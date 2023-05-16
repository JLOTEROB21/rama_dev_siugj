<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$conCiclos="SELECT ciclo,ciclo FROM 550_cicloFiscal";
	$arrCiclos=$con->obtenerFilasArreglo($conCiclos);
	
?>

var arregloQ=[['01','01'],['02','02'],['03','03'],['04','04'],['05','05'],['06','06'],['07','07'],['08','08'],['09','09'],['10','11'],['11','11'],['12','12'],['13','13'],['14','14'],['15','15'],['16','16'],['17','17'],['18','18'],['19','19'],['20','20'],['21','21'],['22','22'],['23','23'],['24','24']];

var nodoSel=null;

Ext.onReady(inicializar);

function validarFrm()
{
	if(validarFormularios('frmEnvio'))
    {
    	gE('frmEnvio').submit();
    }
}

function inicializar()
{
	gE('_cveFactorvch').focus();
	if(gE('idFactor').value!='-1')
    {
    	crearArbolDefinicionFactor();
        crearPanel();
        crearGridRiesgo();
    }
}


function crearArbolDefinicionFactor()
{
		var raiz=new  Ext.tree.AsyncTreeNode	(
                                                      {
                                                          id:'-1',
                                                          text:'Raiz',
                                                          draggable:false,
                                                          expanded :true
                                                      }
                                              	)
                                        
		var cargadorArbol=new Ext.tree.TreeLoader(
                                                        {
                                                            baseParams:{
                                                                            funcion:'75',
                                                                            idFactor:gE('idFactor').value
                                                                        },
                                                            dataUrl:'../paginasFunciones/funcionesContabilidad.php',
                                                            uiProviders:	{
                                                                            	'col': Ext.ux.tree.ColumnNodeUI
                                                                        	}
                                                        }	


		                                         )		                                        
	
                                                 
                                        
		var arbol = new Ext.ux.tree.ColumnTree	(
                                                            {
                                                                id:'tArbol',
                                                                title:' ',
                                                                height:600,
                                                                width:790,
                                                                useArrows:true,
                                                                autoScroll:true,
                                                                animate:true,
                                                                enableDD:true,
                                                                containerScroll: true,
                                                                root:raiz,
                                                                loader: cargadorArbol,
                                                                rootVisible:false,
                                                                collapsible: true,
                                                                draggable:false,
                                                                enableSort:false,
                                                                columns:[
                                                                			{
                                                                                header:'Departamento/Puesto',
                                                                                width:550,
                                                                                dataIndex:'valor'
                                                                            },
                                                                			{
                                                                                header:'Valor factor',
                                                                                width:100,
                                                                                dataIndex:'valor'
                                                                            },
                                                                            {
                                                                                header:'Tipo valor',
                                                                                width:100,
                                                                                dataIndex:'tipoValor'
                                                                            }
                                                                            
                                                                        ],
                                                                 listeners: 	{
                                                                                    'render': 	function(tp)
                                                                                    			{
                                                                                                 }
                                                                                    }

                                                               
                                                            }
                                                    );
		
        
      

        
        var panel=new Ext.Panel	(
        							{
                                    	id:'divPanel',
                                        renderTo:'tblArbol',
                                        items:	[
                                                    arbol
                                        		],
                                        tbar:	[
                                        
                                                    {
                                                    	id:'btnAddDepto',
                                                        text:'Agregar Departamento',
                                                        icon:'../images/add.png',
                                                        cls:'x-btn-text-icon',
                                                        handler:function()
                                                                {
                                                                    mostrarVentanaAgregarDepartamento();
                                                                }
                                                    },
                                                     {
                                                     	id:'btnAddPuesto',
                                                        text:'Agregar Puesto',
                                                        icon:'../images/especial.png',
                                                        cls:'x-btn-text-icon',
                                                        disabled:true,
                                                        handler:function()
                                                                {
                                                                    mostrarVentanaAgregarPuesto()
                                                                }
                                                    },
                                                    '-',
                                                    {
                                                    	id:'btnEliminar',
                                                        text:'Eliminar departamento/puesto',
                                                        icon:'../images/cancel_round.png',
                                                        cls:'x-btn-text-icon',	
                                                        disabled:true,
                                                        handler:function()
                                                                {
                                                                	if(nodoSel==null)
                                                                    {
                                                                    	msgBox('Primero debe seleccionar el departamento/puesto que desea remover');
                                                                        return;
                                                                    }
                                                                    
                                                                   // alert(nodoSel.attributes.tipo);
//                                                                    alert(nodoSel.attributes.valor);
//                                                                    return;
                                                                    function resp(btn)
                                                                    {
                                                                    	if(btn=='yes')
                                                                        {
                                                                        	var valor;
                                                                            if(nodoSel.attributes.tipo=='1')
                                                                            	valor=nodoSel.attributes.codigoDepto;
                                                                            else
                                                                            	valor=nodoSel.attributes.id;
                                                                        	
                                                                            var idFactor=gE('idFactor').value;
                                                                            var tipo=nodoSel.attributes.tipo;
                                                                            ventanaUltimoPeriodo(idFactor,tipo,valor,ventana);
                                                                        }
                                                                    }
                                                                    msgConfirm('&iquest;Est&aacute; seguro de querer eliminar el departamento/puesto seleccionado?',resp)
                                                                }
                                                    }
                                                ]
                                    }
        						)
        arbol.on('click',nodoClick);	
        if(gE('chkFactorTodos').checked)
        {
        	gEx('divPanel').disable();
        }
}

