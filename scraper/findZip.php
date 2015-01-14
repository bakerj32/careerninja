<?php
	include ('../../includes/preferences.php');
	$con = mysql_connect($server, $dbUsername, $dbPassword);
	if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}

	$selectDB = mysql_select_db($db, $con);
	if (!selectDB)
		{
			die('Could not connect to '.$db);
	}
	
	$query = mysql_query("SELECT * FROM zips WHERE zip = '$zip'");
	$results = mysql_fetch_array($query);
	$city = strtolower($results['city']);
	$state =  strtolower($results['state']);
?>