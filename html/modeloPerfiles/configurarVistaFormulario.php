<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");
include_once("funcionesFormularios.php");

function crearElementosFormulario()
{
		global $funcionesJava;
		global $con;
		global $et;
		global $idFormulario;
		global $nTabla;
		$nombreTabla=$nTabla;
		global $calibrarCtrl;
		global $cc;
		global $numElementos;
		global $arrElementosFocus;
		global $nElementosFocus;
		
		$query="select idGrupoElemento,nombreCampo,tipoElemento,obligatorio,posX,posY,eliminable,idGrupoElementoRef from 937_elementosVistaFormulario where idFormulario=".$idFormulario." and (idIdioma=".$_SESSION["leng"]." or idIdioma is null)";
		$res=$con->obtenerFilas($query);
		$res5=$con->obtenerFilas("select idIdioma from 8002_idiomas");
		while($filas=mysql_fetch_row($res))
		{
			$maxAncho="";
			$ignorarLimites="";
			$nombreControl=generarNombre($filas[1],$filas[2]);	
			$paramAdicionales="";
			$estilosAdicionales="";
			$estiloDiv="";
			switch($filas[2])
			{
				case -2:
					$etiqueta="	<table class='tablaMenu' width='200'>";
                  	$consulta="select idFormulario,nombreFormulario from 900_formularios where idFrmEntidad=".$idFormulario;
					$resFrm=$con->obtenerFilas($consulta);
					if(mysql_num_rows($resFrm)>0)
					{
						while($filaFrm=mysql_fetch_row($resFrm))
						{
							$etiqueta.= "<tr height='23'>
											<td  width='30'>&nbsp;<img src='../images/icon_code.gif'></td>
											<td class='letraFichaRespuesta' align='left' >".$filaFrm[1]."</td>
										</tr>";
						}
					}
					$etiqueta.="</table>";	
					$ignorarLimites='ignorarLimites="actualizar"';
					$mostrarEliminar=false;
					$numElementos--;
				break;
				case 13:
					$estiloDiv='z-index:0;';
					$query="select campoConf1,campoConf2 from 938_configuracionElemVistaFormulario where idElemFormulario=".$filas[0];
					$confCampo=$con->obtenerPrimeraFila($query);
					$etiqueta="<fieldset class='frameHijoV3' id='_lbl".$filas[0]."' style='width:".$confCampo[0]."px; height:".$confCampo[1]."px; '  ><legend> ".$filas[1]."</legend></fieldset>";
				break;
				case 23: //Imagen
					$consulta="select * from 938_configuracionElemVistaFormulario where idElemFormulario=".$filas[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$HRef="";
					$cHRef="";
					if($filaE[5]!="")
					{
						$HRef="<a id='link_".$filas[0]."' href='javascript:doNothing()'>";
						$cHRef="</a>";	
					}
					$etiqueta= "<span  id='_img".$filas[0]."' enlace='".$filaE[5]."'>".$HRef."<img src='../media/mostrarImgFrm.php?id=".base64_encode($filaE[4])."' width='".$filaE[2]."' height='".$filaE[3]."' id='".$nombreControl."'>".$cHRef."</span>";
					
				break;
				case 29:
					$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$filas[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta="<span id='contenedorSpanGrid_".$filas[0]."' permiteModificar='".$filaE[5]."' permiteEliminar='".$filaE[6]."'><span id='spanGrid_".$filas[0]."'></span></span>";
					$consulta="SELECT * FROM 9039_configuracionesColumnasCampoGrid WHERE idElemento=".$filas[0]." order by orden";
					$resConf=$con->obtenerFilas($consulta);
					$arrCampos="{name: 'idRegistro'},{name: 'idReferencia'}";
					$arrCabeceras="";
					$mPermisos="";
					$visible='true';
					if($filas[7]=="0")
						$visible='false';
					$nTabla=$filaE[4];
					while($filaConf=mysql_fetch_row($resConf))
					{
						$asterisco="";
						$tipoCampo=$filaConf[6];
						$editorColumn="null";
						$rendererCtrl="function(val)
										{
											return val;	
										}";
						switch($tipoCampo)
						{
							case 1: //Entero
								$editorColumn="new Ext.form.NumberField({id:'editor_".$filaConf[3]."',allowDecimals:false})";
							break;
							case 2: //Decimal
								$editorColumn="new Ext.form.NumberField({id:'editor_".$filaConf[3]."',allowDecimals:true})";
							break;
							case 3:  //texto
								$editorColumn="new Ext.form.TextField({id:'editor_".$filaConf[3]."'})";
							break;
							case 4:  //Vinculado a tabla
								$tabla=$filaConf[8];
								$campoProy=$filaConf[10];
								$campoLlave=$filaConf[12];
								$consulta="select ".$campoLlave.",".$campoProy." from ".$tabla." order by ".$campoProy;
								$arrOpciones=$con->obtenerFilasArreglo($consulta);
								$editorColumn="crearComboExt('editor_".$filaConf[3]."',".$arrOpciones.")";
								$rendererCtrl="function (val,meta,registro,fila,columna,almacen)
												{
													var pos=obtenerPosFila(almacen,'id',val);
													if(pos!=-1)
														return almacen.getAt(pos).get('nombre');
													else
														return val;
												}";
							break;
							case 5:  //Moneda
								$editorColumn="new Ext.form.NumberField({id:'editor_".$filaConf[3]."',allowDecimals:true,renderer:'usMoney'})";
							break;
							case 6:	//Fecha
								$editorColumn="new Ext.form.DateField({id:'editor_".$filaConf[3]."',format:'d/m/Y'})";
							break;
							case 7:	//Hora
								$editorColumn="crearCampoHoraExt('editor_".$filaConf[3]."')";
								$rendererCtrl="function (val,meta,registro,fila,columna,almacen)
														{
															var pos=obtenerPosFila(almacen,'id',val);
															if(pos!=-1)
																return almacen.getAt(pos).get('nombre');
															else
																return val;		
														}";
							break;	
						}
						
						if($filaConf[7]=="1")
							$asterisco=' <font color="red">*</font>';
						$oculto='false';
						if($filaConf[14]=="0")
						{
							$oculto='true';
							$asterisco="";
						}
						$arrCampos.=",{name:'".$filaConf[3]."'}";
						$objCabecera="{
															header:'".$filaConf[4].$asterisco."',
															width:".$filaConf[5].",
															sortable:true,
															dataIndex:'".$filaConf[3]."',
															hidden:".$oculto.",
															editor:".$editorColumn.",
															renderer:".$rendererCtrl."
										}";
						if($arrCabeceras=="")
							$arrCabeceras=$objCabecera;
						else
							$arrCabeceras.=",".$objCabecera;
							
					}
					$arrCampos="[".$arrCampos."]";
					$arrCabeceras="[".$arrCabeceras."]";
					$habilitado="false";
					
					if($filaE[13]==0)
						$habilitado="true";
					
					
					
					$funcionesJava.="crearCampoGridFormulario('grid_".$filas[0]."','spanGrid_".$filas[0]."',".$filaE[2].",".$filaE[3].",".$arrCampos.",".$arrCabeceras.",'".$mPermisos."',".$habilitado.",".$visible.",[]);";
					
				break;
				case 33: //Imagen
					$consulta="select * from 938_configuracionElemVistaFormulario where idElemFormulario=".$filas[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$etiqueta= "<img src='../images/imgNoDisponible.jpg' width='".$filaE[2]."' height='".$filaE[3]."' id='".$nombreControl."'>";
							
				break;
				default:
					$estiloDiv='z-index:10;';
					$consulta="select * from 938_configuracionElemVistaFormulario where idElemFormulario=".$filas[0];
					$filaE=$con->obtenerPrimeraFila($consulta);
					$maxAncho=$filaE[14];
					switch($filas[2])
					{
						case 10:
							$formato=$filaE[15];
							if($formato=="")
								$formato=1;
							$paramAdicionales.=" formatoHTML='".$formato."' ";
							$alineacion=$filaE[16];
							if($alineacion=="")
								$alineacion=0;
							$paramAdicionales.=" alineacion='".$alineacion."' ";
						break;
					}
					
					if($maxAncho!="")
						$estilosAdicionales.="width:".$maxAncho."px;";
					if($filas[2]==1)
					{
						$estilosAdicionales.="width: ".$filaE[2]."px;height: ".$filaE[3]."px";
					}

						
					$HRef="";
					$cHRef="";
					if($filaE[5]!="")
					{
						$HRef="<a id='link_".$filas[0]."' href='javascript:doNothing()'>";
						$cHRef="</a>";	
					}
					$etiqueta="<div style='".$estilosAdicionales."' class='".$filaE[13]."' id='_lbl".$filas[0]."' enlace='".$filaE[5]."'>".$HRef.'<span id="sp_'.$filas[0].'">'.$filas[1]."</span>".$cHRef."</div>";
				break;
			}
			
			if($filas[6]=="1")
			{
				$btnEliminar='&nbsp;<a href="javascript:eliminarElemento(\''.$filas[0].'\')"><img src="../images/formularios/cross.png" height="10" width="10" title="'.$et["lblEliminarElem"].'" alt="'.$et["lblEliminarElem"].'" /></a>';
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
				$queryAux10="select nombreCampo from 937_elementosVistaFormulario where idGrupoElemento=".$filas[0]." and idIdioma=".$fila5[0];
				$valorEt=$con->obtenerValor($queryAux10);
				if($filas[2]=="23")
				{
					$valorEt=str_replace("[","",$valorEt);
					$valorEt=str_replace("]","",$valorEt);		
				}
				$tabla.="<input type='hidden' id='td_".$filas[0]."_".$fila5[0]."' value='".$valorEt."'>";
			}
								
			$tabla.=	"</td><td valign='top'>".$btnEliminar."	</td>
                    		</tr>
    					</table>";
			$tipoControl="1";
			$ctrlInterno="_lbl".$filas[0]."_".$tipoControl;
			switch($filas[2])
			{
				case "13":
					$tipoControl=13;
				break;
				case "23":
					$ctrlInterno=$nombreControl."_23";
				break;
			}
				
			$div="<div ".$paramAdicionales." maxAncho='".$maxAncho."'  id='div_".$filas[0]."' style='top:".$filas[5]."px; left:".$filas[4]."px; position:absolute;".$estiloDiv."' onmousedown='comienzoMovimiento(event, this.id);' onmouseover='this.style.cursor=\"move\"' controlInterno='".$ctrlInterno."' ctrlRef='".$filas[7]."' ".$ignorarLimites." tipoCtrl='".$filas[2]."'>".$tabla."</div>";			
			echo $div;
			$calibrarCtrl.="calibrarCtrl[".$cc."]='div_".$filas[0]."';";
			$cc++;
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
<?php
	$mostrarUsuario=false;
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
<script type="text/javascript" src="../Scripts/ux/grid/GridSummary.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ux/grid/GridSummary.css">
<link rel="stylesheet" type="text/css" href="../Scripts/ux/grid/RowEditor.css"/>
<script type="text/javascript" src="../Scripts/ux/grid/RowEditor.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/Ext.ux.FCKEditor/FCKeditor.css" />
<link rel="stylesheet" type="text/css" href="../Scripts/ext/ux/file-upload.css" />
<script type="text/javascript" src="../Scripts/fckeditor/fckeditor.js"></script>
<script type="text/javascript" src="../Scripts/Ext.ux.FCKEditor/FCKeditor.js"></script>
<script type="text/javascript" src="../Scripts/ext/ux/FileUploadField.js"></script>
<script type="text/javascript" src="../Scripts/Ext.ux.FCKEditor/visorImg.js.php"></script>
<script type="text/javascript" src="../Scripts/Ext.ux.FCKEditor/construyeFCKEditor.js"></script>
<script type="text/javascript" src="Scripts/gridVistaFormulario.js.php"></script> 
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
<script type="text/javascript" src="Scripts/funcionesFormulario.js.php"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ux/colorField/ext.ux.ColorField.css" />
<script type="text/javascript" src="../Scripts/ux/colorField/ext.ux.ColorField.js"></script>
<?php
	
	$mostrarRegresar=false;
	$respetarEspacioRegresar=true;
	
	
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
                  	<td></td>
                    <td>
                    	<input type="button" class="botonAddEtiqueta" alt="<?php echo $et["lblInsEt"] ?>" title="<?php echo $et["lblInsEt"] ?>" onClick="lanzarVentanaConfiguracion(1)" />
                        <span id="btnUrl"><input type="button" class="botonAddLink" alt="Agregar hiperenlace" title="Agregar hiperenlace" onClick="mostrarVentanaHiperEnlace()" /></span>
                        <input type="button" class="botonAddCtrlFrm" alt="Agregar campo de formulario asociado" title="Agregar campo de formulario asociado" onClick="mostrarVentanaAgregarValorFormularioAsoc()" />
                        <input type="button" class="botonAddFrame" alt="<?php echo $et["lblInsFrame"] ?>" title="<?php echo $et["lblInsFrame"] ?>" onClick="lanzarVentanaConfiguracion(13)" />
                        <input type="button" class="botonCrearEstilo" alt="Crear estilo" title="Crear estilo" onClick="mostrarVentanaEstilos()" id="btnEstilos"  />
                        <input type="button" class="botonImagen" alt="Insertar imagen" title="Insertar imagen" onClick="mostrarVentanaImagenes()" id="btnImagen"  />
                        <input type="button" class="botonReset" alt="Reiniciar Vista" title="Reiniciar Vista" onClick="reiniciarVista()" id="btnBorrarFormulario"  />
                        <br /><br />
                    </td>
                  </tr>
                   <tr >
                   		<?php 
							$idFormulario="-1";
							if(isset($objParametros->idFormulario))
								$idFormulario=$objParametros->idFormulario;
								
								
							
							$vistaIframe=0;
							
							if(isset($objParametros->vistaIframe))
								$vistaIframe=$objParametros->vistaIframe;	
								
							$consulta="select idFormulario from  939_configuracionVistaFormularios where idFormulario=".$idFormulario;

							$frmId=$con->obtenerValor($consulta);
							if($frmId=="")
							{
								$consulta="select anchoGrid,altoGrid,nombreTabla from 900_formularios where idFormulario=".$idFormulario;
								$filaFormulario=$con->obtenerPrimeraFila($consulta);
								$consulta="insert into 939_configuracionVistaFormularios(idFormulario,anchoGrid,altoGrid,nombreTabla) values (".$idFormulario.",".$filaFormulario[0].",".$filaFormulario[1].",'".$filaFormulario[2]."')";
								if(!$con->ejecutarConsulta($consulta))
									return;
							}
								
							$funcionesJava="";
							$calibrarCtrl="var calibrarCtrl=new Array();";
							$cc=0;
														
							$query="select nombreTabla,anchoGrid,altoGrid,mostrarMarco  from 939_configuracionVistaFormularios where idFormulario=".$idFormulario;
							$fila=$con->obtenerPrimeraFila($query);
							$nTabla=$fila[0];
							$anchoGrid=$fila[1];
							$altoGrid=$fila[2];
							$mMarco=$fila[3];
							if(!crearTablaFormulario($nTabla))
								return;
							
							$numElementos=0;
							$nElementosFocus=0;
							$arrElementosFocus="var arrElementosFocus=new Array();";
							$consulta="select titulo,idProceso from 900_formularios where idFormulario=".$idFormulario;
							$fila=$con->obtenerPrimeraFila($consulta);
							$titulo=$fila[0];
							$tituloC=$fila[0];
							$idProceso=$fila[1];
							$claseFrame="frameHijo gridRejilla";
							if($mMarco==0)
							{
								$titulo="";
								$claseFrame="gridRejilla";
							}
							
						?>
                        <script type="text/javascript" src="Scripts/configurarVistaFormulario.js.php?idFormulario=<?php echo $idFormulario ?>"></script>
                       <td width="300" valign="top">
                          <table >
                              <tr>
                                  <td align="left">
                                      <input type="button" value="<?php echo $et["lblFinalizar"]?>" class="btnFinalizar"  onclick="<?php echo ($vistaIframe==0)?"regresarPagina()":"window.parent.cerrarVentanaFancy()"?>"/>
                                     <input type="hidden" name="idFormulario" id="idFormulario" value="<?php echo $idFormulario?>" />
                                      <input type="hidden" name="idProceso" id="idProceso" value="<?php echo $idProceso ?>" />
                                       <br />
                                  </td>
                              </tr>
                              <tr>
                                  <td>
                                  <fieldset class="frameHijo" style="background-color:#FFF"><legend><b><?php echo $et["lblTamGrid"]?></b></legend>
                                  <table >
                                      <tr height="23">
                                          <td><span class="letraFicha"><?php echo $et["lblAncho"]?>:</span></td>
                                          <td><span id='divAncho'></span><span class="letraFicha"> px</span></td>
                                      </tr>
                                      <tr height="23">
                                          <td><span class="letraFicha"><?php echo $et["lblAlto"]?>:</span></td>
                                          <td><span id='divAlto'></span><span class="letraFicha"> px</span></td>
                                      </tr>
                                      <tr>
                                          <td colspan="2" class="letraFicha">
                                          <br />
                                          <input type="checkbox" id='verGrid' onClick="mostrarRejila(this)" checked="checked" />&nbsp;&nbsp;<?php echo $et["lblVerGrid"]?> 
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="2" class="letraFicha">
                                          <?php
                                              $mostrarMarco="";
                                              if($mMarco==1)
                                                  $mostrarMarco="checked='checked'";
                                              
                                          ?>
                                          <input id='verMarco' type="checkbox" onClick="mostrarMarcoV(this)" <?php echo $mostrarMarco?> />&nbsp;&nbsp;Mostrar marco
                                          <input type="hidden" id="titulo" value="<?php echo $tituloC ?>" />
                                          </td>
                                      </tr>
                                  </table>
                                  </fieldset>
                                  <br />
                                  </td>
                              </tr>
                              <tr>
                                  <td >
                                      <div id="tblPropiedades">
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td >
                                      <br />
                                      <br />
                                      <!--<div id='tblHidden'>
                                          <?php
                                              $query="select idGrupoElemento,nombreCampo,tipoElemento,obligatorio,posX,posY from 937_elementosVistaFormulario where tipoElemento=20 and idFormulario=".$idFormulario;
                                              $res=$con->obtenerFilas($query);
                                              while($fila=mysql_fetch_row($res))
                                              {
                                                  $nombreControl=generarNombre($fila[1],$fila[2]);	
                                                  $consulta="select * from 938_configuracionElemVistaFormulario where idElemFormulario=".$fila[0];
                                                  $filaE=$con->obtenerPrimeraFila($consulta);
                                                  $btnEliminar='<div style="z-index:10000" >&nbsp;<a href="javascript:eliminarElemento(\''.$fila[0].'\')"><img src="../images/formularios/cross.png" height="10" width="10" title="'.$et["lblEliminarElem"].'" alt="'.$et["lblEliminarElem"].'" /></a></div>';
                                                  
                                                  $etiqueta= "<input type='hidden' value='".$filaE[2]."' id='tipo".$nombreControl."'><input type='hidden' value='".$filaE[3]."' id='actualizable".$nombreControl."'><input type='text' name='".$nombreControl."' id='".$nombreControl."' size='15' value='".$fila[1]."' readOnly>";
                                                  $tabla=	 "	<table class='tablaControl'  >
                                                              <tr >
                                                                  <td valign='top' id='td_obl_".$fila[0]."'></td>
                                                                  <td id='td_".$fila[0]."' class=''>".$etiqueta."</td><td valign='top'>".$btnEliminar."</td>
                                                              </tr>
                                                          </table>";
                                                  $div="<div id='div_".$fila[0]."'  class=''  controlInterno='".$nombreControl."_".$fila[2]."' movible='false'  onmousedown='comienzoMovimiento(event, this.id);' >".$tabla."</div>";			
                                                  echo $div;
                                              }
                                              
                                          ?>
                                      </div>-->
                                  </td>
                              </tr>
                          </table>
                          <input type="hidden" id='hAncho' value="<?php echo $anchoGrid?>" />
                          <input type="hidden" id='hAlto' value="<?php echo $altoGrid?>" />
                          <input type="hidden" id="hNElementos" value="<?php echo $numElementos++ ?>" />
                       </td>
                       
                       <td  height="<?php echo $altoGrid?>px" id='tdContenedor' valign="top"  width="<?php echo $anchoGrid?>px">
                       <fieldset class="<?php echo $claseFrame?>"  id='frameTitulo' style="height:<?php echo $altoGrid?>px; width:<?php echo $anchoGrid?>px;"  ><legend id='lblLegend'><b><?php echo $titulo ?></b></legend>
                             
                        		<input type="hidden" name="hIdidioma" id="hIdidioma" value="<?php echo $_SESSION["leng"] ?>" />
                            </fieldset>
                           
                           <?php
						   		crearElementosFormulario();
						   ?>
                           
                        </td>
                        <td >&nbsp;
                        <input type="hidden" id="vistaIframe" value="<?php echo $vistaIframe?>" />
                        <input type="hidden" id="hNElementos" value="<?php echo $numElementos++ ?>" />
                        </td>
                        <script>
							<?php 
							echo $funcionesJava;
							echo $calibrarCtrl;
							echo $arrElementosFocus;
							?>
							
						</script>
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
