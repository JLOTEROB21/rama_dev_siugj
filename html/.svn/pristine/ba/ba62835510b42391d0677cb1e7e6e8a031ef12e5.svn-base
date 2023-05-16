<?php
session_start();
include("conexionBD.php");

$actualizacionCorrecta=false;

$cmbLogin=$_POST["cmbLogin"];
$Contrasena=$_POST["Contrasena"];
$fechaActualiza=$_POST["fechaActualiza"];
$idUsuario=$_POST["idUsuario"];
$consulta_actualiza = "UPDATE 800_usuarios SET login='".$cmbLogin."', PASSWORD='".$Contrasena."', cambiarDatosUsr='0' ,FechaActualiza='".$fechaActualiza."' WHERE idUsuario=".$idUsuario. " ";
$con->ejecutarConsulta($consulta_actualiza);




$arrParam=array();
$arrParam["idUsuario"]=$idUsuario;
enviarMensajeEnvio(7,$arrParam);

$_SESSION["statusCuenta"]=0;
$actualizacionCorrecta=true;
?>
<body>

<table width="100%">
<tr>
	<td align="center">
<?php
if($actualizacionCorrecta)
{
?>
	<table>
    	<tr>
        	<td>
            <img src="../images/accept.png">
            </td>
            <td width="20">
            </td>
            <td>
            <span style="font-size:14px; font-family: Ubuntu, sans-serif; color:#003"><b>Los datos han sido actualizados correctamente</b></span>
            </td>
        </tr>
    </table>
<?php
}
else
{
?>
	<table>
    	<tr>
        	<td>
            <img src="../images/prohibido.png">
            </td>
            <td width="20">
            </td>
            <td>
            <span style="font-size:14px; font-family: Ubuntu, sans-serif; color:#003"><b>No se ha podido actualizar los datos</b></span>
            </td>
        </tr>
    </table>
<?php
}
?>
	</td>
</tr>
</table>   
<form action="../principal/inicio.php" method="POST" id="formaRegresa">
</form>
<script type="text/javascript">
	//document.getElementById('formaRegresa').submit(); 
</script>
</body>