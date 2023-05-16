<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idRegistro,descripcion FROM 7014_situacionCarpetaAdministrativa where asociableDocumento=1 order by descripcion";
	$arrSituacionCarpetaDocumento=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos";
	$arrCategorias=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT idRegistro,descripcion FROM 7014_situacionCarpetaAdministrativa";
	$arrStuacionCarpeta=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__10_tablaDinamica,nombreFormato,perfilValidacion FROM _10_tablaDinamica WHERE idEstado=1 AND perfilValidacion IS NOT NULL";
	$arrPlatillasDocumentos=$con->obtenerFilasArreglo($consulta);
	
?>
var uploadControl;

var arrPlatillasDocumentos=<?php echo $arrPlatillasDocumentos?>;
var nodoPlantillaSel=null;
var arrStuacionCarpeta=<?php echo $arrStuacionCarpeta?>;
var arrCategorias=<?php echo $arrCategorias?>;
var arrSituacionCarpetaDocumento=<?php echo $arrSituacionCarpetaDocumento?>;
var arrSiNo=<?php echo $arrSiNo?>;

Ext.onReady(inicializar);

function inicializar()
{
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                
                                                items:	[
                                                            crearGridGeneracionDocumentos()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}



function crearGridGeneracionDocumentos()
{
	
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDocumento'},
		                                                {name: 'tipoDocumento'},
		                                                {name:'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'responsableCreacion'},
                                                        {name: 'situacion'},
                                                        {name:'idDocumentoServidor'},
                                                        {name: 'documentoBloqueado'}
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
                                                            sortInfo: {field: 'fechaCreacion', direction: 'ASC'},
                                                            groupField: 'fechaCreacion',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                   	
                                   		gEx('btnModifyDocument').disable();
                                   		gEx('btnDeleteDocument').disable();
                                    	proxy.baseParams.funcion='145';
                                        proxy.baseParams.cA=gE('carpetaAdministrativa').value;
                                        proxy.baseParams.idFormulario=gE('iFormulario').value;
                                        proxy.baseParams.idReferencia=gE('iRegistro').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:50}),
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'idDocumentoServidor',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(registro.data.documentoBloqueado=='1')
                                                                            {
                                                                            	return '<a href="javascript:visualizarDocumentoFinalizado(\''+bE(val)+'\',\''+bE(registro.data.tipoDocumento)+'\')"><img src="../images/page_white_magnify.png" title="Visualizar documento" alt="Visualizar documento"/></a>';
                                                                            }
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de creaci&oacute;n',
                                                                width:190,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacion',
                                                                renderer:function(val)
                                                                		{
                                                                			return val.format('d/m/Y H:i:s')
                                                                		}
                                                            },
                                                            {
                                                                header:'Tipo de documento',
                                                                width:350,
                                                                sortable:true,
                                                                renderer:mostrarValorDescripcion,
                                                                dataIndex:'tipoDocumento',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            
                                                            {
                                                                header:'Registrado por',
                                                                width:250,
                                                                sortable:true,
                                                                renderer:mostrarValorDescripcion,
                                                                dataIndex:'responsableCreacion'
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n actual',
                                                                width:300,
                                                                sortable:true,
                                                                renderer:mostrarValorDescripcion,
                                                                dataIndex:'situacion'
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gDocumentos',
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
                                                                                text:'Crear documento',
                                                                                hidden:gE('sL').value=='1',
																				handler:function()
																						{
																							mostrarVentanaAddDocumento();
																						}

																			},
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                                width:10
                                                                            }
                                                                            ,
																			{
																				id:'btnModifyDocument',
																				icon:'../images/pencil.png',
																				cls:'x-btn-text-icon',
																				text:'Modificar documento',
                                                                                hidden:gE('sL').value=='1',
																				handler:function()
																						{
																							var fila=gEx('gDocumentos').getSelectionModel().getSelected();
																							if(!fila)
																							{
																								msgBox('Debe seleccionar el documento que desea modificar');
																								return;
																							}
																							
                                                                                            
                                                                                            function funcAjax()
                                                                                            {
                                                                                                var resp=peticion_http.responseText;
                                                                                                arrResp=resp.split('|');
                                                                                                if(arrResp[0]=='1')
                                                                                                {
                                                                                                    var obj={};    
                                                                                                    obj.ancho='100%';
                                                                                                    obj.alto='100%';
                                                                                                    obj.url='../modeloPerfiles/vistaDTDv3.php';
                                                                                                    obj.modal=true;
                                                                                                    obj.funcionCerrar=function()
                                                                                                    					{
                                                                                                                        	gEx('gDocumentos').getStore().reload();
                                                                                                                        };
                                                                                                    obj.params=[['idFormulario',1289],['idRegistro',arrResp[1]],['idReferencia',-1],
                                                                                                            ['dComp',arrResp[2]],['actor',arrResp[3]]];
                                                                                                    window.parent.abrirVentanaFancy(obj);
                                                                                                    
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=408&iFormulario='+gE('iFormulario').value+
                                                                                            			'&iRegistro='+gE('iRegistro').value+'&cA='+gE('carpetaAdministrativa').value+'&iP=-1&iR='+fila.data.idDocumento,true);
                                                                                            
                                                                                            
                                                                                            
																						}

																			},
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                                width:10
                                                                            },
																			{
																				icon:'../images/delete.png',
																				id:'btnDeleteDocument',
																				cls:'x-btn-text-icon',
                                                                                hidden:gE('sL').value=='1',
																				text:'Remover documento',
																				handler:function()
																						{
																							var fila=gEx('gDocumentos').getSelectionModel().getSelected();
																							if(!fila)
																							{
																								msgBox('Debe seleccionar el documento que desea remover');
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
																											gEx('gDocumentos').getStore().reload();
																										}
																										else
																										{
																											msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																										}
																									}
																									obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=146&iD='+fila.data.idDocumento,true);
																								}
																							}
																							msgConfirm('Est&aacute; seguro de querer remover el documento seleccionado?',resp);
																						}

																			}

																		]   ,                                                          
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
        
        
        
        tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
       												{
                                                    
       													gEx('btnModifyDocument').disable();
                                   						gEx('btnDeleteDocument').disable();
                                   						if(registro.data.documentoBloqueado=='0')
                                   						{
                                   							gEx('btnModifyDocument').enable();
                                   							gEx('btnDeleteDocument').enable();
                                   						}
       												}
        								)
        return 	tblGrid;
}


