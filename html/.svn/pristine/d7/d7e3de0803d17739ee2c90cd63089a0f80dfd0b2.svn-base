<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var arrTiposMovimiento=[['1','Dep&oacute;sito'],['2','Pagado a beneficiario'],['3','Prescrito'],['4','Traspasado']];
Ext.onReady(inicializar);

function inicializar()
{
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'tabpanel',
                                                region:'center',
                                                cls:'tabPanelSIUGJ',
                                                
                                                border:false,
                                                activeTab:0,
                                                items:	[
                                                            crearGridLibroConcilizacion(),
                                                            crearGridProcesosJudiciales()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}

function crearGridLibroConcilizacion()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'carpetaAdministrativa'},
		                                                {name:'codigoUnidad'},
		                                                {name:'fechaMovimiento', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'numeroDeposito'},
                                                        {name: 'abono'},
                                                        {name: 'cargo'},
                                                        {name:'tipoMovimiento'},
                                                        {name:'fechaRegistro', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'conciliado'},
                                                        {name: 'fechaConciliacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'carpetaAdministrativaDestino'},
                                                        {name: 'codigoUnidadDestino'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloDepositos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                            groupField: 'fechaRegistro',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='1';
                                        proxy.baseParams.codigoUnidad=gE('codigoUnidad').value;
                                        proxy.baseParams.fechaInicio=gE('fechaInicio').value;
                                        proxy.baseParams.fechaFin=gE('fechaFin').value;
                                    }
                        )   
       
       
	var paginador=	new Ext.PagingToolbar	(
                                              {
                                                    pageSize: 200,
                                                    store: alDatos,
                                                    displayInfo: true,
                                                    disabled:false
                                                }
                                             )       
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer({width:40}),
                                                        
                                                        {
                                                            header:'ID',
                                                            width:60,
                                                            sortable:true,
                                                            dataIndex:'idRegistro'
                                                        },
                                                        {
                                                            header:'Fecha registro',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'fechaRegistro',
                                                            renderer:function(val)
                                                            			{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                        },
                                                        {
                                                            header:'Proceso judicial',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'carpetaAdministrativa'
                                                        },
                                                        {
                                                            header:'Despacho',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'codigoUnidad'
                                                        },
                                                        {
                                                            header:'No. dep&oacute;sito',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'numeroDeposito'
                                                        },
                                                        {
                                                            header:'Fecha movimiento',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'fechaMovimiento',
                                                            renderer:function(val)
                                                            			{
                                                                        	return val.format('d/m/Y');
                                                                        }
                                                        },
                                                        {
                                                            header:'Cargo',
                                                            width:180,
                                                            align:'center',
                                                            sortable:true,
                                                            dataIndex:'cargo',
                                                            renderer:'usMoney'
                                                        },
                                                        {
                                                            header:'Abono',
                                                            width:180,
                                                            sortable:true,
                                                            align:'center',
                                                            dataIndex:'abono',
                                                            renderer:'usMoney'
                                                        },
                                                        {
                                                            header:'Tipo movimiento',
                                                            width:200,
                                                            sortable:true,
                                                            dataIndex:'tipoMovimiento',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrTiposMovimiento,val);
                                                                    }
                                                        },
                                                         {
                                                            header:'Proceso judicial trasladado',
                                                            width:235,
                                                            sortable:true,
                                                            dataIndex:'carpetaAdministrativaDestino'
                                                        },
                                                        {
                                                            header:'Despacho al que se traslada',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'codigoUnidadDestino'
                                                        }, 
                                                        {
                                                            header:'Conciliado',
                                                            width:140,
                                                            sortable:true,
                                                            dataIndex:'conciliado',
                                                            renderer:function(val)		
                                                            		{
                                                                    	return val=='1'?'S&iacute;':'No';
                                                                    }
                                                        },
                                                        {
                                                            header:'Fecha conciliaci&oacute;n',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'fechaConciliacion',
                                                            renderer:function(val)		
                                                            		{
                                                                    	if(val)
	                                                                    	return val.format('d/m/Y');
                                                                        return '------';
                                                                    }
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridMovimientos',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            border:false,
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            cls:'gridSiugjPrincipal',
                                                            columnLines : false,
                                                            bbar:[paginador],
                                                            tbar: 	[
                                                            			{
                                                                        	icon:'../images/page_excel.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Generar balance por despacho',
                                                                            handler:function()
                                                                            		{
                                                                                    	
                                                                                        
                                                                                        var arrParametros=	[
                                                                                        						['despachos',gE('codigoUnidad').value],
                                                                                                                ['fechaInicio',gE('fechaInicio').value],
                                                                                                                ['fechaFin',gE('fechaFin').value]
                                                                                        					];
                                                                                        enviarFormularioDatosV('../reportes/generarBalanceDespachos.php',arrParametros);
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                            		],
                                                            title:'Libro de conciliaci&oacute;n',
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :false,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: true,
                                                                                                startCollapsed:false
                                                                                            })
                                                        }
                                                    );
	tblGrid.getStore().load(	{
    								params:	{
                                    			url:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloDepositos.php',
                                                start:0, 
                                                limit:200
                                                
                                    		}
    							}
                           )      


    return 	tblGrid;
}

