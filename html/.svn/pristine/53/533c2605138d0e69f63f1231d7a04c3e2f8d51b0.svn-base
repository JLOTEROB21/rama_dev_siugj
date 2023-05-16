<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
?>

var funcionRestoParametros=null;
var arrInformes= [
						['1','Audiencias'],
						['20','Documentos generados por sistema y firma electr\xF3nica'],
                        ['30','Operaci\xF3n en Unidades de Gesti\xF3n'],
                        ['40','Estadisticas generales']
                  ]
                  
                  
Ext.onReady(inicializar);

function inicializar()
{
	
    var cmbTipoInforme=crearComboExt('cmbTipoInforme',arrInformes,0,0,400);
    cmbTipoInforme.on('select',tipoReporteChange);
    
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                tbar:	[
                                                			{
                                                            	xtype:'label',
                                                                html:'<b>&nbsp;&nbsp;&nbsp;Tipo de informe:&nbsp;&nbsp;&nbsp;</b>'
                                                            },
                                                            cmbTipoInforme,'-',
                                                            {
                                                            	xtype:'label',
                                                                html:'<b>&nbsp;&nbsp;&nbsp;Periodo del:&nbsp;&nbsp;&nbsp;</b>'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dtrFechaInicio',
                                                                value:'<?php echo date("Y-m-d")?>',
                                                                listeners:	{
                                                                				//select:cargarReporte
                                                                			}
                                                            },
                                                            {
                                                            	xtype:'label',
                                                                html:'<b>&nbsp;&nbsp;&nbsp;al:&nbsp;&nbsp;&nbsp;</b>'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dtrFechaFin',
                                                                value:'<?php echo date("Y-m-d")?>',
                                                                listeners:	{
                                                                				//select:cargarReporte
                                                                			}
                                                            },'-',
                                                			
                                                            {
                                                                icon:'../images/icon_big_tick.gif',
                                                                cls:'x-btn-text-icon',
                                                                text:'Generar',
                                                                handler:function()
                                                                        {
                                                                        	
                                                                            if(funcionRestoParametros==null)
	                                                                            cargarReporte();
                                                                            else
                                                                            	funcionRestoParametros();
                                                                        }
                                                                
                                                            }
                                                		],
                                                items:	[
                                                            new Ext.ux.IFrameComponent({ 
                
                                                                                          id: 'frameContenidoHijo', 
                                                                                          anchor:'100% 100%',
                                                                                          region:'center',
                                                                                          loadFuncion:function(iFrame)
                                                                                                      {
                                                                                                          
                                                                                                      },

                                                                                          url: '../paginasFunciones/white.php',
                                                                                          style: 'width:100%;height:100%' 
                                                                                  })
                                                        ]
                                            }
                                         ]
                            }
                        )
                        
	
    
    
                           
}


function tipoReporteChange()
{
	
}


function cargarReporte(arrParams)
{

    var cmbTipoInforme=gEx('cmbTipoInforme');
    var oParams={};
  
    switch(cmbTipoInforme.getValue())
    {
    	case '1':
        	urlLiga='../modulosEspeciales_SGJP/indicadores/resolutivosAudiencia.php';
        	
            if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
        break;
    	case '20':
        	urlLiga='../modulosEspeciales_SGJP/indicadores/documentosGenerados.php';
        	
            if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
        break;
        case '30':
        	urlLiga='../modulosEspeciales_SGJP/indicadores/operacionUGAS.php';
        	
            if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
        break;
         case '40':
        	urlLiga='../modulosEspeciales_SGJP/indicadores/estadisticasUGAS.php';
        	
            if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
        break;
        default:
        	urlLiga='../paginasFunciones/white.php';
        break;
        
    }
    
    if(arrParams)
    {
    	var tmp;
    	for(tmp=0;tmp<arrParams.length;tmp++)
        {
        	oParams[arrParams[tmp][0]]=arrParams[tmp][1];
        }
    }
    
    gEx('frameContenidoHijo').load	(
    									{
                                        	url:urlLiga,
                                            params:oParams
                                        }
    								)
    
    
}

