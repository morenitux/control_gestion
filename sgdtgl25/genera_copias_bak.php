<?php
$titulo_reporte="Reporte de copias";
$query="select documento.fol_orig,nom_ccp,to_char(documento.fec_regi,'dd/mm/yyyy') as fec_regi,to_char(documento.fec_elab,'dd/mm/yyyy') as fec_elab,documento.cve_docto,documento.firmante,documento.cve_remite,docsal.coment as txt_resum from documento,docsal,salccp where documento.fol_orig!='' and documento.fol_orig=docsal.fol_orig and docsal.fol_orig=salccp.fol_orig and docsal.conse=salccp.conse and ";
switch ($fechas) {
	case "1": //Hoy
		$subtitulo_reporte="(Del día $fecha_now)";
		$query.="docsal.fec_salid=to_date('$fecha_now','dd/mm/yyyy')";
	break;
	case "2": //Esta semana
		$subtitulo_reporte="(Del $inicio_semana a $fin_semana)";
		$query.="docsal.fec_salid between to_date('$inicio_semana','dd/mm/yyyy') and to_date('$fin_semana','dd/mm/yyyy')";
	break;
	case "3": //Este mes
		$subtitulo_reporte="(Del mes $mes_now de $anio_now)";
		$query.="date_part('year',docsal.fec_salid)='".$anio_now."'::float8 and date_part('month',docsal.fec_salid)='".$mes_now."'";
	break;
	case "4": //Periodo determinado
		$subtitulo_reporte="(Del $fecha1 a $fecha2)";
		$query.="docsal.fec_salid between to_date('$fecha1','dd/mm/yyyy') and to_date('$fecha2','dd/mm/yyyy')";
	break;
}
if ($apartir!='') {
	$query.=" and documento.fol_orig>='$apartir'";
}
$contador_global=0;
$query.=" order by fol_orig";
$sql->query($query);
$numero_renglones = $sql->num_rows($sql);
while($sql->next_record()) {
	$fol_orig 	= $sql->f("fol_orig");
	$nom_ccp	= $sql->f("nom_ccp");
	$fec_regi	= $sql->f("fec_regi");
	$fec_elab	= $sql->f("fec_elab");
	$cve_docto	= $sql->f("cve_docto");
	$firmante	= $sql->f("firmante");
	$cve_remite	= $sql->f("cve_remite");
	$txt_resum	= $sql->f("txt_resum");

	//primero le quito los corchetes del inicio y del final
	$nom_ccp=substr($nom_ccp,0,(strlen($nom_ccp)-1));
	$nom_ccp=substr($nom_ccp,1,(strlen($nom_ccp)-1));
	//separo en cachos la cadena
	$arreglo_copias=explode("][",$nom_ccp);
	$num_cachos=count($arreglo_copias);
	$controlador=0;
	for ($y=0; $y<$num_cachos; $y++) {
		if (substr($arreglo_copias[$y],0,3)=='999') {
			$y=y+2;
		} else {
			//cuento los cachos impares, que son los que contienen la clave de la dependencia
			$a1	= $y/2;
			$a2	= intval($y/2);
			if ($a1>$a2) {
				//meto en el arreglo copia las claves de la dependencia
			
				$copia[$controlador]=$arreglo_copias[$y];
				$controlador++;
			}
		}
	}
	$total_de_copias=count($copia);
	$y=0;
	while ($y<$total_de_copias) {
		$campo[1][$contador_global]=$fol_orig;
		$campo[2][$contador_global]=$copia[$y];
		$campo[3][$contador_global]="$copia[$y]"."$fol_orig";
		$campo[4][$contador_global]=$fec_regi;
		$campo[5][$contador_global]=$fec_elab;
		$campo[6][$contador_global]=$cve_docto;
		$campo[7][$contador_global]=$firmante;
		$campo[8][$contador_global]=$cve_remite;
		$campo[9][$contador_global]=$txt_resum;
		$y++;
		$contador_global++;
	}
}
$total_global=count($campo[1]);
for ($i=0; $i<($total_global-1); $i++) {
	for ($j=0; $j<($total_global-1); $j++) {
		$primero=$campo[3][$j];
		$segundo=$campo[3][$j+1];
		if ($primero>$segundo) {
			$aux1 =  $campo[1][$j];
			$aux2 =  $campo[2][$j];
			$aux3 =  $campo[3][$j];
			$aux4 =  $campo[4][$j];
			$aux5 =  $campo[5][$j];
			$aux6 =  $campo[6][$j];
			$aux7 =  $campo[7][$j];
			$aux8 =  $campo[8][$j];
			$aux9 =  $campo[9][$j];
			$campo[1][$j] = $campo[1][$j+1];
			$campo[2][$j] = $campo[2][$j+1];
			$campo[3][$j] = $campo[3][$j+1];
			$campo[4][$j] = $campo[4][$j+1];
			$campo[5][$j] = $campo[5][$j+1];
			$campo[6][$j] = $campo[6][$j+1];
			$campo[7][$j] = $campo[7][$j+1];
			$campo[8][$j] = $campo[8][$j+1];
			$campo[9][$j] = $campo[9][$j+1];
			$campo[1][$j+1] = $aux1;
			$campo[2][$j+1] = $aux2;
			$campo[3][$j+1] = $aux3;
			$campo[4][$j+1] = $aux4;
			$campo[5][$j+1] = $aux5;
			$campo[6][$j+1] = $aux6;
			$campo[7][$j+1] = $aux7;
			$campo[8][$j+1] = $aux8;
			$campo[9][$j+1] = $aux9;
		}
	}
}
if ($total_global>0) {
	// FPDF path
	define('FPDF_FONTPATH','includes/fonts/');
	require('includes/fpdf.php');
	$pdf=new FPDF();
	$pdf->Open();
	$pdf->SetAutoPageBreak(0);
	$renglon=0;





for ($i=0; $i<$total_global; $i++) {
	//echo "INICIO: ".$campo[2][$i]." - ".$campo[1][$i]." - ".$campo[4][$i]."-".$campo[5][$i]."-".$campo[6][$i]."-".$campo[7][$i]."-".$campo[8][$i]."-".$campo[9][$i]."<br>";

$fol_orig       = $campo[1][$i];
$fec_regi       = $campo[4][$i]; 
$cve_docto      = $campo[6][$i];
$fec_elab       = $campo[5][$i];
$firmante       = $campo[7][$i];
$txt_resum      = $campo[9][$i];
$cve_remite     = $campo[8][$i];
$nuevo_cve_depe = $campo[2][$i];
if ($cve_control!=$nuevo_cve_depe) {
$cve_control=$nuevo_cve_depe;
$sql2 = new scg_DB;
$sql2->query("select siglas,nom_depe from dependencia where cve_depe='$cve_control'");
while($sql2->next_record()) {
$siglas         = $sql2->f("siglas");
$nom_depe       = $sql2->f("nom_depe");
}
$renglon=0;
}
//INICIO Renglón nuevo
$ver_tope=$pdf->GetY();
if ($ver_tope>250) {
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
$pdf->Text($x+80,$y+4,$lang_app_name);
//if ($tipo_reporte==2) {
$pdf->Text($x+130,$y+4,"Area receptora:");
//}
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);
$pdf->Text($x+2,$y+7,$headvol1);
$pdf->Text($x+80,$y+7,$titulo_reporte);
//if ($tipo_reporte==2 && $nom_depe!="") {
$pdf->Text($x+130,$y+7,$nom_depe);
//}
$pdf->SetFont('Arial','B',6);
$pdf->SetTextColor(0,0,0);
$pdf->Text($x+2,$y+10,$headvol2);
$pdf->Text($x+80,$y+10,$subtitulo_reporte);
//if ($tipo_reporte==2 && $siglas!="") {
$pdf->Text($x+130,$y+10,$siglas);
//}
$pdf->SetFont('Arial','',6);
$pdf->Text($x+2,$y+13,$headvol3);
$num_pag=$pdf->PageNo();
$num_pag="Página: $num_pag";
$pdf->Text($x+80,$y+13,$num_pag);
$pdf->SetFont('Arial','B',6);
$pdf->Text($x+2,$y+20,"FOLIO");
$pdf->Text($x+17,$y+20,"F.REGISTRO");
$pdf->Text($x+32,$y+20,"REFERENCIA");
//$pdf->Text($x+59,$y+20,"F.ELABORACION");
//$pdf->Text($x+90,$y+20,"PROCEDENCIA");
$pdf->Text($x+59,$y+20,"PROCEDENCIA");
$pdf->Text($x+90,$y+20,"FIRMANTE");
$pdf->Text($x+125,$y+20,"ASUNTO");
$pdf->Line($x+2,$y+21,$x+206,$y+21);
//FIN de Encabezado
} else {
$pdf->Line($x+2,$y+$incremento+20,$x+206,$y+$incremento+20);
}
$pdf->SetFont('Arial','',6);
$pdf->Text($x+2, $y+$incremento+24,"$fol_orig");
$pdf->Text($x+17,$y+$incremento+24,"$fec_regi");
$pdf->Text($x+32,$y+$incremento+24,"$cve_docto");
if ($cve_remite!='') {
$sql2 = new scg_DB;
$sql2->query("select nom_prom from promotor where cve_prom='$cve_remite'");
while($sql2->next_record()) {
$nom_remite  = $sql2->f("nom_prom");
}
} else {
$nom_remite='-';
}
//INICIO cálculo de renglones adicionales por texto expandido

if ($instruccion!="") {
$txt_resum=$instruccion." - ".$txt_resum;
}
$largo_remite   =$pdf->GetStringWidth($nom_remite);
$largo_firmante =$pdf->GetStringWidth($firmante);
$largo_asunto   =$pdf->GetStringWidth($txt_resum);
$ancho_remite   = 30;
$ancho_firmante = 30;
$ancho_asunto   = 60;
$a1     = $largo_firmante/($ancho_firmante*.9);
$b1     = $largo_asunto/($ancho_asunto*.9);
$c1     = $largo_remite/($ancho_remite*.9);
$a2     = intval($largo_firmante/($ancho_firmante*.9));
$b2     = intval($largo_asunto/($ancho_asunto*.9));
$c2     = intval($largo_remite/($ancho_remite*.9));


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

$pdf->SetXY($x+59,$y+$incremento+22);
$pdf->MultiCell($ancho_firmante,2, "$nom_remite",0,"L");

$pdf->SetXY($x+90,$y+$incremento+22);
$pdf->MultiCell($ancho_firmante,2, "$firmante",0,"L");
$pdf->SetXY($x+125,$y+$incremento+22);
$pdf->MultiCell($ancho_asunto,2, "$txt_resum",0,"L");
//FIN Renglón nuevo

for ($contador=0; $contador<$el_mayor; $contador++) {
$renglon++;
}

}
$pdf->Output();
}
?>
