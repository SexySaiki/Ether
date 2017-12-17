<?php
require 'database.php';
$num=$_POST['num'];
$room=$_POST['room'];
if(isset($_POST['name'])){
	if(get_magic_quotes_gpc()){
		$name=htmlspecialchars($_POST['name'],ENT_QUOTES);
		$gender=htmlspecialchars($_POST['gender'],ENT_QUOTES);
		$avatar=htmlspecialchars($_POST['avatar'],ENT_QUOTES);
		$msg=htmlspecialchars($_POST['msg'],ENT_QUOTES);
		$namecolor=htmlspecialchars($_POST['namecolor'],ENT_QUOTES);
		$msgcolor=htmlspecialchars($_POST['msgcolor'],ENT_QUOTES);
	}else{
		$name=addslashes(htmlspecialchars($_POST['name'],ENT_QUOTES));
		$gender=addslashes(htmlspecialchars($_POST['gender'],ENT_QUOTES));
		$avatar=addslashes(htmlspecialchars($_POST['avatar'],ENT_QUOTES));
		$msg=addslashes(htmlspecialchars($_POST['msg'],ENT_QUOTES));
		$namecolor=addslashes(htmlspecialchars($_POST['namecolor'],ENT_QUOTES));
		$msgcolor=addslashes(htmlspecialchars($_POST['msgcolor'],ENT_QUOTES));
	}
    date_default_timezone_set('Asia/Chongqing');
	$time2=time();
	$time=date('Y-m-d H:i',$time2);
	$db->query("INSERT INTO msg (name,gender,avatar,msg,namecolor,msgcolor,room,time,uid) VALUES ('".$name."','".$gender."','".$avatar."','".$msg."','".$namecolor."','".$msgcolor."','".$room."','".$time."','".$time2."')");
}
$db->query("SELECT * FROM msg WHERE room='".$room."'");
$n=$db->affected_rows;
if($num==$n){die();}
if($num=='f'){
$number=10;
$fetch=$db->query("SELECT * FROM msg WHERE room=".$room." ORDER BY id DESC LIMIT 10");
}else{
$number=abs($num-$n);
$fetch=$db->query("SELECT * FROM msg WHERE room='".$room."' ORDER BY id DESC LIMIT ".$number);
}
$str='';
$arr=array('avatar','name','gender','msg','namecolor','msgcolor','time');
for($i=0;$i<$number;$i++){
$fetch2=$fetch->fetch_assoc();
$str2='';
foreach ($arr as $key => $value) {
	$str2.=','.$value.':"'.$fetch2[$value].'"';
}
$str2='{'.substr($str2,1).'}';
$str.=',m'.$i.':'.$str2;
}
echo '{'.substr($str,1).',msgnum:'.$n.'}';
$db->close();
?>