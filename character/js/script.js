function showInfo(num)
{
    $("#txtInfo").html(" ");
    $("#loading").html("<center>加载中...</center><br/><center><img src='../img/bungieload.gif' width='50%' /></center>");
    
    var xmlhttp, str;
    if(num==1)
    {
        str=$("#nick1").val();
    }
    else
    {
        str=$("#nick2").val();
    }
    if (str === "")
    { 
        $("#loading").empty();
        document.getElementById("txtInfo").innerHTML=" ";
        return;
    }
    
    var pos1, pos2, strtemp;
    while(str.indexOf("#") > -1)
    {
        pos1 = str.indexOf("#");
        pos2 = pos1 + 1;
        
        strtemp = str.substring(0, pos1) + "%23" + str.substring(pos2, (str.length));
        str = strtemp;
    }
    
    if (window.XMLHttpRequest)
    {
        // IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
        xmlhttp=new XMLHttpRequest();
    }
    else
    {
        // IE6, IE5 浏览器执行代码
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            $("#loading").empty();
            document.getElementById("txtInfo").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","../search/getName.php?q="+str,true);
    xmlhttp.send();
}

$("#submit1").on("click", () => {showInfo(1);});
$("#submit2").on("click", () => {showInfo(2);});
