<html>

  <head>

  </head>
  <body>

<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/php-bin/libquery.php");

if (!array_key_exists('ct1',$_GET) || !array_key_exists('ct2',$_GET) || !array_key_exists('ct3',$_GET)
    || !array_key_exists('c1',$_GET) || !array_key_exists('c2',$_GET) || !array_key_exists('c3',$_GET)) {
    echo "<p><strong>Bad request</strong></p>\n";
    exit(1);
}

$titles = array();
$numbers = array();

for ($i = 1;$i <= 3;++$i) {
    $titles[] = $_GET["ct$i"];
    $numbers[] = $_GET["c$i"];
}

$cids = array();
for ($i = 0;$i < 3;++$i) {
    if ($titles[$i]=='' || $numbers[$i]=='')
        continue;
    $q = new DBQuery("SELECT id FROM banner.course WHERE banner.course.subject_code = \"{$titles[$i]}\" AND banner.course.number = {$numbers[$i]};");
    if ($q->get_row_cnt() == 0) {
        echo "<p> No results found for course {$titles[$i]} {$numbers[$i]} </p>";
        exit(1);
    }
    while (true) {
        $row = $q->get_next_row();
        if ($row === false)
            break;
        $cids[] = $row[0];
    }
}

$sects = array();
foreach ($cids as $id) {
    $q = new DBQuery("SELECT id FROM banner.section WHERE banner.section.course_id = $id;");
    if ($q->get_row_cnt() == 0) {
        echo "<p> No sections found for course with id=$id </p>";
        exit(1);
    }
    while (true) {
        $row = $q->get_next_row();
        if ($row === false)
            break;
        $sects[] = $row[0];
    }
}

$results = array();
foreach ($sects as $id) {
    $q = new DBQuery("SELECT student_id FROM banner.student_section WHERE banner.student_section.section_id = $id;");
    while (true) {
        $row = $q->get_next_row();
        if ($row === false)
            break;
        if (!array_key_exists($row[0],$results))
            $results[$row[0]] = 1;
        else
            ++$results[$row[0]];
    }
}

foreach (array_keys($results) as $k)
    if ($results[$k] != count($cids))
        unset($results[$k]);

$clause = "WHERE banner.student.id = ";
$clause .= implode(" OR banner.student.id = ",array_keys($results));
$q = new DBQuery("SELECT * FROM banner.student $clause;");
echo $q->htmlitize();
?>
    </body>
</html>
