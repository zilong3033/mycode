<?php
    session_start();
    $posts=rand(1000,9999);
    $postr=md5($posts);
    $_SESSION["loadpocod"]=$postr;
    echo '
<html>
<head>
<head>
<meta charset="UTF-8">
<style type="text/css">
*{
margin:0;
padding:0;
}
body{
color:#FFF;
}
.context{
background:#50A3A2;
postion:absolute;
color:#FFFFFF;
width:100%；
}
.container h1{
padding-top:3%;
padding-bottom:1%;
font-size:40;
font-weight:300;
margin-left:34%;
}
.user{
border:1px solid #fff;
width:38%;
padding:1% 2%;
margin-top:6%;
margin-left:20%;
border-radius:20px;
font-size:20px;
font-weight:200;
}
form button{
width:42%;
border-radius:10px;
background:#fff;
padding:10px 15px;
color:#0c3;
font-size:16px;
margin-top:20px;
margin-left:20%;
}
form button:hover{
background:#ccc;
}
</style>
</head>
<body>
	<div class="context">
		<div class="container">
			<h1>登录</h1>
			<form action="load_rq.php?code='.$postr.'" method="POST" >
				<input type="text" name="email" placeholder="请输入邮箱" class="user" name="email"/><br />
				<input type="password" name="userPw" placeholder="请输入密码" class="user"/><br />
				<input type="text" name="code" placeholder="请输入验证码" class="user"/>
				<img  title="点击刷新" src="ValidateCode\captcha_exp.php" align="absbottom" onclick="this.src=\'ValidateCode\\\captcha_exp.php?\'+Math.random();"></img>
				<button type="submit">登&nbsp;&nbsp;&nbsp;录</button><br /><br /><br /><br /><br /><br /><br /><br />
			</form>
		</div>
	</div>
</body>
</html>';
?>
