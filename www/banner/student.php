<html>
  <head>
    <title> Banner - View Students </title>
	<link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">

  </head>

  <body>
<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/php-bin/libquery.php");

if (!isset($_GET) || !array_key_exists('noBackLink',$_GET) || $_GET['noBackLink']=='false')
    echo "<a href=\"/index.html\">Banner Main</a>";

$query = new DBQuery("SELECT * FROM banner.student");
echo $query->htmlitize();
?>
  </body>
</html>
