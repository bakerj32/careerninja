<?php 
	destroyVars();
	$url = 'http://www.careerbuilder.com/Jobseeker/Jobs/JobResults.aspx?IPath=QH&ch=&rs=&_ctl0:_ctl2:ucQuickBar:s_rawwords=&_ctl0:_ctl2:ucQuickBar:s_freeloc='.$zip.'&_ctl0:_ctl2:ucQuickBar:s_jobtypes=ALL&qsbButton=Find+Jobs';
	$markup = initCurl($url);
	echo $markup;
	// Assign Default Values
	$jobUrl = 'None';
	$siteId = 3;
	$site = 'Career Builder';
	$siteUrl = 'http://www.careerbuilder.com/?ff=21';
	$category = 'Uncategorized';
	$company = 'Undefined';
	$postDate = '00:00:0000';
	$scrapeDate = date('r');
	$location = 'Bellingham, Wa';
	$result = '<table border="1"><tr><th>Site</th><th>Job</th><th>Job Url</th><th>Location</th><th>Category</th><th>Company</th><th>Post Time</th></tr>';

	//Match the relevant data from the markup
	$pattern = '/class=\"jt.*?\<\/a\>/';
	preg_match_all($pattern, $markup, $data);

	for($i = 0; $i < count($data[0]); $i++){
		if($debug == False){
			$sql = "INSERT INTO $table (siteId, site, siteUrl, jobTitle, jobUrl, category, company, location, postDate, scrapeTime)
		VALUES ('$siteId', '$site', '$siteUrl', '$title', '$url', '$category', '$company', '$location', '$date', '$scrapeDate')";
			if (!mysql_query($sql,$con)){
				die('Error: ' . mysql_error());
			}
		}
		else{

			$result.= '<tr><td>'.$site.'</td>
				<td>'.$title.'</td>
				<td>'.$url.'</td>
				<td>'.$location.'</td>
				<td>'.$category.'</td>
				<td>'.$company.'</td>
				<td>'.$date.'</td></tr>';
		}
	}
	
	if($debug == True){
		echo $result.'</table>';
	}

?>
