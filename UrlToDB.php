<?php

# this is just for added debugging before MW logging is available
require_once __DIR__ . "/TempLog.php";

$wgDBname = '';
templog( $logpath, "CommonSettings: wgdbname is initialized to empty" );

$subdir = '';

# the older testing wikis have urls that look like https://localhost/wikinamehere/mw/index.php?...
# get the wiki dbame by mapping the first subdir of the url to the dbname, if we have a url.
if (isset($_SERVER['REQUEST_URI'])) {
	$subdir = explode('/', $_SERVER['REQUEST_URI'])[1];
	$temprequri = $_SERVER['REQUEST_URI'];
	templog( $logpath, "CommonSettings: (old approach) subdir is $subdir and requesturi is $temprequri" );
	$project = "none";
}

# the CentralAuth wikis are listed in the DBMapping file; those have urls like
# https://testen.wiktionary.test/mw/index.php?title=Main_Page
if (( $subdir == '' ) || (!isset($wgDbMapping['none'][$subdir]))) {
	if (isset($_SERVER['SERVER_NAME'])) {
		$subdir = explode('.', $_SERVER['SERVER_NAME'])[0];
		$project = explode('.', $_SERVER['SERVER_NAME'])[1];
		$tempservername = $_SERVER['SERVER_NAME'];
		templog( $logpath, "CommonSettings: (new approach) subdir is $subdir and servername is $tempservername" );
		if ( $subdir == '' || $project == '' ) {
			header( "HTTP/1.1 500 Bad Request, unknown wiki <$subdir> and <$project>" );
			exit(1);
		}
	}
	if ( $subdir != '' ) {
		$wgDBname = $wgDbMapping[$project][$subdir];
		templog( $logpath, "CommonSettings: (new approach) subdir is $subdir and wgDBname is $wgDBname" );
	}
} else {
	$wgDBname = $wgDbMapping['none'][$subdir];
}

# we've been called from the cli, get the dbname out of $argv
if (!$wgDBname) {
	templog( $logpath, "CommonSettings: (cli) wgdbname is not set" );

	# code lightly adapted from MWMultiversion.php
	# The --wiki param must be the second argument to avoid any
	# "options with args" ambiguity (see Maintenance.php).
	$index = 1;
	if ( isset( $argv[$index] ) && $argv[$index] === '--wiki' ) {
		$wgDBname = isset( $argv[$index+1] ) ? $argv[$index+1] : ''; // "script.php --wiki dbname"
		templog( $logpath, "CommonSettings: cli (1) and wgDBname is $wgDBname" );
	} elseif ( isset( $argv[$index] ) && substr( $argv[$index], 0, 7 ) === '--wiki=' ) {
		$wgDBname = substr( $argv[$index], 7 ); // "script.php --wiki=dbname"
		templog( $logpath, "CommonSettings: cli (2) and wgDBname is $wgDBname" );
	} else {
		$envwiki = getenv('MW_PHPUNIT_WIKI');
		if ( $envwiki !== false ) {
			$wgDBname = $envwiki;
		}
	}
	if ( $wgDBname === '' ) {
		echo "Missing dbname. Why? wiki component is $subdir\n" ;
		echo "Usage: php scriptName.php --wiki=dbname\n" ;
		exit(1);
	}
}
