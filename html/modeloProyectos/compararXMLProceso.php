<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");

$consulta="SELECT campoMysql FROM 9017_camposControlFormulario";
$arrCamposControl=$con->obtenerFilasArreglo1D($consulta);

function getElementsByTagNameListNode($listNode,$tag)
{
	$x=0;
	$arrNodes=array();
	for($x=0;$x<$listNode->childNodes->length;$x++)
	{
		$nodo=$listNode->childNodes->item($x);
		if($nodo->nodeName==$tag)					
			array_push($arrNodes,$nodo);
	}
	return $arrNodes;
}

function getElementsByTagNameArrayNode($listNode,$tag)
{
	$x=0;
	$arrNodes=array();
	foreach($listNode as $nodo)
	{
		if($nodo->nodeName==$tag)					
			array_push($arrNodes,$nodo);
	}
	return $arrNodes;
}

function obtenerCamposRegistro($tabla)
{
	global $arrCamposControl;
	$arrCampos=array();
	$x=0;
	for($x1=0;$x1<$tabla->childNodes->length;$x1++)
	{
		$campo=$tabla->childNodes->item($x1);
		if(!existeValor($arrCamposControl,$campo->nodeName))
		{
			$arrCampos[$x]["campo"]=$campo->nodeName;
			$arrCampos[$x]["valor"]=$campo->nodeValue;
			$x++;
		}
	}
	return $arrCampos;
}

function obtenerRegistrosTabla($tabla)
{
	$arrCampos=array();
	$x=0;
	for($x1=0;$x1<$tabla->childNodes->length;$x1++)
	{
		$campo=$tabla->childNodes->item($x1);
		$arrCampos[$x]["registro"]=$campo->nodeName;
		$arrCampos[$x]["valoresCampos"]=obtenerCamposRegistro($campo);
		$x++;
	}
	return $arrCampos;
}

