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
        $server_link=mysql_connect("127.0.0.1","root","root");
        $db_link=mysql_select_db("web",$server_link);
        $sql="delete from friends where friend_email='$email_friends'";
        mysql_query($sql,$server_link);
        echo "删除成功!";
    }
?>