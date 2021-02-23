<?php
include('conn.php');

header('content-type:application/json;charset=utf8');
$link = mysql_connect($dbhost,$dbuser,$dbpwd) or die("Unable to connect to the MySQL!");
mysql_query("SET NAMES 'UTF8'");
mysql_select_db("zwzx", $link) or die("Unable to connect to the MySQL!");

$ff=$_REQUEST['ff']; 


if($ff=="app_tag_list"){

	$sql_1 =mysql_query("SELECT * FROM tag ORDER BY tag_id ASC LIMIT 0,20");
	$results_1 = array();
	while ($row_1 = mysql_fetch_assoc($sql_1)) {
		$results_1[] = $row_1;
	};
	$jsoncallback = htmlspecialchars($_REQUEST ['jsoncallback']);
	echo $jsoncallback.'('.json_encode($results_1).')';
	@mysql_free_result($result_1);

}else if($ff=="app_tag_list_0"){//标签选择列表

	$sql_1 =mysql_query("SELECT * FROM tag_class  ORDER BY tag_class_id");
	$results = array();
	while ($row_1 = mysql_fetch_assoc($sql_1)){
		$class_id = $row_1['tag_class_id'];
		$sql_2 =mysql_query("SELECT * FROM tag  where tag_class_id = $class_id");
		while ($row_2 = mysql_fetch_assoc($sql_2)){
			$tag_id = $row_2['tag_id'];
			/*
			$sql_3 =mysql_query("SELECT policy_name,policy_time,policy_id FROM policy  where policy_tags like '%$tag_id%'");
			while ($row_3 = mysql_fetch_assoc($sql_3)){
				$row_3['policy_time'] = gmdate('Y-m-d',$row_3['policy_time']+8*3600);
				$row_2['art'][] = $row_3;
			}
			*/
			$row_1['tag'][] = $row_2;
		}
		$results[] = $row_1;
	};
	$jsoncallback = htmlspecialchars($_REQUEST['jsoncallback']);
	echo $jsoncallback.'('.json_encode($results).')';

}else if($ff=="app_data_list_1"){//文件详情

	$pc=$_REQUEST['pc'];
	$key=$_REQUEST['key'];

	$sql_1 = mysql_query("SELECT * FROM policy as a , tag as b WHERE b.tag_name='".$key."' and b.tag_id in (a.policy_tags)  ORDER BY a.policy_date DESC LIMIT ".$pc.",20");
	while ($row_1 = mysql_fetch_assoc($sql_1)) {
				$row_1['policy_time'] = $key.gmdate('Y-m-d',$row_1['policy_time']+8*3600);
		$results_1[] = $row_1;
	};

	$jsoncallback = htmlspecialchars($_REQUEST ['jsoncallback']);
	echo $jsoncallback.'('.json_encode($results_1).')';
	@mysql_free_result($result_1);

}else if($ff=="app_mod_arc_1"){
	
	$id=$_REQUEST['id'];
	$sql_1 = mysql_query("SELECT * FROM policy WHERE policy_id=".$id." ORDER BY policy_id DESC LIMIT 0,1");
	$results_1 = array();
	while ($row_1 = mysql_fetch_assoc($sql_1)) {
		$results_1[] = $row_1;
	};
	$jsoncallback = htmlspecialchars($_REQUEST ['jsoncallback']);
	echo $jsoncallback.'('.json_encode($results_1).')';
	@mysql_free_result($result_1);

}else if($ff=="app_data_list_2"){

	//获取分类信息
	$result = mysql_query("select class_id,class_name from class");
	while($row = mysql_fetch_array($result)){
		$class_data[$row['class_id']] = $row['class_name'];
	}
	
	$key=$_REQUEST['key'];
	$sql_1 = mysql_query("SELECT policy_id,class_id,policy_name,policy_date FROM policy WHERE policy_content LIKE '%".$key."%' ORDER BY policy_id DESC LIMIT 0,20");
	$results_1 = array();
	while ($row_1 = mysql_fetch_assoc($sql_1)) {
		$row_1['policy_date'] = gmdate('Y-m-d',$row_1['policy_date']+8*3600);
		$row_1['policy_class'] = $class_data[$row_1['class_id']];
		$results_1[] = $row_1;
	};
	$jsoncallback = htmlspecialchars($_REQUEST ['jsoncallback']);
	echo $jsoncallback.'('.json_encode($results_1).')';
	@mysql_free_result($result_1);

};

