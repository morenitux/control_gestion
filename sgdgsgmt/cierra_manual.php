<?
include("connect1.php");
$cve_depen=(isset($_REQUEST[cve_depe]) ? $_REQUEST[cve_depe] : "0");
$documento=(isset($_REQUEST[documento]) ? $_REQUEST[documento] : "");
$respuesta=(isset($_REQUEST[respuesta]) ? $_REQUEST[respuesta] : "");
$procesar=(isset($_REQUEST[procesar]) ? $_REQUEST[procesar] : 0);



$depen=pg_exec($conn_s,"select cve_depe, nom_depe, nom_titu, car_titu from dependencia order by nom_depe");
?>
<form name='si' action="cierra_manual.php" method="get">
 <select name="cve_depen" onchange="document.si.cve_depen.value=this.value;">
  <option="0" <? if ($cve_depen=="0") echo "selected">Seleccione el Área de turno</option>
  <? for ($i=0;$i<pg_numrows($depen);$i++) echo "<option value='".pg_result($depen,$i,cve_depe)."' ".($cve_depen==pg_result($depen,$i,cve_depe) ? " selected" : "").">".pg_result($depen,$i,nom_depe)." (".pg_result($depen,$i,nom_titu).".-".pg_result($depen,$i,car_titu).")</option>\n"; ?>
 </select>
 <br>
 <br>
 Documento:
 <input type=text name="documento" value="<? echo $documento ?>" required maxlenght=50 size=50>
 <br>
 <br>
 <textarea name="respuesta"  cols=50 rows=5 required><? echo $procesar ?></textarea>
 <br>
 <br>
 <input type=hidden name=procesar value='0'>
 <input type=submit name="boton" value="procesar..." onclick="document.si.procesar.value=1;">
</form>
<?
if ($procesar==1) pg_exec($conn_s,"update docsal set fec_regi='$fecha'::date, cve_docto='s/n', text_resp='$respuesta ', modi_resp='PROGRAMA', fec_conclu=fec_comp, califresp=1 where cve_depe='$cve_depen' and (modi_resp is null or modi_resp='')");
include("disconnect1.php");
?>
