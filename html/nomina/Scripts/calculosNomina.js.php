<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$tipoConsulta=1;
	$idUsuario=bD($_GET["idUsuario"]);
	$consulta="select ciclo,ciclo from 550_cicloFiscal where ciclo in (select ciclo from 655_fechasNomina  where situacion=1) order by ciclo";
	$arrCiclos=uEJ($con->obtenerFilasArreglo($consulta));
	$tSingular="c&aacute;lculo";
	$tPlural="calculos";
	$consulta="select id__216_tablaDinamica,txtBeneficiario from _216_tablaDinamica order by txtBeneficiario";
	$arrBeneficiarios=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select id__217_tablaDinamica,txtBeneficiario from _217_tablaDinamica  where idReferencia=".$idUsuario." order by txtBeneficiario";
	$arrBeneficiariosInd=uEJ($con->obtenerFilasArreglo($consulta));
	$arrBeneficiariosInd=substr($arrBeneficiariosInd,1);
	$arrBeneficiariosInd="[['0','Empleado en cuesti\xF3n'],".$arrBeneficiariosInd;
	
	
	
?>
var benGlobales=<?php echo $arrBeneficiarios?>;
var benPersonal=<?php echo $arrBeneficiariosInd?>;
var tipoSingular='<?php echo $tSingular?>';
var tipoPlural='<?php echo $tPlural?>';
var iU=<?php echo $idUsuario?>;

var arrTipoAfectacion=[['1','Debe'],['2','Haber']];
var tC;

Ext.onReady(inicializar);

function inicializar()
{
	tC=bD(gE('tipoConcepto').value);
}
var arrTipo=[['0','C\xE1lculo auxiliar'],['1','Deducci\xF3n'],['2','Percepci\xF3n']];
var arrTipoBeneficiario=[['1','Individual'],['2','Global']];

function agregarConcepto()
{
	var idUsuario=gE('idUsuario').value;
	var tipoConcepto=gE('tipoConcepto').value;
    var cmbTipoCalculo=crearComboExt('cmbTipoCalculo',arrTipo,110,5);
    cmbTipoCalculo.on('select',funcTipoCalculoSelect);
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
                                                            html:'Tipo de c&aacute;lculo:'
                                                        },
                                                        cmbTipoCalculo
                                                        ,
														{
                                                        	x:10,
                                                            y:40,
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
                                                                            	recargarPagina();	
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=49&listConceptos='+listDeduc+'&tipo='+cmbTipoCalculo.getValue()+'&idUsuario='+idUsuario+'&idPerfil='+gE('idPerfil').value,true);
                                                                        
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
    //llenarGridConceptos(ventanaAM,gridConcepto);
}

function funcTipoCalculoSelect(combo,registro)
{
	var idUsuario=gE('idUsuario').value;
    var tC=registro.get('id');
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            var gridConcepto=gEx('gridDeduccionPercepcion');
            gridConcepto.getStore().loadData(arrDatos);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=53&tipo='+tC+'&idUsuario='+idUsuario+'&idPerfil='+gE('idPerfil').value,true);
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
                                                        	id:'gridDeduccionPercepcion',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:70,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:650,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;		
}

function actualizaAfectacion(check)
{
	var accion='-1';
	if(check.checked)
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
                recargarPagina();
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
                                                        	html:'Seleccione la cuenta a afectar:',
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
															width:180,
															sortable:true,
															dataIndex:'cuenta'
														},
                                                        {
															header:'Estructura',
															width:320,
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
                                                            loadMask:true,
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
    msgConfirm('Est&aacute; seguro de querer remover el '+tipoSingular+' seleccionado',resp);
}

function recargarPagina2()
{
	gE('frmActualizar').submit();
}

function modificarBeneficiario(iC)
{
	if(iU==-1)
    	mostrarVentanaBeneficiarioSimple(iC);
    else
    	mostrarVentanaBeneficiarioComplejo(iC);
}

function mostrarVentanaBeneficiarioSimple(iC)
{
	
	var gridBeneficiarios=crearGridBeneficiarios();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridBeneficiarios

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de beneficiario',
										width: 380,
										height:400,
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
																		var filas=gridBeneficiarios.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar el beneficiario a asignar');
                                                                            return;
                                                                        }
                                                                        
                                                                        var tipoBeneficiario=2;
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gE('lblBeneficiario_'+bD(iC)).innerHTML=filas[0].get('beneficiario');	
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=157&idAfectacion='+iC+'&idBeneficiario='+filas[0].get('idBeneficiario')+'&tipo='+tipoBeneficiario,true);
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

