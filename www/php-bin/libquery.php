<?php
/* libquery.php - wrap MySQL query functionality
   in PHP class library */

class DBQueryException extends Exception {
    function __construct($message) {
        parent::__construct($message);
    }
}

class DBQuery {
    static private $conn;

    function __construct($query) {
        if ( is_null(self::$conn) ) {
            self::$conn = mysql_connect();
            if (self::$conn === false)
                throw new Exception("Couldn't connect to database");
        }

        $this->result = mysql_query($query,self::$conn);
        if ($this->result === false)
            throw new DBQueryException("Bad query: $query");
        $this->fieldCnt = mysql_num_fields($this->result);
        $this->rowCnt = mysql_num_rows($this->result);
        $this->rowIter = 0; // point to latest row in result
    }

    function get_next_row() {
        $this->currow = mysql_fetch_row($this->result);
        if ($this->currow !== false)
            ++$this->rowIter;
        return $this->currow;
    }

    function get_current_row() {
        return $this->currow;
    }

    function htmlitize($showFields = true) {
        $content = "";
        if ($showFields) {
            $fields = "";
            for ($i = 0;$i < $this->fieldCnt;++$i)
                $fields .= "<td><b>" . mysql_fetch_field($this->result,$i)->name . "</b></td>";
            $content .= "<tr>$fields</tr>";
        }
        mysql_data_seek($this->result,0);
        while (true) {
            $rowData = mysql_fetch_row($this->result);
            if ($rowData === false)
                break;
            $row = "";
            foreach ($rowData as $value)
                $row .= "<td>$value</td>";
            $content .= "<tr>$row</tr>";
        }
        // restore previous iterator position
        mysql_data_seek($this->result,$this->rowIter);
        return "<table border=\"1\" style=\"width:100%\">$content</table>";
    }
}
?>
