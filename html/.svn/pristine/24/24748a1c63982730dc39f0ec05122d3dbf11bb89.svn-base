<?php session_start();
	include("conexionBD.php");
	$funcion =$_POST["funcion"];
	switch($funcion)
	{
		case 1:
			guardarDatosMedico();
		break;
	}
	
	function guardarDatosMedico()
	{
		global $con;
		$obj=json_decode($_POST["param"]);
		$alumnos=$obj->alumnos;
		$consulta[0]="begin";
		$consulta[1]="insert into 4122_medicos(Nombre,Direccion,Telefono) values('".cv($obj->nombre)."','".cv($obj->direccion)."','".cv($obj->telefono)."')";
		
		if($con->ejecutarBloque($consulta))
		{
			$id=$con->obtenerUltimoID();
			$arrAlumnos=explode(",",$alumnos);
			$ct=sizeof($arrAlumnos);
			$x=0;
			for($x=0;$x<$ct;$x++)
				$consult[$x]="insert into 4126_medicAlum(IdAlumno,IdMedico) values(".$arrAlumnos[$x].",".$id.")";
			$consult[$x]="commit";
			if($con->ejecutarBloque($consult))
				echo "1";
			else
				echo "-1";
		}
		else
			echo "-1";
	}
	
	
?>