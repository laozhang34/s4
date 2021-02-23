<?php 

$db_sn = "localhost";
$db_un = "root";
$db_pw = "phpts";
$db_dn = "sjyh";
$conn = new mysqli($db_sn, $db_un, $db_pw, $db_dn);
if ($conn->connect_error){
    //die("连接失败: " . $conn->connect_error);
};



?>