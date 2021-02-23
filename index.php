<?php
	require_once('page_left.php');
?>
	<div class="page_r">
		<h3><span id='title'>后台首页</span></h3>
		<div class="rq innerbox" style=" height:calc(100vh - 156px); overflow-y:scroll;">
			<div class="table" style="width:800px; margin:0 auto;">
				<table id="data_rq"></table>
				<div class="choo_pack">
					<a id="data_up" style="margin-right:14px;">确认修改</a>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>

<script src="libs/j.js"></script>
<script type="text/javascript">
	console.log(<?php echo $_SESSION["usertype"];?>)
</script>
</body>
</html>

