<?php 
	$name = $_POST['name'];
	$email = $_POST['email'];
	$comments = $_POST['comments'];
	
	$to = 'j0bak3r@gmail.com';
	$message = "Name: ".$name."\r\n Email: ".$email."\r\n Comments: ".$comments;
	$header = 'From: webmaster@jordan-baker.com';
	
	
	mail($to, $subject, $message, $header);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<head>
	<script type="text/javascript" src="../../js/jquery.js"></script> 
	<script type="text/javascript" src="../../js/jqueryui.js"></script>
	<script type="text/javascript" src="../../js/loadmask/jquery.loadmask.min.js"></script> 
	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/themes/base/jquery-ui.css"/>
	<link href="../css/reset.css" rel="stylesheet" type="text/css" />
	<link href="../css/styles.css" rel="stylesheet" type="text/css" />
	<link href="../css/1col.css" rel="stylesheet" type="text/css" />
	<link href="../../js/loadmask/jquery.loadmask.css" rel="stylesheet" type="text/css" />
	<link href="../css/redmond.css" rel="stylesheet" type="text/css" />

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
	<?php include('header.php'); ?>
	
	<div id="results" class="rounded">
		<div id="content">
			<h3 class="ui-widget-header">AJAX Powered Job Site Agregator<small>Beta</small></h3>
			<h2>Thanks!</h2>
					<p class="em_text">Thank you for your interst. I will get back to you as soon as possible.<br /><br />You submitted the following information:</p><br />
		<?php
			echo '<p>Name: '.$name.'<br />
				Email: '.$email.'<br />
				Subject: '.$subject.'<br />
				Comments: '.$comments; ?></p>
		</div>
	</div>
	<?php include('footer.php'); ?>
</div>
</body>
</html>