<?
require("../config/scg.php");
require("../config/html.php");
require("../includes/scg.lib.php");
include("../includes/generador_claves.inc");

print ("<body bgcolor='$default->body_bgcolor' text='$default->body_textcolor' link='$default->body_link' vlink='$default->body_vlink' onLoad='window.opener.document.plantilla_documento.ventana_auxiliar.value=\"abierta\"'>\n");
print ("<link rel='stylesheet' type='text/css' title='style1' href='$default->styles'>");

print("<br>\n<center><font class='bigsubtitle'>$variable $lang_siglas</font>\n<br>\n");

$cve_turn=clave_generada("turnador","cve_turn",$nom_turn);

$sql = new scg_DB;
$sql->query("SELECT count(*) from turnador where cve_turn='$cve_turn'");
if ($sql->num_rows($sql)>0) {
	while($sql->next_record()) {
		$en_catalogo = $sql->f("0");
	}
}
if ($en_catalogo>0) {
	printf("<br>La clave del turnador que intenta ingresar ya existe<br>y no puede duplicarse. Intente con otra clave.");
	printf("<br><br><input type='button' value='Regresar' onClick='javascript: history.go(-1);'>");
} else {
	$query="INSERT into turnador (cve_turn,nom_turn,car_turn,no_oficio) values ('$cve_turn','$nom_turn','$car_turn','$no_oficio')";
	$resulta = $sql->query($query);
	if (!$resulta) {
		printf("<br>¡ Error en el query o con la base de datos !\n");
		printf("<br><br><input type='button' value='Regresar' onClick='javascript: history.go(-1);'>");
	} else {
		printf("<br><br>Se ha insertado el registro.\n");
		printf("<br><br><form action='admonCatalogo.php?sess=$sess&control_catalogos=6' method='post'><input type='submit' value='Aceptar'></form>");
	}
}
print("<br></center>\n<br>\n");
?>