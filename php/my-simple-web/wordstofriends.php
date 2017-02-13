<?php
    session_start();
    function test_input($data)
    {
        $data=trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
    } 
    if(isset($_GET["code"])&&$_GET["code"]==$_SESSION["chatctl"]&&isset($_GET["email"]))
    {
        $friend_email=test_input($_GET["email"]);
        $chatctl=$_SESSION["chatctl"];
        $email=$_SESSION["email"];
        $words=test_input($_POST["words"]);
        $time=date("m-d H:i:s");
        if(!empty($words))
        {
            $server_link=mysql_connect("127.0.0.1","root","root");
            $db_link=mysql_select_db("web",$server_link);
            $sql_id="select max(id) as id from words";
            $result1=mysql_query($sql_id,$server_link);
            $rows=mysql_fetch_array($result1);
            $id=$rows[0];
            $id++;
            $sql="insert into words values('$id','$friend_email','$email','$words','$time')";
            mysql_query($sql,$server_link);
            mysql_close($server_link);
            header("Location:friendswords.php?code=$chatctl&email=$friend_email");
        }
    }
?>