<?php
    session_start();
    if(isset($_GET["code"])&&$_GET["code"]==$_SESSION["chatctl"])
    {
        $strs=[];
        $content="";
        $email=$_SESSION["email"];
        $server_link=mysql_connect("127.0.0.1","root","root");
        $db_link=mysql_select_db("web",$server_link);
        $sql="select * from details where email='$email'";
        $result=mysql_query($sql,$server_link);
        while($row=mysql_fetch_array($result))
        {
            $sql="select * from users where email='$row[1]'";
            $results=mysql_query($sql,$server_link);
            $rows=mysql_fetch_array($results);
            $strs[]="$rows[1]:$row[2]----$row[3]";
        }
        for($i=count($strs)-1;$i>=0;$i--)
        {
            $content=$content.$strs[$i]."<br><br>";
        }
        echo $content;
        mysql_close($server_link);
    }
?>