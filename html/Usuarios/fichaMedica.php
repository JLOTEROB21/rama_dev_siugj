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
<?php
	$paramGET=true;
	$guardarConfSession=true;
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
<?php
$mostrarRegresar=false;
$mostrarRegresarBajo=false;
$mostrarMenuNivel1=false;
$mostrarMenuNivel2=false;
$mostrarMenuIzq=false;
$mostrarTitulo=false;
?>
<script type='text/javascript' src='Scripts/fichaMedica.js'></script>
<script type='text/javascript' src='Scripts/medicos.js'></script>
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
                   <?php
					$IdUsuario=$_SESSION["idUsr"];
					$IdAlumno=$objParametros->idAlumno;
					$consulta="select  802_identifica.idUsuario,CONCAT(Paterno,' ',Materno,', ',Nom) from 802_identifica,4125_alumPers a where 
					802_identifica.idUsuario=a.IdAlumno and a.idUsuario in (select idUsuario from 4125_alumPers where idAlumno=".$IdAlumno.") and a.idAlumno<>".$IdAlumno;				
					
					$ct=0;
					$resAlumnos=$con->obtenerFilas($consulta);
					$objGrupo="";
					$arrGrupos="";
					while($filaGrupos=mysql_fetch_row($resAlumnos))
					{
						$objGrupo="['".$filaGrupos[0]."','".uE($filaGrupos[1])."',false]";	
						if($arrGrupos=="")
							$arrGrupos=$objGrupo;
						else
							$arrGrupos.=",".$objGrupo;
						$ct++;
					}
					
					echo 	"<script>
								var dsAlumnos=[".$arrGrupos."];
							</script>";
					?>
                   <tr>
                        <td>
                          <form id="ficha" name="ficha" method='post'>
                          <table width="100%" border="0" cellspacing="1" cellpadding="1" align="center">
                          	<tr>
                          		<td width="100%">
                                  <fieldset class="frameHijo" ><legend><b>FICHA MÉDICA</b></legend>
                                  <table width="100%" border="0">
                                      <tr><?php $ficha=$con->obtenerPrimeraFila("select * from 4120_fichaMedica where IdAlumno=".$IdAlumno);?>
                                          <td width="450" valign="top">
                                              <label>Grupo Sangu&iacute;neo (RH):</label>
                                          </td>
                                          <td><label></label><?php echo "<input type='hidden' name='IdAlumno' id='IdAlumno' value='".$IdAlumno."'>"; ?></td>
                                          <td><select name="cmbSangre" id="cmbSangre" style='width:190px' val='obl' campo='Tipo Sanguíneo'>
                                            <?php
                                            //$selAB="";$selAB1="";$selA="";$selA1="";$selB="";$selB1="";$selO="";$selO1="";
                                            ($ficha[1]=="AB+"?$selAB="selected":$selAB="");
                                            ($ficha[1]=="AB-"?$selAB1="selected":$selAB1="");
                                            ($ficha[1]=="A+"?$selA="selected":$selA="");
                                            ($ficha[1]=="A-"?$selA1="selected":$selA1="");
                                            ($ficha[1]=="B+"?$selB="selected":$selB="");
                                            ($ficha[1]=="B-"?$selB1="selected":$selB1="");
                                            ($ficha[1]=="O+"?$selO="selected":$selO="");
                                            ($ficha[1]=="O-"?$selO1="selected":$selO1="");
                                            ?>
                                            <option value="AB+"<?php echo $selAB;?>>AB+</option>
                                            <option value="AB-" <?php echo $selAB1;?>>AB-</option>
                                            <option value="A+"<?php echo $selA;?>>A+</option>
                                            <option value="A-"<?php echo $selA1;?>>A-</option>
                                            <option value="B+"<?php echo $selB;?>>B+</option>
                                            <option value="B-"<?php echo $selB1;?>>B-</option>
                                            <option value="O+"<?php echo $selO;?>>O+</option>
                                            <option value="O-"<?php echo $selO1;?>>O-</option>
                                            </select>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td valign="top"><label >Enfermedades que padece el alumno:</label></td>
                                          <td></td>
                                          <td><label for='Aler'>
                                            <textarea name="cmbEnfermedades" id="cmbEnfermedades" val="txt" campo="Enfermedades" cols="34"><?php echo $con->obtenerValor("SELECT Enfermedad FROM 4119_enfermedades WHERE IdAlumno=".$IdAlumno);?></textarea> 
                                            </label>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td valign="top"><label >Medicamentos a los que el alumno es alérgico:</label></td>
                                          <td width="29" ></td>
                                          <td width="165" >
                                          <label>
                                              <textarea name="cmbMedicamentos" id="cmbMedicamentos" val="txt" campo="Medicamentos" cols="34"><?php echo $con->obtenerValor("SELECT Medicamento FROM 4121_medicamentos WHERE IdAlumno=".$IdAlumno);?></textarea> 
                                          </label>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td valign="top"><label for='Aler'>Alimentos o productos  a los que el alumno es al&eacute;rgico:</label></td>
                                          <td ></td>
                                          <td ><label>
                                              <textarea name="cmbAlimentos" id="cmbAlimentos" val="txt" campo="Alimentos" cols="34"><?php echo $con->obtenerValor("SELECT Alimento FROM 4117_alimentos WHERE IdAlumno=".$IdAlumno);?></textarea>
                                              </label>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td valign="top"><label>Otras alergias: </label></td>
                                          <td>&nbsp;</td>
                                          <td><label>
                                          <textarea name="Alergias" id="Alergias" val="txt" campo="Alergias" cols="34"><?php echo $ficha[2];?></textarea>
                                           
                                          </label>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td valign="top"><label>&nbsp;&iquest;Padecimiento f&iacute;sico que le impida realizar alguna actividad f&iacute;sica?</label> </td>
                                          <td ></td>
                                          <td ><textArea name="Padecimiento" id="Padecimiento"  val="txt" campo="Padecimiento" cols="34" rows="2"><?php echo $ficha[3];?></textArea></td>
                                      </tr>
                                      <tr>
                                          <td colspan="3" align='center'>&nbsp;</td>
                                      </tr>
                                      <tr>
                                          <td colspan="3" align='center'><label><b>FAVOR DE AFIRMAR LOS MEDICAMENTOS AUTORIZADOS</label> </td>
                                      </tr>
                                      <tr>
                                          <td colspan="3"><br />
                                              <table width="100%" border="0">
                                              <?php
                                                  $co=0;
                                                  $med=$con->obtenerFilas( "SELECT IdMedicina FROM 4124_alumMedAutorizadas WHERE IdAlumno=".$IdAlumno);
                                                  while ( $rowMes = mysql_fetch_row ( $med ) )
                                                  {
                                                      $co++;
                                                      $medicamento[$co]=$rowMes[0];
                                                  }
                                                  
                                                  $sql="SELECT * FROM 4114_medicinasAutorizadas";
                                                  $result = $con->obtenerFilas ( $sql);
                                                  $noRegistros=mysql_num_rows($result);
                                                  $c=1;
                                                  $cont=0;
                                                  $ch="";
                                                  while ( $row = mysql_fetch_row ( $result ) )
                                                  {
                                                      $cont++;
                                                      for($m=1; $m<=$co; $m++)
                                                      {
                                                          if($row[0]==$medicamento[$m])
                                                          {
                                                              $ch="checked";
                                                              break;
                                                          }
                                                          else
                                                              $ch="";
                                                      }
                                          
                                                      if($c==1)
                                                      {
                                                          echo"<tr><td width='25%'><label>";
                                                          echo"<input type='checkbox' name='chkMed".$cont."' id='chkMed".$cont."' value='".$row[0]."' ".$ch.">&nbsp;".uE($row[1])."</label></td><td></td>";
                                                      }
                                                      else
                                                      {
                                                          if($c==2)
                                                          {
                                                              echo "<td width='25%'><label><input type='checkbox' name='chkMed".$cont."' id='chkMed".$cont."' value='".$row[0]."' ".$ch.">&nbsp;".uE($row[1])."</label></td>";
                                                          }
                                                          else
                                                              if($c==3)
                                                              {
                                                                  echo "<td width='25%'><label><input type='checkbox' name='chkMed".$cont."' id='chkMed".$cont."' value='".$row[0]."' ".$ch.">&nbsp;".uE($row[1])."</label></td>";
                                                              }
                                                              else
                                                              {
                                                                  echo "<td width='25%'><label><input type='checkbox' name='chkMed".$cont."' id='chkMed".$cont."' value='".$row[0]."' ".$ch.">&nbsp;".uE($row[1])."</label></td>
                                                               </tr>";
                                                                  $c=0;
                                                              }
                                                      }
                                                      //}
                                                      $c++;
                                                  }
                                              ?>
                                              </table>
                                          </td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td><td>&nbsp</td><td>&nbsp</td>
                                      </tr>
                                      <tr>
                                        <td ><label for='Aler'>Recomendaciones espec&iacute;ficas:</label></td>
                                        <td ></td>
                                        <td ></td>
                                      </tr>
                                      <tr>
                                        <td colspan="3" >
                                          <table width="100%" border="0">
                                              <tr>
                                                  <td>
                                                      <textarea name="Recomendaciones" id="Recomendaciones" val="txt" campo="Recomendaciones" rows="3" cols="110" wrap="virtual"><?php echo uE($ficha[5]);?></textarea>
                                                  </td>
                                                  <td align="right" valign="top">
                                                      <a href="javaScript:Guardar(<?php echo $noRegistros.",'ficha'"; ?>)" id='Guardar'><img src="../images/publish_f2.png" border="no" title="Guardar" /><b>Guardar </a>
                                                  </td>
                                              </tr>
                                          </table>
                                        </td>
                                      </tr>
                                  </table>
                                  </fieldset>	
                        		</td>
                      		</tr>
                    	  </table>
                    		<br />
                    
                    		<br />
                         <table width="100%" border="0" cellspacing="1" cellpadding="1" align="center">
                            <tr>
                              	<td width="100%">
                                  <fieldset class="frameHijo">
                                  <legend><b>MÉDICOS FAMILIARES</legend>
                                  <center>
                                  <table width="700" border="0" cellspacing="1" cellpadding="1" id="tblMedicos" >
                                   	<tr height="25">
                                  		<td align="right" colspan="4">
                                      		<label><span style="font-size:11px"><b>Para agregar un nuevo médico familiar, dé  click </b></span> </label><span style="font-size:11px"><a href='javaScript:agregarMedico(<?php echo $IdAlumno.",".$noRegistros; ?>)' id='Medicos' title="Agregar Médico"><font color="#FF0000"><b>AQUÍ</b></font></a></span>
                                  		</td>
                                  		<td width="20">
                                  		</td>
                                  
                                  	</tr>
                                  	<tr height="25">
                                      	<td align="right" colspan="4">
                                      		<label><span style="font-size:11px"><b>Para agregar un m&eacute;dico asociado con un alumno relacionado con el actual, dé  click </b></span> </label><span style="font-size:11px"><a href='javaScript:agregarMedicoAsociado(<?php echo $IdAlumno?>)' id='Medicos' alt="Agregar médico asociado con otro alumno" title="Agregar médico asociado con otro alumno"><font color="#FF0000"><b>AQUÍ</b></font></a></span>
                                      		<br /><br /><br />
                                  		</td>
                                  	</tr>
                                  	<tr>
                                  		<td class="tituloTabla" width="250">Nombre</td>
                                        <td class="tituloTabla" width="260">Dirección</td>
                                        <td class="tituloTabla"  width="150">Teléfono</td>
                                        <td width="80" class="tituloTabla"></td>
                                    </tr>
										<?php
                                        $consulta="select m.Nombre,m.Direccion,m.Telefono,ma.idMedAlu,m.IdMedico from 4122_medicos m,4126_medicAlum ma where m.IdMedico=ma.IdMedico and ma.IdAlumno=".$IdAlumno;
                                        $res=$con->obtenerFilas($consulta);
                                        $clase="filaBlanca10";
                                        while($fila=mysql_fetch_row($res))
                                        {
                                            echo "	<tr id='filaM_".$fila[3]."'>
                                                    <td align='left' valign='top' class='".$clase."'>".uE($fila[0])."</td>
                                                    <td align='left' valign='top'  class='".$clase."'>".uE($fila[1])."</td>
                                                    <td align='left' valign='top'  class='".$clase."'>".uE($fila[2])."</td>
                                                    <td align='center' valign='top'  class='".$clase."'>
                                                    <a href=\"javascript:modificarMedico(".$fila[4].")\"><img src='../images/update_nw.gif' title='Modificar' alt='Modificar'></a>&nbsp;
                                                    <a href=\"javascript:quitarMedico('".$fila[3]."',".$noRegistros.")\"><img src='../images/unpublish_f2.png' border=0 title='Quitar médico' height='15'></a>
                                                    </td>
                                                    </tr>";
                                            if($clase=="filaBlanca10")
                                                $clase="filaRosa10";
                                            else
                                                $clase="filaBlanca10";
                                        } 
                                        ?>
                                  </table>
                                  </center>
                                  </fieldset>
                                </td>
                            </tr>
                         </table>
                         <input type="hidden" name="idAlumno" id="idAlumno" value="<?php echo $IdAlumno?>" />
                         <input type="hidden" name="idTabla" id="idTabla" value="<?php echo $_GET["numA"] ?>" />
                         </form>
                         <script language="javascript">
                         function guardar()
                         {
                             Guardar(<?php echo $noRegistros.",'ficha'"; ?>);
                         }
                         </script>
                        	
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
