<?php
	header('Content-Type: application/json; charset=utf-8');
	$user_id = isset($_POST['userid']) ? $_POST['userid'] : '';
	$user_password = isset($_POST['password']) ?  $_POST['password'] : '';
	$conn = mysqli_connect('localhost:3308', 'root', '');
	mysqli_query($conn, 'set names utf8');
	mysqli_select_db($conn, 'test');
	$get_username = mysqli_query($conn, "SELECT * FROM user WHERE username='$user_id'");
	$back['code'] = 0;
	$back['msg'] = '';
	if(mysqli_num_rows($get_username) > 0) {
		if(mysqli_num_rows($get_username) > 1) {
			$back['code'] = 1;
			$back['msg'] = '这波是写代码的人写出问题了，快去锤他！';
		} else {
			$user_password = md5($user_password);
			$row = mysqli_fetch_assoc($get_username);
			if($row['password'] != $user_password) {
				$back['code'] = 1;
				$back['msg'] = '密码错误！';
			} else {
				$user = $row['id'];
				$cookie = md5(md5(rand()) . $user);
        		$expire = time() + 36000;
				setcookie('SESSIONID', $cookie, $expire, '/');
				$is_login = mysqli_query($conn, "SELECT * FROM auth WHERE userid=$user");
				if(mysqli_num_rows($is_login) != 0)
					mysqli_query($conn, "UPDATE auth SET cookie='$cookie', expire=$expire WHERE userid=$user");
				else mysqli_query($conn, "INSERT INTO auth (userid, cookie, expire) VALUES ($user, '$cookie', $expire)");
			}
		}
	} else {
		$back['code'] = 1;
		$back['msg'] = '用户名不存在！';
	} mysqli_close($conn);
	echo json_encode($back);
?>