#!/usr/local/bin/php -q
<?php
	include('includes/functions.php');
	$debug = False;
	$plainText = False;
	
	// Includes preferences and connects to database if debugging.
	include ('/home/baker90/jordan-baker.com/includes/preferences.php');
	$con = mysql_connect($server, $dbUsername, $dbPassword);
	if (!$con){
		die('Could not connect: ' . mysql_error());
	}

	$selectDB = mysql_select_db($db, $con);
	if (!selectDB){
		die('Could not connect to '.$db);
	}
	
	
	if ($debug == False){
	
		$zip = strtolower($_GET['zip']);
		include('findZip.php');
		
		
			
		$query = mysql_query("SELECT * FROM craigslist WHERE city LIKE '%$city%' AND state LIKE '%$state%'");		
		$result = mysql_fetch_array($query);
		if ($result['city'] == ''){
			$cl = 'f';
		}
		else{
			$cl = 't';
		}
		
		$table = '_'.$zip;
		$sql="SELECT * FROM $table";
		$query=@mysql_query($sql);
		$result = @mysql_fetch_array($query);
		if ($result['jobTitle'] == ''){
			// Create a MySQL table
			mysql_query("CREATE TABLE $table(siteId VARCHAR(11), site TEXT, siteUrl TEXT, jobTitle TEXT, jobUrl TEXT, category TEXT, company VARCHAR(140), location TEXT, postDate DATE, scrapeTime DATETIME)") or die(mysql_error());
		}
		else{
			$redirect = 't';
		}
	}
	else{
		echo 'Debugging: ';
		$zip = '98225';
		$city = 'bellingham';
		$state = 'wa';
		$table = '_98225';
		$redirect = 'f';
		
		mysql_query("DROP TABLE $table");
		mysql_query("CREATE TABLE $table(siteId VARCHAR(11), site TEXT, siteUrl TEXT, jobTitle TEXT, jobUrl TEXT, category TEXT, company VARCHAR(140), location TEXT, postDate DATE, scrapeTime DATETIME)") or die(mysql_error());
	}
	if ($redirect != 't'){
		include ('employmentGuide.php');
		include ('snagAJob.php');
		include ('indeed.php');
		include ('craigslist.php');
		include ('careerJet.php');
		include ('yahooHotJobs.php');
		include ('dice.php');
		//include ('careerBuilder.php');
	}
	
	mysql_close($con);
	header('Location: http://jordan-baker.com/jobs/listings.php?table='.$table.'&city='.$city.'&state='.$state.'/');
?>