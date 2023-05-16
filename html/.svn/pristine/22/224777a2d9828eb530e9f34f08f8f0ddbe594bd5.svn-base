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
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Comprobaciones del Sistema</b></span>',
                                                items:	[
                                                            crearGridVerificacionRequerimientos()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}


function crearGridVerificacionRequerimientos()
{
     var lector= new Ext.data.JsonReader({
                                      
                                      totalProperty:'numReg',
                                      fields: [
                                                  {name:'idRequerimiento'},
                                                  {name:'lblRequerimiento'},
                                                  {name: 'situacion'},
                                                  {name:'mensaje'}
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
                                                            sortInfo: {field: 'situacion', direction: 'ASC'},
                                                            groupField: 'lblRequerimiento',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='4';
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'Situaci&oacute;n',
                                                                width:80,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val)
                                                                			{
                                                                            	return val=='1'?'<img src="../images/accept_green.png">':'<img src="../images/cancel_round.png">';
                                                                            }
                                                            },
                                                            
                                                            {
                                                                header:'Requerimiento',
                                                                width:500,
                                                                sortable:true,
                                                                dataIndex:'lblRequerimiento'
                                                            },
                                                            
                                                            {
                                                                header:'Mensaje',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'mensaje',
                                                                renderer:function(val)
                                                                		{
                                                                        	var color='';
                                                                        	if(val=='OK')
                                                                            	color='#030';
                                                                            else
                                                                            	color='#900';
                                                                        
                                                                        	return '<span style="color:'+color+'"><b>'+val+'</b></span>';
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridRequerimientos',
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