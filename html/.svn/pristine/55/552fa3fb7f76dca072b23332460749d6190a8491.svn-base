<?php
	session_start();

	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	$arrRegistros="";
	$consulta="SELECT idConsulta,nombreConsulta FROM 991_consultasSql WHERE idTipoConcepto=106 ORDER BY nombreConsulta";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))	
	{
		$consulta="SELECT nombreValor,nombreValor,if(descripcion='','(Sin descripción)',descripcion) as descripcion FROM 994_valoresDevueltoFuncion WHERE idConsulta=".$fila["idConsulta"]." ORDER BY nombreValor";
		$arrParametros=$con->obtenerFilasArreglo($consulta);
		$o="['".$fila["idConsulta"]."','".cv($fila["nombreConsulta"])."',".$arrParametros."]";
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
	}

	$arrRegistros="[".$arrRegistros."]";
?>

var arrRegistros=<?php echo $arrRegistros?>;

function inyeccionCodigo()
{
    
   
}

function mostrarVentanaInsertParametroPlantilla(e)
{
	
	var option=gE('_funcionSistemavch').options[gE('_funcionSistemavch').selectedIndex].value;
    
    var pos=existeValorMatriz(arrRegistros,option);
    
    
    var registro=arrRegistros[pos];
	
    var objConf={};
    objConf.confVista='<tpl for="."><div class="search-item">{nombre}<br /><i>{valorComp}</i></div></tpl>';
    
    var cmbParametroInsert=crearComboExt('cmbParametroInsert',registro[2],220,5,350,objConf);
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione el par&aacute;metro a insertar:'
                                                        },
                                                        cmbParametroInsert
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Insertar Par&aacute;metro',
										width: 650,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		if(cmbParametroInsert.getValue()=='')
                                                                        {
																			function resp()
                                                                            {
                                                                            	cmbParametroInsert.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el par&aacute;metro que desea insertar',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        e.insertHtml('['+cmbParametroInsert.getValue()+']');
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
