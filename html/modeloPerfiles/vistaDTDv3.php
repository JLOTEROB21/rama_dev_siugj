<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");
$arrConfiguraciones="";
$actorEtapa1="";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/hayas.css.php" media="screen" />
<link rel="stylesheet" type="text/css" href="../estilos/estilos.css" media="screen" />
<script type="text/javascript" src="../Scripts/jquery.min.js"></script>
<link rel="stylesheet" href="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.css"  type="text/css" media="screen" />
<script type="text/javascript" src="../Scripts/fancyBox/fancybox/jquery.fancybox.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ext/resources/css/ext-all.css.cgz"/>
<script type="text/javascript" src="../Scripts/ext/adapter/ext/ext-base.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/ext-all.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/idioma/ext-lang-es.js"></script>

<script type="text/javascript" src="../Scripts/funcionesAjax.js.jgz"></script>
<link rel="stylesheet" type="text/css" href="../estilos/layout-browser.css"/>
<script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../Scripts/ux/grid/rowExpander.js"></script>
<script type="text/javascript" src="../Scripts/ventanaMensajeErrores.js.php"></script>
<script type="text/javascript" src="../Scripts/libreriaVisoresDocumentos.js.php"></script>
<link rel="stylesheet" type="text/css" href="../estilos/dataView.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../Scripts/ux/treeGrid/treegrid.css"/>
<script type="text/javascript" src="../Scripts/ux/treeGrid/TreeGridSorter.js"></script>
<script type="text/javascript" src="../Scripts/ux/treeGrid/TreeGridColumnResizer.js"></script>
<script type="text/javascript" src="../Scripts/ux/treeGrid/TreeGridNodeUI.js"></script>
<script type="text/javascript" src="../Scripts/ux/treeGrid/TreeGridLoader.js"></script>
<script type="text/javascript" src="../Scripts/ux/treeGrid/TreeGridColumns.js"></script>
<script type="text/javascript" src="../Scripts/ux/treeGrid/TreeGrid.js"></script>

<link rel="stylesheet" type="text/css" href="../Scripts/prefixFree/style.css">
<link type="text/css" rel="stylesheet" href="../Scripts/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css" media="screen" />
<script type="text/javascript" src="../Scripts/plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="../Scripts/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<script type="text/javascript" src="../Scripts/plupload/js/i18n/es.js"></script>

<style type="text/css">
<!--
@import url("../css/estiloFinal.css");


-->

/*
.x-grid3-cell-inner 
{
	height:auto !important;
}

.fondoSeccion
{
	background-color:#CFCFCF;
	border-bottom-style:dotted;
	border-bottom-width:1px;
	border-bottom-color:#FFF;
		
}
.fondoOpcion
{
	background-color:#F5F5F5;
	border-bottom-style:dotted;
	border-bottom-width:1px;
	border-bottom-color:#BBB;
	height:20px;
		
}

.btnEditar
{
	width:20px;
	height:20px;
	background:url(../images/pencil.png) no-repeat;
	background-color:#F5F5F5;
	border:none;
}

.wrap
{
	width:100% !important;
	padding:0px !important;
}

.menu li 
{
	border-right-color: #dfe8f6;
    border-right-style:none
    border-right-width: 1px;
	width:auto !important;

}

.opcionSeleccionada
{
	
	background-color:#003761; 	
	border-radius: 0px;
	box-shadow: inset 0px 0px 1px 1px rgba(0,0,0,0.1);
	color: #ccc !important;
	font-family:Lato_Bold;
	font-size:12px;
}

.wrapDTD
{
    width: 100% !important;
    padding: 0px !important;
	border: 1px solid #d1d1d1;
}

nav
{
	background-color:#dfe8f6; 
	
    position: relative;
}


#tPanelCentral .x-tab-panel-header
{
	display:none;
}*/
</style>
<link rel="stylesheet" type="text/css" href="../principalPortal/css/controlesFrameWork.css"/>
<link rel="stylesheet" type="text/css" href="../principalPortal/css/estiloSIUGJ.css"/>
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






