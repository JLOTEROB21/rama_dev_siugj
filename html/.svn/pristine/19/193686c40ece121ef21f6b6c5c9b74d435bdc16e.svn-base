<?php session_start();
	ini_set("memory_limit","256M");
	ini_set('max_execution_time',360000);
	set_time_limit (360000);
	include_once("conexionBD.php");
	include_once("funcionesNomina.php");
	$parametros="";
	$funcion="";
	if(isset($_POST["funcion"]))
	{
		$funcion=$_POST["funcion"];
	}	
	
	
	switch($funcion)
	{
		case 1:
			eliminarMaterial();
		break;
		case 2:
			obtenerSubtemas();
		break;
		case 3:
			obtenerElementosMateria();
		break;
		case 4:
			eliminarMaterialGral();
		break;
		case 5:
			eliminarMaterialGralTabla();
		break;
		case 6:
			obtenerElementosSesion();
		break;
		case 7:
			guardarVinculoSesiones();
		break;
		case 8:
			eliminarVinculoSesionesTema();
		break;
		case 9:
			eliminarSesionesTema();
		break;
		case 10:
			eliminarCatalogos();
		break;
		case 11:
			checarHorariosCeda();
		break;
		case 12:
			eliminarTemasAreaPractica();
		break;
		case 13:
			eliminarAreaPractica();
		break;
		case 14:
			eliminarUnidad();
		break;
		case 15:
			eliminarSesionArea();
		break;
		case 16:
			eliminarSesionExamen();
		break;
		case 17:
			eliminarTemaExamen();
		break;
		case 18:
			comprobarGenerarSesiones();
		break;
		case 19:
			eliminarExamen();
		break;
		case 20:
			comprobarGenerarSesionesLibre();
		break;
		case 21:
			recursosHijo();
		break;
		case 22:
			guardarPonderacionesCriterios();
		break;
		case 23:
			modificarConfiguracionBloque();
		break;
		case 24:
			//removerCriterioEvaluacion();
		break;
		case 25:
			validarHorarioSesion();
		break;
		case 26:
			guardarSesionAbierta();
		break;
		case 27:
			cancelarSesion();
		break;
		case 28:
			guardarRecursosSesion();
		break;
		case 29:
			borrarRecursoSesion();
		break;
		case 30:
			guardarProfesorInvitado();
		break;
		case 31:
			eliminarProfesorInvitado();
		break;
		case 32:
			eliminarTecnicaSesion();
		break;
		case 33:
			agregarParticipanteInv();
		break;
		case 34:
			crearGrupoMateriaComp();
		break;
		case 35:
			eliminarGrupo();
		break;
		case 36:
			obtenerElementosCatalogo();
		break;
		case 37:
			obtenerMaximoOrdenPlaneacion();
		break;
		case 38:
			actualizarOrden();
		break;
		case 39:
			obtenerAlumnosMateria();
		break;
		case 40:
			inscribirAlumnoMateria();
		break;
		case 41:
			removerAlumnoMateria();
		break;
		case 42:
			inscribirAlumnoGrupo();
		break;
		case 43:
			obtenerListadoAlumnosMateriaGrupo();
		break;
		case 44:
			modificarConfiguracionBloqueCriterio();
		break;
		case 45:
			obtenerListadoAlumnosClase();
		break;
		case 46:
			obtenerBloquesMateria();
		break;
		case 47:
			guardarCalificacionCriterio();
		break;
		case 48:
			guardarCalificacionCriterioEntregablesBloque();
		break;
		case 49:
			guardarCalificacionCriterioDirectaBloque();
		break;
		case 50:
			guardarVistaCalificaciones();
		break;
		case 51:
			obtenerDatosVistaCalificaciones();
		break;
		case 52:
			obtenerCriteriosEvaluacion();
		break;
		case 53:
			registrarCriteriosEvaluacionMateria();
		break;
		case 54:
			obtenerCriteriosEvaluacionMateria();
		break;
		case 55:
			guardarPorcentajeCriterio();
		break;
		case 56:
			obtenerConfiguracionBloques();
		break;
		case 57:
			guardarConfiguracionBloque();
		break;
		case 58:
			removerCriterioEvaluacion();
		break;
		case 59:
			obtenerAlumnosGruposCalificacion();
		break;
		case 60:
			guardarCalificacionAlumnoBloque();
		break;
		case 61:
			obtenerRegistrosAsistenciaProfesor();
		break;
		case 100:
			guardarBloque();
		break;
		case 101:
			criteriosBloque();
		break;
		case 102:
			guardarTarea();
		break;
		case 103:
			llenarComboBloques();
		break;
		case 104:
			actualizarSesion();
		break;
		case 105:
			obtenerAreasPracticas();
		break;
		case 106:
			cancelarSesionAreaPractica();
		break;
		case 107:
			comprobarPlanecionMateria();
		break;
		case 108:
			guardarCatalogoReporte();
		break;
		case 109:
			eliminarCatalogoReporte();
		break;
		case 110:
			guardarSemanasBloque();
		break;
		case 111:
			comprobarSesionesBloque();
		break;
		case 112:
			eliminarElementoPlaneacion();
		break;
		case 113:
			obtenerDatosGrupo();
		break;
		case 114:
			modificarGrupoMateriaComp();
		break;
		case 115:
			horarioMateriaComp();
		break;
		case 116:
			vincularGrupoMaterial();
		break;
		case 117:
			quitarVinculoGrupoMaterial();
		break;
		case 118:
			borrarElementoReporte();
		break;
		case 119:
			obtenerProgramasProfesor();
		break;
		case 120:
			obtenerGradosProfesor();
		break;
		case 121:
			vincularMatD();
		break;
		case 122:
			obtenerRecursoCategoria();
		break;
		case 123:
			obtenerElementosCatalogo2();
		break;
		case 124:
			agregarCriterioEvaluacionExtra2();
		break;
		case 125:
			guardarAvisosSesion();
		break;
		case 126:
			guardarEnlacesSesion();
		break;
		case 127:
			modificarAvisosSesion();
		break;
		case 128:
			modificarEnlaceSesion();
		break;
		case 129:
			guardarPlaneacionSesion();
		break;
		case 130:
			guardarPlaneacionCompartida();
		break;
		case 131:
			sobreescribirPlaneacionCompartida();
		break;
		case 132:
			aceptarPlaneacionCompartida();
		break;
		case 133:
			guardarNoBloquesMateria();
		break;
		case 134:
			modificarPonderacionCriterio();
		break;
		case 135:
			obtenerConfiguracionBloquesCriterio();
		break;
		case 136:
			guardarCatalogosSesion();
		break;
		case 137:
			guardarMaterialesUnidad();
		break;
		case 138:
			resetearSesion();
		break;
		case 139:
			llenarVentanaMotivo();
		break;
		case 140:
			obtenerBloquesMateria2();
		break;
		case 141:
			guardarConfEspecial();
		break;
		case 142:
			obtenerDatosConfEspecial();
		break;
		case 143:
			eliminarConfEspecial();
		break;
		case 144:
			obtenerInformacionDocumento();
		break;
		case 145:
			modificarValorLimiteMaximo();
		break;
		case 146:
			obtenerAlumnosGruposCalificacionPerfilEvaluacion();
		break;
		case 147:
			guardarCalificacionAlumnoBloquePerfilEvaluacion();
		break;
		case 148:
			cerrarCapturaEvaluacion();
		break;
		case 149:
			obtenerSolicitudesCambioEvaluacion();
		break;
		case 150:
			marcarDesmarcarAlumnoEvaluacion();
		break;
			
	}
	
	function eliminarMaterial()
	{
		global $con;
	
		$idMaterial=$_POST["idMaterial"];
		$idMateria=$_POST["idMateria"];
		$consulta="delete from 4051_materialesVSTema where idTema=".$idMateria." and idMaterial=".$idMaterial;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerSubtemas ()
	{
		global $con;
		
		$idPadre=$_POST["idTema"];
		if($idPadre!="-1")
		{
			$consulta="select idTema,nombreTema from 4039_temas where idPadre=".$idPadre;
		}
		else
			$consulta="select idTema,nombreTema from 4039_temas where 1=0";
		$fila=$con->obtenerFilasArreglo($consulta);
		 echo "1|".$fila ;
	}
	
	
	function generarArbolTemas($id,$numeracion)
	{
		 global $con;
		 
		 
		 $cadena="";
		 $consulta="select idTema,numTema,nombreTema from 4039_temas where idPadre=".$id."";
		 $res2=$con->obtenerFilas($consulta);
		 $clase="filaBlanca10";
		 $ct=1;
			   while($fila=mysql_fetch_row($res2))
			   {
			   		$hijos=generarArbolTemas($fila[0],$numeracion.$ct.".");
					
					if ($hijos=="[]")
					{
					$obj="{
									id:".$fila[0].",
									text: '".$numeracion.$ct.".- ".$fila[2]."',
									checked:false,
									icon:'images/s.gif',
									leaf: true,
									draggable:false,
									listeners:	{
															'checkchange': checaHijos
												}
									
						  }
								 ";
					}
					else
					{
					$obj="{
									id:".$fila[0].",
									text: '".$numeracion.$ct.".- ".$fila[2]."',
									checked:false,
									icon:'images/s.gif',
									draggable:false,
									listeners:	{
															'checkchange': checaHijos
												},
									children:
												".$hijos."
												
								             
								   }
								 ";
					
					}
					if($cadena!="")
						$cadena.=",".$obj;
					else
						$cadena=$obj;
						
					$ct++;				
			   }
		
		return "[".$cadena."]";
		
	
	}

	
	function obtenerElementosMateria()
	{
	global $con;
	global $mostrarXML;
	$mostrarXML=false;
	if(isset($_POST["idMateria"]))
		$idMateria="-".$_POST["idMateria"];
	$cadTemas=generarArbolTemas($idMateria,"");
	echo $cadTemas;
			   	
	}
	
	function obtenerElementosSesion()
	{
	global $con;
	global $mostrarXML;
	$mostrarXML=false;
	if(isset($_POST["idMateria"]))
		$idMateria=$_POST["idMateria"];
	
	$cadSesiones=generarArbolSesiones($idMateria);
	echo $cadSesiones;
			   	
	}
	
	function generarArbolSesiones($id)
	{
		 global $con;
		 $cadena="";
		 $consulta="select *from 4053_sesiones where idMateria=".$id;
		 $res2=$con->obtenerFilas($consulta);
			
		   while($fila2=mysql_fetch_row($res2))
		   {
				$obtenerHijos=obtenerHijos($fila2[0]);
				if($obtenerHijos=="")
				{
					$obj="{
									id:'".$fila2[0]."',
									text: 'Sesion".$fila2[4]."',
									leaf: true,
									icon:'images/s.gif',
									draggable:false,
									listeners:	{
															'click':mostrarClick
												}
									
						  }
								 ";
				}
				else
				{
					$obj="{
									id:'".$fila2[0]."',
									text: 'Sesion".$fila2[4]."',
									icon:'images/s.gif',
									draggable:false,
									listeners:	{
															'click':mostrarClick
												},
									children:
												".$obtenerHijos."
						  }
								 ";
				}
				
				if($cadena!="")
					$cadena.=",".$obj;
				else
					$cadena.=$obj;
					
		   }
			    
		
		return "[".$cadena."]";
		
	
	}
	
	function eliminarMaterialGral()
	{
		global $con;
		$idMaterial=base64_decode($_POST["idMaterial"]);
		
		$consulta="select  idMaterialDidactico from  4050_materialDidactico 
		where idMaterialDidactico=".$idMaterial;
	    $existe=$con->ObtenerValor($consulta);
		
		if($existe=="")
			echo"1|";
		else
		{
			$consulta="begin";
			if($con->ejecutarConsulta($consulta))
			{
				$ct=0;
				$query[$ct]="delete from 4050_materialDidactico where idMaterialDidactico=".$idMaterial ;
				$ct++;
				
				$query[$ct]="delete from 4051_materialesVSTema where idMaterial=".$idMaterial;
				$ct++;
				
				$query[$ct]="commit";
				
				if($con->ejecutarBloque($query))
				{	
					echo"1|";
				}
				else
				{
					echo "2|";
				}
			}
		}
	}
	
	function eliminarMaterialGralTabla()
	{	
	
		global $con;
		$idMaterial=base64_decode($_POST["idMaterial"]);
		
		$consul="begin";
		$con->ejecutarConsulta($consul);
		
		$consulta[0]="delete from 4050_materialDidactico where idMaterialDidactico=".$idMaterial ;
		
		$consulta[1]="delete from 4051_materialesVSTema where idMaterial=".$idMaterial;
		
			if($con->ejecutarBloque($consulta))
			{
				$consul="commit";
				$con->ejecutarConsulta($consul);
				echo "1|";
			}	
				
			else
				echo "|";
	

	}
	
	function obtenerHijos($id)
	{
		global $con;
		$cadenaHijos="";
		$consulta="select t.idTema,nombreTema from 4039_temas t,4054_sesionesVSTemario s where t.idTema=s.idTema and s.idSesion=".$id;  
	    $res2=$con->obtenerFilas($consulta);
		
		 while($fila2=mysql_fetch_row($res2))
		   {
				
				$obj="{
								id:'".$id."_".$fila2[0]."',
								text: 'Tema".$fila2[1]."',
								leaf: true,
								checked:false,
								icon:'images/s.gif',
								draggable:false,
								listeners:	{
															'click':mostrarClick2
												}
								
								
								
					  }
							 ";
				
				if($cadenaHijos!="")
					$cadenaHijos.=",".$obj;
				else
					$cadenaHijos.=$obj;
					
		   }
		
		
	return "[".$cadenaHijos."]";
	
	}
	
	function guardarVinculoSesiones()
	{
		global $con;
		$arregloTema=$_POST["check"];
		$arreglo=explode(",",$arregloTema);
		$tamano=sizeof($arreglo);
		$idSesion=$_POST["idSesion"];
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		
		{
			$ct=0;
			
				for($x=0;$x<$tamano;$x++) 
				{
					$idTema=$arreglo[$x];
						
						$consulta="select idSesion,idTema from 4054_sesionesVSTemario where idSesion=".$idSesion." and idTema=".$idTema;
						$nomTema=$con->ObtenerValor($consulta);
						if($nomTema=="")		
						{
							$query[$ct]="insert into 4054_sesionesVSTemario(idSesion,idTema) values 
										('".$idSesion."','".$idTema."')";
							$ct++;
						}
				}
			}
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
			{
				echo "1|";
			}
			else
			{
				echo "1|";
			}	
		
	}
	
	function eliminarVinculoSesionesTema()
	{	
	
		global $con;
		$arreglo=$_POST["arrlego"];
		$arreglo2=explode(",",$arreglo);
		$tamano=sizeof($arreglo2);
		$ct=0;
		$consul="begin";
		$con->ejecutarConsulta($consul);
			for($x=0;$x<$tamano;$x++)
			{
				$valorConsulta=$arreglo2[$x];
				$parejaValor=explode("_",$valorConsulta);
				$idSesion=$parejaValor[0];
				$idTema=$parejaValor[1];
			
	
			
				$consulta[$ct]="delete from 4054_sesionesVSTemario where idSesion=".$idSesion." and idTema=".$idTema ;
		        $ct++;
			}
		
			
			if($con->ejecutarBloque($consulta))
			{
				$consul="commit";
				$con->ejecutarConsulta($consul);
				echo "1|";
			}	
				
			else
				echo "|";
	

	}
	
	function eliminarSesionesTema()
	{
		global $con;
	
		
		$id=$_POST["id"];
		$consulta="delete from 4054_sesionesVSTemario where idSesionesVSTemario=".$id;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
		
		
		
	}
	
	function eliminarCatalogos()
	{
		global $con;
	
		
		$id=$_POST["id"];
		$tabla=$_POST["tabla"];
		$idTabla=$_POST["idTabla"];
		
		$consulta="delete from ".$tabla." where ".$idTabla."=".$id;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
		
	}
	
	function checarHorariosCeda()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$idCiclo=$_POST["idCiclo"];
		$noSesion=$_POST["noSesion"];
		$idArea=$_POST["idArea"];
		$horaInicio=$_POST["horaIni"];
		$horaFin=$_POST["horaFin"];
		$fecha=$_POST["fecha"];
		$fecha=cambiaraFechaMysql($fecha);
		$tipoSesion=$_POST["tipoSesion"];
		$idUsuario=$_SESSION["idUsr"];
		$noAlumnos=0;
		if(isset($_POST["noAlumnos"]))
		{
			$noAlumnos=$_POST["noAlumnos"];
			if($noAlumnos=="")
			{
				$noAlumnos=0;
			}
		}
		
		$consultaFecha="select horaInicio,horaFin from 4098_apartaRecursos where idRecursoApartado=".$idArea." and fecha='".$fecha."'";
		$resFecha=$con->obtenerFilas($consultaFecha);
		$filasFecha=$con->filasAfectadas;
		
		while($fila2=mysql_fetch_row($resFecha))
		{
			$horaIniSesion=strtotime($horaInicio);
			$horaFinSesion=strtotime($horaFin);
			
			$horaIniCeda=strtotime($fila2[0]);
			$horaFinCeda=strtotime($fila2[1]);
			
			if( ($horaIniSesion >= $horaIniCeda) && ($horaIniSesion<$horaFinCeda)||($horaFinSesion > $horaIniCeda) && ($horaFinSesion<=$horaFinCeda))            
			{
				  echo "2|espacio ocupado";
				  return;
			}
			else
			{
				if( ($horaIniCeda >= $horaIniSesion) && ($horaIniCeda<$horaFinSesion)||($horaFinCeda > $horaIniSesion) && ($horaFinCeda<=$horaFinSesion)) 
				{
					echo "2|espacio ocupado";
					return;
				}
			}
		}
		
		$consulta="begin";
		$ct=0;
		if($con->ejecutarConsulta($consulta))
		{
			$conInsetar="INSERT INTO 4142_areasPracticasMateria (idArea,idMateria,idGrupo,alumnosEstacion,noSesion) VALUES('".$idArea."','".$idMateria."','".$idGrupo."','".$noAlumnos."','".$noSesion."')";
			$resultado=$con->ejecutarConsulta($conInsetar);
			if($resultado)
			{
				$idAreaMateria=$con->obtenerUltimoID();
				
				$query[$ct]="insert into 4098_apartaRecursos(idRecursoApartado,idUsrApartador,estadoRecurso,tipo,evento,edoSolicitud,fecha,horaInicio,horaFin) 
					values ('".$idArea."','".$idUsuario."','1','1','sesion','0','".$fecha."','".$horaInicio."','".$horaFin."')";
				$ct++;
				
				$query[$ct]="update 4053_sesiones set tipoSesion=".$tipoSesion." where idMateria=".$idMateria." and idGrupo=".$idGrupo." and noSesion=".$noSesion;
				$ct++;
			
			$query[$ct]="commit";
			
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
			}
		}
	}
		
//( ( horaInicio>='".$horaI."' and horaFin<'".$horaI."')or (horaInicio > '".$horaF."' and  horaFin<='".$horaF."'))";

