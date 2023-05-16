<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");?>

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
	$pagRegresar="../principal/inicio.php";
	$mostrarMenuIzq=false;
	$guardarConfSession=true;
?>

<style>
	body
	{
		min-width:3160px !important;
	}
</style>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../Scripts/ux/menu/EditableItem.js"></script>
<script type="text/javascript" src="../Scripts/ux/menu/RangeMenu.js"></script>
<script type="text/javascript" src="../Scripts/ux/menu/ListMenu.js"></script>
<script type="text/javascript" src="../Scripts/ux/grid/GridFilters.js"></script>
<script type="text/javascript" src="../Scripts/ux/grid/filter/Filter.js"></script>
<script type="text/javascript" src="../Scripts/ux/grid/filter/StringFilter.js"></script>
<script type="text/javascript" src="../Scripts/ux/grid/filter/DateFilter.js"></script>
<script type="text/javascript" src="../Scripts/ux/grid/filter/ListFilter.js"></script>
<script type="text/javascript" src="../Scripts/ux/grid/filter/NumericFilter.js"></script>
<script type="text/javascript" src="../Scripts/ux/grid/filter/BooleanFilter.js"></script>

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
								$idUsuario="-1";
								$comp="";
								if(isset($objParametros->idUsuario))
								{
									$idUsuario=bD($objParametros->idUsuario);
									$comp=" (Individuales)";
								}
								$tipoConsulta=1;
								$tSingular="cálculo";
								$tPlural="calculos";
								$nTabla="662_calculosNomina";
								$idTabla="idCalculo";
								
								$idPerfil="-1";
								if($objParametros->idPerfil)
									$idPerfil=$objParametros->idPerfil;
								
								if($idUsuario=="-1")
								{
									$consulta="select d.".$idTabla.",c.codigo,c.nombreConsulta,afectacionNomina,quincenaAfectacion,nQuincenasAfectacion,cicloAfectacion,tipoCalculo,c.idConsulta ,orden from ".$nTabla." d,991_consultasSql c 
									where c.idConsulta=d.idConsulta and idUsuarioAplica is null and idPerfil=".$idPerfil." order by orden";
									$query="select max(orden) from  ".$nTabla." where idUsuarioAplica is null and idPerfil=".$idPerfil;
								}
								else
								{
									$consulta="select d.".$idTabla.",c.codigo,c.nombreConsulta,afectacionNomina,quincenaAfectacion,nQuincenasAfectacion,cicloAfectacion,tipoCalculo,c.idConsulta ,orden from ".$nTabla." d,991_consultasSql c where c.idConsulta=d.idConsulta and idUsuarioAplica = ".$idUsuario." order by orden";
									$query="select max(orden) from  ".$nTabla." where idUsuarioAplica = ".$idUsuario;
								}
								$res=$con->obtenerFilas($consulta);
								$nRegistros=$con->obtenerValor($query);
								$consulta="select idTipoPresupuesto,tituloTipoP from 508_tiposPresupuesto order by tituloTipoP";
								$arrTipoPresupuesto=$con->obtenerFilasArregloAsocPHP($consulta);
								$nivelAcumulador="0";
								if($idUsuario!="-1")
								{
									$nivelAcumulador="1";
									$consulta="select idAcumuladorNomina,nombreAcumulador from 665_acumuladoresNomina where 
											codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and nivelAcumulador in  (".$nivelAcumulador.") and idUsuario=".$idUsuario;
							
								}
								else
								{
									$consulta="select idAcumuladorNomina,nombreAcumulador from 665_acumuladoresNomina where 
											codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and nivelAcumulador in  (".$nivelAcumulador.")  and idPerfil=".$idPerfil;
								}
								$arrAcumuladores=$con->obtenerFilasArreglo($consulta);
								$consulta="select nombrePerfil from 662_perfilesNomina where idPerfilesNomina=".$idPerfil;
								$perfil=$con->obtenerValor($consulta);
							?>
                            <script type="text/javascript" src="../nomina/Scripts/calculosNomina.js.php?idUsuario=<?php echo bE($idUsuario)?>"></script>
                            <table width="100%">
                            <tr>
                                	<td align="left" colspan="2"><br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    	<span class="tituloPaginas">Cálculos a considerar en el perfil: <span class="letraRojaSubrayada8"><?php echo $perfil?></span></span><br /><br /><br /><br />
                        			</td>
                           	</tr>
                            </table><br /><br />
                            <table  width="100%">
                            	<tr>
                                	<td >
                                    	<table class="tablaMenu">
                                        	<tr height="21">
                                            	<td width="30">&nbsp;&nbsp;
                                                <a href="javascript:modificarEscenario()">
                                                <img src="../images/page_process.png" title="Modificar escenario" />
                                                </a>
                                                </td>
                                            	<td width="150" align="left">
                                                <a href="javascript:modificarEscenario()">
                                                <span class="letraRojaSubrayada8">Escenario n&oacute;mina</span>
                                                </a>
                                                </td>
                                            
                                           
                                            	<td width="30">
                                                <a href="javascript:agregarConcepto()">
                                                <img src="../images/add.png" title="Agregar nuevo cálculo" />
                                                </a>
                                                </td>
                                            	<td width="150" align="left">
                                                <a href="javascript:agregarConcepto()">
                                                <span class="letraRojaSubrayada8">Agregar nuevo c&aacute;lculo</span>
                                                </a>
                                                </td>
                                            
                                            	<td width="30">
                                                <a href="javascript:agregarAcumulador()"><img src="../images/formularios/calculator_add.png" title="Administrar acumuladores" /></a>
                                                </td>
                                            	<td width="150" align="left">
                                                <a href="javascript:agregarAcumulador()"><span class="letraRojaSubrayada8">Administrar acumuladores</span></a>
                                                </td>
                                        	</tr>    
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            
                        	<table  width="100%">
                            	
                                
                                
                                <tr>
                                <td align="left">
                                <br /><br />
                                	<table>
                                <?php
										if($nRegistros==0)
										{
									?>
                                <tr>
                                	<td align="left" colspan="2"><br /><br />
                                    	
                                    	<span class="copyrigthSinPadding">Aún no existe algún cálculo de nómina configurado</span>	
									
                                    </td>
                                </tr>
                                <?php		
										}
										else
										{
								?>
                                <tr>
                                	<td align="left" width="100">
                                    	<span class="corpo8_bold" >
                                    	Orden cálculo
                                        </span>
                                    </td>
                                    <td align="center" width="110">
                                    	<span class="corpo8_bold">
                                    	Tipo de cálculo
                                        </span>
                                    </td>
                                    <td align="center" width="200">
                                    	<span class="corpo8_bold">
                                    	Utilizar resultado en acumulador:
                                        </span>
                                    </td>
                                	<td align="center" width="85">
                                    	<span class="corpo8_bold">
                                    	Código
                                        </span>
                                    </td>
                                    <td align="center" width="300">
                                    <span class="corpo8_bold">
                                    	Cálculo
                                    </span>
                                    </td>
                                    <td align="center" width="300">
                                    <span class="corpo8_bold">
                                    	Parámetros
                                    </span>
                                    </td>
                                    <?php
									if($idUsuario==-1)
									{
									?>
                                    <td align="center" width="180">
                                    <span class="corpo8_bold">
                                    	Aplicar a puestos
                                    </span>
                                    </td>
                                    <?php
									}
									?>
                                    <td align="center" width="180">
                                    <span class="corpo8_bold">
                                    	Afectación a la nomina
                                    </span>
                                    </td>
                                    <td align="center" width="300">
                                    <span class="corpo8_bold">
                                    	Quincena afectación
                                    </span>
                                    </td>
                                    <td align="center" width="950">
                                    <span class="corpo8_bold">
                                    	Afectación de cuentas
                                    </span>
                                    </td>
                                    
                                </tr>
                                <tr height="4">
                                	<td colspan="10" ></td>
                                </tr>
                                <tr height="2">
                                	<td colspan="10" style="background-color:#003"></td>
                                </tr>
                                <tr height="4">
                                	<td colspan="10" ></td>
                                </tr>
                                <?php
											$clase="filaBlanca10";
											$tipoCalculo="";
											while($fila=mysql_fetch_row($res))
											{
												switch($fila[7])
												{
													case 0:
														$tipoCalculo="Cálculo auxiliar";
													break;
													case 1:
														$tipoCalculo="Deducción";
													break;
													case 2:
														$tipoCalculo="Percepción";
													break;	
												}
								?>
                                <tr id='fila_<?php echo $fila[0]?>'>
                                	 <td align="left" class='<?php echo $clase?>'>
                                     <a href="javascript:removerConcepto('<?php echo bE($fila[0])?>')">
                                        <img src="../images/cancel_round.png" title="Remover percepción" alt='Remover percepción' />
                                     </a>
                                     <a href='javascript:modificarOrdenCalculo(<?php echo $fila[9]?>,"<?php echo bE($fila[0])?>",<?php echo $nRegistros?>)'>
                                     <img src="../images/resultset_next.png" alt='Modificar orden de c&aacute;lculo' title='Modificar orden de c&aacute;lculo'/>
                                     </a>
                                    	<span class="letraExt">
                                    	<?php
											echo $fila[9].".- ";
										?>
                                        </span>
                                        
                                        
                                    </td>
                                    <td align="left" class='<?php echo $clase?>'>
                                    	<span class="letraExt">
                                        <?php echo $tipoCalculo?>
                                        </span>
                                    </td>
                                    <td align="left" class='<?php echo $clase?>'>
                                    	<table width="100%">
                                        <tr>
                                        <td align="right">
                                    		<a href='javascript:asignarAcumulador("<?php echo bE($fila[0])?>")'><img src="../images/add.png" width="13" height="13" title="Agregar acumulador" />    </a>
                                            <?php
												$consulta="SELECT a.idAcumuladorCalculo,a.operacion,n.nombreAcumulador FROM 666_acumuladoresCalculo a,665_acumuladoresNomina n WHERE n.idAcumuladorNomina=a.idAcumulador AND a.idCalculo=".$fila[0];
												$resAcum=$con->obtenerFilas($consulta);
												if($con->filasAfectadas>0)
												{
													
													
											?>
                                            
                                            
                                                    <table width="100%">
                                                    <tr>
                                                    	<td>
                                                        	<table>
                                                    		<tr>
                                                                <td width="200" class="fondoVerde7" style="color:#000">
                                                                Acumulador
                                                                </td>
                                                                <td width="100" class="fondoVerde7" style="color:#000">
                                                                Operaci&oacute;n
                                                                </td>
                                                                <td width="30" class="fondoVerde7" style="color:#000">
                                                                
                                                                </td>
                                                            </tr>
                                                            <?php
                                                                while($filaAcum=mysql_fetch_row($resAcum))
                                                                {
																	$lblAccion="";
																	switch($filaAcum[1])
																	{
																		case "+":
																			$lblAccion="Sumar";
																		break;
																		case "-":
																			$lblAccion="Restar";
																		break;
																		case "*":
																			$lblAccion="Multiplicar";
																		break;
																		case "/":
																			$lblAccion="Dividir";
																		break;
																		case "=":
																			$lblAccion="Asignar";
																		break;
																		
																	}
                                                                    echo '<tr id="fila_'.$filaAcum[0].'">
                                                                                <td class="fondoGrid7" style="color:#000">'.$filaAcum[2].'</td>
                                                                                <td class="fondoGrid7" style="color:#000">'.$filaAcum[1]." (".$lblAccion.')</td>
																				 <td class="fondoGrid7" style="color:#000">
																				 <a href="javascript:removerAsignacionAcum(\''.bE($filaAcum[0]).'\')"><img src="../images/delete.png" title="Remover asignaci&oacute;n de acumulador" alt="Remover asignaci&oacute;n de acumulador"></a>
																				 </td>
                                                                            </tr>
                                                                            ';	
                                                                    
                                                                }
                                                            ?>
                                                       		</table>
                                                       </td>
                                                   </tr>

                                                    </table>
                                            <?php
												}
											?>
                                    	</td>
                                        </tr>
                                        </table>
                                    
                                    </td>
                                	<td align="left" class='<?php echo $clase?>'>
                                    	<span class="letraExt">
                                    	<?php
											echo $fila[1];
										?>
                                        </span>
                                       
                                    </td>
                                    <td align="left" class='<?php echo $clase?>'>
                                    	<span class="letraExt">
                                    	<?php
											echo $fila[2];
										?>
                                        </span>
                                        
                                    </td>
                                    <td align="left" class='<?php echo $clase?>'>
                                    	<table>
                                    	
                                    	<?php
											$consulta="select idParametro,parametro from 993_parametrosConsulta where idConsulta=".$fila[8]." order by parametro";
											$resParam=$con->obtenerFilas($consulta);
											while($filaP=mysql_fetch_row($resParam))
											{
												$consulta="select valor,tipoValor from 663_valoresCalculos where idCalculo=".$fila[0]." and idParametro=".$filaP[0];
												$filaValParam=$con->obtenerPrimeraFila($consulta);
												$valor=$filaValParam[0];
												
												
												
												switch($filaValParam[1])
												{
													case "21":
														$consulta="SELECT nombreAcumulador FROM 665_acumuladoresNomina WHERE idAcumuladorNomina=".$valor;
														$valor=$con->obtenerValor($consulta);
													break;
													case "2":
														if($idUsuario!="-1")
														{
															$consulta="select concat(orden,'.- [',co.codigo,'] ',co.nombreConsulta,' <br>[<b>Tipo:</b> ',if(idUsuarioAplica is null,'Global','Individual'),']')  from 662_calculosNomina c,
																		991_consultasSql co where co.idConsulta=c.idConsulta and 
																		c.idCalculo =".$valor;
														}
														else
														{
															$consulta="select concat(orden,'.- [',co.codigo,'] ',co.nombreConsulta)  from 662_calculosNomina c,
																		991_consultasSql co where co.idConsulta=c.idConsulta and 
																		c.idCalculo =".$valor;
														}
														$valor=$con->obtenerValor($consulta);
													break;
													default:
													break;
														
												}
												echo "<tr height='21'><td valign='top'><b><span class='letraExt'>".$filaP[1]."=</span></b></td><td width='3'></td><td valign='top'><span id='lblValor_".$fila[0]."_".$filaP[0]."'>".$valor."</span></td><td valign='top'>&nbsp;<a href='javascript:modificarValorParametro(\"".bE($fila[0])."\",\"".bE($filaP[0])."\",\"".bE($fila[9])."\")'><img src='../images/pencil.png' title='Modificar valor par&aacute;metro' alt='Modificar valor par&aacute;metro'></a></td></tr>";
											}
										?>
                                       
                                        </table>
                                    </td>
                                    <?php
										if($idUsuario==-1)
										{
									?>
                                    <td align="left" class='<?php echo $clase?>'>
                                    	<table width="100%">
                                        <tr height='21'>
                                        	<td align="right">
                                            	<a href="javascript:seleccionarTodos('<?php echo bE($fila[0])?>')"><span style="color:#900">Seleccionar todos</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:agregarPuestoCalculo('<?php echo bE($fila[0])?>','<?php echo bE($fila[2])?>')"><img src="../images/user_add.png" title='Agregar puesto' alt='Agregar puesto'/></a>
                                            </td>
                                        </tr>
                                        <tr height="1">
                                        	<td style="background-color:#FF3">
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td>
                                    	<?php
											$checar="";
											
											
											$consulta="SELECT txtClave,txtTipoContratacion FROM _669_tablaDinamica WHERE codigoInstitucion='".$_SESSION["codigoInstitucion"]."' order by txtTipoContratacion";
											$resTipoPuesto=$con->obtenerFilas($consulta);
											while($filaPuesto=mysql_fetch_row($resTipoPuesto))
											{
												$checar="";
												$consulta="select idTipoPuestoAfecta from 660_afectacionesDeducPercepciones where idDeduccionPercepcion=".$fila[0]." and  afectacion=".$filaPuesto[0];
												$vRes=$con->obtenerValor($consulta);
												if($vRes!="")
													$checar='checked="checked"';
											?>
                                            	<input type="checkbox" id='chk_<?php echo $filaPuesto[0]?>_<?php echo $fila[0]?>' name="chk_<?php echo $fila[0]?>" onclick="actualizaAfectacion(this)" <?php echo $checar?> />&nbsp;<span class="letraExt"><?php echo "[".$filaPuesto[0]."] ".$filaPuesto[1]?></span>&nbsp;<br />
                                            
                                            <?php
											}
										}
									?>
                                    	</td>
                                    </tr>
                                    </table>
                                    <td align="left" class='<?php echo $clase?>'>
                                    	
                                        
											<?php
                                                $leyenda="Sin configurar <a href=\"javascript:configurarQuincenasAplicacion('".$fila[0]."')\"><img src='../images/pencil.png' alt='Configurar quincena aplicación' title='Configurar quincena aplicación'></a>";
                                                switch($fila[3])
                                                {
                                                    case 1:
                                                        $checar1='checked="checked"';
                                                        $checar2="";
                                                        $checar3="";
                                                        $leyenda="N/A";
                                                    break;
                                                    case 2:
                                                        if($fila[4]!="")
                                                        {
                                                            $leyenda="Quincena inicio: ".$fila[4]." (Ciclo: ".$fila[6]."), + ".($fila[5]-1)." quincenas <a href=\"javascript:configurarQuincenasAplicacion('".$fila[0]."')\"><img src='../images/pencil.png' alt='Configurar quincena aplicación' title='Configurar quincena aplicación'></a>";
                                                        }
                                                        $checar2='checked="checked"';
                                                        $checar1="";
                                                        $checar3="";
                                                    break;
                                                    case 3:
                                                        if($fila[4]!="")
                                                        {
                                                            $leyenda="Quincena inicio: ".$fila[4]." (Ciclo: ".$fila[6]."), + ".($fila[5]-1)." quincenas <a href=\"javascript:configurarQuincenasAplicacion('".$fila[0]."')\"><img src='../images/pencil.png' alt='Configurar quincena aplicación' title='Configurar quincena aplicación'></a>";
                                                        }
                                                        $checar3='checked="checked"';
                                                        $checar2="";
                                                        $checar1="";
                                                    break;	
                                                }
                                            ?>
                                            <input type="radio" id='chk_1_<?php echo $fila[0]?>' name="aplicacion_<?php echo $fila[0]?>" onclick="actualizarAfectacionNomina(this)" <?php echo $checar1?> />&nbsp;<span class="letraExt">Permanente</span><br />
                                            <input type="radio" id='chk_2_<?php echo $fila[0]?>' name="aplicacion_<?php echo $fila[0]?>" onclick="actualizarAfectacionNomina(this)" <?php echo $checar2?>/>&nbsp;<span class="letraExt">No afectar (Deshabilitar)</span><br />
                                            <input type="radio" id='chk_3_<?php echo $fila[0]?>' name="aplicacion_<?php echo $fila[0]?>" onclick="actualizarAfectacionNomina(this)" <?php echo $checar3?>/>&nbsp;<span class="letraExt">Aplicar a quincenas</span><br />
                                        
                                    </td>
                                    <td align="left" class='<?php echo $clase?>'>
                                    <span class="letraExt">
                                    <?php
										echo $leyenda;
									?>	
                                    </span>
                                    </td >  
                                    <td class='<?php echo $clase?>'>
                                    <table width="100%">
                                        <tr>
                                            <td align="right" >
                                                <a href="javascript:mostrarVentanaCuenta('<?php echo bE($fila[0])?>')"><img src="../images/add.png" alt="Agregar afectación de cuenta" title="Agregar afectación de cuenta" /></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <table >		
                                                <?php
                                                    $consulta="select * from 661_afectacionesCuentasDeducPercepciones where idDeduccionPercepcion=".$fila[0]." and tipo=".$tipoConsulta;
                                                    $resCtas=$con->obtenerFilas($consulta);
                                                    if($con->filasAfectadas>0)
                                                        echo "	<tr>
																	<td class='fondoVerde7' align='center' width='350'><span style='color:#000'>Estructura</span></td>
																	<td class='fondoVerde7' align='center' width='150'><span style='color:#000'>Cuenta</span></td>
																	<td class='fondoVerde7' align='center' width='120'><span style='color:#000'>Tipo afectación</span></td>
																	<td class='fondoVerde7' align='center' width='120'><span style='color:#000'>% afectación</span></td>
																	<td class='fondoVerde7' align='center' width='300'><span style='color:#000'>Beneficiario</span></td>
																	<td class='fondoVerde7' align='center' width='250'><span style='color:#000'>Tipo de presupuesto</span></td>
																	<td></td>
																</tr>";
                                                    while($fCta=mysql_fetch_row($resCtas))
                                                    {
                                                        if($fCta[6]==1)
                                                            $afectacion="Debe";
                                                        else
                                                            $afectacion="Haber";
                                                        $consulta="select tituloCta,codigoUnidadCta from 510_cuentas where codigoCta='".$fCta[3]."'";
														$fEstructura=$con->obtenerPrimeraFila($consulta);
                                                        
                                                ?>	
                                                    <tr id='fila_<?php echo ($fila[0])."_".($fCta[0])?>'>
                                                        <td class="fondoGrid7" align="left"><span style="color:#000"><?php echo $fEstructura[0]?></span></td>
                                                        <td class="fondoGrid7" align="left"><span style="color:#000"><?php echo $fEstructura[1]?></span></td>
                                                        <td class="fondoGrid7" align="left"><span id='afectacionTipoCta_<?php echo $fCta[0]?>' style="color:#000"><?php echo $afectacion?></span>&nbsp;<a href="javascript:modificarTipoAfectacion('<?php echo bE($fCta[0])?>')"><img src="../images/pencil.png" alt='Modificar tipo de afectación' title='Modificar tipo de afectación' /></a></td>
                                                        <td class="fondoGrid7" align="left"><span id='afectacionCta_<?php echo $fCta[0]?>' style="color:#000"><?php echo $fCta[5]?> %</span>&nbsp;<a href="javascript:modficarPorcentaje('<?php echo bE($fCta[0])?>')"><img src="../images/pencil.png" alt='Modificar porcentaje de afectación' title='Modificar porcentaje de afectación' /></a></td>
                                                        <td align="left" class='fondoGrid7'>
                                                        <span class="letraExt" id='lblBeneficiario_<?php echo $fCta[0]?>' style="color:#000">
                                                            <?php
                                                                if($fCta[8]!="")
                                                                {
																	if($fCta[8]==0)
																	{
																		echo "Empleado en cuestión";	
																	}
																	else
																	{
																		$consulta="";
																		if($fCta[9]=="1")
																			$consulta="select txtBeneficiario from _217_tablaDinamica  where id__217_tablaDinamica=".$fCta[8];
																		else
																			$consulta="select txtBeneficiario from _216_tablaDinamica  where id__216_tablaDinamica=".$fCta[8];
																		echo $con->obtenerValor($consulta);
																	}
                                                                }
                                                            ?>
                                                            </span>&nbsp;<a href="javascript:modificarBeneficiario('<?php echo bE($fCta[0])?>')"><img src='../images/pencil.png' title="Modificar beneficiario" alt="Modificar beneficiario" /></a>
                                                            
                                                            
                                                        </td>
                                                        <td align="center" class='fondoGrid7'>
                                                        <select id="cmbTipoPresupuesto_<?php echo $fCta[0]?>" onchange="modificarTipoRecurso(this)">
                                                        <option value="-1">Seleccione</option>
                                                        <?php
															$con->generarOpcionesSelectArregloAsoc($arrTipoPresupuesto,$fCta[10]);
														?>
                                                        </select>
                                                        </td>
                                                        <td><a href="javascript:eliminarCuenta('<?php echo bE($fCta[0]) ?>','<?php echo bE($fila[0])?>')"><img src="../images/delete.png" title="Remover configuración de cuenta" alt="Remover configuración de cuenta" /></a></td>
                                                    </tr>
                                                <?php	
                                                    
                                                	}
                                                ?>
                                                </table>
                                            </td>
                                    	</tr>
                                    </table>
                                                            
                                    </td>
                                    
                                </tr>
                                <?php
									if($clase=="filaBlanca10")
										$clase="filaRosa10";
									else
										$clase="filaBlanca10";
									
								}
										
										}
									?>
                                </table>
                                </td>
                              </tr>
                        	</table>
                            
                            <input type="hidden" id="idPerfil" value="<?php echo $idPerfil?>" />
                            <input type="hidden" id='tipoConcepto' value="<?php echo bE($tipoConsulta)?>" />
                            <form method="post" action="../nomina/<?php echo $nomPagina?>.php" id='frmActualizar'>
                            	<input type="hidden" name="idUsuario" value="<?php echo bE($idUsuario)?>" />
                                <input type="hidden" name="idPerfil" value="<?php echo $idPerfil?>" />
                                <?php 
                                  if(isset($objParametros->cPagina))
                                  {		
                                  ?>
                                  <input type="hidden" name="cPagina" value="sFrm=true" id="cPagina" />
                                  <?php
                                  }
                                ?>
                          	</form>
                            <input type="hidden" name="idUsuario" value="<?php echo ($idUsuario)?>" id="idUsuario" />
                            <input type="hidden" id="arrAcumuladores" value="<?php echo $arrAcumuladores?>" />

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
