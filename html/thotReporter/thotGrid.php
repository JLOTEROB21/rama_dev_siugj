<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");

function crearElementosReporte($idPadre=null,$posZIndex=1)
{
		global $funcionesJava;
		global $con;
		global $et;
		global $idReporte;
		global $nTabla;
		$nombreTabla=$nTabla;
		global $calibrarCtrl;
		global $cc;
		global $numElementos;
		global $arrElementosFocus;
		global $nElementosFocus;
		$cadEtiquetaElementos="";
		$idCtrlPadre="-1";
		$divPadre=0;
		if($idPadre!=null)
		{
			$idCtrlPadre=$idPadre;
			$divPadre=$idPadre;
		}
		if($idPadre==null)
			$query="select idGrupoElemento,nombreCampo,tipoElemento,posX,posY,eliminable from 9011_elementosReportesThot where tipoElemento=1 and idPadre=-1 and idReporte=".$idReporte." and idIdioma in(".$_SESSION["leng"].",0)";
		else			
			$query="select idGrupoElemento,nombreCampo,tipoElemento,posX,posY,eliminable from 9011_elementosReportesThot where tipoElemento=1 and idPadre=".$idPadre." and idIdioma in(".$_SESSION["leng"].",0)";
		$res=$con->obtenerFilas($query);
		$res5=$con->obtenerFilas("select idIdioma from 8002_idiomas");
		while($filas=mysql_fetch_row($res))
		{
			$consulta="select * from 9012_configuracionElemReporteThot where idElemReporte=".$filas[0];
			$filaE=$con->obtenerPrimeraFila($consulta);
			$colorFondo=$filaE[14];
			$alto=$filaE[3];
			if($filaE[2]=="")
				$etiqueta="<span funcRenderer='".$filaE[14]."' class='".$filaE[13]."' id='_lbl".$filas[0]."'>".$filas[1]."</span>";
			else
				$etiqueta="<span funcRenderer='".$filaE[14]."' class='".$filaE[13]."' id='_lbl".$filas[0]."' style='width:".$filaE[2]."px; overflow:hidden; display:inline-block'>".$filas[1]."</span>";
			if($filas[5]=="1")
			{
				$btnEliminar='&nbsp;<a href="javascript:eliminarElemento(\''.bE($filas[0]).'\')"><img src="../images/formularios/cross.png" height="10" width="10" title="Eliminar elemento" alt="Eliminar elemento" /></a>';
			}
			else
				$btnEliminar="";
			$tabla=	 "	<table class='tablaControl'>
    						<tr>
                    			<td id='td_".$filas[0]."'>".$etiqueta;
			$columnas="";
			$ancho=105;
			mysql_data_seek($res5,0);
			while($fila5=mysql_fetch_row($res5))
			{		
			
				$queryAux10="select nombreCampo from 9011_elementosReportesThot where idGrupoElemento=".$filas[0]." and idIdioma=".$fila5[0];
				$valorEt=$con->obtenerValor($queryAux10);
				$tabla.="<input type='hidden' id='td_".$filas[0]."_".$fila5[0]."' value='".$valorEt."'>";
			}
								
			$tabla.=	"	</td>
							<td valign='top' style='background-color:#FFF;display:none'><span id='sp_btnEliminar_".$filas[0]."'>".$btnEliminar."</span>
							</td>
                    		</tr>
    					</table>";
						
			$div="<div colorFondo1='".$colorFondo."'  id='div_".$filas[0]."' idPadre='".$idCtrlPadre."' visible='1' style='z-Index:".$posZIndex.";top:".$filas[4]."px; left:".$filas[3]."px; 
					position:absolute;background-color:".$colorFondo.";' onmousedown='comienzoMovimiento(event, this.id);' 
					onmouseover='setCtrlMovible(event,this)' controlInterno='_lbl".$filas[0]."_".$filas[2]."'>".$tabla."</div>";			
			if($idPadre==null)
				echo $div;
			else
				$cadEtiquetaElementos.=$div;
				
			if($calibrarCtrl=="")
				$calibrarCtrl="'div_".$filas[0]."'";
			else
				$calibrarCtrl.=",'div_".$filas[0]."'";
				
		}
		
		
		$posYPadre=0;
		$posXPadre=0;
		if($idPadre==null)
			$query="select idGrupoElemento,nombreCampo,tipoElemento,posX,posY,eliminable from 9011_elementosReportesThot where idPadre=-1 and tipoElemento not in (1,26) and idReporte=".$idReporte."";
		else
		{
			$query="SELECT posX,posY FROM 9011_elementosReportesThot WHERE idGrupoElemento=".$idPadre;
			$fPadre=$con->obtenerPrimeraFilaAsoc($query);
			
			$posYPadre=$fPadre["posY"];
			$posXPadre=$fPadre["posX"];
			
			$query="select idGrupoElemento,nombreCampo,tipoElemento,(posY-".$posYPadre.") as posY,(posX-".$posXPadre.")as posX,eliminable 
					from 9011_elementosReportesThot where tipoElemento not in (1) and idPadre=".$idPadre;
			
		}
		$res=$con->obtenerFilas($query);
		while($fElemento=mysql_fetch_row($res))
		{
			$numElementos++;
			$ignorarLimites="";
			if($fElemento["5"]=="1")
				$mostrarEliminar=true;
			else
				$mostrarEliminar=false;
			
			$val='';
			$attComp="";
			$asteriscoRojo='';
			$nombreControl=generarNombre($fElemento[1],$fElemento[2]);	
			$habilitado="";
			$btnComp="";
			$anchoAsterisco="1";
			if($asteriscoRojo!="")
				$anchoAsterisco=10;
			$consulta="select * from 9012_configuracionElemReporteThot where idElemReporte=".$fElemento[0];
			$filaE=$con->obtenerPrimeraFila($consulta);
			$colorFondo=$filaE[14];
			$colorFondo2="";
			switch($fElemento[2])					
			{
				case 23: //Imagen
					
					$etiqueta= "<img src='../media/mostrarImgFrm.php?id=".base64_encode($filaE[4])."' width='".$filaE[2]."' height='".$filaE[3]."' id='".$nombreControl."'>";
				break;
				case 25:
					$colorFondo2=$filaE[13];
					$anchoTabla=$filaE[2];
					$altoTabla=$filaE[3];
					if($calibrarCtrl=="")
						$calibrarCtrl="'div_".$fElemento[0]."'";
					else
						$calibrarCtrl.=",'div_".$fElemento[0]."'";
					
					$cadHijos=crearElementosReporte($fElemento[0],($posZIndex+1));
					$etiqueta= "<table  style='width:".$anchoTabla."px' id='_secc".$fElemento[0]."'>
										<tr style='height:".$altoTabla."px' id='filaPrincipal_".$fElemento[0]."'>
										<td>
										</td>
										</tr>
									</table>
								";
					$consulta="SELECT idAlmacen FROM 9016_seccionesVSAlmacen WHERE  idSeccion=".$fElemento[0];
					$filasAlmacen=$con->obtenerPrimeraFila($consulta);
					$attComp="almacenVinculado='0'";
					if($filasAlmacen)
						$attComp="almacenVinculado='1'";
					echo $cadHijos;
				break;
				case 26:
					$anchoAsterisco=1;
					$alto=$filaE[3];
					$campo=$fElemento[1];
					$arrDatoCampo=explode("_",$campo);
					
					if(strpos($campo,"tablaDinamica")!==false)
					{
						$campoAux=ucfirst($arrDatoCampo[2]);
						$arrCampo2=explode(".",$campoAux);
						$consulta="select nombreFormulario from 900_formularios where nombreTabla='_".$arrDatoCampo[1]."_".$arrCampo2[0]."'";
						
						$tituloProceso=$con->obtenerValor($consulta);
						$campo=str_replace("TablaDinamica",$tituloProceso,$campoAux);	
					}
					else
						if(isset($arrDatoCampo[1]))
							$campo=ucfirst($arrDatoCampo[1]);
						else
							$campo=ucfirst($arrDatoCampo[0]);
						
					if($filaE[2]=="")
						$etiqueta="<span class='".$filaE[13]."' id='_lbl".$fElemento[0]."' style='height:".$alto."px;  overflow:hidden; display:inline-block' title='".$campo."' alt='".$campo."'>[".$campo."]</span>";
					else
						$etiqueta="<span class='".$filaE[13]."' id='_lbl".$fElemento[0]."' style='width:".$filaE[2]."px;height:".$alto."px; overflow:hidden; display:inline-block' title='".$campo."' alt='".$campo."'>[".$campo."]</span>";
				break;
				case 27:
					$anchoAsterisco=1;
					$alto=$filaE[3];
					$vInicial=$filaE[5];
					$vIncremento=$filaE[4];
					if($filaE[2]=="")
						$etiqueta="<span vInicial='".$vInicial."' vIncremento='".$vIncremento."' class='".$filaE[13]."' id='_lbl".$fElemento[0]."' style='height:".$alto."px; overflow:hidden; display:inline-block'>#</span>";
					else
						$etiqueta="<span vInicial='".$vInicial."' vIncremento='".$vIncremento."' class='".$filaE[13]."' id='_lbl".$fElemento[0]."' style='width:".$filaE[2]."px;height:".$alto."px; overflow:hidden; display:inline-block'>#</span>";
				break;
				case 28:
					$anchoAsterisco=1;
					$alto=$filaE[3];
					$campo=$filaE[11];
					$idAlmacen=$filaE[10];
					
					
					//$arrCampo=explode("_",$campo);
					//$campo=ucfirst($arrCampo[1]);
					if(($filaE[9]==1)||($filaE[9]==2))
					{
						$consulta="select nombreDataSet from 9014_almacenesDatos where idDataSet=".$idAlmacen;
						$nAlmacen=$con->obtenerValor($consulta);
						$arrDatoCampo=explode("_",$campo);
						
						if(strpos($campo,"tablaDinamica")!==false)
						{
							$campoAux=ucfirst($arrDatoCampo[2]);
							$arrCampo2=explode(".",$campoAux);
							$consulta="select nombreFormulario from 900_formularios where nombreTabla='_".$arrDatoCampo[1]."_".$arrCampo2[0]."'";
							
							$tituloProceso=$con->obtenerValor($consulta);
							$campo=str_replace("TablaDinamica",$tituloProceso,$campoAux);	
						}
						else
						{
							if(isset($arrDatoCampo[1]))
								$campo=ucfirst($arrDatoCampo[1]);
							else
								$campo=ucfirst($arrDatoCampo[0]);
						}
					}
					
					if($filaE[2]=="")
						$etiqueta="<span funcRenderer='".$filaE[14]."' class='".$filaE[13]."' id='_lbl".$fElemento[0]."' style='height:".$alto."px; overflow:hidden; display:inline-block' title='".$campo." [".$nAlmacen."]' alt='".$campo." [".$nAlmacen."]'>[".$campo."]</span>";
					else
						$etiqueta="<span funcRenderer='".$filaE[14]."' class='".$filaE[13]."' id='_lbl".$fElemento[0]."' style='width:".$filaE[2]."px;height:".$alto."px; overflow:hidden; display:inline-block' title='".$campo." [".$nAlmacen."]' alt='".$campo." [".$nAlmacen."]'>[".$campo."]</span>";
				break;
				case 31:
					$tipoGrafico=$filaE[4];
					$idAlmacen=$filaE[6];
					$cadConf=$filaE[8];
					$tTitulo=20;
					if($filaE[11]!="")
						$tTitulo=$filaE[11];
					$tFuente=16;
					if($filaE[12]!="")
						$tFuente=$filaE[12];
					$tLeyenda=14;
					if($filaE[13]!="")
						$tLeyenda=$filaE[13];
					
					$consulta="SELECT objPropiedadesGrafico FROM 9026_tiposGraficos WHERE idTiposGraficos=".$tipoGrafico;
					$objPropiedadesGrafico=$con->obtenerValor($consulta);
					$titulo=$fElemento[1];
					if($titulo=="")
					{
						$objConf=json_decode($cadConf);
						$titulo=$objConf->caption;
					}
					$etiqueta="<table><tr><td objPropiedadesGrafico='".bE($objPropiedadesGrafico)."'  propiedadesGrafico='".bE($cadConf)."' tipoGrafico='".$tipoGrafico."'  idAlmacen='".$idAlmacen."' style='width: ".$filaE[2]."px; height: ".$filaE[3]."px;' id='_Grafico".$fElemento[0]."' class='claseDivGrafico' titulo='".$titulo."'><label>Gráfico: ".$fElemento[1]."</label></td></tr></table>";
				break;
				
			}				
			if($mostrarEliminar)
				$btnEliminar='<span style="z-index:10000" >&nbsp;<a href="javascript:eliminarElemento(\''.bE($fElemento[0]).'\')"><img src="../images/formularios/cross.png" height="10" width="10" title="Eliminar elemento" alt="Eliminar elemento" /></a></span>';
			else
				$btnEliminar="";
			$ayuda="";
			
			$tabla=	 "	<table class='tablaControl'>
    						<tr >
								<td valign='top' id='td_obl_".$fElemento[0]."' width='".$anchoAsterisco."'>".$asteriscoRojo."</td>
                    			<td id='td_".$fElemento[0]."' class=''>".$etiqueta."</td>
								<td valign='top' style='background-color:#FFF;display:none'>".$btnComp."<span id='sp_btnEliminar_".$fElemento[0]."'>".$btnEliminar."</span></td>
								<td id='tdAyuda_".$fElemento[0]."'><span id='spAyuda_".$fElemento[0]."'>".$ayuda."</span></td>".
                    		"</tr>
    					</table>";
			$funcionOver="setCtrlMovible(event,this)";
			$claseDiv="";			
			switch($fElemento[2])
			{
				case 28:
				case 26:	
					$claseDiv='class="frameCtrl"';
				break;
				case 25:
					$funcionOver="mueveMouseSobreGrid(event,this)";
					$claseDiv='class="frameSeccion"';
				break;	
			}			
						
						
			if(($fElemento[2]!=26)&&($fElemento[2]!=27)&&($fElemento[2]!=28))
			{
				$div="	<div colorFondo1='".$colorFondo."' colorFondo2='".$colorFondo2."'  ".$claseDiv." ".$attComp." id='div_".$fElemento[0]."' name='divPadre_".$divPadre."' idPadre='".$idCtrlPadre."' visible='1' 
						habilitado='1' style='z-Index:".$posZIndex.";top:".$fElemento[4]."px; left:".$fElemento[3]."px; position:absolute;background-color:".$colorFondo.";' class='frameSel'
						onmousedown='comienzoMovimiento(event, this.id);' onmouseover='".$funcionOver."' 
						controlInterno='".$nombreControl."_".$fElemento[2]."' ".$ignorarLimites." posX='".$fElemento[3]."' posY='".$fElemento[4]."'  >".$tabla."</div>";			
			}
			else
			{

				$div="	<div colorFondo1='".$colorFondo."' colorFondo2='".$colorFondo2."' ".$claseDiv." ".$attComp." id='div_".$fElemento[0]."' name='divPadre_".$divPadre."' idPadre='".$idCtrlPadre."' visible='1' style='z-Index:".$posZIndex.";
						top:".$fElemento[3]."px; left:".$fElemento[4]."px; position:absolute;background-color:".$colorFondo.";' onmousedown='comienzoMovimiento(event, this.id);' 
						onmouseover='".$funcionOver."' controlInterno='_lbl".$fElemento[0]."_".$fElemento[2]."' posX='".$fElemento[4]."' posY='".$fElemento[3]."'>".$tabla."</div>";							
			}
			if($idPadre==null)
				echo $div;
			else
				$cadEtiquetaElementos.=$div;
			if($fElemento[2]!=25)
			{
				if($calibrarCtrl=="")
					$calibrarCtrl="'div_".$fElemento[0]."'";
				else
					$calibrarCtrl.=",'div_".$fElemento[0]."'";
				
				
			}
		}
		if($idPadre!=null)
			return $cadEtiquetaElementos;
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
	$guardarConfSession=true;
?>

<script type="text/javascript" src="../thotReporter/Scripts/thotCanvas.js.php"></script>
<script type="text/javascript" src="../Scripts/html5/kinetic-v3.10.2.js"></script>
<script type="text/javascript" src="../Scripts/html5/cLienzo.js"></script>
<script type="text/javascript" src="Scripts/thotControles.js.php"></script>
<script type="text/javascript" src="Scripts/thotGuardarControles.js.php"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ux/colorField/ext.ux.ColorField.css" />
<script type="text/javascript" src="../Scripts/ux/colorField/ext.ux.ColorField.js"></script>
<script type="text/javascript" src="Scripts/editorEstilo.js.php"></script>
<script type="text/javascript" src="Scripts/thotImagenes.js.php"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ext/ux/file-upload.css" />
<script type="text/javascript" src="../Scripts/ext/ux/FileUploadField.js"></script>


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
                        	<script type="text/javascript" src="../Scripts/base64.js"></script>

                        	 <script type="text/javascript" src="Scripts/thotGrid.js.php"></script>
                        	<?php 
								$idReporte="-1";
								if(isset($objParametros->idReporte))
									$idReporte=$objParametros->idReporte;
								$anchoGrid="-1";
								if(isset($objParametros->anchoGrid))
									$anchoGrid=$objParametros->anchoGrid;
								$altoGrid="-1";
								if(isset($objParametros->anchoGrid))
									$altoGrid=$objParametros->altoGrid;
								$cc=0;
								$calibrarCtrl="";
							?>
                             
                        	
                        	<table  id='tblGrid' style="height:<?php echo $altoGrid?>px; width:<?php echo $anchoGrid?>px" onmouseover="mueveMouseSobreGrid(event,this)" onmouseout="saleMouseSobreGrid(event,this)" onclick="clickGrid(event,this)" >
                            	<tr>
                                	<td  id="tdContenedor" >
                                    <?php
								   		crearElementosReporte();
									?>
                                    <canvas id="canvas" class="gridRejilla" style="border-color:#000; border-width:1px; border-style:solid" height="<?php echo $altoGrid?>" width="<?php echo $anchoGrid?>"></canvas>
                                    <div id="canvas2" style="position: absolute; cursor: move; left: 34px; top: 42px;"></div>
                                    </td>
                                </tr>
                            </table>
                            <input type="hidden" value="<?php echo $idReporte?>" id="idReporte" />
                            <input type="hidden" value="<?php echo $_SESSION["leng"]?>" id="hIdIdioma" />
                            <input type="hidden" value="<?php echo ("[".$calibrarCtrl."]")?>" id="calibrarCtrl" />
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
