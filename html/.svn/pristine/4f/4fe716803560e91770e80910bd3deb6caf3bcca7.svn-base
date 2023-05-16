<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT idFormato,formatoImportacion FROM 721_formatosImportacion";
	$arrFormatosImportacion=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT idCelda,celda FROM 1019_catalogoCeldasExcel ORDER BY idCelda";
	$arrCeldas=$con->obtenerFilasArreglo($consulta);
?>

var arrSoloCeldas=<?php echo $arrCeldas?>;
var arrCeldas=<?php echo $arrCeldas?>;
var arrFormatosImportacion=<?php echo $arrFormatosImportacion?>;

var arrTipoCalculos=[['0','C\xE1lculo auxiliar','666'],['1','Deducci\xF3n','900'],['2','Percepci\xF3n','030']]

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
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Administraci&oacute;n de perfiles de importaci&oacute;n</b></span>',
                                               
                                                items:	[
                                                         	{
                                                            	xtype:'panel',
                                                                width:300,
                                                                border:false,
                                                                layout:'border',
                                                                region:'west',
                                                                items:	[
                                                                			crearGridPerfilesImportacion()
                                                                		]
                                                            },
                                                            {
                                                            	border:false,
                                                                layout:'border',
                                                            	xtype:'panel',
                                                                width:300,
                                                                title:'<span>Configuraci&oacute;n del perfil:</span> <b><span style="color:#000" id="lblPerfil"></span></b>',
                                                                region:'center',
                                                                items:	[
                                                                			crearGridConfiguracionPerfilImportacion()
                                                                		]
                                                            }
                                                         
                                                            
                                                        ]
                                            }
                                         ]
                            }
                        )   
}

function crearGridPerfilesImportacion()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idPerfilImportacion'},
		                                                {name: 'nombrePerfil'},
		                                                {name:'tipoArchivo'},
                                                        {name:'descripcion'},
                                                        {name:'columnaEmpleado'},
                                                        {name:'considerarSoloEmpleadosImportados'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesEspecialesNomina.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombrePerfil', direction: 'ASC'},
                                                            groupField: 'nombrePerfil',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='49';
                                        proxy.baseParams.idPerfil=gE('idPerfil').value;
                                        gEx('cmbCeldaEmpleado').disable();
                                        gEx('cmbCeldaEmpleado').setValue('');
                                        gEx('cmbSiNo').disable();
                                        gEx('cmbSiNo').setValue('');
                                        
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            
                                                            {
                                                                header:'Nombre de perfil',
                                                                width:240,
                                                                sortable:true,
                                                                dataIndex:'nombrePerfil',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return mostrarValorDescripcion(val+' ('+formatearValorRenderer(arrFormatosImportacion,registro.data.tipoArchivo)+')'+(registro.data.descripcion!=''?', '+registro.data.descripcion:''))
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridPerfilesImportacion',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,     
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                height:40,
                                                                                cls:'btnDobleLinea',
                                                                                text:'Agregar perfil <br />de importaci&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaAgregarPerfilImportacion();
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                height:40,
                                                                                cls:'btnDobleLinea',
                                                                                text:'Remover perfil <br />de importaci&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el perfil que desea remover');
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
                                                                                                            gEx('gridPerfilesImportacion').getStore().remove(fila);
                                                                                                            gEx('gridConfiguracionPerfilImportacion').getStore().reload();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=50&idPerfil='+fila.data.idPerfilImportacion,true);

                                                                                                
                                                                                                
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover el perfil seleccionado?',resp);
                                                                                            
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
                                                        
                                                        
	tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
    						{
                            	gEx('gridConfiguracionPerfilImportacion').getStore().reload();
                                
                                gEx('cmbCeldaEmpleado').setValue(registro.data.columnaEmpleado);
                                gEx('cmbCeldaEmpleado').enable();
                                gEx('cmbSiNo').setValue(registro.data.considerarSoloEmpleadosImportados);
                                gEx('cmbSiNo').enable();
                                
                            }
    		)                                                        
                                                        
        return 	tblGrid;	
}

