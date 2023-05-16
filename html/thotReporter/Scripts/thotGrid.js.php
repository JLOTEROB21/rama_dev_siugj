<?php session_start();
include("conexionBD.php"); 
include("configurarIdiomaJS.php");
?>

Ext.onReady(inicializar);
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
var navegador;
var estado;
var minX;
var minY;
var maxX;
var maxY;
var anchoPantalla;
var altoPantalla;
var posicion;
var altoDiv;
var anchoDiv;
var idDivAnt=null;
var p;
var controlSel=null;
var estado=2;
var mitadX;
var mitadY;
var tdContenedor;
var filaX=null;
var filaY=null;
var idReporte;
var divPadre;
var divPadrePosX;
var divPadrePosY;
var divPadreMaxX;
var divPadreMaxY;
var noMovible=false;
var clickCtrl=false;
var idReporte='-1';
var tdContenedor=null;
var calibrarCtrl=new Array();




var puedeInsertar=false;
function inicializar()
{
	
	inicializarCanvas();
	idReporte=gE('idReporte').value;
	tdContenedor=gE('tdContenedor');
	p=window.parent;
    console.log(p);
	var valorAncho=p.gEx('txtAncho').getValue();
    var valorAlto=p.gEx('txtAlto').getValue();
	window.parent.g=window.parent.gEx('tblCenter').getFrameWindow();
    posDivX=obtenerPosX('tblGrid');
	posDivY=obtenerPosY('tblGrid');
    minX=0;
    minY=0;
	maxX=parseInt(valorAncho);
    maxY=valorAlto;
    mitadX=(minX+maxX)/2;
    mitadX=mitadX.toFixed();
    mitadY=(minY+maxY)/2;
    mitadY=mitadY.toFixed();
    anchoPantalla=screen.width;
    altoPantalla=screen.height;
    posicion=0;
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
   
	calibrarCtrl=eval(gE('calibrarCtrl').value);
   
    for(x=0;x<calibrarCtrl.length;x++)
    {
    	calibrarPosicion(calibrarCtrl[x]);
    }
    
}

function setAncho(ancho)
{
	var idReporte=gE('idReporte').value;
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	//recargarPagina();
            maxX=parseInt(ancho+'');
            gE('tblGrid').style.width=ancho+'px';
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=6&idReporte='+idReporte+'&accion=0&valor='+ancho,true);
}

function setAlto(alto)
{
	var idReporte=gE('idReporte').value;
     function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	gE('tblGrid').style.height=alto+'px';
            maxY=parseInt(alto+'');
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=6&idReporte='+idReporte+'&accion=1&valor='+alto,true);
}

function evitaEventos(event)
{
    if(navegador==0)
    {
        window.event.cancelBubble=true;
        window.event.returnValue=false;
    }
    if(navegador==1) 
    	event.preventDefault();
}

var valCompensacion;
function comienzoMovimiento(event, id)
{
	
	valCompensacion=0;
	clickCtrl=true;
	idDivSel=id;
   	elMovimiento =document.getElementById(id);
    if(elMovimiento.getAttribute('ignorarLimites')==null)
    {
    	seleccionarControl(id);
    }
    
    if(noMovible)
    	return;
    if(elMovimiento.getAttribute('movible')!=null)
    {
    	seleccionarControl(id);
        return;
    }
    altoDiv=elMovimiento.offsetHeight;
    anchoDiv=elMovimiento.offsetWidth;
	posicionInicioX=elMovimiento.style.left;
    posicionInicioY=elMovimiento.style.top;
   
   	cursorComienzoX=obtenerPosXMouse(event);
    cursorComienzoY=obtenerPosYMouse(event);
    if(navegador==0)
    {
        document.attachEvent("onmousemove", enMovimiento);
        document.attachEvent("onmouseup", finMovimiento);
    }
    if(navegador==1)
    {   
        document.addEventListener("mousemove", enMovimiento, true);
        document.addEventListener("mouseup", finMovimiento, true);
    }
   
    elComienzoX=parseInt(elMovimiento.style.left);
    elComienzoY=parseInt(elMovimiento.style.top);
    
    switch(p.tipoControl)
    {
    	case '25':
        	valCompensacion=0;
        break;
    }
    if(elMovimiento.getAttribute('lanzaEvento')==null)
	    evitaEventos(event);
}

