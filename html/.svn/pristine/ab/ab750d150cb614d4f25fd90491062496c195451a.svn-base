<?php	session_start(); 
	include("funcionesFormularios.php");	
	$idp= $_POST["id"];
	$cveProceso=$_POST["_cveProcesovch"];
	$nombre= $_POST["_nombrevch"];
	$desc= $_POST["_descripcionvch"];
	$idTipoProceso="";
	$configuracion=0;
	if(isset($_POST["configuracion"]))
		$configuracion=$_POST["configuracion"];
	
	if(isset($_POST["_idTipoProcesoint"]))
		$idTipoProceso=$_POST["_idTipoProcesoint"];
	try
	{
		if($idp==-1)
		{
			$guardar="insert into 4001_procesos (nombre,descripcion,idTipoProceso,situacion,repetible,idResponsable,cveProceso)
					values('".cv($nombre)."','".cv($desc)."',".$idTipoProceso.",1,1,".$_SESSION["idUsr"].",'".cv($cveProceso)."')";
			$resultado=$con->ejecutarConsulta($guardar);
			$iproceso=$con->obtenerUltimoID();
			switch($idTipoProceso)
			{
				case "1":
				break;
				case "2":
				break;
				case "3":
					$consulta="insert into 4037_etapas(idProceso,numEtapa,nombreEtapa,eliminable) values(".$iproceso.",1,'Registro proyecto',0)";
					if(!$con->ejecutarConsulta($consulta))
						return;
					
					$objFormulario='{
										"nombreFormulario":"Ficha del proyecto",
										"descripcion":"",
										"titulo":"Ficha del proyecto",
										"idProceso":"'.$iproceso.'",
										"idEtapa":"1",
										"idFrmEntidad":"-1",
										"frmRepetible":"1",
										"formularioBase":"1",
										"estadoInicial":"1",
										"eliminable":"0",
										"tipoFormulario":"0",
										"mostrarTableroControl":"1",
										"confListadoFormulario":{
																	"campoOrden":"tituloProyecto",
																	"orden":"ASC",
																	"regPag":"25",
																	"campoAgrupacion":"idEstado",
																	"campos":	[
																					{
																						"campo":"tituloProyecto",
																						"anchoCol":"150",
																						"titulo":	[
																										{
																											"idIdioma":"1",
																											"etiqueta":"Proyecto:"
																										}
																									 ],
																						"accion":"0",
																						"idAlineacion":"3"
																					}
																				]
																},
										"arrControles":	[
															{
																"pregunta":	[
																				{
																					"etiqueta":"Título del proyecto:",
																					"idIdioma":"1"
																				}
																			],
																"obligatorio":"0",
																"tipoElemento":"1",
																"posX":"9",
																"posY":"48",
																"eliminable":"0"
																
																
															},
															
															{
																"obligatorio":"1",
																"tipoElemento":"5",
																"posX":"134",
																"posY":"44",
																"confCampo":{
																				"ancho":"40",
																				"longitud":"50"
																			},
																"nomCampo":"tituloProyecto",
																"eliminable":"0",
																"pregunta":""
																
															}
														]
									}';
								
					if(crearFormulario($objFormulario)=="-1")
						return;
				break;
				case "4":
					$consulta="insert into 4037_etapas(idProceso,numEtapa,nombreEtapa,eliminable) values(".$iproceso.",1,'Registro CV',0)";
					if(!$con->ejecutarConsulta($consulta))
						return;
					
					$objFormulario='{
										"nombreFormulario":"Ficha CV",
										"descripcion":"",
										"titulo":"Ficha CV",
										"idProceso":"'.$iproceso.'",
										"idEtapa":"1",
										"idFrmEntidad":"-1",
										"frmRepetible":"1",
										"formularioBase":"1",
										"estadoInicial":"1",
										"eliminable":"0",
										"tipoFormulario":"0",
										"mostrarTableroControl":"0",
										"confListadoFormulario":{
																	"campoOrden":"titulo",
																	"orden":"ASC",
																	"regPag":"25",
																	"campos":	[
																					{
																						"campo":"titulo",
																						"anchoCol":"150",
																						"titulo":	[
																										{
																											"idIdioma":"1",
																											"etiqueta":"Título:"
																										}
																									 ],
																						"accion":"0",
																						"idAlineacion":"3"
																					}
																				]
																},
										"arrControles":	[
															
															{
																"pregunta":	[
																				{
																					"etiqueta":"Título:",
																					"idIdioma":"1"
																				}
																			],
																"obligatorio":"0",
																"tipoElemento":"1",
																"posX":"8",
																"posY":"48",
																"eliminable":"0"
															},
															{
																"obligatorio":"1",
																"tipoElemento":"5",
																"posX":"87",
																"posY":"44",
																"confCampo":{
																				"ancho":"100",
																				"longitud":"255"
																			},
																"nomCampo":"titulo",
																"eliminable":"0",
																"pregunta":""
															}
														]
									}';
								
					if(crearFormulario($objFormulario)=="-1")
						return;
				break;
				case "6":
					$consulta="insert into 4037_etapas(idProceso,numEtapa,nombreEtapa,eliminable) values(".$iproceso.",1,'Registro Tesis',0)";
					if(!$con->ejecutarConsulta($consulta))
						return;
					
					$objFormulario='{
										"nombreFormulario":"Ficha Tesis",
										"descripcion":"",
										"titulo":"Ficha Tesis",
										"idProceso":"'.$iproceso.'",
										"idEtapa":"1",
										"idFrmEntidad":"-1",
										"frmRepetible":"1",
										"formularioBase":"1",
										"estadoInicial":"1",
										"eliminable":"0",
										"tipoFormulario":"0",
										"mostrarTableroControl":"0",
										"confListadoFormulario":{
																	"campoOrden":"titulo",
																	"orden":"ASC",
																	"regPag":"25",
																	"campos":	[
																					{
																						"campo":"titulo",
																						"anchoCol":"150",
																						"titulo":	[
																										{
																											"idIdioma":"1",
																											"etiqueta":"Título:"
																										}
																									 ],
																						"accion":"0",
																						"idAlineacion":"3"
																					}
																				]
																},
										"arrControles":	[
															
															{
																"pregunta":	[
																				{
																					"etiqueta":"Título:",
																					"idIdioma":"1"
																				}
																			],
																"obligatorio":"0",
																"tipoElemento":"1",
																"posX":"8",
																"posY":"48",
																"eliminable":"0"
															},
															{
																"obligatorio":"1",
																"tipoElemento":"5",
																"posX":"87",
																"posY":"44",
																"confCampo":{
																				"ancho":"100",
																				"longitud":"255"
																			},
																"nomCampo":"titulo",
																"eliminable":"0",
																"pregunta":""
															}
														]
									}';
								
					if(crearFormulario($objFormulario)=="-1")
						return;
				break;
				case "8":
					$consulta="insert into 4037_etapas(idProceso,numEtapa,nombreEtapa,eliminable) values(".$iproceso.",1,'Registro de credito',0)";
					if(!$con->ejecutarConsulta($consulta))
						return;
					
					$objFormulario='{
										"nombreFormulario":"Ficha crédito",
										"descripcion":"",
										"titulo":"Ficha crédito",
										"idProceso":"'.$iproceso.'",
										"idEtapa":"1",
										"idFrmEntidad":"-1",
										"frmRepetible":"1",
										"formularioBase":"1",
										"estadoInicial":"1",
										"eliminable":"0",
										"tipoFormulario":"0",
										"mostrarTableroControl":"0",
										"confListadoFormulario":{
																	"campoOrden":"observaciones",
																	"orden":"ASC",
																	"regPag":"25",
																	"campos":	[
																					{
																						"campo":"observaciones",
																						"anchoCol":"150",
																						"titulo":	[
																										{
																											"idIdioma":"1",
																											"etiqueta":"Observaciones:"
																										}
																									 ],
																						"accion":"0",
																						"idAlineacion":"3"
																					}
																				]
																},
										"arrControles":	[
															
															{
																"pregunta":	[
																				{
																					"etiqueta":"Observaciones:",
																					"idIdioma":"1"
																				}
																			],
																"obligatorio":"0",
																"tipoElemento":"1",
																"posX":"8",
																"posY":"48",
																"eliminable":"0"
															},
															{
																"obligatorio":"1",
																"tipoElemento":"9",
																"posX":"87",
																"posY":"44",
																"confCampo":{
																				"ancho":"80",
																				"alto":"5"
																			},
																"nomCampo":"observaciones",
																"eliminable":"0",
																"pregunta":""
															}
														]
									}';
								
					if(crearFormulario($objFormulario)=="-1")
						return;
				break;
				case "9":
					$x=0;
					$query[$x]="insert into 4037_etapas(idProceso,numEtapa,nombreEtapa,eliminable) values(".$iproceso.",1,'Registro de POA',0)";
					$x++;
					$query[$x]="insert into 4001_configuracionProcesoPOA(idProceso) values(".$iproceso.")";
					$x++;
					if(!$con->ejecutarBloque($query))
						return;
				break;
				case "1000":
					$consulta="insert into 4037_etapas(idProceso,numEtapa,nombreEtapa,eliminable) values(".$iproceso.",1,'Uso de Interface',0)";
					if(!$con->ejecutarConsulta($consulta))
						return;
				break;
				default:
				
					$consulta="select * from 921_tiposProceso  where idTipoProceso=".$idTipoProceso;
					$filaTipoProceso=$con->obtenerPrimeraFila($consulta);
					if($filaTipoProceso[6]==1)
					{
						$consulta="insert into 4037_etapas(idProceso,numEtapa,nombreEtapa,eliminable) values(".$iproceso.",1,'Registro',1)";
						if(!$con->ejecutarConsulta($consulta))
							return;
						if($filaTipoProceso[7]==1)
						{
							$objFormulario='{
												"nombreFormulario":"Formulario base",
												"descripcion":"Formulario base del proceso: '.cv($nombre).'",
												"titulo":"Formulario base",
												"idProceso":"'.$iproceso.'",
												"idEtapa":"1",
												"idFrmEntidad":"-1",
												"frmRepetible":"1",
												"formularioBase":"1",
												"estadoInicial":"1",
												"eliminable":"1",
												"tipoFormulario":"0",
												"mostrarTableroControl":"0"
											}';
										
							if(crearFormulario($objFormulario)=="-1")
								return;
						}
					}
				break;
			}
			
			
			cambiarValorObjParametros($configuracion,"idProceso",$iproceso);
		
			
			
		}
		else
		{
			$modificar="update 4001_procesos set descripcion='".cv($desc)."', nombre='".cv($nombre)."',cveProceso='".cv($cveProceso)."' where idProceso='".$idp."'";
			$resultado=$con->ejecutarConsulta($modificar);
			$iproceso=$idp;
		}
		$res=1;
	}
	catch(Exception $e)
	{
		$res=-1;
		echo $e->getMessage();
	}
 ?>
 <title>
 </title>
 <body>
 	<?php
		if($res==1)
		{
	?>
        <form method="post" action="procesos.php" id="frmEnvio">
            <input type="hidden" name="configuracion" value="<?php echo $configuracion ?>"/>
            
            
            
            
        </form>
        <script language="javascript">
            document.getElementById('frmEnvio').submit();
        </script>
    <?php
		}
	?>
 </body>