function mostrarVentanaBeneficiarioComplejo(iC)
{
	var cmbTipoBeneficiario=crearComboExt('cmbTipoBeneficiario',arrTipoBeneficiario,130,5);
    cmbTipoBeneficiario.on('select',funcTipoBeneficiarioChange);
	var gridBeneficiarios=crearGridBeneficiarios();
    gridBeneficiarios.setPosition(10,40);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	html:'Tipo de beneficiario:',
                                                            x:10,
                                                            y:10
                                                        },
                                            			cmbTipoBeneficiario,
														gridBeneficiarios

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de beneficiario',
										width: 380,
										height:400,
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
																		var filas=gridBeneficiarios.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar el beneficiario a asignar');
                                                                            return;
                                                                        }
                                                                        
                                                                        var tipoBeneficiario=cmbTipoBeneficiario.getValue();
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gE('lblBeneficiario_'+bD(iC)).innerHTML=filas[0].get('beneficiario');	
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=157&idAfectacion='+iC+'&idBeneficiario='+filas[0].get('idBeneficiario')+'&tipo='+tipoBeneficiario,true);
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

function crearGridBeneficiarios()
{
	var dsDatos=[];
    if(iU==-1)
    	dsDatos=benGlobales;
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idBeneficiario'},
                                                                {name: 'beneficiario'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Beneficiario',
															width:250,
															sortable:true,
															dataIndex:'beneficiario'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridBeneficiario',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:280,
                                                            width:350,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
}

function funcTipoBeneficiarioChange(combo,registro)
{
	var gridBeneficiario=gEx('gridBeneficiario');
	if(registro.get('id')=='1')
    	gridBeneficiario.getStore().loadData(benPersonal);
    else
    	gridBeneficiario.getStore().loadData(benGlobales);
}

function modificarValorParametro(iC,iP,o)
{
	
	var arrTiposValor;
    if(iU==-1)
	    arrTiposValor=[['21','Acumulador'],['1','Constante'],['2','Resultado deducci\xF3n'],['3','Resultado percepci\xF3n']];
    else
    	arrTiposValor=[['21','Acumulador'],['1','Constante'],['2','Resultado deducci\xF3n global'],['3','Resultado percepci\xF3n global'],['4','Resultado deducci\xF3n individual'],['5','Resultado percepci\xF3n individual']];
	var cmbTipoValor=crearComboExt('cmbTipoValor',arrTiposValor,100,5,310);
    cmbTipoValor.setValue('1');
    function cmbTipoValorChange(combo,registro)
    {
    	switch(registro.get('id'))
        {
        	case '1':
            	gEx('txtValor').show();
                gEx('txtValor').focus();
                gEx('cmbValor').hide()
            break;
            case '21':
            	gEx('txtValor').setValue('');
                gEx('txtValor').hide();
                gEx('cmbValor').show()
            	var cmbValor=gEx('cmbValor');
                cmbValor.getStore().loadData(eval(gE('arrAcumuladores').value));
            break;
            default:
            	gEx('txtValor').setValue('');
                gEx('txtValor').hide();
                gEx('cmbValor').show()
                function funcAjax()
                {
                    var resp=peticion_http.responseText;
                    arrResp=resp.split('|');
                    if(arrResp[0]=='1')
                    {
                        var cmbValor=gEx('cmbValor');
                        var arrDatos=eval(arrResp[1]);
                        cmbValor.getStore().loadData(arrDatos);
                    }
                    else
                    {
                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                    }
                }
                obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=57&idUsuario='+iU+'&orden='+o+'&tipo='+registro.get('id'),true);
            break;
        
        }
        
    }
    cmbTipoValor.on('select',cmbTipoValorChange);
    var cmbValor=crearComboExt('cmbValor',[],100,35,310);
    cmbValor.hide();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de valor:'
                                                        },
                                                        cmbTipoValor,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Valor:'
                                                        },
                                                        cmbValor,
                                                        {
                                                        	id:'txtValor',
                                                            x:100,
                                                            y:35,
                                                            width:80,
                                                            xtype:'textfield',
                                                            hidden:false
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar par&aacute;metro',
										width: 480,
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
																		var tipo=cmbTipoValor.getValue();
                                                                        var txtValor=gEx('txtValor');
                                                                        var valor;
                                                                        var tipoParametro=1;
                                                                        var valorMostrar='';
                                                                        if(tipo=='1')
                                                                        {
                                                                        	if(txtValor.getValue()=='')
                                                                            {
                                                                            	function resp()
                                                                                {
                                                                                	txtValor.focos();
                                                                                }
                                                                            	msgBox('El valor ingresado no es v&aacute;lido',resp);
                                                                            	return;
                                                                            }
                                                                            valor=txtValor.getValue();
                                                                            valorMostrar=valor;
                                                                        }
                                                                        else
                                                                        {
                                                                        	if(tipo=='21')
                                                                            {
                                                                            	if(cmbValor.getValue()=='')
                                                                                {
                                                                                    msgBox('Debe seleccionar el acumulador que funcionar&aacute; como par&aacute;metro');
                                                                                    return;
                                                                                }
                                                                                valor=cmbValor.getValue();
                                                                                valorMostrar=cmbValor.getRawValue();
                                                                                tipoParametro=21;
                                                                            }
                                                                            else
                                                                            {
                                                                                tipoParametro=2;
                                                                                if(cmbValor.getValue()=='')
                                                                                {
                                                                                    msgBox('Debe seleccionar la opci&oacute;n que funcionar&aacute; como par&aacute;metro');
                                                                                    return;
                                                                                }
                                                                                valor=cmbValor.getValue();
                                                                                valorMostrar=cmbValor.getRawValue();
                                                                            }
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gE('lblValor_'+bD(iC)+'_'+bD(iP)).innerHTML=valorMostrar;
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=58&tipoParam='+tipoParametro+'&valor='+valor+'&idConsulta='+iC+'&idParam='+iP,true);
                                                                        
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

function modificarOrdenCalculo(o,iC,mv)
{
	var x;
    var arrParam=new Array();
    var obj;
    for(x=1;x<=mv;x++)
    {
    	if(x!=o)
        {
            obj=new Array();
            obj.push(x);
            obj.push(x);
            arrParam.push(obj);
        }
    }
    var cmbOrden=crearComboExt('cmbOrden',arrParam,125,5,110);
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Orden de c&aacute;lculo:'
                                                        },
                                                        cmbOrden

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Seleccione el orden en que se ejecutar&aacute; el c&aacute;lculo',
										width: 350,
										height:120,
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
																		
                                                                        if(cmbOrden.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar el orden en el cual se llevar&aacute; a cabo el c&aacute;lculo');
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
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=59&idUsuario='+iU+'&idCalculo='+iC+'&orden='+cmbOrden.getValue(),true);
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



function modificarTipoRecurso(combo)
{
	var idCombo=combo.id;
    datosCombo=idCombo.split("_");
    iC=datosCombo[1];
    tR=obtenerValorSelect(combo);
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
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=158&idCuenta='+iC+'&tipoPresupuesto='+tR,true);
}

function agregarAcumulador()
{
	
	var gridAcumuladores=crearGridAcumuladores();
    gridAcumuladores.getStore().loadData(eval(gE('arrAcumuladores').value));
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridAcumuladores

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Adminitraci&oacute;n de acumuladores',
										width: 400,
										height:360,
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

function crearGridAcumuladores()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                        			{name: 'idAcumulador'},
                                                                    {name: 'nomAcumulador'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Acumulador',
															width:250,
															sortable:true,
															dataIndex:'nomAcumulador'
														}													
                                                   ]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'tblGridAcumulador',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:360,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	id:'btnAddAcumulador',
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar acumulador',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarAcumulor('-1');
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	id:'btnDelAcumulador',
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover acumulador',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el acumulador a remover');
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
                                                                                                        recargarPagina();	   
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=69&idAcumulador='+fila.get('idAcumulador'),true);
                                                                                                    
                                                                                            
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el acumulador seleccionado?',resp)
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;		
}

function mostrarVentanaAgregarAcumulor(idAcumulador)
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
                                                        	xtype:'label',
                                                            html:'Nombre de acumulador:'
                                                            
                                                        },
                                                        {
                                                        	x:150,
                                                            y:5,
                                                        	xtype:'textfield',
                                                            id:'txtNomAcumulador',
                                                            width:240
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Acumuladores',
										width: 450,
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
                                                                	gEx('txtNomAcumulador').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var nAcumulador=gEx('txtNomAcumulador');
                                                                        var nivelAcumulador=0;
                                                                        
                                                                        if(nAcumulador.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	nAcumulador.focus();
                                                                            }
                                                                            msgBox('Debe indicar el nombre del acumulador',resp);
                                                                            return;
                                                                        }
                                                                        
																		function funcAjax()
                                                                        {
                                                                        	
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                             	gEx('tblGridAcumulador').getStore().loadData(eval(arrResp[1]));
                                                                                gE('arrAcumuladores').value=arrResp[1];
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=68&idPerfil='+gE('idPerfil').value+'&idUsuario=NULL&nAcumulador='+cv(nAcumulador.getValue())+'&idAcumulador='+idAcumulador+'&nivelAcumulador='+nivelAcumulador,true);
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

function asignarAcumulador(iC)
{
	var arrOperaciones=[['=','='],['+','+'],['-','-'],['*','x'],['/','/']];
	var cmbOperacion=crearComboExt('cmbOperacion',arrOperaciones,110,5,115);
	var gridAcumuladores=crearGridAcumuladores();
    gridAcumuladores.setPosition(10,40);
    gridAcumuladores.getStore().loadData(eval(gE('arrAcumuladores').value));
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
                                                            html:'Operaci&oacute;n:'
                                                        },
                                                        cmbOperacion,
														gridAcumuladores

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Adminitraci&oacute;n de acumuladores',
										width: 400,
										height:360,
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
															handler:function()
																	{
                                                                    	if(cmbOperacion.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbOperacion.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar la operaci&oacute;n a realizar sobre el acumulador',resp);
                                                                            return;
                                                                            
                                                                        }
																		var fila=gridAcumuladores.getSelectionModel().getSelected();
                                                                        if(fila==null)
                                                                        {
                                                                        	msgBox('Debe seleccionar el acumulador a emplear');
                                                                            return;
                                                                        
                                                                        }
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
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=70&idCalculo='+bD(iC)+'&idAcumulador='+fila.get('idAcumulador')+'&operacion='+cv(cmbOperacion.getValue()),true);
                                                                        
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
    gEx('btnAddAcumulador').hide();
    gEx('btnDelAcumulador').hide();
}

function removerAsignacionAcum(iA)
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
                    var fila=gE('fila_'+bD(iA));
                    fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=71&idAcumulador='+bD(iA),true);
                    }
    }
    msgConfirm('Est&aacute; seguro de querer remover la asignaci&oacute;n del acumulador',resp)
}