function nodoClick(nodo)
{
	nodoSel=nodo;
    gEx('btnAddPuesto').disable();
    gEx('btnEliminar').enable();
	if(nodoSel.attributes.tipo=='1')
    {
    	gEx('btnAddPuesto').enable();
    }
    else
    {
    	gEx('btnAddPuesto').disable();    
    }
}

function mostrarVentanaAgregarDepartamento()
{
	var gridDepartamentos=crearGriDeptos();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione los departamentos que desee vincular al factor:'
                                                        },
														gridDepartamentos

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Listado de departamentos disponibles',
										width: 720,
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
																		var filas=gridDepartamentos.getSelectionModel().getSelections();	
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Al menos debe seleccionar un departamento a vincular');
                                                                        	return;
                                                                        }
                                                                        var x;
                                                                        var arrDeptos='';
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	if(arrDeptos=='')
                                                                            	arrDeptos="'"+filas[x].get('codigoDepto')+"'";
                                                                            else
                                                                            	arrDeptos+=",'"+filas[x].get('codigoDepto')+"'";
                                                                        }
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                             	gEx('tArbol').getRootNode().reload();   
                                                                                gEx('btnAddPuesto').disable();
																			    gEx('btnEliminar').disable();
                                                                                nodoSel=null;
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=78&listDeptos='+arrDeptos+'&idFactor='+gE('idFactor').value,true);

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
	llenarGridDeptos(gridDepartamentos.getStore(),ventanaAM);                                
	
}

function crearGriDeptos()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'codigoDepto'},
                                                                    {name: 'departamento'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:25}),
														chkRow,
														{
															header:'Departamento',
															width:590,
															sortable:true,
															dataIndex:'departamento'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridDeptos',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:320,
                                                            width:680,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;		
}

function llenarGridDeptos(almacen,ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            almacen.loadData(eval(arrResp[1]));
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=77&idFactor='+gE('idFactor').value,true);

}

function mostrarVentanaAgregarPuesto()
{
	var codDepto=nodoSel.attributes.codigoDepto;
 	var gridPuestos=crearGridPuestosDisponibles();   
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione los puestos que desea vincular al factor:'
                                                        },
                                                        gridPuestos

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Listado de puestos disponibles',
										width: 620,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
                                                                    	var filas=gridPuestos.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar al menos un puesto a vincular con el factor');
                                                                            return;
                                                                        }
																		mostrarVentanaPonderarPuesto(filas,ventanaAM);
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
	llenarPuestosDisponibles(gridPuestos.getStore(),codDepto,ventanaAM);	
    
    
}

function llenarPuestosDisponibles(almacen,codDepto,ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            almacen.loadData(eval(arrResp[1]));
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=79&idFactor='+gE('idFactor').value+'&codDepto='+codDepto,true);
}

var arrTipoValor=[['0','Unidad'],['1','Porcentaje']];


