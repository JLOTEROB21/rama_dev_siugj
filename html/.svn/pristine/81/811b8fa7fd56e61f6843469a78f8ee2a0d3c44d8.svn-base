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
                                                          
                                                          mostrarVentanaDiaNoHabil(id);
                                                                   
                                                          return true;
                                                      });	                                                
                                                
	scheduler.init('scheduler_here', new Date(),"month");
    scheduler.load("../paginasFunciones/funcionesPanelCalendario.php?funcion=8","json");

}

function mostrarVentanaDiaNoHabil(id)
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
                                                            html:'Periodo del :'
                                                            
                                                        },
                                                        {
                                                        	x:110,
                                                            y:5,
                                                            id:'fechaInicial',
                                                            xtype:'datefield',
                                                            value:evento.start_date.format('Y-m-d')
                                                        },
                                                        
                                                        
                                                        {
                                                        	x:235,
                                                            y:10,
                                                            html:' al '
                                                            
                                                        },
                                                        {
                                                        	x:270,
                                                            y:5,
                                                            id:'fechaFinal',
                                                            xtype:'datefield',
                                                            value:evento.end_date.add(Date.DAY,-1).format('Y-m-d')
                                                        },
														{
                                                        	x:10,
                                                            y:40,
                                                            html:'Motivo por el cual el d&iacute;a es NO h&aacute;bil:'
                                                            
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            width:600,
                                                            height:80,
                                                            xtype:'textarea',
                                                            id:'txtMotivo'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Registro de d&iacute;a NO h&aacute;bil',
										width: 650,
										height:240,
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
                                                                	gEx('txtMotivo').focus(false,true);
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
                                                                        	msgBox('Debe indicar la fecha final del periodo',resp2);
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
                                                                        
																		var fechaInicio=fechaInicial.getValue().format('Y-m-d');
                                                                        var fechaFin=fechaFinal.getValue().format('Y-m-d');
                                                                        
                                                                        if(gEx('txtMotivo').getValue()=='')
                                                                        {
                                                                        	function respAux()
                                                                            {
                                                                            	gEx('txtMotivo').focus();
                                                                            }
                                                                            msgBox('Ingrese el motivo por el cual el d&iacute;a es NO h&aacute;bil',respAux);
                                                                        	return;
                                                                        }
                                                                        var cadObj='{"fechaInicio":"'+fechaInicio+'","fechaFin":"'+fechaFin+
                                                                        			'","motivo":"'+cv(gEx('txtMotivo').getValue())+'"}';
                                                                        
                                                                       
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	
                                                                                ventanaAM.close();
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                            	scheduler.deleteEvent(id);
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesPanelCalendario.php',funcAjax, 'POST','funcion=9&cadObj='+cadObj,true);
                                                                        
                                                                        

                                                                        
                                                                        
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
                                                            html:'Ingrese el motivo por el cual desea remover el periodo NO h&aacute;bil'
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
										title: 'Remover periodo NO h&aacute;bil',
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
                                                                            msgBox('Debe ingresar el motivo por el cual desea remover el periodo NO h&aacute;bil',resp);
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
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesPanelCalendario.php',funcAjax, 'POST','funcion=10&motivo='+cv(txtMotivo.getValue())+'&idRegistro='+bD(iE),true);
                                                                                
                                                                            
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer remover el periodo NO h&aacute;bil',respQuestion);
                                                                        
                                                                        
                                                                        
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