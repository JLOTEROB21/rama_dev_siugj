<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$consulta="select valor, texto from 1004_siNo where idIdioma=".$_SESSION["leng"];
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	$consulta="select idBanco,nombreBanco from 6000_bancos order by nombreBanco";
	$arrBancos=uEJ($con->obtenerFilasArreglo($consulta));
	$idUsuario=bD($_GET["iU"]);
	$consulta="select idCuentaUsuario,cu.idBanco,nombreCorto,cuenta,clabe,usuarioTitular,titular,comentarios from 823_cuentasUsuario cu,6000_bancos b  
				where b.idBanco=cu.idBanco and cu.idUsuario=".$idUsuario;
	$arrCuentas=uEJ($con->obtenerFilasArreglo($consulta));
?>
Ext.onReady(inicializar);
var nuevoReg=false;
var regTabulacion=crearRegistro	(
									[
                                    	{name: 'idCuentaUsuario'},
                                        {name: 'idBanco'},
                                        {name: 'banco'},
                                        {name: 'cuenta'},
                                        {name: 'clabe'},
                                        {name: 'usuarioTitular'},
                                        {name: 'titular'},
                                        {name: 'comentarios'}
                                    ]
								)

function inicializar()
{
	var arrSiNo=<?php echo $arrSiNo?>;
	var cmbDepositoNomina=crearComboExt('cmbDepositoNomina',arrSiNo);
    cmbDepositoNomina.on('select',	function (combo,registro)
    								{
                                    	if(registro.get('id')=='1')
                                          {
												gEx('txtPorcentaje').setValue('0');
                                              	gEx('txtPorcentaje').setReadOnly(false);
                                          }
                                          else
                                          {
	                                          	gEx('txtPorcentaje').setValue('0');
                                              	gEx('txtPorcentaje').setReadOnly(true);
                                          }
                                    	
                                    }
    					)
    
    var cmbUsuarioTitular=crearComboExt('cmbUsuarioTitular',arrSiNo);
    cmbUsuarioTitular.on('select',function(combo,registro)
    								{
                                      {
                                         	if(registro.get('id')=='1')
                                        	{
                                            	gEx('txtTitular').setValue(gE('nUsuario').value);
                                              	gEx('txtTitular').setReadOnly(true);
                                        	}
                                        	else
                                            	gEx('txtTitular').setReadOnly(false);
                                      }
                                    }
                         )
	var dsDatos=<?php echo $arrCuentas?>;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                        			{name: 'idCuentaUsuario'},
                                                        			{name: 'idBanco'},
                                                                    {name: 'banco'},
                                                                    {name: 'cuenta'},
                                                                    {name: 'clabe'},
                                                                    {name: 'usuarioTitular'},
                                                                    {name: 'titular'},
                                                                    {name: 'comentarios'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	var editorFila=new Ext.ux.grid.RowEditor	(
    												{
                                                        saveText: 'Guardar',
                                                        cancelText:'Cancelar',
                                                        clicksToEdit:2
                                                    }
                                                );

	editorFila.on('beforeedit',funcEditorFilaBeforeEdit)
    editorFila.on('validateedit',funcEditorValida);
    editorFila.on('canceledit',funcEditorCancelEdit);         
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Banco',
															width:150,
															sortable:true,
															dataIndex:'banco',
                                                            enableKeyEvents:true, 
                                                            editor:new Ext.form.TextField	(
                                                            									{
                                                            										id:'txtBanco',
                                                                                                    readOnly:true,
                                                                                                    listeners:	{
                                                                                                    				focus:funcCeldaSelect
                                                                                                    			}
                                                                                                }
                                                            								)
														},
														{
															header:'Cuenta',
															width:140,
															sortable:true,
															dataIndex:'cuenta',
                                                            editor:new Ext.form.TextField	(
                                                            									{
                                                            										id:'txtCuenta'
                                                                                                }
                                                            								)
														},
                                                        
                                                        {
															header:'Clabe',
															width:140,
															sortable:true,
															dataIndex:'clabe',
                                                            editor:new Ext.form.TextField	(
                                                            									{
                                                            										id:'txtClabe'
                                                                                                }
                                                            								)
														},
                                                        {
                                                        	header:'Usuario titular',
															width:100,
															sortable:true,
															dataIndex:'usuarioTitular',
                                                            editor:cmbUsuarioTitular,
                                                            renderer: 	function(val)
                                                            			{
                                                                        	var pos=existeValorMatriz(arrSiNo,val,0);
                                                                            return arrSiNo[pos][1];
                                                                        }
                                                        },
                                                        {
															header:'Titular',
															width:220,
															sortable:true,
															dataIndex:'titular',
                                                            editor:new Ext.form.TextField	(
                                                            									{
                                                            										id:'txtTitular'
                                                                                                }
                                                            								)
														},
                                                        
                                                        {
                                                        	header:'Comentarios',
															width:300,
															sortable:true,
															dataIndex:'comentarios',
                                                            editor:new Ext.form.TextField	(
                                                            									{
                                                            										id:'txtComentarios'
                                                                                                }
                                                            								)
                                                        }
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridCuentas',
                                                            renderTo:'tblGridCuentas',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:850,
                                                            sm:chkRow,
                                                            plugins:[editorFila],
                                                            tbar:	[
                                                            			{
                                                                        	id:'btnAgregarTab',
                                                                        	text:'Agregar cuenta bancaria',
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var r=new regTabulacion	(
                                                                                       								{
                                                                                                                     	idCuentaUsuario:'-1',
                                                                                                                        idBanco:'',
                                                                                                                        banco:'',
                                                                                                                        cuenta:'',
                                                                                                                        clabe:'',
                                                                                                                        usuarioTitular:'1',
                                                                                                                        titular:gE('nUsuario').value,
                                                                                                                        comentarios:''  
                                                                                                                	}
                                                                                                            	);
                                                                                        editorFila.stopEditing();
                                                                                    	tblGrid.getStore().add(r);
                                                                                        nuevoReg=true;
                                                                                        editorFila.startEditing(tblGrid.getStore().getCount()-1);
                                                                                    }
                                                                        },
                                                                        {
                                                                        	id:'btnEliminarTab',
                                                                        	text:'Remover cuenta bancaria',
                                                                            icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la cuenta a  eliminar');
                                                                                            return;
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	var listado=obtenerListadoArregloFilas(filas,'idCuentaUsuario');
                                                                                                
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
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=56&listCuentas='+listado,true);

                                                                                                
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer eliminar las cuentas seleccionadas?',resp);
                                                                                    	
                                                                            		}
                                                                       }
                                                            		]
                                                            		
                                                        }
                                                    );
}

