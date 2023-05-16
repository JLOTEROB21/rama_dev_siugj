<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT DISTINCT anio,anio FROM 7004_seriesUnidadesGestion s ORDER BY anio ASC";
			
	$arrCiclosCarpeta=$con->obtenerFilasArreglo($consulta);
	$anio=date("Y");
	$consulta=" SELECT DISTINCT t.idTipoCarpeta,nombreTipoCarpeta  FROM 7006_carpetasAdministrativas c,7020_tipoCarpetaAdministrativa t 
				 WHERE c.unidadGestion='".$_SESSION["codigoInstitucion"]."' and c.tipoCarpetaAdministrativa=t.idTipoCarpeta";
	$arrTiposCarpetas=$con->obtenerFilasArreglo($consulta);
	
	$tCarpertaDefault=$con->obtenerValor($consulta);
?>

var tCarpertaDefault='<?php echo $tCarpertaDefault ?>';
var arrTiposCarpetas=<?php echo $arrTiposCarpetas?>;
var anio='<?php echo $anio ?>';
var arrCiclosCarpeta=<?php echo $arrCiclosCarpeta?>;

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
                                                title: '<span class="letraRojaSubrayada8" style="font-size:12px"><b>Administraci&oacute;n General de Entrega de Discos</b></span>',
                                                items:	[
                                                           crearGridEntregaDiscos() 
                                                        ]
                                            }
                                         ]
                            }
                        )   
}

function crearGridEntregaDiscos()
{
	var cmbTipoCarpeta=crearComboExt('cmbTipoCarpeta',arrTiposCarpetas,0,0,250);
    cmbTipoCarpeta.setValue(tCarpertaDefault);
    cmbTipoCarpeta.on('select',recargarGrid);
    
    var cmbAnio=crearComboExt('cmbAnio',arrCiclosCarpeta,0,0,120);    
    cmbAnio.setValue(anio);
    cmbAnio.on('select',recargarGrid);
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:	'carpetaAdministrativa'},
		                                                {name: 	'totalDVDSolicitados'},
		                                                {name:	'totalEntregados'},
                                                        {name:  'totalCancelados'},
		                                                {name: 	'totalPorEntregar'}
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
                                                            sortInfo: {field: 'carpetaAdministrativa', direction: 'ASC'},
                                                            groupField: 'carpetaAdministrativa',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='161';
                                        proxy.baseParams.unidadGestion='<?php echo $_SESSION["codigoInstitucion"]?>';
                                        proxy.baseParams.ciclo=gEx('cmbAnio').getValue();
                                        proxy.baseParams.tipoCarpeta=gEx('cmbTipoCarpeta').getValue();
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            
                                                            {
                                                                header:'Carpeta Judicial',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                            },
                                                            {
                                                                header:'Total solicitados',
                                                                width:150,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'totalDVDSolicitados',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(val=='0')
                                                                            	return val;
                                                                        	return '<a href="javascript:mostrarDetalle(\''+bE(registro.data.carpetaAdministrativa)+'\',1)">'+Ext.util.Format.number(val,'0')+'</a>';
                                                                        }
                                                                		
                                                            },
                                                            {
                                                                header:'Entregados',
                                                                width:150,
                                                                sortable:true,
                                                                 align:'center',
                                                                dataIndex:'totalEntregados',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(val=='0')
                                                                            	return val;
                                                                        	return '<a href="javascript:mostrarDetalle(\''+bE(registro.data.carpetaAdministrativa)+'\',2)">'+Ext.util.Format.number(val,'0')+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Cancelados',
                                                                width:150,
                                                                sortable:true,
                                                                 align:'center',
                                                                dataIndex:'totalCancelados',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(val=='0')
                                                                            	return val;
                                                                        	return '<a href="javascript:mostrarDetalle(\''+bE(registro.data.carpetaAdministrativa)+'\',3)">'+Ext.util.Format.number(val,'0')+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Pendientes de Entregar',
                                                                width:150,
                                                                sortable:true,
                                                                 align:'center',
                                                                dataIndex:'totalPorEntregar',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(val=='0')
                                                                            	return val;
                                                                        	return '<a href="javascript:mostrarDetalle(\''+bE(registro.data.carpetaAdministrativa)+'\',4)">'+Ext.util.Format.number(val,'0')+'</a>';
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gEntregaDiscos',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,  
                                                                tbar: 	[
                                                                			{
                                                                                xtype:'label',
                                                                                html:'<b>A&ntilde;o:</b>&nbsp;&nbsp;&nbsp;'
                                                                            },
                                                                            cmbAnio,'-',
                                                                            {
                                                            
                                                                                xtype:'label',
                                                                                html:'<b>Tipo de carpeta:</b>&nbsp;&nbsp;&nbsp;'
                                                                            },
                                                                            cmbTipoCarpeta
                                                                		],                                                              
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

function recargarGrid()
{
	gEx('gEntregaDiscos').getStore().reload();
}

function mostrarDetalle(c,s)
{
	var lblTitulo='';
	switch(s)
    {
    	case 1:
        	lblTitulo='Discos solicitados';
        break;
        case 2:
        	lblTitulo='Discos entregados';
        break;
        case 3:
        	lblTitulo='Discos cancelados';
        break;
        case 4:
        	lblTitulo='Discos pendientes por entregar';
        break;
    }
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridBitacoraDiscos(c,s)
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
                                        proxy.baseParams.cA=bD(cA);
                                        proxy.baseParams.s=s;
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