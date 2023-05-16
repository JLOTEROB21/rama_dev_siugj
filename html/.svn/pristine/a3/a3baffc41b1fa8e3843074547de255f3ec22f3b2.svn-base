<?php session_start();
	include("configurarIdiomaJS.php");
	$idFormulario=bD($_GET["iF"]);
	$consulta="SELECT idFuncionValidacion,camposEnvio,tipoValidacion  FROM 900_funcionesValidacion WHERE idFormulario=".$idFormulario;
	$filaFuncion=$con->obtenerPrimeraFila($consulta);
	$consulta="SELECT idFuncion,nombreFuncionJS FROM 9033_funcionesScriptsSistema WHERE idCategoria=1";
	$arrFuncionesRenderer=$con->obtenerFilasArreglo($consulta);
	
?>
var arrFuncionesRenderer=<?php echo $arrFuncionesRenderer?>;
var funcionValidacion2=null;
var editorActivo;
var myMask=null;
var posDivX;
var posDivY;
var ejecutarInicializar=0;
var controlesOcultos=new Array();

Ext.onReady(inicializar);

function calibrar()
{
	posDivX=obtenerPosX('frameTitulo');
	posDivY=obtenerPosY('frameTitulo');
    var calibrarCtrl=eval(bD(gE('hCtrlCalibrar').value));
 	for(x=0;x<calibrarCtrl.length;x++)
    {
    	calibrarPosicion(calibrarCtrl[x][0]);
    }	
    /*if(myMask!=null)
	    myMask.hide();	*/
}

function inicializar()
{
	var x;
    Ext.util.Format.bE=function(val)
    					{
                        	return bE(val);
                        }
	Ext.util.Format.bytesToSize=function(val)
    					{
                        	return bytesToSize(val);
                        }     
   /* if(!Ext.isIE)
    {
	    myMask = Ext.LoadMask(Ext.getBody(), {msg:"Cargando por favor espere..."});
		myMask.show();
    }*/
	ejecutarFuncionesInicio();
    ejecutarInicializar=1;
 	
    ponerFoco();
    setTimeout('calibrar()',1500);
    <?php
		$arrJava="";
		if($filaFuncion)
		{
			if($filaFuncion[2]==0)
			{
				$arrCampos=explode(",",$filaFuncion[1]);
				
				foreach($arrCampos as $campo)
				{
					if($arrJava=='')
						$arrJava="'".$campo."'";
					else
						$arrJava.=",'".$campo."'";
				}
				$arrJava="[".$arrJava."]";
				
								
	?>
    		funcionValidacion2=function()
            					{
                                	var arrJava=<?php echo $arrJava?>;
                                    var cadObj='{"idReferencia":"'+gE('idReferencia').value+'","idFuncion":"<?php echo $filaFuncion[0]?>","idFormulario":"'+gE('idFormulario').value+'","idRegistro":"'+gE('idRegistroG').value+'"';
                                    
                                    var x;
                                    var control;
                                    var fila='';
                                    var campo='';
                                    var pos;
                                    for(x=0;x<arrJava.length;x++)
                                    {
                                    	control=arrJava[x];
                                        pos=existeValorMatriz(diccionarioCtrl,control);
                                        if(pos!=-1)
                                        {
                                            campo=diccionarioCtrl[pos][1];
                                            fila=',"'+control+'":"'+cv(obtenerValorCampo(campo))+'"';
                                            cadObj+=fila;
                                    	}
                                    }
                                    cadObj+='}';
                                    function funcAjax()
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                        
                                        	var x;
                                           	prepararFormularioEnvio('frmEnvio');

                                        }
                                        else
                                        {
                                        	if(arrResp[0].indexOf('[')==0)
                                            {
                                            	var arrErr=eval(arrResp[0]);
                                                window.parent.mostrarVentanaError(arrErr);
                                            }
                                            else
                                            {
                                                function respErr()
                                                {
                                                    if(arrResp[1]!='')
                                                    {
                                                        pos=existeValorMatriz(diccionarioCtrl,arrResp[1]);
                                                        
                                                        if(pos!=-1)
                                                        {
                                                            campo=diccionarioCtrl[pos][1];
                                                            gE(campo).focus();
                                                        }
                                                    }
                                                }
                                                msgBox('No se puede guardar el registro debido a lo siguiente: <br><br>'+arrResp[0],respErr);
                                            }
                                        }
                                    }
                                    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=232&obj='+cadObj,true);
                   	
                                    
                                }
    <?php	
			}
		}
	?>


	if(typeof(inyeccionCodigo)!='undefined')
    {

    	inyeccionCodigo();
    }
    

	/*$('#dock2').Fisheye	(
                            {
                                maxWidth: 50,
                                items: 'a',
                                itemsText: 'span',
                                container: '.dock-container2',
                                itemWidth: 40,
                                proximity: 80,
                                alignment : 'left',
                                halign : 'left'
                            }
                        )*/
		
}

function ponerFoco()
{
	if(typeof(ctrlEnfocar)=='undefined')
    	return;
	var div=gE(ctrlEnfocar);
	var controlI=div.getAttribute('controlInterno');
    if(controlI !=null)
    {
        var datosCtrl=controlI.split('_');
        var tipoCtrl=datosCtrl[2];
        var nomCtrl='_'+datosCtrl[1];
        switch(parseInt(tipoCtrl))
        {
        	case -1:
            	gE('btnCancelar').focus();
            break;
            case 0:
            	gE('btnGuardar').focus();
            break;
           	case 2:
            case 3:
            case 4:
            case 5:
            case 6:
            case 7:
            case 9:
            case 11:
            case 12:
            	gE(nomCtrl).focus();
            break; 
            case 8:
            case 21:
            	var idControl=gE(nomCtrl).getAttribute('extId');
            	Ext.getCmp(idControl).focus(false,100);
            break;
            case 14:
            case 15:
            case 16:
            case 17:
            case 18:
            case 19:
            	var idControl=gE(nomCtrl).getAttribute('controlF');
                gE(idControl).focus();
            	
            break;
            case 10:
            break;
        }
	}
    
}

