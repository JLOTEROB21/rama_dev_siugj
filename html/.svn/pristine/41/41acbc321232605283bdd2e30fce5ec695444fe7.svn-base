Ext.onReady(Inicializar);
function Inicializar()
{
	function funcFechaCamb(campo,nuevoV,viejoV)
	{
		var f=new  Date(nuevoV);
		gE('FNacimiento').value=f.format('d/m/Y');
	}
	
	var FNac=new Ext.form.DateField
									(
										{
											id:'fecha',
											x:0,
											y:0,
											width:130,
											format:'d/m/Y',
											renderTo:'FNac',
											readOnly:true,
											height:150,
											cls:'campoFecha'
										}
									)
	var FNacimiento=gE('FNacimiento');
	FNac.setValue(FNacimiento.value);	
	FNac.on('change',funcFechaCamb);
	gE('Nombre').focus();
}//Inicializar

var keyMap = new Ext.KeyMap(document, 
									{
										key: 13, 
										fn: funValidar,
										scope: this
									}
							);

function funValidar()
{
	var btnGuardar=gE('btnGuardar');
	btnGuardar.click();
	
}


function GuardarIdentifica(form)
{
	if (!validarFormularios(form))
	{
		return;
	}
	else
	{
		var formulario=gE(form);
		var cmbTelefonos=gE('cmbTelefono');
		var cadTelefono='';
		var x;
		for(x=0;x<cmbTelefonos.options.length;x++)
		{
			if(cadTelefono=='')
				cadTelefono=cmbTelefonos.options[x].value;
			else
				cadTelefono+=','+cmbTelefonos.options[x].value;
			
		}
		gE('telefonos').value=cadTelefono;
		
		var cmbMail=gE('cmbMail');
		var cadMail='';
		var x;
		for(x=0;x<cmbMail.options.length;x++)
		{
			if(cadMail=='')
				cadMail=cmbMail.options[x].value;
			else
				cadMail+=','+cmbMail.options[x].value;
			
		}
		gE('correos').value=cadMail;
		
		formulario.submit();
	}
}//GuardaIdentifica




function solicitarMail(IdUsuario,tipoMail)
{
	/*if(IdUsuario==-1)
	{
			Ext.MessageBox.alert(lblAplicacion,'Solo podrá registrar un correo electrónico, después de haber guardado el resto de la información.');
			return;
	}*/
	
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											disabled:false,
											items:
													[
													 	new Ext.form.Label(
																		   		{
																					x:5,
																					y:10,
																					text: 'Correo Electrónico:'
																				}
																		   ),
														
														new Ext.form.TextField
														(
																			   {
															x:130,
															y:5,
															width:240,
															height:20,
															id:'txtMail'
														}
														),
														new Ext.form.Checkbox
														(
															{
															x:5,
															y:35,
															//autoShow:true,
															checked:true,
															boxLabel:'Notificarme a este correo',
															allowBlank :true,
															value:'1',
															id:'Notificar'
															}
														)
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar Correo Electrónico',
										width:410,
										height:130,
										layout:'fit',
										buttonAlign:'center',
										items:[form],
										modal:true,
										plain:true,
										listeners:
											{
												show:
												{
													buffer:10,fn:function()
															{
																var m=Ext.getCmp('txtMail');
																m.focus(true,10);
															}
												}
											},
										buttons:
												[
												 	{
														text:'Aceptar',
														handler:function ()
															{
																var m=Ext.getCmp('txtMail').getValue();
																var checado=Ext.getCmp('Notificar').checked;
																if(checado)
																	Notifica=1;
																else
																	Notifica=0;
																guardarMail(m,Notifica,IdUsuario,tipoMail,ventana);
															}
													},
													{
														text:'Cancelar',
														handler:function ()
															{
																ventana.close();
																hK();
															}
													}
												 ]
									}
							   )
	ventana.show();
	dK();
}//Solicitar Mail//Solicta Mail





