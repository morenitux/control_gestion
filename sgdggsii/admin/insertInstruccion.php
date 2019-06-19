<?
require("../config/scg.php");
require("../config/html.php");
require("../includes/scg.lib.php");
include("../includes/generador_claves.inc");

print ("<body bgcolor='$default->body_bgcolor' text='$default->body_textcolor' link='$default->body_link' vlink='$default->body_vlink' onLoad='window.opener.document.plantilla_documento.ventana_auxiliar.value=\"abierta\"'>\n");
print ("<link rel='stylesheet' type='text/css' title='style1' href='$default->styles'>");

print("<br>\n<center><font class='bigsubtitle'>$variable $lang_siglas</font>\n<br>\n");

$cve_ins=clave_generada("instruccion","cve_ins",$instruccion);

$sql = new scg_DB;
$sql->query("SELECT count(*) from instruccion where cve_ins='$cve_ins'");
if ($sql->num_rows($sql)>0) {
	while($sql->next_record()) {
		$en_catalogo = $sql->f("0");
	}
}
if ($en_catalogo>0) {
	printf("<br>La clave de instrucción que intenta ingresar ya existe<br>y no puede duplicarse. Intente con otra clave.");
	printf("<br><input type='button' value='Regresar' onClick='javascript: history.go(-1);'>");
} else {
	$query="INSERT into instruccion (cve_ins,instruccion,tipo,orden) values ('$cve_ins','$instruccion','$tipo','$orden')";
//	echo $query."<br>";
  $resulta = $sql->query($query);
	if (!$resulta) {
		printf("<br>¡ Error en el query o con la base de datos !\n");
		printf("<br><br><input type='button' value='Regresar' onClick='javascript: window.close();'>");
	} else {
		printf("<br><br>Se ha insertado el registro.\n");
		print("<br><br><form action='admonCatalogo.php?sess=$sess&control_catalogos=");
		switch ($tipo) {
			case "I":
				print("7");
			break;
			case "D":
				print("8");
			break;
		}
		print("&origen=$origen' method='post'><input type='submit' value='Aceptar'></form>");
	}
}
print("<br></center>\n<br>\n");
?>