function validarFrm(idContenedor)
{
	if(gE('ctrlDecodificado').value=='1')
    {
    	recodificacionControles(idContenedor);
    } 
    var x;
    for(x=0;x<arrTextRich.length;x++)
    {
    	gE(arrTextRich[x]).value=Ext.getCmp(arrTextRich[x]).getValue();
    }
    
    
    if(typeof(cadenaFuncionValidacion)!='undefined')
    {
    	var resultado="";
    	eval('resultado='+cadenaFuncionValidacion+'();');
        if(!resultado)
        {
        	return;
        }
        
    }
    
    if(typeof(arrPluginsProceso)!='undefined')
    {
    	var aux=0;
        var resultado;
        for(aux=0;aux<arrPluginsProceso.length;aux++)
        {
        	if(arrPluginsProceso[aux].cumpleValidacion)
            {
            	resultado=arrPluginsProceso[aux].cumpleValidacion();
                if(!resultado)
                {
                    return;
                }
            		
            }
        }
    	
    }
    
    
    
    var g;
    var aGaleria='';
    var oGaleria='';
    var arrGaleriaDocumento=gEN('galeriaDocumento');
    var ct=0;
    var cArrImagen;
    var aAux;
    var arrImagenes='';
    var oAux='';
    for(x=0;x<arrGaleriaDocumento.length;x++)
    {
    	g=arrGaleriaDocumento[x];
        cArrImagen=gE('sp_'+g.getAttribute('idCtrl'));
        aAux=eval(bD(cArrImagen.getAttribute('arrElementos')));
        for(ct=0;ct<aAux.length;ct++)
        {
        	if(aAux[ct].idArchivo!='-1')
            {
        		oAux='{"idArchivo":"'+aAux[ct].idArchivo+'","nombreArchivo":"'+cv(aAux[ct].nombreArchivo)+'"}';
                if(arrImagenes=='')
                	arrImagenes=oAux;
               	else
                	arrImagenes+=','+oAux;
            }
        }
        oGaleria='{"idCtrl":"'+g.getAttribute('idCtrl')+'","arrImagenes":['+arrImagenes+']}';
        if(aGaleria=='')
        	aGaleria=oGaleria;
        else
       		aGaleria+=','+oGaleria;	
    }
    aGaleria='['+aGaleria+']';
    
    gE('arrImagenesGaleria').value=bE(aGaleria);
	if(validarFormularios(idContenedor))
    {
    	var existeTabla=gE('hExisteTabla').value;
	    var idFormulario=gE('valorPost').value;
    	var arrCamposGrid=gE('arrCamposGrid').value;


		

		if(arrCamposGrid!='')
        {
        	var aCamposGrid=arrCamposGrid.split(',');
            var ct;
            var objCampo='';
            var cadArrObjCamposGrid='';
            var listRegistros='';
            var objRegistro='';
            var nAux;
            var gridCtrl;
            var almacen;
            var camposColeccion;
            var fila;
            var nItem;
            for (ct=0;ct<aCamposGrid.length;ct++)
            {
            	var arrDatosGrid=aCamposGrid[ct].split('_');
                gridCtrl=gEx(aCamposGrid[ct]);
                listRegistros='';
                almacen=gridCtrl.getStore();
                var span=gE('contenedorSpanGrid_'+arrDatosGrid[1]);
                if(span.getAttribute('val')=='obl')
                {
                	if((almacen.getCount()==0)&&(!gridCtrl.disabled))
                    {
                    	function respAux()
                        {
                        	
                        }
                    	msgBox('El campo <b>'+bD(span.getAttribute('msgCampo'))+'</b> es obligatorio, al menos debe ingresar un registro',respAux);
                        return;
                    }
                }
                if(!gridCtrl.disabled)
                {
                    for(nAux=0;nAux<almacen.getCount();nAux++)
                    {
                        objRegistro='';
                        fila=almacen.getAt(nAux);
                        camposColeccion=fila.fields;
                        for(nItem=0;nItem<camposColeccion.getCount();nItem++)
                        {
                            var valor=fila.get(camposColeccion.itemAt(nItem).name);
                            if(fila.get(camposColeccion.itemAt(nItem).name)instanceof Date)
                                valor=valor.format('Y-m-d');
                            if(typeof(fila.get(camposColeccion.itemAt(nItem).name))=='boolean')
                            {
                            	if(fila.get(camposColeccion.itemAt(nItem).name))
	                                valor='1';
                                else
                                    valor=0;
                            }
                            if(objRegistro=='')
                                objRegistro='"'+camposColeccion.itemAt(nItem).name+'":"'+escaparEnter(valor)+'"';
                            else
                                objRegistro+=',"'+camposColeccion.itemAt(nItem).name+'":"'+escaparEnter(valor)+'"';
                           	
                        }
                        objRegistro='{'+objRegistro+'}';
                        if(listRegistros=='')
                            listRegistros=objRegistro;
                        else
                            listRegistros+=','+objRegistro;
                    	
                            
                    }
                }     
            	objCampo='{"idElemento":"'+(aCamposGrid[ct].split('_'))[1]+'","objGrid":['+listRegistros+']}';
                if(cadArrObjCamposGrid=='')
                	cadArrObjCamposGrid=objCampo;
                else
                	cadArrObjCamposGrid+=','+objCampo;
           	}

            if(cadArrObjCamposGrid!='')
	            gE('objCamposGrid').value=bE('['+cadArrObjCamposGrid+']');
        }
		
         
    	if(existeTabla==1)
        {
        	if(funcionValidacion2==null)
            {
            	var x;
                prepararFormularioEnvio(idContenedor);
            }
            else
            {
                funcionValidacion2();
            }
        	
        }
        else
        {
            function funcResp()
            {
                arrResp=peticion_http.responseText.split('|');
                if(arrResp[0]=='1')
                {
                    if(funcionValidacion2==null)
                    {
                    	prepararFormularioEnvio(idContenedor);
                        
                    }
                    else
                    {
                        funcionValidacion2();
                    }
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=11&idFormulario='+idFormulario,true);
		}
       
	    	
    }
}

function prepararFormularioEnvio(idContenedor)
{
	var x;
    var frmEnvio;
    frmEnvio=gE('frmEnvio');
    
    var urlEnvio=frmEnvio.action;
    var arrUrl=urlEnvio.split('?');
    var token;
    var id;
    var valor;
    var pos;
    var hidden;
    if(arrUrl.length>1)
    {
    	arrParam=arrUrl[1].split('&');
        for(x=0;x<arrParam.length;x++)
        {
        	token=arrParam[x];
           	pos=token.indexOf('=');
            id=token.substr(0,pos);
            valor=token.substr(pos+1);
            hidden=gE(id);
            if(hidden)
            {
            	hidden.value=valor;
            }
            else
            {
                hidden=cE('input');
                hidden.type='hidden';
                hidden.value=valor;
                hidden.name=id;
                frmEnvio.appendChild(hidden);
            }
        }
        frmEnvio.action=arrUrl[0];
    }

    for(x=0;x<controlesOcultos.length;x++)
    {
    	if(gE(controlesOcultos[x])!=null)
        {
            
            hidden=gE(controlesOcultos[x]);
            if(hidden)
            {
            	hidden.value='';
            }
            else
            {
                hidden=cE('input');
                hidden.type='hidden';
                hidden.value='';
                hidden.name=controlesOcultos[x];
                frmEnvio.appendChild(hidden);
           	}
    	}   
    }
    
    
    if(typeof(arrControlesHabilitar)!='undefined')
    {
    	for(x=0;x<arrControlesHabilitar.length;x++)
    	{
        	gE(arrControlesHabilitar[x]).disabled=false;
        }
    
    }
    
    if(gE('evitarCodificacion').value=='1')
    {
    	evitarCodificacionControles('frmEnvio');
    }
    
    
    if(typeof(arrPluginsProceso)!='undefined')
    {
    	var aux=0;
        
        for(aux=0;aux<arrPluginsProceso.length;aux++)
        {
        	if(arrPluginsProceso[aux].prepararGuardado)
            	arrPluginsProceso[aux].prepararGuardado();
        }
    }
    
    gE(idContenedor).submit(); 
}

function evitarCodificacionControles(nContenedor)
{
	
	var contenedor=document.getElementById(nContenedor);
	return comenzarDescodificacionControles(contenedor);
}

function comenzarDescodificacionControles(contenedor)
{
	var x;
	var control;
	for(x=0;x<contenedor.childNodes.length;x++)
	{
		control=contenedor.childNodes[x];
		
		if((control.id!=null)&&(typeof(control.id)!='undefined')&&(typeof(control.name)!='undefined')&&(control.id.substr(0,1)=='_'))
		{
        	
			control.name=control.name.substr(1,control.name.length-4);
            if(control.getAttribute('multiple'))
            	control.name+='[]';
            

		}
		if(!comenzarDescodificacionControles(control))
			return false;
	}
    gE('ctrlDecodificado').value=1;
	return true;
}

function recodificacionControles(nContenedor)
{
	
	var contenedor=document.getElementById(nContenedor);
	return comenzarRecodificacionControles(contenedor);
}

function comenzarRecodificacionControles(contenedor)
{
	var x;
	var control;
	for(x=0;x<contenedor.childNodes.length;x++)
	{
		control=contenedor.childNodes[x];
		
		if((control.id!=null)&&(typeof(control.id)!='undefined')&&(control.id.substr(0,1)=='_'))
		{
			control.name=control.id;

		}
		if(!comenzarRecodificacionControles(control))
			return false;
	}
    gE('ctrlDecodificado').value=0;
	return true;
}


function cancelar()
{
	function resp(btn)
	{
    	if(btn=='yes')
        {
        	regresarPagina();
        }
    }
    Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["msgConfCancelarC"] ?>',resp);
}

function cancelarSinConfirmar()
{
	regresarPagina();
}

function crearTabla(nColumnas,datos,tipoControl,nombreCtrl,anchoCelda)
{
	
    
	var table=document.createElement('table');
    table.id='tbl'+nombreCtrl;
    table.style.backgroundColor="#FFF";
    var tbody=document.createElement('tbody');
    table.appendChild(tbody);
    var nCl=0;
    var fila;
    var x;
    var td;
    var opcion;
    var arrDatos=eval(datos);
    var tControl;
    if((tipoControl>=14) && (tipoControl<=16))
    	tControl='radio';
    if((tipoControl>=17) && (tipoControl<=19))
    	tControl='checkbox';

    for(x=0;x<arrDatos.length;x++)
    {
    	if(nCl==0)
        {	
        	fila=document.createElement('tr');
            tbody.appendChild(fila);
        }
        td=document.createElement('td');
        td.setAttribute('class',gE(nombreCtrl).getAttribute('clase'));
        
        opcion=document.createElement('input');
        opcion.type=tControl;
        
        
        if((tipoControl>=14) && (tipoControl<=16))
        {
	    	opcion.name='opt'+nombreCtrl;
            if(navigator.userAgent.indexOf("MSIE")>=0)
            {
                opcion.onclick=	function()
                                        {
                                            return selOpcion(this);
                                        }
                
            }
            else
            {
               opcion.setAttribute('onclick','selOpcion(this)');
            }
            
            
        }
    	if((tipoControl>=17) && (tipoControl<=19))
        {
    		opcion.name='opt_'+nombreCtrl+'[]';
            if(navigator.userAgent.indexOf("MSIE")>=0)
            {
                opcion.onclick=	function()
                                        {
                                            return selCheck(this);
                                        }
                
            }
            else
            {
               opcion.setAttribute('onclick','selCheck(this)');
            }
        }
        opcion.id='opt'+nombreCtrl+'_'+arrDatos[x][0];
        
        
        var et;
       
        opcion.value=arrDatos[x][0];
        et=document.createTextNode(' '+arrDatos[x][1]);
        nCl++;
        td.appendChild(opcion);
        td.appendChild(et);
        td.setAttribute('width',anchoCelda);
        fila.appendChild(td);
        if(nCl==nColumnas)
        	nCl=0;
    }
    return table;
}

function selOpcion(control)
{
	var valor=control.value;
    var nOpcion=control.name;
    var arrNOpcion=nOpcion.split('_');
    var hControl=gE('_'+arrNOpcion[1]);
    hControl.value=control.value;
    lanzarEvento(hControl,'change');
}

function selCheck(control)
{
	var arrControl=control.id.split('_');
    var hElemSel=gE('numSel'+'_'+arrControl[1]);

	var nSel= parseInt(hElemSel.value);
    
    if(control.checked)
    	nSel++;
    else
    	nSel--;
    hElemSel.value=nSel;  
}

function enviarAsociadoNormal(idFrm,idRef,repetible,idReferencia)
{
    if(repetible==1)
    {
		var arrDatos=[['idReferencia',idReferencia],['idFormulario',idFrm]];
        enviarFormularioDatos('../modeloPerfiles/tblFormularios.php',arrDatos);
    }
    else
    {
    	var paginaDest;
    	if(idRef==-1)
        	paginaDest='../modeloPerfiles/registroFormulario.php';
        else
        	paginaDest='../modeloPerfiles/verFichaFormulario.php';

   		var arrDatos=[['idRegistro',idRef],['idFormulario',idFrm],['idReferencia',idReferencia]];
        enviarFormularioDatos(paginaDest,arrDatos);
    }
    
	
}

function crearTextoEnriquecido(id,idDivDestino,ancho,alto,valor)
{
	var valor=bD(valor);
	valor=valor.replace(/\n/gi, '');
    valor=valor.replace(/\r/gi, '');
    
    var texto=crearRichText(id,idDivDestino,ancho,alto,'',valor);
    
}

function evaluarExpresion(control)
{

	var hExpresion=gE('exp_'+control);
    
    var arrExpresion=eval(hExpresion.value);
    var x;
    var expresionFinal='';
    for(x=0;x<arrExpresion.length;x++)
    {
    	if(arrExpresion[x][2]=='1')
        	expresionFinal+=arrExpresion[x][0];
        else
        {
        	if(arrExpresion[x][2]=='2')
            {
            	var valor=normalizarValor(obtenerValorCampo(arrExpresion[x][0]));
                

                if (valor=="")
                	valor=0;
                expresionFinal+=valor;
            }
        }
    }
	try
    {
    	if(expresionFinal=='')
        	expresionFinal='0';
    	var resultado=eval(expresionFinal);
    }
    catch(e)
    {
    	var resultado='NaN';
    }
    var nDecimales=gE('numD_'+control).value;
    
    var nDecimales=gE('numD_'+control).value;
    var separadorMiles=gE('sepMiles_'+control).value;
    var separadorDecimales=gE('sepDec_'+control).value;
    var tratoDecimales=gE('tratoDec_'+control).value;
    var truncar=false;
    if(tratoDecimales=='2')
    	truncar=true;
    var lblEtControl=gE('lbl_'+control);
    lblEtControl.innerHTML=formatearNumero(resultado,nDecimales,separadorDecimales,separadorMiles,truncar);
    if(lblEtControl.getAttribute('funcionCambio'))	
    {
    	eval(lblEtControl.getAttribute('funcionCambio')+'(lblEtControl);');
    }
    var ptrControl=gE(control);
    ptrControl.value=resultado;
    lanzarEvento(ptrControl,'change');
    
}

function establecerValorCtrlFormula(control,resultado)
{
	var nDecimales=gE('numD_'+control).value;
    var nDecimales=gE('numD_'+control).value;
    var separadorMiles=gE('sepMiles_'+control).value;
    var separadorDecimales=gE('sepDec_'+control).value;
    var tratoDecimales=gE('tratoDec_'+control).value;
    var truncar=false;
    if(tratoDecimales=='2')
    	truncar=true;
	gE('lbl_'+control).innerHTML=formatearNumero(resultado,nDecimales,separadorDecimales,separadorMiles,truncar);	
    var ptrControl=gE(control);
    ptrControl.value=resultado;
    lanzarEvento(ptrControl,'change');
}

function obtenerValorCampo(campo)
{
	
   	var control=gE(campo);
    if(!control)
    	return '';
    var tipo=control.nodeName;
	try
    {
        switch(tipo)
        {
            case 'TEXTAREA':
            case 'INPUT':
                return control.value;
            break;
            case 'SELECT':
            	if(control.selectedIndex==-1)
                	return -840510;
                if(control.options[control.selectedIndex].getAttribute('valDefault')!=null)
                    return 0
                return control.options[control.selectedIndex].value;
            break;
            case 'SPAN':
            case 'DIV':
                var contenido=control.innerHTML.split('>');
                if(contenido.length>1)
                {
                    contenido=contenido[1].split('<');
                    contenido=contenido[0];
                }
                else
                    contenido=contenido[0];
                
                contenido=contenido.replace(/'/gi,"");
                if(!isNaN(contenido))
                    return contenido;
                else
                    return '0';
            break;
            
        }
    }
    catch(e)
    {
    	if(e)
        {
        }
    }
}

function mostrarVentanaImg(nombreRichText)
{
	
	var tipoImg=parseInt(gE('idFormulario').value)+1000;
	var conf=  	{
                    url:'../media/get-images.php',
                    width:815,
                    height:480,
                    verTiposImg:tipoImg,
                    guardarTipoImg:tipoImg
                }
    editorActivo=nombreRichText;
	showVentanaImagen(conf);                
}

function inserta(datos)
{
	var oEditor=Ext.ux.FCKeditorMgr.get(editorActivo);
	if ( oEditor.EditMode == FCK_EDITMODE_WYSIWYG )
	{
		oEditor.InsertHtml(datos);
	}
} 

function enviarPaginaEnlace(configuracion)
{
	var pagina=arrParamConfiguraciones[configuracion][0];
	var arrParam=arrParamConfiguraciones[configuracion][1];
	enviarFormularioDatos(pagina,arrParam);
}

function limpiarControl(nControlAux,tipo)
{
	switch(tipo)
    {
    	case 2:
        case 3:
		case 5:
		case 6:
		case 7:
		case 9:
		case 11:
        case 12:
        	var ctrlAux=gE(nControlAux);
            ctrlAux.value='';
		break;
        case 14:
        case 15:
        case 16:
        	var ctrlAux=gE(nControlAux);
            ctrlAux.value='';
        case 17:
        case 18:
        case 19:
        	var lista_rdo=gE('lista'+nControlAux).value;                        	
            var arrElementos=eval(lista_rdo);
            var x;
            var idElemento;
            for(x=0;x<arrElementos.length;x++)
            {
                idElemento='opt'+nControlAux+'_'+arrElementos[x][0];
				gE(idElemento).checked=false;
            }
        break;
        case 4:
        	var ctrlAux=gE(nControlAux);
        	var combo=Ext.getCmp('ext_'+nControlAux);
            if(combo!=null)
            {
                combo.setValue('');
                ctrlAux.value='';
            }
            else
            {
                ctrlAux.selectedIndex=-1;
            }
        break;
        case 10:
        	var texto=Ext.getCmp(nControlAux);
			texto.setValue('');
        break;
        case 8:
        case 21:
	        var ctrlAux=Ext.getCmp('f_sp'+nControlAux);
            if(ctrlAux!=null)
	        	ctrlAux.setValue('');
            ctrlAux=gE(nControlAux);
            ctrlAux.value='';
        break;
         
	}
}

function desHabilitarControl(nControlAux,tipo,idCtrl)
{
	
	switch(tipo)
    {
    	case 2:
        case 3:
		case 5:
		case 6:
		case 7:
		case 9:
		case 11:
        case 12:
        case 24:	
        	var ctrlAux=gE(nControlAux);
            ctrlAux.disabled=true;
            ctrlAux.value='';
            var attrVal=ctrlAux.getAttribute('val');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('valAux',attrVal);
                ctrlAux.removeAttribute('val');
            }
            var frmEnvio=gE('frmEnvio');
            ctrlAux.name='';
            var hidden;
            hidden=gE('h'+nControlAux);
            if(hidden!=null)
            {
                hidden=cE('input');
                hidden.type='hidden';
                hidden.id='h'+nControlAux;
                hidden.name=nControlAux;
                frmEnvio.appendChild(hidden);
                 hidden.value='';
            }
           

		break;
        case 14:
        case 15:
        case 16:
        	var lista_rdo=gE('lista'+nControlAux).value;                        	
            var arrElementos=eval(lista_rdo);
            var x;
            var idElemento;
            for(x=0;x<arrElementos.length;x++)
            {
                idElemento='opt'+nControlAux+'_'+arrElementos[x][0];
				gE(idElemento).disabled=true;
            }
            var ctrlAux=gE(nControlAux);
            var attrVal=ctrlAux.getAttribute('val');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('valAux',attrVal);
                ctrlAux.removeAttribute('val');
            }
        break;
        case 17:
        case 18:
        case 19:
        	var lista_rdo=gE('lista'+nControlAux).value;                        	
            var arrElementos=eval(lista_rdo);
            var x;
            var idElemento;
            for(x=0;x<arrElementos.length;x++)
            {
                idElemento='opt'+nControlAux+'_'+arrElementos[x][0];
				gE(idElemento).disabled=true;
            }
            var numSelMin=gE('numSel'+nControlAux);
            
            numSelMin.setAttribute('numSelAux',numSelMin.value);
            numSelMin.value=0;
        break;
        case 4:
        	var ctrlAux=gE(nControlAux);
        	var combo=Ext.getCmp('ext_'+nControlAux);
            if(combo!=null)
                combo.disable();
            else
            {
                ctrlAux.disabled=true;
                var frmEnvio=gE('frmEnvio');
                ctrlAux.name='';
                var hidden;
                hidden=gE('h'+nControlAux);
                if(hidden==null)
                {
                    hidden=cE('input');
                    hidden.type='hidden';
                    hidden.id='h'+nControlAux;
                    hidden.name=nControlAux;
                    frmEnvio.appendChild(hidden);
                }
                hidden.value='';
            }
            
            var attrVal=ctrlAux.getAttribute('val');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('valAux',attrVal);
                ctrlAux.removeAttribute('val');
            }
        break;
        case 10:
        	var texto=Ext.getCmp(nControlAux);
			var editorInterno=texto.getInnerEditor();
            texto.disable();
			editorInterno.EditorDocument.body.disabled=true;
            var ctrlAux=gE(nControlAux);
            var attrVal=ctrlAux.getAttribute('val');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('valAux',attrVal);
                ctrlAux.removeAttribute('val');
            }
            Ext.getCmp(nControlAux).disable();
        break;
        case 8:
        case 21:
        	var control=Ext.getCmp('f_sp'+nControlAux);
            if(control!=undefined)
	        	control.disable();
            var ctrlAux=gE(nControlAux);
            var attrVal=ctrlAux.getAttribute('val');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('valAux',attrVal);
                ctrlAux.removeAttribute('val');
            }
        break;
        case 29:
        	var ctrl=gEN(nControlAux)[0];
            var arrDatos=ctrl.id.split('_');	
            var idCtrl=arrDatos[1];
            gEx('grid_'+idCtrl).disable();
        break;
         
	}
    limpiarControl(nControlAux,tipo);
}

