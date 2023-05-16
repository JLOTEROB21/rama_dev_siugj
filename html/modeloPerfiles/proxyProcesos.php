<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");

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
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../modeloPerfiles/Scripts/proxyProcesos.js.php"></script>
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
							$idProceso="-1";
							$actor="";
							$vista="";
							$vComp="";
							$ciclo="";
							$idActorProcesoEtapa="";
							if(isset($objParametros->vista))
								$vista=base64_decode($objParametros->vista);
							if(isset($objParametros->idProceso))
								$idProceso=base64_decode($objParametros->idProceso);
							if(isset($objParametros->actor))
								$actor=base64_decode($objParametros->actor);
							$numEtapa="-1";
							if(isset($objParametros->numEtapa))
								$numEtapa=base64_decode($objParametros->numEtapa);
							if(isset($objParametros->vComp))
								$vComp=$objParametros->vComp;
							if(isset($objParametros->ciclo))
								$ciclo=$objParametros->ciclo;
							$tProceso=obtenerTipoProceso($idProceso);	
							$arrParam=array();
							$reenviar=true;
							$idFormulario=-1;
							if(isset($objParametros->idFormulario))
								$idFormulario=$objParametros->idFormulario;
							$idReferencia=-1;
							if(isset($objParametros->idReferencia))
								$idReferencia=$objParametros->idReferencia;
								
							switch($tProceso)
							{
								case 55:
									$pagRedireccion="../recursosHumanos/registroRopaje.php";
									$arrParam[0][0]="cPagina";
									$arrParam[0][1]="sFrm=true";
								break;
								case 28:
									$pagRedireccion="../recursosHumanos/listadoVacantes.php";
									$arrParam[0][0]="actor";
									$arrParam[0][1]=base64_encode($actor);
									$arrParam[1][0]="numEtapa";
									$arrParam[1][1]=base64_encode($numEtapa);
									$arrParam[2][0]="idProceso";
									$arrParam[2][1]=base64_encode($idProceso);
									$arrParam[3][0]="cPagina";
									$arrParam[3][1]="sFrm=true";
								break;
								case 21:
									$pagRedireccion="../presupuesto/interfaceRequisicion.php";
									$arrParam[0][0]="actor";
									$arrParam[0][1]=base64_encode($actor);
									$arrParam[1][0]="numEtapa";
									$arrParam[1][1]=base64_encode($numEtapa);
									$arrParam[2][0]="idProceso";
									$arrParam[2][1]=base64_encode($idProceso);
									$arrParam[3][0]="cPagina";
									$arrParam[3][1]="sFrm=true";
								break;
								case 9:
									
									if($actor=='36_0')
									{
										$pagRedireccion="../planeacion/deteccionNecesidadesValidacion.php";
										$numEtapa=2;
									}
									//$pagRedireccion="../planeacion/interfaceDeteccionNecesidades.php";
									$arrParam[0][0]="actor";
									$arrParam[0][1]=base64_encode($actor);
									$arrParam[1][0]="numEtapa";
									$arrParam[1][1]=base64_encode($numEtapa);
									$arrParam[2][0]="idProceso";
									$arrParam[2][1]=base64_encode($idProceso);
									$arrParam[3][0]="cPagina";
									$arrParam[3][1]="sFrm=true";
									$arrParam[4][0]="ciclo";
									$arrParam[4][1]=$ciclo;
									$arrParamJS="";
									$capitulo="";
									if(($capitulo=="")&&($actor!='36_0'))
									{
										if($actor!="")
										{
											$pagRedireccion="../planeacion/interfaceDeteccionNecesidades.php";
											$consulta="SELECT codigoDepto,idPrograma,r.ruta FROM 9116_responsablesPAT r,9117_estructurasVSPrograma e WHERE e.ruta=r.ruta and r.idPrograma=e.idProgramaInstitucional and e.ciclo=".$ciclo." and idProceso=".$idProceso." and  rolActor='".$actor."' AND idResponsable=".$_SESSION["idUsr"];
										}
										else
										{
											$pagRedireccion="../planeacion/deteccionNecesidades3000.php";
											$consulta="SELECT codigoDepto,idPrograma,r.ruta FROM 9116_responsablesPAT r,9117_estructurasVSPrograma e WHERE e.ruta=r.ruta and r.idPrograma=e.idProgramaInstitucional and idProceso=".$idProceso." and  idResponsable=".$_SESSION["idUsr"];
										}
										
										  $resPermisos=$con->obtenerFilas($consulta);

										  switch($con->filasAfectadas)
										  {
											  case "0":
													if(isset($objParametros->arrEtapas))
													{
														$reenviar=false;
														$arrParamJS="";	
														$arrParam[5][0]="cEtapa";
														$arrParam[5][1]="1";
														
														foreach($arrParam as $param)
														{
															if($param[0]!="numEtapa")
															{
																if($arrParamJS=="")
																	$arrParamJS="['".$param[0]."','".$param[1]."']";
																else
																	$arrParamJS.=",['".$param[0]."','".$param[1]."']";
															}
														}
													
														$arrParamJS="[".$arrParamJS."]";
														echo '<input type="hidden" id="paramJS" value="'.$arrParamJS.'">';	
														echo '<input type="hidden" id="arrEtapas" value="'.bD($objParametros->arrEtapas).'">';
														echo '<input type="hidden" id="mostrarVentanaActor" value="2">';
													}
												
											  break;
											  case "1":
												  $filaInfo=mysql_fetch_row($resPermisos);
												  $arrParam[6][0]="idPrograma";
												  $arrParam[6][1]=$filaInfo[1];
												  $arrParam[5][0]="codigoUnidad";
												  $arrParam[5][1]=$filaInfo[0];
												  $arrParam[7][0]="ruta";
												  $arrParam[7][1]=$filaInfo[2];
											  break;	
											  default:
											  		$arrRutas=obtenerCodigosRutas($ciclo);
												  $arrDatos="";
												  while($filaInfo=mysql_fetch_row($resPermisos))
												  {
													  $consulta="select concat('[',codigoDepto,'] ',unidad) from 817_organigrama where codigoUnidad='".$filaInfo[0]."'";
													  $departamento=$con->obtenerValor($consulta);
													  if($filaInfo[1]==0)
														  $programa="No aplica";
													  else
													  {
														  $consulta="SELECT concat(cvePrograma,'] ',tituloPrograma)  FROM 517_programas WHERE idPrograma=".$filaInfo[1];
														  $programa=$con->obtenerValor($consulta);
													  }
													  if(isset($arrRutas[$filaInfo[2]]))
													  {
														  $obj="['".$filaInfo[0]."','".$filaInfo[2].".".$filaInfo[1]."','".$departamento."','[".$arrRutas[$filaInfo[2]]." ".$programa."']";
														  if($arrDatos=="")
															  $arrDatos=$obj;
														  else
															  $arrDatos.=",".$obj;
													  }
												  }
												  
												  $reenviar=false;
												  $arrParamJS="";
												  foreach($arrParam as $param)
												  {
													  if($arrParamJS=="")
														  $arrParamJS="['".$param[0]."','".$param[1]."']";
													  else
														  $arrParamJS.=",['".$param[0]."','".$param[1]."']";
														  
												  }
												  $arrParamJS="[".$arrParamJS."]";
												  
												  echo '<input type="hidden" id="paramJS" value="'.$arrParamJS.'">';
												  echo '<input type="hidden" id="mostrarVentanaActor" value="1">';
												  echo '<input type="hidden" id="asignaDisponibles" value="'.bE("[".$arrDatos."]").'">';
												   
											  break;
										  }
									}
									
								break;
								case 27:
									$pagRedireccion="../compras/interfaceCompras.php";
									$arrParam[0][0]="actor";
									$arrParam[0][1]=base64_encode($actor);
									$arrParam[1][0]="numEtapa";
									$arrParam[1][1]=base64_encode($numEtapa);
									$arrParam[2][0]="idProceso";
									$arrParam[2][1]=base64_encode($idProceso);
									$arrParam[3][0]="cPagina";
									$arrParam[3][1]="sFrm=true";
								break;
								default:
									
									$arrParam[0][0]="cPagina";
									$arrParam[0][1]="sFrm=true";
									$arrParam[1][0]="idProceso";
									$arrParam[1][1]=base64_encode($idProceso);
									
									switch($vista)
									{
										case 1:
											$pagRedireccion="../modeloProyectos/registros.php";
											
											$consulta="select pagPrincipalReg from 921_tiposProceso where idTipoProceso=".$tProceso;
											$pag=$con->obtenerValor($consulta);
											if($pag!="")
												$pagRedireccion=$pag;
											$arrParam[2][0]="relacion";
											$arrParam[2][1]=$vComp;
											$arrParam[3][0]="actor";
											$arrParam[3][1]=$actor;
											$arrParam[4][0]="idFormulario";
											$arrParam[4][1]=bE($idFormulario);
											$arrParam[5][0]="idReferencia";
											$arrParam[5][1]=bE($idReferencia);
											
										break;
										case 2:
											$pagRedireccion="../modeloProyectos/registrosComite.php";
											$arrParam[2][0]="idComite";
											$arrParam[2][1]=$vComp;
										break;
										case 3:
											$pagRedireccion="../modeloProyectos/registrosUsuario.php";
											$arrParam[2][0]="actor";
											$arrParam[2][1]=$vComp;
										break;
										case 4:
											$pagRedireccion="../modeloProyectos/registrosRevisor.php";
											$arrParam[2][0]="idActorProcesoEtapa";
											$arrParam[2][1]=$vComp;
										break;
									}
									
									
								break;
							}
							
							echo '<input type="hidden" id="paginaRedireccion" value="'.$pagRedireccion.'">';
							if($reenviar)
								enviarPagina($pagRedireccion,$arrParam)
							?>
                            
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
