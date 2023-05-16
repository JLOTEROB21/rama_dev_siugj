Ext.onReady(Inicializar);
function Inicializar()
{
	cargaPuesto();
	
}

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


	
function guardarAdscripcion(form)
{
	if (!validarFormularios(form))
	{
		return;
	}
	else
	{
		var formulario=gE(form);
		formulario.submit();
	}
}

function solicitarTel(IdUsuario,TipoTel)
{
	if(IdUsuario==0)
	{
			Ext.MessageBox.alert(lblAplicacion,'Solo podrá registrar un número telefónico, después de haber guardado el resto de la información.');
			return;
	}
	
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
																					text: 'Lada/Teléfono:'
																				}
																		   ),
														new Ext.form.Label(
																		   		{
																					x:5,
																					y:43,
																					text: 'Extensiones:'
																				}
																		   ),
														
														new Ext.form.TextField
														(
															{
															x:100,
															y:5,
															width:40,
															height:20,
															id:'txtLada'
															}
														),
														new Ext.form.TextField
														(
															{
															x:150,
															y:5,
															width:100,
															height:20,
															id:'txtTelefono',
															enableKeyEvents:true,
															listeners:   {
																			'keydown':
																			{
																				scope:this,
																				fn: function(control,e)
																					{
																							var num = e?e.keyCode:event.keyCode;
																							return false;
																					}
																			}
																		}   
														}
														),
														new Ext.form.TextField
														(
																			   {
															x:100,
															y:40,
															width:150,
															height:20,
															id:'txtExtensiones'
														}
														),
														new Ext.form.Label(
																		   		{
																					x:5,
																					y:70,
																					text: 'Tipo:'
																				}
																		   ),
														new Ext.form.Radio
														(
															{
															x:100,
															y:70,
															//autoShow:true,
															checked:true,
															boxLabel:'Tel.',
															allowBlank :true,
															value:'0',
															id:'Tel'
															}
														),
														new Ext.form.Radio
														(
															{
															x:160,
															y:70,
															//autoShow :true,
															checked:false,
															boxLabel:'Movil',
															allowBlank :true,
															value:'1',
															id:'Movil'
															}
														),
														new Ext.form.Radio
														(
															{
															x:220,
															y:70,
															//autoShow :true,
															checked:false,
															boxLabel:'Fax',
															allowBlank :true,
															value:'2',
															id:'Fax'
															}
														)
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar Número Telefónico',
										width:300,
										height:160,
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
																var m=Ext.getCmp('txtTelefono');
																var exten=Ext.getCmp('txtExtensiones');
																var Lada=Ext.getCmp('txtLada');
																Lada.focus(true,10);
															}
												}
											},
										buttons:
												[
												 	{
														text:'Aceptar',
														handler:function ()
															{
																var Tel=Ext.getCmp('txtTelefono').getValue();
																var exten=Ext.getCmp('txtExtensiones').getValue();
																var Lada=Ext.getCmp('txtLada').getValue();
																guardarTelefono(Tel,exten,Tipo2,TipoTel,Lada,ventana,IdUsuario);
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
	
	var tel=Ext.getCmp('Tel');
	var fax=Ext.getCmp('Fax');
	var movil=Ext.getCmp('Movil');
	tel.on('check',radioCheck);
	fax.on('check',radioCheck);
	movil.on('check',radioCheck);
	Tipo2=0;
	ventana.show();
	dK();
}//Solicitar Tel

function radioCheck(chk,valor)
{
	if(valor==true)
	{
		var tel=Ext.getCmp('Tel');
		var fax=Ext.getCmp('Fax');
		var movil=Ext.getCmp('Movil');
		
		Tipo2=chk.value;
		
		if(tel.id!=chk.id)
			tel.setValue(false);
		if(fax.id!=chk.id)
			fax.setValue(false);
		if(movil.id!=chk.id)
			movil.setValue(false);
	}
	
}//radi Check

function solicitarMail(IdUsuario,tipoMail)
{
	if(IdUsuario==0)
	{
		Ext.MessageBox.alert(lblAplicacion,'Solo podrá registrar un correo electrónico, después de haber guardado el resto de la información.');
		return;
	}
	
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
															width:220,
															height:20,
															id:'txtMail'
														}
														),
														new Ext.form.Checkbox
														(
															{
															x:5,
															y:35,
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
										width:380,
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
}//Solicitar Mail

function guardarTelefono(valor,extens,Tipo2,tipoTel,Lada,ventana,IdUsuario)
{
	var tel=Ext.getCmp('txtTelefono');
	var ext=Ext.getCmp('txtExtensiones');
	var lada=Ext.getCmp('txtLada');
	
	if(Lada.trim()=='' || (Lada.length!=3) || (isNaN(Lada)==true))
	{
		function funcOk1()
		{
			lada.focus(true,10);
		}
		Ext.MessageBox.alert(lblAplicacion,'El campo Lada es obligatorio y solo consta de 3 dígitos numéricos.',funcOk1);
		return;
	}
	
	if(valor.trim()=='')
	{
		function funcOk()
		{
			tel.focus(true,10);
		}
		Ext.MessageBox.alert(lblAplicacion,'El campo Teléfono es obligatorio',funcOk);
		return;
	}
	
	
	function funcTratarRespuesta()
	{
		var resp=peticion_http.responseText;
		var arrResp=resp.split('|');
		if(arrResp[0]==1 || arrResp[0]=='1')
		{
			var Telefono;
			if (tipoTel==0)
				Telefono=gE('cmbTelefono');
			else
				Telefono=gE('cmbTelefonoAds');
			
			var IdTelefono=arrResp[1];
			var x;
			var nuevaOpcion;

				nuevaOpcion=document.createElement('option');
				nuevaOpcion.value=IdTelefono;
				if (extens!="")
					nuevaOpcion.text=Lada+"-"+valor + " ("+extens+")";
				else
					nuevaOpcion.text=Lada+"-"+valor;
					
				Telefono.options[Telefono.length]=nuevaOpcion;
		}
		else
			alert("Error :"+arrResp[0]);
	}
	obtenerDatosWeb('intermediaProcesar.php',funcTratarRespuesta, 'POST','banderaGuardar=guardaTelefono&Tel='+valor+'&Tipo2='+Tipo2+'&tipoTel='+tipoTel+'&Extensiones='+extens+'&Lada='+Lada+'&idUsuario='+IdUsuario);
	ventana.close();
	hK();
}

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
		
	function funcTratarRespuesta()
	{
		var resp=peticion_http.responseText;
		var arrResp=resp.split('|');
		if(arrResp[0]==1 || arrResp[0]=='1')
		{
			Telefono.options[Telefono.selectedIndex]=null;
		}
		else
			alert("Error :"+arrResp[0]);
	}
	obtenerDatosWeb('intermediaProcesar.php',funcTratarRespuesta, 'POST','banderaGuardar=eliminaTelefono&IdTel='+Telefono.value);
}


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
	function funcTratarRespuesta()
	{
		var resp=peticion_http.responseText;
		var arrResp=resp.split('|');
		if(arrResp[0]==1 || arrResp[0]=='1')
		{
			var Mail;
			if (tipoMail==0)
				Mail=gE('cmbMail');
			else
				Mail=gE('cmbMailAds');
			
			var IdMail=arrResp[1];
			var x;
			var nuevaOpcion;

				nuevaOpcion=document.createElement('option');
				nuevaOpcion.value=IdMail;
				nuevaOpcion.text=valor;
				Mail.options[Mail.length]=nuevaOpcion;
		}
		else
			alert("Error :"+arrResp[0]);
	}
	obtenerDatosWeb('intermediaProcesar.php',funcTratarRespuesta, 'POST','banderaGuardar=guardaMail&Mail='+valor+'&IdUsuario='+IdUsuario+'&Notificacion='+Notificar+'&tipoMail='+tipoMail);
	ventana.close();
	hK();
}

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
	function funcTratarRespuesta()
	{	
		var resp=peticion_http.responseText;
		var arrResp=resp.split('|');
		if(arrResp[0]==1 || arrResp[0]=='1')
			Mail.options[Mail.selectedIndex]=null;
		else
			alert("Error :"+arrResp[0]);
	}
	obtenerDatosWeb('intermediaProcesar.php',funcTratarRespuesta, 'POST','banderaGuardar=eliminaMail&IdMail='+Mail.value);
}

function regresar(usr)
{
	var arrParam=[['idUsuario',usr]];
	enviarFormularioDatos('intermediaMostrar.php',arrParam);	
}