<?
/*--------------------------------------------------------------------------------------
|	Archivo:        pendientes.php
|       Autor:          Alfredo Morales Becerra (alfmorales@metro.df.gob.mx)
|       Fecha:          Marzo 2006
|
|       Sistema de Transporte Colectivo
|       Dirección de Transportación
|       Proyecto: "Sistema de Gestión"
|
|       Última adaptación para Transportación:   09/10/2007
|
--------------------------------------------------------------------------------------*/
?>
<table width=50% border=0>
 <tr>
  <td align=left class=alerta1 >
   <?
   if ($vencidos!=0) echo "<a href='principal.php?sess=$sess&control_botones_superior=11&pendientes=V'><img src='boton_rojo.gif' border=0 alt='Turnos Vencidos'>$vencidos Turnos Vencidos</a><br>\n";
   if ($casi!=0) echo "<a href='principal.php?sess=$sess&control_botones_superior=11&pendientes=C'><img src='boton_amarillo.gif' border=0 alt='Turnos por vencer'>$casi Turnos Por Vencer</a><br>\n";
   if ($vigentes!=0) echo "<a href='principal.php?sess=$sess&control_botones_superior=11&pendientes=S'><img src='boton_verde.gif' border=0 alt='Turnos vigentes'>$vigentes Turnos Vigentes</a><br>\n";
   ?>
  </td>
 </tr>
</table>
