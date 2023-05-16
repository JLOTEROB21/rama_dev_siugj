<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$idFormulario=bD($_GET["iF"]);
	$idReferencia=bD($_GET["iR"]);
	$consulta="select idTipoPresupuesto,tituloTipoP from 508_tiposPresupuesto order by tituloTipoP";
	$arrTipoPresupuesto=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select idPrograma,tituloPrograma,descripcion from 517_programas where estado=1  order by tituloPrograma";
	$arrProgramas=uEJ($con->obtenerFilasArreglo($consulta));
	
	$consulta="select idRegistroPOA,tipoPresupuesto,programa,objGasto,total,periodoAplicacion,capitulo from 9014_registroPOA r
				where idFormulario=".$idFormulario." and idReferencia=".$idReferencia;
	$arrReg=uEJ($con->obtenerFilasArreglo($consulta));				
	
?>
var arrProgramas=<?php echo $arrProgramas?>;
var arrMeses=[['Ene','Enero'],['Feb','Febrero'],['Mar','Marzo'],['Abr','Abril'],['May','Mayo'],['Jun','Junio'],['Jul','Julio'],['Ago','Agosto'],['Sep','Septiembre'],['Oct','Octubre'],['Nov','Noviembre'],['Dic','Diciembre']];
var arrTipoPresupuesto=<?php echo $arrTipoPresupuesto ?>;
var regPOA=Ext.data.Record.create	(
										[
                                        	{name:'idRegistro'},
                                            {name: 'presupuesto'},
                                            {name: 'programa'},
                                            {name: 'objGasto'},
                                            {name: 'costoTotal'},
                                            {name: 'periodoAplicacion'},
                                            {name: 'capitulo'}
                                            
										]
									)


Ext.onReady(inicializar);

function inicializar()
{
	crearGridPOA();
}

