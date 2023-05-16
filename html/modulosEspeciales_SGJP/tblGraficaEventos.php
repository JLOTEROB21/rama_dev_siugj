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
                        	$fechaInicio="";
							$fechaFin="";
							$unidadGestion=17;
							$unidadMedida=2;  //jueces
							
							
							if(isset($_POST["fechaInicio"]))
								$fechaInicio=$_POST["fechaInicio"];
							
							if(isset($_POST["fechaFin"]))
								$fechaFin=$_POST["fechaFin"];	
								
							
							if(isset($_POST["unidadGestion"]))	
								$unidadGestion=$_POST["unidadGestion"];
							
							if(isset($_POST["unidadMedida"]))	
								$unidadMedida=$_POST["unidadMedida"];
							
							$urlGraficas="/media/ChartsV2/";
							
							
							$arrCarpetasJuez=array();
							switch($unidadMedida)
							{
								case 1:  //Migrado
									
									$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$unidadGestion."'";
									$unidadGestion=$con->obtenerValor($consulta);
									$arrJuez=array();
									$lUsuarios="";
									
									
									$lblEtiquetas="";
									
									$consulta="SELECT clave,u.nombre,u.idUsuario FROM _26_tablaDinamica t,800_usuarios u WHERE idReferencia=".$unidadGestion.
									" AND u.idUsuario=t.usuarioJuez and u.idUsuario is not null and u.idUsuario <>-1 order by clave";

									$res=$con->obtenerFilas($consulta);
									while($fila=mysql_fetch_row($res))
									{
										if($lblEtiquetas=="")
											$lblEtiquetas="'".$fila[0]." ".$fila[1]."'";
										else
											$lblEtiquetas.=",'".$fila[0]." ".$fila[1]."'";
										if($lUsuarios=="")
											$lUsuarios=$fila[2];
										else
											$lUsuarios.=",".$fila[2];
										
										$arrJuez[$fila[2]]=1;
									}
									
									$lblEtiquetas="[".$lblEtiquetas."]";
									
									if($lUsuarios=="")
										$lUsuarios=-1;
									
									
									$arrTiposAudiencias=array();
									$consulta="SELECT DISTINCT tipoAudiencia FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j WHERE 
											e.idRegistroEvento=j.idRegistroEvento AND j.idJuez IN(".$lUsuarios.") AND fechaSolicitud>='".$fechaInicio." 00:00:00' AND fechaSolicitud<='".$fechaFin." 23:59:59'
											AND situacion IN(SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)";

									$rTipoAudiencia=$con->obtenerFilas($consulta);
									while($fTipoAudiencia=mysql_fetch_row($rTipoAudiencia))
									{
										if($fTipoAudiencia[0]=="")
										{
											$fTipoAudiencia[0]=23;
										}
										$consulta="SELECT tipoAudiencia,numeroMetrica FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fTipoAudiencia[0];
										$fAudiencia=$con->obtenerPrimeraFila($consulta);
										$lblTipoAudiencia=$fAudiencia[0];
										if($fAudiencia[1]==0)
										{
											continue;
										}
										$lblTipoAudiencia=str_replace("Audiencia ","A. ",$lblTipoAudiencia);
										$arrTiposAudiencias[$lblTipoAudiencia."__".$fTipoAudiencia[0]]=$fTipoAudiencia[0];
										//
									}
									ksort($arrTiposAudiencias);
									$nDataSet=0;
									$arrDataSet="";
									$arrTotales=array();
									foreach($arrTiposAudiencias as $tAudiencia=>$idAudiencia)
									{
										$arrDatos=explode("_",$tAudiencia);
										$dataSet1="";
										foreach($arrJuez as $j=>$resto)
										{
											if(!isset($arrTotales[$j]))
												$arrTotales[$j]=0;
											$nEventos=0;
											$consulta="	SELECT e.fechaSolicitud,ta.numeroMetrica,e.idEdificio FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j,
											_4_tablaDinamica ta  WHERE e.idRegistroEvento=j.idRegistroEvento AND j.idJuez =".$j." AND fechaSolicitud>='".$fechaInicio." 00:00:00' 
											AND fechaSolicitud<='".$fechaFin." 23:59:59' and e.tipoAudiencia=".$idAudiencia." AND e.situacion IN(SELECT idSituacion 
											FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1) and ta.id__4_tablaDinamica=e.tipoAudiencia";
											
											$rEventos=$con->obtenerFilas($consulta);
											while($fEvento=mysql_fetch_row($rEventos))
											{

												$tipoHorario=0;
			
												if($fEvento[2]==4)
													$tipoHorario=determinarHorarioB($fEvento[0]);
												else
													$tipoHorario=determinarHorarioA($fEvento[0]);
												
												if($fEvento[1]=="")
													$fEvento[1]=0;
													
												if($tipoHorario!=2)	
													$nEventos+=$fEvento[1];
												
												
												
											}
											
											if($dataSet1=="")
												$dataSet1=$nEventos;
											else
												$dataSet1.=",".$nEventos;
												
												
											$arrTotales[$j]+=$nEventos;	
										}
										
										$oDataSet="{
														label: '".$arrDatos[0]."',
														backgroundColor: color('#".$arrColores[$nDataSet]."').alpha(0.6).rgbString(),
														borderColor: '#".$arrColores[$nDataSet]."',
														borderWidth: 1,
														datalabels: {
																		color:'#000'
																	},
														data: 	[
																	".$dataSet1."
																]
													}";
										if($arrDataSet=="")
											$arrDataSet=$oDataSet;
										else
											$arrDataSet.=",".$oDataSet;
										$nDataSet++;
									}
									$dataSet1="";
									foreach($arrTotales as $valor)
									{
										if($dataSet1=="")
											$dataSet1=$valor;
										else
											$dataSet1.=",".$valor;
									}
									$oDataSet="{
														label: 'Total',
														backgroundColor: color('#FFF').alpha(0).rgbString(),
														borderColor: '#FFF',
														borderWidth: 1,
														datalabels: {
																		color:'#F00',
																		align: 'start',
																		anchor: 'start',
																		offset:-30
																	},
														data: 	[
																	".$dataSet1."
																]
													}";
										if($arrDataSet=="")
											$arrDataSet=$oDataSet;
										else
											$arrDataSet.=",".$oDataSet;
									
									
									 ?>	
                                    <div id="container" style="width: 80%;">
                                        <canvas id="canvas"></canvas>
                                    </div>
                                    <script>
                                    
                                    var color = Chart.helpers.color;
                                    var horizontalBarChartData = {
                                                                    labels: <?php echo $lblEtiquetas?>,
                                                                    datasets: [
                                                                                <?php echo $arrDataSet;?>
                                                                    
                                                                            	]
                                                        
                                                                };
                            
                                    window.onload = function() 
                                    {
                                        var ctx = document.getElementById('canvas').getContext('2d');
                                        window.myHorizontalBar = new Chart(ctx, {
                                                                                    type: 'bar',
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
                                                                                                            position: 'bottom',
                                                                                                            labels:	{
                                                                                                                        filter:function(i,c)
                                                                                                                                {
                                                                                                                                    return i.datasetIndex !== <?php echo $nDataSet?>;
                                                                                                                                }
                                                                                                                    }
                                                                                                        },
                                                                                                title: {
                                                                                                            display: true,
                                                                                                            fontSize:14,
                                                                                                            text: 'Distribución de eventos por juez (Sin guardias)'
                                                                                                        },
                                                                                                scales: {
                                                                                                            xAxes: [
                                                                                                                        {
                                                                                                                            stacked: true,
                                                                                                                        }
                                                                                                                    ],
                                                                                                            yAxes: [
                                                                                                                        {
                                                                                                                            stacked: true
                                                                                                                        }
                                                                                                                    ]
                                                                                                        }
                                                                                            }
                                                                                }
                                                                            );
                            
                                    };
                            
                                    var colorNames = Object.keys(window.chartColors);
                                    
                                    </script>
									<?php
									
								break;
								case 2:  //Migrado
									
									$dataSet1="";
									$lblEtiquetas="";
									$consulta="SELECT nombreUnidad,id__17_tablaDinamica FROM _17_tablaDinamica t WHERE cmbCategoria=1 order by prioridad";
									
									$arrCGJ=array();
									$listaUnidadesGestion="";
									
									$res=$con->obtenerFilas($consulta);
									while($fila=mysql_fetch_row($res))
									{
										$arrCGJ[$fila[1]]=1;
										if($listaUnidadesGestion=="")
											$listaUnidadesGestion=$fila[1]	;
										else
											$listaUnidadesGestion.=",".$fila[1];
										
										if($lblEtiquetas=="")
											$lblEtiquetas="'".$fila[0]."'";
										else
											$lblEtiquetas.=",'".$fila[0]."'";
											
										$nEventos=0;	
										$consulta="	SELECT e.fechaSolicitud,e.idEdificio FROM 7000_eventosAudiencia e
											  WHERE  fechaSolicitud>='".$fechaInicio." 00:00:00' 
											AND fechaSolicitud<='".$fechaFin." 23:59:59'  AND e.situacion IN(SELECT idSituacion 
											FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1) and 
											 idCentroGestion=".$fila[1];
										$rEventos=$con->obtenerFilas($consulta);
										while($fEvento=mysql_fetch_row($rEventos))
										{
										
												$tipoHorario=determinarTipoHorarioGeneral($fEvento[0]);
												
												
													
												if($tipoHorario!=2)	
													$nEventos+=1;
										}
										if($dataSet1=="")
											$dataSet1=$nEventos;
										else
											$dataSet1.=",".$nEventos;
										
									}
									$lblEtiquetas="[".$lblEtiquetas."]";
									
									?>	
                                        <div id="container" style="width: 85%;">
                                            <canvas id="canvas"></canvas>
                                        </div>
                                        <script>
                                        
                                        var color = Chart.helpers.color;
                                        var horizontalBarChartData = {
                                                                        labels: <?php echo $lblEtiquetas?>,
                                                                        datasets: [
                                                                                    {
                                                                                        label: 'Unidades de Gestión',
                                                                                        
                                                                                        backgroundColor: color('#286e81').alpha(0.8).rgbString(),
                                                                                        borderColor: '#286e81',
                                                                                        borderWidth: 1,
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
                                
                                        window.onload = function() 
                                        {
                                            var ctx = document.getElementById('canvas').getContext('2d');
                                            window.myHorizontalBar = new Chart(ctx, {
                                                                                        type: 'bar',
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
                                                                                                                position: 'bottom',
                                                                                                                display: false
                                                                                                            },
                                                                                                    title: {
                                                                                                                display: true,
                                                                                                                fontSize:14,
                                                                                                                padding:40,
                                                                                                                
                                                                                                                text: 'Distribución de Eventos por Unidad de Gestión (Sin Guardias)'
                                                                                                            }
                                                                                                }
                                                                                    }
                                                                                );
                                
                                        };
                                
                                        var colorNames = Object.keys(window.chartColors);
                                        
                                        </script>
                                        <?php
								break;
								case 3://Migrado
									
									$lblEtiquetas="";
									$consulta="SELECT nombreUnidad,'',(SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE fechaCreacion>='".$fechaInicio.
												"' AND fechaCreacion<='".$fechaFin."' AND unidadGestion=t.claveUnidad
												) AS nRegistros FROM _17_tablaDinamica t where cmbCategoria=1 order by prioridad";
									
									
									$res=$con->obtenerFilas($consulta);
									while($fila=mysql_fetch_row($res))
									{
										if($lblEtiquetas=="")
											$lblEtiquetas="'".$fila[0]."'";
										else
											$lblEtiquetas.=",'".$fila[0]."'";
										
									}
									$lblEtiquetas="[".$lblEtiquetas."]";
									$dataSet1="";
									if(mysql_num_rows($res)>0)
									{
										mysql_data_seek($res,0);
										while($fila=mysql_fetch_row($res))
										{
											if($dataSet1=="")
												$dataSet1=$fila[2];
											else
												$dataSet1.=",".$fila[2];
											
										}
									}
									?>	
                                        <div id="container" style="width: 85%;">
                                            <canvas id="canvas"></canvas>
                                        </div>
                                        <script>
                                        
                                        var color = Chart.helpers.color;
                                        var horizontalBarChartData = {
                                                                        labels: <?php echo $lblEtiquetas?>,
                                                                        datasets: [
                                                                                    {
                                                                                        label: 'Unidades de Gestión',
                                                                                        
                                                                                        backgroundColor: color('#286e81').alpha(0.8).rgbString(),
                                                                                        borderColor: '#286e81',
                                                                                        borderWidth: 1,
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
                                
                                        window.onload = function() 
                                        {
                                            var ctx = document.getElementById('canvas').getContext('2d');
                                            window.myHorizontalBar = new Chart(ctx, {
                                                                                        type: 'bar',
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
                                                                                                                position: 'bottom',
                                                                                                                display: false
                                                                                                            },
                                                                                                    title: {
                                                                                                                display: true,
                                                                                                                fontSize:14,
                                                                                                                padding:40,
                                                                                                                
                                                                                                                text: 'Distribución de carpetas conocidas por juez'
                                                                                                            }
                                                                                                }
                                                                                    }
                                                                                );
                                
                                        };
                                
                                        var colorNames = Object.keys(window.chartColors);
                                        
                                        </script>
                                        <?php
									
								break;
								case 4://Migrado
									
									
									$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$unidadGestion."'";
									$unidadGestion=$con->obtenerValor($consulta);
									
									$arrCarpetasJuez=array();
									$consulta="SELECT clave,u.nombre,u.idUsuario FROM _26_tablaDinamica t,800_usuarios u WHERE 
												idReferencia=".$unidadGestion." AND u.idUsuario=t.usuarioJuez  and u.idUsuario is not null 
												and u.idUsuario <>-1 order by clave";

									$res=$con->obtenerFilas($consulta);
									while($fila=mysql_fetch_row($res))
									{
										$arrCarpetas=array();
										$carpeta="";
										$consulta="SELECT e.idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,situacion,
													idEdificio,idCentroGestion,idSala,tipoAudiencia,idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j WHERE fechaSolicitud>='".$fechaInicio." 00:00:00' 
													AND fechaSolicitud<='".$fechaFin." 23:59:59' AND situacion in(SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1) AND j.idJuez=".$fila[2]." 
													AND j.idRegistroEvento=e.idRegistroEvento"	;
										$rEvento=$con->obtenerFilas($consulta);
										while($fEvento=mysql_fetch_row($rEvento))
										{
											
											switch($fEvento[9])
											{
												case 11:
													$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 and idRegistroContenidoReferencia=".$fEvento[0];
													$fDatos=$con->obtenerPrimeraFila($consulta);
													if(!$fDatos)
														continue;
													$carpeta=$fDatos[0];
											
												break;
												case 46:
													$consulta="SELECT carpetaAdministrativa,tipoAudiencia,idActividad FROM _46_tablaDinamica WHERE id__46_tablaDinamica=".$fEvento[10];
													$fDatos=$con->obtenerPrimeraFila($consulta);
													if(!$fDatos)
														continue;
													$carpeta=$fDatos[0];
													
												break;
												case 185:
													$idActividad=-1;
													$consulta="SELECT carpetaAdministrativa,tipoAudiencia FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fEvento[10];
													$fDatos=$con->obtenerPrimeraFila($consulta);
													$carpeta=$fDatos[0];
											
													
												break;
												case 6:
													continue;
												break;
												case 5:
												case 7:
													$consulta="SELECT carpetaAdministrativa,idTipoAudiencia FROM otrasSolicitudes WHERE tipo=".$fEvento[9]." and idSolicitud=".$fEvento[10];
													$fDatos=$con->obtenerPrimeraFila($consulta);
													$carpeta=$fDatos[0];
													
												break;
											}
											
											
											if($carpeta!="")
											{
												$arrCarpetas[$carpeta]=1;

											}
										}
										$arrCarpetasJuez[$fila[0]." ".$fila[1]]=sizeof($arrCarpetas);
										
									}
									
									$lblEtiquetas="";
									foreach($arrCarpetasJuez as $juez=>$total)
									{
										if($lblEtiquetas=="")
											$lblEtiquetas="'".$juez."'";
										else
											$lblEtiquetas.=",'".$juez."'";
										
										
									}
									$lblEtiquetas="[".$lblEtiquetas."]";
									$dataSet1="";
									foreach($arrCarpetasJuez as $juez=>$total)
									{
										if($dataSet1=="")
											$dataSet1=$total;
										else
											$dataSet1.=",".$total;
										
									}
									?>	
                        	<div id="container" style="width: 80%;">
                                <canvas id="canvas"></canvas>
                            </div>
                            <script>
							
							var color = Chart.helpers.color;
							var horizontalBarChartData = {
															labels: <?php echo $lblEtiquetas?>,
															datasets: [
																		{
																			label: 'Jueces',
																			
																			backgroundColor: color('#286e81').alpha(0.8).rgbString(),
																			borderColor: '#286e81',
																			borderWidth: 1,
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
					
							window.onload = function() 
							{
								var ctx = document.getElementById('canvas').getContext('2d');
								window.myHorizontalBar = new Chart(ctx, {
																			type: 'bar',
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
																									position: 'bottom',
																									display: false
																								},
																						title: {
																									display: true,
																									fontSize:14,
																									padding:40,
																									
																									text: 'Distribución de carpetas conocidas por juez'
																								}
																					}
																		}
																	);
					
							};
					
							var colorNames = Object.keys(window.chartColors);
							
							</script>
							<?php
								break;
								case 5:  //Migrado
									

									$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$unidadGestion."'";
									$unidadGestion=$con->obtenerValor($consulta);
									$arrJuez=array();
									$lUsuarios="";
									$consulta="SELECT clave,u.nombre,(SELECT COUNT(*) FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j WHERE fechaSolicitud>='".$fechaInicio." 00:00:00' 
												AND fechaSolicitud<='".$fechaFin." 23:59:59' AND situacion in(SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1) 
												AND j.idJuez=u.idUsuario AND j.idRegistroEvento=e.idRegistroEvento ) AS nAudiencias FROM 
												_26_tablaDinamica t,800_usuarios u WHERE idReferencia=".$unidadGestion." AND u.idUsuario=t.usuarioJuez";
									$lblEtiquetas="";
									$consulta="SELECT clave,u.nombre,u.idUsuario FROM _26_tablaDinamica t,800_usuarios u WHERE idReferencia=".$unidadGestion.
									" AND u.idUsuario=t.usuarioJuez and u.idUsuario is not null and u.idUsuario <>-1 order by clave";

									$res=$con->obtenerFilas($consulta);
									while($fila=mysql_fetch_row($res))
									{
										if($lblEtiquetas=="")
											$lblEtiquetas="'".$fila[0]." ".$fila[1]."'";
										else
											$lblEtiquetas.=",'".$fila[0]." ".$fila[1]."'";
										if($lUsuarios=="")
											$lUsuarios=$fila[2];
										else
											$lUsuarios.=",".$fila[2];
										
										$arrJuez[$fila[2]]=1;
									}
									if($lUsuarios=="")
										$lUsuarios=-1;
									$lblEtiquetas="[".$lblEtiquetas."]";
									
									$arrTiposAudiencias=array();
									$consulta="SELECT DISTINCT tipoAudiencia FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j WHERE 
											e.idRegistroEvento=j.idRegistroEvento AND j.idJuez IN(".$lUsuarios.") AND fechaSolicitud>='".$fechaInicio." 00:00:00' AND fechaSolicitud<='".$fechaFin." 23:59:59'
											AND situacion IN(SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)";

									$rTipoAudiencia=$con->obtenerFilas($consulta);
									while($fTipoAudiencia=mysql_fetch_row($rTipoAudiencia))
									{
										if($fTipoAudiencia[0]=="")
										{
											$fTipoAudiencia[0]=23;
										}
										$consulta="SELECT tipoAudiencia,numeroMetrica FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fTipoAudiencia[0];
										$fAudiencia=$con->obtenerPrimeraFila($consulta);
										$lblTipoAudiencia=$fAudiencia[0];
										if($fAudiencia[1]==0)
										{
											continue;
										}
										$lblTipoAudiencia=str_replace("Audiencia ","A. ",$lblTipoAudiencia);
										$arrTiposAudiencias[$lblTipoAudiencia."__".$fTipoAudiencia[0]]=$fTipoAudiencia[0];
										//
									}
									ksort($arrTiposAudiencias);
									$nDataSet=0;
									$arrDataSet="";
									$arrTotales=array();

									foreach($arrTiposAudiencias as $tAudiencia=>$idAudiencia)
									{
										$arrDatos=explode("_",$tAudiencia);
										$dataSet1="";
										foreach($arrJuez as $j=>$resto)
										{
											if(!isset($arrTotales[$j]))
												$arrTotales[$j]=0;
											$nEventos=0;
											$consulta="	SELECT e.horaInicioEvento,ta.numeroMetrica,e.idEdificio FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j,
											_4_tablaDinamica ta  WHERE e.idRegistroEvento=j.idRegistroEvento AND j.idJuez =".$j." AND fechaSolicitud>='".$fechaInicio." 00:00:00' 
											AND fechaSolicitud<='".$fechaFin." 23:59:59' and e.tipoAudiencia=".$idAudiencia." AND e.situacion IN(SELECT idSituacion 
											FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1) and ta.id__4_tablaDinamica=e.tipoAudiencia";
											
											$rEventos=$con->obtenerFilas($consulta);
											while($fEvento=mysql_fetch_row($rEventos))
											{
												$nEventos+=$fEvento[1];
											}
											
											
											if($dataSet1=="")
												$dataSet1=$nEventos;
											else
												$dataSet1.=",".$nEventos;
												
												
											$arrTotales[$j]+=$nEventos;	
											
										}
										
										$oDataSet="{
														label: '".$arrDatos[0]."',
														backgroundColor: color('#".$arrColores[$nDataSet]."').alpha(0.6).rgbString(),
														borderColor: '#".$arrColores[$nDataSet]."',
														borderWidth: 1,
														datalabels: {
																		color:'#000'
																	},
														data: 	[
																	".$dataSet1."
																]
													}";
										if($arrDataSet=="")
											$arrDataSet=$oDataSet;
										else
											$arrDataSet.=",".$oDataSet;
										$nDataSet++;
										
									}
									$dataSet1="";
									foreach($arrTotales as $valor)
									{
										if($dataSet1=="")
											$dataSet1=$valor;
										else
											$dataSet1.=",".$valor;
									}
									$oDataSet="{
														label: 'Total',
														backgroundColor: color('#FFF').alpha(0).rgbString(),
														borderColor: '#FFF',
														borderWidth: 1,
														datalabels: {
																		color:'#F00',
																		align: 'start',
																		anchor: 'start',
																		offset:-30
																	},
														data: 	[
																	".$dataSet1."
																]
													}";
										if($arrDataSet=="")
											$arrDataSet=$oDataSet;
										else
											$arrDataSet.=",".$oDataSet;
									
									
									
									 ?>	
                                    <div id="container" style="width: 80%;">
                                        <canvas id="canvas"></canvas>
                                    </div>
                                    <script>
                                    
                                    var color = Chart.helpers.color;
                                    var horizontalBarChartData = {
                                                                    labels: <?php echo $lblEtiquetas?>,
                                                                    datasets: [
                                                                                <?php echo $arrDataSet;?>
                                                                    
                                                                            	]
                                                        
                                                                };
                            
                                    window.onload = function() 
                                    {
                                        var ctx = document.getElementById('canvas').getContext('2d');
                                        window.myHorizontalBar = new Chart(ctx, {
                                                                                    type: 'bar',
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
                                                                                                            position: 'bottom',
                                                                                                            labels:	{
                                                                                                                        filter:function(i,c)
                                                                                                                                {
                                                                                                                                    return i.datasetIndex !== <?php echo $nDataSet?>;
                                                                                                                                }
                                                                                                                    }
                                                                                                        },
                                                                                                title: {
                                                                                                            display: true,
                                                                                                            fontSize:14,
                                                                                                            text: 'Distribución de eventos por juez (Incluye guardias)'
                                                                                                        },
                                                                                                scales: {
                                                                                                            xAxes: [
                                                                                                                        {
                                                                                                                            stacked: true,
                                                                                                                        }
                                                                                                                    ],
                                                                                                            yAxes: [
                                                                                                                        {
                                                                                                                            stacked: true
                                                                                                                        }
                                                                                                                    ]
                                                                                                        }
                                                                                            }
                                                                                }
                                                                            );
                            
                                    };
                            
                                    var colorNames = Object.keys(window.chartColors);
                                    
                                    </script>
									<?php
									

								break;
								case 6: //Migrado
									$dataSet1="";
									$lblEtiquetas="";
									$consulta="SELECT nombreUnidad,id__17_tablaDinamica FROM _17_tablaDinamica t WHERE cmbCategoria=1 order by prioridad";
									
									$arrCGJ=array();
									$listaUnidadesGestion="";
									
									$res=$con->obtenerFilas($consulta);
									while($fila=mysql_fetch_row($res))
									{
										$arrCGJ[$fila[1]]=1;
										if($listaUnidadesGestion=="")
											$listaUnidadesGestion=$fila[1]	;
										else
											$listaUnidadesGestion.=",".$fila[1];
										
										if($lblEtiquetas=="")
											$lblEtiquetas="'".$fila[0]."'";
										else
											$lblEtiquetas.=",'".$fila[0]."'";
											
										$nEventos=0;	
										$consulta="	SELECT e.fechaSolicitud,e.idEdificio FROM 7000_eventosAudiencia e
											  WHERE  fechaSolicitud>='".$fechaInicio." 00:00:00' 
											AND fechaSolicitud<='".$fechaFin." 23:59:59'  AND e.situacion IN(SELECT idSituacion 
											FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1) and 
											 idCentroGestion=".$fila[1];
										$rEventos=$con->obtenerFilas($consulta);
										while($fEvento=mysql_fetch_row($rEventos))
										{
											$nEventos+=1;
										}
										if($dataSet1=="")
											$dataSet1=$nEventos;
										else
											$dataSet1.=",".$nEventos;
										
									}
									$lblEtiquetas="[".$lblEtiquetas."]";
									
									?>	
                                        <div id="container" style="width: 85%;">
                                            <canvas id="canvas"></canvas>
                                        </div>
                                        <script>
                                        
                                        var color = Chart.helpers.color;
                                        var horizontalBarChartData = {
                                                                        labels: <?php echo $lblEtiquetas?>,
                                                                        datasets: [
                                                                                    {
                                                                                        label: 'Unidades de Gestión',
                                                                                        
                                                                                        backgroundColor: color('#286e81').alpha(0.8).rgbString(),
                                                                                        borderColor: '#286e81',
                                                                                        borderWidth: 1,
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
                                
                                        window.onload = function() 
                                        {
                                            var ctx = document.getElementById('canvas').getContext('2d');
                                            window.myHorizontalBar = new Chart(ctx, {
                                                                                        type: 'bar',
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
                                                                                                                position: 'bottom',
                                                                                                                display: false
                                                                                                            },
                                                                                                    title: {
                                                                                                                display: true,
                                                                                                                fontSize:14,
                                                                                                                padding:40,
                                                                                                                
                                                                                                                text: 'Distribución de Eventos por Unidad de Gestión (Incluye Guardias)'
                                                                                                            }
                                                                                                }
                                                                                    }
                                                                                );
                                
                                        };
                                
                                        var colorNames = Object.keys(window.chartColors);
                                        
                                        </script>
                                        <?php
								break;
								case 7: //migrado
									
									$fInicio=strtotime($fechaInicio);
									$diferencia=7-date("w",$fInicio);
									$fFinSemana=strtotime("+ ".$diferencia." days",$fInicio);
									
									if($fFinSemana>strtotime($fechaFin))
										$fFinSemana=strtotime($fechaFin);

									
									$nSemana=1;
									$arrSemanas=array();
									while($fInicio<=strtotime($fechaFin))
									{
										$arrSemanas[$nSemana]["leyenda"]="Semana ".$nSemana." (Del ".date("d/m/Y",$fInicio)." al ".date("d/m/Y",$fFinSemana).")";
										$arrSemanas[$nSemana]["fechaInicio"]=date("Y-m-d",$fInicio);
										$arrSemanas[$nSemana]["fechaFin"]=date("Y-m-d",$fFinSemana);
										$fInicio=strtotime("+1 days",$fFinSemana);
										$fFinSemana=strtotime("+ 7 days",$fFinSemana);
										if($fFinSemana>strtotime($fechaFin))
											$fFinSemana=strtotime($fechaFin);										
										
										$nSemana++;
									}
									$lblEtiquetas="";
									foreach($arrSemanas as $obj)
									{
										if($lblEtiquetas=="")	
											$lblEtiquetas="'".cv($obj["leyenda"])."'";
										else
											$lblEtiquetas.=",'".cv($obj["leyenda"])."'";
											
									}
									$lblEtiquetas="[".$lblEtiquetas."]";
									
									$dataSet1="";
									foreach($arrSemanas as $obj)
									{
										$consulta="SELECT COUNT(*) FROM _46_tablaDinamica WHERE idEstado>=1.4 AND fechaCreacion>='".$obj["fechaInicio"]."' 
													AND fechaCreacion<='".$obj["fechaFin"]." 23:59:59' AND delitoGrave<>1"	;
										$nEventos=$con->obtenerValor($consulta);
										if($dataSet1=="")
											$dataSet1=$nEventos;
										else	
											$dataSet1.=",".$nEventos;
									}
									
									
									$dataSet2="";
									foreach($arrSemanas as $obj)
									{
										$consulta="SELECT COUNT(*) FROM _46_tablaDinamica WHERE idEstado>=1.4 AND fechaCreacion>='".$obj["fechaInicio"]."' 
													AND fechaCreacion<='".$obj["fechaFin"]."  23:59:59' AND delitoGrave=1"	;
										$nEventos=$con->obtenerValor($consulta);
										if($dataSet2=="")
											$dataSet2=$nEventos;
										else	
											$dataSet2.=",".$nEventos;	
									}
									
									
									
									
									?>
                                        <div id="container" style="width: 100%;">
                                            <canvas id="canvas"></canvas>
                                        </div>
                                        <script>
                                        
                                        var color = Chart.helpers.color;
                                        var horizontalBarChartData = {
                                                                        labels: <?php echo $lblEtiquetas?>,
                                                                        datasets: [
                                                                                    {
                                                                                        label: 'Solicitudes recibidas Querella',
                                                                                        borderColor: '#FF0000',
                                                                                        borderWidth: 2,
                                                                                        pointBackgroundColor: '#FF0000',
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
                                                                                        label: 'Solicitudes recibidas  Prision preventiva oficiosa',
                                                                                        borderColor: '#003300',
                                                                                        pointBackgroundColor: '#003300',
                                                                                        fill: false,
                                                                                        borderWidth: 2,
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
                                
                                        window.onload = function() 
                                        {
                                            var ctx = document.getElementById('canvas').getContext('2d');
                                            window.myGrafico = new Chart(ctx, {
                                                                                        type: 'line',
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
                                                                                                                text: '<?php echo "Solicitudes por semana (Periodo del ".date("d/m/Y", strtotime($fechaInicio))." al ".date("d/m/Y", strtotime($fechaFin)).")"?>'
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
                                
                                        };
                                
                                        
                                        </script>
									<?php
								break;
								case 8://Migrado
									
									
									$arrDiasSemanaTemp[1]="Lunes";
									$arrDiasSemanaTemp[2]="Martes";
									$arrDiasSemanaTemp[3]=utf8_decode("Miércoles");
									$arrDiasSemanaTemp[4]="Jueves";
									$arrDiasSemanaTemp[5]="Viernes";
									$arrDiasSemanaTemp[6]=utf8_decode("Sábado");
									$arrDiasSemanaTemp[7]="Domingo";
									
									$lblEtiquetas="";
									foreach($arrDiasSemanaTemp as $dia)
									{
										if($lblEtiquetas=="")
											$lblEtiquetas="'".utf8_encode($dia)."'";
										else
											$lblEtiquetas.=",'".utf8_encode($dia)."'";
											
									}
									$lblEtiquetas="[".$lblEtiquetas."]";
									
									$totalEventosQuerella=0;
									$totalEventosPrision=0;
									
									$arrQuerella=array();
									$arrPrision=array();
									$consulta="SELECT fechaCreacion,delitoGrave FROM _46_tablaDinamica WHERE idEstado>=1.4 AND fechaCreacion>='".$fechaInicio."' 
													AND fechaCreacion<='".$fechaFin." 23:59:59'";
									$registros=$con->obtenerFilas($consulta);
									
									while($fRegistro=mysql_fetch_row($registros))
									{
										$dia=date("w",strtotime($fRegistro[0]));
										if($dia==0)
											$dia=7;
										if($fRegistro[1]<>1)
										{
											if(!isset($arrQuerella[$dia]))
												$arrQuerella[$dia]=0;
											$arrQuerella[$dia]++;
											$totalEventosQuerella++;
										}
										else
										{										
											if(!isset($arrPrision[$dia]))
												$arrPrision[$dia]=0;
											
											$arrPrision[$dia]++;
											$totalEventosPrision++;
										}
										
										
									}								
									
									$dataSet1="";
									$dataSet2="";
									
									for($x=1;$x<=7;$x++)
									{
										
										$valor=isset($arrQuerella[$x])?(($arrQuerella[$x]/$totalEventosQuerella)*100):0;
										$valor=number_format($valor,2);
										if($dataSet1=="")
											$dataSet1=$valor;
										else
											$dataSet1.=",".$valor;
										
										
									}
									
									for($x=1;$x<=7;$x++)
									{
										$valor=isset($arrPrision[$x])?(($arrPrision[$x]/$totalEventosPrision)*100):0;
										$valor=number_format($valor,2);
										if($dataSet2=="")
											$dataSet2=$valor;
										else
											$dataSet2.=",".$valor;
									}
									
									
									
									
									?>
                                        <div id="container" style="width: 90%;">
                                            <canvas id="canvas"></canvas>
                                        </div>
                                        <script>
                                        
                                        var color = Chart.helpers.color;
                                        var horizontalBarChartData = {
                                                                        labels: <?php echo $lblEtiquetas?>,
                                                                        datasets: [
                                                                                    {
                                                                                        label: '<?php echo "Querella (Total solicitudes: ".$totalEventosQuerella." [100%])"; ?>',
                                                                                        borderColor: '#FF0000',
                                                                                        borderWidth: 2,
                                                                                        pointBackgroundColor: '#FF0000',
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
                                                                                        label: '<?php echo "Prision preventiva oficiosa (Total solicitudes: ".$totalEventosPrision." [100%])"; ?>',
                                                                                        borderColor: '#003300',
                                                                                        pointBackgroundColor: '#003300',
                                                                                        fill: false,
                                                                                        borderWidth: 2,
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
                                
                                        window.onload = function() 
                                        {
                                            var ctx = document.getElementById('canvas').getContext('2d');
                                            window.myGrafico = new Chart(ctx, {
                                                                                        type: 'line',
                                                                                        data: horizontalBarChartData,
                                                                                        plugins: [ChartDataLabels],
                                                                                        
                                                                                        options: {
                                                                                                    responsive: true,
																									plugins: {
																												datalabels: {
																																formatter: function(value, context) 
																																{
																																	return value+' %';
																																}
																															}
																											},
                                                                                                    legend: {
                                                                                                                position: 'bottom'
                                                                                                                
                                                                                                            },
                                                                                                    title: {
                                                                                                                display: true,
                                                                                                                fontSize:14,
                                                                                                                text: 'Analisis de solicitudes iniciales por gravedad del delito por dia de semana'
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
                                                                                                            }
                                                                                                }
                                                                                    }
                                                                                );
                                
                                        };
                                
                                        
                                        </script>
									<?php
								break;
								case 9://MIgrado
									
									$arrDelitosQuerella=array();
									$arrDelitosOficioso=array();
									$totalDelitosQuerella=0;
									$totalDelitosOficioso=0;
									
									$consulta="SELECT s.fechaCreacion,delitoGrave,id__46_tablaDinamica,s.idActividad,denominacionDelito FROM _46_tablaDinamica s,_61_tablaDinamica d
												 WHERE  s.fechaCreacion>='".$fechaInicio."' AND s.fechaCreacion<='".$fechaFin.
												 " 23:59:59' and s.idEstado>=1.4 and d.idActividad=s.idActividad";
									$registros=$con->obtenerFilas($consulta);
									
									while($fRegistro=mysql_fetch_row($registros))
									{
										if((trim($fRegistro[4])=="")||($fRegistro[4]==-1))
										{
											continue;
										}
										
										if($fRegistro[1]<>1)
										{
											if(!isset($arrDelitosQuerella[$fRegistro[4]]))
												$arrDelitosQuerella[$fRegistro[4]]=0;
											$arrDelitosQuerella[$fRegistro[4]]++;
											$totalDelitosQuerella++;
										}
										else
										{
											if(!isset($arrDelitosOficioso[$fRegistro[4]]))
												$arrDelitosOficioso[$fRegistro[4]]=0;
											$arrDelitosOficioso[$fRegistro[4]]++;
											$totalDelitosOficioso++;
												
										}
										/*$consulta="SELECT denominacionDelito FROM _61_tablaDinamica WHERE idActividad=".$fRegistro[3];
										$resDelito=$con->obtenerFilas($consulta);
										while($fDelito=mysql_fetch_row($resDelito))
										{
											
											if((trim($fDelito[0])=="")||($fDelito[0]==-1))
											{
												continue;
											}
											
											if($fRegistro[1]<>1)
											{
												if(!isset($arrDelitosQuerella[$fDelito[0]]))
													$arrDelitosQuerella[$fDelito[0]]=0;
												$arrDelitosQuerella[$fDelito[0]]++;
												$totalDelitosQuerella++;
											}
											else
											{
												if(!isset($arrDelitosOficioso[$fDelito[0]]))
													$arrDelitosOficioso[$fDelito[0]]=0;
												$arrDelitosOficioso[$fDelito[0]]++;
												$totalDelitosOficioso++;
													
											}
										}*/
									}
									
									
									
									
									
									$arrUGASQuerella["001"]=1;
									$arrUGASQuerella["002"]=1;
									$arrUGASQuerella["003"]=1;
									$arrUGASQuerella["004"]=1;
									$arrUGASQuerella["005"]=1;
									
									$arrUGASGrave["006"]=1;
									$arrUGASGrave["007"]=1;
									$arrUGASGrave["008"]=1;
									$arrUGASGrave["209"]=1;
									$arrUGASGrave["010"]=1;
									$arrUGASGrave["011"]=1;
									
									
									
									$lblEtiquetas="";
									foreach($arrDelitosQuerella as $idDelito=>$resto)
									{
										$tipoDelito="";
										if($idDelito!="")
										{
											$consulta="SELECT denominacionDelito FROM _35_denominacionDelito WHERE id__35_denominacionDelito=".$idDelito;
											$tipoDelito=$con->obtenerValor($consulta);
										}
										else
											$tipoDelito="No definido";
										
										
										if($tipoDelito=="")
										{
											echo $idDelito."<br>";
										}
										
										
										if($lblEtiquetas=="")
											$lblEtiquetas="'".cv(substr($tipoDelito,0,30))."'";
										else
											$lblEtiquetas.=",'".cv(substr($tipoDelito,0,30))."'";
										
									}
									$lblEtiquetas="[".$lblEtiquetas."]";
									$dataSet1="";
									foreach($arrDelitosQuerella as $idDelito=>$resto)
									{
										
										if($dataSet1=="")
											$dataSet1=$resto;
										else
											$dataSet1.=",".$resto;
									}
									
									
									
									
									?>
                                        <div id="container" style="width: 100%;">
                                            <canvas id="canvas"></canvas>
                                        </div>
                                        <script>
                                        
                                        var color = Chart.helpers.color;
                                        var horizontalBarChartData = {
                                                                        labels: <?php echo $lblEtiquetas?>,
                                                                        datasets: [
                                                                                    {
                                                                                        label: 'Delitos Querella',
                                                                                        borderColor: '#003300',
                                                                                        borderWidth: 2,
                                                                                        pointBackgroundColor: '#003300',
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
                                
                                       
                                
                                        
                                        </script>
									<?php
									
									
									$lblEtiquetas="";
									foreach($arrDelitosOficioso as $idDelito=>$resto)
									{
										
										if($idDelito!="")
										{
											$consulta="SELECT denominacionDelito FROM _35_denominacionDelito WHERE id__35_denominacionDelito=".$idDelito;
											$tipoDelito=$con->obtenerValor($consulta);
										}
										else
											$tipoDelito="No definido";
										
										if($lblEtiquetas=="")
											$lblEtiquetas="'".cv(substr($tipoDelito,0,30))."'";
										else
											$lblEtiquetas.=",'".cv(substr($tipoDelito,0,30))."'";
										
									}
									$lblEtiquetas="[".$lblEtiquetas."]";
									$dataSet2="";
									foreach($arrDelitosOficioso as $idDelito=>$resto)
									{
										if($dataSet2=="")
											$dataSet2=$resto;
										else
											$dataSet2.=",".$resto;
										
									}
									
									
									?>
                                        <div id="container2" style="width: 100%;">
                                            <canvas id="canvas2"></canvas>
                                        </div>
                                        <script>
                                        
                                        
                                        var horizontalBarChartData2 = {
                                                                        labels: <?php echo $lblEtiquetas?>,
                                                                        datasets: [
                                                                                    {
                                                                                        label: 'Delitos Prisión Preventiva Oficiosa',
                                                                                        borderColor: '#FF0000',
                                                                                        borderWidth: 2,
                                                                                        pointBackgroundColor: '#FF0000',
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
                                
                                        window.onload = function() 
                                        {
											var ctx = document.getElementById('canvas').getContext('2d');
                                            window.myGrafico = new Chart(ctx, {
                                                                                        type: 'line',
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
                                                                                                                text: '<?php echo "Analisis de solicitudes iniciales por tipo de delito Querella (Total: ".$totalDelitosQuerella.")"; ?>'
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
                                            ctx = document.getElementById('canvas2').getContext('2d');
                                            window.myGrafico2 = new Chart(ctx, {
                                                                                        type: 'line',
                                                                                        data: horizontalBarChartData2,
                                                                                        plugins: [ChartDataLabels],
                                                                                        
                                                                                        options: {
                                                                                                    responsive: true,
                                                                                                    legend: {
                                                                                                                position: 'bottom'
                                                                                                                
                                                                                                            },
                                                                                                    title: {
                                                                                                                display: true,
                                                                                                                fontSize:14,
                                                                                                                text: '<?php echo "Analisis de solicitudes iniciales por tipo de delito Prision preventiva oficiosa (Total: ".$totalDelitosOficioso.")"; ?>'
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
                                
                                        };
                                
                                        
                                        </script>
									<?php
								break;
								case 11: //MIgrado
									
									$dataSet1="";
									$dataSet2="";
									
									$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$unidadGestion."'";
									$unidadGestion=$con->obtenerValor($consulta);
									$arrJuez=array();
									
									$lblEtiquetas="";
									$consulta="SELECT clave,u.nombre,u.idUsuario FROM _26_tablaDinamica t,800_usuarios u WHERE idReferencia=".$unidadGestion.
									" AND u.idUsuario=t.usuarioJuez";

									$res=$con->obtenerFilas($consulta);
									while($fila=mysql_fetch_row($res))
									{
										if($lblEtiquetas=="")
											$lblEtiquetas="'".$fila[0]." ".$fila[1]."'";
										else
											$lblEtiquetas.=",'".$fila[0]." ".$fila[1]."'";
										
										
										
										$arrJuez[$fila[2]]=1;
									}
									
									$lblEtiquetas="[".$lblEtiquetas."]";
									
									
									foreach($arrJuez as $idUsuario=>$resto)
									{
										$consulta="SELECT COUNT(*) FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j WHERE fechaEvento>='".$fechaInicio.
													"' AND fechaEvento<='".$fechaFin."' and situacion IN(1,2,4,5) AND idCentroGestion=".$unidadGestion." AND j.idRegistroEvento=e.idRegistroEvento 
													AND j.idJuez=".$idUsuario;
										$nEventos=$con->obtenerValor($consulta);
										
										
										
										if($dataSet1=="")
											$dataSet1=$nEventos;
										else
											$dataSet1.=",".$nEventos;		
									}
									
									
									
									foreach($arrJuez as $idUsuario=>$resto)
									{
										$consulta="SELECT sum(duracionAudienciaMAJO) FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j WHERE fechaEvento>='".$fechaInicio.
													"' AND fechaEvento<='".$fechaFin."' and situacion IN(1,2,4,5) AND idCentroGestion=".$unidadGestion.
													" AND e.duracionAudienciaMAJO>=10 and e.duracionAudienciaMAJO<350 and j.idRegistroEvento=e.idRegistroEvento  
													and e.duracionAudienciaMAJO is not null AND j.idJuez=".$idUsuario;
										$nEventos=$con->obtenerValor($consulta);
										
										$totalHoras=str_replace(",","",number_format(($nEventos/60),0));
										if($dataSet2=="")
											$dataSet2=$totalHoras;
										else
											$dataSet2.=",".$totalHoras;	
									}
									
									?>
                                        <div id="container" style="width: 100%;">
                                            <canvas id="canvas"></canvas>
                                        </div>
                                        <script>
                                        
                                        var color = Chart.helpers.color;
                                        var horizontalBarChartData = {
                                                                        labels: <?php echo $lblEtiquetas?>,
                                                                        datasets: [
                                                                                    {
                                                                                        label: 'Total de audiencias',
                                                                                        borderColor: '#FF0000',
                                                                                        borderWidth: 2,
                                                                                        pointBackgroundColor: '#FF0000',
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
                                                                                        label: 'Total horas audiencias',
                                                                                        borderColor: '#003300',
                                                                                        pointBackgroundColor: '#003300',
                                                                                        fill: false,
                                                                                        borderWidth: 2,
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
                                
                                        window.onload = function() 
                                        {
                                            var ctx = document.getElementById('canvas').getContext('2d');
                                            window.myGrafico = new Chart(ctx, {
                                                                                        type: 'line',
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
                                                                                                                text: 'Total de audiencias por juez'
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
                                
                                        };
                                
                                        
                                        </script>
									<?php
									
									
								break;
								
								
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
