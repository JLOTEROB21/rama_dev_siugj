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
	$paramGET=false;
?>
<script type="text/javascript" src="../Scripts/fullcalendar/lib/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/visJS/vis-timeline-graph2d.min.css"/>
<link rel="stylesheet" type="text/css" href="../principalPortal/css/estilosTimeLine.css"/>
<script src="../Scripts/visJS/vis.js"></script>
<script src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../Scripts/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/jQueryUI/temas/smoothness/jquery-ui.css"/>
<script type="text/javascript" src="../Scripts/jQueryUI/jquery-ui.js"></script>
<link rel="stylesheet" href="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.css"  type="text/css" media="screen" />
<script type="text/javascript" src="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    
<script src="../modulosEspeciales_SGJ/Scripts/historialCarpetaJudicial.js.php"></script>

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
						
							$cJudicial="";							
							
							if(isset($objParametros->cA))
							{
								$cJudicial=bD($objParametros->cA);
							}
							
							
							$idCarpeta=-1;
							if(isset($objParametros->iC))
							{
								$idCarpeta=bD($objParametros->iC);
							}
						
							$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cJudicial."'";
							if($idCarpeta!=-1)
							{
								$consulta.=" and idCarpeta=".$idCarpeta;
							}
								
							
							$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
							$codigoUnidadCarpeta=$fRegistro["unidadGestion"];
						
							$arSituacionEvento=array();
							$consulta="SELECT descripcionSituacion,icono,idSituacion FROM 7011_situacionEventosAudiencia";
							$resEvento=$con->obtenerFilas($consulta);
							while($fila=mysql_fetch_row($resEvento))
							{
								$arSituacionEvento[$fila[2]]["icono"]=$fila[1];
								$arSituacionEvento[$fila[2]]["leyenda"]=$fila[0];
								
								
							}

							function obtenerEventosVariosCarpeta($cJudicial,&$nRegistro)
							{
								global $con;
								global $codigoUnidadCarpeta;
								$arrEventos=array();
								
								$consulta="SELECT tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cJudicial."'";
								$etapaProcesal=$con->obtenerValor($consulta);
								
								
								
								$etiquetaEvento="";
								$consulta="SELECT * FROM _632_tablaDinamica WHERE carpetaAdministrativa='".$cJudicial."' and idEstado>1";
								$res=$con->obtenerFilas($consulta);
								while($fila=mysql_fetch_assoc($res))
								{
									$consulta="SELECT fechaCreacion,responsableCreacion FROM 7006_carpetasAdministrativas  WHERE carpetaAdministrativa='".$fila["carpetaAdministrativa"]."'";
									$fDatosRegistroCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
									
									$tblDatosAudiencia='<table>'.
														'<tr height="21">'.
															'<td align="left" colspan="2"><div class="lblTituloCarpeta">'.$fila["carpetaAdministrativa"].'</div></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Tipo Evento:</div></td><td align="left" width="320" ><div class="lblCampoValor">Registro de Radicaci&oacute;n Inicial</div></td>'.
														'</tr>'.
														
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Promovente:</div></td><td align="left" width="320" ><div class="lblCampoValor">'.($fDatosRegistroCarpeta["responsableCreacion"]!=""?obtenerNombreUsuario($fDatosRegistroCarpeta["responsableCreacion"]):"NO registrado").' ('.date("d/m/Y H:i:s",strtotime($fDatosRegistroCarpeta["fechaCreacion"])).')</div></td>'.
															
														'</tr>';
														
									if($fila["id__632_tablaDinamica"]!=-1)
									{
										$tblDatosAudiencia.='<tr height="21">'.
																'<td align="center" width="320"  colspan="2"><div  class="lblVerDetalles" id="lblCtrlDetalles_'.$nRegistro.'"><a href="javascript:mostrarDetalleProceso(\''.bE(632).'\',\''.bE($fila["id__632_tablaDinamica"]).'\')">Ver detalles</a></div></td>'.
															'</tr>';
									}
									$tblDatosAudiencia.='</table>';
								
									
									$lblEvento="".$tblDatosAudiencia."<br>";
									$content=$lblEvento;
									
									
									$etiquetaEvento="Registro de Radicaci&oacute;n Inicial";
									
									$cadObj='{"id":"'.$nRegistro.'","etapaProcesal":"'.$etapaProcesal.'","etiquetaEvento":"'.cv($etiquetaEvento).'","content":"'.bE(cv($content)).'","start":"'.date("Y-m-d H:i:s",strtotime($fDatosRegistroCarpeta["fechaCreacion"])).'","className":"puntoEventoRadicacionInicial"}';

									$o=json_decode($cadObj);
									array_push($arrEventos,$o);
									$nRegistro++;
								}
								
								$consulta="SELECT * FROM _672_tablaDinamica WHERE carpetaAdministrativa='".$cJudicial."' and idEstado>1";
								$res=$con->obtenerFilas($consulta);
								while($fila=mysql_fetch_assoc($res))
								{
									
									$tblDatosAudiencia='<table>'.
														'<tr height="21">'.
															'<td align="left" colspan="2"><div class="lblTituloCarpeta">'.$fila["carpetaAdministrativa2aInstancia"].'</div></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Tipo Evento:</div></td><td align="left" width="320" ><div class="lblCampoValor">Registro de Apelaci&oacute;n</div></td>'.
														'</tr>'.
														
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Promovente:</div></td><td align="left" width="320" ><div class="lblCampoValor">'.obtenerNombreUsuario($fila["responsable"]).' ('.date("d/m/Y H:i:s",strtotime($fila["fechaCreacion"])).')</div></td>'.
															
														'</tr>';
														
														if($fila["id__672_tablaDinamica"]!=-1)
														{
															$tblDatosAudiencia.='<tr height="21">'.
																'<td align="center" width="320"  colspan="2"><div class="lblVerDetalles" id="lblCtrlDetalles_'.$nRegistro.'"><a href="javascript:mostrarDetalleProceso(\''.bE(672).'\',\''.bE($fila["id__672_tablaDinamica"]).'\')" >Ver detalles</a></div></td>'.
															'</tr>';
														}
									$tblDatosAudiencia.='</table>';
								
									
									$lblEvento="".$tblDatosAudiencia."<br>";
									$content=$lblEvento;
									
									
									$etiquetaEvento="Registro de Apelaci&oacute;n";
									
									$cadObj='{"id":"'.$nRegistro.'","etapaProcesal":"2","etiquetaEvento":"'.cv($etiquetaEvento).'","content":"'.bE(cv($content)).'","start":"'.date("Y-m-d H:i:s",strtotime($fila["fechaCreacion"])).'","className":"puntoEventoApelacion"}';
									$o=json_decode($cadObj);
									array_push($arrEventos,$o);
									$nRegistro++;
								}
								$consulta="SELECT * FROM _96_tablaDinamica WHERE carpetaAdministrativa='".$cJudicial."'";
								$res=$con->obtenerFilas($consulta);
								while($fila=mysql_fetch_assoc($res))
								{
									
									$lblPromovente=obtenerNombreUsuario($fila["responsable"]);
									
									$consulta="SELECT nombreTipoPromocion FROM _97_tablaDinamica WHERE id__97_tablaDinamica=".$fila["tipoPromociones"];
									$tipoPromocion=$con->obtenerValor($consulta);
									
									
									$tipoAudiencia="";
									
									
														
									$tblDatosAudiencia='<table>'.
														'<tr height="21">'.
															'<td align="left" colspan="2"><div class="lblTituloCarpeta">'.$fila["carpetaAdministrativa"].'</div></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Tipo Evento:</div></td><td align="left" width="320"><div class="lblCampoValor">Registro de Escrito</div></td>'.
														'</tr>'.
														
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Tipo de Escrito:</div></td><td align="left" width="320" ><div class="lblCampoValor">'.$tipoPromocion.'</div></td>'.
														'</tr>'.
														
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Promovente:</div></td><td align="left" width="320" ><div class="lblCampoValor">'.obtenerNombreUsuario($fila["responsable"]).' ('.date("d/m/Y H:i:s",strtotime($fila["fechaCreacion"])).')</div></td>'.
															
														'</tr>';
									if($fila["id__96_tablaDinamica"]!=-1)
									{
										$tblDatosAudiencia.='<tr height="21">'.
															'<td align="center" width="320"  colspan="2"><div class="lblVerDetalles"  id="lblCtrlDetalles_'.$nRegistro.'"><a href="javascript:mostrarDetalleProceso(\''.bE(96).'\',\''.bE($fila["id__96_tablaDinamica"]).'\')">Ver detalles</a></div></td>'.
															'</tr>';
									}
									$tblDatosAudiencia.='</table>';
								
									
									$lblEvento="".$tblDatosAudiencia."<br>";
									$content=$lblEvento;
									
									$etiquetaEvento="Registro de Escrito: ".$tipoPromocion;
									
									$cadObj='{"id":"'.$nRegistro.'","etapaProcesal":"'.$etapaProcesal.'","etiquetaEvento":"'.cv($etiquetaEvento).'","content":"'.bE(cv($content)).'","start":"'.date("Y-m-d H:i:s",strtotime($fila["fechaCreacion"])).'","className":"puntoEventoPromocion"}';
									$o=json_decode($cadObj);
									array_push($arrEventos,$o);
									$nRegistro++;
								}
								$consulta="SELECT * FROM _677_tablaDinamica WHERE carpetaAdministrativa='".$cJudicial."' and idEstado>1";
								$res=$con->obtenerFilas($consulta);
								while($fila=mysql_fetch_assoc($res))
								{
									
									$tblDatosAudiencia='<table>'.
														'<tr height="21">'.
															'<td align="left" colspan="2"><div class="lblTituloCarpeta">'.$fila["carpetaAdministrativa2aInstancia"].'</div></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Tipo Evento:</div></td><td align="left" width="320" ><div class="lblCampoValor">Registro de Casaci&oacute;n</div></td>'.
														'</tr>'.
														
														'<tr height="21">'.
															'<td align="left" width="80"<div class="lblCampoEtiqueta">:</div></td><td align="left" width="320" ><div class="lblCampoValor">'.obtenerNombreUsuario($fila["responsable"]).' ('.date("d/m/Y H:i:s",strtotime($fila["fechaCreacion"])).')</div></td>'.
															
														'</tr>';
									if($fila["id__677_tablaDinamica"]!=-1)
									{
										$tblDatosAudiencia.='<tr height="21">'.
																'<td align="center" width="320"  colspan="2"><div class="lblVerDetalles"  id="lblCtrlDetalles_'.$nRegistro.'"><a href="javascript:mostrarDetalleProceso(\''.bE(677).'\',\''.bE($fila["id__677_tablaDinamica"]).'\')">Ver detalles</a></div></td>'.
															'</tr>';
									}
									$tblDatosAudiencia.='</table>';
													
								
									
									$lblEvento="".$tblDatosAudiencia."<br>";
									$content=$lblEvento;
									$etiquetaEvento="Registro de Casaci&oacute;n";
									$cadObj='{"id":"'.$nRegistro.'","etapaProcesal":"3","etiquetaEvento":"'.cv($etiquetaEvento).'","content":"'.bE(cv($content)).'","start":"'.date("Y-m-d H:i:s",strtotime($fila["fechaCreacion"])).'","className":"puntoEventoCasacion"}';
									$o=json_decode($cadObj);									
									array_push($arrEventos,$o);
									$nRegistro++;
								}
								$consulta="SELECT * FROM _633_tablaDinamica WHERE carpetaAdministrativa='".$cJudicial."' and idEstado>1";
								$res=$con->obtenerFilas($consulta);
								while($fila=mysql_fetch_assoc($res))
								{
									
									$tblDatosAudiencia='<table>'.
														'<tr height="21">'.
															'<td align="left" colspan="2"><div class="lblTituloCarpeta">'.$fila["carpetaAdministrativa"].'</div></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Tipo Evento:</div></td><td align="left" width="320" ><div class="lblCampoValor">Registro de Sentencia</div></td>'.
														'</tr>'.
														
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Registrado Por:</div></td><td align="left" width="320" ><div class="lblCampoValor">'.obtenerNombreUsuario($fila["responsable"]).' ('.date("d/m/Y H:i:s",strtotime($fila["fechaCreacion"])).')</div></td>'.
															
														'</tr>';
									if($fila["id__633_tablaDinamica"]!=-1)
									{
										$tblDatosAudiencia.='<tr height="21">'.
																'<td align="center" width="320"  colspan="2"><div class="lblVerDetalles"  id="lblCtrlDetalles_'.$nRegistro.'"><a href="javascript:mostrarDetalleProceso(\''.bE(633).'\',\''.bE($fila["id__633_tablaDinamica"]).'\')">Ver detalles</a></div></td>'.
															'</tr>';
									}
									$tblDatosAudiencia.='</table>';
								
									
									$lblEvento="".$tblDatosAudiencia."<br>";
									$content=$lblEvento;
									$etiquetaEvento="Registro de Sentencia: ".$fila["carpetaAdministrativa"];
									$cadObj='{"id":"'.$nRegistro.'","etapaProcesal":"'.$etapaProcesal.'","etiquetaEvento":"'.cv($etiquetaEvento).'","content":"'.bE(cv($content)).'","start":"'.date("Y-m-d H:i:s",strtotime($fila["fechaCreacion"])).'","className":"puntoEventoPromocion"}';
									$o=json_decode($cadObj);
									array_push($arrEventos,$o);
									$nRegistro++;
								}
								
								
								$consulta="SELECT * FROM _682_tablaDinamica WHERE carpetaAdministrativa='".$cJudicial."' and idEstado>1";
								$res=$con->obtenerFilas($consulta);
								while($fila=mysql_fetch_assoc($res))
								{
									
									$tblDatosAudiencia='<table>'.
														'<tr height="21">'.
															'<td align="left" colspan="2"><div class="lblTituloCarpeta">'.$fila["carpetaAdministrativa"].'</div></span></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Tipo Evento:</div></td><td align="left" width="320" ><div class="lblCampoValor">Registro de Sentencia</div></td>'.
														'</tr>'.
														
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Registrado Por:</div></td><td align="left" width="320" ><div class="lblCampoValor">'.obtenerNombreUsuario($fila["responsable"]).' ('.date("d/m/Y H:i:s",strtotime($fila["fechaCreacion"])).')</div></td>'.
															
														'</tr>';
									if($fila["id__682_tablaDinamica"]!=-1)
									{
										$tblDatosAudiencia.='<tr height="21">'.
																'<td align="center" width="320"  colspan="2"><div class="lblVerDetalles"  id="lblCtrlDetalles_'.$nRegistro.'"><a href="javascript:mostrarDetalleProceso(\''.bE(682).'\',\''.bE($fila["id__682_tablaDinamica"]).'\')">Ver detalles</a></div></td>'.
															'</tr>';
									}
									$tblDatosAudiencia.='</table>';
								
									
									$lblEvento="".$tblDatosAudiencia."<br>";
									$content=$lblEvento;
									$etiquetaEvento="Registro de Sentencia: ".$fila["carpetaAdministrativa"];
									$cadObj='{"id":"'.$nRegistro.'","etapaProcesal":"'.$etapaProcesal.'","etiquetaEvento":"'.cv($etiquetaEvento).'","content":"'.bE(cv($content)).'","start":"'.date("Y-m-d H:i:s",strtotime($fila["fechaCreacion"])).'","className":"puntoEventoPromocion"}';
									$o=json_decode($cadObj);
									array_push($arrEventos,$o);
									$nRegistro++;
								}
								
								$consulta="SELECT * FROM _630_tablaDinamica WHERE carpetaAdministrativa='".$cJudicial."' and idEstado>1";

								$res=$con->obtenerFilas($consulta);
								while($fila=mysql_fetch_assoc($res))
								{
									$consulta="SELECT nombreActuacion FROM _624_tablaDinamica WHERE id__624_tablaDinamica=".$fila["cmbActuaciones"];
									$tActuacion=$con->obtenerValor($consulta);
									
									$tblDatosAudiencia='<table>'.
														'<tr height="21">'.
															'<td align="left" colspan="2"><div class="lblTituloCarpeta">'.$fila["carpetaAdministrativa"].']</div></span></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Tipo Evento:</div></td><td align="left" width="320" ><div class="lblCampoValor">Registro de Actuaci&oacute;n</div></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Tipo de Actuaci&oacute;n:</div></td><td align="left" width="320" ><div class="lblCampoValor">'.$tActuacion.'</div></td>'.
														'</tr>'.
														
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Registrado Por:</div></td><td align="left" width="320" ><div class="lblCampoValor">'.obtenerNombreUsuario($fila["responsable"]).' ('.date("d/m/Y H:i:s",strtotime($fila["fechaActuacion"]." ".$fila["horaActuacion"])).')</div></td>'.
															
														'</tr>';
									if($fila["id__630_tablaDinamica"]!=-1)
									{
										$tblDatosAudiencia.='<tr height="21">'.
																'<td align="center" width="320"  colspan="2"><div class="lblVerDetalles"  id="lblCtrlDetalles_'.$nRegistro.'"><a href="javascript:mostrarDetalleProceso(\''.bE(630).'\',\''.bE($fila["id__630_tablaDinamica"]).'\')" >Ver detalles</a></div></td>'.
															'</tr>';
									}
									$tblDatosAudiencia.=	'</table>';
								
									
									$lblEvento="".$tblDatosAudiencia."<br>"; 
									$content=$lblEvento;
									$etiquetaEvento="Registro de Actuaci&oacute;n: ".$tActuacion;
									$cadObj='{"id":"'.$nRegistro.'","etapaProcesal":"'.$etapaProcesal.'","etiquetaEvento":"'.cv($etiquetaEvento).'","content":"'.bE(cv($content)).'","start":"'.date("Y-m-d H:i:s",strtotime($fila["fechaActuacion"]." ".$fila["horaActuacion"])).'","className":"puntoEventoPromocion"}';
									$o=json_decode($cadObj);
									array_push($arrEventos,$o);
									$nRegistro++;
								}
								
								$consulta="SELECT * FROM _665_tablaDinamica WHERE carpetaAdministrativa='".$cJudicial."' and idEstado>1";
								$res=$con->obtenerFilas($consulta);
								while($fila=mysql_fetch_assoc($res))
								{
									
									$consulta="SELECT tipoNotificacion FROM _666_tablaDinamica WHERE id__666_tablaDinamica=".$fila["tipoNotificacion"];
									$tipoNotificacion=$con->obtenerValor($consulta);
									$tblDatosAudiencia='<table>'.
														'<tr height="21">'.
															'<td align="left" colspan="2"><div class="lblTituloCarpeta">'.$fila["carpetaAdministrativa"].'</div></span></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Tipo Evento:</div></td><td align="left" width="320" ><div class="lblCampoValor">Notificaci&oacute;n</div></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Tipo de Notificaci&oacute;n:</div></td><td align="left" width="320" ><div class="lblCampoValor">'.$tipoNotificacion.'</div></td>'.
														'</tr>'.
														
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Registrado Por:</div></td><td align="left" width="320" ><div class="lblCampoValor">'.obtenerNombreUsuario($fila["responsable"]).' ('.date("d/m/Y H:i:s",strtotime($fila["fechaCreacion"])).')</div></td>'.
															
														'</tr>';
									if($fila["id__665_tablaDinamica"]!=-1)
									{
										$tblDatosAudiencia.='<tr height="21">'.
																'<td align="center" width="320"  colspan="2"><div class="lblVerDetalles"  id="lblCtrlDetalles_'.$nRegistro.'"><a href="javascript:mostrarDetalleProceso(\''.bE(665).'\',\''.bE($fila["id__665_tablaDinamica"]).'\')">Ver detalles</a></div></td>'.
															'</tr>';
									}
									$tblDatosAudiencia.='</table>';
								
									
									$lblEvento="".$tblDatosAudiencia."<br>"; 
									$content=$lblEvento;
									$etiquetaEvento="Notificaci&oacute;n: ".$tipoNotificacion;
									$cadObj='{"id":"'.$nRegistro.'","etapaProcesal":"'.$etapaProcesal.'","etiquetaEvento":"'.cv($etiquetaEvento).'","content":"'.bE(cv($content)).'","start":"'.date("Y-m-d H:i:s",strtotime($fila["fechaCreacion"])).'","className":"puntoEventoNotificacion"}';
									$o=json_decode($cadObj);
									array_push($arrEventos,$o);
									$nRegistro++;
								}

								$consulta="SELECT * FROM _634_tablaDinamica WHERE carpetaAdministrativa='".$cJudicial."' and idEstado>1";
								$res=$con->obtenerFilas($consulta);
								while($fila=mysql_fetch_assoc($res))
								{
									
									
									$tblDatosAudiencia='<table>'.
														'<tr height="21">'.
															'<td align="left" colspan="2"><div class="lblTituloCarpeta">'.$fila["carpetaAdministrativa"].'</div></span></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Tipo Evento:</div></td><td align="left" width="320" ><div class="lblCampoValor">Cierre de Proceso Judicial</div></td>'.
														'</tr>'.
														
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Registrado Por:</div></td><td align="left" width="320" ><div class="lblCampoValor">'.obtenerNombreUsuario($fila["responsable"]).' ('.date("d/m/Y H:i:s",strtotime($fila["fechaCreacion"])).')</div></td>'.
															
														'</tr>';
									if($fila["id__634_tablaDinamica"]!=-1)
									{
										$tblDatosAudiencia.='<tr height="21">'.
																'<td align="center" width="320"  colspan="2"><div class="lblVerDetalles"  id="lblCtrlDetalles_'.$nRegistro.'"><a href="javascript:mostrarDetalleProceso(\''.bE(634).'\',\''.bE($fila["id__634_tablaDinamica"]).'\')">Ver detalles</a></div></td>'.
															'</tr>';
									}
									$tblDatosAudiencia.='</table>';
								
									
									$lblEvento="".$tblDatosAudiencia."<br>"; 
									$content=$lblEvento;
									$etiquetaEvento="Cierre de Proceso Judicial: ".$fila["carpetaAdministrativa"];
									$cadObj='{"id":"'.$nRegistro.'","etapaProcesal":"'.$etapaProcesal.'","etiquetaEvento":"'.cv($etiquetaEvento).'","content":"'.bE(cv($content)).'","start":"'.date("Y-m-d H:i:s",strtotime($fila["fechaCreacion"])).'","className":"puntoEventoCierreProceso"}';
									$o=json_decode($cadObj);
									array_push($arrEventos,$o);
									$nRegistro++;
								}

								$consulta="SELECT distinct a.idRegistro,a.carpetaAdministrativa,a.descripcion,a.valorReferencia1,a.valorReferencia2,a.fechaRegistro,
										a.tipoAlerta,
										fechaAlerta,idTitularAlerta,a.situacion,motivoCancelacion as comentariosAlerta,
										(select Nombre from 800_usuarios where idUsuario=a.responsableCancelacion) as responsableCancelacion 
										FROM 7036_alertasNotificaciones a,7037_recordatoriosPreviosNotificacion r WHERE  a.carpetaAdministrativa='".$cJudicial.
										"' and  r.idAlertaNotificacion=a.idRegistro and a.situacion in(1,3,4) and 
										(idTitularAlerta=".$_SESSION["idUsr"]." OR idTitularAlerta IS NULL)";
								$res=$con->obtenerFilas($consulta);
								while($filaAlerta=mysql_fetch_assoc($res))
								{
									
									$consulta="SELECT icono FROM 7038_tiposAlertaNotificaciones WHERE idRegistro=".$filaAlerta["tipoAlerta"];
									$icono=$con->obtenerValor($consulta);
									
									$content='<div class="lblCampoValor"><img src="'.$icono.'"> '.$filaAlerta["descripcion"]."<br>(".date("d/m/Y h:i",strtotime($filaAlerta["fechaAlerta"]))." hrs.)</div>";			
									
									$consulta="SELECT tipoAlertaNotificacion FROM 7038_tiposAlertaNotificaciones WHERE idRegistro=".$filaAlerta["tipoAlerta"];
									$tipoAlerta=$con->obtenerValor($consulta);
									$etiquetaEvento="<img src=\"".$icono."\"> Notificaci&oacute;n - ".$tipoAlerta.": ".$filaAlerta["descripcion"];

									$cadObj='{"id":"'.$nRegistro.'","etapaProcesal":"'.$etapaProcesal.'","etiquetaEvento":"'.cv($etiquetaEvento).'","content":"'.bE(cv($content)).'","start":"'.$filaAlerta["fechaAlerta"].'","className":"puntoAlerta_'.$filaAlerta["tipoAlerta"].'"}';
												
									$o=json_decode($cadObj);
									array_push($arrEventos,$o);
									$nRegistro++;
									
								}


								$consulta="SELECT * FROM 7006_registrosAsociadosCarpetaAdministrativa WHERE carpetaAdministrativa='".$cJudicial."' order by fechaRegistro";
								$res=$con->obtenerFilas($consulta);
								while($fila=mysql_fetch_assoc($res))
								{
									$consulta="SELECT * FROM _".$fila["iFormulario"]."_tablaDinamica WHERE id__".$fila["iFormulario"]."_tablaDinamica=".$fila["iRegistro"];	
									$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);	
									$tblDocumentos="";
									
									$tblDocumentos="";
									$consulta="SELECT a.idArchivo,a.nomArchivoOriginal FROM 9074_documentosRegistrosProceso d,908_archivos a WHERE 
												idFormulario=".$fila["iFormulario"]." AND idRegistro=".$fila["iRegistro"]." AND a.idArchivo=d.idDocumento ORDER BY a.nomArchivoOriginal";

									$rDocs=$con->obtenerFilas($consulta);
									while($fDoc=mysql_fetch_assoc($rDocs))
									{
										if($tblDocumentos=="")
											$tblDocumentos="<a href='javascript:mostrarVisorDocumento(\"".bE($fDoc["idArchivo"])."\")'>".$fDoc["nomArchivoOriginal"]."</a>";
										else
											$tblDocumentos.="<br><a href='javascript:mostrarVisorDocumento(\"".bE($fDoc["idArchivo"])."\")'>".$fDoc["nomArchivoOriginal"]."</a>";
									}
									
									
									if($tblDocumentos=="")
										$tblDocumentos="(Sin Documentos Asociados)";
	
									$tblDatosAudiencia='<table>'.
														'<tr height="21">'.
															'<td align="left" colspan="2"><div class="lblTituloCarpeta">'.$fila["carpetaAdministrativa"].'</div></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Tipo Evento:</div></td><td align="left" width="380" ><div class="lblCampoValor">'.cv($fila["tituloRegistroAsociado"]).'</div></td>'.
														'</tr>'.
														
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Registrado Por:</div></td><td align="left" width="320" ><div class="lblCampoValor">'.obtenerNombreUsuario($fRegistro["responsable"]).' ('.date("d/m/Y H:i:s",strtotime($fila["fechaRegistro"])).')</div></td>'.
															
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Documentos Asociados:</div></td><td align="left" width="320" ><div class="lblCampoValor">'.$tblDocumentos.'</div></td>'.
															
														'</tr>';
									if($fila["iRegistro"]!=-1)
									{
										$tblDatosAudiencia.='<tr height="21">'.
																'<td align="center" width="350"  colspan="2"><div class="lblVerDetalles"  id="lblCtrlDetalles_'.$nRegistro.'"><a href="javascript:mostrarDetalleProceso(\''.bE($fila["iFormulario"]).'\',\''.bE($fila["iRegistro"]).'\')">Ver detalles</a></div></td>'.
															'</tr>';
									}
									$tblDatosAudiencia.='</table>';
								
									
									$lblEvento="".$tblDatosAudiencia."<br>"; 
									$content=$lblEvento;
									$etiquetaEvento=$fila["tituloRegistroAsociado"].": ".$fila["carpetaAdministrativa"];
									$cadObj='{"id":"'.$nRegistro.'","etapaProcesal":"'.$etapaProcesal.'","etiquetaEvento":"'.cv($etiquetaEvento).'","content":"'.bE(cv($content)).'","start":"'.date("Y-m-d H:i:s",strtotime($fila["fechaRegistro"])).'","className":"puntoEventoCarpeta"}';
									$o=json_decode($cadObj);
									array_push($arrEventos,$o);
									$nRegistro++;
								}
								
								
								$consulta="SELECT * FROM 00013_registrosMacroProceso WHERE carpetaAdministrativa='".$cJudicial."' and codigoInstitucion='".$codigoUnidadCarpeta."'  order by fechaRegistro";

								$res=$con->obtenerFilas($consulta);
								while($fila=mysql_fetch_assoc($res))
								{

									$tblDocumentos="";
									
									
	
									$tblDatosAudiencia='<table>'.
														'<tr height="21">'.
															'<td align="left" colspan="2"><div class="lblTituloCarpeta">'.$fila["carpetaAdministrativa"].'</div></span></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Tipo Evento:</div></b></td><td align="left" width="380"><div class="lblCampoValor">'.cv($fila["lblEtiquetaRegistro"]).'</div></td>'.
														'</tr>'.
														
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Registrado Por:</div></b></span></td><td align="left" width="320" ><div class="lblCampoValor">'.obtenerNombreUsuario(($fila["idResponsable"]=="")?-1:$fila["idResponsable"]).' ('.date("d/m/Y H:i:s",strtotime($fila["fechaRegistro"])).')</div></td>'.
															
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><div class="lblCampoEtiqueta">Datos Complementarios:</div></b></span></td><td align="left" width="320"><div class="lblCampoValor">'.$fila["detalleComplementario"].'</div></td>'.
															
														'</tr>';
									if($fila["iRegistro"]!=-1)
									{					
										$tblDatosAudiencia.='<tr height="21">'.
															'<td align="center" width="350"  colspan="2"><div class="lblVerDetalles"  id="lblCtrlDetalles_'.$nRegistro.'"><a href="javascript:mostrarDetalleProceso(\''.bE($fila["iFormulario"]).'\',\''.bE($fila["iRegistro"]).'\')">Ver detalles</a></div></td>'.
															'</tr>';
									}
									$tblDatosAudiencia.=	'</table>';
								
									
									$lblEvento="".$tblDatosAudiencia."<br>"; 
									$content=$lblEvento;
									$etiquetaEvento=$fila["lblEtiquetaRegistro"].": ".$fila["carpetaAdministrativa"];
									$cadObj='{"id":"'.$nRegistro.'","etapaProcesal":"'.$etapaProcesal.'","etiquetaEvento":"'.cv($etiquetaEvento).'","content":"'.bE(cv($content)).'","start":"'.date("Y-m-d H:i:s",strtotime(($fila["fechaCambioSituacion"]!=""?$fila["fechaCambioSituacion"]:($fila["fechaMaximaAtencion"]==""?$fila["fechaRegistro"]:$fila["fechaMaximaAtencion"])))).'","className":"puntoEventoCarpeta"}';
									$o=json_decode($cadObj);
									array_push($arrEventos,$o);
									$nRegistro++;
								}
								
								
								return $arrEventos;
							}
							
							function generarPlantillaEvento($nRegistro,$o,$clase)///ok
							{
								global $arSituacionEvento ;
								$oElemento="";
									
								$lblDocumentos="";
								foreach($o["arrDocumentos"] as $d)
								{
									$arrExtension=explode(".",$d[1]);
									$extension=strtolower($arrExtension[sizeof($arrExtension)-1]);
									if($extension=="jpeg")
										$extension="jpg";
									$oDoc='<tr height="21"><td width="20"><a href="javascript:mostrarVisorDocumento(\\\''.bE($d[0]).'\\\')"><img src="../imagenesDocumentos/16/file_extension_'.$extension.'.png"></a></td><td><div class="lblCampoValor"><a href="javascript:mostrarVisorDocumento(\\\''.bE($d[0]).'\\\')">'.$d["1"].'</a></div></td></tr>'	;
									if($lblDocumentos=="")
										$lblDocumentos=$oDoc;
									else
										$lblDocumentos.="<br>".$oDoc;
								}
								if($lblDocumentos!="")
									$lblDocumentos="<table>".$lblDocumentos."</table>";
								else
									$lblDocumentos="<table>(Sin documentos)</table>";
									
								$lblGrabacion="(No registrado)";
								if($o["urlVideo"]!="")
									$lblGrabacion	='<table><tr><td><div class="lblCampoValor"><a href="javascript:abrirVideoGrabacion(\\\''.bE($o["idEventoAudiencia"]).'\\\')"><img src="../images/control_play_blue.png"></a></td><td>&nbsp;&nbsp;<a href="javascript:abrirVideoGrabacion(\\\''.bE($o["idEventoAudiencia"]).'\\\')">Ver grabaci&oacute;n</a></div></td></tr></table>';
									
									
								$lblResultadoAudiencia="";
								
								
								
								$tblDatosAudiencia='<table>'.
														'<tr height="21">'.
															'<td align="left" colspan="2"><div class="lblCampoEtiqueta">'.$o["carpetaJudicial"].']</div>, <div class="lblCampoEtiqueta">ID de Evento: '.$o["idEventoAudiencia"].'</div></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" colspan="2"><div class="lblCampoEtiqueta">'.$o["fechaAudiencia"].'</div></td>'.
														'</tr>'.
														
														'<tr height="21">'.
															'<td align="left" colspan="2"><div class="lblCampoEtiqueta">Situaci&oacute;n del Evento:&nbsp;<img src="'.$arSituacionEvento[$o["situacion"]]["icono"].'" width="14" height="14"></div><div class="lblCampoValor">'.$arSituacionEvento [$o["situacion"]]["leyenda"].'</div></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" colspan="2"><div class="lblCampoEtiqueta">'.$o["tipoAudiencia"].'</div></td>'.
															
														'</tr>'.
														'<tr height="21">'.
															'<td align="center" colspan="2"><div class="lblVerDetalles"  id="lblCtrlDetalles_'.$nRegistro.'"><a href="javascript:mostrarDetalle('.$nRegistro.')">Ver detalles</a></div><br></td>'.
															
														'</tr>'.
														
														
													'</table>';
								$tblDatosAudienciaComp=
														'<span id="sp'.$nRegistro.'_detalles" style="display:none">'.
															'<div class="container" style="width:400px">'.
																
																 '<div id="pagina1_'.$nRegistro.'" class="tab-content current" style="width:370px; white-space:normal;">'.
																	'<table>'.
																		'<tr height="21">'.
																			'<td align="left" width="180"><div class="lblCampoEtiqueta">Lugar de realizaci&oacute;n:</div></td><td align="left"><div class="lblCampoValor">'.$o["lugar"].'</div></td>'.
																			
																		'</tr>'.
																		'<tr height="21">'.
																			'<td align="left"><div class="lblCampoEtiqueta">Hora de la audiencia:</div></td><td align="left"><div class="lblCampoValor">'.$o["horaProgramada"].' hrs.</div></td>'.
																			
																		'</tr>'.
																		'<tr height="21">'.
																			'<td align="left"><div class="lblCampoEtiqueta">Sala:</div></td><td align="left"><div class="lblCampoValor">'.$o["sala"].'</div></td>'.
																			
																		'</tr>'.
																		'<tr height="21">'.
																			'<td align="left"><div class="lblCampoEtiqueta">Juez:</div></td><td align="left"><div class="lblCampoValor">'.$o["jueces"].'</div></td>'.									
																		'</tr>'.(($o["desarrollo"]!="")?'<tr><td align="left"><div class="lblCampoEtiqueta">Desarrollo:</div></td><td align="left"><div class="lblCampoValor">'.utf8_encode($o["desarrollo"]).'</div></td></tr>':'').
																		'<tr height="21"><td align="left"><div class="lblCampoEtiqueta">Documentos asociados:</div></td><td align="left"><div class="lblCampoValor">'.$lblDocumentos.'</div></td></tr>'.
																		'<tr height="21">'.
																			'<td align="left"><div class="lblCampoEtiqueta">Videograbaci&oacute;n:</div></td><td align="left"><div class="lblCampoValor">'.$lblGrabacion.'</div></td>'.
																			
																		'</tr>'.
																	'</table>'.$lblResultadoAudiencia.
												
												
																'</div>'.
																'<div id="pagina2_'.$nRegistro.'" class="tab-content" style="width:510px; white-space:normal;">'.
																'</div>'.
																'<div id="pagina3_'.$nRegistro.'" class="tab-content" style="width:510px; white-space:normal;">'.
																'</div>'.
																'<div id="pagina4_'.$nRegistro.'" class="tab-content" style="width:510px; white-space:normal;">'.
																'</div>'.
																'<div id="pagina5_'.$nRegistro.'" class="tab-content" style="width:510px; white-space:normal;">'.
																'</div>'.
																'<div id="pagina6_'.$nRegistro.'" class="tab-content" style="width:510px; white-space:normal;">'.
																'</div>'.
															'</div>'.
														'</pan>';
								
								$lblEvento="".$tblDatosAudiencia."<br>".$tblDatosAudienciaComp;
								$etiquetaEvento=$o["tipoAudiencia"]."<br><div class=\"lblCampoEtiqueta\">Situaci&oacute;n del Evento:</div><div class=\"lblCampoValor\">".$arSituacionEvento [$o["situacion"]]["leyenda"]."</div>";
								
								$etapaProcesal="";
								switch($clase)
								{
									case "etapaInicial":
										$etapaProcesal="1";
									break;
									case "etapaApelacion":
										$etapaProcesal="2";
									break;
									case "etapaCasacion":
										$etapaProcesal="3";
									break;
								}
								$oElemento=" {
												id: ".$nRegistro.", 
												content: '".$lblEvento."', 
												start: '".date("Y-m-d H:i:s",strtotime($o["fechaAudienciaRaw"]." ".date("H:i:s",strtotime($o["horaProgramada"]))))."',
												etiquetaEvento:'".cv($etiquetaEvento)."',
												className:'".$clase."',
												etapaProcesal:'".$etapaProcesal."',
											}";
											
								
								
											
								return $oElemento;
							}
									
													
							
							

							
							
							$cJudicial=obtenerCarpetaBaseOriginal($cJudicial);
							//return;
							$arrDatosCarpeta=obtenerHistoriaProcesoJudicial($cJudicial);
							
							$arrElementos="";
							$nRegistro=1;
							
							$fEtInicial="";
							$fEtApelacion="";
							$fEtCasacion="";
							
							
							$minFecha="";
							$maxFecha="";
							
							$arrPuntosAlerta=array();
							$arrEventoCarpeta=array();
							

							foreach($arrDatosCarpeta["etapaInicial"] as $o)
							{

								if($minFecha=="")
									$minFecha=$o["fechaAudienciaRaw"]." ".$o["horaProgramada"];
									
								if($maxFecha=="")
									$maxFecha=$o["fechaAudienciaRaw"]." ".$o["horaProgramada"];
									
								if(strtotime($minFecha)>strtotime($o["fechaAudienciaRaw"]." ".$o["horaProgramada"]))	
								{
									$minFecha=$o["fechaAudienciaRaw"]." ".$o["horaProgramada"];
								}
								
								if(strtotime($maxFecha)<strtotime($o["fechaAudienciaRaw"]." ".$o["horaProgramada"]))	
								{
									$maxFecha=$o["fechaAudienciaRaw"]." ".$o["horaProgramada"];
								}
									
								if($fEtInicial=="")
									$fEtInicial=$o["fechaAudienciaRaw"]." ".$o["horaProgramada"];
								
								$clase="etapaInicial";
								$oElemento=generarPlantillaEvento($nRegistro,$o,$clase);
								if($arrElementos=="")
									$arrElementos=$oElemento;
								else
									$arrElementos.=",".$oElemento;
						
								$nRegistro++;
								
								
								
							}
							
							foreach($arrDatosCarpeta["etapaApelacion"] as $o)
							{
								if($minFecha=="")
									$minFecha=$o["fechaAudienciaRaw"]." ".$o["horaProgramada"];
									
								if($maxFecha=="")
									$maxFecha=$o["fechaAudienciaRaw"]." ".$o["horaProgramada"];
									
								if(strtotime($minFecha)>strtotime($o["fechaAudienciaRaw"]." ".$o["horaProgramada"]))	
								{
									$minFecha=$o["fechaAudienciaRaw"]." ".$o["horaProgramada"];
								}
								
								if(strtotime($maxFecha)<strtotime($o["fechaAudienciaRaw"]." ".$o["horaProgramada"]))	
								{
									$maxFecha=$o["fechaAudienciaRaw"]." ".$o["horaProgramada"];
								}
								
								if($fEtApelacion=="")
									$fEtApelacion=$o["fechaAudienciaRaw"]." ".$o["horaProgramada"];
								$clase="etapaApelacion";
								$oElemento=generarPlantillaEvento($nRegistro,$o,$clase);
								if($arrElementos=="")
									$arrElementos=$oElemento;
								else
									$arrElementos.=",".$oElemento;
								$nRegistro++;
								
								
								
							}
							
							foreach($arrDatosCarpeta["etapaCasacion"] as $o)
							{
								if($minFecha=="")
									$minFecha=$o["fechaAudienciaRaw"]." ".$o["horaProgramada"];
									
								if($maxFecha=="")
									$maxFecha=$o["fechaAudienciaRaw"]." ".$o["horaProgramada"];
									
								if(strtotime($minFecha)>strtotime($o["fechaAudienciaRaw"]." ".$o["horaProgramada"]))	
								{
									$minFecha=$o["fechaAudienciaRaw"]." ".$o["horaProgramada"];
								}
								
								if(strtotime($maxFecha)<strtotime($o["fechaAudienciaRaw"]." ".$o["horaProgramada"]))	
								{
									$maxFecha=$o["fechaAudienciaRaw"]." ".$o["horaProgramada"];
								}
								if($fEtCasacion=="")
									$fEtCasacion=$o["fechaAudienciaRaw"]." ".$o["horaProgramada"];
								$clase="etapaCasacion";
								$oElemento=generarPlantillaEvento($nRegistro,$o,$clase);
								if($arrElementos=="")
									$arrElementos=$oElemento;
								else
									$arrElementos.=",".$oElemento;
								$nRegistro++;
								
							}
							
							$arrEventoVarios=obtenerEventosVariosCarpeta($cJudicial,$nRegistro);
							
							foreach($arrEventoVarios as $o)
							{
								
								$oE=$o;
								if($minFecha=="")
									$minFecha=$oE->start;
									
								if($maxFecha=="")
									$maxFecha=$oE->start;
									
								if(strtotime($minFecha)>strtotime($oE->start))	
								{
									$minFecha=$oE->start;
								}
								
								if(strtotime($maxFecha)<strtotime($oE->start))	
								{
									$maxFecha=$oE->start;
								}
								$oElemento='{"id":"'.$oE->id.'","etapaProcesal":"'.$o->etapaProcesal.'","etiquetaEvento":"'.cv($oE->etiquetaEvento).'","content":"'.bD($oE->content).'","start":"'.$oE->start.'","className":"'.$oE->className.'"}';
								
								if($arrElementos=="")
									$arrElementos=$oElemento;
								else
									$arrElementos.=",".$oElemento;
								
							}
							
							$cBase=obtenerCarpetaBaseOriginal($cJudicial);

							$consulta="SELECT idTipoCarpeta FROM 7020_tipoCarpetaAdministrativa";
							$listaCarpetas=$con->obtenerListaValores($consulta);
							$arrCarpetas=obtenerCarpetasDerivadas($cBase,$listaCarpetas);
							$arrCarpetas=explode(",",$arrCarpetas);
							foreach($arrCarpetas as $c)
							{
								$cDerivada=str_replace("'","",$c);
								$consulta="SELECT tipoCarpetaAdministrativa,fechaCreacion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cDerivada."'";
								$fCarpetaDerivada=$con->obtenerPrimeraFilaAsoc($consulta);
								
								switch($fCarpetaDerivada["tipoCarpetaAdministrativa"])
								{
									case 2:
										if($fEtApelacion=="")
											$fEtApelacion=date("Y-m-d",strtotime($fCarpetaDerivada["fechaCreacion"]));
									break;
									case 3:
										if($fEtCasacion=="")
											$fEtCasacion=date("Y-m-d",strtotime($fCarpetaDerivada["fechaCreacion"]));
									break;
								}
								
								
								
								$arrEventoVarios=obtenerEventosVariosCarpeta($cDerivada,$nRegistro);
							
								foreach($arrEventoVarios as $o)
								{
									
									$oE=$o;
									if($minFecha=="")
										$minFecha=$E->start;
										
									if($maxFecha=="")
										$maxFecha=$oE->start;
										
									if(strtotime($minFecha)>strtotime($oE->start))	
									{
										$minFecha=$oE->start;
									}
									
									if(strtotime($maxFecha)<strtotime($oE->start))	
									{
										$maxFecha=$oE->start;
									}
									$oElemento='{"id":"'.$oE->id.'","etapaProcesal":"'.$o->etapaProcesal.'","etiquetaEvento":"'.cv($oE->etiquetaEvento).'","content":"'.bD($oE->content).'","start":"'.$oE->start.'","className":"'.$oE->className.'"}';
									if($arrElementos=="")
										$arrElementos=$oElemento;
									else
										$arrElementos.=",".$oElemento;
									
								}
							}
							

							
							//echo $arrElementos;
							if($minFecha=="")
								$minFecha=date("Y-m-d H:i:s");
							
							if($maxFecha=="")
								$maxFecha=date("Y-m-d H:i:s");
						?>
                        		
                        		
                                <table width="100%">
                                <td width="30">
                                </td>
                                <td>
                                	<div id="visualization"></div>
                                </td>
                                </tr>
                                </table>
                                
                               
                                <input type="hidden" id="arrElementos" value="<?php echo bE($arrElementos)?>" />
                        		<input type="hidden" id="totalRegistro" value="<?php echo $nRegistro?>" />
                                <input type="hidden" id="minFecha" value="<?php echo $minFecha?>" />
                                <input type="hidden" id="maxFecha" value="<?php echo $maxFecha?>" />
                                
                                <input type="hidden" id="fEtInicial" value="<?php echo $fEtInicial?>" />
                                <input type="hidden" id="fEtApelacion" value="<?php echo $fEtApelacion?>" />
                                <input type="hidden" id="fEtCasacion" value="<?php echo $fEtCasacion ?>" />

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
