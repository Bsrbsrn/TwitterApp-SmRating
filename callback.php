
<?php
/*
session_start();
require('config.php');
require_once('twitteroauth/autoload.php');

use Abraham\TwitterOAuth\TwitterOAuth;

$request_token = [];
$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

$connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET_KEY, $request_token['oauth_token'], $request_token['oauth_token_secret']);

$access_token = $connection->oauth('oauth/access_token', array("oauth_verifier" => $_REQUEST['oauth_verifier']));

if($connection->getLastHttpCode() == 200){

    $_SESSION['access_token'] = $access_token;
    unset($_SESSION['oauth_token']);
    unset($_SESSION['oauth_token_secret']);
}else{
    echo "hata";
}

*/