function crearGridConfiguracionPerfilImportacion()
{
	arrCeldas.splice(0,0,['','Ninguna']);
	var cmbCelda=crearComboExt('cmbCelda',arrCeldas);
    
    var cmbCeldaEmpleado=crearComboExt('cmbCeldaEmpleado',arrSoloCeldas,0,0,110);
    cmbCeldaEmpleado.disable();
    
    cmbCeldaEmpleado.on('select',function(cmb,registro)
    							{
                                	var gridPerfilesImportacion=gEx('gridPerfilesImportacion');
                                    var fila=gridPerfilesImportacion.getSelectionModel().getSelected();
                                   	idPerfilImportacion=fila.data.idPerfilImportacion;
                                            
                                    function funcAjax()
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                            fila.set('columnaEmpleado',registro.data.id);
                                        }
                                        else
                                        {
                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                        }
                                    }
                                    obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=53&idPerfilImportacion='+idPerfilImportacion+'&tipoAccion=1&valor='+registro.data.id,true);
                                    
                                    
                                    
                                }
    					)
    
    
    var cmbSiNo=crearComboExt('cmbSiNo',[['1','S\xED'],['0','No']],0,0,110);
    cmbSiNo.on('select',function(cmb,registro)
    							{
                                	var gridPerfilesImportacion=gEx('gridPerfilesImportacion');
                                    var fila=gridPerfilesImportacion.getSelectionModel().getSelected();
                                   	idPerfilImportacion=fila.data.idPerfilImportacion;
                                            
                                    function funcAjax()
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                            fila.set('considerarSoloEmpleadosImportados',registro.data.id);
                                        }
                                        else
                                        {
                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                        }
                                    }
                                    obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=53&idPerfilImportacion='+idPerfilImportacion+'&tipoAccion=2&valor='+registro.data.id,true);
                                    
                                    
                                    
                                }
    					)
    
    
    cmbSiNo.disable();
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			 {name:'orden', type:'int'},
                                                         {name:'tipoCalculo'},
                                                         {name:'idCalculo'},
                                                         {name:'nombreConsulta'},
                                                         {name: 'etiquetaConcepto'},
                                                         {name: 'idColumna'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesEspecialesNomina.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'orden', direction: 'ASC'},
                                                            groupField: 'orden',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	var idPerfilImportacion=-1;
                                        var gridPerfilesImportacion=gEx('gridPerfilesImportacion');
                                        var fila=gridPerfilesImportacion.getSelectionModel().getSelected();
                                        if(fila)
                                        	idPerfilImportacion=fila.data.idPerfilImportacion;
                                            
                                        if(idPerfilImportacion==-1)    
                                        	gE('lblPerfil').innerHTML='[Ninguno]';
                                        else
                                        	gE('lblPerfil').innerHTML=fila.data.nombrePerfil;
                                            
                                    	proxy.baseParams.funcion='51';
                                        proxy.baseParams.idPerfilImportacion=idPerfilImportacion;
                                        proxy.baseParams.idPerfil=gE('idPerfil').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                           new  Ext.grid.RowNumberer(),
                                                            
                                                            {
                                                                header:'&Oacute;rden de <br>ejecuci&oacute;n',
                                                                width:80,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'orden'
                                                            },
                                                            {
                                                                header:'Tipo  de c&aacute;lculo',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'tipoCalculo',
                                                                renderer:function (val)
                                                                		{
                                                                        	var pos=existeValorMatriz(arrTipoCalculos,val);
                                                                            if(pos==-1)
                                                                                return '';
                                                                            else
                                                                                return '<b><span style="color:#'+arrTipoCalculos[pos][2]+'">'+arrTipoCalculos[pos][1]+'</span></b>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Descripci&oacute;n del c&aacute;lculo',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'etiquetaConcepto',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(val==registro.data.nombreConsulta)
	                                                                        	return '<span style="color:#006"><b>'+mostrarValorDescripcion(val)+'</b></span>';
                                                                            else
                                                                            {
                                                                            	return '<span title="'+val+' [C&aacute;lculo: '+registro.data.nombreConsulta+']" alt="'+val+' [C&aacute;lculo: '+registro.data.nombreConsulta+']"><span style="color:#006"><b>'+val+'</b></span> <span style="color:#777">[<b>C&aacute;lculo:</b> '+registro.data.nombreConsulta+']</span></span>';
                                                                            }
                                                                            
                                                                                
                                                                        }
                                                            },
                                                            {
                                                                header:'Columna asociada',
                                                                width:130,
                                                                sortable:true,
                                                                editor:cmbCelda,
                                                                dataIndex:'idColumna',
                                                                renderer:function (val)
                                                                		{
                                                                        	return formatearValorRenderer(arrCeldas,val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gridConfiguracionPerfilImportacion',
                                                                store:alDatos,
                                                                clicksToEdit:1,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,  
                                                                tbar:	[
                                                                			{
                                                                            	xtype:'label',
                                                                                html:'<span style="color:#000">Columna ID de Empleado:</span>&nbsp;&nbsp;'
                                                                            },cmbCeldaEmpleado
                                                                            
                                                                            ,'-',
                                                                            {
                                                                            	xtype:'label',
                                                                                html:'<span style="color:#000">S&oacute;lo procesar empleados importados:</span>&nbsp;&nbsp;'
                                                                            },
                                                                            cmbSiNo
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
                                                        
                                                        
		tblGrid.on('afteredit',function(e)
        						{
                                	var gridPerfilesImportacion=gEx('gridPerfilesImportacion');
                                    var fila=gridPerfilesImportacion.getSelectionModel().getSelected();
                                	function funcAjax()
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                            
                                        }
                                        else
                                        {
                                        	function respErr()
                                            {
                                            	e.record.set(e.field,e.originalValue);
                                            }
                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0],respErr);
                                        }
                                    }
                                    obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=52&idPerfilImportacion='+fila.data.idPerfilImportacion+'&idCalculo='+e.record.data.idCalculo+'&idColumna='+e.value,true);
                                    
                                }
        			)                                                        
                                                        
        return 	tblGrid;
}

