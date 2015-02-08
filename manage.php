<?php
require_once 'autoload.php';

$config = new Config ();
$cache = new Cache ();
$sessionManager = new SessionManager ();
$oAuth = new OAuth ( $config, $sessionManager );

$sessionManager->setSessionName ( $config->getSessionName () );
$sessionManager->startSession ();

if (isset ( $_GET ['error'] )) {
	print $_GET ['error'] . ': ' . $_GET ['error_description'];
	exit ();
} 

elseif (isset ( $_GET ['code'] ) && ! $sessionManager->getSessionAcessToken ()) {
	// User authorized your application
	$sessionManager->setSessionCode ( $_GET ['code'] );
	if ($sessionManager->getSessionState () == $_GET ['state']) {
		$oAuth->getAccess ();
	} else {
		$sessionManager->destroySession ();
		$oAuth->getAuthorizationCode ();
	}
} else {
	$sessionManager->validateSession ();
	if (! $sessionManager->getSessionAcessToken ()) {
		$oAuth->getAuthorizationCode ();
	}
}