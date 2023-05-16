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
	$guardarConfSession=true;
	$_POST["cPagina"]="sFrm=true";
	$arrPOST=array_values($_POST);
	$ctPOST=sizeof($arrPOST);

?>
<script type="text/javascript" src="../Scripts/jquery.min.js"></script>
<link rel="stylesheet" href="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.css"  type="text/css" media="screen" />
<script type="text/javascript" src="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../Scripts/ux/grid/rowExpander.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ux/grid/GridFilters.css"/>
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
<script type="text/javascript" src="../Scripts/dataConceptosAPI.js.php"></script>

<script type="application/javascript" src="../Scripts/funcionesValidacion.js"></script>
<script type="application/javascript" src="../gestorDocumental/Scripts/frmTipoMetaDato.js.php"></script>
<style>
	.sticky {
    position: fixed;
    top: 5px;
    width: 97%;
    background-color: #F5F5F5;
    z-index: 10000;
    text-align: center;
	}
	
	
	body
	{
		min-height:600px;
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
							
							
							$idMetaDato=-1;
							if(isset($objParametros->idMetaDato))	
								$idMetaDato=$objParametros->idMetaDato;
							$consulta="SELECT * FROM 20003_catalogoMetaDatos WHERE idMetaDato=".$idMetaDato;
							$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
							
							$estiloLetraFormulario="SIUGJ_Etiqueta";
							$estiloLetraControles="SIUGJ_Control";
							$TSJDF_Titulo="tituloSIUGJ";
							
							
							?>
                        
                        	<form id="frmEnvio" method="post" action="../paginasFunciones/guardarDatos.php">
                            	<br />
                                	
                                <br /><br /><br />
                                <table width="950" border="0">
                                    <tr>
                                        <td align="left" colspan="3">
                                            <span class="tituloSIUGJ">Tipo de metadato (Catálogo)</span><br /><br /><br />
                                        </td>
                                    </tr>
                                    <tr height="30">
                                        <td width="450">
                                            <span class="<?php echo $estiloLetraFormulario?>">
                                            	Cve. tipo de metadato <span style="color:#F00"></span>
                                            </span>
                                        </td>
                                        <td width="50">
                                        </td>
                                        <td width="450">
                                            <span class="<?php echo $estiloLetraFormulario?>">
                                                T&iacute;tulo metadato <span style="color:#F00">*</span>
                                            </span>
                                        
                                        </td>
                                    </tr>
                                    <tr height="60">
                                        <td>
                                            <input type="text" value="<?php echo $fRegistro["cveMetaDato"]?>" size="10" class="<?php echo $estiloLetraControles?>" val="" id="_cveMetaDatovch" name="_cveMetaDatovch" />
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                    		<input type="text" value="<?php echo $fRegistro["nombreMetaDato"]?>" size="42" class="<?php echo $estiloLetraControles?>" val="obl" campo="Título MetaDato" id="_nombreMetaDatovch" name="_nombreMetaDatovch" />
                                        </td>
                                    </tr>
                                    <tr height="30">
                                        <td >
                                            <span class="<?php echo $estiloLetraFormulario?>">
                                                Tag metadato (XML) <span style="color:#F00">*</span>
                                            </span>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                        	<span class="<?php echo $estiloLetraFormulario?>">
                                        	Descripci&oacute;n
                                            </span>
                                        </td>
                                    </tr>
                                    <tr height="100">
                                        <td valign="top" >
	                                        <input type="text" value="<?php echo $fRegistro["tagMeta"]?>" size="42" class="<?php echo $estiloLetraControles?>" val="obl" campo="Tag MetaDato (XML)" id="_tagMetavch" name="_tagMetavch" />
                                        </td>
                                        <td>
                                        </td>
                                        <td valign="top" >
                                        	<textarea style="width:480px; height:80px !important" class="<?php echo $estiloLetraControles?>"  id="_descripcionvch" name="_descripcionvch"><?php echo $fRegistro["descripcion"]?></textarea>
                                        </td>
                                        
                                    </tr>
                                    
                                    <tr height="30">
                                        <td  valign="top">
                                            <span class="<?php echo $estiloLetraFormulario?>">
                                               M&eacute;todo de resoluci&oacute;n
                                            </span>
                                        </td>
                                        <td >
                                        </td>
                                        	
                                        <td valign="top">
                                        	<span id="lblLeyenda_0" class="<?php echo $estiloLetraFormulario?>" style="display:<?php echo $fRegistro["metodoResolucion"]!=0?"none":"" ?>">
                                               Tipo de dato de entrada
                                            </span>
                                            <span id="lblLeyenda_2" class="<?php echo $estiloLetraFormulario?>" style="display:<?php echo $fRegistro["metodoResolucion"]!=2?"none":"" ?>">
                                               Fuente de datos
                                            </span>
                                            
                                        </td>
                                    </tr>
                                    <tr height="60">
                                        <td>
                                            <select id='_metodoResolucionint' name="_metodoResolucionint" val='obl' campo='M&eacute;todo de Resoluci&oacute;n' style="width:300px" class="<?php echo $estiloLetraControles?>" onchange="metodoSeleccionChange(this)">
                                                    <option value="-1">Seleccione</option>
                                                    <?php
                                                        $arrOpcion=array();
                                                        $arrOpcion[0][0]="0";
                                                        $arrOpcion[0][1]="Campo Abierto";
                                                        $arrOpcion[1][0]="1";
                                                        $arrOpcion[1][1]="Mediante Funci&oacute;n de Sistema";
                                                        $arrOpcion[2][0]="2";
                                                        $arrOpcion[2][1]="Opciones Cerradas (Combo)";
                                                        
                                                        $con->generarOpcionesSelectArreglo($arrOpcion,$fRegistro["metodoResolucion"]);
                                                    ?>
                                            </select>
                                        </td>
                                        <td >
                                        </td>
                                        <td>
                                        	<span id="spTipoEntrada_0" style="display:<?php echo $fRegistro["metodoResolucion"]!=0?"none":"" ?>">
                                        	<select id='_tipoDatoEntradaint' name="_tipoDatoEntradaint" val='' campo='Tipo de Dato de Entrada' style="width:400px" class="<?php echo $estiloLetraControles?>">
                                                <option value="-1">Seleccione</option>
                                                    <?php
                                                        $arrOpcion=array();
                                                        $arrOpcion[0][0]="6";
                                                        $arrOpcion[0][1]="Texto Corto";
                                                        $arrOpcion[1][0]="1";
                                                        $arrOpcion[1][1]="Texto Largo";
                                                        $arrOpcion[2][0]="2";
                                                        $arrOpcion[2][1]="Entero";
                                                        $arrOpcion[3][0]="3";
                                                        $arrOpcion[3][1]="Decimal";
                                                        $arrOpcion[4][0]="4";
                                                        $arrOpcion[4][1]="Moneda";
                                                        $arrOpcion[4][0]="5";
                                                        $arrOpcion[4][1]="Fecha";
                                                        
                                                        $con->generarOpcionesSelectArreglo($arrOpcion,$fRegistro["tipoDatoEntrada"]);
                                                    ?>
                                            </select>
                                            </span>
                                            <span id="spTipoEntrada_2" style="display:<?php echo $fRegistro["metodoResolucion"]!=2?"none":"" ?>">
                                            <select id='_fuenteDatosint' name="_fuenteDatosint" val='' campo='Fuente de Datos' style="width:400px" class="<?php echo $estiloLetraControles?>" onchange="fuenteDatosChange(this)">
                                                    <option value="-1">Seleccione</option>
                                                    <?php
                                                        $arrOpcion=array();
                                                        $arrOpcion[0][0]="0";
                                                        $arrOpcion[0][1]="Funci&oacute;n de Sistema";
                                                        $arrOpcion[1][0]="1";
                                                        $arrOpcion[1][1]="Opciones Manuales";
                                                        $con->generarOpcionesSelectArreglo($arrOpcion,$fRegistro["fuenteDatos"]);
                                                    ?>
                                            </select>
                                            </span>
                                            
                                        </td>
                                    </tr>
                                    <tr height="30">
                                        <td >
                                            <span id="lblLeyenda_1" class="<?php echo $estiloLetraFormulario?>" style="display:<?php echo $fRegistro["metodoResolucion"]!=1?"none":"" ?>">
                                               Funci&oacute;n de sistema
                                            </span>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                        	
                                        </td>
                                    </tr>
                                    <tr height="60" id="fila_3" style="display:<?php echo $fRegistro["metodoResolucion"]!=1?"none":"" ?>">
                                        <td valign="top" >
	                                        <span id="spTipoEntrada_1" >
                                            <?php
												$lblFuncion="";
												if($fRegistro["funcionSistema"]!="")
												{
													$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$fRegistro["funcionSistema"];
													$lblFuncion=$con->obtenerValor($consulta);
												}
											?>
                                            <input type="text" value="<?php echo $lblFuncion ?>" style="width:360px" id="txtFuncionSistema" readonly="readonly" class="<?php echo $estiloLetraControles?>"/>&nbsp;&nbsp;
                                            <a href="javascript:abrirVentanaFuncion()"><img src="../images/pencil.png" /></a>&nbsp;&nbsp;&nbsp;<a href="javascript:removerFuncion()"><img src="../images/cross.png" /></a>
                                            <input type="hidden" name="_funcionSistemavch" id="_funcionSistemavch" value="<?php echo $fRegistro["funcionSistema"]?>" val="" />
                                            </span>
                                        </td>
                                        <td>
                                        </td>
                                        <td valign="top" >
                                        	
                                        </td>
                                        
                                    </tr>
                                    
                                
                                    <tr height="60" id="fila_4" style="display:<?php echo $fRegistro["fuenteDatos"]!=1?"none":"" ?>">
                                        <td   valign="top" >
                                            <span class="<?php echo $estiloLetraFormulario?>">
                                                Ingrese las opciones a presentar
                                            </span>
                                        </td>
                                        <td  colspan="2">
                                            <span id="lblOpciones"></span>
                                        </td>
                                    </tr>
                                
                                    <tr height="30">
                                        <td  >
                                            <span class="<?php echo $estiloLetraFormulario?>">
                                                Situaci&oacute;n
                                            </span>
                                        </td>
                                        <td >
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr height="60">
                                        <td  >
                                            <select id='_situacionActualint' name="_situacionActualint" val='obl' campo='Situaci&oacute;n' style="width:200px" class="<?php echo $estiloLetraControles?>">
                                                    <?php
                                                        $arrOpcion[0][0]="1";
                                                        $arrOpcion[0][1]="Activo";
                                                        $arrOpcion[1][0]="0";
                                                        $arrOpcion[1][1]="Inactivo";
                                                        $con->generarOpcionesSelectArreglo($arrOpcion,$fRegistro["situacionActual"]);
                                                    ?>
                                            </select>
                                        </td>
                                        <td >
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    
                                </table><br /><br />
                                <table width="100%">
                                    <tr>
                                        <td>
                                             <div class=""  >
                                                  <table width="100%">
                                                      <tr>
                                                          <td align="center">
                                                              <table >
                                                                  <tr>
                                                                      <td><span id="contenedor2"></span></td>
                                                                      <td width="15">
                                                                      </td>
                                                                      <td><span id="contenedor1"></span></td>
                                                                  </tr>
                                                              </table>
                                                          </td>
                                                      </tr>
                                                  </table>
                                            </div>
                                        </td>
                                	</tr>
                                </table>
                                
								<?php
									$consulta="SELECT valor,etiqueta FROM 20004_opcionesMetaDatos WHERE idMetaDatos=".$idMetaDato." ORDER BY idOpcionMetaDatos";
									$arrOpciones=$con->obtenerFilasArreglo($consulta);
									
								?>
                            	
                            	 <input type="hidden" name="tabla" value="20003_catalogoMetaDatos" />
                                  <input type="hidden" name="id" id="id" value="<?php echo $idMetaDato?>" />
                                  <input type="hidden" name="campoId" value="idMetaDato" />
                                  <input type="hidden" name="arrOpciones" id="arrOpciones" value="<?php echo bE($arrOpciones)?>" />
                                  <input type="hidden" name="pagRedireccion" value="../gestorDocumental/tblMetaDatos.php"/>	
                                  
                                  <?php
								  if($idMetaDato==-1)
								  {
									 ?>
                                      <input type="hidden" name="funcPHPEjecutarNuevo" id="funcPHPEjecutarNuevo" value=""/>	
                                     <?php
								  }
								  else
								  {
									  ?>
                                       <input type="hidden" name="funcPHPEjecutarModif" id="funcPHPEjecutarModif" value=""/>	
                                      <?php
								  }
									?>
                                   
                                     
                                 
                                  
                                  
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
