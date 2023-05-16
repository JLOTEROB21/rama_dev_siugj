<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$fechaActual=date("Y-m-d");
	$diaActual=date("N",strtotime($fechaActual));
	$fechaFinal=7-$diaActual;
	
	$fechaFinal=date("Y-m-d",strtotime("+".$fechaFinal." days",strtotime($fechaActual)));
	
	$consulta="SELECT  id__4_tablaDinamica,tipoAudiencia FROM _4_tablaDinamica";
	$arrAudiencias=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__15_tablaDinamica,nombreSala FROM _15_tablaDinamica";
	$arrSalas=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica";
	$arrUnidades=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idSituacion,descripcionSituacion FROM 7011_situacionEventosAudiencia";
	$arrSituacionEvento=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica WHERE categoriaDespacho=4 ORDER BY nombreUnidad";
	$arrDespachos=$con->obtenerFilasArreglo($consulta);
	
	
	$arrEspecialidades="";
	$consulta="SELECT id__637_tablaDinamica,nombreEspecialidadDespacho FROM _637_tablaDinamica ORDER by nombreEspecialidadDespacho";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT id__625_tablaDinamica,nombreTipoProceso FROM _625_tablaDinamica WHERE especialidad=".$fila[0]." ORDER BY nombreTipoProceso";
		$arrTiposProceso=$con->obtenerFilasArreglo($consulta);
		$o="['".$fila[0]."','".cv($fila[1])."',".$arrTiposProceso."]";
		if($arrEspecialidades=="")
			$arrEspecialidades=$o;
		else
			$arrEspecialidades.=",".$o;
	}
	
	$consulta="SELECT idSituacion,descripcionSituacion FROM 7011_situacionEventosAudiencia ORDER BY descripcionSituacion";
	$arrSituacionEvento=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idSituacion,icono,tamano FROM 7011_situacionEventosAudiencia";
	$arrSituaciones=$con->obtenerFilasArreglo($consulta);

	
?>
var arrSemaforo=<?php echo $arrSituaciones?>;
var arrSituacionEvento=<?php echo $arrSituacionEvento?>;
var arrEstadoProceso =[];
var arrEspecialidades=[<?php echo $arrEspecialidades?>];
var arrDespachos=<?php echo $arrDespachos?>;
var arrSituacionEvento=<?php echo $arrSituacionEvento?>;
var arrSalas=<?php echo $arrSalas?>;
var arrAudiencias=<?php echo $arrAudiencias?>;
var arrUnidades=<?php echo $arrUnidades?>;

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
                                                cls:'panelSiugj',
                                                border:false,
                                                title:gE('nombreUsuario').value,
                                               
                                                items:	[
                                                            new Ext.ux.IFrameComponent({ 
                
                                                                                              id: 'frameContenidoCalendario', 
                                                                                              anchor:'100% 100%',
                                                                                              region:'center',
                                                                                              loadFuncion:function(iFrame)
                                                                                                          {
                                                                                                              
                                                                                                          },
    
                                                                                              url: '../paginasFunciones/white.php',
                                                                                              style: 'width:100%;height:100%' 
                                                                                      })
                                                        ]
                                            }
                                         ]
                            }
                        )   


	recargarGridEventos();
}

function recargarContenedorCentral()
{
	recargarGridEventos();
}

function recargarGridEventos()
{
	gEx('frameContenidoCalendario').load	(
    								{
                                    	url:'../modulosEspeciales_SGJ/calendarioAudienciasDespacho.php',
                                        params:	{
                                        			idUsr:gE('idUsuario').value,
                                                    vVacaciones:0,
                                                    vIncidencias:0,
                                                    vGuardias:0,
                                                    vTramite:0,
                                                    cPagina:'sFrm=true'
                                                    
                                        		}
                                    }
    							)
}


