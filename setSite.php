<?php
	include ('../includes/preferences.php');
	$table = $_GET['table'];
	$city = $_GET['city'];
	$state = $_GET['state'];
	$cl = $_GET['cl'];
	$category = $_GET['category'];
	$company = $_GET['company'];
	$site = $_GET['site'];

	$con = mysql_connect($server, $dbUsername, $dbPassword);
	if ($table != ''){
		if (!$con){
			die('Could not connect: ' . mysql_error());
		}

		$selectDB = mysql_select_db($db, $con);
		if (!selectDB){
			die('Could not connect to '.$db);
		}
	}
	if ($category == 'All'){
		$siteQuery = mysql_query("SELECT DISTINCT site FROM $table LIMIT 30");
	}
	else{
		$siteQuery = mysql_query("SELECT DISTINCT site FROM $table WHERE category LIKE '%$category%' LIMIT 30");
	}
	$results = '<div id="radio">';
	if($site == 'All'){
		$results.= '<input type="radio" id="All" name="sites" checked="checked"/>';
	}
	else{
		$results.= '<input type="radio" id="All" name="sites"/>';
	}
	$results.= '<label class="siteButton" onClick="getSelectedSite(this)" id="All" for="All">All</label>';
						
						
	while($sites = mysql_fetch_array($siteQuery)){
		if($site == $sites['site']){
			$results .= '<input type="radio" onClick="getSelectedSite(this)" id="'.$sites['site'].'" name="sites" checked="checked"/>';
		}
		else{
			$results .= '<input type="radio" onClick="getSelectedSite(this)" id="'.$sites['site'].'" name="sites" />';
		}
		
		$results .= '<label class="siteButton" for="'.$sites['site'].'">'.$sites['site'].'</label>';
	}
	$results .= '</div>'; 
	mysql_close($con);
	echo $results;
?>

