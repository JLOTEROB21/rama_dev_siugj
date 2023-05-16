<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__406_tablaDinamica,pena,CONCAT(tipoEntrada,'_',pSustitutivo),p.idPadre FROM _406_tablaDinamica s,_406_sustitutivos p 
				WHERE categoria=2 AND p.idOpcion=s.id__406_tablaDinamica  ORDER BY p.idPadre,id__406_tablaDinamica";
	$arrSustitutivo=$con->obtenerFilasArreglo($consulta);
?>

var arrStatusAlerta=[['1','<span style="color:#030">Activa</span>'],['3','<span style="color:#0E3A92">Atendida</span>'],['2','<span style="color:#900">Cancelada</span>']];
var arrSustitutivo=<?php echo $arrSustitutivo?>;
var filaPena;
var arrSiNo=<?php echo $arrSiNo?>;
var arrMedio=[['1','En audiencia'],['2','Por escrito']];
var arrJuecesUnidad=[];
var arrSituacion=[	['1','En cumplimiento','../images/bullet-green.png'],['2','Extinta','../images/bullet-grey.png'],['3','Prescrita','../images/bullet-red.png'],
					['4','Acogida a suspensi\xF3n condicional','../images/bullet-blue.png'],['5','En cumplimiento','../images/bullet-green.png'],
					['6','Acogida a sustitutivo','../images/bullet-blue.png'],['7','En cumplimiento','../images/bullet-green.png']];
var arrSituacionCambio=[['1','En cumplimiento'],['2','Extinta'],['3','Prescrita']];
var arrSituacionPena=[['1,5,7','En cumplimiento'],['2','Extinta'],['3','Prescrita'],['4','Acogida a suspensi\xF3n condicional'],['6','Acogida a sustitutivo'],['1,2,3,4,5,6,7','Cualquiera']];

 
Ext.onReady(inicializar);

function inicializar()
{
	Ext.QuickTips.init();
	var cmbSituacionPenas=crearComboExt('cmbSituacionPenas',arrSituacionPena,0,0,220);
    cmbSituacionPenas.setValue('1,2,3,4,5,6,7');
    cmbSituacionPenas.on('select',recargarGridPenas);
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Penas (Concentrado)</b></span>',      
                                                tbar:	[
                                                            {
                                                                html:'<b>Mostrar penas en situaci&oacute;n:&nbsp;&nbsp;</b>'
                                                            },
                                                            cmbSituacionPenas                                                
                                                           ,'-',
                                                            {
                                                                html:'<b>Inicien entre:&nbsp;&nbsp;</b>'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dteInicio1',
                                                                listeners:	{
                                                                				change:function(ctrl,nValor,oValor)
                                                                                		{
                                                                                        	if((gEx('dteInicio2').getValue()=='')||((gEx('dteInicio2').getValue().format('Y-m-d')==oValor.format('Y-m-d'))))
                                                                                            {
                                                                                            	gEx('dteInicio2').setValue(nValor);
                                                                                            }
                                                                                            recargarGridPenas();
                                                                                        }
                                                                			}
                                                            },
                                                            {
                                                                html:'<b>&nbsp;&nbsp;y&nbsp;&nbsp;</b>'
                                                            },
                                                             {
                                                            	xtype:'datefield',
                                                                id:'dteInicio2',
                                                                listeners:	{
                                                                				change:function(ctrl,nValor,oValor)
                                                                                		{
                                                                                        	if(gEx('dteInicio1').getValue()=='')
                                                                                            {
                                                                                            	gEx('dteInicio1').setValue(nValor);
                                                                                            }
                                                                                            recargarGridPenas();
                                                                                        }
                                                                			}
                                                            },
                                                            {
                                                            	icon:'../images/find_remove.png',
                                                                cls:'x-btn-text-icon',
                                                                tooltip:'Remover filtro',
                                                                handler:function()
                                                                        {
                                                                        	gEx('dteInicio1').setValue('');
                                                                            gEx('dteInicio2').setValue('');
                                                                           	recargarGridPenas();
                                                                        }
                                                                
                                                            },
                                                            '-',
                                                            {
                                                                
                                                                html:'<b>Terminen entre:&nbsp;&nbsp;</b>'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dteTermine1',
                                                                listeners:	{
                                                                				change:function(ctrl,nValor,oValor)
                                                                                		{
                                                                                        	if((gEx('dteTermine2').getValue()=='')||((gEx('dteTermine2').getValue().format('Y-m-d')==oValor.format('Y-m-d'))))
                                                                                            {
                                                                                            	gEx('dteTermine2').setValue(nValor);
                                                                                            }
                                                                                            recargarGridPenas();
                                                                                        }
                                                                			}
                                                            },
                                                            {
                                                                html:'<b>&nbsp;&nbsp;y&nbsp;&nbsp;</b>'
                                                            },
                                                             {
                                                            	xtype:'datefield',
                                                                id:'dteTermine2',
                                                                listeners:	{
                                                                				change:function(ctrl,nValor,oValor)
                                                                                		{
                                                                                        	if(gEx('dteTermine1').getValue()=='')
                                                                                            {
                                                                                            	gEx('dteTermine1').setValue(nValor);
                                                                                            }
                                                                                            recargarGridPenas();
                                                                                        }
                                                                			}
                                                            },
                                                            {
                                                            	icon:'../images/find_remove.png',
                                                                cls:'x-btn-text-icon',
                                                                tooltip:'Remover filtro',
                                                                handler:function()
                                                                        {
                                                                        	gEx('dteTermine1').setValue('');
                                                                            gEx('dteTermine2').setValue('');
                                                                           	recargarGridPenas();
                                                                        }
                                                                
                                                            }
                                                        ],                                         
                                                items:	[
                                                            crearGridConcentradoPenas()
                                                        ]
                                            }
                                         ]
                            }
                        )   
                        
	gEx('gGridPenas').getStore().load	(
    										{
                                            	url:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                params:	{
                                                			start:0,
                                                			limit:300
														}
                                            }
    									);                      
}

