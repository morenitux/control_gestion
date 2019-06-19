<?php
/*
ULTIMA MODIFICACION: ccedillo
09-01-2003 10:20hrs
se modificaron distancias para imprimir de manera horizontal
así como los anchos de los boxes.
*/

require("./config/scg.php");
require("./config/html.php");
require("./includes/scg.lib.php");
require("./includes/readhd.php");
include("./includes/funciones_fechas.inc");
/*echo "prueba= $prueba <br>";
echo "tipo reporte= $tipo_reporte <br>";
echo "fechas      = $fechas <br>";
echo "fecha1      = $fecha1 <br>";
echo "fecha2      = $fecha2 <br>";
echo "fecha2      = $fecha2 <br>";
echo "grueso	  = $grueso <br>";
echo "clasif	  = $clasif <br>";
echo "nacional	  = $nacional <br>";
echo "confi	  = $confi firmantedocs<br>";
echo "salida	  = $salida <br>";
echo "folio minimo= $apartir <br>";*/

$sql = new scg_DB;
$sql->query("select usuarios.usuario from usuarios,sesion_activa where usuarios.usuario=sesion_activa.usuario and sess_id='$sess'");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$id_usuario = $sql->f("usuario");
	}
}
$sql = new scg_DB;
$sql->query("select * from tbl_mensaje");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$licencia 	= $sql->f("licencia");
		$headvol1 	= $sql->f("headvol1");
		$headvol2 	= $sql->f("headvol2");
		$headvol3 	= $sql->f("headvol3");
		$bmprep 	= $sql->f("bmprep");
	}
}
$fecha_now		= date("d/m/Y");
$mes_now  		= date("m");
$anio_now 		= date("Y");
$inicio_semana= inicio_semana($fecha_now);
$fin_semana		= fin_semana($fecha_now);
 switch ($tipo_reporte) {
	case "1": //Documentos recibidos
		$titulo_reporte="Reporte de recepción";

		$query="select fol_orig,cve_docto,to_char(fec_regi,'dd/mm/yyyy') as fec_regi,to_char(fec_recep,'dd/mm/yyyy') as fec_recep,to_char(fec_elab,'dd/mm/yyyy') as fec_elab,firmante,txt_resum,cve_remite,nom_suje from documento where fol_orig!='' and salida!='1' and ";
		switch ($fechas) {
			case "1": //Hoy
				$subtitulo_reporte="del día $fecha_now";
				$query.="fec_regi=to_date('$fecha_now','dd/mm/yyyy')";
			break;
			case "2": //Esta semana
				$subtitulo_reporte="del $inicio_semana a $fin_semana";
				$query.="fec_regi between to_date('$inicio_semana','dd/mm/yyyy') and to_date('$fin_semana','dd/mm/yyyy')";
			break;
			case "3": //Este mes
				$subtitulo_reporte="del mes $mes_now de $anio_now";
				$query.="date_part('year',fec_regi)='".$anio_now."'::float8 and date_part('month',documento.fec_regi)='".$mes_now."'";
			break;
			case "4": //Periodo determinado
				$subtitulo_reporte="del $fecha1 a $fecha2";
				$query.="fec_regi between to_date('$fecha1','dd/mm/yyyy') and to_date('$fecha2','dd/mm/yyyy')";
			break;
		}
		if ($apartir!='') {
			$query.=" and fol_orig>='$apartir'";
		}
		$query.=" order by fec_regi,fol_orig";
	break;
	case "2": //Documentos turnados
		$titulo_reporte="Control de entrega";
		$query="select documento.fol_orig,documento.cve_docto,to_char(documento.fec_regi,'dd/mm/yyyy') as fec_regi,to_char(documento.fec_recep,'dd/mm/yyyy') as fec_recep,to_char(documento.fec_elab,'dd/mm/yyyy') as fec_elab,documento.firmante,coment as txt_resum,docsal.cve_depe,documento.cve_remite,docsal.cve_ins,documento.nom_suje from documento,docsal where documento.fol_orig!='' and documento.fol_orig=docsal.fol_orig and docsal.cve_depe!='' and docsal.cve_depe!=0 and documento.salida!='1' and ";
		switch ($fechas) {
			case "1": //Hoy
				$subtitulo_reporte="del día $fecha_now";
				$query.="docsal.fec_salid=to_date('$fecha_now','dd/mm/yyyy')";
			break;
			case "2": //Esta semana
				$subtitulo_reporte="del $inicio_semana a $fin_semana";
				$query.="docsal.fec_salid between to_date('$inicio_semana','dd/mm/yyyy') and to_date('$fin_semana','dd/mm/yyyy')";
			break;
			case "3": //Este mes
				$subtitulo_reporte="del mes $mes_now de $anio_now";
				$query.="date_part('year',docsal.fec_salid)='".$anio_now."'::float8 and date_part('month',docsal.fec_salid)='".$mes_now."'";
			break;
			case "4": //Periodo determinado
				$subtitulo_reporte="del $fecha1 a $fecha2";
				$query.="docsal.fec_salid between to_date('$fecha1','dd/mm/yyyy') and to_date('$fecha2','dd/mm/yyyy')";
			break;
		}
		if ($apartir!='') {
			$query.=" and documento.fol_orig>='$apartir'";
		}
		$query.=" order by cve_depe,fec_regi,fol_orig";
	break;
	case "3": //Copias
		include ("genera_copias.php");
	break;
	case "4": //Salidas
		$titulo_reporte="Relación de salidas";
		$query="select fol_orig,cve_docto,to_char(fec_regi,'dd/mm/yyyy') as fec_regi,to_char(fec_recep,'dd/mm/yyyy') as fec_recep,to_char(fec_elab,'dd/mm/yyyy') as fec_elab,firmante,txt_resum,cve_remite,cve_dirigido,documento.nom_suje from documento where fol_orig!='' and salida='1' and ";
		switch ($fechas) {
			case "1": //Hoy
				$subtitulo_reporte="del día $fecha_now";
				$query.="fec_regi=to_date('$fecha_now','dd/mm/yyyy')";
			break;
			case "2": //Esta semana
				$subtitulo_reporte="del $inicio_semana a $fin_semana";
				$query.="fec_regi between to_date('$inicio_semana','dd/mm/yyyy') and to_date('$fin_semana','dd/mm/yyyy')";
			break;
			case "3": //Este mes
				$subtitulo_reporte="del mes $mes_now de $anio_now";
				$query.="date_part('year',fec_regi)='".$anio_now."'::float8 and date_part('month',documento.fec_regi)='".$mes_now."'";
			break;
			case "4": //Periodo determinado
				$subtitulo_reporte="del $fecha1 a $fecha2";
				$query.="fec_regi between to_date('$fecha1','dd/mm/yyyy') and to_date('$fecha2','dd/mm/yyyy')";
			break;
		}
		if ($apartir!='') {
			$query.=" and fol_orig>='$apartir'";
		}
		$query.=" order by fec_regi,fol_orig";
	break;
}

