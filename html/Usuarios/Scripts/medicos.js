function modificarMedico(idMedico)
{
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items:
													[
													 	new Ext.form.Label(
																		   		{
																					x:5,
																					y:10,
																					text: 'Nombre:'
																				}
																		   ),
														new Ext.form.Label(
																		   		{
																					x:5,
																					y:40,
																					html: 'Direcci&oacuten:'
																				}
																		   ),
														new Ext.form.Label(
																		   		{
																					x:5,
																					y:70,
																					html: 'Tel&eacute;fono(s):'
																				}
																		   ),				   
																		   
														new Ext.form.TextField({
															x:90,
															y:10,
															width:350,
															height:25,
															id:'txtNombre'
														}),
														
														new Ext.form.TextField({
															x:90,
															y:40,
															width:350,
															height:25,
															id:'txtDireccion'
														}),
														
														new Ext.form.TextArea({
															x:90,
															y:70,
															width:170,
															height:45,
															id:'txtTelefono',
															maskRe:/^[0-9\n\-\(\)]$/
														})
														
													]
										}
										
										
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar M&eacute;dico Familiar',
										width:500,
										height:200,
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
																var nombre=Ext.getCmp('txtNombre');
																nombre.focus(true,10);
															}
												}
											},
										buttons:
												[
												 	{
														text:'Aceptar',
														handler:function ()
															{
																var txtNombre=Ext.getCmp('txtNombre');
																if(txtNombre.getValue().trim()=='')
																{
																	function respN()
																	{
																		txtNombre.focus();
																	}
																	msgBox('El nombre ingresado no es v&aacute;lido',respN);
																	return;
																}
																
																var txtDireccion=Ext.getCmp('txtDireccion');
																if(txtDireccion.getValue().trim()=='')
																{
																	function respD()
																	{
																		txtDireccion.focus();
																	}
																	msgBox('La direcci&oacute;n ingresada no es v&aacute;lida',respD);
																	return;
																}
																var txtTelefono=Ext.getCmp('txtTelefono');
																var telefono=txtTelefono.getValue().replace(/\n/gi, '<BR>');
																
																function funcAjax()
																{
																	var resp=peticion_http.responseText;
																	arrResp=resp.split('|');
																	if(arrResp[0]=='1')
																	{
																		ventana.close();
																		recargarPagina();
																		
																	}
																	else
																	{
																		msgBox('No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente error: '+arrResp[0]);
																	}
																}
																obtenerDatosWeb('../paginasFunciones/procesarFichaMedica.php',funcAjax, 'POST','funcion=10&idMedico='+idMedico+'&nombre='+cv(txtNombre.getValue().trim())+'&direccion='+txtDireccion.getValue().trim()+'&telefono='+telefono,true);
																
																
																
																
																
																
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
	llenarDatosMedico(idMedico,ventana);
	

	dK();
}

function llenarDatosMedico(idMedico,ventana)
{
	function funcAjax()
	{
		var resp=peticion_http.responseText;
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
			Ext.getCmp('txtNombre').setValue(arrResp[1]);
			Ext.getCmp('txtDireccion').setValue(arrResp[2]);
			Ext.getCmp('txtTelefono').setValue(arrResp[3].replace(/<BR>/gi, '\n'));
			ventana.show();
		}
		else
		{
			msgBox('No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente error: '+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/procesarFichaMedica.php',funcAjax, 'POST','funcion=9&idMedico='+idMedico,true);
		
}

function agregarMedico(IdAlumno,idRegistro)
{
	tblGrid=crearGrid();
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items:
													[
													 	new Ext.form.Label(
																		   		{
																					x:5,
																					y:10,
																					text: 'Nombre:'
																				}
																		   ),
														new Ext.form.Label(
																		   		{
																					x:5,
																					y:40,
																					html: 'Direcci&oacute;n:'
																				}
																		   ),
														new Ext.form.Label(
																		   		{
																					x:5,
																					y:70,
																					html: 'Tel&eacute;fono(s):'
																				}
																		   ),				   
																		   
														new Ext.form.TextField({
															x:90,
															y:10,
															width:350,
															height:25,
															id:'txtNombre'
														}),
														
														new Ext.form.TextField({
															x:90,
															y:40,
															width:350,
															height:25,
															id:'txtDireccion'
														}),
														
														new Ext.form.TextArea({
															x:90,
															y:70,
															width:170,
															height:45,
															id:'txtTelefono',
															maskRe:/^[0-9\n\-\(\)]$/
														}),
														tblGrid
														
													]
										}
										
										
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar M&eacute;dico Familiar',
										width:500,
										height:400,
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
																var nombre=Ext.getCmp('txtNombre');
																nombre.focus(true,10);
															}
												}
											},
										buttons:
												[
												 	{
														text:'Aceptar',
														handler:function ()
															{
																
																guardarInfoMedico(tblGrid,ventana,idRegistro);
																//guardarEnfermedad(m,IdAlumno,ventana);
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

function crearGrid()
{
	alNameAlumno=		new Ext.data.SimpleStore(
    											{
    												fields:	[
    															{name: 'idUsuario'},
																{name: 'nomAlumno'},
																{name:'asignado'}
    														]
    											}
    										);

    alNameAlumno.loadData(dsAlumnos);

	var checkColumn = new Ext.grid.CheckColumn	(
													{
													 	header: "",
													   	dataIndex: 'asignado',
														width:50
													}
												);

	
	var cmFrmDTD= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														checkColumn,
														{
															header:'Alumno',
															width:300,
															sortable:true,
															dataIndex:'nomAlumno'
														}
													]
												);
											
	tblFrmDTD=	new Ext.grid.EditorGridPanel	(
                                                    {
														x:10,
														y:130,
														title:'Asignar tambi&eacute;n este m&eacute;dico a:',
                                                        store:alNameAlumno,
                                                        frame:true,
														clicksToEdit:1,
														plugins:checkColumn,
                                                        cm: cmFrmDTD,
                                                        height:200,
                                                        width:450
                                                    }
							                    );
	return tblFrmDTD;
}

Ext.grid.CheckColumn = function(config)
{
    Ext.apply(this, config);
    if(!this.id)
	{
        this.id = Ext.id();
    }
    this.renderer = this.renderer.createDelegate(this);
};

Ext.grid.CheckColumn.prototype =
{
	init : function(grid)
	{
        this.grid = grid;
        this.grid.on('render', 	function()
								{
									var view = this.grid.getView();
									view.mainBody.on('mousedown', this.onMouseDown, this);
						        }, 
					this);
    },

    onMouseDown : function(e, t)
	{
        if(t.className && t.className.indexOf('x-grid3-cc-'+this.id) != -1){
            e.stopEvent();
            var index = this.grid.getView().findRowIndex(t);
            var record = this.grid.store.getAt(index);
            record.set(this.dataIndex, !record.data[this.dataIndex]);
        }
    },

    renderer : function(v, p, record){
        p.css += ' x-grid3-check-col-td'; 
        return '<div class="x-grid3-check-col'+(v?'-on':'')+' x-grid3-cc-'+this.id+'">&#160;</div>';
    }
};

function guardarInfoMedico(tblGrid,ventana,idRegistro)
{
	var txtNombre=Ext.getCmp('txtNombre');
	var txtDireccion=Ext.getCmp('txtDireccion');
	var txtTelefono=Ext.getCmp('txtTelefono');
	var filas=tblGrid.getStore();
	
	if(txtNombre.getValue().trim()=='')
	{
		function funcOk()
		{
			txtNombre.focus(true,10);
		}
		Ext.MessageBox.alert(lblAplicacion,'El campo nombre es obligatorio',funcOk);
		return;
	}
	if(txtTelefono.getValue().trim()=='')
	{
		function funcOk()
		{
			txtTelefono.focus(true,10);
		}
		Ext.MessageBox.alert(lblAplicacion,'El campo teléfono es obligatorio',funcOk);
		return;
	}
	
	var x;
	var f;
	var lAlumnos=gE('idAlumno').value;
	for(x=0;x<filas.getCount();x++)
	{
		f=filas.getAt(x);
		if(f.get('asignado'))
		{
			if(lAlumnos=='')
				lAlumnos=f.get('idUsuario');
			else
				lAlumnos+=','+f.get('idUsuario');
		}
	}
	
	if(lAlumnos=='')
	{
		Ext.MessageBox.alert(lblAplicacion,'El m&eacute;dico debe ser asignado al menos a un alumno');
		return;
	}
	
	var obj='{"nombre":"'+cv(txtNombre.getValue().trim())+'","direccion":"'+cv(txtDireccion.getValue().trim())+'","telefono":"'+cv(txtTelefono.getValue().replace(/\n/gi, '<BR>'))+'","alumnos":"'+lAlumnos+'"}';
	function funcTratarRespuesta()
	{
		var resp=peticion_http.responseText;
		if(resp=='1' || resp==1)
		{
			ventana.close();
			Guardar(idRegistro,'ficha',true);
			
			hK();
		}
		else
			Ext.MessageBox.alert(lblAplicacion,'Ha ocurrido un problema con el servidor y la operaci&oacuten no ha podido llevarse a cabo. Problema: '+resp);
	}
	obtenerDatosWeb('../paginasFunciones/procesarMedicos.php',funcTratarRespuesta, 'POST','funcion=1&param='+obj);
}

function agregarMedicoAsociado(idUsuario)
{
	var gridMedicos=crearGridMedicos();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														{
															html:'Seleccione a los m&eacute;dicos que desea asociar con el alumno actual:',
															x:10,
															y:10,
															xtype:'label'
														},
														gridMedicos,
														{
															x:10,
															y:310,
															xtype:'label',
															html:'<font color="red"><b>Nota:</b></font>&nbsp;Los m&eacute;dicos mostrados son tomados de las relaciones existentes entre padres/tutores e hijos.'
														}

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar m&eacute;dico asociado',
										width: 610,
										height:450,
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
															id:'btnAceptar',
															text: 'Aceptar',
															handler: function()
																	{
																		var arrFilas=gridMedicos.getSelectionModel().getSelections();
																		if(arrFilas.length==0)
																		{
																			msgBox('Al menos debe seleccionar un m&eacute;dico para asociarlo con el alumno');
																			return;
																		}
																		
																		var medicos='';
																		var x;
																		for(x=0;x<arrFilas.length;x++)
																		{
																			if(medicos=='')
																				medicos=arrFilas[x].get('idMedico');
																			else
																				medicos+=','+arrFilas[x].get('idMedico');
																		}
																		
																		function funcTratarRespuesta()
																		{
																			var resp=peticion_http.responseText.split('|');
																			if((resp[0]=='1') || (resp[0]==1))
																			{
																				ventanaAM.close();
																				recargarPagina();
																				hK();
																			}
																			else
																				Ext.MessageBox.alert(lblAplicacion,'Ha ocurrido un problema con el servidor y la operaci&oacuten no ha podido llevarse a cabo. Problema: '+resp);
																		}
																		obtenerDatosWeb('../paginasFunciones/procesarFichaMedica.php',funcTratarRespuesta, 'POST','funcion=12&idUsuario='+idUsuario+'&medicos='+medicos);
																		
																		
																		
																	}
														},
														{
															text: 'Cancelar',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	llenarDatosMedicosRelacionados(ventanaAM,idUsuario);

}

function crearGridMedicos()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idMedico'},
                                                                {name: 'nombre'},
																{name: 'direccion'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Nombre',
															width:200,
															sortable:true,
															dataIndex:'nombre'
														},
														{
															header:'Direcci&oacute;n',
															width:290,
															sortable:true,
															dataIndex:'direccion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridMedicos',
                                                            store:alDatos,
                                                            frame:true,
															x:5,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:580,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;		
}

function llenarDatosMedicosRelacionados(ventana,idUsuario)
{
	function funcTratarRespuesta()
	{
		var resp=peticion_http.responseText.split('|');
		if((resp[0]=='1') || (resp[0]==1))
		{
			var arrDatos=eval(resp[1]);
			var gridMedicos=Ext.getCmp('gridMedicos').getStore();
			gridMedicos.loadData(arrDatos);
			ventana.show();
			hK();
		}
		else
			Ext.MessageBox.alert(lblAplicacion,'Ha ocurrido un problema con el servidor y la operaci&oacuten no ha podido llevarse a cabo. Problema: '+resp);
	}
	obtenerDatosWeb('../paginasFunciones/procesarFichaMedica.php',funcTratarRespuesta, 'POST','funcion=11&idUsuario='+idUsuario);
}


