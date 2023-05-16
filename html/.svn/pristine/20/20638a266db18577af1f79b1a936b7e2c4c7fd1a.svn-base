<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT id__416_tablaDinamica,nombrePuesto FROM _416_tablaDinamica ORDER BY nombrePuesto";
	$arrPuestos=$con->obtenerFilasArreglo($consulta);
	
?>

var nodoSel=null;
var arrPuestos=<?php echo $arrPuestos?>;

Ext.onReady(inicializar);

function inicializar()
{
	var raiz=new  Ext.tree.AsyncTreeNode	(
                                                      {
                                                          id:'-1',
                                                          text:'Raiz',
                                                          draggable:false,
                                                          expanded :true
                                                      }
                                              	)
                                        
		var cargadorArbol=new Ext.tree.TreeLoader(
                                                        {
                                                            baseParams:{
                                                                            funcion:'176',
                                                                            unidadGestion:gE('uG').value
                                                                        },
                                                            dataUrl:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                            uiProviders:	{
                                                                            	'col': Ext.ux.tree.ColumnNodeUI
                                                                        	}
                                                        }	


		                                         )		                                        
		
        
        cargadorArbol.on('beforeload',function()
        							{
                                    	//gEx('btnAddPuestoBase').disable();
                                        gEx('btnAddPuestoHijo').disable();
                                        gEx('btnDelPuesto').disable();
                                        gEx('btnAddEmpleado').disable();
                                        gEx('btnDelEmpleado').disable();
                                        nodoSel=null;
                                    }
        				)
		
        cargadorArbol.on('load',function(c,nodo)
        							{
                                    	
                                    	if(nodo.childNodes.length==0)
                                        {
                                        	gEx('btnAddPuestoBase').show();
                                            gEx('btnAddPuestoHijo').hide();
                                        }
                                        else
                                        {
                                        	gEx('btnAddPuestoBase').hide();
                                            gEx('btnAddPuestoHijo').show();
                                        }
                                    }
        				)
                                                
		var organigrama = new Ext.ux.tree.TreeGrid	(
                                                            {
                                                                id:'tOrganigrama',
                                                                height:500,
                                                                width:960,
                                                                useArrows:true,
                                                                autoScroll:false,
                                                                animate:true,
                                                                enableDD:true,
                                                                border:false,
                                                                containerScroll: true,
                                                                root:raiz,
                                                                enableSort:false,
                                                                loader: cargadorArbol,
                                                                rootVisible:false,                                                                
                                                                draggable:false,
                                                                columns:[
                                                                			
                                                                            {
                                                                                header:'Puesto',
                                                                                width:650,
                                                                                dataIndex:'puesto'
                                                                            },
                                                                            {
                                                                                header:'Usuario asignado',
                                                                                width:280,
                                                                                dataIndex:'nombreEmpleado'
                                                                            }
                                                                         ],
                                                                 listeners: 	{
                                                                                    'render': 	function(tp)
                                                                                    			{
                                                                                        			
                                                                                                 }
                                                                                    }

                                                               
                                                            }
                                                    );
                                                    
                                                    
	var panel=new Ext.Panel	(
        							{
                                    	id:'divPanel',
                                        renderTo:'tblOrganigrama',
                                        items:	[
                                                    organigrama
                                        		],
                                        tbar:	[
                                        			{
                                                    	id:'btnAddPuestoBase',
                                                        icon:'../images/add.png',
                                                        cls:'x-btn-text-icon',
                                                        text:'Agregar puesto',
                                                        handler:function()
                                                                {
                                                                    agregarPuesto();
                                                                }
                                                        
                                                    },'-',
                                        			 {
                                                     	id:'btnAddPuestoHijo',
                                                        icon:'../images/add.png',
                                                        cls:'x-btn-text-icon',
                                                        text:'Agregar puesto',
                                                        disabled:true,
                                                        handler:function()
                                                                {
                                                                    agregarPuesto();
                                                                }
                                                        
                                                    },'-',
                                                    {
                                                     	id:'btnDelPuesto',
                                                        icon:'../images/delete.png',
                                                        cls:'x-btn-text-icon',
                                                        text:'Remover puesto',
                                                        disabled:true,
                                                        handler:function()
                                                                {
                                                                    removerPuesto();
                                                                }
                                                        
                                                    },'-',
                                                    {
                                                    	id:'btnAddEmpleado',
                                                        icon:'../images/user_add.png',
                                                        cls:'x-btn-text-icon',
                                                        disabled:true,
                                                        text:'Asignar empleado',
                                                        handler:function()
                                                                {
                                                                    mostrarVentanaAsignarEmpleado();
                                                                }
                                                        
                                                    },'-',
                                                    {
                                                    	id:'btnDelEmpleado',
                                                        icon:'../images/user_remove.png',
                                                        cls:'x-btn-text-icon',
                                                        disabled:true,
                                                        text:'Registrar baja de empleado',
                                                        handler:function()
                                                                {
                                                                    mostrarVentanaBajaEmpleado();
                                                                }
                                                        
                                                    }
                                                ]
                                    }
        						)
        organigrama.on('click',nodoClick);                                                    
}