function habilitarControl(nControlAux,tipo,idCtrl)
{
	switch(tipo)
    {
    	case 2:
        case 3:
		case 5:
		case 6:
		case 7:
		case 9:
		case 11:
        case 12:
        case 24:
        	var ctrlAux=gE(nControlAux);
            ctrlAux.disabled=false;
            var attrVal=ctrlAux.getAttribute('valAux');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('val',attrVal);
                ctrlAux.removeAttribute('valAux');
            }
			var hidden=gE('h'+nControlAux);
            if(hidden!=null)
            {
                hidden.parentNode.removeChild(hidden);
            }
            ctrlAux.name=nControlAux;
		break;
       
        case 14:
        case 15:
        case 16:
        	var lista_rdo=gE('lista'+nControlAux).value;                        	
            var arrElementos=eval(lista_rdo);
            var x;
            var idElemento;
            for(x=0;x<arrElementos.length;x++)
            {
                idElemento='opt'+nControlAux+'_'+arrElementos[x][0];
				gE(idElemento).disabled=false;
            }
            var ctrlAux=gE(nControlAux);
            var attrVal=ctrlAux.getAttribute('valAux');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('val',attrVal);
                ctrlAux.removeAttribute('valAux');
            }
        break;
        case 17:
        case 18:
        case 19:
        	
        	var lista_rdo=gE('lista'+nControlAux).value;                        	
            var arrElementos=eval(lista_rdo);
            var x;
            var idElemento;
            for(x=0;x<arrElementos.length;x++)
            {
                idElemento='opt'+nControlAux+'_'+arrElementos[x][0];
				gE(idElemento).disabled=false;
            }
            var numSelMin=gE('numSel'+nControlAux);
            
            numSelMin.setAttribute('numSelAux',numSelMin.value);
            numSelMin.value=0;
        break;
        case 4:
        	var ctrlAux=gE(nControlAux);
        	var combo=Ext.getCmp('ext_'+nControlAux);
            if(combo!=null)
                combo.enable();
            else
            {
                ctrlAux.disabled=false;
                var hidden=gE('h'+nControlAux);
                if(hidden!=null)
                {
                	hidden.parentNode.removeChild(hidden);
                }
                ctrlAux.name=nControlAux;
            }
            
            var attrVal=ctrlAux.getAttribute('valAux');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('val',attrVal);
                ctrlAux.removeAttribute('valAux');
            }
        break;
        case 10:
        	var texto=Ext.getCmp(nControlAux);
			var editorInterno=texto.getInnerEditor();
            texto.disable();
			editorInterno.EditorDocument.body.disabled=false;
            var ctrlAux=gE(nControlAux);
            var attrVal=ctrlAux.getAttribute('valAux');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('val',attrVal);
                ctrlAux.removeAttribute('valAux');
            }
            Ext.getCmp(nControlAux).enable();
        break;
        case 8:
        case 21:
        	var control=Ext.getCmp('f_sp'+nControlAux);
            if(control!=undefined)
	        	control.enable();

            var ctrlAux=gE(nControlAux);
            var attrVal=ctrlAux.getAttribute('valAux');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('val',attrVal);
                ctrlAux.removeAttribute('valAux');
            }
        break;
        case 29:
        	var ctrl=gEN(nControlAux)[0];
            var arrDatos=ctrl.id.split('_');	
            var idCtrl=arrDatos[1];
        	gEx('grid_'+idCtrl).enable();
        break;
	}
}

