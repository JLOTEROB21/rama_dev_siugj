<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");
$excluirExt=true;

function  construirTablaPonderacion($padre,$titulo=false)
{
	global $con;
	global $idProceso;
	global $filaProceso;
	$consulta="select * from 9003_elementosConfConvocatoria where padre='".$padre."'";
	$resP=$con->obtenerFilas($consulta);
	if($con->filasAfectadas==0)
		return;
	?>
    <table>
    <?php
		if($titulo)
		{
	?>
    		<tr>
              <td class="copyrigthSinPadding" align="center" width="40">Puntos</td>
              <td class="copyrigthSinPadding" align="center" width="80">Conjunción</td>
			  <td class="copyrigthSinPadding" align="center" width="200">
              	Actores 
              </td>	
            </tr>
    <?php
		}
		while($filaP=mysql_fetch_row($resP))
		{
			$idPts=$padre."_".$filaP[0]."_pts";
			$idCon=$padre."_".$filaP[0]."_conj";
			$consulta="select valor from 9006_valorElementosConvocatoria where idElemento='".$idPts."'";
			$vPts=$con->obtenerValor($consulta);
			if($vPts=="")
				$vPts=0;
			$consulta="select valor from 9006_valorElementosConvocatoria where idElemento='".$idCon."'";
			$vCon=$con->obtenerValor($consulta);
			if($vCon=="1")
				$vCon="checked='checked'";
			else
				$vCon="";
			
			
			
			$idMMC=$padre."_".$filaP[0]."_MMC";
			$consulta="select valor from 9006_valorElementosConvocatoria where idElemento='".$idMMC."'";
			$valorMMC=$con->obtenerValor($consulta);
			if($valorMMC=="")
				$valorMMC=0;
			
			$idMMNC=$padre."_".$filaP[0]."_MMNC";
			$consulta="select valor from 9006_valorElementosConvocatoria where idElemento='".$idMMNC."'";
			$valorMMNC=$con->obtenerValor($consulta);
			if($valorMMNC=="")
				$valorMMNC=0;
			
			$idOC=$padre."_".$filaP[0]."_OC";
			$consulta="select valor from 9006_valorElementosConvocatoria where idElemento='".$idOC."'";
			$valorOtroC=$con->obtenerValor($consulta);
			if($valorOtroC=="")
				$valorOtroC=0;
			$idONC=$padre."_".$filaP[0]."_ONC";			
			$consulta="select valor from 9006_valorElementosConvocatoria where idElemento='".$idONC."'";
			$valorOtroNC=$con->obtenerValor($consulta);
			if($valorOtroNC=="")
				$valorOtroNC=0;
	?>
    		<tr>
            	<td align="center" width="40">
                	<input type="text" value="<?php echo $vPts ?>" id="<?php echo $idPts ?>" size="3" onKeyPress="return soloNumero(event,true,false,this)" onBlur="guardarPonderacion(this)" />
                </td>
                <td align="center" width="80">
                	<input type="checkbox" <?php echo $vCon ?> id="<?php echo $idCon ?>" onClick="guardarConjuncion(this)"  />
                </td>
                <td align="right">
                	<a href="javascript:agregarInv('<?php echo $padre."_".$filaP[0] ?>')"><img src="../images/verMas.gif" title="Agregar Nivel Investigador" border="Agregar Nivel Investigador" /></a>
                	<table width="100%">
                    <?php
					$consulta="select idElemento,valor,complementario from 9006_valorElementosConvocatoria where idElemento like '".$padre."_".$filaP[0]."_inv%'";
					$resInvC=$con->obtenerFilas($consulta);
					while($filaInv=mysql_fetch_row($resInvC))
					{
						$iEInv=$filaInv[2];
						$arrValores=explode('_',$iEInv);

						
						if($arrValores[1]=="1")
							$situacion="calif";
						else
							$situacion="no calif";
						$query="select abreviatura from 9007_nivelInvestigador where idNivelInsvestigador=".$arrValores[0];
						$abreviatura=$con->obtenerValor($query);
						$abreviatura.=" ".$situacion;
						
					?>
                    	<tr>
                    	<td>
                        <span class="corpo7Simple">
                        <?php
							echo $abreviatura;
						?>	
                        </span>
                        </td>
                        <td>
                        	<input type="text" value="<?php echo $filaInv[1] ?>" id="<?php echo $filaInv[0] ?>" size="3" onKeyPress="return soloNumero(event,true,false,this)" onBlur="guardarPonderacion(this)" />
                        </td>
                    </tr>
                    <?php
					}
					
					if($filaProceso[4]=="1")
					{
					?>
                    <tr>
                    	<td>
                        <span class="corpo7Simple">
                        Mando medio calif.
                        </span>
                        </td>
                        <td>
                        	<input type="text" value="<?php echo $valorMMC ?>" id="<?php echo $idMMC ?>" size="3" onKeyPress="return soloNumero(event,true,false,this)" onBlur="guardarPonderacion(this)" />
                        </td>
                    </tr>
                    <?php
					}
					?>
                    <?php
					if($filaProceso[5]=="1")
					{
					?>
                    <tr>
                    	<td>
                        <span class="corpo7Simple">
                        Mando medio no calif.
                        </span>
                        </td>
                        <td>
                        	<input type="text" value="<?php echo $valorMMNC ?>" id="<?php echo $idMMNC ?>" size="3" onKeyPress="return soloNumero(event,true,false,this)" onBlur="guardarPonderacion(this)" />
                        </td>
                    </tr>
                    <?php
					}
					?>
                    <?php
					if($filaProceso[6]=="1")
					{
					?>
                    <tr>
                    	<td>
                        <span class="corpo7Simple">
                        Otro calif.
                        </span>
                        </td>
                        <td>
                        	<input type="text" value="<?php echo $valorOtroC ?>" id="<?php echo $idOC ?>" size="3" onKeyPress="return soloNumero(event,true,false,this)" onBlur="guardarPonderacion(this)" />
                        </td>
                    </tr>
                    <?php
					}
					?>
                    <?php
					if($filaProceso[7]=="1")
					{
					?>
                    <tr>
                    	<td>
                        <span class="corpo7Simple">
                        Otro no calif.
                        </span>
                        </td>
                        <td>
                        	<input type="text" value="<?php echo $valorOtroNC ?>" id="<?php echo $idONC ?>" size="3" onKeyPress="return soloNumero(event,true,false,this)" onBlur="guardarPonderacion(this)" />
                        </td>
                    </tr>
                    <?php
					}
					?>
                    </table>
                </td>
                
            </tr>
    <?php
		}
	?>
    </table>
    <?php
	
	
}


