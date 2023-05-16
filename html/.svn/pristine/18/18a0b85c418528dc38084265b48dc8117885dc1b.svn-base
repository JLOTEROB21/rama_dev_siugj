Ext.onReady(inicializar);

function inicializar()
{
	crearCampoFecha('txtFechaIni','hFechaIni');
}
function verOcul()
{	
		var time1 = gE('hora0').options[gE('hora0').selectedIndex].text+':'+gE('min0').options[gE('min0').selectedIndex].text+' '+gE('middle0').options[gE('middle0').selectedIndex].text;
		var time2 = gE('hora').options[gE('hora').selectedIndex].text+':'+gE('min').options[gE('min').selectedIndex].text+' '+gE('middle').options[gE('middle').selectedIndex].text;
	
	//alert(Date.parse ( time1 ));
	time1=Date.parse ( time1 );
	time2=Date.parse ( time2 );
	//alert(Date.parse ( time2 ));
	valor=Date.compare(time1,time2);
	//alert (valor);
	
	if(valor==1)
	{	
		msgBox("La Hora de t&eacute;rmino no puede ser menor a la de inicio");
		return true;
	}
	if(valor==0)
	{	
		msgBox("La Hora de t&eacute;rmino no puede ser igual a la de inicio");
		return true;
	}
}
function checkvalidate(checks) {
    for (i = 0; i < gE('event').check.length; i++) {
        if (gE('event').check[i].checked) {
            return true;
        }
    }
    return false;
}

function submiteEvent()
{	
	
	if(validarFormularios('one-column-emphasis'))
	{		
			verifica=false;
			verifica=verOcul();
			var grupo = document.getElementById("event").chk;
			if(verifica==true||checkvalidate(grupo)==false)
			{	
				if(checkvalidate(grupo)==false){
				msgBox("Debe seleccionar por lo menos un campo de Afectacion");
				}
				else{
				msgBox("La configuracion de Hora seleccionada, no es correcta, por favor seleccione de nuevo");
				}
			}
			else
			{	inicio=gE('hora0').options[gE('hora0').selectedIndex].text+':'+gE('min0').options[gE('min0').selectedIndex].text+' '+gE('middle0').options[gE('middle0').selectedIndex].text;
				fin=gE('hora').options[gE('hora').selectedIndex].text+':'+gE('min').options[gE('min').selectedIndex].text+' '+gE('middle').options[gE('middle').selectedIndex].text;
				gE('inicio').value=inicio;
				gE('final').value=fin;
				gE('event').action='guardaEventoComite.php';
				gE('formated').value=Date.parse(gE('hFechaIni').value).toString("yyyy-dd-MM");
				gE('event').submit();
			}
	}
}