function ocultarControl(nControlAux,tipo,nControl,idCtrl)
{

	if(existeValorArreglo(controlesOcultos,nControlAux)==-1)
		controlesOcultos.push(nControlAux);
	var divCtrlAux=gE('div_'+nControl);
    divCtrlAux.style.display='none';

	switch(tipo)
    {
    	case 2:
        case 3:
		case 5:
		case 6:
		case 7:
		case 9:
		case 11:
        case 12:
        case 24:
        	
        	if(tipo==12)
            {
            	
            	nControlAux=nControlAux.substr(1,nControlAux.length-4);
                
           	}
        	var ctrlAux=gE(nControlAux);
			
            var attrVal=ctrlAux.getAttribute('val');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('valAux',attrVal);
                ctrlAux.removeAttribute('val');
            }
            			
            var frmEnvio=gE('frmEnvio');
            ctrlAux.name='';
            var hidden;
            			
           
		break;
        case 14:
        case 15:
        case 16:
        	var ctrlAux=gE(nControlAux);
            var attrVal=ctrlAux.getAttribute('val');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('valAux',attrVal);
                ctrlAux.removeAttribute('val');
            }
        break;
        case 17:
        case 18:
        case 19:
        	var numSelMin=gE('numSel'+nControlAux);
            numSelMin.setAttribute('numSelAux',numSelMin.value);
            numSelMin.value=0;
        break;
        case 4:
        	var ctrlAux=gE(nControlAux);
        	var combo=Ext.getCmp('ext_'+nControlAux);
            if(combo!=null)
            {
            	ctrlAux.name='';
            }
            else
            {
                var frmEnvio=gE('frmEnvio');
                ctrlAux.name='';
               	var hidden;
            }
            
            var attrVal=ctrlAux.getAttribute('val');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('valAux',attrVal);
                ctrlAux.removeAttribute('val');
            }
        break;
        case 10:
        	var texto=Ext.getCmp(nControlAux);
			var editorInterno=texto.getInnerEditor();
			editorInterno.EditorDocument.body.disabled=true;
            var ctrlAux=gE(nControlAux);
            var attrVal=ctrlAux.getAttribute('val');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('valAux',attrVal);
                ctrlAux.removeAttribute('val');
            }
            Ext.getCmp(nControlAux).disable();
        break;
        case 8:
        case 21:
            var ctrlAux=gE(nControlAux);
            var attrVal=ctrlAux.getAttribute('val');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('valAux',attrVal);
                ctrlAux.removeAttribute('val');
            }
        break;
        case 29:
        	var ctrl=gEN(nControlAux,false)[0];
             
            var arrDatos=ctrl.id.split('_');	
            var idCtrl=arrDatos[1];
            var grid=gEx('grid_'+idCtrl);
            if(grid!=undefined)
	        	grid.hide();
        break;
         
	}

    if((typeof(limpiarValorControl)!='undefined')&&(limpiarValorControl!=false))
	    limpiarControl(nControlAux,tipo);

}

