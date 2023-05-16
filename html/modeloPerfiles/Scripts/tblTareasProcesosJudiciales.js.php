<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var carpetaAdministrativa;
Ext.onReady(inicializar);

function inicializar()
{
	carpetaAdministrativa=-1;
    
    
   var oConf=	{
                            idCombo:'cmbCarpetaJudicial',
                            anchoCombo:350,
                            raiz:'registros',
                            campoDesplegar:'carpetaAdministrativa',
                            campoID:'carpetaAdministrativa',
                            funcionBusqueda:47,
                            //listClass:"listComboSIUGJ", 
                            //cls:"comboSIUGJBusqueda",
                            //height:30,
                            emptyText:'Buscar Proceso Judicial',
                            //fieldClass:"comboSIUGJBusqueda",
                            //ctCls:"comboWrapSIUGJBusqueda",
                            paginaProcesamiento:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                            confVista:'<tpl for="."><div class="search-item">{carpetaAdministrativa}<br></div></tpl>',
                            campos:	[
                                        {name:'carpetaAdministrativa'},
                                        {name:'idCarpeta'}
    
                                    ],
                            funcAntesCarga:function(dSet,combo)
                                        {
                                            carpetaAdministrativa=-1;
                                            idCarpeta=-1;
                                            var aValor=combo.getRawValue();
                                            dSet.baseParams.criterio=aValor;
                                            dSet.baseParams.uG='';
                                            
                                            
                                            
                                        },
                            funcElementoSel:function(combo,registro)
                                        {
                                            carpetaAdministrativa=registro.data.carpetaAdministrativa;
                                            idCarpeta=registro.data.idCarpeta;
                                            cargarEventosExpediente(carpetaAdministrativa);
                                           
                                            
                                            
                                        }  
                        };

		var carpetaJudicial=crearComboExtAutocompletar(oConf);
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Seguimiento a tareas</b></span>',
                                                tbar:	[
                                                         	{
                                                            	
                                                                html:'<b>Proceso Judicial:</b>&nbsp;&nbsp;'
                                                            } ,
                                                            carpetaJudicial  ,'-',
                                                            {
                                                              icon:'../images/arrow_refresh.PNG',
                                                              cls:'x-btn-text-icon',
                                                              text:'Recargar Eventos',
                                                              handler:function()
                                                                      {
                                                                          gEx('gEventosExpediente').getStore().reload();
                                                                      }
                                                              
                                                          }
                                                        ],
                                               items:	[
                                               				crearGridEventosProcesosJudiciales()
                                               			]
                                            }
                                         ]
                            }
                        )   
}


function crearGridEventosProcesosJudiciales()
{
	var arrSituacionActual=[['1','En espera de atenci&oacute;n'],['2','Atendida']];

	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name:'fechaRegistro', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'fechaMaximaAtencion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'iFormulario'},
                                                        {name: 'iRegistro'},
                                                        {name: 'tipoNotificacion'},
                                                        {name: 'idEstado'},
                                                        {name:'usuarioDestinatario'},
                                                        {name:'despacho'}
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
                                                            sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                            groupField: 'fechaRegistro',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	
                                    	proxy.baseParams.funcion='308';
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:60}),
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'iFormulario',
                                                                renderer:function(val,meta,registro)
                                                                        {
                                                                            return '<a href="javascript:abrirProcesoOrigen(\''+bE(val)+'\',\''+bE(registro.data.iRegistro)+'\')"><img src="../images/magnifier.png" title="Abrir proceso origen" alt="Abrir proceso origen" /></a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de registro',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val)
                                                                			{
                                                                            	return val.format('d/m/Y H:i');
                                                                            }
                                                            },
                                                            {
                                                                header:'Fecha de m&aacute;xima de atenci&oacute;n',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'fechaMaximaAtencion',
                                                                renderer:function(val)
                                                                			{
                                                                            	if(val)
	                                                                            	return val.format('d/m/Y H:i');
                                                                            }
                                                            },
                                                            {
                                                                header:'Tipo de notificaci&oacute;n',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'tipoNotificacion',
                                                                renderer:function(val)
                                                                			{
                                                                            	return mostrarValorDescripcion(val);
                                                                            }
                                                            },
                                                           
                                                            {
                                                                header:'Usuario Asignado',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'usuarioDestinatario',
                                                                renderer:function(val)
                                                                			{
                                                                            	return mostrarValorDescripcion(val);
                                                                            }
                                                            },
                                                            
                                                            {
                                                                header:'Situaci&oacute;n Actual',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'idEstado',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrSituacionActual,val);
                                                                            }
                                                            },
                                                            
                                                            {
                                                                header:'Despacho',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'despacho',
                                                                renderer:function(val)
                                                                			{
                                                                            	return mostrarValorDescripcion(val);
                                                                            }
                                                            }
                                                            
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gEventosExpediente',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                cls:'gridSiugjPrincipal',
                                                                columnLines : false,
                                                                
                                                                
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

function cargarEventosExpediente(cAdministrativa)
{
	gEx('gEventosExpediente').getStore().load	(
    												{
                                                    	url:'../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',
                                                        params: {
                                                        			carpetaAdministrativa:cAdministrativa
                                                        		}
                                                    }
    											);
}

function abrirProcesoOrigen(iF,iR)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['idFormulario',bD(iF)],['idRegistro',bD(iR)],['actor',bE(0)],['dComp',bE('auto')]];
    abrirVentanaFancySuperior(obj);
    
    
}