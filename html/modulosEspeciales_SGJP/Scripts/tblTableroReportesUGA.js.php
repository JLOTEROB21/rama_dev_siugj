<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica where claveUnidad='".$_SESSION["idUsr"]."'";
	$arrUnidades=$con->obtenerFilasArreglo($consulta);
	
?>

var arrUnidades=<?php echo $arrUnidades?>;

Ext.onReady(inicializar);

function inicializar()
{
	
	
    
    var cmbTipoInforme=crearComboExt('cmbTipoInforme',	[
   															['1','Reporte de captura de resolutivos por audiencia'],
    														['2','Reporte de solicitudes iniciales'],
                                                      
                                                        ],0,0,350);
    
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
                                                            },
                                                			'-',
                                                            {
                                                                icon:'../images/icon_big_tick.gif',
                                                                cls:'x-btn-text-icon',
                                                                text:'Generar',
                                                                handler:function()
                                                                        {
                                                                        	
                                                                            cargarReporte();
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


function cargarReporte()
{

    var cmbTipoInforme=gEx('cmbTipoInforme');
    var oParams={};
  
    switch(cmbTipoInforme.getValue())
    {
    	case '1':
      		urlLiga='../modulosEspeciales_SGJP/tblReporteCapturaResolutivosAudienciaExcel.php';
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
                oParams.unidadGestion='<?php echo $_SESSION["codigoInstitucion"]?>';
            
       	break;
        case '2':
        	
            	urlLiga='../modulosEspeciales_SGJP/generarInformeCarpetasIniciales.php';
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
                oParams.unidadGestion='<?php echo $_SESSION["codigoInstitucion"]?>';
            
        break;
        
        
        default:
        	urlLiga='../paginasFunciones/white.php';
        break;
        
    }
    
    
    gEx('frameContenidoHijo').load	(
    									{
                                        	url:urlLiga,
                                            params:oParams
                                        }
    								)
    
    
}
