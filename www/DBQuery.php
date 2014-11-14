<?php

	class DBQuery{
		private $query;
		private $result;

		function __construct(){
			$this->result=array();
		}

		function set_query($inQ){
			$this->query=$inQ;
		}

		public function executeQuery(){
			$servername = "localhost";
			$username = "username";
			$password = "password";
			$dbName = "test";

			// Create connection. I chose the "procedural approach because other approaches were not back-compatible with old php versions
			$conn = mysqli_connect($servername, $username, $password, $dbName);

			// Check connection
			if (!$conn) {
			    die("Connection failed: " . mysqli_connect_error());
			}
			
			$tempResult=mysqli_query($conn, $sql));
			$i=0;
			while($row = mysqli_fetch_assoc($tempResult)) {		
				$this->result[i]=$row;
				i++;
			}
		
			msqli_close($conn);

		}
		public function get_result(){
			return $this->result;
		}
	}

?>