function crearGridPuestosDisponibles()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'cvePuesto'},
                                                                {name: 'nomPuesto'},
                                                                {name: 'valorFactor'},
                                                                {name: 'tipoValor'},
                                                                {name: 'ciclo'},
                                                                {name: 'periodo'}
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
															header:'Clave puesto',
															width:100,
															sortable:true,
															dataIndex:'cvePuesto'
														},
														{
															header:'Puesto',
															width:400,
															sortable:true,
															dataIndex:'nomPuesto'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:320,
                                                            width:590,
                                                            sm:chkRow,
                                                            columnLines : true

                                                        }
                                                    );
	return 	tblGrid;		
}


function mostrarVentanaPonderarPuesto(arrPuestos,ventana)
{
	var codDepto=nodoSel.attributes.codigoDepto;
 	var gridPuestos=crearGridPuestosDisponiblesSelect(arrPuestos);   
    gridPuestos.getStore().add(arrPuestos);
    ventana.close();
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Ingrese el valor de los factores para cada uno de los puestos seleccioandos:'
                                                        },
                                                        gridPuestos

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Listado de puestos seleccionados',
										width: 750,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var x;
                                                                        var fila;
                                                                        for(x=0;x<gridPuestos.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gridPuestos.getStore().getAt(x);
                                                                            if(fila.get('valorFactor')=='')
                                                                            {
                                                                            	function resp()
                                                                                {
                                                                                	gridPuestos.startEditing(x,4);
                                                                                }
                                                                                msgBox('Debe ingresar el valor del factor a asignar al puesto',resp)
                                                                            	return;
                                                                            }
                                                                            
                                                                            if(fila.get('tipoValor')=='')
                                                                            {
                                                                            	function resp1()
                                                                                {
                                                                                	gridPuestos.startEditing(x,5);
                                                                                }
                                                                                msgBox('Debe ingresar el tipo de valor por cada puesto',resp1)
                                                                            	return;
                                                                            }
                                                                            
                                                                            if(fila.get('ciclo')=='')
                                                                            {
                                                                            	function resp2()
                                                                                {
                                                                                	gridPuestos.startEditing(x,6);
                                                                                }
                                                                                msgBox('Debe ingresar el ciclo por cada puesto',resp2)
                                                                            	return;
                                                                            }
                                                                        }
                                                                        var arrObj='';
                                                                        var obj='';
                                                                        for(x=0;x<gridPuestos.getStore().getCount();x++)
                                                                        {
                                                                        	var fila=gridPuestos.getStore().getAt(x);
                                                                            var periodo=fila.get('periodo');
                                                                            alert(periodo);
                                                                            if(periodo=='')
                                                                            	periodo=100;
                                                                        	obj='{"cvePuesto":"'+fila.get('cvePuesto')+'","valor":"'+fila.get('valorFactor')+'","tipoValor":"'+fila.get('tipoValor')+'","ciclo":"'+fila.get('ciclo')+'","periodo":"'+periodo+'"}';
                                                                        	if(arrObj=='')
                                                                            	arrObj=obj;
                                                                            else
                                                                            	arrObj+=','+obj;
                                                                        }
                                                                        arrObj='{"arrObj":['+arrObj+']}';
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                             	gEx('tArbol').getRootNode().reload();   
                                                                                gEx('btnAddPuesto').disable();
																				gEx('btnEliminar').disable();
                                                                                nodoSel=null
                                                                                ventanaAM.close();
                                                                                   
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=80&cveFactor='+cv(gE('cveFactor').value)+'&departamento='+codDepto+'&idFactor='+gE('idFactor').value+'&cadObj='+arrObj,true);
                                                                        
                                                                        
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