//================================================================================

if($ff=="app_data_ys_1"){

	$sql_1 = mysql_query("SELECT * FROM category ORDER BY category_id DESC");
	$id=$_REQUEST['id'];
	if($id) $sql_1 = mysql_query("SELECT * FROM category where category_id = '$id'");
	$results_1 = array();
	while ($row_1 = mysql_fetch_assoc($sql_1)) {
		$datum = explode('|', $row_1['category_datum']);
		$row_1['datum_con'] = count($datum);
		$row_1['datum'][] = $datum;
		$results_1[] = $row_1;
	};
	$jsoncallback = htmlspecialchars($_REQUEST ['jsoncallback']);
	echo $jsoncallback.'('.json_encode($results_1).')';
	@mysql_free_result($result_1);

};

if($ff=="app_data_ys_2"){
	//获取预审工单号
	$pid = $_REQUEST['pid'];
	if ($pid == '') die();
	$id = substr($pid,6,9) - 100000000;
	//读取工单用户信息
	$row = mysql_fetch_array(mysql_query("SELECT category_id,user_code FROM pre where pre_id = '$id'"));
	$cid = $row['category_id'];
	$user = $row['user_code'];
	//准备管理员名字数据
	$result = mysql_query("select master_id,master_name from master");
	while($row = mysql_fetch_array($result)){
		$master_data[$row['master_id']] = $row['master_name'];
	}
	//构建交互信息数据
	$sql = mysql_query("SELECT user_id,mes_body,mes_time FROM messages where pre_id = '$id' order by mes_id desc");
	$m = 0;
	while($row = mysql_fetch_assoc($sql)) {
		$mesdb[$m]['mes_body'] = $row['mes_body'];
		$mesdb[$m]['mes_time'] = gmdate('Y-m-d H:i:s',$row['mes_time']+8*3600);
		$uid = $row['user_id'];
		if ($uid == $user){
			$mesdb[$m]['mes_who'] = '0';
			$mesdb[$m]['mes_user'] = '您';
		}else{
			$mesdb[$m]['mes_who'] = '1';
			$mesdb[$m]['mes_user'] = $master_data[$uid];
		}
		$m++;
	}
	if ($m == 0){
		$mesdb[$m]['mes_body'] = '';
		$mesdb[$m]['mes_time'] = '';
		$mesdb[$m]['mes_who'] = '';
		$mesdb[$m]['mes_user'] = '';
	}

	//构建资料数据
	$sql_1 = mysql_query("SELECT pic_url,pic_info FROM pics where pre_id = '$id'");
	$i = 0;
	while($row_1 = mysql_fetch_assoc($sql_1)) {
		$picdb[$i]['pic_url'] = str_replace('../','http://api.viewxd.cn/161208/', $row_1['pic_url']);
		$picdb[$i]['pic_info'] = $row_1['pic_info'];
		$i++;
	}
	//构建工单基础数据
	$sql_1 = mysql_query("SELECT * FROM category where category_id = '$cid'");
	$results_1 = array();
	$n = 0;
	while ($row_1 = mysql_fetch_assoc($sql_1)){
		$datum = explode('|', $row_1['category_datum']);
		for($ii=0; $ii < count($datum); $ii++){ 
			for($c = 0; $c < $i; $c++){
				if($datum[$ii] == $picdb[$c]['pic_info']) $datum_pics[$ii] = $picdb[$c]['pic_url'];
			}
		}
		$row_1['datum_con'] = count($datum);
		$row_1['datum'][] = $datum;
		$row_1['datum_pics'][] = $datum_pics;
		$row_1['datum_mes'][] = $mesdb;
		$results_1[] = $row_1;
		$n++;
	};
	$jsoncallback = htmlspecialchars($_REQUEST ['jsoncallback']);
	echo $jsoncallback.'('.json_encode($results_1).')';
	@mysql_free_result($result_1);
};

if($ff=="tttt"){
	echo '111';
};

if($ff=="app_data_ys_makecode"){
	$code=$_REQUEST['c']; 
	$id=$_REQUEST['id'];
	if ($code == '' || $id == ''){
		$results['num'] = '0';
	}else{
		$t = time();
		mysql_query("insert into pre (user_code,category_id,pre_time) values ('$code','$id','$t')");
		$did = mysql_insert_id();
		$date = gmdate('ymd',time()+8*3600);
		$results['num'] = $date.($did+100000000);
	}
	$jsoncallback = htmlspecialchars($_REQUEST ['jsoncallback']);
	echo $jsoncallback.'('.json_encode($results).')';
	@mysql_free_result($result);
};

