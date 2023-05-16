<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var arrDictamen=null;

Ext.onReady(inicializar);

function inicializar()
{
	 new Ext.Button (
                                {
                                    icon:'../images/Save.png',
                                    cls:'x-btn-text-icon',
                                    text:'Guardar evaluaci&oacute;n',
                                    width:150,
                                    height:30,
                                    renderTo:'contenedor1',
                                    handler:function()
                                            {
                                                guardarDatosCuestionario(true)
                                            }
                                    
                                }
                            )
                            
                                    
        new Ext.Button (
                                {
                                    icon:'../images/icon_big_tick.gif',
                                    cls:'x-btn-text-icon',
                                    text:'Finalizar evaluaci&oacute;n',
                                    width:150,
                                    height:30,
                                    renderTo:'contenedor2',
                                    handler:function()
                                            {
                                                guardarDatosCuestionario()
                                            }
                                    
                                }
                            )
}


function respuestaSel(ctrl)
{
	var datosID=ctrl.name.split('_');
	var valor;
    var valorPregunta;
    var esNoAplica=false;
    switch(ctrl.nodeName)
    {
    	case 'INPUT':
			valor=ctrl.value;
            valorPregunta=ctrl.getAttribute('puntaje');
            if((valor=='-2')&&((ctrl.getAttribute('ctrlNoaplica')!=null)&&(ctrl.getAttribute('ctrlNoaplica')!='')))
            {
            	esNoAplica=true;
            }
            
		break;
		case 'SELECT':
			valor=ctrl.options[ctrl.selectedIndex].value;
             if((valor=='-2')&&((ctrl.options[ctrl.selectedIndex].getAttribute('ctrlNoaplica')!=null)&&(ctrl.options[ctrl.selectedIndex].getAttribute('ctrlNoaplica')!='')))
            {
            	esNoAplica=true;
            }
            valorPregunta=ctrl.options[ctrl.selectedIndex].getAttribute('puntaje');
		break;
    }
    
	var hPregunta=gE('p_'+datosID[1]);
    hPregunta.value=valor;
    
    var ponderacionElemento=hPregunta.getAttribute('ponderacionElemento');

    if(ponderacionElemento=='0')
    {
    	var maxValorPregunta=parseFloat(hPregunta.getAttribute('maxValorPregunta'));
        valorPregunta=(valorPregunta/maxValorPregunta)*parseFloat(hPregunta.getAttribute('valorPregunta'));
    }

    gE('lblValorPregunta_'+datosID[1]).innerHTML=valorPregunta;
    

    procesarPadre(ctrl);
}

