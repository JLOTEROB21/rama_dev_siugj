<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"><html xmlns="http://www.w3.org/1999/xhtml" dir="ltr"><!-- InstanceBegin template="/Templates/Lhayas_B.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
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
	$paramGET=true;
	$guardarConfSession=true;
?>
<script type="text/javascript" src="../Scripts/jquery.min.js"></script>
<link rel="stylesheet" href="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.css"  type="text/css" media="screen" />
<script type="text/javascript" src="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

<link rel="stylesheet" type="text/css" href="../estilos/layout-browser.css"/>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<link rel="stylesheet" type="text/css" href="../css/estiloFinal.css" media="screen" />
<script type="text/javascript" src="../Scripts/funcionesProcesos.js.php"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ux/grid/GroupSummary.css" media="screen" />
<script type="text/javascript" src="../Scripts/ux/grid/HybritGroupSummary.js"></script>
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
<link rel="stylesheet" type="text/css" href="../Scripts/ux/checkBoxComboBox/CheckboxComboBox.css" media="screen" />
<script type="text/javascript" src="../Scripts/ux/checkBoxComboBox/CheckboxComboBox.js"></script>

<?php
	$consulta="SELECT DISTINCT archivoJS FROM 9033_funcionesScriptsSistema WHERE idCategoria=1";
	$resScript=$con->obtenerFilas($consulta);
	while($fScript=mysql_fetch_row($resScript))
	{
		echo '<script type="text/javascript" src="'.$fScript[0].'"></script>';
	}
?>

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
	$idFormulario=-1;
	if(isset($objParametros->idFormulario))
		$idFormulario=$objParametros->idFormulario;
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
		<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr"><!-- InstanceBegin template="/Templates/Lhayas_B.dwt.php" codeOutsideHTMLIsLocked="false" -->
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
	$paramGET=true;
	$guardarConfSession=true;
?>
<script type="text/javascript" src="../Scripts/jquery.min.js"></script>
<link rel="stylesheet" href="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.css"  type="text/css" media="screen" />
<script type="text/javascript" src="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

<link rel="stylesheet" type="text/css" href="../estilos/layout-browser.css"/>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<link rel="stylesheet" type="text/css" href="../css/estiloFinal.css" media="screen" />
<script type="text/javascript" src="../Scripts/funcionesProcesos.js.php"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ux/grid/GroupSummary.css" media="screen" />
<script type="text/javascript" src="../Scripts/ux/grid/HybritGroupSummary.js"></script>
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
<link rel="stylesheet" type="text/css" href="../Scripts/ux/checkBoxComboBox/CheckboxComboBox.css" media="screen" />
<script type="text/javascript" src="../Scripts/ux/checkBoxComboBox/CheckboxComboBox.js"></script>

<?php
	$consulta="SELECT DISTINCT archivoJS FROM 9033_funcionesScriptsSistema WHERE idCategoria=1";
	$resScript=$con->obtenerFilas($consulta);
	while($fScript=mysql_fetch_row($resScript))
	{
		echo '<script type="text/javascript" src="'.$fScript[0].'"></script>';
	}
