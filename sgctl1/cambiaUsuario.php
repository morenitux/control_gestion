<?php
switch ($accion) {
	case "insert":
		$variable = "Alta ";
	break;
	case "update":
		$variable = "Cambio ";
	break;
	case "delete":
		$variable = "Baja ";
	break;
}
print("<br>\n<center><font class='bigsubtitle'>$variable Usuario $lang_siglas</font></center>\n<br>\n");

$usuario_tbl 	= "";
$clave_tbl 		= "";
$descrip_tbl 	= "";

if ($accion!="insert") {
	$sql = new scg_DB;
	$sql->query("SELECT * from usuarios where usuario='$parametro'");
	$num = $sql->num_rows($sql);
	if ($num == 1) {
		while($sql->next_record()) {
			$usuario_tbl 	= $sql->f("usuario");
			$clave_tbl 		= $sql->f("clave");
			$descrip_tbl 	= $sql->f("descrip");
		}
		print ("<body bgcolor='$default->body_bgcolor' text='$default->body_textcolor' link='$default->body_link' vlink='$default->body_vlink' onLoad='window.opener.document.plantilla_documento.ventana_auxiliar.value=\"abierta\"; despliegaAmbitos(document.captura_promotor,\"$cabeza_sector_jalado\"); seleccionaAmbito(\"$ambito_jalado\"); despliegaDependencia(document.captura_promotor,\"$ambito_jalado\"); alert(\"reseteada\");'>\n");
	} else {
		if ($num > 1) {
			print("Error\n");
			exit;
		} else {
			$usuario_tbl 	= "";
			$clave_tbl 		= "";
			$descrip_tbl 	= "";
		}
	}
}
print("<form name='captura_usuario' action='$accion"."Usuario.php?sess=$sess' method='post' target='_self' onsubmit='return regform_Validator(this)'>\n");
print("<center>\n");
if ($accion=="delete") print("<font class='alerta'>$lang_catdelete_warn</font>\n");
?>

<table border=0  width="700">
 <tr>
  <td align="right" width="25%">
   Usuario:
  </td>
  <td>
   <input type="text" name="usuario"  value="<? echo $usuario_tbl ?>"size=10 maxlength=8 <? if ($accion=="delete" || $accion=="update") { echo "onFocus='this.blur();'"; }?> onChange="this.value=this.value.toUpperCase();">
   <input type="hidden" name="usuario_original" value="<? echo $usuario_tbl ?>">
  </td>
 </tr>
 <tr>
  <td align="right" width="25%">
   Clave:
  </td>
  <td>
   <input type="text" name="clave" value="<? echo $clave_tbl ?>"size=10 maxlength=8 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?> onChange="this.value=this.value.toUpperCase();">
   <input type="hidden" name="clave_original" value="<? echo $clave_tbl ?>">
  </td>
 </tr>
 <tr>
  <td align="right" width="25%">
   Descripción:
  </td>
  <td>
   <input type="text" name="descrip" value="<? echo $descrip_tbl ?>"size=40 maxlength=50 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?> onChange="this.value=this.value.toUpperCase();">
  </td>
 </tr>
</table>
<?
print("<input type='button' value='$lang_basicbutton_x' onClick='location=\"principal.php?sess=$sess&control_botones_superior=10\"'>");
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
	<?php if ($accion!="delete") { ?>
	if (f.usuario.value.length < 1) {
		  alert("Por favor introduzca o verifique el login de usuario.");
		  f.usuario.focus();
		  return(false);
	}
	if (f.clave.value.length < 5) {
		  alert("Por favor introduzca o verifique que la clave o contraseña del usuario sea de al menos 5 letras o números sin espacios ni caracteres especiales.");
		  f.clave.focus();
		  return(false);
	}
	<?php } else { ?>
		return(true);
	<?php } ?>
}
</script>