function procesarPadre(ctrl)
{
	
    var datosID=ctrl.name.split('_');
    var hElemento=gE('p_'+datosID[1]);
    
    if(hElemento==null)
    {
        hElemento=ctrl;
    }
    var padre=gE(hElemento.getAttribute('padre'));
    
    var datosPadre=padre.name.split('_');
    
    var valMaximo=parseFloat(padre.getAttribute('valorMaxEsperado'));
    var valorPregunta=parseFloat(padre.getAttribute('valorPregunta'));
    var valorObtenido=0;
    var arrHijos=$('[padre='+hElemento.getAttribute('padre')+']');
    var x;
    var numRespuestasNoAplica=0;
    var lblPregunta;
    var datosHijo;
    
    for(x=0;x<arrHijos.length;x++)
    {
    	datosHijo=arrHijos[x].name.split('_');
    	lblPregunta=gE('lblValorPregunta_'+datosHijo[1]);
        if(lblPregunta)
        	lblPregunta=(lblPregunta.getAttribute('tipoPregunta')!='4');
        if(lblPregunta)
        {	
        	var vPregunta=parseFloat(gE('lblValorPregunta_'+datosHijo[1]).innerHTML);
            
            if(vPregunta>=0)
            {
                if(vPregunta==0)
                {
                
                    var c=obtenerElementoSeleccionado('rdo_'+datosHijo[1]);
                    if(c!=null)
                    {
                        if((c.getAttribute('ctrlNoaplica')!=null)&&(c.getAttribute('ctrlNoaplica')==1))
                        {
                            var maxValor=parseFloat((arrHijos[x].getAttribute('maxValorPregunta')));
                            valMaximo-=maxValor;
                            numRespuestasNoAplica++;
                        }
                    }                
                }
                valorObtenido+=vPregunta;
            }
            else
            {
                valMaximo+=vPregunta;
            }
    	}
    }
    
    var valorPadre=0;
    if(valMaximo>0)
        valorPadre=(valorObtenido/valMaximo)*valorPregunta;
    
       
        
    padre.value=valorPadre;
    
    if(arrHijos.length==numRespuestasNoAplica)
    {
        valorPadre=-valorPregunta;
    
    }
    if(padre.getAttribute('padre')!='-1')
    {
        gE('lblValorPregunta_'+datosPadre[1]).innerHTML=valorPadre;
        procesarPadre(padre);
    }
    else
    {
        var datosPadre=padre.id.split('_');
        
        var dictamenFinal=parseFloat(formatearNumero(parseFloat(valorPadre),2,'.','',true));
        gE('lblValorPregunta_'+datosPadre[1]).innerHTML=dictamenFinal;
        ditaminarCuestionario(dictamenFinal);
    }
}

