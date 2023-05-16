<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");

$arrDias=array();
function calcularNumHoras($idUsuario,$fechaInicio,$fechaFin)
{
	global $con;
	global $arrDias;
	$consulta="select numDia,horasLaborales,minutosLaborales from 979_horariosLaborUsuario where idUsuario=".$idUsuario." order by numDia";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$arrDias[$fila[0]]=($fila[1]*60)+$fila[2];
	}
	$minutosTotas=0;
	$fInicio=strtotime($fechaInicio);
	$fFin=strtotime($fechaFin);
	while($fInicio<=$fFin)
	{
		if(isset($arrDias[date("w",$fInicio)]))
			$minutosTotas+=$arrDias[date("w",$fInicio)];
		$fInicio=strtotime("+1 day",$fInicio);
	}
	return $minutosTotas;
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
	$guardarConfSession=true;
	
	
?>
<style>
	body
	{
		min-width:4700px !important;
	}
	
	div.scroll2
	{
		width:3700px !important;
	}
</style>
<link rel="stylesheet" type="text/css" href="../Scripts/jsgantt/jsgantt.css" />
<script language="javascript" src="../Scripts/jsgantt/jsgantt.js"></script>

<!--<script type="text/javascript" src="../Scripts/ext/idioma/ext-lang-es.js"></script>-->
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
<?php
	if(!isset($pagRegresar))
		$pagRegresar="../principal/inicio.php";
