<?php
	destroyVars();
	$url = 'http://www.careerjet.com/search/jobs?l='.$city.'+'.$state;
	$markup = initCurl($url);
	preg_match('/lid=(.*?)\"\>/', $markup, $lid);
	$url = 'http://www.careerjet.com/wsearch/jobs?l='.$city.'+'.$state.'&lid='.$lid[1].'&b=21';
	$markup .= initCurl($url);
	$url = 'http://www.careerjet.com/wsearch/jobs?l='.$city.'+'.$state.'&lid='.$lid[1].'&b=41';
	$markup .= initCurl($url);
	$url = 'http://www.careerjet.com/wsearch/jobs?l='.$city.'+'.$state.'&lid='.$lid[1].'&b=61';
	$markup .= initCurl($url);
	
	// Define Default values
	$siteId = 6;
	$jobUrl = 'None';
	$site = 'Career Jet';
	$siteUrl = 'http://www.careerjet.com';
	$location = 'Bellingham, Wa';
	$category = 'Uncategorized';
	$postDate = '00:00:0000';
	$scrapeDate = date('r');
	$result = '<table border="1"><tr><th>#</th><th>Site</th><th>Job</th><th>Job Url</th><th>Location</th><th>Category</th><th>Company</th><th>Post Time</th></tr>';

	// Match the relevant data from the markup
	$pattern = '/\<div class=\"job\"\>(.*?)\<\/div\>/s';
	preg_match_all($pattern, $markup, $data);
	
	// Format data
	for($i = 0; $i < count($data[0]); $i++){
		preg_match('/nofollow\"\>(.*?)\<\/a\>/', $data[0][$i], $titles[$i]);
		$title = addslashes($titles[$i][1]);
		
		preg_match('/\"(\/job\/.*?html)\"/', $data[0][$i], $urls[$i]);
		$url = addslashes('http://www.careerjet.com'.$urls[$i][1]);
		
		preg_match('/company_compact\" \>(.*?)\</', $data[0][$i], $companies[$i]);
		$company = addslashes($companies[$i][1]);
		if ($company == ''){
			$company = 'None Provided';
		}
		
		preg_match('/\<a.*?locations_compact.*?\" \>(.*?)\</', $data[0][$i], $locations[$i]);
		$location = addslashes($locations[$i][1]);
		
		preg_match('/date_compact\"\>..(.*?)..\</s', $data[0][$i], $dates[$i]);
		$date = strtotime($dates[$i][1]);
		$date = date( "m-d-Y", $date);
		
		$sql = "INSERT INTO $table (siteId, site, siteUrl, jobTitle, jobUrl, category, company, location, postDate, scrapeTime)
	VALUES ('$siteId', '$site', '$siteUrl', '$title', '$url', '$category', '$company', '$location', '$date', '$scrapeDate')";
		if (!mysql_query($sql,$con)){
			die('Error: ' . mysql_error());
		}
		
		if($plainText == True){
			$result.= '<tr><td>'.$site.'</td>
				<td>'.$i.'</td>
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
