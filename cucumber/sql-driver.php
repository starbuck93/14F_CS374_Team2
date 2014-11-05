#!/usr/bin/env php
<?php

# sqltest.php - driver program to test mySQL queries
#  This program reads queries on its stdin, an SQL query
# which is sent to the database. The program returns
# the results of the query line by line where each line
# contains a comma-separated list of column values. An 
# arbitrary amount of whitespace may exist between the
# comma and the next value.

$newlines = array("\n","\r");
$con = mysql_connect();
if ($con === false) {
    fwrite(STDERR,"Could not connect to MySQL server\n");
    exit(1);
}

while (true) {
    $query = fgets(STDIN);
    if ($query === false)
        break;
    $query = str_replace($newlines,"",$query);

    $result = mysql_query($query,$con);
    if ($result === false) {
        fwrite(STDERR,"Bad query: $query1\n");
        continue;
    }

    // print out each row as a comma-separated string
    while (true) {
        $row = mysql_fetch_row($result);
        if ($row === false)
            break;
        $itemcnt = count($row);
        if ($itemcnt > 0) {
            $rowstr = $row[0];
            for ($j = 1;$j < $itemcnt;++$j) {
                $value = $row[$j];
                $rowstr .= ", $value";
            }
        }
        echo "$rowstr\n";
    }

}

?>
