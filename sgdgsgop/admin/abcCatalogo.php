<?php
require("../config/scg.php");
require("../config/html.php");
require("../includes/scg.lib.php");

print ("<body bgcolor='$default->body_bgcolor' text='$default->body_textcolor' link='$default->body_link' vlink='$default->body_vlink' onLoad='window.opener.document.plantilla_documento.ventana_auxiliar.value=\"abierta\"'>\n");
print ("<link rel='stylesheet' type='text/css' title='style1' href='$default->styles'>");

switch ($accion) {
	case "insert":
		$variable = "Alta ";
	break;
	case "update":
		$variable = "Cambio ";
	break;
	case "delete":
		$variable = "Baja ";
	break;
}
switch ($control_catalogos) {
	case "1":
	$variable.=$lang_cat_1;
		include("cambioPromotor.php");
	break;
	case "2":
		$variable.=$lang_cat_2;
		include("cambioExpediente.php");
	break;
	case "3":
		$variable.=$lang_cat_3;
		$tipo="T";
		include("cambioTema.php");
	break;
	case "4":
		$variable.=$lang_cat_4;
		$tipo="E";
		include("cambioTema.php");
	break;
	case "5":
		$variable.=$lang_cat_5;
		include("cambioDependencia.php");
	break;
	case "6":
		$variable.=$lang_cat_6;
		include("cambioTurnador.php");
	break;
	case "7":
		$variable.=$lang_cat_7;
		$tipo="I";
		include("cambioInstruccion.php");
	break;
	case "8":
		$variable.=$lang_cat_8;
		$tipo="D";
		include("cambioInstruccion.php");
	break;
	case "9":
		$variable.=$lang_cat_9;
		include("cambioDestinatario.php");
	break;
}