function crearGridPOA()
{
	
    var cmbTipoPresupuesto=crearComboExt('cmbTipoPresupuesto',arrTipoPresupuesto);
	var dsDatos=<?php echo $arrReg?>;
    var lector=new	Ext.data.ArrayReader	(
                                                    {
                                                        fields:	[
                                                        			{name: 'idRegistro'},
                                                                    {name: 'presupuesto'},
							                                        {name: 'programa'},
                                                                    {name: 'objGasto'},
                                                                    {name: 'costoTotal'},
                                                                    {name: 'periodoAplicacion'},
                                                                    {name: 'capitulo'}
                                                                    
                                                                ]
                                                    }
                                                );

    
	
    var editorFila=new Ext.ux.grid.RowEditor	(
    												{
                                                        saveText: 'Guardar',
                                                        cancelText:'Cancelar',
                                                        clicksToEdit:2
                                                    }
                                                );
	var gS=new Ext.data.GroupingStore(
    									{
                                            reader: lector,
                                            data: dsDatos,
                                            sortInfo: {field: 'idRegistro', direction: 'ASC'},
                                            groupField: 'capitulo'
                                        }
                                    )                                                
	var summary = new Ext.ux.grid.GroupSummary();
    editorFila.on('beforeedit',funcEditorFilaBeforeEdit)
    editorFila.on('validateedit',funcEditorValida);
    editorFila.on('canceledit',funcEditorCancelEdit);
    var chkRow=new Ext.grid.CheckboxSelectionModel();
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
                                                        chkRow,
                                                         {
															header:'Cap&iacute;tulo',
															width:120,
															sortable:true,
															dataIndex:'capitulo',
                                                            hidden:true
														},
                                                        {
															header:'Presupuesto',
															width:180,
															sortable:true,
															dataIndex:'presupuesto',
                                                            editor:cmbTipoPresupuesto,
                                                            renderer:function(val)
                                                            		{
                                                                    	var pos=existeValorMatriz(arrTipoPresupuesto,val);
                                                                        if(pos==-1)
                                                                        	return '';
                                                                        return arrTipoPresupuesto[pos][1];
                                                                    }
														},
                                                        {
															header:'Programa',
															width:150,
															sortable:true,
															dataIndex:'programa'
                                                            ,
                                                                    editor:new Ext.form.TextField	(
                                                                                                        {
                                                                                                            id:'txtPrograma',
                                                                                                            readOnly :true,
                                                                                                            enableKeyEvents:true,
                                                                                                            valorOculto:'',
                                                                                                            listeners:	{
                                                                                                                            focus:textFocus
                                                                                                                        }
                                                                                                        }
                                                                                                    )
                                                          
														},
														{
															header:'Obj. Gasto',
															width:150,
															sortable:true,
															dataIndex:'objGasto',
                                                            editor:new Ext.form.TextField	(
                                                            									{
                                                                                                	id:'txtObjetoGasto',
                                                                                                	readOnly :true,
                                                                                                    enableKeyEvents:true,
                                                                                                    listeners:	{
                                                                                                    				focus:textFocus
                                                                                                    			}
                                                                                                }
                                                            								)
														},
														
                                                        {
															header:'Monto total',
															width:100,
															sortable:true,
															dataIndex:'costoTotal',
                                                            renderer: 'usMoney',
                                                            summaryType: 'sum',
                                                            editor:new Ext.form.NumberField	(
                                                            									{
                                                                                                	id:'txtMontoTotal',
                                                                                                	allowDecimals:true
                                                                                                    
                                                                                                }
                                                            								)
														},
                                                        {
															header:'Periodo aplicaci&oacute;n',
															width:270,
															sortable:true,
															dataIndex:'periodoAplicacion',
                                                            editor:new Ext.form.TextField	(
                                                            									{
                                                                                                	id:'txtPeriodo',
                                                                                                	readOnly :true,
                                                                                                    enableKeyEvents:true,
                                                                                                    listeners:	{
                                                                                                    				focus:textFocus
                                                                                                    			}
                                                                                                }
                                                            								)
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridPOA',
                                                            renderTo:'tblPOA',
                                                            store:gS,
                                                            frame:true,
                                                            cm: cModelo,
                                                            height:460,
                                                            width:850,
                                                            sm:chkRow,
                                                            stripeRows: 'true',
                                                            

                                                            plugins: [editorFila],
                                                            tbar:	[
                                                            			{
                                                                        	id:'btnAgregar',
                                                                        	text:'Agregar Nuevo',
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            
                                                                            handler:function ()
                                                                            		{
                                                                                    	var r=new regPOA(
                                                                                        					{
                                                                                                            	idRegistro:'',
                                                                                                                presupuesto:'',
                                                                                                                programa:'',
                                                                                                                objGasto:'',
                                                                                                                producto:'',
                                                                                                                cantidad:'',
                                                                                                                costoPromedio:'',
                                                                                                                costoTotal:'',
                                                                                                                periodoAplicacion:'',
                                                                                                                capitulo:''
                                                                                                            }
                                                                                        				);
                                                                                        editorFila.stopEditing();
                                                                                    	tblGrid.getStore().add(r);
                                                                                        nuevoReg=true;
                                                                                        editorFila.startEditing(tblGrid.getStore().getCount()-1);
                                                                                        
                                                                                    }	
                                                                        },
                                                                        {
                                                                        	id:'btnRemover',
                                                                        	text:'Remover',
                                                                            icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            
                                                                            handler:function ()
                                                                            		{
                                                                                    	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                        if(filas==0)
                                                                                        {
                                                                                        	msgBox('Al menos debe seleccionar un registro a eliminar');
                                                                                            return;
                                                                                        }
                                                                                        
                                                                                        var listReg=obtenerListadoArregloFilas(filas,'idRegistro');
                                                                                        
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
                                                                                                        tblGrid.getStore().remove(filas);
                                                                                                      	if(typeof(funcAgregar)!='undefined')
																						                   	funcAgregar();
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=184&idRegistro='+listReg,true);
                                                                                            }
                                                                                            
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer eliminar los registros seleccionados?',resp); 
                                                                                    }	
                                                                        }
                                                            		]
                                                            
                                                        }
                                                    );
	tblGrid.on('beforeEdit',funcGridBeforeEdit);	                                            
}
function funcGridBeforeEdit(e)
{

	if((!pEdicion)||(e.record.get('situacion')!=etapaActual))
		e.cancel=true;
}


