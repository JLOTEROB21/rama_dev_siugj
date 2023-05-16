<?php session_start();

	include("conexionBD.php");
	$funcion =$_POST["funcion"];
	switch($funcion)
	{
		case 1:
			Guardar();
			break;
		case 2:
			GuardarEnfermedad();
			break;
		case 3:
			GuardarMedicamento();
			break;
		case 4:
			GuardarProducto();
			break;
		case 5:
			elimnarMedicamento();
			break;
		case 6:
			elimnarEnfermedad();
			break;
		case 7:
			eliminarAlimento();
			break;
		case 8:
			eliminarAlumnoDoctor();
			break;
		case 9:
			obtenerDatosMedico();
		break;
		case 10:
			actualizarDatosMedico();
		break;
		case 11:
			obtenerMedicosAsociados();
		break;
		case 12:
			asociarMedicoAlumno();
		break;
	}	
	
	
	function Guardar()
	{
		global $con;
		$datos=$_POST["objDatos"];
		$obj=json_decode($datos);
		
		$consulta="select IdAlumno from 4120_fichaMedica where IdAlumno=".$obj->IdAlumno;
		$idAlumno=$con->obtenerValor($consulta);
		if($idAlumno=="")
		{
			$consulta="insert into 4120_fichaMedica(IdAlumno) values(".$obj->IdAlumno.")";
			if(!$con->ejecutarConsulta($consulta))
			{
				echo "|";
				return;
			}
		}
		
		$fichas="UPDATE 4120_fichaMedica SET GrupoSanguineo='".cv($obj->cmbSangre)."',Alergias='".cv($obj->Alergias)."',Padecimiento='".cv($obj->Padecimiento)."',Recomendaciones='".cv($obj->Recomendaciones)."',Llenada=1 WHERE IdAlumno=".$obj->IdAlumno;
		if($con->ejecutarConsulta($fichas))
		{
			//Borrar los medicamentos y luego volver a insertar, por si entra a actualizar
			$con->ejecutarConsulta("DELETE FROM 4124_alumMedAutorizadas WHERE IdAlumno=".$obj->IdAlumno);
			$separar = explode(',',$obj->Medicamentos);
			for($x=0; $x<=$obj->noRegistros-1; $x++)
			{
				$Medic="INSERT INTO 4124_alumMedAutorizadas (IdAlumno,IdMedicina)VALUES(";
				$Medic=$Medic.$obj->IdAlumno.",".$separar[$x].")";
				if(!$con->ejecutarConsulta($Medic))
				{
					echo "|";
					return;
				}
				$Medic="";
			}
			
			$consulta="delete from 4119_enfermedades where IdAlumno=".$obj->IdAlumno;
			if(!$con->ejecutarConsulta($consulta))
			{
				echo "|";
				return;
			}	
			
			if(trim($obj->enfermedades)!="")
			{
				$consulta="insert into 4119_enfermedades(Enfermedad,IdAlumno) values('".cv(trim($obj->enfermedades))."',".$obj->IdAlumno.")";
				if(!$con->ejecutarConsulta($consulta))
				{
					echo "|";
					return;
				}				
			}
			
			$consulta="delete from 4121_medicamentos where IdAlumno=".$obj->IdAlumno;
			if(!$con->ejecutarConsulta($consulta))
			{
				echo "|";
				return;
			}	
			
			if(trim($obj->medicamentosAlergia)!="")
			{
				$consulta="insert into 4121_medicamentos(Medicamento,IdAlumno) values('".cv(trim($obj->medicamentosAlergia))."',".$obj->IdAlumno.")";
				if(!$con->ejecutarConsulta($consulta))
				{
					echo "|";
					return;
				}				
			}

			$consulta="delete from 4117_alimentos where IdAlumno=".$obj->IdAlumno;
			if(!$con->ejecutarConsulta($consulta))
			{
				echo "|";
				return;
			}	
			
			if(trim($obj->alimentos)!="")
			{
				$consulta="insert into 4117_alimentos(Alimento,IdAlumno) values('".cv(trim($obj->alimentos))."',".$obj->IdAlumno.")";
				if(!$con->ejecutarConsulta($consulta))
				{
					echo "|";
					return;
				}				
			}
			
			echo '1|';
		}
		else
			echo "|";
	}
	
	function GuardarEnfermedad()
	{
		global $con;
		$Enfermedad=$_POST["Enfermedad"];
		$IdAlumno=$_POST["IdAlumno"];
		$sql2="INSERT INTO 4119_enfermedades(Enfermedad,IdAlumno)VALUES('".$Enfermedad."',".$IdAlumno.")";
		$res=$con->agregarRegistro($sql2);
		echo '1|'.$res;
	}
	
	function GuardarMedicamento()
	{
		global $con;
		$Medicamento=$_POST["Medicamento"];
		$IdAlumno=$_POST["IdAlumno"];
		$sql2="INSERT INTO 4121_medicamentos(Medicamento,IdAlumno)VALUES('".$Medicamento."',".$IdAlumno.")";
		$res=$con->agregarRegistro($sql2);
		echo '1|'.$res;
	}
	
	function GuardarProducto()
	{
		global $con;
		$Producto=$_POST["Producto"];
		$IdAlumno=$_POST["IdAlumno"];
		$sql2="INSERT INTO 4117_alimentos(Alimento,IdAlumno)VALUES('".$Producto."',".$IdAlumno.")";
		$res=$con->agregarRegistro($sql2);
		echo '1|'.$res;
	}
	
	function elimnarMedicamento()
	{
		$IdMedicamento=$_POST["IdMedicamento"];
		$s="DELETE FROM 4121_medicamentos WHERE IdMedicamento=".$IdMedicamento;
		$con->ejecutarConsulta($s);
		echo "1|".$s;
	}
	
	function elimnarEnfermedad()
	{
		global $con;
		$IdEnfermedad=$_POST["IdEnfermedad"];
		$s="DELETE FROM 4119_enfermedades WHERE IdEnfermedad=".$IdEnfermedad;
		$con->ejecutarConsulta($s);
		echo "1|".$s;
	}
	
	function eliminarAlimento($con,$conexion)
	{
		global $con;
		$IdAlimento=$_POST["IdAlimento"];
		$s="DELETE FROM 4117_alimentos WHERE IdAlimento=".$IdAlimento;
		$con->ejecutarConsulta($s);
		echo "1|".$s;
	}
	
	function eliminarAlumnoDoctor()
	{
		global $con;
		$consulta="select IdMedico from 4126_medicAlum where IdMedAlu=".$_POST["idRel"];
		$idMedico=$con->obtenerValor($consulta);
		$consulta="delete from 4126_medicAlum where IdMedAlu=".$_POST["idRel"];
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="select IdMedAlu from 4126_medicAlum where IdMedico=".$idMedico;
			$res=$con->obtenerFilas($consulta);
			if($con->filasAfectadas==0)
			{
				$consulta="delete from 4122_medicos where IdMedico=".$idMedico;
				if($con->ejecutarConsulta($consulta))
					echo "1";
			}
			else
				echo "1";
		}
		else
			echo "-1";
	}
	
	function obtenerDatosMedico()
	{
		global $con;
		$idMedico=$_POST["idMedico"];
		$consulta="select Nombre,Direccion,Telefono from 4122_medicos where IdMedico=".$idMedico;
		$fila=$con->obtenerPrimeraFila($consulta);
		$cadFila=$fila[0]."|".$fila[1]."|".$fila[2];
		echo "1|".uEJ($cadFila);
	}
	
	function actualizarDatosMedico()
	{
		global $con;
		$idMedico=$_POST["idMedico"];
		$nombre=$_POST["nombre"];
		$direccion=$_POST["direccion"];
		$telefono=$_POST["telefono"];
		$consulta="update 4122_medicos set Nombre='".cv($nombre)."',Direccion='".cv($direccion)."',Telefono='".cv($telefono)."' where idMedico=".$idMedico;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
		
	}
	
	function obtenerMedicosAsociados()
	{
		global $con;
		$idAlumno=$_POST["idUsuario"];
		$consulta="select distinct (me.IdMedico),me.Nombre,me.Direccion from 4125_alumPers a,4126_medicAlum ma,4122_medicos me where  me.IdMedico=ma.IdMedico and
		ma.IdAlumno= a.idAlumno and a.idUsuario in (select idUsuario from 4125_alumPers where idAlumno=".$idAlumno.") and me.IdMedico not in
		(select IdMedico from 4126_medicAlum where IdAlumno=".$idAlumno.")
		and a.idAlumno<>".$idAlumno;	
		$arrMedicos= $con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrMedicos);
	}
	
	function asociarMedicoAlumno()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$medicos=$_POST["medicos"];
		$arrMedicos=explode(",",$medicos);
		$nMedicos=sizeof($arrMedicos);
		$p=0;
		$consulta[$p]="begin";
		$p++;
		for($x=0;$x<$nMedicos;$x++)
		{
			$consulta[$p]="insert into 4126_medicAlum(IdAlumno,IdMedico) values(".$idUsuario.",".$arrMedicos[$x].")";
			$p++;
		}
		$consulta[$p]="commit";
		$p++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
?>