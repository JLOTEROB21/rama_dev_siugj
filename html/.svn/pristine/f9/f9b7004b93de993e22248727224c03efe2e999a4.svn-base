<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");


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
	$paramGET=true;
	$mostrarMenuIzq=false;
	//$pagRegresar="javascript:regresar(".$idUsuario.")";
	$guardarConfSession=true;
	
	
	$_POST["cPagina"]="sFrm=true";
	$arrPOST=array_values($_POST);
	$ctPOST=sizeof($arrPOST);
	
	
?>
<style>
	#sticky {
				position: fixed;
				top: 5px;
				background-color: #F5F5F5;
				z-index: 10000;
				text-align: center;
			}
</style>
<link rel="stylesheet" type="text/css" href="../principalPortal/css/estilosFormulariosDinamicos.css" media="screen" />
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../modulosEspeciales_SIUGJ/Scripts/nUsuariosIntermedia.js.php"></script>
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

<script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
<?php
	$regresaPagInicio=false;
	if((isset($_POST["idUsuario"])||(isset($_POST["accion"]))))
	{
	//	$pagRegresar="javascript:regresar(".$_POST["idUsuario"].")";
	}
	else
	{
		$pagRegresar="../principal/inicio.php";	
		$regresaPagInicio=true;
	}
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
				   <?php
				   
				   $actualizado=0;
				    $accion="";
					$idUsuario=$_SESSION["idUsr"];
					$bandera=0;
					if(isset($objParametros->accion))
						$accion=$objParametros->accion;
					if(isset($objParametros->idUsuario))
						$idUsuario=$objParametros->idUsuario;
					
					if(isset($objParametros->bandera))
						$bandera=$objParametros->bandera;	
					if($accion=="Nuevo")	
						$idUsuario=-1;
					
					if(isset($objParametros->actualizado))
						$actualizado=1;
						
						$consulta="SELECT idTipoHuella,descripcion FROM 826_tiposHuellasUsuario ORDER BY idTipoHuella";
						$arrHuellas=$con->obtenerFilasArreglo($consulta);
					
					
					
					$consulta="SELECT bloqueadoNomina FROM 802_identifica WHERE idUsuario=".$idUsuario;
					$bloqueadoNomina=$con->obtenerValor($consulta);
					if($bloqueadoNomina=="")
						$bloqueadoNomina=0;
					
					$lblNombre="";
					$sql="SELECT Nom,Paterno,Materno,Prefijo,ciudadNacimiento,estadoNacimiento,paisNacimiento,Nacionalidad,RFC, ";
					$sql.="date_format(fechaNacimiento,'%d/%m/%Y') as fechaNacimiento,Status,Genero,CURP,IMSS,Calle,Numero,Colonia,Ciudad,
					CP,Estado,Pais,cvuConacyt,tipoIdentificacion,noIdentificacion,datosValidados,date_format(fechaExpedicionDocumento,'%d/%m/%Y') as fechaExpedicionDocumento,
					grupoEtnico,discapacidad ";
					$sql.="FROM 802_identifica Iden,803_direcciones Dir ";
					if($idUsuario!="-1")//Si esta puesta
						$sql.="WHERE Iden.idUsuario=Dir.idUsuario and Dir.Tipo=0 and Iden.idUsuario=".$idUsuario;
					else
						$sql.="WHERE 1=-1";
					

					$cInfo=$con->obtenerPrimeraFilaAsoc($sql);
					
					$datosValidados=$cInfo["datosValidados"]==1;
					
					$lblNombre=$cInfo["Nom"]." ".$cInfo["Paterno"]." ".$cInfo["Materno"];
					
					
					
					$consulta="SELECT Login,Password,FechaActualiza,FechaCambio-FechaActualiza,cuentaActiva,cambiarDatosUsr FROM 800_usuarios WHERE idUsuario=".$idUsuario;

					if($Enable_AES_Ecrypt)
					{
						$consulta="SELECT Login,AES_DECRYPT(UNHEX(Password), '".bD($versionLatis)."')as Password,FechaActualiza,FechaCambio-FechaActualiza ,
									cuentaActiva,cambiarDatosUsr FROM 800_usuarios WHERE idUsuario=".$idUsuario;;
					
					
					}
					
					$cInfoPasswd=$con->obtenerPrimeraFilaAsoc($consulta);
					$cuentaActiva=1;
					$cambiarDatosUsr=2;
					if($cInfoPasswd)
					{
						$cuentaActiva=$cInfoPasswd["cuentaActiva"];
						$cambiarDatosUsr=$cInfoPasswd["cambiarDatosUsr"];
					}
					
					$consulta="SELECT  Institucion from 801_adscripcion WHERE idUsuario=".$idUsuario;
					$adscripcion=$con->obtenerValor($consulta);
					$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$adscripcion."'";
					$lblAdscripcion=$con->obtenerValor($consulta);
					
					
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
                   <tr>
                        <td>
                        	<input type="hidden" name="arrHuellas" id="arrHuellas" value="<?php echo $arrHuellas?>"/>
	                        <form action="../cuentasUsuario/intermediaProcesar.php"  id="nIdentifica" method="post" enctype="multipart/form-data">
							<input type="hidden" name="banderaGuardar" id="banderaGuardar" value="nIdentificaActualizaUsuario"/>
                            <input type="hidden" name="cambioDatosUsrPrimeraVez" id="cambioDatosUsrPrimeraVez" value="<?php echo $cambiarDatosUsr==2?1:0?>"/>
                            <input type="hidden" name="complemento" id="complemento" value="<?php echo bE($cInfoPasswd["Password"])?>"/>
                            <input type="hidden" name="banderaAccion" id="banderaAccion" value="<?php echo $accion ?>"/>
                            <input type="hidden" name="idUsuario" id="idUsuario" value='<?php echo $idUsuario;?>'/>
                            <input type="hidden" name="validado" id="validado" value='<?php echo $cInfo["datosValidados"] ?>'/>
                            <table width="100%">
                            <tr>
                            	<td align="center">
                                	<table width="100%">
                                    	<tr>
                                        	<td align="center">
                                            	<img class="imagenLogo" src="../principalPortal/imagesSIUGJ/logoRamaJudicial2.png">
                                                <img class="imagenLogo2" src="../principalPortal/imagesSIUGJ/Paleta_SIUGJ_Mesa_de_trabajo_1.png">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                            <td align="center">
                            <br /><br /><br /><br />
                            <br /><br /><br /><br />
                            <br /><br />
							<table border="0" cellspacing="1" cellpadding="1" width="850">
                            <tr>
                            	<td align="left">
                                	<span class="letraTituloPagina">Actualizaci&oacute;n de datos de usuario</span><br /><br />
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	
                                    <table width="850">
                                    <tbody><tr>
                                        <td align="right">
                                            <table  width="<?php echo 680+($accion=="Nuevo"?0:120) ?>">
                                                <tbody><tr>
                                                	<td align="left" width="480">
                                                   <span style="display:<?php echo $actualizado==0?"none":""?>">&nbsp;&nbsp; <img src="../images/001_06.gif" /> <b><span style="color:#003">Datos actualizados correctamente<br /><br /></span></b></span>
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
                                                <span class="letraTituloSeccion">Datos de identificaci&oacute;n</span>
                                                </td>
                                            </tr>
                                            <tr height="50">
                                            	<td></td>
                                                <td width="440" align="left"><span class="letraTituloCampoRegistro">Nombres *</span></td>
                                                <td width="10"></td>
                                                <td width="440" align="left"><span class="letraTituloCampoRegistro">Primer apellido *</span></td>
                                            </tr>
                                            <tr height="50">
                                            	<td></td>
                                                <td align="left">
                                                
                                                <?php
												if(!$datosValidados)
												{
												?>
                                                <input class="SIUGJ_Control" onkeyup="cambiarMayusculasTexto(this)" size="42" type="text" name="Nombre" id="Nombre" val="obl|txt" campo="Nombres" value="<?php echo ($cInfo["Nom"]);?>"/>
                                                <?php
												}
												else
												{
												?>
                                                <div class="SIUGJ_ControlEtiqueta"><?php echo ($cInfo["Nom"]);?></div>
                                                <?php
												}
												?>
                                                
                                                </td>
                                                <td ></td>
                                                <td  align="left">
                                                
                                                
                                                 <?php
												if(!$datosValidados)
												{
												?>
                                                <input class="SIUGJ_Control" onkeyup="cambiarMayusculasTexto(this)" size="42" type="text" name="Apat" id="Apat" val="obl|txt" campo="Primer apellido" value='<?php echo ($cInfo["Paterno"]);?>'/>
                                                <?php
												}
												else
												{
												?>
                                                <div class="SIUGJ_ControlEtiqueta"><?php echo ($cInfo["Paterno"]);?></div>
                                                <?php
												}
												?>
                                                
                                                </td>
                                            </tr>
                                             <tr height="50">
                                            	<td></td>
                                                <td align="left"><span class="letraTituloCampoRegistro">Segundo apellido</span></td>
                                                <td ></td>
                                                <td  align="left"><span class="letraTituloCampoRegistro">Prefijo (Dr., Dra., Lic.)</span></td>
                                            </tr>
                                            <tr height="50">
                                            	<td></td>
                                                <td align="left">
                                                <?php
												if(!$datosValidados)
												{
												?>
                                                <input class="SIUGJ_Control" onkeyup="cambiarMayusculasTexto(this)" size="42" type="text" name="Amat" id="Amat" val="txt" campo="Segundo apellido" value='<?php echo ($cInfo["Materno"]);?>'/></td>
                                                <?php
												}
												else
												{
												?>
                                                <div class="SIUGJ_ControlEtiqueta"><?php echo ($cInfo["Materno"]);?></div>
                                                <?php
												}
												?>
                                                
                                                
                                                <td ></td>
                                                <td  align="left"><input class="SIUGJ_Control" size="42" type="text" name="Prefijo" id="Prefijo" value='<?php echo ($cInfo["Prefijo"]);?>'/></td>
                                            </tr>
                                            <tr height="50">
                                            	<td></td>
                                                <td align="left"><span class="letraTituloCampoRegistro">Nacionalidad</span></td>
                                                <td ></td>
                                                <td  align="left"><span class="letraTituloCampoRegistro">Fecha de nacimiento *</span></td>
                                            </tr>
                                            <tr height="50">
                                            	<td></td>
                                                <td align="left">
                                                <select name="nacionalidad" style="width:380px"  id="nacionalidad" class="SIUGJ_Control">
                                                <option value="-1">Seleccione</option>
                                                <?php 
													$consulta="SELECT id__378_tablaDinamica,nacionalidad FROM _378_tablaDinamica ORDER BY nacionalidad";
													$con->generarOpcionesSelect($consulta,$cInfo["Nacionalidad"]);
												?>
                                                </select>
                                                </td>
                                                <td ></td>
                                                <td  align="left">
                                                <div name='FNac' id='FNac' style="width:390px"></div>
	                                            <input type='hidden' name='FNacimiento' id='FNacimiento' value='<?php echo ($cInfo["fechaNacimiento"]);?>'  campo='Fecha de Nacimiento' val="obl" extId="f_FNac">
                                                </td>
                                            </tr>
                                            <tr height="50">
                                            	<td></td>
                                                <td align="left"><span class="letraTituloCampoRegistro">G&eacute;nero</span></td>
                                                <td ></td>
                                                <td align="left"><span class="letraTituloCampoRegistro">Tipo de identificaci&oacute;n *</span></td>
                                            </tr>
                                            <tr height="50">
                                            	<td></td>
                                                <td align="left">
                                                <select class="SIUGJ_Control" style="width:380px" name="cmbGenero" id="cmbGenero">
												  <?php
                                                    $consulta="SELECT idGenero,genero FROM 1005_generoUsuario";
													$con->generarOpcionesSelect($consulta,$cInfo["Genero"]);
                                                  ?>
                                                </select>
                                                </td>
                                                <td ></td>
                                                <td  align="left">
                                                
                                                
                                                <?php
												if(!$datosValidados)
												{
												?>
                                                <select name="tipoIdentificacion" style="width:380px"  id="tipoIdentificacion" class="SIUGJ_Control" campo="Tipo de identificaci&oacute;n" val="obl">
												<option value="-1">Seleccione</option>
                                                <?php 
													$consulta="SELECT id__32_tablaDinamica,UPPER(tipoIdentificacion) FROM _32_tablaDinamica where situacion=1 ORDER BY tipoIdentificacion";
													$con->generarOpcionesSelect($consulta,$cInfo["tipoIdentificacion"]);
													
													
												?>
                                                </select>
                                                <?php
												}
												else
												{
													$consulta="SELECT UPPER(tipoIdentificacion) FROM _32_tablaDinamica where id__32_tablaDinamica=".$cInfo["tipoIdentificacion"];
													$lblTipoIdentificacion=$con->obtenerValor($consulta);
												?>
                                                <div class="SIUGJ_ControlEtiqueta"><?php echo $lblTipoIdentificacion ?></div>
                                                <input type="hidden" id="lblTipoIdentificacion" value="<?php echo $$cInfo["tipoIdentificacion"]?>" />
                                                <?php
												}
												?>
                                                
                                                
                                                
                                                
                                                </td>
                                            </tr>
                                            
                                            <tr height="50">
                                            	<td></td>
                                                <td align="left"><span class="letraTituloCampoRegistro" id="lblNoIdentificacion">No. de identificaci&oacute;n *</span></td>
                                                <td ></td>
                                                <td align="left"><span class="letraTituloCampoRegistro" id="lblFechaExpedicion">Fecha de expedición del documento *</span></td>
                                            </tr>
                                            <tr height="50">
                                            	<td></td>
                                                <td align="left">
                                                <?php
												if(!$datosValidados)
												{
												?>
                                                <input onblur="noIdenticacionBlur(this)" onkeypress="return noIdenticacionKeyPress(event)"  class="SIUGJ_Control" size="42" maxlength="18" type="text" name="noIdentificacion" id="noIdentificacion" campo="No. de identificaci&oacute;n" value="<?php echo ($cInfo["noIdentificacion"]);?>"/></td>
                                                <?php
												}
												else
												{
												?>
                                                <div class="SIUGJ_ControlEtiqueta" ><?php echo ($cInfo["noIdentificacion"]);?></div>
                                                <?php
												}
												?>
                                                
                                                
                                                
                                                <td ></td>
                                                <td  align="left">
                                                <?php
												if(!$datosValidados)
												{
												?>
                                                <div name='FExp' id='FExp' style="width:390px"></div>
	                                            <input type='hidden' name='FExpedicion' id='FExpedicion' value='<?php echo ($cInfo["fechaExpedicionDocumento"]);?>'  campo='Fecha de expedici&oacute;n del documento' val="obl" extId="f_FExp"></td>
                                                
                                                <?php
												}
												else
												{
												?>
                                                <div class="SIUGJ_ControlEtiqueta" id="lblFechaNacimiento"><?php echo ($cInfo["fechaExpedicionDocumento"]);?></div>
                                                <?php
												}
												?>
                                                
                                                
                                                
                                            </tr>
                                            <tr height="50">
                                            	<td></td>
                                                <td align="left"><span class="letraTituloCampoRegistro">Grupo étnico *</span></td>
                                                <td ></td>
                                                <td align="left"><span class="letraTituloCampoRegistro">Discapacidad *</span></td>
                                            </tr>
                                            <tr height="50">
                                            	<td></td>
                                                <td align="left">
                                                
                                                <select name="grupoEtnico" style="width:380px"  id="grupoEtnico" class="SIUGJ_Control" campo="Grupo &eacute;tnico" val="obl">
												<option value="-1">Seleccione</option>
                                                <?php
													$consulta="SELECT id__857_tablaDinamica,medidaCautelar FROM _857_tablaDinamica WHERE tipoMedida=5 ORDER BY id__857_tablaDinamica";
													$con->generarOpcionesSelect($consulta,$cInfo["grupoEtnico"]);
												?>
                                                </select>
                                                </td>
                                                <td ></td>
                                                <td align="left">
                                                 <select name="discapacidad" style="width:380px"  id="discapacidad" class="SIUGJ_Control" campo="Discapacidad" val="obl">
												<option value="-1">Seleccione</option>
                                                <?php
													$consulta="SELECT id__857_tablaDinamica,medidaCautelar FROM _857_tablaDinamica WHERE tipoMedida=6 ORDER BY id__857_tablaDinamica";
													$con->generarOpcionesSelect($consulta,$cInfo["discapacidad"]);
												?>
                                                </select>
                                                </td>
                                            </tr>
                                        </table>
                                    
                                    </fieldset>
                                	<br /><br />
                                	<fieldset class="frameSiugj" style="width:850px" >
                                    <br /><br />
									<table width="100%"  border="0" cellspacing="1" cellpadding="1">
                                        	<tr>
                                            	<td align="left" width="30">
                                            	<td colspan="3" align="left">
                                                <span class="letraTituloSeccion">Datos de contacto</span>
                                                </td>
                                            </tr>
                                            <tr height="50">
                                            	<td></td>
                                                <td width="440" align="left"><span class="letraTituloCampoRegistro">Tel&eacute;fono</span></td>
                                                <td width="10"></td>
                                                <td width="440" align="left"><span class="letraTituloCampoRegistro">Correo electr&oacute;nico</span></td>
                                            </tr>
                                            <tr height="50">
                                            	<td></td>
                                                <td align="left">
                                                	<table border="0">
                                                        <tr height="60">
                                                            <td valign="top" >
                                                                <table width="20" border="0" cellspacing="1" cellpadding="1">
                                                                <tr>
                                                                <?php if($idUsuario=="") 
                                                                        $idUsuario=0;
                                                                ?>
                                                                <td width="19"><a href="javaScript:mostrarVentanaAgregarCelular()"><img src="../images/icon_big_tick.gif" alt="Agregar" height="15" title="Agregar Teléfono" border='0'/></a></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><a href="javaScript:eliminarTelefono(0)"><img src="../images/cancel_round.png" alt="Eliminar" title="Eliminar Teléfono" border='0'/></a></td>
                                                                </tr>
                                                                </table>
                                                            </td>
                                                            <td width="270" valign="top">
                
                                                                    <select class="SIUGJ_Control"  id="cmbTelefono" size="3" style="width:380px; height:80px !important">
                                                                      <?php
                                                                      if(isset($idUsuario))
                                                                      {
                                                                            $consulta="SELECT * FROM 804_telefonos WHERE idUsuario=".$idUsuario." and Numero<>'' ORDER BY IdTelefono";															  
                                                                            $res=$con->obtenerFilas($consulta);
                                                                            while($fila=$con->fetchAssoc($res))
                                                                            {
                
                                                                                $tTelefono="";
                                                                                switch($fila["Tipo2"])
                                                                                {
                                                                                    case "1":
                                                                                        $tTelefono='Fijo';
                                                                                    break;
                                                                                    case "2":
                                                                                        $tTelefono='Celular';
                                                                                    break;
                                                                                }
                                                                                
                                                                                $consulta="SELECT nombre FROM 238_paises WHERE idPais=".($fila["codArea"]==""?-1:$fila["codArea"]);
                                                                                $lblPais=$con->obtenerValor($consulta);
                                                                                if($lblPais=="")
                                                                                    $lblPais="N/E";
                                                                                $etiqueta='('.$tTelefono.') '.$fila["Numero"].($fila["Extension"]==''?'':' Ext. '.$fila["Extension"]).' ('.$lblPais.')';
                                                                                
                                                                                
                                                                                $idOpcion=$fila["codArea"]."_".$fila["Numero"]."_".$fila["Extension"]."_".$fila["Tipo2"]."_".$fila["verificado"];
                                                                                echo '<option value="'.$idOpcion.'">'.$etiqueta.'</option>';
                                                                                
                                                                            }
                                                                      }
                                                                      ?>
                                                                    </select>
                                                                    <input type="hidden" name="telefonos" id="telefonos" value="" />
                
                                                            </td>
                                                            
                                                        </tr>
                                                	</table>
                                                </td>
                                                <td ></td>
                                                <td  align="left" >
                                                	<table>
                                                	<tr>
                                                   
                                                    <td valign="top">
                                                      <table width="20" border="0" cellspacing="1" cellpadding="1">
                                                      <tr>
                                                        <td><a href="javaScript:solicitarMail(<?php echo $idUsuario;?>,0)"><img src="../images/icon_big_tick.gif" height="15" title="Agregar Correo Electrónico" border='0'/></a></td>
                                                      </tr>
                                                      <tr>
                                                        <td><a href="javaScript:eliminarMail(0)"><img src="../images/cancel_round.png" title="Eliminar Correo Electrónico" border='0'/></a></td>
                                                      </tr>
                                                      </table>
                                                    </td>
                                                    <td valign="top">
                                                      <label>
                                                      <select class="SIUGJ_Control"   id="cmbMail" size="3" style="width:380px; height:80px !important">
                                                        <?php
                                                          if(isset($idUsuario))
                                                              $con->generarOpcionesSelect("SELECT concat(Mail,'/0','/',Notificacion),Mail FROM 805_mails WHERE Tipo=0 AND idUsuario=".$idUsuario);
                                                        ?>
                                                      </select>
                                                      <input type="hidden" name="correos" id="correos" value="" />
                                                      </label>
                                                    </td>
                                                </tr>
                                                </table>
                                                
                                                </td>
                                            </tr>
				  					
  									
									</table>
                                    <br /><br />
									</fieldset>
                                	<br /><br />
								<fieldset class="frameSiugj" style="width:850px"><br /><br />
									<table width="100%">
                                    
                                    <tr>
                                        <td align="left" width="30">
                                        <td colspan="3" align="left">
                                        <span class="letraTituloSeccion">Direcci&oacute;n personal</span>
                                        </td>
                                    </tr>
                                     <tr height="50">
                                        <td></td>
                                        <td width="440" align="left"><span class="letraTituloCampoRegistro">Direcci&oacute;n</span></td>
                                        <td width="10"></td>
                                        <td width="440" align="left"><span class="letraTituloCampoRegistro" style="display:none">Barrio</span></td>
                                    </tr>
                                    <tr height="50">
                                        <td></td>
                                        <td  align="left"  colspan="3">
                                        	<input class="SIUGJ_Control"  style="width:800px" type="text" name="direccion" id="direccion" campo="Direcci&oacute;n" value="<?php echo $cInfo["Calle"] ?>" />
                                            <input class="SIUGJ_Control" style="display:none"  style="width:380px" type="text" name="colonia" id="colonia" campo="Barrio" value='<?php echo $cInfo["Colonia"] ?>' />
                                        </td>
                                        
                                    </tr>
                                    <tr height="50">
                                        <td></td>
                                        <td width="440" align="left"><span class="letraTituloCampoRegistro">País</span></td>
                                        <td width="10"></td>
                                        <td width="440" align="left"><span class="letraTituloCampoRegistro">Departamento</span></td>
                                    </tr>
                                    <tr height="50">
                                        <td></td>
                                        <td align="left">
                                        	<select name="Pais" onchange="paisResidenciaChange(this)" class="SIUGJ_Control" style="width:380px">
                                            <option value="-1">Seleccione</option>
                                            <?php
                                                $consulta="SELECT idPais,nombre FROM 238_paises ORDER BY nombre";
                                                $con->generarOpcionesSelect($consulta,$cInfo["Pais"]);
                                                if($cInfo["Ciudad"]=="-1")
                                                    $cInfo["Ciudad"]="";
                                                if($cInfo["Estado"]=="-1")
                                                    $cInfo[""]="";
                                                
                                            ?>
                                            </select>
                                        
                                        </td>
                                        <td ></td>
                                        <td  align="left">
                                        	<select name="Estado" id="cmbEstado" onchange="estadoSel(this)" class="SIUGJ_Control" style="width:380px">
                                            <option value="-1">Seleccione</option>
                                            <?php
                                                $consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
                                                $con->generarOpcionesSelect($consulta,$cInfo["Estado"]);
                                            ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr height="50">
                                        <td></td>
                                        <td width="440" align="left"><span class="letraTituloCampoRegistro">Municipio</span></td>
                                        <td width="10"></td>
                                        <td width="440" align="left"><span class="letraTituloCampoRegistro" style="display:none">C&oacute;digo postal</span></td>
                                    </tr>
                                    <tr height="50">
                                        <td></td>
                                        <td align="left">
                                        	<select name="Ciudad" id="cmbCiudad" class="SIUGJ_Control" style="width:380px">
                                           <option value="-1">Seleccione</option>
                                           <?php
										   		$consulta=" SELECT cveMunicipio,municipio FROM 821_municipios WHERE cveEstado='".$cInfo["Estado"]."'";
												$con->generarOpcionesSelect($consulta,$cInfo["Ciudad"]);
										   ?>
                                           </select>
                                        
                                        </td>
                                        <td ></td>
                                        <td  align="left">
                                        	<input style="display:none" class="SIUGJ_Control"  size="42" type="text" name="CP" id="CP" campo="Código Postal" value='<?php echo ($cInfo["CP"])?>' onkeypress="return soloNumero(event,false,false,this)"/>
                                        </td>
                                    </tr>
                                   
									
                                </table>
                             </fieldset><br /><br />
                            
                            	<fieldset class="frameSiugj" style="width:850px" ><br /><br />
                                    	<table width="100%">
                                        	<tr>
                                            	<td align="left" width="30">
                                            	<td colspan="3" align="left">
                                                <span class="letraTituloSeccion">Datos de la cuenta</span>
                                                </td>
                                            </tr>
                                            
                                            <tr class="">
                                              <td></td>
                                               <td align="left" colspan="14">
                                                  <span class="SIUGJ_ControlEtiqueta"><?php echo $lblEtiqueta?></span><br />
                                               </td>
                                          </tr>
											 
											 
                                            <tr height="40">
                                            	<td></td>
                                                <td width="440" align="left"><span class="letraTituloCampoRegistro">Usuario *</span></td>
                                                <td width="10"></td>
                                                <td width="440" align="left"><span class="letraTituloCampoRegistro"></span></td>
                                            </tr>
                                            <tr height="50">
                                            	<td></td>
                                                <td align="left">
                                                	
													<div style="width:380px; padding-top: 10px;" class="SIUGJ_ControlEtiqueta"><?php echo $cInfoPasswd["Login"] ?></div>
													<input type="hidden" name="cmbLogin" value="<?php echo $cInfoPasswd["Login"] ?>" />
													
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
                                                	<input size="20" type="password" class="SIUGJ_Control"  style="width:380px" name="Contrasena" id="Contrasena" val="obl" campo="Contraseña" value='<?php echo ($cInfoPasswd["Password"]);?>'/>
                                                </td>
                                                <td></td>
                                                <td  align="left">
                                                	<input  size="20" type="password" class="SIUGJ_Control"  style="width:380px" name="Contrasena2" id="Contrasena2" val="obl" campo="Confirmar Contraseña" value='<?php echo ($cInfoPasswd["Password"]);?>'/>
                                                </td>
                                            </tr>
                                             
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
                            
                            
                             <fieldset class="frameHijo" style="display:none"><legend><b>HUELLAS DIGITALES CAPTURADAS</b></legend>
                             	<br>
                                <span id="tblHuellas"></span>
                                </br>
							</fieldset>
							
                            
                                  
            				</td>
         				 </tr>
        					</table>
                            </td>
                            </tr>
                            <tr>
                            	<td>
                                	
                                    <table width="100%">
                                    <tbody><tr>
                                        <td align="center">
                                            	<table>
                                                <tbody>
                                                <tr>
                                                    <td width="110"><span id="contenedor2"></span></td>
                                                    <td width="10"></td>
                                                    <td width="110"><span id="contenedor1"></span></td>
                                                </tr>
                                                </tbody>
                                                </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                    </table>
                                    
                                </td>
                            </tr>
                            </table>
                            <input type="hidden" name="bandera" id="bandera" value="<?php echo $bandera ?>" />
                            <?php 
							if($regresaPagInicio)
							{
							?>
                            	<input type="hidden" name="regresaPagInicio" value="1" />
                            <?php
							}
							?>
                            <input type="hidden" name="pRedireccion" value="<?php  echo (isset($_POST["pRedireccion"]))?$_POST["pRedireccion"]:"" ?>" />
							</form>
							<?php
							
							
                            if($actualizado==1)
							{
							?>
                            <script>
							window.parent.setNombreUsuario('<?php echo $lblNombre?>');
							</script>
                            <?php
							}
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

