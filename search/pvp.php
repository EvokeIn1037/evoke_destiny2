<?php
    header("Content-Type: text/html; charset=utf-8");
    
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
    $fin = $_GET["fin"];
    $cin = $_GET["cin"];
    
    //lookup all hints from array if length of q>0
    if (strlen($fin) > 0)
    {
        $infonum = $fin;
    }
    if (strlen($cin) > 0)
    {
        $cnum = $cin;
    }
    
    $myapi = array(
        'X-API-Key:'.'eb63c115d7a3496c9a603e166cb641da',
    );
    $purl = "https://www.bungie.net/Platform/Destiny2/3/Account/".$infonum."/Character/".$cnum."/Stats/Activities/";
    $cparam = array(
        'mode' => '5',
    );
    
    $soutput = curl_get_http_p($purl, $myapi, $cparam);
    $act = json_decode($soutput, true);
    
    if ($act['Response'] == NULL)
    {
        echo "<br/><br/>";
    }
    else
    {
        $table = "<table>";
        
        $index = 0;
        $listlong = count($act['Response']['activities']);
        while ($index < $listlong)
        {
            $table = $table."<tr>
            <td>时长：".$act['Response']['activities'][$index]['values']['activityDurationSeconds']['basic']['displayValue']."</td>
            <td>击杀：".$act['Response']['activities'][$index]['values']['kills']['basic']['displayValue']."</td>
            <td>死亡：".$act['Response']['activities'][$index]['values']['deaths']['basic']['displayValue']."</td>
            <td>助攻：".$act['Response']['activities'][$index]['values']['assists']['basic']['displayValue']."</td>
            <td>KD：".$act['Response']['activities'][$index]['values']['killsDeathsRatio']['basic']['displayValue']."</td>
            <td>KDA：".$act['Response']['activities'][$index]['values']['killsDeathsAssists']['basic']['displayValue']."</td>
            <td>效率：".$act['Response']['activities'][$index]['values']['efficiency']['basic']['displayValue']."</td>
            </tr>";
            
            $index = $index + 1;
        }
        $table = $table."</table><br/><br/>";
        echo $table;
    }
    
?>