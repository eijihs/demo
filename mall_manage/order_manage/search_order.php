﻿<?php
	require_once("../../conn/conn.php");
	require_once("../inc_function.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css"/>
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script>
		$(function(){
			$(".delete").click(function(){
				if(confirm("Confirm to delete?")){
					var id=$(this).parents("tr").attr("id");
					$.post("delete_order.php",{id:id},function(data){
						if(data==1){
							alert("Delete success");
							location.reload();
						}else{
							alert("UnKown error,please try later");
						}
					})
				}
			});
		});
		</script>
		<script language="javascript" type="text/javascript" src="../js/My97DatePicker/WdatePicker.js"></script>
	</head>
	<body>
		<div class="bgintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">OrderManage</a></li>
					</ul>		
				</div>
				<div class="listintor">
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Position:OrderManage －&gt;<strong>CheckOrders</strong></span>
				</div>
				<div class="content">
					<form action="#" method ="post" name="listForm">
						<table width="100%">
							<tr class="t1">
							    <td width="5%">OrderNo.</td>
								<td width="5%">GuestNo.</td>
								<td width="5%">MallNo.</td>
								<td width="5%">ShopNo.</td>
								<td width="5%">Goodsno.</td>
								<td width="5%">Amount</td>
								<td width="5%">TotalPrice</td>
								<td width="5%">GuestName</td>								
							    <td width="5%">Receiver</td>							
							    <td width="5%">Address</td>
								<td width="5%">Contacts</td>
								<td width="5%">State</td>
							    <td width="5%">OrderTime</td>
								<td width="5%">Operation</td>
							</tr>
							<?php
								$pagesize=20;							
								$select="select count(order_id) as page_count from order_manage";
								$rest=mysql_query($select);
								$rs=mysql_fetch_array($rest);
								$count=$rs['page_count'];						
								if($count%$pagesize){
									$pagecount = intval($count/$pagesize)+1;
								}else{
									$pagecount = intval($count/$pagesize);
								}
								if(isset($_GET['page'])){
									$page=intval($_GET['page']);
								}else{
									$page=1;
								}
								$pagestart = ($page-1)*$pagesize;
								switch($_SESSION["role"]){
									case 1:
										$query="select order_id,user_id,mall_id,shop_id,good_id,num,price,username,rec_name,address,phone,state,time from order_manage order by order_id desc limit ".$pagestart.",".$pagesize;									
										break;
									case 2:
										$query="select order_id,user_id,mall_id,shop_id,good_id,num,price,username,rec_name,address,phone,state,time from order_manage where mall_id=$_SESSION[mall_id] order by order_id desc limit ".$pagestart.",".$pagesize;									
										break;
									case 3:
										$query="select order_id,user_id,mall_id,shop_id,good_id,num,price,username,rec_name,address,phone,state,time from order_manage where shop_id=$_SESSION[shop_id] order by order_id desc limit ".$pagestart.",".$pagesize;									
										break;
									case 4:
										$query="select order_id,user_id,mall_id,shop_id,good_id,num,price,username,rec_name,address,phone,state,time from order_manage where user_id=$_SESSION[id] order by order_id desc limit ".$pagestart.",".$pagesize;								
										break;									
								}
								$res=mysql_query($query);
								while($row=mysql_fetch_array($res)){
							?>
							<tr id="<?php echo $row["order_id"];?>">		 
								<td><?php echo $row["order_id"] ?></td>
								<td><?php echo $row["user_id"] ?></td>
								<td><?php echo $row["mall_id"] ?></td>
								<td><?php echo $row["shop_id"] ?></td>
								<td><?php echo $row["good_id"] ?></td>
								<td><?php echo $row["num"] ?></td>
								<td><?php echo $row["price"] ?></td>								
								<td><?php echo $row["username"] ?></td>
								<td><?php echo $row["rec_name"] ?></td>
								<td><?php echo $row["address"] ?></td>
								<td><?php echo $row["phone"] ?></td>
								<td>
							<?php
								switch($row["state"]){
									case 0:
										echo "NotPaied";
										break;
									case 1:
										echo "Paied,receiving";
										break;
									case 2:
										echo "Received";
										break;
									case 3:
										echo "Checking";
										break;
								}
							?>
								</td> 
								<td><?php echo $row["time"] ?></td> 
							<?php/*
								if($_SESSION["role"]==1){
									echo'<td><a href="#" target="mainFrame" class="delete">删除</a></td>';
								}
								*/
							?>
							</tr>
							<?php }?>
						
						</table>
					</form>
					<?php	
						if($count==0){
							echo "<center><b>No such information!</b></center>";
						}else{
					?>
					<div class="page">
						<div class="pagebefore">Current:<?php echo $page;?>/<?php echo $pagecount;?>Page EveryPage <?php echo $pagesize?> Items</div>
						<div class="pageafter">
						<?php echo showPage("search_order.php",$page,$pagecount,"../images");?>
						<div class="clear"></div>
						</div>
					</div>
					<?php }?>
				</div>
			</div>
		</div>
	</body>
</html>