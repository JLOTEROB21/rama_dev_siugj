<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");
header("Content-Type:text/html;charset=utf-8");
$arrIdSecciones;
$arrElemDTD;
$numSec=0;
function obtenerFuncionesDoc($padre)
{
	global $con;
	global $arrIdSecciones;
	global $arrElemDTD;
	global $numSec;
	$res=$con->obtenerFilas("select re.tag,re.tipo_elemento,re.tipo_entrada,e.idElementoDTD,re.id_elemento from 203_elementosDTD e,200_elementosRevista re
where re.id_elemento=e.idElementoRevista  and e.idElementoPadre=".$padre);
	while($fila=mysql_fetch_row($res))
	{
		if($fila["1"]=="3")
		{
			$resAux=$con->obtenerFilas("select nf.idFuncion from 219_nombreFuncionesElementos nf  where  nf.idFuncion=".$fila[2]." and nf.idLenguaje=".$_SESSION["leng"]);
			$filaAux=mysql_fetch_row($resAux);
			$arrElemDTD[$numSec]=$fila[3];
			$arrIdSecciones[$numSec]=$filaAux[0];
			$numSec++;
		}
		else
			obtenerFuncionesDoc($fila[3]);
	}
}

if(isset($_POST["crearCuestionario"]))
{
	if($_POST["tCuestionario"]=="1")
		$porcentaje="100";
	else
		$porcentaje="0";
	
	$consulta[0]="begin";
	$consulta[1]="update 231_cuestionariosEvaluacion set vigente=0 where idDTD=".$_POST["idDTD"];
	$consulta[2]="insert into 231_cuestionariosEvaluacion (nombreCuestionario,descripcion,fechaCreacion,idUsuario,tipoCuestionario,idDTD,vigente,porcentaje) values
				('".cv($_POST["txtNombre"])."','".cv($_POST["descripcion"])."','".date('Y-m-d')."',".$_SESSION["idUsr"].",".$_POST["tCuestionario"].",".$_POST["idDTD"].",1,".$porcentaje.")";
	
	if($con->ejecutarBloque($consulta))
	{
		$idCuestionario=$con->obtenerUltimoID();
		$consultaS="select idSeccionCuestSig from 232_variablesSistema for update";
		$idSecc=$con->obtenerValor($consultaS);

		
		if($_POST["tCuestionario"]=="1")
		{
			$consulta[0]="update 202_descripcionDTD set idCuestionarioEval=".$idCuestionario." where idDTD=".$_POST["idDTD"];
			$x=1;
			
			$consultaAux="Select texto,idIdioma from 814_etiquetasIdiomaPaginas where nombre='lblGeneral'";
			$resAux=$con->obtenerFilas($consultaAux);
			$ct=0;
			while($filaAux=mysql_fetch_row($resAux))
			{
				$arrSecciones[$ct]=$filaAux[0];
				$arrLenguaje[$ct]=$filaAux[1];
				$ct++;
			}
			
			for($num=0;$num<$ct;$num++)
			{
				$consulta[$x]="insert into 233_seccionesCuestionario(nombreSeccion,ponderacion,idCuestionario,idIdioma,idGrupoSeccion,idElementoDTD) values
							('".$arrSecciones[$num]."',100,".$idCuestionario.",".$arrLenguaje[$num].",".$idSecc.",-".$_POST["idDTD"].")";	
				$x++;
				
							
			}
			
			$consulta[$x]="update 232_variablesSistema set idSeccionCuestSig=idSeccionCuestSig+1";
			$x++;
			$consulta[$x]="commit";
			if(!$con->ejecutarBloque($consulta))
				return;
		
		}
		else
		{
			obtenerFuncionesDoc("-".$_POST["idDTD"]);
			$sumaS=0;
			$x=0;
			$arrQuery[$x]="update 202_descripcionDTD set idCuestionarioEval=".$idCuestionario." where idDTD=".$_POST["idDTD"];
			$x++;
			for($ct=0;$ct<$numSec;$ct++)
			{
				$query="select NombreFuncion,idLenguaje from 219_nombreFuncionesElementos where idFuncion=".$arrIdSecciones[$ct];
				$rSecciones=$con->obtenerFilas($query);
				
				while($fSecciones=mysql_fetch_row($rSecciones))
				{
					$arrQuery[$x]="insert into 233_seccionesCuestionario(nombreSeccion,ponderacion,idCuestionario,idIdioma,idGrupoSeccion,idElementoDTD) values
								('".$fSecciones[0]."',0,".$idCuestionario.",".$fSecciones[1].",".($idSecc+$sumaS).",".$arrElemDTD[$ct].")";	
					$x++;
				}
				$sumaS++;
			}

			$arrQuery[$x]="update 232_variablesSistema set idSeccionCuestSig=idSeccionCuestSig+".$sumaS;
			$x++;
			$arrQuery[$x]="commit";
			if(!$con->ejecutarBloque($arrQuery))
				return;
			
			
			
			
			
		}
		
		
		$confReferencia="-1";
		if(isset($_POST["confReferencia"]))
			$confReferencia=$_POST["confReferencia"];
			
		echo '
					<body>
					<form method="post" action="cuestinarioDictamen.php" id="frmEnvio">
						<input type="hidden" name="idCuestionario" value="'.$idCuestionario.'" />
						<input type="hidden" name="confReferencia" value="'.$confReferencia.'"/>
						
						
					</form>
					<script>
						document.getElementById("frmEnvio").submit();
					</script>
					</body>
			';
			return;
		

	}
}



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

<script type="text/javascript" src="Scripts/tblCuestionario.js.php"></script>
<script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
<?php
$mostrarMenuIzq=false;
$guardarConfSession=true;

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
                        <br />
                        <?php
							$consulta="select idCuestionarioEval from 202_descripcionDTD where idDTD=".$_POST["idDTD"]." and idIdioma=".$_SESSION["leng"];
							$idCuestionario=$con->obtenerValor($consulta);
							if($idCuestionario=="-1")
							{
						?>
                        		<table width="100%">
                                	<tr>
                                    	<td class="letraFichaRespuesta" align="center"><?php echo $et["lblDTDSinCuest"]?></td>
                                        
                                    </tr>
                                    <tr>
                                    <td>
                                    	<br />
                                        <br />
                                        <table width="100%">
                                        <tr>
                                        	<td width="100"></td>
                                            <td>
                                        		<form name="frmEnvio" id="frmEnvio" method="post" action="tblCuestionario.php">
                                                <table width="80%">
                                                    <tr>
                                                        <td class="letraFicha"><?php echo $et["lblTipoCuest"]?>:</td>
                                                        <td>
                                                            <select name="tCuestionario">
                                                                <option value="1"><?php echo $et["lblGeneral"]?></option>
                                                                <option value="2"><?php echo $et["lblPorSecciones"]?></option>                                                        
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td class="letraFicha"><?php echo $et["lblNombres"]?>: <span class="letraRoja">*</span></td>
                                                        <td><input type="text" name="txtNombre" maxlength="50" size="40" val="obl" campo="<?php echo $et["lblNombres"]?>" /></td>
                                                     
                                                    </tr>
                                                    <tr>
                                                    	<td class="letraFicha" valign="top"><?php echo $et["lblDescripcion"]?>:</td>
                                                        <td>
                                                        	<textarea cols="50" rows="5" name="descripcion"></textarea>
                                                        </td>
                                                     
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" align="center">
                                                        <br />
                                                        <input type="hidden" name="idDTD" value="<?php echo $_POST["idDTD"] ?>" />
                                                        <input type="hidden" name="confReferencia" value="<?php echo $nConfiguracion ?>" />
                                                        <input type="hidden" name="crearCuestionario" value="1" />
                                                        <input class="btnAceptar" type="button" value="<?php echo $et["lblBtnAceptar"]?>" onclick="enviarFormulario('frmEnvio')" /> 
                                                        </td>
                                                    </tr>
                                                </table>
                                                </form>
                                            </td>
                                       </tr>
                                       </table>
                                    </td>
                                    </tr>
                                
                                </table>
                        <?php		
							}
							else
							{
								$consulta="select idCuestionario,nombreCuestionario,descripcion,fechaCreacion,tipoCuestionario,vigente
											from 231_cuestionariosEvaluacion where idDTD=".$_POST["idDTD"]." order by  vigente desc,fechaCreacion,nombreCuestionario";
								$res=$con->obtenerFilas($consulta);											
						?>
                        
                        	<table>
                            	<tr>
                                	<td class="tituloTabla" width="180"><?php echo $et["lblNombreC"]?></td>
                                    <td class="tituloTabla" width="300"><?php echo $et["descripcion"]?></td>
                                    <td class="tituloTabla" width="150"><?php echo $et["fechaCreacion"]?></td>
                                    <td class="tituloTabla" width="150"><?php echo $et["lblTipoC"]?></td>
                                    <td class="tituloTabla" width="100"><?php echo $et["lblVigente"]?></td>
                                    <td class="tituloTabla" width="50"></td>
                                    
                                </tr>
                            
                        
                        <?php
								$filaC="filaBlanca10";
								while($f=mysql_fetch_row($res))
								{
									echo 	"<tr>
												<td class='".$filaC."'>".$f[1]."</td>
												<td class='".$filaC."'>".$f[2]."</td>
												<td class='".$filaC."' align='center'>".date('d/m/Y',strtotime($f[3]))."</td>";
									if($f[4]==1)
										echo	"<td class='".$filaC."'>".$et["lblGeneral"]."</td>";
									else
										echo	"<td class='".$filaC."'>".$et["lblPorSecciones"]."</td>";
									if($f[5]==1)
										echo	"<td class='".$filaC."' align='center'><img src='../images/accept_green.png'></td>";
									else	
										echo	"<td class='".$filaC."' align='center'><img src='../images/cancel_round.png' ></td>";
									
									echo "<td align='center'><a href='javascript:modificarCuestionario(".$f[0].")'><img src='../images/notes_edit.png' title='".$et["modificar"]."' alt='".$et["modificar"]."'></a></td>
												</tr>";
									if($filaC=="filaBlanca10")
										$filaC="filaRosa10";
									else
										$filaC="filaBlanca10";
									
								}
							}
						?>
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
