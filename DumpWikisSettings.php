<?php

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
}
