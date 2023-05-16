<?php session_start();
	include("configurarIdiomaJS.php");
?>
var tamanoInterlineado=1.2;
var tamanoFormularioBase=820;

var tamanoAncho=612.28;
var relacionEscala;

Ext.onReady(inicializar2);

function inicializar2()
{
	loadScript('../Scripts/jsPDF/FileSaver.js',function(){});
	loadScript('../Scripts/jsPDF/dist/jspdf.min.js',function(){});
	if(gE('pModificar').value=='1')
    {
        new Ext.Button (
                            {
                                //icon:'../images/pencil.png',
                                //cls:'x-btn-text-icon',
                                cls:'btnSIUGJ',
                                text:'Editar registro',
                                width:150,
                                height:45,
                                renderTo:'contenedor1',
                                handler:function()
                                        {
                                            modificarRegistro(gE('idRegistroG').value);
                                        }
                                
                            }
                        )
        
	}
    
    if(gE('pEliminar').value=='1')
    {
        new Ext.Button (
                            {
                                //icon:'../images/cancel_round.png',
                                //cls:'x-btn-text-icon',
                                cls:'btnSIUGJCancel',
                                text:'Eliminar registro',
                                width:170,
                                height:45,
                                renderTo:'contenedor2',
                                handler:function()
                                        {
                                            eliminarRegistro(gE('idRegistroG').value);
                                        }
                                
                            }
                        )
        
	}
    	
     if(gE('pCancelar').value=='1')
    {
        new Ext.Button (
                            {
                                //icon:'../images/cross.png',
                                //cls:'x-btn-text-icon',
                                cls:'btnSIUGJCancel',
                                text:'Cancelar',
                                width:170,
                                height:45,
                                renderTo:'contenedor3',
                                handler:function()
                                        {
                                            regresarPagina();
                                        }
                                
                            }
                        )
        
	}
    
    
}

function modificarRegistro(idRegistro)
{

	var idFormulario=gE('idFormulario').value;
	var arrDatos=[
    				['idRegistro',idRegistro],
                    ['idFormulario',idFormulario],
                    ['paginaRedireccion','../modeloPerfiles/verFichaFormularioV2.php'],
                    ['eJs',gE('eJs').value],
                    ['actor',gEN('actorProceso')[0].value]
                 ];
	enviarFormularioDatos('../modeloPerfiles/registroFormularioV2.php',arrDatos);
}

function eliminarRegistro(idRegistro)
{
	var idFormulario=gE('idFormulario').value;
	function resp(btn)
    {
    	if(btn=='yes')
        {
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                	if(gE('eJE').value=='')
	                 	regresarPagina(); 
                    else
                    {
                    	eval(bD(gE('eJE').value));
                    }
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=39&idRegistro='+idRegistro+'&idFormulario='+idFormulario,true);
		}        
	}
    msgConfirm('Est&aacute; seguro de querer eliminar el registro?',resp);

}

