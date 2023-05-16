<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");
include_once("sgjp/funcionesDocumentos.php");

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
?>
<script type="text/javascript" src="../Scripts/funcionesAjaxV2.js"></script>
<script type="text/javascript" src="../Scripts/jquery.min.js"></script>
<script src="../Scripts/base64.js" ></script>
<script src="../Scripts/ckeditor/ckeditor.js" ></script>
<link type="text/css" rel="stylesheet" href="../Scripts/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css" media="screen" />
<script type="text/javascript" src="../Scripts/plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="../Scripts/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<script type="text/javascript" src="../Scripts/plupload/js/i18n/es.js"></script>
<script src="../modulosEspeciales_SGJP/Scripts/editorFormatosSeleccionFormatoPublicacionBoletin.js.php" ></script>

<style>
	.plupload_header
	{
			display:none;
	}
	
	.plupload_container
	{
		padding:0px;
		border-width:1px;
		border-color:#CCC;
		border-style:solid;
	}
	.x-window
	{
		z-index:1150100 !important;
	}
	.ext-el-mask
	{
		z-index:1150000 !important;
	}
	.x-combo-list
	{
		z-index:1151000 !important;
	}
	/*.x-shadow
	{
		z-index:115 !important;
	}*/
	
	.cke_button__psavedocument_label
	{
		display: inline !important;
	}
	
	.cke_button__psavepdf_label
	{
		display: inline !important;
	}
	
	.cke_button__psavefirmaelectronica_label
	{
		display: inline !important;
	}
	
	/*.cke_button__psavepdf
	{
		display:none !important;
	}*/
	
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
                        	
							$actor=0;
							if(isset($objParametros->actor))
								$actor=bD($objParametros->actor);
								
								
								
							$idRegistro=-1;
							if(isset($objParametros->idRegistro))
								$idRegistro=$objParametros->idRegistro;
								
							$idFormulario=-1;
							if(isset($objParametros->idFormulario))
								$idFormulario=$objParametros->idFormulario;	
							
							$actor=-1;
							if(isset($objParametros->actor))
								$actor=bD($objParametros->actor);	
							
							$idReferencia=-1;
							if(isset($objParametros->idReferencia))
								$idReferencia=bD($objParametros->idReferencia);	
							
							$sL=0;
							if(isset($objParametros->sL))
								$sL=$objParametros->sL;
							
							$idFormularioProceso=-1;
							if(isset($objParametros->idFormularioProceso))
								$idFormularioProceso=$objParametros->idFormularioProceso;
							
							$documentoFirmado=0;
							$cObjDefault='{"tipoDocumento":"","tituloDocumento":"","perfilValidacion":"","categoriaDocumento":""}';
							
							$tipoFormato=-1;	
							$consulta="SELECT idRegistro FROM 7035_informacionDocumentos WHERE idFormulario=".$idFormulario.
									" AND idReferencia=".$idRegistro." and idFormularioProceso=".$idFormularioProceso;

							$listaDocumentos=$con->obtenerListaValores($consulta);
							if($listaDocumentos=="")					
								$listaDocumentos=-1;	
							$consulta="SELECT tipoFormato,idFormulario,idRegistro,idReferencia,cuerpoFormato,idRegistroFormato,
										documentoBloqueado,idDocumentoAdjunto,idDocumento,firmado,configuracionDocumento FROM 3000_formatosRegistrados 
										WHERE idFormulario=-2 and idRegistro in(".$listaDocumentos.") 
										and idFormularioProceso=".$idFormularioProceso;

							$fFormato=$con->obtenerPrimeraFila($consulta);

							if($fFormato && ($fFormato[9]==1)&&($fFormato[7]==""))
							{
								$consulta="update 3000_formatosRegistrados set idDocumentoAdjunto=idDocumento where idRegistroFormato=".$fFormato[5];
								$con->ejecutarConsulta($consulta);
								$fFormato[7]=$fFormato[8];
								
								
							}
							
							
							$idRegistroFormato=-1;	
							$idInformacionDocumento=-1;
							
							$idDocumentoAdjunto=$fFormato[7]==""?-1:$fFormato[7];
							$idPerfil=-1;
							$consulta="SELECT tipoActor,actor FROM 944_actoresProcesoEtapa WHERE idActorProcesoEtapa=".$actor;

							$fActor=$con->obtenerPrimeraFila($consulta);

							if($fActor)
							{
								$consulta="SELECT idPerfil FROM 206_perfilesEscenarios WHERE tipoActor=".$fActor[0]." AND actor='".$fActor[1]."' AND situacion=1";
								
								$idPerfil=$con->obtenerValor($consulta);
								if($idPerfil=="")
									$idPerfil=-1;
							}
							$idProceso=obtenerIdProcesoFormulario($idFormulario);
							
							
							if(!$fFormato)
							{
								
								$idRegistroFormato=-1;
								$tipoFormato=0;
								$cuerpoDocumento="";
								$configuracionDocumento="";
								
								
							
							}
							else
							{
								$idRegistroFormato=$fFormato[5];
								$tipoFormato=$fFormato[0];
								$cuerpoDocumento=$fFormato[4];
								
								$sL=$fFormato[6];
								$idInformacionDocumento=$fFormato[2];
								$documentoFirmado=$fFormato[9];
								$configuracionDocumento=$fFormato[10];
							}

							$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);

							$consulta="SELECT * FROM 3019_categoriaDocumentosAdjuntos WHERE idProceso=".$idProceso.
									" AND idPerfil=".$idPerfil." AND idFormularioProceso=".$idFormularioProceso;
							$fConfiguracion=$con->obtenerPrimeraFila($consulta);

							$idCategoriaDocumento=$fConfiguracion[1];
							
							$permiteSeleccionPlantilla=$fConfiguracion[5];
							$permiteEdicionTextoEnriquecido=$fConfiguracion[6];
							$permiteSubirWord=$fConfiguracion[7];
							$idFormatoDefault=$fConfiguracion[8]==""?-1:$fConfiguracion[8];
							$permiteConfiguracionBoletin=$fConfiguracion[9];
							$publicaEnBoletin=$fConfiguracion[10];
							$funcionAsignacion=$fConfiguracion[11];
							$permitirGuardarSinModificacion=$fConfiguracion[12];
							if($permiteConfiguracionBoletin==1)
							{
								$consulta="SELECT actor FROM 944_actoresProcesoEtapa WHERE idActorProcesoEtapa=".$actor;
								$rolActor=$con->obtenerValor($consulta);
								
								$consulta="SELECT COUNT(*) FROM 3019_rolesEditanConfiguracionBoletin WHERE idConfiguracionEditor=".
										$fConfiguracion[0]." AND rolEdicion='".$rolActor."'";
								$nRegistros=$con->obtenerValor($consulta);
								if($nRegistros==0)
								{
									$permiteConfiguracionBoletin=0;
								}
							}
							
							
							if($idFormatoDefault==-10)
							{
								$cacheCalculos=NULL;
								$cadParametros='{"idFormularioEvaluacion":"'.$idFormularioProceso.'","idFormulario":"'.$idFormulario.'","idRegistro":"'.$idRegistro.'","actor":"'.$actor.'"}';
								
								$objParametros=json_decode($cadParametros);

								$idFormatoDefault=removerComillasLimite(resolverExpresionCalculoPHP($funcionAsignacion,$objParametros,$cacheCalculos));
								if($idFormatoDefault=="")
								{
									$idFormatoDefault=-1;
								}
							}
							
							$consulta="SELECT * FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$idFormatoDefault;
							
							$datosDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
							
							
							
							
							if($datosDocumento)
							{
								if(!$fFormato)
								{
									$cuerpoDocumento=bE($datosDocumento["txtPlantillaDocumento"]);
								}
								$cObjDefault='{"tipoDocumento":"'.$idFormatoDefault.'","tituloDocumento":"'.cv($datosDocumento["nombreFormato"]).
											'","perfilValidacion":"'.$datosDocumento["perfilValidacion"].'","categoriaDocumento":"'.$datosDocumento["categoriaDocumento"].'"}';
							}
							$cObjDefault=bE($cObjDefault);
							
                        ?>
                        
                        <input type="hidden" id="idFormularioProceso" value="<?php echo $idFormularioProceso?>" />
                        <input type="hidden" id="idInformacionDocumento" value="<?php echo $idInformacionDocumento?>" />
                        <input type="hidden" id="idRegistroFormato" value="<?php echo $idRegistroFormato?>" />
                        <input type="hidden" id="tipoFormato" value="<?php echo $tipoFormato?>" />
                        <input type="hidden" id="idFormulario" value="<?php echo $idFormulario?>" />
                        <input type="hidden" id="idRegistro" value="<?php echo $idRegistro?>" />
                        <input type="hidden" id="idReferencia" value="<?php echo $idRegistro?>" />
                        <input type="hidden" id="txtCuerpo" value="<?php echo $cuerpoDocumento?>" />
                        <input type="hidden" id="sL" value="<?php echo $sL?>" />
                        <input type="hidden" id="actor" value="<?php echo $actor?>" />
                        
                        <input type="hidden" id="cObjDefault"  value="<?php echo $cObjDefault?>"/>
                        
                        <input type="hidden" id="carpetaAdministrativa"  value="<?php echo $carpetaAdministrativa?>"/>
                        <input type="hidden" id="idDocumentoAdjunto"  value="<?php echo $idDocumentoAdjunto?>"/>
                        <input type="hidden" id="categoriaDocumento"  value="<?php echo $idCategoriaDocumento?>"/>
						<input type="hidden" id="permiteSeleccionPlantilla" name="permiteSeleccionPlantilla" value="<?php echo $permiteSeleccionPlantilla ?>" />
					 	<input type="hidden" id="permiteEdicionTextoEnriquecido" name="permiteEdicionTextoEnriquecido" value="<?php echo $permiteEdicionTextoEnriquecido ?>" />
                        <input type="hidden" id="permiteSubirWord" name="permiteSubirWord" value="<?php echo $permiteSubirWord ?>" />
                        <input type="hidden" id="documentoFirmado" name="documentoFirmado" value="<?php echo $documentoFirmado ?>" />
                        <input type="hidden" id="permiteConfiguracionBoletin" name="permiteConfiguracionBoletin" value="<?php echo $permiteConfiguracionBoletin?>" />
                        <input type="hidden" id="configuracionBoletin" name="configuracionBoletin" value="<?php echo $configuracionDocumento?>" />
                        <input type="hidden" id="publicaEnBoletin" name="publicaEnBoletin" value="<?php echo $publicaEnBoletin?>" />
                        <input type="hidden" id="permitirGuardarSinModificacion" name="permitirGuardarSinModificacion" value="<?php echo $permitirGuardarSinModificacion?>" />
                        
                        
                        
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
