<html>

    <head>
        <title> Student Schedule Results </title>
    </head>

    <body>
        <?php
            include_once("{$_SERVER['DOCUMENT_ROOT']}/php-bin/libquery.php");
            echo "<a href=\"/index.html\"> Banner Main </a>";
            if ( !array_key_exists('bannerid',$_GET) ) {
                echo "<p><strong>Bad request</strong></p>\n";
            }
            else {
                $bannerid = $_GET['bannerid'];
                if ( !is_numeric($bannerid) ) {
                    echo "<p>$bannerid is not a valid Banner ID</p>";
                    exit(0);
                }

                $student = new DBQuery("SELECT lname, fname FROM test.student WHERE test.student.id = $bannerid;");
                if ($student->get_row_cnt() == 0) {
                    echo "<p>No results for Banner ID=$bannerid</p>";
                    exit(0);
                }
                $row = $student->get_next_row();

                echo "<h1>Schedule listing for {$row[0]}, {$row[1]} [$bannerid]</h1>";

                $schedule = new DBQuery("SELECT department, course_number, name FROM test.student_section INNER JOIN test.section ON
test.section.crn = test.student_section.section_id INNER JOIN test.course ON
test.section.course_id = test.course.id INNER JOIN test.student ON
test.student_section.student_id = test.student.id WHERE test.student_section.student_id = $bannerid;");

                echo $schedule->htmlitize();
            }
        ?>
    </body>

</html>
