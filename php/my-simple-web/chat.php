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
        session_start();
        $email=$_SESSION["email"];
        $loadpocod=$_SESSION["loadpocod"];
        $spker=test_input($_POST["spker"]);
        $content=test_input($_POST["content"]);
        $time=date("Y-m-d H:i:s");
        if(!empty($spker)&&!empty($content))
        {
            $server_link=mysql_connect("127.0.0.1","root","root");
            $db_link=mysql_select_db("web",$server_link);
            $sql="insert into details values('$email','$spker','$content','$time')";
            mysql_query($sql,$server_link);
            mysql_close($server_link);
        }
        header("Location:main.php?code=$loadpocod");
    }
?>