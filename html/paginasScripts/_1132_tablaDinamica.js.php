<?php
	session_start();

	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);

	$idRegistro=bD($_GET["iR"]);


	$consultas="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE institucion=10 AND codigoUnidad LIKE '10000003%' ORDER BY unidad";
	$arrDistritos=$con->obtenerFilasArreglo($consultas);
	
	$consultas="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE institucion=12 AND codigoUnidad LIKE '10000003%' ORDER BY unidad";
	$arrCircuitos=$con->obtenerFilasArreglo($consultas);
	
	$consultas="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE institucion=13 AND codigoUnidad LIKE '10000003%' ORDER BY unidad";
	$arrMunicipios=$con->obtenerFilasArreglo($consultas);
	
	$consultas="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica ORDER BY nombreUnidad";
	$arrDespachos=$con->obtenerFilasArreglo($consultas);



?>

var cadenaFuncionValidacion='validarAmbitoAplicacion';

var idFecha=<?php echo $idRegistro?>;
var arrDistritos=<?php echo $arrDistritos?>;
var arrCircuitos=<?php echo $arrCircuitos?>;
var arrMunicipios=<?php echo $arrMunicipios?>;
var arrDespachos=<?php echo $arrDespachos?>;


function inyeccionCodigo()
{
	gE('sp_14839').innerHTML='';
    
    
    
	new Ext.TabPanel 	(
    						{
                            	id:'tpanelAmbito',
                                disabled:esRegistroFormulario(),
                                renderTo:'sp_14839',
                                title:'&Aacute;mbito de Aplicaci&oacute;n',
                                width:630,
                                height:350,
                                activeTab:0,
                                items:	[
                                            {
                                                xtype:'panel',
                                                title:'Distritos',
                                                items:	[
                                                            crearGridCatalogos(idFecha,1)
                                                        ]
                                            },
                                            {
                                                xtype:'panel',
                                                title:'Circuitos',
                                                items:	[
                                                            crearGridCatalogos(idFecha,2)
                                                        ]
                                            },
                                            {
                                                xtype:'panel',
                                                title:'Municipios',
                                                items:	[
                                                            crearGridCatalogos(idFecha,3)
                                                        ]
                                            },
                                            {
                                                xtype:'panel',
                                                title:'Despachos',
                                                items:	[
                                                            crearGridCatalogos(idFecha,4)
                                                        ]
                                            }
                                        ]
                            }
    					)
   

	if(esRegistroFormulario())
    {
    	asignarEvento(gE('opt_ambitoGlobalvch_1'),'click',function()
        							{
                                    	gEx('tpanelAmbito').disable();
                                    }
        			);      
	
    	asignarEvento(gE('opt_ambitoGlobalvch_0'),'click',function()
        							{
                                    	gEx('tpanelAmbito').enable();
                                        var x;
                                        for(x=1;x<=4;x++)
                                        {
                                        	gEx('gridCatalogo_'+x).getStore().removeAll();
                                        }
                                    }
        			);
                    
		if(gE('opt_ambitoGlobalvch_1').checked)
        {
        	gEx('tpanelAmbito').enable();
        }                    
                                              
    }


}


