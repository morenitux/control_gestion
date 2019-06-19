<?php
$control_menu_catalogos=$ok["ctrl_menu_cat"];
if ($control_catalogos=="") $control_catalogos="0";
echo "<form name='plantilla_documento'>";
echo "<table border=1 width=200>";
if (substr($control_menu_catalogos,0,1)=="1") {
 		echo "<tr>\n";
 		echo " <td>\n";
		if ($control_catalogos=="1") {
			echo "<font class=bigsubtitle>$lang_cat_1</font>";
		} else {
			echo "<a href='principal.php?sess=$sess&control_botones_superior=999&control_catalogos=1'>$lang_cat_1</a>";
		}
 		echo " </td>\n";
 		echo "</tr>\n";
}
if (substr($control_menu_catalogos,1,1)=="1") {
		echo "<tr>\n";
 		echo " <td>\n";
		if ($control_catalogos=="2") {
			echo "<font class=bigsubtitle>$lang_cat_2</font>";
		} else {
			echo "<a href='principal.php?sess=$sess&control_botones_superior=999&control_catalogos=2'>$lang_cat_2</a>";
		}
 		echo " </td>\n";
 		echo "</tr>\n";
}
if (substr($control_menu_catalogos,2,1)=="1") {
		echo "<tr>\n";
 		echo " <td>\n";
 		if ($control_catalogos=="3") {
			echo "<font class=bigsubtitle>$lang_cat_3</font>";
		} else {
			echo "<a href='principal.php?sess=$sess&control_botones_superior=999&control_catalogos=3'>$lang_cat_3</a>";
		}
 		echo " </td>\n";
 		echo "</tr>\n";
}
if (substr($control_menu_catalogos,3,1)=="1") {
 		echo "<tr>\n";
 		echo " <td>\n";
		if ($control_catalogos=="4") {
			echo "<font class=bigsubtitle>$lang_cat_4</font>";
		} else {
			echo "<a href='principal.php?sess=$sess&control_botones_superior=999&control_catalogos=4'>$lang_cat_4</a>";
		}
 		echo " </td>\n";
 		echo "</tr>\n";
}
if (substr($control_menu_catalogos,4,1)=="1") {
		echo "<tr>\n";
 		echo " <td>\n";
 		if ($control_catalogos=="5") {
			echo "<font class=bigsubtitle>$lang_cat_5</font>";
		} else {
			echo "<a href='principal.php?sess=$sess&control_botones_superior=999&control_catalogos=5'>$lang_cat_5</a>";
		}
    echo " </td>\n";
 		echo "</tr>\n";
}
if (substr($control_menu_catalogos,5,1)=="1") {
 		echo "<tr>\n";
 		echo " <td>\n";
 		if ($control_catalogos=="6") {
			echo "<font class=bigsubtitle>$lang_cat_6</font>";
		} else {
			echo "<a href='principal.php?sess=$sess&control_botones_superior=999&control_catalogos=6'>$lang_cat_6</a>";
		}
 		echo " </td>\n";
 		echo "</tr>\n";
}
if (substr($control_menu_catalogos,6,1)=="1") {
		echo "<tr>\n";
 		echo " <td>\n";
		if ($control_catalogos=="7") {
			echo "<font class=bigsubtitle>$lang_cat_7</font>";
		} else {
			echo "<a href='principal.php?sess=$sess&control_botones_superior=999&control_catalogos=7'>$lang_cat_7</a>";
		}
 		echo " </td>\n";
 		echo "</tr>\n";
}
if (substr($control_menu_catalogos,7,1)=="1") {
		echo "<tr>\n";
 		echo " <td>\n";
 		if ($control_catalogos=="8") {
			echo "<font class=bigsubtitle>$lang_cat_8</font>";
		} else {
			echo "<a href='principal.php?sess=$sess&control_botones_superior=999&control_catalogos=8'>$lang_cat_8</a>";
		}
 		echo " </td>\n";
 		echo "</tr>\n";
}
if (substr($control_menu_catalogos,8,1)=="1") {
		echo "<tr>\n";
 		echo " <td>\n";
 		if ($control_catalogos=="9") {
			echo "<font class=bigsubtitle>$lang_cat_9</font>";
		} else {
			echo "<a href='principal.php?sess=$sess&control_botones_superior=999&control_catalogos=9'>$lang_cat_9</a>";
		}
 		echo " </td>\n";
 		echo "</tr>\n";
}
?>
</table>
<input type="hidden" name="ventana_auxiliar" value="cerrada">
</form>