function nodoClick(nodo)
{
	
	nodoSel=nodo;
    /*var claveNivel=nodoSel.attributes.claveNivel;
    gE('sp_'+claveNivel).innerHTML='Prueba';*/
    gEx('btnAddPuestoBase').disable();
    gEx('btnAddPuestoHijo').enable();
    gEx('btnDelPuesto').enable();
    gEx('btnAddEmpleado').disable();
    gEx('btnDelEmpleado').disable();
    
    
    if(nodo.attributes.nombreEmpleado.indexOf('VACANTE')!=-1)
    {
    	gEx('btnAddEmpleado').enable();
    }
    else
    {
    	gEx('btnDelEmpleado').enable();
    }
    
    
    
    
}


function mostrarVentanaAsignarEmpleado()
{
	var arrEmpleados=eval(bD(gE('arrEmpleados').value));
	var cmbEmpleadoAsignar=crearComboExt('cmbEmpleadoAsignar',arrEmpleados,200,35,350);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'<b>Puesto:</b>&nbsp;&nbsp;&nbsp;&nbsp;<span id="lblPuesto" style="color:#900; font-weight:bold">'+nodoSel.attributes.puesto+'</span>'
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'<b>Empleado a asignar:</b>'
                                                        },
                                                        cmbEmpleadoAsignar,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'<b>Fecha de inicio de funciones:</b>'
                                                        },
                                                        {
                                                        	x:200,
                                                            y:65,
                                                            id:'dteFechaInicio',
                                                            xtype:'datefield',
                                                            value:'<?php echo date("Y-m-d")?>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'<b>Comentarios adicionales:</b>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            xtype:'textarea',
                                                            width:650,
                                                            height:80,
                                                            id:'txtComentariosAdicionales'
                                                        }
													]
										}
									);
                                    
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignar empleado',
										width: 700,
										height:300,
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
																		if(cmbEmpleadoAsignar.getValue()=='') 
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	cmbEmpleadoAsignar.focus();
                                                                            }
                                                                        	msgBox('Debe seleccionar el empleado a asignar',resp1);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        var cadObj='{"idPerfil":"'+nodoSel.attributes.idPerfil+'","puesto":"'+nodoSel.attributes.claveNivel+'","empleado":"'+
                                                                        			cmbEmpleadoAsignar.getValue()+'","fechaInicio":"'+gEx('dteFechaInicio').getValue().format('Y-m-d')+
                                                                                    '","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+'"}';
                                                                       
                                                                       	
                                                                       	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gE('sp_'+nodoSel.attributes.claveNivel).innerHTML='<span style="color:#030 !important; font-weight:bold">'+cmbEmpleadoAsignar.getRawValue()+'</span>';
                                                                           		ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=171&cadObj='+cadObj,true);
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

