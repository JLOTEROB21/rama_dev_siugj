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

<?php
	$paramGET=true;
?>

<style>
	body
	{
		min-height:480px;
	}
	
	.x-form-cb-label 
	{
    
   	 font-size: 11px;
	}
</style>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../Scripts/jquery.min.js"></script>
<script type="text/javascript" src="../Scripts/fullcalendar/lib/moment.min.js"></script>
<script type="text/javascript" src="../Scripts/ux/checkColumn.js"></script>
<script type="text/javascript" src="../Scripts/funcionesAjaxV2.js"></script>
<script type="text/javascript" src="../modulosEspeciales_SGJP/Scripts/tblAgendaEventosPenalTradicional.js.php"></script>


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
                        <td align="left">
                        <?php
							$fechaAudiencia="";
							$idFormulario=185;
							if(isset($objParametros->idFormulario))
								$idFormulario=$objParametros->idFormulario;
							
							$idRegistro=38879;
							if(isset($objParametros->idRegistro))
								$idRegistro=$objParametros->idRegistro;
							
							$sL=-1;
							if(isset($objParametros->sL))
								$sL=$objParametros->sL;
							
							$consulta="SELECT carpetaAdministrativa,idCarpetaAdministrativa FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
							$fCarpeta=$con->obtenerPrimeraFila($consulta);
							$carpetaAdministrativa=$fCarpeta[0];
							
							
							$consulta="SELECT id__17_tablaDinamica,u.idReferencia,c.tipoCarpetaAdministrativa,c.idJuezTitular FROM 7006_carpetasAdministrativas c,_17_tablaDinamica u WHERE 
									carpetaAdministrativa='".$carpetaAdministrativa."' and c.idCarpeta=".$fCarpeta[1]." AND claveUnidad=c.unidadGestion";
							$fUnidadGestion=$con->obtenerPrimeraFila($consulta);

							$idUnidadGestion=$fUnidadGestion[0];
							$idEdificio=$fUnidadGestion[1];
							$tipoCarpetaAdministrativa=$fUnidadGestion[2];
							$idJuezResponsableCarpeta=$fUnidadGestion[3]==""?-1:$fUnidadGestion[3];
							
							
							$consulta="SELECT * FROM 7000_eventosAudiencia WHERE idFormulario=".$idFormulario." AND idRegistroSolicitud=".$idRegistro;
							$fEvento=$con->obtenerPrimeraFilaAsoc($consulta);

							if(($fEvento)&&($fEvento["situacion"]>=2))
							{
								$sL=1;
							}
							$duracionAudiencia=0;
							$tipoAudiencia="";
							if($fEvento["tipoAudiencia"]!="")
							{
								$tipoAudiencia=$fEvento["tipoAudiencia"];
								$fechaAudiencia=$fEvento["fechaEvento"];
								if($fEvento["horaInicioEvento"]!="")
								{
									$duracionAudiencia=obtenerDiferenciaMinutos($fEvento["horaInicioEvento"],$fEvento["horaFinEvento"]);
								}
							}
							else
							{
								if($idFormulario==185)
								{
									
									$consulta="SELECT * FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$idRegistro;
									$fSolicitud=$con->obtenerPrimeraFilaAsoc($consulta);
									$tipoAudiencia=$fSolicitud["tipoAudiencia"];
									if($fSolicitud["parametrosFechaMinima"]==1)
										$fechaAudiencia=$fSolicitud["fechaEstimadaAudiencia"];
								}
							}

							if($duracionAudiencia==0)
							{
								$consulta="SELECT promedioDuracion FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$tipoAudiencia;
								$duracionAudiencia=$con->obtenerValor($consulta);
							}
							
							if($fEvento && $fEvento["idEdificio"]!="" &&  $fEvento["idEdificio"]!="-1")
								$idEdificio=$fEvento["idEdificio"];
							
							$idJuezOriginal=-1;
							$idJuezOriginal=-1;
							$consulta="SELECT idJuez,noJuez,tipoJuez,titulo,serieRonda,noRonda FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".($fEvento?$fEvento["idRegistroEvento"]:-1);
							$fJuez=$con->obtenerPrimeraFila($consulta);

							if(!$fJuez)
							{
								if($idFormulario==185)
								{
									
									$consulta="SELECT * FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$idRegistro;
									$fSolicitud=$con->obtenerPrimeraFilaAsoc($consulta);
									
									if($fSolicitud["parametrosFechaMinima"]==1)
									{
										
										$fJuez[0]=(($fSolicitud["juezAsignar"]==0)||($fSolicitud["juezAsignar"]==""))?-1:$fSolicitud["juezAsignar"];
										$fJuez[1]="";
										if($fJuez[0]!=-1)
										{
											$consulta="SELECT clave FROM _26_tablaDinamica WHERE usuarioJuez=".$fJuez[0]." AND idReferencia=".$idUnidadGestion;

											$fJuez[1]=$con->obtenerValor($consulta);
										}
										
										$consulta="SELECT  tipoAtencion FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fSolicitud["tipoAudiencia"];
										$fDatosTipoAudiencia=$con->obtenerPrimeraFila($consulta);
										$categoriaAudiencia=$fDatosTipoAudiencia[0]==2?"AU":"AN";
										
										$consulta="SELECT tipoJuez,titulo FROM _4_gridJuecesRequeridos WHERE idReferencia=".$fSolicitud["tipoAudiencia"];

										$fTipoJuez=$con->obtenerPrimeraFila($consulta);
										
										if(isset($arrAudienciasIntermedias[$fSolicitud["tipoAudiencia"]]))
										{
											$categoriaAudiencia="I";
										}
										else
										{

											if($fSolicitud["idEventoReferencia"]!="")
											{
												$fDatosSolicitudAuxiliar=$fSolicitud;
												$encontrado=false;
												while(!$encontrado)
												{
													
													$consulta="SELECT tipoAudiencia,idRegistroEvento,idFormulario,idRegistroSolicitud FROM 
																7000_eventosAudiencia WHERE idRegistroEvento=".$fDatosSolicitudAuxiliar["idEventoReferencia"];

													$fDatosEventoBusqueda=$con->obtenerPrimeraFila($consulta);
													$tAudiencia=$fDatosEventoBusqueda[0];
													if(isset($arrAudienciasIntermedias[$tAudiencia]))
													{
														$categoriaAudiencia="IC";
														$encontrado=true;
													}
													else
													{
														if((($tAudiencia==25)||($tAudiencia==203))&&($fDatosEventoBusqueda[2]==185))
														{
															$consulta="SELECT * FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fDatosEventoBusqueda[3];

															$fDatosSolicitudAuxiliar=$con->obtenerPrimeraFilaAsoc($consulta);
															if($fDatosSolicitudAuxiliar["idEventoReferencia"]=="")
															{
																$encontrado=true;
															}
														}
														else
														{
															$encontrado=true;
														}
													}
												}
											}
										}
										
										
										$fJuez[2]=$fTipoJuez[0];
										$fJuez[3]=$fTipoJuez[1];
										$fJuez[4]=$categoriaAudiencia."_D";
										$fJuez[5]="0";
									}
								}
							}
							else
							{
								$idJuezOriginal=$fJuez[0];
							}

							$idJuez=$fJuez[0];
							if($idJuez=="")
								$idJuez=-1;
								
							$nombreJuez="NO ASIGNADO";
							if($idJuez!=-1)	
								$nombreJuez="[".$fJuez[1]."] ".obtenerNombreUsuario($fJuez[0]);
							
							$consulta="SELECT COUNT(*) FROM _55_tablaDinamica se,_15_tablaDinamica s WHERE se.idReferencia=".$idUnidadGestion." 
										AND salasVinculadas=s.id__15_tablaDinamica AND s.idReferencia=".$idEdificio;
							$nSalas=$con->obtenerValor($consulta);
							if($nSalas>0)
							{
								$consulta="SELECT distinct  id__15_tablaDinamica,CONCAT('[',if(s.claveSala is null,'',s.claveSala),'] ',nombreSala)  FROM _55_tablaDinamica t,
									_15_tablaDinamica s WHERE (t.idReferencia=".$idUnidadGestion." AND s.id__15_tablaDinamica=t.salasVinculadas AND s.idReferencia=".$idEdificio.")
									or (id__15_tablaDinamica in (152,154)) ORDER BY s.nombreSala";
							}
							else
							{
								$consulta="SELECT distinct id__15_tablaDinamica,CONCAT('[',if(s.claveSala is null,'',s.claveSala),'] ',nombreSala)  FROM 
									_15_tablaDinamica s WHERE s.idReferencia=".$idEdificio." or id__15_tablaDinamica in (152,154)
									
									ORDER BY s.nombreSala";
							}
							$arrSalas=$con->obtenerFilasArreglo($consulta);
							
							
							$consulta="SELECT tipoDelito FROM _17_gridDelitosAtiende WHERE idReferencia=".$idUnidadGestion;
							$listaDelitos=$con->obtenerListaValores($consulta,"'");
							if($listaDelitos=="")
								$listaDelitos=-1;
							
							
							switch($idFormulario)
							{
								case 46:
									$consulta="SELECT id__4_tablaDinamica,tipoAudiencia,promedioDuracion FROM _4_tablaDinamica a,_4_tiposUGJ u,_4_chkCategoriaAudiencia t 
										WHERE u.idPadre=a.id__4_tablaDinamica and t.idPadre=a.id__4_tablaDinamica AND 
										u.idOpcion in(".$listaDelitos.") and t.idOpcion=10";
								break;
								default:
									$consulta="SELECT id__4_tablaDinamica,tipoAudiencia,promedioDuracion FROM _4_tablaDinamica a,_4_tiposUGJ u,_4_chkCategoriaAudiencia t 
										WHERE u.idPadre=a.id__4_tablaDinamica and t.idPadre=a.id__4_tablaDinamica AND 
										u.idOpcion in(".$listaDelitos.") and t.idOpcion=".$tipoCarpetaAdministrativa;
								break;
							}
							
							$consulta="SELECT id__4_tablaDinamica,tipoAudiencia,promedioDuracion FROM _4_tablaDinamica a";
										
							
							$arrTipoAudiencia=$con->obtenerFilasArreglo($consulta);
							
                        	echo formatearTituloPagina($tituloModulo);
                        ?>
                        <input type="hidden" id="idFormulario" value="<?php echo $idFormulario?>" />
                        <input type="hidden" id="idRegistro" value="<?php echo $idRegistro?>" />
                        <input type="hidden" id="sL" value="<?php echo $sL?>" />
                        <input type="hidden" id="carpetaAdministrativa" value="<?php echo $carpetaAdministrativa?>" />
                        <input type="hidden" id="idJuez" value="<?php echo $idJuez?>" />
                        <input type="hidden" id="idJuezOriginal" value="<?php echo $idJuezOriginal?>" />
                        <input type="hidden" id="nombreJuez" value="<?php echo bE($nombreJuez)?>" />
                        <input type="hidden" id="fechaAudiencia" value="<?php echo ($fechaAudiencia=="")?date("Y-m-d"):$fechaAudiencia?>" />
                        <input type="hidden" id="horaInicio" value="<?php echo ($fEvento["horaInicioEvento"]!=""?date("H:i",strtotime($fEvento["horaInicioEvento"])):"")?>" />
                        <input type="hidden" id="horaFin" value="<?php echo ($fEvento["horaFinEvento"]!=""?date("H:i",strtotime($fEvento["horaFinEvento"])):"")?>" />
                        <input type="hidden" id="idEdificio" value="<?php echo $idEdificio?>" />
                        <input type="hidden" id="idSala" value="<?php echo $fEvento["idSala"]?>" />
                        <input type="hidden" id="idRegistroEvento" value="<?php echo $fEvento?$fEvento["idRegistroEvento"]:-1 ?>" />
                        <input type="hidden" id="tipoAudiencia" value="<?php echo $tipoAudiencia ?>" />
                        <input type="hidden" id="idUnidadGestion" value="<?php echo $idUnidadGestion ?>" />
                        <input type="hidden" id="arrSalas" value="<?php echo bE($arrSalas) ?>" />
                        <input type="hidden" id="arrTipoAudiencia" value="<?php echo bE($arrTipoAudiencia) ?>" />
                        <input type="hidden" id="situacionAudiencia" value="<?php echo $fEvento["situacion"]==""?0:$fEvento["situacion"] ?>" />
                       	<input type="hidden" id="tipoJuez" value="<?php echo $fJuez[2]?>" />
                        <input type="hidden" id="participacion" value="<?php echo $fJuez[3]?>" />
                        <input type="hidden" id="serieRonda" value="<?php echo $fJuez[4]?>" />
                        <input type="hidden" id="noRonda" value="<?php echo $fJuez[5]?>" />
                        <input type="hidden" id="pagoAdeudo" value="0" />
                        <input type="hidden" id="arrJuecesBloquear" value="" />
                        <input type="hidden" id="arrJuecesExcusa" value="" />
                        <input type="hidden" id="duracionAudiencia" value="<?php echo $duracionAudiencia?>" />
                        <input type="hidden" id="arrJuezOriginal" value="" />
                        <input type="hidden" id="tipoCarpetaAdministrativa" value="<?php echo $tipoCarpetaAdministrativa?>" />
                        <input type="hidden" id="idJuezResponsableCarpeta" value="<?php echo $idJuezResponsableCarpeta?>" />
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
