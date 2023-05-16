<?php session_start();
	include("configurarIdiomaJS.php");
	$idProceso=bD($_GET["iD"]);
	$consulta="select idTipoProceso,tipoProceso from 921_tiposProceso where idTipoProceso not in (select idTipoProceso from 921_tiposProceso where procesoNormal=0) order by tipoProceso";
	$arrTiposProc=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT numEtapa, nombreEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." order by numEtapa";
	$resEt=$con->obtenerFilas($consulta);
	$arrObj="";
	while($filaEt=mysql_fetch_row($resEt))
	{
		$obj="['".$filaEt[0]."','".removerCerosDerecha($filaEt[0]).".- ".$filaEt[1]."']";
		if($arrObj=="")
			$arrObj=$obj;
		else
			$arrObj.=",".$obj;
	}
	$arrEt="[".uEJ($arrObj)."]";
	$consulta="SELECT idStatus,nombreStatus FROM `4005_status` WHERE idStatus<3";
	$arrStatus=$con->obtenerFilasArreglo($consulta);
	
	
	
	$consulta="SELECT idConsulta,nombreConsulta FROM 991_consultasSql WHERE tipoConsulta in (11) order by nombreConsulta";
	$arrFuncionesDisparador=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT idConsulta,nombreConsulta FROM 991_consultasSql WHERE tipoConsulta=12 ORDER BY nombreConsulta";
	$arrCalculosCondicionales=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT idTipoProceso,tipoProceso FROM 921_tiposProceso where idTipoProceso not in (1,15) ORDER BY tipoProceso";
	$arrTiposProcesos=$con->obtenerFilasArreglo($consulta);	

?>
var arrUsuarioMarcaAtendida=[['1','Usuario que ocasion\xF3 cambio de etapa'],['2','Todos los usuarios notificados']];
var arrCalculosCondicionales=<?php echo $arrCalculosCondicionales?>;
arrCalculosCondicionales.splice(0,0,['0','Ninguno']);
var arrFuncionesDisparador=<?php echo $arrFuncionesDisparador?>;
var arrFuncionesDisparadorPeriodico=new Array();
var ct;
arrFuncionesDisparadorPeriodico.push(['0','Ninguno']);
for(ct=0;ct<arrFuncionesDisparador.length;ct++)
{
	arrFuncionesDisparadorPeriodico.push(arrFuncionesDisparador[ct]);
    
}
    
var arrTareas=[['1','Reporte peri\xF3dico']];
var arrStatus=<?php echo $arrStatus?>;
function agregarParticipante()
{
	
    var gridParticipantes=crearGridParticipantes();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione los participantes que desee incluir en la etapa seleccionada:'
                                                        },
														gridParticipantes
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar participante a la etapa seleccionada',
										width: 410,
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
																		var filas=gridParticipantes.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Al meno debe seleccionar un participante a agregar');
                                                                            return;
                                                                        }
                                                                        var x;
                                                                        var participantes='';
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	if(participantes=='')
                                                                            	participantes=filas[x].get('idParticipante');
                                                                            else
                                                                            	participantes+=','+filas[x].get('idParticipante');
                                                                        }
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                Ext.getCmp('arbolParticipantes').getRootNode().reload();
                                                                                Ext.getCmp('arbolParticipantes').expandAll();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=16&idProyecto='+idProceso+'&comites='+participantes+'&numEtapa='+nodoSelParticipante.attributes.numEtapa+'&participantes=true',true);
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
	                        
	llenarDatosParticipantes(ventanaAM,gridParticipantes.getStore());
}

function crearGridParticipantes(idGridComite)
{
	var idGrid='idGridParticipantes';
	if(idGridComite!=undefined)
    	idGrid=idGridComite;
      
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idParticipante'},
                                                                {name: 'participante'}
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
															header:'Participante',
															width:250,
															sortable:true,
															dataIndex:'participante'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:idGrid,
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:350,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;
}

function llenarDatosParticipantes(ventanaAM,almacen)
{
	var idProyecto=gE('idDocumento').value;	
	function funcAjax()
	{
		var resp=peticion_http.responseText;
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
			almacen.loadData(eval(arrResp[1]));
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=12&idProyecto='+idProyecto+'&numEtapa='+nodoSelParticipante.attributes.numEtapa+'&participantes=true',true);
	ventanaAM.show();
}

function agregarCElementoDTDParticipante()
{

	var arbolSecciones=crearArbolSeccionesPart();
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
															html:'Seleccione los elementos del DTD a los que tendr&aacute; acceso el participante seleccionado:'
														},
														arbolSecciones

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Elementos DTD',
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
															id:'btnAceptar',
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var nodos=arbolSecciones.getChecked();
																		var x;
																		var listadoE='';
																		for(x=0;x<nodos.length;x++)
																		{
																			if(listadoE=='')
																				listadoE=nodos[x].id;
																			else
																				listadoE+=','+nodos[x].id;
																		}
																		
																		
																		function funcAjax()
																		{
																			var resp=peticion_http.responseText;
																			arrResp=resp.split('|');
																			if(arrResp[0]=='1')
																			{
																				var panel=Ext.getCmp('arbolParticipantes');
																				panel.getRootNode().reload();
																				panel.expandAll();
																				ventanaAM.close();
																			}
																			else
																			{
																				msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																			}
																		}
																		obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=20&idProyectoComite='+nodoSelParticipante.id+'&listadoE='+listadoE+'&participante=true',true);
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

function crearArbolSeccionesPart()
{
	var idProceso=gE('idDocumento').value;
	

	var cargadorArbol=new Ext.tree.TreeLoader(
												{
													baseParams:{
																	funcion:'168',
																	idProyecto:idProceso,
																	idProyectoParticipante:nodoSelParticipante.id
																},
													dataUrl:'../paginasFunciones/funcionesProyectos.php'
												}
											)	
	
    var raizV=new  Ext.tree.AsyncTreeNode	(
                                                  {
                                                      id:'raizVentana',
                                                      text:'',
                                                      draggable:false,
                                                      expanded :true
													  
                                                  }
                                            )
                     
    
	panelArbolV=new Ext.tree.TreePanel	(
                                                  {
												  	  x:10,
													  y:50,
                                                      id:'panelArbolVentanaParticipante',
                                                      height:300,
                                                      width:450,
                                                      useArrows:true,
                                                      autoScroll:true,
                                                      animate:true,
                                                      enableDD:true,
                                                      containerScroll: true,
                                                      root:raizV,
                                                      rootVisible:false,
                                                      draggable:false,
													  loader: cargadorArbol
                                                  }
                                          );   
    return panelArbolV;
    
}

function removerParticipante()
{
	var fila=nodoSelParticipante;
    if(fila==null)
    {
    	msgBox('Debe seleccionar el Participante/Elemento DTD a remover');
    	return;
    }
    else
    {
		var msg;
        switch(fila.attributes.tipo)
        {
        	case '0':
            	msg='&iquest;Est&aacute; seguro de querer remover el elemento de DTD seleccionado?';
            break;
            case '1':
            	msg='&iquest;Est&aacute; seguro de querer remover el participante seleccionado?';
            break;
            case '4':
            	msg='&iquest;Est&aacute; seguro de querer remover la acci&oacute;n seleccionada?';
            break;
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
						nodoSelParticipante.remove();
						nodoSelParticipante=null;
						Ext.getCmp('btnRemoverParticipante').disable();
						Ext.getCmp('btnCambiarElementoParticipante').hide();
                        gEx('btnModifEnvioEtapa').hide();

					}
					else
					{
						msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
					}
				}
				obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=169&id='+fila.id+'&tipo='+fila.attributes.tipo,true);
			}
        }
        Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>',msg,resp);
    }
}

function cambiarFuncionesParticipante(funcion)
{
	if(funcion==nodoSelParticipante.attributes.funciones)
		return;

	function funcAjax()
	{
		var resp=peticion_http.responseText;
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
			var titulo='';
			var color='';
			var texto='';
			
            switch(funcion)
            {
                case '0':
                    color='darkred';
                    texto='S&oacute;lo Ver';
                break;
                case '1':
                    color='blue';
                    texto='Ver y modificar';
                break;
            }
			
			titulo=nodoSelParticipante.attributes.tituloO+" <b>Funci&oacute;n:</b> <font color='"+color+"'><b>"+texto+"</b></font>";					
			nodoSelParticipante.setText(titulo);
			nodoSelParticipante.attributes.funciones=funcion;

		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=170&valorFuncion='+funcion+'&id='+nodoSelParticipante.id,true);
}

function agregarAccionParticipante()
{
	var idProceso=gE('idProceso').value;
	var arrActores=[];
	var gridAcciones=crearGridAccionesParticipante();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione las acciones a agregar:'
                                                        },
                                                        gridAcciones
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar acci&oacute;n',
										width: 550,
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
																		var filas=gridAcciones.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar al menos una acci&oacute;n para agregar al participante');
                                                                        	return;
                                                                        }
                                                                        var x;
                                                                        var cadAcciones='';
                                                                        var idGrupoAccion;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	idGrupoAccion=filas[x].get('idGrupoAccion');
                                                                            
                                                                            if(cadAcciones=='')
                                                                            	cadAcciones=idGrupoAccion;
                                                                            else
                                                                            	cadAcciones+=','+idGrupoAccion;
                                                                        }
                                                                        var idParticipante=nodoSelParticipante.id.split('_')[1];
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var panel=Ext.getCmp('arbolParticipantes');
																				panel.getRootNode().reload();
																				panel.expandAll();	
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=172&acciones='+cadAcciones+'&idParticipante='+idParticipante,true);
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

	obtenerAccionesParticipantesDisponibles(ventanaAM,gridAcciones.getStore());
}

function crearGridAccionesParticipante()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idGrupoAccion'},
                                                                {name: 'accion'}
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
															header:'Acci&oacute;n',
															width:410,
															sortable:true,
															dataIndex:'accion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridAccionParticipante',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:500,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;
}

function obtenerAccionesParticipantesDisponibles(ventanaAM,almacen)
{
	var idProceso=gE('idProceso').value;
    var idParticipante=nodoSelParticipante.id.split('_')[1];
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
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=171&idParticipante='+idParticipante+'&idProceso='+idProceso,true);
}

