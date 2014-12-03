<html>

  <head>
    <title> Banner - View Courses </title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
  </head>

  <body><center>
    <p>
<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/php-bin/libquery.php");

if (!isset($_GET) || !array_key_exists('noBackLink',$_GET) || $_GET['noBackLink']=='false')
    echo "<a style= \"margin-top:10px;margin-left:10px;margin-bottom:10px;\" class=\"pure-button pure-button-primary\" href=\"/index.html\">Banner Main</a>";

$query = new DBQuery("SELECT * FROM banner.course");
echo $query->htmlitize();
?>
    </p>
  </center></body>
</html>
