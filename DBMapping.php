<?php
  $wgDbMapping = [];
  # these get from http://localhost/wikidbname/mw/...
  $wgDbMapping['none'] = [
	'elwikt' => 'elwikt',
	'elwv' => 'elwikivoyage',
	'tenwiki' => 'tenwiki',
	'testwiki' => 'testwiki',
	'wikidata' => 'wikidatawiki',
  ];

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
