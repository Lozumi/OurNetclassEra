<?php
    header('Content-Type: application/json; charset=utf-8');
    $cookie = isset($_COOKIE['SESSIONID']) ? $_COOKIE['SESSIONID'] : '';
    $conn = mysqli_connect('localhost:3308', 'root', '');
    mysqli_query($conn, 'set names utf8');
    mysqli_select_db($conn, 'test');
    $get_user = mysqli_query($conn, "SELECT * FROM auth WHERE cookie='$cookie'");
    $back['code'] = 0;
    $back['name'] = '未登录用户';
    if(mysqli_num_rows($get_user) > 0) {
        if(mysqli_num_rows($get_user) > 1) {
            $back['code'] = -1;
            $back['name'] = '出现错误！';
        } else {
            $row = mysqli_fetch_assoc($get_user);
            if($row['expire'] >= time()) {
                $user_id = $row['userid'];
                $back['code'] = $user_id;
                $get_name = mysqli_query($conn, "SELECT * FROM user WHERE id='$user_id'");
                $get_name = mysqli_fetch_assoc($get_name);
                $back['name'] = $get_name['username'];
                $expire = time() + 36000;
                setcookie('SESSIONID', $cookie, $expire, '/');
                mysqli_query($conn, "UPDATE auth SET expire='$expire' WHERE cookie='$cookie'");
            }
        }
    } mysqli_close($conn);
    echo json_encode($back);
?>