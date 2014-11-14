<?php

	require_once(handlerParent.php);
	class SimpleHandler extends handlerParent{
		private $time;
		private $answer;

		public function set_time($inTime){
			$this->time=$inTime;
		}
		public function handleQuery(){
			$q= "SELECT c.name,stu.fname FROM course as c
			INNER JOIN section as sec
			ON c.id=sec.course_id
			INNER JOIN student_section as ss
			ON ss.section_id=sec.crn
			INNER JOIN student as stu
			ON stu.id=ss.student_id
			WHERE sec.time=".$this->inTime.";";
			parent::$Qobj->set_query($q);
			parent::$Qobj->executeQuery();
			$this->answer=parent::$Qobj->get_result();
			echo("testing <ul>");
			foreach($this->answer as $row){
				echo("<li> student ".$row['stu.fname']." is attending ".$row['c.name']."at that time</li>");
			}
			echo("</ul>");
		}
	}

?>