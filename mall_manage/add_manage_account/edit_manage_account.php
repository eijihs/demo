﻿<?php
	require_once("../../conn/conn.php");
	$role=$_SESSION['role'];
	$shop_id=$_SESSION['shop_id'];
	$mall_id=$_SESSION['mall_id'];
	$id=$_SESSION['id'];
	if($role==2){
		$select="select * from mall where id='$mall_id'";
		$result=mysql_query($select);
		$row=mysql_fetch_array($result);
		$mall_name=$row['name'];
		$area="Manage Mall:".$mall_name;
	}else if($role==3){
		$select1="select name,mall_name from shop where id='$shop_id'";
		$result1=mysql_query($select1);
		//echo $select1;
		$row1=mysql_fetch_array($result1);
		$shop_name=$row1['name'];
		$mall_name=$row1['mall_name'];
		$area="Manage Store:".$mall_name."->".$shop_name;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> Modify Password</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css"/>
		<script type="text/javascript" src="../js/jquery-1.6.2.min.js"></script>
    	<script type="text/javascript" src="../js/upload.js"></script>
    	<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
	</head>
	<body>
	<div class="bgintor">
		<div class="tit1">
			<ul>				
				<li><a href="#">Account Manage</a> </li>
			</ul>		
		</div>
	<div class="listintor">
		<div class="header1">
			<span>Position:Account Manage －&gt; <strong>Modify Password</strong></span>
		</div>		
		<div class="fromcontent">
			<form action="edit_manage_account_do.php" method="post" id="doForm">
				<p>Username:<?=$_SESSION["name"]?></p>
				<input type="hidden" name="id" value=<?=$id?> />
				<p>Charactor:
					<select name="role" id="role" disabled="disabled">
						<option value="0">----Choose----</option>
						<option value="1" <?php echo ($role==1?"selected":"")?> >SuperAdmin</option>
						<option value="2" <?php echo ($role==2?"selected":"")?> >MallManager</option>
						<option value="3" <?php echo ($role==3?"selected":"")?> >StoreManager</option>				
					</select>
				</p>
				<p><?=$area?></p>
				<p>Password:<input type="password" name="password" id="password"/> </p>
				<p>Confirm:<input  onpaste="return false" type="password" name="password1" id="password1"/> </p>	
				<p><input type="button" class="confirm" value="确定" onclick="return check()"></p>
			</form>
		</div>
	</div>
  </div>
 </body>
</html>
<script>
$("input[name='name']").attr("value","<?=$account?>");
$("select[name='role']").find("option[value='<?=$role?>']").attr("selected",true);
form=document.getElementById("doForm");
function check()
{
	if(form.password.value=="")
	{
		alert('Input the password!');
		form.password.focus();
		return false;
	}
	if(form.password1.value=="")
	{
		alert('Confirm the passwrod!');
		form.password1.focus();
		return false;
	}
	if(form.password.value!=form.password1.value)
	{
		alert('Password inconformity!');
		form.password1.focus();
		return false;
	}
	form.submit();
}
</script>
