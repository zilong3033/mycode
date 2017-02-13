<?php
    session_start();
    $stra=[];
    $content="";
    if(isset($_GET["code"])&&$_GET["code"]==$_SESSION["chatctl"])
    {
        $chatctl=$_SESSION["chatctl"];
        $email=$_SESSION["email"];
        $server_link=mysql_connect("127.0.0.1","root","root");
        $db_link=mysql_select_db("web",$server_link);
        $sql="select * from mood where email='$email'";
        $sql1="select username from users where email='$email'";
        $result1=mysql_query($sql1,$server_link);
        $rows=mysql_fetch_array($result1);
        $username=$rows[0];
        if($result=mysql_query($sql,$server_link))
        {
            $num=mysql_num_rows($result);
            if($num==1)
            {
                $row=mysql_fetch_array($result);
                $stra[]='<div  id="content">
			<label for="text"></label>
			<div>'.$username.':<br><br>&nbsp&nbsp&nbsp'.$row[2].'<br><br>'.$row[3].'</div>
			<div class="imgs">
			<img id="comment" src="del.png" onclick="javascript:del(\'.$row[0].\')">
			<img id="good" src="zhuanfa.png">
			</div><br>';
            }
            else
            {
                while($row=mysql_fetch_array($result))
                {
                    $stra[]='<div  id="content">
			<label for="text"></label>
			<div>'.$username.':<br><br>&nbsp&nbsp&nbsp'.$row[2].'<br><br>'.$row[3].'</div>
			<div class="imgs">
			<img id="comment" src="del.png" onclick="javascript:del(\''.$row[0].'\')">
			<img id="good" src="zhuanfa.png">
			</div><br>';
                }
            }
        }
        mysql_close($server_link);
        $j=0;
        for($i=count($stra)-1;$i>=0;$i--)
        {
            $j++;
            if($j==3)
            {
                $j==0;
                $content=$content.$stra[$i];
            }
            else
            {
                $content=$content.$stra[$i];
            }
        }
        echo $content;
    }
?>