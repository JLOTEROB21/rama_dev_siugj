Ext.onReady(Inicializar);
var ct=1;


RegistroRelacion =Ext.data.Record.create	(
												[
													{name: 'idRelacion'},
													{name: 'Persona'},
													{name: 'Relacion'}
												]
											)


RegistroRelacionAlumnos =Ext.data.Record.create	(
												[
													{name: 'idPersona'},
													{name: 'Persona'}
												]
											)											

var alRelaciones=new Array();

function Inicializar()
{
	if(ct==1)
	{
		ct++;
		function funcFechaCamb(campo,nuevoV,viejoV)
		{
			var f=new  Date(nuevoV);
			gE('FNacimiento').value=f.format('d/m/Y');
		}
		var fecha=new Date();
		fecha=new Date(fecha.getDay()+'/'+fecha.getMonth()+'/'+(fecha.getYear()-15));
		var FNac=new Ext.form.DateField
										(
											{
												id:'fecha',
												x:0,
												y:0,
												width:130,
												format:'d/m/Y',
												maxValue: fecha, 
												renderTo:'FNac',
												readOnly:true,
												height:150,
												cls:'campoFecha'
											}
										)
		var FNacimiento=gE('FNacimiento');
		FNac.setValue(FNacimiento.value);
		FNac.on('change',funcFechaCamb)
		gE('Apellido_Paterno').focus();
		
		var x;
		var numA=gE('hNumAlumnos').value;
		for(x=0;x<numA;x++)
		{
			alRelaciones[x]=new Ext.data.SimpleStore(
														{
															fields:	[
																		{name: 'idRelacion'},
																		{name: 'Persona'},
																		{name: 'Relacion'}
																	]
														}
													);
		}
		
		for(x=1;x<=numA;x++)
		{
			crearTablaRelaciones(x);
		}
		
		
		
	}
	
}//Iniciar

var keyMap = new Ext.KeyMap(document, 
									{
										key: 13, 
										fn: funAceptar,
										scope: this
									}
							);

function funAceptar()
{
	GuardarDatos('reinscripcion');
}


function lanzarVentana1(persona,ref,numA)
{
	dK();
	gE('Apellido_Paterno').focus();	
	return WPopup('LATIS - Ficha Médica ['+persona+']',ref+'&numA='+numA,670,850,null,miFuncion);

}

function lanzarVentana2(persona,ref)
{
	dK();
	gE('Apellido_Paterno').focus();
	return WPopup('LATIS - Datos del alumno ['+persona+']',ref,450,850,null,miFuncion);
	
}

function lanzarVentana3(referencia)
{
	dK();
	gE('Apellido_Paterno').focus();
	return WPopup('LATIS - Cuenta de Usuario',referencia,550,850,null,cambiarSes);
}

function lanzarVentana5(persona,ref,numA)
{
	dK();
	gE('Apellido_Paterno').focus();	
	return WPopup('LATIS - Ver documentos solicitados['+persona+']',ref+'&numA='+numA,670,850,null,miFuncion);

}

function nuevoAspirante(referencia)
{
	dK();
	gE('Apellido_Paterno').focus();
	return WPopup('LATIS',referencia,500,1000,null,miFuncion);
}

function miFuncion()
{
	var salir=true;
	hK();
}
function cerrarSesion()
{
	
	var x;
	var numA=gE('hNumAlumnos').value;
	var estadoAlumnos='';
	var nomAlum;
	var estadoAlum='';
	var ct=0;
	var alumNo='Los siguientes alumnos a&uacute;n <b>NO</b> han sido reinscritos:<br><br><br>';
	for(x=1;x<=numA;x++)
	{
		nomAlum=gE('alumno'+x).value;
		if(nomAlum==0)
		{

			estadoAlum+=gE('nomAlumno'+x).value+"<br>";
			ct++;
		}
	}
	
	alumNo+=estadoAlum;
	if(ct>0)
	{
		function funcResp(btn)
		{
			if(btn=='yes')
			{
				function funcTratarRespuesta()
				{
					var resp=peticion_http.responseText;
					location.href='../principal/inicio.php';
				}
				obtenerDatosWeb('../paginasFunciones/procesarReinscripcion.php',funcTratarRespuesta, 'POST','funcion=9');	
			}
		}
		Ext.MessageBox.confirm(lblAplicacion,alumNo+'<br>Realmente desea salir del sistema?',funcResp);
	}
	else
	{
		function funcTratarRespuesta()
		{
			var resp=peticion_http.responseText;
			location.href='../principal/inicio.php';
		}
		obtenerDatosWeb('../paginasFunciones/procesarReinscripcion.php',funcTratarRespuesta, 'POST','funcion=9');		
	}
}//Cerrar sesion

