<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	$fechaActual=date("Y-m-d");
	$horaActual=date("H:i");
	
?>

var cadObjBusqueda='';
var fechaActual='<?php echo $fechaActual?>';
var horaActual='<?php echo $horaActual ?>';

function inyeccionCodigo()
{

	
}  

 
 
function addPerito()
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
                                                            html:'Nombre: <span style="color:#F00; font-weight:bold">*</span>'
                                                        },
                                                        {
                                                        	x:90,
                                                            y:5,
                                                            xtype:'textfield',
                                                            width:140,
                                                            id:'txtNombre'
                                                        },
                                                        {
                                                        	x:240,
                                                            y:10,
                                                            html:'Ap. Paterno: <span style="color:#F00; font-weight:bold">*</span>'
                                                        },
                                                        {
                                                        	x:330,
                                                            y:5,
                                                            xtype:'textfield',
                                                            width:120,
                                                            id:'txtApPaterno'
                                                        },
                                                        {
                                                        	x:460,
                                                            y:10,
                                                            html:'Ap. Materno:'
                                                        },
                                                        {
                                                        	x:550,
                                                            y:5,
                                                            xtype:'textfield',
                                                            width:120,
                                                            id:'txtApMaterno'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Registrar Perito',
										width: 720,
										height:130,
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
                                                                        var txtApPaterno=gEx('txtApPaterno');
                                                                        var txtApMaterno=gEx('txtApMaterno');
                                                                        
                                                                        if(txtNombre.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtNombre.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el nombre del perito',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(txtApPaterno.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	txtApPaterno.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el apellido paterno del perito',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cadObj='{"nombre":"'+cv(txtNombre.getValue())+'","apPaterno":"'+cv(txtApPaterno.getValue())+'","apMaterno":"'+cv(txtApMaterno.getValue())+'"}';
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                var arrDatos=eval(arrResp[1]);
                                                                                
                                                                                llenarCombo(gE('_peritovch'),arrDatos,true);
                                                                                selElemCombo(gE('_peritovch'),arrResp[2]);
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Juzgados.php',funcAjax, 'POST','funcion=7&cadObj='+cadObj,true);
                                                                        
                                                                        
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



