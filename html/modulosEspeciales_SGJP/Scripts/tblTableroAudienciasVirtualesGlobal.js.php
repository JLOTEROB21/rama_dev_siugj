<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica WHERE cmbCategoria=1 order by prioridad";
	
	$cualquierUnidad="0";
	/*if(existeRol("'176_0'"))
	{
		$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica t,_17_gridDelitosAtiende d 
					WHERE cmbCategoria=1 and t.id__17_tablaDinamica=d.idReferencia and d.tipoDelito='E'
					order by prioridad";
					
		$cualquierUnidad=$con->obtenerListaValores($consulta,"'");
	}*/
	
	if(existeRol("'177_0'"))
	{
		$consulta="SELECT DISTINCT claveUnidad,nombreUnidad FROM _17_tablaDinamica t WHERE 
					claveUnidad NOT IN(
										SELECT claveUnidad FROM _17_tablaDinamica t,_17_gridDelitosAtiende d 
										WHERE cmbCategoria=1 AND t.id__17_tablaDinamica=d.idReferencia AND d.tipoDelito  IN('E','EA')
					) AND cmbCategoria=1
					ORDER BY prioridad";
					
		$cualquierUnidad=$con->obtenerListaValores($consulta,"'");
	}
	
	if(existeRol("'182_0'"))
	{
		$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica t where id__17_tablaDinamica in(
		SELECT idPadre FROM _17_tiposCarpetasAdministra WHERE idOpcion=1
		) and id__17_tablaDinamica not in (50,49)
					order by prioridad";
					
		$cualquierUnidad=$con->obtenerListaValores($consulta,"'");
	}
	
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
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Audiencias Virtuales Agendadas</b></span>',
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
                                    	url:'../modulosEspeciales_SGJP/tblTableroAudienciasVirtuales.php',
                                   		params:	{
                                    				uGestion:gEx('cmbUnidadGestion').getValue()
                                    			}
                                    }
    							)
}


