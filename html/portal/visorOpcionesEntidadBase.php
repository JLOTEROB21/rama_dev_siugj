<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");
include_once("funcionesActores.php");
?>

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
<?php
	$guardarConfSession=true;
	$mostrarRegresar=false;
	$mostrarMenuIzq=false;
	$paramGET=true;
?>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../Scripts/masonry/jquery.masonry.min.js"></script>
<script type="text/javascript" src="../portal/Scripts/visorOpcionesEntidadBase.js.php"></script>
<style>
	.wrapper
	{
		width:100% !important;
	}
	#main_content, .p15, #example_content 
	{
		padding:0px !important;
	}

	#main_single
	{
		background:#FFFFFF !important;
	}
	.transparencia
	{
		margin-top:-180 !important; 
		float: right; 
		
		-webkit-border-radius: 10px; 
		-moz-border-radius: 10px; 
		
		color:#FFF;
		font-weight:bold;
		padding:2px 10px 2px 10px;
		/*filter: alpha(opacity=50);
		-khtml-opacity: 0.5; 
		-moz-opacity: 0.5;
		opacity: 0.5; 
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)"*/
	}
	
	.transparencia2
	{
		
		/*filter: alpha(opacity=100) !important;
		-khtml-opacity: 1 !important; 
		-moz-opacity: 1 !important;
		opacity: 1 !important; 
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)" !important;*/
	}
	
	.transparencia2 a
	{
		color:#F00 !important;
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
                        <td>
                        <div id="container" class="clearfix">
                        	<?php
								$cadJavaParam="";
								$arrParam1=array();
								$reflectionClase = new ReflectionObject($objParametros);
								foreach ($reflectionClase->getProperties() as $property => $value) 
								{
									$nombre=$value->getName();
									$valor=$value->getValue($objParametros);
									if(($nombre!="paginaConf")&&($nombre!="configuracion")&&($nombre!="cPagina")&&($nombre!="iframe")&&($nombre!="mostrarRegresar"))
									{
										$arrParam1[$nombre]=$valor;
										
										$cadJavaParam.=",['".$nombre."','".cv($valor)."']";
										
									}
	
								}
								
								$cadJavaParam=substr($cadJavaParam,1);
								$cadJavaParam="".$cadJavaParam."";
								$objRef=NULL;
								$arrMenu="";
								$totalReg=0;
								$consulta="SELECT t.idMenu,textoMenu,colorFondo,idFuncionVisualiza,idFuncionRenderer,clase 
										FROM 813_paginasVSOpciones p,808_titulosMenu t WHERE 
										posicion=6 AND t.idMenu=p.idOpcion ORDER BY prioridad,textoMenu";
								$res=$con->obtenerFilas($consulta);
								while($fila=mysql_fetch_row($res))
								{
									$tblMenu="";
									
									$mostrarMenu=true;
									
									$consulta="SELECT COUNT(idOpcion) FROM 812_permisosOpcionesMenus WHERE idOpcion=".$fila[0]." 
											AND  idRol IN(".$_SESSION["idRol"].")";
									
									$nReg=$con->obtenerValor($consulta);
									if($nReg==0)
										$mostrarMenu=false;
									
									if((!$mostrarMenu)&&($fila[3]!="")&&($fila[3]!="-1"))
									{
										$cadObj='{"idMenu":"'.$fila[0].'","param1":null}';
										$obj=json_decode($cadObj);
										$obj->param1=$arrParam1;
										$resultado=removerComillasLimite(resolverExpresionCalculoPHP($fila[3],$obj,$objRef));
						
										if($resultado==0)
											$mostrarMenu=false;
										else
											$mostrarMenu=true;
									}
									
									if(!$mostrarMenu)
										continue;
									if(($fila[4]=="")||($fila[4]=="-1"))
									{
										$linkEnlace="";
										$opciones="";
										$consulta="SELECT o.* FROM 811_menusVSOpciones m,809_opciones o WHERE idMenu=".$fila[0]." 
													AND o.idOpcion=m.idOpcion ORDER BY orden";
										$resOpt=$con->obtenerFilas($consulta);
										while($filaOpt=mysql_fetch_row($resOpt))
										{
											$o="";
											$mostrarOpcion=true;
											$txtComplementario="";
											$paramComplementario=array();
											$mostrarSoloTexto=false;
											$paramBase=$cadJavaParam;
											if(($filaOpt[12]!="")&&($filaOpt[12]!="-1"))
											{
												$cadObj='{"idOpcion":"'.$filaOpt[0].'","param1":null}';
										
												$obj=json_decode($cadObj);
												$obj->param1=$arrParam1;
												$resultado=resolverExpresionCalculoPHP($filaOpt[12],$obj,$objRef);
												if(gettype($resultado)=="array")
												{
													if(isset($resultado["mensaje"]))
													{
														$txtComplementario=$resultado["mensaje"];
														$mostrarSoloTexto=true;
													}
													if(!isset($resultado["mostrarOpcion"]))
													{
														$mostrarOpcion=true;
													}
													else
													{
														if($resultado["mostrarOpcion"]!=1)
														{
															$mostrarOpcion=false;
															
														}
														
													}
													if(isset($resultado["params"])&&(sizeof($resultado["params"]>0)))
													{
														foreach($resultado["params"] as $p)
														{
															$paramBase.=",['".$p["parametro"]."','".$p["valor"]."']";
														}
													}
													
														
												}
												else
												{
													$resultado=removerComillasLimite($removerComillasLimite);
													if($resultado==0)
														$mostrarOpcion=false;
												}
											}
											if((!$mostrarOpcion)&&(!$mostrarSoloTexto))
												continue;
											if(($filaOpt[13]=="")||($filaOpt[13]=="-1"))
											{
												$compTxto="";
												if($mostrarSoloTexto)
													$compTxto='&nbsp;<img src="../images/icon_comment.gif" title="'.cv($txtComplementario).'" alt="'.cv($txtComplementario).'">';
												if($mostrarOpcion)
												{
													if(strpos($filaOpt[2],"?idFormulario"))
													{
														
														$arrOpciones=explode('=',$filaOpt[2]);
														$idFormulario=$arrOpciones[1];
														if(strpos($filaOpt[2],"administrarHorarioUnidadApartado.php"))
															$linkEnlace='enviarFormularioAdmon('.$idFormulario.')';
														else
															$linkEnlace='enviarFormulario('.$idFormulario.')';
													}
													else
													{
														if(strpos($filaOpt[2],"?idTipoProyecto"))
														{
															$arrOpciones=explode('=',$filaOpt[2]);
															$idTipoProyecto=$arrOpciones[1];
															
														}
														else
														{
															if(strpos($filaOpt[2],"javascript")===false)
																$linkEnlace='abrirUrl("'.$filaOpt[2].'")';
															else
															{
																
																$linkEnlace=$filaOpt[2];
																
															}
														}
													}
													$linkEnlace=str_replace("@param",bE("[".$paramBase."]"),$linkEnlace);
													$claseOpcion="bg_list_un";
													if($filaOpt[14]!="")
														$claseOpcion=$filaOpt[14];
													$imgBullet="";
													if($filaOpt[9]!="")
														$imgBullet="<img src='../media/verBullet.php?id=".$filaOpt[0]."' width='16' height='16'> ";
													$o=	'<li >'.
															'<table><tr height=\'21\'><td width=\'20\'>'.$imgBullet.'</td><td><a onclick='.$linkEnlace.' style=\'cursor:pointer; cursor: hand;\'><span class=\''.$claseOpcion.'\'>'.$filaOpt[1].$compTxto.'</span></a></td></tr></table>'.
														'</li>';
												}
												else
												{
													$o=	'<li >'.
															'<table><tr height=\'21\'><td width=\'20\'>'.$imgBullet.'</td><td><span class=\''.$claseOpcion.'\'>'.$filaOpt[1].$compTxto.'</span></td></tr></table>'.
														'</li>';
												}
											}
											else
											{
												$cadObj='{"idOpcion":"'.$filaOpt[0].'","param1":null}';
												$obj=json_decode($cadObj);
												$obj->param1=$arrParam1;
												$tblOpcion=removerComillasLimite(resolverExpresionCalculoPHP($filaOpt[13],$obj,$objRef));
												$o='<li>'.$tblOpcion.'</li>';
											}
											$opciones.=$o;
										}	
										$claseMenu="current";
										if($fila[5]!="")
											$claseMenu=$fila[5];
										$tblMenu='<div class=\'cBox\'><table width=\'250\'>'.
													'<tr>'.
														'<td >'.
															'<ul id=\'menu_'.$nReg.'\'>'.
																'<li  >'.
																	'<a href=\'#\'><span class=\''.$claseMenu.'\' style=\'display:inline-block; \'>'.$fila[1].'</span></a>'.
																	'<ul>'.
																		$opciones.
																	'</ul>'.
																'</li>'.
															'</ul>'.
														'</td>'.
													'</tr>'.
												'</table></div>';
									}
									else
									{
										$cadObj='{"idMenu":"'.$fila[0].'","param1":null}';
										$obj=json_decode($cadObj);
										$obj->param1=$arrParam1;
										$paramBase=$cadJavaParam;
										$tblMenuAux=removerComillasLimite(resolverExpresionCalculoPHP($fila[4],$obj,$objRef));
										$tblMenu='<div class=\'cBox\'>'.str_replace("@param",bE("[".$paramBase."]"),$tblMenuAux).'</div>';
									}
									
									$totalReg++;
									echo $tblMenu;
								}
							?>
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
