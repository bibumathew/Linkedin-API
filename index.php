<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Linkedin API Test</title>
</head>

<body>
<?php
require_once 'manage.php';
if (isset ( $_GET ['clear'] )) {
	session_destroy ();
	$_SESSION = null;
	$url = "http://localhost/linkedin";
	header ( "Location: $url" );
}
?>
<p>Please use https for testing rest API calls
 <a	href "https://developer.linkedin.com/apis" target="_blank">Reference</a>
	<br /> 
	<a href="index.php?clear=true">Clear Session</a>
</p>
<form name="api_link" method="post" action="index.php" />
	<textarea rows="4" cols="50" name="comment"
		placeholder="Enter linkedin API URL...">
		<?php
		
if (isset ( $_POST ['comment'] )) {
			echo $_POST ['comment'];
		}
		?>
</textarea>
	<br />
	<input type="submit">
</form>

<div>
	
<?php
if (isset ( $_POST ['comment'] )) {
	$url = trim ( $_POST ['comment'] );
	$resultData = $oAuth->fetchAPI ( $url );
	echo "<pre>";
	echo json_encode ( $resultData, JSON_PRETTY_PRINT );
	echo "</pre>";
}
?>
</div>


</body>

</html>



