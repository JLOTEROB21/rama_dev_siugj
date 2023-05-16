<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$consulta="SELECT id__10_tablaDinamica,CONCAT('(',cveFormato,') ',nombreFormato) FROM _10_tablaDinamica";
	$arrDocumentos=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos ORDER BY nombreCategoria";
	$arrCategorias=$con->obtenerFilasArreglo($consulta);
?>

var arrCategorias=<?php echo $arrCategorias?>;
var idFormato=-1;
var arrDocumentos=<?php echo $arrDocumentos?>;
Ext.onReady(inicializar);

function inicializar()
{
	crearGridDocumentosPermitidos()
}



function crearGridDocumentosPermitidos()
{
	var cmbCategoria=crearComboExt('cmbCategoria',arrCategorias,0,0,300);
    
    cmbCategoria.setValue(gE('idCategoriaDocumento').value);
    cmbCategoria.on('select',function(cmb,registro)
    						{
                            	var cadObj='{"idPerfil":"'+gE('_idPerfilint').value+'","idProceso":"'+gE('_idProcesoint').value+'","idFormularioProceso":"'+
                                				gE('idFormularioProceso').value+'","idCategoria":"'+registro.data.id+'"}';
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
                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=190&cadObj='+cadObj,true);
                            }
    				)
    
    
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
                                                            new  Ext.grid.RowNumberer(),
                                                            
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
														width:800,
														height:400,
														renderTo:'tblGrid',
														frame:false,
														border:true,
														cm: cModelo,
														stripeRows :true,
														loadMask:true,
														columnLines : true,
														tbar:	[
                                                        			{
                                                                    	xtype:'label',
                                                                        html:'Categoría asignar a documentos adjuntos:&nbsp;&nbsp;'
                                                                    },
                                                                    cmbCategoria,'-',
																	{
																		icon:'../images/add.png',
																		cls:'x-btn-text-icon',
																		text:'Agregar formato',
																		handler:function()
																				{
																					mostrarVentanaAgregarFormato();
																				}

																	},'-',
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
	var oConf=	{
    					idCombo:'cmbFormato',
                        anchoCombo:550,
                        posX:90,
                        posY:5,
                        raiz:'registros',
                        campoDesplegar:'formato',
                        campoID:'idFormato',
                        funcionBusqueda:182,
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
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                            				x:10,
                                            				y:10,
                                            				html:'Formato:'
                                            			},
                                            			cmbFormato
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar formato',
										width: 700,
										height:140,
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
																	cmbFormato.focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
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
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}