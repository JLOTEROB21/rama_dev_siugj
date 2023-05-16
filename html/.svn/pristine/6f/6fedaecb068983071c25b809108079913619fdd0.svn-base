<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");

$consulta="select idCalculo,concat(orden,'.- [',co.codigo,'] ',co.nombreConsulta,' [Tipo: ',if(idUsuarioAplica is null,'Global','Individual'),']')  
			from 662_calculosNomina c,991_consultasSql co where co.idConsulta=c.idConsulta";
$arrCalculosDef=$con->obtenerFilasArregloAsocPHP($consulta);
$consulta="SELECT idTipoPuesto,nombreTipoPuesto FROM 664_tiposPuesto WHERE codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
$resConsulta=$con->obtenerFilas($consulta);
$arrPuestos=array();
while($filaPuesto=mysql_fetch_row($resConsulta))
	$arrPuestos[$filaPuesto[0]]=$filaPuesto[1];

$habilitarCache=true;



function generarListadoNominaDepto($codPadre,&$objUsuario,$idLibro,&$nPuestos)
{
	global $con;
	global $totalSueldoBaseGlobal;
	global $totalDeduccionesGlobal;
	global $totalPercepcionesGlobal;
	global $totalSueldoNetoGlobal;
	global $arrCalculosDef;
	global $arrPuestos;
	global $habilitarCache;
	$consulta="SELECT idAcumuladorNomina FROM 665_acumuladoresNomina WHERE nivelAcumulador=0 AND codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
	$resAcumuladores=$con->obtenerFilas($consulta);
	$arrAcumuldoresGlobales=array();
	while($filaAcum=mysql_fetch_row($resAcumuladores))
	{
		$arrAcumuldoresGlobales[$filaAcum[0]]=0;
	}
	
	
	
	$arrPuestos[0]="107";
	$arrPuestos[1]="97";
	$arrPuestos[2]="111";
	$arrPuestos[3]="42";
	$arrPuestos[4]="75";
	$arrPuestos[5]="68";
	$arrPuestos[6]="88";
	$listUnidades="'000100040003','000100060005','000100060001','000100070029','000100020003','000100020005','000100030002'";
	//$listUnidades="'000100060001'";
	$consulta="select codigoFuncional,unidad,codigoUnidad from 817_organigrama where codigoUnidad in(".$listUnidades.")  order by codigoFuncional";
	////$codPadre='00010003002000000000';
	//$consulta="select codigoFuncional,unidad,codigoUnidad from 817_organigrama where unidadPadre='".$codPadre."'   order by codigoFuncional";
	//$consulta="select codigoFuncional,unidad,codigoUnidad from 817_organigrama where codigoFuncional='".$codPadre."'   order by codigoFuncional";

	$res=$con->obtenerFilas($consulta);
	$ct=0;
		
	while($fila=mysql_fetch_row($res))
	{
		
		$totalArea=0;
		$totalDeducciones=0;
		$totalPercepciones=0;
		$totalSueldoNeto=0;
		echo "	
				<table>
					<tr>
						<td colspan='2'>
							<table>
							<tr>
								<td width='250'><span class='corpo8_bold'>Código de unidad: </span> <span class='copyrigthSinPadding'>".$fila[0]."</span>
								</td>
								<td width='20'>
								</td>
								<td width='570'><span class='corpo8_bold'>Nombre área/departamento: </span> <span class='copyrigthSinPadding'>".$fila[1]."</span>
								</td>
								<td width='10'>
								</td>
							</tr>
							<tr height='4'>
								<td style='background-color:#FFF;' colspan='4'>
							</tr>
							<tr height='2'>
								<td style='background-color:#006;' colspan='4'>
							</tr>
							<tr height='2'>
								<td style='background-color:#FFF;' colspan='4'>
							</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan='2'>
							<br>
						</td>
					<tr>
					<tr>
						<td width='70'>
						</td>
						<td>
							<table width='1430'>
								<tr>
									<td width='170' align='center' class='fondoVerde7'>Código tabulación puesto</td>
									<td width='350' align='center' class='fondoVerde7'>Puesto</td>
									<td width='120' align='center' class='fondoVerde7'>Tipo puesto</td>
									<td width='100' align='center' class='fondoVerde7'>Zona</td>
									<td width='250' align='center' class='fondoVerde7'>Titular puesto</td>
									<td width='120' align='center' class='fondoVerde7'>Total deducciones</td>
									<td width='120' align='center' class='fondoVerde7'>Total percepciones</td>
									<td width='120' align='center' class='fondoVerde7'>Sueldo neto</td>
								</tr>
								<tr height='2'>
									<td colspan='200' style='background-color:#000'></td>
								</tr>
								<tr height='7'>
									<td colspan='200' style='background-color:#FFF'></td>
								</tr>
								";
								$consulta="select distinct p.cvePuesto,p.puesto,p.tipoPuesto,p.zona,up.situacion,p.idPuesto,up.idUnidadVSPuesto from 653_unidadesOrgVSPuestos up,819_puestosOrganigrama p 
											where  p.idPuesto=up.idPuesto and up.codUnidad='".$fila[2]."' order  by p.puesto limit 0,1";
								$resPuestos=$con->obtenerFilas($consulta);
								
								while($filaPuestos=mysql_fetch_row($resPuestos))
								{
									$ct++;
									if($ct>10)
										return;
						
	
									$nPuestos++;
									$tipoPuesto="";
									$tipoPuesto=$arrPuestos[$filaPuestos[2]];
									$consulta="select NombreZona from 650_zonas where id_650_zonas=".$filaPuestos[3];
									$zona=$con->obtenerValor($consulta);
									$titular="<font color='red'>Vacante</font>";
									$sueldoBase="0";
									$objUsuario->idUsuario="";
									$objUsuario->sueldoBase=0;
									$objUsuario->nFaltas=0;
									$objUsuario->nRetardos=0;
									$objUsuario->totalDeducciones=0;
									$objUsuario->totalPercepciones=0;
									$objUsuario->sueldoNeto=0;
									$fechaContratacion="";
									$objUsuario->fechaContratacion=$fechaContratacion;
									$objUsuario->arrCalculosIndividuales=array();
									$objUsuario->arrCalculosGlobales=array();
									$objUsuario->departamento="";
									$compApDeducciones="";
									$compCDeducciones="";
									$compApPercepciones="";
									$compCPercepciones="";
									if($filaPuestos[4]!="0")
									{
										$consulta="select salario,idUsuario,puesto from 801_fumpEmpleado where idTabulacion=".$filaPuestos[6]." and activo=1";
										$filaTab=$con->obtenerPrimeraFila($consulta);
										$arrAcumuldoresIndividuales=array();
										
										foreach($arrAcumuldoresGlobales as $acumG=>$valor)
										{
											$arrAcumuldoresGlobales[$acumG]=0;	
										}
										
										if($filaTab)
										{
											$consulta="select fechaIngresoInstitucion,fechaBase,fechaBaja,horasTrabajador,Institucion from 801_adscripcion where idUsuario=".$filaTab[1];
											$filaAds=$con->obtenerPrimeraFila($consulta);
											$sueldoBase=$filaTab[0];
											$titular=obtenerNombreUsuario($filaTab[1]);
											$objUsuario->idUsuario=$filaTab[1];
											
											$objUsuario->puesto="'".$filaTab[2]."'";
											$objUsuario->fechaBaja="'".$filaAds[2]."'";
											$objUsuario->fechaBasificacion="'".$filaAds[1]."'";;
											$objUsuario->horasTrabajador=$filaAds[3];
											$objUsuario->institucion=$filaAds[4];
											$objUsuario->fechaContratacion=$filaAds[0];
											$consulta="SELECT idAcumuladorNomina FROM 665_acumuladoresNomina WHERE nivelAcumulador=1 AND idUsuario=".$objUsuario->idUsuario." and codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
											$resAcumuladores=$con->obtenerFilas($consulta);
											while($filaAcum=mysql_fetch_row($resAcumuladores))
											{
												$arrAcumuldoresIndividuales[$filaAcum[0]]=0;
											}

										}
										else
										{
											$sueldoBase=0;
											$titular=obtenerNombreUsuario("-1");
											$objUsuario->idUsuario=-1;
											$objUsuario->puesto="''";
											$objUsuario->fechaBaja="";
											$objUsuario->fechaBasificacion="";
											$objUsuario->horasTrabajador="";
											$objUsuario->institucion="";
											$objUsuario->fechaContratacion="";
										}
										$objUsuario->sueldoBase=$sueldoBase;
										$objUsuario->nFaltas=0;
										$objUsuario->nRetardos=0;
										$objUsuario->totalDeducciones=0;
										$objUsuario->totalPercepciones=0;
										$objUsuario->sueldoNeto=0;
										
										$objUsuario->departamento=$fila[2];
										$cacheCalculos=NULL;
										if($habilitarCache)
											$cacheCalculos=array();
										/*echo "<table>";*/
										if($objUsuario->idUsuario!="-1")
										{
											
											realizarCalculosGlobales($objUsuario,$arrCalculosDef,$arrAcumuldoresGlobales,$cacheCalculos);
											/*if($cacheCalculos!=null)
											{
												foreach($cacheCalculos as $idCalculo=>$contador)
												{
													echo "<tr><td width='100'>".$idCalculo."</td><td>".$contador."</td></tr>";
												}
											}*/
											//realizarCalculosIndividuales($objUsuario,$arrCalculosDef,$arrAcumuldoresIndividuales);
										}
										/*echo "</table>";*/
										$totalArea+=$sueldoBase;
										$arrCalculosInd=array();
										$arrCalculosGlobal=array();
										if(sizeof($objUsuario->arrCalculosIndividuales)>0)
										{
											foreach($objUsuario->arrCalculosIndividuales as $calculoInd)
											{
												if($calculoInd["tipoCalculo"]=="1")
													$objUsuario->totalDeducciones+=$calculoInd["valorCalculado"];
												else
													$objUsuario->totalPercepciones+=$calculoInd["valorCalculado"];
												$obj["tipoCalculo"]=$calculoInd["tipoCalculo"];
												$obj["nombreCalculo"]=$calculoInd["nombreCalculo"];
												$obj["valorCalculado"]=$calculoInd["valorCalculado"];
												array_push($arrCalculosInd,$obj);
												
												
											}
										}
										
										if(sizeof($objUsuario->arrCalculosGlobales)>0)
										{
											foreach($objUsuario->arrCalculosGlobales as $calculoInd)
											{

												if($calculoInd["tipoCalculo"]=="1")
													$objUsuario->totalDeducciones+=$calculoInd["valorCalculado"];
												else
													$objUsuario->totalPercepciones+=$calculoInd["valorCalculado"];
													
												$obj["tipoCalculo"]=$calculoInd["tipoCalculo"];
												$obj["nombreCalculo"]=$calculoInd["nombreCalculo"];
												$obj["valorCalculado"]=$calculoInd["valorCalculado"];
												array_push($arrCalculosGlobal,$obj);
											}
											//echo $objUsuario->totalPercepciones."<br>";
										}
										$totalDeducciones+=$objUsuario->totalDeducciones;
										$totalPercepciones+=$objUsuario->totalPercepciones;
										
										$compApDeducciones="";
										$compCDeducciones="";
										$compApPercepciones="";
										$compCPercepciones="";
										if($objUsuario->totalDeducciones!=0)
										{
											$compApDeducciones="<a href='javascript:verDesgloce(1,\"".bE(json_encode($arrCalculosGlobal))."\",\"".bE(json_encode($arrCalculosInd))."\",\"".bE($objUsuario->idUsuario)."\")'>";
											$compCDeducciones="</a>";
										
											
										}
										if($objUsuario->totalPercepciones!=0)
										{
											$compApPercepciones="<a href='javascript:verDesgloce(2,\"".bE(json_encode($arrCalculosGlobal))."\",\"".bE(json_encode($arrCalculosInd))."\",\"".bE($objUsuario->idUsuario)."\")'>";
											$compCPercepciones="</a>";
										}
										
										$objUsuario->sueldoNeto=$objUsuario->totalDeducciones+$objUsuario->totalPercepciones;
										
										$totalSueldoNeto+=$objUsuario->sueldoNeto;
										guardarAsientoCalculoNomina($objUsuario,$idLibro);
									}
									
									//<td><span class='letraExt'>$ ".number_format($sueldoBase,2,'.',',')."</span></td>
									echo "<tr>
											<td><span class='letraExt'>".$filaPuestos[0]."</span></td>
											<td><span class='letraExt'>".$filaPuestos[1]."</span></td>
											<td><span class='letraExt'>".$tipoPuesto."</span></td>
											<td><span class='letraExt'>".$zona."</span></td>
											<td><span class='letraExt'>".$titular."</span></td>
											<td><span class='letraExt'>".$compApDeducciones."$ ".number_format($objUsuario->totalDeducciones,2,'.',',').$compCDeducciones."</span></td>
											<td><span class='letraExt'>".$compApPercepciones."$ ".number_format($objUsuario->totalPercepciones,2,'.',',').$compCPercepciones."</span></td>
											<td><span class='letraExt'>$ ".number_format($objUsuario->sueldoNeto,2,'.',',')."</span></td>
										</tr>
										<tr height='3'>
											<td colspan='200' style='background-color:#FFF'></td>
										</tr>
										<tr height='1'>
											<td colspan='200' style='background-color:#6B6E72'></td>
										</tr>
										<tr height='3'>
											<td colspan='200' style='background-color:#FFF'></td>
										</tr>
										";	
								}
								
		echo "				
							<tr>
								<td colspan='5' align='right' class='fondoGrid7'>
									<span class='letraRoja'>
									Total Área:&nbsp;&nbsp;
									</span>
								</td>
								
								<td class='fondoGrid7'><span class='letraExt'><b>$ ".number_format($totalDeducciones,2,'.',',')."</b></span>
								</td>
								<td class='fondoGrid7'><span class='letraExt'><b>$ ".number_format($totalPercepciones,2,'.',',')."</b></span>
								</td>
								<td class='fondoGrid7'><span class='letraExt'><b>$ ".number_format($totalSueldoNeto,2,'.',',')."</b></span>
								</td>
							</tr>
							</table>
							
						</td>
					</tr>
				</table><br><br>
			";
		$totalSueldoBaseGlobal+=$totalArea;
		$totalDeduccionesGlobal+=$totalDeducciones;
		$totalPercepcionesGlobal+=$totalPercepciones;
		$totalSueldoNetoGlobal+=$totalSueldoNeto;
		//generarListadoNominaDepto($fila[2],$objUsuario,$idLibro,$nPuestos);
	}
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
	$mostrarMenuIzq=false;
	$guardarConfSession=true;
?>

<script type="text/javascript" src="Scripts/generarNomina.js.php"></script>
<style>
	body
	{
		min-width:1500px !important;
	}
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
                        <td align="center">
                        
                        <?php
							$ciclo="-1";
							if(isset($objParametros->ciclo))
								$ciclo=$objParametros->ciclo;
							$codUnidad="-1";
							if(isset($objParametros->codUnidad))
								$codUnidad=$objParametros->codUnidad;

							$quincena="00";
							if(isset($objParametros->quincena))
								$quincena=$objParametros->quincena;
							
							$totalSueldoBaseGlobal=0;
							$totalDeduccionesGlobal=0;
							$totalPercepcionesGlobal=0;
							$totalSueldoNetoGlobal=0;
							$cadObj='	{
												"idUsuario":"",
												"fechaContratacion":"",
												"sueldoBase":"",
												"arrCalculosIndividuales":[],
												"arrCalculosGlobales":[],
												"ciclo":"'.$ciclo.'",
												"quincena":"'.$quincena.'",
												"nFaltas":"",
												"nRetardos":"",
												"departamento":"",
												"totalDeducciones":"",
												"totalPercepciones":"",
												"sueldoNeto":"",
												"puesto":"",
												"fechaBaja":"",
												"fechaBasificacion":"",
												"horasTrabajador":"",
												"institucion":""
											}';
							
							$objUsuario=json_decode($cadObj);
						?>
                        	<span class="tituloPaginas">Nomina<br /><br />Quincena: <?php echo $quincena?>, Ciclo: <?php echo $ciclo?></span><br /><br />
                            <table width="100%">
                            	<tr>
                                	<td align='left' ><br /><br />
                                    	<?php
											$idLibroDiario=generarEntradaLibroNomina($quincena,$ciclo);
											$nPuestos=0;
											$hInicio=date("H:i:s");
											
											if($idLibroDiario)
												generarListadoNominaDepto($codUnidad,$objUsuario,$idLibroDiario,$nPuestos);
											$consulta="update 656_calendarioNomina set situacion='2' where noQuincena='".$quincena."' and ciclo='".$ciclo."'";
											$con->ejecutarConsulta($consulta);
											$hFin=date("H:i:s");
											
											echo "<br>Hora de inicio: ".$hInicio."  hora final: ".$hFin." Diferencia=".date("H:i:s",strtotime("00:00:00")+strtotime($hFin)-strtotime($hInicio));
											
										?>
                                    </td>
                                </tr>
                                <tr>
                                	<td align="center">
                                    	<br /><br /><br />
                                        <table>
                                        	<tr height="21">
                                                <td width="190">
                                                <span class="corpo8_bold">
                                                Total de plazas:
                                                </span>
                                                </td>
                                                <td width="20">
                                                 <span class="corpo8_bold">
                                                	
                                                 </span>
                                                </td>
                                                <td align="right" width="100">
                                                <span class="copyrigthSinPadding">
                                                <?php
													echo number_format ($nPuestos,0,'.',',');
												?>
                                                </span>
                                                </td>
                                               
                                            </tr>
                                           
                                            <tr height="21">
                                                <td>
                                                <span class="corpo8_bold">
                                                Monto total deducciones:
                                                </span>
                                                </td>
                                                <td >
                                                 <span class="corpo8_bold">
                                                	$
                                                 </span>
                                                </td>
                                                <td align="right">
                                                 <span class="copyrigthSinPadding">
                                                <?php
													echo number_format ($totalDeduccionesGlobal,2,'.',',');
													
												?>
                                                </span>
                                                </td>
                                               
                                            </tr>
                                             <tr height="21">
                                                <td>
                                                <span class="corpo8_bold">
                                                 Monto total percepciones:
                                                 </span>
                                                </td>
                                                <td >
                                                 <span class="corpo8_bold">
                                                	$
                                                 </span>
                                                </td>
                                                <td align="right">
                                                <span class="copyrigthSinPadding">
                                                <?php
													
													echo number_format ($totalPercepcionesGlobal,2,'.',',');
												?>
                                                </span>
                                                </td>
                                            </tr>
                                            <tr height="2">
                                            	<td colspan="3" style="background-color:#FFF">
                                                </td>
                                            </tr>
                                            <tr height="2">
                                            	<td colspan="3" style="background-color:#CCCCCC">
                                                </td>
                                            </tr>
                                            <tr height="2">
                                            	<td colspan="3" style="background-color:#FFF">
                                                </td>
                                            </tr>
                                             <tr height="21">
                                                <td>
                                                <span class="corpo8_bold">
                                                Monto total sueldo neto:
                                                </span>
                                                </td>
                                                <td >
                                                 <span class="corpo8_bold">
                                                	$
                                                 </span>
                                                </td>
                                                <td align="right">
                                                 <span class="copyrigthSinPadding">
                                                <?php
													echo number_format ($totalSueldoNetoGlobal,2,'.',',');
												?>
                                                </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <br />
                            <br />
                            
                            
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


