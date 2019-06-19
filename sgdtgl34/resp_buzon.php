<?php
/*--------------------------------------------------------------------------------------
|
|	Archivo:	resp_buzon.php
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
if (!$variable || $variable=="") {
	include "lista_resp.php";
} else {
	$including=$variable.".php";
	include ("$including");
}
echo "&nbsp;";
?>