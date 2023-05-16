<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

Ext.onReady(inicializar);

function inicializar()
{
	var gridEncargado=crearGridEncargado();
    var gridEncargado=crearGridRevisorDepto();
    var gridEncargadoSegunda=crearGridRevisorSegunda();
	var tabPanel=new Ext.TabPanel(	{
    					
                                        renderTo:'spPanel',
                                        width:800,
                                        hight:450,
                                        activeTab: 0,
                                        items:	[
                                                    {
                                                    	title:'1.- Configuraci&oacute;n general',
                                                        contentEl:'tbl1',
                                                        height:440
                                                    },
                                                    {
                                                    	title:'2.- Responsable de registro',
                                                        contentEl:'tbl2',
                                                        height:440
                                                    
                                                    },
                                                    {
                                                    	title:'3.- Responsable de validaci&oacute;n por depto',
                                                        contentEl:'tbl3',
                                                        height:440
                                                    },
                                                    {
                                                    	title:'4.- Responsable de validaci&oacute;n segunda fase',
                                                        contentEl:'tbl4',
                                                        height:440
                                                    }
                                                    
                                                ]
                                    }
                                 )
	var arrCapitulos=eval(bD(gE('arrCapitulos').value));
	var dsDatos=arrCapitulos;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'capitulo'},
                                                                    {name: 'nombreCapitulo'}
                                                                ]
                                                    }
                                                );
    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Cap&iacute;tulo',
															width:300,
															sortable:true,
															dataIndex:'nombreCapitulo'
														}													
                                                  ]
												);
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                        	id:'gridCapitulos',
                                                            renderTo:'tblCapitulos',
                                                            store:alDatos,
                                                            frame:true,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:390,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar cap&iacute;tulo',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarCapitulo();
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover cap&iacute;tulo',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                        var idProceso=gE('idProceso').value;
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar al menos un cap&iacute;tulo a remover');
                                                                                            return;
                                                                                        }
                                                                                        
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                                var cadCapitulos=obtenerListadoArregloFilas(filas,'capitulo');
                                                                                                function funcAjax()
                                                                                                {
                                                                                                    var resp=peticion_http.responseText;
                                                                                                    arrResp=resp.split('|');
                                                                                                    if(arrResp[0]=='1')
                                                                                                    {
                                                                                                        tblGrid.getStore().remove(filas);
                                                                                                    }
                                                                                                       
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=226&idProceso='+idProceso+'&cadCapitulos='+cadCapitulos,true);
                                                                                    		}
                                                                                    	}
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el cap&iacute;tulo seleccionado?',resp);
                                                                                        
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	                                                    
}


