<?php
	namespace budget;
	function get_date_range()
	{
		$from_date = null; $to_date = null;
		if (array_key_exists("from_date", $_REQUEST))
		{
			//strtotime
			$from_date = $_REQUEST["from_date"];
		}
		if (array_key_exists("to_date", $_REQUEST))
		{
			$to_date = $_REQUEST["to_date"];
		}
		if (array_key_exists("from_year", $_REQUEST) && 
			array_key_exists("from_month", $_REQUEST) &&
			array_key_exists("from_day", $_REQUEST))
		{
			$from_date = $_REQUEST["from_year"].'-'.$_REQUEST["from_month"].'-'.$_REQUEST["from_day"];
		}
		if (array_key_exists("to_year", $_REQUEST) && 
			array_key_exists("to_month", $_REQUEST) &&
			array_key_exists("to_day", $_REQUEST))
		{
			$to_date = $_REQUEST["to_year"].'-'.$_REQUEST["to_month"].'-'.$_REQUEST["to_day"];
		}
		return array($from_date, $to_date);
	}
?>
