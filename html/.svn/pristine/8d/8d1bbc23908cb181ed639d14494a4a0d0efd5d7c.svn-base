<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica WHERE cmbCategoria=1 
			and id__17_tablaDinamica in
			(
			SELECT DISTINCT idCentroGestion FROM 7000_eventosAudiencia e,_4_gridProcesos g WHERE g.idReferencia=e.tipoAudiencia
			) 	order by prioridad";
	$arrUnidades=$con->obtenerFilasArreglo($consulta);
	
	
	
?>

var arrUnidades=<?php echo $arrUnidades?>;

Ext.onReady(inicializar);

function inicializar()
{
	arrUnidades.splice(0,0,['0','Cualquiera']);
	var cmbUnidadGestion=crearComboExt('cmbUnidadGestion',arrUnidades,0,0,500);
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
                                                                html:'<b>&nbsp;&nbsp;&nbsp;Eventos de la unidad de gesti&oacute;n:&nbsp;&nbsp;&nbsp;</b>'
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
                        
	cmbUnidadGestion.setValue('0') ;    
    cmbUnidadGestion.on('select',cargarTableroUnidadGestion);
    
    dispararEventoSelectCombo('cmbUnidadGestion',true);
                           
}

function cargarTableroUnidadGestion()
{
	gEx('frameContenidoHijo').load	(
    								{
                                    	url:'../modulosEspeciales_SGJP/tblTableroAudienciasEvaluacion.php',
                                   		params:	{
                                    				uGestion:gEx('cmbUnidadGestion').getValue()
                                    			}
                                    }
    							)
}


