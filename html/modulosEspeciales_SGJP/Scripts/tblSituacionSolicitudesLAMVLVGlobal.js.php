<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica s,_17_tiposCarpetasAdministra tC WHERE 
				cmbCategoria=1 and tC.idPadre=s.id__17_tablaDinamica and tC.idOpcion=1 and id__17_tablaDinamica not in(50,49) order by prioridad";
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
                                                                html:'<b>&nbsp;&nbsp;&nbsp;Unidad de Gesti&oacute;n Judicial:&nbsp;&nbsp;&nbsp;</b>'
                                                            },
                                                            cmbUnidadGestion,'-'
                                                            
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
                                    	url:'../modulosEspeciales_SGJP/tSituacionSolicitudesLAMVLVUnidad.php',
                                   		params:	{
                                    				uGestion:gEx('cmbUnidadGestion').getValue()
                                    			}
                                    }
    							)
}