function funcEditorValida(rowEditor,obj,registro,nFila)
{	
     if(obj.presupuesto=='')
    {
    	function respP()
        {
        	Ext.getCmp('cmbTipoPresupuesto').focus();
        }
    	msgBox('Debe ingresar el tipo de presupuesto',respP);
        return false;
    }
    
    if(obj.objGasto=='')
    {
    	function respOG()
        {
        	Ext.getCmp('txtObjetoGasto').focus();
        }
    	msgBox('Debe ingresar el objeto de gasto',respOG);
        return false;
    }
    
    
	if(obj.costoTotal=='')
    {
    	function resp()
        {
        	Ext.getCmp('txtMontoTotal').focus();
        }
    	msgBox('Debe ingresar el monto total',resp);
        return false;
    }
    if(obj.periodoAplicacion=='')
    {
    	function respPeriodo()
        {
        	Ext.getCmp('txtPeriodo').focus();
        }
    	msgBox('Debe ingresar el periodo de aplicaci&oacute;n',respPeriodo);
        return false;
    }
	var idFormulario=gE('idFormulario').value;
    var idRegistro=gE('idRegistro').value;
    
    var obj='{"capitulo":"'+registro.get('capitulo')+'","idRegistroPOA":"'+registro.get('idRegistro')+'","presupuesto":"'+obj.presupuesto+'","programa":"'+obj.programa+'","objGasto":"'+obj.objGasto+'","costoTotal":"'+obj.costoTotal+'","periodoAplicacion":"'+obj.periodoAplicacion+'","idFormulario":"'+
            idFormulario+'","idRegistro":"'+idRegistro+'"}';
	
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	if(typeof(funcAgregar)!='undefined')
	           	funcAgregar();
        	registro.set('registro',arrResp[1]);
            Ext.getCmp('btnAgregar').enable();
		    Ext.getCmp('btnRemover').enable();
            nuevoReg=false;
            Ext.getCmp('gridPOA').getStore().save();
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            Ext.getCmp('btnAgregar').enable();
		    Ext.getCmp('btnRemover').enable();
            Ext.getCmp('gridPOA').getStore().rejectChanges();
            nuevoReg=false;
            return false;
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=183&obj='+obj,true);
     
}

function funcEditorFilaBeforeEdit(ctrl,fila)
{
	/*var tblGrid=Ext.getCmp('gridPOA');
    var registro=tblGrid.getStore().getAt(fila);
	if((!pEdicion)||(registro.get('situacion')!=etapaActual))
    {
        return false;
    }
	Ext.getCmp('btnAgregar').disable();
    Ext.getCmp('btnRemover').disable();
    var fila=Ext.getCmp('gridPOA').getStore().getAt(fila);
    Ext.getCmp('txtPrograma').valorOculto=fila.get('codPrograma');
    Ext.getCmp('txtCentroC').codCC=fila.get('codCentroCosto');
    if((!nuevoReg)&&((registro.get('situacion')!='1')))
    {
    	desHabilitarControles();
    }
    else
    {
    	habilitarControles();
    }*/
	    
}

function desHabilitarControles()
{
	Ext.getCmp('cmbTipoPresupuesto').disable();
    Ext.getCmp('txtPrograma').disable();
    Ext.getCmp('txtCentroC').disable();
    Ext.getCmp('txtProyecto').disable();
    Ext.getCmp('txtObjetoGasto').disable();
    Ext.getCmp('txtProducto').disable();   
    Ext.getCmp('txtPeriodo').disable();   
}

function habilitarControles()
{
	Ext.getCmp('cmbTipoPresupuesto').enable();
    Ext.getCmp('txtPrograma').enable();
    Ext.getCmp('txtCentroC').enable();
    Ext.getCmp('txtProyecto').enable();
    Ext.getCmp('txtObjetoGasto').enable();
    Ext.getCmp('txtProducto').enable();   
    Ext.getCmp('txtPeriodo').enable();   
}


function funcEditorCancelEdit(rowEdit,obj,registro,nFila)
{
	if(nuevoReg)
    {
    	var gridPOA=Ext.getCmp('gridPOA');
        gridPOA.getStore().removeAt(gridPOA.getStore().getCount()-1);
    }
    Ext.getCmp('btnAgregar').enable();
    Ext.getCmp('btnRemover').enable();
    nuevoReg=false;
}

function textFocus(ctrl)
{
	switch(ctrl.id)
    {
	    case 'txtPrograma':
        	mostrarVentanaPrograma(ctrl.id);
        break;
        case 'txtObjetoGasto':
        	mostrarVentanaObjetoGasto(ctrl.id);
        break;
        case 'txtProducto':
        break;
        case 'txtPeriodo':
        	mostrarVentanaMeses(ctrl.id);
        break;
        
    }	
}

function mostrarVentanaPrograma(ctrlId)
{
	var gridPrograma=generarGridPrograma();
    var ctrl;
    function aceptarClick()
    {
    	var filaTDoc=gridPrograma.getSelectionModel().getSelected();
        if(filaTDoc==null)
        {
            msgBox('Primero debe seleccionar un programa');
            return;
        }
        ctrl=Ext.getCmp(ctrlId);
		ctrl.setValue(filaTDoc.get('programa'));
       
        ventanaAM.close();

    }
    gridPrograma.on('rowdblclick',function()
    									{
                                        	aceptarClick();
                                        }
    						)
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														
                                                        {
                                                        	html:'Seleccione un programa:',
                                                            x:10,
                                                            y:10
                                                        },
                                                        gridPrograma
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Programas',
										width: 635,
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
															id:'btnTPAceptar',
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		aceptarClick();
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

function generarGridPrograma()
{
	var dsDatos=arrProgramas;
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idPrograma'},
                                                                {name: 'programa'},
                                                                {name: 'descripcion'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														{
															header:'Programa',
															width:200,
															sortable:true,
															dataIndex:'programa'
														},
                                                        {
															header:'Descripci&oacute;n',
															width:300,
															sortable:true,
															dataIndex:'descripcion'
														}
														
													]
												);
                                                
	var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:580
                                                            
                                                        }
                                                    );
	return 	tblGrid;
}

