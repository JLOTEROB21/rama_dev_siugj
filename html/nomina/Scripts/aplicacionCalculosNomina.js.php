<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>	
Ext.onReady(inicializar);


function inicializar()
{
	var dsTablaRegistros = new Ext.data.JsonStore	(

                                                        {
                                                            root: 'registros',
                                                            totalProperty: 'numReg',
                                                            idProperty: 'idCalculo',
                                                            fields: [
                                                            			{name:'idCalculo'},
                                                                        {name: 'orden'},
                                                                        {name:'tipoCalculo'},
                                                                        {name:'codigo'},
                                                                        {name:'nombreConsulta'},
                                                                        {name:'parametros'},
                                                                        {name: 'afectacionNomina'},
                                                                        {name:'nQuincenasAfectacion'},
                                                                        {name:'afectacionCuentas'},
                                                                        {name: 'cicloAfectacion'}
                                                            		],
                                                            remoteSort:true,
                                                            proxy: new Ext.data.HttpProxy	(
  
                                                                                                {
  
                                                                                                    url: '../paginasFunciones/funcionesContabilidad.php'
  
                                                                                                }
  
                                                                                            )
  
                                                        }
  
                                                    );

																		

					/*var filters = new Ext.ux.grid.GridFilters	(

    												{

                                                    	filters:	[ {type: 'string', dataIndex: 'idProceso'},{type: 'string', dataIndex: 'nombre'},{type: 'string', dataIndex: 'descripcion'},{type: 'string', dataIndex: 'tipoProceso'},{type: 'string', dataIndex: 'responsable'}]

                                                    }

                                                );        */                                            
	dsTablaRegistros.setDefaultSort('orden', 'ASC');
	function cargarDatos(proxy,parametros)
    {
        proxy.baseParams.funcion=67;
    }                                      
  
    dsTablaRegistros.on('beforeload',cargarDatos);  
    
    
    var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Orden del c&aacute;culo',
															width:120,
															sortable:true,
															dataIndex:'orden'
														},
														{
															header:'Tipo de c&aacute;lculo',
															width:120,
															sortable:true,
															dataIndex:'tipoCalculo',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val=='1')
                                                                        	return "Deducci&oacute;n";
                                                                        return "Percepci&oacute;n";
                                                                    }
														},
														{
															header:'C&oacute;digo',
															width:120,
															sortable:true,
															dataIndex:'codigo'
														},
														{
															header:'C&aacute;lculo',
															width:350,
															sortable:true,
															dataIndex:'nombreConsulta'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            store:dsTablaRegistros,
                                                            frame:true,
															renderTo:'tblCalculosNomina',
                                                            cm: cModelo,
                                                            height:560,
                                                            width:850,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar concepto',
                                                                            handler:function()
                                                                            		{
                                                                                    	
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover concepto',
                                                                            handler:function()
                                                                            		{
                                                                                    	
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );    
	dsTablaRegistros.load({params:{funcion:67 }});                                                   

}