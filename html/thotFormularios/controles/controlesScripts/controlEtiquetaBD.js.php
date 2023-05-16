<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
var listUsuarioEtBD;
var listAppEtBD;


function crearVentanaEtiquetaBD()
{
	listUsuarioEtBD=new Array();
	listAppEtBD=new Array();
    var arrCampos=[];
	var arrTipoConexion=[['11','Almac\xE9n de datos'],['7','Consulta auxiliar']];
	var cmbTipoConexion=crearComboExt('cmbTipoConexion',arrTipoConexion,110,30);
    cmbTipoConexion.on('select',function(cmb,registro)
    							{
                                	
                                	var arrAlmacenes;
                                	if(registro.get('id')=='7')
                                    {
                                    	arrAlmacenes=obtenerAlmacenesDatosDisponibles(2);
                                    }
                                    else
                                    {
                                    	arrAlmacenes=obtenerAlmacenesDatosDisponibles(1);
                                    }
                                    gEx('cmbAlmacen').getStore().loadData(arrAlmacenes);
                                }
    )
    
    var cmbAlmacen=crearComboExt('cmbAlmacen',[],110,55,260);
    cmbAlmacen.on('select',function(cmb,registro)
    						{
                            	var id=registro.get('id');
                                arrCampos=obtenerCamposDisponibles(id,true);
                                
                                
                            }
    			)
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                        	xtype:'label',
                                                            html:'ID Control:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            id:'txtNombreCampo',
                                                            x:110,
                                                            y:5,
                                                            width:160,
                                                            hideLabel:true,
                                                            maskRe:/^[a-zA-Z0-9]$/
                                                            
                                                        }
                                                        ,
														{
                                                        	x:10,
                                                            y:35,
                                                        	xtype:'label',
                                                            html:'Conectar con:'
                                                        },
                                                        cmbTipoConexion,
                                                        {
                                                        	x:10,
                                                            y:60,
                                                        	xtype:'label',
                                                            html:'Origen de datos:'
                                                        },
                                                        cmbAlmacen,
                                                        {
                                                            xtype:'label',
                                                            x:5,
                                                            y:90,
                                                            html:'Configure el texto a mostrar como etiqueta:'
                                                        }
                                                        ,
                                                        {
                                                            xtype:'panel',
                                                            x:20,
                                                            y:120,
                                                            height:100,
                                                            width:400,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                        {
                                                                            xtype:'button',
                                                                            icon:'../images/add.png',
                                                                            tooltip:'Agregar campo',
                                                                            handler:function()
                                                                                    {
                                                                                        mostrarVentanaSelCampoComboEt(arrCampos);
                                                                                    }
                                                                        }
                                                                    ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:45,
                                                            y:120,
                                                            height:100,
                                                            width:400,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                        {
                                                                            xtype:'button',
                                                                            icon:'../images/font_add.png',
                                                                            tooltip:'Agregar frase',
                                                                            handler:function()
                                                                                    {
                                                                                        mostrarVentanaFraseEt();
                                                                                    }
                                                                        }
                                                                    ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:70,
                                                            y:120,
                                                            height:100,
                                                            width:400,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                        {
                                                                            xtype:'button',
                                                                            icon:'../images/espacio.png',
                                                                            tooltip:'Agregar espacio en blanco',
                                                                            handler:function()
                                                                                    {
                                                                                        listUsuarioEtBD.push('\' \'');
                                                                                        listAppEtBD.push('\' \'');
                                                                                        actualizarVistaOpcionEt();
                                                                                    }
                                                                        }
                                                                    ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:95,
                                                            y:120,
                                                            height:100,
                                                            width:400,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                        {
                                                                            xtype:'button',
                                                                            icon:'../images/delete.png',
                                                                            tooltip:'Remover elemento',
                                                                            handler:function()
                                                                                    {
                                                                                        listUsuarioEtBD.pop();
                                                                                        listAppEtBD.pop();
                                                                                        actualizarVistaOpcionEt();
                                                                                    }
                                                                                    
                                                                        }
                                                                    ]
                                                        },
                                                        
                                                        {
                                                        
                                                            id:'txtVistaElemento',
                                                            xtype:'textarea',
                                                            x:20,
                                                            y:150,
                                                            width:500,
                                                            height:50,
                                                            readOnly:true
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Crear etiqueta con conexi&oacute;n a almac&eacute;n',
										width: 580,
										height:300,
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
                                                                	gEx('txtNombreCampo').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var nomColumn='';
                                                                        for(x=0;x<listAppEtBD.length;x++)
                                                                        {
                                                                        	if(nomColumn=='')
                                                                        		nomColumn=listAppEtBD[x];
                                                                            else
                                                                            	nomColumn+='@@'+listAppEtBD[x];
                                                                        }
                                                                        
                                                                    	var txtIdControl=gEx('txtNombreCampo');
                                                                    	if(txtIdControl.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtIdControl.focus();
                                                                            }
                                                                            msgBox('Debe indicar el ID del control a insertar',resp1);
                                                                            return;
                                                                        }
																		if(cmbTipoConexion.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbTipoConexion.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de conexi&oacute;n a utilizar',resp);
                                                                            return;
                                                                        }
                                                                        if(cmbAlmacen.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbAlmacen.focus();
                                                                            }
                                                                            msgBox('Debe indicar el almac&eacute;n/consulta auxiliar a utilizar',resp2);
                                                                            return;
                                                                        }
                                                                        if(gEx('txtVistaElemento').getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	cmbCampo.focus();
                                                                            }
                                                                            msgBox('Al menos debe seleccionar un campo para proyectar como texto de la etiqueta',resp3);
                                                                            return;
                                                                        }

                                                                        var campo=nomColumn;
                                                                        var objFinal='{"campoEtUsuario":"'+cv(gEx('txtVistaElemento').getValue())+'","tipoElemento":"30","idFormulario":"'+idFormulario+'","nomCampo":"'+txtIdControl.getValue()+'","almacen":"'+cmbAlmacen.getValue()+'","campo":"'+cv(campo)+'","pregunta":"","obligatorio":"0","posX":"@posX","posY":"@posY"}';
                                                                        h.objControl=objFinal;
                                                                        ventanaAM.close();
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

