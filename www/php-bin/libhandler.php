<?php

include_once('libquery.php');

class HandlerException extends Exception {
    function __construct($message) {
        parent::__construct($message);
    }
}
class SectionNotFoundException extends HandlerException { // bad CRN input to library function
    function __construct() {
        parent::__construct("specified section was not found");
    }
}
class BadTimeFormatException extends HandlerException { // time string contained syntax error
    function __construct($message) {
        parent::__construct($message);
    }
}
class BadTimeSemanticException extends HandlerException { // time was correctly formatted, but not semantically correct
    function __construct($message) {
        parent::__construct($message);
    }
}

class SectionChangeDescription {
    static private $term_id = '';

    // since a CRN is reused between terms, the user can set the term
    // code ahead of time so that the system can find the correct section
    static function select_term($term) {
        self::$term_id = $term;
    }

    function __construct($crn,$begin_change,$end_change,$day_change = '') {
        // precondition check on begin and end times
        if (intval($begin_change) >= intval($end_change))
            throw new BadTimeSemanticException("begin time must be earlier than end time");

        // this is the change description for the section (potentially)
        $this->desc = array($begin_change,$end_change,$day_change);

        // look up the section by CRN; use the selected term code
        $use_term = self::$term_id;
        $opt = self::$term_id != '' ? "AND term_code = $use_term" : "";
        $q = new DBQuery("SELECT id, begin_time, end_time, dow FROM banner.section WHERE crn = $crn $opt;");
        if ( $q->is_empty() )
            throw new SectionNotFoundException;
        if ($q->get_row_cnt() > 1) // this should not occur given preconditions of the database
            throw new HandlerException("more than one section found given input CRN");

        // remember important attributes about the section
        $row = $q->get_next_row(); // the query should have only retrieved one query
        $this->sid = $row[0];
        $this->curdesc = array($row[1],$row[2],$row[3]);

        // if no dow was supplied in the section change description, then use the current dow for the course
        if ($day_change == '')
            $this->desc[2] = $this->curdesc[2];
    }

    function commit_change_description() {
        // update section with the change description supplied earlier

    }

    function generate_sql_where_time_overlap($fieldBegin,$fieldEnd) {
        /* there are 4 cases to consider:
            - 3 involve overlaps where the new begin/end time is within the
           current time interval for the section
            - the last involves an overlap where the new begin and end times
           overlap the entire current time interval for the section */
        $beg = $this->desc[0];
        $end = $this->desc[1];
        return "(($beg >= $fieldBegin AND $beg <= $fieldEnd) OR ($end >= $fieldBegin AND $end <= $fieldEnd)
OR ($beg < $fieldBegin AND $end > $fieldEnd))";
    }

    function generate_sql_where_dow_overlap($fieldDOW) {
        // generate a string that can be matched in SQL using wildcard characters; note
        // that this insists on a correct ordering for the day characters in the string
        $wildDOW = implode('|',array_map(function ($c) { return "$c+"; },str_split($this->desc[2])));
        return "$fieldDOW REGEXP \"$wildDOW\"";
    }

    function get_section_id() {
        return $this->sid;
    }

    // gets an array of section ids corresponding to the next student
    function get_next_student_schedule(&$student_id) {
        if ( !isset($this->students) ) {
            $q = new DBQuery("SELECT student_id FROM banner.student_section WHERE section_id = {$this->sid};");
            $this->students = array();
            while (($row = $q->get_next_row()) !== false)
                $this->students[] = $row[0];
        }
        $student_id = current($this->students);
        if ($student_id !== false) {
            next($this->students);
            $q = new DBQuery("SELECT section_id FROM banner.student_section WHERE student_id = $student_id;");
            $results = array();
            while (($row = $q->get_next_row()) !== false)
                if ($row[0] != $this->sid)
                    $results[] = $row[0];
            return $results;
        }
        return false;
    }
}

