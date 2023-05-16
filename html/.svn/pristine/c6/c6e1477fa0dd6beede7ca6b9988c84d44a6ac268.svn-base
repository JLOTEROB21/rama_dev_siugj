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
<script src="../Scripts/ChartsJS/chart.min.js"></script>
<script src="../Scripts/ChartsJS/utils.js"></script>
<script src="../Scripts/ChartsJS/chartjs-plugin-datalabels.min.js"></script>

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
							
							
							$fechaInicio="-1";
							if(isset($_POST["fechaInicio"]))
								$fechaInicio=$_POST["fechaInicio"];
							
							
							$fechaFin="-1";
							if(isset($_POST["fechaFin"]))
								$fechaFin=$_POST["fechaFin"];	
							
							
							$unidadGestion=$objParametros->unidadGestion;
							$tiposAudiencia=$objParametros->tiposAudiencia;
							
							$arrTiposAudiencias=explode(",",$tiposAudiencia);
							
							
							$listaUnidades="";
							$arrUnidades=explode(",",$unidadGestion);
							foreach($arrUnidades as $u)
							{
								if($listaUnidades=="")
									$listaUnidades="'".$u."'";
								else	
									$listaUnidades.=",'".$u."'";
							}
							$arrJueces=array();
							$consulta="SELECT clave,(SELECT nombre FROM 800_usuarios WHERE idUsuario=t.usuarioJuez) AS nombreJuez,t.usuarioJuez , j.nombreCorto
									FROM _26_tablaDinamica t,_17_tablaDinamica j WHERE j.claveUnidad in(".$listaUnidades.") 
									and t.idReferencia=j.id__17_tablaDinamica  order by clave";
							$res=$con->obtenerFilas($consulta);
							while($fila=mysql_fetch_row($res))
							{
								$arrJueces[$fila[2]]="[".$fila[3]."] ".$fila[0].".- ".$fila[1];
							}
							
							$lblEtiquetas="";
							foreach($arrJueces as $idJuez=>$nombreJuez)
							{
								
								if($lblEtiquetas=="")
									$lblEtiquetas="'".$nombreJuez."'";
								else
									$lblEtiquetas.=",'".$nombreJuez."'";	
							}		
							$lblEtiquetas="[".$lblEtiquetas."]";
							
							$arrDataSets1="";
							$arrDataSets2="";
							$nDataSet=0;
							foreach($arrTiposAudiencias as $idAudiencia)
							{
								
								$consulta="SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$idAudiencia;
								$tipoAudiencia=$con->obtenerValor($consulta);
								$arrAnalisisJueces=array();
								foreach($arrJueces as $idJuez=>$nombreJuez)
								{
									$consulta="SELECT e.idRegistroEvento,(SELECT COUNT(*) FROM 7007_contenidosCarpetaAdministrativa c,
											7006_carpetasAdministrativas ca,7005_relacionFigurasJuridicasSolicitud r 
											WHERE c.tipoContenido=3 AND idRegistroContenidoReferencia=e.idRegistroEvento and 
											ca.carpetaAdministrativa=c.carpetaAdministrativa
											and r.idActividad=ca.idActividad and r.idFiguraJuridica=4) as nImputados,TIMESTAMPDIFF(MINUTE, horaInicioReal,horaTerminoReal )	
											  FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j 
											WHERE e.fechaEvento>='".$fechaInicio."' AND fechaEvento<='".$fechaFin."'  AND tipoAudiencia=".$idAudiencia.
											" AND   j.idRegistroEvento=e.idRegistroEvento 
											and j.idJuez=".$idJuez;
									
									$rEventos=$con->obtenerFilas($consulta);
									while($fEventos=mysql_fetch_row($rEventos))
									{
										
										if($fEventos[2]<=10)
											continue;
										
										if(!isset($arrAnalisisJueces[$idJuez]))
										{
											$arrAnalisisJueces[$idJuez]=array();
											$arrAnalisisJueces[$idJuez]["minutos"]=0;
											$arrAnalisisJueces[$idJuez]["total"]=0;
											$arrAnalisisJueces[$idJuez]["totalAudienciasMinutos"]=0;

											
										}
										
										
										$arrAnalisisJueces[$idJuez]["minutos"]+=($fEventos[2]<400 && $fEventos[2]>20)?$fEventos[2]:0;
										$arrAnalisisJueces[$idJuez]["total"]++;
										if($fEventos[2]<400)
										{
											$arrAnalisisJueces[$idJuez]["totalAudienciasMinutos"]++;
										}
											
										
									}	
									
									foreach($arrAnalisisJueces as $idJuez=>$resto)
									{
										if($resto["total"]==0)
										{
											$arrAnalisisJueces[$idJuez]["promedio"]=0;
										}
										else
											$arrAnalisisJueces[$idJuez]["promedio"]=$resto["minutos"]/$resto["totalAudienciasMinutos"];
										
									}
									
								}
								
								$dataSet1="";
								$dataSet2="";

								foreach($arrJueces as $idJuez=>$aux)
								{
									$valor1=0;
									$valor2=0;
									
									if(isset($arrAnalisisJueces[$idJuez]))
									{
										$resto=$arrAnalisisJueces[$idJuez];
										$valor1=str_replace(",","",number_format($resto["promedio"],2));
										$valor2=str_replace(",","",number_format($resto["total"],2));
									}
									
									
									if($dataSet1=="")
										$dataSet1=$valor1;
									else
										$dataSet1.=",".$valor1;
										
										
									if($dataSet2=="")
										$dataSet2=$valor2;
									else
										$dataSet2.=",".$valor2;	
									
								}
								
								$oDataset1="{
												label: '".cv($tipoAudiencia)."',
												borderWidth: 1,
												borderColor: '#".$arrColores[$nDataSet]."',
												backgroundColor: color('#".$arrColores[$nDataSet]."').alpha(0.6).rgbString(),
												datalabels: {
																align: 'end',
																anchor: 'end',
																formatter: function(value, context) 
																			{
																				return value+' min.';
																			}
															},
												data: 	[".$dataSet1."]
										  }";
								
								if($arrDataSets1=="")
									$arrDataSets1=$oDataset1;
								else
									$arrDataSets1.=",".$oDataset1;
								
								$oDataset2="{
												label: '".cv($tipoAudiencia)."',
												borderWidth: 1,
												borderColor: '#".$arrColores[$nDataSet]."',
												backgroundColor: color('#".$arrColores[$nDataSet]."').alpha(0.6).rgbString(),
												borderColor: 'rgb(163, 168, 207)',
												datalabels: {
																align: 'end',
																anchor: 'end'
															},
												data: 	[".$dataSet2."]
										  }";
								
								if($arrDataSets2=="")
									$arrDataSets2=$oDataset2;
								else
									$arrDataSets2.=",".$oDataset2;
								$nDataSet++;
								
							}
								
								
								
								?>	
                        	<div  style="width: 100%;">
                                <canvas id="canvas_1"></canvas>
                            </div><br />
                            <br /><br />
                            <div  style="width: 100%;">
                                <canvas id="canvas_2"></canvas>
                            </div>
                            <script>
							
							var color = Chart.helpers.color;
							var horizontalBarChartData = {
															labels: <?php echo $lblEtiquetas?>,
															datasets: [
																		<?php
																		echo $arrDataSets1;
																		?>
															
																	]
												
														};
					
							
							var ctx = document.getElementById('canvas_1').getContext('2d');
							new Chart(ctx, {
												type: 'horizontalBar',
												data: horizontalBarChartData,
												plugins: [ChartDataLabels],
												options: {
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
																		position: 'bottom'
																	},
															title: {
																		display: true,
																		fontSize:14,
																		text: 'Promedio de Duración de Audiencia por Juez'
																	},
															scales: {
																		xAxes: [
																					{
																						stacked: false,
																					}
																				],
																		yAxes: [
																					{
																						stacked: false
																					}
																				]
																	}/*,
															tooltips: 	{
																			filter: function (tooltipItem) 
																			{
																			
																				return tooltipItem.datasetIndex !== 3;
																			}
																		}*/
														}
											}
										);
																	
							var horizontalBarChartData2 = {
															labels: <?php echo $lblEtiquetas?>,
															datasets: [
																		<?php
																		echo $arrDataSets2;
																		?>
															
																	]
												
														};										
						 	ctx = document.getElementById('canvas_2').getContext('2d');
							new Chart(ctx, {
												  type: 'horizontalBar',
												  data: horizontalBarChartData2,
												  plugins: [ChartDataLabels],
												  options: {
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
																		  position: 'bottom'
																	  },
															  title: {
																		  display: true,
																		  fontSize:14,
																		  text: 'Total de Audiencias por Juez'
																	  },
															  scales: {
																		  xAxes: [
																					  {
																						  stacked: false,
																					  }
																				  ],
																		  yAxes: [
																					  {
																						  stacked: false
																					  }
																				  ]
																	  }/*,
															  tooltips: 	{
																			  filter: function (tooltipItem) 
																			  {
																			  
																				  return tooltipItem.datasetIndex !== 3;
																			  }
																		  }*/
														  }
											  }
										  );
					
							var colorNames = Object.keys(window.chartColors);
							
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
