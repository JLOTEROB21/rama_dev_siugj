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
	$tituloModulo="Perfil de importaci&oacute;n";
?>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../Sistema/Scripts/configuracionPerfilImportacion.js.php"></script>
<script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
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
                        <td align="center">
                        <?php
                        	
							
							
							$idPerfilConfiguracion=-1;
							if(isset($objParametros->idPerfilConfiguracion))
							{
								$idPerfilConfiguracion=$objParametros->idPerfilConfiguracion;
							}
							
							echo formatearTituloPagina($tituloModulo,true,$idPerfilConfiguracion);
							
							$arrTipoSeparacion=array();
							$arrTipoSeparacion[0][0]="1";
							$arrTipoSeparacion[0][1]="Delimitado por caracteres";
							$arrTipoSeparacion[1][0]="2";
							$arrTipoSeparacion[1][1]="Delimitado por longitud fija";
							
							
							$consulta="SELECT * FROM 720_perfilesImportacion WHERE idPerfilConfiguracion=".$idPerfilConfiguracion;
							$fRegistro=$con->obtenerPrimeraFila($consulta);
							
							$oConfiguracion=NULL;
							if($fRegistro[4]!="")
							{
								$oConfiguracion=json_decode(bD($fRegistro[4]));
								
							}
							
                        ?>
                        	<form method="post" action="../paginasFunciones/guardarDatos.php" id="frmEnvio">
                        	<table width="800" class="frameHijoV3">
                            	<tr height="21">
                                	<td width="220"><span class="letraAzulSimple">Nombre del perfil:</span><span class="letraRoja">*</span></td>
                                    <td width="580"><input type="text" size="60" id="_nombrePerfilvch" name="_nombrePerfilvch"  val="obl" campo="Nombre del perfil" value="<?php echo $fRegistro[1]?>"/></td>
                                </tr>
                                <tr height="21">
                                	<td width="220" valign="top"><span class="letraAzulSimple" >Descripci&oacute;n:</span></td>
                                    <td width="580"><textarea  cols="80" rows="6" id="_descripcionvch" name="_descripcionvch" /><?php echo $fRegistro[2]?></textarea></td>
                                </tr>
                                <tr height="21">
                                	<td width="220"><span class="letraAzulSimple">Formato del archivo de importación:</span><span class="letraRoja">*</span></td>
                                    <td width="580">
                                    	<select id="_formatoImportacionvch" name="_formatoImportacionvch" val="obl" campo="Formato del archivo de importación" onchange="formatoImportacionSel(this)">
                                        <option value="-1">Seleccione</option>
                                    	<?php
											$consulta="SELECT idFormato,formatoImportacion FROM 721_formatosImportacion ORDER BY formatoImportacion";
                                        	$con->generarOpcionesSelect($consulta,$fRegistro[3]);
                                        ?>
                                        </select>
                                        
                                        <input type="hidden" name="_objConfiguracionvch" id="_objConfiguracionvch" value="<?php echo $fRegistro[4]?>"/>
                                        
                                    </td>
                                </tr>
                                <tr id="fila_1" style="display:<?php echo ((($idPerfilConfiguracion==-1)||(($fRegistro[3]!=3)&&($fRegistro[3]!=4)))?'none':'')?>">
                                	<td  colspan="2"><br />
                                    <fieldset class="frameHijo"><legend>Par&aacute;metros de configuraci&oacute;n</legend>
                                    <table>
                                    	<tr height="21">
                                        	<td width="115">
                                            	<span class="letraAzulSimple">Columna inicial:</span><span class="letraRoja">*</span>
                                            </td>
                                            <td width="250">
                                            	<select id="_columnaInicialvch"  value="obl" campo="Columna inicial">
                                                <option value="-1">Seleccione</option>
                                                <?php
													$consulta="SELECT idCelda,celda FROM 1019_catalogoCeldasExcel ORDER BY idCelda";
													$cI=-1;
													if(($oConfiguracion)&&(isset($oConfiguracion->columnaInicial)))
														$cI=$oConfiguracion->columnaInicial;
                                                    $con->generarOpcionesSelect($consulta,$cI);
                                                ?>
                                                </select>
                                            </td>
                                            <td width="90">
                                            	<span class="letraAzulSimple">Fila inicial:</span><span class="letraRoja">*</span>
                                            </td>
                                            <td width="400">
                                           		<input type="text" size="8" value="<?php echo (($oConfiguracion&&(isset($oConfiguracion->filaInicial)))?$oConfiguracion->filaInicial:'')?>" id="_filaInicialint"  onkeypress="return soloNumero(event,false,false,this)" />
                                            </td>
                                        </tr>
                                        <tr  height="21">
                                        	<td>
                                            	<span class="letraAzulSimple">Columna final:</span><span class="letraRoja">*</span>
                                            </td>
                                            <td>
                                            	<select id="_columnaFinalvch"  value="obl" campo="Columna final">
                                                <option value="0">Determinada por primera columna vac&iacute;a</option>
                                                <?php
													$cF=-1;
													if(($oConfiguracion)&&(isset($oConfiguracion->columnaFinal)))
														$cF=$oConfiguracion->columnaFinal;
                                                    $con->generarOpcionesSelect($consulta,$cF);
													$consulta="SELECT idCelda,celda FROM 1019_catalogoCeldasExcel ORDER BY idCelda";
                                                    $con->generarOpcionesSelect($consulta,$cF);
                                                ?>
                                                </select>
                                            </td>
                                            <td>
                                            	<span class="letraAzulSimple">Fila final:</span><span class="letraRoja">*</span>
                                            </td>
                                            <td>
                                            	<input type="text" size="8" value="<?php echo (($oConfiguracion&&(isset($oConfiguracion->filaFinal)))?$oConfiguracion->filaFinal:'')?>" id="_filaFinalint"  onkeypress="return soloNumero(event,false,false,this)" /> <label style="font-size:10px;color:#000">(0 final determinado por primera columna-fila vacía)</label>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    </fieldset>
                                    </td>
                                </tr>
                                 <tr id="fila_2" style="display:<?php echo ((($idPerfilConfiguracion==-1)||($fRegistro[3]!=2))?'none':'')?>">
                                	<td  colspan="2"><br />
                                    <fieldset class="frameHijo"><legend>Par&aacute;metros de configuraci&oacute;n</legend>
                                    <table>
                                    	<tr height="21">
                                        	<td width="190" valign="top">
                                            	<span class="letraAzulSimple">Separador de linea:</span><span class="letraRoja">*</span>
                                            </td>
                                            <td width="550">
                                            	<span class="letraAzulSimple">
                                                <table>
                                                	<tr>
                                                    	<td width="170">
                                                        	<input type="checkbox" name="chkD_2" id="chkD_1" value="[n]" onclick="checkDelimitadorClick(this)" <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==2)&&(strpos($oConfiguracion->separadorLinea,"[n]")!==false))?'checked="checked"':''?>/> Retorno de carro
                                                        </td>
                                                        <td width="170">
                                                        	<input type="checkbox" name="chkD_2" id="chkD_2" value="[t]" onclick="checkDelimitadorClick(this)" <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==2)&&(strpos($oConfiguracion->separadorLinea,"[t]")!==false))?'checked="checked"':''?>/> Tabulaci&oacute;n
                                                        </td>
                                                        <td width="170">
                                                        	<input type="checkbox" name="chkD_2" id="chkD_3" value="[;]" onclick="checkDelimitadorClick(this)" <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==2)&&(strpos($oConfiguracion->separadorLinea,"[;]")!==false))?'checked="checked"':''?>/> Punto y coma
                                                        </td>
                                                        <td width="170">
                                                        	<input type="checkbox" name="chkD_2" id="chkD_4" value="[,]" onclick="checkDelimitadorClick(this)" <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==2)&&(strpos($oConfiguracion->separadorLinea,"[,]")!==false))?'checked="checked"':''?>/> Coma
                                                        </td>
                                                       
                                                    </tr>
                                                    <tr>
                                                    	<td >
                                                        	<input type="checkbox" name="chkD_2" id="chkD_5" value="[ ]" onclick="checkDelimitadorClick(this)" <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==2)&&(strpos($oConfiguracion->separadorLinea,"[ ]")!==false))?'checked="checked"':''?>/> Espacio en blanco
                                                        </td>
                                                        <td colspan="3">
                                                        	<input type="checkbox" name="chkD_2" id="chkD_6" value="[@]" onclick="checkDelimitadorClick(this)" <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==2)&&(strpos($oConfiguracion->separadorLinea,"[@]")!==false))?'checked="checked"':''?>/> 
                                                            Otro &nbsp;&nbsp;&nbsp;<input type="text" size="20" id="otro_D2" <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==2)&&(strpos($oConfiguracion->separadorLinea,"[@]")===false))?'disabled="disabled"':''?>
                                                            
                                                             <?php
																if(($oConfiguracion)&&($fRegistro[3]==2)&&(strpos($oConfiguracion->separadorLinea,"[@]")!==false))
																{
																	$arrSeparador=explode("[@]@,@",$oConfiguracion->separadorLinea);
																	echo 'value="'.htmlentities(str_replace("@,@",",",$arrSeparador[1])).'"';
																}
															?>
                                                            
                                                            />&nbsp;&nbsp;<label style="font-size:10px;color:#000">(Separado por coma)</label>
                                                        </td>
                                                    </tr>
                                                    
                                                </table>
                                                </span>
                                            </td>
                                        </tr>
                                    	<tr height="21">
                                        	<td >
                                            	<span class="letraAzulSimple">Tipo de separaci&oacute;n de valores:</span><span class="letraRoja">*</span>
                                            </td>
                                            <td >
                                            	<select id="_separacionValoresvch" onchange="tipoSeparacionSel(this)" >
                                                <?php
													$idTipoSeparacion=-1;
													if(($oConfiguracion)&&(isset($oConfiguracion->tipoSeparacionValores)))
														$idTipoSeparacion=$oConfiguracion->tipoSeparacionValores;
													$con->generarOpcionesSelectArreglo($arrTipoSeparacion,$idTipoSeparacion);
												?>
                                                </select>
                                            </td>
                                            
                                        </tr>
                                        <tr height="21" id="filaSeparadorValores" style="display: <?php echo ($oConfiguracion!=NULL &&(isset($oConfiguracion->tipoSeparacionValores)&&($oConfiguracion->tipoSeparacionValores==2))?'none':"")?>">
                                        	<td width="190" valign="top">
                                            	<span class="letraAzulSimple">Separador de valores:</span><span class="letraRoja">*</span>
                                            </td>
                                            <td width="550">
                                            	<span class="letraAzulSimple">
                                                <table>
                                                	<tr>
                                                    	<td width="170">
                                                        	<input type="checkbox" name="chkS_2" id="chkS_1" value="[n]" onclick="checkSeparadorClick(this)" <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==2)&&(strpos($oConfiguracion->separadorValores,"[n]")!==false))?'checked="checked"':''?>/> Retorno de carro
                                                        </td>
                                                        <td width="170">
                                                        	<input type="checkbox" name="chkS_2" id="chkS_2" value="[t]" onclick="checkSeparadorClick(this)" <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==2)&&(strpos($oConfiguracion->separadorValores,"[t]")!==false))?'checked="checked"':''?>/> Tabulaci&oacute;n
                                                        </td>
                                                        <td width="170">
                                                        	<input type="checkbox" name="chkS_2" id="chkS_3" value="[;]" onclick="checkSeparadorClick(this)" <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==2)&&(strpos($oConfiguracion->separadorValores,"[;]")!==false))?'checked="checked"':''?>/> Punto y coma
                                                        </td>
                                                        <td width="170">
                                                        	<input type="checkbox" name="chkS_2" id="chkS_4" value="[,]" onclick="checkSeparadorClick(this)" <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==2)&&(strpos($oConfiguracion->separadorValores,"[,]")!==false))?'checked="checked"':''?>/> Coma
                                                        </td>
                                                       
                                                    </tr>
                                                    <tr>
                                                    	<td >
                                                        	<input type="checkbox" name="chkS_2" id="chkS_5" value="[ ]" onclick="checkSeparadorClick(this)" <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==2)&&(strpos($oConfiguracion->separadorValores,"[ ]")!==false))?'checked="checked"':''?>/> Espacio en blanco
                                                        </td>
                                                        <td colspan="3">
                                                        	<input type="checkbox" name="chkS_2" id="chkS_6" value="[@]" onclick="checkSeparadorClick(this)" <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==2)&&(strpos($oConfiguracion->separadorValores,"[@]")!==false))?'checked="checked"':''?>/> 
                                                            Otro &nbsp;&nbsp;&nbsp;<input type="text" size="20" id="otro_S2" <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==2)&&(strpos($oConfiguracion->separadorValores,"[@]")===false))?'disabled="disabled"':''?>
                                                            <?php
																if(($oConfiguracion)&&($fRegistro[3]==2)&&(strpos($oConfiguracion->separadorValores,"[@]")!==false))
																{
																	$arrSeparador=explode("[@]@,@",$oConfiguracion->separadorValores);
																	echo 'value="'.htmlentities(str_replace("@,@",",",$arrSeparador[1])).'"';
																}
															?>
                                                            />&nbsp;&nbsp;<label style="font-size:10px;color:#000">(Separado por coma)</label>
                                                        </td>
                                                    </tr>
                                                    <tr height="21">
                                                        <td colspan="3" valign="top">
                                                            <span class="letraAzulSimple">Valores encerrados entre caracter:</span><span class="letraRoja">*</span>&nbsp;&nbsp;
                                                        
                                                            <input type="text" maxlength="1" size="4" id="cvsCaracterEncerrado3" value="<?php echo htmlentities((($oConfiguracion!=NULL)&&isset($oConfiguracion->caracterEncierro))?$oConfiguracion->caracterEncierro:'') ?>" />
                                                        </td>
                                                    </tr>
                                                </table>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr height="21" id="filaDefinicionEstructura" style="display: <?php echo ($oConfiguracion==NULL ||(isset($oConfiguracion->tipoSeparacionValores)&&($oConfiguracion->tipoSeparacionValores==1))?'none':"")?>">
                                        	<td width="190" valign="top">
                                            	<span class="letraAzulSimple">Definici&oacute;n de estructura:</span><span class="letraRoja">*</span>
                                            </td>
                                            <td width="550">
                                            	<span id="tblDefincionEstructura"></span><br /><br />
                                                
                                                <?php
													$arrEstructura="[]";
													if(($oConfiguracion)&&(isset($oConfiguracion->arrLongitudes)))
													{
														$arrEstructura="";
														foreach($oConfiguracion->arrLongitudes as $a)
														{
															$oT="['".$a->idColumna."','".$a->longitud."']";
															if($arrEstructura=="")
																$arrEstructura=$oT;
															else
																$arrEstructura.=",".$oT;
														}
														
														$arrEstructura="[".$arrEstructura."]";
													}
												?>
                                                
                                            	<input type="hidden" id="arrEstructura" value="<?php echo bE($arrEstructura) ?>" />
                                            
                                            </td>
                                        </tr>
                                        
                                   </table>
                                   </fieldset>
                                  </td>
                             </tr>
                            
                            
                            	<tr id="fila_3" style="display:<?php echo ((($idPerfilConfiguracion==-1)||($fRegistro[3]!=1))?'none':'')?>">
                                	<td  colspan="2"><br />
                                    <fieldset class="frameHijo"><legend>Par&aacute;metros de configuraci&oacute;n</legend>
                                    <table>
                                    	<tr height="21">
                                        	<td width="190" valign="top">
                                            	<span class="letraAzulSimple">Separador de linea:</span><span class="letraRoja">*</span>
                                            </td>
                                            <td width="550">
                                            	<span class="letraAzulSimple">
                                                <table>
                                                	<tr>
                                                    	<td width="170">
                                                        	<input type="radio" name="chkD_3" id="chkD_1" value="[n]" onclick='radioDelimitadorClick(this)' <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==1)&&($oConfiguracion->separadorLinea=="[n]"))?'checked="checked"':''?> /> Retorno de carro
                                                        </td>
                                                        <td width="170">
                                                        	<input type="radio" name="chkD_3" id="chkD_2" value="[t]" onclick='radioDelimitadorClick(this)' <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==1)&&($oConfiguracion->separadorLinea=="[t]"))?'checked="checked"':''?>/> Tabulaci&oacute;n
                                                        </td>
                                                        <td width="170">
                                                        	<input type="radio" name="chkD_3" id="chkD_3" value="[;]" onclick='radioDelimitadorClick(this)' <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==1)&&($oConfiguracion->separadorLinea=="[;]"))?'checked="checked"':''?>/> Punto y coma
                                                        </td>
                                                        <td width="170">
                                                        	<input type="radio" name="chkD_3" id="chkD_4" value="[,]" onclick='radioDelimitadorClick(this)' <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==1)&&($oConfiguracion->separadorLinea=="[,]"))?'checked="checked"':''?>/> Coma
                                                        </td>
                                                       
                                                    </tr>
                                                    <tr>
                                                    	<td >
                                                        	<input type="radio" name="chkD_3" id="chkD_5" value="[ ]" onclick='radioDelimitadorClick(this)' <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==1)&&($oConfiguracion->separadorLinea=="[ ]"))?'checked="checked"':''?>/> Espacio en blanco
                                                        </td>
                                                        <td colspan="3">
                                                        
                                                        
                                                        
                                                        	<input type="radio" name="chkD_3" id="chkD_6" value="[@]" onclick='radioDelimitadorClick(this)' <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==1)&&(strpos($oConfiguracion->separadorLinea,"[@]")!==false))?'checked="checked"':''?>/> 
                                                            Otro &nbsp;&nbsp;&nbsp;
                                                            <input type="text" size="20" id="otro_D3" <?php echo ((($oConfiguracion==NULL)||($fRegistro[3]!=1)||(strpos($oConfiguracion->separadorLinea,"[@]")===false))?'disabled="true"':"")?>
                                                            <?php
																if(($oConfiguracion)&&($fRegistro[3]==1)&&(strpos($oConfiguracion->separadorLinea,"[@]")!==false))
																{
																	$arrSeparador=explode("[@]",$oConfiguracion->separadorLinea);
																	echo 'value="'.htmlentities($arrSeparador[1]).'"';
																}
															?>
                                                            
                                                            
                                                            />
                                                        </td>
                                                    </tr>
                                                    
                                                </table>
                                                </span>
                                            </td>
                                        </tr>
                                    	<tr height="21">
                                        	<td width="190" valign="top">
                                            	<span class="letraAzulSimple">Separador de valores:</span><span class="letraRoja">*</span>
                                            </td>
                                            <td width="550">
                                            	<span class="letraAzulSimple">
                                                <table>
                                                	<tr>
                                                    	<td width="170">
                                                        	<input type="radio" name="chkS_3" id="chkS_1" value="[n]" onclick='radioSeparadorClick(this)' <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==1)&&($oConfiguracion->separadorValores=="[n]"))?'checked="checked"':''?>/> Retorno de carro
                                                        </td>
                                                        <td width="170">
                                                        	<input type="radio" name="chkS_3" id="chkS_2" value="[t]" onclick='radioSeparadorClick(this)' <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==1)&&($oConfiguracion->separadorValores=="[t]"))?'checked="checked"':''?>/> Tabulaci&oacute;n
                                                        </td>
                                                        <td width="170">
                                                        	<input type="radio" name="chkS_3" id="chkS_3" value="[;]" onclick='radioSeparadorClick(this)' <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==1)&&($oConfiguracion->separadorValores=="[;]"))?'checked="checked"':''?>/> Punto y coma
                                                        </td>
                                                        <td width="170">
                                                        	<input type="radio" name="chkS_3" id="chkS_4" value="[,]" onclick='radioSeparadorClick(this)' <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==1)&&($oConfiguracion->separadorValores=="[,]"))?'checked="checked"':''?>/> Coma
                                                        </td>
                                                       
                                                    </tr>
                                                    <tr>
                                                    	<td >
                                                        	<input type="radio" name="chkS_3" id="chkS_5" value="[ ]" onclick='radioSeparadorClick(this)' <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==1)&&($oConfiguracion->separadorValores=="[ ]"))?'checked="checked"':''?>/> Espacio en blanco
                                                        </td>
                                                        <td colspan="3">
                                                        	<input type="radio" name="chkS_3" id="chkS_6" value="[@]" onclick='radioSeparadorClick(this)' <?php echo (($oConfiguracion!=NULL)&&($fRegistro[3]==1)&&(strpos($oConfiguracion->separadorValores,"[@]")!==false))?'checked="checked"':''?>/> 
                                                            Otro &nbsp;&nbsp;&nbsp;<input type="text" size="20" id="otro_S3" <?php echo ((($oConfiguracion==NULL)||($fRegistro[3]!=1)||(strpos($oConfiguracion->separadorValores,"[@]")===false))?'disabled="true"':"")?>
                                                            <?php
																if(($oConfiguracion)&&($fRegistro[3]==1)&&(strpos($oConfiguracion->separadorValores,"[@]")!==false))
																{
																	$arrSeparador=explode("[@]",$oConfiguracion->separadorValores);
																	echo 'value="'.htmlentities($arrSeparador[1]).'"';
																}
															?>
                                                            
                                                            
                                                            />
                                                        </td>
                                                    </tr>
                                                </table>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr height="21">
                                        	<td width="190" valign="top">
                                            	<span class="letraAzulSimple">Valores encerrados entre caracter:</span><span class="letraRoja">*</span>
                                            </td>
                                            <td width="550">
                                            	<input type="text" maxlength="1" size="4" id="cvsCaracterEncerrado" value="<?php echo htmlentities((($oConfiguracion&&(isset($oConfiguracion->caracterEncierro)))!=NULL?$oConfiguracion->caracterEncierro:'')) ?>" />
                                            </td>
                                        </tr>
                                   </table>
                                   </fieldset>
                                  </td>
                             </tr>
                             
                             <tr>
                             	<td align="center" colspan="2"><br /><br />
                                	<input type="button" value="Aceptar" class="btnAceptar" onclick="validarConfiguracion()" />
                                </td>
                             </tr>
                             
                             
                            
                            </table>
                            
                           
                            <input type="hidden" name="tabla" value="720_perfilesImportacion" />
                            <input type="hidden" name="post"  value="" />
                            <input type="hidden" name="id" id="id" value="<?php echo $idPerfilConfiguracion?>" />
                            <input type="hidden" name="campoId" value="idPerfilConfiguracion" />
                            <input type="hidden" name="pagRedireccion" value="../Sistema/tblPerfilesImportacion.php"/>	
                           
                            
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
