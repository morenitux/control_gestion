<?php
print("<br>\n<center><font class='bigsubtitle'>$variable $lang_siglas</font></center>\n<br>\n");
$id=str_replace("~"," ",$id);
if ($accion!="insert") {
	$sql = new scg_DB;
	$sql->query("SELECT cve_expe,nom_expe from expediente where cve_expe='$id'");
	$num = $sql->num_rows($sql);
	if ($num == 1) {
		while($sql->next_record()) {
			$cve_expe 	= $sql->f("cve_expe");
			$nom_expe 	= $sql->f("nom_expe");
		}
	} else {
		if ($num > 1) {
			print("Error\n");
			exit;
		} else {
			$cve_expe 	= "";
			$nom_expe 	= "";
		}
	}
}
print("<form name='captura_expediente' action='$accion"."Expediente.php?sess=$sess&variable=$variable&lang_siglas=$lang_siglas&origen=$origen' method='post' target='_self' onsubmit='return regform_Validator(this)'>\n");
print("<center>\n");
if ($accion=="delete") print("<font class='alerta'>$lang_catdelete_warn</font>\n");

?>
<table border=0 width="700">
	<tr>
		<td align="right" width="25%">
			Clave del expediente:
		</td>
		<td>
			<input type="text" name="cve_expe" value="<? echo $cve_expe ?>" size=50 maxlength=50 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; } else { if ($accion=="update") { echo "onFocus='alert(\"No se puede modificar la clave del expediente\"); this.blur();'"; } }?>>
		</td>
	</tr>
	<tr>
		<td align="right" width="25%">
			Expediente
		</td>
		<td>
			<input type="text" name="nom_expe" value="<? echo $nom_expe ?>" size=50 maxlength=50 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
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
print("</form>\n");
?>
<script language="javascript">
<!--
function regform_Validator(f) {
	<? if ($accion!="delete") { ?>
	if (f.cve_expe.value.length < 1) {
		  alert("Por favor introduzca la clave del expediente.");
		  f.cve_expe.focus();
		  return(false);
	}
	if (f.nom_expe.value.length < 1) {
		  alert("Por favor introduzca el nombre del expediente.");
		  f.nom_expe.focus();
		  return(false);
	}
	<? } ?>
}
//-->
</script>