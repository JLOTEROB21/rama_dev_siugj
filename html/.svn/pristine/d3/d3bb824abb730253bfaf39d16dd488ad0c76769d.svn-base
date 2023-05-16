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
		if(isset($objParametros->idUsuario))
			$idUsuario=base64_decode($objParametros->idUsuario);
		
		$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$idUsuario. " and codigoRol not like '%_-1'";
		$roles=$con->obtenerListaValores($consulta,"'");
		
		$consulta="select * from 990_permisosReportes where tipoReporte=1 and rol in (".$roles.")";
		$con->obtenerFilas($consulta);
		$totalFilas=0;
		$fReporteMenciones=$con->filasAfectadas;
		$totalFilas+=$fReporteMenciones;
		$consulta="select * from 990_permisosReportes where tipoReporte=2 and rol in (".$roles.")";
		$con->obtenerFilas($consulta);
		
		$fReporteUsuarios=$con->filasAfectadas;
		$totalFilas+=$fReporteUsuarios;
		$consulta="select * from 990_permisosReportes where tipoReporte=3 and rol in (".$roles.")";
		$resProg=$con->obtenerFilas($consulta);
		
		$fReportePrograma=$con->filasAfectadas;
		$totalFilas+=$fReportePrograma;
	
		
		?>
    <table id="hor-minimalist-b" >
    <thead>
    	<tr>
        	<th colspan="3">
            	Opciones generales
            </th>
        </tr>
    </thead>
	<tbody>
        
        <tr>
        	<td width="18"><img src="../images/bullet_green.png" /></td>
            <td colspan="2"><a href="javascript:mostrarAgenda()"><span class="">Agenda</span></a></td>
        </tr>
       
        <tr>
        	<td width="18"><img src="../images/bullet_green.png" /></td>
            <td colspan="2"><a href="javascript:mostrarProgramaTrabajo()"><span class="">Programa de trabajo</span></a></td>
        </tr>

        
	</tbody>
    </table>
    <?php
	if($totalFilas>0)
	{
	?>
        <table id="hor-minimalist-b" >
        <thead>
            <tr>
                <th colspan="3">
                    Reportes
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            if($fReporteMenciones>0)
            {
            ?>
                <tr>
                    <td width="18"><img src="../images/bullet_green.png" /></td>
                    <td colspan="2"><a href="javascript:mostrarReporteMenciones()"><span class="">Menciones</span></a></td>
                </tr>
            <?php
            }
            if($fReportePrograma>0)
            {
            ?>
                 <tr>
                    <td width="18"><img src="../images/bullet_green.png" /></td>
                    <td colspan="2"><a href="javascript:mostrarReporteProgramaTrabajo()"><span class="">Programa de trabajo</span></a></td>
                </tr>
             <?php
            }
            if($fReporteUsuarios>0)
            {
            ?>
                <tr>
                    <td width="18"><img src="../images/bullet_green.png" /></td>
                    <td colspan="2"><a href="javascript:mostrarReporteUsuarios()"><span class="">Usuarios</span></a></td>
                </tr>
             <?php
            }
            ?>
           
    
            
        </tbody>
        </table>
    <?php
	}
	
	?>
    

</body>
</html>