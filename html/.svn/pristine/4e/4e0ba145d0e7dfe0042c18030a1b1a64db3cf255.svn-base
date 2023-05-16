<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica where idReferencia<>6";
	$arrUnidades=$con->obtenerFilasArreglo($consulta);
	
?>

var arrUnidades=<?php echo $arrUnidades?>;

Ext.onReady(inicializar);

function inicializar()
{
	
	var cmbUnidadGestion=crearComboExt('cmbUnidadGestion',arrUnidades,0,0,250);
    
    var cmbTipoInforme=crearComboExt('cmbTipoInforme',[['1','Eventos por juez (Sin guardias)'],['5','Eventos por juez (Incluyendo guardias)'],['4','Carpetas judiciales por juez'],['2','Eventos por unidad de gesti\xF3n (Sin guardias)'],['6','Eventos por unidad de gesti\xF3n (Incluyendo guardias)'],['3','Carpetas judiciales por unidad de gesti\xF3n']],0,0,290);
    
    cmbTipoInforme.on('select',cargarReporte);
    
    
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
                                                                value:'2016-01-01',
                                                                listeners:	{
                                                                				select:cargarReporte
                                                                			}
                                                            },
                                                            {
                                                            	xtype:'label',
                                                                html:'<b>&nbsp;&nbsp;&nbsp;al:&nbsp;&nbsp;&nbsp;</b>'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dtrFechaFin',
                                                                value:'2016-12-31',
                                                                listeners:	{
                                                                				select:cargarReporte
                                                                			}
                                                            },
                                                			{
                                                            	xtype:'label',
                                                                html:'<b>&nbsp;&nbsp;&nbsp;Unidad de gesti&oacute;n:&nbsp;&nbsp;&nbsp;</b>'
                                                            },
                                                            cmbUnidadGestion
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
                        
	
    cmbUnidadGestion.on('select',cargarReporte);
    
    
                           
}


function cargarReporte()
{
	urlLiga='../modulosEspeciales_SGJP/tblGraficaEventos.php';
    var cmbTipoInforme=gEx('cmbTipoInforme');
    var oParams={};
    switch(cmbTipoInforme.getValue())
    {
    	case '1':
        case '4':
        case '5':
        	gEx('cmbUnidadGestion').enable();
            
            if((gEx('cmbUnidadGestion').getValue()=='')||(gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	oParams.unidadMedida=cmbTipoInforme.getValue();
                oParams.unidadGestion=gEx('cmbUnidadGestion').getValue();
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
        break;
        case '2':
        case '3':
        case '6':
       
        	gEx('cmbUnidadGestion').disable();
            gEx('cmbUnidadGestion').setValue('');
            if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	oParams.unidadMedida=cmbTipoInforme.getValue();
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
        
        break;
        default:
        	url='../paginasFunciones/white.php';
        break;
        
    }
    
    
    gEx('frameContenidoHijo').load	(
    									{
                                        	url:urlLiga,
                                            params:oParams
                                        }
    								)
    
    
}
