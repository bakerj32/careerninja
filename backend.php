<?php

	$query = addslashes($_GET['query']);
	$site = addslashes($_GET['site']);
	$category = addslashes($_GET['category']);
	$company = addslashes($_GET['company']);
	$table = $_GET['table'];

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

	//Search Query
	if (strlen($query) > 3){
		$query = mysql_query("SELECT DISTINCT * FROM $table WHERE jobTitle LIKE '%$query%' 
		OR company LIKE '%$query%'
		OR site LIKE '%$query%'
		OR category LIKE '%$query%'
		OR postDate LIKE '%$query%'
		ORDER BY postDate");
		$countQuery = mysql_query("SELECT COUNT( DISTINCT jobTitle ) AS resultcount
FROM $table
WHERE jobTitle LIKE  '%query%'
OR company LIKE  '%query%'
OR site LIKE  '%query%'
OR category LIKE  '%query%'
OR postDate LIKE  '%query%'");
	}
	//Everything set to All	
	else if($site == 'All' && $category == 'All' && $company == 'All'){
		$query = mysql_query("SELECT DISTINCT * FROM $table LIMIT 200");
		$countQuery = mysql_query("SELECT count( DISTINCT jobTitle ) as resultcount FROM $table LIMIT 200");
	}
	//2 set to All
	else if($site == 'All' && $category == 'All'){
		$query = mysql_query("SELECT DISTINCT * FROM $table WHERE company LIKE '%$company%' LIMIT 200");
		$countQuery = mysql_query("SELECT count( DISTINCT jobTitle ) as resultcount FROM $table WHERE company LIKE '%$company%' LIMIT 200");
	}

	else if($site == 'All' && $company == 'All'){
		$query = mysql_query("SELECT DISTINCT * FROM $table WHERE category = '$category' LIMIT 200");
		$countQuery = mysql_query("SELECT count( DISTINCT jobTitle ) as resultcount FROM $table WHERE category = '$category' LIMIT 200");
	}

	else if($category == 'All' && $company == 'All'){
		$query = mysql_query("SELECT DISTINCT * FROM $table WHERE site  LIKE '%$site%' LIMIT 200");
		$countQuery = mysql_query("SELECT count( DISTINCT jobTitle ) as resultcount FROM $table WHERE site LIKE '%$site%' LIMIT 200");

	}
	//1 set to All
	else if ($site == 'All'){
		$query = mysql_query("SELECT DISTINCT * FROM $table WHERE category = '$category' AND company LIKE '%$company%' LIMIT 200");
		$countQuery = mysql_query("SELECT count( DISTINCT jobTitle ) as resultcount FROM $table WHERE category = '$category' AND company LIKE '%$company%' LIMIT 200");

	}
	else if($category == 'All'){
		$query = mysql_query("SELECT DISTINCT * FROM $table WHERE site LIKE '%$site%' AND company LIKE '%$company%' LIMIT 200");
		$countQuery = mysql_query("SELECT count( DISTINCT jobTitle ) as resultcount FROM $table WHERE site LIKE '%$site%' AND company LIKE '%$company%' LIMIT 200");

	}
	else if($company == 'All'){
		$query = mysql_query("SELECT DISTINCT * FROM $table WHERE site LIKE '%$site%' AND category = '$category' LIMIT 200");
		$countQuery = mysql_query("SELECT count( DISTINCT jobTitle ) as resultcount FROM $table WHERE site LIKE '%$site%' AND category = '$category' LIMIT 200");

	}
	//Nothing set to All
	else{
		$query = mysql_query("SELECT DISTINCT * FROM $table WHERE site LIKE '%$site%' AND category LIKE '%$category%' LIMIT 30");
		$countQuery = mysql_query("SELECT count( DISTINCT jobTitle ) as resultcount FROM $table WHERE site LIKE '%$site%' AND category LIKE '%$category%' LIMIT 30");
	}
	mysql_close($con);
	
	$resultCount = mysql_fetch_array($countQuery);

	//Initialize count variable for striping the table rows.
	$count = 0;

	$result = '<h3 class="ui-widget-header">'.$site.' - '.$category.' - '.$company.'</h3><p>Results: '.$resultCount['resultcount'].'</p>
				<table id="myTable" width="100%" class="tablesorter">
					<thead>
						<tr class="even">
							<th>Job Title</th>
							<th>Site</th>
							<th>Category</th>
							<th>Company</th>
							<th>Location</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>';
	$firstResult = mysql_fetch_array($query);
	if (count($firstResult) == 1){
		echo '<p class="red">Nothing appears to match your query</p>';
	}
	else {
		while ($results = mysql_fetch_array($query)){
			if ($count % 2 == 0){
				$result = $result.'<tr class="even">';
			}
			else{
				$result = $result.'<tr>';
			}
			
			
			if(strlen($results['jobTitle']) > 60){
				$result = $result.'<td><a href="'.$results['jobUrl'].'">'.ucwords(substr($results['jobTitle'], 0, 40)).'...</a></td>';
			}
			else{
				$result = $result.'<td><a href="'.$results['jobUrl'].'">'.ucwords($results['jobTitle']).'</a></td>';
			}
			
			
			$result = $result.'
				<td align="center"><a href="'.$results['siteUrl'].'">'.$results['site'].'</a></td>
				<td align="center">'.$results['category'].'</td>
				<td align="center">'.$results['company'].'</td>
				<td align="center">'.$results['location'].'</td>
				<td align="center">'.$results['postDate'].'</td>
			  </tr>';
			$count = $count + 1;
		}
		$result = $result.'</tbody></table><br /> 
			<div id="pager" class="pager"> 
				<form> 
					<img src="../js/icons/first.png" class="first"/> 
					<img src="../js/icons/prev.png" class="prev"/> 
					<input type="text" class="pagedisplay"/> 
					<img src="../js/icons/next.png" class="next"/> 
					<img src="../js/icons/last.png" class="last"/> 
					<select class="pagesize" style="display: none;"> 
						<option selected="selected" value="20">20</option> 
					</select> 
				</form> 
			</div><br />';
		echo $result;
	}?>