?>

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
	$idFormulario=-1;
	if(isset($objParametros->idFormulario))
		$idFormulario=$objParametros->idFormulario;
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
                        <td align="left">
                        <?php
							
							 $iM="-1";
							  if(isset($objParametros->iM))
								  $iM=$objParametros->iM;
								  
							$idEstado="-1";
							if(isset($objParametros->idEstado))	
								$idEstado=$objParametros->idEstado;
							
							$idUsuario=$_SESSION["idUsr"];
							if(isset($objParametros->idUsuario))
								$idUsuario=$objParametros->idUsuario;
							
							$ciclo="-1";
							if(isset($objParametros->ciclo))
							  $ciclo=$objParametros->ciclo;
							
							$idReferencia="-1";
							if(isset($objParametros->idReferencia))
							  $idReferencia=$objParametros->idReferencia;
							
							$idFormulario="-1";
							if(isset($objParametros->idFormulario))
							  $idFormulario=$objParametros->idFormulario;
							
							$seccionProceso=0;
							if(isset($objParametros->seccionProceso))
								$seccionProceso=$objParametros->seccionProceso;
							
							
							$idProceso="-1";
							if(isset($objParametros->idProceso)&&($objParametros->idProceso!=-1))
								$idProceso=$objParametros->idProceso;
							else
							{
								
								$idProceso=obtenerIdProcesoFormulario($idFormulario);
								if($idProceso=="")
									$idProceso=-1;
								
							}
							
							
							$objConfAux="";
							if(isset($objParametros->objConfAux))
								$objConfAux=$objParametros->objConfAux;
							
							
							$funcPHPEjecutarNuevo="";
							if(isset($objParametros->funcPHPEjecutarNuevo))
								$funcPHPEjecutarNuevo=$objParametros->funcPHPEjecutarNuevo;
							$funcPHPEjecutarModif="";
							if(isset($objParametros->funcPHPEjecutarModif))
								$funcPHPEjecutarModif=$objParametros->funcPHPEjecutarModif;
							
							
							$consulta="SELECT nombre,idTipoProceso FROM 4001_procesos WHERE idProceso=".$idProceso;
							$fConfiguracionProceso=$con->obtenerPrimeraFila($consulta);
							
							$tituloModulo=$fConfiguracionProceso[0];
							$tipoProceso=$fConfiguracionProceso[1];
						
							$tipoSeccionProceso=0;
							if(isset($objParametros->tipoSeccionProceso))
								$tipoSeccionProceso=$objParametros->tipoSeccionProceso;
						
							if(($tipoProceso!=1)&&($tipoSeccionProceso==0))
								$idFormulario=obtenerFormularioBase($idProceso);
							else
							{
								$consulta="SELECT nombreFormulario FROM 900_formularios WHERE idFormulario=".$idFormulario;
								$tituloModulo=$con->obtenerValor($consulta);				
							}
							
							$idProcesoPadre="-1";
							if(isset($objParametros->idProcesoPadre))
								  $idProcesoPadre=$objParametros->idProcesoPadre;
						
							$actor="-1";
							
							if(isset($objParametros->actor))
								$actor=$objParametros->actor;
							
							$sL=0;
							if(isset($objParametros->sL))
								$sL=$objParametros->sL;			
								
							$consulta="select incluirPaginasScrips from 909_configuracionTablaFormularios f where f.idFormulario=".$idFormulario;
							$paginasScripts=$con->obtenerValor($consulta);
							if($paginasScripts!="")
							{
								$arrPaginas=explode(",",$paginasScripts);
								foreach($arrPaginas as $p)
								{
									echo '<script type="text/javascript" src="'.$p.'"></script>';
								}
							}
							$tipoVista=2;
							if(isset($objParametros->tipoVista))
								$tipoVista=$objParametros->tipoVista;
								
								
								
							
								
							$_SESSION["configuracionesPag"][$nConfiguracion]["tituloModulo"]=$tituloModulo;
							echo formatearTituloPagina($tituloModulo);
							
								  
						?>
						
						<script type="text/javascript" src="../modeloProyectos/Scripts/visorRegistroProcesos.js.php?l=<?php echo bE($sL)?>&tS=<?php echo $tipoSeccionProceso?>&iR=<?php echo bE($idReferencia)?>&iF=<?php echo bE($idFormulario)?>&idUsuario=<?php echo bE($idUsuario)?>&actor=<?php echo bE($actor)?>"></script>
                        	
                        
                        
                        <table width="100%">
                        <tr>
                            <td align="center">
                                <table>
                                <tr>
                                    <td align="left">
                                        <div id='tblListado'></div>
                                    </td>
                                </tr>
                                </table>
                                
                            </td>
                        </tr>
                        </table>
                        <input type="hidden" id="pagRegresar" value="<?php echo $pagRegresar ?>"  />
                        <input type="hidden" value="<?php echo $idEstado?>" id="idEstado" />
                        
                        <input type="hidden" id="ciclo" value="<?php echo $ciclo?>" />
                        <input type="hidden" id="idReferencia" value="<?php echo $idReferencia?>" />
                        <input type="hidden" id="idFormulario" value="<?php echo $idFormulario?>" />
                        <input type="hidden" id="idProceso" value="<?php echo $idProceso?>" />
                        <input type="hidden" id="idProcesoPadre" value="<?php echo $idProcesoPadre?>" />
                        <input type="hidden" id="idUsuario" value="<?php echo $idUsuario?>" />
                        <input type="hidden" id="actor" value="<?php echo $actor?>" />
                        <input type="hidden" id="sL" value="<?php echo $sL?>" />
                        <input type="hidden" id="tipoVista" value="<?php echo $tipoVista?>" />
                        <input type="hidden" id="objConfAux" value="<?php echo $objConfAux?>" />
                    	<input type="hidden" id="tipoSeccionProceso" value="<?php echo $tipoSeccionProceso?>" />
                        <input type="hidden" id="soloContenido" name="soloContenido" value="<?php echo ($soloContenido?'1':'0')?>" />
                        
                    
                      <?php
						  if(isset($objParametros->eJs))
						  {
					  ?>
						  <input type="hidden" id="eJs" value="<?php echo ($objParametros->eJs)?>" />
					  <?php
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
