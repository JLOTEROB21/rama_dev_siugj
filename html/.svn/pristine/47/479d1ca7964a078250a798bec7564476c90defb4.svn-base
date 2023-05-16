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
	$paramGET=true;
?>
<script src="../Scripts/visJS/vis.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/visJS/vis-timeline-graph2d.min.css"/>
<script src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../Scripts/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/jQueryUI/temas/smoothness/jquery-ui.css"/>
<script type="text/javascript" src="../Scripts/jQueryUI/jquery-ui.js"></script>
<link rel="stylesheet" href="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.css"  type="text/css" media="screen" />
<script type="text/javascript" src="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    
<script src="../modulosEspeciales_SGJP/Scripts/historialCarpetaJudicial.js.php"></script>
<style>
	.eventoCarpeta
	{
		border-style:solid;
		border-width:3px;		
		border-color:#FFFF4A;
		
	}
	
	.promocion
	{
		border-style:solid;
		border-width:3px;		
		border-color:#46A3FF;
		
	}
	
	.etapaInicial
	{
		border-style:solid;
		border-width:3px;		
		border-color:#060;
		
	}
	.etapaIntermedia
	{
		
		border-style:solid;
		border-width:3px;		
		border-color:#F93;
	}
	.etapaJuicioOral
	{
		border-style:solid;
		border-width:3px;		
		border-color:#900;
		
	}
	.etapaEjecucion
	{
		border-style:solid;
		border-width:3px;		
		border-color:#A61BA6;
		
	}
	
	.tblMarco
	{
		border-color:#CCC;
		padding:10px;
		border-style:solid;
		border-width:1px;
	}
	
	.vi s-item.vis-selected 
	{
		border-color: #F00;
		border-style:solid;
		border-width:4px;
		z-index: 2;
	}
	
	.puntoAlerta
	{
		border-style:solid;
		border-width:1px;
		color:#FFF;
		background-color:#900;
		border-color:#030;
		font-weight:bold;
		
		
		
		
	}
	
	.puntoEventoCarpeta
	{
		border-style:solid;
		border-width:4px;
		color:#000;
		background-color:#FFD9D9;
		border-color:#003;
		font-weight:bold;
	}
	
	.puntoEventoApelacion
	{
		border-style:solid;
		border-width:4px;
		color:#000;
		background-color:#FCC;
		border-color:#003;
		font-weight:bold;
	}
	
	.puntoEventoAmparo
	{
		border-style:solid;
		border-width:4px;
		color:#000;
		background-color:#FCF;
		border-color:#003;
		font-weight:bold;
	}
	
	.puntoEventoPromocion
	{
		border-style:solid;
		border-width:4px;
		color:#000;
		background-color:#F0E1FF;
		border-color:#003;
		font-weight:bold;
	}
	
	.puntoEventoIncompetencia
	{
		border-style:solid;
		border-width:4px;
		color:#000;
		background-color:#999;
		border-color:#003;
		font-weight:bold;
	}
	
	.container
	{
		width: 550px;
		margin: 0 auto;
	}



	ul.tabs
	{
		margin: 0px;
		padding: 0px;
		list-style: none;
	}
	ul.tabs li
	{
		background: none;
		color: #222;
		display: inline-block;
		padding: 10px 15px;
		cursor: pointer;
	}

	ul.tabs li.current
	{
		background: #ededed;
		color: #222;
	}

	.tab-content
	{
		display: none;
		background: #ededed;
		padding: 15px;
	}

	.tab-content.current
	{
		display: inherit;
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
                        <td align="left">
                        
                        <?php
							function obtenerEventosVariosCarpeta($cJudicial,&$nRegistro)
							{
								global $con;
								$arrEventos=array();
								$consulta="SELECT * FROM _451_tablaDinamica WHERE carpetaAdministrativa='".$cJudicial."' and idEstado>1";
								$res=$con->obtenerFilas($consulta);
								while($fila=mysql_fetch_assoc($res))
								{
									$consulta="SELECT nombreTipo FROM _5_tablaDinamica WHERE id__5_tablaDinamica=".$fila["figuraJuridica"];
									$lblFigura=$con->obtenerValor($consulta);
									$tblDatosAudiencia='<table>'.
														'<tr height="21">'.
															'<td align="left" colspan="2"><span style="font-size:10px"><b>['.$fila["carpetaApelacion"].']</b></span></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><b>Tipo Evento:</b></td><td align="left" width="320" >Registro de Apelaci&oacute;n</td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><b>Nombre del apelante:</b></td><td align="left" width="320" >'.obtenerNombreImplicado($fila["nombreApelante"]).' ('.$lblFigura.')&nbsp;<span id="lblCtrlDetalles_'.$nRegistro.'"><a href="javascript:mostrarDetalleProceso(\''.bE(451).'\',\''.bE($fila["id__451_tablaDinamica"]).'\')" style="font-size:9px;color:#000;font-weight:bold">[Ver detalles]</a></span></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><span style="font-size:10px"><b>Registrado por:</b></span></td><td align="left" width="320" ><span style="font-size:10px">'.obtenerNombreUsuario($fila["responsable"]).' ('.date("d/m/Y H:i:s",strtotime($fila["fechaCreacion"])).')</span></td>'.
															
														'</tr>'.
														
													'</table>';
								
									
									$lblEvento="".$tblDatosAudiencia."<br>";
									$content=$lblEvento;
									$cadObj='{"id":"'.$nRegistro.'","content":"'.bE(cv($content)).'","start":"'.date("Y-m-d",strtotime($fila["fechaCreacion"])).'","className":"puntoEventoApelacion"}';
									$o=json_decode($cadObj);
									array_push($arrEventos,$o);
									$nRegistro++;
								}
								
								
								$consulta="SELECT * FROM _346_tablaDinamica WHERE carpetaAdministrativa='".$cJudicial."' and idEstado>1";
								$res=$con->obtenerFilas($consulta);
								while($fila=mysql_fetch_assoc($res))
								{
									$consulta="SELECT tipoAmparo FROM _174_tablaDinamica WHERE id__174_tablaDinamica=".$fila["tipoAmparo"];
									$tipoAmparo=$con->obtenerValor($consulta);
									
									$lblQuejoso="";
									if(($fila["quejoso"]=="")||($fila["quejoso"]==-1))
										$lblQuejoso=$fila["nombre"]." ".$fila["apPaterno"]." ".$fila["apMaterno"];
									else
										$lblQuejoso=obtenerNombreImplicado($fila["quejoso"]);
									$tblDatosAudiencia='<table>'.
														'<tr height="21">'.
															'<td align="left" colspan="2"><span style="font-size:10px"><b>['.$fila["carpetaAmparo"].']</b></span></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><b>Tipo Evento:</b></td><td align="left" width="320" >Registro de Amparo ('.$tipoAmparo.')</td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><b>Nombre del quejoso:</b></td><td align="left" width="320" >'.$lblQuejoso.'&nbsp;<span id="lblCtrlDetalles_'.$nRegistro.'"><a href="javascript:mostrarDetalleProceso(\''.bE(346).'\',\''.bE($fila["id__346_tablaDinamica"]).'\')" style="font-size:9px;color:#000;font-weight:bold">[Ver detalles]</a></span></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><span style="font-size:10px"><b>Registrado por:</b></span></td><td align="left" width="320" ><span style="font-size:10px">'.obtenerNombreUsuario($fila["responsable"]).' ('.date("d/m/Y H:i:s",strtotime($fila["fechaCreacion"])).')</span></td>'.
															
														'</tr>'.
														
													'</table>';
								
									
									$lblEvento="".$tblDatosAudiencia."<br>";
									$content=$lblEvento;
									$cadObj='{"id":"'.$nRegistro.'","content":"'.bE(cv($content)).'","start":"'.date("Y-m-d",strtotime($fila["fechaCreacion"])).'","className":"puntoEventoAmparo"}';
									$o=json_decode($cadObj);
									array_push($arrEventos,$o);
									$nRegistro++;
								}
								
								
								$consulta="SELECT * FROM _96_tablaDinamica WHERE carpetaAdministrativa='".$cJudicial."'";
								$res=$con->obtenerFilas($consulta);
								while($fila=mysql_fetch_assoc($res))
								{
									
									if($fila["figuraPromovente"]=="")
										$fila["figuraPromovente"]=-1;
									
									if($fila["usuarioPromovente"]=="")
										$fila["usuarioPromovente"]=-1;
									
									if($fila["tipoPromociones"]=="")
										$fila["tipoPromociones"]=-1;
									
									if($fila["tipoAudiencia"]=="")
										$fila["tipoAudiencia"]=-1;	
									$consulta="SELECT nombreTipo FROM _5_tablaDinamica WHERE id__5_tablaDinamica=".$fila["figuraPromovente"];
									$lblFigura=$con->obtenerValor($consulta);
									
									$consulta="SELECT COUNT(idOpcion) FROM _96_chkPersonaNoRegistrada WHERE idPadre=".$fila["id__96_tablaDinamica"];
									$nPromovente=$con->obtenerValor($consulta);
									$lblPrmomovente="";
									if($nPromovente==0)
										$lblPromovente=$fila["nombre"]." ".$fila["apPaterno"]." ".$fila["apMaterno"];
									else
										$lblPromovente=obtenerNombreImplicado($fila["usuarioPromovente"]);
									
									$consulta="SELECT nombreTipoPromocion FROM _97_tablaDinamica WHERE id__97_tablaDinamica=".$fila["tipoPromociones"];
									$tipoPromocion=$con->obtenerValor($consulta);
									
									
									$tipoAudiencia="";
									
									if($fila["tipoPromociones"]==2)
									{
										$consulta="SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fila["tipoAudiencia"];

										$tipoAudiencia=$con->obtenerValor($consulta);
									}
									$filaTipoAudienica='<tr height="21">'.
															'<td align="left" width="80"><b>Tipo de audiencia:</b></td><td align="left" width="320" >'.$tipoAudiencia.'</td>'.
														'</tr>';
														
									$tblDatosAudiencia='<table>'.
														'<tr height="21">'.
															'<td align="left" colspan="2"><span style="font-size:10px"><b>['.$fila["carpetaAdministrativa"].']</b></span></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><b>Tipo Evento:</b></td><td align="left" width="320" >Promoci&oacute;n</td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><b>Nombre del promovente:</b></td><td align="left" width="320" >'.$lblPromovente.($lblFigura==""?"":' ('.$lblFigura.')').'&nbsp;<span id="lblCtrlDetalles_'.$nRegistro.'"><a href="javascript:mostrarDetalleProceso(\''.bE(96).'\',\''.bE($fila["id__96_tablaDinamica"]).'\')" style="font-size:9px;color:#000;font-weight:bold">[Ver detalles]</a></span></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><b>Tipo de promoci&oacute;n:</b></td><td align="left" width="320" >'.$tipoPromocion.'</td>'.
														'</tr>'.($fila["tipoPromociones"]==2?$filaTipoAudienica:"").
														'<tr height="21">'.
															'<td align="left" width="80"><span style="font-size:10px"><b>Registrado por:</b></span></td><td align="left" width="320" ><span style="font-size:10px">'.obtenerNombreUsuario($fila["responsable"]).' ('.date("d/m/Y H:i:s",strtotime($fila["fechaCreacion"])).')</span></td>'.
															
														'</tr>'.
														
													'</table>';
								
									
									$lblEvento="".$tblDatosAudiencia."<br>";
									$content=$lblEvento;
									$cadObj='{"id":"'.$nRegistro.'","content":"'.bE(cv($content)).'","start":"'.date("Y-m-d",strtotime($fila["fechaCreacion"])).'","className":"puntoEventoPromocion"}';
									$o=json_decode($cadObj);
									array_push($arrEventos,$o);
									$nRegistro++;
								}
								
								return $arrEventos;
							}
							
							function generarPlantillaEvento($nRegistro,$o,$clase)
							{
								
								$oElemento="";
								if(!isset($o["incompetencia"]))
								{
									$lblDocumentos="";
									foreach($o["arrDocumentos"] as $d)
									{
										$arrExtension=explode(".",$d[1]);
										$extension=strtolower($arrExtension[sizeof($arrExtension)-1]);
										if($extension=="jpeg")
											$extension="jpg";
										$oDoc='<tr height="21"><td width="20"><a href="javascript:mostrarVisorDocumento(\\\''.bE($d[0]).'\\\')"><img src="../imagenesDocumentos/16/file_extension_'.$extension.'.png"></a></td><td><a href="javascript:mostrarVisorDocumento(\\\''.bE($d[0]).'\\\')">'.$d["1"].'</a></td></tr>'	;
										if($lblDocumentos=="")
											$lblDocumentos=$oDoc;
										else
											$lblDocumentos.="<br>".$oDoc;
									}
									if($lblDocumentos!="")
										$lblDocumentos="<table>".$lblDocumentos."</table>";
									else
										$lblDocumentos="<table>(Sin documentos)</table>";
										
									$lblGrabacion="(No registrado)";
									if($o["urlVideo"]!="")
										$lblGrabacion	='<table><tr><td><a href="javascript:abrirVideoGrabacion(\\\''.bE($o["idEventoAudiencia"]).'\\\')"><img src="../images/control_play_blue.png"></a></td><td>&nbsp;&nbsp;<a href="javascript:abrirVideoGrabacion(\\\''.bE($o["idEventoAudiencia"]).'\\\')">Ver grabaci&oacute;n</a></td></tr></table>';
										
										
									$lblResultadoAudiencia="";
									
									$lblResolutivos="<table style=\"100%\">";
									$lblResolutivos.="<tr><td align=\"left\"><b><U>Resolutivos</u></b><br><br></td></tr>";
									foreach($o["resolutivos"] as $r)
									{
										$oResolutivo="-- ".$r["descripcionResolutivo"]." (".$r["valor"].")";
										if($r["comentarios"]!="")
										{
											$oResolutivo.=". ".$r["comentarios"];
										}
										$oResolutivo.="<br><br>";
										$lblResolutivos.="<tr><td align=\"left\" style=\"text-align:justify;\" >".str_replace("\n","<br>",$oResolutivo)."</td></tr>";
										
										
									}
									$lblResolutivos.="</table>";	
									
									if(sizeof($o["resolutivos"])>0)
									{
										$lblResultadoAudiencia=$lblResolutivos;
									}
									
									$lblMedidasCautelares="<table style=\"100%\">";
									$lblMedidasCautelares.="<tr><td align=\"left\"><b><U>Medidas Cautelares</u></b><br><br></td></tr>";
									foreach($o["medidasCautelares"] as $r)
									{
										$oResolutivo="<b>-- Imputado ".$r["imputado"].".-</b>".$r["medida"];
										if($r["comentarios"]!="")
										{
											$oResolutivo.=". ".$r["comentarios"];
										}
										$oResolutivo.="<br><br>";
										$lblMedidasCautelares.="<tr><td align=\"left\" style=\"text-align:justify;\" >".str_replace("\n","<br>",$oResolutivo)."</td></tr>";
										
										
									}
									$lblMedidasCautelares.="</table>";
									
									if(sizeof($o["medidasCautelares"])>0)
									{
										if($lblResultadoAudiencia=="")
											$lblResultadoAudiencia=$lblMedidasCautelares;
										else
											$lblResultadoAudiencia.="<br><br>".$lblMedidasCautelares;
									}
									
									$lblMedidasProteccion="<table style=\"100%\">";
									$lblMedidasProteccion.="<tr><td align=\"left\"><b><U>Medidas de Protecci&oacute;n</u></b><br><br></td></tr>";
									foreach($o["medidasProteccion"] as $r)
									{
										$oResolutivo="<b>-- Imputado ".$r[0].".-</b>".$r[1];
										if($r[2]!="")
										{
											$oResolutivo.=". ".$r[2];
										}
										$oResolutivo.="<br><br>";
										$lblMedidasProteccion.="<tr><td align=\"left\" style=\"text-align:justify;\" >".str_replace("\n","<br>",$oResolutivo)."</td></tr>";
										
										
									}
									$lblMedidasProteccion.="</table>";
									
									if(sizeof($o["medidasProteccion"])>0)
									{
										if($lblResultadoAudiencia=="")
											$lblResultadoAudiencia=$lblMedidasProteccion;
										else
											$lblResultadoAudiencia.="<br><br>".$lblMedidasProteccion;
									}
									
									
									$lblSuspension="<table style=\"100%\">";
									$lblSuspension.="<tr><td align=\"left\"><b><U>Condiciones de suspensi&oacute;n condicional</u></b><br><br></td></tr>";
									foreach($o["suspensionCondicional"] as $r)
									{
										$oResolutivo="<b>-- Imputado ".$r[0].".-</b>".$r[1];
										if($r[2]!="")
										{
											$oResolutivo.=". ".$r[2];
										}
										$oResolutivo.="<br><br>";
										$lblSuspension.="<tr><td align=\"left\" style=\"text-align:justify;\" >".str_replace("\n","<br>",$oResolutivo)."</td></tr>";
										
										
									}
									$lblSuspension.="</table>";
									
									if(sizeof($o["suspensionCondicional"])>0)
									{
										if($lblResultadoAudiencia=="")
											$lblResultadoAudiencia=$lblSuspension;
										else
											$lblResultadoAudiencia.="<br><br>".$lblSuspension;
									}
									
									
									
									//--
									$lblAcuerdosReparatorios="<table style=\"100%\">";
									$lblAcuerdosReparatorios.="<tr><td align=\"left\"><b><U>Acuerdos reparatorios</u></b><br><br></td></tr>";
									foreach($o["acuerdosReparatorios"] as $r) 
									{
										$oResolutivo="<b>-- Imputado(s) ".$r[1].".</b><br><br><b>Resumen del acuerdo:</b><br><br>".($r[2]==""?"(Sin resumen)":$r[2]).
													"<br><b>Tipo de cumplimiento: </b>".$r[3]."<br><b>Acuerdo aprobado: </b>".utf8_encode($r[4]).
													"<br><b>Fecha de extinsi&oacute;n de la acci&oacute;n penal: </b>".($r[5]!=""?date("d/m/Y",strtotime($r[5])):"").
													"<br><b>Comentarios adicionales: </b>".$r[6]."<br>";
										
										$oResolutivo.="<br><br>";
										$lblAcuerdosReparatorios.="<tr><td align=\"left\" style=\"text-align:justify;\" >".str_replace("\n","<br>",$oResolutivo)."</td></tr>";
										
										
									}
									$lblAcuerdosReparatorios.="</table>";
									
									if(sizeof($o["acuerdosReparatorios"])>0)
									{
										if($lblResultadoAudiencia=="")
											$lblResultadoAudiencia=$lblAcuerdosReparatorios;
										else
											$lblResultadoAudiencia.="<br><br>".$lblAcuerdosReparatorios;
									}
									
									
									
									
									$tblDatosAudiencia='<table>'.
															'<tr height="21">'.
																'<td align="left" colspan="2"><span style="font-size:10px"><b>['.$o["carpetaJudicial"].']</b></span></td>'.
															'</tr>'.
															'<tr height="21">'.
																'<td align="left" colspan="2"><b>'.$o["fechaAudiencia"].'</b></td>'.
															'</tr>'.
															'<tr height="21">'.
																'<td align="left" colspan="2"><span style="color:#900; font-weight:bold">'.$o["tipoAudiencia"].'</span> <span id="lblCtrlDetalles_'.$nRegistro.'"><a href="javascript:mostrarDetalle('.$nRegistro.')" style="font-size:9px;color:#000;font-weight:bold">[Ver detalles]</a></span><br></td>'.
																
															'</tr>'.
														'</table>';
									$tblDatosAudienciaComp=
															'<span id="sp'.$nRegistro.'_detalles" style="display:none">'.
																'<div class="container" style="width:400px">'.
																	
																	 '<div id="pagina1_'.$nRegistro.'" class="tab-content current" style="width:370px; white-space:normal;">'.
																		'<table>'.
																			'<tr height="21">'.
																				'<td align="left" width="180"><b>Lugar de realizaci&oacute;n:</b></td><td align="left">'.$o["lugar"].'</td>'.
																				
																			'</tr>'.
																			'<tr height="21">'.
																				'<td align="left"><b>Hora de la audiencia:</b></td><td align="left">'.$o["horaProgramada"].' hrs.</td>'.
																				
																			'</tr>'.
																			'<tr height="21">'.
																				'<td align="left"><b>Sala:</b></td><td align="left">'.$o["sala"].'</td>'.
																				
																			'</tr>'.
																			'<tr height="21">'.
																				'<td align="left"><b>Juez:</b></td><td align="left">'.$o["jueces"].'</td>'.									
																			'</tr>'.(($o["desarrollo"]!="")?'<tr><td align="left"><b>Desarrollo:</td><td align="left">'.utf8_encode($o["desarrollo"]).'</td></tr>':'').
																			'<tr height="21"><td align="left"><b>Documentos asociados:</b></td><td align="left">'.$lblDocumentos.'</td></tr>'.
																			'<tr height="21">'.
																				'<td align="left"><b>Videograbaci&oacute;n:</b></td><td align="left">'.$lblGrabacion.'</td>'.
																				
																			'</tr>'.
																		'</table>'.$lblResultadoAudiencia.
													
													
																	'</div>'.
																	'<div id="pagina2_'.$nRegistro.'" class="tab-content" style="width:510px; white-space:normal;">'.
																	'</div>'.
																	'<div id="pagina3_'.$nRegistro.'" class="tab-content" style="width:510px; white-space:normal;">'.
																	'</div>'.
																	'<div id="pagina4_'.$nRegistro.'" class="tab-content" style="width:510px; white-space:normal;">'.
																	'</div>'.
																	'<div id="pagina5_'.$nRegistro.'" class="tab-content" style="width:510px; white-space:normal;">'.
																	'</div>'.
																	'<div id="pagina6_'.$nRegistro.'" class="tab-content" style="width:510px; white-space:normal;">'.
																	'</div>'.
																'</div>'.
															'</pan>';
									
									$lblEvento="".$tblDatosAudiencia."<br>".$tblDatosAudienciaComp;
									
									$oElemento=" {
													id: ".$nRegistro.", 
													content: '".$lblEvento."', 
													start: '".$o["fechaAudienciaRaw"]."',
													className:'".$clase."'
												}";
											
								}
								else
								{
									$lblDocumentos="";
									foreach($o["arrDocumentos"] as $d)
									{
										$arrExtension=explode(".",$d[1]);
										$extension=strtolower($arrExtension[sizeof($arrExtension)-1]);
										if($extension=="jpeg")
											$extension="jpg";
										$oDoc='<tr height="21"><td width="20"><a href="javascript:mostrarVisorDocumento(\\\''.bE($d[0]).'\\\')"><img src="../imagenesDocumentos/16/file_extension_'.$extension.'.png"></a></td><td><a href="javascript:mostrarVisorDocumento(\\\''.bE($d[0]).'\\\')">'.$d["1"].'</a></td></tr>'	;
										if($lblDocumentos=="")
											$lblDocumentos=$oDoc;
										else
											$lblDocumentos.="<br>".$oDoc;
									}
									if($lblDocumentos!="")
										$lblDocumentos="<table>".$lblDocumentos."</table>";
									else
										$lblDocumentos="<table>(Sin documentos)</table>";
										
									
									
									
									$tblDatosAudiencia='<table>'.
															'<tr height="21">'.
																'<td align="left" colspan="2"><span style="font-size:10px"><b>['.$o["carpetaJudicial"].']</b></span></td>'.
															'</tr>'.
															'<tr height="21">'.
																'<td align="left" colspan="2"><b>'.$o["fechaAudiencia"].'</b></td>'.
															'</tr>'.
															'<tr height="21">'.
																'<td align="left" colspan="2"><span style="color:#900; font-weight:bold">'.$o["tipoAudiencia"].'</span> <span id="lblCtrlDetalles_'.$nRegistro.'"><a href="javascript:mostrarDetalle('.$nRegistro.')" style="font-size:9px;color:#000;font-weight:bold">[Ver detalles]</a></span><br></td>'.
																
															'</tr>'.
														'</table>';
									$tblDatosAudienciaComp=
															'<span id="sp'.$nRegistro.'_detalles" style="display:none">'.
																'<div class="container" style="width:500px">'.
																	
																	 '<div id="pagina1_'.$nRegistro.'" class="tab-content current" style="width:480px; white-space:normal;">'.
																		'<table>'.
																			'<tr height="21"><td align="left"><b>Documentos asociados:</b></td><td align="left">'.$lblDocumentos.'</td></tr>'.
																			
																		'</table>'.
													
													
																	'</div>'.
																	
																'</div>'.
															'</pan>';
									
									$lblEvento="".$tblDatosAudiencia."<br>".$tblDatosAudienciaComp;
									
									$oElemento=" {
													id: ".$nRegistro.", 
													content: '".$lblEvento."', 
													start: '".$o["fechaAudienciaRaw"]."',
													className:'puntoEventoIncompetencia'
												}";
								}
											
								return $oElemento;
							}
																				
							function generarPlantillaEventoCarpeta($nRegistro,$fEvento,$clase)			
							{
								$tblDatosAudiencia="";
								$tblDatosAudienciaComp="";
								
								
									
								$tblDatosAudiencia='<table>'.
														'<tr height="21">'.
															'<td align="left" colspan="2"><span style="font-size:10px"><b>['.$fEvento["carpetaAdministrativa"].']</b>&nbsp;<img src="../images/warning_2.png"></span></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><b>Fecha l&iacute;mite:</b></td><td align="left" width="320" >'.date("d/m/Y",strtotime($fEvento["fecha"])).'&nbsp;<span id="lblCtrlDetalles_'.$nRegistro.'"><a href="javascript:mostrarDetalle('.$nRegistro.')" style="font-size:9px;color:#000;font-weight:bold">[Ver detalles]</a></span></td>'.
														'</tr>'.
														'<tr height="21">'.
															'<td align="left" width="80"><span style="font-size:10px"><b>Registrado por:</b></span></td><td align="left" width="320" ><span style="font-size:10px">'.obtenerNombreUsuario($fEvento["idUsuario"]).' ('.date("d/m/Y H:i:s",strtotime($fEvento["fechaRegistro"])).')</span></td>'.
															
														'</tr>'.
														
													'</table>';
								
								$tblDatosAudienciaComp=
														'<span id="sp'.$nRegistro.'_detalles" style="display:none">'.
															'<div class="container" style="width:400px; font-size:11px; font-weight:normal; text-align:justify;">'.$fEvento["detalle"];
															'<br></div>'.
														'</pan>';
								
								$lblEvento="".$tblDatosAudiencia."<br>".$tblDatosAudienciaComp;
								
								$oElemento=' {
												"id": "'.$nRegistro.'", 
												"content": "'.bE(cv($lblEvento)).'", 
												"start": "'.$fEvento["fecha"].'",
												"className":"'.$clase.'"
											}';
								return $oElemento;
							}							
							$cJudicial="";							
							
							if(isset($objParametros->cA))
							{
								$cJudicial=bD($objParametros->cA);
							}
							//return;
							$arrDatosCarpeta=obtenerHistoriaCarpeta($cJudicial);
							
							$arrElementos="";
							$nRegistro=1;
							
							$fEtInicial="";
							$fEtIntermedia="";
							$fEtJuicioOral="";
							$fEtEjecucion="";
							
							$minFecha="";
							$maxFecha="";
							
							$arrPuntosAlerta=array();
							$arrEventoCarpeta=array();
							

							foreach($arrDatosCarpeta["etapaInicial"] as $o)
							{

								if($minFecha=="")
									$minFecha=$o["fechaAudienciaRaw"];
									
								if($maxFecha=="")
									$maxFecha=$o["fechaAudienciaRaw"];
									
								if(strtotime($minFecha)>strtotime($o["fechaAudienciaRaw"]))	
								{
									$minFecha=$o["fechaAudienciaRaw"];
								}
								
								if(strtotime($maxFecha)<strtotime($o["fechaAudienciaRaw"]))	
								{
									$maxFecha=$o["fechaAudienciaRaw"];
								}
									
								if($fEtInicial=="")
									$fEtInicial=$o["fechaAudienciaRaw"];
								
								$clase="etapaInicial";
								$oElemento=generarPlantillaEvento($nRegistro,$o,$clase);
								if($arrElementos=="")
									$arrElementos=$oElemento;
								else
									$arrElementos.=",".$oElemento;
						
								$nRegistro++;
								
								if(isset($o["resolutivos"]))
								{
									foreach($o["resolutivos"] as $r)
									{
										if($r["tipoResolutivo"]==71)
										{
											$oAux=array();
											
											$arrFechas=explode(":",$r["valor"]);
											$oAux["etiqueta"]="(".$arrFechas[1].") Plazo de cierre de investigaci&oacute;n";
											$oAux["fechaAudienciaRaw"]=cambiaraFechaMysql($arrFechas[1]);
											array_push($arrPuntosAlerta,$oAux);
										}
									}
								}
								
								$consulta="SELECT * FROM 7027_eventosCarpetas WHERE carpetaAdministrativa='".$o["carpetaJudicial"]."' ORDER BY fecha";
								$rEventos=$con->obtenerFilas($consulta);
								while($fEventos=mysql_fetch_assoc($rEventos))
								{

									$oEvento=generarPlantillaEventoCarpeta($nRegistro,$fEventos,"puntoEventoCarpeta");
									
									array_push($arrEventoCarpeta,$oEvento);
									$nRegistro++;
									
								}
								
							}
							
							foreach($arrDatosCarpeta["etapaIntermedia"] as $o)
							{
								if($minFecha=="")
									$minFecha=$o["fechaAudienciaRaw"];
									
								if($maxFecha=="")
									$maxFecha=$o["fechaAudienciaRaw"];
									
								if(strtotime($minFecha)>strtotime($o["fechaAudienciaRaw"]))	
								{
									$minFecha=$o["fechaAudienciaRaw"];
								}
								
								if(strtotime($maxFecha)<strtotime($o["fechaAudienciaRaw"]))	
								{
									$maxFecha=$o["fechaAudienciaRaw"];
								}
								
								if($fEtIntermedia=="")
									$fEtIntermedia=$o["fechaAudienciaRaw"];
								$clase="etapaIntermedia";
								$oElemento=generarPlantillaEvento($nRegistro,$o,$clase);
								if($arrElementos=="")
									$arrElementos=$oElemento;
								else
									$arrElementos.=",".$oElemento;
								$nRegistro++;
								
								$consulta="SELECT * FROM 7027_eventosCarpetas WHERE carpetaAdministrativa='".$o["carpetaJudicial"]."' ORDER BY fecha";
								$rEventos=$con->obtenerFilas($consulta);
								while($fEventos=mysql_fetch_assoc($rEventos))
								{

									$oEvento=generarPlantillaEventoCarpeta($nRegistro,$fEventos,"puntoEventoCarpeta");
									
									array_push($arrEventoCarpeta,$oEvento);
									$nRegistro++;
									
								}
								
							}
							
							foreach($arrDatosCarpeta["etapaJuicioOral"] as $o)
							{
								if($minFecha=="")
									$minFecha=$o["fechaAudienciaRaw"];
									
								if($maxFecha=="")
									$maxFecha=$o["fechaAudienciaRaw"];
									
								if(strtotime($minFecha)>strtotime($o["fechaAudienciaRaw"]))	
								{
									$minFecha=$o["fechaAudienciaRaw"];
								}
								
								if(strtotime($maxFecha)<strtotime($o["fechaAudienciaRaw"]))	
								{
									$maxFecha=$o["fechaAudienciaRaw"];
								}
								if($fEtJuicioOral=="")
									$fEtJuicioOral=$o["fechaAudienciaRaw"];
								$clase="etapaJuicioOral";
								$oElemento=generarPlantillaEvento($nRegistro,$o,$clase);
								if($arrElementos=="")
									$arrElementos=$oElemento;
								else
									$arrElementos.=",".$oElemento;
								$nRegistro++;
								$consulta="SELECT * FROM 7027_eventosCarpetas WHERE carpetaAdministrativa='".$o["carpetaJudicial"]."' ORDER BY fecha";
								$rEventos=$con->obtenerFilas($consulta);
								while($fEventos=mysql_fetch_assoc($rEventos))
								{

									$oEvento=generarPlantillaEventoCarpeta($nRegistro,$fEventos,"puntoEventoCarpeta");
									
									array_push($arrEventoCarpeta,$oEvento);
									$nRegistro++;
									
								}
							}
							
							foreach($arrDatosCarpeta["etapaEjecucion"] as $o)
							{
								if($minFecha=="")
									$minFecha=$o["fechaAudienciaRaw"];
									
								if($maxFecha=="")
									$maxFecha=$o["fechaAudienciaRaw"];
									
								if(strtotime($minFecha)>strtotime($o["fechaAudienciaRaw"]))	
								{
									$minFecha=$o["fechaAudienciaRaw"];
								}
								
								if(strtotime($maxFecha)<strtotime($o["fechaAudienciaRaw"]))	
								{
									$maxFecha=$o["fechaAudienciaRaw"];
								}
								if($fEtEjecucion=="")
									$fEtEjecucion=$o["fechaAudienciaRaw"];
								$clase="etapaEjecucion";
								$oElemento=generarPlantillaEvento($nRegistro,$o,$clase);
								if($arrElementos=="")
									$arrElementos=$oElemento;
								else
									$arrElementos.=",".$oElemento;
								$nRegistro++;
								$consulta="SELECT * FROM 7027_eventosCarpetas WHERE carpetaAdministrativa='".$o["carpetaJudicial"]."' ORDER BY fecha";
								$rEventos=$con->obtenerFilas($consulta);
								while($fEventos=mysql_fetch_assoc($rEventos))
								{

									$oEvento=generarPlantillaEventoCarpeta($nRegistro,$fEventos,"puntoEventoCarpeta");
									
									array_push($arrEventoCarpeta,$oEvento);
									$nRegistro++;
									
								}
							}
							
							
							foreach($arrPuntosAlerta as $o)
							{
								
								if($minFecha=="")
									$minFecha=$o["fechaAudienciaRaw"];
									
								if($maxFecha=="")
									$maxFecha=$o["fechaAudienciaRaw"];
									
								if(strtotime($minFecha)>strtotime($o["fechaAudienciaRaw"]))	
								{
									$minFecha=$o["fechaAudienciaRaw"];
								}
								
								if(strtotime($maxFecha)<strtotime($o["fechaAudienciaRaw"]))	
								{
									$maxFecha=$o["fechaAudienciaRaw"];
								}
								$oElemento=" {
												id: ".$nRegistro.", 
												content: '<img src=\"../images/warning_1.png\">".$o["etiqueta"]."', 
												start: '".$o["fechaAudienciaRaw"]."',
												className:'puntoAlerta'
											}";
								if($arrElementos=="")
									$arrElementos=$oElemento;
								else
									$arrElementos.=",".$oElemento;
								$nRegistro++;
							}
							
							foreach($arrEventoCarpeta as $o)
							{
								
								$oE=json_decode($o);
								if($minFecha=="")
									$minFecha=$E->start;
									
								if($maxFecha=="")
									$maxFecha=$oE->start;
									
								if(strtotime($minFecha)>strtotime($oE->start))	
								{
									$minFecha=$oE->start;
								}
								
								if(strtotime($maxFecha)<strtotime($oE->start))	
								{
									$maxFecha=$oE->start;
								}
								$oElemento='{"id":"'.$oE->id.'","content":"'.bD($oE->content).'","start":"'.$oE->start.'","className":"'.$oE->className.'"}';
								if($arrElementos=="")
									$arrElementos=$oElemento;
								else
									$arrElementos.=",".$oElemento;
								
							}
							
							$arrEventoVarios=obtenerEventosVariosCarpeta($cJudicial,$nRegistro);
							
							foreach($arrEventoVarios as $o)
							{
								
								$oE=$o;
								if($minFecha=="")
									$minFecha=$E->start;
									
								if($maxFecha=="")
									$maxFecha=$oE->start;
									
								if(strtotime($minFecha)>strtotime($oE->start))	
								{
									$minFecha=$oE->start;
								}
								
								if(strtotime($maxFecha)<strtotime($oE->start))	
								{
									$maxFecha=$oE->start;
								}
								$oElemento='{"id":"'.$oE->id.'","content":"'.bD($oE->content).'","start":"'.$oE->start.'","className":"'.$oE->className.'"}';
								if($arrElementos=="")
									$arrElementos=$oElemento;
								else
									$arrElementos.=",".$oElemento;
								
							}
							//echo $arrElementos;

							$datosCarpeta=obtenerDatosSujetosProcesalesDelitosCarpetaAdministrativa($cJudicial);

							$lblImputados="";
							foreach($datosCarpeta["Imputados"] as $i)
							{
								$oImputado="<a href='javascript:abrirFichaParticipante(\"".bE($i["idRegistro"])."\")'>".$i["nombre"]." ".$i["apellidoPaterno"]." ".$i["apellidoMaterno"]."</a>";
								if($lblImputados=="")
									$lblImputados=$oImputado;
								else
									$lblImputados.="<br>".$oImputado;
							}
							
							
							$lblVictimas="";
							foreach($datosCarpeta["Víctimas"] as $v)
							{
								$oVictima="<a href='javascript:abrirFichaParticipante(\"".bE($v["idRegistro"])."\")'>".$v["nombre"]." ".$v["apellidoPaterno"]." ".$v["apellidoMaterno"]."</a>";
								if($lblVictimas=="")
									$lblVictimas=$oVictima;
								else
									$lblVictimas.="<br>".$oVictima;
							}
							
							$lblDelitos="";
							foreach($datosCarpeta["delitos"] as $d)
							{
								
								if($lblDelitos=="")
									$lblDelitos=$d["denominacionDelito"];
								else
									$lblDelitos.="<br>".$d["denominacionDelito"];
							}
							
							
							
							
							if($minFecha=="")
								$minFecha=date("Y-m-d");
							
							if($maxFecha=="")
								$maxFecha=date("Y-m-d");
								
							$minFecha=date("Y-m-d",strtotime("-120 days",strtotime($minFecha)));
							$maxFecha=date("Y-m-d",strtotime("+120 days",strtotime($maxFecha)));
							
							
							
							
						?>
                        
                        		
                                <table width="100%" class="tblMarco">
                                <tr>
                                	<td colspan="2">
                                    	<table>
                                        <tr height="21">
                                        	<td width="20">
                                            	<img src="../images/folder_table.png" />
                                            </td>
                                            <td width="130"><b>
                                                Carpeta Judicial:
                                                </b>
                                            </td>
                                            <td colspan="5">
                                            	<a href="javascript:abrirCarpetaJudicial('<?php echo bE($cJudicial)?>')" style="color:#900; font-weight:bold">
                                            	<?php
													echo $cJudicial;
												?>	
                                                </a>
                                            </td>
                                        </tr>
                                        <tr height="21">
                                        	<td width="20">
                                            	<img src="../images/vcard.png" />
                                            </td>
                                            <td><b>
                                                Hecho Delitivo:
                                                </b>
                                            </td>
                                            <td colspan="5">
                                            	<?php
													echo $lblDelitos;
													
												?>
                                            </td>
                                        </tr>
                                        <tr height="21">
                                        	<td width="20">
                                            	<img src="../images/user_gray.png" />
                                            </td>
                                            <td><b>
                                                Imputados:
                                                </b>
                                            </td>
                                            <td width="350">
                                            	<?php
													echo $lblImputados;
												?>
                                            </td>
                                            <td width="20">
                                            </td>
                                            <td width="20">
                                            	<img src="../images/user.png" />
                                            </td>
                                            <td><b>
                                                Victimas:
                                                </b>
                                            </td>
                                            <td width="350">
                                            	<?php
													echo $lblVictimas;
												?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td colspan="10">
                                            <br />
                                            	<table>
                                                	<tr>
                                                    	<td><span id="btnExpandAll"></span></td>
                                                        <td><span id="btnColapsAll"></span></td>
                                                        <td><span id="btnEtapaInicial"></span></td>
                                                        <td><span id="btnEtapaIntermedia"></span></td>
                                                        <td><span id="btnEtapaJuicioOral"></span></td>
                                                        <td><span id="btnEtapaEjecucion"></span></td>
                                                    </tr>
                                                </table>
                                            	
                                            </td>
                                        </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                </table><br />
                                <table width="100%">
                                <td width="30">
                                </td>
                                <td>
                                	<div id="visualization"></div>
                                </td>
                                </tr>
                                </table>
                                
                               
                                <input type="hidden" id="arrElementos" value="<?php echo bE($arrElementos)?>" />
                        		<input type="hidden" id="totalRegistro" value="<?php echo $nRegistro?>" />
                                <input type="hidden" id="minFecha" value="<?php echo $minFecha?>" />
                                <input type="hidden" id="maxFecha" value="<?php echo $maxFecha?>" />
                                
                                <input type="hidden" id="fEtInicial" value="<?php echo $fEtInicial?>" />
                                <input type="hidden" id="fEtIntermedia" value="<?php echo $fEtIntermedia?>" />
                                <input type="hidden" id="fEtJuicioOral" value="<?php echo $fEtJuicioOral?>" />
                                <input type="hidden" id="fEtEjecucion" value="<?php echo $fEtEjecucion?>" />
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
