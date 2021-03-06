﻿<?php 
/**
*一级分类显示
*
*/
	require_once("../../conn/conn.php");
	//一级分类
	
	//当前是几级分类
	$type=1;
	$id=0;
	//显示各自管理权限下的分类
	if($_SESSION["role"]==1){
		$where=" where typebelong=0";
	}else{
		$where=" where typebelong=$_SESSION[mall_id]";
	}
	//echo $where;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="../js/upload.js"></script>
	</head>
	<body>
		<div class="bgintor">
	<div class="tit1">
					<ul>				
						<li><a href="#">Commodity classification</a></li>
					</ul>		
				</div>		
			<div class="listintor">
				
				<div class="header1">
					<span>Location: Commodity management －&gt; Commodity classification－&gt; <strong>First classification</strong></span>
				</div>
				<div class="content">
					<form action="add_type_do.php" method="post" id="doForm">
						<p>Classification name:<input class="in1" type="text" name="goods_type"/></p><br/>
						<p>Classification weight：<input class="in1 weight" type="text" name="weight" />(Please input between 1 to 9999, the larger floor front the top, the default is 1)</p><br/>
						<p>Classification LOGO upload: 
						 <input type="hidden" name="img_url" id="image_url">
						 <span id="upd_pics" name=""></span>
						 <input type="file" name="file" id="file_image"/>
							<span id="loading_image" style="display:none;">
							<img src="../images/loading.gif" alt="loading...">
							</span>
							<span id="logo_image"></span>
							<input type="button" value="Upload"  class="confirm" onclick="return ajaxFileUpload('image');" 
							class="btn btn-large btn-primary" />(*LOGO size：Less than 500*500)
						</p>	
						<p><input type="checkbox" name="display"/>Whether show the home page classification</p><br/>
						<input type="button" value="Sure to add" onclick="return check()" class="confirm"></p>
						<input type="hidden" value="<?=$type?>" name="type">
						<input type="hidden" value="<?=$id?>" name="id">
					</form>
					<form action="modify_type_do.php" method="post" id="replace" style="display:none;">
						<p>Classification name:<input class="in1" type="text" name="goods_type"/></p><br/>
						<p>Classification weight：<input class="in1 weight" type="text" name="weight" />(Please input between 1 to 9999, the larger floor front the top, the default is 1)</p><br/>
						<p>分类LOGO：<img class="logo" src="" name="11"/></p>
						<p>Classification LOGO upload: 
						 <input type="hidden" name="img_url" id="image_url">
						 <span id="upd_pics" name=""></span>
						 <input type="file" name="file" id="file_image"/>
							<span id="loading_image" style="display:none;">
							<img src="../images/loading.gif" alt="loading...">
							</span>
							<span id="logo_image"></span>'
							<input type="button" value="Upload" onclick="return ajaxFileUpload('image');" 
							class="btn btn-large btn-primary" />(*LOGO size：Less than 500*500)
						</p>	
						<p><input type="checkbox" name="display"/>Whether show the home page classification</p><br/>
						<input type="button" value="Sure to modify" onclick="return checks()" class="confirm"></p>
						<input type="hidden" value="<?=$type?>" name="type">
						<input type="hidden" value="<?=$id?>" name="id">
					</form><br>
					<table style="width:100%">
						<tr class="t1">
							<td style="10%">Number</td>
							<td style="10%">Classification LOGO</td>						
							<td style="10%">Classification name</td>
							<td style="10%">Classification weight</td>
							<td style="10%">Home page displays</td>
							<td style="10%">Operation</td>
						</tr>
						<?php
						//查看商场的分类
						$select="select * from goods_type1".$where." order by weight desc";
						//echo $select;
						$res=mysql_query($select);
						while($row=mysql_fetch_array($res)){
							$type1_id=$row['id'];
							$type1_name=$row['name'];
						?>
							<tr>
								<td class="id"><?php echo $type1_id ?></td>
								<td class="logo"><img src="<?php echo $row["logo"] ?>" /></td>
								<td class="name"><?php echo $type1_name?></td>
								<td class="weight"><?php echo $row["weight"]?></td>
								<td class="display"><?php echo $row["display"]==1?"Display":"Not Displayed";?></td>
								<td><a href="#" class="modify">Modify</a>|<a href="goods_type2.php?id=<?=$type1_id?>&type1_name=<?=$type1_name?>">View the subclass</a>|<a href="javascript:void(0);" onclick="delete_foods(<?php echo $type1_id?>)">Delete</a></td>
							</tr>
						<?php
						}
						?>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>
<script>
$(function(){
	$(".modify").click(function(){
		$("#doForm").remove();
		var $parent=$(this).parent("td");
		var id=$parent.siblings(".id").text();
		var logo=$parent.siblings(".logo").children("img").attr("src");
		var name=$parent.siblings(".name").text();
		var weight=$parent.siblings(".weight").text();
		var display=$parent.siblings(".display").text();
		var $replace=$("#replace");
		$replace.children("input[name='id']").val(id);
		$replace.find("input[name='goods_type']").val(name);
		$replace.find(".logo").attr("src",logo);
		$replace.find(".weight").val(weight);
		if(display=="显示"){
			$replace.find(":checkbox").attr("checked","checked");	
		}else{
			$replace.find(":checkbox").removeAttr("checked");
		}
		$replace.show();
		return false;
	});
	$(".weight").keyup(function(){
		var val=$(this).val();
		if(val!=""&&(val<1||val>9999)){
			alert("请输入合法的数！");
			$(this).val("");
			//return false;
		}
	});
});
//添加商品分类时的检查
form=document.getElementById("doForm");
function check()
{
	if(form.goods_type.value=="")
	{
		alert('请填写分类名称！');
		form.name.focus();
		return false;
	}else{
		form.submit();
	}	
}
function delete_foods(id){
	if(confirm("确认删除吗")){
			$.post("delete_foods_do.php",
				{
					goods_id:id
				},
				function(data,status){
					if(data==1){
						alert("删除成功!");
						location.reload();
					}else{
						alert("删除失败");
					}
				}
			);
	}
}
function ajaxFileUpload(file_type)
{
	var doing = '';
	$("#loading"+"_"+file_type).ajaxStart(function()
	{
		$(this).show();
		$("#logo"+"_"+file_type).html("上传中……");
	})
	.ajaxComplete(function(){
		$(this).hide();
		$("#logo"+"_"+file_type).html("");
	});
	$.ajaxFileUpload
	(
		{
		url:'../shop_manage/upload_image.php?type=' + file_type,
		secureuri:false,
		fileElementId:'file'+'_'+file_type,
		dataType: 'json',
		data:{},
		success: function (data, status)
		{
			data=data.replace('<pre>','');
			data=data.replace('</pre>','');
			var info=data.split('|');
			if(info[0]=="E")
			{
				alert(info[1]);
			}
			else
			{
				var c = document.getElementById('upd_pics').innerHTML;
					document.getElementById('upd_pics').innerHTML= c + 
                        		"<p><img src='"+ info[1] +"' width='100'> <input type='checkbox' checked name='pics[]' value="+ info[1] +" /> "+info[1]+
                        		"</p>";
			}
			
		},
		error: function (data, status, e)
		{
			 alert(e);
		}
	}
	
	)
	return false;
}
//修改商品分类时的检查
forms=document.getElementById("replace");
function checks()
{
	if(forms.goods_type.value=="")
	{
		alert('请填写分类名称！');
		forms.name.focus();
		return false;
	}else{
		forms.submit();
	}	
}
</script>