function crearGridPuestosDisponiblesSelect()
{
	var cmbTipoValor=crearComboExt('cmbTipoValor',arrTipoValor);
    var cmbCicloD=crearComboExt('cmbCicloD',<?php echo $arrCiclos?>);
    var cmbQ=crearComboExt('cmbQ',arregloQ);
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'cvePuesto'},
                                                                {name: 'nomPuesto'},
                                                                {name: 'valorFactor'},
                                                                {name: 'tipoValor'},
                                                                {name: 'ciclo'},
                                                                {name: 'periodo'}
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
															header:'Clave puesto',
															width:100,
															sortable:true,
															dataIndex:'cvePuesto'
														},
														{
															header:'Puesto',
															width:300,
															sortable:true,
															dataIndex:'nomPuesto'
														},
                                                        {
															header:'Valor factor',
															width:100,
															sortable:true,
															dataIndex:'valorFactor',
                                                            editor:{
                                                            			xtype:'numberfield',
                                                                        allowDecimals:true,
                                                            		}
														},
                                                        {
															header:'Tipo valor',
															width:110,
															sortable:true,
															dataIndex:'tipoValor',
                                                            editor:cmbTipoValor,
                                                            renderer:function (val)
                                                            		{
                                                                    	return formatearValorRenderer(arrTipoValor,val);
                                                                    }
														},
                                                        {
															header:'Ciclo',
															width:110,
															sortable:true,
															dataIndex:'ciclo',
                                                            editor:cmbCicloD,
                                                            renderer:function (val)
                                                            		{
                                                                    	return formatearValorRenderer(<?php echo $arrCiclos?>,val);
                                                                    }
														},
                                                        {
															header:'Per&iacute;odo',
															width:110,
															sortable:true,
															dataIndex:'periodo',
                                                            editor:cmbQ,
                                                            renderer:function (val)
                                                            		{
                                                                    	return formatearValorRenderer(arregloQ,val);
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:320,
                                                            width:710,
                                                            sm:chkRow,
                                                            columnLines : true,
                                                            tbar:[
                                                            		{
                                                                    	icon:'../images/delete.png',
                                                                        cls:'x-btn-text-icon',
                                                                        text:'Remover puesto',
                                                                        handler:function()
                                                                                {
                                                                                    var filas=tblGrid.getSelectionModel().getSelections();
                                                                                    if(filas.length==0)
                                                                                    {
                                                                                        msgBox('Debe seleccionar al menos un puesto a remover');
                                                                                        return;
                                                                                    }
                                                                                    
                                                                                    function resp(btn)
                                                                                    {
                                                                                    	if(btn=='yes')
                                                                                        {
                                                                                        	tblGrid.getStore().remove(filas);
                                                                                        }
                                                                                    }
                                                                                    msgConfirm('Est&aacute; seguro de querer remover los puestos seleccionados',resp)
                                                                                }
                                                                    }
                                                            	]

                                                        }
                                                    );
	return 	tblGrid;		
}

function mostrarVentanaFactor()
{
	var cmbTipoValor=crearComboExt('cmbTipoValor',arrTipoValor,110,35);
    cmbTipoValor.setValue(1);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Valor a asignar:',
                                                        },
                                                        {
                                                        	xtype:'numberfield',
                                                            x:110,
                                                            y:5,
                                                            id:'txtValor',
                                                            width:80,
                                                            decimalPrecision:4
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Tipo valor:'
                                                        },
                                                        cmbTipoValor
                                                        

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignar valor a todos los puestos',
										width: 400,
										height:150,
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
                                                                	gEx('txtValor').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtValor=gEx('txtValor').getRawValue();
                                                                        if(txtValor=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	gE('txtValor').focus();
                                                                            }
                                                                            msgBox('Debe ingresar el valor a asignar a todos los puestos de la instituci&oacute;n',resp);
                                                                            retun;
                                                                        }
                                                                        
                                                                        function respP(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        recargarPagina();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=81&cveFactor='+gE('cveFactor').value+'&idFactor='+gE('idFactor').value+'&valor='+txtValor+'&tipoValor='+cmbTipoValor.getValue(),true);
                                                                           }
																		}
                                                                        msgConfirm('Est&aacute; seguro de querer asignar un valor a todos los puestos?<br><b>Nota:</b> Esta acci&oacute;n eliminar&aacute; cualquier otro valor asignado a un puesto/departamento',respP);

																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
                                                                    	gE('chkFactorTodos').cheked=false;
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	    
}

function asignarTodosPuestos(chk)
{
	if(chk.checked)
    {
    	mostrarVentanaFactor();
    }
    else
    {
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
                        recargarPagina();
                    }
                    else
                    {
                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                    }
                }
                obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=82&idFactor='+gE('idFactor').value,true);
			            
            }
        }
    	msgConfirm('Est&aacute; seguro de querer desasociar el valor a todos los puestos de la instituci&oacute;n?',resp)
    }
}

