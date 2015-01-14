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
		$categoryQuery = mysql_query("SELECT DISTINCT category FROM $table LIMIT 30");
	}
	else{
		$categoryQuery = mysql_query("SELECT DISTINCT category FROM $table WHERE site LIKE '%$site%' LIMIT 30");
	}
	$results = '<ol id="selCategories">';
	if ($category == 'All'){
		$results .= '<li id="All" class="ui-selected ui-widget-content" name="categories">All</li>';
	}
	else{
		$results .= '<li id="All" class="ui-widget-content" name="categories">All</li>';
	}
	while($categories = mysql_fetch_array($categoryQuery)){
		if($category == $categories['category']){
			$results .= '<li id="'.$categories['category'].'" class="ui-selected ui-widget-content" name="categories">'.$categories['category'].'</li>';
		}
		else{
			$results .= '<li id="'.$categories['category'].'" class="ui-widget-content" name="categories">'.$categories['category'].'</li>';
		}
	}
	$results .= '</ol>'; 
	mysql_close($con);
	echo $results;
?>
