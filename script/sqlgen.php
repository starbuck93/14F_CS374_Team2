#!/usr/bin/env php
<?php

function get_row() {
    global $csvfile;
    $row = fgetcsv($csvfile,5000);
    if ($row === null) {
        fwrite(STDERR,"fail fgetcsv()\n");
        exit(1);
    }
    return $row;
}

function extract_field(array $row,$fld) {
    global $fields;
    $index = array_search($fld,$fields);
    if ($index === false) {
        fwrite(STDERR,"fail extract_field::array_search($fld)\n");
        exit(1);
    }
    return $row[$index];
}

function add_field(&$entity,$member,array $row,$fld) {
    if (is_array($fld)) {
        $entity->$member = '';
        foreach ($fld as $f)
            $entity->$member .= extract_field($row,$f);
    }
    else
        $entity->$member = extract_field($row,$fld);
}

function generate_table($name,array $fields,array $types,$primary_key) {
    assert(count($fields) == count($types));
    assert(!is_array($primary_key) || count($primary_key)>=1);
    $sql = "DROP TABLE IF EXISTS $name;\n";
    $sql .= "CREATE TABLE $name(";
    for ($i = 0;$i < count($fields);++$i)
        $sql .= "{$fields[$i]} {$types[$i]}, ";
    $sql .= "PRIMARY KEY(";
    if ( is_array($primary_key) )
        $sql .= implode(", ",$primary_key);
    else
        $sql .= $primary_key;
    $sql .= "));\n";
    fwrite(STDOUT,$sql);
}

function generate_content($name,array $table,array $types,$primaryKey,$addKey = true) {
    $haveHeader = false;
    $sql = "";
    $results = array();
    foreach ($table as $key => $entity) {
        $data = $addKey ? array('id' => $key) : array();
        $data = array_merge($data,get_object_vars($entity));
        if (!$haveHeader) {
            generate_table($name,array_keys($data),$types,$primaryKey);
            $sql = "INSERT INTO $name (" . implode(", ",array_keys($data)) . ") VALUES\n";
            $haveHeader = true;
        }
        $data = array_values($data);
        assert(count($data) == count($types) && count($data)>=1);
        $r = "";
        if ($types[0] != 'INT')
            $r .= "\"{$data[0]}\"";
        else
            $r .= $data[0];
        for ($i = 1;$i < count($data);++$i) {
            $r .= ", ";
            if ($types[$i] != 'INT')
                $r .= "\"{$data[$i]}\"";
            else
                $r .= $data[$i];
        }
        $results[] = "($r)";
    }
    $sql .= implode(",\n",$results) . ";\n";
    fwrite(STDOUT,$sql);
}

if ($argc < 2) {
    fwrite(STDERR,"usage: {$argv[0]} CSV-file\n");
    exit(1);
}

// open the CSV file
$csvfile = @fopen($argv[1],'r');
if ($csvfile === false) {
    fwrite(STDERR,"failed to open {$argv[1]} for reading\n");
    exit(1);
}

// create arrays for each entity
$student_table = array();
$professor_table = array(); $professor_table[0] = null;
$course_table = array(); $course_table[0] = null;
$section_table = array(); $section_table[0] = null;
$building_table = array(); $building_table[0] = null;
$room_table = array(); $room_table[0] = null;
$student_section_table = array(); // key: "student_id:section_id"

// create arrays of SQL type information for each entity
$student_types = array('INT','VARCHAR(30)','VARCHAR(30)','VARCHAR(30)','VARCHAR(2)');
$professor_types = array('INT','VARCHAR(30)','VARCHAR(30)');
$course_types = array('INT','VARCHAR(10)','VARCHAR(10)','VARCHAR(120)','INT','VARCHAR(10)');
$section_types = array('INT','INT','INT','INT','INT','INT','INT','VARCHAR(10)','INT');
$building_types = array('INT','VARCHAR(10)','VARCHAR(120)');
$room_types = array('INT','VARCHAR(25)','INT');
$student_section_types = array('INT','INT');

