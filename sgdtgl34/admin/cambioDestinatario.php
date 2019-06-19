<?php
print("<br>\n<center><font class='bigsubtitle'>$variable $lang_siglas</font></center>\n<br>\n");
$id=str_replace("~"," ",$id);
if ($accion!="insert") {
	$sql = new scg_DB;
	$sql->query("SELECT clave,nombre,cargo from dirigido where clave='$id'");
	$num = $sql->num_rows($sql);
	if ($num == 1) {
		while($sql->next_record()) {
			$clave 	= $sql->f("clave");
			$nombre = $sql->f("nombre");
			$cargo	= $sql->f("cargo");
		}
	} else {
		if ($num > 1) {
			print("Error\n");
			exit;
		} else {
			$clave 	= "";
			$nombre = "";
			$cargo	= "";
		}
	}
}
print("<form name='captura_turnador' action='$accion"."Destinatario.php?sess=$sess&origen=$origen' method='post' target='_self' onsubmit='return regform_Validator(this)'>\n");
print("<center>\n");
if ($accion=="delete") print("<font class='alerta'>$lang_catdelete_warn</font>\n");
?>
<table border=0 >
	<tr>
		<td align="right" width="25%">
			Nombre
		</td>
		<td>
			<input type="text" name="nombre" value="<? echo $nombre ?>" size=50 maxlength=50 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
	<tr>
		<td align="right" width="25%">
			Cargo
		</td>
		<td>
			<input type="text" name="cargo" value="<? echo $cargo ?>" size=50 maxlength=50 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
</table>
<?
print("<input type='button' value='$lang_basicbutton_x' onClick='location=\"admonCatalogo.php?sess=$sess&control_catalogos=$control_catalogos&origen=$origen\"'>");
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
print("<input type='hidden' name='origen' value='$origen'>\n");
print("</form>\n");
?>
<script language='JavaScript'>
function regform_Validator(f) {
	if (f.nombre.value.length < 1) {
		  alert("Por favor introduzca o verifique el nombre del destinatario.");
		  f.nombre.focus();
		  return(false);
	}
	if (f.cargo.value.length < 1) {
		  alert("Por favor introduzca el cargo del destinatario.");
		  f.cargo.focus();
		  return(false);
	}
}
</script>