function mostrarVentanaAddDocumento(iDocumento,importarWord)
{
	if(iDocumento)
    {
    	nodoPlantillaSel={};
    	nodoPlantillaSel.id=iDocumento;
        nodoPlantillaSel.attributes={};
        
        var pos=existeValorMatriz(arrPlatillasDocumentos,iDocumento);
        
    	nodoPlantillaSel.attributes.perfilValidacion=arrPlatillasDocumentos[pos][2];
		nodoPlantillaSel.text=arrPlatillasDocumentos[pos][1];
    	mostrarVentanaDatosDocumento(importarWord?true:false,importarWord);
    	return;
    }
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearArbolPlantillas(),
                                            			{
                                            				xtype:'panel',
                                            				region:'center',
                                            				layout:'absolute',
                                            				items: 	[
                                           								{
                                           									x:0,
                                           									y:0,
                                           									xtype:'label',
																			html:'<textarea id="txtDocumentoDemo"></textarea>'
                                           								}
                                            						]
                                            			}                               			
                                            			
                                            			
													]
										}
									);
	var anchoVentana=(obtenerDimensionesNavegador()[1]*0.9);
    var altoVentana=(obtenerDimensionesNavegador()[0]*0.9);
	var ventanaAM = new Ext.Window(
									{
										title: 'Crear documento',
										width: anchoVentana,
                                        id:'wCreateDocumentDocument',
										height:altoVentana,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
																	var editor1=	CKEDITOR.replace('txtDocumentoDemo',
																										 {

																											customConfig:'../../modulosEspeciales_SGJP/Scripts/configCKEditorEjecucionSLV2.js',
																											width:anchoVentana-310,
																											height:altoVentana-100,
																											resize_enabled:false,
																											on:	{
																													instanceReady:function(evt)
																																{
																																	


																																}

																												}
																										 }
																						);
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
																		if(!nodoPlantillaSel)
																		{
																			msgBox('Debe seleccionar la plantilla a utilizar para generar el documento');
																			return;
																		}
                                                                        
                                                                        
                                                                       	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                var obj={};    
                                                                                obj.ancho='100%';
                                                                                obj.alto='100%';
                                                                                obj.url='../modeloPerfiles/vistaDTDv3.php';
                                                                                obj.modal=true;
                                                                                obj.funcionCerrar=function()
                                                                                                    					{
                                                                                                                        	gEx('gDocumentos').getStore().reload();
                                                                                                                        };
                                                                                obj.params=[['idFormulario',1289],['idRegistro',arrResp[1]],['idReferencia',-1],
                                                                                        ['dComp',arrResp[2]],['actor',arrResp[3]]];
                                                                                window.parent.abrirVentanaFancy(obj);
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=408&iFormulario='+gE('iFormulario').value+
                                                                        			'&iRegistro='+gE('iRegistro').value+'&cA='+gE('carpetaAdministrativa').value+'&iP='+nodoPlantillaSel.id,true);
																	}
														}
													]
									}
								);
	ventanaAM.show();
}

