<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$consulta="SELECT id__10_tablaDinamica,CONCAT('(',cveFormato,') ',nombreFormato) FROM _10_tablaDinamica ORDER BY cveFormato";
	$arrDocumentos=$con->obtenerFilasArreglo($consulta);


	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos ORDER BY nombreCategoria";
	$arrCategoriaDocumento=$con->obtenerFilasArreglo($consulta);
?>

var idFormato=-1;
var arrDocumentos=<?php echo $arrDocumentos?>;
var arrCategoriaDocumento=<?php echo $arrCategoriaDocumento?>;
var arrPlantillas=<?php echo $arrDocumentos?>;

Ext.onReady(inicializar);

function inicializar()
{
    arrPlantillas.splice(0,0,['0','Ninguno']);
    arrPlantillas.splice(1,0,['-10','Definida por funci\xF3n']);
      
    
                                                        
    var panel= new Ext.Panel 	(
    								{
                                        layout:'absolute',
                                        region:'south',
                                        height:220,
                                        items:	[	
                                                    {
                                                        xtype:'label',
                                                        x:10,
                                                        y:15,
                                                        cls:'SIUGJ_Etiqueta',
                                                        html:'Categor&iacute;a de documento default:'
                                                    },
                                                    {
                                                    	x:340,
                                                        y:10,
                                                        xtype:'label',
                                                        html:'<div id="divCategoriaDocumento"></div>'
                                                    },	
                                                    {
                                                        xtype:'checkbox',
                                                        x:30,
                                                        y:65,
                                                        ctCls:'SIUGJ_Etiqueta',
                                                        boxLabel:'Mostrar selección de plantilla',
                                                        checked:gE('permiteSeleccionPlantilla').value=='1',
                                                        listeners:
                                                                    {
                                                                        check:function(chk,checado)
                                                                                {
                                                                                    modificarParametrosConfiguracion(1,checado?1:0);
                                                                                }	
            
                                                                    }
                                                    },
                                                    {
                                                        xtype:'checkbox',
                                                        x:410,
                                                        y:65,
                                                        ctCls:'SIUGJ_Etiqueta',
                                                        checked:gE('permiteEdicionTextoEnriquecido').value=='1',
                                                        boxLabel:'Permitir edici&oacute;n de texto enriquecido',
                                                        listeners:
                                                                    {
                                                                        check:function(chk,checado)
                                                                                {
                                                                                    modificarParametrosConfiguracion(2,checado?1:0);
                                                                                }	
            
                                                                    }
                                                    },
                                                    {
                                                        xtype:'checkbox',
                                                        x:860,
                                                        y:65,
                                                        ctCls:'SIUGJ_Etiqueta',
                                                        checked:gE('permiteSubirWord').value=='1',
                                                        boxLabel:'Permitir subir documentos en formato Word',
                                                        listeners:
                                                                    {
                                                                        check:function(chk,checado)
                                                                                {
                                                                                    modificarParametrosConfiguracion(4,checado?1:0);
                                                                                }	
            
                                                                    }
                                                    },
                                                    {
                                                        xtype:'checkbox',
                                                        x:30,
                                                        y:105,
                                                        hidden:true,
                                                        ctCls:'SIUGJ_Etiqueta',
                                                        boxLabel:'Publica en bolet&iacute;n',
                                                        checked:gE('publicaEnBoletin').value=='1',
                                                        listeners:
                                                                    {
                                                                        check:function(chk,checado)
                                                                                {
                                                                                    modificarParametrosConfiguracion(7,checado?1:0);
                                                                                }	
            
                                                                    }
                                                    },
                                                    {
                                                        xtype:'checkbox',
                                                        x:410,
                                                        y:105,
                                                        hidden:true,
                                                        ctCls:'SIUGJ_Etiqueta',
                                                        checked:gE('permiteConfiguracionBoletin').value=='1',
                                                        boxLabel:'Permitir configuraci&oacute;n de bolet&iacute;n',
                                                        listeners:
                                                                    {
                                                                        check:function(chk,checado)
                                                                                {
                                                                                    modificarParametrosConfiguracion(8,checado?1:0);
                                                                                }	
            
                                                                    }
                                                    },
                                                    {
                                                        xtype:'checkbox',
                                                        x:30,
                                                        y:105,
                                                        ctCls:'SIUGJ_Etiqueta',
                                                        checked:gE('permiteGuardarSinCambios').value=='1',
                                                        boxLabel:'Permitir guardar sin realizar cambios (primera vez)',
                                                        listeners:
                                                                    {
                                                                        check:function(chk,checado)
                                                                                {
                                                                                    modificarParametrosConfiguracion(9,checado?1:0);
                                                                                }	
            
                                                                    }
                                                    },
                                                    {
                                                        x:10,
                                                        y:165,
                                                        xtype:'label',
                                                        ctCls:'SIUGJ_Etiqueta',
                                                        html:'Plantilla de documento default:'
                                                    },
                                                    
                                                    {
                                                    	x:340,
                                                        y:160,
                                                        xtype:'label',
                                                        html:'<div id="divPlantillaDocumento"></div>'
                                                    },	
                                                    
                                                    
                                                    {
                                                        x:10,
                                                        y:215,
                                                        xtype:'label',
                                                        id:'lblEtiquetaFuncionAsignacion',
                                                        hidden:true,
                                                        cls:'SIUGJ_Etiqueta',
                                                        html:'Funci&oacute;n de asignaci&oacute;n:'
                                                    },
                                                    {
                                                        x:240,
                                                        y:210,
                                                        id:'txtFuncionAsignacion',
                                                        width:450,
                                                        cls:'controlSIUGJ',
                                                        hidden:true,
                                                        xtype:'textfield',
                                                        disabled:true
                                                    },
                                                    {
                                                        xtype:'label',
                                                        x:710,
                                                        y:217,
                                                        id:'btnFuncion',
                                                        hidden:true,
                                                        html:'<a href="javascript:agregarFuncionAsignacionOficio()"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionControlEscenario(2)"><img src="../images/cross.png"></a>'
                                                    }
                                                ]
                                    }
                                )
                    
                    
	new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                cls:'panelSiugjWrap',
                                                title: 'Documentos permitidos',
                                                items:	[
                                                            crearGridDocumentosPermitidos(),
                                                            panel
                                                        ]
                                            }
                                         ]
                            }
                        )                     
                    
                    
	
	gEx('txtFuncionAsignacion').idConsulta=gE('funcionAsignacion').value;
    gEx('txtFuncionAsignacion').setValue(gE('lblFuncionAsignacion').value);
    
    var cmbCategoriaDocumentos=crearComboExt('cmbCategoriaDocumentos',arrCategoriaDocumento,0,0,550,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCategoriaDocumento'});
	cmbCategoriaDocumentos.on('select',function(cmb,registro)
											{
												modificarParametrosConfiguracion(3,registro.data.id);
											}
							)
	cmbCategoriaDocumentos.setValue(gE('idCategoriaDocumento').value);

	var cmbPlantillaDefault=crearComboExt('cmbPlantillaDefault',arrPlantillas,0,0,650,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divPlantillaDocumento'});
    cmbPlantillaDefault.setValue(gE('idFormatoDefault').value);
    cmbPlantillaDefault.on('select',function(cmb,registro)
    								{
                                    	gEx('lblEtiquetaFuncionAsignacion').hide();
                                        gEx('txtFuncionAsignacion').hide();                                        
                                        gEx('btnFuncion').hide();
                                        if(registro.data.id=='-10')
                                        {
                                            gEx('lblEtiquetaFuncionAsignacion').show();
                                            gEx('txtFuncionAsignacion').show();                                        
                                            gEx('btnFuncion').show();
                                        }
                                    	
                                    }
    						)
                            
	cmbPlantillaDefault.on('change',function(cmb,registro)
    								{
                                    	
                                    	modificarParametrosConfiguracion(5,registro);
                                    }
    						)

	dispararEventoSelectCombo('cmbPlantillaDefault');
}



function crearGridDocumentosPermitidos()
{
	



	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDocumento'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'idDocumento', direction: 'ASC'},
                                                            groupField: 'idDocumento',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='179';
                                        proxy.baseParams.idPerfil=gE('_idPerfilint').value;
                                        proxy.baseParams.idProceso=gE('_idProcesoint').value;
                                        proxy.baseParams.idFormularioProceso=gE('idFormularioProceso').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:50}),
                                                            
                                                            {
                                                                header:'Formato permitido',
                                                                width:740,
                                                                sortable:true,
                                                                dataIndex:'idDocumento',
                                                                renderer:function(val)
                                                                		{
                                                                			return formatearValorRenderer(arrDocumentos,val);
                                                                		}
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
													{
														id:'gDocumentosPermitidos',
														store:alDatos,
														region:'center',
														frame:false,
														border:false,
                                                        cls:'gridSiugjPrincipal',
														cm: cModelo,
														stripeRows :true,
														loadMask:true,
														columnLines : true,
														tbar:	[
																	{
																		icon:'../images/add.png',
																		cls:'x-btn-text-icon',
																		text:'Agregar formato',
																		handler:function()
																				{
																					mostrarVentanaAgregarFormato();
																				}

																	},
                                                                    {
                                                                    	xtype:'tbspacer',
                                                                        width:10
                                                                    },
																	{
																		icon:'../images/delete.png',
																		cls:'x-btn-text-icon',
																		text:'Remover formato',
																		handler:function()
																				{
																					var fila=tblGrid.getSelectionModel().getSelected();
																					
																					if(!fila)
																					{
																						msgBox('Debe seleccionar el formato que desea remover');
																						return;
																					}
																					
																					
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
																									tblGrid.getStore().remove(fila);
																								}
																								else
																								{
																									msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																								}
																							}
																							obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 
																							'POST','funcion=181&idPerfil='+gE('_idPerfilint').value+'&idProceso='+gE('_idProcesoint').value+
																							'&idFormato='+fila.data.idDocumento+'&idFormularioProceso='+gE('idFormularioProceso').value,true);
																						}
																					}
																					msgConfirm('Est&aacute; seguro de querer remover el documento seleccionado?',resp);
																					
																				}

																	}



																],
														
														view:new Ext.grid.GroupingView({
																							forceFit:false,
																							showGroupName: false,
																							enableGrouping :false,
																							enableNoGroups:false,
																							enableGroupingMenu:false,
																							hideGroupedColumn: false,
																							startCollapsed:false
																						})
													}
												);
        return 	tblGrid;	
}

