Ext.onReady(Inicializar);
function Inicializar()
{
	
	
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
		var cmbTelefonos=gE('cmbTelefonoAds');
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
		
		var cmbMail=gE('cmbMailAds');
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
}


function solicitarTel(IdUsuario,TipoTel)
{
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
														
														new Ext.form.NumberField
														(
															{
																x:100,
																y:5,
																width:40,
																height:20,
																id:'txtLada',
																maxLengthText:'La lada debe contener solo 3 números.',
																maxLength:3,
																allowDecimals:false
															}
														),
														new Ext.form.NumberField
														(
															{
																x:150,
																y:5,
																width:100,
																height:20,
																id:'txtTelefono',
																allowDecimals:false,
																enableKeyEvents:true
															}
														),
														new Ext.form.NumberField
														(
															{
																x:100,
																y:40,
																width:150,
																height:20,
																id:'txtExtensiones',
																allowDecimals:false,
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
															x:150,
															y:70,
															//autoShow :true,
															checked:false,
															boxLabel:'Celular',
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
																var combo=gE('cmbTelefono');
																
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
	Tipo2='0';
	ventana.show();
	dK();
}

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
	
}//radioCheck

function guardarTelefono(valor,extens,Tipo2,tipoTel,Lada,ventana,IdUsuario)
{
	var tTelefono;
	switch(Tipo2)
	{
		case "0":
			tTelefono='Teléfono';
		break;
		case "1":
			tTelefono='Celular';
		break;
		case "2":
			tTelefono='Fax';
		break;
	}

	var tel=Ext.getCmp('txtTelefono');
	var ext=Ext.getCmp('txtExtensiones');
	var lada=Ext.getCmp('txtLada');
	var cmbTelefono=gE('cmbTelefono');	
	if((Lada+'').length!=3)
	{
		function funcOk1()
		{
			lada.focus(true,10);
		}
		Ext.MessageBox.alert(lblAplicacion,'El campo Lada es obligatorio y solo consta de 3 dígitos numéricos.',funcOk1);
		return;
	}
	
	if((valor+'').trim()=='')
	{
		function funcOk()
		{
			tel.focus(true,10);
		}
		Ext.MessageBox.alert(lblAplicacion,'El campo Teléfono es obligatorio',funcOk);
		return;
	}
	
	Telefono=gE('cmbTelefonoAds');
	
	var x;
	var nuevaOpcion;
	nuevaOpcion=document.createElement('option');
	
	if (extens!="")
		nuevaOpcion.text=Lada+"-"+valor + " ("+extens+") - "+tTelefono;
	else
		nuevaOpcion.text=Lada+"-"+valor+" () - "+tTelefono;
	var hTelefonos=gE('telefonos');
	var cadTel=Lada+'_'+valor+'_'+extens+'_'+Tipo2;
	nuevaOpcion.value=cadTel;
	Telefono.options[Telefono.length]=nuevaOpcion;
	
	ventana.close();
	hK();
}//Guardar Tel//Guarda Telefono



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
			Telefono.options[Telefono.selectedIndex]=null;
	}
	msgConfirm('Est&aacute; seguro de querer remover el tel&eacute;fono seleccionado?',resp);	
}


function solicitarMail(IdUsuario,tipoMail)
{
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
	function resp(btn)
	{
		if(btn=='yes')
			Mail.options[Mail.selectedIndex]=null;
	}
	msgConfirm('Est&aacute; seguro de querer remover el correo electr&oacute;nico seleccionado?',resp);	
	
	
	
}

function regresar(usr)
{
	var arrParam=[['idUsuario',usr]];
	enviarFormularioDatos('intermediaMostrar.php',arrParam);	
}