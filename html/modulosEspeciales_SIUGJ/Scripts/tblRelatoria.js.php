<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

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
                                                            new Ext.ux.IFrameComponent({ 
                
                                                                                                id: 'frameContenidoReporte', 
                                                                                                anchor:'100% 100%',
                                                                                                region:'center',
                                                                                                loadFuncion:function(iFrame)
                                                                                                            {
                                                                                                                
                                                                                                            },

                                                                                                url: '../paginasFunciones/white.php',
                                                                                                style: 'width:100%;height:100%' 
                                                                                        })
                                                        ]
                                            },
                                            crearArbolSeccionesRetoria()
                                         ]
                            }
                        )   
                        
      
	 gEx('frameContenidoReporte').load	(
                                            {
                                                url:'../visoresGaleriaDocumentos/visorDocumentosGeneral.php',
                                                params:	{
                                                            iD:bE('iD_'+gE('idDocumento').value),
                                                            cPagina:'sFrm=true'
                                                        }
                                            }
                                        );                        
}


function crearArbolSeccionesRetoria()
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
                                                                    funcion:'1',
                                                                    idFormulario:gE('idFormulario').value,
                                                                    idDocumento:gE('idDocumento').value,
                                                                    idRegistro:gE('idRegistro').value
                                                                   
                                                                },
                                                    dataUrl:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloRelatoria.php'
                                                }
                                            )		
										
	cargadorArbol.on('beforeload',function(c)
    						{
                            	
                            }
    				)	
    										
	cargadorArbol.on('load',function(c,nodoCarga)
    						{
                            	
                            }
    				)										
	var arbol=new Ext.tree.TreePanel	(
                                                            {
                                                                id:'arbolSecciones',
                                                                useArrows:true,
                                                                animate:true,
                                                                enableDD:false,
                                                                ddScroll:true,
                                                                enableSort : false,
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                border:true,
                                                                region:'west',
                                                                width:420,
                                                                root:raiz,
                                                                loader: cargadorArbol,
                                                                rootVisible:false
                                                            }
                                                        )
         
         
	arbol.on('click',nodoClick);
    
    
                                                        
	return  arbol;
}



function nodoClick(nodo)
{
	var funcionVentana=bD(nodo.attributes.datosComplementarios);
    eval(funcionVentana+'(nodo);');
}


function mostrarVentanaCampoAbierto(nodo)
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
                                                            xtype:'textarea',
                                                            width:650,
                                                            height:100,
                                                            readOnly:(gE('sL').value=='1'),
                                                            cls:'controlSIUGJ',
                                                            value:escaparBR(bD(nodo.attributes.valorSeccion)),
                                                            id:'txtCampoAbierto'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Secci&oacute;n: '+nodo.text,
										width: 690,
										height:230,
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
                                                                	gEx('txtCampoAbierto').focus(false,500);
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
                                                            hidden:gE('sL').value=='1',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
																		var txtCampoAbierto=gEx('txtCampoAbierto');
                                                                        
                                                                        if(txtCampoAbierto.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtCampoAbierto.focus();
                                                                            }
                                                                            msgBox('Debe indicar el valor de la secci&oacute;n <b>'+nodo.text+'</b>');
                                                                            return;
                                                                        }
                                                                        var arrID=nodo.id.split('_');
                                                                        
                                                                        var cadObj='{"idFormulario":"'+gE('idFormulario').value+'","idReferencia":"'+gE('idRegistro').value+
                                                                        			'","idSeccion":"'+arrID[1]+'","valorSeccion":"'+cv(txtCampoAbierto.getValue())+'"}';
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('arbolSecciones').getRootNode().reload();
                                                                                
                                                                                if((window.parent)&&(window.parent.recargarMenuDTD))
                                                                                {
                                                                                    window.parent.recargarMenuDTD();
                                                                                }
                                                                                
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloRelatoria.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true);
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
}

