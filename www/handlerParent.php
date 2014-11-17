<?php
	//echo("about to require Q");
	require_once("DBQuery.php");
	//echo("required Q");
	class HandlerParent{

		protected static $Qobj;
		
		static function init(){
			self::$Qobj=new DBQuery();
		}

		//public abstract function handleQuery();
	}
