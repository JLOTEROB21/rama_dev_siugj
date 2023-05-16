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
                                        if(event.unidadGestion) // if event has subject property then special class should be assigned
                                            css += "event_"+event.unidadGestion;
                        
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
    scheduler.load("../paginasFunciones/funcionesPanelCalendario.php?funcion=4&uG="+gE('idUnidadGestion').value,"json");

}

function mostrarVentanaAsignarJuez(id)
{
	var arrJueces=eval(''+bD(gE('arrJueces').value)+'');
	var cmbJuez=crearComboExt('cmbJuez',arrJueces,110,35,300);
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
                                                            html:'Perido del :'
                                                            
                                                        },
                                                        {
                                                        	x:110,
                                                            y:5,
                                                            id:'fechaInicial',
                                                            xtype:'datefield',
                                                            value:evento.start_date.format('Y-m-d')
                                                        },
                                                        {
                                                        	x:240,
                                                            y:10,
                                                            html:' al '
                                                            
                                                        },
                                                        {
                                                        	x:290,
                                                            y:5,
                                                            id:'fechaFinal',
                                                            xtype:'datefield',
                                                            value:evento.end_date.add(Date.DAY,-1).format('Y-m-d')
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Juez a asignar:'
                                                        },
                                                        cmbJuez,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            width:600,
                                                            height:80,
                                                            xtype:'textarea',
                                                            id:'txtComentariosAdicionales'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Registro de periodo de juez de tr&aacute;mite',
										width: 650,
										height:280,
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
                                                                	scheduler.deleteEvent(id);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var fechaInicial=gEx('fechaInicial');
                                                                        var fechaFinal=gEx('fechaFinal');
                                                                        
                                                                        
                                                                        if(fechaInicial.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	fechaInicial.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la fecha inicial del periodo',resp1);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(fechaFinal.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	fechaFinal.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la fecha inicial del periodo',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(fechaInicial.getValue()>fechaFinal.getValue())
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	fechaFinal.focus();
                                                                            }
                                                                        	msgBox('La fecha inicial del periodo no puede ser mayor que la fecha final',resp3);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbJuez.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	cmbJuez.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el juez a asignar',resp4);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var cadObj='{"tipoEvento":"2","fechaInicio":"'+fechaInicial.getValue().format('Y-m-d')+'","fechaFin":"'+fechaFinal.getValue().format('Y-m-d')+
                                                                        			'","idJuez":"'+cmbJuez.getValue()+'","comentarios":"'+cv(gEx('txtComentariosAdicionales').getValue())+'"}';
                                                                        
                                                                       
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	recargarPagina();
                                                                                ventanaAM.close();
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                            	scheduler.deleteEvent(id);
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesPanelCalendario.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true);
                                                                        
                                                                        

                                                                        
                                                                        
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
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


function removerAsignacion(iE)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Ingrese el motivo por el cual desea remover la asignaci&oacute;n de juez de tr&aacute;mite'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            id:'txtMotivo',
                                                            xtype:'textarea',
                                                            width:500,
                                                            height:80
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Remover asignaci&oacute;n de juez de tr&aacute;mite',
										width: 550,
										height:210,
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
                                                                	gEx('txtMotivo').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtMotivo=gEx('txtMotivo');	
                                                                        if(txtMotivo.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtMotivo.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el motivo por el cual desea remover la asignaci&oacute;n del juez',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        function respQuestion(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                            	function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        scheduler.deleteEvent(bD(iE));
                                                                                        ventanaAM.close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesPanelCalendario.php',funcAjax, 'POST','funcion=3&tipo=2&motivo='+cv(txtMotivo.getValue())+'&idAsignacion='+bD(iE),true);
                                                                                
                                                                            
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer remover la asignaci&oacute;n del juez',respQuestion);
                                                                        
                                                                        
                                                                        
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
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