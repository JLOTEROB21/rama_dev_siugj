<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/hayas.css.php" media="screen" />
<link rel="stylesheet" type="text/css" href="../estilos/estilos.css" media="screen" />
<script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>
<style type="text/css">
<!--
@import url("../css/estiloFicha.css");
-->
</style>
<script>
	var f=window.parent;
</script>
<?php
$paramPOST=true;
$paramGET=false;
$arrPOST=array_values($_POST);
$ctPOST=sizeof($arrPOST);
$arrGET=array_values($_GET);
$ctGET=sizeof($arrGET);
$arrValores=null;
$arrLlaves=null;
$nomPagina=$_SERVER["PHP_SELF"];
$arrPagina=	explode("/",$nomPagina);
$nElementos=sizeof($arrPagina);
$nomPagina=$arrPagina[$nElementos-1];
$rutaNomPagina=$arrPagina[$nElementos-2]."/".$arrPagina[$nElementos-1];
$arrPagina=explode(".",$nomPagina);
$nomPagina=$arrPagina[0];
$guardarConfSession=true;
$pagRegresar="../principal/inicio.php";
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
<title><?php echo $tituloPagina ?></title>
</head>
<body>
	<?php
		$idUsuario="-1";
		if(isset($objParametros->idUsuario))
			$idUsuario=base64_decode($objParametros->idUsuario);
			
		$consulta="SELECT o.codigoDepto,unidad FROM  817_organigrama o,801_adscripcion a WHERE a.codigoUnidad=o.codigoUnidad AND a.idUsuario=".$idUsuario;
		$filaAds=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT unidad FROM  817_organigrama o,801_adscripcion a WHERE a.Institucion=o.codigoUnidad AND a.idUsuario=".$idUsuario;
		$institucion=$con->obtenerValor($consulta);
		if($institucion=="")
		{
			$institucion="No adcrito a alguna instituci&oacute;n";
		}
		?>
        
    <table width="100%">
    	
        <tr>
        	<td>
            	<br />
            	<table>
                <tr>
                <td valign="top" >
		            &nbsp;<span class="corpo8_bold">Usuario:</span>&nbsp;&nbsp;
            	</td>
                <td valign="top">
                	<span class="copyrigthSinPadding">
                	<?php echo obtenerNombreUsuario($idUsuario)?>
                    </span>
                </td>
                </tr>
                </table>
            </td>
        </tr>
    	<tr>
        	<td align="center">
            <br />
            <img height="120" width='100' src='verFoto.php?Id="<?php echo $idUsuario;?>"'/>	
            </td>
        </tr>
        <tr height="27">
        	<td>
	           	<table>
                <tr>
                <td valign="top" >
		            &nbsp;<span class="corpo8_bold">Clave Empleado:</span>&nbsp;&nbsp;
            	</td>
                <td valign="top">
                	<span class="copyrigthSinPadding">
                	<?php echo $idUsuario?>
                    </span>
                </td>
                </tr>
                </table>
            </td>
        </tr>
         <tr height="27">
        	<td>
            	<table>
                <tr>
                <td valign="top" >
		            &nbsp;<span class="corpo8_bold">Instituci&oacute;n:</span>&nbsp;&nbsp;
            	</td>
                <td valign="top">
                	<span class="copyrigthSinPadding">
                	<?php 
					
						echo $institucion;
					?>

                    </span>
                </td>
                </tr>
                </table>
            </td>
        </tr>
    	<tr height="27">
        	<td>
            	<table>
                <tr>
                <td valign="top" >
		            &nbsp;<span class="corpo8_bold">Departamento:</span>&nbsp;&nbsp;
            	</td>
                <td>
                </td>
        		</tr>
                <tr>
                <td valign="top" colspan="2">
                	<span class="copyrigthSinPadding">
                	<?php 
						if($filaAds[1]!="")
						{
							echo "[".str_replace(".","",$filaAds[0])."] ".$filaAds[1];	
						}
						else
						{
							echo "A&uacute;n no ha sido asignado a un departamento";	
						}
					
					?>
                    </span>
                </td>
                </tr>
                </table>
            </td>
        </tr>
    </table>    
    <table id="hor-minimalist-b" >
    <thead>
    	<tr>
        	<th colspan="3">
            	Nómina
            </th>
        </tr>
    </thead>
	<tbody>
        <tr>
        	<td width="18"><img src="../images/bullet_green.png" /></td>
            <td colspan="2"><a href="javascript:configurarAdscripcion()"><span class="letraFichaRespuesta">Adscripción</span></a></td>
        </tr>
        <!--<tr>
        	<td width="18"><img src="../images/bullet_green.png" /></td>
            <td colspan="2"><a href="javascript:verBeneficiarios()"><span class="letraFichaRespuesta">Beneficiarios</span></a></td>
        </tr>-->
        <tr>
        	<td width="18"><img src="../images/bullet_green.png" /></td>
            <td colspan="2"><a href="javascript:verCalculosNomina()"><span class="letraFichaRespuesta">Cálculos nomina</span></a></td>
        </tr>
        <tr>
        	<td width="18"><img src="../images/bullet_green.png" /></td>
            <td colspan="2"><a href="javascript:verCuentasBancarias()"><span class="letraFichaRespuesta">Cuentas bancarias</span></a></td>
        </tr>
        <tr>
        	<td width="18"><img src="../images/bullet_green.png" /></td>
            <td colspan="2"><a href="javascript:verFump()"><span class="letraFichaRespuesta">FUMP</span></a></td>
        </tr>
         <tr>
        	<td width="18"><img src="../images/bullet_green.png" /></td>
            <td colspan="2"><a href="javascript:horarioLaboral()"><span class="letraFichaRespuesta">Horario laboral</span></a></td>
        </tr>
        <!--<tr>
        	<td width="18"><img src="../images/bullet_green.png" /></td>
            <td colspan="2"><a href="javascript:verDeduccionesIndividuales()"><span class="letraFichaRespuesta">Deducciones individuales</span></a></td>
        </tr>
        <tr>
        	<td width="18"><img src="../images/bullet_green.png" /></td>
            <td colspan="2"><a href="javascript:verPercepcionesIndividuales()"><span class="letraFichaRespuesta">Percepciones individuales</span></a></td>
        </tr>-->
         
       
	</tbody>
    </table>
    <!--<table id="hor-minimalist-b" >
    <thead>
    	<tr>
        	<th colspan="3">
            	Permisos
            </th>
        </tr>
    </thead>
	<tbody>
        <tr>
        	<td width="18"><img src="../images/bullet_green.png" /></td>
            <td colspan="2"><a href="javascript:verDiasEconomicos()"><span class="letraFichaRespuesta">Días económicos</span></a></td>
        </tr>
        
        <tr>
        	<td width="18"><img src="../images/bullet_green.png" /></td>
            <td colspan="2"><a href="javascript:()"><span class="letraFichaRespuesta">Jutificación de faltas</span></a></td>
        </tr>
        <tr>
        	<td width="18"><img src="../images/bullet_green.png" /></td>
            <td colspan="2"><a href="javascript:()"><span class="letraFichaRespuesta">Jutificación de retardos</span></a></td>
        </tr>
         <tr>
        	<td width="18"><img src="../images/bullet_green.png" /></td>
            <td colspan="2"><a href="javascript:verLicencias()"><span class="letraFichaRespuesta">Licencias</span></a></td>
        </tr>
        <tr>
        	<td width="18"><img src="../images/bullet_green.png" /></td>
            <td colspan="2"><a href="javascript:verVacaciones()"><span class="letraFichaRespuesta">Vacaciones</span></a></td>
        </tr>
	</tbody>
    </table>
    <table id="hor-minimalist-b" >
    <thead>
    	<tr>
        	<th colspan="3">
            	Servicios
            </th>
        </tr>
    </thead>
	<tbody>
    	  <tr>
        	<td width="18"><img src="../images/bullet_green.png" /></td>
            <td colspan="2"><a href="javascript:verPercepcionesIndividuales()"><span class="letraFichaRespuesta">Ahorros</span></a></td>
        </tr>
        <tr>
        	<td width="18"><img src="../images/bullet_green.png" /></td>
            <td colspan="2"><a href="javascript:verDeduccionesIndividuales()"><span class="letraFichaRespuesta">Comedor</span></a></td>
        </tr>
        <tr>
        	<td width="18"><img src="../images/bullet_green.png" /></td>
            <td colspan="2"><a href="javascript:configurarAdscripcion()"><span class="letraFichaRespuesta">Estacionamientos</span></a></td>
        </tr>
        <tr>
        	<td width="18"><img src="../images/bullet_green.png" /></td>
            <td colspan="2"><a href="javascript:verPercepcionesIndividuales()"><span class="letraFichaRespuesta">Préstamos</span></a></td>
        </tr>
      
	</tbody>
    </table>-->
</body>
</html>