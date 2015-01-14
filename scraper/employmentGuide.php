<?php
	destroyVars();
	$url = 'http://www.employmentguide.com/searchresults.php?q=&l='.$zip.'&radius=50&sort=date%3AD%3AS%3Ad1';
	$markup = initCurl($url);

	// Define Default values
	$siteId = 5;
	$jobUrl = 'None';
	$site = 'Employment Guide';
	$siteUrl = 'http://www.employmentguide.com';
	$location = 'Bellingham, Wa';
	$company = 'undefined';
	$category = 'Uncategorized';
	$postDate = '00:00:0000';
	$scrapeDate = date('r');
	$result = '<table border="1"><tr><th>#</th><th>Site</th><th>Job</th><th>Job Url</th><th>Location</th><th>Category</th><th>Company</th><th>Post Time</th></tr>';
	
	//Match the relevant data from the markup
	
	$pattern = '/450.*?a href=\".*?\/jobd.*?\".*?b>(.*?)\</';
	preg_match_all($pattern, $markup, $titleData);
	
	$pattern = '/450.*?a href=\"(.*?\/jobd.*?)\"\>/';
	preg_match_all($pattern, $markup, $urlData);

	$pattern = '/100\"\>(.*)\<\/td\>/';
	preg_match_all($pattern, $markup, $locationData);
	
	$pattern = '/150\"\>(.*?)\<br\>/';
	preg_match_all($pattern, $markup, $companyData);
	
	$pattern = '/width=\"50\"\>(.*?)\<br\>/';
	preg_match_all($pattern, $markup, $postDateData);
	
	for($i = 0; $i < count($urlData[0]); $i++){
		$title = $titleData[1][$i];
		$url = 'http://www.employmentguide.com'.$urlData[1][$i];
		$company = $companyData[1][$i];
		$location = $locationData[1][$i];
		$postDate = $postDateData[1][$i];
		
		$sql = "INSERT INTO $table (siteId, site, siteUrl, jobTitle, jobUrl, category, company, location, postDate, scrapeTime)
	VALUES ('$siteId', '$site', '$siteUrl', '$title', '$url', '$category', '$company', '$location', '$postDate', '$scrapeDate')";
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
				<td>'.$postDate.'</td></tr>';
		}
		
	}

	if($plainText == True){
		echo $result.'</table>';
	}
?>
