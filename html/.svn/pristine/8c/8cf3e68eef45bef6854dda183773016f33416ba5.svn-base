<?php session_start();
	include("conexionBD.php");


	$funcion =$_POST["funcion"];
	switch($funcion)
	{
		case 1:
			cargarCombo();
			break;
		case 2:
			Guardar();
		break;
	}	
	
	function Guardar()
	{
			global $con;
			$idUsuario=$_SESSION["idUsr"];
			$datos=$_POST["objDatos"];
			$obj=json_decode($datos);
		  	$fecha = time(); 
			  $fecha=date('Y/m/d',$fecha);
			  
			  if($obj->cmbPrograma==4)//Bachillerato
				  {
					  $Semestre=$obj->cmbGrado;
					  
					  $Grado=$obj->cmbGrado;
						  
				  }
				  else//LAs otras areas
				  {
					  $Semestre=0;
					  $Grado=$obj->cmbGrado;
				  }
		  
			  $dia= substr($obj->FNac,0,2);
			  $mes=substr($obj->FNac,3,2);
			  $anio=substr($obj->FNac,6,4);
			  
			  $fechaNac=$anio."-".$mes."-".$dia;
			  $nombreC=trim($obj->Nombre.' '.$obj->APaterno.' '.$obj->AMaterno);
			  $status="106";
			  
			  $txtRelacion=$obj->relacion;
			  $consulta1="begin";
			  $x=0;
			  if($con->ejecutarConsulta($consulta1))
			  {
				  $consulta2="insert into 800_usuarios(Status,Nombre,FechaActualiza,paso)values(".$status.",'".cv($nombreC)."','".date('Y-m-d')."',1)";
				  if($con->ejecutarConsulta($consulta2))
				  {
					  $idUsuario=$con->obtenerUltimoID();
					  $consulta[$x]="insert into 801_adscripcion(Status,Actualizado,idUsuario) values(".$status.",0,".$idUsuario.")";
					  $x++;
					  $consulta[$x]="insert into 802_identifica(Nom,Paterno,Materno,Nombre,Status,idUsuario,Actualizado,fechaNacimiento,Genero,CURP) 
								  values('".cv($obj->Nombre)."','".cv($obj->APaterno)."','".cv($obj->AMaterno)."','".cv($nombreC)."',".$status.",".$idUsuario.",0,'".$fechaNac."',".$obj->Sexo.",'".cv($obj->CURP)."')";
					  $x++;
					  $consulta[$x]="insert into 803_direcciones(idUsuario,Tipo) values(".$idUsuario.",0)";
					  $x++;
					  $consulta[$x]="insert into 803_direcciones(idUsuario,Tipo) values(".$idUsuario.",1)";
					  $x++;
					  $consulta[$x]="insert into 806_fotos(idUsuario) values(".$idUsuario.")";
					  $x++;
					  $consulta[$x]="insert into 807_usuariosVSRoles(idUsuario,idRol) values(".$idUsuario.",7)";
					  $x++;
					  $consulta[$x]="insert into 4120_fichaMedica(IdAlumno) values(".$idUsuario.")";
					  $x++;
					  $consulta[$x]="insert into 4118_alumnos(idPrograma,idGrado,idUsuario,estado,ciclo) values(".$obj->cmbPrograma.",".$obj->cmbGrado.",".$idUsuario.",7,".$obj->ciclo.")";
					  $x++;
					  $consulta[$x]="insert into 4128_nuevosAspirantes(idPrograma,idGrado,Procedencia,idUsuario,ciclo,estado) values(".$obj->cmbPrograma.",".$obj->cmbGrado.",'".$obj->Escuela."',".$idUsuario.",".$obj->ciclo.",1)";
					  $x++;
					  $consulta[$x]="insert into 4125_alumPers(idAlumno,idUsuario,IdParentezco) values(".$idUsuario.",".$_SESSION["idUsr"].",".$txtRelacion.")";
					  $x++;
					  $consulta[$x]="commit";
					  if($con->ejecutarBloque($consulta))
					  {
						  $idRel=$con->obtenerUltimoID();
						  echo "1|".$idUsuario."|".$idRel;
					  }
					  else
						  echo "|";
				  }
				  else
					  echo "|";
			  }
			  else
				  echo "|";
	}
	
	function cargarCombo()
	{
		global $con;
		$arrObj="";
		$datos=$_POST["objDatos"];
		
		$sql="select idGrado,grado from 4014_grados where idPrograma=".$datos;
		$result =$con->obtenerFilas( $sql);
		while ( $row = mysql_fetch_row ( $result ) )
		{
			$obj='{"IdGrado":"'.$row[0].'","Grado":"'.utf8_encode($row[1]).'"}';
			if($arrObj=="")
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
		}
		echo '1|['.$arrObj.']';
	}
	
?>