<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

function nuevoReporte()
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
                                                            html:'T&iacute;tulo:'
                                                        },
                                                        {
                                                        	id:'txtTitulo',
                                                        	xtype:'textfield',
                                                            x:100,
                                                            y:5,
                                                            width:350
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	x:100,
                                                            y:35,
                                                            xtype:'textarea',
                                                            width:350,
                                                            height:150,
                                                            id:'txtDescripcion'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Nuevo reporte',
										width: 500,
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
                                                                	gEx('txtTitulo').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var titulo=gEx('txtTitulo');
                                                                        if(titulo.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	titulo.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el t&iacute;tulo del reporte',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var arrDatos=[['idReporte',arrResp[1]]];
                                                                                enviarFormularioDatos('../thotReporter/thot.php',arrDatos);
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=1&idReporte=-1&titulo='+cv(titulo.getValue())+'&descripcion='+cv(gEx('txtDescripcion').getValue()),true);

                                                                        
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

function modificarReporte(iR)
{
	var arrDatos=[['idReporte',bD(iR)]];
    enviarFormularioDatos('../thotReporter/thot.php',arrDatos);
}

function eliminarReporte()
{
	var grid=gEx('grid_tblTabla');
    var fila=vFilaSel(grid,'Debe seleccionar el reporte que desea eliminar')
   	if(fila)
    {
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
                          grid.getStroe().remove(fila);
                      }
                      else
                      {
                          msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                      }
                  }
                  obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=31&idReporte='+fila.get('idReporte'),true);
      
              }
          }
          msgConfirm('Est&aacute; seguro de querer eliminar el reporte seleccionado?',resp)
	}
}

function clonarReporte()
{
	var grid=gEx('grid_tblTabla');
    var fila=vFilaSel(grid,'Debe seleccionar el reporte que desea clonar')
   	if(fila)
    {
    	mostrarVentanaClonReporte(fila.get('idReporte'));
    }
}

function mostrarVentanaClonReporte(iR)
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
                                                            html:'T&iacute;tulo:'
                                                        },
                                                        {
                                                        	id:'txtTitulo',
                                                        	xtype:'textfield',
                                                            x:100,
                                                            y:5,
                                                            width:350
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	x:100,
                                                            y:35,
                                                            xtype:'textarea',
                                                            width:350,
                                                            height:150,
                                                            id:'txtDescripcion'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Clonar reporte [Ingrese los datos del nuevo reporte]',
										width: 500,
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
                                                                	gEx('txtTitulo').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var titulo=gEx('txtTitulo');
                                                                        if(titulo.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	titulo.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el t&iacute;tulo del reporte',resp);
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var arrDatos=[['idReporte',arrResp[1]]];
                                                                                enviarFormularioDatos('../thotReporter/thot.php',arrDatos);
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=100&idReporte='+iR+'&titulo='+cv(titulo.getValue())+'&descripcion='+cv(gEx('txtDescripcion').getValue()),true);
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