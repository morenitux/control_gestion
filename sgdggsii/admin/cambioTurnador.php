<?php
print("<br>\n<center><font class='bigsubtitle'>$variable $lang_siglas</font></center>\n<br>\n");
$id=str_replace("~"," ",$id);
if ($accion!="insert") {
	$sql = new scg_DB;
	$sql->query("SELECT cve_turn,nom_turn,car_turn,no_oficio from turnador where cve_turn='$id'");
	$num = $sql->num_rows($sql);
	if ($num == 1) {
		while($sql->next_record()) {
			$cve_turn 	= $sql->f("cve_turn");
			$nom_turn 	= $sql->f("nom_turn");
			$car_turn	= $sql->f("car_turn");
			$no_oficio	= $sql->f("no_oficio");
		}
	} else {
		if ($num > 1) {
			print("Error\n");
			exit;
		} else {
			$cve_turn 	= "";
			$nom_turn 	= "";
			$car_turn		= "";
			$no_oficio	= "";
		}
	}
}
print("<form name='captura_turnador' action='$accion"."Turnador.php?sess=$sess&origen=$origen' method='post' target='_self' onsubmit='return regform_Validator(this)'>\n");
print("<center>\n");
if ($accion=="delete") print("<font class='alerta'>$lang_catdelete_warn</font>\n");
?>
<table border=0 width="700" >
	<tr>
		<td align="right" width="25%">
			Nombre del Turnador:
		</td>
		<td>
			<input type="text" name="nom_turn" value="<? echo $nom_turn ?>" size=40 maxlength=40 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
	<tr>
		<td align="right" width="25%">
			Cargo del Turnador:
		</td>
		<td>
			<input type="text" name="car_turn" value="<? echo $car_turn ?>" size=50 maxlength=50 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
	<tr>
		<td align="right" width="25%">
			No_Oficio:
		</td>
		<td>
			<input type="text" name="no_oficio" value="<? echo $no_oficio ?>" size=15 maxlength=15 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
</table>
<?
print("<input type='button' value='$lang_basicbutton_x' onClick='location=\"admonCatalogo.php?sess=$sess&control_catalogos=$control_catalogos\"'>");
switch ($accion) {
 case "insert":
	echo "<input type='submit' value='$lang_basicbutton_a'>";
 break;
 case "update":
	echo "<input type='submit' value='$lang_basicbutton_c'>";
 break;
 case "delete":
	echo "<input type='submit' value='$lang_basicbutton_b'>";
 break;
}
print("</center>\n");
print("<input type='hidden' name='id' value='$id'>\n");
print("</form>\n");
?>
<script language='JavaScript'>
function regform_Validator(f) {
	if (f.nom_turn.value.length < 1) {
		  alert("Por favor introduzca o verifique el nombre del turnador.");
		  f.nom_turn.focus();
		  return(false);
	}
}
</script>