function crearGridProcesosJudiciales()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'carpetaAdministrativa'},
		                                                {name:'codigoUnidad'},
		                                                {name: 'valorObligacion'},
                                                        {name: 'montoDepositado'},
                                                        {name: 'montoPagado'},
                                                        {name: 'montoPrescrito'},
                                                        {name: 'montoTrasladado'},
                                                        {name: 'saldoActual'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'}
                                                        
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloDepositos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaCreacion', direction: 'ASC'},
                                                            groupField: 'fechaCreacion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='2';
                                        proxy.baseParams.codigoUnidad=gE('codigoUnidad').value;
                                        
                                    }
                        )   
       
       
	var paginador=	new Ext.PagingToolbar	(
                                              {
                                                    pageSize: 200,
                                                    store: alDatos,
                                                    displayInfo: true,
                                                    disabled:false
                                                }
                                             )       

	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});

       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer({width:40}),
                                                        chkRow,
                                                        
                                                        
                                                        {
                                                            header:'Proceso judicial',
                                                            width:200,
                                                            sortable:true,
                                                            dataIndex:'carpetaAdministrativa'
                                                        },
                                                        {
                                                            header:'Despacho',
                                                            width:400,
                                                            sortable:true,
                                                            dataIndex:'codigoUnidad',
                                                            renderer:function(val)
                                                            		{
                                                                    	return mostrarValorDescripcion(val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Fecha Creaci&oacute;n',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'fechaCreacion',
                                                            renderer:function(val)
                                                            			{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                        },
                                                        {
                                                            header:'Valor de la obligaci&oacute;n',
                                                            width:200,
                                                            align:'right',
                                                            sortable:true,
                                                            dataIndex:'valorObligacion',
                                                            renderer:'usMoney'
                                                        },
                                                        {
                                                            header:'Monto depositado',
                                                            width:180,
                                                            align:'right',
                                                            sortable:true,
                                                            dataIndex:'montoDepositado',
                                                            renderer:'usMoney'
                                                        },
                                                        {
                                                            header:'Monto pagado',
                                                            width:150,
                                                            align:'right',
                                                            sortable:true,
                                                            dataIndex:'montoPagado',
                                                            renderer:'usMoney'
                                                        },
                                                        {
                                                            header:'Monto prescrito',
                                                            width:150,
                                                            align:'right',
                                                            sortable:true,
                                                            dataIndex:'montoPrescrito',
                                                            renderer:'usMoney'
                                                        },
                                                        {
                                                            header:'Monto trasladado',
                                                            width:180,
                                                            align:'right',
                                                            sortable:true,
                                                            dataIndex:'montoTrasladado',
                                                            renderer:'usMoney'
                                                        },
                                                        {
                                                            header:'Saldo Actual',
                                                            width:150,
                                                            align:'right',
                                                            sortable:true,
                                                            dataIndex:'saldoActual',
                                                            renderer:'usMoney'
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridProcesosJudiciales',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            border:false,
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            cls:'gridSiugjPrincipal',
                                                            columnLines : false,
                                                            bbar:[paginador],
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/page_excel.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Generar balance por proceso judicial',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas;
                                                                                        filas=gEx('gridProcesosJudiciales').getSelectionModel().getSelections();
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar almenos un proceso judicial');
                                                                                        	return;
                                                                                        }
                                                                                        var fila;
                                                                                        var procesosJudiciales='';
                                                                                        for(x=0;x<filas.length;x++)
                                                                                        {
                                                                                        	fila=filas[x];
                                                                                            if(procesosJudiciales=='')
                                                                                            {
                                                                                            	procesosJudiciales="'"+fila.data.carpetaAdministrativa+"'";
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                            	procesosJudiciales+=",'"+fila.data.carpetaAdministrativa+"'";
                                                                                            }
                                                                                        }
                                                                                        
                                                                                        
                                                                                        enviarFormularioDatosV('../reportes/generarBalanceProcesoJudicial.php',[['procesosJudiciales',procesosJudiciales]]);
                                                                                        
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                            		],

                                                            title:'Procesos Judiciales',
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :false,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: true,
                                                                                                startCollapsed:false
                                                                                            })
                                                        }
                                                    );
	tblGrid.getStore().load(	{
    								params:	{
                                    			url:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloDepositos.php',
                                                start:0, 
                                                limit:200
                                                
                                    		}
    							}
                           )      


    return 	tblGrid;
}