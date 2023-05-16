<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$idProceso=base64_decode($_GET["proc"]);
	$consulta="select numEtapa,nombreEtapa from 4037_etapas where idProceso=".$idProceso;
	
	$arrEtapas=uEJ($con->obtenerFilasArreglo($consulta));
	
	
	
?>




var arrEtapas=<?php echo $arrEtapas?>;
var arrNinguna=['0','Ninguna'];
arrEtapas.push(arrNinguna);






function agregarCampo(et)
{
	var idProceso=gE('idProceso').value;
	var arrCampos=[];
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
                                                            html:'Seleccione los campos a agregar:'
                                                        },
                                                        gridCampos
													]
										}
									);
	
	var ventanaCampo = new Ext.Window(
									{
                                    	
										title: 'Agregar campos',
										width: 530,
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
															id:'btnAceptar',
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var filas=gridCampos.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar al menos un campos para agregar a la etapa');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var x;
                                                                        var etapa=et;
                                                                        var idProceso=gE('idProceso').value;
                                                                        var id;
                                                                        var tipo;
                                                                        var cadCampos='';
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	id=filas[x].get('idControl');
                                                                            
                                                                            
                                                                            if(cadCampos=='')
                                                                            	cadCampos=id;
                                                                            else
                                                                            	cadCampos+=','+id;
                                                                        }
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	ventanaCampo.close();
                                                                                recargarPagina();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=119&idProceso='+idProceso+'&numEtapa='+etapa+'&cadCampos='+cadCampos,true);
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaCampo.close();
																	}
														}
													]
									}
								);
	obtenerCamposDisponibles(et,idProceso,ventanaCampo,gridCampos.getStore());
}

function crearGridCampos()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idControl'},
                                                                {name: 'campo'},
                                                                {name: 'formulario'} //1 rol; 2 comite
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
															header:'Campo',
															width:200,
															sortable:true,
															dataIndex:'campo'
														},
                                                        {
                                                        	header:'Formulario',
															width:200,
															sortable:true,
															dataIndex:'formulario'
                                                        }
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridCampos',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:490,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;
}

function obtenerCamposDisponibles(etapa,idProceso,ventanaAM,almacen)
{
	
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var datos=eval(arrResp[1]);
            almacen.loadData(datos);
        	ventanaAM.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=118&idProceso='+idProceso+'&numEtapa='+etapa,true);
}

function removerActor(idActor)
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
                    var fila=gE('filaActor_'+idActor);
                    fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=49&idActorProcesoEtapa='+idActor,true);
        }
   }

   msgConfirmWin('Est&aacute; seguro de querer remover a este actor?',resp,330,120);
}

function mostrarVentanaCuenta(idCampo,tipo)
{
	var gridCuenta=generarGridCuenta();
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
		      	cadCuentas=filaTDoc[x].get('codigoCompletoCta')+'|'+filaTDoc[x].get('codigoSimple');
            else
	        	cadCuentas+=','+filaTDoc[x].get('codigoCompletoCta')+'|'+filaTDoc[x].get('codigoSimple');
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
        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=120&tipo='+tipo+'&cadCuentas='+cadCuentas+'&idCampo='+idCampo,true);
        
        
            

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
                                                        gridCuenta
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	
                                        id:'ventanaCta',
										title: 'Cuentas',
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
	
    gridCuenta.getStore().load({params:{funcion:43}});                             
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
                                                                        {name: 'codigoCompletoCta'},
		                                                                {name: 'tituloCta'},
                                                                        {name: 'codigoSimple'},
                                                                        {name: 'tipoCta'}
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
                                                                           	dataIndex:'codigoCompletoCta' 
																		},
                                                                        {
                                                                            type:'string',
                                                                           	dataIndex:'tituloCta' 
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
															dataIndex:'codigoCompletoCta'
														},
                                                        {
															header:'Nombre Cta.',
															width:400,
															sortable:true,
															dataIndex:'tituloCta'
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

function modficarPorcentaje(tipo,id)
{
	var idControl='';
	if(tipo==1)
    	idControl='afectacionCta_'+id;
    else
    	idControl='afectacionContraCta_'+id;
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
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=121&tipo='+tipo+'&id='+id+'&valor='+porcentaje,true);
                                                                        
                                                                        
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