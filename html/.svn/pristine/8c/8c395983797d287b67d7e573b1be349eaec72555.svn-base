<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica where claveUnidad in
	(SELECT DISTINCT unidadGestion FROM 7006_carpetasAdministrativas WHERE tipoCarpetaAdministrativa=6) order by prioridad";
	$arrUnidadesGestion=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idRegistro,descripcion FROM 7014_situacionCarpetaAdministrativa";
	$arrSituacion=$con->obtenerFilasArreglo($consulta);
?>
var arrSituacion=<?php echo $arrSituacion?>;
var arrUnidadesGestion=<?php echo $arrUnidadesGestion?>;

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
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b></b></span>',
                                                items:	[
                                                            crearGridCarpetasEjecucion()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}


function crearGridCarpetasEjecucion()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'carpetaAdministrativa'},
                                                        {name:'carpetaAdministrativaBase'},
		                                                {name: 'unidadGestion'},
		                                                {name:'carpetaInvestigacion'},
		                                                {name: 'imputados'},
                                                        {name: 'delitos'},
                                                        {name: 'situacion'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 	
    var tamPagina =300;
	                                                                                      
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
                                    	proxy.baseParams.funcion='175';
                                        
                                    }
                        )   
    
    
    
     var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[ 
                                                        				
                                                                        {type: 'string', dataIndex: 'carpetaAdministrativa'},
                                                                        {type: 'string', dataIndex: 'carpetaAdministrativaBase'},
                                                                        {type: 'string', dataIndex: 'unidadGestion', type:'list', options:arrUnidadesGestion, phpMode:true},
                                                                        {type: 'string', dataIndex: 'carpetaInvestigacion'}
                                                                        
                                                                    ]
                                                    }
                                                );
    
    var paginador=	new Ext.PagingToolbar	(
                                                    {
                                                          pageSize: tamPagina,
                                                          store: alDatos,
                                                          displayInfo: true,
                                                          disabled:false
       												}
                                           )
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:35}),
                                                            
                                                            {
                                                                header:'Unidad de Gesti&oacute;n',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'unidadGestion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrUnidadesGestion,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Carpeta Ejecucion',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                            },
                                                            {
                                                                header:'Carpeta Origen',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativaBase'
                                                            },
                                                            {
                                                                header:'Carpeta de Investigaci&oacute;n',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'carpetaInvestigacion'
                                                            },
                                                            {
                                                                header:'Imputados',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'imputados'
                                                            },
                                                            {
                                                                header:'Delitos',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'delitos'
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n de la carpeta',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSituacion,val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gCarpetasEjecucion',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                bbar:	[paginador],
                                                                plugins:[filters],
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,                                                                
                                                                view:new Ext.ux.grid.BufferView({
                                                                                                    // custom row height
                                                                                                    rowHeight: 60,
                                                                                                    // render rows as they come into viewable area.
                                                                                                    scrollDelay: false
                                                                                                })
                                                            }
                                                        );
        
        
        
        tblGrid.getStore().load		(
        								{
                                        	url:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                        	params:	{
                                            			start:0,
                                                        limit:tamPagina,
                                                        funcion:175
                                                    }
                                                        
                                        }
        							)
        return 	tblGrid;	
}