function mostrarControl(nControlAux,tipo,nControl,idCtrl)
{
	var pos=existeValorArreglo(controlesOcultos,nControlAux);
    if(pos!=-1)
    {
    	controlesOcultos.splice(pos,1);
    }
	var divCtrlAux=gE('div_'+nControl);
    divCtrlAux.style.display='';
    
	switch(tipo)
    {
    	case 2:
        case 3:
		case 5:
		case 6:
		case 7:
		case 9:
		case 11:
        case 12:
        case 24:
        	if(tipo==12)
            {
            	
            	nControlAux=nControlAux.substr(1,nControlAux.length-4);
                
           	}
        	var ctrlAux=gE(nControlAux);
            var attrVal=ctrlAux.getAttribute('valAux');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('val',attrVal);
                ctrlAux.removeAttribute('valAux');
            }
			
            ctrlAux.name=nControlAux;
		break;
        case 14:
        case 15:
        case 16:
            var ctrlAux=gE(nControlAux);
            var attrVal=ctrlAux.getAttribute('valAux');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('val',attrVal);
                ctrlAux.removeAttribute('valAux');
            }
        break;
        case 17:
        case 18:
        case 19:
            var numSelMin=gE('numSel'+nControlAux);
            numSelMin.setAttribute('numSelAux',numSelMin.value);
            numSelMin.value=0;
        break;
        case 4:
        	var ctrlAux=gE(nControlAux);
        	var combo=Ext.getCmp('ext_'+nControlAux);
            if(combo!=null)
            {
               
                var hidden=gE('h'+nControlAux);
                if(hidden!=null)
                {
                	hidden.parentNode.removeChild(hidden);
                }
                ctrlAux.name=nControlAux;
            }
            var attrVal=ctrlAux.getAttribute('valAux');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('val',attrVal);
                ctrlAux.removeAttribute('valAux');
            }
            ctrlAux.name=nControlAux;
        break;
        case 10:
        	var ctrlAux=gE(nControlAux);
            var attrVal=ctrlAux.getAttribute('valAux');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('val',attrVal);
                ctrlAux.removeAttribute('valAux');
            }
        break;
        case 8:
        case 21:
            var ctrlAux=gE(nControlAux);
            var attrVal=ctrlAux.getAttribute('valAux');
            if(attrVal!=null)
            {
                ctrlAux.setAttribute('val',attrVal);
                ctrlAux.removeAttribute('valAux');
            }
        break;
        case 29:
        	
        	var ctrl=gEN(nControlAux,false)[0];
            
            var arrDatos=ctrl.id.split('_');	
            
            var idCtrl=arrDatos[1];
        	gEx('grid_'+idCtrl).show();
        break;
         
	}
}

