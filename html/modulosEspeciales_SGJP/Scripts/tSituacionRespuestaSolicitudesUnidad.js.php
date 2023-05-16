<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$fechaActual=date("Y-m-d");
	$fechaInicio=date("Y-m-d",strtotime("-3 days",strtotime($fechaActual)));
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica";
	$arrUnidadesGeston=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT cveTipoSolicitud,tipoSolicitud FROM _285_tablaDinamica";
	$arrSolicitudes=$con->obtenerFilasArreglo($consulta);
	
	$arrEtapasSolIniciales="";
	$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=89 ORDER BY numEtapa";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$o="[".$fila[0].",'".removerCerosDerecha($fila[0]).".- ".$fila[1]."']";
		if($arrEtapasSolIniciales=="")
			$arrEtapasSolIniciales=$o;
		else
			$arrEtapasSolIniciales.=",".$o;
	}
	
	$arrEtapasSolPromociones="";
	$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=103 ORDER BY numEtapa";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$o="[".$fila[0].",'".removerCerosDerecha($fila[0]).".- ".$fila[1]."']";
		if($arrEtapasSolPromociones=="")
			$arrEtapasSolPromociones=$o;
		else
			$arrEtapasSolPromociones.=",".$o;
	}
	
?>
var arrSituacion=[	['1','Respuesta Notificada','../images/bullet-green.png'],
					['0','Respuesta NO notificada','../images/bullet-red.png'],
                    ['2','Con errores NO notificado','../images/bullet-red.png'],
                    ['3','Respuesta Marcada como Notificada','../images/bullet_white.png']
                    
                 ];
var arrEtapasSolIniciales=[<?php echo $arrEtapasSolIniciales?>];
var arrEtapasSolPromociones=[<?php echo $arrEtapasSolPromociones?>];
var arrSolicitudes=<?php echo $arrSolicitudes?>;	
var arrUnidadesGestion=<?php echo $arrUnidadesGeston?>;    
var arrModulos=[['46','Registro solicitud inicial'],['96','Recepci&oacute;n de promociones']];    
Ext.onReady(inicializar);