function crearGridConcentradoPenas()
{
	
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
		                                                {name: 'idPena'},
                                                        {name: 'imputado'},
                                                        {name: 'carpetaAdministrativa'},
		                                                {name: 'objDetalle'},
                                                        {name: 'centroDetencion'},
                                                        {name: 'detallesAdicionales'},
                                                        {name: 'permiteSustitutivos'},
                                                        {name: 'datosSustitutivos'},
                                                        {name: 'delitos'},
                                                        {name: 'tipoPena'},
                                                        {name: 'detallePena'},
                                                        {name: 'arrComputoPrisionPreventiva'},
                                                        {name: 'fechaInicio', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'fechaFin', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'fechaPrescripcion', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'abonoPrisionPunitiva'},
                                                        {name: 'situacionPena'},
                                                        {name: 'concedeSuspension'},
                                                        {name: 'montoGarantia'},
                                                        {name: 'permiteSuspensionCondicional'},
                                                        {name: 'acogeSuspension'},
                                                        {name: 'nHistorial'},
                                                        {name: 'tipoIngreso'},
                                                        {name: 'sentencia'},
                                                        {name: 'abonoPrisionPreventiva'},
                                                        {name: 'abonoPrisionPunitiva'},
                                                        {name: 'arrSustitutivos'}
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
												sortInfo: {field: 'carpetaAdministrativa', direction: 'ASC'},
												groupField: 'carpetaAdministrativa',
												remoteGroup:false,
												remoteSort: false,
												autoLoad:false

											}) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	
                                        gEx('btnModificar').disable();
										gEx('btnSeAcoge').disable();
										gEx('btnNoSeAcoge').disable();
                                       	gEx('btnAcogeSustitutivo').disable();
       									gEx('btnCancelarAcogeSustitutivo').disable();
                                       
                                       	proxy.baseParams.funcion='173';
										proxy.baseParams.uG='<?php echo $_SESSION["codigoInstitucion"] ?>';
										proxy.baseParams.s=gEx('cmbSituacionPenas').getValue();
										
										if(gEx('dteInicio1').getValue()!='')
											proxy.baseParams.i1=gEx('dteInicio1').getValue().format('Y-m-d');
										else
											proxy.baseParams.i1='';

										if(gEx('dteInicio2').getValue()!='')
											proxy.baseParams.i2=gEx('dteInicio2').getValue().format('Y-m-d');
										else
											proxy.baseParams.i2='';

										if(gEx('dteTermine1').getValue()!='')
											proxy.baseParams.t1=gEx('dteTermine1').getValue().format('Y-m-d');
										else
											proxy.baseParams.t1='';	
											
										if(gEx('dteTermine2').getValue()!='')
											proxy.baseParams.t2=gEx('dteTermine2').getValue().format('Y-m-d');
										else
											proxy.baseParams.t2='';
										
                                    
                                    }
                        )   
    
    var paginador=	new Ext.PagingToolbar	(
                                                    {
                                                          pageSize: 300,
                                                          store: alDatos,
                                                          displayInfo: true,
                                                          disabled:false
       												}
                                           )      
       
	var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[ 
                                                        				{type: 'string', dataIndex: 'carpetaAdministrativa'},
                                                                        {type: 'list', dataIndex: 'concedeSuspension', phpMode:true, options:arrSiNo},
                                                                        {type: 'list', dataIndex: 'acogeSuspension', phpMode:true, options:arrSiNo},
                                                                        {type: 'date', dataIndex: 'fechaPrescripcion'},
                                                                        {type: 'date', dataIndex: 'fechaInicio'},
                                                                        {type: 'date', dataIndex: 'fechaFin'}
                                                                    ]
                                                    }
                                                );          
       
       var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
       var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:35}),
                                                            chkRow,
                                                            {
                                                                header:'Carpeta de Ejecuci&oacute;n',
                                                                width:160,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                            },
                                                            {
                                                                header:'Permite suspensi&oacute;n condicional de la ejecuci&oacute;n de la pena',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'concedeSuspension',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                			var comp='';
                                                                			if(val=='1')
																				comp=', <b>Monto:</b> '+Ext.util.Format.usMoney(registro.data.montoGarantia);
                                                                			return formatearValorRenderer(arrSiNo,val)+comp;
                                                                		}
                                                            },
                                                            {
                                                                header:'Se acoge a la supenci&oacute;n condicional de la ejecuci&oacute;n de la pena',
                                                                width:160,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'acogeSuspension',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                			
                                                                			return formatearValorRenderer(arrSiNo,val);
                                                                		}
                                                            },
                                                            {
                                                                header:'Sentenciado',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'imputado'
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n actual',
                                                                width:270,
                                                                sortable:true,
                                                                dataIndex:'situacionPena',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                       		var comp='';
                                                                        	var pos=existeValorMatriz(arrSituacion,val);
                                                                           	if(registro.data.nHistorial!='0')
                                                                           	{
																				comp='&nbsp;&nbsp;&nbsp;<a href="javascript:verHistorialPena(\''+bE(registro.data.idPena)+'\')"><img src="../images/magnifier.png" title="Ver historial" alt="Ver historial"></a>';
                                                                           	}
                                                                            return '<img src="'+arrSituacion[pos][2]+'" width="16" height="16"> '+arrSituacion[pos][1]+comp;
                                                                        }
                                                            },                                                            
                                                            {
                                                                header:'Tipo',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'tipoPena'
                                                            },
                                                            {
                                                                header:'Pena',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'detallePena'
                                                            },
                                                            {
                                                                header:'Fecha de<br>inicio',
                                                                width:80,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'fechaInicio',
                                                                renderer:function(val, meta,registro)
                                                                		{
                                                                        	var lblLeyenda='';
                                                                        	if(val)
                                                                            	lblLeyenda=val.format('d/m/Y');
                                                                            
                                                                            
                                                                            	
                                                                            return lblLeyenda;
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de t&eacute;rmino',
                                                                width:80,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'fechaFin',
                                                                renderer:function(val, meta,registro)
                                                                		{
                                                                        	var lblLeyenda='';
                                                                        	if(val)
                                                                            	lblLeyenda=val.format('d/m/Y');
                                                                            
                                                                            
                                                                            return lblLeyenda;
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de prescripci&oacute;n',
                                                                width:80,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'fechaPrescripcion',
                                                                renderer:function(val, meta,registro)
                                                                		{
                                                                        	var lblLeyenda='';
                                                                        	if(val)
                                                                            	lblLeyenda=val.format('d/m/Y');
                                                                            
                                                                            
                                                                            return lblLeyenda;
                                                                        }
                                                            },
                                                            {
                                                                header:'Considerado en suspensi&oacute;n condicional',
                                                                width:140,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'permiteSuspensionCondicional',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                       		if(registro.data.concedeSuspension=='0')
                                                                       			return 'N/A';
                                                                        	return formatearValorRenderer(arrSiNo,val);
                                                                        }
                                                            },                                                            
                                                            
                                                            {
                                                                header:'Sustitutivos concedidos',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'arrSustitutivos',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                      		if(val.length==0)
                                                                      			return '(Ninguno)';
                                                                      		var resultado='';
                                                                      		for(x=0;x<val.length;x++)
                                                                      		{
																				r=val[x];
																				var lblDetalle='';
																				if(r.montoSustitutivo!='')
																					lblDetalle='<b>Monto:</b> '+Ext.util.Format.usMoney(r.montoSustitutivo);

																				if(r.periodoSustitutivo!='') 
																				{
																					var arrPeriodo=r.periodoSustitutivo.split('|');
																					lblDetalle='<b>Periodo:</b> '+convertirLeyendaComputo(arrPeriodo);
																				}
																				
																				lDetalle=formatearValorRenderer(arrSustitutivo,r.idSustitutivo)+(r.acogeSustitutivo=='1'?' <span style="color:#900;fonct-size:9px"><b>-- Acogido --</b></span>':'');
																				if(lblDetalle!='')
																					lDetalle+='<br><span style="font-size:11px; color:#444;">'+lblDetalle+'</span>';
																				if(r.detallesAdicionales.trim()!='')
																			    	lDetalle+='<br><span style="font-size:11px; color:#444;">'+r.detallesAdicionales.trim()+'</span>'  ; 
																				      
																				            
																				if(resultado=='')
																					resultado=lDetalle;
																				else
																					resultado+='<br><br>'+lDetalle;
																				
																						
																						

																			}
                                                                      							
                                                                       		return resultado;
                                                                        }
                                                            },
                                                            {
                                                                header:'Detalles adicionales',
                                                                width:500,
                                                                sortable:true,
                                                                renderer:mostrarValorDescripcion,
                                                                dataIndex:'detallesAdicionales'
                                                            }
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gGridPenas',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                sm:chkRow,
                                                                plugins:[filters],
                                                                bbar:	[paginador],
                                                                columnLines : true, 
                                                                tbar:	[
                                                                			{
																				icon:'../images/clock_edit.png',
																				id:'btnAlerta',
																				cls:'x-btn-text-icon',
																				text:'Administrar alertas/notificaciones',
																				handler:function()
																						{
																						   var fila=gEx('gGridPenas').getSelectionModel().getSelected();
																						   if(!fila)
																						   {
																								msgBox('Debe seleccionar la pena cuyas alertas/notificaciones desea adminsitrar');
																								return; 
																						   }
																						   mostrarVentanaAdministracionAlertas(fila);



																						}

																			},'-',
                                                                            {
                                                                                icon:'../images/cog.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Acciones..',
                                                                                menu: 	[
                                                                               				{
																								icon:'',
																								id:'btnModificar',
																								cls:'x-btn-text-icon',
																								text:'Modificar situaci&oacute;n de la pena',
																								handler:function()
																										{
																										   var fila=gEx('gGridPenas').getSelectionModel().getSelected();
																										   if(!fila)
																										   {
																												msgBox('Debe seleccionar la pena cuya situaci&oacute;n desea modificar');
																												return; 
																										   }


																										   mostrarVentanaModificarSituacion(fila);

																										}

																							},
																							'-',
																							{
																								icon:'',
																								id:'btnSeAcoge',
																								cls:'x-btn-text-icon',
																								text:'Marcar como "Se acoge a la suspenci&oacute;n condicional de la pena"',
																								handler:function()
																										{
																										   var fila=gEx('gGridPenas').getSelectionModel().getSelected();
																										   if(!fila)
																										   {
																												msgBox('Debe seleccionar la pena que desea marcar como "Se acoge a la suspenci&oacute;n condicional de la pena"');
																												return; 
																										   }

																										   mostrarVentanaModificarSuspensionCondicional(fila,1);
																										   

																										}

																							},'-',
																							{
																								icon:'',
																								id:'btnNoSeAcoge',
																								cls:'x-btn-text-icon',
																								text:'Marcar como "NO se acoge a la suspenci&oacute;n condicional de la pena"',
																								handler:function()
																										{
																										   var fila=gEx('gGridPenas').getSelectionModel().getSelected();
																										   if(!fila)
																										   {
																												msgBox('Debe seleccionar la pena que desea marcar como "NO se acoge a la suspenci&oacute;n condicional de la pena"');
																												return; 
																										   }
																										   mostrarVentanaModificarSuspensionCondicional(fila,0);

																										   

																										}

																							},'-',
																							{
																								icon:'',
																								id:'btnAcogeSustitutivo',
																								cls:'x-btn-text-icon',
																								text:'Acoger a sustitutivo',
																								handler:function()
																										{
																										   var fila=gEx('gGridPenas').getSelectionModel().getSelected();
																										   if(!fila)
																										   {
																												msgBox('Debe seleccionar la pena que desea marcar como "NO se acoge a la suspenci&oacute;n condicional de la pena"');
																												return; 
																										   }
																										   mostrarVentanaAcogerSustitutivo(fila);

																										   

																										}

																							},'-',
																							{
																								icon:'',
																								id:'btnCancelarAcogeSustitutivo',
																								cls:'x-btn-text-icon',
																								text:'Cancelar acogimiento a sustitutivo',
																								handler:function()
																										{
																										   var fila=gEx('gGridPenas').getSelectionModel().getSelected();
																										   if(!fila)
																										   {
																												msgBox('Debe seleccionar la pena cuya situaci&oacute;n desea modificar');
																												return; 
																										   }


																										   mostrarVentanaCancelarAcogimientoSustitutivo(fila);

																										   

																										}

																							}
                                                                                		]
                                                                                
                                                                            }
                                                                			
                                                                        ],                                                               
                                                                view:new Ext.ux.grid.BufferView({
                                                                                                    // custom row height
                                                                                                    rowHeight: 90,
                                                                                                    // render rows as they come into viewable area.
                                                                                                    scrollDelay: false
                                                                                                })
                                                            }
                                                        );
        
		tblGrid.getSelectionModel().on 	('rowselect',function(sm,nFila,registro)
       												{
       													gEx('btnModificar').enable();
       													gEx('btnSeAcoge').disable();
       													gEx('btnNoSeAcoge').disable();
       													gEx('btnAcogeSustitutivo').disable();
       													gEx('btnCancelarAcogeSustitutivo').disable();
       													
       													
       													if(registro.data.concedeSuspension=='1')
       													{
       														if(registro.data.acogeSuspension=='1')
       															gEx('btnNoSeAcoge').enable();
       														else
       															gEx('btnSeAcoge').enable();
       													}
       													
       													if(registro.data.situacionPena=='6')
       													{
       														gEx('btnModificar').disable();
       														gEx('btnNoSeAcoge').disable();
       														gEx('btnSeAcoge').disable();
       														gEx('btnCancelarAcogeSustitutivo').enable();
       													}
       													else
       													{
       														if(registro.data.arrSustitutivos.length>0)
       															gEx('btnAcogeSustitutivo').enable();
       													}
       												}
        								)
        
        
        tblGrid.getSelectionModel().on 	('rowdeselect',function(sm,nFila,registro)
       												{
       													gEx('btnModificar').disable();
       													gEx('btnSeAcoge').disable();
       													gEx('btnNoSeAcoge').disable();
       													gEx('btnAcogeSustitutivo').disable();
       													gEx('btnCancelarAcogeSustitutivo').disable();
       												}
        								)
        return 	tblGrid;
}

