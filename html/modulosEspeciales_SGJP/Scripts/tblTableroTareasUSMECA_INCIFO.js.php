<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$categoriaDocumento="";
	
	if(existeRol("'193_0'"))
		$categoriaDocumento=52;
	
	if(existeRol("'194_0'"))
		$categoriaDocumento=60;
		
	
?>    

var categoriaDocumento='<?php echo $categoriaDocumento ?>';
    
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
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Tareas asignadas</b></span>',
                                                items:	[
                                                            creaGridDelegarTarea()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}


function creaGridDelegarTarea()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idUsuario'},
		                                                {name: 'nombre'},
		                                                {name:'tareasAsignadas'},
		                                                {name: 'tareasAtendidas'},
                                                        {name: 'tareasPorAtender'},
                                                        {name: 'asignado'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_MedidasCautelares.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombre', direction: 'ASC'},
                                                            groupField: 'nombre',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='2';
                                        proxy.baseParams.iT=4;
                                        proxy.baseParams.cD=categoriaDocumento;

                                    }
                        )   

	var chkRow=new Ext.grid.CheckboxSelectionModel({sigleSelect:true});       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:30}),
                                                            chkRow,
                                                             
                                                            {
                                                                header:'Nombre',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'nombre'
                                                            },
                                                            {
                                                                header:'Tareas asignadas',
                                                                width:130,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'tareasAsignadas',
                                                                renderer:function(val)
                                                                			{
                                                                            	return Ext.util.Format.number(val,'0,000');
                                                                            }
                                                            },
                                                            {
                                                                header:'Tareas atendidas',
                                                                width:130,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'tareasAtendidas',
                                                                renderer:function(val)
                                                                			{
                                                                            	return Ext.util.Format.number(val,'0,000');
                                                                            }
                                                            },
                                                            {
                                                                header:'Tareas por atender',
                                                                width:130,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'tareasPorAtender',
                                                                renderer:function(val)
                                                                			{
                                                                            	return Ext.util.Format.number(val,'0,000');
                                                                            }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gTareas',
                                                                store:alDatos,
                                                                region:'center',
                                                                sm:chkRow,
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