function mostrarVentanaAgregarFormato()
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
                                            				html:'Formato:'
                                            			},
                                            			{
                                            				x:130,
                                            				y:15,                                                            
                                            				html:'<div id="divComboAutoCompletar"></div>'
                                            			}
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar formato',
										width: 730,
										height:190,
										layout: 'fit',
										plain:true,
                                        cls:'msgHistorialSIUGJ',
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	var oConf=	{
                                                                                    idCombo:'cmbFormato',
                                                                                    anchoCombo:550,
                                                                                    renderTo:'divComboAutoCompletar',
                                                                                    raiz:'registros',
                                                                                    campoDesplegar:'formato',
                                                                                    campoID:'idFormato',
                                                                                    funcionBusqueda:182,
                                                                                    ctCls:'comboWrapSIUGJControl',
                                                                                    cls:'comboSIUGJControl',
                                                                                    listClass:'listComboSIUGJControl',
                                                                                    paginaProcesamiento:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                                                    confVista:'<tpl for="."><div class="search-item">{formato}<br></div></tpl>',
                                                                                    campos:	[
                                                                                                {name:'idFormato'},
                                                                                                {name:'formato'}
                                                            
                                                                                            ],
                                                                                    funcAntesCarga:function(dSet,combo)
                                                                                                {
                                                                                                    idFormato=-1;
                                                                                                    var aValor=combo.getRawValue();
                                                                                                    dSet.baseParams.criterio=aValor;
                                                                                                    
                                                                                                    
                                                                                                },
                                                                                    funcElementoSel:function(combo,registro)
                                                                                                {
                                                                                                    idFormato=registro.data.idFormato;
                                                                                                    
                                                                                                }  
                                                                                };
                                                            
                                                               		var cmbFormato=crearComboExtAutocompletar(oConf)
																	cmbFormato.focus(false,500);
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
																		if(idFormato==-1)
																		{
																			msgBox('Debe seleccionar el formato que desea agregar');
																			return;
																		}
																		
																		function funcAjax()
																		{
																			var resp=peticion_http.responseText;
																			arrResp=resp.split('|');
																			if(arrResp[0]=='1')
																			{
																				gEx('gDocumentosPermitidos').getStore().reload();
																				ventanaAM.close();
																			}
																			else
																			{
																				msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																			}
																		}
																		obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 
																		'POST','funcion=180&idPerfil='+gE('_idPerfilint').value+'&idProceso='+gE('_idProcesoint').value+
																		'&idFormato='+idFormato+'&idFormularioProceso='+gE('idFormularioProceso').value,true);
																		
																		
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
}