function modificarPasoEtapaParticipante()
{
	var arrEtapas=[];
    var cmbEtapas=crearComboExt('cmbEtapas',arrEtapas,260,15);
    cmbEtapas.setWidth(300);
    etAct=nodoSelParticipante.attributes.etapaActual;
  	cmbEtapas.setValue(etAct);
    var numEtapa=nodoSelParticipante.attributes.numEtapa;
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:20,
                                                            html:'Seleccione la etapa a la cual pasar&aacute; el proceso:'
                                                        },
                                                        cmbEtapas,
                                                        {
                                                        	x:10,
                                                            y:50,
                                                            html:'Etiqueta:'
                                                        },
                                                        {
                                                        	x:260,
                                                            y:45,
                                                        	xtype:'textfield',
                                                            id:'txtEtiqueta',
                                                            width:200,
                                                            value:nodoSelParticipante.attributes.nAccion
                                                            
                                                        },
                                                        {
                                                        	x:10,
                                                            y:80,
                                                            html:'Mensaje de confimaci&oacute;n:'
                                                        },
                                                        {
                                                        	x:260,
                                                            y:75,
                                                            xtype:'textarea',
                                                            id:'txtMensaje',
                                                            width:280,
                                                            height:80,
                                                            value:bD(nodoSelParticipante.attributes.msgConf)
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de etapa',
										width: 650,
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
															id:'btnAceptar',
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var numEt=cmbEtapas.getValue();
                                                                        var txtEtiqueta=gEx('txtEtiqueta');
                                                                        var txtMensaje=gEx('txtMensaje').getValue();
                                                                        if(numEt=='')
                                                                        {
                                                                        	msgBox('Debe Seleccionar la etapa a la cual pasar&aacute; el proceso');
                                                                        	return;
                                                                        }
                                                                        if(txtEtiqueta.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe ingresar la etiqueta a mostrar como opci&oacute;n');
                                                                            return;
                                                                        }
                                                                        if(txtMensaje=='')
                                                                        {
                                                                        	msgBox('Debe ingresar el mensaje mostrar para confirmar la acci&oacute;n');
                                                                            return;
                                                                        }
                                                                        
                                                                        var obj='{"etiqueta":"'+cv(txtEtiqueta.getValue())+'","msgConf":"'+cv(txtMensaje)+'"}';
                                                                        
                                                                        var idParticipante=nodoSelParticipante.id.split('_')[1];
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                var panel=Ext.getCmp('arbolParticipantes');
																				panel.getRootNode().reload();
																				panel.expandAll();
                                                                            	ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=173&idParticipante='+idParticipante+'&obj='+obj+'&numEtapa='+numEt,true);
                                                                        
                                                                        
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
                                
	obtenerEtapasDisponiblesPart(numEtapa,ventanaAM,cmbEtapas.getStore());                                

}

function obtenerEtapasDisponiblesPart(et,ventana,almacen)
{
	var idProceso=gE('idProceso').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrEt=eval(arrResp[1]);
            almacen.loadData(arrEt);
	       	ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=51&idProceso='+idProceso+'&numEtapa='+et,true);
}




function procesoRepetible(combo)
{
	var valor=combo.options[combo.selectedIndex].value;
    var idProceso=gE('idProceso').value;
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
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=177&idProceso='+idProceso+'&valor='+valor,true);

}

function vConfigurarModuloProceso()
{
	var cmbActor=crearComboExt('cmbActor',[],310,5);
    cmbActor.setWidth(260);
    var cmbResponsable=crearComboExt('cmbResponsable',[],230,35);
    cmbResponsable.setWidth(340);
    cmbResponsable.on('select',funcSelectResponsable);
    var arrMostrarReg=[['1','Aquellos dados de alta dentro del proceso padre'],['2','Aquellos definidos para el actor en el escenario de proceso vinculado']];
    var cmbMostrarRegistro=crearComboExt('cmbMostrarRegistro',arrMostrarReg,230,95);
    cmbMostrarRegistro.setWidth(340);
    var cmbCampoFormulario=crearComboExt('cmbCampoFormulario',eval(bD(gE('arrCampos').value)),230,65);
    cmbCampoFormulario.setWidth(340);
    cmbCampoFormulario.hide();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione el actor con el cual se ingresar&aacute; al proceso:'
                                                        },
                                                        cmbActor,
                                                        {
                                                        	xtype:'checkbox',
                                                            id:'chkRolesUsuario',
                                                            boxLabel:'Buscar antes roles de usuario',
                                                            x:585,
                                                            y:5
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Los nuevos registros se asociar&aacute;n con:'
                                                        },
                                                        cmbResponsable,
                                                        {
                                                        	id:'lblFormularioB',
                                                        	x:10,
                                                            y:70,
                                                            html:'Campo de formulario base:',
                                                            hidden:true
                                                        },
                                                        cmbCampoFormulario,
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'Los registros que se mostrar&aacute;n son:'
                                                        },
                                                        cmbMostrarRegistro
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configuraci&oacute;n de m&oacute;dulo de proceso',
										width: 800,
										height:230,
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
																		if(cmbActor.getValue()=='')
                                                                        {
                                                                        	function respActor()
                                                                            {
                                                                            	cmbActor.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el actor con el cual se ingresar&aacute; al proceso',respActor);
                                                                            return;
                                                                        }
                                                                        if(cmbResponsable.getValue()=='')
                                                                        {
                                                                        	function respResponsable()
                                                                            {
                                                                            	cmbResponsable.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar la figura a a la cual se asociar&aacute;n los nuevos registros',respResponsable);
                                                                            return;
                                                                        }
                                                                        var cmbCampoFormulario=gEx('cmbCampoFormulario');
                                                                        if(cmbResponsable.getValue()=='-10')
                                                                        {
                                                                        	if(cmbCampoFormulario.getValue()=='')
                                                                            {
                                                                            	function respCampoForm()
                                                                                {
                                                                                    cmbCampoFormulario.focus();
                                                                                }
                                                                                msgBox('Debe seleccionar el campo del formulario bajo el cual se asociar&aacute;n los registros',respCampoForm);
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        if(cmbMostrarRegistro.getValue()=='')
                                                                        {
                                                                        	function respMostrarReg()
                                                                            {
                                                                            	cmbMostrarRegistro.focus();
                                                                            }
                                                                            msgBox('Debe indicar los registros que se mostrar&aacute;n en la vista del proceso',respMostrarReg);
                                                                            return;
                                                                        }
                                                                        var cadComplementaria=cmbActor.getValue()+','+cmbResponsable.getValue()+','+
                                                                        						cmbMostrarRegistro.getValue()+','+cmbCampoFormulario.getValue()+
                                                                                                ','+(gEx('chkRolesUsuario').getValue()==''?0:1);
                                                                        
                                                                        
                                                                        var idElemento=nodoSel.id;
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                Ext.getCmp('arbolSecciones').getRootNode().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=182&idElemento='+idElemento+'&valor='+cadComplementaria,true);
                                                                        
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
    llenarDatosConfiguracionModuloProceso(ventanaAM);
}

function llenarDatosConfiguracionModuloProceso(ventana)
{
	var idProceso=gE('idProceso').value;
    var idElemento=nodoSel.id;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var obj=eval(arrResp[1])[0];
        	gEx('cmbResponsable').getStore().loadData(obj.opcionesAsoc);
            gEx('cmbActor').getStore().loadData(obj.opcionesActores);
            gEx('chkRolesUsuario').setValue(obj.buscarRolesUsuario=='1');
            if(obj.actor!='')
            {
            	gEx('cmbActor').setValue(obj.actor);
                gEx('cmbResponsable').setValue(obj.asocRegistro);
                if(obj.asocRegistro=='-10')
                {
                	var cmbCampoFormulario=gEx('cmbCampoFormulario');
                	cmbCampoFormulario.setValue(obj.idCampoFrm);
                    cmbCampoFormulario.show();
                    gEx('lblFormularioB').show();
                    
                }
                gEx('cmbMostrarRegistro').setValue(obj.mostrarRegistro);
                
           	}
        	ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=181&idProcesoV='+(parseInt(nodoSel.attributes.idModulo)*-1)+'&idProceso='+idProceso+'&idElemento='+idElemento,true);
}

function funcSelectResponsable(combo,registro)
{
	var idFormularioBase=gE('formularioBase').value;
	if(registro.get('id')=='-10')
    {
    	gEx('lblFormularioB').show();
        gEx('cmbCampoFormulario').show();
    }		
    else
     {
    	gEx('lblFormularioB').hide();
        gEx('cmbCampoFormulario').hide();
    }
}

function administrarTareaProgramada()
{
	var gridTareas=crearGridTareasProgramadas();
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridTareas

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Tareas programadas',
										width: 810,
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

function crearGridTareasProgramadas()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idTarea'},
                                                                {name: 'nomTarea'},
                                                                {name:  'descripcion'},
                                                                {name: 'tipoTarea'},
                                                                {name: 'formularioVinculado'}
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
															header:'Nombre de tarea',
															width:200,
															sortable:true,
															dataIndex:'nomTarea'
														},
                                                        {
                                                        	header:'Descripci&oacute;n',
															width:250,
															sortable:true,
															dataIndex:'descripcion'
                                                        },
														{
															header:'Tipo tarea',
															width:130,
															sortable:true,
															dataIndex:'tipoTarea'
														},
                                                        {
															header:'Formulario vinculado',
															width:120,
															sortable:true,
															dataIndex:'formularioVinculado'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:360,
                                                            width:780,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar nueva tarea',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaNuevaTarea();
                                                                                    }
                                                                            
                                                                        },
                                                                         {
                                                                        	icon:'../images/pencil.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Configurar tarea',
                                                                            handler:function()
                                                                            		{
                                                                                    	
                                                                                    }
                                                                            
                                                                        }
                                                                        ,
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover tarea',
                                                                            handler:function()
                                                                            		{
                                                                                    	
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}

function mostrarVentanaNuevaTarea()
{
	var cmbTipoTarea=crearComboExt('cmbTipoTarea',arrTareas,110,120);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'label',
                                                            x:10,
                                                            y:10,
                                                            html:'Nombre de tarea:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            id:'txtNombreTarea',
                                                            width:350,
                                                            x:110,
                                                            y:5
                                                        }
                                                        ,
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:35,
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	xtype:'textarea',
                                                            id:'txtDescripcion',
                                                            width:350,
                                                            height:80,
                                                            x:110,
                                                            y:30
                                                        },
														{
                                                        	xtype:'label',
                                                            x:10,
                                                            y:125,
                                                            html:'Tipo de tarea'
                                                        },
                                                        cmbTipoTarea

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Nueva tarea',
										width: 500,
										height:250,
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
                                                                	gEx('txtNombreTarea').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
                                                                    	var txtNombreTarea=gEx('txtNombreTarea').value;
                                                                    	if(txtNombreTarea.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtNombreTarea.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el nombre de la tarea a crear',resp1);
                                                                            return;
                                                                        }
																		if(cmbTipoTarea.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbTipoTarea.focus();
                                                                            }
                                                                        	msgBox('Debe seleccionar el tipo de tarea a crear',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cadObj='"nombreTarea":"'+cv(txtNombreTarea)+'","tipoTarea":"'+cmbTipoTarea.getValue()+'","descripcion":"'+cv(gEx('txtDescripcion').getValue())+'"';
                                                                        switch(cmbTipoTarea.getValue())
                                                                        {
                                                                        	case '1':
                                                                            	crearTareaReporte(cadObj);
                                                                            break;
                                                                        }
                                                                        
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

function crearTareaReporte()
{

}


function mostrarVentanaConfFechas(conf)
{
	var cmbSiNo=crearComboExt('cmbSiNo',arrSiNo,100,145,120);
    
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	xtype:'fieldset',
                                                            x:10,
                                                            y:10,
                                                            width:400,
                                                            height:120,
                                                            title:'Seleccione las fechas a solicitar:',
                                                            layout:'absolute',
                                                            items:	[
                                                            			{
                                                                        	xtype:'checkbox',
                                                                            id:'fPublicacion',
                                                                            boxLabel:'Publicaci\xF3n de convocatoria',
                                                                            x:10,
                                                                            y:10,
                                                                            checked:true,
                                                                            disabled:true
                                                                            
                                                                        },
                                                                        {
                                                                        	xtype:'checkbox',
                                                                            id:'fRegistro',
                                                                            boxLabel:'Registro',
                                                                            x:10,
                                                                            y:35
                                                                        },
                                                                        {
                                                                        	xtype:'checkbox',
                                                                            id:'fEvaluacion',
                                                                            boxLabel:'Evaluaci\xF3n',
                                                                            x:10,
                                                                            y:60
                                                                        }	
                                                            		]
                                                        },
                                                        {
                                                            x:10,
                                                            y:150,
                                                            html:'Solicitar Ciclo:'
                                                        },
                                                        cmbSiNo

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configuraci&oacute;n [M&oacute;dulo: Fechas convocatorias]',
										width: 500,
										height:280,
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
                                                                    	var fReg='0';
                                                                        if(gEx('fRegistro').getValue())
                                                                        	fReg='1';
                                                                        var fEval='0';
                                                                        if(gEx('fEvaluacion').getValue())
                                                                        	fReg='1';                                                                        
                                                                        var cadObj='{"fPublicacion":"1","fRegistro":"'+fReg+'","fEvaluacion":"'+fEval+'","solCiclo":"'+cmbSiNo.getValue()+'"}';
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	
                                                                                msgBox('La configuraci&oacute;n ha sido guardada correctamente');
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=233&idProceso='+gE('idProceso').value+'&idModulo=11&conf='+cadObj,true);
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
    if(conf!=null)
    {
    	cmbSiNo.setValue(conf.solCiclo);
        gEx('fPublicacion').setValue(conf.fPublicacion);
        gEx('fRegistro').setValue(conf.fRegistro);
        gEx('fEvaluacion').setValue(conf.fEvaluacion);
     }                           
	ventanaAM.show();	
}


function mostrarVentanaConfDatosComplementarios()
{
	var gridTipoProceso=crearGridTipoProcesoConv();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Indique los tipos de procesos que podr&aacute;n ser vinculados a la convocatoria: '
                                                        },
                                                        gridTipoProceso
                                                        

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configuraci&oacute;n [M&oacute;dulo: Datos complementarios convocatoria]',
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
                                                                    	var filas=gridTipoProceso.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe al menos seleccionar un tipo de proceso');
                                                                        	return;
                                                                        }
                                                                    	var lProcesos=obtenerListadoArregloFilas(filas,'idTipoProceso');
                                                                    	var cadObj='{"listTiposProceso":"'+lProcesos+'"}';
																		function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	
                                                                                msgBox('La configuraci&oacute;n ha sido guardada correctamente');
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=233&idProceso='+gE('idProceso').value+'&idModulo=12&conf='+cadObj,true);
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


