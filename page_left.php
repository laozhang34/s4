<?php 

	session_start();
	if($_SESSION["is_login"] != 1){
		echo "<script>window.location.href='login.php'</script>";
	};

	echo '<!doctype html>';
	echo '<html lang="zh">';
	echo '<head>';
	echo '<meta charset="UTF-8">';
	echo '<meta name="viewport" content="width=device-width,initial-scale=1">';
	echo '<link rel="stylesheet" href="libs/a.css">';
	echo '<link rel="stylesheet" href="//at.alicdn.com/t/font_2361289_97xk3cntf5l.css">';
	
	echo '</head>';
	echo '<body>';
	echo '<div class="page_t">';
	echo '<h2>2021年度UI测试项目<span>BETA:1.0</span></h2>';
	echo '<a class="exit btn" href="login.php"><i class="iconfont icon-guanbi"></i>退出</a>';
	echo '</div>';
	echo '<div class="page_b">';

	echo '<div class="page_l"><div></div><ul><dt>';
	echo $_SESSION["username"];
	echo "</dt>";
	echo '<a class="list" href="index.php"><i class="iconfont icon-shouye"></i>后台首页</a>';
	if($_SESSION["usertype"] == 3){//系统管理员
		echo '<a class="list" href="activity_list.php"><i class="iconfont icon-xinwen"></i>活动管理</a>';
		echo '<a class="list" href="area_list.php"><i class="iconfont icon-ditu"></i>街镇社区管理</a>';
		echo '<a class="list" href="admin_user.php"><i class="iconfont icon-qunzu"></i>用户&密码管理</a>';
		echo '<a class="list" href="data_choo.php"><i class="iconfont icon-qiandao"></i>系统&数据管理</a>';
	}else if($_SESSION["usertype"] == 2){//社区管理员
		echo '<a class="list" href="activity_list.php">活动管理</a>';
		echo '<a class="list" href="admin_user.php">用户&密码管理</a>';
	};
	echo "</ul><div class='bq'>成都斓设网络科技有限公司</div></div>";

	$page_title = '';
	$php_self = substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
	if($php_self=='index.php'){
		$page_title = '后台首页';
	}else if($php_self=='activity_list.php'){
		$page_title = '活动管理';
	}else if($php_self=='admin_user.php'){
		$page_title = '用户&密码管理';
	}else if($php_self=='data_choo.php'){
		$page_title = '系统&数据管理';
	}else if($php_self=='area_list.php'){
		$page_title = '街镇&社区管理';
	};



?>