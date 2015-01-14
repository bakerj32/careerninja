<?php
include ('../includes/preferences.php');
include ('includes/lastRun.php');
$con = mysql_connect($server, $dbUsername, $dbPassword);
$table = $_GET['table'];
$city = $_GET['city'];
$state = $_GET['state'];
$cl = $_GET['cl'];
if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

$selectDB = mysql_select_db($db, $con);
if (!selectDB)
	{
		die('Could not connect to '.$db);
	}

$defaultQuery = mysql_query("SELECT DISTINCT * FROM $table LIMIT 200");
$countQuery = mysql_query("SELECT count(DISTINCT jobTitle) as resultCount FROM $table");
$resultCount = mysql_fetch_array($countQuery);
$categoryQuery = mysql_query("SELECT DISTINCT category FROM $table LIMIT 30");
$companyQuery = mysql_query("SELECT DISTINCT company FROM $table LIMIT 30");
$siteQuery = mysql_query("SELECT DISTINCT site FROM _98225 LIMIT 30");
mysql_close($con);

?>

<html>
<head>
	<script type="text/javascript" src="../js/jquery.js"></script> 
	<script type="text/javascript" src="../js/jqueryui.js"></script> 
	<script type="text/javascript" src="../js/jquery.tablesorter.js"></script>
	<script type="text/javascript" src="../js/jquery.tablesorter.pager.js"></script>
	<script type="text/javascript" src="../js/loadmask/jquery.loadmask.min.js"></script> 
	<script type="text/javascript" src="js/jobs.js"></script> 
	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/themes/base/jquery-ui.css"/>
	<link href="css/reset.css" rel="stylesheet" type="text/css" />
	<link href="../js/loadmask/jquery.loadmask.css" rel="stylesheet" type="text/css" />
	<link href="css/styles.css" rel="stylesheet" type="text/css" />
	<link href="css/redmond.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
	<?php include('includes/header.php'); ?>
	<div id="leftBar">
		<div id="categoryPane" class="ui-widget-content">
			<h3 class="ui-widget-header">Categories</h3>
				<span id="catResults">
					<?php
						$results = '<ol id="selCategories"><li id="All" class="ui-selected ui-widget-content" name="categories">All</li>';
						while($categories = @mysql_fetch_array($categoryQuery)){
							$results .= '<li id="'.$categories['category'].'" class="ui-widget-content" name="companies">'.$categories['category'].'</li>';
						}
						echo $results.'</ol>';
					?>
				</span>
			<h3 class="ui-widget-header" style="margin-top: .5em;">Companies</h3>
				<span id="companyResults">
					<?php
						$results = '<ol id="selCompanies"><li id="All" class="ui-selected ui-widget-content" name="companies">All</li>';
						while($companies = @mysql_fetch_array($companyQuery)){
							$results .= '<li id="'.$companies['company'].'" class="ui-widget-content" name="companies">'.$companies['company'].'</li>';
						}
						echo $results.'</ol>';
					?>
				</span>
		</div>
	</div>
	<div id="results" class="rounded">
		<h3 class="ui-widget-header">AJAX Powered Job Site Agregator<small>Beta</small></h3>
		<span id="siteResults">
			<?php
				$results = '<div id="radio">
						<input type="radio" id="All" name="sites" checked="checked"/>
						<label class="siteButton" onClick="getSelectedSite(this)" id="All" for="All">All</label>';
				while($sites = @mysql_fetch_array($siteQuery)){
					$results .= '<label class="siteButton" for="'.$sites['site'].'">'.$sites['site'].'</label>';
					$results .= '<input type="radio" onClick="getSelectedSite(this)" id="'.$sites['site'].'" name="sites" />';
					
				}
				$results .= '</div>'; 
				echo $results;
			?>
		</span>
		<div id="resultsPane" class="ui-widget-content">
			<span id="output">
				<?php
					$result = '<h3 class="ui-widget-header">All - All - All</h3><p style="float: left;">Results: '.$resultCount['resultCount'].'</p>';
					
					$result .= '
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
					$firstResult = @mysql_fetch_array($defaultQuery);
					if (count($firstResult) == 1){
						echo '<p class="red">Nothing appears to match your query</p>';
					}
					else {
						while ($results = @mysql_fetch_array($defaultQuery)){
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
						
						$result = $result.'</tbody></table>
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
							</div>';
						echo $result;
					}

				?>
			</span>
		</div>
	</div>
	<?php include('includes/footer.php'); ?>
</div>
</body>
</html>
