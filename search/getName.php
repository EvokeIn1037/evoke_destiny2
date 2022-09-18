<?php

    header("Content-Type: text/html; charset=utf-8");
    
    function curl_get_http($url, $api)
    {
        // create curl resource
        $ch = curl_init();
        
        // set url
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $api);
        curl_setopt($ch, CURLOPT_HEADER, 0);
      
     
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     
        // $output contains the output string
        $output = curl_exec($ch);
        
        // close curl resource to free up system resources
        curl_close($ch);
        
        return $output;
    }
    
    function curl_get_http_p($ourl, $api, $param)
    {
        // create curl resource
        $ch = curl_init();
        
        $url = $ourl . '?' . http_build_query($param);
        
        // set url
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $api);
        curl_setopt($ch, CURLOPT_HEADER, 0);
      
     
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     
        // $output contains the output string
        $output = curl_exec($ch);
        
        // close curl resource to free up system resources
        curl_close($ch);
        
        return $output;
    }
    
    function curl_get_http0($ourl, $param)
    {
        // create curl resource
        $ch = curl_init();
        
        $url = $ourl . '?' . http_build_query($param);
        
        // set url
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
     
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     
        // $output contains the output string
        $output = curl_exec($ch);
        echo $output;
        
        // close curl resource to free up system resources
        curl_close($ch);
    }
    
    function detail_output($pro, $mno, $cno)
    {
        if ($pro['Response']['character']['data']['classType'] == 1)
        {
            $classcontent = "猎人 ";
        }
        else if($pro['Response']['character']['data']['classType'] == 2)
        {
            $classcontent = "术士 ";
        }
        else
        {
            $classcontent = "泰坦 ";
        }
        
        if ($pro['Response']['character']['data']['raceType'] == 0)
        {
            $classcontent = $classcontent."人类";
        }
        else if($pro['Response']['character']['data']['raceType'] == 1)
        {
            $classcontent = $classcontent."觉醒者";
        }
        else
        {
            $classcontent = $classcontent."EXO";
        }
        
        if ($pro['Response']['character']['data']['genderType'] == 0)
        {
            $classcontent = $classcontent."男性";
        }
        else
        {
            $classcontent = $classcontent."女性";
        }
        
        $str = $pro['Response']['character']['data']['dateLastPlayed'];
        $i1 = strpos($str, "T");
        $str = substr($str, 0, $i1)."  ".substr($str, ($i1+1), (strlen($str)));
        $i2 = strpos($str, "Z");
        $str = substr($str, 0, $i2);
        
        $strt = $pro['Response']['character']['data']['minutesPlayedTotal'];
        $time = intval($strt);
        if($time > 60)
        {
            $timeh = $time / 60;
            $timeh = (int)$timeh;
            $timem = $time % 60;
            
            $timecontent = $timeh."小时".$timem."分钟";
        }
        else
        {
            $timecontent = $time."分钟";
        }
        
        $light = $pro['Response']['character']['data']['light'];
        $mobility = $pro['Response']['character']['data']['stats']['2996146975'];
        $resilience = $pro['Response']['character']['data']['stats']['392767087'];
        $recovery = $pro['Response']['character']['data']['stats']['1943323491'];
        $discipline = $pro['Response']['character']['data']['stats']['1735777505'];
        $intellect = $pro['Response']['character']['data']['stats']['144602215'];
        $strength = $pro['Response']['character']['data']['stats']['4244567218'];
        
        $table = "<table frame=\"void\">
        <tr>
        <td>职业：</td>
        <td>$classcontent</td>
        </tr>
        <tr>
        <td>上次登陆时间：</td>
        <td>$str</td>
        </tr>
        <tr>
        <td>游戏时长：</td>
        <td>$timecontent</td>
        </tr>
        <tr>
        <td>光等：</td>
        <td>$light</td>
        </tr>
        <tr>
        <td>敏捷：</td>
        <td>$mobility</td>
        </tr>
        <tr>
        <td>韧性：</td>
        <td>$resilience</td>
        </tr>
        <tr>
        <td>恢复：</td>
        <td>$recovery</td>
        </tr>
        <tr>
        <td>纪律：</td>
        <td>$discipline</td>
        </tr>
        <tr>
        <td>智慧：</td>
        <td>$intellect</td>
        </tr>
        <tr>
        <td>力量：</td>
        <td>$strength</td>
        </tr>
        </table>";
        echo $table;
        
        $url = "YOUR WEB/db/getName.php";
        $param = array(
            'mno' => $mno,
            'cno' => $cno,
        );
        curl_get_http0($url, $param);
        
        echo "<br/>";
    }
    
    // 公会信息
    function clan_detail($clan)
    {
        echo "<b>公会名称：</b>".$clan['Response']['results'][0]['group']['name']." <b>[</b>".$clan['Response']['results'][0]['group']['clanInfo']['clanCallsign']."<b>]</b>"."<br/>";
        echo $clan['Response']['results'][0]['group']['memberCount']."名成员"."<br/>";
        echo "<b>ABOUT US：</b>"."<br/>";
        echo $clan['Response']['results'][0]['group']['motto']."<br/>";
        
        $str = $clan['Response']['results'][0]['group']['about'];
        while(strpos($str, "\n") !== false)
        {
            $i1 = strpos($str, "\n");
            $str = substr($str, 0, $i1)."<br/>".substr($str, ($i1+2), strlen($str));
        }
        
        echo $str."<br/>";
    }
    
    //get the q parameter from URL
    $q=$_GET["q"];
    
    //lookup all hints from array if length of q>0
    if (strlen($q) > 0)
    {
        $hint=$q;
    }
    
    // Set output to "no suggestion" if no hint were found
    // or to the correct values
    if ($hint == "")
    {
        $response="no suggestion";
    }
    else
    {
        while(strpos($hint, "#") !== false)
        {
            $i1 = strpos($hint, "#");
            $hint = substr($hint, 0, $i1)."%23".substr($hint, ($i1+1), strlen($hint));
        }
        
        $myapi = array(
            'X-API-Key:'.'YOUR BUNGIE API',
        );
        $purl = "https://www.bungie.net/Platform/Destiny2/SearchDestinyPlayer/-1/".$hint."/";
        
        $soutput = curl_get_http($purl, $myapi);
        
        $info = json_decode($soutput, true);
        $infocheck = $info['Response'];
        
        if(empty($infocheck))
        {
            echo "请输入正确的Bungie昵称！<br/>";
        }
        else
        {
            echo "数据信息：<br/>";
            
            // 查找membershipId
            $infonum = $info['Response'][0]['membershipId'];
            
            $curl = "https://www.bungie.net/Platform/Destiny2/3/Profile/".$infonum."/";
            $cparam = array(
                'components' => '100',
            );
            $coutput = curl_get_http_p($curl, $myapi, $cparam);
            //echo $coutput;
            
            // 查找各职业characterIds
            $character = json_decode($coutput, true);
            
            $cnum[1] = $character['Response']['profile']['data']['characterIds'][0];
            $cnum[2] = $character['Response']['profile']['data']['characterIds'][1];
            $cnum[3] = $character['Response']['profile']['data']['characterIds'][2];
            
            //统计创建的职业个数
            if(empty($cnum[1]))
            {
                $cnumcheck = 0;
            }
            else if(empty($cnum[2]))
            {
                $cnumcheck = 1;
            }
            else if(empty($cnum[3]))
            {
                $cnumcheck = 2;
            }
            else
            {
                $cnumcheck = 3;
            }
            
            $idparam = array(
                'components' => '200',
            );
            
            $coutput1 = curl_get_http_p(("https://www.bungie.net/Platform/Destiny2/3/Profile/".$infonum."/Character/".$cnum[1]."/"), $myapi, $idparam);
            $coutput2 = curl_get_http_p(("https://www.bungie.net/Platform/Destiny2/3/Profile/".$infonum."/Character/".$cnum[2]."/"), $myapi, $idparam);
            $coutput3 = curl_get_http_p(("https://www.bungie.net/Platform/Destiny2/3/Profile/".$infonum."/Character/".$cnum[3]."/"), $myapi, $idparam);
            
            $pro[1] = json_decode($coutput1, true);
            $pro[2] = json_decode($coutput2, true);
            $pro[3] = json_decode($coutput3, true);
            
            $picurl[1] = "https://www.bungie.net".$pro[1]['Response']['character']['data']['emblemBackgroundPath'];
            $picurl[2] = "https://www.bungie.net".$pro[2]['Response']['character']['data']['emblemBackgroundPath'];
            $picurl[3] = "https://www.bungie.net".$pro[3]['Response']['character']['data']['emblemBackgroundPath'];
            
            // 输出各职业信息
            $ccount = 1;
            while ($ccount <= $cnumcheck)
            {
                $pic[$ccount] = "<img src=\"".$picurl[$ccount]."\" />";
                //echo htmlentities($pic[$ccount],ENT_QUOTES,"UTF-8");
                echo $pic[$ccount];
                echo "<br/>";
                detail_output($pro[$ccount], $infonum, $cnum[$ccount]);
                $ccount = $ccount + 1;
            }
            
            // 公会信息输出
            $clanurl = "https://www.bungie.net/Platform/GroupV2/User/3/".$infonum."/0/1/";
            
            $clanoutput = curl_get_http($clanurl, $myapi);
            
            $claninfo = json_decode($clanoutput, true);
            
            if($claninfo['Response']['totalResults'] > 0)
            {
                $piccurl1 = "https://www.bungie.net".$claninfo['Response']['results'][0]['group']['bannerPath'];
            
                echo "公会信息：<br/>";
                $cpic1 = "<img src=\"".$piccurl1."\" width=\"50%\" height=\"50%\" />";
                //echo htmlentities($cpic1,ENT_QUOTES,"UTF-8");
                echo $cpic1;
                echo "<br/>";
                clan_detail($claninfo);
            }
        }
    }

?>
