<?php session_start();
	include("conexionBD.php"); 

$proyecto='';
if(isset($_POST['proyecto']))
{
	$proyecto=$_POST['proyecto'];	
}
$fecha=$_POST['formated'];
$final=$_POST['final'];
$inicio=$_POST['inicio'];
$place=$_POST['place'];
$desc=$_POST['desc'];
$title=$_POST['title'];
$check=$_POST['check'];
$final=strtotime($final);
$final=date('His',$final);
$inicio=strtotime($inicio);
$inicio=date('His',$inicio);

if($con->ejecutarConsulta("BEGIN"))
{
$consulta_insertar = "INSERT INTO 4089_calendario(inicio,final,idUsuario,descrip,titulo,lugar,tipo,fecha) 
	values('".cv($inicio)."','".cv($final)."','".$_SESSION['idUsr']."','".cv($desc)."','".cv($title)."','".cv($place)."','2','".$fecha."')";
	if(!$con->ejecutarConsulta($consulta_insertar))
		return;
	$id=$con->obtenerUltimoID();
	
for($i=0;$i<count($check);$i++)
{
	
	$consulta_rol[$i]="INSERT INTO 4094_eventosVsRol(rol,idFecha,complementario) 
	values('".$check[$i]."','".$id."','".$proyecto."')";
	if(!$con->ejecutarConsulta($consulta_rol[$i]))
		return;
}

$con->ejecutarConsulta("COMMIT");	

}

?>