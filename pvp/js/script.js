var dataInfo, btnShow1 = 0, btnShow2 = 0, btnShow3 = 0;

document.getElementById("pic1").onmouseover = function()
{
    this.style.cursor = 'pointer';
}
document.getElementById("pic2").onmouseover = function()
{
    this.style.cursor = 'pointer';
}
document.getElementById("pic3").onmouseover = function()
{
    this.style.cursor = 'pointer';
}
btnShow();

$("#submit1").on("click", () => {showInfo(1);});
$("#submit2").on("click", () => {showInfo(2);});

$("#mode11").on("click", () => {showResult(110);});
$("#mode12").on("click", () => {showResult(119);});
$("#mode13").on("click", () => {showResult(125);});
$("#mode14").on("click", () => {showResult(132);});

$("#mode15").on("click", () => {showResult(137);});
$("#mode16").on("click", () => {showResult(143);});
$("#mode17").on("click", () => {showResult(148);});
$("#mode18").on("click", () => {showResult(162);});

$("#mode19").on("click", () => {showResult(173);});
$("#mode1a").on("click", () => {showResult(180);});
$("#mode1b").on("click", () => {showResult(181);});
$("#mode1c").on("click", () => {showResult(184);});


$("#mode21").on("click", () => {showResult(210);});
$("#mode22").on("click", () => {showResult(219);});
$("#mode23").on("click", () => {showResult(225);});
$("#mode24").on("click", () => {showResult(232);});

$("#mode25").on("click", () => {showResult(237);});
$("#mode26").on("click", () => {showResult(243);});
$("#mode27").on("click", () => {showResult(248);});
$("#mode28").on("click", () => {showResult(262);});

$("#mode29").on("click", () => {showResult(273);});
$("#mode2a").on("click", () => {showResult(280);});
$("#mode2b").on("click", () => {showResult(281);});
$("#mode2c").on("click", () => {showResult(284);});


$("#mode31").on("click", () => {showResult(310);});
$("#mode32").on("click", () => {showResult(319);});
$("#mode33").on("click", () => {showResult(325);});
$("#mode34").on("click", () => {showResult(332);});

$("#mode35").on("click", () => {showResult(337);});
$("#mode36").on("click", () => {showResult(343);});
$("#mode37").on("click", () => {showResult(348);});
$("#mode38").on("click", () => {showResult(362);});

$("#mode39").on("click", () => {showResult(373);});
$("#mode3a").on("click", () => {showResult(380);});
$("#mode3b").on("click", () => {showResult(381);});
$("#mode3c").on("click", () => {showResult(384);});

function btnShow()
{
    if (btnShow1 == 1)
    {
        $("#mode11").show();
        $("#mode12").show();
        $("#mode13").show();
        $("#mode14").show();
        $("#mode15").show();
        $("#mode16").show();
        $("#mode17").show();
        $("#mode18").show();
        $("#mode19").show();
        $("#mode1a").show();
        $("#mode1b").show();
        $("#mode1c").show();
    }
    else
    {
        $("#mode11").hide();
        $("#mode12").hide();
        $("#mode13").hide();
        $("#mode14").hide();
        $("#mode15").hide();
        $("#mode16").hide();
        $("#mode17").hide();
        $("#mode18").hide();
        $("#mode19").hide();
        $("#mode1a").hide();
        $("#mode1b").hide();
        $("#mode1c").hide();
    }
    if (btnShow2 == 1)
    {
        $("#mode21").show();
        $("#mode22").show();
        $("#mode23").show();
        $("#mode24").show();
        $("#mode25").show();
        $("#mode26").show();
        $("#mode27").show();
        $("#mode28").show();
        $("#mode29").show();
        $("#mode2a").show();
        $("#mode2b").show();
        $("#mode2c").show();
    }
    else
    {
        $("#mode21").hide();
        $("#mode22").hide();
        $("#mode23").hide();
        $("#mode24").hide();
        $("#mode25").hide();
        $("#mode26").hide();
        $("#mode27").hide();
        $("#mode28").hide();
        $("#mode29").hide();
        $("#mode2a").hide();
        $("#mode2b").hide();
        $("#mode2c").hide();
    }
    if (btnShow3 == 1)
    {
        $("#mode31").show();
        $("#mode32").show();
        $("#mode33").show();
        $("#mode34").show();
        $("#mode35").show();
        $("#mode36").show();
        $("#mode37").show();
        $("#mode38").show();
        $("#mode39").show();
        $("#mode3a").show();
        $("#mode3b").show();
        $("#mode3c").show();
    }
    else
    {
        $("#mode31").hide();
        $("#mode32").hide();
        $("#mode33").hide();
        $("#mode34").hide();
        $("#mode35").hide();
        $("#mode36").hide();
        $("#mode37").hide();
        $("#mode38").hide();
        $("#mode39").hide();
        $("#mode3a").hide();
        $("#mode3b").hide();
        $("#mode3c").hide();
    }
}

