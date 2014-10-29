#!/usr/bin/env php
<?php

$con = mysql_connect();
if ($con === false) {
    fwrite(STDERR,"Could not connect to MySQL server\n");
    exit(1);
}

$query1 = "SELECT * FROM test.student;";
$result = mysql_query($query1,$con);
if ($result === false) {
    fwrite(STDERR,"Bad query: $query1\n");
    exit(1);
}

for ($i = 0;$i < 3;++$i)
    var_dump( mysql_fetch_row($result) );

?>
