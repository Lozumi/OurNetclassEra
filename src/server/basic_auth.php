<?php
    function getUser($cookie) {
        $back = 0;
        $conn = mysqli_connect('localhost:3308', 'root', '');
        mysqli_query($conn, 'set names utf8');
        mysqli_select_db($conn, 'test');
        $get_user = mysqli_query($conn, "SELECT * FROM auth WHERE cookie='$cookie'");
        if(mysqli_num_rows($get_user) > 0) {
            if(mysqli_num_rows($get_user) > 1)
                $back = -1;
            else {
                $row = mysqli_fetch_assoc($get_user);
                if($row['expire'] >= time())
                    $back = $row['userid'];
            }
        } mysqli_close($conn);
        return $back;
    }
?>