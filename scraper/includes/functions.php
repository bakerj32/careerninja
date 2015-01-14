<?php
	function destroyVars(){
		unset($jobData);
		unset($jobs);
		unset($locationData);
		unset($locations);
	}
	
	function initCurl($url){
		$ch = curl_init();
		$timeout = 5; // set to zero for no timeout
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$markup = curl_exec($ch);
		curl_close($ch);
		return $markup;
	}
?>