<?php

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

$craigsListQuery = mysql_query("SELECT * FROM jobs WHERE refSiteId = '0'");
$careerJetQuery = mysql_query("SELECT * FROM jobs WHERE refSiteId = '1'");
$snagAJobQuery = mysql_query("SELECT * FROM jobs WHERE refSiteId = '2'");
$careerBuilderQuery = mysql_query("SELECT * FROM jobs WHERE refSiteId = '3'");
$yahooHotJobsQuery = mysql_query("SELECT * FROM jobs WHERE refSiteId = '4'");
$employmentGuideQuery = mysql_query("SELECT * FROM jobs WHERE refSiteId = '5'");

?>

<html>
<head>
	<title>Test Scraper</title>
	<link href="css/styles.css" rel="stylesheet" type="text/css" />
	<style>
		a {font-size: 14px; margin: 5px 0 5px 5px; text-decoration: none;}
		a:hover{text-decoration: underline;}
		h3 {padding: .3%; border: 1px solid #888; background-color: #DDD;}
		ul li{display-style: none;}
		li:hover{background-color: #BBB}
		
		#container
{
	margin: 0;
	padding: 0%;
	width: 100%;
	background: #fff;
}

#header
{
	background: #ccc;
	padding: 20px;
	border-bottom: 1px solid black;
}

#header h4 { margin: 0 200px 0 10px; float: left; }

#header ul{float: left;}
#header li{display: inline; list-style-type: none; margin-right: 30px;}

#content-container
{
	float: left;
	width: 100%;
}

#content
{
	background: #BBB;
	clear: none;
	float: right;
	width: 100%;
	margin: 0 0 0 0;
	display: inline;
}

#content h2 { margin: 0; }

#footer
{
	clear: both;
	border-top: 1px solid black;
	background: #ccc;
	text-align: right;
	padding: 20px;
	height: 1%;
}

.leftbox{
	width: 30%;
	background-color: #CCC;
	margin: .5%;
	border: 1px solid #999;
	float: left;
	padding: 1%;
}

.middlebox{
	width: 30%;
	float: left;
	margin: .5%;
	background-color: #CCC;
	border: 1px solid #999;
	display: inline;
	padding: 1%;
}

.rightbox{
	width: 30%;
	float: left;
	margin: .5%;
	background-color: #CCC;
	border: 1px solid #999;
	display: inline;
	padding: 1%;
}

	</style>
</head>
<body>
<div id="container">
	<div id="header">
		<?php include('includes/header.php'); ?>
	</div>
	
	<div id="content-container">
		<div id="content">
			<?php
				echo '<div class="leftbox"><a href="http://bellingham.craigslist.org/jjj/" ><center><h3>CraigsList</h3><br /></center></a>';
				$count = 0;
				echo'<ul>';
				while($craigsList = mysql_fetch_array($craigsListQuery)){
					echo '<li>'.ucwords(stripslashes($craigsList['job'])).'</li>';
					$count++;
					if($count > 19){
						break;
					}	
				}

				echo '</ul></div><div class="middlebox"><a href="http://www.careerjet.com/jobs_in_bellingham_23276.html" ><center><h3>CareerJet</h3><br /></center></a>';
				echo'<ul>';
				$count = 0;
				while($careerJet = mysql_fetch_array($careerJetQuery)){
					echo '<li>'.ucwords(stripslashes($careerJet['job'])).'</li>';
					$count++;
					if($count > 20){
						break;
					}	
				}
				echo '</ul></div><div class="rightbox"><a href="http://www.snagajob.com/jobs/Washington/Bellingham_jobs.html"><center><h3>Snag A Job</h3><br /></center></a>';
				echo'<ul>';
				$count = 0;
				while($snagAJob = mysql_fetch_array($snagAJobQuery)){
					echo '<li>'.ucwords(stripslashes($snagAJob['job'])).'</li>';
					$count++;
					if($count > 20){
						break;
					}	
				};
				echo '</ul></div><br style="clear: both;" /><br /><div class="leftbox"><a href="http://jobs.careerbuilder.com"><center><h3>Career Builder</h3><br /></center></a>';
				echo'<ul>';
				$count = 0;
				while($careerBuilder = mysql_fetch_array($careerBuilderQuery)){
					echo '<li>'.ucwords(stripslashes($careerBuilder['job'])).'</li>';
					$count++;
					if($count > 20){
						break;
					}	
				};
				echo'</ul></div><div class="middlebox"><a href="http://hotjobs.yahoo.com/"><center><h3>Yahoo Jobs</h3><br /></center></a>';
				echo'<ul>';
				$count = 0;
				while($yahooHotJobs = mysql_fetch_array($yahooHotJobsQuery)){
					echo '<li>'.ucwords(stripslashes($yahooHotJobs['job'])).'</li>';
					$count++;
					if($count > 19){
						break;
					}	
				};
				echo'</ul></div><div class="rightbox"><a href="http://employmentguide.com/"><center><h3>Employment Guide</h3><br /></center></a>';
				echo'<ul>';
				$count = 0;
				while($employmentGuide = mysql_fetch_array($employmentGuideQuery)){
					echo '<li>'.ucwords(stripslashes($employmentGuide['job'])).'</li>';
					$count++;
					if($count > 19){
						break;
					}	
				};
			?>
		</div>
	</div>
	<div id="footer">
		<?php include('includes/footer.php'); ?>
	</div>
</div>
</body>
</html>