function agregarPuestoCalculo(iC,c)
{ 
	var gridPuestosCalculo=crearGridPuestosCalculo(iC);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Puestos a considerar para aplicar el calculo: "'+bD(c)+'"'
                                                        },
                                                        gridPuestosCalculo

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Puestos asociados al c&aacute;lculo',
										width: 480,
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
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	llenarPuestosAsociadosCalculo(gridPuestosCalculo.getStore(),ventanaAM,iC);                                

}

function llenarPuestosAsociadosCalculo(almacen,ventana,iC)
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
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=62&idCalculo='+bD(iC),true);
    

}

function crearGridPuestosCalculo(iC)
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idPuestoVSCalculo'},
                                                                    {name: 'cvePuesto'},
                                                                    {name: 'puesto'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:30}),
														chkRow,
														{
															header:'Clave Puesto',
															width:100,
															sortable:true,
															dataIndex:'cvePuesto'
														},
														{
															header:'Puesto',
															width:250,
															sortable:true,
															dataIndex:'puesto'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                         	id:'gridPuestoAsoc',   
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:450,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar puesto',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaPuestosDisponibles(iC);
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover puesto',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el puesto que desea remover para la aplicaci&oacute;n del c&aacute;lculo');
                                                                                            return;
                                                                                        }
                                                                                        var listDel=obtenerListadoArregloFilas(filas,'idPuestoVSCalculo');
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
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=74&listPuesto='+listDel,true);
                                                                                                

                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover los puestos seleccionados?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;		
}

