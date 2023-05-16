<?php session_start();
include("conexionBD.php"); 
include("configurarIdiomaJS.php");

?>

function mostrarVentanaAccion()
{
	var arbolAcciones=crearArbolAcciones();

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            xtype:'label',
                                                        	html:'Acciones a realizar al seleccionar:'
                                                            
                                                        },
                                                        arbolAcciones

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Acciones del control',
										width: 730,
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
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	nodoArbolEventoSel=null;
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}

function crearArbolAcciones()
{
	var divSel=h.gE('div_'+h.idControlSel);
    var datosCtrl=divSel.getAttribute('controlInterno').split("_");
    var query='';
    if((datosCtrl[2]=='4')||(datosCtrl[2]=='16')||(datosCtrl[2]=='19'))
    {
    
    	var idAlmacen=h.gE('_'+datosCtrl[1]).getAttribute('idAlmacen');
		var pos=existeValorMatriz(h.arrQueriesResueltas,idAlmacen);
        if(pos!=-1)
        	query=h.arrQueriesResueltas[pos][1];
        
    }
	var cargadorArbol=new Ext.tree.TreeLoader(
												{
													baseParams:{
																	funcion:'108',
                                                                    idControl:h.idControlSel,
                                                                    qy:query
																},
													dataUrl:'../paginasFunciones/funcionesProyectos.php',
                                                    uiProviders:	{
                                                                        'col': Ext.ux.tree.ColumnNodeUI
                                                                    }
												}
											)	

    var raiz=new  Ext.tree.AsyncTreeNode	(
                                                  {
                                                      id:'raizAcciones',
                                                      text:'Acciones',
                                                      draggable:false,
                                                      expanded :true
                                                  }
                                            )

	var panelArbol=new Ext.ux.tree.ColumnTree	(
                                                      {
                                                          id:'arbolAcciones',
                                                          title:' ',
                                                          useArrows:true,
                                                          autoScroll:true,
                                                          animate:false,
                                                          enableDD:true,
                                                          containerScroll:true,
                                                          height:290,
                                                          width:700,
                                                          root:raiz,
                                                          rootVisible:false,
                                                          loader: cargadorArbol,
                                                          columns:[
                                                                      {
                                                                          header:'Valor opci&oacute;n/Control',
                                                                          width:300,
                                                                          dataIndex:'text'
                                                                      },
                                                                       {
                                                                              header:'Tipo de control',
                                                                              width:140,
                                                                              dataIndex:'tipoControl'
                                                                      },
                                                                      {
                                                                      		header:'Acci&oacute;n',
                                                                            width:240,
                                                                            dataIndex:'accion'
                                                                      }
                                                                  ]
                                                      }
                                                  );                                                 	  
            
    panelArbol.expandAll();	
    panelArbol.on('click',funcClikArbol); 
    var panel=new Ext.Panel	(
        							{
                                    	id:'divPanel',
                                        x:10,
                                        baseCls: 'x-plain',
                                        y:45,
                                        items:	[
                                                    panelArbol
                                                ],
                                          tbar:	[
                                                  {
                                                      id:'btnAgregarOpcion',
                                                      tooltip:'Agregar opci&oacute;n de evento',
                                                      icon:'../images/add.png',
                                                      cls:'x-btn-text-icon',
                                                      handler:function()
                                                              {
                                                                  mostrarVentanaOpcionesEvento();
                                                              }
                                                  },
                                                  {
                                                      id:'btnAgregarCtrl',
                                                      tooltip:'Agregar acci&oacute;n sobre control',
                                                      icon:'../images/application_add.png',
                                                      cls:'x-btn-text-icon',
                                                      disabled:true,
                                                      handler:function()
                                                              {
                                                                  mostrarVentanaControlesAccion();
                                                              }
                                                  }
                                                  ,'-',
                                                  {
                                                      id:'btnRemoverOpcionesControl',
                                                      tooltip:'Remover Opci&oacute;n/Control',
                                                      icon:'../images/delete.png',
                                                      cls:'x-btn-text-icon',
                                                      handler:function()
                                                              {
                                                                  function respDel(btn)
                                                                  {
                                                                  	if(btn=='yes')
                                                                    {
                                                                    	var idElemento;
                                                                        if(nodoArbolEventoSel.attributes.tipo=='0')
                                                                        	idElemento=nodoArbolEventoSel.id;
                                                                        else
                                                                       		idElemento=nodoArbolEventoSel.attributes.idControl;
                                                                        
                                                                    	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	nodoArbolEventoSel.remove();
                                                                            	nodoArbolEventoSel=null;
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=114&tipo='+nodoArbolEventoSel.attributes.tipo+'&idElemento='+idElemento+'&idControl='+h.idControlSel,true);
                                                                    }
                                                                  }
                                                                  msgConfirm('Est&aacute; seguro de querer eliminar el elemento seleccionado?',respDel)
                                                                  
                                                                  
                                                              }
                                                  },
                                                  '-',
                                                  {
                                                      id:'btnCambiarAccion',
                                                      tooltip:'Modificar acci&oacute;n',
                                                      icon:'../images/pencil.png',
                                                      cls:'x-btn-text-icon',
                                                      disabled:true,
                                                      handler:function()
                                                              {
                                                                  mostrarVentanaModificarAccion();
                                                              }
                                                  }
                                                 
                                              ]
                                      }
                              )
    
    
       
    return panel;
}

