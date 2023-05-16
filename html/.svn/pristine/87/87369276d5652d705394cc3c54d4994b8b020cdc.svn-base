<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");

function generarFicha($idActividad)
{
	global $con;	
	/*$consulta="select a.actividad,p.actividad,tipoActividadProgramada,pr.tipoReporte,fechaInicio,fechaFin,idProcesoAsociado,idReferencia,horasTotal,
				idUsuario,reportaAvance,a.idTipoReporte from 965_actividadesUsuario a,967_prioridadActividad p,
				980_tiposReporte pr where pr.idTipoReporte=a.idTipoReporte and p.idPrioridad=a.prioridad and a.idActividadPrograma=".$idActividad;*/
	$consulta="select a.actividad,p.actividad,tipoActividadProgramada,(select tipoReporte from 980_tiposReporte where idTipoReporte=a.idTipoReporte  ) as tipoReporte,fechaInicio,fechaFin,idProcesoAsociado,idReferencia,horasTotal, idUsuario,reportaAvance,a.idTipoReporte from 965_actividadesUsuario a,967_prioridadActividad p where p.idPrioridad=a.prioridad and a.idActividadPrograma=".$idActividad;

	$fila=$con->obtenerPrimeraFila($consulta);
	
	$tipoActividad="Libre";
	if($fila[2]=="2")
		$tipoActividad="Asociada a un objeto de un proceso";
	$porcentaje=obtenerAvanceActividadUsuario($idActividad);
	$consulta="select concat(if(Prefijo is null,'',Prefijo),' ',Nombre) from 802_identifica where idUsuario=".$fila[9];
	$responsable=$con->obtenerValor($consulta);
	$consulta="select situacion from 973_reporteActividades where idActividad=".$idActividad;
	$resReportes=$con->obtenerFilas($consulta);
	$nReportes=$con->filasAfectadas;
	$reportesRealizados=0;
	while($fReporte=mysql_fetch_row($resReportes))
	{
		if($fReporte[0]=="2")
			$reportesRealizados++;
	}
	
?>
	<table >
    	<tr>
        	<td valign="top" align="center" width="120">
            	<img height="120" width='100' src='../Usuarios/verFoto.php?Id="<?php echo $fila[9];?>"'/>	
            </td>
            <td>
            	<table>
                <tr>
                    <td>
                        <table>
                        <tr>
                            <td class="esquinaFicha" align="left" width="200"><span class="corpo8_bold">
                                Actividad:</span>
                            </td>
                            <td class="valorFicha" align="left" width="400">
                                <span class="letraRojaSubrayada8">
                                <?php 
                                    echo $fila[0];
                                ?>
                                </span>
                            </td>
                        </tr>
                         
                        <tr>
                            <td class="etiquetaFicha" align="left">
                                <span class="corpo8_bold">
                                Prioridad:
                                </span>
                            </td>
                            <td class="valorFicha" align="left">
                                <span class="corpo8">
                                <?php 
                                    echo $fila[1];
                                ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="etiquetaFicha" align="left">
                                <span class="corpo8_bold">
                                Responsable:
                                </span>
                            </td>
                            <td class="valorFicha" align="left">
                                <span class="corpo8">
                                <a href="javascript:verUsr('<?php echo base64_encode($fila[9])?>')">
                                <?php 
                                    echo $responsable;
                                ?>
                                </a>
                                </span>
                            </td>
                        </tr>
                         <tr>
                            <td class="etiquetaFicha" align="left">
                                <span class="corpo8_bold">
                                Periodicidad de reportes:
                                </span>
                            </td>
                            <td class="valorFicha" align="left">
                                <span class="corpo8">
                                <?php 
                                    echo $fila[3];
                                ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="etiquetaFicha" align="left">
                                <span class="corpo8_bold">
                                Fecha de inicio:
                                </span>
                            </td>
                            <td class="valorFicha" align="left">
                                <span class="corpo8">
                                <?php 
                                    echo date('d/m/Y',strtotime($fila[4]));
                                ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="etiquetaFicha" align="left">
                                <span class="corpo8_bold">
                                Fecha de fin:
                                </span>
                            </td>
                            <td class="valorFicha" align="left">
                                <span class="corpo8">
                                <?php 
                                    echo date('d/m/Y',strtotime($fila[5]));
                                ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                          <td class="etiquetaFicha" align="left">
                              <span class="corpo8_bold">
                              Total horas comprometidas:
                              </span>
                          </td>
                          <td class="valorFicha" align="left">
                              <span class="corpo8">
                              <?php 
                                  echo $fila[8]
                              ?>
                              </span>
                          </td>
                      </tr>
                      <tr>
                        <td class="etiquetaFicha" align="left">
                            <span class="corpo8_bold">
                            Tipo de reportes:
                            </span>
                        </td>
                        <td class="valorFicha" align="left">
                            <span class="corpo8">
                            <?php 
                                echo $fila[3];
                            ?>
                            </span>
                        </td>
                    </tr>
                      <?php
						  if(($fila[11]!="1")&&($fila[11]!=""))
						  {
					  ?>
					  <tr>
						  <td class="etiquetaFicha" align="left">
							  <span class="corpo8_bold">
							  Reportes realizados:
							  </span>
						  </td>
						  <td class="valorFicha" align="left">
							  <span class="corpo8">
								  <a href="javascript:verReportes('<?php echo base64_encode($idActividad)?>')">
								  <?php
									  echo $reportesRealizados."/".$nReportes;
								  ?>
								  </a>
							  </span>
						  </td>
					  </tr>
					  <?php
						  }
						  if($fila[10]=='1')
						  {
					  ?>
					  <tr>
						  <td class="etiquetaFicha" align="left">
							  <span class="corpo8_bold">
							  Porcentaje de avance:
							  </span>
						  </td>
						  <td class="valorFicha" align="left">
							  <span class="corpo8">
							  <?php 
								 echo $porcentaje." %";
							  ?>
							  </span>
						  </td>
					  </tr>
					  <?php
						  }
					  ?>
                        <tr>
                          <td colspan="2" align="center">
                                  <br />
                                  <fieldset class="frameHijo" style=" text-align:left;"><legend><b>Sesiones de trabajo planeadas</b></legend><br />
                                 
                                  <table width="600"  >
                                      
                                      <tr>
                                          <td align="center" class="letraFicha">Semana</td>
                                          <td align="center"  class="letraFicha">Del</td>
                                          <td align="center"  class="letraFicha">Al</td>
                                          <td align="center"  class="letraFicha">Sesiones de trabajo</td>
                                          <td align="center"  class="letraFicha">Horas planeadas
                                          </td>
                                           <td>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="3"><br />
                                          </td>
                                      </tr>
                                      <?php
                                      $arrSemanas=obtenerSemanasTrabajo($fila[4],$fila[5]);
                                      $horasGlobalTotal=0;
                                      foreach($arrSemanas as $semana)
                                      {
                                      ?>
                                          <tr>
                                              <td align="center" class="valorFicha">
                                                  <span class="copyrigth">
                                                      <?php echo $semana["nSemana"] ?>.-
                                                  </span>
                                              </td>
                                              <td class="valorFicha">
                                                  <span class="copyrigth">
                                                      <?php echo date('d/m/Y',$semana["fechaI"]) ?> 
                                                  </span>
                                              </td>
                                              <td class="valorFicha">
                                                  <span class="copyrigth">
                                                      <?php echo date('d/m/Y',$semana["fechaF"]) ?>
                                                  </span>
                                              </td>
                                              <td class="valorFicha" align="center">
                                                  <table>
                                                  <tr>
                                                      <td align="left">
                                                      <a href="javascript:verSesionesTrabajo('<?php echo $semana["fechaI"] ?>','<?php echo $semana["fechaF"] ?>','<?php echo base64_encode($idActividad)?>','<?php echo $semana["nSemana"] ?>')">
                                                           <span class="copyrigth">
                                                      <?php
                                                          $consulta="select count(fecha) from 4089_calendario where tipo=2 and lugar='".$idActividad."' and fecha>='".date('Y-m-d',$semana["fechaI"])."' and fecha<='".date('Y-m-d',$semana["fechaF"])."'";
                                                          $sesiones=$con->obtenerValor($consulta);
                                                          echo $sesiones;
                                                      ?>
                                                          
                                                          </span>
                                                      </a>
                                                      </td>
                                                  </tr>
                                                  </table>
                                              </td>
                                              <td class="valorFicha" align="center">
                                                  <span class="copyrigth">
                                              <?php
                                                  
                                                  $consulta="select inicio,final from 4089_calendario where tipo=2 and lugar='".$idActividad."' and fecha>='".date('Y-m-d',$semana["fechaI"])."' and fecha<='".date('Y-m-d',$semana["fechaF"])."'";
                                                  $resHorasP=$con->obtenerFilas($consulta);
                                                  $nHorasPlaneadas=0;	
                                                  while($filasP=mysql_fetch_row($resHorasP))
                                                  {
                                                      $nHorasPlaneadas+=date("g",restaHoras($filasP[0],$filasP[1]));
                                                  }
                                                  $horasGlobalTotal+=$nHorasPlaneadas;
                                                  echo $nHorasPlaneadas;
                                              ?>
                                                  </span>
                                              </td>
                                              <td class="valorFicha" align="center">
                                                <a href="javascript:verSesionesTrabajo('<?php echo $semana["fechaI"] ?>','<?php echo $semana["fechaF"] ?>','<?php echo base64_encode($idActividad)?>','<?php echo $semana["nSemana"] ?>')">
                                                    &nbsp;<img src="../images/magnifier.png" width="16" height="16" alt='Ver sesiones de trabajo' title="Ver sesiones de trabajo" />
                                                </a>
                                            </td>
            
                                          </tr>
                                      <?php
                                      }
                                      ?>
                                      <tr>
                                          <td colspan="2">
                                          </td>
                                          <td colspan="2" class="etiquetaFicha" align="right">
                                          <span class="corpo8_bold">
                                              Total horas planeadas:&nbsp;
                                          </span>
                                          </td>
                                          
                                          <td  align="center" class="valorFicha">
                                              <span class="letraRoja">
                                              <?php 
                                                  echo $horasGlobalTotal;
                                              ?>
                                              </span>
                                          </td>
                                          <td>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="6"><br />
                                          </td>
                                      </tr>
                                  </table>
                                  </span>
                                  </fieldset>
                              
                             
                          </td>
                      </tr>
                        
                        <tr>
                            <td colspan="2" class="">
                                <br />
                                <fieldset class="frameHijo"><legend><b>L&iacute;neas de acci&oacute;n:</b></legend>
                                <table width="100%">
                             <?php
							 
								
							?>
							
								<tr>
									<td>
									</td>
									<td align="center">
										<span class="letraFicha">L&iacute;nea de acci&oacute;n</span>
									</td>
									<td align="center">
										<span class="letraFicha">
										L&iacute;nea de investigaci&oacute;n
										</span>
									</td>
								</tr>
							<?php
							
							
								$consulta="select la.txtLineaAccion,(select txtLineaInv from 243_lineasInvestigacion li where li.id_243_lineasInvestigacion=aa.idLineaInvestigacion) as lineaInv from 244_lineasAccion la,969_actividadesLineasAccion aa where aa.idLineaAccion=la.id_244_lineasAccion and  idActividad=".$idActividad;
							
									
								
								$res=$con->obtenerFilas($consulta);
								$ct=1;
								while($f=mysql_fetch_row($res))
								{
									
									
								?>
                                <tr height="21">
                                    <td width="10%" class="valorFicha" >
                                        <span class="copyrigth">
                                        <?php echo $ct;?>.- 
                                        </span>
                                    </td>
                                    <td class="valorFicha" align="left">
                                        <span class="copyrigth">
                                        <?php echo $f[0];?>
                                        </span>
                                    </td>
                                     <td class="valorFicha" align="left">
                                        <span class="copyrigth">
                                        <?php echo $f[1];?>
                                        </span>
                                    </td>
                                </tr>
								 <?php
									
									$ct++;
								}
							 ?>
							 
                             
                                </table>
                                </fieldset>
                                <br />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="">
                                <br />
                                <fieldset class="frameHijo"><legend><b>Productos esperados:</b></legend>
                                <table width="100%">
                             <?php
                                $consulta="select producto from 970_actividadesVSProductos where idActividad=".$idActividad;
                                $res=$con->obtenerFilas($consulta);
                                $ct=1;
                                while($f=mysql_fetch_row($res))
                                {
                                ?>
                                <tr>
                                    <td width="10%" class="valorFicha" align="center">
                                        <span class="copyrigth">
                                        <?php echo $ct;?>.- 
                                        </span>
                                    </td>
                                    <td class="valorFicha" align="left">
                                        <span class="copyrigth">
                                        <?php echo $f[0];?>
                                        </span>
                                    </td>
                                </tr>
                                <?php	
                                    $ct++;
                                }
                             ?>
                             
                                </table>
                                </fieldset>
                                <br />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="">
                                <br />
                                <fieldset class="frameHijo"><legend><b>Metas esperadas:</b></legend>
                                <table width="100%">
                             <?php
                                $consulta="select meta from 971_actividadesVSMetas where idActividad=".$idActividad;
                                $res=$con->obtenerFilas($consulta);
                                $ct=1;
                                while($f=mysql_fetch_row($res))
                                {
                                ?>
                                <tr>
                                    <td width="10%" class="valorFicha" align="justify">
                                        <span class="copyrigth">
                                        <?php echo $ct;?>.- 
                                        </span>
                                    </td>
                                    <td class="valorFicha" align="left">
                                        <span class="copyrigth">
                                        <?php echo $f[0];?>
                                        </span>
                                    </td>
                                </tr>
                                <?php	
                                    $ct++;
                                }
                             ?>
                             
                                </table>
                                </fieldset>
                                <br />
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2" class="">
                                <br />
                                <fieldset class="frameHijo"><legend><b>Elementos de CV con lo que se puede vincular la actividad:</b></legend>
                                <table width="100%">
                             <?php
                                $consulta="select nombre from 972_actividadesVSElementosCV,4001_procesos where idProceso=idElementoCV and idActividad=".$idActividad;
                                $res=$con->obtenerFilas($consulta);
                                $ct=1;
                                while($f=mysql_fetch_row($res))
                                {
                                ?>
                                <tr>
                                    <td width="10%" class="valorFicha" align="justify">
                                        <span class="copyrigth">
                                        <?php echo $ct;?>.- 
                                        </span>
                                    </td>
                                    <td class="valorFicha">
                                        <span class="copyrigth" align="left">
                                        <?php echo $f[0];?>
                                        </span>
                                    </td>
                                </tr>
                                <?php	
                                    $ct++;
                                }
                             ?>
                             
                                </table>
                                </fieldset>
                                <br />
                            </td>
                        </tr>
                        
                        
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
	$guardarConfSession=true;
	$mostrarMenuIzq=false;
	$mostrarTitulo=false;
	$mostrarPiePag=false;
	
?>
<script type="text/javascript" src="Scripts/fichaActividadProceso.js.php"></script>
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
                        <td align="center"><br /><br />
                                <?php
                                    $idActividad=base64_decode($objParametros->idActividad);
                                    generarFicha($idActividad);
                                ?>
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