function agregarElemento(iE,nC)
{
	var conf={};
    conf.url='../modeloPerfiles/proxyAgregarCatalogo.php';
    conf.ancho=700;
    conf.alto=420;
    conf.titulo='Agregar';
    conf.params=[['nC',nC],['idElemento',iE],['cPagina','sFrm=true'],['cadObj',gE('cadObj').value]];
    abrirVentanaFancy(conf);
}


function insertarOpcion(ctrl,arreglo,idRegistro,nombreOpt,autoC)
{
   	var cmbDestino;
    if(autoC=='1')
    {
		cmbDestino=gEx('ext_'+ctrl);   
        cmbDestino.setRawValue(nombreOpt);
        gE(ctrl).value=idRegistro;     
    }
    else
    {
    	cmbDestino=gE(ctrl);
        llenarCombo(cmbDestino,arreglo);
        selElemCombo(cmbDestino,idRegistro);
    }
}

function funcionEventoCambio(ctrl,registro)
{

	var nControl='';
    if(registro)
    {
    	nControl=ctrl.id.replace('ext_','');
        nControl=obtenerNombreCtrlOriginal(nControl);
    }
    else
    	nControl=obtenerNombreCtrlOriginal(ctrl.id);
	
    var posControl=existeValorMatriz(matrizControles,nControl);
    var aQueries;
    var posAux;
    var query;
    var dependencias;
    var objAux;
    var arrQueriesResueltas='';
    var queryResuelto;
    var arrControles='';
    var pAux;
    var ctrlQueries;
    var xAux;
    var objCtrl;
    var pTmp;
    var controlFrm;
    var nQuery=0;
    if(pos!=-1)
    {
		aQueries=matrizControles[posControl][1];   
        var x;
        for(x=0;x<aQueries[x];x++) 
		{
        	posAux=existeValorMatriz(arrQueries,aQueries[x]);
            if(posAux!=-1)
            {
            	query=bD(arrQueries[posAux][1]);
               
                dependencias=bD(arrQueries[posAux][2]).split(',');
                queryResuelto=resolverQy(query,dependencias);

                pAux=existeValorMatriz(queriesControles,aQueries[x]);
                if(pAux!=-1)
                {
                	ctrlQueries=queriesControles[pAux][1];
                    arrControles='';
                    for(xAux=0;xAux<ctrlQueries.length;xAux++)
                    {
                    
                    	pTmp=existeValorMatriz(diccionarioCtrl,ctrlQueries[xAux],1);
                        if(pTmp!=-1)
                        {
                        	
                            objCtrl='{"nomCtrlFrm":"'+diccionarioCtrl[pTmp][1]+'","nomCtrlOriginal":"'+diccionarioCtrl[pTmp][0]+'","tipoCtrl":"'+diccionarioCtrl[pTmp][3]+'","idCtrl":"'+diccionarioCtrl[pTmp][2]+'"}';
                            if(arrControles=='')
                                arrControles=objCtrl;
                            else
                                arrControles+=','+objCtrl;
                        }
                    }
                    arrControles='['+arrControles+']';
                }
                nQuery+=aQueries[x];
                
                
                
                objAux='{"idQuery":"'+aQueries[x]+'","qy":"'+cv(bE(queryResuelto))+'","arrControles":'+arrControles+'}';

                if(arrQueriesResueltas=='')
                	arrQueriesResueltas=objAux;
                else
                	arrQueriesResueltas+=','+objAux;
            }
       	}        
        arrQueriesResueltas='{"aQueries":['+arrQueriesResueltas+']}';
        
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            	var obj=eval('['+arrResp[1]+']')[0];	
                var ct=0;
                var o;
                for(ct=0;ct<obj.resultado.length;ct++)
                {
                	o=obj.resultado[ct];
                    controlFrm=gE(o.control);
                    var funcRenderer=controlFrm.getAttribute('funcRenderer');
                    var tieneRenderer=false;
                    if((funcRenderer!=null)&&(funcRenderer!=''))
                    {
                        var posFunc=existeValorMatriz(arrFuncionesRenderer,funcRenderer);
                        if(posFunc!=-1)
                        {
                            eval('funcRenderer='+arrFuncionesRenderer[posFunc][1]+';');
                            tieneRenderer=true;
                        }
                    }
                    switch(o.tipoCtrl)
                    {
                    	case '4':
                        	
							if(tieneRenderer)
                            {
                            	
                            	var ctAux;
                                for(ctAux=0;ctAux<o.valor.length;ctAux++)
                                {
                                	o.valor[ctAux][1]=funcRenderer(o.valor[ctAux][1]);
                                }
                            }
                        	llenarCombo(controlFrm,o.valor,true);
                            lanzarEvento(controlFrm,'change');
                        break;
                        case '5':
                        case '6':
                        case '7':
                        case '9':
                        case '11':
                        case '24':
                        	if(tieneRenderer)
	                            controlFrm.value=funcRenderer(o.valor,controlFrm);
                            else
                            	controlFrm.value=o.valor;
                        	lanzarEvento(controlFrm,'blur');
                        break;
                        case '8':
                        	var dteFecha=null;
                        	var lblFecha='';
                        	var arrValores=o.valor.split(' ');
                           	if(arrValores[0].indexOf('/')!=-1)
                               	dteFecha=Date.parseDate(arrValores[0],'d/m/Y');
                            else
                            	if(arrValores[0].indexOf('-')!=-1)
                                	dteFecha=Date.parseDate(arrValores[0],'Y-m-d');
                            if(dteFecha!=null)    
                            {
                                var ctrlFecha=gEx('f_sp'+o.control);
                                ctrlFecha.setValue(dteFecha.format('Y-m-d'));
                                ctrlFecha.fireEvent('change',ctrlFecha,ctrlFecha.getValue());
							}                        
                        break;
                        case '21':
                        	var lblHora='';
                        	var arrValores=o.valor.split(' ');
                            if(arrValores.length>1)
                            {
                            	if(arrValores[1].indexOf(':')!=-1)
                                {
                                	var arrFomato=arrValores[1].split(":");
                                    var hora;
                                    lblHora=arrFomato[0]+':'+arrFomato[1];
                                    
                                }
                            }
                            else
                            {
                            	if(arrValores[0].indexOf(':')!=-1)
                                {
                                	var arrFomato=arrValores[0].split(":");
                                    var hora;
                                    lblHora=arrFomato[0]+':'+arrFomato[1];
                                    
                                }
                            }
                            var ctrlFecha=gEx('f_sp'+o.control);
                            ctrlFecha.setValue(lblHora);
                            dispararEventoSelectCombo('f_sp'+o.control);
                        
                        break;
                        case '16':
                        case '19':
                        	
                        	if(tieneRenderer)
                            {
                            	var ctAux;
                                for(ctAux=0;ctAux<o.valor.length;ctAux++)
                                {
                                	o.valor[ctAux][1]=funcRenderer(o.valor[ctAux][1]);
                                }
                            }
                        	generarOpcionesRadioCheck(o.controlOriginal,o.valor,o.tipoCtrl);
                        break;
                        case '30':
                        	pTmp=existeValorMatriz(diccionarioCtrl,o.control,1);
                            var iCtrl=diccionarioCtrl[pTmp][2];
                            var ctrlDestino= gE('sp_'+iCtrl);
							if(tieneRenderer)
	                            ctrlDestino.innerHTML=funcRenderer(o.valor,ctrlDestino);
                            else
                            	ctrlDestino.innerHTML=o.valor;
                        break;
                    }
                }
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=72&nQuery='+nQuery+'&aQ='+arrQueriesResueltas,true);
    }
}

