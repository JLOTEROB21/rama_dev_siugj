<?php session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$consulta="select IdRelacion,Tipo from 4115_parentezco";
	$arrRelaciones=$con->obtenerFilasJson($consulta);
	echo "var arrRelaciones=".$arrRelaciones;
	$arrRel=$con->obtenerFilasArreglo($consulta);
?>

Ext.onReady(inicializar);
var ct=1;

function inicializar()
{
	inicializarCombos();
	crearTablaRelaciones();
}


var pPagina=new Ext.data.HttpProxy	(
										 	{
												url:'../paginasFunciones/funcionesUsuarios.php',
												method:'POST'
											}
										 );
var lector=new Ext.data.JsonReader 	(
										 	{
												root:'personas',
												totalProperty:'num',
												id:'idUsuario'
											},
											[
											 	{name:'idUsuario', mapping:'idUsuario'},
												{name:'Paterno', mapping:'Paterno'},
												{name:'Materno', mapping:'Materno'},
												{name:'Nom', mapping:'Nom'},
												{name:'Nombre', mapping:'Nombre'},
												{name:'Status', mapping:'Status'},
                                                {name:'idUsuario',mapping:'idUsuario'}
											]
										);


function inicializarCombos()
{
	var parametros=	{
						funcion:'1',
						criterio:''
					};
	inicializarCmbNombre(pPagina,lector,parametros);
}

function ponerCBusqueda(cBusqueda)
{
	gE('cBusqueda').value=cBusqueda;
}

RegistroRelacion =Ext.data.Record.create	(
												[
													{name: 'idRelacion'},
													{name: 'Persona'},
													{name: 'Relacion'},
												]
											)

var alRelaciones=	new Ext.data.SimpleStore(
											{
												fields:	[
															{name: 'idRelacion'},
															{name: 'Persona'},
															{name: 'Relacion'}
														]
											}
										);

function inicializarCmbNombre(pagina,lector, parametros)
{

	var ds=new Ext.data.Store	(
								 	{
										proxy:pagina,
										reader:lector,
										baseParams:parametros
									}
								 );
	
	function cargarDatos(dSet)
	{
    	oE('filaViveCon');
		tblPersonas.getStore().removeAll();
		gE('idAlumno').value='-1';
		var aNombre=Ext.getCmp('cmbNombreAlumno').getValue();
		dSet.baseParams.criterio=aNombre;
		dSet.baseParams.campoBusqueda=gE('cBusqueda').value;
        
	}
	
	ds.on('beforeload',cargarDatos);

	var resultTpl=new Ext.XTemplate	(
									 	'<tpl for="."><div class="search-item">',
											'{Paterno}&nbsp;{Materno}&nbsp;{Nom}&nbsp;<br>---<br>',
										'</div></tpl>'
									 );
	
	var comboNombre= new Ext.form.ComboBox	(
												 	{
														id:'cmbNombreAlumno',
														store:ds,
														displayField:'Nombre',
														typeAhead:false,
														minChars:1,
														loadingText:'Procesando, por favor espere...',
														width:500,
														pageSize:10,
														hideTrigger:true,
														tpl:resultTpl,
														renderTo :'txtUsuario',
														itemSelector:'div.search-item',
														listWidth :300
													}
												 );

	function funcElemSeleccionado(combo,registro)
	{	
		var idAlumno=registro.get('idUsuario');
		gE('idAlumno').value=idAlumno;
        mE('filaViveCon');
		function funcGuardar()
		{
			var resp=peticion_http.responseText.split('|');
			
			var arrResp=eval(resp[1]);
			var nombre;
			var relacion;
			var idAsoc;
            var idUsuario;
			var x;
			var nuevaF;
			alRelaciones.removeAll();
            var arrViveCon=new Array();
            var elemViveCon;
            var cmbViveCon=gE('cmbViveCon');
            rellenarCombo(cmbViveCon,eval(resp[3]));
            selElemCombo(cmbViveCon,resp[2]);
            gE('hViveCon').value=resp[2];
			for(x=0;x<arrResp.length;x++)
			{
				nombre=arrResp[x].Nombre;
				relacion=arrResp[x].IdParentezco;
				idAsoc=arrResp[x].idAlumnosParientes;
                idUsuario=arrResp[x].idUsuario;
				nuevaF=new RegistroRelacion	(
											 	{
													idRelacion:idAsoc,
													Persona:nombre,
													Relacion:relacion
												}
											 )
				alRelaciones.add(nuevaF);
			}
            
            
            
		}
		obtenerDatosWeb("../paginasFunciones/funcionesUsuarios.php",funcGuardar,'POST','funcion=2&'+'idAlumno='+idAlumno,true);
	}
	comboNombre.on('select',funcElemSeleccionado);	
	Ext.getCmp('cmbNombreAlumno').focus();
}

