<?php
include '../../autob/bt.php';
include '../../autob/basicbot.php';
include '../../autob/uacrawler.php';
include '../../autob/refspam.php';
include '../../autob/ipselect.php';
include "../../autob/bts2.php";
header("HTTP/1.0 404 Not Found");
logbot('SCANNER BOT');banbot();
die("<h1>404 Not Found</h1>The page that you have requested could not be found.");
exit();
?>