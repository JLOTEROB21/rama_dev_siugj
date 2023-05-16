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
	$guardarConfSession=true;
	$mostrarMenuIzq=false;
	$mostrarTitulo=false;
	$mostrarPiePag=false;
?>
<script type="text/javascript" src="Scripts/sesionesTrabajo.js.php"></script>
<style type="text/css">
<!--
@import url("../css/estiloFicha.css");
-->
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
                        <td>
                        	<?php
								$idActividad=base64_decode($objParametros->a);
								$fechaInicio=$objParametros->fI;
								$fechaFin=$objParametros->fF;
								$nSemana=$objParametros->s;
								$modificar=true;
								if(isset($objParametros->sl))
									$modificar=false;
								$totalHoras=0;
							
								$consulta="select inicio,final,fecha from 4089_calendario where tipo=2 and lugar=".$idActividad;
								
								$resActP=$con->obtenerFilas($consulta);
								$totalHorasSemana=0;
								$totalGlobalHoras=0;
								$ctSesiones=0;
								while($filaS=mysql_fetch_row($resActP))
								{
									$horas=date("g",restaHoras($filaS[0],$filaS[1]));
									if((strtotime($filaS[2])>=$fechaInicio)&&(strtotime($filaS[2])<=$fechaFin))
									{
										$totalHorasSemana+=$horas;
										$ctSesiones++;
									}
									$totalGlobalHoras+=$horas;
								}
								$consulta="select a.actividad,horasTotal,idUsuario from 965_actividadesUsuario a where  a.idActividadPrograma=".$idActividad;
                                $filaAct=$con->obtenerPrimeraFila($consulta);
								$actividad=$filaAct[0];
								$totalHoras=$filaAct[1];
								$idUsuario=$filaAct[2];
								$sesiones=$ctSesiones;
								$consulta="select concat(if(Prefijo is null,'',Prefijo),' ',Nombre) from 802_identifica where idUsuario=".$idUsuario;
								$usuario=$con->obtenerValor($consulta);
								
                            ?>
                        	<table width="100%">
                            <tr>
                            	<td align="center">
                                	<span class="tituloPaginas">Sesiones de trabajo planeadas</span>
                                </td>
                            </tr>
                            <tr>
                                <td align="left"><br /><br /><br />
                                	<table>
                                    	<tr>
                                    		<td width="80">&nbsp;</td>
                                    		<td>
                                            	
                                                <table>
                                                <tr height="23">
                                                    <td class="letraFicha" width="150"><span class="letraRoja">
                                                    Actividad:</span>
                                                    </td>
                                                    <td colspan="6">
                                                    <span class="letraRojaSubrayada8">
                                                    <?php
                                                        
                                                        echo $actividad;
                                                    ?>
                                                    </span>
                                                    </td>
                                                </tr>
                                                <tr height="23">
                                                    <td class="letraFicha" width="150"><span class="letraRoja">
                                                    Responsable:</span>
                                                    </td>
                                                    <td colspan="6">
                                                    <span class="letraRojaSubrayada8">
                                                    <?php
                                                        
                                                        echo $usuario;
                                                    ?>
                                                    </span>
                                                    </td>
                                                </tr>
                                                
                                                 
                                                 <tr height="23">
                                                 	<td width="20">
                                                    </td>
                                                    <td class="letraFicha">
                                                    # Total horas actividad:
                                                    </td>
                                                    <td width="80">&nbsp;&nbsp;
                                                    <span class="letraAzul">
                                                   <?php
												   		echo $totalHoras;
												   ?>
                                                    </span>
                                                    </td>
                                                    <td class="letraFicha">
                                                    # Total horas planeadas:
                                                    </td>
                                                    <td width="80">&nbsp;&nbsp;
                                                    <span class="letraAzul">
                                                   <?php
												   		echo $totalGlobalHoras;
												   ?>
                                                    </span>
                                                    </td>
                                                    <td class="letraFicha">
                                                    # Total horas sin planeación:
                                                    </td>
                                                    <td width="80">&nbsp;&nbsp;
                                                    <span class="letraAzul">
                                                   <?php
													   $horasLibres=$totalHoras- $totalGlobalHoras;
												   		echo $horasLibres;
													if($horasLibres==0)
														$modificar=false;
												   ?>
                                                    </span>
                                                    </td>
                                                </tr>
                                                	<tr>
                                                    	<td colspan="7"><br />
                                                        </td>
                                                    </tr>
                                                 <tr height="23">
                                                    <td class="letraFicha"><span class="letraRoja">
                                                    Semana: </span>
                                                    </td>
                                                    <td colspan="6">
                                                    <span class="corpo8"><span class="letraAzul">
                                                    <?php echo $nSemana?></span> <span class="corpo7">(Del Lunes <?php echo date('d/m/Y',$fechaInicio) ?> al Domingo <?php echo date('d/m/Y',$fechaFin) ?> )</span>
                                                    </span>
                                                    </td>
                                                </tr>
                                                <tr height="23">
                                                	<td width="20">
                                                    </td>
                                                    <td class="letraFicha">
                                                    # Sesiones planeadas:
                                                    </td>
                                                    <td width="80">&nbsp;&nbsp;
                                                    <span class="letraAzul">
                                                   <?php
												   	echo $sesiones;
												   ?>
                                                    </span>
                                                    </td>
                                                    <td class="letraFicha">
                                                    Total horas planeadas:
                                                    </td>
                                                    <td width="80">&nbsp;&nbsp;
                                                    <span class="letraAzul" id='lblHorasTotal'>
                                                    <?php
														echo $totalHorasSemana;
													?>
                                                    </span>
                                                    </td>
                                                </tr>
                                                
                                                
                                                </table>
                                      		</td>
                                      	</tr>
                                	</table>
                                </td>
                            </tr>
                            <tr>
                            	<td align="center">
                                	<br /><br />
                                     
                                	<table id="hor-minimalist-b" style="width:500px !important" >
                                    <thead>
                                    	<tr>
                                        	<th align="center" class="rounded-company " style="text-align:center"><b><span class="">Fecha</span></b></th>
                                            <th align="center" class="rounded-q4 "  style="text-align:center"><b><span class="">Sesión planeada</span></b></th>
                                            <th></th>
                                        </tr>
                                    </thead>    
                                     <tbody>   
                                        <?php
											$clase="filaBlanca10";
											for($x=0;$x<7;$x++)
											{
												$nFecha=strtotime("+".$x." days",$fechaInicio);
										?>
                                        	 <tr>
                                                <td align="center" style="vertical-align:top" class="<?php echo $clase?>"><span class="corpo8" > <?php echo date('d/m/Y',$nFecha) ?></span></td>
                                                <td  class="<?php echo $clase?>" align="left" width="500">
                                                	<table>
                                                    <tr>
                                                    	<td align="left">
															<?php
                                                                $consulta="select * from 4089_calendario where tipo=2 and lugar='".$idActividad."' and fecha='".date('Y-m-d',$nFecha)."' order by inicio";
                                                                $resF=$con->obtenerFilas($consulta);
                                                                if($con->filasAfectadas>0)
                                                                {
                                                            ?>
                                                                    <table>
                                                                        <tr>
                                                                            <td width="50"></td>
                                                                            <td width="130" class="letraFicha" align="center">Hora inicio</td>
                                                                            <td width="130" class="letraFicha" align="center">Hora fin</td>
                                                                            <td width="130" class="letraFicha" align="center">Total horas</td>
                                                                            <td></td>
                                                                        </tr>
                                                                        <?php
                                                                            $ct=1;
                                                                            while($fH=mysql_fetch_row($resF))
                                                                            {
                                                                        ?>
                                                                                <tr id="fila_<?php echo ($fH[0])?>">
                                                                                    <td class="valorFicha"><span class="corpo7Simple"><?php echo $ct?>.- </td>
                                                                                    <td class="valorFicha"><span class="corpo7Simple"><?php echo date("h:i A",strtotime($fH[1]));?></span></td>
                                                                                    <td class="valorFicha"><span class="corpo7Simple"><?php echo date("h:i A",strtotime($fH[2]));?></span></td>
                                                                                    <td class="valorFicha" align="center"><span class="corpo7Simple" id='horas_<?php  echo ($fH[0])?>'><?php $horas=date("g",restaHoras($fH[1],$fH[2])); echo $horas?></span></td>
                                                                         
                                                                         <?php
                                                                         		if($nFecha>=strtotime(date("Y-m-d",strtotime("now")))&&($modificar))
																				{
                                                                         ?>           
                                                                                    
                                                                                    
                                                                                    <td class="valorFicha" align="center"><a href="javascript:removerSesion('<?php  echo base64_encode($fH[0])?>','<?php  echo ($fH[0])?>')"><img src="../images/delete.png" title="Remover sesión de trabajo" alt="Remover sesión de trabajo"/></td>
                                                                                </tr>
                                                                        <?php
																				}
																				else
																				{
																		?>
                                                                        			<td class="valorFicha" align="center"></td>
                                                                        <?php
																				}
                                                                                $totalHoras+=$horas;
                                                                                $ct++;
                                                                            }
                                                                        ?>
                                                                        
                                                                    </table>
                                                            <?php
                                                                    
                                                                }
                                                                else
                                                                {
                                                            ?>
                                                                    Sin Sesión planeada
                                                            <?php
                                                                }
                                                                
                                                            ?>
                                                	</td>
                                                    </tr>
                                                    </table>
                                                </td>
                                                <td valign="top" class="<?php echo $clase?>">
                                                    <?php
													if($nFecha>=strtotime(date("Y-m-d",strtotime("now")))&&($modificar))
													{
                                                ?>
                                                		<a href="javascript:agregarSesion('<?php echo date('d/m/Y',$nFecha) ?>')"><img src="../images/add.png" alt="Agregar sesión de trabajo" title="Agregar sesión de trabajo" /></a>
                                               	<?php
													}
													?>
                                                    
                                                    </td>
                                            </tr>
                                        <?php
												if($clase=="filaRosa10")
													$clase="filaBlanca10";
												else
													$clase="filaRosa10";
												
											}
										?>
                                    </tbody>   
                                    </table>
                                    
                                </td>
                            </tr>
                            </table>
                            
                            
                            <input type="hidden" value="<?php echo $idActividad?>" id="idActividad" />
                            <input type="hidden" value="<?php echo $_SESSION["idUsr"]?>" id="idUsuario" />
                        	<input type="hidden" value="<?php echo $totalHoras ?>" id="totalHoras" />
                            <input type="hidden" value="<?php echo $horasLibres ?>" id="horasLibres" />
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
