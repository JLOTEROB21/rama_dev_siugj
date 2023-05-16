<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
var idProceso=-1;
var idFormularioPrincipal=-1 ;  
var idRegistro=-1;
var arrStatusActual=[['1','En espera de atenci\xF3n'],['2','Atendida'],['3','Cancelado - Vencimiento'],['0','Eliminado - Proceso reiniciado'],['5','Cancelado - Proceso Abortado'],['10','En Espera - Proceso Pausado']];
var arrEtapas=[];
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

                                                
                                                items:	[
                                                            {
                                                            	xtype:'panel',
                                                                cls:'panelSiugj',
                                                                region:'north',
                                                                height:240,
                                                                title: 'Movimientos Procesos',
                                                                defaultType: 'label',
                                                                layout:'absolute',
                                                                items:	[	
                                                                			{
                                                                            	x:10,
                                                                                y:15,
                                                                                cls:'SIUGJ_Etiqueta',
                                                                                html:'Nombre del proceso:'
                                                                            },
                                                                            {
                                                                                x:230,
                                                                                y:10,
                                                                                html:'<div id="divNombreProceso"></div>'
                                                                            },
                                                                            {
                                                                            	x:10,
                                                                                y:55,
                                                                                cls:'SIUGJ_Etiqueta',
                                                                                html:'Folio de registro:'
                                                                            },
                                                                            {
                                                                                x:230,
                                                                                y:50,
                                                                                html:'<div id="divFolioProceso"></div>'
                                                                            },
                                                                            {
                                                                            	x:10,
                                                                                y:95,
                                                                                cls:'SIUGJ_Etiqueta',
                                                                                html:'Etapa actual del proceso:'
                                                                            },
                                                                            {
                                                                                x:230,
                                                                                y:95,
                                                                                html:'<div id="divEtapaActual" class="SIUGJ_ControlEtiqueta"></div>'
                                                                            },
                                                                            {
                                                                                xtype:'button',
                                                                                text:'Ver proceso',
                                                                                cls:'btnSIUGJCancel',
                                                                                x:615,
                                                                                y:53,
                                                                                id:'btnVerProceso',
                                                                                icon:'../images/magnifier.png',
                                                                                disabled:true,
                                                            					width:150,
                                                                                handler:function()
                                                                                        {
                                                                                            var obj={};
                                                                                            obj.ancho='100%';
                                                                                            obj.alto='100%';
                                                                                            obj.modal=true;
                                                                                            obj.url='../modeloPerfiles/vistaDTDv3.php';
                                                                                            obj.params=[['idFormulario',idFormularioPrincipal],['idRegistro',idRegistro],['actor',bE(0)],['dComp',bE('auto')]];
                                                                                            abrirVentanaFancySuperior(obj);
                                                                                            
                                                                                            
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                                xtype:'button',
                                                                                text:'Cambiar de Etapa',
                                                                                cls:'btnSIUGJCancel',
                                                                                x:10,
                                                                                y:150,
                                                                                icon:'../images/arrow_switch.png',
                                                                            	id:'btnCambiarProceso',
                                                                                disabled:true,
                                                            					width:190,
                                                                                handler:function()
                                                                                        {
                                                                                            
                                                                                            mostrarVentanaCambiarEtapa();
                                                                                            
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                                xtype:'button',
                                                                                text:'Reiniciar Proceso',
                                                                                cls:'btnSIUGJCancel',
                                                                                x:210,
                                                                                y:150,
                                                                                id:'btnReiniciarProceso',
                                                                                disabled:true,
                                                                                icon:'../images/regresar.png',
                                                            					width:190,
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaAccionProceso(2);
                                                                                            
                                                                                            
                                                                                        }
                                                                                
                                                                            }
                                                                            ,
                                                                            {
                                                                                xtype:'button',
                                                                                text:'Pausar Proceso',
                                                                                cls:'btnSIUGJCancel',
                                                                                x:410,
                                                                                y:150,
                                                                                icon:'../images/control_pause.png',
                                                                                id:'btnPausarProceso',
                                                                                disabled:true,
                                                            					width:190,
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaAccionProceso(3);
                                                                                            
                                                                                            
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                                xtype:'button',
                                                                                text:'Reanudar Proceso',
                                                                                cls:'btnSIUGJCancel',
                                                                                x:410,
                                                                                y:150,
                                                                                hidden:true,
                                                                                icon:'../images/control_play_blue.png',
                                                                                id:'btnReanudarProceso',
                                                                                width:190,
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaAccionProceso(4);
                                                                                            
                                                                                            
                                                                                        }
                                                                                
                                                                            }
                                                                            ,
                                                                            {
                                                                                xtype:'button',
                                                                                text:'Terminar/Abortar Proceso',
                                                                                cls:'btnSIUGJCancel',
                                                                                x:610,
                                                                                y:150,
                                                                                icon:'../images/cross.png',
                                                                                id:'btnTerminarProceso',
                                                                                disabled:true,
                                                            					width:280,
                                                                                handler:function()
                                                                                        {
                                                                                            
                                                                                            mostrarVentanaAccionProceso(5);
                                                                                            
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                		]
                                                                
                                                            },
                                                            {
                                                            	xtype:'tabpanel',
                                                                activeTab:1,
                                                                id:'tabProceso',
                                                                region:'center',
                                                                cls:'tabPanelSIUGJ',
                                                                items:	[
                                                                			{
                                                                                xtype:'panel',
                                                                                title:'Tareas Generadas',   
                                                                                cls:'panelSiugj',
                                                                                layout:'border',
                                                                                region:'center',
                                                                                items:[  
                                                                                        crearGridTareasGeneradas()
                                                                                       ]
                                                                            },
                                                                            {
                                                                                xtype:'panel',
                                                                                title:'Historial',   
                                                                                cls:'panelSiugj',
                                                                                layout:'border',
                                                                                region:'center',
                                                                                items:[  
                                                                                        crearGridHistorial()
                                                                                       ]
                                                                            }
                                                                		]
                                                            }
                                                            
                                                        ]
                                            }
                                         ]
                            }
                        )
	idProceso=-1;
    idFormularioPrincipal=-1         
	var oConf=	{
                  idCombo:'cmbNombreProceso',
                  anchoCombo:600,
                  posX:0,
                  posY:0,
                  raiz:'registros',
                  campoDesplegar:'nombre',
                  campoID:'idProceso',
                  funcionBusqueda:1,
                  renderTo:'divNombreProceso',
                  ctCls:'campoComboWrapSIUGJAutocompletar',
                  listClass:'listComboSIUGJ',
                  paginaProcesamiento:'../paginasFunciones/funcionesProcesos.php',
                  confVista:'<tpl for="."><div class="search-item">[{cveProceso}] {nombre}<br>----<br>{descripcion}</div></tpl>',
                  campos:	[
                              {name:'idProceso'},
                              {name:'nombre'},
                              {name: 'descripcion'},
                              {name: 'cveProceso'},
                              {name: 'arrEtapas'},
                              {name: 'idFormularioPrincipal'}

                          ],
                  funcAntesCarga:function(dSet,combo)
                              {
                                  	idProceso='-1';
                                  	var aValor=combo.getRawValue();
                                  	dSet.baseParams.criterio=aValor;
                                  	idFormularioPrincipal=-1;
									arrEtapas=null;
                                  
                                  	idRegistro='-1';
                                    gEx('gTareas').getStore().removeAll();
                                    gEx('gridHistorial').getStore().removeAll();
                                    gEx('btnVerProceso').disable();
                                    gEx('cmbFolioProceso').setRawValue('');                                     
                                                                        
                                  
                              },
                  funcElementoSel:function(combo,registro)
                              {
                                  idProceso=registro.data.idProceso;
                                  idFormularioPrincipal=registro.data.idFormularioPrincipal;
                                  arrEtapas=registro.data.arrEtapas;
                                  var resultado= formatearValorRendererNumerico(arrEtapas,500);
                                  if(resultado=='')
	                                  arrEtapas.slice(0,0,['500','Proceso Pausado']);
                                  resultado= formatearValorRendererNumerico(arrEtapas,510);
                                  if(resultado=='')
	                                  arrEtapas.slice(0,0,['510','Proceso Abortado/Cerrado']);
                              }  
              };
              
      var cmbNombreProceso=crearComboExtAutocompletar(oConf);        
      
      cmbNombreProceso.focus(false,500); 
      idRegistro=-1;
      var oConf=	{
                      idCombo:'cmbFolioProceso',
                      anchoCombo:350,
                      posX:0,
                      posY:0,
                      raiz:'registros',
                      campoDesplegar:'folioProceso',
                      campoID:'idRegistro',
                      funcionBusqueda:2,
                      renderTo:'divFolioProceso',
                      ctCls:'campoComboWrapSIUGJAutocompletar',
                      listClass:'listComboSIUGJ',
                      paginaProcesamiento:'../paginasFunciones/funcionesProcesos.php',
                      confVista:'<tpl for="."><div class="search-item">Folio: {folioProceso}<br>Fecha de Registro: {fechaCreacion:date("d/m/Y H:i")}<br>----</div></tpl>',
                      campos:	[
                                  {name:'idRegistro'},
                                  {name:'folioProceso'},
                                  {name: 'fechaCreacion'},
                                  {name: 'idEstado'}
    
                              ],
                      funcAntesCarga:function(dSet,combo)
                                  {
                                      idRegistro='-1';
                                      var aValor=combo.getRawValue();
                                      dSet.baseParams.criterio=aValor;
                                      dSet.baseParams.iP=bE(idProceso);
								      gEx('gridHistorial').getStore().removeAll();
                                      gEx('gTareas').getStore().removeAll();
                                      gEx('btnVerProceso').disable();
                                      gEx('btnCambiarProceso').disable();
                                      gEx('btnReiniciarProceso').disable();
                                      gEx('btnPausarProceso').disable();
                                      gEx('btnTerminarProceso').disable();
                                      gEx('btnReanudarProceso').hide();	
                                      gEx('btnReanudarProceso').disable();
                                  
                                                                            
                                      
                                  },
                      funcElementoSel:function(combo,registro)
                                  {
                                      idRegistro=registro.data.idRegistro;
                                      gE('divEtapaActual').innerHTML=formatearValorRendererNumerico(arrEtapas,registro.data.idEstado);
                                      cargarGridTareas();
                                      gEx('btnVerProceso').enable();
                                      gEx('btnCambiarProceso').enable();
                                      gEx('btnReiniciarProceso').enable();
                                      gEx('btnTerminarProceso').enable();
                                      
                                      if(parseInt(registro.data.idEstado)==500)
                                      {
                                      		gEx('btnReanudarProceso').show();	
                                            gEx('btnReanudarProceso').enable();
                                            gEx('btnPausarProceso').hide();	
                                            gEx('btnPausarProceso').disable();
                                      }
                                      else
                                      {
                                      		gEx('btnReanudarProceso').hide();	
                                            gEx('btnReanudarProceso').disable();
                                            gEx('btnPausarProceso').show();	
                                            gEx('btnPausarProceso').enable();
                                      }
                                  }  
                  };
              
      var cmbFolioProceso=crearComboExtAutocompletar(oConf);  
      gEx('tabProceso').setActiveTab(0);                    
}


