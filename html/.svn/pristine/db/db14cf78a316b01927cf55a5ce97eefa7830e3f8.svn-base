<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	
	$consulta="SELECT nombreCampo FROM 901_elementosFormulario WHERE idFormulario=".$idFormulario." AND tipoElemento=0";
	$lblGuardar=$con->obtenerValor($consulta);
	
	$consulta="SELECT nombreCampo FROM 901_elementosFormulario WHERE idFormulario=".$idFormulario." AND tipoElemento=-1";
	$lblCancelar=$con->obtenerValor($consulta);
	
?>
var arrElementosFocus=new Array();
Ext.onReady(inicializar);
var p;
var objControl='';
var clickCtrl=false;
var controlSel=null;
var tdContenedor=null;
var filaX=null;
var filaY=null;
var navegador;
var posDivX;
var posDivY;
var posicionInicioX;
var posicionInicioY;
var cursorComienzoX;
var cursorComienzoY;
var elComienzoX;
var elComienzoY;
var ultimaPosX;
var ultimaPosY;
var idDivSel='';
var elMovimiento;
var estado=2;
var minX;
var minY;
var maxX;
var maxY;
var altoDiv;
var anchoDiv;
var idDivAnt=null;
var posicion;
var noMovible=false;
var calibrarCtrl=new Array();
var divPadre;
var divPadrePosX;
var divPadrePosY;
var divPadreMaxX;
var divPadreMaxY;
var idFormulario='-1';
var navegador;
var anchoPantalla;
var altoPantalla;
var mitadX;
var mitadY;
var noMovible=false;
var clickCtrl=false;
var idControlSel;
var calibrarCtrl=new Array();
var valorCompensacionY;
var idOrigenD;
var listUsuario;
var listApp;
var arrCampo;
var tipoCampoF;
var filtroUsuario;
var filtroMysql;
var dsDatosCampos;
var arrConsulta;
var arrQueriesResueltas;

function inicializar()
{
	
	$('input[type="file"]').on("click", function(e) 
                                            {
                                            	e.preventDefault();
                                            });
	arrQueriesResueltas=eval(gE('queryResueltas').value);
	valorCompensacionY=32;
	idFormulario=gE('idFormulario').value;
	posDivX=obtenerPosX('tblGrid');
	posDivY=obtenerPosY('tblGrid');
	tdContenedor=gE('tdContenedor');
	p=window.parent;
    var valorAncho=p.gEx('txtAncho').getValue();
    var valorAlto=p.gEx('txtAlto').getValue();
	window.parent.g=window.parent.gEx('tblCenter').getFrameWindow();
    minX=0;
    minY=0;
	maxX=parseInt(valorAncho)+posDivX;
    maxY=parseInt(valorAlto)+posDivY-valorCompensacionY;
    mitadX=(minX+maxX)/2;
    mitadX=mitadX.toFixed();
    mitadY=(minY+maxY)/2;
    mitadY=mitadY.toFixed();
    anchoPantalla=screen.width;
    altoPantalla=screen.height;
    posicion=0;
    
	p.h=p.gEx('tblCenter').getFrameWindow();
    var mostrarMarco=gE('mostrarMarco').value;
    if(mostrarMarco=='0')
    	p.gEx('chkMostrarMarco').setValue(false);
    if(navigator.userAgent.indexOf("Opera")>=0)
    {
    	navegador=0;
    }
    else
        if(navigator.userAgent.indexOf("MSIE")>=0)
        {
            navegador=0;

        }
        else 
        {
            navegador=1;
        }
	var x;
    var arrNElementos=new Array();
    
    var nElemen=gE('hNElementos').value;
    var arrAux;
    for(x=1;x<=nElemen;x++)
    {
    	arrAux=new Array();
    	arrAux.push(x);
        arrAux.push(x);
    	arrNElementos.push(arrAux);
    }
    
    p.gEx('comboNumTab').getStore().loadData(arrNElementos);   
   inicializarControles();
    var x;
   
	calibrarCtrl=eval(gE('calibrarCtrl').value);
   
    for(x=0;x<calibrarCtrl.length;x++)
    {
    	calibrarPosicion(calibrarCtrl[x]);
    }
    
    new Ext.Button (
                                {
                                    icon:'../images/icon_big_tick.gif',
                                    cls:'x-btn-text-icon',
                                    text:'<?php echo ($lblGuardar=="")?"Guardar":$lblGuardar?>',
                                    width:110,
                                    height:30,
                                    renderTo:'contenedor1',
                                    handler:function()
                                            {
                                                validarFrm('frmEnvio')
                                            }
                                    
                                }
                            )
                            
                                    
        new Ext.Button (
                                {
                                    icon:'../images/cross.png',
                                    cls:'x-btn-text-icon',
                                    text:'<?php echo ($lblCancelar=="")?"Cancelar":$lblCancelar?>',
                                    width:110,
                                    height:30,
                                    renderTo:'contenedor2',
                                    handler:function()
                                            {
                                                confirmarCierre();
                                            }
                                    
                                }
                            )
    
}