function crearPanel()
{
	var gridF=crearGridRiesgo();
    var gridH=crearGridHistorial();
    var tabs = new Ext.TabPanel	(
									{
										renderTo: 'my-tabs',
										activeTab: 0,
										width:850,
										height:1000,
										items:	[	
												 {
                                                    contentEl:'tabla1', 
                                                    title:'Departamento'
                                                 },
                                                 {
                                                    title:'Usuario',
                                                    items:gridF
                                                 },
                                                 {
                                                    title:'Historial',
                                                    items:gridH
                                                 }
												]
									}
								);

}

function crearGridRiesgo()
{
     var dsTablaRegistros4=new Ext.data.JsonStore({
                                                        root: 'registros',
                                                        totalProperty: 'numReg',
                                                        idProperty: 'idUsuarioVSRiesgo',
                                                        fields: [
                                                                  {name: 'idUsuarioVSRiesgo'},
                                                                  {name: 'idUsuario'},
                                                                  {name: 'nombre'},
                                                                  {name: 'tipoValor'},
                                                                  {name: 'cantidad'},
                                                                  {name: 'ciclo'},
                                                                  {name: 'periodo'},
                                                              ],         
                                                        proxy : new Ext.data.HttpProxy	(

                                                                                          {

                                                                                              url: '../paginasFunciones/funcionesContabilidad.php'

                                                                                          }
                                                                                      )                             
                                                    })
	dsTablaRegistros4.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion=83;
                                        proxy.baseParams.idFactor=gE('idFactor').value;
                                    }
                        );
   
	var chkRow=new Ext.grid.CheckboxSelectionModel();
    
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Nombre',
															width:300,
															sortable:true,
															dataIndex:'nombre',
                                                            align:'left'
														},
                                                        {
															header:'Valor Factor',
															width:100,
															sortable:true,
															dataIndex:'cantidad'
														},
                                                        {
															header:'Tipo Valor',
															width:100,
															sortable:true,
															dataIndex:'tipoValor'
														},
                                                        {
															header:'Ciclo',
															width:100,
															sortable:true,
															dataIndex:'ciclo'
														},
                                                        {
															header:'Per&iacute;odo',
															width:100,
															sortable:true,
															dataIndex:'periodo'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            store:dsTablaRegistros4,
                                                            frame:true,
                                                            cm: cModelo,
                                                            height:700,
                                                            width:750,
                                                            sm:chkRow,
                                                            id:'gridUsuariosRiesgo',
                                                            tbar:	[
                                                            			{
                                                                        	text:'Agregar Empleado',
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            	{
                                                                                	agregarEmpleado(tblGrid);
                                                                                }
                                                                        },
                                                                        {
                                                                        	text:'Remover Empleado',
                                                                            icon:'../images/cancel_round.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            	{
                                                                                
                                                                                	removerEmpleado(tblGrid);
                                                                                }
                                                                        }
                                                            		]
                                                                                                                                                                        
                                                        }
                                                    );
		
    dsTablaRegistros4.load()  ;     
	return 	tblGrid;	
}

