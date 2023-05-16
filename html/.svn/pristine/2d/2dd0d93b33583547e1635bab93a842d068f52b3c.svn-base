<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"><html xmlns="http://www.w3.org/1999/xhtml" dir="ltr"><!-- InstanceBegin template="/Templates/Lhayas_B.dwt.php" codeOutsideHTMLIsLocked="false" -->
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
$mostrarMenuNivel1=false;
$mostrarMenuNivel2=false;
$mostrarMenuIzq=false;
$mostrarUsuario=false;
$guardarConfSession=true;
$paramGET=true;
?>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../Scripts/thickbox/jquery.js"></script>
<script type="text/javascript" src="../Scripts/thickbox/thickbox.js"></script>
<link rel="stylesheet" href="../Scripts/thickbox/thickbox.css" type="text/css" />
<script type="text/javascript" src="Scripts/vista.js"></script>
<style type="text/css">
<!--
@import url("../css/estiloFinal.css");
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
                   		<td align="center"><br /><Br />
                    <?php
                        $idUsuario=base64_decode($objParametros->idUsuario);

						$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$idUsuario;
						$arrRolesUsr=$con->obtenerFilasArreglo1D($consulta);
						$sixe='width:170px';
						$ct=0;
						
						$elemento[$ct]="<button style='".$sixe."' class='btnButton' onClick='javascript:adscripcion(\"".base64_encode($idUsuario)."\")'><img src='../images/book_add.jpg' width='15' height='15'> Adscripcion</button>";
						$actions[$ct]="CADS";
						$ct++;
						
						if(($considerarAlumnosAsociados)&&(existeValor($arrRolesUsr,'6_0'))) //rol papa
						{
							$elemento[$ct]="<button style='".$sixe."' class='btnButton' onClick='javascript:verAlumnosAsociados(\"".base64_encode($idUsuario)."\")'><img src='../images/users.png' width='15' height='15'> Alumnos asociados</button>";
							$actions[$ct]="AA";
							$ct++;
						}
						$elemento[$ct]="<button style='".$sixe."' class='btnButton' onClick='javascript:doc(\"".base64_encode($idUsuario)."\")'><img src='../images/Icono_txt.gif' width='15' height='15'> Documentos</button>";
						$actions[$ct]="D";
						$ct++;
						if(($considerarFichaMedica)&&(existeValor($arrRolesUsr,'7_0'))) //rol alumno
						{
							$elemento[$ct]="<button style='".$sixe."' class='btnButton' onClick='javascript:fich(\"".base64_encode($idUsuario)."\")' align='left'><img src='../images/medic.gif' width='15' height='15'> Ficha Médica</button>";
							$actions[$ct]="F";
							$ct++;
						}
						if(existeValor($arrRolesUsr,'7_0'))
						{
							$elemento[$ct]="<button style='".$sixe."' class='btnButton' onClick='javascript:hist(\"".base64_encode($idUsuario)."\")'><img src='../images/edit_f2.png' width='15' height='15'> Historial académico</button>";	
							$actions[$ct]="H";
							$ct++;
						}
						
						
						$elemento[$ct]="<button style='".$sixe."' class='btnButton' onClick='javascript:verPerfil(\"".base64_encode($idUsuario)."\")'><img src='../images/vcard_edit.png' width='15' height='15'> Estadísticas del Usuario</button>";						
						$actions[$ct]="I";
						$ct++;
						if(($considerarJustificacionFaltas)&&(existeValor($arrRolesUsr,'7_0'))) //rol alumno
						{
							$elemento[$ct]="<button style='".$sixe."' class='btnButton' onClick='javascript:just(\"".base64_encode($idUsuario)."\")'><img src='../images/app_48.png' width='15' height='15'> Justificación de faltas</button>";
							$actions[$ct]="J";
							$ct++;
						}
						if(existeValor($arrRolesUsr,'5_0')) //Profesor
						{
							$elemento[$ct]="<button style='".$sixe."' class='btnButton' onClick='javascript:verHistorialProf(\"".base64_encode($idUsuario)."\")'><img src='../images/vcard_edit.png' width='15' height='15'> Historial profesor</button>";						
							$actions[$ct]="HC";
							$ct++;
						}
						
						$elemento[$ct]="<button style='".$sixe."' class='btnButton' onClick='javascript:verCronograma(\"".base64_encode($idUsuario)."\" )' ><img width='16' height='16' src='../images/gantt.png' > Programa de trabajo</button>";
						$actions[$ct]="CR";
						$ct++;
						if(($considerarReporteConducta)&&(existeValor($arrRolesUsr,'7_0'))) //rol alumno
						{
							$elemento[$ct]="<button style='".$sixe."' class='btnButton' onClick='javascript:report(\"".base64_encode($idUsuario)."\")'><img src='../images/book_add.jpg' width='15' height='15'> Reportes de conducta</button>";
							$actions[$ct]="R";
							$ct++;
						}
						
						
												
						$consulta="select distinct(clave) from 977_rolesVSPermisosModulo rp,976_permisosModulos pm where pm.idPermisosModulo=rp.idPermiso and rp.rol in(".$_SESSION["idRol"].") and pm.idModulo=1";
						$act=$con->obtenerFilasArreglo1D($consulta);
						if($act==null)
							$act=array();
					?>
                    
                    <table>
                    <tr>
                    	<td colspan="2" align="center"><span class="tituloPaginas">Ficha de usuario</span><br /><br /></td>
                    </tr>
                    <tr>
                    	<td  valign="top" style="margin:0; width:182px" align="center">
                        	<?php
								if(sizeof($act)>0)
								{
							?>
                                    <table id="box-table-b" style="width:182px;margin:0px;">
                                        <?php
                                        for($i=0;$i<count($actions);$i++)
                                        {	 
                                            if(in_array($actions[$i],$act))
                                            {
                                                echo "<tr>
                                                          <td style='padding:2px 5px'>
                                                          ".$elemento[$i]."
                                                          </td>
                                                     </tr>";
                                            }
                                        }
                                        ?>
                                    </table>
                            <?php
								}
                                 
								  
								  
								if(existeValor($act,"RA"))
								{
									 $consulta3="select codigoRol from 807_usuariosVSRoles where idUsuario=".$idUsuario;
	                                 $res3=$con->obtenerFilas($consulta3);
                            ?>
                            		<table id="box-table-b" style="width:182px; margin:0px; padding:0px"><!--tabla4-->
									  <?php
                                      echo "	<tr>
                                                        <th style='padding:0px 3px;vertical-align:middle'>
                                                        Roles Asociados
                                                        </th>
                                                   </tr>";
                                        while($fila=mysql_fetch_row($res3))
                                        { 
                                             
                                              echo "<tr>
                                                        <td style='padding:2px 3px' align='left'>
                                                        &#149;".obtenerTituloRol($fila[0])."
                                                        </td>
                                                   </tr>";
                                              
                                        }
                                          ?>
                                                                      
                                	</table>
                               <?php
								}
							   ?>
                    	</td>
                    <td valign="top">
                   
                        <table style="background-color:#D0DAFD;border:solid 3px #9BAFF1;"><!--tabla1-->
                    	<tr>
                        	<td width="140" align="right" valign="top" >
                            	<table>
                                	<tr>
                                    	<td>
                        			    <img height="140" width='140' src='verFoto.php?Id="<?php echo $idUsuario;?>"'/>
                                        </td>
                                     </tr>
                                     <tr>
                                     	<td>
                                        	
                                        </td>
                                     </tr>
                            	</table>
                            </td>
							<td align="left" valign="top">
                        	<?php
							$btnMail="";
							
							if(existeValor($act,"EC"))
							{
								$tieneMail=false;
								$consulta="SELECT Mail FROM 805_mails WHERE idUsuario=".$idUsuario." AND Notificacion=1";
								$mail=$con->obtenerValor($consulta);
								if($mail!="")
									$tieneMail=true;
								if($tieneMail)
									$btnMail="&nbsp;&nbsp;<a href='javascript:enviarMail()'><img src='../images/email_go.png' title='Enviar correo electr&oacute;nico' alt='Enviar correo electr&oacute;nico'></a>";
							}
							$columna1[0]="Nombre";
							$columna1[1]="Paterno";
							$columna1[2]="Materno";
							$columna1[3]="Prefijo";
							$columna1[4]="Ciudad Nac.";
							$columna1[5]="Estado Nac.";
							$columna1[6]="País";
							$columna1[7]="Nacionalidad";
							$columna1[8]="RFC";
							$columna1[9]="Fecha Nac.:";
							$columna1[10]="Genero";
							$columna1[11]="CURP";
							$columna1[12]="IMSS";
							$columna1[13]="CVU Conacyt";
							$consulta0="SELECT Nom,Paterno,Materno,Prefijo,
										if((SELECT municipio FROM 821_municipios WHERE cveMunicipio=i.ciudadNacimiento) is not null,(SELECT municipio FROM 821_municipios WHERE cveMunicipio=i.ciudadNacimiento),'') as ciudadNacimiento ,
										if((SELECT estado FROM 820_estados WHERE cveEstado=i.estadoNacimiento) is not null,(SELECT estado FROM 820_estados WHERE cveEstado=i.estadoNacimiento),'') as estadoNacimiento,
										paisNacimiento,Nacionalidad,
										RFC,DATE_FORMAT(fechaNacimiento,'%d/%m/%Y'),Genero,CURP,IMSS,cvuConacyt 
										FROM 802_identifica i WHERE idUsuario=".$idUsuario;
							$res0=$con->obtenerFilas($consulta0);
								  echo "
										<table id='one-column-emphasis' style='width:100%;margin:0px'>
												  <colgroup>
													  <col class='oce-first' />
												  </colgroup>
												<th colspan='4' height='50' align='center'>Datos Personales".$btnMail."</th>
										</table>
									
										<table id='one-column-emphasis' style='width:280px;margin:0px'>
										<colgroup>
											<col class='oce-first' />
										</colgroup>";
										$var=0;
										while($fila0=mysql_fetch_row($res0))
										{ 
											for($i=0;$i<count($fila0);$i++)
											{ 
												if($fila0[$i]!="")
													{
														$var++;
													}
											}
											$b=0;
											$var=$var/2;
											$alr= "
										</table>
												
						</td>
									
						<td valign='top'>
										<table id='one-column-emphasis' style='width:280px;margin:0px'>
										<colgroup>
											<col class='oce-first' />
										</colgroup>
										<th colspan='2'  height='50' align='right'></th>";
										$var=round($var);
										for($i=0;$i<count($fila0);$i++)
										{
										  if($fila0[$i]=="")
												{
													if($b==$var)
													{
														echo $alr;
													}
												}
										  else
												 {
													if($b==$var)
													{
														
															echo $alr;
													}
												
													if($fila0[10]==$fila0[$i])
													{
														if($fila0[$i]==1)
														{
														  $fila0[$i]='Femenino';
														}
														else
														{
														  $fila0[$i]='Masculino';
														}
														
													}
											echo "<tr>";
												echo "	<td scope='col' style='padding:4px 10px'>". $columna1[$i]. "</td>
														<td scope='col' style='padding:4px 10px'><font color='black'>". $fila0[$i] ."</font></td>";
											echo "</tr>"; 
											}
											$b++;
									  }
								   }
							  		echo "</table>
						";
									
                    		?>
                            		
                            
                            
                    		</td>
                    	</tr>
                    </table>
                    
					<?php
						if(existeValor($act,"DC"))
						{
							$consulta2="SELECT *FROM 803_direcciones WHERE idUsuario=".$idUsuario;
							$cInfo=$con->obtenerPrimeraFila($consulta2);
							$ciudad=$cInfo[5];
							
							$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$ciudad."'";
							$tmp=$con->obtenerValor($consulta);
							if($tmp!="")
								$ciudad=$tmp;
							$estado=$cInfo[7];
							$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$estado."'";
							$tmp=$con->obtenerValor($consulta);
							if($tmp!="")
								$estado=$tmp;
							
							$pais=$cInfo[8];
							$consulta="SELECT nombre FROM 238_paises WHERE idPais='".$pais."'";
							$tmp=$con->obtenerValor($consulta);
							if($tmp!="")
								$pais=$tmp;
							
                        ?>
                                <fieldset class="frameHijo" style="border:solid 3px #9BAFF1;"><legend><b>DIRECCIÓN PERSONAL</b></legend>
                                <table width="670">
                                    <tr height="25" valign="top">
                                            <td style="width:100px" align="left" >
                                            <label >Calle:</label>
                                            </td>
                                            <td style="width:200px" align="left">
                                            <label class="copyrigth">
                                              <?php echo ($cInfo[2]);?>
                                            </label>    
                                            </td>
                                            <td style="width:100px" align="left"><label>Número:</label >
                                            </td>
                                            <td  align="left"><label class="copyrigth">
                                             <?php echo ($cInfo[3]);?>
                                             </label>    
                                             </td>
                                      </tr>   
                                        <tr height="25" valign="top" align="left">
                                             <td><label>Colonia:</label>
                                            </td>
                                            <td  align="left"><label class="copyrigth">
                                              <?php echo ($cInfo[4]);?>
                                              </label>    
                                             </td>
                                                <td align="left"><label>Ciudad:</label>
                                                  
                                                </td>
                                                <td  align="left"><label class="copyrigth">
                                                  <?php echo $ciudad?>
                                                  </label>    
                                                 </td>
                                          <tr height="25" valign="top">
                                                <td align="left"><label>Estado:</label>
                                                </td>
                                                <td  align="left"><label class="copyrigth">
                                                  <?php echo $estado;?>
                                                  </label>    
                                                 </td>
                                                <td align="left"><label>País:</label>
                                                </td>
                                                <td align="left"><label class="copyrigth">
                                                  <?php echo $pais;?>
                                                  </label>    
                                                  </td>
                                       </tr>
                                        <tr height="25" valign="top">
                                                  <td align="left"><label>Código Postal:</label>
                                                  </td>
                                                    <td align="left"><label class="copyrigth">
                                                      <?php echo ($cInfo[6]);?>
                                                      </label>    
                                                    </td>
                                                     <td align="left">
                                                  </td>
                                                    <td  align="left">
                                                    </td>
                                         </tr>
                                        <tr height="25" valign="top">
                                            <td align="left" valign="top"><label>E-mail:</label>
                                            </td>
                                            <td  align="left">
                                            <?php
												$consulta="select Mail from 805_mails where idUsuario=".$idUsuario." and Tipo=0";
												$res=$con->obtenerFilas($consulta);
												while($fila=mysql_fetch_row($res))
												{
											?>
                                            	<span class="copyrigth"><?php echo $fila[0]?></span><br />
                                            <?php
												}
											?>
                                            
                                            </td>
                                            <td align="left" valign="top">
                                                <label >Teléfonos:</label>
                                            </td>
                                            <td align="left">
                                             <?php
												$consulta="select * from 804_telefonos where idUsuario=".$idUsuario." and tipo=0";
												
												$res=$con->obtenerFilas($consulta);
												while($fila=mysql_fetch_row($res))
												{
													$ext="";
													if(trim($fila[3])!="")
														$ext="(Ext. ".$fila[3].")";
													$tipoTel="";
													switch($fila[5])
													{
														case 0:
															$tipoTel="Teléfono";
														break;
														case 1:
															$tipoTel="Celular";
														break;
														case 2:
															$tipoTel="Fax";
														break;
													}
											?>
                                            	<span class="copyrigth">(<?php echo $fila[1]?>)-<?php echo $fila[2]." ".$ext?> - <?php echo $tipoTel ?></span><br />
                                            <?php
												}
											?>
                                            </td>
                                         </tr>
                            </table>
                            </fieldset>
                            <?php
						}
						if(existeValor($act,"ADS"))
						{
								$consulta="select * from 801_adscripcion where idUsuario=".$idUsuario;
								$filaA=$con->obtenerPrimeraFila($consulta);
								
								$institucion="No especificado";
								$depto="No especificado";
								$puesto="No especificado";
								if($filaA[1]!="")
								{
									$consulta="select unidad from 817_organigrama where codigoUnidad='".$filaA[1]."'";	
									$institucion=$con->obtenerValor($consulta);
									$consulta="select unidad from 817_organigrama where codigoUnidad='".$filaA[12]."'";	
									$depto=$con->obtenerValor($consulta);
									$consulta="select puesto from 819_puestosOrganigrama where idPuesto='".$filaA[4]."'";	
									$puesto=$con->obtenerValor($consulta);
								}
								
							?>
                            
                            <fieldset class="frameHijo" style="border:solid 3px #9BAFF1;"><legend><b>ADSCRIPCIÓN</b></legend>
                                <table width="670">
                                    <tr height="25" valign="top">
                                            <td style="width:100px" align="left">
                                            <label>Institución:</label>
                                            </td>
                                            <td style="width:200px" align="left">
                                            <label class="copyrigth">
                                              <?php echo $institucion;?>
                                            </label>    
                                            </td>
                                            <td style="width:100px" align="left">
                                            <label>Departamento:</label >
                                            </td>
                                            <td  align="left"><label class="copyrigth">
                                             <?php echo $depto;?>
                                             </label>    
                                             </td>
                                      </tr>   
                                      <tr height="25" valign="top">
                                            <td style="width:100px" align="left">
                                            <label>Puesto:</label>
                                            </td>
                                            <td style="width:200px" align="left">
                                            <label class="copyrigth">
                                              <?php echo $puesto;?>
                                            </label>    
                                            </td>
                                            <td style="width:100px" align="left">
                                            </td>
                                            <td  align="left">
                                             </td>
                                      </tr>   
                                      <tr height="25" valign="top">
                                            <td align="left" valign="top"><label>E-mail:</label>
                                            </td>
                                            <td  align="left">
                                            <?php
												$consulta="select Mail from 805_mails where idUsuario=".$idUsuario." and Tipo=1";
												$res=$con->obtenerFilas($consulta);
												while($fila=mysql_fetch_row($res))
												{
											?>
                                            	<span class="copyrigth"><?php echo $fila[0]?></span><br />
                                            <?php
												}
											?>
                                            
                                            </td>
                                            <td align="left" valign="top" class="">
                                                <label >Teléfonos:</label>
                                            </td>
                                            <td align="left" class="">
                                             <?php
												$consulta="select * from 804_telefonos where idUsuario=".$idUsuario." and tipo=1";
												$res=$con->obtenerFilas($consulta);
												while($fila=mysql_fetch_row($res))
												{
													$ext="";
													if($fila[3]!="")
														$ext="(Ext. ".$fila[2].")";
													$tipoTel="";
													switch($fila[5])
													{
														case 0:
															$tipoTel="Teléfono";
														break;
														case 1:
															$tipoTel="Celular";
														break;
														case 2:
															$tipoTel="Fax";
														break;
													}
											?>
                                            	<span class="copyrigth">(<?php echo $fila[1]?>)-<?php echo $fila[2]." ".$ext?> - <?php echo $tipoTel ?></span><br />
                                            <?php
												}
											?>
                                            </td>
                                         </tr>
                                </table>
                           </fieldset>
                           <?php
						   
						   
						   
						   
						}
						
						$consulta="select complementario from 977_rolesVSPermisosModulo rp where  rp.rol in(".$_SESSION["idRol"].") and rp.idPermiso=1";
						$listTiposProc=$con->obtenerValor($consulta);
						
						if($listTiposProc!="")
						{
							$arrTiposProc=explode(",",$listTiposProc);
							foreach($arrTiposProc as $tipoProc)
							{
								$ctElementos=0;
								$nColumnas=3;
								$consulta="select tipoProceso FROM 921_tiposProceso WHERE idTipoProceso=".$tipoProc;
								$nTipoProceso=$con->obtenerValor($consulta);
								$fieldSet='
											<fieldset class="frameHijo" style="border:solid 3px #9BAFF1;">
												<legend><b>'.$nTipoProceso.'</b></legend>
													<table width="670">';
												
												$consulta="select idProceso,nombre from 4001_procesos where idTipoProceso=".$tipoProc." order by nombre";
												$resCV=$con->obtenerFilas($consulta);
												$ctCol=0;
												while($filaCV=mysql_fetch_row($resCV))
												{
													$idProceso=$filaCV[0];
													$consulta="select nombreTabla,idFormulario from 900_formularios where idProceso=".$idProceso." and formularioBase=1";
													
													$filaFrm=$con->obtenerPrimeraFila($consulta);
													$nTabla=$filaFrm[0];
													$idFormulario=$filaFrm[1];
													
													$idFrmAutores=incluyeModulo($idProceso,3);
													if($idFrmAutores=="-1")
														$condWhere=" where responsable=".$idUsuario;
													else
													{
														$idFormularioBase=obtenerFormularioBase($idProceso);	
														$condWhere=" where id_".$nTabla." in (select distinct idReferencia from 246_autoresVSProyecto where idUsuario=".$idUsuario." and idFormulario=".$idFormularioBase.")";
													}
													
													$consulta="select id_".$nTabla.",idEstado from ".$nTabla.$condWhere;

													$resReg=$con->obtenerFilas($consulta);
													$nReg=$con->filasAfectadas;
													if($nReg>0)
													{
														  if($ctCol==0)
														  {
															  $fieldSet.='<tr height="25" valign="top">';
														  }
														  
														  $ctCol++;
														  $fieldSet.= '<td class="celdaGris" align="left"><img src="../images/bullet_red.png"><a href="javascript:verElemento(\''.base64_encode($idProceso).'\',\''.base64_encode($idUsuario).'\')"><span class="">'.$filaCV[1].' ('.$nReg.')</span></a></td>';
														  if($ctCol==$nColumnas)
														  {
															  $fieldSet.='</tr>';
						  
															  $ctCol=0;
														  }
														  $ctElementos+=$nReg;
													}
												}
												
												if($ctCol!=0)
												{
													for($x=$ctCol;$x<$nColumnas;$x++)
													{
														$fieldSet.= "<td></td>";
													}
													$fieldSet.= "</tr>";
												}
												
										
									$fieldSet.='	</table>
											</fieldset>';
									if($ctElementos>0)
										echo $fieldSet."";
							}
						}
					 ?>
                     <input type="hidden" id="soloContenido" value="<?php echo $soloContenido?>" />
                     <input type="hidden" id="idUsr" value="<?php  echo bE($idUsuario)?>" />
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
