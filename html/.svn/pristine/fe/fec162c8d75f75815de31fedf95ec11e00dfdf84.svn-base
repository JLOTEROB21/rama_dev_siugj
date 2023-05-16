<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT DISTINCT idTableroControl FROM 9064_rolesTableroControl WHERE rol IN(".$_SESSION["idRol"].")";
	$listaTableros=$con->obtenerListaValores($consulta);
	if($listaTableros=="")
		$listaTableros=-1;
		
	$arrTableros="";	
		
	$consulta="SELECT idTableroControl,nombreTableroControl,nombreCorto,tiempoActualizacion,descripcion FROM 9060_tablerosControl WHERE idTableroControl IN (".$listaTableros.") AND visibleBarraNotificaciones=1";
	$resTableros=$con->obtenerFilas($consulta);
	while($filaTablero=mysql_fetch_row($resTableros))
	{
		$o='	{
					xtype:"panel",
					id:"panel_'.$filaTablero[0].'",
					"title":"'.cv($filaTablero[2]).'",
					listeners:	{
									activate:function(p)
											{
												if(!p.activo)
												{
													var arrId=p.id.split("_");													
													gEx("iFrame_"+arrId[1]).load	(
																						{
																							url:"../modeloPerfiles/instanciaTableroControl.php",
																							params:	{
																										idTableroControl:'.$filaTablero[0].',
																										cPagina:"sFrm=true"
																									}
																						}
																					)
													
													p.activo=true;
												}
												
												if((window.parent)&&(window.parent.ocultarNotificacionesTableroControl))
													window.parent.ocultarNotificacionesTableroControl('.$filaTablero[0].')
											}
								},
					items:	[
								new Ext.ux.IFrameComponent({ 
																  id: "iFrame_'.$filaTablero[0].'", 
																  anchor:"100% 100%",
																  url: "../paginasFunciones/white.php",
																  style: "width:100%;height:100%"
														  })
							]
				}';
		if($arrTableros=="")
			$arrTableros=$o;
		else	
			$arrTableros.=",".$o;
	}
	
	
	
?>

var tableroActivo='';
Ext.onReady(inicializar);

function inicializar()
{
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                border:false,
                                                layout:'border',
                                                items:	[
                                                         	{
                                                            	region:'center',
                                                                activeTab:0,
                                                               
                                                                id:'tabPanelTableros',
                                                            	xtype:'tabpanel',
                                                                items:	[
			                                                                <?php echo $arrTableros?>
                                                                		]
                                                            }   
                                                        ]
                                            }
                                         ]
                            }
                        )   
                        
	tableroActivo=gE('tableroActivo').value;
    
    if(tableroActivo!='-1')
    	establecerTableroControl(tableroActivo);
    
	                      
                        
}

function establecerTableroControl(iT)
{

	tableroActivo=iT;
  
	var tabPanelTableros=gEx('tabPanelTableros');
 	tabPanelTableros.setActiveTab('panel_'+iT);   
    if(gEx('iFrame_'+iT)&&gEx('iFrame_'+iT).getFrameWindow()&&gEx('iFrame_'+iT).getFrameWindow().recargarGridRegistros)
    	gEx('iFrame_'+iT).getFrameWindow().recargarGridRegistros();
    
    
}

function recargarTableroControl(iT)
{

	if(gEx('iFrame_'+iT) && (gEx('iFrame_'+iT).getFrameWindow) && (gEx('iFrame_'+iT).getFrameWindow().recargarGridRegistros))
		gEx('iFrame_'+iT).getFrameWindow().recargarGridRegistros();
}


function recargarContenedorCentral()
{
	gEx('iFrame_'+tableroActivo).getFrameWindow().recargarGridRegistros();
}

function actualizarBurbujaTareas(iT,total)
{
	if(window.parent.actualizarBurbujaTareas)
    {
        window.parent.actualizarBurbujaTareas(iT,total);
    }
}