<?php
    session_start();
    $stra=[];
    $content="";
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
        $server_link=mysql_connect("127.0.0.1","root","root");
        $db_link=mysql_select_db("web",$server_link);
        $sql="select * from words where email='$email'";
        if($result=mysql_query($sql,$server_link))
        {
            $num=mysql_num_rows($result);
            if($num==1)
            {
                $row=mysql_fetch_array($result);
                $sql1="select username from users where email='$row[2]'";
                $result1=mysql_query($sql1,$server_link);
                $rows=mysql_fetch_array($result1);
                $username=$rows[0];
                $stra[]='<div  id="content">
                <label for="text"></label>
                <div>'.$username.':<br><br>&nbsp&nbsp&nbsp'.$row[3].'<br><br><p id="good">'.$row[4].'</p><br></div>
        </div>';
            }
            else{
                while($row=mysql_fetch_array($result))
                {
                    $sql1="select username from users where email='$row[2]'";
                    $result1=mysql_query($sql1,$server_link);
                    $rows=mysql_fetch_array($result1);
                    $username=$rows[0];                    
                    $stra[]='<div  id="content">
                <label for="text"></label>
                <div>'.$username.':<br><br>&nbsp&nbsp&nbsp'.$row[3].'<br><br><p id="good">'.$row[4].'</p><br></div>
        </div>';
                }
            }
        }
        for($i=count($stra)-1;$i>=0;$i--)
        {
            $content=$content.$stra[$i];
        }
        echo $content;  
    }
?>