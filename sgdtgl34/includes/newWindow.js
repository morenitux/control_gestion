<!-- Begin
function newWindow(helphtm,x_parametro,y_parametro,padre,forma,variable) {
	var max_x = screen.width;	//maximo valor horizontal de la resolucion del monitor
	var max_y = screen.height;	//maximo valor vertical de la resolucion del monitor
	var x = screen.width*0.9;	//magnitud horizontal de la ventana
	var y = screen.height*0.9;	//magnitud vertical de la ventana
	var pos_horizontal=0;		//posicion de la ventana, coordenada x de la esquina superior izquierda
	var pos_vertical=0;			//posicion de la ventana, coordenada y de la esquina superior izquierda
	var suficiente = true;
	if (x<=x_parametro) {
		suficiente = false;
	} else {
		x=x_parametro
	}
	if (y<=y_parametro) {
		suficiente = false;
	} else {
		y=y_parametro
	}
	if (suficiente) {
		var dif_x=max_x - x;
		var dif_y=max_y - y;
		pos_horizontal=pos_horizontal + (dif_x/2);
		pos_vertical=pos_vertical + (dif_y/4);
	}
	Ventanita = window.open(helphtm,"bookWin", "width="+x+",height="+y+",scrollbars=yes,left="+pos_horizontal+",top="+pos_vertical+",location=no,toolbar=no,status=no,menubar=no,resizeble=no");
	Ventanita.focus();
}
//  End -->