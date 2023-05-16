<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

mostrarAllDay=true;
Ext.onReady(inicializar);

function inicializar()
{
	$('#calendar').fullCalendar(
    								{
										defaultView:'month',
                                        allDayDefault:true,
                                     	header: 
                                        		{
                                                	left: '',
                            		            	center: '',
                                                    right:'month'
                                    	        },
										
                                        businessHours: true, // display business hours
                                        editable: true,
                                        selectable: true,
                                        defaultDate: '<?php echo date("Y-m-d")?>',
										contentHeight:'auto',
                                        loading:function(isLoading,view)
                                        		{
                                                	if(!isLoading)
                                                    {
                                                    	
                                                       	
                                                        
                                                    }
                                                },
                                                
                                        dayClick: function(date, jsEvent, view) 
                                        			{
                                                    	//mostrarVentanaAsignarJuez(1,null,date,date);
                                                    },
                                        
                                        select: function(start, end) 
                                        			{
                                                        mostrarVentanaAsignarJuez(1,null,start,end)
                                                        
                                                    },
                                        eventRender: function(event, element) 
                                                			{
																
                                                              	element.bind('dblclick', function(e) 
                                                              							{
                                                                                        	
                                                                                            
							                                                              }
                                                                           );        
                                                            },
                                        
                                        eventSources: 	[
                                                    		{
                                                            	url:'../paginasFunciones/funcionesPanelCalendario.php',
                                                                type:'POST',
                                                                data:	{
                                                                            funcion:1,
                                                                            uG:gE('idUnidadGestion').value
                                                                		}
                                                            }
                                                		]
                                                
             						 }
					);
    
}



function mostrarVentanaAsignarJuez(accion,evento,inicio,fin)
{

	var fInicio=inicio.format('YYYY-MM-DD');
    var lblFechaFin=fin.format('YYYY-MM-DD');
    var fechaFin=Date.parseDate(lblFechaFin,'Y-m-d');
    var fFin=fechaFin.add(Date.DAY,-1).format('Y-m-d');

	if(inicio==fin)
    {
    	fFin=fin.format('YYYY-MM-DD');
    }

	
	
    
    

    

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Periodo del :'
                                                            
                                                        },
                                                        {	
                                                        	x:130,
                                                            y:15,
                                                            html:'<div id="divFechaInicio" style="width:140px"></div>'
                                                        },
                                                        {	
                                                        	x:280,
                                                            y:15,
                                                            html:'<div id="divHoraInicial"></div>'
                                                        },
                                                        
                                                        
                                                        
                                                        
                                                        {
                                                        	x:415,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:' al '
                                                            
                                                        },
                                                        {	
                                                        	x:445,
                                                            y:15,
                                                            html:'<div id="divFechaFinal" style="width:140px"></div>'
                                                        },
                                                        {	
                                                        	x:595,
                                                            y:15,
                                                            html:'<div id="divHoraFinal"></div>'
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Juez a asignar:'
                                                        },
                                                        {	
                                                        	x:170,
                                                            y:65,
                                                            html:'<div id="divJuez"></div>'
                                                        }
                                                        ,
                                                        {
                                                        	x:10,
                                                            y:120,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:150,
                                                            width:710,
                                                            height:80,
                                                            cls:'controlSIUGJ',
                                                            xtype:'textarea',
                                                            id:'txtComentariosAdicionales'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Registro de periodo de guardia',
										width: 750,
										height:340,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	var arrJueces=eval(''+bD(gE('arrJueces').value)+'');
																	var cmbJuez=crearComboExt('cmbJuez',arrJueces,0,0,550,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divJuez'});
																
                                                                	new Ext.form.DateField (	{
                                                                                                        renderTo:'divFechaInicio',
                                                                                                        width:130,
                                                                                                        ctCls:'campoFechaSIUGJ',
                                                                                                        id:'fechaInicial',
                                                                                                        xtype:'datefield',
                                                                                                        value:fInicio
                                                                                                    }
                                                                                             )
                                                                
                                                                	
                                                               
                                                               		var cmbHoraInicial=crearCampoHoraExt('cmbHoraInicial','00:00','23:50',1,false,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divHoraInicial'});
    
                                                                    
                                                                    cmbHoraInicial.setValue(gE('hInicioGuardia').value);
                                                               
                                                               		new Ext.form.DateField (	{
                                                                                                        renderTo:'divFechaFinal',
                                                                                                        width:130,
                                                                                                        ctCls:'campoFechaSIUGJ',
                                                                                                        id:'fechaFinal',
                                                                                                        xtype:'datefield',
                                                                                                        value:fFin
                                                                                                    }
                                                                                             )
                                                               
                                                               		var cmbHoraFinal=crearCampoHoraExt('cmbHoraFinal','00:00','23:50',1,false,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divHoraFinal'});
    																cmbHoraFinal.setValue(gE('hFinGuardia').value);
                                                               
                                                                }
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
																		var fechaInicial=gEx('fechaInicial');
                                                                        var fechaFinal=gEx('fechaFinal');
                                                                        var cmbHoraInicial=gEx('cmbHoraInicial');
                                                                        var cmbHoraFinal=gEx('cmbHoraFinal');
                                                                        var cmbJuez=gEx('cmbJuez');
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
                                                                        
                                                                        if(cmbHoraInicial.getValue()=='')
                                                                        {
                                                                        	function resp20()
                                                                            {
                                                                            	cmbHoraInicial.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la hora inicial del periodo',resp20);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbHoraFinal.getValue()=='')
                                                                        {
                                                                        	function resp21()
                                                                            {
                                                                            	cmbHoraFinal.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la hora final del periodo',resp21);
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
                                                                        
                                                                        var fechaInicio=Date.parseDate(fechaInicial.getValue().format('Y-m-d')+' '+cmbHoraInicial.getValue(),'Y-m-d H:i');
                                                                        var fechaFin=Date.parseDate(fechaFinal.getValue().format('Y-m-d')+' '+cmbHoraFinal.getValue(),'Y-m-d H:i');
                                                                        
                                                                        if(fechaInicio>fechaFin)
                                                                        {
                                                                        	function resp30()
                                                                            {
                                                                            	cmbHoraFinal.focus();
                                                                            }
                                                                        	msgBox('La fecha inicial del periodo no puede ser mayor que la fecha final',resp30);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var cadObj='{"tipoEvento":"1","fechaInicio":"'+fechaInicio.format('Y-m-d H:i:s')+'","fechaFin":"'+fechaFin.format('Y-m-d H:i:s')+
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
                                                                            	msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesPanelCalendario.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true);
                                                                        
                                                                        

                                                                        
                                                                        
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
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Motivo por el cual desea remover el periodo de guardia:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:50,
                                                            cls:'controlSIUGJ',
                                                            id:'txtMotivo',
                                                            xtype:'textarea',
                                                            width:600,
                                                            height:80
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Remover periodo de guardia',
										width: 650,
										height:240,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
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
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
																		var txtMotivo=gEx('txtMotivo');	
                                                                        if(txtMotivo.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtMotivo.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el motivo por el cual desea remover el periodo de guardia',resp);
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
                                                                                        recargarPagina();
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
                                                                        msgConfirm('¿Est&aacute; seguro de querer remover el periodo de guardia?',respQuestion);
                                                                        
                                                                        
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();
}