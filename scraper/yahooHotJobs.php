<?php
	destroyVars();
	$url = 'http://hotjobs.yahoo.com/job-search?jobtype=PERM&jobtype=CONT&commitment=FT&commitment=PT&kw=&locations='.$zip.'&country=USA&metro_search=1&industry=';

	$markup = initCurl($url);
	
	if (preg_match('/\<span\>Next\<\/span\>/', $markup)){
		$morePages = True;
	}
	$count = 30;
	while ($morePages){
		$url = 'http://hotjobs.yahoo.com/job-search-l-'.$city.'-'.$state.'-m-1-d-FT-d-PT-j-PERM-j-CONT-o-'.$count;
		$tmp = initCurl($url);
		if (!preg_match('/\<span\>Next\<\/span\>/', $tmp)){
			$morePages = False;
		}
		$markup .= $tmp;
		$count += 30;
	}

	// Define Default values
	$siteId = 4;
	$jobUrl = 'None';
	$site = 'Yahoo Hot Jobs';
	$siteUrl = 'http://www.yahoo.com';
	$location = 'Bellingham, Wa';
	$category = 'Uncategorized';
	$postDate = '00:00:0000';
	$scrapeDate = date('r');
	$result = '<table border="1"><tr><th>#</th><th>Site</th><th>Job</th><th>Job Url</th><th>Location</th><th>Category</th><th>Company</th><th>Post Time</th></tr>';

	// Match the relevant data from the markup
	$pattern = '/a href=\"\/job.*?SRP\" >(.*?)\<\/a\>/';
	preg_match_all($pattern, $markup, $titleData);
	
	$pattern = '/a href=\"(\/job.*?SRP)\"/';
	preg_match_all($pattern, $markup, $urlData);

	$pattern = '/td class=\"t\".(.*?)\<\/tr\>/s';
	preg_match_all($pattern, $markup, $data);
	
	$pattern = '/class=\"c\"\>\<a.*?>(.*?)\<\/a\>/';
	preg_match_all($pattern, $markup, $companyData);
	
	// Format data
	for($i = 0; $i < count($titleData[0]); $i++){
		if (preg_match('/class=.rd.\>/', $data[1][$i], $datData)){
			preg_match('/class=.rd.\>.*?\<b\>(.*?)\<\/b\>/', $data[1][$i], $dateData[$i]);
		}
		else{
			preg_match('/class=\"d\".*?\>(.*?)\</', $data[1][$i], $dateData[$i]);
		}
		
		if (preg_match('/class=\"first\-of\-type/', $data[1][$i], $locData)){
			preg_match('/\<li\>(.*?)\<\/li\>/', $data[1][$i], $locationData[$i]);
		}
		else{
			preg_match('/class=\"l\".(.*?)\</', $data[1][$i], $locationData[$i]);
		}
		
		$title = addslashes($titleData[1][$i]);
		$url = addslashes('http://hotjobs.yahoo.com'.$urlData[1][$i]);
		$company = addslashes($companyData[1][$i]);
		$location = addslashes($locationData[$i][1]);
		$date = date( "Y-d-m", strtotime($dateData[$i][1]));
		
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
