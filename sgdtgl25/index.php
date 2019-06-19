<?php
/*--------------------------------------------------------------------------------------
|
|	Archivo:	index.php
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

if (checkrequirements() == 1) {
	exit;
}
if(!$login) {
	$login = 1;
}

if($loginname && $password) {
	$verified["bit"] = 0;
	$verified = verify_login($loginname, $password);
	if ($verified["bit"] == 1) {
		$session = new Scg_Session;
		$uid = $session->Open_Session(0,$verified["userid"]);
		$id = 1;

		//verificar con qué ventana inicia 0=ninguna, 1=documentos, 2=respuestas
		$sql = new scg_DB;
		$query = "select opciones from defaults_scg,sesion_activa where defaults_scg.usuario=sesion_activa.usuario and sess_id='".$uid->sessdata["sessid"]."' and modulo='GA'";
		$sql->query($query);
		$con_cual_inicio=0;
		if ($sql->num_rows($sql) > 0) {
			while($sql->next_record()) {
				$con_cual_inicio = $sql->f("0");

			}
		}
		header("Location: principal.php?sess=".$uid->sessdata["sessid"]."&control_botones_superior=$con_cual_inicio");
		//$sql->disconnect($sql->Link_ID);
	} else {
		if ($verified["bit"] == 2) {
			header("Location: index.php?login=1&failure=2");
		} else {
			if ($verified["bit"] == 3) {
				header("Location: index.php?login=1&failure=3");
			} else {
				header("Location: index.php?login=1&failure=1");
			}
		}
	}
}

if(($login == 1) || ($failure == 1)) {
	$incluye_cabeza="amedias";
	include("./includes/loginheader.inc");
	?>
	<script language='JavaScript'>
	function regform_Validator(f) {
		f.loginname.value=f.loginname.value.toUpperCase();
		f.password.value=f.password.value.toUpperCase();
		if (f.loginname.value.length < 1) {
			alert("Capture la clave de usuario");
			f.loginname.focus();
			return(false);
		}
		if (f.password.value.length < 1) {
			alert("Capture la contraseña");
			f.password.focus();
			return(false);
		}
	}
	//  End -->
	</script>
	<?
	$incluye_cabeza="";
	print("<center>\n");
	print "<br><br>\n";
	if($failure == 1) print("<br>$lang_loginfail<br>\n");
	if($failure == 2) print("<br>$lang_logindisabled<br>\n");
	if($failure == 3) print("<br>$lang_sessinuse<br>\n");
	print "<form name='login_form' action='index.php' method='post' target='_self' onsubmit='return regform_Validator(this);'>\n";
	print "<table>\n<tr>\n<td>$lang_username:</td>\n<td><input type=text name=loginname size=12 maxlength=10 onBlur='this.value=this.value.toUpperCase()'><br></td>\n</tr>\n";
	print "<tr>\n<td>$lang_password:</td>\n<td><input type=password name=password size=12 maxlength=10 onBlur='this.value=this.value.toUpperCase()'><br></td>\n</tr>\n</table>\n";
	print "<input type=submit value=$lang_login>\n";
	print "<br><br></form>\n";
	include("./includes/loginfooter.inc");
	exit;
}

if($login == "logout") {
	$incluye_cabeza="amedias";
	include("./includes/loginheader.inc");
	?>
	<script language='JavaScript'>
	function regform_Validator(f) {
		f.loginname.value=f.loginname.value.toUpperCase();
		f.password.value=f.password.value.toUpperCase();
		if (f.loginname.value.length < 1) {
			alert("Capture la clave de usuario");
			f.loginname.focus();
			return(false);
		}
		if (f.password.value.length < 1) {
			alert("Capture la contraseña");
			f.password.focus();
			return(false);
		}
	}
	//  End -->
	</script>
	<?
	$incluye_cabeza="";
	print("<center>\n");
	print("<br><br>\n");
	$sql = new Scg_DB;
	$sql->query("delete from sesion_activa where sess_id = '$sess'");
	//$sql->disconnect($sql->Link_ID);
	print "<br><br>\n";
	print("<br>$lang_successlogout<br>\n");
	print "<form name='login_form' action='index.php' method='post' target='_self' onsubmit='return regform_Validator(this);'>\n";
	print "<table><tr><td>$lang_username:</td><td><input type=text name=loginname size=12 maxlength=10 onBlur='this.value=this.value.toUpperCase()'><br></td></tr>\n";
	print "<tr><td>$lang_password:</td><td><input type=password name=password size=12 maxlength=10 onBlur='this.value=this.value.toUpperCase()'><br></td></tr></table>\n";
	print "<input type=submit value=$lang_login>\n";
	print "<br><br></form>\n";
	include("./includes/loginfooter.inc");
	exit;
}
include("./includes/loginfooter.inc");
?>