<?php
	//首页焦点图管理
	
	
	require("../../conn/conn.php");
	require_once("../inc_function.php");
	//$area="where role=".$_SESSION["mall_id"];
	$area="";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>预售管理</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script>
		/*$(function(){
			
		})
		*/
		function delete_focus(id){
			if(confirm("确认删除")){
				$.ajax({
					data:"id="+id,
					type:"POST",
					url:"delete_focus.php",
					success:function(msg){
						alert(msg);
						location.reload();
					}
				})
			}
		}
		</script>
	</head>
	<body>
		<div class="bgintor">				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">预售管理</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>位置：预售管理 －&gt; <strong>焦点图管理</strong></span>
				</div>
				<div class="content">
					<table width="100%">
						<tr class="t1">
							<td width="5%">焦点图编号</td>
							<td width="5%">跳转链接</td>
							<td width="10%">权重</td>
							<td width="10%">图片</td>
							<td width="10%">操作</td>
						</tr>
						<?php
							$pagesize=20;							
							$select="select count(*) as page_count from book_focus ".$area;
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
							$sql1="select * from book_focus ".$area." order by weight desc limit ".$pagestart.",".$pagesize;
							$result1=mysql_query($sql1);
							while($row1=mysql_fetch_array($result1))
							{	
								$id=$row1['id'];
								$weight=$row1["weight"];
								$link_url=$row1['link_url'];
								$image_url=$row1["image_url"];
						?>
						<tr>
							<td><?php echo $id?></td>
							<td><?php echo $link_url?></td>
							<td><?php echo $weight?></td>
							<td><img src="<?php echo $image_url?>"/></td>
							<td>
								<a href="javascript:void(0);" onclick="delete_focus(<?php echo $id;?>)">删除</a>
							</td>
						</tr>
						<?php
							}	
						?>
					</table>
					<?php	
						if($count==0){
							echo "<center><b>没有相关信息！</b></center>";
						}else{
					?>
					<div class="page">
						<div class="pagebefore">当前页:<?php echo $page;?>/<?php echo $pagecount;?>页 每页 <?php echo $pagesize?> 条</div>
						<div class="pageafter">
						<?php echo showPage("check_goods.php",$page,$pagecount,"../images");?>
						<div class="clear"></div>
						</div>
					</div>
					<?php }?>
				</div>
			</div>	
		</div>
	</body>
</html>