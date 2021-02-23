<?php
require_once('page_left.php');
?>
	<div class="page_r">
		<h3><span><?php echo $page_title ?></span></h3>
		<div class="rq ">
			<style type="text/css">
				.mess_mod_1 {}
				.mess_mod_1>dl {width:100%; display:block;}
				.mess_mod_1>dl>dt {height:12px; line-height:12px; margin:30px 0 10px 0; font-size:14px; font-weight:900; letter-spacing:2px;display:block; border-left:3px solid #3200ff; padding-left:5px; color:#424242;}
				.mess_mod_1>dl>dd {height:30px; line-height:30px; font-size:14px;  letter-spacing:2px; float:left; display:block; margin-right:10px; color:#757575; cursor:pointer; padding:0 5px; border:1px solid #fff; border-radius:4px;}
				.mess_mod_1>dl>dd:hover {background:#f0f5ff; border:1px solid #d6e4ff; border-radius:4px; color:#2f54eb;}
			</style>
			<div class="mess_mod_1 innerbox">
				<dl id="data_rq"></dl>
			</div>
			<div class="choo_pack">
				<div class="info">数据载入中······</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>

<div class="page_right">
	<div class="mass"></div>
	<div class="rq">
		<h3></h3>
		<div class="pack">
			<input id="prpi_0" name="sq_id" value="" style="display:none;"></input>
			<label>社区名称</label>
			<input id="prpi_1" name="sq_name" value=""></input>
			<label>所属街道</label>
			<input id="prpi_2" name="jd_name" readonly="readonly" value=""></input>
			<div class="danxuan" id="jd_list"></div>
			<label>经度</label>
			<input id="prpi_3" name="j" value=""></input>
			<label>纬度</label>
			<input id="prpi_4" name="w" value=""></input>
			<div class="clear"></div>
		</div>
		<div class="btn_arr">
			<div class="btn ok">确认</div>
			<div class="btn del">删除</div>
			<div class="btn exit">取消</div>
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
	let jd_list = [];
	let jd_num = Number(0);
	let sq_num = Number(0);
	function data_aj() {
		$.ajax({
			url: ajax_url,
			data:{
				fa:'area_list',
				fu:'list'
			},
			beforeSend:function(){
				$('#data_rq').html('<img class="page_right_laoding" src="libs/laoding.gif">');
			},
			success: function (result){
				console.log(result)
				var list = result,
					flag = 0,
					data = [];
				sq_num = result.length;
				for(var i = 0; i< list.length; i++) {
				    var az = '';
				    for (var j = 0; j < data.length; j++) {
				        if(data[j][0].jd == list[i].jd) {
				            flag = 1;
				            az = j;
				            break;
				        };
				    };
				    if(flag == 1){
				        data[az].push(list[i]);
				        flag = 0;
				    } else if (flag == 0) {
				        wdy = new Array();
				        wdy.push(list[i]);
				        data.push(wdy);
				    };
				};
				console.log(data)
				data_play(data);
			},
			error:function(xhr,status,error){
				console.log(status);
			}
		});
	};

	function data_play(data){
		jd_num = data.length;
		let h = '';
		for (var i = 0; i < data.length; i++) {
			h +=''
			+'<dt>'
			+data[i][0].jd
			+'</dt>'
			let d = data[i];
			jd_list.push(data[i][0].jd);
			for (var j = 0; j < d.length; j++) {
				h +=''
				+'<dd data-id="'
				+d[j].id
				+'" data-jd="'
				+d[j].jd
				+'" data-j="'
				+d[j].j
				+'" data-w="'
				+d[j].w
				+'">'
				+d[j].sq
				+'</dd>'
			};
			h +=''
			+'<div class="clear"></div>'
		};
		$('#data_rq').html(h);
		$('.choo_pack').html('<div class="info">当前共查询到<b> '+jd_num+' </b>个街镇园区 以及<b> '+sq_num+' </b>个社区</div><a class="btn" id="sq_add">添加社区</a>')
		$('dd').on('click',function(){
			sq_edit($(this).data('id'),$(this).text(),$(this).data('jd'),$(this).data('j'),$(this).data('w'))
		});

		$('#sq_add').on('click',function(){
			sq_add();
		});

	};

	function sq_edit(id,sq,jd,j,w){
		$('.page_right').fadeIn();
		$('.page_right .rq').animate({right:'-500px'},0);
		$('.page_right .rq').animate({right:'0px'},500);
		$('.page_right h3').text('编辑社区');
		$('.page_right .del').show();
		$('.page_right #prpi_0').val(id);
		$('.page_right #prpi_1').val(sq);
		$('.page_right #prpi_2').val(jd);
		$('.page_right #prpi_3').val(j);
		$('.page_right #prpi_4').val(w);
		let h = '<ul>';
		for (var i = 0; i < jd_list.length; i++) {
			if(jd_list[i]==jd){
				h+=''
				+'<li class="act">'
				+jd_list[i]
				+'</li>'
			}else{
				h+=''
				+'<li>'
				+jd_list[i]
				+'</li>'
			}
		};
		h+="</ul>"
		$('#jd_list').html(h);
		$('#prpi_2').on('click',function(){
			$('#jd_list').show();
			$("#jd_list li").hover(function(){
			    $("#jd_list").show();
			},function(){
			    $("#jd_list").hide();
			});
		});
		$('#jd_list li').on('click',function() {
			let k = $(this).html();
			$('#prpi_2').val(k);
			$('#jd_list li').removeClass('act');
			$(this).addClass('act');
			$('#jd_list').hide();
		});
		$('.exit').on('click',function() {
			$('#jd_list').hide();
			$('.page_right').fadeOut();
			$('.page_right .rq').animate({right:'-500px'},500);
			$('.page_right .rq').animate({right:'0px'},0);
			$('.exit').unbind();
		});
		$('.page_right .ok').on('click',function(){
			let id =$('#prpi_0').val();
			let sq =$('#prpi_1').val();
			let jd =$('#prpi_2').val();
			let aj =$('#prpi_3').val();
			let aw =$('#prpi_4').val();
			if (confirm("确认操作？")==true){
				$('.page_right').hide();
				$('#data_rq').html('<img class="page_right_laoding" src="libs/laoding.gif">');
				$.ajax({
					url: ajax_url,
					data:{
						fa:'area_list',
						fu:'sq_edit',
						id:id,
						sq:sq,
						jd:jd,
						aj:aj,
						aw:aw
					},
					success: function (result){
						$('#data_rq').empty();
						$('dd').unbind();
						$('.page_right .ok').unbind();
						data_aj();
						jd_list = [];
						jd_num = Number(0);
						sq_num = Number(0);
					}
				});
			};
		});
		$('.page_right .del').on('click',function(){
			let id =$('#prpi_0').val();
			if (confirm("确认操作？")==true){
				$('.page_right').fadeOut();
				$('.page_right .rq').animate({right:'-500px'},500);
				$('.page_right .rq').animate({right:'0px'},0);
				$('#data_rq').html('<img class="page_right_laoding" src="libs/laoding.gif">');
				$.ajax({
					url: ajax_url,
					data:{
						fa:'area_list',
						fu:'sq_del',
						id:id
					},
					success: function (result){
						$('#data_rq').empty();
						$('dd').unbind();
						$('.page_right .del').unbind();
						data_aj();
						jd_list = [];
						jd_num = Number(0);
						sq_num = Number(0);
					}
				});
				
			};
		});
	};

	function sq_add(){
		$('.page_right').fadeIn();
		$('.page_right .rq').animate({right:'-500px'},0);
		$('.page_right .rq').animate({right:'0px'},500);
		$('.page_right h3').text('添加社区');
		$('.page_right .del').hide();
		$('.page_right #prpi_0').val('');
		$('.page_right #prpi_1').val('');
		$('.page_right #prpi_2').val('');
		$('.page_right #prpi_3').val('');
		$('.page_right #prpi_4').val('');
		let h = '<ul>';
		for (var i = 0; i < jd_list.length; i++) {
			h+=''
			+'<li>'
			+jd_list[i]
			+'</li>'
		};
		h+="</ul>"
		$('#jd_list').html(h);
		$('#prpi_2').on('click',function(){
			$('#jd_list').show();
			$("#jd_list li").hover(function(){
			    $("#jd_list").show();
			},function(){
			    $("#jd_list").hide();
			});
		});
		$('#jd_list li').on('click',function() {
			let k = $(this).html();
			$('#prpi_2').val(k);
			$('#jd_list li').removeClass('act');
			$(this).addClass('act');
			$('#jd_list').hide();
		});
		$('.exit').on('click',function() {
			$('#jd_list').hide();
			$('.page_right').fadeOut();
			$('.page_right .rq').animate({right:'-500px'},500);
			$('.page_right .rq').animate({right:'0px'},0);
			$('.exit').unbind();
		});	
		$('.page_right .ok').on('click',function(){
			let sq =$('#prpi_1').val();
			let jd =$('#prpi_2').val();
			let aj =$('#prpi_3').val();
			let aw =$('#prpi_4').val();
			if (confirm("确认操作？")==true){
				$('.page_right').fadeOut();
				$('.page_right .rq').animate({right:'-500px'},500);
				$('.page_right .rq').animate({right:'0px'},0);
				$('#data_rq').html('<img class="page_right_laoding" src="libs/laoding.gif">');
				$.ajax({
					url: ajax_url,
					data:{
						fa:'area_list',
						fu:'sq_add',
						sq:sq,
						jd:jd,
						aj:aj,
						aw:aw
					},
					success: function (result){
						$('#data_rq').empty();
						$('dd').unbind();
						$('.page_right .ok').unbind();
						data_aj();
						jd_list = [];
						jd_num = Number(0);
						sq_num = Number(0);
					}
				});
			};
		});
	};

</script>
</body>
</html>

