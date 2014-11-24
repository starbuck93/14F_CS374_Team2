<html>
  <head>
    <title> Banner - Conflicts Results </title>
  </head>

  <body>
    <a href="/index.html">Banner Main</a>

<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/php-bin/libhandler.php");
// make sure needed variables where sent in the URL; use the post method
if (!isset($_POST) || !array_key_exists('CRN',$_POST) || !array_key_exists('beginTime',$_POST) || !array_key_exists('endTime',$_POST)) {
    echo "<p> Bad request </p>";
    exit(0);
}

// create parameter list for conflict handler
$params = array('CRN' => $_POST['CRN'], 'BEGIN' => $_POST['beginTime'], 'END' => $_POST['endTime']);

// create DOW parameter for parameter list
$dow = '';
foreach (array('M','T','W','R','F') as $key)
    if ( array_key_exists($key,$_POST) )
        $dow .= $key;
$params['DOW'] = $dow;

// attempt to create the handler
try {
    $handler = new SimpleConflictHandler($params);
} catch (SectionNotFoundException $ex) {
    echo "<p> Course section with CRN={$_POST['CRN']} was not found. </p>";
    exit(0);
} catch (BadTimeFormatException $ex) {
    echo "<p> Syntax Error: " . $ex->getMessage() . " </p>";
    exit(0);
} catch (BadTimeSemanticException $ex) {
    echo "<p> Incorrect Time: " . $ex->getMessage() . " </p>";
    exit(0);
}

// populate the page with the results
echo $handler->htmlitize();
?>

  </body>
</html>
