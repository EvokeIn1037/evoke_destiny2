<?php
    header("Content-Type: text/html; charset=utf-8");
    
    function sql_data($id)
    {
        // 设置json格式
        header('Content-Type: application/json; charset=utf-8');
        
        // 定义PDO
        $pdo = new PDO('sqlite:world_sql_content.sqlite');
        
        // 定义sql查询语句
        $sql = "SELECT json FROM DestinyActivityDefinition WHERE id = ".$id.";";
        $statement = $pdo->query($sql);
        
        // 执行sql
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        $result = json_encode($row[0]['json']);
        $result = json_decode($result, true);
        $result = json_decode($result, true);
        
        // 输出
        // echo "<pre>";
        return $result['displayProperties']['name'];
        // echo "</pre>";
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
    
    function getid($hash)
    {
        $id = (int)$hash;
        if (($id & (1 << (32 - 1))) != 0)
        {
            $id = $id - (1 << 32);
        }
        return $id;
    }
    
    //get the q parameter from URL
    $fin = $_GET["fin"];
    $cin = $_GET["cin"];
    $mode = $_GET["mode"];
    $flag = 0;
    
    //lookup all hints from array if length of q>0
    if (strlen($fin) > 0)
    {
        $infonum = $fin;
    }
    if (strlen($cin) > 0)
    {
        $cnum = $cin;
    }
    if (strlen($mode) > 0)
    {
        $modenum = $mode;
    }
    if ($modenum == "84")
    {
        $flag = 1;
    }
    else
    {
        $flag = 0;
    }
    
    $myapi = array(
        'X-API-Key:'.'eb63c115d7a3496c9a603e166cb641da',
    );
    $purl = "https://www.bungie.net/Platform/Destiny2/3/Account/".$infonum."/Character/".$cnum."/Stats/Activities/";
    $cparam = array(
        'mode' => $modenum,
    );
    
    $soutput = curl_get_http_p($purl, $myapi, $cparam);
    $act = json_decode($soutput, true);
    
    $arrayHash[0] = 0;
    $arrayMap[0] = "";
    $dataArr = array();
    
    if ($act['Response'] == NULL)
    {
        $dataArr['res'] = "<br/><br/>";
        $jsonobj = json_encode($dataArr);
        echo $jsonobj;
    }
    else
    {
        $table = "<table>";
        
        $index = 0;
        $dp =1;
        $listlong = count($act['Response']['activities']);
        
        if ($flag == 0)
        {
            while ($index < $listlong)
            {
                $hash = $act['Response']['activities'][$index]['activityDetails']['referenceId'];
                $indexHash = $arrayHash[$hash];
                if ($indexHash > 0)
                {
                    $map = $arrayMap[$indexHash];
                }
                else
                {
                    $arrayHash[$hash] = $dp;
                    $id = getid($hash);
                    $arrayMap[$dp] = sql_data($id);
                    $map = $arrayMap[$dp];
                    $dp = $dp + 1;
                }
                
                $table = $table."<tr><td>地图：".$map."</td><td>击杀：".$act['Response']['activities'][$index]['values']['kills']['basic']['displayValue']."</td><td>死亡：".$act['Response']['activities'][$index]['values']['deaths']['basic']['displayValue']."</td><td>助攻：".$act['Response']['activities'][$index]['values']['assists']['basic']['displayValue']."</td><td>KD：".$act['Response']['activities'][$index]['values']['killsDeathsRatio']['basic']['displayValue']."</td><td>KDA：".$act['Response']['activities'][$index]['values']['killsDeathsAssists']['basic']['displayValue']."</td><td>效率：".$act['Response']['activities'][$index]['values']['efficiency']['basic']['displayValue']."</td></tr>";
                
                $index = $index + 1;
            }
        }
        else
        {
            while ($index < $listlong)
            {
                $hash = $act['Response']['activities'][$index]['activityDetails']['referenceId'];
                $indexHash = $arrayHash[$hash];
                if ($indexHash > 0)
                {
                    $map = $arrayMap[$indexHash];
                }
                else
                {
                    $arrayHash[$hash] = $dp;
                    $id = getid($hash);
                    $arrayMap[$dp] = sql_data($id);
                    $map = $arrayMap[$dp];
                    $dp = $dp + 1;
                }
                if ($act['Response']['activities'][$index]['activityDetails']['directorActivityHash'] == 1728343233)
                {
                    $map = $map."（试炼实验室）";
                }
                
                $table = $table."<tr><td>地图：".$map."</td><td>击杀：".$act['Response']['activities'][$index]['values']['kills']['basic']['displayValue']."</td><td>死亡：".$act['Response']['activities'][$index]['values']['deaths']['basic']['displayValue']."</td><td>助攻：".$act['Response']['activities'][$index]['values']['assists']['basic']['displayValue']."</td><td>KD：".$act['Response']['activities'][$index]['values']['killsDeathsRatio']['basic']['displayValue']."</td><td>KDA：".$act['Response']['activities'][$index]['values']['killsDeathsAssists']['basic']['displayValue']."</td><td>效率：".$act['Response']['activities'][$index]['values']['efficiency']['basic']['displayValue']."</td></tr>";
                
                $index = $index + 1;
            }
        }
        
        $table = $table."</table><br/><br/>";
        $dataArr['res'] = $table;
        $jsonobj = json_encode($dataArr);
        echo $jsonobj;
    }
    
?>