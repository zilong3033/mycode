<?php
    session_start();
    if(isset($_GET["code"])&&$_GET["code"]==$_SESSION["chatctl"])
    {
        $email=$_SESSION["email"];
        $server_link=mysql_connect("127.0.0.1","root","root");
        $db_link=mysql_select_db("web",$server_link);
        $sql="delete from details where email='$email' or spker='$email'";
        mysql_query($sql,$server_link);
        mysql_close($server_link);
        echo "消息已清空!";
    }
?>