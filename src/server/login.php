<?php
	require "auth.php";
	$cookie = login(1);
	header("Set-Cookie: SESSIONID=$cookie");
?>