function mostrarVentanaObjetoGasto(ctrlId)
{
	var gridObjGasto=generarGridObjetoGasto();
    function aceptarClick()
    {
    	var filaTDoc=gridObjGasto.getSelectionModel().getSelected();
        if(filaTDoc==null)
        {
            msgBox('Primero debe seleccionar un objeto de gasto');
            return;
        }
        
        ctrl=Ext.getCmp(ctrlId);
		ctrl.setValue(filaTDoc.get('codigoCompletoObj'));
        ventanaAM.close();
    }
    gridObjGasto.on('rowdblclick',function()
    									{
                                        	aceptarClick();
                                        }
    						)
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														
                                                        {
                                                        	html:'Seleccione un objeto de gasto:',
                                                            x:10,
                                                            y:10
                                                        },
                                                        gridObjGasto
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Objeto de gasto',
										width: 635,
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
															id:'btnTPAceptar',
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		aceptarClick();
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
	
    gridObjGasto.getStore().load({params:{funcion:42}});                             
	ventanaAM.show();	
}

function generarGridObjetoGasto()
{
    var alDatos = new Ext.data.JsonStore	(
                                                        {
                                                            root: 'registros',
                                                            totalProperty: 'numReg',
                                                            idProperty: 'codigo',
                                                            fields:	[
                                                                        {name: 'codigoCompletoObj'},
		                                                                {name: 'tituloObj'}
                                                                    ],
                                                            remoteSort:false,
                                                            proxy: new Ext.data.HttpProxy	(
                                                                                                {
                                                                                                    url: '../paginasFunciones/funcionesContabilidad.php'
                                                                                                }
                                                                                            )
                                                        }
                                                    );                                            


	var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[
                                                        				{
                                                                            type:'string',
                                                                           	dataIndex:'codigoCompletoObj' 
																		},
                                                                        {
                                                                            type:'string',
                                                                           	dataIndex:'tituloObj' 
																		}
                                                        			]
                                                    }
                                                ); 
    
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														{
															header:'C&oacute;digo',
															width:100,
															sortable:true,
															dataIndex:'codigoCompletoObj'
														},
                                                        {
															header:'Objeto de gasto',
															width:400,
															sortable:true,
															dataIndex:'tituloObj'
														}
														
													]
												);
                                                
	var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridObjetoGasto',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:580,
                                                            plugins: filters
                                                            
                                                        }
                                                    );
	return 	tblGrid;
}

function mostrarVentanaMeses(ctrlId)
{
	var grid=generarGridMeses();
    var txtPeriodo=Ext.getCmp('txtPeriodo');
    function aceptarClick()
    {
    	var filaTDoc=grid.getSelectionModel().getSelections();
        if(filaTDoc.length==0)
        {
            msgBox('Primero debe seleccionar al menos un mes como periodo de ejecuci&oacute;n');
            return;
        }
        ctrl=Ext.getCmp(ctrlId);
        var meses='';
        var x;
        for(x=0;x<filaTDoc.length;x++)
        {
        	if(meses=='')
            	meses=filaTDoc[x].get('codMes');
            else
            	meses+=','+filaTDoc[x].get('codMes');
        }
        
		ctrl.setValue(meses);
       	ventanaAM.close();
    }
    grid.on('rowdblclick',function()
    									{
                                        	aceptarClick();
                                        }
    						)
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														
                                                        {
                                                        	html:'Indique el periodo de ejecuci&oacute;n:',
                                                            x:10,
                                                            y:10
                                                        },
                                                        grid
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Periodo de ejecuci&oacute;n',
										width: 280,
										height:390,
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
															id:'btnTPAceptar',
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		aceptarClick();
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

function generarGridMeses()
{
    var dsDatos=arrMeses;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'codMes'},
                                                                    {name: 'mes'}
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
															header:'Mes',
															width:150,
															sortable:true,
															dataIndex:'mes'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'tblMeses',
                                                            store:alDatos,
                                                            frame:true,
                                                            cm: cModelo,
                                                            height:300,
                                                            width:250,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
}