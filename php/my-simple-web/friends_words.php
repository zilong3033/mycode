<?php
    session_start();
    $strt=[];
    $stra=[];
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
                $stra[]=$row[1];
            }
            else
            {
                while($row=mysql_fetch_array($result))
                {
                    $strt[]=$row[2];
                    $stra[]=$row[1];
                }
            }
        }
        mysql_close($server_link);
        $j=0;
        for($i=count($strt)-1;$i>=0;$i--)
        {
            $j++;
            if($j==3)
            {
                $j==0;
                $content=$content.'<font color=#A9F8E6 onclick="javascript:getvalue(\''.$stra[$i].'\')">&nbsp<u>'.$strt[$i].'</u></font><br>';
            }
            else
            {
                $content=$content.'<font color=#A9F8E6 onclick="javascript:getvalue(\''.$stra[$i].'\')">&nbsp<u>'.$strt[$i].'</u></font>';
            }
        }
        echo $content;
    }
?>