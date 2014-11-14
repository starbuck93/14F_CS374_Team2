<?php

	require_once(DBQuery.php);
	class HandlerParent{

		private static $Qobj;

		function __construct(){
			self::Qobj=new DBQuery();
		}
		
		public virtual function handleQuery();
	}

?>