function mostrarVentanaModificarSituacion(fila)
{
	filaPena=fila;
	var cmbMedioExtinsion=crearComboExt('cmbMedioExtinsion',arrMedio,195,5,180);
    cmbMedioExtinsion.setValue('1');
    cmbMedioExtinsion.on('select',function(cmb,registro)
    								{
                                    	switch(registro.data.id)
                                        {
                                        	case '1':
                                            	gE('sp_LabelExtinto').innerHTML='Fecha de la audiencia';
                                                gEx('cmbAudienciaExtinsion').show();
                                                gEx('dtefechaExtinsion').hide();
                                                
                                            break;
                                            case '2':
                                            	gE('sp_LabelExtinto').innerHTML='Fecha en que se declara extinta';
                                                gEx('cmbAudienciaExtinsion').hide();
                                                gEx('dtefechaExtinsion').show();
                                                
                                            break;
                                        }
                                    }
    					)
                        
	var cmbMedioPrescripcion=crearComboExt('cmbMedioPrescripcion',arrMedio,195,5,180);
    cmbMedioPrescripcion.setValue('1');
    cmbMedioPrescripcion.on('select',function(cmb,registro)
    								{
                                    	switch(registro.data.id)
                                        {
                                        	case '1':
                                            	gE('sp_LabelPrescrito').innerHTML='Fecha de la audiencia';
                                                gEx('cmbAudienciaPrescripcion').show();
                                                gEx('dtefechaPrescripcion').hide();
                                                
                                            break;
                                            case '2':
                                            	gE('sp_LabelPrescrito').innerHTML='Fecha en que se declara prescrita';
                                                gEx('cmbAudienciaPrescripcion').hide();
                                                gEx('dtefechaPrescripcion').show();
                                                
                                            break;
                                        }
                                    }
    					)                       
    
	var cmbJuezExtinta=crearComboExt('cmbJuezExtinta',arrJuecesUnidad,195,65,350);    
    var cmbJuezPrescrita=crearComboExt('cmbJuezPrescrita',arrJuecesUnidad,195,65,350);
    
	var cmbSituacionPena=crearComboExt('cmbSituacionPena',arrSituacionCambio,150,5,200);
    cmbSituacionPena.setValue('1');
    cmbSituacionPena.on('select',function(cmb,registro)
    								{
                                    	gEx('f_1').hide();
                                       	gEx('f_1_1').hide();
                                        gEx('f_2').hide();
                                        gEx('f_3').hide();
                                        if(registro.data.id=='1')
                                        {
                                        	if(filaPena.data.tipoIngreso=='5')
                                        		gEx('f_1_1').show();
                                        	else
                                        		gEx('f_'+registro.data.id).show();
                                        }
                                        else
                                        	gEx('f_'+registro.data.id).show();
                                        
                                    }
                        )
    
    var cmbAudienciaExtinsion=crearComboExt('cmbAudienciaExtinsion',[],195,35,180);
    cmbAudienciaExtinsion.on('select',function(cmb,registro)
    								{
                                    	
                                    	var pos=obtenerPosFila(cmbJuezExtinta.getStore(),'id',registro.data.valorComp);
                                      
                                        if(pos!=-1)
                                        {
                                        	cmbJuezExtinta.setValue(registro.data.valorComp);
                                        }
                                    }
    						)
	
    var cmbAudienciaPrescripcion=crearComboExt('cmbAudienciaPrescripcion',[],195,35,180);
    cmbAudienciaPrescripcion.on('select',function(cmb,registro)
    								{
                                    	
                                    	var pos=obtenerPosFila(cmbJuezPrescrita.getStore(),'id',registro.data.valorComp);
                                      
                                        if(pos!=-1)
                                        {
                                        	cmbJuezPrescrita.setValue(registro.data.valorComp);
                                        }
                                    }
    						)
    
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Situaci&oacute;n de la pena:'
                                                        },
                                                        cmbSituacionPena,
                                                        {
															  x:0,
															  y:20,
															  width:670,
															  height:183,
															  id:'f_1_1',    
															  hidden:true,                                                      
															  border:false,
															  layout:'absolute',
															  defaultType: 'label',
															  xtype:'fieldset',
															  items:	[
																		  {
																			  x:0,
																			  y:10,
																			  html:'Fecha de inicio de pena:'
																		  },  
																		  
																		  {
																				x:160,
																				y:5,
																				xtype:'datefield',
																				value:filaPena.data.fechaInicio,
																				id:'dteFechaInicioPena',
																				listeners:	{
																							  	select:calcularPenaCumplir
																							}

																		  },
																		  {
																			  x:0,
																			  y:40,
																			  html:'Sentencia:'
																		  },
																		  {
																			  x:160,
																			  y:40,
																			  html:'<span id="spSentencia">'+convertirLeyendaComputo(fila.data.sentencia.split('_'))+'</span>'
																		  },
																		  {
																			  x:0,
																			  y:70,
																			  html:'Abono prisi&oacute;n preventiva:'
																		  },  
																		  {
																			  x:160,
																			  y:70,
																			  html:'<span id="spAbonoPrision">'+convertirLeyendaComputo(fila.data.abonoPrisionPreventiva.split('_'))+'</span>'
																		  },
																		  {
																			  x:0,
																			  y:100,
																			  html:'Abono prisi&oacute;n punitiva:'
																		  },
																		  
																		  {
																			  xtype:'fieldset',
																			  width:650,                                                                                              
																			  id:'fsPrisionPunitiva',
																			  height:80,
																			  x:150,
																			  y:87,
																			  border:false,
																			  layout:'absolute',
																			  items:	[

																						  {
																							  x:10,
																							  y:0,
																							  xtype:'numberfield',
																							  allowDecimals:false,
																							  alowNegative:false,
																							  width:40,
																							  value:0,                                                                                                             
																							  listeners:	{
																											  change:calcularPenaCumplir
																										  },
																							  id:'txtAniosPunitiva'
																						  },
																						  {
																							  xtype:'label',
																							  html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">A&ntilde;os</span>',
																							  x:15,
																							  y:25
																						  },
																						  {
																							  x:60,
																							  y:0,
																							  xtype:'numberfield',
																							  width:40,

																							  listeners:	{
																											  change:calcularPenaCumplir
																										  },
																							  allowDecimals:false,
																							  alowNegative:false,
																							  value:0,

																							  id:'txtMesesPunitiva'
																						  },
																						  {
																							  xtype:'label',
																							  html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">Meses</span>',
																							  x:65,
																							  y:25
																						  },
																						  {
																							  x:110,
																							  y:0,
																							  xtype:'numberfield',
																							  width:40,
																							  value:0,

																							  listeners:	{
																											  change:calcularPenaCumplir
																										  },
																							  allowDecimals:false,
																							  alowNegative:false,
																							  id:'txtDiasPunitiva'
																						  },
																						  {
																							  xtype:'label',
																							  html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">D&iacute;as</span>',
																							  x:115,
																							  y:25
																						  }

																						]
																		  }, 
																		  {
																			  x:0,
																			  y:145,
																			  html:'Por cumplir:'
																		  },
																		  {
																			  x:160,
																			  y:145,
																			  html:'<span id="spPorCumplir"></span>'
																		  },
																		  {
																			  x:360,
																			  y:145,
																			  html:'Fecha de t&eacute;rmino de pena:'
																		  },
																		  {
																				x:520,
																				y:140,
																				xtype:'datefield',
																				value:filaPena.data.fechaFin,
																				id:'dteFechaTerminoPena'

																		  }
																	  ]
														  },
                                                        {
                                                          x:0,
                                                          y:20,
                                                          width:670,
                                                          height:180,
                                                          id:'f_1',    
                                                          hidden:true,                                                      
                                                          border:false,
                                                          layout:'absolute',
                                                          defaultType: 'label',
                                                          xtype:'fieldset',
                                                          items:	[
                                                                      {
                                                                          x:0,
                                                                          y:10,
                                                                          html:'Condiciones de cumplimiento:'
                                                                      },  
                                                                      {
                                                                      	x:10,
                                                                        y:40,
                                                                        height:80,
                                                                        xtype:'textarea',
                                                                        width:630,
                                                                        id:'txtCondiciones'
                                                                      },                                                                   
                                                                      {
                                                                          x:0,
                                                                          y:140,
                                                                          html:'Fecha en que deber&aacute; cumplirse:'
                                                                      },
                                                                      {
                                                                      		x:190,
                                                                            y:135,
                                                                            xtype:'datefield',
                                                                            id:'dteFechaCumplimiento'
                                                                            
                                                                      },
                                                                      {
                                                                          x:330,
                                                                          y:140,
                                                                          html:'Fecha en que prescribe:'
                                                                      },
                                                                      {
                                                                      		x:480,
                                                                            y:135,
                                                                            xtype:'datefield',
                                                                            id:'dteFechaPrescripcion'
                                                                            
                                                                      }
                                                                  ]
                                                      },
                                                        {
                                                        	x:0,
                                                            y:20,
                                                            width:650,
                                                            height:120,
                                                            id:'f_2',
                                                            hidden:true,
                                                            border:false,
                                                            layout:'absolute',
                                                            defaultType: 'label',
                                                            xtype:'fieldset',
                                                            items:	[
                                                            			{
                                                                        	x:0,
                                                                            y:10,
                                                                            html:'Medio en que se declara extinta:'
                                                                        },
                                                                        cmbMedioExtinsion,
                                                                        {
                                                                        	x:0,
                                                                            y:40,
                                                                            html:'<span id="sp_LabelExtinto">Fecha de la audiencia</span>:'
                                                                        },
                                                                        {
                                                                        	x:195,
                                                                            y:35,
                                                                            hidden:true,
                                                                            xtype:'datefield',
                                                                            id:'dtefechaExtinsion'
                                                                        },
                                                                        cmbAudienciaExtinsion,
                                                                        {
                                                                        	x:0,
                                                                            y:70,
                                                                            html:'<span >Juez que la declara extinta:</span>'
                                                                        },
                                                                        cmbJuezExtinta
                                                            		]
                                                        },
                                                       {
                                                          x:0,
                                                          y:20,
                                                          width:650,
                                                          height:120,
                                                          id:'f_3', 
                                                          hidden:true,                                                         
                                                          border:false,
                                                          layout:'absolute',
                                                          defaultType: 'label',
                                                          xtype:'fieldset',
                                                          items:	[
                                                                      {
                                                                          x:0,
                                                                          y:10,
                                                                          html:'Medio en que se declara precrita:'
                                                                      },
                                                                      cmbMedioPrescripcion,
                                                                      {
                                                                          x:0,
                                                                          y:40,
                                                                          html:'<span id="sp_LabelPrescrito">Fecha de la declaraci&oacute;n</span>:'
                                                                      },
                                                                      {
                                                                          x:195,
                                                                          y:35,
                                                                          hidden:true,
                                                                          xtype:'datefield',
                                                                          id:'dtefechaPrescripcion'
                                                                      },
                                                                      cmbAudienciaPrescripcion,
                                                                      {
                                                                          x:0,
                                                                          y:70,
                                                                          html:'<span >Juez que la declara prescrita:</span>'
                                                                      },
                                                                      cmbJuezPrescrita
                                                                  ]
                                                      },
                                                      {
                                                      	x:10,
                                                        y:200,
                                                        html:'Comentarios adicionales:'
                                                      },
                                                      {
                                                      	x:20,
                                                        y:230,
                                                        xtype:'textarea',
                                                        width:630,
                                                        height:80,
                                                        id:'txtComentariosAdicionales'
                                                      }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar situaci&oacute;n de la pena',
										width: 700,
										height:410,
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
                                                                  		var dteFechaCumplimiento=gEx('dteFechaCumplimiento');
                                                                   		if(cmbSituacionPena.getValue()=='')
                                                                   		{
                                                                   			function resp1()
                                                                   			{
                                                                   				cmbSituacionPena.focus();
                                                                   			}
                                                                   			msgBox('Debe indicar la situaci&oacute;n de la pena',resp1);
                                                                   			return;
                                                                   		}
                                                                    	var cadObj='';
																		switch(cmbSituacionPena.getValue())
                                                                        {
                                                                        	case '1':
                                                                           		if(filaPena.data.tipoIngreso=='5')
                                                                           		{
                                                                           			if(gEx('dteFechaInicioPena').getValue()=='')
                                                                           			{
                                                                           				function resp111()
																						{
																							gEx('dteFechaInicioPena').focus();
																						}
																						msgBox('Debe indicar la fecha de inicio de la pena',resp111);
																						return;
                                                                           			}
                                                                           			
                                                                           			
                                                                           			if(gEx('dteFechaTerminoPena').getValue()=='')
                                                                           			{
                                                                           				function resp112()
																						{
																							gEx('dteFechaTerminoPena').focus();
																						}
																						msgBox('Debe indicar la fecha de t&eacute;rmino de la pena',resp112);
																						return;
                                                                           			}
                                                                           		
                                                                           			var abonoPrisionPunitiva='';
                                                                           			abonoPrisionPunitiva=gEx('txtAniosPunitiva').getValue()==''?'0':gEx('txtAniosPunitiva').getValue();
																					abonoPrisionPunitiva+='_'+(gEx('txtMesesPunitiva').getValue()==''?'0':gEx('txtMesesPunitiva').getValue());
																					abonoPrisionPunitiva+='_'+(gEx('txtDiasPunitiva').getValue()==''?'0':gEx('txtDiasPunitiva').getValue());
                                                                          			
                                                                           			cadObj='{"idPena":"'+fila.data.idPena+'","situacionPena":"'+cmbSituacionPena.getValue()+
                                                                           					'","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+'",'+
                                                                           					'"fechaInicio":"'+gEx('dteFechaInicioPena').getValue().format('Y-m-d')+
                                                                           					'","abonoPrisionPunitiva":"'+abonoPrisionPunitiva+'","fechaCumplimiento":"'+
                                                                           					gEx('dteFechaTerminoPena').getValue().format('Y-m-d')+
                                                                           					'","sentencia":"'+filaPena.data.sentencia+'","abonoPrisionPreventiva":"'+
                                                                           					filaPena.data.abonoPrisionPreventiva+'"}';
                                                                           		}
                                                                           		else
                                                                           		{
																					if(gEx('txtCondiciones').getValue()=='')
																					{
																						function resp2()
																						{
																							gEx('txtCondiciones').focus();
																						}
																						msgBox('Debe indicar las condiciones de cumplimiento de la pena',resp2);
																						return;
																					}

																					if(dteFechaCumplimiento.getValue()=='')
																					{
																						function resp3()
																						{
																							dteFechaCumplimiento.focus();
																						}
																						msgBox('Debe indicar la fecha en que deber&aacute;n cumplirse las condiciones',resp3);
																						return;
																					}

																					cadObj='{"idPena":"'+fila.data.idPena+'","situacionPena":"'+cmbSituacionPena.getValue()+'","condicionesCumplimiento":"'+
																						cv(gEx('txtCondiciones').getValue())+'","fechaCumplimiento":"'+(dteFechaCumplimiento.getValue()==''?'':dteFechaCumplimiento.getValue().format('Y-m-d'))+
																						'","fechaPrescripcion":"'+(gEx('dtefechaPrescripcion').getValue()!=''?gEx('dtefechaPrescripcion').getValue().format('Y-m-d'):'')+
																						'","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+'"}';
                                                                            	}
                                                                            break;
                                                                            case '2':
                                                                            	if(cmbMedioExtinsion.getValue()=='')
																				{
																					function resp4()
																					{
																						cmbMedioExtinsion.focus();
																					}
																					msgBox('Debe indicar el medio en que se declara extinta la pena',resp4);
																					return;
																				}
                                                                          		
                                                                          		if(cmbMedioExtinsion.getValue()=='1')
                                                                          		{
																					if(cmbAudienciaExtinsion.getValue()=='')
																					{
																						function resp5()
																						{
																							cmbAudienciaExtinsion.focus();
																						}
																						msgBox('Debe indicar la audiencia en la cual se declara extinta la pena',resp5);
																						return;
																					}
                                                                          	 	}
                                                                          	 	else
                                                                          	 	{
                                                                          	 		if(gEx('dtefechaExtinsion').getValue()=='')
																					{
																						function resp6()
																						{
																							gEx('dtefechaExtinsion').focus();
																						}
																						msgBox('Debe indicar la fecha en la cual se declara extinta la pena',resp6);
																						return;
																					}
                                                                          	 	}
                                                                          	 	
                                                                          	 	if(cmbJuezExtinta.getValue()=='')
																				{
																					function resp7()
																					{
																						cmbJuezExtinta.focus();
																					}
																					msgBox('Debe indicar el juez que declara extinta la pena',resp7);
																					return;
																				}
                                                                           	
                                                                            	cadObj='{"idPena":"'+fila.data.idPena+'","situacionPena":"'+cmbSituacionPena.getValue()+'","medioDeclaracion":"'+cmbMedioExtinsion.getValue()+
                                                                            	'","audienciaDeclaracion":"'+(cmbMedioExtinsion.getValue()=='1'?cmbAudienciaExtinsion.getValue():'')+
                                                                            	'","fechaDeclaracion":"'+(cmbMedioExtinsion.getValue()=='2'?gEx('dtefechaExtinsion').getValue().format('Y-m-d'):'')+
                                                                            	'","juezDeclaracion":"'+cmbJuezExtinta.getValue()+'","comentariosAdicionales":"'+
                                                                            	cv(gEx('txtComentariosAdicionales').getValue())+'"}';
                                                                            break;
                                                                            case '3':
                                                                            	if(cmbMedioPrescripcion.getValue()=='')
																				{
																					function resp14()
																					{
																						cmbMedioPrescripcion.focus();
																					}
																					msgBox('Debe indicar el medio en que se declara prescrita la pena',resp14);
																					return;
																				}
                                                                          		
                                                                          		if(cmbMedioPrescripcion.getValue()=='1')
                                                                          		{
																					if(cmbAudienciaPrescripcion.getValue()=='')
																					{
																						function resp15()
																						{
																							cmbAudienciaPrescripcion.focus();
																						}
																						msgBox('Debe indicar la audiencia en la cual se declara prescrita la pena',resp15);
																						return;
																					}
                                                                          	 	}
                                                                          	 	else
                                                                          	 	{
                                                                          	 		if(gEx('dtefechaPrescripcion').getValue()=='')
																					{
																						function resp16()
																						{
																							gEx('dtefechaPrescripcion').focus();
																						}
																						msgBox('Debe indicar la fecha en la cual se declara prescrita la pena',resp16);
																						return;
																					}
                                                                          	 	}
                                                                          	 	
                                                                          	 	if(cmbJuezPrescrita.getValue()=='')
																				{
																					function resp17()
																					{
																						cmbJuezPrescrita.focus();
																					}
																					msgBox('Debe indicar el juez que declara prescrita la pena',resp17);
																					return;
																				}
                                                                            	cadObj='{"idPena":"'+fila.data.idPena+'","situacionPena":"'+cmbSituacionPena.getValue()+'","medioDeclaracion":"'+cmbMedioPrescripcion.getValue()+
                                                                            	'","audienciaDeclaracion":"'+(cmbMedioPrescripcion.getValue()=='1'?cmbAudienciaPrescripcion.getValue():'')+
                                                                            	'","fechaDeclaracion":"'+(cmbMedioPrescripcion.getValue()=='2'?gEx('dtefechaPrescripcion').getValue().format('Y-m-d'):'')+
                                                                            	'","juezDeclaracion":"'+cmbJuezPrescrita.getValue()+'","comentariosAdicionales":"'+
                                                                            	cv(gEx('txtComentariosAdicionales').getValue())+'"}';
                                                                            break;
                                                                        }
                                                                        
                                                                        
                                                                        function funcAjax()
																		{
																			var resp=peticion_http.responseText;
																			arrResp=resp.split('|');
																			if(arrResp[0]=='1')
																			{
																				gEx('gGridPenas').getStore().reload();
																				ventanaAM.close();
																			}
																			else
																			{
																				msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																			}
																		}
																		obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=183&cadObj='+cadObj,true);

                                                                        
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
	
    
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            ventanaAM.show();
            calcularPenaCumplir();
            var arrDatos=eval(arrResp[1]);
            var arrJueces=eval(arrResp[2]);
            
            var arrDatosFinal=[];
            var x;
            for(x=0;x<arrDatos.length;x++)
            {
            	arrDatosFinal.push([arrDatos[x][0],Date.parseDate(arrDatos[x][1],'Y-m-d H:i:s').format('d/m/Y H:i'),arrDatos[x][3]]);
            }
            cmbAudienciaExtinsion.getStore().loadData(arrDatosFinal);
            cmbAudienciaPrescripcion.getStore().loadData(arrDatosFinal);
            
            cmbJuezExtinta.getStore().loadData(arrJueces);
            cmbJuezPrescrita.getStore().loadData(arrJueces);
            
            dispararEventoSelectCombo('cmbSituacionPena');
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=174&cA='+fila.data.carpetaAdministrativa,true);
	
}

