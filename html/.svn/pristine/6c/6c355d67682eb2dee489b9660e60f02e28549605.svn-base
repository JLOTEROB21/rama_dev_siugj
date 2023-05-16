<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../Scripts/ext/ux/file-upload.css" />
<link rel="stylesheet" type="text/css" href="../css/hayas.css.php" media="screen" />
<link rel="stylesheet" type="text/css" href="../estilos/estilos.css" media="screen" />
<script type="text/javascript" src="../Scripts/base64.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ext/resources/css/ext-all.css.cgz"/>
<script type="text/javascript" src="../Scripts/ext/adapter/ext/ext-base.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/ext-all.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/idioma/ext-lang-es.js"></script>
<script type="text/javascript" src="../Scripts/funcionesAjax.js.jgz"></script>
<link rel="stylesheet" type="text/css" href="../estilos/layout-browser.css"/>
<script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>
<script type="text/javascript" src="../Scripts/miFrame/multidom.js.jgz"></script>
<script type="text/javascript" src="../Scripts/miFrame/mif.js.jgz"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ux/colorField/ext.ux.ColorField.css" />
<script type="text/javascript" src="../Scripts/ux/colorField/ext.ux.ColorField.js"></script>

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
<script type="text/javascript" src="../Scripts/ext/ux/FileUploadField.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ux/css/columnNodeUI.css" />
<link rel="stylesheet" type="text/css" href="../Scripts/ux/css/column-tree.css" />
<script type="text/javascript" src="../Scripts/ux/columnNodeUI.js"></script>
<script type="text/javascript" src="../Scripts/ux/checkColumn.js"></script>
<script type="text/javascript" src="../Scripts/jquery.min.js"></script>
<script type="text/javascript" src="../Scripts/ux/grid/rowExpander.js"></script>
<link rel="stylesheet" href="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.css"  type="text/css" media="screen" />
<script type="text/javascript" src="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="../Scripts/dataConceptosAPI.js.php"></script>


<style>
<?php
	generarFuentesLetras();
?>
</style>
<script language="javascript">
	function enviar(lenguaje)
	{
		gE('leng').value=lenguaje;
		gE('formLenguaje').submit();
	}
	
	function regresarPagina()
	{
		gE('frmRegresar').submit();
	}
	
	function recargarPagina()
	{
		gE('frmRefrescarPagina').submit();
	}
	
</script>
<link rel="stylesheet" href="../principalPortal/css/controlesFrameWork.css"  type="text/css" media="screen" />
<link rel="stylesheet" href="../principalPortal/css/estiloSIUGJ.css"  type="text/css" media="screen" />

<?php
$paramPOST=true;
$paramGET=true;
$arrPOST=array_values($_POST);
$ctPOST=sizeof($arrPOST);
$arrGET=array_values($_GET);
$ctGET=sizeof($arrGET);
$arrValores=null;
$arrLlaves=null;
$sqlmax = "SELECT disenoBanner,textoInfIzq,textInfDerecho,tituloPagina FROM 4081_colorEstilo";
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
$guardarConfSession=true;

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
$idFormulario="-1";
if(isset($objParametros->idFormulario))
	$idFormulario=$objParametros->idFormulario;
echo generarCabeceraControlesFormulario($idFormulario);


$vistaIframe=0;

if(isset($objParametros->vistaIframe))
	$vistaIframe=$objParametros->vistaIframe;

?>
<script type="text/javascript" src="Scripts/thotConfigurarFormulario.js.php"></script>
<script type="text/javascript" src="Scripts/gridPropiedades.js.php?idFormulario=<?php echo bE($idFormulario)?>"></script>
<script type="text/javascript" src="../Scripts/dataSetAPI.js.php"></script>
<title><?php echo $tituloPagina ?></title>
</head>
<body>
<div id="header">
</div>
<?php 
?>


	<?php
		$idUsuario=$_SESSION["idUsr"];
		$nUsuario=obtenerNombreUsuario($idUsuario);
		
		$consulta="select anchoGrid,altoGrid from 900_formularios where idFormulario=".$idFormulario;
		$filaGrid=$con->obtenerPrimeraFila($consulta);
		$idProceso=obtenerIdProcesoFormulario($idFormulario);
		
	?>
    <input type="hidden" id="vistaIframe" value="<?php echo $vistaIframe?>" />
    <input type="hidden" id="nUsuario" value="<?php echo $nUsuario?>" />
    <input type="hidden" id="pagRegresar" value="<?php echo $pagRegresar?>" />
    <input type="hidden" name="ancho" id="ancho" value="<?php echo $filaGrid[0]?>" />
    <input type="hidden" name="alto" id="alto" value="<?php echo $filaGrid[1]?>" />
    <input type="hidden" name="idFormulario" value="<?php echo $idFormulario?>" id="idFormulario">
    <input type="hidden" name="hLeng" id="hLeng" value="<?php echo $_SESSION["leng"] ?>" />
    <input type="hidden" name="idProceso" id="idProceso" value="<?php echo $idProceso ?>" />
    <form method="post"	action="" id='frmEnvioDatos'>
    	<input type="hidden" name="confReferencia" value="<?php echo $nConfiguracion ?>" />
    </form>
    <form method="post"	action="<?php echo $pConfRegresar?>" id='frmRegresar'>
        <input type="hidden" name="configuracion" value="<?php echo $nConfRegresar ?>" />
    </form>
    <form method="post"	action="<?php echo "../".$rutaNomPagina ?>" id='frmRefrescarPagina'>
        <input type="hidden" name="configuracion" value="<?php echo $nConfiguracion ?>" />
    </form>
</body>

</html>