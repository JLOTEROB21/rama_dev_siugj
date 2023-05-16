<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

function configurarCampos()
{
	var gridCampos=crearGridCampos();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Indique los campos a mostrar en el FUMP:'
                                                        },
                                                        gridCampos

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Campos mostrados en el FUMP',
										width: 380,
										height:380,
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
																		recargarPagina();
																	}
														}
														
													]
									}
								);
	
	cargarCamposGrid(gridCampos.getStore(),ventanaAM,1);
}

function crearGridCampos()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idCampo'},
                                                                {name: 'campo'}
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
															header:'Campo',
															width:200,
															sortable:true,
															dataIndex:'campo'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridcamposProy',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:230,
                                                            width:350,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar Campo',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarCampos();
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover Campo',
                                                                            handler:function()
                                                                            		{
                                                                                    	
                                                                                        	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                          if(filas.length==0)	
                                                                                          {
                                                                                              msgBox('Debe seleccionar al menos un campo a remover');
                                                                                              return;
                                                                                          }
                                                                                          
                                                                                          var listado=obtenerListadoArregloFilas(filas,'idCampo');
                                                                                          function funcAjax()
                                                                                          {
                                                                                              var resp=peticion_http.responseText;
                                                                                              arrResp=resp.split('|');
                                                                                              if(arrResp[0]=='1')
                                                                                              {
                                                                                                  tblGrid.getStore().remove(filas);
                                                                                              }
                                                                                              else
                                                                                              {
                                                                                                  msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                              }
                                                                                          }
                                                                                          obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=36&lista='+listado,true);
                    
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}

function cargarCamposGrid(almacen,ventana,tipo)
{
	
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]); 
            almacen.loadData(arrDatos);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=34&tipo='+tipo,true);

}


function mostrarVentanaAgregarCampos()
{
	var gridCampos=crearGridCamposAgregar();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Indique los campos a mostrar en el FUMP:'
                                                        },
                                                        gridCampos

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vAgregar',
										title: 'Agregar campos a mostrar en FUMP',
										width: 360,
										height:340,
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
																		var filas=gridCampos.getSelectionModel().getSelections();
                                                                          if(filas.length==0)	
                                                                          {
                                                                              msgBox('Debe seleccionar al menos un campo a agregar');
                                                                              return;
                                                                          }
                                                                          
                                                                          var listado=obtenerListadoArregloFilas(filas,'idCampo');
                                                                          function funcAjax()
                                                                          {
                                                                              var resp=peticion_http.responseText;
                                                                              arrResp=resp.split('|');
                                                                              if(arrResp[0]=='1')
                                                                              {
                                                                                  gEx('gridcamposProy').getStore().loadData(eval(arrResp[1]));
                                                                                  ventanaAM.close();
                                                                              }
                                                                              else
                                                                              {
                                                                                  msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                              }
                                                                          }
                                                                          obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=35&lista='+listado,true);
	
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
	
	cargarCamposGrid(gridCampos.getStore(),ventanaAM,2);	
}


function crearGridCamposAgregar()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idCampo'},
                                                                {name: 'campo'}
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
															header:'Campo',
															width:200,
															sortable:true,
															dataIndex:'campo'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:200,
                                                            width:320,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;
}