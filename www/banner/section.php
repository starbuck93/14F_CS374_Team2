<html>

  <head>
    <title> View student </title>
  </head>

  <body>
    <a href="/index.html">Banner Main</a>

    <p>
        <?php
	        include_once("{$_SERVER['DOCUMENT_ROOT']}/php-bin/libquery.php");
	        $query = new DBQuery("SELECT * FROM test.section");
	        echo $query->htmlitize();
        ?>
    </p>
  </body>
</html>
