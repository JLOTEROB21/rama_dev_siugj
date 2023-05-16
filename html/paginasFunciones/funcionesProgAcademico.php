<?php session_start();
	include("conexionBD.php");
	$parametros="";
	$funcion="";
	if(isset($_POST["funcion"]))
	{
		$funcion=$_POST["funcion"];
	}	
	switch($funcion)
	{
		case "1":
			quitarNiveles();
		break;
		case "2":
			quitarProgramas();
		break;
		case "3":
			quitarTipoCiclo();
		break;
		case "4":
			quitarModalidad();
		break;
		case "5":
			eliminarMapaCurricular();
		break;
		case "6":
			cargarCombo();
		break;
		case "7":
			asignarGrupo();
		break;
		case "8":
			generarMapaCurricular();
		break;
		case "9":
			guardarMapa();
		break;
		case "10":
			comprobarHorarioProfesor();
		break;
		case "11":
			cambioProfesor();
		break;
		case "12":
			guardarHorarioMapa();
		break;
		case "13":
			estadoMapa();
		break;
		case "14":
			cambioProfesorLibre();
		break;
		case "15":
			borrarProfesor();
		break;
		case "16":
			guardarProfesor();
		break;
		case 17:
			removerProfesor();
		break;
		case 18:
			obtenerMateriasProfesor();
		break;
		case 19:
			obtenerMateriasAlumno();
		break;
		case 20:
			obtenerPermisosRolControlE();
		break;
		case 21:
			modificarPermisosControlE();
		break;
		case 22:
			guardarConfParametrosCalculo();
		break;
		case 23:
			obtenerConfCalculo();
		break;
		case 24:
			obtenerSedes();
		break;
		case 25:
			guardarMateriaConvocatoria();
		break;
		case 26:
			obtenerHorarioMateriaCurso();
		break;
		case 27:
			validarHorarioMateriaCurso();
		break;
		case 28:
			guardarAplicacionHorarioMateriaCurso();
		break;
		case 29:
			eliminarRegistroHorarioMateriaCurso();
		break;
		case 30:
			validarHorarioCursoConDocente();
		break;
		case 31:
			guardarParticipacionCursoDocente();
		break;
		case 32:
			obtenerRecursosSede();
		break;
		case 33:
			modificarDatosGrupoCurso();
		break;
		case 34:
			existeProgramaModalidad();
		break;
		case 35:
			obtenerSedesProgramaUsuario();
		break;
		case 36:
			guardarMapaCiclo();
		break;
		case 37:
			obtenerAlumnosMapaCiclo();
		break;
		case 38:
			eliminarMapaCiclo();
		break;
		case 39:
			guardarBloqueGrado();
		break;
		case 40:
			obtenerInformacionBloqueGrado();
		break;
		case 41:
			validarFechasBloqueGrado();
		break;
		case 42:
			eliminarBloqueGrado();
		break;
		case 43:
			obtenerDatosRevoe();
		break;
		case 44:
			marcarRegistradoBloqueCalificaciones();
		break;
		case 45:
			obtenerSedesLibres();
		break;
		case 46:
			obtenerNumeroSedesLibres();
		break;
		case 47:
			obtenerClaveMateria();
		break;
		case 48:
			validarClaveMateria();
		break;
		case 100:
			eliminarRegistroHorario();
		break;
		case 101:
			validarHorarioMatC();
		break;
		case 102:
			validarHorarioProfesorMateriCompartida();
		break;
		case 103:
			validarModificarHorarioMatC();
		break;
		case 104:
			validarFechasMapaC();
		break;
		case 105:
			guaradarMateriasPerfil();
		break;
		case 106:
			eliminarMateriasPerfil();
		break;
		case 107:
			eliminarPerfilMapa();
		break;
		case 108:
			guardarMatRequisito();
		break;
		case 109:
			guardarTipoMatRequisito();
		break;
		case 110:
			eliminarMatRequisito();
		break;
		case 111:
			excluirMatFormato();
		break;
		case 112:
			agregarCurso();
		break;
		case 113:
			obtenerFechasCurso();
		break;
		case 114:
			guardarFechasCurso();
		break;
		case 115:
			guardarProfesorCurso();
		break;
		case 116:
			comprobarHorarioProfesorCurso();
		break;
		case 117:
			borrarProfesorCurso();
		break;
		case 118:
			modificarCurso();
		break;
		case 119:
			obtenerCapacidadRecurso();
		break;
		case 120:
			eliminarCurso();
		break;
		case 121:
			guaradarRolesPermisoControlE();
		break;
		case 122:
			borrarRolesPermisoControlE();
		break;
		case 123:
			buscarUsuariosSede();
		break;
		case 124:
			obtenerAlumnosGrado();
		break;
		case 125:
			inscribirAlumnosGrupo();
		break;
		case 126:
			obtenerGruposGrado();
		break;
		case 127:
			obtenerElementosMateriaHijo();
		break;
		case 128:
			guardarElementoUnidadD();
		break;
		case 129:
			modificarOrdenElementoUnidadD();
		break;
		case 130:
			obtenerMaximoOrdenElementoUnidadD();
		break;
		case 131:
			obtenerGridAlumnos();
		break;
		case 132:
			incribirdAlumno();
		break;
		case 133:
			rechazarAlumno();
		break;
		case 134:
			comentarAlumno();
		break;
		case 135:
			obtenerParametros();
		break;
		case 136:
			obtenerCandidatos();
		break;
		case 137:
			obtenerPeriodoInstanciaPlan();
		break;
		case 138:
			obtenerGradosInstanciaPlan();
		break;
		case 139:
			obtenerGruposMaestrosInstanciaPlan();
		break;
		case 140:
			obtenerAlumnosGrupoMaestro();
		break;
	}
	
	function quitarNiveles()
	{
		global $con;
		$idNivel=$_POST["idNivel"];
		$consulta="delete from 50_nivel where idNivel=".$idNivel;
		if($con->ejecutarConsulta($consulta))
			echo "1";
		
		
	}
	
	function quitarProgramas()
	{
		global $con;
		$idProg=$_POST["idPrograma"];
		$consulta="delete from 51_programa where idPrograma=".$idProg;
		if($con->ejecutarConsulta($consulta))
			echo "1";
	}
	
	function quitarTipoCiclo()
	{
		global $con;
		$idCiclo=$_POST["idTipoCiclo"];
		$consulta="delete from 4101_tipoCicloEscolar where idTipoCiclo=".$idCiclo;
		if($con->ejecutarConsulta($consulta))
			echo "1";
	}
	
	function quitarModalidad()
	{
		global $con;
		$idModalidad=$_POST["idModalidad"];
		$consulta="delete from 4100_modalidad where idModalidad=".$idModalidad;
		if($con->ejecutarConsulta($consulta))
			echo "1";
	}
	
	function eliminarMapaCurricular()
	{
		global $con;
		$id=$_POST["id"];
		
		$conDatos="SELECT idPrograma,ciclo FROM 4029_mapaCurricular WHERE idMapaCurricular=".$id;
		$datos=$con->obtenerPrimerafila($conDatos);
		if(!$datos)
		{
			$idCiclo="-1";
			$idPrograma="-1";
		}
		else
		{
			$idCiclo=$datos[1];
			$idPrograma=$datos[0];
		}
		
		$consulta="begin";
		if($con->ejecutarconsulta($consulta))
		{
			$ct=0;
			
			$query[$ct]="delete from 4029_mapaCurricular where idMapaCurricular=".$id;
			$ct++;
			
			$query[$ct]="DELETE FROM 4031_elementosMapa WHERE idMapaCurricular=".$id;
			$ct++;
			
			$query[$ct]="DELETE FROM 4013_materia WHERE idPrograma=".$idPrograma." AND ciclo=".$idCiclo;
			$ct++;
			
			$consultaGrados="SELECT idGrado FROM 4014_grados WHERE idPrograma=".$idPrograma." AND ciclo=".$idCiclo;
			$resGrados=$con->obtenerFilas($consultaGrados);
			
			while($fila=mysql_fetch_row($resGrados))
			{
				$query[$ct]="DELETE FROM 4048_grupos WHERE idGrado=".$fila[0];
				$ct++;
			}
				
			$query[$ct]="DELETE FROM 4014_grados WHERE idPrograma=".$idPrograma." AND ciclo=".$idCiclo;
			$ct++;
			
			$query[$ct]="DELETE FROM 4068_fechaCalendario WHERE idMapaCurricular=".$id;
			$ct++;
			
			$query[$ct]="commit";
			
			if($con->ejecutarBloque($query))
				echo "1";
			else
				echo "-1";
				
		}
		else
		{
			echo "-1";
		}

    }

function cargarCombo()
	{
		global $con;
		$arrObj="";
		$datos=$_POST["objDatos"];
		
		$sql="SELECT distinct(n.NombrePrograma),o.idPrograma FROM  4004_programa n,4029_mapaCurricular o ,4035_programaVsRol pr
				WHERE pr.idPrograma=o.idPrograma and pr.idRol in(".$_SESSION["idRol"].") and n.idTipoPrograma=1 
				and o.idPrograma=n.idPrograma AND o.ciclo=".$datos." AND (o.estadoMapa=1 OR o.estadoMapa=2)ORDER BY n.idPrograma";
		$result =$con->obtenerFilas( $sql);
		while ( $row = mysql_fetch_row ( $result ) )
		{
			$obj='{"IdPrograma":"'.$row[1].'","Programa":"'.$row[0].'"}';
			if($arrObj=="")
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
		}
		echo '1|['.uEJ($arrObj).']';
	}

