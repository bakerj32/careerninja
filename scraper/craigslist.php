<?php
	destroyVars();
	$url = 'http://'.$city.'.craigslist.org/jjj/';
	$markup = initCurl($url);
	$url = 'http://'.$city.'.craigslist.org/jjj/index100.html';
	$markup .= initCurl($url);
	// Define Default values
	$jobUrl = 'None';
	$siteId = 0;
	$site = 'Craigs List';
	$siteUrl = 'http://www.craigslist.org';
	$postDate = '00:00:0000';
	$company = 'None Provided';
	$scrapeDate = date('r');
	$result = '<table border="1"><tr><th>Site</th><th>Job</th><th>Job Url</th><th>Location</th><th>Category</th><th>Company</th><th>Post Time</th></tr>';

	$pattern = '/4>(.*?)\<h/s';
	preg_match_all($pattern, $markup, $data);
	$count = 0;
	for($i = 0; $i < count($data[0]); $i++){
		preg_match('/4\>(.*?)\<\/h4\>/', $data[0][$i], $dateData[$i]);
		preg_match_all('/\<p\>(.*?)\<\/p\>/', $data[0][$i], $jobData);
		for($j = 0; $j < count($jobData[0]); $j++){
			preg_match('/href=\"(.*?html)/', $jobData[0][$j], $urlData[$j]);
			preg_match('/[^\/]\"\>(.*?)\<\/a\>/', $jobData[0][$j], $titleData[$j]);
			preg_match('/font size=\"-1\"\>(.*?)\<\/font\>/', $jobData[0][$j], $locationData[$j]);
			preg_match('/\/\"\>(.*?)\<\/a\>/', $jobData[0][$j], $categoryData[$j]);
			if($locationData[$j][1] == ''){$locationData[$j][1] = 'None Provided';}
			$date = strtotime($dateData[$i][1]);
			$date = date( "Y-d-m", $date);
			$title = addslashes($titleData[$j][1]);
			$url = addslashes($urlData[$j][1]);
			$category = addslashes($categoryData[$j][1]);
			$location = addslashes($locationData[$j][1]);
			$count++;
		
			$sql = "INSERT INTO $table (siteId, site, siteUrl, jobTitle, jobUrl, category, company, location, postDate, scrapeTime)
		VALUES ('$siteId', '$site', '$siteUrl', '$title', '$url', '$category', '$company', '$location', '$date', '$scrapeDate')";
		
			if (!mysql_query($sql,$con)){
				die('Error: ' . mysql_error());
			}
		
			if($plainText == True){
				$result .= '<tr><td>'.$count.'</td>
				<td>'.$site.'</td>
				<td>'.$title.'</td>
				<td>'.$url.'</td>
				<td>'.$location.'</td>
				<td>'.$category.'</td>
				<td>'.$company.'</td>
				<td>'.$date.'</td></tr>';
			}
		}
	}

	if($plainText == True){
		echo $result.'</table>';
	}
?>
