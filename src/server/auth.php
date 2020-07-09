<?php
function auth($cookie) {
    if (!$cookie) return False;
    $conn = mysqli_connect("localhost:3308", "root", "");
    if (!mysql_select_db($conn, "test")) die("Fail to switch database.");
    $user = mysqli_query($conn, "SELECT * FROM auth WHERE cookie='$cookie'");
    if (!mysqli_num_rows($user)) return False;
    return mysqli_fetch_array($user)['userid'];
}

function login($user) {
    if (!$user) return False;
    $conn = mysqli_connect("localhost:3308", "root", "");
    var_dump($conn);
    if (!$conn) echo "Fail to connect to SQL";
    if (!mysql_select_db($conn, "test")) echo "Fail to switch database.";
    $cookie = hash("SHA128", rand_str());
    $isloggedin = mysqli_query($conn, "SELECT * FROM auth WHERE userid='$user'");
    if (mysqli_num_rows($isloggedin)) {
        mysqli_query($conn, "UPDATE auth SET cookie='$cookie' WHERE userid=$user");
    } else {
        mysqli_query($conn, "INSERT INTO auth (userid, cookie) VALUES ($user, $cookie)");
    }
    return $cookie;
}