<link rel="stylesheet" type="text/css" href="../Scripts/prefixFree/style.css">
<link rel="stylesheet" type="text/css" href="../Scripts/prefixFree/iconic.css">
<script type="text/javascript" src="../Scripts/prefixFree/prefix-free.js"></script>

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




if(isset($objParametros->titulo))
	$tituloPagina=$objParametros->titulo;



	$idFormulario=-1;
	if(isset($objParametros->idFormulario))
		$idFormulario=$objParametros->idFormulario;
			
			
	$idRegistro=-1;
	if(isset($objParametros->idRegistro))
		$idRegistro=$objParametros->idRegistro;
	
	
	$consulta="select idProceso from 900_formularios  where idFormulario=".$idFormulario;
	$idProceso=$con->obtenerValor($consulta);
	$consulta="SELECT * FROM 9057_configuracionSeccionesProceso WHERE idProceso=".$idProceso;
	$resSecc=$con->obtenerFilas($consulta);
	while($fSecc=mysql_fetch_row($resSecc))
	{
		if($fSecc[2]!="")
			echo '<script type="text/javascript" src="'.$fSecc[2].'?iR='.$idRegistro.'"></script>';
	}


	if($con->existeCampo("archivosJS","4001_procesos"))
	{
		$consulta="SELECT archivosJS FROM 4001_procesos WHERE idProceso=".$idProceso;

		$archivosJS=$con->obtenerValor($consulta);

		if($archivosJS!="")
		{
			$aArchivos=explode(",",$archivosJS);

			foreach($aArchivos as $a)
			{
				echo '<script type="text/javascript" src="'.$a.'?iF='.$idFormulario.'&iR='.$idRegistro.'"></script>';
			}
			
		}
	}


?>
<title><?php echo $tituloPagina ?></title>
<style>
<?php
	generarFuentesLetras();
?>

</style>
</head>
<body>

