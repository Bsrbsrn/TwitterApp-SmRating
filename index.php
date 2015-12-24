<?php
header('Content-type: text/html; charset=utf-8');
session_start();
require('config.php');
require_once('twitteroauth/autoload.php');
require_once('TwitterAPIExchange.php');

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET_KEY);

if (!$_SESSION['access_token']) {
    ?>
	<h1 align="center">SOSYAL MEDYA PUANLAMA</h1>
    <form align="center" action="redirect.php" method="get"> 
		<button type="submit">
			<img src="https://bothell.recruiter.uw.edu/Undergrad/images/Bothell/Twitter-Icon.png?width=75&height=75" width="100px" height="100px" >
		</button> 
	</form>
	<form align="center">
		<a href="redirect.php" align="left"><strong>Twitter İle Bağlan :)</strong></a>
		<a href="https://twitter.com/?lang=tr" align="right"><strong>Çıkış Yap:(</strong></a>
	</form>
<?php
} else {
    ?>
	<form align="center" action="redirect.php" method="get"> 
		<button type="submit">
			<img src="https://bothell.recruiter.uw.edu/Undergrad/images/Bothell/Twitter-Icon.png?width=75&height=75" width="100px" height="100px" >
		</button> 
	</form>
	<form align="center">
		<a href="redirect.php" align="left"><strong>Twitter İle Bağlan :)</strong></a>
		<a href="https://twitter.com/?lang=tr" align="right"><strong>Çıkış Yap:(</strong></a>
	</form>
<?php
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <title>Smrating Twitter</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
	<!--Menü-->
	<div class="container">
		<h3>Sosyal Rozet :D</h3>
		<ul class="nav nav-tabs">
			<li class="active"><a href="#profile">Profil</a>
			</li>
			<li>
			<a data-toggle="tab" href="#friends">Takip Edilenler</a>
			</li>
		</ul>
	</div>
	
	<div class="tab-content">
	  <div id="#profil" class="tab-pane fade in active">
		<form action="#" method="get"> 
			<div class="row">
				<div class="col-md-9" align="left" style="padding:120px">
					<?php
					function array_value_recursive($key, array $arr){
						$val = array();
						array_walk_recursive($arr, function($v, $k) use($key, &$val){
							if($k == $key) array_push($val, $v);
						});
						return count($val) > 1 ? $val : array_pop($val);
					}
					if ($_REQUEST['oauth_verifier']) {
						$request_token = [];
						$request_token['oauth_token'] = $_SESSION['oauth_token'];
						$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

						$connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET_KEY, $request_token['oauth_token'], $request_token['oauth_token_secret']);

						$access_token = $connection->oauth('oauth/access_token', array("oauth_verifier" => $_REQUEST['oauth_verifier']));
						$access_token['oauth_token'];

						if ($connection->getLastHttpCode() == 200) {

							$_SESSION['access_token'] = $access_token;
							$connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET_KEY, $access_token['oauth_token'], $access_token['oauth_token_secret']);														
							
							$params = array('include_entities'=>'false');
							$data = $connection -> get('account/verify_credentials',$params);
							//$count2 = count($data);
							//echo "count of data".$count2."</br>";
							//print_r($data);
							
							echo "Name: ".$data->name."</br>";
							echo "Username: ".$data->screen_name."</br>";
							echo "Photo: <img src='".$data->profile_image_url."'/></br></br>";
							echo "ID: ".$data->id."</br>";
							echo "Location: ".$data->location."</br>";
							echo "Description: ".$data->description."</br>";
							echo "Friends Count: ".$data->friends_count."</br>";
							echo "Favourites tweet Count: ".$data->favourites_count."</br>";
							echo '<br><br><br>';
							
							$count = $data -> statuses_count;
							echo "Twit sayısı: ".$count."</br>";	//toplam twit sayım
														
							$user_info = $connection->get("statuses/user_timeline", array("count" => $count, "exclude_replies" => true));
							//echo '<br><br><br>';
							$count2 = count($user_info);
							echo "user_info tweet count: ".$count2."</br></br>";
							
							for($i=0;$i<$count2;$i++){
								echo $user_info[$i]->text;
								echo '<br>';
								echo $user_info[$i]->id;
								echo '<br>';
							}
							
							//son follow yaptığın kişiyi getirdi
							//$friends_list = $connection->get('friends/list');
							//$count = count($friends_list);
							//print_r($count);
							//print_r($friends_list);
							
							//arakadaşlar listesi
							//$friends_info = $connection->get('friends/list');
							//echo $friends_info[0]->screen_name;
							//$count2 = count($friends_info);
							
							//for($i=0;$i<$count;$i++){
								//echo $friends_info[$i]->text;
								//echo '<br>';
							//}
							
							//anasayfa zamantünelini getiriyor
							//$home_tmln = $connection->get('statuses/home_timeline');
							//$count2 = count($home_tmln);
							//for($i=0;$i<$count2;$i++){
								//echo $home_tmln[$i]->text;
								//echo '<br>';
							//}

							unset($_SESSION['oauth_token']);
							unset($_SESSION['oauth_token_secret']);
						} else {
							echo "hata";
						}

						unset($_SESSION['access_token']);
					}
					unset($_SESSION['access_token']);
					?>
				</div>
				<div class="col-md-3" align="right" style="padding:120px">
					<button type="submit">Rozet İsteği</button>
				</div>
			</div>
		</form>
	  </div>
	  
	  <div id="#friends" class="tab-pane fade">
		<form action="#" method="get">  
			<div class="row">
				<div class="col-md-9" align="left" style="padding:120px">
				</div>
				<div class="col-md-3" align="right" style="padding:120px">
					<button type="submit">Rozet İsteği</button>
				</div>
		</form>
	  </div>
	</div>
</body>
</html>


