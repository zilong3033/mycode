<?php
    session_start();
    if(isset($_SESSION["loadpocod"])&&isset($_GET["code"])&&$_GET["code"]==$_SESSION["loadpocod"]&&isset($_SESSION["code_session"]))
    {
        $zilong_zid=sha1("zilong_zid");
        $zilong_ckp=sha1("zilong_ckp");
        $zilong_pdcode=sha1("zilong_pdcode");
        if(isset($_COOKIE[$zilong_zid])&&isset($_COOKIE[$zilong_ckp])&&isset($_COOKIE[$zilong_pdcode]))
        {
            $chatctl=md5(rand(1000,9999));
            $_SESSION["chatctl"]=$chatctl;
            if(md5($_SESSION["email"])==$_COOKIE[$zilong_zid]&&sha1(md5($_SESSION["pwd"]))==$_COOKIE[$zilong_ckp]&&md5($_SESSION["code_session"])==$_COOKIE[$zilong_pdcode])
            {
                $email=$_SESSION["email"];
                $server_link=mysql_connect("127.0.0.1","root","root");
                $db_link=mysql_select_db("web",$server_link);
                $sql="select * from users where email='$email'";
                $result=mysql_query($sql,$server_link);
                $rows=mysql_fetch_array($result);
                $username=$rows[1];
                echo '
<html>
<head>
<meta charset="UTF-8">
<style type="text/css">
*{
margin:0;
padding:0;
}
body{
width:100%; 
height:100%;
background:#E5F6F2;
color:#fff;
}
#container{
width:100%;
}
#left{
float:left;
width:20%;
height:100%;
}
.logo{
width:12%;
height:10%;
margin-left:50%;
margin-top:3%;
float:left;
}	
#left h1{
margin-top:-10%;
margin-left:64%;
float:left;
font-size:200%;
color:#CB741B;
} 
#left a{
display:block;
text-decoration:none;
}
.name{
margin-left:20%;
font-size:25;
color:#CB741B;
}
.images{
width:30%;
height:20%;
margin-top:35%;
margin-left:20%;
margin-bottom:5%;
}
#mid{
width:60%;
float:left;
height:100%;
}
#mid p{
margin-left:40%;
margin-top:2%;
margin-bottom:1%;
font-size:20;
font-weight:bolder;
}
#mid input{
margin-left:35%;
border:1px solid #F7F7F1;
border-radius:3px;
width:20%;
height:4%;
}
#mid span{
margin-left:1%;
font-size:20;
font-weight:bolder;
}
#mid h3{
margin-top:2%;
margin-left:40%;
margin-bottom:1%;
font-size:30;
}
#content{
margin-left:27%;
}
#message{
background:#fff;
width:70%;
height:40%;
margin-left:10%;
}
#mid button{
margin-top:1%;
margin-left:35%;
margin-bottom:1%;
border:1px solid #F7F7F1;
border-radius:3px;
width:20%;
height:4%;
background:#D2F6F8;
color:#383637;
font-size:20;
}
.text{
margin-left:15%;
margin-top:3%;
}
#right{
width:20%;
float:right;
height:100%;
}
#right p{
font-size:20;
margin-top:10%;
margin-left:8%;
color:#CB741B;
}
#right ul{
margin-toP:7%;
margin-left:8%;
font-size:20;
}
#right ul li{
margin-bottom:6%;
list-style:none;
}
#right ul li a {
text-decoration:none;
}
#show{
float:right;
width:70%;
height:6%;
margin-right:30%;
margin-top:1%;
margin-bottom:8%;
background:#50A3A2;
border-radius:4px;
border:1px solid #fff;
padding:1% 4%;
}
.clear{
clear:both;
}
</style>
<script>
function msgcls()
{
    if(window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    xmlhttp.onreadystatechange=function()
    {
        if(xmlhttp.readyState==4&&xmlhttp.status==200)
        {
            alert(xmlhttp.responseText);
        }
    }
    xmlhttp.open("GET","cls.php?code='.$chatctl.'",true);
    xmlhttp.send();
}
function find()
{
    var arg=document.getElementById("show").value;
    if(window.XMLHttpRequest)
    {
        xmlhttp1=new XMLHttpRequest();
    }
    xmlhttp1.onreadystatechange=function()
    {
        if(xmlhttp1.readyState==4&&xmlhttp1.status==200)
        {
            document.getElementById("find").innerHTML=xmlhttp1.responseText
        }
    }
    url="find.php?code='.$chatctl.'&email="+arg;
    xmlhttp1.open("GET",url,true);
    xmlhttp1.send();
}
function getvalue(id)
{
	var x=document.getElementById(id);
	document.getElementById("b").value=x.title;
}
function delfriend(id)
{
    var email=document.getElementById(id).title;
    if(window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    xmlhttp.onreadystatechange=function()
    {
        if(xmlhttp.readyState==4&&xmlhttp.status==200)
        {
            alert(xmlhttp.responseText);
        }
    }
    url="delfriend.php?code='.$chatctl.'&email="+email;
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}
function friend()
{
    if(window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    xmlhttp.onreadystatechange=function()
    {
        if(xmlhttp.readyState==4&&xmlhttp.status==200)
        {
            document.getElementById("friends").innerHTML=xmlhttp.responseText
        }
    }
    xmlhttp.open("GET","friends.php?code='.$chatctl.'",true);
    xmlhttp.send();
    setTimeout("friend()",5000);
}
</script>
</head>
<body onload="javascript:friend()">
	<div id="containier">
		<div id="left">
			<img class="logo" src="12.gif" />
			<h1>聊聊呗</h1>
			<a href="zone.php?code='.$chatctl.'&cid=1"><img class="images" src="11.jpg"></a>
			<a href="zone.php?code='.$chatctl.'&cid=1"><span class="name">我的空间</span></a>
			<a href="zone.php?code='.$chatctl.'&cid=2"><img class="images" src="zhuye.jpg"></a>
			<a href="zone.php?code='.$chatctl.'&cid=2"><span class="name">我的主页</span></a>
		</div>
		<div id="mid">
			<form action="chat.php?code='.$chatctl.'" method="POST">
			<p>正在和</p>
			<input type="text" id="b" name="spker"/><span>聊天</span><br />
			<h3>内容</h3>
			<textarea cols="38" rows="15" id="content" name="content"></textarea><br />
			<button type="submit" >提&nbsp交</button><br />
            </form>
			<div id="message">
			<iframe src="msgrv_frame.php?code='.$chatctl.'"  scrolling="yes" style="margin-left:7%;margin-top:1%;height:90%;width:40%;" /></iframe>
			<iframe src="msgsd_frame.php?code='.$chatctl.'"  scrolling="yes" style="margin-left:3%;margin-top:1%;height:90%;width:40%;" /></iframe>
			</div>
			<button type="button" onclick="javascript:msgcls()" style="margin-top:1%;font-size:10;background:#D2F6F8">提交</button>
		</div>
		<div id="right">
			<p>我的用户名:'.$username.'</p>
			<ul>
			<p>好友添加</p><br>
				<input type="text" id="show" />
				<button type="button" style="margin:1% 40%;" onclick="javascript:find()">搜索</button><br /><p id="find"></p><br />
			<li><a href="home page.html" target=rframe>切换用户</a></li>
			<p>我的好友<br>(点好友名字，和他聊天)</p>
            <p id="friends"></p>
		</div>
</body>
</html>';
            }
            else{
                header("Location:home page.html");
                echo "身份验证失败!";
            }
        }
        else{
            header("Location:home page.html");
            echo "没有登录";
        }
    }
    else{
        header("Location:home page.html");
        echo "非法进入！";
    }
?>