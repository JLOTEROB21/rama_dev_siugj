<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$tipoConsulta=bD($_GET["tC"]);
	
	$consulta="select ciclo,ciclo from 550_cicloFiscal where ciclo in (select ciclo from 655_fechasNomina  where situacion=1) order by ciclo";
	$arrCiclos=uEJ($con->obtenerFilasArreglo($consulta));
	$tSingular="deducci&oacute;n";
	$tPlural="deducciones";
	if($tipoConsulta==2)
	{
		$tSingular="percepci&oacute;n";
		$tPlural="percepciones";
	}
	
?>
var tipoSingular='<?php echo $tSingular?>';
var tipoPlural='<?php echo $tPlural?>';


var arrTipoAfectacion=[['1','Debe'],['2','Haber']];
var tC;

Ext.onReady(inicializar);

function inicializar()
{
	tC=bD(gE('tipoConcepto').value);
}

function agregarConcepto()
{
	var idUsuario=gE('idUsuario').value;
	var tipoConcepto=gE('tipoConcepto').value;
    
    var gridConcepto=crearGridConceptos();
    
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione las '+tipoPlural+' que desea agregar:'
                                                        },
                                                        gridConcepto														

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Nueva '+tipoSingular,
										width: 690,
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
																		var filas=gridConcepto.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar la '+tipoSingular+' a agregar');
                                                                            return;
                                                                        }
                                                                        
                                                                        var listDeduc=obtenerListadoArregloFilas(filas,'idConsulta');
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	recargarPagina2();	
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=49&listConceptos='+listDeduc+'&tipo='+tC+'&idUsuario='+idUsuario,true);
                                                                        
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
    llenarGridConceptos(ventanaAM,gridConcepto);
}

function crearGridConceptos()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idConsulta'},
                                                                {name: 'codigo'},
                                                                {name: 'nomConcepto'},
                                                                {name: 'descripcion'}
                                                                
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
															header:'C&oacute;digo',
															width:100,
															sortable:true,
															dataIndex:'codigo'
														},
														{
															header:letraCapitalPalabra(tipoSingular),
															width:150,
															sortable:true,
															dataIndex:'nomConcepto'
														},
														{
															header:'Descripci&oacute;n',
															width:300,
															sortable:true,
															dataIndex:'descripcion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:650,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;		
}

function llenarGridConceptos(ventana,gridConcepto)
{
	var idUsuario=gE('idUsuario').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            gridConcepto.getStore().loadData(arrDatos);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=53&tipo='+tC+'&idUsuario='+idUsuario,true);
	
}


function actualizaAfectacion(check)
{
	var accion='-1';
	if(check.checked);
    	accion="1";
    var arrAfectacion=check.id.split('_');
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
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=50&accion='+accion+'&tipoConcepto='+tC+'&afectacion='+arrAfectacion[1]+'&idConcepto='+arrAfectacion[2],true);  
}

function actualizarAfectacionNomina(radio)
{
	var arrAfectacion=radio.id.split('_');
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	recargarPagina2();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=51&tipoConcepto='+tC+'&afectacion='+arrAfectacion[1]+'&idConcepto='+arrAfectacion[2],true);  
}