function crearGridTareasGeneradas()
{

	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idTarea'},
		                                                {name: 'fechaRegistro', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                                {name:'fechaLimiteAtencion',type:'date', dateFormat:'Y-m-d H:i:s'},
		                                                {name: 'remitente'},
                                                        {name: 'codigoUnicoProceso'},
                                                        {name:'actividad'},
                                                        {name:'responsableAtencion'},
                                                        {name: 'statusActual'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                reader: lector,
                                                proxy : new Ext.data.HttpProxy	(

                                                                                  {

                                                                                      url: '../paginasFunciones/funcionesProcesos.php'

                                                                                  }

                                                                              ),
                                                sortInfo: {field: 'fechaRegistro', direction: 'DESC'},
                                                groupField: 'fechaRegistro',
                                                remoteGroup:false,
                                                remoteSort: true,
                                                autoLoad:false
                                                
                                            }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='3';
                                        proxy.baseParams.iF=bE(idFormularioPrincipal);
                                        proxy.baseParams.iR=bE(idRegistro);
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            {
                                                                header:'',
                                                                width:50,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'idTarea',
                                                                renderer:function(val)
                                                                		{
                                                                        	return '<a href="javascript:ventanaOperacionTarea(\''+bE(val)+'\')"><img title="Operaciones de Tarea" alt="Operaciones de Tarea"  src="../images/pencil.png"></a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'ID Tarea',
                                                                width:110,
                                                                sortable:true,
                                                                dataIndex:'idTarea'
                                                            },
                                                            {
                                                                header:'Registro en sistema',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i')
                                                                        }
                                                            },
                                                            {
                                                                header:'Límite de atención',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'fechaLimiteAtencion',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val)
	                                                                        	return val.format('d/m/Y H:i')
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'C&oacute;digo &Uacute;nico de Proceso',
                                                                width:240,
                                                                sortable:true,
                                                                dataIndex:'codigoUnicoProceso'
                                                            },
                                                            {
                                                                header:'Actividad',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'actividad'
                                                            },
                                                            {
                                                                header:'Asignado a',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'responsableAtencion'
                                                            },
                                                            {
                                                                header:'Enviado por',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'remitente'
                                                            },
                                                            {
                                                                header:'Estado Actual',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'statusActual',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrStatusActual,val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gTareas',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                cls:'gridSiugj',
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                                                                             
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

function cargarGridTareas()
{
	var iRegistro=idRegistro;
	gEx('gTareas').getStore().load	(
    									{
                                        	url:'../paginasFunciones/funcionesProcesos.php',
                                            params:	{
                                            			funcion:'3',
                                                        iF:bE(idFormularioPrincipal),
                                                        iR:bE(idRegistro)
                                            		}
                                        }
    								)
                                    
	
	gEx('gridHistorial').getStore().load	(
    									{
                                        	url:'../paginasFunciones/funcionesFormulario.php',
                                            params:	{
                                            			funcion:'241',
                                                        idFormulario:idFormularioPrincipal,
                                                        idRegistro:iRegistro
                                            		}
                                        }
    								)                                  
}

function crearGridHistorial()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name:'fechaOperacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'etapaOriginal'},
		                                                {name:'etapaCambio'},
		                                                {name:'responsable'},
                                                        {name: 'comentarios'}
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
                                                            sortInfo: {field: 'fechaOperacion', direction: 'DESC'},
                                                            groupField: 'fechaOperacion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='241';
                                       
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            {
                                                                header:'Fecha',
                                                                width:300,
                                                                sortable:false,
                                                                menuDisabled :true,
                                                                align:'center',
                                                                dataIndex:'fechaOperacion',
                                                                renderer:function(val,meta,attr)
                                                                		{
                                                                        	meta.attr='style="height:auto;"';
                                                                        	return formatoTitulo(val.format('d')+' de '+arrMeses[parseInt(val.format('m'))-1][1]+' de '+val.format('Y')+'<br>'+val.format('H:i:s')+' hrs.');
                                                                        }
                                                            },
                                                            {
                                                                header:'Etapa original',
                                                                width:320,
                                                                menuDisabled :true,
                                                                sortable:false,
                                                                dataIndex:'etapaOriginal',
                                                                renderer:formatoTitulo2
                                                            },
                                                            {
                                                                header:'Etapa cambio',
                                                                width:320,
                                                                sortable:false,
                                                                menuDisabled :true,
                                                                dataIndex:'etapaCambio',
                                                                renderer:formatoTitulo2
                                                            },                                                            
                                                            {
                                                                header:'Responsable',
                                                                width:400,
                                                                menuDisabled :true,
                                                                sortable:false,
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
                                                        cls:'gridSiugj',                                                                
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
    p.body = '<BR><p style="margin-left: 4em;margin-right: 4em;text-align:justify"><br><span >Comentarios:<br><br>' + ((record.data.comentarios.trim()=="")?"(Sin comentarios)":record.data.comentarios) + '<span></p><br><br><br>';
    return 'x-grid3-row-expanded';
}

function formatoTitulo(val)
{
	return '<span >'+val+'</span>';
}

function formatoTitulo2(val)
{
	return '<div >'+val+'</div>';
}

function formatoTitulo3(val)
{
	return '<div >'+(val)+'</div>';
}

function mostrarVentanaCambiarEtapa(accion)
{
	var cmbEtapaCambio=null;
	var lblVentana='Cambiar de Etapa';
    switch(accion)
    {
    	case 1:
        	lblVentana='Cambiar de Etapa';
        break;
    }
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
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Nombre del Proceso:'
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            x:240,
                                                            y:5,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            html:gEx('cmbNombreProceso').getRawValue()
                                                        },
                                                        {
                                                        	x:10,
                                                            y:90,
                                                            cls:'SIUGJ_Etiqueta',
                                                        	xtype:'label',
                                                            html:'Etapa actual del proceso:'

                                                        },
                                                        {
                                                        	xtype:'label',
                                                            x:240,
                                                            y:85,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            html:'<span id="lblActualProceso">'+gE('divEtapaActual').innerHTML+'</span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            cls:'SIUGJ_Etiqueta',
                                                        	xtype:'label',
                                                            html:'Etapa al cual cambia:'

                                                        },
                                                        {
                                                            x:240,
                                                            y:125,
                                                            html:'<div id="divComboAmbito">'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:170,
                                                            cls:'SIUGJ_Etiqueta',
                                                        	xtype:'label',
                                                            html:'Motivo del cambio:'

                                                        },
                                                        {
                                                        	x:10,
                                                            y:210,
                                                            width:650,
                                                            id:'txtMotivo',
                                                            xtype:'textarea',
                                                            cls:'controlSIUGJ'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: lblVentana,
										width: 700,
										height:420,
										layout: 'fit',
										plain:true,
										modal:true,
                                        closable:false,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	cmbEtapaCambio=crearComboExt('cmbEtapaCambio',arrEtapas,0,0,400,{renderTo:'divComboAmbito',ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl'});
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
																		var cmbEtapaCambio=gEx('cmbEtapaCambio');
                                                                        if(cmbEtapaCambio.getValue()=='')
                                                                        {
                                                                        	function resp(btn)
                                                                            {
                                                                            	if(btn=='yes')
                                                                                {
                                                                                	cmbEtapaCambio.focus();
                                                                                }
                                                                            }
                                                                            msgBox('Debe ingresar la etapa a la cual desea cambiar el proceso',resp);
                                                                           
                                                                        	return;
                                                                        }
                                                                        
                                                                        var txtMotivo=gEx('txtMotivo');
                                                                        if(txtMotivo.getValue()=='')
                                                                        {
                                                                        	function resp2(btn)
                                                                            {
                                                                            	if(btn=='yes')
                                                                                {
                                                                                	txtMotivo.focus();
                                                                                }
                                                                            }
                                                                            msgBox('Debe ingresar el motivo del cambio',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        function respAux(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                                var cadObj='{"idFormulario":"'+idFormularioPrincipal+'","idRegistro":"'+idRegistro+
                                                                                            '","etapaCambio":"'+cmbEtapaCambio.getValue()+'","motivoCambio":"'+
                                                                                            cv(txtMotivo.getValue())+'","tipoAccion":"1"}';
                                                                            
                                                                            
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        function respAux()
                                                                                        {
                                                                                        	gE('divEtapaActual').innerHTML=formatearValorRendererNumerico(arrEtapas,cmbEtapaCambio.getValue());
                                                                                            cargarGridTareas();
                                                                                            ventanaAM.close();
                                                                                            
                                                                                            if(parseInt(cmbEtapaCambio.getValue())==500)
                                                                                            {
                                                                                                  gEx('btnReanudarProceso').show();	
                                                                                                  gEx('btnReanudarProceso').enable();
                                                                                                  gEx('btnPausarProceso').hide();	
                                                                                                  gEx('btnPausarProceso').disable();
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                  gEx('btnReanudarProceso').hide();	
                                                                                                  gEx('btnReanudarProceso').disable();
                                                                                                  gEx('btnPausarProceso').show();	
                                                                                                  gEx('btnPausarProceso').enable();
                                                                                            }
                                                                                            
                                                                                            
                                                                                        }
                                                                                        msgBox('La operaci&oacute;n ha sido realizada exitosamente',respAux)
                                                                                        return;
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesProcesos.php',funcAjax, 'POST','funcion=4&cadObj='+cadObj,true);
                                                                    		}
                                                                        }
                                                                        msgConfirm('¿Est&aacute; seguro de querer cambiar la etapa del proceso?',respAux);
                                                                    }
														}
                                                        
													]
									}
								);
	ventanaAM.show();	
}


