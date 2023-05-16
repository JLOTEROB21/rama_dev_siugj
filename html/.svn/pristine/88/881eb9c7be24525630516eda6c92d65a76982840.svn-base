<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$fechaActual=date("Y-m-d");
	$fechaInicio=date("Y-m-d",strtotime("-7 days",strtotime($fechaActual)));
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica";
	$arrUnidadesGeston=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__10_tablaDinamica,nombreFormato FROM _10_tablaDinamica";
	$arrSolicitudes=$con->obtenerFilasArreglo($consulta);
?>

var arrSolicitudes=<?php echo $arrSolicitudes?>;
var arrSituacion=[['0','Espera de atenci\xF3n','../images/bullet-red.png'],['1','Atendida','../images/bullet-green.png']];

var arrUnidadesGestion=<?php echo $arrUnidadesGeston?>;    
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
	var arrResultadoExhorto=[['0','Dilegencia NO realizada'],['1','Dilegencia realizada']];
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'iRegistroOPP'},
                                                        {name: 'iFormularioOPP'},
                                                        {name: 'iRegistroUGJ'},
                                                        {name: 'iFormularioUGJ'},
                                                        {name:'carpetaJudicial'},
		                                                {name:'unidadGestion'},
                                                        {name: 'situacionRespuesta'},
                                                        {name: 'totalTareasEmitidas'},
                                                        {name: 'totalTareasVisualizadas'},
                                                        {name: 'folioRegistroOPP'},
                                                        {name: 'folioRegistroUGJ'},
                                                        {name: 'fechaRegistro', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'fechaRespuesta', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'resultadoExhorto'}
                                                        
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

                                    	proxy.baseParams.funcion=16;
                                        proxy.baseParams.fechaInicio=gEx('dtePeriodoInicial').getValue().format('Y-m-d');
                                        proxy.baseParams.fechaFin=gEx('dtePeriodoFinal').getValue().format('Y-m-d');
                                        proxy.baseParams.unidadGestion=gE('uGestion').value;
                                        
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
                                                                        	if(registro.data.totalTareasEmitidas=='0')
                                                                            {
                                                                            	return '<img width="16" height="16" src="../images/warning_2.png" title="Sin tareas generadas" alt="Sin tareas generadas"/>';
                                                                        
                                                                            }
                                                                        	var tipoSituacion=val;
                                                                            
                                                                            var pos=existeValorMatriz(arrSituacion,tipoSituacion);
                                                                            if(pos!=-1)
	                                                                        	return '<img width="16" height="16" src="'+arrSituacion[pos][2]+'" title="'+arrSituacion[pos][1]+'" alt="'+arrSituacion[pos][2]+'"/>';
                                                                        }
                                                            },   
                                                            {
                                                                header:'Folio de registro<br />(OPP)',
                                                                width:120,
                                                                sortable:true,
                                                                dataIndex:'folioRegistroOPP',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                        	return '<a href="javascript:abrirRegistroSolicitud(\''+bE(registro.data.iFormularioOPP)+'\',\''+bE(registro.data.iRegistroOPP)+'\')">'+val+'</a>';
                                                                        }
                                                            },  
                                                            {
                                                                header:'Folio de registro<br />(UGJ)',
                                                                width:120,
                                                                sortable:true,
                                                                dataIndex:'folioRegistroUGJ',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                        	return '<a href="javascript:abrirRegistroSolicitud(\''+bE(registro.data.iFormularioUGJ)+'\',\''+bE(registro.data.iRegistroUGJ)+'\')">'+val+'</a>';
                                                                        }
                                                            },                                                       
                                                            {
                                                                header:'Fecha de registro',
                                                                width:135,
                                                                sortable:true,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Carpeta de Exhorto',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'carpetaJudicial',
                                                                renderer:function(val)
                                                                		{
                                                                        	return '<a href="javascript:abrirVentanaCarpetaJudicial(\''+bE(val)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                                                                                       
                                                            {
                                                                header:'Unidad de Gesti&oacute;n',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'unidadGestion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrUnidadesGestion,val));
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
                                                            },
                                                            {
                                                                header:'Fecha de atenci&oacute;n',
                                                                width:120,
                                                                sortable:true,
                                                                dataIndex:'fechaRespuesta',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val)
	                                                                        	return val.format('d/m/Y');
                                                                        }
                                                            },
                                                            {
                                                                header:'Resultado Exhorto',
                                                                width:160,
                                                                sortable:true,
                                                                dataIndex:'resultadoExhorto',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val!='')
	                                                                        	return formatearValorRenderer(arrResultadoExhorto,val);
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
                                                                                icon:'../images/arrow_refresh.PNG',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Recargar',
                                                                                handler:function()
                                                                                        {
                                                                                            recargarGrid()
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
                                                    			funcion:16,
                                                                fechaInicio:gEx('dtePeriodoInicial').getValue().format('Y-m-d'),
                                                                fechaFin:gEx('dtePeriodoFinal').getValue().format('Y-m-d'),
                                                                unidadGestion:gE('uGestion').value
                                                                
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

function abrirDocumento(iD)
{
	if(window.parent)
		window.parent.mostrarVisorDocumentoProceso('pdf',bD(iD),null,'');
    else
    	mostrarVisorDocumentoProceso('pdf',bD(iD),null,bD(nA));
}