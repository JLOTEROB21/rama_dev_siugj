<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var carpetaAdministrativa=-1;
var dragged_event;
Ext.onReady(inicializar);

function inicializar()
{
	scheduler.config.show_loading = true;
	scheduler.setLoadMode("month");
    scheduler.config.xml_date="%Y-%m-%d %H:%i";  
	scheduler.config.drag_move=false;
    scheduler.config.businessHours=false;
    scheduler.config.eventLimit=false;
    scheduler.businessHours=false;
    if(gE('carpetaJudicial').value!='-1')
    {
    	carpetaAdministrativa=gE('carpetaJudicial').value;
    }
    
	/*scheduler.templates.event_class=function(start, end, event)
    								{
                                        var css = "";
                                        if(event.unidadGestion) // if event has subject property then special class should be assigned
                                            css += "event_"+event.unidadGestion;
                        
                                        if(event.id == scheduler.getState().select_id)
                                        {
                                            css += " selected";
                                        }
                                        return css;
                                    };*/
    
    scheduler.attachEvent("onBeforeDrag", function (id, mode, e)
    										{
                                            	
                                                
                                                return true;
                                            });
    
    scheduler.attachEvent("onBeforeLightbox", function (id)
    											{
                                                   
                                                    return false;
                                                });
                                                
                                                
	scheduler.attachEvent("onDragEnd", function (id, e){
                                                          var evento=scheduler.getEvent(id);
                                                          mostrarVentanaProgramarEvento(-1,evento);
                                                                   
                                                          return true;
                                                      });	                                                
    
    
    scheduler.attachEvent("onDblClick", function (id, e){
                                                         	
                                                            
                                                            var evento=scheduler.getEvent(id);

                                                            mostrarVentanaProgramarEvento(evento.id,evento);
                                                                   
                                                          	return true;
                                                      });
    
                                                
	scheduler.init('scheduler_here', new Date(),"month");
    scheduler.load("../paginasFunciones/funcionesPanelCalendario.php?funcion=12&c="+gE('carpetaJudicial').value+'&uG='+gE('unidadGestion').value,"json");

}