function crearGridTipoProcesoConv()
{
	var dsDatos=<?php echo $arrTiposProcesos?>;
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idTipoProceso'},
                                                                {name: 'tipoProceso'}
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
															header:'Tipo de proceso',
															width:300,
															sortable:true,
															dataIndex:'tipoProceso'
														}
                                                   ]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                        	id:'gridTiposProcesosConv',
                                                            x:10,
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:280,
                                                            width:440,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;
}

function registroEnLinea(combo)
{
	var valor=combo.options[combo.selectedIndex].value;
    var obj='{"idProcesoReg":"'+valor+'"}';
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
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=234&idProceso='+gE('idProceso').value+'&obj='+obj,true);
}

function mostrarVentanaSecciones()
{
	var gridSecciones=crearGridSecciones();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridSecciones

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Administrar secciones',
										width: 400,
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
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	obtenerSecciones(ventanaAM);
	
}

function crearGridSecciones()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                    			{name: 'idSeccion'},
                                                                {name: 'seccion'}
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
															header:'Secci&oacute;n',
															width:250,
															sortable:true,
															dataIndex:'seccion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridSeccion',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:240,
                                                            width:360,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar secci&oacute;n',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaSeccion();
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../images/pencil.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Modificar secci&oacute;n',
                                                                            handler:function()
                                                                            		{ 
                                                                                    	var fila=vFilaSel(tblGrid,'Debe seleccionar la secci&oacute;n que desea modificar');
                                                                                    	
                                                                                    	if(fila)
                                                                                        {
                                                                                        	mostrarVentanaSeccion(fila);
                                                                                        }
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Eliminar secci&oacute;n',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la secci&oacute;n a eliminar');
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
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosProcesos.php',funcAjax, 'POST','funcion=9&idSeccion='+fila.get('idSeccion'),true);
                                                                                            	
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover  la secci&oacute;n seleccionada?',resp)
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function mostrarVentanaSeccion(id)
{
	var idProceso=gE('idProceso').value;
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Secci&oacute;n:'
                                                        },
                                                        {
                                                        	x:80,
                                                            y:5,
                                                            width:200,
                                                            xtype:'textfield',
                                                            id:'txtSeccion'
                                                        }	

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Secci&oacute;n',
										width: 335,
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
                                                                	gE('txtSeccion').focus(false,400);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtSeccion=gEx('txtSeccion');
                                                                        var idSeccion=-1;
                                                                        if(id!=undefined)
                                                                        	idSeccion=id.get('idSeccion');
                                                                        if(txtSeccion.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtSeccion.focus();
                                                                            }
                                                                            msgBox('El nombre de la secci&oacute;n es obligatorio',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('gridSeccion').getStore().loadData(eval(arrResp[1]));
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosProcesos.php',funcAjax, 'POST','funcion=7&idSeccion='+idSeccion+'&idProceso='+idProceso+'&nSeccion='+cv(txtSeccion.getValue()),true);
                                                                        
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
	if(id!=undefined)
    {
    	gEx('txtSeccion').setValue(id.get('seccion'));
    }                                
	ventanaAM.show();
    
}

function obtenerSecciones(ventana)
{
	var idProceso=gE('idProceso').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('gridSeccion').getStore().loadData(eval(arrResp[1]));
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosProcesos.php',funcAjax, 'POST','funcion=8&idProceso='+idProceso,true);
}

function mostrarVentanaConfiguracionPrespuesto()
{
	var gridRubros=crearGridRubros();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Indique los rubros a considerar en el presupuesto:'
                                                        },
                                                        gridRubros
                                                        

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configuraci&oacute;n m&oacute;dulo presupuestal',
										width: 800,
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
																		ventanaAM.close();	
																	}
														}
													]
									}
								);
	obtenerDatosModulosPresupuesto(ventanaAM);
}

function obtenerDatosModulosPresupuesto(ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj=eval("["+arrResp[1]+"]")[0];
            gEx('gridPresupuesto').getStore().loadData(obj.arrConceptos);
            ventana.show();
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=322&idProceso='+gE('idProceso').value,true);
    
    
}