function crearGridCatalogos(idFecha,tA)
{

	var lblEtiqueta='';
    switch(tA)
    {
    	case 1:
        	lblEtiqueta='Distrito';
        break;
        case 2:
        	lblEtiqueta='Circuito';
        break;
        case 3:
        	lblEtiqueta='Municipio';
        break;
        case 4:
        	lblEtiqueta='Despacho';
        break;
    }



	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'cveElemento'},
		                                                {name: 'nombreElemento'}
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
                                                            sortInfo: {field: 'nombreElemento', direction: 'ASC'},
                                                            groupField: 'nombreElemento',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='3';
                                        proxy.baseParams.iR=idFecha;
                                        proxy.baseParams.tA=tA;
                                    }
                        )   
       
       
       
       var chkRow=new Ext.grid.CheckboxSelectionModel();
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:30}),
                                                            chkRow,
                                                            {
                                                                header:lblEtiqueta,
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'nombreElemento',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridCatalogo_'+tA,
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                sm:chkRow,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                height:350,
                                                                tbar:	[
                                                                            {
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:!esRegistroFormulario(),
                                                                                text:'Agregar '+lblEtiqueta,
                                                                                handler:function()
                                                                                        {
                                                                                            switch(tA)
                                                                                            {
                                                                                                case 1:
                                                                                                    mostrarVentanaAgregarDistrito(idFecha)
                                                                                                break;
                                                                                                case 2:
                                                                                                	mostrarVentanaAgregarCircuito(idFecha)
                                                                                                   
                                                                                                break;
                                                                                                case 3:
                                                                                                    mostrarVentanaAgregarMunicipio(idFecha)
                                                                                                break;
                                                                                                case 4:
                                                                                                   mostrarVentanaAgregarDespacho(idFecha);
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:!esRegistroFormulario(),
                                                                                text:'Remover '+lblEtiqueta,
                                                                                handler:function()
                                                                                        {
                                                                                        	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                            
                                                                                            if(filas.length==0)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar almenos un elemento a remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	tblGrid.getStore().remove(filas);
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover los elementos seleccionados?',resp);
                                                                                        }
                                                                                
                                                                            }
                                                                            
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

function mostrarVentanaAgregarDistrito(idFecha)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione los distritos que desea agregar al &aacute;mbito de aplicaci&oacute;n:'
                                                        },
                                                        crearGridDistritosAdd(idFecha)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Distrito',
										width: 570,
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
                                                                    	var pos;
                                                                        var r;
                                                                        var registro=crearRegistro	(		
                                                                                                        [
                                                                                                            {name:'cveElemento'},
                                                                                                            {name: 'nombreElemento'}
                                                                                                        ]
                                                                                                    );
																		var filas=gEx('gridCatalogoAddDistrito').getSelectionModel().getSelections();
                                                                        var x;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	pos=obtenerPosFila(gEx('gridCatalogo_1').getStore(),'cveElemento',filas[x].data.cveDistrito);
                                                                            if(pos==-1)
                                                                            {
                                                                            	r=new registro	(
                                                                                					{
                                                                                                    	cveElemento:filas[x].data.cveDistrito,
                                                                                                        nombreElemento:filas[x].data.nombreDistrito
                                                                                                    }
                                                                                				)
                                                                            
                                                                            	gEx('gridCatalogo_1').getStore().add(r);	
                                                                            }
                                                                            
                                                                        }
                                                                        
                                                                        ventanaAM.close();
                                                                        	
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}


function crearGridDistritosAdd(idFecha)
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'cveDistrito'},
		                                                {name: 'nombreDistrito'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreDistrito', direction: 'ASC'},
                                                            groupField: 'nombreDistrito',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='27';
                                        proxy.baseParams.iR=idFecha;
                                        
                                    }
                        )   
       var chkRow=new Ext.grid.CheckboxSelectionModel();
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            chkRow,
                                                            {
                                                                header:'Distrito',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'nombreDistrito',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridCatalogoAddDistrito',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                height:350,
                                                                sm:chkRow,
                                                                width:525,
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

function mostrarVentanaAgregarCircuito(idFecha)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione los circuitos que desea agregar al &aacute;mbito de aplicaci&oacute;n:'
                                                        },
                                                        crearGridCircuitosAdd(idFecha)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Circuito',
										width: 570,
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
                                                                    	var pos;
                                                                        var r;
                                                                        var registro=crearRegistro	(		
                                                                                                        [
                                                                                                            {name:'cveElemento'},
                                                                                                            {name: 'nombreElemento'}
                                                                                                        ]
                                                                                                    );
																		var filas=gEx('gridCatalogoAddCircuito').getSelectionModel().getSelections();
                                                                        var x;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	pos=obtenerPosFila(gEx('gridCatalogo_2').getStore(),'cveElemento',filas[x].data.cveCircuito);
                                                                            if(pos==-1)
                                                                            {
                                                                            	r=new registro	(
                                                                                					{
                                                                                                    	cveElemento:filas[x].data.cveCircuito,
                                                                                                        nombreElemento:filas[x].data.nombreCircuito
                                                                                                    }
                                                                                				)
                                                                            
                                                                            	gEx('gridCatalogo_2').getStore().add(r);	
                                                                            }
                                                                            
                                                                        }
                                                                        
                                                                        ventanaAM.close();
                                                                        	
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}


