<?php
require_once 'manage.php';
// Congratulations! You have a valid token. Now fetch your profile 
$user = fetch('GET', '/v1/people/~:(firstName,lastName)');
print "Hello $user->firstName $user->lastName.";
$users = fetch('GET', '/v1/people/~/connections');
echo "<pre>"; 
print_r($users);
/* $serialize = serialize($users);
file_put_contents("dat.txt",$serialize); */
echo "</pre>";
exit;
 

 
function fetch($method, $resource, $body = '') {
   /*  print $_SESSION['access_token']; */
 
    $opts = array(
        'http'=>array(
            'method' => $method,
            'header' => "Authorization: Bearer " . $_SESSION['access_token'] . "\r\n" . "x-li-format: json\r\n"
        )
    );
 
    // Need to use HTTPS
    $url = 'https://api.linkedin.com' . $resource;
 
    // Append query parameters (if there are any)
  
 
    // Tell streams to make a (GET, POST, PUT, or DELETE) request
    // And use OAuth 2 access token as Authorization
    $context = stream_context_create($opts);
 
    // Hocus Pocus
    $response = file_get_contents($url, false, $context);
 
    // Native PHP object, please
    return json_decode($response);
}
