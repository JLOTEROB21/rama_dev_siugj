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
<link rel="stylesheet" type="text/css" href="../../css/hayas.css.php" media="screen" />
<link rel="stylesheet" type="text/css" href="../../estilos/estilos.css" media="screen" />
<!--[if IE 8]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE7.css" media="screen" /><![endif]-->
<!--[if IE 6]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE6.css" media="screen" /><![endif]-->
<!--[if IE]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
<?php
if(!isset($excluirExt))
{
?>
<link rel="stylesheet" type="text/css" href="../../Scripts/ext/resources/css/ext-all.css.cgz"/>
<script type="text/javascript" src="../../Scripts/ext/adapter/ext/ext-base.js.jgz"></script>
<script type="text/javascript" src="../../Scripts/ext/ext-all.js.jgz"></script>
<script type="text/javascript" src="../../Scripts/ext/idioma/ext-lang-es.js"></script>
<?php
}
?>
<script type="text/javascript" src="../../Scripts/funcionesAjax.js.jgz"></script>
<script type="text/javascript" src="../../Scripts/funcionesGenerales.js"></script>


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
<script src="../../Scripts/ChartsJS/chart.min.js"></script>
<script src="../../Scripts/ChartsJS/utils.js"></script>
<script src="../../Scripts/ChartsJS/chartjs-plugin-datalabels.min.js"></script>

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
<link rel="stylesheet" type="text/css" href="../../principalPortal/css/controlesFrameWork.css"/>
<link rel="stylesheet" type="text/css" href="../../principalPortal/css/estiloSIUGJ.css"/>
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
<script type="text/javascript" src="../../Scripts/funcionesUtiles.js.php"></script>
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
			                		<a href="javascript:ingresarSistema()"><img src="../../images/botonIngreso.png"  /></a><a href="javascript:mostrarVentanaDuda()"><img src="../../images/botonSoporte.png"  /></a>
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
			                		<a href="javascript:cerrarSesion()"><img src="../../images/botonSalir.png" /></a>
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
											<a href="<?php echo $pagRegresar ?>" class="letraVerde"><img width="24" height="24" src="../../images/flechaizq.gif" border="0" /></a>
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
							$urlGraficas="/media/ChartsV2/";
							$fechaInicio="";
							if(isset($objParametros->fechaInicio))
								$fechaInicio=$_POST["fechaInicio"];
							
							$fechaFin="";
							if(isset($objParametros->fechaFin))
								$fechaFin=$_POST["fechaFin"];
							
							
							$condWhere="";
							
							if($_SESSION["idUsr"]==2158)
							{
								$condWhere=" and id__17_tablaDinamica in(36,53,51,49,52)";
								
							}
							$lblEtiquetas="";
							$consulta="SELECT id__17_tablaDinamica,claveUnidad,nombreCorto,colorAsociado FROM _17_tablaDinamica WHERE cmbCategoria=1 ".$condWhere." ORDER BY prioridad";
							$res=$con->obtenerFilas($consulta);
							while($fila=mysql_fetch_row($res))
							{
								if($lblEtiquetas=="")
									$lblEtiquetas="'".$fila[2]."'";
								else
									$lblEtiquetas.=",'".$fila[2]."'";
							}
							
							$lblEtiquetas.=",'Total'";
							$lblEtiquetas="[".$lblEtiquetas."]";
							
							
							if(mysql_num_rows($res)>0)
							{
								mysql_data_seek($res,0);
							}
							
							$arrDocumentosGenerados=array();
							$dataSet1="";
							$totalGlobal=0;
							while($fila=mysql_fetch_row($res))
							{
								$consulta="SELECT COUNT(*) FROM 7035_informacionDocumentos i,7006_carpetasAdministrativas c,3000_formatosRegistrados f WHERE 
									i.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$fila[1]."' AND f.idFormulario=-2 AND f.idRegistro=i.idRegistro
									AND f.fechaRegistro>='".$fechaInicio."' AND f.fechaRegistro<='".$fechaFin."'";
								$total=$con->obtenerValor($consulta);
								
								
								
								
								$consulta="SELECT COUNT(*) FROM _293_tablaDinamica i,7006_carpetasAdministrativas c,3000_formatosRegistrados f  WHERE 
								i.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$fila[1]."' AND f.idFormulario=293 AND f.idRegistro=i.id__293_tablaDinamica
								AND f.fechaRegistro>='".$fechaInicio."' AND f.fechaRegistro<='".$fechaFin."'";
								
								$total+=$con->obtenerValor($consulta);
								
								
								$consulta="SELECT COUNT(*) FROM 7028_actaNotificacion i,7006_carpetasAdministrativas c,3000_formatosRegistrados f  WHERE 
											i.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$fila[1]."' AND f.idFormulario=-1 AND f.idRegistro=i.idRegistro
											AND f.fechaRegistro>='".$fechaInicio."' AND f.fechaRegistro<='".$fechaFin."'";
								
								$total+=$con->obtenerValor($consulta);
								$totalGlobal+=$total;
								$arrDocumentosGenerados[$fila[1]]=$total;
								
								if($dataSet1=="")
									$dataSet1=$total;
								else
									$dataSet1.=",".$total;
							}
								
							$dataSet1.=",".$totalGlobal;
							
							
							if(mysql_num_rows($res)>0)
							{
								mysql_data_seek($res,0);
							}
							$arrDocumentosFirmados=array();
							$totalGlobal=0;
							$dataSet2="";
							while($fila=mysql_fetch_row($res))
							{
								$consulta="SELECT COUNT(*) FROM 7035_informacionDocumentos i,7006_carpetasAdministrativas c,3000_formatosRegistrados f WHERE 
									i.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$fila[1]."' AND f.idFormulario=-2 AND f.idRegistro=i.idRegistro
									AND f.fechaRegistro>='".$fechaInicio."' AND f.fechaRegistro<='".$fechaFin."' and firmado=1";
								$total=$con->obtenerValor($consulta);
								
								
								
								
								$consulta="SELECT COUNT(*) FROM _293_tablaDinamica i,7006_carpetasAdministrativas c,3000_formatosRegistrados f  WHERE 
								i.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$fila[1]."' AND f.idFormulario=293 AND f.idRegistro=i.id__293_tablaDinamica
								AND f.fechaRegistro>='".$fechaInicio."' AND f.fechaRegistro<='".$fechaFin."' and firmado=1";
								
								$total+=$con->obtenerValor($consulta);
								
								
								
								
								$consulta="SELECT COUNT(*) FROM 7028_actaNotificacion i,7006_carpetasAdministrativas c,3000_formatosRegistrados f  WHERE 
											i.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$fila[1]."' AND f.idFormulario=-1 AND f.idRegistro=i.idRegistro
											AND f.fechaRegistro>='".$fechaInicio."' AND f.fechaRegistro<='".$fechaFin."' and firmado=1";
								
								$total+=$con->obtenerValor($consulta);
								$totalGlobal+=$total;
								$arrDocumentosFirmados[$fila[1]]=$total;
								
								if($dataSet2=="")
									$dataSet2=$total;
								else
									$dataSet2.=",".$total;
							}
								
							
							
							
							?>
										<div id="container" style="width:1200px" >
                                            <canvas id="canvas" ></canvas>
                                        </div>
                                        <script>
                                        
                                        var color = Chart.helpers.color;
                                        var horizontalBarChartData = {
                                                                        labels: <?php echo $lblEtiquetas?>,
                                                                        datasets: [
                                                                                    {
                                                                                        label: 'Documentos Generados',
                                                                                        borderColor: '#FF0000',
                                                                                        borderWidth: 2,
																						backgroundColor: color('#FF0000').alpha(0.8).rgbString(),
                                                                                        fill: false,
                                                                                        lineTension:0,
                                                                                        pointBorderWidth:2,
                                                                                        datalabels: {
                                                                                                        align: 'end',
                                                                                                        anchor: 'end'
                                                                                                    },
                                                                                        data: 	[
                                                                                                    <?php echo $dataSet1?>
                                                                                                ]
                                                                                    },
																					{
                                                                                        label: 'Documentos Firmados Electrónicamente',
                                                                                        borderColor: '#030',
                                                                                        borderWidth: 2,
                                                                                        backgroundColor: color('#030').alpha(0.8).rgbString(),
                                                                                        
																						fill: false,
                                                                                        lineTension:0,
                                                                                        pointBorderWidth:2,
                                                                                        datalabels: {
                                                                                                        align: 'end',
                                                                                                        anchor: 'end'
                                                                                                    },
                                                                                        data: 	[
                                                                                                    <?php echo $dataSet2?>
                                                                                                ]
                                                                                    }
                                                                        
                                                                                ]
                                                            
                                                                    };
                                
                                      
                                            var ctx = document.getElementById('canvas').getContext('2d');
                                            window.myGrafico = new Chart(ctx, {
                                                                                        type: 'horizontalBar',
                                                                                        data: horizontalBarChartData,
                                                                                        plugins: [ChartDataLabels],
                                                                                        
                                                                                        options: {
                                                                                                    responsive: true,
                                                                                                    legend: {
                                                                                                                position: 'bottom'
                                                                                                                
                                                                                                            },
                                                                                                    title: {
                                                                                                                display: true,
                                                                                                                fontSize:14,
                                                                                                                text: '<?php echo "Documentos Generados en el Periodo"?>'
                                                                                                            },
                                                                                                    scales: {
                                                                                                                xAxes: [
                                                                                                                            {
                                                                                                                                display: true,
                                                                                                                                ticks:	{
                                                                                                                                            autoSkip: false/*,
                                                                                                                                            maxRotation: 90,
                                                                                                                                            minRotation: 90*/
                                                                                                                                        }
                                                                                                                            }
                                                                                                                        ],
                                                                                                                yAxes: 	[
                                                                                                                            {
                                                                                                                                display: true
                                                                                                                            }
                                                                                                                        ]
                                                                                                            },
                                                                                                }
                                                                                    }
                                                                                );
                                
                                        
                                
                                        
                                        </script>
                                        
                    
                    <?php							
							
							
							if(mysql_num_rows($res)>0)
							{
								mysql_data_seek($res,0);
							}
							$totalGlobal=0;
							$lblEtiquetas="";
							$colores="";
							$dataSet1="";
							$numValores=0;
							while($fila=mysql_fetch_row($res))
							{
								if($dataSet1=="")
								{
									$dataSet1=$arrDocumentosFirmados[$fila[1]];
									$colores="color('#".$fila[3]."').alpha(0.7).rgbString()";
									
								
								}
								else
								{
									$dataSet1.=",".$arrDocumentosFirmados[$fila[1]];
									$colores.=",color('#".$fila[3]."').alpha(0.7).rgbString()";
								}
								$totalGlobal+=$arrDocumentosFirmados[$fila[1]];
								$numValores++;
							}
							
							
							if(mysql_num_rows($res)>0)
							{
								mysql_data_seek($res,0);
							}
							$porcentajeAcumulado=0;
							$posValor=0;
							while($fila=mysql_fetch_row($res))
							{
								if($posValor==$numValores-1)
								{
									$porcentaje=100-$porcentajeAcumulado;
								}
								else
								{
									$porcentaje=($arrDocumentosFirmados[$fila[1]]/$totalGlobal) * 100;
									$porcentajeAcumulado+=$porcentaje;
								
								}
								if($lblEtiquetas=="")
									$lblEtiquetas="'".$fila[2]." (".number_format($porcentaje,2)." %)'";
								else
									$lblEtiquetas.=",'".$fila[2]." (".number_format($porcentaje,2)." %)'";
								
								$posValor++;
									
							}
							$lblEtiquetas="[".$lblEtiquetas."]";
							
							$x++;
							
							?>	
                              <br><br>
                              <div id="container2" style="width: 80%;">
                                  <canvas id="canvas2" ></canvas>
                                   <div id="legend" ></div>
                              </div>
                              <br><br>
                              <script>
                              
                              var horizontalBarChartData = {
                                                              labels: <?php echo $lblEtiquetas?>,
                                                              datasets: [
                                                                          {
                                                                              label: '',
                                                                              backgroundColor: [<?php echo $colores?>],
                                                                              /*datalabels: 	{
                                                                                                align: 'end',
                                                                                                anchor: 'end'
                                                                                                
                                                                                            },*/
                                                                              borderWidth: 1,
                                                                              
                                                                              data: 	[
                                                                                          <?php echo $dataSet1?>
                                                                                      ]
                                                                          }
                                                              
                                                                      ]
                                                  
                                                          };
                        
                                  var ctx = document.getElementById('canvas2').getContext('2d');
                                  var chart=window.myHorizontalBar = new Chart(ctx, {
                                                                              type: 'pie',
                                                                              data: horizontalBarChartData,
                                                                              //plugins: [ChartDataLabels],
                                                                              options: {
																				  		 tooltips:	{
																							 			enabled:false
																							 		},
                                                                                         layout: {
                                                                                                    padding: {
                                                                                                                left: 10,
                                                                                                                right: 10,
                                                                                                                top: 10,
                                                                                                                bottom: 10
                                                                                                            }
                                                                                                },
                                                                                        plugins:	{
                                                                                                        datalabels: {
																															display: function(context) 
																																	{
    																																	return false; // display labels with an odd index
																																	}
                                                                                                                            
                                                                                                                    },
                                                                                                    },
                                                                                          indexAxis: 'y',
                                                                                          // Elements options apply to all of the options unless overridden in a dataset
                                                                                          // In this case, we are setting the border of each horizontal bar to be 2px wide
                                                                                          elements: {
                                                                                                          bar: {
                                                                                                                  borderWidth: 2,
                                                                                                              }
                                                                                                      },
                                                                                          responsive: true,
                                                                                          legend: {
                                                                                                      position: 'bottom',
                                                                                                      display: true,
                                                                                                      
                                                                                                  },
                                                                                          legend: {
                                                                                                      position: 'bottom',
                                                                                                      display: true,
																									  labels:	{
                                                                                                                        filter:function(i,c)
                                                                                                                                {
																																	
																																	return parseFloat((c.datasets[0].data[i.index]))>0;

                                                                                                                                    
                                                                                                                                }
                                                                                                                    }
                                                                                                      
                                                                                                  },
                                                                                          title: {
                                                                                                      display: true,
                                                                                                      fontSize:14,
                                                                                                      padding:40,
                                                                                                      text: 'Distribución de Documentos Firmados Electrónicamente'
                                                                                                  }
                                                                                      }
                                                                          }
                                                                      );
                        
                              
                        

                              
                              </script>
	
                       
                        <?php
							
							
							$lblEtiquetas="";
							$consulta="SELECT IF(id__1_tablaDinamica=8,'8,12',id__1_tablaDinamica) AS idRegistro,nombreInmueble FROM _1_tablaDinamica WHERE idEstado=2 AND id__1_tablaDinamica<>12";
							$res=$con->obtenerFilas($consulta);
							while($fila=mysql_fetch_row($res))
							{
								if($lblEtiquetas=="")
									$lblEtiquetas="'".$fila[1]."'";
								else
									$lblEtiquetas.=",'".$fila[1]."'";
								
							}
							$lblEtiquetas.=",'Total'";
							$lblEtiquetas="[".$lblEtiquetas."]";
							
							if(mysql_num_rows($res)>0)
							{
								mysql_data_seek($res,0);
							}
							
							$dataSet1="";
							$totalGlobal=0;
							while($fila=mysql_fetch_row($res))
							{
								$total=0;
								$consulta="SELECT claveUnidad FROM _17_tablaDinamica WHERE idReferencia in(".$fila[0].")";
								$rUnidad=$con->obtenerFilas($consulta);
								while($fUnidad=mysql_fetch_row($rUnidad))
								{
									if(isset($arrDocumentosGenerados[$fUnidad[0]]))
										$total+=$arrDocumentosGenerados[$fUnidad[0]];
								}
								$totalGlobal+=$total;
								
								if($dataSet1=="")
									$dataSet1=$total;
								else
									$dataSet1.=",".$total;
							}
								
							$dataSet1.=",".$totalGlobal;
							
							
							
							if(mysql_num_rows($res)>0)
							{
								mysql_data_seek($res,0);
							}
							$totalGlobal=0;
							$dataSet2="";
							while($fila=mysql_fetch_row($res))
							{
								$total=0;
								$consulta="SELECT claveUnidad FROM _17_tablaDinamica WHERE idReferencia in(".$fila[0].")";
								$rUnidad=$con->obtenerFilas($consulta);
								while($fUnidad=mysql_fetch_row($rUnidad))
								{
									if(isset($arrDocumentosFirmados[$fUnidad[0]]))
										$total+=$arrDocumentosFirmados[$fUnidad[0]];
								}
								$totalGlobal+=$total;
								
								if($dataSet2=="")
									$dataSet2=$total;
								else
									$dataSet2.=",".$total;
							}
								
							$dataSet2.=",".$totalGlobal;
							
							
					?>
										<div id="container3" style="width:1200px" >
                                            <canvas id="canvas3" ></canvas>
                                        </div>
                                        <script>
                                        
                                        var color = Chart.helpers.color;
                                        var horizontalBarChartData = {
                                                                        labels: <?php echo $lblEtiquetas?>,
                                                                        datasets: [
                                                                                    {
                                                                                        label: 'Documentos Generados',
                                                                                        borderColor: '#FF0000',
                                                                                        borderWidth: 2,
																						backgroundColor: color('#FF0000').alpha(0.8).rgbString(),
                                                                                        fill: false,
                                                                                        lineTension:0,
                                                                                        pointBorderWidth:2,
                                                                                        datalabels: {
                                                                                                        align: 'end',
                                                                                                        anchor: 'end'
                                                                                                    },
                                                                                        data: 	[
                                                                                                    <?php echo $dataSet1?>
                                                                                                ]
                                                                                    },
																					{
                                                                                        label: 'Documentos Firmados Electrónicamente',
                                                                                        borderColor: '#030',
                                                                                        borderWidth: 2,
                                                                                        backgroundColor: color('#030').alpha(0.8).rgbString(),
                                                                                        
																						fill: false,
                                                                                        lineTension:0,
                                                                                        pointBorderWidth:2,
                                                                                        datalabels: {
                                                                                                        align: 'end',
                                                                                                        anchor: 'end'
                                                                                                    },
                                                                                        data: 	[
                                                                                                    <?php echo $dataSet2?>
                                                                                                ]
                                                                                    }
                                                                        
                                                                                ]
                                                            
                                                                    };
                                
                                      
                                            var ctx = document.getElementById('canvas3').getContext('2d');
                                            window.myGrafico = new Chart(ctx, {
                                                                                        type: 'horizontalBar',
                                                                                        data: horizontalBarChartData,
                                                                                        plugins: [ChartDataLabels],
                                                                                        
                                                                                        options: {
                                                                                                    responsive: true,
                                                                                                    legend: {
                                                                                                                position: 'bottom'
                                                                                                                
                                                                                                            },
                                                                                                    title: {
                                                                                                                display: true,
                                                                                                                fontSize:14,
                                                                                                                text: '<?php echo "Documentos generados en el Periodo por Inmueble"?>'
                                                                                                            },
                                                                                                    scales: {
                                                                                                                xAxes: [
                                                                                                                            {
                                                                                                                                display: true,
                                                                                                                                ticks:	{
                                                                                                                                            autoSkip: false/*,
                                                                                                                                            maxRotation: 90,
                                                                                                                                            minRotation: 90*/
                                                                                                                                        }
                                                                                                                            }
                                                                                                                        ],
                                                                                                                yAxes: 	[
                                                                                                                            {
                                                                                                                                display: true
                                                                                                                            }
                                                                                                                        ]
                                                                                                            },
                                                                                                }
                                                                                    }
                                                                                );
                                
                                        
                                
                                        
                                        </script>
                                        
                    

                         
                    <?php							
							$arrColores[0]="FF0000";
							$arrColores[1]="003000";
							$arrColores[2]="120058";
							$arrColores[3]="84015D";
							$arrColores[4]="4B0184";
							$arrColores[5]="588401";
							$arrColores[6]="846101";
							$arrColores[7]="843101";
							$arrColores[8]="990000";
							$arrColores[9]="AEC70A";
							$arrColores[10]="E5215C";
							$arrColores[11]="D409CD";
							$arrColores[12]="7F43E8";
							$arrColores[13]="00AFB5";
							$arrColores[14]="3C9B5F";
							$arrColores[15]="77C728";
							$arrColores[16]="B2AF6B";
							$arrColores[17]="B2986B";
							$arrColores[18]="B27E6B";
							$arrColores[19]="B26B6B";
							$arrColores[20]="809FC9";
							
							
							if(mysql_num_rows($res)>0)
							{
								mysql_data_seek($res,0);
							}
							
							$arrTotalInmueble=array();
							$totalGlobal=0;
							$lblEtiquetas="";
							$numValores=0;
							$dataSet1="";
							while($fila=mysql_fetch_row($res))
							{
								$total=0;
								$consulta="SELECT claveUnidad FROM _17_tablaDinamica WHERE idReferencia in(".$fila[0].")";
								$rUnidad=$con->obtenerFilas($consulta);
								while($fUnidad=mysql_fetch_row($rUnidad))
								{
									if(isset($arrDocumentosFirmados[$fUnidad[0]]))
										$total+=$arrDocumentosFirmados[$fUnidad[0]];
								}
								
								if(!isset($arrTotalInmueble[$fila[0]]))
								{
									$arrTotalInmueble[$fila[0]]=0;
								}
								$arrTotalInmueble[$fila[0]]+=$total;
								$totalGlobal+=$total;
								
								if($dataSet1=="")
								{
									$dataSet1=$total;
									$colores="color('#".$arrColores[$numValores]."').alpha(0.7).rgbString()";
									
								
								}
								else
								{
									$dataSet1.=",".$total;
									$colores.=",color('#".$arrColores[$numValores]."').alpha(0.7).rgbString()";
								}
								$numValores++;
								
							}
							
							if(mysql_num_rows($res)>0)
							{
								mysql_data_seek($res,0);
							}
							
							$porcentajeAcumulado=0;
							$posValor=0;
							while($fila=mysql_fetch_row($res))
							{
								if($posValor==$numValores-1)
								{
									$porcentaje=100-$porcentajeAcumulado;
								}
								else
								{
									
									
									$porcentaje=($arrTotalInmueble[$fila[0]]/$totalGlobal) * 100;
									$porcentajeAcumulado+=$porcentaje;
								
								}
								if($lblEtiquetas=="")
									$lblEtiquetas="'".$fila[1]." (".number_format($porcentaje,2)." %)'";
								else
									$lblEtiquetas.=",'".$fila[1]." (".number_format($porcentaje,2)." %)'";
								
								$posValor++;
									
							}
							$lblEtiquetas="[".$lblEtiquetas."]";

							
							?>
                             <br><br>
                              <div id="container4" style="width: 80%;">
                                  <canvas id="canvas4" ></canvas>
                                   <div id="legend" ></div>
                              </div>
                              <br><br>
                              <script>
                              
                              var horizontalBarChartData = {
                                                              labels: <?php echo $lblEtiquetas?>,
                                                              datasets: [
                                                                          {
                                                                              label: '',
                                                                              backgroundColor: [<?php echo $colores?>],
                                                                              /*datalabels: 	{
                                                                                                align: 'end',
                                                                                                anchor: 'end'
                                                                                                
                                                                                            },*/
                                                                              borderWidth: 1,
                                                                              
                                                                              data: 	[
                                                                                          <?php echo $dataSet1?>
                                                                                      ]
                                                                          }
                                                              
                                                                      ]
                                                  
                                                          };
                        
                                  var ctx = document.getElementById('canvas4').getContext('2d');
                                  var chart=window.myHorizontalBar = new Chart(ctx, {
                                                                              type: 'pie',
                                                                              data: horizontalBarChartData,
                                                                              //plugins: [ChartDataLabels],
                                                                              options: {
																				  		 tooltips:	{
																							 			enabled:false
																							 		},
                                                                                         layout: {
                                                                                                    padding: {
                                                                                                                left: 10,
                                                                                                                right: 10,
                                                                                                                top: 10,
                                                                                                                bottom: 10
                                                                                                            }
                                                                                                },
                                                                                        plugins:	{
                                                                                                        datalabels: {
																															display: function(context) 
																																	{
    																																	return false; // display labels with an odd index
																																	}
                                                                                                                            
                                                                                                                    },
                                                                                                    },
                                                                                          indexAxis: 'y',
                                                                                          // Elements options apply to all of the options unless overridden in a dataset
                                                                                          // In this case, we are setting the border of each horizontal bar to be 2px wide
                                                                                          elements: {
                                                                                                          bar: {
                                                                                                                  borderWidth: 2,
                                                                                                              }
                                                                                                      },
                                                                                          responsive: true,
                                                                                          legend: {
                                                                                                      position: 'bottom',
                                                                                                      display: true,
                                                                                                      
                                                                                                  },
                                                                                          legend: {
                                                                                                      position: 'bottom',
                                                                                                      display: true,
																									  labels:	{
                                                                                                                        filter:function(i,c)
                                                                                                                                {
																																	
																																	return parseFloat((c.datasets[0].data[i.index]))>0;

                                                                                                                                    
                                                                                                                                }
                                                                                                                    }
                                                                                                      
                                                                                                  },
                                                                                          title: {
                                                                                                      display: true,
                                                                                                      fontSize:14,
                                                                                                      padding:40,
                                                                                                      text: 'Distribución de Documentos Firmados Electrónicamente por Inmueble'
                                                                                                  }
                                                                                      }
                                                                          }
                                                                      );
                        
                              
                        

                              
                              </script>
                            <?php
							
							
							$lblEtiquetas="";
							$consulta="SELECT id__26_tablaDinamica,nombreCorto AS unidad,clave,usuarioJuez,(SELECT nombre FROM 800_usuarios WHERE idUsuario=t.usuarioJuez) AS nombreJuez,
										(SELECT GROUP_CONCAT(tj.tipoJuez) FROM _26_tipoJuez j,_18_tablaDinamica tj WHERE idPadre=t.id__26_tablaDinamica 
										AND tj.id__18_tablaDinamica=j.idOpcion) AS tipoJuez
										FROM _26_tablaDinamica t,_17_tablaDinamica u WHERE t.usuarioJuez<>-1 and t.usuarioJuez is not null and u.id__17_tablaDinamica=t.idReferencia 
										AND cmbCategoria=1 ".$condWhere." ORDER BY  prioridad,clave";
							$res=$con->obtenerFilas($consulta);
							while($fila=mysql_fetch_row($res))
							{
								if($lblEtiquetas=="")
									$lblEtiquetas="'[".$fila[1]."] (".$fila[2].")".$fila[4]."'";
								else
									$lblEtiquetas.=",'[".$fila[1]."] (".$fila[2].")".$fila[4]."'";
							}
							$lblEtiquetas="[".$lblEtiquetas."]";
							
							if(mysql_num_rows($res)>0)
							{
								mysql_data_seek($res,0);
							}
							
							$dataSet1="";
							$totalGlobal=0;
							while($fila=mysql_fetch_row($res))
							{
								$total=0;
								$consulta="SELECT COUNT(*) FROM 3000_formatosRegistrados WHERE firmado=1 AND fechaRegistro>='".$fechaInicio.
										"' AND fechaRegistro<='".$fechaFin."' AND  responsableFirma=".$fila[3];
								$total=$con->obtenerValor($consulta);
								if($dataSet1=="")
									$dataSet1=$total;
								else
									$dataSet1.=",".$total;
								
							}
								
							
							
                        	
                        ?>
                             <br><br>
                              <div id="container5" >
                                  <canvas id="canvas5" style="height:2500px; width:1100px"></canvas>
                                   <div id="legend" ></div>
                              </div>
                              <br><br>
                              <script>
                              
                                        
                                        var color = Chart.helpers.color;
                                        var horizontalBarChartData = {
                                                                        labels: <?php echo $lblEtiquetas?>,
                                                                        datasets: [
                                                                                    {
                                                                                        label: 'Documentos Firmados',
                                                                                        borderColor: '#FF0000',
                                                                                        borderWidth: 2,
																						backgroundColor: color('#FF0000').alpha(0.8).rgbString(),
                                                                                        fill: false,
                                                                                        lineTension:0,
                                                                                        pointBorderWidth:2,
                                                                                        datalabels: {
                                                                                                        align: 'end',
                                                                                                        anchor: 'end'
                                                                                                    },
                                                                                        data: 	[
                                                                                                    <?php echo $dataSet1?>
                                                                                                ]
                                                                                    }
                                                                        
                                                                                ]
                                                            
                                                                    };
                                
                                      
                                            var ctx = document.getElementById('canvas5').getContext('2d');
                                            window.myGrafico = new Chart(ctx, {
                                                                                        type: 'horizontalBar',
                                                                                        data: horizontalBarChartData,
                                                                                        plugins: [ChartDataLabels],
                                                                                        
                                                                                        options: {
                                                                                                    responsive: true,
                                                                                                    legend: {
                                                                                                                position: 'bottom'
                                                                                                                
                                                                                                            },
                                                                                                    title: {
                                                                                                                display: true,
                                                                                                                fontSize:14,
                                                                                                                text: '<?php echo "Documentos Firmador por Juez Electrónicamente"?>'
                                                                                                            },
                                                                                                    scales: {
                                                                                                                xAxes: [
                                                                                                                            {
                                                                                                                                display: true,
                                                                                                                                ticks:	{
                                                                                                                                            autoSkip: false/*,
                                                                                                                                            maxRotation: 90,
                                                                                                                                            minRotation: 90*/
                                                                                                                                        }
                                                                                                                            }
                                                                                                                        ],
                                                                                                                yAxes: 	[
                                                                                                                            {
                                                                                                                                display: true
                                                                                                                            }
                                                                                                                        ]
                                                                                                            },
                                                                                                }
                                                                                    }
                                                                                );
                                
                                        
                                
                                        
                                        </script>
                             
                        
                        
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
							<a href="<?php echo $pagRegresar ?>" class="letraVerde"><img src="../../images/flechaizq.gif" border="0" /></a>
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
