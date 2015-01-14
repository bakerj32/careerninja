<?php
	destroyVars();
	$url = 'http://seeker.dice.com/jobsearch/servlet/JobSearch?op=300&N=0&Hf=0&NUM_PER_PAGE=200&Ntk=JobSearchRanking&Ntx=mode+matchall&AREA_CODES=&AC_COUNTRY=1525&QUICK=1&ZIPCODE=&RADIUS=64.37376&ZC_COUNTRY=0&COUNTRY=1525&STAT_PROV=0&METRO_AREA=33.78715899,-84.39164034&TRAVEL=0&TAXTERM=0&SORTSPEC=0&FRMT=0&DAYSBACK=30&LOCATION_OPTION=2&FREE_TEXT=&WHERE='.$zip;
	$markup = initCurl($url);
	
	$siteId = 8;
	$jobUrl = 'None';
	$site = 'Dice';
	$siteUrl = 'seeker.dice.com';
	$location = 'Bellingham, Wa';
	$category = 'Uncategorized';
	$postDate = '00:00:0000';
	$scrapeDate = date('r');
	$result = '<table border="1"><tr><th>#</th><th>Site</th><th>Job</th><th>Job Url</th><th>Location</th><th>Category</th><th>Company</th><th>Post Time</th></tr>';

	// Match the relevant data from the markup
	$pattern = '/tr bgcolor=\"#f.*?\"\>(.*?)\<\/tr\>/s';
	preg_match_all($pattern, $markup, $data);
	
	// Format data
	for($i = 0; $i < count($data[0]); $i+=2){
		preg_match('/href=.*?sourc.*?\"\>(.*?)\<\/a>/s', $data[1][$i], $titles[$i]);
		$title = addslashes($titles[$i][1]);
		
		preg_match('/href=\"(.*?sourc.*?)\"\>(.*?)\<\/a>/s', $data[1][$i], $urls[$i]);
		$url = addslashes('http://seeker.dice.com'.$urls[$i][1]);

		preg_match('/title=.*?\"\>(.*?)\<\/a\>/', $data[1][$i], $companies[$i]);
		$company = addslashes($companies[$i][1]);
		
		preg_match('/td\>([A-Z].*?)\</s', $data[1][$i], $locations[$i]);
		$location = addslashes($locations[$i][1]);
		
		preg_match('/td\>(......)\</s', $data[1][$i], $dates[$i]);
		$date = strtotime($dates[$i][1]);
		$date = date( "m-d", $date);
		
		
		$sql = "INSERT INTO $table (siteId, site, siteUrl, jobTitle, jobUrl, category, company, location, postDate, scrapeTime)
	VALUES ('$siteId', '$site', '$siteUrl', '$title', '$url', '$category', '$company', '$location', '$date', '$scrapeDate')";
		if (!mysql_query($sql,$con)){
			die('Error: ' . mysql_error());
		}

		if($plainText == True){
			$result.= '<tr><td>'.$i.'</td>
				<td>'.$site.'</td>
				<td>'.$title.'</td>
				<td>'.$surl.'</td>
				<td>'.$location.'</td>
				<td>'.$category.'</td>
				<td>'.$company.'</td>
				<td>'.$date.'</td></tr>';
		}
	}
	
	if($plainText == True){
		echo $result.'</table>';
	}
?>
