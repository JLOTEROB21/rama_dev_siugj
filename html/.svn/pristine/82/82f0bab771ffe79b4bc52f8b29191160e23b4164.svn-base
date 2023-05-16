<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");


$Enable_AES_Ecrypt=(isset($Enable_AES_Ecrypt)&&($Enable_AES_Ecrypt==true));

$accion="";
$idUsuario="-1";
if(isset($_POST["accion"]))
	$accion=$_POST['accion'];
if(isset($_POST['idUsuario']))
	$idUsuario=$_POST['idUsuario'];
$consulta="SELECT Login,Password,FechaActualiza,FechaCambio-FechaActualiza,cuentaActiva,cambiarDatosUsr FROM 800_usuarios WHERE idUsuario=".$idUsuario;

if($Enable_AES_Ecrypt)
{
	$consulta="SELECT Login,AES_DECRYPT(UNHEX(Password), '".bD($versionLatis)."')as Password,FechaActualiza,FechaCambio-FechaActualiza ,
				cuentaActiva,cambiarDatosUsr FROM 800_usuarios WHERE idUsuario=".$idUsuario;;


}

$cInfo=$con->obtenerPrimeraFilaAsoc($consulta);
$cuentaActiva=1;
$cambiarDatosUsr=2;
if($cInfo)
{
	$cuentaActiva=$cInfo["cuentaActiva"];
	$cambiarDatosUsr=$cInfo["cambiarDatosUsr"];
}

$consulta="SELECT  Institucion from 801_adscripcion WHERE idUsuario=".$idUsuario;
$adscripcion=$con->obtenerValor($consulta);
$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$adscripcion."'";
$lblAdscripcion=$con->obtenerValor($consulta);

$consulta="select * from 801_adscripcion WHERE idUsuario=".$idUsuario;
$fAdscripcion=$con->obtenerPrimeraFilaAsoc($consulta);

$consulta="SELECT * FROM 903_variablesSistema WHERE idVariable=1";
$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);

$lblEtiqueta="<br><b>Por políticas de seguridad para cambiar su contraseña de acceso debera considerar los siguiente:</b><br><br>
- La longitud de la contrase&ntilde;a debera ser de almenos ".$fRegistro["logitudMinimaContrasena"]." caracteres<br>
- La longitud de la contrase&ntilde;a debera ser m&aacute;ximo de ".$fRegistro["logitudMaximaContrasena"]." caracteres<br>";
if($fRegistro["minLetrasMinusculas"]>0)
{
	$lblEtiqueta.="- La contrase&ntilde;a deberá contener almenos ".($fRegistro["minLetrasMinusculas"]==1?" 1 letra min&uacute;scula":($fRegistro["minLetrasMinusculas"]." letras min&uacute;sculas"))."<br>";
}

if($fRegistro["minLetrasMayusculas"]>0)
{
	$lblEtiqueta.="- La contrase&ntilde;a deberá contener almenos ".($fRegistro["minLetrasMayusculas"]==1?" 1 letra may&uacute;scula":($fRegistro["minLetrasMayusculas"]." letras letra may&uacute;scula"))."<br>";
}

if($fRegistro["minCaracteresEspeciales"]>0)
{
	$lblEtiqueta.="- La contrase&ntilde;a deberá contener almenos ".($fRegistro["minCaracteresEspeciales"]==1?" 1 caracter especial":($fRegistro["minCaracteresEspeciales"]." caracteres especial"))." (! \" # $ % & ( ) = ¿ ? [ ] ' + - * / _ ; @ . , ;)<br>";
}

if($fRegistro["minCaracteresNumericos"]>0)
{
	$lblEtiqueta.="- La contrase&ntilde;a deberá contener almenos ".($fRegistro["minCaracteresNumericos"]==1?" 1 caracter num&eacute;rico":($fRegistro["minCaracteresNumericos"]." caracteres num&eacute;ricos"))."<br>";
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr"><!-- InstanceBegin template="/Templates/Lhayas_B.dwt.php" codeOutsideHTMLIsLocked="false" -->
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
	$mostrarMenuIzq=false;
	$guardarConfSession=true;
	$pagRegresar="javascript:regresar(".$idUsuario.")";
?>

<style>
	#sticky {
				position: fixed;
				top: 5px;
				background-color: #F5F5F5;
				z-index: 1000;
				text-align: center;
			}
</style>

<!-- InstanceEndEditable -->

<?php



