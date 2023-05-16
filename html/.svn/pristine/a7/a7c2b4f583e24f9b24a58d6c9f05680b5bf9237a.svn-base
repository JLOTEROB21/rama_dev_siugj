<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$iR=$_GET["iR"];
	$consulta="SELECT carpetaAdministrativa FROM _441_tablaDinamica WHERE id__441_tablaDinamica=".$iR;
	$cAdministrativa=$con->obtenerValor($consulta);
?>
var iR=<?php echo $iR?>;
var cAdministrativa='<?php echo $cAdministrativa?>';


function functionActerRenderer()
{
	gEx('tPanelCentral').getTopToolbar().add('-');
    gEx('tPanelCentral').getTopToolbar().add	(
    												{
                                                        icon:'../images/Icono_txt.gif',
                                                        cls:'x-btn-text-icon',
                                                        text:'Ver res&uacute;men de copias solicitada',
                                                        handler:function()
                                                                {
                                                                    mostrarDetalleSolicitud();
                                                                }
                                                        
                                                    }	
    											);
}

function mostrarDetalleSolicitud()
{
	var lblTitulo='Discos solicitados';
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridBitacoraDiscos()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: lblTitulo,
										width: 800,
										height:450,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();
}

function crearGridBitacoraDiscos(cA,s)
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'totalDiscos'},
		                                                {name: 'detalle'}
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
                                                            sortInfo: {field: 'totalDiscos', direction: 'ASC'},
                                                            groupField: 'totalDiscos',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='162';
                                        proxy.baseParams.cA=cAdministrativa;
                                        proxy.baseParams.s=5;
                                        proxy.baseParams.iR=iR;
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            
                                                            
                                                            {
                                                                header:'Total de discos',
                                                                width:100,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'totalDiscos',
                                                                renderer:function(val)
                                                                		{
                                                                        	return Ext.util.Format.number(val,'0');
                                                                        }
                                                            },
                                                            {
                                                                header:'Detalles',
                                                                width:600,
                                                                sortable:true,
                                                                dataIndex:'detalle',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	meta.attr='style="height:auto !important;overflow:visible;white-space:normal;"';
                                                                        return val;
                                                                    }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridBitacoraDiscos',
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