function crearGridCircuitosAdd(idFecha)
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'cveCircuito'},
		                                                {name: 'nombreCircuito'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreCircuito', direction: 'ASC'},
                                                            groupField: 'nombreCircuito',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='28';
                                        proxy.baseParams.iR=idFecha;
                                        
                                    }
                        )   
       var chkRow=new Ext.grid.CheckboxSelectionModel();
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            chkRow,
                                                            {
                                                                header:'Circuito',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'nombreCircuito',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridCatalogoAddCircuito',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                height:350,
                                                                sm:chkRow,
                                                                width:525,
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


function mostrarVentanaAgregarMunicipio(idFecha)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione los municipio que desea agregar al &aacute;mbito de aplicaci&oacute;n:'
                                                        },
                                                        crearGridMunicipioAdd(idFecha)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Municipio',
										width: 570,
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
                                                                    	var pos;
                                                                        var r;
                                                                        var registro=crearRegistro	(		
                                                                                                        [
                                                                                                            {name:'cveElemento'},
                                                                                                            {name: 'nombreElemento'}
                                                                                                        ]
                                                                                                    );
																		var filas=gEx('gridCatalogoAddMunicipio').getSelectionModel().getSelections();
                                                                        var x;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	pos=obtenerPosFila(gEx('gridCatalogo_3').getStore(),'cveElemento',filas[x].data.cveMunicipio);
                                                                            if(pos==-1)
                                                                            {
                                                                            	r=new registro	(
                                                                                					{
                                                                                                    	cveElemento:filas[x].data.cveMunicipio,
                                                                                                        nombreElemento:filas[x].data.nombreMunicipio
                                                                                                    }
                                                                                				)
                                                                            
                                                                            	gEx('gridCatalogo_3').getStore().add(r);	
                                                                            }
                                                                            
                                                                        }
                                                                        
                                                                        ventanaAM.close();
                                                                        	
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}


function crearGridMunicipioAdd(idFecha)
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'cveMunicipio'},
		                                                {name: 'nombreMunicipio'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreMunicipio', direction: 'ASC'},
                                                            groupField: 'nombreMunicipio',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='29';
                                        proxy.baseParams.iR=idFecha;
                                        
                                    }
                        )   
       var chkRow=new Ext.grid.CheckboxSelectionModel();
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            chkRow,
                                                            {
                                                                header:'Municipio',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'nombreMunicipio',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridCatalogoAddMunicipio',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                height:350,
                                                                sm:chkRow,
                                                                width:525,
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


function mostrarVentanaAgregarDespacho(idFecha)
{
	var claveUnidad;
    var oConf=	{
    					idCombo:'cmbDespacho',
                        anchoCombo:400,
                        posX:160,
                        posY:5,
                        raiz:'registros',
                        campoDesplegar:'nombreUnidad',
                        campoID:'claveUnidad',
                        funcionBusqueda:30,
                        paginaProcesamiento:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',
                        confVista:'<tpl for="."><div class="search-item">{nombreUnidad}<br></div></tpl>',
                        campos:	[
                                   	{name:'claveUnidad'},
                                    {name:'nombreUnidad'}

                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	claveUnidad='';
                                    	var aValor=combo.getRawValue();
										dSet.baseParams.criterio=aValor;
                                        dSet.baseParams.iR=idFecha;
                                        
                                                                              
                                        
                                    },
                      	funcElementoSel:function(combo,registro)
                    				{
                                    	claveUnidad=registro.data.claveUnidad;
                                        
                                    }  
    				};

	var cmbDespacho=crearComboExtAutocompletar(oConf);
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Despacho que agregar:'
                                                        },
                                                        cmbDespacho
                                                        
                                                       
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Municipio',
										width: 650,
										height:130,
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
                                                                    	var pos;
                                                                        var r;
                                                                        var registro=crearRegistro	(		
                                                                                                        [
                                                                                                            {name:'cveElemento'},
                                                                                                            {name: 'nombreElemento'}
                                                                                                        ]
                                                                                                    );
																		
                                                                        var x;
                                                                        pos=obtenerPosFila(gEx('gridCatalogo_4').getStore(),'cveElemento',claveUnidad);
                                                                        if(pos==-1)
                                                                        {
                                                                            r=new registro	(
                                                                                                {
                                                                                                    cveElemento:claveUnidad,
                                                                                                    nombreElemento:gEx('cmbDespacho').getRawValue()
                                                                                                }
                                                                                            )
                                                                        
                                                                            gEx('gridCatalogo_4').getStore().add(r);	
                                                                        }
                                                                        
                                                                        ventanaAM.close();
                                                                        	
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}