<?php 
	  $idUsuario=$_SESSION["idUsr"];
	  if(isset($objParametros->idUsuario))
		  $idUsuario=$objParametros->idUsuario;
	  $nProfesor=obtenerNombreUsuario($idUsuario);
	  
	  if(!isset($objParametros->idFormulario))
	  {
   		  enviarPagina("../principal/inicio.php");
		  return;
	  }
	  $actor=0;
	  

	  if(isset($objParametros->actor))
	  {
		  
			$actor=base64_decode($objParametros->actor);
			if($actor=="")	  
				$actor=0;
		 
		  
	  }
	  $accion="";
	  if(isset($objParametros->dComp))
			$accion=base64_decode($objParametros->dComp);
	 
	  $dComp=$objParametros->dComp;
	  $idFormulario=$objParametros->idFormulario;
	  $idRegistro=$objParametros->idRegistro;
	  $idProceso=obtenerIdProcesoFormulario($idFormulario);

	  $consulta="select version,date_format(fechaRegistro,'%d/%m/%Y') as fechaRegistro,version,u.Nombre from 9036_respaldosProceso r,800_usuarios u where u.idUsuario=r.idUsuarioResp and idProceso=".$idProceso." and idRegistro=".$idRegistro;
	  $arrVersiones=$con->obtenerFilasArreglo($consulta);
	  
	  $participante="0";
	  if(isset($objParametros->participante))
	  	$participante=$objParametros->participante;
	  
	  
	  
	  	$idProcesoP="";
	  	if(isset($objParametros->idProcesoP))
	  		$idProcesoP=$objParametros->idProcesoP;
	  	$idReferencia="";
		if(isset($objParametros->idReferencia))
	  		$idReferencia=$objParametros->idReferencia;
	  
		  $funcEjecutarNuevo="";
		  if(isset($objParametros->funcEjecutarNuevo))
			$funcEjecutarNuevo=$objParametros->funcEjecutarNuevo;
		  $funcEjecutarModif="";
		  if(isset($objParametros->funcEjecutarModif))
			$funcEjecutarNuevo=$objParametros->funcEjecutarModif;
			
			
		  $funcPHPEjecutarNuevo="";
		  if(isset($objParametros->funcPHPEjecutarNuevo))
			$funcPHPEjecutarNuevo=$objParametros->funcPHPEjecutarNuevo;
		  
		  $funcPHPEjecutarModif="";
		  if(isset($objParametros->funcPHPEjecutarModif))
			$funcPHPEjecutarModif=$objParametros->funcPHPEjecutarModif;
	  
	  	$funcEJs="";
	  	if(isset($objParametros->funcEJs))
			$funcEJs=$objParametros->funcEJs;
	  
	  if($idRegistro=="-1")
	  {
		  $idProceso=obtenerIdProcesoFormulario($idFormulario);	

		  if(!isset($objParametros->actorInicio))
		  {
			  
		  	$consulta="select actor from 949_actoresVSAccionesProceso where idActorVSAccionesProceso=".$actor;
			
		  }
		  else
		  {
		  	$consulta="SELECT actor FROM 950_actorVSProcesoInicio WHERE idActorProcesoInicio=".$actor;
			
			
			
			
		  }
		 

		  $rolActor=$con->obtenerValor($consulta);
		  $consulta="select idActorProcesoEtapa from 944_actoresProcesoEtapa where idProceso=".$idProceso." and numEtapa=1 and actor='".$rolActor.
		  			"' and tipoActor=1";

		  $actorEtapa1=$con->obtenerValor($consulta);
		  if($actorEtapa1=="")
		  	$actorEtapa1="0";
	  }
	  else
	  {
	  	$actorEtapa1=$actor;
		$consulta="select idReferencia from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$idReferencia=$con->obtenerValor($consulta);
		if($idReferencia=="-1")
			$idReferencia="";
		
	  }
	  $idProceso=obtenerIdProcesoFormulario($idFormulario);

	  $consulta="SELECT COUNT(*) FROM 2002_comentariosRegistro WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro." and comentario<>''";
	  $nComentarios=$con->obtenerValor($consulta);
	  
	  $consulta="SELECT COUNT(*) FROM 2002_comentariosRegistro WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro." and comentario<>'' and visualizado=0";
	  $nNuevosComentarios=$con->obtenerValor($consulta);
	  
	  
	  $parametrosProceso="";
	  if(isset($objParametros->parametrosProceso))
	  		$parametrosProceso=$objParametros->parametrosProceso;
			
	  $eJs="";
	  if(isset($objParametros->eJs))
	  		$eJs=$objParametros->eJs;
	  
