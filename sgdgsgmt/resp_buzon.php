<?php
/*--------------------------------------------------------------------------------------
|
|	Archivo:	resp_buzon.php
|	Autor:		Sa�l E Morales Cedillo (ccedillo@df.gob.mx)
|	Fecha:		Noviembre 2002
|
|	Gobierno del Distrito Federal
|	Oficial�a Mayor
|	Coordinaci�n Ejecutiva de Desarrollo Inform�tico
|	Direcci�n de Nuevas Tecnolog�as
|
|	�ltima actualizaci�n:	04/11/2002
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