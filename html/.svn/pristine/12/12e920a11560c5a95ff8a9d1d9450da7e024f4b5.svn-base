<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$camposUGAS="";
	$columnasUGAS="";
	
	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica WHERE cmbCategoria=1 AND id__17_tablaDinamica<>36 ORDER BY prioridad";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$camposUGAS.=",{name:'ugj_".$fila[0]."_1'}";
		$columnasUGAS.=",{
							header:'".$fila[1]."',
							width:130,
							sortable:true,
							dataIndex:'ugj_".$fila[0]."_1'
						}";
		
	}
	
	
?>


Ext.onReady(inicializar);

function inicializar()
{
	crearGridInformeIncidencias();
}

function crearGridInformeIncidencias()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                            			{name:'idConcepto'},
                                               			{name:'concepto'}
		                                                <?php
														echo $camposUGAS
														?>,
                                                        {name:'total'}
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
                                                            sortInfo: {field: 'idConcepto', direction: 'ASC'},
                                                            groupField: 'idConcepto',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='132';
                                        proxy.baseParams.fechaInicio=gE('periodoInicio').value;
                                        proxy.baseParams.fechaFin=gE('periodoFinal').value;
                                        
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'idConcepto'
                                                        },
                                                        {
                                                            header:'Rubro',
                                                            width:550,
                                                            sortable:true,
                                                            dataIndex:'concepto'
                                                        }
                                                        <?php
															echo $columnasUGAS
														?>,
                                                        {
                                                            header:'Total',
                                                            width:100,
                                                            sortable:true,
                                                            dataIndex:'total'
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gReporte',
                                                            store:alDatos,
                                                            renderTo:'tblInforme',
                                                            frame:false,
                                                            cm: cModelo,
                                                            height:500,
                                                            width:1100,
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
