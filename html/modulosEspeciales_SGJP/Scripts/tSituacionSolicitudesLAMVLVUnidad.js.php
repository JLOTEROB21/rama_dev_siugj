<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$fechaActual=date("Y-m-d");
	$fechaInicio=date("Y-m-d",strtotime("-3 days",strtotime($fechaActual)));
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica";
	$arrUnidadesGeston=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__4_tablaDinamica,tipoAudiencia FROM _4_tablaDinamica";
	$arrSolicitudes=$con->obtenerFilasArreglo($consulta);
	
	$arrEtapasRegistro="";
	$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=250 ORDER BY numEtapa";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$o="[".$fila[0].",'".removerCerosDerecha($fila[0]).".- ".$fila[1]."']";
		if($arrEtapasRegistro=="")
			$arrEtapasRegistro=$o;
		else
			$arrEtapasRegistro.=",".$o;
	}
	$consulta="SELECT id__4_tablaDinamica,tipoAudiencia FROM _4_tablaDinamica";
	$arrSolicitudes=$con->obtenerFilasArreglo($consulta);
	
	
?>
var arrSolicitudes=<?php echo $arrSolicitudes ?>;
var arrSituacion=[	['1','Atendida','../images/bullet-green.png'],
					['2','En espera de atenci\xF3n, tarea NO Visualizada','../images/bullet-red.png'],
                    ['3','En espera de atenci\xF3n, tarea Visualizada','../images/bullet-yellow.png'],
                    ['4','No turnada','../images/exclamation.png'],
                    ['5','Sin Tareas Generadas','../images/warning_2.png']
                 ];
var arrEtapasRegistro=[<?php echo $arrEtapasRegistro?>];

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
                                                                value:'<?php echo $fechaInicio?>',
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
	
	var cmbSituacionSolicitud= crearComboExt('cmbSituacionSolicitud',[['0','Cualquiera'],['1','Atendido'],['2','En espera de atenci\xF3n']],0,0,180);
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
		                                                {name: 'fechaRegistro', type:'date', date:'Y-m-d H:i:s'},
		                                                {name:'fechaFenecimiento', type:'date', date:'Y-m-d H:i:s'},
		                                                {name:'unidadGestion'},
                                                        {name: 'tipoSolicitud'},
                                                        {name: 'etapaActual'},
                                                        {name: 'totalTareasEmitidas'},
                                                        {name: 'totalTareasVisualizadas'},
                                                        {name: 'horasMaximaAtencion'},
                                                        {name: 'folioRegistro'},
                                                        {name: 'asuntoPromocion'},
                                                        {name: 'totalAudienciasGeneradas'},
                                                        {name: 'acuerdoNotificado'},
                                                        {name: 'generoAcuerdo'},
                                                        {name: 'victima'},
                                                        {name: 'centroRegistro'}
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
                                                            sortInfo: {field: 'fechaRegistro',  direction: 'DESC'},
                                                            groupField: 'fechaRegistro', 
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	gEx('btnAtendida').disable();
                                    	proxy.baseParams.funcion='322';
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
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var etapaActual=parseFloat(registro.data.etapaActual);
                                                                        	var tipoSituacion='';
                                                                            if(etapaActual>2)
                                                                            {
                                                                            	tipoSituacion='1';
                                                                            }
                                                                            else
                                                                            {
                                                                                 if(registro.data.totalTareasEmitidas=='0')
                                                                                      tipoSituacion='5';
                                                                                  else
                                                                                  {
                                                                                      if(registro.data.totalTareasVisualizadas=='0')
                                                                                          tipoSituacion='2';
                                                                                      else
                                                                                          tipoSituacion='3';
                                                                                      
                                                                                  }
                                                                                
                                                                            }
                                                                            var pos=existeValorMatriz(arrSituacion,tipoSituacion);
                                                                            
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
                                                                header:'Horas m&aacute;ximas<br />de atenci&oacute;n',
                                                                width:95,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'horasMaximaAtencion',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val=='-1')
                                                                            {
                                                                            	return '--';
                                                                            }
                                                                            return val;
                                                                         }
                                                                    
                                                            },
                                                            {
                                                                header:'Fecha m&aacute;xima<br> de atenci&oacute;n',
                                                                width:105,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'fechaFenecimiento',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val)
	                                                                        	return val.format('d/m/Y H:i');
                                                                            return '--/--/----';
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
                                                                        	return formatearValorRenderer(arrSolicitudes,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'V&iacute;ctima',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'victima',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val;
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
                                                                header:'Centro de Registro',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'centroRegistro',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(val);
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
                                                                header:'Total audiencias<br>generadas',
                                                                width:110,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'totalAudienciasGeneradas',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                            return val;
                                                                        	
                                                                        }
                                                            },
                                                            
                                                             {
                                                                header:'Generó<br>acuerdo',
                                                                width:80,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'generoAcuerdo',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                            return val=='1'?'<span style="color:#030; font-weight:bold">S&iacute;</span>':'<span style="color:#900; font-weight:bold">No</span>';
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:'Acuerdo<br>notificado',
                                                                width:80,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'acuerdoNotificado',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                             return val=='1'?'<span style="color:#030; font-weight:bold">S&iacute;</span>':'<span style="color:#900; font-weight:bold">No</span>';
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n actual',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'etapaActual',
                                                                renderer:function(val,meta,registro)
                                                                		{

                                                                            
                                                                           
                                                                        	return formatearValorRenderer(arrEtapasRegistro,val,1,true);
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
                                                                                text:'Marcar solicitud como atendida',
                                                                                handler:function()
                                                                                        {
                                                                                        	var fila=gEx('gSolicitudesIniciales').getSelectionModel().getSelected();
                                                                                         	
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la solicitud que desea marcar como atendida');
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
                                                	var etapaActual=parseFloat(registro.data.etapaActual);
                                                    var tipoSituacion='';
                                                    if(etapaActual>=3)
                                                    {
                                                        tipoSituacion='1';
                                                    }
                                                    else
                                                    {
                                                        if(etapaActual==1.4)
                                                        {
                                                            tipoSituacion='4';
                                                        }
                                                        else
                                                        {
                                                            if(registro.data.totalTareasEmitidas=='0')
                                                                tipoSituacion='5';
                                                            else
                                                            {
                                                                if
                                                                (
                                                                    ((registro.data.iFormulario=='46') &&(( etapaActual==2.7)||( etapaActual==2.5)))||
                                                                    ((registro.data.iFormulario=='96') &&( etapaActual==2))
                                                                )
                                                                {
                                                                    if(registro.data.totalTareasVisualizadas=='0')
                                                                        tipoSituacion='2';
                                                                    else
                                                                        tipoSituacion='3';
                                                                    
                                                                }
                                                                else
                                                                {
                                                                    tipoSituacion='1';
                                                                }
                                                            }
                                                        }
                                                    }
                                                    
                                                    
                                                    if(tipoSituacion!='1')
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
                                                	url:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                    params:	{
                                                    			funcion:'322',
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
                                                            html:'Indique el motivo por el cual la solicitud es marcada como atendida:'
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
                                                                            	msgBox('Debe indicar el motivo por el cual la solicitud es marcada como atendida',resp);
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
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=252&cadObj='+cadObj,true);
                                                                                
                                                                                
                                                                                
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