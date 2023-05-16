<?php 
include("conexionBD.php"); 

extract($_POST);
?>

<html>
<body>
<?php
$x=0;
$query="begin";
$enviarFrm=false;
$tipoEnvio="1";
if($con->ejecutarConsulta($query))
{
	if($idTipoProceso=="-1")
	{
		$tipoEnvio="0";
		$query="insert into 921_tiposProceso(tipoProceso,descripcion) values('".cv($nCategoria)."','".cv($descripcion)."')";
		if($con->ejecutarConsulta($query))	
			$idTipoProceso=$con->obtenerUltimoID();
		else
			return;
	}
	else
	{
		$consulta[$x]="update 921_tiposProceso set tipoProceso='".cv($nCategoria)."',descripcion='".cv($descripcion)."' where idTipoProceso=".$idTipoProceso;
		$x++;
	}
	$consulta[$x]="delete from 936_vistasProcesos where tipoProceso=".$idTipoProceso;
	$x++;
	$consulta[$x]="insert into 936_vistasProcesos(tipoProceso,pagVista,accion) values(".$idTipoProceso.",'".cv($pAgregar)."',0) ";
	$x++;
	$consulta[$x]="insert into 936_vistasProcesos(tipoProceso,pagVista,accion) values(".$idTipoProceso.",'".cv($pConsultar)."',1) ";
	$x++;
	$consulta[$x]="insert into 936_vistasProcesos(tipoProceso,pagVista,accion) values(".$idTipoProceso.",'".cv($pModificar)."',2) ";
	$x++;
	$consulta[$x]="insert into 936_vistasProcesos(tipoProceso,pagVista,accion) values(".$idTipoProceso.",'".cv($pEscenario)."',3) ";
	$x++;
	$consulta[$x]="commit";
	$x++;
	if($con->ejecutarBloque($consulta))
		$enviarFrm=true;	
}
if($tipoEnvio=="1")
	enviarPagina("../procesos/tblTiposProceso.php");
else
{
	$arrParam[0][0]="idTipoProceso";
	$arrParam[0][1]=$idTipoProceso;
	enviarPagina("../procesos/tiposProceso.php",$arrParam);
}
?>
</body>
</html>