function configurarQuincenasAplicacion(idConcepto)
{
	var arrCiclos=<?php echo $arrCiclos?>;
	var cmbCiclos=crearComboExt('cmbCiclos',arrCiclos,90,5);
    cmbCiclos.on('select',funcCicloSelect);
    var cmbQuincena=crearComboExt('cmbQuincena',[],90,35);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                        	html:'Ciclo:'
                                                        },
                                                        cmbCiclos	,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Quincena:'
                                                        },											
                                                        cmbQuincena,
                                                         {
                                                        	x:10,
                                                            y:70,
                                                            html:'No quincenas:'
                                                        },
                                                        {
                                                        	x:90,
                                                            y:65,
                                                        	xtype:'numberfield',
                                                            id:'txtNQuincenas',
                                                            value:'1'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Quincenas de afectaci&oacute;n',
										width: 300,
										height:210,
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
																		if(cmbCiclos.getValue()=='')
                                                                        {
                                                                        	function respC()
                                                                            {
                                                                            	cmbCiclos.focus();
                                                                            }
                                                                            
                                                                        	msgBox('Debe seleccionar el ciclo al cual pertenece la primera quincena de afectaci&oacute;',respC);
                                                                        	return;
                                                                            
                                                                        }
                                                                        if(cmbQuincena.getValue()=='')
                                                                        {
                                                                        	function respQ()
                                                                            {
                                                                            	cmbQuincena.focus();
                                                                            }
                                                                            
                                                                        	msgBox('Debe seleccionar la primera quincena de afectaci&oacute;',respQ);
                                                                        	return;
                                                                            
                                                                        }
                                                                        var txtNQuincenas=gEx('txtNQuincenas');
                                                                        if(txtNQuincenas.getValue()=='')
                                                                        {
                                                                        	function respQA()
                                                                            {
                                                                            	txtNQuincenas.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el n&uacute;mero de quincenas a afectar',respQA);
                                                                            return;
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	recargarPagina2();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=52&tipoConcepto='+tC+'&idConcepto='+idConcepto+'&ciclo='+cmbCiclos.getValue()+'&quincena='+cmbQuincena.getValue()+'&nQuincenas='+txtNQuincenas.getValue(),true);

                                                                        
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

function funcCicloSelect(combo,registro)
{
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
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=46&ciclo='+registro.get('id'),true);
    
}

function mostrarVentanaCuenta(iC)
{
	
	var gridCuenta=generarGridCuenta();
    var cmbTipoAfectacion=crearComboExt('cmbTipoAfectacion',arrTipoAfectacion,115,355);
    cmbTipoAfectacion.setValue('1');
    function aceptarClick()
    {
    	var filaTDoc=gridCuenta.getSelectionModel().getSelections();
        if(filaTDoc.length==0)
        {
            msgBox('Primero debe seleccionar una cuenta');
            return;
        }
        var x;
        var cadCuentas='';
        for(x=0;x<filaTDoc.length;x++)
        {
        	if(cadCuentas=='')
		      	cadCuentas=filaTDoc[x].get('idCuenta')+'|'+filaTDoc[x].get('cuenta');
            else
	        	cadCuentas+=','+filaTDoc[x].get('idCuenta')+'|'+filaTDoc[x].get('cuenta');
        }
        	
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            	Ext.getCmp('ventanaCta').close();
                recargarPagina2();
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=152&idConcepto='+iC+'&tipo='+tC+'&cadCuentas='+cadCuentas+'&tAfectacion='+cmbTipoAfectacion.getValue(),true);
        
        
            

    }
    gridCuenta.on('rowdblclick',function()
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
                                                        gridCuenta,
                                                        {
                                                        	html:'Tipo afectaci&oacute;n:',
                                                            x:10,
                                                            y:360
                                                        },
                                                        cmbTipoAfectacion
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	
                                        id:'ventanaCta',
										title: 'Cuentas',
										width: 635,
										height:470,
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
	
    gridCuenta.getStore().load({params:{funcion:48,idConsulta:iC,accion:1}});                             
	ventanaAM.show();	
}

function generarGridCuenta()
{
    var alDatos = new Ext.data.JsonStore	(
                                                        {
                                                            root: 'registros',
                                                            totalProperty: 'numReg',
                                                            idProperty: 'codigo',
                                                            fields:	[
                                                            			{name: 'idCuenta'},
                                                                        {name: 'cuenta'},
		                                                                {name: 'estructura'}
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
                                                                           	dataIndex:'cuenta' 
																		},
                                                                        {
                                                                            type:'string',
                                                                           	dataIndex:'estructura' 
																		}
                                                        			]
                                                    }
                                                ); 
    var chkRow=new Ext.grid.CheckboxSelectionModel();
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
                                                        chkRow,
														{
															header:'Cuenta',
															width:100,
															sortable:true,
															dataIndex:'cuenta'
														},
                                                        {
															header:'Estructura',
															width:400,
															sortable:true,
															dataIndex:'estructura'
														}
														
													]
												);
                                                
	var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridCuentas',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:300,
                                                            width:580,
                                                            sm:chkRow,
                                                            plugins: filters
                                                            
                                                        }
                                                    );
	return 	tblGrid;
}

function modificarTipoAfectacion(id)
{
	var idControl='';
	
    idControl='afectacionTipoCta_'+bD(id);
    
	var valor=gE(idControl).innerHTML;
    var tAfectacion='2';
    if(valor=='Debe')
    	tAfectacion='1';
    var cmbTipoAfectacion=crearComboExt('cmbTipoAfectacion',arrTipoAfectacion,130,5);
    cmbTipoAfectacion.setValue(tAfectacion);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de afectaci&oacute;n:'
                                                        },
                                                       cmbTipoAfectacion
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	
										title: 'Tipo de afectaci&oacute;n',
										width: 330,
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
                                                                	
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gE(idControl).innerHTML=cmbTipoAfectacion.getRawValue();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=154&id='+id+'&valor='+cmbTipoAfectacion.getValue()+'&tipo=1',true);
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

function eliminarCuenta(id,iC)
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
                	
                	var fila=gE('fila_'+bD(iC)+'_'+bD(id));
                    fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=153&id='+id,true);

        }
    }
    msgConfirm('Est&aacute; seguro de querer remover la cuenta seleccionada y su configuraci&oacute;n',resp)
}

function modficarPorcentaje(id)
{
	var idControl='';
	
    idControl='afectacionCta_'+bD(id);
    
	var valor=gE(idControl).innerHTML;
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Porcentaje:'
                                                        },
                                                        {
                                                        	x:100,
                                                            y:5,
                                                            width:100,
                                                        	xtype:'numberfield',
                                                            allowDecimals:true,
                                                            id:'txtPorcentaje',
                                                            value:valor
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	
										title: 'Porcentaje de afectaci&oacute;n',
										width: 250,
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
                                                                	Ext.getCmp('txtPorcentaje').focus(true,1000);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var porcentaje=Ext.getCmp('txtPorcentaje').getValue();
                                                                        if(porcentaje=='')
                                                                        {
                                                                        	function respP()
                                                                            {
                                                                            	Ext.getCmp('txtPorcentaje').focus();
                                                                                return;
                                                                            }
                                                                            msgBox('El valor ingresado no es v&aacute;lido',respP);
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gE(idControl).innerHTML=porcentaje;
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=154&id='+id+'&valor='+porcentaje+'&tipo=2',true);
                                                                        
                                                                        
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

function removerConcepto(iC)
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
                	recargarPagina2();
                    
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=155&idConcepto='+iC+'&tipo='+tC,true);

        }
    }
    msgConfirm('Est&aacute; seguro de querer remover la '+tipoSingular+' seleccionada',resp);
}

function recargarPagina2()
{
	gE('frmActualizar').submit();
}