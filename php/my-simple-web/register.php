<?php
    session_start();
    $posts=rand(1000,9999);
    $postr=md5($posts);
    $_SESSION["regpocod"]=$postr;
    $ref=rand(1000,9999);
    $refer=md5($ref);
    $_SESSION["regrefer"]=$refer;
    echo '
<html>
<head>
<head>
<meta charset="UTF-8">
<style type="text/css">
*{
margin:0;
padding:0;}
body{
color:#FFF;
}
.context{
background:#50A3A2;
postion:absolute;
color:#FFFFFF;
width:100%;
}
.container h1{
padding-top:3%;
padding-bottom:1%;
font-size:40;
font-weight:300;
margin-left:34%;
}
form input{
border:1px solid #fff;
width:38%;
padding:1% 2%;
margin-top:4%;
border-radius:20px;
font-size:20px;
font-weight:200;
}
.yz{
width:42%;
border-radius:10px;
background:#fff;
color:#0c3;
font-size:16px;
padding:10px;
margin-top:20px;
}
#yz{
width:42%;
border-radius:10px;
background:#fff;
color:#0c3;
font-size:16px;
padding:10px;
margin-top:20px;
}
form button:hover{
background:#ccc;
}
#useridchack{
margin-left:65%;
margin-top:-4%;
}
#codechack{
margin-left:65%;
margin-top:-4%;
}
#pwdchack{
margin-left:65%;
margin-top:-4%;
}
</style>
<script>
function chackid()
{
    var username=document.forms["myForm"]["userId"].value;
    if(username=="")
    {
        document.getElementById("useridchack").innerHTML="用户名不能为空！"
    }
    else{
        document.getElementById("useridchack").innerHTML=""
    }
}
function chackcode()
{
    var username=document.forms["myForm"]["code"].value;
    if(username=="")
    {
        document.getElementById("codechack").innerHTML="验证码不能为空！"
    }
    else{
        document.getElementById("codechack").innerHTML=""
    }
}
function chackpwd()
{
    var username=document.forms["myForm"]["userPw"].value;
    if(username=="")
    {
        document.getElementById("pwdchack").innerHTML="密码不能为空！"
    }
    else{
        document.getElementById("pwdchack").innerHTML=""
    }
}
function validateForm(){
	var x=document.forms["myForm"]["email"].value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length){
		alert("请输入有效的邮箱地址");
  		return false;
	}
    else{
        if(window.XMLHttpRequest)
        {
            xmlhttp=new XMLHttpRequest();
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4&&xmlhttp.status==200)
            {
                document.getElementById("yz").value=xmlhttp.responseText;
            }
        }
        var strs="/web/email/email.php?code='.$refer.'&email="+x
        xmlhttp.open("GET",strs,true);
        xmlhttp.send();
        return true;
    }
}
	</script>
</head>
<body>
	<div class="context">
		<div class="container">
			<h1>注册</h1>
			<form action="reg.php?code='.$postr.'" method="POST" name="myForm">
				<span style="margin-left:10%;">用户名:<input type="text" name="userId"  onblur="javascript:chackid();"/></span><p id="useridchack"></p><br />
				<span style="margin-left:10%;">&nbsp密码:<input type="password" name="userPw" onblur="javascript:chackpwd();"/></span><p id="pwdchack"></p><br />
				<span style="margin-left:10%;">&nbsp邮箱:<input type="text" name="email" />
				<input id="yz" type="button" value="点击验证" onclick="return validateForm();" style="margin-left:10px;width:150px;height:50px;"/><br />
				<span style="margin-left:10%;">验证码:<input type="text" name="code" onblur="javascript:chackcode();"/></span><p id="codechack"></p><br />
				<span style="margin-left:10%;">&nbsp&nbsp&nbsp<input class="yz" type="submit" value="注&nbsp;&nbsp;&nbsp;册" style="text-align:center;"/></span><br /><br /><br /><br /><br /><br />
			</form>
		</div>
	</div>
</body>
</html>';
?>