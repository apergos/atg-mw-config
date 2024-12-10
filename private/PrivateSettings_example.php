<?php

/**
 * this is intended to have all your secret stuff in it, yeah it's
 * only a local dev environment so probably who cares, but still.
 * 
 * $wgSecretKey: set to a unique random value and keep private
 * $wgUpgradeKey: Site upgrade key. Must be set to a string to turn on the
 * web installer while LocalSettings.php is in place

  if ( $wgDBname == 'elwikt' ) {
	  $wgSecretKey = "...";
	  $wgUpgradeKey = "...";
	  $wgDBuser = "yyyy";
	  $wgDBpassword = "xxxxx";
  } else if ( $wgDBname == ''elwikivoyage ) {
	  $wgSecretKey = "...";
	  $wgUpgradeKey = "...";
	  $wgDBuser = "yyyy";
	  $wgDBpassword = "xxxxx";
  } else if ( $wgDBname == 'tenwiki' ) {
	  ...
  }

*/
