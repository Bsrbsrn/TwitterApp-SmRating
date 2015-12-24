<?php

session_start();
require('config.php');
require_once('twitteroauth/autoload.php');

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET_KEY);
try {
    $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => "http://anymaa.com/sosyalrozet/twitterapp/index.php"));

}
catch (Exception $e){
    echo $e;
}

switch ($connection->getLastHttpCode()) {
    case 200:

        $_SESSION['oauth_token'] = $request_token['oauth_token'];
        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];


        try{
            $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
            header('Location:'.$url);
        }
        catch(Exception $e){
            echo $e;
        }
        break;
    default:

        echo 'Could not connect to Twitter. Refresh the page or try again later.';
}


$access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
echo $_REQUEST['oauth_verifier'];
echo "<br>";
echo $access_token;




