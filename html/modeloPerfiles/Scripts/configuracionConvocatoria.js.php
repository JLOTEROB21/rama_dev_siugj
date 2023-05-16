<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$idProceso=base64_decode($_GET["proc"]);
	$consulta="select idNivelInsvestigador,nivel,abreviatura from 9007_nivelInvestigador order by nivel";
	$arrNiveles=uEJ($con->obtenerFilasArreglo($consulta));
?>

function agregarAnio()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														{
                                                        	x:40,
                                                            y:10,
                                                        	html:'De:',
                                                            xtype:'label'
                                                        },
                                                        {
                                                        	id:'txtAnioDe',
                                                        	xtype:'datefield',
                                                            x:100,
                                                            y:5,
                                                            format:'d/m/Y'
                                                        },
                                                        {
                                                        	x:40,
                                                            y:35,
                                                        	html:'Hasta:',
                                                            xtype:'label'
                                                        },
                                                        {
                                                        	id:'txtAnioHasta',
                                                        	xtype:'datefield',
                                                            x:100,
                                                            y:30,
                                                            format:'d/m/Y'
                                                            
                                                        }
                                                        

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Especificar periodo',
										width: 280,
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
                                                                	
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var anioI=Ext.getCmp('txtAnioDe').getValue();
																		if(anioI=='')
                                                                        {
                                                                        	function respAnioI()
                                                                            {
                                                                            	Ext.getCmp('txtAnioDe').focus();
                                                                            }
                                                                        	msgBox('La fecha de inicio de periodo es obligatorio');
                                                                        	return;
                                                                        }
                                                                        var anioF=Ext.getCmp('txtAnioHasta').getValue();
																		if(anioF=='')
                                                                        {
                                                                        	function respAnioF()
                                                                            {
                                                                            	Ext.getCmp('txtAnioHasta').focus();
                                                                            }
                                                                        	msgBox('La fecha de fin de periodo es obligatorio');
                                                                        	return;
                                                                        }
                                                                        if(anioI>anioF)
                                                                        {
                                                                        	msgBox('La fecha de inicio no puede ser mayor a la fecha de fin del periodo');
                                                                        	return;
                                                                        }
                                                                        var idProceso=gE('idProceso').value;
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	ventanaAM.close();
                                                                            	recargarPagina();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=209&idProceso='+idProceso+'&fechaI='+anioI.format('Y-m-d')+'&fechaF='+anioF.format('Y-m-d'),true);
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

function agregarTipo(padre,idCtrl)
{
	var gridTipos=crearGridTipos();
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
                                                            html:'Seleccione los valores que desea agregar:'
                                                        },
                                                        gridTipos
                                                        
														

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar elemento',
										width: 345,
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
                                                                    	var filas=gridTipos.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Al menos debe seleccionar un elemento para agregar');
                                                                            return;
                                                                        }
                                                                        var x;
                                                                        var arrObj='';
                                                                        var cadObj;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	cadObj='{"idElemento":"'+filas[x].get('idValor')+'","tipo":"2","compl":""}';
                                                                        	if(arrObj=='')
                                                                            	arrObj=cadObj;
                                                                            else
                                                                            	arrObj+=','+cadObj;
                                                                        }
																		var obj='{"padre":"'+padre+'","elementos":['+arrObj+']}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	ventanaAM.close();
                                                                            	recargarPagina();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=207&obj='+obj,true);
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
	llenarValoresGridTipo(ventanaAM,idCtrl);                                
}

function llenarValoresGridTipo(ventana,idCtrl)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            Ext.getCmp('gridTipo').getStore().loadData(arrDatos);
        	ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=109&idControl='+idCtrl,true);
}

function crearGridTipos()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idValor'},
                                                                {name: 'valor'}
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
															header:'Tipo',
															width:200,
															sortable:true,
															dataIndex:'valor'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridTipo',
                                                            x:10,
                                                            y:40,
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:300,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
}

function agregarParticipacion(padre,idPerfil)
{
	var gridParticipacion=crearGridParticipaciones();
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
                                                            html:'Seleccione las participaciones que desea agregar:'
                                                        },
                                                        gridParticipacion
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Participaci&oacute;n',
										width: 345,
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
                                                                    	var filas=gridParticipacion.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Al menos debe seleccionar un elemento para agregar como valor de participaci&oacute;n');
                                                                            return;
                                                                        }
                                                                        var x;
                                                                        var arrObj='';
                                                                        var cadObj;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	cadObj='{"idElemento":"'+filas[x].get('idParticipacion')+'","tipo":"4","compl":""}';
                                                                        	if(arrObj=='')
                                                                            	arrObj=cadObj;
                                                                            else
                                                                            	arrObj+=','+cadObj;
                                                                        }
																		var obj='{"padre":"'+padre+'","elementos":['+arrObj+']}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	ventanaAM.close();
                                                                            	recargarPagina();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=207&obj='+obj,true);
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
    
	llenarValoresGridParticipaciones(ventanaAM,idPerfil);                                
}