var nodoArbolEventoSel=null;

function funcClikArbol(nodo)
{
	nodoArbolEventoSel=nodo;
	if(nodo.attributes.tipo==0)
    {
    	Ext.getCmp('btnAgregarCtrl').enable();
        Ext.getCmp('btnCambiarAccion').disable();
    }
    else
    {
   		Ext.getCmp('btnAgregarCtrl').disable(); 
        Ext.getCmp('btnCambiarAccion').enable();
    }
}

function mostrarVentanaOpcionesEvento()
{
	var gridOpcionesCtrl=crearGridOpcionesControl();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	html:'Seleccione las opci&oacute;nes del control,que desea considerar para sus acciones de evento:',
                                                            x:10,
                                                            y:10
                                                        },
                                                        gridOpcionesCtrl

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Opciones del control',
										width: 360,
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
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var filas=gridOpcionesCtrl.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Al menos debe seleccionar una elemento');
                                                                            return;
                                                                        }
                                                                        var listaValores='';
                                                                        var x;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	if(listaValores=='')
                                                                            	listaValores=filas[x].get('idOpcion');
                                                                            else
                                                                            	listaValores+=','+filas[x].get('idOpcion');
                                                                        }
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            var arbol=Ext.getCmp('arbolAcciones');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	arbol.getRootNode().reload();
                                                                                arbol.expandAll();
                                                                            	ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=110&lOpciones='+listaValores+'&idControl='+h.idControlSel,true);
                                                                        
                                                                        
                                                                        
                                                                        
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
	
    llenarOpcionesControl(ventanaAM);
}

function crearGridOpcionesControl()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idOpcion'},
                                                                {name: 'opcion'}
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
															header:'Opci&oacute;n',
															width:240,
															sortable:true,
															dataIndex:'opcion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridOpcionesCtrl',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:310,
                                                            width:335,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
}

function llenarOpcionesControl(ventana)
{
	var divSel=h.gE('div_'+h.idControlSel);
    var datosCtrl=divSel.getAttribute('controlInterno').split("_");
    var qy='';
    if((datosCtrl[2]=='4')||(datosCtrl[2]=='16')||(datosCtrl[2]=='19'))
    {
    
    	var idAlmacen=h.gE('_'+datosCtrl[1]).getAttribute('idAlmacen');
		var pos=existeValorMatriz(h.arrQueriesResueltas,idAlmacen);
    	if(pos!=-1)
        {
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    Ext.getCmp('gridOpcionesCtrl').getStore().loadData(eval(arrResp[1]));
                    ventana.show();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=109&qy='+h.arrQueriesResueltas[pos][1]+'&idControl='+h.idControlSel,true);
    	}
        else
        	ventana.show();
    	
   	}
    else
    {
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                Ext.getCmp('gridOpcionesCtrl').getStore().loadData(eval(arrResp[1]));
                ventana.show();
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=109&idControl='+h.idControlSel,true);
	}
}

