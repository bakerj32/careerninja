<?php
	$zip = $_GET['zip'];
	
	function isValidZip($zip){
	  if(preg_match("/^([0-9]{5})(-[0-9]{4})?$/i",$zip))
		return true;
	  else
		return false;
	}
	if (strlen($zip) == 5){
	
		$pattern = '/[0-9]*/';
		
		if(isValidZip($zip)){
			
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
			
			$query = mysql_query("SELECT * FROM zips WHERE zip = '$zip'");
			$results = mysql_fetch_array($query);
			$city = strtolower($results['city']);
			$state =  strtolower($results['state']);

			
			if ($city == ''){
				echo '<p class="red" style="font-size: 10pt;">The zip you entered is not working</p>';
			}
			else{
				$cityState = ucwords($city).', '.strtoupper($state);
				echo '<p class="green">Ah, beautiful '.$cityState.'.</p>';
			}
			
		}
		else{
			echo '<p class="red">That is not a zip code</p>';
		}
	}
	
?>