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
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Procesos asociados</b></span>',
                                               
                                                items:	[
                                                            crearGridProcesoAsociados()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}

function crearGridProcesoAsociados()
{
	 
     var lector= new Ext.data.JsonReader({
                                          
                                          totalProperty:'numReg',
                                          fields: [
                                                      {name:'iFormulario'},
                                                      {name: 'iRegistro'},
                                                      {name:'situacion'},
                                                      {name:'descripcion'},
                                                      {name:'actor'}
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
                                                            sortInfo: {field: 'descripcion', direction: 'ASC'},
                                                            groupField: 'descripcion',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='45';
                                        proxy.baseParams.idFormulario=gE('idFormulario').value;
                                        proxy.baseParams.idRegistro=gE('idRegistro').value;
                                        proxy.baseParams.actor=gE('actor').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            
                                                            
                                                            {
                                                                header:'Proceso',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'descripcion',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'situacion'
                                                            },
                                                            {
                                                                header:'',
                                                                width:50,
                                                                sortable:true,
                                                                dataIndex:'iRegistro',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:abrirRegistroProceso(\''+bE(registro.data.iFormulario)+'\',\''+bE(registro.data.iRegistro)+'\',\''+bE(registro.data.actor)+'\')"><img src ="../images/right1.png"></a>';
                                                                        	
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridComentarios',
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

function abrirRegistroProceso(iF,iR,a)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url="../modeloPerfiles/vistaDTDv3.php";
    obj.params=[['idFormulario',bD(iF)],['idRegistro',bD(iR)],['dComp',bE('auto')],['actor',(a)]];
    window.parent.abrirVentanaFancy(obj);
}