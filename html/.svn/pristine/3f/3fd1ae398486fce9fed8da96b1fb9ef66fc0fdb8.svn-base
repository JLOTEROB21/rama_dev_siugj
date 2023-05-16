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
	$mostrarMenuIzq=false;
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
	$procesoName="comites";
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
                        <td align="center">
                        <?php
							$idComite=$objParametros->idComite;
							$consulta="select nombreComite from 2006_comites where idComite=".$idComite;
							$nomComite=$con->obtenerValor($consulta);
						?>
                        <table>
                        	<tr>
                            	<td align="center">
                                	<span class="tituloPaginas">
                                	Procesos vinculados al comite: <font color="green"><?php echo $nomComite?></font>
                                    <br /><br /><br /><br />
                                    </span>
                                </td>
                            </tr>
                            <tr>
                            <td>
                            	
								<?php
                                    
                                    $consulta="select idProyecto,agregarFrm from 235_proyectosVSComites where idComite=".$idComite;
                                    $res=$con->obtenerFilas($consulta);

                                    while($fila=mysql_fetch_row($res))
                                    {
										$idProceso=$fila[0];
										$agregarFrm=$fila[1];
										$consulta="select nombre,descripcion,sp.situacion,p.idTipoProceso,p.situacion from 4001_procesos p,940_situacionesProceso sp 
										where sp.valor=p.situacion and sp.tipoProceso=p.idTipoProceso and sp.idIdioma=".$_SESSION["leng"]." and p.idProceso=".$fila[0];
										$fP=$con->obtenerPrimeraFila($consulta);
										$situacionProc=$fP[4];
										switch($fP[3])
										{
											case 3:
												$tipo="Proyecto";
											break;
											case 4:
												$tipo="CV";
											break;
											case 5:
												$tipo="Convenio"
											default:
												$tipo="No especificado";
										}
										
                                 ?>
                                 		<table>
                                 		<tr>
                                        	<td width="110" class="esquinaFicha"><span class="corpo8_bold">Proceso:</span></td><td width="550" class="valorFicha"><span class="speaker"><?php echo $fP[0]?></span></td>
                                        </tr>
                                        <tr>
                                        	<td class="etiquetaFicha"><span class="corpo8_bold">Tipo:</span></td><td class="valorFicha"><span class="corpo8"><?php echo $tipo?></span></td>
                                        </tr>
                                         <tr>
                                        	<td class="etiquetaFicha" valign="top"><span class="corpo8_bold">Descripción:</span></td><td class="valorFicha"><span class="corpo8"><?php echo $fP[1]?></span></td>
                                        </tr>
                                         <tr>
                                        	<td class="etiquetaFicha"><span class="corpo8_bold">Situación:</span></td><td class="valorFicha"><span class="corpo8"><?php echo $fP[2]?></span></td>
                                        </tr>
                                        <tr>
                                           	<td class="etiquetaFicha" colspan="2"><span class="corpo8_bold">Elementos del proceso asociados al comite (Por etapa):</span>
                                            
                                        </tr>
                                        <tr>
                                           	<td class="valorFicha" colspan="2">
                                            	<table>
                                            
                                            <?php
												$consulta="select e.nombreEtapa,pe.idProyectoVSComiteVSEtapa,pe.numEtapa from 234_proyectosVSComitesVSEtapas pe,4037_etapas e where e.numEtapa=pe.numEtapa and e.idProceso=pe.idProyecto and pe.idProyecto=".$fila[0]." and idComite=".$idComite. " order by pe.numEtapa";
												$resEtapa=$con->obtenerFilas($consulta);
												while($filaEtapa=mysql_fetch_row($resEtapa))
												{
													$btnAgregar="";
													if(($agregarFrm=="1")&&($situacionProc=="1")&&(isset($permisosArray["F"])))
													{
														$btnAgregar="<a href='javascript:agregarFormulario(".$fila[0].",".$filaEtapa[2].",".$filaEtapa[1].")'><img src='../images/form_add.png' title='Agregar formulario a esta etapa'></a>";
													}
											?>
                                            		<tr height="23">
                                                    	<td colspan="2">
                                                        	<span class="letraRojaSubrayada8"><?php echo $filaEtapa[0]?>:</span>&nbsp;&nbsp;<?php echo $btnAgregar?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="50" align="right" valign="middle">
                                                        <img src="../images/bullet_green.png" />
                                                        </td>
                                                        <td >
                                                        	<br /><span class="corpo8_bold"><u>
                                                        	Elementos del proceso asignados al comit&eacute;</u>
                                                            </span>
                                                            <br /><br />
                                                            
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td colspan="2">
                                                        	<table>
															<?php
                                                                    $query="select e.idProyectoComiteElementosDTD,f.nombreFormulario,e.funciones,f.tipoFormulario,f.complementario,f.idFormulario from 245_proyectosComitesElementosDTD e,203_elementosDTD eD,900_formularios f 
                                                                            where  eD.idElementoDTD=e.idElemento and f.idFormulario=eD.idFormulario and e.idProyectoComite=".$filaEtapa[1];
                                                                    $resM=$con->obtenerFilas($query);
                                                                    while($filaM=mysql_fetch_row($resM))
                                                                    {
                                                                        $funcion="<font color='darkred'>Sólo lectura</font>";
                                                                        if($filaM[2]=="1")
                                                                            $funcion="<font color='blue'>Revisar y dictaminar</font>";
                                                                        $btnAccion="";														
                                                                        if(($filaM[3]=="11")&&($filaM[4]==$idComite))
                                                                            $btnAccion="&nbsp;<a href='javascript:modificarFormulario(".$filaM[5].")'><img src='../images/pencil_go.png' title='Modificar formulario' alt='Modificar formulario'></a>&nbsp;&nbsp;<a href='javascript:eliminarFormulario(".$filaM[5].")'><img src='../images/delete.png' title='Eliminar formulario' alt='Eliminar formulario'></a>";
                                                                ?>
                                                                        <tr height="23" id="fila_<?php echo $filaM[5]?>">
                                                                            <td width="115" align="right" valign="middle"><img src="../images/bullet_red.png" /></td><td><span class="copyrigth"><?php echo $filaM[1]." (<font color='black'><b>Función</b></font>: ".$funcion.")" ?> </span>&nbsp;<?php echo $btnAccion?></td>
                                                                        </tr>
                                                            <?php														
                                                                    }
                                                                    echo "<tr><td colspan='2'><br></td></tr>";
                                                            
                                                                
                                                            ?>		
                                                                    
                                                                    </table>
                                                                    </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="50" align="right" valign="middle">
                                                                        <img src="../images/bullet_green.png" />
                                                                        </td>
                                                                        <td >
                                                                            <br /><span class="corpo8_bold"><u>
                                                                            Acciones asignadas al comit&eacute; para esta etapa:</u>
                                                                            </span>
                                                                            <br /><br />
                                                                            
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                    	<td width="115" align="right" valign="middle">
                                                                        
                                                                        </td>
                                                                        <td colspan="">
                                                                        
                                                                        
                                                                            <table width="100%">
                                                                        <?php
																		

																			$consulta="select idActorProcesoEtapa from 944_actoresProcesoEtapa ac,234_proyectosVSComitesVSEtapas ce where 
																						ce.idProyectoVSComiteVSEtapa=ac.actor and ac.numEtapa=".$filaEtapa[2]." and 
																						ac.idProceso=".$fila[0]." and ac.tipoActor=2 and ce.idComite=".$idComite;
																			
																			$idActorProcesoEtapa=$con->obtenerValor($consulta);
                                                                            $consulta="select ap.idAccionesProcesoEtapaVSAcciones,aa.accion,aa.idGrupoAccion,ap.complementario,ap.complementario2 from 947_actoresProcesosEtapasVSAcciones ap,945_accionesActor aa where aa.idGrupoAccion=ap.idGrupoAccion and aa.idIdioma=".$_SESSION["leng"]." and idActorProcesoEtapa=".$idActorProcesoEtapa;
                                                                            
                                                                            $resPA=$con->obtenerFilas($consulta);
                                                                            while($filaPA=mysql_fetch_row($resPA))
                                                                            {
                                                                                $estiloMarco="";
                                                                                if(($filaPA[2]=="5")||($filaPA[2]=="4")||($filaPA[2]=="3"))
                                                                                    $estiloMarco="filaMarco";
                                                                                    
                                                                                    
                                                                    ?>
                                                                            <tr height="25" id="filaAccion_<?php echo  $filaPA[0] ?>" >
                                                                                <td colspan="2"class="<?php echo $estiloMarco?>" >
                                                                                <img src="../images/bullet_red.png" />&nbsp;
                                                                                <span class="copyrigth" ><b>
                                                                                <?php
                                                                                    echo $filaPA[1];
                                                                                ?></b>
                                                                                </span>&nbsp;&nbsp;
                                                                                
                                                                                <span id="tblEtapas_<?php echo $filaPA[0]?>">
                                                                                <?php
                                                                                    $btnComp="";
                                                                                    switch($filaPA[2])
                                                                                    {
                                                                                        case "1":
                                                                                            if($filaPA[3]=="")
                                                                                                $btnComp="";
                                                                                            else
                                                                                            {
                                                                                                $consulta="select nombreEtapa from 4037_etapas where idProceso=".$idProceso." and numEtapa=".$filaPA[3];
                                                                                                $etapaPasa=$con->obtenerValor($consulta);
                                                                                                  $btnComp="<span class='corpo8'><font color='#000055'><b>Pasa a etapa:</b></font><font color='green'><b> ".$etapaPasa."</b></font></span>&nbsp;&nbsp;";
                                                                                            }
                                                                                            
                                                                                        break;
                                                                                        
                                                                                        case "3":
                                                                                            if($filaPA[3]=="")
                                                                                                $btnComp="<a href='javascript:configurarDictamenRevisor(".$filaPA[0].",".$filaEtapa[2].")'><img src='../images/warning.png' title='Este elemento requiere que se indique los posibles valores de dictamen, para configurarlo de click sobre este ícono' alt='Este elemento requiere que se indique los posibles valores de dictamen, para configurarlo de click sobre este ícono, para configurarlo de click sobre este ícono'></a>";
                                                                                            else
                                                                                            {
                                                                                                $consulta="select idElementoDictamen,idFormulario from 948_actoresVSFormulariosDictamen where idActorVSFormularioDictamen=".$filaPA[3];
                                                                                                
                                                                                                $filaFrm=$con->obtenerPrimeraFila($consulta);
                                                                                                $idFormulario=$filaFrm[1];
                                                                                                $idElemento=$filaFrm[0];
                                                                                                $consulta="(select valor,Contenido from 902_opcionesFormulario of
                                                                                                            where  of.idGrupoElemento=".$idElemento." and of.idIdioma=".$_SESSION["leng"].")
                                                                                                            order by valor";
                                                                                                
                                                                                                
                                                                                                $btnComp="	<br><br><table>
                                                                                                                <tr>
                                                                                                                    <td colspan='2' class='copyrigth'>Resoluciones de dictamen:&nbsp;&nbsp;<a href='javascript:verFormulario(".$idFormulario.")'><img src='../images/icon_code.gif' alt='Configurar formulario de dictamen parcial' title='Configurar formulario de dictamen parcial'></a><br><br></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td width='60' class='fondoVerde7' align='center'>
                                                                                                                    <span class='letraAzulSubrayada7'>C&oacute;digo</span></td>
                                                                                                                    <td width='200' class='fondoVerde7' align='center'>
                                                                                                                    <span class='letraAzulSubrayada7'>Dict&aacute;men</span></td>
                                                                                                                    
                                                                                                                    <td>&nbsp;&nbsp;
                                                                                                                    <a href='javascript:configurarDictamenRevisor(".$filaPA[0].",".$filaEtapa[2].",".$idElemento.")'><img src='../images/pencil.png' alt='Modificar opciones de dictamen' title='Modificar opciones de dictamen'></a>
                                                                                                                    </td>
                                                                                                                </tr>";
                                                                                                $resOpt=$con->obtenerFilas($consulta);
                                                                                                while($filasOpt=mysql_fetch_row($resOpt))
                                                                                                {
                                                                                                    $btnComp.=" <tr>
                                                                                                                    <td class='fondoGrid7'>".$filasOpt[0]."</td><td class='fondoGrid7'>".$filasOpt[1]."</td><td></td>
                                                                                                                </tr>";
                                                                                                }
                                                                                                $btnComp.="
                                                                                                                </table><br><br>		
                                                                                                            ";
                                                                                                
                                                                                            }
                                                                                        break;
                                                                                        
                                                                                        case "4":
                                                                                            if($filaPA[3]=="")
                                                                                                $btnComp="<a href='javascript:configurarDictamenParcial(".$filaPA[0].",".$filaEtapa[2].")'><img src='../images/warning.png' title='Este elemento requiere que se le indique la etapa al cual pasar&aacute; el proceso de acuerdo al dictamen tomado, para configurarlo de click sobre este ícono' alt='Este elemento requiere que se le indique la etapa al cual pasar&aacute; el proceso de acuerdo al dictamen tomado, para configurarlo de click sobre este ícono'></a>";
                                                                                            else
                                                                                            {
                                                                                                $consulta="select idElementoDictamen,idFormulario from 948_actoresVSFormulariosDictamen where idActorVSFormularioDictamen=".$filaPA[3];
                                                                                                
                                                                                                $filaFrm=$con->obtenerPrimeraFila($consulta);
                                                                                                $idFormulario=$filaFrm[1];
                                                                                                $idElemento=$filaFrm[0];
                                                                                                $consulta="(select valor,Contenido,cv.opcion from 902_opcionesFormulario of,954_accionesDictamenParcial d,951_catalogoOpcionesVarios cv
                                                                                                            where  cv.tipoOpcion=2 and cv.valorOpcion=d.idAccion and cv.idIdioma=of.idIdioma and  d.idValor=of.valor and 
                                                                                                            d.idGrupoElemento=of.idGrupoElemento and of.idGrupoElemento=".$idElemento." and of.idIdioma=".$_SESSION["leng"].")
                                                                                                            order by valor";
                                                                                                
                                                                                                
                                                                                                $btnComp="	<br><br><table>
                                                                                                                <tr>
                                                                                                                    <td colspan='3' class='copyrigth'>Resoluciones de dictamen:&nbsp;&nbsp;<a href='javascript:verFormulario(".$idFormulario.")'><img src='../images/icon_code.gif' alt='Configurar formulario de dictamen parcial' title='Configurar formulario de dictamen parcial'></a><br><br></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td width='60' class='fondoVerde7' align='center'>
                                                                                                                    <span class='letraAzulSubrayada7'>C&oacute;digo</span></td>
                                                                                                                    <td width='200' class='fondoVerde7' align='center'>
                                                                                                                    <span class='letraAzulSubrayada7'>Dict&aacute;men</span></td>
                                                                                                                    <td width='240' class='fondoVerde7' align='center'>
                                                                                                                    <span class='letraAzulSubrayada7'>Acci&oacute;n autor</span></td>
                                                                                                                    <td>&nbsp;&nbsp;
                                                                                                                    <a href='javascript:configurarDictamenParcial(".$filaPA[0].",".$filaEtapa[2].",".$idElemento.")'><img src='../images/pencil.png' alt='Modificar opciones de dictamen' title='Modificar opciones de dictamen'></a>
                                                                                                                    </td>
                                                                                                                </tr>";
                                                                                                $resOpt=$con->obtenerFilas($consulta);
                                                                                                while($filasOpt=mysql_fetch_row($resOpt))
                                                                                                {
                                                                                                    $btnComp.=" <tr>
                                                                                                                    <td class='fondoGrid7'>".$filasOpt[0]."</td><td class='fondoGrid7'>".$filasOpt[1]."</td><td class='fondoGrid7'>".$filasOpt[2]."</td><td></td>
                                                                                                                </tr>";
                                                                                                }
                                                                                                        
                                                                                                
                                                                                                $btnComp.="
                                                                                                                </table><br><br>		
                                                                                                            ";
                                                                                                
                                                                                            }
                                                                                        break;
                                                                                        
                                                                                        
                                                                                        
                                                                                        case "5":
                                                                                            if($filaPA[3]=="")
                                                                                                $btnComp="<a href='javascript:configurarDictamenFinal(".$filaPA[0].",".$filaEtapa[2].",".$idProceso.")'><img src='../images/warning.png' title='Este elemento requiere que se le indique la etapa al cual pasar&aacute; el proceso de acuerdo al dictamen tomado, para configurarlo de click sobre este ícono' alt='Este elemento requiere que se le indique la etapa al cual pasar&aacute; el proceso de acuerdo al dictamen tomado, para configurarlo de click sobre este ícono'></a>";
                                                                                            else
                                                                                            {
                                                                                                $consulta="select idElementoDictamen,idFormulario from 948_actoresVSFormulariosDictamen where idActorVSFormularioDictamen=".$filaPA[3];
                                                                                                $filaFrm=$con->obtenerPrimeraFila($consulta);
                                                                                                $idFormulario=$filaFrm[1];
                                                                                                $idElemento=$filaFrm[0];
                                                                                                $consulta="(select valor,Contenido,nombreEtapa from 902_opcionesFormulario of,911_disparadores d,4037_etapas e 
                                                                                                            where e.numEtapa=d.idEtapa and d.idValor=of.valor and 
                                                                                                            d.idGrupoElemento=of.idGrupoElemento and of.idGrupoElemento=".$idElemento." and of.idIdioma=".$_SESSION["leng"].")
                                                                                                            union
                                                                                                            (select valor,Contenido,'Ninguna' as etapa from 902_opcionesFormulario of,911_disparadores d
                                                                                                            where d.idEtapa=0 and d.idValor=of.valor and 
                                                                                                            d.idGrupoElemento=of.idGrupoElemento and of.idGrupoElemento=".$idElemento." and of.idIdioma=".$_SESSION["leng"].")
                                                                                                            order by valor";
                                                                                                $btnComp="	<br><br><table>
                                                                                                                <tr>
                                                                                                                    <td colspan='3' class='copyrigth'>Posibles resoluciones de dictamen:&nbsp;&nbsp;<a href='javascript:verFormulario(".$idFormulario.")'><img src='../images/icon_code.gif' alt='Configurar formulario de dictamen final' title='Configurar formulario de dictamen final'></a><br><br></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    
                                                                                                                    <td width='60' class='fondoVerde7' align='center'>
                                                                                                                    <span class='letraAzulSubrayada7'>C&oacute;digo</span></td>
                                                                                                                    <td width='200' class='fondoVerde7' align='center'>
                                                                                                                    <span class='letraAzulSubrayada7'>Dict&aacute;men</span></td>
                                                                                                                    <td width='240' class='fondoVerde7' align='center'>
                                                                                                                    <span class='letraAzulSubrayada7'>Envia a etapa</span></td>
                                                                                                                    <td>&nbsp;&nbsp;
                                                                                                                    <a href='javascript:configurarDictamenFinal(".$filaPA[0].",".$filaEtapa[2].",".$idElemento.",".$idProceso.")'><img src='../images/pencil.png' alt='Modificar opciones de dictamen' title='Modificar opciones de dictamen'></a>
                                                                                                                    </td>
                                                                                                                </tr>";
                                                                                                $resOpt=$con->obtenerFilas($consulta);
                                                                                                while($filasOpt=mysql_fetch_row($resOpt))
                                                                                                {
                                                                                                    $btnComp.=" <tr>
                                                                                                                    <td class='fondoGrid7'>".$filasOpt[0]."</td><td class='fondoGrid7'>".$filasOpt[1]."</td><td class='fondoGrid7'>".$filasOpt[2]."</td><td></td>
                                                                                                                </tr>";
                                                                                                }
                                                                                                        
                                                                                                
                                                                                                                        
                                                                                                  
                                                                                                
                                                                                                $btnComp.="
                                                                                                                </table><br><br>		
                                                                                                            ";
                                                                                                
                                                                                            }
                                                                                        break;
  
                                                                                        
                                                                                    }
                                                                                    echo $btnComp;
                                                                                ?>
                                                                                </span><br /><br />
                                                                                </td>
                                                                            </tr>
                                                                    <?php			
                                                                            }
												}
                                                                            
                                                                        ?>
                                                                         </table>
                                    
                                                        
                                                        
                                                        </td>
                                                    </tr>
                                                    
                                                    
                                                    
                                            	</table>
                                            </td>
                                        </tr>
                                        </table><br /><br />
                                        
                                 <?php       
                                    }
                                ?>
                               <script type="text/javascript" src="Scripts/procesosAsocComite.js.php?proc=<?php echo base64_encode($idProceso)?>" ></script>
                        	</td>
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
