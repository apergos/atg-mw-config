<?php

# user names, passwords, upgrade keys and such go here.
require __DIR__ . '/private/PrivateSettings.php';
$templog = fopen('/var/www/html/wikifarm/logs/templog.txt', 'a');
fwrite($templog, "InitialiseSettings: wgDBuser is set to $wgDBuser\n");
fclose($templog);

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
$templog = fopen('/var/www/html/wikifarm/logs/templog.txt', 'a');
fwrite($templog, "InitialiseSettings: wgResourceBasePath is set to $wgResourceBasePath\n");
fclose($templog);
$wgRightsIcon = "$wgResourceBasePath/resources/assets/licenses/cc-by-sa.png";
$crappyLogosDir = "$wgResourceBasePath/resources/assets";

$crappyMWVersionSubdir = [ 'testenwiki' => 'php-master',
			   'test2enwiki' => 'php-master',
			   'metawiki' => 'php-master',
			   'loginwiki' => 'php-master',
			   'testenwikt' => 'php-master',
			   'test2enwikt' => 'php-master' ];
$crappyMWPath = "/var/www/html/wikifarm/mediawiki/" . ( $crappyMWVersionSubdir[ $wgDBname ] ?? 'latest' );
putenv( 'MW_INSTALL_PATH=' . $crappyMWPath );

# FIXME check this
$scribuntoSubdir = 'extensions/Scribunto/includes/Engines/LuaStandalone/binaries/lua5_1_5_linux_64_generic';
$wgScribuntoEngineConf['luastandalone']['luaPath'] = '$crappyMWPath/$scribuntoSubdir/lua';

$wgDefaultSkin = "vector-2022";
# default
$wgLanguageCode = "en";

$wgDefaultUserOptions[ 'toc-floated' ] = true;

switch ( $wgDBname ) {
	case 'elwikt':
		$wgSitename = "Βικιλεξικό";
		$wgLogos = [ '1x' => "$crappyLogosDir/junk_logo.png" ];

		$wgLanguageCode = "el";

		$wgExtraNamespaces[100] = 'Παράρτημα';
		$wgExtraNamespaces[101] = 'Συζήτηση_παραρτήματος';
		$wgMetaNamespace = 'Βικιλεξικό';
		$wgMetaNamespaceTalk = 'Συζήτηση_βικιλεξικού';

		wfLoadExtension( 'ActiveAbstract' );
		break;
	case 'elwikivoyage':
		$wgSitename = "Βικιταξίδια";
		$wgLogos = [ '1x' => "$crappyLogosDir/Wikivoyage-el.png.png" ];

		$wgLanguageCode = "el";

		wfLoadExtension( 'ActiveAbstract' );
		# FIXME decide whether to re-enable Kartographer

		# do we really need this still? FIXME
		$wgIncludeLegacyJavaScript = true;

		wfLoadExtension( 'Flow' );
		# FIXME see what flow settings are supposed to be, and if I need to
		# run any maintenance scripts to migrate content handler stuff etc
		$wgNamespaceContentModels[NS_TALK] = 'flow-board';
		$wgFlowSearchEnabled = false;
		$wgFlowContentFormat = 'wikitext';
		// $wgFlowCluster = 'extension1';
		$wgFlowCluster = false;

		$wgXmlDumpSchemaVersion = XML_DUMP_SCHEMA_VERSION_11;

		# FIXME lots of wikibase client stuff ommitted, do we have
		# to have it? Can we live without it?
		break;
	case 'tenwiki':
		$wgSitename = "Wikipedia 10";
		$wgMetaNamespace = "Wikipedia";
		$wgLogos = [ '1x' => "$crappyLogosDir/wiki.png" ];

		wfLoadExtension( 'InputBox' );

		break;
	case 'wikidatawiki':
		# FIXME what does php ini have in it generally and what should it have??
		ini_set('memory_limit', '1024M');

		$wgSitename = "Wikidata";
		# FIXME copy over all those logos and put them somewhere nice
		$wgLogos = [ '1x' => "$crappyLogosDir/wikidata.png" ];

		require __DIR__ . "/WikibaseConfig.php";

		$wgUseRCPatrol = true;
		break;
	case 'testwiki':
		$wgSitename = "TestWiki";
		$wgLogos = [ '1x' => "$crappyLogosDir/wiki.png" ];

		# enable javascript testing via a special page
		$wgEnableJavaScriptTest = true;

	       # wfLoadExtension( 'examples' );
	       # wfLoadExtension( 'Elastica' );
	       # wfLoadExtension( 'CirrusSearch' );
	       break;

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

