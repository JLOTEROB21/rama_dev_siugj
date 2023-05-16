<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT id__992_tablaDinamica,nombreSala FROM _992_tablaDinamica";
	$arrSalas=$con->obtenerFilasArreglo($consulta);
	
	
	
?>

var arrSalas=<?php echo $arrSalas?>;
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
                                                items:	[
                                                            crearGridDemandasConsideradas()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}


function crearGridDemandasConsideradas()
{
	var cmbDespachoAsignado=crearComboExt('cmbDespachoAsignado',arrSalas,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid listComboSIUGJGridExpediente'});
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'folioRegistro'},
		                                                {name:'fechaRegistro',  type:'date', dateFormat:'Y-m-d H:i:s'},
		                                                {name:'demandante'},
                                                        {name: 'demandado'},
                                                        {name: 'normaInconstitucional'},
                                                        {name: 'despachoAsignado'},
                                                        {name: 'carpetaAdministrativa'}
                                                        
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloProgramaTrabajoAccionPublica.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'folioRegistro', direction: 'ASC'},
                                                            groupField: 'despachoAsignado',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='1';
                                        proxy.baseParams.idRegistro=gE('idRegistro').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:45}),
                                                            
                                                            {
                                                                header:'Folio de Registro',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'folioRegistro',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:abrirDemanda(\''+bE(registro.data.idRegistro)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de Recepci&oacute;n',
                                                                width:190,
                                                                sortable:true,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            {
                                                                header:'C&oacute;digo &Uacute;nico',
                                                                width:260,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val=='N/E')
                                                                            {
                                                                            	return 'POR ASIGNAR';
                                                                            }
                                                                            return val;
                                                                        }
                                                            },
                                                            {
                                                                header:'Demandante',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'demandante',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Demandado',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'demandado',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Despacho Asignado',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'despachoAsignado',
                                                                editor:cmbDespachoAsignado,
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val=='')
                                                                            	return 'SIN DESPACHO ASIGNADO';
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrSalas,val));
                                                                        }
                                                            },
                                                            {
                                                                header:'Norma Acusada como Inconstitucional',
                                                                width:500,
                                                                sortable:true,
                                                                dataIndex:'normaInconstitucional',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gDemandas',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                cls:'gridSiugjSeccion',
                                                                columnLines : true, 
                                                                tbar:	[
                                                                			{
                                                                                icon:'../principalPortal/imagesSIUGJ/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                height:50,
                                                                                hidden:gE('sL').value=='1',
                                                                                text:'Agregar Demanda',
                                                                                handler:function()
                                                                                        {
                                                                                    		mostrarVentanaAgregarDemandas();
                                                                                        
                                                                                        }
                                                                            
                                                                            },
                                                                            {
                                                                                icon:'../principalPortal/imagesSIUGJ/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                height:50,
                                                                                hidden:gE('sL').value=='1',
                                                                                id:'btnRemoveDemanda',
                                                                                text:'Remover Demanda',
                                                                                handler:function()
                                                                                        {
                                                                                    		var fila=gEx('gDemandas').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la demanda que desea remover del programa de trabajo');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	function funcAjax()
                                                                                                    {
                                                                                                        var resp=peticion_http.responseText;
                                                                                                        arrResp=resp.split('|');
                                                                                                        if(arrResp[0]=='1')
                                                                                                        {
                                                                                                            gEx('gDemandas').getStore().reload();
                                                                                                             if((window.parent)&&(window.parent.recargarMenuDTD))
                                                                                                            {
                                                                                                                window.parent.recargarMenuDTD();
                                                                                                            }
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloProgramaTrabajoAccionPublica.php',funcAjax, 'POST','funcion=4&iP='+gE('idRegistro').value+'&iR='+fila.data.idRegistro,true);

                                                                                                }
                                                                                            }
                                                                                            msgConfirm('¿Est&aacute; seguro de querer remover la demanda seleccionada?',resp);
                                                                                            
                                                                                    	}
                                                                            
                                                                            },
                                                                            {
                                                                                icon:'../principalPortal/imagesSIUGJ/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                height:50,
                                                                                hidden:gE('sL').value=='1',
                                                                                id:'btnRemoveDemanda',
                                                                                text:'Remover Demanda',
                                                                                handler:function()
                                                                                        {
                                                                                    		var fila=gEx('gDemandas').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la demanda que desea remover del programa de trabajo');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	function funcAjax()
                                                                                                    {
                                                                                                        var resp=peticion_http.responseText;
                                                                                                        arrResp=resp.split('|');
                                                                                                        if(arrResp[0]=='1')
                                                                                                        {
                                                                                                            gEx('gDemandas').getStore().reload();
                                                                                                             if((window.parent)&&(window.parent.recargarMenuDTD))
                                                                                                            {
                                                                                                                window.parent.recargarMenuDTD();
                                                                                                            }
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloProgramaTrabajoAccionPublica.php',funcAjax, 'POST','funcion=4&iP='+gE('idRegistro').value+'&iR='+fila.data.idRegistro,true);

                                                                                                }
                                                                                            }
                                                                                            msgConfirm('¿Est&aacute; seguro de querer remover la demanda seleccionada?',resp);
                                                                                            
                                                                                    	}
                                                                            
                                                                            },
                                                                            {
                                                                                icon:'../images/arrow_refresh.PNG',
                                                                                cls:'x-btn-text-icon',
                                                                                height:50,
                                                                                hidden:gE('sL').value=='1',
                                                                                id:'btnRepartirDemanda',
                                                                                text:'Repartir Demanda',
                                                                                handler:function()
                                                                                        {
                                                                                    		function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	var listaDemandas='';
                                                                                                    var x;
                                                                                                    var fila;
                                                                                                    for(x=0;x<gEx('gDemandas').getStore().getCount();x++)
                                                                                                    {
                                                                                                    	fila=gEx('gDemandas').getStore().getAt(x);
                                                                                                    	if(listaDemandas=='')
                                                                                                        	listaDemandas=fila.data.idRegistro;
                                                                                                       	else	
                                                                                                        	listaDemandas+=','+fila.data.idRegistro;
                                                                                                    }
                                                                                                
                                                                                                	function funcAjax()
                                                                                                    {
                                                                                                        var resp=peticion_http.responseText;
                                                                                                        arrResp=resp.split('|');
                                                                                                        if(arrResp[0]=='1')
                                                                                                        {
                                                                                                            gEx('gDemandas').getStore().reload();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloProgramaTrabajoAccionPublica.php',funcAjax, 'POST','funcion=5&iP='+gE('idRegistro').value+'&d='+listaDemandas,true);
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('¿Est&aacute; seguro de querer repartir las demandas?',resp);
                                                                                            
                                                                                    	}
                                                                            
                                                                            }
                                                                       ],                                                               
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
                                                        
		tblGrid.on('afteredit',function(e)
                                {
                                	function funcAjax()
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                            gEx('gDemandas').getStore().reload();
                                        }
                                        else
                                        {
                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                        }
                                    }
                                    obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloProgramaTrabajoAccionPublica.php',funcAjax, 'POST','funcion=6&iP='+gE('idRegistro').value+'&valor='+e.value+'&iR='+e.record.data.idRegistro,true);
                                }                                                        
				)                                                      
        return 	tblGrid;	
}






