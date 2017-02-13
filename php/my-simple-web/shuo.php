<?php
    session_start();
    $content="";
    $stra=[];
    if(isset($_GET["code"])&&$_GET["code"]==$_SESSION["chatctl"])
    {
        $chatctl=$_SESSION["chatctl"];
        $email=$_SESSION["email"];
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
border:1px solid #ccc;
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
function del(id)
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
    url="delmood.php?code='.$chatctl.'&moodi="+id;
    xmlhttp.open("GET",url,true);
    xmlhttp.send();    
}
function moogmsg()
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
    url="moodmsg.php?code='.$chatctl.'";
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
    setTimeout("moogmsg()",3000);    
}
</script>
</head>
<body onload="moogmsg()">
	<fieldset>
		<legend>my mood</legend>
        <form action="shuo_msg.php?code='.$chatctl.'" method="post">
        <textarea style=\'margin-bottom:4%;\' name="msg_mood"></textarea>
        <input type="submit" value="发表">
        </form>
        <div id="moodmsg"></div>
	</fieldset>
</body>
</html>';
    }
?>