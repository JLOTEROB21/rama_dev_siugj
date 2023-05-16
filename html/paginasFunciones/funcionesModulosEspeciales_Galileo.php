<?php session_start();
	ini_set("memory_limit","256M");
	ini_set('max_execution_time',360000);
	set_time_limit (360000);
		
	;

	include("funcionesFormularios.php"); 
	include("configurarIdioma.php");
	include_once("conexionBDGalileo.php");
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	

	switch($funcion)
	{
		case 1:
			obtenerListaGrupo();
		break;
		case 2:
			guardarAsistencia();
		break;
		case 3:
			obtenerListaGrupoTareas();
		break;
		case 4:
			guardarAsistenciaTareas();
		break;
		case 5:
			obtenerDatosCurso();
		break;
		case 6:
			obtenerPlantelesCursoVeracruz();
		break;
		case 7:
			obtenerAsistenciaProfesoresVeracruz();
		break;
		case 8:
			obtenerAsistentesVeracruz();
		break;
		case 9:
			guardarAsistenciaVeracruz();
		break;
		case 10:
			obtenerTareasProfesor();
		break;
		case 11:
			obtenerFacilitadoresProyecto();
		break;
		case 12:
			obtenerPeriodosCiclo();
		break;
		case 13:
			obtenerCursosPeriodosCiclo();
		break;
		case 14:
			obtenerSubsistemasCursos();
		break;
		case 15:
			obtenerFacilitadorSubsistema();
		break;
		case 16:
			obtenerTareasProfesorCursoCicloPeriodo();
		break;
		case 17:
			obtenerTemarioProyecto();
		break;
		case 18:
			guardarTemaProyecto();
		break;
		case 19:	
			removerTemaProyecto();
		break;
		case 20:
			obtenerSesionesProyecto();
		break;
		case 21:
			obtenerTemarioSesionesProyecto();
		break;
		case 22:
			guardarTemasSesionProyecto();
		break;
		case 23:
			modificarNoSesiones();
		break;
		case 24:
			clonarProyecto();
		break;
		case 25:
			obtenerProyectosInscritos();
		break;
		case 26:
			obtenerTareasSesionProyecto();
		break;
		case 27:
			removerTareaSesionProyecto();
		break;
		case 28:
			registrarRecursoProyecto();
		break;
		case 29:
			obtenerRecursosProyectoSesion();
		break;
		case 30:
			removerRecursoSesionProyecto();
		break;
		case 31:
			verificarEmailAsistenciaProyecto();
		break;
		case 32;
			obtenerPlanteles();
		break;
		case 33;
			obtenerTurnosPlantel();
		break;
		case 34:
			registrarUsuarioProyecto();
		break;
		case 35:
			obtenerDocumentosTareaUsuarioProyecto();
		break;
		case 36:
			enviarTareaProyecto();
		break;
		case 37:
			removerDocumentoTareaProyecto();
		break;
		case 38:
			guardarDocumentoTareaProyecto();
		break;
		case 39:
			obtenerTareasSesionProyectoAlumno();
		break;
		case 40:
			obtenerTareasSesionProyectoFacilitador();
		break;
		case 41:
			evaluarTareaSesion();
			
		break;
		case 42:
			obtenerPlantelCCT();
		break;
		case 43:
			obtenerLocalidadesPlanteles();
		break;
		case 44:
			registrarPlantelInscripcionProyecto();
		break;
		case 45:
			guardarComentarioUsuarioProyecto();	

		break;
		case 46:
			obtenerComentariosDudasProyecto();
		break;
		case 47:
			obtenerProyectosGalileo();
		break;
		case 48:
			obtenerInscritosProyecto();
		break;
		
	}
	
	
	function obtenerListaGrupo()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$idSesion=$_POST["idSesion"];
		$consulta="SELECT id__350_tablaDinamica FROM _350_tablaDinamica WHERE fechaSesion=".$idSesion." and idReferencia=".$idReferencia;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
			$idRegistro=-1;
		$cadObj="";
		$consulta="SELECT u.idUsuario,upper(Nombre) FROM 246_autoresVSProyecto  a, 800_usuarios u  WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." 
					AND claveParticipacion=44 AND u.idUsuario=a.idUsuario ORDER BY Nombre";
	
		$res=$con->obtenerFilas($consulta);
		$nRegistros=$con->filasAfectadas;
		$cadObj="";
		while($fila=mysql_fetch_row($res))
		{
			
			$consulta="select COUNT(*)  FROM _350_gridAsistencia WHERE idReferencia=".$idRegistro." AND asistente=".$fila[0];
			$asistencia="false";
			if($con->obtenerValor($consulta)>0)
				$asistencia="true";
			
			$obj='{"idUsuarioAsistente":"'.$fila[0].'","nombre":"'.$fila[1].'","asistencia":'.$asistencia.',"plantel":""}';
			if($cadObj=="")
				$cadObj=$obj;
			else
				$cadObj.=",".$obj;
		}
		echo '{"numReg":"'.$nRegistros.'","registros":['.$cadObj.']}';
		
	}
	
	function guardarAsistencia()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$query="SELECT id__350_tablaDinamica FROM _350_tablaDinamica WHERE fechaSesion=".$obj->idSesion." and idReferencia=".$obj->idReferencia;
		$idRegistro=$con->obtenerValor($query);
		if($idRegistro=="")
		{
			$consulta[$x]="INSERT INTO _350_tablaDinamica(idReferencia,fechaCreacion,responsable,fechaSesion) 
							VALUES(".$obj->idReferencia.",'".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",".$obj->idSesion.")";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;							
		}
		else
		{
			$consulta[$x]="DELETE FROM _350_gridAsistencia WHERE idReferencia=".$idRegistro;
			$x++;
			$consulta[$x]="set @idRegistro:=".$idRegistro;
			$x++;
		}
		foreach($obj->arrUsuarios as $o)
		{
			$consulta[$x]="INSERT INTO _350_gridAsistencia(idReferencia,asistente) VALUES(@idRegistro,".$o->idUsuario.")";
			$x++;
		}
		

			
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
		
	}
	
	function obtenerListaGrupoTareas()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$idSesion=$_POST["idSesion"];
		$consulta="SELECT id__351_tablaDinamica FROM _351_tablaDinamica WHERE fechaSesion=".$idSesion." and idReferencia=".$idReferencia;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
			$idRegistro=-1;
		$cadObj="";
		$consulta="SELECT u.idUsuario,upper(Nombre) FROM 246_autoresVSProyecto  a, 800_usuarios u  WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." 
					AND claveParticipacion=44 AND u.idUsuario=a.idUsuario ORDER BY Nombre";
	
		$res=$con->obtenerFilas($consulta);
		$nRegistros=$con->filasAfectadas;
		$cadObj="";
		while($fila=mysql_fetch_row($res))
		{
			
			$consulta="select COUNT(*)  FROM _351_grdiListaTareas WHERE idReferencia=".$idRegistro." AND asistentes=".$fila[0];
			$asistencia="false";
			if($con->obtenerValor($consulta)>0)
				$asistencia="true";
			
			$obj='{"idUsuarioAsistente":"'.$fila[0].'","nombre":"'.$fila[1].'","asistencia":'.$asistencia.',"plantel":""}';
			if($cadObj=="")
				$cadObj=$obj;
			else
				$cadObj.=",".$obj;
		}
		echo '{"numReg":"'.$nRegistros.'","registros":['.$cadObj.']}';
		
	}
	
	function guardarAsistenciaTareas()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$query="SELECT id__351_tablaDinamica FROM _351_tablaDinamica WHERE fechaSesion=".$obj->idSesion." and idReferencia=".$obj->idReferencia;
		$idRegistro=$con->obtenerValor($query);
		if($idRegistro=="")
		{
			$consulta[$x]="INSERT INTO _351_tablaDinamica(idReferencia,fechaCreacion,responsable,fechaSesion) 
							VALUES(".$obj->idReferencia.",'".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",".$obj->idSesion.")";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;							
		}
		else
		{
			$consulta[$x]="DELETE FROM _351_grdiListaTareas WHERE idReferencia=".$idRegistro;
			$x++;
			$consulta[$x]="set @idRegistro:=".$idRegistro;
			$x++;
		}
		foreach($obj->arrUsuarios as $o)
		{
			$consulta[$x]="INSERT INTO _351_grdiListaTareas(idReferencia,asistentes) VALUES(@idRegistro,".$o->idUsuario.")";
			$x++;
		}
		

			
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
		
	}
	
	function obtenerDatosCurso()
	{
		global $con;
		$idCurso=$_POST["idCurso"];
		$consulta="SELECT noSesion,CONCAT('Sesión ',noSesion) FROM _348_gridFechasSesion g,_348_tablaDinamica t WHERE g.idReferencia=t.id__348_tablaDinamica AND t.idReferencia=".$idCurso." ORDER BY noSesion";
		$arrSesiones=$con->obtenerFilasArreglo($consulta);
		$consulta="SELECT id__352_tablaDinamica,cveGrupo FROM _352_tablaDinamica WHERE cursosGalileo=".$idCurso." ORDER BY cveGrupo";
		$arrGrupos=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrGrupos."|".$arrSesiones;
		
	}
	
	function obtenerPlantelesCursoVeracruz()
	{
		global $conGalileo;
		$municipio=$_POST["idMunicipio"];
		$consulta="SELECT cct,nombre FROM escuelasver WHERE municipio=".$municipio." and cct in (SELECT DISTINCT(TRIM(cct)) FROM insccur3rosec) order by nombre";
		$arrReg=$conGalileo->obtenerFilasArreglo($consulta);
		echo "1|".$arrReg;
	}
	
	function obtenerAsistenciaProfesoresVeracruz()
	{
		global $con;
		$idCurso=$_POST["idCurso"];
		$idProfesor=$_POST["idProfesor"];
		$fechaSesion=$_POST["fechaSesion"];
		$consulta="SELECT id__352_tablaDinamica,cveGrupo FROM _352_tablaDinamica WHERE cursosGalileo=".$idCurso;		
		$resCursos=$con->obtenerFilas($consulta);
		$cadReg="";
		$ct=0;
		while($fila=mysql_fetch_row($resCursos))
		{
			$total="";
			$consulta="select noAsistentes from 0_asistenciaVeracruz where fechaAsistencia='".$fechaSesion."' and idProfesor=".$idProfesor." and idHorario=".$fila[0];
			$total=$con->obtenerValor($consulta);
			if($total=="")
				$total=0;
			$obj='{"idHorario":"'.$fila[0].'","horario":"'.$fila[1].'","totalAlumno":"'.$total.'"}';
			if($cadReg=="")
				$cadReg=$obj;
			else
				$cadReg.=",".$obj;
			$ct++;
		}
		echo '{"numReg":"'.$ct.'","registros":['.$cadReg.']}';
	}
	
	function obtenerAsistentesVeracruz()
	{
		global $conGalileo;
		$plantel=$_POST["plantel"];
		$consulta="SELECT id AS idUsuarioAsistente,UPPER(CONCAT(apellidos,' ',nombre))AS nombre FROM insccur3rosec  WHERE trim(cct)='".$plantel."' ORDER BY apellidos,nombre";
		$reg=$conGalileo->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$conGalileo->filasAfectadas.'","registros":'.utf8_encode($reg).'}';
		
	}
	
	function guardarAsistenciaVeracruz()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($obj->registros as $r)
		{
			$consulta[$x]="delete from 0_asistenciaVeracruz where fechaAsistencia='".$obj->fechaSesion."' and idProfesor=".$obj->idUsuario." and idHorario=".$r->idGrupo;
			$x++;

			$consulta[$x]="INSERT INTO 0_asistenciaVeracruz(fechaAsistencia,idProfesor,idHorario,noAsistentes) VALUES('".$obj->fechaSesion."',".$obj->idUsuario.",".$r->idGrupo.",".$r->noAsistentes.")";
			$x++;
		}
		$consulta[$x]="commit";

		$x++;
		eB($consulta);
	}
	
	function obtenerTareasProfesor()
	{
		global $con;
		global $conGalileo;
		$curso=8;
		$listGrupos="-1";
		if(isset($_POST["listGrupos"]))
			$listGrupos=$_POST["listGrupos"];
		$nFacilitador=$_POST["nFacilitador"];
		$arrDatosCurso=array();
		
		$consulta="SELECT GROUP_CONCAT(id__337_tablaDinamica) FROM _337_tablaDinamica WHERE cursos=".$curso;
		$listRef=$con->obtenerValor($consulta);
		$consulta="SELECT subsistema,idReferencia FROM _337_subsistemas WHERE idReferencia IN (".$listRef.")";
		$resSub=$con->obtenerFilas($consulta);
		while($filaSub=mysql_fetch_row($resSub))
		{
			$arrDatosCurso[$filaSub[0]]=array();
			$consulta="SELECT MIN(fechaSesion) FROM _337_gridFechas WHERE idReferencia=".$filaSub[1];
			$arrDatosCurso[$filaSub[0]]["fechaInicio"]=$con->obtenerValor($consulta);
			$consulta="SELECT MAX(fechaSesion) FROM _337_gridFechas WHERE idReferencia=".$filaSub[1];
			$arrDatosCurso[$filaSub[0]]["fechaFin"]=$con->obtenerValor($consulta);
			$arrDatosCurso[$filaSub[0]]["arrMaterias"]=array();
			$consulta="SELECT txtMateria FROM _337_gridFechas g,_336_tablaDinamica t WHERE t.id__336_tablaDinamica=g.materiaImparte AND g.idReferencia=".$filaSub[1]." and g.noSesion=1";
			$arrDatosCurso[$filaSub[0]]["arrMaterias"][0]=$con->obtenerValor($consulta);
			$consulta="SELECT txtMateria FROM _337_gridFechas g,_336_tablaDinamica t WHERE t.id__336_tablaDinamica=g.materiaImparte AND g.idReferencia=".$filaSub[1]." and g.noSesion=2";
			$arrDatosCurso[$filaSub[0]]["arrMaterias"][1]=$con->obtenerValor($consulta);
			$consulta="SELECT txtMateria FROM _337_gridFechas g,_336_tablaDinamica t WHERE t.id__336_tablaDinamica=g.materiaImparte AND g.idReferencia=".$filaSub[1]." and g.noSesion=3";
			$arrDatosCurso[$filaSub[0]]["arrMaterias"][2]=$con->obtenerValor($consulta);
			
		}
		
		
		$consulta="SELECT cveCurso,txtDescripcion FROM _246_tablaDinamica WHERE id__246_tablaDinamica=".$curso;
		$fCurso=$con->obtenerPrimeraFila($consulta);
		$lCursos=$fCurso[0];
		$curso=$fCurso[1];
		$arrFacilitadores=array();
		
		$arrFacilitadores[$nFacilitador]=array();
		/*
		$consulta="SELECT DISTINCT clvfac FROM inscritosxsede where curso in (".$lCursos.") and clvfac='".$facilitador."'";

		$res=$conGalileo->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$arrFacilitadores[$fila[0]]=array();
		}	*/						
		
		$arrTareas=array();
		$nPos=1;
		for($x=1;$x<=12;$x++)
		{
			$consulta="SELECT GROUP_CONCAT(id) FROM mdl_assignment WHERE course IN (4,5,7) AND NAME LIKE '%Tarea ".$x.".%'";
			$lTareas=$conGalileo->obtenerValor($consulta);
			if(!isset($arrTareas[$nPos]))
				$arrTareas[$nPos]=$lTareas;
			else
				$arrTareas[$nPos].=",".$lTareas;
			$nPos++;
			if($nPos>3)
				$nPos=1;
		}
		
		foreach($arrFacilitadores as $idFacilitador=>$resto)
		{
			$consulta="SELECT upper(u.lastname),upper(u.firstname),iduser,idgrupo,cct_sede FROM inscritosxsede i,mdl_user u 
						WHERE u.id=i.iduser AND i.curso in(".$lCursos.") and idGrupo in (".$listGrupos.") order by u.lastname,u.firstname";
			$res=$conGalileo->obtenerFilas($consulta);
			
			while($fila=mysql_fetch_row($res))
			{
				$obj[0]=$fila[2];
				$nombreProf=$fila[0];
				if($nombreProf!=$fila[1])
					$nombreProf.=" ".$fila[1];
				$obj[1]=$nombreProf;
				$obj[2]=$fila[3];
				$obj[3]=array();
				$obj[3][1]=0;
				$obj[3][2]=0;
				$obj[3][3]=0;
				for($x=1;$x<=3;$x++)
				{
					$consulta="SELECT COUNT(*) FROM mdl_assignment_submissions WHERE userid=".$fila[2]." AND assignment IN (".$arrTareas[$x].") and grade=1";
					$nTareas=$conGalileo->obtenerValor($consulta);
					$obj[3][$x]+=$nTareas;
				}
				$nombreProf=$fila[1];
				if($nombreProf!=$fila[0])
					$nombreProf.=" ".$fila[0];
				$obj[4]=$nombreProf;
				$consulta="SELECT codigoUnidad FROM 817_organigrama WHERE codigoDepto='".$fila[4]."'";
				$obj[5]=$con->obtenerValor($consulta);
				if($obj[5]=="")
					continue;
				array_push($arrFacilitadores[$idFacilitador],$obj);
		
			}
		}
		
		
		$arrObj="";
		$ct=0;
		foreach($arrFacilitadores as $idFacilitador=>$resto)
		{
			foreach($resto as $obj)
			{
				$cadObj='{"idProfesor":"'.$obj[0].'","nombre":"'.$obj[1].'","geometria":"'.$obj[3][1].'","calculo":"'.$obj[3][2].'","matematicas":"'.$obj[3][3].'"}';
				if($arrObj=="")
					$arrObj=$cadObj;
				else
					$arrObj.=",".$cadObj;
				$ct++;
			}
		}
		echo '{"numReg":"'.$ct.'","registros":['.$arrObj.']}';
	}
	
	function obtenerFacilitadoresProyecto()
	{
		global $conGalileo;
		global $con;
		$proyecto=$_POST["proyecto"];
		
		$consulta="SELECT distinct nombreFacilitador FROM 0_facilitadoresEneJun WHERE cveGrupo LIKE '%".$proyecto."%' order by nombreFacilitador";
		$res=$con->obtenerFilas($consulta);
		$arrRegistros="";
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT DISTINCT cveGrupo FROM 0_facilitadoresEneJun WHERE cveGrupo LIKE '%DGT%' AND nombreFacilitador='".$fila[0]."'";
			$listGrupos=$con->obtenerListaValores($consulta,"'");
			$consulta="SELECT id FROM mdl_groups WHERE NAME IN (".$listGrupos.")";
			$listIdGrupos=$conGalileo->obtenerListaValores($consulta);
			$obj="['".$listIdGrupos."','".$fila[0]."']";
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
		}
		echo "1|[".$arrRegistros."]";
	}
	
	function obtenerPeriodosCiclo()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$consulta="SELECT id__370_gridPeriodos,nombrePeriodo FROM _370_gridPeriodos WHERE idReferencia=".$idCiclo." ORDER BY orden";
		$arrPeriodo=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrPeriodo;
		
		
	}
	
	function obtenerCursosPeriodosCiclo()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		$consulta="SELECT id__246_tablaDinamica,Curso FROM _246_tablaDinamica WHERE ciclo=".$idCiclo." AND periodo=".$idPeriodo." AND modalidadCurso=2 ORDER BY Curso";
		$arrCursos=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrCursos;
	}
	
	
	function obtenerSubsistemasCursos()
	{
		global $con;
		$idCurso=$_POST["idCurso"];
		$consulta="SELECT DISTINCT descripcion,o.unidad FROM 817_organigrama o,_337_subsistemas s,_337_tablaDinamica t 
					WHERE o.codigoUnidad=s.subsistema AND s.idReferencia=t.id__337_tablaDinamica AND t.idReferencia=".$idCurso." ORDER BY o.unidad";
		$arreglo=$con->obtenerFilasArreglo($consulta);
		$consulta="SELECT id__336_tablaDinamica,t.txtMateria FROM _246_MateriasCurso g,_336_tablaDinamica t 
					WHERE g.idReferencia=".$idCurso." AND t.id__336_tablaDinamica=g.materia ORDER BY txtMateria";
		$arrMaterias=$con->obtenerFilasArreglo($consulta);
		$consulta="SELECT pefilCertificado FROM _375_tablaDinamica WHERE idReferencia=".$idCurso;
		$idPerfil=$con->obtenerValor($consulta);
		if($idPerfil=="")
			$idPerfil=-1;
		$consulta="SELECT nombrePerfil,paginaGeneradora,columnaComplementaria,tituloColumna FROM _374_tablaDinamica WHERE id__374_tablaDinamica=".$idPerfil;
		$fPerfil=$con->obtenerPrimeraFila($consulta);
		if($fPerfil[2]=="")
			$fPerfil[2]=0;
		echo "1|".$arreglo."|".$arrMaterias."|".$fPerfil[1]."|".$fPerfil[2]."|".$fPerfil[3];					
					
		
	}
	
	function obtenerFacilitadorSubsistema()
	{
		global $con;
		$idCurso=$_POST["idCurso"];
		$proyecto=$_POST["proyecto"];
		$arrFinal=array();
		$consulta="SELECT distinct u.idUsuario,u.Nombre FROM _373_gridFacilitadores g,_373_tablaDinamica t,800_usuarios u WHERE g.idReferencia=t.id__373_tablaDinamica AND t.idReferencia=".$idCurso
					." AND grupo LIKE '%\\_".$proyecto."\\_%' and facilitador=u.idUsuario";
		
		$res=$con->obtenerFilas($consulta);

		while($fila=mysql_fetch_row($res))
		{
			
			$arrFinal[$fila[0]]=array();
			$arrFinal[$fila[0]]["nombre"]=$fila[1];
			$arrFinal[$fila[0]]["grupos"]="";
			$consulta="SELECT distinct grupo FROM _373_gridFacilitadores g,_373_tablaDinamica t WHERE g.idReferencia=t.id__373_tablaDinamica AND t.idReferencia=".$idCurso
					." AND grupo LIKE '%\\_".$proyecto."\\_%' and facilitador=".$fila[0];
			$resGpo=$con->obtenerFilas($consulta);	
			while($filaGpo=mysql_fetch_row($resGpo))
			{
				if($arrFinal[$fila[0]]["grupos"]=="")
					$arrFinal[$fila[0]]["grupos"]="'".$filaGpo[0]."'";
				else
					$arrFinal[$fila[0]]["grupos"].=",'".$filaGpo[0]."'";
			}
			
			
		}
		$listGrupos="";
		
		if(sizeof($arrFinal)>0)
		{
			foreach($arrFinal as $idGpo=>$resto)
			{
				$obj='["'.$resto["grupos"].'","'.$resto["nombre"].'"]';
				if($listGrupos=="")
					$listGrupos=$obj;
				else
					$listGrupos.=",".$obj;
				
			}
		}
		echo "1|[".$listGrupos."]";
	}
	
	function obtenerTareasProfesorCursoCicloPeriodo()
	{
		global $con;
		global $conGalileo;
		$subsistema=$_POST["subsistema"];
		$idCurso=$_POST["idCurso"];
		$listGrupos="-1";
		if(isset($_POST["listGrupos"]))
			$listGrupos=$_POST["listGrupos"];
		$nFacilitador=$_POST["nFacilitador"];

		$arrDatosCurso=array();
		$consulta="SELECT cveCurso,txtDescripcion FROM _246_tablaDinamica WHERE id__246_tablaDinamica=".$idCurso;
		$fCurso=$con->obtenerPrimeraFila($consulta);
		$lCursos=obtenerCursosMoodleLatis($idCurso);
		$curso=$fCurso[1];
		$consulta="SELECT id__336_tablaDinamica,t.txtMateria FROM _246_MateriasCurso g,_336_tablaDinamica t 
					WHERE g.idReferencia=".$idCurso." AND t.id__336_tablaDinamica=g.materia ORDER BY txtMateria";
		$arrMateriasCurso=array();
		$resMat=$con->obtenerFilas($consulta);
		while($fMat=mysql_fetch_row($resMat))
		{
			array_push($arrMateriasCurso,$fMat[0]);
		}
		
		$arrFacilitadores=array();
		$arrFacilitadores[$nFacilitador]=array();
		$arrTareas=array();
		$arrMateriasTarea=array();
		$nPos=1;
		
		for($x=1;$x<=12;$x++)
		{
			$lTareas=obtenerIDTareas($idCurso,$x);
			if($lTareas=="")
				$lTareas=-1;
			if(!isset($arrTareas[$nPos]))
				$arrTareas[$nPos]=$lTareas;
			else
				$arrTareas[$nPos].=",".$lTareas;
			$nPos++;
		}
		
		$consulta="SELECT codigoUnidad FROM 817_organigrama WHERE descripcion='".$subsistema."'";
		$subsistema=$con->obtenerValor($consulta);
		$consulta="SELECT id__337_tablaDinamica FROM _337_tablaDinamica t,_337_subsistemas s WHERE cursos=".$idCurso." AND s.idReferencia=t.id__337_tablaDinamica AND s.subsistema='".$subsistema."'";
		$idReferencia=$con->obtenerValor($consulta);
		if($idReferencia=="")
			$idReferencia=-1;
		
		
		$arrOrdenTareas=array();
		$consulta="SELECT DISTINCT noTarea,materia FROM _337_gridTareasCurso2 g,_337_tablaDinamica WHERE g.idReferencia=".$idReferencia." ORDER BY noTarea";
		$resMat=$con->obtenerFilas($consulta);
		while($fTarea=mysql_fetch_row($resMat))
		{
			array_push($arrOrdenTareas,$fTarea[1]);
		}
		
		
		$consulta="SELECT id FROM mdl_groups WHERE courseid in(".$lCursos.") AND NAME IN (".$listGrupos.")";
		$listGrupos=$conGalileo->obtenerListaValores($consulta);
		if($listGrupos=="")
			$listGrupos=-1;
		
		$numTareasTotal=sizeof($arrOrdenTareas);
		foreach($arrFacilitadores as $idFacilitador=>$resto)
		{
			$consulta="SELECT upper(u.lastname),upper(u.firstname),iduser,idgrupo,cct_sede FROM inscritosxsede i,mdl_user u 
						WHERE u.id=i.iduser AND i.curso in(".$lCursos.") and idGrupo in (".$listGrupos.") order by u.lastname,u.firstname";
			
			$res=$conGalileo->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$obj[0]=$fila[2];
				$nombreProf=$fila[0];
				if($nombreProf!=$fila[1])
					$nombreProf.=" ".$fila[1];
				$obj[1]=$nombreProf;
				$obj[2]=$fila[3];
				$obj[3]=array();
				$obj[3][1]=0;
				$obj[3][2]=0;
				$obj[3][3]=0;
				$nPosMateria=1;
				foreach($arrMateriasCurso as $idMateria)
				{
					for($nTmp=0;$nTmp<$numTareasTotal;$nTmp++)
					{
						if($arrOrdenTareas[$nTmp]==$idMateria)
						{
							$consulta="SELECT COUNT(*) FROM mdl_assignment_submissions WHERE userid=".$fila[2]." AND assignment IN (".$arrTareas[($nTmp+1)].") and grade=1";
							
							$nTareas=$conGalileo->obtenerValor($consulta);
							
							$obj[3][$nPosMateria]+=$nTareas;
						}
					}
					
					$nPosMateria++;
				}
				$nombreProf=$fila[1];
				if($nombreProf!=$fila[0])
					$nombreProf.=" ".$fila[0];
				$obj[4]=$nombreProf;
				$consulta="SELECT codigoUnidad FROM 817_organigrama WHERE codigoDepto='".$fila[4]."'";
				$obj[5]=$con->obtenerValor($consulta);
				//if($obj[5]=="")
					//continue;
				array_push($arrFacilitadores[$idFacilitador],$obj);
		
			}
		}
		
		$arrObj="";
		$ct=0;
		foreach($arrFacilitadores as $idFacilitador=>$resto)
		{
			foreach($resto as $obj)
			{
				$cadObj='{"idProfesor":"'.$obj[0].'","nombre":"'.$obj[1].'","materia1":"'.$obj[3][1].'","materia2":"'.$obj[3][2].'","materia3":"'.$obj[3][3].'"}';
				if($arrObj=="")
					$arrObj=$cadObj;
				else
					$arrObj.=",".$cadObj;
				$ct++;
			}
		}
		echo '{"numReg":"'.$ct.'","registros":['.$arrObj.']}';
	}
	
	function obtenerTemarioProyecto()
	{
		global $con;
		$tamPalabra=5;
		$idReferencia=$_POST["idReferencia"];
		$cadUnidades="";
		$consulta="SELECT id__402_gridUnidadesTematicas,unidadTematica FROM _402_gridUnidadesTematicas WHERE idReferencia=".$idReferencia." order by orden";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$clave=str_pad($fila[0],$tamPalabra,"0",STR_PAD_LEFT);
			$arrHijos=obtenerTemarioTema($clave);
			$comp="";
			if($arrHijos!="[]")
				$comp=',"leaf":false,"children":'.$arrHijos;
			else
				$comp=',"leaf":true';
			$obj='{"icon":"../images/book.png","id":"'.$clave.'","expanded":true,"text":"<b>Unidad Temática:</b> '.cv($fila[1]).'","tipo":"1"'.$comp.'}';
			if($cadUnidades=="")
				$cadUnidades=$obj;
			else
				$cadUnidades.=",".$obj;
		}
		
		echo "[".$cadUnidades."]";
	}
	
	
	function obtenerTemarioTema($codigoPadre)
	{
		global $con;
		$cadUnidades="";
		$consulta="SELECT codigoUnidad,prefijo,tema,descripcion,orden FROM  3002_temarioProyecto WHERE codigoPadre='".$codigoPadre."' ORDER BY orden";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$arrHijos=obtenerTemarioTema($fila[0]);
			$comp="";
			if($arrHijos!="[]")
				$comp=',"leaf":false,"children":'.$arrHijos;
			else
				$comp=',"leaf":true';
			$lblTexto="";
			if($fila[1]!="")
				$lblTexto=$fila[1].".- ";
			
			$lblTexto.=$fila[2];
			$obj='{"icon":"../images/book_open.png","id":"'.$fila[0].'","expanded":true,"tema":"'.cv($fila[2]).'","text":"'.cv($lblTexto).'","tipo":"2"'.$comp.',"prefijo":"'.cv($fila[1]).'","descripcion":"'.cv($fila[3]).'","orden":"'.$fila[4].'"}';
			if($cadUnidades=="")
				$cadUnidades=$obj;
			else
				$cadUnidades.=",".$obj;
		}
		
		return "[".$cadUnidades."]";
	}
	
	function guardarTemaProyecto()
	{
		global $con;
		$tamPalabra=5;
		$consulta="";
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		if($obj->idTema=="-1")
		{
			$consulta="SELECT MAX(codigoUnidad) FROM 3002_temarioProyecto WHERE codigoPadre='".$obj->codigoPadre."'";
			$codigoUnidad=$con->obtenerValor($consulta);
			
			if($codigoUnidad=="")
				$codigoUnidad=1;
			else
			{
				$codigoUnidad=substr($codigoUnidad,strlen($codigoUnidad)-$tamPalabra);
				$codigoUnidad=($codigoUnidad*1)+1;
			}
				
			
			
			$codigoUnidad=$obj->codigoPadre.str_pad($codigoUnidad,$tamPalabra,"0",STR_PAD_LEFT);
			
			$consulta="INSERT INTO 3002_temarioProyecto(codigoPadre,prefijo,tema,descripcion,orden,codigoUnidad)
						VALUES('".$obj->codigoPadre."','".cv($obj->noTema)."','".cv($obj->titulo)."','".cv($obj->descripcion)."',".$obj->orden.",'".$codigoUnidad."')";
				
		}
		else
		{
			$consulta="UPDATE 3002_temarioProyecto SET prefijo='".cv($obj->noTema)."',tema='".cv($obj->titulo)."',descripcion='".cv($obj->descripcion)."',orden=".$obj->orden." WHERE codigoUnidad='".$obj->idTema."'";
		}
		eC($consulta);
	}
	
	function removerTemaProyecto()
	{
		global $con;
		$codigoUnidad=$_POST["codigoUnidad"];
		$consulta="DELETE FROM 3002_temarioProyecto WHERE codigoUnidad LIKE '".$codigoUnidad."%'";
		eC($consulta);
	}
	
	function obtenerSesionesProyecto()
	{
		global $con;
		$numReg=0;
		$cadSesiones="";
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$consulta="SELECT idSesion,noSesion,fechaSesion,(SELECT unidadTematica FROM _402_gridUnidadesTematicas WHERE id__402_gridUnidadesTematicas=s.idUnidadTematica),noSesionUnidadTematica,idUnidadTematica,tituloSesion 
					FROM 3003_sesionesProyecto s WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." ORDER BY noSesion";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$temario="<table>";
			$consulta="SELECT t.prefijo,t.tema FROM 3004_sesionesVSTemas s,3002_temarioProyecto t WHERE idSesion=".$fila[0]." AND t.codigoUnidad=s.tema ORDER BY codigoPadre,orden";
			$resTemas=$con->obtenerFilas($consulta);
			while($fTema=mysql_fetch_row($resTemas))
			{
				$lblNum="";
				if($fTema[0]!="")
					$lblNum=$fTema[0].".- ";
				$temario.='<tr height=\'21\'><td >'.$lblNum.'</td><td width=\'400\'>'.$fTema[1].'</td></tr>';
			}
			$temario.="</table>";
			$o='{"tema":"'.cv($fila[6]).'","idSesion":"'.$fila[0].'","noSesion":"'.$fila[1].'","fechaSesion":"'.$fila[2].'","unidadTematica":"'.$fila[3].'","noSesionUnidadTematica":"'.$fila[4].'","temario":"'.$temario.'","idUnidadTematica":"'.$fila[5].'"}';
			if($cadSesiones=="")
				$cadSesiones=$o;
			else
				$cadSesiones.=",".$o;
			$numReg++;
			
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$cadSesiones.']}';
	}
	
	function obtenerTemarioSesionesProyecto()
	{
		global $con;
		$tamPalabra=5;
		$idSesion=$_POST["idSesion"];
		$idUnidadTematica=$_POST["idUnidadTematica"];
		if($idUnidadTematica=="")
			$idUnidadTematica=-1;
		
		
		$cadUnidades="";
		$consulta="SELECT id__402_gridUnidadesTematicas,unidadTematica FROM _402_gridUnidadesTematicas WHERE id__402_gridUnidadesTematicas=".$idUnidadTematica." order by orden";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$clave=str_pad($fila[0],$tamPalabra,"0",STR_PAD_LEFT);
			$arrHijos=obtenerTemarioTemaProyecto($clave,$idSesion);
			$comp="";
			if($arrHijos!="[]")
				$comp=',"leaf":false,"children":'.$arrHijos;
			else
				$comp=',"leaf":true';
			$obj='{"icon":"../images/book.png","id":"'.$clave.'","expanded":true,"text":"<b>Unidad Temática:</b> '.cv($fila[1]).'","tipo":"1"'.$comp.'}';
			if($cadUnidades=="")
				$cadUnidades=$obj;
			else
				$cadUnidades.=",".$obj;
		}
		
		echo "[".$cadUnidades."]";
	}
	
	function obtenerTemarioTemaProyecto($codigoPadre,$idSesion)
	{
		global $con;
		$cadUnidades="";
		$consulta="SELECT codigoUnidad,prefijo,tema,descripcion,orden FROM  3002_temarioProyecto WHERE codigoPadre='".$codigoPadre."' ORDER BY orden";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$arrHijos=obtenerTemarioTemaProyecto($fila[0],$idSesion);
			$comp="";
			if($arrHijos!="[]")
				$comp=',"leaf":false,"children":'.$arrHijos;
			else
				$comp=',"leaf":true';
			$lblTexto="";
			if($fila[1]!="")
				$lblTexto=$fila[1].".- ";
			
			$lblTexto.=$fila[2];
			$checked='false';
			$consulta="SELECT COUNT(*) FROM 3004_sesionesVSTemas WHERE idSesion=".$idSesion." AND tema='".$fila[0]."'";
			$nTema=$con->obtenerValor($consulta);
			if($nTema!=0)
				$checked='true';
			$obj='{"checked":'.$checked.',"icon":"../images/book_open.png","id":"'.$fila[0].'","expanded":true,"tema":"'.cv($fila[2]).'","text":"'.cv($lblTexto).'","tipo":"2"'.$comp.',"prefijo":"'.cv($fila[1]).'","descripcion":"'.cv($fila[3]).'","orden":"'.$fila[4].'"}';
			if($cadUnidades=="")
				$cadUnidades=$obj;
			else
				$cadUnidades.=",".$obj;
		}
		
		return "[".$cadUnidades."]";
	}
	
	function guardarTemasSesionProyecto()
	{
		global $con;
		$x=0;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$query[$x]="begin";
		$x++;
		$query[$x]="UPDATE 3003_sesionesProyecto SET tituloSesion='".$obj->tema."',idUnidadTematica=".$obj->idUnidadTematica.",fechaSesion='".$obj->fechaSesion."' WHERE idSesion=".$obj->idSesion;
		$x++;
		$query[$x]="DELETE FROM 3004_sesionesVSTemas WHERE idSesion=".$obj->idSesion;
		$x++;
		$arrTemas=explode(",",$obj->temas);
		if(sizeof($arrTemas)>0)
		{
			foreach($arrTemas as $t)
			{
				$query[$x]="INSERT INTO 3004_sesionesVSTemas(idSesion,tema) VALUES(".$obj->idSesion.",'".$t."')";
				$x++;
			}
		}
		$query[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($query))
		{
			$x=0;
			$query=array();
			$query[$x]="begin";
			$x++;
			$numTmp=1;
			$consulta="select * from 3003_sesionesProyecto where idUnidadTematica=".$obj->idUnidadTematica." and idFormulario=".$obj->idFormulario." and idReferencia=".$obj->idReferencia. " order by noSesion";
			
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$query[$x]="UPDATE 3003_sesionesProyecto SET noSesionUnidadTematica=".$numTmp." WHERE idSesion=".$fila[0];
				$x++;
				$numTmp++;
			}
			$query[$x]="commit";
			$x++;
			eB($query);
		}
		
	}
	
	function modificarNoSesiones()
	{
		global $con;
		$x=0;
		$query[$x]="begin";
		$x++;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$noInicial=$_POST["noInicial"];
		$consulta="SELECT idSesion FROM 3003_sesionesProyecto WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." ORDER BY idReferencia";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$query[$x]="UPDATE 3003_sesionesProyecto SET noSesion=".$noInicial." WHERE idSesion=".$fila[0];
			
			$x++;
			$noInicial++;
		}
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function clonarProyecto()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="INSERT INTO _401_tablaDinamica(idReferencia,fechaCreacion,responsable,idEstado,codigoUnidad,codigoInstitucion,codigo,cmbCicloEscolar,cmbPeriodos,cmbProyectoBase,fechaInicio,fechaFinalizacion,situacion,descripcion,cveProyecto)
					SELECT idReferencia,'".date("Y-m-d H:i:s")."' as fechaCreacion,'".$_SESSION["idUsr"]."' as responsable,'1' as idEstado,codigoUnidad,codigoInstitucion,'@folio' as codigo,cmbCicloEscolar,
					cmbPeriodos,cmbProyectoBase,fechaInicio,fechaFinalizacion,1 as situacion,descripcion,concat('(Clon )',if(cveProyecto is null,'',cveProyecto)) as cveProyecto
					FROM _401_tablaDinamica WHERE id__401_tablaDinamica=".$idProyecto;
		$x++;
		$query[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		$query[$x]="INSERT INTO _401_gridDiasNOHabiles(idReferencia,etiqueta,fechaInicio,fechaFin)
					SELECT @idRegistro,etiqueta,fechaInicio,fechaFin FROM _401_gridDiasNOHabiles WHERE idReferencia=".$idProyecto;
		$x++;
		$query[$x]="INSERT INTO _401_GridSesionesClase(idReferencia,dia,horaInicio,horaFin)
					SELECT @idRegistro,dia,horaInicio,horaFin FROM _401_GridSesionesClase WHERE idReferencia=".$idProyecto;
		$x++;
		$query[$x]="INSERT INTO 3003_sesionesProyecto(idFormulario,idReferencia,noSesion,fechaSesion,idUnidadTematica,noSesionUnidadTematica)
					SELECT idFormulario,@idRegistro,noSesion,fechaSesion,idUnidadTematica,noSesionUnidadTematica FROM 3003_sesionesProyecto 
					WHERE idFormulario=401 AND idReferencia=".$idProyecto." order by noSesion";
		$x++;
		$query[$x]="INSERT INTO 3004_sesionesVSTemas(idSesion,tema)
					SELECT (SELECT idSesion FROM 3003_sesionesProyecto WHERE idFormulario=401 AND idReferencia=@idRegistro AND noSesion=p.noSesion) AS idSesion,s.tema FROM 3004_sesionesVSTemas s,3003_sesionesProyecto p 
					WHERE p.idSesion=s.idSesion AND p.idFormulario=401 AND p.idReferencia=".$idProyecto;
		$x++;
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
		{
			
			$consulta="select id__401_tablaDinamica from _401_tablaDinamica where codigo='@folio'";
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				asignarFolioRegistro(401,$fila[0]);
			}
			echo "1|";
		}
		
		
		
	}
	
	function obtenerProyectosInscritos()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$actor=$_POST["actor"]; //1 Alumno; 2 facilitador;
		$consulta="";
		switch($actor)
		{
			case 1:
				$consulta="SELECT DISTINCT idProyecto FROM 3005_usuariosProyecto WHERE idUsuario=".$idUsuario;
			break;
			case 2:
				$consulta="SELECT DISTINCT idProyecto FROM 3005_usuariosProyecto WHERE idFacilitador=".$idUsuario;
			break;
		}
		
		$listProyectos=$con->obtenerListaValores($consulta);
		if($listProyectos=="")
			$listProyectos=-1;
		
		$arrCiclo=array();	
		$consulta="SELECT id__401_tablaDinamica,nombreCiclo,p.nombrePeriodo,pr.tituloProyecto,t.descripcion FROM _401_tablaDinamica t,4526_ciclosEscolares c,_400_gridPeriodos p,_402_tablaDinamica pr WHERE 
					id__401_tablaDinamica IN (".$listProyectos.") AND c.idCiclo=t.cmbCicloEscolar AND p.id__400_gridPeriodos=t.cmbPeriodos AND 
					pr.id__402_tablaDinamica=t.cmbProyectoBase ORDER BY nombreCiclo,id__401_tablaDinamica";

		$resCursos=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resCursos))
		{
			if(!isset($arrCiclo[$fila[1]]))
				$arrCiclo[$fila[1]]=array();
			array_push($arrCiclo[$fila[1]],$fila);
		}
		$cadNodos="";
		$numCiclo=1;

		foreach($arrCiclo as $ciclo=>$resto)
		{
			$arrCursos="";
			foreach($resto as $curso)
			{
				$consulta="SELECT noSesion,CONCAT('Sesión: ',noSesion,'.- ',IF(tituloSesion IS NULL,'',tituloSesion),'(',fechaSesion,')') FROM `3003_sesionesProyecto` 
						WHERE idFormulario=401 AND idReferencia=".$curso[0]." ORDER BY noSesion";
				$arrSesion=$con->obtenerFilasArreglo($consulta);
				$o='{"arrSesion":'.$arrSesion.',"icon":"../images/bullet_green.png","id":"'.$curso[0].'","text":"<span style=\'color:#777 !important;display:inline;width:100px;overflow:visible;font-size:10px\'>'.cv($curso[3]).'</span>","leaf":true,tipo:2}';
				if($arrCursos=="")
					$arrCursos=$o;
				else
					$arrCursos.=",".$o;
			}
			$oCurso='{"icon":"../images/s.gif","id":"c'.$numCiclo.'","text":"<span style=\'color:#000 !important;font-size:10px\'><b>'.$ciclo.'</b></span>","leaf":false,"children":['.$arrCursos.'],tipo:1}';
			if($cadNodos=="")
				$cadNodos=$oCurso;
			else
				$cadNodos.=",".$oCurso;
			$numCiclo++;
		}
		echo "[".$cadNodos."]";
	}
	
	function obtenerTareasSesionProyecto()
	{
		global $con;
		$idSesion=$_POST["idSesion"];
		$idUsuario=$_POST["idUsuario"];
		$actor=$_POST["actor"];
		$consulta="SELECT idTareas as idTarea,titulo as tituloTarea,CONCAT(fechaLimiteEntrega,' ',horaLimiteEntrega) as fechaLimiteEntrega FROM 3009_tareasProyecto WHERE idSesion=".$idSesion." order by titulo";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
	}
	
	function removerTareaSesionProyecto()
	{
		global $con;
		$idTarea=$_POST["idTarea"];
		$consulta="DELETE FROM 3009_tareasProyecto WHERE idTareas=".$idTarea;
		eC($consulta);
	}
	
	function registrarRecursoProyecto()
	{
		global $con;
		$x=0;
		$query[$x]="begin";
		$x++;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);

		$idDocumentoRecurso=-1;
		if($obj->idRecurso==-1)
		{
			if($obj->idArchivo!="")
				$idRecurso=registrarDocumentoServidor($obj->idArchivo,$obj->nombreArchivo);
			else
				$idRecurso="NULL";
			$query[$x]="INSERT INTO 3008_recursosSesionesProyecto(idSesion,tipoRecurso,idDocumentoRecurso,tituloRecurso,descripcion,url,fechaUltimaModificacion)
						VALUES(".$obj->idSesion.",".$obj->tipoRecurso.",".$idRecurso.",'".cv($obj->nombreRecurso)."','".cv($obj->descripcion)."','".cv($obj->url)."','".date("Y-m-d H:i:s")."')";
			
			$x++;
		}
		else
		{
			$consulta="SELECT idDocumentoRecurso FROM 3008_recursosSesionesProyecto WHERE idRecursosSesion=".$obj->idRecurso;
			$idDocumentoRecurso=$con->obtenerValor($consulta);
			if($obj->idArchivo!="")
			{
				$idRecurso=registrarDocumentoServidor($obj->idArchivo,$obj->nombreArchivo);
				
				
			}
			else
			{
				$idRecurso=$idDocumentoRecurso;
				$idDocumentoRecurso=-1;
				if($idRecurso=="")
					$idRecurso="NULL";
			}
			$query[$x]="update 3008_recursosSesionesProyecto set fechaUltimaModificacion='".date("Y-m-d H:i:s")."',tipoRecurso=".$obj->tipoRecurso.
			",idDocumentoRecurso=".$idRecurso.",tituloRecurso='".cv($obj->nombreRecurso)."',descripcion='".cv($obj->descripcion)."',url='".cv($obj->url)."'
						where idRecursosSesion=".$obj->idRecurso;

			$x++;	
		}
		
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
		{
			if($idDocumentoRecurso!=-1)
				removerDocumentoServidor($idDocumentoRecurso);	
			echo "1|";
		}
		
	}
	
	function obtenerRecursosProyectoSesion()
	{
		global $con;
		$idSesion=$_POST["idSesion"];
		$tipoRecurso=$_POST["tipoRecurso"];
		$consulta="(SELECT idRecursosSesion AS idRecurso,tituloRecurso AS titulo,descripcion,a.tamano,s.fechaUltimaModificacion as fechaSubida,s.idDocumentoRecurso as idDocumento,url,tipoRecurso
					FROM 3008_recursosSesionesProyecto s,908_archivos a WHERE idSesion=".$idSesion." AND s.idDocumentoRecurso is not null and a.idArchivo=s.idDocumentoRecurso and tipoRecurso in(".$tipoRecurso."))
					union
					(SELECT idRecursosSesion AS idRecurso,tituloRecurso AS titulo,descripcion,'' as tamano,s.fechaUltimaModificacion as fechaSubida,'' as idDocumento,url,tipoRecurso
					FROM 3008_recursosSesionesProyecto s WHERE idSesion=".$idSesion." AND s.idDocumentoRecurso is  null  and tipoRecurso in(".$tipoRecurso.")) 
					order by titulo";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
	}
	
	function removerRecursoSesionProyecto()
	{
		global $con;
		$idRecurso=$_POST["idRecurso"];
		$consulta="SELECT idDocumentoRecurso FROM 3008_recursosSesionesProyecto WHERE idRecursosSesion=".$idRecurso;
		$idDocumentoRecurso=$con->obtenerValor($consulta);
		$consulta="DELETE FROM 3008_recursosSesionesProyecto WHERE idRecursosSesion=".$idRecurso;
		if($con->ejecutarConsulta($consulta))
		{
			removerDocumentoServidor($idDocumentoRecurso);	
			echo "1|";
		}
	}
	
	function verificarEmailAsistenciaProyecto()
	{
		global $con;
		
		$idProyecto=$_POST["idProyecto"];
		$email=$_POST["email"];
		$idAsistenciaGrupal=$_POST["idAsistenciaGrupal"];
		$noAsistentes=$_POST["noAsistentes"];		
		$fechaActual=date("Y-m-d");
		$hora=date("H:i:s");
		
		
		
		$registrarAsistencia=false;
		$dia=date("N",strtotime($fechaActual));		
		$horaInicio="";
		$horaFin="";
		$nombre="";
		$consulta="select idUsuario from 805_mails where Mail='".$email."'";
		$idUsuario=$con->obtenerValor($consulta);
		$resultado=1;
		$nombreGrupo="";
		$arrUsuarios="";
		if($idUsuario=="")
		{
			$resultado=2;
		}
		else
		{
			$consulta="select nombre from 800_usuarios where idUsuario=".$idUsuario;
			$nombre=$con->obtenerValor($consulta);
			$consulta="select count(*) from  3005_usuariosProyecto where idProyecto=".$idProyecto." and idUsuario=".$idUsuario;
			
			$nReg=$con->obtenerValor($consulta);
			if($nReg==0)
				$resultado=3;
			else
			{
				$consulta="select * from  3003_sesionesProyecto where idReferencia=".$idProyecto." and fechaSesion='".$fechaActual."'";
				$fSesion=$con->obtenerPrimeraFila($consulta);
				if($fSesion)
				{
					$consulta="SELECT idAsistenciaGrupal FROM `3006_usuariosAsistencia` WHERE idUsuario=".$idUsuario." AND idSesion=".$fSesion[0];
					
					$idAsistencia=$con->obtenerValor($consulta);
					if($idAsistencia!="")
						$idAsistenciaGrupal=$idAsistencia;
					$consulta="select horaInicio,horaFin from _401_GridSesionesClase where idReferencia=".$idProyecto." and dia=".$dia;
	
					$fHorario=$con->obtenerPrimeraFila($consulta);
					if($fHorario)
					{
						$consulta="select minutosAntesHoraInicio,minutosDespuesHoraFin from _412_tablaDinamica where idReferencia=".$idProyecto;
	
						$fTolerancias=$con->obtenerPrimeraFila($consulta);
						$hInicio=strtotime("- ".$fTolerancias[0]."minutes", strtotime($fHorario[0]));
						$hFin=strtotime("+ ".$fTolerancias[1]."minutes", strtotime($fHorario[1]));	
						$horaInicio=date("H:i",$hInicio);
						$horaFin=date("H:i",$hFin);
						$hActual=strtotime($hora);	
						if(!(($hActual>=$hInicio)&&($hActual<=$hFin)))
						{
							$resultado=5;
						}
						else
						{
							if($idAsistencia=="")
								$registrarAsistencia=true;
						}
					}
					else
					{
						$resultado=4;	
					}	
				}
				else
					$resultado=4;
			}			
			
		}	
		if($resultado==1)
		{
			
			if($registrarAsistencia)
			{
				$x=0;
				$query[$x]="begin";
				$x++;
				if($idAsistenciaGrupal=="")
				{
					$query[$x]="INSERT INTO `3007_gruposAsistencia`(idSesion,fechaRegistro,cveGrupoAsistencia)
								VALUES(".$fSesion[0].",'".date("Y-m-d H:i:s")."','".$nombre."')";
					$x++;
					$query[$x]="set @idAsistencia:=(select last_insert_id())";
					$x++;

				}
				else
				{
					$query[$x]="set @idAsistencia:=".$idAsistenciaGrupal;
					$x++;
				}
				$query[$x]="INSERT INTO `3006_usuariosAsistencia`(idUsuario,idSesion,fechaRegistro,idAsistenciaGrupal,noAsistentes)
							VALUES(".$idUsuario.",".$fSesion[0].",'".date("Y-m-d H:i:s")."',@idAsistencia,".$noAsistentes.")";
				$x++;
				$query[$x]="commit";
				$x++;
				
				$con->ejecutarBloque($query);	
				$consulta="select @idAsistencia";
				$idAsistenciaGrupal=$con->obtenerValor($consulta);
			}
			
			$consulta="SELECT u.idUsuario,u.Nombre AS nombre,m.Mail AS email,
					(SELECT CONCAT('[',claveCCT,' ] ',nombreEscuela)  FROM `3010_datosComplementariosUsuariosProyectos` c,`_395_tablaDinamica` p WHERE idUsuarioProyecto=u.idUsuario 
					AND p.id__395_tablaDinamica=c.plantel) as plantel,noAsistentes 
					FROM `3006_usuariosAsistencia` a,800_usuarios u,`805_mails` m 
						WHERE idAsistenciaGrupal=".$idAsistenciaGrupal." AND u.idUsuario=a.idUsuario AND m.idUsuario=u.idUsuario ORDER BY u.Nombre";
			$arrUsuarios=($con->obtenerFilasArreglo($consulta));		
			$consulta="select cveGrupoAsistencia from 3007_gruposAsistencia where idGrupoAsistencia=".$idAsistenciaGrupal;
			$nombreGrupo=$con->obtenerValor($consulta);
		}
		echo '1|{"idAsistenciaGrupal":"'.$idAsistenciaGrupal.'","resultado":"'.$resultado.'","idUsuario":"'.$idUsuario.'","nombre":"'.$nombre.
				'","email":"'.$email.'","horaInicio":"'.$horaInicio.'","horaFin":"'.$horaFin.'","arrUsuarios":'.$arrUsuarios.',"nombreGrupo":"'.cv($nombreGrupo).'"}';		
		
	}
	
	function obtenerPlanteles()
	{
		global $con;
		$tipoBusqueda=$_POST["tipoBusqueda"];
		$clave=$_POST["clave"];
		$idProyecto=$_POST["idProyecto"];
		$consulta="SELECT distinct e.estado FROM _415_tablaDinamica t, _415_gridEstados e WHERE e.idReferencia=t.id__415_tablaDinamica AND t.idReferencia in(".$idProyecto.")";
		$listEstado=$con->obtenerListaValores($consulta,"'");
		
		$comp="";
		/*if($listEstado!="")
		{
			$comp=" and estado in (".$listEstado.")";
		}*/
		$campo="";
		switch($tipoBusqueda)
		{
			case 1:
				$campo="estado";
			break;
			case 2:
				$campo="municipio";
			break;
			case 3:
				$campo="localidad";
			break;
			case 4:
				$campo="claveCCT";
			break;
		}
	
		$listServicioEducativo="";
		$arrProyecto=explode(",",$idProyecto);

		foreach($arrProyecto as $iProyecto)
		{
			$consulta="SELECT id__416_tablaDinamica,tipoEducativo,nivelEducativo FROM _416_tablaDinamica WHERE idReferencia=".$iProyecto;
	
			$res=$con->obtenerFilas($consulta);
	
			while($fila=mysql_fetch_row($res))
			{
				if(($fila[2]!="")&&($fila[2]!=-1))
				{
					$consulta="SELECT idOpcion FROM _416_servicioEducativo WHERE idPadre=".$fila[0];
	
					$listServicio=$con->obtenerListaValores($consulta);
					if($listServicio=="")
					{
						$consulta="SELECT id__409_tablaDinamica FROM _409_tablaDinamica WHERE nivelEducativo=".$fila[2];
						$listServicio=$con->obtenerListaValores($consulta);
						if($listServicio=="")
							$listServicio=-1;
					}
					
				}
				else
				{
					$consulta="SELECT id__409_tablaDinamica FROM _409_tablaDinamica WHERE tipoEducativo=".$fila[1];
					$listServicio=$con->obtenerListaValores($consulta);
						if($listServicio=="")
							$listServicio=-1;
				}
				if($listServicioEducativo=="")
					$listServicioEducativo=$listServicio;
				else
					$listServicioEducativo.=",".$listServicio;
					
			}
		}
		
		
		$consulta="SELECT id__395_tablaDinamica,CONCAT('[',claveCCT,'] ',nombreEscuela),calle FROM `_395_tablaDinamica` e,_411_tablaDinamica t
					WHERE ".$campo."='".$clave."' ".$comp." and t.idReferencia=e.id__395_tablaDinamica and servicioEducativo in (".$listServicioEducativo.") ORDER BY nombreEscuela";	

		echo "1|".$con->obtenerFilasArreglo($consulta);
	}
	
	function obtenerTurnosPlantel()
	{
		global $con;
		$idPlatel=$_POST["plantel"];
		$consulta="SELECT id__407_tablaDinamica,turno FROM `_395_turnos` t, `_407_tablaDinamica` ct 
					WHERE t.`idPadre`=".$idPlatel." AND ct.id__407_tablaDinamica=idOpcion ORDER BY turno";
		echo "1|".$con->obtenerFilasArreglo($consulta);	
			
	}
	
	
	function registrarUsuarioProyecto($objParam=null)
	{
		global $con;
		global $mostrarXML;
		global $urlSitio;
		
		if($objParam!=null)
			$cadObjJson=$objParam;
		else
			$cadObjJson=$_POST["datosAutor"];
		
		$objJson=json_decode($cadObjJson);
		$apPaterno=$objJson->apPaterno;
		$apMaterno=$objJson->apMaterno;
		$nombre=$objJson->nombres;
		$prefijo="";
		if(isset($objJson->prefijo))
			$prefijo=$objJson->prefijo;
		$nombreC=trim($nombre).' '.trim($apPaterno).' '.trim($apMaterno);
		$mail=$objJson->email;
		$codInstitucion="";
		$codDepto="";
		$idIdioma="1";
		$password=generarPassword();
		$sexo=0;
		if(isset($objJson->sexo))
			$sexo=$objJson->sexo;
		if($sexo=="")
			$sexo="NULL";
		$fechaNacimiento="NULL";
		
		if(isset($objJson->fechaNacimiento)&&($objJson->fechaNacimiento!=''))
			$fechaNacimiento="'".$objJson->fechaNacimiento."'";
		$noGrupos=1;
		if(isset($objJson->noGrupos))
			$noGrupos=$objJson->noGrupos;
		$mailUsr=$mail;
		$status="5";
		$telefonos="";
		$idProceso=$objJson->idProceso;
		$query="SELECT * FROM 9018_configuracionProcesoRegistro WHERE idProceso=".$idProceso;
		$filaConf=$con->obtenerPrimeraFila($query);
		$solAfiliacion=$filaConf[2];
		$solAceptacion=$filaConf[3];
		$query="insert into 800_usuarios(Login,Status,FechaCambio,Password,Nombre,idIdioma,cuentaActiva,cambiarDatosUsr) values('".cv(trim($mail))."',".$status.",'".date('Y-m-d')."','".cv($password)."','".cv($nombreC)."',".$idIdioma.",0,0)";
		if(!$con->ejecutarConsulta($query))
		{
			echo "|";
			return ;
		}
		$x=0;	
		
		$idUsuario=$con->obtenerUltimoID();
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="insert into 805_mails(Mail,Tipo,Notificacion,idUsuario) values('".cv(trim($mail))."',0,1,".$idUsuario.")";
		$x++;
		$consulta[$x]="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$idUsuario.",-1000,0,'-1000_0')";
		$x++;
		$query="SELECT rol FROM 9019_rolesRegistro WHERE idProceso=".$idProceso;
		$resRoles=$con->obtenerFilas($query);
		while($filaRol=mysql_fetch_row($resRoles))
		{
			$arrDatos=explode("_",$filaRol[0]);
			$consulta[$x]="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$idUsuario.",".$arrDatos[0].",".$arrDatos[1].",'".$filaRol[0]."')";
			$x++;
		}
		$consulta[$x]="insert into 802_identifica(Nom,Paterno,Materno,Nombre,Status,idUsuario,Prefijo,Genero,fechaNacimiento) 
					  values('".cv($nombre)."','".cv($apPaterno)."','".cv($apMaterno)."','".cv($nombreC)."',".$status.",".$idUsuario.",'".$prefijo."',".$sexo.",".$fechaNacimiento.")";
		$x++;
		$consulta[$x]="insert into 801_adscripcion(Institucion,Status,idUsuario,codigoUnidad) values('".cv($codInstitucion)."',".$status.",".$idUsuario.",'".$codDepto."')";
		$x++;
		$consulta[$x]="insert into 803_direcciones(idUsuario,Tipo) values(".$idUsuario.",0)";
		$x++;
		$consulta[$x]="insert into 803_direcciones(idUsuario,Tipo) values(".$idUsuario.",1)";
		$x++;
		$consulta[$x]="insert into 806_fotos(idUsuario) values(".$idUsuario.")";
		$x++;
		$consulta[$x]="INSERT INTO 3015_usuariosInscripcionProyecto(idUsuario,fechaInscripcion,montoInscripcion,tipoInscripcion,noGrupos)
					VALUES(".$idUsuario.",'".date("Y-m-d H:i:s")."',0,".$objJson->tipoInscripcion.",".$noGrupos.")";
		$x++;
		$consulta[$x]="set @idInscripcion:=(select last_insert_id())";
		$x++;
		$arrProyecto=explode(",",$objJson->idProyecto);
		foreach($arrProyecto as $idProyecto)
		{
			$inscribirProyecto=true;
			if($objJson->tipoInscripcion==2)
			{
				$query="SELECT COUNT(*)FROM _415_tablaDinamica a,_415_turnosProyecto t WHERE t.idPadre=a.id__415_tablaDinamica AND a.idReferencia=".$idProyecto." AND t.idOpcion=".$objJson->idTurno;

				$nReg=$con->obtenerValor($query);
				if($nReg==0)
					$inscribirProyecto=false;
			}
			if($inscribirProyecto)
			{
				$consulta[$x]="INSERT INTO `3005_usuariosProyecto`(idUsuario,idProyecto,idInscripcion)
								VALUE(".$idUsuario.",".$idProyecto.",@idInscripcion)";
				
				$x++;
			}
		}
		/*$consulta[$x]="set @idUsuarioProyecto:=(select last_insert_id())";
		$x++;*/
		$consulta[$x]="INSERT INTO `3010_datosComplementariosUsuariosProyectos`(idUsuarioProyecto,plantel,turno)
						VALUES(".$idUsuario.",".$objJson->idPlantel.",".$objJson->idTurno.")";
		$x++;
		
		if($objJson->telCasa!="")
		{
			$consulta[$x]="	insert into 804_telefonos(codArea,Lada,Numero,Extension,Tipo,Tipo2,idUsuario) 
								values('','','".$objJson->telCasa."','',0,0,".$idUsuario.")";
			$x++;
		}
		
		if($objJson->telMovil!="")
		{
			$consulta[$x]="	insert into 804_telefonos(codArea,Lada,Numero,Extension,Tipo,Tipo2,idUsuario) 
								values('','','".$objJson->telMovil."','',0,1,".$idUsuario.")";
			$x++;
		}
		
		$consulta[$x]="INSERT INTO 3014_datosDirectorPlantelUsuarioProyecto(apPaterno,apMaterno,nombre,telefono,email,idUsuarioProyecto)
						VALUES('".$objJson->datosContactoDirector->apPaterno."','".$objJson->datosContactoDirector->apMaterno."','".$objJson->datosContactoDirector->nombre.
						"','".$objJson->datosContactoDirector->telefono."','".$objJson->datosContactoDirector->email."',".$idUsuario.")";
		$x++;
			
							
		
		$consulta[$x]="commit";
		$x++;
		
		
		if($con->ejecutarBloque($consulta))		
		{
			$query="Select u.idUsuario,u.login,u.Nombre,a.Institucion,a.codigoUnidad,u.status,u.cambiarDatosUsr from 800_usuarios u,801_adscripcion a where a.idUsuario=u.idUsuario and u.idUsuario=".$idUsuario;
			$fila=$con->obtenerPrimeraFila($query);
			$query="select codigoRol from 807_usuariosVSRoles where idUsuario=".$idUsuario;
			$resRoles=$con->obtenerFilas($query);
			$listaGrupo="";
			while($fRoles=mysql_fetch_row($resRoles))
			{
				$arrRol=explode("_",$fRoles[0]);
				$rol="'".$fRoles[0]."'";
				if($arrRol[1]!="0")
					$rol.=",'".$arrRol[0]."_-1'";
				
				if($listaGrupo=="")
					$listaGrupo=$rol;
				else
					$listaGrupo.=",".$rol;
			}
			if($listaGrupo=="")
				$listaGrupo='-1';
			$consulta="select mailContacto from _415_tablaDinamica where idReferencia in (".$objJson->idProyecto.") and mailContacto<>'' limit 0,1";
			$mailAdministrador=$con->obtenerValor($consulta);
			
			$link="<a href='".$urlSitio."/registroUsuario/activaCuentaCurso.php?cta=".base64_encode("cuenta:".$idUsuario)."'>".$urlSitio."/registroUsuario/activaCuentaCurso.php?cta=".base64_encode("cuenta:".$idUsuario)."</a>";

			$arrParametros='[
								["$user","'.$mailUsr.'"],["$passwd","'.$password.'"],["$actLink","'.$link.'"],
								["$apPaterno","'.$apPaterno.'"],["$apMaterno","'.$apMaterno.'"],
								["$nombre","'.$nombre.'"],["$prefijo","'.$prefijo.'"]
							]';
			$query="SELECT idGrupoMensaje,'".$mailAdministrador."' as remitente FROM 9020_mensajesAccionProceso WHERE idProceso=".$idProceso." AND numEtapa=1";

			$fMensaje=$con->obtenerPrimeraFila($query);			
			$idCircular=$fMensaje[0];				
			if($idCircular!="")
			{
				$objEnvio='{"destinatarios":"'.$mailUsr.'","arrParametros":'.$arrParametros.',"idCircular":"'.$idCircular.'"}';
				if(enviarMailProceso($objEnvio,$fMensaje[1]))
					echo "1|";
				else
					echo "|";
			}
			else
				echo "1|";
		}
		else
			echo "|";
	}
	
	
	function obtenerDocumentosTareaUsuarioProyecto()
	{
		global $con;
		$idTarea=$_POST["idTarea"];
		
		$consulta="SELECT idDocumentoTarea AS idTarea, a.nomArchivoOriginal AS documento,a.tamano AS tamano, d.comentarios,d.idDocumento  FROM 
				`3012_documentosTareas` d,`908_archivos` a WHERE idTarea=".$idTarea." AND a.idArchivo=d.`idDocumento`";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	
	}
	
	function enviarTareaProyecto()
	{
		global $con;
		$idTarea=$_POST["idTarea"];
		$comentariosAdicionales=$_POST["comentarios"];
		$consulta="UPDATE `3011_tareasUsuarioProyecto` SET comentarios='".cv($comentariosAdicionales)."',situacion=1,fechaEnvio='".date("Y-m-d H:i:s")."' WHERE idTareaUsuario=".$idTarea;
		ec($consulta);
	}
	
	function removerDocumentoTareaProyecto()
	{
		global $con;
		$idTarea=$_POST["idTarea"];
		$consulta="SELECT idDocumento FROM `3012_documentosTareas` WHERE idDocumentoTarea=".$idTarea;
		$idDocumentoRecurso=$con->obtenerValor($consulta);
		$consulta="delete from `3012_documentosTareas`  WHERE idDocumentoTarea=".$idTarea;
		if($con->ejecutarConsulta($consulta));
		{
			removerDocumentoServidor($idDocumentoRecurso);	
			echo "1|";
		}
	}
	
	function guardarDocumentoTareaProyecto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$idRecurso=registrarDocumentoServidor($obj->idArchivo,$obj->nombreArchivo);
		$consulta="INSERT INTO `3012_documentosTareas`(idDocumento,comentarios,idTarea) VALUES(".$idRecurso.",'".cv($obj->comentarios)."',".$obj->idTarea.")";
		eC($consulta);
		
	}
	
	function obtenerTareasSesionProyectoAlumno()
	{
		global $con;
		$idSesion=$_POST["idSesion"];
		$idUsuario=$_POST["idUsuario"];
		
		$resultadoEvaluacion="";
		$arrRegistros="";
		$consulta="SELECT idTareas as idTarea,titulo as tituloTarea,CONCAT(fechaLimiteEntrega,' ',horaLimiteEntrega) as fechaLimiteEntrega 
					FROM 3009_tareasProyecto WHERE idSesion=".$idSesion." order by titulo";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$situacion="";
			$consulta="SELECT situacion,resultadoEvaluacion,comentariosEvaluacion,fechaEvaluacion FROM `3011_tareasUsuarioProyecto` WHERE idTarea=".$fila[0]." AND idUsuario=".$idUsuario;
			$fTarea=$con->obtenerPrimeraFila($consulta);
			
			switch($fTarea[0])
			{
				case 0:
					$situacion="Pendiente de en&iacute;o";
				break;
				case 1:
					$situacion="En espera de evaluaci&oacute;n";
				break;
				case 2:
					$situacion="Evaluado";
					$consulta="SELECT etiqueta FROM `4033_elementosEscala` WHERE idElementoEscala=".$fTarea[2];
					$resultadoEvaluacion=$con->obtenerValor($consulta);
				break;
				default:
					$situacion="Pendiente de en&iacute;o";
					
				break;
			}
			
			
			
			$o='{"idTarea":"'.$fila[0].'","tituloTarea":"'.cv($fila[1]).'","fechaLimiteEntrega":"'.$fila[2].'","situacion":"'.$situacion.
				'","resultadoEvaluacion":"'.$resultadoEvaluacion.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$arrRegistros.']}';
		
	}
	
	function obtenerTareasSesionProyectoFacilitador()
	{
		global $con;
		$arrUsuarios="";
		$idUsuario=$_POST["idUsuario"];
		$idTarea=$_POST["idTarea"];
		$consulta="SELECT s.idReferencia FROM `3009_tareasProyecto` t,`3003_sesionesProyecto` s WHERE idTareas=".$idTarea." AND s.idSesion=t.idSesion";
		$idProyecto=$con->obtenerValor($consulta);
		$consulta="SELECT u.idUsuario,CONCAT(u.Paterno,' ',u.Materno,' ',u.Nom) AS nombre FROM `802_identifica` u,`3005_usuariosProyecto` p WHERE p.idUsuario=u.idUsuario AND p.idFacilitador=".$idUsuario."
					ORDER BY u.Paterno,u.Materno,u.Nom";

		$res=$con->obtenerFilas($consulta);
		$numReg=0;
		while($fila=mysql_fetch_row($res))
		{
			$archivosAdjuntos="<table >";
			$consulta="SELECT idTareaUsuario,fechaEnvio,comentarios,situacion,resultadoEvaluacion,comentariosEvaluacion,fechaEvaluacion 
					FROM `3011_tareasUsuarioProyecto` WHERE idTarea=".$idTarea." AND idUsuario=".$fila[0];

			$fTarea=$con->obtenerPrimeraFila($consulta);
			if($fTarea[3]=="")
				$fTarea[3]=0;
			if($fTarea)
			{
				$consulta="SELECT idDocumento,a.nomArchivoOriginal,d.comentarios FROM `3012_documentosTareas` d,`908_archivos` a WHERE a.idArchivo=d.idDocumento
						AND idTarea=".$fTarea[0];
				
				$resTarea=$con->obtenerFilas($consulta);
				while($fDocTarea=mysql_fetch_row($resTarea))
				{
					$archivosAdjuntos.='<tr height=21><td width=\'300\'><a href=javascript:descargarRecurso(\''.bE($fDocTarea[0]).'\')><img src=\'../images/download.png\'></a> '.cv($fDocTarea[1]).'</td></tr>';
										
				}
			}
			$archivosAdjuntos.="<table >";
			$consulta="SELECT p.claveCCT,p.NombreEscuela FROM `3010_datosComplementariosUsuariosProyectos` d,`_395_tablaDinamica` p WHERE p.id__395_tablaDinamica=d.plantel AND d.idUsuarioProyecto=".$fila[0];
			$fPlatel=$con->obtenerPrimeraFila($consulta);
			$plantel='<span title=\''.cv($fPlatel[1]).'\' alt=\''.cv($fPlatel[1]).'\'>'.$fPlatel[0].'</span>';
			$o='{"idTareaUsuario":"'.$fTarea[0].'","idUsuario":"'.$fila[0].'","nombre":"'.$fila[1].'","plantel":"'.$plantel.'","fechaEnvio":"'.$fTarea[1].'","situacion":"'.$fTarea[3].
				'","archivosAdjuntos":"'.$archivosAdjuntos.'","comentariosAdicionales":"'.cv($fTarea[2]).'","resultadoEvaluacion":"'.$fTarea[4].'","comentariosEvaluacion":"'.cv($fTarea[5]).'"}'	;
			if($arrUsuarios=="")
				$arrUsuarios=$o;
			else
				$arrUsuarios.=",".$o;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrUsuarios.']}';
	}
	
	function evaluarTareaSesion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="UPDATE `3011_tareasUsuarioProyecto` SET situacion=2,resultadoEvaluacion=".$obj->resultado.",comentariosEvaluacion='".cv($obj->comentarios)."',fechaEvaluacion='".date("Y-m-d H:i:s").
					"' WHERE idTareaUsuario=".$obj->idTarea;
		eC($consulta);
		
	}
	
	function obtenerPlantelCCT()
	{
		global $con;
		$tipoBusqueda=4;
		$clave=$_POST["clave"];
		$idProyecto=$_POST["idProyecto"];
		/*$consulta="SELECT e.estado FROM _415_tablaDinamica t, _415_gridEstados e WHERE e.idReferencia=t.id__415_tablaDinamica AND t.idReferencia=".$idProyecto;

		$listEstado=$con->obtenerListaValores($consulta,"'");*/
		
		
		$campo="";
		switch($tipoBusqueda)
		{
			case 1:
				$campo="estado";
			break;
			case 2:
				$campo="municipio";
			break;
			case 3:
				$campo="localidad";
			break;
			case 4:
				$campo="claveCCT";
			break;
		}
	
		$listServicioEducativo="";
		$consulta="SELECT id__416_tablaDinamica,tipoEducativo,nivelEducativo FROM _416_tablaDinamica WHERE idReferencia in (".$idProyecto.")";
		$res=$con->obtenerFilas($consulta);

		while($fila=mysql_fetch_row($res))
		{
			if(($fila[2]!="")&&($fila[2]!=-1))
			{
				$consulta="SELECT idOpcion FROM _416_servicioEducativo WHERE idPadre=".$fila[0];

				$listServicio=$con->obtenerListaValores($consulta);
				if($listServicio=="")
				{
					$consulta="SELECT id__409_tablaDinamica FROM _409_tablaDinamica WHERE nivelEducativo=".$fila[2];
					$listServicio=$con->obtenerListaValores($consulta);
					if($listServicio=="")
						$listServicio=-1;
				}
				
			}
			else
			{
				$consulta="SELECT id__409_tablaDinamica FROM _409_tablaDinamica WHERE tipoEducativo=".$fila[1];
				$listServicio=$con->obtenerListaValores($consulta);
					if($listServicio=="")
						$listServicio=-1;
			}
			if($listServicioEducativo=="")
				$listServicioEducativo=$listServicio;
			else
				$listServicioEducativo.=",".$listServicio;
				
		}

		
		$consulta="SELECT id__395_tablaDinamica,CONCAT('[',claveCCT,'] ',nombreEscuela),calle,estado FROM `_395_tablaDinamica` e
					WHERE ".$campo."='".$clave."' ORDER BY nombreEscuela";	
		$fEscuela=$con->obtenerPrimeraFila($consulta);
		if($con->filasAfectadas==0)
		{
			echo "2|[]";
		}
		else
		{
			
			$arrServiciosEducativos=explode("'",$listServicioEducativo);
			/*$arrEstados=explode(",",$listEstado);
			if(!existeValor($arrEstados,"'".$fEscuela[3]."'"))
			{
				$consulta="SELECT estado FROM 820_estadosV2 WHERE cveEstado IN(".$listEstado.") ORDER BY estado";
				$listEstados=$con->obtenerListaValores($consulta,"<br>");
				echo "3|<b>".$listEstados."</b>";
				return;
			}*/
			$consulta="SELECT count(*) FROM _411_tablaDinamica WHERE idReferencia=".$fEscuela[0]." AND servicioEducativo IN(".$listServicioEducativo.")";
			$nReg=$con->obtenerValor($consulta);
			if($nReg==0)
			{
				$consulta="SELECT servicioEducativo FROM _409_tablaDinamica WHERE id__409_tablaDinamica in(".$listServicioEducativo.") ORDER BY servicioEducativo";
				$listRegistros=$con->obtenerListaValores($consulta,"<br>");
				echo "4|<b>".$listServicioEducativo."</b>";
				return;
			}
			
		}
		echo "1|[['".$fEscuela[0]."','".$fEscuela[1]."','".$fEscuela[2]."']]";
	}
	
	function obtenerLocalidadesPlanteles()
	{
		global $con;
		$codigo=$_POST["codigo"];
		$tipoInscripcion=$_POST["tipoInscripcion"];
		$idProyecto=$_POST["idProyecto"];
		
		$listServicioEducativo="";
		
		$arrProyecto=explode(",",$idProyecto);

		foreach($arrProyecto as $iProyecto)
		{
			$consulta="SELECT id__416_tablaDinamica,tipoEducativo,nivelEducativo FROM _416_tablaDinamica WHERE idReferencia=".$iProyecto;
	
			$res=$con->obtenerFilas($consulta);
	
			while($fila=mysql_fetch_row($res))
			{
				if(($fila[2]!="")&&($fila[2]!=-1))
				{
					$consulta="SELECT idOpcion FROM _416_servicioEducativo WHERE idPadre=".$fila[0];
	
					$listServicio=$con->obtenerListaValores($consulta);
					if($listServicio=="")
					{
						$consulta="SELECT id__409_tablaDinamica FROM _409_tablaDinamica WHERE nivelEducativo=".$fila[2];
						$listServicio=$con->obtenerListaValores($consulta);
						if($listServicio=="")
							$listServicio=-1;
					}
					
				}
				else
				{
					$consulta="SELECT id__409_tablaDinamica FROM _409_tablaDinamica WHERE tipoEducativo=".$fila[1];
					$listServicio=$con->obtenerListaValores($consulta);
						if($listServicio=="")
							$listServicio=-1;
				}
				if($listServicioEducativo=="")
					$listServicioEducativo=$listServicio;
				else
					$listServicioEducativo.=",".$listServicio;
					
			}
		}
		
		$consulta="select* from (select cveLocalidad,localidad,
					(SELECT COUNT(*) FROM _395_tablaDinamica e,_411_tablaDinamica t WHERE   localidad=l.cveLocalidad and t.idReferencia=e.id__395_tablaDinamica and servicioEducativo in (".$listServicioEducativo.") ) as nPlanteles 
					from 822_localidadesV2 l where cveMunicipio='".$codigo."') as loc where nPlanteles>0  order by localidad";

		$arrElemento=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrElemento);
			
	}
	
	function registrarPlantelInscripcionProyecto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		if($obj->etapa==3)
		{
			if($obj->cct!="")
			{
				$consulta="SELECT * FROM _395_tablaDinamica WHERE claveCCT='".$obj->cct."'";
				$fRegEscuela=$con->obtenerPrimeraFila($consulta);
				if($fRegEscuela)
				{
					echo "2|<b>[".$fRegEscuela[10]."] ".cv($fRegEscuela[11]."</b><br><b>Direcci&oacute;n:</b> ".generarDireccionPlantel($fRegEscuela[0])).
					"|[['".$fRegEscuela[0]."','[".$fRegEscuela[10]."] ".cv($fRegEscuela[11])."','".cv(generarDireccionPlantel($fRegEscuela[0]))."']]";
					return;
				}
			}
		}
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="INSERT INTO _395_tablaDinamica(fechaCreacion,responsable,idEstado,claveCCT,nombreEscuela,calle,numero,colonia,cp,estado,municipio,localidad,tipoEspacio,tipoFinanciamiento2)
				VALUES('".date("Y-m-d H:i:s")."',0,".$obj->etapa.",'".cv($obj->cct)."','".cv($obj->nombrePlantel)."','".cv($obj->calle)."','".cv($obj->no).
				"','".cv($obj->colonia)."','".cv($obj->cp)."','".cv($obj->estado)."','".cv($obj->municipio)."','".cv($obj->localidad)."',1,1)";
		$x++;
		$query[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		$consulta="SELECT id__407_tablaDinamica,turno FROM _407_tablaDinamica WHERE id__407_tablaDinamica<>8 ORDER BY turno";
		$res=$con->obtenerFilas($consulta);
		while($fTurno=mysql_fetch_row($res))
		{
			$query[$x]="INSERT INTO _395_turnos(idPadre,idOpcion)
						VALUES(@idRegistro,".$fTurno[0].")";
			$x++;
		}
		$listServicioEducativo="";
		$arrProyecto=explode(",",$obj->idProyecto);

		foreach($arrProyecto as $iProyecto)
		{
			$consulta="SELECT id__416_tablaDinamica,tipoEducativo,nivelEducativo FROM _416_tablaDinamica WHERE idReferencia=".$iProyecto;
	
			$res=$con->obtenerFilas($consulta);
	
			while($fila=mysql_fetch_row($res))
			{
				
				$consulta="SELECT id__409_tablaDinamica FROM _409_tablaDinamica WHERE tipoEducativo=".$fila[1];
				$listServicio=$con->obtenerListaValores($consulta);
					if($listServicio=="")
						$listServicio=-1;
				
				if($listServicioEducativo=="")
					$listServicioEducativo=$listServicio;
				else
					$listServicioEducativo.=",".$listServicio;
					
			}
			
			
		}
		
		$query[$x]="INSERT INTO _411_tablaDinamica(idReferencia,TipoEducativo,nivelEducativo,servicioEducativo)
					SELECT @idRegistro,tipoEducativo,nivelEducativo,id__409_tablaDinamica FROM _409_tablaDinamica WHERE id__409_tablaDinamica IN (".$listServicioEducativo.")";
		$x++;
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
		{
			$consulta="SELECT id__395_tablaDinamica,CONCAT('[',claveCCT,'] ',nombreEscuela),calle,estado FROM `_395_tablaDinamica` e
						WHERE id__395_tablaDinamica=@idRegistro";
			$fEscuela=$con->obtenerPrimeraFila($consulta);		
			echo "1|[['".$fEscuela[0]."','".$fEscuela[1]."','".$fEscuela[2]."']]";
		}
	}

	function guardarComentarioUsuarioProyecto()
	{
		global  $con;
		global $mailSoporte;
		$mailAdministrador=$mailSoporte;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		$mail="";
		if(isset($obj->email))
			$mail=$obj->email;
		else
		{
			if(isset($_SESSION["idUsr"]))
			{
				$consulta="SELECT Mail FROM 805_mails WHERE idUsuario=".$_SESSION["idUsr"];
				$mail=$con->obtenerValor($consulta);
				
			}
		}
		
		$nombre="";
		if(isset($obj->nombre))
			$nombre=$obj->nombre;
		else
		{
			if(isset($_SESSION["nombreUsr"]))
				$nombre=$_SESSION["nombreUsr"];
		}
		$referencia="";
		if(isset($obj->referencia))
			$referencia=$obj->referencia;
		$consulta="select mailContacto from _415_tablaDinamica where idReferencia in (".$obj->referencia.") and mailContacto<>'' limit 0,1";
		$mailAdministrador=$con->obtenerValor($consulta);
		$consulta="INSERT INTO 001_comentariosUsuariosSistema(nombreUsuario,email,comentario,fechaComentario,telefono,referencia,emailRemitente) 
			VALUES('".cv($nombre)."','".cv($mail)."','".cv($obj->comentario)."','".date("Y-m-d H:i")."','".cv($obj->telefono)."','".$referencia."','".$mailAdministrador."')";
		
		if($con->ejecutarConsulta($consulta))
		{
			if(trim($obj->comentario)!="")
			{
				if(enviarMail($mailAdministrador,"Duda / comentario de usuario",$obj->comentario,$mail,$nombre))
				{
					echo "1|";
				}
			}
			else
			{
				echo "1|";
			}
		}
	}

	function obtenerComentariosDudasProyecto()
	{
		global $con;
		$situacion=$_POST["situacion"];
		$ciclo=$_POST["ciclo"];
		$consulta="SELECT idComentarioUsuario AS idComentario,fechaComentario,nombreUsuario AS responsableComentario,email AS emailResponsable,comentario,activo AS situacion,fechaRespuesta AS fechaAtencion,
				(SELECT nombre FROM 800_usuarios WHERE idUsuario=c.idResponsableRespuesta)responsableAtencion,respuesta AS respuestaAtencion,telefono,
				(SELECT distinct nombreProyecto from `_401_tablaDinamica` t WHERE  t.id__401_tablaDinamica in(c.referencia) order by nombreProyecto limit 0,1) as proyecto FROM 001_comentariosUsuariosSistema c 
				WHERE fechaComentario>='".$ciclo."-01-01' and fechaComentario<='".$ciclo."-12-31' and activo in (".$situacion.") ORDER BY fechaComentario";
		$arrReg=$con->obtenerFilasJSON($consulta);
		
		$arrReg=str_replace("#R","",$arrReg);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
		
	}

	function obtenerProyectosGalileo()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		$consulta="SELECT id__401_tablaDinamica, CONCAT('[',IF(t.`cveProyecto` IS NULL,'',t.`cveProyecto`),'] ',p.`tituloProyecto`) FROM `_401_tablaDinamica` t,
					`_402_tablaDinamica` p  WHERE cmbCicloEscolar=".$idCiclo." AND cmbPeriodos=".$idPeriodo." AND p.`id__402_tablaDinamica`=t.`cmbProyectoBase` 
					 ORDER BY t.`cveProyecto`,p.`tituloProyecto`";
		$arrProyectos=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrProyectos;
	}
	
	function obtenerInscritosProyecto()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$consulta="SELECT u.idUsuario,CONCAT(u.`Paterno`,' ',u.`Materno`,' ',u.`Nom`) AS nombre,i.fechaInscripcion,
					cuentaConfirmada AS confirmaCorreo,fechaConfirmacion,CONCAT(d.`apPaterno`,' ',d.`apMaterno`,' ',d.`nombre`) AS directorPlantel,
					d.`telefono` AS telefonoPlantel,d.`email` AS emailContacto,es.`claveCCT` AS cct,es.`nombreEscuela` AS plantel,
					(SELECT Mail FROM `805_mails` WHERE idUsuario=u.idUsuario) AS email,
					(SELECT GROUP_CONCAT(Numero) FROM `804_telefonos` WHERE idUsuario=u.idUsuario) AS telefono,
					(SELECT turno FROM `_407_tablaDinamica` WHERE id__407_tablaDinamica=e.`turno`) AS turno
					FROM `3015_usuariosInscripcionProyecto` i,`802_identifica` u,`3005_usuariosProyecto` p, `3014_datosDirectorPlantelUsuarioProyecto` d,
					`3010_datosComplementariosUsuariosProyectos` e,`_395_tablaDinamica` es
					WHERE u.idUsuario=i.`idUsuario` AND d.`idUsuarioProyecto`=i.`idUsuario` AND e.`idUsuarioProyecto`=i.`idUsuario`
					AND p.`idUsuario`=i.`idUsuario` AND p.`idProyecto`=".$idProyecto." AND es.`id__395_tablaDinamica`=e.`plantel`
					ORDER BY u.`Paterno`,u.`Materno`,u.`Nom`";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	}
?>