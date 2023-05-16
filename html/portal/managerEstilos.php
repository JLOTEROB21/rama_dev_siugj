<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");

$pagRegresar="../principal/inicio.php";
global $con;
$sqlN = "SELECT *FROM 4081_colorEstilo";
$filaU= $con->obtenerPrimeraFila($sqlN);
$temp=$filaU[0];
if($temp!=NULL)
{
	$colorFondoEx=$filaU[0];
	$colorFondoIn=$filaU[1];
	$colorMenu=$filaU[2];
	$colorBarraIn=$filaU[3];
	$colorMenuIn=$filaU[4];
	$colorBanner=$filaU[5];
	$colorLink=$filaU[6];
	$colorTiTabla=$filaU[7];
	$colorCelda1=$filaU[8];
	$colorCelda2=$filaU[9];
	$colorLeTabla=$filaU[10];
	$colorTxTabla=$filaU[11];
	$colorFuMenu=$filaU[12];
	$colortamFuMenu=$filaU[13];
	$colorBordeIn=$filaU[14];
	$colorBoton=$filaU[15];
	$disenoBanner=$filaU[16];
	$colorLeNivel1=$filaU[20];
	$colorLeNivel2=$filaU[21];
	$tituloMenuIzq=$filaU[22];
	$colorLePieIzq=$filaU[23];
	$colorTxTabla1=$filaU[24];
	$colorTxTabla2=$filaU[25];
	$colorTxTabla3=$filaU[26];
	$colorTxTabla4=$filaU[27];
	$colorTxTabla5=$filaU[29];
	$colorCelda3=$filaU[28];
	$colorBorde1=$filaU[30];
	
	$colortxtImpre1=$filaU[31];
	$colortxtImpre2=$filaU[32];
	$colorCeldaImp1=$filaU[33];
	$colorCeldaImp2=$filaU[34];
	
	
	$txtIzq=$filaU[17];
	$txtDer=$filaU[18];
	$txtTitPagina=$filaU[19];
	
	$selImagen="";
	$selColor="";
	$idImagen="-1";
	$idImagen2="-1";
	$mostrarImg="none";
	$mostrarColor="none";
	if($colorBoton=="")
	{
		$selImagen='checked="checked"';
		$consulta="select idArchivo from 4080_archivosEditor where tipoArchivo=4";
		$idImagen=$con->obtenerValor($consulta);
		$mostrarImg='';
		
	}
	else
	{
		$selColor='checked="checked"';
		$mostrarColor='';
	}
}
else
	header('location:defaultE.php');

{
	
		$consulta2="select idArchivo from 4080_archivosEditor where tipoArchivo=100";
		$idImagen2=$con->obtenerValor($consulta2);		
	}
	
	if($idImagen2=="")
	{
		$idImagen2="-1";
		
	}
	

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
	$mostrarMenuIzq=false;
?>

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
<?php
	$pagRegresar="../principal/inicio.php";
