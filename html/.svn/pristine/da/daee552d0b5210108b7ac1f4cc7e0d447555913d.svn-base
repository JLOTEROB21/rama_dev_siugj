<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT idEscalaCalificacion,nombreEscala FROM 4032_escalasCalificacion ORDER BY nombreEscala";
	$arrEscala=$con->obtenerFilasArreglo($consulta);
	
?>
var arrTipoCuestionario=[['0','Cuestionario est\xE1ndar'],['1','Cuestionario de evaluaci\xF3n']];
var arrEscala=<?php echo $arrEscala?>;
var arrPonderacionHijos=[['0','Manual'],['1','Equitativa']];

function nuevoCuestionario()
{
	var arrSiNo=[['0','No'],['1','Si']];
	var cmbPonderacionElementos=crearComboExt('cmbPonderacionElementos',arrPonderacionHijos,190,160,210);
    var cmbEscala=crearComboExt('cmbEscala',arrEscala,190,190,210);
    var cmbSiNo=crearComboExt('cmbSiNo',arrSiNo,190,220,150);
    
    cmbSiNo.setValue('1');
    var cmbSiNoPuntaje=crearComboExt('cmbSiNoPuntaje',arrSiNo,190,250,150);
    cmbSiNoPuntaje.setValue('1');
    
    var cmbTipoCuestionario=crearComboExt('cmbTipoCuestionario',arrTipoCuestionario,190,280,210);
    cmbTipoCuestionario.on('select',function(cmb,registro)
    								{
                                    	gEx('cmbCategoriaRespuestas').hide();
                                        gEx('lblNivelDificultad').hide();
                                    	switch(registro.data.id)
                                        {
                                        	case '1':
                                            	gEx('cmbCategoriaRespuestas').show();
		                                        gEx('lblNivelDificultad').show();	
                                            break;
                                        }
                                    }
    					)
    
    
    var cmbCategoriaRespuestas=crearComboExt('cmbCategoriaRespuestas',arrEscala,230,310,210);
    cmbCategoriaRespuestas.hide();
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Nombre del cuestionario:'
                                                        },
                                                        {
                                                        	id:'txtNombre',
                                                        	xtype:'textfield',
                                                            x:165,
                                                            y:5,
                                                            width:350
                                                        },
                                            			{
                                                        	x:10,
                                                            y:40,
                                                            html:'T&iacute;tulo del cuestionario:'
                                                        },
                                                        {
                                                        	id:'txtTitulo',
                                                        	xtype:'textfield',
                                                            x:165,
                                                            y:35,
                                                            width:350
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	x:165,
                                                            y:65,
                                                            xtype:'textarea',
                                                            width:550,
                                                            height:80,
                                                            id:'txtDescripcion'
                                                        },
                                                         {
                                                        	x:10,
                                                            y:165,
                                                            html:'Ponderaci&oacute;n de elementos hijos:'
                                                        },
                                                        cmbPonderacionElementos,
                                                        {
                                                        	x:10,
                                                            y:195,
                                                            html:'Escala de evaluaci&oacute;n final:'
                                                        },
                                                        cmbEscala,
                                                        {
                                                        	x:10,
                                                            y:225,
                                                            html:'Solicitar comentarios finales:'
                                                        },
                                                        cmbSiNo,
                                                        {
                                                        	x:10,
                                                            y:255,
                                                            html:'¿Mostrar puntaje obtenido?:'
                                                        },
                                                        cmbSiNoPuntaje,
                                                        {
                                                        	x:10,
                                                            y:285,
                                                            html:'Tipo de cuestionario:'
                                                        },
                                                        cmbTipoCuestionario,
                                                        {
                                                        	x:10,
                                                            y:315,
                                                            id:'lblNivelDificultad',
                                                            hidden:true,
                                                            html:'Escala de categorizaci&oacute;n de respuestas:'
                                                        },
                                                        cmbCategoriaRespuestas
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Nuevo reporte',
										width: 780,
										height:430,
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
                                                                	gEx('txtNombre').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtNombre=gEx('txtNombre');
                                                                        if(txtNombre.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtNombre.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el nombre del reporte',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        var titulo=gEx('txtTitulo');
                                                                        if(titulo.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	titulo.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el t&iacute;tulo del reporte',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                       if(cmbPonderacionElementos.getValue()=='')
                                                                       {
                                                                       		function resp3()
                                                                            {
                                                                            	cmbPonderacionElementos.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el tipo de ponderaci&oacute;n que tendr&aacute;n los elementos hijos de este cuestionario',resp3);
                                                                            return;
                                                                       }
                                                                       
                                                                       if(cmbEscala.getValue()=='')
                                                                       {
                                                                       		function resp4()
                                                                            {
                                                                            	cmbEscala.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la escala de evaluaci&oacute;n que definir&aacute; el resultado final de este cuestionario',resp4);
                                                                            return;
                                                                       }
                                                                       
                                                                       if(cmbTipoCuestionario.getValue()=='')
                                                                       {
                                                                       		function resp5()
                                                                            {
                                                                            	cmbTipoCuestionario.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el tipo de cuestionario a crear',resp5);
                                                                            return;
                                                                       }
                                                                       
                                                                       var idEscalaCategoriaPreguntas=0;
                                                                       
                                                                       if(cmbTipoCuestionario.getValue()=='1')
                                                                       {
                                                                       		if(gEx('cmbCategoriaRespuestas').getValue()=='')
                                                                            {
                                                                            	function resp6()
                                                                                {
                                                                                    cmbCategoriaRespuestas.focus();
                                                                                }
                                                                                msgBox('Debe indicar la escala de ctegorizaci&oacute;n de respuestas',resp6);
                                                                                return;
                                                                            }
                                                                            else
                                                                            	idEscalaCategoriaPreguntas=gEx('cmbCategoriaRespuestas').getValue();
                                                                       }
                                                                       
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var arrDatos=[['idCuestionario',arrResp[1]]];
                                                                                enviarFormularioDatos('../thotCuestionarios/thotDesigner.php',arrDatos);
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=45&idEscalaCategoriaPreguntas='+idEscalaCategoriaPreguntas+'&tipoCuestionario='+cmbTipoCuestionario.getValue()+'&ponderacionHijos='+cmbPonderacionElementos.getValue()+'&escala='+cmbEscala.getValue()+'&solicitaComentarios='+cmbSiNo.getValue()+'&nombre='+cv(txtNombre.getValue())+
                                                                        				'&idCuestionario=-1&titulo='+cv(titulo.getValue())+'&descripcion='+cv(gEx('txtDescripcion').getValue())+'&mostrarPuntaje='+cmbSiNoPuntaje.getValue(),true);
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

function modificarCuestionario(iR)
{
	var arrDatos=[['idCuestionario',bD(iR)]];
    enviarFormularioDatos('../thotCuestionarios/thotDesigner.php',arrDatos);
}

function eliminarCuestionario()
{
	var grid=gEx('grid_tblTabla');
    var fila=vFilaSel(grid,'Debe seleccionar el cuestionario que desea eliminar')
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
                          grid.getStore().remove(fila);
                      }
                      else
                      {
                          msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                      }
                  }
                  obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=31&idReporte='+fila.get('idReporte'),true);
      
              }
          }
          msgConfirm('Est&aacute; seguro de querer eliminar el cuestionario seleccionado?',resp)
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