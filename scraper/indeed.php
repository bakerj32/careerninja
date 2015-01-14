<?php
	destroyVars();
	$url = 'http://www.indeed.com/l-'.$zip.'-jobs.html';
	$markup = initCurl($url);
	if (preg_match('/span class=np\>Next/s', $markup)){
		$morePages = True;
	}

	$count = 10;
	while($morePages && $count <= 100){
		$url = 'http://www.indeed.com/jobs?l='.$zip.'&start='.$count;
		$tmp = initCurl($url);
		if (!preg_match('/span class=np\>Next/s', $tmp)){
			$morePages = False;
		}
		$markup .= $tmp;
		$count += 10;
	}
	
	$siteId = 7;
	$jobUrl = 'None';
	$site = 'Indeed';
	$siteUrl = 'http://www.indeed.com/';
	$location = 'Bellingham, Wa';
	$category = 'Uncategorized';
	$postDate = '00:00:0000';
	$scrapeDate = date('r');
	$result = '<table border="1"><tr><th>#</th><th>Site</th><th>Job</th><th>Job Url</th><th>Location</th><th>Category</th><th>Company</th><th>Post Time</th></tr>';

	// Match the relevant data from the markup
	$pattern = '/class=\"row\".*?\<\/div\>/s';
	preg_match_all($pattern, $markup, $data);
	
	// Format data
	for($i = 0; $i < count($data[0]); $i++){
		preg_match('/\<h2.*?\"\>(.*?)\<\/a\>/s', $data[0][$i], $titles[$i]);
		$title = addslashes($titles[$i][1]);
		
		preg_match('/\<h2.*?href=\"(.*?)\"/s', $data[0][$i], $urls[$i]);
		$url = addslashes('http://www.indeed.com'.$urls[$i][1]);
		
		preg_match('/class=company\>(.*?)\<\/span\>/', $data[0][$i], $companies[$i]);
		$company = addslashes($companies[$i][1]);
		if($company == ''){
			$company = 'None Provided';
		}
		
		preg_match('/class=\"location\"\>(.*?)\<\/span\>/', $data[0][$i], $locations[$i]);
		$location = addslashes($locations[$i][1]);
		
		preg_match('/class=date\>(.*?)\<\/span\>/', $data[0][$i], $dates[$i]);
		$date = strtotime($dates[$i][1]);
		$date = date( "m-d-Y", $date);
		
		$sql = "INSERT INTO $table (siteId, site, siteUrl, jobTitle, jobUrl, category, company, location, postDate, scrapeTime)
	VALUES ('$siteId', '$site', '$siteUrl', '$title', '$url', '$category', '$company', '$location', '$date', '$scrapeDate')";
		if (!mysql_query($sql,$con)){
			die('Error: ' . mysql_error());
		}

		if($plainText == True){
			$result.= '<tr><td>'.$i.'</td>
				<td>'.$site.'</td>
				<td>'.$title.'</td>
				<td>'.$url.'</td>
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

