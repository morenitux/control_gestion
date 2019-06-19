<?php
if ($cual_submit=="BUSCAR") {
	include("buscar_documento_complex.php");

} else {
	if ($cual_submit=="GUARDAR") {
		include("insertDocumento.php");
	} else {
		echo "ERROR";
	}
}
?>