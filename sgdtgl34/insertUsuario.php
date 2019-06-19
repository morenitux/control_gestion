<?
require("config/scg.php");
require("config/html.php");
require("includes/scg.lib.php");

print ("<body bgcolor='$default->body_bgcolor' text='$default->body_textcolor' link='$default->body_link' vlink='$default->body_vlink' onLoad='window.opener.document.plantilla_documento.ventana_auxiliar.value=\"abierta\"'>\n");
print ("<link rel='stylesheet' type='text/css' title='style1' href='$default->styles'>");

print("<br>\n<center><font class='bigsubtitle'>$variable Usuario</font>\n<br>\n");


$sql = new scg_DB;
$sql->query("SELECT count(*) from usuarios where usuario='$usuario'");
if ($sql->num_rows($sql)>0) {
	while($sql->next_record()) {
		$en_catalogo = $sql->f("0");
	}
}
if ($en_catalogo>0) {
	printf("<br>El login de usuario que intenta ingresar ya existe<br>y no puede duplicarse. Intente con otro usuario.");
	printf("<br><input type='button' value='Regresar' onClick='javascript: history.go(-1);'>");
} else {
	$query="INSERT into usuarios (usuario,grupo,clave,creator,aplica,descrip) values ('$usuario','999','$clave','99XXXX','SCG','$descrip')";
	$resulta = $sql->query($query);
	if (!$resulta) {
		printf("<br>¡ Error en el query o con la base de datos !\n");
		printf("<br><br><input type='button' value='Regresar' onClick='javascript: window.close();'>");
	} else {
		printf("<br><br>Se ha insertado el registro.\n");
		printf("<br><br><form action='principal.php?sess=$sess&control_botones_superior=10' method='post'><input type='submit' value='Aceptar'></form>");
	}
}
print("<br></center>\n<br>\n");
?>