function mostrarVentanaBajaEmpleado()
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
                                                            html:'<b>Puesto:</b>'
                                                        },
                                                        {
                                                        	x:70,
                                                            y:10,
                                                            html:'<span id="lblPuesto" style="color:#900; font-weight:bold">'+nodoSel.attributes.puesto+'</span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'<b>Empleado a dar de baja:</b>'
                                                        },
                                                        {
                                                        	x:200,
                                                            y:40,
                                                            html:'<span id="lblPuesto" style="color:#900; font-weight:bold">'+nodoSel.attributes.nombreEmpleado+'</span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'<b>Fecha de fin de funciones:</b>'
                                                        },
                                                        {
                                                        	x:200,
                                                            y:65,
                                                            id:'dteFechaFin',
                                                            xtype:'datefield',
                                                            value:'<?php echo date("Y-m-d")?>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'<b>Comentarios adicionales:</b>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            xtype:'textarea',
                                                            width:650,
                                                            height:80,
                                                            id:'txtComentariosAdicionales'
                                                        }
													]
										}
									);
                                    
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignar empleado',
										width: 700,
										height:300,
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
																		
                                                                        
                                                                        
                                                                        var cadObj='{"idPerfil":"'+nodoSel.attributes.idPerfil+'","puesto":"'+nodoSel.attributes.claveNivel+'","fechaInicio":"'+
                                                                        				gEx('dteFechaFin').getValue().format('Y-m-d')+
                                                                                    '","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+'"}';
                                                                       
                                                                       	
                                                                        function respF(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                        
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        gE('sp_'+nodoSel.attributes.claveNivel).innerHTML='<span style="color:#F00 !important; font-weight:bold">VACANTE</span>';
                                                                                        ventanaAM.close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=172&cadObj='+cadObj,true);
																			}
                                                                         }
                                                                         msgConfirm('Est&aacute; seguro de querer registrar la baja del empleado seleccionado?',respF);
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

function agregarPuesto()
{
	var cmbPuestoAgregar=crearComboExt('cmbPuestoAgregar',arrPuestos,200,5,400);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'<b>Puesto a agregar:</b>'
                                                        },
                                                        cmbPuestoAgregar,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'<b>Puesto inmmediato superior:</b>'
                                                        },
                                                        {
                                                        	x:200,
                                                            y:40,
                                                            html:'<span style="color:#900; font-weight:bold">'+(nodoSel?nodoSel.attributes.puesto:'(NINGUNO)')+'</span>'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar puesto',
										width: 700,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		if(cmbPuestoAgregar.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbPuestoAgregar.focus();
                                                                            }
                                                                            msgBox('Debe indicar el puesto que desea gregar',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        var cadObj='{"idPerfil":"'+gE('idPerfil').value+'","puestoSuperior":"'+
                                                                        			(nodoSel?nodoSel.attributes.claveNivel:'')+'","puestoAgrega":"'+
                                                                                    cmbPuestoAgregar.getValue()+'","iUGJ":"'+gE('uG').value+'"}'
                                                                        	
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gE('idPerfil').value=arrResp[1];
                                                                                gEx('tOrganigrama').getRootNode().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=177&cadObj='+cadObj,true);
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

function removerPuesto()
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
                                                            html:'<b>Puesto inmmediato superior:</b>'
                                                        },
                                                        {
                                                        	x:200,
                                                            y:10,
                                                            html:'<span style="color:#900; font-weight:bold">'+(nodoSel?nodoSel.attributes.puesto:'(NINGUNO)')+'</span>'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Remover puesto',
										width: 700,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		
                                                                        function resp(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                                var cadObj='{"idPerfil":"'+gE('idPerfil').value+'","puestoRemover":"'+
                                                                                            nodoSel.attributes.claveNivel+'"}'
                                                                                    
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        
                                                                                        gEx('tOrganigrama').getRootNode().reload();
                                                                                        ventanaAM.close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=178&cadObj='+cadObj,true);
																	
                                                                    		}
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer remover el puesto seleccionado?',resp);
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