<?php
    session_start();
    function test_input($data)
    {
        $data=trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
    } 
    if(isset($_GET["code"])&&$_GET["code"]==$_SESSION["chatctl"]&&isset($_GET["email"]))
    {
        $friend_email=test_input($_GET["email"]);
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
width:12%;
height:0%;
float:right;
margin-right:20%;
margin-top:-5%;
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
function friends_words_show()
{
    if(window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    xmlhttp.onreadystatechange=function()
    {
        if(xmlhttp.readyState==4&&xmlhttp.status==200)
        {
            document.getElementById("friendswords").innerHTML=xmlhttp.responseText;
        }
    }
    url="friends_words_show.php?code='.$chatctl.'&email='.$friend_email.'";
    xmlhttp.open("GET",url,true);
    xmlhttp.send();  
}
</script>
</head>
<body onload="friends_words_show()">
	<fieldset>
		<legend>friend words</legend>
        <form action="wordstofriends.php?code='.$chatctl.'&email='.$friend_email.'" method="post">
        <textarea style=\'margin-bottom:4%;\' name="words"></textarea>
        <input type="submit" value="发表">
        </form>
        <div id="friendswords"></div>
	</fieldset>
</body>
</html>';
    }
?>