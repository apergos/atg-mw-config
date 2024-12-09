<?php

// I have not used this in a good while. Probably bitrotted by now.
switch ($wgDBname) {
       case 'elwikt':
          break;
       case 'elwikivoyage':
          break;
       case 'tenwiki':
          break;
       case 'wikidata':
          # FIXME these are all likely wrong
	  $wgEnableWikibaseRepo = true;
	  $wgEnableWikibaseClient = true;

	  # FIXME what is $IP set to??
	  require_once "$IP/extensions/Wikibase/repo/Wikibase.php";
	  require_once "$IP/extensions/Wikibase/client/WikibaseClient.php";

	  $wmgWikibaseEnableData = true;
	  $wmgWikibaseEnableArbitraryAccess = true;
	  $wmgWikibaseUseLegacyUsageIndex = false;
	  $wmgUseWikibaseRepo = true;
	  $wmgUseWikibasePropertySuggester = true;


	  $wgExtensionEntryPointListFiles[] = "$IP/extensions/Wikidata/extension-list-wikidata";
	  $wgWBSharedSettings['specialSiteLinkGroups'][] = 'wikidata';

	  $baseNs = 120;

	  // Define the namespace indexes
	  #define( 'WB_NS_ITEM', $baseNs );
	  #define( 'WB_NS_ITEM_TALK', $baseNs + 1 );
	  define( 'WB_NS_PROPERTY', $baseNs + 2 );
	  define( 'WB_NS_PROPERTY_TALK', $baseNs + 3 );

	  // Define the namespaces
	  #$wgExtraNamespaces[WB_NS_ITEM] = 'Item';
	  #$wgExtraNamespaces[WB_NS_ITEM_TALK] = 'Item_talk';
	  $wgExtraNamespaces[WB_NS_PROPERTY] = 'Property';
	  $wgExtraNamespaces[WB_NS_PROPERTY_TALK] = 'Property_talk';

	  $wgWBRepoSettings = $wgWBSharedSettings + $wgWBRepoSettings;
	  $wgWBRepoSettings['allowEntityImport'] = true;

	  # adding these here two lines finally made it use the right content handler
	  $wgWBRepoSettings['entityNamespaces']['item'] = NS_MAIN; 
	  $wgWBRepoSettings['entityNamespaces']['property'] = WB_NS_PROPERTY;
	  # yes those ones right above. everything else, nope.

	  $wgWBRepoSettings['normalizeItemByTitlePageNames'] = true;
	  $wgWBRepoSettings['dataRightsText'] = 'Creative Commons CC0 License';
	  $wgWBRepoSettings['dataRightsUrl'] = 'https://creativecommons.org/publicdomain/zero/1.0/';

	  $wgWBRepoSettings['badgeItems'] = array();
	  $wgWBRepoSettings['clientDbList'] = array( 'wikidatawiki' );
	  $wgWBRepoSettings['localClientDatabases'] = array_combine(
	            $wgWBRepoSettings['clientDbList'],
          	    $wgWBRepoSettings['clientDbList']
	  );

	  $wgGroupPermissions['*']['property-create'] = false;

	  $wgNamespaceAliases = array(
		'WD' => NS_PROJECT,      // Bug 41834
		'WT' => NS_PROJECT_TALK,
		'P' => 120, // bug 45079
 	  );

	  $wgNamespaceAliases['Item'] = NS_MAIN;
	  $wgNamespaceAliases['Item_talk'] = NS_TALK;

	  $wgWBClientSettings['entityNamespaces'] = [ 'item' => 0, 'property' => 122 ];
	  $wgWBClientSettings['repoNamespaces'] = [ 'item' => '', 'property' => 'Property' ];

	  $wgWBRepoSettings['entityDataFormats'] = [ 'json', 'php', 'rdfxml', 'n3', 'turtle', 'ntriples', 'html', 'jsonld', ];

	  /*
	  $wgWBRepoSettings['statementSections'] = [
		 'item' => [
		 		'statements' => null,
				'identifiers' => [ 'type' => 'dataType', 'dataTypes' => [ 'external-id' ], ],
		 	   ],
		 'property' => [
		  	            'statements' => null,
				    'constraints' => [ 'type' => 'propertySet', 'propertyIds' => [ 'P2302' ], ],
			       ],
	  ];
	  */

	  $wgWBClientSettings['namespaces'] = [
		NS_CATEGORY,
		NS_PROJECT,
		NS_TEMPLATE,
		NS_HELP,
		828 // NS_MODULE
	  ];

          break;
       case 'testwiki':

          break;
}