function modificarParametrosConfiguracion(param,valor)
{
	function funcAjax()
	{
		var resp=peticion_http.responseText;
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
			
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 
	'POST','funcion=207&idPerfil='+gE('_idPerfilint').value+'&idProceso='+gE('_idProcesoint').value+
	'&idFormularioProceso='+gE('idFormularioProceso').value+'&parametro='+param+'&valor='+valor,true);
}


function agregarFuncionAsignacionOficio()
{

	var control=gEx('txtFuncionAsignacion');
	
    
    
    asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre,ventana)
                                            {
                                             	control.idConsulta=idConsulta;
                                                control.setValue(nombre);
                                                 modificarParametrosConfiguracion(6,control.idConsulta);
                                                if(gEx('vAgregarExp'))
	                                                gEx('vAgregarExp').close();
                                            }
    mostrarVentanaExpresion(function(filaSelec,ventana)
    						{
                            	control.idConsulta=filaSelec.data.idConsulta;
                                control.setValue(filaSelec.data.nombreConsulta);
                                modificarParametrosConfiguracion(6,control.idConsulta);
                                
                                ventana.close();
                            }
    						,true);
    
}


function removerFuncionControlEscenario(tipo)
{
	var control=gEx('txtFuncionAsignacion');
    control.idConsulta='';
    control.setValue('');
    modificarParametrosConfiguracion(6,-1);
}