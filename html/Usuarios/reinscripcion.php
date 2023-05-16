<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");

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
<title>LATIS</title>
<script language='javascript'>
	var GB_ROOT_DIR = '../Scripts/grb/';
	var arrRelaciones=new Array();
	
</script>

<?php
	$pagRegresar="../principal/inicio.php";
	$consulta="select IdRelacion,Tipo from 4115_parentezco";
	$arrRelaciones=$con->obtenerFilasJson($consulta);
	$arrRel=$con->obtenerFilasArreglo($consulta);	
	echo "	<script> 
					var arrTiposRelaciones=".$arrRelaciones."; 	
					var tablaRelacions=".$arrRel.";
			</script>";
		
	
	
	function evaluarGrados($programa,$grado)
	{
		switch($programa)
		{
			case 1:
				if($grado==3)//Kinder
				{
					$prog=2;
					$grado=1;
				}
				else
				{
					$prog=1;
					$grado=$grado+1;
				}
			break;
			case 2:
				if($grado==6)//Primaria
				{
					$prog=3;
					$grado=1;
				}
				else
				{
					$prog=2;
					$grado=$grado+1;
				}
			break;
			case 3:
				if($grado==3)//Secndaria
				{
					$prog=4;
					$grado=1;
				}
				else
				{
					$prog=3;
					$grado=$grado+1;
				}
			break;
			case 4:
				if($grado==6)//Prepa
				{
					$prog=0;
					$grado=0;
				}
				else
				{
					$prog=4;
					$grado=$grado + 1;
				}
			break;
		}

		return $prog."|".$grado;
	}
	function obtenerProgramaCadena($cadena)
	{
		global $con;
		$prog=substr($cadena,0,1);
		$consulta="select nombrePrograma from 4004_programa where idPrograma=".$prog;
		$programa=$con->obtenerValor($consulta);
		return $programa;
		
	}
	function obtenerGrado($cadena)
	{
		$grad=substr($cadena,2,1);
		if($grad==0)
			return "-";
		else
			return $grad;
	}
	
