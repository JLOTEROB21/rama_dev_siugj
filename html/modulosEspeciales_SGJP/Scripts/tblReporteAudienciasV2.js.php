<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


Ext.onReady(inicializar);

function inicializar()
{
	crearGridInformeAudiencias();
}

function crearGridInformeAudiencias()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idUnidadGestion'},
                                                        {name: 'categoria'},
                                                        {name: 'idCategoria'},
		                                                {name: 'unidadGestion'},
		                                                {name:'carpetasJudiciales'},
		                                                {name:'listaCarpetas'},
                                                        {name: 'promociones'},
                                                        {name: 'promocionesExhortos'},
                                                        {name: 'listaPromociones'},
                                                        {name: 'audienciasSolicitudInicial'},
                                                        {name: 'listaAudienciasIniciales'},
                                                        {name: 'audienciasPromocion'},
                                                        {name:'listaAudienciasPromocion'},
                                                        {name:'audienciasVarias'},
                                                        {name: 'audienciasContinuacion'},
                                                        {name: 'listaAudienciasContinuacion'},
                                                        {name: 'listaAudienciasVarias'},
                                                        {name: 'totalAudiencias'},
                                                        {name: 'listaTotalAudiencias'},
                                                        {name: 'carpetasExhortos'},
                                                        {name: 'listaCarpetasEx'}
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
                                                            sortInfo: {field: 'categoria', direction: 'ASC'},
                                                            groupField: 'categoria',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='109';
                                        proxy.baseParams.fechaInicio=gE('fechaInicio').value;
                                        proxy.baseParams.fechaFin=gE('fechaFin').value;
                                    }
                        )   
      
	var summary = new Ext.ux.grid.GridSummary();
    var summary2 = new Ext.ux.grid.HybridSummary();;      
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                        	{
                                                                header:'Categor&iacute;a',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'categoria'
                                                            },
                                                            {
                                                                header:'Unidad de gesti&oacute;n',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'unidadGestion'
                                                            },
                                                            {
                                                                header:'Carpetas<br>judiciales',
                                                                width:100,
                                                                align:'center',
                                                                summaryType:'sum',
                                                                sortable:true,
                                                                dataIndex:'carpetasJudiciales',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return val;
                                                                        	if(!registro.get)
                                                                            	return val;
                                                                            
                                                                            
                                                                        	return '<a href="javascript:abrirListadoCarpetasJudiciales(\''+bE(registro.data.idUnidadGestion)+
                                                                            		'\',\''+bE(registro.data.listaCarpetas)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                             {
                                                                header:'Exhortos',
                                                                width:100,
                                                                align:'center',
                                                                summaryType:'sum',
                                                                sortable:true,
                                                                dataIndex:'carpetasExhortos',
                                                                renderer:function(val,meta,registro)
                                                                		{	
                                                                        	return val;
                                                                        	if(!registro.get)
                                                                            	return val;
                                                                        	if(registro.data.idCategoria!='1')
                                                                            	return '--';
                                                                        	return '<a href="javascript:abrirListadoCarpetasJudiciales(\''+bE(registro.data.idUnidadGestion)+
                                                                            		'\',\''+bE(registro.data.listaCarpetasEx)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Promociones',
                                                                width:100,
                                                                align:'center',
                                                                sortable:true,
                                                                summaryType:'sum',
                                                                dataIndex:'promociones',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return val;
                                                                       	 	if(!registro.get)
                                                                            	return val;
                                                                        	return '<a href="javascript:abrirListadoPromociones(\''+bE(registro.data.idUnidadGestion)+
                                                                            		'\',\''+bE(registro.data.listaPromociones)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Promociones<br />(Exhortos)',
                                                                width:100,
                                                                align:'center',
                                                                summaryType:'sum',
                                                                sortable:true,
                                                                dataIndex:'promocionesExhortos',
                                                                renderer:function(val,meta,registro)
                                                                		{	
                                                                        	return val;
                                                                        	if(!registro.get)
                                                                            	return val;
                                                                        	if(registro.data.idCategoria!='1')
                                                                            	return '--';
                                                                        	return '<a href="javascript:abrirListadoCarpetasJudiciales(\''+bE(registro.data.idUnidadGestion)+
                                                                            		'\',\''+bE(registro.data.listaCarpetasEx)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Audiencias celebradas<br>por solicitud inicial',
                                                                width:140,
                                                                align:'center',
                                                                sortable:true,
                                                                summaryType:'sum',
                                                                dataIndex:'audienciasSolicitudInicial',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return val;
                                                                        	return '<a href="javascript:abrirListadoAudiencias(\''+bE(registro.data.idUnidadGestion)+
                                                                            		'\',\''+bE(registro.data.listaAudienciasIniciales)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Audiencias celebradas<br>por promoci&oacute;n',
                                                                width:140,
                                                                align:'center',
                                                                sortable:true,
                                                                summaryType:'sum',
                                                                dataIndex:'audienciasPromocion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return val;
                                                                        	return '<a href="javascript:abrirListadoAudiencias(\''+bE(registro.data.idUnidadGestion)+
                                                                            		'\',\''+bE(registro.data.listaAudienciasPromocion)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Audiencias<br>celebradas por <br>solicitudes varias',
                                                                width:130,
                                                                align:'center',
                                                                sortable:true,
                                                                summaryType:'sum',
                                                                dataIndex:'audienciasVarias',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return val;
                                                                        	return '<a href="javascript:abrirListadoAudiencias(\''+bE(registro.data.idUnidadGestion)+
                                                                            		'\',\''+bE(registro.data.listaAudienciasVarias)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                             {
                                                                header:'Audiencias de<br>continuaci&oacute;n',
                                                                width:130,
                                                                align:'center',
                                                                sortable:true,
                                                                summaryType:'sum',
                                                                dataIndex:'audienciasContinuacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return val;
                                                                        	return '<a href="javascript:abrirListadoAudiencias(\''+bE(registro.data.idUnidadGestion)+
                                                                            		'\',\''+bE(registro.data.listaAudienciasContinuacion)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Total de audiencias<br>celebradas',
                                                                width:120,
                                                                align:'center',
                                                                sortable:true,
                                                                summaryType:'sum',
                                                                dataIndex:'totalAudiencias',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return val;
                                                                        	return '<a href="javascript:abrirListadoAudiencias(\''+bE(registro.data.idUnidadGestion)+
                                                                            		'\',\''+bE(registro.data.listaTotalAudiencias)+'\')">'+val+'</a>';
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridUnidades',
                                                                store:alDatos,
                                                                width:1200,
                                                                height:1150,
                                                                renderTo:'tblUnidades',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                plugins:[summary,summary2],
                                                                columnLines : true,                                                                
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

function abrirListadoAudiencias(iU,l)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tblTableroAudienciasReporte.php';
    obj.params=[['uGestion',bD(iU)],
                ['listaAudiencias',bD(l)]];
    

    window.parent.abrirVentanaFancy(obj);
}

function abrirListadoPromociones(iU,l)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tblPromociones.php';
    obj.params=[['uGestion',bD(iU)],
                ['listaPromociones',bD(l)]];    

    abrirVentanaFancy(obj);
}

function abrirListadoCarpetasJudiciales(iU,l)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tblCarpetasAdministrativasReporte.php';
    obj.params=[['uGestion',bD(iU)],
                ['listaCarpetas',bD(l)]];
    

    window.parent.abrirVentanaFancy(obj);
}