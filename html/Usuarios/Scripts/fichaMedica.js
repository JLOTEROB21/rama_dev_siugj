Ext.onReady(inicializar);

function inicializar()
{
	gE('cmbSangre').focus();
}

/*var keyMap = new Ext.KeyMap(document, 
									{
										key: 13, 
										fn: funAceptar,
										scope: this
									}
							);
*/
function funAceptar()
{
	guardar();
}

function agregarEnfermedad(IdAlumno)
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
																					text: 'Enfermedad:'
																				}
																		   ),
														new Ext.form.TextField({
															x:90,
															y:5,
															width:150,
															height:20,
															id:'txtEnfermedad'
														})
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar Enfermedad',
										width:280,
										height:100,
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
																var m=Ext.getCmp('txtEnfermedad');
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
																var m=Ext.getCmp('txtEnfermedad').getValue();
																guardarEnfermedad(m,IdAlumno,ventana);
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
}

function agregarMedicamento(IdAlumno)
{
	return;
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
																					text: 'Medicamento:'
																				}
																		   ),
														new Ext.form.TextField({
															x:90,
															y:5,
															width:150,
															height:20,
															id:'txtMedicamento'
														})
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar Medicamento',
										width:280,
										height:100,
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
																var m=Ext.getCmp('txtMedicamento');
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
																var m=Ext.getCmp('txtMedicamento').getValue();
																guardarMedicamento(m,IdAlumno,ventana);
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
}

function agregarProducto(IdAlumno)
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
																					text: 'Producto:'
																				}
																		   ),
														new Ext.form.TextField({
															x:90,
															y:5,
															width:150,
															height:20,
															id:'txtProducto'
														})
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar Alimento o Producto',
										width:280,
										height:100,
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
																var m=Ext.getCmp('txtProducto');
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
																var m=Ext.getCmp('txtProducto').getValue();
																guardarProducto(m,IdAlumno,ventana);
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
}

function Salir()
{
	//parent.parent.GB_hide();
	var salir=true;
}

function cargarCombo()
{
	var cmbPrograma=gE('cmbPrograma');
	
	var lblGrado=gE('lblGrado');
		
		if(cmbPrograma.value==4)
			lblGrado.innerHTML="Semestre:"
		else
			lblGrado.innerHTML="Grado:"
			
	function funcTratarRespuesta()
	{
	
		var resp=peticion_http.responseText;	
		var arrResp=resp.split('|');
		if(arrResp[0]=='1' || arrResp[0]==1)
		{
			var arrObjResp=eval(arrResp[1]);

			var cmbGrado=gE('cmbGrado');
			var x;
			var nuevaOpcion;
			limpiarCombo(cmbGrado);
			for(x=0;x<arrObjResp.length;x++)
			{
				objResp=arrObjResp[x];
				nuevaOpcion=document.createElement('option');
				nuevaOpcion.value=objResp.IdGrado;
				nuevaOpcion.text=objResp.Grado+"";
				cmbGrado.options[cmbGrado.length]=nuevaOpcion;
			}
		}
		else
			alert("Error :"+arrResp[0]);
			
			
	}
	obtenerDatosWeb('../paginasFunciones/procesarNuevoAspirante.php',funcTratarRespuesta, 'POST','funcion=1&objDatos='+cmbPrograma.value);		
}

function guardarEnfermedad(valor,IdAlumno,ventana)
{
	if(valor.trim()=='')
	{
		
		function funcOk()
		{
			Ext.getCmp('txtEnfermedad').focus(true,10);
		}
		Ext.MessageBox.alert(lblAplicacion,'El campo Enfermedad es obligatorio',funcOk);
		return;
	}
	function funcTratarRespuesta()
	{
		var resp=peticion_http.responseText;
		var arrResp=resp.split('|');
		if(arrResp[0]=='1' || arrResp[0]==1)
		{
			var Enfermedad=gE('cmbEnfermedades');
			
			var IdEnf=arrResp[1];
			var x;
			var nuevaOpcion;
				nuevaOpcion=document.createElement('option');
				nuevaOpcion.value=IdEnf;
				nuevaOpcion.text=valor;
					Enfermedad.options[Enfermedad.length]=nuevaOpcion;
		}
		else
			alert("Error :"+arrResp[0]);
	}
	obtenerDatosWeb('../paginasFunciones/procesarFichaMedica.php',funcTratarRespuesta, 'POST','funcion=2&IdAlumno='+IdAlumno+'&Enfermedad='+valor);		
	ventana.close();
	hK();
}

