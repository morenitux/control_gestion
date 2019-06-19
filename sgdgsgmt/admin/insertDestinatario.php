<?
require("../config/scg.php");
require("../config/html.php");
require("../includes/scg.lib.php");
include("../includes/generador_claves.inc");

print ("<body bgcolor='$default->body_bgcolor' text='$default->body_textcolor' link='$default->body_link' vlink='$default->body_vlink' onLoad='window.opener.document.plantilla_documento.ventana_auxiliar.value=\"abierta\"'>\n");
print ("<link rel='stylesheet' type='text/css' title='style1' href='$default->styles'>");

print("<br>\n<center><font class='bigsubtitle'>$variable $lang_siglas</font>\n<br>\n");

$clave=clave_generada("dirigido","clave",$nombre);

$sql = new scg_DB;
$sql->query("SELECT count(*) from dirigido where clave='$clave'");
if ($sql->num_rows($sql)>0) {
	while($sql->next_record()) {
		$en_catalogo = $sql->f("0");
	}
}
if ($en_catalogo>0) {
	printf("<br>La clave de destinatario que intenta ingresar ya existe<br>y no puede duplicarse. Intente con otra clave.");
	printf("<br><br><input type='button' value='Regresar' onClick='javascript: history.go(-1);'>");
} else {
	$query="INSERT into dirigido (clave,nombre,cargo) values ('$clave','$nombre','$cargo')";
	//echo $query."<br>";
	$resulta = $sql->query($query);
	if (!$resulta) {
		printf("<br>¡ Error en el query o con la base de datos !\n");
		printf("<br><br><input type='button' value='Regresar' onClick='javascript: history.go(-1);'>");
	} else {
		printf("<br><br>Se ha insertado el registro.\n");
		printf("<br><br><form action='admonCatalogo.php?sess=$sess&control_catalogos=9&origen=$origen' method='post'><input type='submit' value='Aceptar'></form>");
	}
}
print("<br></center>\n<br>\n");
?>