function construirTablaParticipacion($padre,$filaConf)
{
	global $con;
	$consulta="select * from 9003_elementosConfConvocatoria where padre='".$padre."'";
	$resP=$con->obtenerFilas($consulta);
?>
	<table>
    	<tr>
            <td>
            	<br />
            	<table>
                <tr>
                	<td class="copyrigthVerde" width=""><span >Participación</span> <a href="javascript:agregarParticipacion('<?php echo $padre ?>','<?php echo $filaConf[7]?>')"><img  src="../images/add.png" title='Agregar participación' alt="Agregar participación"/></a></td>
                     <td rowspan="<?php echo $con->filasAfectadas+1?>">
					<?php 	
                            if($filaConf[5]=="0")
                            {
                                construirTablaPonderacion($padre,true);
                            }
                    
                    ?>
                    </td>
                    
                </tr>
                <tr>
                <td>
                	<table>
                    
        <?php
            while($filaP=mysql_fetch_row($resP))
            {
        ?>
            <tr>
                <td valign="top" align="left">
                <span class="corpo8_bold">
            <?php
				$consulta="select descParticipacion from 953_elementosPerfilesParticipacionAutor where idElementoPerfilAutor=".$filaP[2];
				echo $con->obtenerValor($consulta);
            ?>
            </span>
                </td>
                <td>
               <?php
					if($filaConf[5]!="-1")//Estado
					{
						construirTablaNivel("eN_".$filaP[0],$filaConf);	
					}
                    
				?>
                </td>
            </tr>
        <?php
            }
    ?>	
    			</table>
    		</td>
     		</tr>
		    </table>
		</td>
	</tr>
	</table>           
                  
<?php
	
}

function construirTablaTipo($padre,$filaConf)
{
	global $con;
	$consulta="select * from 9003_elementosConfConvocatoria where padre='".$padre."'";
	$resT=$con->obtenerFilas($consulta);
	
?>
	<table>
    	<tr>
            <td>
            	<br />
            	<table>
                <tr>
                <td class="copyrigthVerde" valign="top"><span >Clasificación <a href="javascript:agregarTipo('<?php echo $padre ?>','<?php echo $filaConf[3]?>')"><img  src="../images/add.png" title='Agregar clasificación' alt="Agregar clasificación"/></a></span></td><td width="10"></td>
                <td rowspan="<?php echo $con->filasAfectadas+1?>">
				<?php 	
						if(($filaConf[6]=="0")&&($filaConf[5]=="0"))
						{
							construirTablaPonderacion($padre,true);
						}
				
				?>
                </td>
                </tr>
        <?php
			
            while($filaT=mysql_fetch_row($resT))
            {
        ?>
            <tr>
                <td valign="top" align="left">
                <span class="corpo8_bold">
            <?php
                echo obtenerValorControlFormulario($filaConf[3],$filaT[2]);
            ?>
            </span>
                </td>
                <td>
               <?php
			   if($filaConf[6]!="0")//Particiapcion
               {
               		construirTablaParticipacion("et_".$filaT[0],$filaConf);
               }
			   else
                	if($filaConf[5]!="-1")//Estado
					{
						construirTablaNivel("et_".$filaT[0],$filaConf);
					}
                   
				?>
                </td>
                
                
            </tr>
        <?php
				
            }

		?>
    		</table>
    	</td>
        
        	
        
     </tr>
    
    </table>
<?php
}