function guardarMedicamento(valor,IdAlumno,ventana)
{
	if(valor.trim()=='')
	{
		function funcOk()
		{
			Ext.getCmp('txtMedicamento').focus(true,10);
		}
		Ext.MessageBox.alert(lblAplicacion,'El campo Medicamento es obligatorio',funcOk);
		return;
		
	}
	function funcTratarRespuesta()
	{
		var resp=peticion_http.responseText;
		var arrResp=resp.split('|');
		if(arrResp[0]=='1' || arrResp[0]==1)
		{
			var Medicamento=gE('cmbMedicamentos');
			
			var IdMed=arrResp[1];
			var x;
			var nuevaOpcion;
				nuevaOpcion=document.createElement('option');
				nuevaOpcion.value=IdMed;
				nuevaOpcion.text=valor;
				Medicamento.options[Medicamento.length]=nuevaOpcion;
		}
		else
			alert("Error :"+arrResp[0]);
	}
	obtenerDatosWeb('../paginasFunciones/procesarFichaMedica.php',funcTratarRespuesta, 'POST','funcion=3&IdAlumno='+IdAlumno+'&Medicamento='+valor);		
	ventana.close();
	hK();
}

function guardarProducto(valor,IdAlumno,ventana)
{
	if(valor.trim()=='')
	{
		function funcOk()
		{
			Ext.getCmp('txtProducto').focus(true,10);
		}
		Ext.MessageBox.alert(lblAplicacion,'El campo Producto es obligatorio',funcOk);
		return;
		
	}
	function funcTratarRespuesta()
	{
		var resp=peticion_http.responseText;
		var arrResp=resp.split('|');
		if(arrResp[0]=='1' ||arrResp[0]==1)
		{
			var Producto=gE('cmbAlimentos');
			
			var IdProd=arrResp[1];
			var x;
			var nuevaOpcion;
				nuevaOpcion=document.createElement('option');
				nuevaOpcion.value=IdProd;
				nuevaOpcion.text=valor;
					Producto.options[Producto.length]=nuevaOpcion;
		}
		else
			alert("Error :"+arrResp[0]);
	}
	obtenerDatosWeb('../paginasFunciones/procesarFichaMedica.php',funcTratarRespuesta, 'POST','funcion=4&IdAlumno='+IdAlumno+'&Producto='+valor);		
	ventana.close();
	hK();
}

function eliminarEnfermedad()
{
	var cmbEnfermedades=gE('cmbEnfermedades');
		
	if(cmbEnfermedades.selectedIndex==-1)
	{
		Ext.MessageBox.alert(lblAplicacion,'Por favor seleccione una Enfermedad');
		return;
	}
		
	function funcTratarRespuesta()
	{
		var resp=peticion_http.responseText;
		var arrResp=resp.split('|');
		if(arrResp[0]=='1' || arrResp[0]==1)
		{
			cmbEnfermedades.options[cmbEnfermedades.selectedIndex]=null;
		}
		else
			alert("Error :"+arrResp[0]);
	}
	obtenerDatosWeb('../paginasFunciones/procesarFichaMedica.php',funcTratarRespuesta, 'POST','funcion=6&IdEnfermedad='+cmbEnfermedades.value);
}

function eliminarMedicamento()
{
	var cmbMedicamentos=gE('cmbMedicamentos');
		
	if(cmbMedicamentos.selectedIndex==-1)
	{
		Ext.MessageBox.alert(lblAplicacion,'Por favor seleccione un Medicamento');
		return;
	}
		
	function funcTratarRespuesta()
	{
		var resp=peticion_http.responseText;
		var arrResp=resp.split('|');
		if(arrResp[0]=='1' || arrResp[0]==1)
		{
			cmbMedicamentos.options[cmbMedicamentos.selectedIndex]=null;
		}
		else
			alert("Error :"+arrResp[0]);
	}
	obtenerDatosWeb('../paginasFunciones/procesarFichaMedica.php',funcTratarRespuesta, 'POST','funcion=5&IdMedicamento='+cmbMedicamentos.value);
}

