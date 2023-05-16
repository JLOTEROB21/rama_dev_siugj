<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica t,_17_tiposCarpetasAdministra c WHERE cmbCategoria=1 
			and id__17_tablaDinamica not in(49,50) and c.idPadre=t.id__17_tablaDinamica and c.idOpcion=1 order by prioridad";

	
	$cualquierUnidad="0";
	
	$arrUnidades=$con->obtenerFilasArreglo($consulta);
	
?>

var arrUnidades=<?php echo $arrUnidades?>;

Ext.onReady(inicializar);

function inicializar()
{
	arrUnidades.splice(0,0,["<?php echo $cualquierUnidad?>",'Cualquiera']);
	var cmbUnidadGestion=crearComboExt('cmbUnidadGestion',arrUnidades,0,0,500);
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Audiencias LAMVLVCDMX Agendadas</b></span>',
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
                        
	cmbUnidadGestion.setValue("<?php echo $cualquierUnidad?>") ;    
    cmbUnidadGestion.on('select',cargarTableroUnidadGestion);
    
    dispararEventoSelectCombo('cmbUnidadGestion',true);
                           
}

function cargarTableroUnidadGestion()
{
	gEx('frameContenidoHijo').load	(
    								{
                                    	url:'../modulosEspeciales_SGJP/tblTableroAudienciasVirtualesLAMVLVCDMX.php',
                                   		params:	{
                                    				uGestion:gEx('cmbUnidadGestion').getValue()
                                    			}
                                    }
    							)
}


