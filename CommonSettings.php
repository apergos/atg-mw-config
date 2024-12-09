<?php
# settings and configuration goes here that is the same
# for all wikis in your farm, and which is boring (and
# bad practice of course) to duplicate in all your
# LocalSettings.php files per wiki.

#error_reporting( -1 );
ini_set( 'display_errors', 1 );

if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

$inTestbed = false;
$myName = gethostbyaddr(gethostbyname(gethostname()));
if ( str_ends_with( $myName, ".lan" ) ) {
    $inTestbed = true;
}

# we use this config file for a local installation AND for the dumps testbed
# running on containers, so we need a different server url depending on which
# of those is running this. if my hostname is $something.lan, assume I'm in
# the testbed and set the server url accordingly.
if ( $inTestbed ) {
    $wgServer = "http://atg-httpd.atg.lan";
} else {
    $wgServer = "http://localhost";
}

require __DIR__ . "/DBMapping.php";
require __DIR__ . "/UrlToDB.php";

# we don't do email ever.
$wgEnableEmail = false;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = "apache@🌻.invalid";
$wgPasswordSender = "apache@🌻.invalid";

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = true;

## Database settings
$wgDBtype = "mysql";

# we use this config file for a local installation AND for the dumps testbed
# running on containers, so we need a different db hostname depending on which
# of those is running this. if my hostname is $something.lan, assume I'm in
# the testbed and set the db server accordingly.
if ( $inTestbed ) {
    $wgDBserver = "atg-dbprimary";
} else {
    $wgDBserver = "localhost";
}

# MySQL specific settings
$wgDBprefix = "";

# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

# Shared database table
# This has no effect unless $wgSharedDB is also set.
$wgSharedTables[] = "actor";

## Shared memory settings
$wgMainCacheType = CACHE_ACCEL;
$wgMemCachedServers = [];

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgUploadDirectory = __DIR__ . '/../w/images';
$wgUploadPath = '/images';
$wgEnableUploads = true;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";
$wgFileExtensions[] = 'svg';
$wgSVGConverter = 'ImageMagick';

# InstantCommons allows wiki to use images from https://commons.wikimedia.org
$wgUseInstantCommons = false;

# Periodically send a pingback to https://www.mediawiki.org/ with basic data
# about this MediaWiki instance. The Wikimedia Foundation shares this data
# with MediaWiki developers to help guide future development efforts.
$wgPingback = false;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale. This should ideally be set to an English
## language locale so that the behaviour of C library functions will
## be consistent with typical installations. Use $wgLanguageCode to
## localise the wiki.
$wgShellLocale = "en_US.utf8";

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "https://creativecommons.org/licenses/by-sa/4.0/";
$wgRightsText = "Creative Commons Attribution-ShareAlike";
$wgRightsIcon = "$wgResourceBasePath/resources/assets/licenses/cc-by-sa.png";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";

# production uses this
$wgDefaultSkin = "vector-2022";

# Enabled skins.
wfLoadSkin( 'Vector' );

# Standard  set, way more than is necessary but who cares.
# A few wikis have extras, see InitialiseSettings for that
wfLoadExtension( 'Babel' );
wfLoadExtension( 'CategoryTree' );
wfLoadExtension( 'Cite' );
wfLoadExtension( 'CiteThisPage' );
wfLoadExtension( 'ConfirmEdit' );
wfLoadExtension( 'Disambiguator' );
wfLoadExtension( 'Gadgets' );
wfLoadExtension( 'ImageMap' );
WfLoadExtension( 'Interwiki' );
wfLoadExtension( 'LabeledSectionTransclusion' );
wfLoadExtension( 'PagedTiffHandler' );
wfLoadExtension( 'ParserFunctions' );
wfLoadExtension( 'PdfHandler' );
wfLoadExtension( 'Scribunto' );
wfLoadExtension( 'SiteMatrix' );
wfLoadExtension( 'TemplateData' );
wfLoadExtension( 'TimedMediaHandler' );
wfLoadExtension( 'TocTree' );
wfLoadExtension( 'UniversalLanguageSelector' );
wfLoadExtension( 'WikiEditor' );
wfLoadExtension( 'WikimediaMaintenance' );

$wgCompressRevisions = true;

# we need to actually run jobs from the command line now.
# DO NOT FORGET
$wgJobRunRate = 0;

$wgLocalVirtualHosts = [
	'testen.wikipedia.test',
	'test2en.wikipedia.test',
	'login.wikipedia.test',
	'meta.wikipedia.test',
	'testen.wiktionary.test',
#	'test2en.wiktionary.test',
];

# default values overridden in InitialiseSettings
$wmgUseCentralAuth = false;

require __DIR__ . "/Logging.php";
require __DIR__ . "/ATGDevSettings.php";

require __DIR__ . "/InitialiseSettings.php";
