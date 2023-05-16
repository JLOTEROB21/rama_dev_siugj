<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	
?>


var dragged_event;
Ext.onReady(inicializar);

function inicializar()
{
	scheduler.config.show_loading = true;
	scheduler.setLoadMode("month");
    scheduler.config.xml_date="%Y-%m-%d %H:%i";  
	scheduler.config.drag_move=false;
	scheduler.templates.event_class=function(start, end, event)
    								{
                                        var css = "";
                                        css += "event_"+event.tipoEvento;
                        
                                        if(event.id == scheduler.getState().select_id)
                                        {
                                            css += " selected";
                                        }
                                        return css;
                                    };


    
    scheduler.attachEvent("onBeforeDrag", function (id, mode, e)
    										{
                                            	
                                                
                                                return true;
                                            });
    
    scheduler.attachEvent("onBeforeLightbox", function (id)
    											{
                                                   
                                                    return false;
                                                });
                                                
                                                
	scheduler.attachEvent("onDragEnd", function (id, e){
                                                          
                                                          mostrarVentanaAsignarJuez(id);
                                                                   
                                                          return true;
                                                      });	                                                
                                                
	scheduler.init('scheduler_here', new Date(),"month");
    scheduler.load("../paginasFunciones/funcionesPanelCalendario.php?funcion=14&vVacaciones="+gE('vVacaciones').value+'&vIncidencias='+gE('vIncidencias').value+
    			'&vGuardias='+gE('vGuardias').value+'&vTramite='+gE('vTramite').value+'&tipoVista='+gE('tipoVista').value+'&idJuzgado='+gE('idJuzgado').value,"json");

}


function mostrarDatosEventoAudiencia(iE)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/pDatosAudiencia.php';
    obj.params=[['idEvento',iE],['cPagina','sFrm=true']];
    window.parent.parent.abrirVentanaFancy(obj);
}

function mostrarVentanaIncidencias(id)
{
	var evento=scheduler.getEvent(id);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'<b>Periodo de la incidencia:</b>'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:10,
                                                            html:' Del '+evento.start_date.format('d/m/Y')+' al '+evento.end_date.format('d/m/Y')
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'<b>Juez:</b>'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:40,
                                                            html:Ext.util.Format.stripTags(evento.text)
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'<b>Tipo de incidencia:</b>'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:70,
                                                            html:formatearValorRenderer(arrTiposIncidencia,evento.tipoIncidencia)
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'<b>Comentarios adicionales:</b>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            width:570,
                                                            height:80,
                                                            readOnly:true,
                                                            xtype:'textarea',
                                                            value:evento.comentarios.replace(/<br \/>/gi,'\r\n')
                                                        }		

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Datos de la incidencia/permiso',
										width: 620,
										height:310,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
																}
															}
												},
										buttons:	[
														{
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}