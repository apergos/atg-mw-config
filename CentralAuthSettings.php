<?php

# this has all the settings for central auth so we can just include it
# in the loginwiki stanza in InitialiseSettings

$wgCookieSameSite = 'None';

$wgVirtualDomainsMapping['virtual-centralauth'] = [ 'db' => 'centralauth' ];

$wgCentralAuthDatabase = 'centralauth';
$wgCentralAuthAutoMigrate = true;
$wgCentralAuthAutoMigrateNonGlobalAccounts = false;
$wgCentralAuthStrict = false;
$wgCentralAuthDryRun = false;
$wgCentralAuthCookies = true;
$wgCentralAuthLoginWiki = 'loginwiki';

// set a different cookie depending on the domain, for testing so-called 'edge logins'
$wgCentralAuthCookieDomain = '';
if ( in_array( $wgDBname, [ 'testenwiki', 'test2enwiki', 'metawiki' ] ) ) {
	$wgCentralAuthCookieDomain = '.wikipedia.test';
} elseif ( in_array( $wgDBname, [ 'testenwikt', 'test2enwikt' ] ) ) {
	$wgCentralAuthCookieDomain = '.wiktionary.test';
}
$wgCentralAuthCookiePrefix = 'centralauth_';
$wgCentralAuthCookiePath = '/';

# which wiki is used for automatic login and acquisition of the appropriate cookie
# for the specified wiki family, i.e. domain? these wikis will be automatically logged
# into behind the scenes when the user logs into a local wiki
$wgCentralAuthAutoLoginWikis = [ 
    '*.wikipedia.org' => 'metawiki',
    '*.wiktionary.org' => 'testenwikt',
];

# this is for autocreate of local accounts when a global one is created, which we really
# oonly need on the wiki where central logins happen
$wgCentralAuthAutoCreateWikis = [ 'loginwiki' ];

# it wants a 20x20 icon, we have none. skip and hope.
$wgCentralAuthLoginIcon = false;

# this has a default with a lot lot lot of user prefs, skip
#$wgCentralAuthPrefsForUIReload = [];

# this is for centralauth events appearing in irc. heh. skip
# $wgCentralAuthRC = [];

# number of wikis where we will do a suppress user at a time. we could just do  all of
# them btu again who really cares
$wgCentralAuthWikisPerSuppressJob = 4;

$wgCentralAuthReadOnly = false;

# let's not get into this yet
$wgCentralAuthEnableGlobalRenameRequest = false;

# let's skip this too, sometime I oughta look at it but today is not that time
$wgCentralAuthGlobalPasswordPolicies = [];

# wow this is sketchy. a wiki page with a list of 'we will not rename you'?
# how about no
$wgGlobalRenameDenylist = null;

# the person who did the block will be shown as global>username-here
# to indicate that it's a ca thing
$wgCentralAuthGlobalBlockInterwikiPrefix = "global";

