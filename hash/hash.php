<?php

    $q=$_GET["q"];
    
    //lookup all hints from array if length of q>0
    if (strlen($q) > 0)
    {
        $hash=$q;
    }
    
    // Set output to "no suggestion" if no hint were found
    // or to the correct values
    if ($hash == "")
    {
        $response="no suggestion";
    }
    else
    {
        echo $hash."<br/>";
        $id = (int)$hash;
        if (($id & (1 << (32 - 1))) != 0)
        {
            $id = $id - (1 << 32);
        }
        echo $id."<br/>";
    }

?>