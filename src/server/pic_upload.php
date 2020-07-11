<?php
	require('basic_auth.php');
	require('pic_compress.php');
	$allow_type = array('jpg', 'jpeg', 'png', 'gif', 'jfif', 'bmp');
	$cst = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    function rand_str() {
        global $cst;
        $str = '';
        for($i = 0; $i < 32; ++ $i)
            $str .= $cst[mt_rand(0, 25)];
        return $str;
    }
	header('Content-Type: application/json; charset=utf-8');
	$cookie = isset($_COOKIE['SESSIONID']) ? $_COOKIE['SESSIONID'] : '';
    $userid = getUser($cookie);
    $temp = explode('.', $_FILES['picfile']['name']);
	$temp = end($temp);
    $back['code'] = 0;
	$back['msg'] = '';
    if($userid <= 0) {
    	$back['code'] = 1;
    	$back['msg'] = '请先登录！';
    } else if($_FILES['picfile']['error'] > 0) {
		$back['code'] = 1;
		$back['msg'] = $_FILES['picfile']['error'];
	} else if($_FILES['picfile']['size'] > 15728640) {
		$back['code'] = 1;
		$back['msg'] = '图片的大小不能超过 15MiB！';
	} else if(!in_array($temp, $allow_type)) {
		$back['code'] = 1;
		$back['msg'] = '请上传一个图片文件！';
	} else {
		$new_name = rand_str();
		$new_Name = $new_name . '.' . $temp;
		move_uploaded_file($_FILES['picfile']['tmp_name'], '../files/' . $new_Name);
		imgcompress('../files/' . $new_Name, '../slt/' . $new_name);
		$conn = mysqli_connect('localhost:3308', 'root', '');
		mysqli_query($conn, 'set names utf8');
		mysqli_select_db($conn, 'test');
		mysqli_query($conn, "INSERT INTO files".
							"(userid, ftype, fname, fend, fdes, likes, scores, isshow, iswait, uptime)".
							"VALUES".
							"($userid, 'image', '$new_name', '$temp', '', 0, 0.0, false, true, NOW())");
		mysqli_close($conn);
	} echo json_encode($back);
?>