<?php
	session_start();
	header('Content-Type: application/json; charset=utf-8');
	$user_id = $_POST['userid'];
	$user_password = $_POST['password'];
	$user_email = $_POST['email'];
	$user_code = $_POST['code'];
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
	} // Check email code
	if($ok) {
		$user_password = md5($user_password);
		$new_data = "INSERT INTO user".
					"(username, password, email, regdate)".
					"VALUES".
					"('$user_id', '$user_password', '$user_email', NOW())";
		mysqli_query($conn, $new_data);
		mysqli_close($conn);
	} echo json_encode($back);
?>