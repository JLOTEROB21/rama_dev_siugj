<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$fechaActual=date('Y-m-d');
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	$consulta="select HEX(AES_ENCRYPT('".$_SESSION["idUsr"]."', '".bD($versionLatis)."'))";
	$idUsuario=$con->obtenerValor($consulta);
?>

var iNotififyAlerta;
var arrStatusAlerta=[['-1','<span style="color:#030">Activa</span>'],['1','<span style="color:#030">Activa</span>'],['3','<span style="color:#0E3A92">Atendida</span>'],['2','<span style="color:#900">Cancelada</span>']];
var arrSiNo=<?php echo $arrSiNo?>;


function dispararAnalisisAlertas()
{
	setInterval(	function()
    				{  
                    
                    	function funcAjax(peticion_http)
                        {
                            var resp=peticion_http.responseText;
                            arrResp=resp.split('|');
                            if(arrResp[0]=='1')
                            {
                                var oResp=eval('['+arrResp[1]+']')[0];
                                if(parseInt(oResp.registrosNuevos)>0)
                                {
                                	var lblLeyenda='';
                                    if(oResp.registrosNuevos=='1')
                                    {
                                        lblLeyenda='Se ha detectado 1 nuevo mensaje de recordatorio';
                                    }
                                    else
                                    {
                                        lblLeyenda='Se han detectado '+oResp.registrosNuevos+' nuevos mensajes de recordatorio';
                                    }
                                    if(iNotififyAlerta)
                                        iNotififyAlerta.cerrar();
                                    iNotififyAlerta=	$.ClassyNotty({
                                                            
                                                                        content : '<div style="text-align:center">'+lblLeyenda+', para m&aacute;s detalle de click <a style="text-decoration:none" href="javascript:mostrarVentanaRecordatoriosDia()"><span style="color:#900"><b>AQU&Iacute;</b></span></a></div>',
                                                                        showTime:false
                                                                    });
                                }
                            }
                            else
                            {
                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                            }
                        }
                        obtenerDatosWebV2('../paginasFunciones/funcionesTblFormularios.php',funcAjax, 'POST','funcion=13&consultaAutomatica=1&iU=<?php echo $idUsuario?>',false);
                    
                    }, 
               300000);

   
}

function mostrarVentanaRecordatoriosDia()
{
	iNotififyAlerta.cerrar();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			crearGridRecordatoriosDia()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Recordatorios del d&iacute;a',
										width: 710,
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
	ventanaAM.show();
}	

function crearGridRecordatoriosDia()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'carpetaAdministrativa'},
		                                                {name:'descripcion'},
		                                                {name:'valorReferencia1'},
                                                        {name: 'valorReferencia2'},
                                                        {name: 'fechaRegistro', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'responsableRegistro'},
                                                        {name: 'tipoAlerta'},
                                                        {name: 'fechaAlerta', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'idTitularAlerta'},
                                                        {name: 'objConfiguracion'},
                                                        {name: 'situacion'},
                                                        {name: 'comentariosAlerta'},
                                                        {name: 'responsableCancelacion'},
                                                        {name: 'detallesAdicionales'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesTblFormularios.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaAlerta', direction: 'ASC'},
                                                            groupField: 'fechaAlerta',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                   		gEx('btnAtendidaAlerta').disable();
                                    	proxy.baseParams.funcion='12';
                                        proxy.baseParams.esRecordatorioDia='1';
                                        
                                        proxy.baseParams.fI=gEx('txtFechaInicio').getValue().format('Y-m-d');
                                        proxy.baseParams.fF=gEx('txtFechaFin').getValue().format('Y-m-d');
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:30}),
                                                            
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'idTitularAlerta',
                                                                renderer:function(val)
                                                                		{
                                                                			if(val=='')
                                                                				return '<img src="../images/users.png" title="Alerta General">';
                                                                			return '<img src="../images/user.png" title="Alerta Personal">';
                                                                		}
                                                            },
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'objConfiguracion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                			
                                                                			
                                                                			if(val!='')
                                                                			{
                                                                				
                                                                				var objConfiguracion=eval('['+bD(val)+']')[0];
                                                                				
																				return '<a href="javascript:'+objConfiguracion.funcion+'(\''+val+'\')"><img src="../images/magnifier.png"></a>'	;
                                                                			}
                                                                			
                                                                			
                                                                		}
                                                            },
                                                            {
                                                                header:'Fecha de alerta',
                                                                width:120,
                                                                sortable:true,
                                                                dataIndex:'fechaAlerta',
                                                                renderer:function(val)
                                                                		{
                                                                			return val.format('d/m/Y');
                                                                		}
                                                            },
                                                            {
                                                                header:'Carpeta Judicial',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                                
                                                            },
                                                            {
                                                                header:'Fecha de registro',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val)
                                                                		{
                                                                			return val.format('d/m/Y H:i:s');
                                                                		}
                                                            },
                                                            
                                                             {
                                                                header:'Status alerta',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val)
                                                                		{
																			return '<b>'+formatearValorRenderer(arrStatusAlerta,val)+'</b>';
                                                                		}
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gAlertasNotificaciones',
                                                                store:alDatos,
                                                                height:360,                                                                
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true, 
                                                                
                                                                tbar: 	[
                                                               				{
																				html:'<b>Mostrar alertas/notificaciones del:&nbsp;&nbsp;</b>'
                                                               				},
                                                               				{
                                                               					xtype:'datefield',
                                                               					id:'txtFechaInicio',
                                                               					listeners:  {
                                                              									select:recargarGridAlertas
                                                               								},
                                                               					value:'<?php echo $fechaActual?>'
                                                               				},
                                                               				{
																				html:'&nbsp;&nbsp;<b>al&nbsp;&nbsp;</b>'
                                                               				},
                                                               				{
                                                               					xtype:'datefield',
                                                               					id:'txtFechaFin',
                                                               					listeners:  {
                                                              									select:recargarGridAlertas
                                                               								},
                                                               					value:'<?php echo $fechaActual?>'
                                                               				},'-',
                                                               				
                                                               				{
																				icon:'../images/icon_big_tick.gif',
																				cls:'x-btn-text-icon',
																				id:'btnAtendidaAlerta',
																				text:'Marcar como atendida',
																				handler:function()
																						{
																							var fila=gEx('gAlertasNotificaciones').getSelectionModel().getSelected();
																							if(!fila)
																							{
																								msgBox('Debe seleccionar la alerta/notificaci&oacute;n a marcar como atendida');
																								return;
																							}
																							mostrarVentanaAtendida(fila);
																						}

																			}
                                                                		],
                                                                		                                                               
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    enableRowBody:true,
                                                                                                    groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "alertas/notificaciones" : "alerta/notificaci&oacute;n"]})',
						                                                                            getRowClass : formatearFilaNotificacion,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        
        tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
												{
													gEx('btnAtendidaAlerta').disable();
													if(registro.data.situacion=='1')
														gEx('btnAtendidaAlerta').enable();
												}
									)
        tblGrid.getSelectionModel().on('rowdeselect',function(sm,nFila,registro)
													{
														gEx('btnAtendidaAlerta').disable();

													}
										)
        return 	tblGrid;	
}

