Ext.onReady(inicializar);

function inicializar()
{
	var mes=gE('hMes').value;
	var txtMes=new Ext.form.NumberField	(
                                                {
                                                    id:'txtMes',
                                                    width:50,
                                                    maxLength:2,
                                                    renderTo:'spanMes',
                                                    value:mes,
                                                    style: {
                                                                textAlign:'center'
                                                            }
 
                                                }
                                            );
	function mesChange(campo,nuevoV,viejoV)
    {
    	if(nuevoV<1)
        {
            campo.setValue('1');
            return;
        }
        if(nuevoV>53)
        {
        	campo.setValue('53');
            return;
        }
    	cambiarMes(nuevoV);
    }                                            	
	txtMes.on('change',mesChange);                                            
	txtMes.focus();
    var anio=gE('hAnio').value;
    var txtAnio=new Ext.form.NumberField	(
                                                {
                                                    id:'txtAnio',
                                                    width:50,
                                                    maxLength:4,
                                                    renderTo:'spanAnio',
                                                    value:anio,
                                                    style: {
                                                                textAlign:'center'
                                                            }
 
                                                }
                                            );
	function anioChange(campo,nuevoV,viejoV)
    {
    	if(nuevoV<1970)
        {
            campo.setValue('1970');
            return;
        }
        if(nuevoV>2099)
        {
        	campo.setValue('2099');
            return;
        }
    	cambiarAnio(nuevoV);
    }                                            	
	txtAnio.on('change',anioChange);    
    
                                               
}

function cambiarMes(numMes)
{
	var mes=gE('mes');
    mes.value=numMes;
    gE('frmMes').submit();
}

function cambiarAnio(numAnio)
{
	var anio=gE('anio');
    anio.value=numAnio;
    gE('frmMes').submit();
}

function ejecutarAccionClickDia(fecha)
{
	if((funcionClickDia!=undefined)&&(funcionClickDia!=null))
    {
    	funcionClickDia(fecha);
    }
}