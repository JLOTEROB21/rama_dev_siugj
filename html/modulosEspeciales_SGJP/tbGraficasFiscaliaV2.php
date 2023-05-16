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
                        	$fechaInicio="-1";
							$fechaFin="-1";
							
							$urlGraficas="/media/ChartsV2/";
							
							if(isset($_POST["fechaInicio"]))
								$fechaInicio=$_POST["fechaInicio"];
							
							if(isset($_POST["fechaFin"]))
								$fechaFin=$_POST["fechaFin"];	
							
							
							
							
							$x=0;
							$grafica[$x]=new FusionCharts("StackedBar3D",1200,700);
							$grafica[$x]->setSWFPath($urlGraficas);
							$grafica[$x]->defineStyle("titulo","font","font=Calibri;size=16;");
							$grafica[$x]->applyStyle("CAPTION","titulo");
							$titulo="Distribución de solicitudes por fiscalías (Desconcentradas) Periodo: Del ".date("d/m/Y",strtotime($fechaInicio))." al ".date("d/m/Y",strtotime($fechaFin));
							
							$strParam="baseFont=Calibri;baseFontSize=12;labelDisplay=WRAP;showToolTip=1;";
							$strParam.="showAboutMenuItem=0;exportEnabled=1;exportAtClient=0;exportAction=download;exportHandler=".$urlSitio."include/latis/ExportHandlers/PHP/FCExporter.php;
										exportFormats=PNG=Exportar como PNG;exportDialogMessage=Capturando imagen, por favor espere ;showPrintMenuItem=0;exportFileName=asistenciaSemanal.png";
							$strParam.=";caption=".$titulo.";showLegend=1;formatNumberScale=0;decimalPrecision=0;showValues=0;showNames=1;rotateNames=1;bgColor=FFFFFF;
										valuePadding=5;canvasPadding=10;showBorder=0;chartRightMargin=40;palette=1;showSum=1";	
							$grafica[$x]->setChartParams($strParam);
							
							$arrFiscalias=array();
							$consulta="SELECT id__286_tablaDinamica,fiscalia FROM _286_tablaDinamica WHERE tipoFiscalia=1 ORDER BY fiscalia";
							$res=$con->obtenerFilas($consulta);
							while($fila=mysql_fetch_row($res))
							{
								$arrFiscalias[$fila[0]]=$fila[1];
								$grafica[$x]->addCategory($fila[1]);
							}
							
							$grafica[$x]->addDataset("Robo");	
							foreach($arrFiscalias as $idFiscalia=>$resto)
							{
								$consulta="SELECT COUNT(*) FROM _46_tablaDinamica t,_100_tablaDinamica f,_61_tablaDinamica d WHERE 
										t.fechaCreacion>='".$fechaInicio."' AND t.fechaCreacion<='".$fechaFin."' AND t.idEstado>1.4
											AND f.idReferencia=t.id__46_tablaDinamica AND f.claveFiscalia=".$idFiscalia." 
											AND d.idActividad=t.idActividad AND d.denominacionDelito 
											IN(11,15,16,17,18,19,20,21,10080,10081,10082,10083,10167,10192,10193,10194,10195,10196)";
											
								$nSolicitudes=$con->obtenerValor($consulta);
								$grafica[$x]->addChartData($nSolicitudes);
							}
							
							$grafica[$x]->addDataset("Violencia familiar");	
							foreach($arrFiscalias as $idFiscalia=>$resto)
							{
								$consulta="SELECT COUNT(*) FROM _46_tablaDinamica t,_100_tablaDinamica f,_61_tablaDinamica d WHERE 
										t.fechaCreacion>='".$fechaInicio."' AND t.fechaCreacion<='".$fechaFin."' AND t.idEstado>1.4
											AND f.idReferencia=t.id__46_tablaDinamica AND f.claveFiscalia=".$idFiscalia." 
											AND d.idActividad=t.idActividad AND d.denominacionDelito 
											IN(10089,10090)";
											
								$nSolicitudes=$con->obtenerValor($consulta);
								$grafica[$x]->addChartData($nSolicitudes);
							}
							
							$grafica[$x]->addDataset("Narcomenudeo");	
							foreach($arrFiscalias as $idFiscalia=>$resto)
							{
								$consulta="SELECT COUNT(*) FROM _46_tablaDinamica t,_100_tablaDinamica f,_61_tablaDinamica d WHERE 
										t.fechaCreacion>='".$fechaInicio."' AND t.fechaCreacion<='".$fechaFin."' AND t.idEstado>1.4
											AND f.idReferencia=t.id__46_tablaDinamica AND f.claveFiscalia=".$idFiscalia." 
											AND d.idActividad=t.idActividad AND d.denominacionDelito 
											IN(10241)";
											
								$nSolicitudes=$con->obtenerValor($consulta);
								$grafica[$x]->addChartData($nSolicitudes);
							}
							
							$grafica[$x]->addDataset("Homicidio");	
							foreach($arrFiscalias as $idFiscalia=>$resto)
							{
								$consulta="SELECT COUNT(*) FROM _46_tablaDinamica t,_100_tablaDinamica f,_61_tablaDinamica d WHERE 
										t.fechaCreacion>='".$fechaInicio."' AND t.fechaCreacion<='".$fechaFin."' AND t.idEstado>1.4
											AND f.idReferencia=t.id__46_tablaDinamica AND f.claveFiscalia=".$idFiscalia." 
											AND d.idActividad=t.idActividad AND d.denominacionDelito 
											IN(12,10066,10123,10125,10126,10127,10128,10130,10131)";
											
								$nSolicitudes=$con->obtenerValor($consulta);
								$grafica[$x]->addChartData($nSolicitudes);
							}
							
							$grafica[$x]->addDataset("Otros");	
							foreach($arrFiscalias as $idFiscalia=>$resto)
							{
								$consulta="SELECT COUNT(*) FROM _46_tablaDinamica t,_100_tablaDinamica f,_61_tablaDinamica d WHERE 
										t.fechaCreacion>='".$fechaInicio."' AND t.fechaCreacion<='".$fechaFin."' AND t.idEstado>1.4
											AND f.idReferencia=t.id__46_tablaDinamica AND f.claveFiscalia=".$idFiscalia." 
											AND d.idActividad=t.idActividad AND d.denominacionDelito not
											IN(11,15,16,17,18,19,20,21,10080,10081,10082,10083,10167,10192,10193,10194,10195,10196,
											10089,10090,
											10241,
											12,10066,10123,10125,10126,10127,10128,10130,10131)";
											
								$nSolicitudes=$con->obtenerValor($consulta);
								$grafica[$x]->addChartData($nSolicitudes);
							}
							
							$grafica[$x]->renderChart(true,true);
							$x++;
							
							
							$grafica[$x]=new FusionCharts("StackedBar3D",1200,700);
							$grafica[$x]->setSWFPath($urlGraficas);
							$grafica[$x]->defineStyle("titulo","font","font=Calibri;size=16;");
							$grafica[$x]->applyStyle("CAPTION","titulo");
							$titulo="Distribución de solicitudes por fiscalías (Especializadas), Periodo: Del ".date("d/m/Y",strtotime($fechaInicio))." al ".date("d/m/Y",strtotime($fechaFin));
							
							$strParam="baseFont=Calibri;baseFontSize=12;labelDisplay=WRAP;showToolTip=1;";
							$strParam.="showAboutMenuItem=0;exportEnabled=1;exportAtClient=0;exportAction=download;exportHandler=".$urlSitio."include/latis/ExportHandlers/PHP/FCExporter.php;
										exportFormats=PNG=Exportar como PNG;exportDialogMessage=Capturando imagen, por favor espere ;showPrintMenuItem=0;exportFileName=asistenciaSemanal.png";
							$strParam.=";caption=".$titulo.";showLegend=1;formatNumberScale=0;decimalPrecision=0;showValues=0;showNames=1;rotateNames=1;bgColor=FFFFFF;
										valuePadding=5;canvasPadding=10;showBorder=0;chartRightMargin=40;palette=1;showSum=1";	
							$grafica[$x]->setChartParams($strParam);
							
							$arrFiscalias=array();
							$consulta="SELECT id__286_tablaDinamica,fiscalia FROM _286_tablaDinamica WHERE tipoFiscalia=2 ORDER BY fiscalia";
							$res=$con->obtenerFilas($consulta);
							while($fila=mysql_fetch_row($res))
							{
								$consulta="SELECT COUNT(*) FROM _46_tablaDinamica t,_100_tablaDinamica f WHERE 
										t.fechaCreacion>='".$fechaInicio."' AND t.fechaCreacion<='".$fechaFin."' AND t.idEstado>1.4
											AND f.idReferencia=t.id__46_tablaDinamica AND f.claveFiscalia=".$fila[0];
											
								$nSolicitudes=$con->obtenerValor($consulta);
								if($nSolicitudes>0)
								{
									$arrFiscalias[$fila[0]]=$nSolicitudes;
									$grafica[$x]->addCategory($fila[1]);
								}
							}
							
							$grafica[$x]->addDataset("Total solicitudes");	
							foreach($arrFiscalias as $idFiscalia=>$resto)
							{
								
								$grafica[$x]->addChartData($resto);
							}
							
							
							
							$grafica[$x]->renderChart(true,true);
							$x++;
							
							
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
