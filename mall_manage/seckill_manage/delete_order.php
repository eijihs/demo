<?php
	require("../../conn/conn.php");
	$id=$_POST["id"];
	$sql="delete from seckill_orderlist where order_id=$id";
	if(mysql_query($sql)){
		echo 1;
	}else{
		echo 0;
	}