function crearGridRubros()
{
	var cmbSituacion=crearComboExt('cmbSituacion',arrStatus);
    cmbSituacion.setValue('1');
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idRubro'},
                                                                    {name: 'concepto'},
                                                                    {name: 'conceptoCorto'},
                                                                    {name: 'funcionConstruccion'},
                                                                    {name: 'objetoGasto'},
                                                                    {name: 'lblObjetoGasto'},
                                                                    {name: 'situacion'},
                                                                    {name: 'eliminable'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	var editorFila=new Ext.ux.grid.RowEditor	(
    												{
														id:'editor_Presupuesto',
                                                        saveText: 'Guardar',
                                                        cancelText:'Cancelar',
                                                        clicksToEdit:2
                                                    }
                                                );
                                             
    editorFila.on('beforeedit',funcEditorFilaBeforeEditCampoGridPresupuesto)
    editorFila.on('validateedit',funcEditorValidaCampoGridPresupuesto);
    editorFila.on('canceledit',funcEditorCancelEditCampoGridPresupuesto);
                                                    
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Concepto *',
															width:400,
															sortable:true,
															dataIndex:'concepto',
                                                            editor:{xtype:'textfield',id:'editor_concepto'}
														},
														{
															header:'T&iacute;tulo corto *',
															width:200,
															sortable:true,
															dataIndex:'conceptoCorto',
                                                            editor:{xtype:'textfield',id:'editor_conceptoCorto'}
														},
                                                        
                                                        {
															header:'Objeto de gasto asociado',
															width:150,
															sortable:true,
															dataIndex:'lblObjetoGasto',
                                                            editor:	{
                                                            			xtype:'textfield',
                                                                        id:'editor_lblObjetoGasto',
                                                                        readOnly:true,
                                                                        listeners:	{
                                                                        				'focus':function()
                                                                                        		{
                                                                                                	mostrarVentanaObjetosGasto();
                                                                                                }
                                                                                                
                                                                        			}
                                                                    }
														},
                                                        {
															header:'Funci&oacute;n de construcci&oacute;n',
															width:150,
															sortable:true,
															dataIndex:'funcionConstruccion',
                                                            editor:{xtype:'textfield',id:'editor_funcionConstruccion'}
														},
                                                        {
															header:'Situaci&oacute;n',
															width:120,
															sortable:true,
															dataIndex:'situacion',
                                                            id:'editor_situacion',
                                                            editor:cmbSituacion,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrStatus,val);
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridPresupuesto',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:280,
                                                            width:770,
                                                            sm:chkRow,
                                                            plugins:[editorFila],
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar concepto',
                                                                            id:'btnAdd_Presupuesto',
                                                                            handler:function()
                                                                            		{
                                                                                    	var registroGrid=crearRegistro([
                                                                                                                            {name: 'idRubro'},
                                                                                                                            {name: 'concepto'},
                                                                                                                            {name: 'conceptoCorto'},
                                                                                                                            {name: 'funcionConstruccion'},
                                                                                                                            {name: 'objetoGasto'},
                                                                                                                            {name: 'lblObjetoGasto'},
                                                                                                                            {name: 'situacion'},
                                                                                                                            {name: 'eliminable'}
                                                                                                                        ]);		
                                                                                    	var nReg=new registroGrid	(
                                                                                                                        {
                                                                                                                        	idRubro:'-1',
                                                                                                                            concepto:'',
                                                                                                                            conceptoCorto:'',
                                                                                                                            funcionConstruccion:'',
                                                                                                                            objetoGasto:'',
                                                                                                                            situacion:'1',
                                                                                                                            eliminable:'1'
                                                                                                                        }
                                                                                                                    )
                                                                                        
                                                                                        editorFila.stopEditing();
                                                                                        tblGrid.getStore().add(nReg);
                                                                                        tblGrid.nuevoRegistro=true;
                                                                                        editorFila.startEditing(tblGrid.getStore().getCount()-1);	
                                                                                        Ext.getCmp('btnAdd_Presupuesto').disable();
                                                                                        Ext.getCmp('btnDel_Presupuesto').disable();                                    
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            id:'btnDel_Presupuesto',
                                                                            text:'Remover concepto',
                                                                            handler:function()
                                                                            		{
                                                                                    	
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	tblGrid.nuevoRegistro=false;                                                    
	return 	tblGrid;	
}

function funcEditorFilaBeforeEditCampoGridPresupuesto(rowEdit,fila)
{
	var grid=Ext.getCmp('gridPresupuesto');
    grid.copiaRegistro=grid.getStore().getAt(fila).copy();
    grid.registroEdit=grid.getStore().getAt(fila);
    gEx('editor_lblObjetoGasto').codigoObjeto=grid.registroEdit.get('objetoGasto');
}

function funcEditorCancelEditCampoGridPresupuesto(rowEdit,cancelado)
{
	var grid=Ext.getCmp('gridPresupuesto');
	if(grid.nuevoRegistro)
		grid.getStore().removeAt(grid.getStore().getCount()-1);
	Ext.getCmp('btnDel_Presupuesto').enable();
    Ext.getCmp('btnAdd_Presupuesto').enable();
    var copiaRegistro=grid.copiaRegistro;
    var x=0;
    var arrCampos=grid.getStore().fields;
    var filaDestino=grid.registroEdit;
    for(x=0;x<arrCampos.items.length;x++)
    {
    	filaDestino.set(arrCampos.items[x].name,copiaRegistro.get(arrCampos.items[x].name));

    }
	grid.nuevoRegistro=false;
}

function funcEditorValidaCampoGridPresupuesto(rowEdit,obj,fila,nFila)
{
	fila.set('objetoGasto', gEx('editor_lblObjetoGasto').codigoObjeto);
	var grid=Ext.getCmp('gridPresupuesto');
	var cm=grid.getColumnModel();
	var nColumnas=cm.getColumnCount(false);
	var x;
	var editor;
	var dataIndex;
	var valor;
	for(x=0;x<nColumnas;x++)
	{
		if(cm.getColumnHeader(x).indexOf('*')!=-1)
		{
			dataIndex=cm.getDataIndex(x);
			valor=(eval('obj.'+dataIndex));
			if(valor=='')
			{
				function funcResp()
				{
					var ctrl=gEx('editor_'+dataIndex);
					ctrl.focus();
				}
				msgBox('La columna "'+cm.getColumnHeader(x).replace('*','')+'" no puede ser vac&iacute;a',funcResp);
				return false;
			}
		}	
	}
    var cadObj='{"idProceso":"'+gE('idProceso').value+'","idRubro":"'+fila.get('idRubro')+'","concepto":"'+obj.concepto+'","conceptoCorto":"'+obj.conceptoCorto+'","funcionConstruccion":"'+obj.funcionConstruccion+'","objetoGasto":"'+fila.get('objetoGasto')+'","situacion":"'+fila.get('situacion')+'"}';
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            fila.set('idRubro',arrResp[1]);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=321&cadObj='+cadObj,true);
}



var regProcesoRegistro=crearRegistro([
										{name: 'idRegProceso'},
                                        {name: 'tipoProceso'},
                                        {name: 'proceso'},
                                        {name: 'nProceso'}
                                     ]);


function crearGridProcesosAsocConvocatoria()
{
	var arrTipoProceso=<?php echo $arrTiposProc ?>;
	var cmbTipoProceso=crearComboExt('cmbTipoProceso',arrTipoProceso);
    cmbTipoProceso.on('select',funcComboTipoPrcesoChange);
    var cmbProcesos=crearComboExt('cmbProcesos',[]);
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idRegProceso'},
                                                                    {name: 'tipoProceso'},
                                                                    {name: 'proceso'},
                                                                    {name: 'nProceso'}
                                                                ]
                                                    }
                                                );
    
        alDatos.loadData(dsDatos);

        var chkRow=new Ext.grid.CheckboxSelectionModel();
        var editorFila=new Ext.ux.grid.RowEditor	(
                                                        {
                                                            id:'editor_GridProcesos',
                                                            saveText: 'Guardar',
                                                            cancelText:'Cancelar',
                                                            clicksToEdit:2
                                                        }
                                                    );
    	editorFila.on('beforeedit',funcEditorFilaBeforeEditGridProcesos)
    	editorFila.on('validateedit',funcEditorValidaCampoGridProcesos);
    	editorFila.on('canceledit',funcEditorCancelEditCampoGridProcesos);  
        
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            chkRow,
                                                            {
                                                                header:'Tipo de proceso',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'tipoProceso',
                                                                editor:cmbTipoProceso,
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoProceso,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Proceso',
                                                                width:500,
                                                                sortable:true,
                                                                dataIndex:'proceso',
                                                                editor:cmbProcesos,
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return registro.get('nProceso');
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'editorGridProcesos',
                                                                store:alDatos,
                                                                frame:true,
                                                                renderTo:'tblProcesosConvocatoria',
                                                                cm: cModelo,
                                                                height:260,
                                                                width:800,
                                                                sm:chkRow,
                                                                plugins:[editorFila],
                                                                tbar:	[
                                                                			{
                                                                            	id:'btnAddEditorGridProcesos',
                                                                            	icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar proceso',
                                                                                handler:function()
                                                                                		{
                                                                                        	var r=new regProcesoRegistro({idRegProceso:'-1',tipoProceso:'',proceso:'',nProceso:''});
                                                                                            editorFila.stopEditing();
                                                                                            tblGrid.getStore().add(r);
                                                                                            tblGrid.nuevoRegistro=true;
                                                                                            editorFila.startEditing(tblGrid.getStore().getCount()-1);	
                                                                                        }
                                                                               
                                                                                        
                                                                            },
                                                                            {
                                                                            	id:'btnDelEditorGridProcesos',
                                                                            	icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover proceso',
                                                                                handler:function()
                                                                                		{
                                                                                        	var fila=tblGrid.getSelectionModel().getSelections();
                                                                                            if(fila.length==0)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar al menos un proceso a remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	var idRegProceso=obtenerListadoArregloFilas(fila,'idRegProceso');
                                                                                                	function funcAjax()
                                                                                                    {
                                                                                                        var resp=peticion_http.responseText;
                                                                                                        arrResp=resp.split('|');
                                                                                                        if(arrResp[0]=='1')
                                                                                                        {
                                                                                                        	tblGrid.getStore().remove(fila);
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=221&idRegProceso='+idRegProceso,true);

	
                                                                                                	
                                                                                                }
                                                                                               
                                                                                            }
                                                                                             msgConfirm('Est&aacute; seguro de querer remover los procesos seleccionados?',resp);
                                                                                            
                                                                                        }
                                                                               
                                                                                        
                                                                            }
                                                                		]
                                                            }
                                                        );
	    tblGrid.nuevoRegistro=false;   
        tblGrid.on('beforeedit',funcTipoProcesoSelect);                                       
        return 	tblGrid;
}

function funcEditorFilaBeforeEditGridProcesos()
{

}

function funcEditorValidaCampoGridProcesos(rowEditor,obj,registro)
{
	var cmbTipoProceso=gEx('cmbTipoProceso');
    var cmbProceso=gEx('cmbProcesos');
    if(cmbTipoProceso.getValue()=='')
    {
    	function funcRespTipo()
        {
        	cmbTipoProceso.focus();
        }
    	msgBox('Debe indicar el tipo de proceso con el cual se vincular&aacute; la convocatoria',funcRespTipo);
        return false;
    }
    
    if(cmbProceso.getValue()=='')
    {
    	function funcRespProc()
        {
        	cmbProceso.focus();
        }
    	msgBox('Debe indicar el proceso con el cual se vincular&aacute; la convocatoria',funcRespProc);
        return false;
    }
    
    var cadObj='{"tipoRegistro":"1","idRegProceso":"'+registro.get('idRegProceso')+'","idProceso":"'+cmbProceso.getValue()+'","idProcesoConvocatoria":"'+gE('idProceso').value+'"}';
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            gEx('editorGridProcesos').getStore().loadData(arrDatos);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            Ext.getCmp('btnAddEditorGridProcesos').enable();
            Ext.getCmp('btnDelEditorGridProcesos').enable();
            var grid=gEx('editorGridProcesos').getStore().rejectChanges();
            grid.nuevoRegistro=false;
            return false;
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=220&cadObj='+cadObj,true);
    return true;
    
    
}

function funcEditorCancelEditCampoGridProcesos()
{
	var grid=Ext.getCmp('editorGridProcesos');
	if(grid.nuevoRegistro)
		grid.getStore().removeAt(grid.getStore().getCount()-1);
	
	Ext.getCmp('btnAddEditorGridProcesos').enable();
    Ext.getCmp('btnDelEditorGridProcesos').enable();
	grid.nuevoRegistro=false;
}

