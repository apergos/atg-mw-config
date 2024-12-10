<?php

// I break everything often, so I log everything often, including
// before there is a MW logger available; change this path to what
// makes sense for you, or just make this function a noop
function templog( $logpath, $message ) {
	$templog = fopen( "$logpath/templog.txt", 'a' );
	fwrite( $templog, "$message\n" );
	fclose( $templog );
}