function asignarGrupo()
{
	global $con;
	$param=str_replace('\\',"",$_POST["param"]);
	$obj=json_decode($param);
	
	$idPrograma=$obj->idPrograma;
	$idGrupo=$obj->idGrupo;
	$cadenaSet="";
	
	
	$idGrado=$obj->idGrado;
	$idCiclo=$obj->idCiclo;
	$idAlumnos=$obj->idAlumnos;
	$x=0;
	$consul="begin";
	if($con->ejecutarConsulta($consul))
	{
		if($idGrupo=='_10')
		{
			$idGrupo='NULL';
			$cadenaSet=",estado=6";
		}
		else
		{
			$cadenaSet=",estado=1";
		}
		$consulta[$x]="update 4118_alumnos set idGrupo=".$idGrupo.$cadenaSet." where idPrograma=".$idPrograma." and ciclo=".$idCiclo." and idGrado=".$idGrado." and idUsuario in(".$idAlumnos.")";
		$x++;
		$arrAlumnos=explode(",",$idAlumnos);
		$nAlumnos=sizeof($arrAlumnos);
		$query="select em.idMateria,m.compartida from 4031_elementosMapa em,4013_materia m where m.idmateria=em.idMateria and em.idPadre=0 and em.idGrado=".$idGrado." and em.idTipoMateria=1";
		$resMat=$con->obtenerFilas($query);
		while($filaMat=mysql_fetch_row($resMat))
		{
			if($filaMat[1]==1)
			{
				for($y=0;$y<$nAlumnos;$y++)
				{
					if($idGrupo!="NULL")
					{
						$conExiste="SELECT idAlumnosElementoMapa FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$filaMat[0]." AND idUsuario=".$arrAlumnos[$y];
						$existe=$con->obtenerValor($conExiste);
						if($existe=="")
						{
							$consult="insert into 4120_alumnosVSElementosMapa(idUsuario,situacion,idGrupo,idMateria,idPrograma) values(".$arrAlumnos[$y].",1,NULL,".$filaMat[0].",".$idPrograma.")";
							if(!$con->ejecutarConsulta($consult))	
							{
								return;
							}
						}
					}
					else
					{
						$consulta[$x]="delete from 4120_alumnosVSElementosMapa where idUsuario=".$arrAlumnos[$y]." and idMateria=".$filaMat[0];
						$x++;
					}
					
				}
				inscribirMateriasObligatoriasAlumno($arrAlumnos,$filaMat[0],$consulta,$x,$idGrupo,$idPrograma);
			}
			else
			{
				
				for($y=0;$y<$nAlumnos;$y++)
				{
					if($idGrupo!="NULL")
					{
						$conExiste="SELECT idAlumnosElementoMapa FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$filaMat[0]." AND idUsuario=".$arrAlumnos[$y];
						$existe=$con->obtenerValor($conExiste);
						if($existe=="")
						{
							$consult="insert into 4120_alumnosVSElementosMapa(idUsuario,situacion,idGrupo,idMateria,idPrograma) values(".$arrAlumnos[$y].",1,".$idGrupo.",".$filaMat[0].",".$idPrograma.")";
							if(!$con->ejecutarConsulta($consult))	
							{
								return;
							}
						}
					}
					else
					{
						$consulta[$x]="delete from 4120_alumnosVSElementosMapa where idUsuario=".$arrAlumnos[$y]." and idMateria=".$filaMat[0];
						$x++;
					}
					//echo $consult;
					//if(!$con->ejecutarConsulta($consult))	
//					{
//						return;
//					}
				}
				inscribirMateriasObligatoriasAlumno($arrAlumnos,$filaMat[0],$consulta,$x,$idGrupo,$idPrograma);
			}
			
		}
		$consulta[$x]="commit";
		//$x++;
		
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
}

function inscribirMateriasObligatoriasAlumno($arrAlumnos,$idPadre,&$consulta,&$x,$idGrupo,$idPrograma)
{
	global $con;
	$query="select em.idMateria,m.compartida from 4031_elementosMapa em,4013_materia m where m.idmateria=em.idMateria and em.idPadre=".$idPadre." and em.idTipoMateria=1";
	//echo $query;
	$resMat=$con->obtenerFilas($query);
	$nAlumnos=sizeof($arrAlumnos);
	while($filaMat=mysql_fetch_row($resMat))
	{
		if($filaMat[1]==1)
		{
			for($y=0;$y<$nAlumnos;$y++)
			{
				if($idGrupo!="NULL")
				{
					$conExiste="SELECT idAlumnosElementoMapa FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$filaMat[0]." AND idUsuario=".$arrAlumnos[$y];
					$existe=$con->obtenerValor($conExiste);
					if($existe=="")
					{
						$consult="insert into 4120_alumnosVSElementosMapa(idUsuario,situacion,idGrupo,idMateria,idPrograma) values(".$arrAlumnos[$y].",1,NULL,".$filaMat[0].",".$idPrograma.")";
						//echo $consult;
						if(!$con->ejecutarConsulta($consult))
						{
							return;
						}
					}
				}
				else
				{
					$consulta[$x]="delete from 4120_alumnosVSElementosMapa where idUsuario=".$arrAlumnos[$y]." and idMateria=".$filaMat[0];
					//echo $$consulta[$x];
					$x++;
				}
			}
			inscribirMateriasObligatoriasAlumno($arrAlumnos,$filaMat[0],$consulta,$x,$idGrupo,$idPrograma);
		}
		else
		{
			for($y=0;$y<$nAlumnos;$y++)
			{
				if($idGrupo!="NULL")
				{
					$conExiste="SELECT idAlumnosElementoMapa FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$filaMat[0]." AND idUsuario=".$arrAlumnos[$y];
					//echo $conExiste."<br>";
					$existe=$con->obtenerValor($conExiste);
					if($existe=="")
					{
					  $consulta1="insert into 4120_alumnosVSElementosMapa(idUsuario,situacion,idGrupo,idMateria,idPrograma) values(".$arrAlumnos[$y].",1,".$idGrupo.",".$filaMat[0].",".$idPrograma.")";
					  //echo $consulta."<br>";
					  if(!$con->ejecutarConsulta($consulta1))
					  {
					  	return;
					  }
					}
				}
				else
				{
					$consulta[$x]="delete from 4120_alumnosVSElementosMapa where idUsuario=".$arrAlumnos[$y]." and idMateria=".$filaMat[0];
					//echo $$consulta[$x];
					$x++;
				}
				//inscribirMateriasObligatoriasAlumno($arrAlumnos,$filaMat[0],$consulta,$x,$idGrupo,$idPrograma);
			}
			inscribirMateriasObligatoriasAlumno($arrAlumnos,$filaMat[0],$consulta,$x,$idGrupo,$idPrograma);
		}
	}
}

function generarMapaCurricular()
{
	global $con;
	
	$idCiclo=$_POST["idCiclo"];
	$idPrograma=$_POST["idPrograma"];
	
	
	$consulta="insert into 4029_mapaCurricular(ciclo,idPrograma,estadoMapa) values 
				('".$idCiclo."','".$idPrograma."',1)";
	
	
	if($con->ejecutarConsulta($consulta))
	{
		$idMapaCurricular=$con->obtenerUltimoID();
		echo "1|".$idMapaCurricular."";
	}
	else
		echo "|";
}

function guardarMapa()
{
	global $con;
	
	$idMapaCurricular=$_POST["idMapaCurricular"];
	$idEstadoMapa=$_POST["idEstado"];
	
	
	$consulta="update 4029_mapaCurricular set estadoMapa=".$idEstadoMapa." where idMapaCurricular=".$idMapaCurricular;
	
	
	if($con->ejecutarConsulta($consulta))
	{
		
		echo "1|";
	}
	else
		echo "|";
}



function comprobarHorarioProfesor()
{
	global $con;
	$bandera=$_POST["bandera"];
	if($bandera==1)
	{
	    $idMateria=$_POST["idMateria"];
	    $idCiclo=$_POST["idCiclo"];
		$idGrupo=$_POST["idGrupo"];
		$cadena=$_POST["cadena"];
     		
		$consulta="select idUsuario from 4047_participacionesMateria where idMateria=".$idMateria." and idGrupo=".$idGrupo." and participacionP=1 and estado=1";
		$filas=$con->obtenerFilas($consulta);
		$numeroFilas=$con->filasAfectadas;
		$res=$con->obtenerPrimeraFila($consulta);
		$idUsuario=$res[0];
		
		if($numeroFilas==0)
		{
		    echo"1|";
		}
		else
		{
			$materiasProfesor="SELECT idMateria,idGrupo FROM 4047_participacionesMateria WHERE idUsuario=".$idUsuario." AND participacionP=1 AND estado=1";
			$resMateriasProf=$con->obtenerFilas($materiasProfesor);
			$arreglo=explode(",",$cadena);
			$tamaño=sizeof($arreglo);
			
			$mensajeColision="";
			for($x=0;$x<$tamaño;$x++)
			{
			    $array=explode("_",$arreglo[$x]);
				$horaI=$array [0] ;
		        $horaF=$array [1];
				$dia=$array[2];
				
				while($matProf=mysql_fetch_row($resMateriasProf))
				{
					$conHorMat="SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
								WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$matProf[0]." AND idGrupo=".$matProf[1]." and ciclo=".$idCiclo;
					$resHorMat=$con->obtenerFilas($conHorMat);			
								
					while($hMat=mysql_fetch_row($resHorMat))			
					{
						if($hMat[0]==$dia)
						{
							if( (($horaI >= $hMat[1]) && ($horaI < $hMat[2])) || (($horaF > $hMat[1])  && ($horaF <= $hMat[2])) )
							{
							   $nombreMateria="select titulo from 4013_materia where idMateria=".$matProf[0];
							   $nombre=$con->obtenerPrimeraFila($nombreMateria);
							   
							   $consultaGrupo="select *from 4048_grupos where idGrupo=".$matProf[1];
							   $datos=$con->obtenerPrimeraFila($consultaGrupo);
							   
							   $consultaPrograma="select *from 4004_programa where idPrograma=".$hMat[3];
							   $programa=$con->obtenerPrimeraFila($consultaPrograma);
							   
							   if($datos[3]=="")
							   {
							   		$conGradoAux="select idGrado from 4063_PerfilHorarioVSGrados where idPerfil=".$hMat[4]." and idPrograma=".$hMat[3];
									$idGrado=$con->obtenerValor($conGradoAux);
									
									$consultaGrado="select *from 4014_grados where idGrado=".$idGrado;
							   		$grado=$con->obtenerPrimeraFila( $consultaGrado);
							   }
							   else
							   {
							   		$consultaGrado="select *from 4014_grados where idGrado=".$datos[3];
							   		$grado=$con->obtenerPrimeraFila( $consultaGrado);
							   }
							   
								 switch($hMat[0])
								  {
									case "1":
										$dia="Lunes";
									break;
									case "2":
										$dia="Martes";
									break;
									case "3":
										$dia="Miercoles";
									break;
									case "4":
										$dia="Jueves";
									break;
									case "5":
									   $dia="Viernes";
									break;
									case "6":
										$dia="Sabado";
									break;
									case "7":
									   $dia="Domingo";
								  }
							   
								$colision="Tiene asignada la materia:&nbsp;<b>".$nombre[0]."</b>&nbsp;el dia&nbsp;<b>".$dia."</b>&nbsp;de&nbsp;<b>".$hMat[1]."</b>&nbsp;a&nbsp;<b>".$hMat[2]."</b><br/>";
								if($mensajeColision=="")
									$mensajeColision=$colision;
								else
									$mensajeColision.=$colision;
								//echo"2|".$nombre[0]."|". $programa[4]."|".$grado[4]."|".$datos[4]."|".$dia."|".$hMat[1]."|".$hMat[2]."";
								//return ;
							}
							else
							{
								if( ( ($hMat[1] >= $horaI) && ($hMat[1]< $horaF )) ||  (($hMat[2] > $horaI) &&  ($hMat[2]<= $horaF )) )
								{
								   $nombreMateria="select titulo from 4013_materia where idMateria=".$matProf[0];
								   $nombre=$con->obtenerPrimeraFila($nombreMateria);
								   
								   $consultaGrupo="select *from 4048_grupos where idGrupo=".$matProf[1];
								   $datos=$con->obtenerPrimeraFila($consultaGrupo);
								   
								   $consultaPrograma="select *from 4004_programa where idPrograma=".$datos[2];
								   $programa=$con->obtenerPrimeraFila($consultaPrograma);
								   
								   $consultaGrado="select *from 4014_grados where idGrado=".$datos[3];
								   $grado=$con->obtenerPrimeraFila( $consultaGrado);
								   
									 switch($hMat[0])
									  {
										case "1":
											$dia="Lunes";
										break;
										case "2":
											$dia="Martes";
										break;
										case "3":
											$dia="Miercoles";
										break;
										case "4":
											$dia="Jueves";
										break;
										case "5":
										   $dia="Viernes";
										break;
										case "6":
											$dia="Sabado";
										break;
										case "7":
										   $dia="Domingo";
									  }
								   
									$colision="Tiene asignada la materia:&nbsp;<b>".$nombre[0]."</b>&nbsp;el dia&nbsp;<b>".$dia."</b>&nbsp;de&nbsp;<b>".$hMat[1]."</b>&nbsp;a&nbsp;<b>".$hMat[2]."</b><br/>";
									if($mensajeColision=="")
										$mensajeColision=$colision;
									else
										$mensajeColision.=$colision;
									//echo"2|".$nombre[0]."|". $programa[4]."|".$grado[4]."|".$datos[4]."|".$dia."|".$hMat[1]."|".$hMat[2]."";
									//return ;
								}
							}
						}
					}
				}
				
				//$consultaExiste="select * from 4049_materiaVSProfesorVSGrupo where idUsuario=".$idUsuario." and ciclo=".$idCiclo." and dia=".$dia." and estado=1 and ( ('".$horaI."' >= horaInicio and '".$horaI."'<horaFin)or 
//											 ('".$horaF."' >horaInicio  and '".$horaF."' <=horaFin))";
//				
//				$resExiste=$con->obtenerFilas($consultaExiste);
//				$numero=$con->filasAfectadas;
//						$filaResumen=$con->obtenerPrimeraFila($consultaExiste);
//						if($numero>0)
//						{
//							   $nombreMateria="select titulo from 4013_materia where idMateria=".$filaResumen[1];
//							   $nombre=$con->obtenerPrimeraFila($nombreMateria);
//							   
//							   $consultaGrupo="select *from 4048_grupos where idGrupo=".$filaResumen[3];
//							   $datos=$con->obtenerPrimeraFila($consultaGrupo);
//							   
//							   $consultaPrograma="select *from 4004_programa where idPrograma=".$datos[2];
//							   $programa=$con->obtenerPrimeraFila($consultaPrograma);
//							   
//							   $consultaGrado="select *from 4014_grados where idGrado=".$datos[3];
//							   $grado=$con->obtenerPrimeraFila( $consultaGrado);
//							   
//								 switch($filaResumen[9])
//								  {
//									case "1":
//										$dia="Lunes";
//									break;
//									case "2":
//										$dia="Martes";
//									break;
//									case "3":
//										$dia="Miercoles";
//									break;
//									case "4":
//										$dia="Jueves";
//									break;
//									case "5":
//									   $dia="Viernes";
//									break;
//									case "6":
//										$dia="Sabado";
//									break;
//									case "7":
//									   $dia="Domingo";
//								  }
//							   
//								echo"2|".$nombre[0]."|". $programa[4]."|".$grado[4]."|".$datos[4]."|".$dia."|".$filaResumen[7]."|".$filaResumen[8]."";
//								return ;
//						}
//						else
//						{
//							
//							$consultaExiste="select * from 4049_materiaVSProfesorVSGrupo where idUsuario=".$idUsuario." and ciclo=".$idCiclo." and dia=".$dia." and estado=1 and ( ( horaInicio>='".$horaI."' and horaFin<'".$horaI."')or 
//											 (horaInicio > '".$horaF."' and  horaFin<='".$horaF."'))";
//				
//							$resExiste=$con->obtenerFilas($consultaExiste);
//							$numero=$con->filasAfectadas;
//							$filaResumen=$con->obtenerPrimeraFila($consultaExiste);
//							if($numero>0)
//							{
//								   
//								   $nombreMateria="select titulo from 4013_materia where idMateria=".$filaResumen[1];
//								   $nombre=$con->obtenerPrimeraFila($nombreMateria);
//								   
//								   $consultaGrupo="select *from 4048_grupos where idGrupo=".$filaResumen[3];
//								   $datos=$con->obtenerPrimeraFila($consultaGrupo);
//								   
//								   $consultaPrograma="select *from 4004_programa where idPrograma=".$datos[2];
//								   $programa=$con->obtenerPrimeraFila($consultaPrograma);
//								   
//								   $consultaGrado="select *from 4014_grados where idGrado=".$datos[3];
//								   $grado=$con->obtenerPrimeraFila( $consultaGrado);
//								   
//									 switch($filaResumen[9])
//									  {
//										case "1":
//											$dia="Lunes";
//										break;
//										case "2":
//											$dia="Martes";
//										break;
//										case "3":
//											$dia="Miercoles";
//										break;
//										case "4":
//											$dia="Jueves";
//										break;
//										case "5":
//										   $dia="Viernes";
//										break;
//										case "6":
//											$dia="Sabado";
//										break;
//										case "7":
//										   $dia="Domingo";
//									  }
//								   
//									echo"2|".$nombre[0]."|". $programa[4]."|".$grado[4]."|".$datos[4]."|".$dia."|".$filaResumen[7]."|".$filaResumen[8]."";
//									return ;
//							}
//							
//							
//							
//						}
//						echo"1|";
			}
			if($mensajeColision=="")
				echo"1|";
			else
				echo"2|".$mensajeColision."|".$cadena;
			
		}
	}
	else
	{
		if($bandera==2)
		{
				
				$idMateria=$_POST["idMateria"];
				$idUsuario=$_POST["idUsuario"];
				$idPrograma=$_POST["idPrograma"];
				$idGrupo=$_POST["idGrupo"];
				$idCiclo=$_POST["idCiclo"];
				
				$materiasProfesor="SELECT idMateria,idGrupo FROM 4047_participacionesMateria WHERE idUsuario=".$idUsuario." AND participacionP=1 AND estado=1";
				$resMateriasProf=$con->obtenerFilas($materiasProfesor);
				$numMat=$con->filasAfectadas;
				
				if($numMat==0)
				{
					echo "1|";
				}
				else
				{
					  
					  $consultaHorarioMateria="select m.idBloque, m.idMateria,m.horaInicio,m.horaFin,b.dia from 4065_materiaVSGrupo m,4062_perfilVSBloque b
								 where idMateria=".$idMateria." and ciclo=".$idCiclo." and idGrupo=".$idGrupo." and m.idbloque=b.idPerfilVSBloque and idPrograma=".$idPrograma." and ciclo=".$idCiclo;
					  $resHorarioMateria=$con->obtenerFilas($consultaHorarioMateria);
					  $numeroFilasM=$con->filasAfectadas;
					  if($numeroFilasM==0)
					  {
					  	echo "1|";
					  }
					  else
					  {
					  //if($numeroFilasM==0)
					  //{
					  	//$consultaHorarioMateria="select m.idBloque, m.idMateria,m.horaInicio,m.horaFin,b.dia from 4065_materiaVSGrupo m,4062_perfilVSBloque b
								 //where idMateria=".$idMateria." and ciclo=".$idCiclo." and idGrupoCompartido=".$idGrupo." and m.idbloque=b.idPerfilVSBloque and idPrograma=".$idPrograma." and ciclo=".$idCiclo;
					    //$resHorarioMateria=$con->obtenerFilas($consultaHorarioMateria);
					  //}
					  
					  $mensajeColision="";
					  while($matProf=mysql_fetch_row($resMateriasProf)) //ciclo para materias del profesor
					  {
					  		$conHorMat="SELECT p.dia,m.horaInicio,m.horaFin FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
								WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$matProf[0]." AND idGrupo=".$matProf[1]." and ciclo=".$idCiclo;
					        $resHorMat=$con->obtenerFilas($conHorMat);
							
							
							while($fila=mysql_fetch_row($resHorMat))//ciclo para el horario de cada una de las materias
							{
								mysql_data_seek($resHorarioMateria,0);	
								while($hMat=mysql_fetch_row($resHorarioMateria))			
								{	
									if($fila[0]==$hMat[4])
									{
										  
										  if( (($fila[1] >= $hMat[1]) && ($fila[1] < $hMat[2])) || (($fila[2] > $hMat[1])  && ($fila[2] <= $hMat[2])) )
										  {
										
											   $nombreMateria="select titulo from 4013_materia where idMateria=".$matProf[0];
											   $nombre=$con->obtenerPrimeraFila($nombreMateria);
											   
											   $consultaGrupo="select *from 4048_grupos where idGrupo=".$matProf[1];
											   $datos=$con->obtenerPrimeraFila($consultaGrupo);
											   
											   $consultaPrograma="select *from 4004_programa where idPrograma=".$datos[2];
											   $programa=$con->obtenerPrimeraFila($consultaPrograma);
											   
											   $consultaGrado="select *from 4014_grados where idGrado=".$datos[3];
											   $grado=$con->obtenerPrimeraFila( $consultaGrado);
											   
												 switch($fila[4])
												  {
													case "1":
														$dia="Lunes";
													break;
													case "2":
														$dia="Martes";
													break;
													case "3":
														$dia="Miercoles";
													break;
													case "4":
														$dia="Jueves";
													break;
													case "5":
													   $dia="Viernes";
													break;
													case "6":
														$dia="Sabado";
													break;
													case "7":
													   $dia="Domingo";
												  }
											   
											   $colision="Tiene asignada la materia:&nbsp;<b>".$nombre[0]."</b>&nbsp;el dia&nbsp;<b>".$dia."</b>&nbsp;de&nbsp;<b>".$fila[1]."</b>&nbsp;a&nbsp;<b>".$fila[2]."</b><br/>";
												if($mensajeColision=="")
													$mensajeColision=$colision;
												else
													$mensajeColision.=$colision;
												//echo"2|".$nombre[0]."|". $programa[4]."|".$grado[4]."|".$datos[4]."|".$dia."|".$fila[1]."|".$fila[2]."";
												//return ;
										  }
										  else
										  {
											 if( ( ($hMat[1] >= $fila[1]) && ($hMat[1]< $fila[2] )) ||  (($hMat[2] > $fila[1]) &&  ($hMat[2]<= $fila[2] )) )
											  {
													 $nombreMateria="select titulo from 4013_materia where idMateria=".$matProf[0];
													 $nombre=$con->obtenerPrimeraFila($nombreMateria);
													 
													 if($matProf[0]==0)
													 {
														 $consultaGrupo="select *from 4048_grupos where idGrupo=".$$matProf[1];
														 $datos=$con->obtenerPrimeraFila($consultaGrupo);
														 
														 $consultaPrograma="select *from 4004_programa where idPrograma=".$datos[2];
														 $programa=$con->obtenerPrimeraFila($consultaPrograma);
													 }
													 else
													 {
														 $consultaGrupo="select *from 4048_grupos where idGrupo=".$matProf[1];
														 $datos=$con->obtenerPrimeraFila($consultaGrupo);
														 
														 $consultaPrograma="select *from 4004_programa where idPrograma=".$datos[2];
														 $programa=$con->obtenerPrimeraFila($consultaPrograma);
														 
														 $consultaGrado="select *from 4014_grados where idGrado=".$datos[3];
														 $grado=$con->obtenerPrimeraFila( $consultaGrado);
													 }
														 
													   switch($fila[0])
														{
														  case "1":
															  $dia="Lunes";
														  break;
														  case "2":
															  $dia="Martes";
														  break;
														  case "3":
															  $dia="Miercoles";
														  break;
														  case "4":
															  $dia="Jueves";
														  break;
														  case "5":
															 $dia="Viernes";
														  break;
														  case "6":
															  $dia="Sabado";
														  break;
														  case "7":
															 $dia="Domingo";
														}
													 
													   //if($matProf[1]==0)
//													   {
//														  echo"3|".$nombre[0]."|". $programa[4]."|".$dia."|".$fila[1]."|".$fila[2]."";
//														  return ;
//													   }
//													   else
//													   {
//														  echo"2|".$nombre[0]."|". $programa[4]."|".$grado[4]."|".$datos[4]."|".$dia."|".$fila[1]."|".$fila[2]."";
//														  return ;
//													   }
													   
													   $colision="Tiene asignada la materia:&nbsp;<b>".$nombre[0]."</b>&nbsp;el dia&nbsp;<b>".$dia."</b>&nbsp;de&nbsp;<b>".$fila[1]."</b>&nbsp;a&nbsp;<b>".$fila[2]."</b><br/>";
														if($mensajeColision=="")
															$mensajeColision=$colision;
														else
															$mensajeColision.=$colision;
											  }
										  }
									}
								}
							}
					  }
					  //echo "1|";
					  if($mensajeColision=="")
						  echo"1|";
					  else
						  echo"2|".$mensajeColision;
					  }
				
				}
		}
	}
}

function cambioProfesor()
{
	global $con;
	$bandera=$_POST["bandera"];
	echo $bandeera;
	if($bandera==1)
	{
		$motivo=$_POST["motivo"];
		$idUsuario=$_POST["idUsuario"];
		$idGrupo=$_POST["idGrupo"];
		$idMateria=$_POST["idMateria"];
		$idCiclo=$_POST["idCiclo"];
		$idPrograma=$_POST["idPrograma"];
		$participacion=$_POST["participacion"];
		
		$consul="begin";
		
		if($con->ejecutarConsulta($consul))
		{
		
			$consulBloque="select *from 4049_materiaVSProfesorVSGrupo where idUsuario=".$idUsuario." and idGrupo=".$idGrupo." and idMateria=".$idMateria." and ciclo=".$idCiclo." and idPrograma=".$idPrograma." and idParticipacion=".$participacion ;
			//echo $consulBloque;
			$res=$con->obtenerFilas($consulBloque);
				
			$ct=0;
			while($fila=mysql_fetch_row($res))
			{
			  $query[$ct]="update 4049_materiaVSProfesorVSGrupo set motivoCambio='".$motivo."' , estado=2 where idMateriaVSProfesorVSGrupo=".$fila[0];
			  $ct++;
			}
	
		     $query[$ct]="commit";
			 
			 if($con->ejecutarBloque($query))
			     echo "1|";
			 else
			     echo "|";
	    }
	
	}
	else
	{
		$idUsuario=$_POST["idUsuario"];
		$idGrupo=$_POST["idGrupo"];
		$idMateria=$_POST["idMateria"];
		$idCiclo=$_POST["idCiclo"];
		$idPrograma=$_POST["idPrograma"];
		$participacion=$_POST["participacion"];
		$consul="begin";
		  
		if($con->ejecutarConsulta($consul))
		{
			  $consulBloque="select *from 4049_materiaVSProfesorVSGrupo where idUsuario=".$idUsuario." and idGrupo=".$idGrupo." and idMateria=".$idMateria." and ciclo=".$idCiclo." and idPrograma=".$idPrograma." and idParticipacion=".$participacion ;
			  $res=$con->obtenerFilas($consulBloque);
			  $ct=0;
			  while($fila=mysql_fetch_row($res))
			  {
				$query[$ct]="delete from 4049_materiaVSProfesorVSGrupo where idMateriaVSProfesorVSGrupo=".$fila[0];
				$ct++;
			  }
	  
			   $query[$ct]="commit";
			   if($con->ejecutarBloque($query))
				   echo "1|";
			   else
				   echo "|";
		}
	}
}

function guardarHorarioMapa()
{
	global $con;
	
	$idMapaCurricular=$_POST["idMapaCurricular"];
	$idHorario=$_POST["idHorario"];
	$consulta="update 4029_mapaCurricular set idTipoHorario=".$idHorario." where idMapaCurricular=".$idMapaCurricular;
	if($con->ejecutarConsulta($consulta))
		echo "1|";
	else
		echo "|";
}

function estadoMapa()
{
	global $con;
	
	$idMapaCurricular=$_POST["idMapa"];
	
	$consulta="SELECT estadoMapa FROM 4029_mapaCurricular WHERE idMapaCurricular=".$idMapaCurricular;
	$estado=$con->obtenerValor($consulta);
	
	if($estado==2)
	{
		
		echo "1|";
	}
	else
		echo "2|";
}

function cambioProfesorLibre()
{
	global $con;
	
	$id=$_POST["id"];
	$motivo=$_POST["motivo"];
	
	 
	 $query="update 4158_materiaVSProfesor set estadoCambio='2',motivo='".$motivo."' where idMateriaProfesor=".$id;
	 if($con->ejecutarConsulta($query))
	  {
		  echo "1|";
	  }
	  else
		  echo "|";
}

function borrarProfesor()
{
	global $con;
	
	$id=$_POST["id"];
	
	 $consulta="delete from 4158_materiaVSProfesor where idMateriaProfesor=".$id;
	  if($con->ejecutarConsulta($consulta ))
	  {
		  echo "1|";
	  }
	  else
		  echo "|";
}

function guardarProfesor()
{
	global $con;
	$idMateria=$_POST["idMateria"];
	$idUsuario=$_POST["idUsuario"];
	$idParticipacion=$_POST["idParticipacion"];
	$idGrupo=$_POST["idGrupo"];
	$idParticipacionPrincipal=$_POST["idParticipacionPrincipal"];
	$participacionP=0;
	if($idParticipacionPrincipal==$idParticipacion)
		$participacionP=1;
	$query="select titulo,horasTotal,fechaInicio,fechaFin from 4013_materia where idMateria=".$idMateria;
	$filaMat=$con->obtenerPrimeraFila($query);
	
	$query="select idPrograma,ciclo from 4013_materia where idMateria=".$idMateria;
	$filaMateria=$con->obtenerPrimeraFila($query);
	$query="SELECT idParticipacionCoordinador FROM 4029_mapaCurricular WHERE idPrograma=".$filaMateria[0]." AND ciclo=".$filaMateria[1];
	$idCoordinador=$con->obtenerValor($query);
	
	$fechaInicio="";
	$fechaFin="";
	if($filaMat[2]!="")
	{
		$fechaInicio=$filaMat[2];
		$fechaFin=$filaMat[3];
	}
	
	
	if(($idGrupo=="")||($idGrupo=="0"))
		$comp="";
	else
	{
		$query="select nombreGrupo from 4048_grupos where idGrupo=".$idGrupo;
		$filaGrp=$con->obtenerPrimeraFila($query);
		$comp=" (Grupo:".$filaGrp[0]." )";
	}
	$consulBloque="select idParticipante from 4047_participacionesMateria where idUsuario=".$idUsuario." and idGrupo=".$idGrupo." and idMateria=".$idMateria." and idParticipacion=".$idParticipacion." and estado=1";
	$valor=$con->obtenerValor($consulBloque);
	$x=0;
	if($valor=="")
	{
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO 4047_participacionesMateria(idUsuario,idMateria,idParticipacion,estado,idGrupo,participacionP)
			   			VALUES('".$idUsuario."','".$idMateria."','".$idParticipacion."','1','".$idGrupo."','".$participacionP."')";
		//echo $consulta[$x];
		$x++;
		if($fechaInicio=="")
			$fechaInicio="NULL";
		else
			$fechaInicio="'".$fechaInicio."'";
		if($fechaFin=="")
			$fechaFin="NULL";
		else
			$fechaFin="'".$fechaFin."'";
		if($participacionP=="1")
		{
			$consulta[$x]="insert into 965_actividadesUsuario(tipoActividadProgramada,actividad,fechaInicio,fechaFin,prioridad,idUsuario,idProcesoAsociado,idReferencia,idPadre,horasTotal,raizUsuario,idMateria,idGrupo)
							values(3,'Clase: ".$filaMat[0].$comp." ',".$fechaInicio.",".$fechaFin.",1,".$idUsuario.",-1,-1,-1,".$filaMat[1].",1,".$idMateria.",".$idGrupo.")";
			

			$x++;
		}
		
		if($idCoordinador==$idParticipacion)
		{
			$query="select idUsuario from 807_usuariosVSRoles where idUsuario=".$idUsuario." and codigoRol='-101_0'";
			$resUsuario=$con->obtenerValor($query);
			if($resUsuario=="")
			{
				$consulta[$x]="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$idUsuario.",-101,0,'-101_0')";

				$x++;
			}
		}
		
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))		   
			echo "1|";
		else
			echo "2|";
	}
	else
	{
		echo "3|";
	}
}

