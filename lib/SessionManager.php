<?php
class SessionManager {
	const SESSION_EXPIRY = "session_expiry";
	const SESSION_ACCESS_TOKEN = "session_access_token";
	const SESSION_STATE = "session_state";
	const SESSION_CODE = "session_code";
	public function __construct() {
	}
	public function startSession() {
		if (session_status () == PHP_SESSION_NONE) {
			session_start ();
		}
	}
	public function setSessionName($sessionName) {
		session_name ( $sessionName );
	}
	public function setSessionExpiry($time) {
		$_SESSION [self::SESSION_EXPIRY] = $time;
	}
	public function getSessionExpiry() {
		return isset ( $_SESSION [self::SESSION_EXPIRY] ) ? $_SESSION [self::SESSION_EXPIRY] : null;
	}
	public function setSessionAcessToken($token) {
		$_SESSION [self::SESSION_ACCESS_TOKEN] = $token;
	}
	public function getSessionAcessToken() {
		return isset ( $_SESSION [self::SESSION_ACCESS_TOKEN] ) ? $_SESSION [self::SESSION_ACCESS_TOKEN] : null;
	}
	public function setSessionState($state) {
		$_SESSION [self::SESSION_STATE] = $state;
	}
	public function getSessionState() {
		return isset ( $_SESSION [self::SESSION_STATE] ) ? $_SESSION [self::SESSION_STATE] : null;
	}
	public function setSessionCode($code) {
		$_SESSION [self::SESSION_CODE] = $code;
	}
	public function getSessionCode() {
		return isset ( $_SESSION [self::SESSION_CODE] ) ? $_SESSION [self::SESSION_CODE] : null;
	}
	private function isExpiredSession() {
		return (isset ( $_SESSION [self::SESSION_EXPIRY] ) && (time () > $_SESSION [self::SESSION_EXPIRY]));
	}
	public function validateSession() {
		if ($this->isExpiredSession ())
			$this->destroySession ();
	}
	public function destroySession() {
		if (session_status () != PHP_SESSION_NONE) {
			session_unset ();
			session_destroy ();
			$_SESSION = null;
		}
	}
}

$x = new SessionManager ();
$x->getSessionState ();