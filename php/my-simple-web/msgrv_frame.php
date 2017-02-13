<?php
    session_start();
    if(isset($_GET["code"])&&$_GET["code"]==$_SESSION["chatctl"])
    {
        $chatctl=$_SESSION["chatctl"];
        echo '
<html>
<body onload="javascript:rvrefresh()">
<script>
function rvrefresh()
{
    if(window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4&&xmlhttp.status==200)
        {
            document.getElementById("recv").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","msg_recv.php?code='.$chatctl.'",true);
    xmlhttp.send();
    setTimeout("rvrefresh()",3000);
}
</script>
<center>
<B><font size=4>接收的消息:</font></B><br><br>
<p><span id="recv"></span></p>
</center>
</body>
</html>';
    }
?>