function mostrarVentanaAgregarDemandas()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridDemandasDisponibles()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Demandas Disponibles',
										width: 980,
										height:450,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
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
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
                                                            
															handler: function()
																	{
																		var filas=gEx('gDemandasDisponibles').getSelectionModel().getSelections();
                                                                        var x;
                                                                        var f;
                                                                        var listaDemandas='';
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	f=filas[x];
                                                                            
                                                                            if(listaDemandas=='')
                                                                            	listaDemandas=f.data.idRegistro;
                                                                            else
                                                                            	listaDemandas+=','+f.data.idRegistro;
                                                                        }	
                                                                        
                                                                        function resp(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                            	function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                    	gEx('gDemandas').getStore().reload();
                                                                                        if((window.parent)&&(window.parent.recargarMenuDTD))
                                                                                      	{
                                                                                          window.parent.recargarMenuDTD();
                                                                                      	}
                                                                                        ventanaAM.close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloProgramaTrabajoAccionPublica.php',funcAjax, 'POST','funcion=3&iP='+gE('idRegistro').value+'&l='+listaDemandas,true);
                                                                                
                                                                                
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer agregar al programa de trabajo las demandas selecionadas?',resp);
                                                                        
                                                                        
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
}

function crearGridDemandasDisponibles()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'folioRegistro'},
		                                                {name:'fechaRegistro',  type:'date', dateFormat:'Y-m-d H:i:s'},
		                                                {name:'demandante'},
                                                        {name: 'demandado'},
                                                        {name: 'normaInconstitucional'}
                                                        
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloProgramaTrabajoAccionPublica.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'folioRegistro', direction: 'ASC'},
                                                            groupField: 'folioRegistro',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='2';
                                        
                                    }
                        )   
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:45});       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:45}),
                                                            chkRow,
                                                            
                                                            {
                                                                header:'Folio de Registro',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'folioRegistro',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:abrirDemanda(\''+bE(registro.data.idRegistro)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de Recepci&oacute;n',
                                                                width:190,
                                                                sortable:true,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            {
                                                                header:'Demandante',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'demandante',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Demandado',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'demandado',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Norma Acusada como Inconstitucional',
                                                                width:500,
                                                                sortable:true,
                                                                dataIndex:'normaInconstitucional',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gDemandasDisponibles',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                cls:'gridSiugjSeccion',
                                                                columnLines : true, 
                                                                sm:chkRow,                                                           
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

function abrirDemanda(iR)
{
	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.modal=true;
    
    obj.params=[['idFormulario',1004],['idRegistro',bD(iR)],['idReferencia',-1],
            ['dComp',bE('auto')],['actor',bE(0)]];
    window.parent.abrirVentanaFancy(obj);
}