function crearGridEncargado()
{
	var arrGridEncargado=eval(bD(gE('arrGridEncargado').value));
	var dsDatos=arrGridEncargado;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'rol'},
                                                                    {name: 'nombreRol'}
                                                                ]
                                                    }
                                                );
    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Rol',
															width:250,
															sortable:true,
															dataIndex:'nombreRol'
														}
                                                   ]
												);
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridRolesReg',
                                                            store:alDatos,
                                                            frame:true,
                                                            renderTo:'tblRolesReg',
                                                            cm: cModelo,
                                                            height:260,
                                                            width:350,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar responsable',
                                                                            handler:function()
                                                                            		{
                                                                                    	agregarRolModulo(tblGrid,1);
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover responsable',
                                                                            handler:function()
                                                                            		{
                                                                                    	var idProceso=gE('idProceso').value;
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el rol que desea remover');
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
                                                                                                        tblGrid.getStore().remove(fila);
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=227&idProceso='+idProceso+'&tActor=1&rol='+fila.get('rol')+'&tipoEliminacion=1',true);
                                                                                                
                                                                                            
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el rol seleccionado?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
}

var registroRol=crearRegistro([
                                  {name: 'rol'},
                                  {name: 'nombreRol'}
                              ]);

function crearGridRevisorDepto()
{
	var arrGridRevisor=eval(bD(gE('arrGridRevisor').value));
	var dsDatos=arrGridRevisor;
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'rol'},
                                                                {name: 'nombreRol'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Rol',
															width:250,
															sortable:true,
															dataIndex:'nombreRol'
														}
                                                   ]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridRolesValJefe',
                                                            store:alDatos,
                                                            frame:true,
                                                            renderTo:'tblRolesValJefe',
                                                            cm: cModelo,
                                                            height:260,
                                                            width:350,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar responsable',
                                                                            handler:function()
                                                                            		{
                                                                                    	agregarRolModulo(tblGrid,2);
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover responsable',
                                                                            handler:function()
                                                                            		{
                                                                                    	var idProceso=gE('idProceso').value;
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el rol que desea remover');
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
                                                                                                        tblGrid.getStore().remove(fila);
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=227&idProceso='+idProceso+'&tActor=1&rol='+fila.get('rol')+'&tipoEliminacion=2',true);
                                                                                                
                                                                                            
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el rol seleccionado?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
}

function crearGridRevisorSegunda()
{
	var arrGridRevisor=eval(bD(gE('arrGridRevisor').value));
	var dsDatos=arrGridRevisor;
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'rol'},
                                                                {name: 'nombreRol'},
                                                                {name: 'tipoActor'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Actor',
															width:250,
															sortable:true,
															dataIndex:'nombreRol'
														},
                                                        {
															header:'Tipo actor',
															width:150,
															sortable:true,
															dataIndex:'tipoActor'
														}
                                                   ]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridRolesValSegunda',
                                                            store:alDatos,
                                                            frame:true,
                                                            renderTo:'tblRolesValPlan',
                                                            cm: cModelo,
                                                            height:260,
                                                            width:500,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar responsable',
                                                                            handler:function()
                                                                            		{
                                                                                    	agregarRolModulo(tblGrid,2);
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover responsable',
                                                                            handler:function()
                                                                            		{
                                                                                    	var idProceso=gE('idProceso').value;
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el rol que desea remover');
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
                                                                                                        tblGrid.getStore().remove(fila);
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=227&idProceso='+idProceso+'&tActor=1&rol='+fila.get('rol')+'&tipoEliminacion=2',true);
                                                                                                
                                                                                            
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el rol seleccionado?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
}

function actualizarRequisicion(combo)
{
	var tipoReq=combo.options[combo.selectedIndex].value;
    var idProceso=gE('idProceso').value;
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=223&idProceso='+idProceso+'&tipoReq='+tipoReq,true);
}

function mostrarVentanaAgregarCapitulo()
{
	var gridCapitulos=crearGridCapitulos();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione los cap&iacute;tulos que desea utlizar en el proceso:'
                                                        },
                                                        gridCapitulos
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar cap&iacute;tulo',
										width: 620,
										height:385,
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
                                                                    	var idProceso=gE('idProceso').value;
																		var filas=gridCapitulos.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar al menos un cap&iacute;tulo para agregar');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var cadCapitulos=obtenerListadoArregloFilas(filas,'capitulo');
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var x;
                                                                                var gridCapitulos=gEx('gridCapitulos');
                                                                                for(x=0;x<filas.length;x++)
                                                                                {
                                                                                	gridCapitulos.getStore().add(filas[x]);
                                                                                    gridCapitulos.getStore().sort('capitulo');
                                                                               	}
                                                                                ventanaAM.close();
                                                                            }
                                                                               
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=225&idProceso='+idProceso+'&cadCapitulos='+cadCapitulos,true);

                                                                        
                                                                        
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
	obtenerPartidasDisponibles(ventanaAM,gridCapitulos.getStore());                                

}

function crearGridCapitulos()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'capitulo'},
                                                                    {name: 'nombreCapitulo'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Cap&iacute;tulo',
															width:500,
															sortable:true,
															dataIndex:'nombreCapitulo'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:590,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;
}

function obtenerPartidasDisponibles(ventana,almacen)
{
	var idProceso=gE('idProceso').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
			almacen.loadData(eval(arrResp[1]));            
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=224&idProceso='+idProceso,true);
}