function eliminarTelefono(Tipo)
{
	var Telefono;
	if (Tipo==0)
		Telefono=gE('cmbTelefono');
	else
		Telefono=gE('cmbTelefonoAds');
	if(Telefono.selectedIndex==-1)
	{
		Ext.MessageBox.alert(lblAplicacion,'Por favor seleccione un Teléfono');
		return;
	}
	function resp(btn)
	{
		if(btn=='yes')
		{
			if(gE('idUsuario').value!='-1')
			{
				Telefono.options[Telefono.selectedIndex]=null;
			}
			else
			{
				Telefono.options[Telefono.selectedIndex]=null;
			}
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este tel&eacute;fono?',resp);
}//Eliminar tel

function guardarMail(valor,Notificar,IdUsuario,tipoMail,ventana)
{
	var mail=gE('txtMail');
	if(valor=='')
	{
		function funcOk()
		{
			mail.focus(true,10);
		}
		Ext.MessageBox.alert(lblAplicacion,'El campo mail es obligatorio',funcOk);
		return;
	}
	if(!validarCorreo(valor))
	{
		function funcOk()
		{
			mail.focus(true,10);
		}
		Ext.MessageBox.alert(lblAplicacion,'La dirección de correo ingresada no es válida',funcOk);
		return;
	}
	var Mail;
	if (tipoMail==0)
		Mail=gE('cmbMail');
	else
		Mail=gE('cmbMailAds');
	
	var IdMail=Mail;
	var x;
	var nuevaOpcion;
	var cadMail=valor+'/'+tipoMail+'/'+Notificar;
	nuevaOpcion=document.createElement('option');
	nuevaOpcion.value=cadMail;
	nuevaOpcion.text=valor;
	Mail.options[Mail.length]=nuevaOpcion;
	ventana.close();
	hK();
}//Guardar Mail

function eliminarMail(tipoMail)
{
	if (tipoMail==0)
		Mail=gE('cmbMail');
	else
		Mail=gE('cmbMailAds');
			
	if(Mail.selectedIndex==-1)
	{
		Ext.MessageBox.alert(lblAplicacion,'Por favor seleccione un Correo');
		return;
	}
	function resp(btn)
	{
		if(btn=='yes')
		{
			Mail.options[Mail.selectedIndex]=null;
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar Est&aacute; cuenta de correo?',resp);
}//Eliminar Mail

function regresar(usr)
{
	var arrParam=[['idUsuario',usr]];
	enviarFormularioDatos('intermediaMostrar.php',arrParam);	
}


function mostrarVentanaAgregarCelular()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
                                            cls:'panelSiugj',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Tipo'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:60,
                                                            html:'<div id="divCmbTipo"></div>'
                                                        },
                                                        {
                                                        	x:300,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Pa&iacute;s'
                                                        },
                                                        {
                                                        	x:300,
                                                            y:60,
                                                            html:'<div id="divCmbPais"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:120,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'N&uacute;mero'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:160,
                                                            width:280,
                                                            xtype:'textfield',
                                                            cls:'controlSIUGJ',
                                                            id:'txtNumero',
                                                            enableKeyEvents:true,
                                                            maskRe:/^[0-9]$/,
                                                            listeners:	{
                                                                            keypress:function(ctrl,e)
                                                                                    {
                                                                                        if(ctrl.getValue().length==10)
                                                                                        {
                                                                                            e.stopEvent();
                                                                                        }
                                                                                    }
                                                                        }
                                                        },
                                                        {
                                                        	x:300,
                                                            y:120,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Extensi&oacute;n'
                                                            
                                                        },
                                                        {
                                                        	x:300,
                                                            y:160,
                                                            width:280,
                                                            xtype:'textfield',
                                                            cls:'controlSIUGJ',
                                                            id:'txtExtension',
                                                            enableKeyEvents:true,
                                                            maskRe:/^[0-9]$/,
                                                            listeners:	{
                                                                            keypress:function(ctrl,e)
                                                                                    {
                                                                                        if(ctrl.getValue().length==6)
                                                                                        {
                                                                                            e.stopEvent();
                                                                                        }
                                                                                    }
                                                                        }
                                                        },
                                                        {
                                                        	x:60,
                                                            y:230,
                                                            hidden:true,
                                                            id:'lblIngreseCodigo',
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Ingrese el código de validación enviado al celular registrado'
                                                        },
                                                        {
                                                        	x:85,
                                                            y:270,
                                                            width:280,
                                                            hidden:true,
                                                            xtype:'textfield',
                                                            cls:'controlSIUGJ',
                                                            id:'txtCodigoValidacion',
                                                            enableKeyEvents:true,
                                                            maskRe:/^[0-9]$/,
                                                            listeners:	{
                                                                            keypress:function(ctrl,e)
                                                                                    {
                                                                                        if(ctrl.getValue().length==6)
                                                                                        {
                                                                                            e.stopEvent();
                                                                                        }
                                                                                    }
                                                                        }
                                                        },
                                                        {
                                                              icon:'../images/arrow_refresh.PNG',
                                                              cls:'btnSIUGJCancel',
                                                              xtype:'button',
                                                              x:380,
                                                              y:265,
                                                              hidden:true,
                                                              id:'btnReenviar',
                                                              text:'Reenviar c&oacute;digo',
                                                              handler:function()
                                                                      {
                                                                          enviarSMSCelular	(
                                                                          						function()
                                                                                                {
                                                                                                	
                                                                                                    
                                                                                                    function respAux()
                                                                                                    {
                                                                                                    	gEx('btnReenviar').disable();
                                                                                                    	gEx('txtCodigoValidacion').focus();
                                                                                                    }
                                                                                                    msgBox('Se ha reenviado un nuevo c&oacute;digo de verificaci&oacute;n al n&uacute;mero registrado',respAux);
                                                                                                    
                                                                                                }
                                                                          					);
                                                                      }
                                                          
                                                      	}
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar tel&eacute;fono',
										width: 650,
										height:350,
										layout: 'fit',
										plain:true,
										modal:true,
                                        closable:false,
                                        id:'vAddCelular',
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	var cmbPais=crearComboExt('cmbPaisV',arrPaises,0,0,280,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbPais'});
																	cmbPais.setValue('52');
                                                                    var cmbTipoTelefono=crearComboExt('cmbTipoTelefonoV',arrTelefonos,0,0,280,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbTipo'});
																	cmbTipoTelefono.on('select',function(cmb,registro)
                                                                    							{
                                                                                                	if(registro.data.id=='2')
                                                                                                    {
                                                                                                    	gEx('txtExtension').setValue('');
                                                                                                    	gEx('txtExtension').disable();
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                    	gEx('txtExtension').enable();
                                                                                                    }
                                                                                                }
                                                                    					)
                                                                
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
                                                            id:'btnAceptarTelefono',
															handler: function()
																	{
                                                                    	var cmbPaisV=gEx('cmbPaisV');
                                                                        if(cmbPaisV.getValue()=='')
                                                                        {
                                                                        	function resp10()
                                                                            {
                                                                            	cmbPaisV.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el pa&iacute;s al cual pertenece el n&uacute;mero tel&eacute;fonico a agregar',resp10);
                                                                        	return;
                                                                        }
                                                                        
																		var cmbTipoTelefono=gEx('cmbTipoTelefonoV');
                                                                        if(cmbTipoTelefono.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbTipoTelefono.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el tipo de tel&eacute;fono a agregar',resp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var txtNumero=gEx('txtNumero');
                                                                        if(txtNumero.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	txtNumero.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el n&uacute;mero de tel&eacute;fono a agregar',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var txtNumero=gEx('txtNumero');
                                                                        if(txtNumero.getValue().length!=10)
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	txtNumero.focus();
                                                                            }
                                                                        	msgBox('El n&uacute;mero de tel&eacute;fono a agregar debe ser de 10 d&iacute;gitos',resp3);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if((cmbTipoTelefono.getValue()=='1')||(gE('vCU').value=='1'))
                                                                        {
                                                                        	var txtTelefono=gEx('txtNumero');
																			var txtExtension=gEx('txtExtension');
																			
																			var tTelefono=gEx('cmbTipoTelefonoV').getRawValue();
																			
																			var idTelefono=gEx('cmbPaisV').getValue()+'_'+txtTelefono.getValue()+'_'+txtExtension.getValue()+'_'+gEx('cmbTipoTelefonoV').getValue()+'_0';
																			var lblPais=gEx('cmbPaisV').getRawValue()
																			var etiqueta='('+tTelefono+') '+txtTelefono.getValue()+(gEx('txtExtension').getValue()==''?'':' Ext. '+gEx('txtExtension').getValue())+' ('+lblPais+')';
																			var nuevaOpcion;
																			nuevaOpcion=document.createElement('option');
																			
																			
																			var hTelefonos=gE('telefonos');
																			nuevaOpcion.value=idTelefono;
																			nuevaOpcion.text=etiqueta;
																			var Telefono=gE('cmbTelefono');
																			Telefono.options[Telefono.length]=nuevaOpcion;
																			ventanaAM.close();
                                                                        }
                                                                        else
                                                                        {
                                                                        
                                                                        
                                                                            enviarSMSCelular(	function()
                                                                                                {
                                                                                                    gEx('btnAceptarTelefono').hide();
                                                                                                    gEx('btnValidarTelefono').show();
                                                                                                    gEx('lblIngreseCodigo').show();
                                                                                                    gEx('txtCodigoValidacion').show();
                                                                                                    gEx('vAddCelular').setHeight(440);
                                                                                                    gEx('btnReenviar').show();
                                                                                                    function respAux()
                                                                                                    {
                                                                                                    	 gEx('txtCodigoValidacion').focus();
                                                                                                    }
                                                                                                    msgBox('Se ha enviado un c&oacute;digo de verificaci&oacute;n al n&uacute;mero registrado',respAux);
                                                                                                }
                                                                                            );
                                                                        }
																	}
														},
                                                        {
															
															text: 'Validar',
                                                            cls:'btnSIUGJ',
                                                            width:140,
                                                            hidden:true,
                                                            id:'btnValidarTelefono',
															handler: function()
																	{
																		function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                switch(arrResp[1])
                                                                                {
                                                                                	case '0':
                                                                                    	msgBox('El c&oacute;digo de verificaci&oacute;n ha expirado, se ha enviado uno nuevo para su validaci&oacute;n');
                                                                                    break;
                                                                                    case '1':
                                                                                    	
                                                                                   		var txtTelefono=gEx('txtNumero');
                                                                                        var txtExtension=gEx('txtExtension');
                                                                                        
                                                                                        var tTelefono=gEx('cmbTipoTelefonoV').getRawValue();
                                                                                        
                                                                                        var idTelefono=gEx('cmbPaisV').getValue()+'_'+txtTelefono.getValue()+'_'+txtExtension.getValue()+'_'+gEx('cmbTipoTelefonoV').getValue()+'_1';
						                                                                var lblPais=gEx('cmbPaisV').getRawValue()
                                                                                        var etiqueta='('+tTelefono+') '+txtTelefono.getValue()+(gEx('txtExtension').getValue()==''?'':' Ext. '+gEx('txtExtension').getValue())+' ('+lblPais+')';
                                                                                        var nuevaOpcion;
                                                                                        nuevaOpcion=document.createElement('option');
                                                                                        
                                                                                        
                                                                                        var hTelefonos=gE('telefonos');
                                                                                        nuevaOpcion.value=idTelefono;
                                                                                        nuevaOpcion.text=etiqueta;
                                                                                        var Telefono=gE('cmbTelefono');
                                                                                        Telefono.options[Telefono.length]=nuevaOpcion;
                                                                                        ventanaAM.close();
                                                                                        
                                                                                        
                                                                                        
                                                                                    break;
                                                                                    case '2':
                                                                                    	msgBox('El c&oacute;digo de verificaci&oacute;n ingresado no es v&aacute;lido');
                                                                                    	
                                                                                    break;
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax, 'POST','funcion=39&codigo='+gEx('txtCodigoValidacion').getValue()+'&numeroCelular='+gEx('txtNumero').getValue(),true);
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
}

function enviarSMSCelular(afterSend)
{

	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
	        if(afterSend)
	            afterSend();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax, 'POST','funcion=38&p='+gEx('cmbPaisV').getValue()+'&numeroCelular='+gEx('txtNumero').getValue(),true);


	
}

function cambiarMayusculasTexto(txt)
{
	txt.value=txt.value.toUpperCase();
}