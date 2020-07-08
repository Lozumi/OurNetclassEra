<?php
	session_start();
	header('Content-Type: application/json; charset=utf-8');
	$user_id = isset($_POST['userid']) ? $_POST['userid'] : '';
	$user_password = isset($_POST['password']) ?  $_POST['password'] : '';
	$user_email = isset($_POST['email']) ? $_POST['email'] : '';
	$user_code = isset($_POST['code']) ? $_POST['code'] : '';
	$back['code'] = 0;
	$back['msg'] = '';
	$ok = True;
	$conn = mysqli_connect('localhost:3308', 'root', '');
	mysqli_query($conn, 'set names utf8');
	mysqli_select_db($conn, 'test');
	if(strlen($user_id) < 4) {
		$back['code'] = 1;
		$back['msg'] .= '用户名过短！' . PHP_EOL;
		$ok = False;
	} else if(strlen($user_id) > 15) {
		$back['code'] = 1;
		$back['msg'] .= '用户名过长！' . PHP_EOL;
		$ok = False;
	} $check_username = "SELECT * FROM user WHERE username='$user_id'";
	$get_username = mysqli_query($conn, $check_username);
	if(mysqli_num_rows($get_username) > 0) {
		$back['code'] = 1;
		$back['msg'] .= '用户名已经被注册！' . PHP_EOL;
		$ok = False;
	} if(strlen($user_password) < 6) {
		$back['code'] = 1;
		$back['msg'] .= '密码过短！' . PHP_EOL;
		$ok = False;
	} else if(strlen($user_password) > 20) {
		$back['code'] = 1;
		$back['msg'] .= '密码过长！' . PHP_EOL;
		$ok = False;
	} $check_username = "SELECT * FROM emailcode WHERE code='$user_code'";
	$get_username = mysqli_query($conn, $check_username);
	if(mysqli_num_rows($get_username) > 0) {
		if(mysqli_num_rows($get_username) > 1) {
			$back['code'] = 1;
			$back['msg'] .= '这波是写代码的人写出问题了，快去锤他！' . PHP_EOL;
			$ok = False;
		} else {
			$row = mysqli_fetch_assoc($get_username);
			if($row['email'] != $user_email) {
				$back['code'] = 1;
				$back['msg'] .= '验证码不正确！' . PHP_EOL;
				$ok = False;
			} else mysqli_query($conn, "DELETE FROM emailcode WHERE code='$user_code'");
		}
	} else {
		$back['code'] = 1;
		$back['msg'] .= '验证码不正确！' . PHP_EOL;
		$ok = False;
	} if($ok) {
		$user_password = md5($user_password);
		$new_data = "INSERT INTO user".
					"(username, password, email, usergrp, regdate)".
					"VALUES".
					"('$user_id', '$user_password', '$user_email', 'user', NOW())";
		mysqli_query($conn, $new_data);
	} mysqli_close($conn);
	echo json_encode($back);
?>