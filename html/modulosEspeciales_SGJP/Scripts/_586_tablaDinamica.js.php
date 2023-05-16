<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	

?>	

function inyeccionCodigo()
{
	var grid_9561=gEx('grid_9561');
    var btnAdd=gEx('btnAdd_grid_9561');
    
    if(esRegistroFormulario())
    {
      
    	  btnAdd.setHandler(
          						function()
                                {
                                	agregarEmailDestinatario();
                                }	
    						)
    
    }
  

}	


function agregarEmailDestinatario()
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
                                                            html:'Seleccione los destinatarios que desea agregar:'
                                                        },
                                                        crearGridestinatario()
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Destinatario',
										width: 650,
										height:400,
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
																		var grid_9561=gEx('grid_9561');
																		var gMails=gEx('gMails');
                                                                        var filas=gMails.getSelectionModel().getSelections();
                                                                        
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe sleccionar almenos un destinatario a agregar');
                                                                        	return;
                                                                        }
                                                                        var x; 
                                                                        var f;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	f=filas[x];
                                                                            if(obtenerPosFila(grid_9561.getStore(),'email',f.data.email)==-1)
                                                                            {
                                                                            	grid_9561.getStore().add(f);
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

function crearGridestinatario()
{
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idRegistro'},
                                                        {name: 'idReferencia'},
                                                        {name:'nombre', type:'string'},
                                                        {name:'email', type:'string'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php'

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
                                    	proxy.baseParams.funcion='10';
                                        proxy.baseParams.idRegistro=gE('idRegistroG').value;
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        chkRow,
                                                        
                                                        {
                                                            header:'Nombre destinatario',
                                                            width:220,
                                                            sortable:true,
                                                            dataIndex:'nombre'
                                                        },
                                                        {
                                                            header:'Remover destinatario',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'email'
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gMails',
                                                            store:alDatos,
                                                            x:10,
                                                            y:40,
                                                            width:600,
                                                            height:250,
                                                            frame:false,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Registrar destinatario',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarDestinatario()
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover destinatario',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gMails').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el destinatario que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        function respAux(btn)
                                                                                        {
                                                                                            if(btn=='yes')
                                                                                            {
                                                                                                function funcAjax()
                                                                                                {
                                                                                                    var resp=peticion_http.responseText;
                                                                                                    arrResp=resp.split('|');
                                                                                                    if(arrResp[0]=='1')
                                                                                                    {
                                                                                                        gEx('gMails').getStore().reload();
                                                                                                        ventanaAM.close();
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php',funcAjax, 'POST','funcion=12&m='+fila.data.email,true);
                                                                                    		}
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el destinatario seleccionado?',respAux);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		],
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


function  mostrarVentanaAgregarDestinatario()
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
                                                            html:'Nombre del destinatario:'
                                                        },
                                                        {
                                                        	x:190,
                                                            y:5,
                                                            xtype:'textfield',
                                                            width:300,
                                                            id:'txtNombreDestinatario'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Direcci&oacute;n de correo electr&oacute;nico:'
                                                        },
                                                        {
                                                        	x:190,
                                                            y:35,
                                                            xtype:'textfield',
                                                            width:300,
                                                            id:'txtEmail'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Destinatario',
										width: 550,
										height:150,
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
                                                                	gEx('txtNombreDestinatario').focus(false,500);
                                                                    
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var  txtNombreDestinatario=gEx('txtNombreDestinatario');
                                                                        var  txtEmail=gEx('txtEmail');
                                                                        
                                                                        if(txtNombreDestinatario.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtNombreDestinatario.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el nombre del destinatario',resp1);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(txtEmail.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	txtEmail.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la direcci&oacute;n de correo electr&oacute;nico',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        if(!validarCorreo(txtEmail.getValue()))
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	txtEmail.focus();
                                                                            }
                                                                            msgBox('La direcci&oacute;n de correo electr&oacute;nico ingresada NO es v&aacute;lida',resp3);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('gMails').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php',funcAjax, 'POST','funcion=11&d='+
                                                                        txtNombreDestinatario.getValue()+'&m='+txtEmail.getValue(),true);
                                                                        
                                                                        
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