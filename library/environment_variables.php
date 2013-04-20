<?php

// Get the URL parameter.
$url = (!empty($_GET['url'])) ? $_GET['url'] : false;

// Process the URL parameter.
if ($url) {
	$url = rtrim($url, '/');
	$url_parts = explode('/', $url);
} else {
	$url_parts = array();
}

// Set the environment variables.
$request_method 	= $_SERVER['REQUEST_METHOD'];
$controller     		= (!empty($url_parts[0]))         			? strtolower($url_parts[0]) : 	'index';
$action         			= (!empty($url_parts[1]))         			? strtolower($url_parts[1]) : 	'index';
$id             			= (!empty($url_parts[2]))         			? $url_parts[2]             			: false;
$filter        			= (!empty($_GET['filter']))       			? $_GET['filter']           			: false;
$logged_in    		= (isset($_SESSION['logged_in'])) 	? true                      				: false;