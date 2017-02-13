<?php
    session_start();
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
label{
display:block;
}
textarea{
width:100%；
height:10em;
margin-left:20%;
margin-bottom:4%;
width:60%;
height:20%;
}
#content{
border:1px solid #ccc;
font-weight:bold;
font-size:20;
}
#good{
width:12%;
height:0%;
float:right;
margin-right:20%;
margin-top:-5%;
}
</style>
<script>
function words_show()
{
    if(window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    xmlhttp.onreadystatechange=function()
    {
        if(xmlhttp.readyState==4&&xmlhttp.status==200)
        {
            document.getElementById("liuyan").innerHTML=xmlhttp.responseText;
        }
    }
    url="words_show.php?code='.$chatctl.'";
    xmlhttp.open("GET",url,true);
    xmlhttp.send();  
}
</script>
</head>
<body onload="words_show()">
	<fieldset>
		<legend>my words board</legend>
		<div id="liuyan"></div>
        <div  id="content">
                <label for="text"></label>
                <div>zilong:<br><br>&nbsp&nbsp&nbsp23213213<br><br><p id="good">time</p><br></div>
        </div>
        <div  id="content">
                <label for="text"></label>
                <div>zilong:<br><br>&nbsp&nbsp&nbsp23213213<br><br><p id="good">time</p><br></div>
         </div>
	</fieldset>
</body>
</html>';
    }
?>