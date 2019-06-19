<?
require("../config/scg.php");
require("../config/html.php");
require("../includes/scg.lib.php");

print ("<body bgcolor='$default->body_bgcolor' text='$default->body_textcolor' link='$default->body_link' vlink='$default->body_vlink' onLoad='window.opener.document.plantilla_documento.ventana_auxiliar.value=\"abierta\"'>\n");
print ("<link rel='stylesheet' type='text/css' title='style1' href='$default->styles'>");

print("<br>\n<center><font class='bigsubtitle'>$variable $lang_siglas</font>\n<br>\n");
$sql = new scg_DB;
$sql->query("SELECT count(*) from documento where cve_eve='$id' union SELECT count(*) from doctem where cve_tema='$id'");
if ($sql->num_rows($sql)>0) {
	while($sql->next_record()) {
		$en_documento = $sql->f("0");
	}
}
if ($en_documento>0) {
		printf("<br>El registro que intenta borrar tiene turnos y/o documentos relacionados y no puede ser eliminado.");
		print("<br><br><form action='admonCatalogo.php?sess=$sess&control_catalogos=");
		switch ($tipo) {
			case "T":
				print("3");
			break;
			case "E":
				print("4");
			break;
		}
		print("&origen=$origen' method='post'><input type='submit' value='Aceptar'></form>");
} else {
	$sql->query("SELECT count(*) from tema where cve_tema='$id'");
	if ($sql->num_rows($sql)>0) {
		while($sql->next_record()) {
			$en_catalogo = $sql->f("0");
		}
	}
	if ($en_catalogo>0) {
		$resulta = $sql->query("DELETE from tema where cve_tema='$id'");
		if (!$resulta) {
			print("<br>¡ Error en el query o con la base de datos !\n");
			print("<br><br><input type='button' value='Regresar' onClick='javascript: history.go(-1);'>");
		} else {
			print("<br>Se ha borrado el registro \"$id\".\n");
			print("<br><br><form action='admonCatalogo.php?sess=$sess&control_catalogos=");
			switch ($tipo) {
				case "T":
					print("3");
				break;
				case "E":
					print("4");
				break;
			}
			print("&origen=$origen' method='post'><input type='submit' value='Aceptar'></form>");
		}
	} else {
		print("<br>El promotor/remitente que intenta borrar ya no existe.<br> Por favor revise los datos que seleccionó.");
		print("<br><br><form action='admonCatalogo.php?sess=$sess&control_catalogos=");
		switch ($tipo) {
			case "T":
				print("3");
			break;
			case "E":
				print("4");
			break;
		}
		print("&origen=$origen' method='post'><input type='submit' value='Regresar'></form>");
	}
}
print("<br></center>\n<br>\n");
?>