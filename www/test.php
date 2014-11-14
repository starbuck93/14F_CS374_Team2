<html>
<body>
<?php
	//echo("about to require");
	require_once("SimpleHandler.php");
	//echo("past require");
	$getCourses = new SimpleHandler();
	$getCourses::init();
	$inTime=$_GET['time'];
	$getCourses->set_time($inTime);
	$getCourses->handleQuery();
	//echo("time is ".$inTime."\n");
	//echo("made it through");

?>
</body>
</html>