function crearTablaRelaciones()
{
	var dsRelaciones=[];
	alRelaciones.loadData(dsRelaciones);	
		
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
															header:'Relacion',
															width:100,
															sortable:true,
															dataIndex:'Relacion',
															renderer:function(val)
																	{
																		var x=0;
																		for(x=0;x<arrRelaciones.length;x++)
																		{
																			if(arrRelaciones[x].IdRelacion==val)
																				return arrRelaciones[x].Tipo;
																		}
																		return '';
																		
																	},
															editor:new Ext.form.ComboBox(
																						 	{
																							   typeAhead: true,
																							   triggerAction: 'all',
																							   transform:'cmbRelaciones',
																							   lazyRender:true
																							}
																						)
															

														}
													]
												);
											
												
	tblPersonas=	new Ext.grid.EditorGridPanel	(
                                                    {
														id:'tblPersonas',
                                                        store:alRelaciones,
                                                        frame:true,
                                                        cm: cmPersonas,
                                                        height:200,
                                                        width:500,
														clicksToEdit:1,
														renderTo:'tblRelaciones'
														
														,
														tbar:[
																{
                                                                	icon:'../images/add.png',
                                                                    cls:'x-btn-text-icon',
																	text:'Agregar Relaci&oacute;n',
																	handler:function()
																			{
																				if(gE('idAlumno').value=='-1')
																				{
																					function resp()
																					{
																						Ext.getCmp('cmbNombreAlumno').focus();
																					}
																				
																					Ext.MessageBox.alert(lblAplicacion,'Primero debe seleccionar un alumno para relacionar',resp)
																					return;
																				}
																				mostrarVentanaAgregar(tblPersonas);
																			}
																}
																,
																{
                                                                	icon:'../images/cancel_round.png',
                                                                    cls:'x-btn-text-icon',
																	text:'Eliminar Relaci&oacute;n',
																	handler:function()
																		{
																			eliminaUsuario(tblPersonas);
																		}
																	
																}
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

function eliminaUsuario(tblPersonas)
{
	var sFilas=tblPersonas.getSelectionModel();
	var filasSel=sFilas.getSelectedCell();
	if(filasSel==null)
	{
		Ext.MessageBox.alert(lblAplicacion,'Primero debe seleccionar la relaci&oacute;n a eliminar');
		return;
	}
	var fSel=filasSel[0];
	var fila=tblPersonas.getStore().getAt(fSel);

	var idRelacionDel=	fila.get('idRelacion');

	function funcGuardar()
	{
		var resp=peticion_http.responseText.split('|');
		if(resp[0]=='1')
		{
			tblPersonas.getStore().remove(fila);
            var arrViceCon=eval(resp[2]);
            var cmbViveCon=gE('cmbViveCon');
            llenarCombo(cmbViveCon,arrViceCon);
            selElemCombo(cmbViveCon,resp[1]);
		}
		else
		{
			msgBox('No se ha podido realizar la operaci&oacute;n debido al siguiente error:'+' <br />'+resp[0]);
		}		
	}
	obtenerDatosWeb("../paginasFunciones/funcionesUsuarios.php",funcGuardar,'POST','funcion=4&'+'&idRelacion='+idRelacionDel,true);
}

var rdoPaterno;
var rdoMaterno;
var rdoNom;

function mostrarVentanaAgregar(tblPersonas)
{
	gE('cBusquedaP').value='1';
	gE('idPadre').value='-1';
	var tablaRelaciones=<?php echo $arrRel?>;

	var dsRelaciones= new Ext.data.SimpleStore	(
													{
														fields:	[
																	{name:'id'},
																	{name:'nombre'}
																	
																]
													}
												)

	dsRelaciones.loadData(tablaRelaciones);
	
	var cmbRel=document.createElement('select');
	
	var parametros2=	{
							funcion:'5',
							criterio:''
						};
	
	var comboPapa=inicializarCmbPadre(pPagina,lector,parametros2);

	var comboRelacion=new Ext.form.ComboBox	(
												{
													x:70,
													y:65,
													id:'cmbRelacion',
													mode:'local',
													emptyText:'Elija una relacion',
													store:dsRelaciones,
													displayField:'nombre',
													valueField:'id',
													transform:cmbRel,
													editable:false,
													typeAhead: true,
													triggerAction: 'all',
													lazyRender:true
													
												}
											)

	var form = new Ext.form.FormPanel(	
										 	{
												baseCls: 'x-plain',
												layout:'absolute',
												defaultType: 'textfield',
												items: 	[
														 	new Ext.form.Label	(
																				 	{
																						x:5,
																						y:40,
																						text:'Persona: '
																					}
																				)
															,
															comboPapa,
															
															new Ext.form.Label	(
																				 	{
																						x:5,
																						y:70,
																						text:'Relacion:'
																					}
																				)
															,
															comboRelacion,
															
															
															new Ext.form.Radio	(
																					{
																						x:5,
																						y:5,
																						id:'rdoPaterno',
																						boxLabel:'Ap. Paterno',
																						checked:true,
																						value:1
																						
																					}
																				),
															new Ext.form.Radio	(
																					{
																						x:135,
																						y:5,
																						id:'rdoMaterno',
																						boxLabel:'Ap. Materno',
																						value:2
																					}
																				),
															new Ext.form.Radio	(
																					{
																						x:265,
																						y:5,
																						id:'rdoNombre',
																						boxLabel:'Nombre',
																						value:3
																					}
																				)
															
														]
											}
										);
	
	ventana = new Ext.Window	(
									{
										title: lblAplicacion,
										width: 450,
										height:180,
										minWidth: 280,
										minHeight: 100,
										layout: 'fit',
										plain:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										modal:true,
										listeners : {
														show : {
																	buffer : 10,
																	fn : function() 
																	{
																		comboPapa.focus();
																	}
																}
													},
										buttons:	[
														{
															text: 'Aceptar',
															handler:function()
																	{
																		var idPadre=gE('idPadre').value;
																		var relacion=comboRelacion.getValue();
																		
																		var idAlumno=gE('idAlumno').value;
																		if(idPadre==-1)
																		{
																			function funcResp()
																			{
																				comboPapa.focus();
																			}
																			Ext.MessageBox.alert(lblAplicacion,'Debe seleccionar a una persona para asociarla al alumno',funcResp)
																			return;
																		}
																		if(relacion=='')
																		{
																			function funcResp()
																			{
																				comboRelacion.focus();
																			}
																			Ext.MessageBox.alert(lblAplicacion,'Debe indicar la relaci&oacute;n que la persona tiene con el alumno',funcResp)
																			return;
																		}
																		
																		var param='&idPersona='+idPadre+'&idAlumno='+idAlumno+'&idParentezco='+relacion
																		function funcGuardar()
																		{
																			var arrResp=peticion_http.responseText.split('|');
																			if(arrResp[1]==1)
																			{
																				var nuevaF=new RegistroRelacion	(
																													{
																														idRelacion:arrResp[0],
																														Persona:comboPapa.getValue(),
																														Relacion:relacion
																													}
																												 )
																				alRelaciones.add(nuevaF);
                                                                                var arrViceCon=eval(arrResp[3]);
                                                                                var cmbViveCon=gE('cmbViveCon');
                                                                                llenarCombo(cmbViveCon,arrViceCon);
                                                                                selElemCombo(cmbViveCon,arrResp[2]);
																				ventana.close();
																			}
																			else
																			{
																				Ext.MessageBox.alert(lblAplicacion,"No se ha podido llevar a cabo la acci&oacute;n debido al siguiente error: <br>"+arrResp[1]);
																			}
																		
																		}
																		obtenerDatosWeb("../paginasFunciones/funcionesUsuarios.php",funcGuardar,'POST','funcion=6&'+param,true);

																	}
														},
														{
															text: 'Cancelar',
															handler:function()
																	{
																		ventana.close();
																	}
														}
													]
    								}
								);

	var rdoPaterno=Ext.getCmp('rdoPaterno');
	var rdoMaterno=Ext.getCmp('rdoMaterno');
	var rdoNombre=Ext.getCmp('rdoNombre');
	rdoPaterno.on('check',cambiarRadioSel);									
	rdoMaterno.on('check',cambiarRadioSel);									
	rdoNombre.on('check',cambiarRadioSel);							

    ventana.show();
}

function cambiarRadioSel(chk, valor)
{
	if(valor==true)
	{
		var rdoPaterno=Ext.getCmp('rdoPaterno');
		var rdoMaterno=Ext.getCmp('rdoMaterno');
		var rdoNom=Ext.getCmp('rdoNombre');
		if(rdoPaterno.id!=chk.id)
			rdoPaterno.setValue(false);
		if(rdoMaterno.id!=chk.id)
			rdoMaterno.setValue(false);
		if(rdoNom.id!=chk.id)
			rdoNom.setValue(false);
		gE('cBusquedaP').value=chk.value;
	}
}


function inicializarCmbPadre(pagina,lector, parametros2)
{

	var ds=new Ext.data.Store	(
								 	{
										proxy:pagina,
										reader:lector,
										baseParams:parametros2
									}
								 );
	
	function cargarDatos(dSet)
	{
		gE('idPadre').value='-1';
		var aNombre=Ext.getCmp('cmbNombrePadre').getValue();
		dSet.baseParams.criterio=aNombre;
		dSet.baseParams.campoBusqueda=gE('cBusquedaP').value;
        dSet.baseParams.idAlumno=gE('idAlumno').value;
	}
	
	ds.on('beforeload',cargarDatos);

	var resultTpl=new Ext.XTemplate	(
									 	'<tpl for="."><div class="search-item">',
											'{Paterno}&nbsp;{Materno}&nbsp;{Nom}&nbsp;<br>---<br>',
										'</div></tpl>'
									 );
	
	var comboNombre= new Ext.form.ComboBox	(
												 	{
														x:70,
														y:35,
														id:'cmbNombrePadre',
														store:ds,
														displayField:'Nombre',
														typeAhead:false,
														minChars:1,
														loadingText:'Procesando, por favor espere...',
														width:350,
                                                        listWidth :350,
														pageSize:10,
														hideTrigger:true,
														tpl:resultTpl,
														itemSelector:'div.search-item',
														listWidth :300
													}
												 );

	function funcElemSeleccionado(combo,registro)
	{	
		gE('idPadre').value=registro.get('idUsuario');	
	
	}
	
	comboNombre.on('select',funcElemSeleccionado);	
	return comboNombre;
}

function viveConChange(combo)
{
	function resp(btn)
    {
    	if(btn=='yes')
        {
            var idViveCon=combo.options[combo.selectedIndex].value;
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                	gE('hViveCon').value=idViveCon;
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=24&idUsuario='+gE('idAlumno').value+'&viveCon='+idViveCon,true);
		}     
        else
        	selElemCombo(cmbViveCon,gE('hViveCon').value);
    }
    msgConfirm('Est&aacute; seguro de querer cambiar la persona con la cual vive el alumno?',resp);

}
