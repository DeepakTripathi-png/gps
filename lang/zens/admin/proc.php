<?php

if(isset($_POST['toggle'])){
		$ud=file_get_contents('db.json');
		$udarray = json_decode($ud,true);
		$narr=array();
		foreach($udarray as $key=>$value){$narr[$key]=$value;};
		if($narr['status'] == 'on'){
			$narr['status'] = 'off';}
		else{$narr['status'] = 'on';};
		file_put_contents('db.json',json_encode($narr));
		header('location:index?ston='.md5(rand(100,999999)));};
		
if(isset($_POST['clear'])){
		$narr=array('visits'=>0,'bots'=>0,'humans'=>0,'status'=>'on','ips'=>array());
		file_put_contents('db.json',json_encode($narr));
		file_put_contents('bots.txt','');
		file_put_contents('results.txt','');
		file_put_contents('yo.txt','');
		header('location:index?st='.md5(rand(100,999999)));};
		
		
		
		
		
		
		?>