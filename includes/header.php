<?php echo '<input type="hidden" id="table" name="table" value="'.$table.'" />'; ?>
<div id="header">
	<a href="http://www.jordan-baker.com/jobs/"><img src="http://www.jordan-baker.com/jobs/css/images/logo3.png" style="float: left; margin-top: 6px;" height="50"/></a>
	<div id="headerSearch">
		<form action="scraper/index.php" method="get" onSubmit="displayLoading()">
			<p><label for="Zip">Zip</label><input type="text" class="rounded" name="zip" id="zip" value="<?php echo str_replace('_', '', $table); ?>" onClick="displayLoading()" size="5"/>
			<input type="submit" value="Go!" name="submit" id="submit" style="margin-right: 10px;" /> 
		</form>
		<b>Search:</b> 
		<input type="text" class="rounded" name="<?php echo $table; ?>" id="search" onkeypress="search(this)"/></p>
	</div>
	<div id="displayCity">
		<?php echo '<p>'.ucwords($city).', '.strtoupper($state).'</p>'; ?>
	</div>
</div>