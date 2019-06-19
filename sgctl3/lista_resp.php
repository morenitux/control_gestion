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
$sql->query("select count(*) from resp_buzon where fol_orig is not null");
while($sql->next_record()) {
	$cuantos = $sql->f("0");
}
if ($cuantos>0) {
	$query="SELECT fec_salid,fol_orig,conse,to_char(fec_salid,'dd/mm/yyyy') as fec_salid2,remite,sintesis,cve_docto,to_char(fec_elab,'dd/mm/yyyy') as fec_elab2,base_datos,prop_base,folio_remite,conse_remite,plazo,viable,to_char(fec_notifica,'dd/mm/yyyy') as fec_notifica,cve_resp,etapas,to_char(fec_conclu,'dd/mm/yyyy') as fec_conclu,califresp,to_char(fec_compro,'dd/mm/yyyy') as fec_compro from resp_buzon where fol_orig is not null ";
	if ($condicion_adicional!="") {
		$query.=" and ".$condicion_adicional;
	}
	$query.=" order by fec_salid,fol_orig,conse";
	$sql = new scg_DB;
	$sql->query($query);
	$numero_renglones = $sql->num_rows($sql);
	if ($numero_renglones > 0) {
		//abre tabla
		?>
		<table width=100% border=0 cellspacing=2 cellpadding=2>
		 <tr>
		  <td width=100% align=center>
				<font class='bigsubtitle'>Buzón de respuestas</font>
		  </td>
		 </tr>
		</table>
		<table width=100% border=0 cellspacing=2 cellpadding=2>
			<tr bgcolor='#<? echo $bgcolor_titulos; ?>'>
				<td align='center' class='chiquitoblanco'>
					No.
				</td>
				<td align='center' class='chiquitoblanco'>
					<? echo "Turno"; ?>
				</td>
				<td align='center' class='chiquitoblanco'>
					<? echo "Referencia"; ?>
				</td>
				<td align='center' class='chiquitoblanco'>
					<? echo "Respuesta/<br>Fecha"; ?>
				</td>
				<td align='center' class='chiquitoblanco'>
					<? echo "Responsable"; ?>
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
			$remite			= "";
			$sintesis		= "";
			$cve_docto_resp	= "";
			$fec_elab2		= "";
			$base_datos		= "";
			$prop_base		= "";
			$folio_remite	= "";
			$conse_remite	= "";
			$plazo			= "";
			$viable			= "";
			$fec_notifica	= "";
			$cve_resp		= "";
			$etapas			= "";
			$fec_conclu		= "";
			$califresp		= "";
			$fec_compro		= "";
			$parametro		= "";

			$fec_salid		= $sql->f("fec_salid");
			$fol_orig		= $sql->f("fol_orig");
			$conse			= $sql->f("conse");
			$fec_salid2		= $sql->f("fec_salid2");
			$remite			= $sql->f("remite");
			$sintesis		= $sql->f("sintesis");
			$cve_docto_resp	= $sql->f("cve_docto");
			$fec_elab2		= $sql->f("fec_elab2");
			$base_datos		= $sql->f("base_datos");
			$prop_base		= $sql->f("prop_base");
			$folio_remite	= $sql->f("folio_remite");
			$conse_remite	= $sql->f("conse_remite");
			$plazo			= $sql->f("plazo");
			$viable			= $sql->f("viable");
			$fec_notifica	= $sql->f("fec_notifica");
			$cve_resp		= $sql->f("cve_resp");
			$etapas			= $sql->f("etapas");
			$fec_conclu		= $sql->f("fec_conclu");
			$califresp		= $sql->f("califresp");
			$fec_compro		= $sql->f("fec_compro");
			$parametro		= "$fol_orig-$conse";
			if (strlen($sintesis)>400) {
				$sintesis=substr($sintesis,0,400)."...";
			}
			$x++;
			$sql2 = new scg_DB;
			//print("select cve_docto,to_char(fec_elab,'dd/mm/yyyy') as fec_elab from documento where fol_orig='$fol_orig'<br>");
			$sql2->query("select cve_docto,to_char(fec_elab,'dd/mm/yyyy') as fec_elab from documento where fol_orig='$fol_orig'");
			if ($sql2->num_rows($sql) > 0) {
				while($sql2->next_record()) {
					$cve_docto 	= $sql2->f("0");
					$fec_elab 	= $sql2->f("1");
				}
			}
			echo "<tr bgcolor='#$color_renglon' valign=top>\n<td class='chiquito' align='left'>$x.-";
			echo "</td>";
			echo "\t<td class='chiquito' align='left'>\n";
			echo "\t\t$fol_orig-$conse<br>";
			if (substr($control_menu_superior,1,1)!="2" && (!$folio_en_documentos)) {
				echo "<a href='insertRespuestaDeBuzonDirecto.php?sess=$sess&control_botones_superior=8&parametro=$parametro&viene_de=buzon_respuestas&borrar_buzon_directo='><img src='$default->scg_graphics_url/registrar.gif' border='0' title='Registrar Respuesta' alt='Registrar Respuesta'></a>";
				echo "<a href='principal.php?sess=$sess&control_botones_superior=8&variable=recibeRespBuzon&parametro=$parametro'><img src='$default->scg_graphics_url/cambio.gif' border='0' title='Complementar y Registrar Respuesta' alt='Complementar y Registrar Respuesta'></a>&nbsp;";
				echo "<a href='principal.php?sess=$sess&control_botones_superior=8&variable=borraRespBuzon&parametro=$parametro&control=0'><img src='$default->scg_graphics_url/baja.gif' border='0' title='Eliminar registro' alt='Eliminar registro'></a>&nbsp;";
			} else {
				if ($folio_en_documentos) {
					echo "<a href='listados.php?sess=$sess&control_botones_superior=1&variable=detalle_documento_consulta&tipo_reporte=$tipo_reporte&columna=$i&parametro=$folio_en_documentos'><img src='$default->scg_graphics_url/consulta.gif' border='0' title='Detalle de Documento' alt='Detalle de Documento'></a>&nbsp;";
					echo "<a href='principal.php?sess=$sess&control_botones_superior=8&variable=RespSoliBuzon&parametro=$parametro&control=1'><img src='$default->scg_graphics_url/baja.gif' border='0' title='Eliminar registro' alt='Eliminar registro'></a>&nbsp;";
				}
			}
			echo "\t</td>\n";

			echo "\t<td class='chiquito' align='left'>\n";
			echo "\t\t$cve_docto<br>$fec_elab";
			echo "\t</td>\n";

			echo "\t<td class='chiquito' align='left'>\n";
			echo "\t\t$cve_docto_resp<br>$fec_elab2";
			echo "\t</td>\n";

			echo "\t<td class='chiquito' align='center'>\n";
			echo "\t\t$remite<br>$fec_comp";
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
			<font class='bigsubtitle'>No hay documentos en el buzón de respuestas</font>
	  </td>
	 </tr>
	</table>
	<?
}
//$sql->disconnect($sql->Link_ID);
?>
