<html>
<body>
<?php
	
	//require_once(SimpleHandler.php);
	echo("getting somewhere");
	$getCourses = new SimpleHandler();
	$inTime=$_REQUEST['time'];
	$getCourses->setTime($inTime);
	$getCourses->handleQuery();

?>
</body>
</html>