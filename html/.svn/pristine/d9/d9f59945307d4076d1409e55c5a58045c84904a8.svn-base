<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	
?>

var arrDatosCarpeta=[];
Ext.onReady(inicializar);
var timeline;
function inicializar()
{
	var container = document.getElementById('visualization');
    
	arrDatosCarpeta=eval('['+bD(gE('arrElementos').value)+']');
    
    var items = new vis.DataSet(arrDatosCarpeta);
  
    // Configuration for the Timeline
    var options = 	{
    					maxHeight:400,
                        zoomable:true	,
                        verticalScroll:true,
                        horizontalScroll:true,
                        min:gE('minFecha').value,
                        max:gE('maxFecha').value,
                        
    				};
  
    // Create a Timeline
    timeline = new vis.Timeline(container, items, options);
   
    generarBarraHerramientas()
    
    
    var x;
    var totalRegistro=parseInt(gE('totalRegistro').value);
    
    
    
    
   /* $('.tab-link').click(function()
                            {
                                var tab_id = $(this).attr('data-tab');
                        
                                $('ul.tabs li').removeClass('current');
                                $('.tab-content').removeClass('current');
                        
                                $(this).addClass('current');
                                $("#"+tab_id).addClass('current');
                            }
                       )*/
    
    


   
    
}

function mostrarDetalle(id,redibujar)
{
	mE('sp'+id+'_detalles');
    if((typeof(redibujar)=='undefined')||redibujar)
    {
	    timeline.redraw();
        timeline.focus(id);
    }
    if(gE('lblCtrlDetalles_'+id))
	    gE('lblCtrlDetalles_'+id).innerHTML='<a href="javascript:ocultarDetalle('+id+')" style="font-size:9px;color:#000;font-weight:bold">[Ocultar detalles]</a>';
}

function ocultarDetalle(id,redibujar)
{
	oE('sp'+id+'_detalles');
    

    if((typeof(redibujar)=='undefined')||redibujar)
	    timeline.redraw();
    if(gE('lblCtrlDetalles_'+id))
	    gE('lblCtrlDetalles_'+id).innerHTML='<a href="javascript:mostrarDetalle('+id+')" style="font-size:9px;color:#000;font-weight:bold">[Ver detalles]</a>';
}

function abrirCarpetaJudicial(cJ)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tableroAudienciaAdministracion.php';
    obj.params=[['cA',cJ]];
    abrirVentanaFancy(obj);
}

function abrirFichaParticipante(a)
{
	var obj={};
    var params=[['idRegistro',bD(a)],['idFormulario',47],['dComp',bE('auto')],['actor',bE('0')]];
    obj.ancho='90%';
    obj.alto='95%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=params;
    obj.modal=true;
    abrirVentanaFancy(obj)
}

function mostrarVisorDocumento(iD)
{
	mostrarVisorDocumentoProceso('',bD(iD),'');
}

function abrirVideoGrabacion(idEventoAudiencia)
{
	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/visorGrabacionAudiencia.php';
    obj.params=[['idEvento',idEventoAudiencia],['cPagina','sFrm=true']]
    abrirVentanaFancy(obj);
}

function generarBarraHerramientas()
{
	new Ext.Button (
						{
                        	icon:'../images/elbow-plus-nl.gif', 
                            width:100,
                            height:25,     
                            renderTo:'btnExpandAll',                    
                            cls:'x-btn-text-icon',
                            text:'Expandir todo',
                            handler:function()
                                    {
                                        var x;
                                        var totalRegistro=parseInt(gE('totalRegistro').value);
                                        for(x=1;x<totalRegistro;x++)
                                        {
                                        	mostrarDetalle(x,false);
                                        }
                                        timeline.redraw();
                                    }
                        }
    				)
                    
	new Ext.Button (
						{
                        	icon:'../images/elbow-plus-nl.gif', 
                            width:100,
                            height:25,     
                            renderTo:'btnColapsAll',                    
                            cls:'x-btn-text-icon',
                            text:'Contraer todo',
                            handler:function()
                                    {
                                        var x;
                                        var totalRegistro=parseInt(gE('totalRegistro').value);
                                        for(x=1;x<totalRegistro;x++)
                                        {
                                        	ocultarDetalle(x,false);
                                        }
                                        timeline.redraw();
                                    }
                        }
    				)       
        
    new Ext.Button (
						{
                        	
                            width:100,
                            height:25,    
                            disabled:(gE('fEtInicial').value==''),
                            renderTo:'btnEtapaInicial',                    
                            cls:'x-btn-text-icon',
                            text:'<table><tr><td><div style="width:15px; height:12px;background-color:#060"></div></td><td>&nbsp;&nbsp;Etapa Inicial</td></tr></table>',
                            handler:function()
                                    {
                                        timeline.moveTo(gE('fEtInicial').value);
                                    }
                        }
    				)
 
 	new Ext.Button (
						{
                        	
                            width:100,
                            height:25, 
                            disabled:(gE('fEtIntermedia').value==''),    
                            renderTo:'btnEtapaIntermedia',                    
                            cls:'x-btn-text-icon',
                            text:'<table><tr><td><div style="width:15px; height:12px;background-color:#F93"></div></td><td>&nbsp;&nbsp;Etapa Intermedia</td></tr></table>',
                            handler:function()
                                    {
                                        timeline.moveTo(gE('fEtIntermedia').value);
                                    }
                        }
    				) 
                      
	new Ext.Button (
						{
                        	
                            width:100,
                            height:25,   
                            disabled:(gE('fEtJuicioOral').value==''),   
                            renderTo:'btnEtapaJuicioOral',                    
                            cls:'x-btn-text-icon',
                            text:'<table><tr><td><div style="width:15px; height:12px;background-color:#900"></div></td><td>&nbsp;&nbsp;Etapa Juicio Oral</td></tr></table>',
                            handler:function()
                                    {
                                        timeline.moveTo(gE('fEtJuicioOral').value);
                                    }
                        }
    				)    
	
    new Ext.Button (
						{
                        	
                            width:100,
                            height:25,   
                            disabled:(gE('fEtEjecucion').value==''),    
                            renderTo:'btnEtapaEjecucion',                    
                            cls:'x-btn-text-icon',
                            text:'<table><tr><td><div style="width:15px; height:12px;background-color:#A61BA6"></div></td><td>&nbsp;&nbsp;Etapa Ejecuci&oacute;n</td></tr></table>',
                            handler:function()
                                    {
                                        timeline.moveTo(gE('fEtEjecucion').value);
                                    }
                        }
    				)                                                         
}

function mostrarDetalleProceso(iF,iR)
{
	var obj={};
    var params=[['idRegistro',bD(iR)],['idFormulario',bD(iF)],['dComp',bE('auto')],['actor',bE('0')]];
    obj.ancho='90%';
    obj.alto='95%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=params;
    obj.modal=true;
    abrirVentanaFancy(obj)
}