<?
require("../config/scg.php");
require("../config/html.php");
require("../includes/scg.lib.php");

print ("<body bgcolor='$default->body_bgcolor' text='$default->body_textcolor' link='$default->body_link' vlink='$default->body_vlink' onLoad='window.opener.document.plantilla_documento.ventana_auxiliar.value=\"abierta\"'>\n");
print ("<link rel='stylesheet' type='text/css' title='style1' href='$default->styles'>");

print("<br>\n<center><font class='bigsubtitle'>$variable $lang_siglas</font>\n<br>\n");

$sql = new scg_DB;
$sql->query("SELECT count(*) from promotor where cve_prom='$id'");
if ($sql->num_rows($sql)>0) {
	while($sql->next_record()) {
		$en_catalogo = $sql->f("0");
	}
}
if ($en_catalogo>0) {
		$query="UPDATE promotor set siglas='$siglas',nom_prom='$nom_prom',tit_prom='$tit_prom',tipo='$tipo',domicilio='$domicilio',colonia='$colonia',codigo_post='$codigo_post',";
		if ($delegacion!="0") {
			$query.="delegacion='$delegacion',";
		}
		if ($entidad!="0") {
			$query.="entidad='$entidad',";
		}
		$query.="telefono='$telefono',car_titu='$car_titu' where cve_prom='$id'";
		$resulta = $sql->query($query);
	if (!$resulta) {
		printf("<br>¡ Error en el query o con la base de datos !\n");
		printf("<br><br><input type='button' value='Regresar' onClick='javascript: history.go(-1);'>");
	} else {
		printf("<br>El registro ha sido actualizado.\n");
		printf("<br><br><form action='admonCatalogo.php?sess=$sess&control_catalogos=1&origen=$origen' method='post'><input type='submit' value='Aceptar'></form>");
	}
} else {
	printf("<br>El promotor/remitente que intenta actualizar ya no existe.<br> Por favor revise los datos que capturó.");
	printf("<br><br><form action='admonCatalogo.php?sess=$sess&control_catalogos=1&origen=$origen' method='post'><input type='submit' value='Regresar'></form>");
}
print("<br></center>\n<br>\n");
?>