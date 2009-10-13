<?php
class Unikassa {
 function postvars($postarray) {
  $result="";
  foreach ($postarray as $name => $postvar)
  {
  $result .= ($result!="" ? "&" : ""). urlencode($name)."=".urlencode($postvar);

 };
  return $result;
 }
 function getimage() {
  $fp = fsockopen("ssl://server.unikassa.ru", 443, $errno, $errstr, 30);
 if (!$fp) {
  echo "$errstr ($errno)<br />\n"; return false;
 } else {
    $out = "GET https://server.unikassa.ru/site_78_2/main.php?id_service=1000 HTTP/1.1\r\n";
    $out .= "Host: server.unikassa.ru\r\n";
    $out .= "Connection: Close\r\n\r\n";

    fwrite($fp, $out);
    $mathc=50;
    while (!feof($fp)) {
     $s=fgets($fp);
     $sout=trim($s);
  if ( substr($sout ,0, $mathc) == substr("<img src=\"http://www.unikassa.ru/image.php?id_img=", 0, $mathc) ) {
//	var_dump($sout);
   $sout = substr($sout,$mathc);
   $sout = substr($sout, 0, 6);
   //	var_dump($sout);
   fclose($fp);
   return $sout;
  };

    }
    fclose($fp);
  return false;
}
}
 function getbalance($pin, $ccode, $id_img) {
  $pin=ereg_replace("[^0-9]", "", $pin);
  $ccode=intval(ereg_replace("[^0-9]", "", $ccode));
  $id_img=intval(ereg_replace("[^0-9]", "", $id_img));

 $fp = fsockopen("ssl://server.unikassa.ru", 443, $errno, $errstr, 30);
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
    return false;
} else {
$vars=$this->postvars(Array('n_act'=>"1" ,'pin'=>$pin ,'ccode'=>$ccode ,'id_img'=>$id_img));
    $out = "POST https://server.unikassa.ru/site_78_2/main.php?id_service=1000 HTTP/1.1\r\n";
    $out .= "Host: server.unikassa.ru\r\n";
    $out .= "Content-type: application/x-www-form-urlencoded\r\n";
    $out .= "Content-length: ".strlen($vars)."\r\n";
    $out .= "Connection: Close\r\n\r\n";

    fwrite($fp, $out.$vars);
    while (!feof($fp)) {
$s=fgets($fp);
$s=iconv("cp1251", "utf8", $s);
$sout=trim($s);
$mathc=65;
if ( substr($sout ,0, $mathc) == substr("Баланс вашей уникарты составляет <b>", 0, $mathc) ) {
   $sout = substr($sout,$mathc,-12);
    fclose($fp);
    return $sout;
  };
$msg="Запрос не выполнен. Возможные проблемы:<br>";
if ( substr($sout ,0, strlen($msg)) == substr($msg, 0, strlen($msg)) ) {
    fclose($fp);
    return "Вы ввели неправильный пин или пин уже погашенной карты. Так же проверьте правильность ввода контрольного числа";
  };
};
    fclose($fp);
    return false;
}

}

 function payptc($pin, $ccode, $id_img, $num, $sum, $email) {
  $pin=ereg_replace("[^0-9]", "", $pin);
  $ccode=intval(ereg_replace("[^0-9]", "", $ccode));
  $id_img=intval(ereg_replace("[^0-9]", "", $id_img));
  $num=intval($num);$sum=intval($sum);
 $fp = fsockopen("ssl://server.unikassa.ru", 443, $errno, $errstr, 30);
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
    return false;
} else {
$vars=$this->postvars(Array('n_act'=>"2" ,'pin'=>$pin ,'ccode'=>$ccode ,'id_img'=>$id_img,
'num'=>$num,  'sum'=> $sum, 'email'=>$email));
    $out = "POST https://server.unikassa.ru/site_78_2/main.php?id_service=205 HTTP/1.1\r\n";
    $out .= "Host: server.unikassa.ru\r\n";
    $out .= "Content-type: application/x-www-form-urlencoded\r\n";
    $out .= "Content-length: ".strlen($vars)."\r\n";
    $out .= "Connection: Close\r\n\r\n";

    fwrite($fp, $out.$vars);
$i=0;
    while (!feof($fp)) {
$s=fgets($fp);
$s=iconv("cp1251", "utf8", $s);
$sout=trim($s);
// $mathc=65;
// if ( substr($sout ,0, $mathc) == substr("Баланс вашей уникарты составляет <b>", 0, $mathc) ) {
//    $sout = substr($sout,$mathc,-12);
//     fclose($fp);
//     return $sout;
//   };
// $msg="Запрос не выполнен. Возможные проблемы:<br>";
/*if ( substr($sout ,0, strlen($msg)) == substr($msg, 0, strlen($msg)) ) {
    fclose($fp);
    return "Вы ввели неправильный пин или пин уже погашенной карты. Так же проверьте правильность ввода контрольного числа";
  };*/
$i++;
if ($i>15) {echo $s;};
};
    fclose($fp);
    return false;
}

}

};
if (!$UNISTART) {echo "Домик уже зелёный";};
?>
