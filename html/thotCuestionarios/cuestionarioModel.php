<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"><html xmlns="http://www.w3.org/1999/xhtml" dir="ltr"><!-- InstanceBegin template="/Templates/Lhayas_B.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<style>
<?php
	generarFuentesLetras();
?>

	body
    {
		min-height:450px;
    	
    }
</style>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta name="description" content=""/>
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<link rel="stylesheet" type="text/css" href="../css/hayas.css.php" media="screen" />
<link rel="stylesheet" type="text/css" href="../estilos/estilos.css" media="screen" />
<!--[if IE 8]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE7.css" media="screen" /><![endif]-->
<!--[if IE 6]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE6.css" media="screen" /><![endif]-->
<!--[if IE]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
<?php
if(!isset($excluirExt))
{
?>
<link rel="stylesheet" type="text/css" href="../Scripts/ext/resources/css/ext-all.css.cgz"/>
<script type="text/javascript" src="../Scripts/ext/adapter/ext/ext-base.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/ext-all.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/idioma/ext-lang-es.js"></script>
<?php
}
?>
<script type="text/javascript" src="../Scripts/funcionesAjax.js.jgz"></script>
<script type="text/javascript" src="../Scripts/funcionesGenerales.js"></script>


<?php 
$idEstiloMenu=0;
$procesoName="";
$mostrarRegresar=true;
$ocultarRegresar=!$mostrarOpcionRegresar;
$soloContenido=false;
$mostrarRegresarBajo=false;
$mostrarMenuNivel1=true;
$mostrarMenuNivel2=true;
$mostrarMenuIzq=false;
$mostrarTitulo=true;
$respetarEspacioRegresar=false;
$tamColumIzq="210";
$mostrarUsuario=true;
$mostrarPiePag=true;
$ocultarFormulariosEnvio=false;
$paginaDestino="";

$sqlmax = "SELECT disenoBanner,textoInfIzq,textInfDerecho,tituloPagina,Menu,txTabla3,txTabla4,TiTabla FROM 4081_colorEstilo";
$unico= $con->obtenerPrimeraFila($sqlmax);
$banner=$unico[0];
$textoInfIzq=$unico[1];
$textoInfDer=$unico[2];
$tituloPagina=$unico[3];
$nomPagina=$_SERVER["PHP_SELF"];
$arrPagina=	explode("/",$nomPagina);
$nElementos=sizeof($arrPagina);
$nomPagina=$arrPagina[$nElementos-1];
$rutaNomPagina=$arrPagina[$nElementos-2]."/".$arrPagina[$nElementos-1];
$arrPagina=explode(".",$nomPagina);
$nomPagina=$arrPagina[0];
$paramPOST=true;
$paramGET=false;
$guardarConfSession=false;
$arrPOST=array_values($_POST);
$ctPOST=sizeof($arrPOST);
$arrGET=array_values($_GET);
$ctGET=sizeof($arrGET);
$txMenuIncluye="";
$mostrarBotonesControlSistema=false;
$tituloModulo="";
?>

<!-- InstanceBeginEditable name="EditRegion5" -->
<script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../Scripts/jquery.min.js"></script>
<script type="text/javascript" src="../thotCuestionarios/Scripts/cuestionarioModel.js.php"></script>
<?php
	$guardarConfSession=true;
?>
<style>
	#sticky 
	{
		position: fixed;
		top: 5px;
		width: 97%;
		background-color: #F5F5F5;
		z-index:10000;
		text-align:center;
		
	}
</style>
<!-- InstanceEndEditable -->

<?php



$arrValores=null;
$arrLlaves=null;
$nConfiguracion="-1";
if(($paramPOST)&&($ctPOST>0))
{
	$arrLlaves=array_keys($_POST);
	$arrValores=array_values($_POST);
}
else
{
	if(($paramGET)&&($ctGET>0))
	{
		$arrLlaves=array_keys($_GET);
		$arrValores=array_values($_GET);
	}
}


$ctParams=sizeof($arrLlaves);
$parametros='';
for($x=0;$x<$ctParams;$x++)
{
	if(gettype($arrValores[$x])=='array')
	{
		$cadAux="";
		foreach($arrValores[$x] as $v)
		{
			if($cadAux=="")
				$cadAux="'".$v."'";
			else
				$cadAux.=",'".$v."'";
		}
		$arrValores[$x]=$cadAux;
	}
	if($parametros=='')
	{
	  $parametros='"'.$arrLlaves[$x].'":"'.$arrValores[$x].'"';
	}
	else
	{
	  $parametros.=',"'.$arrLlaves[$x].'":"'.$arrValores[$x].'"';	
	}
}
if($parametros!='')
	$parametros.=',"paginaConf":"../'.$rutaNomPagina.'"';
else
	$parametros.='"paginaConf":"../'.$rutaNomPagina.'"';
$parametros='{'.$parametros.'}';
$objParametros=json_decode($parametros);
$pConfRegresar="";
$nConfRegresar="";


