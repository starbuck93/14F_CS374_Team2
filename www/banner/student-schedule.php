<html>

  <head>
    <title> Banner - View Student Schedule </title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
  </head>

  <body>

<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/php-bin/libquery.php");
if (!isset($_GET) || !array_key_exists('noBackLink',$_GET) || $_GET['noBackLink']=='false')
    echo "<a style= \"margin-top:10px;margin-left:10px;\" class=\"pure-button pure-button-primary\" href=\"/index.html\">Banner Main</a></div>";
if (!isset($_GET) || !array_key_exists('bannerid',$_GET)) {
    echo "<p><strong>Bad request</strong></p>\n";
}
else {
    $bannerid = $_GET['bannerid'];
    if ( !is_numeric($bannerid) ) {
        echo "<p>$bannerid is not a valid Banner ID</p>";
        exit(0);
    }

    $student = new DBQuery("SELECT last_name, first_name FROM banner.student WHERE banner.student.id = $bannerid;");
    if ($student->get_row_cnt() == 0) {
        echo "<p>No results for Banner ID=$bannerid</p>";
        exit(0);
    }
    $row = $student->get_next_row();

    echo "<h1>Schedule listing for {$row[0]}, {$row[1]} [$bannerid]</h1>";

    $schedule = new DBQuery("SELECT crn, subject_code, number, title, begin_time, end_time, dow FROM banner.student_section INNER JOIN
banner.section ON banner.section.id = banner.student_section.section_id INNER JOIN banner.course ON
banner.section.course_id = banner.course.id INNER JOIN banner.student ON
banner.student_section.student_id = banner.student.id
WHERE banner.student_section.student_id = $bannerid
ORDER BY course.title;");

    echo $schedule->htmlitize();
}
?>

  </body>
</html>
