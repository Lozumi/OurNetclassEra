<?php

$SQL = "localhost:3306";

function auth($cookie) {
    global $SQL;
    if (!$cookie) return False;
    $conn = mysqli_connect($SQL, "root", "");
    if (!mysqli_select_db($conn, "test")) echo "Fail to switch database.";
    $user = mysqli_query($conn, "SELECT * FROM auth WHERE cookie='$cookie'");
    if (!mysqli_num_rows($user)) return False;
    $array = mysqli_fetch_array($user);
    $expire = time()+36000;
    if ($array['expire'] < time()) return False;
    setcookie("SESSIONID", $cookie, $expire);
    mysqli_query($conn, "UPDATE auth SET expire=$expire WHERE userid=$user");
    return $array['userid'];
}

function login($user) {
    global $SQL;
    if (!$user) return False;
    $conn = mysqli_connect($SQL, "root", "");
    if (!$conn) echo "Fail to connect to SQL";
    if (!mysqli_select_db($conn, "test")) echo "Fail to switch database.";
    $cookie = md5(rand()+rand()*rand());    //防止撞车
    $expire = time()+36000;
    $isloggedin = mysqli_query($conn, "SELECT * FROM auth WHERE userid='$user'");
    if (mysqli_num_rows($isloggedin)) {
        mysqli_query($conn, "UPDATE auth SET cookie='$cookie', expire=$expire WHERE userid=$user");
    } else {
        mysqli_query($conn, "INSERT INTO auth (userid, cookie, expire) VALUES ($user, '$cookie', $expire)");
    }
    setcookie("SESSIONID", "$cookie", time()+36000);
    return $cookie;
}