function eliminarAlimento()
{
	var cmbAlimentos=gE('cmbAlimentos');
	if(cmbAlimentos.selectedIndex==-1)
	{
		Ext.MessageBox.alert(lblAplicacion,'Por favor seleccione un Producto');
		return;
	}
		
	function funcTratarRespuesta()
	{
		var resp=peticion_http.responseText;
		var arrResp=resp.split('|');
		if(arrResp[0]=='1' || arrResp[0]==1)
			cmbAlimentos.options[cmbAlimentos.selectedIndex]=null;
		else
			alert("Error :"+arrResp[0]);
	}
	obtenerDatosWeb('../paginasFunciones/procesarFichaMedica.php',funcTratarRespuesta, 'POST','funcion=7&IdAlimento='+cmbAlimentos.value);
}
				 
function Guardar(noRegistros,form,recargar)
{
	if (!validarFormularios(form))
	{
		return;
	}
	var cmbSangre=gE('cmbSangre');
	var Alergias=gE('Alergias');	
	var Padecimiento=gE('Padecimiento');
	var Recomendaciones=gE('Recomendaciones');
	var IdAlumno=gE('IdAlumno');
	var enfermedades=gE('cmbEnfermedades');
	var medicamentosAlergia=gE('cmbMedicamentos');
	var alimentos=gE('cmbAlimentos');
	var x;
	var noReg=0;
	var Medicamentos="";
	for(x=1;x<=noRegistros;x++)
	{
		var M='chkMed'+x;
		var Med=gE(M);

		if(Med.checked)
		{
			noReg++;
			Medicamentos=Medicamentos+Med.value+",";
		}
	}

	var obj='{"enfermedades":"'+cv(enfermedades.value)+'","medicamentosAlergia":"'+cv(medicamentosAlergia.value)+'","alimentos":"'+cv(alimentos.value)+'","cmbSangre":"'+encodeURIComponent(cmbSangre.value)+'","Alergias":"'+cv(Alergias.value)+'","Padecimiento":"'+cv(Padecimiento.value)+'","Recomendaciones":"'+cv(Recomendaciones.value)+'","Medicamentos":"'+cv(Medicamentos)+'","IdAlumno":"'+IdAlumno.value+'","noRegistros":"'+noReg+'"}';

	function funcTratarRespuesta()
	{	
		var resp=peticion_http.responseText.split('|');
		if(resp[0]=='1')
		{
			if(recargar==true)
				location.reload();
			else
				Ext.MessageBox.alert(lblAplicacion,'Los datos han sido guardados correctamente');
			var idAlumno=gE('idAlumno').value;
			var idTabla=gE('idTabla').value;
			parent.parent.marcarReinscrito(idAlumno,idTabla);
		}
		else
		{
			Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/procesarFichaMedica.php',funcTratarRespuesta, 'POST','funcion=1&objDatos='+obj);		
	
}

function quitarMedico(idRel,idRegistro)
{
	function funcResp(btn)
	{
		if(btn=='yes')
		{
			function funcTratarRespuesta()
			{
				var resp=peticion_http.responseText;
				if(resp=='1' || resp==1)
				{
					
					var fila=gE('filaM_'+idRel);
					fila.parentNode.removeChild(fila);
				}
				
				else
					Ext.MessageBox.alert(lblAplicacion,'Ha ocurrido un problema con el servidor y la operacion no ha podido llevarse a cabo');
					
			}
			
			obtenerDatosWeb('../paginasFunciones/procesarFichaMedica.php',funcTratarRespuesta, 'POST','funcion=8&idRel='+idRel);
		}
	}
	
	Ext.MessageBox.confirm(lblAplicacion,'¿Est&aacute; seguro de querer eliminar el m&eacute;dico del alumno?',funcResp)
	
	
}