function recargarGridPenas(inicio,fin)
{
	gEx('gGridPenas').getStore().reload();
	return;
	var oParams={};
    
    oParams.funcion='173';
    oParams.uG='<?php echo $_SESSION["codigoInstitucion"] ?>';
   	oParams.s=gEx('cmbSituacionPenas').getValue();
    if(gEx('dteInicio1').getValue()!='')
    {
        oParams.i1=gEx('dteInicio1').getValue().format('Y-m-d');
    }
    
    if(gEx('dteInicio2').getValue()!='')
    {
        oParams.i2=gEx('dteInicio2').getValue().format('Y-m-d');
    }
    
    if(gEx('dteTermine1').getValue()!='')
    {
        oParams.t1=gEx('dteTermine1').getValue().format('Y-m-d');
    }
    
    if(gEx('dteTermine2').getValue()!='')
    {
        oParams.t2=gEx('dteTermine2').getValue().format('Y-m-d');
    }
    
    
    
     if(gEx('txtCarpetaEjecucion').getValue()!='')
    {
        oParams.cA=gEx('txtCarpetaEjecucion').getValue();
    }
    
    if(inicio)
    {
    	oParams.start=inicio;
    	oParams.limit=fin;
    }
    
	gEx('gGridPenas').getStore().load	(
    										{
                                            	url:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                params:	oParams
                                            }
    									);
}


