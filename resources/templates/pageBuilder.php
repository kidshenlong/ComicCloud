<?php

	function createHeader($title = 'Default', $script=''){
		$header = "
			<!DOCTYPE html>
				<head>
					<title>Comic Cloud - ".$title."</title>
					<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css' />
					<link href='css/styles.css' rel='stylesheet' type='text/css' />
					<script src='http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js'></script>
					<link rel='stylesheet' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css' />
					<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js'></script>
					<script src='http://browserstate.github.io/history.js/scripts/bundled/html4+html5/jquery.history.js'></script>
					<script src='js/imagesloaded.pkgd.min.js'></script>
					<script src='js/main.js'></script>
					<script src='js/functions.js'></script>".
					$script.
					"<meta name='viewport' content='initial-scale=1, maximum-scale=1'>
				</head>
				<body>
				    <div id='ajaxLoader'></div>
                    <div id='ajaxLoader2'></div>
				    ";

		return $header;
	}

	function createMenu(){
		$menu = " 
			<div id='header'>
				<div id='nameplate'><a href='./'>Comic Cloud</a></div>
				<div id='menu'>
					<ul>
						<li><form id='searchForm' action='search.php'><input name='searchQuery' id='searchField' placeholder='Search Comic Title' type='search'></form></li>
					</ul>
				</div>
			</div>
			";
		return $menu;
	}