<?php 
	session_start();
	$_SESSION["is_login"] = 0;

	$db_sn = "localhost";
	$db_un = "root";
	$db_pw = "phpts";
	$db_dn = "sjyh";
	@$conn = new mysqli($db_sn, $db_un, $db_pw, $db_dn);
	if ($conn->connect_error){
	    die("<script>alert('数据库连接失败！')</script>");
	};

	@$fa = $_REQUEST['fa'];
	if($fa==''){

	};
	if($fa=='login'){
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];
		if($username==''||$password==''){
			echo "<script>window.location.href='login.php?state=2&info=用户名或密码为空'</script>";
		}else{

			$sql = "SELECT * FROM admin_user WHERE password='$password' AND name='$username'";
			$res = mysqli_query($conn,$sql);
			if (mysqli_num_rows($res) > 0) {
				$row = mysqli_fetch_assoc($res);
				$_SESSION["is_login"] = 1;
				$_SESSION["usertype"] = $row["type"];
				$_SESSION["username"] = $username;
				echo "<script>window.location.href='index.php'</script>";
			} else {
				echo "<script>window.location.href='login.php?state=0&info=验证失败'</script>";
			};
		};
	};
?>
<!doctype html>
<html lang="zh" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="libs/a.css">
</head>
<body>
<form action="login.php?fa=login" method="post">
<div class="surface">
	<div class="mass"></div>
	<div class="pack">
		<h4 id="surface_title">账号密码登录</h4>
		<div class="lab">账户</div>
		<input name="username" type="text" value=""></input>
		<br>
		<div class="lab">密码</div>
		<input name="password" type="password" value=""></input>
		<br>
		<hr>
		<input type="submit" name="login" value="登录" class="btn ok">
	</div>
</div>
</form>
<div class="login_bq"> -成都斓设网络有限公司提供技术支持-</div>
<script src="libs/j.js"></script>
<script src="libs/a.js"></script>
<script type="text/javascript">
    var state = getUrlParam('state');
	var info  = getUrlParam('info');
    console.log(state);
    if(state==null){
    	
    }else if(state==1){
		alert(info);
    	window.location.href='index.php';
    }else{
		alert(info);
    	window.location.href='login.php';
    };
</script>
</body>
</html>