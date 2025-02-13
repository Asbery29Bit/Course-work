<?php
$fp = fsockopen("tcp://93.94.180.183", 2223, $errno, $errstr,100);

if (!$fp) {
    echo "ERROR: $errno - $errstr<br />\n";
} else {
	$i = 0;
	$txt = '';
        while (!feof($fp)){
        	$txt .= fread($fp,128);
        }    
    fclose($fp);
    var_dump($txt);
}
?>