function funcTipoProcesoSelect(e)
{
	if(e.record.get('tipoProceso')=='')
    {
    	e.cancel=true;
        return;
    }
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            var cmbProcesos=gEx('cmbProcesos');
            cmbProcesos.reset();
            cmbProcesos.getStore().loadData(arrDatos);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=219&idTipoProceso='+e.record.get('tipoProceso'),true);	

}

function funcComboTipoPrcesoChange(combo,registro)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            var cmbProcesos=gEx('cmbProcesos');
            cmbProcesos.reset();
            cmbProcesos.getStore().loadData(arrDatos);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=219&idTipoProceso='+registro.get('id'),true);	
}


function vicularProcesoReporte(combo)
{
	var valor=combo.options[combo.selectedIndex].value;
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
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=324&idProceso='+gE('idProceso').value+'&idReporte='+valor,true);	
}

function configurarTemporizador(iP,e)
{

	var gridTemporizador=crearGridTemporizador(iP,e);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridTemporizador

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configurar temporizador',
										width: 850,
										height:350,
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
															text: 'Cerrar',
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


function crearGridTemporizador(iP,e)
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idTemporizador'},
		                                                {name: 'noUnidades'},
                                                        {name: 'idFuncionTemporizador'},
                                                        {name: 'noUnidadesDiaria'},
                                                        {name: 'idFuncionEjecucionDiaria'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesProyectos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'noUnidades', direction: 'ASC'},
                                                            groupField: 'noUnidades',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='329';
                                        proxy.baseParams.idProceso=bD(iP);
                                        proxy.baseParams.nEtapa=bD(e)
                                        
                                    }
                        )   
	var chkRow=new Ext.grid.CheckboxSelectionModel();       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                         	chkRow,   
                                                            
                                                            {
                                                                header:'Funci&oacute;n a ejecutar',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'idFuncionTemporizador',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrFuncionesDisparador,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Ejecutar despu&eacute;s de',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'noUnidades',
                                                                renderer:function(val)
                                                                		{
                                                                        	if((val!='')&&(val!='0'))
	                                                                        	return val+' d&iacute;as';
                                                                        }
                                                                
                                                            },
                                                            {
                                                                header:'Funci&oacute;n a ejecutar periodicamente',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'idFuncionEjecucionDiaria',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrFuncionesDisparadorPeriodico,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Ejecutar cada',
                                                                width:130,
                                                                sortable:true,
                                                                renderer:function(val)
                                                                		{
                                                                        	if((val!='')&&(val!='0'))
	                                                                        	return val+' d&iacute;as';
                                                                        },
                                                                dataIndex:'noUnidadesDiaria'
                                                                
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridTemporizadores',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:true,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                height:250,
                                                                sm:chkRow,
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar temporizador',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaAgregarTemporizador(iP,e,tblGrid);
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover temporizador',
                                                                                handler:function()
                                                                                        {
                                                                                        	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                            if(filas.length==0) 
                                                                                            {
                                                                                            	msgBox('Debe seleccionar al menos un temporizador para remover');
                                                                                                return;
                                                                                            }
                                                                                            var listTemporizadores='';
                                                                                            var x;
                                                                                            for(x=0;x<filas.length;x++)
                                                                                            {
                                                                                            	if(listTemporizadores=='')
                                                                                                	listTemporizadores=filas[x].get('idTemporizador');
                                                                                                else
                                                                                                	listTemporizadores+=','+filas[x].get('idTemporizador');
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
                                                                                                            tblGrid.getStore().remove(filas);
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=331&listTemporizadores='+listTemporizadores,true);

                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover los temporizadores seleccionados',resp);
                                                                                        }
                                                                                
                                                                            }
                                                                		],
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit: false,
                                                                                                    enableGrouping :false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;	
}

function mostrarVentanaAgregarTemporizador(iP,e,grid)
{
	var cmbFuncionEjecutar=crearComboExt('cmbFuncionEjecutar',arrFuncionesDisparador,210,35,300);
    
    var cmbFuncionEjecutarPeriodica=crearComboExt('cmbFuncionEjecutarPeriodica',arrFuncionesDisparadorPeriodico,210,95,300);
    cmbFuncionEjecutarPeriodica.setValue('0');
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	xtype:'label',
                                                            html:'Ejecutar temporizador despu&eacute;s de: ',
                                                            x:10,
                                                            y:10
                                                        },
                                                        {
                                                        	xtype:'numberfield',
                                                            id:'nDias',
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            width:80,
                                                            x:210,
                                                            y:5
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            html:'d&iacute;as',
                                                            x:310,
                                                            y:10
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            html:'Funci&oacute;n a ejecutar: ',
                                                            x:10,
                                                            y:40
                                                        },
                                                        cmbFuncionEjecutar,
                                                        {
                                                        	xtype:'label',
                                                            html:'Ejecutar temporizador peri&oacute;dico cada: ',
                                                            x:10,
                                                            y:70
                                                        },
                                                        {
                                                        	xtype:'numberfield',
                                                            id:'nDiasPeriodico',
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            width:80,
                                                            x:210,
                                                            y:65
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            html:'d&iacute;as',
                                                            x:310,
                                                            y:70
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            html:'Funci&oacute;n a ejecutar: ',
                                                            x:10,
                                                            y:100
                                                        },
                                                        cmbFuncionEjecutarPeriodica

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar temporizador',
										width: 600,
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
                                                                	gEx('nDias').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var nDias=gEx('nDias');
                                                                        if(nDias.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	nDias.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el n&uacute;mero de d&iacute;as que deber&aacute; esperar el sistema antes de ejecutar la funci&oacute;n',resp);
                                                                            return;
                                                                        }
                                                                        if(cmbFuncionEjecutar.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbFuncionEjecutar.focus();
                                                                            }
                                                                            msgBox('Debe indicar la funci&oacute;n a ajecutar',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        var nDiasPeriodico=gEx('nDiasPeriodico');
                                                                        if(cmbFuncionEjecutarPeriodica.getValue()!='0')
                                                                        {
                                                                            if(nDiasPeriodico.getValue()=='')
                                                                            {
                                                                                function resp3()
                                                                                {
                                                                                    nDiasPeriodico.focus();
                                                                                }
                                                                                msgBox('Debe ingresar el n&uacute;mero de d&iacute;as en el cual se ejecutar&aacute; la funci&oacute;n periodicamente',resp3);
                                                                                return;
                                                                            }
		                                                                }
                                                                               
                                                                        var cadObj='{"idProceso":"'+bD(iP)+'","nEtapa":"'+bD(e)+'","nDias":"'+nDias.getValue()+'","idFuncion":"'+cmbFuncionEjecutar.getValue()+
                                                                        			'","nDiasPeriodico":"'+nDiasPeriodico.getValue()+'","idFuncionPeriodico":"'+cmbFuncionEjecutarPeriodica.getValue()+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                             	gEx('gridTemporizadores').getStore().reload();
                                                                                ventanaAM.close();                          
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=328&cadObj='+cadObj,true);

                                                                        
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

function crearGridOtrasSecciones(iP)
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idSeccion'},
		                                                {name: 'tituloSeccion'},
		                                                {name:'paginaJavaScript'},
		                                                {name:'funcionScript'},
                                                        {name: 'funcionInicializacion'},
                                                        {name: 'paginaIncludePhp'},
                                                        {name: 'funcionRenderer'},
                                                        {name: 'descripcion'}
                                                        
                                                        
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesProyectos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'tituloSeccion', direction: 'ASC'},
                                                            groupField: 'tituloSeccion',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='332';
                                        proxy.baseParams.idProceso=iP;
                                    }
                        )   
                        
                        
	var expander = new Ext.ux.grid.RowExpander({
                                                column:3,
                                                expandOnEnter:false,
                                                tpl : new Ext.Template(
                                                    '<table >',
                                                    '<tr><td style="padding:5px; color:#666; font-style:italic">{descripcion}</td></tr>',
                                                    '</table>'
                                                )
                                            });                        
                        
	var chkRow=new Ext.grid.CheckboxSelectionModel();       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            expander,
                                                            chkRow,
                                                            {
                                                                header:'Leyenda',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'tituloSeccion',
                                                                editor:{xtype:'textfield'}
                                                            },
                                                            {
                                                                header:'P&aacute;gina JavaScript <span class="letraRoja">*</span>',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'paginaJavaScript',
                                                                editor:{xtype:'textfield'}
                                                            },
                                                            {
                                                                header:'Funci&oacute;n JavaScript asociada<span class="letraRoja">*</span>',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'funcionScript',
                                                                editor:{xtype:'textfield'}
                                                            },
                                                            {
                                                                header:'Funci&oacute;n JavaScript inicializaci&oacute;n',
                                                                width:230,
                                                                sortable:true,
                                                                dataIndex:'funcionInicializacion',
                                                                editor:{xtype:'textfield'}
                                                            },
                                                            {
                                                                header:'P&aacute;gina include PHP',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'paginaIncludePhp',
                                                                editor:{xtype:'textfield'}
                                                            },
                                                            {
                                                                header:'Funci&oacute;n PHP renderer',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'funcionRenderer',
                                                                editor:{xtype:'textfield'}
                                                            }
                                                        ]
                                                    );


	var editorFila=new Ext.ux.grid.RowEditor	(
    												{
														id:'editor_gridOtrasSecciones',
                                                        saveText: 'Guardar',
                                                        cancelText:'Cancelar',
                                                        clicksToEdit:2
                                                    }
                                                );
	editorFila.on('afteredit',funcEditorAfterEditSeccion)                                                
    editorFila.on('beforeedit',funcEditorBeforeEditSeccion)
    editorFila.on('validateedit',funcEditorValidaSeccion);
    editorFila.on('canceledit',funcEditorCancelEditSeccion);
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridOtrasSecciones',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:true,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                height:440,
                                                                sm:chkRow,
                                                                plugins:[editorFila,expander],
                                                                tbar:	[
                                                                            {
                                                                            	id:'btnAdd_gridOtrasSecciones',
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar configuraci&oacute;n de secci&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                         	var tblGrid=gEx('gridOtrasSecciones');
                                                                                              var registroGrid=crearRegistro([
                                                                                                                                {name:'idSeccion'},
                                                                                                                                {name: 'tituloSeccion'},
                                                                                                                                {name:'paginaJavaScript'},
                                                                                                                                {name:'funcionScript'},
                                                                                                                                {name: 'funcionInicializacion'},
                                                                                                                                {name: 'paginaIncludePhp'},
                                                                                                                                {name: 'funcionRenderer'}
                                                                                                                                
                                                                                                                                
                                                                                                                            ]);
                                                                                              
                                                                                              var nReg=new registroGrid	(
                                                                                              								{
                                                                                                                              idSeccion:-1,
                                                                                                                              tituloSeccion:'',
                                                                                                                              paginaJavaScript:'',
                                                                                                                              funcionScript:'',
                                                                                                                              funcionInicializacion:'',
                                                                                                                              paginaIncludePhp:'',
                                                                                                                              funcionRenderer:''
                                                                                                                            }
                                                                                                                          )
                                                                                              
                                                                                              editorFila.stopEditing();
                                                                                              tblGrid.getStore().add(nReg);
                                                                                              tblGrid.nuevoRegistro=true;
                                                                                              editorFila.startEditing(tblGrid.getStore().getCount()-1);	
                                                                                              Ext.getCmp('btnAdd_gridOtrasSecciones').disable();
                                                                                              Ext.getCmp('btnDel_gridOtrasSecciones').disable();	   
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                            	id:'btnDel_gridOtrasSecciones',
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover configuraci&oacute;n de secci&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                            var filas=tblGrid.getSelectionModel().getSelections();
                                                                                            if(filas.length==0) 
                                                                                            {
                                                                                            	msgBox('Debe seleccionar al menos una secci&oacute;n para remover');
                                                                                                return;
                                                                                            }
                                                                                            var listTemporizadores='';
                                                                                            var x;
                                                                                            for(x=0;x<filas.length;x++)
                                                                                            {
                                                                                            	if(listTemporizadores=='')
                                                                                                	listTemporizadores=filas[x].get('idSeccion');
                                                                                                else
                                                                                                	listTemporizadores+=','+filas[x].get('idSeccion');
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
                                                                                                            tblGrid.getStore().remove(filas);
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=334&listConfiguraciones='+listTemporizadores,true);

                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover las secciones seleccionadas?',resp);
                                                                                        }
                                                                                
                                                                            }
                                                                          ],
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit: false,
                                                                                                    enableGrouping :false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;	
}