?>
<!-- InstanceBeginEditable name="doctitle" -->

<!-- InstanceEndEditable -->
<?php
if($guardarConfSession)
{
	if(isset($objParametros->configuracion))
	{
		$nConfiguracion=$objParametros->configuracion;
		$parametros=$_SESSION["configuracionesPag"][$nConfiguracion]["parametros"];			
		$objParametros=json_decode($parametros);
		if(isset($objParametros->confReferencia))
		{
			if(isset($_SESSION["configuracionesPag"][$objParametros->confReferencia]))
			{
				$configuracionAux=$_SESSION["configuracionesPag"][$objParametros->confReferencia]["parametros"];
				$objAux=json_decode($configuracionAux);
				$pConfRegresar=$objAux->paginaConf;
				$nConfRegresar=$objParametros->confReferencia;
				$pagRegresar="javascript:regresarPagina()";
			}
			//eliminarReferencia($nConfiguracion);
		}
	}
	else
	{
		if(isset($_SESSION["configuracionesPag"]))
		{
			$nConfiguracion=sizeof($_SESSION["configuracionesPag"])-1;
			
			$ultimaConf=$_SESSION["configuracionesPag"][$nConfiguracion]["parametros"];
			if($ultimaConf!=$parametros)
				$nConfiguracion++;
		}
		else
			$nConfiguracion=0;
		$_SESSION["configuracionesPag"][$nConfiguracion]["parametros"]=$parametros;
		$_SESSION["configuracionesPag"][$nConfiguracion]["tituloModulo"]=$tituloModulo;
		if(isset($objParametros->confReferencia))
		{
			if($objParametros->confReferencia!="-1")
			{
				$_SESSION["configuracionesPag"][$nConfiguracion]["referencia"]=$objParametros->confReferencia;
				$configuracionAux=$_SESSION["configuracionesPag"][$objParametros->confReferencia]["parametros"];
				$objAux=json_decode($configuracionAux);
				$pConfRegresar=$objAux->paginaConf;
				$nConfRegresar=$objParametros->confReferencia;
				$pagRegresar="javascript:regresarPagina()";
			}
		}
	}
	
	
	if(($logSistemaAccesoPaginas)&&(isset($_SESSION["idUsr"])))
		guardarBitacoraAccesoPagina($rutaNomPagina,$parametros);
}
else
{
	if(($logSistemaAccesoPaginas)&&(isset($_SESSION["idUsr"])))
	{
		$parametros="";
		if($ctPOST>0)
		{
			$aLlaves=array_keys($_POST);
			$aValores=array_values($_POST);
			for($nCtParam=0;$nCtParam<$ctPOST;$nCtParam++)
			{
				$parametros.="&".$aLlaves[$nCtParam]."=".$aValores[$nCtParam];
			}
		}
		else
		{
			if($ctGET>0)
			{
				$aLlaves=array_keys($_GET);
				$aValores=array_values($_GET);
				for($nCtParam=0;$nCtParam<$ctGET;$nCtParam++)
				{
					$parametros.="&".$aLlaves[$nCtParam]."=".$aValores[$nCtParam];
				}
			}
		}
		guardarBitacoraAccesoPagina($rutaNomPagina,$parametros);
	}
}
?>


<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->

<?php 
$tipoConsult="";
$permisosArray=array();
if($procesoName!="")
{
	$consulta="select permisos from 942_funcionesRoles where proceso='".$procesoName."' and rol in (".$_SESSION["idRol"].")";
	$procesoResult=$con->obtenerFilas($consulta);
	while($procesoRow=mysql_fetch_row($procesoResult))
	{
		$permisos=$procesoRow[0];
		$arrPermisosArray=explode("_",$permisos);
		$ctPermisos=sizeof($arrPermisosArray);
		for($x=0;$x<$ctPermisos;$x++)
		{
			$permisosArray[$arrPermisosArray[$x]]=true;
		}
	}
}


$configuracion="";
if(isset($objParametros->configuracion))
	$configuracion=$objParametros->configuracion;
$cPagina="";
$iFrame=false;
if(isset($objParametros->cPagina))
	$cPagina=$objParametros->cPagina;

if(isset($objParametros->iFrame))
	$iFrame=$objParametros->iFrame;

$arrParam=array();
	
if($cPagina!="")	
{
	$arrConf=explode("|",$cPagina);
	$nConf=sizeof($arrConf);
	for($x=0;$x<$nConf;$x++)
	{
		$arrDatosP=explode("=",$arrConf[$x]);
		$arrParam[$arrDatosP[0]]=$arrDatosP[1];
	}
	if(isset($arrParam["b"]))
		$mostrarTitulo=false;
	if(isset($arrParam["mI"]))
		$mostrarMenuIzq=false;
	if(isset($arrParam["mnu1"]))
		$mostrarMenuNivel1=false;
	if(isset($arrParam["mnu2"]))
		$mostrarMenuNivel2=false;
	if(isset($arrParam["mR1"]))
		$mostrarRegresar=false;
	if(isset($arrParam["mR2"]))
		$mostrarRegresarBajo=true;
	if(isset($arrParam["mPie"]))
		$mostrarPiePag=false;
	if(isset($arrParam["sFrm"]))
		$soloContenido=true;
	if(isset($arrParam["gConfS"]))
		$guardarConfSession=false;
	
}

