<?php 
// Copyright: Byke
define ('DISABLE_CACHE', 1);

if (!defined ('P')) {
	define ('P', './');
} 
define ('FPATH', dirname (__FILE__));

include_once (P . 'inc/system.php');

$canonical = new bwCanonicalization;

if ($canonical -> cache) { // Cached content: direct output
	if (!defined ('ajax')) {
		die ($canonical -> cache);
	} else {
		die (json_encode (array ('error' => 0, 'returnMsg' => $canonical -> cache)));
	} 
} else {
	hook ('newIndexPage', 'Execute', $canonical);

	if (!file_exists (P . "inc/mode_{$canonical->loaderID}.php")) {
		stopError ("Invalid parameter.");
	} 
	include_once (P . "inc/mode_{$canonical->loaderID}.php");
} 

