<?
require("../config/scg.php");
require("../config/html.php");
require("../includes/scg.lib.php");

print ("<body bgcolor='$default->body_bgcolor' text='$default->body_textcolor' link='$default->body_link' vlink='$default->body_vlink' onLoad='window.opener.document.plantilla_documento.ventana_auxiliar.value=\"abierta\"'>\n");
print ("<link rel='stylesheet' type='text/css' title='style1' href='$default->styles'>");

print("<br>\n<center><font class='bigsubtitle'>$variable $lang_siglas</font>\n<br>\n");

$sql = new scg_DB;
$sql->query("SELECT count(*) from dependencia where cve_depe='$id'");
if ($sql->num_rows($sql)>0) {
	while($sql->next_record()) {
		$en_catalogo = $sql->f("0");
	}
}
if ($en_catalogo>0) {
		$query="UPDATE dependencia set siglas='$siglas',nom_depe='$nom_depe',nom_titu='$nom_titu',car_titu='$car_titu',titulo_titu='$titulo_titu',dir_depe='$dir_depe',tel_depe='$tel_depe',orden='$orden' where cve_depe='$id'";
		$resulta = $sql->query($query);
	if (!$resulta) {
		printf("<br>¡ Error en el query o con la base de datos !\n");
		printf("<br><br><input type='button' value='Regresar' onClick='javascript: history.go(-1);'>");
	} else {
		printf("<br>El registro ha sido actualizado.\n");
		printf("<br><br><form action='admonCatalogo.php?sess=$sess&control_catalogos=5' method='post'><input type='submit' value='Aceptar'></form>");
	}
} else {
	printf("<br>La dependencia que intenta actualizar ya no existe.<br> Por favor revise los datos que capturó.");
	printf("<br><br><form action='admonCatalogo.php?sess=$sess&control_catalogos=5' method='post'><input type='submit' value='Regresar'></form>");
}
print("<br></center>\n<br>\n");
?>