function mostrarVentanaEtiquetado(nodo)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridEtiquetas(nodo)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Secci&oacute;n: '+nodo.text,
										width: 900,
										height:400,
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
                                                                	
																}
															}
												},
										buttons:	[
                                        				{
															text: 'Cerrar',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
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

function crearGridEtiquetas(nodo)
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'idEtiqueta'},
		                                                {name:'lblEtiqueta'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloRelatoria.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'lblEtiqueta', direction: 'ASC'},
                                                            groupField: 'lblEtiqueta',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='3';
                                        proxy.baseParams.idDocumento=gE('idDocumento').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            
                                                            {
                                                                header:'Etiqueta',
                                                                width:1300,
                                                                sortable:true,
                                                                dataIndex:'lblEtiqueta'
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gEtiquetas',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : false,
                                                                cls:'gridSiugjPrincipal',
                                                                tbar:	[
                                                                            {
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar etiqueta',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaAgregarEtiqueta(nodo);
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                                width:15
                                                                            },
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover etiqueta',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=gEx('gEtiquetas').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la etiqueta a eliminar');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            
                                                                                            function resp(btn)
                                                                                            {
                                                                                                if(btn=='yes')
                                                                                                {
                                                                                                
                                                                                                	var arrID=nodo.id.split('_');
                                                                        
                                                                        							var cadObj='{"idArchivo":"'+gE('idDocumento').value+'","idFormulario":"'+gE('idFormulario').value+'","idReferencia":"'+gE('idRegistro').value+'","idSeccion":"'+arrID[1]+'","iRegistro":"'+fila.data.idRegistro+'"}';
                                                                                                    function funcAjax()
                                                                                                    {
                                                                                                        var resp=peticion_http.responseText;
                                                                                                        arrResp=resp.split('|');
                                                                                                        if(arrResp[0]=='1')
                                                                                                        {
                                                                                                        	gEx('arbolSecciones').getRootNode().reload();
                                                                                							gEx('gEtiquetas').getStore().reload();
                                                                                                            if((window.parent)&&(window.parent.recargarMenuDTD))
                                                                                                            {
                                                                                                                window.parent.recargarMenuDTD();
                                                                                                            }
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloRelatoria.php',funcAjax, 'POST','funcion=5&cadObj='+cadObj,true);
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('¿Est&aacute; seguro de querer remover la etiqueta seleccionada?',resp);
                                                                                            return;
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

function mostrarVentanaAgregarEtiqueta(nodo)
{
	var registro=null;
	var oConf=	{
    					idCombo:'cmbEtiqueta',
                        anchoCombo:650,
                        raiz:'registros',
                        campoDesplegar:'etiqueta',
                        campoID:'idEtiqueta',
                        funcionBusqueda:4,
                        renderTo:'spComboEtiqueta',
                        ctCls:'campoComboWrapSIUGJAutocompletar',
                        listClass:'listComboSIUGJ',
                        paginaProcesamiento:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloRelatoria.php',
                        confVista:'<tpl for="."><div class="search-item">{etiqueta}<br></div></tpl>',
                        campos:	[
                                   	{name:'idEtiqueta'},
                                    {name:'etiqueta'}

                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	registro=null;
                                    	var aValor=combo.getRawValue();
										dSet.baseParams.criterio=aValor;
                                         
                                                                              
                                        
                                    },
                      	funcElementoSel:function(combo,registroSel)
                                        {
                                            registro=registroSel;
                                            
                                        }
    				};

	

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
                                            cls:'panelSiugj',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Etiqueta:'
                                                        },
                                                        {
                                                        	x:120,
                                                            y:15,
                                                            html:'<div id="spComboEtiqueta" style="width:660px"></div>'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar etiqueta',
										width: 850,
										height:180,
										layout: 'fit',
										plain:true,
										modal:true,
                                        closable:false,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	var cmbEtiqueta=crearComboExtAutocompletar(oConf);
                                                                    cmbEtiqueta.focus(false,500);
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
																		if(!registro)
                                                                        {
                                                                        	msgBox('Debe ingresar un criterio de b&uacute;squeda (m&iacute;nimo 3 caracteres)');
                                                                        	return;
                                                                        }	
                                                                        
                                                                        
                                                                        var pos=obtenerPosFila(gEx('gEtiquetas').getStore(),'idEtiqueta',registro.data.idEtiqueta);
                                                                        if(pos!=-1)
                                                                        {
                                                                        	msgBox('La etiqueta ya ha sido asociada anteriormente');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var arrID=nodo.id.split('_');
                                                                        
                                                                        var cadObj='{"idFormulario":"'+gE('idFormulario').value+'","idReferencia":"'+gE('idRegistro').value+'","idSeccion":"'+arrID[1]+'","idArchivo":"'+gE('idDocumento').value+'","idEtiqueta":"'+registro.data.idEtiqueta+'","lblEtiqueta":"'+cv(registro.data.etiqueta)+'"}';
                                                                       function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('arbolSecciones').getRootNode().reload();
                                                                                gEx('gEtiquetas').getStore().reload();
                                                                                if((window.parent)&&(window.parent.recargarMenuDTD))
                                                                                {
                                                                                    window.parent.recargarMenuDTD();
                                                                                }
                                                                                
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloRelatoria.php',funcAjax, 'POST','funcion=6&cadObj='+cadObj,true);
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
}


function mostrarVentanaCampoFecha(nodo)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:40,
                                                            y:20,
                                                            html:'<div id="spFechaSeccion" style="width:360px"></div>'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Secci&oacute;n: '+nodo.text,
										width: 450,
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
                                                                    	new Ext.form.DateField (
                                                                                                    {
                                                                                                       
                                                                                                        width:350,
                                                                                                        xtype:'datefield',
                                                                                                        disabled:(gE('sL').value=='1'),
                                                                                                        renderTo:'spFechaSeccion',
                                                                                                        ctCls:'campoFechaSIUGJ',
                                                                                                        value:(nodo.attributes.valorSeccion!=''?bD(nodo.attributes.valorSeccion):''),
                                                                                                        id:'txtCampoAbierto'
                                                                                                    }
                                                                                                 )
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
                                                            hidden:gE('sL').value=='1',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
																		var txtCampoAbierto=gEx('txtCampoAbierto');
                                                                        
                                                                        if(txtCampoAbierto.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtCampoAbierto.focus();
                                                                            }
                                                                            msgBox('Debe indicar el valor de la secci&oacute;n <b>'+nodo.text+'</b>');
                                                                            return;
                                                                        }
                                                                        var arrID=nodo.id.split('_');
                                                                        
                                                                        var cadObj='{"idFormulario":"'+gE('idFormulario').value+'","idReferencia":"'+gE('idRegistro').value+
                                                                        			'","idSeccion":"'+arrID[1]+'","valorSeccion":"'+cv(txtCampoAbierto.getValue().format('Y-m-d'))+'"}';
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('arbolSecciones').getRootNode().reload();
                                                                                
                                                                                if((window.parent)&&(window.parent.recargarMenuDTD))
                                                                                {
                                                                                    window.parent.recargarMenuDTD();
                                                                                }
                                                                                
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloRelatoria.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true);
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
}

