<?php
    require('basic_auth.php');
    header('Content-Type: application/json; charset=utf-8');
    $cookie = isset($_COOKIE['SESSIONID']) ? $_COOKIE['SESSIONID'] : '';
    $userid = getUser($cookie);
    $back['code'] = $userid;
    $back['name'] = '未登录用户';
    if($userid == -1)
        $back['name'] = '出现错误！';
    else if($userid > 0) {
        $conn = mysqli_connect('localhost:3308', 'root', '');
        mysqli_query($conn, 'set names utf8');
        mysqli_select_db($conn, 'test');
        $get_name = mysqli_query($conn, "SELECT * FROM user WHERE id=$userid");
        $get_name = mysqli_fetch_assoc($get_name);
        $back['name'] = $get_name['username'];
        $expire = time() + 36000;
        setcookie('SESSIONID', $cookie, $expire, '/');
        mysqli_query($conn, "UPDATE auth SET expire=$expire WHERE cookie='$cookie'");
        mysqli_close($conn);
    } echo json_encode($back);
?>