function inicializar()
{
	
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                tbar:	[	
                                                			{
                                                            	xtype:'label',
                                                                html:'&nbsp;&nbsp;&nbsp;<b>Unidad de Gesti&oacute;n Judicial:</b>&nbsp;<span style="color: #900"><b>'+gE('nombreUnidad').value+'</b></span>&nbsp;&nbsp;'
                                                            },'-',
                                                			{
                                                            	xtype:'label',
                                                                html:'&nbsp;&nbsp;&nbsp;<b>Periodo del:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dtePeriodoInicial',
                                                                value:'<?php echo $fechaActual?>',
                                                                listeners:	{
                                                                				select:function()
                                                                                		{
                                                                                        	recargarGrid();
                                                                                        }
                                                                                        
                                                                			}
                                                            },'-',
                                                            {
                                                            	xtype:'label',
                                                                html:'&nbsp;&nbsp;&nbsp;<b>Periodo al:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dtePeriodoFinal',
                                                                value:'<?php echo $fechaActual?>',
                                                                listeners:	{
                                                                				select:function()
                                                                                		{
                                                                                        	recargarGrid();
                                                                                        }
                                                                                        
                                                                			}
                                                            },'-'
                                                		],
                                                items:	[
                                                           crearGridSolicitudes()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}

function crearGridSolicitudes()
{
	var cmbSituacionSolicitud= crearComboExt('cmbSituacionSolicitud',[['4','Cualquiera'],['0','Respuesta NO notificada'],['1','Respuesta Notificada']],0,0,180);
    cmbSituacionSolicitud.setValue('0');
    cmbSituacionSolicitud.on('select',function()
    							{
                                	recargarGrid();
                                }
                      )                     
                      
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'iRegistro'},
                                                        {name: 'iFormulario'},
                                                        {name:'carpetaAdministrativa'},
		                                                {name:'unidadGestion'},
                                                        {name: 'tipoSolicitud'},
                                                        {name: 'situacionRespuesta'},
                                                        {name: 'totalTareasEmitidas'},
                                                        {name: 'totalTareasVisualizadas'},
                                                        {name: 'horasMaximaAtencion'},
                                                        {name: 'folioRegistro'},
                                                        {name: 'fechaRegistro', type:'date', dateFormat:'Y-m-d H:i:s'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaRegistro',  direction: 'DESC'},
                                                            groupField: 'fechaRegistro', 
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	gEx('btnAtendida').disable();
                                    	proxy.baseParams.funcion=7;
                                        proxy.baseParams.fechaInicio=gEx('dtePeriodoInicial').getValue().format('Y-m-d');
                                        proxy.baseParams.fechaFin=gEx('dtePeriodoFinal').getValue().format('Y-m-d');
                                        proxy.baseParams.unidadGestion=gE('uGestion').value;
                                        proxy.baseParams.situacionSolicitud=gEx('cmbSituacionSolicitud').getValue();
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:30}), 
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'situacionRespuesta',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                        	var tipoSituacion=val;
                                                                            
                                                                            var pos=existeValorMatriz(arrSituacion,tipoSituacion);
                                                                            if(pos!=-1)
	                                                                        	return '<img width="16" height="16" src="'+arrSituacion[pos][2]+'" title="'+arrSituacion[pos][1]+'" alt="'+arrSituacion[pos][2]+'"/>';
                                                                        }
                                                            },   
                                                            {
                                                                header:'Folio de registro',
                                                                width:95,
                                                                sortable:true,
                                                                dataIndex:'folioRegistro',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:abrirRegistroSolicitud(\''+bE(registro.data.iFormulario)+'\',\''+bE(registro.data.iRegistro)+'\')">'+val+'</a>';
                                                                        }
                                                            },                                                        
                                                            {
                                                                header:'Fecha de registro',
                                                                width:105,
                                                                sortable:true,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Carpeta Judicial',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa',
                                                                renderer:function(val)
                                                                		{
                                                                        	return '<a href="javascript:abrirVentanaCarpetaJudicial(\''+bE(val)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Tipo de solicitud',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'tipoSolicitud',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val=='-1')
                                                                            	return mostrarValorDescripcion(registro.data.asuntoPromocion);
                                                                        	return formatearValorRenderer(arrSolicitudes,val);
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Unidad de Gesti&oacute;n',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'unidadGestion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrUnidadesGestion,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Total tareas<br>generadas',
                                                                width:80,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'totalTareasEmitidas',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(val!='0')
                                                                            	return '<a href="javascript:mostrarTareasGeneradas(\''+bE(registro.data.iFormulario)+'\',\''+
                                                                                		bE(registro.data.iRegistro)+'\',0)">'+val+'</a>';
                                                                            return val;
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:'Total tareas<br>visualizadas',
                                                                width:80,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'totalTareasVisualizadas',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(val!='0')
                                                                            	return '<a href="javascript:mostrarTareasGeneradas(\''+bE(registro.data.iFormulario)+'\',\''+
                                                                                		bE(registro.data.iRegistro)+'\',1)">'+val+'</a>';
                                                                            return val;
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n actual',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'situacionRespuesta',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return formatearValorRenderer(arrSituacion,val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gSolicitudesIniciales',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,     
                                                                tbar:	[
                                                                            
                                                                             {
                                                                                xtype:'label',
                                                                                html:'<b>&nbsp;&nbsp;&nbsp;Observar solicitudes en situaci&oacute;n:&nbsp;&nbsp;&nbsp;</b>'
                                                                            },
                                                                            cmbSituacionSolicitud,'-',
                                                                            {
                                                                                icon:'../images/arrow_refresh.PNG',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Recargar',
                                                                                handler:function()
                                                                                        {
                                                                                            recargarGrid()
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/accept_green.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                id:'btnAtendida',
                                                                                text:'Marcar solicitud como notificada',
                                                                                handler:function()
                                                                                        {
                                                                                        	var fila=gEx('gSolicitudesIniciales').getSelectionModel().getSelected();
                                                                                         	
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la solicitud que desea marcar como notificada');
                                                                                            	return;
                                                                                            }
                                                                                            mostrarVentanaAtendido(fila);  
                                                                                        }
                                                                                
                                                                            }
                                                                		],                                                           
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
	
    tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
    											{
                                                	gEx('btnAtendida').disable();
                                                	
                                                    if(registro.data.situacionRespuesta!='1')
                                                    {
                                                    	gEx('btnAtendida').enable();
                                                    }
                                                }
    							)
    return 	tblGrid;
}

function mostrarTareasGeneradas(iF,iR,tT)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridTareasAsociadas(iF,iR,tT)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Tareas '+(tT==0?'Generadas':'Visualizadas'),
										width: 850,
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