?>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../Scripts/jscolor/jscolor.js"></script>
<script type="text/javascript" src="Scripts/managerEstilos.js.php"></script>
<script type="text/javascript" src="../Scripts/Ext.ux.FCKEditor/construyeFCKEditor.js"></script>
<script type="text/javascript" src="../Scripts/fckeditor/fckeditor.js"></script>
<script type="text/javascript" src="../Scripts/Ext.ux.FCKEditor/visorImg.js.php"></script>
<script type="text/javascript" src="../Scripts/ext/ux/FileUploadField.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ext/ux/file-upload.css" />
<link rel="stylesheet" type="text/css" href="../Scripts/Ext.ux.FCKEditor/FCKeditor.css" />
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
<style type="text/css">
<!--
#g {
	text-align: left;
}
-->
</style>
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
                        	<script type='text/javascript'>
							   <?php  
						   			$contenido=str_replace("'","\\'",$disenoBanner);
                                   echo "var contenido='".bE($contenido)."';";
								   $pIzq=str_replace("'","\\'",$txtIzq);
								   echo "var pieIzq='".bE($pIzq)."';";
								   $pDer=str_replace("'","\\'",$txtDer);
								   echo "var pieDer='".bE($pDer)."';";
                                  ?>
						</script>
                        <form action="guardaBaseColor.php" method="POST" id="frmEnvio" enctype="multipart/form-data">
                        <fieldset class="frameHijo"><legend>Datos de página</legend><br /><br />
						<table width="100%">
                        <tr>
                        	 <td class="letraFicha" width="130">Título de página:</td>
                             <td width="130"><input name="tituloPagina" value="<?php echo $txtTitPagina; ?>" maxlength="60" size="60" ></td>
                                <td width="20"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                        </tr>
                        <tr>
                            <td colspan="7">
                            <br /><br />
                                <div align="center" id="textArea"></div>
                                <br /><br /><br />
                            </td>
                        </tr>
                         <tr>
                        	<td class="letraFicha" width="130" valign="top">Pie de página izquierdo:</td>
                            <td colspan="6">
                            	<div align="center" id="txtPieIzq"></div><br /><br /><br />
                            </td>
                           
                        </tr>
                         <tr>
                        	<td class="letraFicha" width="130" valign="top">Pie de página derecho:</td>
                            <td colspan="6"><div align="center" id="txtPieDer"></div><br /><br /><br />
                            </td>
                           
                        </tr>
                        
                        </table>
                        </fieldset>
                        <br /><br />
                        <fieldset class="frameHijo"><legend>Seleccione los Colores de Estilo</legend>
                        
                            <table width="100%">
                            <tr height="30">
                                 <td class="letraFicha" width="179">Fondo Externo:</td>
                                 <td width="128"><input name="colorFondoEx" class="color" value="<?php echo $colorFondoEx; ?>" ></td>
                                <td width="15"></td>
                                <td class="letraFicha">Color texto menú nivel 1 :</td>
                                <td width="212"><input name= "colorLeNivel1" class= "color" value="<?php echo $colorLeNivel1; ?>"></td>
                                <td width="5"></td>
                                <td width="9"></td>
                            </tr>
                            <tr height="30">
                                <td class="letraFicha">Menu Superior:</td>
                                <td><input name= "colorMenu" class= "color" value="<?php echo $colorMenu; ?>"></td>
                                <td width="15"></td>
                                 <td class="letraFicha">Color texto menú nivel 1 :</td>
                                <td><input name= "colorLeNivel2" class= "color" value="<?php echo $colorLeNivel2; ?>"></td>
                                <td></td>
                            </tr>
                            <tr height="30">
                                <td class="letraFicha">Barra Interna:</td>
                                <td><input name= "colorBarraIn" class= "color" value="<?php echo $colorBarraIn; ?>"></td>
                                <td width="15"></td>
                                <td class="letraFicha">Color texto pie de página :</td>
                                <td><input name= "colorLePieIzq" class= "color" value="<?php echo $colorLePieIzq; ?>" /></td>
                                <td></td>
                             </tr>
                             <tr height="30">
                                <td class="letraFicha">Color fondo área  central :</td>
                                <td><input name= "colorFondoIn" class= "color" value="<?php echo $colorFondoIn; ?>"></td>
                                <td width="15"></td>
                                <td class="letraFicha">Color fondo entre áreas :</td>
                                <td><input name= "colorBordeIn" class= "color" value="<?php echo $colorBordeIn; ?>" /></td>
                                <td></td>
                              </tr>  
                             <tr height="30">
                                <td class="letraFicha">Color fondo  banner:</td>
                                <td><input name= "colorBanner" class= "color" value="<?php echo $colorBanner; ?>"></td>
                                <td width="15"></td>
                                <td class="letraFicha">Color  título texto menú izq. :</td>
                                <td><input name= "colorTxTabla3" class= "color" value="<?php echo $colorTxTabla3; ?>" /></td>
                                <td></td>
                             </tr>
                             <tr height="30">
                                <td class="letraFicha">Color fondo menu interno:</td>
                                <td><input name= "colorMenuIn" class= "color" value="<?php echo $colorMenuIn; ?>"></td>
                               <td width="15"></td>
                               <td class="letraFicha">Color texto menú izq. :</td>
                               <td><input name= "colorTxTabla4" class= "color" value="<?php echo $colorTxTabla4; ?>" /></td>
                               <td></td>
                             </tr>         
                             <tr height="30">
                                <td class="letraFicha">Fondo Segundo plano barra int. :</td>
                                <td><input name= "colorLink" class= "color" value="<?php echo $colorLink; ?>"></td>
                                <td width="15"></td>
                                <td class="letraFicha">Color  texto link menú izq. :</td>
                                <td><input name= "colorTxTabla2" class= "color" value="<?php echo $colorTxTabla2; ?>" /></td>
                                <td></td>
                             </tr>
                             <tr height="30">
                                <td class="letraFicha">Color encabezado tabla / Botón :</td>
                                <td><input name= "colorTiTabla" class= "color" value="<?php echo $colorTiTabla; ?>"></td>
                                <td width="15"></td>
                                 <td class="letraFicha" width="182">Color texto encabezado tabla / Botón:</td>
                                <td><input name= "colorLeTabla" class= "color" value="<?php echo $colorLeTabla; ?>" /></td>
                                <td></td>
                             </tr>
                             <tr height="30">
                                <td class="letraFicha">Color Fila inicial tabla:</td>
                                <td><input name= "colorCelda1" class= "color" value="<?php echo $colorCelda1; ?>"></td>
                                <td width="15"></td>
                                <td class="letraFicha">Color  Texto Celda fila inicial:</td>
                                <td><input name= "colorTxTabla1" class= "color" value="<?php echo $colorTxTabla1; ?>" /></td>
                                <td></td>
                             </tr>
                             <tr height="30">
                                <td class="letraFicha">Color segunda fila tabla:</td>
                                <td><input name= "colorCelda2" class= "color" value="<?php echo $colorCelda2; ?>"></td>
                                <td width="15"></td>
                                <td class="letraFicha">Color  Texto Celda segunda fila:</td>
                                <td><input name= "colorTxTabla" class= "color" value="<?php echo $colorTxTabla; ?>"></td>
                                <td></td>
                             </tr>
                             <tr height="30">
                                <td class="letraFicha">Fuente del Menu:</td>
                                <td>
                                    <select name="colorFuMenu">
                                    <option style="font-family : Arial">Arial</option>
                                    <option style="font-family : Courier">Courier</option>
                                    <option style="font-family : Tahoma">Tahoma</option>
                                    <option style="font-family : 'Times New Roman'">Times New Roman</option>
                                    <option style="font-family : Verdana">Verdana</option>
                                    </select>
                                </td>
                                <td width="15"></td>
                                <td class="letraFicha">Tamaño Letra del Menu:</td>
                                <td class="letraFicha">
                                    <select name="tamFuMenu">
                                    	<?php 
											$con->generarNumeracionSelect(8,30,$colortamFuMenu);
										
										?>
                                    	
                                      
                                    </select>&nbsp; px
                                </td>
                                <td></td>
                             </tr>
                             <tr height="30">
                               <td height="30" class="letraFicha">Color celda interna tabla:</td>
                               <td><input name= "colorCelda3" class= "color" value="<?php echo $colorCelda3; ?>"></td>
                               <td></td>
                               <td class="letraFicha">Color  Texto Celda interna tabla:</td>
                               <td class="letraFicha"><input name= "colorTxTabla5" class= "color" value="<?php echo $colorTxTabla5; ?>" /></td>
                               <td></td>
                             </tr>
                             <tr height="30">
                               <td height="30" class="letraFicha">Color borde celdas:</td>
                               <td><input name= "colorBorde1" class= "color" value="<?php echo $colorBorde1; ?>" /></td>
                               <td></td>
                               <td class="letraFicha">&nbsp;</td>
                               <td class="letraFicha">&nbsp;</td>
                               <td></td>
                             </tr>
                             <tr height="30">
                               <td class="letraFicha">Color txt Fila 1 impresi&oacute;n:</td>
                               <td><input name= "colortxtImpre1" class= "color" value="<?php echo $colortxtImpre1; ?>" /></td>
                               <td></td>
                               <td class="letraFicha">Color txt Fila 2 impresi&oacute;n:</td>
                               <td><input name= "colortxtImpre2" class= "color" value="<?php echo $colortxtImpre2; ?>" /></td>
                               <td></td>
                             </tr>
                             <tr height="30">
                               <td class="letraFicha">Color fondo fila 1 impresi&oacute;n:</td>
                               <td><input name= "colorCeldaImp1" class= "color" value="<?php echo $colorCeldaImp1; ?>" /></td>
                               <td></td>
                               <td class="letraFicha">Color fondo fila 2 impresi&oacute;n:</td>
                               <td><input name= "colorCeldaImp2" class= "color" value="<?php echo $colorCeldaImp2; ?>" /></td>
                               <td></td>
                             </tr>
                             
                             
                            </table>
    
							<input type="hidden" name="valorContenido" id="valorContenido" value="" />
                            <input type="hidden" name="valorPieIzq" id="valorPieIzq" value="" />
                            <input type="hidden" name="valorPieDer" id="valorPieDer" value="" />
                            
                            </fieldset> 
                            
                            <br />
                            <br />
                            <fieldset class="frameHijo"><legend>Botones de imagen o color plano</legend>
                            <table width="100%">
                                 <tr height="30">
                                   <td class="letraFicha" width="100">
                                    <input name="botonRadioMenu"  id="radioColor" type="radio"   value="color"   <?php echo $selColor ?>  onclick="mostrarColor(this)" />&nbsp;&nbsp;Color
                                  </td>
                                  <td class="letraFicha">
                                    <span id="divColor" style="display:<?php echo $mostrarColor ?>;"  > Selecione color <input name= "colorBoton" id="colorBoton" type="text" class= "color" value="<?php echo $colorBoton; ?>" size="12" />  </span>
                                  </td>
                                   <td></td>
                                  </tr>
                                  
                                 <tr height="30">   
                                    <td class="letraFicha">
                                        <input name="botonRadioMenu"  id="radioImagen" type="radio"  value="imagen" <?php echo $selImagen ?> onclick="mostrarImagen(this)"   />&nbsp;&nbsp;Imagen
                                    </td>
                                    <td class="letraFicha" valign="top">
                                    	<span id="divImagen" style="display:<?php echo $mostrarImg?>;">
                                        <table>
                                        <tr>
                                            <td>
                                            
                                            <?php 
                                            if($idImagen!="-1")
                                            {
                                            ?>
                                            <img src="../media/verImagen.php?id=<?php echo $idImagen ?>" height="25" width="25" />
                                            
                                            <?php 
                                            }
                                            ?>
                                            </td>
                                        <td valign="top">&nbsp;&nbsp;
                                      	  <input name="up" id="up" type="file" size="15" /> 
                                        </td>
                                        </tr>
                                        </table>
                                        </span>  
                                    </td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td align="right" class="letraFicha">Imagen de Bulet</td>
                                    <td align="left"><table >
                                      <tr>
                                        <td width="74"><?php 
                                            if($idImagen2!="-1")
                                            {
                                            ?>
                                          <img src="../media/verImagen.php?id=<?php echo $idImagen2 ?>" height="25" width="25" />
                                          <?php 
                                            }
                                            ?></td>
                                        <td width="139" valign="top">&nbsp;&nbsp;
                                          <input name="up2" id="up2" type="file" size="15" /></td>
                                      </tr>
                                    </table></td>
                                    <td align="center">&nbsp;</td>
                                    <td align="center">&nbsp;</td>
                                    <td align="center">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="center" colspan="5"><br /><br /><br />
                                         <INPUT TYPE="button" VALUE="Guardar" class="tituloTabla" onclick="guardar()"> &nbsp;&nbsp;
                                         <input type="button" VALUE="Restaurar Valores predeterminados..." class="tituloTabla" onclick="restaurar()">
                                    </td>
                                 </tr>
                                 
                            </table>  
                            </fieldset>      
                        
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