function guardarDatosCuestionario(saveParcial)
{
	if(gE('vistaDiseno').value=='1')	
    	return;
	var idCuestionario=gE('idCuestionario').value;
    if(idCuestionario=='-1')
    	return;
    var arrCuestionario=$('[valorPregunta=1]');
  
    var arrRespuestas=$('[tipo=3]');
        
    var idRegistro=gE('idRegistro').value;
    var idReferencia1=gE('idReferencia1').value;
	var idReferencia2=gE('idReferencia2').value;
    var esEvaluacionComite=gE('esEvaluacionComite').value;
	
    var x;
    var p;
    var cadOpciones='';
    var opc='';
    var idElemento;
    var eFinal;
    var nHidden='';
    var arrDatosCtrl;
    var idDictamen=gE('dictamen').value;
    var procesarCuestionario=true;

    if(saveParcial==undefined)
    {
        for(x=0;x<arrRespuestas.length;x++)
        {
            if((arrRespuestas[x].value=='-1')||(arrRespuestas[x].value==''))
            {
                procesarCuestionario=false;
                mE('err_'+arrRespuestas[x].getAttribute('idElemento'));
            }
            else
                oE('err_'+arrRespuestas[x].getAttribute('idElemento'));
        }
    }
	if(!procesarCuestionario)
    {
    	msgBox('Debe responder todas las preguntas');
    	return;
    }
    var lblMsg='Est&aacute; seguro de querer finalizar la evaluaci&oacute;n del proyecto?';
    var guardadoParcial='0';
    if(saveParcial!=undefined)
    {
        guardadoParcial='1';
        lblMsg='Est&aacute; seguro de querer guardar la evaluaci&oacute;n del proyecto?';
    }

    function resp(btn)
    {
    	if(btn=='yes')
        {
        	var valor;
            var valorTexto;
            var idOpcion;
            for(x=0;x<arrCuestionario.length;x++)
            {
            	valorTexto='';
                valor='';
                idOpcion=0;
                
                p=arrCuestionario[x];
                arrDatosCtrl=p.id.split('_');
                nHidden='p_'+arrDatosCtrl[1];
                idElemento=p.getAttribute('idElemento');
                if(idElemento!='-1')
                {
                	if(p.getAttribute('tipoPregunta')=='4')
                	{
                    	valor='';
                        valorTexto=gE('txtArea_p_'+arrDatosCtrl[1]).value;
                        idOpcion=0;
                    }
                	else
                    {
                    	valorTexto='(null)';
                        valor=p.innerHTML;
                        if(valor=='')
                            valor=0;
                        idOpcion=gE(nHidden).value;
                        if(idOpcion=='')
                            idOpcion=-1;
                    }
                    opc='{"idElemento":"'+idElemento+'","valor":"'+valor+'","idOpcion":"'+idOpcion+'","valorTexto":"'+cv(valorTexto)+'"}';
                    if(cadOpciones=='')
                        cadOpciones=opc;
                    else
                        cadOpciones+=','+opc;
                }
                else
                    eFinal=p;
            }
           
          
            
            var cadObj='{"idCuestionario":"'+idCuestionario+'","idReferencia1":"'+idReferencia1+'","idReferencia2":"'+idReferencia2+'","idRegistro":"'+idRegistro+'","puntajeTotal":"'+eFinal.innerHTML+'","dictamen":"'+idDictamen+'","comentariosFinales":"'+cv(gE('lblComentarios').value)+'","arrRespuestas":['+cadOpciones+']}';
			/*if((!Ext.isChrome)&&(!Ext.isIE8))
            {
                function funcAjax()
                {
                    var resp=peticion_http.responseText;
                    arrResp=resp.split('|');
                    if(arrResp[0]=='1')
                    {
                    	function resp11()
                        {
                        	recargarPagina();
                        }
                        msgBox('La operaci&oacute;n ha sido llevada a cabo exitosamente',resp11);
                        
                        if((window.parent.opener.finalizarEvaluacion!=undefined)&&(saveParcial==undefined))
                            window.parent.opener.finalizarEvaluacion(arrResp[1]);
                    }
                    else
                    {
                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                    }
                }
                obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=48&cadObj='+cadObj+'&guardadoParcial='+guardadoParcial,true);
			}
            else
            {
            	
            }*/
            
            function funcAjax2()
            {
                var resp=window.parent.peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    function resp10()
                    {
                    	
                    	/*if(esEvaluacionComite=='0')
                        {
                            window.parent.evaluacionFinal();
                        }
                        else*/
                        {

                        	if(saveParcial)
                            {
                            	
                            	window.parent.evaluacionParcial();
                            }
                            else
                            {
                            	window.parent.evaluacionFinal();
                            }
                        }
                    }
                    window.parent.msgBox('La operaci&oacute;n ha sido llevada a cabo exitosamente',resp10);
                    
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            window.parent.obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax2, 'POST','funcion=48&idUsuario='+gE('idUsuario').value+'&cadObj='+cadObj+'&esEvaluacionComite='+esEvaluacionComite+'&guardadoParcial='+guardadoParcial,true);	
        }
   	}
   	msgConfirm(lblMsg,resp)     
        
}

function ditaminarCuestionario(valDictamen)
{
	if(arrDictamen==null)
    	arrDictamen=eval(bD(gE('arrDictamen').value));
    var x;
    for(x=0;x<arrDictamen.length;x++)
    {
    	if((valDictamen>=arrDictamen[x][2])&&(valDictamen<=arrDictamen[x][3]))
        {
        	gE('dictamen').value=arrDictamen[x][0];
            gE('lblDictamen').innerHTML=arrDictamen[x][1];
        	return;
        }
    }
    gE('dictamen').value=-1;
	gE('lblDictamen').innerHTML='Sin dict&aacute;men';
    
}

function obtenerElementoSeleccionado(nElemento)
{
	var arrEle=gEN(nElemento);
    if(arrEle.length==0)
    	return null;
    var ctrl=arrEle[0];
    var arrCtrl;
    switch(ctrl.nodeName)
    {
    	case 'INPUT':
			arrCtrl=arrEle;
            
		break;
		case 'SELECT':
			arrCtrl=ctrl.options;
		break;
    }
    var x;
    for(x=0;x<arrCtrl.length;x++)
    {
    	if((arrCtrl[x].checked)||(arrCtrl[x].selected))
        	return arrCtrl[x];
    }
}