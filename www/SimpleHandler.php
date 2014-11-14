<?php
	//echo("about to require parent");
	require_once("handlerParent.php");
	//echo("required parent");
	class SimpleHandler extends handlerParent{
		private $time;
		private $answer;

		public function set_time($inTime){
			$this->time=$inTime;
		}
		public function handleQuery(){
			$q= "SELECT * FROM course as c
			INNER JOIN section as sec
			ON c.crn=sec.course_id
			INNER JOIN student_section as ss
			ON ss.section_id=sec.crn
			INNER JOIN student as stu
			ON stu.id=ss.student_id
			WHERE sec.time='{$this->time}';";

			parent::$Qobj->set_query($q);
			parent::$Qobj->executeQuery();
			$this->answer=parent::$Qobj->get_result();
			echo("<ul>");
			foreach($this->answer as $row){
				echo("<li>".$row['fname']." is attending ".$row['name']." at that time</li>");
			}
			echo("</ul>");
		}
	}
