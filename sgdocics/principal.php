<?php
/*--------------------------------------------------------------------------------------
|
|	Archivo:	principal.php
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
if ($control_botones_superior=="999") {
	print("<td width=200 align=center valign=top>\n");
	include "includes/control_catalogos.inc";
	print("</td>\n<td width=700 align=center valign=top>\n");
}
switch ($control_botones_superior) {
	case "999":
		if ($control_catalogos!="0") {
			print("<center>Administración de Catálogos</center>");
			//include "admin/admonCatalogo.php";
		}
	break;
	case "1":
		include "documento.php";
	break;
	case "2":
		include "salidas.php";
	break;
	case "3":
		if ($tipo_reporte==0 || $tipo_reporte=="") $tipo_reporte=4;
		include "estadisticas_documento.php";
	break;
	case "5":
		include "estadisticas_turnos.php";
	break;
	case "7":
		include "soli_buzon.php";
	break;
	case "8":
		include "resp_buzon.php";
	break;
	case "9":
		include "consola_impresion.php";
	break;
	case "10":
		include "consola_usuarios.php";
	break;
}
echo "&nbsp;";
print("</td>\n");

include("./includes/footer.inc");
?>