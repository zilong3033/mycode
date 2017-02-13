<?php
    session_start();
    $stra=[];
    $content="";
    $comments="";
    $com=[];
    $friendsa=[];
    if(isset($_GET["code"])&&$_GET["code"]==$_SESSION["chatctl"])
    {
        $chatctl=$_SESSION["chatctl"];
        $email=$_SESSION["email"];
        $server_link=mysql_connect("127.0.0.1","root","root");
        $db_link=mysql_select_db("web",$server_link);
        $sql="select * from friends where email='$email'";
        if($result=mysql_query($sql,$server_link))
        {
            $num=mysql_num_rows($result);
            if($num==1)
            {
                $row=mysql_fetch_array($result);
                $friendsa[]=$row[1];
            }
            else{
                while($row=mysql_fetch_array($result))
                {
                    $friendsa[]=$row[1];
                }
            }
        }
         $friendsa[]=$email;
        $sql="select max(id) as id from mood";
        $result=mysql_query($sql,$server_link);
        $row=mysql_fetch_array($result);
        $num=$row[0];
        for($id=1;$id<=$num;$id++)
        {
            for($i=0;$i<count($friendsa);$i++)
            {
                $sql="select * from mood where id=$id and email='$friendsa[$i]'";
                $result=mysql_query($sql,$server_link);
                $row=mysql_fetch_array($result);
                if($row)
                {
                    $sql1="select username from users where email='$friendsa[$i]'";
                    $result1=mysql_query($sql1,$server_link);
                    $rows=mysql_fetch_array($result1);
                    $username=$rows[0];
                    $comment_id=(string)$row[0]."_comment";
                    $sql2="select * from comment where moodid=$id";
                    if($result2=mysql_query($sql2,$server_link))
                    {
                        $num2=mysql_num_rows($result2);
                        if($num2==1)
                        {
                            $row2=mysql_fetch_array($result2);
                            $sql3="select username from users where email='$row2[3]'";
                            $result3=mysql_query($sql3,$server_link);
                            $rows3=mysql_fetch_array($result3);
                            $com[]="<p id='talkcontent'>$rows3[0]:$row2[2]</p>";
                        }
                       else
                       {
                            while($row2=mysql_fetch_array($result2))
                            {
                                $sql3="select username from users where email='$row2[3]'";
                                $result3=mysql_query($sql3,$server_link);
                                $rows3=mysql_fetch_array($result3);
                                $com[]="<p id='talkcontent'>$rows3[0]:$row2[2]</p>";
                            }   
                       }
                        
                    }
                    for($j=count($com)-1;$j>=0;$j--)
                    {
                        $comments=$comments.$com[$j];
                    }
                    $stra[]='<div  id="content">
                <label for="text"></label>
                <div>'.$username.':<br><br>&nbsp&nbsp&nbsp'.$row[2].'<br><br>'.$row[3].'</div>
                <div class="imgs">
                <img id="comment" src="talk.png" onclick="javascript:talk('.$row[0].')">
                <img id="good" src="good.png">
                </div><br>
                <div id='.$comment_id.'>'.$comments.'<div>
                <div id='.$row[0].'></div>';
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