function funcCeldaSelect(texto)
{
	mostrarVentanaBancos();
}

function funcGridBeforeEdit(e)
{
	/*if((!pEdicion)||(e.record.get('situacion')!=etapaActual))
		e.cancel=true;*/
}

function funcEditorValida(rowEditor,obj,registro,nFila)
{	
	var idUsuario=gE('idUsuario').value;
	if(obj.banco=='')
    {
    	function resp()
        {
        	Ext.getCmp('txtBanco').focus();
        }
    	msgBox('Debe indicar el banco al cual pertenece la cuenta',resp);
        return false;
    }
    
    if(obj.cuenta=='')
    {
    	function respP()
        {
        	Ext.getCmp('txtCuenta').focus();
        }
    	msgBox('Debe ingresar la cuenta bancaria',respP);
        return false;
    }
	
    if(obj.titular=='')
    {
    	function respOG()
        {
        	Ext.getCmp('txtTitular').focus(true);
        }
    	msgBox('Debe ingresar el titular de la cuenta',respOG);
        return false;
    }
    
    var idBanco=gEx('txtBanco').valorOculto;
	var cadObj='{"idUsuario":"'+idUsuario+'","idCuentaUsuario":"'+registro.get('idCuentaUsuario')+'","idBanco":"'+idBanco+'","cuenta":"'+cv(obj.cuenta)+'","clabe":"'+obj.clabe+'","usuarioTitular":"'+obj.usuarioTitular+'","titular":"'+cv(obj.titular)+'","comentarios":"'+cv(obj.comentarios)+'"}';
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            registro.set('idCuentaUsuario',arrResp[1]);
            registro.set('idBanco',idBanco);
            Ext.getCmp('btnAgregarTab').enable();
            Ext.getCmp('btnEliminarTab').enable();
            nuevoReg=false;
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            Ext.getCmp('btnAgregarTab').enable();
            Ext.getCmp('btnEliminarTab').enable();
            if(registro.get('idCuentaUsuario')=='-1')
                Ext.getCmp('gridCuentas').getStore().removeAt(Ext.getCmp('gridTab').getStore().getCount()-1);
            else
                Ext.getCmp('gridCuentas').getStore().rejectChanges();
            nuevoReg=false;
            return false;
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=55&obj='+cadObj,true);
            
        
}

function funcEditorCancelEdit(rowEdit,obj,registro,nFila)
{
	
	if(nuevoReg)
    {
    	var gridPOA=Ext.getCmp('gridCuentas');
        gridPOA.getStore().removeAt(gridPOA.getStore().getCount()-1);
    }
   	Ext.getCmp('btnAgregarTab').enable();
    Ext.getCmp('btnEliminarTab').enable();

    nuevoReg=false;
}

function funcEditorFilaBeforeEdit(ctrl,fila)
{
	var registro=Ext.getCmp('gridCuentas').getStore().getAt(fila);
	if(registro.get('usuarioTitular')=='1')
    	gEx('txtTitular').setReadOnly(true);
    else
    	gEx('txtTitular').setReadOnly(false);
	
	Ext.getCmp('btnAgregarTab').disable();
    Ext.getCmp('btnEliminarTab').disable();
    gEx('txtBanco').valorOculto=registro.get('idBanco');
}

function mostrarVentanaBancos()
{
	var gridBancos=crearGridBancos();
    
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridBancos														
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Cat&aacute;logo de bancos',
										width: 400,
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
																		bancoSeleccionado(ventanaAM);
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
    gridBancos.on('dblclick',function()
    				{
                    	bancoSeleccionado(ventanaAM);
                    }
    );
    
}

function crearGridBancos()
{
	var dsDatos=<?php echo $arrBancos?>;
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idBanco'},
                                                                {name: 'banco'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														
														{
															header:'Banco',
															width:280,
															sortable:true,
															dataIndex:'banco'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                        	x:10,
                                                            id:'gridBancos',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:330,
                                                            width:350
                                                            
                                                        }
                                                    );
	return 	tblGrid;	
}

function bancoSeleccionado(ventanaAM)
{
	var gridBancos=gEx('gridBancos');
	var fila=gridBancos.getSelectionModel().getSelected();
    if(fila==null)
    {
        msgBox('Primero debe seleccionar el banco a asignar');
        return;
    }
    var ctrl=gEx('txtBanco');
    ctrl.setValue(fila.get('banco'));
    ctrl.valorOculto=fila.get('idBanco');
    gEx('txtCuenta').focus();
    ventanaAM.close();
}