function cambiarSesion()
{
	
	function funcTratarRespuesta()
	{
		var resp=peticion_http.responseText;
		if(resp==1 || resp=='1')
		{
			location.reload();
		}
	}
	obtenerDatosWeb('../paginasFunciones/procesarReinscripcion.php',funcTratarRespuesta, 'POST','funcion=8');		
}//Cambiar sesion


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
														
														new Ext.form.TextField
														(
															{
															x:100,
															y:5,
															width:40,
															height:20,
															id:'txtLada',
															maxLengthText:'La lada debe contener solo 3 números.',
															maxLength:3
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
															autoShow:true,
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
															autoShow :true,
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
															autoShow :true,
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
	Tipo2='0';
	dK();
	ventana.show();
}//SolictaTel

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
															width:150,
															height:20,
															id:'txtMail'
														}
														),
														new Ext.form.Checkbox
														(
															{
															x:5,
															y:35,
															autoShow:true,
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
										width:310,
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
	dK();
	ventana.show();
}//Solicitar Mail

function cambiarSes()
{
	document.location.href="reinscripcion.php";
	parent.parent.GB_hide();
	location.reload();
}//Cambiar sesion

function Relaciones(Id,cmb)
{
	var Rel=gE(cmb);
	var obj='{"IdAlumno":"'+Id+'","Parentezco":"'+Rel.value+'"}';
	function funcTratarRespuesta()
	{
			var resp=peticion_http.responseText;	
	}
	obtenerDatosWeb('../paginasFunciones/procesarReinscripcion.php',funcTratarRespuesta, 'POST','funcion=1&objDatos='+obj);		
}//Relaciones

function solicitarVive(IdAlumno,IdUsuario)
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
																					text: 'Calle:'
																				}
																		   ),
														new Ext.form.Label(
																		   		{
																					x:5,
																					y:43,
																					text: 'Número:'
																				}
																		   ),
														new Ext.form.Label(
																		   		{
																					x:5,
																					y:73,
																					text: 'Colonia:'
																				}
																		   ),
														new Ext.form.Label(
																		   		{
																					x:5,
																					y:103,
																					text: 'Ciudad:'
																				}
																		   ),
														new Ext.form.Label(
																		   		{
																					x:5,
																					y:133,
																					text: 'Municipio:'
																				}
																		   ),
														new Ext.form.Label(
																		   		{
																					x:5,
																					y:163,
																					text: 'Estado:'
																				}
																		   ),
														new Ext.form.Label(
																		   		{
																					x:5,
																					y:193,
																					text: 'País:'
																				}
																		   ),
														new Ext.form.Label(
																		   		{
																					x:5,
																					y:213,
																					text: 'CP:'
																				}
																		   ),
														
														new Ext.form.TextField
														(
															{
															x:80,
															y:5,
															width:150,
															height:20,
															id:'txtCalle'
															}
														),
														new Ext.form.TextField
														(
															{
															x:80,
															y:35,
															width:150,
															height:20,
															id:'txtNumero',
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
															x:80,
															y:65,
															width:150,
															height:20,
															id:'txtColonia'
														}
														),
														
														new Ext.form.TextField
														(
																			   {
															x:80,
															y:95,
															width:150,
															height:20,
															id:'txtCiudad'
														}
														),
														new Ext.form.TextField
														(
																			   {
															x:80,
															y:125,
															width:150,
															height:20,
															id:'txtMunicipio'
														}
														),
														new Ext.form.TextField
														(
																			   {
															x:80,
															y:155,
															width:150,
															height:20,
															id:'txtEstado'
														}
														),
														new Ext.form.TextField
														(
																			   {
															x:80,
															y:185,
															width:150,
															height:20,
															id:'txtPais'
														}
														),
														new Ext.form.TextField
														(
																			   {
															x:80,
															y:215,
															width:150,
															height:20,
															id:'txtCP'
														}
														)
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Registro de Dirección',
										width:280,
										height:320,
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
																var Calle=Ext.getCmp('txtCalle');
																var Numero=Ext.getCmp('txtNumero');
																var Colonia=Ext.getCmp('txtColonia');
																var Ciudad=Ext.getCmp('txtCiudad');
																var Estado=Ext.getCmp('txtEstado');
																var Municipio=Ext.getCmp('txtMunicipio');
																var CP=Ext.getCmp('txtCP');
																var Pais=Ext.getCmp('txtPais');
																Ext.getCmp('txtCalle').focus(true,10);
															}
												}
											},
										buttons:
												[
												 	{
														text:'Aceptar',
														handler:function ()
															{																
																var Calle=Ext.getCmp('txtCalle').getValue();
																var Numero=Ext.getCmp('txtNumero').getValue();
																var Colonia=Ext.getCmp('txtColonia').getValue();
																var Ciudad=Ext.getCmp('txtCiudad').getValue();
																var Estado=Ext.getCmp('txtEstado').getValue();
																var Municipio=Ext.getCmp('txtMunicipio').getValue();
																var CP=Ext.getCmp('txtCP').getValue();
																var Pais=Ext.getCmp('txtPais').getValue();
																guardarVive(Calle,Numero,Colonia,Ciudad,Estado,Municipio,Pais,CP,ventana,IdAlumno,IdUsuario);

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
}//Solicitar Vive

function guardarVive(Calle,Numero,Colonia,Ciudad,Estado,Municipio,Pais,CP,ventana,IdAlumno,IdUsuario)
{
	if(Calle.trim()=='')
	{

		function funcOk()
		{
			Ext.getCmp('txtCalle').focus(true,10);
		}
		Ext.MessageBox.alert(lblAplicacion,'El campo Calle es obligatorio',funcOk);
		return;
	}
	
	if(Numero.trim()=='')
	{
		function funcOk1()
		{
			Ext.getCmp('txtNumero').focus(true,10);
		}
		Ext.MessageBox.alert(lblAplicacion,'El campo Número es obligatorio',funcOk1);
		return;
	}
	
	if(Colonia.trim()=='')
	{
		function funcOk2()
		{
			Ext.getCmp('txtColonia').focus(true,10);
		}
		Ext.MessageBox.alert(lblAplicacion,'El campo Colonia es obligatorio',funcOk2);
		return;
	}
	
	if(Ciudad.trim()=='')
	{
		function funcOk3()
		{
			Ext.getCmp('txtCiudad').focus(true,10);
		}
		Ext.MessageBox.alert(lblAplicacion,'El campo Ciudad es obligatorio',funcOk3);
		return;
	}
	
	var obj='{"Calle":"'+Calle+'","Numero":"'+Numero+'","Colonia":"'+Colonia+'","Ciudad":"'+Ciudad+'","Estado":"'+Estado+'","Municipio":"'+Municipio+'","Pais":"'+Pais+'","CP":"'+CP+'","IdAlumno":"'+IdAlumno+'","IdUsuario":"'+IdUsuario+'"}';
		
		function funcTratarRespuesta()
		{
				var resp=peticion_http.responseText;
				if(resp==1 || resp=='-1')
				{
					ventana.close();
					hK();

				}
		}
		obtenerDatosWeb('../paginasFunciones/procesarReinscripcion.php',funcTratarRespuesta, 'POST','funcion=12&objDatos='+obj);	
}//Guardar Vive
	
function viveCon(form,IdAlumno,cmb)
{	
	var vive=gE(cmb);
	switch(vive.value)
	{
		case -1://No selecciono nada
		case '-1':
			return;
		break;
		//case -2://Otro
		//case '-2':
			//solicitarVive(IdAlumno,vive.value);
		//break;
		default:
			guardarVivePapas();
	}//vive Con

	function guardarVivePapas()
	{
		var obj='{"IdAlumno":"'+IdAlumno+'","IdUsuario":"'+vive.value+'"}';
		
		function funcTratarRespuesta()
		{
				var resp=peticion_http.responseText;	
		}
		obtenerDatosWeb('../paginasFunciones/procesarReinscripcion.php',funcTratarRespuesta, 'POST','funcion=11&objDatos='+obj);		
	}
}//vivePapas


function guardaReinscritos(Id,Grado,Programa,Reinscr,numLbl)
{
	var grado=gE(Grado);
	var programa=gE(Programa);
	var Reinscribir=gE(Reinscr);
	var prog;
	var obj='{"IdAlumno":"'+Id+'","Grado":"'+grado.value+'","Programa":"'+programa.value+'"}';
	
	function funcTratarRespuesta()
	{
		var resp=peticion_http.responseText;
		if(resp==2 || resp=='2')
		{
			dK();
			function resp()
			{
				hK();
			}
			Ext.MessageBox.alert(lblAplicacion,'No puede reinscribir al alumno sin antes haber llenado su ficha m&eacute;dica.',resp)
			return;
		}
		
		var td=gE('td'+numLbl);
		td.innerHTML='<img src="../images/publish_f2.png"  height="20" width="20" title="Estado: Reinscrito" />';
		
		
		
		gE('lblEstado'+numLbl).innerHTML="<font color='green'><b>Reinscrito</b></font>";
		//--
		var x=1;
		var numAlumnos=gE('hNumAlumnos').value;
		var idAlumno;
		for(x=1;x<=numAlumnos;x++)
		{
			idAlumno=gE('idAlumno'+x).value;
			if(idAlumno==Id)
			{
				gE('alumno'+x).value='1';
				break;
			}
		}
	}
	obtenerDatosWeb('../paginasFunciones/procesarReinscripcion.php',funcTratarRespuesta, 'POST','funcion=2&objDatos='+obj);		
	
}//Guarda Reinscritos

function GuardarDatos(form)
{
	
	if (!validarFormularios(form))
	{
		return;
	}
	var Apellido_Paterno=gE('Apellido_Paterno');
	var Apellido_Materno=gE('Apellido_Materno');
	var Nombre=gE('Nombre');
	var RFC=gE('RFC');
	var Calle=gE('Calle');
	var Numero=gE('Numero');
	var Colonia=gE('Colonia');
	var Ciudad=gE('Ciudad');
	var IdDireccionCasa=gE('IdDireccionCasa');
	var fecha=gE('fecha');
	var Empresa=gE('Empresa');
	var Profesion=gE('Profesion');
	var Puesto=gE('Puesto');
	var IdDireccionLab=gE('IdDireccionLab');
	var Municipio=gE('Municipio');
	var CP=gE('CP');
	
	
	var obj='{"Apellido_Paterno":"'+Apellido_Paterno.value+'","Apellido_Materno":"'+Apellido_Materno.value+'","Nombre":"'+Nombre.value+'","RFC":"'+RFC.value+'","Calle":"'+Calle.value+'","Numero":"'+Numero.value+'","Colonia":"'+Colonia.value+'","Ciudad":"'+Ciudad.value+'","IdDireccionCasa":"'+IdDireccionLab.value+'","FechaNac":"'+fecha.value+'","Empresa":"'+Empresa.value+'","Profesion":"'+Profesion.value+'","Puesto":"'+Puesto.value+'","IdDireccionLab":"'+IdDireccionLab.value+'","Municipio":"'+Municipio.value+'","CP":"'+CP.value+'"}';
	
	function funcTratarRespuesta()
	{
		var resp=peticion_http.responseText;
		var arrResp=resp.split('|');
		if(arrResp[0]==1 || arrResp[0]=='1')
		{
			dK();
			function resp()
			{
				hK();
			}
			var x;
			var numA=gE('hNumAlumnos').value;
			var estadoAlumnos='';
			var nomAlum;
			var estadoAlum;
			
			for(x=1;x<=numA;x++)
			{
				nomAlum=gE('alumno'+x).value;
				if(nomAlum==0)
					nomAlum='<font color="red"><b>Sin reinscribir</b></font>';
				else
					if(nomAlum==1)
						nomAlum='<font color="green"><b>Reinscrito</b></font>';
					else
						nomAlum='<font color="blue"><b>Nuevo ingreso</b></font>';
					
				estadoAlum=gE('nomAlumno'+x).value;
				estadoAlumnos+=estadoAlum+' ('+nomAlum+')<br>';
			}
			
			
			Ext.MessageBox.alert('LATIS','Sus datos se actualizaron correctamente.<br>El estado de los alumnos asociados a su cuenta es el siguiente:<br><br>'+estadoAlumnos,resp)
			
		}
	}
	obtenerDatosWeb('../paginasFunciones/procesarReinscripcion.php',funcTratarRespuesta, 'POST','funcion=5&objDatos='+obj);		
	
}//Guarda datos


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
				Telefono=gE('Telefono');
			else
				Telefono=gE('TelefonoLab');
			
			var IdTelefono=arrResp[1];
			var x;
			var nuevaOpcion;

				nuevaOpcion=document.createElement('option');
				nuevaOpcion.value=IdTelefono;
				if (extens!="")
					nuevaOpcion.text=Lada+"-"+valor + " ("+extens+") - "+tTelefono;
				else
					nuevaOpcion.text=Lada+"-"+valor+" () - "+tTelefono;
					
				Telefono.options[Telefono.length]=nuevaOpcion;
		}
		else
			alert("Error :"+arrResp[0]);
	}
	obtenerDatosWeb('../paginasFunciones/procesarReinscripcion.php',funcTratarRespuesta, 'POST','funcion=3&Tel='+valor+'&Tipo2='+Tipo2+'&tipoTel='+tipoTel+'&Extensiones='+extens+'&Lada='+Lada+'&idUsuario='+IdUsuario);
	ventana.close();
	hK();
}//GuardaTelefono

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
			var Mail=gE('Mail');
			
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