function verHistorialPena(iP)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
                                            frame:false,
											defaultType: 'label',
											items: 	[
														crearGridHistorial(iP)

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Historial',
										width: 900,
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

function crearGridHistorial(iP)
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name:'fechaOperacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'etapaOriginal'},
		                                                {name:'etapaCambio'},
		                                                {name:'responsable'},
                                                        {name: 'comentarios'},
                                                        {name: 'detalles'}
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
                                                            sortInfo: {field: 'fechaOperacion', direction: 'DESC'},
                                                            groupField: 'fechaOperacion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='184';
                                        proxy.baseParams.idPena=bD(iP);
                                       
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'Fecha',
                                                                width:150,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'fechaOperacion',
                                                                renderer:function(val)
                                                                		{
                                                                        
                                                                        	return formatoTitulo(val.format('d')+' de '+arrMeses[parseInt(val.format('m'))-1][1]+' de '+val.format('Y')+'<br>('+val.format('H:i:s')+' hrs.)');
                                                                        }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n original',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'etapaOriginal',
                                                                renderer:formatoTitulo2
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n cambio',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'etapaCambio',
                                                                renderer:formatoTitulo2
                                                            },                                                            
                                                            {
                                                                header:'Responsable',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'responsable',
                                                                renderer:formatoTitulo3
                                                            }
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                    {
                                                        id:'gridHistorial',
                                                        store:alDatos,
                                                        region:'center',
                                                        frame:false,
                                                        border:true,
                                                        cm: cModelo,
                                                        columnLines : false,
                                                        stripeRows :true,
                                                        loadMask:true,
                                                                                                                        
                                                        view:new Ext.grid.GroupingView({
                                                                                            forceFit:false,
                                                                                            showGroupName: false,
                                                                                            enableGrouping :false,
                                                                                            enableNoGroups:false,
                                                                                            enableGroupingMenu:false,
                                                                                            hideGroupedColumn: false,
                                                                                            startCollapsed:false,
                                                                                            enableRowBody:true,
                                                                                            getRowClass : formatearFilaHistorial
                                                                                        })
                                                    }
                                                );
        return 	tblGrid;	

}

function formatearFilaHistorial(record, rowIndex, p, ds)
{
	var xf = Ext.util.Format;
    p.body = '<p style="margin-left: 4em;margin-right: 4em;text-align:justify"><br><span class="menu"><span style="color: #3B3C3B">'+record.data.detalles+'</span><span style="color: #001C02"><b>Comentarios adicionales:</b></span><br><br><span style="color: #3B3C3B">' + ((record.data.comentarios.trim()=="")?"(Sin comentarios)":record.data.comentarios) + '</span></p><br><br><br>';
    return 'x-grid3-row-expanded';
}

function formatoTitulo(val)
{
	return '<span style="font-size:11px; color:#040033">'+val+'</span>';
}

function formatoTitulo2(val)
{
	return '<div style="font-size:11px; color:#040033;; height:45px; word-wrap: break-word;white-space: normal; ">'+formatearValorRenderer(arrSituacion,val)+'</div>';
}

function formatoTitulo3(val)
{
	return '<div style="font-size:11px; height:45px; color:#040033; word-wrap: break-word;white-space: normal;"><img src="../images/user_gray.png">'+(val)+'</div>';
}

function calcularPenaCumplir()
{
	var arrResultado=new Array();
	arrResultado[0]=0;
	arrResultado[1]=0;
	arrResultado[2]=0;
	
	var arrSentencia=filaPena.data.sentencia.split('_');
	var arrPrisionPreventiva=filaPena.data.abonoPrisionPreventiva.split('_');
	var arrPrisionPunitiva=new Array();
	arrPrisionPunitiva[0]=gEx('txtAniosPunitiva').getValue()==''?'0':gEx('txtAniosPunitiva').getValue();
	arrPrisionPunitiva[1]=gEx('txtMesesPunitiva').getValue()==''?'0':gEx('txtMesesPunitiva').getValue();
	arrPrisionPunitiva[2]=gEx('txtDiasPunitiva').getValue()==''?'0':gEx('txtDiasPunitiva').getValue();
	
	arrResultado=restarComputo(arrSentencia,arrPrisionPreventiva);
	arrResultado=restarComputo(arrResultado,arrPrisionPunitiva);
	gE('spPorCumplir').innerHTML=convertirLeyendaComputo(arrResultado);
	
	if(gEx('dteFechaInicioPena').getValue()!='')
	{
		var fecha=gEx('dteFechaInicioPena').getValue();
		fecha=fecha.add(Date.YEAR,arrResultado[0]);
		fecha=fecha.add(Date.MONTH,arrResultado[1]);
		fecha=fecha.add(Date.DAY,arrResultado[2]);
		gEx('dteFechaTerminoPena').setValue(fecha);
	}
	
	
}

function mostrarVentanaModificarSuspensionCondicional(fila,situacion)
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
                                            				x:10,
                                            				y:40,
                                            				width:550,
                                            				height:80,
                                            				xtype:'textarea',
                                            				id:'txtComentariosAdicionales'
                                            			}
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: situacion==1?'Marcar como "Se acoge a la suspenci&oacute;n condicional de la pena"':'Marcar como "NO se acoge a la suspenci&oacute;n condicional de la pena"',
										width: 600,
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
																				var cadObj='{"idPena":"'+fila.data.idPena+'","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+'","seAcoge":"'+situacion+'"}';
																				function funcAjax()
																				{
																					var resp=peticion_http.responseText;
																					arrResp=resp.split('|');
																					if(arrResp[0]=='1')
																					{
																						gEx('gGridPenas').getStore().reload();
																						ventanaAM.close();
																					}
																					else
																					{
																						msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																					}
																				}
																				obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=185&cadObj='+cadObj,true);
																			}
																		}
																		msgConfirm('Est&aacute; seguro de querer marcar la pena como: '+(situacion==1?'Marcar como "Se acoge a la suspenci&oacute;n condicional de la pena"':'Marcar como "NO se acoge a la suspenci&oacute;n condicional de la pena"'),resp);
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

