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
                                                border:false,
                                                items:	[
                                                            crearGridBitacoraSeguimiento()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}

function crearGridBitacoraSeguimiento()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name:'iFormulario'},
		                                                {name:'fechaMovimiento', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'iRegistro'},
                                                        {name: 'descripcion'}
                                                        
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesScriptsFormularios.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaMovimiento', direction: 'ASC'},
                                                            groupField: 'fechaMovimiento',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='4';
                                        proxy.baseParams.idFormulario=gE('idFormulario').value;
                                        proxy.baseParams.idRegistro=gE('idRegistro').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            
                                                            {
                                                                header:'Fecha',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'fechaMovimiento',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y h:i')
                                                                        }
                                                            },
                                                            {
                                                                header:'Descripci&oacute;n',
                                                                width:600,
                                                                sortable:true,
                                                                dataIndex:'descripcion'
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gSeguimiento',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
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