$consulta="SELECT idIdioma,idioma,imagen FROM 8002_idiomas ORDER BY idioma";
$res=$con->obtenerFilas($consulta);
?>
<title><?php echo $tituloPagina ?></title>
<script language="javascript">
	function enviar(lenguaje)
	{
		gE('leng').value=lenguaje;
		gE('formLenguaje').submit();
	}
	
	function regresarPagina()
	{
		if(gE('configuracionRegresar').value!='')
			gE('frmRegresar').submit();
		else
			recargarPagina();
	}
	
	function recargarPagina()
	{
		gE('frmRefrescarPagina').submit();
	}
	
</script>
<?php
	if($soloContenido)
	{
?>
	<style>
	#main_content
	{
		padding: 0px !important;
	}
	.p15
	{
		padding: 0px !important;
	}
	#example_content
	{
		padding: 0px !important;
		margin-bottom: 0px !important;
	}
	</style>
<?php		
	}
?>
<link rel="stylesheet" type="text/css" href="../principalPortal/css/controlesFrameWork.css"/>
<link rel="stylesheet" type="text/css" href="../principalPortal/css/estiloSIUGJ.css"/>
</head>

<?php
		$main_single="main_single";
		$wrapper="wrapper";
		$main_hayas="main_hayas";
		$bgColor="";
		if($soloContenido)
		{
			$main_single="";
			$wrapper="";
			$main_hayas="";
			$bgColor='style=" background:#FFFFFF !important"';
		}
		
	?>

<body <?php echo $bgColor ?>>
<script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>
<?php
	if(!$soloContenido)
	{
?>
<div id="main_title">
  <div class="wrapper">
  <?php
  	if($mostrarTitulo)
	{
		echo $banner; 
	} 
	?>
    <div class="transparencia" >
    	<table >
        	<tr height="25">
            	<td >
                	<?php
					if(!esUsuarioLog()&&$mostrarBotonesControlSistema)
					{
					?>
                    	<table class="transparencia2">
                        	<tr>
                            	<td align="right">
			                		<a href="javascript:ingresarSistema()"><img src="../images/botonIngreso.png"  /></a><a href="javascript:mostrarVentanaDuda()"><img src="../images/botonSoporte.png"  /></a>
                                </td>
                                <td align="left">
	                                
                                </td>
                            </tr>
                        </table>
                    <?php
					}
					else
					{
						if($mostrarBotonesControlSistema)
						{
					?>
                    	<table class="transparencia2">
                        	<tr>
                            	<td align="right">
			                		<a href="javascript:cerrarSesion()"><img src="../images/botonSalir.png" /></a>
                                </td>
                                <td align="left">
	                               <!-- &nbsp;<a href="javascript:cerrarSesion()">Cerrar sesión</a>-->
                                </td>
                            </tr>
                        </table>
						
					<?php
						}
					}
					
                    ?>
                </td>
                <td>
                </td>
            </tr>
       </table>
    </div>
  </div>
</div>
	
	<div id="navigation_hayas">
	<div class="wrapper_hayas">
    	
    	<div class="links_hayas">
		<ul class="tabs_hayas"  style="z-index:200 !important">
			<?php 
				
				if($mostrarMenuNivel1)
				{
					
					genearOpcionesMenusPrincipal($nomPagina,1,$idEstiloMenu);
				}
				
			?>
		</ul>
		<div class="clearer">&nbsp;</div>
		</div>

	</div>
	</div>
	<div id="subnavigation_hayas">
	<div class="wrapper">
		<div class="content">
			<div class="links">
            	<ul class="menu2" >
			<?php
				if($mostrarMenuNivel2)
				{
					genearOpcionesMenusPrincipal($nomPagina,2,$idEstiloMenu);
				}
			
			?>
            	</ul>
			<div class="clearerx">&nbsp;</div>
		  </div>
	  </div>
	</div>
</div>
<?php
	}
