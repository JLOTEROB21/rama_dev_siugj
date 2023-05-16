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
<link rel="stylesheet" type="text/css" href="../Scripts/ux/css/columnNodeUI.css" />
<link rel="stylesheet" type="text/css" href="../Scripts/ux/css/column-tree.css" />
<script type="text/javascript" src="../Scripts/ux/columnNodeUI.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ux/grid/RowEditor.css"/>
<script type="text/javascript" src="../Scripts/ux/grid/RowEditor.js"></script>
<script type="text/javascript" src="../nomina/Scripts/confAdscripcion.js.php"></script>

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
                        	<span class="tituloPaginas">Configuración de adscripción</span><br /><br /><br /><br /><br />
                        	<table width="">
                            <tr>
                            	<td align="left">
                                
                                	<span id='tblAdscripcionTab'></span>
                                	<span id="tblAdscripcion">
									<?php
                                        $idUsuario="-1";
                                        if(isset($objParametros->idUsuario))
                                            $idUsuario=bD($objParametros->idUsuario);
                                        $consulta="select cod_Puesto,idCuentaDeposito,codigoUnidad,tipoContratacion,horasTrabajador,idTipoJornada,idTipoContrato from 801_adscripcion where idUsuario=".$idUsuario;

										$filasAds=$con->obtenerPrimeraFila($consulta);
                                        $idTabulacion=$filasAds[0];
										$tJornada="No especificado";
										$tContrato="No especificado";
										
										if(($filasAds[5]!="")&&($filasAds[5]!="0"))
										{
											$consulta="SELECT tipoJornada FROM 689_tipoJornadas WHERE idTipoJornada=".$filasAds[5];
											$tJornada=$con->obtenerValor($consulta);
										
										}
										
										if(($filasAds[6]!="")&&($filasAds[6]!="0"))
										{
											$consulta="SELECT tipoContrato FROM 686_tiposContrato WHERE idTipoContrato=".$filasAds[6];

											$tContrato=$con->obtenerValor($consulta);
										}
										
										
										$idCuentaDepo=$filasAds[1];
										$codDepto=$filasAds[2];
                                        $fila=array();
										$idFum="";
										$consulta="select Institucion,codigoUnidad from 801_adscripcion where idUsuario=".$idUsuario;
										$filaAds=$con->obtenerPrimeraFila($consulta);

										
										$consulta="select unidad from 817_organigrama where codigoUnidad='".$filaAds[1]."'";
										$nDepartamento=$con->obtenerValor($consulta);
                                        if($idTabulacion!="")
                                        {
											/*$consulta="SELECT DISTINCT p.puesto,tp.tipoPuesto,z.NombreZona,p.cvePuesto,p.sueldoMinimo,p.sueldoMaximo,p.idPuesto,p.horasPuesto FROM 
														819_puestosOrganigrama p,650_zonas z,653_unidadesOrgVSPuestos uo,801_tiposPuesto tp 
														WHERE tp.idTipoPuesto=p.tipoPuesto AND   z.id_650_zonas=p.zona AND 
														p.cvePuesto='".$idTabulacion."'";*/
											
											$consulta="SELECT DISTINCT p.puesto,(select tipoPuesto from 801_tiposPuesto where idTipoPuesto=p.tipoPuesto) as tipoPuesto,
											z.NombreZona,p.cvePuesto,p.sueldoMinimo,p.sueldoMaximo,p.idPuesto,p.horasPuesto FROM 
														819_puestosOrganigrama p,650_zonas z,653_unidadesOrgVSPuestos uo 
														WHERE   z.id_650_zonas=p.zona AND 
														p.idPuesto='".$idTabulacion."'";	
			
                                            $filaPuesto=$con->obtenerPrimeraFila($consulta);
                                           /* $consulta="select pQuincenaPago,pCicloPago,salario,fechaAplicacion,idFump,tipoContratacion,horasTrabajador from 801_fumpEmpleado where idUsuario=".$idUsuario." 
														 and (tipoOperacion=1 or tipoOperacion=0) and activo=1  order by idFump desc";

                                            $filaTab=$con->obtenerPrimeraFila($consulta);*/
                                            //$idFum=$filaTab[4];
											if($filaPuesto[1]=="")
												$filaPuesto[1]="No aplica";
											$consulta="select unidad from 817_organigrama where codigoUnidad='".$codDepto."'";
											$depto=$con->obtenerValor($consulta);
											$horasTrabajador=$filasAds[4];
											$tipoContrata=$filasAds[3];
											if($tipoContrata=="")
												$tipoContrata=-1;
											$consulta="select concat('[',cveTipoContratacion,'] ',tipoContratacion) from 690_tiposContratacionEmpresa WHERE idTipoContratacion=".$tipoContrata;

											$tContratacion=$con->obtenerValor($consulta);
											
                                    ?>
                                			<br /><br />
                                			<table id='tblPuestoAdscripcion'>
                                            <tr>
                                                <td width="20">
                                                </td>
                                                <td>
                                               		<table>
                                                    <tr height="21">
                                                        <td  width='195'>
                                                            <span class="corpo8_bold">
                                                            Clave del puesto:
                                                            </span>
                                                        </td>
                                                        <td>	
                                                            <span class="copyrigthSinPadding">
                                                            <?php echo $filaPuesto[3]?>
                                                            </span>
                                                        </td>
                                                   </tr>
                                                    <tr height="21">
                                                        <td  >
                                                            <span class="corpo8_bold">
                                                            Puesto:
                                                            </span>
                                                        </td>
                                                        <td>	
                                                            <span class="copyrigthSinPadding">
                                                            <?php echo $filaPuesto[0]?>
                                                            </span>
                                                        </td>
                                                   </tr>
                                                   <tr height="21">
                                                        <td>
                                                            <span class="corpo8_bold">
                                                            Tipo de puesto:
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="copyrigthSinPadding">
                                                            <?php echo $filaPuesto[1]?>
                                                            </span>
                                                        </td>
                                                   </tr>
                                                    <tr height="21">
                                                        <td>
                                                            <span class="corpo8_bold">
                                                            Horas contratación:
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="copyrigthSinPadding">
                                                            <?php echo $horasTrabajador?>
                                                            </span>
                                                        </td>
                                                   </tr>
                                                   <tr height="21">
                                                        <td>
                                                            <span class="corpo8_bold">
                                                            Tipo contratación:
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="copyrigthSinPadding">
                                                            <?php echo $tContratacion?>
                                                            </span>
                                                        </td>
                                                   </tr>
                                                   <tr height="21">
                                                        <td>
                                                            <span class="corpo8_bold">
                                                            Tipo de jornada:
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="copyrigthSinPadding">
                                                            <?php echo $tJornada?>
                                                            </span>
                                                        </td>
                                                   </tr>
                                                   <tr height="21">
                                                        <td>
                                                            <span class="corpo8_bold">
                                                            Tipo de contrato:
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="copyrigthSinPadding">
                                                            <?php echo $tContrato?>
                                                            </span>
                                                        </td>
                                                   </tr>
                                                   <tr height="21">
                                                        <td>
                                                            <span class="corpo8_bold">
                                                            Zona:
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="copyrigthSinPadding">
                                                            <?php echo $filaPuesto[2]?>
                                                            </span>
                                                        </td>
                                                        
                                                   </tr>
                                                   <tr height="21">
                                                        <td>
                                                            <span class="corpo8_bold">
                                                            Departamento:
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="copyrigthSinPadding">
                                                            <?php echo $depto?>
                                                            </span>
                                                        </td>
                                                   </tr>
                                                   <tr height="21">
                                                        <td>
                                                            <span class="corpo8_bold">
                                                            Sueldo base:
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="copyrigthSinPadding">
                                                            $ <?php echo number_format(0,2,".",",")?>
                                                            </span>
                                                        </td>
                                                   </tr>
                                                   <tr height="21">
                                                        <td>
                                                            <span class="corpo8_bold">
                                                            Fecha de aplicación:
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="copyrigthSinPadding">No especificado
                                                            <?php //echo date("d/m/Y",strtotime($filaTab[3]))?>
                                                            </span>
                                                        </td>
                                                   </tr>
                                                   <tr height="21">
                                                        <td>
                                                            <span class="corpo8_bold">
                                                            Primera quincena de pago:
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="copyrigthSinPadding">No especificado
                                                            <?php //echo $filaTab[0]." (Ciclo: ".$filaTab[1].")"?>
                                                            </span>
                                                        </td>
                                                   </tr>
                                                   <tr height="21">
                                                        <td>
                                                            <span class="corpo8_bold">
                                                            Cuenta de pago de nómina:
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <select id='cmbCuentaPago' onchange="cuentaPagoChange(this)">
                                                            	<option value="-1">Sin cuenta seleccionada</option>
                                                                <?php
																	$consulta="select idCuentaUsuario,concat(cuenta,' (Titular:',titular,', ',nombreCorto,')') as datos from 823_cuentasUsuario cu,6000_bancos b  
																	where b.idBanco=cu.idBanco and cu.idUsuario=".$idUsuario." order by cuenta";
																	$con->generarOpcionesSelect($consulta,$idCuentaDepo);
																?>
                                                            </select>
                                                        </td>
                                                   </tr>
                                                </table>
                                                </td>
                                            </tr>
                                            </table>
                                    <?php
                                        }
                                        else
                                        {
									?>
                                    	<br />
                                        <br />
                                    	<table width="100%">
                                        	<tr>
                                            	<td align="center">
                                            	<span class="corpo8_bold">El usuario aún no cuenta con un puesto asignado</span>
                                                </td>
                                            </tr>
                                            
                                        </table>
                                    <?php
									
                                        }
                                    ?>
                                    </span>
                        		</td>
                            </tr>
                            </table>
                            <form method="post" action="../nomina/confAdscripcion.php" id='frmActualizar'>
                              <input type="hidden" name="idUsuario" value="<?php echo bE($idUsuario)?>" />
                              <input type="hidden" name="cPagina" value="sFrm=true" id="cPagina" />
                          </form>
                          <input type="hidden" name="idUsuario" value="<?php echo ($idUsuario)?>" id="idUsuario" />
                          <input type="hidden" name="idFum" value="<?php echo ($idFum)?>" id="idFum" />
                          <input type="hidden" id="viejoSueldo" value="<?php echo $filaTab[2]?>" />
                          <input type="hidden" id="sueldoMin" value="<?php echo number_format($filaPuesto[4],2,".",",")?>" />
                          <input type="hidden" id="sueldoMax" value="<?php echo number_format($filaPuesto[5],2,".",",")?>" />
                          <input type="hidden" id="tipoContratacion" value="<?php echo $filasAds[3]  ?>" />
                          <input type="hidden" id="horasTrabajador" value="<?php echo $filasAds[4] ?>" />
                          <input type="hidden" id="horasPuesto" value="<?php echo $filaPuesto[7]?>" />
                          <input type="hidden" id="departamento" value="<?php echo $filaAds[1]?>" />
                          <input type="hidden" id="institucion" value="<?php echo $filaAds[0]?>" />
                          <input type="hidden" id="nDepartamento" value="<?php echo $nDepartamento?>" />
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