function mostrarVentanaAcogerSustitutivo(fila)
{
	
	var arrSustitutivosPena=[];
	var x;
	for(x=0;x<fila.data.arrSustitutivos.length;x++)
	{
	
		var pos=existeValorMatriz(arrSustitutivo,fila.data.arrSustitutivos[x].idSustitutivo);
		arrSustitutivosPena.push(	[	arrSustitutivo[pos][0],
										arrSustitutivo[pos][1],
										arrSustitutivo[pos][2],
										fila.data.arrSustitutivos[x]
									]
								);
	}

	var cmbSustitutivo=crearComboExt('cmbSustitutivo',arrSustitutivosPena,185,5,450);
	
	cmbSustitutivo.on('select',function(cmb,registro)
    								{
                                   		
                                    	var arrComplementario=registro.data.valorComp.split('_');
                                        switch(arrComplementario[0])
                                        {
                                            case '2'://Monto
                                                gE('lblMontoSustitutivo').innerHTML='Monto:';
                                                gEx('txtMontoSustitutivo').show();
                                                gEx('fsPeriodoSustitutivo').hide();
                                                gEx('txtAniosSustitutivos').setValue(0);
                                                gEx('txtMesesSustitutivos').setValue(0);
                                                gEx('txtDiasSustitutivos').setValue(0);
                                                gE('lblFechaInicioSustitutivo').innerHTML='Fecha en que deber&aacute; cumplirse:';
                                                gEx('lFechaInicioSustitutivo').show();
                                                gEx('dteFechaInicio').show();
                                                gEx('lFechaTerminoSustitutivo').hide();
                                                gEx('dteFechaTermino').hide();
                                                
                                                gEx('txtMontoSustitutivo').setValue(registro.data.valorComp2.montoSustitutivo);
                                                gEx('dteFechaInicio').setValue(registro.data.valorComp2.fechaInicio);
                                                gEx('dteFechaTermino').setValue(registro.data.valorComp2.fechaTermino);
                                                
                                            break;
                                            case '5'://Periodo
                                                gE('lblMontoSustitutivo').innerHTML='Periodo:';
                                                gEx('fsPeriodoSustitutivo').show();
                                                gEx('txtMontoSustitutivo').hide();
                                                gE('lblFechaInicioSustitutivo').innerHTML='Fecha de inicio:';
                                                gEx('lFechaInicioSustitutivo').show();
                                                gEx('dteFechaInicio').show();
                                                gEx('lFechaTerminoSustitutivo').show();
                                                gEx('dteFechaTermino').show();
                                                
                                                var arrPeriodo=registro.data.valorComp2.periodoSustitutivo.split('|');
                                                gEx('txtAniosSustitutivos').setValue(arrPeriodo[0]);
                                                gEx('txtMesesSustitutivos').setValue(arrPeriodo[1]);
                                                gEx('txtDiasSustitutivos').setValue(arrPeriodo[2]);
                                                
                                                gEx('dteFechaInicio').setValue(registro.data.valorComp2.fechaInicio);
                                                gEx('dteFechaTermino').setValue(registro.data.valorComp2.fechaTermino);
                                            break;
                                            default:
                                                gE('lblMontoSustitutivo').innerHTML='';
                                                gEx('fsPeriodoSustitutivo').hide();
                                                gEx('txtMontoSustitutivo').hide();
                                                gEx('lFechaInicioSustitutivo').hide();
                                                gEx('dteFechaInicio').hide();
                                                gEx('lFechaTerminoSustitutivo').hide();
                                                gEx('dteFechaTermino').hide();
                                            break;
                                            
                                            
                                        }
                                    }
    					)
	
	
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                            				x:10,
                                            				y:10,
                                            				html:'Sustitutivo al cual se acoge:'
                                            			},
                                            			cmbSustitutivo,
                                            			{
                                                            x:10,
                                                            y:40,
                                                            xtype:'label',                                                            
                                                            id:'lblMontoSustitutivo',
                                                            html:'<span id="spMultaSustitutivo"></span>'
                                                        },
                                                        {
                                                            x:185,
                                                            y:35,
                                                            hidden:true,
                                                            allowDecimals:true,
                                                            allowNegative:false,
                                                            xtype:'numberfield',
                                                            width:120,
                                                            id:'txtMontoSustitutivo'
                                                        },
                                                        {
                                                            xtype:'fieldset',
                                                            width:200,
                                                            height:60,
                                                            x:165,
                                                            y:25,
                                                            hidden:true,
                                                            id:'fsPeriodoSustitutivo',
                                                            border:false,
                                                            layout:'absolute',
                                                            items:	[
                                                                        {
                                                                            x:10,
                                                                            y:0,
                                                                            xtype:'numberfield',
                                                                            allowDecimals:false,
                                                                            alowNegative:false,
                                                                            width:40,
                                                                            value:0,
                                                                            listeners:	{
                                                                           					change:calcularPeriodoSustitutivo
                                                                            			},
                                                                            id:'txtAniosSustitutivos'
                                                                        },
                                                                        {
                                                                            xtype:'label',
                                                                            html:'A&ntilde;os',
                                                                            x:15,
                                                                            y:25
                                                                        },
                                                                        {
                                                                            x:70,
                                                                            y:0,
                                                                            xtype:'numberfield',
                                                                            width:40,
                                                                            allowDecimals:false,
                                                                            alowNegative:false,
                                                                            value:0,
                                                                            listeners:	{
                                                                           					change:calcularPeriodoSustitutivo
                                                                            			},
                                                                            id:'txtMesesSustitutivos'
                                                                        },
                                                                        {
                                                                            xtype:'label',
                                                                            html:'Meses',
                                                                            x:75,
                                                                            y:25
                                                                        },
                                                                        {
                                                                            x:130,
                                                                            y:0,
                                                                            xtype:'numberfield',
                                                                            width:40,
                                                                            value:0,
                                                                            listeners:	{
                                                                           					change:calcularPeriodoSustitutivo
                                                                            			},
                                                                            allowDecimals:false,
                                                                            alowNegative:false,
                                                                            id:'txtDiasSustitutivos'
                                                                        },
                                                                        {
                                                                            xtype:'label',
                                                                            html:'D&iacute;as',
                                                                            x:135,
                                                                            y:25
                                                                        }
                                                                         
                                                                    ]
                                                        },
                                                        {
                                            				x:10,
                                            				y:90,
                                            				hidden:true,
                                            				id:'lFechaInicioSustitutivo',
															html:'<span id="lblFechaInicioSustitutivo">Fecha de inicio:</span>'
                                            			},
                                                        {
                                                        	x:185,
                                                        	y:85,
                                                        	xtype:'datefield',
                                                        	hidden:true,
                                                        	listeners:	{
																			select:calcularPeriodoSustitutivo
																		},
                                                        	id:'dteFechaInicio'
                                                        },
                                                        {
                                            				x:350,
                                            				y:90,
                                            				hidden:true,
                                            				id:'lFechaTerminoSustitutivo',
															html:'<span id="lblFechaTerminoSustitutivo">Fecha de t&eacute;rmino:</span>'
                                            			},
                                                        {
                                                        	x:470,
                                                        	y:85,
                                                        	hidden:true,
                                                        	xtype:'datefield',
                                                        	
                                                        	id:'dteFechaTermino'
                                                        },
                                                        {
                                                            x:10,
                                                            y:120,
                                                            xtype:'label',
                                                            html:'Detalles adicionales:'
                                                        },
                                                        {
                                                            x:185,
                                                            y:115,
                                                            xtype:'textarea',
                                                            width:500,
                                                            height:50,
                                                            id:'txtDetallesSustitutivo'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Acoger a sustitutivo',
										width: 730,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtMontoSustitutivo=gEx('txtMontoSustitutivo');
                                                                        var txtAniosSustitutivos=gEx('txtAniosSustitutivos');
                                                                        var txtMesesSustitutivos=gEx('txtMesesSustitutivos');
                                                                        var txtDiasSustitutivos=gEx('txtDiasSustitutivos');
																		if(cmbSustitutivo.getValue()=='')
																		{
																			function resp(btn)
																			{
																				cmbSustitutivo.focus();
																			}
																			msgBox('Debe indicar el sustitutivo al cual se acoge',resp);
																			return;
																		}
																		
																		var pos=obtenerPosFila(cmbSustitutivo.getStore(),'id',cmbSustitutivo.getValue());
                                                                        var registro=cmbSustitutivo.getStore().getAt(pos);
                                                                        arrComplementario=registro.data.valorComp.split('_');
                                                                        datosSustitutivos='{"sustitutivo":"'+cmbSustitutivo.getValue()+'"';                                                                        
                                                                        
                                                                        var oSustitutivo={};
                                                                        oSustitutivo.idSustitutivo=cmbSustitutivo.getValue();
                                                                        oSustitutivo.montoSustitutivo='';
                                                                        oSustitutivo.periodoSustitutivo='';
                                                                        switch(arrComplementario[0])
                                                                        {
                                                                            case '2'://Monto
                                                                                if((txtMontoSustitutivo.getValue()=='')||(txtMontoSustitutivo.getValue()<=0))
                                                                                {
                                                                                    function resp6()
                                                                                    {
                                                                                        txtMontoSustitutivo.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el monto impuesto como sustitutivo',resp6);
                                                                                    return;
                                                                                }
                                                                                oSustitutivo.montoSustitutivo=txtMontoSustitutivo.getValue();
                                                                                var dteFechaInicio=gEx('dteFechaInicio');
                                                                                if(dteFechaInicio.getValue()=='')
																				{
																					function resp100(btn)
																					{
																						dteFechaInicio.focus();
																					}
																					msgBox('Debe indicar la fecha en que deber&aacute; cumplirse',resp100);
																					return;
																				}
                                                                           		oSustitutivo.fechaInicio=dteFechaInicio.getValue().format('Y-m-d');
                                                                           		oSustitutivo.fechaTermino='';
                                                                            break;
                                                                            case '5'://Periodo
                                                                                if(((txtAniosSustitutivos.getValue()=='')||(txtAniosSustitutivos.getValue()<=0))&&((txtMesesSustitutivos.getValue()=='')||(txtMesesSustitutivos.getValue()<=0))&&((txtDiasSustitutivos.getValue()=='')||(txtDiasSustitutivos.getValue()<=0)))
                                                                                {
                                                                                    function resp7()
                                                                                    {
                                                                                        txtAniosSustitutivos.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el periodo de duraci&oacute;n del sustitutivo impuesto',resp7);
                                                                                    return;
                                                                                }
                                                                                
                                                                                oSustitutivo.periodoSustitutivo=(txtAniosSustitutivos.getValue()==''?0:txtAniosSustitutivos.getValue())+'|'+
                                                                                								(txtMesesSustitutivos.getValue()==''?0:txtMesesSustitutivos.getValue())+'|'+
                                                                                            					(txtDiasSustitutivos.getValue()==''?0:txtDiasSustitutivos.getValue());
                                                                              
                                                                                
                                                                                  
                                                                                    
                                                                             	var dteFechaInicio=gEx('dteFechaInicio');
                                                                                if(dteFechaInicio.getValue()=='')
																				{
																					function resp100(btn)
																					{
																						dteFechaInicio.focus();
																					}
																					msgBox('Debe indicar la fecha de inicio del sustitutivo impuesto',resp100);
																					return;
																				}
                                                                           		oSustitutivo.fechaInicio=dteFechaInicio.getValue().format('Y-m-d');    
                                                                           		var dteFechaTermino=gEx('dteFechaTermino');
                                                                                if(dteFechaTermino.getValue()=='')
																				{
																					function resp101(btn)
																					{
																						dteFechaTermino.focus();
																					}
																					msgBox('Debe indicar la fecha de t&eacute;rmino del sustitutivo impuesto',resp101);
																					return;
																				}
                                                                           		oSustitutivo.fechaTermino=dteFechaTermino.getValue().format('Y-m-d');       
                                                                            break;
                                                                        }
                                                                        oSustitutivo.idPena=fila.data.idPena;
                                                                        oSustitutivo.detallesAdicionales=gEx('txtDetallesSustitutivo').getValue();
																		var cadObj=convertirCadenaJson(oSustitutivo);
																		
																		function funcAjax()
																		{
																			var resp=peticion_http.responseText;
																			arrResp=resp.split('|');
																			if(arrResp[0]=='1')
																			{
																				gEx('gGridPenas').getStore().reload();
																				ventanaAM.close();
																			}
																			else
																			{
																				msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																			}
																		}
																		obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=186&cadObj='+cadObj,true);
																		
																		
																		
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

function calcularPeriodoSustitutivo()
{
	var dteFechaInicio=gEx('dteFechaInicio');
	if(dteFechaInicio.getValue()=='')
		return;
	
	var fechaTermino=dteFechaInicio.getValue().add(Date.YEAR,gEx('txtAniosSustitutivos').getValue()==''?0:parseInt(gEx('txtAniosSustitutivos').getValue()));
	fechaTermino=fechaTermino.add(Date.MONTH,gEx('txtMesesSustitutivos').getValue()==''?0:parseInt(gEx('txtMesesSustitutivos').getValue()));
	fechaTermino=fechaTermino.add(Date.DAY,gEx('txtDiasSustitutivos').getValue()==''?0:parseInt(gEx('txtDiasSustitutivos').getValue()));
	gEx('dteFechaTermino').setValue(fechaTermino);
}

function mostrarVentanaCancelarAcogimientoSustitutivo(fila)
{
	filaPena=fila;
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			
                                                        {
															  x:0,
															  y:0,
															  width:670,
															  height:183,
															  id:'f_1_1',    
															  hidden:true,                                                      
															  border:false,
															  layout:'absolute',
															  defaultType: 'label',
															  xtype:'fieldset',
															  items:	[
																		  {
																			  x:0,
																			  y:10,
																			  html:'Fecha de reinicio de la pena:'
																		  },  
																		  
																		  {
																				x:160,
																				y:5,
																				xtype:'datefield',
																				value:'<?php echo date('Y-m-d')?>',
																				id:'dteFechaInicioPena',
																				listeners:	{
																							  	select:calcularPenaCumplirCancelarAcogidaSustitutivo
																							}

																		  },
																		 
																		  {
																			  x:0,
																			  y:40,
																			  html:'Periodo a cumplir:'
																		  },
																		  
																		  {
																			  xtype:'fieldset',
																			  width:650,                                                                                              
																			  id:'fsPrisionPunitiva',
																			  height:80,
																			  x:140,
																			  y:30,
																			  border:false,
																			  layout:'absolute',
																			  items:	[

																						  {
																							  x:10,
																							  y:0,
																							  xtype:'numberfield',
																							  allowDecimals:false,
																							  alowNegative:false,
																							  width:40,
																							  value:0,                                                                                                             
																							  listeners:	{
																											  change:calcularPenaCumplirCancelarAcogidaSustitutivo
																										  },
																							  id:'txtAniosPunitiva'
																						  },
																						  {
																							  xtype:'label',
																							  html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">A&ntilde;os</span>',
																							  x:15,
																							  y:25
																						  },
																						  {
																							  x:60,
																							  y:0,
																							  xtype:'numberfield',
																							  width:40,

																							  listeners:	{
																											  change:calcularPenaCumplirCancelarAcogidaSustitutivo
																										  },
																							  allowDecimals:false,
																							  alowNegative:false,
																							  value:0,

																							  id:'txtMesesPunitiva'
																						  },
																						  {
																							  xtype:'label',
																							  html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">Meses</span>',
																							  x:65,
																							  y:25
																						  },
																						  {
																							  x:110,
																							  y:0,
																							  xtype:'numberfield',
																							  width:40,
																							  value:0,

																							  listeners:	{
																											  change:calcularPenaCumplirCancelarAcogidaSustitutivo
																										  },
																							  allowDecimals:false,
																							  alowNegative:false,
																							  id:'txtDiasPunitiva'
																						  },
																						  {
																							  xtype:'label',
																							  html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">D&iacute;as</span>',
																							  x:115,
																							  y:25
																						  }

																						]
																		  }, 
																		 
																		  {
																			  x:360,
																			  y:40,
																			  html:'Fecha de t&eacute;rmino de pena:'
																		  },
																		  {
																				x:520,
																				y:35,
																				xtype:'datefield',
																				value:'',
																				id:'dteFechaTerminoPena'

																		  }
																	  ]
														  },
                                                        {
                                                          x:0,
                                                          y:0,
                                                          width:670,
                                                          height:180,
                                                          id:'f_1',    
                                                          hidden:true,                                                      
                                                          border:false,
                                                          layout:'absolute',
                                                          defaultType: 'label',
                                                          xtype:'fieldset',
                                                          items:	[
                                                                                                                                      
                                                                      {
                                                                          x:0,
                                                                          y:10,
                                                                          html:'Fecha en que deber&aacute; cumplirse la pena retomada:'
                                                                      },
                                                                      {
                                                                      		x:270,
                                                                            y:5,
                                                                            xtype:'datefield',
                                                                            id:'dteFechaCumplimiento'
                                                                            
                                                                      },
                                                                      {
                                                                          x:0,
                                                                          y:40,
                                                                          html:'Fecha en que prescribe la pena retomada:'
                                                                      },
                                                                      {
                                                                      		x:270,
                                                                            y:35,
                                                                            xtype:'datefield',
                                                                            id:'dteFechaPrescripcion'
                                                                            
                                                                      }
                                                                  ]
                                                      },
                                                      {
                                                      	x:10,
                                                        y:100,
                                                        html:'Motivo de la cancelaci&oacute;n:'
                                                      },
                                                      {
                                                      	x:10,
                                                        y:130,
                                                        xtype:'textarea',
                                                        width:630,
                                                        height:80,
                                                        id:'txtComentariosAdicionales'
                                                      }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Cancelar acogimiento de pena',
										width: 680,
										height:320,
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
                                                                 		var txtComentariosAdicionales=gEx('txtComentariosAdicionales');
                                                                 		
                                                                 		var cadObj='';
                                                                 		if(gEx('f_1_1').isVisible())
                                                                 		{
                                                                 			if(gEx('dteFechaInicioPena').getValue()=='')
																			{
																				function resp()
																				{
																					txtComentariosAdicionales.focus();

																				}
																				msgBox('Debe ingresar la fecha de reinicio de la pena',resp);
																				return;
																			}

																			if(gEx('dteFechaTerminoPena').getValue()=='')
																			{
																				function resp2()
																				{
																					gEx('dteFechaTerminoPena').focus();

																				}
																				msgBox('Debe ingresar la fecha de t&eacute;rmino de la pena',resp2);
																				return;
																			}
                                                                 			cadObj='{"fechaInicio":"'+gEx('dteFechaInicioPena').getValue().format('Y-m-d')+'","fechaTermino":"'+
																						gEx('dteFechaTerminoPena').getValue().format('Y-m-d')+'","idPena":"'+fila.data.idPena+'","motivoCancelacion":"'+
																						cv(txtComentariosAdicionales.getValue())+'","periodoCumplir":"'+(gEx('txtAniosPunitiva').getValue()+'|'+gEx('txtMesesPunitiva').getValue()+
																						'|'+gEx('txtDiasPunitiva').getValue())+'"}';
                                                                 		}
                                                                 		else
                                                                 		{
                                                                 			if(gEx('dteFechaCumplimiento').getValue()=='')
																			{
																				function resp3()
																				{
																					gEx('dteFechaCumplimiento').focus();

																				}
																				msgBox('Debe ingresar la fecha en que debe cumplirse la pena',resp3);
																				return;
																			}
																			cadObj='{"fechaInicio":"'+gEx('dteFechaCumplimiento').getValue().format('Y-m-d')+'","fechaTermino":"","fechaPrescripcion":"'+
																						gEx('dteFechaPrescripcion').getValue().format('Y-m-d')+'","idPena":"'+fila.data.idPena+'","motivoCancelacion":"'+
																						cv(txtComentariosAdicionales.getValue())+'"}';
                                                                       
                                                                       	}
                                                                        
                                                                        if(txtComentariosAdicionales.getValue()=='')
                                                                 		{
                                                                 			function resp3()
                                                                 			{
                                                                 				txtComentariosAdicionales.focus();
                                                                 			
                                                                 			}
                                                                 			msgBox('Debe ingresar el motivo de la cancelaci&oacute;n del acogimiento de la pena',resp3);
                                                                 			return;
                                                                 		}
                                                                        
                                                                        
                                                                        function funcAjax()
																		{
																			var resp=peticion_http.responseText;
																			arrResp=resp.split('|');
																			if(arrResp[0]=='1')
																			{
																				gEx('gGridPenas').getStore().reload();
																				ventanaAM.close();
																			}
																			else
																			{
																				msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																			}
																		}
																		obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=187&cadObj='+cadObj,true);

                                                                        
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
    if(filaPena.data.tipoIngreso=='5')
		gEx('f_1_1').show();
	else
		gEx('f_1').show();
    
}


function calcularPenaCumplirCancelarAcogidaSustitutivo()
{
	var dteFechaInicioPena=gEx('dteFechaInicioPena');
	var fechaInicioPena=dteFechaInicioPena.getValue();
	if(fechaInicioPena=='')
	{
		return;
	}
	fechaInicioPena=fechaInicioPena.add(Date.YEAR,gEx('txtAniosPunitiva').getValue());
	fechaInicioPena=fechaInicioPena.add(Date.MONTH,gEx('txtMesesPunitiva').getValue());
	fechaInicioPena=fechaInicioPena.add(Date.DAY,gEx('txtDiasPunitiva').getValue());
	gEx('dteFechaTerminoPena').setValue(fechaInicioPena);
}




function mostrarVentanaAdministracionAlertas(fila)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridNotificacionesDia(fila)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Administrar alertas/notificaciones ['+fila.data.carpetaAdministrativa+', Pena: '+Ext.util.Format.stripTags(fila.data.detallePena)+']',
										width: 870,
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
	ventanaAM.show();
}


function crearGridNotificacionesDia(fila)
{
	var arrStatusAlertaCombo=[['0','Todas'],['1,4','Activas'],['2','Canceladas'],['3','Atendidas']];
	var cmbStatusAlertas=crearComboExt('cmbStatusAlertas',arrStatusAlertaCombo,0,0,140);
	cmbStatusAlertas.setValue('0');
	cmbStatusAlertas.on('select',recargarGridAlertas);
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
                                                        {name: 'responsableCancelacion'}
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
                                   		gEx('btnCancelarAlerta').disable();
                                   		
                                    	proxy.baseParams.funcion='12';        
										proxy.baseParams.cA=fila.data.carpetaAdministrativa;
                                      	proxy.baseParams.tAlerta=5;
                                       	proxy.baseParams.valorReferencia1=fila.data.idPena;
                                        proxy.baseParams.status=gEx('cmbStatusAlertas').getValue();
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
                                                                			return '<img src="../images/user_gray.png" title="Alerta Personal">';
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
                                                                width:120,
                                                                hidden:true,
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
                                                                header:'Registrado por',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'responsableRegistro'
                                                            },
                                                             {
                                                                header:'Status alerta',
                                                                width:160,
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
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true, 
                                                                
                                                                tbar: 	[
                                                               				{
																				html:'<b>Mostrar alertas/notificaciones:&nbsp;&nbsp;</b>'
                                                               				},
                                                               				
                                                               				cmbStatusAlertas,
                                                               				
                                                               				'-',
                                                               				{
																				icon:'../images/icon_big_tick.gif',
																				cls:'x-btn-text-icon',
																				id:'btnAtendidaAlerta',
																				text:'Marcar como atendida',
																				handler:function()
																						{
																							var filaA=gEx('gAlertasNotificaciones').getSelectionModel().getSelected();
																							if(!filaA)
																							{
																								msgBox('Debe seleccionar la alerta/notificaci&oacute;n a marcar como atendida');
																								return;
																							}
																							mostrarVentanaAtendida(filaA);
																						}

																			},
                                                               				'-',
                                                               				{
																				icon:'../images/cross.png',
																				cls:'x-btn-text-icon',
																				id:'btnCancelarAlerta',
																				text:'Cancelar alerta/notificaci&oacute;n',
																				handler:function()
																						{
																							var filaA=gEx('gAlertasNotificaciones').getSelectionModel().getSelected();
																							if(!filaA)
																							{
																								msgBox('Debe seleccionar la alerta/notificaci&oacute;n que desea cancelar');
																								return;
																							}
																							mostrarVentanaCancelar(filaA);
																						}

																			},
                                                               				'-',
                                                               				{
																				icon:'../images/clock_add.png',
																				cls:'x-btn-text-icon',
																				id:'btnCrearAlerta',
																				text:'Crear alerta/notificaci&oacute;n',
																				handler:function()
																						{
																							
																							mostrarVentanaCrearAlerta(fila);
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
													{
														gEx('btnAtendidaAlerta').enable();
														gEx('btnCancelarAlerta').enable();
													}
												}
									)
        tblGrid.getSelectionModel().on('rowdeselect',function(sm,nFila,registro)
													{
														gEx('btnAtendidaAlerta').disable();
														gEx('btnCancelarAlerta').disable();

													}
										)
        return 	tblGrid;	
}

function formatearFilaNotificacion(record, rowIndex, p, ds) 
{
	var xf = Ext.util.Format;   
    
	p.body = 	'<table width="100%"><tr><td width="20"></td><td>';
   	p.body +=		'<table width="800">';
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
																			fF:gEx('txtFechaFin').getValue().format('Y-m-d'),
																			cA:gE('carpetaAdministrativa').value,
                                        									status:gEx('cmbStatusAlertas').getValue()
																		}
															}
														)
}

