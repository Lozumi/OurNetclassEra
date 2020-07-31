<?php
	header('Content-Type: application/json; charset=utf-8');
	$ftype = isset($_POST['ftype']) ? $_POST['ftype'] : '';
	$fsort = isset($_POST['fsort']) ? $_POST['fsort'] : '';
	$fnum = isset($_POST['fnum']) ? $_POST['fnum'] : 0;
	$back = array();
	$conn = mysqli_connect('localhost:3308', 'root', '');
	mysqli_query($conn, 'set names utf8');
	mysqli_select_db($conn, 'test');
	$get_random = False;
	switch($fsort) {
		case 'uptime':
			$get_ = mysqli_query($conn, "SELECT * FROM files WHERE ftype='$ftype' ORDER BY uptime DESC");
			break;
		case 'likes':
			if($ftype == 'image')
				$get_ = mysqli_query($conn, "SELECT * FROM files WHERE ftype='$ftype' ORDER BY likes DESC");
			else $get_ = mysqli_query($conn, "SELECT * FROM files WHERE ftype='$ftype' ORDER BY scores DESC");
			break;
		default:
			$get_ = mysqli_query($conn, "SELECT * FROM files WHERE ftype='$ftype'");
			$get_random = True;
	} $rownum = mysqli_num_rows($get_);
	$fnum = $fnum == 0 ? $rownum : $fnum;
	for($i = 0; $i < $rownum; ++ $i) {
		$row = mysqli_fetch_assoc($get_);
		if($row['isshow']) continue;
		$nowrow['id'] = $row['id'];
		$nowrow['userid'] = $row['userid'];
		$user_id = $row['userid'];
		$get_username = mysqli_query($conn, "SELECT * FROM user WHERE id=$user_id");
		$get_username = mysqli_fetch_assoc($get_username);
		$nowrow['username'] = $get_username['username'];
		$nowrow['fpath'] = '/slt/' . $row['fname'] . '.png';
		$nowrow['freal'] = '/files/' . $row['fname'] . '.' . $row['fend'];
		if($row['fend'] == 'gif') $nowrow['fpath'] = $nowrow['freal'];
		$nowrow['fdes'] = $row['fdes'];
		$nowrow['likes'] = $row['likes'];
		$nowrow['scores'] = $row['scores'];
		$nowrow['uptime'] = $row['uptime'];
		$back[$i] = $nowrow;
	} mysqli_close($conn);
	if($get_random) shuffle($back);
	if($fnum > $rownum) $fnum = $rownum;
	echo json_encode(array_slice($back, 0, $fnum));
?>