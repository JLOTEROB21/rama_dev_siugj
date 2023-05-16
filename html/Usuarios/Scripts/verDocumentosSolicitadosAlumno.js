var fp;
var ventana;
function alerta(msgx)
{
	msgBox('<table><tr><td>Su documento ha sido rechazado por la siguiente raz&oacute;n:</td></tr><tr><td align="center"><b>'+msgx+'</b></td></tr><tr><td height="30">Por lo que debera subirlo nuevamente</td></tr>');	
}

function abrirVentanaSubida(idDoc,idAlumno,idAlumnoDoc,idRegistro,idFormulario)
{
	fp = new Ext.FormPanel(
								{
							        fileUpload: true,
							        width: 500,
							        frame: true,
									
									autoHeight: true,
									bodyStyle: 'padding: 10px 10px 0 10px;',
									labelWidth: 50,
							        defaults: 	{
													anchor: '70%',
													allowBlank: false,
													msgTarget: 'side'
												},
									items:	[
												{
													name:'hIdDoc',
													xtype:'hidden',
													value:idDoc
												},
												{
													name:'hIdAlumno',
													xtype:'hidden',
													value:idAlumno
													
												},
												{
													name:'idAlumnoDoc',
													xtype:'hidden',
													value:idAlumnoDoc
												},
												{
													name:'idFormulario',
													xtype:'hidden',
													value:idFormulario
												},
												{
													name:'idReferencia',
													xtype:'hidden',
													value:idRegistro
												},	
												{
													xtype: 'fileuploadfield',
													id: 'form-file',
													emptyText: 'Elija un archivo',
													fieldLabel: 'Archivo',
													name: 'archivo',
													buttonText: '',
													buttonCfg: 	{
																	iconCls: 'upload-icon'
																}
        										}
											]
        							
								}
							);
	
	ventana=new Ext.Window(
							   		{
										title:'Agregar documento',
										width:400,
										height:150,
										layout:'fit',
										buttonAlign:'center',
										items:[fp],
										modal:true,
										plain:true,
										listeners:
											{
												show:
												{
													buffer:10,fn:function()
															{
																
															}
												}
											},
											buttons: 	[
															{
																text: 'Aceptar',
																handler: function()
																		{
																			if(fp.getForm().isValid())
																			{
																				fp.getForm().submit	(	
																										{
																											url: '../Usuarios/guardarDocumento.php',
																											waitMsg: 'Cargando documento...',
																											success: resultadoGuardar,
																											failure:falloAccion
																										}
																									);
																			}
																		}
															},
															{
																text: 'Cancelar',
																handler: function()
																		{
																			ventana.close();
																		}
															}
														]
									}
							   )
	ventana.show();
}

function resultadoGuardar(fp,o)
{
	var idDoc=o.result.idDoc;
	var estado=o.result.estado;
	gE('lblEtiqueta_'+o.result.tipoDoc).innerHTML="<table><tr><td><a href='../Usuarios/obtenerDocumento.php?id="+idDoc+"'><img src='../images/Save.png' title='Descargar documento' alt='Descargar documento'></a></td><td><a href='../Usuarios/obtenerDocumento.php?id="+idDoc+"'> Descargar documento</a></td></tr></table>";
	gE('estado_'+o.result.tipoDoc).innerHTML='<font color="green">'+estado+"</font>";
	ventana.close();
}

function falloAccion(fp,o)
{
	function funcResp()
	{
		ventana.close();
	}
	Ext.MessageBox.alert(lblAplicacion,'No se ha podido guardar el documento debido al siguiente problema: <br>'+o.result.error,funcResp);
}
									