function agregarEmpleado(gridF)
{
	var codigoInst='<?php echo $_SESSION["codigoInstitucion"] ?>';
    
   gE('cBusquedaP').value='1';
	
	var cmbRel=document.createElement('select');
	
	var parametros2=	{
							funcion:'84',
							criterio:'',
                            codInst:codigoInst
						};
	
    var comboTipo=crearComboExt('comboTipo',arrTipoValor,90,95);
    var cmbCiclo=crearComboExt('cmbCiclo',<?php echo $arrCiclos ?>,90,130);
    cmbCiclo.on('select',obtenerQuincenas);
    var cmbQuincena=crearComboExt('cmbQuincena',[],90,160);
    var comboPapa=inicializarCmbPadre(parametros2);
	var form = new Ext.form.FormPanel(	
										 	{
												baseCls: 'x-plain',
												layout:'absolute',
												defaultType: 'textfield',
												items: 	[
														 	new Ext.form.Label	(
																				 	{
																						x:30,
																						y:40,
																						text:'Persona: '
																					}
																				)
															,
															comboPapa,
															new Ext.form.Radio	(
																					{
																						x:5,
																						y:5,
																						id:'rdoPaterno',
																						boxLabel:'Ap. Paterno',
																						checked:true,
																						value:1
																					}
																				),
															new Ext.form.Radio	(
																					{
																						x:135,
																						y:5,
																						id:'rdoMaterno',
																						boxLabel:'Ap. Materno',
																						value:2
																					}
																				),
															new Ext.form.Radio	(
																					{
																						x:265,
																						y:5,
																						id:'rdoNombre',
																						boxLabel:'Nombre',
																						value:3
																					}
																				),
                                                            new Ext.form.Label	(
																				 	{
																						x:10,
																						y:70,
																						text:'Valor Factor: '
																					}
																				)
																				, 
                                                                                {
                                                                                   x:90,
                                                                                   y:65,
                                                                                   id:'cantidadV',
                                                                                   xtype:'numberfield',
                                                                                   width:60
                                                                                 },
                                                             new Ext.form.Label	(
																				 	{
																						x:18,
																						y:100,
																						text:'Tipo Valor: '
																					}
																				)
																				,                       
                                                                                 comboTipo,
                                                            new Ext.form.Label	(
																				 	{
																						x:48,
																						y:135,
																						text:'Ciclo: '
																					}
																				)
																				,                       
                                                                                 cmbCiclo,
                                                           new Ext.form.Label	(
																				 	{
																						x:23,
																						y:165,
																						text:'Quincena: '
																					}
																				)
																				,                       
                                                                                 cmbQuincena                                                                 
														]
											}
										);
	
	var ventana = new Ext.Window	(
									{
										title: lblAplicacion,
										width: 450,
										height:280,
										minWidth: 280,
										minHeight: 100,
										layout: 'fit',
										plain:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										modal:true,
										listeners : {
														show : {
																	buffer : 500,
																	fn : function() 
																	{
																		comboPapa.focus();
																	}
																}
													},
										buttons:	[
														{
															text: 'Aceptar',
															handler:function()
																	{
																		
                                                                        var idUsr=gE('idUsuario').value;
                                                                        var idFactor=gE('idFactor').value;
                                                                        if(idUsr=='-1')
                                                                        {
                                                                        	function respUsr()
                                                                            {
                                                                            	comboPapa.focus();
                                                                            }
                                                                        	msgBox('Debe seleccionar el usuario a agregar',respUsr);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cmbC=Ext.getCmp('cantidadV');
                                                                        var cantidad=cmbC.getValue();
                                                                        if(cantidad=='')
                                                                        {
                                                                        	function respUsr1()
                                                                            {
                                                                            	cmbC.focus();
                                                                            }
                                                                            msgBox('Debe indicar el Valor Factor',respUsr1);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cmbT=Ext.getCmp('comboTipo');
                                                                        var tipo=cmbT.getValue();
                                                                        if(tipo=='')
                                                                        {
                                                                        	function respUsr2()
                                                                            {
                                                                            	cmbT.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de valor',respUsr2);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cmbCiclo=Ext.getCmp('cmbCiclo');
                                                                        var idCiclo=cmbCiclo.getValue();
                                                                        if(idCiclo=='')
                                                                        {
                                                                        	function respUsr3()
                                                                            {
                                                                            	cmbCiclo.focus();
                                                                            }
                                                                            msgBox('Debe indicar el Ciclo',respUsr3);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cmbQuin=Ext.getCmp('cmbQuincena');
                                                                        var idQ=cmbQuin.getValue();
                                                                        if(idQ=='')
                                                                        {
                                                                        	function respUsr4()
                                                                            {
                                                                            	cmbQuin.focus();
                                                                            }
                                                                            msgBox('Debe indicar la quincena',respUsr4);
                                                                            return;
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText.split('|');
                                                                            if(resp[0]=='1')
                                                                            {
                                                                                
                                                                                gridF.getStore().reload();
                                                                                
                                                                                ventana.close()
                                                                                
                                                                                //recargarGrid(ventana);
                                                                            }
                                                                            else
                                                                            {
                                                                                if(resp[0]=='2')
                                                                            	{
                                                                                	 Ext.MessageBox.alert(lblAplicacion,'El usuario ya cuenta con un registro');
                                                                                     return;
                                                                                }	
                                                                                else
                                                                                {
                                                                                    Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp[0]);
                                                                                }   
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=85&idFactor='+idFactor+'&idUsuario='+idUsr+'&cantidad='+cantidad+'&tipo='+tipo+'&idCiclo='+idCiclo+'&idQ='+idQ,true)
                                                                    }
                                                                    
														},
														{
															text: 'Cancelar',
															handler:function()
																	{
																		gE('idUsuario').value=-1;
                                                                        ventana.close();
																	}
														}
													]
    								}
								);

	var rdoPaterno=Ext.getCmp('rdoPaterno');
	var rdoMaterno=Ext.getCmp('rdoMaterno');
	var rdoNombre=Ext.getCmp('rdoNombre');
	rdoPaterno.on('check',cambiarRadioSel);									
	rdoMaterno.on('check',cambiarRadioSel);									
	rdoNombre.on('check',cambiarRadioSel);							
    ventana.show();
}

function inicializarCmbPadre(parametros2)
{

	var pPagina=new Ext.data.HttpProxy	(
										 	{
												url:'../paginasFunciones/funcionesContabilidad.php',
												method:'POST'
											}
										 );
	var lector=new Ext.data.JsonReader 	(
										 	{
												root:'personas',
												totalProperty:'num',
												id:'idUsuario'
											},
											[
											 	{name:'idUsuario', mapping:'idUsuario'},
												{name:'Paterno', mapping:'Paterno'},
												{name:'Materno', mapping:'Materno'},
												{name:'Nom', mapping:'Nom'},
												{name:'Nombre', mapping:'Nombre'},
												{name:'Status', mapping:'Status'}
                                                ,
                                                {name:'idUsuario',mapping:'idUsuario'}
											]
										);

	var ds=new Ext.data.Store	(
								 	{
										proxy:pPagina,
										reader:lector,
										baseParams:parametros2
									}
								 );
	
	function cargarDatos(dSet)
	{
		gE('idUsuario').value='-1';
		var aNombre=Ext.getCmp('cmbNombrePadre').getValue();
		dSet.baseParams.criterio=aNombre;
		dSet.baseParams.campoBusqueda=gE('cBusquedaP').value;
       
	}
	
	ds.on('beforeload',cargarDatos);

	var resultTpl=new Ext.XTemplate	(
									 	'<tpl for="."><div class="search-item">',
											'{Paterno}&nbsp;{Materno}&nbsp;{Nom}&nbsp;<br>{Status}<br>---<br>',
										'</div></tpl>'
									 );
	
	var comboNombre= new Ext.form.ComboBox	(
												 	{
														x:90,
														y:35,
														id:'cmbNombrePadre',
														store:ds,
														displayField:'Nombre',
														typeAhead:false,
														minChars:1,
														loadingText:'Procesando, por favor espere...',
														width:320,
                                                        listWidth :320,
														pageSize:10,
														hideTrigger:true,
														tpl:resultTpl,
														itemSelector:'div.search-item'
														
													}
												 );
	
    function funcElemSeleccionado(combo,registro)
	{	
		var idUsuario=registro.get('idUsuario');
		gE('idUsuario').value=idUsuario;
    }
	comboNombre.on('select',funcElemSeleccionado);	
	return comboNombre;
}

function cambiarRadioSel(chk, valor)
{
	if(valor==true)
	{
		var rdoPaterno=Ext.getCmp('rdoPaterno');
		var rdoMaterno=Ext.getCmp('rdoMaterno');
		var rdoNom=Ext.getCmp('rdoNombre');
		if(rdoPaterno.id!=chk.id)
			rdoPaterno.setValue(false);
		if(rdoMaterno.id!=chk.id)
			rdoMaterno.setValue(false);
		if(rdoNom.id!=chk.id)
			rdoNom.setValue(false);
		gE('cBusquedaP').value=chk.value;
	}
}

function recargarGrid(ventana)
{
	var almacen=Ext.getCmp('gridUsuariosRiesgo').getStore();
    //alert(almacen);
    almacen.reload();
    ventana.close();
}

function removerEmpleado(gridF)
{
	//gridF.getSelectionModel().getSelections();
	//var modoSel=Ext.getCmp('gridUsuariosRiesgo').getSelectionModel().getSelections();
    var modoSel=gridF.getSelectionModel().getSelections();
    var tamano=modoSel.length;
    if(tamano==0)
    {
    	Ext.MessageBox.alert(lblAplicacion,'Debe seleccionar al menos un empleado');
        return;
    
    }
    var cadena='';
    var x;
    
    for(x=0;x< tamano;x++)
    {
    	var id=modoSel[x].get('idUsuarioVSRiesgo');
        if(cadena=='')
    		cadena=id;
        else
            cadena+=','+id;
    }
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1') 
        {
			gridF.getStore().reload();
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=86&cadena='+cadena,true);

}

function obtenerQuincenas(combo,fila,pos)
{
	var idCiclo=combo.getValue();
	
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1') 
        {
			Ext.getCmp('cmbQuincena').getStore().loadData(eval(arrResp[1]));
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=90&idCiclo='+idCiclo,true);
}

function ventanaUltimoPeriodo()
{
	function funcAjax()
                                                                    {
                                                                        var resp=peticion_http.responseText;
                                                                        arrResp=resp.split('|');
                                                                        if((arrResp[0]=='1')||(arrResp[0]==1))
                                                                        {
                                                                            nodoSel.remove();
                                                                            nodoSel=null;
                                                                            gEx('btnEliminar').disable();
                                                                            gEx('btnAddPuesto').disable();
                                                                            
                                                                        }
                                                                        else
                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                    }
                                                                    obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=76&idFactor='+gE('idFactor').value+'&tipo='+nodoSel.attributes.tipo+'&valor='+valor,true);
}

function crearGridHistorial()
{
    var dsHistorial=new Ext.data.JsonStore({
                                                        root: 'registros',
                                                        totalProperty: 'numReg',
                                                        idProperty: 'idUsuarioVSRiesgo',
                                                        fields: [
                                                                  {name: 'idUsuarioVSRiesgo'},
                                                                  {name: 'idUsuario'},
                                                                  {name: 'nombre'},
                                                                  {name: 'tipoValor'},
                                                                  {name: 'cantidad'},
                                                                  {name: 'ciclo'},
                                                                  {name: 'periodo'},
                                                              ],         
                                                        proxy : new Ext.data.HttpProxy(
                                                                                          {

                                                                                              url: '../paginasFunciones/funcionesContabilidad.php'

                                                                                          }
                                                                                      )                             
                                                    })
	dsHistorial.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion=91;
                                        proxy.baseParams.idFactor=gE('idFactor').value;
                                    }
                        );
   
	 var filters = new Ext.ux.grid.GridFilters	(
                                                  {
                                                      filters:	[
                                                                      {
                                                                          type:'string',
                                                                          dataIndex:'nombre' 
                                                                      },
                                                                      {
                                                                          type:'string',
                                                                          dataIndex:'ciclo' 
                                                                      },
                                                                      {
                                                                          type:'string',
                                                                          dataIndex:'periodo' 
                                                                      }
                                                                  ]
                                                  }
                                              ); 
   var tamPagina=50;
   var paginador=	new Ext.PagingToolbar	(
                                              {
                                                  pageSize: tamPagina,
                                                  store: dsHistorial,
                                                  displayInfo: true,
                                                  disabled:false
                                              }
                                            );    
   var chkRow=new Ext.grid.CheckboxSelectionModel();
   var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Nombre',
															width:300,
															sortable:true,
															dataIndex:'nombre',
                                                            align:'left'
														},
                                                        {
															header:'Valor Factor',
															width:100,
															sortable:true,
															dataIndex:'cantidad'
														},
                                                        {
															header:'Tipo Valor',
															width:100,
															sortable:true,
															dataIndex:'tipoValor'
														},
                                                        {
															header:'Ciclo',
															width:100,
															sortable:true,
															dataIndex:'ciclo'
														},
                                                        {
															header:'Per&iacute;odo',
															width:100,
															sortable:true,
															dataIndex:'periodo'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            store:dsHistorial,
                                                            frame:true,
                                                            cm: cModelo,
                                                            height:700,
                                                            width:750,
                                                            sm:chkRow,
                                                            id:'gridUsuariosRiesgo',
                                                            bbar: paginador,
                                                            plugins: [filters]
                                                        }
                                                    );
		
    dsHistorial.load({params:{start:0,limit:tamPagina,funcion:91}})  ; 
    //dsHistorial.load()  ;     
	return 	tblGrid;	
}