function obtenerNombreCtrlOriginal(nCtrl)
{
	return nCtrl.substr(1,nCtrl.length-4);
}

function resolverQy(qy,dependencias)
{
	var x;
    var pos;
    var valor;
    var campo;
    var cadReemplazo;
    var re;
    var query=qy;
    var idControl;
    for(x=0;x<dependencias.length;x++)
    {
    	pos=existeValorMatriz(matrizControles,dependencias[x]);
        if(pos!=-1)
        {
        	campo=matrizControles[pos][2];
            idControl=matrizControles[pos][3];
        	valor=obtenerValorCampo(campo);
            cadReemplazo='@Control_'+idControl;
            re=new RegExp (cadReemplazo, 'gi') ; 
            query=query.replace(re,valor);
        }	
    }

    return query;
}

function obtenerControlesVinculadosQuery(iQ)
{

}

function generarOpcionesRadioCheck(cDestino,valores,tipoControl)
{
	var nomNCol;
	var nColumnas;
	var anchoCol;
	var tblDestino;
	var nomDestino;
	if((tipoControl>=14)&&(tipoControl<=16))
	{
		nomDestino='_'+cDestino+'vch';
		nomNCol='nColumnas_'+cDestino+'vch';
		nColumnas=gE(nomNCol).value;
		anchoCol=gE('ancho_'+cDestino+'vch').value;
		tblDestino=gE('tbl_'+cDestino+'vch');
		gE(nomDestino).value='-1';
	}
	else
	{
		if((tipoControl>=17)&&(tipoControl<=19))
		{
			nomDestino='_'+cDestino+'arr';
			nomNCol='nColumnas_'+cDestino+'arr';
			nColumnas=gE(nomNCol).value;
			anchoCol=gE('ancho_'+cDestino+'arr').value;
			tblDestino=gE('tbl_'+cDestino+'arr');
		}
	}
	
    var arrOpciones=valores;
    var numOpt=arrOpciones.length;
    var x;
    var opt;
    var ct=0;
    
    var padre=tblDestino.parentNode;
    padre.removeChild(tblDestino);
    
    var tablaCtrl=crearTabla(nColumnas,arrOpciones,tipoControl,nomDestino,anchoCol);
    padre.appendChild(tablaCtrl);
}

