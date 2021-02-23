<?php
header('content-type:application/json;charset=utf8');
header('Access-Control-Allow-Origin:*');  
header('Access-Control-Allow-Methods:POST');  
header('Access-Control-Allow-Headers:x-requested-with,content-type');

$db_sn = "localhost";
$db_un = "root";
$db_pw = "phpts";
$db_dn = "sjyh";
$mysqli = new mysqli($db_sn, $db_un, $db_pw, $db_dn);
$mysqli -> query('set names utf8;');
if(!$mysqli){
	echo "链接数据库失败";
};

function call_back($results){
	$jsoncallback = htmlspecialchars($_REQUEST['jsoncallback']);
	echo $jsoncallback.json_encode($results);
	mysqli_close($mysqli);
	die();
};

$fa = $_GET['fa'];
$fu = $_GET['fu'];
if($fa==""){
	echo '3';
};


if($fa=="activity_list"){
	if($fu=='list'){
		$result = $mysqli->query("SELECT * FROM think_activity ORDER BY id ASC LIMIT 0,50");
		while($row = mysqli_fetch_array($result)){
			$results[] = $row;
		};
	};
	if($fu=='edit'){
		$result = $mysqli->query("SELECT * FROM think_activity ORDER BY id ASC LIMIT 0,50");
		while($row = mysqli_fetch_array($result)){
			$results[] = $row;
		};
	};
	@call_back($results);
};


if($fa=="area_list"){
	if($fu=='list'){
		$result = $mysqli->query("SELECT id,sq,jd,j,w FROM xindu_list ORDER BY id DESC");
		while($row = mysqli_fetch_array($result)){
			unset($row['0'],$row['1'],$row['2'],$row['3'],$row['4']);
			$results[] = $row;
		};
	};
	if($fu=='sq_edit'){
		$id = $_GET['id'];
		$sq = $_GET['sq'];
		$jd = $_GET['jd'];
		$aj = $_GET['aj'];
		$aw = $_GET['aw'];
		$result = $mysqli->query("UPDATE xindu_list SET sq='".$sq."',jd='".$jd."',j='".$aj."',w='".$aw."' WHERE id = '".$id."'");
	};
	if($fu=='sq_del'){
		$id = $_GET['id'];
		$result = $mysqli->query("DELETE FROM xindu_list  WHERE id = '".$id."'");
	};
	if($fu=='sq_add'){
		$sq = $_GET['sq'];
		$jd = $_GET['jd'];
		$q = '新都区';
		$aj = $_GET['aj'];
		$aw = $_GET['aw'];
		$result = $mysqli->query("INSERT INTO xindu_list (sq,jd,q,j,w) VALUES ('$sq','$jd','$q','$aj','$aw')");
	};
	@call_back($results);
};

if($fa=='admin_user'){
	if($fu=='list'){
		$result = $mysqli->query("SELECT * FROM admin_user ORDER BY id DESC");
		while($row = mysqli_fetch_array($result)){
			unset($row['0'],$row['1'],$row['2'],$row['3']);
			$results[] = $row;
		};
	};
	if($fu=='user_edit'){
		$id = $_GET['id'];
		$name = $_GET['name'];
		$type = $_GET['type'];
		$result = $mysqli->query("UPDATE admin_user SET name='".$name."',type='".$type."' WHERE id = '".$id."'");
		$results = $result;
	};
	if($fu=='pass_edit'){
		$id = $_GET['id'];
		$pd = null;
		$old_pass = $_GET['old_pass'];
		$new_pass = $_GET['new_pass'];
		$result = $mysqli->query("SELECT id,password FROM admin_user WHERE id = '".$id."' AND password='".$old_pass."'");
		while($row = mysqli_fetch_array($result)){
			$pd[] = $row;
		};
		if($pd==null){
			$results = false;
		}else{
			$result = $mysqli->query("UPDATE admin_user SET password='".$new_pass."' WHERE id = '".$id."'");
			$results = $result;
		};
	};
	if($fu=='user_plus'){
		$name = $_GET['name'];
		$type = $_GET['type'];
		$pass = $_GET['pass'];
		$result = $mysqli->query("INSERT INTO admin_user (name,type,password) VALUES ('$name','$type','$pass')");
		$results = $result;
	};
	if($fu=='user_delete'){
		$id = $_GET['id'];
		$result = $mysqli->query("DELETE FROM admin_user  WHERE id = '".$id."'");
		$results = $result;
	};
	@call_back($results);
};


if($fa=='data_choo'){
	if($fu=='data_list'){
		$dir = "D:/phpts/data/wwwroot/s4/data/";
	    $fileArray[]=NULL;
	    if (false != ($handle = opendir ( $dir ))) {
	        $i=0;
	        while ( false !== ($file = readdir ( $handle )) ) {
	            if ($file != "." && $file != ".."&&strpos($file,".")) {
	                $fileArray[$i]=$dir.$file;
	                if($i==100){
	                    break;
	                };
	                $i++;
	            }
	        };
	        closedir ( $handle );
	    };
		$results = $fileArray;
	};
	if($fu=='data_back'){
		$doc_root=$_SERVER['DOCUMENT_ROOT'];
		$file_path_name=$doc_root.'/s4/data';
		$name='backup_'.date('YmdHis').".sql";
		if(!file_exists($file_path_name)){
			mkdir($file_path_name,0777);
		};
		$mysqldump_url='D:\phpts\apps\mysql\x64\bin\mysqldump.exe';
		$process=$mysqldump_url." -h".$db_sn." -u".$db_un."  -p".$db_pw."  ".$db_dn." >".$file_path_name."/".$name;
		$er=system($process);
		if($er!==false){
			$pach = $file_path_name.'/'.$name;
			$up_time = time();
			$result = $mysqli->query("INSERT INTO data_choo (name,pach,up_time) VALUES ('$name','$pach','$up_time')");
			$results=$result;
		}else{
		  	$results['state'] = false;
		};
	};
	@call_back($results);
};






?>