abstract class ConflictHandler {
    /* '$input' is an array that must contain the following key-value string pairs:
         'CRN' => section crn field
         'BEGIN' => begin-change-time
         'END' => end-change-time
         'DOW' => dow-change [optional] */
    function __construct(array $input) {
        if (!array_key_exists('CRN',$input) || !array_key_exists('BEGIN',$input) || !array_key_exists('END',$input))
            throw new HandlerException("ConflictHandler::__construct: bad parameter to function");

        // given normal time strings (e.g. 1:00 PM), create military time; verify if given military time
        foreach (array('BEGIN','END') as $key) {
            if ( !is_numeric($input[$key]) ) {
                if (preg_match("/([0-9]+):([0-9]+) *((?:(?:P|p)|(?:A|a))(?:M|m))/",$input[$key],$matches) === false)
                    throw new HandlerException("ConflictHandler::__construct: fail preg_match()");
                if (count($matches) != 4)
                    throw new BadTimeFormatException("time string {$input[$key]} was not formatted correctly");
                $n = strtolower($matches[3])=='am' ? 0 : 1200;
                $n += 100 * intval($matches[1]) % 2400;
                $n += intval($matches[2]);
                $input[$key] = "$n";
            }
            else { // is military time
                // make sure that time string is within valid range for military time
                $n = intval($input[$key]);
                if ($n<0 || $n>2400)
                    throw new BadTimeFormatException("time value $n was out of range");
            }
        }

        // create the section change description and call the find conflicts function
        $this->desc = new SectionChangeDescription($input['CRN'],$input['BEGIN'],$input['END'],array_key_exists('DOW',$input) ? $input['DOW'] : '');
        $this->find_conflicts_impl($input);
    }

    function commit_changes() {
        $this->desc->commit_change_description();
    }

    /* if you're too lazy to want to generate the html, just
       call this boy to do all your work; I can't guarantee that
       it will look pretty and all */
    function htmlitize() {
        return $this->htmlitize_impl();
    }

    function grab_all_rows() {
        return $this->grab_all_rows_impl();
    }

    // to be implemented by derived handlers
    abstract protected function find_conflicts_impl();
    abstract protected function htmlitize_impl();
    abstract protected function grab_all_rows_impl();
}

/* SimpleConflictHandler: a simple conflict handler explores the schedules of students in a given
   section to find conflicts in changing the sections time and/or day. */
class SimpleConflictHandler extends ConflictHandler {
    /* '$input' must meet the same requirements as the parent handler */
    function __construct(array $input) {
        parent::__construct($input);
    }

    final protected function find_conflicts_impl() {
        $section_id = $this->desc->get_section_id();

        // grab all the students in the section
        $q = new DBQuery("SELECT id FROM banner.student_section INNER JOIN banner.student ON id = student_id WHERE section_id = $section_id;");
        $students = array();
        while (($row = $q->get_next_row()) !== false)
            $students[] = $row[0];

        // grab all simple conflicts for the section change description
        $this->q = new DBQuery("SELECT student.id, student.first_name, student.last_name, section.crn, course.subject_code, course.number, course.title, section.begin_time, section.end_time, section.dow
FROM banner.student_section
INNER JOIN banner.section ON banner.student_section.section_id = section.id
AND banner.student_section.section_id <> $section_id
AND " . $this->desc->generate_sql_where_time_overlap("banner.section.begin_time","banner.section.end_time") . "
AND " . $this->desc->generate_sql_where_dow_overlap("banner.section.dow") . "
INNER JOIN banner.student ON banner.student_section.student_id = student.id
INNER JOIN banner.course ON banner.course.id = banner.section.course_id
WHERE banner.student.id = " . implode(" OR banner.student.id = ",$students) . ";");
    }

    final protected function htmlitize_impl() {
        if (isset($this->q) && get_class($this->q)=='DBQuery')
            return $this->q->htmlitize();
        throw new HandlerException("bad precondition: SimpleConflictHandler::htmlitize_impl()");
    }

    final protected function grab_all_rows_impl() {
        if (isset($this->q) && get_class($this->q)=='DBQuery') {
            $rows = array();
            while (($r = $this->q->get_next_row()) !== false)
                $rows[] = $r;
            return $rows;
        }
        throw new HandlerException("bad precondition: SimpleConflictHandler::grab_all_rows_impl()");
    }
}

?>