function funcEditorAfterEditSeccion(rowEdit,obj,registro,nFila)
{

}

function funcEditorBeforeEditSeccion(rowEdit,fila)
{
	var datosEditor=rowEdit.getId().split('_')	
	var idGrid=datosEditor[1];
	var grid=Ext.getCmp(idGrid);
    grid.copiaRegistro=grid.getStore().getAt(fila).copy();
    grid.registroEdit=grid.getStore().getAt(fila);
	if((grid.soloLectura)&&(!grid.nuevoRegistro))
		return false;
}

function funcEditorValidaSeccion(rowEdit,obj,registro,nFila)
{
	var datosEditor=rowEdit.getId().split('_')	
	var idGrid=datosEditor[1];
	var grid=Ext.getCmp(idGrid);
	var cm=grid.getColumnModel();
	var nColumnas=cm.getColumnCount(false);
	var x;
	var editor;
	var dataIndex;
	var valor;
	for(x=0;x<nColumnas;x++)
	{
		if(cm.getColumnHeader(x).indexOf('*')!=-1)
		{
			dataIndex=cm.getDataIndex(x);
			valor=(eval('obj.'+dataIndex));
			if(valor=='')
			{
				function funcResp()
				{
					var ctrl=gEx('editor_'+dataIndex);
					ctrl.focus();
				}
				msgBox('La columna "'+cm.getColumnHeader(x).replace('*','')+'" no puede ser vac&iacute;a',funcResp);
				return false;
			}
		}	
	}
    
    
    var cadObj='{"idSeccion":"'+registro.get('idSeccion')+'","tituloSeccion":"'+cv(obj.tituloSeccion)+'","paginaJavaScript":"'+cv(obj.paginaJavaScript)+
    			'","funcionScript":"'+cv(obj.funcionScript)+'","funcionInicializacion":"'+cv(obj.funcionInicializacion)+'","paginaIncludePhp":"'+
                cv(obj.paginaIncludePhp)+'","funcionRenderer":"'+cv(obj.funcionRenderer)+'","idProceso":"<?php echo $idProceso?>"}';
    
    
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	registro.set('idSeccion',arrResp[1]);
            Ext.getCmp('btnAdd_gridOtrasSecciones').enable();
			Ext.getCmp('btnDel_gridOtrasSecciones').enable();	
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=333&cadObj='+cadObj,true);
    
    return true;
   
}

function funcEditorCancelEditSeccion(rowEdit,cancelado)
{
	var datosEditor=rowEdit.getId().split('_')
	var idGrid=datosEditor[1];
	var grid=Ext.getCmp(idGrid);
	if(grid.nuevoRegistro)
		grid.getStore().removeAt(grid.getStore().getCount()-1);
	Ext.getCmp('btnDel_'+idGrid).enable();
    Ext.getCmp('btnAdd_'+idGrid).enable();
    var copiaRegistro=grid.copiaRegistro;
    
    var x=0;
    var arrCampos=grid.getStore().fields;
    var filaDestino=grid.registroEdit;

    for(x=0;x<arrCampos.items.length;x++)
    {
    	filaDestino.set(arrCampos.items[x].name,copiaRegistro.get(arrCampos.items[x].name));

    }

    
	grid.nuevoRegistro=false;
}








function removerEtapa(e,iS)
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
                    gEx('gridOtrasSecciones').getStore().reload();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=343&e='+bD(e)+'&iS='+bD(iS),true);
            
		}
    }
    msgConfirm('Est&aacute; seguro de querer remover la etapa seleccionada?',resp);
}


function agregarEtapaSeccion(iS)
{
	var gridEtapasSeccion=crearGridEtapasSeccion(bD(iS));
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridEtapasSeccion

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar etapa de visualizaci&oacute;n de secci&oacute;n',
										width: 500,
										height:350,
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
																		var listEtapas='';
                                                                        var filas=gridEtapasSeccion.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar almenos una etapa para asignar a la secci&oacute;n');
                                                                            return;
                                                                        }
                                                                        var x;
                                                                        var f;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	f=filas[x];
                                                                            if(listEtapas=='')
                                                                            	listEtapas=f.data.numEtapa;
                                                                            else
                                                                            	listEtapas+=','+f.data.numEtapa;
                                                                        }
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gridOtrasSecciones').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=345&listEtapas='+listEtapas+'&iS='+bD(iS),true);

                                                                        
                                                                        
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

function crearGridEtapasSeccion(iS)
{
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'numEtapa',type:'float'},
		                                                {name: 'nombreEtapa'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesProyectos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'numEtapa', direction: 'ASC'},
                                                            groupField: 'numEtapa',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='344';
                                        proxy.baseParams.idSeccion=iS;
                                        proxy.baseParams.idProceso=gE('idDocumento').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            chkRow,
                                                            {
                                                                header:'No. Etapa',
                                                                width:70,
                                                                sortable:true,
                                                                dataIndex:'numEtapa',
                                                                renderer:removerCerosDerecha
                                                            },
                                                            {
                                                                header:'Etapa',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'nombreEtapa'
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridEtapasSecc',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                border:true,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                height:245,
                                                                sm:chkRow,
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;	
}

function configurarNotificaciones(iP,e)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
														crearGridConfiguracionNotificaciones(bD(e))

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configuraci&oacute;n de notificaciones',
										width: 980,
										height:480,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
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
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
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

function crearGridConfiguracionNotificaciones(e)
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idRegistroNotificacion'},
		                                                {name: 'tipoNotificacion'},
                                                        {name: 'funcionCondicionadora'},
                                                        {name: 'etFuncionCondicionadora'},
		                                                {name: 'rolDestinatario'},
                                                        {name: 'etRolDestinatario'},
		                                                {name: 'funcionDefinicionDestinatario'},
                                                        {name: 'etFuncionDefinicionDestinatario'},
                                                        {name: 'permiteAccesoProceso'},
                                                        {name: 'actorAccesoProceso'},
                                                        {name: 'etActorAccesoProceso'},
                                                        {name: 'statusNotificacion'},
                                                        {name: 'confComplementaria'},
                                                        {name: 'marcarAtendidaCambioEtapa'},
                                                        {name: 'funcionAplicacionMarcaAtencion'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesFormulario.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'tipoNotificacion', direction: 'ASC'},
                                                            groupField: 'tipoNotificacion',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='235';
                                        proxy.baseParams.idProceso=idProceso;
                                        proxy.baseParams.etapa=e;
                                        proxy.baseParams.idPerfil=-1;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            {
                                                                header:'Tipo de notificaci&oacute;n',
                                                                width:150,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'tipoNotificacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoNotificaciones,val);
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Actor destinatario',
                                                                width:200,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'etRolDestinatario',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Funci&oacute;n de aplicaci&oacute;n',
                                                                width:300,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'etFuncionCondicionadora',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Funci&oacute;n de asignaci&oacute;n<br>de destinatario',
                                                                width:300,
                                                                align:'center',
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'etFuncionDefinicionDestinatario',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Permitir acceso al proceso',
                                                                width:250,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'permiteAccesoProceso',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSiNo,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Actor de acceso al proceso',
                                                                width:280,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'etActorAccesoProceso'
                                                            },
                                                            {
                                                                header:'Notificaci&oacute;n activa',
                                                                width:190,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'statusNotificacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSiNo,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Marcar como atendida al cambiar de etapa',
                                                                width:400,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'marcarAtendidaCambioEtapa',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSiNo,val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                      {
                                                          id:'gConfiguracionNotificaciones',
                                                          store:alDatos,
                                                          region:'center',
                                                          frame:false,
                                                          cm: cModelo,
                                                          stripeRows :false,
                                                          loadMask:true,
                                                          cls:'gridSiugjPrincipal',
                                                          columnLines : false,    
                                                          tbar:	[
                                                          			{
                                                                        icon:'../images/add.png',
                                                                        cls:'x-btn-text-icon',
                                                                        text:'Agregar notificaci&oacute;n',
                                                                        handler:function()
                                                                                {
                                                                                    mostrarVentanaConfiguracionNotificacion(e);
                                                                                }
                                                                        
                                                                    },
                                                                    {
                                                                    	xtype:'tbspacer',
                                                                        width:10
                                                                    },
                                                                    {
                                                                        icon:'../images/pencil.png',
                                                                        cls:'x-btn-text-icon',
                                                                        text:'Modificar notificaci&oacute;n',
                                                                        handler:function()
                                                                                {
                                                                                    var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        
                                                                                    if(!fila)
                                                                                    {
                                                                                        msgBox('Debe seleccionar la notificaci&oacute;n que desea modificar');
                                                                                        return;
                                                                                    }
                                                                                    mostrarVentanaConfiguracionNotificacion(e,fila);
                                                                                }
                                                                        
                                                                    },
                                                                    {
                                                                    	xtype:'tbspacer',
                                                                        width:10
                                                                    },
                                                                    {
                                                                        icon:'../images/delete.png',
                                                                        cls:'x-btn-text-icon',
                                                                        text:'Remover notificaci&oacute;n',
                                                                        handler:function()
                                                                                {
                                                                                    var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        
                                                                                    if(!fila)
                                                                                    {
                                                                                        msgBox('Debe seleccionar la notificaci&oacute;n que desea remover');
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
                                                                                                    
                                                                                                    gEx('gConfiguracionNotificaciones').getStore().reload();
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=237&idNotificacion='+fila.data.idRegistroNotificacion,true);
                                                                                        }
                                                                                    }
                                                                                    msgConfirm('Est&aacute; seguro de querer remover la notificaci&oacute;n seleccionada?',resp);
                                                                                    
                                                                                    
                                                                                    
                                                                                }
                                                                        
                                                                    }
                                                          		],                                                            
                                                          view:new Ext.grid.GroupingView({
                                                                                              forceFit:false,
                                                                                              showGroupName: false,
                                                                                              enableGrouping :true,
                                                                                              enableNoGroups:false,
                                                                                              enableGroupingMenu:false,
                                                                                              hideGroupedColumn: true,
                                                                                              startCollapsed:false
                                                                                          })
                                                      }
                                                  );
        return 	tblGrid;	
}