function asignarValorFormatoRenderer(idRenderer,tControl,nombreControl,idCtrl)
{
	var control;
	var funcRenderer=rendererNulo;
    var posFunc=existeValorMatriz(arrFuncionesRenderer,idRenderer);
    if(posFunc!=-1)
    {
        eval('funcRenderer='+arrFuncionesRenderer[posFunc][1]+';');
        
    }
	switch(tControl)	
    {
    	case -1:
        	var arrElementos=gEN(nombreControl);
            var ct;
            for(ct=0;ct<arrElementos.length;ct++)
            {
            	arrElementos[ct].innerHTML=funcRenderer(arrElementos[ct].innerHTML,arrElementos[ct]);
            }
        break;
    	case 0:
        	gE(nombreControl).innerHTML=funcRenderer(gE(nombreControl).innerHTML,gE(nombreControl));
        break;
    	case 2:
        case 3:
        case 4:
        	var combo=gE(nombreControl);
            var ct;
            for(ct=0;ct<combo.options.length;ct++)
            {
            	var et=combo.options[ct].text;
                
                if(et!='Elija una opción')
                {
                	combo.options[ct].setAttribute('opcionOriginal',combo.options[ct].text);
                	combo.options[ct].text=funcRenderer(combo.options[ct].text,combo.options[ct]);
                }
            }
        break;
        case 14:
        case 15:
        case 16:
        case 17:
        case 18:
        case 19:
        	var arrElementos=gEN('et'+nombreControl);
            var ct;
            for(ct=0;ct<arrElementos.length;ct++)
            {
	            arrElementos[ct].innerHTML=funcRenderer(arrElementos[ct].innerHTML,arrElementos[ct]);
            }
            
        break;
    	case 30:
        	control=gE('sp_'+idCtrl);
            control.innerHTML=funcRenderer(control.innerHTML,control);
        break;
    }
}

function textoBotonRenderer(val)
{
	if(val!='')
    {
    	var url='';
    	var arrDatos=val.split('|');
        return '<a href="javascript:obtenerArchivo(\''+bE(arrDatos[1])+'\',\''+bE(arrDatos[0])+'\')"><img width="13" height="13" src="../images/download.png">&nbsp;&nbsp;'+arrDatos[0]+'</a>';
    }
    return '';
}

function obtenerArchivo(archivo,nArchivo)
{
	var arch=bD(archivo);
    if(arch.indexOf('_')==-1)
    {
    	var arrParam=[['id',archivo]];
        enviarFormularioDatos('../paginasFunciones/obtenerArchivos.php',arrParam,'GET');
    }
    else
    {
    	var arrParam=[['iD',archivo],['nA',nArchivo]];
        enviarFormularioDatos('../media/obtenerDocumentoTemporal.php',arrParam,'POST');
    }
    
    
}

function generarGaleriaImagen(aImagenes,idCtrl,ancho,alto)
{
	var lblGaleria='<div class="slider_'+idCtrl+'"><ul>';
    var x;
    for(x=0;x<aImagenes.length;x++)
    {
    	if(aImagenes[x].idArchivo!='-1')
	    	lblGaleria+='<li><img src="../paginasFunciones/obtenerArchivos.php?id='+bE(aImagenes[x].idArchivo)+'" /></li>';
        else
        	lblGaleria+='<li><img src="'+aImagenes[x].imagen+'" /></li>';
    }
                        
    lblGaleria+='</ul></div>';
	gE('sp_'+idCtrl).innerHTML=lblGaleria;

	var config={};
    config.width =ancho;  //pixels
    config.height=alto;  //pixels 
    config.intervalTime  =10000; //mili-seconds   
    
    $('.slider_'+idCtrl).cleanSlider(config);
}


function abrirAdmonGaleria(iC)
{
	
    mostrarGaleria(iC);
}



function registrarPluginProceso(p)
{
	if(typeof(arrPluginsProceso)=='undefined')
    {
    	window.arrPluginsProceso=[];
    }
    
    arrPluginsProceso.push(p);
}