?>

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
                        <script type="text/javascript" src="../modeloProyectos/Scripts/programaTrabajo.js.php"></script>
                        <?php
							$inicializar="0";
							$idUsuario=$_SESSION["idUsr"];
							if(isset($objParametros->idUsuario))
								$idUsuario=base64_decode($objParametros->idUsuario);
							$fechaInicio=date('Y-01')."-01";
							if(isset($objParametros->fI))
								$fechaInicio=$objParametros->fI;
							$fIni=$fechaInicio;
							$fechaFin=date('Y-12')."-31";
							if(isset($objParametros->fF))
								$fechaFin=$objParametros->fF;
							$fFin=$fechaFin;
							$consulta="select * from 965_actividadesUsuario where 
									idUsuario=".$idUsuario." and
									((fechaInicio>='".$fIni."' and fechaInicio<='".$fFin."') or (fechaFin>='".$fIni."' and fechaFin<='".$fFin."') ) 
									order by fechaInicio";
							
							$fila=$con->obtenerFilas($consulta);
							if($con->filasAfectadas>0)
								$inicializar="1";
							$sl=0;
							
							if(isset($objParametros->sl))
								$sl=$objParametros->sl;
							$minutosIntervalo=calcularNumHoras($idUsuario,$fechaInicio,$fechaFin);
							$horas=intval($minutosIntervalo/60);
							$minutos=$minutosIntervalo-($horas*60);
							$minutosSemana=0;
							for($x=0;$x<7;$x++)
							{
								if(isset($arrDias[$x]))
									$minutosSemana+=$arrDias[$x];
							}
							$horasSemana=intval($minutosSemana/60);
							$minutosSemana-=$horasSemana*60;
							$desgloceTiempo=NULL;
							$horasComprometidad=calcularHorasComprometidas($idUsuario,$fechaInicio,$fechaFin,$desgloceTiempo);
							$minComprometidos=0;
							$tiempoComprometido=($horasComprometidad*60)+$minComprometidos;
							$minutosLibres=$minutosIntervalo-$tiempoComprometido;
							$horasLibres=intval($minutosLibres/60);
							$minutosLibres-=($horasLibres*60);
							
						?>
                        	<table width="100%">
                        	<tr>
                            	<td align="center" colspan="3"><br />
                                	<span class="tituloPaginas">Programa de trabajo</span>
                                    
                                   <br /><br />
                                    <br />
                                </td>
                            </tr>
                            <tr>
                            	<td align="left" colspan="3">
                               	 <table >
                                    <tr>
                                      	<td><span class="copyrigthSinPadding" >Periodo del</span>&nbsp;&nbsp;</td><td><span id='spDel'></span></td><td>&nbsp;&nbsp;<span class="copyrigthSinPadding" >Al</span>&nbsp;&nbsp;</td><td><span id='spAl'></span></td>
                                       	<td width=""></td>
	                                   	<td>&nbsp;&nbsp;<a href="javaScript:refresarPrograma()"><img src="../images/arrow_refresh.PNG" title='Ver programa en el intervalo de fechas marcado' alt="Ver programa en el intervalo de fechas marcado" /></a></td>
                                    	
                                        
                                    </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr height="10">
                            	<td>&nbsp;
                                </td>
                            </tr>
                            <tr>
                            	<td  colspan="3">
                                	<table >
                                    <tr>
                                    	<td width="500">
                                        <fieldset class="frameHijo"><legend >Estadísticas del tiempo &nbsp;&nbsp;<a href="javascript:mostrarOcultarHoras()"><img id='imgHora' estado='0' src="../images/verMenos2.png" title="Ocultar estadísticas de tiempo" alt="Ocultar estadísticas de tiempo"></a></legend>
                                        <table class="" id='tblEstadisticas'>
                                        <tr>
                                            <td colspan="4">
                                                <table width="100%"> 
                                                <tr>
                                                <td>
                                                    <table width="">
                                                        <tr>
                                                            <td width="160" style="padding:4px" valign="top"><span class="corpo8_bold">Usuario:</span></td>
                                                            <td style="padding:4px" colspan="3"><span class="copyrigthSinPadding" ><?php echo obtenerNombreUsuario($idUsuario)?></span></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <?php
                                            if($horasSemana>0)
                                            {
                                        ?>
                                        <tr height="16">
                                            <td colspan="4"></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:4px"><span class="corpo8_bold">Tiempo de trabajo x Semana:</span></td>
                                            
                                            <td align="right" width="70">
                                            <span class="copyrigthSinPadding">
                                                    <b><?php echo $horasSemana?></b> hrs. </b>
                                            </span>
                                            </td>
                                            <td align="right" width="40">
                                            <span class="copyrigthSinPadding">
                                                    <?php echo $minutosSemana?></b> min.
                                            </span>
                                            </td>
                                            <td width="50">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="center"><span class="letraRojaSubrayada8">
                                            Tiempo calculado del periodo:
                                            </span>
                                            </td>
                                        </tr>
                                         <tr>
                                            <td style="padding:4px"><span class="corpo8_bold">Tiempo total:</span></td>
                                            <td align="right" >
                                            <span class="copyrigthSinPadding">
                                                    <b><?php echo $horas?></b> hrs.
                                            </span>
                                            </td>
                                            <td align="right">
                                            <span class="copyrigthSinPadding">
                                                    <?php echo $minutos?></b> min.
                                            </span>
                                            </td>
                                            <td align="left"  width="120">
                                            <span class="copyrigthSinPadding" >
                                                    &nbsp;&nbsp;&nbsp;(100%)
                                            </span>
                                            </td>
                                        </tr>
                                         <tr>
                                            <td style="padding:4px"><span class="corpo8_bold">Tiempo comprometido:</span></td>
                                            <td align="right" >
                                            <span class="copyrigthSinPadding">
                                                    <b><?php echo $horasComprometidad?></b> hrs. 
                                            </span>
                                            </td>
                                            <td align="right">
                                            <span class="copyrigthSinPadding">
                                                    <?php echo $minComprometidos?></b> min.
                                            </span>
                                            </td>
                                            <td align="left" >
                                             <span class="copyrigthSinPadding">
                                                    &nbsp;&nbsp;
                                                    <?php
                                                        $cociente=(($horasComprometidad*60)+$minComprometidos);
                                                        $resultado=((($horas*60)+$minutos));
                                                        if($resultado==0)
                                                            $porcentajeC=0.00;
                                                        else
                                                            $porcentajeC=number_format(( $cociente/$resultado )*100,2,'.',',');
                                                        echo "(".$porcentajeC."%)";
                                                    ?>
                                            </span>
                                            </td>
                                        </tr>
                                        <tr height="1">
                                            <td colspan="3" style="background-color:#003">
                                            </td>
                                            <td>
                                            </td>
                                            
                                        </tr>
                                         <tr>
                                            <td style="padding:4px"><span class="corpo8_bold">Tiempo disponible:</span></td>
                                            <td align="right" >
                                            <span class="copyrigthSinPadding">
                                                    <b><?php echo $horasLibres?></b> hrs. </b>
                                            </span>
                                            </td>
                                            <td align="right">
                                            <span class="copyrigthSinPadding">
                                                    <?php echo $minutosLibres?></b> min.
                                            </span>
                                            </td>
                                            <td align="left" >
                                            <span class="copyrigthSinPadding">
                                                    &nbsp;&nbsp;
                                                    <?php
                                                        
                                                        echo "(".(100-$porcentajeC)."%)";
                                                    ?>
                                            </span>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                            else
                                            {
                                        ?>
                                            <tr>
                                            <td align="center">
                                            <br />
                                            <table width="450">
                                            <tr>
                                                <td colspan="4" align="center">
                                                    <span class="copyrigthSinPadding">
                                                    No se pueden generar estadísticas debido al que el usuario seleccionado no ha configurado su horario de trabajo.
                                                    </span>
                                                </td>
                                            </tr>
                                            </table>
                                            </td>
                                            </tr>
                                        <?php
                                            }
                                        ?>
                                        </table>
                                        </fieldset>
                                        </td>
                                        <td width="200">
                                        </td>
                                        <td valign="top">
                                        	<fieldset class="frameHijo"><legend>Prioridad de la actividad</legend>
                                            <table width="170">
                                            <tr>
                                            <?php
                                                $consulta="select * from 967_prioridadActividad order by idPrioridad";
                                                $res=$con->obtenerFilas($consulta);
                                                while($fila=mysql_fetch_row($res))
                                                {
                                            ?>
                                                    
                                                        <td style=" background-color: #<?php echo $fila[2]?>" width="30"></td><td width="10"></td><td><span class="corpo8"_bold><?php echo $fila[1]?></span></td><td width="20"></td>
                                                    
                                            <?php
                                                }
                                            ?>
                                            </tr>
                                            </table>
                                      		</fieldset>
                                        </td>
                                    </tr>
                                    </table>    
                                </td>
                                <td width="200" valign="top"><br />
                                	 
                                </td>
                                <td width="200">
                                	
                                </td>
                            </tr>
                            <?php
								if($sl=='0')
								{
							?>
                            <tr>
                             <td colspan="3" align="left">
                             	<br /><br />
                                            <span class="letraFichaRespuesta">Si desea agregar una nueva actividad de click <a href="javascript:agregarActividad(-1)"><span class="letraRoja">AQUÍ</span></a></span>
                                           
                             </td>
                            </tr>
                            <?php
                            	}
                            ?>
                            <tr>
                            <td colspan="3"><br /> <br /><br />
                            <?php
								
								if($inicializar=="0")
								{
								 ?>
								<table width="100%">
								<tr>
									<td class="letraFicha" align="center" class="" >
										Actualmente no cuenta con actividades planeadas
									</td>
								</tr>
								</table>
								<?php
								}
								
								?>
                            
	                            <div style="position:relative" class="gantt" id="GanttDiv"></div>
                            </td>
                            </tr>
                        	</table>
                            <form method="post" action="../modeloProyectos/programaTrabajo.php" id="frmReenvio">
                                <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo base64_encode($idUsuario) ?>" />
                                <input type="hidden" name="sl" id="sl" value="<?php echo ($sl) ?>" />
                                <input type="hidden" name="fI" id="fIni" value="<?php echo date('d/m/Y',strtotime($fechaInicio)) ?>" />
                                <input type="hidden" name="fF" id="fFin" value="<?php echo date('d/m/Y',strtotime($fechaFin)) ?>" />
                                <?php 
								if($nConfRegresar!="")
								{
								?>
                                <input type="hidden" name="confReferencia" value="<?php echo $nConfRegresar ?>" />
                                <?php
								}
								?>
                            </form>
                            
                            <input type="hidden" name="idUsuario" id="idUsuarioB64" value="<?php echo base64_encode($idUsuario) ?>" />
                            <input type="hidden" name="sl" id="slB64" value="<?php echo base64_encode($sl) ?>" />
                            <input type="hidden" name="fIni" id="fIniB64" value="<?php echo base64_encode($fechaInicio) ?>" />
                            <input type="hidden" name="fFin" id="fFinB64" value="<?php echo base64_encode($fechaFin) ?>" />
                            <input type="hidden" name="inicializar" id="inicializar" value="<?php echo $inicializar ?>" />
                            
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