obtenerDatosWeb('../paginasFunciones/procesarReinscripcion.php',funcTratarRespuesta, 'POST','funcion=6&Mail='+valor+'&IdUsuario='+IdUsuario+'&Notificacion='+Notificar+'&tipoMail='+tipoMail);

	ventana.close();
	hK();
}//Guardar Mail

function eliminarTel(Tipo)
{
	var Telefono;
	if (Tipo==0)
		Telefono=gE('Telefono');
	else
		Telefono=gE('TelefonoLab');
	if(Telefono.selectedIndex==-1)
	{
		dK();
		function resp()
		{
			hK();
		}
		Ext.MessageBox.alert('LATIS','Por favor seleccione un Teléfono',resp);
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
		{
			dK();
			function resp()
			{
				hK();
			}
			alert("Error :"+arrResp[0],resp);
		}
	}
	
	obtenerDatosWeb('../paginasFunciones/procesarReinscripcion.php',funcTratarRespuesta, 'POST','funcion=4&IdTel='+Telefono.value);
}//Eliminar Tel

function eliminarMail()
{
	var Mail=gE('Mail');	
			
	if(Mail.selectedIndex==-1)
	{
		dK();
		function resp()
		{
			hK();
		}
		Ext.MessageBox.alert('LATIS','Por favor seleccione un Correo',resp);
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
	
	obtenerDatosWeb('../paginasFunciones/procesarReinscripcion.php',funcTratarRespuesta, 'POST','funcion=7&IdMail='+Mail.value);
}//Eliminar mail

function removerInscripcion(idElemento)
{
	function resp(btn)
	{
		if(btn=='yes')
		{
			function funcTratarRespuesta()
			{
				var resp=peticion_http.responseText;
				var arrResp=resp.split('|');
				if(arrResp[0]==1 || arrResp[0]=='1')
				{
					location.reload();
				}
				else
					alert("Error :"+arrResp[0]);
			}
			obtenerDatosWeb('../paginasFunciones/procesarReinscripcion.php',funcTratarRespuesta, 'POST','funcion=13&idInscripcion='+idElemento);
		}
	}
	Ext.MessageBox.confirm("CLH","¿Est&aacute; seguro de querer eliminar &eacute;sta pre-inscripci&oacute;n?",resp);
	
}

function crearTablaRelaciones(id)
{
	alRelaciones[id-1].loadData(arrRelaciones[id]);	
		
	var cmPersonas= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														{
															header:'Persona',
															width:300,
															sortable:true,
															dataIndex:'Persona'

														},
														{
															header:'Relación',
															width:100,
															sortable:true,
															dataIndex:'Relacion',
															renderer:function(val)
																	{
																		var x=0;
																		
																		for(x=0;x<arrTiposRelaciones.length;x++)
																		{
																			
																			//alert(arrRelaciones[x].IdRelacion+'=='+val);
																			if(arrTiposRelaciones[x].IdRelacion==val)
																				return arrTiposRelaciones[x].Tipo;
																		}
																		return 'S/E';
																		
																	},
															editor:new Ext.form.ComboBox(
																						 	{
																							   typeAhead: true,
																							   triggerAction: 'all',
																							   transform:'cmbRelaciones'+id,
																							   lazyRender:true
																							}
																						)															 
															

														}
													]
												);
											
												
	var tblPersonas=	new Ext.grid.EditorGridPanel	(
														{
															id:'tblPersonas'+id,
															store:alRelaciones[id-1],
															frame:true,
															cm: cmPersonas,
															height:150,
															width:500,
															clicksToEdit:1,
															renderTo:'tblRelaciones'+id,
															tbar:	[	
																			{
																				text:'Agregar Relaci&oacute;n',
																				handler:function()
																						{
																							var idAlumno=gE('idAlumno'+id).value;
																							if(idAlumno=='-1')
																							{
																								Ext.MessageBox.alert(lblAplicacion,'Primero debe seleccionar un alumno para relacionar',resp)
																								return;
																							}
																							mostrarVentanaAgregar(tblPersonas,idAlumno,id);
																						}
																			}
																			/*,
																			{
																				text:'Eliminar Relaci&oacute;n',
																				handler:function()
																					{
																						//eliminaUsuario(tblPersonas);
																					}
																				
																			}*/
																	 ]
																
														}
					
    												);
	tblPersonas.on('afteredit',funcEditar);
}

