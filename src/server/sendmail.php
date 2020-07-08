<?php
    require 'class.phpmailer.php';
    $cst = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    function rand_str() {
        global $cst;
        $str = '';
        for($i = 0; $i < 6; ++ $i)
            $str .= $cst[mt_rand(0, 25)];
        return $str;
    }
    header('Content-Type: application/json; charset=utf-8');
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $tcode = rand_str();
    $content = '您注册活动的验证码为：' . $tcode . '。<br/>如果您没有注册账号，请忽略这封邮件。';
    class Mail {
        static public $error = '';
        static public function send($address, $content) {
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = True;
            $mail->Host = 'ssl://smtp.exmail.qq.com:465';
            $mail->Username = 'notify@mail.loid.top';
            $mail->Password = '2F5qPdgWJgtDz84F';
            $mail->IsHTML(True);
            $mail->CharSet = "UTF-8";
            $mail->From = 'notify@mail.loid.top';
            $mail->FromName = "洛云推送";
            $mail->Subject = "注册验证邮件";
            $mail->MsgHTML($content);
            $mail->AddAddress($address);
            if($mail->Send()) return True;
            else {
                self::$error = $mail->ErrorInfo;
                return False;
            }
        }
    }
    $back['code'] = 0;
    $back['msg'] = '';
    if(!preg_match("/.+@qq\.com/", $address)) {
        $back['code'] = 1;
        $back['msg'] = '邮箱不合法！';
    } else {
        $conn = mysqli_connect('localhost:3308', 'root', '');
        mysqli_query($conn, 'set names utf8');
        mysqli_select_db($conn, 'test');
        $check_email = "SELECT * FROM user WHERE email='$address'";
        $get_email = mysqli_query($conn, $check_email);
        if(mysqli_num_rows($get_email) > 0) {
            $back['code'] = 1;
            $back['msg'] = '邮箱已经被注册！';
        } else {
            if(!Mail::send($address, $content)) {
                $back['code'] = 1;
                $back['msg'] = '发送失败' . PHP_EOL . Mail::$error;
            } else {
                $new_data = "INSERT INTO emailcode".
                        "(email, code)".
                        "VALUES".
                        "('$address', '$tcode')";
                mysqli_query($conn, $new_data);
            }
        } mysqli_close($conn);
    } echo json_encode($back);
?>