$arrValores=array();
$arrLlaves=array();
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


$ctParams=count($arrLlaves);
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
<link rel="stylesheet" type="text/css" href="../Scripts/ux/treeGrid/treegrid.css"/>
<script type="text/javascript" src="../Scripts/ux/treeGrid/TreeGridSorter.js"></script>
<script type="text/javascript" src="../Scripts/ux/treeGrid/TreeGridColumnResizer.js"></script>
<script type="text/javascript" src="../Scripts/ux/treeGrid/TreeGridNodeUI.js"></script>
<script type="text/javascript" src="../Scripts/ux/treeGrid/TreeGridLoader.js"></script>
<script type="text/javascript" src="../Scripts/ux/treeGrid/TreeGridColumns.js"></script>
<script type="text/javascript" src="../Scripts/ux/treeGrid/TreeGrid.js"></script>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
<script type='text/javascript' src='Scripts/nUsuarios.js.php'></script>
<?php 
$pagRegresar="javascript:regresar(".$idUsuario.")";
?>

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
	while($procesoRow=$con->fetchRow($procesoResult))
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
                        <td align="center" >
                        
                        	<?php
                            $actualizado=0;
							if(isset($objParametros->actualizado))
								$actualizado=1;
								
							$bandera=0;
							if(isset($objParametros->bandera))
								$bandera=1;
								
							$vCU=0;
							if(isset($objParametros->vCU))
								$vCU=$objParametros->vCU;
							
                            ?>
                        
						<input type="hidden" id="lblLogin" value="<?php echo $cInfo["Login"]?>" />
							<form id='nUsuario' name='nUsuario' action="intermediaProcesar.php" method='post' >
                            <input type="hidden" name="adscripcion" id="adscripcion" value="<?php echo $adscripcion?>"/>
                            <input type="hidden" name="banderaGuardar" id="banderaGuardar" value="nUsuarios"/>
                            <input type="hidden" name="bandera" id="bandera" value="<?php echo $bandera?>"/>
                            <input type="hidden" name="banderaAccion" id="banderaAccion" <?php echo"value='".$accion."'"; ?>/>
                            <input type="hidden" name="idUsuario" id="idUsuario" value='<?php echo $idUsuario;?>'/>
                            <input type="hidden" name="fechaActualiza" id="fechaActualiza" value='<?php echo $cInfo["FechaActualiza"];?>'/>
                            <input type="hidden" name="cuentaActiva" id="cuentaActiva" value='<?php echo $cuentaActiva?>' />
                            <input type="hidden" name="cambiarDatosUsr" id="cambiarDatosUsr" value='<?php echo $cambiarDatosUsr?>' />
                            <input type="hidden" name="vCU" id="vCU" value='<?php echo $vCU?>' />
							
                            
                            <table border="0" cellspacing="1" cellpadding="1" width="850">
                            <tr>
                            	<td>
                                	
                                    <table width="850">
                                    <tbody><tr>
                                        <td align="right">
                                            <table  width="100%">
                                                <tbody><tr>
                                                	<td align="left">
                                                   <span style="display:<?php echo $actualizado==0?"none":""?>">&nbsp;&nbsp; <img src="../images/001_06.gif" /> <b><span style="color:#003" class="SIUGJ_ControlEtiqueta">Datos actualizados correctamente<br /><br /></span></b></span>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        </td>
                                    </tr>
                                    </tbody>
                                    </table>
                                    
                                </td>
                            </tr>
                            <tr>
								<td align="left" >
                                
                                	<fieldset class="frameSiugj" style="width:850px" ><br /><br />
                                    	<table width="100%">
                                        	<tr>
                                            	<td align="left" width="30">
                                            	<td colspan="3" align="left">
                                                <span class="letraTituloSeccion">Datos de la cuenta</span>
                                                </td>
                                            </tr>
                                            <?php
											if($vCU==1)
											{
											?>
												<tr class="">
                                                		<td></td>
														 <td align="left" colspan="14">
															<span class="SIUGJ_ControlEtiqueta"><?php echo $lblEtiqueta?></span><br />
														 </td>
													</tr>
											 <?php
											}
											 ?>
											 
                                            <tr height="40">
                                            	<td></td>
                                                <td width="440" align="left"><span class="letraTituloCampoRegistro">Usuario *</span></td>
                                                <td width="10"></td>
                                                <td width="440" align="left"><span class="letraTituloCampoRegistro"></span></td>
                                            </tr>
                                            <tr height="50">
                                            	<td></td>
                                                <td align="left">
                                                	<?php
										
													if(($cInfo["Login"]=="")||($cInfo["Login"]=="NULL"))
													{
													?>
													
													<select name="cmbLogin" id="cmbLogin"  class="SIUGJ_Control"  style="width:380px" val="obl" campo="Login" />
													</select>
													<?php
													}
													else
													{
													?>
													<div style="width:380px; padding-top: 10px;" class="SIUGJ_Control"><b><?php echo $cInfo["Login"] ?></b></div>
													<input type="hidden" name="cmbLogin" value="<?php echo $cInfo["Login"] ?>" />
													<?php
													}
													?>
                                                </td>
                                                <td ></td>
                                                <td  align="left"></td>
                                            </tr>
                                            <tr height="50">
                                            	<td></td>
                                                <td width="440" align="left"><span class="letraTituloCampoRegistro">Contrase&ntilde;a *</span></td>
                                                <td width="10"></td>
                                                <td width="440" align="left"><span class="letraTituloCampoRegistro">Confirmar Contrase&ntilde;a: *</span></td>
                                            </tr>
                                            <tr height="50">
                                            	<td></td>
                                                <td align="left">
                                                	<input size="20" type="password" class="SIUGJ_Control"  style="width:380px" name="Contrasena" id="Contrasena" val="obl" campo="Contraseña" value='<?php echo ($cInfo["Password"]);?>'/>
                                                </td>
                                                <td></td>
                                                <td  align="left">
                                                	<input  size="20" type="password" class="SIUGJ_Control"  style="width:380px" name="Contrasena2" id="Contrasena2" val="obl" campo="Confirmar Contraseña" value='<?php echo ($cInfo["Password"]);?>'/>
                                                </td>
                                            </tr>
                                             <?php
											if($vCU==0)
											{
											?>
                                            <tr height="50">
                                            	<td></td>
                                                <td width="440" align="left"><span class="letraTituloCampoRegistro">Cambiar contraseña en el pr&oacute;ximo ingreso al sistema *</span></td>
                                                <td width="10"></td>
                                                <td width="440" align="left"><span class="letraTituloCampoRegistro">Situaci&oacute;n de la cuenta *</span></td>
                                            </tr>
                                            <tr height="50">
                                            	<td></td>
                                                <td align="left">
                                                	<input type="radio" class="letraTituloCampoRegistro" name="radioCambioPass" id="rdo_2" value="2" <?php echo $cambiarDatosUsr==2?"checked='checked'":"" ?> onclick="radioCambioPassChecked(this)" /> <span class="letraTituloCampoRegistro">S&iacute;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                            		<input type="radio" class="letraTituloCampoRegistro" name="radioCambioPass" id="rdo_0" value="0" <?php echo $cambiarDatosUsr==0?"checked='checked'":"" ?> onclick="radioCambioPassChecked(this)"/> <span class="letraTituloCampoRegistro">No</span>
                                            
                                                </td>
                                                <td></td>
                                                <td  align="left">
                                                	<input type="radio" class="letraTituloCampoRegistro" name="radioCuentaActiva" id="rdo_1" <?php echo $cuentaActiva==1?"checked='checked'":"" ?> onclick="radioCuentaActivaChecked(this)"/> <span class="letraTituloCampoRegistro">Activa</span>&nbsp;&nbsp;&nbsp;
                                            		<input type="radio" class="letraTituloCampoRegistro" name="radioCuentaActiva" id="rdo_0" <?php echo $cuentaActiva==0?"checked='checked'":"" ?> onclick="radioCuentaActivaChecked(this)"/> <span class="letraTituloCampoRegistro">Inactiva</span>&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" class="letraTituloCampoRegistro" name="radioCuentaActiva" id="rdo_100" <?php echo $cuentaActiva==100?"checked='checked'":"" ?> onclick="radioCuentaActivaChecked(this)"/> <span class="letraTituloCampoRegistro">Bloqueada</span>
                                            
                                                </td>
                                            </tr>
                                            <?php
											}
											?>
                                            <tr height="50">
                                            	<td></td>
                                                <td width="440" align="left"><span class="letraTituloCampoRegistro">Adscripci&oacute;n *</span></td>
                                                <td width="10"></td>
                                                <td width="440" align="left"><span class="letraTituloCampoRegistro"></span></td>
                                            </tr>
                                            <tr height="50">
                                            	<td></td>
                                                <td align="left" colspan="3">
                                                	<div style="width:800px; padding-top: 10px;" class="SIUGJ_Control"><b><?php echo $lblAdscripcion==""?"(Sin adscripci&oacute;n)":$lblAdscripcion?></b></div>

                                                </td>
                                                
                                            </tr>
                                        </table>
                                    <br /><br />
                                    </fieldset>
                                	<br /><br />
                                </td>
                           </tr>
                           </table>	
                            <?php if(($fAdscripcion["institucionAbierto"]!="") || ($fAdscripcion["puestoAbierto"]!=""))
							{
							?>
                           <fieldset class="frameSiugj" style="width:850px" ><br /><br />
                          <table width="100%">
                              <tr>
                                  <td align="left" width="30">
                                  <td colspan="3" align="left">
                                  <span class="letraTituloSeccion">Ultima vinculaci&oacute;n</span><br /><br />
                                  </td>
                              </tr> 
                              <tr height="50">
                                  <td></td>
                                  <td width="440" align="left"><span class="letraTituloCampoRegistro">&Uacute;ltima dependencia</span></td>
                                  <td width="10"></td>
                                  <td width="440" align="left"><span class="letraTituloCampoRegistro"></span></td>
                              </tr>
                              <tr height="50">
                                  <td></td>
                                  <td align="left" colspan="3">
                                      <div style="width:800px; padding-top: 10px;" class="SIUGJ_Control"><?php echo $fAdscripcion["institucionAbierto"]?></div>
                                  </td>
                                  
                              </tr>
                              <tr height="50">
                                  <td></td>
                                  <td width="440" align="left"><span class="letraTituloCampoRegistro">&Uacute;ltimo cargo</span></td>
                                  <td width="10"></td>
                                  <td width="440" align="left"><span class="letraTituloCampoRegistro"></span></td>
                              </tr>
                              <tr height="50">
                                  <td></td>
                                  <td  align="left" colspan="3">
                                  	<div style="width:800px; padding-top: 10px;" class="SIUGJ_Control"><?php echo $fAdscripcion["puestoAbierto"]?></div>
                                      
                                  </td>
                              </tr>
                          </table>
                          </fieldset><br /><br />
                          
                          <?php
							}
						  ?>
                            <?php
							if($vCU=='0')
							{
								$consulta="SELECT codigoRol FROM 807_usuariosVSRoles WHERE idUsuario=".$idUsuario;
								$arrRoles=$con->obtenerFilasArreglo($consulta);
							?>
                           <fieldset class="frameSiugj" style="width:850px" ><br /><br />
                          <table width="100%">
                              <tr>
                                  <td align="left" width="30">
                                  <td colspan="3" align="left">
                                  <span class="letraTituloSeccion">Roles de usuario</span><br /><br />
                                  </td>
                              </tr> 
                              <tr height="50">
                                <td colspan="4">
                                <div id="gridRoles"></div><br /><br />
                                <input type="hidden" name="listadoRoles" id="listadoRoles" value="">
                                <input type="hidden" name="arrRoles" id="arrRoles" value="<?php echo bE($arrRoles)?>">
                                </td>
                            </tr>
                          </table>
                          </fieldset>
                          <br /><br />
                          <fieldset class="frameSiugj" style="width:850px" ><br /><br />
                          <table width="100%">
                              <tr>
                                  <td align="left" width="30">
                                  <td colspan="3" align="left">
                                  <span class="letraTituloSeccion">Datos de adscripci&oacute;n</span><br /><br />
                                  </td>
                              </tr> 
                              <tr height="50">
                                <td colspan="4">
                                <span id="tblOrganigrama"></span><br /><br />
                                </td>
                            </tr>
                          </table>
                          </fieldset>
                            <?php
							}
							?>
                            <br /><br />
                            <table width="850">
                            <tbody><tr>
                                <td align="center">
                                    <table  >
                                        <tbody>
                                        <tr>
                                            <td width="110"><span id="contenedor1"></span></td>
                                            <?php
                                            if($accion=="Nuevo")
                                            {
                                            ?>
                                            <td width="10"></td>
                                            <td width="110"><span id="contenedor2"></span></td>
                                            <?php
                                            }
                                            ?>
                                        </tr>
                                        </tbody>
                                        </table>
                                </td>
                            </tr>
                            </tbody>
                            </table>
							
                            </form>
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
