<?php
require("basic_auth.php");
$uid = getUser($_COOKIE["SESSIONID"]);
if ($uid == 0) {
    header("Content-Type: application/json", true, 403);
    echo(array("err"=>"请登录!"));
    return;
}
$fid = isset($_POST["id"]) ? $_POST["id"] : null;
if ($fid == null) {
    header("Content-Type: application/json", true, 404);
    echo(array("err"=>"你倒是说说你要给谁点赞啊!"));
    return;
}
$conn = mysqli_connect('localhost:3308', 'root', '');
mysqli_query($conn, 'set names utf8');
mysqli_select_db($conn, 'test');
mysqli_query($conn, "INSERT INTO likes (uid, fid, time) VALUES ($uid, $fid, NOW())");
$likes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM files WHERE id=$fid"))["likes"] + 1;
mysqli_query($conn, "UPDATE files SET likes=$likes WHERE id=$fid");