function crearArbolPlantillas()
{
	var raiz=new  Ext.tree.AsyncTreeNode(
											{
												id:'-1',
												text:'Raiz',
												draggable:false,
												expanded :false,
												cls:'-1'
											}
										)
										
	var cargadorArbol=new Ext.tree.TreeLoader(
											{
												baseParams:{
																funcion:'142',
																idFormulario:gE('iFormulario').value,
																idRegistro:gE('iRegistro').value,
																actor:gE('actor')?gE('actor').value:-1
															},
												dataUrl:'../paginasFunciones/funcionesModulosEspeciales_SGP.php'
											}
										)		
										
											
										
	var arbolPlantillas=new Ext.tree.TreePanel	(
														{
															
															id:'arbolPlantillas',
															useArrows:true,
															autoScroll:true,
															animate:true,
															enableDD:true,
															width:280,
															region:'west',
															containerScroll: true,
															root:raiz,
                                                            cls:'cssArbol',
															loader: cargadorArbol,
															rootVisible:false
															
														}
													)
			
							
	arbolPlantillas.on('click',funcPlantillaClick);	
	
	return arbolPlantillas;
}


function funcPlantillaClick(nodo)
{
	nodoPlantillaSel=nodo;
	
	if(nodo.attributes.tipoNodo=='2')
	{
	
		function funcAjax()
		{
			var resp=peticion_http.responseText;
			arrResp=resp.split('|');
			if(arrResp[0]=='1')
			{
				var objPlantilla=eval('['+arrResp[1]+']')[0];
				CKEDITOR.instances["txtDocumentoDemo"].setData(bD(objPlantilla.cuerpoDocumento));
                setTimeout(	function()
                			{
                            	//Zoom
			                	/*var anchoVentana=(obtenerDimensionesNavegador()[1]*0.9)-310;
							    var altoVentana=(obtenerDimensionesNavegador()[0]*0.9)-100;                                                                                       											
                                var body = CKEDITOR.instances.txtDocumentoDemo.editable().$;
                
                                var value = anchoVentana*100/800;
                                body.style.MozTransformOrigin = "top left";
                                body.style.MozTransform = "scale(" + (value/100)  + ")";
                                body.style.WebkitTransformOrigin = "top left";
                                body.style.WebkitTransform = "scale(" + (value/100)  + ")";
                                body.style.OTransformOrigin = "top left";
                                body.style.OTransform = "scale(" + (value/100)  + ")";
                                body.style.TransformOrigin = "top left";
                                body.style.Transform = "scale(" + (value/100)  + ")";
                                body.style.zoom = value/100;*/
                          	},500
                         )

			}
			else
			{
				msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
			}
		}
		obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=143&iD='+nodo.id,true);
	}
	else
	{
		nodoPlantillaSel=null;
		CKEDITOR.instances["txtDocumentoDemo"].setData('');
	}
	
}


