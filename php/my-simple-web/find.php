<?php
    session_start();
    function test_input($data)
    {
        $data=trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
    }
    if(isset($_GET["code"])&&$_GET["code"]==$_SESSION["chatctl"])
    {
        $email_friends=test_input($_GET["email"]);
        if(empty($email_friends))
        {
            echo "输入为空!";
        }
        else
        {
            $email=$_SESSION["email"];
            if($email==$email_friends)
            {
                echo "不能加自己!";
            }
            else
            {
                $server_link=mysql_connect("127.0.0.1","root","root");
                $db_link=mysql_select_db("web",$server_link);
                $sql="select * from users where email='$email_friends'";
                $result=mysql_query($sql,$server_link);
                $rows=mysql_fetch_array($result);
                if($rows[0]==$email_friends)
                {
                    $sql="insert into friends values('$email','$email_friends','$rows[1]')";
                    mysql_query($sql,$server_link);
                    echo "添加好友成功!";
                    mysql_close($server_link);
                }
                else{
                    echo "该用户没有注册!";
                }
            }
        }
        
    }
?>