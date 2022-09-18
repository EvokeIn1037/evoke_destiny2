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
        
        $dataArr = array();
        
        if(empty($infocheck))
        {
            $dataArr['result'] = 0;
            $dataArr['str'] = "请输入正确的Bungie昵称！<br/>";
            $jsonobj = json_encode($dataArr);
            echo $jsonobj;
        }
        else
        {
            $dataArr['result'] = 1;
            
            // 查找membershipId
            $infonum = $info['Response'][0]['membershipId'];
            $dataArr['info'] = $infonum;
            
            $curl = "https://www.bungie.net/Platform/Destiny2/3/Profile/".$infonum."/";
            $cparam = array(
                'components' => '100',
            );
            $coutput = curl_get_http_p($curl, $myapi, $cparam);
            
            // 查找各职业characterIds
            $character = json_decode($coutput, true);
            
            $charaNum = count($character['Response']['profile']['data']['characterIds']);
            $dataArr['num'] = $charaNum;
            
            $index = 0;
            while ($index < $charaNum)
            {
                $cnum[$index] = $character['Response']['profile']['data']['characterIds'][$index];
                $dataArr['chara'][$index] = $cnum[$index];
                $index = $index + 1;
            }
            
            $idparam = array(
                'components' => '200',
            );
            
            $index = 0;
            while ($index < $charaNum)
            {
                $couttemp[$index] = curl_get_http_p(("https://www.bungie.net/Platform/Destiny2/3/Profile/".$infonum."/Character/".$cnum[$index]."/"), $myapi, $idparam);
                $pro[$index] = json_decode($couttemp[$index], true);
                $dataArr['pic'][$index] = "https://www.bungie.net".$pro[$index]['Response']['character']['data']['emblemBackgroundPath'];
                $streamNum = $pro[$index]['Response']['character']['data']['classType'];
                switch ($streamNum)
                {
                    case 0:
                    {
                        $dataArr['stream'][$index] = '泰坦';
                        break;
                    }
                    case 1:
                    {
                        $dataArr['stream'][$index] = '猎人';
                        break;
                    }
                    case 2:
                    {
                        $dataArr['stream'][$index] = '术士';
                        break;
                    }
                }
                $index = $index + 1;
            }
            
            $jsonobj = json_encode($dataArr);
            echo $jsonobj;
        }
    }
?>
