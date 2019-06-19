<?php
print("<br>\n<center><font class='bigsubtitle'>$variable $lang_siglas</font></center>\n<br>\n");
$id=str_replace("~"," ",$id);
if ($accion!="insert") {
	$sql = new scg_DB;
	$sql->query("SELECT cve_ins,instruccion,tipo from instruccion where cve_ins='$id'");
	$num = $sql->num_rows($sql);
	if ($num == 1) {
		while($sql->next_record()) {
			$cve_ins			= $sql->f("cve_ins");
			$instruccion	= $sql->f("instruccion");
			$tipo 				= $sql->f("tipo");
		}
	} else {
		if ($num > 1) {
			print("Error\n");
			exit;
		} else {
			$cve_ins			= "";
			$instruccion	= "";
			$tipo 				= "";
		}
	}
}
print("<form name='captura_nombre' action='$accion"."Instruccion.php?sess=$sess&origen=$origen' method='post' target='_self' onsubmit='return regform_Validator(this)'>\n");
print("<center>\n");
if ($accion=="delete") print("<font class='alerta'>$lang_catdelete_warn</font>\n");
?>
<table border=0 >
	<tr>
		<td align="right" width="25%">
			<?
			switch ($tipo) {
				case "I":
					print("$lang_cat_7single");
				break;
				case "D":
					print("$lang_cat_8single");
				break;
			}
			?>
		</td>
		<td>
			<input type="text" name="instruccion" value="<? echo $instruccion ?>" size=30 maxlength=30 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
</table>
<input type="hidden" name="tipo" value="<? echo $tipo; ?>">
<input type="hidden" name="origen" value="<? echo $origen; ?>">
<input type="hidden" name="cve_tema" value="<? echo $cve_tema; ?>">
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
print("</form>\n");
?>
<script language="javascript">
<!--
function regform_Validator(f) {
	if (f.instruccion.value.length < 1) {
		  alert("Por favor introduzca o verifique el nombre.");
		  f.instruccion.focus();
		  return(false);
	}
}
//-->
</script>
</center>