function mostrarVentanaAccionProceso(tipoAccion)
{
	var lbltitulo='';
	var cmbEtapaCambio=null;
    switch(tipoAccion)
    {
    	case 2: //Reiniciar Proceso
        	lbltitulo='Reiniciar proceso';
        break;
        case 3: //PAusar Proceso
        	lbltitulo='Pausar proceso';
        break;
        case 4:  //Reanudar proceso
        	lbltitulo='Renudar proceso';
        break;
        case 5:  //Terminar proceso
        	lbltitulo='Terminar proceso';
        break;
        
    }
	
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
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Nombre del Proceso:'
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            x:240,
                                                            y:5,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            html:gEx('cmbNombreProceso').getRawValue()
                                                        },
                                                        {
                                                        	x:10,
                                                            y:90,
                                                            cls:'SIUGJ_Etiqueta',
                                                        	xtype:'label',
                                                            html:'Etapa actual del proceso:'

                                                        },
                                                        {
                                                        	xtype:'label',
                                                            x:240,
                                                            y:85,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            html:'<span id="lblActualProceso">'+gE('divEtapaActual').innerHTML+'</span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            cls:'SIUGJ_Etiqueta',
                                                        	xtype:'label',
                                                            html:'Motivo de la operaci&oacute;n: <span style="color:#F00">*</span>'

                                                        },
                                                        {
                                                        	x:10,
                                                            y:170,
                                                            width:650,
                                                            id:'txtMotivo',
                                                            xtype:'textarea',
                                                            cls:'controlSIUGJ'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: lbltitulo,
										width: 700,
										height:380,
										layout: 'fit',
										plain:true,
										modal:true,
                                        closable:true,
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
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
																		
                                                                        
                                                                        var txtMotivo=gEx('txtMotivo');
                                                                        if(txtMotivo.getValue()=='')
                                                                        {
                                                                        	function resp2(btn)
                                                                            {
                                                                            	if(btn=='yes')
                                                                                {
                                                                                	txtMotivo.focus();
                                                                                }
                                                                            }
                                                                            msgBox('Debe ingresar el motivo de la operaci&oacute;n',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        function respAux(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                                var cadObj='{"idFormulario":"'+idFormularioPrincipal+'","idRegistro":"'+idRegistro+
                                                                                            '","etapaCambio":"1","motivoCambio":"'+
                                                                                            cv(txtMotivo.getValue())+'","tipoAccion":"'+tipoAccion+'"}';
                                                                            
                                                                            
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        function respAux()
                                                                                        {
                                                                                        	gE('divEtapaActual').innerHTML=formatearValorRendererNumerico(arrEtapas,'1');
                                                                                            cargarGridTareas();
                                                                                            switch(tipoAccion)
                                                                                            {
                                                                                                
                                                                                                case 3: //PAusar Proceso
                                                                                                     gEx('btnReanudarProceso').show();	
                                                                                                      gEx('btnReanudarProceso').enable();
                                                                                                      gEx('btnPausarProceso').hide();	
                                                                                                      gEx('btnPausarProceso').disable();
                                                                                                      gE('divEtapaActual').innerHTML=formatearValorRendererNumerico(arrEtapas,'500');
                                                                                                break;
                                                                                                case 4:  //Reanudar proceso
                                                                                                    	gEx('btnReanudarProceso').hide();	
                                                                                                      gEx('btnReanudarProceso').disable();
                                                                                                      gEx('btnPausarProceso').show();	
                                                                                                      gEx('btnPausarProceso').enable();
                                                                                                      gE('divEtapaActual').innerHTML=formatearValorRendererNumerico(arrEtapas,arrResp[1]);
                                                                                                break;
                                                                                                 case 5:  //Terminar proceso
                                                                                                      
                                                                                                      gE('divEtapaActual').innerHTML=formatearValorRendererNumerico(arrEtapas,'510');
                                                                                                break;
                                                                                                
                                                                                                
                                                                                            }
                                                                                            ventanaAM.close();
                                                                                            
                                                                                        }
                                                                                        msgBox('La operaci&oacute;n ha sido realizada exitosamente',respAux)
                                                                                        return;
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesProcesos.php',funcAjax, 'POST','funcion=4&cadObj='+cadObj,true);
                                                                    		}
                                                                        }
                                                                        msgConfirm('¿Est&aacute; seguro de querer '+lbltitulo.toLowerCase()+'?',respAux);
                                                                    }
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJ',
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

function ventanaOperacionTarea(iT)
{
	var idUsuario=-1;
	var arrTipoOperacion=[['1','Marcar tarea como atendida'],['2','Marcar tarea como en espera de atenci\xf3n'],['3','Reasignar tarea'],['4','Clonar tarea - Nueva tarea']];
	var pos=obtenerPosFila(gEx('gTareas').getStore(),'idTarea',bD(iT));
    fila=gEx('gTareas').getStore().getAt(pos);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
                                            cls:'panelSiugj',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                        	xtype:'label',
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'ID Tarea:'
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            x:240,
                                                            y:5,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            html:fila.data.idTarea
                                                        },	
                                                        {
                                                        	x:10,
                                                            y:50,
                                                        	xtype:'label',
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Actividad:'
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            x:240,
                                                            y:45,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            html:fila.data.actividad
                                                        },	
                                                        {
                                                        	x:10,
                                                            y:90,
                                                        	xtype:'label',
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Asignado a:'
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            x:240,
                                                            y:85,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            html:fila.data.responsableAtencion
                                                        },
                                                        {
                                                        	x:10,
                                                            y:130,
                                                        	xtype:'label',
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Tipo de operaci&oacute;n:'
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            x:240,
                                                            y:125,
                                                            html:'<div id="divTipoOperacion"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:170,
                                                        	xtype:'label',
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Motivo de la operaci&oacute;n: <span style="color:#F00">*</span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:210,
                                                            height:60,
                                                            width:700,
                                                            xtype:'textarea',
                                                            cls:'controlSIUGJ',
                                                            id:'txtMotivoOperacion'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:290,
                                                            id:'lblAsignaTarea',
                                                            hidden:true,
                                                        	xtype:'label',
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Asignar Tarea a:'
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            x:240,
                                                            y:285,
                                                            id:'lblDivAsignaTarea',
                                                            hidden:true,
                                                            html:'<div id="divUsuarioAsigna" style="width:475px"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:330,
                                                        	xtype:'label',
                                                            id:'lblFechaVencimiento',
                                                            hidden:true,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Fecha de Vencimiento:'
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            x:240,
                                                            y:325,
                                                            id:'lblDivFechaVencimiento',
                                                           	hidden:true,
                                                            html:'<div id="divFechaVencimiento"  style="width:150px"></div>'
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            x:420,
                                                            y:325,
                                                            id:'lblHoraVencimiento',
                                                            hidden:true,
                                                            html:'<div id="divHoraVencimiento"  style="width:160px"></div>'
                                                        },
                                                        {
                                                        	xtype:'checkbox',
                                                            x:240,
                                                            y:360,
                                                            checked:(!fila.data.fechaLimiteAtencion),
                                                            id:'chkFechaVencimiento',
                                                            hidden:true,
                                                            listeners:	{
                                                            				check:function(chk,valor)
                                                                            	{
                                                                                	if(valor)
                                                                                    {
                                                                                    	gEx('fechaVencimiento').setValue('');
                                                                                        gEx('cmbHoraVencimiento').setValue('');
                                                                                        gEx('fechaVencimiento').disable();
                                                                                        gEx('cmbHoraVencimiento').disable();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                    	gEx('fechaVencimiento').enable();
                                                                                        gEx('cmbHoraVencimiento').enable();
                                                                                    }
                                                                                    
                                                                                }
                                                            			},
                                                            boxLabel:'<span class="SIUGJ_Control">Sin fecha de vencimiento</span>'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Opertaciones de Tarea',
										width: 765,
										height:490,
										layout: 'fit',
										plain:true,
                                        cls:'msgHistorialSIUGJ',
										modal:true,
                                        closable:false,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	
                                                                	cmbTipoOperacion=crearComboExt('cmbTipoOperacion',arrTipoOperacion,0,0,420,{renderTo:'divTipoOperacion',ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl'});
																	cmbTipoOperacion.on('select',function(cmb,registro)
                                                                    							{
                                                                                                	gEx('lblAsignaTarea').hide();
                                                                                                    gEx('lblFechaVencimiento').hide();
                                                                                                    gEx('lblDivAsignaTarea').hide();
                                                                                                    gEx('cmbUsuarioResponsable').setRawValue('');
                                                                                                    idUsuario=-1;
                                                                                                    gEx('lblDivFechaVencimiento').hide();
                                                                                                    gEx('lblHoraVencimiento').hide();

                                                                                                    gEx('chkFechaVencimiento').hide();
                                                                                                    switch(registro.data.id)
                                                                                                    {
                                                                                                    	case '3':
                                                                                                        case '4':
                                                                                                        	gEx('lblAsignaTarea').show();
                                                                                                            gEx('lblFechaVencimiento').show();
                                                                                                            gEx('lblDivAsignaTarea').show();
                                                                                                            gEx('lblDivFechaVencimiento').show();
                                                                                                            gEx('lblHoraVencimiento').show();
                                                                                                            gEx('chkFechaVencimiento').show();
                                                                                                        break;
                                                                                                        default:
                                                                                                        	gEx('fechaVencimiento').setValue('');
                                                                                                            gEx('cmbHoraVencimiento').setValue('');
                                                                                                   		break; 
                                                                                                    }
                                                                                                    
                                                                                                }
                                                                    					)
                                                                    var oConf=	{
                                                                                    idCombo:'cmbUsuarioResponsable',
                                                                                    anchoCombo:450,
                                                                                    posX:0,
                                                                                    posY:0,
                                                                                    raiz:'registros',
                                                                                    campoDesplegar:'nombreUsuario',
                                                                                    campoID:'idRegistro',
                                                                                    funcionBusqueda:5,
                                                                                    renderTo:'divUsuarioAsigna',
                                                                                    ctCls:'campoComboWrapSIUGJAutocompletar',
                                                                                    listClass:'listComboSIUGJ',
                                                                                    paginaProcesamiento:'../paginasFunciones/funcionesProcesos.php',
                                                                                    confVista:'<tpl for="."><div class="search-item">[{idUsuario}] {nombreUsuario}<br>{adscripcion}<br>----</div></tpl>',
                                                                                    campos:	[
                                                                                                {name:'idUsuario'},
                                                                                                {name:'nombreUsuario'},
                                                                                                {name: 'adscripcion'}
                                                                  
                                                                                            ],
                                                                                    funcAntesCarga:function(dSet,combo)
                                                                                                {
                                                                                                    idUsuario=-1;
                                                                                                    var aValor=combo.getRawValue();
                                                                                                    dSet.baseParams.criterio=aValor;
                                                                                                    
                                                                                                                                          
                                                                                                    
                                                                                                },
                                                                                    funcElementoSel:function(combo,registro)
                                                                                                {
                                                                                                    idUsuario=registro.data.idUsuario;
                                                                                                    
                                                                                                }  
                                                                                };
                                                                    
                                                                    var fechaVencimiento=new Ext.form.DateField({id:'fechaVencimiento',renderTo:'divFechaVencimiento',ctCls:'campoFechaSIUGJ'})
																	fechaVencimiento.setValue('<?php echo date("Y-m-d") ?>');

                                                                	var cmbHoraVencimiento=crearCampoHoraExt('cmbHoraVencimiento','00:00','23:59',1,false,{renderTo:'divHoraVencimiento',ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl'},0,0,160);
                                                                	cmbHoraVencimiento.setValue('<?php echo date("H:i") ?>');
                                                                            
                                                                    var cmbUsuarioResponsable=crearComboExtAutocompletar(oConf); 

                                                                	if((fila.data.fechaLimiteAtencion)&&(fila.data.fechaLimiteAtencion!=''))
                                                                    {

                                                                    	fechaVencimiento.setValue(fila.data.fechaLimiteAtencion.format('Y-m-d'));
                                                                        cmbHoraVencimiento.setValue(fila.data.fechaLimiteAtencion.format('H:i'));
                                                                    }
                                                                    else
                                                                    {
                                                                    	fechaVencimiento.disable();
                                                                        cmbHoraVencimiento.disable();
                                                                    }
                                                                }
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
                                                                    	var cmbTipoOperacion=gEx('cmbTipoOperacion');
                                                                        if(cmbTipoOperacion.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbTipoOperacion.focus();
                                                                            }
                                                                            	msgBox('Debe indicar el tipo de operaci&oacute;n a realizar',resp)
                                                                            return;
                                                                        }
                                                                        
                                                                        var txtMotivoOperacion=gEx('txtMotivoOperacion');
                                                                        if(txtMotivoOperacion.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	txtMotivoOperacion.focus();
                                                                            }
                                                                            msgBox('Debe indicar el motivo de la operaci&oacute;n a realizar',resp2)
                                                                            return;
                                                                        }
                                                                        
                                                                        var fechaVencimiento=gEx('fechaVencimiento');
                                                                        var cmbHoraVencimiento=gEx('cmbHoraVencimiento');
                                                                        
                                                                        
                                                                        switch(cmbTipoOperacion.getValue())
                                                                        {
                                                                        	case '3':
                                                                            case '4':
                                                                            	if(idUsuario==-1)
                                                                                {
                                                                                	function resp3()
                                                                                    {
                                                                                        gEx('cmbUsuarioResponsable').focus();
                                                                                    }
                                                                                    msgBox('Debe indicar la persona a la cual se asignar&aacute; la tarea',resp3)
                                                                                    return;
                                                                                }	
                                                                                
                                                                                if(gEx('chkFechaVencimiento').getValue())
                                                                                {
                                                                                	
                                                                                    
                                                                                    if(fechaVencimiento.getValue())
                                                                                    {
                                                                                        function resp4()
                                                                                        {
                                                                                            fechaVencimiento.focus();
                                                                                        }
                                                                                        msgBox('Debe indicar la fecha del vencimiento de la tarea',resp4)
                                                                                        return;
                                                                                    }
                                                                                    
                                                                                    if(cmbHoraVencimiento.getValue())
                                                                                    {
                                                                                        function resp5()
                                                                                        {
                                                                                            cmbHoraVencimiento.focus();
                                                                                        }
                                                                                        msgBox('Debe indicar la hora del vencimiento de la tarea',resp5)
                                                                                        return;
                                                                                    }
                                                                                }	
                                                                            
                                                                            break;
                                                                        }
                                                                        
																		var cadObj='{"idTarea":"'+fila.data.idTarea+'","tipoOperacion":"'+cmbTipoOperacion.getValue()+'","motivoOperacion":"'+cv(txtMotivoOperacion.getValue())+
                                                                        			'","responsableAsignacion":"'+idUsuario+'","fechaVencimiento":"'+(fechaVencimiento.getValue()==''?'':(fechaVencimiento.getValue().format('Y-m-d')+' '+cmbHoraVencimiento.getValue()))+
                                                                                    '"}';
                                                                                    
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                cargarGridTareas();
                                                                                ventanaAM.close();
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProcesos.php',funcAjax, 'POST','funcion=6&cadObj='+cadObj,true);
            
                                                                                    
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJ',
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