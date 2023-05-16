<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

function eliminarRegistro(idRegistro,op)
{
	var idFormulario=gE('idFormulario').value;
    function respPregunta(btn)
    {
        if(btn=='yes')
        {
            function funcResp()
            {
                var arrResp=peticion_http.responseText.split('|');
                if(arrResp[0]=='1')
                {
                    var fila=gE('fila_'+op);
                    fila.parentNode.removeChild(fila);
                    fila=gE('filaComp_'+op);
                    fila.parentNode.removeChild(fila);
                }
                else
                {
                     msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);				
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=39&idRegistro='+op+'&idFormulario='+idFormulario,true);
        }
    }
    Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro?',respPregunta);
}

function irPagina(nPagina)
{
	gE('pagina').value=nPagina;
	gE('frmCambiarPag').submit();
}


//Evaluar si eliminarse

function removerParticipante(iF,iR,iU,mC,iA)
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
                	function respA()
                    {
                        //var fila=gE('filaAccion_'+bD(iA)+'_'+bD(iR));
                        //fila.parentNode.removeChild(fila);
                        recargarPagina();
                    }
                    msgBox('La acci&oacute;n ha sido llevada a cabo satisfactoriamente',respA);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=311&idFormulario='+iF+'&idUsuario='+iU+'&idRegistro='+iR+'&accion=-1&complementario=&idAccion='+iA,true);
       	}
    }
    msgConfirm(bD(mC),resp)
}
  
function cancelarSolicitudRemover(iF,iR,iU,mC,iA)
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
                    function respA()
                    {
                        var fila=gE('filaAccion_'+bD(iA)+'_'+bD(iR));
                        fila.parentNode.removeChild(fila);
                        recargarPagina();
                    }
                    msgBox('La acci&oacute;n ha sido llevada a cabo satisfactoriamente',respA);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=311&idFormulario='+iF+'&idUsuario='+iU+'&idRegistro='+iR+'&accion=1&complementario=&idAccion='+iA,true);
       	}
    }
    msgConfirm(bD(mC),resp)
}

function enviarComentario(iF,iR,iU,mC,iA)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	html:'Ingrese el comentario a enviar:',
                                                            x:10,
                                                            y:10
                                                        },
                                                        {
                                                        	xtype:'textarea',
                                                            x:10,
                                                            y:40,
                                                            width:400,
                                                            height:100,
                                                            id:'txtComentario'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Enviar comentario a admisnitrador de sistema',
										width: 440,
										height:235,
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
                                                                	gEx('txtComentario').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtComentario=gEx('txtComentario');
                                                                        if(txtComentario.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtComentario.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el comentario a enviar al adminitrador del sistema',resp)
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	function resp2()
                                                                                {
                                                                                	ventanaAM.close();
                                                                                }
                                                                                msgBox('Su comentario ha sido enviado satisfactoriamente al adminsitrador del sistema',resp2);
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=311&idFormulario='+iF+'&idUsuario='+iU+'&idRegistro='+iR+'&accion=2&complementario='+cv(txtComentario.getValue())+'&idAccion='+iA,true);

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

function inscribirConvocatoria(iF,iR,iU,mC,iA)
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
                    function respA()
                    {
                        var fila=gE('filaAccion_'+bD(iA)+'_'+bD(iR));
                        fila.parentNode.removeChild(fila);
                    }
                    msgBox('La acci&oacute;n ha sido llevada a cabo satisfactoriamente',respA);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=311&idFormulario='+iF+'&idUsuario='+iU+'&idRegistro='+iR+'&accion=3&complementario=1000&idAccion='+iA,true);
       	}
    }
    msgConfirm(bD(mC),resp)
}

function desInscribirConvocatoria(iF,iR,iU,mC,iA)
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
                    function respA()
                    {
                        var fila=gE('filaAccion_'+bD(iA)+'_'+bD(iR));
                        fila.parentNode.removeChild(fila);
                    }
                    msgBox('La acci&oacute;n ha sido llevada a cabo satisfactoriamente',respA);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=311&idFormulario='+iF+'&idUsuario='+iU+'&idRegistro='+iR+'&accion=4&complementario=1000&idAccion='+iA,true);
       	}
    }
    msgConfirm(bD(mC),resp)
}

function buscarProducto(iP)
{
	tb_show(lblAplicacion,'../reportes/buscarProducto.php?cPagina=sFrm=true&idProceso='+iP+'&TB_iframe=true&height=380&width=700',"","scrolling=no");
}

function cancelarSolicitudParticipante(iF,iR,iU,mC,iA)
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
                    function respA()
                    {
                        
                        recargarPagina();
                    }
                    msgBox('La acci&oacute;n ha sido llevada a cabo satisfactoriamente',respA);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=311&idFormulario='+iF+'&idUsuario='+iU+'&idRegistro='+iR+'&accion=6&complementario=&idAccion='+iA,true);
       	}
    }
    msgConfirm(bD(mC),resp)
}