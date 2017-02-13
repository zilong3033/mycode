<?php
    session_start();
    function test_input($data)
    {
        $data=trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
    }
    if($_GET["code"]==$_SESSION["regpocod"])
    {
        $code=test_input($_POST["code"]);
        $username=test_input($_POST["userId"]);
        $password=test_input($_POST["userPw"]);
        $email=test_input($_POST["email"]);
        if(!empty($code)&&!empty($username)&&!empty($password))
        {
            if(isset($_SESSION["email_code"])&&$code==$_SESSION["email_code"])
            {
                $server_link=mysql_connect("127.0.0.1","root","root");
                $db_link=mysql_select_db("web",$server_link);
                $sql="insert into users values('$email','$username','$password')";
                mysql_query($sql,$server_link);
                mysql_close($server_link);
                header("Location:load.php");
            }
            else{
                echo "你的验证码有误！请重新注册！<br><br>";
                echo "<a href='register.php'>注册</a>";
            }
        }
        else{
            echo "你的输入格式错误！请重新注册！<br><br>";
            echo "<a href='register.php'>注册</a>";
        }
    }
?>