function imprimirFormulario()
{
	if(!paginaLista)
    {
    	
    	setTimeout(	function()
        			{ 
                    	imprimirFormulario();
                     }, 1000);

    }
    else
    {
    	var ajusteIzquierdo=mmToPt(5.65) ;//mm
    	window.parent.mostrarMensajeProcesando();
        var inicioIzquierdo=0;
        var inicioSuperior=0;
        var inicioDerecho=612;
        var inicioInferior=792;
        var objPagina=	{
        					posXInicial:inicioIzquierdo,
                            posXFinal:inicioDerecho,
                            posYInicial:inicioSuperior,
                            posYFinal:inicioInferior
                            
        				}
        var ajusteHojaPosY=0;
        var tamanoFuente=10;
        var margenInferior=inicioInferior-mmToPt(15);
        var margenSuperior=mmToPt(10);
    
        var margenIzquierdo=mmToPt(10);
        if(margenIzquierdo<ajusteIzquierdo)
        {
        	margenIzquierdo=ajusteIzquierdo;
        }
        var margenDerecho=mmToPt(20);
        
        
        relacionEscala=(tamanoFormularioBase-ptToPx(margenIzquierdo)-ptToPx(margenDerecho))/612;
       
        var pdf = new jsPDF({unit:'pt',lineHeight: 1.5});
        
        
        var arrDiv=$('div');
        
        var arrElementos=[];
       
        var x;
        var aDiv;
        var posXDiv;
        var posYDiv;
        
        for(x=0;x<arrDiv.length;x++)
        {
            aDiv=arrDiv[x].id.split('_');
            if(gE('sp_'+aDiv[1]))
            {
                posXDiv=parseInt(arrDiv[x].style.left.replace('px',''));
                posYDiv=parseInt(arrDiv[x].style.top.replace('px',''));            
                posXDiv-=posDivX;
                posXDiv*=relacionEscala;
                posYDiv-=posDivY;
                posXDiv=pxToPt(posXDiv);
                posYDiv=pxToPt(posYDiv*1.04);
                arrElementos.push(
                                    {
                                        x:posXDiv,
                                        y:posYDiv,
                                        texto:gE('sp_'+aDiv[1]).innerHTML.replace(/\s+/g," "),
                                        clase:gE('sp_'+aDiv[1]).parentNode.getAttribute('class'),
                                        id:arrDiv[x].id
                                    }
                                );
                                
             	break;                   
                                
                                
            }
        }
        
        arrElementos.sort(	function(a,b)
                            {
                                return a.y-b.y;
                            }
                        )
            
        var totalHojas=0;
        var string=pdf.output('datauristring');
        
        
        var objeto;
        var diferencia;
        var correccionY=0;
        var correccionX=0;
        var enters;
    
        var elementosHojas=[];
        elementosHojas[0]=[];
        var nHojas=0;
        var diferenciaAjuste=0;
        var ajusteYReferencia=0;
        var posYInicioHoja=0;
        var posY;
        var xAux;
        var diferencia=0;
        var nCiclos=0;
        var desplazamiento=0;
        for(x=0;x<arrElementos.length;x++)
        {
            if(elementosHojas[nHojas].length==0)
            {
            	
            	ajusteYReferencia=arrElementos[x].y-(nHojas*margenInferior);
                if(ajusteYReferencia>0)
                	diferenciaAjuste=Math.abs(ajusteYReferencia-(ajusteYReferencia-margenSuperior));
                else
                	diferenciaAjuste=margenSuperior-ajusteYReferencia;
               
                    
                if(ajusteYReferencia>margenInferior)
                	posYInicioHoja=ajusteYReferencia-diferenciaAjuste;
                else
                	posYInicioHoja=ajusteYReferencia+diferenciaAjuste;
                
                desplazamiento=arrElementos[x].y-posYInicioHoja;
                
            }
            
            
            posY=arrElementos[x].y-desplazamiento;
           	
            if((posY>margenInferior)||(arrElementos[x].texto=='@breakPage@'))
            {
            	
            	
                nHojas++;
                elementosHojas[nHojas]=[];
                /*if(arrElementos[x].texto!='@breakPage@')
	                x--;*/
                
               
    
            }
            else
            {
                arrElementos[x].posY=posY;            
                arrElementos[x].posX=arrElementos[x].x+margenIzquierdo;
                
                correccionX=0;
                
                if(arrElementos[x].posX<margenIzquierdo)
                {
                    diferencia=arrElementos[x].posX-margenIzquierdo;
                }
                
                correccionX+=diferencia;
                arrElementos[x].posX+=correccionX;
                elementosHojas[nHojas].push(arrElementos[x]);
            }
            
        }
      
    
       
        var objeto;
        var resRenderer;
        var arrControl;
        var resControl;
        for(x=0;x<elementosHojas.length;x++)
        {
            if(x>0)
            {
                pdf.addPage();
                
            }
            ajusteHojaPosY=0;
            for(xAux=0;xAux<elementosHojas[x].length;xAux++)
            {
                objeto=elementosHojas[x][xAux];
                objeto.posY+=ajusteHojaPosY;
                arrControl=objeto.id.split('_');
                eval("resRenderer=typeof("+objeto.clase+"_Renderer);");
                eval("resControl=typeof(_"+arrControl[1]+"_Renderer);");
                if((resRenderer=='undefined')&&(resControl=='undefined'))
                {
                   objeto=rendererEstandar(objeto,pdf,margenDerecho,tamanoFuente,margenIzquierdo,objPagina);
                 
                }
                else
                {
                    if(resRenderer!='undefined')
                    {
                        eval("objeto="+objeto.clase+"_Renderer(objeto,pdf,margenDerecho,tamanoFuente,margenIzquierdo,objPagina);");
                    }
                    else
                    {
                        eval("objeto="+arrControl[1]+"_Renderer(objeto,pdf,margenDerecho,tamanoFuente,margenIzquierdo,objPagina);");
                    }
                }
                
                ajusteHojaPosY+=objeto.ajusteHojaPosY;
            }
        }
        var string=pdf.output('datauristring');
        
        var arrParametros=[['documentoPDF',string],['nombreDocumento','evaluacion.pdf']];
       
        window.parent.enviarFormularioDatos('../paginasFunciones/generarPDFJsPDF.php',arrParametros,'POST','frameDTD');
    }
	 
}

