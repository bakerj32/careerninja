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
	if ($site == 'All'){
		$companyQuery = mysql_query("SELECT DISTINCT company FROM $table LIMIT 30");
	}
	else{
		$companyQuery = mysql_query("SELECT DISTINCT company FROM $table WHERE site LIKE '%$site%' LIMIT 30");
	}
	$results = '<ol id="selCompanies">';
	if ($company == 'All'){
		$results.= '<li id="All" class="ui-selected ui-widget-content" name="companies">All</li>';
	}
	else{
		$results.= '<li id="All" class="ui-widget-content" name="companies">All</li>';
	}
	
	while($companies = mysql_fetch_array($companyQuery)){
		if ($companies['company'] != ''){
			if($company == $companies['company']){
				$results .= '<li id="'.$companies['company'].'" class="ui-selected ui-widget-content" name="companies">'.$companies['company'].'</li>';
			}
			else{
				$results .= '<li id="'.$companies['company'].'" class="ui-widget-content" name="companies">'.$companies['company'].'</li>';
			}
		}
	}
	$results .= '</ol>'; 
	mysql_close($con);
	echo $results;
?>
