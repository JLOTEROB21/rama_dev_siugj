<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");
$excluirExt=true;
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
	$guardarConfSession=false;
	$ocultarFormulariosEnvio=true;
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
								$idProceso=$objParametros->idProceso;
								$consulta="select nombre,idTipoProceso,situacion from 4001_procesos where idProceso=".$idProceso;
								$fProceso=$con->obtenerPrimeraFila($consulta);
								$tProceso=$fProceso[1];
								if($tProceso!="9")
								{
									$tOpcion=1;
									//$ocultarInicio="display:";
								}
								else
								{
									$tOpcion=9;
								}/*
									$consulta="select * from 4001_configuracionProcesoPOA where idProceso=".$idProceso;
									$fProceso=$con->obtenerPrimeraFila($consulta);
									$esquemaPlaneacion=$fProceso[7];
									$tOpcion="1".$esquemaPlaneacion;
									$ocultarInicio="display:none";
								}*/

							?>	
  								<script type="text/javascript" src="../modeloPerfiles/Scripts/configuracionEscenario.js.php?proc=<?php echo  base64_encode($idProceso)?>"></script>
                        		<span id="divEscenario" >
                                <table >
                                <tr>
                                    <td width="30">
                                    </td>
                                    <td align="left">
                                        <span class="letraFicha" ><br />
                                        Escenario del proceso:
                                        </span>
                                        <br />
                                        <br />
                                        <br />
                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor="" class="" ></td>
                                    <td align="center">
                                    	<table >
                                        <tr>
                                        	<td width="260" align="center" class="valorFicha"><span class="corpo8_bold">Actor</span></td>
                                            <td width="680" align="center" class="valorFicha"><span class="corpo8_bold">Acción</span></td>
                                            
                                            
                                        </tr>
                                        <tr style="<?php echo $ocultarInicio?>">
                                        	<td colspan="2" class="etiquetaFicha" align="left">
                                            <span class="letraRojaSubrayada8">
                                            Proceso (Inicio)</span>&nbsp;&nbsp;<a href='javascript:agregarActorProceso(<?php echo $idProceso?>)'><img src="../images/user_add.png" alt="Agregar Actor" title="Agregar actor" /></a>
                                            
                                            </td>
                                        </tr>
                                        
                                        
                                        
                                        <?php
											$consulta="select actor,idActorProcesoInicio from 950_actorVSProcesoInicio where idProceso=".$idProceso;
											
											$res=$con->obtenerFilas($consulta);
											while($fila=mysql_fetch_row($res))
											{
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
													$nomRol="Actor: ".$rol1.$rol2;
											?>
                                            		<tr id="filaActorInicio_<?php echo $fila[1]?>" style="<?php echo $ocultarInicio?>">
                                                    	<td class="valorFicha" valign="top" align="left"><span class="corpo8" align="left"><?php echo $nomRol?></span>&nbsp;&nbsp;<a href="javascript:removerActorInicio(<?php echo $fila[1]?>)"><img src="../images/cancel_round.png" alt="Remover actor" title="Remover actor"/></a></td>
                                                        <td class="valorFicha" align="left">	
                                                        <table width="100%">
                                                                	<tr>
                                                                    	<td align="left">
                                                                        
                                                                        <table width="100%">
                                                                   			<?php
																				$consulta="select ap.idActorVSAccionesProceso,aa.nombreAccion,aa.idGrupoAccion,ap.complementario 
																						from 949_actoresVSAccionesProceso ap,946_accionesActoresVSTipoProceso aa where 
																						aa.idGrupoAccion=ap.idAccion and aa.tipoProceso=".$tProceso." and ap.actor='".$fila[0]."' and idProceso=".$idProceso;
																				$resPA=$con->obtenerFilas($consulta);
																				
																				while($filaPA=mysql_fetch_row($resPA))
																				{
																		?>
                                                                        		<tr height="25" id="filaAccionInicio_<?php echo  $filaPA[0] ?>" >
                                                                                	<td colspan="2" >
                                                                                    
                                                                                    <span class="copyrigth" ><b>
                                                                                    <?php
																						echo $filaPA[1];
																					?></b>
                                                                                    </span>&nbsp;&nbsp;
                                                                                    <a href="javascript:removerAccionInicio(<?php echo $filaPA[0]?>)"><img src="../images/delete.png" alt="Remover acción" title="Remover acción" /></a>&nbsp;&nbsp;
                                                                                    <span id="tblVer_<?php echo $filaPA[0]?>" class="letraAzulSubrayada7">
                                                                                    <?php
																						$btnComp="";
																						
																						switch($filaPA[2])
																						{
																							case 9:
																							case 11:
																								if($filaPA[3]=="")
																									$btnComp="<a href='javascript:configurarVerRegistros(".$filaPA[0].",\"\",1)'><img src='../images/warning.png' title='Este elemento requiere que se le indique los registros que podrá ver el actor, para configurarlo de click sobre este ícono'  alt='Este elemento requiere que se le indique los registros que podrá ver el actor, para configurarlo de click sobre este ícono'></a>";
																								else
																								{
																									$consulta="select opcion from 951_catalogoOpcionesVarios where valorOpcion=".$filaPA[3]." and tipoOpcion=".$tOpcion." and idIdioma=".$_SESSION["leng"];
																									$verRegistro=$con->obtenerValor($consulta);
																									$btnComp="(".$verRegistro.")&nbsp;&nbsp;<a href='javascript:configurarVerRegistros(".$filaPA[0].",".$filaPA[3].",1)'><img src='../images/pencil.png' title='Cambiar tipo de registros visto por actor' alt='Cambiar tipo de registros visto por actor'></a>";
																								}
																							break;	
																							case 15:
																								$arrComp=explode("_",$filaPA[3]);
																								$arrOpciones=array();
																								$arrOpciones[0][0]='0';
																								$arrOpciones[0][1]='Cualquiera';
																								$arrOpciones[1][0]='1';
																								$arrOpciones[1][1]='Adscritos a su departamento';
																								$arrOpciones[2][0]='2';
																								$arrOpciones[2][1]='Adscritos en su departamento/subdepartamentos';
																								$arrOpciones2=array();
																								$arrOpciones2[0][0]='0';
																								$arrOpciones2[0][1]='Cualquiera';
																								$arrOpciones2[1][0]='1';
																								$arrOpciones2[1][1]='Sólo en su departamento';
																								$arrOpciones2[2][0]='2';
																								$arrOpciones2[2][1]='Sólo en su departamento y subdepartamentos';
																								$consulta="select rol from 943_rolesActoresProceso where idProceso=".$idProceso;
																								$resRoles=$con->obtenerFilas($consulta);
																								$arrRoles=array();
																								while($filaRol=mysql_fetch_row($resRoles))
																								{
																									$obj[0]=str_replace("_","|",$filaRol[0]);
																									$obj[1]=obtenerTituloRol($filaRol[0]);
																									array_push($arrRoles,$obj);
																								}
																								$opciones=$con->generarOpcionesSelectArregloNoImp($arrOpciones,$arrComp[0]);
																								$opciones2=$con->generarOpcionesSelectArregloNoImp($arrOpciones2,$arrComp[1]);
																								$roles=$con->generarOpcionesSelectArregloNoImp($arrRoles,$arrComp[2]);
																								
																								
																								$btnComp="<br><br>
																												<table>
																												<tr height='21'>
																													<td width='5'>
																													</td>
																													<td width='265'>
																														Usuarios sobre los que puede asignar responsabilidad:
																													</td>
																													<td>
																														<select id='cmbUsuariosAsigna' onchange='cambiarAmbitoResp(this,\"".($filaPA[0])."\",0)'>".$opciones."
																														</select>
																													</td>
																												</tr>
																												<tr height='21'>
																													<td >
																													</td>
																													<td>
																														Deptos. sobre los que puede asignar responsabilidad:
																													</td>
																													<td>
																														<select id='cmbUsuariosAsigna2' onchange='cambiarAmbitoResp(this,\"".($filaPA[0])."\",1)'>".$opciones2."
																														</select>
																													</td>
																												</tr>
																												<tr height='21'>
																													<td >
																													</td>
																													<td>
																														El usuario asignado tendrá los privilegios del rol:
																													</td>
																													<td>
																														<select id='cmbUsuariosAsigna2' onchange='cambiarAmbitoResp(this,\"".($filaPA[0])."\",2)'><option value='-1'>Seleccione</option>".$roles."
																														</select>
																													</td>
																												</tr>
																												</table><br><br>
																												";
																							break;
																						}
																						echo $btnComp;
																					?>
                                                                                    
                                                                                    </span>
                                                                                    <br /><br />
                                                                                    </td>
                                                                                </tr>
                                                                        <?php			
																				}
																				
																			?>
                                                                        	 </table>
                                                                        	
                                                                        </td>
                                                                    	<td align="right" valign="top"><a href="javascript:agregarAccionInicio('<?php echo $fila[0] ?>')"><img src='../images/addAccion.png' title="Agregar acción" alt="Agregar acción" /></td>
                                                                    </tr>
                                                                </table>
                                                        
                                                        
                                                        </td>
                                                    </tr>
                                            <?php
													
												}
												
											}	
											$consulta="select numEtapa,nombreEtapa from 4037_etapas where idProceso=".$idProceso." order by numEtapa";
											$resP=$con->obtenerFilas($consulta);
											while($filaP=mysql_fetch_row($resP))
											{
										?>		
											<tr>
                                            	<td colspan="1" class="etiquetaFicha" align="left"><span class="letraRojaSubrayada8">
                                                Etapa: <?php echo removerCerosDerecha($filaP[0]).".- ".$filaP[1]?></span>&nbsp;&nbsp;<a href='javascript:agregarActor(<?php echo $filaP[0] ?>)'><img src="../images/user_add.png" alt="Agregar Actor" title="Agregar actor" /></a>
                                                </td>
                                                <td align="right" class="etiquetaFicha">
                                                	<a href='javascript:configurarDisparador("<?php echo bE($idProceso)?>","<?php echo bE($filaP[0])?>")'><img src="../images/lightning_add.png" title='Configurar disparadores' alt='Configurar disparadores'/>
                                                </td>
                                            </tr>	
                                            <?php
                                            	$consulta="select actor,tipoActor,idActorProcesoEtapa,asocAutomatico from 944_actoresProcesoEtapa where numEtapa=".$filaP[0]." and idProceso=".$idProceso;
												$resAc=$con->obtenerFilas($consulta);
												$actorComp="";
												while($filaAc=mysql_fetch_row($resAc))
												{
													$actorComp="";
													$actor=$filaAc[0];
													switch($filaAc[1])
													{
														case "1":
															$arrRol=explode("_",$actor);
															$nRol=obtenerTituloRol($actor);
															$actor="Actor: ".$nRol;
														break;
														case "2":
															if($tProceso=="9")
															{
																$consulta="select nombreComite from 235_proyectosVSComites e,2006_comites c where c.idComite=e.idComite 
																			and  e.idProyectoVSComite=".$actor;	
															}
															else
															{
																$consulta="select nombreComite from 234_proyectosVSComitesVSEtapas e,2006_comites c where c.idComite=e.idComite 
																			and  e.idProyectoVSComiteVSEtapa=".$actor;	
															}
															$actor="Comite: ".$con->obtenerValor($consulta);
															$consulta="select valor,texto from 1004_siNo where idIdioma=".$_SESSION["leng"];
															$actorComp="¿Asociar automáticamente?&nbsp;<select id='cmbAsoc_".$filaAc[2]."' onchange='asociarAutomaticamente(this)'>".$con->generarOpcionesSelectNoImp($consulta,$filaAc[3])."</select>";
														break;
													}
													?>
														<tr id="filaActor_<?php echo $filaAc[2]?>">
                                                        	<td class="valorFicha" valign="top" align="left">
                                                            <span class="corpo8"><?php echo $actor?></span>&nbsp;&nbsp;<a href="javascript:removerActor(<?php echo $filaAc[2]?>)"><img src="../images/cancel_round.png" alt="Remover actor" title="Remover actor"/></a><br />
                                                            <span class="letraExt">
															<?php echo $actorComp?>
                                                            </span>
                                                            </td>
                                                            <td class="valorFicha" align="left">
                                                            	<table width="100%">
                                                                	<tr>
                                                                    	<td>
                                                                        	<table width="100%">
                                                                   			<?php
																				$consulta="select ap.idAccionesProcesoEtapaVSAcciones,aa.nombreAccion,aa.idGrupoAccion,ap.complementario,ap.complementario2 from 
																				947_actoresProcesosEtapasVSAcciones ap,946_accionesActoresVSTipoProceso aa where aa.idGrupoAccion=ap.idGrupoAccion 
																				and aa.tipoProceso=".$tProceso." and idActorProcesoEtapa=".$filaAc[2];
																				//echo $consulta;
																				$resPA=$con->obtenerFilas($consulta);
																				while($filaPA=mysql_fetch_row($resPA))
																				{
																					$estiloMarco="";
																					if(($filaPA[2]=="5")||($filaPA[2]=="4")||($filaPA[2]=="3"))
																						$estiloMarco="filaMarco";
																						
																						
																		?>
                                                                        		<tr height="25" id="filaAccion_<?php echo  $filaPA[0] ?>" >
                                                                                	<td colspan="2"class="<?php echo $estiloMarco?>" >
                                                                                    	<table>
                                                                                        <tr>
                                                                                        	<td valign="top">
                                                                                            	<?php
																								if(($filaPA[2]!=5)&&($filaPA[2]!=4))
																								{
																								?>
                                                                                                    <span class="copyrigth" ><b><span id="lblEtiqueta_<?php echo $filaPA[0]?>">
                                                                                                    <?php
                                                                                                     	$lblEtiqueta=$filaPA[1];
																										$msgConfirmacion="Está seguro de querer someter este registro a revisión?";
																										if($filaPA[4]!="")
																										{
																											$obj=json_decode($filaPA[4]);
																											$lblEtiqueta=$obj->etiqueta;
																											$msgConfirmacion=$obj->msgConf;
																										}
                                                                                                        echo trim($lblEtiqueta);
                                                                                                    ?></span></b>
                                                                                                    </span>&nbsp;&nbsp;
                                                                                                	<input type="hidden" value="<?php echo bE($msgConfirmacion)?>" id='msgConf_<?php echo $filaPA[0] ?>'>
                                                                                                	<a href="javascript:removerAccion(<?php echo $filaPA[0]?>)"><img src="../images/delete.png" alt="Remover acción" title="Remover acción" /></a>&nbsp;&nbsp;
                                                                                    			<?php
																								}
																								?>	
                                                                                            
                                                                                            </td>
                                                                                            <td>&nbsp;&nbsp;
                                                                                            </td>
                                                                                            <td>
                                                                                                <span id="tblEtapas_<?php echo $filaPA[0]?>">
                                                                                                <?php
                                                                                                    $btnComp="";
                                                                                                    switch($filaPA[2])
                                                                                                    {
                                                                                                        case "1":
                                                                                                            if($filaPA[3]=="")
                                                                                                                $btnComp="<a href='javascript:configurarSometeRevision(".$filaPA[0].",".$filaP[0].")'><img src='../images/warning.png' title='Este elemento requiere que se le indique la etapa al cual pasar&aacute; el proceso, para configurarlo de click sobre este ícono'  alt='Este elemento requiere que se le indique la etapa al cual pasar&aacute; el proceso, para configurarlo de click sobre este ícono'></a>";
                                                                                                            else
                                                                                                            {
                                                                                                                $consulta="select nombreEtapa from 4037_etapas where idProceso=".$idProceso." and numEtapa=".$filaPA[3];
                                                                                                                $etapaPasa=removerCerosDerecha($filaPA[3]).".- ".$con->obtenerValor($consulta);
                                                                                                                  $btnComp="<span class='corpo8'><font color='#000055'><b>Pasa a etapa:</b></font><font color='green'><b> ".$etapaPasa."</b></font></span>&nbsp;&nbsp;<a href='javascript:modificarPasoEtapa(".$filaPA[0].",".$filaP[0].",".$filaPA[3].")'><img src='../images/pencil.png' title='Cambiar etapa' alt='Cambiar etapa'></a>";
                                                                                                            }
                                                                                                            
                                                                                                        break;
                                                                                                        
                                                                                                        case "3":
                                                                                                            if($filaPA[3]=="")
                                                                                                                $btnComp="<a href='javascript:configurarDictamenRevisor(".$filaPA[0].",".$filaP[0].")'><img src='../images/warning.png' title='Este elemento requiere que se indique los posibles valores de dictamen, para configurarlo de click sobre este ícono' alt='Este elemento requiere que se indique los posibles valores de dictamen, para configurarlo de click sobre este ícono, para configurarlo de click sobre este ícono'></a>";
                                                                                                            else
                                                                                                            {
                                                                                                                $consulta="select idElementoDictamen,idFormulario from 948_actoresVSFormulariosDictamen where idActorVSFormularioDictamen=".$filaPA[3];
                                                                                                               //echo $consulta;
                                                                                                                $filaFrm=$con->obtenerPrimeraFila($consulta);
                                                                                                                $idFormulario=$filaFrm[1];
                                                                                                                $idElemento=$filaFrm[0];
																												if($idElemento=="")
																													$idElemento="-1";
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
                                                                                                                                    <a href='javascript:configurarDictamenRevisor(".$filaPA[0].",".$filaP[0].",".$idElemento.")'><img src='../images/pencil.png' alt='Modificar opciones de dictamen' title='Modificar opciones de dictamen'></a>
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
																											echo '<span class="copyrigth" ><b>'.$filaPA[1].'</span>&nbsp;&nbsp;';
																											?>
                                                                                                            <a href="javascript:removerAccion(<?php echo $filaPA[0]?>)"><img src="../images/delete.png" alt="Remover acción" title="Remover acción" /></a>&nbsp;&nbsp;
                                                                                                            <?php
                                                                                                            if($filaPA[3]=="")
                                                                                                                $btnComp="<a href='javascript:configurarDictamenParcial(".$filaPA[0].",".$filaP[0].")'><img src='../images/warning.png' title='Este elemento requiere que se le indique la etapa al cual pasar&aacute; el proceso de acuerdo al dictamen tomado, para configurarlo de click sobre este ícono' alt='Este elemento requiere que se le indique la etapa al cual pasar&aacute; el proceso de acuerdo al dictamen tomado, para configurarlo de click sobre este ícono'></a>";
                                                                                                            else
                                                                                                            {
                                                                                                                $consulta="select idElementoDictamen,idFormulario from 948_actoresVSFormulariosDictamen where idActorVSFormularioDictamen=".$filaPA[3];
                                                                                                                
                                                                                                                $filaFrm=$con->obtenerPrimeraFila($consulta);
                                                                                                                $idFormulario=$filaFrm[1];
                                                                                                                $idElemento=$filaFrm[0];
                                                                                                                $consulta="(select of.valor,Contenido,cv.opcion,s.texto from 902_opcionesFormulario of,954_accionesDictamenParcial d,951_catalogoOpcionesVarios cv,1004_siNo s
                                                                                                                            where s.valor=of.requiereRespuesta and s.idIdioma=".$_SESSION["leng"]." and cv.tipoOpcion=2 and cv.valorOpcion=d.idAccion and cv.idIdioma=of.idIdioma and  d.idValor=of.valor and 
                                                                                                                            d.idGrupoElemento=of.idGrupoElemento and of.idGrupoElemento=".$idElemento." and of.idIdioma=".$_SESSION["leng"].")
                                                                                                                            order by valor";
                                                                                                                
                                                                                                                
                                                                                                                $btnComp="	<br><br><table>
                                                                                                                                <tr>
                                                                                                                                    <td colspan='3' class='copyrigth'>Resoluciones de dictamen:&nbsp;&nbsp;<a href='javascript:verFormulario(".$idFormulario.")'><img src='../images/icon_code.gif' alt='Configurar formulario de dictamen parcial' title='Configurar formulario de dictamen parcial'></a><br><br></td>
                                                                                                                                </tr>
                                                                                                                                <tr>
                                                                                                                                    <td width='40' class='fondoVerde7' align='center'>
                                                                                                                                    <span class='letraAzulSubrayada7'>C&oacute;digo</span></td>
                                                                                                                                    <td width='180' class='fondoVerde7' align='center'>
                                                                                                                                    <span class='letraAzulSubrayada7'>Dict&aacute;men</span></td>
                                                                                                                                    <td width='220' class='fondoVerde7' align='center'>
                                                                                                                                    <span class='letraAzulSubrayada7'>Acci&oacute;n autor</span>
																																	</td>
                                                                                                                                   
																																	<td width='60' class='fondoVerde7' align='center'>
                                                                                                                                    <span class='letraAzulSubrayada7'>Req. respuesta</span>
																																	</td>
                                                                                                                                    <td>
																																	&nbsp;&nbsp;
                                                                                                                                    <a href='javascript:configurarDictamenParcial(".$filaPA[0].",".$filaP[0].",".$idElemento.")'><img src='../images/pencil.png' alt='Modificar opciones de dictamen' title='Modificar opciones de dictamen'></a>
                                                                                                                                    </td>
                                                                                                                                </tr>";
                                                                                                                $resOpt=$con->obtenerFilas($consulta);
                                                                                                                while($filasOpt=mysql_fetch_row($resOpt))
                                                                                                                {
                                                                                                                    $btnComp.=" <tr>
                                                                                                                                    <td class='fondoGrid7'>".$filasOpt[0]."</td><td class='fondoGrid7'>".$filasOpt[1]."</td><td class='fondoGrid7'>".$filasOpt[2]."</td><td class='fondoGrid7'>".$filasOpt[3]."</td><td></td>
                                                                                                                                </tr>";
                                                                                                                }
                                                                                                                        
                                                                                                                
                                                                                                                $btnComp.="
                                                                                                                                </table><br><br>		
                                                                                                                            ";
                                                                                                                
                                                                                                            }
                                                                                                        break;
                                                                                                        case "5":
																											echo '<span class="copyrigth" ><b>'.$filaPA[1].'</span>&nbsp;&nbsp;';
																											?>
                                                                                                            <a href="javascript:removerAccion(<?php echo $filaPA[0]?>)"><img src="../images/delete.png" alt="Remover acción" title="Remover acción" /></a>&nbsp;&nbsp;
                                                                                                            <?php
                                                                                                            if($filaPA[3]=="")
                                                                                                                $btnComp="<a href='javascript:configurarDictamenFinal(".$filaPA[0].",".$filaP[0].")'><img src='../images/warning.png' title='Este elemento requiere que se le indique la etapa al cual pasar&aacute; el proceso de acuerdo al dictamen tomado, para configurarlo de click sobre este ícono' alt='Este elemento requiere que se le indique la etapa al cual pasar&aacute; el proceso de acuerdo al dictamen tomado, para configurarlo de click sobre este ícono'></a>";
                                                                                                            else
                                                                                                            {
                                                                                                                $consulta="select idElementoDictamen,idFormulario from 948_actoresVSFormulariosDictamen where idActorVSFormularioDictamen=".$filaPA[3];
																												
																												$filaFrm=$con->obtenerPrimeraFila($consulta);
                                                                                                                $idFormulario=$filaFrm[1];
                                                                                                                $idElemento=$filaFrm[0];
																												if($idElemento=="")
																													$idElemento="-1";
                                                                                                                $consulta="(select valor,Contenido,idEtapa from 902_opcionesFormulario of,911_disparadores d
                                                                                                                            where  d.idValor=of.valor and 
                                                                                                                            d.idGrupoElemento=of.idGrupoElemento and of.idGrupoElemento=".$idElemento." and of.idIdioma=".$_SESSION["leng"].")
                                                                                                                            union
                                                                                                                            (select valor,Contenido,'0' as etapa from 902_opcionesFormulario of,911_disparadores d
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
                                                                                                                                    <a href='javascript:configurarDictamenFinal(".$filaPA[0].",".$filaP[0].",".$idElemento.")'><img src='../images/pencil.png' alt='Modificar opciones de dictamen' title='Modificar opciones de dictamen'></a>
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
                                                                                                                    $btnComp.=" <tr>
                                                                                                                                    <td class='fondoGrid7'>".$filasOpt[0]."</td><td class='fondoGrid7'>".$filasOpt[1]."</td><td class='fondoGrid7'>".$enviaEtapa."</td><td></td>
                                                                                                                                </tr>";
                                                                                                                }
                                                                                                                        
                                                                                                                $consulta="select ac.idGrupoAccion from 944_actoresProcesoEtapa pe,947_actoresProcesosEtapasVSAcciones ac 
                                                                                                                            where ac.idActorProcesoEtapa=pe.idActorProcesoEtapa and pe.numEtapa=".$filaP[0]." and pe.idProceso=".$idProceso." and 
                                                                                                                            pe.idActorProcesoEtapa<>".$filaAc[2]." and ac.idGrupoAccion in(4,5)";		
                                                                                                                $idEvaluacion=$con->obtenerValor($consulta);
                                                                                                                if($idEvaluacion!="")
                                                                                                                {
                                                                                                                    $btnComp.="	<tr>
                                                                                                                                    <td colspan='3'>
                                                                                                                                        <table>
                                                                                                                                        <tr>
                                                                                                                                            <td>
                                                                                                                                                <span class='corpo8'><br>
                                                                                                                                                ¿Dictamen condicionado a evaluaci&oacute;n de otro actor?
                                                                                                                                                </span>
                                                                                                                                            </td>
                                                                                                                                            <td ><br>&nbsp;&nbsp;
                                                                                                                                                <select id='cmbCondicionado_".$filaPA[0]."' onchange='condicionadoCambio(this,".$filaPA[0].",".$filaP[0].")'>";
                                                                                                                    $consulta="select valor,texto from 1004_siNo where idIdioma=".$_SESSION["leng"]." order by valor";	
                                                                                                                    if($filaPA[4]!="")
                                                                                                                        $siNo=1;
                                                                                                                    else
                                                                                                                        $siNo=0;
                                                                                                                    $btnComp.=$con->generarOpcionesSelectNoImp($consulta,$siNo);
                                                                                                                    $btnComp.=				"	</select>
                                                                                                                                            </td><td></td>
                                                                                                                                        </tr>";
                                                                                                                    if($siNo==1)
                                                                                                                    {
                                                                                                                        $btnComp.="		
                                                                                                                                        <tr id='filaTexto_".$filaPA[0]."'>
                                                                                                                                                <td class='letraAzulSubrayada7Simple' colspan='2'><br><br>
                                                                                                                                                    Para que el proceso de dictámen final sea permitido, los siguientes actores deberán primero haber llevado a cabo su dictamen correspondiente:  
                                                                                                                                                    <br><br>
                                                                                                                                                </td>
                                                                                                                                        </tr>
                                                                                                                                        <tr id='filaTablaDictamen_".$filaPA[0]."'>
                                                                                                                                        <td colspan='3'>
                                                                                                                                            <br>
                                                                                                                                            <table>
                                                                                                                                                
                                                                                                                                                <tr>
                                                                                                                                                    <td class='fondoVerde7' width='260' align='center'><span class='letraAzulSubrayada7'>Actor</span></td>
                                                                                                                                                    <td><a href='javascript:agregarDependenciaDictamen(".$filaPA[0].",".$filaP[0].")'><img src='../images/add.png' title='Agregar dependencia de dictamen' alt='Agregar dependencia de dictamen'></a></td></tr>";
                                                                                                                                                    
                                                                                                                        
                                                                                                                        $consulta="select ae.actor,tipoActor,aa.idAccionesProcesoEtapaVSAcciones from 944_actoresProcesoEtapa ae,947_actoresProcesosEtapasVSAcciones aa 
                                                                                                                                    where ae.idActorProcesoEtapa=aa.idActorProcesoEtapa and aa.idAccionesProcesoEtapaVSAcciones in(".$filaPA[4].")";
 																														
                                                                                                                        $resActorD=$con->obtenerFilas($consulta);
                                                                                                                        while($filaActorD=mysql_fetch_row($resActorD))
                                                                                                                        {
                                                                                                                            $actorD=$filaActorD[0];
                                                                                                                            switch($filaActorD[1])
                                                                                                                            {
                                                                                                                                case "1":
                                                                                                                                   $actorD=obtenerTituloRol($actorD);
                                                                                                                                    
                                                                                                                                    
                                                                                                                                break;
                                                                                                                                case "2":
                                                                                                                                    $consulta="select nombreComite from 234_proyectosVSComitesVSEtapas e,2006_comites c where c.idComite=e.idComite 
                                                                                                                                                and  e.idProyectoVSComiteVSEtapa=".$actorD;	
                                                                                                                                    $actorD=$con->obtenerValor($consulta);
                                                                                                                                
                                                                                                                                break;
                                                                                                                            }
                                                                                                                            
                                                                                                                            
                                                                                                                            $btnComp.="<tr>
                                                                                                                                            <td class='fondoGrid7'>".$actorD."</td>
                                                                                                                                            <td><a href='javascript:removerDependencia(".$filaActorD[2].",".$filaPA[0].")'><img src='../images/delete.png' title='Remover dependencia de dictamen' alt='Remover dependencia de dictamen'></a></td>
                                                                                                                                            <td></td>
                                                                                                                                        </tr>";
                                                                                                                        }
                                                                                                                        $btnComp.="
                                                                                                                                            </table>
                                                                                                                                    
                                                                                                                                        </td>
                                                                                                                                    </tr>";
                                                                                                                    }
                                                                                                                                        
                                                                                                                    $btnComp.="					
                                                                                                                                        </table>
                                                                                                                                    </td>
                                                                                                                                    
                                                                                                                                </tr>";
                                                                                                                }
                                                                                                                $btnComp.="
                                                                                                                                </table><br><br>		
                                                                                                                            ";
                                                                                                                
                                                                                                            }
                                                                                                        break;
                                                                                                        case 9:
                                                                                                        case 11:
                                                                                                            if($filaPA[3]=="")
                                                                                                                $btnComp="<a href='javascript:configurarVerRegistros(".$filaPA[0].",\"\",2)'><img src='../images/warning.png' title='Este elemento requiere que se le indique los registros que podrá ver el actor, para configurarlo de click sobre este ícono'  alt='Este elemento requiere que se le indique los registros que podrá ver el actor, para configurarlo de click sobre este ícono'></a>";
                                                                                                            else
                                                                                                            {
                                                                                                                $consulta="select opcion from 951_catalogoOpcionesVarios where valorOpcion=".$filaPA[3]." and tipoOpcion=".$tOpcion." and idIdioma=".$_SESSION["leng"];
                                                                                                                $verRegistro=$con->obtenerValor($consulta);
                                                                                                                $btnComp="<span class='letraAzulSubrayada7'> (".$verRegistro.") </span>&nbsp;&nbsp;<a href='javascript:configurarVerRegistros(".$filaPA[0].",".$filaPA[3].",2)'><img src='../images/pencil.png' title='Cambiar tipo de registros visto por actor' alt='Cambiar tipo de registros visto por actor'></a>";
                                                                                                            }
																											$btnComp.="	<br><br><table>
                                                                                                                                <tr>
                                                                                                                                    <td colspan='3' class='copyrigth'>Posibles resoluciones de dictamen:&nbsp;&nbsp;<br><br></td>
                                                                                                                                </tr>
                                                                                                                                <tr>
                                                                                                                                    
                                                                                                                                    <td width='60' class='fondoVerde7' align='center'>
                                                                                                                                    <span class='letraAzulSubrayada7'>C&oacute;digo</span></td>
                                                                                                                                    <td width='200' class='fondoVerde7' align='center'>
                                                                                                                                    <span class='letraAzulSubrayada7'>Dict&aacute;men</span></td>
                                                                                                                                    <td width='240' class='fondoVerde7' align='center'>
                                                                                                                                    <span class='letraAzulSubrayada7'>Envia a etapa</span></td>
                                                                                                                                    <td>&nbsp;&nbsp;
                                                                                                                                    <a href='javascript:configurarEvaluacion(".$filaPA[0].",".$filaP[0].")'><img src='../images/pencil.png' alt='Modificar opciones de dictamen' title='Modificar opciones de dictamen'></a>
                                                                                                                                    </td>
                                                                                                                                </tr>";
																											$consulta="select valor, contenido,etapa from 9114_opcionesEvaluacion where idIdioma=".$_SESSION["leng"]." and idAccion=".$filaPA[0]." order by valor";
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
																												$btnComp.=" <tr>
																																<td class='fondoGrid7'>".$filasOpt[0]."</td><td class='fondoGrid7'>".$filasOpt[1]."</td><td class='fondoGrid7'>".$enviaEtapa."</td><td></td>
																															</tr>";
																											}
																											$btnComp.="</table>";
																											
                                                                                                        break;
                                                                                                        case 12:
                                                                                                            if($filaPA[3]=="")
                                                                                                                $btnComp="<a href='javascript:configurarSometeRevision(".$filaPA[0].",".$filaP[0].",\"\",12)'><img src='../images/warning.png' title='Este elemento requiere que se le 
																														indique la etapa de la cual obtendrá los comites disponibles de asignaci&oacute;n, para configurarlo de click sobre este ícono'  alt='Este elemento requiere que se le indique 
																														la etapa de la cual obtendrá los comites disponibles de asignaci&oacute;n, para configurarlo de click sobre este ícono'></a>";
                                                                                                            else
                                                                                                            {
                                                                                                                $consulta="select nombreEtapa from 4037_etapas where idProceso=".$idProceso." and numEtapa=".$filaPA[3];
                                                                                                                $etapaPasa=removerCerosDerecha($filaPA[3]).".- ".$con->obtenerValor($consulta);
                                                                                                                  $btnComp="<span class='corpo8'><font color='#000055'><b>Asignar comités de la etapa:</b></font><br><font color='green'><b> ".$etapaPasa."</b></font></span>&nbsp;&nbsp;<a href='javascript:modificarPasoEtapa(".$filaPA[0].",".$filaP[0].",".$filaPA[3].",12)'><img src='../images/pencil.png' title='Cambiar etapa' alt='Cambiar etapa'></a>";
                                                                                                            }
                                                                                                        break;
																										case 20:
																											if($filaPA[3]=="")
                                                                                                                $btnComp="<a href='javascript:configurarTiempoPresupuestal(".$filaPA[0].")'><img src='../images/warning.png' title='Este elemento requiere que se le indique el tiempo presupuestal que tomar&aacute;n las partidas al ser autorizadas'  alt='Este elemento requiere que se le indique el tiempo presupuestal que tomar&aacute;n las partidas al ser autorizadas'></a>";
                                                                                                            else
                                                                                                            {
                                                                                                                $consulta="SELECT nombreTiempo FROM 524_tiemposPresupuestales WHERE idTiempoPresupuestal=".$filaPA[3];
	                                                                                                            $tiempoP=$con->obtenerValor($consulta);
                                                                                                                $btnComp="<span class='corpo8'><font color='#000055'><b>Tiempo presupuestal:</b></font><br><font color='green'><b> ".$tiempoP."</b></font></span>&nbsp;&nbsp;<a href='javascript:configurarTiempoPresupuestal(".$filaPA[0].",".$filaPA[3].")'><img src='../images/pencil.png' title='Modificar el tiempo presupuestal que tomar&aacute;n las partidas al ser autorizadas' alt='Modificar el tiempo presupuestal que tomar&aacute;n las partidas al ser autorizadas'></a>";
                                                                                                            }
																										break;
																										
                                                                                                    }
                                                                                                    echo $btnComp;
                                                                                                ?>
                                                                                                </span>
                                                                                    		</td>
                                                                                    	</tr>
                                                                                        </table>
                                                                                    <br /><br />
                                                                                    	
                                                                                    </td>
                                                                                </tr>
                                                                        <?php			
																				}
																				
																			?>
                                                                        	 </table>
                                                                        </td>
                                                                    	<td align="right" valign="top"><a href="javascript:agregarAccion(<?php echo $filaAc[2]?>)"><img src='../images/addAccion.png' title="Agregar acción" alt="Agregar acción" /></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            
                                                        </tr>
													<?php
												}
                                            ?>
                                            
												
										<?php		
											}
										?>
                                        </table>
                                    </td>
                                    <td width="10" class="">
                                    <input type="hidden" id="idProceso" value="<?php echo $idProceso ?>" />
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
