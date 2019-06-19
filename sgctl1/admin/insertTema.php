<?
require("../config/scg.php");
require("../config/html.php");
require("../includes/scg.lib.php");
include("../includes/generador_claves.inc");

print ("<body bgcolor='$default->body_bgcolor' text='$default->body_textcolor' link='$default->body_link' vlink='$default->body_vlink' onLoad='window.opener.document.plantilla_documento.ventana_auxiliar.value=\"abierta\"'>\n");
print ("<link rel='stylesheet' type='text/css' title='style1' href='$default->styles'>");

print("<br>\n<center><font class='bigsubtitle'>$variable $lang_siglas</font>\n<br>\n");

$cve_tema=clave_generada("tema","cve_tema",$topico);

$sql = new scg_DB;
$sql->query("SELECT count(*) from tema where cve_tema='$cve_tema'");
if ($sql->num_rows($sql)>0) {
	while($sql->next_record()) {
		$en_catalogo = $sql->f("0");
	}
}
if ($en_catalogo>0) {
	printf("<br>La clave de tema que intenta ingresar ya existe<br>y no puede duplicarse. Intente con otra clave.");
	printf("<br><input type='button' value='Regresar' onClick='javascript: history.go(-1);'>");
} else {
	$query="INSERT into tema (cve_tema,topico,tipo) values ('$cve_tema','$topico','$tipo')";
	$resulta = $sql->query($query);
	if (!$resulta) {
		printf("<br>¡ Error en el query o con la base de datos !\n");
		printf("<br><br><input type='button' value='Regresar' onClick='javascript: window.close();'>");
	} else {
		print("<br><br>Se ha insertado el registro.\n");
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
}
print("<br></center>\n<br>\n");
?>