<?php
  $wgDbMapping = [];

  ## SQL/XML dumps test wikis
  # these get from http://localhost/wikidbname/mw/...
  $wgDbMapping['none'] = [
	'elwikt' => 'elwikt',
	'elwv' => 'elwikivoyage',
	'tenwiki' => 'tenwiki',
	'testwiki' => 'testwiki',
	'wikidata' => 'wikidatawiki',
  ];

  ## CentralAuth test wikis
  # url: http://<prefix>.<project>.test/mw/...
  $wgDbMapping['wikipedia'] = [
	'testen' => 'testenwiki',
	'test2en' => 'test2enwiki',
	'meta' => 'metawiki',
	'login' => 'loginwiki',
  ];
  $wgDbMapping['wiktionary'] = [
	'testen' => 'testenwikt',
	'test2en' => 'test2enwikt',
  ];
