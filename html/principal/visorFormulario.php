<?php session_start();
	
if(isset($_SESSION["idUsr"]))
{
	if($_SESSION["idUsr"]=="-1")
	{
		$_SESSION["idUsr"]="1";
		$_SESSION["login"]="";
		$_SESSION["idRol"]="'-1000_0'";
		$_SESSION["codigoUnidad"]="0001";
		$_SESSION["codigoInstitucion"]="0001";
	}
}
else
{
	$_SESSION["idUsr"]="1";
	$_SESSION["login"]="";
	$_SESSION["idRol"]="'-1000_0'";
	$_SESSION["codigoUnidad"]="0001";
	$_SESSION["codigoInstitucion"]="0001";
}
include("conexionBD.php"); 
include("funcionesPortal.php");?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="../Scripts/jquery.min.js"></script>
<link rel="stylesheet" href="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.css"  type="text/css" media="screen" />
<script type="text/javascript" src="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ext/resources/css/ext-all.css.cgz"/>
<script type="text/javascript" src="../Scripts/ext/adapter/ext/ext-base.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/ext-all.js.jgz"></script>
<script type="text/javascript" src="../Scripts/funcionesAjax.js.jgz"></script>
<link rel="stylesheet" type="text/css" href="../estilos/layout-browser.css"/>
<script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<link rel="stylesheet" type="text/css" href="../css/hayas.css.php" media="screen" />
<link rel="stylesheet" type="text/css" href="../estilos/estilos.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../css/estiloFinal.css" media="screen" />
<script type="text/javascript" src="../Scripts/miFrame/multidom.js.jgz"></script>
<script type="text/javascript" src="../Scripts/miFrame/mif.js.jgz"></script>
<script type="text/javascript" src="../principal/Scripts/visorFormulario.js.php"></script>

<script>
	function regresarPagina()
	{
		gE('frmRegresar').submit();
	}
	
	function recargarPagina()
	{
		gE('frmRefrescarPagina').submit();
	}
</script>	
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
$pagRegresar="../principal/inicio.php";
$paramGET=true;
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
  <title></title>
  <script type="text/javascript" src="../Scripts/base64.js"></script>

  <script type="text/javascript" src="../Scripts/ext/idioma/ext-lang-es.js"></script>
	
</head>
<body>
	
	<?php
		$soloFormulario=0;
		if(isset($objParametros->sF))
			$soloFormulario=bD($objParametros->sF);
		$idFormulario=-1;
		if(isset($objParametros->iF))
			$idFormulario=bD($objParametros->iF);
		$idRegistro=-1;
		if(isset($objParametros->iR))
			$idRegistro=($objParametros->iR);
		$idReferencia=-1;
		if(isset($objParametros->idRef))
			$idReferencia=($objParametros->idRef);
		
		$refUnica=-1;
		if(isset($objParametros->refU))
			$refUnica=bD($objParametros->refU);
			
		$eJ="";
		if(isset($objParametros->eJ))
			$eJ=$objParametros->eJ;
		$mostrarCerrar=0;
		if(isset($objParametros->mC))
			$mostrarCerrar=bD($objParametros->mC);
		if($idRegistro==-1)
		{
			if(($idReferencia!=-1)&&($refUnica==1)&&($idFormulario!=-1))
			{
				$consulta="SELECT id__".$idFormulario."_tablaDinamica FROM _".$idFormulario."_tablaDinamica WHERE idReferencia=".$idReferencia;
				$idRegistro=$con->obtenerValor($consulta);
				if($idRegistro=="")
					$idRegistro=-1;
			}
		}
	?>
    <input type="hidden" id="mostrarCerrar" value="<?php echo $mostrarCerrar?>" />
    <input type="hidden" id="idFormulario" value="<?php echo $idFormulario?>" />
    <input type="hidden" id="idRegistro" value="<?php echo $idRegistro?>" />
    <input type="hidden" id="idReferencia" value="<?php echo $idReferencia?>" />
    <input type="hidden" id="refUnica" value="<?php echo $refUnica?>" />
    <input type="hidden" id="eJ" value="<?php echo $eJ?>" />
    <input type="hidden" id="soloFormulario" value="<?php echo $soloFormulario?>" />
    
    
    
    
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
