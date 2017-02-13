<?php
    $refer="";
    session_start();
    header("content-type:text/html;charset=utf-8");
    require "PHPMailerAutoload.php";
    if($_GET["code"])
    {
        $refer=$_SESSION["regrefer"];
        if($_GET["code"]==$refer)
        {    
            $email_code=rand(1000,9999);
            $_SESSION["email_code"]=$email_code;
            $mail=new PHPMailer;
            $mail->isSMTP();
            $mail->CharSet="UTF-8";
            $mail->Host="smtp.163.com";
            $mail->SMTPAuth=true;
            $mail->Mailer="SMTP";
            $mail->Username="xlfpzilong@163.com";
            $mail->Password="5742610495812837";
            $mail->SMTPSecure="TLS";
            $mail->Port=25;
            $mail->setFrom("xlfpzilong@163.com");
            $mail->addAddress($_GET["email"],"");
            #$mail->addReplyTo("xlfpzilong@163.com","xlfpzilong");
            $mail->isHTML(true);
            
            $mail->Subject="zilong聊天验证";
            $mail->Body="欢迎使用zilong聊天系统,这是你的验证码:$email_code(如果不是你的操作,请保管好你的个人隐私)";
            $mail->AltBody="This is the body in plain text for non-HTML mail clients";
            
            if(!$mail->send()){
                echo "未成功";
            }else{
                echo "重新验证";
            }
        }
    }
?>