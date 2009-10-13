<?php
$host="www.unikassa.ru";
  $fp = fsockopen($host, 80, $errno, $errstr, 30);
 if (!$fp) {
  echo "$errstr ($errno)<br />\n"; 
 } else {
    $out = "GET /image.php?id_img=".intval($_REQUEST['id_img'])." HTTP/1.0\r\n";
    $out .= "Host: ".$host."\r\n";
    $out .= "Connection: Close\r\n\r\n";

    fwrite($fp, $out);
$i=0;
    while (!feof($fp)) {
$i++;
     $s=fgets($fp);
if ($i>7) {echo $s;} else {header($s);};

  };

    fclose($fp);
}
?>