<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=$_GET["iF"];
	$idRegistro=$_GET["iR"];
	
	$tamMinimoCanvas=900;
	$margenDibujo=140;
	$tamBloque=200;
	$separacionBloque=25;
	
	$consulta="SELECT idRegistro,causa FROM 3218_arbolPCausas WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro."";
	$arrCausas=$con->obtenerFilasArreglo($consulta);	
	$nCausas=$con->filasAfectadas;
		
	$consulta="SELECT idRegistro,efecto FROM 3217_arbolPEfectos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
	$arrEfectos=$con->obtenerFilasArreglo($consulta);
	$nEfectos=$con->filasAfectadas;
	
	$consulta="SELECT idRegistro,problemaCentral FROM 3216_arbolPProblemaCentral WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
	$fProblema=$con->obtenerPrimeraFila($consulta);
	
	$baseCalculo=$nCausas>$nEfectos?$nCausas:$nEfectos;

	$margenPerdidaDibujo=$margenDibujo+($separacionBloque*($baseCalculo-1));
	
	if((($tamBloque * $baseCalculo)+$margenPerdidaDibujo)<$tamMinimoCanvas)
	{
		if($baseCalculo>0)
			$tamBloque=($tamMinimoCanvas-$margenPerdidaDibujo)/$baseCalculo;
	}
	
	
	$tamTotal=$margenDibujo+($baseCalculo*$tamBloque)+($separacionBloque*($baseCalculo-1));
	
	$tamProblema=$tamTotal-($tamBloque*6);
	if($tamProblema<500)
		$tamProblema=500;
?>
var contextCanvas=null;
var objSeleccionado=null;
var arrObjetos=[];
var tamTotalY=0;
var idProblemaCentral='<?php echo cv($fProblema[0])?>';
var problemaCentral='<?php echo cv($fProblema[1])?>';
var posYCausa=0;
var tamLetra=12;
var tamInterlineado=tamLetra*1.5;

var margenDerecho=10;
var margenIzquierdo=10;
var margenSuperior=15;
var margenInferior=15;

var tamBloque=<?php echo $tamBloque?>;
var separacionBloque=<?php echo $separacionBloque?>;
var separacionInterBloque=90;

var arrEfectos=<?php echo $arrEfectos?>;
var nEfectos=<?php echo $nEfectos ?>;

var arrCausas=<?php echo $arrCausas?>;
var nCausas=<?php echo $nCausas ?>;
var tamTotal=<?php echo $tamTotal?>;

var maxYCausa=0;
var maxYEfecto=0;
var maxProblemaCentral=<?php echo $tamProblema?>;

var tamProblema=<?php echo $tamProblema?>;

var arrObjCausas=[];
var arrObjEfectos=[];
var objProblemaCentral={};


Ext.onReady(inicializar);

