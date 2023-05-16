<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/hayas.css.php" media="screen" />
<link rel="stylesheet" type="text/css" href="../estilos/estilos.css" media="screen" />
<script type="text/javascript" src="../Scripts/thickbox/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ext/resources/css/ext-all.css.cgz"/>
<script type="text/javascript" src="../Scripts/ext/adapter/ext/ext-base.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/ext-all.js.jgz"></script>
<script type="text/javascript" src="../Scripts/funcionesAjax.js.jgz"></script>
<link rel="stylesheet" type="text/css" href="../estilos/layout-browser.css"/>
<script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<!--Agenda-->

<script type="text/javascript" src="../Scripts/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/Carousel/thickbox.css"/>
<script type="text/javascript" src="../Scripts/Carousel/thickbox.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ext/agenda/calendar.css" />
<link rel="stylesheet" href="../Scripts/ext/agenda/estilosAuxiliares.css" type="text/css" />
<script type="text/javascript" src="../Scripts/ext/agenda/Ext.calendar.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/DayHeaderTemplate.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/DayBodyTemplate.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/DayViewTemplate.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/BoxLayoutTemplate.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/MonthViewTemplate.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/CalendarScrollManager.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/StatusProxy.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/CalendarDD.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/DayViewDD.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/EventRecord.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/MonthDayDetailView.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/CalendarPicker.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/WeekEventRenderer.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/CalendarView.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/MonthView.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/DayHeaderView.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/DayBodyView.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/DayView.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/WeekView.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/DateRangeField.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/ReminderField.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/EventEditForm.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/EventEditWindow.js"></script>
<script type="text/javascript" src="../Scripts/ext/agenda/CalendarPanel.js"></script>
<!-- -->
<script src="../Scripts/ext/idioma/ext-lang-es.js"></script>
<script type="text/javascript" src="../almacen/Scripts/agendaEntregas.js.php"></script>
<style>
<?php
	$consulta="select idTipoEventos,color from 4089_tiposEvento";
	$resColor=$con->obtenerFilas($consulta);
	while($filaColor=mysql_fetch_row($resColor))
	{
		echo "
				.ext-color-".$filaColor[0].", .ext-ie .ext-color-".$filaColor[0]."-ad, .ext-opera .ext-color-".$filaColor[0]."-ad 
				{
					color: #".$filaColor[1].";
				}
				.ext-cal-day-col .ext-color-".$filaColor[0].", .ext-dd-drag-proxy .ext-color-".$filaColor[0].",	.ext-color-".$filaColor[0]."-ad,
				.ext-color-".$filaColor[0]."-ad .ext-cal-evm, .ext-color-".$filaColor[0]." .ext-cal-picker-icon, .ext-color-".$filaColor[0]."-x dl,
				.ext-color-".$filaColor[0]."-x .ext-cal-evb 
				{
					background: #".$filaColor[1].";
				}
				.ext-color-".$filaColor[0]."-x .ext-cal-evb, .ext-color-".$filaColor[0]."-x dl 
				{
					border-color: #8C500B;
				}
	
			";
	}
?>
</style>
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
</head>
<?php 
		$sL=0;
		if(isset($objParametros->sL))
			$sL=$objParametros->sL;
	  $idUsuario=$_SESSION["idUsr"];
	  if(isset($objParametros->idUsuario))
		  $idUsuario=$objParametros->idUsuario;
		$fechaInicial="";
		if(isset($objParametros->fechaInicial))
			$fechaInicial=$objParametros->fechaInicial;
		
		$idAlmacen="-1";
		if(isset($objParametros->idAlmacen))
			$idAlmacen=$objParametros->idAlmacen;
	 
?>
<body>
	<div style="display:none;"> 
    <div id="app-header-content"> 
        <div id="app-logo"> 
            <div class="logo-top">&nbsp;</div> 
            <div id="logo-body">&nbsp;</div> 
            <div class="logo-bottom">&nbsp;</div> 
        </div> 
        <h1>Ext JS Calendar</h1> 
        <span id="app-msg" class="x-hidden"></span> 
    </div> 
    </div>
	<input type="hidden" id="idAlmacen" value="<?php echo $idAlmacen?>" />
    <input type="hidden" id="idUsuario" value="<?php echo $idUsuario?>" />
    <input type="hidden" id="nUsuario" value="<?php echo obtenerNombreUsuario($idUsuario)?>" />
    <input type="hidden" id="arrUsuarios" value="" />
    <input type="hidden" id="fechaInicial" value="<?php echo $fechaInicial?>" />
    <input type="hidden" id="sL" value="<?php echo $sL?>" />
    
</body>
<script> 
    var updateLogoDt = function()
	{
        document.getElementById('logo-body').innerHTML = new Date().getDate();
    }
    updateLogoDt();
    setInterval(updateLogoDt, 1000);
</script>
</html>