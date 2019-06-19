<?php
$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
require("./config/scg.php");
require("./config/html.php");
require("./includes/scg.lib.php");
require("./includes/readhd.php");
$titulo_en_header = $default->scg_title_in_header;
$windowname = "Principal";
include("./includes/header.inc");
print("<td width=700 align=center valign=top>\n");
if ($accion=="preexistentes") {
	include("turnosPreexistentes.php");
} else {
	include("turno.php");
}
echo "&nbsp;";
print("</td>\n");
include("./includes/footer.inc");
?>