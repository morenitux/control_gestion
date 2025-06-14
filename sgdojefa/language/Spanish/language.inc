<?php
/*--------------------------------------------------------------------------------------
|
|	Archivo:	language.inc (ESPA�OL)
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


$lang_app_name		= "Sistema de Control de Gesti�n Semaforos V.1";
$lang_owner_name	= "Jefatura de la D.T.";
$lang_siglas		= "(SCG-Jefatura de la D.T.)";
$lang_logout		= "Salir";
$lang_close		= "Cerrar";
$lang_login		= "Entrar";
$lang_successlogout	= "Gracias por utilizar el $lang_app_name.<br>Para entrar de nuevo, reg�strate:<br>";
$lang_loginfail 	= "Clave de usuario o contrase�a inv�lidos. Favor de verificar:<br>";
$lang_logindisabled 	= "La cuenta ha sido DESHABILITADA, contacte al Administrador del Sistema";

$lang_sessinuse 	= "<b>ATENCION:</b> Su cuenta tiene una sesi�n activa en otra<br>computadora y se la ha negado acceso al sistema.<br>Comun�quese inmediatamente con el administrador<br>al Tel.".$default->scg_admin_phone." o al correo electr�nico <a href='mailto:".$default->scg_admin_email."?subject=scg-LOGIN'>".$default->scg_admin_email."</a>";
$lang_invalidsess	= "Identificador de sesi�n invalido, por favor intente accesar nuevamente en la <a href='".$default->scg_root_url."/'>p�gina principal</a><br>Si tiene problemas para ingresar al sistema, comun�quese con el administrador al Tel.".$default->scg_admin_phone."<br>o al correo electr�nico <a href='mailto:".$default->scg_admin_email."?subject=scg-".$sess."'>".$default->scg_admin_email."</a>";
$lang_sesstimeout	= "Su sesi�n ha expirado, por favor intente accesar nuevamente en la <a href='".$default->scg_root_url."/'>p�gina principal</a><br>Si tiene problemas para ingresar al sistema, comun�quese con el administrador al Tel.".$default->scg_admin_phone."<br>o al correo electr�nico <a href='mailto:".$default->scg_admin_email."?subject=scg-".$sess."'>".$default->scg_admin_email."</a>";

//$lang_sessinuse 	= "La sesi�n esta activa en otra computadora, acceso denegado";
//$lang_invalidsess	= "Identificador de sesi�n invalido, por favor intente acceder nuevamente en la <a href='".$default->scg_root_url."/'>p�gina principal</a>";
//$lang_sesstimeout	= "Su sesi�n ha expirado, por favor intente acceder nuevamente al sistema";

$lang_cat_1		= "Promotores / remitentes";
$lang_cat_2		= "Expedientes";
$lang_cat_3		= "Temas";
$lang_cat_4		= "Eventos";
$lang_cat_5		= "Dependencias";
$lang_cat_6		= "Turnadores";
$lang_cat_7		= "Instrucciones";
$lang_cat_8		= "Tipos de Documentos";
$lang_cat_9		= "Destinatarios";
$lang_cat_10		= "";
$lang_cat_11		= "";
$lang_cat_7single	= "Instrucci�n";
$lang_cat_8single	= "Tipo de Documento";
$lang_new		= "Nuevo";
$lang_basicbutton_a	= " Alta ";
$lang_basicbutton_b	= " Borrar ";
$lang_basicbutton_c	= " Cambio ";
$lang_basicbutton_x	= " Cancelar ";
$lang_no_catresults	= "No hay registros en el cat�logo";
$lang_catdelete_warn	= "Se borrar� toda la informaci�n correspondiente al siguiente registro:";




//DE AQUI EN ADELANTE HAY QUE SUPER REVISAR ANTES DE LIBERAR LA VERSION
$lang_currentdir="Directorio Actual:";
$lang_addingfolder = "Agregar la carpeta a ";
$lang_addingfile = "Agregar el archivo a la carpeta ";
$lang_modifying = "Modificando ";
$lang_reallydelete = "Est�s seguro de eliminar";
$lang_addfolder = "<IMG SRC='$default->scg_graphics_url/btn_add_folder.gif' BORDER=0>";
$lang_addfile = "<IMG SRC='$default->scg_graphics_url/btn_add_file.gif' BORDER=0>";
$lang_title = "Nombre";
//ccedillo
$lang_user_tag = "Nombre completo del usuario";
$lang_group_tag = "Nombre del grupo";
$lang_required = "Requerido";
$lang_notify_explanation = "Marca la casilla si deseas que este usuario reciba notificaciones a su correo electr�nico de manera autom�tica cada vez que sea depositado o actualizado un documento relacionado con su grupo primario y secundario(s).";
$lang_notify_explanation2 = "Marca la casilla si deseas recibir notificaciones a tu correo electr�nico de manera autom�tica cada vez que sea depositado o actualizado un documento relacionado con tu grupo primario y/o secundario(s).";
$lang_disable_explanation = "Marca la casilla para deshabilitar al usuario y evitar que ingrese al archivo electr�nico.";
$lang_name_required = "Inserte el nombre completo del usuario";
$lang_username_required = "Inserte la clave de acceso del usuario";
$lang_password_required = "Debe capturar una contrase�a de al menos 4 caracteres alfanum�ricos";
$lang_email_required = "Para recibir notificaciones es indispensable que capture una cuenta de correo electr�nico";
$lang_folder_name_required = "El nombre de la carpeta no debe ser nulo";
$lang_fileupload_required = "Debe elegir el documento que desea depositar en el archivo electr�nico utilizando el bot�n <<Browse>>";
$lang_filename_required = "Capture el nombre o etiqueta que identificar� al documento";
$lang_filedescription_required = "Debe capturar una descripci�n breve del contenido del archivo";





//ccedillo
$lang_userlang = "Idioma";
// begin Daphne change
$lang_held = "Bloqueado por";
// for version control
$lang_ver = "Ver.";
// for version control
// end Daphne change
$lang_file = "Archivo";
$lang_size = "Tama�o";
$lang_postedby = "Agregado por";
$lang_modified = "Modificado";
$lang_actions = "Acciones";
$lang_ownership = "Propiedad de";
$lang_newpolicy = "Nueva Pol�tica";
$lang_policy = "Pol�tica";
$lang_sendthisfile = "Subir este archivo";
$lang_sendfile = "Enviar archivo";
$lang_keywords = "Palabras clave";
$lang_newpermissions = "Nuevos Permisos";
$lang_permissions = "Permisos";
$lang_description = "Descripci�n";
$lang_change = "Actualizar";
$lang_reset = "Restaurar";
$lang_create = "Crear";
// begin Daphne change
$lang_vertype = "Tipo de revisi�n";
// for modify.php when uploading
$lang_vermajor = "Revisi�n extensiva";
$lang_verminor = "Revision m�nima";
$lang_verdescription = "Descripci�n de cambios";
// end Daphne change
$lang_everyoneread = "Cualquier usuario puede leer/descargar";
$lang_everyonewrite = "Cualquier usuario puede leer/escribir/descargar";
$lang_everyonewrite_nod = "Cualquier usuario puede leer/escribir/descargar, NO BORRAR";
$lang_groupread = "COMPARTIDO: Tu grupo puede leer/descargar (no borrar ni actualizar)";
$lang_groupwrite = "Tu grupo puede leer/descargar/actualizar";
$lang_groupwrite_nod = "GRUPAL: Tu grupo puede leer/descargar/actualizar (no borrar)";
$lang_onlyyou = "PRIVADO: Solamente t� puedes leer/escribir/descargar";
$lang_groupwrite_worldread = "El grupo seleccionado puede leer/escribir/descargar y cualquiera puede leer";
$lang_groupwrite_worldread_nod = "El grupo seleccionado leer/escribir/descargar (NO BORRAR) y cualquiera puede leer";
$lang_ggroupwrite_worldread = "El grupo seleccionado puede subir y borrar archivos de esta carpeta y cualquiera puede ver su contenido";
$lang_ggroupwrite_worldread_nod = "El grupo seleccionado puede subir y borrar archivos de esta carpeta y cualquiera puede ver su contenido, NO BORRAR";
// BEGIN BUG FIX: #449394 add document policy bugs for admin
$lang_everyoneread_ad = "Cualquiera puede leer/descargar";
$lang_everyonewrite_ad = "Cualquiera puede leer/escribir/descargar";
$lang_everyonewrite_ad_nod = "Cualquiera puede leer/descargar/actualizar (no borrar)";
$lang_groupread_ad = "COMPARTIDO: El grupo due�o puede leer/descargar";
$lang_groupwrite_ad = "Tu grupo puede leer/escribir/descargar";
$lang_groupwrite_ad_nod = "GRUPAL: El grupo due�o puede leer/descargar/actualizar (no borrar)";
$lang_onlyyou_ad = "PRIVADO: S�lo el due�o puede leer/descargar/actualizar";
$lang_groupwrite_worldread_ad = "El grupo seleccionado puede leer/escribir/descargar y cualquiera puede leer";
$lang_groupwrite_worldread_ad_nod = "El grupo seleccionado leer/escribir/descargar (NO BORRAR) y cualquiera puede leer";
$lang_ggroupwrite_worldread_ad = "El grupo seleccionado puede subir y borrar archivos de esta carpeta y cualquiera puede ver su contenido";
$lang_ggroupwrite_worldread_ad_nod = "El grupo seleccionado puede subir y borrar archivos de esta carpeta y cualquiera puede ver su contenido, NO BORRAR";
// END BUG FIX: #449394 add document policy bugs for admin
$lang_geveryoneread = "Cualquier usuario puede leer esta carpeta";
$lang_geveryonewrite = "Cualquiera puede subir archivos y borrar esta carpeta";
$lang_geveryonewrite_nod= "Cualquiera puede subir archivos a esta carpeta";
$lang_ggroupread = "Tu grupo puede leer esta carpeta";
$lang_ggroupwrite = "Tu grupo puede subir archivos y borrar esta carpeta";
$lang_ggroupwrite_nod = "RESTRINGIDA. (S�lo tu grupo puede hacer uso de esta carpeta)";
$lang_gonlyyou = "PRIVADA. (Solo t� puedes hacer uso de esta carpeta)";
$lang_geveryoneread_ad = "Cualquier usuario puede leer esta carpeta";
$lang_geveryonewrite_ad = "P�BLICA. (cualquier usuario puede hacer uso de esta carpeta)";
$lang_geveryonewrite_ad_nod = "Cualquiera puede subir archivos a esta carpeta";
$lang_ggroupread_ad = "El grupo seleccionado puede leer esta carpeta";
$lang_ggroupwrite_ad = "El grupo seleccionado puede subir archivos y borrar esta carpeta";
$lang_ggroupwrite_ad_nod= "RESTRINGIDA. (S�lo el grupo seleccionado puede hacer uso de esta carpeta)";
$lang_gonlyyou_ad = "PRIVADA. (Solo t� puedes hacer uso de esta carpeta)";
$lang_nofolderaccess = "Atenci�n. No tienes acceso a esta carpeta";
$lang_nofileaccess = "Atenci�n. No tienes acceso a este archivo";
$lang_nofilemod = "Atenci�n. No tienes permisos para modificar este archivo";
$lang_nofiledelete = "Atenci�n. No tienes permisos para borrar este archivo";
$lang_noupload = "Atenci�n. No tienes permisos para subir archivos a esta carpeta";
$lang_nosubfolder = "Atenci�n. No tienes permisos para crear subcarpetas aqu�";
$lang_nofoldermod = "Atenci�n. No tienes permisos para modificar esta carpeta";
$lang_nofolderdelete = "Atenci�n. No tienes permisos para borrar esta carpeta";
$lang_noemail = "Atenci�n. No tienes permisos para enviar por correo este archivo";
$lang_fileexists = "El archivo que intentas subir ya existe";
$lang_specifyname = "Por favor vuelve a la p�gina anterior y especifica el nombre";
$lang_newuser = "Nuevo Usuario";
$lang_newgroup = "Nuevo Grupo";
$lang_users = "Usuarios";
$lang_groups = "Grupos";
$lang_return = "Regresar a explorar archivos";
$lang_group = "Grupo Primario";
$lang_groupmember = "Grupo(s) secundario(s)";
$lang_username = "Clave";
$lang_password = "Contrase�a";
$lang_newpassword = "Nueva Contrase�a";
$lang_oldpassword = "Contrase�a Actual";
$lang_confpassword = "Confirmar la Nueva Contrase�a";
$lang_email = "Correo Electr�nico";
$lang_emailing = "Enviando por correo";
$lang_email_to = "Correo para (To):";
$lang_email_reply_to = "Respuesta a (Reply To):";
$lang_email_subject = "Asunto (Subject)";
$lang_email_body = "Mensaje";
$lang_notification = "Recibir Notificaciones";
$lang_change = "Actualizar";
$lang_deleteuser = "Borrar Usuario";
$lang_deletegroup = "Borrar Grupo";
$lang_saved = "Actualizaci�n Realizada";
$lang_add = "Agregar";
$lang_quota = "Cuota (bytes)";
$lang_disableuser = "Deshabilitar Usuario";
// Bozz Change Begin
$lang_email_alt = "Enviar este Archivo por Correo";
$lang_del_folder_alt = "Borrar Carpeta (S/N)";
$lang_mod_folder_alt = "Modificaci�n de las propiedades de la Carpeta";
$lang_move_folder_alt = "Mover el Carpeta";
$lang_del_file_alt = "Borrar Archivo (S/N)";
$lang_mod_file_alt = "Modificar las Propiedades del Archivo";
$lang_move_file_alt = "Mover el Archivo";
$lang_upd_file_alt = "Actualizar el Archivo";
$lang_get_file_alt = "Descargar el Archivo";
$lang_view_file_alt = "Ver el Archivo";
// Bozz Change End
// begin Daphne change
$lang_log_file = "Bit�cora de Actualizaciones del Archivo";
$lang_lock_file = "Bloquear/Desbloquear el Archivo";
// end Daphne Change
$lang_notif_subject_new = "Un documento ha sido agregado al Archivo Electr�nico de la Intranet";
$lang_notif_subject_upd = "Un documento del Archivo Electr�nico de la Intranet fue actualizado";
$lang_notif_msg = "ESTE ES UN MENSAJE AUTOMATICO GENERADO DESDE EL ARCHIVO ELECTRONICO DE LA INTRANET\n\nHaz Click en la liga de abajo para ver el archivo nuevo/actualizado.\n\n";
// Diego Bugfix
$lang_admin = "Administrador";
$lang_user = "Usuario";
$lang_search = "Buscar";
$lang_search_results_for = "Buscar en los resultados por";
$lang_score = "Raiting";
$lang_ownergroup = "Due�o (Grupo)";
$lang_name = "Nombre";
//Diego Bugfix end
$lang_query_empty = "Vac�ar la cadena de b�squeda";
// Error Message Section //
$lang_err_file_update = "Para actualizar el archivo se requiere que se mantenga el mismo nombre, por favor intente nuevamente usando el mismo nombre de archivo";
$lang_err_quota = "T� no tienes suficente espacio en disco asigandao para subir este archivo: ";
$lang_err_quota_needed = " necesario ";
$lang_err_quota_avail = " disponible.";
$lang_err_quota_exceed = "Tu has excedido tu cuota";
$lang_err_upload = "Error al subir el archivo";
$lang_err_folder_exist = "Esta carpeta ya existe";
$lang_err_folder_create = "Error al crear la carpeta";
//Begin Daphne Change - backup folder and file creation errors
$lang_err_backup_folder_create = "Error al crear la carpeta de respaldo";
$lang_err_backup_file = "Error al respaldar el archivo ya existente";
$lang_err_file_lock = "En este moemento t� no puedes checar este archivo, El archivo se encuentra bloqueado por";
// end Daphne change
$lang_err_unauthorized = "Acceso no autorizado";
$lang_err_unauth_area = "T� no estas autorizado para usar esta �rea";
$lang_err_pass_wrong = "La contrase�a anterior es incorrecta";
$lang_err_pass_missmatch= "La contrase�a nueva y su confirmaci�n no coinciden";
$lang_err_user_exists = "El usuario ya existe";
$lang_err_general = "Un error ha ocurrido";
$lang_err_lang_1 = "El idioma ha sido especificado, pero ";
$lang_err_lang_2 = " este no ha sido encontrado";
$lang_err_sess_write = "Error al escribir la informaci�n de la sesi�n en la base de datos";
$lang_err_sess_notvalid = "Identificador de sesi�n no valido";
$lang_err_bad_version_1 = "Owl Intranet requiere como m�nimo la versi�n PHP";
$lang_err_bad_version_2 = "T� estas corriendo la Versi�n";
$lang_err_bad_version_3 = "Instala una nueva versi�n e intentalo nuevamente";
$lang_err_folderexists = "El renombramiento fue cancelado. Una carpeta con el mismo nombre ya existe.";
$lang_err_movecancel = "El movimiento fue cancelado";
$lang_err_email = "El mensaje no pudo enviarse";
$lang_err_fileexists = "El movimiento fue cancelado Un Archivo con el mismo nombre ya existe.";
//janu's change BEGIN
$lang_engine = "";
$lang_version = "Versi�n";
$lang_username = "Clave de usuario";
$lang_password = "Contrase�a";
$lang_owl_admin = "Administraci�n del Sistema de Control de Gesti�n";
$lang_upg_MD5 = "Encriptar passwords (MD5)";
//janu's change END


//ccedillo: INICIO DE ETIQUETAS AGREGADAS
$lang_notes_date	= "Fecha";
$lang_notes_user	= "Usuario";
$lang_notes_note	= "Comentario";
$lang_notes_actions	= "Acciones";
$lang_notes_adding	= "Agregar";
$lang_notes_editing	= "Modificar";
$lang_notes_deleting	= "Eliminar";
$lang_preferences	= "Preferencias";
//ccedillo: FIN DE ETIQUETAS AGREGADAS



?>
