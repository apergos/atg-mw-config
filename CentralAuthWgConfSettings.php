<?php

# this has the wgconf settings for central auth so we can just include it
# in the loginwiki stanza in InitialiseSettings
# it must go *after* the wfLoadExtension('CentralAuth') line. uh??? ewwww

# $wgConf->localVHosts = [ 'localhost' ];

$wgLocalDatabases = [ 'testenwiki', 'test2enwiki', 'metawiki', 'loginwiki', 'testenwikt', 'test2enwikt' ];
$wgConf->wikis = $wgLocalDatabases;
$wgConf->suffixes = [ 'wikipedia' => 'wiki', 'wiktionary' => 'wikt' ];
$wgConf->settings['wgServer'] = [
  	  'default' => 'http://localhost',
  	  'testenwiki' => 'https://testen.wikipedia.test',
  	  'test2enwiki' => 'https://test2en.wikipedia.test',
  	  'loginwiki' => 'https://login.wikipedia.test',
  	  'metawiki' => 'https://meta.wikipedia.test',
  	  'testenwikt' => 'https://testen.wiktionary.test',
  	  'test2enwikt' => 'https://test2en.wiktionary.test',
];
$wgConf->settings['wgCanonicalServer'] = $wgConf->settings['wgServer'];

$wgConf->settings['wgArticlePath'] = [
	'default' => "/mw/index.php?title=$1",
];