if($ff == 'app_data_submit_pre'){
	$pid = $_REQUEST['pid'];
	$user = $_REQUEST['u'];
	if ($pid == '') die();
	$id = substr($pid,6,9) - 100000000;
	$name = $_REQUEST['n'];
	$tel = $_REQUEST['t'];
	$message = $_REQUEST['m'];
	$t = time();
	mysql_query("update pre set pre_name = '$name',pre_tel='$tel',ex_state='1' where pre_id = '$id'");
	if ($message != '')
	mysql_query("insert into messages (pre_id,user_id,mes_body,mes_time) values ('$id','$user','$message','$t')");
	mysql_close($con);

	$results_1['state'] = '1';
	$jsoncallback = htmlspecialchars($_REQUEST ['jsoncallback']);
	echo $jsoncallback.'('.json_encode($results_1).')';
	@mysql_free_result($result_1);
}

if($ff=="app_data_ys_user"){
	$user=$_REQUEST['u'];
	if ($user == '') die();
	//检测空单号，清除空单数据
	$result = mysql_query("select pre_id from pre where user_code = '$user'");
	while($row = mysql_fetch_array($result)){
		$pid = $row['pre_id'];
        $row_c = mysql_fetch_array(mysql_query("SELECT pre_id FROM pics where pre_id = '$pid'"));
        $check = $row_c['pre_id'];
        if($check == '') mysql_query("delete from pre where pre_id = '$pid'");
	}
	//获取预审类目信息
	$result = mysql_query("select category_id,category_name from category");
	while($row = mysql_fetch_array($result)){
		$class_data[$row['category_id']] = $row['category_name'];
	}
	//处理用户预审工单数据
	$sql_1 = mysql_query("SELECT pre_id,category_id,pre_time,ex_state,ex_time FROM pre where user_code = '$user'");
	$results_1 = array();
	while ($row_1 = mysql_fetch_assoc($sql_1)) {
		$did = $row_1['pre_id'];
		$date = gmdate('ymd',$row_1['pre_time']+8*3600);
		$row_1['pre_id'] = $date.($did+100000000);
		$row_1['cname'] = $class_data[$row_1['category_id']];
		$row_1['pre_time'] = gmdate('Y-m-d H:i:s',$row_1['pre_time']+8*3600);
		$results_1[] = $row_1;
	};
	$jsoncallback = htmlspecialchars($_REQUEST ['jsoncallback']);
	echo $jsoncallback.'('.json_encode($results_1).')';
	@mysql_free_result($result_1);
}

if($ff=="app_data_tag_policylist"){
	//输出对应标签政策列表

	//判定政策标签是否符合检索要求
	function check_tag_contain($ck,$tags){
		$str = explode(',',$tags);
		for($i=0; $i < count($str); $i++){
			if($ck == $str[$i]) return '1';
		}
		return '0';
	}

	//获取分类信息
	$result = mysql_query("select class_id,class_name from class");
	while($row = mysql_fetch_array($result)){
		$class_data[$row['class_id']] = $row['class_name'];
	}

	$pc=$_REQUEST['pc'];
	$tagid=$_REQUEST['tagid'];
	$sql_1 = mysql_query("SELECT policy_id,class_id,policy_name,policy_date,policy_tags FROM policy ORDER BY policy_time DESC");
	$results_1 = array();
	$n = 0;
	while($row_1 = mysql_fetch_assoc($sql_1)){
		$policy_tags = $row_1['policy_tags'];
		$c = check_tag_contain($tagid,$policy_tags);
		if($c == '1'){
			$row_1['policy_date'] = gmdate('Y-m-d',$row_1['policy_date']+8*3600);
			$row_1['policy_class'] = $class_data[$row_1['class_id']];
			$results_1[$n] = $row_1;
			$n++;
		}
	}

	$jsoncallback = htmlspecialchars($_REQUEST ['jsoncallback']);
	echo $jsoncallback.'('.json_encode($results_1).')';
	@mysql_free_result($result_1);
}

mysql_close($link);
error_reporting(E_ALL^E_NOTICE^E_WARNING);//关闭所有错误提示
?>