function actualizarVistaOpcionEt()
{
	var x;
    var cadena='';
    for(x=0;x<listUsuarioEtBD.length;x++)
    {
    	cadena+=listUsuarioEtBD[x];	
    }
    gEx('txtVistaElemento').setValue(cadena);
}

function mostrarVentanaFraseEt()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														{
                                                        	xtype:'label',
                                                            html:'Frase:',
                                                            x:10,
                                                            y:10
                                                        },
                                                        {
                                                        	id:'txtFrase',
                                                            x:70,
                                                            y:5,
                                                            width:280
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar frase',
										width: 400,
										height:130,
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
                                                                	gEx('txtFrase').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var frase=Ext.getCmp('txtFrase').getValue();
                                                                        if(frase=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	Ext.getCmp('txtFrase').focus();
                                                                            }
                                                                        	msgBox('Debe ingresar la frase a insertar',resp);
                                                                        }
                                                                        listUsuarioEtBD.push(frase);
                                                                        listAppEtBD.push("'"+frase+"'");
                                                                        actualizarVistaOpcionEt();
                                                                        ventanaAM.close();
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

function mostrarVentanaSelCampoComboEt(arrCampo)
{

	var alOpciones=		new Ext.data.SimpleStore(
                                                    {
                                                        fields:	[
                                                                 	{name:'campoMysql'},
                                                                    {name:'campoUsr'}
                                                                ]
                                                    }
                                                );
    alOpciones.loadData(arrCampo);
   
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        
                                                        {
                                                            header:'Campo',
                                                            width:400,
                                                            dataIndex:'campoUsr'
                                                        }
                                                       
                                                    ]
                                                );
    
    var tblOpciones=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridTabla',
                                                            store:alOpciones,
                                                            frame:true,
                                                            cm: cmFrmDTD,
                                                            height:220,
                                                            width:490,
                                                            title:'Seleccione el campo a insertar'
                                                        }
                                                    );
  
    panelGrid=new Ext.Panel	(
                                {
                                    y:10,
                                    x:10,
                                    items:	[
                                                tblOpciones
                                            ]
                                }
                            );

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														panelGrid
													]
										}
									);

	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar campo',
										width: 530,
										height:330,
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
																		var fila=tblOpciones.getSelectionModel().getSelected();
                                                                        var campo=fila.get('campoUsr');
                                                                        var campoMysql=fila.get('campoMysql');
																		listUsuarioEtBD.push(campo);
                                                                        listAppEtBD.push(campoMysql);
                                                                        actualizarVistaOpcionEt();
                                                                        ventanaAM.close();
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