?>
<script type="text/javascript" src="../Scripts/grb/AJS.js.jgz"></script>
<script type="text/javascript" src="../Scripts/grb/AJS_fx.js.jgz"></script>
<script type="text/javascript" src="../Scripts/grb/gb_scripts.js.jgz"></script>
<script type="text/javascript" src="../Scripts/grb/WindowPopup.js.jgz"></script>
<link  rel="stylesheet" type="text/css" href="../Scripts/grb/gb_styles.css.cgz" />
<script type='text/javascript' src='Scripts/reinscripcion.js' ></script>
<script language="javascript" src="../Scripts/funcionesValidacion.js.jgz"></script>

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
                        
                        <form id='reinscripcion' name='reinscripcion' action='procesarReinscripcion.php' method='post' >
                        <table width="100%">
                        <tr>
                        <td width="5%">
                        </td>
                        <td width="60%">
                            <table width='100%' border='0' cellspacing='1' cellpadding='1' align='center'>
                                <tr>
                                    <td>
                                        <fieldset class="frameHijo"><legend><b>DATOS PERSONALES</legend>
                                        <table border='0' align='center' id="tblPersonales">
                                          <tr height="25" valign="top">
                                            <td><label>Apellido Paterno:</label></td>
                                            <td>&nbsp;</td>
                                            <?php
											$IdUsuario=$_SESSION["idUsr"];
                                            $sql="select Paterno,Materno,Nom,RFC,date_format(fechaNacimiento,'%d/%m/%Y'),Calle,Numero,Colonia,Ciudad,803_direcciones.idDireccion,Municipio,CP,Nombre
                                                from 802_identifica,803_direcciones 
                                                where 802_identifica.idUsuario=803_direcciones.idUsuario 
                                                and Tipo=0 AND 802_identifica.idUsuario=".$IdUsuario;
                                                $Personales=$con->obtenerPrimeraFila($sql);
                                                echo"<td width='220'><input type='text' name='APaterno_Vtu' id='Apellido_Paterno' value='".($Personales[0])."' val='obl|txt' campo='Apellido Paterno'/></td>";
                                            ?>
                                            <td width='110'><label>Apellido Materno:</label></td>
                                            <td width='22'>
                                            <input type="hidden" name="hNombreU" id="hNombreU" value="<?php echo ($Personales[12])?>" /> 
                                            <input type="hidden" name="idUsuarioAct" id="idUsuarioAct" value="<?php echo $IdUsuario ?>" />
                                            </td>
                                        <?php
                                        echo"<td width='151'><input type='text' name='AMaterno_Vtu' id='Apellido_Materno' value='".($Personales[1])."' val='txt' campo='Apellido Materno'/></td>";
                                        ?>
                                        </tr>
                                        <tr height="25" valign="top">
                                            <td><label for='_Nom'>Nombre:</label></td>
                                            <td>&nbsp;</td>
                                            <?php
                                            echo"<td><input type='text' name='Nombre_Vtu' id='Nombre' value='".($Personales[2])."' val='obl|txt' campo='Nombre'/></td>";
                                            ?>
                                            <td><label>RFC:</label></td>
                                            <td>&nbsp;</td>
                                            <?php
                                            echo"<td><input type='text' name='RFC' id='RFC' value='".($Personales[3])."' val='txt' campo='RFC'/></td>";
                                            ?>
                                        </tr>
                                        <tr height="25" valign="top">
                                          <td><label>Fecha de Nacimiento: </label></td>
                                          <td>&nbsp;</td>
                                          <td align="left"><label>
                                            <span name='FNac' id='FNac'></span>
                                            <?php
                                              echo"</label><input type='hidden' name='FNacimiento' id='FNacimiento' value='".($Personales[4])."' val='obl|dte' campo='Fecha de Nacimiento' extId='fecha'></td>";
                                            ?>
                                          <td><label>Calle:</label></td>
                                          <td>&nbsp;</td>
                                          <td><label>
                                          <?php
                                          echo"<input type='text' name='Calle' id='Calle' value='".($Personales[5])."' val='obl|txt' campo='Calle'/>";
                                          ?>
                                          </label></td>
                                        </tr>
                                        <tr height="25" valign="top">
                                            <td><label for='_num'>Número:</label></td>
                                            <td>&nbsp;</td>
                                            <?php
                                            echo"<td><input type='text' name='Numero_Vdi' id='Numero' value='".($Personales[6])."' val='obl|txt' campo='Número'/></td>";
                                            ?>
                                            
                                            <td><label for='_col'>Colonia:</label></td>
                                            <td>&nbsp;</td>
                                            <?php
                                            echo"<td><input type='text' name='Colonia_Vdi' id='Colonia' value='".($Personales[7])."' val='obl|txt' campo='Colonia'/></td>";
                                            ?>
                                        </tr>
                                        <tr height="25" valign="top">
                                            <td><label for='_ciu'>Ciudad:</label></td>
                                            <td>&nbsp;</td>
                                            <?php
                                            echo"<td><input type='text' name='Ciudad' id='Ciudad' value='".($Personales[8])."' val='obl|txt' campo='Ciudad'/></td>";
                                            ?>
                                            
                                            <td><label for='tel'>Municipio:</label></td>
                                            <td>&nbsp;</td>
                                            
                                            <?php
                                            echo"<td><input type='text' name='Municipio' id='Municipio' value='".($Personales[10])."' val='obl|txt' campo='Municipio'/></td>";
                                            ?>
                                        </tr>
                                        <tr height="25" valign="top">
                                        <td><label for='_ciu'>C.P:</label></td>
                                            <td>&nbsp;</td>
                                            <?php
                                            echo"<td><input type='text' name='CP' id='CP' value='".($Personales[11])."' val='num' campo='CP' onkeypress='return soloNumero(event,false,false)'/></td>";
                                            ?>
                                        </tr>
                                        <tr height="25" valign="top">
                                            <td rowspan='2' ali><label>Tel&eacute;fonos:</label>
                                            <label for='cel'></label></td>
                                            <?php
                                            $tel="SELECT idTelefono,concat(Lada,'-',Numero,' Ext.(',Extension,')',' - ',(select case Tipo2 when 0 then 'Tel&eacute;fono'  when 1 then 'Celular' when 2 then 'Fax' end)) as telefonos FROM 804_telefonos 
                                            where Tipo=0 and 804_telefonos.idUsuario=".$IdUsuario;
                                            echo"<td><table><tr>";
                                            echo"<td align='left'><a href='javaScript:solicitarTel(".$IdUsuario.",0)'><img src='../images/icon_big_tick.gif' alt='Agregar' height='13' title='Agregar Tel&eacute;fono' border='0'/></a></td></tr>";
                                            echo"<tr><td align='left'><a href='javaScript:eliminarTel(0)'><img src='../images/cancelar.gif' alt='Eliminar'  title='Eliminar Tel&eacute;fono' border='0'/></a></td></tr></table></td>";
                                            
                                            echo"<td rowspan='2'><input type='hidden' name='IdDireccionCasa' id='IdDireccionCasa' value='".$Personales[10]."'>";
                                            echo"<select name='Telefono' id='Telefono' size='3' style='width:200px'>";
                                            echo $con->generarOpcionesSelect($tel)."</select>";
                                            $mail="SELECT idMail,Mail FROM 805_mails WHERE idUsuario=".$IdUsuario;
                                            ?>
                                            </td>
                                            
                                            <td rowspan='2'><label>Correo Electr&oacute;nico:</label>
                                            <label></label></td>
                                            
                                            <td >
                                                <table>
                                                    <tr><td>
                                                    <a href='javaScript:solicitarMail(<?php echo $IdUsuario;?>,0)'><img src='../images/icon_big_tick.gif' alt='Agregar' title='Agregar Mail' border='0' height='13'/></a>
                                                    </td></tr>
                                                    <tr><td align='left'><a href='javaScript:eliminarMail()'><img src='../images/cancelar.gif' title='Eliminar Mail' border='1'/></a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td rowspan='2'><label>
                                            <select name='Mail' id='Mail' size='3' style='width:220px'>
                                            <?php
                                            $con->generarOpcionesSelect($mail)
                                            ?>
                                            </select>
                                            </label></td>
                                        </tr>
                                        </table align='center'>
                                    </fieldset>	
                                    </td>
                                            
                                    <tr><td>&nbsp;</td></tr>
                                        <td>
                                            <fieldset class="frameHijo"><legend><b>DATOS LABORALES</legend>
                                            <table border='0' align='center'>
                                             <tr height="25" valign="top">
                                                <td><label for='_Apat'>Empresa/Institución:</label></td>
                                            <?php
                                                $sql="select Institucion,Profesion,puestoAbierto,idAdscripcion 
                                                from 801_adscripcion
                                                where idUsuario=".$IdUsuario;
                                                
                                                $Laborales=$con->obtenerPrimeraFila($sql);
                                            
                                            echo"<td>&nbsp;</td><td width='220'><input type='text' name='Empresa' id='Empresa' value='".($Laborales[0])."' val='txt'  campo='Empresa o Institución'/></td>";
                                            ?>
                                            
                                            <td width='126'><label for='_Amat'>Ocupación/Profesión:</label></td>
                                            <td width='22'>&nbsp;</td>
                                            <?php
                                            echo"<td width='151'><input type='text' name='Profesion' id='Profesion' value='".($Laborales[1])."' val='txt'     campo='Ocupación o Profesión'/></td>";
                                            ?>
                                            </tr>
                                            <tr height="25" valign="top">
                                            <td><label>Puesto:</label></td><td width='22'>&nbsp;</td>
                                            
                                            <?php
                                            echo"<td><input type='text' name='Puesto' id='Puesto' value='".($Laborales[2])."' val='txt' campo='Puesto'/></td>";
                                            ?>
                                            
                                            
                                            <?php
                                            $tel="SELECT idTelefono,concat(Lada,'-',Numero,' Ext.(',Extension,')',' - ',(select case Tipo2 when 0 then 'Tel&eacute;fono'  when 1 then 'Celular' when 2 then 'Fax' end)) as telefonos FROM 804_telefonos 
                                            where Tipo=1 and 804_telefonos.idUsuario=".$IdUsuario;
                                            echo"<td><input type='hidden' name='IdDireccionLab' id='IdDireccionLab' value='".($Laborales[3])."'><label>Tel&eacute;fonos: </label></td>";
                                            ?>
                                            <td>
                                                <table>
                                                    <tr>
                                                    <td>
                                            <?php
                                                    echo"<a href='javaScript:solicitarTel(".$IdUsuario.",1)'><img src='../images/icon_big_tick.gif' id='btnAgregarT' alt='Agregar' height='13' title='Agregar Tel&eacute;fono' border='0'/></a>";
                                            ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><a href='javaScript:eliminarTel(1)'><img src='../images/cancelar.gif' alt='Eliminar' title='Eliminar Tel&eacute;fono' border='0'/></a></td>
                                                </tr>
                                            </table>
                                            <td rowspan='2'>
                                            <select name='TelefonoLab' id='TelefonoLab' size='3' style='width:220px'>
                                            <?php
                                            $con->generarOpcionesSelect($tel)
                                            ?>
                                            </select>
                                            </td>
                                        </tr>
                                        </table>
                                        </fieldset>	
                                        </td>
                                    </tr>
                                        
                                        
                                        <tr>
                                        <!--<td align='right'><b>Para crear una nueva cuenta, de click <a href='nuevaCuenta.php' title='Nuevo ingreso' onClick="return WPopup('LATIS',this.href,400,800,null,miFuncion)">AQU&Iacute; </a></td>-->
                                        <!--<td align="right"><a href="javaScript:GuardarDatos('reinscripcion')"><span></span> <img src="../images/floppy_disk_48.png" title="Actualizar Datos" border="0" width="25"/><b>Actualizar</a></td>-->
                                        </tr>
                                        <tr>
                                        <td>
                                        
                                        </td>
                                        </tr>
                                    </td>
                                    <td>
                                    <table width='100%' border='0' cellspacing='1' cellpadding='1' align='center'>
                                    <tr>
                                        <td align='center' >
                                       	<b>
                                        <font color="green" size="-1">Para registrar un nuevo aspirante, dé click 
                                        <a href='nuevoAspirante.php' title='Nuevo ingreso' onClick="return nuevoAspirante(this.href)">
                                        <font size="2"><font color="#FF0000">AQU&Iacute;</font> 
                                        </a>
                                        </font>
                                        </b>
                                        </td>
                                        <td align="right"></td>
                                    </tr>
                                </table>
                                <br />
                                        <fieldset class="frameHijo"><legend><b>ALUMNOS REGISTRADOS</b></legend>
                                        <br />
                                        <table id="tblAlumnosR" width="100%">
                                            
                                        <?php
                                            
                                            $sql="Select distinct(802_identifica.Nombre),IdPrograma,Grado,4118_alumnos.idUsuario,IdParentezco,viveCon,802_identifica.Status from 802_identifica,4125_alumPers,4118_alumnos
                                            where 802_identifica.idUsuario=4125_alumPers.idAlumno and 4118_alumnos.idUsuario=4125_alumPers.idAlumno AND 4125_alumPers.idUsuario=".$IdUsuario." order by 802_identifica.Status,802_identifica.Nombre";
                                                //					echo $sql;
                                            $result = $con->obtenerFilas( $sql);
                                            $c=0;
                                            $numAlumnos=mysql_num_rows($result);
                                            while ( $alumno = mysql_fetch_row ( $result ) )
                                            {
                                                $c++;
                                                echo "<tr><td>";
                                                echo '<table width="100%"  border=0 align="center" id="tblVive'.$c.'" class="tablaUsuario">';
                                                echo "<tr><td colspan=2 class='tituloTabla' style='text-align:left !important'>".($alumno[0])."</td></tr>";
                                                echo '<tr  ><td align="center" class=""><br><b>GRD/SEM ACTUAL</b></td><td align="center" class=""><br><b>PROGRAMA</br></td><td align="center" class=""><br><b>VIVE CON</b></td></tr>';
                                        
                                                echo"<tr>";
                                                $s="SELECT nombrePrograma,idPrograma from 4004_programa WHERE idPrograma=".$alumno[1];
                                                $prog=$con->obtenerPrimeraFila($s);
                                                if($alumno[6]!='106')
                                                {
                                                    $PrgGrad=evaluarGrados($prog[1],$alumno[2]);
                                                    $sigProg=obtenerProgramaCadena($PrgGrad);
                                                    $sigGrado=obtenerGrado($PrgGrad);
                                                }
                                                else
                                                {
                                                    $sigGrado=$alumno[2];
                                                    $sigProg=$prog[0];
													$PrgGrad=' ';
                                                    
                                                }

                                                echo"<input type='hidden' id='hProg".$c."' value='".substr($PrgGrad,0,1)."'><input type='hidden' id='hGrado".$c."' value='".$sigGrado."'></td>";
                                                
                                                
                                                echo"<td class='copyrigth' align='center'><b>".$sigGrado."</td>";
                                                echo "<td class='copyrigth'><b>".$sigProg."</td>";
                                                $consu="SELECT IdReinscripcion FROM 4129_reinscripciones WHERE IdAlumno=".$alumno[3];
												$nFila=$con->obtenerFilas($consu);
                                                $reinsc=mysql_num_rows($nFila);
                                                if($reinsc!=0)
                                                    $reinsc=1;
                                                if($alumno[6]=='106')
                                                {
                                                    $reinsc="2";
                                                }
                                                
                                                echo'<td align="center"><select name="cmbVive'.$c.'" id="cmbVive'.$c.'" 
                                                onchange="javaScript:viveCon(\'tblVive\','.$alumno[3].',\'cmbVive'.$c.'\')" val="obl" campo="Vive con">';
                                                echo"<option value='-1'>Seleccione</option>";
                                                    $vive="Select distinct(802_identifica.idUsuario),802_identifica.Nombre from 802_identifica,4125_alumPers ";
                                                    $vive.="where 802_identifica.idUsuario=4125_alumPers.idUsuario and 4125_alumPers.idAlumno=".$alumno[3];
                            
                                                    $con->generarOpcionesSelect($vive,$alumno[5]);
                                                    
                                                ?>
                                                <input type="hidden" name="alumno<?php echo $c?>" value="<?php echo $reinsc ?>" id="alumno<?php echo $c?>" />
                                                <input type="hidden" name="nomAlumno<?php echo $c?>" value="<?php echo ($alumno[0]) ?>" id="nomAlumno<?php echo $c?>" />
                                                <input type="hidden" name="idAlumno<?php echo $c?>" value="<?php echo $alumno[3] ?>" id="idAlumno<?php echo $c?>" />
                                                    <tr>
                                                    <td colspan='3' >
                                                    <br />
                                                    <br />
                                                    <fieldset class='framePadre'><legend><b>Relación familiar</b></legend>
                                                    <br />
                                                    <span id='tblRelaciones<?php echo $c?>'></span>
                                                    </fieldset>
                                                    </td>
                                                    <td width="10"></td>
                                                    <td colspan='2' valign="top">
                                                    <br /><br /><br />
                                                        <table width="180" class="tablaMenu" >
                                                            <tr>
                                                            <td colspan="2" class="tituloTabla">
                                                                Acciones
                                                            </td>
                                                            </tr>
                                                            <?php
                                                            
                                                                if($alumno[6]!='106')
                                                                {
                                                            ?>
                                                            <tr>
                                                                <td><a href="fichaMedica.php?IdAlumno=<?php echo $alumno[3]?>" onclick="return lanzarVentana1(' <?php echo ($alumno[0])?>',this.href,'<?php echo $c?>')"><img src='../images/fichaM.png' height='20' border='0' title='Ver Ficha Médica'></a></td>
                                                                <td class="letraFichaRespuesta"><a href="fichaMedica.php?IdAlumno=<?php echo $alumno[3]?>" onclick="return lanzarVentana1(' <?php echo ($alumno[0])?>',this.href,'<?php echo $c?>')">Ver ficha médica del alumno </a></td>
                                                            </tr>
                                                            <?php
                                                                }
                                                            ?>
                                                            <tr>
                                                                <td><a href="verDatos.php?IdAlumno=<?php echo $alumno[3]?>" onclick="return lanzarVentana2('<?php echo ($alumno[0]) ?>',this.href)"><img src='../images/lupa.png' height='25' border='0' title='Ver Datos'></a></td>
                                                                <td class="letraFichaRespuesta"><a href="verDatos.php?IdAlumno=<?php echo $alumno[3]?>" onclick="return lanzarVentana2('<?php echo ($alumno[0]) ?>',this.href)">Ver datos del alumno</a></td>
                                                            </tr>
                                                            
                                                            <tr>
                                                            <?php
                                                                 if($alumno[6]!='106')
                                                                {
                                                             ?>
                                                                   <!-- <tr>
                                                                        <td><a href="verDocumentosGuardadosAlumno.php?IdAlumno=<?php echo $alumno[3]?>" onclick="return lanzarVentana4(' <?php echo ($alumno[0])?>',this.href,'<?php echo $c?>')"><img src='../images/tabs_48.png' height='20' border='0' title='Ver documentos del alumno'></a></td>
                                                                        <td class="letraFichaRespuesta"><a href="verDocumentosGuardadosAlumno.php?IdAlumno=<?php echo $alumno[3]?>" onclick="return lanzarVentana4(' <?php echo ($alumno[0])?>',this.href,'<?php echo $c?>')">Ver documentos del alumno </a></td>
                                                                    </tr>-->
                                                             <?php
                                                                 }
																 else
																 {
															?>
                                                            	<tr>
                                                                        <td>&nbsp;<a href="verDocumentosSolicitadosAlumno.php?IdAlumno=<?php echo $alumno[3]?>" onclick="return lanzarVentana5(' <?php echo ($alumno[0])?>',this.href,'<?php echo $c?>')"><img src='../images/app_48.png' height='20' border='0' title='Ver documentos solicitados'></a></td>
                                                                        <td class="letraFichaRespuesta"><a href="verDocumentosSolicitadosAlumno.php?IdAlumno=<?php echo $alumno[3]?>" onclick="return lanzarVentana5(' <?php echo ($alumno[0])?>',this.href,'<?php echo $c?>')">Ver documentos solicitados </a></td>
                                                                    </tr>
                                                            <?php
																 }
                                                                ?>
                                                                <?php
                                                                    if($alumno[6]!='106')
                                                                    {
                                                                        if($sigProg=="-")//Ya va a salir
                                                                            echo'<td align="center">&nbsp;</td><td></td>';
                                                                        if($reinsc==0)
                                                                            echo'<td align="center" id="td'.$c.'"><a href="javaScript:guardaReinscritos('.$alumno[3].',\'hGrado'.$c.'\',\'hProg'.$c.'\',\'Reinscribir'.$c.'\',\''.$c.'\')" id="Reinscribir'.$c.',\''.$c.'\'">
																				<img src="../images/edit_f2.png" height="20" border="0" title="Reinscribir Alumno" id="img'.$c.'" ></a></td>
																				<td class="letraFichaRespuesta10">Estado Alumno:<br><label id="lblEstado'.$c.'">
																				<a href="javaScript:guardaReinscritos('.$alumno[3].',\'hGrado'.$c.'\',\'hProg'.$c.'\',\'Reinscribir'.$c.'\',\''.$c.'\')" id="Reinscribir'.$c.'">
																				<font color="red"><b>Sin Reinscribir</b></font></a></label></td>';
                                                                        else
                                                                            echo"<td align='center' ><img src='../images/publish_f2.png' height='20' border='0' title='Estado Alumno: Reinscrito'></a></td>
																				<td ><label id='lblEstado' class='letraFichaRespuesta10' >Estado Alumno:<font color='green'><b><br>Reinscrito</b></font></label></td>";		 
                                                                    }
                                                                    else
                                                                    {
                                                                        echo"<td align='center'><img src='../images/publish_f2.png' height='20' border='0' title='Estado Alumno: Nuevo Ingreso'></a></td>
																			<td ><label id='lblEstado' class='letraFichaRespuesta10'>Estado Alumno:<font color='blue'><b><br>Nuevo Ingreso</b></font></label></td>";		 	
                                                                    }
                                                                ?>
                                                                
                                                                
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    </tr>
                                                <?php
                                                $consultaR="select IdReAlPers,i.Nombre,IdParentezco from 802_identifica i,4125_alumPers au where i.idUsuario=au.idUsuario and idAlumno=".$alumno[3];
                                                $filasR=$con->obtenerFilas($consultaR);
                                                $arrRelaciones="";
                                                $contenido="";
                                                while($f=mysql_fetch_row($filasR))
                                                {
                            
                                                    $contenido="['".$f[0]."','".($f[1])."','".$f[2]."']";
                                                    if($arrRelaciones=="")
                                                        $arrRelaciones=$contenido;
                                                    else
                                                        $arrRelaciones.=",".$contenido;
                                                }
                                                echo 	"<script langueja='javascript'>arrRelaciones[".$c."]=[".$arrRelaciones."]</script>";
                                                echo "<select id='cmbRelaciones".$c."' style='display:none'>";
                            
                                            $consultaR="select IdRelacion,Tipo from 4115_parentezco";
                                            $fRel=$con->obtenerFilas($consultaR);
                                            while($f=mysql_fetch_row($fRel))
                                            {
                                                echo "<option value='".$f[0]."'>".$f[1]."</option>";
                                            }
                                            
                                                echo '</select>';
                                                echo "</table><br><br>";
                                            }
                                            echo "</td></tr>";
                                           ?>
                                        
                                        
                                        <input  type="hidden"  name="hNumAlumnos" id="hNumAlumnos"  value="<?php echo $numAlumnos?>" />
                                        <input type="hidden" name="idUsuarioActual" id="idUsuarioActual" value="<?php echo $_SESSION["idUsr"]?>" />
                                        
                                        </table>
                                        </fieldset>	
                                    </td>
                                </tr>
                                
                                
                                
                                </table>
                            
                                <center><br>
                                <table width='600' border='0' cellspacing='1' cellpadding='1' align='center'>
                                    <tr>
                                        <td align="left">
                                        </td>
                                        <td align='center'><b><font color="green" size="-1">Para registrar un nuevo aspirante, dé click 
                                        <a href='nuevoAspirante.php' title='Nuevo ingreso' onClick="return nuevoAspirante(this.href)"><font size="2"><font color="#FF0000">AQU&Iacute; </font></a></b></font></td>
                                        <td align="right"></td>
                                    </tr>
                                </table>
                            </td>
                            <!--<td width="20%" valign="top">
                                <table>
                                <tr>
                                <td width="10">&nbsp;</td>
                                <td>
                                    <table width="180" class="tablaMenu">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><a href="javaScript:GuardarDatos('reinscripcion')"> <img src="../images/floppy_disk_48.png" title="Actualizar Datos" border="0" width="16"/></a></td>
                                        <td><a href="javaScript:GuardarDatos('reinscripcion')"><span style="font-size:14px"><b>Guardar datos</b></span></a></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><br /><a href='javascript:cerrarSesion()' title='Cerrar Sesión' ><img src="../images/Exit.png" title="Cerrar Sesión"/></a></td>
                                        <td><br><a href='javascript:cerrarSesion()' title='Cerrar Sesión' ><span style="font-size:14px"><b>Cerrar Sesión </b></span> </a></td>
                                    </tr>
                                    
                                    </table>
                                </td>
                                </tr>
                                </table>
                                    
                            </td>-->
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
