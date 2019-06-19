<?php
if ($variable) {
	switch ($variable) {
		case "cambiaPrivilegios":
			include "consola_privilegios.php";
		break;
		case "cambiaPassword":
			include "cambia_password.php";
		break;
		case "cambiaUsuario":
			include "cambiaUsuario.php";
		break;
	}
} else {
	include "admon_usuarios.php";
}
?>