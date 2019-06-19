<?
//INICIALIZACION DE VARIABLES
$condicion_adicional="";
if ($ok["vista"]!="") {
	$condicion_adicional="documento.fol_orig in (select fol_orig from docsal where cve_depe='".$ok["vista"]."' group by fol_orig)";
}
$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
$anio_now  =date("Y");
$bgcolor_titulos="#003399";
$color_1="EAEAEA";
$color_2="C6FFFF";

$sql = new scg_DB;
$sql->query("select count(*) from soli_buzon where fol_orig is not null");
while($sql->next_record()) {
	$cuantos = $sql->f("0");
}
if ($cuantos>0) {
	$query="SELECT fec_salid,fol_orig,conse,to_char(fec_salid,'dd/mm/yyyy') as fec_salid2,to_char(fec_comp,'dd/mm/yyyy') as fec_comp,remite,cve_urge,sintesis,cve_docto,to_char(fec_elab,'dd/mm/yyyy') as fec_elab,base_datos,prop_base from soli_buzon where soli_buzon.fol_orig is not null ";
	if ($condicion_adicional!="") {
		$query.=" and ".$condicion_adicional;
	}
	$query.=" order by fec_salid,fol_orig,conse";
	$sql->query($query);
	$numero_renglones = $sql->num_rows($sql);
	if ($numero_renglones > 0) {
		//abre tabla
		?>
		<table width=100% border=0 cellspacing=2 cellpadding=2>
		 <tr>
		  <td width=100% align=center>
				<font class='bigsubtitle'>Buzón de solicitudes</font>
		  </td>
		 </tr>
		</table>
		<table width=100% border=0 cellspacing=2 cellpadding=2>
			<tr bgcolor='#<? echo $bgcolor_titulos; ?>'>
				<td align='center' class='chiquitoblanco'>
					No.
				</td>
				<td align='center' class='chiquitoblanco'>
					<? echo "Núm.Entrada"; ?>
				</td>
				<td align='center' class='chiquitoblanco'>
					<? echo "Referencia"; ?>
				</td>
				<td align='center' class='chiquitoblanco'>
					<? echo "Turnador/<br>Fecha de Turno"; ?>
				</td>
				<td align='center' class='chiquitoblanco'>
					<? echo "Prioridad/<br>Fecha Compromiso"; ?>
				</td>
				<td align='center' class='chiquitoblanco'>
					<? echo "Asunto"; ?>
				</td>
			</tr>
		<?
		$x=0;
		$color_renglon=$color_1;
		while($sql->next_record()) {
			$folio_en_documentos = "";
			$fec_salid		= "";
			$fol_orig		= "";
			$conse			= "";
			$fec_salid2		= "";
			$fec_comp		= "";
			$remite			= "";
			$cve_urge		= "";
			$sintesis		= "";
			$cve_docto		= "";
			$fec_elab		= "";
			$base_datos		= "";
			$prop_base		= "";
			$parametro		= "";

			$fec_salid		= $sql->f("fec_salid");
			$fol_orig		= $sql->f("fol_orig");
			$conse			= $sql->f("conse");
			$fec_salid2		= $sql->f("fec_salid2");
			$fec_comp		= $sql->f("fec_comp");
			$remite			= $sql->f("remite");
			$cve_urge		= $sql->f("cve_urge");
			$sintesis		= $sql->f("sintesis");
			$cve_docto		= $sql->f("cve_docto");
			$fec_elab		= $sql->f("fec_elab");
			$base_datos		= $sql->f("base_datos");
			$prop_base		= $sql->f("prop_base");
			$parametro		= "$fol_orig-$conse";
			if (strlen($sintesis)>400) {
				$sintesis=substr($sintesis,0,400)."...";
			}
			switch ($cve_urge) {
				case "":
					$urgencia="No requiere respuesta";
				break;
				case "C":
					$urgencia="No requiere respuesta";
				break;
				case "O":
					$urgencia="Requiere respuesta<BR>ORDINARIA";
				break;
				case "U":
					$urgencia="Requiere respuesta<BR>URGENTE";
				break;
				case "E":
					$urgencia="Requiere respuesta<BR>EXTRAURGENTE";
				break;
			}
			$x++;

			$sql2 = new scg_DB;
			//print("select fol_orig from documento where cve_docto='$cve_docto' and (cve_refe='$fol_orig-$conse' or cve_refe='$fol_orig$conse')<br>");
			$sql2->query("select fol_orig from documento where cve_docto='$cve_docto' and (cve_refe='$fol_orig-$conse' or cve_refe='$fol_orig$conse')");
			if ($sql2->num_rows($sql) > 0) {
				while($sql2->next_record()) {
					$folio_en_documentos = $sql2->f("0");
				}
			}
			echo "<tr bgcolor='#$color_renglon' valign=top>\n<td class='chiquito' align='left'>$x.-";
			if ($folio_en_documentos) {
				echo "<br><img src='$default->scg_graphics_url/tick_plana.gif' border='0'>";
			}
			echo "</td>";
			echo "\t<td class='chiquito' align='left'>\n";
			echo "\t\t$fol_orig-$conse<br>";

			if (substr($control_menu_superior,1,1)!="2" && (!$folio_en_documentos)) {
				echo "<a href='principal.php?sess=$sess&control_botones_superior=7&variable=insertDocumentoDeBuzonDirecto&parametro=$parametro'><img src='$default->scg_graphics_url/registrar.gif' border='0' title='Recibir directamente el envío' alt='Recibir directamente el envío'></a>";
				echo "<a href='principal.php?sess=$sess&control_botones_superior=7&variable=rechazaSoliBuzon&parametro=$parametro''><img src='$default->scg_graphics_url/rechazar.gif' border='0' title='Contestar que el documento no compete' alt='Contestar que el documento no compete'></a>&nbsp;";
				echo "<a href='principal.php?sess=$sess&control_botones_superior=7&variable=recibeSoliBuzon&parametro=$parametro'><img src='$default->scg_graphics_url/cambio.gif' border='0' title='Complementar y Aceptar Envío' alt='Complementar y Aceptar Envío'></a>&nbsp;";
				echo "<a href='principal.php?sess=$sess&control_botones_superior=7&variable=borraSoliBuzon&parametro=$parametro&control=0'><img src='$default->scg_graphics_url/baja.gif' border='0' title='Eliminar registro' alt='Eliminar registro'></a>&nbsp;";
			} else {
				if ($folio_en_documentos) {
					echo "<a href='listados.php?sess=$sess&control_botones_superior=1&variable=detalle_documento_consulta&tipo_reporte=$tipo_reporte&columna=$i&parametro=$folio_en_documentos'><img src='$default->scg_graphics_url/consulta.gif' border='0' title='Detalle de Documento' alt='Detalle de Documento'></a>&nbsp;";
					echo "<a href='principal.php?sess=$sess&control_botones_superior=7&variable=borraSoliBuzon&parametro=$parametro&control=1'><img src='$default->scg_graphics_url/baja.gif' border='0' title='Eliminar registro' alt='Eliminar registro'></a>&nbsp;";
				}
			}
			echo "\t</td>\n";

			echo "\t<td class='chiquito' align='left'>\n";
			echo "\t\t$cve_docto<br>$fec_elab";
			echo "\t</td>\n";

			echo "\t<td class='chiquito' align='left'>\n";
			echo "\t\t$remite<br>$fec_salid2";
			echo "\t</td>\n";

			echo "\t<td class='chiquito' align='center'>\n";
			echo "\t\t$urgencia<br>$fec_comp";
			echo "\t</td>\n";

			echo "\t<td class='chiquito' align='left'>\n";
			echo "\t\t$sintesis";
			echo "\t</td>\n";

			echo "</tr>\n";
			if ($color_renglon==$color_1) {
				$color_renglon=$color_2;
			} else {
				$color_renglon=$color_1;
			}
		}
		//cierra tabla
		?>
		</table>
		<?
	}
} else {
	?>
	<br>
	<table width=100% border=0 cellspacing=2 cellpadding=2>
	 <tr>
	  <td width=100% align=center>
			<font class='bigsubtitle'>No hay documentos en el buzón de solicitudes</font>
	  </td>
	 </tr>
	</table>
	<?
}