function mostrarVentanaProgramarEvento(id,e)
{
	
	var oConf=	{
    					idCombo:'cmbCarpetaJudicial',
                        anchoCombo:200,
                        posX:140,
                        posY:5,
                        nRegistros:'numReg',
                        raiz:'registros',
                        campoDesplegar:'carpetaAdministrativa',
                        campoID:'carpetaAdministrativa',
                        funcionBusqueda:47,
                        paginaProcesamiento:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                        confVista:'<tpl for="."><div class="search-item">{carpetaAdministrativa}<br></div></tpl>',
                        campos:	[
                                    {name:'carpetaAdministrativa'}

                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	carpetaAdministrativa=-1;
                                    	var aValor=combo.getRawValue();
										dSet.baseParams.criterio=aValor;
                                        
                                    },
                      	funcElementoSel:function(combo,registro)
                    				{
                                    	carpetaAdministrativa=registro.data.carpetaAdministrativa;
                                        combo.setRawValue(carpetaAdministrativa);
                                    }  
    				};

	
	var cmbCarpetaJudicial=crearComboExtAutocompletar(oConf)
    if(gE('carpetaJudicial').value!='-1')
    {
    	cmbCarpetaJudicial.setRawValue(carpetaAdministrativa);
        cmbCarpetaJudicial.disable();
    }
    var x;
    var arrDias=[];
    for(x=0;x<31;x++)
    {
    	arrDias.push([x,x]);
        
    }
    var cmbDias=crearComboExt('cmbDias',arrDias,345,35,110);
    cmbDias.setValue(0);
    if(e.editable=='0')
    {
    	cmbDias.disable();
        cmbCarpetaJudicial.disable();
    }
        
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Carpeta Judicial:'
                                                            
                                                        },
                                                        cmbCarpetaJudicial,
														{
                                                        	x:10,
                                                            y:40,
                                                            html:'Fecha l&iacute;mite:'
                                                            
                                                        },
                                                        {
                                                        	x:140,
                                                            y:35,
                                                            id:'fechaInicial',
                                                            xtype:'datefield',
                                                            disabled:e.editable=='0',
                                                            value:e.start_date.format('Y-m-d')
                                                        },
                                                        {
                                                        	x:270,
                                                            y:40,
                                                            html:'Recordar:'
                                                            
                                                        },
                                                        cmbDias,
                                                         {
                                                        	x:470,
                                                            y:40,
                                                            html:'d&iacute;as antes'
                                                            
                                                        },
                                                        {
                                                        	x:345,
                                                            y:65,
                                                            html:'(0 para no recordar)'
                                                        }
                                                        ,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Detalles del evento:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            width:600,
                                                            height:80,
                                                            xtype:'textarea',
                                                            readOnly:e.editable=='0',
                                                            id:'txtComentariosAdicionales'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Registro de evento de Carpeta Judicial',
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
                                                                	if(id==-1)
	                                                                	scheduler.deleteEvent(e.id);
                                                                    cmbCarpetaJudicial.focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            hidden:e.editable=='0',
															handler: function()
																	{
																		if(carpetaAdministrativa==-1)
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbCarpetaJudicial.focus();
                                                                            }
                                                                            msgBox('Debe indicar la carpeta judicial a la cual pertenece el evento a registrar',resp);
                                                                            return;
                                                                        }
                                                                       
                                                                       	var fechaInicial=gEx('fechaInicial');
                                                                        if(fechaInicial.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	fechaInicial.focus();
                                                                            }
                                                                            msgBox('Debe indicar la fecha l&iacute;mite del evento a registrar',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        var txtComentariosAdicionales=gEx('txtComentariosAdicionales');
                                                                        if(txtComentariosAdicionales.getValue().trim()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	txtComentariosAdicionales.focus();
                                                                            }
                                                                            msgBox('Debe ingresar los detalles del evento a registrar',resp3);
                                                                            return;
                                                                        }
                                                                        var idEvento=-1;
                                                                        if(id!=-1)
                                                                        	idEvento=id;
                                                                        var cadObj='{"idEvento":"'+idEvento+'","carpetaAdministrativa":"'+cv(carpetaAdministrativa)+
                                                                        		'","fechaLimite":"'+fechaInicial.getValue().format('Y-m-d')+
                                                                                '","diasRecordatorio":"'+cmbDias.getValue()+
                                                                                '","detallesEvento":"'+cv(txtComentariosAdicionales.getValue())+'"}';
                                                                        
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
                                                                            	//scheduler.deleteEvent(e.id);
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesPanelCalendario.php',funcAjax, 'POST','funcion=11&cadObj='+cadObj,true);
                                                                        
                                                                        

                                                                        
                                                                        
																	}
														},
														{
															text: e.editable=='0'?'Aceptar':'<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
                                                                    	if(id=='-1')
                                                                        {
                                                                        
                                                                        	scheduler.deleteEvent(e.id);
																		}
                                                                        ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
    if(id!=-1)
    {
    	carpetaAdministrativa=e.carpetaAdministrativa;
    	cmbCarpetaJudicial.setRawValue(carpetaAdministrativa);
        gEx('fechaInicial').setValue(e.start_date.format('Y-m-d'));
        gEx('txtComentariosAdicionales').setValue(escaparBR(e.detalle,true));
        cmbDias.setValue(e.diasRecordar);
    }
   
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
                                                            html:'Ingrese el motivo por el cual desea remover el periodo de guardia del juez'
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
										title: 'Remover periodo de guardia',
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
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesPanelCalendario.php',funcAjax, 'POST','funcion=3&tipo=1&motivo='+cv(txtMotivo.getValue())+'&idAsignacion='+bD(iE),true);
                                                                                
                                                                            
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


function removerEvento(id)
{
	function resp(btn)
    {
    	if(btn=='yes')
        {
        	function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    scheduler.deleteEvent(bD(id));
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesPanelCalendario.php',funcAjax, 'POST','funcion=13&iE='+bD(id),true);
            
        }
    }
    msgConfirm('Est&aacute; seguro de querer remover el evento seleccionado?',resp);
}