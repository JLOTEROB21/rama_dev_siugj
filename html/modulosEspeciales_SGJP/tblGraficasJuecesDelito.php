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
                        <td align="center">
                        <?php
                        	$fechaInicio="";
							$fechaFin="";
							
							$urlGraficas="/media/ChartsV2/";							
							
							$fechaInicio="-1";
							if(isset($_POST["fechaInicio"]))
								$fechaInicio=$_POST["fechaInicio"];
							
							
							$fechaFin="-1";
							if(isset($_POST["fechaFin"]))
								$fechaFin=$_POST["fechaFin"];	
							
							
							


//,100118

							
							$arrTiposAudiencias["10082"]="1";
							$arrTiposAudiencias["10089"]="1";
							$arrTiposAudiencias["10080"]="1";
							$arrTiposAudiencias["10068,100118"]="1";
							//$arrTiposAudiencias["52"]="1";

							
							$arrUGJ[15]="1";
							$arrUGJ[16]="1";
							$arrUGJ[17]="1";
							$arrUGJ[25]="1";
							$arrUGJ[32]="1";
							
							foreach($arrUGJ as $iUGJ=>$resto)
							{
								
								$consulta="SELECT CONCAT('[',claveFolioCarpetas,'] ',nombreUnidad) AS nombreUnidad from _17_tablaDinamica WHERE id__17_tablaDinamica=".$iUGJ;
								$nombreUnidadGestion=$con->obtenerValor($consulta);
								
								echo "<table width='100%' class='SeparadorSeccion'><tr><td align='center'><b>Unidad de Gesti&oacute;n: </b><span>".$nombreUnidadGestion."</span></td></tr></table><br>";
								$arrJueces=array();
								$consulta="SELECT clave,(SELECT nombre FROM 800_usuarios WHERE idUsuario=t.usuarioJuez) AS nombreJuez,t.usuarioJuez 
										FROM _26_tablaDinamica t,_26_tipoJuez j WHERE idReferencia=".$iUGJ." AND j.idPadre=t.id__26_tablaDinamica 
										AND j.idOpcion=1 order by clave";
								$res=$con->obtenerFilas($consulta);
								while($fila=mysql_fetch_row($res))
								{
									$arrJueces[$fila[2]]="[".$fila[0]."] ".$fila[1];
								}
								
								$grafica=new FusionCharts("MSBar3D",960,800);
								$grafica->setSWFPath($urlGraficas);
								$grafica->defineStyle("titulo","font","font=Calibri;size=16;");
								$grafica->applyStyle("CAPTION","titulo");
								
								$titulo="Promedio de duracion de audiencia por juez por tipo delito (Control de detención)";
								
								$strParam="baseFont=Calibri;baseFontSize=12;labelDisplay=WRAP;showToolTip=1;";
								$strParam.="showAboutMenuItem=0;exportEnabled=1;exportAtClient=0;exportAction=download;exportHandler=".$urlSitio."include/latis/ExportHandlers/PHP/FCExporter.php;
											exportFormats=PNG=Exportar como PNG;exportDialogMessage=Capturando imagen, por favor espere ;showPrintMenuItem=0;exportFileName=asistenciaSemanal.png";
								$strParam.=";caption=".$titulo.";showLegend=1;formatNumberScale=0;decimalPrecision=0;showValues=1;showNames=1;rotateNames=1;bgColor=FFFFFF;
											valuePadding=5;canvasPadding=10;showBorder=0;chartRightMargin=40;palette=1;showSum=1; numberSuffix= min.";	
								$grafica->setChartParams($strParam);
								
								foreach($arrJueces as $idJuez=>$nombreJuez)
								{
									$grafica->addCategory($nombreJuez);		
									
								}		
								
								
								foreach($arrTiposAudiencias as $idAudiencia=>$resto)
								{
									
									$consulta="SELECT group_concat(distinct denominacionDelito) FROM _35_denominacionDelito 
											WHERE id__35_denominacionDelito in (".$idAudiencia.")";
									$tipoAudiencia=$con->obtenerValor($consulta);
									$arrAnalisisJueces=array();
									foreach($arrJueces as $idJuez=>$nombreJuez)
									{
										$consulta="SELECT e.idRegistroEvento,(SELECT ca.idActividad FROM 7007_contenidosCarpetaAdministrativa c,
												7006_carpetasAdministrativas ca,_61_tablaDinamica d
												WHERE c.tipoContenido=3 AND idRegistroContenidoReferencia=e.idRegistroEvento and 
												ca.carpetaAdministrativa=c.carpetaAdministrativa and d.idActividad=ca.idActividad and 
												d.denominacionDelito in (".$idAudiencia.")) as nDelitos	,
												if(horaInicioReal is not null,TIMESTAMPDIFF(MINUTE, horaInicioReal,horaTerminoReal ),null) as minutos
												  FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j 
												WHERE e.fechaEvento>='".$fechaInicio."' AND fechaEvento<='".$fechaFin."'  AND tipoAudiencia=26
												 AND   j.idRegistroEvento=e.idRegistroEvento 
												and j.idJuez=".$idJuez;

										$rEventos=$con->obtenerFilas($consulta);
										while($fEventos=mysql_fetch_row($rEventos))
										{
											
											if(($fEventos[1]==0)||($fEventos[2]<15)||($fEventos[2]>400)||($fEventos[2]==""))
												continue;
											
											if(!isset($arrAnalisisJueces[$idJuez]))
											{
												$arrAnalisisJueces[$idJuez]=array();
												$arrAnalisisJueces[$idJuez]["1"]["minutos"]=0;
												$arrAnalisisJueces[$idJuez]["1"]["total"]=0;
												$arrAnalisisJueces[$idJuez]["2"]["minutos"]=0;
												$arrAnalisisJueces[$idJuez]["2"]["total"]=0;
												$arrAnalisisJueces[$idJuez]["3"]["minutos"]=0;
												$arrAnalisisJueces[$idJuez]["3"]["total"]=0;
											}
											
										
											$fEventos[1]=1;
											$arrAnalisisJueces[$idJuez][$fEventos[1]]["minutos"]+=$fEventos[2];
											$arrAnalisisJueces[$idJuez][$fEventos[1]]["total"]++;
											
												
											
										}						
										foreach($arrAnalisisJueces as $idJuez=>$resto)
										{
											foreach($resto as $nImputados=>$resto2)
											{
												if($resto2["total"]==0)
												{
													$arrAnalisisJueces[$idJuez][$nImputados]["promedio"]=0;
												}
												else
													$arrAnalisisJueces[$idJuez][$nImputados]["promedio"]=$resto2["minutos"]/$resto2["total"];
											}
										}
										
										
										
												
										
									}
									
									$grafica->addDataset($tipoAudiencia);		
																
									foreach($arrJueces as $idJuez=>$aux)
									{
										
										if(isset($arrAnalisisJueces[$idJuez]))
										{
											$resto=$arrAnalisisJueces[$idJuez];
											$grafica->addChartData($resto[1]["promedio"],"label=Audiencias: ".$resto[1]["total"].";");	
											
										}
										else
										{
											$grafica->addChartData(0);	
											
										}
									}
									
									
								}
								$grafica->renderChart(true,true);
								
							}
							
							
							
							


							$arrTiposAudiencias=array();
							$arrTiposAudiencias["10167"]="1";
							$arrTiposAudiencias["10241"]="1";
							$arrTiposAudiencias["10082"]="1";
							$arrTiposAudiencias["10127"]="1";


							$arrUGJ=array();
							
							$arrUGJ[33]="1";
							$arrUGJ[34]="1";
							$arrUGJ[35]="1";
							
							$arrUGJ[48]="1";
							$arrUGJ[47]="1";
							$arrUGJ[46]="1";
							$arrUGJ[50]="1";
							
							
							foreach($arrUGJ as $iUGJ=>$resto)
							{
								
								$consulta="SELECT CONCAT('[',claveFolioCarpetas,'] ',nombreUnidad) AS nombreUnidad from _17_tablaDinamica WHERE id__17_tablaDinamica=".$iUGJ;
								$nombreUnidadGestion=$con->obtenerValor($consulta);
								
								echo "<table width='100%' class='SeparadorSeccion'><tr><td align='center'><b>Unidad de Gesti&oacute;n: </b><span>".$nombreUnidadGestion."</span></td></tr></table><br>";
								$arrJueces=array();
								$consulta="SELECT clave,(SELECT nombre FROM 800_usuarios WHERE idUsuario=t.usuarioJuez) AS nombreJuez,t.usuarioJuez 
										FROM _26_tablaDinamica t,_26_tipoJuez j WHERE idReferencia=".$iUGJ." AND j.idPadre=t.id__26_tablaDinamica 
										AND j.idOpcion=1 order by clave";
								$res=$con->obtenerFilas($consulta);
								while($fila=mysql_fetch_row($res))
								{
									$arrJueces[$fila[2]]="[".$fila[0]."] ".$fila[1];
								}
								
								
									
																	
								$grafica=new FusionCharts("MSBar3D",960,800);
								$grafica->setSWFPath($urlGraficas);
								$grafica->defineStyle("titulo","font","font=Calibri;size=16;");
								$grafica->applyStyle("CAPTION","titulo");
								
								$titulo="Promedio de duracion de audiencia por juez por tipo delito (Control de detención)";
								
								$strParam="baseFont=Calibri;baseFontSize=12;labelDisplay=WRAP;showToolTip=1;";
								$strParam.="showAboutMenuItem=0;exportEnabled=1;exportAtClient=0;exportAction=download;exportHandler=".$urlSitio."include/latis/ExportHandlers/PHP/FCExporter.php;
											exportFormats=PNG=Exportar como PNG;exportDialogMessage=Capturando imagen, por favor espere ;showPrintMenuItem=0;exportFileName=asistenciaSemanal.png";
								$strParam.=";caption=".$titulo.";showLegend=1;formatNumberScale=0;decimalPrecision=0;showValues=1;showNames=1;rotateNames=1;bgColor=FFFFFF;
											valuePadding=5;canvasPadding=10;showBorder=0;chartRightMargin=40;palette=1;showSum=1; numberSuffix= min.";	
								$grafica->setChartParams($strParam);
								
								
								
								
								
								foreach($arrJueces as $idJuez=>$nombreJuez)
								{
									$grafica->addCategory($nombreJuez);		
									
								}		
								
								
								foreach($arrTiposAudiencias as $idAudiencia=>$resto)
								{
									
									$consulta="SELECT group_concat(distinct denominacionDelito) FROM _35_denominacionDelito WHERE id__35_denominacionDelito in (".$idAudiencia.")";
									$tipoAudiencia=$con->obtenerValor($consulta);
									$arrAnalisisJueces=array();
									foreach($arrJueces as $idJuez=>$nombreJuez)
									{
										$consulta="SELECT e.idRegistroEvento,(SELECT ca.idActividad FROM 7007_contenidosCarpetaAdministrativa c,
												7006_carpetasAdministrativas ca,_61_tablaDinamica d
												WHERE c.tipoContenido=3 AND idRegistroContenidoReferencia=e.idRegistroEvento and 
												ca.carpetaAdministrativa=c.carpetaAdministrativa and d.idActividad=ca.idActividad and 
												d.denominacionDelito in (".$idAudiencia.")) as nDelitos,m.duracionVideo	
												  FROM 7000_eventosAudiencia e,7000_audienciasMAJO m,7001_eventoAudienciaJuez j 
												WHERE e.fechaEvento>='".$fechaInicio."' AND fechaEvento<='".$fechaFin."'  AND tipoAudiencia=26
												 AND  m.ExpedienteId=e.idRegistroEvento and j.idRegistroEvento=e.idRegistroEvento 
												and j.idJuez=".$idJuez;
										$rEventos=$con->obtenerFilas($consulta);
										while($fEventos=mysql_fetch_row($rEventos))
										{
											
											if(($fEventos[1]==0)||($fEventos[2]<=10))
												continue;
											
											if(!isset($arrAnalisisJueces[$idJuez]))
											{
												$arrAnalisisJueces[$idJuez]=array();
												$arrAnalisisJueces[$idJuez]["1"]["minutos"]=0;
												$arrAnalisisJueces[$idJuez]["1"]["total"]=0;
												$arrAnalisisJueces[$idJuez]["2"]["minutos"]=0;
												$arrAnalisisJueces[$idJuez]["2"]["total"]=0;
												$arrAnalisisJueces[$idJuez]["3"]["minutos"]=0;
												$arrAnalisisJueces[$idJuez]["3"]["total"]=0;
											}
											
											if($fEventos[1]==0)
												$fEventos[1]=1;
											
											if($fEventos[1]>3)
												$fEventos[1]=3;
											$fEventos[1]=1;
											$arrAnalisisJueces[$idJuez][$fEventos[1]]["minutos"]+=$fEventos[2];
											$arrAnalisisJueces[$idJuez][$fEventos[1]]["total"]++;
											
												
											
										}						
										foreach($arrAnalisisJueces as $idJuez=>$resto)
										{
											foreach($resto as $nImputados=>$resto2)
											{
												if($resto2["total"]==0)
												{
													$arrAnalisisJueces[$idJuez][$nImputados]["promedio"]=0;
												}
												else
													$arrAnalisisJueces[$idJuez][$nImputados]["promedio"]=$resto2["minutos"]/$resto2["total"];
											}
										}
										
										
										
												
										
									}
									
									$grafica->addDataset($tipoAudiencia);		
																
									foreach($arrJueces as $idJuez=>$aux)
									{
										
										if(isset($arrAnalisisJueces[$idJuez]))
										{
											$resto=$arrAnalisisJueces[$idJuez];
											$grafica->addChartData($resto[1]["promedio"],"label=Audiencias: ".$resto[1]["total"].";");	
											
										}
										else
										{
											$grafica->addChartData(0);	
											
										}
									}
									
									
								}
								$grafica->renderChart(true,true);
								
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
