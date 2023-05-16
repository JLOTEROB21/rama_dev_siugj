<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


Ext.onReady(inicializar);

function inicializar()
{

	construirArbol();

	
}

function construirArbol()
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var oEstructura=eval('['+arrResp[1]+']')[0];
            
            gE('spContenedor').innerHTML='<div class="chart" id="tOrganigrama"></div>';
            
            var tree_structure=	{
                                    chart: 	{
                                                container: "#tOrganigrama", 
                                                rootOrientation: "NORTH",   
                                                levelSeparation: 90,
                                                nodeAlign: "BOTTOM", 
                                                siblingSeparation :60,                                   
                                                connectors: {
                                                                type: 'straight',
                                                                style:	{
                                                                			stroke:'#900'
                                                                        }
                                                            },
                                                node: 	{
                                                            HTMLclass: 'big-commpany'
                                                        }
                                            },
                                    nodeStructure:	oEstructura
                                }
    		var arbol=new Treant( tree_structure );
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=148&iUG='+gE('uG').value,true);

}

function nodoClick(id)
{
	var arrId=id.split('_');
    
    console.log(arrId);
    if(arrId[2]==-1)
    {	 
    	mostrarVentanaAsignarEmpleado(arrId);
    }
    else
    {
    	mostrarVentanaBajaEmpleado(arrId);
    }
    
}

function mostrarVentanaAsignarEmpleado(arrId)
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
                                                            html:'<b>Puesto:</b>&nbsp;&nbsp;&nbsp;&nbsp;<span id="lblPuesto" style="color:#900; font-weight:bold">'+bD(arrId[4])+'</span>'
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
                                                                        
                                                                        
                                                                        var cadObj='{"idPerfil":"'+arrId[0]+'","puesto":"'+arrId[1]+'","empleado":"'+cmbEmpleadoAsignar.getValue()+
                                                                        			'","fechaInicio":"'+gEx('dteFechaInicio').getValue().format('Y-m-d')+
                                                                                    '","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+'"}';
                                                                       
                                                                       	
                                                                       	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gE('puesto_'+arrId[1]).innerHTML='<span style="color:#030 !important; font-weight:bold">'+cmbEmpleadoAsignar.getRawValue()+'</span>';
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


function mostrarVentanaBajaEmpleado(arrId)
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
                                                            html:'<span id="lblPuesto" style="color:#900; font-weight:bold">'+bD(arrId[4])+'</span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'<b>Empleado a dar de baja:</b>'
                                                        },
                                                        {
                                                        	x:200,
                                                            y:40,
                                                            html:'<span id="lblPuesto" style="color:#900; font-weight:bold">'+bD(arrId[3])+'</span>'
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
																		
                                                                        
                                                                        
                                                                        var cadObj='{"idPerfil":"'+arrId[0]+'","puesto":"'+arrId[1]+'","fechaInicio":"'+
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
                                                                                        gE('puesto_'+arrId[1]).innerHTML='<span style="color:#F00 !important; font-weight:bold">VACANTE</span>';
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