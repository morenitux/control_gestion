<?php
function dia_habil_posterior($fecha_inicial,$duracion) {
	$dia	=	substr($fecha_inicial,0,2);
	$mes	=	substr($fecha_inicial,3,2);
	$anio	=	substr($fecha_inicial,6,4);
	$mientras=date("d/m/Y",mktime(0,0,0,$mes,$dia,$anio));
	$n=1;
	while ($n<$duracion) {
		$dia=substr($mientras,0,2);
		$mes=substr($mientras,3,2);
		$anio=substr($mientras,6,4);
		$mientras=date("d/m/Y", mktime(0,0,0,$mes,$dia+1,$anio));
		$dia=substr($mientras,0,2);
		$mes=substr($mientras,3,2);
		$anio=substr($mientras,6,4);
		$diadelasemana=date("w",mktime(0,0,0,$mes,$dia,$anio));
		if ($diadelasemana==6) {
			$mientras=date("d/m/Y", mktime(0,0,0,$mes,$dia+2,$anio));
		}
		if ($diadelasemana==0) {
			$mientras=date("d/m/Y", mktime(0,0,0,$mes,$dia+1,$anio));
		}
		$dia=substr($mientras,0,2);
		$mes=substr($mientras,3,2);
		$anio=substr($mientras,6,4);
		$diames="$dia/$mes";
		if ($diames=="01/01") {
			$mientras=date("d/m/Y", mktime(0,0,0,$mes,$dia+1,$anio));
		}
		if ($diames=="05/02") {
			$mientras=date("d/m/Y", mktime(0,0,0,$mes,$dia+1,$anio));
		}
		if ($diames=="21/03") {
			$mientras=date("d/m/Y", mktime(0,0,0,$mes,$dia+1,$anio));
		}
		if ($diames=="01/05") {
			$mientras=date("d/m/Y", mktime(0,0,0,$mes,$dia+1,$anio));
		}
		if ($diames=="05/05") {
			$mientras=date("d/m/Y", mktime(0,0,0,$mes,$dia+1,$anio));
		}
		if ($diames=="16/09") {
			$mientras=date("d/m/Y", mktime(0,0,0,$mes,$dia+1,$anio));
		}
		if ($diames=="02/11") {
			$mientras=date("d/m/Y", mktime(0,0,0,$mes,$dia+1,$anio));
		}
		if ($diames=="20/11") {
			$mientras=date("d/m/Y", mktime(0,0,0,$mes,$dia+1,$anio));
		}
		if ($diames=="25/12") {
			$mientras=date("d/m/Y", mktime(0,0,0,$mes,$dia+1,$anio));
		}
		$n++;
	}
	return $mientras;
}

function inicio_semana($fecha_inicial) {
	$dia	=	substr($fecha_inicial,0,2);
	$mes	=	substr($fecha_inicial,3,2);
	$anio	=	substr($fecha_inicial,6,4);
	$diadelasemana=date("w",mktime(0,0,0,$mes,$dia,$anio));
	switch ($diadelasemana) {
		case 1: //Lunes
			$mientras=date("d/m/Y",mktime(0,0,0,$mes,$dia,$anio));
		break;
		case 2: // Martes
			$mientras=date("d/m/Y",mktime(0,0,0,$mes,$dia-1,$anio));
		break;
		case 3: // Miercoles
			$mientras=date("d/m/Y",mktime(0,0,0,$mes,$dia-2,$anio));

		break;
		case 4: // Jueves
			$mientras=date("d/m/Y",mktime(0,0,0,$mes,$dia-3,$anio));
		break;
		case 5: // Viernes
			$mientras=date("d/m/Y",mktime(0,0,0,$mes,$dia-4,$anio));
		break;
		case 6: // Sabado
			$mientras=date("d/m/Y",mktime(0,0,0,$mes,$dia-5,$anio));
		break;
		case 0: // Domingo
			$mientras=date("d/m/Y",mktime(0,0,0,$mes,$dia-6,$anio));
		break;
	}
	return $mientras;
}

function fin_semana($fecha_inicial) {
	$dia	=	substr($fecha_inicial,0,2);
	$mes	=	substr($fecha_inicial,3,2);
	$anio	=	substr($fecha_inicial,6,4);
	$diadelasemana=date("w",mktime(0,0,0,$mes,$dia,$anio));
	switch ($diadelasemana) {
		case 1: //Lunes
			$mientras=date("d/m/Y",mktime(0,0,0,$mes,$dia+6,$anio));
		break;
		case 2: // Martes
			$mientras=date("d/m/Y",mktime(0,0,0,$mes,$dia+5,$anio));
		break;
		case 3: // Miercoles
			$mientras=date("d/m/Y",mktime(0,0,0,$mes,$dia+4,$anio));

		break;
		case 4: // Jueves
			$mientras=date("d/m/Y",mktime(0,0,0,$mes,$dia+3,$anio));
		break;
		case 5: // Viernes
			$mientras=date("d/m/Y",mktime(0,0,0,$mes,$dia+2,$anio));
		break;
		case 6: // Sabado
			$mientras=date("d/m/Y",mktime(0,0,0,$mes,$dia+1,$anio));
		break;
		case 0: // Domingo
			$mientras=date("d/m/Y",mktime(0,0,0,$mes,$dia,$anio));
		break;
	}
	return $mientras;
}
?>