function mostrarVentanaCrearAlerta(fila)
{
	var cmbTipoAlerta=crearComboExt('cmbTipoAlerta',[['1','General'],['2','Personal']],180,175);
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                            				x:10,
                                            				y:10,
                                            				html:'Fecha de alerta/notificaci&oacute;n:'
                                            			},
                                            			{
                                            				x:180,
                                            				y:5,
                                            				xtype:'datefield',
                                            				id:'dteFechaAlerta'
                                            			},
                                            			{
                                            				x:10,
                                            				y:40,
                                            				html:'Comentario de alerta/notificaci&oacute;n:'
                                            			},
                                            			{
                                            				x:10,
                                            				y:70,
                                            				width:560,
                                            				xtype:'textarea',
                                            				height:80,
                                            				id:'txtComentarioAlerta'
                                            			},
                                            			{
                                            				x:10,
                                            				y:180,
                                            				html:'Tipo de alerta/notificaci&oacute;n:'
                                            			},
                                            			cmbTipoAlerta
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Crear alerta/notificaci&oacute;n',
										width: 620,
										height:300,
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
																		var dteFechaAlerta=gEx('dteFechaAlerta');
																		var txtComentarioAlerta=gEx('txtComentarioAlerta');
																		if(dteFechaAlerta.getValue()=='')
																		{
																			function resp1()
																			{
																				dteFechaAlerta.focus();
																			}
																			msgBox('Debe ingresar la fecha de la alerta/notificaci&oacute;n',resp1);
																			return;
																		}
																		
																		
																		if(txtComentarioAlerta.getValue().trim()=='')
																		{
																			function resp2()
																			{
																				txtComentarioAlerta.focus();
																			}
																			msgBox('Debe ingresar el comentario de la alerta/notificaci&oacute;n',resp2);
																			return;
																		}
																		
																		
																		if(cmbTipoAlerta.getValue()=='')
																		{
																			function resp3()
																			{
																				cmbTipoAlerta.focus();
																			}
																			msgBox('Debe ingresar el tipo de alerta/notificaci&oacute;n',resp3);
																			return;
																		}
																		
																		var cadObj='{"carpetaAdministrativa":"'+fila.data.carpetaAdministrativa+
																				'","fechaAlerta":"'+dteFechaAlerta.getValue().format('Y-m-d')+
																				'","comentarios":"'+cv(txtComentarioAlerta.getValue())+
																				'","tipoAlerta":"'+cmbTipoAlerta.getValue()+'","valorReferencia1":"'+
																				fila.data.idPena+'","tAlerta":"5"}';
																		
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
																		obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=160&cadObj='+cadObj,true);
																		
																	
																	
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

