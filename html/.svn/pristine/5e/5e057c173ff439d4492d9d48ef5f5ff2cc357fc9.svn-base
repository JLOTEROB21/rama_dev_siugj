<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");


$idFormulario=obtenerValorParametro("idFormulario");
if($idFormulario=="")
	$idFormulario="-1";
$consulta="select frmRepetible,nombreTabla,idProceso,complementario,titulo from 900_formularios where idFormulario=".$idFormulario;
$filaResp=$con->obtenerPrimeraFila($consulta);
$repetible=$filaResp[0];
$nTabla=$filaResp[1];
$tipoProceso=-1;
if($filaResp)
	$tipoProceso=obtenerTipoProceso($filaResp[2]);
$idUsuario=$_SESSION["idUsr"];
if(obtenerValorParametro("idUsuario")!="")
	$idUsuario=obtenerValorParametro("idUsuario");



if($repetible=="0")
{
	$idReferencia=obtenerValorParametro("idReferencia");
	if($idReferencia=="")
		$idReferencia=-1;
	$idReg="";
	

	/*Filtro Registro
	0 Ver todos;
	1 Registrado por susuario
	2 Registrado por referencia
	3 Registrado por institucion
	4 Registrado por departamento
	*/
	if($tipoProceso!=1000)
	{	
	
		$consulta="SELECT configuracionFormulario FROM 900_formularios WHERE idFormulario=".$idFormulario;
		$configuracionFormulario=$con->obtenerValor($consulta);
		if($configuracionFormulario=="")
		{
			if($idReferencia=="-1")	
				$consulta="select id_".$nTabla." from ".$nTabla." where responsable=".$idUsuario;
			else
				$consulta="select id_".$nTabla." from ".$nTabla." where idReferencia=".$idReferencia;
		}
		else
		{
			$objConf=json_decode($configuracionFormulario);	
			if(isset($objConf->filtroRegistro))
			{
				switch($objConf->filtroRegistro)	
				{
					case 0:
						$consulta="select id_".$nTabla." from ".$nTabla;
					break;
					case 1:
						$consulta="select id_".$nTabla." from ".$nTabla." where responsable=".$idUsuario;
					break;
					case 2:
						$consulta="select id_".$nTabla." from ".$nTabla." where idReferencia=".$idReferencia;
					break;
					case 3:
						$consulta="select id_".$nTabla." from ".$nTabla." where codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
					break;
					case 4:
						$consulta="select id_".$nTabla." from ".$nTabla." where codigoUnidad='".$_SESSION["codigoUnidad"]."'";
					break;	
				}
			}
			else
			{
				if($idReferencia=="-1")	
					$consulta="select id_".$nTabla." from ".$nTabla." where responsable=".$idUsuario;
				else
					$consulta="select id_".$nTabla." from ".$nTabla." where idReferencia=".$idReferencia;
			}
		}
			
		$idReg=$con->obtenerValor($consulta);
	}
	else
	{
		$paginaEnvioDatos=$filaResp[3];
		if($paginaEnvioDatos=="")
			$paginaEnvioDatos="../paginaFunciones/guardarDatos.php";
	}
	
	$idProceso=$filaResp[2];
	
	$pagNuevo="../modeloPerfiles/registroFormulario.php";
	$pagModificar="../modeloPerfiles/registroFormulario.php";
	$pagVer="../modeloPerfiles/verFichaFormulario.php";
	
	$query="select pagVista,accion from 936_vistasProcesos where tipoProceso=".$tipoProceso;
	$resPagAccion=$con->obtenerFilas($query);
	while($filaAccion=mysql_fetch_row($resPagAccion))
	{
		switch($filaAccion[1])
		{
			case "0"://Nuevo
				$pagNuevo=$filaAccion[0];
			break;
			case "1"://Modificar
				$pagModificar=$filaAccion[0];
			break;
			case "2"://Consultar/Ver
				$pagVer=$filaAccion[0];
			break;
			
		}
	}
	//$idReg="";
	if($idReg=="")
	{
		$idReg="-1";
		$pagDestino=$pagNuevo;
		
	}
	else
		$pagDestino=$pagVer;
?>
	<html>
    	<title></title>
        <body>
        
        <form method="post" action="<?php echo $pagDestino?>" id="frmEnvio">
        	<input type="hidden" name="idRegistro" value="<?php echo $idReg?>" />
            <input type="hidden" name="idFormulario" value="<?php echo $idFormulario ?>" />
            <input type="hidden" name="idReferencia" value="<?php echo $idReferencia?>" />
            <input type="hidden" name="formularioNormal" value="1" />
		<?php
			if(isset($_POST["cPagina"]))
			{
		?>
				 <input type="hidden" name="cPagina" value="<?php echo $_POST["cPagina"] ?>" />
		<?php                 
			}
		
			if(isset($_POST["confReferencia"]))
			{
				$confReferencia=$_POST["confReferencia"];
				$parametros=$_SESSION["configuracionesPag"][$confReferencia]["parametros"];			
				$objParametros=json_decode($parametros);
		?>
        	<input type="hidden" name="confReferencia" value="<?php echo $confReferencia?>" />
            <input type="hidden" name="paginaRedireccion" value="<?php echo $objParametros->paginaConf?>" />
        <?php
			}
			else
			{
		?>
        		<input type="hidden" name="paginaRedireccion" value="../principal/inicio.php" />
        <?php
			}
			if($tipoProceso==1000)
			{
		?>
        		<input type="hidden" name="paginaEnvioDatos" value="<?php echo $paginaEnvioDatos?>" />
        <?php
			}
		?>
        </form>
        <script>
			document.getElementById('frmEnvio').submit();
		</script>
    	</body>
    </html>
	
<?php	
	return;
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
	$paramGET=true;
	$guardarConfSession=true;
	$tituloModulo=$filaResp[4]. " [<span style='color:#000'>Listado</span>]";

?>
<style>
	.wrapper
	{
		width:100% !important;
	}
	.p15
	{
		padding: 0px !important;
	}


	

	#main_single
	{
		background:#FFFFFF !important;
	}
</style>	
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
<script type="text/javascript" src="../Scripts/base64.js"></script>
<link rel="stylesheet" type="text/css"  href="../Scripts/ux/resources/style.css" media="screen" />
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
<?php
	$guardarConfSession=true;
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
                        <td align="center" >
                        <?php
						
						echo formatearTituloPagina($tituloModulo);
						$frmEntidad="-1";
						$idReferencia="-1";
						$idEstado="-1";
						$idFormulario="-1";
						$accion="";
						$regresarTablero="-1";
						if(isset($objParametros->regresarTablero))
							$regresarTablero=$objParametros->regresarTablero;

						if(isset($objParametros->idFormulario))
							$idFormulario=$objParametros->idFormulario;
						
						if(isset($objParametros->idReferencia))
							$idReferencia=$objParametros->idReferencia;
						if(isset($objParametros->edo))
							$idEstado=$objParametros->edo;
						
						if(isset($objParametros->accion))
							$accion=$objParametros->accion;
						if(isset($objParametros->idUsuario))
							$idReferencia=$objParametros->idUsuario;
						
						$paginaDestino="../modeloPerfiles/registroFormulario.php";
						$consulta="select ct.idConfGrid from 909_configuracionTablaFormularios ct where ct.idFormulario=".$idFormulario;
						$idConfiguracion=$con->obtenerValor($consulta);
						if((!isset($pagRegresar))||($pagRegresar=="javascript:history.back(1)"))
							$pagRegresar="../principal/inicio.php";
						
						$consulta="select idEtapa,idProceso from 900_formularios where idFormulario=".$idFormulario;
						$filaResp=$con->obtenerPrimeraFila($consulta);
						$idProceso=$filaResp[1];
						$idEtapa=$filaResp[0];
						
						$consulta="select tp.ignoraPermisos from 4001_procesos p,921_tiposProceso tp where tp.idTipoProceso=p.idTipoProceso and p.idProceso=".$idProceso;
						$ignoraPermisos=$con->obtenerValor($consulta);
						$nPermisos=$ignoraPermisos;
						if($ignoraPermisos=="0")
						{
							$consulta="select permisos from 4002_rolesVSEtapas where etapa=".$idEtapa." and proceso=".$idProceso." and idRol in(".$_SESSION["idRol"].")";
							$res=$con->obtenerFilas($consulta);
							$nPermisos=$con->filasAfectadas;
						}
					?>
                      <script type="text/javascript" src="../modeloPerfiles/Scripts/tblFormularios.js.php?idFormulario=<?php echo $idFormulario ?>&idReferencia=<?php echo $idReferencia ?>&idEstado=<?php echo $idEstado ?>" ></script>
                        	<?php
								
								$ct=1;
								$tablaFormulario="";
								$idRegistro="-1";
								if(isset($objParametros->idRegistro))
									$idRegistro=$objParametros->idRegistro;
								$eJs="";
								
								if(isset($objParametros->eJs))
									$eJs="var funcAgregar=	function()
															{
																".base64_decode($objParametros->eJs).";
															}";
														
								if($nPermisos==0)
								{	
								?>
                                			<fieldset class="frameHijo"><legend><b>SIN PRIVILEGIOS</b></legend>
                                			<table width="100%">
                                            	<tr>
                                                	<td width="145">
                                                    	<img src="../images/prohibido.png" />
                                                    </td>
                                                	<td><span class="letraRoja"><font style="font-size:13px">Usted no cuenta con los permisos suficientes para ingresar a esta página.</font></span><span class="corpo8"><br />
                                               	    <br />
                                                    </span>
                                                        <span class="letraFicha"><font style="font-size:12px"><b>
                                                        En breve será redireccionado a la página anterior...</b>
                                                        </font>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </fieldset>
                                        <script>
											setTimeout("history.back(1)",3000);
										</script>
                        	
								<?php
								}
								$consulta="select nombreTabla,idFrmEntidad,frmRepetible,titulo from 900_formularios where idFormulario=".$idFormulario;
								$fila=$con->obtenerPrimeraFila($consulta);
								$tablaFormulario=$fila[0];
								$frmEntidad=$fila[1];
								$repetible=$fila[2];
								$funcionJava="";
								$idPadre="-1";
										if(isset($objParametros->idPadre))
											$idPadre=$objParametros->idPadre;
								$lblEtapa="";
								if($idEstado!="-1")
								{
									$consulta="select idProceso from 900_formularios where idFormulario=".$idFormulario;
									$idProceso=$con->obtenerValor($consulta);
									$consulta="select nombreEtapa from 4037_etapas where idProceso=".$idProceso." and numEtapa=".$idEstado;
									$lblNomEtapa=$con->obtenerValor($consulta);
									$lblEtapa="<br><br>(<font color='blue'><b>".$et["lblEtapa"].":</font> <font color='gray'>".$lblNomEtapa."</font></b>)";
								}
								
								if(($fila)&&($nPermisos!=0))
								{
									//if($repetible!=0)
									if(false)
									{
										echo "	
												<table width='100%'>
												<tr>
													<td >
														<table width='100%'>
														<tr>
														<td align='center' class='tituloPaginas'><b>
														
													".$fila[3]."</b>".$lblEtapa." 
													
														</td>
														</tr>
														</table>
													</td>
												</tr>
												<tr>
													<td colspan='".(mysql_num_rows($res)+1)."' align='right'>
														<br>
														<br>
													</td>
												</tr>
												</table>";
										
									}
									
								}
								
							?>
                            <input type="hidden" name="nombreTabla" id="nombreTabla" value="<?php echo $tablaFormulario ?>" />
                            <form method="post" action="registroFormulario.php" id="frmEnvio">
                            	<input type="hidden" name="idFormulario" id="idFormulario" value="<?php echo $idFormulario?>" />
                                <input type="hidden" name="idPadre" id="idPadre" value="<?php echo $idPadre?>" />
                                <input type="hidden" name="idRegistro" id="idRegistro" value="<?php echo $idRegistro ?>" />
                                <input type="hidden" name="idReferencia" id="idReferencia" value="<?php echo $idReferencia ?>" />
                                <input type="hidden" name="confReferencia" id="confReferencia" value="<?php echo $nConfiguracion ?>" />
                                
                                <?php 
									if($frmEntidad!='-1')
										echo '<input type="hidden" name="idReferencia" id="idReferencia" value="'.$idReferencia.'"/>';
								?>
                            </form>
                            <input type="hidden" id="regresarTablero" value="<?php echo $regresarTablero?>" />
                            <input type="hidden" id="soloContenido" name="soloContenido" value="<?php echo $soloContenido?>" />
                            <input type="hidden" id="accion" value="<?php echo ($accion)?>" />
                            <?php
								if(isset($objParametros->eJs))
								{
							?>
                            	<input type="hidden" id="eJs" value="<?php echo ($objParametros->eJs)?>" />
							<?php
								}
								
							?>
                            
                            <br />
                            <script>
								<?php 
									echo $eJs;
									echo $funcionJava;
								?>
							</script>
                            <table>
                            <tr>
                            <td align="left">
                            <?php
							if($nPermisos!=0)
							{
							?>
                            <span id='tdTblRegistro'>
                            	
                                	
                                    <div id='tblRegistros'>
                                    </div>
                                
                            </span>
                            <?php
							}
							?>
							</td>
                            </tr>
                            </table>
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
