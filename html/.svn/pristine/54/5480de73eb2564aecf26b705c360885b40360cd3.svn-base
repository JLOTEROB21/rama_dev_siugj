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
  	
    var arrDatosIndice=[];
    var oIndice;
    var o;
    for(x=0;x<arrDatosCarpeta.length;x++)
    {
    	o=arrDatosCarpeta[x];
        oIndice={};
        oIndice.idEvento=o.id;
        oIndice.fechaEvento=o.start;
        oIndice.etapaProcesal=o.etapaProcesal;
        oIndice.leyenda=o.etiquetaEvento;
        
        arrDatosIndice.push(oIndice);
    }
    window.parent.cargarEventosIncide(arrDatosIndice);
    // Configuration for the Timeline
    
    
   moment.lang('es', {
                          months: 'Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre'.split('_'),
                          monthsShort: 'Enero._Feb._Mar_Abr._May_Jun_Jul._Ago_Sept._Oct._Nov._Dec.'.split('_'),
                          weekdays: 'Domingo_Lunes_Martes_Miercoles_Jueves_Viernes_Sabado'.split('_'),
                          weekdaysShort: 'Dom._Lun._Mar._Mier._Jue._Vier._Sab.'.split('_'),
                          weekdaysMin: 'Do_Lu_Ma_Mi_Ju_Vi_Sa'.split('_')
                        }
              );

    
    
    var options = 	{
    					maxHeight:480,
                        minHeight:480,
                        zoomable:false,
                        locale: 'es',
                        horizontalScroll:true,
                        verticalScroll:true,
                        margin:	{
                        			axis:30,
                                    item:30
                        		}	,
                        timeAxis: {scale: 'hour', step: 1},
                        width: '100%',
                        zoomMin:100
                        
    				};
  
    // Create a Timeline
    timeline = new vis.Timeline(container, items, options);
    setTimeout(	function()
    			{ 
                	
                	var minFecha=gE('minFecha').value;
                    if(minFecha=='')
                    {
                    	minFecha='<?php echo date("Y-m-d H:i:s")?>';
                    }
                	var fechaInicial=Date.parseDate(minFecha,'Y-m-d H:i:s');
                    if(!fechaInicial)
                    	fechaInicial=Date.parseDate(minFecha,'Y-m-d H:i');
                        
                    fechaInicial=fechaInicial.add(Date.HOUR,-3);
                	timeline.setWindow(fechaInicial, fechaInicial.add(Date.HOUR,16));
                    

                }, 300);
   	
    generarBarraHerramientas()
    
    
    var x;
    var totalRegistro=parseInt(gE('totalRegistro').value);
    
    
    
    
   
    
    


   
    
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
    obj.url='../modulosEspeciales_SGJ/tableroAudienciaAdministracion.php';
    obj.params=[['cA',cJ]];
    window.parent.abrirVentanaFancy(obj);
}

function abrirFichaParticipante(a)
{
	var obj={};
    var params=[['idRegistro',bD(a)],['idFormulario',47],['dComp',bE('auto')],['actor',bE('0')]];
    obj.ancho='100%';
    obj.alto='95%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=params;
    obj.modal=true;
    window.parent.abrirVentanaFancy(obj)
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
    window.parent.abrirVentanaFancy(obj);
}

function generarBarraHerramientas()
{
	     
        
    
	
                                                     
}

function mostrarDetalleProceso(iF,iR)
{
	var obj={};
    var params=[['idRegistro',bD(iR)],['idFormulario',bD(iF)],['dComp',bE('auto')],['actor',bE('0')]];
    obj.ancho='100%';
    obj.alto='95%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=params;
    obj.modal=true;
    window.parent.abrirVentanaFancy(obj)
}


function seleccionarEvento(id)
{
	timeline.setSelection(id,{focus:true})
}