function funcEditar(e)
{
	
	function funcGuardar()
	{
		var resp=peticion_http.responseText.split('|');
		if(resp[0]=='1')
		{}
		else
		{
			msgBox('No se ha podido realizar la operaci&oacute;n debido al siguiente error:'+' <br />'+resp[0]);
		}		
	}
	obtenerDatosWeb("../paginasFunciones/funcionesUsuarios.php",funcGuardar,'POST','funcion=3&'+'idParentezco='+e.value+'&idRelacion='+e.record.get('idRelacion'),true);
}

function mostrarVentanaAgregar(tblDatos,idAlumno,id)
{
	var idUsuarioActual=gE('idUsuarioActual').value;
	var tblRelaciones=crearTblRelaciones(idAlumno,idUsuarioActual);
	var cmbRelaciones=crearComboRel();
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											disabled:false,
											items: 	[
														new Ext.form.Label(
																		   		{
																					x:5,
																					y:10,
																					text: 'Usuarios disponibles:'
																				}
																		   ),
																		 
														new Ext.form.Label(
																		   		{
																					x:150,
																					y:20,
																					html: '<font color="black">Para agregar un nuevo usuario de click</font><a href="javascript:agregarNuevoUSuario(\''+tblDatos.id+'\',\''+idAlumno+'\',\''+id+'\')"><font color="red"><b> Aqu&iacute;</b></font></a>'
																				}
																		   ),
																		 
														tblRelaciones,
														new Ext.form.Label(
																		   		{
																					x:5,
																					y:200,
																					 html : 'Relaci&oacute;n:'
																				}
																		   ),
														cmbRelaciones
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										id:'vtnAgregarN',
										title:'Agregar nueva relaci&oacute;n',
										width:450,
										height:300,
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
																//var m=Ext.getCmp('txtMail');
																//m.focus(true,10);
															}
												}
											},
										buttons:
												[
												 	{
														text:'Aceptar',
														handler:function ()
															{
															
																var fila=tblRelaciones.getSelectionModel().getSelected();
																if(fila == undefined)
																{
																	Ext.MessageBox.alert(lblAplicacion,'Primero debe seleccionar la persona a relacionar')
																	return;
																}	
																
																var idRelacion=cmbRelaciones.getValue();
																if(idRelacion=='')
																{
																	Ext.MessageBox.alert(lblAplicacion,'Debe seleccionar el tipo de relaci&oacute;n que la persona tiene con el alumno');
																	return;
																}
																
																
																
																function funcRespuesta()
																{
																	var arrResp=peticion_http.responseText.split('|');
																	if(arrResp[1]==1)
																	{
																		var nuevaF=new RegistroRelacionAlumnos	(
																													{
																														idRelacion:arrResp[0],
																														Persona:fila.get('Persona'),
																														Relacion:idRelacion
																													}
																												 )
																		tblDatos.getStore().add(nuevaF);
																		var cmbVive=gE('cmbVive'+id);
																		var opcion=document.createElement('option');
																		opcion.value=fila.get('idPersona');
																		opcion.text=fila.get('Persona');
																		cmbVive[cmbVive.length]=opcion;
																		ventana.close();
																		hK();
																	}
																	else
																	{
																		Ext.MessageBox.alert(lblAplicacion,"No se ha podido llevar a cabo la acci&oacute;n debido al siguiente error: <br>"+arrResp[1]);
																	}
																
																}
																
																obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcRespuesta, 'POST','funcion=6&idPersona='+fila.get('idPersona')+'&idAlumno='+idAlumno+'&idParentezco='+idRelacion);
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
	dK();
	cargarDatosR(tblRelaciones.getStore(),idAlumno,idUsuarioActual,ventana);
	
}

function crearTblRelaciones(idAlumno,idUsuario)
{

	var datosR=[];
	
	var alRel=new Ext.data.SimpleStore(
											{
												fields:	[
															{name: 'idPersona'},
															{name: 'Persona'}
														]
											}
										);
	alRel.loadData(datosR);
	
	
	


	var cmPersonas= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														{
															header:'Persona',
															width:300,
															sortable:true,
															dataIndex:'Persona'
														}														 
													]
												);
											
												
	var tblPersonas=	new Ext.grid.GridPanel	(
															{
																x:20,
																y:35,
																id:'tblRel',
																store:alRel,
																frame:true,
																cm: cmPersonas,
																height:150,
																width:350
															}
														);
	return tblPersonas;
}

