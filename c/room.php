<?php
require 'database.php';
if(get_magic_quotes_gpc()){
	$room=htmlspecialchars($_POST['room'],ENT_QUOTES);
}else{
	$room=addslashes(htmlspecialchars($_POST['room'],ENT_QUOTES));
}
if(isset($_POST['exit'])){
	if(get_magic_quotes_gpc()){
		$name=htmlspecialchars($_POST['name'],ENT_QUOTES);
	}else{
		$name=addslashes(htmlspecialchars($_POST['name'],ENT_QUOTES));
	}
	$db->query("DELETE FROM userlist WHERE name='".$name."' AND room=".$room);
	die();
}
if(isset($_POST['name'])){
	if(get_magic_quotes_gpc()){
		$name=htmlspecialchars($_POST['name'],ENT_QUOTES);
		$gender=htmlspecialchars($_POST['gender'],ENT_QUOTES);
		$avatar=htmlspecialchars($_POST['avatar'],ENT_QUOTES);
		$namecolor=htmlspecialchars($_POST['namecolor'],ENT_QUOTES);
	}else{
		$name=addslashes(htmlspecialchars($_POST['name'],ENT_QUOTES));
		$gender=addslashes(htmlspecialchars($_POST['gender'],ENT_QUOTES));
		$avatar=addslashes(htmlspecialchars($_POST['avatar'],ENT_QUOTES));
		$namecolor=addslashes(htmlspecialchars($_POST['namecolor'],ENT_QUOTES));
	}
	$db->query("SELECT id FROM userlist WHERE name='".$name."' AND room=".$room);
	if(!$db->affected_rows){
    	date_default_timezone_set('Asia/Chongqing');
		$time=time();
		$db->query("INSERT INTO userlist (name,gender,avatar,namecolor,room,uid) VALUES ('".$name."','".$gender."','".$avatar."','".$namecolor."','".$room."','".$time."')");
	}
}
$fetch=$db->query("SELECT * FROM userlist WHERE room=".$room);
$num=$db->affected_rows;
$str='';
$arr=array('avatar','name','gender','namecolor');
for($i=0;$i<$num;$i++){
$fetch2=$fetch->fetch_assoc();
$str2='';
foreach ($arr as $key => $value) {
	$str2.=','.$value.':"'.$fetch2[$value].'"';
}
$str2='{'.substr($str2,1).'}';
$str.=',u'.$i.':'.$str2;
}
echo '{'.substr($str,1).'}';
$db->close();
?>