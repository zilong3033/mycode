<?php
    session_start();
    if(isset($_GET["code"])&&$_GET["code"]==$_SESSION["chatctl"])
    {
        $email=$_SESSION["email"];
        $chatctl=$_SESSION["chatctl"];
        echo '<html>
<head>
<style type="text/css">
fieldset{
margin-left:5%;
margin-right:5%;
margin-top:2%;
padding:2%;
border:1px solid #ccc;
background:#f8f8f8;
}
legend{
font-weight:bold;
font-size:20;
}
#content{
font-weight:bold;
font-size:20;
}
label{
display:block;
}
.imgs{
width:100%;
height:8%;
margin-top:2%;
}

#good{
width:5%;
height:50%;
float:right;
margin-right:2%;
}
#content{
border:1px solid #ccc;
font-weight:bold;
font-size:20;
}
#talkcontent
{
margin-left:3%;
}
#comment{
width:5%;
height:50%;
float:right;
margin-right:20%;
}
textarea{
width:100%；
height:10em;
margin-left:20%;
width:60%;
height:20%;
}
</style>
<script>
function talk(id)
{
    var content=document.getElementById(id).innerHTML;
    if(content==null || content.length==0)
        document.getElementById(id).innerHTML="<form action=\"comment.php?code='.$chatctl.'\" method=\"post\"><textarea style=\'margin-bottom:4%;\' name=\"comment\"></textarea><input type=\"hidden\" name=\"moodid\" value="+id+"><input type=\"submit\" value=\"发表\"></form>";
    else
        document.getElementById(id).innerHTML=null;
}
function friendaction()
{
    if(window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    xmlhttp.onreadystatechange=function()
    {
        if(xmlhttp.readyState==4&&xmlhttp.status==200)
        {
            document.getElementById("moodmsg").innerHTML=xmlhttp.responseText;
        }
    }
    url="friendaction.php?code='.$chatctl.'";
    xmlhttp.open("GET",url,true);
    xmlhttp.send();  
}
</script>
</head>
<body onload="friendaction()">
    <center><img src="refresh.png" onclick="javascript:friendaction()"></center><br>
	<fieldset>
		<legend>好友动态</legend>
        <div id="moodmsg"><div>
	</fieldset>
</body>
</html>';
    }
?>