function mostrarVentanaPuestosDisponibles(iC)
{ 
	var gridPuestosCalculoDisponibles=crearGridPuestosCalculosDisponibles();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														
                                                        gridPuestosCalculoDisponibles

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Puestos asociados al c&aacute;lculo',
										width: 480,
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
																		var filas=gridPuestosCalculoDisponibles.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar al menos un puesto para aplicar el c&aacute;lculo');
                                                                            return;
                                                                        }
                                                                        
                                                                        var listaPuestos=obtenerListadoArregloFilas(filas,'idPuesto');
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gridPuestoAsoc').getStore().loadData(eval(arrResp[1]));
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=73&listaPuestos='+listaPuestos+'&idCalculo='+bD(iC),true);
                                                                        
                                                                        
                                                                        
                                                                        
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
	llenarPuestosDisponiblesAsociadosCalculo(gridPuestosCalculoDisponibles.getStore(),ventanaAM,iC);                                

}

function crearGridPuestosCalculosDisponibles()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idPuesto'},
                                                                    {name: 'cvePuesto'},
                                                                    {name: 'puesto'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:30}),
														chkRow,
														{
															header:'Clave Puesto',
															width:100,
															sortable:true,
															dataIndex:'cvePuesto'
														},
														{
															header:'Puesto',
															width:250,
															sortable:true,
															dataIndex:'puesto'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridPuestosDisponibles',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:450,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;		
}

function llenarPuestosDisponiblesAsociadosCalculo(almacen,ventana,iC)
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
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=63&idCalculo='+bD(iC),true);
    

}

function seleccionarTodos(iC)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrChk=gEN('chk_'+bD(iC));
            var x;
            for(x=0;x<arrChk.length;x++)
            {
                arrChk[x].checked=true;
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=65&iC='+bD(iC),true);
}

function modificarEscenario()
{
	var idPerfil=gE('idPerfil').value;
    var arrParam=[['idPerfil',idPerfil]];
    enviarFormularioDatos('../nomina/escenarioNomina.php',arrParam);
}

