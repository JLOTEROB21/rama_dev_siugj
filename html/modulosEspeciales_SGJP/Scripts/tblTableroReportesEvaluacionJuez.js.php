<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica where cmbCategoria=1 order by prioridad";
	$arrUnidades=$con->obtenerFilasArreglo($consulta);
	
	$consulta=" SELECT idProceso FROM 900_formularios WHERE categoriaFormulario='[3]'";
	$listaProcesos=$con->obtenerListaValores($consulta);
	if($listaProcesos=="")
		$listaProcesos=-1;
		
	$consulta="SELECT id__4_tablaDinamica,tipoAudiencia,
				(SELECT idFormulario FROM 900_formularios WHERE idProceso=p.idProceso AND formularioBase=1) AS iFormulario 
				FROM _4_tablaDinamica a,_4_gridProcesos p 
				WHERE p.idReferencia=a.id__4_tablaDinamica AND p.idProceso IN(".$listaProcesos.")"	;
				
	$arTipoAudiencia=$con->obtenerFilasArreglo($consulta);	
?>


var arTipoAudiencia=<?php echo $arTipoAudiencia?>;
var arrUnidades=<?php echo $arrUnidades?>;

Ext.onReady(inicializar);

function inicializar()
{
	var cmbTipoAudiencia=crearComboExt('cmbTipoAudiencia',arTipoAudiencia,0,0,400);
	var cmbUnidadGestion=crearComboExt('cmbUnidadGestion',arrUnidades,0,0,450,{multiSelect:true});
    
    var cmbTipoInforme=crearComboExt('cmbTipoInforme',	[
   															['1','Evaluaci\xF3n de Juez']
                                                      
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
                                                                html:'<b>&nbsp;&nbsp;&nbsp;Periodo de audiencias del:&nbsp;&nbsp;&nbsp;</b>'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dtrFechaInicio',
                                                                value:'<?php echo date("Y-01-01")?>',
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
                                                            }
                                                		],
                                                items:	[
                                                			{
                                                            	xtype:'panel',
                                                                region:'center',
                                                                border:false,
                                                                tbar:	[
                                                                			{
                                                                                xtype:'label',
                                                                                html:'<b>&nbsp;&nbsp;&nbsp;Unidad de gesti&oacute;n:&nbsp;&nbsp;&nbsp;</b>'
                                                                            },
                                                                            cmbUnidadGestion,'-',
                                                                            {
                                                                                xtype:'label',
                                                                                html:'<b>&nbsp;&nbsp;&nbsp;Tipo de audiencia:&nbsp;&nbsp;&nbsp;</b>'
                                                                            },
                                                                            cmbTipoAudiencia,
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
                                                                                                              border:false,
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
    var cmbUnidadGestion=gEx('cmbUnidadGestion');
    var cmbTipoAudiencia=gEx('cmbTipoAudiencia');
    
    if(cmbTipoInforme.getValue()=='')
    {
    	function resp()
        {
        	cmbTipoInforme.focus();
        }
        msgBox('Debe seleccionar el tipo de informe a generar',resp);
        return;
    }
    
    if(cmbUnidadGestion.getValue()=='')
    {
    	function resp2()
        {
        	cmbUnidadGestion.focus();
        }
        msgBox('Debe seleccionar la unidad de gesti&oacute;n cuyo informe desea generar',resp2);
        return;
    }
    
    if(cmbTipoAudiencia.getValue()=='')
    {
    	function resp3()
        {
        	cmbTipoAudiencia.focus();
        }
        msgBox('Debe seleccionar el tipo de audiencia cuyo informe desea generar',resp3);
        return;
    }
    
    
    
    var oParams={};
  
    switch(cmbTipoInforme.getValue())
    {
    	case '1':
      		urlLiga='../modulosEspeciales_SGJP/tblReporteEvaluacionAudiencia.php';
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
                oParams.unidadGestion=gEx('cmbUnidadGestion').getValue();
                oParams.tipoAudiencia=gEx('cmbTipoAudiencia').getValue();
                
                
                var pos=obtenerPosFila(cmbTipoAudiencia.getStore(),'id',cmbTipoAudiencia.getValue());
                
                oParams.formularioEvaluacion=cmbTipoAudiencia.getStore().getAt(pos).data.valorComp;
            
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