function compararTablas($sTabla1,$sTabla2,$col=0)//0 Derecha; 1 izquierda
{
	$cadTemp="";
	$anchoCeldaCampo="300";
	
	global $version1;
	global $version2;
	for($x1=0;$x1<$sTabla1->childNodes->length;$x1++)
	{
		$filaTmp="";
		$tabla=$sTabla1->childNodes->item($x1);
		$nTabla=$tabla->nodeName;
		$nSeccion=$tabla->attributes->getNamedItem ("tituloTabla")->nodeValue;
		$arrTabla=getElementsByTagNameListNode($sTabla2,$nTabla); 
		if(sizeof($arrTabla)>0)
		{
			$tabla2=$arrTabla[0];
			$arrRegistros=obtenerRegistrosTabla($tabla);
			$arrRegistros2=obtenerRegistrosTabla($tabla2);
			$nRegistros1=sizeof($arrRegistros);
			$nRegistros2=sizeof($arrRegistros2);
			for($x=0;$x<$nRegistros1;$x++)
			{
				$tblCampo=$arrRegistros[$x];
				$posCampo=existeValorMatriz($arrRegistros2,$tblCampo["registro"],"registro");
				
				if($posCampo=="-1")
				{
					$filaTmp.=		"<tr height='23'>
										<td width='100'>
											<span class='letraRojaSubrayada8'></span>
										</td>
										<td align='left' class='celdaImagenAzul2' width='".$anchoCeldaCampo."'>
											&nbsp;&nbsp;&nbsp;
										</td>
										<td width='".$anchoCeldaCampo."' align='center' class='celdaImagenAzul2'>
										</td>
										
										<td width='130' align='center' class='celdaImagenAzul2'>
											<span class='letraRoja'>Se agreg&oacute; registro en la versi&oacute;n: ".$version1."</span>
										</td>
									</tr>
									<tr height='23'>
											<td>
											</td>
											<td align='left' class='celdaImagenAzul3' width='".$anchoCeldaCampo."' colspan='3'>
												<table>
													<tr height='23'>
														<td align='center' width='200'><b>Campo:</b></td>
														<td align='center' width='490'><b>Valor:</b></td>
													</tr>
												
									
									";
									
					foreach($arrRegistros[$x]["valoresCampos"] as $campo)				
					{
									
						$filaTmp.=		"<tr height='23'>
											
											<td align='left' class='celdaImagenAzul3' >
												 ".$campo["campo"]."
											</td>
											
											<td align='left' class='celdaImagenAzul3'>
												".$campo["valor"]."
											</td>
											
										</tr>
								";
					}
					$filaTmp.="			</table>
									</td>
								</tr>";
				}
				else
				{
					$arrCampos1=$tblCampo["valoresCampos"];
					$nFilas1=sizeof($arrCampos1);
					$arrCampos2=$arrRegistros2[$posCampo]["valoresCampos"];
					$nFilas2=sizeof($arrCampos2);
					$campoTmp="";
					for($x=0;$x<$nFilas1;$x++)
					{
						$tblCampo=$arrCampos1[$x];
						$posCampo=existeValorMatriz($arrCampos2,$tblCampo["campo"],"campo");
						if($posCampo=="-1")
						{
							$filaTmp.=		"<tr height='23'>
												<td width='100'>
													<span class='letraRojaSubrayada8'></span>
												</td>
												<td align='left' class='celdaImagenAzul2' width='".$anchoCeldaCampo."'>
													&nbsp;&nbsp;&nbsp;<img src='../images/flecha_azul_corta.gif'>&nbsp;<span class='letraRoja'><font color=''>".$tblCampo["campo"]."</font></span>
												</td>
												<td width='".$anchoCeldaCampo."' align='center' class='celdaImagenAzul2'>
												</td>
												
												<td width='130' align='center' class='celdaImagenAzul2'>
													<span class='letraRoja'>Se agreg&oacute;</span>
												</td>
											</tr>";
							$filaTmp.=		"<tr height='23'>
												<td width='100'>
													<span class='letraRojaSubrayada8'></span>
												</td>
												<td align='left' class='celdaImagenAzul3' width='".$anchoCeldaCampo."'>
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/bullet_green.png'>&nbsp;<span class='letraRoja'>Valor: ".$tblCampo["valor"]."</span>
												</td>
												<td width='".$anchoCeldaCampo."' align='center' class='celdaImagenAzul3'>
												</td>
												<td width='130' align='center' class='celdaImagenAzul3'>
													<span class='corpo8'></span>
												</td>
											</tr>
									";
						}
						else
						{
							if($tblCampo["valor"]!=$arrCampos2[$posCampo]["valor"])
							{
								$filaTmp.=		"
												<tr height='21'>
													<td width='100'>
														<span class='letraRojaSubrayada8'></span>
													</td>
													<td colspan='3' align='left'>
														<b>Campo: </b><span class='copyri'>".$tblCampo["campo"]."</span>
													</td>
												</tr>
												<tr height='23'>
													<td width='100'>
														<span class='letraRojaSubrayada8'></span>
													</td>
													<td align='center' class='celdaImagenAzul3' width='".$anchoCeldaCampo."'>
														<span class='letraRojaSubrayada8'>Valor versi&oacute;n: ".$version1."</span></span>
													</td>
													<td width='".$anchoCeldaCampo."' align='center' class='celdaImagenAzul3'>
														<span class='letraRojaSubrayada8'><font color=''>Valor versi&oacute;n: ".$version2." </span></span>
													</td>
													<td width='130' align='center' class='celdaImagenAzul3'>
														
													</td>
												</tr>
												<tr height='23'>
													<td width='100'>
														<span class='letraRojaSubrayada8'></span>
													</td>
													<td align='left' class='celdaImagenAzul3' width='".$anchoCeldaCampo."'>
														<span class=''><font color=''>".$tblCampo["valor"]."</font></span>
													</td>
													<td width='".$anchoCeldaCampo."' align='left' class='celdaImagenAzul3'>
														<span class=''><font color=''>".$arrCampos2[$posCampo]["valor"]."</font></span>
													</td>
													<td width='130' align='center' class='celdaImagenAzul3'>
														<span class='corpo8'><font color='#F60'><b>Con diferencia</b></font></span>
													</td>
												</tr>";
							}
						}
					}
					
					for($x=0;$x<$nFilas2;$x++)
					{
						$tblCampo=$arrCampos2[$x];
						$posCampo=existeValorMatriz($arrCampos1,$tblCampo["campo"],"campo");
						if($posCampo=="-1")
						{
							$filaTmp.=		"<tr height='23'>
												<td width='100'>
													<span class='letraRojaSubrayada8'></span>
												</td>
												<td align='left' class='celdaImagenAzul2' width='".$anchoCeldaCampo."'>
													&nbsp;&nbsp;&nbsp;<img src='../images/flecha_azul_corta.gif'>&nbsp;<span class='letraRoja'><font color=''>".$tblCampo["campo"]."</font></span>
												</td>
												<td width='".$anchoCeldaCampo."' align='center' class='celdaImagenAzul2'>
												</td>
												
												<td width='130' align='center' class='celdaImagenAzul2'>
													<span class='letraRoja'>Se elimin&oacute;</span>
												</td>
											</tr>";
							$filaTmp.=		"<tr height='23'>
												<td width='100'>
													<span class='letraRojaSubrayada8'></span>
												</td>
												<td align='left' class='celdaImagenAzul3' width='".$anchoCeldaCampo."'>
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/bullet_green.png'>&nbsp;<span class='letraRoja'>Valor: ".$tblCampo["valor"]."</span>
												</td>
												<td width='".$anchoCeldaCampo."' align='center' class='celdaImagenAzul3'>
												</td>
												<td width='130' align='center' class='celdaImagenAzul3'>
													<span class='corpo8'></span>
												</td>
											</tr>
									";
						}
						
					}
				}
			}
			
			for($x=0;$x<$nRegistros2;$x++)
			{
				$tblCampo=$arrRegistros2[$x];
				$posCampo=existeValorMatriz($arrRegistros,$tblCampo["registro"],"registro");
				
				if($posCampo=="-1")
				{
					$filaTmp.=		"<tr height='23'>
										<td width='100'>
											<span class='letraRojaSubrayada8'></span>
										</td>
										<td align='left' class='celdaImagenAzul2' width='".$anchoCeldaCampo."'>
											&nbsp;&nbsp;&nbsp;
										</td>
										<td width='".$anchoCeldaCampo."' align='center' class='celdaImagenAzul2'>
										</td>
										
										<td width='130' align='center' class='celdaImagenAzul2'>
											<span class='letraRoja'>Se elimin&oacute; registro en la versi&oacute;n:".$version1."</span>
										</td>
									</tr>
									<tr height='23'>
											<td>
											</td>
											<td align='left' class='celdaImagenAzul3' width='".$anchoCeldaCampo."' colspan='3'>
												<table>
													<tr height='23'>
														<td align='center' width='200'><b>Campo:</b></td>
														<td align='center' width='490'><b>Valor:</b></td>
													</tr>
												
									
									";
									
					foreach($arrRegistros2[$x]["valoresCampos"] as $campo)				
					{
									
						$filaTmp.=		"<tr height='23'>
											
											<td align='left' class='celdaImagenAzul3' >
												 ".$campo["campo"]."
											</td>
											
											<td align='left' class='celdaImagenAzul3'>
												".$campo["valor"]."
											</td>
											
										</tr>
								";
					}
					$filaTmp.="			</table>
									</td>
								</tr>";
				}
			}
			
			
			
			$tablaTmp="";
						
			if($filaTmp!="")
			{
				$tablaTmp.="	<tr height='23'>
									<td width='100'>
										<span class='letraRojaSubrayada8'></span>
									</td>
									
									<td align='left' class='celdaImagenAzul1' width='".$anchoCeldaCampo."' colspan='2'>
										<b>Secci&oacute;n:</b> <span class='letraRoja'><font color='#003'>".$nSeccion."</font></span>
									</td>
									<td width='130' align='center' class='celdaImagenAzul1'>
										<span class='corpo8'><font color='#F60'><b>Existe diferencia</b></font></span>
									</td>
								</tr>".$filaTmp;
				$cadTemp.=$tablaTmp;
			}	
		}
		else
		{
			$tablaTmp="	<tr height='23'>
									<td width='100'>
										<span class='letraRojaSubrayada8'></span>
									</td>
									
									<td align='left' class='celdaImagenAzul1' width='".$anchoCeldaCampo."' colspan='2'>
										<b>Secci&oacute;n:</b> <span class='letraRoja'><font color='#003'>".$nSeccion."</font></span>
									</td>
									<td width='130' align='center' class='celdaImagenAzul1'>
										<span class='corpo8'><font color='#FF0000'><b>Se agreg&oacute; la secci&oacute;n en la versi&oacute;n: ".$version1."</b></font></span>
									</td>
								</tr>".$filaTmp;
				$cadTemp.=$tablaTmp;
		}
		
		
	}

	for($x1=0;$x1<$sTabla2->childNodes->length;$x1++)
	{
		$tabla=$sTabla2->childNodes->item($x1);
		$nTabla=$tabla->nodeName;
		$nSeccion=$tabla->attributes->getNamedItem ("tituloTabla")->nodeValue;
		$arrTabla=getElementsByTagNameListNode($sTabla1,$nTabla); 
		if(sizeof($arrTabla)==0)
		{
			$tablaTmp="	<tr height='23'>
									<td width='100'>
										<span class='letraRojaSubrayada8'></span>
									</td>
									
									<td align='left' class='celdaImagenAzul1' width='".$anchoCeldaCampo."' colspan='2'>
										<b>Secci&oacute;n:</b> <span class='letraRoja'><font color='#F60'>".$nSeccion."</font></span>
									</td>
									<td width='130' align='center' class='celdaImagenAzul1'>
										<span class='corpo8'><font color='#FF0000'><b>Se elimin&oacute; la secci&oacute;n en la versi&oacute;n: ".$version1."</b></font></span>
									</td>
								</tr>".$filaTmp;
				$cadTemp.=$tablaTmp;
		}
	}
	
	return $cadTemp;
}

