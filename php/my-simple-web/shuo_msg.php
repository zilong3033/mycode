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
        $chatctl=$_SESSION["chatctl"];
        $email=$_SESSION["email"];
        $content=test_input($_POST["msg_mood"]);
        $time=date("m-d H:i:s");
        if(!empty($content))
        {
            $server_link=mysql_connect("127.0.0.1","root","root");
            $db_link=mysql_select_db("web",$server_link);
            $sql_id="select max(id) as id from mood";
            $result1=mysql_query($sql_id,$server_link);
            $rows=mysql_fetch_array($result1);
            $id=$rows[0];
            $id++;
            $sql="insert into mood values('$id','$email','$content','$time')";
            mysql_query($sql,$server_link);
            mysql_close($server_link);
            header("Location:shuo.php?code=$chatctl");
        }
    }   
?>