//( (horaInicio >='".$fila[2]."'  and horaFin<'".$fila[2]."')or (horaInicio >'".$fila[3]."'  and  horaFin<='".$fila[3]."'))";


	function eliminarTemasAreaPractica()
	{
		global $con;
	
		
		$idTema=$_POST["idTema"];
		$idAreaMateria=$_POST["idAreaMateria"];
		
		
		$consulta="select idTema from 4145_areaVSTema where idAreaVSMateria=".$idAreaMateria;
		$res=$con->obtenerFilas($consulta);
		$filas=$con->filasAfectadas;
		
		if($filas==1)
		{
			echo "2|";
		}
		else
		{
			$eliminar="delete from 4145_areaVSTema where idTema=".$idTema." and idAreaVSMateria=".$idAreaMateria ;
			if($con->ejecutarConsulta($eliminar))
				echo "1|";
			else
				echo "3|";
		}
	}

	function eliminarAreaPractica()
	{
		global $con;
	
		
		$idTema=$_POST["idTema"];
		$idAreaMateria=$_POST["idAreaMateria"];
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		
		$ct=0;
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$query[$ct]="delete from 4142_areasPracticasMateria where idAreaPracticaVSMateria=".$idAreaMateria ;
			
			$ct++;
			
			$consultaHorario="select distinct(noSesion) from 4146_areaHorario where idAreaMateria=".$idAreaMateria;
			$filas=$con->obtenerFilas($consultaHorario);
			
			while($fila=mysql_fetch_row($filas))
			{
				$query[$ct]="update 4053_sesiones set tipoSesion=0 where idMateria=".$idMateria." and idGrupo=".$idGrupo." and noSesion=".$fila[0] ;
			
				$ct++;
				
				$query[$ct]="delete from 4146_areaHorario where idAreaMateria=".$idAreaMateria;
				$ct++;
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "2|";
				
		}
	}
	
	
	function eliminarUnidad()
	{
		global $con;
		$idArea=$_POST["idArea"];
		$unidades=$_POST["idUnidad"];
		$arregloUnidades=explode(",",$unidades);
		$tamano=sizeof($arregloUnidades);
		$ct=0;
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			for($x=0;$x<$tamano;$x++) 
			{
				$idUnidad=$arregloUnidades[$x];
					
						$query[$ct]="delete from 4143_unidadesVSAreasPracticas where idUnidadVSAreaPractica=".$idUnidad." and idArea=".$idArea ;
						$ct++;
				   
			}
		
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		
		}

	}
	
	
	function eliminarSesionArea()
	{
		global $con;
	
		
		$idArea=$_POST["idArea"];
		$idAreaMateria=$_POST["idAreaMateria"];
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$noSesion=$_POST["noSesion"];
		
		
		$consulta="select noSesion from 4146_areaHorario where idMateria=".$idMateria." and idGrupo=".$idGrupo." and idArea=".$idArea." and idAreaMateria=".$idAreaMateria;
		//echo $consulta;
		$res=$con->obtenerFilas($consulta);
		$filas=$con->filasAfectadas;
		
		if($filas==1)
		{
			echo "2|";
		}
		else
		{
			$ct=0;
			$consul="begin";
			if($con->ejecutarConsulta($consul))
			{
			  $query[$ct]="delete from 4146_areaHorario where idMateria=".$idMateria." and idGrupo=".$idGrupo." and idArea=".$idArea." and idAreaMateria=".$idAreaMateria." and noSesion=".$noSesion ;
			  
			  $ct++;
			  
			  $query[$ct]="update 4053_sesiones set tipoSesion=0 where idMateria=".$idMateria." and idGrupo=".$idGrupo." and noSesion=".$noSesion ;
			  
			  $ct++;
			  $query[$ct]="commit";
			  
			  if($con->ejecutarBloque($query))
				  echo "1|";
			  else
				  echo "3|";
			}
		}

	}
	
	
	function eliminarSesionExamen()
	{
		global $con;
		
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$idExamenMateria=$_POST["idExamenMateria"];
		$noSesion=$_POST["noSesion"];
		
		
		$consulta="select noSesion from 4150_sesionesExamen where idExamenMateria=".$idExamenMateria ;
		//echo $consulta;
		$res=$con->obtenerFilas($consulta);
		$filas=$con->filasAfectadas;
		
		if($filas==1)
		{
			echo "2|";
		}
		else
		{
			$ct=0;
			$consul="begin";
			if($con->ejecutarConsulta($consul))
			{
			  $query[$ct]="delete from 4150_sesionesExamen where idExamenMateria=".$idExamenMateria."  and noSesion=".$noSesion ;
			  
			  $ct++;
			  
			  $query[$ct]="update 4053_sesiones set tipoSesion=0 where idMateria=".$idMateria." and idGrupo=".$idGrupo." and noSesion=".$noSesion ;
			  
			  $ct++;
			  $query[$ct]="commit";
			  
			  if($con->ejecutarBloque($query))
				  echo "1|";
			  else
				  echo "3|";
			}
		}

	}
	
	function eliminarTemaExamen()
	{
		global $con;
		
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$idExamenMateria=$_POST["idExamenMateria"];
		$idTemaExamen=$_POST["idTemaExamen"];
		
		
		$consulta="select idTema from 4151_temaExamen where idExamenMateria=".$idExamenMateria ;
		//echo $consulta;
		$res=$con->obtenerFilas($consulta);
		$filas=$con->filasAfectadas;
		
		if($filas==1)
		{
			echo "2|";
		}
		else
		{
			$ct=0;
			$consul="begin";
			if($con->ejecutarConsulta($consul))
			{
			  $query[$ct]="delete from 4151_temaExamen where idTemaExamen=".$idTemaExamen ;
			  
			  $ct++;
			 
			  $query[$ct]="commit";
			  
			  if($con->ejecutarBloque($query))
				  echo "1|";
			  else
				  echo "3|";
			}
		}

	}
	
	function comprobarGenerarSesiones()
	{
		global $con;
		
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$idCiclo=$_POST["idCiclo"];
		$idUsuario=$_SESSION["idUsr"];
		
		$conDatos="SELECT idGrado,idPrograma,ciclo FROM 4048_grupos WHERE idGrupo=".$idGrupo;
		$grado=$con->obtenerPrimeraFila($conDatos);
		
		$idGrado=$grado[0];
		$idPrograma=$grado[1];
		
		//la materia no tiene horario asignado
		$consulta="SELECT idMateriaVSGrupo FROM 4065_materiaVSGrupo WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo;
		//echo $consulta;
		$res=$con->obtenerFilas($consulta);
		$filas=$con->filasAfectadas;
		
		if($filas==0)
		{
			echo "2|";
		}
		else
		{
			//ell estado del mapa no ha sido liberado
			$mapaCurricular="SELECT idMapaCurricular FROM 4029_mapaCurricular WHERE idPrograma=".$idPrograma." AND ciclo=".$idCiclo;
			$mapa=$con->obtenerPrimeraFila($mapaCurricular);
			
			$estadoMapa="SELECT estadoMapa FROM 4029_mapaCurricular WHERE idMapaCurricular=".$mapa[0];
			$estado=$con->obtenerValor($estadoMapa);
			
			if($estado=="2")
			{
				
				$fechasGrado="SELECT fechaInicio,fechaFin FROM 4014_grados WHERE idGrado=".$idGrado ;
				//echo $fechasGrado;
				$fechas=$con->obtenerPrimeraFila($fechasGrado);
				if(($fechas[0]=="") && ($fechas[1]==""))
				{
					echo"4|";
				}
				else
				{
					echo "1|";
				}
			}
			else
			{
				echo "3|";
			}
		}

	}
	
	function eliminarExamen()
	{
		global $con;
		
		$idExamenMateria=$_POST["idExamenMateria"];
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		
		$sesionExamen="SELECT noSesion FROM 4150_sesionesExamen WHERE idExamenMateria=".$idExamenMateria;
		$resSesion=$con->obtenerfilas($sesionExamen);
		
		$ct=0;
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$sesionExamen="SELECT noSesion FROM 4150_sesionesExamen WHERE idExamenMateria=".$idExamenMateria;
		    $resSesion=$con->obtenerfilas($sesionExamen);
			
			while($fila=mysql_fetch_row($resSesion))
			{
				$query[$ct]="update 4053_sesiones set tipoSesion=0 where idMateria=".$idMateria." and idGrupo=".$idGrupo." and noSesion=".$fila[0] ;
			
				$ct++;
			}
			
			$query[$ct]="delete from 4149_examenMateria where idExamenMateria=".$idExamenMateria ;
			
			$ct++;
		
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "2|";
		}
	}
	
	function comprobarGenerarSesionesLibre()
	{
		global $con;
		
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$idCiclo=$_POST["idCiclo"];
		$idUsuario=$_SESSION["idUsr"];
		
		//ell estado del mapa no ha sido liberado
		$gradoGrupo="SELECT idGrado FROM 4048_grupos WHERE idGrupo=".$idGrupo;
		$grado=$con->obtenerPrimeraFila($gradoGrupo);
		
		$mapaCurricular="SELECT idMapaCurricular FROM 4068_fechaCalendario WHERE idEtiqueta=1 AND idGrado=".$grado[0];
		$mapa=$con->obtenerPrimeraFila($mapaCurricular);
		
		$estadoMapa="SELECT estadoMapa FROM 4029_mapaCurricular WHERE idMapaCurricular=".$mapa[0];
		$estado=$con->obtenerPrimeraFila($estadoMapa);
		
		if($estado[0]=="2" )
		{
			echo "1|";
		}
		else
		{
			echo "3|";
		}
		

	}
	
	function recursosHijo()
	{
		global $con;
		
		$idRecurso=$_POST["idRecurso"];
		//ell estado del mapa no ha sido liberado
		$conRecursos="SELECT titulo,descripcion,marca,modelo,noSerie,capacidad,observaciones FROM 4009_recursos WHERE idInmueble=".$idRecurso ;
		$arregloRecurso=$con->obtenerFilasArreglo($conRecursos);
		echo "1|".$arregloRecurso."" ;
			
	}
	
	function guardarPonderacionesCriterios()
	{
		global $con;
		$conf=$_POST["objConf"];
		$objConf=json_decode($conf);
		$idGrupo=$objConf->idGrupo;
		$idMateria=$objConf->idMateria;
		$idPadre=$objConf->idPadre;
		$idCatalogo=$objConf->idCatalogo;
		$idCriterio=$objConf->criterio;
		$esquemaEval=$objConf->esquemaEval;
		$confBloques=$objConf->confBloques;
		$nivel=$objConf->nivel;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO 4156_criteriosEvaluacionExtra(idEvaluacion,idGrupo,idMateria,tipoCriterio,idPadre,nivel)VALUES(".$idCriterio.",".$idGrupo.",
					".$idMateria.",".$idCatalogo.",".$idPadre.",".$nivel.")";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$idCriterioEvaluacionExtra=$con->obtenerUltimoID();
			$x=0;
			$consulta=array();
			foreach($confBloques as $confBloque)
			{
				
				$consulta[$x]="INSERT INTO 4152_ponderacionCriterios(idEvaluacion,valor,bloque,tipoCriterio,tipoBloque,idGrupo,idMateria,idPadre,solicitarCalificacion)
							VALUES(".$idCriterio.",".$confBloque->ponderacion.",".$confBloque->idBloque.",".$idCatalogo.",".$esquemaEval.",".$idGrupo.",".$idMateria.",".$idPadre.",".$confBloque->solCal.")";
				$x++;
			}
		
			$query="SELECT noParciales FROM 4502_Materias WHERE idMateria=".$idMateria ;
			$filaMateria=$con->obtenerPrimeraFila($query);
				
			$bloques=$filaMateria[0];
			for($nBloque=1;$nBloque<=$bloques;$nBloque++)
			{
				$consulta[$x]="INSERT INTO 4156_confBloquesCriterio(bloque,tipoBloque,pondCriteriosEq,idCriterioEvaluacionExtra)VALUES(".$nBloque.",0,0,".$idCriterioEvaluacionExtra.")";
				$x++;
			}
			
			
			$consulta[$x]="INSERT INTO 4156_confBloquesCriterio(bloque,tipoBloque,pondCriteriosEq,idCriterioEvaluacionExtra)VALUES(0,0,0,".$idCriterioEvaluacionExtra.")";
			$x++;
			$consulta[$x]="commit";
			$x++;
			eB($consulta);
		}
		else
			echo "|";
	}
	
	
	

	
	function agregarParticipanteInv($objParam=null)
	{
		global $con;
		global $urlSitio;
		
		
		if($objParam!=null)
			$cadObjJson=$objParam;
		else
			$cadObjJson=$_POST["datosAutor"];
		
		
		$objJson=json_decode($cadObjJson);
		
		$apPaterno=$objJson->apPaterno;
		$apMaterno=$objJson->apMaterno;
		$nombre=$objJson->nombres;
		$nombreC=trim($nombre).' '.trim($apPaterno).' '.trim($apMaterno);
		$mail=$objJson->email;
		$idMateria=$objParametros->idMateria;
		$idGrupo=$objParametros->idGrupo;
		$noSesion=$objParametros->noSesion;
		$idParticipacion=$objParametros->idParticipacion;
		$codInstitucion=$objJson->codInstitucion;
		$codDepto=$objJson->codDepto;
		$telefonos=$objJson->telefonos;
		$idIdioma="1";
		$password=generarPassword();
		$mailUsr=$mail;
		$status="5";
		$query="insert into 800_usuarios(Login,Status,FechaCambio,Password,Nombre,idIdioma) values('".cv(trim($mail))."',".$status.",'".date('Y-m-d')."','".cv($password)."','".cv($nombreC)."',".$idIdioma.")";
		if(!$con->ejecutarConsulta($query))
		{
			echo "|";
			return ;
		}
		$x=0;	
		$query="select horaInicio,horaFin,fecha from 4053_sesiones where noSesion=".$noSesion." and idMateria=".$idMateria."  and idGrupo=".$idGrupo;
		$filaSesion=$con->obtenerPrimeraFila($query);
		$hInicio=$filaSesion[0];
		$hFin=$filaSesion[1];
		$fecha=$filaSesion[2];
		$idUsuario=$con->obtenerUltimoID();
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="insert into 805_mails(Mail,Tipo,Notificacion,idUsuario) values('".cv(trim($mail))."',0,1,".$idUsuario.")";
		$x++;
		$consulta[$x]="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$idUsuario.",-1000,0,'-1000_0')";
		$x++;
		$consulta[$x]="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$idUsuario.",5,0,'5_0')";
		$x++;
		$consulta[$x]="insert into 802_identifica(Nom,Paterno,Materno,Nombre,Status,idUsuario) 
					  values('".cv($nombre)."','".cv($apPaterno)."','".cv($apMaterno)."','".cv($nombreC)."',".$status.",".$idUsuario.")";
		$x++;
		$consulta[$x]="insert into 801_adscripcion(Institucion,Status,idUsuario,codigoUnidad) values('".cv($codInstitucion)."',".$status.",".$idUsuario.",'".$codDepto."')";
		$x++;
		$consulta[$x]="insert into 803_direcciones(idUsuario,Tipo) values(".$idUsuario.",0)";
		$x++;
		$consulta[$x]="insert into 803_direcciones(idUsuario,Tipo) values(".$idUsuario.",1)";
		$x++;
		$consulta[$x]="insert into 806_fotos(idUsuario) values(".$idUsuario.")";
		$x++;
		$consulta[$x]="insert into 4047_participacionesMateria(idUsuario,idMateria,idGrupo,idParticipacion) values(".$idUsuario.",".$idMateria.",".$idGrupo.",".$idParticipacion.")";
		$x++;
		$consulta[$x]="insert into 4069_participantesInvitados(idUsuario,idMateria,idGrupo,noSesion,estado,horaInicio,horaFin,fecha) values(".$idUsuario.",".$idMateria.",".$idGrupo.",".$noSesion.",1,'".$hInicio."','".$hFin."','".$fecha."')";
		$x++;
		
		if($telefonos!="")
		{
			$arrTelefonos=explode(",",$telefonos);
			$ct=sizeof($arrTelefonos);
			for($y=0;$y<$ct;$y++)
			{
				$datosTel=explode("_",$arrTelefonos[$y]);
				$tipo=$datosTel[0];
				$codArea=$datosTel[1];
				$lada=$datosTel[2];
				$tel=$datosTel[3];
				$ext=$datosTel[4];
				$consulta[$x]="	insert into 804_telefonos(codArea,Lada,Numero,Extension,Tipo,Tipo2,idUsuario) 
								values('".$codArea."','".$lada."','".$tel."','".$ext."',1,".$tipo."".$idUsuario.")";
				$x++;
			}
		}
		
		$consulta[$x]="commit";
		$x++;
		$query="select titulo from 4013_materia where idMateria=".$idMateria;
		$nMateria=$con->obtenerValor($consulta);
		if($con->ejecutarBloque($consulta))		
		{
			$link=$urlSitio."/principal/activaCuenta.php?cta=".base64_encode("cuenta:".$idUsuario);
			$arrParametros='[
								["$user","'.$mailUsr.'"],["$passwd","'.$password.'"],["$actLink","'.$link.'"],
								["$apPaterno","'.$apPaterno.'"],["$apMaterno","'.$apMaterno.'"],
								["$nombre","'.$nombre.'"],["$nMateria","'.$nMateria.'"]
							]';
			$objEnvio='{"destinatarios":"'.$mailUsr.'","arrParametros":'.$arrParametros.',"idAccion":"2"}';//Generar mensaje de accion para regsitro d eprofesor invitado
			if(enviarCircular($objEnvio))
				echo "1|";
			else
				echo "|";
		}
		else
			echo "|";
	}
	
	function crearGrupoMateriaComp()
	{
		global $con;
		$idMateria=base64_decode($_POST["idMateria"]);
		$nGrupo=$_POST["nGrupo"];
		$vMin=$_POST["vMin"];
		$vMax=$_POST["vMax"];
		$consulta="select idGrupo from 4048_grupos where nombreGrupo='".cv($nGrupo)."' and idMateria=".$idMateria;
		$idGrupo=$con->obtenerValor($consulta);
		if($idGrupo=="")
		{
			$consulta="insert into 4048_grupos(nombreGrupo,cupoMinimo,cupoMaximo,idMateria,idSituacion) values('".cv($nGrupo)."',".$vMin.",".$vMax.",".$idMateria.",1)";
			if($con->ejecutarConsulta($consulta))
				echo "1|";
			else
				echo "|";
		}
		else
		{
			echo "2|El nombre del grupo ya se encuentra registrado";
		}
	}
	
	function eliminarGrupo()
	{
		global $con;
		$idGrupo=base64_decode($_POST["idGrupo"]);
		$idMateria=base64_decode($_POST["idMateria"]);
		$idCiclo=$_POST["idCiclo"];
		
		$consulta="begin";
		if($con->ejecutarconsulta($consulta))
		{
			$x=0;
			
			$query[$x]="delete FROM 4180_materiaCompVSGrupo WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo;
			$x++;
			  
			$query[$x]="delete from 4065_materiaVSGrupo WHERE idMateria=".$idMateria." AND idGrupoCompartido=".$idGrupo." and ciclo=".$idCiclo;
			$x++;
			
			$query[$x]="delete from 4048_grupos where idGrupo=".$idGrupo;
			$x++;
			
			$query[$x]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else 
				echo "|";
		}
	}
	
	function validarHorarioSesion()
	{
		global $con;
		$tipoSesion=$_POST["tipoSesion"];
		if($tipoSesion==2)
		{
			$idArea=$_POST["idArea"];
			$idMateria=$_POST["idMateria"];
			$idGrupo=$_POST["idGrupo"];
			$idCiclo=$_POST["idCiclo"];
			$idArea=$_POST["idArea"];
			$horaInicio=$_POST["horaIni"];
			$horaFin=$_POST["horaFin"];
			$fecha=$_POST["fecha"];
			$fecha=cambiaraFechaMysql($fecha);
			
			$consultaFecha="select horaInicio,horaFin from 4098_apartaRecursos where idRecursoApartado=".$idArea." and fecha='".$fecha."'";
			$resFecha=$con->obtenerFilas($consultaFecha);
			$filasFecha=$con->filasAfectadas;
			
			while($fila2=mysql_fetch_row($resFecha))
			{
				$horaIniSesion=strtotime($horaInicio);
				$horaFinSesion=strtotime($horaFin);
				
				$horaIniCeda=strtotime($fila2[0]);
				$horaFinCeda=strtotime($fila2[1]);
				
				if( ($horaIniSesion >= $horaIniCeda) && ($horaIniSesion<$horaFinCeda)||($horaFinSesion > $horaIniCeda) && ($horaFinSesion<=$horaFinCeda))            
				{
					  echo "2|espacio ocupado";
					  return;
				}
				else
				{
					if( ($horaIniCeda >= $horaIniSesion) && ($horaIniCeda<$horaFinSesion)||($horaFinCeda > $horaIniSesion) && ($horaFinCeda<=$horaFinSesion)) 
					{
						echo "2|espacio ocupado";
						return;
					}
				}
			}
			echo "1|";
		}
		else
		{
			echo "1|";
		}
	}
	
	function guardarSesionAbierta()
	{
		global $con;
		$noSesion=$_POST["noSesion"];
		$fecha=$_POST["fecha"];
		$fecha=cambiaraFechaMysql($fecha);
		$horaInicio=$_POST["horaInicio"];
		$horaInicio=date('H:i:s',strtotime($horaInicio));
		$horaFin=$_POST["horaFin"];
		$horaFin=date('H:i:s',strtotime($horaFin));
		$tipoSesion=$_POST["tipoSesion"];
		$idMateria=$_POST["idMateria"];
		$bloque=$_POST["bloque"];
		$idArea=$_POST["idArea"];
		$noAlumnos=0;
		$idUsuario=$_SESSION["idUsr"];
		$idCiclo=$_POST["idCiclo"];
		if(isset($_POST["noAlumnos"]))
		{
			$noAlumnos=$_POST["noAlumnos"];
			if($noAlumnos=="")
			{
				$noAlumnos=0;
			}
		}
		$idGrupo=0;
		if(isset($_POST["idGrupo"]))
		{
			$idGrupo=$_POST["idGrupo"];
			if($idGrupo=="")
			{
				$idGrupo=0;
			}
		}
		
		if($tipoSesion==2)
		{
			$ct=0;
			$consulta="begin";
			if($con->ejecutarConsulta($consulta))
			{
				$conInsetar="INSERT INTO 4142_areasPracticasMateria (idArea,idMateria,idGrupo,alumnosEstacion,noSesion) VALUES('".$idArea."','".$idMateria."','".$idGrupo."','".$noAlumnos."','".$noSesion."')";
				$resultado=$con->ejecutarConsulta($conInsetar);
				if($resultado)
				{
					$idAreaMateria=$con->obtenerUltimoID();
					$conNomM="select titulo from 4013_materia where idMateria=".$idMateria;
					$nombreMat=$con->obtenerValor($conNomM);
					$evento="sesion".$noSesion."_".$nombreMat;
					
					$query[$ct]="insert into 4098_apartaRecursos(idRecursoApartado,idUsrApartador,estadoRecurso,tipo,evento,edoSolicitud,fecha,horaInicio,horaFin) 
					values ('".$idArea."','".$idUsuario."','1','1','".$evento."','0','".$fecha."','".$horaInicio."','".$horaFin."')";
					$ct++;
					
					$conExisteSesion="SELECT DISTINCT(noSesion) FROM 4053_sesiones WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." and noSesion=".$noSesion;
					$existeS=$con->obtenerValor($conExisteSesion);
					if($existeS=="")
					{
						$query[$ct]="insert into 4053_sesiones(noSesion,fecha,horaInicio,horaFin,tipoSesion,idMateria,tipo,idGrupo,bloque) values('".$noSesion."','".$fecha."','".$horaInicio."','".$horaFin."','".$tipoSesion."','".$idMateria."',0,'".$idGrupo."','".$bloque."')";
					}
					else
					{
						$query[$ct]="update 4053_sesiones set tipoSesion=".$tipoSesion.",horaInicio='".$horaInicio."',horaFin='".$horaFin."',fecha='".$fecha."' where idMateria=".$idMateria." AND idGrupo=".$idGrupo." and noSesion=".$noSesion;
					}
					$ct++;
				
				$query[$ct]="commit";
				
				if($con->ejecutarBloque($query))
					echo "1|";
				else
					echo "|";
				}
			}
		}
		else
		{
			$conExisteSesion="SELECT DISTINCT(noSesion) FROM 4053_sesiones WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." and noSesion=".$noSesion;
			$existeS=$con->obtenerValor($conExisteSesion);
			if($existeS=="")
			{
				$consulta="insert into 4053_sesiones(noSesion,fecha,horaInicio,horaFin,tipoSesion,idMateria,tipo,idGrupo,bloque) values('".$noSesion."','".$fecha."','".$horaInicio."','".$horaFin."','".$tipoSesion."','".$idMateria."',0,'".$idGrupo."','".$bloque."')";
			}
			else
			{
				$consulta="update 4053_sesiones set tipoSesion=".$tipoSesion.",horaInicio='".$horaInicio."',horaFin='".$horaFin."',fecha='".$fecha."' where idMateria=".$idMateria." AND idGrupo=".$idGrupo." and noSesion=".$noSesion;
			}
			if($con->ejecutarConsulta($consulta))
				echo "1|";
			else
				echo"2|";
		}
	}
	
	function cancelarSesion()
	{
		global $con;
		$noSesion=$_POST["noSesion"];
		$fecha=$_POST["fecha"];
		$horaIni=$_POST["horaIni"];
		$horaFin=$_POST["horaFin"];
		$idMateria=$_POST["idMateria"];
		$idUsuario=$_SESSION["idUsr"];
		$idMapaCurricular=$_POST["idMapaCurricular"];
		$motivo=$_POST["motivo"];
		$idGrupo=0;
		if(isset($_POST["idGrupo"]))
		{
			$idGrupo=$_POST["idGrupo"];
			if($idGrupo=="")
			{
				$idGrupo=0;
			}
		}
		
		$conPrograma="select idPrograma,ciclo from 4029_mapaCurricular where idMapaCurricular=".$idMapaCurricular ;
		$datos=$con->obtenerPrimeraFila($conPrograma);
		$conMateria="SELECT titulo FROM 4013_materia WHERE idMateria=".$idMateria ;
	    $nombre=$con->obtenerValor($conMateria);
	    $cadena="sesion".$noSesion."_".$nombre;
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			$query[$ct]="update 4053_sesiones set estado='CANCELLED' where noSesion=".$noSesion." and fecha='".$fecha."' and  idMateria=".$idMateria." and idGrupo=".$idGrupo;
			$ct++;
			$query[$ct]="update 4098_apartaRecursos set estadoRecurso=0 where idUsrApartador=".$idUsuario." and tipo=1 and evento='".$cadena."' and fecha='".$fecha."' and horaInicio='".$horaIni."' and horaFin='".$horaFin."'";
			$ct++;
			
			$query[$ct]="INSERT INTO 4197_motivoCancSesion(idMateria,idGrupo,noSesion,fecha,horaInicio,horaFin,motivo) VALUES('".$idMateria."','".$idGrupo."','".$noSesion."','".$fecha."','".$horaIni."','".$horaFin."','".$motivo."')";
			$ct++;
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|".$datos[0]."|".$datos[1];
			else
				echo"21";
		}
	}
	
	function guardarRecursosSesion ()
	{
	    global $con;
	    $noSesion=$_POST["noSesion"];
	    $idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
	    $fecha=$_POST["fecha"];
	    $recursos=$_POST["recursos"];
	    $arregloRecursos=explode(",",$recursos);
	    $tamanoRecursos=sizeof($arregloRecursos);
	    $horaIni=$_POST["horaIni"];
		$horaIni=date('H:i:s',strtotime($horaIni));
	    $horaFin=$_POST["horaFin"];
		$horaFin=date('H:i:s',strtotime($horaFin));
	    $idUsuario=$_SESSION["idUsr"];

		$conMateria="SELECT titulo FROM 4013_materia WHERE idMateria=".$idMateria ;
		$nombre=$con->obtenerValor($conMateria);
		$cadena="sesion".$noSesion."_".$nombre;
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			
				for($y=0;$y<$tamanoRecursos;$y++) 
				{
					$idRecurso=$arregloRecursos[$y];
						
						$consulta="select idRecurso,idTema from 4045_materiaVsRecursos where idRecurso='".$idRecurso."' and idMateria=".$idMateria." and noSesion=".$noSesion." and fecha='".$fecha."' and idGrupo=".$idGrupo;
						$nomTema=$con->obtenerValor($consulta);
						if($nomTema=="")		
						{
							$query[$ct]="insert into 4045_materiaVsRecursos(fecha,idRecurso,idMateria,noSesion,idGrupo) values 
										('".$fecha."','".$idRecurso."','".$idMateria."','".$noSesion."','".$idGrupo."')";
							$ct++;
						}
						
						$conR="select idApartado from 4098_apartaRecursos where idRecursoApartado=".$idRecurso." and idUsrApartador=".$idUsuario." and estadoRecurso=0 and tipo=1 and evento='".$cadena."' and fecha='".$fecha."' and horaInicio='".$horaIni."' and horaFin='".$horaFin."'";
						$registro=$con->obtenerValor($conR);
						
						if($registro=="")		
						{
							$query[$ct]="insert into 4098_apartaRecursos(idRecursoApartado,idUsrApartador,estadoRecurso,tipo,evento,fecha,horaInicio,horaFin) values 
										('".$idRecurso."','".$idUsuario."','1','1','".$cadena."','".$fecha."','".$horaIni."','".$horaFin."')";
							$ct++;
						}
				}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
			{
				 echo "1|";
			}
			else
				echo "|";
		}
	}
	
	function borrarRecursoSesion ()
	{
	   global $con;
	   $noSesion=$_POST["noSesion"];
	   $idMateria=$_POST["idMateria"];
	   $fecha=$_POST["fecha"];
	   $idRecurso=$_POST["idRecurso"];
	   $horaIni=$_POST["horaIni"];
	   $horaFin=$_POST["horaFin"];
	   $idUsuario=$_SESSION["idUsr"];
	   
	   $conMateria="SELECT titulo FROM 4013_materia WHERE idMateria=".$idMateria ;
	   $nombre=$con->obtenerValor($conMateria);
	   $cadena="sesion".$noSesion."_".$nombre;
	   
	   $consulta="begin";
	   if($con->ejecutarConsulta($consulta))
	   {
			$ct=0;
			$query[$ct]="delete from 4045_materiaVsRecursos where idRecurso=".$idRecurso." and idMateria=".$idMateria." and noSesion=".$noSesion." and fecha='".$fecha ."'";
	   		$ct++;
			$query[$ct]="update 4098_apartaRecursos set estadoRecurso=0 where idRecursoApartado=".$idRecurso." and idUsrApartador=".$idUsuario." and tipo=1 and evento='".$cadena."' and fecha='".$fecha."' and horaInicio='".$horaIni."' and horaFin='".$horaFin."'";
			$ct++;
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo"|";
	   }
	}
	
	
	function guardarProfesorInvitado ()
	{
	   global $con;
	   $noSesion=$_POST["noSesion"];
	   $idMateria=$_POST["idMateria"];
	   $fecha=$_POST["fecha"];
	   $idUsuario=$_POST["idUsuario"];
	   $horaIni=$_POST["horaIni"];
	   $horaFin=$_POST["horaFin"];
	   $participacionInv=$_POST["participacionInv"];
	   $idGrupo=0;
	   if(isset($_POST["idGrupo"]))
	   		$idGrupo=$_POST["idGrupo"];
			
	   
	   $consulta="begin";
	   if($con->ejecutarConsulta($consulta))
	   {
			$ct=0;
			$conExiste="SELECT idProfesorInv FROM 4069_participantesInvitados WHERE idUsuario=".$idUsuario." AND idMateria=".$idMateria." AND noSesion=".$noSesion." AND idGrupo=".$idGrupo." AND fecha='".$fecha."' AND horaInicio='".$horaIni."' AND horaFin='".$horaFin."'" ;
			$existe=$con->obtenerValor($conExiste);
			if($existe=="")
			{
			$query[$ct]="insert into 4069_participantesInvitados(idUsuario,noSesion,idMateria,idGrupo,horaInicio,horaFin,fecha) values('".$idUsuario."','".$noSesion."','".$idMateria."','".$idGrupo."','".$horaIni."','".$horaFin."','".$fecha ."')";
	   		$ct++;
			}
			
			$conExiste2="SELECT idParticipante FROM 4047_participacionesMateria WHERE idUsuario=".$idUsuario." AND idMateria=".$idMateria." and idGrupo=".$idGrupo ;
			$existe2=$con->obtenerValor($conExiste2);
			if($existe2=="")
			{
			$query[$ct]="insert into 4047_participacionesMateria(idUsuario,idMateria,idGrupo,idParticipacion) values('".$idUsuario."','".$idMateria."','".$idGrupo."','".$participacionInv."')";
			$ct++;
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo"|";
	   }
	}
	
	
	function eliminarProfesorInvitado ()
	{
	   global $con;
	   $noSesion=$_POST["noSesion"];
	   $idMateria=$_POST["idMateria"];
	   $fecha=$_POST["fecha"];
	   $idUsuario=$_POST["idUsuario"];
	   $horaIni=$_POST["horaIni"];
	   $horaFin=$_POST["horaFin"];
	   $idGrupo=0;
	   if(isset($_POST["idGrupo"]))
	      $idGrupo=$_POST["idGrupo"];
	   
	   $consulta="begin";
	   if($con->ejecutarConsulta($consulta))
	   {
			
			$ct=0;
			
			//verificar si es el ultimo registro en la tabla 4069 y si es asi borrarla de la 4047
			$query[$ct]="delete from 4069_participantesInvitados where idUsuario=".$idUsuario." and noSesion=".$noSesion." and idMateria=".$idMateria." and idGrupo=".$idGrupo." AND horaInicio='".$horaIni."' and horaFin='".$horaFin."' and fecha='".$fecha ."'";
			$ct++;
			
			$conExiste2="SELECT idProfesorInv FROM 4069_participantesInvitados WHERE idUsuario=".$idUsuario." AND idMateria=".$idMateria." and idGrupo=".$idGrupo ;
			$res=$con->obtenerFilas($conExiste2);
			$filas=$con->filasAfectadas;
			if($filas==0)
			{
			$query[$ct]="delete from 4047_participacionesMateria where idUsuario=".$idUsuario." and idMateria=".$idMateria." and idGrupo=".$idGrupo;
			$ct++;
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo"|";
	   }
	}
	
	function eliminarTecnicaSesion()
	{
	   global $con;
	   $id=$_POST["id"];
	   $tabla=$_POST["tabla"];
	   $campo=$_POST["campo"];
	   
	   $consulta="delete from ".$tabla." where ".$campo."=".$id ;
	   if($con->ejecutarConsulta($consulta))
	   	  echo "1|";
	   else
	   	  echo "|";
	}
	
	function guardarBloque()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$noSesion=$_POST["noSesion"];
		$bloque=$_POST["bloque"];
		$idGrupo=0;
		if(isset($_POST["idGrupo"]))
		{
			$idGrupo=$_POST["idGrupo"];
			if($idGrupo=="")
			{
				$idGrupo=0;
			}
		}
		
		$consulta="update 4053_sesiones set bloque='".$bloque."' where idMateria=".$idMateria." and idGrupo=".$idGrupo." and noSesion=".$noSesion ;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function criteriosBloque()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$bloque=$_POST["bloque"];
		$idGrupo=0;
		if(isset($_POST["fecha"]))
		{	
			$fecha=$_POST["fecha"];
			$fecha=cambiaraFechaMysql($fecha);
		}
		else
		{
			$fecha=0;
		}
		
		if(isset($_POST["idGrupo"]))
		{
			$idGrupo=$_POST["idGrupo"];
			if($idGrupo=="")
			{
				$idGrupo=0;
			}
		}
		
		$consulta="SELECT e.idEvaluacion,e.titulo FROM 4010_evaluaciones e, 4152_ponderacionCriterios p WHERE e.idEvaluacion=p.idEvaluacion AND idTipoEvaluacion=2 AND idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND bloque=".$bloque ;
		$arreglo=$con->obtenerFilasArreglo($consulta);
		
		if($fecha==0)
		{
			$arregloS=array();
		}
		else
		{
			$conSesiones="SELECT DISTINCT(CONCAT(noSesion,'_',fecha)),CONCAT('sesion','',noSesion,'-',DATE_FORMAT(fecha,'%d/%m/%Y')) AS fecha  FROM 4053_sesiones WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND fecha>='".$fecha."'";
			$arregloS=$con->obtenerFilasArreglo($conSesiones);
		}
	  	echo "1|".uEJ($arreglo)."|".uEJ($arregloS);
	}
	
	function guardarTarea()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$bloque=$_POST["bloque"];
		$subirArchivo=$_POST["siNo"];
		$criterio=$_POST["criterioT"];
		$fecha=$_POST["fechaE"];
		$bandera=$_POST["bandera"];
		
		if($bandera==2)
		{
			$fecha=cambiaraFechaMysql($fecha);
		}
		else
		{
			$fecha=explode("_",$fecha);
			$fecha=$fecha[1];
		}
		
		$descripcion=$_POST["descripcion"];
		$noSesion=$_POST["noSesion"];
		$idGrupo=0;
		if(isset($_POST["idGrupo"]))
		{
			$idGrupo=$_POST["idGrupo"];
			if($idGrupo=="")
			{
				$idGrupo=0;
			}
		}
		
		$idTema=0;
		if(isset($_POST["idTema"]))
		{
			$idTema=$_POST["idTema"];
			if($idTema=="")
			{
				$idTema=0;
			}
		}
		
		$consulta="insert into 4166_tareasMateria(idMateria,idGrupo,idTema,noSesion,fechaEntrega,texto,subirArchivo,bloque,idEvaluacion) values
					('".$idMateria."','".$idGrupo."','".$idTema."','".$noSesion."','".$fecha."','".$descripcion."','".$subirArchivo."','".$bloque."','".$criterio."')";
		
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function llenarComboBloques()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$noSesion=$_POST["noSesion"];
		
		$arreglo="[]";
		$conEsquemaEvaluacion="SELECT esquemaEvaluacion,bloques FROM 4013_materia WHERE idMateria=".$idMateria;
		$esquema=$con->obtenerPrimeraFila($conEsquemaEvaluacion);
		if($esquema[0]==0)
		{
			if($esquema[1]==1000)
			{
				$profBloques="select noBloques from 4165_profesorBloques where idMateria=".$idMateria." and idGrupo=".$idGrupo ;
				$maximoBloques=$con->obtenerValor($profBloques);
				
				$bloqueSesion="SELECT if(MAX(bloque) is null,1,max(bloque)) FROM 4053_sesiones WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." and noSesion<>".$noSesion ;
				$bloqueMayor=$con->obtenerValor($bloqueSesion);
				
				$cadenaObjetos="";
				for($x=$bloqueMayor;$x<= $maximoBloques;$x++)
				{
					$obj="[".$x.",".$x."]"	;
					if($cadenaObjetos=="")
						$cadenaObjetos=$obj;
					else
						$cadenaObjetos.=$obj;
				}
			$arreglo="[".$cadenaObjetos."]"	;
			echo "1|".$arreglo;
			}
			else
			{
				$bloqueSesion="SELECT if(MAX(bloque) is null,1,max(bloque)) FROM 4053_sesiones WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." and noSesion<>".$noSesion ;
				$bloqueMayor=$con->obtenerValor($bloqueSesion);
				
				$maximoBloques=$esquema[1];
				
				$cadenaObjetos="";
				for($x=$bloqueMayor;$x<= $maximoBloques;$x++)
				{
					$obj="[".$x.",".$x."]"	;
					if($cadenaObjetos=="")
						$cadenaObjetos=$obj;
					else
						$cadenaObjetos.=",".$obj;
				}
				$arreglo="[".$cadenaObjetos."]"	;
				echo "1|".$arreglo;
			}
		}
		else
		{
			$consTemas="SELECT idTema,nombreTema FROM 4039_temas WHERE idPadre=-".$idMateria." AND  (idProfesor=0 OR idProfesor=".$_SESSION["idUsr"].")" ;
			$arreglo=$con->obtenerFilasArreglo($consTemas);
			echo "1|".uEJ($arreglo);
		}
	}
	function actualizarSesion()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$noSesion=$_POST["noSesion"];
		$tiposesion=$_POST["tipoSesion"];
		$bloque=$_POST["bloque"];
		
		$consulta="update 4053_sesiones set tipoSesion=".$tiposesion.",bloque=".$bloque." where idMateria=".$idMateria." and idGrupo=".$idGrupo." and noSesion=".$noSesion;
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|";
		}
	}
	
	function obtenerAreasPracticas()
	{
		global $con;
	    $consulta="select idRecurso,titulo from 4009_recursos where idTipoRecurso=6";
		$arreglo=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arreglo);
	}
	
	function  cancelarSesionAreaPractica()
	{
		global $con;
		$noSesion=$_POST["noSesion"];
		$fecha=$_POST["fecha"];
		$horaIni=$_POST["horaIni"];
		$horaFin=$_POST["horaFin"];
		$idMateria=$_POST["idMateria"];
		$idUsuario=$_SESSION["idUsr"];
		$idMapaCurricular=$_POST["idMapaCurricular"];
		$idGrupo=0;
		if(isset($_POST["idGrupo"]))
		{
			$idGrupo=$_POST["idGrupo"];
			if($idGrupo=="")
			{
				$idGrupo=0;
			}
		}
		
		$conPrograma="select idPrograma,ciclo from 4029_mapaCurricular where idMapaCurricular=".$idMapaCurricular ;
		$datos=$con->obtenerPrimeraFila($conPrograma);
		
		$conRecurso="SELECT idArea FROM 4142_areasPracticasMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND noSesion=".$noSesion;
		$idRecursoApartado=$con->obtenerValor($conRecurso);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			$query[$ct]="update 4053_sesiones set estado='CANCELLED' where noSesion=".$noSesion." and fecha='".$fecha."' and  idMateria=".$idMateria." and idGrupo=".$idGrupo;
			$ct++;
			$query[$ct]="UPDATE 4098_apartaRecursos SET estadoRecurso='0' WHERE fecha='".$fecha."' and horaInicio='".$horaIni."' and horaFin='".$horaFin."' and idRecursoApartado='".$idRecursoApartado."'";
			
			$ct++;
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|".$datos[0]."|".$datos[1];
			else
				echo"21";
		}
	}
	
	function comprobarPlanecionMateria()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$fechaIni=$_POST["fechaIni"];
		$fechaIni=cambiaraFechaMysql($fechaIni);
		$fechaFin=$_POST["fechaFin"];
		$fechaFin=cambiaraFechaMysql($fechaFin);
		
		$consulta="SELECT idPlaneacionMateria,noBloque FROM 4171_planeacionMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND fechaInicio>='".$fechaIni."' AND fechaFin<='".$fechaFin."'" ;
		$idPlaneacion=$con->obtenerPrimeraFila($consulta);
		if(!$idPlaneacion)
			echo "2|";
		else
			echo "1|".$idPlaneacion[1];
	}
	
	function guardarCatalogoReporte()
	{
		global $con;
		$tipoPlaneacion=0;
		if(isset($_POST["tipoPlaneacion"]))
		{
			$tipoPlaneacion=$_POST["tipoPlaneacion"];
		}
		//$tipoPlaneacion=$_POST["tipoPlaneacion"];
		$idCatalogo=$_POST["catalogo"];
	    $etiqueta=$_POST["etiqueta"];
		if($tipoPlaneacion==0)
		{
			$idPerfilPlaneacionVSMapa=$_POST["idPerfilPlaneacionVSMapa"];
			$conExiste="SELECT idElementoPlaneacion FROM 4172_elementosPlaneacion WHERE idPerfilPlaneacionVSMapa=".$idPerfilPlaneacionVSMapa."  AND tipo='".$idCatalogo."'";
			$existe=$con->obtenerValor($conExiste);
			$consulta="select max(orden) from 4172_elementosPlaneacion where idPerfilPlaneacionVSMapa=".$idPerfilPlaneacionVSMapa;
			$nElemento=$con->obtenerValor($consulta);
			$nElemento++;
			if($existe=="")
			{
				
				$consulta="INSERT INTO 4172_elementosPlaneacion (idPerfilPlaneacionVSMapa,tipo,etiqueta,visible,orden) VALUES('".$idPerfilPlaneacionVSMapa."','".$idCatalogo."','".$etiqueta."','1',".$nElemento.")";
				if($con->ejecutarConsulta($consulta))
					echo "1|".$nElemento;
				else
					echo "2|";
			}
			else
			{
				$consulta="UPDATE 4172_elementosPlaneacion SET visible=1,orden=".$nElemento." WHERE idPerfilPlaneacionVSMapa=".$idPerfilPlaneacionVSMapa."  AND tipo=".$idCatalogo ;
				if($con->ejecutarConsulta($consulta))
					echo "1|".$nElemento;
				else
					echo "2|";
			}
		}
		else
		{
			$idPerfilPlaneacionVSMapa=$_POST["idPerfilPlaneacionVSMapa"];
			//$idMateria=$_POST["idMateria"];
			//$idGrupo=$_POST["idGrupo"];
			$conExiste="SELECT idElementoPlaneacion FROM 4172_elementosPlaneacion WHERE idPerfilPlaneacionVSMapa=".$idPerfilPlaneacionVSMapa."  AND tipo='".$idCatalogo."' and tipoPlaneacion=1" ;
			$existe=$con->obtenerValor($conExiste);
			$consulta="select max(orden) from 4172_elementosPlaneacion where idPerfilPlaneacionVSMapa=".$idPerfilPlaneacionVSMapa." and tipoPlaneacion=1";
			$nElemento=$con->obtenerValor($consulta);
			$nElemento++;
			if($existe=="")
			{
				
				$consulta="INSERT INTO 4172_elementosPlaneacion (idPerfilPlaneacionVSMapa,tipo,etiqueta,visible,orden,tipoPlaneacion) VALUES('".$idPerfilPlaneacionVSMapa."','".$idCatalogo."','".$etiqueta."','1',".$nElemento.",'1')";
				if($con->ejecutarConsulta($consulta))
					echo "1|".$nElemento;
				else
					echo "2|";
			}
			else
			{
				$consulta="UPDATE 4172_elementosPlaneacion SET visible=1,orden=".$nElemento." WHERE idPerfilPlaneacionVSMapa=".$idPerfilPlaneacionVSMapa."  AND tipo=".$idCatalogo."  and tipoPlaneacion=1"  ;
				if($con->ejecutarConsulta($consulta))
					echo "1|".$nElemento;
				else
					echo "2|";
			}
		
		}
	}
	
	function eliminarCatalogoReporte()
	{
		global $con;
		$tipoPlaneacion=0;
		if(isset($_POST["tipoPlaneacion"]))
		{
			$tipoPlaneacion=$_POST["tipoPlaneacion"];
		}
		if($tipoPlaneacion==0)
		{
			$idPerfilPlaneacionVSMapa=$_POST["idPerfilPlaneacionVSMapa"];
			$idCatalogo=$_POST["catalogo"];
			
			$consulta="select orden,idElementoPlaneacion from 4172_elementosPlaneacion where idPerfilPlaneacionVSMapa=".$idPerfilPlaneacionVSMapa." and tipo=".$idCatalogo;
			$fila=$con->obtenerPrimeraFila($consulta);
			$orden=$fila[0];
			$idElemento=$fila[1];
			$x=0;
			$query[$x]="begin";
			$x++;
			$query[$x]="update 4172_elementosPlaneacion set orden=orden-1 WHERE orden>".$orden." and idPerfilPlaneacionVSMapa=".$idPerfilPlaneacionVSMapa;
			$x++;
			$query[$x]="UPDATE 4172_elementosPlaneacion SET visible=0,orden=null WHERE idElementoPlaneacion=".$idElemento;
			$x++;
			$query[$x]="commit";
			$x++;
			if($con->ejecutarBloque($query))
				echo "1|";
			else
			echo "2|";
		}
		else
		{
			$idCatalogo=$_POST["catalogo"];
			//$idMateria=$_POST["idMateria"];
			//$idGrupo=$_POST["idGrupo"];
			$idPerfilPlaneacionVSMapa=$_POST["idPerfilPlaneacionVSMapa"];
			
			$consulta="select orden,idElementoPlaneacion from 4172_elementosPlaneacion where idPerfilPlaneacionVSMapa=".$idPerfilPlaneacionVSMapa." and tipo=".$idCatalogo." and tipoPlaneacion=1";
			$fila=$con->obtenerPrimeraFila($consulta);
			$orden=$fila[0];
			$idElemento=$fila[1];
			$x=0;
			$query[$x]="begin";
			$x++;
			$query[$x]="update 4172_elementosPlaneacion set orden=orden-1 WHERE orden>".$orden." and idPerfilPlaneacionVSMapa=".$idPerfilPlaneacionVSMapa." and tipoPlaneacion=1";
			$x++;
			$query[$x]="UPDATE 4172_elementosPlaneacion SET visible=0,orden=null WHERE idElementoPlaneacion=".$idElemento;
			$x++;
			$query[$x]="commit";
			$x++;
			if($con->ejecutarBloque($query))
				echo "1|";
			else
			echo "2|";
		}
	
	}
	
	function obtenerElementosCatalogo()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$tCatalogo=$_POST["catalogo"];
		$idMapaCurricular=$_POST["idMapaCurricular"];
		$idPadre=$_POST["idPadre"];
		switch($tCatalogo)
		{
			case 0: //criterios de evaluacion
				$consulta="select * from ((select idEvaluacion from 4156_criteriosEvaluacionExtra where idPadre=".$idPadre." and (idGrupo=".$idGrupo." or idGrupo=-1) and idMateria=".$idMateria." and tipoCriterio=0) 
							union
							(select idEvaluacion from 4044_materiaVsEvaluaciones where idMateria=".$idMateria.")) as tmp
							";
				$listado=$con->obtenerListaValores($consulta);
				if($listado=="")
					$listado="-1";
				$consulta="select idEvaluacion,titulo from 4010_evaluaciones where idEvaluacion not in (".$listado.") and (idMapaCurricular=".$idMapaCurricular." or idMapaCurricular=-1) order by titulo";
			break;
			case 2: //Actitudes
				$consulta="select * from ((select idEvaluacion from 4156_criteriosEvaluacionExtra where idPadre=".$idPadre." and (idGrupo=".$idGrupo." or idGrupo=-1) and idMateria=".$idMateria." and tipoCriterio=2) 
							union
							(select idActitud from 4043_materiaVsActitudes where idMateria=".$idMateria." and criterioEval=1)) as tmp
							";
				$listado=$con->obtenerListaValores($consulta);
				if($listado=="")
					$listado="-1";
				$consulta="select idActitud,titulo from 4008_actitudes where idActitud not in (".$listado.") and (idMapaCurricular=".$idMapaCurricular." or idMapaCurricular=-1) order by titulo";
			break;
			case 3: //Competencias
				$consulta="select * from ((select idEvaluacion from 4156_criteriosEvaluacionExtra where idPadre=".$idPadre." and (idGrupo=".$idGrupo." or idGrupo=-1) and idMateria=".$idMateria." and tipoCriterio=3) 
							union
							(select idCompetencia from 4041_materiaVsCompetencias where idMateria=".$idMateria." and criterioEval=1)) as tmp
							";
				$listado=$con->obtenerListaValores($consulta);
				if($listado=="")
					$listado="-1";
				$consulta="select idCompetencia,titulo from 4007_competencias where idCompetencia not in (".$listado.") and (idMapaCurricular=".$idMapaCurricular." or idMapaCurricular=-1) order by titulo";
			break;
			case 4://Hablidades
				$consulta="select * from ((select idEvaluacion from 4156_criteriosEvaluacionExtra where idPadre=".$idPadre." and (idGrupo=".$idGrupo." or idGrupo=-1) and idMateria=".$idMateria." and tipoCriterio=4) 
							union
							(select idHabilidad from 4042_materiaVsHabilidades where idMateria=".$idMateria." and criterioEval=1)) as tmp
							";
				$listado=$con->obtenerListaValores($consulta);
				if($listado=="")
					$listado="-1";
				$consulta="select idHabilidad,titulo from 4006_habilidades where idHabilidad not in (".$listado.") and (idMapaCurricular=".$idMapaCurricular." or idMapaCurricular=-1) order by titulo";
			break;
			case 5://Tecnicas colaborativas
				$consulta="select * from ((select idEvaluacion from 4156_criteriosEvaluacionExtra where idPadre=".$idPadre." and (idGrupo=".$idGrupo." or idGrupo=-1) and idMateria=".$idMateria." and tipoCriterio=5) 
							union
							(select idTecnicaC from 4046_materiaVsTecnicas where idMateria=".$idMateria." and criterioEval=1)) as tmp
							";
				$listado=$con->obtenerListaValores($consulta);
				if($listado=="")
					$listado="-1";
				$consulta="select idTecnicaC,titulo from 4011_tecnicasColaborativas where idTecnicaC not in (".$listado.") and (idMapaCurricular=".$idMapaCurricular." or idMapaCurricular=-1) order by titulo";
			break;
			case 6:
				$consulta="select * from ((select idEvaluacion from 4156_criteriosEvaluacionExtra where idPadre=".$idPadre." and (idGrupo=".$idGrupo." or idGrupo=-1) 
											and idMateria=".$idMateria." and tipoCriterio=6)) as tmp
							";
				$listado=$con->obtenerListaValores($consulta);
				if($listado=="")
					$listado="-1";
				$consulta="select idProducto,titulo from 4012_productos where idProducto not in (".$listado.") and (idMapaCurricular=".$idMapaCurricular." or idMapaCurricular=-1) order by titulo";
			
			
			break;
		}
		$arrDatos=uEJ($con->obtenerFilasArreglo($consulta));
		echo "1|".$arrDatos;
	}
	
	function guardarSemanasBloque ()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$semana1=$_POST["semana1"];
		$semana2=$_POST["semana2"];
		
		$datosSemana1=explode("_",$semana1);
		$datosSemana2=explode("_",$semana2);
		
		$bloque=$datosSemana1[3];
		if($datosSemana1[5]=="semanaIni")
		{
			$primSemana=$datosSemana1[4];
			$fechaIni=$datosSemana1[1];
			$fechaFinSemanaIni=$datosSemana1[2];
			$segSemana=$datosSemana2[4];
			$fechaFin=$datosSemana2[2];
			$fechaIniSemanaFin=$datosSemana2[1];
		}
		else
		{
			$primSemana=$datosSemana2[4];
			$fechaIni=$datosSemana2[1];
			$fechaFinSemanaIni=$datosSemana2[2];
			$segSemana=$datosSemana1[4];
			$fechaFin=$datosSemana1[2];
			$fechaIniSemanaFin=$datosSemana1[1];
		}
		
		$consulta="begin";
		$ct=0;
		if($con->ejecutarConsulta($consulta))
		{
			$conExiste="SELECT idBloqueMateria FROM 4179_bloqueSemanas WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND bloque=".$bloque;
			$existe=$con->obtenerValor($conExiste);
			
			if($existe=="")
			{
				$query[$ct]="INSERT INTO 4179_bloqueSemanas(idMateria,idGrupo,bloque,noSemanaIni,noSemanaFin,fechaInicio,fechaFin,fechaFinSemanaIni,fechaIniSemanaFin)
						 VALUES('".$idMateria."','".$idGrupo."','".$bloque."','".$primSemana."','".$segSemana."','".$fechaIni."','".$fechaFin."','".$fechaFinSemanaIni."','".$fechaIniSemanaFin."')";
						 
				$ct++;
			}
			else
			{
				//$conDatos="SELECT noSemanaIni,noSemanaFin,fechaInicio,fechaFinSemanaIni,fechaIniSemanaFin,fechaFin FROM 4179_bloqueSemanas WHERE idBloqueMateria=".$existe;
				//$filaD=$con->obtenerPrimeraFila($conDatos);
				
				//$difSemanas=$segSemana-$primSemana;
				//$sumaSemanas=
				
				$query[$ct]="UPDATE 4179_bloqueSemanas SET noSemanaIni='".$primSemana."',noSemanaFin='".$segSemana."',fechaInicio='".$fechaIni."', fechaFin='".$fechaFin."',fechaFinSemanaIni='".$fechaFinSemanaIni."',fechaIniSemanaFin='".$fechaIniSemanaFin."'
							WHERE idBloqueMateria=".$existe;
				$ct++;
				
			}
			
			//$query[$ct]="UPDATE 4053_sesiones SET bloque='".$bloque."' WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND fecha>='".$fechaIni."' AND fecha<='".$fechaFin."'";
			//$ct++;
			
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
	
	
	function comprobarSesionesBloque()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$bloque=$_POST["bloque"];
		
		$conSesiones="SELECT DISTINCT(noSesion),tipoSesion FROM 4053_sesiones WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND bloque=".$bloque;
		$resSesiones=$con->obtenerFilas($conSesiones);
		
		while($fila=mysql_fetch_row($resSesiones))
		{
			if($fila[1]!=1000)
			{
				echo "2|";
				return;
			}
		}
		
		echo "1|";
	}
	
	function eliminarElementoPlaneacion()
	{
		global $con;
		$id=$_POST["id"];
		$bandera=$_POST["bandera"];
		
		if($bandera==1)
		{
			$consulta="UPDATE 4172_elementosPlaneacion SET visible='0' WHERE idElementoPlaneacion=".$id;
		}
		else
		{
			$consulta="UPDATE 4172_elementosPlaneacion SET visible='1' WHERE idElementoPlaneacion=".$id;
		}
		
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			"|";
	}
	
	function obtenerDatosGrupo()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		
		$conGrupo="SELECT nombreGrupo,cupoMinimo,cupoMaximo FROM 4048_grupos WHERE idGrupo=".$idGrupo;
		$fila=$con->obtenerPrimeraFila($conGrupo);
		
		echo "1|".$fila[0]."|".$fila[1]."|".$fila[2];
	}
	
	function modificarGrupoMateriaComp()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$idMateria=$_POST["idMateria"];
		$nGrupo=$_POST["nGrupo"];
		$vMin=$_POST["vMin"];
		$vMax=$_POST["vMax"];
		$consulta="select idGrupo from 4048_grupos where nombreGrupo='".cv($nGrupo)."' and idMateria=".$idMateria." and idGrupo<>".$idGrupo;
		$idGrupoC=$con->obtenerValor($consulta);
		if($idGrupoC=="")
		{
			$consulta="update 4048_grupos set nombreGrupo='".$nGrupo."',cupoMinimo='".$vMin."',cupoMaximo='".$vMax."' where idGrupo=".$idGrupo;
			if($con->ejecutarConsulta($consulta))
				echo "1|";
			else
				echo "|";
		}
		else
		{
			echo "2|El nombre del grupo ya se encuentra registrado";
		}
	}
	
	function vincularGrupoMaterial()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idMaterial=$_POST["idMaterial"];
		$cadenaGrupos=$_POST["cadena"];
		$arreglo=explode(',',$cadenaGrupos);
		$tamano=sizeof($arreglo);
		
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$y=0;
			for($x=0;$x<$tamano;$x++)
			{
				$idGrupo=$arreglo[$x];
				$query[$y]="INSERT INTO 4051_materialesVSTema(idMateria,idMAterial,idGrupo) VALUES('".$idMateria."','".$idMaterial."','".$idGrupo."')";
				$y++;
			}
			$query[$y]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "2|";
		}
	}
	
	function quitarVinculoGrupoMaterial()
	{
		global $con;
		
		$idMaterial=base64_decode($_POST["idMaterial"]);
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		
		$consulta="DELETE 	FROM 4051_materialesVSTema WHERE idMaterial=".$idMaterial." AND idMateria=".$idMateria." AND idGrupo=".$idGrupo;
		
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "2|";
	}
	
	function borrarElementoReporte()
	{
		
		global $con;
		$bandera=0;
		if(isset($_POST["bandera"]))
		{
			$bandera=$_POST["bandera"];
		}
		$id=$_POST["idElemento"];
		$consulta="select orden,idPerfilPlaneacionVSMapa from 4172_elementosPlaneacion where idElementoPlaneacion=".$id;
		$fila=$con->obtenerPrimeraFila($consulta);
		$orden=$fila[0];
		if($bandera==0)
		{
			$idPerfil=$fila[1];
		}
		else
		{
			$idPerfil=$fila[1];
			//$idMateria=$_POST["idMateria"];
			//$idGrupo=$_POST["idGrupo"];
		}
		$x=0;
		$query[$x]="begin";
		$x++;
		if($bandera==0)
		{
			$query[$x]="update 4172_elementosPlaneacion set orden=orden-1 WHERE orden>".$orden." and idPerfilPlaneacionVSMapa=".$idPerfil;
		}
		else
		{
			$query[$x]="update 4172_elementosPlaneacion set orden=orden-1 WHERE orden>".$orden." and idPerfilPlaneacionVSMapa=".$idPerfil." and tipoPlaneacion=1";
		}
		$x++;
		$query[$x]="DELETE FROM 4172_elementosPlaneacion WHERE idElementoPlaneacion=".$id;
		$x++;
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
			echo "1|";
		else
			echo "2|";
	}
	
	function obtenerProgramasProfesor()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$idProfesor=$_POST["idProfesor"];
		
		$consulta="select distinct(p.idPrograma),nombrePrograma from  4047_participacionesMateria pg,
					4013_materia m,4004_programa p where m.idMateria=pg.idMateria and 
					p.idPrograma=m.idPrograma and pg.idUsuario=".$idProfesor." and m.ciclo=".$idCiclo;
					
		$res=$con->obtenerFilasArreglo($consulta);
		
		echo "1|".uEJ($res);
	}
	
	function obtenerGradosProfesor()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$idPrograma=$_POST["idPrograma"];
		$idProfesor=$_POST["idProfesor"];
		
		$idMapa=obtenerMapaCurricular($idPrograma,$idCiclo);
		$consulta="SELECT idParticipacionPrincipal,idParticipacionCoordinador FROM 4029_mapaCurricular WHERE idMapaCurricular=".$idMapa;
		$filaParticipaciones=$con->obtenerPrimeraFila($consulta);
		$idParticipacionP=$filaParticipaciones[0];
		
		if($idParticipacionP=="")
			$idParticipacionP="-1";
		
		$consulta="select pg.idGrupo,m.idMateria,m.titulo,pg.idParticipacion,m.cve_materia,m.descripcion from  4047_participacionesMateria pg,4013_materia m 
					where m.idMateria=pg.idMateria and pg.idUsuario=".$idProfesor." and m.ciclo=".$idCiclo." and m.idPrograma=".$idPrograma." 
					and idParticipacion=".$idParticipacionP." order by m.titulo";
		$resMaterias=$con->obtenerFilas($consulta);			
		$arrMaterias="";
		while($fila=mysql_fetch_row($resMaterias))
		{
			$comp="";
			
			$consulta="SELECT idTipoComponente FROM 4031_elementosMapa e,4029_mapaCurricular m WHERE e.idMapaCurricular=m.idMapaCurricular
						AND m.idPrograma=".$idPrograma." AND m.ciclo=".$idCiclo." and e.idMateria=".$fila[1];
			$idTipoMateria=$con->obtenerValor($consulta);
			if(($idTipoMateria!="")&&($idTipoMateria!=1))
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
				$nodoM="['".$fila[0]."_".$fila[1]."','".$fila[2]." ".$comp."']";
							
				if($arrMaterias=="")
					$arrMaterias=$nodoM;
				else
					$arrMaterias.=",".$nodoM;
			}			
		}
	 echo "1|[".$arrMaterias."]";
	}
	
	function vincularMatD()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$cadena=$_POST["cadenaM"];
		
		$arreglo=explode('_',$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
		  $y=0;
		  for($x=0;$x<$tamano;$x++)
		  {
				$idMaterial=$arreglo[$x];
				$conExiste="SELECT idMaterialVSTema FROM 4051_materialesVSTema WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND idMaterial=".$idMaterial;  
		  		$existe=$con->obtenerValor($conExiste);
				if($existe=="")
				{
					$query[$y]="INSERT INTO 4051_materialesVSTema(idMateria,idGrupo,idMaterial) VALUES('".$idMateria."','".$idGrupo."','".$idMaterial."')";
					$y++;
				}
		  }
		  $query[$y]="commit";
		  if($con->ejecutarBloque($query))
		  	echo "1|";
		  else
		  	echo "|";
		}
	}
	
	function obtenerMaximoOrdenPlaneacion()
	{
		global $con;
		$bandera=0;
		if(isset($_POST["bandera"]))
		{
			$bandera=$_POST["bandera"];
		}
		
		if($bandera==0)
		{
			$idPerfilPlaneacion=$_POST["idPerfil"];
			$consulta="select max(orden) from 4172_elementosPlaneacion where idPerfilPlaneacionVSMapa=".$idPerfilPlaneacion;
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
		else
		{
			$idPerfilPlaneacion=$_POST["idPerfil"];
			//$idMateria=$_POST["idMateria"];
			//$idGrupo=$_POST["idGrupo"];
			$consulta="select max(orden) from 4172_elementosPlaneacion where idPerfilPlaneacionVSMapa=".$idPerfilPlaneacion." and tipoPlaneacion=1 " ;
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
	}
	
	function actualizarOrden()
	{
		global $con;
		$bandera=0;
		if(isset($_POST["bandera"]))
		{
			$bandera=$_POST["bandera"];
		}
		$idElemento=bD($_POST["idElemento"]);	
		$orden=($_POST["orden"]);
		if($bandera==0)
		{
			$consulta="select orden,idPerfilPlaneacionVSMapa from 4172_elementosPlaneacion where idElementoPlaneacion=".$idElemento;
			$filaE=$con->obtenerPrimeraFila($consulta);
			$vOrden=$filaE[0];
			$idPerfil=$filaE[1];
			$x=0;
			$query[$x]="begin";
			$x++;
			if($vOrden>$orden)
			{
				$query[$x]="update 4172_elementosPlaneacion set orden=orden+1 where idPerfilPlaneacionVSMapa=".$idPerfil." and orden>=".$orden." and orden<".$vOrden;
				$x++;
			}
			else
			{
				$query[$x]="update 4172_elementosPlaneacion set orden=orden-1 where idPerfilPlaneacionVSMapa=".$idPerfil." and orden>".$vOrden." and orden<=".$orden;
				$x++;
			}
			$query[$x]="update 4172_elementosPlaneacion set orden=".$orden." where idElementoPlaneacion=".$idElemento;
			$x++;
			$query[$x]="commit";
			$x++;
			if($con->ejecutarBloque($query))
				echo "1|";
		}
		else
		{
			//$idMateria=$_POST["idMateria"];
			//$idGrupo=$_POST["idGrupo"];
			$consulta="select orden,idPerfilPlaneacionVSMapa from 4172_elementosPlaneacion where idElementoPlaneacion=".$idElemento;
			$filaE=$con->obtenerPrimeraFila($consulta);
			$vOrden=$filaE[0];
			$idPerfil=$filaE[1];
			$x=0;
			$query[$x]="begin";
			$x++;
			if($vOrden>$orden)
			{
				$query[$x]="update 4172_elementosPlaneacion set orden=orden+1 where idPerfilPlaneacionVSMapa=".$idPerfil." and orden>=".$orden." and orden<".$vOrden;
				$x++;
			}
			else
			{
				$query[$x]="update 4172_elementosPlaneacion set orden=orden-1 where idPerfilPlaneacionVSMapa=".$idPerfil." and orden>".$vOrden." and orden<=".$orden;
				$x++;
			}
			$query[$x]="update 4172_elementosPlaneacion set orden=".$orden." where idElementoPlaneacion=".$idElemento;
			$x++;
			$query[$x]="commit";
			$x++;
			if($con->ejecutarBloque($query))
				echo "1|";
		}
	}
	
	function obtenerAlumnosMateria()
	{
		global $con;
		$tBusqueda=$_POST["tBusqueda"];
		$idMateria=$_POST["idMateria"];
		$idMapaCurricular=$_POST["idMapaCurricular"];
		$listUsr=obtenerCandidatosInscribir($idMateria,$idMapaCurricular);
		if($listUsr=="")
			$listUsr="-1";
		$consulta="select ciclo,idPrograma from 4029_mapaCurricular where idMapaCurricular=".$idMapaCurricular;
		$filaMapa=$con->obtenerPrimeraFila($consulta);
		$idPrograma=$filaMapa[1];
		$ciclo=$filaMapa[0];
		
		$consulta="select idUsuario from 4120_alumnosVSElementosMapa a 
						where idPrograma=".$idPrograma." and a.idMateria=".$idMateria;

		$listUsrInsc=$con->obtenerListaValores($consulta);
		if($listUsrInsc=="")
			$listUsrInsc="-1";
		if($tBusqueda=="1") // Inscritos
			$consulta="select i.idUsuario,i.idUsuario,concat(Paterno,' ',Materno,' ',Nom) as nombre,(if(a.idGrupo is null,'Es espera de asignaci&oacute;n',
						(select nombreGrupo from 4048_grupos where idGrupo=a.idGrupo))) as grupo from 802_identifica i,4120_alumnosVSElementosMapa a 
						where a.idUsuario=i.idUsuario and idMateria=".$idMateria." and i.idUsuario in (".$listUsrInsc.") order by Paterno,Materno,Nom";
		else //candidatis
			$consulta="select i.idUsuario,i.idUsuario,concat(Paterno,' ',Materno,' ',Nom) as nombre,(select leyenda from 4014_grados where idGrado=a.idGrado) as  grado,
						(select nombreGrupo from 4048_grupos where idGrupo=a.idGrupo) as grupo from 802_identifica i,
						4118_alumnos a where a.idUsuario=i.idUsuario and a.ciclo=".$ciclo." and i.idUsuario in (".$listUsr.") 
						and i.idUsuario not in (".$listUsrInsc.") order by Paterno,Materno,Nom";
		echo "1|".uEJ($con->obtenerFilasArreglo($consulta));		
	}
	
	function inscribirAlumnoMateria()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idAlumnos=$_POST["idAlumnos"];
		$idMapaCurricular=$_POST["idMapaCurricular"];
		$consulta="select idElementoMapa from 4031_elementosMapa where idMateria=".$idMateria." and idMapaCurricular=".$idMapaCurricular;
		$iElemento=$con->obtenerValor($consulta);
		$consulta="select ciclo,idPrograma from 4029_mapaCurricular where idMapaCurricular=".$idMapaCurricular;
		$filaMapa=$con->obtenerPrimeraFila($consulta);
		$arrAlumnos=explode(",",$idAlumnos);
		$x=0;
		$query[$x]="begin";
		$x++;
		$arrAlumnos=explode(",",$idAlumnos);
		$arrAlumnosNoPermitidos="";
		foreach($arrAlumnos as $iAlumno)
		{
			if($iElemento!="")
			{
			
				
				$resComp=comprobarReglasMateria($iAlumno,$idMateria,$iElemento);
				$datosResp=explode("|",$resComp);
				if($datosResp[0]=="1")
				{
				
					$query[$x]="insert into 4120_alumnosVSElementosMapa(idUsuario,situacion,idGrupo,idMateria,idPrograma) values
								(".$iAlumno.",1,NULL,".$idMateria.",".$filaMapa[1].")";
					$x++;
				}
				else
				{
					$obj="['".$alumno."','".$datosResp[1]."']";
					if($arrAlumnosNoPermitidos=="")
						$arrAlumnosNoPermitidos=$obj;
					else
						$arrAlumnosNoPermitidos.=",".$obj;
				}
			}
			else
			{
				$query[$x]="insert into 4120_alumnosVSElementosMapa(idUsuario,situacion,idGrupo,idMateria,idPrograma) values
								(".$iAlumno.",1,NULL,".$idMateria.",".$filaMapa[1].")";
				$x++;
			}
		}
		inscribirMateriasObligatoriasAlumnoSinGrupo($arrAlumnos,$idMateria,$query,$x,1,$filaMapa[1]);
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
			echo "1|[".uEJ($arrAlumnosNoPermitidos)."]";
		else
			echo "|";
	}
	
	function inscribirMateriasObligatoriasAlumnoSinGrupo($arrAlumnos,$idPadre,&$consulta,&$x,$idGrupo,$idPrograma)
	{
		global $con;
		$query="select em.idMateria,m.compartida from 4031_elementosMapa em,4013_materia m where m.idmateria=em.idMateria and em.idPadre=".$idPadre." and em.idTipoMateria=1" ;
		$resMat=$con->obtenerFilas($query);
		$nAlumnos=sizeof($arrAlumnos);
		while($filaMat=mysql_fetch_row($resMat))
		{
				for($y=0;$y<$nAlumnos;$y++)
				{
					if($idGrupo==1)
						$consulta[$x]="insert into 4120_alumnosVSElementosMapa(idUsuario,situacion,idGrupo,idMateria,idPrograma) values(".$arrAlumnos[$y].",1,NULL,".$filaMat[0].",".$idPrograma.")";
					else
						$consulta[$x]="delete from 4120_alumnosVSElementosMapa where idUsuario=".$arrAlumnos[$y]." and idMateria=".$filaMat[0];
					
					
					$x++;
				}
				inscribirMateriasObligatoriasAlumnoSinGrupo($arrAlumnos,$filaMat[0],$consulta,$x,$idGrupo,$idPrograma);
		}
	}

	function removerAlumnoMateria()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idAlumnos=$_POST["idAlumnos"];
		$arrAlumnos=explode(",",$idAlumnos);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 4120_alumnosVSElementosMapa where idMateria=".$idMateria." and idUsuario in (".$idAlumnos.")";
		$x++;
		
		inscribirMateriasObligatoriasAlumnoSinGrupo($arrAlumnos,$idMateria,$consulta,$x,-1,0);
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function inscribirAlumnoGrupo()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idAlumnos=$_POST["idAlumnos"];
		$idGrupo=$_POST["idGrupo"];
		$arrAlumnos=explode(",",$idAlumnos);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($idGrupo=="_10")
			$idGrupo="NULL";
		$arrAlumnosNoPermitidos="";
		foreach($arrAlumnos as $alumno)
		{
			$resComp=comprobarHorarioAlumno($alumno,$idMateria,$idGrupo);
			$datosResp=explode("|",$resComp);
			if($datosResp[0]=="1")
			{
				$consulta[$x]="update 4120_alumnosVSElementosMapa set idGrupo=".$idGrupo." where idMateria=".$idMateria." and idUsuario=".$alumno;
				$x++;
			}
			else
			{
				$obj="['".$alumno."','".$datosResp[1]."']";
				if($arrAlumnosNoPermitidos=="")
					$arrAlumnosNoPermitidos=$obj;
				else
					$arrAlumnosNoPermitidos.=",".$obj;
			}
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|[".uEJ($arrAlumnosNoPermitidos)."]";
		else
			echo "|";
	}
	
	function obtenerListadoAlumnosMateriaGrupo()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$aux="";
		if($idGrupo=="_10")
			$aux=" is null";
		else
			$aux="=".$idGrupo;
		$consulta="select a.idUsuario,a.idUsuario,concat(Paterno,' ',Materno,' ',Nom) as nombre,
				(select nombrePrograma from 4004_programa where idPrograma=a.idPrograma) as programa from 4120_alumnosVSElementosMapa a,802_identifica i 
				where i.idUsuario=a.idUsuario and a.idMateria=".$idMateria." and a.idGrupo".$aux. " order by Paterno,Materno,Nom";
		$arrAlumnos=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrAlumnos);
	}
	
	function obtenerRecursoCategoria()
	{
		global $con;
		$idCategoria=$_POST["idCategoria"];
		
		$consulta="select idRecurso,titulo from 4009_recursos where idTipoRecurso=".$idCategoria." order by titulo";  	
		
		$arrRecursos=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrRecursos);
	
	}
	
	function obtenerElementosCatalogo2()
	{
		global $con;
		$idPadre=base64_decode($_POST["idPadre"]);
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$tCatalogo=$_POST["catalogo"];
		$idMapaCurricular=$_POST["idMapaCurricular"];
		switch($tCatalogo)
		{
			case 0: //criterios de evaluacion
				$consulta="select * from ((select idEvaluacion from 4156_criteriosEvaluacionExtra where (idGrupo=".$idGrupo." or idGrupo=-1) and idMateria=".$idMateria." and tipoCriterio=0 and (idPadre<>0 and idPadre<>".$idPadre.")) 
							union
							(select idEvaluacion from 4044_materiaVsEvaluaciones where idMateria=".$idMateria.")) as tmp
							";
				$listado=$con->obtenerListaValores($consulta);
				if($listado=="")
					$listado="-1";
				$consulta="select idEvaluacion,titulo from 4010_evaluaciones where idEvaluacion not in (".$listado.") and (idMapaCurricular=".$idMapaCurricular." or idMapaCurricular=-1) order by titulo";
			break;
			case 2: //Actitudes
				$consulta="select * from ((select idEvaluacion from 4156_criteriosEvaluacionExtra where (idGrupo=".$idGrupo." or idGrupo=-1) and idMateria=".$idMateria." and tipoCriterio=2) 
							union
							(select idActitud from 4043_materiaVsActitudes where idMateria=".$idMateria." and criterioEval=1)) as tmp
							";
				$listado=$con->obtenerListaValores($consulta);
				if($listado=="")
					$listado="-1";
				$consulta="select idActitud,titulo from 4008_actitudes where idActitud not in (".$listado.") and (idMapaCurricular=".$idMapaCurricular." or idMapaCurricular=-1) order by titulo";
			break;
			case 3: //Competencias
				$consulta="select * from ((select idEvaluacion from 4156_criteriosEvaluacionExtra where (idGrupo=".$idGrupo." or idGrupo=-1) and idMateria=".$idMateria." and tipoCriterio=3) 
							union
							(select idCompetencia from 4041_materiaVsCompetencias where idMateria=".$idMateria." and criterioEval=1)) as tmp
							";
				$listado=$con->obtenerListaValores($consulta);
				if($listado=="")
					$listado="-1";
				$consulta="select idCompetencia,titulo from 4007_competencias where idCompetencia not in (".$listado.") and (idMapaCurricular=".$idMapaCurricular." or idMapaCurricular=-1) order by titulo";
			break;
			case 4://Hablidades
				$consulta="select * from ((select idEvaluacion from 4156_criteriosEvaluacionExtra where (idGrupo=".$idGrupo." or idGrupo=-1) and idMateria=".$idMateria." and tipoCriterio=4) 
							union
							(select idHabilidad from 4042_materiaVsHabilidades where idMateria=".$idMateria." and criterioEval=1)) as tmp
							";
				$listado=$con->obtenerListaValores($consulta);
				if($listado=="")
					$listado="-1";
				$consulta="select idHabilidad,titulo from 4006_habilidades where idHabilidad not in (".$listado.") and (idMapaCurricular=".$idMapaCurricular." or idMapaCurricular=-1) order by titulo";
			break;
			case 5://Tecnicas colaborativas
				$consulta="select * from ((select idEvaluacion from 4156_criteriosEvaluacionExtra where (idGrupo=".$idGrupo." or idGrupo=-1) and idMateria=".$idMateria." and tipoCriterio=5) 
							union
							(select idTecnicaC from 4046_materiaVsTecnicas where idMateria=".$idMateria." and criterioEval=1)) as tmp
							";
				$listado=$con->obtenerListaValores($consulta);
				if($listado=="")
					$listado="-1";
				$consulta="select idTecnicaC,titulo from 4011_tecnicasColaborativas where idTecnicaC not in (".$listado.") and (idMapaCurricular=".$idMapaCurricular." or idMapaCurricular=-1) order by titulo";
			break;
			case 6:
				$consulta="select * from ((select idEvaluacion from 4156_criteriosEvaluacionExtra where (idGrupo=".$idGrupo." or idGrupo=-1) 
											and idMateria=".$idMateria." and tipoCriterio=6)) as tmp
							";
				$listado=$con->obtenerListaValores($consulta);
				if($listado=="")
					$listado="-1";
				$consulta="select idProducto,titulo from 4012_productos where idProducto not in (".$listado.") and (idMapaCurricular=".$idMapaCurricular." or idMapaCurricular=-1) order by titulo";
			
			
			break;
		}
		$arrDatos=uEJ($con->obtenerFilasArreglo($consulta));
		echo "1|".$arrDatos;
	}
	
	function agregarCriterioEvaluacionExtra2()
	{
		global $con;
		$idPadre=base64_decode($_POST["idPadre"]);
		$tipoPadre=base64_decode($_POST["tipoPadre"]);
		$idGrupo=$_POST["idGrupo"];
		$idMateria=$_POST["idMateria"];
		$cadCriterios=$_POST["cadCriterios"];
		$tipoCriterio=$_POST["tipoCriterio"];
		$idPadre=$idPadre."_".$tipoPadre;
		$arrCriterios=explode(",",$cadCriterios);
		$nCriterios=sizeof($arrCriterios);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		for($z=0;$z<$nCriterios;$z++)
		{
			$consulta[$x]="insert into 4156_criteriosEvaluacionExtra(idEvaluacion,idGrupo,idMateria,tipoCriterio,idPadre) values(".$arrCriterios[$z].",".$idGrupo.",".$idMateria.",".$tipoCriterio.",'".$idPadre."')";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarAvisosSesion()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$noSesion=$_POST["noSesion"];
		$fecha=cambiaraFechaMysql($_POST["fecha"]);
		$titulo=$_POST["titulo"];
		$des=$_POST["descripcion"];
		$id=$_POST["id"];
		
		if($id=="-1")
		{
			$consulta="INSERT INTO 4191_avisosMateria(idMateria,idGrupo,noSesion,fecha,titulo,descripcion)VALUES(".$idMateria.",".$idGrupo.",".$noSesion.",'".$fecha."','".$titulo."','".$des."')";
		}
		else
		{
			$consulta="Update 4191_avisosMateria set titulo='".$titulo."',descripcion='".$des."' where idAvisoMateria=".$id;
		}
		
		if($con->ejecutarConsulta($consulta))
			echo"1|";
		else
			echo"2|";
	}
	
	function guardarEnlacesSesion()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$noSesion=$_POST["noSesion"];
		$fecha=cambiaraFechaMysql($_POST["fecha"]);
		$titulo=$_POST["titulo"];
		$des=$_POST["descripcion"];
		$enlace=$_POST["enlace"];
		$id=$_POST["id"];
		
		if($id=="-1")
		{
			$consulta="INSERT INTO 4192_enlacesMateria(idMateria,idGrupo,noSesion,fecha,titulo,descripcion,enlace)VALUES(".$idMateria.",".$idGrupo.",".$noSesion.",'".$fecha."','".$titulo."','".$des."','".$enlace."')";
		}
		else
		{	
			$consulta="Update 4192_enlacesMateria set titulo='".$titulo."',descripcion='".$des."',enlace='".$enlace."' where idEnlaceMateria=".$id;
		}
		
		if($con->ejecutarConsulta($consulta))
			echo"1|";
		else
			echo"2|";
	}
	
	function modificarAvisosSesion()
	{
		global $con;
		$id=$_POST["id"];
		
		$consulta="SELECT titulo,descripcion FROM 4191_avisosMateria WHERE idAvisoMateria=".$id;
		$fila=$con->obtenerPrimeraFila($consulta);
		
		echo "1|".$fila[0]."|".$fila[1];
	}
	
	function modificarEnlaceSesion()
	{
		global $con;
		$id=$_POST["id"];
		
		$consulta="SELECT titulo,descripcion,enlace FROM 4192_enlacesMateria WHERE idEnlaceMateria=".$id;
		$fila=$con->obtenerPrimeraFila($consulta);
		
		echo "1|".$fila[0]."|".$fila[1]."|".$fila[2];
	}
	
	function guardarPlaneacionSesion()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$noSesion=$_POST["noSesion"];
		$fechaC=$_POST["fecha"];
		$cadenaGuardar=$_POST["cadenaGuardar"];
		$arregloObj=json_decode($cadenaGuardar);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			foreach($arregloObj as $obj)
			{
				$campo=$obj->idControl;
				$valor=$obj->valor;
				
				$conExiste="SELECT idPlaneacionSesion FROM 4193_planeacionSesion WHERE campo=".$campo." AND noSesion=".$noSesion." AND fecha='".$fechaC."'";
				$existe=$con->obtenerValor($conExiste);
				if($existe=="")
				{
					$query[$ct]="INSERT INTO 4193_planeacionSesion(idMateria,idGrupo,noSesion,fecha,campo,valor) VALUES(".cv($idMateria).",".cv($idGrupo).",".cv($noSesion).",'".cv($fechaC)."',".cv($campo).",'".cv($valor)."') ";
				}
				else
				{
					$query[$ct]="UPDATE 4193_planeacionSesion SET valor='".cv($valor)."' WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND noSesion=".$noSesion." AND fecha='".$fechaC."' AND campo=".$campo;
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
				echo "2|";
			}
		}
	}
	
	function guardarPlaneacionCompartida()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$noSemana=$_POST["noSemana"];
		$idPlaneacion=$_POST["idPlaneacion"];
		$cadenaCompartidos=$_POST["cadenaCompartidos"];
		$primerDia=$_POST["iniSemana"];
		$primerDia=cambiaraFechaMysql($primerDia);
		$ultimoDia=$_POST["finSemana"];
		$ultimoDia=cambiaraFechaMysql($ultimoDia);
		$arreglo=explode("_",$cadenaCompartidos);
		$idUsuario=$_SESSION["idUsr"];
		
		$idGrupoC=$arreglo[0];
		$idProfesor=$arreglo[1];
		if($idUsuario==$idProfesor)
		{
			$consultaExisteReporte="SELECT idPlaneacionMateria FROM 4171_planeacionMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupoC." AND fechaInicio='".$primerDia."' AND fechaFin='".$ultimoDia."'";
			$existe=$con->obtenerValor($consultaExisteReporte);
			if($existe=="")
			{
				$consul="INSERT INTO 4171_planeacionMateria(idMateria,idgrupo,fechaInicio,fechaFin) VALUES('".$idMateria."','".$idGrupoC."','".$primerDia."','".$ultimoDia."') ";
				if($con->ejecutarConsulta($consul))
				{
					$idNplanecion=$con->obtenerUltimoID();
					$consulta="begin";
					if($con->ejecutarconsulta($consulta))
					{
						$ct=0;
							
						$elementosPlaneacion="SELECT campo,valor FROM 4174_reporteMateria r, 4172_elementosPlaneacion e WHERE idPlaneacionMateria=".$idPlaneacion." AND e.idElementoPlaneacion=r.campo AND visible=1";
						$res=$con->obtenerFilas($elementosPlaneacion);
						
						while($fElemento=mysql_fetch_row($res))
						{
							$query[$ct]="INSERT INTO 4174_reporteMateria(idPlaneacionMateria,campo,valor) VALUES('".$idNplanecion."','".$fElemento[0]."','".$fElemento[1]."')";
							$ct++;
						}
						
						$temasPlaneacion="SELECT idTema FROM 4186_temasVSPlaneacion WHERE idPlaneacionMateria=".$idPlaneacion;
						$temas=$con->obtenerFilas($temasPlaneacion);
						while($fTemas=mysql_fetch_row($temas))
						{
							$query[$ct]="insert into 4186_temasVSPlaneacion(idPlaneacionMateria,idTema) values('".$idNplanecion."','".$fTemas[0]."')";
							$ct++;
						}
						$query[$ct]="commit";	
						if($con->ejecutarBloque($query))
							echo"1|";
						else	
							echo"3|";
					}
				}
			}
			else
			{
				echo"2|";
			}
		}
		else
		{
			$conExiste="SELECT idPlaneacionCompartida FROM 4194_planeacionesCompartidas WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND idGrupoCompartiendo=".$idGrupoC." AND noSemanaPlaneacion=".$noSemana;
			$existe=$con->obtenerValor($conExiste);
			if($existe=="")
			{
				$compartir="INSERT INTO 4194_planeacionesCompartidas(idMateria,idGrupo,idGrupoCompartiendo,noSemanaPlaneacion) VALUES('".$idMateria."','".$idGrupo."','".$idGrupoC."','".$noSemana."')";
				if($con->ejecutarConsulta($compartir))
					echo "1|";
				else
					echo "3|";
			}	
		}
	}
	
	function sobreescribirPlaneacionCompartida()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$noSemana=$_POST["noSemana"];
		
		$idPlaneacion=$_POST["idPlaneacion"];
		$cadenaCompartidos=$_POST["cadenaCompartidos"];
		$primerDia=$_POST["iniSemana"];
		$primerDia=cambiaraFechaMysql($primerDia);
		$ultimoDia=$_POST["finSemana"];
		$ultimoDia=cambiaraFechaMysql($ultimoDia);
		$arreglo=explode('_',$cadenaCompartidos);
		$idGrupoC=$arreglo[0];
		$idProfesor=$arreglo[1];
		
		$consulta="begin";
		if($con->ejecutarconsulta($consulta))
		{
			$ct=0;
			$consultaExisteReporte="SELECT idPlaneacionMateria FROM 4171_planeacionMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupoC." AND fechaInicio='".$primerDia."' AND fechaFin='".$ultimoDia."'";
			$existe=$con->obtenerValor($consultaExisteReporte);
			
			$query[$ct]="DELETE FROM 4174_reporteMateria WHERE idPlaneacionMateria=".$existe;
			$ct++;
			
			$query[$ct]="DELETE FROM 4186_temasVSPlaneacion WHERE idPlaneacionMateria=".$existe;
			$ct++;
			
			$conExiste="SELECT idPlaneacionCompartida FROM 4194_planeacionesCompartidas WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND idGrupoCompartiendo=".$idGrupoC." AND noSemanaPlaneacion=".$noSemana;
			$existeC=$con->obtenerValor($conExiste);
			if($existeC=="")
			{
				$query[$ct]="INSERT INTO 4194_planeacionesCompartidas(idMateria,idGrupo,idGrupoCompartiendo,noSemanaPlaneacion) VALUES('".$idMateria."','".$idGrupo."','".$idGrupoC."','".$noSemana."')";
				$ct++;
			}
			
			$elementosPlaneacion="SELECT campo,valor FROM 4174_reporteMateria r, 4172_elementosPlaneacion e WHERE idPlaneacionMateria=".$idPlaneacion." AND e.idElementoPlaneacion=r.campo AND visible=1";
			$res=$con->obtenerFilas($elementosPlaneacion);
			while($fElemento=mysql_fetch_row($res))
			{
				$query[$ct]="INSERT INTO 4174_reporteMateria(idPlaneacionMateria,campo,valor) VALUES('".$existe."','".$fElemento[0]."','".$fElemento[1]."')";
				$ct++;
			}
			
			$temasPlaneacion="SELECT idTema FROM 4186_temasVSPlaneacion WHERE idPlaneacionMateria=".$idPlaneacion;
			$temas=$con->obtenerFilas($temasPlaneacion);
			while($fTemas=mysql_fetch_row($temas))
			{
				$query[$ct]="insert into 4186_temasVSPlaneacion(idPlaneacionMateria,idTema) values('".$existe."','".$fTemas[0]."')";
				$ct++;
			}
			
			$query[$ct]="commit";	
			if($con->ejecutarBloque($query))
				echo"1|";
			else	
				echo"3|";
		}
	}
	
	function aceptarPlaneacionCompartida()
	{
		global $con;
		$idPlaneacion=$_POST["idPlaneacion"];
		$bloque=$_POST["bloque"];
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$noSemana=$_POST["noSemana"];
		$cadenaCompartidos=$_POST["cadenaCompartidos"];
		$arreglo=explode('_',$cadenaCompartidos);
		$primerDia=$_POST["iniSemana"];
		$primerDia=cambiaraFechaMysql($primerDia);
		$ultimoDia=$_POST["finSemana"];
		$ultimoDia=cambiaraFechaMysql($ultimoDia);
		$idGrupoC=$arreglo[0];
		$idProfesor=$arreglo[1];
		
		if($idPlaneacion==0)
		{
			$consultaExisteReporte="SELECT idPlaneacionMateria FROM 4171_planeacionMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupoC." AND fechaInicio='".$primerDia."' AND fechaFin='".$ultimoDia."'";
			$existe=$con->obtenerValor($consultaExisteReporte);
			if($existe=="")
			{
				$existe="-1";
			}
			
			$consul="INSERT INTO 4171_planeacionMateria(idMateria,idgrupo,fechaInicio,fechaFin,noBloque) VALUES('".$idMateria."','".$idGrupo."','".$primerDia."','".$ultimoDia."',".$bloque.") ";
			if($con->ejecutarConsulta($consul))
			{
				$idNplanecion=$con->obtenerUltimoID();
				$consulta="begin";
				if($con->ejecutarconsulta($consulta))
				{
					$ct=0;
						
					$elementosPlaneacion="SELECT campo,valor FROM 4174_reporteMateria r, 4172_elementosPlaneacion e WHERE idPlaneacionMateria=".$existe." AND e.idElementoPlaneacion=r.campo AND visible=1";
					$res=$con->obtenerFilas($elementosPlaneacion);
					
					while($fElemento=mysql_fetch_row($res))
					{
						$query[$ct]="INSERT INTO 4174_reporteMateria(idPlaneacionMateria,campo,valor) VALUES('".$idNplanecion."','".$fElemento[0]."','".$fElemento[1]."')";
						$ct++;
					}
					
					$temasPlaneacion="SELECT idTema FROM 4186_temasVSPlaneacion WHERE idPlaneacionMateria=".$existe;
					$temas=$con->obtenerFilas($temasPlaneacion);
					while($fTemas=mysql_fetch_row($temas))
					{
						$query[$ct]="insert into 4186_temasVSPlaneacion(idPlaneacionMateria,idTema) values('".$idNplanecion."','".$fTemas[0]."')";
						$ct++;
					}
					$query[$ct]="commit";	
					if($con->ejecutarBloque($query))
						echo"1|";
					else	
						echo"3|";
				}
			}
		
		}
		else
		{
			$consulta="begin";
			if($con->ejecutarconsulta($consulta))
			{
				$ct=0;
				$consultaExisteReporte="SELECT idPlaneacionMateria FROM 4171_planeacionMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupoC." AND fechaInicio='".$primerDia."' AND fechaFin='".$ultimoDia."'";
				$existe=$con->obtenerValor($consultaExisteReporte);	
				if($existe=="")
				{
					$existe="-1";
				}
				
				$query[$ct]="DELETE FROM 4174_reporteMateria WHERE idPlaneacionMateria=".$idPlaneacion;
				$ct++;
				
				$elementosPlaneacion="SELECT campo,valor FROM 4174_reporteMateria r, 4172_elementosPlaneacion e WHERE idPlaneacionMateria=".$existe." AND e.idElementoPlaneacion=r.campo AND visible=1";
				$res=$con->obtenerFilas($elementosPlaneacion);
				
				while($fElemento=mysql_fetch_row($res))
				{
					$query[$ct]="INSERT INTO 4174_reporteMateria(idPlaneacionMateria,campo,valor) VALUES('".$idPlaneacion."','".$fElemento[0]."','".$fElemento[1]."')";
					$ct++;
				}
				
				$temasPlaneacion="SELECT idTema FROM 4186_temasVSPlaneacion WHERE idPlaneacionMateria=".$idPlaneacion;
				$temas=$con->obtenerFilas($temasPlaneacion);
				while($fTemas=mysql_fetch_row($temas))
				{
					$query[$ct]="insert into 4186_temasVSPlaneacion(idPlaneacionMateria,idTema) values('".$idPlaneacion."','".$fTemas[0]."')";
					$ct++;
				}
				$query[$ct]="commit";	
				if($con->ejecutarBloque($query))
					echo"1|";
				else	
					echo"3|";
			}
		}
	}
	
	function guardarNoBloquesMateria()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$noBloques=$_POST["noBloques"];
		$bandera=$_POST["bandera"];
		
		$consulta="select idMateriaBloques from 4195_bloquesMateria where idMateria=".$idMateria." and idGrupo=".$idGrupo;
		$existe=$con->obtenerValor($consulta);
		
		if($bandera=="1")
		{
			$consulta="begin";
			if($con->ejecutarConsulta($consulta))
			{
				$ct=0;
				$query[$ct]="delete from 4179_bloqueSemanas where idMateria=".$idMateria." and idGrupo=".$idGrupo;
				$ct++;
				
				if($existe=="")
				{
					$query[$ct]="INSERT INTO 4195_bloquesMateria(idMateria,idGrupo,noBloques) VALUES('".$idMateria."','".$idGrupo."','".$noBloques."')";
				}
				else
				{
					$query[$ct]="UPDATE 4195_bloquesMateria SET noBloques='".$noBloques."' WHERE idMateriaBloques=".$existe;
				}
				
				$ct++;
				$query[$ct]="commit";
				
				if($con->ejecutarBloque($query))
					echo "1|";
				else
					echo "2|";
			}
		}
		else
		{
			
			if($existe=="")
			{
				$query="INSERT INTO 4195_bloquesMateria(idMateria,idGrupo,noBloques) VALUES('".$idMateria."','".$idGrupo."','".$noBloques."')";
			}
			else
			{
				$query="UPDATE 4195_bloquesMateria SET noBloques='".$noBloques."' WHERE idMateriaBloques=".$existe;
			}
			
			if($con->ejecutarConsulta($query))
				echo "1|";
			else
				echo "2|";
		}
	}
	
	function modificarConfiguracionBloque()
	{
		global $con;
		$pondCriteriosEq=$_POST["pondCriteriosEq"];
		$bloque=$_POST["bloque"];
		$tipoBloque=$_POST["tBloque"];
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="UPDATE 4155_confBloquesMateria SET pondCriteriosEq=".$pondCriteriosEq." WHERE bloque=".$bloque." AND tipoBloque=".$tipoBloque." 
					AND idMateria=".$idMateria." AND idGrupo=".$idGrupo;
		$x++;
		if($pondCriteriosEq==1)
		{
			$consulta[$x]="update 4152_ponderacionCriterios set valor=0 where bloque=".$bloque." and idMateria=".$idMateria." and idGrupo=".$idGrupo." 
						   and idPadre=0";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function modificarPonderacionCriterio()
	{
		global $con;
		$idPonderacion=$_POST["idPonderacion"];
		$valor=$_POST["valor"];
		$solPond=$_POST["solPond"];
		$idGrupo=$_POST["idGrupo"];
		$idMateria=$_POST["idMateria"];
		if($idPonderacion!="-1")
			$consulta="update 4152_ponderacionCriterios set solicitarCalificacion=".$solPond.",valor=".$valor." where idPonderacion=".$idPonderacion;
		else
			$consulta="insert into 4152_ponderacionCriterios(solicitarCalificacion,valor,idEvaluacion,bloque,tipoCriterio,tipoBloque,idGrupo,idMateria,idPadre) 
						values(".$solPond.",".$valor.",0,0,0,0,".$idGrupo.",".$idMateria.",0)";
		eC($consulta);
	}
	
	/*function removerCriterioEvaluacion()
	{
		global $con;
		$idCriterio=$_POST["idCriterio"];
		$query="select idMateria,idGrupo,idEvaluacion,tipoCriterio from 4156_criteriosEvaluacionExtra where idCriterioEvaluacionExtra=".$idCriterio;
		$filaCriterio=$con->obtenerPrimeraFila($query);
		$query="SELECT idCriterioEvaluacionExtra FROM 4156_criteriosEvaluacionExtra WHERE idPadre=".$idCriterio;
		$res=$con->obtenerFilas($query);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 4156_criteriosEvaluacionExtra where idCriterioEvaluacionExtra=".$idCriterio;
		$x++;
		$consulta[$x]="delete from 4152_ponderacionCriterios where idMateria=".$filaCriterio[0]." and idGrupo=".$filaCriterio[1]." and idEvaluacion=".$filaCriterio[2]." and tipoCriterio=".$filaCriterio[3];
		$x++;
		while($fila=mysql_fetch_row($res))
		{
			removerCriterioEvaluacionHijo($fila[0],$consulta,$x);
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}*/
	
	function removerCriterioEvaluacionHijo($idPadre,&$consulta,&$x)
	{
		global $con;
		$query="select idMateria,idGrupo,idEvaluacion,tipoCriterio from 4156_criteriosEvaluacionExtra where idCriterioEvaluacionExtra=".$idPadre;
		$filaCriterio=$con->obtenerPrimeraFila($query);
		$query="select idPonderacion from 4152_ponderacionCriterios where idMateria=".$filaCriterio[0]." and idGrupo=".$filaCriterio[1]." and idEvaluacion=".$filaCriterio[2]." and tipoCriterio=".$filaCriterio[3];
		$listPonderacion=$con->obtenerListaValores($query);
		if($listPonderacion=="")
			$listPonderacion="-1";
		$query="SELECT idCriterioEvaluacionExtra FROM 4156_criteriosEvaluacionExtra WHERE idPadre=".$idPadre;
		$res=$con->obtenerFilas($query);
		$consulta[$x]="delete from 4156_criteriosEvaluacionExtra where idCriterioEvaluacionExtra=".$idPadre;
		$x++;
		$consulta="delete from 4162_calCriterioBloque where idPonderacion in (".$listPonderacion.")";
		$x++;
		$consulta[$x]="delete from 4152_ponderacionCriterios where idMateria=".$filaCriterio[0]." and idGrupo=".$filaCriterio[1]." and idEvaluacion=".$filaCriterio[2]." and tipoCriterio=".$filaCriterio[3];
		$x++;
		while($fila=mysql_fetch_row($res))
		{
			removerCriterioEvaluacionHijo($fila[0],$consulta,$x);
		}
	}
	
	function obtenerConfiguracionBloquesCriterio()
	{
		global $con;
		$idCriterio=$_POST["idCriterio"];
		$idMateria=$_POST["idMateria"];
		
		$consulta="SELECT noParciales FROM 4502_Materias WHERE idMateria=".$idMateria ;
		$filaMateria=$con->obtenerPrimeraFila($consulta);
		$bloques=$filaMateria[0];
		$confBloque="";
		
		for($x=1;$x<=$bloques;$x++)
		{
			$consulta="SELECT pondCriteriosEq,regla FROM 4156_confBloquesCriterio WHERE bloque=".$x." AND tipoBloque=0 AND idCriterioEvaluacionExtra=".$idCriterio;
			$compPonderacion=$con->obtenerPrimeraFila($consulta);
			$objBl="['".$x."','".$x."','".$compPonderacion[0]."','".$compPonderacion[1]."','0','0']";
			if($confBloque=="")
				$confBloque=$objBl;
			else
				$confBloque.=",".$objBl;
		}
	
	
		$consulta="SELECT pondCriteriosEq FROM 4156_confBloquesCriterio WHERE bloque=0 AND tipoBloque=0 AND idCriterioEvaluacionExtra=".$idCriterio;
		$compPonderacion=$con->obtenerValor($consulta);
		echo "1|[".uEJ($confBloque.",['0','Bloque final','".$compPonderacion."','0','0']")."]";
	}
	
	
	function modificarConfiguracionBloqueCriterio()
	{
		global $con;
		$objConf=$_POST["objConf"];
		$obj=json_decode($objConf);
		$idCriterio=$obj->idCriterio;
		$tipoBloque=$obj->tipoBloque;
		$arrConf=$obj->arrConf;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrConf as $conf)
		{
			if($conf->regla=='')
				$conf->regla=-1;
			$consulta[$x]="update 4156_confBloquesCriterio set pondCriteriosEq=".$conf->balanceado.",regla=".$conf->regla." where bloque=".$conf->idBloque." and tipoBloque=".$tipoBloque." and idCriterioEvaluacionExtra=".$idCriterio;
			$x++;
			if($conf->balanceado==1)
			{
				$consulta[$x]="UPDATE 4152_ponderacionCriterios set valor=0 WHERE idPadre=".$idCriterio." AND bloque=".$conf->idBloque." AND tipoCriterio=".$tipoBloque;
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerListadoAlumnosClase()
	{
		global $con;
		global $mostrarCalEvidencia;
		global $mostrarTotalSoicitados;
		global $habilitarFaltas;
		global $habilitarAsitencias;
		global $calcularAsistencias;
		
		
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$idBloque=$_POST["idBloque"];
		$arrAlumnos="";
		$consulta="SELECT i.idUsuario as idAlumno,concat(i.Paterno,' ',i.Materno,' ',i.Nom) as alumno FROM 4517_alumnosVsMateriaGrupo ae,802_identifica i
					WHERE i.idUsuario=ae.idUsuario and   ae.idGrupo=".$idGrupo."  order by i.Paterno,i.Materno,i.Nom";

		$resAlumnos=$con->obtenerFilas($consulta);	

		$consulta="select max(nivel) from 4156_criteriosEvaluacionExtra where idMateria=".$idMateria." and (idGrupo=".$idGrupo." or idGrupo=-1)";
		$maxNivel=$con->obtenerValor($consulta)+1;

		$consulta="(select idEvaluacion,tipoCriterio,idPadre,idCriterioEvaluacionExtra,idGrupo from 4156_criteriosEvaluacionExtra where idMateria=".$idMateria." and (idGrupo=".$idGrupo." or idGrupo=-1) and idPadre=0)
					";
		
		//echo $consulta;
		$resCriterios=$con->obtenerFilas($consulta);
		$arrCriterios=array();
		$arrNiveles=array();
		while($filaCriterios=mysql_fetch_row($resCriterios))
		{
			$nCriterio=buscarNombreCriterio($filaCriterios[0],$filaCriterios[1]);
			$tipoC=buscarTipoCalCriterio($filaCriterios[0],$filaCriterios[1]);
			$obj["idCriterio"]=$filaCriterios[3];
			$obj["idEvaluacion"]=$filaCriterios[0];
			$obj["nCriterio"]=$nCriterio;
			$obj["tipoCriterio"]=$filaCriterios[1];
			$obj["tipoCalCriterio"]=$tipoC;
			$obj["padre"]=$filaCriterios[2];
				
				$arrHijos=obtenerHijosCriterio($filaCriterios[3]);
				$obj["hijos"]=$arrHijos;
				
			array_push($arrCriterios,$obj);
		}
		
		$ct=1;	
		
		while($filaAlumno=mysql_fetch_row($resAlumnos))
		{
			$tamanoFor=sizeof($arrCriterios);
			$contadorFor=1;
			$cadRutas="";
			foreach($arrCriterios as $criterio)
			{			
				$arrRutas=generarRutasCriterio($criterio["hijos"],1,$maxNivel,$filaAlumno[0],$idBloque,$idMateria,$idGrupo,$criterio["tipoCalCriterio"]);
				$cadRutas="";
				
				if(sizeof($arrRutas)!=0)
				{
					
					foreach($arrRutas as $ruta)
					{
						$raiz='{"idRegistro":"'.$ct.'","idAlumno":"'.$filaAlumno[0].'","alumno":"'.strtoupper($filaAlumno[1]).'",
						"idCriterio_0":"'.$criterio["idCriterio"].'","criterio_0":"'.$criterio["nCriterio"].'"';
						if($cadRutas=="")
							$cadRutas=$raiz.','.$ruta.'}';
						else	
							$cadRutas.=",".$raiz.','.$ruta.'}';
						$ct++;
					}
					
					
					$consulta="SELECT idPonderacion FROM 4152_ponderacionCriterios WHERE idEvaluacion=".$criterio["idEvaluacion"]." AND tipoCriterio=".$criterio["tipoCriterio"]." AND idMateria=".$idMateria." AND (idGrupo=".$idGrupo." or idGrupo=-1) AND bloque=".$idBloque;
					//echo $consulta;
					
					$idPonderacion=$con->obtenerValor($consulta);
					if($idPonderacion=="")
						$idPonderacion="-1";
					
					$conCalif="SELECT calificacion FROM 4162_calCriterioBloque WHERE idPonderacion=".$idPonderacion." AND idUsuario=".$filaAlumno[0];
						//echo $conCalif;
					$calCrit=$con->obtenerValor($conCalif);
					
					$raiz='{"idRegistro":"'.$ct.'","idAlumno":"'.$filaAlumno[0].'","alumno":"'.strtoupper($filaAlumno[1]).'",
						"idCriterio_0":"'.$criterio["idCriterio"].'","criterio_0":"'.$criterio["nCriterio"].'"';
					$nodoHijoCal='"idCriterio_1":"-1000","criterio_1":"¦Calificacion","value":"0_0_'.number_format($calCrit,2,'.',',').'_0_0_'.$criterio["idCriterio"].'"';
					$cadRutas.=",".$raiz.','.$nodoHijoCal.'}';
					$ct++;
				}
				else
				{
					
					$consulta="SELECT idPonderacion FROM 4152_ponderacionCriterios WHERE idEvaluacion=".$criterio["idEvaluacion"]." AND tipoCriterio=".$criterio["tipoCriterio"]." AND idMateria=".$idMateria." AND (idGrupo=".$idGrupo." or idGrupo=-1) AND bloque=".$idBloque;
					//echo $consulta;
					
					$idPonderacion=$con->obtenerValor($consulta);
					if($idPonderacion=="")
						$idPonderacion="-1";
					//echo $consulta;
					//$consulta="SELECT calificacion FROM 4162_calCriterioBloque WHERE idPonderacion=".$idPonderacion." AND idUsuario=".$filaAlumno[0];
					$conCalif="SELECT calificacion FROM 4162_calCriterioBloque WHERE idPonderacion=".$idPonderacion." AND idUsuario=".$filaAlumno[0];
					//echo $conCalif;
					$calCrit=$con->obtenerValor($conCalif);
					if($calCrit=="")
						$calCrit="0";
					
					if($criterio["tipoCalCriterio"]!=2)
					{		
						if($criterio["tipoCriterio"]==0)
						{
						  //echo "entra".$criterio["nCriterio"];
						  $raiz='{"idRegistro":"'.$ct.'","idAlumno":"'.$filaAlumno[0].'","alumno":"'.strtoupper($filaAlumno[1]).'",
								  "idCriterio_0":"'.$criterio["idCriterio"].'","criterio_0":"'.$criterio["nCriterio"].'&nbsp;&nbsp;&nbsp;<a href=\'javascript:guardarColumna('.$idPonderacion.',1)\'><img width=\'13\' height=\'13\' src=\'../images/guardar.JPG\'></a>&nbsp;&nbsp;&nbsp;<a href=\'javascript:guardarSoloColumna('.$idPonderacion.',1,'.$criterio["idEvaluacion"].','.$criterio["tipoCalCriterio"].')\'><img width=\'13\' height=\'13\' src=\'../images/table_row_insert.png\' title=\'Ver alumnos por criterio\' alt=\'Ver alumnos por criterio\'></a>"';
						  $cadRutas=$raiz.',"value":"'.$idPonderacion.'_'.$filaAlumno[0].'_'.number_format($calCrit,2,'.',',').'_1_0_'.$criterio["idEvaluacion"].'"}';
						//$ct++;
						}
						else
						{
							$raiz='{"idRegistro":"'.$ct.'","idAlumno":"'.$filaAlumno[0].'","alumno":"'.strtoupper($filaAlumno[1]).'",
								  "idCriterio_0":"'.$criterio["idCriterio"].'","criterio_0":"'.$criterio["nCriterio"].'"';
						  $cadRutas=$raiz.',"value":"'.$idPonderacion.'_'.$filaAlumno[0].'_'.number_format($calCrit,2,'.',',').'_0_0_'.$criterio["idCriterio"].'"}';
						}
					}
					else
					{
						//echo "entra-";
						$consulta="SELECT noEvidencias FROM 4210_alumnosVSEvidencia WHERE idPonderacion=".$idPonderacion." AND idUsuario=".$filaAlumno[0];
						$valor=$con->obtenerValor($consulta);
						if($valor=="")
							$valor=0;
						
						$consulta="select * from 4199_evidenciasBloque where idPonderacion=".$idPonderacion." and idGrupo=".$idGrupo;
						$filaEvidencia=$con->obtenerPrimeraFila($consulta);
						
						$valorE=$filaEvidencia[3];
						if($valorE=="")
							$valorE="0";
						
						$raiz='{"idRegistro":"'.$ct.'","idAlumno":"'.$filaAlumno[0].'","alumno":"'.strtoupper($filaAlumno[1]).'",
								"idCriterio_0":"'.$criterio["idCriterio"].'","criterio_0":"'.$criterio["nCriterio"].'","idCriterio_1":"-10","criterio_1":"<font color=\'#009900\'> Total a considerar <label id=\'totalC_'.$idPonderacion.'\'>'.$valorE.'</label></font>&nbsp;&nbsp;<a href=\'javascript:actualizarTotal('.$idPonderacion.',3)\'><img width=\'13\' height=\'13\' src=\'../images/pencil.png\'></a><br/>Total entregados<br/><a href=\'javascript:guardarColumna('.$idPonderacion.',2)\'><img width=\'13\' height=\'13\' src=\'../images/guardar.PNG\'></a>&nbsp;&nbsp;&nbsp;<a href=\'javascript:guardarSoloColumna('.$idPonderacion.',1,'.$criterio["idEvaluacion"].','.$criterio["tipoCalCriterio"].')\'><img width=\'13\' height=\'13\' src=\'../images/table_row_insert.png\' title=\'Ver alumnos por criterio\' alt=\'Ver alumnos por criterio\'></a>",
								"value":"'.$idPonderacion.'_'.$filaAlumno[0].'_'.number_format($valor,0,'.',',').'_1_1_'.$criterio["idCriterio"].'"}';
						$ct++;
						
						
						if($mostrarTotalSoicitados=="true")
						{
							$valor=$filaEvidencia[2];
							if($valor=="")
								$valor="0";
							$raiz.=',{"idRegistro":"'.$ct.'","idAlumno":"'.$filaAlumno[0].'","alumno":"'.strtoupper($filaAlumno[1]).'",
									"idCriterio_0":"'.$criterio["idCriterio"].'","criterio_0":"'.$criterio["nCriterio"].'","idCriterio_1":"-11","criterio_1":"Total solicitados <br><a href=\'javascript:actualizarTotal('.$idPonderacion.',2)\'><img width=\'13\' height=\'13\' src=\'../images/pencil.png\'>",
									"value":"'.$idPonderacion.'_'.$filaAlumno[0].'_'.number_format($valor,2,'.',',').'_0_2_'.$criterio["idCriterio"].'"}';
							$ct++;
						
						}
					
						
						$conCalif="SELECT calificacion FROM 4162_calCriterioBloque WHERE idPonderacion=".$idPonderacion." AND idUsuario=".$filaAlumno[0];
						//echo $conCalif;
						$calCrit=$con->obtenerValor($conCalif);
						if($calCrit=="")
							$calCrit="0";
						
						if(($mostrarCalEvidencia=="true") || ($criterio["padre"]==0))
						{
						//<br><a href=\'javascript:actualizarTotal('.$idPonderacion.',3)\'><img width=\'13\' height=\'13\' src=\'../images/pencil.png\'>
						$raiz.=',{"idRegistro":"'.$ct.'","idAlumno":"'.$filaAlumno[0].'","alumno":"'.strtoupper($filaAlumno[1]).'",
								"idCriterio_0":"'.$criterio["idCriterio"].'","criterio_0":"'.$criterio["nCriterio"].'","idCriterio_1":"-12","criterio_1":"^Calificacion:",
								"value":"'.$idPonderacion.'_'.$filaAlumno[0].'_'.number_format($calCrit,2,'.',',').'_0_4_'.$criterio["idCriterio"].'"}';	
						//$ct++;		
						}
						$cadRutas=$raiz;
						$ct++;
						
						
						$conCalif="SELECT calificacion FROM 4162_calCriterioBloque WHERE idPonderacion=".$idPonderacion." AND idUsuario=".$filaAlumno[0];
						//echo $conCalif;
						$calCrit=$con->obtenerValor($conCalif);
						if($calCrit=="")
							$calCrit="0";
						
						if(($mostrarCalEvidencia=="true") || ($criterio["padre"]==0))
						{
						//<br><a href=\'javascript:actualizarTotal('.$idPonderacion.',3)\'><img width=\'13\' height=\'13\' src=\'../images/pencil.png\'>
						$raiz.=',{"idRegistro":"'.$ct.'","idAlumno":"'.$filaAlumno[0].'","alumno":"'.strtoupper($filaAlumno[1]).'",
								"idCriterio_0":"'.$criterio["idCriterio"].'","criterio_0":"'.$criterio["nCriterio"].'","idCriterio_1":"-12","criterio_1":"^Calificacion:",
								"value":"'.$idPonderacion.'_'.$filaAlumno[0].'_'.number_format($calCrit,2,'.',',').'_0_4_'.$criterio["idCriterio"].'"}';	
						//$ct++;		
						}
						$cadRutas=$raiz;
						
					}
	
					$ct++;
				}
				
				if($arrAlumnos=="")
					$arrAlumnos=$cadRutas;
				else
					$arrAlumnos.=",".$cadRutas;
				
				$contadorFor++;
			}
			
			$conExiste2="SELECT calificacion FROM 4163_calBloqueMateria WHERE bloque=".$idBloque." AND idMateria=".$idMateria." AND idGrupo=".$idGrupo." and idUsuario=".$filaAlumno[0] ;
			//echo $conExiste2;
			$id2=$con->obtenerValor($conExiste2);
			if($id2=="")
			{
				$id2=0;
			}

			$conAsitenciaGrupo="SELECT noAsistencias FROM  4232_asistenciasBloque WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND bloque=".$idBloque;
			$noAsist=$con->obtenerValor($conAsitenciaGrupo);
			if($noAsist=="")
				$noAsist=0;
			
			$conFaltasGrupo="SELECT noFaltas FROM 4233_faltasBloque WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND bloque=".$idBloque." AND idUsuario=".$filaAlumno[0];
			$noFaltas=$con->obtenerValor($conFaltasGrupo);
			//if()
			
			
			
			$raiz='{"idRegistro":"'.$ct.'","idAlumno":"'.$filaAlumno[0].'","alumno":"'.strtoupper($filaAlumno[1]).'",
				"idCriterio_0":"-2000","criterio_0":"¦Calificacion Final:"';
				$cadRutas1=$raiz.',"value":"0_0_'.number_format($id2,2,'.',',').'_0_0_-2000"}';
			
			$cadRutas.=",".$cadRutas1;
			$ct++;
			
			if($arrAlumnos=="")
			  $arrAlumnos=$cadRutas;
		  	else
			  $arrAlumnos.=",".$cadRutas;
		}
	
		echo ('{"alumnos":['.$arrAlumnos.']}');
			
	}
	
	function obtenerHijosCriterio($idCriterio)
	{
		global $con;
		$consulta="select * from 4156_criteriosEvaluacionExtra where idPadre=".$idCriterio;
		//echo $consulta;
		$resCriterios=$con->obtenerFilas($consulta);
		$arrCriterios=array();
		while($filaCriterios=mysql_fetch_row($resCriterios))
		{
			$nCriterio=buscarNombreCriterio($filaCriterios[1],$filaCriterios[4]);
			$tipoC=buscarTipoCalCriterio($filaCriterios[1],$filaCriterios[4]);
			$obj["idCriterio"]=$filaCriterios[0];
			$obj["idEvaluacion"]=$filaCriterios[1];
			$obj["nCriterio"]=$nCriterio;
			$obj["tipoCriterio"]=$filaCriterios[4];
			$obj["tipoCalCriterio"]=$tipoC;
			$obj["padre"]=$idCriterio;
			$arrHijos=obtenerHijosCriterio($filaCriterios[0]);
			$obj["hijos"]=$arrHijos;
			array_push($arrCriterios,$obj);
		}
		return $arrCriterios;
		
	}
	
	function generarRutasCriterio($arrHijos,$nivel,$maxNivel,$idUsuario,$idBloque,$idMateria,$idGrupo,$tipoCalCriterio)
	{
		global $con;
		global $mostrarTotalSoicitados;
		global $mostrarCalEvidencia;
		$arrNodos=array();
		
		//var_dump ($arrHijos);
		foreach($arrHijos as $hijo)
		{
			$consulta="SELECT idPonderacion FROM 4152_ponderacionCriterios WHERE idEvaluacion=".$hijo["idEvaluacion"]." AND tipoCriterio=".$hijo["tipoCriterio"]." AND idMateria=".$idMateria." AND (idGrupo=".$idGrupo." or idGrupo=-1) AND bloque=".$idBloque;
			//echo $consulta;
			$idPonderacion=$con->obtenerValor($consulta);
			
			$nodoHijo='"idCriterio_'.$nivel.'":"'.$hijo["idCriterio"].'","criterio_'.$nivel.'":"'.$hijo["nCriterio"].'&nbsp;&nbsp;&nbsp;<a href=\'javascript:guardarColumna('.$idPonderacion.',1)\'><img width=\'13\' height=\'13\' src=\'../images/guardar.JPG\'></a>"';
			$tCriterio=1;
			if(($hijo["tipoCalCriterio"]==2)||($tipoCalCriterio==2))
				$tCriterio=2;
			
			$arrComp=generarRutasCriterio($hijo["hijos"],($nivel+1),$maxNivel,$idUsuario,$idBloque,$idMateria,$idGrupo,$tCriterio);
			if(sizeof($arrComp)!=0)
			{
				foreach($arrComp as $comp)
				{
					$nNodoComp=$nodoHijo.",".$comp;	
					array_push($arrNodos,$nNodoComp);
				}
				
			}
			else
			{
				$consulta="SELECT idPonderacion FROM 4152_ponderacionCriterios WHERE idEvaluacion=".$hijo["idEvaluacion"]." AND tipoCriterio=".$hijo["tipoCriterio"]." AND idMateria=".$idMateria." AND (idGrupo=".$idGrupo." or idGrupo=-1) AND bloque=".$idBloque;
				//echo $consulta;
				$idPonderacion=$con->obtenerValor($consulta);
				if($idPonderacion=="")
					$idPonderacion="-1";
					
				
				if(($hijo["tipoCalCriterio"]==2)||($tipoCalCriterio==2))
				{
					$consulta="SELECT noEvidencias FROM 4210_alumnosVSEvidencia WHERE idPonderacion=".$idPonderacion." AND idUsuario=".$idUsuario;
					//echo $consulta;
					$valor=$con->obtenerValor($consulta);
					if($valor=="")
						$valor=0;
					
					$consulta="select * from 4199_evidenciasBloque where idPonderacion=".$idPonderacion." and idGrupo=".$idGrupo;
					$filaEvidencia=$con->obtenerPrimeraFila($consulta);
					$valorE=$filaEvidencia[2];
					  if($valorE=="")
						  $valorE="0";
					
					$nNodoComp=$nodoHijo.',"value":"'.$idPonderacion.'_'.$idUsuario.'_'.number_format($valor,0,'.',',').'_1_1_'.$hijo["idEvaluacion"].'","idCriterio_'.($nivel+1).'":"-10","criterio_'.($nivel+1).'":"<font color=\'#009900\'>Total a considerar <label id=\'totalC_'.$idPonderacion.'\'>'.$valorE.'</label></font>&nbsp;&nbsp;<a href=\'javascript:actualizarTotal('.$idPonderacion.',3)\'><img width=\'13\' height=\'13\' src=\'../images/pencil.png\'></a><br/>Total entregados<br/><a href=\'javascript:guardarColumna('.$idPonderacion.',2)\'><img width=\'13\' height=\'13\' src=\'../images/guardar.PNG\'></a>"';	
					array_push($arrNodos,$nNodoComp);
					
					
					
					
					if($mostrarTotalSoicitados=="true")
					{
					  $valor=$filaEvidencia[2];
					  if($valor=="")
						  $valor="0";
					  $nNodoComp=$nodoHijo.',"value":"'.$idPonderacion.'_'.$idUsuario.'_'.number_format($valor,2,'.',',').'_0_2_'.$hijo["idEvaluacion"].'","idCriterio_'.($nivel+1).'":"-11","criterio_'.($nivel+1).'":"Total solicitados <br><a href=\'javascript:actualizarTotal('.$idPonderacion.',2)\'><img width=\'13\' height=\'13\' src=\'../images/pencil.png\'>" ';	
					  array_push($arrNodos,$nNodoComp);
					}
					
					//$valor=$filaEvidencia[3];
//					if($valor=="")
//						$valor="0";
//					$nNodoComp=$nodoHijo.',"value":"'.$idPonderacion.'_'.$idUsuario.'_'.number_format($valor,2,'.',',').'_0_3_'.$hijo["idCriterio"].'","idCriterio_'.($nivel+1).'":"-12","criterio_'.($nivel+1).'":"Total a considerar <br><a href=\'javascript:actualizarTotal('.$idPonderacion.',3)\'><img width=\'13\' height=\'13\' src=\'../images/pencil.png\'>"';	
//					array_push($arrNodos,$nNodoComp);
					
					if(($mostrarCalEvidencia=="true") || ($hijo["padre"]==0))
					{
					$consulta="SELECT calificacion FROM 4162_calCriterioBloque WHERE idPonderacion=".$idPonderacion." AND idUsuario=".$idUsuario;
					//echo $consulta;
					$valor=$con->obtenerValor($consulta);
					if($valor=="")
						$valor=0;
					//<br><a href=\'javascript:actualizarTotal('.$idPonderacion.',3)\'><img width=\'13\' height=\'13\' src=\'../images/pencil.png\'>
					$nNodoComp=$nodoHijo.',"value":"'.$idPonderacion.'_'.$idUsuario.'_'.number_format($valor,2,'.',',').'_0_4_'.$hijo["idEvaluacion"].'","idCriterio_'.($nivel+1).'":"-12","criterio_'.($nivel+1).'":"^Calificacion:"';	
					array_push($arrNodos,$nNodoComp);	
					}
				}
				else
				{
					$consulta="SELECT calificacion FROM 4162_calCriterioBloque WHERE idPonderacion=".$idPonderacion." AND idUsuario=".$idUsuario;
					$valor=$con->obtenerValor($consulta);
					if($valor=="")
						$valor=0;
					
					$nNodoComp=$nodoHijo.',"value":"'.$idPonderacion.'_'.$idUsuario.'_'.number_format($valor,2,'.',',').'_1_0_'.$hijo["idEvaluacion"].'"';	
					array_push($arrNodos,$nNodoComp);
				}
				
				

			}
		}
		return $arrNodos;
	}
	
	function obtenerBloquesMateria()
	{
		global $con;
		$idMateria=bD($_POST["idMateria"]);
		$idGrupo=$_POST["idGrupo"];
		$consulta="SELECT noParciales FROM 4502_Materias WHERE idMateria=".$idMateria ;
		$filaMateria=$con->obtenerPrimeraFila($consulta);
		$bloques=$filaMateria[0];
		$tipoBloque=0;
		
		$arrBloques="";
		if($tipoBloque==0)
		{
			for($nBloque=1;$nBloque<=$bloques;$nBloque++)
			{
				$obj="['".$nBloque."','".$nBloque."']";
				if($arrBloques=="")
					$arrBloques=$obj;
				else
					$arrBloques.=",".$obj;
			}
		}
		else
		{
			$consulta="select idTema,nombreTema from 4039_temas where idPadre=-".$idMateria;
			$resTema=$con->obtenerFilas($consulta);
			while($filaTema=mysql_fetch_row($resTema))
			{
				$obj="['".$filaTema[0]."','".$filaTema[1]."']";
				if($arrBloques=="")
					$arrBloques=$obj;
				else
					$arrBloques.=",".$obj;
			}
		}
		echo "1|[".uEJ($arrBloques)."]";
	}
	
	function guardarCalificacionCriterio()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$idPonderacion=$_POST["idPonderacion"];
		$valor=$_POST["valor"];
		$tipoAsiento=$_POST["tipoAsiento"];
		$idGrupo=$_POST["idGrupo"];
		
		switch($tipoAsiento)
		{
			case 0: //asiento directo
				
				$conDatos="SELECT *FROM 4152_ponderacionCriterios WHERE idPonderacion=".$idPonderacion;
				$datos=$con->obtenerPrimeraFila($conDatos);
				
				$idPadre=$datos[8];
				
				$conEsquemaB="SELECT pondCriteriosEq FROM 4155_confBloquesMateria WHERE bloque=".$datos[3]." AND idMateria=".$datos[7]." AND idGrupo=".$datos[6];
				$esquemaE=$con->obtenerValor($conEsquemaB);
				
				//$consulta="select valor from 4152_ponderacionCriterios where idPonderacion=".$idPonderacion;
//				$filaPond=$con->obtenerPrimeraFila($consulta);
				
				if($esquemaE==1)
				{	
					$valorReal=$valor;
				}
				else
				{
					$valorReal=($datos[2]*$valor)/100;
				}
				
				$consulta="select idCalCriterioBloque from 4162_calCriterioBloque where idPonderacion=".$idPonderacion." and idUsuario=".$idUsuario;
				$filaCal=$con->obtenerPrimeraFila($consulta);
				if($filaCal)
					$consulta="update 4162_calCriterioBloque set calificacion=".$valor.",valorReal=".$valorReal.",ponderacion=".$datos[2]." where  idUsuario=".$idUsuario." and idPonderacion=".$idPonderacion;
				else		
					$consulta="insert into 4162_calCriterioBloque(calificacion,valorReal,ponderacion,idUsuario,idPonderacion) values(".$valor.",".$valorReal.",".$datos[2].",".$idUsuario.",".$idPonderacion.")";
					
				//echo $consulta;
				
				if($con->ejecutarConsulta($consulta))
				{
					
					if($idPadre==0)
					{
						$conGrupo="SELECT idGrupo FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$datos[7]." AND idUsuario=".$idUsuario;
						$idGrupo=$con->obtenerValor($conGrupo);
						
						//echo calcularCalificacionBloque($datos[7],$idGrupo,$idUsuario,$datos[3]);
						
						if(calcularCalificacionBloque($datos[7],$idGrupo,$idUsuario,$datos[3]))
						{
							echo "1|".number_format($valor,2,'.',',');	
							//echo "1|".$calificacionR."|".$calAnterior."|".$valor;
						}
					}
					else
					{
						if(calcularCalificacionPadre($idPadre,$datos[3],$idUsuario,$esquemaE))
						{
							//echo "entra de regreso";
							$conGrupo="SELECT idGrupo FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$datos[7]." AND idUsuario=".$idUsuario;
							$idGrupo=$con->obtenerValor($conGrupo);
							
							if(calcularCalificacionBloque($datos[7],$idGrupo,$idUsuario,$datos[3]))
							{
								//echo "entra";
								//echo "1|".$calificacionR."|".$calAnterior."|".$valor;
								echo "1|".number_format($valor,2,'.',',');	
							}
							else
							{
								echo "2|";
							}
						}
						else
						{
							echo "2|";
						}
					}
					//return;
					//guardar calificacion
					//echo "1|".number_format($valor,2,'.',',');			
				}
			break;
			case 1: //total entregados
				$consulta="SELECT totalSolicitados,totalConsiderar FROM 4199_evidenciasBloque WHERE idPonderacion=".$idPonderacion." and idGrupo=".$idGrupo;
				//echo $consulta;
				$fila=$con->obtenerPrimeraFila($consulta);
				if(!$fila)
				{
					echo "2|Algunos de los datos solicitados no son correctos";
				}
				else
				{
					//datos de la ponderacion
					$datosPon="SELECT *FROM 4152_ponderacionCriterios WHERE idPonderacion=".$idPonderacion;
					$datos=$con->obtenerPrimeraFila($datosPon);
					
					//tiene padre
					$conPadre="SELECT idPadre FROM 4152_ponderacionCriterios WHERE idPonderacion=".$idPonderacion;
					$idPadre=$con->obtenerValor($conPadre);
					//if($idPadre==0)
					//{
						if($valor>$fila[1])
						{
							echo "2|El Total entregados no puede  ser mayor al  Total a considerar";
							return;
						}
						
						//tipo de esquema del bloque
						$conEsquemaB="SELECT pondCriteriosEq FROM 4155_confBloquesMateria WHERE bloque=".$datos[3]." AND idMateria=".$datos[7]." AND idGrupo=".$datos[6];
						$esquemaE=$con->obtenerValor($conEsquemaB);
						
						$regla="-1";
						if($esquemaE==1)
						{
							$conRegla="SELECT regla FROM 4156_confBloquesCriterio WHERE idCriterioEvaluacionExtra=".$idPadre." AND bloque=".$datos[3];
							$regla=$con->obtenerValor($conRegla);
						}
						
						$calificacionR=($valor*10)/$fila[1];
						$valorReal=$calificacionR;
						if($esquemaE==0)
						{
							$valorReal=($calificacionR*$datos[2])/100;
						}
						
							$conExiste="SELECT idAlumnoEvidencia FROM 4210_alumnosVSEvidencia WHERE idPonderacion=".$idPonderacion." AND idUsuario=".$idUsuario;
							$id=$con->obtenerValor($conExiste);
							if($id=="")
							{
								$query="INSERT INTO 4210_alumnosVSEvidencia(idUsuario,idPonderacion,noEvidencias)  VALUES('".$idUsuario."','".$idPonderacion."','".$valor."')";
							}
							else
							{
								$query="UPDATE 4210_alumnosVSEvidencia SET noEvidencias='".$valor."' WHERE idAlumnoEvidencia=".$id;
							}
							if($con->ejecutarConsulta($query))
							{
								
							$consulta="select idCalCriterioBloque,calificacion from 4162_calCriterioBloque where idPonderacion=".$idPonderacion." and idUsuario=".$idUsuario;
							$filaCal=$con->obtenerPrimeraFila($consulta);
							if($filaCal)
							{
								$consulta="update 4162_calCriterioBloque set calificacion=".$calificacionR.",valorReal=".$valorReal.",ponderacion=".$datos[2]." where  idUsuario=".$idUsuario." and idPonderacion=".$idPonderacion;
								$calAnterior=$filaCal[1];
							}
							else		
							{
								$consulta="insert into 4162_calCriterioBloque(calificacion,valorReal,ponderacion,idUsuario,idPonderacion) values(".$calificacionR.",".$valorReal.",".$datos[2].",".$idUsuario.",".$idPonderacion.")";
								$calAnterior=$calificacionR;
							}
						
							//echo $consulta;
								if($con->ejecutarConsulta($consulta))
								{
										
									if($idPadre==0)
									{
										$conGrupo="SELECT idGrupo FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$datos[7]." AND idUsuario=".$idUsuario;
										$idGrupo=$con->obtenerValor($conGrupo);
										if(calcularCalificacionBloque($datos[7],$idGrupo,$idUsuario,$datos[3]))
										{
											//echo "entra";
											echo "1|".$calificacionR."|".$calAnterior."|".$valor;
										}
										else
										{
											echo "2|";
										}
										//echo "1|".$calificacionR."|".$calAnterior."|".$valor;
									}
									else
									{
										if(calcularCalificacionPadre($idPadre,$datos[3],$idUsuario,$esquemaE))
										{
											//echo "entra de regreso";
											$conGrupo="SELECT idGrupo FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$datos[7]." AND idUsuario=".$idUsuario;
											$idGrupo=$con->obtenerValor($conGrupo);
											
											if(calcularCalificacionBloque($datos[7],$idGrupo,$idUsuario,$datos[3]))
											{
												//echo "entra";
												echo "1|".$calificacionR."|".$calAnterior."|".$valor;
											}
											else
											{
												echo "2|";
											}
										}
										else
										{
											echo "2|";
										}
									}
									return;
								}
								else
								{
										echo "|";
								}
							}
							
							echo "1|";
						//}
					//}
					//else
					//{
						
					//}
				}
			break;
			case 2: //total solicitados
				$consulta="select * from 4199_evidenciasBloque where idPonderacion=".$idPonderacion." and idGrupo=".$idGrupo;
				if($fila=$con->obtenerPrimeraFila($consulta))
				{
					$query="update 4199_evidenciasBloque set totalSolicitados=".$valor.",idGrupo=".$idGrupo." where idEvidenciasBloque=".$fila[0];
				}
				else
				{
					$query="insert into 4199_evidenciasBloque (idPonderacion,totalSolicitados,totalConsiderar,idGrupo) values('".$idPonderacion."','".$valor."',0,".$idGrupo.")";
				}
				
				if($con->ejecutarConsulta($query))
					echo "1|";
				else
					echo "2|";
			break;
			case 3: //total considerar
				$consulta="select * from 4199_evidenciasBloque where idPonderacion=".$idPonderacion." and idGrupo=".$idGrupo;
				//echo $consulta;
				if($fila=$con->obtenerPrimeraFila($consulta))
				{
					$query="update 4199_evidenciasBloque set totalConsiderar=".$valor.",idGrupo=".$idGrupo." where idEvidenciasBloque=".$fila[0];
				}
				else
				{
					$query="insert into 4199_evidenciasBloque (idPonderacion,totalSolicitados,totalConsiderar,idGrupo) values('".$idPonderacion."',0,".$valor.",".$idGrupo.")";
				}
				//echo $query;
				if($con->ejecutarConsulta($query))
					echo "1|";
				else
					echo "2|";
			break;
		}
		$consulta="select valor from 4152_ponderacionCriterios where idPonderacion=".$idPonderacion;
		switch($tipoAsiento)
		{
			case 0: //asiento directo
				$consulta="select valor from 4152_ponderacionCriterios where idPonderacion=".$idPonderacion;
				$filaPond=$con->obtenerPrimeraFila($consulta);
				$ponderacion=$filaPond[0];
				$valorReal=($ponderacion*$valor)/10;
				
				$conDatos="SELECT *FROM 4152_ponderacionCriterios WHERE idPonderacion=".$idPonderacion;
				$datos=$con->obtenerPrimeraFila($conDatos);
				
				$idPadre=$datos[8];
				
				$conEsquemaB="SELECT pondCriteriosEq FROM 4155_confBloquesMateria WHERE bloque=".$datos[3]." AND idMateria=".$datos[7]." AND idGrupo=".$datos[6];
				$esquemaE=$con->obtenerValor($conEsquemaB);
				
				//$consulta="select valor from 4152_ponderacionCriterios where idPonderacion=".$idPonderacion;
//				$filaPond=$con->obtenerPrimeraFila($consulta);
				
				if($esquemaE==1)
				{	
					$valorReal=$valor;
				}
				else
				{
					$valorReal=($datos[2]*$valor)/100;
				}
				
				$consulta="select idCalCriterioBloque from 4162_calCriterioBloque where idPonderacion=".$idPonderacion." and idUsuario=".$idUsuario;
				$filaCal=$con->obtenerPrimeraFila($consulta);
				if($filaCal)
					$consulta="update 4162_calCriterioBloque set calificacion=".$valor.",valorReal=".$valorReal.",ponderacion=".$datos[2]." where  idUsuario=".$idUsuario." and idPonderacion=".$idPonderacion;
				else		
					$consulta="insert into 4162_calCriterioBloque(calificacion,valorReal,ponderacion,idUsuario,idPonderacion) values(".$valor.",".$valorReal.",".$datos[2].",".$idUsuario.",".$idPonderacion.")";
					
				//echo $consulta;
				
				if($con->ejecutarConsulta($consulta))
				{
					
					if($idPadre==0)
					{
						$conGrupo="SELECT idGrupo FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$datos[7]." AND idUsuario=".$idUsuario;
						$idGrupo=$con->obtenerValor($conGrupo);
						
						//echo calcularCalificacionBloque($datos[7],$idGrupo,$idUsuario,$datos[3]);
						
						if(calcularCalificacionBloque($datos[7],$idGrupo,$idUsuario,$datos[3]))
						{
							echo "1|".number_format($valor,2,'.',',');	
							//echo "1|".$calificacionR."|".$calAnterior."|".$valor;
						}
					}
					else
					{
						if(calcularCalificacionPadre($idPadre,$datos[3],$idUsuario,$esquemaE))
						{
							//echo "entra de regreso";
							$conGrupo="SELECT idGrupo FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$datos[7]." AND idUsuario=".$idUsuario;
							$idGrupo=$con->obtenerValor($conGrupo);
							
							if(calcularCalificacionBloque($datos[7],$idGrupo,$idUsuario,$datos[3]))
							{
								//echo "entra";
								//echo "1|".$calificacionR."|".$calAnterior."|".$valor;
								echo "1|".number_format($valor,2,'.',',');	
							}
							else
							{
								echo "2|";
							}
						}
						else
						{
							echo "2|";
						}
					}
					//return;
					//guardar calificacion
					//echo "1|".number_format($valor,2,'.',',');			
				}
			break;
			case 1: //total entregados
				$consulta="SELECT totalSolicitados,totalConsiderar FROM 4199_evidenciasBloque WHERE idPonderacion=".$idPonderacion." and idGrupo=".$idGrupo;
				//echo $consulta;
				$fila=$con->obtenerPrimeraFila($consulta);
				if(!$fila)
				{
					echo "2|Algunos de los datos solicitados no son correctos";
				}
				else
				{
					//datos de la ponderacion
					$datosPon="SELECT *FROM 4152_ponderacionCriterios WHERE idPonderacion=".$idPonderacion;
					$datos=$con->obtenerPrimeraFila($datosPon);
					
					//tiene padre
					$conPadre="SELECT idPadre FROM 4152_ponderacionCriterios WHERE idPonderacion=".$idPonderacion;
					$idPadre=$con->obtenerValor($conPadre);
					//if($idPadre==0)
					//{
						if($valor>$fila[1])
						{
							echo "2|El Total entregados no puede  ser mayor al  Total a considerar";
							return;
						}
						
						//tipo de esquema del bloque
						$conEsquemaB="SELECT pondCriteriosEq FROM 4155_confBloquesMateria WHERE bloque=".$datos[3]." AND idMateria=".$datos[7]." AND idGrupo=".$datos[6];
						$esquemaE=$con->obtenerValor($conEsquemaB);
						
						$regla="-1";
						if($esquemaE==1)
						{
							$conRegla="SELECT regla FROM 4156_confBloquesCriterio WHERE idCriterioEvaluacionExtra=".$idPadre." AND bloque=".$datos[3];
							$regla=$con->obtenerValor($conRegla);
						}
						
						$calificacionR=($valor*10)/$fila[1];
						$valorReal=$calificacionR;
						if($esquemaE==0)
						{
							$valorReal=($calificacionR*$datos[2])/100;
						}
						
							$conExiste="SELECT idAlumnoEvidencia FROM 4210_alumnosVSEvidencia WHERE idPonderacion=".$idPonderacion." AND idUsuario=".$idUsuario;
							$id=$con->obtenerValor($conExiste);
							if($id=="")
							{
								$query="INSERT INTO 4210_alumnosVSEvidencia(idUsuario,idPonderacion,noEvidencias)  VALUES('".$idUsuario."','".$idPonderacion."','".$valor."')";
							}
							else
							{
								$query="UPDATE 4210_alumnosVSEvidencia SET noEvidencias='".$valor."' WHERE idAlumnoEvidencia=".$id;
							}
							if($con->ejecutarConsulta($query))
							{
								
							$consulta="select idCalCriterioBloque,calificacion from 4162_calCriterioBloque where idPonderacion=".$idPonderacion." and idUsuario=".$idUsuario;
							$filaCal=$con->obtenerPrimeraFila($consulta);
							if($filaCal)
							{
								$consulta="update 4162_calCriterioBloque set calificacion=".$calificacionR.",valorReal=".$valorReal.",ponderacion=".$datos[2]." where  idUsuario=".$idUsuario." and idPonderacion=".$idPonderacion;
								$calAnterior=$filaCal[1];
							}
							else		
							{
								$consulta="insert into 4162_calCriterioBloque(calificacion,valorReal,ponderacion,idUsuario,idPonderacion) values(".$calificacionR.",".$valorReal.",".$datos[2].",".$idUsuario.",".$idPonderacion.")";
								$calAnterior=$calificacionR;
							}
						
							//echo $consulta;
								if($con->ejecutarConsulta($consulta))
								{
										
									if($idPadre==0)
									{
										echo "1|".$calificacionR."|".$calAnterior."|".$valor;
									}
									else
									{
										if(calcularCalificacionPadre($idPadre,$datos[3],$idUsuario,$esquemaE))
										{
											//echo "entra de regreso";
											$conGrupo="SELECT idGrupo FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$datos[7]." AND idUsuario=".$idUsuario;
											$idGrupo=$con->obtenerValor($conGrupo);
											
											if(calcularCalificacionBloque($datos[7],$idGrupo,$idUsuario,$datos[3]))
											{
												//echo "entra";
												echo "1|".$calificacionR."|".$calAnterior."|".$valor;
											}
											else
											{
												echo "2|";
											}
										}
										else
										{
											echo "2|";
										}
									}
									return;
								}
								else
								{
										echo "|";
								}
							}
							
							echo "1|";
						//}
					//}
					//else
					//{
						
					//}
				}
			break;
			case 2: //total solicitados
				$consulta="select * from 4199_evidenciasBloque where idPonderacion=".$idPonderacion." and idGrupo=".$idGrupo;
				if($fila=$con->obtenerPrimeraFila($consulta))
				{
					$query="update 4199_evidenciasBloque set totalSolicitados=".$valor.",idGrupo=".$idGrupo." where idEvidenciasBloque=".$fila[0];
				}
				else
				{
					$query="insert into 4199_evidenciasBloque (idPonderacion,totalSolicitados,totalConsiderar,idGrupo) values('".$idPonderacion."','".$valor."',0,".$idGrupo.")";
				}
				
				if($con->ejecutarConsulta($query))
					echo "1|";
				else
					echo "2|";
			break;
			case 3: //total considerar
				$consulta="select * from 4199_evidenciasBloque where idPonderacion=".$idPonderacion." and idGrupo=".$idGrupo;
				//echo $consulta;
				if($fila=$con->obtenerPrimeraFila($consulta))
				{
					$query="update 4199_evidenciasBloque set totalConsiderar=".$valor.",idGrupo=".$idGrupo." where idEvidenciasBloque=".$fila[0];
				}
				else
				{
					$query="insert into 4199_evidenciasBloque (idPonderacion,totalSolicitados,totalConsiderar,idGrupo) values('".$idPonderacion."',0,".$valor.",".$idGrupo.")";
				}
				//echo $query;
				if($con->ejecutarConsulta($query))
					echo "1|";
				else
					echo "2|";
			break;
		}
		
	}
	
	function guardarCatalogosSesion()
	{
		global $con;
		$cadena=$_POST["cadenaElementos"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		$idMateria=$_POST["idMateria"];
		$noSesion=$_POST["noSesion"];
		$tipoSesion=$_POST["tipoSesion"];
		$fecha=$_POST["fecha"];
		$idTabla=$_POST["id"];
		$tabla=$_POST["ntabla"];
		
		$idGrupo=0;
		if(isset($_POST["idGrupo"]))
		{
			$idGrupo=$_POST["idGrupo"];
			if($idGrupo=="")
				$idGrupo=0;
		}
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
				
			for($y=0;$y<$tamano;$y++) 
			{
				$idArreglo=$arreglo[$y];
					
					$consulta="select ".$idTabla." from ".$tabla." where noSesion='".$noSesion."'and ".$idTabla."='".$idArreglo."' and idMateria=".$idMateria." and idGrupo=".$idGrupo." and fecha='".$fecha."'";
					$valor=$con->ObtenerValor($consulta);
					if($valor=="")		
					{
						$query[$ct]="insert into ".$tabla."(noSesion,".$idTabla.",idMateria,idGrupo,fecha) values 
									('".$noSesion."','".$idArreglo."','".$idMateria."','".$idGrupo."','".$fecha."')";
						$ct++;
					}
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "2|";
		}
	}
	
	function guardarMaterialesUnidad()
	{
		
		global $con;
		
		$materiales=$_POST["cadena"];
		$arregloMateriales=explode(",",$materiales);
		$tamanoMateriales=sizeof($arregloMateriales);
		
		$unidades=$_POST["cadenaU"];
		$arregloUnidades=explode(",",$unidades);
		$tamanoUnidad=sizeof($arregloUnidades);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamanoUnidad;$x++) 
			{
				$idUnidad=$arregloUnidades[$x];
				
				for($y=0;$y<$tamanoMateriales;$y++) 
				{
					$idMaterial=$arregloMateriales[$y];
						
						$consulta="select idMaterialVSArea from 4147_materialesUnidad where idUnidad=".$idUnidad." and idMaterial=".$idMaterial;
						$nomTema=$con->ObtenerValor($consulta);
						if($nomTema=="")		
						{
							$query[$ct]="insert into 4147_materialesUnidad(idUnidad,idMaterial) values 
										('".$idUnidad."','".$idMaterial."')";
							$ct++;
						}
				}
			}
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "2|";
		}
	}
	
	function resetearSesion()
	{
		global $con;  
		$tipoHorario=$_POST["tipoHorario"];
		$noSesion=$_POST["noSesion"];
		$tipoSesion=$_POST["tipoSesion"];
 	    $fecha=$_POST["fecha"];  
        $idGrupo=$_POST["idGrupo"];
		$idMateria=$_POST["idMateria"];
		$horaIni=$_POST["horaIni"];
		$horaFin=$_POST["horaFin"];
		$idMapaCurricular=$_POST["idMapaCurricular"];
		$cadenaGuardar=$_POST["cadenaGuardar"];
		$idUsuario=$_SESSION["idUsr"];
		
		
		$conPrograma="select idPrograma,ciclo from 4029_mapaCurricular where idMapaCurricular=".$idMapaCurricular ;
		$datos=$con->obtenerPrimeraFila($conPrograma);
		$conMateria="SELECT titulo FROM 4013_materia WHERE idMateria=".$idMateria ;
	    $nombre=$con->obtenerValor($conMateria);
	    $cadena="sesion".$noSesion."_".$nombre;
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			if($tipoHorario==1)
			{
				$query[$ct]="update 4053_sesiones set tipoSesion=1000 where noSesion=".$noSesion." and fecha='".$fecha."' and  idMateria=".$idMateria." and idGrupo=".$idGrupo;
				$ct++;
			}
			else
			{
				$query[$ct]="update 4053_sesiones set tipoSesion=1000,fecha='2010-01-01',horaInicio='00:00:00',horaFin='00:00:00' where noSesion=".$noSesion." and fecha='".$fecha."' and  idMateria=".$idMateria." and idGrupo=".$idGrupo;
				$ct++;
			}	
				
			if($tipoSesion==2)	
			{
				$conAreaRecurso="SELECT idArea FROM 4142_areasPracticasMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND noSesion=".$noSesion;
				$idRecurso=$con->obtenerValor($conAreaRecurso);
				if($idRecurso=="")
				{
					$idRecurso="-1";
				}
				
				$conAreaPractica="SELECT idAreaPracticaVSMateria FROM 4142_areasPracticasMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND noSesion=".$noSesion;
				$idArea=$con->obtenerValor($conAreaPractica);
				if($idArea=="")
				{
					$idArea="-1";
				}
				
				$conUnidades="SELECT idUnidadVSAreaPractica FROM 4143_unidadesVSAreasPracticas WHERE idArea=".$idArea;
				$resU=$con->obtenerFilas($conUnidades);
				
				while($fUnidad=mysql_fetch_row($resU))
				{
					$query[$ct]="DELETE FROM 4147_materialesUnidad WHERE idUnidad=".$fUnidad[0];
					$ct++;
					$query[$ct]="DELETE FROM 4143_unidadesVSAreasPracticas WHERE idUnidadVSAreaPractica=".$fUnidad[0];
					$ct++;
				}
				
				$query[$ct]="DELETE FROM 4142_areasPracticasMateria WHERE idAreaPracticaVSMateria=".$idArea;
				$ct++;
			}
				
				$query[$ct]="update 4098_apartaRecursos set estadoRecurso=0 where idUsrApartador=".$idUsuario." and tipo=1 and evento='".$cadena."' and fecha='".$fecha."' and horaInicio='".$horaIni."' and horaFin='".$horaFin."'";
				$ct++;
				
				if($cadenaGuardar!="")
				{
					$arregloObj=json_decode($cadenaGuardar);
					foreach($arregloObj as $obj)
					{
						$campo=$obj->idControl;
						$valor=$obj->valor;
						
						$conExiste="SELECT idPlaneacionSesion FROM 4193_planeacionSesion WHERE campo=".$campo." AND noSesion=".$noSesion." AND fecha='".$fecha."'";
						$existe=$con->obtenerValor($conExiste);
						
						$query[$ct]="DELETE FROM 4193_planeacionSesion WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND noSesion=".$noSesion." AND fecha='".$fecha."' and campo=".$campo;
						//if($existe=="")
//						{
//							$query[$ct]="INSERT INTO 4193_planeacionSesion(idMateria,idGrupo,noSesion,fecha,campo,valor) VALUES(".cv($idMateria).",".cv($idGrupo).",".cv($noSesion).",'".cv($fecha)."',".cv($campo).",'".cv($valor)."') ";
//						}
//						else
//						{
//							$query[$ct]="UPDATE 4193_planeacionSesion SET valor='".cv($valor)."' WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND noSesion=".$noSesion." AND fecha='".$fecha."' AND campo=".$campo;
//						}
						$ct++;
						
					}
				
				}
				$query[$ct]="DELETE FROM 4181_sesionVSActitudes WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND noSesion=".$noSesion." AND fecha='".$fecha."'" ;
				$ct++;
				
				$query[$ct]="DELETE FROM 4182_sesionVSHabilidades WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND noSesion=".$noSesion." AND fecha='".$fecha."'" ;
				$ct++;
				
				$query[$ct]="DELETE FROM 4183_sesionVSCompetencia WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND noSesion=".$noSesion." AND fecha='".$fecha."'" ;
				$ct++;
				
				$query[$ct]="DELETE FROM 4184_sesionVSProductos WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND noSesion=".$noSesion." AND fecha='".$fecha."'" ;
				$ct++;
				
				$query[$ct]="DELETE FROM 4054_sesionesVSTemario WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND noSesion=".$noSesion." AND fecha='".$fecha."'" ;
				$ct++;
				
				$query[$ct]="DELETE FROM 4191_avisosMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND noSesion=".$noSesion." AND fecha='".$fecha."'" ;
				$ct++;
				
				$query[$ct]="DELETE FROM 4192_enlacesMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND noSesion=".$noSesion." AND fecha='".$fecha."'" ;
				$ct++;
				
				$query[$ct]="DELETE FROM 4166_tareasMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND noSesion=".$noSesion ;
				$ct++;
				
				$query[$ct]="DELETE FROM 4051_materialesVSTema WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND noSesion=".$noSesion." AND fecha='".$fecha."'" ;
				$ct++;
				
				$query[$ct]="commit";
				
				if($con->ejecutarBloque($query))
					echo "1|".$datos[0]."|".$datos[1];
				else
					echo"21";
	    }
	}
	
	function llenarVentanaMotivo()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$noSesion=$_POST["noSesion"];
		$horaInicio=$_POST["horaInicio"];
		$horaFin=$_POST["horaFin"];
		$fecha=$_POST["fecha"];
		$fecha=cambiaraFechaMysql($fecha);
		$consulta="SELECT motivo FROM 4197_motivoCancSesion WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND noSesion=".$noSesion." AND fecha='".$fecha."' AND horaInicio='".$horaInicio."' AND horaFin='".$horaFin."'";
		$motivo=$con->obtenerValor($consulta);
		
		echo "1|".$motivo;
	}
	
	function obtenerBloquesMateria2()
	{
		global $con;
		$bloque=$_REQUEST["bloque"];
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		
		$arreglo="";
		
		//consulta="SELECT bloque,nombre,1 AS existe FROM  4198_configuracionEspBloque WHERE bloque=1 AND idMateria=".$idMateria." AND idGrupo=".$idGrupo;
//		$arreglo=$con->obtenerFilasArreglo($consulta);
		
		$consulta="SELECT noParciales FROM 4502_Materias WHERE idMateria=".$idMateria ;
		//echo $conTipoB;
		$fila=$con->obtenerPrimeraFila($consulta);
		if(true)
		{
			
				$noBloques=$fila[0];
				if($noBloques=="")
					$noBloques=0;
				
				if($noBloques!=0)
				{
					if($bloque==0)
						$bloque=$noBloques+1;
				}
				
				for($x=1;$x<=$noBloques;$x++)
				{
					if($x<$bloque)
					{
						$obj="[".$x.",".$x.",1]";
						
						if($arreglo=="")
							$arreglo=$obj;
						else
							$arreglo.=",".$obj;
					}
				}
			
		}
	
		echo "1|[".$arreglo."]";
	}
	
	function guardarConfEspecial()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$bloque=$_POST["bloque"];
		$cadena=$_POST["cadena"];
		$nombre=$_POST["nombre"];
		$descripcion=$_POST["descripcion"];
		$id=0;
		if(isset($_POST["id"]))
			$id=$_POST["id"];
		
		if($id==0)
		{
			$query="INSERT INTO 4198_configuracionEspBloque(idMateria,idGrupo,nombre,descripcion,bloque,idBloquesPromedio) 
						VALUES('".$idMateria."','".$idGrupo."','".$nombre."','".$descripcion."','".$bloque."','".$cadena."')";
		}
		else
		{
			$query="UPDATE 4198_configuracionEspBloque SET nombre='".$nombre."',descripcion='".$descripcion."',idBloquesPromedio='".$cadena."' WHERE idBloqueConfEsp=".$id;
		}
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerDatosConfEspecial()
	{
		global $con;
		$id=$_POST["id"];
		
		$consulta="SELECT *FROM 4198_configuracionEspBloque WHERE idBloqueConfEsp=".$id;
		$filaE=$con->obtenerPrimeraFila($consulta);
		if($filaE)
		{
			$arreglo="";
			$arregloBloques="";
			$conTipoB="select esquemaEvaluacion,bloques from 4013_materia where idMateria=".$filaE[1];
			$fila=$con->obtenerPrimeraFila($conTipoB);
			if($fila[0]==1)
			{
				$conBloques="SELECT idTema,nombreTema FROM 4039_temas WHERE idPadre=-50";//.$filaE[1];
				$res=$con->obtenerFilas($conBloques);
				$noBloques=$con->filasAfectadas;
				$arregloTemas=$con->obtenerFilasArregloPHP($conBloques);
			}
			else
			{
				if($fila[1]==1000)
				{
					$conBloques="select noBloques from 4195_bloquesMateria where idMateria=".$filaE[1]." and idGrupo=".$filaE[2];
					$noBloques=$con->obtenerValor($conBloques);
					if($noBloques=="")
						$noBloques=0;
				}
				else
				{
					$noBloques=$fila[1];
				}
			}
			
			
			for($x=1;$x<=$noBloques;$x++)
			{
				$obj="[".$x."]";
				
				if($arregloBloques=="")
					$arregloBloques=$obj;
				else
					$arregloBloques.=",".$obj;
			}
			$arregloBloques="[".$arregloBloques."]";
			
			if($fila[0]==0)
			{
				$cadena=explode(",",$filaE[6]);
				for($x=1;$x<=$noBloques;$x++)
				{
					if(existeValor($cadena,$x))
					{
						$existe=1;
					}
					else
					{
						$existe=0;
					}
					if($arreglo=="")
						$arreglo="['".$x."','".$x."','".$existe."']";
					else
						$arreglo.=",['".$x."','".$x."','".$existe."']";
				}
				$arreglo="[".$arreglo."]";
				
				echo "1|".$arreglo."|".$filaE[5]."|".$filaE[3]."|".$filaE[4];
			}
			else
			{
				$tamano=sizeof($arregloTemas);
				for($x=0;$x<$tamano;$x++)
				{
					$elemento=$arregloTemas[$x];
					$nbloque=$elemento[0];
					
					$obj="[".$nbloque."]";
					
					if($arregloBloques=="")
						$arregloBloques=$obj;
					else
						$arregloBloques.=",".$obj;
				}
			$arregloBloques="[".$arregloBloques."]";
			
				
				for($y=0;$y<$tamano;$y++)
				{
					$elemento=$arregloTemas[$y];
					$nbloque=$elemento[0];
					$nombreB=$elemento[1];
					
					if(existeValor($arregloBloques,$nbloque))
					{
						$existe=1;
					}
					else
					{
						$existe=0;
					}
					if($arreglo=="")
						$arreglo="['".$nbloque."','".$nombreB."','".$existe."']";
					else
						$arreglo.=",['".$nbloque."','".$nombreB."','".$existe."']";
						
				}
				echo "1|[".$arreglo."]|".$filaE[5]."|".$filaE[3]."|".$filaE[4];
			
			}
		}
		else
		{
			echo "|";
		}
	
	}
	
	function eliminarConfEspecial()
	{
		global $con;
		$id=$_POST["id"];
		
		$query="DELETE FROM 4198_configuracionEspBloque WHERE idBloqueConfEsp=".$id;
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	
	}
	
	function calcularCalificacionPadre($idPadre,$bloque,$idUsuario,$esquemaBloque)
	{
		global $con;
		
		$datosPonderacionPadre="SELECT *FROM 4156_criteriosEvaluacionExtra WHERE idCriterioEvaluacionExtra=".$idPadre;
		//echo $datosPonderacionPadre;
		$datosPadre=$con->obtenerPrimeraFila($datosPonderacionPadre);
		
		$conIdPonderacionPadre="SELECT *FROM 4152_ponderacionCriterios WHERE idMateria=".$datosPadre[3]." AND idGrupo=".$datosPadre[2]." AND idEvaluacion=".$datosPadre[1]." AND bloque=".$bloque;
		//echo $conIdPonderacionPadre;
		$filaPadre=$con->obtenerPrimeraFila($conIdPonderacionPadre);
		if(!$filaPadre)
		{
			return true;		
		}
		
		$idPonderacion=$filaPadre[0];
		$idPadrePon=$filaPadre[8];
		
		$consulta="SELECT *FROM 4152_ponderacionCriterios WHERE idPadre=".$idPadre." AND bloque=".$bloque." and solicitarCalificacion=1";
		//echo $consulta;
		$resHermanos=$con->obtenerFilas($consulta);
		
		$conDatos="SELECT pondCriteriosEq,regla FROM 4156_confBloquesCriterio WHERE idCriterioEvaluacionExtra=".$idPadre." AND bloque=".$bloque;
		$datos=$con->obtenerPrimeraFila($conDatos);
		if(!$datos)
		{
			return true;
		}
		
		$esquemaE=$datos[0];
		$regla=$datos[1];
		$nEvidTotal=0;
		$sumaCal=0;
		$totalEvidC=0;
		$calCriterio=0;
		$nCal=0;
		
		while($filaH=mysql_fetch_row($resHermanos))
		{
			$conCal="select calificacion,valorReal from 4162_calCriterioBloque where idPonderacion=".$filaH[0]." and idUsuario=".$idUsuario;
			//echo $conCal;
			$calH=$con->obtenerPrimeraFila($conCal);
			if($calH=="")
			{
				return true;
			}
			
			if($esquemaE==1)
			{
				if($regla==0)
				{
					$conExiste="SELECT noEvidencias FROM 4210_alumnosVSEvidencia WHERE idPonderacion=".$filaH[0]." AND idUsuario=".$idUsuario;
					$nEvidencias=$con->obtenerValor($conExiste);
					if($nEvidencias=="")
					{
						return true;
					}
					
					$conTotalC="SELECT totalConsiderar FROM  4199_evidenciasBloque WHERE idPonderacion=".$filaH[0];
					$totalC=$con->obtenerValor($conTotalC);
					if($totalC=="")
					{
						return true;
					}
					
					$nEvidTotal=$nEvidTotal+$nEvidencias;
					$totalEvidC=$totalEvidC+$totalC;
				}
				else
				{
					$sumaCal=$sumaCal+$calH[0];
					$nCal=$nCal+1;
				}
			}
			else
			{
				$sumaCal=$sumaCal+$calH[1];
			}
		}
		
		if($esquemaE==1)
		{
			if($regla==0)
			{
				$calCriterio=($nEvidTotal*10)/$totalEvidC;
			}
			else
			{
				$calCriterio=$sumaCal/$nCal;
			}
			//$valorReal=$calCriterio;
		}
		else
		{
			$calCriterio=$sumaCal;
			//$valorReal=$calCriterio;
		}
		
		if($esquemaBloque==1)
		{
			$valorReal=$calCriterio;
		}
		else
		{
			$valorReal=($calCriterio*$filaPadre[2])/100;
		}
		
		
		$consulta="select idCalCriterioBloque,calificacion from 4162_calCriterioBloque where idPonderacion=".$idPonderacion." and idUsuario=".$idUsuario;
		//echo $consulta;
		$filaCal=$con->obtenerPrimeraFila($consulta);
		if($filaCal)
		{
			$consulta="update 4162_calCriterioBloque set calificacion=".$calCriterio.",valorReal=".$valorReal.",ponderacion=".$filaPadre[2]." where  idUsuario=".$idUsuario." and idPonderacion=".$idPonderacion;
			$calAnterior=$filaCal[1];
		}
		else		
		{
			$consulta="insert into 4162_calCriterioBloque(calificacion,valorReal,ponderacion,idUsuario,idPonderacion) values(".$calCriterio.",".$valorReal.",".$filaPadre[2].",".$idUsuario.",".$idPonderacion.")";
			$calAnterior=$calCriterio;
		}
		
		//echo $consulta;
		if($con->ejecutarConsulta($consulta))
		{
			$conPadre="SELECT idPadre FROM 4152_ponderacionCriterios WHERE idPonderacion=".$idPadre;
			//echo $conPadre;
			$idPadre=$con->obtenerValor($conPadre);
			
			if(($idPadre!=0) && ($idPadre!=""))
			{
				return calcularCalificacionPadre($idPadre,$bloque,$idUsuario,$esquemaBloque);
			}
			else
			{
				return true;
			}
		}
	}
	
	function obtenerNumeroBloques($idMateria,$idGrupo)
	{
		global $con;
		$conTipoB="select esquemaEvaluacion,bloques from 4013_materia where idMateria=".$idMateria;
		$fila=$con->obtenerPrimeraFila($conTipoB);
		if($fila[0]==1)
		{
			$conBloques="SELECT idTema FROM 4039_temas WHERE idPadre=-".$idMateria;
			$filas=$con->obtenerFilas($conBloques);
			$noBloques=$con->filasAfectadas;
		}
		else
		{
			if($fila[1]==1000)
			{
				$conBloques="select noBloques from 4195_bloquesMateria where idMateria=".$idMateria." and idGrupo=".$idGrupo;
				$noBloques=$con->obtenerValor($conBloques);
				if($noBloques=="")
					$noBloques=0;
			}
			else
			{
				$noBloques=$fila[1];
			}
		}
		return $noBloques;
	}
	
	function asentarCalCriterio($cadenaCriterio,$idUsuario,$idMateria,$idGrupo,$bloque)
	{
		global $con;
		$datos=explode('_',$cadenaCriterio);
		$idPonderacion=$datos[0];
		$cal=$datos[1];
		$valorReal=$datos[2];
		$ponderacion=$datos[3];
		$conExiste="SELECT idCalCriterioBloque FROM 4162_calCriterioBloque WHERE idPonderacion=".$idPonderacion." and idUsuario=".$idUsuario ;
		$id=$con->obtenerValor($conExiste);
		$ct=0;
		if($id=="")
		{
			$query[$ct]="insert into 4162_calCriterioBloque(idPonderacion,calificacion,valorReal,idUsuario) values ('".$idPonderacion."','".$cal."','".$valorReal."','".$idUsuario."')";
			//echo $query[$ct];
			$ct++;
		}
		else
		{
			$query[$ct]="update 4162_calCriterioBloque set calificacion='".$cal."',valorReal=".$valorReal." where idCalCriterioBloque=".$id ;
			//echo $query[$ct];
			$ct++;
		}
		
		if($con->ejecutarBloque($query))
		{
			return true;
		}
		else
			return false;
	}
	
	function calcularCalificacionBloque($idMateria,$idGrupo,$idUsuario,$bloque)
	{
		global $con;
		//echo "entra a calcular bloque".$bloque."<br>";
		//echo "idMateria".$idMateria;
		$conEsquema="SELECT pondCriteriosEq FROM 4155_confBloquesMateria WHERE idMateria=".$idMateria." AND (idGrupo=".$idGrupo." or idGrupo=-1) AND bloque=".$bloque;
		//echo $conEsquema;
		$esquema=$con->obtenerValor($conEsquema);
		
		if($bloque==0)
		{
			$promedioBloque=0;
			$totalElementos=0;
			
			//consulta para sacar las materias que tiene como criterio en este bloque
			$consulta="SELECT idPonderacion,idEvaluacion,valor FROM 4152_ponderacionCriterios WHERE idMateria=".$idMateria." AND (idGrupo=".$idGrupo." or idGrupo=-1) AND bloque=".$bloque." and tipoCriterio=1 and solicitarCalificacion=1";
			//echo $consulta;
			$res1=$con->obtenerFilas($consulta);
			$nMaterias=$con->filasAfectadas;
			$sumatoriaMaterias=0;
			
			if($nMaterias>0)
			{
				while($fMat=mysql_fetch_row($res1))
				{
					$conCalMat="SELECT calificacion FROM 4159_calificaciones WHERE idMateria=".$fMat[1]." AND idGrupo=".$idGrupo." AND idUsuario=".$idUsuario;
					
					$calMat=$con->obtenerValor($conCalMat);
					if($calMat=="")
					{
						return true;
					}
					else
					{
						if($esquema==1)
						{
							$sumatoriaMaterias=$sumatoriaMaterias+$calMat;
						}
						else
						{
							$sumatoria=($sumatoria+($calMat*($fMat[2]/100)));
						}
					}
				}
				
				if($esquema==1)
				{
					$sumatoriaMaterias=$sumatoriaMaterias/$nMaterias;
				}
			}
			
			$totalElementos=$totalElementos+$nMaterias;
			$promedioBloque=$promedioBloque+$sumatoriaMaterias;
			
			//obtener los criterios del bloque
			$conCrit="SELECT idPonderacion,valor FROM 4152_ponderacionCriterios WHERE idMateria=".$idMateria." AND (idGrupo=".$idGrupo." or idGrupo=-1) AND bloque=".$bloque." and tipoCriterio<>1 AND idEvaluacion<>0 and solicitarCalificacion=1";
			//echo $conCrit;
			$resCrit=$con->obtenerFilas($conCrit);
			$nCrit=$con->filasAfectadas;
			$sumatoriaCrit=0;
			if($nCrit>0)
			{
				$sumatoriaCrit=0;
				while($fCrit=mysql_fetch_row($resCrit))
				{
					$conCalCrit="SELECT valorReal FROM 4162_calCriterioBloque WHERE idPonderacion=".$fCrit[0]." AND idUsuario=".$idUsuario;
					//echo $conCalCrit;
					$calCrit=$con->obtenerValor($conCalCrit);
					if($calCrit=="")
					{
						return true;
					}
					else
					{
						$sumatoriaCrit=$sumatoriaCrit+$calCrit;
					}
				}
				
				if($esquema==1)
				{
					$sumatoriaCrit=$sumatoriaCrit/$nCrit;
				}
					
			}
			
			$totalElementos=$totalElementos+$nCrit;
			$promedioBloque=$promedioBloque+$sumatoriaCrit;
			
			//obtiene el promedio de los bloques
			$conBlq="SELECT idPonderacion FROM 4152_ponderacionCriterios WHERE idMateria=".$idMateria."  AND (idGrupo=".$idGrupo." or idGrupo=-1) AND bloque=".$bloque." AND idEvaluacion=0 and solicitarCalificacion=1";
			//echo $conBlq;
			$valor=$con->obtenerValor($conBlq);
			if($valor!="")
			{
				$sumatoriaBloques=calcularCalBloquesMateria($idMateria,$idGrupo,$idUsuario,$bloque);
				//echo $sumatoriaBloques;
				//echo "promediodebloques".$sumatoriaBloques;
				if($sumatoriaBloques==-1)
				{
					return true; 
				}
				else
				{
					//if($esquema==0)
//					{
//						$sumatoriaBloques=($sumatoriaBloques*$valor/100);
//					}
//					else
//					{
//						$sumatoriaBloques=$sumatoriaBloques;
//					}
//					
//					$nCrit=$nMaterias+1;
					$promedioBloque=$promedioBloque+$sumatoriaBloques;
					$totalElementos=$totalElementos+1;
				}
				
				//echo $promedioBloque;
				//echo $totalElementos;
				//echo $totalElementos;
			}
			
			if($esquema==1)
			{
				$promedioBloque=$promedioBloque/$totalElementos;
			}
			//echo $promedioBloque;
			
			//CRITERIOS ESPECIALES
			$consultaE="SELECT idPonderacion,valor FROM 4152_ponderacionCriterios WHERE idMateria=".$idMateria." AND (idGrupo=".$idGrupo." or idGrupo=-1) AND bloque=".$bloque." and tipoCriterio=3 AND idEvaluacion=-1000 and solicitarCalificacion=1";
			//echo $consultaE;
			$resE=$con->obtenerFilas($consultaE);
			$filasEsp=$con->filasAfectadas;
			$filaEspecial=$con->obtenerPrimeraFila($consultaE);
			$sumatoriaCritEsp=0;
			
			if($filasEsp>0)
			{
				//echo "entra a criterios especiales";
				$confEspecial="SELECT idbloquesPromedio  FROM 4198_configuracionEspBloque WHERE idMateria=".$idMateria." AND (idGrupo=".$idGrupo." OR idGrupo=-1) AND bloque=".$bloque;
				$res=$con->obtenerFilas($confEspecial);
				$numBloquesE=$con->filasAfectadas;
				
				if($numBloquesE>0)
				{
					$promedioEspecial=0;
					$bloquesE=0;
					while($filaE=mysql_fetch_row($res))
					{
						$arrBloquesP=explode(",",$filaE[0]);
						$tamano=sizeof($arrBloquesP);
						
						$promedioCriterio=0;
						$elementoCriterio=0;
						for($x=0;$x<$tamano;$x++)						
						{
							$conBloqueE="SELECT calificacion FROM 4163_calBloqueMateria WHERE idMateria=".$idMateria." AND (idGrupo=".$idGrupo." OR idGrupo=-1) AND bloque=".$arrBloquesP[$x];
							$calBloqueE=$con->obtenerValor($conBloqueE);
							if($calBloqueE=="")
							{
								return true;
							}
							$promedioCriterio=$promedioCriterio+$calBloqueE;
							$elementoCriterio++;
							
						}
						$promedioCriterio=$promedioCriterio/$elementoCriterio;
						
						$promedioEspecial=$promedioEspecial+$promedioCriterio;
						$bloquesE++;	
					}
					
					$promedioEspecial=$promedioEspecial/$bloquesE;
					
					if($esquema==1)
					{
						$promedioBloque=($promedioBloque+$promedioEspecial)/2;
					}
					else
					{
						$promedioEspecial=($promedioEspecial*$filaEspecial[1])/100;
						$promedioBloque=$promedioBloque+$promedioEspecial;
					}
				}
			}
			return asentarCalificacionBloque($idMateria,$idGrupo,$idUsuario,$promedioBloque,$bloque);
		}
		else//calcular bloque diferenre a 0
		{
			$promedioBloque=0;
			$totalElementos=0;
			
			//sacar las materias que tiene como criterio
			$consulta="SELECT idPonderacion,idEvaluacion,valor FROM 4152_ponderacionCriterios WHERE idMateria=".$idMateria." AND (idGrupo=".$idGrupo." or idGrupo=-1) AND bloque=".$bloque." and tipoCriterio=1 and solicitarCalificacion=1";
			//echo $consulta;
			$res1=$con->obtenerFilas($consulta);
			$nMaterias=$con->filasAfectadas;
			$sumatoriaMaterias=0;
			
			if($nMaterias>0)
			{
				while($fMat=mysql_fetch_row($res1))
				{
					$conGrupo="SELECT idGrupo FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$fMat[1]." AND idUsuario=".$idUsuario;
					//echo $conGrupo;
					$idGrupoC=$con->obtenerValor($conGrupo);
					$conCalMat="select calificacion from 4163_calBloqueMateria where idMateria=".$fMat[1]."  and idGrupo=".$idGrupoC." and idUsuario=".$idUsuario." and bloque=".$bloque;
					//$conCalMat="SELECT calificacion FROM 4159_calificaciones WHERE idMateria=".$fMat[1]." AND idGrupo=".$idGrupo." AND idUsuario=".$idUsuario;
					//echo $conCalMat;
					$calMat=$con->obtenerValor($conCalMat);
					if($calMat=="")
					{
						return true;
					}
					else
					{
						if($esquema==1)
						{
							$sumatoriaMaterias=$sumatoriaMaterias+$calMat;
						}
						else
						{
							$sumatoriaMaterias=($sumatoriaMaterias+($calMat*($fMat[2]/100)));
						}
					}
				}
				
				if($esquema==1)
				{
					$sumatoriaMaterias=$sumatoriaMaterias/$nMaterias;
				}
			}
			
			//echo $sumatoriaMaterias;
			$promedioBloque=$promedioBloque+$sumatoriaMaterias;
			//echo "-".$promedioBloque."-";
			
			//CRITERIOS NORMALES DEL BLOQUE
			$consulta="SELECT idPonderacion FROM 4152_ponderacionCriterios WHERE idMateria=".$idMateria." AND (idGrupo=".$idGrupo." or idGrupo=-1) AND bloque=".$bloque." and tipoCriterio<>1 and tipoCriterio<>3 AND idEvaluacion<>0 and solicitarCalificacion=1 and idPadre=0";
			//echo $consulta;
			$res=$con->obtenerFilas($consulta);
			$filasCal=$con->filasAfectadas;
			$sumatoriaCrit=0;
			while($fila=mysql_fetch_row($res))
			{
				$conCalif="SELECT calificacion,valorReal FROM 4162_calCriterioBloque WHERE idPonderacion=".$fila[0]." AND idUsuario=".$idUsuario;
				//echo $conCalif;
				$calCri=$con->obtenerPrimeraFila($conCalif);
				if(!$calCri)
					return true;
					
				$sumatoriaCrit=$sumatoriaCrit+$calCri[1];
			}
			
			$promedioBloque=$promedioBloque+$sumatoriaCrit;
			//echo $promedioBloque;
			
			$totalElementos=$filasCal+$nMaterias;
			
			if($esquema==1)
			{
				$promedioBloque=$promedioBloque/$totalElementos;
			}
			
			//CRITERIOS ESPECIALES
			$consultaE="SELECT idPonderacion,valor FROM 4152_ponderacionCriterios WHERE idMateria=".$idMateria." AND (idGrupo=".$idGrupo." or idGrupo=-1) AND bloque=".$bloque." and tipoCriterio=3 AND idEvaluacion=-1000 and solicitarCalificacion=1";
			//echo $consultaE;
			$resE=$con->obtenerFilas($consultaE);
			$filasEsp=$con->filasAfectadas;
			$filaEspecial=$con->obtenerPrimeraFila($consultaE);
			$sumatoriaCritEsp=0;
			
			if($filasEsp>0)
			{
				//echo "entra a criterios especiales";
				$confEspecial="SELECT idbloquesPromedio  FROM 4198_configuracionEspBloque WHERE idMateria=".$idMateria." AND (idGrupo=".$idGrupo." OR idGrupo=-1) AND bloque=".$bloque;
				$res=$con->obtenerFilas($confEspecial);
				$numBloquesE=$con->filasAfectadas;
				
				if($numBloquesE>0)
				{
					$promedioEspecial=0;
					$bloquesE=0;
					while($filaE=mysql_fetch_row($res))
					{
						$arrBloquesP=explode(",",$filaE[0]);
						$tamano=sizeof($arrBloquesP);
						
						$promedioCriterio=0;
						$elementoCriterio=0;
						for($x=0;$x<$tamano;$x++)						
						{
							$conBloqueE="SELECT calificacion FROM 4163_calBloqueMateria WHERE idMateria=".$idMateria." AND (idGrupo=".$idGrupo." OR idGrupo=-1) AND bloque=".$arrBloquesP[$x];
							$calBloqueE=$con->obtenerValor($conBloqueE);
							if($calBloqueE=="")
							{
								return true;
							}
							$promedioCriterio=$promedioCriterio+$calBloqueE;
							$elementoCriterio++;
							
						}
						$promedioCriterio=$promedioCriterio/$elementoCriterio;
						
						$promedioEspecial=$promedioEspecial+$promedioCriterio;
						$bloquesE++;	
					}
					
					$promedioEspecial=$promedioEspecial/$bloquesE;
					
					if($esquema==1)
					{
						$promedioBloque=($promedioBloque+$promedioEspecial)/2;
					}
					else
					{
						$promedioEspecial=($promedioEspecial*$filaEspecial[1])/100;
						$promedioBloque=$promedioBloque+$promedioEspecial;
					}
				}
			}
			//echo $calBloque;
			return asentarCalificacionBloque($idMateria,$idGrupo,$idUsuario,$promedioBloque,$bloque);
		}
	}
	
	function asentarCalificacionBloque($idMateria,$idGrupo,$idUsuario,$cal,$bloque)
	{
		global $con;
		//echo $bloque;
		//echo "entra a asentarbloque".$bloque."<br>";
		$conTipoBloque="SELECT tipoBloque FROM 4155_confBloquesMateria WHERE idMateria=".$idMateria." AND (idGrupo=".$idGrupo." OR idGrupo=-1) AND bloque=".$bloque;
		//echo $conTipoBloque;
		$tipoBloque=$con->obtenerValor($conTipoBloque);
		if($tipoBloque=="")
			$tipoBloque=0;
		if($bloque==0)
		{
			$conExiste2="SELECT idCalBloqueMateria FROM 4163_calBloqueMateria WHERE bloque=".$bloque." AND idMateria=".$idMateria." AND idGrupo=".$idGrupo." and idUsuario=".$idUsuario ;
			//echo $conExiste2;
			$id2=$con->obtenerValor($conExiste2);
			if($id2=="")
			{
				$query="insert into 4163_calBloqueMateria(bloque,idMateria,idGrupo,calificacion,idUsuario,tipoBloque) values ('".$bloque."','".$idMateria."','".$idGrupo."','".$cal."','".$idUsuario."','".$tipoBloque."')";
			}
			else
			{
				$query="update 4163_calBloqueMateria set calificacion='".$cal."' where idCalBloqueMateria=".$id2 ;
			}
			//echo $query;
			//return calcularCalificacionFinalMateria($idMateria,$idGrupo,$idUsuario);
			
			$resultado=$con->ejecutarConsulta($query);
			if($resultado)
			{
				//echo "entra a resultado";
				return calcularCalificacionMateria($idMateria,$idGrupo,$idUsuario,$bloque,$cal);
			}
		}
		else
		{
			$conExiste2="SELECT idCalBloqueMateria FROM 4163_calBloqueMateria WHERE bloque=".$bloque." AND idMateria=".$idMateria." AND idGrupo=".$idGrupo." and idUsuario=".$idUsuario ;
			$id2=$con->obtenerValor($conExiste2);
			if($id2=="")
			{
				$query="insert into 4163_calBloqueMateria(bloque,idMateria,idGrupo,calificacion,idUsuario,tipoBloque) values ('".$bloque."','".$idMateria."','".$idGrupo."','".$cal."','".$idUsuario."','".$tipoBloque."')";
			}
			else
			{
				$query="update 4163_calBloqueMateria set calificacion='".$cal."' where idCalBloqueMateria=".$id2 ;
			}
			
			//echo $query;
			//return calcularCalificacionFinalMateria($idMateria,$idGrupo,$idUsuario);
			$resultado=$con->ejecutarConsulta($query);
			if($resultado)
			{
				$nbloquesMat=obtenerNumeroBloques($idMateria,$idGrupo);
				
				//preguntar si tengo padres y si me tienen como criterio de evaluacion
				$padresCriterio="select idPadre from 4031_elementosMapa where idMateria=".$idMateria." and idPadre<>0 and criterioEvaluacion=1";
				//echo $padresCriterio;
				$res=$con->obtenerFilas($padresCriterio);
				$numeroPadres=$con->filasAfectadas;
				//si tengo padres guardar la calificacion 
				if($numeroPadres>0)
				{
					calcularPadres($idMateria,$idGrupo,$cal,$idUsuario,$bloque,$res);
				}
				
				//preguntar si tengo padres que no me tengan como criterio de evaluacion
				$padresMat="select idPadre from 4031_elementosMapa where idMateria=".$idMateria." and idPadre<>0 and criterioEvaluacion=0";
				$res1=$con->obtenerFilas($padresMat);
				$numPadres=$con->filasAfectadas;
				//si tengo padres calcular padres 
				if($numPadres>0)
				{
					while($fPadre=mysql_fetch_row($res1))
					{
						$conGrupo="SELECT idGrupo FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$fPadre[0]." AND idUsuario=".$idUsuario;
						$idGrupo=$con->obtenerValor($conGrupo);
						
						$nbloquesPadre=obtenerNumeroBloques($fPadre[0],$idGrupo);
						
						if($nbloquesPadre==$nbloquesMat)
						{
							calcularMateriaContenedora($fPadre[0],$idGrupo,$idUsuario,$bloque);
						}
					}
				}
				
				if($bloque==$nbloquesMat)
				{
					//$conPonBloqueFinal="SELECT pondCriteriosEq FROM 4155_confBloquesMateria WHERE idMateria=".$idMateria." AND (idGrupo=".$idGrupo." OR idGrupo=-1) AND bloque=0";
//					//echo $conPonBloqueFinal;
//					$ponBloqueFinal=$con->obtenerValor($conPonBloqueFinal);
//					
//					if($ponBloqueFinal==1)
//					{
						
						return calcularCalificacionBloque($idMateria,$idGrupo,$idUsuario,0);
					//}
				}
				
				//return true;//calcularCalificacionMateria($idMateria,$idGrupo,$idUsuario,$bloque,$cal);
				$conPadreGrado="SELECT idGrado FROM 4031_elementosMapa WHERE idMateria=".$idMateria." and idPadre=0";
				$idGrado=$con->obtenerValor($conPadreGrado);	
				if($idGrado)
				{
					return calcularGrado($idGrado,$idGrupo,$idUsuario);
				}
				else
				{
					return true;
				}
			}
		}
	}
	
	
	function calcularCalificacionMateria($idMateria,$idGrupo,$idUsuario,$bloque,$cal)
	{
		global $con;
		//echo "entra a calcularCalificacionMateria";
		//$resultadoCalMat=calcularCalBloquesMateria($idMateria,$idGrupo,$idUsuario,$bloque);
		//echo $resultadoCalMat;
		$consulta="SELECT calificacion FROM 4163_calBloqueMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND idUsuario=".$idUsuario." AND bloque=0";
		//echo $consulta;
		$calificacion=$con->obtenerValor($consulta);
		if($calificacion=="")
		{
			return true;
		}
		else
		{
			//if($resultadoCalMat==1)
				//$resultadoCalMat=$cal;
			//echo "entra a asentar cal";
			return asentarCalificacionMateria($idMateria,$idGrupo,$idUsuario,$calificacion);
		}
	}
	
	function calcularCalBloquesMateria($idMateria,$idGrupo,$idUsuario,$bloque)
	{
		global $con;
		
		if($bloque==0)
		{
			$conEsquema="SELECT pondCriteriosEq FROM 4155_confBloquesMateria WHERE idMateria=".$idMateria." AND (idGrupo=".$idGrupo." or idGrupo=-1) AND bloque=".$bloque;
			$esquema=$con->obtenerValor($conEsquema);
			
			$conBlq="SELECT idPonderacion,valor FROM 4152_ponderacionCriterios WHERE idMateria=".$idMateria."  AND (idGrupo=".$idGrupo." or idGrupo=-1) AND bloque=".$bloque." AND idEvaluacion=0 and solicitarCalificacion=1";
			$fPon=$con->obtenerPrimeraFila($conBlq);
			
			$idPonderacion=$fPon[0];
			$valor=$fPon[1];
			
			$consulta="SELECT valorReal FROM 4162_calCriterioBloque WHERE idPonderacion=".$idPonderacion;
			$calificacion=$con->obtenerValor($consulta);
			if($calificacion!="")
			{
				return $calificacion;
			}
			else
			{
				$conTipoBloque="select esquemaEvaluacion,bloques from 4013_materia where idMateria=".$idMateria;
				$tipoBloque=$con->obtenerPrimeraFila($conTipoBloque);
				if($tipoBloque)
				{
					if($tipoBloque[0]==1)
					{
						$conBloques="SELECT idTema FROM 4039_temas WHERE idPadre=-".$idMateria;
						$bloques=$con->obtenerFilas($conBloques);
						$nBloques=$con->filasAfectadas;
						if($nBloques==0)
						{
							return -1;
						}
					}
					else
					{
						if($tipoBloque[1]==1000)
						{
							$conBloques="SELECT noBloques FROM 4195_bloquesMateria WHERE idMateria=".$idMateria." and idGrupo=".$idGrupo;
							$nBloques=$con->obtenerValor($conBloques);
							if($nBloques=="")
							{
			
								return -1;
							}
						}
						else
						{
							$nBloques=$tipoBloque[1];
						}
					}
					
					$calBloques="SELECT calificacion FROM 4163_calBloqueMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND idUsuario=".$idUsuario." and bloque<>0";
					//echo $calBloques;
					//return -1;
					$nCalBloques=$con->obtenerFilas($calBloques);
					$nCal=$con->filasAfectadas;
					$calBloquesMateria=0;
					if($nCal==$nBloques)
					{
						while($fCalBloq=mysql_fetch_row($nCalBloques))
						{
							$calBloquesMateria=$calBloquesMateria+$fCalBloq[0];
						}
						
						$calBloquesMateria=$calBloquesMateria/$nCal;
						if($esquema==0)
						{
							$valorReal=$calBloquesMateria*($valor/100);
						}
						else
						{
							$valorReal=$calBloquesMateria;
						}
						
						$conExiste="SELECT idCalCriterioBloque FROM 4162_calCriterioBloque WHERE idPonderacion=".$idPonderacion." and idUsuario=".$idUsuario ;
						$id=$con->obtenerValor($conExiste);
						$ct=0;
						if($id=="")
						{
							$query="insert into 4162_calCriterioBloque(idPonderacion,calificacion,valorReal,idUsuario) values ('".$idPonderacion."','".$calBloquesMateria."','".$valorReal."','".$idUsuario."')";
						}
						else
						{
							$query="update 4162_calCriterioBloque set calificacion='".$calBloquesMateria."',valorReal=".$valorReal." where idCalCriterioBloque=".$id ;
						}
						
						if($con->ejecutarConsulta($query))
						{
							return $calBloquesMateria;
						}
					}
					else
					{
						return -1;
					}
				}
				else
				{
					return -1;
				}
			
			}
		}
		else
		{
			return true;
		}
	}
	
	function asentarCalificacionMateria($idMateria,$idGrupo,$idUsuario,$cal)
	{
		global $con;
		//global $idPrograma;
		//global $idCiclo;
		//global $calcularGradoMapa;
		
		//echo "calificacion".$cal;
		
		//$conMapa="SELECT idMapaCurricular FROM 4029_mapaCurricular WHERE idPrograma=".$idPrograma." AND ciclo=".$idCiclo;
		
		//$idMapaCurricular=$con->obtenerValor($conMapa);
		
		//$conTipoMateria="SELECT idTipoComponente FROM 4031_elementosMapa WHERE idMateria=".$idMateria." AND idMapaCurricular=".$idMapaCurricular ;
//		$tipo=$con->obtenerValor($conTipoMateria);
//		if($tipo!=2)
//		{
//			return calcularMateriaContenedora($idMateria,idGrupo,idUsuario,$idMapaCurricular,$tipo);
//		}
//		else
//		{
			
			$conCalFinMat="SELECT idAlumnoCalificacion FROM 4159_calificaciones WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND idUsuario=".$idUsuario;
			$existeFinal=$con->obtenerValor($conCalFinMat);
			if($existeFinal=="")
			{
				$query="insert into 4159_calificaciones(idMateria,idGrupo,calificacion,idUsuario) values ('".$idMateria."','".$idGrupo."','".$cal."','".$idUsuario."')";
			}
			else
			{
				$query="update 4159_calificaciones set calificacion='".$cal."' where idAlumnoCalificacion=".$existeFinal ;
			}
			if($con->ejecutarConsulta($query))
			{
				//preguntar si tengo padres y si me tienen como criterio de evaluacion
				$padresCriterio="select idPadre from 4031_elementosMapa where idMateria=".$idMateria." and idPadre<>0 and criterioEvaluacion=1";
				//echo $padresCriterio;
				$res=$con->obtenerFilas($padresCriterio);
				$numeroPadres=$con->filasAfectadas;
				//si tengo padres guardar la calificacion 
				if($numeroPadres>0)
				{
					calcularPadres($idMateria,$idGrupo,$cal,$idUsuario,0,$res);
				}
				
				$conPadre="SELECT idPadre FROM 4031_elementosMapa WHERE idMateria=".$idMateria." and idPadre<>0 and criterioEvaluacion=0";
				//echo $conPadre;
				$res=$con->obtenerFilas($conPadre);
				$filasPadres=$con->filasAfectadas;
				if($filasPadres>0)
				{
					while($fPadre=mysql_fetch_row($res))
					{
						calcularMateriaContenedora($fPadre[0],$idGrupo,$idUsuario,0);
					}
					//echo "regresa de calcular contenedora"	;
					return true;
				}
				
				
				$conPadreGrado="SELECT idGrado FROM 4031_elementosMapa WHERE idMateria=".$idMateria." and idPadre=0";
				$idGrado=$con->obtenerValor($conPadreGrado);	
				if($idGrado)
				{
					return calcularGrado($idGrado,$idGrupo,$idUsuario);
				}
				else
				{
					return true;
				}
			}
	}
	
	function calcularMateriaContenedora($idMateria,$idGrupo,$idUsuario,$bloque)
	{
		global $con;
		//echo "entra a calcular materia contenedora";
		$conTipoMat="SELECT idTipoComponente FROM 4031_elementosMapa WHERE idMateria=".$idMateria;
		$tipoContenedor=$con->obtenerValor($conTipoMat);
		
		$conEsquemaE="SELECT esquemaEvaluacion FROM 4031_elementosMapa WHERE idMateria=".$idMateria;
	    $esquemaE=$con->obtenerValor($conEsquemaE);
			  
		$contieneMaterias="select materiasLibres,porcentajeLibres,materiasOptativasC,porcentajeOptativaC,noMaterias,noMateriasMax,sumaPorcentaje,ponderaHijos from 4031_elementosMapa where idMateria=".$idMateria;
		$tipoMaterias=$con->obtenerPrimeraFila($contieneMaterias);
		
		//if($tipoContenedor==1)
		//{
			$arrHijos=array();
			$porOblig=0;
			$numeroTipoHijos=0;
			
			$considerarObligatorias=false;
			$conHijosObl="SELECT  *FROM 4031_elementosMapa WHERE idPadre=".$idMateria." AND idTipoMateria=1 and criterioEvaluacion=0";
			//echo $conHijosObl;
			$resH=$con->obtenerFilas($conHijosObl);
			$numHObl=$con->filasAfectadas;
			
			if($numHObl>0)
			{
				$considerarObligatorias=true;
				$promedioObligatorias= promedioHijosObligatorios($idMateria,$idGrupo,$idUsuario,$bloque,$esquemaE);
				//echo $promedioObligatorias;
				if($promedioObligatorias!=-1)
				{
					$datos1=explode("_",$promedioObligatorias);
					$promObl=$datos1[0];
					$numeroCal=$datos1[1];
					$porOblig=$porOblig+$datos1[2];
					array_push($arrHijos,$promObl."_".$numeroCal);
					
				}
				else
				{
					return true;
				}
			}
			
			$considerarLibres=false;
			if($tipoMaterias[0]==1)
			{
				//echo "entra a libres";
				$promedioLibres= promedioHijosLibres($idMateria,$idGrupo,$idUsuario,$bloque,$esquemaE,$tipoMaterias[1]);
				//echo $promedioLibres."-";
				if($promedioLibres!=2)
				{
				  	if($promedioLibres==-1)
					{
						return true;
					}
					else
					{
				  		$datos2=explode("_",$promedioLibres);
				  		$promLibres=$datos2[0];
				  		$numeroCal=$datos2[1];
						$numeroInscripcionesL=$datos2[2];
				  		array_push($arrHijos,$promLibres."_".$numeroCal);
				  		$considerarLibres=true;
					}
				}
			}
			
			$considerarOptC=false;
			if($tipoMaterias[2]==1)
			{
				$promedioOptativasCerradas= promedioHijosOptativosC($idMateria,$idGrupo,$idUsuario,$bloque,$esquemaE,$tipoMaterias[4],$tipoMaterias[5],$tipoMaterias[3]);
				//echo $promedioOptativasCerradas;
				if($promedioOptativasCerradas!=2)
				{
					if($promedioOptativasCerradas==-1)
					{
						echo "llega aqui";
						return true;
					}
					else
					{
					  	$datos3=explode("_",$promedioOptativasCerradas);
					  	$promOptC=$datos3[0];
					  	$numeroCalOp=$datos3[1];
					  	array_push($arrHijos,$promOptC."_".$numeroCal);
					  	$considerarOptC=true;
					}
				}
				else
				{
					return true;
				}
			}
			
			
			//if($esquemaE==0)
//			{
				//$promedioDisponible=100;
				//if($considerarObligatorias)
//				{
//					$promedioDisponible=100-$porOblig;
//				}
				
				//$porcentajeLibres=0;
//				if($considerarLibres)
		//		{
					//if($promedioDisponible==0)
//					{
//						return true;
//					}
//					else
//					{
						//$porcentajeLibres=($tipoMaterias[1]*$promedioDisponible)/100;
					//}
			//		$porcentajeLibres=$tipoMaterias[1];
//				}
//				
//				$porcentajeOptC=0;
//				if($considerarOptC)
//				{
					//if($promedioDisponible==0)
//					{
//						return true;
//					}
//					else
//					{
						//$porcentajeOptC=($tipoMaterias[3]*$promedioDisponible)/100;
					//}
				//	$porcentajeOptC=$tipoMaterias[3];
//				}
				
				//if((!$considerarLibres) && ($considerarOptC))
//				{
//					if($tipoMaterias[6]==1)
//					{
//						$porcentajeOptC=$promedioDisponible;
//					}
//				}
//				
//				if((!$considerarOptC) && ($considerarLibres))
//				{
//					if($tipoMaterias[6]==1)
//					{
//						$considerarLibres=$promedioDisponible;
//					}
//				}
				
				$promedioContenedor=0;
				$elementosTotales=0;
				if($considerarObligatorias)
				{
					$promedioContenedor=$promedioContenedor+$promObl;
					if($esquemaE==1)
					{
						$elementosTotales=$elementosTotales+$numHObl;
						//$promedioContenedor=$promedioContenedor/$elementosTotales;
					}
				}
				
				if($considerarOptC)
				{
					$promedioContenedor=$promedioContenedor+$promOptC;
					if($esquemaE==1)
					{
						$elementosTotales=$elementosTotales+$numeroCalOp;
						//$promedioContenedor=$promedioContenedor/$elementosTotales;
					}
				}
				
				
				if($considerarLibres)
				{
					if($numeroInscripcionesL==0)
					{
						if($tipoMaterias[6]==1)
						{
							if($esquemaE==0)
							{
								$promedioContenedor=$promedioContenedor+((10*$tipoMaterias[1])/100);
							}
							//else
//							{
//								$promedioContenedor=$promedioContenedor/$elementosTotales;
//							}
						}
						else
						{
							if($esquemaE==0)
							{
								$promedioContenedor=$promedioContenedor+0;
							}
							else
							{
								$elementosTotales=$elementosTotales+$numeroInscripcionesL;
							}
						}
					}
					else
					{
						$promedioContenedor=$promedioContenedor+$promLibres;
						if($esquemaE==1)
						{
							$elementosTotales=$elementosTotales+$numeroInscripcionesL;
							//$promedioContenedor=$promedioContenedor/$elementosTotales;
						}
					}
					
				}
				
				if($esquemaE==1)
				{
					//$elementosTotales=$elementosTotales+$numeroInscripcionesL;
					$promedioContenedor=$promedioContenedor/$elementosTotales;
				}
				
				//echo $promedioContenedor;
				if(true)//$porOblig==100)
				{
					if($bloque==0)
					{
						$promedioComponente=$promObl;
						$conExiste="SELECT idAlumnoCalificacion FROM 4159_calificaciones WHERE idUsuario=".$idUsuario." AND idMateria=".$idMateria." AND idGrupo=".$idGrupo ;
						$id=$con->obtenerValor($conExiste);
						if($id=="")
						{
							$guardarCal="insert into 4159_calificaciones(idUsuario,idMateria,calificacion,idGrupo) values ('".$idUsuario."','".$idMateria."','".$promedioContenedor."','".$idGrupo."')";
						}
						else
						{
							$guardarCal="update 4159_calificaciones set calificacion='".$promedioContenedor."' where idAlumnoCalificacion=".$id;
						}
						
						//echo $guardarCal;
						if($con->ejecutarConsulta($guardarCal))
						{
							//echo "entra aqui";
							//if($tipo[1]!=0)
	//						{
	//							$conIdMateria="SELECT idMateria FROM 4031_elementosMapa WHERE idElementoMapa=".$tipo[1] ;
	//							$id=$con->obtenerValor($conIdMateria);
								return true; //calcularMateria($id);
								//preguntar si tengo padres y si me tienen como criterio de evaluacion
								$padresCriterio="select idPadre from 4031_elementosMapa where idMateria=".$idMateria." and idPadre<>0 and criterioEvaluacion=1";
								//echo $padresCriterio;
								$res=$con->obtenerFilas($padresCriterio);
								$numeroPadres=$con->filasAfectadas;
								//si tengo padres guardar la calificacion 
								if($numeroPadres>0)
								{
									calcularPadres($idMateria,$idGrupo,$cal,$idUsuario,0,$res);
								}
								
								$conPadre="SELECT idPadre FROM 4031_elementosMapa WHERE idMateria=".$idMateria." and idPadre<>0 and criterioEvaluacion=0";
								//echo $conPadre;
								$res=$con->obtenerFilas($conPadre);
								$filasPadres=$con->filasAfectadas;
								if($filasPadres>0)
								{
									while($fPadre=mysql_fetch_row($res))
									{
										calcularMateriaContenedora($fPadre[0],$idGrupo,$idUsuario,0);
									}
									//echo "regresa de calcular contenedora"	;
									return true;
								}
								
								
								$conPadreGrado="SELECT idGrado FROM 4031_elementosMapa WHERE idMateria=".$idMateria." and idPadre=0";
								$idGrado=$con->obtenerValor($conPadreGrado);	
								if($idGrado)
								{
									return calcularGrado($idGrado,$idGrupo,$idUsuario);
								}
								else
								{
									return true;
								}
								
						//	}
						}
						else
						{
							return true;
						}
					}
					else
					{
						$conExiste2="SELECT idCalBloqueMateria FROM 4163_calBloqueMateria WHERE bloque=".$bloque." AND idMateria=".$idMateria." AND idGrupo=".$idGrupo." and idUsuario=".$idUsuario ;
						//echo $conExiste2;
						$id2=$con->obtenerValor($conExiste2);
						if($id2=="")
						{
							$query="insert into 4163_calBloqueMateria(bloque,idMateria,idGrupo,calificacion,idUsuario,tipoBloque) values ('".$bloque."','".$idMateria."','".$idGrupo."','".$promedioContenedor."','".$idUsuario."','".$esquemaE."')";
						}
						else
						{
							$query="update 4163_calBloqueMateria set calificacion='".$promedioContenedor."' where idCalBloqueMateria=".$id2 ;
						}
						if($con->ejecutarConsulta($query))
						{
							
							$nbloquesMat=obtenerNumeroBloques($idMateria,$idGrupo);
				
							//preguntar si tengo padres y si me tienen como criterio de evaluacion
							$padresCriterio="select idPadre from 4031_elementosMapa where idMateria=".$idMateria." and idPadre<>0 and criterioEvaluacion=1";
							//echo $padresCriterio;
							$res=$con->obtenerFilas($padresCriterio);
							$numeroPadres=$con->filasAfectadas;
							//si tengo padres guardar la calificacion 
							if($numeroPadres>0)
							{
								calcularPadres($idMateria,$idGrupo,$cal,$idUsuario,$bloque,$res);
							}
							
							//preguntar si tengo padres que no me tengan como criterio de evaluacion
							$padresMat="select idPadre from 4031_elementosMapa where idMateria=".$idMateria." and idPadre<>0 and criterioEvaluacion=0";
							$res1=$con->obtenerFilas($padresMat);
							$numPadres=$con->filasAfectadas;
							//si tengo padres calcular padres 
							if($numPadres>0)
							{
								while($fPadre=mysql_fetch_row($res1))
								{
									$conGrupo="SELECT idGrupo FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$fPadre[0]." AND idUsuario=".$idUsuario;
									$idGrupo=$con->obtenerValor($conGrupo);
									
									$nbloquesPadre=obtenerNumeroBloques($fPadre[0],$idGrupo);
									
									if($nbloquesPadre==$nbloquesMat)
									{
										calcularMateriaContenedora($fPadre[0],$idGrupo,$idUsuario,$bloque);
									}
								}
								return true;
							}
							
							$conPadreGrado="SELECT idGrado FROM 4031_elementosMapa WHERE idMateria=".$idMateria." and idPadre=0";
							$idGrado=$con->obtenerValor($conPadreGrado);	
							if($idGrado)
							{
								return calcularGrado($idGrado,$idGrupo,$idUsuario);
							}
							else
							{
								return true;
							}
							
						}
						else
						{
							return true;
						}
					}
				}
				//else
//				{
//				  $porcentajeLibre=100-$porOblig;
//				  
//				}
		//	}
//			else
//			{
//			
//			}
		//}
		//else
		//{
			//simple compuesta
		//}
	}
	
	function promedioHijosObligatorios($idMateria,$idGrupo,$idUsuario,$bloque,$esquemaE)
	{
		global $con;
		//echo $bloque;
		$numBloqP=obtenerNumeroBloques($idMateria,$idGrupo);
		//echo $numBloqP;
		
		$conHijosObligatorios="SELECT idMateria,ponderacion FROM 4031_elementosMapa WHERE idPadre=".$idMateria." and idTipoMateria=1  and criterioEvaluacion=0" ;
		$res2=$con->obtenerFilas($conHijosObligatorios);
		$numeroHijosObl=$con->filasAfectadas;
		if($numeroHijosObl>0)
		{
			$porOblig=0;
			$suma=0;
			$numeroCal=0;
			while($hijo=mysql_fetch_row($res2))
			{
				$conGrupo="SELECT idGrupo FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$hijo[0]." AND idUsuario=".$idUsuario;
				$idGrupo=$con->obtenerValor($conGrupo);
				
				$numBloqH=obtenerNumeroBloques($hijo[0],$idGrupo);
				//echo $numBloqH;
				if($bloque!=0)
				{
					//echo "entra a bloque <>0";
					if($numBloqH==$numBloqP)	
					{
						$calificacionBloque="SELECT calificacion FROM 4163_calBloqueMateria WHERE idUsuario=".$idUsuario." AND idMateria=".$hijo[0]." AND idGrupo=".$idGrupo." and bloque=".$bloque ;
						$calM=$con->obtenerValor($calificacionBloque);
						if($calM=="")
						{
							return -1;
						}
					}
					else
					{
						return -1;
					}
				}
				else
				{
					$calificacionBloque="SELECT calificacion FROM 4159_calificaciones WHERE idUsuario=".$idUsuario." AND idMateria=".$hijo[0]." AND idGrupo=".$idGrupo ;
					$calM=$con->obtenerValor($calificacionBloque);
					if($calM=="")
					{
						return -1;
					}
				}
				
				if($esquemaE==0)
				{
				  $valorReal=($calM*$hijo[1])/100;
				  $suma=$suma+$valorReal; 
				  $numeroCal++;
				  $porOblig=$porOblig+$hijo[1];
				}
				else
				{
				  $suma=$suma+$calM; 
				  $numeroCal++;
				}
			}
			
			if($numeroHijosObl==$numeroCal)
			{
			   $promObl=$suma;
			   $promedio1=$promObl."_".$numeroCal."_".$porOblig;
			   return $promedio1;
			}
			else
			{
			  return "1_2_0";//si tiene pero no estan todas las calificaciones
			}
		}
		else
		{
			return "1_1";//no tiene hijos obligatorios
		}
	}
	
	function promedioHijosLibres($idMateria,$idGrupo,$idUsuario,$bloque,$esquemaE,$ponderacion)
	{
		global $con;
		$numBloqP=obtenerNumeroBloques($idMateria,$idGrupo);
		
		$materiasLibres="SELECT idMateria,ponderacion FROM 4031_elementosMapa WHERE idPadre=".$idMateria." and idTipoMateria=3 and criterioEvaluacion=0" ;
		$resLibres=$con->obtenerFilas($materiasLibres);
		$numLibres=$con->filasAfectadas;
		if($numLibres>0)
		{
			$nCalLibres=0;
			$sumaLibres=0;
			$numIncripciones=0;
			while($filaLibres=mysql_fetch_row($resLibres))
			{
				
				$conInscrito="SELECT idAlumnosElementoMapa,idGrupo FROM 4120_alumnosVSElementosMapa WHERE idUsuario=".$idUsuario." AND idMateria=".$filaLibres[0];
				//echo $conInscrito;
				$inscrito=$con->obtenerPrimeraFila($conInscrito);
				
				if($inscrito)
				{
					$numBloqH=obtenerNumeroBloques($filaLibres[0],$inscrito[1]);
					if($bloque!=0)
					{
						if($numBloqH==$numBloqP)	
						{
							$conCalLibre="SELECT calificacion FROM 4163_calBloqueMateria WHERE idUsuario=".$idUsuario." AND idMateria=".$filaLibres[0]." AND idGrupo=".$idGrupo." and bloque=".$bloque ;
							$calLibre=$con->obtenerValor($conCalLibre);
							if($calLibre=="")
							{
								return -1;
							}
						}
						else
						{
							return -1;
						}
					}
					else
					{
						$conCalLibre="SELECT calificacion FROM 4159_calificaciones WHERE idMateria=".$filaLibres[0]." AND idGrupo=".$inscrito[1]." AND idUsuario=".$idUsuario;
						$calLibre=$con->obtenerValor($conCalLibre);
						if($calLibre!="")
						{
							$sumaLibres=$sumaLibres+$calLibre;
							$nCalLibres++;
						}
						else
						{
							return -1;
						}
					}
					$numIncripciones ++;
				}
			}
			
			if($numIncripciones==0)
			{
				$promedioLibresF="0_0_0";
			}
			
			$promedioLibres=$sumaLibres/$nCalLibres;
			
			if($esquemaE==0)
			{
				$promedioLibres=($promedioLibres*$ponderacion)/100;
			}
			
			return $promedioLibresF=$promedioLibres."_".$nCalLibres."_".$numIncripciones;
		}
		else
		{
			return -1;
		}
	}
	
	
	function promedioHijosOptativosC($idMateria,$idGrupo,$idUsuario,$bloque,$esquemaE,$minimo,$maximo,$ponderacion)
	{
		global $con;
		$numBloqP=obtenerNumeroBloques($idMateria,$idGrupo);
		
		$conHijosOptativasCerradas="SELECT idMateria,ponderacion FROM 4031_elementosMapa WHERE idPadre=".$idMateria." and idTipoMateria=2  and criterioEvaluacion=0" ;
		$res3=$con->obtenerFilas($conHijosOptativasCerradas);
		$numeroHijosOpA=$con->filasAfectadas;
		if($numeroHijosOpA>0)
		{
		    $nCalOptC=0;
		    $sumaOptC=0;
			$numIncripciones=0;
			while($filaOptC=mysql_fetch_row($res3))
			{
				$conInscrito="SELECT idAlumnosElementoMapa,idGrupo FROM 4120_alumnosVSElementosMapa WHERE idUsuario=".$idUsuario." AND idMateria=".$filaOptC[0];
				//echo $conInscrito;
				$inscrito=$con->obtenerPrimeraFila($conInscrito);
				if($inscrito)
				{
					$numBloqH=obtenerNumeroBloques($filaOptC[0],$inscrito[1]);
					if($bloque!=0)
					{
						if($numBloqH==$numBloqP)	
						{
							$conCalOptC="SELECT calificacion FROM 4163_calBloqueMateria WHERE idUsuario=".$idUsuario." AND idMateria=".$filaOptC[0]." AND idGrupo=".$idGrupo." and bloque=".$bloque ;
							$calOptC=$con->obtenerValor($conCalOptC);
							if($calOptC=="")
							{
								return -1;
							}
						}
						else
						{
							return -1;
						}
					}
					else
					{
						$conCalOptC="SELECT calificacion FROM 4159_calificaciones WHERE idMateria=".$filaOptC[0]." AND idGrupo=".$inscrito[1]." AND idUsuario=".$idUsuario;
						//echo $conCalOptC;
						$calOptC=$con->obtenerValor($conCalOptC);
						if($calOptC=="")
						{
							return -1;
						}
						else
						{
							$sumaOptC=$sumaOptC+$calOptC;
							$nCalOptC++;
						}
					}
					$numIncripciones++;
				}
			}
			 
			//echo "(".$nCalOptC.">=".$minimo.")&&(".$nCalOptC."<=".$maximo.")";
			if(($nCalOptC>=$minimo)&&($nCalOptC<=$maximo))
			{
				$promedioOptC=$sumaOptC/$nCalOptC;
				if($esquemaE==0)
				{
					$promedioOptC=($promedioOptC*$ponderacion)/100;
				}
				
				return $promedioOptCf=$promedioOptC."_".$nCalOptC."_".$numIncripciones;
			}
			else
			{
				return -1;
			}
		}
		return 2;
	}
	
	function calcularPadres($idMateria,$idGrupo,$cal,$idUsuario,$bloque,$res)
	{
		global $con;
		//echo "entra a calcular padres";
		$numBloqH=obtenerNumeroBloques($idMateria,$idGrupo);
		while($filaP=mysql_fetch_row($res))
		{
			$conGrupo="SELECT idGrupo FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$filaP[0]." AND idUsuario=".$idUsuario;
			$idGrupo=$con->obtenerValor($conGrupo);
			
			$numBloqP=obtenerNumeroBloques($idMateria,$idGrupo);
			if($numBloqH==$numBloqP)
			{
				if($idGrupo!="")
				{
					$consideraMateria="SELECT idPonderacion,idEvaluacion,valor FROM 4152_ponderacionCriterios WHERE idMateria=".$filaP[0]." AND (idGrupo=".$idGrupo." or idGrupo=-1) 
												 AND bloque=".$bloque." and tipoCriterio=1 and solicitarCalificacion=1 and idPadre=0";
					$filaPon=$con->obtenerPrimeraFila($consideraMateria);
					if($filaPon)
					{
						$conEsquema="SELECT pondCriteriosEq FROM 4155_confBloquesMateria WHERE idMateria=".$filaP[0]." AND (idGrupo=".$idGrupo." or idGrupo=-1) AND bloque=".$bloque;
						
						$esquema=$con->obtenerValor($conEsquema);
						if($esquema=0)
						{
							$calif=$cal;
							$valorReal=($cal*$valor)/100;
						}
						else
						{
							$calif=$cal;
							$valorReal=$cal;
						}
						
						$conExiste="SELECT idCalCriterioBloque FROM 4162_calCriterioBloque WHERE idPonderacion=".$filaPon[0]." and idUsuario=".$idUsuario ;
						$id=$con->obtenerValor($conExiste);
						if($id=="")
						{
							$query="insert into 4162_calCriterioBloque(idPonderacion,calificacion,valorReal,idUsuario) values ('".$filaPon[0]."','".$calif."','".$valorReal."','".$idUsuario."')";
							//echo $query[$ct];
						}
						else
						{
							$query="update 4162_calCriterioBloque set calificacion='".$calif."',valorReal=".$valorReal." where idCalCriterioBloque=".$id ;
							//echo $query[$ct];
						}
						//echo $query;
						if($con->ejecutarConsulta($query))
						{
							//echo $filaP[0];
							calcularCalificacionBloque($filaP[0],$idGrupo,$idUsuario,$bloque);
						}
					}
				}
			}
		}
		return true;
	}
	
	
		
	function calcularGrado($idGrado,$idGrupo,$idUsuario)
	{
		return true ;
	}
	
	function guardarCalificacionCriterioEntregablesBloque()
	{
		global $con;
		
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		$idPonderacion=$_POST["idPonderacion"];
		$idGrupo=$_POST["idGrupo"];
		
		$consulta="SELECT totalSolicitados,totalConsiderar FROM 4199_evidenciasBloque WHERE idPonderacion=".$idPonderacion." and idGrupo=".$idGrupo;
				//echo $consulta;
		$fila=$con->obtenerPrimeraFila($consulta);
		
		for($x=0;$x<$tamano;$x++)
		{
			$elemento=$arreglo[$x];
			//echo $elemento;
			$datosArreglo=explode("_",$elemento);
			$idUsuario=$datosArreglo[0];
			$valor=$datosArreglo[1];
			//datos de la ponderacion
			$datosPon="SELECT *FROM 4152_ponderacionCriterios WHERE idPonderacion=".$idPonderacion;
			$datos=$con->obtenerPrimeraFila($datosPon);
			
			//tiene padre
			$conPadre="SELECT idPadre FROM 4152_ponderacionCriterios WHERE idPonderacion=".$idPonderacion;
			$idPadre=$con->obtenerValor($conPadre);
			//if($idPadre==0)
			//{
				
				//tipo de esquema del bloque
				$conEsquemaB="SELECT pondCriteriosEq FROM 4155_confBloquesMateria WHERE bloque=".$datos[3]." AND idMateria=".$datos[7]." AND idGrupo=".$datos[6];
				$esquemaE=$con->obtenerValor($conEsquemaB);
				
				$regla="-1";
				if($esquemaE==1)
				{
					$conRegla="SELECT regla FROM 4156_confBloquesCriterio WHERE idCriterioEvaluacionExtra=".$idPadre." AND bloque=".$datos[3];
					$regla=$con->obtenerValor($conRegla);
				}
				
				$calificacionR=($valor*10)/$fila[1];
				$valorReal=$calificacionR;
				if($esquemaE==0)
				{
					$valorReal=($calificacionR*$datos[2])/100;
				}
				
					$conExiste="SELECT idAlumnoEvidencia FROM 4210_alumnosVSEvidencia WHERE idPonderacion=".$idPonderacion." AND idUsuario=".$idUsuario;
					$id=$con->obtenerValor($conExiste);
					if($id=="")
					{
						$query="INSERT INTO 4210_alumnosVSEvidencia(idUsuario,idPonderacion,noEvidencias)  VALUES('".$idUsuario."','".$idPonderacion."','".$valor."')";
					}
					else
					{
						$query="UPDATE 4210_alumnosVSEvidencia SET noEvidencias='".$valor."' WHERE idAlumnoEvidencia=".$id;
					}
					if($con->ejecutarConsulta($query))
					{
						
					$consulta="select idCalCriterioBloque,calificacion from 4162_calCriterioBloque where idPonderacion=".$idPonderacion." and idUsuario=".$idUsuario;
					//echo $consulta;
					$filaCal=$con->obtenerPrimeraFila($consulta);
					if($filaCal)
					{
						$consulta="update 4162_calCriterioBloque set calificacion=".$calificacionR.",valorReal=".$valorReal.",ponderacion=".$datos[2]." where  idUsuario=".$idUsuario." and idPonderacion=".$idPonderacion;
						$calAnterior=$filaCal[1];
					}
					else		
					{
						$consulta="insert into 4162_calCriterioBloque(calificacion,valorReal,ponderacion,idUsuario,idPonderacion) values(".$calificacionR.",".$valorReal.",".$datos[2].",".$idUsuario.",".$idPonderacion.")";
						$calAnterior=$calificacionR;
					}
				
					//echo $consulta;
						if($con->ejecutarConsulta($consulta))
						{
								
							if($idPadre==0)
							{
								
								if(calcularCalificacionBloque($datos[7],$idGrupo,$idUsuario,$datos[3]))
								{
									//echo "entra";
									//echo "1|".$calificacionR."|".$calAnterior."|".$valor;
								}
								else
								{
									//echo "2|";
								}
								//echo "1|".$calificacionR."|".$calAnterior."|".$valor;
							}
							
							//return;
						}
						else
						{
								//echo "|";
						}
					}
		}
		
		echo "1|";
	}
	
	function guardarCalificacionCriterioDirectaBloque()
	{
		global $con;
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		$idPonderacion=$_POST["idPonderacion"];
		
		
		for($x=0;$x<$tamano;$x++)
		{
			$elemento=$arreglo[$x];
			$datosArreglo=explode("_",$elemento);
			$idUsuario=$datosArreglo[0];
			$valor=$datosArreglo[1];
			
			$conDatos="SELECT *FROM 4152_ponderacionCriterios WHERE idPonderacion=".$idPonderacion;
			//echo $conDatos;
			$datos=$con->obtenerPrimeraFila($conDatos);
			
			$idPadre=$datos[8];
			
			$conEsquemaB="SELECT pondCriteriosEq FROM 4155_confBloquesMateria WHERE bloque=".$datos[3]." AND idMateria=".$datos[7]." AND idGrupo=".$datos[6];
			$esquemaE=$con->obtenerValor($conEsquemaB);
			
			if($esquemaE==1)
			{	
				$valorReal=$valor;
			}
			else
			{
				$valorReal=($datos[2]*$valor)/100;
			}
			
			$consulta="select idCalCriterioBloque from 4162_calCriterioBloque where idPonderacion=".$idPonderacion." and idUsuario=".$idUsuario;
			$filaCal=$con->obtenerPrimeraFila($consulta);
			if($filaCal)
				$consulta="update 4162_calCriterioBloque set calificacion=".$valor.",valorReal=".$valorReal.",ponderacion=".$datos[2]." where  idUsuario=".$idUsuario." and idPonderacion=".$idPonderacion;
			else		
				$consulta="insert into 4162_calCriterioBloque(calificacion,valorReal,ponderacion,idUsuario,idPonderacion) values(".$valor.",".$valorReal.",".$datos[2].",".$idUsuario.",".$idPonderacion.")";
				
			
			if($con->ejecutarConsulta($consulta))
			{
				
				if($idPadre==0)
				{
					$conGrupo="SELECT idGrupo FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$datos[7]." AND idUsuario=".$idUsuario;
					$idGrupo=$con->obtenerValor($conGrupo);
					
					
					if(calcularCalificacionBloque($datos[7],$idGrupo,$idUsuario,$datos[3]))
					{
						//echo "1|".number_format($valor,2,'.',',');	
					}
				}
				else
				{
					if(calcularCalificacionPadre($idPadre,$datos[3],$idUsuario,$esquemaE))
					{
						//echo "entra de regreso";
						$conGrupo="SELECT idGrupo FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$datos[7]." AND idUsuario=".$idUsuario;
						$idGrupo=$con->obtenerValor($conGrupo);
						
						if(calcularCalificacionBloque($datos[7],$idGrupo,$idUsuario,$datos[3]))
						{
							//echo "entra";
							//echo "1|".$calificacionR."|".$calAnterior."|".$valor;
							//echo "1|".number_format($valor,2,'.',',');	
						}
						else
						{
							//echo "2|";
						}
					}
					else
					{
						//echo "2|";
					}
				}
			}
		}
		
		echo "1|";
	}
	
	function guardarVistaCalificaciones()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$idProfesor=$_POST["idProfesor"];
		$muestra=$_POST["muestraP"];
		$muestraCritEsp=$_POST["muestraCritE"];
		$muestraPorcAsist=$_POST["muestraPorA"];
		
		$conExiste="SELECT idConfVistaCalif FROM 4236_confVistaCal WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo;
		$existe=$con->obtenerValor($conExiste);
		if($existe=="")
		{
			$query="INSERT INTO 4236_confVistaCal(idMateria,idGrupo,idProfesor,mostrarPromedioParcial,mostrarConfEspeciales,mostrarPorcentajeAsitencia) VALUES(".$idMateria.",".$idGrupo.",".$idProfesor.",".$muestra.",".$muestraCritEsp.",".$muestraPorcAsist.")";		
		}
		else
		{
			$query="UPDATE 4236_confVistaCal SET mostrarPromedioParcial=".$muestra.",mostrarConfEspeciales=".$muestraCritEsp.",mostrarPorcentajeAsitencia=".$muestraPorcAsist." WHERE idConfVistaCalif=".$existe;
		}
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerDatosVistaCalificaciones()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$idProfesor=$_POST["idProfesor"];
		
		$consulta="SELECT *FROM 4236_confVistaCal WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo;
		$fila=$con->obtenerPrimeraFila($consulta);
		//if($fila[0]==""])
		//{
			
		//}
		
		echo "1|".$fila[4]."|".$fila[5]."|".$fila[6];
	}
	
	function obtenerInformacionDocumento()
	{
		global $con;
		$idDoc=$_POST["idDoc"];
		$consulta="SELECT idGaleriaDocumentos,tituloDocumento,fechaUltimoCambio,descripcion,tamano,idCategoria,nombreDocumento FROM 9048_galeriaDocumentos WHERE idGaleriaDocumentos=".$idDoc;
		$fDocumento=$con->obtenerPrimeraFila($consulta);
		echo '1|[{"idMaterialDidactico":"'.$fDocumento[0].'","titulo":"'.cv($fDocumento[1]).'","fechaSubida":"'.$fDocumento[2].'","tipo":"","descripcion":"'.cv($fDocumento[3]).'","tamano":"'.$fDocumento[4].
				'","idCategoria":"'.$fDocumento[5].'","nomArchivo":"'.$fDocumento[6].'"}]';
		
			
	}
	
	function obtenerCriteriosEvaluacion()
	{
		global $con;
		$arrTipoEvaluacion=array();
		
		$arrTipoEvaluacion[1]="Asociado a escala de calificación";
		$arrTipoEvaluacion[2]="Asociado a función de sistema";
		
		$cadRegistros="";
		$consulta="SELECT idEvaluacion,titulo,descripcion,idTipoEvaluacion FROM 4010_evaluaciones ORDER BY titulo";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$descripcion="";
			$descripcion2="";
			
			$descripcion=$fila[2];
			
			if($descripcion!="")
				$descripcion.=". ";
				
			switch($fila[3])	
			{
				case 1:
					$consulta="SELECT nombreEscala FROM 4032_escalasCalificacion WHERE idEscalaCalificacion=".$fila[3];
					$descripcion2="<b>Escala: </b>".$con->obtenerValor($consulta);
				break;
				case 2:
					$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$fila[3];
					$descripcion2="<b>Funci&oacute;n: </b>".$con->obtenerValor($consulta);
				break;
				
			}
				
				
			$descripcion.="<b>Forma de evaluaci&oacute;n:</b> <i>".utf8_encode($arrTipoEvaluacion[$fila[3]])." [".$descripcion2."]</i>";
				
			
			$obj='{"idCriterio":"'.$fila[0].'","nombreCriterio":"'.cv($fila[1]).'","descripcion":"'.cv($descripcion).'"}';
			if($cadRegistros=="")
				$cadRegistros=$obj;
			else
				$cadRegistros.=",".$obj;
		}
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$cadRegistros.']}';
	}
	
	function registrarCriteriosEvaluacionMateria()
	{
		global $con;
		$obj=json_decode($_POST["cadObj"]);
		$longitud=7;
		$codigoPadre=str_pad($obj->codigoPadre,$longitud,"0",STR_PAD_LEFT);
		$consulta="select max(codigoUnidad) from 4564_criteriosEvaluacionMateria where codigoPadre='".$codigoPadre."' and idGrupo=".$obj->idGrupo;
		$maxNivel=$con->obtenerValor($consulta);

		if($maxNivel=="")
		{
			$maxNivel=0;
			
			
		}
		else
			$maxNivel=substr($maxNivel,strlen($codigoPadre));
		
		$maxNivel++;
		$arrCriterios=explode(",",$obj->criterios);

		$x=0;
		$query[$x]="begin";
		$x++;
		foreach($arrCriterios as $c)
		{
			$codigoUnidad=$codigoPadre.str_pad($maxNivel,$longitud,"0",STR_PAD_LEFT);
			$consulta="select count(*) from 4564_criteriosEvaluacionMateria where idGrupo=".$obj->idGrupo." and codigoPadre='".$codigoPadre."' and idCriterio=".$c;
			$nCriterio=$con->obtenerValor($consulta);

			if($nCriterio==0)
			{
				$query[$x]="INSERT INTO 4564_criteriosEvaluacionMateria(idMateria,idGrupo,codigoUnidad,codigoPadre,idCriterio) VALUES(".$obj->idMateria.",".$obj->idGrupo.",'".$codigoUnidad."','".$codigoPadre."',".$c.")";
				$x++;
				$maxNivel++;
			}
		}

		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	///reqBloque
	
	
	function obtenerCriteriosEvaluacionMateria()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$nBloques=0;
		
		if($idGrupo!=-1)
			$nBloques=obtenerNoBloquesEvaluacion($idGrupo);
		else
			$nBloques=obtenerNoBloquesEvaluacion($idMateria,2);
				
		$longitud=7;
		$cadObj="";
		$codigoPadre=str_pad($idMateria,$longitud,"0",STR_PAD_LEFT);
		$consulta="SELECT c.codigoUnidad,e.titulo FROM 4564_criteriosEvaluacionMateria c,4010_evaluaciones e WHERE  codigoPadre='".$codigoPadre."' AND (idGrupo=-1 OR idGrupo=".$idGrupo.") AND e.idEvaluacion=c.idCriterio order by titulo";

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$comp="";
			for($x=0;$x<=$nBloques;$x++)
			{
				$consulta="SELECT porcentaje FROM 4565_porcentajeCriterioEvaluacion WHERE idGrupo=".$idGrupo." and idCriterioEvaluacionMateria='".$fila[0]."' AND bloque=".$x;
				$valor=removerCerosDerecha($con->obtenerValor($consulta));
				if($valor=="")
					$valor=0;
				$o='"bloque_'.$x.'":"'.$valor.'"';
				$comp.=",".$o;
			}
			$arrHijos="";
			$arrHijos=obtenerCriteriosHijos($fila[0],$idGrupo,$nBloques);
			if($arrHijos=="[]")
				$comp.=',"leaf":true';
			else
				$comp.=',"leaf":false,"children":'.$arrHijos;
			$obj='{"icon":"../images/bullet_green.png","id":"'.$fila[0].'","criterioEval":"'.cv($fila[1]).'"'.$comp.'}';
			if($cadObj=="")
				$cadObj=$obj;
			else
				$cadObj.=",".$obj;
		}
		echo "[".$cadObj."]";
	}
	
	function obtenerCriteriosHijos($codigoPadre,$idGrupo,$nBloques)
	{
		global $con;
		$cadObj="";
		$consulta="SELECT c.codigoUnidad,e.titulo FROM 4564_criteriosEvaluacionMateria c,4010_evaluaciones e WHERE codigoPadre='".$codigoPadre."' AND (idGrupo=-1 OR idGrupo=".$idGrupo.") AND e.idEvaluacion=c.idCriterio order by titulo";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$comp="";
			for($x=0;$x<=$nBloques;$x++)
			{
				$consulta="SELECT porcentaje FROM 4565_porcentajeCriterioEvaluacion WHERE idGrupo=".$idGrupo." and idCriterioEvaluacionMateria='".$fila[0]."' AND bloque=".$x;
				$valor=removerCerosDerecha($con->obtenerValor($consulta));
				if($valor=="")
					$valor=0;
				$o='"bloque_'.$x.'":"'.$valor.'"';
				$comp.=",".$o;
			}
			$arrHijos="";
			$arrHijos=obtenerCriteriosHijos($fila[0],$idGrupo,$nBloques);
			if($arrHijos=="[]")
				$comp.=',"leaf":true';
			else
				$comp.=',"leaf":false,"children":'.$arrHijos;
			$obj='{"icon":"../images/bullet_green.png","id":"'.$fila[0].'","criterioEval":"'.cv($fila[1]).'"'.$comp.'}';
			if($cadObj=="")
				$cadObj=$obj;
			else
				$cadObj.=",".$obj;
		}
		return "[".$cadObj."]";
	}
	
	function guardarPorcentajeCriterio()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="select count(*) from 4565_porcentajeCriterioEvaluacion where idCriterioEvaluacionMateria='".$obj->idCriterioEvaluacionMateria."' and idGrupo=".$obj->idGrupo." and bloque=".$obj->bloque;
		$nCriterio=$con->obtenerValor($consulta);		
		if($nCriterio==0)
			$consulta="INSERT INTO 4565_porcentajeCriterioEvaluacion(idCriterioEvaluacionMateria,bloque,porcentaje,idGrupo) VALUES('".$obj->idCriterioEvaluacionMateria."',".$obj->bloque.",".$obj->porcentaje.",".$obj->idGrupo.")";
		else
			$consulta="update 4565_porcentajeCriterioEvaluacion set porcentaje=".$obj->porcentaje." where idCriterioEvaluacionMateria='".$obj->idCriterioEvaluacionMateria."' and idGrupo=".$obj->idGrupo." and bloque=".$obj->bloque;					
		eC($consulta);
	}
	
	
	///reqBloque
	
	function obtenerConfiguracionBloques()
	{
		global $con;
		$idCriterio=-1;
		$longitud=7;
		if(isset($_POST["idCriterio"]))
			$idCriterio=$_POST["idCriterio"];
		$idGrupo=$_POST["idGrupo"];
		$idMateria=$_POST["idMateria"];
		$nBloque=0;
		if($idGrupo!=-1)
			$nBloques=obtenerNoBloquesEvaluacion($idGrupo);
		else
			$nBloques=obtenerNoBloquesEvaluacion($idMateria,2);
		$arrBloque="";
		for($x=0;$x<=$nBloque;$x++)
		{
			$valor=1;
			$consulta="SELECT * FROM 4566_configuracionBloques  WHERE idMateria=".$idMateria." AND (idGrupo=".$idGrupo." or idGrupo=-1) AND idCriterio='".$idCriterio."' and noBloque=".$x;
			$fConf=$con->obtenerPrimeraFila($consulta);
			if($fConf)
				$valor=$fConf[4];
			if($arrBloque=="")
				$arrBloque="'".$valor."'";
			else
				$arrBloque.=",'".$valor."'";
			
		}
		$arrBloque="[".$arrBloque."]";
		$arrCriterios="";
		$codigoPadre=$idCriterio;
		if($idCriterio==-1)
			$codigoPadre=str_pad($idMateria,$longitud,"0",STR_PAD_LEFT);
		$consulta="SELECT c.codigoUnidad,e.titulo FROM 4564_criteriosEvaluacionMateria c,4010_evaluaciones e WHERE c.codigoPadre='".$codigoPadre."' AND (c.idGrupo=".$idGrupo." or c.idGrupo=-1) AND e.idEvaluacion=c.idCriterio ORDER BY titulo";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$obj="['".$fila[0]."','".cv($fila[1])."'";
			for($x=0;$x<=$nBloque;$x++)
			{
				$valor="false";
				$consulta="SELECT count(*) FROM 4566_configuracionBloques c,4567_bloquesConfiguracion b WHERE idMateria=".$idMateria." AND (c.idGrupo=".$idGrupo." or c.idGrupo=-1) AND idCriterio='".$idCriterio."' and noBloque=".$x
							." and b.idConfiguracion=c.idConfiguracionBloque and codigoUnidad='".$fila[0]."'";

				$nConf=$con->obtenerValor($consulta);
				if($nConf>0)
				{
					
					$valor="true";
				}
				
				$obj.=",".$valor;
				
			}
			$obj.="]";
			if($arrCriterios=="")
				$arrCriterios=$obj;
			else
				$arrCriterios.=",".$obj;
		}
		echo "1|[".$arrBloque."]|[".$arrCriterios."]";
	}
	
	function guardarConfiguracionBloque()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$query[$x]="begin";
		$x++;
		
		foreach($obj->arrObj as $o)
		{
			if($o->tipoPonderacion=="")
				$o->tipoPonderacion=1;
			$query[$x]="delete from 4567_bloquesConfiguracion where idConfiguracion in (SELECT idConfiguracionBloque FROM 4566_configuracionBloques WHERE idMateria=".$obj->idMateria." AND idGrupo=".$obj->idGrupo." 
					AND idCriterio=".$obj->idCriterio." AND noBloque=".$o->bloque.")";
			$x++;
			$query[$x]="delete FROM 4566_configuracionBloques WHERE idMateria=".$obj->idMateria." AND idGrupo=".$obj->idGrupo." AND idCriterio=".$obj->idCriterio." AND noBloque=".$o->bloque."";
			$x++;
			$query[$x]="INSERT INTO 4566_configuracionBloques(idMateria,idGrupo,noBloque,tipoPonderacion,idCriterio) VALUES(".$obj->idMateria.",".$obj->idGrupo.",".$o->bloque.",".$o->tipoPonderacion.",'".$obj->idCriterio."')";
			$x++;	
			$query[$x]="set @idConfiguracion:=(select last_insert_id())";
			$x++;
			if($o->arrCriterios!="")
			{
				$arrCriterios=explode(",",$o->arrCriterios);
				foreach($arrCriterios as $c)
				{
					$query[$x]="INSERT INTO 4567_bloquesConfiguracion(codigoUnidad,idConfiguracion,idGrupo) VALUES('".$c."',@idConfiguracion,".$obj->idGrupo.")";
					$x++;
				}
			}
		}

		$query[$x]="commit";
		$x++;
		eB($query);
		
	}
	
	function removerCriterioEvaluacion()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$idCriterio=$_POST["idCriterio"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 4564_criteriosEvaluacionMateria WHERE idGrupo=".$idGrupo." and codigoUnidad LIKE '".$idCriterio."%'";
		$x++;
		$consulta[$x]="DELETE FROM 4565_porcentajeCriterioEvaluacion WHERE idGrupo=".$idGrupo." and idCriterioEvaluacionMateria LIKE '".$idCriterio."%'";
		$x++;
		$consulta[$x]="DELETE FROM 4566_configuracionBloques WHERE idGrupo=".$idGrupo." and idCriterio LIKE  '".$idCriterio."%'";
		$x++;
		$consulta[$x]="DELETE FROM 4567_bloquesConfiguracion WHERE idGrupo=".$idGrupo." and codigoUnidad LIKE  '".$idCriterio."%'";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerAlumnosGruposCalificacion()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$bloque=$_POST["bloque"];
		$criterios=bD($_POST["criterio"]);
		
		$objCriterio=json_decode($criterios);

		$cadCriterios="";
		$tamCriterios=sizeof($objCriterio->criterios)-1;
		$arrConfiguracionCriterio=array();
		for($x=2;$x<$tamCriterios;$x++)
		{
			$criterios=$objCriterio->criterios[$x]->name;
			$arrDatos=explode("_",$criterios);
			if($arrDatos[0]=="porcentaje")
			{
				if($cadCriterios=="")
					$cadCriterios="'".$arrDatos[1]."'";
				else
					$cadCriterios.=",'".$arrDatos[1]."'";
				$consulta="SELECT idTipoEvaluacion,funcionEvaluacion,funcionSistemaValMax,formaValorMaximoCriterio,valorMaximo,idEscalaCalificacion,idEvaluacion FROM 4010_evaluaciones e,
						4564_criteriosEvaluacionMateria c WHERE e.idEvaluacion= c.idCriterio AND c.codigoUnidad='".$arrDatos[1]."'";
				$arrConfiguracionCriterio[$arrDatos[1]]=$con->obtenerPrimeraFila($consulta);
				
			}
		}
		
		if($cadCriterios=="")
			$cadCriterios=-1;

		
		
		$consulta="SELECT i.idUsuario,upper(CONCAT(Paterno,' ',Materno,' ',Nom)) AS nombre,a.idGrupo,a.idGrupoOrigen FROM 802_identifica i,4517_alumnosVsMateriaGrupo a
				WHERE a.idUsuario=i.idUsuario AND a.idGrupo=".$idGrupo." and situacion=1 ORDER BY Paterno,Materno,Nom";
		$res=$con->obtenerFilas($consulta);
		$cadRegistros="";
		$nReg=0;
		$posRegistro=0;
		while($fila=mysql_fetch_row($res))
		{
			$posRegistro++;
			$nReg++;
			$dAlumno="";
			$recalcular=false;
			$idGrupoOrigen=$fila[2];
			if($fila[3]!="")
			{
				$idGrupoOrigen=$fila[3];
			}
			
			
			$dAlumno=obtenerOrigenGrupoAlumno($idGrupoOrigen);
			
			$obj='{"idUsuario":"'.$fila[0].'","alumno":"'.cv($fila[1]).'","dAlumno":"'.$dAlumno.'","idGrupoOrigen":"'.$idGrupoOrigen.'"';	
			$arrCalificaciones=array();
			$consulta="SELECT * FROM 4568_calificacionesCriteriosAlumno WHERE idAlumno=".$fila[0]." AND idGrupo=".$idGrupo." AND idCriterio in (".$cadCriterios.") AND bloque=".$bloque;
			$resCal=$con->obtenerFilas($consulta);
			while($fCal=mysql_fetch_row($resCal))
			{
				$arrCalificaciones["c_".$fCal[3]]=$fCal[5];
				$arrCalificaciones["porcentaje_".$fCal[3]]=$fCal[6];
				$arrCalificaciones["tConsidera_".$fCal[3]]=$fCal[8];
				
				
			}
			
			for($x=4;$x<$tamCriterios;$x++)
			{
				$valor=0;
				/*if(isset($arrCalificaciones[$objCriterio->criterios[$x]->name]))
					$valor=$arrCalificaciones[$objCriterio->criterios[$x]->name];
				else
				{*/
				$arrDatos=explode("_",$objCriterio->criterios[$x]->name);
				$confCriterio=$arrConfiguracionCriterio[$arrDatos[1]];
				switch($arrDatos[0])
				{
					case "porcentaje":
						if(isset($arrCalificaciones[$objCriterio->criterios[$x]->name]))
							$valor=$arrCalificaciones[$objCriterio->criterios[$x]->name];
					break;
					case "c":
						switch($confCriterio[0])
						{
							case "1": //Manual
								if(isset($arrCalificaciones[$objCriterio->criterios[$x]->name]))
									$valor=$arrCalificaciones[$objCriterio->criterios[$x]->name];
							break;
							case "2": //Automatico
								$cadObj='{"idCriterio":"'.$arrDatos[1].'","idGrupo":"'.$idGrupo.'","idUsuario":"'.$fila[0].'","bloque":"'.$bloque.'"}';
								$obj=json_decode($cadObj);
								$cache=NULL;
								$valor=resolverExpresionCalculoPHP($confCriterio[1],$obj,$cache);
								if(!is_numeric($valor))
									$valor=0;
								$valorAux=0;
								if(isset($arrCalificaciones[$objCriterio->criterios[$x]->name]))
								{
									$valorAux=$arrCalificaciones[$objCriterio->criterios[$x]->name];
									
								}
								
								if(abs($valor-$valorAux)>0.0001)
								{
									$recalcular=true;
									recalcularCalificacionesGrupo($idGrupo,$arrDatos[1],$bloque,$fila[0]);
								}

							break;
						}
					break;
					case "tConsidera":
						$consulta="SELECT valMax FROM 4571_valoresMaximosCriterio WHERE idGrupo=".$idGrupo." AND noBloque=".$bloque." AND idCriterio=".$arrDatos[1];
						$fCriterio=$con->obtenerPrimeraFila($consulta);
						if(!$fCriterio)
						{
							switch($confCriterio[3])
							{
								case "1": //Valor máximo de escala de evaluación
									$consulta="SELECT max(valorMaximo) FROM 4033_elementosEscala WHERE idEscalaCalificacion=".$confCriterio[5];
									$valor=$con->obtenerValor($consulta);
								break;
								case "2": //Valor constante
									$valor=$confCriterio[4];
								break;
								case "3"://Automático (Mediante función de sistema)
									$cadObj='{"idCriterio":"'.$arrDatos[1].'","idGrupo":"'.$idGrupo.'","idUsuario":"'.$fila[0].'","bloque":"'.$bloque.'"}';
									$obj=json_decode($cadObj);
									$valor=resolverExpresionCalculoPHP($confCriterio[2],$obj);
								break;
							}
						}
						else
							$valor=$fCriterio[0];
							
						if(!is_numeric($valor))
							$valor=0;
						$valorAux=0;
						if(isset($arrCalificaciones[$objCriterio->criterios[$x]->name]))
						{
							$valorAux=$arrCalificaciones[$objCriterio->criterios[$x]->name];
							
						}	
						if(abs($valor-$valorAux)>0.0001)
						{
							$recalcular=true;
							recalcularCalificacionesGrupo($idGrupo,$arrDatos[1],$bloque,$fila[0]);
						}
					break;
				}
				//}
				if($valor=="")
					$valor=0;
				$obj.=',"'.$objCriterio->criterios[$x]->name.'":"'.removerCerosDerecha($valor).'"';
			}
			$consulta="SELECT valor FROM 4569_calificacionesBloqueAlumno WHERE idAlumno=".$fila[0]." AND idGrupo=".$idGrupo." AND bloque=".$bloque;
			$valor=$con->obtenerValor($consulta);
			if($valor=="")
				$valor=0;

			$obj.=',"total":"'.removerCerosDerecha($valor).'"}';
			if(!$recalcular)
			{
				if($cadRegistros=="")
					$cadRegistros=$obj;
				else
					$cadRegistros.=",".$obj;
			}
			else
			{
				try
				{
					mysql_data_seek($res,$posRegistro-1);
				}
				catch(Exception $ex)
				{
					
				}
			}
		}
		
		echo '{"numReg":"'.$nReg.'","registros":['.$cadRegistros.']}';
	}
	
	
	
	function guardarCalificacionAlumnoBloque()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 4568_calificacionesCriteriosAlumno WHERE idAlumno=".$obj->idAlumno." AND idGrupo=".$obj->idGrupo." and bloque=".$obj->bloque;
		$x++;
		foreach($obj->criterios as $c)
		{
			$consulta[$x]="INSERT 4568_calificacionesCriteriosAlumno (idAlumno,idGrupo,idCriterio,bloque,valor,porcentajeObtenido,porcentajeValor,totalConsiderar)
							VALUES(".$obj->idAlumno.",".$obj->idGrupo.",'".$c->criterio."',".$obj->bloque.",".$c->valor.",".$c->porcentajeObtenido.",".$c->porcentajeValor.",".$c->totalConsiderar.")";
			$x++;
		}
		$consulta[$x]="delete from 4569_calificacionesBloqueAlumno where idAlumno=".$obj->idAlumno." and idGrupo=".$obj->idGrupo." and bloque=".$obj->bloque;
		$x++;
		$consulta[$x]="INSERT INTO 4569_calificacionesBloqueAlumno(idAlumno,idGrupo,bloque,valor) VALUES(".$obj->idAlumno.",".$obj->idGrupo.",".$obj->bloque.",".$obj->totalBloque.")";
		$x++;
		if($obj->bloque==0)
		{
			$aprobado=1;
			$consulta[$x]="INSERT INTO 4570_calificacionesAlumnoMateria(idAlumno,idGrupo,valor,aprobado) VALUES(".$obj->idAlumno.",".$obj->idGrupo.",".$obj->totalBloque.",".$aprobado.")";
			$x++;
		}
		
		
		$consulta[$x]="commit";
		$x++;
		if(($con->ejecutarBloque($consulta))&&(recalcularCalificacionFinalMateria($obj->idGrupo,$obj->idAlumno)))
		{
			echo "1|";
		}
		
	}
	
	function obtenerRegistrosAsistenciaProfesor()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$fechaInicio='';
		
		$consulta="SELECT MAX(fechaCorteAsistencia) FROM 672_nominasEjecutadas WHERE idPerfil=4 AND etapa in(800,900,1000)";
		$fechaInicio=$con->obtenerValor($consulta);
		$fechaInicio=date("Y-m-d",strtotime("+1 days",strtotime($fechaInicio)));
		
		
		$fechaMax=date("Y-m-d");
		//$fechaInicio='2013-02-15';
		$fInicio=strtotime($fechaInicio);

		$fFin=strtotime($fechaMax);
		$nReg=0;
		$arrReg="";
		$arrSincronizacionPlanteles=array();
		$consulta="SELECT plantel,marcaSincronizacion FROM 9105_sincronizacionPlanteles";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$arrSincronizacionPlanteles[$fila[0]]=strtotime($fila[1]);
		}
		$consulta="select tipoIncidencia from _484_tablaDinamica";
		$tIncidencias=$con->obtenerValor($consulta);
		if($tIncidencias=="")
			$tIncidencias=3;
		
		while($fInicio<=$fFin)
		{
			$fechaLimite=date("Y-m-d",$fInicio);
				
			
			$consulta="(SELECT fecha,g.nombreGrupo AS grupo,CONCAT(date_format(horaInicioBloque,'%H:%i'),' - ',date_format(horaFinBloque,'%H:%i')) AS horario,hora_entrada AS horaEntrada,tRetardo,hora_salida AS horaSalida,
						tAnticipado,cA.descripcion AS tratamientoEvento,o.unidad AS plantel,c.valorEvento AS tEvento,'1' as tipoEvento,idAsistencia as idRegistro,horaInicioBloque,g.Plantel
						 FROM 9105_controlAsistencia c, 4520_grupos g , 9105_tiposEventoControlAsistencia cA,817_organigrama o WHERE 
						  idUsuario=".$idUsuario." AND fecha='".$fechaLimite."' AND
						 g.idGrupos=c.idGrupo AND cA.idTipoControlAsistencia=c.tipoEvento AND o.codigoUnidad=g.Plantel and tipo=1) 
						 union
						 (SELECT fecha,g.nombreGrupo AS grupo,CONCAT(date_format(horaInicioBloque,'%H:%i'),' - ',date_format(horaFinBloque,'%H:%i')) AS horario,hora_entrada AS horaEntrada,tRetardo,hora_salida AS horaSalida,
						tAnticipado,cA.descripcion AS tratamientoEvento,o.unidad AS plantel,c.valorEvento AS tEvento,'3' as tipoEvento,idAsistencia as idRegistro,horaInicioBloque,g.Plantel
						 FROM 9105_controlAsistenciaDiaFestivo c, 4520_grupos g , 9105_tiposEventoControlAsistencia cA,817_organigrama o WHERE 
						  idUsuario=".$idUsuario." AND fecha='".$fechaLimite."' AND
						 g.idGrupos=c.idGrupo AND cA.idTipoControlAsistencia=c.tipoEvento AND o.codigoUnidad=g.Plantel) 
						 union
						 (SELECT fechaFalta AS fecha,g.nombreGrupo AS grupo,CONCAT(DATE_FORMAT(horaInicial,'%H:%i'),' - ',DATE_FORMAT(horaFinal,'%H:%i')) AS horario, 
						'00:00:00' AS horaEntrada ,'00:00:00' AS tRetardo,'00:00:00' AS horaSalida,'00:00:00' AS tAnticipado,'Omision de entrada y salida' AS tratamientoEvento,
						o.unidad AS plantel,'3' AS tEvento,'2' as tipoEvento,idFalta as idRegistro,horaInicial as horaInicioBloque,g.Plantel	FROM 4559_controlDeFalta c,4520_grupos g,817_organigrama o  WHERE 				
						g.idGrupos=c.idGrupo AND c.idUsuario=".$idUsuario." AND fechaFalta='".$fechaLimite."' AND idRegistroControlAsistencia IS NULL and o.codigoUnidad=g.plantel)			 
						 order by fecha,horaEntrada";

			$resFecha=$con->obtenerFilas($consulta) ;
			while($fila=mysql_fetch_row($resFecha))
			{
				
				if($fila[9]==3)
				{
					if($fila[10]==1)
						$consulta="select estadoFalta FROM 4559_controlDeFalta where idRegistroControlAsistencia=".$fila[11];
					else
						$consulta="select estadoFalta FROM 4559_controlDeFalta where idFalta=".$fila[11];
					$edoFalta=$con->obtenerValor($consulta);
					
					if($edoFalta>0)
					{
						switch($edoFalta)
						{
							case 1:
									
									$fila[7]="Falta justificada";
									$fila[9]=1;

							break;
							case 2:
									
									$fila[7]="Clase comisionada";
									$fila[9]=1;
							break;
						}
					}
				}
				
				$considerar=false;
				switch($tIncidencias)
				{
					case 1:
						if($fila[9]==3)
							$considerar=true;
					break;
					case 2:
						if($fila[9]==1)
							$considerar=true;
					break;
					case 3:
						$considerar=true;
					break;
					
				}
				
				if($fila[9]==3)
				{
					if($arrSincronizacionPlanteles[$fila[13]]<strtotime($fechaLimite." ".$fila[12]))
						$considerar=false;
				}
				
				if($considerar)
				{
					$nReg++;
					$obj='{"fecha":"'.$fila[0].'","grupo":"'.cv($fila[1]).'","horario":"'.$fila[2].'","horaEntrada":"'.$fila[3].'","tRetardo":"'.$fila[4].'","horaSalida":"'.$fila[5].
							'","tAnticipado":"'.$fila[6].'","tratamientoEvento":"'.$fila[7].'","plantel":"'.$fila[8].'","tEvento":"'.$fila[9].'","hInicioBloque":"'.$fila[12].'"}';
					if($arrReg=="")
						$arrReg=$obj;
					else
						$arrReg.=",".$obj;
				}
			}
			
			$fInicio=strtotime("+1 days",$fInicio);

		}
		
		echo '{"numReg":"'.$nReg.'","registros":['.($arrReg).']}';
	}
	
	
	function modificarValorLimiteMaximo()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		
		$consulta="SELECT  idCriterioValMaximo FROM 4571_valoresMaximosCriterioPerfilMateria WHERE idCriterio='".$obj->idCriterio."' AND idGrupo=".$obj->idGrupo." 
					AND noBloque=".$obj->noBloque."  AND idAlumno IS NULL and tipoEvaluacion=".$obj->tipoEvaluacion." and noEvaluacion=".$obj->noEvaluacion;
		$idCriterio=$con->obtenerValor($consulta);
		if($idCriterio=="")
			$consulta="INSERT INTO 4571_valoresMaximosCriterioPerfilMateria(idCriterio,idGrupo,noBloque,valMax,tipoEvaluacion,noEvaluacion)
					VALUES('".$obj->idCriterio."',".$obj->idGrupo.",".$obj->noBloque.",".$obj->valMax.",".$obj->tipoEvaluacion.",".$obj->noEvaluacion.")";
		else
			$consulta="update 4571_valoresMaximosCriterioPerfilMateria set idCriterio='".$obj->idCriterio."',idGrupo=".$obj->idGrupo.",
					noBloque=".$obj->noBloque.",valMax=".$obj->valMax." where idCriterioValMaximo=".$idCriterio;
		if($con->ejecutarConsulta($consulta))
		{
			if(recalcularCalificacionesGrupo($obj->idGrupo,$obj->idCriterio,$obj->noBloque,$obj->tipoEvaluacion,$obj->noEvaluacion))
			{
				echo "1|";
			}
		}
	}
	
	function obtenerAlumnosGruposCalificacionPerfilEvaluacion()
	{
		global $con;
		$bloque=0;
		$idGrupo=$_POST["idGrupo"];
		$tipoEvaluacion=$_POST["tipoEvaluacion"];
		$noEvaluacion=$_POST["noEvaluacion"];
		$criterios=bD($_POST["criterio"]);
		
		$objCriterio=json_decode($criterios);

		$cadCriterios="";
		$tamCriterios=sizeof($objCriterio->criterios)-3;
		
		$arrConfiguracionCriterio=array();
		for($x=2;$x<$tamCriterios;$x++)
		{
			$criterios=$objCriterio->criterios[$x]->name;
			$arrDatos=explode("_",$criterios);
			if($arrDatos[0]=="porcentaje")
			{
				if($cadCriterios=="")
					$cadCriterios="'".$arrDatos[1]."'";
				else
					$cadCriterios.=",'".$arrDatos[1]."'";
				$consulta="SELECT idTipoEvaluacion,funcionEvaluacion,funcionSistemaValMax,formaValorMaximoCriterio,valorMaximo,idEscalaCalificacion,idEvaluacion FROM 4010_evaluaciones e,
						4564_criteriosEvaluacionPerfilMateria c WHERE e.idEvaluacion= c.idCriterio AND c.codigoUnidad='".$arrDatos[1]."'";
				$arrConfiguracionCriterio[$arrDatos[1]]=$con->obtenerPrimeraFila($consulta);
				
			}
		}
		if($cadCriterios=="")
			$cadCriterios=-1;
			
		$consulta="SELECT situacion FROM 4593_situacionEvaluacionCurso WHERE idGrupo=".$idGrupo." AND tipoExamen=".$tipoEvaluacion." AND noExamen=".$noEvaluacion;	
		
		
		$situacionEvaluacion=$con->obtenerValor($consulta);
		$listUsuario="";
		$cache=NULL;
		
		$consulta="SELECT idPlanEstudio,idInstanciaPlanEstudio FROM 4520_grupos WHERE idGrupos=".$idGrupo;
		$fGrupo=$con->obtenerPrimeraFila($consulta);
		$idPlanEstudio=$fGrupo[0];
		$idInstanciaPlanEstudio=$fGrupo[1];
		$idReferenciaExamenes=obtenerPerfilExamenesAplica($idPlanEstudio,$idInstanciaPlanEstudio);
		
		$idFuncionListado=obtenerValorConfiguracionEvaluacion($idReferenciaExamenes,$tipoEvaluacion,6);//FUncion listado alumnos
		
		if($idFuncionListado!="0")
		{
			$cTmp='{"idGrupo":"'.$idGrupo.'","tipoEvaluacion":"'.$tipoEvaluacion.'","noEvaluacion":"'.$noEvaluacion.'"}';
			$objTmp=json_decode($cTmp);
			
			$arrUsrFinal=array();
			$arrUsr=resolverExpresionCalculoPHP($idFuncionListado,$objTmp,$cache);
			
			if(sizeof($arrUsr)>0)
			{
				foreach($arrUsr as $u)
				{
					
					if($listUsuario=="")
						$listUsuario=$u["idUsuario"];
					else
						$listUsuario.=','.$u["idUsuario"];
				}
			}
		}
		
		if($listUsuario=="")
			$listUsuario=-1;
		$consulta="SELECT i.idUsuario,upper(CONCAT(Paterno,' ',Materno,' ',Nom)) AS nombre,a.idGrupo,a.idGrupoOrigen FROM 802_identifica i,4517_alumnosVsMateriaGrupo a
				WHERE  i.idUsuario in (".$listUsuario.") and a.idUsuario=i.idUsuario AND a.idGrupo=".$idGrupo." and situacion=1 ORDER BY Paterno,Materno,Nom";
		
		$res=$con->obtenerFilas($consulta);

		$cadRegistros="";
		$nReg=0;
		$posRegistro=0;
		
		while($fila=mysql_fetch_row($res))
		{
			$posRegistro++;
			$nReg++;
			$dAlumno="";
			$recalcular=false;
			$idGrupoOrigen=$fila[2];
			if($fila[3]!="")
			{
				$idGrupoOrigen=$fila[3];
			}
			$dAlumno=obtenerOrigenGrupoAlumno($idGrupoOrigen);
			
			$obj='{"registraCalificacion":"@registraCalificacion","comentarios":"@comentarios","idUsuario":"'.$fila[0].'","alumno":"'.cv($fila[1]).'","dAlumno":"'.$dAlumno.'","idGrupoOrigen":"'.$idGrupoOrigen.'"';	
			$arrCalificaciones=array();
			$consulta="SELECT * FROM 4568_calificacionesCriteriosAlumnoPerfilMateria WHERE idAlumno=".$fila[0]." AND idGrupo=".$idGrupo." AND idCriterio in (".$cadCriterios.") 
						AND tipoEvaluacion=".$tipoEvaluacion." and noEvaluacion=".$noEvaluacion." and bloque=0";
			$resCal=$con->obtenerFilas($consulta);
			while($fCal=mysql_fetch_row($resCal))
			{
				$arrCalificaciones["c_".$fCal[3]]=$fCal[5];
				if($fCal[6]=='')
					$fCal[6]=0;
				$arrCalificaciones["porcentaje_".$fCal[3]]=$fCal[6];
				$arrCalificaciones["tConsidera_".$fCal[3]]=$fCal[8];
			}
			
			for($x=4;$x<$tamCriterios;$x++)
			{
				$valor=0;
				
				$arrDatos=explode("_",$objCriterio->criterios[$x]->name);
				$confCriterio=$arrConfiguracionCriterio[$arrDatos[1]];
				switch($arrDatos[0])
				{
					case "porcentaje":
						if(isset($arrCalificaciones[$objCriterio->criterios[$x]->name]))
							$valor=$arrCalificaciones[$objCriterio->criterios[$x]->name];
					break;
					case "c":
						
						if($situacionEvaluacion!=2)
						{
							
							switch($confCriterio[0])
							{
								case "1": //Manual
									if(isset($arrCalificaciones[$objCriterio->criterios[$x]->name]))
										$valor=$arrCalificaciones[$objCriterio->criterios[$x]->name];
								break;
								case "2": //Automatico
									$cadObj='{"idCriterio":"'.$arrDatos[1].'","idGrupo":"'.$idGrupo.'","idUsuario":"'.$fila[0].'","bloque":"'.$bloque.'","tipoEvaluacion":"'.$tipoEvaluacion.'","noEvaluacion":"'.$noEvaluacion.'"}';
									$objTmp=json_decode($cadObj);
									
									$valor=resolverExpresionCalculoPHP($confCriterio[1],$objTmp,$cache);
									if(!is_numeric($valor))
										$valor=0;
									$valorAux=0;
									if(isset($arrCalificaciones[$objCriterio->criterios[$x]->name]))
									{
										$valorAux=$arrCalificaciones[$objCriterio->criterios[$x]->name];
									}
									if(abs($valor-$valorAux)>0.0001)
									{
										$recalcular=true;
										recalcularCalificacionesGrupo($idGrupo,$arrDatos[1],$bloque,$tipoEvaluacion,$noEvaluacion,$fila[0]);
									}
								break;
							}
						}
						else
						{
							$valor=0;
							if(isset($arrCalificaciones[$objCriterio->criterios[$x]->name]))
							{
								$valor=$arrCalificaciones[$objCriterio->criterios[$x]->name];
							}
						}
					break;
					case "tConsidera":
						if($situacionEvaluacion!=2)
						{
							$consulta="SELECT valMax FROM 4571_valoresMaximosCriterioPerfilMateria WHERE idGrupo=".$idGrupo." AND noBloque=0 AND idCriterio='".$arrDatos[1]."' and tipoEvaluacion=".
										$tipoEvaluacion." and noEvaluacion=".$noEvaluacion;
							$fCriterio=$con->obtenerPrimeraFila($consulta);
							if(!$fCriterio)
							{
									
								switch($confCriterio[3])
								{
									case "1": //Valor máximo de escala de evaluación
										$consulta="SELECT max(valorMaximo) FROM 4033_elementosEscala WHERE idEscalaCalificacion=".$confCriterio[5];
										$valor=$con->obtenerValor($consulta);
									break;
									case "2": //Valor constante
										$valor=$confCriterio[4];
									break;
									case "3"://Automático (Mediante función de sistema)
										
										$cadObj='{"idCriterio":"'.$arrDatos[1].'","idGrupo":"'.$idGrupo.'","idUsuario":"'.$fila[0].'","bloque":"'.$bloque.'","tipoEvaluacion":"'.$tipoEvaluacion.'","noEvaluacion":"'.$noEvaluacion.'"}';
										$objTmp=json_decode($cadObj);
										$valor=resolverExpresionCalculoPHP($confCriterio[2],$objTmp,$cache);
									break;
								}
							}
							else
								$valor=$fCriterio[0];
								
							if(!is_numeric($valor))
								$valor=0;
							$valorAux=0;
							if(isset($arrCalificaciones[$objCriterio->criterios[$x]->name]))
							{
								$valorAux=$arrCalificaciones[$objCriterio->criterios[$x]->name];
								
							}	
							if(abs($valor-$valorAux)>0.0001)
							{
								$recalcular=true;
								recalcularCalificacionesGrupo($idGrupo,$arrDatos[1],$bloque,$tipoEvaluacion,$noEvaluacion,$fila[0]);
							}
						}
						else
						{
							$valor=0;
							if(isset($arrCalificaciones[$objCriterio->criterios[$x]->name]))
							{
								$valor=$arrCalificaciones[$objCriterio->criterios[$x]->name];
							}
						}
					break;
				}

				if($valor=="")
					$valor=0;

				$obj.=',"'.$objCriterio->criterios[$x]->name.'":"'.removerCerosDerecha($valor).'"';
			}
			
			$consulta="SELECT valor FROM 4569_calificacionesEvaluacionAlumnoPerfilMateria WHERE idAlumno=".$fila[0]." AND idGrupo=".$idGrupo.
						" AND bloque=0 and tipoEvaluacion=".$tipoEvaluacion." and noEvaluacion=".$noEvaluacion;
			$valor=$con->obtenerValor($consulta);
			if($valor=="")
				$valor=0;

			$totalEval=removerCerosDerecha($valor);
			
			$obj.=',"total":"@total"}';
			if(!$recalcular)
			{
				$registraCalificacion=1;
				$comentarios="";
				
				$idFuncionAsientaCalificacion=obtenerValorConfiguracionEvaluacion($idReferenciaExamenes,$tipoEvaluacion,7);//FUncion asienta calificacion
				if($idFuncionAsientaCalificacion!=0)
				{
					$cTmp='{"idGrupo":"'.$idGrupo.'","tipoEvaluacion":"'.$tipoEvaluacion.'","noEvaluacion":"'.$noEvaluacion.'","objUsr":null}';
					$objTmp=json_decode($cTmp);
					$objTmp->objUsr=json_decode($obj);
					$oResp=resolverExpresionCalculoPHP($idFuncionAsientaCalificacion,$objTmp,$cache);			
					if(gettype($oResp)=="array")
					{
						$registraCalificacion=$oResp["registraCalificacion"];
						if(isset($oResp["comentarios"]))
							$comentarios=$oResp["comentarios"];
						if(isset($oResp["totalEvaluacion"]))
						{
							$totalEval=$oResp["totalEvaluacion"];
							
							if($totalEval<0)
							{
								$consulta="update 4569_calificacionesEvaluacionAlumnoPerfilMateria  set valor=".$totalEval." WHERE idAlumno=".$fila[0]." AND idGrupo=".$idGrupo." AND bloque=0 and tipoEvaluacion=".$tipoEvaluacion." and noEvaluacion=".$noEvaluacion;
								$con->ejecutarConsulta($consulta);
							}	
						}
							
					}
					else
					{
						$registraCalificacion=removerComillasLimite($oResp);
						
					}
					/*if($totalEval<0)
						$registraCalificacion=0;*/
				}
				
				
				
				$obj=str_replace("@registraCalificacion",$registraCalificacion,$obj);
				$obj=str_replace("@comentarios",$comentarios,$obj);
				$obj=str_replace("@total",$totalEval,$obj);			
				
				if($cadRegistros=="")
					$cadRegistros=$obj;
				else
					$cadRegistros.=",".$obj;
			}
			else
			{
				$posRegistro--;
				$nReg--;
				mysql_data_seek($res,$posRegistro);
				
			}
		}
		
		echo '{"numReg":"'.$nReg.'","registros":['.$cadRegistros.']}';
	}
	
	function guardarCalificacionAlumnoBloquePerfilEvaluacion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$query="SELECT idPlanEstudio,idInstanciaPlanEstudio,idMateria FROM 4520_grupos WHERE idGrupos=".$obj->idGrupo;
		$fGrupo=$con->obtenerPrimeraFila($query);
		$query="SELECT calificacionMinimaAprobatoria FROM 4592_configuracionPerfilEvaluacion WHERE idPlanEstudio=".$fGrupo[0]." AND idMateria=".$fGrupo[2]." AND idInstanciaPlanEstudio IN (".$fGrupo[1].",-1) AND idGrupo IN (".$obj->idGrupo.",-1)
				AND tipoExamen=".$obj->tipoEvaluacion." AND noExamen=".$obj->noEvaluacion." order by idGrupo desc,idInstanciaPlanEstudio desc";
		$calMinima=$con->obtenerValor($query);
		$aprobado=0;
		
		if($calMinima<=($obj->totalBloque/10))
			$aprobado=1;
		$query="SELECT idInstanciaPlan,idMateria FROM 4517_alumnosVsMateriaGrupo WHERE idUsuario=".$obj->idAlumno." and idGrupo=".$obj->idGrupo;
	
		$fInscripcion=$con->obtenerPrimeraFila($query);
		$x=0;
		
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 4568_calificacionesCriteriosAlumnoPerfilMateria WHERE idAlumno=".$obj->idAlumno." AND idGrupo=".$obj->idGrupo." and bloque=".$obj->bloque." and tipoEvaluacion=".$obj->tipoEvaluacion." and noEvaluacion=".$obj->noEvaluacion;
		$x++;
		foreach($obj->criterios as $c)
		{
			$consulta[$x]="INSERT 4568_calificacionesCriteriosAlumnoPerfilMateria (idAlumno,idGrupo,idCriterio,bloque,valor,porcentajeObtenido,porcentajeValor,totalConsiderar,tipoEvaluacion,noEvaluacion)
							VALUES(".$obj->idAlumno.",".$obj->idGrupo.",'".$c->criterio."',".$obj->bloque.",".$c->valor.",".$c->porcentajeObtenido.",".$c->porcentajeValor.",".$c->totalConsiderar.",".$obj->tipoEvaluacion.",".$obj->noEvaluacion.")";
			$x++;
		}
		$consulta[$x]="delete from 4569_calificacionesEvaluacionAlumnoPerfilMateria where idAlumno=".$obj->idAlumno." and idGrupo=".$obj->idGrupo." and bloque=".$obj->bloque." and tipoEvaluacion=".$obj->tipoEvaluacion." and noEvaluacion=".$obj->noEvaluacion;
		$x++;
		$consulta[$x]="INSERT INTO 4569_calificacionesEvaluacionAlumnoPerfilMateria(idAlumno,idGrupo,bloque,valor,tipoEvaluacion,noEvaluacion,aprobado,idMateria) 
					VALUES(".$obj->idAlumno.",".$obj->idGrupo.",".$obj->bloque.",".$obj->totalBloque.",".$obj->tipoEvaluacion.",".$obj->noEvaluacion.",".$aprobado.",".$fInscripcion[1].")";
		$x++;
		
		
		$query="SELECT idSituacionAplicacionEvaluacion FROM 4593_situacionEvaluacionCurso WHERE idGrupo=".$obj->idGrupo." AND tipoExamen=".$obj->tipoEvaluacion." AND noExamen=".$obj->noEvaluacion;
		$nReg=$con->obtenerValor($query);
		if($nReg=="")
		{
			$consulta[$x]="INSERT INTO 4593_situacionEvaluacionCurso(idGrupo,tipoExamen,noExamen,situacion,idResponsable,fechaRegistro) VALUES(".$obj->idGrupo.",".$obj->tipoEvaluacion.",".$obj->noEvaluacion.",1,".$_SESSION["idUsr"].",'".date("Y-m-d")."')";
			$x++;
		}
		else
		{
			$consulta[$x]="update 4593_situacionEvaluacionCurso set idResponsable=".$_SESSION["idUsr"].",fechaRegistro='".date("Y-m-d")."' where idSituacionAplicacionEvaluacion=".$nReg;
			$x++;
		}
		
		if(esCalificacionFinal($obj->tipoEvaluacion))
		{
		
			$query="SELECT idAdeudoMateria FROM 4607_materiasAdeudoAlumno WHERE idAlumno=".$obj->idAlumno." AND idMateria=".$fInscripcion[1]." and idInstanciaPlan=".$fInscripcion[0];
			
			$idAdeudoMateria=$con->obtenerValor($query);
			if($idAdeudoMateria!="")
			{
				if($aprobado==1)
				{
					$consulta[$x]="UPDATE 4607_materiasAdeudoAlumno SET situacion=0 WHERE idAdeudoMateria=".$idAdeudoMateria;
					$x++;
				}	
				else
				{
					$consulta[$x]="UPDATE 4607_materiasAdeudoAlumno SET situacion=1 WHERE idAdeudoMateria=".$idAdeudoMateria;
					$x++;	
				}
			}
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			echo "1|";
		}
		
	}
	
	function cerrarCapturaEvaluacion()
	{
		global $con;

		$idGrupo=$_POST["idGrupo"];
		$tipoEvaluacion=$_POST["tipoEvaluacion"];
		$noEvaluacion=$_POST["noEvaluacion"];
		$consulta="";
		$query="SELECT idSituacionAplicacionEvaluacion FROM 4593_situacionEvaluacionCurso WHERE idGrupo=".$idGrupo." AND tipoExamen=".$tipoEvaluacion." AND noExamen=".$noEvaluacion;
		
		$nReg=$con->obtenerValor($query);
		if($nReg=="")
			$consulta="INSERT INTO 4593_situacionEvaluacionCurso(idGrupo,tipoExamen,noExamen,situacion,idResponsable,fechaRegistro) VALUES(".$idGrupo.",".$tipoEvaluacion.",".$noEvaluacion.",2,".$_SESSION["idUsr"].",'".date("Y-m-d")."')";
		else
			$consulta="update 4593_situacionEvaluacionCurso set situacion=2, idResponsable=".$_SESSION["idUsr"].",fechaRegistro='".date("Y-m-d")."' where idSituacionAplicacionEvaluacion=".$nReg;
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="SELECT idInstanciaPlanEstudio,idMateria FROM 4520_grupos WHERE idGrupos=".$idGrupo;
			$fGrupo=$con->obtenerPrimeraFila($consulta);
			$consulta="SELECT idPerfilEvaluacionMateria FROM 4592_configuracionPerfilEvaluacion WHERE idInstanciaPlanEstudio=".$fGrupo[0]." AND idMateria=".$fGrupo[1]." AND 
					idGrupo IN(-1,".$idGrupo.") AND tipoExamen=".$tipoEvaluacion." AND noExamen=".$noEvaluacion." ORDER BY idGrupo DESC";

			$idPerfilEvaluacionMateria=$con->obtenerValor($consulta);
			if($idPerfilEvaluacionMateria=="")
				$idPerfilEvaluacionMateria=-1;
			$cache=NULL;
			$consulta="SELECT idFuncion FROM 4606_funcionesConfiguracionPerfilEvaluacion WHERE tipoFuncion=1 AND idPerfilEvaluacionMateria=".$idPerfilEvaluacionMateria;
			
			$resFunc=$con->obtenerFilas($consulta);
			while($fFuncion=mysql_fetch_row($resFunc))
			{
				$cTmp='{"idInstanciaPlanEstudio":"'.$fGrupo[0].'","idMateria":"'.$fGrupo[1].'","idGrupo":"'.$idGrupo.'","tipoEvaluacion":"'.$tipoEvaluacion.'","noEvaluacion":"'.$noEvaluacion.'"}';
				$objTmp=json_decode($cTmp);
				
				
				$oResp=resolverExpresionCalculoPHP($fFuncion[0],$objTmp,$cache);		
					
			}
			
			echo "1|";	
		}
		
	}
	
	function obtenerSolicitudesCambioEvaluacion()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$tipoEvaluacion=$_POST["tipoEvaluacion"];
		$noEvaluacion=$_POST["noEvaluacion"];
		$consulta="SELECT id__885_tablaDinamica AS idSolicitud,fechaCreacion AS fechaSolicitud, motivoCambio,
		(SELECT Nombre FROM 800_usuarios WHERE idUsuario=t.responsable)  AS responsableSolicitud,
		idEstado AS situacion,
		(SELECT fechaHoraDictamen FROM 2002_comentariosRegistro WHERE idFormulario=885 AND idRegistro=t.id__885_tablaDinamica ORDER BY idComentario DESC LIMIT 0,1) AS fechaRespuesta,
		(SELECT comentario FROM 2002_comentariosRegistro WHERE idFormulario=885 AND idRegistro=t.id__885_tablaDinamica ORDER BY idComentario DESC LIMIT 0,1) AS comentariosRespuesta
		FROM _885_tablaDinamica t WHERE idGrupo=".$idGrupo." AND tipoEvaluacion=".$tipoEvaluacion." AND noEvaluacion=".$noEvaluacion." ORDER BY fechaCreacion";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';

	}
	
	function marcarDesmarcarAlumnoEvaluacion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];	
		$obj=json_decode($cadObj);
		$x=0;
		$query[$x]="begin";
		$x++;
		foreach($obj->arrUsuarios as $a)
		{
			
			$query[$x]="UPDATE 4569_calificacionesEvaluacionAlumnoPerfilMateria SET valor=".$obj->accion." WHERE idAlumno=".$a->idUsuario." AND idGrupo=".$obj->idGrupo." AND tipoEvaluacion=".$obj->tipoEvaluacion." AND noEvaluacion=".$obj->noEvaluacion;
			$x++;
		}
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
		{
			if($obj->accion==0)
			{
				foreach($obj->arrUsuarios as $a)
				{
					$consulta="SELECT idCriterio FROM 4568_calificacionesCriteriosAlumnoPerfilMateria WHERE idAlumno=".$a->idUsuario." AND idGrupo=".$obj->idGrupo." AND tipoEvaluacion=".$obj->tipoEvaluacion." AND noEvaluacion=".$obj->noEvaluacion;
				
					$criterio=$con->obtenerValor($consulta);
					recalcularCalificacionesGrupo($obj->idGrupo,$criterio,0,$obj->tipoEvaluacion,$obj->noEvaluacion,$a->idUsuario);
				}
			
			}
			echo "1|";	
		}
		
	}
?>