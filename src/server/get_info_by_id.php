<?php
$id = isset($_GET["id"]) ? $_GET["id"] : -1;
if ($id == -1) {
    http_response_code(404);
    header("Content-Type: application/json");
    echo json_encode(array("err"=> "未选择作品哦"));
}
$conn = mysqli_connect('localhost:3308', 'root', '');
mysqli_query($conn, 'set names utf8');
mysqli_select_db($conn, 'test');
$info = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM files WHERE id='$id'"));
if ($info == null) {
    http_response_code(404);
    header("Content-Type: application/json");
    echo json_encode(array("err"=> "没有这件作品哦"));
    return;
}
$user_id = $info['userid'];
$username = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id=$user_id"))['username'];

$back["id"] = $id;
$back["uid"] = $user_id;
$back["username"] = $username;
$back['path'] = '/files/' . $info['fname'] . '.' . $info["fend"];
$back['fdes'] = $info['fdes'];
$back['likes'] = $info['likes'];
$back['scores'] = $info['scores'];
$back['uptime'] = $info['uptime'];
header("Content-Type: application/json");
echo json_encode($back);
