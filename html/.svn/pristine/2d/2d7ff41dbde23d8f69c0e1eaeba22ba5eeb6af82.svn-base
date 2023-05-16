<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


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
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Monitor de Componentes</b></span>',
                                                items:	[
                                                            crearGridMonitoreo()
                                                        ]
                                            }
                                         ]
                            }
                        )   
                        
                        
	setInterval(recargarGrids,600000);
                        
}

function crearGridMonitoreo()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'nombreTipoComponene'},
		                                                {name: 'componenteOnline'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesEspecialesSistema.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreTipoComponene', direction: 'ASC'},
                                                            groupField: 'nombreTipoComponene',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='7';
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            
                                                            {
                                                                header:'Nombre del Componente',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'nombreTipoComponene'
                                                            },
                                                            {
                                                                header:'Funcionando',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'componenteOnline',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val=='1')
                                                                            {
                                                                            	return '<img src="../images/icon_tick.gif" width="16" height="16">';
                                                                            }
                                                                            else
                                                                            	if(val=='2')
	                                                                            	return '----';
                                                                            	return '<img src="../images/cross.png" width="16" height="16">';
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gMonitoreoComponentes',
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
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;	
}


function recargarGrids()
{
	gEx('gMonitoreoComponentes').getStore().reload();
}