function compararSeccionTablas($t1,$t2)
{
	global $version1;
	global $version2;	
	if( $t1->childNodes->length!= $t2->childNodes->length) 
		$resEval="<font color='red'><b>Con diferencia</b></font>";
	else
		$resEval="<font color='green'><b>Sin diferencia</b></font>";
	$analisis="<br><br><table>
					<tr height='23'>
						<td width='100'><span class='corpo8_bold'></span></td><td width='350' align='center'><span class='corpo8_bold'>Versi&oacute;n de registro: ".$version1."</span></td><td width='350' align='center'><span class='corpo8_bold'>Versi&oacute;n de registro: ".$version2."</span></td><td width='230' align='center'><span class='corpo8_bold'>Situación</span></td>
					</tr>
					<tr height='23'>
						<td width='100'><span class='letraRojaSubrayada8'># Secciones</span></td><td align='center'><span class='copyrigthSinPadding'>".$t1->childNodes->length."</span></td><td width='350' align='center'><span class='copyrigthSinPadding'>".$t2->childNodes->length."</span></td><td width='130' align='center'><span class='copyrigthSinPadding'>".$resEval."</span></td>
					</tr>
					<tr height='4'>
						<td colspan='4'></td>
					</tr>
					<tr height='1'>
						<td colspan='4' style='background-color:#600'></td>
					</tr>
					<tr height='23'>
						<td width='100' colspan='4'><span class='letraRojaSubrayada8'>Análisis de secciones</span></td>
					</tr>
					";
	$analisis.=compararTablas($t1,$t2);
	$analisis.="</table>
				";
	return $analisis;
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
<?php
	$mostrarMenuIzq=false; 
	$paramGET=true;
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
							$version1="";
							if(isset($objParametros->version1))
								$version1=$objParametros->version1;	
							$version2="";
							if(isset($objParametros->version2))
								$version2=$objParametros->version2;	
							$idProceso="";
							if(isset($objParametros->idProceso))
								$idProceso=$objParametros->idProceso;	
							$idRegistro="";
							if(isset($objParametros->idRegistro))
								$idRegistro=$objParametros->idRegistro;
								
							if(($version1!="")&&($version2!=""))
							{
								if($version1<0)
								{
									$doc1=obtenerVersionProceso($idProceso,$idRegistro);
									$version1*=-1;
								}
								else
								{
									$consulta="select documentoXML from 9036_respaldosProceso where version=".$version1." and idProceso=".$idProceso." and idRegistro=".$idRegistro;
									$doc1=$con->obtenerValor($consulta);
								}
								if($version2<0)
								{
									$doc2=obtenerVersionProceso($idProceso,$idRegistro);
									$version2*=-1;
								}
								else
								{
									$consulta="select documentoXML from 9036_respaldosProceso where version=".$version2." and idProceso=".$idProceso." and idRegistro=".$idRegistro;
									$doc2=$con->obtenerValor($consulta);
								}
								$xml1=new DOMDocument();
								$xml1->loadXML($doc1);
								$xml2=new DOMDocument();
								$xml2->loadXML($doc2);
								$tablas1=$xml1->getElementsByTagName('proceso'); 
								$tablas2=$xml2->getElementsByTagName('proceso'); 
							}
                            ?>
                            <table width="100%">
                              <tr>
                                <td align="center">
                                  <span class="tituloPaginas">Resultado de comparación de versiones</span>
                                </td>
                              </tr>
                              <tr>
                                <td align="center" class="">
                                  <br />
                                  <br />
                                  <table>
                                    <tr>
                                      <td>
                                        <?php
								$resultado="";
								$resultado=compararSeccionTablas($tablas1->item(0),$tablas2->item(0));
								echo $resultado; 
                                        ?>
                                      </td>
                                    </tr>
                                  </table>
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