function validarAmbitoAplicacion()
{
	var arrDistritos='';
                                                                        
    var o='';
    var fila;
    var gridCatalogo=gEx('gridCatalogo_1');
    var x;
    
    for(x=0;x<gridCatalogo.getStore().getCount();x++)
    {
        fila=gridCatalogo.getStore().getAt(x);
        o='{"cveElemento":"'+fila.data.cveElemento+'"}';
        if(arrDistritos=='')
            arrDistritos=o;
        else
            arrDistritos+=','+o;
    }
    
    
    var arrCircuitos='';
    
    o='';
    
    gridCatalogo=gEx('gridCatalogo_2');
    for(x=0;x<gridCatalogo.getStore().getCount();x++)
    {
        fila=gridCatalogo.getStore().getAt(x);
        o='{"cveElemento":"'+fila.data.cveElemento+'"}';
        if(arrCircuitos=='')
            arrCircuitos=o;
        else
            arrCircuitos+=','+o;
    }
    
    
    var arrMunicipios='';
    
     o='';
    
    gridCatalogo=gEx('gridCatalogo_3');
    for(x=0;x<gridCatalogo.getStore().getCount();x++)
    {
        fila=gridCatalogo.getStore().getAt(x);
        o='{"cveElemento":"'+fila.data.cveElemento+'"}';
        if(arrMunicipios=='')
            arrMunicipios=o;
        else
            arrMunicipios+=','+o;
    }
    
    var arrDespachos='';
    
    
    gridCatalogo=gEx('gridCatalogo_4');
    for(x=0;x<gridCatalogo.getStore().getCount();x++)
    {
        fila=gridCatalogo.getStore().getAt(x);
        o='{"cveElemento":"'+fila.data.cveElemento+'"}';
        if(arrDespachos=='')
            arrDespachos=o;
        else
            arrDespachos+=','+o;
    }
    
    
     var cadObj='{"arrDistritos":['+arrDistritos+'],"arrCircuitos":['+arrCircuitos+'],"arrMunicipios":['+arrMunicipios+
                 '],"arrDespachos":['+arrDespachos+']}';
    
    
    var id=<?php echo $idRegistro?>;
	if(id=='-1')
    {
        gE('funcPHPEjecutarNuevo').value=bE('asociarAmbitoAplicacionPlantilla(@idRegPadre,\''+bE(cadObj)+'\')');
    }
    else
    {
        gE('funcPHPEjecutarModif').value=bE('asociarAmbitoAplicacionPlantilla('+id+',\''+bE(cadObj)+'\')');
    }
    
    
    return true;
    
    
}