//if ($tipo_reporte=="2") {
//	include("genera_copias.php");
//}
$sql = new scg_DB;
$sql->query($query);
$numero_renglones = $sql->num_rows($sql);

if ($numero_renglones>0 && $tipo_reporte!=3) {
	// FPDF path
	define('FPDF_FONTPATH','includes/fonts/');
	require('includes/fpdf.php');
	$pdf=new FPDF();
	$pdf->Open();
	$pdf->SetAutoPageBreak(0);
	$renglon=0;
	$registros=1;
	while($sql->next_record()) {
		$instruccion	= "";
		$fol_orig 	= "";
		$fec_regi 	= "";
		$cve_docto 	= "";
		$fec_elab 	= "";
		$firmante 	= "";
		$txt_resum 	= "";
		$cve_remite	= "";
		$nom_suje	= "";
		$fol_orig 	= $sql->f("fol_orig");
		$fec_regi 	= $sql->f("fec_regi");
		$cve_docto 	= $sql->f("cve_docto");
		$fec_elab 	= $sql->f("fec_elab");
		$firmante 	= $sql->f("firmante");
		$txt_resum 	= $sql->f("txt_resum");
		$cve_remite	= $sql->f("cve_remite");
		$nom_suje	= $sql->f("nom_suje");
		if ($tipo_reporte==2) {
			$nuevo_cve_depe 	= $sql->f("cve_depe");
			if ($cve_control!=$nuevo_cve_depe) {
				$cve_control=$nuevo_cve_depe;
				$sql2 = new scg_DB;
				$sql2->query("select siglas,nom_depe from dependencia where cve_depe='$cve_control'");
				while($sql2->next_record()) {
					$siglas 	= $sql2->f("siglas");
					$nom_depe	= $sql2->f("nom_depe");
				}
				$pdf->Text($x+90,$y+185,"Total: ".($registros-1)." original(es)");
				$registros=1;
				$renglon=0;
			}
		}
		if ($tipo_reporte==4) {
			$cve_dirigido 	= $sql->f("cve_dirigido");
			$sql2 = new scg_DB;
			$sql2->query("select nombre,cargo from dirigido where clave='$cve_dirigido'");
			while($sql2->next_record()) {
				$nombre	= $sql2->f("nombre");
				$cargo 	= $sql2->f("cargo");
			}
			if ($nombre!='') {
				$quien_manda=$nombre;
				if ($cargo!='') {
					$quien_manda.=", ".$cargo;
				}
			} else {
				$quien_manda='-';
			}
		}
		//INICIO Renglón nuevo
		$ver_tope=$pdf->GetY();
		if ($ver_tope>180) { // tamaño carta vertical es 250, horizontal es 180
			$renglon=0;
		}
		$incremento=$renglon*5;
		if ($renglon==0) {
			//INICIO de Encabezado
			$pdf->AddPage();
			$x=0;
			$y=0;
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(0,0);
			$pdf->SetTextColor(0,0,0);
			$pdf->Text($x+2,$y+4,$licencia);
			$pdf->Text($x+70,$y+4,$lang_app_name);
			if ($tipo_reporte==2) {
				$pdf->Text($x+145,$y+4,"Area destinataria:");
			}
			$pdf->SetFont('Arial','',8);
			$pdf->SetTextColor(0,0,0);
			$pdf->Text($x+2,$y+7,$headvol1);
			$pdf->Text($x+80,$y+7,$titulo_reporte);
			if ($tipo_reporte==2 && $nom_depe!="") {
				$pdf->Text($x+145,$y+7,$nom_depe);
			}
			$pdf->SetFont('Arial','B',8);
			$pdf->SetTextColor(0,0,0);
			$pdf->Text($x+2,$y+10,$headvol2);
			$pdf->Text($x+80,$y+10,$subtitulo_reporte);
			if ($tipo_reporte==2 && $siglas!="") {
				$pdf->Text($x+145,$y+10,$siglas);
			}
			$pdf->SetFont('Arial','',8); //6
			$pdf->Text($x+2,$y+13,$headvol3);
			$num_pag=$pdf->PageNo();
			$num_pag="Página: $num_pag";
			$pdf->Text($x+80,$y+13,$num_pag);
			$pdf->SetFont('Arial','B',8); //6
			$pdf->Text($x+2,$y+20,"FOLIO");

			//$pdf->Text($x+13,$y+20,"F.REGISTRO");

			$pdf->Text($x+20,$y+20,"REFERENCIA");
			if ($tipo_reporte==4) { $tit1="FIRMADO POR"; } else { $tit1="PROCEDENCIA"; }
			$pdf->Text($x+54,$y+20,$tit1);
			if ($tipo_reporte==4) { $tit2="DIRIGIDO A"; } else { $tit2="FIRMADO POR"; }
			$pdf->Text($x+94,$y+20,$tit2);
            $pdf->Text($x+135,$y+20,"ASUNTO"); //125
			$pdf->Line($x+2,$y+21,$x+256,$y+21); //206
			//FIN de Encabezado
		} else {
			$pdf->Line($x+2,$y+$incremento+20,$x+256,$y+$incremento+20); //206
		}
		$pdf->SetFont('Arial','',8); //6
		$pdf->Text($x+2, $y+$incremento+24,"$fol_orig");

		//$pdf->Text($x+13,$y+$incremento+24,"$fec_regi");

		$pdf->Text($x+20,$y+$incremento+24,"$cve_docto");

		if ($cve_remite!='' && $cve_remite!='0' && $tipo_reporte!=4) {
		   $sql2 = new scg_DB;
		   $sql2->query("select nom_prom from promotor where cve_prom='$cve_remite'");
		   while($sql2->next_record()) {
				 $nom_remite  = $sql2->f("nom_prom");
		   }
		} else {
			if ($tipo_reporte==4 && $cve_remite!='' && $cve_remite!='0') {
			   $sql2 = new scg_DB;
			   $sql2->query("select nom_prom from promotor where cve_prom='$cve_remite'");
			   while($sql2->next_record()) {
			   		$nom_remite  = $sql2->f("nom_prom");
			   }
			   if ($nom_remite!='') {
				   $firmante.=", ".$nom_remite;
			   }
			   $nom_remite=$quien_manda;
			} else {
				if ($nom_suje!='') {
					$nom_remite=$nom_suje;
				} else {
					$nom_remite='-';
				}
			}
		}
		//INICIO cálculo de renglones adicionales por texto expandido

		if ($instruccion!="") {
			$txt_resum=$instruccion." - ".$txt_resum;
		}
		$largo_remite	=$pdf->GetStringWidth($nom_remite);
		$largo_firmante	=$pdf->GetStringWidth($firmante);
		$largo_asunto	=$pdf->GetStringWidth($txt_resum);
		$ancho_remite	= 40;
		$ancho_firmante	= 40;
		$ancho_asunto	= 70;
		$a1	= $largo_firmante/($ancho_firmante*.9);
		$b1	= $largo_asunto/($ancho_asunto*.9);
		$c1	= $largo_remite/($ancho_remite*.9);
		$a2	= intval($largo_firmante/($ancho_firmante*.9));
		$b2	= intval($largo_asunto/($ancho_asunto*.9));
		$c2	= intval($largo_remite/($ancho_remite*.9));


		if ($a1>$a2) {
			$num_renglones_firmante=$a2+1;
		} else {
			$num_renglones_firmante=$a2;
		}
		if ($b1>$b2) {
			$num_renglones_asunto=$b2+1;
		} else {
			$num_renglones_asunto=$b2;
		}
		if ($c1>$c2) {
			$num_renglones_remite=$c2+1;
		} else {
			$num_renglones_remite=$c2;
		}
		$el_mayor=$num_renglones_asunto;
		if ($num_renglones_firmante>$num_renglones_asunto) {
			$el_mayor=$num_renglones_firmante;
		}
		if ($num_renglones_remite>$el_mayor) {
			$el_mayor=$num_renglones_remite;
		}
		//FIN cálculo de renglones adicionales por texto expandido

		$pdf->SetXY($x+54,$y+$incremento+22);
		$pdf->MultiCell($ancho_firmante,2, "$nom_remite",0,"L");

		$pdf->SetXY($x+94,$y+$incremento+22);
		$pdf->MultiCell($ancho_firmante,2, "$firmante",0,"L");
		$pdf->SetXY($x+135,$y+$incremento+22); //125
		$pdf->MultiCell($ancho_asunto,2, "$txt_resum",0,"L");
		//FIN Renglón nuevo

		for ($contador=0; $contador<$el_mayor; $contador++) {
			$renglon++;
		}
		$registros++;
	}
	$pdf->Text($x+90,$y+185,"Total: ".($registros-1)." original(es)");
	$pdf->Output();
}
?>