function enMovimiento(event)
{ 
	var xActual, yActual;
    xActual=obtenerPosXMouse(event);
    yActual=obtenerPosYMouse(event);
    
    
    
    if(estado==2)
    {
		
	   
        var nuevoX;
        if(divPadre==null)
	        nuevoX=elComienzoX+xActual-cursorComienzoX-posDivX;
        else
        	nuevoX=elComienzoX+xActual-cursorComienzoX;
        var ignorar=elMovimiento.getAttribute('ignorarLimites');
       
        if(ignorar==null)
        {
			if(divPadre==null)
            {
                if(nuevoX<minX)
                    nuevoX=minX;
                if((nuevoX+anchoDiv-valCompensacion)>maxX)
                    nuevoX=maxX-anchoDiv+valCompensacion;
            }
            else
            {
            	if(nuevoX<divPadrePosX)
                    nuevoX=divPadrePosX;
                if((nuevoX+anchoDiv)>divPadreMaxX)
                    nuevoX=divPadreMaxX-anchoDiv;
            }
        }  
        var nuevoY  
        if(divPadre==null)
       		nuevoY=(elComienzoY+yActual-cursorComienzoY-posDivY);
        else
        	nuevoY=(elComienzoY+yActual-cursorComienzoY);
        
        var ignorar=elMovimiento.getAttribute('ignorarLimites');
        if(ignorar==null)
        {
			if(divPadre==null)
            {
                if(nuevoY<minY)
                    nuevoY=minY;
                if((nuevoY+altoDiv)>maxY)
                    nuevoY=maxY-altoDiv;
            }
            else
            {
            	if(nuevoY<divPadrePosY)
                    nuevoY=divPadrePosY;
                if((nuevoY+altoDiv)>divPadreMaxY)
	                nuevoY=divPadreMaxY-altoDiv;
		    }
		}
        
        
        
        if(divPadre==null)
        {
            elMovimiento.style.left=(nuevoX+posDivX)+"px";
            ultimaPosX=nuevoX;
            elMovimiento.style.top=(nuevoY+posDivY)+"px";
            ultimaPosY=nuevoY;
        }
        else
        {
        	elMovimiento.style.left=(nuevoX)+"px";
            ultimaPosX=nuevoX;
            elMovimiento.style.top=(nuevoY)+"px";
            ultimaPosY=nuevoY;
        }
        limpiarContexto();
        dibujarLineaHorizontal(nuevoY);
        dibujarLineaVertical(nuevoX);
        evitaEventos(event);
	}
}

function finMovimiento(event)
{
	if(navegador==0)
    {   
    	document.detachEvent("onmousemove", enMovimiento);
        document.detachEvent("onmouseup", finMovimiento);
	}
    if(navegador==1)
    {
    	document.removeEventListener("mousemove", enMovimiento, true);
        document.removeEventListener("mouseup", finMovimiento, true);
	}
    
    var ignorar=elMovimiento.getAttribute('ignorarLimites');
    
    if(idDivAnt!=null)
    {
    	idDivSel=idDivAnt;
    	idDivAnt=null;
    }
    
    if((ignorar==null)||(ignorar=='actualizar'))
    {
        if(ultimaPosX!=undefined)
        {
            actualizarPosicionElemento();
            if(filaX!=null)
                filaX.set('value',ultimaPosX);
            if(filaY!=null)
                filaY.set('value',ultimaPosY);

        }
    }
     limpiarContexto();
}

