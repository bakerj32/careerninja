<?php
	if($table == ''){
		echo '<div id="intro" title="We Will Just Need Your Zip">
		<form action="scraper/index.php" method="get" onSubmit="displayLoading()">
			<p><label for="zip">Zip: </label><input type="text" onKeyUp="verify(this)" size="5" maxlength="5" name="zip" id="zip" />
				<input class="line" type="submit" value="Go!" name="submit" /></p>

			<br style="clear: both;"/>
			<span id="zipResult"></span><br />
		</form>
	</div>';
	}
?>