<?php
	require_once('page_left.php');
?>
	<div class="page_r">
		<h3><span><?php echo $page_title ?></span></h3>
		<div class="rq">
			<div class="table">
				<table>
					<tr>
						<th style="width:50px;">ID</th>
						<th>用户</th>
						<th>权限</th>
						<th>操作</th>
					</tr>
					<tbody class="innerbox"  id="data_rq"></tbody>
				</table>
			</div>
			<div class="choo_pack"></div>
		</div>
	</div>
	<div class="clear"></div>
</div>
<div class="page_right">
	<div class="mass"></div>
	<div class="rq">
		<h3></h3>
		<div class="pack">

			<input id="prpi_0" value="" style="display:none;"></input>
			<label class="user_edit">用户名</label>
			<input class="user_edit" id="prpi_1" value="" autocomplete="off"></input>
			<label class="user_edit">权限</label>
			<input class="user_edit" id="prpi_2" value="" autocomplete="off"></input>

			<label class="pass_edit new_user">输入密码</label>
			<input class="pass_edit new_user" id="prpi_3" value="" type="password" autocomplete="off"></input>
			<label class="pass_edit">新的密码</label>
			<input class="pass_edit" id="prpi_4" value="" type="password" autocomplete="off"></input>
			<label class="pass_edit new_user">再次输入</label>
			<input class="pass_edit new_user" id="prpi_5" value="" type="password" autocomplete="off"></input>

			<div class="clear"></div>

		</div>
		<div class="btn_arr">
			<div class="btn ok">
				<i class="iconfont icon-duihao"></i>
				<i class="iconfont icon-jiazai_shuang rotate" style="display:none;"></i>
				确认
			</div>
			<div class="btn exit"><i class="iconfont icon-guanbi"></i>取消</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<script src="libs/j.js"></script>