function seleccionarControl(id)
{
	var atClase;
	if(controlSel!=null)
    	setClase(controlSel,'');
    var arrDiv=id.split('_');
    idControlSel=arrDiv[1];
	var divSel=gE(id);
    var idPadre=divSel.getAttribute('idPadre');
	if((idPadre==null)||(idPadre=='-1'))
    	divPadre=null;
    else
    	divPadre=gE('div_'+idPadre);
    if(divPadre!=null)
    {
        divPadrePosX=parseInt(divPadre.style.left.replace('px',''));
        divPadrePosY=parseInt(divPadre.style.top.replace('px',''));
        divPadreMaxX=15+divPadrePosX+parseInt(gE('_secc'+idPadre).style.width.replace('px',''));
        divPadreMaxY=divPadrePosY+parseInt(gE('filaPrincipal_'+idPadre).style.height.replace('px',''));
    }
    else
    {
    	divPadrePosX=0;
        divPadrePosY=0;
    }
    
    var arrNomDiv=id.split('_');
    controlSel=gE('td_'+arrNomDiv[1]);
    setClase(controlSel,'seleccionado');
    establecerFuente(id);
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

function establecerFuente(id)
{
	p.establecerFuente(id);
}

function actualizarPosicionElemento()
{
	if(((parseInt(ultimaPosX)<0)||(parseInt(ultimaPosY)<0))&&(gE(idDivSel).getAttribute('tipoCtrl')!='-2')&&(gE(idDivSel).getAttribute('tipoCtrl')!=null))
    {
    	return;
    }
	var arrDiv=idDivSel.split('_');
	var idElemento=arrDiv[1];
    ultimaPosX=ultimaPosX-divPadrePosX;
    ultimaPosY=ultimaPosY-divPadrePosY;
   
	var objPos='{"posX":"'+ultimaPosX+'","posY":"'+ultimaPosY+'","idElemento":"'+idElemento+'"}';
	function funcResp()
    {
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
        	ultimaPosX=undefined;
            actualizarPosicionHijos(eval(arrResp[1]));
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcResp, 'POST','funcion=3&param='+objPos,true);
}

function actualizarPosicionHijos(arrCtrl)
{
    var x;
    for(x=0;x<arrCtrl.length;x++)
    {
		var objHijo=gE('div_'+arrCtrl[x][0]);
        objHijo.style.display='none';
        objHijo.style.left=arrCtrl[x][1]+'px';
        objHijo.style.top=arrCtrl[x][2]+'px';
    	calibrarPosicion(objHijo);
        objHijo.style.display='';

    }
}

function mueveMouseSobreGrid(evento,ctrl)
{
	var ctrlInterno=ctrl.getAttribute('controlInterno');
    var tipoCtrl=null;
    
    var xActual, yActual;
    xActual=obtenerPosXMouse(evento);
    yActual=obtenerPosYMouse(evento);
    
    /*if(dibujarLinea)
    {
    	if(capaActual==null)
        {
        	capaActual=new Kinetic.Layer();
            
        }
        var oLinea={};
        oLinea.x1=posXInicio;
        oLinea.y1=posYInicio;
        oLinea.x2=xActual;
        oLinea.y2=yActual;
        dibujarLinea2P(oLinea,capaActual);
        lienzo.agregarObjeto(capaActual);
    }*/
    
    if(ctrlInterno!=null)
    {
    	var arrCtrl=ctrlInterno.split('_');
       	tipoCtrl=arrCtrl[2];
        	
    }
	if(objControl!='')
    {
    	if(((p.ctrlDestino==null)&&(p.tipoCtrlDestino==null))||((p.ctrlDestino!=null)&&(p.ctrlDestino.id==ctrl.id))||(((p.tipoCtrlDestino!=null)&&(p.tipoCtrlDestino==tipoCtrl))))
        {

            ctrl.style.cursor='crosshair';
            noMovible=true;
            puedeInsertar=true;
           
            
        }
        else
        {
        	ctrl.style.cursor='url(../images/no.cur), default';
			noMovible=false;
            puedeInsertar=false;
        }
    }
    else
    {
    	noMovible=false;
        puedeInsertar=false;
    	if(ctrl.id=='tblGrid')
        	ctrl.style.cursor='default';
        else
        	ctrl.style.cursor='move';
    }

    detenerEvento(evento);

}

function saleMouseSobreGrid(evento,ctrl)
{
   	ctrl.style.cursor='default';
}	

function setCtrlMovible(evento,ctrl)
{
   if(objControl!='')
   {
   		ctrl.style.cursor='url(../images/no.cur), default';
		noMovible=false;
   }
   else
   {
   		noMovible=true;
    	ctrl.style.cursor='move';
   }
}	

function clickGrid(evento,ctrl)
{
	
	var posX=obtenerPosXMouse(evento);
    var posY=obtenerPosYMouse(evento);
    
    if(!clickCtrl)
    {
    	desSeleccionarControlSel(true);
    }   

	if(dibujarLinea)
    {
    	var x,y;
        x=posX-34;
        y=posY-42;
    	if(posXInicio==null)
        {
        	posXInicio=x;
            posYInicio=y;
        }
        else
        {
        	
        	posXFin=x;
            posYFin=y;
            var oLinea={};
            oLinea.x1=posXInicio;
            oLinea.y1=posYInicio;
            oLinea.x2=posXFin;
            oLinea.y2=posYFin;
			capaActual=new Kinetic.Layer();
            dibujarLinea2P(oLinea,capaActual);
            lienzo.agregarObjeto(capaActual);
            dibujarLinea=false;
            posXInicio=null;
        }
    	return;
    }

    if((objControl!='')&&(puedeInsertar))
    {
    	var idPadre;
        if(idDivSel!='')
        {
			var datosDivSel=idDivSel.split('_');
            idPadre=datosDivSel[1];
        	//if((p.ctrlDestino==null)||(p.ctrlDestino.id==idPadre))
            //{
              var posDivSelX=parseInt(gE(idDivSel).style.left.replace('px',''));
              var posDivSelY=parseInt(gE(idDivSel).style.top.replace('px',''));
              x=posX-posDivSelX;
              y=posY-posDivSelY;
    		//}        
        }
        else
        {
        	if(p.ctrlDestino==null)
            {
                idPadre='-1';
                x=posX-posDivX;
                y=posY-posDivY;
        	}
        }
    	insertarControlClick(x,y,idPadre);
    }
    clickCtrl=false;
    
}

function imprimirPagina()
{
}
