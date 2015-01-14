<?php
	
	include ('../includes/preferences.php');
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
	$file_handle = fopen("zips.txt", "rb");

	while (!feof($file_handle) ) {

	$line_of_text = fgets($file_handle);
	$parts = explode(',', $line_of_text);
	$parts[1] = str_replace('"', '', $parts[1]);
	$parts[2] = str_replace('"', '', $parts[2]);
	$parts[3] = str_replace('"', '', $parts[3]);
	$sql = "INSERT INTO zips (zip, city, state)
VALUES ('$parts[1]', '$parts[3]', '$parts[2]')";
	if (!mysql_query($sql,$con))
		{
			die('Error: ' . mysql_error());
		}
}

	
	
	fclose($file_handle);
	mysql_close($con);

?>