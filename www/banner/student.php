<html>
  <head>
    <title> Banner - View Students </title>
  </head>

  <body>
    <a href="/index.html">Banner Main</a>

    <p>

<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/php-bin/libquery.php");
$query = new DBQuery("SELECT * FROM banner.student");
echo $query->htmlitize();
?>

    </p>
  </body>
</html>
