<?php
	require_once("../../conn/conn.php");
	require_once("../inc_function.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css"/>
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script language="javascript" type="text/javascript" src="../js/My97DatePicker/WdatePicker.js"></script>
	</head>
	<body>
		<div class="bgintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">Classify according to the mall</a></li>
						<li class="l1"><a href="sum_order_shop.php" target="mainFrame">Classify according to the shops</a></li>
						<li class="l1"><a href="sum_order_good.php" target="mainFrame">Classify according to the goods</a></li>
					</ul>		
				</div>
				<div class="listintor">
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Location: the order management －&gt;<strong>Commodity statistics list</strong></span>
				</div>
				<div class="content">
					<form action="#" method ="post" name="listForm">
						<table width="100%">
							<tr class="t1">
							    <td width="15%">Shop ID</td>
								<td width="40%">Statistical information</td>
								<td width="10%">operation</td>	
							</tr>
<?php
$pagesize=20;
$select="select count(*) as page_count from mall";
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
$query="select id from mall limit ".$pagestart.",".$pagesize;
$res=mysql_query($query);
while($row=mysql_fetch_array($res)){
     $mall_id=$row['id'];
	 $query1="select count(order_id) as total from seckill_orderlist where mall_id=$mall_id and state=0";
     $res1=mysql_query($query1);
	 $row1=mysql_fetch_array($res1);
	 $query1="select count(order_id) as total from seckill_orderlist where mall_id=$mall_id and state=1";
     $res2=mysql_query($query1);
	 $row2=mysql_fetch_array($res2);
	 $query1="select count(order_id) as total from seckill_orderlist where mall_id=$mall_id and state=2";
     $res3=mysql_query($query1);
	 $row3=mysql_fetch_array($res3);
	 $query1="select count(order_id) as total from seckill_orderlist where mall_id=$mall_id and state=3";
     $res4=mysql_query($query1);
	 $row4=mysql_fetch_array($res4);
?>
							<tr>
								<td><?php echo $mall_id;?></td>   
								<td><a href="order_list_stats.php?state=0&type=mall&id=<?php echo $mall_id; ?>">No payment:
									<?php
										echo $row1["total"]?$row1["total"]:0;
								    ?>item</a>&nbsp;|&nbsp;<a href="order_list_stats.php?state=1&type=mall&id=<?php echo $mall_id; ?>">Payment:
									<?php
										echo $row2["total"]?$row2["total"]:0;
								    ?>item</a>&nbsp;|&nbsp;<a href="order_list_stats.php?state=2&type=mall&id=<?php echo $mall_id; ?>">Shipment:
									<?php
										echo $row3["total"]?$row3["total"]:0;
								    ?>item</a>&nbsp;|&nbsp;<a href="order_list_stats.php?state=3&type=mall&id=<?php echo $mall_id; ?>">Confirmed:
									<?php
										echo $row4["total"]?$row4["total"]:0;
								    ?>item</a>
								</td>
								<td>
								     <a href="order_list_stats.php?type=mall&id=<?php echo $mall_id; ?>">Check all order</a>
								</td>
								</tr>
							<?php }?>
						</table>
					</form>
					<?php	
						if($count==0){
							echo "<center><b>There is no relevant information!</b></center>";
						}else{
					?>
					<div class="page">
						<div class="pagebefore">Current page:<?php echo $page;?>/<?php echo $pagecount;?>page Each page <?php echo $pagesize?> one</div>
						<div class="pageafter">
						<?php echo showPage('sum_order.php',$page,$pagecount,"../images");?>
						<div class="clear"></div>
						</div>
					</div>
					<?php }?>
				</div>
			</div>
		</div>
	</body>
</html>