function inicializar()
{
	var canvas = document.getElementById("myCanvas");
	var ctx = canvas.getContext("2d");
    contextCanvas=ctx;
    ctx.font=tamLetra+"pt Times New Roman, serif ";
    
    var tamY;
    var x=0;
    var obj;
    //Causas
   
    for(x=0;x<nCausas;x++)
    {
    	tamY=estimarWrapText(escaparBR(arrCausas[x][1],true),tamBloque-margenIzquierdo-margenDerecho,tamInterlineado,ctx);
        tamY+=tamLetra+margenInferior;
        if(maxYCausa<tamY)
        	maxYCausa=tamY;
        
        obj=	{
        			texto:Ext.util.Format.stripTags(arrCausas[x][1].trim(),true),
                    posX:0,
                    posY:0,
                    tipo:'C',
                    id:arrCausas[x][0],
                    color:'#FFB758'
        		};
        arrObjCausas.push(obj);
        
    }
    
    //Efectos
   
    for(x=0;x<nEfectos;x++)
    {
    	tamY=estimarWrapText(escaparBR(arrEfectos[x][1],true),tamBloque-margenIzquierdo-margenDerecho,tamInterlineado,ctx);
        tamY+=tamLetra+margenInferior;
        if(maxYEfecto<tamY)
        	maxYEfecto=tamY;
            
       	obj=	{
                    texto:Ext.util.Format.stripTags(arrEfectos[x][1].trim(),true),
                    posX:0,
                    posY:0,
                    tipo:'E',
                    id:arrEfectos[x][0],
                    color:'#9FFC9F'
        		};
        arrObjEfectos.push(obj);     
            
        
    }

    problemaCentral=Ext.util.Format.stripTags(problemaCentral.trim());
    
    var tamReal=ctx.measureText(problemaCentral,true);
    
    if(tamReal.width<tamProblema)
    {
    	tamProblema=tamReal.width+margenIzquierdo+margenDerecho;
    }

    maxProblemaCentral=estimarWrapText(problemaCentral,tamProblema-margenIzquierdo-margenDerecho,tamInterlineado,ctx);
    maxProblemaCentral+=tamLetra+margenInferior;
    
    tamTotalY+=maxYCausa+maxYEfecto+maxProblemaCentral+(separacionInterBloque*2)+<?php echo $margenDibujo?>;
    canvas.width=tamTotal;
    canvas.height=tamTotalY;
    if(parseInt(canvas.width)<980)
    {
    	canvas.style.left=(980/2)-parseInt(tamTotal)/2;
    }
    inicializarEventoClickCanvas(canvas);
    var posYCentral=(tamTotalY/2)-(maxProblemaCentral/2);
    var posXCentral=(tamTotal/2)-(tamProblema/2);
    
    objProblemaCentral.texto=problemaCentral;
    objProblemaCentral.posX=posXCentral;
    objProblemaCentral.posY=posYCentral;
    objProblemaCentral.anchoX=tamProblema;
    objProblemaCentral.id=idProblemaCentral==''?'-1':idProblemaCentral;
    objProblemaCentral.anchoY=maxProblemaCentral;
    objProblemaCentral.posXFinal= objProblemaCentral.posX + objProblemaCentral.anchoX;
    objProblemaCentral.posYFinal=objProblemaCentral.posY + objProblemaCentral.anchoY;
    
   	objProblemaCentral.color='#AFF9FC';
    objProblemaCentral.tipo='P';
    dibujarObjCanvas(objProblemaCentral,ctx);
    arrObjetos.push(objProblemaCentral);
  
    var posInicial=0;
    var calculoPosicion=(tamBloque*arrObjCausas.length)+(separacionBloque*(arrObjCausas.length-1));
    posInicial=(tamTotal/2)-(calculoPosicion/2);
	
    for(x=0;x<arrObjCausas.length;x++)
    {    	
    	arrObjCausas[x].posX=posInicial;
    	arrObjCausas[x].posY=((objProblemaCentral.posY+objProblemaCentral.anchoY)+separacionInterBloque);
        arrObjCausas[x].anchoX=tamBloque;
        arrObjCausas[x].anchoY=maxYCausa;
        
        arrObjCausas[x].posXFinal= arrObjCausas[x].posX + arrObjCausas[x].anchoX;
    	arrObjCausas[x].posYFinal=arrObjCausas[x].posY + arrObjCausas[x].anchoY;
        
        posInicial+=tamBloque+separacionBloque;        
        dibujarObjCanvas(arrObjCausas[x],ctx);
        arrObjetos.push(arrObjCausas[x]);
    }
    
    
    calculoPosicion=(tamBloque*arrObjEfectos.length)+(separacionBloque*(arrObjEfectos.length-1));
    posInicial=(tamTotal/2)-(calculoPosicion/2);
    for(x=0;x<arrObjEfectos.length;x++)
    {
    	arrObjEfectos[x].posX=posInicial;
    	arrObjEfectos[x].posY=(objProblemaCentral.posY-separacionInterBloque-maxYEfecto);
        arrObjEfectos[x].anchoX=tamBloque;
        arrObjEfectos[x].anchoY=maxYEfecto;
        
        arrObjEfectos[x].posXFinal= arrObjEfectos[x].posX + arrObjEfectos[x].anchoX;
    	arrObjEfectos[x].posYFinal=arrObjEfectos[x].posY + arrObjEfectos[x].anchoY;
        
        posInicial+=tamBloque+separacionBloque;
        dibujarObjCanvas(arrObjEfectos[x],ctx);
        arrObjetos.push(arrObjEfectos[x]);
    }
    
    dibujarConectores(ctx);

	if(gE('idNodoEditado').value!='-1')
    {
		switch(gE('tipoNodo').value)
        {
        	case 'C':
            	for(x=0;x<nCausas;x++)
                {
                    if(arrObjCausas[x].id==gE('idNodoEditado').value)
                    {
                    	objSeleccionado=arrObjCausas[x];
            			dibujarObjCanvasSeleccionado(arrObjCausas[x],contextCanvas);
                    	break;
                    }
                    
                }
            break;
            case 'E':
            	for(x=0;x<nEfectos;x++)
                {
                    if(arrObjEfectos[x].id==gE('idNodoEditado').value)
                    {
                    	objSeleccionado=arrObjEfectos[x];
            			dibujarObjCanvasSeleccionado(arrObjEfectos[x],contextCanvas);
                    	break;
                    }
                    
                }
            break;
            case 'P':
            	if(objProblemaCentral.id!='-1')
                {
                    objSeleccionado=objProblemaCentral;
                    dibujarObjCanvasSeleccionado(objProblemaCentral,contextCanvas);
                }
            break;
        }
    }
   
}




