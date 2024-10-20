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
            'X-API-Key:'.'eb63c115d7a3496c9a603e166cb641da',
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
            
            $curl = "https://www.bungie.net/Platform/Destiny2/3/Profile/".$infonum."/";
            $cparam = array(
                'components' => '100',
            );
            $coutput = curl_get_http_p($curl, $myapi, $cparam);
            
            // 查找各职业characterIds
            $character = json_decode($coutput, true);
            $charaNum = count($character['Response']['profile']['data']['characterIds']);
            
            $index = 0;
            $ac0 = 0;
            $ac1 = 0;
            $ac2 = 0;
            $t = 0;
            $t0 = 0;
            $t1 = 0;
            $t2 = 0;
            while ($index < $charaNum)
            {
                $cnum = $character['Response']['profile']['data']['characterIds'][$index];
                $aurl = "https://www.bungie.net/Platform/Destiny2/3/Account/".$infonum."/Character/".$cnum."/Stats/AggregateActivityStats/";
                $couttemp = curl_get_http($aurl, $myapi);
                $pro = json_decode($couttemp, true);
                $pnum = count($pro['Response']['activities']);
                $aindex = $pnum - 1;
                $aflag = 0;
                while (($aflag != 3) && ($aindex >= 0))
                {
                    if($pro['Response']['activities'][$aindex]['activityHash'] == 1374392663)
                    {
                        $dataArr['exist'][0] = 1;
                        $dataArr['name'][0] = "国王的陨落";
                        $dataArr['clear'][0] = $pro['Response']['activities'][$aindex]['values']['activityWins']['basic']['value'] + $dataArr['clear'][0];
                        $dataArr['compl'][0] = $pro['Response']['activities'][$aindex]['values']['activityCompletions']['basic']['value'] + $dataArr['compl'][0];
                        
                        if ($ac0 == 0)
                        {
                            $dataArr['time'][0] = $pro['Response']['activities'][$aindex]['values']['fastestCompletionMsForActivity']['basic']['displayValue'];
                            $t0 = $pro['Response']['activities'][$aindex]['values']['fastestCompletionMsForActivity']['basic']['value'];
                            $dataArr['clear'][0] = $pro['Response']['activities'][$aindex]['values']['activityWins']['basic']['value'];
                            $dataArr['compl'][0] = $pro['Response']['activities'][$aindex]['values']['activityCompletions']['basic']['value'];
                            $ac0 = 1;
                        }
                        else
                        {
                            $t = $pro['Response']['activities'][$aindex]['values']['fastestCompletionMsForActivity']['basic']['value'];
                            if ($t < $t0)
                            {
                                $dataArr['time'][0] = $pro['Response']['activities'][$aindex]['values']['fastestCompletionMsForActivity']['basic']['displayValue'];
                                $t0 = $t;
                            }
                            $dataArr['clear'][0] = $pro['Response']['activities'][$aindex]['values']['activityWins']['basic']['value'] + $dataArr['clear'][0];
                            $dataArr['compl'][0] = $pro['Response']['activities'][$aindex]['values']['activityCompletions']['basic']['value'] + $dataArr['compl'][0];
                        }
                        
                        $aflag = $aflag + 1;
                    }
                    elseif ($pro['Response']['activities'][$aindex]['activityHash'] == 1063970578)
                    {
                        $dataArr['exist'][1] = 1;
                        $dataArr['name'][1] = "国王的陨落：DAYONE挑战";
                        
                        if ($ac1 == 0)
                        {
                            $dataArr['time'][1] = $pro['Response']['activities'][$aindex]['values']['fastestCompletionMsForActivity']['basic']['displayValue'];
                            $t1 = $pro['Response']['activities'][$aindex]['values']['fastestCompletionMsForActivity']['basic']['value'];
                            $dataArr['clear'][1] = $pro['Response']['activities'][$aindex]['values']['activityWins']['basic']['value'];
                            $dataArr['compl'][1] = $pro['Response']['activities'][$aindex]['values']['activityCompletions']['basic']['value'];
                            $ac1 = 1;
                        }
                        else
                        {
                            $t = $pro['Response']['activities'][$aindex]['values']['fastestCompletionMsForActivity']['basic']['value'];
                            if ($t < $t1)
                            {
                                $dataArr['time'][1] = $pro['Response']['activities'][$aindex]['values']['fastestCompletionMsForActivity']['basic']['displayValue'];
                                $t1 = $t;
                            }
                            $dataArr['clear'][1] = $pro['Response']['activities'][$aindex]['values']['activityWins']['basic']['value'] + $dataArr['clear'][1];
                            $dataArr['compl'][1] = $pro['Response']['activities'][$aindex]['values']['activityCompletions']['basic']['value'] + $dataArr['compl'][1];
                        }
                        
                        $aflag = $aflag + 1;
                    }
                    elseif ($pro['Response']['activities'][$aindex]['activityHash'] == 2964135793)
                    {
                        $dataArr['exist'][2] = 1;
                        $dataArr['name'][2] = "国王的陨落：大师";
                        
                        if ($ac2 == 0)
                        {
                            $dataArr['time'][2] = $pro['Response']['activities'][$aindex]['values']['fastestCompletionMsForActivity']['basic']['displayValue'];
                            $t2 = $pro['Response']['activities'][$aindex]['values']['fastestCompletionMsForActivity']['basic']['value'];
                            $dataArr['clear'][2] = $pro['Response']['activities'][$aindex]['values']['activityWins']['basic']['value'];
                            $dataArr['compl'][2] = $pro['Response']['activities'][$aindex]['values']['activityCompletions']['basic']['value'];
                            $ac2 = 1;
                        }
                        else
                        {
                            $t = $pro['Response']['activities'][$aindex]['values']['fastestCompletionMsForActivity']['basic']['value'];
                            if ($t < $t2)
                            {
                                $dataArr['time'][2] = $pro['Response']['activities'][$aindex]['values']['fastestCompletionMsForActivity']['basic']['displayValue'];
                                $t2 = $t;
                            }
                            $dataArr['clear'][2] = $pro['Response']['activities'][$aindex]['values']['activityWins']['basic']['value'] + $dataArr['clear'][2];
                            $dataArr['compl'][2] = $pro['Response']['activities'][$aindex]['values']['activityCompletions']['basic']['value'] + $dataArr['compl'][2];
                        }
                        
                        $aflag = $aflag + 1;
                    }
                    
                    $aindex = $aindex - 1;
                }
                
                $index = $index + 1;
            }
            $ac = $ac0 + $ac1 + $ac2;
            if ($ac > 0)
            {
                $dataArr['row1'][0] = "名称";
                $dataArr['row1'][1] = "通关次数";
                $dataArr['row1'][2] = "全程次数";
                $dataArr['row1'][3] = "最短时长";
                $dataArr['rnum'] = $ac;
            }
            
            $jsonobj = json_encode($dataArr);
            echo $jsonobj;
            // echo "<script>console.log(".$jsonobj.")</script>";
        }
    }
?>