function removerProfesor()
{
	global $con;
	$idParticipacion=base64_decode($_POST["idParticipacion"]);
	$consulta="select idMateria,idGrupo,idUsuario from 4047_participacionesMateria where idParticipante=".$idParticipacion;
	$filaP=$con->obtenerPrimeraFila($consulta);
	$x=0;
	$query[$x]="begin";
	$x++;
	$query[$x]="delete from 4047_participacionesMateria where idParticipante=".$idParticipacion;
	$x++;
	$query[$x]="delete from 965_actividadesUsuario where idMateria=".$filaP[0]." and idGrupo=".$filaP[1]." and idUsuario=".$filaP[2];
	$x++;
	$query[$x]="commit";
	$x++;
	
	if($con->ejecutarBloque($query))
		echo "1|";
	else
		echo "|";
}

function obtenerMateriasProfesor()
{
	global $con;
	global $mostrarEnVistaMateriasTipoCriterioEval;
	$idUsuario=$_POST["idUsuario"];
	$ciclo=$_POST["ciclo"];
	$vista=$_POST["vista"];
	$consulta="select distinct(p.idPrograma),nombrePrograma from  4047_participacionesMateria pg,
				4048_grupos g,4004_programa p where g.idGrupo=pg.idGrupo and 
				p.idPrograma=g.idPrograma and pg.idUsuario=".$idUsuario." and pg.estado=1 and g.ciclo=".$ciclo;
	$resProg=$con->obtenerFilas($consulta);
	$arrNodos="";
	while($filasProg=mysql_fetch_row($resProg))
	{
		$conMapa="select idMapaCurricular from 4029_mapaCurricular where idPrograma=".$filasProg[0];
		$idMapa=$con->obtenerValor($conMapa);
		if($idMapa=="")
		  $idMapa="-1";
		//$idMapa=obtenerMapaCurricular($filasProg[0],$ciclo);
		$consulta="SELECT idParticipacionPrincipal,idParticipacionCoordinador FROM 4029_mapaCurricular WHERE idMapaCurricular=".$idMapa;
		$filaParticipaciones=$con->obtenerPrimeraFila($consulta);
		$idParticipacionP=$filaParticipaciones[0];
		$idCoordinador=$filaParticipaciones[1];
		if($idParticipacionP=="")
			$idParticipacionP="-1";
		$idParticipacion=$idParticipacionP;
		if($vista==2)
			$idParticipacion=$idCoordinador;
		$consulta="select pg.idGrupo,m.idMateria,m.titulo,pg.idParticipacion,m.cve_materia,m.descripcion from  4047_participacionesMateria pg,4013_materia m,4048_grupos g 
					where m.idMateria=pg.idMateria and pg.idUsuario=".$idUsuario." and m.idPrograma=".$filasProg[0]." 
					and idParticipacion=".$idParticipacion." and g.idGrupo=pg.idGrupo and g.ciclo=".$ciclo." order by m.titulo";
		$resMaterias=$con->obtenerFilas($consulta);
		$arrMaterias="";
		while($fila=mysql_fetch_row($resMaterias))
		{
			$comp="";
			
			$consulta="SELECT idTipoComponente,criterioEvaluacion FROM 4031_elementosMapa e,4029_mapaCurricular m WHERE e.idMapaCurricular=m.idMapaCurricular
						AND m.idPrograma=".$filasProg[0]." and e.idMateria=".$fila[1];
			$filaElemento=$con->obtenerPrimeraFila($consulta);
			$idTipoMateria=$filaElemento[0];
			$criterioEval=$filaElemento[1];
			if(($idTipoMateria!="")&&($idTipoMateria!=1)&&(($criterioEval==0)||(($criterioEval==1)&&($mostrarEnVistaMateriasTipoCriterioEval))))
			{
				if($fila[0]!="0")
				{
					$consulta="select leyenda from 4048_grupos g,4014_grados gr where gr.idGrado=g.idGrado and g.idGrupo=".$fila[0];
					$leyenda=$con->obtenerValor($consulta);
					$consulta="select concat('Grupo: ',nombreGrupo) from 4048_grupos g where g.idGrupo=".$fila[0];
					$lGrupo=$con->obtenerValor($consulta);
					if($leyenda!="")
						$leyenda.=", ";
					$leyenda.=$lGrupo;
					$comp="(".$leyenda.")";
				}
				$nodoM='	{
								"text":"['.$fila[4].'] '.$fila[2].$comp.'",
								"id":"'.$fila[1]."_".$fila[0].'",
								"idMateria":"'.$fila[1].'",
								"idMapaC":"'.$idMapa.'",
								"idPrograma":"'.$filasProg[0].'",
								"idParticipacionP":"'.$idParticipacionP.'",
								"part":"'.$fila[3].'",
								"allowDrop":false,
								"idGrupo":"'.$fila[0].'",
								"cls":"../images/icon_code.gif",
								"tipo":"1",
								leaf:true,
								"qtip":"'.chop($fila[5]).'"
							}
						';	
				if($arrMaterias=="")
					$arrMaterias=$nodoM;
				else
					$arrMaterias.=",".$nodoM;
			}
	}
		
		if($arrMaterias!="")
		{
			$nodoProg='	{
							"text":"'.$filasProg[1].'",
							"id":"p_'.$filasProg[0].'",
							"allowDrop":false,
							"cls":"../images/icon_code.gif",
							"tipo":"0",
							children:	['.$arrMaterias.']
						}
								';		
			if($arrNodos=="")
				$arrNodos=$nodoProg;
			else
				$arrNodos.=",".$nodoProg;
		}
	}
	echo "[".uEJ($arrNodos)."]";

}


	function obtenerMateriasAlumno()
	{
		global $con;
		global $mostrarEnVistaMateriasTipoCriterioEval;
		$idUsuario=$_POST["idUsuario"];
		$ciclo=$_POST["ciclo"];
		$consulta="select distinct(p.idPrograma),nombrePrograma from  4120_alumnosVSElementosMapa am,4004_programa p,4013_materia m where m.idmateria=am.idMateria and p.idPrograma=m.idPrograma and am.idUsuario=".$idUsuario." and m.ciclo=".$ciclo;
		$resProg=$con->obtenerFilas($consulta);
		$arrNodos="";
		while($filasProg=mysql_fetch_row($resProg))
		{
			//$idMapa=obtenerMapaCurricular($filasProg[0],$ciclo);
			$conMapa="select idMapaCurricular from 4029_mapaCurricular where idPrograma=".$filasProg[0];
			$idMapa=$con->obtenerValor($conMapa);
			if($idMapa=="")
			  $idMapa="-1";
			$consulta="select idParticipacionPrincipal from 4029_mapaCurricular where idMapaCurricular=".$idMapa;
			$idParticipacion=$con->obtenerValor($consulta);
			$consulta="select am.idGrupo,m.idMateria,m.titulo from  4120_alumnosVSElementosMapa am,4013_materia m 
						where m.idMateria=am.idMateria and am.idUsuario=".$idUsuario." and m.ciclo=".$ciclo." and m.idPrograma=".$filasProg[0]."  order by m.titulo";
			$resMaterias=$con->obtenerFilas($consulta);
			$arrMaterias="";
			while($fila=mysql_fetch_row($resMaterias))
			{
				$comp="";
				$listaProf="-1";
				$consulta="SELECT idTipoComponente,criterioEvaluacion FROM 4031_elementosMapa e,4029_mapaCurricular m WHERE e.idMapaCurricular=m.idMapaCurricular
							AND m.idPrograma=".$filasProg[0]." AND m.ciclo=".$ciclo." and e.idMateria=".$fila[1];
				$filaElemento=$con->obtenerPrimeraFila($consulta);
				$idTipoMateria=$filaElemento[0];
				$criterioEval=$filaElemento[1];
				//$idTipoMateria=$con->obtenerValor($consulta);
				//if(($idTipoMateria!="")&&($idTipoMateria!=1))
				if(($idTipoMateria!="")&&($idTipoMateria!=1)&&(($criterioEval==0)||(($criterioEval==1)&&($mostrarEnVistaMateriasTipoCriterioEval))))
				{
					if(($fila[0]!="0")&&($fila[0]!=""))
					{
						$consulta="select idUsuario from 4047_participacionesMateria where idMateria=".$fila[1]." and idGrupo=".$fila[0];
						$listaProf=$con->obtenerListaValores($consulta);
						$consulta="select idGrado from 4048_grupos where idGrupo=".$fila[0];
						$idGrado=$con->obtenerValor($consulta);
						if($idGrado!="")
							$consulta="select concat(leyenda,' Grupo: ',nombreGrupo) from 4048_grupos g,4014_grados gr where gr.idGrado=g.idGrado and g.idGrupo=".$fila[0];
						else
							$consulta="select concat('Grupo: ',nombreGrupo) from 4048_grupos g where g.idGrupo=".$fila[0];
						$comp="(".$con->obtenerValor($consulta).")";
					}
					else
					{
						if($fila[0]=="0")	
							$comp="(Grupo único)";
						else
							$comp="(En espera de asignaci&oacute;n de grupo)";
					}
					$nodoM='	{
									"text":"'.$fila[2].$comp.'",
									"id":"'.$fila[1]."_".$fila[0].'",
									"idMateria":"'.$fila[1].'",
									"idMapaC":"'.$idMapa.'",
									"idPrograma":"'.$filasProg[0].'",
									"idParticipacionP":"'.$idParticipacion.'",
									"allowDrop":false,
									"idGrupo":"'.$fila[0].'",
									"cls":"../images/icon_code.gif",
									"profesor":"'.$listaProf.'",
									"tipo":"1",
									leaf:true
								}
							';	
					if($arrMaterias=="")
						$arrMaterias=$nodoM;
					else
						$arrMaterias.=",".$nodoM;
				}
			}
			if($arrMaterias!="")
			{
				$nodoProg='	{
								"text":"'.$filasProg[1].'",
								"id":"p_'.$filasProg[0].'",
								"allowDrop":false,
								"cls":"../images/icon_code.gif",
								"tipo":"0",
								children:	['.$arrMaterias.']
							}
									';		
				if($arrNodos=="")
					$arrNodos=$nodoProg;
				else
					$arrNodos.=",".$nodoProg;
			}
		}
		echo "[".uEJ($arrNodos)."]";
	}

	function eliminarRegistroHorario()
	{
	global $con;
	$id=$_POST["id"];
	$id=bD($id);
	$consulta="delete from 4180_materiaCompVSGrupo where idBloqueMatCVSGrupo=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

    }
	
	function validarHorarioMatC()
	{
		global $con;
		$horaI=$_POST["horaI"];
		$horaF=$_POST["horaF"];
		$dia=$_POST["dia"];
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$id=$_POST["id"];
		
		if($id==-1)
		{
			$conHorMat="SELECT dia,horaInicio,horaFin FROM 4180_materiaCompVSGrupo WHERE  idMateria=".$idMateria." AND idGrupo=".$idGrupo;
		}
		else
		{
			$conHorMat="SELECT dia,horaInicio,horaFin FROM 4180_materiaCompVSGrupo WHERE  idMateria=".$idMateria." AND idGrupo=".$idGrupo." and idBloqueMatCVSGrupo not in(select idBloqueMatCVSGrupo from 4180_materiaCompVSGrupo where idBloqueMatCVSGrupo=".$id." )";
		}
		$resHorMat=$con->obtenerFilas($conHorMat);
		$numeroFilas=$con->filasAfectadas;
		if($numeroFilas==0)			
		{
			echo "1|";
		}
		else
		{
			while($hMat=mysql_fetch_row($resHorMat))			
			{
				if($hMat[0]==$dia)
				{
					if(colisionaTiempo($horaI,$horaF,$hMat[1],$hMat[2]))
					{
						echo"2|".$dia."|".$hMat[1]."|".$hMat[2]."";
						return ;
					}
					//$horaInRg=strtotime($hMat[1]);
//					$horaFnRg=strtotime($hMat[2]);
//					if( (($horaI >= $horaInRg) && ($horaI < $horaFnRg)) || (($horaF > $horaInRg)  && ($horaF <= $horaFnRg)) )
//					{
//						 switch($hMat[0])
//						  {
//							case "1":
//								$dia="Lunes";
//							break;
//							case "2":
//								$dia="Martes";
//							break;
//							case "3":
//								$dia="Miercoles";
//							break;
//							case "4":
//								$dia="Jueves";
//							break;
//							case "5":
//							   $dia="Viernes";
//							break;
//							case "6":
//								$dia="Sabado";
//							break;
//							case "7":
//							   $dia="Domingo";
//						  }
//					   
//						$horaInRg=date('G:i',$horaInRg);
//						$horaFnRg=date('G:i',$horaFnRg);
//						echo"2|".$dia."|".$horaInRg."|".$horaFnRg."";
//						return ;
//					}
//					else
//					{
//						if( ( ($horaInRg >= $horaI) && ($horaFnRg< $horaI )) ||  (($horaInRg > $horaF) &&  ($horaFnRg<= $horaF )) )
//						{
//							 switch($hMat[0])
//							  {
//								case "1":
//									$dia="Lunes";
//								break;
//								case "2":
//									$dia="Martes";
//								break;
//								case "3":
//									$dia="Miercoles";
//								break;
//								case "4":
//									$dia="Jueves";
//								break;
//								case "5":
//								   $dia="Viernes";
//								break;
//								case "6":
//									$dia="Sabado";
//								break;
//								case "7":
//								   $dia="Domingo";
//							  }
//						   
//							echo"2|".$dia."|".$horaInRg."|".$horaFnRg."";
//							return ;
//						}
//					}
				}
			}
			echo "1|";
		}
	}
	
	function validarHorarioProfesorMateriCompartida()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$idUsuario=$_POST["idUsuario"];
		$idPrograma=$_POST["idPrograma"];
		$idCiclo=$_POST["idCiclo"];
		$conMateriasProf="SELECT idMateria,idGrupo FROM 4047_participacionesMateria WHERE idUsuario=".$idUsuario." AND participacionP=1 AND estado=1";
		$matProf=$con->obtenerFilas($conMateriasProf);
		$numMatP=$con->filasAfectadas;
		if($numMatP==0)
		{
			echo"1|";
		}
		else
		{
	
			  $consulta="SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
								WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$idMateria." AND idGrupoCompartido=".$idGrupo." and ciclo=".$idCiclo;
			  //echo $consulta;
			  $res=$con->obtenerFilas($consulta);
			  $nFilas=$con->filasAfectadas;
			  
			  if($nFilas==0)
			  {
			  	echo "1|";
			  }
			  else
			  {
				  $mensajeDeColision="";
				  while($fila=mysql_fetch_row($matProf))	
				  {
				  		$horaMatProf="SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
								         WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$fila[0]." AND idGrupo=".$fila[1]." and ciclo=".$idCiclo;
						$respuesta=$con->obtenerFilas($horaMatProf);				 
						$numFilas=$con->filasAfectadas;
						
						if($numFilas==0)
				  		{
							$horaMatProf="SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
								    WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$fila[0]." AND idGrupoCompartido=".$fila[1]." and ciclo=".$idCiclo;
							$respuesta=$con->obtenerFilas($horaMatProf);		
						}
						while($filaMatP=mysql_fetch_row($respuesta))
						{
							mysql_data_seek($res,0);
							while($filaHmat=mysql_fetch_row($res))
							{
								if($filaMatP[0]==$filaHmat[0])
								{
									if(colisionaTiempo($filaMatP[1],$filaMatP[2],$filaHmat[1],$filaHmat[2]))
									{
										$nombreMat="SELECT titulo FROM 4013_materia WHERE idMateria=".$fila[0];
										$nombre=$con->obtenerValor($nombreMat);
										
										switch($filaHmat[0])
										{
										  case "1":
											  $dia="Lunes";
										  break;
										  case "2":
											  $dia="Martes";
										  break;
										  case "3":
											  $dia="Miercoles";
										  break;
										  case "4":
											  $dia="Jueves";
										  break;
										  case "5":
											 $dia="Viernes";
										  break;
										  case "6":
											  $dia="Sabado";
										  break;
										  case "7":
											 $dia="Domingo";
										}

										$colision="Tiene asignada la materia:&nbsp;<b>".$nombre."</b>&nbsp;el dia&nbsp;<b>".$dia."</b>&nbsp;de&nbsp;<b>".$filaHmat[1]."</b>&nbsp;a&nbsp;<b>".$filaHmat[2]."</b><br/>";
										//echo"2|".$dia."|".$filaHmat[1]."|".$filaHmat[2]."|".$nombre;
										//return ;	
										if($mensajeDeColision=="")
										  $mensajeDeColision=$colision;
									   else
										  $mensajeDeColision.=$colision;
									
									}
								}
							}
						}
				  }
				  
				  if($mensajeDeColision=="")
					echo "1|";
				  else
					echo "2|".$mensajeDeColision;
				 // echo "1|";
			  }
		
		}
	}
	
	function validarModificarHorarioMatC()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$idProfesor=$_POST["idProfesor"];
		$dia=$_POST["dia"];
		$horaIni=$_POST["horaIni"];
		$horaFin=$_POST["horaFin"];
		
		$conParticipacionPrincipal="SELECT idParticipante FROM 4047_participacionesMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND participacionP=1 AND estado=1 AND idUsuario=".$idProfesor;
		$id=$con->obtenerValor($conParticipacionPrincipal);
		
		if($id=="")
		{
			echo "1|";
		}
		else
		{
		
			$conMateriasProf="SELECT idMateria,idGrupo FROM 4047_participacionesMateria WHERE idUsuario=".$idProfesor." AND participacionP=1 AND estado=1 and idMateria<>".$idMateria." and idGrupo<>".$idGrupo;
			$matProf=$con->obtenerFilas($conMateriasProf);
			$numMatP=$con->filasAfectadas;
			if($numMatP==0)
			{
				echo"1|";
			}
			else
			{
				$mensajeDeColision="";
				while($fila=mysql_fetch_row($matProf))	
				{
					  //$horaMatProf="SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
//									   WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$fila[0]." AND idGrupo=".$fila[1]." and ciclo=".$idCiclo;
					  
					  $horaMatProf="(SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
						  WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$fila[0]." AND idGrupo=".$fila[1]." AND ciclo=".$idCiclo.")
						  UNION
						  (			  
						  SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
						  WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$fila[0]." AND idGrupoCompartido=".$fila[1]." AND ciclo=".$idCiclo.")
						  UNION
						  (SELECT dia,horaInicio,horaFin,idPrograma,'0' AS idPerfil FROM 4065_materiaVSGrupo 
						  WHERE  idMateria=".$fila[0]." AND idGrupo=".$fila[1]." AND ciclo=".$idCiclo.")";
					  $respuesta=$con->obtenerFilas($horaMatProf);				 
					  $numFilas=$con->filasAfectadas;
					  
					 // if($numFilas==0)
//					  {
//						  $horaMatProf="SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
//								  WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$fila[0]." AND idGrupoCompartido=".$fila[1]." and ciclo=".$idCiclo;
//						  $respuesta=$con->obtenerFilas($horaMatProf);		
//					  }
					  
					  while($filaMatP=mysql_fetch_row($respuesta))
					  {
							  if($filaMatP[0]==$dia)
							  {
								  if(colisionaTiempo($horaIni,$horaFin,$filaMatP[1],$filaMatP[2]))
								  {
									  $nombreMat="SELECT titulo FROM 4013_materia WHERE idMateria=".$fila[0];
									  $nombre=$con->obtenerValor($nombreMat);
									  
									  switch($filaMatP[0])
									  {
										case "1":
											$dia="Lunes";
										break;
										case "2":
											$dia="Martes";
										break;
										case "3":
											$dia="Miercoles";
										break;
										case "4":
											$dia="Jueves";
										break;
										case "5":
										   $dia="Viernes";
										break;
										case "6":
											$dia="Sabado";
										break;
										case "7":
										   $dia="Domingo";
									  }
									  $colision="Tiene asignada la materia:&nbsp;<b>".$nombre."</b>&nbsp;el dia&nbsp;<b>".$dia."</b>&nbsp;de&nbsp;<b>".$filaMatP[1]."</b>&nbsp;a&nbsp;<b>".$filaMatP[2]."</b><br/>";
									  
									  //echo"2|".$dia."|".$filaMatP[1]."|".$filaMatP[2]."|".$nombre;
									  //return ;
									   if($mensajeDeColision=="")
										  $mensajeDeColision="-".$colision;
									   else
										  $mensajeDeColision.="-".$colision;
								  }
						  }
					  }
				}
				if($mensajeDeColision=="")
					echo "1|";
				else
					echo "2|".$mensajeDeColision;
				//echo "1|";
			}
		}
	}
	
	
	function validarFechasMapaC()
	{
		global $con;
		$idMapaCurricular=$_POST["idMapaCurricular"];
		
		$consulta="SELECT idFechaCalendario FROM 4068_fechaCalendario WHERE idMapaCurricular=".$idMapaCurricular." AND idEtiqueta=10";
		$fechas=$con->obtenerValor($consulta);
		
		if($fechas=="")
			echo"1|";
		else
			echo "2|";
		
	}
	
	function guaradarMateriasPerfil()
	{
		global $con;
		$tipoPlaneacion=0;
		if(isset($_POST["tipoPlaneacion"]))
		{
			$tipoPlaneacion=$_POST["tipoPlaneacion"];
		}
		$idPerfil=$_POST["idPerfil"];
		$cadena=$_POST["arreglo"];
		$arreglo=explode(',',$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$y=0;
			for($x=0;$x<$tamano;$x++)
			{
				$idMateria=$arreglo[$x];
				$conExiste="select idMateriaVSPerfilPlaneacion from 4188_materiaVSPerfilPlaneacion where idMateria=".$idMateria." and idPerfilPlaneacionVSMapa=".$idPerfil;
				$existe=$con->obtenerValor($conExiste);
				if($existe=="")
				{
					$query[$y]="INSERT INTO 4188_materiaVSPerfilPlaneacion(idMateria,idPerfilPlaneacionVSMapa,tipoPlaneacion) VALUES('".$idMateria."','".$idPerfil."','".$tipoPlaneacion."')";
					$y++;
				}
			}
			$query[$y]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "2|";
		}
	}
	
	function eliminarMateriasPerfil()
	{
		global $con;
		$id=$_POST["id"];
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$x=0;
			$consulta="select idMateria FROM 4188_materiaVSPerfilPlaneacion WHERE idMateriaVSPerfilPlaneacion=".$id;
			$idMateria=$con->obtenerValor($consulta);
		
			$conPlaneacionesMat="SELECT idPlaneacionMateria FROM 4171_planeacionMateria WHERE idMateria=".$idMateria;
			$resPlaneacionesMat=$con->obtenerFilas($conPlaneacionesMat);
			
			while($filaP=mysql_fetch_row($resPlaneacionesMat))
			{
				$query[$x]="delete from FROM 4174_reporteMateria WHERE idPlaneacionMateria=".$filaP[0];
				$x++;
			}
			
			$query[$x]="DELETE FROM 4171_planeacionMateria where idMateria=".$idMateria;
			$x++;
			
			$query[$x]="DELETE FROM 4188_materiaVSPerfilPlaneacion WHERE idMateriaVSPerfilPlaneacion=".$id;
			$x++;
			
			$query[$x]="commit";
			
			if($con->ejecutarBloque($query))
				echo"1|";
			else
				echo "2|";
		}
	}
	
	function eliminarPerfilMapa()
	{
		global $con;
		
		$id=$_POST["id"];
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$x=0;
			$consultaMaterias="SELECT idMateria FROM 4188_materiaVSPerfilPlaneacion WHERE idPerfilPlaneacionVSMapa=".$id;
			$resMaterias=$con->obtenerFilas($consultaMaterias);
			while($filaM=mysql_fetch_row($resMaterias))
			{
				$conPlaneacionesMat="SELECT idPlaneacionMateria FROM 4171_planeacionMateria WHERE idMateria=".$filaM[0];
				$resPlaneacionesMat=$con->obtenerFilas($conPlaneacionesMat);
				
				while($filaP=mysql_fetch_row($resPlaneacionesMat))
				{
					$query[$x]="DELETE FROM 4174_reporteMateria WHERE idPlaneacionMateria=".$filaP[0];
					$x++;
				
				}
				
				$query[$x]="DELETE FROM 4171_planeacionMateria where idMateria=".$filaM[0];
				$x++;
			}
	
			
			$query[$x]="DELETE FROM 4188_materiaVSPerfilPlaneacion WHERE idPerfilPlaneacionVSMapa=".$id;
			$x++;
			
			$query[$x]="DELETE FROM 4172_elementosPlaneacion WHERE idPerfilPlaneacionVSMapa=".$id;
			$x++;
			
			$query[$x]="DELETE FROM 4187_mapaVSPlaneaciones WHERE idPerfilPlaneacionVSMapa=".$id;
			$x++;
	
			$query[$x]="commit";
			
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo"2|";
		}
	}
	
	function guardarMatRequisito()
	{
		global $con;
		$cadena=$_POST["cadena"];
		$arreglo=explode(',',$cadena);
		$tamano=sizeof($arreglo);
		$idElementoMapa=$_POST["idElementoMapa"];
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$y=0;
			for($x=0;$x<$tamano;$x++)
			{
				$idMateria=$arreglo[$x];
				
				$conExiste="SELECT idElementoMapa FROM 4190_materiaRequisitoVSElemento WHERE idMateria=".$idMateria." AND idElementoMapa=".$idElementoMapa ;
				$existe=$con->obtenerValor($conExiste);
				if($existe=="")
				{
					$query[$y]="INSERT INTO 4190_materiaRequisitoVSElemento(idElementoMapa,idMateria) VALUES ('".$idElementoMapa."','".$idMateria."')";
					$y++;
				}
			}
			$query[$y]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "2|";
		}
	}
	
	function guardarTipoMatRequisito()
	{
		global $con;
		$cadena=$_POST["cadena"];
		$idElementoMapa=$_POST["idElementoMapa"];
		if($cadena=="")
		{
			$registros=array();
			$tamano=sizeof($registros);
			//echo"1|";
			//return ;
		}
		else
		{
			$registros=explode(',',$cadena);
			$tamano=sizeof($registros);
		}
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			$costo=0;
			$costo=$_POST["costo"];
			$nCreditos=$_POST["nCreditos"];
			$inscribe=$_POST["inscribe"];
			$cierraGrupo=$_POST["cierraGrupo"];
			for($x=0;$x<$tamano;$x++)
			{
				$datos=explode('_',$registros[$x]);
				$conExiste="SELECT idMatRequisitoVSElemento FROM 4190_materiaRequisitoVSElemento WHERE idMatRequisitoVSElemento=".$datos[0];
				$existe=$con->obtenerValor($conExiste);
				if($existe!="")
				{
					$query[$ct]="UPDATE 4190_materiaRequisitoVSElemento SET idTipoRequisito='".$datos[1]."' WHERE idMatRequisitoVSElemento=".$datos[0];
					$ct++;
				}
			}
			
			$conExisteElemento="SELECT idElementoMapaVSReglas FROM 4189_elementoMapaVSReglas WHERE idElementoMapa=".$idElementoMapa;
			$existeElemento=$con->obtenerValor($conExisteElemento);
			if($existeElemento=="")
			{
				$query[$ct]="INSERT INTO 4189_elementoMapaVSReglas(idElementoMapa,noCreditosCubiertos,inscribe,cierraGrupo,costo) VALUES('".$idElementoMapa."','".$nCreditos."','".$inscribe."','".$cierraGrupo."','".$costo."')";
				$ct++;
			}
			else
			{
				$query[$ct]="UPDATE 4189_elementoMapaVSReglas SET noCreditosCubiertos='".$nCreditos."',inscribe='".$inscribe."',cierraGrupo='".$cierraGrupo."',costo='".$costo."' WHERE idElementoMapaVSReglas=".$existeElemento;
				$ct++;
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo"1|";
			else
				echo"2|";
		}
	}
	
	function eliminarMatRequisito()
	{
		global $con;
		$id=$_POST["id"];
		
		$consulta="DELETE FROM 4190_materiaRequisitoVSElemento WHERE idMatRequisitoVSElemento=".$id;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "2|";
	}
	
	function excluirMatFormato()
	{
		global $con;
		$idMapaCurricular=$_POST["idMapaCurricular"];
		$materias=$_POST["materias"];
		
		$arreglo=explode(',',$materias);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
		  $ct=0;
		  for($x=0;$x<$tamano;$x++)
		  {
			  $idMateria=$arreglo[$x];
			  $conExiste="SELECT idMateriaExcluida FROM 4196_materiasExcluidasPlaneacion WHERE idMateria=".$idMateria." AND idMapaCurricular=".$idMapaCurricular;
			  $existe=$con->obtenerValor($conExiste);
			  if($existe=="")
				  $query[$ct]="INSERT INTO 4196_materiasExcluidasPlaneacion(idMateria,idMapaCurricular) VALUES('".$idMateria."','".$idMapaCurricular."')";
			  
			  $ct++;
		  }
		  $query[$ct]="commit";
		  if($con->ejecutarBloque($query))
		  	echo"1|";
		  else
		  	echo"2|";
		}
	}
	
	function agregarCurso()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrado=$_POST["idGrado"];
		$idCiclo=$_POST["idCiclo"];
		$idPrograma=$_POST["idPrograma"];
		$sede=$_POST["sede"];
		$fecha='';
		//$fecha=date('Y/m/d');
		$idMapaCiclo=$_POST["idMapaCiclo"];
		$idMapaCurricular=$_POST["idMapaCurricular"];
		
		$conIdModalidad="SELECT idModalidadCurso FROM 4241_nuevosMapas WHERE idMapaCiclo=".$idMapaCiclo;
		$idModalidad=$con->obtenerValor($conIdModalidad);
		if($idModalidad=="")
			$idModalidad="-1";
		
		$conDatosMapa="SELECT 	generarGrupos,modoPrefijo,prefijo,valorInicio,incremento FROM 4029_mapaCurricular WHERE idMapaCurricular=".$idMapaCurricular;
		//echo $conDatosMapa;
		$filaMapa=$con->obtenerPrimeraFila($conDatosMapa);
		if($filaMapa[2]=="")
			$filaMapa[2]="Grupo";
		
		if($filaMapa[4]=="")	
			$filaMapa[4]=1;
		
		if(($filaMapa[0]==1) || ($filaMapa[0]==""))
		{
			$nombreGrupo="Grupo";
			$consulta="INSERT INTO 4048_grupos  (idMateria,idSituacion,ciclo,idPrograma,idGrado,sede,nombreGrupo,cupoMinimo,cupoMaximo,idModalidad) VALUES('".$idMateria."','1',".$idCiclo.",".$idPrograma.",".$idGrado.",'".$sede."','".$nombreGrupo."',0,0,".$idModalidad.")";
			if($con->ejecutarConsulta($consulta))
				echo "1|";
			else
				echo "|";
		}
		else
		{
			  
			  $numeroGruposMateria="SELECT noGrupos FROM 4013_materia WHERE idMateria=".$idMateria;
			  $numeroGruposM=$con->obtenerValor($numeroGruposMateria);
			  if(($numeroGruposM=="") || ($numeroGruposM==0))
			  {
			  	echo "2|";
				return;
			  }
			  $nuevoNumero=0;
			  $conNumeroG="SELECT noIncrementable FROM 4237_incrementableGrupoMateria WHERE idMateria=".$idMateria." AND idMapaCurricular='".$idMapaCiclo."'";
			  //echo $conNumeroG;
			  $nGrupo=$con->obtenerValor($conNumeroG);
			  if($nGrupo=="")
			  {
				  $insertar="INSERT INTO 4237_incrementableGrupoMateria (idMapaCurricular,idMateria,sede,noIncrementable,incremento)
							 VALUES(".$idMapaCiclo.",".$idMateria.",'".$sede."',0,".$filaMapa[4].")";
				  
				  if($con->ejecutarConsulta($insertar))		   
				  {
					  $consulta="begin";
					  if($con->ejecutarConsulta($consulta))
					  {
						  $ctAux=0;
						  $conIncrementable="SELECT noIncrementable FROM 4237_incrementableGrupoMateria WHERE idMateria=".$idMateria." AND idMapaCurricular='".$idMapaCiclo."' for update";
						  $ultimoInc=$con->obtenerValor($conIncrementable); 
						  if($ultimoInc=="")
							  $ultimoInc=0;
						  $nuevoNumero=$ultimoInc+1;
						  
						  $queryAux[$ctAux]="UPDATE 4237_incrementableGrupoMateria SET noIncrementable=".$nuevoNumero." where idMateria=".$idMateria." AND idMapaCurricular='".$idMapaCiclo."'";
						  $ctAux++;
						  $queryAux[$ctAux]="commit";
						  $con->ejecutarBloque($queryAux);
					  }
				  }
			  }
			  else

			  {
				  $consulta="begin";
				  if($con->ejecutarConsulta($consulta))
				  {
					  $ctAux=0;
					  $conIncrementable="SELECT noIncrementable FROM 4237_incrementableGrupoMateria WHERE idMateria=".$idMateria." AND idMapaCurricular='".$idMapaCiclo."' for update";
					  $ultimoInc=$con->obtenerValor($conIncrementable); 
					  if($ultimoInc=="")
						  $ultimoInc=0;
					  $nuevoNumero=$ultimoInc+1;
					  
					  $queryAux[$ctAux]="UPDATE 4237_incrementableGrupoMateria SET noIncrementable=".$nuevoNumero." where idMateria=".$idMateria." AND idMapaCurricular='".$idMapaCiclo."'";
					  $ctAux++;
					  $queryAux[$ctAux]="commit";
					  $con->ejecutarBloque($queryAux);
				  }
			  }
			  
			  $conGruposExistentes="SELECT COUNT(idGrupo) FROM 4048_grupos WHERE idMateria=".$idMateria." AND sede='".$sede."' AND ciclo=".$idCiclo." AND idModalidad=".$idModalidad;
			  //echo $conGruposExistentes;
			  $numeroGruposExistentes=$con->obtenerValor($conGruposExistentes);
			  
			  //echo "dd".trim($numeroGruposM)."--".trim($numeroGruposExistentes);
			  if(trim($numeroGruposExistentes)>=trim($numeroGruposM))
			  {
			  	  echo "3|".$numeroGruposM;
				  return;
			  }
			  $nombreGrupo=$filaMapa[2]."&nbsp;".$nuevoNumero;
			  
			  $consulta="INSERT INTO 4048_grupos  (idMateria,idSituacion,ciclo,idPrograma,idGrado,sede,nombreGrupo,cupoMinimo,cupoMaximo,idModalidad) VALUES('".$idMateria."','1',".$idCiclo.",".$idPrograma.",".$idGrado.",'".$sede."','".$nombreGrupo."',0,0,".$idModalidad.")";
			  if($con->ejecutarConsulta($consulta))
				  echo "1|";
			  else
				  echo "|";
		}
	}
	
	function obtenerFechasCurso()
	{
		global $con;
		$idTabla=base64_decode($_POST["idT"]);

		$consulta="select fechaInicio,fechaFin from 4048_grupos where idGrupo=".$idTabla;
		$fila=$con->obtenerPrimeraFila($consulta);
		$fInicio=$fila[0];
		if($fInicio!="")
			$fInicio=date("d/m/Y",strtotime($fInicio));
		$fFin=$fila[1];
		if($fFin!="")
			$fFin=date("d/m/Y",strtotime($fFin));
		//$comp="";
		//if($tipo!=1)
//		{
//			if($fila[2]=="0")
//				$consulta="select fechaInicio,fechaFin from 4014_grados where idGrado=".$fila[3];
//			else
//				$consulta="select mat.fechaInicio,mat.fechaFin from 4031_elementosMapa em,4029_mapaCurricular mc,4013_materia mat where mat.idMateria=em.idMateria and mc.idMapaCurricular=em.idMapaCurricular and mc.idPrograma=".$fila[4]." and em.idMateria=".$fila[2];	
//			$fila=$con->obtenerPrimeraFila($consulta);
//			$fInicioPadre=$fila[0];
//			if($fInicioPadre!="")
//				$fInicioPadre=date("d/m/Y",strtotime($fInicioPadre));
//			$fFinPadre=$fila[1];
//			if($fFinPadre!="")
//				$fFinPadre=date("d/m/Y",strtotime($fFinPadre));
//				
//			$consulta="select idMateria,idTipoComponente from 4031_elementosMapa em where em.idElementoMapa=".$idElemento;
//			$filaElem=$con->obtenerPrimeraFila($consulta);
//			if(($filaElem[1]==1)||($filaElem[1]==3))
//			{
//				$consulta="select min(m.fechaInicio),max(m.fechaFin) from 4031_elementosMapa em,4013_materia m where m.idMateria=em.idMateria and em.idPadre=".$filaElem[0];
//				$filaFecha=$con->obtenerPrimeraFila($consulta);
//				if($filaFecha[0]!="")
//					$comp="|".date("d/m/Y",strtotime($filaFecha[0]))."|".date("d/m/Y",strtotime($filaFecha[1]));
//				else
//					$comp="||";
//					
//			}
//			$comp="|".$fInicioPadre."|".$fFinPadre.$comp;
//		}
//		else
//		{
//			$conDatosGrado="SELECT idPrograma,ciclo FROM 4014_grados WHERE idGrado=".$idElemento;
//			$datosG=$con->obtenerPrimeraFila($conDatosGrado);
//			$idPrograma=$datosG[0];
//			$idCiclo=$datosG[1];
//			
//			$conMapa="select idMapaCurricular from 4029_mapaCurricular where idPrograma=".$idPrograma." and ciclo=".$idCiclo;
//			$idMapaCurricular=$con->obtenerValor($conMapa);
//			if($idMapaCurricular=="")
//				$idMapaCurricular="-1";
//			//$consulta="select min(mat.fechaInicio),max(mat.fechaFin) from 4031_elementosMapa em,4013_materia mat where mat.idMateria=em.idMateria and em.idGrado=".$idElemento;
//			$consulta="SELECT fechaInicio,fechaFin FROM 4068_fechaCalendario WHERE idMapaCurricular=".$idMapaCurricular." AND idEtiqueta=10";
//			$fila=$con->obtenerPrimeraFila($consulta);
//			$fInicioPadre=$fila[0];
//			if($fInicioPadre!="")
//				$fInicioPadre=date("d/m/Y",strtotime($fInicioPadre));
//			$fFinPadre=$fila[1];
//			if($fFinPadre!="")
//				$fFinPadre=date("d/m/Y",strtotime($fFinPadre));
//			$comp="|".$fInicioPadre."|".$fFinPadre;
//		}
		
		//echo "1|".$fInicio."|".$fFin.$comp;
		echo "1|".$fInicio."|".$fFin;
	}
	
	function guardarFechasCurso()
	{
		global $con;
		
		$idT=base64_decode($_POST["idT"]);
		$fInicio=$_POST["fInicio"];
		$fFin=$_POST["fFin"];
		$idE=$_POST["idElemento"];
		$idMapaCiclo=$_POST["idMapaCiclo"];
		$idGrado=$_POST["idGrado"];
			
		$query="SELECT idTipoHorario,noSemanas FROM 4031_elementosMapa WHERE idElementoMapa=".$idE;
		$tipoH=$con->obtenerPrimeraFila($query);
		
		if($tipoH[0]=='2')
			$fFin= date("Y-m-d",strtotime('+ '.((7*$tipoH[1])-1).' days ',strtotime(cambiaraFechaMysql($fInicio))));
		else
			$fFin=cambiaraFechaMysql($fFin);
		
		
		$conBloquesFechas="SELECT fechaInicio,fechaFin FROM 4242_bloquesGrados WHERE idGrado=".$idGrado." AND idMapaCiclo=".$idMapaCiclo;
		$res=$con->obtenerFilas($conBloquesFechas);
		$noFilas=$con->filasAfectadas;
		if($noFilas==0)
		{
		  //$consulta="update 4048_grupos set fechaInicio='".cambiaraFechaMysql($fInicio)."',fechaFin='".$fFin."' where idGrupo=".$idT;
		  //if($con->ejecutarConsulta($consulta))
			  //echo "1|";
		  //else
			  //echo "|";
		  echo "3|"	;
		}
		else
		{
			$mensaje="";
			$encontroIni=0;
			$encontroFin=0;
			$validarIni=cambiaraFechaMysql($fInicio);
			//echo $validarIni;
			if($tipoH[0]==1)
			{
				$validarFin=cambiaraFechaMysql($fFin);
			}
			else
			{
				$validarFin=$fFin;
			}
			//echo $validarFin;
			while($fila=mysql_fetch_row($res))
			{
				//echo $fila[0]."-inicio-".$validarIni;
				if($fila[0]===$validarIni)
				{
					$encontroIni=1;
				}
				//echo $fila[1]."-fin-".$validarFin;
				if($fila[1]===$validarFin)
				{
					$encontroFin=1;
				}
			}
			
			if(($encontroIni==1) && ($encontroFin==1))
			{
				$consulta="update 4048_grupos set fechaInicio='".cambiaraFechaMysql($fInicio)."',fechaFin='".$fFin."' where idGrupo=".$idT;
				if($con->ejecutarConsulta($consulta))
					echo "1|";
				else
					echo "|";
		    }
			else
			{
				if(($encontroIni==0) && ($encontroFin==0))
				{
					$mensaje="La fecha de inicio y fin no coinciden con las fechas de bloques";
				}
				else
				{
					if($encontroIni==0)
					{
						$mensaje="La fecha de inicio no coincide con las fechas de bloques";
					}
					
					if($encontroFin==0)
					{
						$mensaje="La fecha de fin no coincide con las fechas de bloques";
					}
				}
				
				echo "2|".$mensaje;
			}
		}
	}
	
	function guardarProfesorCurso()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$idMateria=$_POST["idMateria"];
		$idUsuario=$_POST["idUsuario"];
		$idCiclo=$_POST["idCiclo"];
		$idParticipacion=$_POST["idParticipacion"];
		$idMapaCurricular=$_POST["idMapa"];
		$bandera=$_POST["bandera"];
		
		$conPartPrin="SELECT idParticipacionPrincipal FROM 4029_mapaCurricular WHERE idMapaCurricular=".$idMapaCurricular;
		$idParticipacionPrincipal=$con->obtenerValor($conPartPrin);
		
		$participacionP=0;
		if($idParticipacionPrincipal==$idParticipacion)
			$participacionP=1;
		
		$conHorarioMat="SELECT dia,horaInicio,horaFin,idMateriaVSGrupo FROM 4065_materiaVSGrupo WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." and ciclo=".$idCiclo;
		$resHorario=$con->obtenerFilas($conHorarioMat);
		
		$query="select titulo,horasTotal,fechaInicio,fechaFin from 4013_materia where idMateria=".$idMateria;
		$filaMat=$con->obtenerPrimeraFila($query);
		
		$query="select idPrograma,ciclo from 4013_materia where idMateria=".$idMateria;
		$filaMateria=$con->obtenerPrimeraFila($query);
		
		$query="SELECT idParticipacionCoordinador FROM 4029_mapaCurricular WHERE idPrograma=".$filaMateria[0]." AND ciclo=".$filaMateria[1];
		$idCoordinador=$con->obtenerValor($query);
		
		$conFechasGrupo="SELECT fechaInicio,fechaFin FROM 4048_grupos WHERE idGrupo=".$idGrupo;
		$fechasGrupo=$con->obtenerPrimeraFila($conFechasGrupo);
		$fechaInicio="";
		$fechaFin="";
		if($fechasGrupo[0]!="")
		{
			$fechaInicio=$fechasGrupo[0];
			$fechaFin=$fechasGrupo[1];
		}
		
		//$consulBloque="select idParticipante from 4218_participacionCurso where idUsuario=".$idUsuario." and idMateriaVSCurso=".$idCurso." and idParticipacion=".$idParticipacion." and estado=1";