?>
	

	<div id="<?php echo $main_hayas ?>">
	<div class="<?php echo $wrapper ?>">

		<div id="main_content">		
		<div id="<?php echo $main_single ?>" class="p15">
		<div > 
			  <table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
               
			    <tr>    
					<?php  
					if((($mostrarMenuIzq)&&(!$soloContenido))||((isset($arrParam["mI"]))&&($arrParam["mI"]=='true')))
					{
					?>	
                    <td valign="top" style="width:<?php echo $tamColumIzq?>px" id="tdMenuIzq">
					
               		<div id="example_content" style="width:<?php echo $tamColumIzq?>px">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td valign="top">
                        	<?php
                            genearOpcionesMenusPrincipal($nomPagina,3,$idEstiloMenu);
                            ?>
						</td>
						
                      </tr>
					  <tr>
					  <td>
					 
					  <!-- InstanceBeginEditable name="menu_left2" -->
					  
					  <!-- InstanceEndEditable -->
					  </td>
					  </tr>
                    </table>
					 </div>
                
                     </td>
					 <?php
					 }
					 ?>
                  <td width="1%" bgcolor="#FFFFFF">&nbsp;</td>
                  <td width="81%" bgcolor="#FFFFFF" valign="top">
				  <div id="example_content">  
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
				  	<td align="right">
						<table width="100%">
						<tr>
						<td>
							<?php 	
									if(!$ocultarRegresar)
									{

										if((($mostrarRegresar)&&(!$soloContenido))||((isset($arrParam["mR1"]))&&($arrParam["mR1"]=='true')))
										{
								?> 
											<table align="left" id="tblRegresar1">
											<tr>
											<td>
											<a href="<?php echo $pagRegresar ?>" class="letraVerde"><img width="24" height="24" src="../images/flechaizq.gif" border="0" /></a>
											</td>
											<td>
											<a href="<?php echo $pagRegresar ?>" class="letraVerde">&nbsp;&nbsp;<?php echo $et["regresar"] ?></a>
											</td>
											</tr>
											</table>
											<br />
								<?php 
										}
									}
									if($respetarEspacioRegresar)
										echo "<br><br>";
									echo "<input type=\"hidden\" value=\"".$_SESSION["leng"]."\" id=\"hLeng\"> ";
									
							?>
						</td>
						</tr>
						</table>
					</td>
				</tr>
				  <!-- InstanceBeginEditable name="content2" --> 
                   <tr>
                        <td align="center">
                        <?php
							
							function dibujarElementosHijos($codigoUnidad,$ponderacionHijos)
							{
								global $con;
								global $arrEstilos;
								global $arrEscalas;
								global $arrResultConsulta;
								global $arrRespuestas;
								global $vistaDiseno;
								global $idRegistro;
								
								$valMax=0;
								$consulta="SELECT * FROM 9052_elementosCuestionario WHERE  codigoPadre='".$codigoUnidad."' order by ordenElemento";
								$resElementos=$con->obtenerFilas($consulta);
								while($fila=mysql_fetch_row($resElementos))
								{
									
									if($ponderacionHijos==0)
									{
										$valMax+=$fila[5];

									}
									$btnGuardar="";
									/*if($fila[2]==1)
									{
										$btnGuardar="<a  href='javascript:guardarDatosCuestionario(true)'><img src='../images/guardar.PNG' title='Guardar avance' alt='Guardar avance'></a>&nbsp;";
									}*/
									
									$prefijo="";
									if($fila[11]!="")
										$prefijo=$fila[11].".- ";
										
									$valPregunta="0";
									$valIdOpcion="";
									if(isset($arrRespuestas[$fila[0]]))	
									{
										$valPregunta=$arrRespuestas[$fila[0]][0];
										
										if($arrRespuestas[$fila[0]][3]==4)
										{
											$valPregunta=$arrRespuestas[$fila[0]][2];
											
										}
										
										$valIdOpcion=$arrRespuestas[$fila[0]][1];
										
									}
							?>
								
										<table>
											<tr height="21">
												<td width="15" align="right" valign="top">
												<!--	<span class="<?php echo $arrEstilos[$fila[7]]?>"></span>-->
												</td>
												<td style='text-align:justify' valign="top" >
													<span class="<?php echo $arrEstilos[$fila[7]]?>"><?php echo $prefijo.$btnGuardar.$fila[1]?></span>
												</td>
                                                <td>
                                                	<?php
                                                	if($fila[2]!=2)
													{
													?>
                                                    <label tipoPregunta="<?php echo $fila[2] ?>" style="display:none" id="lblValorPregunta_<?php echo $fila[10]?>" idElemento="<?php echo $fila[0]?>" valorPregunta="1"><?php echo $valPregunta?></label>
                                                    <?php
													}
													?>
                                                </td>
											</tr>
											<?php
											
												switch($fila[2])
												{
													case 1:
														?>
														<tr>
															<td>
															</td>
															<td align="left" colspan="2">
																<?php
																	
																	$valMaxEsperado=dibujarElementosHijos($fila[10],$fila[12]);
																	$campoHidden='<input type="hidden" ponderacionElemento="'.$ponderacionHijos.'" tipo="'.$fila[2].'"  padre="p_'.$codigoUnidad.'" name="p_'.$fila[10].'" id="p_'.$fila[10].'" value="'.$valPregunta.'" ponderacionHijos="'.$fila[12].'" valorPregunta="'.$fila[5].'" valorMaxEsperado="'.$valMaxEsperado.'">';
																	echo $campoHidden;
																?>
															</td>
															
														</tr>
												<?php
													break;
													case 3:
															?>
                                            		<tr height="5">
                                                    	<td colspan="2"></td>
                                                    </tr>
													<tr>
														<td align="right">
														
														</td>
														<td colspan="2" valign="">
													<?php		
															
															$tipoRespuesta=$fila[3];
															$idReferenciaResp=$fila[4];
															$claseRespuesta=$fila[8];
															$presentarRespuesta=$fila[13];
															$incluirValorNoAplica=$fila[14];
															$nColumnas=4;
															if($tipoRespuesta==0)
															{
																
																$arrElementos=array();
																$maxValorPregunta=0;
																if(isset($arrEscalas[$idReferenciaResp]))
																{
																	$arrElementos=$arrEscalas[$idReferenciaResp];	
																	if($ponderacionHijos==1)
																	{
																		$valMax+=$arrEscalas[$idReferenciaResp]["valMaximo"];
																		$maxValorPregunta=$arrEscalas[$idReferenciaResp]["valMaximo"];
																	}
																}
																$campoHidden='<img src="../images/exclamation.png" style="display:none" id="err_'.$fila[0].'" title="Debe responder la pregunta" alt="Debe responder la pregunta" /><input type="hidden"  idElemento="'.$fila[0].'" ponderacionElemento="'.$ponderacionHijos.'"  tipo="'.$fila[2].'"  padre="p_'.$codigoUnidad.'" name="p_'.$fila[10].'" id="p_'.$fila[10].'" value="'.$valIdOpcion.'" maxValorPregunta="'.$maxValorPregunta.'" valorPregunta="'.$fila[5].'">';
																if($presentarRespuesta==0)
																{
																	
																	$cadResp=$campoHidden."<select name='rdo_".$fila[10]."' onselect='respuestaSel(this)'><option value='-1'>Seleccione</option>";
																	if(sizeof($arrElementos)>0)
																	{
																		
																		foreach($arrElementos["escalas"] as $e=>$texto)
																		{
																			$checado="";
																			if($e==$valIdOpcion)
																			{
																				$checado="checked='checked'";
																			}
																			$cadResp.="<option ".$checado." puntaje='".$texto[2]."' value='".$e."'>".$texto[0]."</option>";
																		}
																		if($incluirValorNoAplica==1)
																		{
																			$checado="";
																			if("-2"==$valIdOpcion)
																			{
																				$checado="checked='checked'";
																			}
																			$cadResp.="<option ".$checado." puntaje='0' value='-2' ctrlNoAplica='1'>No aplica</option>";
																		}
																	}
																	$cadResp.="</select>";
																}
																else
																{
																	$cadResp="<table>";
																	$col=0;
																	
																	foreach($arrElementos["escalas"] as $e=>$texto)
																	{
																		if($col==0)
																			$cadResp.="<tr>";
																		$checado="";
																		if($e==$valIdOpcion)
																		{
																			$checado="checked='checked'";
																		}
																		$cadResp.="<td  style='text-align:justify'><span class='".$arrEstilos[$claseRespuesta]."'>".$campoHidden."<input onClick='respuestaSel(this)' name='rdo_".$fila[10]."'  type='radio' ".$checado." puntaje='".$texto[2]."'  value='".$e."'> ".$texto[0]."</span></td><td width='5'></td>";
																		$campoHidden="";
																		$col++;
																		if($col==$nColumnas)
																		{
																			$cadResp.="</tr>";
																			$col=0;
																		}
																	}
																	if($incluirValorNoAplica==1)
																	{
																		if($col==0)
																			$cadResp.="<tr>";
																		$checado="";
																		if("-2"==$valIdOpcion)
																		{
																			$checado="checked='checked'";
																		}
																		$cadResp.="<td  style='text-align:justify'><span class='".$arrEstilos[$claseRespuesta]."'><input ctrlNoAplica='1' onClick='respuestaSel(this)' ".$checado." name='rdo_".$fila[10]."' type='radio' puntaje='0'  value='-2'> No aplica</span></td><td width='5'></td>";
																		$col++;
																		if($col==$nColumnas)
																		{
																			$cadResp.="</tr>";
																			$col=0;
																		}
																	}
																	
																	for($x=$col;$x<=$nColumnas;$x++)
																	{
																		$cadResp.="<td></td><td width='5'></td>";
																	}
																	if($col!=0)
																		$cadResp.="</tr>";
																	$cadResp.="</table>";
																}
															}
															else
															{
																if(!isset($arrResultConsulta[$idReferenciaResp]))
																	continue;
																
																$campoTextoRespuesta=$fila[15];
																$campoIdRespuesta=$fila[16];
																$campoValorRespuesta=$fila[17];	
																
																if($presentarRespuesta==0)
																{
																	$cadResp="<select padre='e_".$codigoUnidad."' name='p_".$fila[0]."'>";
																	if(sizeof($arrElementos)>0)
																	{
																		
																		while($e=mysql_fetch_assoc($arrResultConsulta[$idReferenciaResp]["resultado"]))
																		{
																			$cadResp.="<option puntaje='".$e[$campoValorRespuesta]."' value='".$e[$campoIdRespuesta]."'>".$e[$campoTextoRespuesta]."</option>";
																		}
																		if($incluirValorNoAplica==1)
																		{
																			$cadResp.="<option puntaje='0' value='0'>No aplica</option>";
																		}
																	}
																	$cadResp.="</select>";
																}
																else
																{
																	$cadResp="<table>";
																	$col=0;
																	while($e=mysql_fetch_assoc($arrResultConsulta[$idReferenciaResp]["resultado"]))
																	{
																		if($col==0)
																			$cadResp.="<tr>";
																		$cadResp.="<td  style='text-align:justify'><span class='".$arrEstilos[$claseRespuesta]."'><input padre='e_".$codigoUnidad."' name='p_".$fila[0]."' type='radio' puntaje='".$e[$campoValorRespuesta]."'  value='".$e[$campoIdRespuesta]."'> ".$e[$campoTextoRespuesta]."</span></td><td width='5'></td>";
																		$col++;
																		if($col==$nColumnas)
																		{
																			$cadResp.="</tr>";
																			$col=0;
																		}
																	}
																	if($incluirValorNoAplica==1)
																	{
																		if($col==0)
																			$cadResp.="<tr>";
																		$cadResp.="<td  style='text-align:justify'><span class='".$arrEstilos[$claseRespuesta]."'><input padre='e_".$codigoUnidad."' name='p_".$fila[0]."' type='radio' puntaje='0'  value='0'> No aplica</span></td><td width='5'></td>";
																		$col++;
																		if($col==$nColumnas)
																		{
																			$cadResp.="</tr>";
																			$col=0;
																		}
																	}
																	
																	for($x=$col;$x<=$nColumnas;$x++)
																	{
																		$cadResp.="<td></td><td width='5'></td>";
																	}
																	if($col!=0)
																		$cadResp.="</tr>";
																	$cadResp.="</table>";
																}
																
															}
															echo $cadResp;
													?>	
														</td>
                                                        
													</tr>
                                                    <tr height="10">	
                                                    	<td colspan="2"></td>
                                                     </tr>
											<?php
													break;
													case 4:
													
														if(($valPregunta==0)&&($idRegistro==-1))
															$valPregunta="";
													
														?>
														<tr>
															<td>
															
															</td>
															<td align="left" colspan="2">
                                                            	<textarea <?php echo ($vistaDiseno==1)?"readOnly='readOnly'":"" ?> style="height:80px; width:650px" id="txtArea_p_<?php echo $fila[10] ?>" class="<?php echo $arrEstilos[$fila[8]]?>"><?php echo str_replace("<br />","\n",$valPregunta) ?></textarea>
																<?php
																	
																	$valMaxEsperado=dibujarElementosHijos($fila[10],$fila[12]);
																	$campoHidden='<input type="hidden" ponderacionElemento="'.$ponderacionHijos.'" tipo="'.$fila[2].'"  padre="p_'.$codigoUnidad.'" name="p_'.$fila[10].'" id="p_'.$fila[10].'" value="'.$valPregunta.'" ponderacionHijos="'.$fila[12].'" valorPregunta="'.$fila[5].'" valorMaxEsperado="'.$valMaxEsperado.'">';
																	echo $campoHidden;
																?>
															</td>
															
														</tr>
												<?php
													break;
												}
											
												
											?>
											
											
										</table>
                                       
									
							<?php
								}
								echo "<br><br>";
								
								return $valMax;
							}
						
						
							$idUsuario=$_SESSION["idUsuario"];
							if(isset($objParametros->idUsuario))
								$idUsuario=$objParametros->idUsuario;
						
							$idCuestionario=-1;
							if(isset($objParametros->idCuestionario))
								$idCuestionario=$objParametros->idCuestionario;
							
							$idRegistro=-1;
							if(isset($objParametros->idRegistro))
								$idRegistro=$objParametros->idRegistro;
								
							$idReferencia1=-1;
							if(isset($objParametros->idReferencia1))
								$idReferencia1=$objParametros->idReferencia1;
							$idReferencia2=-1;
							if(isset($objParametros->idReferencia2))
								$idReferencia2=$objParametros->idReferencia2;

							$vistaDiseno=0;
							if(isset($objParametros->vistaDiseno))
								$vistaDiseno=$objParametros->vistaDiseno;	
							
							$esEvaluacionComite=0;
							if(isset($objParametros->esEvaluacionComite))
								$esEvaluacionComite=$objParametros->esEvaluacionComite;
													
							$consulta="SELECT * FROM 9051_cuestionarios where idCuestionario=".$idCuestionario;
							$fCuestionario=$con->obtenerPrimeraFila($consulta);
							$cveElemento=str_pad($idCuestionario,4,"0",STR_PAD_LEFT);
							$solicitarComentariosFinales=$fCuestionario[8];
							$mostrarPuntajeObtenido=$fCuestionario[9];
							$mostrarPuntaje="";
							$mostrarComentarios="";
							if($mostrarPuntajeObtenido==0)
								$mostrarPuntaje="none";
							if($solicitarComentariosFinales==0)
								$mostrarComentarios="none";
							$query="select idEstilo,nombreEstilo from 932_estilos order by nombreEstilo";
							$arrEstilos=$con->obtenerFilasArregloAsocPHP($query);
							$arrEscalas=array();
							$query="SELECT idEscalaCalificacion,nombreEscala FROM 4032_escalasCalificacion ORDER BY nombreEscala";
							$resEscala=$con->obtenerFilas($query,true);
							while($fila=mysql_fetch_row($resEscala))
							{
								$query="SELECT idElementoEscala,etiqueta,valorMinimo,valorMaximo FROM 4033_elementosEscala WHERE idEscalaCalificacion=".$fila[0];
								$arrEscalasValor=$con->obtenerFilasArregloAsocPHP($query,true);
								$query="SELECT max(valorMaximo) FROM 4033_elementosEscala WHERE idEscalaCalificacion=".$fila[0];
								$valMaximo=$con->obtenerValor($query);
								$arrEscalas[$fila[0]]["nombre"]=$fila[1];
								$arrEscalas[$fila[0]]["escalas"]=$arrEscalasValor;
								$arrEscalas[$fila[0]]["valMaximo"]=$valMaximo;
							}
							
							$cadObj='{}';
							$paramObj=json_decode($cadObj);
							$arrResultConsulta=resolverQueries($idCuestionario,6,$paramObj);
							
							$idEscala=$fCuestionario[7];
							$cadEscala="";
							if(isset($arrEscalas[$idEscala]))
							{
								
								foreach($arrEscalas[$idEscala]["escalas"] as $id=>$e)
								{
									$o="['".$id."','".$e[0]."',".$e[1].",".$e[2]."]";
									if($cadEscala=="")
										$cadEscala=$o;
									else
										$cadEscala.=",".$o;
								}
							}
							
							$consulta="SELECT calificacionFinal,dictamen,comentariosFinales FROM 9053_resultadoCuestionario WHERE idRegistroCuestionario=".$idRegistro;
							$fResultado=$con->obtenerPrimeraFila($consulta);
							if(!$fResultado)
							{
								$fResultado=array();
								$fResultado[0]=0;
								$fResultado[1]=0;
								$fResultado[2]="";
							}
							
							$consulta="SELECT etiqueta FROM 4033_elementosEscala WHERE idElementoEscala=".$fResultado[1];
							$dictamen=$con->obtenerValor($consulta);
							if($dictamen=="")
								$dictamen="Sin dict&aacute;men";
							$consulta="SELECT idElemento,valorRespuesta,idRespuesta,valorRespuestaTexto,
									(SELECT tipoElemento FROM 9052_elementosCuestionario WHERE idElementoCuestionario=r.idElemento) as tipoControl  
									FROM 9054_respuestasCuestionario r WHERE idReferencia=".$idRegistro;

							$arrRespuestas=$con->obtenerFilasArregloAsocPHP($consulta,true);
							

						?>
                        	<table>
                            <tr>
                            	<td align="left">
                                	<br /><br />
                                    <br /><br />
                                    <br />
                                    <table width="900">
                                        
                                        
                                        <tr>
                                            <td align="left">
                                                <?php
                                                    $valMax=dibujarElementosHijos($cveElemento,$fCuestionario[6]);
                                                ?>
                                            </td>
                                        </tr> 
                                        
                                        <tr>
                                        	<td colspan="3" align="left">
                                            	<form id="frmEnvio">
                                            	 <table>
                                                 	<tr height="21" style="display:<?php echo $mostrarPuntaje?>">
                                                    	<td valign="top" width="130">
                                                        	<span class="corpo8_bold" style="font-size:12px">Puntaje obtenido:</span>
                                                        </td>
                                                        <td align="left">
                                                        	 <?php
																$campoHidden='<input  type="hidden" ponderacionElemento="'.$fCuestionario[6].'" tipo="0"  padre="-1"  id="p_'.$cveElemento.'" value="'.$fResultado[0].'" ponderacionHijos="'.$fila[6].'" valorPregunta="'.$valMax.'" valorMaxEsperado="'.$valMax.'">';
																echo $campoHidden;
															?>
															<label id="lblValorPregunta_<?php echo $cveElemento?>" class="letraRoja" style="font-size:12px !important" valorPregunta="1" idElemento="-1"><?php echo number_format($fResultado[0],2) ?></label>
                                                        </td>
                                                    </tr>
                                                    <tr height="21" style="display:none">
                                                    	<td valign="top" width="130">
                                                        	<span class="corpo8_bold" style="font-size:12px">Dictámen:</span>
                                                        </td>
                                                        <td align="left">
                                                        	<label id="lblDictamen" class="letraRoja" style="font-size:12px !important"><?php echo $lblDictamen?></label>
                                                        </td>
                                                    </tr>
                                                 	<tr  height="21" style="display:<?php echo $mostrarComentarios?>">
                                                    	<td valign="top" width="130" colspan="2">
                                                        	<br /><span class="corpo8_bold" style="font-size:12px">Comentarios finales:</span>
                                                        </td>
                                                        
                                                    </tr>
                                                    <tr  height="21" style="display:<?php echo $mostrarComentarios?>">
                                                    	
                                                        <td align="left" colspan="2">
                                                        	<textarea id="lblComentarios" style="width:700px; height:100px;"><?php echo str_replace("<br />","\r\n",$fResultado[2])?></textarea>
                                                        </td>
                                                    </tr>
                                                    
                                                 </table>
                                                 </form>
                                            </td>
                                        </tr>
                                    </table>
                                   
                                    <input type="hidden" id="dictamen" value="<?php echo $fResultado[1]?>" />
                                    <input type="hidden" id="arrDictamen" value="<?php echo bE("[".$cadEscala."]")?>" />
                                    <input type="hidden" id="idCuestionario" value="<?php echo $idCuestionario?>" />
                                    <input type="hidden" id="idRegistro" value="<?php echo $idRegistro?>" />
                                    <input type="hidden" id="idReferencia1" value="<?php echo $idReferencia1?>" />
                                    <input type="hidden" id="idReferencia2" value="<?php echo $idReferencia2?>" />
                                    <input type="hidden" id="vistaDiseno" value="<?php echo $vistaDiseno?>" />
                                    <input type="hidden" id="esEvaluacionComite" value="<?php echo $esEvaluacionComite?>" />
                                    <input type="hidden" id="idUsuario" value="<?php echo $idUsuario?>" />
                                   
                                   
                                    
                              </td>
                           </tr>
                           
                          </table>
                        </td>
                   </tr>
                   <tr>
                           	<td colspan="2">
                            	 <div id="sticky" >
                                      <table width="100%">
                                      <tr>
                                          <td align="right">
                                              <table>
                                                  <tr>
                                                      <td><span id="contenedor1"></span></td>
                                                      <td><span id="contenedor2"></span></td>
                                                  </tr>
                                              </table>
                                          </td>
                                      </tr>
                                      </table>
                                      
                                    </div>
                            </td>
                           </tr>
				  <!-- InstanceEndEditable -->
				  <tr>
				  <td><br />
                  <?php
						if(!$ocultarFormulariosEnvio)
						{
				  ?>
                            <form method="post"	action="" id='frmEnvioDatos'>
                                <input type="hidden" name="confReferencia" value="<?php echo $nConfiguracion ?>" />
                                
                                <?php
									if($soloContenido)
									{
								?>
                                 <input type="hidden" name="cPagina" value="sFrm=true|mR1=true" />
                                <?php
									}
								?>
                                
                            </form>
                            <form method="post"	action="<?php echo $pConfRegresar?>" id='frmRegresar'>
                                <input type="hidden" name="configuracion" id="configuracionRegresar" value="<?php echo $nConfRegresar ?>" />
                            </form>
                            <form method="post"	action="<?php echo "../".$rutaNomPagina ?>" id='frmRefrescarPagina'>
                                <input type="hidden" name="configuracion" value="<?php echo $nConfiguracion ?>" />
                            </form>    
                        
				  	<?php 	
						}
					
							if(($mostrarRegresarBajo)&&(!$soloContenido))
							{
							?> 
							<table align="left" id="tblRegresar2">
							<tr>
							<td>
							<a href="<?php echo $pagRegresar ?>" class="letraVerde"><img src="../images/flechaizq.gif" border="0" /></a>
							</td>
							<td>
							<a href="<?php echo $pagRegresar ?>" class="letraVerde">&nbsp;&nbsp;<?php echo $et["regresar"] ?></a>
							</td>
							</tr>
							</table>
							<?php 
									}
							?>
				  </td>
				  </tr> 
				   </table>
				 </div>
				  </td>
				
                </tr>
              </table>
			  <div class="clearer">&nbsp;</div>
		 


			<div class="clearer">&nbsp;</div>
		</div>
	</div>
</div>
<?php
if(($mostrarPiePag)&&(!$soloContenido))
{
?>
<div id="footer">
	<div class="wrapper">
		<div class="content">

			<table width="100%">
            	<tr>
                	<td width="33%" align="left">
                        <span class="small">
                        <?php
                            echo $textoInfIzq;
                        ?>
                        </span>
                    </td>
                    <td width="34%"></td>
                    <td width="33%" align="right">
                    	<span class="small">
						<?php
                            echo $textoInfDer;
                        ?>
                        </span>
                    </td>
                    
                </tr>
            </table>
	  </div>
	</div>
</div>
<?php
}
?>
</body>
<!-- InstanceEnd --></html>