function mostrarRejila(valor)
{
	var tdContenedor=gE('tdContenedor');
    var atClase;
    var cComp='';
    if(valor)
   	    setClase(tdContenedor,'gridRejilla');
    else
    	setClase(tdContenedor,'gridRejillaSinFondo');
}

function mostrarMarco(valorCheck)
{
	
	var tdContenedor=gE('frameTitulo');
    var atClase;
    var cComp='';
    var valor;

    if(valorCheck)
    {
   	    setClase(tdContenedor,'frameHijo');
        gE('lblLegend').innerHTML='<b>'+gE('titulo').value+'</b>';
        valor=1;
    }
    else
    {
    	setClase(tdContenedor,'gridRejillaSinFondo');
        gE('lblLegend').innerHTML='';
        valor=0;
    }
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=47&idFormulario='+idFormulario+'&valor='+valor,true);

    
}

function mueveMouseSobreGrid(evento,ctrl)
{
	if(objControl!='')
    {
    	if((p.ctrlDestino==null)||(p.ctrlDestino.id==ctrl.id))
        {
            ctrl.style.cursor='crosshair';
            noMovible=true;
        }
        else
        {
        	ctrl.style.cursor='url(../images/no.cur), default';
			noMovible=false;
        }
    }
    else
    {
    	noMovible=false;
    	if(ctrl.id=='tblGrid')
        	ctrl.style.cursor='default';
        else
        	ctrl.style.cursor='move';
    }
}

function saleMouseSobreGrid(evento,ctrl)
{
   	ctrl.style.cursor='default';
}	

function clickGrid(evento,ctrl)
{
	var posX=obtenerPosXMouse(evento);
    var posY=obtenerPosYMouse(evento)
    if(!clickCtrl)
    {
    	desSeleccionarControlSel(true);
    }   
     
    if(objControl!='')
    {
    	var idPadre;
        if(idDivSel!='')
        {
        	var datosDivSel=idDivSel.split('_');
            idPadre=datosDivSel[1];

            var posDivSelX=parseInt(gE(idDivSel).style.left.replace('px',''));
            var posDivSelY=parseInt(gE(idDivSel).style.top.replace('px',''));
            x=posX-posDivSelX;
		    y=posY-posDivSelY;
            
        }
        else
        {
        	idPadre='-1';
            x=posX-posDivX;
            y=posY-posDivY;
        }
    	insertarControlClick(x,y,idPadre);
    }
    clickCtrl=false;
    
}

function desSeleccionarControlSel(liberarCtrlSel)
{
	if(controlSel!=null)
    	controlSel.setAttribute('class','');
    if(liberarCtrlSel != undefined)
    {
    	controlSel=null;
        divSel=null;
        p.establecerFuenteVacia();
    }
    idDivSel='';
}

function crearTextoEnriquecido(id,idDivDestino,ancho,alto,valor,conf,habilitado)
{
	
	var texto=crearRichTextV2(id,idDivDestino,ancho,alto,conf,valor,habilitado);
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
                var valor=obtenerValorCampo(arrExpresion[x][0]);
                if (valor=="")
                    valor=0;
                expresionFinal+=valor;
            }
        }
    }
    try
    {
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
    
    gE('lbl_'+control).innerHTML=formatearNumero(resultado,nDecimales,separadorDecimales,separadorMiles,truncar);	
    var ptrControl=gE(control);
    ptrControl.value=resultado;
    lanzarEvento(ptrControl,'change');
    
}

function obtenerValorCampo(campo)
{
    
    var control=gE(campo);
    var tipo=control.nodeName;
    switch(tipo)
    {
        case 'TEXTAREA':
        case 'INPUT':
            return control.value;
        break;
        case 'SELECT':
            return control.options[control.selectedIndex].value;
        break;
        case 'SPAN':
        	var contenido=control.innerHTML.split('>');
            if(contenido.length>1)
            {
            	contenido=contenido[1].split('<');
                contenido=contenido[0];
            }
            else
            	contenido=contenido[0];
            
            
        	if(!isNaN(contenido))
        		return contenido;
            else
            	return '0';
        break;
    }
}

function doNothing()
{}