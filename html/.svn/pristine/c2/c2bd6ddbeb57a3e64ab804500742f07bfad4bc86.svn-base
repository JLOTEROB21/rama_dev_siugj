	<?php 
	include("sesiones.php");
	include("conexionBD.php"); 
	include("configurarIdioma.php");
	include("funcionesPortal.php");
	$arrConfiguraciones="";
	$actorEtapa1="";

function generarTablaModulos()
{
  global $con;
  global $accion;
  global $objParametros;
  global $actor;
  
  $idFormulario=$objParametros->idFormulario;
  $idRegistro=$objParametros->idRegistro;
  $consulta="select nombreFormulario,nombreTabla,idProceso from 900_formularios  where idFormulario=".$idFormulario;

  $filaFrm=$con->obtenerPrimeraFila($consulta);
  $nFormulario=$filaFrm[0];
  $nTabla=$filaFrm[1];
  $idProceso=$filaFrm[2];
  $enlace="javascript:enviarFichaProyecto(".$idFormulario.",\"".base64_encode("ver")."\")";
  $imgFicha="../images/001_06.gif";
  $tblRegistro="";
  $ocultarMenuDTD="";
  
  
  if($accion=="agregar")
  {
	  $ocultarMenuDTD=' style="display:none"';
	  $tblRegistro="	<table style='display:' id='tblRegistro'>
					  <tr>
						  <td><img src='../images/update_nw.gif' alt=''></td><td width='10'></td><td class='letraFicha' id='td_1'>".$nFormulario."</td>
					  </tr>
				  ";
  }

  echo $tblRegistro;
  
  $consulta="select idEstado from ".$nTabla." where id_".$nTabla."=".$idRegistro;
  $etapaReg=$con->obtenerValor($consulta);
 
  if($actor!=0)
  {
	  $consulta="select aa.idGrupoAccion,aa.complementario from 944_actoresProcesoEtapa ap,947_actoresProcesosEtapasVSAcciones aa where 
				  aa.idActorProcesoEtapa=ap.idActorProcesoEtapa and ap.numEtapa=".$etapaReg." and ap.idProceso=".$idProceso." and ap.idActorProcesoEtapa=".$actor;
  }
  else
  {
	    $consulta="select aa.idGrupoAccion,aa.complementario from 944_actoresProcesoEtapa ap,947_actoresProcesosEtapasVSAcciones aa where 
				  aa.idActorProcesoEtapa=ap.idActorProcesoEtapa and ap.numEtapa=".$etapaReg." and ap.idProceso=".$idProceso." and ap.idActorProcesoEtapa=".$actor;
		
  }
  $resAcciones=$con->obtenerFilas($consulta);
  $arrAcciones=array();
  while($filaAcciones=mysql_fetch_row($resAcciones))
  {
	  $arrAcciones[$filaAcciones[0]]="".$filaAcciones[1];
  }
  
  $someteRevision=false;
  $modificaElementos=false;
  $asignaRevisores=false;
  $realizaDictamenF=false;
  $realizaDictamenP=false;
  $marcarElementos=false;
  
  if(isset($arrAcciones["1"]))
	  $someteRevision=true;
  if(isset($arrAcciones["2"]))
	  $modificaElementos=true;
  if(isset($arrAcciones["3"]))
	  $asignaRevisores=true;
  if(isset($arrAcciones["4"]))
	  $realizaDictamenP=true;
  if(isset($arrAcciones["5"]))
	  $realizaDictamenF=true;
  if(isset($arrAcciones["6"]))
	  $marcarElementos=true;
  
  $consulta="select estado from 963_estadosElementoDTD where idFormulario=".$idFormulario." and idReferencia=".$idRegistro;
  $estado=$con->obtenerValor($consulta);
  
  if($estado=="1")
  {
	  $btnBloqueado="&nbsp;<img src='../images/lock.png' alt='Elemento bloqueado, no puede ser editado' title='Elemento bloqueado, no puede ser editado'>";
	  $elemBloqueado=true;
  }
  else
  {
	  $elemBloqueado=false;
	  $btnBloqueado="";
  }
  $btnBloqueoElem="";
  if($marcarElementos)
  {
	  if($elemBloqueado)
		  $btnBloqueoElem="&nbsp;<a href='javascript:quitarBloqueo(\"".base64_encode($idFormulario)."\",\"".base64_encode($idRegistro)."\")'><img src='../images/lock_delete.png' title='Quitar bloqueo de edici&oacute;n' alt='Quitar bloqueo de edici&oacute;n'></a>";
	  else
		  $btnBloqueoElem="&nbsp;<a href='javascript:bloquearElemento(\"".base64_encode($idFormulario)."\",\"".base64_encode($idRegistro)."\")'><img src='../images/lock_add.png' title='Bloquear elemento para evitar edici&oacute;n' alt='Bloquear elemento para evitar edici&oacuten'></a>";
  }
  
  
  $btnModificar="";
  
  if($actor==0)
  	$modificaElementos=false;
  
  if($modificaElementos&&!$elemBloqueado)
  {
	  $accionM=base64_encode("modificar");
	  $btnModificar="<a href='javascript:enviarFichaProyecto(".$idFormulario.",\"".$accionM."\")'><img src='../images/pencil.png' title ='Modificar' alt='Modificar'></a>";
  }
  

?>
  
  
  
  
  <table <?php echo $ocultarMenuDTD?> id="tblDTD">
  <tr>
  <td><img src='<?php echo $imgFicha ?>' alt=''></td><td width='10'></td><td class='letraFicha' id="td_1"><a href='<?php echo $enlace ?>'><?php echo $nFormulario?></a>&nbsp;<?php echo $btnModificar.$btnBloqueado.$btnBloqueoElem?></td>
  </tr>
  
<?php
  
  echo generarTableroModulosUsuario($idFormulario,$idRegistro,$actor);
?>
  </table>
  <br /><br />
<?php
}

