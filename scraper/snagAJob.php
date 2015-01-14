<?php
	destroyVars();
	$url = 'http://www.snagajob.com/job-seeker/jobs/search-results.aspx?postalcode='.$zip.'&radius=20&pagesize=100&initialRequest=True&adv=False';
	$markup = initCurl($url);
	
	
	// Assign Default Values
	$jobUrl = 'None';
	$siteId = 2;
	$site = 'Snag A Job';
	$siteUrl = 'http://www.snagajob.com/';
	$category = 'Uncategorized';
	$postDate = 'Not Provided';
	$scrapeDate = date('r');
	$result = '<table border="1"><tr><th>#</th><th>Site</th><th>Job</th><th>Job Url</th><th>Location</th><th>Category</th><th>Company</th><th>Post Time</th></tr>';

	//Match the relevant data from the markup
	$pattern = '/class=\"Employer.*?\>(.*?)\</';
	preg_match_all($pattern, $markup, $employerData);

	$pattern = '/a class=\"jobTitle\" href=\"(.*?fsr=true)\"/';
	preg_match_all($pattern, $markup, $linkData);

	$pattern = '/LinkTitle">(.*?)\</';
	preg_match_all($pattern, $markup, $titleData);

	$pattern = '/class=\"Location\"\>(.*?)\</';
	preg_match_all($pattern, $markup, $locationData);

	$pattern = '/class=\"Employer\"\>(.*?)\</';
	preg_match_all($pattern, $markup, $companyData);

	
	
	// Upload data to the database.
	for($i = 0; $i < count($titleData[0]); $i++){
		$title = addslashes($titleData[1][$i]);
		$url = addslashes('http://www.snagajob.com/job-seeker/jobs'.$urlData[1][$i]);
		$location = addslashes($locationData[1][$i]);
		$company = addslashes($companyData[1][$i]);
		
			$sql = "INSERT INTO $table (siteId, site, siteUrl, jobTitle, jobUrl, category, company, location, postDate, scrapeTime)
		VALUES ('$siteId', '$site', '$siteUrl', '$title', '$url', '$category', '$company', '$location', '$postDate', '$scrapeDate')";
			if (!mysql_query($sql,$con)){
				die('Error: ' . mysql_error());
			}
		
		if($plainText == True){
			$result .= '<tr><td>'.$i.'</td>
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