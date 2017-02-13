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
        $id=test_input($_GET["moodi"]);
        $chatctl=$_SESSION["chatctl"];
        $email=$_SESSION["email"];
        $server_link=mysql_connect("127.0.0.1","root","root");
        $db_link=mysql_select_db("web",$server_link);
        $sql="delete from mood where id=$id";
        mysql_query($sql,$server_link);
        mysql_close($server_link);
        echo "该消息已删除!";
    }
?>