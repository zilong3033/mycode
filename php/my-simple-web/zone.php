<?php
    session_start();
    $cid=0;
    if(isset($_GET["code"])&&isset($_GET["cid"])&&$_GET["code"]==$_SESSION["chatctl"])
    {
        $chatctl=$_SESSION["chatctl"];
        $email=$_SESSION["email"];
        if($_GET["cid"]==1)
        {
            $cid=1;
        }
        if($_GET["cid"]==2)
        {
            $cid=2;
        }
        $server_link=mysql_connect("127.0.0.1","root","root");
        $db_link=mysql_select_db("web",$server_link);
        $sql="select username from users where email='$email'";
        $result=mysql_query($sql,$server_link);
        $rows=mysql_fetch_array($result);
        $username=$rows[0];
        echo '<html>
<head>
<meta charset="UTF-8">
<style type="text/css">
*{
margin:0;
padding:0;
}
#header {
width:100%;
height:8%;
background:black;
}
#title{
width:100%;
height:18%;
background:#50A3A2;
}
#L{
width:20%;
float:left;
}
#R{
margin-left:80%;
font-size:24;
color:#fff;
padding-top:2%;
}
#C{
margin-left:40%;
font-size:36;
color:#fff;
padding-top:2%;
}
#calendar{
padding-left:2%;
padding-top:3%;
font-size:18;
color:#fff;
}
#txt{
padding-left:2%;
padding-top:2%;
font-size:18;
color:#fff;
}
#left{
width:20%;
background:#50A3A2;
float:left;
height:100%;
}
#left h3{
padding-top:5%;
padding-left:15%;
font-size:34;
color:#A9F8E6;
}
#left ul{
margin-left:10%;
margin-top:10%;
}
#left ul li{
list-style:none;
font-size:20;
margin-bottom:8%;
}
#left ul li a{
text-decoration:none;
color:#EAE41F;
}
#mid{
width:50%;
background:#fff;
float:left;
height:100%;
}
#right{
width:30%;
background:#50A3A2;
float:left;
height:100%;
}
#right li{
list-style:none;
margin-top:3%;
}
#right li a{
text-decoration:none;
font-size:30;
color:#EAE41F;
margin-left:6%;
}
#right iframe{
margin-top:10%;
margin-left:10%;
height:60%;
}
.clear{
clear:both;
}
#friend{
margin-left:6%;
background:#50A3A2;
border:1px solid #ccc;
font-size:20;
width:80%;
height:60%;
margin-top:10%;
margin-left:10%;
}
</style>
<script>
function showTime(){
   var date=new Date();
   var year=date.getFullYear(); //获取当前年份
   var mon=date.getMonth()+1; //获取当前月份
   var da=date.getDate(); //获取当前日
   var h=date.getHours();
   var m=date.getMinutes();
   var s=date.getSeconds();// 在小于10的数字钱前加一个‘0’
   m=checkTime(m);
   s=checkTime(s);
   var d=document.getElementById(\'calendar\'); 
   d.innerHTML=year+\'/\'+mon+\'/\'+da;
   document.getElementById(\'txt\').innerHTML=h+":"+m+":"+s;
   t=setTimeout(function(){showTime()},500);
   }
   function checkTime(i){
	if (i<10){
		i="0" + i;
	}
	return i;
}

function dowhat(){
    var tag='.$cid.'
    if(tag==1)
    {
        document.getElementById("action").src="shuo.php?code='.$chatctl.'";
    }
    if(tag==2)
    {
        document.getElementById("action").src="action.php?code='.$chatctl.'";
    }
}
function getvalue(email)
{
    document.getElementById("action").src="friendswords.php?code='.$chatctl.'&email="+email;
}
function friends()
{
    if(window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    xmlhttp.onreadystatechange=function()
    {
        if(xmlhttp.readyState==4&&xmlhttp.status==200)
        {
            document.getElementById("friends").innerHTML=xmlhttp.responseText;
        }
    }
    url="friends_words.php?code='.$chatctl.'";
    xmlhttp.open("GET",url,true);
    xmlhttp.send();  
}
function doit()
{
    showTime();
    dowhat();
    friends();
}
</script>
</head>
<body onload="doit()">
	<div id="header">
		<div id="L">
			<div id="calendar">
			</div>
			<div id="txt">
			</div>
		</div>
		<div id="R">我是:'.$username.'</div>
	</div>
    <div id="title">
        <div id="C">My Zone</div>
    </div>
	<div id="container">
		<div id="left">
			<h3>我的空间</h3>
            <div>
			<img src="100.jpg" style="width:50%;height:25%;margin-left:18%;margin-top:3%;" onclick="uploadimg()"></div>
			<ul>
				<li><a href="shuo.php?code='.$chatctl.'" target=rframe>我的说说</a></li>
				<li><a href="liuyan.php?code='.$chatctl.'" target=rframe>我的留言板</a></li>
                <li><a href="action.php?code='.$chatctl.'" target=rframe>我的主页</a></li>
                <li><a href="">我的相册</a></li>
			</ul>
			
		</div>
		<div id="mid">
			<iframe id="action" name="rframe" width=100% height=100% scrolling="yes" frameborder="0" src=""></iframe>
		</div>
		<div id="right">
			<li><a href="" target=>给好友留言</a></li>
            <div id="friend"><br>
                <div id="friends"></div>
            <div>
		</div>
		<div class="clear">
		</div>
	</div>
</body>
</html>';
    }
?>