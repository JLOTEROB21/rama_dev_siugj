<?php
session_start();
include("conexionBD.php");

$actualizacionCorrecta=false;

$consulta="SELECT * FROM 903_variablesSistema WHERE idVariable=1";
$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);	

$fechaActualiza=date("Y-m-d");

$fechaCambioContrasena="NULL";
$fechaLimiteCambioContrasena="NULL";
if($fRegistro["cantidadCambioCrontrasena"]>0)
{
	$fechaCambioContrasena=date("Y-m-d",strtotime("+".($fRegistro["cantidadCambioCrontrasena"]." ".($fRegistro["periodoCambioCrontrasena"]==0?" days":"months")),strtotime($fechaActualiza)));
	
	
	
	if($fRegistro["cantidadperiodoContrasenaDeshabilita"]>0)
	{
		$fechaLimiteCambioContrasena=	date("Y-m-d",strtotime("+".($fRegistro["cantidadperiodoContrasenaDeshabilita"]." ".
							($fRegistro["periodoContrasenaDeshabilita"]==0?" days":"months")),strtotime($fechaCambioContrasena)));
	}
	
	$fechaCambioContrasena="'".$fechaCambioContrasena."'";
	$fechaLimiteCambioContrasena="'".$fechaLimiteCambioContrasena."'";
	
}

$Contrasena=$_POST["Contrasena"];

$idUsuario=$_SESSION["idUsr"];
$valInicio="";
$valFin="";
$Contrasena=decodificarAES_Encrypt($Contrasena,$valInicio,$valFin);
$consulta_actualiza = "UPDATE 800_usuarios SET PASSWORD= HEX(AES_ENCRYPT('".$Contrasena."', '".bD($versionLatis)."')), cambiarDatosUsr='0' 
				,FechaActualiza='".$fechaActualiza."',fechaCambio='".$fechaActualiza."',fechaCambioContrasena=".$fechaCambioContrasena.
				",fechaLimiteCambioContrasena=".$fechaLimiteCambioContrasena." WHERE idUsuario=".$idUsuario. " ";
$con->ejecutarConsulta($consulta_actualiza);




$_SESSION["statusCuenta"]=0;
$actualizacionCorrecta=true;
?>
<body>

<table width="100%">
<tr>
	<td align="center">


	</td>
</tr>
</table>   
<form action="../principalPortal/inicio.php" method="POST" id="formaRegresa">
</form>
<script type="text/javascript">
	<?php 
		if($actualizacionCorrecta)
		{
	?>
	document.getElementById('formaRegresa').submit(); 
	<?php
		}
	?>
</script>
</body>