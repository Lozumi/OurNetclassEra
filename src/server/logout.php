<?php
	header('Content-Type: application/json; charset=utf-8');
	$back['code'] = 0;
	setcookie('SESSIONID', '', time() - 1, '/');
	echo json_encode($back);
?>