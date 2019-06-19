<?php
function clave_generada($tabla,$campo,$valor) {
	$valor=strtoupper($valor);
	$valor=strtr($valor,"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","AAAAAAAEEEEEIIIIONOOOOOXOUUUBYAAAAAAAEEEEEIIIIDNOOOOOXOUUUBB");
	$pedazo = explode(" ", $valor);
	$cuantos = count($pedazo);
	if ($cuantos>1) {
		$x=0;
		$inicio="";
		while ($x<$cuantos) {
			if ($x<4) {
				$inicio.=substr($pedazo[$x],0,1);
			}
			$x++;
		}
		$lo_que_va=strlen($inicio);
		$faltante=4-$lo_que_va;
		if ($faltante>0) {
			$fuente_adicional=substr($pedazo[$x-1],1,strlen($pedazo[$x-1]));
			$tamanio_fuente_adicional=strlen($fuente_adicional);
			if ($tamanio_fuente_adicional>=$faltante) {
				$inicio.=substr($fuente_adicional,0,$faltante);
			} else {
				$inicio.=substr($pedazo[$x-1],1,strlen($pedazo[$x-1]));
				$lo_que_va=strlen($inicio);
				$faltante=4-$lo_que_va;
				if ($faltante>0) {
					$inicio.=str_repeat("0",$faltante);
				}
			}
		}
	} else {
		$inicio=substr($valor,0,4);
	}
	if (strlen($inicio)<4) {
		$inicio=str_pad($inicio, 4, "0", STR_PAD_RIGHT);
	}
	$sql = new scg_DB;
	$sql->query("SELECT max(substr($campo,5,4)) from $tabla where substr($campo,1,4)='$inicio'");
	if ($sql->num_rows($sql)>0) {
		while($sql->next_record()) {
			$fin = $sql->f("0")*1;
		}
	}
	if ($fin=='' || $fin==0) {
		$nuevo_fin='0001';
	} else {
		$fin++;
		$nuevo_fin=str_pad($fin, 4, "0", STR_PAD_LEFT);
	}
	$regreso=$inicio.$nuevo_fin;
	return $regreso;
}
?>