function mostrarVentanaControlesAccion()
{
	var gridOpcionesCtrl=crearGridControlesAccion();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	html:'Seleccione los controles,que desea considerar para sus acciones:',
                                                            x:10,
                                                            y:10
                                                        },
                                                        gridOpcionesCtrl
                                                        ,
                                                        {
                                                        	x:10,
                                                            y:290,
                                                            xtype:'fieldset',
                                                            title:'Opciones de visibilidad',
                                                            width:510,
                                                            height:65,
                                                        	items:[
                                                                        {
                                                                        	id:'rdoVisibilidad',
                                                                            xtype:'radiogroup',
                                                                            hideLabel:true,
                                                                            items:	[
                                                                                        {boxLabel: 'Ocultar control', name: 'accionOcultar', inputValue: 'O'},
                                                                                        {boxLabel: 'Mostrar control', name: 'accionOcultar', inputValue: 'M'},
                                                                                        {boxLabel: 'Ninguno', name: 'accionOcultar', inputValue: '',  checked: true}
                                                                                    ]
                                                                        }
                                                                  ]
                                                         }
                                                        ,
                                                        {
															x:10,
                                                            y:360,
                                                            xtype:'fieldset',
                                                            title:'Opciones de edici&oacute;n',
                                                            width:510,
                                                            height:65,
                                                        	items:[
                                                                        {
                                                                        	id:'rdoEdicion',
                                                                            xtype:'radiogroup',
                                                                            hideLabel:true,
                                                                            items:	[
                                                                                        {boxLabel: 'Habilitar control', name: 'accionEdicion', inputValue: 'H'},
                                                                                        {boxLabel: 'Deshabilitar control', name: 'accionEdicion', inputValue: 'D'},
                                                                                        {boxLabel: 'Ninguno', name: 'accionEdicion', inputValue: '',  checked: true}
                                                                                    ]
                                                                        }
                                                                  ]
                                                         }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de controles de acci&oacute;n',
										width: 550,
										height:510,
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
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var filas=gridOpcionesCtrl.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Al menos debe seleccionar una elemento');
                                                                            return;
                                                                        }
                                                                        var listaValores='';
                                                                        var x;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	if(listaValores=='')
                                                                            	listaValores=filas[x].get('idControl');
                                                                            else
                                                                            	listaValores+=','+filas[x].get('idControl');
                                                                        }
                                                                        
                                                                        var opcionV=Ext.getCmp('rdoVisibilidad').getValue().getRawValue();
                                                                        var opcionE=Ext.getCmp('rdoEdicion').getValue().getRawValue();
                                                                        var listaAccion=opcionV+opcionE;
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            var arbol=Ext.getCmp('arbolAcciones');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	arbol.getRootNode().reload();
                                                                                arbol.expandAll();
                                                                            	ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=112&lControles='+listaValores+'&listaAccion='+listaAccion+'&idControl='+h.idControlSel+'&valorOpt='+nodoArbolEventoSel.id,true);
                                                                        
                                                                        
                                                                        
                                                                        
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
	
    llenarControlesAccion(ventanaAM);
}

function crearGridControlesAccion()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idControl'},
                                                                {name: 'control'},
                                                                {name: 'tipoElemento'}
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
															header:'Control',
															width:240,
															sortable:true,
															dataIndex:'control'
														},
                                                        {
                                                        	header:'Tipo',
															width:190,
															sortable:true,
															dataIndex:'tipoElemento'
                                                        }
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridCtrlAccion',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:230,
                                                            width:520,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
}