function blank()
{
    document.getElementById("pic1").src="";
    document.getElementById("pic2").src="";
    document.getElementById("pic3").src="";
    document.getElementById("txtInfo").innerHTML="";
    document.getElementById("txtInfo1").innerHTML="";
    document.getElementById("txtInfo2").innerHTML="";
    document.getElementById("txtInfo3").innerHTML="";
    document.getElementById("streamName1").innerHTML="";
    document.getElementById("streamName2").innerHTML="";
    document.getElementById("streamName3").innerHTML="";
    btnShow1 = 0;
    btnShow2 = 0;
    btnShow3 = 0;
}

function picShow()
{
    var pic1 = document.getElementById("pic1"),
    pic2 = document.getElementById("pic2"),
    pic3 = document.getElementById("pic3"),
    str1 = document.getElementById("streamName1"),
    str2 = document.getElementById("streamName2"),
    str3 = document.getElementById("streamName3"),
    txt1 = document.getElementById("txtInfo1"),
    txt2 = document.getElementById("txtInfo2");
    
    switch (dataInfo['num'])
    {
        case 1:
        {
            str1.innerHTML = dataInfo['stream'][0];
            pic1.src = dataInfo['pic'][0];
            btnShow1 = 1;
            btnShow();
            break;
        }
        case 2:
        {
            str1.innerHTML = dataInfo['stream'][0];
            pic1.src = dataInfo['pic'][0];
            btnShow1 = 1;
            txt1.innerHTML = "<br/><br/>";
            str2.innerHTML = dataInfo['stream'][1];
            pic2.src = dataInfo['pic'][1];
            btnShow2 = 1;
            btnShow();
            break;
        }
        case 3:
        {
            str1.innerHTML = dataInfo['stream'][0];
            pic1.src = dataInfo['pic'][0];
            btnShow1 = 1;
            txt1.innerHTML = "<br/><br/>";
            str2.innerHTML = dataInfo['stream'][1];
            pic2.src = dataInfo['pic'][1];
            btnShow2 = 1;
            txt2.innerHTML = "<br/><br/>";
            str3.innerHTML = dataInfo['stream'][2];
            pic3.src = dataInfo['pic'][2];
            btnShow3 = 1;
            btnShow();
            break;
        }
    }
}

function showInfo(num)
{
    blank();
    btnShow();
    $("#loading").html("<center>加载中...</center><br/><center><img src='../img/bungieload.gif' width='50%' /></center>");
    
    var str;
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
        blank();
        btnShow();
        $("#loading").empty();
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
    
    $.getJSON("../search/getInfo.php?q="+str, function(res){
        $("#loading").empty();
        dataInfo = res;
        if (dataInfo["result"] == 1)
        {
            picShow();
        }
        else
        {
            document.getElementById("txtInfo").innerHTML = dataInfo['str'];
        }
    })
}

function showResult(choice)
{
    var txt1 = document.getElementById("txtInfo1"),
    txt2 = document.getElementById("txtInfo2"),
    txt3 = document.getElementById("txtInfo3"),
    decision, mValue;
    
    decision = parseInt(choice / 100);
    mValue = parseInt(choice % 100);
    mValue = mValue.toString();
    
    switch (decision)
    {
        case 1:
        {
            txt1.innerHTML = "<center>加载中...</center><br/><center><img src='../img/bungieload.gif' width='50%' /></center><br/><br/>";
            
            $.getJSON("../db/pvp.php?fin="+dataInfo['info']+"&cin="+dataInfo['chara'][0]+"&mode="+mValue, function(res1){
                console.log(res1);
                txt1.innerHTML = res1['res'];
            })
            
            break;
        }
        case 2:
        {
            txt2.innerHTML = "<center>加载中...</center><br/><center><img src='../img/bungieload.gif' width='50%' /></center><br/><br/>";
            
            $.getJSON("../db/pvp.php?fin="+dataInfo['info']+"&cin="+dataInfo['chara'][1]+"&mode="+mValue, function(res2){
                console.log(res2);
                txt2.innerHTML = res2['res'];
            })
            
            break;
        }
        case 3:
        {
            txt3.innerHTML = "<center>加载中...</center><br/><center><img src='../img/bungieload.gif' width='50%' /></center>";
            
            $.getJSON("../db/pvp.php?fin="+dataInfo['info']+"&cin="+dataInfo['chara'][2]+"&mode="+mValue, function(res3){
                txt3.innerHTML = res3['res'];
            })
            
            break;
        }
    }
}
