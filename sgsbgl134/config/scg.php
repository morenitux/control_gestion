<?php
/*--------------------------------------------------------------------------------------
|
|	Archivo:	scg.php
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

// URLS
$default->scg_root_url		= "/scg/sgsbgl134";
$default->scg_graphics_url	= $default->scg_root_url . "/images";

// Directorio donde se aloja el SCG
$default->scg_fs_root		= "/var/www/html/scg/sgsbgl134";
$default->scg_LangDir		= $default->scg_fs_root . "/language";

// Folios automaticos (0) o manuales (1)
$default->scg_tipo_folios	= "0";

// Captura masiva y despu�s turnos masivos (0) o turno inmediatamente despu�s de captura (1)
$default->scg_tipo_turnos_captura	= "1";


// Motor de base de datos
require("$default->scg_fs_root/phplib/db_pgsql.inc");

// Idioma
$default->scg_lang		= "Spanish";

// Datos del administrador
$default->scg_admin_email	=	'jose.morenog@metro.cdmx.gob.mx';
$default->scg_admin_phone	=	'4991';
$default->scg_admin_name	=	'SCG Admin';

// Notificaciones v�a email
$default->scg_notify_from 		= "Sistema de Control de Gestion";
$default->scg_notify_replyto 	= "jose.morenog@metro.cdmx.gob.mx";
$default->scg_notify_link     	= "http://$SERVER_NAME$default->scg_root_url/";
$default->scg_email_from		= "jose.morenog@metro.cdmx.gob.mx";
$default->scg_email_fromname	= "Sistema de Control de Gestión del STC";
$default->scg_email_replyto 	= "jose.morenog@metro.cdmx.gob.mx";
$default->scg_email_server 		= "ip_del_servidor_de_correo";
//FIN email

// Imagen logotipo
$default->logo = "stc_dt.png";

// Tiempo m�ximo de conexion
$default->scg_timeout		= "7800";

// Tiempo para permitir reingreso si una sesion se queda colgada
$default->scg_time_forback	= "7200";

// Versi�n del sistema para despliegue
$default->version = "SCG-WEB v1.0";
$default->phpversion = "4.0.2";

$default->arg_DB = "SCG01";
?>
