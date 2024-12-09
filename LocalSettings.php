<?php
# This file should be placed in the root of each mediawiki repository
# from which your wikifarm is served.
# If you have structured your wikifarm directory to look differently
# than the diagram in the wikifarm README, adjust the path below
# accordingly.

# uncoment when needed
error_reporting( -1 );
ini_set( 'display_errors', 1 );

$configs = '/var/www/html/wikifarm/configs';
require_once $configs . "/TempLog.php";

if ( isset( $_SERVER['HTTP_HOST'] ) ) {
	$temporigurl = $_SERVER['HTTP_HOST'] . " at " .  $_SERVER['REQUEST_URI'];
	templog( "LocalSettings: orig url was $temporigurl" );
}

require $configs . "/CommonSettings.php";
$wgShowExceptionDetails = true;