function mostrarVentanaConfiguracionNotificacion(etapa,filaNotificacion)
{
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            activeTab:1,
                                                            region:'center',
                                                            cls:'tabPanelSIUGJ',
                                                            id:'idPanelConf',
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Configuraci&oacute;n Inicial',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Tipo de notificaci&oacute;n: <span style="color:#F00">*</span>'
                                                                                        },
                                                                                        {
                                                                                            x:220,
                                                                                            y:5,
                                                                                            html:'<div id="divComboTipoNotificacion"></div>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:60,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Funci&oacute;n de aplicaci&oacute;n:'
                                                                                        },
                                                                                        {
                                                                                            xtype:'textfield',
                                                                                            width:500,
                                                                                            x:220,
                                                                                            y:55,
                                                                                            cls:'controlSIUGJ',
                                                                                            id:'txtFuncionAplicacion',
                                                                                            readOnly:true
                                                                                        },
                                                                                        {
                                                                                            xtype:'label',
                                                                                            x:730,
                                                                                            y:57,
                                                                                            html:'<a href="javascript:agregarFuncionControl(1)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionControl(1)"><img src="../images/cross.png"></a>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:100,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Actor destinatario:'
                                                                                        },
                                                                                        {
                                                                                            x:220,
                                                                                            y:95,
                                                                                            html:'<div id="divComboRolesNotificacion"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:580,
                                                                                            y:95,
                                                                                            html:'<div id="divComboExtensiones"></div>'
                                                                                        },
                                                                                        
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:150,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Funci&oacute;n de asignaci&oacute;n de destinatario:'
                                                                                        },
                                                                                        {
                                                                                            xtype:'textfield',
                                                                                            width:480,
                                                                                            x:350,
                                                                                            y:145,
                                                                                            cls:'controlSIUGJ',
                                                                                            id:'txtFuncionAsignacionDestinatario',
                                                                                            readOnly:true
                                                                                        },
                                                                                        {
                                                                                            xtype:'label',
                                                                                            x:840,
                                                                                            y:147,
                                                                                            html:'<a href="javascript:agregarFuncionControl(2)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionControl(2)"><img src="../images/cross.png"></a>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:190,
                                															cls:'SIUGJ_Etiqueta',
                                                                                            html:'Permitir acceso al proceso: <span style="color:#F00">*</span>'
                                                                                        },
                                                                                        {
                                                                                            x:260,
                                                                                            y:185,
                                                                                            html:'<div id="divComboAccesoProceso"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:400,
                                                                                            y:190,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Ingresar como:'
                                                                                        },
                                                                                         {
                                                                                            x:540,
                                                                                            y:185,
                                                                                            html:'<div id="divComboActorAccesoProceso"></div>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:240,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'¿Marcar como atendia al cambiar de etapa?: <span style="color:#F00">*</span>'
                                                                                        },
                                                                                        {
                                                                                            x:430,
                                                                                            y:235,
                                                                                            html:'<div id="divComboMarcarAtendido"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:290,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Notificaci&oacute;n activa: <span style="color:#F00">*</span>'
                                                                                        },
                                                                                        {
                                                                                            x:430,
                                                                                            y:285,
                                                                                            html:'<div id="divComboNotificacionActiva"></div>'
                                                                                        }
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Configuraci&oacute;n cambio etapa',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Funci&oacute;n de aplicaci&oacute;n:'
                                                                                        },
                                                                                        {
                                                                                            xtype:'textfield',
                                                                                            width:500,
                                                                                            x:230,
                                                                                            y:5,
                                                                                            cls:'controlSIUGJ',
                                                                                            id:'txtFuncionAplicacionCambioEtapa',
                                                                                            readOnly:true
                                                                                        },
                                                                                        {
                                                                                            xtype:'label',
                                                                                            x:750,
                                                                                            y:7,
                                                                                            html:'<a href="javascript:agregarFuncionControl(3)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionControl(3)"><img src="../images/cross.png"></a>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:60,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Marcar como atendida notificaciones del usuario:'
                                                                                        },
                                                                                        {
                                                                                            x:450,
                                                                                            y:55,
                                                                                            html:'<div id="divComboUsuarioMarcarAtendido" style="width:390px"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:110,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Marcar como atendida tambi&eacute;n a notificaciones delegadas:'
                                                                                        },
                                                                                        {
                                                                                            x:530,
                                                                                            y:105,
                                                                                            html:'<div id="divComboMarcarDelegadas" style="width:150px"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:160,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Si es notificaci&oacute;n delegada, marcar como atendida a la notificaci&oacute;n origen:'
                                                                                        },
                                                                                        {
                                                                                            x:650,
                                                                                            y:155,
                                                                                            html:'<div id="divComboMarcarNotificacionesOrigen" style="width:150px"></div>'
                                                                                        }
                                                                                        
                                                                            		]
                                                                        }
                                                            		]
                                                            
                                                        }
														

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configurar notificaci&oacute;n',
										width: 920,
										height:490,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	gEx('idPanelConf').setActiveTab(0);
                                                                	var cmbTipoNotificacion=crearComboExt('cmbTipoNotificacion',arrTipoNotificaciones,0,0,550,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboTipoNotificacion'});
																	var cmbRolesNotificacion=crearComboExt('cmbRolesNotificacion',arrRolesSistema,0,0,350,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboRolesNotificacion'});
                                                                    
                                                                    cmbRolesNotificacion.on('select',function(cmb,registro)	
                                                                                                    {
                                                                                                        cmbExtensiones.setValue('');
                                                                                                        var idRegistro=registro.get('id');
                                                                                                        var arrId=idRegistro.split('_');
                                                                                                        if(arrId[1]!=0)
                                                                                                        {
                                                                                                            function funcAjax()
                                                                                                            {
                                                                                                                var resp=peticion_http.responseText;
                                                                                                                arrResp=resp.split('|');
                                                                                                                if(arrResp[0]=='1')
                                                                                                                {
                                                                                                                    var arrExtensiones=eval(arrResp[1]);
                                                                                                                    cmbExtensiones.getStore().loadData(arrExtensiones);                
                                                                                                                    cmbExtensiones.enable();
                                                                                                                    
                                                                                                                }
                                                                                                                else
                                                                                                                {
                                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                }
                                                                                                            }
                                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=20&extension='+arrId[1],true);
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            cmbExtensiones.disable();
                                                                                                           
                                                                                                        }
                                                                                                    }
                                                                                            );
                                                                	var cmbExtensiones=crearComboExt('cmbExtensiones',[],0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboExtensiones'});
                                                                    cmbExtensiones.disable();
                                                                    
                                                                    var cmbAccesoProceso=crearComboExt('cmbAccesoProceso',arrSiNo,0,0,120,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboAccesoProceso'});
    
   
    
                                                                    cmbAccesoProceso.setValue('0');
                                                                    
                                                                    cmbAccesoProceso.on('select',function(cmb,registro)
                                                                                                {
                                                                                                    if(registro.data.id=='1')
                                                                                                        gEx('cmbRolesParticipantesProcesos').enable();
                                                                                                    else
                                                                                                        gEx('cmbRolesParticipantesProcesos').disable();
                                                                                                }
                                                                                        )
                                                                
                                                                	var cmbRolesParticipantesProcesos=  crearComboExt('cmbRolesParticipantesProcesos',arrRolesParticipantesProceso,0,0,340,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboActorAccesoProceso'});                          
																    cmbRolesParticipantesProcesos.setValue('0');     
                                                                
                                                                	var cmbAtendidaCambioEtapa=crearComboExt('cmbAtendidaCambioEtapa',arrSiNo,0,0,140,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboMarcarAtendido'});  
                                                                    cmbAtendidaCambioEtapa.setValue('0');
                                                                    cmbAtendidaCambioEtapa.on('select',function(cmb,registro)
                                                                                                        {
                                                                                                            if(registro.data.id=='1')
                                                                                                            {
                                                                                                                gEx('idPanelConf').unhideTabStripItem(1 );
                                                                                                            }
                                                                                                            else
                                                                                                            {
                                                                                                                gEx('idPanelConf').hideTabStripItem(1 );
                                                                                                            }
                                                                                                        }
                                                                                                )
                                                                
                                                                
                                                                	var cmbNotificacionActiva=crearComboExt('cmbNotificacionActiva',arrSiNo,0,0,140,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboNotificacionActiva'});
                                                                    cmbNotificacionActiva.setValue('1');
                                                                 
                                                                 
                                                                 	var cmbUsuarioMarcaAtendida=   crearComboExt('cmbUsuarioMarcaAtendida',arrUsuarioMarcaAtendida,0,0,380,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboUsuarioMarcarAtendido'});  
                                                                    cmbUsuarioMarcaAtendida.setValue('2');  
                                                                    
                                                                    var cmbMarcarNotificacionesDelegadas=  crearComboExt('cmbMarcarNotificacionesDelegadas',arrSiNo,0,0,140,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboMarcarDelegadas'});
                                                                    cmbMarcarNotificacionesDelegadas.setValue('1');
                                                                    var cmbMarcarNotificacionesOrigen=  crearComboExt('cmbMarcarNotificacionesOrigen',arrSiNo,0,0,140,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboMarcarNotificacionesOrigen'}); 
                                                                    cmbMarcarNotificacionesOrigen.setValue('1');             
                                                                    
                                                                    
                                                                    
                                                                    if(filaNotificacion)
                                                                    {
                                                                        cmbTipoNotificacion.setValue(filaNotificacion.data.tipoNotificacion);
                                                                        var txtFuncionAplicacion=gEx('txtFuncionAplicacion');
                                                                        txtFuncionAplicacion.setValue(filaNotificacion.data.etFuncionCondicionadora);
                                                                        txtFuncionAplicacion.idConsulta=filaNotificacion.data.funcionCondicionadora;
                                                                        
                                                                        
                                                                        if(filaNotificacion.data.rolDestinatario!='')
                                                                        {
                                                                        
                                                                            var idRegistro=filaNotificacion.data.rolDestinatario;
                                                                            var arrId=idRegistro.split('_');
                                                                            var rolSelecionado='';
                                                                            var pos;
                                                                            var x;
                                                                            for(x=0;x<arrRolesSistema.length;x++)
                                                                            {
                                                                                var aAux=arrRolesSistema[x][0].split('_');
                                                                                
                                                                                if(aAux[0]==arrId[0])
                                                                                {
                                                                                    rolSelecionado=arrRolesSistema[x][0];
                                                                                    break;
                                                                                }
                                                                                
                                                                            }
                                                                            
                                                                        
                                                                            cmbRolesNotificacion.setValue(rolSelecionado);
                                                                            cmbExtensiones.setValue('');
                                                                            var arrIdRolSelecionado=rolSelecionado.split('_');
                                                                            if(arrIdRolSelecionado[1]!=0)
                                                                            {
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        var arrExtensiones=eval(arrResp[1]);
                                                                                        cmbExtensiones.getStore().loadData(arrExtensiones);                
                                                                                        cmbExtensiones.enable();
                                                                                        if(arrId[1]!='0')
                                                                                            cmbExtensiones.setValue(arrId[1]);
                                                                                        
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=20&extension='+arrIdRolSelecionado[1],true);
                                                                            }
                                                                            else
                                                                            {
                                                                                cmbExtensiones.disable();
                                                                            }
                                                                        }
                                                                        
                                                                        var txtFuncionAsignacionDestinatario=gEx('txtFuncionAsignacionDestinatario');
                                                                        txtFuncionAsignacionDestinatario.setValue(filaNotificacion.data.etFuncionDefinicionDestinatario);
                                                                        txtFuncionAsignacionDestinatario.idConsulta=filaNotificacion.data.funcionDefinicionDestinatario;
                                                                        cmbAccesoProceso.setValue(filaNotificacion.data.permiteAccesoProceso);
                                                                        cmbRolesParticipantesProcesos.setValue(filaNotificacion.data.actorAccesoProceso);
                                                                        cmbNotificacionActiva.setValue(filaNotificacion.data.statusNotificacion);
                                                                        cmbAtendidaCambioEtapa.setValue(filaNotificacion.data.marcarAtendidaCambioEtapa);
                                                                        if(filaNotificacion.data.confComplementaria!='')
                                                                        {
                                                                            var objComp=eval('['+bD(filaNotificacion.data.confComplementaria)+']')[0];
                                                                            var txtFuncionAplicacionCambioEtapa=gEx('txtFuncionAplicacionCambioEtapa');
                                                                            txtFuncionAplicacionCambioEtapa.setValue(filaNotificacion.data.funcionAplicacionMarcaAtencion);
                                                                            txtFuncionAplicacionCambioEtapa.idConsulta=objComp.funcionAplicacion==''?-1:objComp.funcionAplicacion;
                                                                            cmbUsuarioMarcaAtendida.setValue(objComp.afectarNotificionUsuario);
                                                                            cmbMarcarNotificacionesDelegadas.setValue(objComp.afectarNotificacionesDelegadas);
                                                                            cmbMarcarNotificacionesOrigen.setValue(objComp.afectarNotificacionesPadre);
                                                                            
                                                                            
                                                                        }
                                                                    }	
                                                                    
                                                                    
                                                                    dispararEventoSelectCombo('cmbAccesoProceso');
                                                                    dispararEventoSelectCombo('cmbAtendidaCambioEtapa');
                                                                    
                                                                }
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
                                                                    	var txtFuncionAplicacionCambioEtapa=gEx('txtFuncionAplicacionCambioEtapa');
                                                                    	var txtFuncionAplicacion=gEx('txtFuncionAplicacion');
                                                                    	var txtFuncionAsignacionDestinatario=gEx('txtFuncionAsignacionDestinatario');
                                                                        var cmbTipoNotificacion=gEx('cmbTipoNotificacion');
																		if(cmbTipoNotificacion.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	gEx('idPanelConf').setActiveTab(0);
                                                                            	cmbTipoNotificacion.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de notificaci&oacute;n a ejecutar',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        actorDestinatario='';
                                                                        var cmbNotificacionActiva=gEx('cmbNotificacionActiva');
                                                                        var cmbRolesNotificacion=gEx('cmbRolesNotificacion');
                                                                        
                                                                        if(cmbRolesNotificacion.getValue()!='')
                                                                        {
                                                                        	actorDestinatario=cmbRolesNotificacion.getValue();
                                                                            
                                                                            var arrRol=actorDestinatario.split('_');
                                                                            var extension='0';
                                                                            if(arrRol[1]!='0')
                                                                            {
                                                                            	if(cmbExtensiones.getValue()!='')
                                                                                {
                                                                                	extension=cmbExtensiones.getValue();	
                                                                                }
                                                                            }
                                                                            
                                                                            actorDestinatario=arrRol[0]+'_'+extension;
                                                                            
                                                                            
                                                                            	
                                                                        }
                                                                        
                                                                        var actorAccesoProceso='';
                                                                        var cmbAccesoProceso=gEx('cmbAccesoProceso');
                                                                        var cmbRolesParticipantesProcesos=gEx('cmbRolesParticipantesProcesos');
                                                                        if(cmbAccesoProceso.getValue()=='1')
                                                                        {
                                                                        	actorAccesoProceso=cmbRolesParticipantesProcesos.getValue();
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        var idNotificacion=-1;
                                                                        if(filaNotificacion)
                                                                        {
                                                                        	idNotificacion=filaNotificacion.data.idRegistroNotificacion;
                                                                        }
                                                                        var cmbAtendidaCambioEtapa=gEx('cmbAtendidaCambioEtapa');
                                                                        var confComplementaria='';
                                                                        
                                                                        var cmbUsuarioMarcaAtendida=gEx('cmbUsuarioMarcaAtendida');
                                                                        var cmbMarcarNotificacionesDelegadas=gEx('cmbMarcarNotificacionesDelegadas');
                                                                        var cmbMarcarNotificacionesOrigen=gEx('cmbMarcarNotificacionesOrigen');
                                                                        
                                                                        
                                                                        if(cmbAtendidaCambioEtapa.getValue()=='1')
                                                                        {
                                                                        	confComplementaria='{"funcionAplicacion":"'+((txtFuncionAplicacionCambioEtapa.getValue()=='')?'-1':txtFuncionAplicacionCambioEtapa.idConsulta)+
                                                                            					'","afectarNotificionUsuario":"'+cmbUsuarioMarcaAtendida.getValue()+
                                                                                                '","afectarNotificacionesDelegadas":"'+cmbMarcarNotificacionesDelegadas.getValue()+
                                                                                                '","afectarNotificacionesPadre":"'+cmbMarcarNotificacionesOrigen.getValue()+'"}';
                                                                        }
                                                                        
                                                                        
                                                                        var cadObj='{"idNotificacion":"'+idNotificacion+'","idProceso":"'+idProceso+'","tipoNotificacion":"'+cmbTipoNotificacion.getValue()+'","funcionAplicacion":"'+
                                                                        			((txtFuncionAplicacion.getValue()=='')?'':txtFuncionAplicacion.idConsulta)+'","actorDestinatario":"'+actorDestinatario+
                                                                        			'","funcionAsignacionDestinatario":"'+((txtFuncionAsignacionDestinatario.getValue()=='')?'-1':txtFuncionAsignacionDestinatario.idConsulta)+
                                                                                    '","permiteAccesoProceso":"'+cmbAccesoProceso.getValue()+'","actorAccesoProceso":"'+actorAccesoProceso+'","notificacionActiva":"'+
                                                                                    cmbNotificacionActiva.getValue()+'","etapa":"'+etapa+'","idPerfil":"-1","confComplementaria":"'+
                                                                                    bE(confComplementaria)+'","marcarAtendidaCambioEtapa":"'+cmbAtendidaCambioEtapa.getValue()+'"}';
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gConfiguracionNotificaciones').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=236&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();
    
    
}

function removerFuncionControl(tipo)
{
	var control='';
    switch(tipo)
    {
    	case 1:
	    	control=gEx('txtFuncionAplicacion');
    	break;
        case 2:
	    	control=gEx('txtFuncionAsignacionDestinatario');
    	break;
        case 3:
	    	control=gEx('txtFuncionAplicacionCambioEtapa');
    	break;
    }
    
    
    
    
    control.idConsulta='';
    control.setValue('');
}

function agregarFuncionControl(tipo)
{

	var control='';
	switch(tipo)
    {
    	case 1:
	    	control=gEx('txtFuncionAplicacion');
    	break;
        case 2:
	    	control=gEx('txtFuncionAsignacionDestinatario');
    	break;
        case 3:
	    	control=gEx('txtFuncionAplicacionCambioEtapa');
    	break;
    }
    
    
    
    asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre,ventana)
                                            {
                                             	control.idConsulta=idConsulta;
                                                control.setValue(nombre);
                                                
                                                if(gEx('vAgregarExp'))
	                                                gEx('vAgregarExp').close();
                                            }
    mostrarVentanaExpresion(function(filaSelec,ventana)
    						{
                            	control.idConsulta=filaSelec.data.idConsulta;
                                control.setValue(filaSelec.data.nombreConsulta);
                                
                                
                                ventana.close();
                            }
    						,true);
    
}