function mostrarVentanaDatosDocumento(datosDocumento,importarDocumento)
{
	

                    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                            			
                                            				x:10,
                                            				y:10,
                                                            id:'lblTituloDocumento',
                                                            hidden:importarDocumento,
                                            				html:'T&iacute;tulo del documento:'
                                            			},
                                                        {
                                            			
                                            				x:10,
                                            				y:10,
                                                            id:'lblIngreseDocumento',
                                                            hidden:!importarDocumento,
                                            				html:'Ingrese documento a adjuntar:'
                                            			},
                                            			{
                                            				x:210,
                                            				y:5,
                                            				xtype:'textfield',
                                            				width:300,
                                                            
                                                            hidden:importarDocumento,
                                            				id:'txtTitulo'
                                            			},
                                                        {
                                                        	xtype:'button',
                                                            cls:'x-btn-text-icon',
                                                            icon:'../images/page_word.png',
                                                            text:'Adjuntar documento Word',
                                                            width:160,
                                                            x:530,
                                                            y:5,
                                                            id:'btnAdjuntarDocumento',
                                                            enableToggle : true,
                                                            pressed:importarDocumento,
                                                            toggleHandler:function(btn,presionado)
                                                                            {
                                                                                if(presionado)
                                                                                {
                                                                                   	gEx('lblIngreseDocumento').show();
                                                                                    gEx('lblTituloDocumento').hide();
                                                                                    gEx('txtTitulo').hide();                                                                                    
                                                                                    gEx('lblTabla').show();
                                                                                    gEx('btnUploadFile').show();
                                                                                    importarDocumento=true;
                                                                                }
                                                                                else
                                                                                {
                                                                                    gEx('lblIngreseDocumento').hide();
                                                                                    gEx('lblTituloDocumento').show();                                                                                    
                                                                                    gEx('txtTitulo').show();
                                                                                    gEx('lblTabla').hide();
                                                                                    gEx('btnUploadFile').hide();
                                                                                    gEx('txtTitulo').focus();
                                                                                    importarDocumento=false;
                                                                                }
                                                                            }
                                                            			
                                                        },
                                                        {
                                                            x:185,
                                                            y:5,
                                                            
                                                            id:'lblTabla',
                                                            html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                        },
                                                        {
                                                            x:185,
                                                            y:35,
                                                            hidden:true,
                                                            html:	'<div id="containerUploader"></div>'
                                                        },
                                                        {
                                                            x:480,
                                                            y:6,
                                                            width:30,
                                                            id:'btnUploadFile',
                                                            xtype:'button',
                                                            text:'...',
                                                            handler:function()
                                                                    {
                                                                        $('#containerUploader').click();
                                                                    }
                                                        },
                                                        
                                                        {
                                                            x:290,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'idArchivo'

                                                        },
                                                        {
                                                            x:290,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'nombreArchivo'
                                                        }, 
                                            			{
                                            			
                                            				x:10,
                                            				y:40,
                                            				html:'Ingrese la descripci&oacute;n de la actuaci&oacute;n:'
                                            			},
                                            			{
                                            				x:10,
                                            				y:70,
                                            				xtype:'textarea',
                                            				width:680,
                                            				height:80,
                                            				id:'txtDescripcion'
                                            			},
                                            			crearGridProgramacionAlerta()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Informaci&oacute;n del documento [Tipo del documento: '+formatearValorRenderer(arrPlatillasDocumentos,nodoPlantillaSel.id)+']',
										width: 730,
                                        id:'vInfoDocumento',
										height:440,
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
																	if(!importarDocumento)
																		gEx('txtTitulo').focus(false,500);
                                                                    
                                                                    
                                                                    var cObj={
                                                                    // Backend settings
                                                                                            upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                                                                                            file_post_name: "archivoEnvio",
                                                                             
                                                                                            // Flash file settings
                                                                                            file_size_limit : "1000 MB",
                                                                                            file_types : "*.doc;*.docx",			// or you could use something like: "*.doc;*.wpd;*.pdf",
                                                                                            file_types_description : "Todos los archivos",
                                                                                            file_upload_limit : 0,
                                                                                            file_queue_limit : 1,
                                                                             
                                                                                           
                                                                                            upload_success_handler : subidaCorrectaDocument,
                                                                                            
                                                                                        }; 
                                                                    
                                                                    
                                                                    crearControlUploadHTML5(cObj);     
                                                                    
                                                                     if(presionado)
                                                                      {
                                                                          gEx('lblIngreseDocumento').show();
                                                                          gEx('lblTituloDocumento').hide();
                                                                          gEx('txtTitulo').hide();                                                                                    
                                                                          gEx('lblTabla').show();
                                                                          gEx('btnUploadFile').show();
                                                                          importarDocumento=true;
                                                                      }
                                                                      else
                                                                      {
                                                                          gEx('lblIngreseDocumento').hide();
                                                                          gEx('lblTituloDocumento').show();                                                                                    
                                                                          gEx('txtTitulo').show();
                                                                          gEx('lblTabla').hide();
                                                                          gEx('btnUploadFile').hide();
                                                                          gEx('txtTitulo').focus();
                                                                          importarDocumento=false;
                                                                      }
                                                                                
                                                                                        
                                                                   	
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		
																		
																		var txtDescripcion=gEx('txtDescripcion');
																		if(!importarDocumento)
                                                                        {
                                                                        	var txtTitulo=gEx('txtTitulo');
                                                                            if(txtTitulo.getValue().trim()=='')
                                                                            {
                                                                                function resp()
                                                                                {
                                                                                    txtTitulo.focus();
                                                                                }
                                                                                msgBox('Debe ingresar el t&iacute;tulo del documento',resp);
                                                                                return;
                                                                            }
                                                                            
                                                                            
                                                                            var arrAlertas='';
                                                                            var gAlertas=gEx('gAlertas');
                                                                            var x;
                                                                            var f;
                                                                            for(x=0;x<gAlertas.getStore().getCount();x++)
                                                                            {
                                                                                f=gAlertas.getStore().getAt(x);
                                                                                
                                                                                if(f.data.fechaAlerta=='')
                                                                                {
                                                                                    function respDoc2()
                                                                                    {
                                                                                        gAlertas.startEditing(x,2);
                                                                                    }
                                                                                    
                                                                                    msgBox('Debe ingresar la fecha de la alerta',respDoc2);
                                                                                    return;
                                                                                }
                                                                                
                                                                                if(f.data.descripcionAlerta.trim()=='')
                                                                                {
                                                                                    function respDoc()
                                                                                    {
                                                                                        gAlertas.startEditing(x,3);
                                                                                    }
                                                                                    msgBox('Debe ingresar la descripci&oacute;n de la alerta',respDoc);
                                                                                    return;
                                                                                }
                                                                                
                                                                                oAlerta='{"fechaAlerta":"'+f.data.fechaAlerta.format('Y-m-d')+'","textoAlerta":"'+cv(f.data.descripcionAlerta)+'"}';
                                                                                if(arrAlertas=='')
                                                                                    arrAlertas=oAlerta;
                                                                                else
                                                                                    arrAlertas+=','+oAlerta;
                                                                            }
                                                                            
                                                                            var cadObj='{"idGeneracionDocumento":"-1","tipoDocumento":"'+nodoPlantillaSel.id+'","tituloDocumento":"'+cv(txtTitulo.getValue().trim())+
                                                                                        '","perfilValidacion":"'+nodoPlantillaSel.attributes.perfilValidacion+'","fechaLimite":"","modificaSituacionCarpeta":"0","situacion":"'+
                                                                                        '","descripcionActuacion":"'+cv(gEx('txtDescripcion').getValue())+'","carpetaAdministrativa":"'+
                                                                                        gE('carpetaAdministrativa').value+'","idFormulario":"'+gE('iFormulario').value+'","idRegistro":"'+gE('iRegistro').value+
                                                                                        '","arrAlertas":['+arrAlertas+']}';
                                                                            
                                                                            
                                                                            function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                	var anchoVentana=(obtenerDimensionesNavegador()[1]*0.9);
																					var altoVentana=(obtenerDimensionesNavegador()[0]*0.9);
                                                                                    objConf={
                                                                                                tipoDocumento:nodoPlantillaSel.id,
                                                                                                idFormulario:-2,
                                                                                                idRegistro: arrResp[1],
                                                                                                actor:gE('actor').value,
                                                                                                ancho:anchoVentana,
																		                        alto:altoVentana,
                                                                                                functionAfterValidate:function()
                                                                                                                {
                                                                                                                    gEx('gDocumentos').getStore().reload();
                                                                                                                },
                                                                                                functionAfterTurn:function()
                                                                                                                {
                                                                                                                    gEx('gDocumentos').getStore().reload();
                                                                                                                },
                                                                                                functionAfterSaveDocument:function()
                                                                                                                            {
                                                                                                                                gEx('gDocumentos').getStore().reload();
                                                                                                                            },
                       	
                                                                                                functionAfterLoadDocument:function()
                                                                                                                        {
                                                                                                                            setTimeout(function()
                                                                                                                                        {
                                                                                                                                        	//Zoom
                                                                                                                                            /*
                                                                                                                                            var body = CKEDITOR.instances.txtDocumento.editable().$;
                                                                                                                                            
                                                                                                                                            var value = (anchoVentana*100)/900;
                                                                                                                                            
                                                                        
                                                                                                                                            body.style.MozTransformOrigin = "top left";
                                                                                                                                            body.style.MozTransform = "scale(" + (value/100)  + ")";
                                                                        
                                                                                                                                            body.style.WebkitTransformOrigin = "top left";
                                                                                                                                            body.style.WebkitTransform = "scale(" + (value/100)  + ")";
                                                                        
                                                                                                                                            body.style.OTransformOrigin = "top left";
                                                                                                                                            body.style.OTransform = "scale(" + (value/100)  + ")";
                                                                        
                                                                                                                                            body.style.TransformOrigin = "top left";
                                                                                                                                            body.style.Transform = "scale(" + (value/100)  + ")";
                                                                                                                                            // IE
                                                                                                                                            body.style.zoom = value/100;
                                                                                                                                            */
                                                                                                                                        
                                                                                                                                            
                                                                                                                                        },200
                                                                                                                                    )
                                                                                                                            
                                                                        
                                                                                                                            
                                                                                                                        } 
    
                                                                                             };
                                                                                    gEx('gDocumentos').getStore().reload();
                                                                                    ventanaAM.close();
                                                                                    mostrarVentanaGeneracionDocumentos(objConf);
                                                                                    
                                                                                    
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=144&cadObj='+cadObj,true);
																		}
                                                                        else
                                                                        {
                                                                        	if(uploadControl.files.length==0)
                                                                            {
                                                                                msgBox('Debe ingresar el documento que desea adjuntar');
                                                                                return;
                                                                            }
                                                                            uploadControl.start();
                                                                            
	                                                                    }  
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
	
	
	
	if(!datosDocumento)
	{
		gEx('txtTitulo').setValue(nodoPlantillaSel.text);
	}
}