function crearGridTareasAsociadas(iF,iR,tT)
{
    var lector= new Ext.data.JsonReader({
                                          
                                          totalProperty:'numReg',
                                          fields: [
                                                      {name:'idRegistro'},
                                                      {name: 'fechaAsignacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                      {name:'tipoNotificacion'},
                                                      {name:'usuarioDestinatario'},
                                                      {name: 'fechaVisualizacion', type:'date', dateFormat:'Y-m-d H:i:s'}
                                                  ],
                                          root:'registros'
                                          
                                      }
                                    );
    
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                reader: lector,
                                                proxy : new Ext.data.HttpProxy	(

                                                                                  {

                                                                                      url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                  }

                                                                              ),
                                                sortInfo: {field: 'fechaAsignacion', direction: 'ASC'},
                                                groupField: 'tipoNotificacion',
                                                remoteGroup:false,
                                                remoteSort: false,
                                                autoLoad:true
                                                
                                            }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='251';
                                        proxy.baseParams.idFormulario=bD(iF);
                                        proxy.baseParams.idRegistro=bD(iR);
                                        proxy.baseParams.tTarea=tT;
                                        
                                        
                                    }
                        )   
       
	var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:30}),
                                                            
                                                            {
                                                                header:'Fecha de asignaci&oacute;n',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'fechaAsignacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de visualizaci&oacute;n',
                                                                width:140,
                                                                
                                                                sortable:true,
                                                                dataIndex:'fechaVisualizacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val)
	                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            {
                                                                header:'Tipo de notificaci&oacute;n',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'tipoNotificacion',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Usuario destinatario',
                                                                width:380,
                                                                sortable:true,
                                                                dataIndex:'usuarioDestinatario',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
	var tblGrid=	new Ext.grid.GridPanel	(
                                                {
                                                    id:'gTareasAsociadas',
                                                    store:alDatos,
                                                    region:'center',
                                                    frame:false,
                                                    cm: cModelo,
                                                    stripeRows :true,
                                                    loadMask:true,
                                                    columnLines : true,
                                                    
                                                    view:new Ext.grid.GroupingView({
                                                                                        forceFit:false,
                                                                                        showGroupName: false,
                                                                                        enableGrouping :false,
                                                                                        enableNoGroups:false,
                                                                                        enableGroupingMenu:true,
                                                                                        hideGroupedColumn: true,
                                                                                        startCollapsed:false
                                                                                    })
                                                }
                                            );
	return 	tblGrid;
}

function recargarGrid()
{
	gEx('gSolicitudesIniciales').getStore().load	(
    											{
                                                	url:'../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php',
                                                    params:	{
                                                    			funcion:7,
                                                                fechaInicio:gEx('dtePeriodoInicial').getValue().format('Y-m-d'),
                                                                fechaFin:gEx('dtePeriodoFinal').getValue().format('Y-m-d'),
                                                                unidadGestion:gE('uGestion').value,
                                                                
                                                                situacionSolicitud:gEx('cmbSituacionSolicitud').getValue()
                                                    		}
                                                }
                                                
    										)
}

function abrirRegistroSolicitud(iF,iR)
{
	if(window.parent.parent)
		window.parent.parent.abrirFormularioProcesoFancy(iF,iR,bE(0));
    else
    	abrirFormularioProcesoFancy(iF,iR,bE(0));
}


function mostrarVentanaAtendido(fila)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:'10',
                                                            y:'10',
                                                            html:'Indique el motivo por el cual la solicitud es marcada como notificada:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            xtype:'textarea',
                                                            width:620,
                                                            height:80,
                                                            id:'txtMotivo'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Marcar solicitud como atendida',
										width: 670,
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
                                                                	gEx('txtMotivo').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtMotivo=gEx('txtMotivo');
                                                                        if(txtMotivo.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtMotivo.focus();
                                                                            }
                                                                            	msgBox('Debe indicar el motivo por el cual la solicitud es marcada como notificada',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        function respAux(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                            	var cadObj='{"idFormulario":"'+fila.data.iFormulario+'","idRegistro":"'+fila.data.iRegistro+'","motivoCambio":"'+cv(txtMotivo.getValue())+'"}';
                                                                                
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                     	gEx('gSolicitudesIniciales').getStore().reload();  
                                                                                        ventanaAM.close(); 
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php',funcAjax, 'POST','funcion=8&cadObj='+cadObj,true);
                                                                                
                                                                                
                                                                                
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer marcar la solicitud como atendida?',respAux);
                                                                        
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


function abrirVentanaCarpetaJudicial(cA)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tableroAudienciaAdministracion.php';
    obj.params=[['cA',cA],['idCarpetaAdministrativa',-1]];
    obj.titulo='Carpeta Judicial: '+bD(cA);
    abrirVentanaFancySuperior(obj);
}