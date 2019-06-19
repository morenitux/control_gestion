<?php
/*--------------------------------------------------------------------------------------
|
|	Archivo:	scg.php
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

// URLS
$default->scg_root_url		= "/scg/sgdggsii";
$default->scg_graphics_url	= $default->scg_root_url . "/images";

// Directorio donde se aloja el SCG
$default->scg_fs_root		= "/var/www/html/scg/sgdggsii";
$default->scg_LangDir		= $default->scg_fs_root . "/language";

// Folios automaticos (0) o manuales (1)
$default->scg_tipo_folios	= "0";

// Captura masiva y después turnos masivos (0) o turno inmediatamente después de captura (1)
$default->scg_tipo_turnos_captura	= "1";


// Motor de base de datos
require("$default->scg_fs_root/phplib/db_pgsql.inc");

// Idioma
$default->scg_lang		= "Spanish";

// Datos del administrador
$default->scg_admin_email	=	'rgil@metro.df.gob.mx';
$default->scg_admin_phone	=	'5627-4813';
$default->scg_admin_name	=	'SCG Admin';

// Notificaciones vía email
$default->scg_notify_from 		= "Sistema de Control de Gestion";
$default->scg_notify_replyto 	= "rgil@metro.df.gob.mx";
$default->scg_notify_link     	= "http://$SERVER_NAME$default->scg_root_url/";
$default->scg_email_from		= "rgil@metro.df.gob.mx";
$default->scg_email_fromname	= "Sistema de Control de Gestión del STC";
$default->scg_email_replyto 	= "rgil@metro.df.gob.mx";
$default->scg_email_server 		= "ip_del_servidor_de_correo";
//FIN email

// Imagen logotipo
$default->logo = "stc_dt.png";

// Tiempo máximo de conexion
$default->scg_timeout		= "7800";

// Tiempo para permitir reingreso si una sesion se queda colgada
$default->scg_time_forback	= "7200";

// Versión del sistema para despliegue
$default->version = "SCG-WEB v1.0";
$default->phpversion = "4.0.2";

$default->arg_DB = "SCG01";
?>