function genenerarDTDProyecto()
{
	global $arrConfiguraciones;
	global $objParametros;
	global $con;
	global $accion;
	global $objParametros;
	global $actor;
	global $actorEtapa1;
	$idFormulario=$objParametros->idFormulario;
	$idRegistro=$objParametros->idRegistro;
	$consulta="select nombreFormulario,nombreTabla,idProceso from 900_formularios  where idFormulario=".$idFormulario;
	
	$fForm=$con->obtenerPrimeraFila($consulta);
	$nFormulario=$fForm[0];
	$nTabla=$fForm[1];
	$idProceso=$fForm[2];
	$enlace="javascript:enviarAsociado(".$idFormulario.",".$idRegistro.",1)";
	$imgFicha="../images/001_06.gif";
	$tblRegistro="";
	$ocultarMenuDTD="";
	$constante=1;
	
	$consulta="select distinct(idActorProcesoEtapa) from 944_actoresProcesoEtapa where idProceso=".$idProceso." and tipoActor=1 and numEtapa=1";
	
	$actorEtapa1=base64_encode($con->obtenerValor($consulta));
	
	if($actor<0)
		$constante=-1;
	
	if($accion!="agregar")
	{
		if($actor!=0)
		{
			$consulta="select tipoActor,actor from 944_actoresProcesoEtapa where idActorProcesoEtapa=".($actor*$constante);
			$filaActor=$con->obtenerPrimeraFila($consulta);
			$tipoActor=$filaActor[0];
			$act=$filaActor[1];
			
		}
		else
		{
			$tipoActor=1;
			$act=0;
		}
		$consulta="select idEstado from ".$nTabla." where id_".$nTabla."=".$idRegistro;
		$etapaReg=$con->obtenerValor($consulta);
		
		if($tipoActor==1)
		{
			$consulta="select e.idFormulario,nombreFormulario,titulo,e.tipoElemento,nombreTabla,e.obligatorio from 
					203_elementosDTD e,900_formularios f where e.idFormulario=f.idFormulario and 
					e.idProceso=".$idProceso." and f.idEtapa<=".$etapaReg." 
					order by orden";
			
			
		}
		else
		{
			$consulta="select idFormulario from 245_proyectosComitesElementosDTD eD,203_elementosDTD dtd where dtd.idElementoDTD=eD.idElemento and  eD.idProyectoComite=".$act;
			$arrFrm=$con->obtenerListaValores($consulta);		
			if($arrFrm=="")
				$arrFrm="-1";
			$consulta="select e.idFormulario,nombreFormulario,titulo,e.tipoElemento,nombreTabla,e.obligatorio from 
					203_elementosDTD e,900_formularios f where e.idFormulario=f.idFormulario and 
					e.idProceso=".$idProceso." and f.idEtapa<=".$etapaReg." and e.idFormulario in(".$arrFrm.")
					order by orden";
		}
		
		$res=$con->obtenerFilas($consulta);
		$ct=1;
		$arrConfiguraciones="var arrParamConfiguraciones=new Array();";
		$ctParamFunciones=0;
		$arrValoresReemplazo[0][0]="@formulario";
		$arrValoresReemplazo[0][1]=$idFormulario;
		$arrValoresReemplazo[1][0]="@registro";
		$arrValoresReemplazo[1][1]=$idRegistro;
		$enlace="";
		$ctTD=2;
		while($f=mysql_fetch_row($res))
		{
			if($f[3]=="0")
			{
				$nTabla="select id_".$f[4]." from ".$f[4]." where idReferencia=".$idRegistro;
				$fila=$con->obtenerPrimeraFila($nTabla);
				$enlace="javascript:enviarAsociado(".$f[0].",".$idRegistro.",".$ctTD.")";
				
				if($fila)									
					$img="<a href='".$enlace."'><img src='../images/001_06.gif' alt=''></a>";
				else
					$img="<a href='".$enlace."'><img src='../images/001_05.gif' alt=''></a>";
			}
			else
			{
				$nTabla=$f[4];
				$consulta="select modulo,paginaAsociada,paginaVistaAsociada from 200_modulosPredefinidosProcesos where idGrupoModulo=".$f[2]." and idIdioma=".$_SESSION["leng"];
				$filaR=$con->obtenerPrimeraFila($consulta);		
				$arrConfiguraciones.="arrParamConfiguraciones[".$ctParamFunciones."]=new Array();";
				$arrConfiguraciones.="arrParamConfiguraciones[".$ctParamFunciones."][0]='".$filaR[1]."';";
				$arrConfiguraciones.="arrParamConfiguraciones[".$ctParamFunciones."][2]='".$filaR[2]."';";
				$consulta="select nombreParametro,valorParametro from 242_parametrosEnlaces where idEnlace=".$f[2]." and tipoEnlace=0";
				$arrParametros=$con->obtenerFilasArreglo($consulta);	
				$numParam=sizeof($arrValoresReemplazo);
				for($pos=0;$pos<$numParam;$pos++)
				{
					$arrParametros=str_replace($arrValoresReemplazo[$pos][0],$arrValoresReemplazo[$pos][1],$arrParametros);	
				}
				$arrConfiguraciones.="arrParamConfiguraciones[".$ctParamFunciones."][1]=".$arrParametros.";";
				$ctParamFunciones++;
			}
		}
	}
	
	?>
    <span id="divAcciones">
	<?php
	
	switch($accion)
	{
    	case "agregar":
			$tblRegistro="	<table id='tblRegistro'>
							<tr>
								<td><img src='../images/update_nw.gif' alt=''></td><td width='10'></td><td class='letraFicha' id='td_1'>".$nFormulario."</td>
							</tr>
							</table>
						";
		break;
		case "modificar":
			generarTablaModulos();
		break;
		case "auto":
			generarTablaModulos();
		break;
	}
	echo $tblRegistro;
	
?>
	</span>
    <br /><br />
<?php
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
<?php
		//$paramGET=true;
		$guardarConfSession=true;
		
		//echo $accion;
		
?>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../modeloPerfiles/Scripts/verDTD.js.php"></script>
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
	$tamColumIzq="210";
	$mostrarUsuario=false;
	
	
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
                      <br><br>

					  <?php
					  $accion="";
					  if(isset($objParametros->dComp))
						$accion=base64_decode($objParametros->dComp);
					
					
					  $scriptFrmEnvio="";
					  $idFormulario="-1";
					  if(isset($objParametros->idFormulario))
						  $idFormulario=$objParametros->idFormulario;
					  $idRegistro="-1";
					  if(isset($objParametros->idRegistro))
						  $idRegistro=$objParametros->idRegistro;
					  $tipoProceso=obtenerTipoProceso(obtenerIdProcesoFormulario($idFormulario));
					  $idEntidad="-1";
					  if(isset($objParametros->idEntidad))
					  	$idEntidad=$objParametros->idEntidad;
					  $tEntidad="-1";
					  if(isset($objParametros->tEntidad))
					  	$tEntidad=$objParametros->tEntidad;

					  switch($accion)
					  {
						  case "agregar":
							  if($tipoProceso==8)
							  	$scriptFrmEnvio	="var parametrosFrm=[['idRegistro','".$idRegistro."'],['idFormulario','".$idFormulario."'],['cPagina','sFrm=true'],['paginaRedireccion','../modeloPerfiles/verFichaFormulario.php'],['eJs','".base64_encode("window.parent.mostrarMenuDTD('@idRegistro');")."'],['funcEjecutarNuevo','registrarCredito(idRegPadre,".$idEntidad.",".$tEntidad.",".$idFormulario.")']];";
							  else
							  	$scriptFrmEnvio	="var parametrosFrm=[['idRegistro','".$idRegistro."'],['idFormulario','".$idFormulario."'],['cPagina','sFrm=true'],['paginaRedireccion','../modeloPerfiles/verFichaFormulario.php'],['eJs','".base64_encode("window.parent.mostrarMenuDTD('@idRegistro');")."']];";
							  
							  
							  $scriptFrmEnvio.= "
											     var funcionInicio=function()
																  {
																	  enviarFormularioDatos('../modeloPerfiles/registroFormulario.php',parametrosFrm,'POST','iFElementosDTD');
																  }
											  ";
							   
						  break;
						  case  "modificar":
							  $scriptFrmEnvio	="var parametrosFrm=[['idRegistro','".$idRegistro."'],['idFormulario','".$idFormulario."'],['cPagina','sFrm=true'],['paginaRedireccion','../modeloPerfiles/verFichaFormulario.php'],['eJs','".base64_encode("window.parent.mostrarMenuDTD();")."']];
											  var funcionInicioarioDatos('../modeloPerfiles/verFichaFormulario.php',parametrosFrm,'POST','iFElementosDTD');
																  }
											  ";
						  break;
						  case "auto":
							  $scriptFrmEnvio	="var parametrosFrm=[['idRegistro','".$idRegistro."'],['idFormulario','".$idFormulario."'],['cPagina','sFrm=true'],['paginaRedireccion','../modeloPerfiles/verFichaFormulario.php'],['eJs','".base64_encode("window.parent.mostrarMenuDTD();")."']];
											  var funcionInicio=function()
																  {
																	  enviarFormularioDatos('../modeloPerfiles/verFichaFormulario.php',parametrosFrm,'POST','iFElementosDTD');
																  }
											  ";
							  
						  break;
					  }
					  $actor=0;
					  if(isset($objParametros->actor))
						  $actor=base64_decode($objParametros->actor);
						
					  genenerarDTDProyecto()
					  ?>
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
                        	<table width="100%">
                            <tr>
                            	<td width="" align="center">
                                   	<iframe width="100%" src="" id="iFElementosDTD" name="iFElementosDTD" height="" frameborder="0" onLoad="redimensionarIframe(this)"  >
                                    </iframe>
                        		</td>
                                <td width="">
                                <input type="hidden" name="idFormulario" value="<?php echo $idFormulario?>" id="idFormularioAux" />
                                 <input type="hidden" name="idRegistroAux" value="<?php echo $idRegistro?>" id="idRegistroAux" />
                                <input type="hidden" name="accion" value="<?php echo base64_encode($accion)?>" id="accionAux" />
                                <input type="hidden" name="eJsAux" value="<?php echo base64_encode("window.parent.mostrarMenuDTD()") ?>" id="eJsAux" />
                                <input type="hidden" id="actor" value="<?php echo base64_encode($actor) ?>" />
                                <?php 
									$idProceso=obtenerIdProcesoFormulario($idFormulario);
									$consulta="select pagPrincipalReg from 921_tiposProceso tp,4001_procesos p where tp.idTipoProceso=p.idTipoProceso and p.idProceso=".$idProceso;
									$pagPrincipal=$con->obtenerValor($consulta);
								?>
                                
                                
                                <input type="hidden" id="pagPrincipal" value="<?php echo $pagPrincipal?>" />
                                
                                <form id="frmEnvioNuevo" method="post" action="verDTD.php">
                                	<input type="hidden" id="actor" name="actor" value="<?php echo ($actorEtapa1)?>" />
                                    <input type="hidden" name="confReferencia" value="<?php echo $nConfRegresar ?>" />
                                    <input type="hidden" name="dComp" value="<?php echo base64_encode("auto")?>" />
                                    <input type="hidden" name="idFormulario" value="<?php echo $idFormulario?>" />
                                    <input type="hidden" name="idRegistro" id="registroRecarga" value="" />
                                    
                                
                                </form>
                                
                                </td>
                                <script>
									<?php 
										echo $arrConfiguraciones;
										echo $scriptFrmEnvio;
									?>
                                </script>
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
