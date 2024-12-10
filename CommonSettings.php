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

# historically, local wikis managed by these config files have included
# wikis for cli testing of SQL/XML dumps, wikis in a docker testbed for dumps,
# and CentralAuth wikis.
# if my hostname is $something.lan, assume I'm in the docker testbed and set
# the server url accordingly. For the other cases, localhost is fine; CentralAuth
# wikis will get an override for wgServer in InitialiseSettings.
# we also need a different  db hostname for the docker testbed wikis.
$myName = gethostbyaddr(gethostbyname(gethostname()));
if ( str_ends_with( $myName, ".lan" ) ) {
    $wgServer = "http://atg-httpd.atg.lan";
    $wgDBserver = "atg-dbprimary";
} else {
    $wgServer = "http://localhost";
    $wgDBserver = "localhost";
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

# MySQL specific settings
$wgDBprefix = "";

# MySQL table options to use during installation or update
# we use binary rather than utf-8, so all data including old
# buggy crap can go in without issue

$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

# Shared memory settings
$wgMainCacheType = CACHE_MEMCACHED;
$wgParserCacheType = CACHE_MEMCACHED; // optional
$wgMessageCacheType = CACHE_MEMCACHED; // optional
$wgMemCachedServers = [ '127.0.0.1:11211' ];

# make sure the 'images' directory is writable! 
$wgUploadDirectory = __DIR__ . '/../w/images';
$wgUploadPath = '/images';
$wgEnableUploads = true;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";
$wgFileExtensions[] = 'svg';
$wgSVGConverter = 'ImageMagick';

# copyright/license info. use the standard stuff.
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

# save on space!
$wgCompressRevisions = true;

# we need to actually run jobs from the command line now.
# DO NOT FORGET
$wgJobRunRate = 0;

# default values overridden in InitialiseSettings
$wmgUseCentralAuth = false;

require __DIR__ . "/Logging.php";
require __DIR__ . "/ATGDevSettings.php";

require __DIR__ . "/InitialiseSettings.php";
