<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="../Scripts/thickbox/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ext/resources/css/ext-all.css.cgz"/>
<script type="text/javascript" src="../Scripts/ext/adapter/ext/ext-base.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/ext-all.js.jgz"></script>
<script type="text/javascript" src="../Scripts/funcionesAjax.js.jgz"></script>
<link rel="stylesheet" type="text/css" href="../estilos/layout-browser.css"/>
<script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>
<script type="text/javascript" src="../Scripts/miFrame/multidom.js.jgz"></script>
<script type="text/javascript" src="../Scripts/miFrame/mif.js.jgz"></script>
<script type="text/javascript" src="../Scripts/funcionesProcesos.js.php"></script>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<link rel="stylesheet" href="../Scripts/thickbox/thickboxExt.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/hayas.css.php" media="screen" />
<link rel="stylesheet" type="text/css" href="../estilos/estilos.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../css/estiloFinal.css" media="screen" />
<script type="text/javascript" src="../Scripts/thickbox/thickbox.js"></script>
<script type="text/javascript" src="../Scripts/funcionesProcesos.js.php"></script>

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
$paramGET=false;
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
<title><?php echo $tituloPagina ?></title>
<?php 
	$idUsuario=$_SESSION["idUsr"];
	if(isset($objParametros->idUsuario))
		$idUsuario=$objParametros->idUsuario;
	
	$idFormulario="-1";
	if(isset($objParametros->idFormulario))
		$idFormulario=$objParametros->idFormulario;
	$idRegistro="-1";
	if(isset($objParametros->idRegistro))
		$idRegistro=$objParametros->idRegistro;
	$actor="0";
	if(isset($objParametros->actor))
		$actor=$objParametros->actor;
	$idProceso="-1";
	if(isset($objParametros->idProceso))
		$idProceso=$objParametros->idProceso;
	 $idFormularioDictamen=-1; 
	 $consulta="select af.idFormulario from 948_actoresVSFormulariosDictamen af,900_formularios f where f.idFormulario=af.idFormulario and f.tipoFormulario=15 and af.idActor=".(bD($actor)*-1);
	 $idFormularioDictamen=$con->obtenerValor($consulta);
  ?>
<script type="text/javascript" src="Scripts/vistaRevisor.js.php?iP=<?php echo bE($idProceso)?>&iU=<?php echo bE($idUsuario)?>"></script>
</head>

<body>

	<div id="header">
    	
    </div>
    
    <span id="tblOpciones" class="x-hide-display"><br />
        <table width="100%">
            
            <tr height='25'>
            	<td width="20"></td>
                <td colspan='3' align='left'>
                    <img src='../images/magnifier.png'>
                    <a title='Ver documento' href='javascript:verDocumento()'><span class='letraFicha'>Ver documento</span></a>
                </td>
                <tr height='25'>
                <td></td>
                <td colspan='3' align='left'>
                    <img src='../images/pencil.png'>
                    <a title='Realizar dictamen' href='javascript:realizarDictamenRevisor("<?php echo ($idFormularioDictamen)?>","<?php echo bE($idRegistro)?>")'><span class='letraFicha'>Realizar dictamen</span></a>
                </td>
            </tr>
            </tr>
        </table>
    </span>
    <input type="hidden" id="pagRegresar" value="<?php echo $pagRegresar ?>" />
	<input type="hidden" id="idFormulario"  value="<?php echo $idFormulario?>" />
    <input type="hidden" id="idRegistro" value="<?php echo $idRegistro?>" />
    <input type="hidden" id="idProceso" value="<?php echo $idProceso?>" />
    <input type="hidden" id="actor" value="<?php echo $actor?>" />
    <input type="hidden" id="idUsuario" value="<?php echo $idUsuario?>" />
        
   
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