function mostrarVentanaBuscarEvento()
{
	var arrFiltroFecha=[['>=','>='],['>','>'],['=','='],['<','<'],['<=','<=']];
	
    
    
    
    
    
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            region:'center',
                                                            id:'tabPanelBusqueda',
                                                            cls:'tabPanelSIUGJ',
                                                            activeTab:0,
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            
                                                                            title:'Datos generales',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:20,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Despacho:'
                                                                                        },
                                                                                        {
                                                                                            x:130,
                                                                                            y:15,
                                                                                            html:'<div id="divDespachos"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:70,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Especialidad:'
                                                                                        },
                                                                                        {
                                                                                            x:130,
                                                                                            y:65,
                                                                                            html:'<div id="divEspecialidad"></div>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:500,
                                                                                            y:70,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Tipo de Proceso:'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:660,
                                                                                            y:65,
                                                                                            html:'<div id="divFiltroProceso"></div>'
                                                                                        },
                                                                                       
                                                                                        {
                                                                                            x:10,
                                                                                            y:120,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Fecha de la Audiencia:'
                                                                                        },
                                                                                        {
                                                                                            x:230,
                                                                                            y:115,
                                                                                            html:'<div id="divFechaFiltroInicio"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:420,
                                                                                            y:115,
                                                                                            html:'<div id="divFechaInicio" style="width:140px"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:580,
                                                                                            y:125,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Y'
                                                                                        },
                                                                                         {
                                                                                            x:610,
                                                                                            y:115,
                                                                                            html:'<div id="divFechaFiltroFin"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:800,
                                                                                            y:115,
                                                                                            html:'<div id="divFechaFin" style="width:140px"></div>'
                                                                                        }, 
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:170,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Nombre del Evento:'
                                                                                        },
                                                                                        {
                                                                                            x:230,
                                                                                            y:165,
                                                                                            xtype:'textfield',
                                                                                            width:230,
                                                                                            cls:'controlSIUGJ',
                                                                                            id:'txtNombreEvento'
                                                                                        },
                                                                                         {
                                                                                            x:480,
                                                                                            y:170,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Nombre del Participante:'
                                                                                        },
                                                                                        {
                                                                                            x:720,
                                                                                            y:165,
                                                                                            xtype:'textfield',
                                                                                            width:230,
                                                                                            cls:'controlSIUGJ',
                                                                                            id:'txtNombreParticipante'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:220,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Situaci&oacute;n de la Audiencia:'
                                                                                        },
                                                                                        {
                                                                                            x:250,
                                                                                            y:215,
                                                                                            html:'<div id="divSituacionAudiencia"></div>'
                                                                                        }
                                                                                        ,
                                                                                        {
                                                                                            x:590,
                                                                                            y:215,
                                                                                            cls:'btnSIUGJCancel',
                                                                                            xtype:'button',
                                                                                            icon:'../images/magnifier.png',
                                                                                            width:150,
                                                                                            text:'Buscar',
                                                                                            handler:function()
                                                                                                    {
                                                                                                        if((gEx('fInicioFiltro').getValue()!='')&&(cmbInicioFiltro.getValue()==''))
                                                                                                        {
                                                                                                            function resp1()
                                                                                                            {
                                                                                                                cmbInicioFiltro.focus();
                                                                                                            }
                                                                                                            msgBox('Debe seleccionar la condici&oacute;n de b&uacute;squeda por fecha',resp1);
                                                                                                            return;
                                                                                                        }
                                                                                                        
                                                                                                        if((gEx('fFinFiltro').getValue()!='')&&(cmbFinFiltro.getValue()==''))
                                                                                                        {
                                                                                                            function resp2()
                                                                                                            {
                                                                                                                cmbFinFiltro.focus();
                                                                                                            }
                                                                                                            msgBox('Debe seleccionar la condici&oacute;n de b&uacute;squeda por fecha',resp2);
                                                                                                            return;
                                                                                                        }
                                                                                                    
                                                                                                        var cadObj='{"depacho":"'+gEx('cmbDespachos').getValue()+'","especialidad":"'+gEx('cmbEspecialidad').getValue()+
                                                                                                        '","tipoProceso":"'+gEx('cmbTipoProceso').getValue()+'","fechaInicioRegistro":"'+(gEx('fInicioFiltro').getValue()?gEx('fInicioFiltro').getValue().format('Y-m-d'):'')+
                                                                                                        '","fechaFinRegistro":"'+(gEx('fFinFiltro').getValue()?gEx('fFinFiltro').getValue().format('Y-m-d'):'')+
                                                                                                        '","condFInicioFiltro":"'+gEx('cmbInicioFiltro').getValue()+'","condFFinFiltro":"'+gEx('cmbFinFiltro').getValue()+
                                                                                                        '","nombreEvento":"'+cv(gEx('txtNombreEvento').getValue())+
                                                                                                        '","nombreParticipante":"'+cv(gEx('txtNombreParticipante').getValue())+
                                                                                                        '","situacionAudiencia":"'+gEx('cmbSituacionEvento').getValue()+'","tipoVista":"2","idReferencia":"<?php echo $_SESSION["codigoInstitucion"]?>"}';
                                                                                                    
                                                                                                    
                                                                                                        gEx('gResultadoBusqueda').getStore().load	(
                                                                                                                                                        {
                                                                                                                                                            url:'../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',
                                                                                                                                                            params:	{
                                                                                                                                                                        criterioBusqueda:cadObj
                                                                                                                                                                    }
                                                                                                                                                         }
                                
                                                                                                                                                    )
                                                                                                    	gEx('tabPanelBusqueda').setActiveTab(1);
                                                                                                    }
                                                                                            
                                                                                        },
                                                                                        {
                                                                                            x:750,
                                                                                            y:215,
                                                                                            width:150,
                                                                                            xtype:'button',
                                                                                            icon:'../images/find_remove.png',
                                                                                            cls:'btnSIUGJCancel',
                                                                                            text:'Limpiar Filtros',
                                                                                            handler:function()
                                                                                                    {
                                                                                                        gEx('cmbDespachos').setValue('');
                                                                                                        gEx('cmbEspecialidad').setValue('');
                                                                                                        gEx('cmbTipoProceso').setValue('');
                                                                                                        gEx('cmbInicioFiltro').setValue('');
                                                                                                        gEx('fInicioFiltro').setValue('');
                                                                                                        gEx('cmbFinFiltro').setValue('');
                                                                                                        gEx('fFinFiltro').setValue('');
                                                                                                        gEx('txtNombreEvento').setValue('');
                                                                                                        gEx('txtNombreParticipante').setValue('');
                                                                                                        gEx('cmbSituacionEvento').setValue('');
                                                                                                        var cadObj='{"depacho":"'+gEx('cmbDespachos').getValue()+'","especialidad":"'+gEx('cmbEspecialidad').getValue()+
                                                                                                        '","tipoProceso":"'+gEx('cmbTipoProceso').getValue()+'","fechaInicioRegistro":"'+(gEx('fInicioFiltro').getValue()?gEx('fInicioFiltro').getValue().format('Y-m-d'):'')+
                                                                                                        '","fechaFinRegistro":"'+(gEx('fFinFiltro').getValue()?gEx('fFinFiltro').getValue().format('Y-m-d'):'')+
                                                                                                        '","condFInicioFiltro":"'+gEx('cmbInicioFiltro').getValue()+'","condFFinFiltro":"'+gEx('cmbFinFiltro').getValue()+
                                                                                                         '","nombreEvento":"'+cv(gEx('txtNombreEvento').getValue())+
                                                                                                        '","nombreParticipante":"'+cv(gEx('txtNombreParticipante').getValue())+
                                                                                                        '","situacionAudiencia":"'+gEx('cmbSituacionEvento').getValue()+'","tipoVista":"2","idReferencia":"<?php echo $_SESSION["codigoInstitucion"]?>"}';
                                                                                                    
                                                                                                    
                                                                                                        gEx('gResultadoBusqueda').getStore().removeAll();
                                                                                                    }
                                                                                            
                                                                                        }
                                                                            
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'border',
                                                                            title:'Resultado de b&uacute;squeda',
                                                                            items:	[
                                                                            			crearGridResultadoProcesos()
                                                                            		]
                                                                        }
                                                            		]
                                                        }
                                                        
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vBusquedaProcesos',
										title: 'B&uacute;squeda de Procesos Avanzada',
										width: 1100,
										height:470,
                                        y:20,
                                        cls:'msgHistorialSIUGJ',
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
                                                                	var cmbDespachos=crearComboExt('cmbDespachos',arrDespachos,0,0,880,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divDespachos'});
                                                                    cmbDespachos.setValue('<?php echo $_SESSION["codigoInstitucion"]?>');
                                                                    cmbDespachos.disable();
                                                                    var cmbEspecialidad=crearComboExt('cmbEspecialidad',arrEspecialidades,0,0,350,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divEspecialidad'});
                                                                    cmbEspecialidad.on('select',function(cmb,registro)
                                                                                                {
                                                                                                    gEx('cmbTipoProceso').setValue('');
                                                                                                    gEx('cmbTipoProceso').getStore().loadData(registro.data.valorComp);
                                                                                                }
                                                                                        )
																	var cmbSituacionEvento=crearComboExt('cmbSituacionEvento',arrSituacionEvento,0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divSituacionAudiencia'});
                                                            		var cmbInicioFiltro=crearComboExt('cmbInicioFiltro',arrFiltroFecha,0,0,175,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divFechaFiltroInicio'});
                                                                    var cmbFinFiltro=crearComboExt('cmbFinFiltro',arrFiltroFecha,0,0,175,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divFechaFiltroFin'});
                                                            		var cmbTipoProceso=crearComboExt('cmbTipoProceso',[],0,0,350,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divFiltroProceso'});
                                                                	new Ext.form.DateField (	{
                                                                                                        renderTo:'divFechaInicio',
                                                                                                        xtype:'datefield',
                                                                                                        width:130,
                                                                                                        ctCls:'campoFechaSIUGJ',
                                                                                                        id:'fInicioFiltro'
                                                                                                    }
                                                                                             )
                                                                
                                                                	new Ext.form.DateField (	{
                                                                                                        renderTo:'divFechaFin',
                                                                                                        xtype:'datefield',
                                                                                                        width:130,
                                                                                                        ctCls:'campoFechaSIUGJ',
                                                                                                        id:'fFinFiltro'
                                                                                                    }
                                                                                             )
                                                                	
                                                                
                                                                }
															}
												},
										buttons:	[
														{
															
															text: 'Cerrar',
                                                            cls:'btnSIUGJ',
                                                            width:140,
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

function crearGridResultadoProcesos()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistroEvento'},
                                                        {name:'fechaEvento', type:'date', dateFormat:'Y-m-d'},
		                                                {name:'horaInicioEvento', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'horaFinEvento', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'horaInicioRealEvento', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'horaFinRealEvento', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'situacion'},
                                                        {name: 'sede'},
                                                        {name: 'despacho'},
                                                        {name: 'sala'},
                                                        {name:'tipoAudiencia'},
                                                        {name:'carpetaAdministrativa'},
                                                        {name: 'juez'},
                                                        {name: 'nombreEvento'},
                                                        {name: 'descripcionEvento'},
                                                        {name: 'participantes'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaEvento', direction: 'ASC'},
                                                            groupField: 'fechaEvento',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='24';
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            {
                                                                header:'ID Evento',
                                                                width:120,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'idRegistroEvento',
                                                                renderer:function(val)
                                                                		{
                                                                        	return '<a href="javascript:mostrarDatosEventoAudiencia(\''+bE(val)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'',
                                                                width:30,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'idRegistroEvento',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                            return '<a href="javascript:mostrarEventoAudienciaAgenda(\''+bE(val)+'\',\''+bE(registro.data.horaInicioEvento.format('Y-m-d H:i:s'))+'\')"><img src="../images/calendar.png" title="Ver Evento en Agenda" alt="Ver Evento en Agenda"></a>';
                                                                        
                                                                        }
                                                            },
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                css:'text-align:center;vertical-align:middle !important;',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var icono='';
                                                                            meta.attr='style="padding: 0px !important;"';
                                                                        	icono=formatearValorRenderer(arrSemaforo,val);    
                                                                            var tamano=formatearValorRenderer(arrSemaforo,val,2);                                                                            
                                                                            return '<img src="'+icono+'" width="'+tamano+'" height="'+tamano+'" title="'+formatearValorRenderer(arrSituacionEvento,val)+'" alt="'+formatearValorRenderer(arrSituacionEvento,val)+'">';
                                                                        	
                                                                        }
                                                            },
                                                             {
                                                                header:'Situaci&oacute;n audiencia',
                                                                width:190,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrSituacionEvento,val));
                                                                        }
                                                            },
                                                            {
                                                                header:'Proceso Judicial',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                            },
                                                            {
                                                                header:'Fecha de la audiencia',
                                                                width:220,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'fechaEvento',
                                                                renderer:function(val)
                                                                	{
                                                                    	return val.format('d/m/Y');
                                                                    }
                                                            },
                                                            {
                                                                header:'Hora programada de audiencia',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'horaInicioEvento',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	var comp='';
                                                                        if(val.format('d')!=registro.data.horaFinEvento.format('d'))
                                                                        {
                                                                        	comp=' del '+registro.data.horaFinEvento.format('d/m/Y');
                                                                        }

                                                                    	return 'De las '+val.format('H:i')+' hrs. a las '+registro.data.horaFinEvento.format('H:i')+' hrs.'+comp
                                                                    }
                                                            },

                                                            
                                                            {
                                                                header:'Hora de realizaci&oacute;n de audiencia',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'horaInicioRealEvento',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if(!val)
                                                                        {
                                                                        	return '(Datos no disponibles)';
                                                                        }
                                                                    	var comp='';
                                                                        if(val.format('d')!=registro.data.horaFinRealEvento.format('d'))
                                                                        {
                                                                        	comp=' del '+registro.data.horaFinRealEvento.format('d/m/Y');
                                                                        }

                                                                    	return 'De las '+val.format('H:i')+' hrs. a las '+registro.data.horaFinRealEvento.format('H:i')+' hrs.'+comp
                                                                    }
                                                            },
                                                            {
                                                                header:'Tipo de audiencia',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'tipoAudiencia',
                                                                renderer:function(val)
                                                                		{
                                                                        
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Nombre del Evento',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'nombreEvento',
                                                                renderer:function(val)
                                                                		{
                                                                        
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Sede',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'sede',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var lblSala=mostrarValorDescripcion(val);
                                                                        	return lblSala;
                                                                        }
                                                            },
                                                            {
                                                                header:'Sala',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'sala',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var lblSala=mostrarValorDescripcion(val);
                                                                            
                                                                            
                                                                            
                                                                        	return lblSala;
                                                                        }
                                                            },
                                                            {
                                                                header:'Juez',
                                                                width:320,
                                                                sortable:true,
                                                                dataIndex:'juez'
                                                            },
                                                            {
                                                                header:'Participantes',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'participantes'
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gResultadoBusqueda',
                                                                region:'center',
                                                                store:alDatos,
                                                                height:210,
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : false,
                                                                cls:'gridSiugjPrincipal',
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


function mostrarDatosEventoAudiencia(iE)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJ/pDatosAudiencia.php';
    obj.params=[['idEvento',bD(iE)],['cPagina','sFrm=true']];
    window.parent.parent.abrirVentanaFancy(obj);
}


function mostrarEventoAudienciaAgenda(iE,f)
{
	
	gEx('vBusquedaProcesos').close();
    gEx('frameContenidoCalendario').getFrameWindow().selectEvento(bD(iE),bD(f));
}