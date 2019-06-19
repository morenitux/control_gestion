<?php
require("./config/owl.php");
require("./config/html.php");
require("./includes/owl.includes.php");
require("./includes/readhd.php");
require("./includes/security.includes.php");
print ("<link rel='stylesheet' type='text/css' title='style1' href='$default->styles'>");
?>
<body bgcolor="#FFFFCC" link="<?php echo (empty($ForumBodyLinkColor)) ? $default_body_link_color : $ForumBodyLinkColor; ?>" alink="<?php echo (empty($ForumBodyALinkColor)) ? $default_body_alink_color : $ForumBodyALinkColor; ?>" vlink="<?php echo (empty($ForumBodyVLinkColor)) ? $default_body_vlink_color : $ForumBodyVLinkColor; ?>">
<?
print("<a href=\"javascript:window.close();\"><img src='$default->scg_graphics_url/bullet.gif' border=0>&nbsp;Cerrar</a>");
if ($control_referencia) {
	include("locale/$default->owl_lang/referencia$control_referencia.html");
} else {
	//echo "<br>Source: <b>".$source_para."</b><br>";
	//echo "<br>Action: <b>".$action."</b><br>";
	echo "<table width=80% border=3 >";
	echo "<tr><td colspan=2><b><font class='SubTitle'>Cómo...</font></b></td></tr>";
	switch ($source_para) {
		case "browse":
			// incluye cómo navegar, cómo subir archivos, cómo crear carpetas, como descargar archivos, cómo actualizar archivos, cómo enviar por email un archivo
			echo "<tr><td width=5%>1.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=6'>Crear carpetas nuevas</a></b></td></tr>";
			echo "<tr><td width=5%>2.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=1'>Subir archivos</a></b></td></tr>";
			echo "<tr><td width=5%>3.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=3'>Descargar archivos al disco local</a></b></td></tr>";
			echo "<tr><td width=5%>4.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=2'>Actualizar un archivo que ya existe</a></b></td></tr>";
			echo "<tr><td width=5%>5.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=5'>Navegar por las carpetas / Regresar a la carpeta anterior</a></b></td></tr>";
			echo "<tr><td width=5%>6.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=4'>Registrar tus comentarios a un archivo</a></b></td></tr>";
			echo "<tr><td width=5%>7.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=7'>Echar un vistazo a los archivos de tipo imagen</a></b></td></tr>";
			echo "<tr><td width=5%>8.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=12'>Cambiar la contraseña de usuario</a></b></td></tr>";
			echo "<tr><td width=5%>9.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=12'>Activar la función para recibir mensajes automáticos</a></b></td></tr>";
		break;
		case "view":
			if ($action=="file_details" || $action=="image_preview") {
				// incluye cómo navegar, cómo subir archivos, cómo crear carpetas, como descargar archivos, cómo actualizar archivos, cómo enviar por email un archivo
				echo "<tr><td width=5%>1.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=4'>Registrar tus comentarios</a></b></td></tr>";
				echo "<tr><td width=5%>2.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=5'>Navegar por las carpetas / Regresar a la carpeta anterior</a></b></td></tr>";
			}
		break;
		case "modify":
			if ($action=="folder_create") {
				echo "<tr><td width=5%>1.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=6'>Crear carpetas nuevas</a></b></td></tr>";
				echo "<tr><td width=5%>2.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=5'>Navegar por las carpetas / Regresar a la carpeta anterior</a></b></td></tr>";
			}
			if ($action=="file_upload") {
				echo "<tr><td width=5%>1.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=1'>Subir archivos</a></b></td></tr>";
				echo "<tr><td width=5%>2.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=3'>Descargar archivos al disco local</a></b></td></tr>";
				echo "<tr><td width=5%>3.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=2'>Actualizar un archivo que ya existe</a></b></td></tr>";
				echo "<tr><td width=5%>4.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=5'>Navegar por las carpetas / Regresar a la carpeta anterior</a></b></td></tr>";
				echo "<tr><td width=5%>5.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=4'>Registrar tus comentarios a un archivo</a></b></td></tr>";
			}

			if ($action=="folder_modify") {
				echo "<tr><td width=5%>1.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=6'>Crear carpetas nuevas</a></b></td></tr>";
				echo "<tr><td width=5%>2.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=2'>Actualizar un archivo que ya existe</a></b></td></tr>";
				echo "<tr><td width=5%>3.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=5'>Navegar por las carpetas / Regresar a la carpeta anterior</a></b></td></tr>";
				echo "<tr><td width=5%>4.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=4'>Registrar tus comentarios a un archivo</a></b></td></tr>";
			}
			if ($action=="file_modify" || $action=="file_update") {
				echo "<tr><td width=5%>1.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=2'>Actualizar un archivo que ya existe</a></b></td></tr>";
				echo "<tr><td width=5%>2.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=5'>Navegar por las carpetas / Regresar a la carpeta anterior</a></b></td></tr>";
				echo "<tr><td width=5%>3.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=4'>Registrar tus comentarios a un archivo</a></b></td></tr>";
			}
			if ($action=="file_email") {
				echo "<tr><td width=5%>1.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=8'>Enviar un archivo por e-mail</a></b></td></tr>";
				echo "<tr><td width=5%>2.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=5'>Navegar por las carpetas / Regresar a la carpeta anterior</a></b></td></tr>";
				echo "<tr><td width=5%>3.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=4'>Registrar tus comentarios a un archivo</a></b></td></tr>";
			}
		break;
		case "move":
			echo "<tr><td width=5%>1.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=2'>Mover / Actualizar un archivo que ya existe</a></b></td></tr>";
			echo "<tr><td width=5%>2.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=6'>Crear carpetas nuevas</a></b></td></tr>";
			echo "<tr><td width=5%>3.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=5'>Navegar por las carpetas / Regresar a la carpeta anterior</a></b></td></tr>";
			echo "<tr><td width=5%>4.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=4'>Registrar tus comentarios a un archivo</a></b></td></tr>";
		break;
		case "admin_index":
			echo "<tr><td width=5%>1.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=9'>Crear usuarios y grupos usuarios</a></b></td></tr>";
			echo "<tr><td width=5%>2.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=10'>Eliminar usuarios, grupos de usuarios, carpetas y archivos</a></b></td></tr>";
			echo "<tr><td width=5%>3.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=11'>Controlar y modificar las cuotas de espacio de los usuarios</a></b></td></tr>";
			echo "<tr><td width=5%>4.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=6'>Crear carpetas nuevas</a></b></td></tr>";
			echo "<tr><td width=5%>5.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=1'>Subir archivos</a></b></td></tr>";
			echo "<tr><td width=5%>6.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=3'>Descargar archivos al disco local</a></b></td></tr>";
			echo "<tr><td width=5%>7.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=2'>Actualizar un archivo que ya existe</a></b></td></tr>";
			echo "<tr><td width=5%>8.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=5'>Navegar por las carpetas / Regresar a la carpeta anterior</a></b></td></tr>";
			echo "<tr><td width=5%>9.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=4'>Registrar tus comentarios a un archivo</a></b></td></tr>";
			echo "<tr><td width=5%>10.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=7'>Echar un vistazo a los archivos de tipo imagen</a></b></td></tr>";
		break;
		case "prefs":
			echo "<tr><td width=5%>1.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=5'>Navegar por las carpetas / Regresar a la carpeta anterior</a></b></td></tr>";
			echo "<tr><td width=5%>2.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=12'>Cambiar la contraseña de usuario</a></b></td></tr>";
			echo "<tr><td width=5%>3.-</td><td><b><a href='referencia.php?user=$userid&sess=$sess&source_para=$source_para&sess=$sess&action=$action&control_referencia=12'>Activar la función para recibir mensajes automáticos</a></b></td></tr>";
		break;

	}
	echo "</table>";
}
//include("./includes/footer.inc");

?>