function formatearFilaNotificacion(record, rowIndex, p, ds) 
{
	var xf = Ext.util.Format;   
    
	p.body = 	'<br><table width="100%"><tr><td width="20"></td><td>';
   	p.body +=		'<table width="650">';
	p.body +=			'<tr height="21"><td valign="top" ><span class="TSJDF_Control">'+record.data.descripcion+'<br></span></td></tr>';
	
	switch(record.data.situacion)
	{
		case '2':
			p.body +=			'<tr height="21"><td valign="top" ><span class="TSJDF_Etiqueta"><br>Motivo de la cancelaci&oacute;n (Cancelado por: '+record.data.responsableCancelacion+'):</span></td></tr>';
			p.body +=			'<tr height="21"><td valign="top" ><span class="TSJDF_Control">'+record.data.comentariosAlerta+'<br></span></td></tr>';
		break;
		case '3':
			p.body +=			'<tr height="21"><td valign="top" ><span class="TSJDF_Etiqueta"><br>Comentarios de la atenci&oacute;n (Atendido por: '+record.data.responsableCancelacion+'):</span></td></tr>';
			p.body +=			'<tr height="21"><td valign="top" ><span class="TSJDF_Control">'+(record.data.comentariosAlerta.trim()==''?'(Sin comentarios)':record.data.comentariosAlerta.trim())+'<br></span></td></tr>';
		break;
	}
	
	if(record.data.detallesAdicionales!='')
	{
		p.body +=				'<tr height="21"><td valign="top" ><span class="TSJDF_Control">'+record.data.detallesAdicionales+'<br></span></td></tr>';
	}
	
   p.body +=		'</table>';
    p.body +=	'</p>';
	p.body +=	'</td></tr></table><br>';
    return 'x-grid3-row-expanded';
}

function recargarGridAlertas()
{
	gEx('gAlertasNotificaciones').getStore().load	(
														{
															url:'../paginasFunciones/funcionesTblFormularios.php',
															params: {
																		funcion:'12',
																		fI:gEx('txtFechaInicio').getValue().format('Y-m-d'),
																		fF:gEx('txtFechaFin').getValue().format('Y-m-d')
																	}
														}
													)
}

function mostrarVentanaAtendida(fila)
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
                                            				html:'Comentarios adicionales:'
                                            				
                                            			},
                                            			{
                                            				xtype:'textarea',
                                            				x:10,
                                            				y:40,
                                            				width:550,
                                            				height:100,
                                            				id:'txtComentariosAdicionales'
                                            			}
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Marcar alerta/notificaci&oacute;n como atendida',
										width: 600,
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
																	gEx('txtComentariosAdicionales').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
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
																						gEx('gAlertasNotificaciones').getStore().reload();
																						ventanaAM.close();
																					}
																					else
																					{
																						msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																					}
																				}
																				obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=159&iA='+fila.data.idRegistro+'&s=3&c='+cv(gEx('txtComentariosAdicionales').getValue()),true);
																			}
																		}
																		msgConfirm('Est&aacute; seguro de querer marcar la alerta/notificaci&oacute;n como atendida',resp);
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
