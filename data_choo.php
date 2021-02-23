<?php
	require_once('page_left.php');
?>
	<div class="page_r">
		<h3><span id='title'><?php echo $page_title ?></span></h3>
		<div class="rq">
			<div class="table">
				<table>
					<tr>
						<th style="width:50px;">ID</th>
						<th>文件名</th>
						<th>操作</th>
					</tr>
					<tbody class="innerbox"  id="data_rq"></tbody>
				</table>
			</div>		
			<div class="choo_pack">
				<div class="info">当前共查询到<b id="len"> 0 </b>个备份</div>
				<a class="btn" id="data_back_btn"><i class="iconfont icon-daochu"></i>数据备份</a>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>

<script src="libs/j.js"></script>
<script src="libs/a.js"></script>
<script type="text/javascript">
	$(function(){
		$('#data_back_btn').hide();
		data_aj();
	});
	function data_aj() {
		$.ajax({
			url: ajax_url,
			data:{
				fa:'data_choo',
				fu:'data_list'
			},
			beforeSend:function(){
				$('#data_rq').html('<img class="page_right_laoding" src="libs/laoding.gif">');
			},
			success: function (result){
				console.log(result);
				if(result[0]==null){
					$('#data_back_btn').show();
					$('#data_rq').html('<div class="page_right_qs_no">没有数据</div>');
				}else{
					data_play(result);	
				};
			},
			error:function(xhr,status,error){
				console.log(status);
			}
		});
	};

	function data_play(data){
		let h = '';
		h+=''
		for (var i = 0; i < data.length; i++) {
			h +=''
			+'<tr>'
			+'<td style="width:50px;">'
			+i
			+'</td>'
			+'<td>'
			+data[i]
			+'</td>'
			+'<td>'
			+'<a class="btn data_delete_btn" data-id="'+i+'"><i class="iconfont icon-shanchu"></i>删除</a>'
			+'</td>'
			+'</tr>'
		};
		h+=''
		$('#data_rq').html(h);
		$('.choo_pack #len').html(data.length);
		$('.data_delete_btn').on('click',function() {
			alert('权限验证失败，不能删除！');
		});
		$('#data_back_btn').show();
	};

	$('#data_back_btn').click(function(){
		$('#data_back_btn').hide();
		$.ajax({
			url: ajax_url,
			data:{
				fa:'data_choo',
				fu:'data_back'
			},
			beforeSend:function(){
				$('#data_rq').html('<img class="page_right_laoding" src="libs/laoding.gif">');
			},
			success: function (result){
				console.log(result);
				alert('操作成功！');
				data_aj();
			},
			error:function(xhr,status,error){
				console.log(status);
			}
		});			
	});

</script>
</body>
</html>