//		$valor=$con->obtenerValor($consulBloque);
		$conParticipacion="SELECT idParticipante FROM 4047_participacionesMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND idParticipacion=".$idParticipacion." AND estado=1";
		//echo $conParticipacion;
		$valor=$con->obtenerValor($conParticipacion);
		$x=0;
		if($valor=="")
		{
			$conExisteParticipacionP="SELECT idParticipante FROM 4047_participacionesMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND participacionP=1 AND estado=1";
			//echo $conExisteParticipacionP;
			$existePartiP=$con->obtenerValor($conExisteParticipacionP);
			if($existePartiP!="")
			{
				if($participacionP==1)
				{
					echo "4|";
					return;
				}
			}
			
			if($participacionP==1)
			{
				$validarNumeroHoras=validarMaximoHorasPeriodo($idUsuario,$idCiclo,$idMateria,$idGrupo);
				if($validarNumeroHoras==1)
				{
					$validarH=validarHorarioCursos($idMateria,$idGrupo,$idUsuario,$idCiclo);
					$datosVal=explode("|",$validarH);
					if($datosVal[0]==1)
					{
						$consulta[$x]="begin";
						$x++;
						
						$conExiste="SELECT idTipoHorarioCurso FROM 4226_tipoHorarioCurso WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo;
						$existe=$con->obtenerValor($conExiste);
						if($existe=="")
						{
						    $consulta[$x]="INSERT INTO 4226_tipoHorarioCurso(idGrupo,idMateria,aplicacionHorario) VALUES(".$idGrupo.",".$idMateria.",".$bandera.")";
							$x++;
						}
						
						$consulta[$x]="INSERT INTO 4047_participacionesMateria(idUsuario,idMateria,idGrupo,idParticipacion,participacionP,estado,esperaContrato)
										VALUES('".$idUsuario."','".$idMateria."','".$idGrupo."','".$idParticipacion."',1,1,1)";
						$x++;
						if($fechaInicio=="")
							$fechaInicio="NULL";
						else
							$fechaInicio="'".$fechaInicio."'";
						if($fechaFin=="")
							$fechaFin="NULL";
						else
							$fechaFin="'".$fechaFin."'";
						if($participacionP=="1")
						{
							$consulta[$x]="insert into 965_actividadesUsuario(tipoActividadProgramada,actividad,fechaInicio,fechaFin,prioridad,idUsuario,idProcesoAsociado,idReferencia,idPadre,horasTotal,raizUsuario,idMateria,idGrupo)
											values(3,'Clase: ".$filaMat[0]." ',".$fechaInicio.",".$fechaFin.",1,".$idUsuario.",-1,-1,-1,".$filaMat[1].",1,".$idMateria.",null)";
							
							$x++;
						}
						
						if($idCoordinador==$idParticipacion)
						{
							$query="select idUsuario from 807_usuariosVSRoles where idUsuario=".$idUsuario." and codigoRol='-101_0'";
							$resUsuario=$con->obtenerValor($query);
							if($resUsuario=="")
							{
								$consulta[$x]="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$idUsuario.",-101,0,'-101_0')";
								$x++;
							}
						}
						
						$consulta[$x]="commit";
						$x++;
						
						if($con->ejecutarBloque($consulta))		   
							echo "1|";
						else
							echo "2|";
					}
					else
					{
						echo "7|".$datosVal[1];
					}
				}
				else
				{
					if($validarNumeroHoras==2)
						echo "5|";//excede el numero de horas con las materias que ya tenia
					else
						echo "6|";//con la nueva materia excede el maximo de horas
					
					return;
				}
			}
			else
			{
				$query="INSERT INTO 4047_participacionesMateria(idUsuario,idMateria,idGrupo,idParticipacion,participacionP,estado,esperaContrato)
                        VALUES(".$idUsuario.",".$idMateria.",".$idGrupo.",".$idParticipacion.",0,1,0)";
				if($con->ejecutarConsulta($query))		
					echo "1|";
				else
					echo "|";
			}
		}
		else
		{
			//if($valor==$idParticipacionPrincipal)
			//{
				echo "3|";
			//}
			//else
			//{
				//$query="INSERT INTO 4047_participacionesMateria(idUsuario,idMateria,idGrupo,idParticipacion,participacionP,estado,esperaContrato)
						//VALUES(".$idUsuario.",".$idMateria.",".$idGrupo.",".$idParticipacion.",".$participacionP.",1,0)";
			//}
		}
	}
	
	function comprobarHorarioProfesorCurso()
	{
		global $con;
		$idCurso=$_POST["idCurso"];
		$idUsuario=$_POST["idUsuario"];
		
		$horarioCurso="SELECT dia,horaInicio,horaFin FROM 4219_horarioCurso WHERE idMateriaVSCurso=".$idCurso;
		$horario=$con->obtenerfilas($horarioCurso);
		$filasH=$con->filasAfectadas;
		if($filasH==0)
		{
			echo "1|";
			return;
		}
		
		
		$materiasProfesor="SELECT idMateria,idGrupo FROM 4047_participacionesMateria WHERE idUsuario=".$idUsuario." AND participacionP=1 AND estado=1";
		$resMateriasProf=$con->obtenerFilas($materiasProfesor);
		$numMat=$con->filasAfectadas;
		
		if($numMat==0)
		{
			echo "1|";
		}
		else
		{
			  
			  $consultaHorarioMateria="select m.idBloque, m.idMateria,m.horaInicio,m.horaFin,b.dia from 4065_materiaVSGrupo m,4062_perfilVSBloque b
						 where idMateria=".$idMateria." and ciclo=".$idCiclo." and idGrupo=".$idGrupo." and m.idbloque=b.idPerfilVSBloque and idPrograma=".$idPrograma." and ciclo=".$idCiclo;
			  $resHorarioMateria=$con->obtenerFilas($consultaHorarioMateria);
			  $numeroFilasM=$con->filasAfectadas;
			  if($numeroFilasM==0)
			  {
				echo "1|";
			  }
			  else
			  {
			 
				  $mensajeColision="";
				  while($matProf=mysql_fetch_row($resMateriasProf)) //ciclo para materias del profesor
				  {
						$conHorMat="SELECT p.dia,m.horaInicio,m.horaFin FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
							WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$matProf[0]." AND idGrupo=".$matProf[1]." and ciclo=".$idCiclo;
						$resHorMat=$con->obtenerFilas($conHorMat);
						
						
						while($fila=mysql_fetch_row($resHorMat))//ciclo para el horario de cada una de las materias
						{
							mysql_data_seek($resHorarioMateria,0);	
							while($hMat=mysql_fetch_row($resHorarioMateria))			
							{	
								if($fila[0]==$hMat[4])
								{
									  
									  if( (($fila[1] >= $hMat[1]) && ($fila[1] < $hMat[2])) || (($fila[2] > $hMat[1])  && ($fila[2] <= $hMat[2])) )
									  {
									
										   $nombreMateria="select titulo from 4013_materia where idMateria=".$matProf[0];
										   $nombre=$con->obtenerPrimeraFila($nombreMateria);
										   
										   $consultaGrupo="select *from 4048_grupos where idGrupo=".$matProf[1];
										   $datos=$con->obtenerPrimeraFila($consultaGrupo);
										   
										   $consultaPrograma="select *from 4004_programa where idPrograma=".$datos[2];
										   $programa=$con->obtenerPrimeraFila($consultaPrograma);
										   
										   $consultaGrado="select *from 4014_grados where idGrado=".$datos[3];
										   $grado=$con->obtenerPrimeraFila( $consultaGrado);
										   
											 switch($fila[4])
											  {
												case "1":
													$dia="Lunes";
												break;
												case "2":
													$dia="Martes";
												break;
												case "3":
													$dia="Miercoles";
												break;
												case "4":
													$dia="Jueves";
												break;
												case "5":
												   $dia="Viernes";
												break;
												case "6":
													$dia="Sabado";
												break;
												case "7":
												   $dia="Domingo";
											  }
										   
										   $colision="Tiene asignada la materia:&nbsp;<b>".$nombre[0]."</b>&nbsp;el dia&nbsp;<b>".$dia."</b>&nbsp;de&nbsp;<b>".$fila[1]."</b>&nbsp;a&nbsp;<b>".$fila[2]."</b><br/>";
											if($mensajeColision=="")
												$mensajeColision=$colision;
											else
												$mensajeColision.=$colision;
											
									  }
									  else
									  {
										 if( ( ($hMat[1] >= $fila[1]) && ($hMat[1]< $fila[2] )) ||  (($hMat[2] > $fila[1]) &&  ($hMat[2]<= $fila[2] )) )
										  {
												 $nombreMateria="select titulo from 4013_materia where idMateria=".$matProf[0];
												 $nombre=$con->obtenerPrimeraFila($nombreMateria);
												 
												 if($matProf[0]==0)
												 {
													 $consultaGrupo="select *from 4048_grupos where idGrupo=".$$matProf[1];
													 $datos=$con->obtenerPrimeraFila($consultaGrupo);
													 
													 $consultaPrograma="select *from 4004_programa where idPrograma=".$datos[2];
													 $programa=$con->obtenerPrimeraFila($consultaPrograma);
												 }
												 else
												 {
													 $consultaGrupo="select *from 4048_grupos where idGrupo=".$matProf[1];
													 $datos=$con->obtenerPrimeraFila($consultaGrupo);
													 
													 $consultaPrograma="select *from 4004_programa where idPrograma=".$datos[2];
													 $programa=$con->obtenerPrimeraFila($consultaPrograma);
													 
													 $consultaGrado="select *from 4014_grados where idGrado=".$datos[3];
													 $grado=$con->obtenerPrimeraFila( $consultaGrado);
												 }
													 
												   switch($fila[0])
													{
													  case "1":
														  $dia="Lunes";
													  break;
													  case "2":
														  $dia="Martes";
													  break;
													  case "3":
														  $dia="Miercoles";
													  break;
													  case "4":
														  $dia="Jueves";
													  break;
													  case "5":
														 $dia="Viernes";
													  break;
													  case "6":
														  $dia="Sabado";
													  break;
													  case "7":
														 $dia="Domingo";
													}
												 
												   $colision="Tiene asignada la materia:&nbsp;<b>".$nombre[0]."</b>&nbsp;el dia&nbsp;<b>".$dia."</b>&nbsp;de&nbsp;<b>".$fila[1]."</b>&nbsp;a&nbsp;<b>".$fila[2]."</b><br/>";
													if($mensajeColision=="")
														$mensajeColision=$colision;
													else
														$mensajeColision.=$colision;
										  }
									  }
								}
							}
						}
				  }
			  if($mensajeColision=="")
				  echo"1|";
			  else
				  echo"2|".$mensajeColision;
			  }
		
		}
	}
	
	function borrarProfesorCurso()
	{
		global $con;
		
		$idTabla=base64_decode($_POST["idTabla"]);
		$idParticipacion=base64_decode($_POST["idParticipacion"]);
		$idCiclo=base64_decode($_POST["idCiclo"]);
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			if($idParticipacion==1)
			{
				$conFechasInicio="SELECT fechaInicio,fechaFin FROM 4048_grupos WHERE idGrupo=".$idGrupo;
				$fechas=$con->obtenerPrimeraFila($conFechasInicio);
				if($fechas[0]=="")
				{
					$query[$ct]="DELETE FROM 4047_participacionesMateria WHERE idParticipante=".$idTabla;
					$ct++;
				}
				else
				{
					$fechaActual=date("Y-m-d");
					if(($fechaActual>$fechas[0]) && ($fechaActual<$fechas[1]))
					{
						$query[$ct]="UPDATE 4047_participacionesMateria set estado='2' WHERE idParticipante=".$idTabla;
						$ct++;
					}
					else
					{
						$query[$ct]="DELETE FROM 4047_participacionesMateria WHERE idParticipante=".$idTabla;
						$ct++;
					}
				}
				
				$conDatos="SELECT idMateria,idGrupo FROM 4047_participacionesMateria WHERE idParticipante=".$idTabla;
				$datos=$con->obtenerPrimeraFila($conDatos);
				if($datos[0]!="")
				{
					$conAplicacionHorario="SELECT aplicacionHorario FROM 4226_tipoHorarioCurso WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo;
					$tipoH=$con->obtenerValor($conAplicacionHorario);
					if($tipoH!="")
					{
						if($tipoH==2)//materia se apega a profesor
						{
							$query[$ct]="DELETE FROM 4226_tipoHorarioCurso WHERE idMateria=".$datos[0]." AND idGrupo=".$datos[1];
					        $ct++;
							 
						}
						
					}
					//$conDatosGrupo="SELECT ciclo,idPrograma,sede,idModalidad FROM 4048_grupos WHERE idGrupo=".$idGrupo;
					//$datos=$con->obtenerPriemarFila($conDatosGrupo);
					
					//$query[$ct]="DELETE FROM 4065_materiaVSGrupo WHERE idMateria=".$datos[0]." AND idGrupo=".$datos[1]." AND ciclo=".$idCiclo;
					//$ct++;
				}
			}
			else
			{
				$query[$ct]="DELETE FROM 4047_participacionesMateria WHERE idParticipante=".$idTabla;
				$ct++;
			}
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function modificarCurso()
	{
		global $con;
		$idCurso=base64_decode($_POST["idCurso"]);
		$idRecurso=base64_decode($_POST["idRecurso"]);
		$valor=$_POST["vMin"];
		
		$query="UPDATE 4048_grupos SET idRecurso='".$idRecurso."' WHERE idGrupo=".$idCurso;
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerCapacidadRecurso()
	{
		global $con;
		$idRecurso=$_POST["idRecurso"];
		
		$consulta="SELECT capacidad FROM 4009_recursos WHERE idRecurso=".$idRecurso;
		$valor=$con->obtenerValor($consulta);
		
		if($valor=="")
			echo "-100|"	;
		else
			echo "1|".$valor;
		
	}
	
	function eliminarCurso()
	{
		global $con;
		
		$id=base64_decode($_POST["id"]);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			
			$query[$ct]="DELETE FROM 4048_grupos WHERE idGrupo=".$id;
			$ct++;
			
			$query[$ct]="DELETE FROM 4047_participacionesMateria WHERE idGrupo=".$id;
			$ct++;
			
			$query[$ct]="DELETE FROM 4065_materiaVSGrupo WHERE idGrupo=".$id;
			$ct++;
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "1|";
		}
	}
	
	function guaradarRolesPermisoControlE()
	{
		global $con;
		$tPermiso=$_POST["permiso"];
		$rol=$_POST["rol"];
		$acciones=$_POST["acciones"];
		
		$arrRol=explode("|",$rol);
		$rol=$arrRol[0];
		//$comp=$arrRol[1];
		
		
		$consulta="insert into 4220_permisosControlEscolar(tipoPermiso,rol,acciones) values(".$tPermiso.",'".$rol."','".$acciones."')";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	
	}
	
	function borrarRolesPermisoControlE()
	{
		global $con;
		$tPermiso=$_POST["tPermiso"];
		$lista=$_POST["rol"];
		$arreglo=explode(",",$lista);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			
			for($x=0;$x<$tamano;$x++)
			{
				$query[$ct]="DELETE FROM 4220_permisosControlEscolar WHERE tipoPermiso=".$tPermiso." AND rol=".$arreglo[$x];
				$ct++;
			}
			
			$query[$ct]="commit";
			
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	
	}
	
	function buscarUsuariosSede()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$campoB=$_POST["campoBusqueda"];
		$cadena=$_POST["cadena"];
		switch($campoB)
		{
			case "1": //Paterno
				$consulta="select i.idUsuario,concat('<b>',Paterno,'</b>') as Paterno,Materno,Nom,Nombre,'' as Status,Institucion from 802_identifica i, 801_adscripcion a  where Paterno like '".$criterio."%' and Institucion in(".$cadena.") and i.idUsuario=a.idUsuario and  Institucion is not null  order by Paterno,Materno,Nom asc";
			break;
			case "2": //Materno
				$consulta=" (select i.idUsuario,Paterno,concat('<b>',Materno,'</b>') as Materno,Nom,Nombre,'' as Status,Institucion from 802_identifica i, 801_adscripcion a where Materno like '".$criterio."%' and Institucion in(".$cadena.") and i.idUsuario=a.idUsuario and  Institucion is not null order by Materno,Paterno,Nom asc)";
			break;
			case "3": //Nombre
				$consulta=" (select i.idUsuario,Paterno, Materno,concat('<b>',Nom,'</b>') as Nom,Nombre,'' as Status,Institucion from 802_identifica i, 801_adscripcion a where Nom like '".$criterio."%' and Institucion in(".$cadena.") and i.idUsuario=a.idUsuario and  Institucion is not null order by Nom,Paterno,Materno asc)";
			break;
		}
		$res=$con->obtenerFilas($consulta);
		$arrDatos="";
		while($fila=mysql_fetch_row($res))
		{
			$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$fila[0];
			$resRol=$con->obtenerFilas($consulta);
			$situaciones="";
			while($filaRol=mysql_fetch_row($resRol))
			{
				$sitaciones="";
				if($situaciones=="")
					$situaciones=obtenerTituloRol($filaRol[0]);
				else
					$situaciones.=",".obtenerTituloRol($filaRol[0]);
			}
			$obj='{"idUsuario":"'.$fila[0].'","Paterno":"'.$fila[1].'","Materno":"'.$fila[2].'","Nom":"'.$fila[3].'","Nombre":"'.$fila[4].'","Status":"'.$situaciones.'","codigoUnidad":"'.$fila[6].'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$obj='{"num":"'.$con->filasAfectadas.'","personas":['.uDJ($arrDatos).']}';
		echo $obj;
	
	}
	
	function obtenerAlumnosGrado()
	{
		global $con;
		
		$idGrupo=$_POST["idGrupo"];
		$bandera=$_POST["bandera"];
		$idGradoSig=$_POST["idGradoSig"];
		$idGrupoSig=$_POST["idGrupoSig"];
		
		if($idGrupoSig==-100)
		{
			$whereGrupo=" and idGrupo is NULL";
		}
		else
		{
			$whereGrupo=" and idGrupo=".$idGrupoSig;
		}
		
		$conExistenAlumnos="SELECT idUsuario FROM 4118_alumnos WHERE idGrado=".$idGradoSig.$whereGrupo;
		$resGrupo=$con->obtenerFilas($conExistenAlumnos);
		$nalumnosInc=$con->filasAfectadas;
		$cadena=$con->obtenerListaValores($conExistenAlumnos);
		if($cadena=="")
			$cadena="-1";
		
		
		$conGrado="SELECT idGrado FROM 4048_grupos WHERE idGrupo=".$idGrupo;
		$idGrado=$con->obtenerValor($conGrado);
		
		$condicionWhere="";
		if($bandera==0)
		{
			$condicionWhere="AND (a.estado=2 OR a.estado=5)";
		}
		
		$consulta="SELECT a.idUsuario,CONCAT(i.Paterno,' ',i.Materno,' ',Nom) as nombre,a.estado,e.estado,i.Paterno,a.idGrado,a.matricula FROM 802_identifica i, 4118_alumnos a, 4119_estadosAlumno e
					WHERE a.idUsuario=i.idUsuario AND a.idGrupo=".$idGrupo." AND idEstadoAlumno=a.estado ".$condicionWhere."  AND a.idUsuario NOT IN (".$cadena.") order by  i.Paterno";
		//echo $consulta;
		$res=$con->obtenerFilas($consulta);
		$arrDatos="";
		while($fila=mysql_fetch_row($res))
		{
			$obj='{"idUsuario":"'.$fila[0].'","nombre":"'.$fila[1].'","idSituacion":"'.$fila[2].'","situacion":"'.$fila[3].'","paterno":"'.$fila[4].'","matricula":"'.$fila[6].'"}';
			
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$obj='{"num":"'.$con->filasAfectadas.'","registros":['.uDJ($arrDatos).']}';
		echo $obj;
	}
	
	function inscribirAlumnosGrupo ()
	{
		global $con;
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		$idGrupo=$_POST["idGrupo"];
		$idGrado=$_POST["idGrado"];
		
		$conDatos="SELECT idPrograma,ciclo FROM 4014_grados WHERE idGrado=".$idGrado;
		$datos=$con->obtenerPrimeraFila($conDatos);
		
		$conMapa="SELECT idMapaCurricular FROM 4029_mapaCurricular WHERE idPrograma=".$datos[0]." AND ciclo=".$datos[1];
		$idMapa=$con->obtenerValor($conMapa);
		
		$consulta="begin";
		
		if($con->ejecutarConsulta($consulta))
		{
			
			if($idGrupo==-100)
			{
				$mWhere=" idGrupo IS NULL";
				$idGrupo="NULL";
			}
			else
			{
				$mWhere="idGrupo=".$idGrupo;
			}
			
			$ct=0;
			for($x=0;$x<$tamano;$x++)
			{
				$elemento=explode("_",$arreglo[$x]);
				$idUsuario=$elemento[0];
				$matricula=$elemento[1];
				
				$conExiste="SELECT idAlumnoTabla FROM 4118_alumnos WHERE idUsuario=".$idUsuario." AND idGrado=".$idGrado." AND ".$mWhere;
				$existe=$con->obtenerValor($conExiste);
				
				if($existe=="")
				{
					$query[$ct]="INSERT INTO 4118_alumnos(ciclo,idPrograma,idGrado,idGrupo,matricula,idUsuario,estado,idMapaCurricular)
								 VALUES('".$datos[1]."','".$datos[0]."','".$idGrado."',".$idGrupo.",'".$matricula."','".$idUsuario."','6','".$idMapa."')";
				    $ct++;	
					
					if($idGrupo!="NULL")
					{
						  $consulta="select em.idMateria,m.compartida from 4031_elementosMapa em,4013_materia m where m.idmateria=em.idMateria and em.idPadre=0 and em.idGrado=".$idGrado." and em.idTipoMateria=1";
						  $resMat=$con->obtenerFilas($consulta);
						  while($filaMat=mysql_fetch_row($resMat))
						  {
							  if($filaMat[1]==1)
							  {
									  if($idGrupo!="NULL")
									  {
										  $conExiste="SELECT idAlumnosElementoMapa FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$filaMat[0]." AND idUsuario=".$idUsuario;
										  //echo $conExiste;
										  $existe=$con->obtenerValor($conExiste);
										  if($existe=="")
										  {
											  $consult="insert into 4120_alumnosVSElementosMapa(idUsuario,situacion,idGrupo,idMateria,idPrograma) values(".$idUsuario.",1,NULL,".$filaMat[0].",".$datos[0].")";
											  if(!$con->ejecutarConsulta($consult))	
											  {
												  return;
											  }
										  }
									  }
									  
								  inscribirMateriasObligatoriasAlumnoIndividual($idUsuario,$filaMat[0],$query,$ct,$idGrupo,$datos[0]);
							  }
							  else
							  {
								  
									  if($idGrupo!="NULL")
									  {
										  $conExiste="SELECT idAlumnosElementoMapa FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$filaMat[0]." AND idUsuario=".$idUsuario;
										  //echo $conExiste;
										  $existe=$con->obtenerValor($conExiste);
										  if($existe=="")
										  {
											  $consult="insert into 4120_alumnosVSElementosMapa(idUsuario,situacion,idGrupo,idMateria,idPrograma) values(".$idUsuario.",1,".$idGrupo.",".$filaMat[0].",".$datos[0].")";
											  //echo $consult;
											  if(!$con->ejecutarConsulta($consult))	
											  {
												  return;
											  }
										  }
									  }
									  
								  inscribirMateriasObligatoriasAlumnoIndividual($idUsuario,$filaMat[0],$query,$ct,$idGrupo,$datos[0]);
							  }
							  
						  }
					}
				
				}
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function inscribirMateriasObligatoriasAlumnoIndividual($idUsuario,$idPadre,&$query,&$ct,$idGrupo,$idPrograma)
	{
		global $con;
		$consulta="select em.idMateria,m.compartida from 4031_elementosMapa em,4013_materia m where m.idmateria=em.idMateria and em.idPadre=".$idPadre." and em.idTipoMateria=1";
		$resMat=$con->obtenerFilas($consulta);
		while($filaMat=mysql_fetch_row($resMat))
		{
			if($filaMat[1]==1)
			{
					if($idGrupo!="NULL")
					{
						$conExiste="SELECT idAlumnosElementoMapa FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$filaMat[0]." AND idUsuario=".$idUsuario;
						$existe=$con->obtenerValor($conExiste);
						if($existe=="")
						{
							$consult="insert into 4120_alumnosVSElementosMapa(idUsuario,situacion,idGrupo,idMateria,idPrograma) values(".$idUsuario.",1,NULL,".$filaMat[0].",".$idPrograma.")";
							//echo $consult;
							if(!$con->ejecutarConsulta($consult))
							{
								return;
							}
						}
					}
					else
					{
						$query[$ct]="delete from 4120_alumnosVSElementosMapa where idUsuario=".$idUsuario." and idMateria=".$filaMat[0];
						//echo $$consulta[$x];
						$ct++;
					}
				inscribirMateriasObligatoriasAlumno($idUsuario,$filaMat[0],$query,$ct,$idGrupo,$idPrograma);
			}
			else
			{
					if($idGrupo!="NULL")
					{
						$conExiste="SELECT idAlumnosElementoMapa FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$filaMat[0]." AND idUsuario=".$idUsuario;
						//echo $conExiste."<br>";
						$existe=$con->obtenerValor($conExiste);
						if($existe=="")
						{
						  $consulta1="insert into 4120_alumnosVSElementosMapa(idUsuario,situacion,idGrupo,idMateria,idPrograma) values(".$idUsuario.",1,".$idGrupo.",".$filaMat[0].",".$idPrograma.")";
						  //echo $consulta."<br>";
						  if(!$con->ejecutarConsulta($consulta1))
						  {
							return;
						  }
						}
					}
					else
					{
						$query[$ct]="delete from 4120_alumnosVSElementosMapa where idUsuario=".$idUsuario." and idMateria=".$filaMat[0];
						//echo $$consulta[$x];
						$ct++;
					}
					//inscribirMateriasObligatoriasAlumno($arrAlumnos,$filaMat[0],$consulta,$x,$idGrupo,$idPrograma);
				inscribirMateriasObligatoriasAlumno($idUsuario,$filaMat[0],$query,$ct,$idGrupo,$idPrograma);
			}
		}
	}
	
	function obtenerGruposGrado()
	{
		global $con;
		$idGrado=$_POST["idGrado"];
		
		$conGrado="SELECT idGradoSig FROM 4014_grados WHERE idGrado=".$idGrado;
		$gradoSig=$con->obtenerValor($conGrado);
		
		if($gradoSig=="")
		{
			$leyendaSiguiente="No Existe";
			$gradoSiguiente=-1000;
			$arregloGruposSig="[]";
			$nuevoPrograma=0;
			$nombre="";
		
		}
		else
		{
			if($gradoSig=="-1")
			{
				$conPrograma="SELECT idPrograma FROM 4014_grados WHERE idGrado=".$idGrado;
				$idPrograma=$con->obtenerValor($conPrograma);
				if($idPrograma=="")
					$idPrograma="-1";
				
				$conSig="SELECT idProgramaSig,nombrePrograma FROM 4004_programa WHERE idPrograma=".$idPrograma;
				$progSiguiente=$con->obtenerPrimeraFila($conSig);
				if($progSiguiente)
				{
					$idProgS=$progSiguiente[0];
					if(($progSiguiente[0]=="") or ($progSiguiente[0]=="NULL"))
					{
						$idProgS="-1";
					}
				}
				else
				{
					$idProgS="-1";
					$nuevoPrograma=0;
					$nombre="";
					
				}
				
				$conGradoSig="SELECT idGrado,leyenda FROM 4014_grados WHERE idPrograma=".$idProgS." AND  idGradoAnt=-1";
				$datosSiguiente=$con->obtenerPrimeraFila($conGradoSig);
				
				if($datosSiguiente)
				{
					$gradoSiguiente=$datosSiguiente[0];
					$leyendaSiguiente=$datosSiguiente[1];
					
					$consulta="SELECT idGrupo,nombreGrupo FROM 4048_grupos WHERE idGrado=".$gradoSiguiente;
					$arregloGruposSig=$con->obtenerFilasArreglo($consulta);
					
					$nuevoPrograma=1;
					
					$nombrePrograma="SELECT nombrePrograma FROM 4004_programa WHERE idPrograma=".$idProgS;
					$nombreP=$con->obtenerValor($nombrePrograma);
					$nombre=$nombreP;
					
				}
				else
				{
					$gradoSiguiente=-1000;
					$leyendaSiguiente="No Existe";
					$arregloGruposSig="[]";
					$nuevoPrograma=0;
					$nombre="";
				}
			}
			else
			{
				$nuevoPrograma=0;
				$nombre="";
				$conGradoSig="SELECT idGrado,leyenda FROM 4014_grados WHERE idGrado=".$gradoSig;
				$datosSiguiente=$con->obtenerPrimeraFila($conGradoSig);
				
				if($datosSiguiente)
				{
					$gradoSiguiente=$datosSiguiente[0];
					$leyendaSiguiente=$datosSiguiente[1];
					
					$consulta="SELECT idGrupo,nombreGrupo FROM 4048_grupos WHERE idGrado=".$gradoSiguiente;
					$arregloGruposSig=$con->obtenerFilasArreglo($consulta);
				}
				else
				{
					$gradoSiguiente=-1000;
					$leyendaSiguiente="No Existe";
					$arregloGruposSig="[]";
				}
			}
		
		}
		
		$consulta="SELECT idGrupo,nombreGrupo FROM 4048_grupos WHERE idGrado=".$idGrado;
		$arreglo=$con->obtenerFilasarreglo($consulta);
		
		echo "1|".$arreglo."|".$gradoSiguiente."|".$leyendaSiguiente."|".$arregloGruposSig."|".$nuevoPrograma."|".$nombre;
	
	}
	
	function obtenerElementosMateriaHijo()
	{
		global $con;
		
		$idUsuario=$_POST["idUsuario"];
		
		$consulta="SELECT *FROM 4118_alumnos WHERE idUsuario=".$idUsuario." AND estado=1";
		//echo $consulta;
		$fila=$con->obtenerPrimeraFila($consulta);
		
		$arregloElementos="";
		$consulta="select em.idMateria,m.compartida from 4031_elementosMapa em,4013_materia m where m.idmateria=em.idMateria and em.idPadre=0 and em.idGrado=".$fila[3]." and em.idTipoMateria=1";
		//echo $consulta;
		$resMat=$con->obtenerFilas($consulta);
		while($filaMat=mysql_fetch_row($resMat))
		{
			//if($filaMat[1]==1)
//			{
					$conExiste="SELECT *FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$filaMat[0]." AND idUsuario=".$idUsuario;
					//echo $conExiste;
					$existe=$con->obtenerPrimeraFila($conExiste);
					
					if($existe)
					{
						if($existe[3]!="NULL")
						{
							$nomMateria="SELECT titulo FROM 4013_materia WHERE idMateria=".$filaMat[0];
							$nMateria=$con->obtenerValor($nomMateria);
							
							$nomnbreGrupo="SELECT nombreGrupo FROM 4048_grupos WHERE idGrupo=".$existe[3];
							$nGrupo=$con->obtenerValor($nomnbreGrupo);
							
							$conElementos="(SELECT idAvisoMateria AS idTabla,'1' AS tipo,titulo AS titulo,descripcion AS descripcion,DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha 
											FROM 4191_avisosMateria WHERE idMateria=".$filaMat[0]." AND idGrupo=".$existe[3]."
											) 
											UNION 
											(SELECT idTareaMateria AS idTabla,'2' AS tipo,texto AS titulo,' ' AS descripcion,DATE_FORMAT(fechaEntrega,'%d/%m/%Y')  AS fecha 
											FROM 4166_tareasMateria WHERE idMateria=".$filaMat[0]." AND idGrupo=".$existe[3]."
											)
											
											UNION
											(
											SELECT idEnlaceMateria AS idTabla,'3' AS tipo,titulo AS titulo,descripcion AS descripcion,DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha 
											FROM 4192_enlacesMateria WHERE idMateria=".$filaMat[0]." AND idGrupo=".$existe[3]."
											) 
											UNION
											(
											SELECT idMaterialVSTema AS idTabla,'4' AS tipo,titulo AS titulo,descripcion AS descripcion,DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha
											FROM 4050_materialDidactico m , 4051_materialesVSTema t WHERE idMaterial=idMaterialDidactico AND idMateria=".$filaMat[0]." AND idGrupo=".$existe[3]." 
											
											)
											ORDER BY fecha DESC";
							//echo $conElementos;
							$resElementos=$con->obtenerFilas($conElementos);
							
							while($fElem=mysql_fetch_row($resElementos))
							{
								$obj='{"idMateria":"'.$filaMat[0].'","nombreMateria":"'.$nMateria.'","nombreGrupo":"'.$nGrupo.'","titulo":"'.$fElem[2].'","descripcion":"'.$fElem[3].'","fecha":"'.$fElem[4].'","tipo":"'.$fElem[1].'","idTabla":"'.$fElem[0].'"}';
								if($arregloElementos=="")
									$arregloElementos=$obj;
								else
									$arregloElementos.=",".$obj;
							}
						}
					}
					
				obtenerElementosMateria($idUsuario,$filaMat[0],$arregloElementos);
			//}
			//else
//			{
//				
//					if($idGrupo!="NULL")
//					{
//						$conExiste="SELECT idAlumnosElementoMapa FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$filaMat[0]." AND idUsuario=".$idUsuario;
//						//echo $conExiste;
//						$existe=$con->obtenerValor($conExiste);
//						if($existe=="")
//						{
//							$consult="insert into 4120_alumnosVSElementosMapa(idUsuario,situacion,idGrupo,idMateria,idPrograma) values(".$idUsuario.",1,".$idGrupo.",".$filaMat[0].",".$datos[0].")";
//							//echo $consult;
//							if(!$con->ejecutarConsulta($consult))	
//							{
//								return;
//							}
//						}
//					}
//					
//				inscribirMateriasObligatoriasAlumnoIndividual($idUsuario,$filaMat[0],$query,$ct,$idGrupo,$datos[0]);
			//}
			
		}
		$obj='{"num":"'.$con->filasAfectadas.'","registros":['.uDJ($arregloElementos).']}';
		echo $obj;
		//echo $arregloElementos;
	}
	
	function obtenerElementosMateria($idUsuario,$idPadre,&$arregloElementos)
	{
		global $con;
		$consulta="select em.idMateria,m.compartida from 4031_elementosMapa em,4013_materia m where m.idmateria=em.idMateria and em.idPadre=".$idPadre." and em.idTipoMateria=1";
		$resMat=$con->obtenerFilas($consulta);
		while($filaMat=mysql_fetch_row($resMat))
		{
					$conExiste="SELECT *FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$filaMat[0]." AND idUsuario=".$idUsuario;
					$existe=$con->obtenerPrimeraFila($conExiste);
					
					if($existe)
					{
						if($existe[3]!="NULL")
						{
							$nomMateria="SELECT titulo FROM 4013_materia WHERE idMateria=".$filaMat[0];
							$nMateria=$con->obtenerValor($nomMateria);
							
							$nomnbreGrupo="SELECT nombreGrupo FROM 4048_grupos WHERE idGrupo=".$existe[3];
							$nGrupo=$con->obtenerValor($nomnbreGrupo);
							
							$conElementos="(SELECT idAvisoMateria AS idTabla,'1' AS tipo,titulo AS titulo,descripcion AS descripcion,DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha 
											FROM 4191_avisosMateria WHERE idMateria=".$filaMat[0]." AND idGrupo=".$existe[3]."
											) 
											UNION 
											(SELECT idTareaMateria AS idTabla,'2' AS tipo,texto AS titulo,' ' AS descripcion,DATE_FORMAT(fechaEntrega,'%d/%m/%Y') AS fecha 
											FROM 4166_tareasMateria WHERE idMateria=".$filaMat[0]." AND idGrupo=".$existe[3]."
											)
											
											UNION
											(
											SELECT idEnlaceMateria AS idTabla,'3' AS tipo,titulo AS titulo,descripcion AS descripcion,DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha 
											FROM 4192_enlacesMateria WHERE idMateria=".$filaMat[0]." AND idGrupo=".$existe[3]."
											)
											UNION
											(
											SELECT idMaterialVSTema AS idTabla,'4' AS tipo,titulo AS titulo,descripcion AS descripcion,DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha
											FROM 4050_materialDidactico m , 4051_materialesVSTema t WHERE idMaterial=idMaterialDidactico AND idMateria=".$filaMat[0]." AND idGrupo=".$existe[3]." 
											)
											ORDER BY fecha DESC";
							$resElementos=$con->obtenerFilas($conElementos);
							
							while($fElem=mysql_fetch_row($resElementos))
							{
								$obj='{"idMateria":"'.$filaMat[0].'","nombreMateria":"'.$nMateria.'","nombreGrupo":"'.$nGrupo.'","titulo":"'.$fElem[2].'","descripcion":"'.$fElem[3].'","fecha":"'.$fElem[4].'","tipo":"'.$fElem[1].'","idTabla":"'.$fElem[0].'"}';
								if($arregloElementos=="")
									$arregloElementos=$obj;
								else
									$arregloElementos.=",".$obj;
							}
						}
					}
					
				obtenerElementosMateria($idUsuario,$filaMat[0],$arregloElementos);
		}
	}
	
	function guardarElementoUnidadD()
	{
		global $con;
		
		$tipo=$_POST["tipo"];
		$nombre=$_POST["nombre"];
		$idFormato=$_POST["idFormato"];
		$idElemento=$_POST["idElemento"];
		
		$conOrden="SELECT MAX(orden) FROM 4236_elementosUnidadDidactica WHERE idFormatoUnidad=".$idFormato;
		$maxOrden=$con->obtenerValor($conOrden);
		if($maxOrden=="")
		{
			$orden=1;
		}
		else
		{
			$orden=$maxOrden+1;
		}
		
		if($idElemento=="-1")
		{
			$query="INSERT INTO 4236_elementosUnidadDidactica (idFormatoUnidad,tipo,etiqueta,orden) VALUES(".$idFormato.",".$tipo.",'".$nombre."',".$orden.")";
		}
		else
		{
			$query="UPDATE 4236_elementosUnidadDidactica SET etiqueta='".$nombre."' WHERE idElementoUnidadD=".$idElemento;
		}
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
		
	}
	
	function modificarOrdenElementoUnidadD()
	{
		global $con;
		$idElemento=$_POST["idElemento"];	
		$orden=$_POST["orden"];
		
		$consulta="select orden,idFormatoUnidad from 4236_elementosUnidadDidactica where idElementoUnidadD=".$idElemento;
		$filaE=$con->obtenerPrimeraFila($consulta);
		$vOrden=$filaE[0];
		$idFormato=$filaE[1];
		$x=0;
		$query[$x]="begin";
		$x++;
		if($vOrden>$orden)
		{
			$query[$x]="update 4236_elementosUnidadDidactica set orden=orden+1 where idFormatoUnidad=".$idFormato." and orden>=".$orden." and orden<".$vOrden;
			$x++;
		}
		else
		{
			$query[$x]="update 4236_elementosUnidadDidactica set orden=orden-1 where idFormatoUnidad=".$idFormato." and orden>".$vOrden." and orden<=".$orden;
			$x++;
		}
		$query[$x]="update 4236_elementosUnidadDidactica set orden=".$orden." where idElementoUnidadD=".$idElemento;
		$x++;
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
			echo "1|";
	}
	
	function obtenerMaximoOrdenElementoUnidadD()
	{
		global $con;
		
		$idFormato=$_POST["idFormato"];
		$consulta="select max(orden) from 4236_elementosUnidadDidactica where idFormatoUnidad=".$idFormato;
		$ordenMax=$con->obtenerValor($consulta);
		$arrOrden="";
		for($x=1;$x<=$ordenMax;$x++)
		{
			$obj="['".$x."','".$x."']";
			if($arrOrden=="")
				$arrOrden=$obj;
			else
				$arrOrden.=','.$obj;
		}
		echo "1|[".$arrOrden."]";
	
	}
	
	function obtenerGridAlumnos()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$consulta="SELECT idUsuario,a.idPrograma,a.idGrado,a.ciclo,leyenda,nombrePrograma,estado FROM 4118_alumnos a, 4014_grados g,4004_programa p WHERE a.ciclo=".$idCiclo." AND (estado=6 OR estado=7) AND a.idGrado=g.idGrado AND p.idPrograma=a.idPrograma ORDER BY a.idPrograma,g.grado";
		$res=$con->obtenerFilas($consulta);
		$arrUsuarios="";
		$ct=1;
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT idUsuario FROM 4128_nuevosAspirantes WHERE ciclo=".$idCiclo." AND idUsuario=".$fila[0];
			$origen=$con->obtenerValor($consulta);
			if($origen=="")
			{
				$movimiento="Reinscripci&oacute;n";
				$idMovimiento=1;
			}
			else
			{
				$movimiento="Nuevo Ingreso";
				$idMovimiento=0;
			}
			
			$nombre=obtenerNombreUsuario($fila[0]);
			
			$obj='{"idUsuario":"'.$fila[0].'","nombre":"'.$nombre.'","nombrePrograma":"'.$fila[5].'","idPrograma":"'.$fila[1].'","nombreGrado":"'.$fila[4].'","movimiento":"'.$movimiento.'","idGrado":"'.$fila[2].'","idCiclo":"'.$idCiclo.'","idMovimiento":"'.$idMovimiento.'","estado":"'.$fila[6].'"}';	
			if($arrUsuarios=="")
				$arrUsuarios=$obj;
			else
				$arrUsuarios.=",".$obj;
		}
		$obj='{"numReg":"'.$con->filasAfectadas.'","registros":['.$arrUsuarios.']}';
		echo $obj;
	}
	
	function incribirdAlumno()
	{
		global $con;
		
		$idUsuario=$_POST["idUsuario"];
		$idPrograma=$_POST["idPrograma"];
		$idGrado=$_POST["idGrado"];
		$idCiclo=$_POST["idCiclo"];
		
		$query="UPDATE 4118_alumnos SET estado=1 WHERE idUsuario=".$idUsuario." AND idPrograma=".$idPrograma." AND idGrado=".$idGrado." AND ciclo=".$idCiclo;
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	
	}
	
	function rechazarAlumno()
	{
		global $con;
		
		$idUsuario=$_POST["idUsuario"];
		$idPrograma=$_POST["idPrograma"];
		$idGrado=$_POST["idGrado"];
		$idCiclo=$_POST["idCiclo"];
		$motivo=$_POST["motivo"];
		$estado=$_POST["estado"];
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
		  $ct=0;
		  $query[$ct]="UPDATE 4118_alumnos SET estado=9 WHERE idUsuario=".$idUsuario." AND idPrograma=".$idPrograma." AND idGrado=".$idGrado." AND ciclo=".$idCiclo;
		  $ct++;
		  
		  $query[$ct]="INSERT INTO 4128_comentariosInscripcion (comentario,fechaComentario,horaComentario,ciclo,idUsuario,estadoInscripcion,estado)
						VALUES('".$motivo."','".date('Y-m-d')."','".date('H:i')."','".$idCiclo."',".$idUsuario.",".$estado.",1)";
						
		  $ct++;
		  $query[$ct]="commit";
		  if($con->ejecutarBloque($query))
			  echo "1|";
		  else
			  echo "|";
		}
	}
	
	function comentarAlumno()
	{
		global $con;
		
		$idUsuario=$_POST["idUsuario"];
		$idPrograma=$_POST["idPrograma"];
		$idGrado=$_POST["idGrado"];
		$idCiclo=$_POST["idCiclo"];
		$estado=$_POST["estado"];
		$motivo=$_POST["motivo"];
		
		$query="INSERT INTO 4128_comentariosInscripcion (comentario,fechaComentario,horaComentario,ciclo,idUsuario,estadoInscripcion,estado)
						VALUES('".$motivo."','".date('Y-m-d')."','".date('H:i')."','".$idCiclo."',".$idUsuario.",".$estado.",1)";
						
		  if($con->ejecutarConsulta($query))
			  echo "1|";
		  else
			  echo "|";
	}
	
	function obtenerPermisosRolControlE()
	{
		global $con;
		$tipoP=$_POST["tipoP"];
		$codRol=$_POST["codRol"];
		$extension="";
		if(isset($_POST["extension"]))
			$extension=$_POST["extension"];
			
		if($extension=="")
			$consulta="SELECT acciones FROM 4220_permisosControlEscolar WHERE tipoPermiso=".$tipoP." AND  rol='".$codRol."'";
		else
			$consulta="SELECT acciones FROM 4220_permisosControlEscolar WHERE tipoPermiso=".$tipoP." AND  rol='".$codRol."' AND extension='".$extension."'";
		$cadena=$con->obtenerValor($consulta);
		if($cadena=="")
		{
			echo "1|0|0|0";
		}
		else
		{
			$agregar=0;
			$modificar=0;
			$borrar=0;
			$cadenaA=strpos($cadena,'A');
			if($cadenaA===false)
				$agregar=0;
			else
				$agregar=1;
				
			$cadenaM=strpos($cadena,'M');
			if($cadenaM===false)
				$modificar=0;
			else
				$modificar=1;
			
			$cadenaE=strpos($cadena,'E');
			if($cadenaE===false)
				$borrar=0;
			else
				$borrar=1;
				
			echo "1|".$agregar."|".$modificar."|".$borrar;	
		}
	}
	
	function modificarPermisosControlE()
	{
		global $con;
		$cadena=$_POST["cadena"];
		$tipoP=$_POST["tipoP"];
		$codRol=$_POST["codRol"];
		
		$query="UPDATE 4220_permisosControlEscolar SET acciones='".$cadena."' WHERE tipoPermiso=".$tipoP." AND rol='".$codRol."'";
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarConfParametrosCalculo()
	{
		global $con;
		
	    $idCalculo=$_POST["idCalculo"];
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		$consulta="begin";
		if($con->ejecutarconsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamano;$x++)
			{
				$elemento=explode("@",$arreglo[$x]);
				$idParametro=$elemento[0];
				$tipoE=$elemento[1];
				$tabla=$elemento[2];
				$campo=$elemento[3];
				$proyectar=$elemento[4];
				
				$conExiste="SELECT idConfCalculo FROM 4232_confCalculo WHERE idCalculo=".$idCalculo." AND idParametro=".$idParametro;
				$id=$con->obtenerValor($conExiste);
				if($id=="")
				{
					$query[$ct]="INSERT INTO 4232_confCalculo (idCalculo,idParametro,tipoEntrada,tabla,campo,proyectar)
								 VALUES(".$idCalculo.",".$idParametro.",".$tipoE.",'".$tabla."','".$campo."','".$proyectar."')";
				}
				else
				{
					$query[$ct]="UPDATE 4232_confCalculo SET tipoEntrada=".$tipoE.",tabla='".$tabla."',campo='".$campo."',proyectar='".$proyectar."' WHERE idConFCalculo=".$id;
				}
				$ct++;
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
			{
				echo "1|";
			}
			else
			{
				echo "|";
			}
		}
	}
	
	function obtenerConfCalculo()
	{
	}
	
	function obtenerParametros()
	{
		global $con;
		$idCalculo=$_POST["idCalculo"];
		$consulta="SELECT parametro FROM 993_parametrosConsulta WHERE idConsulta=".$idCalculo;
		$nParametros=$con->obtenerFilasArreglo($consulta);
		echo "1|".$nParametros;
		
	}
	
	function obtenerCandidatos()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$arrResultado=array();
		$pos=0;
		foreach($obj as $o)
		{
			$objParam=json_decode(bD($o->param));
			$ref=NULL;
			$arrResultado[$pos]=resolverExpresionCalculoPHP($o->idCalculo,$objParam,$ref);
			if($arrResultado[$pos]=='')
				$arrResultado[$pos]='-1';
			$pos++;
		}
		$condWhere="";
		
		foreach($arrResultado as $r)
		{
			if($condWhere=='')
				$condWhere=' where idUsuario in ('.$r.')';
			else
				$condWhere.=' and idUsuario in ('.$r.')';
		}
		
		$consulta="select distinct idUsuario,concat(Paterno,' ',Materno,' ',Nom) as Nombre from 802_identifica".$condWhere." order by Paterno,Materno,Nom";
		$arrUsuarios=$con->obtenerFilasArreglo($consulta);
		echo "1|".str_replace("|","",$arrUsuarios);
	}
	
	function obtenerSedes()
	{
		global $con;
		$conSedes="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE codigoInstitucion='".$_SESSION["codigoInstitucion"]."' AND institucion=1";
		//echo $conSedes;
		$res=$con->obtenerFilas($conSedes);
		$nreg=$con->filasAfectadas;
		
		$arrSedes="";
		while($fila=mysql_fetch_row($res))
		{
			$obj='{"codigoUnidad":"'.$fila[0].'","unidad":"'.$fila[1].'"}';	
			if($arrSedes=="")
				$arrSedes=$obj;
			else
				$arrSedes.=",".$obj;
		}
		$obj='{"numReg":"'.$nreg.'","registros":['.$arrSedes.']}';
		echo $obj;
	}
	
	function guardarMateriaConvocatoria()
	{
		global $con;
		
		$idGrupo=$_POST["idGrupo"];
		$ciclo=$_POST["idCiclo"];
		
		$consultaExiste="SELECT idSolicitudConvMat FROM 4233_solicitudConvMateria WHERE idGrupo=".$idGrupo." AND ciclo=".$ciclo;
		$existe=$con->obtenerValor($consultaExiste);
		if($existe=="")
		{
			$consulta="SELECT idMateria,Plantel FROM 4520_grupos WHERE idGrupos=".$idGrupo;
			$filaGpo=$con->obtenerPrimeraFila($consulta);
			$query="INSERT INTO 4233_solicitudConvMateria(idMateria,sede,idGrupo,situacion,ciclo,fechaVacante,idFormulario,idRegistro) 
					VALUES (".$filaGpo[0].",'".$filaGpo[1]."',".$idGrupo.",1,".$ciclo.",'".date("Y-m-d")."',0,0)";
		
			
			if($con->ejecutarConsulta($query)) 
				echo "1|";
			else
				echo "|";
		}
		else
		{
			echo "2|";
		}
	}
	
	function obtenerHorarioMateriaCurso()
	{
		global $con;
		
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$idCiclo=$_POST["idCiclo"];
		
		$consulta="SELECT idMateriaVSGrupo FROM 4065_materiaVSGrupo WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND ciclo=".$idCiclo." AND dia IS NOT NULL";
		$res=$con->obtenerFilas($consulta);
		$nFilas=$con->filasAfectadas;
		
		echo "1|".$nFilas;
	}
	
	function validarHorarioMateriaCurso()
	{
		global $con;
		if($hInicio)
		$horaI=$_POST["horaI"];
		$horaF=$_POST["horaF"];
		$dia=$_POST["dia"];
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$idCiclo=$_POST["idCiclo"];
		$id=$_POST["id"];
		echo funcValidarHorarioMateriaCurso($horaI,$horaF,$dia,$idMateria,$idGrupo,$idCiclo,$id);
		
	}
	
	function guardarAplicacionHorarioMateriaCurso()
	{
		global $con; 
		
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$tipoA=$_POST["tipoA"];
		
		$conExiste="SELECT idTipoHorarioCurso FROM 4226_tipoHorarioCurso WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo;
		$existe=$con->obtenerValor($conExiste);
		if($existe=="")
		{
		  $query="INSERT INTO 4226_tipoHorarioCurso(idGrupo,idMateria,aplicacionHorario) VALUES(".$idGrupo.",".$idMateria.",".$tipoA.")";
		  if($con->ejecutarConsulta($query))
			  echo "1|";
		  else
			  echo "|";
		}
		else
		{
			echo "1|";
		}
	}
	
	function eliminarRegistroHorarioMateriaCurso()
	{
		global $con;
		
		$idTabla=$_POST["id"];
		
		$query="DELETE FROM 4065_materiaVSGrupo WHERE idMateriaVSGrupo=".$idTabla;
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function validarHorarioCursos($idMateria,$idGrupo,$idUsuario,$idCiclo)
	{
		global $con;
		
		$consulta="select idUsuario,idMateria,idGrupo from 4047_participacionesMateria where idUsuario=".$idUsuario." and participacionP=1 and estado=1";// and esperaContrato=0";
		$filas=$con->obtenerFilas($consulta);
		$numeroFilas=$con->filasAfectadas;
		$res=$con->obtenerPrimeraFila($consulta);
		$idUsuario=$res[0];
		
		if($numeroFilas==0)
		{
		    return "1|";
		}
		else
		{
			  $conFechasGrupo="SELECT fechaInicio,fechaFin FROM 4048_grupos WHERE idGrupo=".$idGrupo;
		      $fechasGrupo=$con->obtenerPrimeraFila($conFechasGrupo);
			  $fechaIniGrupoNuevo=$fechasGrupo[0];
			  $fechaFinGrupoNuevo=$fechasGrupo[1];
			  
			  $consulta="(SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
						  WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND ciclo=".$idCiclo.")
						  UNION
						  (			  
						  SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
						  WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$idMateria." AND idGrupoCompartido=".$idGrupo." AND ciclo=".$idCiclo.")
						  UNION
						  (SELECT dia,horaInicio,horaFin,idPrograma,'0' AS idPerfil FROM 4065_materiaVSGrupo 
						  WHERE  idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND ciclo=".$idCiclo.")";
			  //echo $consulta;
			  $res=$con->obtenerFilas($consulta);
			  $nFilas=$con->filasAfectadas;
			
			  if($nFilas==0)
			  {
			  	return "1|";//la materia no tiene horario
			  }
			  else
			  {
				  $mensajeDeColision="";
				  while($fila=mysql_fetch_row($filas))	
				  {
				  		$conFechasGrupo="SELECT fechaInicio,fechaFin FROM 4048_grupos WHERE idGrupo=".$idGrupo;
						$fechasGrupo=$con->obtenerPrimeraFila($conFechasGrupo);
						if($fechasGrupo[0]=="")
						{
							$conFechasMateria="SELECT fechaInicio,fechaFin FROM 4013_materia WHERE idMateria=".$fila[0];
							$fechasMat=$con->obtenerPrimeraFila($conFechasMateria);
							$fechaIniGrupoExiste=$fechasMat[0];
							$fechaFinGrupoExiste=$fechasMat[1];
						}
						else
						{
							$fechaIniGrupoExiste=$fechasGrupo[0];
							$fechaFinGrupoExiste=$fechasGrupo[1];
						}
						$horaMatProf="(SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
									  WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$fila[1]." AND idGrupo=".$fila[2]." AND ciclo=".$idCiclo.")
									  UNION
									  (			  
									  SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
									  WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$fila[1]." AND idGrupoCompartido=".$fila[2]." AND ciclo=".$idCiclo.")
									  UNION
									  (SELECT dia,horaInicio,horaFin,idPrograma,'0' AS idPerfil FROM 4065_materiaVSGrupo 
									  WHERE  idMateria=".$fila[1]." AND idGrupo=".$fila[2]." AND ciclo=".$idCiclo.")";
						$respuesta=$con->obtenerFilas($horaMatProf);				 
						$numFilas=$con->filasAfectadas;
						
						while($filaMatP=mysql_fetch_row($respuesta))
						{
							mysql_data_seek($res,0);
							while($filaHmat=mysql_fetch_row($res))
							{
								if($filaMatP[0]==$filaHmat[0])
								{
									if(colisionaTiempo($filaMatP[1],$filaMatP[2],$filaHmat[1],$filaHmat[2]))
									{
										if(colisionaTiempoFecha($fechaIniGrupoExiste,$fechaFinGrupoExiste,$fechaIniGrupoNuevo,$fechaFinGrupoNuevo))
										{
											$nombreMat="SELECT titulo FROM 4013_materia WHERE idMateria=".$fila[1];
											$nombre=$con->obtenerValor($nombreMat);
											
											switch($filaHmat[0])
											{
											  case "1":
												  $dia="Lunes";
											  break;
											  case "2":
												  $dia="Martes";
											  break;
											  case "3":
												  $dia="Miercoles";
											  break;
											  case "4":
												  $dia="Jueves";
											  break;
											  case "5":
												 $dia="Viernes";
											  break;
											  case "6":
												  $dia="Sabado";
											  break;
											  case "7":
												 $dia="Domingo";
											}
	
											$colision="<tr><td width='400' class='letraExt'><b>".$nombre."</b>&nbsp;el dia&nbsp;<b>".$dia."</b>&nbsp;de&nbsp;<b>".$filaHmat[1]."</b>&nbsp;a&nbsp;<b>".$filaHmat[2]."</b></td></tr>";
											//echo"2|".$dia."|".$filaHmat[1]."|".$filaHmat[2]."|".$nombre;
											//return ;	
											if($mensajeDeColision=="")
											  $mensajeDeColision=$colision;
										   else
											  $mensajeDeColision.=$colision;
										}
									}
								}
							}
						}
				  }
				  
				  if($mensajeDeColision=="")
					return "1|";
				  else
					return "3|<table width='400'>".$mensajeDeColision."</table>";//choca con alguna materia
				 // echo "1|";
			  }
		}
	}
	
	function colisionaTiempoFecha($tiempoI1,$tiempoF1,$tiempoI2,$tiempoF2)
	{
		$tInicio1=strtotime($tiempoI1);
		$tFin1=strtotime($tiempoF1);
		$tInicio2=strtotime($tiempoI2);
		$tFin2=strtotime($tiempoF2);	
		if(($tInicio1>=$tInicio2)&&($tInicio1<$tFin2))
			return true;
		else
			if(($tFin1>$tInicio2)&&($tFin1<=$tFin2))
				return true;
		
		if(($tInicio2>=$tInicio1)&&($tInicio2<$tFin1))
			return true;
		else
			if(($tFin2>$tInicio1)&&($tFin2<=$tFin1))
				return true;
		return false;
	}
	
	function validarHorarioCursoConDocente()
	{
		global $con; 
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$idUsuario=$_POST["idUsuario"];
		
		$consultaCiclo="select ciclo from 4048_grupos where idGrupo=".$idGrupo;
		$idCiclo=$con->obtenerValor($consultaCiclo);
		if($idCiclo=="")
			$idCiclo="-1";
		//$idCiclo=$_POST["idCiclo"];
		
		$consulta="SELECT idDiaSemana,horaInicio,horaFin FROM 4065_disponibilidadHorario WHERE idUsuario=".$idUsuario." AND ciclo=".$idCiclo." order by idDiasemana,horaInicio";
		$resHorarios=$con->obtenerFilas($consulta);
		$noHorarios=$con->filasAfectadas;
		if($noHorarios==0)
		{
			echo "2|";
		}
		else
		{
			$conHorarioMat="SELECT dia,horaInicio,horaFin,idPrograma FROM 4065_materiaVSGrupo WHERE  idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND ciclo=".$idCiclo;
			$resHM=$con->obtenerFilas($conHorarioMat);
			
			//$consulta="SELECT idDiasemana,idHrIni,idHorfinal FROM _239_HrDisponible WHERE idReferencia=".$idRef." order by idDiasemana,idHrIni";
//			$resHora=$con->obtenerFilas($consulta);
			
			$cadenaColision="";
			while($fHora=mysql_fetch_row($resHM))
			{
				mysql_data_seek($resHorarios,0);
				$obj="";
				$encontrado=0;
				while($fila=mysql_fetch_row($resHorarios))
				{
					$obj="";
					if($fila[0]==$fHora[0])
					{
						if((($fHora[1])>=($fila[1])) && (($fHora[2])<=($fila[2])))
						{
							$encontrado=1;
						}
					}
				}
				
				if($encontrado==0)
				{
					$obj="<tr><td>".obtenerNombreDia($fHora[0])."</td><td>".date('H:i',strtotime($fHora[1]))."</td><td>".date('H:i',strtotime($fHora[2]))."</td></tr>";
				
					if($cadenaColision=="")	  
						$cadenaColision=$obj;
					else
						$cadenaColision.=$obj;
				}
			}
			
			if($cadenaColision=="")
			{
				echo "1|";
			}
			else
			{
				$cabecera="<tr><td width='40' class='letraExt'>Dia</td><td width='50' class='letraExt'>Hora Ini.</td><td width='50' class='letraExt'>Hora Fin</td><tr>";	
				$cadenaFinal="<table>".$cabecera.$cadenaColision."</table>";
				echo "3|".$cadenaFinal;
			}
		}
	}
	
	
	
	function validarMaximoHorasPeriodo($idUsuario,$idCiclo,$idMateria,$idGrupo)
	{
		global $con;
		
		$sedeGrupo="SELECT sede FROM 4048_grupos WHERE idGrupo='".$idGrupo."'";
		$sedeG=$con->obtenerValor($sedeGrupo);
		if($sedeG=="")
			$sedeG="-1";
		
		$consulta="SELECT id__315_tablaDinamica,IntHrmin,IntHrMax,IntHrMedida FROM _315_tablaDinamica WHERE  codigoInstitucion='".$sedeG."'"; //AND cmbCiclo=".$idCiclo;
		$filaC=$con->obtenerPrimeraFila($consulta);
		if($filaC[0]=="")
		{
			return 1;
		}
		
		$noHoras=$filaC[2];
		$minutosClase=$filaC[3];
		
		$conHorasMateria="SELECT horaInicio,horaFin  FROM 4065_materiaVSGrupo WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo;
		$resHoras=$con->obtenerFilas($conHorasMateria);
		$tiemTotalM=0;
		
		while($horaMt=mysql_fetch_row($resHoras))
		{
			$tiempoMat=((strtotime('0:00:00'))+(strtotime($horaMt[1])))-(strtotime($horaMt[0]));
			$tiemTotalM+=(date('H',$tiempoMat)*60)+(date('i',$tiempoMat));
		}
		
		if($tiemTotalM!=0)
		{
			$tiempoRealMat=$tiemTotalM/$minutosClase;
		}
		else
		{
			$tiempoRealMat=0;
		}
		
		$conMateriasUsuario="SELECT p.idMateria,p.idGrupo FROM 4047_participacionesMateria p,4048_grupos g WHERE idUsuario=".$idUsuario." AND participacionP=1 AND estado=1 AND p.idGrupo=g.idGrupo AND ciclo=".$idCiclo;
		$resMaterias=$con->obtenerFilas($conMateriasUsuario);
		$noFilas=$con->filasAfectadas;
		if($noFilas==0)
		{
			if($tiempoRealMat>$noHoras)
			{
				return 3;
			}
			else
			{
				return 1;
			}
		}
		else
		{
			$tiempoTotal=0;
			while($fila=mysql_fetch_row($resMaterias))
			{
				$conHorarioGrupo="(SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
									  WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$fila[0]." AND idGrupo=".$fila[1]." AND ciclo=".$idCiclo.")
									  UNION
									  (			  
									  SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
									  WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$fila[0]." AND idGrupoCompartido=".$fila[1]." AND ciclo=".$idCiclo.")
									  UNION
									  (SELECT dia,horaInicio,horaFin,idPrograma,'0' AS idPerfil FROM 4065_materiaVSGrupo 
									  WHERE  idMateria=".$fila[0]." AND idGrupo=".$fila[1]." AND ciclo=".$idCiclo.")";
				$res=$con->obtenerFilas($conHorarioGrupo);					  
				
				while($fHoras=mysql_fetch_row($res))
				{
					$tiempo=((strtotime('0:00:00'))+(strtotime($fHoras[2])))-(strtotime($fHoras[1]));
					$tiempoTotal+=(date('H',$tiempo)*60)+(date('i',$tiempo));
				}
			}
			
			if($tiempoTotal==0)
			{
				if($tiempoRealMat>$noHoras)
				{
					return 3;
				}
				else
				{
					return 1;
				}
			}
			else
			{
				$tiempoReal=$tiempoTotal/$minutosClase;
				if($tiempoReal>$noHoras)
				{
					return 2;
				}
				else
				{
					if(($tiempoRealMat+$tiempoReal)>$noHoras)
					{
						return 3;
					}
					else
					{
						return 1;
					}
				}
			}
		}
	}
	
	function guardarParticipacionCursoDocente()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$idUsuario=$_POST["idUsuario"];
		$idCiclo=$_POST["idCiclo"];
		$idParticipacion=$_POST["idPartic"];
		
		$conExisteParticipacionP="SELECT idParticipante FROM 4047_participacionesMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND idParticipacion=".$idParticipacion;
		$existePartiP=$con->obtenerValor($conExisteParticipacionP);
		if($existePartiP=="")
		{
			$query="INSERT INTO 4047_participacionesMateria (idUsuario,idMateria,idGrupo,idParticipacion,participacionP,estado,esperaContrato)
			VALUES(".$idUsuario.",".$idMateria.",".$idGrupo.",".$idParticipacion.",0,1,0)";
			
			if($con->ejecutarconsulta($query))
				echo "1|";
			else
				echo "|";
		}
		else
		{
			echo "2|";
		}
	}
	
	function obtenerRecursosSede()
	{
		global $con;
		
		$sede=$_POST["sede"];
		
		$consulta="SELECT idRecurso,titulo FROM 4009_recursos WHERE codigoInstitucion='".$sede."'";
		$arreglo=$con->obtenerFilasArreglo($consulta);
		
		echo "1|".$arreglo;
	}
	
	function modificarDatosGrupoCurso()
	{
		global $con;
		
		$idGrupo=$_POST["idGrupo"];
		$minimo=$_POST["minimo"];
		$max=$_POST["max"];
		$nombre=$_POST["nombre"];
		
		$query="UPDATE 4048_grupos SET nombreGrupo='".$nombre."',cupoMinimo=".$minimo.",cupoMaximo=".$max." WHERE idGrupo=".$idGrupo;
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	
	
	function validarModificacionHorarioAlumnos($idMateria,$idGrupo,$idCiclo,$dia,$hIni,$hFin)
	{
		global $con;
		
		$consulta="SELECT idusuario FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$idMateria." AND idGrupo=".$idMateria." AND situacion=1";
		$res=$con->obtenerFilas($consulta);
		$noFilas=$con->filasAfectadas;
		if($noFilas==0)
		{
			return "1|";
		}
		else
		{
			$mensajeColision="";
			while($fila=mysql_fetch_row($res))
			{
				$conMatAlum="SELECT a.idMateria,idGrupo FROM 4120_alumnosVSElementosMapa a,4013_materia m WHERE a.idMateria=m.idMateria AND ciclo=".$idCiclo." AND idUsuario=".$fila[0];
				$resAlum=$con->obtenerFilas($conMatAlum);
				while($filaMat=mysql_fetch_row($resAlum))
				{
					$consulta="(SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
						  WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$filaMat[0]." AND idGrupo=".$filaMat[1]." AND ciclo=".$idCiclo.")
						  UNION
						  (			  
						  SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
						  WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$filaMat[0]." AND idGrupoCompartido=".$filaMat[1]." AND ciclo=".$idCiclo.")
						  UNION
						  (SELECT dia,horaInicio,horaFin,idPrograma,'0' AS idPerfil FROM 4065_materiaVSGrupo 
						  WHERE  idMateria=".$filaMat[0]." AND idGrupo=".$filaMat[0]." AND ciclo=".$idCiclo.")";
					$resMatAlum=$con->obtenerFilas($consulta);
					while($filaAlum=mysql_fetch_row($resMatAlum))
					{
						if($dia==$filaAlum[0])
						{
							if(colisionaTiempo($filaAlum[1],$filaAlum[2],$hIni,$hFin))
							{
								$nombre=obtenerNombreUsuario($fila[0]);
								if($mensajeColision=="")
									$mensajeColision="<tr><td>".$nombre."</td></tr>";
								else
									$mensajeColision.="<tr><td>".$nombre."</td></tr>";
							}
						}
					}
				}
			}
			if($mensajeColision=="")
			{
				return "1|";
			}
			else
			{
				$cabecera="<tr><td class='letraExt' width='200'></td></tr>";
				$cadenaFinal="<table>".$cabecera.$mensajeColision."</table>";
				return "2|".$cadenaFinal;
			}
		}
	}
	
	
	
	function existeProgramaModalidad()
	{
		global $con;
		
		$idPrograma=$_POST["idPrograma"];
		$idCiclo=$_POST["idCiclo"];
		$idModalidad=$_POST["idModalidad"];
		$sede=$_POST["sede"];
		$turno=$_POST["turno"];
		
			
		$consulta="SELECT idMapaCiclo FROM 4241_nuevosMapas WHERE idPrograma=".$idPrograma." AND ciclo=".$idCiclo." AND idModalidadCurso=".$idModalidad." AND sede='".$sede."' and turno=".$turno;
		//echo $consulta;
		$existe=$con->obtenerValor($consulta);
		if($existe=="")
			echo "1|";
		else
			echo "2|";
		
	}
	
	function obtenerSedesProgramaUsuario()
	{
		global $con;
		
		$idUsuario=$_SESSION["idUsr"];
		$idPrograma=$_POST["idPrograma"];
		
		$consulta="SELECT u.codigoUnidad,unidad,acciones FROM 4035_programaVsUsuariosPermitidos u, 817_organigrama o WHERE idUsuario=".$idUsuario." AND idPrograma=".$idPrograma." AND u.codigounidad=o.codigoUnidad";
		$res=$con->obtenerFilas($consulta);
		//echo $consulta;
		$arreglo="";
		$ct=1;
		while($fila=mysql_fetch_row($res))
		{
			if(pAgr($fila[2]))
			{
				$obj="['".$fila[0]."','".$fila[1]."']";
				if($arreglo=="")
					$arreglo=$obj;
				else
					$arreglo.=",".$obj;
			}
			$ct++;
		}
		echo "1|[".$arreglo."]";
	}
	
	function guardarMapaCiclo()
	{
		global $con;
		
		$idUsuario=$_SESSION["idUsr"];
		$idPrograma=$_POST["idPrograma"];
		$idCiclo=$_POST["idCiclo"];
		$idModalidad=$_POST["idModalidad"];
		$sede=$_POST["sede"];
		$revoe=$_POST["revoe"];
		$fechaRevoe=$_POST["fechaRevoe"];
		$fechaR=cambiaraFechaMysql($fechaRevoe);
		//echo $fechaR;
		$turno=$_POST["turno"];
		
		$conMapa="SELECT idMapaCurricular FROM 4029_mapaCurricular WHERE idPrograma=".$idPrograma;
		$idMapaCurricular=$con->obtenerValor($conMapa);
		if($idMapaCurricular=="")
		{	
			echo "2|";
		}
		else
		{
		  $query="INSERT INTO 4241_nuevosMapas (idMapaCurricular,idModalidadCurso,ciclo,idPrograma,estado,sede,idResponsable,revoe,fechaRevoe,turno) 
				  VALUES (".$idMapaCurricular.",".$idModalidad.",".$idCiclo.",".$idPrograma.",0,'".$sede."',".$idUsuario.",'".$revoe."','".$fechaR."',".$turno.")";
		  
		  if($con->ejecutarConsulta($query))
			  echo "1|";
		  else
			  echo "|";
		}
	}
	
	function obtenerAlumnosMapaCiclo()
	{
		global $con;
		
		$idPrograma=$_POST["idPrograma"];
		$idCiclo=$_POST["idCiclo"];
		
		$consulta="SELECT idAlumnoTabla FROM 4118_alumnos WHERE idPrograma=".$idPrograma." AND ciclo=".$idCiclo;
		$res=$con->obtenerFilas($consulta);
		$noFilas=$con->filasAfectadas;
		
		if($noFilas>0)
			echo "1|";
		else
			echo "1|";
	}
	
	function eliminarMapaCiclo()
	{
		global $con;
		
		$id=$_POST["id"];
		
		$query="DELETE FROM 4241_nuevosMapas WHERE idMapaCiclo=".$id;
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarBloqueGrado()
	{
		global $con;
		
		$idMapaCiclo=$_POST["idMapaCiclo"];
		$sede=$_POST["sede"];
		$idCiclo=$_POST["idCiclo"];
		$idModalidad=$_POST["idModalidad"];
		$idGrado=$_POST["idGrado"];
		$etiqueta=$_POST["etiqueta"];
		$fechaI=$_POST["fechaI"];
		$fechaF=$_POST["fechaF"];
		$bloque=$_POST["bloque"];
		$bloqueAnterior=$_POST["bAnt"];
		$id=$_POST["id"];
		
		if($fechaI=="")
			$fechaI="0000-00-00";
		else
			$fechaI=cambiaraFechaMysql($fechaI);
		
		if($fechaF=="")
			$fechaF="0000-00-00";
		else	
			$fechaF=cambiaraFechaMysql($fechaF);
		
		//$conExiste="SELECT idBloqueGrado FROM 4242_bloquesGrados WHERE idGrado=".$idGrado." AND idMapaCiclo=".$idMapaCiclo;
		//$existe=$con->obtenerValor($conExiste);
		
		if($id=="-1")
		{
			$query="INSERT INTO 4242_bloquesGrados (idGrado,noBloque,etiqueta,sede,ciclo,idModalidad,idMapaCiclo,fechaInicio,fechaFin,bloqueAnterior)
					VALUES (".$idGrado.",".$bloque.",'".$etiqueta."','".$sede."',".$idCiclo.",".$idModalidad.",".$idMapaCiclo.",'".$fechaI."','".$fechaF."',".$bloqueAnterior.")";
		}
		else
		{
			$query="UPDATE 4242_bloquesGrados SET noBloque=".$bloque.",etiqueta='".$etiqueta."',fechaInicio='".$fechaI."',fechaFin='".$fechaF."' WHERE idBloqueGrado=".$id;
		}
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerInformacionBloqueGrado()
	{
		global $con;
		
		$id=$_POST["id"];
		$idMapaCiclo=$_POST["idMapaCiclo"];
		$idGrado=$_POST["idGrado"];
		
		$consulta="SELECT *FROM 4242_bloquesGrados WHERE idBloqueGrado=".$id;
		$fila=$con->obtenerPrimeraFila($consulta);
		if($fila[0]!="")
		{
			$fila[8]=date('d/m/Y',strtotime($fila[8]));
			$fila[9]=date('d/m/Y',strtotime($fila[9]));
			if($fila[1]=="") 
				$fila[1]="-1";
			
			if($fila[7]=="")
				$fila[7]="-1";
			
			$conBloques="SELECT idBloqueGrado,etiqueta FROM 4242_bloquesGrados WHERE idGrado=".$fila[1]." AND idMapaCiclo=".$fila[7]." AND idBloqueGrado NOT IN (".$id.") ";
			$arreglo=$con->obtenerFilasArreglo($conBloques);
			
			echo "1|".$fila[2]."|".$fila[3]."|".$fila[8]."|".$fila[9]."|".$fila[10]."|".$arreglo;
		}
		else
		{
			$conBloques="SELECT idBloqueGrado,etiqueta FROM 4242_bloquesGrados WHERE idGrado=".$idGrado." AND idMapaCiclo=".$idMapaCiclo." order by noBloque";
			$arreglo=$con->obtenerFilasArreglo($conBloques);
			echo "1||||||".$arreglo;
		}
	}
	
	function validarFechasBloqueGrado()
	{
		global $con;
		
		$bloqueAnt=$_POST["bAnt"];
		$fechaI=$_POST["fechaI"];
		$fechaF=$_POST["fechaF"];
		$id=$_POST["id"];
		
		$consulta="SELECT fechaInicio,fechaFin FROM 4242_bloquesGrados WHERE idBloqueGrado=".$bloqueAnt;
		$fila=$con->obtenerPrimeraFila($consulta);
		if(($fila[0]=="") || ($fila[0]=="0000-00-00"))
		{
			echo "1|";
		}
		else
		{
			$fechaInicio=$fila[0];
			$fechaFin=$fila[1];
			
			if((cambiaraFechaMysql($fechaI)>$fechaFin))
				echo "1|";
			else
				echo "2|".date('d/m/Y',strtotime($fila[0]))."|".date('d/m/Y',strtotime($fila[1]));
		}
	}
	
	function eliminarBloqueGrado()
	{
		global $con;
		
		$id=$_POST["id"];
		
		$query="DELETE FROM 4242_bloquesGrados WHERE idBloqueGrado=".$id;
		if($con->ejecutarconsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerDatosRevoe()
	{
		global $con;
		$sede=$_POST["sede"];
		$idModalidad=$_POST["idModalidad"];
		$idPrograma=$_POST["idPrograma"];
		
		$revoe="";
		$fechaR="";
		$datosRevoe="SELECT revoe,DATE_FORMAT(fechaRevoe,'%d/%m/%Y') AS fechaRevoe FROM 4241_nuevosMapas WHERE idPrograma=".$idPrograma." AND sede='".$sede."' AND idModalidadCurso=".$idModalidad;
		//echo $datosRevoe;
		$filaD=$con->obtenerPrimeraFila($datosRevoe);
		if($filaD[0]!="")
		{
			$revoe=$filaD[0];
			$fechaR=$filaD[1];
		}
		
		echo "1|".$revoe."|".$fechaR;
	}
	
	function marcarRegistradoBloqueCalificaciones()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$idBloque=$_POST["idBloque"];
		$bandera=$_POST["bandera"];
		
		$conExiste="SELECT idRegistroBloqueMateria FROM 4247_registroCalBloqueMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo;
		$id=$con->obtenerValor($conExiste);
		
		if($id=="")
		{
			$query="INSERT INTO 4247_registroCalBloqueMateria(idMateria,idGrupo,estado) VALUES(".$idMateria.",".$idGrupo.",1)";
		}
		else
		{
			if($bandera==1)
			{
				$query="UPDATE 4247_registroCalBloqueMateria SET estado=1 WHERE idRegistroBloqueMateria=".$id;
			}
			else
			{
				$query="UPDATE 4247_registroCalBloqueMateria SET estado=0 WHERE idRegistroBloqueMateria=".$id;
			}
		}
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerSedesLibres()
	{
		global $con;
		
		$cadena=$_POST["cadena"];
		$conSedes="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE codigoInstitucion='".$_SESSION["codigoInstitucion"]."' AND institucion=1";
		//echo $conSedes;
		$res=$con->obtenerFilas($conSedes);
		$nreg=$con->filasAfectadas;
		
		$arrSedes="";
		while($fila=mysql_fetch_row($res))
		{
			$obj='{"codigoUnidad":"'.$fila[0].'","unidad":"'.$fila[1].'"}';	
			if($arrSedes=="")
				$arrSedes=$obj;
			else
				$arrSedes.=",".$obj;
		}
		$obj='{"numReg":"'.$nreg.'","registros":['.$arrSedes.']}';
		echo $obj;
	}
	
	function obtenerNumeroSedesLibres()
	{
		global $con;
		//$cadena=$_POST["cadena"];
	
	}
	
	function obtenerNombreDia($numeroDia)
	{
		 $nombreDia="";
		 switch($numeroDia)
		  {
			  case "1":
				$nombreDia="Lun";
			  break;
			  case "2":
				$nombreDia="Mar";
			  break;
			  case "3":
				$nombreDia="Mir";
			  break;
			  case "4":
				$nombreDia="Jue";
			  break;
			  case "5":
				$nombreDia="Vie";
			  break;
			  case "6":
				$nombreDia="Sab";
			  break;
			  case "0":
				$nombreDia="Dom";
			  break;
		  }
		  return $nombreDia;
	}
	
	function obtenerClaveMateria()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		
		$consulta="SELECT cve_materia FROM 4013_materia WHERE idMateria=".$idMateria;
		$clave=$con->obtenerValor($consulta);
		
		echo "1|".$clave;
	}
	
	function validarClaveMateria()
	{
		global $con;
		
		$clave=base64_decode($_POST["clave"]);
		$idMapaCurricular=$_POST["idMapaCurricular"];
		
		$consulta="SELECT idMateria FROM 4031_elementosMapa WHERE idMapaCurricular=".$idMapaCurricular." AND claveMateria='".$clave."'";
		$existe=$con->obtenerFilas($consulta);
		$nFilas=$con->filasAfectadas;
		
		if($nFilas==0)
			echo "1|";
		else
			echo "2|";
	}
	
	function obtenerPeriodoInstanciaPlan()
	{
		global $con;
		$idInstancia=$_POST["idInstancia"];
		$consulta="SELECT id__464_gridPeriodos,nombrePeriodo FROM _464_gridPeriodos g,4513_instanciaPlanEstudio i 
					WHERE idReferencia=i.idPeriodicidad AND i.idInstanciaPlanEstudio=".$idInstancia;
		$arrRegistros=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrRegistros;
	}
	
	function obtenerGradosInstanciaPlan()
	{
		global $con;
		$idInstancia=$_POST["idInstancia"];
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		$consulta="SELECT e.grado,leyendaGrado FROM 4546_estructuraPeriodo e,4501_Grado g WHERE g.idGrado=e.idGrado AND e.idInstanciaPlanEstudio=".$idInstancia." AND e.idCiclo=".$idCiclo."
				AND e.idPeriodo=".$idPeriodo." ORDER BY ordenGrado";
		$arrRegistros=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrRegistros;
	}
	
	function obtenerGruposMaestrosInstanciaPlan()
	{
		global $con;
		$idInstancia=$_POST["idInstancia"];
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		$grado=$_POST["grado"];
		$consulta="SELECT idGrupoPadre,nombreGrupo FROM 4540_gruposMaestros WHERE idInstanciaPlanEstudio=".$idInstancia." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo."
					AND codigoGrado='".$grado."' ORDER BY nombreGrupo";
		$arrRegistros=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrRegistros;	
	}
	
	function obtenerAlumnosGrupoMaestro()
	{
		global $con;
		
		$idGrupoMaestro=$_POST["idGrupoMaestro"];
		$consulta="SELECT i.idUsuario,CONCAT(Paterno,' ',Materno,' ',Nom) AS alumnos FROM 4529_alumnos a,802_identifica i 
					WHERE i.idUsuario=a.idUsuario AND idGrupo=".$idGrupoMaestro." ORDER BY Paterno,Materno,Nom";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	}
?>