function crearGridParticipaciones()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idParticipacion'},
                                                                {name: 'participacion'}
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
															header:'Participaci&oacute;n',
															width:200,
															sortable:true,
															dataIndex:'participacion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridParticipacion',
                                                            x:10,
                                                            y:40,
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:300,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
}

function llenarValoresGridParticipaciones(ventana,idPerfil)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            Ext.getCmp('gridParticipacion').getStore().loadData(arrDatos);
        	ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=208&idPerfil='+idPerfil,true);
}

function agregarNivel(padre,idCtrl)
{
	var gridTipos=crearGridTipos();
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
                                                            html:'Seleccione los valores que desea agregar:'
                                                        },
                                                        gridTipos
                                                        
														

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar elemento',
										width: 345,
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
                                                                    	var filas=gridTipos.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Al menos debe seleccionar un elemento para agregar');
                                                                            return;
                                                                        }
                                                                        var x;
                                                                        var arrObj='';
                                                                        var cadObj;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	cadObj='{"idElemento":"'+filas[x].get('idValor')+'","tipo":"3","compl":""}';
                                                                        	if(arrObj=='')
                                                                            	arrObj=cadObj;
                                                                            else
                                                                            	arrObj+=','+cadObj;
                                                                        }
																		var obj='{"padre":"'+padre+'","elementos":['+arrObj+']}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	ventanaAM.close();
                                                                            	recargarPagina();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=207&obj='+obj,true);
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
	llenarValoresGridTipo(ventanaAM,idCtrl);                                
}

function guardarValorElemento(idValor,valor)
{
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
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=210&idValor='+idValor+'&valor='+valor,true);

}

function guardarPonderacion(ctrl)
{
	if(ctrl.value=='')
    	ctrl.value=0;
    guardarValorElemento(ctrl.id,ctrl.value);
}

function guardarConjuncion(ctrl)
{
	var valor='0';
	if(ctrl.checked)
    	valor='1';
    guardarValorElemento(ctrl.id,valor);
}

function agregarInv(padre)
{
	var invC=gE('invC').value;
    var invNC=gE('invNC').value;
    var arrSituacion=new Array();
    if(invC=='1')
    	arrSituacion.push(['1','Calificado']);
    if(invNC=='1')
    	arrSituacion.push(['2','No Calificado']);
    
    if(arrSituacion.length==2)
    	arrSituacion.push(['3','Ambos']);
    
    
	var gridNivelInv=crearGridNivelesInv();
    var cmbSituacion=crearComboExt('cmbSituacion',arrSituacion,80,315);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione el nivel del investigador a agregar:'
                                                        },
														gridNivelInv,
                                                        {
                                                        	x:10,
                                                            y:320,
                                                            html:'Situaci&oacute;n:'
                                                        },
                                                        cmbSituacion
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Nivel de investigador',
										width: 500,
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
																		var filas=gridNivelInv.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Al menos debe seleccionar un nivel de investigador a agregar');
                                                                            return;
                                                                        }
                                                                        var x;
                                                                        var cadFilas='';
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	if(cadFilas=='')
                                                                            	cadFilas=filas[x].get('idNivel');
                                                                            else
	                                                                            cadFilas+=','+filas[x].get('idNivel');
                                                                        }
                                                                        
                                                                        if(cmbSituacion.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe indicar la situaci&oacute;n del nivel a agregar');
                                                                            return;
                                                                        }
                                                                        var situacion=cmbSituacion.getValue();
                                                                        if(situacion=='3')
                                                                        	situacion='1,2';
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	ventanaAM.close();
                                                                            	recargarPagina();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=211&situacion='+situacion+'&niveles='+cadFilas+'&padre='+padre,true);
                                                                        
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

function crearGridNivelesInv()
{
	var dsDatos=<?php echo $arrNiveles?>;
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idNivel'},
                                                                {name: 'nivel'},
                                                                {name: 'abreviatura'}
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
															header:'Nivel investigador',
															width:250,
															sortable:true,
															dataIndex:'nivel'
														},
														{
															header:'Abreviatura',
															width:120,
															sortable:true,
															dataIndex:'abreviatura'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            x:10,
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:650,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;		
}