function visualizarDocumentoFinalizado(iD,tD)
{

	mostrarVisorDocumentoProceso('pdf',bD(iD));

}




function crearGridProgramacionAlerta()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                   
                                                                    {name: 'fechaAlerta', type:'date', dateFormat:'Y-m-d'},
                                                                    {name: 'descripcionAlerta'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Fecha de alerta',
															width:120,
															sortable:true,
															dataIndex:'fechaAlerta',
															editor:{xtype:'datefield'},
															renderer:function(val)
																	{
																		if(!val)
																			return '';
																		return val.format('d/m/Y');
																	}
														},
														{
															header:'Descripci&oacute;n de la alerta',
															width:480,
															sortable:true,
															editor:{ xtype:'textarea',height:80},
															dataIndex:'descripcionAlerta',
															renderer:mostrarValorDescripcion
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gAlertas',
                                                            store:alDatos,
                                                            frame:false,
                                                            y:160,
                                                            x:10,
                                                            clicksToEdit:1,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:190,
                                                            width:680,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/clock_add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Programar alerta',
                                                                            handler:function()
                                                                            		{
                                                                                    	var regAlerta= crearRegistro (
                                                                                   										[
                                                                                   											{name: 'fechaAlerta'},
                                                                    														{name: 'descripcionAlerta'}
                                                                                   										
                                                                                   										]
                                                                                    								)
                                                                                    
                                                                                    	var r=new  regAlerta 	(
                                                                                   									{
                                                                                   										fechaAlerta:'',
                                                                                   										descripcionAlerta:''
                                                                                   									}
                                                                                    							)
                                                                                    
                                                                                    
                                                                                    
                                                                                    	tblGrid.getStore().add(r);
                                                                                    	tblGrid.startEditing(tblGrid.getStore().getCount()-1,2);
                                                                                    	
                                                                                    	
                                                                                    	
                                                                                    	
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover alerta',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                    	if(!fila)
                                                                                    	{
                                                                                    		msgBox('Debe seleccionar la alerta que desea remover');
                                                                                    		return;
                                                                                    	}
                                                                                    	
                                                                                    	function resp(btn)
                                                                                    	{
                                                                                    		if(btn=='yes')
                                                                                    		{
                                                                                    			tblGrid.getStore().remove(fila);
                                                                                    		}
                                                                                    	}
                                                                                    	msgConfirm('Est&aacute; seguro de querer remover la alerta seleccionada?',resp);
                                                                                    	return;
                                                                                    	
                                                                                    	
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}

function subidaCorrectaDocument(file, serverData) 
{
	
	
	//try 
    
    file.id = "singlefile";	// This makes it so FileProgress only makes a single UI element, instead of one for each file
    var arrDatos=serverData.split('|');
    if ( arrDatos[0]!='1') 
    {
        
    } 
    else 
    {
        
        gEx("idArchivo").setValue(arrDatos[1]);
        gEx("nombreArchivo").setValue(arrDatos[2]);
        if(gE('txtFileName'))
	        gE('txtFileName').value=arrDatos[2];
        
        var arrAlertas='';
        var gAlertas=gEx('gAlertas');
        var x;
        var f;
        for(x=0;x<gAlertas.getStore().getCount();x++)
        {
            f=gAlertas.getStore().getAt(x);
            
            if(f.data.fechaAlerta=='')
            {
                function respDoc2()
                {
                    gAlertas.startEditing(x,2);
                }
                
                msgBox('Debe ingresar la fecha de la alerta',respDoc2);
                return;
            }
            
            if(f.data.descripcionAlerta.trim()=='')
            {
                function respDoc()
                {
                    gAlertas.startEditing(x,3);
                }
                msgBox('Debe ingresar la descripci&oacute;n de la alerta',respDoc);
                return;
            }
            
            oAlerta='{"fechaAlerta":"'+f.data.fechaAlerta.format('Y-m-d')+'","textoAlerta":"'+cv(f.data.descripcionAlerta)+'"}';
            if(arrAlertas=='')
                arrAlertas=oAlerta;
            else
                arrAlertas+=','+oAlerta;
        }
        
        var cadObj='{"idGeneracionDocumento":"-1","tipoDocumento":"'+nodoPlantillaSel.id+'","tituloDocumento":"'+cv(arrDatos[2])+'","perfilValidacion":"'+
                nodoPlantillaSel.attributes.perfilValidacion+'","fechaLimite":"","modificaSituacionCarpeta":"0","situacion":"'+
                    '","descripcionActuacion":"'+cv(gEx('txtDescripcion').getValue())+'","carpetaAdministrativa":"'+
                    gE('carpetaAdministrativa').value+'","nombreArchivoTemp":"'+arrDatos[1]+'","nombreArchivo":"'+arrDatos[2]+
                    '","idFormulario":"'+gE('iFormulario').value+'","idRegistro":"'+gE('iRegistro').value+'","arrAlertas":['+arrAlertas+']}';
        
        
       
        
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                objConf={
                            tipoDocumento:nodoPlantillaSel.id,
                            idFormulario:-2,
                            idRegistro: arrResp[1],
                            idRegistroFormato:arrResp[2],
                            actor:gE('actor').value,
                            functionAfterValidate:function()
                                            {
                                                gEx('gDocumentos').getStore().reload();
                                            },
                            functionAfterTurn:function()
                                            {
                                                gEx('gDocumentos').getStore().reload();
                                            },
                            functionAfterSaveDocument:function()
                                                        {
                                                            gEx('gDocumentos').getStore().reload();
                                                        }

                         };
                gEx('gDocumentos').getStore().reload();
                gEx('vInfoDocumento').close();
                mostrarVentanaGeneracionDocumentos(objConf);
                
                
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=144&cadObj='+cadObj,true);
        
        
        
    }
		
	
}