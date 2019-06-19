<!-- Begin
function isValidDate(dateStr) {
	var datePat = /^(\d{2})(\/|-)(\d{2})\2(\d{4})$/;
	var matchArray = dateStr.match(datePat);
	if (matchArray == null) {
		alert("Por favor verifique la fecha.")
		valida = 0;
		return false;
	}
	day = matchArray[1];
	month = matchArray[3];
	year = matchArray[4];
	if (day < 1 || day > 31) {
		alert("El valor del día debe ser entre 1 y 31.");
		valida = 0;
		return false;
	}
	if (month < 1 || month > 12) {
		alert("El valor del mes debe ser entre 1 y 12.");
		valida = 0;
		return false;
	}
	if ((month==4 || month==6 || month==9 || month==11) && day==31) {
		alert("El mes "+month+" no tiene 31 días!")
		valida = 0;
		return false
	}
	if (month == 2) {
		var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
		if (day>29 || (day==29 && !isleap)) {
			alert("Febrero de " + year + " no tiene " + day + " días!");
			valida = 0;
			return false;
		}
	}
	valida = 1;
	 return true;
}

function isValidHour(hourStr) {
	/*
	Revisa horas en formato hh24:mi
	separando la hora en variables horas:minutos
	---------------------------------------------
	Saul E Morales Cedillo
	ccedillo@df.gob.mx
	Direccion de Nuevas Tecnologias GDF
	*/

	var hourPat = /^(\d{2})(\:)(\d{2})$/;  //Se denife el patrón de dos digitos luego dos puntos y luego dos digitos
	var matchArray = hourStr.match(hourPat); // Compara si el parámetro coincide con el patrón
	if (matchArray == null) {
		alert("El formato de hora no es valido. Utilice el formato hh:mm de 24 horas.")
		return false;
	}
	hora = matchArray[1]; // separa la hora en variables hora y minutos
	minutos = matchArray[3];

	if (hora < 0 || hora > 23) { // checa el rango de la hora
		alert("La hora debe estar en el rango del 1 al 23.");
		return false;
	}

	if (minutos < 00 || minutos > 59) { // checa el rango de los minutos
		alert("Los minutos deben estar en el rango del 0 a 59.");
		return false;
	}
	return true;  // la hora es válida
}

function ComparacionEntreFechas(dateStr1,dateStr2) {
	/*
	Regresa ERRORF1,ERRORF2,MAYOR,MENOR o IGUAL según el resultado de comparar
	dos fechas parametro en formato dd/mm/yyyy
	---------------------------------------------
	Saul E Morales Cedillo
	ccedillo@df.gob.mx
	Direccion de Nuevas Tecnologias GDF
	*/

	var datePat = /^(\d{1,2})(\/)(\d{1,2})\2(\d{4})$/; //Se define el patrón de fecha dd/mm/yyyy
	var matchArray1 = dateStr1.match(datePat); // Compara si el parámetro 1 coincide con el patrón
	if (matchArray1 == null) {
		return 'ERRORF1'; //El formato de la fecha 1 no es valido. Utilice el formato dd/mm/aaaa
	}
	var matchArray2 = dateStr2.match(datePat); // Compara si el parámetro 2 coincide con el patrón
	if (matchArray2 == null) {
		return 'ERRORF2'; //El formato de la fecha 2 no es valido. Utilice el formato dd/mm/aaaa
	}
	day1 = matchArray1[1]; // divide fecha 1 en variables
	month1 = matchArray1[3];
	year1 = matchArray1[4];

	day2 = matchArray2[1]; // divide fecha 2 en variables
	month2 = matchArray2[3];
	year2 = matchArray2[4];

	if (year1 < year2) {
	   return 'MENOR';
	} else {
	   if (year1 > year2) {
	      return 'MAYOR';
	   } else {
	      if (month1 < month2) {
	         return 'MENOR';
	      } else {
	         if (month1 > month2) {
	            return 'MAYOR';
	         } else {
	            if (day1 < day2) {
	               return 'MENOR';
	            } else {
	               if (day1 > day2) {
	                  return 'MAYOR';
	               } else {
	                  return 'IGUAL';
	               }
	            }
	         }
	      }
	   }
	}
}

