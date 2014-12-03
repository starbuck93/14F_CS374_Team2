<html>

  <head>
    <title> Banner - View Sections </title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
  </head>

  <body><center>
    <p>

<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/php-bin/libquery.php");

if (!isset($_GET) || !array_key_exists('noBackLink',$_GET) || $_GET['noBackLink']=='false')
    echo "<a style= \"margin-top:10px;margin-left:10px;margin-bottom:10px;\" class=\"pure-button pure-button-primary\" href=\"/index.html\">Banner Main</a>";

$query = new DBQuery("SELECT crn, subject_code, number, title, first_name, last_name, begin_time, end_time, dow, building.code, room.code FROM banner.section
INNER JOIN banner.course ON course.id = course_id
INNER JOIN banner.professor ON professor.id = professor_id
INNER JOIN banner.room ON room.id = room_id
INNER JOIN banner.building ON building.id = building_id;");
echo $query->htmlitize();
?>

    </p>
  </center></body>
</html>
