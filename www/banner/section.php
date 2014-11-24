<html>

  <head>
    <title> Banner - View Students </title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
  </head>

  <body>
    <a href="/index.html">Banner Main</a>

    <p>

<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/php-bin/libquery.php");
$query = new DBQuery("SELECT * FROM banner.section");
echo $query->htmlitize();
?>

    </p>
  </body>
</html>