function imprimirFormularioPaginaLista()
{
	
}

function rendererEstandar(objeto,pdf,margenDerecho,tamanoFuente,margenIzquierdo,objHoja)
{
	var arrLineas;
    var arrLineasAux;
    var nWordWrap;
    var palabras;
    var pos;
    var ajusteHojaPosY=0;
    var maxTamano=0;
    var tFuente=tamanoFuente;
    
    tFuente=parseFloat(window.getComputedStyle(gE(objeto.id)).getPropertyValue('font-size').replace('px',''))*relacionEscala;
   	pdf.setFontSize(tFuente);
   
	objeto.texto=objeto.texto.replace(/<br \/>/gi, '\n').replace(/<br>/gi, '\n')
    arrLineas=objeto.texto.split('\n');
    arrLineasAux=[];
    for(pos=0;pos<arrLineas.length;pos++)
    {
    	maxTamano=objHoja.posXFinal-margenIzquierdo-margenDerecho-objeto.posX;
        nWordWrap= dividirCadena(pdf,arrLineas[pos],maxTamano,objeto);
        
        for(palabras=0;palabras<nWordWrap.length;palabras++)
        {
            arrLineasAux.push(nWordWrap[palabras]);
        }
    }
    
    for(pos=0;pos<arrLineasAux.length;pos++)
    {
    	
        pdf.fromHTML('<div style="font-size: '+tFuente+'pt">'+arrLineasAux[pos]+'</div>',objeto.posX,objeto.posY+(pos*tFuente*tamanoInterlineado));
    }
    
    
    if(arrLineasAux.length>1)
    {
        ajusteHojaPosY=((arrLineasAux.length-1)*tFuente)*tamanoInterlineado;
        
    }
    
    objeto.ajusteHojaPosY=ajusteHojaPosY;
    return objeto;
}


function dividirCadena(pdf,cadena,maxTamano,objeto)
{
    var arrCadenas=[];
   	
    if(maxTamano>=pdf.getTextDimensions(cadena))
    {
    	
    	arrCadenas.push(cadena);
    }
    else
    {

    	var arrPalabras=cadena.split(' ');
        var line = '';
        for(var n = 0; n < arrPalabras.length; n++) 
        {
        	var testLine = line + arrPalabras[n] + ' ';
            var testWidth =pdf.getTextDimensions(testLine).w;
            
            if (testWidth > maxTamano && n > 0) 
            {
            	//n--;
            	arrCadenas.push(line);
                line='';
            }
            else
            {
            	line = testLine;
                
            }
        }
        if(line!='')
        	arrCadenas.push(line);
    }
    return arrCadenas;
}

function pxToPt(val)
{
	return val * 0.7528125;
}

function mmToPt(val)
{
	return val * 2.834645669;
}

function ptToPx(val)
{
	return val*0.3333;
}

