function mostrarVentanaCancelar(fila)
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
                                            				html:'Motivo de la cancelaci&oacute;n:'
                                            				
                                            			},
                                            			{
                                            				xtype:'textarea',
                                            				x:10,
                                            				y:40,
                                            				width:550,
                                            				height:100,
                                            				id:'txtMotivoCancelacionAlerta'
                                            			}
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Cancelar alerta/notificaci&oacute;n',
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
																		gEx('txtMotivoCancelacionAlerta').focus(false,500);
																	}
																}
													},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																	
																		if(gEx('txtMotivoCancelacionAlerta').getValue().trim()=='')
																		{
																			function respA()
																			{	
																				gEx('txtMotivoCancelacionAlerta').focus();
																			}
																			msgBox('Debe ingresar el motivo de la cancelaci&oacute;n de la alerta/notificaci&oacute;n',respA);
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
																						gEx('gAlertasNotificaciones').getStore().reload();
																						ventanaAM.close();
																					}
																					else
																					{
																						msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																					}
																				}
																				obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=159&iA='+fila.data.idRegistro+'&s=2&c='+cv(gEx('txtMotivoCancelacionAlerta').getValue()),true);
																			}
																		}
																		msgConfirm('Est&aacute; seguro de querer cancelar la alerta/notificaci&oacute;n seleccionada',resp);
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

