<?php session_start();
include("conexionBD.php"); 
include("configurarIdiomaJS.php");
?>

function setAncho(ancho)
{
	
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gE('tdContenedor').style.width=ancho+'px';
            gE('frameTitulo').style.width=ancho+'px';
            gE('tblGrid').style.width=ancho+'px';
            maxX=ancho+posDivX;
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=23&ancho='+ancho+'&idFormulario='+idFormulario,true);
}

function setAlto(alto)
{
     function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	gE('tdContenedor').style.height=alto+'px';
            gE('frameTitulo').style.height=alto+'px';
            gE('tblGrid').style.height=alto+'px';
            maxY=alto+posDivY-valorCompensacionY;
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
     obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=24&alto='+alto+'&idFormulario='+idFormulario,true);
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
    if(estado==2)
    {
		xActual=obtenerPosXMouse(event);
        yActual=obtenerPosYMouse(event);
	   
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
	if(((parseInt(ultimaPosX)<0)||(parseInt(ultimaPosY)<0))&&(gE(idDivSel).getAttribute('tipoCtrl')!='-2'))
    {
    	
    	return;
    }
	var arrDiv=idDivSel.split('_');
	var idElemento=arrDiv[1];
	var objPos='{"posX":"'+ultimaPosX+'","posY":"'+ultimaPosY+'","idElemento":"'+idElemento+'"}';
	function funcResp()
    {
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
        	ultimaPosX=undefined;
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=9&param='+objPos,true);
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

function insertarControlClick(x,y,idPadre)
{
	var posXCtrl=x;
    var posYCtrl=y;
    objControl=objControl.replace('@posX',posXCtrl);
    objControl=objControl.replace('@posY',posYCtrl);
    objControl=objControl.replace('@idPadre',idPadre);
   	guardarPregunta(objControl);
   	
}
