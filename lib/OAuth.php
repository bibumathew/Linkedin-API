<?php
class OAuth {
	const CODE = "code";
	const GRANT_TYPE = "grant_type";
	const AUTH_CODE = "authorization";
	const RESPONSE_TYPE = "response_type";
	const CLIENT_ID = "client_id";
	const SCOPE = "scope";
	const REDIRECT_URI = "redirect_uri";
	const STATE = "state";
	const CLIENT_SECRET = "client_secret";
	private $config;
	private $sessionManager;
	public function __construct(Config $config, SessionManager $sessionManager) {
		$this->config = $config;
		$this->sessionManager = $sessionManager;
	}
	private function getAuthParams() {
		return [ 
				OAuth::RESPONSE_TYPE => $this->config->getResponseType (),
				OAuth::CLIENT_ID => $this->config->getAPIKey (),
				OAuth::SCOPE=> $this->config->getScope(),
				OAuth::STATE => $this->config->getState (),
				OAuth::REDIRECT_URI => $this->config->getRedirectUrl () 
		];
	}
	private function buildOAuthUrl() {
		$query = http_build_query ( $this->getAuthParams () );
		return $this->config->getOauthUrl () . $query;
	}
	public function getAuthorizationCode() {
		$this->sessionManager->setSessionState ( $this->config->getState () );
		$url = $this->buildOAuthUrl ();
		header ( "Location: $url" );
		exit ();
	}
	private function getAccessParams() {
		return [ 
				OAuth::GRANT_TYPE => $this->config->getAuthCode (),
				OAuth::CLIENT_ID => $this->config->getAPIKey (),
				OAuth::CLIENT_SECRET => $this->config->getAPISecret (),
				OAuth::CODE => $this->sessionManager->getSessionCode (),
				OAuth::REDIRECT_URI => $this->config->getRedirectUrl () 
		];
	}
	private function buildAccessTokenUrl() {
		$query = http_build_query ( $this->getAccessParams () );
		return $this->config->getAccessTokenUrl () . $query;
	}
	private function makeRequest($opts, $url) {
		$context = stream_context_create ( $opts );
		return file_get_contents ( $url, false, $context );
	}
	public function getAccess() {
		$opts = [ 
				'http' => [ 
						'method' => 'POST' 
				] 
		];
		$token = json_decode ( $this->makeRequest ( $opts, $this->buildAccessTokenUrl () ) );
		
		// Store access token and expiration time
		$this->sessionManager->setSessionAcessToken ( $token->access_token );
		$this->sessionManager->setSessionExpiry ( time () + $token->expires_in );
	}
	public function fetchAPI($url, $method = "GET") {
		$opts = [ 
				'http' => [ 
						'method' => $method,
						'header' => "Authorization: Bearer " . $this->sessionManager->getSessionAcessToken () . "\r\n" . "x-li-format: json\r\n" 
				] 
		];
		
		return json_decode ( $this->makeRequest ( $opts, $url ) );
		;
	}
}