function cargarDatosR(almacen,idAlumno,idUsuario,ventana)
{
	function funcRespuesta()
	{
		var resp=eval(peticion_http.responseText);
		var x;
		var num=resp.length;
		var r;
		for(x=0;x<num;x++)
		{
			r=new RegistroRelacionAlumnos	(
												{
													idPersona:resp[x].idUsuario,
													Persona:resp[x].Nombre
												}
											)
			almacen.add(r);
		}
		ventana.show();
	}
	
	obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcRespuesta, 'POST','funcion=9&idUsuario='+idUsuario+'&idAlumno='+idAlumno);		
}

function crearComboRel()
{
	
	
	var dsRelaciones= new Ext.data.SimpleStore	(
											 	{
													fields:	[
															 	{name:'id'},
																{name:'nombre'}
																
															]
												}
											)

	

	dsRelaciones.loadData(tablaRelacions);	
	
	
	var comboRel=document.createElement('select');
	
	var comboRelaciones=new Ext.form.ComboBox	(
													{
														x:80,
														y:200,
														width:250,
														id:'IDcomboRelaciones',
														mode:'local',
														emptyText:'Elija un elemento',
														store:dsRelaciones,
														displayField:'nombre',
														valueField:'id',
														transform:comboRel,
														editable:false,
														typeAhead: true,
														triggerAction: 'all',
														lazyRender:true
													
													}
												)
	return comboRelaciones;
}


