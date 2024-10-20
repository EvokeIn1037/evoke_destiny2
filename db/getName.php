<?php

    function sql_data($id)
    {
        // 设置json格式
        header('Content-Type: application/json; charset=utf-8');
        
        // 定义PDO
        $pdo = new PDO('sqlite:world_sql_content.sqlite');
        
        // 定义sql查询语句
        $sql = "SELECT json FROM DestinyInventoryItemDefinition WHERE id = ".$id.";";
        $statement = $pdo->query($sql);
        
        // 执行sql
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        $result = json_encode($row[0]['json']);
        $result = json_decode($result, true);
        $result = json_decode($result, true);
        
        // 输出
        // echo "<pre>";
        return $result['displayProperties'];
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
    $m = $_GET["mno"];
    $c = $_GET["cno"];
    
    //lookup all hints from array if length of q>0
    if (strlen($m) > 0)
    {
      $mno = $m;
    }
    if (strlen($c) > 0)
    {
      $cno = $c;
    }
    
    $myapi = array(
            'X-API-Key:'.'eb63c115d7a3496c9a603e166cb641da',
        );
    $curl = "https://www.bungie.net/Platform/Destiny2/3/Profile/".$mno."/Character/".$cno."/";
    $cparam = array(
        'components' => '205',
    );
    $coutput = curl_get_http_p($curl, $myapi, $cparam);
    $armour = json_decode($coutput, true);
    
    $epoch = 0;
    while ($epoch < 8)
    {
        $flag = 0;
        $item = $armour['Response']['equipment']['data']['items'][$epoch];
        if ($item['overrideStyleItemHash'] > 0)
        {
            $hash1 = $item['overrideStyleItemHash'];
            $flag = 1;
        }
        $hash = $item['itemHash'];
        $id = getid($hash);
        $con = sql_data($id);
        $name[$epoch] = " ".$con['name']." ";
        if ($flag > 0)
        {
            $id = getid($hash1);
            $con = sql_data($id);
        }
        $arm[$epoch] = "https://www.bungie.net/".$con['icon'];
        $img[$epoch] = "<img src=\"".$arm[$epoch]."\" width=\"50%\" height=\"50%\" />";
        
        $itemid = $armour['Response']['equipment']['data']['items'][$epoch]['itemInstanceId'];
        $iurl = "https://www.bungie.net/Platform/Destiny2/3/Profile/".$mno."/Item/".$itemid."/";
        $iparam = array(
            'components' => '300,302,304,305,310',
        );
        $ioutput = curl_get_http_p($iurl, $myapi, $iparam);
        $weapon = json_decode($ioutput, true);
        $light[$epoch] = $weapon['Response']['instance']['data']['primaryStat']['value'];
        
        $epoch = $epoch + 1;
    }
    
    $table1 = "<table frame=\"void\">
        <tr>
        <td align=\"center\">$name[0]</td>
        <td align=\"center\">$name[1]</td>
        <td align=\"center\">$name[2]</td>
        </tr>
        <tr>
        <td align=\"center\">$img[0]</td>
        <td align=\"center\">$img[1]</td>
        <td align=\"center\">$img[2]</td>
        </tr>
        <tr>
        <td align=\"center\">$light[0]</td>
        <td align=\"center\">$light[1]</td>
        <td align=\"center\">$light[2]</td>
        </tr>
        </table>";
    $table2 = "<table frame=\"void\">
        <tr>
        <td align=\"center\">$name[3]</td>
        <td align=\"center\">$name[4]</td>
        <td align=\"center\">$name[5]</td>
        <td align=\"center\">$name[6]</td>
        <td align=\"center\">$name[7]</td>
        </tr>
        <tr>
        <td align=\"center\">$img[3]</td>
        <td align=\"center\">$img[4]</td>
        <td align=\"center\">$img[5]</td>
        <td align=\"center\">$img[6]</td>
        <td align=\"center\">$img[7]</td>
        </tr>
        <tr>
        <td align=\"center\">$light[3]</td>
        <td align=\"center\">$light[4]</td>
        <td align=\"center\">$light[5]</td>
        <td align=\"center\">$light[6]</td>
        <td align=\"center\">$light[7]</td>
        </tr>
        </table>";
        
    echo "<pre>";
    echo $table1;
    echo "</pre>";
    echo "<pre>";
    echo $table2;
    echo "</pre>";

?>