function dibujarObjCanvas(o,ctx)
{
	if(o)
    {
    	
       
        ctx.strokeStyle = "#000";
        ctx.lineWidth = 4;
        ctx.strokeRect(o.posX,o.posY,o.anchoX,o.anchoY);
        
    	ctx.fillStyle=o.color;
        ctx.fillRect(o.posX,o.posY,o.anchoX,o.anchoY);
        
        
        
        ctx.fillStyle="#000";
        wrapText(ctx,o.texto,o.posX+margenDerecho,o.posY+margenSuperior,o.anchoX-margenIzquierdo,tamInterlineado);
    }
}

function dibujarObjCanvasSeleccionado(o,ctx)
{
	if(o)
    {
    	window.parent.setObjetoSeleccionado(objSeleccionado);
    	ctx.fillStyle=o.color;
        ctx.fillRect(o.posX,o.posY,o.anchoX,o.anchoY);
        
        ctx.strokeStyle = "#900";
        ctx.lineWidth = 4;
        ctx.strokeRect(o.posX,o.posY,o.anchoX,o.anchoY);
        
	    ctx.fillStyle="#000";
        wrapText(ctx,o.texto,o.posX+margenDerecho,o.posY+margenSuperior,o.anchoX-margenIzquierdo,tamInterlineado);
        
        switch(o.tipo)
        {
        	case 'C':
            	window.parent.habilitarBotonEliminar();
            break;
            case 'E':
            	window.parent.habilitarBotonEliminar();
            break;
            case 'P':
            	if((arrObjCausas.length+arrObjEfectos.length)==0)
	            	window.parent.habilitarBotonEliminar();
            break;
        }
        
    }
    else
    {
    	window.parent.setObjetoSeleccionado(null);
    }
}

function estimarWrapText(text,maxWidth,lineHeight,context)
{
	var y=0;
	var words = text.split(' ');
    var line = '';
    for(var n = 0; n < words.length; n++) 
    {
    	var testLine = line + words[n] + ' ';
        var metrics = context.measureText(testLine);
        var testWidth = metrics.width;
        if (testWidth > maxWidth && n > 0) 
        {
        	line = words[n] + ' ';
            y += lineHeight;
        }
        else 
        {
            line = testLine;
        }
	}
	return y;
}

function wrapText(context,text,x,y,maxWidth,lineHeight)
{
	var words = text.split(' ');
    var line = '';
    for(var n = 0; n < words.length; n++) 
    {
    	var testLine = line + words[n] + ' ';
        var metrics = context.measureText(testLine);
        var testWidth = metrics.width;
        if (testWidth > maxWidth && n > 0) 
        {
        	context.fillText(line, x, y);
            line = words[n] + ' ';
            y += lineHeight;
        }
        else 
        {
            line = testLine;
        }
	}
	context.fillText(line, x, y);
    return y;
}

