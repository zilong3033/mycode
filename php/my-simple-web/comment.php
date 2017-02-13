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
        $email=$_SESSION["email"];
        $chatctl=$_SESSION["chatctl"];
        $content=test_input($_POST["comment"]);
        $moodid=test_input($_POST["moodid"]);
        if(!empty($content))
        {
            $server_link=mysql_connect("127.0.0.1","root","root");
            $db_link=mysql_select_db("web",$server_link);
            $sql_id="select max(id) as id from comment";
            $result1=mysql_query($sql_id,$server_link);
            $rows=mysql_fetch_array($result1);
            $id=$rows[0];
            $id++;
            $sql="insert into comment values('$id','$moodid','$content','$email')";
            mysql_query($sql,$server_link);
            mysql_close($server_link);
            header("Location:action.php?code=$chatctl");
        }
    }
        
?>