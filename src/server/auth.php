<?php

$SQL = "localhost:3306";

function auth($cookie) {        //任何网页应该先调用这个函数进行身份验证, 返回值为 {0: 未登录, i (i>0): 已登录, -1: Server Error}, 参数为SESSIONID
    global $SQL;
    if (!$cookie) return 0;
    if (!($conn = mysqli_connect($SQL, "root", ""))) return -1;
    if (!mysqli_select_db($conn, "test")) return -1;
    $user = mysqli_query($conn, "SELECT * FROM auth WHERE cookie='$cookie'");
    if (!mysqli_num_rows($user)) return 0;
    $array = mysqli_fetch_array($user);
    $expire = time()+36000;
    if ($array['expire'] < time()) return 0;
    setcookie("SESSIONID", $cookie, $expire);   //更新expire time
    mysqli_query($conn, "UPDATE auth SET expire=$expire WHERE userid=$user");
    mysqli_close($conn);
    return $array['userid'];    //返回用户编号以便继续处理
}

function login($user) {         //处理登录请求, 返回值为 {-1: Server Error, 0: Success}. 此函数默认用户存在, 参数为userid
    global $SQL;
    if (!$user) return -1;
    if (!($conn = mysqli_connect($SQL, "root", ""))) return -1;
    if (!mysqli_select_db($conn, "test")) return -1;
    $cookie = md5(md5(rand()) . $user);    //防止撞车
    $expire = time()+36000;
    $isloggedin = mysqli_query($conn, "SELECT * FROM auth WHERE userid='$user'");
    if (mysqli_num_rows($isloggedin)) {
        mysqli_query($conn, "UPDATE auth SET cookie='$cookie', expire=$expire WHERE userid=$user");
    } else {
        mysqli_query($conn, "INSERT INTO auth (userid, cookie, expire) VALUES ($user, '$cookie', $expire)");
    }
    setcookie("SESSIONID", "$cookie", time()+36000);
    mysqli_close($conn);
    return 0;
}