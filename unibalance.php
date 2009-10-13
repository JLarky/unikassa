<?php
$UNISTART=true;
include("unikassa.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Проверка баланса уникарты</title>
</head>
<body>
<?
$uni = new Unikassa();
$imageid=$uni->getimage();
if($imageid) {
echo "<a href=\"./\">В начало</a>\n";
} else {
echo "Произошла ошибка. Если вы видите это сообщение с 2 до 4 ночи, то это нормально, потому что у них в это время профилактика";
exit;
};
?>
<script type="text/javascript">
//<!--
function refreshimage()
{
document.getElementById('code').innerHTML = '<img width="78" height="30" alt="код брать отсюда" src="image.php?id_img=<? echo $imageid; ?>&#038;tmp='+Math.random()+'"/> <img src="refresh.png" alt="refresh"/>';
}
//-->
</script>
<?
echo '<form method="post" action="">'."\n";
echo "<table>\n<tr>\n<td>\n";
echo '<input type="hidden" name="n_act" value="1" />'."\n";
echo 'pin-code(пароль): <input type="password" name="pin" size="20" value="" />'."\n";
echo "</td>\n</tr>\n<tr>\n<td>\n";
?>
<span id="code" onclick="refreshimage()">
<img width="78" height="30" alt="код брать отсюда" src="image.php?id_img=<? echo $imageid; ?>"/>
<img src="refresh.png" alt="refresh"/>
</span>
<?
echo "</td>\n</tr>\n<tr valign=\"middle\">\n<td>\n";
echo "введите код на картинке";
echo "</td>\n</tr>\n<tr valign=\"middle\">\n<td>\n";
echo '<input type="text" name="ccode" maxlength="8" size="11" />'."\n";
echo '<input type="hidden" name="id_img" value="'.$imageid.'" />'."\n";
echo '<input type="submit" value="проверить" />'."\n";
echo "</td>\n</tr>\n</table>\n";
echo '</form>'."\n";

if (isset($_REQUEST['pin'])) {
$tmp=$uni->getbalance($_REQUEST['pin'], $_REQUEST['ccode'], $_REQUEST['id_img']);
if (!$tmp) {echo "Чё-то не сложилось"; exit;};
echo "На данной карте находится ".$tmp." рублей"."\n";
};

echo "<p>Данная фигня позволяет проверить баланс уникарты без инета. По всем вопросам обращайтесь в dc или jabber: jlarky@jabber.spbu.ru ещё есть icq 77712521 но я там редко </p>";
?>
  <p>
    <a href="http://validator.w3.org/check?uri=referer"><img
        src="valid-xhtml10.png"
        alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
  </p>
</body>
</html>