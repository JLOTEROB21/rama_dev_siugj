<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");

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
<?php
	$paramGET=true;
	$guardarConfSession=true;

?>
<style>
.x-grid3-hd-inner 
{
    font-family: Ubuntu, sans-serif;
   	min- height: 21px;
    height:auto;
	font-size: 12px;
}
</style>
<link rel="stylesheet" type="text/css" href="../Scripts/ux/checkBoxComboBox/CheckboxComboBox.css" media="screen" />
<script type="text/javascript" src="../Scripts/ux/checkBoxComboBox/CheckboxComboBox.js"></script>
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
<script type="text/javascript" src="../Scripts/dataConceptosAPI.js.php"></script>
<script type="text/javascript" src="../Scripts/ux/grid/rowExpander.js"></script>


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
<style>
	body
	{
		min-height:600px;
	}
</style>
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
								$idProceso=$objParametros->idProceso;
								$consulta="select nombre,idTipoProceso,situacion from 4001_procesos where idProceso=".$idProceso;
								$fProceso=$con->obtenerPrimeraFila($consulta);
								$tProceso=$fProceso[1];
								$tOpcion=1;
								
								$ocultarInicio="display:";

							?>	
                            	<script type="text/javascript" src="../Scripts/base64.js"></script>
  								<script type="text/javascript" src="../modeloPerfiles/Scripts/configuracionEscenario.js.php?proc=<?php echo  base64_encode($idProceso)?>"></script>
                        		<span id="divEscenario" >
                                <table width="100%" style="border-spacing:0px !important" >
                                <tr >
                                    <td bgcolor="" class="" ></td>
                                    <td align="center">
                                    	<table width="100%" style="border-spacing:0px !important">
                                        <tr style="height:50px;">
                                        	<td width="40%" align="center" class="encabezadoEscenario" valign="middle">Actor</td>
                                            <td width="60%" align="center" class="encabezadoEscenario" valign="middle">Acci&oacute;n</td>
                                            
                                            
                                        </tr>
                                        <tr style="height:80px; <?php echo $ocultarInicio?>">
                                        	<td class="filaEtapaEscenario" align="left" valign="middle">
                                            	<table width="100%">
                                                	<tr>
                                                    	<td width="90%" align="left">
                                                        	Proceso (Inicio)
                                                        </td>
                                                        <td width="10%" align="right" style="padding-right:15px">
                                                        	<a href='javascript:agregarActorProceso(<?php echo $idProceso?>)'><img width="20" height="22" src="../images/formularios/rolAdd.png" alt="Agregar Actor" title="Agregar actor" /></a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            
                                            </td>
                                            <td class="filaEtapaEscenario" align="left" valign="middle">
                                            </td>
                                        </tr>
                                        
                                        
                                        
                                        <?php
											
											$consulta="select actor,idActorProcesoInicio from 950_actorVSProcesoInicio where idProceso=".$idProceso." and idPerfil=-1";
											$res=$con->obtenerFilas($consulta);
											$totalFilas=$con->filasAfectadas;
											$numFila=0;
											while($fila=mysql_fetch_row($res))
											{
												
												$celdaBordeSuperior="";
												
												if($numFila>0)
												{
													$celdaBordeSuperior="celdaBordeSuperior";
												}
												
												
												$rol=$fila[0];
												$arrRol=explode("_",$rol);
												$consulta="select nombreGrupo from 8001_roles where idRol=".$arrRol[0];
												$rol1=$con->obtenerValor($consulta);
												if($rol1!="")
												{
													$rol2="";
													if($arrRol[1]!="0")
													{
														$consulta="select unidadRol from 4084_unidadesRoles where idUnidadesRoles=".$arrRol[1];
														$rol2=" (".$con->obtenerValor($consulta).")";
													}
													$nomRol="<div class='SIUGJ_Etiqueta14_Gris'>Actor:</div><div class='SIUGJ_ControlEtiqueta14_GrisClaro'>".$rol1.$rol2."</div>";
											?>
                                            		<tr id="filaActorInicio_<?php echo $fila[1]?>" style="min-height:80px;<?php echo $ocultarInicio?>">
                                                    	<td class="valorCeldaEscenario <?php echo $celdaBordeSuperior ?>" valign="middle" align="left">
                                                        	<table width="100%">
                                                            	<tr >
                                                                	<td width="90%" align="left">
                                                                    	<?php 
																			echo $nomRol;
																		?>
                                                                    </td>
                                                                    <td width="10%" align="right" style="padding-right:15px">
                                                                    	<a href="javascript:removerActorInicio(<?php echo $fila[1]?>)"><img  src="../images/formularios/menos.png" alt="Remover actor" title="Remover actor"/></a>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        	
                                                        </td>
                                                        <td class="valorCeldaEscenario <?php echo $celdaBordeSuperior ?>" valign="middle" align="left">	
                                                            <table width="100%">
                                                            	<tr>
                                                                <td align="left">
                                                                    <table width="100%">
                                                                        <?php
                                                                            $consulta="select ap.idActorVSAccionesProceso,aa.accion,aa.idGrupoAccion,ap.complementario 
                                                                                    from 949_actoresVSAccionesProceso ap,945_accionesActor aa where 
                                                                                    aa.idGrupoAccion=ap.idAccion and  ap.actor='".$fila[0]."' and idProceso=".$idProceso.
                                                                                    " and ap.idPerfil=-1";
                                                                            $resPA=$con->obtenerFilas($consulta);
                                                                            
                                                                            while($filaPA=mysql_fetch_row($resPA))
                                                                            {

																				$btnComp="";
																				$verRegistro="";
																				
																				switch($filaPA[2])
																				{
																					case 9: //Ve registros
																					
																						if($filaPA[3]=="")
																							$btnComp="<a href='javascript:configurarVerRegistros(".$filaPA[0].",\"\",1)'><img src='../images/formularios/pencil.png' title='Este elemento requiere que se le indique los registros que podrá ver el actor, para configurarlo de click sobre este ícono'  alt='Este elemento requiere que se le indique los registros que podrá ver el actor, para configurarlo de click sobre este ícono'></a>";
																						else
																						{
																							$consulta="select opcion from 951_catalogoOpcionesVarios where valorOpcion=".$filaPA[3]." and tipoOpcion=".$tOpcion." and idIdioma=".$_SESSION["leng"];
																							$verRegistro=$con->obtenerValor($consulta);
																							$btnComp="<a href='javascript:configurarVerRegistros(".$filaPA[0].",".$filaPA[3].",1)'><img src='../images/formularios/pencil.png' title='Cambiar tipo de registros visto por actor' alt='Cambiar tipo de registros visto por actor'></a>";
																						}
																					break;	
																				}
																				
																				
                                                                    ?>
                                                                            <tr height="50" id="filaAccionInicio_<?php echo  $filaPA[0] ?>" >
                                                                                <td width="35%" align="left">
                                                                                
                                                                                   <div class="SIUGJ_Etiqueta14_Gris">
                                                                                    <?php
                                                                                        echo $filaPA[1];
                                                                                    ?>
                                                                                    </div>
                                                                                </td>
                                                                                <td width="50%" align="right">
                                                                                <div id="tblVer_<?php echo $filaPA[0]?>" class="SIUGJ_ControlEtiqueta14_GrisClaro">
                                                                                <?php
																					echo $verRegistro;
																				?>
                                                                                </div>
                                                                                </td>
                                                                                <td width="15%" align="center">
                                                                                	<table>
                                                                                    	<tr>
                                                                                        	<td width="25" align="center">	
                                                                                            	<a href="javascript:removerAccionInicio(<?php echo $filaPA[0]?>)"><img  src="../images/formularios/menos.png" alt="Remover acción" title="Remover acción" /></a>
                                                                                            </td>
                                                                                            <td width="10">
                                                                                            </td>
                                                                                            <td width="25" align="center">	
                                                                                            	<span id="btnModificar_<?php echo $filaPA[0]?>">	
                                                                                            	<?php
																									echo $btnComp;
																								?>
                                                                                                </span>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                    <?php			
                                                                            }
                                                                            
                                                                        ?>
                                                                         </table>
                                                                </td>
                                                                <td width="30" align="right" valign="top"><a href="javascript:agregarAccionInicio('<?php echo $fila[0] ?>')"><img width="22" height="22"  src='../images/formularios/plus-square.png' title="Agregar acción" alt="Agregar acción" /></a></td>
                                                            </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                            <?php
													
												}
												
												$numFila++;
												
											}	
											$consulta="select numEtapa,nombreEtapa from 4037_etapas where idProceso=".$idProceso." order by numEtapa";
											$resP=$con->obtenerFilas($consulta);
											while($filaP=mysql_fetch_row($resP))
											{
										?>		
											<tr style="height:80px;">
                                            	<td colspan="1" class="filaEtapaEscenario" align="left">
                                               		<table width="100%">
                                                        <tr>
                                                            <td width="90%" align="left">
                                                                Etapa: <?php echo removerCerosDerecha($filaP[0]).".- ".$filaP[1]?>
                                                            </td>
                                                            <td width="10%" align="right" style="padding-right:15px">
                                                                <a href='javascript:agregarActor(<?php echo $filaP[0] ?>)'><img width="20" height="22" src="../images/formularios/rolAdd.png" alt="Agregar Actor" title="Agregar actor" /></a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                               
                                                </td>
                                                <td align="right" class="filaEtapaEscenario" style="padding-right:20px">
                                                	<table>
                                                    <tr>
                                                    	<td width="25" align="center">
                                                        	<a href="javascript:window.parent.configurarNotificaciones('<?php echo bE($idProceso) ?>','<?php echo bE($filaP[0])?>')"><img src="../images/formularios/bell.png" width="22" height="22" title="Configurar notificaciones" alt="Configurar notificaciones" /></a>
                                                        </td>
                                                        <td width="15">
                                                        </td>
                                                        <td width="25" align="center">
                                                        	<a href='javascript:configurarDisparador("<?php echo bE($idProceso)?>","<?php echo bE($filaP[0])?>")'><img src="../images/formularios/calendar.png" width="22" height="22" title='Configurar disparadores' alt='Configurar disparadores'/></a>
                                                        </td>
                                                        <td width="15">
                                                        </td>
                                                        <td width="25" align="center">
                                                        	 <a href='javascript:configurarArranqueProceso("<?php echo bE($idProceso)?>","<?php echo bE($filaP[0])?>","<?php echo bE(removerCerosDerecha($filaP[0]).".- ".$filaP[1])?>")'><img width="22" height="22" src="../images/formularios/folder.png" title='Arrancar Proceso' alt='Arrancar Proceso'/></a>
                                                        </td>
                                                        <td width="15">
                                                        </td>
                                                        <td width="25" align="center">
                                                        	 <a href='javascript:configurarCambioEtapaProceso("<?php echo bE($idProceso)?>","<?php echo bE($filaP[0])?>","<?php echo bE(removerCerosDerecha($filaP[0]).".- ".$filaP[1])?>")'><img width="20" height="20" src="../images/formularios/arrows.png" title='Cambiar Etapa Proceso Asociado' alt='Cambiar Etapa Proceso Asociado'/></a>
                                                        </td>
                                                        <td width="15">
                                                        </td>
                                                        <td width="25" align="center" id="btnScriptEjecutar_<?php echo $idProceso."_".$filaP[0] ?>">
                                                        
                                                        <?php
														$consulta="SELECT urlScript,imprimirScript,funcionAplicacion,(SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=e.funcionAplicacion) 
																	AS lblFuncionAplicacion FROM 9083_ejecucionScriptCambioEtapa e WHERE idProceso=".$idProceso." AND numEtapa=".$filaP[0];
														$cadObjScript=$con->obtenerFilasJSON($consulta);
	
														?>
                                                        
                                                        	 <a href='javascript:dispararScript("<?php echo bE($idProceso)?>","<?php echo bE($filaP[0])?>","<?php echo bE(removerCerosDerecha($filaP[0]).".- ".$filaP[1])?>","<?php echo bE($cadObjScript)?>")'><img width="21" height="21" src="../images/formularios/linkChain.png" title='Disparar Script' alt='Disparar Script'/></a>
                                                        </td>
                                                    </tr>
                                                    </table>
                                                </td>
                                            </tr>	
                                            <?php
                                            	$consulta="select actor,tipoActor,idActorProcesoEtapa,asocAutomatico from 944_actoresProcesoEtapa where numEtapa=".$filaP[0]." and idProceso=".$idProceso." and idPerfil=-1";
												$resAc=$con->obtenerFilas($consulta);
												$actorComp="";
												$totalFilas=$con->filasAfectadas;
												$numFila=0;
												while($filaAc=mysql_fetch_row($resAc))
												{
													$celdaBordeSuperior="";
													$lblEtiquetaComplementaria="";
													if($numFila>0)
													{
														$celdaBordeSuperior="celdaBordeSuperior";
													}
													$actor=$filaAc[0];
													$arrRol=explode("_",$actor);
													$nRol=obtenerTituloRol($actor);
													$actor="<div class='SIUGJ_Etiqueta14_Gris'>Actor:</div><div class='SIUGJ_ControlEtiqueta14_GrisClaro'>".$nRol."</div>";
													
													?>
														<tr id="filaActor_<?php echo $filaAc[2]?>" style="min-height:80px;">
                                                        	<td class="valorCeldaEscenario <?php echo $celdaBordeSuperior?>" valign="middle" align="left">
                                                            
                                                            	<table width="100%">
                                                            	<tr >
                                                                	<td width="90%" align="left">
                                                                    	<?php 
																			echo $actor;
																		?>
                                                                    </td>
                                                                    <td width="10%" align="right" style="padding-right:15px">
                                                                    	<a href="javascript:removerActor(<?php echo $filaAc[2]?>)"><img src="../images/formularios/menos.png" alt="Remover actor" title="Remover actor"/></a>
                                                                    </td>
                                                                </tr>
                                                            	</table>
                                                            </td>
                                                            <td class="valorCeldaEscenario  <?php echo $celdaBordeSuperior?>" valign="middle" align="left">
                                                            	<table width="100%">
                                                                	<tr>
                                                                    	<td>
                                                                        	<table width="100%">
                                                                   			<?php
																				$consulta="select ap.idAccionesProcesoEtapaVSAcciones,aa.accion,aa.idGrupoAccion,
																						ap.complementario,ap.complementario2,ap.complementario3 from 
																						947_actoresProcesosEtapasVSAcciones ap,945_accionesActor aa where aa.idGrupoAccion=ap.idGrupoAccion 
																						and idActorProcesoEtapa=".$filaAc[2];


																				$resPA=$con->obtenerFilas($consulta);
																				while($filaPA=mysql_fetch_row($resPA))
																				{
																					$btnTablaDictamen="";
																					$lblEtiquetaComplementaria="";
																					$estiloMarco="";
																					if(($filaPA[2]=="5")||($filaPA[2]=="4")||($filaPA[2]=="3"))
																						$estiloMarco="filaMarco";
																					
																					
																					$lblEtiqueta=$filaPA[1];
																					$msgConfirmacion="";
																					$btnDeleteAccion='';
																					switch($filaPA[2])
																					{
																						case 1://Somete a revisión																										
																							$msgConfirmacion="¿Está seguro de querer someter este registro a revisión?";
																							if($filaPA[4]!="")
																							{
																								$obj=json_decode($filaPA[4]);
																								if(isset($obj->etiqueta))
																								{
																									$lblEtiqueta=$obj->etiqueta;
																									$msgConfirmacion=$obj->msgConf;
																								}
																								if(isset($obj->funcionVisualizacion))
																								{
																									$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$obj->funcionVisualizacion;
																									$lblFuncionVisualizacion=$con->obtenerValor($consulta);
																									
																									
																									$filaPA[4]=setAtributoCadJson($filaPA[4],"lblFuncionVisualizacion",$lblFuncionVisualizacion);
																									
																									
																									
																								}
																								
																								if(isset($obj->funcionValidacionSistema))
																								{
																									$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$obj->funcionValidacionSistema;
																									$lblFuncionValidacion=$con->obtenerValor($consulta);
																									$filaPA[4]=setAtributoCadJson($filaPA[4],"lblFuncionValidacion",$lblFuncionValidacion);
																								}
																							}
																							else
																							{
																								$filaPA[4]='{"etiqueta":"'.$lblEtiqueta.'","msgConf":"'.$msgConfirmacion.'","solicitarComentarios":"0","cerrarVentana":"0"}';
																							}
																						break;
																						case 30://Certificar/Firmar
																						
																							if($filaPA[4]!="")
																							{
																								$obj=json_decode($filaPA[4]);
																								if(isset($obj->etiqueta))
																								{
																									$lblEtiqueta=$obj->etiqueta;
																									
																								}
																							}
																						break;
																					}
																					
																					
																					$btnTablaDictamen="";
																					$btnComp="";
																					switch($filaPA[2])
																					{
																						case 1://Somete a revisión
																							if($filaPA[3]=="")
																								$btnComp="<a href='javascript:configurarSometeRevision(".$filaPA[0].",".$filaP[0].")'><img src='../images/warning.png' title='Este elemento requiere que se le indique la etapa al cual pasar&aacute; el proceso, para configurarlo de click sobre este ícono'  alt='Este elemento requiere que se le indique la etapa al cual pasar&aacute; el proceso, para configurarlo de click sobre este ícono'></a>";
																							else
																							{
																								$consulta="select nombreEtapa from 4037_etapas where idProceso=".$idProceso." and numEtapa=".$filaPA[3];
																								$etapaPasa=removerCerosDerecha($filaPA[3]).".- ".$con->obtenerValor($consulta);
																								$btnComp="<a href='javascript:modificarPasoEtapa(".$filaPA[0].",".$filaP[0].",".$filaPA[3].")'><img src='../images/formularios/pencil.png' title='Cambiar etapa' alt='Cambiar etapa'></a>";
																							
																								$lblEtiquetaComplementaria="<div class='SIUGJ_ControlEtiqueta14_GrisClaro'>Pasa a etapa: ".$etapaPasa."</div>";
																							
																							}
																							
																							
																						break;
																						case 5:
																							$lblEtiqueta=$filaPA[1];
																							
																							if($filaPA[5]!="")
																							{
																								$obj=json_decode($filaPA[5]);
																								if(isset($obj->etiqueta))
																								{
																									$lblEtiqueta=$obj->etiqueta;
																									
																								}
																							}
																							

																							
																							$btnDeleteAccion='<a href="javascript:removerAccion('.$filaPA[0].')"><img src="../images/formularios/menos.png" alt="Remover acción" title="Remover acción" /></a>';
																							
																							if($filaPA[3]=="")
																								$btnComp="<a href='javascript:configurarDictamenFinal(\"".bE($filaAc[2])."\",\"".bE($filaPA[0])."\",\"".bE($filaP[0])."\")'><img src='../images/formularios/pencil.png' title='Este elemento requiere que se le indique la etapa al cual pasar&aacute; el proceso de acuerdo al dictamen tomado, para configurarlo de click sobre este ícono' alt='Este elemento requiere que se le indique la etapa al cual pasar&aacute; el proceso de acuerdo al dictamen tomado, para configurarlo de click sobre este ícono'></a>";
																							else
																							{
																								$consulta="select idElementoDictamen,idFormulario from 948_actoresVSFormulariosDictamen where idActorVSFormularioDictamen=".$filaPA[3];

																								$filaFrm=$con->obtenerPrimeraFila($consulta);
																								$idFormulario=$filaFrm[1];
																								$idElemento=$filaFrm[0];
																								if($idElemento=="")
																									$idElemento="-1";
																								$consulta="(select valor,Contenido,idEtapa from 902_opcionesFormulario `of`,911_disparadores d
																											where  d.idValor=`of`.valor and 
																											d.idGrupoElemento=`of`.idGrupoElemento and `of`.idGrupoElemento=".$idElemento." and `of`.idIdioma=".$_SESSION["leng"].")
																											union
																											(select valor,Contenido,'0' as etapa from 902_opcionesFormulario `of`,911_disparadores d
																											where d.idEtapa=0 and d.idValor=`of`.valor and 
																											d.idGrupoElemento=`of`.idGrupoElemento and `of`.idGrupoElemento=".$idElemento." and `of`.idIdioma=".$_SESSION["leng"].")
																											order by valor";
																								
																								
																								$btnComp="<a href='javascript:configurarDictamenFinal(\"".bE($filaAc[2])."\",\"".bE($filaPA[0])."\",\"".bE($filaP[0])."\",\"".bE($idElemento)."\",\"".bE($idFormulario)."\")'><img src='../images/formularios/pencil.png' alt='Modificar opciones de dictamen' title='Modificar opciones de dictamen'></a>";
																								//<a href='javascript:verFormulario(".$idFormulario.")'><img src='../images/icon_code.gif' alt='Configurar formulario de dictamen final' title='Configurar formulario de dictamen final'></a>
																								$btnTablaDictamen="	
																													<tr>
																														<td colspan='3' align='center'>
																														
																															<table width='100%' style='border-spacing:0px !important'>
																															<tr>
																																<td colspan='3' ><div class='SIUGJ_ControlEtiqueta14_GrisClaro'>Listado de opciones a presentar:</div><br></td>
																															</tr>
																															<tr height='40'>
																																
																																<td width='10%' class='celdaCabeceraDictamenFinal' align='center'>
																																Clave
																																</td>
																																<td width='50%' class='celdaCabeceraDictamenFinal celdaBordeIzquierdo' align='center'>
																																Opci&oacute;n
																																</td>
																																<td width='40%' class='celdaCabeceraDictamenFinal celdaBordeIzquierdo' align='center'>
																																Envia a etapa
																																</td>
																																
																															</tr>";
																															$resOpt=$con->obtenerFilas($consulta);
																															while($filasOpt=mysql_fetch_row($resOpt))
																															{
																																if($filasOpt[2]!=0)
																																{	
																																	$consulta="select nombreEtapa from 4037_etapas where numEtapa=".$filasOpt[2]." and idProceso=".$idProceso;
																																	$enviaEtapa=removerCerosDerecha($filasOpt[2]).".- ".$con->obtenerValor($consulta);
																																}
																																else
																																	$enviaEtapa="Ninguna";
																																$btnTablaDictamen.=" <tr height='40'>
																																						<td class='celdaCuerpoDictamenFinal'>".$filasOpt[0]."</td><td class='celdaCuerpoDictamenFinal celdaBordeIzquierdo'>".$filasOpt[1]."</td><td class='celdaCuerpoDictamenFinal celdaBordeIzquierdo'>".$enviaEtapa."</td>
																																					</tr>";
																															}
																																	
																															
																															$btnTablaDictamen.="
																																			</table><br><br>		
																																		
																															</td>
																														</tr>				
																								";
																								
																							}
																						break;
																						
																						case 30:
																							 if($filaPA[4]=="")
																								$btnComp="<a href='javascript:configurarModuloFirmaCertificacion(".$filaPA[0].",".$filaP[0].")'><img src='../images/formularios/pencil.png' title='Este elemento requiere ser configurado, para llevar acabo dicha acci&oacute;n de click sobre este ícono'  alt='Este elemento requiere ser configurado, para llevar acabo dicha acci&oacute;n de click sobre este ícono'></a>";
																							else
																								$btnComp="<a href='javascript:configurarModuloFirmaCertificacion(".$filaPA[0].",".$filaP[0].",\"".bE($filaPA[4])."\")'><img src='../images/formularios/pencil.png' title='Modificar configuraci&oacute;n' alt='Modificar configuraci&oacute;n'></a>";
																						break;
																						case 31:
																							$btnComp="<span id=\"btn_".$filaPA[0]."\"><a href='javascript:configurarSubidaDocumento(".$filaPA[0].",".$filaP[0].",\"".bE($filaPA[4])."\")'><img src='../images/formularios/pencil.png' title='Configurar documentos de subida'  alt='Configurar documentos de subida'></a></span>";
																						break;
																					}
																				?>
																					<tr height="<?php echo $filaPA[2]!=5?"50":"30"?>" id="filaAccion_<?php echo  $filaPA[0] ?>">
                                                                                        <td width="35%" align="left" valign="top">
                                                                                        
                                                                                           <div class="SIUGJ_Etiqueta14_Gris">
																							  <?php
                                                                                              if(($filaPA[2]!=5)&&($filaPA[2]!=4))
                                                                                              {
                                                                                              ?>
                                                                                                  <span id="lblEtiqueta_<?php echo $filaPA[0]?>">
                                                                                                  <?php
                                                                                                      echo trim($lblEtiqueta);
                                                                                                  ?>
                                                                                                  </span>
                                                                                                  <input type="hidden" value="<?php echo bE($msgConfirmacion)?>" id='msgConf_<?php echo $filaPA[0] ?>'>
                                                                                                  <input type="hidden" value="<?php echo bE($filaPA[4])?>" id='oConf_<?php echo $filaPA[0] ?>'>
                                                                                                  
                                                                                                  <?php
                                                                                                    $btnDeleteAccion='<a href="javascript:removerAccion('.$filaPA[0].')"><img src="../images/formularios/menos.png" alt="Remover acción" title="Remover acción" /></a>';
                                                                                                  ?>
            
                                                                                              <?php
                                                                                              }
																							  else
																							  {
																							?>
																								  <span id="lblEtiqueta_<?php echo $filaPA[0]?>">
                                                                                                  <?php
                                                                                                      echo trim($lblEtiqueta);
                                                                                                  ?>
                                                                                                  </span>
																							<?php
                                                                                            
                                                                                              }
                                                                                              ?>
                                                                                           </div>
                                                                                        </td>
                                                                                        <td width="50%" align="right" valign="top">
                                                                                        	<div id="tblEtapas_<?php echo $filaPA[0]?>">
                                                                                        <?php
																							echo $lblEtiquetaComplementaria;
																						?>
                                                                                        	</div>
                                                                                        </td>
                                                                                        <td width="15%" align="center" valign="top">
                                                                                            <table>
                                                                                                <tr>
                                                                                                    <td width="25" align="center">	
                                                                                                    <?php
																										echo $btnDeleteAccion;
																									?>    
                                                                                                    </td>
                                                                                                    <td width="10">
		                                                                                            </td>
                                                                                                    <td width="25" align="center">
                                                                                                    <span id="btnModificar_<?php echo $filaPA[0]?>">	
                                                                                                     <?php
																										echo $btnComp;
																									?>    
                                                                                                    </span>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr><?php
																					echo $btnTablaDictamen;
																					?>	
																				<?php			
																				}
																			?>
                                                                        	 </table>
                                                                        </td>
                                                                    	<td width="30" align="right" valign="top"><a href="javascript:agregarAccion(<?php echo $filaAc[2]?>)"><img width="22" height="22" src='../images/formularios/plus-square.png' title="Agregar acción" alt="Agregar acción" /></a></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            
                                                        </tr>
													<?php
													$numFila++;
												}
                                            ?>
                                            
												
										<?php		
											}
										?>
                                        </table>
                                    </td>
                                    <td width="10" class="">
                                    <input type="hidden" id="idProceso" value="<?php echo $idProceso ?>" />
                                    <input type="hidden" id="hUnidad" value="-1" />
                                    </td>
                                </tr>
                                
                                </table>
                            </span>
                        
                        
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