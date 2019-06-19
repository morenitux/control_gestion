<?
require("config/scg.php");
require("config/html.php");
require("includes/scg.lib.php");

print ("<body bgcolor='$default->body_bgcolor' text='$default->body_textcolor' link='$default->body_link' vlink='$default->body_vlink' onLoad='window.opener.document.plantilla_documento.ventana_auxiliar.value=\"abierta\"'>\n");
print ("<link rel='stylesheet' type='text/css' title='style1' href='$default->styles'>");

print("<br>\n<center><font class='bigsubtitle'>$variable Usuario</font>\n<br>\n");

$sql = new scg_DB;
$sql->query("SELECT count(*) from docsal where usua_sal='$usuario_original' or modi_sal='$usuario_original' or usua_resp='$usuario_original' or modi_resp='$usuario_original' or acuso_turno='$usuario_original' or acuso_resp='$usuario_original'");
if ($sql->num_rows($sql)>0) {
	while($sql->next_record()) {
		$en_docsal = $sql->f("0");
	}
}
$sql->query("SELECT count(*) from documento where usua_doc='$usuario_original' or modifica='$usuario_original'");
if ($sql->num_rows($sql)>0) {
	while($sql->next_record()) {
		$en_documento = $sql->f("0");
	}
}
if ($en_documento>0 || $en_docsal>0) {
		printf("<br>El usuario que intenta borrar tiene documentos relacionados y no puede ser eliminado.");
		printf("<br><br><form action='principal.php?sess=$sess&control_botones_superior=10' method='post'><input type='submit' value='Regresar'></form>");
} else {
	$sql->query("SELECT count(*) from usuarios where usuario='$usuario_original'");
	if ($sql->num_rows($sql)>0) {
		while($sql->next_record()) {
			$en_catalogo = $sql->f("0");
		}
	}
	if ($en_catalogo>0) {
		$resulta = $sql->query("DELETE from usuarios where usuario='$usuario_original'");
		if (!$resulta) {
			printf("<br>¡ Error en el query o con la base de datos !\n");
			printf("<br><br><input type='button' value='Regresar' onClick='javascript: history.go(-1);'>");
		} else {
			printf("<br>Se ha borrado el registro \"$usuario_original\".\n");
			printf("<br><br><form action='principal.php?sess=$sess&control_botones_superior=10' method='post'><input type='submit' value='Aceptar'></form>");
		}
	} else {
		printf("<br>El usuario que intenta borrar ya no existe.<br> Por favor revise los datos que seleccionó.");
		printf("<br><br><form action='principal.php?sess=$sess&control_botones_superior=10' method='post'><input type='submit' value='Regresar'></form>");
	}
}
print("<br></center>\n<br>\n");
?>