<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$consulta="SELECT id__642_tablaDinamica,nombrePeriodicidad FROM _642_tablaDinamica  WHERE situacion=1 ORDER BY nombrePeriodicidad";
	$arrPeriodicidad=$con->obtenerFilasArreglo($consulta);
?>

var arrPeriodicidad=<?php echo $arrPeriodicidad?>;
function crearNuevoPerfil()
{
	var cmbPeriodicidad=crearComboExt('cmbPeriodicidad',arrPeriodicidad,135,125,250);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Nombre del perfil:<span class="letraRoja">*</span>'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            x:135,
                                                            y:5,
                                                            id:'txtNombrePerfil',
                                                            width:300
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            x:135,
                                                            y:35,
                                                            width:400,
                                                            height:80,
                                                            id:'txtDescripcion'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            html:'Periodicidad de pago:<span class="letraRoja">*</span>'
                                                        },
                                                        cmbPeriodicidad
														

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Crear perfil de n&oacute;mina',
										width: 600,
										height:250,
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
                                                                	gEx('txtNombrePerfil').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		if(gEx('txtNombrePerfil').getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	gEx('txtNombrePerfil').focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el nombre del perfil a crear',resp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbPeriodicidad.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbPeriodicidad.focus();
                                                                            }
                                                                            msgBox('Debe indicar la periodicidad de pago',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                var arrParam=[['idPerfil',arrResp[1]]];
                                                                                enviarFormularioDatos('../nomina/modificarPerfilNomina.php',arrParam);
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=10&idPeriodicidad='+cmbPeriodicidad.getValue()+'&nombrePerfil='+cv(gEx('txtNombrePerfil').getValue())+'&idPerfil=-1&descripcion='+cv(gEx('txtDescripcion').getValue()),true);
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