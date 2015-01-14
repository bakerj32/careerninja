<?php
include ('../includes/preferences.php');
?>

<html>
<head>
	<script type="text/javascript" src="../js/jquery.js"></script> 
	<script type="text/javascript" src="../js/jqueryui.js"></script>
	<script type="text/javascript" src="../js/loadmask/jquery.loadmask.min.js"></script> 
	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/themes/base/jquery-ui.css"/>
	<link href="css/reset.css" rel="stylesheet" type="text/css" />
	<link href="css/styles.css" rel="stylesheet" type="text/css" />
	<link href="css/1col.css" rel="stylesheet" type="text/css" />
	<link href="../js/loadmask/jquery.loadmask.css" rel="stylesheet" type="text/css" />
	<link href="css/redmond.css" rel="stylesheet" type="text/css" />

	<script type="text/javascript">
		$(document).ready(function(){
			$("#process").bind("click", function () {
				$("body").mask("Loading...");
			});
			
			$("#navigation").tabs();
			
		});
			
		function verify(zip){
			var val = zip.value;
			$.ajax({
				type: "get",
				url: "getZip.php",
				data: "zip=" + val,
				success: function(resp){  
				   document.getElementById('zipResult').innerHTML = resp;
				},  
				error: function(e){  
				  alert('Error: ' + e);  
				}  
			})
			
		}
		
	</script>
</head>
<body>

<div id="container">
	<?php include('includes/header.php'); ?>
	
	<div id="results" class="rounded">
		<h3 class="ui-widget-header">AJAX Powered Job Site Agregator<small>Beta</small></h3>
		<div id="navigation">
			<ul>
				<li><a href="#home">Home</a></li>
				<li><a href="#changelog">Change Log</a></li>
				<li><a href="#contact">Contact</a></li>
			</ul>
			<div id="home">
				<div id="content">
					<span style="float: left; width: 66%;">
						<h2>Hello, Welcome Job Fiend</h2>
						<p>We're still in early beta right now, but the site should be usuable for the most part. Check back often for updates! And dont' forget, your help is always appreciated. If you find a bug or would like to request a feature, head over to the contact page.</p>
						<h2>What Does It Do?</h2>
						<p>Provided your zip code, JobFiend will crawl the most popular job posting sites on the internet and aggregate them in one place for you for easy browsing. Jobs are filterable by site, company, and category(if provided). The data is also sortable by any field making it easy to find exacly what you're looking for.</p>
						
						<form id="zipEntry" action="scraper/index.php" method="get" onSubmit="display()">
							<fieldset>
								<legend>We'll Just Need A Zip Code</legend><br />
								<span style="float: left;">
								<label for="zip">Zip: </label><input type="text" class="rounded form-text" onKeyUp="verify(this)" size="5" maxlength="5" name="zip" id="zipcode" value=""/>
								<input type="submit" class="rounded" name="submit" value="Go!" id="process" /></span>
								<span id="zipResult" style="float: right;"></span>
							</fieldset>
						</form>
					</span>
					<div id="updates">
						<h2><img src="images/earth.png" height="21" width="21"/>&nbsp;Supported Sites:</h2>
							<ul>
								<li><a href="http://hotjobs.yahoo.com/">Yahoo Hot Jobs</a></li>
								<li><a href="http://www.craigslist.org/about/sites">Craig's List</a></li>
								<li><a href="http://www.employmentguide.com/">Employment Guide</a></li>
								<li><a href="http://www.careerjet.com/">Career Jet</a></li>
								<li><a href="http://www.indeed.com/">Indeed</a></li>
								<li><a href="http://www.snagajob.com/">Snag A Job</a></li>
								<li><a href="http://seeker.dice.com/">Dice</a></li>
								<li><a href="http://www.snagajob.com/">Coming Soon: usa.gov</a></li>
							</ul><br />
						<h2><img src="images/update.png" height="21" width="21"/>&nbsp;Recent Updates:</h2>
						<ul>
							<li>Added Career Jet and Indeed as job sources</li>
							<li>Data sets for most sites roughly doubled</li>
							<li>This new homepage</li>
							<li>Optimization</li>
							<li>Better data formatting</li>
							<li>Search is now working</li>
						</ul>
					</div>
				</div>
			</div>
			<div id="changelog">
				<?php include('includes/changelog.php'); ?>
			</div>
			<div id="contact">
				<?php include('includes/contact.php'); ?>
			</div>
		</div>
		
	</div>
	<?php include('includes/footer.php'); ?>
</div>
</body>
</html>