?>


	<div id="header">
    	<script type="text/javascript" src="../Scripts/ext/menus/uxMenu.js"></script>
    	<script type="text/javascript" src="../modeloPerfiles/Scripts/vistaDTDv3.js.php?idP=<?php echo bE($participante)?>&iP=<?php echo bE($idProceso)?>&iF=<?php echo bE($idFormulario)?>&iR=<?php echo bE($idRegistro)?>&iA=<?php echo bE($actor)?>"></script>
    </div>
    
    <input type="hidden" id="regVersiones" value="<?php echo $arrVersiones?>" />
    <input type="hidden" id="idProcesoPrincipal" value="<?php echo $idProceso?>" />
    <input type="hidden" name="idRegistroAux" value="<?php echo $idRegistro?>" id="idRegistroAux" />
    <input type="hidden" name="nComentarios" value="<?php echo $nComentarios?>" id="nComentarios" />
    <input type="hidden" name="nNuevosComentarios" value="<?php echo $nNuevosComentarios?>" id="nNuevosComentarios" />
    <input type="hidden" name="parametrosProceso" value="<?php echo $parametrosProceso?>" id="parametrosProceso" />
    <input type="hidden" name="eJs" value="<?php echo $eJs?>" id="eJs" />
    <?php 
	
	
		
	
        $consulta="select pagPrincipalReg from 921_tiposProceso tp,4001_procesos p where tp.idTipoProceso=p.idTipoProceso and p.idProceso=".$idProceso;
		
        $pagPrincipal=$con->obtenerValor($consulta);
		$consulta="SELECT * FROM 9046_botonesProceso WHERE idProceso=".$idProceso." order by texto";
		$resBotones=$con->obtenerFilas($consulta);
		$arrBtn="";
		while($fila=mysql_fetch_row($resBotones))
		{
			$icono="../images/Icono_txt.gif";
			if($fila[3]!="")
				$icono=$fila[3];
			
			$obj="{
					  icon:'".$icono."',
					  cls:'x-btn-text-icon',
					  text:'".$fila[2]."',
					  handler:function()
							  {";
			if($fila[5]==0)							  
			{
				$obj.="var arrParam=[['idFormulario','".$idFormulario."'],['idRegistro','".$idRegistro."']];
						enviarFormularioDatos('".$fila[1]."',arrParam);
				";
			}
			else
			{
				$obj.=$fila[1]."();";
			}
								  
			$obj.="			  }
					  
				  }";
			if($arrBtn=="")
				$arrBtn=$obj;
			else
				$arrBtn.=",".$obj;
		}
		$arrBtn="[".$arrBtn."]";
		
		$arrParamIgnorar=array();
		array_push($arrParamIgnorar,"confReferencia");
		array_push($arrParamIgnorar,"cPagina");
		array_push($arrParamIgnorar,"idRegistro");
		array_push($arrParamIgnorar,"idFormulario");
		array_push($arrParamIgnorar,"dComp");
		array_push($arrParamIgnorar,"actor");
		array_push($arrParamIgnorar,"paginaConf");
		$arrParamComp='';
		$cadParam="";
		$reflectionClase = new ReflectionObject($objParametros);
		foreach ($reflectionClase->getProperties() as $property => $value) 
		{
			$nombre=$value->getName();
			$valor=$value->getValue($objParametros);
			if(!existeValor($arrParamIgnorar,$nombre))
			{
				$o='<input type="hidden" id="'.$nombre.'" name="'.$nombre.'" value='.$valor.'>';
				if($cadParam=="")
					$cadParam=$o;
				else
					$cadParam.="".$o;
				if($arrParamComp=="")
					$arrParamComp="['".$nombre."','".$valor."']";
				else
					$arrParamComp.=",['".$nombre."','".$valor."']";
			}
		}
		
    ?>
    <input type="hidden" id="actor" name="actor" value="<?php echo base64_encode($actor)?>" />

    <form id="frmEnvioNuevo" method="post" action="vistaDTDv2.php">
    <?php
		echo $cadParam;
	?>
        <input type="hidden" id="actorEtapa1" name="actor" value="<?php echo base64_encode($actorEtapa1)?>" />
        <input type="hidden" name="idFormulario" value="<?php echo $idFormulario?>" id="idFormularioAux"  />
        <input type="hidden" name="participante" value="<?php echo $participante?>" id="participante" />
        <input type="hidden" name="idProcesoP" id='idProcesoP' value="<?php echo $idProcesoP ?>" />
        <input type="hidden" name="idReferencia" id="idReferencia" value="<?php echo $idReferencia ?>" />
        <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $idUsuario ?>" />
        
    </form>

    <input type="hidden" id="arrParamComp" value="<?php echo bE("[".$arrParamComp."]")?>" />
    <input type="hidden" id="arrBtn" value="<?php echo bE($arrBtn) ?>" />
    <form method="post"	action="" id='frmEnvioDatos'>
    	<input type="hidden" id="confPaginaEnvioDatos" name="confReferencia" value="<?php echo $nConfiguracion ?>" />
    </form>
    
    <form method="post"	action="<?php echo "../".$rutaNomPagina ?>" id='frmRefrescarPagina'>
        <input type="hidden" id="confPaginaRefrescar" name="configuracion" value="<?php echo $nConfiguracion ?>" />
    </form>
    
    <iframe id="frameDTD" name="frameDTD" src="" width="400" height="400" onload="frameLoad(this)"></iframe>
    
</body>

</html>