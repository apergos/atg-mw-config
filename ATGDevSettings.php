<?php

# a selection of things from includes/DevelopmentSettings.php

global $wgDebugRawPage, $wgDebugToolbar;
global $wgRateLimits, $wgPasswordAttemptThrottle, $wgForceDeferredUpdatesPreSend, $wgSQLMode;

// we love all the debugging output. ALLLL of it.
$wgDebugRawPage = true;
$wgDebugToolbar = true;

foreach ( $wgRateLimits as $right => &$limit ) {
	foreach ( $limit as $group => &$groupLimit ) {
		$groupLimit[0] = PHP_INT_MAX;
	}
}

// we don't need this ever. who cares
// Greatly raise the limits on short/long term login attempts,
// so that automated tests run in parallel don't error.
$wgPasswordAttemptThrottle = [
        [ 'count' => 1000, 'seconds' => 300 ],
        [ 'count' => 100000, 'seconds' => 60 * 60 * 48 ],
];

// Run deferred updates before sending a response to the client.
// This ensures that in end-to-end tests, a GET request will see the
// effect of all previous POST requests (T230211).
// Caveat: this does not wait for jobs to be executed, and it does
// not wait for database replication to complete.
$wgForceDeferredUpdatesPreSend = true;
// but wow	that caveat.

// Enable MariaDB/MySQL strict mode (T108255)
$wgSQLMode = 'STRICT_ALL_TABLES,ONLY_FULL_GROUP_BY';
