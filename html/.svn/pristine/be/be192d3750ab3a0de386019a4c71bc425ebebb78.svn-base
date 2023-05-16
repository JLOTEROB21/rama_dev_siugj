<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");
$accion="";
$idUsuario="-1";
if(isset($_POST["accion"]))
	$accion=$_POST['accion'];
if(isset($_POST['idUsuario']))
	$idUsuario=$_POST['idUsuario'];

$sql="SELECT Institucion,Dependencia,cod_Area,cod_Puesto,Ads.Tipo,Calle,Numero,Colonia,Ciudad,CP,Estado,Pais,puestoAbierto,Status ";
$sql.="FROM 801_adscripcion Ads,803_direcciones Dir ";

if(isset($idUsuario))//Si esta puesta
	$sql.="WHERE Ads.idUsuario=Dir.idUsuario AND Dir.Tipo=1 AND Ads.idUsuario=".$idUsuario;
else
	$sql.="WHERE 1=-1";
	
	$cInfo=$con->obtenerRegistros($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
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

<script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
<script type="text/javascript" src="Scripts/nAdscripcion.js"></script>
<?php 
$pagRegresar="javascript:regresar(".$idUsuario.")";
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
                        <td>
						<center> <p><b>ADMINISTRACIÓN DE USUARIOS</p> </center><br />
						<form action="intermediaProcesar.php" id="nAdscripcion" method="post">
						<table border="0" cellspacing="1" cellpadding="1" width="630">
						<tr>
							<td>
								<fieldset class="frameHijo"><legend><b>DATOS DE LABORALES</b></legend>
								<br />
								<table width="630" border="0" cellspacing="1" cellpadding="1">
								<tr height="25" valign="top">
                                    <td width="103"><label>Institución:</label>&nbsp;</td>
                                    <td width="193">
                                        <input type="hidden" name="banderaGuardar" id="banderaGuardar" value="nAdscripcion"/>
                                        <input type="hidden" name="banderaAccion" id="banderaAccion" <?php echo"value='".$accion."'"; ?>/>
                                        <input type="hidden" name="idUsuario" id="idUsuario" value='<?php echo $idUsuario;?>'/>
                                        <input type="text" name="Institucion" id="Institucion" value='<?php echo ($cInfo[0]);?>' style="width:180px"/>
                                    
                                    </td>
									<td>&nbsp;</td>
                                    <td width="135">
                                    <label>Dependencia:</label>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td width="200"><input type="text" name="Dependencia" id="Dependencia" value='<?php echo ($cInfo[1]);?>' size="32"/></td>
                                   
								
  								</tr>
                                <tr height="25" valign="top">
                                <td><label>Tipo:</label> &nbsp;</td>
								
								<td>
									<select name="cmbTipo" id="cmbTipo" style="width:130px" onchange="javascript:cargaPuesto()">
									<?php
										if($cInfo[4]==0)
										{
											$i="selected";
											$e="";
										}
										else
										{
											$e="selected";
											$i="";
										}
										//echo "<option value='-1'>Seleccione</option>";
										echo "<option value='0' ".$i.">Interno</option>";
										echo "<option value='1' ".$e.">Externo</option>";
									  ?>
									</select>
								</td>
                                </tr>
 
  								<tr height="25" valign="top">
    								<td><label>Área:</label><span id="spanArea"> <font color="#FF0000">*</font></span>&nbsp;</td>
								    <td>
										<label>
								      		<select name="cmbArea" id="cmbArea" style="width:180px" val="obl" campo="Área">
										  	<option value='-1'>Seleccione</option>
										  	<?php
											$con->llenarComboChecado("select idArea,Nombre from 4132_areas",$cInfo[2])
											?>
										  	</select>
										</label>	 
										<label id="AreaNecesaria">No obligatoria</label>
									</td>
		    						<td>&nbsp;</td>
									<td>
										<label>Puesto:</label><span id="spanPuesto"> <font color="#FF0000">*</font></span>
     								 &nbsp;
									</td>
    								<td>&nbsp;</td>
    								<td>
										<select name="cmbPuesto" id="cmbPuesto" style="width:205px" val="obl" campo="Puesto">
										<option value='-1'>Seleccione</option>
										<?php
												if($cInfo[3]=="NULL")
													$cInfo[3]=1;
											 ?>
										<?php
										$con->llenarComboChecado("select codPuesto,Descripcion from 4133_puestos",$cInfo[3])
										?>
										</select>
										<input type="text" name="txtPuesto" id="txtPuesto" value='<?php echo $cInfo[12];?>' size="35" />
									</td>
									<td>&nbsp;</td>
									<td><label></label></td>
									<td rowspan="1"></td>
									<td rowspan="1"></td>
  								</tr>
  								<tr height="75" valign="top">
									<td colspan="10">
										<table>
										<tr>
											<td width="83" valign="top"><label>Teléfonos:</label></td>
											<td valign="top">
												<table width="20" border="0" cellspacing="1" cellpadding="1">
      											<tr>
													<td width="19"><a href="javaScript:solicitarTel(<?php echo $idUsuario;?>,1)"><img src="../images/icon_big_tick.gif" alt="Agregar" height="15" title="Agregar Teléfono" border='0'/></a></td>
												 </tr>
      											<tr>
        											<td><a href="javaScript:eliminarTelefono(1)"><img src="../images/cancel_round.png" alt="Eliminar" title="Eliminar Teléfono" border='0'/></a></td>
      											</tr>
    											</table>	
											</td>
											<td width="200">
												<select name="cmbTelefonoAds" id="cmbTelefonoAds" size="4" style="width:190px" >
												<?php
													$con->generarOpcionesSelect("SELECT idTelefono,concat(Lada,'-',Numero,' (',Extension,')',' - ',(select case Tipo2 when 0 then 'Teléfono'  when 1 then 'Celular' when 2 then 'Fax' end)) as telefonos  FROM 804_telefonos WHERE Tipo=1 AND idUsuario=".$idUsuario);
												?>
												</select>	
											</td>
											<td width="120" valign="top">
												<label>Correo electrónico:</label>	
											</td>
											<td valign="top">
												<table width="20" border="0" cellspacing="1" cellpadding="1">
        										<tr>
													<td><a href="javaScript:solicitarMail(<?php echo $idUsuario;?>,1)"><img src="../images/icon_big_tick.gif" height="15" title="Agregar Correo Electrónico" border='0'/></a></td>
												</tr>
												<tr>
												  	<td><a href="javaScript:eliminarMail(1)"><img src="../images/cancel_round.png" title="Eliminar Correo Electrónico" border='0'/></a></td>
												</tr>
    											</table>	
											</td>
											<td>
												<select name="cmbMailAds" id="cmbMailAds" size="4" style="width:205px">
												  <?php
													$con->generarOpcionesSelect("SELECT idMail,Mail FROM 805_mails WHERE Tipo=1 AND idUsuario=".$idUsuario);
												  ?>
												  </select>	
											</td>
										</tr>
										</table>	
									</td>
   								</tr>
								</table>
								</fieldset>
								
								<br>
								<fieldset class="frameHijo"><legend><b>DIRECCIÓN LABORAL</b></legend>
									<br />
									<table width="630" border="0" cellspacing="1" cellpadding="1">
									<tr height="25" valign="top">
										<td width="105"><label>Calle:</label></td>
										<td width="240"><label>
										  <input type="text" name="Calle" id="Calle" value='<?php echo ($cInfo[5]);?>' size="36"/>
											</label>    
										</td>
										
										<td width="90">
											<label>Número:</label>
										</td>
										
										<td ><label>
											<input type="text" name="Numero" id="Numero" value='<?php echo ($cInfo[6]);?>'/>
											</label>    
										</td>
										
										
									</tr>
	
									<tr height="25" valign="top">
                                    	<td><label>Colonia:</label></td>
                                        
                                    	<td><label>
										  <input type="text" name="Colonia" id="Colonia" value='<?php echo ($cInfo[7]);?>'/>
											</label>    
										</td>
										<td><label>Ciudad:</label></td>
										<td><label>
											<input type="text" name="Ciudad" id="Ciudad" value='<?php echo ($cInfo[8]);?>'/>
											</label>    
										</td>
										
										
									</tr>
                                    <tr height="25" valign="top">
                                    <td><label>Estado:</label></td>
										
										<td><label>
											<input type="text" name="Estado" id="Estado" value='<?php echo ($cInfo[10]);?>'/>
											</label>    
										</td>
										
										<td><label>País:</label></td>
										
										<td><label>
											<input type="text" name="Pais" id="Pais" value='<?php echo ($cInfo[11]);?>'/>
											</label>    
										</td>
                                    </tr>
	  
									<tr height="25" valign="top">
										<td><label>Código Postal:</label></td>
										<td><label>
											<input type="text" name="CP" id="CP" value='<?php echo ($cInfo[9]);?>'/>
											</label>    
										</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									</table>
								</fieldset>
								<table width="630" border="0" cellspacing="1" cellpadding="1">
								<tr>
  									<td align="left"><br /></td>
    								<td align="right"><br />
										<input type="button" class="tituloTabla" name="btnGuardar" id="btnGuardar" <?php 
										if($accion=="Nuevo")
											echo "value='Guardar'"; 
										else
											echo "value='Actualizar'"; 
										?> onclick="guardarAdscripcion('nAdscripcion')"/>
									</td>
  								</tr>
								</table>
							</td>
  						</tr>
						</table>
						</form>		
								
							
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
