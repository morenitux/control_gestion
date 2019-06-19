<?php
	/* recibe la variable control_menu_superior que contiene unos y ceros
   para señalar cuál opción estará disponible y cuál no dependiendo
   de los privilegios del usuario */
  $control_menu_superior=$ok["ctrl_menu_sup"];
	if ($control_menu_superior=="") $control_menu_superior="00000000000";
	if ($control_botones_superior=="") $control_botones_superior="0";
?>
<body>
<table border=1 cellpadding=0 cellspacing=0 width=100%	>
 <tr>
  <td width=20% align=center>
  <?php
  if (substr($control_menu_superior,0,1)=="1") {
  	if ($control_botones_superior=="0" || $control_botones_superior=="999") {
  		echo "<a href='principal.php?sess=$sess&control_botones_superior=999&control_catalogos=0'>Editar catálogos</a>&nbsp;";
	 	} else {
			echo "&nbsp;";
		}
	} else {
		echo "&nbsp;";
	}
  ?>
  </td>
  <td width=60% align=center>
   <?php
   //BOTON 0
   if (substr($control_menu_superior,0,1)=="1") {
    if ($control_botones_superior!="0") {
   		$nuevo_control_botones_superior="0";
   		echo "<a href='principal.php?sess=$sess&control_botones_superior=$nuevo_control_botones_superior'><img src='$default->scg_graphics_url/b00.gif' border=0 alt='Cerrar formas'></a>&nbsp;";
		} else {
			echo "<a href='principal.php?sess=$sess&control_botones_superior=0'><img src='$default->scg_graphics_url/b01.gif' border=0 alt='Cerrar formas'></a>&nbsp;";
   		//echo "<font class='chiquito'><img src='$default->scg_graphics_url/b01.gif' border=0 alt='Cerrar formas'>&nbsp;</font>";
		}
	}
   //BOTON 1
   if (substr($control_menu_superior,1,1)>="1") {
	   	if ($control_botones_superior!="1") {
	   		$nuevo_control_botones_superior="1";
	   		echo "<a href='principal.php?sess=$sess&control_botones_superior=$nuevo_control_botones_superior'><img src='$default->scg_graphics_url/b10.gif' border=0 alt='Entrada de Documentos'></a>&nbsp;";
   		} else {
				echo "<a href='principal.php?sess=$sess&control_botones_superior=1'><img src='$default->scg_graphics_url/b11.gif' border=0 alt='Entrada de Documentos'></a>&nbsp;";
	   		//echo "<font class='chiquito'><img src='$default->scg_graphics_url/b11.gif' border=0 alt='Entrada de Documentos'>&nbsp;</font>";
		}
   }
   //BOTON 2
   if (substr($control_menu_superior,2,1)=="1") {
	   	if ($control_botones_superior!="2") {
	   		$nuevo_control_botones_superior="2";
 		    echo "<a href='principal.php?sess=$sess&control_botones_superior=$nuevo_control_botones_superior'><img src='$default->scg_graphics_url/b20.gif' border=0 alt='Entrada de Respuestas'></a>&nbsp;";
   		} else {
				echo "<a href='principal.php?sess=$sess&control_botones_superior=2'><img src='$default->scg_graphics_url/b21.gif' border=0 alt='Entrada de Respuestas'></a>&nbsp;";
	   		//echo "<font class='chiquito'><img src='$default->scg_graphics_url/b21.gif' border=0 alt='Entrada de Respuestas'>&nbsp;</font>";
	    }
   }
   //BOTON 3
   if (substr($control_menu_superior,3,1)=="1") {
	   	if ($control_botones_superior!="3") {
	   		$nuevo_control_botones_superior="3";
 		    echo "<a href='principal.php?sess=$sess&control_botones_superior=$nuevo_control_botones_superior'><img src='$default->scg_graphics_url/b30.gif' border=0 alt='Estadísticas de Documentos'></a>&nbsp;";
   		} else {
				echo "<a href='principal.php?sess=$sess&control_botones_superior=3'><img src='$default->scg_graphics_url/b31.gif' border=0 alt='Estadísticas de Documentos'></a>&nbsp;";
	   		//echo "<font class='chiquito'><img src='$default->scg_graphics_url/b31.gif' border=0 alt='Estadísticas de Documentos'>&nbsp;</font>";
	    }
   }
   //BOTON 4
   if (substr($control_menu_superior,4,1)=="1") {
	   	if ($control_botones_superior!="4") {
	   		$nuevo_control_botones_superior="4";
	   		echo "<a href='principal.php?sess=$sess&control_botones_superior=$nuevo_control_botones_superior'><img src='$default->scg_graphics_url/b40.gif' border=0 alt='Seguimiento de Documentos'></a>&nbsp;";
	    } else {
				echo "<a href='principal.php?sess=$sess&control_botones_superior=4'><img src='$default->scg_graphics_url/b41.gif' border=0 alt='Seguimiento de Documentos'></a>&nbsp;";
	   		//echo "<font class='chiquito'><img src='$default->scg_graphics_url/b41.gif' border=0 alt='Seguimiento de Documentos'>&nbsp;</font>";
   	    }
   }
   //BOTON 5
   if (substr($control_menu_superior,5,1)=="1") {
	   	if ($control_botones_superior!="5") {
	   		$nuevo_control_botones_superior="5";
	 	    echo "<a href='principal.php?sess=$sess&control_botones_superior=$nuevo_control_botones_superior'><img src='$default->scg_graphics_url/b50.gif' border=0 alt='Estadísticas de Turnos'></a>&nbsp;";
   		} else {
				echo "<a href='principal.php?sess=$sess&control_botones_superior=5'><img src='$default->scg_graphics_url/b51.gif' border=0 alt='Estadísticas de Turnos'></a>&nbsp;";
	   		//echo "<font class='chiquito'><img src='$default->scg_graphics_url/b51.gif' border=0 alt='Estadísticas de Turnos'>&nbsp;</font>";
	    }
   }
   //BOTON 6
   if (substr($control_menu_superior,6,1)=="1") {
	   	if ($control_botones_superior!="6") {
	   		$nuevo_control_botones_superior="6";
	   		echo "<a href='principal.php?sess=$sess&control_botones_superior=$nuevo_control_botones_superior'><img src='$default->scg_graphics_url/b60.gif' border=0 alt='Seguimiento de Turnos'></a>&nbsp;";
   		} else {
				echo "<a href='principal.php?sess=$sess&control_botones_superior=6'><img src='$default->scg_graphics_url/b61.gif' border=0 alt='Seguimiento de Turnos'></a>&nbsp;";
	   		//echo "<font class='chiquito'><img src='$default->scg_graphics_url/b61.gif' border=0 alt='Seguimiento de Turnos'>&nbsp;</font>";
	    }
   }
   //BOTON 7 BUZON DE SOLICITUDES
   if (substr($control_menu_superior,7,1)=="1") {
	   	if ($control_botones_superior!="7") {
	   		$nuevo_control_botones_superior="7";
	   		echo "<a href='principal.php?sess=$sess&control_botones_superior=$nuevo_control_botones_superior'><img src='$default->scg_graphics_url/b70.gif' border=0 alt='Buzón de solicitudes'></a>&nbsp;";
   		} else {
				echo "<a href='principal.php?sess=$sess&control_botones_superior=7'><img src='$default->scg_graphics_url/b71.gif' border=0 alt='Buzón de solicitudes'></a>&nbsp;";
	   		//echo "<font class='chiquito'><img src='$default->scg_graphics_url/b61.gif' border=0 alt='Seguimiento de Turnos'>&nbsp;</font>";
	    }
   }
   //BOTON 8 BUZON DE RESPUESTAS
   if (substr($control_menu_superior,8,1)=="1") {
	   	if ($control_botones_superior!="8") {
	   		$nuevo_control_botones_superior="8";
	   		echo "<a href='principal.php?sess=$sess&control_botones_superior=$nuevo_control_botones_superior'><img src='$default->scg_graphics_url/b80.gif' border=0 alt='Buzón de respuestas'></a>&nbsp;";
   		} else {
				echo "<a href='principal.php?sess=$sess&control_botones_superior=8'><img src='$default->scg_graphics_url/b81.gif' border=0 alt='Buzón de respuestas'></a>&nbsp;";
	   		//echo "<font class='chiquito'><img src='$default->scg_graphics_url/b61.gif' border=0 alt='Seguimiento de Turnos'>&nbsp;</font>";
	    }
   }
   //BOTON 9 IMPRESION
   if (substr($control_menu_superior,9,1)=="1") {
	   	if ($control_botones_superior!="9") {
	   		$nuevo_control_botones_superior="9";
	   		echo "<a href='principal.php?sess=$sess&control_botones_superior=$nuevo_control_botones_superior'><img src='$default->scg_graphics_url/bot_impresion.gif' border=0 alt='Reportes'></a>&nbsp;";
   		} else {
				echo "<a href='principal.php?sess=$sess&control_botones_superior=9'><img src='$default->scg_graphics_url/bot_impresion_2.gif' border=0 alt='Reportes'></a>&nbsp;";
	   		//echo "<font class='chiquito'><img src='$default->scg_graphics_url/b61.gif' border=0 alt='Seguimiento de Turnos'>&nbsp;</font>";
	    }
   }
   ?>
  </td>
  <td width=20% align=right>
  	<?php
   //BOTON 10 ADMINISTRACION DE PRIVILEGIOS
   if (substr($control_menu_superior,10,1)=="1") {
	   	if ($control_botones_superior!="10") {
	   		$nuevo_control_botones_superior="10";
	   		echo "<a href='principal.php?sess=$sess&control_botones_superior=$nuevo_control_botones_superior'><img src='$default->scg_graphics_url/bot_usuarios.gif' border=0 alt='Privilegios'></a>&nbsp;";
   		} else {
				echo "<a href='principal.php?sess=$sess&control_botones_superior=10'><img src='$default->scg_graphics_url/bot_usuarios_2.gif' border=0 alt='Privilegios'></a>&nbsp;";
	   		//echo "<font class='chiquito'><img src='$default->scg_graphics_url/b61.gif' border=0 alt='Seguimiento de Turnos'>&nbsp;</font>";
	    }
   }
   print("<a href='index.php?login=logout&sess=$sess'><img src='$default->scg_graphics_url/bot_puertita.gif' border=0></a>&nbsp;&nbsp;\n");
  ?>
  </td>
 </tr>
</table>
</body>