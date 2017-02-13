<?php
    session_start();
    $strs=[];
    $strt=[];
    $content="";
    if(isset($_GET["code"])&&$_GET["code"]==$_SESSION["chatctl"])
    {
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
                $strt[]=$row[2];
                $strs[]=$row[1];
            }
            else
            {
                while($row=mysql_fetch_array($result))
                {
                    $strt[]=$row[2];
                    $strs[]=$row[1];
                }
            }
        }
        mysql_close($server_link);
        $j=0;
        for($i=count($strs)-1;$i>=0;$i--)
        {
            $j++;
            if($j==3)
            {
                $j==0;
                $content=$content."<u><font size=4 color=#50A3A2 id=$i title='$strs[$i]' onclick='javascript:getvalue(id)' >$strt[$i]</font></u><br>";
            }
            else
            {
                $content=$content."<u><font size=4 color=#50A3A2 id=$i title='$strs[$i]' onclick='javascript:getvalue(id)' >$strt[$i]</font></u><button id=$i type='button' style='margin:0% 20%;' onclick='javascript:delfriend(id)'>删除</button>";
            }
        }
        echo $content;
    }
?>