function mostrarVentanaAgregarPerfilImportacion()
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
                                                            html:'Seleccione los perfiles de importaci&oacute;n que desea agregar:'
                                                        },
                                                        crearGridPerfilesImportacionDisponibles()	

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar perfil de importaci&oacute;n',
										width: 700,
										height:350,
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
																		var gPerfilesImpDisponibles=gEx('gPerfilesImpDisponibles');
                                                                        
                                                                        var listaPerfiles='';
                                                                        var x;
                                                                        var f;
                                                                        var arrFilas=gPerfilesImpDisponibles.getSelectionModel().getSelections();
                                                                        if(arrFilas.length==0)
                                                                        {
                                                                        	
                                                                            msgBox('Debe selecionar almenos un perfil a agregar');
                                                                            return;
                                                                        }
                                                                        for(x=0;x<arrFilas.length;x++)
                                                                        {
                                                                        	f=arrFilas[x];
                                                                            
                                                                            if(listaPerfiles=='')
                                                                            	listaPerfiles=f.data.idPerfil;
                                                                            else
                                                                            	listaPerfiles+=','+f.data.idPerfil;
                                                                            
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gridPerfilesImportacion').getStore().reload();
                                                                                gEx('gridConfiguracionPerfilImportacion').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=48&idPerfilNomina='+gE('idPerfil').value+'&listaPerfiles='+listaPerfiles,true);
                                                                        
                                                                        
                                                                        
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

function crearGridPerfilesImportacionDisponibles()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idPerfil'},
		                                                {name: 'nombrePerfil'},
		                                                {name:'descripcion'},
		                                                {name:'formatoImportacion'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesEspecialesNomina.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombrePerfil', direction: 'ASC'},
                                                            groupField: 'nombrePerfil',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='47';
                                        proxy.baseParams.idPerfilNomina=gE('idPerfil').value;
                                    }
                        )   
  
  
  var chkRow=new Ext.grid.CheckboxSelectionModel();
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            chkRow,
                                                            {
                                                                header:'Nombre del perfil',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'nombrePerfil',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Descripci&oacute;n',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'descripcion',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Formato de importaci&oacute;n',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'formatoImportacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrFormatosImportacion,val);
                                                                        
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gPerfilesImpDisponibles',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                y:40,
                                                                sm:chkRow,
                                                                height:230,
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