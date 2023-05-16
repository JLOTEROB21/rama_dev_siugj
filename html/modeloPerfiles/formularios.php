<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");
header("Content-Type:text/html;charset=utf-8");
$idFormulario="-1";
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
	$mostrarMenuIzq=false;
	$tituloModulo="Formulario";
	$guardarConfSession=true;
?>
<script type="text/javascript" src="../Scripts/base64.js"></script>
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
	$guardarConfSession=true;
	//$pagRegresar="javascript:regresar()";
?>
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
                   		<?php
							$oCamposComp=false;
							if(isset($objParametros->oCamposComp))
								$oCamposComp=true;
						?>
                   		<script type="text/javascript" src="../modeloPerfiles/Scripts/formularios.js.php"></script>
						<script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
                        <link rel="stylesheet" type="text/css" href="../Scripts/ux/grid/RowEditor.css"/>
                        <script type="text/javascript" src="../Scripts/ux/checkColumn.js"></script>
                        <script type="text/javascript" src="../Scripts/ux/grid/RowEditor.js"></script>
                        <td align="center">
                        	<table>
                            <tr>
                            	
                                <td width="100%" align="center">
                                	<?php
										$redireccionarFormulario=0;
										if(isset($objParametros->redireccionarFormulario))
											$redireccionarFormulario=$objParametros->redireccionarFormulario;
										$accionCancelar="";
										if(isset($objParametros->accionCancelar))
											$accionCancelar=$objParametros->accionCancelar;
										$idFormulario="-1";
										if(isset($objParametros->idFormulario))
										{
											$idFormulario=$objParametros->idFormulario;	
										}
										$idProceso="-1";
										if(isset($objParametros->idProceso))
										{
											$idProceso=$objParametros->idProceso;	
										}
										else
										{
											$consulta="select idProceso from 900_formularios where idFormulario=".$idFormulario;
											$idProceso=$con->obtenerValor($consulta);
										}
											
										if($idFormulario!="-1")
										{
											$consulta="select nombreTabla from 900_formularios where idFormulario=".$idFormulario;
											$nombreTabla=$con->obtenerValor($consulta);
											if($nombreTabla=="")
											{
												$query="begin";
												if($con->ejecutarConsulta($query))
												{
													
													$nombreTabla="_".$idFormulario."_tablaDinamica";
													$consultaT[0]="update 900_formularios set nombreTabla='".$nombreTabla."' where idFormulario=".$idFormulario;
													$consultaT[1]="commit";
													$con->ejecutarBloque($consultaT);
														
												}
											}
										}
											
										$consulta="select * from 900_formularios where idFormulario=".$idFormulario;
										$fila=$con->obtenerPrimeraFila($consulta);
										$tipoProceso=obtenerTipoProceso($idProceso);
										
										
									
										$estiloLetraFormulario="SIUGJ_Etiqueta";
										$estiloLetraControles="SIUGJ_Control";	
									
										$cadConf=$fila[29];
										$obj=NULL;
										if(strpos($cadConf,"{")!==false)
											$obj=json_decode($cadConf);
										$campoDictamen="-1";
										$campoComentario="-1";
										$mostrarSeccionEvaluacion=false;
										if($obj!=null)
										{
											if(isset($obj->campoDictamen))
												$campoDictamen=$obj->campoDictamen;
											if(isset($obj->campoComentario))
												$campoComentario=$obj->campoComentario;
													
										}
									 	switch($fila[21])
										{
											case 13: //Dictamen parcial
											case 14: //Dictamen parcial
											case 15:  //Dictamen revisor
												$mostrarSeccionEvaluacion=true;	
											break;
										}
												
									
									?>
                                
                                	
                                    <br />
                                    <form action="../paginasFunciones/guardarDatos.php" method="post" id="frmEnvio">
                                    
                                    	<table  width="900" border="0">
                                        	<tr>
                                                <td colspan="2">
                                                    <?php
                                                    echo formatearTituloPagina($tituloModulo,true,$idProceso);
                                                    ?>
                                                </td>
                                                
                                            </tr>
                                            <tr height="50">
                                              <td width="450" align="left">
                                                  <span class="<?php echo $estiloLetraFormulario?>">
                                                      Nombre del formulario *
                                                  </span>
                                              </td>
                                              <td width="450" align="left">
                                                  <span class="<?php echo $estiloLetraFormulario?>">
                                                      Título corto *
                                                  </span>
                                              </td>
                                            </tr>
                                            <tr height="50">
                                              <td align="left">
                                                  <input class="<?php echo $estiloLetraControles?>"  type="text" name="_nombreFormulariovch" id="_nombreFormulariovch" val="obl" campo="Nombre del formulario" maxlength="255"  style="width:420px"  value="<?php echo $fila["1"] ?>"  />
                                              </td>
                                              <td  align="left">
                                                  <input class="<?php echo $estiloLetraControles?>"  type="text" name="_titulovch" id="_titulovch" val="obl" campo="Título corto" maxlength="150" style="width:420px" value="<?php echo $fila["6"] ?>"    /> 
                                              </td>
                                            </tr>
                                            
                                            <tr height="50">
                                              <td colspan="2" align="left">
                                                  <span class="<?php echo $estiloLetraFormulario?>">
                                                      Descripci&oacute;n
                                                  </span>
                                              </td>
                                              
                                            </tr>
                                            <tr height="50">
                                              <td colspan="2" align="left">
                                                  <textarea class="<?php echo $estiloLetraControles?>"  name="_descripcionvch" id="_descripcionvch" style="width:800px; height:80px !important;"><?php echo $fila["5"]; ?></textarea>
                                              </td>
                                              
                                            </tr>
                                            
                                            <?php
											if(!$mostrarSeccionEvaluacion)
											{
											?>
                                            
                                                <tr height="50">
                                                  <td width="450" align="left">
                                                      <span class="<?php echo $estiloLetraFormulario?>">
                                                          Etapa *
                                                      </span>
                                                  </td>
                                                  <td width="450" align="left">
                                                      <span class="<?php echo $estiloLetraFormulario?>">
                                                          ¿Formulario principal del proceso? *
                                                      </span>
                                                  </td>
                                                </tr>
                                                <tr height="50">
                                                  <td align="left">
                                                      <select class="<?php echo $estiloLetraControles?>"  name="_idEtapaint" id="_idEtapaint"  val="obl" campo="Etapa" onchange="setEstadoInicial()" style="width:380px">
                                                      <option value="-1">Elija una opción</option>
                                                        <?php
                                                            
                                                            $frmBaseConf='';
                                                            if($fila[12]!="")
                                                            {
                                                                $query="select formularioBase from 900_formularios where idFormulario<>".$idFormulario." and formularioBase=1 and idProceso=".$idProceso;
                                                                $idFrmBase=$con->obtenerValor($query);
                                                                
                                                                if($idFrmBase=="1")
                                                                    $frmBaseConf="oE('filaFormularioPrincipal');ignorarOFB=true;";
                                                            }
                                                            $consulta="select numEtapa,concat(numEtapa,'.- ',nombreEtapa) as nombreEtapa from 4037_etapas where idProceso=".$idProceso." order by numEtapa";
                                                            $con->generarOpcionesSelect($consulta,$fila[13]);
                                                        ?>
                                                        </select>
                                                  </td>
                                                  <td  align="left">
                                                      <select class="<?php echo $estiloLetraControles?>"  name="_formularioBaseint" id="_formularioBaseint"  val="obl" campo="¿Formulario principal del proceso?" onchange="formularioPrincipal(this)" style="width:380px">
                                                      <?php
                                                          $consulta="select valor,texto from 1004_siNo where idIdioma=".$_SESSION["leng"];
                                                          $con->generarOpcionesSelect($consulta,$fila[16]);
                                                      ?>
                                                      </select>
                                                  </td>
                                                </tr>
                                                <tr height="50">
                                                  <td width="450" align="left">
                                                      <span class="<?php echo $estiloLetraFormulario?>">
                                                          Formulario entidad
                                                      </span>
                                                  </td>
                                                  <td width="450" align="left">
                                                      <span class="<?php echo $estiloLetraFormulario?>">
                                                          Repetible *
                                                      </span>
                                                  </td>
                                                </tr>
                                                <tr height="50">
                                                  <td align="left">
                                                      <select class="<?php echo $estiloLetraControles?>"  name="_idFrmEntidadint" id="_idFrmEntidadint" onchange="accionRepetible(this)"  style="width:380px">
                                                      <option value="-1">Elija una opción</option>
                                                        <?php
                                                        
                                                            $consulta="select idFormulario,titulo from 900_formularios where idFormulario<>".$idFormulario." and idProceso=".$idProceso." and tipoFormulario<>10";
                                                            $con->generarOpcionesSelect($consulta,$fila[14]);
                                                        ?>
                                                            
                                                            
                                                        </select>
                                                  </td>
                                                  <td  align="left">
                                                      <select class="<?php echo $estiloLetraControles?>"  name="_frmRepetibleint" id="_frmRepetibleint"  campo='Repetible' style="width:380px" onchange="verificarListadoRegistros(this)">
                                                      <option value="-1">Elija una opción</option>
                                                        <?php
                                                            $consulta="select valor,texto from 1004_siNo where idIdioma=".$_SESSION["leng"];
                                                            $con->generarOpcionesSelect($consulta,$fila[15]);
                                                        ?>
                                                            
                                                            
                                                        </select>
                                                  </td>
                                                </tr>
                                            <?php
											}
											?>
                                            <tr height="50">
                                              <td width="450" align="left">
                                                  <span class="<?php echo $estiloLetraFormulario?>">
                                                      Estado *
                                                  </span>
                                              </td>
                                              <td width="450" align="left">
                                                  <span class="<?php echo $estiloLetraFormulario?>">
                                                      Funci&oacute;n a ejecutar al crear un registro
                                                  </span>
                                              </td>
                                            </tr>
                                            <tr height="50">
                                              <td align="left">
                                                  <select class="<?php echo $estiloLetraControles?>"  name="_estadoint" id="_estadoint" style="width:380px">
                                                        <?php
                                                            $consulta="select * from 4005_status order by idStatus";
                                                            $con->generarOpcionesSelect($consulta,$fila[3]);
                                                        ?>
                                                        </select>
                                              </td>
                                              <td  align="left">
                                                  	<input class="<?php echo $estiloLetraControles?>"    type="text" name="_funcionNuevoRegistrovch" id="_funcionNuevoRegistrovch" value="<?php echo $fila[27]?>" style="width:380px">
                                              </td>
                                            </tr>
                                            <tr height="50">
                                              <td width="450" align="left">
                                                  <span class="<?php echo $estiloLetraFormulario?>">
                                                      Funci&oacute;n a ejecutar al modificar un registro
                                                  </span>
                                              </td>
                                              <td width="450" align="left">
                                                  <span class="<?php echo $estiloLetraFormulario?>">
                                                      Funci&oacute;n validadora de eliminación de registro
                                                  </span>
                                              </td>
                                            </tr>
                                            <tr height="50">
                                              <td align="left">
                                                  <input class="<?php echo $estiloLetraControles?>"  style="width:380px" type="text" name="_funcionModificaRegistrovch" id="_funcionModificaRegistrovch" value="<?php echo $fila[28]?>">
                                              </td>
                                              <td  align="left">
                                                  <input class="<?php echo $estiloLetraControles?>"  style="width:380px" type="text" name="_funcionEliminacionRegistrovch" id="_funcionEliminacionRegistrovch" value="<?php echo $fila[33]?>">
                                              </td>
                                            </tr>
                                            
                                            <?php
											if($mostrarSeccionEvaluacion)
											{
											?>
                                                <tr height="50">
                                                  <td  align="left" colspan="2">
                                                      <span class="letraTituloSeccion">
                                                          Configuraci&oacute;n de resultado de evaluaci&oacute;n
                                                      </span>
                                                  </td>
                                                </tr>
                                                <tr height="50">
                                                  <td width="450" align="left">
                                                      <span class="<?php echo $estiloLetraFormulario?>">
                                                          Campo de evaluaci&oacute;n *
                                                      </span>
                                                  </td>
                                                  <td width="450" align="left">
                                                      <span class="<?php echo $estiloLetraFormulario?>">
                                                          Campo de comentario *	
                                                      </span>
                                                  </td>
                                                </tr>
                                                <tr height="50">
                                                  <td align="left">
                                                      <select class="<?php echo $estiloLetraControles?>"  id="campoDictamen"  val='obl' campo="Campo de evaluaci&oacute;n" style="width:380px">
                                                      <option value="-1">Seleccione</option>
                                                      <?php
                                                          $consulta="select idGrupoElemento,nombreCampo from 901_elementosFormulario where tipoElemento in (2,3,4,14,15,16) and idFormulario=".$idFormulario;
                                                          $con->generarOpcionesSelect($consulta,$campoDictamen);
                                                      ?>
                                                      </select>
                                                  </td>
                                                  <td  align="left">
                                                      <select class="<?php echo $estiloLetraControles?>"  id="campoComentario" val='obl' campo="Campo de comentario" style="width:380px">
                                                      <option value="-1">Seleccione</option>
                                                        <?php
                                                            $consulta="select idGrupoElemento,nombreCampo from 901_elementosFormulario where tipoElemento in (5,9,10) and idFormulario=".$idFormulario;
                                                            $con->generarOpcionesSelect($consulta,$campoComentario);
                                                        ?>
                                                        </select>
                                                        <input type="hidden" id="_configuracionFormulariovch" name="_configuracionFormulariovch" value="<?php echo bE($cadConf)?>" />
                                                  </td>
                                                </tr>
                                    	
                                        	<?php
											}
											?>
                                            
                                            
                                            <tr height="50">
                                              <td  colspan="2" align="center"><br />
                                                  <table cellspacing="10">
                                                  	<tr>
                                                    	<td width="400" align="left" class="opcionesConfiguracionFormulario">
                                                        	<a href="javascript:configurarCuestionario('<?php echo $idFormulario ?>')">Diseño del formulario</a>
                                                        </td>
                                                        <td width="400" align="left" class="opcionesConfiguracionFormulario">
                                                        	<a href="javascript:ventanaFolios()">Administración de folios</a> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="400" align="left" class="opcionesConfiguracionFormulario">
                                                        	<a href="javascript:configurarVistaFormulario('<?php echo $idFormulario ?>')">Configurar vista de formulario</a>
                                                        
                                                        </td>
                                                        <td width="400" id="tdListadoRegistro" align="left" class="<?php echo (($fila[15]==1)||($fila[16]=="1"))?"opcionesConfiguracionFormulario":"" ?>">
                                                        	<a id="linkListadoRegistro" style="display: <?php echo (($fila[15]==1)||($fila[16]=="1"))?"":"none" ?>" href="javascript:enviarListadoConf('<?php echo $idFormulario ?>')">Configuración del listado de registros</a> 
                                                        
                                                        
                                                        
                                                        </td>
                                                    </tr>
                                                  </table>
                                              </td>
                                            </tr>
                                            
                                            
                                        </table>
                                        
                                        
                                        <table width="980">
                                        	
                                            
                                            <tr>
                                                <td colspan="2">
                                                    <br /><br />
                                                    <table width="100%">
                                                    <tr>
                                                        
                                                        <td align="center">
                                                        	<br />
							
                                                                <table>
                                                                <tr>
                                                                    <td>
																	<input type="button" value="Cancelar" onclick="cancelarOperacion()" class="btnSIUGJCancel" style="width:140px"/>  
                                                                    </td>
                                                                    <td width="10">
                                                                    </td>
                                                                    
                                                                    <td>
																		<input type="button" value="Guardar" onclick="validarFormulario('frmEnvio')" class="btnSIUGJ" style="width:140px" /> 
                                                                    </td>
                                                                </tr>
                                                                </table>
															<?php
																if($idFormulario=="-1")
																{
															?>
																	
																	<input type="hidden" name="_fechaCreaciondta" value=" " />
																	<input type="hidden" name="_responsableint" value="<?php echo $_SESSION["idUsr"]?>" />
                                                                   <!-- <input type="hidden" name="ejecutarProcedimiento" value="crearEntradaFormularioProyecto(idRegPadre)" />-->
																	<input type='hidden' name='reemplazarIDSesion' value="<?php echo $nConfiguracion ?>">
                                                                    <input type="hidden" name="sentenciaReemplazo" value='"idFormulario":"-1"' />
                                                                    <input type="hidden" name="valorReemplazo" value='"idFormulario":"idRegPadre"' />
                                                                    <input type="hidden" name="valorPost" value="" />
															<?php
																}
																else
																{
															?>
																	
																	<input type="hidden" name="_fechaModifdta" value=" " />
																	<input type="hidden" name="_respModifint" value="<?php echo $_SESSION["idUsr"]?>" />
															<?php 
																}
															?>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    </table>                                         
                                                </td>
                                            </tr>
            
                                        </table>
                                        <input type="hidden" name="_vistaListadoRegistrosint" id="_vistaListadoRegistrosint" value="0" />
                                        <input type="hidden" id="idFrm" value="<?php echo $idFormulario?>">
                                        <input type="hidden" name="_asociadoProcesoint" value="1" />
                                        <input type="hidden" name="tabla" value="900_formularios" />
                                        <input type="hidden" name="id" value="<?php echo $idFormulario?>" />
                                        <input type="hidden" name="campoId" value="idFormulario" />
                                        <?php
											$idEdoInicial=$fila[17];
											if($idEdoInicial=="")
												$idEdoInicial=1;
											//if($idFormulario=='-1')
												$paginaRedireccion="../modeloPerfiles/formularios.php";
											//else
												//$paginaRedireccion="../modeloPerfiles/procesos.php";
												
										?>
                                        
                                        <input type="hidden" name="pagRedireccion" value="<?php echo $paginaRedireccion ?>"/>
                                        <input type="hidden" name="post" value="idFormulario" />
                                        
                                        <?php
											if($tipoProceso!=1000)
											{
										?>
                                       	<input type="hidden" name="_estadoInicialint" id="_estadoInicialint" value="<?php echo $idEdoInicial ?>" />
										<?php
											}
										?>
                                        <input type="hidden" name="_idProcesoint" id="_idProcesoint" value="<?php echo $idProceso ?>" />
                                        <input type="hidden" name="paramPost" value='[{"nombreP":"configuracion","valorP":"<?php echo $nConfiguracion ?>"}]' />
                                    </form>
                                    <br />
                                    <input type="hidden" id="accionCancelar" value="<?php echo $accionCancelar?>" />
                                    <input type="hidden" id="redireccionarFormulario" value="<?php echo $redireccionarFormulario?>" />
                                    <form method="post" action="configurarFormulario.php" id="frmConfFormulario">
                                    <input type="hidden" name="idFormulario" id="idFormulario" value="" />
                                    </form>
                                    <form action="../procesos/procesos.php" method="post" name="frmRegresarForm" id="frmRegresarForm">
                                    	<input type="hidden" name="idProceso" value="<?php echo $idProceso?>" />
                                        <input type="hidden" name="tabActivo" value="2" />
                                    </form>
                                    <br />
                                    
                        		</td>
                            	<td></td>
                        	</tr>
                            
							</table>                           
						</td>
                        <script>
							<?php 
								//echo $frmBaseConf;
							?>
						</script>
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
