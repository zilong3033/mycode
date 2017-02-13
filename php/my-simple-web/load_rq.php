<?php
    session_start();
    function test_input($data)
    {
        $data=trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
    }
    if(isset($_GET["code"])&&$_GET["code"]==$_SESSION["loadpocod"])
    {
        $code=test_input($_POST["code"]);
        $password=test_input($_POST["userPw"]);
        $email=test_input($_POST["email"]);
        
        if(!empty($code)&&!empty($email)&&!empty($password))
        {
            if(isset($_SESSION["code_session"])&&($code==$_SESSION["code_session"]))
            {
                $server_link=mysql_connect("127.0.0.1","root","root");
                $db_link=mysql_select_db("web",$server_link);
                $sql="select * from users where email='$email' and password='$password'";
                $result=mysql_query($sql,$server_link);
                $rows=mysql_fetch_array($result);
                if($rows[0]==$email&&$rows[2]==$password)
                {
                    setcookie(sha1("zilong_zid"),md5($email),time()+3600,"/web/","127.0.0.1",NULL,1);
                    setcookie(sha1("zilong_ckp"),sha1(md5($password)),time()+3600,"/web/","127.0.0.1",null,1);
                    setcookie(sha1("zilong_pdcode"),md5($code),time()+3600,"/web/","127.0.0.1",null,1);
                    setcookie(sha1("zilong_private"),md5(rand(1000,9999)),time()+3600);
                    $_SESSION["email"]=$email;
                    $_SESSION["pwd"]=$password;
                    echo "
                    <html>
                    <body onload='javascript:jump();'>
                    <script>function jump(){top.location=\"main.php?code=".$_SESSION["loadpocod"]."\"}</script></body></html>";
                }
                else{
                    echo "密码或邮箱有误!";
                }
            }
            else{
                echo "验证码有误!注意大小写!";
            }
        }
        else{
            echo "输入内容不能为空!";
        }
    }
    else{
        echo "您还没有登录!";
    }
?>