<script src="libs/a.js"></script>
<script type="text/javascript">
	$(function(){
		data_aj();
	});
	function data_aj() {
		$.ajax({
			url: ajax_url,
			data:{
				fa:'admin_user',
				fu:'list'
			},
			beforeSend:function(){
				$('#data_rq').html('<img class="page_right_laoding" src="libs/laoding.gif">');
			},
			success: function (result){
				console.log(result);
				data_play(result);
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
			+data[i].id
			+'</td>'
			+'<td>'
			+data[i].name
			+'</td>'
			+'<td>'
			+data[i].type
			+'</td>'
			+'<td>'
			+'<a class="btn user_edit_btn" data-id="'+data[i].id+'" data-name="'+data[i].name+'" data-type="'+data[i].type+'"><i class="iconfont icon-bianji"></i>权限</a>'

			+'<a class="btn pass_edit_btn" data-id="'+data[i].id+'"><i class="iconfont icon-suoding"></i>密码</a>'

			+'<a class="btn user_delete_btn" data-id="'+data[i].id+'"><i class="iconfont icon-shanchu"></i>删除</a>'	

			+'</td>'
			+'</tr>'
		};
		h+=''
		$('#data_rq').html(h);
		$('.choo_pack').html('<div class="info">当前共查询到<b> '+data.length+' </b>个用户</div><a class="btn" id="user_plus_btn"><i class="iconfont icon-jiahao"></i>添加用户</a>')
		$('.user_edit_btn').on('click',function(){
			user_edit($(this).data('id'),$(this).data('name'),$(this).data('type'));
		});
		$('.pass_edit_btn').on('click',function(){
			pass_edit($(this).data('id'),$(this).data('name'),$(this).data('type'));
		});
		$('#user_plus_btn').on('click',function(){
			user_plus();
		});
		$('.user_delete_btn').on('click',function(){
			user_delete($(this).data('id'));
		});
	};

	function user_edit(id,name,type){
		$('.page_right').fadeIn();
		$('.page_right .rq').animate({right:'-500px'},0);
		$('.page_right .rq').animate({right:'0px'},500);
		$('.page_right h3').text('编辑用户');
		$('.user_edit').show();
		$('.pass_edit').hide();

		$('.page_right #prpi_0').val(id);
		$('.page_right #prpi_1').val(name);
		$('.page_right #prpi_2').val(type);

		$('.exit').on('click',function() {
			$('.page_right').fadeOut();
			$('.page_right .rq').animate({right:'-500px'},500);
			$('.page_right .rq').animate({right:'0px'},0);
			$('.exit').unbind();
			$('.ok').unbind();
		});

		$('.ok').on('click',function() {
			$('.ok .icon-duihao').hide();
			$('.ok .rotate').show();
			name = $('#prpi_1').val();
			type = $('#prpi_2').val();
			$.ajax({
				url: ajax_url,
				data:{
					fa:'admin_user',
					fu:'user_edit',
					id:id,
					name:name,
					type:type
				},
				success: function (result){
					if(result){
						$('#data_rq').empty();
						data_aj();
						$('.page_right').fadeOut();
						$('.page_right .rq').animate({right:'-500px'},500);
						$('.page_right .rq').animate({right:'0px'},0);
						$('.ok .icon-duihao').toggle();
						$('.ok .rotate').toggle();
						$('.page_right .ok').unbind();
					}
				}
			});
			$('.ok').unbind();
		});
	};
	function pass_edit(id){
		$('.page_right').fadeIn();
		$('.page_right .rq').animate({right:'-500px'},0);
		$('.page_right .rq').animate({right:'0px'},500);
		$('.page_right h3').text('修改密码');
		$('.user_edit').hide();
		$('.pass_edit').show();
		$('.page_right #prpi_0').val(id);
		$('.exit').on('click',function() {
			$('.page_right').fadeOut();
			$('.page_right .rq').animate({right:'-500px'},500);
			$('.page_right .rq').animate({right:'0px'},0);
			$('.exit').unbind();
			$('.ok').unbind();
		});
		$('.ok').on('click',function() {
			if($('#prpi_4').val()==$('#prpi_5').val()){
				$('.ok .icon-duihao').hide();
				$('.ok .rotate').show();
				old_pass = $('#prpi_3').val();
				new_pass = $('#prpi_4').val();
				$.ajax({
					url: ajax_url,
					data:{
						fa:'admin_user',
						fu:'pass_edit',
						id:id,
						old_pass:old_pass,
						new_pass:new_pass
					},
					success: function (result){
						console.log(result);
						$('.ok .icon-duihao').toggle();
						$('.ok .rotate').toggle();
						if(result){
							alert('修改成功！');
							$('#data_rq').empty();
							data_aj();
							$('.page_right').fadeOut();
							$('.page_right .rq').animate({right:'-500px'},500);
							$('.page_right .rq').animate({right:'0px'},0);
							$('.page_right .ok').unbind();
						}else{
							alert('旧密码验证错误，请重新输入！');
						};
					}
				});
				$('.ok').unbind();
			}else{
				alert('2次新密码输入不一致！');
			};
		});
	};
	function user_plus(){
		$('.page_right').fadeIn();
		$('.page_right .rq').animate({right:'-500px'},0);
		$('.page_right .rq').animate({right:'0px'},500);
		$('.page_right h3').text('添加用户');
		$('.user_edit').show();
		$('.pass_edit').hide();
		$('.new_user').show();

		$('.page_right #prpi_0').val('');
		$('.page_right #prpi_1').val('');
		$('.page_right #prpi_2').val('');
		$('.page_right #prpi_3').val('');
		$('.page_right #prpi_4').val('');
		$('.page_right #prpi_5').val('');

		$('.exit').on('click',function() {
			$('.page_right').fadeOut();
			$('.page_right .rq').animate({right:'-500px'},500);
			$('.page_right .rq').animate({right:'0px'},0);
			$('.exit').unbind();
			$('.ok').unbind();
		});

		$('.ok').on('click',function() {
			if($('#prpi_3').val()==$('#prpi_5').val()){
				$('.ok .icon-duihao').hide();
				$('.ok .rotate').show();
				name = $('#prpi_1').val();
				type = $('#prpi_2').val();
				pass = $('#prpi_3').val();
				$.ajax({
					url: ajax_url,
					data:{
						fa:'admin_user',
						fu:'user_plus',
						name:name,
						type:type,
						pass:pass
					},
					success: function (result){
						console.log(result);
						$('.ok .icon-duihao').toggle();
						$('.ok .rotate').toggle();
						if(result){
							alert('添加成功！');
							$('#data_rq').empty();
							data_aj();
							$('.page_right').fadeOut();
							$('.page_right .rq').animate({right:'-500px'},500);
							$('.page_right .rq').animate({right:'0px'},0);
							$('.page_right .ok').unbind();
						}else{
							alert('添加失败');
						};
					}
				});
				$('.ok').unbind();
			}else{
				alert('2次新密码输入不一致！');
			};
		});
	};

	function user_delete(id){
	    if(confirm('确定要删除吗')==true){
	    	$('#data_rq').html('<img class="page_right_laoding" src="libs/laoding.gif">');
			$.ajax({
				url: ajax_url,
				data:{
					fa:'admin_user',
					fu:'user_delete',
					id:id
				},
				success: function (result){
					if(result){
						alert('删除成功!');
					}else{
						alert('删除失败!');
					};
					location.reload();
				}
			});
	    };
	};
</script>
</body>
</html>