// get the first from the CSV file; this contains the column names
$fields = get_row();

while (($row = get_row()) !== false) {
    // student
    $student = new stdClass;
    $student_key = extract_field($row,'Banner ID');
    add_field($student,'first_name',$row,'First Name');
    add_field($student,'middle_name',$row,'Middle Name');
    add_field($student,'last_name',$row,'Last Name');
    add_field($student,'classification',$row,'Class Code');
    if ( !array_key_exists($student_key,$student_table) )
        $student_table[$student_key] = $student;

    // professor
    $professor = new stdClass;
    if (preg_match("/([[:alpha:]]+), ([[:alpha:] ]+)$/",$thing = extract_field($row,'Instructor Name'),$matches)!==1 || count($matches)!=3) {
        static $cnt = 1;
        $professor->first_name = "Unknown$cnt";
        $professor->last_name = "Unknown$cnt";
        ++$cnt;
    }
    else {
        $professor->first_name = $matches[2];
        $professor->last_name = $matches[1];
    }
    $professor_key = array_search($professor,$professor_table);
    if ($professor_key === false) {
        $professor_key = count($professor_table);
        $professor_table[] = $professor;
    }

    // course
    $course = new stdClass;
    add_field($course,'subject_code',$row,'Subject Code');
    add_field($course,'number',$row,'Course Number');
    add_field($course,'title',$row,'Course Title');
    add_field($course,'credit_hours',$row,'Credit Hours');
    add_field($course,'type',$row,'Schd Code1');
    $course_key = array_search($course,$course_table);
    if ($course_key === false) {
        $course_key = count($course_table);
        $course_table[] = $course;
    }

    // building
    $building = new stdClass;
    add_field($building,'code',$row,'Bldg Code1');
    add_field($building,'description',$row,'Bldg Desc1');
    $building_key = array_search($building,$building_table);
    if ($building_key === false) {
        $building_key = count($building_table);
        $building_table[] = $building;
    }

    // room
    $room = new stdClass;
    add_field($room,'code',$row,'Room Code1');
    $room->building_id = $building_key;
    $room_key = array_search($room,$room_table);
    if ($room_key === false) {
        $room_key = count($room_table);
        $room_table[] = $room;
    }

    // section
    $section = new stdClass;
    add_field($section,'crn',$row,'CRN');
    add_field($section,'term_code',$row,'Term Code');
    $section->course_id = $course_key;
    $section->professor_id = $professor_key;
    add_field($section,'begin_time',$row,'Begin Time 1');
    add_field($section,'end_time',$row,'End Time1');
    add_field($section,'dow',$row,array('Monday Ind1','Tuesday Ind1','Wednesday Ind1','Thursday Ind1','Friday Ind1','Saturday Ind1','Sunday Ind1'));
    $section->room_id = $room_key;
    $section_key = array_search($section,$section_table);
    if ($section_key === false) {
        $section_key = count($section_table);
        $section_table[] = $section;
    }

    // student_section
    $student_section = new stdClass;
    $student_section->student_id = $student_key;
    $student_section->section_id = $section_key;
    if ( !in_array($student_section,$student_section_table) )
        $student_section_table[] = $student_section;
}

fclose($csvfile);

unset($professor_table[0]);
unset($course_table[0]);
unset($section_table[0]);
unset($building_table[0]);
unset($room_table[0]);

// generate SQL and write it to stdout
generate_content('student',$student_table,$student_types,'id');
generate_content('professor',$professor_table,$professor_types,'id');
generate_content('course',$course_table,$course_types,'id');
generate_content('section',$section_table,$section_types,'id');
generate_content('building',$building_table,$building_types,'id');
generate_content('room',$room_table,$room_types,'id');
generate_content('student_section',$student_section_table,$student_section_types,array('student_id','section_id'),false);

?>
