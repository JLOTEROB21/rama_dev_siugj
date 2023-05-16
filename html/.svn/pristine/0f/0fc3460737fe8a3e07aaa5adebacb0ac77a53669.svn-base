<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT id__17_tablaDinamica,CONCAT('[',claveFolioCarpetas,'] ',nombreUnidad) FROM _17_tablaDinamica WHERE cmbCategoria=1 order by prioridad";
	$arrUnidades=$con->obtenerFilasArreglo($consulta);
?>

var tipoMateria='<?php echo $tipoMateria?>';

var arrUnidades=<?php echo $arrUnidades?>;

Ext.onReady(inicializar);

function inicializar()
{
	arrUnidades.splice(0,0,['0','Cualquiera']);
	var cmbUnidadGestion=crearComboExt('cmbUnidadGestion',arrUnidades,0,0,450);
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
                                                                html:'<b>&nbsp;&nbsp;&nbsp;'+(tipoMateria=='P'?'Unidad de Gesti&oacute;n Judicial':'Juzgado')+':&nbsp;&nbsp;&nbsp;</b>'
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
                                    	url:'../modulosEspeciales_SGJP/tblTableroControlJueces.php',
                                   		params:	{
                                    				idUnidadGestion:gEx('cmbUnidadGestion').getValue()
                                    			}
                                    }
    							)
}