//---
function agregarNuevoUSuario(idTabla,idAlumno,id)
{
	Ext.getCmp('vtnAgregarN').close();
	
	var cmbRelacion=crearComboRel();
	cmbRelacion.setPosition(115,210);
	
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											disabled:false,
											defaultType:'textfield',
											items: 	[
														new Ext.form.Label(
																		   		{
																					x:10,
																					y:15,
																					html: '<font color="black">Ap. Paterno:</font><font color="red">*</font></font>'
																				}
																		   ),
														{
															x:80,
															y:10,
															id:'txtApPaterno'
														},
														new Ext.form.Label(
																		   		{
																					x:220,
																					y:15,
																					html: '<font color="black">Ap. Materno:</font>'
																				}
																		   ),
														{
															x:290,
															y:10,
															id:'txtApMaterno'
														},
														new Ext.form.Label(
																		   		{
																					x:430,
																					y:15,
																					html: '<font color="black">Nombre:</font><font color="red">*</font>'
																				}
																		   ),
														{
															x:485,
															y:10,
															id:'txtNombre'
														},
														
														new Ext.form.Label(
																		   		{
																					x:10,
																					y:60,
																					html: '<font color="black"><b>Datos de domicilio</b></font>'
																				}
																		   ),
														{
															x:10,
															y:85,
															xtype:'label',
															html: '<font color="black">Calle:</font>'
														},
														
														{
															x:80,
															y:80,
															width:340,
															hideLabel :true,
															xtype:'textfield',
															id:'txtCalle'
														},
														{
															x:430,
															y:85,
															xtype:'label',
															html: '<font color="black">N&uacute;mero:</font>'
														}
														,
														
														{
															x:485,
															y:80,
															width:100,
															hideLabel :true,
															xtype:'textfield',
															id:'txtNumero'
														},
														
														{
															x:10,
															y:115,
															xtype:'label',
															html: '<font color="black">Colonia:</font>'
														}
														,
														{
															x:80,
															y:110,
															hideLabel :true,
															width:200,
															xtype:'textfield',
															id:'txtColonia'
														},
														{
															x:10,
															y:145,
															xtype:'label',
															html: '<font color="black">Ciudad:</font>'
														},
														{
															x:80,
															y:140,
															hideLabel :true,
															width:130,
															xtype:'textfield',
															id:'txtCiudad'
														}
														,
														
														{
															x:230,
															y:145,
															xtype:'label',
															html: '<font color="black">Municipio:</font>'
														},
														{
															x:290,
															y:140,
															hideLabel :true,
															width:130,
															xtype:'textfield',
															id:'txtMunicipio'
														},
														new Ext.form.Label(
																		   		{
																					x:10,
																					y:185,
																					html: '<font color="black">Correo Electr&oacute;nico:</font>'
																				}
																		   ),
														{
															x:115,
															y:180,
															id:'txtMail',
															width:250
														},
														new Ext.form.Label(
																		   		{
																					x:10,
																					y:215,
																					html: '<font color="black">Relaci&oacute;n:</font>'
																				}
																		   ),
														cmbRelacion,
														new Ext.form.Label	(
																					{
																						x:150,
																						y:60,
																						html:'Si comparte su misma direcci&oacute;n de click <a href="javascript:llenarMiDireccion()"><font color="red">Aqu&iacute;</a></a>'
																						
																					}	
																				)
														
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar nueva relación',
										width:650,
										height:340,
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
																Ext.getCmp('txtApPaterno').focus();
															}
												}
											},
										buttons:
												[
												 	{
														text:'Aceptar',
														handler:function ()
															{
																guardarNuevoUsuario(idTabla,idAlumno,ventana,id);
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
	dK();
	ventana.show();
}




function guardarNuevoUsuario(idTabla,idAlumno,ventana,id)
{
	var tblDatos=Ext.getCmp(idTabla);
	var txtApPaterno=cv(Ext.getCmp('txtApPaterno').getValue());
	var txtApMaterno=cv(Ext.getCmp('txtApMaterno').getValue());
	var txtNombre=cv(Ext.getCmp('txtNombre').getValue());
	var txtCalle=cv(Ext.getCmp('txtCalle').getValue());
	var txtNumero=cv(Ext.getCmp('txtNumero').getValue());
	var txtColonia=cv(Ext.getCmp('txtColonia').getValue());
	var txtCiudad=cv(Ext.getCmp('txtCiudad').getValue());
	var txtMunicipio=cv(Ext.getCmp('txtMunicipio').getValue());
	var txtMail=(Ext.getCmp('txtMail').getValue());
	var txtRelacion=Ext.getCmp('IDcomboRelaciones').getValue();
	if(txtApPaterno.trim()=='')
	{
		function resp()
		{
			Ext.getCmp('txtApPaterno').focus();
		}
		Ext.MessageBox.alert(lblAplicacion,'El apellido paterno es obligatorio',resp);
		return;
	}
	if(txtNombre.trim()=='')
	{
		function resp()
		{
			Ext.getCmp('txtNombre').focus();
		}
		Ext.MessageBox.alert(lblAplicacion,'El nombre es el obligatorio',resp);
		return;
	}
	if(txtMail.trim()!='')
	{
		
		if(!validarCorreo(txtMail))
		{
			function resp()
			{
				Ext.getCmp('txtMail').focus();
			}
			Ext.MessageBox.alert(lblAplicacion,'El correo ingresado no es v&aacute;lido',resp);
			return;
		}
	}
	
	if(txtRelacion=='')
	{
		function resp()
		{
			Ext.getCmp('IDcomboRelaciones').focus();
		}
		Ext.MessageBox.alert(lblAplicacion,'Debe seleccionar el tipo de relaci&oacute;n que la persona tiene con el alumno',resp);
		return;
	}	
	
	var obj='{"txtApPaterno":"'+txtApPaterno+'","txtApMaterno":"'+txtApMaterno+'","txtNombre":"'+txtNombre+'","txtCalle":"'+txtCalle+
			'","txtNumero":"'+txtNumero+'","txtColonia":"'+txtColonia+'","txtCiudad":"'+txtCiudad+'","txtMunicipio":"'+txtMunicipio+
			'","txtMail":"'+cv(txtMail)+'","txtRelacion":"'+txtRelacion+'","idAlumno":"'+idAlumno+'"}';
	
	
	function funcRespuesta()
	{
		var arrResp=peticion_http.responseText.split('|');
		if(arrResp[1]==1)
		{
			
			var nuevaF=new RegistroRelacionAlumnos	(
														{
															idRelacion:arrResp[0],
															Persona:Ext.getCmp('txtNombre').getValue().trim()+' '+Ext.getCmp('txtApPaterno').getValue().trim()+' '+Ext.getCmp('txtApMaterno').getValue().trim(),
															Relacion:txtRelacion
														}
													 )
			tblDatos.getStore().add(nuevaF);
			var cmbVive=gE('cmbVive'+id);
			var opcion=document.createElement('option');
			opcion.value=arrResp[2];
			opcion.text=Ext.getCmp('txtNombre').getValue().trim()+' '+Ext.getCmp('txtApPaterno').getValue().trim()+' '+Ext.getCmp('txtApMaterno').getValue().trim();
			cmbVive[cmbVive.length]=opcion;
			ventana.close();
			
		}
		else
		{
			Ext.MessageBox.alert(lblAplicacion,"No se ha podido llevar a cabo la acci&oacute;n debido al siguiente error: <br>"+arrResp[0]);
		}	
	}
	obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcRespuesta, 'POST','funcion=10&obj='+obj);
}

function llenarMiDireccion()
{
	var txtCalle=Ext.getCmp('txtCalle');
	var txtNumero=Ext.getCmp('txtNumero');
	var txtColonia=Ext.getCmp('txtColonia');
	var txtCiudad=Ext.getCmp('txtCiudad');
	var txtMunicipio=Ext.getCmp('txtMunicipio');
	
	txtCalle.setValue(gE('Calle').value);
	txtNumero.setValue(gE('Numero').value);
	txtColonia.setValue(gE('Colonia').value);
	txtCiudad.setValue(gE('Ciudad').value);
	txtMunicipio.setValue(gE('Municipio').value);
	Ext.getCmp('txtMail').focus();
}

//cambio

function marcarReinscrito(idAlumno,numA)
{	
	guardaReinscritos(idAlumno,'hGrado'+numA,'hProg'+numA,'Reinscribir'+numA,numA);
}

//cambio



function agregarNuevoAlumno(obj)
{
	var numA=gE('hNumAlumnos');
	var nuevoNum=parseInt(numA.value)+1;
	numA.value=nuevoNum;
	//var obj='[{\"nombre\":\"Marco Antonio Magaña Ramírez\",\"grado\":\"1\",\"programa\":\"PRIMARIA\",\"idAlumno\":\"1010\","idRelacion":"1"}]';
	var datos=eval(obj);
	var arrObj=datos[0];
	var nombre=arrObj.nombre;
	var grado=arrObj.grado;
	var programa=arrObj.programa;
	var idAlumno=arrObj.idAlumno;
	var idRelacion=arrObj.idRelacion;
	var idRelAlumPers=arrObj.idRelAlumPers;
	var nomPersonaAct=gE('hNombreU').value;
	var idUsuarioAct=gE('idUsuarioAct').value;
	
	cadRelaciones='[[\''+idRelAlumPers+'\',\''+nomPersonaAct+'\',\''+idRelacion+'\']]';
	arrRelaciones[nuevoNum]=eval(cadRelaciones);
	
	alRelaciones[nuevoNum-1]=new Ext.data.SimpleStore(
														{
															fields:	[
																		{name: 'idRelacion'},
																		{name: 'Persona'},
																		{name: 'Relacion'}
																	]
														}
													);
	
	
	var tabla=gE('tblAlumnosR');
	var numFilas=tabla.rows.length;
	var nuevaFila = tabla.insertRow(numFilas);
	var nCeldas = tabla.rows[numFilas].cells;
	nuevaFila.appendChild(nuevaFila.insertCell(0));
	
	var numE=arrTiposRelaciones.length;
	var ct;
	var select='<select id="cmbRelaciones'+nuevoNum+'" style="display:none">';
	for(ct=0;ct<numE;ct++)
	{
		select+='<option value="'+arrTiposRelaciones[ct].IdRelacion+'">'+arrTiposRelaciones[ct].Tipo+'</option>';
	}
	select+='</select>';
	
	
	
	
	var cadTabla=	'<table id="tblVive'+nuevoNum+'" class="tablaUsuario" width="100%" align="center" border="0">'+
						'<tr>'+
						'	<td colspan="2" class="tituloTabla" style="text-align: left ! important;">'+nombre+'</td>'+
						'</tr>'+
						'<tr>'+
						'	<td class="" align="center"><br><b>GRD/SEM AL QUE SE INSCRIBE</b></td>'+
						'	<td class="" align="center"><br><b>PROGRAMA</b></td>'+
						'	<td class="" align="center"><br><b>VIVE CON</b></td>'+
						'</tr>'+
						'<tr>'+
					
						'	<td class="copyrigth" align="center"><b>'+grado+'</b></td>'+
						'	<td class="copyrigth"><b>'+programa+'</b></td>'+
						'	<td align="center">'+
						'		<select name="cmbVive'+nuevoNum+'" id="cmbVive'+nuevoNum+'" onchange="javaScript:viveCon(\'tblVive\','+idAlumno+',\'cmbVive'+nuevoNum+'\')" val="obl" campo="Vive con">'+
						'			<option value="-1">Seleccione</option>'+
						'			<option value="'+idUsuarioAct+'">'+nomPersonaAct+'</option>'+
						'		</select>'+
						'		<input name="alumno'+nuevoNum+'" value="2" id="alumno'+nuevoNum+'" type="hidden">'+
						'		<input name="nomAlumno'+nuevoNum+'" value="'+nombre+'" id="nomAlumno'+nuevoNum+'" type="hidden">'+
						'		<input name="idAlumno'+nuevoNum+'" value="'+idAlumno+'" id="idAlumno'+nuevoNum+'" type="hidden">'+
						'	</td>'+
						'</tr>'+
						'<tr>'+
						'	<td colspan="3">'+
						'		<br>'+
						'		<br>'+
						'		<fieldset class="framePadre"><legend><b>Relación familiar</b></legend>'+
						'		<br>'+
						'			<span id="tblRelaciones'+nuevoNum+'"></span>'+
						'		</fieldset>'+
						'	</td><td width="10"></td>'+
						'	<td colspan="2" valign="top">'+
						'	<br><br><br>'+
						'	<table class="tablaMenu" width="100%">'+
						'		<tr>'+
						'			<td colspan="2" class="tituloTabla">'+
						'				Acciones'+
						'			</td>'+
						'		</tr>'+
						
						'		<tr>'+
						'			<td>'+
						'				<a href="verDatos.php?IdAlumno='+idAlumno+'" onclick="return lanzarVentana2(\''+nombre+'\',this.href)"><img src="../images/folder_violet.png" title="Ver Datos" border="0" height="25"></a>'+
						'			</td>'+
						'			<td class="letraFichaRespuesta10" >'+
						'				<a href="verDatos.php?IdAlumno='+idAlumno+'" onclick="return lanzarVentana2(\''+nombre+'\',this.href)">Ver datos del alumno</a>'+
						'			</td>'+
						'		</tr>'+
						'		<tr>'+
						'			<td>'+
						'				<a href="verDocumentosSolicitadosAlumno.php?IdAlumno='+idAlumno+'" onclick="return lanzarVentana5(\''+nombre+'\',this.href)"><img src="../images/app_48.png" title="Ver documentos solicitados" border="0" height="25"></a>'+
						'			</td>'+
						'			<td class="letraFichaRespuesta10" >'+
						'				<a href="verDocumentosSolicitadosAlumno.php?IdAlumno='+idAlumno+'" onclick="return lanzarVentana5(\''+nombre+'\',this.href)">Ver documentos solicitados</a>'+
						'			</td>'+
						'		</tr>'+
						'		<tr>'+
						'			<td id="td'+nuevoNum+'" align="center">'+
						'				<img src="../images/publish_f2.png" height="20" border="0" title="Estado Alumno: Nuevo Ingreso"></a></td>'+
						'				<td><label id="lblEstado" class="letraFichaRespuesta10" >Estado Alumno:<font color="blue"><b><br>Nuevo Ingreso</b></font></label>'+
						'			</td>'+										
						'		</tr>'+	
						'	</table>'+select
						
						'</td>'+
						'</tr>'+
					'</table>';
	
	nCeldas[0].innerHTML=cadTabla;
	crearTablaRelaciones(nuevoNum);
}



