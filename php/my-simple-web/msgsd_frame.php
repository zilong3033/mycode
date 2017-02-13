<?php
    session_start();
    if(isset($_GET["code"])&&$_GET["code"]==$_SESSION["chatctl"])
    {
        $chatctl=$_SESSION["chatctl"];
        echo '
<html>
<body onload="javascript:sdrefresh()">
<script>
function sdrefresh()
{
    if(window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4&&xmlhttp.status==200)
        {
            document.getElementById("send").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","msg_send.php?code='.$chatctl.'",true);
    xmlhttp.send();
    setTimeout("sdrefresh()",3000);
}
</script>
<center>
<B><font size=4>发送的的消息:</font></B><br><br>
<p><span id="send"></span></p>
</center>
</body>
</html>';
    }
?>