function llenarControlesAccion(ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	Ext.getCmp('gridCtrlAccion').getStore().loadData(eval(arrResp[1]));
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=111&idControl='+h.idControlSel+'&valorOpt='+nodoArbolEventoSel.id+'&idFormulario='+idFormulario,true);
}

function mostrarVentanaModificarAccion()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            xtype:'fieldset',

                                                            title:'Opciones de visibilidad',
                                                            width:450,
                                                            height:65,
                                                        	items:[
                                                                        {
                                                                        	id:'rdoVisibilidad',
                                                                            xtype:'radiogroup',
                                                                            hideLabel:true,
                                                                            items:	[
                                                                                        {boxLabel: 'Ocultar control', name: 'accionOcultar', id:'rdoOcultar', inputValue: 'O'},
                                                                                        {boxLabel: 'Mostrar control', name: 'accionOcultar', id:'rdoMostrar',inputValue: 'M'},
                                                                                        {boxLabel: 'Ninguno', name: 'accionOcultar',id:'rdoNinguno', inputValue: ''}
                                                                                    ]
                                                                        }
                                                                  ]
                                                         }
                                                        ,
                                                        {
															x:10,
                                                            y:90,
                                                            xtype:'fieldset',
                                                            title:'Opciones de edici&oacute;n',
                                                            width:450,
                                                            height:65,
                                                        	items:[
                                                                        {
                                                                        	id:'rdoEdicion',
                                                                            xtype:'radiogroup',
                                                                            hideLabel:true,
                                                                            items:	[
                                                                                        {boxLabel: 'Habilitar control', name: 'accionEdicion',id:'rdoHabilitar', inputValue: 'H'},
                                                                                        {boxLabel: 'Deshabilitar control', name: 'accionEdicion',id:'rdoDeshabilitar', inputValue: 'D'},
                                                                                        {boxLabel: 'Ninguno', name: 'accionEdicion', id:'rdoNingunoE',inputValue: ''}
                                                                                    ]
                                                                        }
                                                                  ]
                                                         }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar acci&oacute;n',
										width: 500,
										height:260,
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
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var opcionV=Ext.getCmp('rdoVisibilidad').getValue().getRawValue();
                                                                        var opcionE=Ext.getCmp('rdoEdicion').getValue().getRawValue();
                                                                        var listaAccion=opcionV+opcionE;
                                                                        var arbol=Ext.getCmp('arbolAcciones');
                                                                        
																		function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	arbol.getRootNode().reload();
                                                                                arbol.expandAll();
                                                                            	ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=113&idAccion='+nodoArbolEventoSel.attributes.idControl+'&listaAccion='+listaAccion,true);	
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
    var codAccion=nodoArbolEventoSel.attributes.codAccion;
    var rdoOcultar=false;
    var rdoMostrar=false;
    var rdoNinguno=false;
    ventanaAM.show();
    
   
    if(codAccion.indexOf('O')!=-1)
    {
    	rdoOcultar=true;
        Ext.getCmp('rdoOcultar').setValue(true);
        
    }
    if(codAccion.indexOf('M')!=-1)
    {
    	rdoMostrar=true;
        Ext.getCmp('rdoMostrar').setValue(true);
    }
    if(!rdoOcultar&&!rdoMostrar)
    {
    	rdoNinguno=true;
        Ext.getCmp('rdoNinguno').setValue(true);
    }
    
    
    var rdoHabilitar=false;
    var rdoDesHabilitar=false;
    var rdoNingunoE=false;
    
    if(codAccion.indexOf('H')!=-1)
    {
    	rdoHabilitar=true;
        Ext.getCmp('rdoHabilitar').setValue(true);
    }
    if(codAccion.indexOf('D')!=-1)
    {
    	rdoDesHabilitar=true;
        Ext.getCmp('rdoDeshabilitar').setValue(true);
    }
    if(!rdoHabilitar&&!rdoDesHabilitar)
    {
    	rdoNingunoE=true;
        Ext.getCmp('rdoNingunoE').setValue(true);
    }
    
	
}