function dibujarConectores(ctx)
{
	var colorLinea='000';
	var diferenciaY;
    var x;
    
	if(arrObjCausas.length>0)
    {
    	if(arrObjCausas.length==1)
        {
        	var posIniX=objProblemaCentral.posX+(objProblemaCentral.anchoX/2);
            var posIniY=objProblemaCentral.posY+objProblemaCentral.anchoY;
            var posFinX=arrObjCausas[0].posX+(arrObjCausas[0].anchoX/2);
            var posFinY=arrObjCausas[0].posY;
            dibujaLinea(ctx,posIniX,posIniY,posFinX,posFinY,colorLinea);
        }
        else
        {
        	diferenciaY=(arrObjCausas[0].posY-(objProblemaCentral.posY+objProblemaCentral.anchoY))/2;
            
					
            var posIniX=arrObjCausas[0].posX+(arrObjCausas[0].anchoX/2);
            var posFinX=arrObjCausas[arrObjCausas.length-1].posX+(arrObjCausas[arrObjCausas.length-1].anchoX/2);
            var posY=arrObjCausas[0].posY-diferenciaY;
           
            dibujaLinea(ctx,posIniX,posY,posFinX,posY,colorLinea);
            
            
            for(x=0;x<arrObjCausas.length;x++)
            {
            	posIniX=arrObjCausas[x].posX+(arrObjCausas[x].anchoX/2);
            	dibujaLinea(ctx,posIniX,posY,posIniX,arrObjCausas[x].posY,colorLinea);
            }
            posIniX=objProblemaCentral.posX+(objProblemaCentral.anchoX/2);
            dibujaLinea(ctx,posIniX,posY,posIniX,objProblemaCentral.posY+objProblemaCentral.anchoY,colorLinea);
        }
    }

	if(arrObjEfectos.length>0)
    {
    	if(arrObjEfectos.length==1)
        {
        	var posIniX=objProblemaCentral.posX+(objProblemaCentral.anchoX/2);
            var posIniY=objProblemaCentral.posY;
            var posFinX=arrObjEfectos[0].posX+(arrObjEfectos[0].anchoX/2);
            var posFinY=arrObjEfectos[0].posY+arrObjEfectos[0].anchoY;
            dibujaLinea(ctx,posIniX,posIniY,posFinX,posFinY,colorLinea);
        }
        else
        {
        	diferenciaY=(objProblemaCentral.posY-(arrObjEfectos[0].posY+arrObjEfectos[0].anchoY))/2;
            var posIniX=arrObjEfectos[0].posX+(arrObjEfectos[0].anchoX/2);
            var posFinX=arrObjEfectos[arrObjEfectos.length-1].posX+(arrObjEfectos[arrObjEfectos.length-1].anchoX/2);
            var posY=objProblemaCentral.posY-diferenciaY;
           
            dibujaLinea(ctx,posIniX,posY,posFinX,posY,colorLinea);
            
            for(x=0;x<arrObjEfectos.length;x++)
            {
            	posIniX=arrObjEfectos[x].posX+(arrObjEfectos[x].anchoX/2);
            	dibujaLinea(ctx,posIniX,posY,posIniX,(arrObjEfectos[x].posY+arrObjEfectos[x].anchoY),colorLinea);
            }
            posIniX=objProblemaCentral.posX+(objProblemaCentral.anchoX/2);
            dibujaLinea(ctx,posIniX,posY,posIniX,objProblemaCentral.posY,colorLinea);
        }
    }
	
}

function dibujaLinea(ctx,posXIni,posYIni,posXFin,posYFin,color)
{
	ctx.moveTo(posXIni,posYIni);
    ctx.lineTo(posXFin,posYFin);
    ctx.strokeStyle = "#"+(color?color:'000');
    ctx.stroke();

}

function inicializarEventoClickCanvas(e)
{
    
    var  elemLeft = e.offsetLeft,
         elemTop = e.offsetTop,
         context = e.getContext('2d'),
         elements = [];
    

    e.addEventListener('click', function(event) 
                                {
                                	window.parent.desHabilitarBotonEliminar();
                                	dibujarObjCanvas(objSeleccionado,contextCanvas);
                                	objSeleccionado=null;
                                	var encontrado=false;
                                   	var xVal = event.pageX - elemLeft,
                                   	yVal = event.pageY - elemTop;
                                   	var x;
                                   	var o;
                                   	for(x=0;x<arrObjetos.length;x++)
                                   	{
                                   		o=arrObjetos[x];
                                   		if((xVal>=o.posX) &&(xVal<=o.posXFinal))
                                        {
                                        	if((yVal>=o.posY) &&(yVal<=o.posYFinal))
                                            {
                                            	objSeleccionado=o;
                                            	encontrado=true;
                                                
                                                dibujarObjCanvasSeleccionado(objSeleccionado,contextCanvas);
                                            	break;
                                            }
                                        }
                                   	}
                                    
                                    
                                    
                                   
                                }, false);
                                
                                
	
    e.addEventListener('dblclick', function(event) 
                                {
                                	window.parent.desHabilitarBotonEliminar();
                                	dibujarObjCanvas(objSeleccionado,contextCanvas);
                                	objSeleccionado=null;
                                	var encontrado=false;
                                   	var xVal = event.pageX - elemLeft,
                                   	yVal = event.pageY - elemTop;
                                   	var x;
                                   	var o;
                                   	for(x=0;x<arrObjetos.length;x++)
                                   	{
                                   		o=arrObjetos[x];
                                   		if((xVal>=o.posX) &&(xVal<=o.posXFinal))
                                        {
                                        	if((yVal>=o.posY) &&(yVal<=o.posYFinal))
                                            {
                                            	objSeleccionado=o;
                                            	encontrado=true;
                                                dibujarObjCanvasSeleccionado(objSeleccionado,contextCanvas);
                                                window.parent.editarObjeto(objSeleccionado);
                                            }
                                        }
                                   	}
                                    
                                    
                                    
                                   
                                }, false);
                                    
}
      
 