function agregarRolModulo(griDestino,etapa)
{
	<?php
		$consulta="select concat(idRol,'_',extensionRol),nombreGrupo from 8001_roles where  idIdioma=".$_SESSION["leng"]." order by nombreGrupo";
		$arrRoles=uEJ($con->obtenerFilasArreglo($consulta));
	?>
    var arrRoles=<?php echo $arrRoles;?>;
    var idProceso=gE('idProceso').value;
    var cmbExtensiones=crearComboExt('cmbExtensiones',[],100,35,250);
	cmbExtensiones.hide();
	var cmbRoles=crearComboExt('cmbRoles',arrRoles,100,5,250);
    function rolSeleccionado(combo,registro,indice)
    {
    	cmbExtensiones.reset();
    	var idRegistro=registro.get('id');
        var arrId=idRegistro.split('_');
        if(arrId[1]!=0)
        {
        	function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
					var arrExtensiones=eval(arrResp[1]);
                    cmbExtensiones.getStore().loadData(arrExtensiones);     
                	cmbExtensiones.show();
		            Ext.getCmp('lblExtension').show();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=20&noTodos=true&extension='+arrId[1],true);
        
        	
        }
        else
        {
        	cmbExtensiones.hide();
            Ext.getCmp('lblExtension').hide();
        }
        
    }
    
    cmbRoles.on('select',rolSeleccionado);
    
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											disabled:false,
											items:
													[
													 	{
                                                        	id:'lblRol',
                                                            x:10,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'Rol:'
                                                        },
                                                        cmbRoles,
                                                        {
                                                        	id:'lblExtension',
                                                        	x:10,
                                                            y:40,
                                                            xtype:'label',
                                                            html:'Extensi&oacute;n:',
                                                            hidden:true
                                                        },
                                                        cmbExtensiones
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar rol',
										width:380,
										height:150,
										layout:'fit',
										buttonAlign:'center',
										items:[form],
										modal:true,
										plain:true,
										listeners:
											{
												show:
												{
													buffer:10,fn:function()
															{
																
															}
												}
											},
										buttons:
												[
												 	{
														text:'Aceptar',
														handler:function ()
															{
                                                            	var rol=cmbRoles.getValue();
                                                                var arrId=rol.split('_');
                                                                var extension='0';
                                                                if(arrId[1]!=0)
                                                                	extension=cmbExtensiones.getValue();	
                                                                if(extension=='')
                                                                {
                                                                	function resp()
                                                                    {
                                                                    	cmbExtensiones.focus();
                                                                    }
                                                                	msgBox('Debe seleccionar una extensi&oacute;n del rol',resp);
                                                                    return;
                                                                }
                                                                var listRoles=gE('listRoles');
                                                                var codigoRol=arrId[0]+'_'+extension;
                                                                var rolExiste=existeRol(griDestino.getStore(),codigoRol);
                                                                
                                                                if(!rolExiste)
                                                                {
                                                                    var nExtension=cmbExtensiones.getValue();
                                                                    var txtExtension='';
                                                                    if(nExtension!='')
                                                                    {
                                                                    	txtExtension=' ('+cmbExtensiones.getRawValue()+')';
                                                                    }
                                                                    
                                                                    function funcAjax()
                                                                    {
                                                                        var resp=peticion_http.responseText;
                                                                        arrResp=resp.split('|');
                                                                        if(arrResp[0]=='1')
                                                                        {
                                                                        	var r=new registroRol	(	
                                                                                                        {
                                                                                                            rol:codigoRol,
                                                                                                            nombreRol:cmbRoles.getRawValue()+txtExtension
                                                                                                        }
                                                                                                    )
                                                                   			griDestino.getStore().add(r);
                                                                   			 ventana.close();
                                                                            
                                                                        }
                                                                        else
                                                                        {
                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                        }
                                                                    }
                                                                    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=228&idProceso='+idProceso+'&rol='+codigoRol+'&tActor=1&etapa='+etapa,true);
                                                                }
                                                                else
                                                                {
                                                                	msgBox('El rol seleccionado ya ha sido agregado previamente')
                                                                    return;
                                                                }
                                                                
                                                               
																
															}
													},
													{
														text:'Cancelar',
														handler:function ()
															{
																ventana.close();
															}
													}
												 ]
									}
							   )
	ventana.show();

}

function existeRol(almacen,valor)
{
    var x;
    var fila;
    for(x=0;x<almacen.getCount();x++)
    {
    	fila=almacen.getAt(x);
    	if(fila.get('rol')==valor)
        	return true;
    }
    return false;
}