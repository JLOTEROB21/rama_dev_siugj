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
                        <td>
                        <?php
						
						
							$arrEtapasPredefinidas=array();
							$oEtapa=array();
							$oEtapa[0]="900";
							$oEtapa[1]="Nómina timbrada";
							$oEtapa[2]="";
							array_push($arrEtapasPredefinidas,$oEtapa);
							$oEtapa=array();
							$oEtapa[0]="1000";
							$oEtapa[1]="Nómina autorizada";
							$oEtapa[2]="";
							array_push($arrEtapasPredefinidas,$oEtapa);
							
							$idPerfil=-1;
							if(isset($objParametros->idPerfil))
								$idPerfil=$objParametros->idPerfil;
							$arrEtapas="";
							$consulta="SELECT noEtapa,nombreEtapa FROM 662_etapasNomina WHERE idPerfil=".$idPerfil." ORDER BY  noEtapa";
							$rEtapas=$con->obtenerFilas($consulta);
							while($fEtapa=mysql_fetch_row($rEtapas))
							{
								$oEtapa="['".removerCerosDerecha($fEtapa[0])."','".removerCerosDerecha($fEtapa[0]).".- ".cv($fEtapa[1])."']";
								if($arrEtapas=="")
									$arrEtapas=$oEtapa;
								else
									$arrEtapas.=",".$oEtapa;
							}
							
							$arrEtapas="[".$arrEtapas."]";
							$consulta="select nombrePerfil from 662_perfilesNomina where idPerfilesNomina=".$idPerfil;
							$perfil=$con->obtenerValor($consulta);
							
							$posEtapa=0;
							foreach($arrEtapasPredefinidas as $oEtapa)
							{
							
								$idEtapaFinal="-1";
								$consulta="SELECT idEtapa FROM 662_etapasNomina WHERE idPerfil=".$idPerfil." AND noEtapa=".$oEtapa[0];
								$idEtapaFinal=$con->obtenerValor($consulta);
								if($idEtapaFinal=="")
								{
									$consulta="INSERT INTO 662_etapasNomina(nombreEtapa,noEtapa,idPerfil)VALUES ('".$oEtapa[1]."',".$oEtapa[0].",".$idPerfil.")";
									if($con->ejecutarConsulta($consulta))
									{
										$idEtapaFinal=$con->obtenerUltimoID($consulta);
									}
								}
								
								$arrEtapasPredefinidas[$posEtapa][2]=$idEtapaFinal;
								$posEtapa++;
							}
						?>
                        
                        <span class="tituloPaginas">Escenario del perfil: <span class="letraRojaSubrayada8" style="font-size:14px"><?php echo $perfil?></span></span><br /><br />
                        <table >
                        <tr>
                            <td bgcolor="" class="" ></td>
                            <td align="center">
                                <table >
                                <tr>
                                    <td width="260" align="center" class="valorFicha"><span class="corpo8_bold">Actor</span></td>
                                    <td width="680" align="center" class="valorFicha"><span class="corpo8_bold">Acción</span></td>
                                    
                                    
                                </tr>
                                <tr >
                                        <td colspan="2" class="etiquetaFicha" align="left">
                                            <table width="100%">
                                                    <tr>
                                                        <td align="left">
                                                        	<span class="letraRojaSubrayada8">
															Inicio</span>&nbsp;&nbsp;<a href='javascript:window.parent.agregarActor("<?php echo bE(0)?>")'><img src="../images/user_add.png" alt="Agregar Actor" title="Agregar actor" /></a>                                                            
                                                            
                                                        </td>
                                                        <td align="right">
                                                            
                                                        </td>
                                                    </tr>
                                               </table>

                                        
                                        
                                        </td>
                                    </tr>
                                <?php
                                    $consulta="SELECT idActorEtapaNomina,actor,tipoActor FROM 662_actoresEtapaNomina WHERE idPerfil=".$idPerfil." AND etapa=0";
									$resActores=$con->obtenerFilas($consulta);
									while($filaActores=mysql_fetch_row($resActores))
									{	
										$nomActor="";
										if($filaActores[2]==1)
										{
											$nomActor="<b>Rol:</b> ".obtenerTituloRol($filaActores[1]);
										}
							?>
							
								<tr>
									<td width="260" valign="top" align="left" class="valorFicha"><span class="letraExt"><?php echo $nomActor?></span>&nbsp;&nbsp;<a href="javascript:window.parent.removerActorEtapa('<?php echo bE($filaActores[0])?>')"><img src="../images/cancel_round.png" title="Remover actor de la etapa" alt="Remover actor de la etapa"/></a></td>
									<td width="680" align="center" class="valorFicha"><span class="letraExt">
									<table width="100%">
										<tr>
											<td align="right"><a href="javascript:window.parent.agregarAccion('<?php echo bE($filaActores[0])?>',2)"><img src="../images/addAccion.png" title="Agregar acción" alt="Agregar acción" /></a></td>
										</tr>
										<tr>
											<td>
												<table width="100%">
												<?php
													$consulta="SELECT accion,configuracion,idAccionNomina FROM 662_accionesActorEtapaNomina WHERE idActorEtapa=".$filaActores[0];
													$res=$con->obtenerFilas($consulta);
													while($fila=mysql_fetch_row($res))
													{
														$accion="";
														
														switch($fila[0])
														{
															case 1:
																$accion="Ver Nóminas";
															break;
															case 2:
																$accion="Calcular N&oacute;mina";
															break;
															case 3:
																$accion="Evaluar Nómina";
															break;
															case 4:
																$accion="Eliminar Nómina";
															break;
															case 5:
																$accion="Crear Nómina";
															break;
															case 6:
																$accion="Modifica Par&aacute;metros de N&oacute;mina";
															break;
															case 7:
																$accion="Modifica Fecha de Pago";
															break;
															case 8:
																$accion="Modifica Fecha de Pago Individual";
															break;
															case 9:
																$accion="Marcar Registros para NO ser Timbrados";
															break;
															case 10:
																$accion="Recalcular Nómina";
															break;
															case 11:
																$accion="Calcular/Recalcular N&oacute;mina Individual";
															break;
														}
														$ambito="No aplica";
														$obj=NULL;
														if($fila[1]!="")
														{
															
															$obj=json_decode($fila[1]);
															switch($obj->ambitoAccion)
															{
																case 1:
																	$ambito="Nóminas generadas por el usuario";
																break;
																case 2:
																	$ambito="Nóminas pertenecientes a la institución del usuario";
																break;
																case 3:
																	$ambito="Nóminas pertenecientes a la institución y subinstituciones del usuario";
																break;
																case 4:
																	$ambito="Nóminas pertenecientes a instituciones especificadas";
																break;
																case 5:
																	$ambito="Todas las nóminas";
																break;
															}
															$idAccion=$obj->ambitoAccion;
														}
												?>
													<tr>
														<td >
															<fieldset class="frameHijo"><legend><?php echo $accion?>&nbsp;&nbsp;<a href="javascript:window.parent.removerAccion('<?php echo bE($fila[2])?>')"><img src="../images/delete.png" alt="Remover acci&oacute;n" title="Remover acci&oacute;n" /></a></legend>
															<table width="100%">	
																<tr>
																	<td width="120" valign="top"><span class="corpo8_bold">Ámbito de la acción:</span></td>
																	<td valign="top">
																	<span class="letraExt" style="LINE-HEIGHT: 150%;"><?php echo $ambito ?></span>&nbsp;<!--<a href="javascript:window.parent.modificarAmbito('<?php echo bE($fila[2])?>','<?php echo bE($idAccion)?>')"><img src="../images/pencil.png" alt="Modificar ámbito de la acci&oacute;n" title="Modificar ámbito de la acci&oacute;n" /></a>-->
																	</td>
																</tr>
                                                                
                                                                
                                                                <?php
																	if(($obj!=NULL)&&($obj->ambitoAccion==4))
																	{
																?>
																<tr>
																	<td colspan="2" align="left">
																	<span class="corpo8_bold">
																	Instituciones sobre las cuales aplica la acci&oacute;n:
																	</span>
																	<table>
																<?php
																		$arrInstituciones=explode(",",$obj->arrInstituciones);
																		foreach($arrInstituciones as $i)
																		{
																			$consulta="select unidad from 817_organigrama where codigoUnidad='".$i."'";
																			$unidad=$con->obtenerValor($consulta);
																?>
																
																		<tr>
																			<td width="20">
																			<img src="../images/bullet_green.png" />
																			</td>
																			<td>
																			<span class="letraExt"><?php echo $unidad?></span>
																			</td>
																		</tr>
																   
																<?php
																		}
																?>
																 </table>
																	</td>
																</tr>
																<?php
																		
																	}
																	
																	if($fila[0]==3)
																	{
															?>
																<tr>
																	<td colspan="2" align="left">
																		<span class="corpo8_bold">
																		Opciones de dictámen:&nbsp;<a href="javascript:window.parent.mostrarVentanaOpcionesDictamen('<?php echo bE($fila[2])?>')"><img src="../images/pencil.png"  title="Modificar opciones de dictámen" alt=="Modificar opciones de dictámen" /></a>
																		</span>
																	</td>
																</tr>
															
															<?php
																		
																	}
															?>
                                                                
                                                                
															</table>
															</fieldset><br /><br />
														
														</td>
													</tr>
                                                  <?php
												
													}
												?>
												</table>
											</td>
										</tr>
									</table>
									</span></td>
									
									
								</tr>
								
							<?php
										
										
									}
                                    ?>
                                <?php
									$consulta="SELECT idEtapa,noEtapa,nombreEtapa FROM 662_etapasNomina WHERE idPerfil=".$idPerfil." and noEtapa not in (0) ORDER BY noEtapa";
									$resEtapas=$con->obtenerFilas($consulta);
								
									while($fila=mysql_fetch_row($resEtapas))
									{
										
								?>
                                	<tr >
                                        <td colspan="2" class="etiquetaFicha" align="left">
                                        	<table width="100%">
                                            	<tr>
                                                	<td align="left">
                                                        <a href='javascript:window.parent.removerEtapa("<?php echo bE($fila[1])?>")'>
                                                        <img src="../images/delete.png" title="Remover etapa" alt="Remover etapa" />&nbsp;&nbsp;
                                                        </a>
                                                        <span class="letraRojaSubrayada8">
                                                        <?php echo removerCerosDerecha($fila[1]).".- ".$fila[2]?></span>&nbsp;&nbsp;<a href='javascript:window.parent.agregarEtapa("<?php echo bE($fila[0])?>","<?php echo bE($fila[1])?>","<?php echo bE($fila[2])?>")'><img src="../images/pencil.png" alt="Modificar datos de etapa" title="Modificar datos de etapa" /></a>&nbsp;&nbsp;<a href='javascript:window.parent.agregarActor("<?php echo bE($fila[1])?>")'><img src="../images/user_add.png" alt="Agregar Actor" title="Agregar actor" /></a>
                                        			</td>
                                                    <td align="right">
	                                                   	<a href="javascript:window.parent.configurarDisparador('<?php echo bE($fila[0])?>')"><img src="../images/lightning_add.png" title="Configurar disparadores" alt="Configurar disparadores" /></a>
                                                    </td>
                                                </tr>
                                           </table>
                                        </td>
                                        
                                    </tr>
                                <?php
								
										$consulta="SELECT idActorEtapaNomina,actor,tipoActor FROM 662_actoresEtapaNomina WHERE idPerfil=".$idPerfil." AND etapa=".$fila[1];
										$resActores=$con->obtenerFilas($consulta);
										while($filaActores=mysql_fetch_row($resActores))
										{	
											$nomActor="";
											if($filaActores[2]==1)
											{
												$nomActor="<b>Rol:</b> ".obtenerTituloRol($filaActores[1]);
											}
								?>
                                
                                	<tr>
                                        <td width="260" valign="top" align="left" class="valorFicha"><span class="letraExt"><?php echo $nomActor?></span>&nbsp;&nbsp;<a href="javascript:window.parent.removerActorEtapa('<?php echo bE($filaActores[0])?>')"><img src="../images/cancel_round.png" title="Remover actor de la etapa" alt="Remover actor de la etapa"/></a></td>
                                        <td width="680" align="center" class="valorFicha"><span class="letraExt">
                                        <table width="100%">
                                        	<tr>
                                            	<td align="right"><a href="javascript:window.parent.agregarAccion('<?php echo bE($filaActores[0])?>',1)"><img src="../images/addAccion.png" title="Agregar acción" alt="Agregar acción" /></a></td>
                                            </tr>
                                            <tr>
                                            	<td>
                                                	<table width="100%">
                                                    <?php
														$consulta="SELECT accion,configuracion,idAccionNomina FROM 662_accionesActorEtapaNomina WHERE idActorEtapa=".$filaActores[0];
														$res=$con->obtenerFilas($consulta);
														while($fila=mysql_fetch_row($res))
														{
															$accion="";
															
															switch($fila[0])
															{
																case 1:
																	$accion="Ver Nóminas";
																break;
																case 2:
																	$accion="Calcular N&oacute;mina";
																break;
																case 3:
																	$accion="Dictaminar Nómina";
																break;
																case 4:
																	$accion="Eliminar Nómina";
																break;
																case 5:
																	$accion="Cancelar Timbrado Individual";
																break;
																case 6:
																	$accion="Modifica Par&aacute;metros de N&oacute;mina";
																break;
																case 7:
																	$accion="Modifica Fecha de Pago";
																break;
																case 8:
																	$accion="Modifica Fecha de Pago Individual";
																break;
																case 9:
																	$accion="Marcar Registros para NO ser Timbrados";
																break;
																case 10:
																	$accion="Recalcular Nómina";
																break;
																case 11:
																	$accion="Calcular/Recalcular N&oacute;mina Individual";
																break;
																
															}
															$ambito="No especificado";
															$idAccion="";
															$obj=NULL;
															$mostrarBtnModificar=true;
															if($fila[1]!="")
															{
																
																$obj=json_decode($fila[1]);
																switch($obj->ambitoAccion)
																{
																	case 1:
																		$ambito="Nóminas generadas por el usuario";
																	break;
																	case 2:
																		$ambito="Nóminas pertenecientes a la institución del usuario";
																	break;
																	case 3:
																		$ambito="Nóminas pertenecientes a la institución y subinstituciones del usuario";
																	break;
																	case 4:
																		$ambito="Nóminas pertenecientes a instituciones especificadas";
																	break;
																	case 5:
																		$ambito="Todas las nóminas";
																	break;
																	case 7:
																		$ambito="Pertenecientes al centro de costo del usuario";
																	break;
																	
																}
																$idAccion=$obj->ambitoAccion;
															}
															else
															{
																switch($fila[0])
																{
																	/*case 8:
																		$ambito="No aplica";
																		$mostrarBtnModificar=false;
																	break;	*/
																}
															}
													?>
                                                    	<tr>
                                                        	<td >
                                                            	<fieldset class="frameHijo"><legend><?php echo $accion?>&nbsp;&nbsp;<a href="javascript:window.parent.removerAccion('<?php echo bE($fila[2])?>')"><img src="../images/delete.png" alt="Remover acci&oacute;n" title="Remover acci&oacute;n" /></a></legend>
                                                            	<table width="100%">	
                                                                	<tr>
                                                                    	<td width="140" valign="top"><span class="corpo8_bold">Ámbito de la acción:</span></td>
                                                                        <td valign="top">
                                                                        <span class="letraExt" style="LINE-HEIGHT: 150%;">
																			<?php echo $ambito ?>
                                                                         </span>&nbsp;
                                                                         <?php
																		 	$lblDatosComplementarios="";
																		 	if($mostrarBtnModificar)
																			{
																				if($fila[0]!=2)
																				{
																		 ?>
                                                                         <a href="javascript:window.parent.modificarAmbito('<?php echo bE($fila[2])?>','<?php echo bE($idAccion)?>')"><img src="../images/pencil.png" alt="Modificar ámbito de la acci&oacute;n" title="Modificar ámbito de la acci&oacute;n" /></a>
                                                                         <?php
																				}
																				else
																				{
																			 
																			 
																			 		$etapaCambio=0;
																					$lblDatosComplementarios="No Cambia Etapa";
																					if(isset($obj->etapaCambio))
																					{
																						$etapaCambio=removerCerosDerecha($obj->etapaCambio);

																						$consulta="SELECT noEtapa,nombreEtapa FROM 662_etapasNomina WHERE idPerfil=".$idPerfil." and noEtapa=".$obj->etapaCambio." ORDER BY  noEtapa";
																						$fRegistroEtapa=$con->obtenerPrimeraFila($consulta);
																						

																						$lblDatosComplementarios="Cambia a etapa: ".removerCerosDerecha($fRegistroEtapa[0]).".- ".cv($fRegistroEtapa[1]);
																						
																					}
																					
																					echo " ($lblDatosComplementarios) " ;
																			 ?>
                                                                         <a href="javascript:window.parent.modificarAmbitoEnvioEtapa('<?php echo bE($fila[2])?>','<?php echo bE($idAccion)?>','<?php echo bE($arrEtapas)?>','<?php echo bE($etapaCambio)?>')"><img src="../images/pencil.png" alt="Modificar ámbito de la acci&oacute;n" title="Modificar ámbito de la acci&oacute;n" /></a>
                                                                         <?php
																				}
																			}
																		 ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
																		if(($obj!=NULL)&&($obj->ambitoAccion==4))
																		{
																	?>
                                                                    <tr>
                                                                    	<td colspan="2" align="left">
                                                                        <span class="corpo8_bold">
                                                                        Instituciones sobre las cuales aplica la acci&oacute;n:
                                                                        </span>
                                                                        <table>
                                                                    <?php
																			$arrInstituciones=explode(",",$obj->arrInstituciones);
																			foreach($arrInstituciones as $i)
																			{
																				$consulta="select unidad from 817_organigrama where codigoUnidad='".$i."'";
																				$unidad=$con->obtenerValor($consulta);
																	?>
                                                                    
                                                                        	<tr>
                                                                            	<td width="20">
                                                                                <img src="../images/bullet_green.png" />
                                                                                </td>
                                                                                <td>
                                                                                <span class="letraExt"><?php echo $unidad?></span>
                                                                                </td>
                                                                            </tr>
                                                                       
                                                                    <?php
																			}
																	?>
                                                                     </table>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
		
																				
																		}
																		
																		if($fila[0]==3)
																				{
																		?>
																			<tr>
																				<td colspan="2" align="left">
																					<span class="corpo8_bold">
																					Opciones de dictámen:&nbsp;<a href="javascript:window.parent.mostrarVentanaOpcionesDictamen('<?php echo bE($fila[2])?>')"><img src="../images/pencil.png"  title="Modificar opciones de dictámen" alt=="Modificar opciones de dictámen"/></a>
																					</span>
                                                                                     <table >
                                                                            		<tr>
                                                                                    	<td width="250" align="center" class="fondoVerde7">
                                                                                        Dictámen
                                                                                        </td>
                                                                                        <td width="350" align="center" class="fondoVerde7">
                                                                                        Pasa a etapa:
                                                                                        </td>
                                                                                    </tr>
                                                                                	<?php
																						if(isset($obj->arrOpciones))
																						{
																							$cadOpciones=bD($obj->arrOpciones);
																							
																							$cadAux='{"opciones":['.$cadOpciones.']}';
																							$objAux=json_decode($cadAux);
																							foreach($objAux->opciones as $o)
																							{
																									
																						?>
                                                                                        <tr>
                                                                                            <td class="fondoGrid7">
                                                                                            <?php
																								echo $o->columna[0]->texto;
																							?>
                                                                                            </td>
                                                                                            <td class="fondoGrid7">
                                                                                            <?php
																								$consulta="SELECT nombreEtapa FROM 662_etapasNomina WHERE idPerfil=".$idPerfil." and noEtapa =".$o->etapa."";
																								$nEtapa=$con->obtenerValor($consulta);
																								echo removerCerosDerecha($o->etapa).".- ".$nEtapa;
																							?>
                                                                                            </td>
                                                                            			</tr>
                                                                                        <?php		
																							}
																						}
																					?>
                                                                                
                                                                            	</table>
																				</td>
																			</tr>
																		
																		<?php
																					
																				}
																	?>	
                                                                </table>
                                                                </fieldset><br /><br />
                                                            
                                                            </td>
                                                        </tr>
                                                    <?php
														}
													?>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        </span></td>
                                        
                                        
                                    </tr>
                                	
                                <?php
											
											
										}
								
									}
									
									
                                    ?>
                                </table>
                         	</td>
                         </tr>
                         </table>
                         <input type="hidden" id="arrEtapas" value="<?php echo bE($arrEtapas)?>"  />      
                        
                        
                       
                        
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
