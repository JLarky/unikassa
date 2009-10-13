<?php
$UNISTART=true;
include("unikassa.php");

$uni = new Unikassa();
$imageid=$uni->getimage();
if($imageid) {
echo "<a href=\"index.php\">В начало</a>";
} else {
echo "Произошла ошибка. Если вы видите это сообщение с 2 до 4 ночи, то это нормально, потому что у них в это время профилактика";
exit;
};

echo '<form method="post" action="">'."\n";
echo "<table>\n<tr>\n<td>\n";
echo '<input type="hidden" name="n_act" value="1">'."\n";
echo 'pin-code(пароль): <input type="password" name="pin" size=20 value="">'."\n";
echo "</td>\n</tr>\n<tr>\n<td>\n";
echo 'UID <input type="text" size=25 name="num">';
echo "</td>\n</tr>\n<tr>\n<td>\n";
echo 'sum <input name="sum" size="25" class="payform" type="text">';
echo "</td>\n</tr>\n<tr>\n<td>\n";
echo 'email <input name="email" size="25" value="" class="payform" type="text">';
echo "</td>\n</tr>\n<tr>\n<td>\n";
echo "<img src=\"image.php?id_img=".$imageid."\">"."\n";
echo "</td>\n</tr>\n<tr valign=center>\n<td>\n";
echo "введите код на картинке";
echo "</td>\n</tr>\n<tr valign=center>\n<td>\n";
echo '<input type="text" name="ccode" maxlength=8 size=11>'."\n";
echo '<input type="hidden" name="id_img" value="'.$imageid.'">';
echo '<input type="submit" value="проверить">'."\n";
echo "</td>\n</tr>\n</table>\n";
echo '</form>'."\n";

if (isset($_REQUEST['pin'])) {
$tmp=$uni->payptc($_REQUEST['pin'], $_REQUEST['ccode'], $_REQUEST['id_img'], $_REQUEST['num'], $_REQUEST['sum'], $_REQUEST['email'] );

// if (!$tmp) {echo "Чё-то не сложилось"; exit;};
// echo "На данной карте находится ".$tmp." рублей";
};

echo "<p>Данная фигня позволяет оплатить услуги ВТЦ через уникарту без инета. По всем вопросам обращайтесь jlarky@gmail.com и jlarky@jabber.spbu.ru</p>";
?>