function construirTablaNivel($padre,$filaConf)
{
	global $con;
	$consulta="select * from 9003_elementosConfConvocatoria where padre='".$padre."'";
	$resT=$con->obtenerFilas($consulta);
	
?>
	<table>
    	<tr>
            <td>
            	<br />
            	<table width="400">
                <tr>
                <td class="copyrigthVerde" valign="top"><span >Nivel <a href="javascript:agregarNivel('<?php echo $padre ?>','<?php echo $filaConf[5]?>')"><img  src="../images/add.png" title='Agregar nivel' alt="Agregar nivel"/></a></span></td><td width="10"></td>
                <td rowspan="<?php echo $con->filasAfectadas+1?>">
				<?php 	
				construirTablaPonderacion($padre,true);
					?>
                </td>
                </tr>
        <?php
			$ponderacion=false;
            while($filaT=mysql_fetch_row($resT))
            {
        ?>
            <tr>
                <td valign="top" align="left">
                <span class="corpo8_bold">
            <?php
                echo obtenerValorControlFormulario($filaConf[5],$filaT[2]);
            ?>
            </span>
                </td>
                <td>
                </td>
            </tr>
        <?php
				
            }

		?>
    		</table>
    	</td>
     </tr>
    </table>
<?php
}

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
<script >
	var Ext=window.parent.Ext;
</script>
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
								$idProceso=-1;
								if(isset($objParametros->idProceso))
									$idProceso=$objParametros->idProceso;
								$consulta="select * from 9000_procesoConvocatorias where idProceso=".$idProceso;
								$filaProceso=$con->obtenerPrimeraFila($consulta);
								$invC=$filaProceso[2];
								$invNC=$filaProceso[3];
							?>	
  								<script type="text/javascript" src="Scripts/configuracionConvocatoria.js.php?proc=<?php echo  base64_encode($idProceso)?>"></script>
                                <script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
                        		<span id="divEscenario" >
                                <table width="100%" >
                                <tr>
                                    <td width="30">
                                    </td>
                                    <td align="left">
                                        <span class="letraFicha" ><br />
                                        <b>
                                        Reglas de la convocatoria:
                                        </b>
                                        </span>
                                        <br /><br />
                                        
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td bgcolor="" class="" ></td>
                                    <td align="center"><br />
                                    	<table >
                                        <tr>
                                        	<td>
                                           <label>
                                            Periodo de fechas considerado:
                                            
                                            </label>
                                            <br /><br />
                                            </td>
                                            <td>
                                            <span class="copyrigthSinPadding">
                                            <?php
												$consulta="select fechaInicio,fechaFin from 9000_procesoConvocatorias where idProceso=".$idProceso;
												
												$fila=$con->obtenerPrimeraFila($consulta);
												if($fila[0]=="")
												{
											?>
                                            	
                                            	No especificado a&uacute;n
                                            <?php
												}
												else
												{
													echo "<b>De</b> ".date("d/m/Y",strtotime($fila[0]))." <b>a</b> ".date("d/m/Y",strtotime($fila[1]));
												}
											?>
                                            </span>&nbsp;<a href="javascript:agregarAnio()"><img src="../images/calendar_add.png" title="Especificar periodo de convocatoria" alt="Especificar periodo de convocatoria" /></a>
                                            <br /><br />
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td width="200" align="center" style="background:url(../images/fondo_barra_mc_azul.gif)"><span class="corpo8_bold" >Elemento</span></td>
                                            <td width="570" align="center" style="background:url(../images/fondo_barra_mc_azul.gif)"><span class="corpo8_bold"></span></td>
                                        </tr>
                                        <?php 
											$consulta="select ep.idElementoConvocatoria,p.nombre,ep.idConfiguracion from 9001_elementosProceso ep,4001_procesos p  where p.idProceso=ep.idElemento and ep.idProceso=".$idProceso." and ep.idConfiguracion is not null";
											
											$resP=$con->obtenerFilas($consulta);	
											while($filaP=mysql_fetch_row($resP))
											{
												$consulta="select * from 9002_confElementoConvocatoria where idConfElemento=".$filaP[2];
												$filaConf=$con->obtenerPrimeraFila($consulta);
												
										?>
                                        <tr>
                                        	<td colspan="2" class="etiquetaFicha" align="left" valign="top">
                                            <span class="letraRojaSubrayada8">
                                            <?php echo $filaP[1]?>
                                            </span>
                                            
                                            </td>
                                       </tr>
                                       <tr>
                                            <td class="etiquetaFicha" align="left" colspan="2">
                                            <?php
												
													if($filaConf[3]!="-1")
													{
															construirTablaTipo("eC_".$filaConf[0],$filaConf);
													}
													else
														if($filaConf[6]!="0")
														{
															construirTablaParticipacion("eC_".$filaConf[0],$filaConf);
														}
														else
															if($filaConf[5]!="-1")
															{
																construirTablaNivel("eC_".$filaConf[0],$filaConf);	
															}
											?>
                                            </td>
                                            
                                        </tr>
                                        <?php
                                        	}
                                        ?>
                                        </table>
                                        <input type="hidden" id="idProceso" value="<?php echo $idProceso?>" />
                                        <input type="hidden" id="invC" value="<?php echo $invC?>" />
                                        <input type="hidden" id="invNC" value="<?php echo $invNC?>" />
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
