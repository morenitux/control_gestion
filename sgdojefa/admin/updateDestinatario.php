<?
require("../config/scg.php");
require("../config/html.php");
require("../includes/scg.lib.php");

print ("<body bgcolor='$default->body_bgcolor' text='$default->body_textcolor' link='$default->body_link' vlink='$default->body_vlink' onLoad='window.opener.document.plantilla_documento.ventana_auxiliar.value=\"abierta\"'>\n");
print ("<link rel='stylesheet' type='text/css' title='style1' href='$default->styles'>");

print("<br>\n<center><font class='bigsubtitle'>$variable $lang_siglas</font>\n<br>\n");

$sql = new scg_DB;
$sql->query("SELECT count(*) from dirigido where clave='$id'");
if ($sql->num_rows($sql)>0) {
	while($sql->next_record()) {
		$en_catalogo = $sql->f("0");
	}
}
if ($en_catalogo>0) {
		$query="UPDATE dirigido set nombre='$nombre',cargo='$cargo' where clave='$id'";
		$resulta = $sql->query($query);
	if (!$resulta) {
		printf("<br>� Error en el query o con la base de datos !\n");
		printf("<br><br><input type='button' value='Regresar' onClick='javascript: history.go(-1);'>");
	} else {
		printf("<br>El registro ha sido actualizado.\n");
		printf("<br><br><form action='admonCatalogo.php?sess=$sess&control_catalogos=9&origen=$origen' method='post'><input type='submit' value='Aceptar'></form>");
	}
} else {
	printf("<br>El destinatario que intenta actualizar ya no existe.<br> Por favor revise los datos que captur�.");
	printf("<br><br><form action='admonCatalogo.php?sess=$sess&control_catalogos=9&origen=$origen' method='post'><input type='submit' value='Regresar'></form>");
}
print("<br></center>\n<br>\n");
?>