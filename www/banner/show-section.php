<html>

  <head>
    <title> Banner - View Section </title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
  </head>

  <body>

<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/php-bin/libquery.php");

if (!isset($_GET) || !array_key_exists('noBackLink',$_GET) || $_GET['noBackLink']=='false')
    echo "<a href=\"/index.html\">Banner Main</a>";

if (!isset($_GET) || !array_key_exists('crn',$_GET)) {
    echo "<p><strong>Bad request</strong></p>\n";
    exit(0);
}

$crn = $_GET['crn'];
if ( !is_numeric($crn) ) {
    echo "<p>$crn is not a valid CRN value</p>";
    exit(0);
}

// get the course title information
$q1 = new DBQuery("SELECT subject_code, number, title, begin_time, end_time, dow, first_name, last_name FROM banner.course
INNER JOIN banner.section ON section.course_id = course.id AND crn=$crn
INNER JOIN banner.professor ON professor.id = professor_id;");
if ($q1->is_empty()) {
    echo "<p>No results for CRN=$crn</p>";
    exit(0);
}
$heading = $q1->get_next_row();

$q2 = new DBQuery("SELECT student.id, first_name, middle_name, last_name, classification FROM banner.section
INNER JOIN banner.student_section ON crn=$crn AND section.id = section_id
INNER JOIN banner.student ON student_id = student.id
ORDER BY student.classification, last_name;");
if ($q2->is_empty()) { // section shouldn't be empty
    echo "<p>No students where associated with the specified section</p>";
    exit(0);
}

echo "<h1>Section listing for {$heading[0]} {$heading[1]} {$heading[2]} [CRN=$crn]</h1>"
    . "<h2>Start Time: {$heading[3]}<br />End Time: {$heading[4]}<br />Meeting Days: {$heading[5]}<br />Professor: {$heading[6]} {$heading[7]}</h2>"
    . $q2->htmlitize();
?>

  </body>
</html>
