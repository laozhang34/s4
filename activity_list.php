<?php
require_once('page_left.php');
?>

<!-- 					<tr>
						<th>ID</th>
						<th>图片</th>
						<th>标题</th>
						<th>积分</th>
						<th>活动名额</th>
						<th>已报名人数</th>
						<th>活动时间</th>
						<th>活动类型</th>
						<th>所属社区</th>
						<th>联系人</th>
						<th>联系电话</th>
						<th>主办方</th>
						<th>当前状态</th>
						<th>操作</th>
					</tr> -->

	<div class="page_r">
		<h3><span><?php echo $page_title ?></span><a class="btn" onclick="add()">添加用户</a></h3>
		<div class="rq ">
			
			<div class="table">
				<table>
					<thead>
					<tr>
						<th style="width:5%">ID</th>
						<th style="width:55%;">标题</th>
						<th style="width:10%">所属社区</th>
						<th style="width:10%">当前状态</th>
						<th style="width:20%">操作</th>
					</tr>
					</thead>
					<tbody class="data_rq innerbox">
						<td style="background:rgb(251, 252, 252);">
							<img class="page_right_laoding" src="libs/laoding.gif">		
						</td>
					</tbody>
				</table>
			</div>
			<div class="choo_pack">
				
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>


<style type="text/css">
	.page_right {display:none;}
	.page_right>.mass {width:100vw; height:100vh; display:block; position:fixed; top:0; left:0; z-index:100; background:rgba(0,0,0,0.5);}
	.page_right>.rq   {width:500px; height:100vh; display:block; position:fixed; top:0; right:0; z-index:101; background:rgba(255,255,255,2); box-shadow:-3px 0 3px rgba(0,0,0,0.05); padding:0 30px;}
	.page_right>.rq>h3 {height:50px; line-height:50px; font-size:16px; border-bottom:1px solid #eee; margin-top:20px; font-weight:900; letter-spacing:2px;}

	.page_right>.rq>.pack {width:100%; height:calc(100vh - 160px);}
    .page_right>.rq .page_right_laoding {width:32px; display:block; margin-left:auto; margin-right:auto; padding-top:calc(50vh - 130px); opacity:0.8;}

	.page_right>.rq>.pack label { display:block; width:18%; height:32px; line-height:32px; letter-spacing:2px; text-indent:2px; color:#78909c; margin-top:25px; float:left; text-align:right;}
	.page_right>.rq>.pack input { display:block; width:74%; height:30px; line-height:30px;  padding:0 2%; border:1px solid #cfd8dc; margin-top:25px; float:right; border-radius:4px;}
	.page_right>.rq>.pack .date_choo { display:block; width:74%; height:30px; line-height:30px;  padding:0 2%; border:1px solid #cfd8dc; margin-top:25px; float:right; border-radius:4px; font-size:13px;}

	.page_right>.rq>.btn_arr { padding-top:20px; border-top:1px solid #eee; }
	.page_right>.rq>.btn_arr>.btn {display:inline-block; float:right; display:block; font-size:13px;  height:30px; line-height:30px;  border-radius:4px; border:1px solid #ddd; margin-left:30px; padding:0 15px; letter-spacing:2px; text-indent:2px; cursor:pointer;}
	.page_right>.rq>.btn_arr>.ok { background:#2962ff; color:#fff; }
	.page_right>.rq>.btn_arr>.btn:hover {opacity:0.8;}

</style>
<div class="page_right">
	<div class="mass"></div>
	<div class="rq">
		<h3>活动编辑</h3>
		<div class="pack">
			<!-- <img class="page_right_laoding" src="libs/laoding.gif"> -->
			<label>活动标题</label>
			<input name="" value=""></input>
			<label>活动图片</label>
			<input name="" value=""></input>
			<label>奖励积分</label>
			<input name="" value=""></input>
			<label>活动人数</label>
			<input name="" value=""></input>
			<label>所属分类</label>
			<input name="" value=""></input>
			<label>所属社区</label>
			<input name="" value=""></input>
			<label>发布用户</label>
			<input name="" value=""></input>
			<label>联系电话</label>
			<input name="" value=""></input>
			<label>主办方</label>
			<input name="" value=""></input>
			<label>开始时间</label>
			<div class="date_choo" id='start_datetime'></div>
			<label>结束时间</label>
			<div class="date_choo" id='end_datetime'></div>
		</div>
		<div class="btn_arr">
			<div class="btn ok">确认</div>
			<div class="btn exit">取消</div>
			<div class="clear"></div>
		</div>
	</div>
</div>

<script src="libs/j.js"></script>
<script src="libs/moment.js"></script>
<script src="libs/xndatepicker.js"></script>
<script src="libs/a.js"></script>

<script type="text/javascript">
	let data_list = [];
	
	$(function(){
		data_aj();
		
	});
	function data_aj() {
		$.ajax({
			url: ajax_url,
			data:{
				fa:'activity_list',
				fu:'list'
			},
			beforeSend:function(){
				//console.log('beforeSend');
			},
			success: function (result){
				data_play(result);
				data_list = result;
			},
			error:function(xhr,status,error){
				console.log(status);
			}
		});
	};

	function data_play(data_list){
		let h = '';
		for (var i = 0; i < data_list.length; i++) {
			h +='<tr>'
			+'<td style="width:5%">'
			+data_list[i].id
			+'</td>'
			+'<td style="text-align:left; padding-left:5px; width:55%;">'
			+data_list[i].title
			+'</td>'
			+'<td style="width:10%">'
			+data_list[i].community_id
			+'</td>'
			+'<td style="width:10%">'
			+data_list[i].status
			+'</td>'
			+'<td style="width:20%"><a class="btn edit_btn" data-id="'
			+i
			+'">编辑</a>'
			+'</td>'
			+'</tr>'
		};
		$('.page_r .page_right_laoding').remove();
		$('.data_rq').html(h).hide().slideDown();

		$('.edit_btn').on('click',function(){
			let id = $(this).data('id');
			data_edit(id);
		});

	};
	function data_edit(id){
		$('.page_right').fadeIn();
		console.log(data_list[id]);

	};



	$('.exit').click(function() {
		$('.page_right').hide();
	});



    var datetime=new XNDatepicker($("#start_datetime"),{
        type:'datetime',
        multipleDates:[],
        startTime:'',
        maxDate:'',
        separator:' 到 ',
        showType:'modal',
        linkPanels:false,
        showClear:true,
        autoConfirm:true,
        showShortKeys:false,
        autoFillDate:true,
    },function(data){
        //console.log(data)
    },);

    var datetime2=new XNDatepicker($("#end_datetime"),{
        type:'datetime',
        multipleDates:[],
        startTime:'',
        maxDate:'',
        separator:' 到 ',
        showType:'modal',
        linkPanels:false,
        showClear:true,
        autoConfirm:true,
        showShortKeys:false,
        autoFillDate:true,
    },function(data){
        //console.log(data)
    },);

</script>
</body>
</html>

