<?php
class Config {
	private $config;
	private $uniqueId = null;
	public function __construct() {
		$this->config = parse_ini_file ( "config.inc" );
	}
	public function getRedirectUrl() {
		return $this->config ['REDIRECT_URI'];
	}
	public function getAPIKey() {
		return $this->config ['API_KEY'];
	}
	public function getAPISecret() {
		return $this->config ['API_SECRET'];
	}
	public function getSessionName() {
		return $this->config ['SESSION_NAME'];
	}
	public function getBaseUrl() {
		return $this->config ['LINKEDIN_BASE_URL'];
	}
	public function getOauthUrl() {
		return $this->config ['OAUTH_URL'];
	}
	public function getResponseType() {
		return $this->config ['RESPONSE_TYPE'];
	}
	public function getState() {
		if (! $this->uniqueId) {
			$this->uniqueId = uniqid ( '', true );
		}
		return $this->uniqueId;
	}
	public function getAuthCode() {
		return $this->config ['AUTH_CODE'];
	}
	public function getAccessTokenUrl() {
		return $this->config ['ACCESS_TOKEN_URL'];
	}
	public function getCacheExpiry() {
		return $this->config ['CACHE_FILE_EXPIRY_SECS'];
	}
	public function getScope() {
		return $this->config ['SCOPE'];
	}
}