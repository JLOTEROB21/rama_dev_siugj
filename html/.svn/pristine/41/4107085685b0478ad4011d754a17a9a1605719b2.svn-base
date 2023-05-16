<?php
session_start();
include("conexionBD.php");

$xconvo=$_POST['myFCKeditor'];
$usuario=$_SESSION['idUsr'];

$fechaini=cambiaraFechaMysql($_POST['f_txtFechaIni']);
$fechafin=cambiaraFechaMysql($_POST['f_txtFechaFin']);

$fechainiPre=cambiaraFechaMysql($_POST['f_txtFechaIniPre']);
$fechafinPre=cambiaraFechaMysql($_POST['f_txtFechaFinPre']);

$fechainiIns=cambiaraFechaMysql($_POST['f_txtFechaIniIns']);
$fechafinIns=cambiaraFechaMysql($_POST['f_txtFechaFinIns']);

$fechaC=date("Y-m-d");
$ciclo=$_POST['ciclo'];
$estado=$_POST['estado'];
$idPrograma=$_POST['idPrograma'];		  
$consulta_borrar= "delete from 4086_convocatoria where programa=".$idPrograma." AND ciclo=".$ciclo." ";
$sustituye = array("\r\n", "\n\r", "\n", "\r");
$disenoConvo=str_replace($sustituye,'',$xconvo);
$consulta_insertar = "insert into 4086_convocatoria(convocatoria,fechaInicio,fechaFin,ciclo,programa,idUsuario,fechaCrea,Estado,fechaIniPre,fechaFinPre,fechaIniIns,fechaFinIns) 
									values('".cv($disenoConvo)."','".$fechaini."','".$fechafin."','".$ciclo."','".$idPrograma."','".$usuario."','".$fechaC."','".$estado."','".$fechainiPre."','".$fechafinPre."','".$fechainiIns."','".$fechafinIns."')";
//$consulta_insertar = "insert into 4086_convocatoria(convocatoria,fechaInicio,fechaFin,ciclo,programa,idUsuario,fechaCrea,Estado) 
	//								values('".cv($disenoConvo)."','".$fechaini."','".$fechafin."','".$ciclo."','".$idPrograma."','".$usuario."','".$fechaC."','".$estado."')";
					$con->ejecutarConsulta($consulta_borrar);				
					$con->ejecutarConsulta($consulta_insertar);
?>
<body>
<form action="creaConvocatoria.php" method="POST" id="formaRegresa">
<input type="hidden" id="programa" name="programa" value="<?php echo $idPrograma ?>" />
<input type="hidden" id="programan" name="programan" value="<?php echo $_POST['programa'] ?>" />
<input type="hidden" id="estado" name="estado" value="<?php echo $estado ?>" />
<input type="hidden" id="ciclo" name="ciclo" value="<?php echo $ciclo ?>" />

</form>

<script type="text/javascript">
<?php 
	echo "document.getElementById('formaRegresa').submit()"; 
?>
</script>

</body>