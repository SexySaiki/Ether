<?php
header('Content-Type:text/html;charset=utf-8');
header('Access-Control-Allow-Origin: *');

$db=new mysqli('localhost','hitokoto','yx0205','hitokoto');
$db->query("SET NAMES utf8");
$arr=[];
if($result=$db->query("SELECT word,author,source,type FROM hitokoto")){
	for($i=0;$i<$db->affected_rows;++$i){
		$arr[]=$result->fetch_assoc();
	}
}
$arr2=$arr[array_rand($arr)];
$type=['动漫','小说'];
$arr2['type']=$type[$arr2['type']];
echo json_encode($arr2);
