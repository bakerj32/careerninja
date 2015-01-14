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
		
	mysql_query("TRUNCATE TABLE craigslist");
	$url = 'http://www.craigslist.org/about/sites';
	$ch = curl_init();
	$timeout = 5; // set to zero for no timeout
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$markup = curl_exec($ch);
	
	
	$pattern = '/a href=.*us\/.*?\>/';
	preg_match_all($pattern, $markup, $stateData);
	
	for($i = 0; $i < count($stateData[0]); $i++){
		$statesUrls[$i] = str_replace('a href="', '', $stateData[0][$i]);
		$statesUrls[$i] = str_replace('">', '', $statesUrls[$i]);
		$states[$i] = addslashes($statesUrls[$i][33].$statesUrls[$i][34]);
		$url = $statesUrls[$i];
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$markup = curl_exec($ch);
		$pattern = '/a href=.*?\<\/a\>/';
		preg_match_all($pattern, $markup, $cityData);
		echo '<h3>'.$statesUrls[$i].' - '.$states[$i].'</h3>';
		for ($j = 3; $j < count($cityData[0]); $j++){

			$cities[$j] = preg_replace('/a href=.*?\>/', '', $cityData[0][$j]);
			$cities[$j] = preg_replace('/\<.>/', '', $cities[$j]);
			$cities[$j] = addslashes(preg_replace('/\<..>/', '', $cities[$j]));
			preg_match_all('/\".*?\"/', $cityData[0][$j], $cityUrls);
			$cityUrls[0][0] = str_replace('"', '', $cityUrls[0][0]).'/jjj/';
			$urls[$j] = addslashes($cityUrls[0][0]);
			echo $states[$i].' - '.$cities[$j].' - '.$cityUrls[0][0].'<br />';
			
			$sql = "INSERT INTO craigslist (city, state, url)
		VALUES ('$cities[$j]', '$states[$i]', '$urls[$j]')";
			if (!mysql_query($sql,$con))
					{
						die('Error: ' . mysql_error());
					}
		}
		
		echo '<br />';
		
	}
	
	curl_close($ch);
?>