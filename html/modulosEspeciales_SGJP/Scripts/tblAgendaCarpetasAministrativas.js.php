<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var carpetaAdministrativa='-1';
Ext.onReady(inicializar);

function inicializar()
{
	var oConf=	{
    					idCombo:'cmbCarpetaJudicial',
                        anchoCombo:200,
                        campoDesplegar:'carpetaJudicial',
                        campoID:'carpetaJudicial',
                        funcionBusqueda:47,
                        paginaProcesamiento:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                        confVista:'<tpl for="."><div class="search-item">{carpetaJudicial}<br></div></tpl>',
                        campos:	[
                                    {name:'carpetaAdministrativa'}

                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	carpetaAdministrativa=-1;
                                    	var aValor=combo.getRawValue();
										dSet.baseParams.criterio=aValor;
                                        
                                    },
                      	funcElementoSel:function(combo,registro)
                    				{
                                    	carpetaAdministrativa=registro.data.carpetaAdministrativa;
                                    }  
    				};

	var carpetaJudicial=crearComboExtAutocompletar(oConf)

    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b></b></span>',
                                               	tvar:	[	
                                                			{
                                                            	html:'Carpeta Judicial:&nbsp;&nbsp;'
                                                            }
                                                            carpetaJudicial
                                                            
                                                		],
                                                items:	[
                                                            
                                                        ]
                                            }
                                         ]
                            }
                        )   
}


function crearGridCarpetaAdministrativas()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idPedido'},
		                                                {name: 'txtRazonSocial2'},
		                                                {name:'folioPedido'},
		                                                {name:'fechaRecepcion', type:'date'},
                                                        {name: 'diferencia', type:'int'},
                                                        {name: 'num_Factura'},
                                                        {name: 'fecha_entrada',type:'date'},
                                                        {name: 'Nombre'},
                                                        {name: 'observaciones'},
                                                        {name:'num_entrega'},
                                                        {name:'cond_pago'},
                                                        {name: 'txtRFC'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesAlmacen.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaRecepcion', direction: 'ASC'},
                                                            groupField: 'fechaRecepcion',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='87';
                                        proxy.baseParams.idAlmacen=gE('idAlmacen').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            
                                                            {
                                                                header:'Dict&aacute;men / Resultado',
                                                                width:550,
                                                                sortable:true,
                                                                dataIndex:'dictamen',
                                                                renderer:formatearDictamen
                                                            },
                                                            {
                                                                header:'Fecha comentario',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'fechaComentario',
                                                                renderer:formatearfechaColor
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridComentarios',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:true,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                
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
        return 	tblGrid;	
}
