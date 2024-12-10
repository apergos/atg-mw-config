<?php

require_once __DIR__ . "/TempLog.php";

# user names, passwords, upgrade keys and such go here.
require __DIR__ . '/private/PrivateSettings.php';
templog( $logpath, "InitialiseSettings: wgDBuser is set to $wgDBuser" );

# per-wiki settings go here.
$basedir = "/";
$wgDebugLogFile = __DIR__ . "/../logs/$wgDBname/debugging.log";
$wgAuthenticationTokenVersion = "1";

$crappyScriptSubdir = [ 'elwikt' => 'elwikt/',
			'elwikivoyage' => 'elwv/',
			'tenwiki' => 'tenwiki/',
			'wikidatawiki' => 'wikidata/',
			'testwiki' => 'testwiki/' ];
$wgScriptPath = $basedir . ( $crappyScriptSubdir[ $wgDBname ] ?? '' ) . "mw";
$wgResourceBasePath = $wgScriptPath;
templog( $logpath, "InitialiseSettings: wgResourceBasePath is set to $wgResourceBasePath" );

$wgRightsIcon = "$wgResourceBasePath/resources/assets/licenses/cc-by-sa.png";
$crappyLogosDir = "$wgResourceBasePath/resources/assets";

$crappyMWVersionSubdir = [ 'testenwiki' => 'php-master',
			   'test2enwiki' => 'php-master',
			   'metawiki' => 'php-master',
			   'loginwiki' => 'php-master',
			   'testenwikt' => 'php-master',
			   'test2enwikt' => 'php-master' ];
$crappyMWPath = "$mwpath/" . ( $crappyMWVersionSubdir[ $wgDBname ] ?? 'latest' );
putenv( 'MW_INSTALL_PATH=' . $crappyMWPath );

# FIXME check this
$scribuntoSubdir = 'extensions/Scribunto/includes/Engines/LuaStandalone/binaries/lua5_1_5_linux_64_generic';
$wgScribuntoEngineConf['luastandalone']['luaPath'] = '$crappyMWPath/$scribuntoSubdir/lua';

$wgDefaultSkin = "vector-2022";
# default
$wgLanguageCode = "en";

$wgDefaultUserOptions[ 'toc-floated' ] = true;

require_once __DIR__ . "/DumpWikisSettings.php";

switch ( $wgDBname ) {
	# all wikis for CentralAuth testing
	case 'testenwiki':
	case 'test2enwiki':
	case 'metawiki':
	case 'loginwiki':
	case 'testenwikt':
	case 'test2enwikt':
		$wmgUseCentralAuth = true;

		if ($wgDBname == 'testenwiki') {
			$wgServer = "https://testen.wikipedia.test";
			$wgSitename = "TestEnWiki";
		} else if ($wgDBname == 'test2enwiki') {
			$wgServer = "https://test2en.wikipedia.test";
			$wgSitename = "Test2EnWiki";
		} else if ($wgDBname == 'metawiki') {
			$wgServer = "https://meta.wikipedia.test";
			$wgSitename = "MetaWiki";
			# in production, this is true for meta, we'll do the same
			$wgGroupPermissions['steward']['centralauth-rename'] = true;
			$wgGroupPermissions['steward']['userrights-interwiki'] = true;
			$wgGroupPermissions['steward']['globalgroupmembership'] = true;
			$wgGroupPermissions['steward']['globalgrouppermissions'] = true;
		} else if ($wgDBname == 'loginwiki') {
			$wgServer = "https://login.wikipedia.test";
			$wgSitename = "LoginWiki";
		} else if ($wgDBname == 'testenwikt') {
			$wgServer = "https://testen.wiktionary.test";
			$wgSitename = "TestEnWikt";
			wfLoadExtension( 'OATHAuth' );
			wfLoadExtension( 'WebAuthn' );
		} else if ($wgDBname == 'test2enwikt') {
			$wgServer = "https://test2en.wiktionary.test";
			$wgSitename = "Test2EnWikt";
			wfLoadExtension( 'OATHAuth' );
			wfLoadExtension( 'WebAuthn' );
		}

		# common to all wikis for central auth testing

		# for wikis with checkuser enabled
		# in production we do not use a central database for these, it seems. so for local testing, do the same
		# $wgVirtualDomainsMapping['virtual-checkuser-global'] = [ 'db' => 'centralauth' ];

		# just for wikis with oathauth enabled
		# $wgOATHAuthDatabase = 'centralauth';
		$wgVirtualDomainsMapping['virtual-oathauth'] = [ 'db' => 'centralauth' ];
		$wgOATHAuthAccountPrefix = 'authntest';
		$wgGroupPermissions['user']['oathauth-enable'] = true;
		# $wgWebAuthnNewCredsDisabled = true;		   		   

		$wgDebugDumpSql = true;

		## Uncomment this to disable output compression
		# $wgDisableOutputCompression = true;

		$wgLogos = [ '1x' => "$crappyLogosDir/Goatification_logo.svg",
			     'icon' => "$crappyLogosDir/Goatification_logo.svg.png" ];

		$wgDBssl = false;

		# Time zone
		$wgLocaltimezone = "UTC";

		## Set $wgCacheDirectory to a writable directory on the web server
		# ths is for localization cache stuff, lives on disk
		$wgCacheDirectory = "$IP/cache/$wgDBname";

		# FIXME check this
		$wgScribuntoEngineConf['luastandalone']['luaPath'] = '/usr/bin/lua';

		# $wgGlobalBlockingDatabase = "gbtesting";
		$wgVirtualDomainsMapping['virtual-globalblocking'] = [ 'db' => 'centralauth' ];
		$wgApplyGlobalBlocks = true;

		# $wgAutoCreateTempUser['enabled'] = false;
		# $wgAutoCreateTempUser['known'] = true;
		# $wgAutoCreateTempUser['matchPattern'] = '~2$1';
		# $wgAutoCreateTempUser['genPattern'] = '~$1';

		wfLoadExtension( 'AntiSpoof' );
		wfLoadExtension( 'CheckUser' );
		wfLoadExtension( 'CentralAuth' );
		wfLoadExtension( 'GlobalBlocking' );
		  
		require __DIR__ . "/CentralAuthSettings.php";
		require __DIR__ . "/CentralAuthWgConfSettings.php";

		break;
}

