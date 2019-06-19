<?php
/*--------------------------------------------------------------------------------------
|
|	Archivo:	listados.php
|	Autor:		Saúl E Morales Cedillo (ccedillo@df.gob.mx)
|	Fecha:		Noviembre 2002
|
|	Gobierno del Distrito Federal
|	Oficialía Mayor
|	Coordinación Ejecutiva de Desarrollo Informático
|	Dirección de Nuevas Tecnologías
|
|	Última actualización:	04/11/2002
|
--------------------------------------------------------------------------------------*/
require("./config/scg.php");
require("./config/html.php");
require("./includes/scg.lib.php");
$titulo_en_header = $default->scg_title_in_header;
$windowname = "Principal";
include("./includes/header.inc");
if (!$variable || $variable=="") {
	print("</td>\n<td width=700 align=center valign=top>\n");
	switch ($control_botones_superior) {
		case "3":
			include "lista_documentos.php";
		break;
		case "5":
			include "lista_turnos.php";
		break;
	}
} else {
	$including=$variable.".php";
	include ("$including");
}
echo "&nbsp;";
print("</td>\n");

include("./includes/footer.inc");
?>