function ComparacionEntreFechasConHoras(dateStr1,horaStr1,dateStr2,horaStr2) {
	/*
	Regresa ERRORF1,ERRORF2,ERRORH1,ERRORH2,MAYOR,MENOR o IGUAL según el resultado de comparar
	dos fechas y sus horas como parámetro en formato dd/mm/yyyy hh24:mi
	---------------------------------------------
	Saul E Morales Cedillo
	ccedillo@df.gob.mx
	Direccion de Nuevas Tecnologias GDF
	*/

   	var datePat = /^(\d{1,2})(\/)(\d{1,2})\2(\d{4})$/; //Se define el patrón de fecha dd/mm/yyyy
   	var matchArray1 = dateStr1.match(datePat); // Compara si el parámetro fecha 1 coincide con el patrón
   	if (matchArray1 == null) {
		return 'ERRORF1'; //El formato de la fecha 1 no es valido. Utilice el formato dd/mm/aaaa
	}
   	var matchArray2 = dateStr2.match(datePat); // Compara si el parámetro fecha 2 coincide con el patrón
   	if (matchArray2 == null) {
		return 'ERRORF2'; //El formato de la fecha 2 no es valido. Utilice el formato dd/mm/aaaa
	}

	day1 = matchArray1[1]; // divide fecha 1 en variables
	month1 = matchArray1[3];
	year1 = matchArray1[4];

	day2 = matchArray2[1]; // divide fecha 2 en variables
	month2 = matchArray2[3];
	year2 = matchArray2[4];

	var hourPat = /^(\d{2})(\:)(\d{2})$/; //Se denife el patrón de dos digitos luego dos puntos y luego dos digitos
	var matchArray3 = horaStr1.match(hourPat); // Compara si el parámetro hora 1 coincide con el patrón
	if (matchArray3 == null) {
		return 'ERRORH1'; //El formato de hora no es valido. Utilice el formato hh:mm de 24 horas
	}

	var matchArray4 = horaStr2.match(hourPat); // Compara si el parámetro hora 2 coincide con el patrón
	if (matchArray4 == null) {
 		return "ERRORH2"; //El formato de hora no es valido. Utilice el formato hh:mm de 24 horas
 	}

	hora1 = matchArray3[1]; // parse date into variables
	minutos1 = matchArray3[3];

	hora2 = matchArray4[1]; // parse date into variables
	minutos2 = matchArray4[3];

	if (year1 < year2) {
	   return 'MENOR';
	} else {
	   if (year1 > year2) {
	      return 'MAYOR';
	   } else {
	      if (month1 < month2) {
	         return 'MENOR';
	      } else {
	         if (month1 > month2) {
	            return 'MAYOR';
	         } else {
	            if (day1 < day2) {
	               return 'MENOR';
	            } else {
	               if (day1 > day2) {
	                  return 'MAYOR';
	               } else {
	                  if (hora1 < hora2) {
	                     return 'MENOR EN HORAS';
	                  } else {
	                     if (hora1 > hora2) {
	                        return 'MAYOR EN HORAS';
	                     } else {
	                        if (minutos1 < minutos2) {
	                           return 'MENOR EN HORAS';
	                        } else {
	                           if (minutos1 > minutos2) {
	                              return 'MAYOR EN HORAS';
	                           } else {
	                              return 'IGUAL';
	                           }
	                        }
	                     }
	                  }
	               }
	            }
	         }
	      }
	   }
	}
}

/* Ejemplo de uso de la función ComparacionEntreFechasConHoras.
Estas línes deberían ir dentro de una función para
validar una forma.En este caso de ejemplo,
la fecha y la hora se capturan en dos <input type='text'>
diferentes: fecharec y hora_recepcion
-----------------------------------------------------------------

var comparacion=ComparacionEntreFechasConHoras(f.fecharec.value,f.hora_recepcion.value,'<? echo $fecha_ultima_actualizacion; ?>','<? echo $hora_ultima_actualizacion; ?>');
if (comparacion=='MENOR') {
	alert ('La fecha de cambio no puede ser menor a la fecha de la última actualización: '+'<? echo $fecha_ultima_actualizacion; ?>'+' '+'<? echo $hora_ultima_actualizacion; ?>'+' hrs.');
	f.fecharec.focus();
	return(false);
}
if (comparacion=='MENOR EN HORAS') {
	alert ('La hora del cambio no puede ser menor a la de la última actualización: '+'<? echo $fecha_ultima_actualizacion; ?>'+' '+'<? echo $hora_ultima_actualizacion; ?>'+' hrs.');
	f.hora_recepcion.focus();
	return(false);
}

-----------------------------------------------------------------
*/

//  End -->