<?php session_start();
	include("conexionBD.php"); 
	//include("conexionBDGalileo.php"); 
	$parametros="";
	if(isset($_POST["funcion"]))
	{
		$funcion=$_POST["funcion"];
		if(isset($_POST["param"]))
		{
			$p=$_POST["param"];
			$parametros=json_decode($p,true);
			
		}
	}	
	
	switch($funcion)
	{
		case 1: 
			obtenerProgramasSede();
		break;
		case 2:
			cambiarStatusGrado();
		break;
		case  3:
			obtenerAlumnosInscritos();
		break;
		case 4:
			realizarAccionAlumno();
		break;
		case 5:
			obtenerProyectosEjecucion();
		break;
		case 6:
			obtenerComprobaciones();
		break;
		case 7:
			obtenerSituacionPresupuestal();
		break;
		case 8:
			obtenerAsistentesCurso();
		break;
		case 9:
			obtenerGruposSedeCCT();
		break;
		case 10:
			obtenerFechasSesion();
		break;
		case 11:
			obtenerAsistenteSesion();
		break;
		case 12:
			registrarAsistencia1();
		break;
		case 13:
			registrarAsistencia2();
		break;
		case 14:
			obtenerPlanteles();
		break;
		case 15:
			obtenerGrupos();
		break;
		case 16:
			obtenerProyectosEstadoEjecucion();
		break;
		case 17:
			obtenerSesionesSubSistema();
		break;
		case 18:
			obtenerPlantelesCentroCosto();
		break;
		case 19:
			obtenerPlantelesSubsistemaInscrito();
		break;
		case 20:
			obtenerSesionesSubSistemaGlobal();
		break;
		case 21:
			registrarAsistencia3();
		break;
		case 22:
			obtenerEvaluacionAudiencia();
		break;
		
	}
	
	function obtenerProgramasSede()
	{
		global $con;
		$plantel=$_POST["sede"];
		$consulta="SELECT idInstanciaPlanEstudio,CONCAT(nombrePlanEstudios,' (Turno: ',t.turno,', Modalidad: ',m.nombre,')') AS nombrePlanEstudios2
					FROM 4513_instanciaPlanEstudio i,4514_tipoModalidad m,4516_turnos t WHERE i.idTurno=t.idTurno AND 
					i.idModalidad=m.idModalidad and sede='".$plantel."'";
		
		$arr=$con->obtenerFilasArreglo($consulta);					
		echo "1|".$arr;

	}
	
	function cambiarStatusGrado()
	{
		global $con;
		$valor=$_POST["valor"];
		$idMapa=$_POST["idMapa"];
		$idGrado=$_POST["idGrado"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 4241_aperturaGrados where idNuevoMapa=".$idMapa." and idGrado=".$idGrado;
		$x++;
		$consulta[$x]="insert into 4241_aperturaGrados(idNuevoMapa,idGrado,situacion) values(".$idMapa.",".$idGrado.",".$valor.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerAlumnosInscritos()
	{
		global $con;
		$listAlumnos=($_POST["listAlumnos"]);
		$consulta="select idUsuario,concat(Paterno,' ',Materno,' ',Nom) as nombre,'' as accion,'' as programa from 802_identifica where idUsuario in (".$listAlumnos.") order by Paterno,Materno,Nom";	
		$arrUsuario=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrUsuario;
		
		
	}
	
	function realizarAccionAlumno()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$idAlumno=$_POST["idAlumno"];
		$idCiclo=$_POST["iCiclo"];
		$idInstancia=$_POST["idInstancia"];
		
		$comp=$_POST["complementario"];
		$x=0;
		$consulta[$x]="begin";	
		$x++;
		
		$query="SELECT idAlumnoTabla FROM 4529_alumnos WHERE ciclo=".$idCiclo." AND idInstanciaPlanEstudio=".$idInstancia;
		$idAlumnoTabla=$con->obtenerValor($query);
		if($idAlumnoTabla=="")
			$idAlumnoTabla="-1";
		switch($idAccion)
		{
			case "1":
				
				$consulta[$x]="delete from 4517_alumnosVsMateriaGrupo  WHERE idUsuario=".$idAlumno." AND  idGrupo IN (
						SELECT idGrupos FROM 4520_grupos WHERE idInstanciaPlanEstudio=".$idInstancia." AND idCiclo=".$idCiclo.")";	
				$x++;	
				
				$query="SELECT * FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$comp;
				$filaMapa=$con->obtenerPrimeraFila($query);

				
				$query="select idGrado,e.codigoUnidad FROM 4501_Grado g,4505_estructuraCurricular e WHERE e.idPlanEstudio=".$filaMapa[2]." 
								and g.idGrado=e.idUnidad and tipoUnidad=3 and (codigoPadre='' or codigoPadre is null) order by g.ordenGrado limit 0,1";

				$fGrado=$con->obtenerPrimeraFila($query);
				$grado=$fGrado[0];
				$codigoGrado=$fGrado[1];
				if($grado=="")
					$grado="-1";
				if($filaMapa[12]==1)
				{
					$consulta[$x]="update 4529_alumnos set idInstanciaPlanEstudio=".$idInstancia.",idGrado=".$grado.",idGrupo=NULL where idAlumnoTabla=".$idAlumnoTabla;
					$x++;
				}
				else
				{
					$consulta[$x]="delete from 4529_alumnos WHERE idAlumnoTabla=".$idAlumnoTabla;
					$x++;
				}
				inscribirAlumnoMateriaObligatoria($codigoGrado,$filaMapa[2],$idAlumno,$consulta,$x,$idCiclo,$filaMapa[1],$idInstancia,$grado);
				
			break;
			case "2":
				$consulta[$x]="update 4517_alumnosVsMateriaGrupo set situacion=7 WHERE idUsuario=".$fila[7]." AND  idGrupo IN (
						SELECT idGrupos FROM 4520_grupos WHERE idInstanciaPlanEstudio=".$fila[2]." AND idCiclo=".$fila[1].")";	
				$x++;	
				$consulta[$x]="UPDATE  4529_alumnos SET estado=7 WHERE idAlumnoTabla=".$idAlumnoTabla;	
				$x++;
				
		
			break;	
		}
		$consulta[$x]="commit";	
		$x++;
		eB($consulta);
	}
	
	function obtenerProyectosEjecucion()
	{
		global $con;
		$categoria=$_POST["categoria"];
		$condWhere=" 1=1";
		if(isset($_POST["filter"]))
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		
		if($categoria!=7)	
		{
			$consulta="SELECT * FROM (
								SELECT id__293_tablaDinamica as idRegistro,codigo,tituloProyecto,(SELECT SUM(montoAutorizado) FROM 100_calculosGrid WHERE idFormulario=293 and idReferencia=p.id__293_tablaDinamica ) AS montoAutorizado,
								IF((SELECT SUM(txtImporte) FROM _351_tablaDinamica WHERE idReferencia=p.id__293_tablaDinamica AND idEstado=3)IS NULL,0,
								(SELECT SUM(txtImporte) FROM _351_tablaDinamica WHERE idReferencia=p.id__293_tablaDinamica AND idEstado=3)) AS montoComprobado,
								(if(categorias<>7,(SELECT COUNT(*) FROM _351_tablaDinamica WHERE idReferencia=p.id__293_tablaDinamica AND idEstado=2),
								'0'
								)) AS comprobacionPorValidar,categorias,
								unidad,CONCAT('[',numEtapa,'] ',nombreEtapa) AS estado,
								(SELECT COUNT(*) FROM _351_tablaDinamica WHERE idReferencia=p.id__293_tablaDinamica AND idEstado=4) as comprobacionRechazadas,
								IF((SELECT SUM(txtImporte) FROM _351_tablaDinamica WHERE idReferencia=p.id__293_tablaDinamica AND idEstado=4)IS NULL,0,
								(SELECT SUM(txtImporte) FROM _351_tablaDinamica WHERE idReferencia=p.id__293_tablaDinamica AND idEstado=4)) AS montoRechazado,
								(SELECT COUNT(*) FROM _351_tablaDinamica WHERE idReferencia=p.id__293_tablaDinamica AND idEstado=5) as comprobacionEnEsperaCambios,
								IF((SELECT SUM(txtImporte) FROM _351_tablaDinamica WHERE idReferencia=p.id__293_tablaDinamica AND idEstado=5)IS NULL,0,
								(SELECT SUM(txtImporte) FROM _351_tablaDinamica WHERE idReferencia=p.id__293_tablaDinamica AND idEstado=5)) AS montoEsperaCambios
								FROM _293_tablaDinamica p,817_organigrama o,4037_etapas e
								WHERE e.numEtapa=idEstado and e.idProceso=34 and o.codigoUnidad=p.codigoInstitucion and idEstado in (12,13,14,15)) AS t where categorias=".$categoria." and ".$condWhere." ORDER BY codigo";
		}
		else
		{
			$consulta="SELECT * FROM (
								SELECT id__293_tablaDinamica as idRegistro,codigo,tituloProyecto,(SELECT SUM(montoAutorizado) FROM 100_calculosGrid WHERE  idFormulario=293 and  idReferencia=p.id__293_tablaDinamica  ) AS montoAutorizado,
								(if((SELECT SUM(importe) FROM _361_tablaDinamica WHERE idReferencia=p.id__293_tablaDinamica)is null,0,(SELECT SUM(importe) FROM _361_tablaDinamica WHERE idReferencia=p.id__293_tablaDinamica))) AS montoComprobado,
								'0' AS comprobacionPorValidar,categorias,
								unidad,CONCAT('[',numEtapa,'] ',nombreEtapa) AS estado,
								'0' as comprobacionRechazadas,
								'0' AS montoRechazado,
								'0' as comprobacionEnEsperaCambios,
								'0' AS montoEsperaCambios
								FROM _293_tablaDinamica p,817_organigrama o,4037_etapas e
								WHERE e.numEtapa=idEstado and e.idProceso=34 and o.codigoUnidad=p.codigoInstitucion and idEstado in (12,13,14,15)) AS t where categorias=".$categoria." and ".$condWhere." ORDER BY codigo";
		}
		
		$arrProy=$con->obtenerFilasJson($consulta);							
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrProy).'}';
		
	}
	
	function obtenerComprobaciones()
	{
		global $con;
		$idEstado=$_POST["idEstado"];
		$idProyecto=$_POST["idProyecto"];
		$consulta="SELECT t.id__351_tablaDinamica as idRegistro,c.nombreConcepto AS rubro,con.calculo AS concepto,txtImporte AS monto,fechaCreacion AS fechaRegistro FROM _351_tablaDinamica t,100_conceptosGridPresupuesto c,100_calculosGrid con WHERE 
				c.idConceptoGrid=t.cmbRubro AND con.idGridVSCalculo=t.cmbConcepto AND t.idEstado=".$idEstado." AND t.idReferencia=".$idProyecto." ORDER BY t.fechaCreacion";		
		$arrProy=$con->obtenerFilasJson($consulta);							
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrProy).'}';	
	}
	
	function obtenerSituacionPresupuestal()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		
		
		$consulta="SELECT con.idGridVSCalculo,c.nombreConcepto AS rubro,con.calculo AS concepto,con.montoAutorizado,
					(IF((SELECT SUM(txtImporte) FROM _351_tablaDinamica WHERE idReferencia=".$idProyecto." AND idEstado=3 and cmbConcepto=con.idGridVSCalculo)IS NULL,0,
					(SELECT SUM(txtImporte) FROM _351_tablaDinamica WHERE idReferencia=".$idProyecto." AND idEstado=3 and cmbConcepto=con.idGridVSCalculo)))  as montoComprobado
					FROM 100_conceptosGridPresupuesto c,100_calculosGrid con WHERE 
					c.idConceptoGrid=con.idRubro and con.idFormulario=293 AND con.idReferencia=".$idProyecto." and eliminado=0 AND montoAutorizado>0 order by con.calculo";	
							
		$arrProy=$con->obtenerFilasJson($consulta);							
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrProy).'}';				
	}
	
	function obtenerAsistentesCurso()
	{
		global $conGalileo;
		global $con;
		$plantel=$_POST["plantel"];
		$idGrupo=$_POST["idGrupo"];
		$idCurso=$_POST["idCurso"];
		
		$fechaSesion=date("Y-m-d");
		if(isset($_POST["fechaSesion"]))
			$fechaSesion=$_POST["fechaSesion"];
		
		
		$arrAsistentes="";
		$ct=0;
		
		
		$consulta="SELECT codigoDepto FROM 817_organigrama WHERE codigoUnidad='".$plantel."'";
		$cct=$con->obtenerValor($consulta);
		
		$consulta="SELECT i.iduser,UPPER(u.firstname),UPPER(u.lastname) FROM inscritosxsede i,mdl_user u WHERE cct_sede='".$cct."' AND idgrupo IN (".$idGrupo.") AND u.id=i.iduser ORDER BY lastname,firstname";
		$res=$conGalileo->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$asistencia="false";
			$consulta="SELECT idUsuario FROM 0_paseListaAsistencia WHERE fechaAsistencia='".$fechaSesion."' AND idUsuario=".$fila[0]." AND idGrupo IN (".$idGrupo.") AND plantel='".$plantel."'";

			$filaUsr=$con->obtenerPrimeraFila($consulta);
			if($filaUsr)
				$asistencia="true";
			
			$sede="";
			if($sede=="")
				$sede="No especificado";
			$nombre=$fila[2];
			if($nombre<>$fila[1])
				$nombre.=" ".$fila[1];
			$obj='{"idUsuarioAsistente":"'.$fila[0].'","nombre":"'.cv($nombre).'","asistencia":'.$asistencia.',"plantel":"'.cv($sede).'"}';
			if($arrAsistentes=="")
				$arrAsistentes=$obj;
			else
				$arrAsistentes.=",".$obj;
			$ct++;
		}
		echo '{"numReg":"'.$ct.'","registros":['.$arrAsistentes.']}';	
	}
	
	function obtenerGruposSedeCCT()
	{
		global $con;
		global $conGalileo;
		$cveCCT=$_POST["cveCCT"];
		$idCurso=$_POST["idCurso"];
		
		$consulta="SELECT cveCurso FROM _246_tablaDinamica WHERE id__246_tablaDinamica=".$idCurso;
		$listCursos=$con->obtenerListaValores($consulta);
		if($listCursos=="")
			$listCursos=-1;
		$consulta="SELECT  DISTINCT g.id,g.name FROM inscritosxsede i,mdl_groups g WHERE cct_sede='".$cveCCT."' AND g.id=i.idGrupo and curso in(".$listCursos.") order by g.name";

		$resInscritos=$conGalileo->obtenerFilas($consulta);
		$arr="";
		$arrHorarios=array();
		while($fila=mysql_fetch_row($resInscritos))
		{
			$datos=explode("_",$fila[1]);
			if($datos[1]!=0)
				$nombreGrupo='Horario: '.substr($datos[1],0,2).":00 - ".substr($datos[1],2,2).":00 hrs.";
			else
				$nombreGrupo="Grupo único";
			if(!isset($arrHorarios[$nombreGrupo]))
				$arrHorarios[$nombreGrupo]=array();
			array_push($arrHorarios[$nombreGrupo],$fila[0]);
		}
		
		foreach($arrHorarios as $nGrupo=>$arrGrupos)
		{
			$listGrupos="";
			foreach($arrGrupos as $g)
			{
				if($listGrupos=="")
					$listGrupos=$g;
				else
					$listGrupos.=",".$g;
			}
			$obj="['".$listGrupos."','".$nGrupo."']";	
				if($arr=="")
					$arr=$obj;
				else
					$arr.=",".$obj;
		}
		if($arr=="")
		{
			echo "2|";
			return;
		}

		$consulta="select unidad,codigoUnidad from 817_organigrama where codigoDepto='".cv($cveCCT)."'";
		$filaP=$con->obtenerPrimeraFila($consulta);
		echo "1|[".$arr."]|".$filaP[0]."|".$filaP[1];	
		
	}
	
	function obtenerFechasSesion()
	{
		global $conGalileo;
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$plantel=$_POST["plantel"];
		$idCurso=$_POST["idCurso"];
		$fechaSesion=NULL;
		if(isset($_POST["fechaSesion"]))
			$fechaSesion=$_POST["fechaSesion"];
			
		$consulta="SELECT NAME FROM mdl_groups WHERE id IN (".$idGrupo.")";
		$valor=$conGalileo->obtenerValor($consulta);
		$arrDatos=explode("_",$valor);
		$hIniI=substr($arrDatos[1],0,2);
		$hIniI=strtotime(date("H:i",strtotime("-120 minutes",strtotime("1984-05-10 ".$hIniI.":00:00"))));
		
		$hFinI=substr($arrDatos[1],2,2);
		$hFinI=strtotime(date("H:i",strtotime("+120 minutes",strtotime("1984-05-10 ".$hFinI.":00:00"))));
		
		$horaActual=strtotime(date("H:i"));
		
		
		$fueraLimitesRegistro=false;
		if(($horaActual>=$hIniI)&&($horaActual<=$hFinI))
			$fueraLimitesRegistro=true;
		
		if((!$fueraLimitesRegistro)||($fechaSesion!=NULL))
		{
			$consulta="SELECT id__337_tablaDinamica  FROM _337_tablaDinamica t,_337_subsistemas s WHERE s.idReferencia=t.id__337_tablaDinamica AND s.subsistema='".substr($plantel,0,4)."' AND t.cursos=".$idCurso;
			$idPerfil=$con->obtenerValor($consulta);
			
			if($idPerfil=="")
				$idPerfil=-1;
			if($fechaSesion==NULL)			
				$consulta="SELECT noSesion FROM _337_gridFechas WHERE idReferencia=".$idPerfil." AND fechaSesion='".date("Y-m-d")."'"; 
			else
				$consulta="SELECT noSesion FROM _337_gridFechas WHERE idReferencia=".$idPerfil." AND fechaSesion='".$fechaSesion."'"; 
			
			$nSesion=$con->obtenerValor($consulta);
			
			if($nSesion=="")
			{
				echo "3|";
			}
			else
			{
				//$consulta="SELECT COUNT(*) FROM 0_AsistenciaGalileo WHERE fechaSesion='".date("Y-m-d")."' AND noSesion=".$nSesion." AND idGrupo='".$idGrupo."' AND plantel='".$plantel."'";
				//$registrado=$con->obtenerValor($consulta);
				$arrAsistentes="";
				
				$consulta="SELECT codigoDepto FROM 817_organigrama WHERE codigoUnidad='".$plantel."'";
				$cct=$con->obtenerValor($consulta);
				$consulta="SELECT i.iduser,UPPER(u.firstname),UPPER(u.lastname) FROM inscritosxsede i,mdl_user u WHERE cct_sede='".$cct."' AND idgrupo IN (".$idGrupo.") AND u.id=i.iduser ORDER BY lastname,firstname";

				$res=$conGalileo->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					$asistencia="false";
					$consulta="SELECT idUsuario FROM 0_paseListaAsistencia WHERE noSesion=".$nSesion." AND idUsuario=".$fila[0]." AND idGrupo IN (".$idGrupo.") AND plantel='".$plantel."'";
					$filaUsr=$con->obtenerPrimeraFila($consulta);
					if(!$filaUsr)
					{	
										
						$nombre=$fila[2];
						if($nombre<>$fila[1])
							$nombre.=" ".$fila[1];
						$obj="['".$fila[0]."','".cv($nombre)."']";
						if($arrAsistentes=="")
							$arrAsistentes=$obj;
						else
							$arrAsistentes.=",".$obj;
					}
					
				}
				
				
				$registrado=0;
				echo "1|".$nSesion."|".$registrado."|[".$arrAsistentes."]";
			}
		}
		else
		{
			echo "2|";
		}
		
		
	}
	
	function obtenerAsistenteSesion()
	{
		global $con;
		$fechaSesion=$_POST["fechaSesion"];
		$plantel=$_POST["plantel"];
		$idGrupo=$_POST["idGrupo"];
		
		
		
		$consulta="SELECT id__292_tablaDinamica FROM _292_tablaDinamica WHERE cmbCursos=".$idGrupo." AND cmbPLantel='".$plantel."'";
		$idCurso=$con->obtenerValor($consulta);
		if($idCurso=="")
			$idCurso=-1;
		$consulta="SELECT if(txtNoAsistentes is null,-1,txtNoAsistentes),txtHoraCierreAsistencia FROM _295_tablaDinamica WHERE idReferencia=".$idCurso." AND cmbFechasSesion='".$fechaSesion."'";
		$fila=$con->obtenerPrimeraFila($consulta);
		$txtNoAsistentes=$fila[0];
		$txtHoraCierreAsistencia=$fila[1];
		$asistenciaCerrada=0;
		if($con->filasAfectadas==0)
		{
			$txtNoAsistentes=-1;
			
		}
		else
		{
			if($txtHoraCierreAsistencia!="")
				$asistenciaCerrada=1;		
		}
		$cadObj='{"noAsistentes":"'.$txtNoAsistentes.'","asistenciaCerrada":"'.$asistenciaCerrada.'","idCurso":"'.$idCurso.'"}';
		
		echo "1|".$cadObj;
	}
	
	function registrarAsistencia1()
	{
		global $con;
		$fechaSesion=$_POST["fechaSesion"];
		$plantel=$_POST["plantel"];
		$idGrupo=$_POST["idGrupo"];
		$horaRegistro=$_POST["horaRegistro"];
		$noAsistentes=$_POST["noAsistentes"];
		
		
		$consulta="SELECT id__292_tablaDinamica FROM _292_tablaDinamica WHERE cmbCursos=".$idGrupo." AND cmbPLantel='".$plantel."'";
		$idCurso=$con->obtenerValor($consulta);
		if($idCurso=="")
			$idCurso=-1;
		$consulta="SELECT id__295_tablaDinamica FROM _295_tablaDinamica WHERE idReferencia=".$idCurso." AND cmbFechasSesion='".$fechaSesion."'";
		$idRegistro=$con->obtenerValor($consulta);
		if($con->filasAfectadas==0)
		{
			$consulta="INSERT INTO _295_tablaDinamica(idReferencia,fechaCreacion,responsable,idEstado,cmbFechasSesion,txtNoAsistentes,txtHoraRegistro) 
					values(".$idCurso.",'".date("Y-m-d")."',1,1,'".$fechaSesion."','".$noAsistentes."','".$horaRegistro."')";
		}
		else
		{
			$consulta="update _295_tablaDinamica set txtNoAsistentes=".$noAsistentes.",txtHoraRegistro='".$horaRegistro."' where id__295_tablaDinamica=".$idRegistro;
		}
		
		eC($consulta);

	}
	
	function registrarAsistencia2()
	{
		global $con;
		global $conGalileo;
		$noSesion=$_POST["noSesion"];
		$plantel=$_POST["plantel"];
		$idGrupo=$_POST["idGrupo"];
		$idCurso=$_POST["idCurso"];
		$horaRegistro=date("H:i");
		$arrAsistentes=array();
		$listaAsistencia=$_POST["listaAsistencia"];
		if($listaAsistencia!="")
			$arrAsistentes=explode(",",$listaAsistencia);
		$noAsistentes=sizeof($arrAsistentes);
		$x=0;
		$fechaSesion=date("Y-m-d");
		if(isset($_POST["fechaSesion"]))
			$fechaSesion=$_POST["fechaSesion"];
		$query[$x]="begin";
		$x++;
		$query[$x]="delete from 0_AsistenciaGalileo where fechaSesion='".$fechaSesion."' and noSesion=".$noSesion." and idGrupo='".$idGrupo."' and idCurso=".$idCurso." and plantel='".$plantel."'";
		$x++;
		$query[$x]="INSERT INTO 0_AsistenciaGalileo(fechaSesion,noSesion,idGrupo,plantel,horaRegistro,idCurso) 
					VALUES('".$fechaSesion."',".$noSesion.",'".$idGrupo."','".$plantel."','".$horaRegistro."',".$idCurso.")";
		$x++;
		if(!isset($_POST["noBorrar"]))
		{
			$query[$x]="delete from 0_paseListaAsistencia where fechaAsistencia='".$fechaSesion."' and noSesion=".$noSesion." and idGrupo='".$idGrupo."' and plantel='".$plantel."' and idCurso=".$idCurso;
			$x++;
		}
		if($noAsistentes>0)
		{
			foreach($arrAsistentes as $a)	
			{
				$query[$x]="INSERT INTO 0_paseListaAsistencia(fechaAsistencia,noSesion,idUsuario,idGrupo,plantel,idCurso) 
							VALUES('".$fechaSesion."',".$noSesion.",".$a.",'".$idGrupo."','".$plantel."',".$idCurso.")";
				$x++;
			}
		}
		$query[$x]="commit";
		$x++;
		eB($query);

	}
	
	function obtenerPlanteles()
	{
		global $con;
		$codigoUnidad=$_POST["codigoUnidad"];
		$consulta="SELECT distinct cmbPlantel,o.unidad FROM _292_tablaDinamica t, 817_organigrama o WHERE o.codigoUnidad=t.cmbPLantel and t.idEstado=1 AND o.codigoUnidad LIKE '".$codigoUnidad."%' AND o.status=1 order by o.unidad";
		$arr=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arr;
	}
	
	function obtenerGrupos()
	{
		global $con;
		global $conGalileo;
		$codigoUnidad=$_POST["codigoUnidad"];
		$idCurso=$_POST["idCurso"];
		$consulta="SELECT cveCurso FROM _246_tablaDinamica WHERE id__246_tablaDinamica=".$idCurso;
		$listCursos=$con->obtenerListaValores($consulta);
		if($listCursos=="")
			$listCursos=-1;
		$consulta="SELECT codigoDepto FROM 817_organigrama WHERE codigoUnidad='".$codigoUnidad."'";
		$cct=$con->obtenerValor($consulta);
		$consulta="SELECT  DISTINCT g.id,g.name FROM inscritosxsede i,mdl_groups g WHERE cct_sede='".$cct."' AND g.id=i.idGrupo and i.curso in(".$listCursos.") order by g.name";
		
		$resInscritos=$conGalileo->obtenerFilas($consulta);
		$arr="";
		$arrHorarios=array();
		while($fila=mysql_fetch_row($resInscritos))
		{
			$datos=explode("_",$fila[1]);
			if($datos[1]!=0)
			{
				$nombreGrupo='Horario: '.substr($datos[1],0,2).":00 - ".substr($datos[1],2,2).":00 hrs.";
			}
			else
				$nombreGrupo="Grupo único";
			if(!isset($arrHorarios[$nombreGrupo]))
				$arrHorarios[$nombreGrupo]=array();
			array_push($arrHorarios[$nombreGrupo],$fila[0]);
		}
		
		foreach($arrHorarios as $nGrupo=>$arrGrupos)
		{
			$listGrupos="";
			foreach($arrGrupos as $g)
			{
				if($listGrupos=="")
					$listGrupos=$g;
				else
					$listGrupos.=",".$g;
			}
			$obj="['".$listGrupos."','".$nGrupo."']";	
				if($arr=="")
					$arr=$obj;
				else
					$arr.=",".$obj;
		}
		echo "1|[".$arr."]";
	}
	
	function obtenerProyectosEstadoEjecucion()
	{
		global $con;
		$categoria=$_POST["categoria"];
		$idEstado=$_POST["idEstado"];
		$condWhere=" 1=1";
		if(isset($_POST["filter"]))
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		$consulta="SELECT * FROM (
							SELECT id__293_tablaDinamica as idRegistro,codigo,tituloProyecto,(SELECT SUM(montoAutorizado) FROM 100_calculosGrid WHERE idReferencia=p.id__293_tablaDinamica ) AS montoAutorizado,
							IF((SELECT SUM(txtImporte) FROM _351_tablaDinamica WHERE idReferencia=p.id__293_tablaDinamica AND idEstado=3)IS NULL,0,
							(SELECT SUM(txtImporte) FROM _351_tablaDinamica WHERE idReferencia=p.id__293_tablaDinamica AND idEstado=3)) AS montoComprobado,
							(SELECT COUNT(*) FROM _351_tablaDinamica WHERE idReferencia=p.id__293_tablaDinamica AND idEstado=2) AS comprobacionPorValidar,categorias,
							unidad,CONCAT('[',numEtapa,'] ',nombreEtapa) AS estado,
							(SELECT id__359_tablaDinamica FROM _359_tablaDinamica WHERE idReferencia=p.id__293_tablaDinamica ORDER BY id__359_tablaDinamica DESC LIMIT 0,1) as dictamen
							FROM _293_tablaDinamica p,817_organigrama o,4037_etapas e
							WHERE e.numEtapa=idEstado and e.idProceso=34 and o.codigoUnidad=p.codigoInstitucion and idEstado =".$idEstado.") AS t where categorias=".$categoria." and ".$condWhere." ORDER BY codigo";
		$arrProy=$con->obtenerFilasJson($consulta);							
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrProy).'}';
		
	}
	
	function obtenerSesionesSubSistema()
	{
		global $con;
		global $conGalileo;
		$cursoGalileo=$_POST["cursoGalileo"];
		$codigoUnidad=$_POST["codigoUnidad"];
		$consulta="SELECT cveCurso,Curso FROM _246_tablaDinamica WHERE id__246_tablaDinamica=".$cursoGalileo;
		$fCurso=$con->obtenerPrimeraFila($consulta);
		$listCursos=$fCurso[0];
		if($listCursos=="")
			$listCursos=-1;	
		$consulta="SELECT id__337_tablaDinamica FROM _337_tablaDinamica t,_337_subsistemas s WHERE cursos=".$cursoGalileo." AND 
					s.idReferencia=t.id__337_tablaDinamica AND s.subsistema='".$codigoUnidad."'";

		$idRefCurso=$con->obtenerValor($consulta);
		if($idRefCurso=="")
			$idRefCurso=-1;
		$consulta="SELECT COUNT(*) FROM _337_gridFechas WHERE idReferencia=".$idRefCurso;

		$nSesion=$con->obtenerValor($consulta);
		if($nSesion=="")
			$nSesion=0;
		$consulta="select distinct codigoDepto from 817_organigrama where status=1 and codigoUnidad like '".$codigoUnidad."%'";
		$listCct=$con->obtenerListaValores($consulta,"'");
		if($listCct=="")
			$listCct=-1;
		$consulta="SELECT DISTINCT idgrupo FROM inscritosxsede i WHERE cct_sede IN(".$listCct.") and  i.curso in (".$listCursos.")";	
		$listGrupos=$conGalileo->obtenerListaValores($consulta);
		if($listGrupos=="")
			$listGrupos="-1";
		$consulta="SELECT id__336_tablaDinamica,txtMateria FROM _336_tablaDinamica";
		$resCursos=$con->obtenerFilas($consulta);
		$arrMaterias=array();
		while($fila=mysql_fetch_row($resCursos))
		{
			$arrMaterias[$fila[0]]=$fila[1];
		}
		if($listGrupos=="")
			$listGrupos=-1;
		$consulta="SELECT id,name FROM mdl_groups WHERE id IN (".$listGrupos.")";
		$resGpo=$conGalileo->obtenerFilas($consulta);
		$arrGrupos=array();
		while($fGpo=mysql_fetch_row($resGpo))
		{
			$datosGrupo=explode("_",$fGpo[1]);
			if(!isset($arrGrupos[$datosGrupo[1]]))
				$arrGrupos[$datosGrupo[1]]=$fGpo[0];
			else
				$arrGrupos[$datosGrupo[1]].=",".$fGpo[0];
			
		}
		$arrCursos="";
		foreach($arrMaterias as $idMateria=>$materia)
		{
			foreach($arrGrupos as $horario=>$idGrupo)
			{
				$obj="['".$idMateria."_".$idGrupo."','".$materia." ".substr($horario,0,2).":00 hrs - ".substr($horario,2).":00 hrs']";
				if($arrCursos=="")
					$arrCursos=$obj;
				else
					$arrCursos.=",".$obj;
			}
		}
		
		$consulta="select codCentroCosto from 817_organigrama where codigoDepto in (".$listCct.")";	
		$lisCentrosCosto=$con->obtenerListaValores($consulta,"'");			
		if($lisCentrosCosto=="")
			$lisCentrosCosto="-1";
		$consulta="SELECT codigo,tituloCentroC FROM 506_centrosCosto WHERE codigo IN(".$lisCentrosCosto.") order by tituloCentroC";
		$arrEstados=$con->obtenerFilasArreglo($consulta);
		echo "1|".$nSesion."|[".$arrCursos."]|".$arrEstados;
		
	}
	
	function obtenerPlantelesCentroCosto()
	{
		global $con;
		$cc=$_POST["cc"];
		$codigoUnidad=$_POST["codigoUnidad"];
		$consulta="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE codCentroCosto in (".$cc.") AND unidadPadre LIKE '".$codigoUnidad."%' and status=1 order by unidad";
		$arrPlanteles=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrPlanteles;
		
	}
	
	function obtenerPlantelesSubsistemaInscrito()
	{
		global $con;
		global $conGalileo;
		$codigoUnidad=$_POST["codigoUnidad"];
		$idCurso=$_POST["idCurso"];
		$consulta="SELECT cveCurso FROM _246_tablaDinamica WHERE id__246_tablaDinamica=".$idCurso;
		$listCursos=$con->obtenerListaValores($consulta);
		if($listCursos=="")
			$listCursos=-1;
		$consulta="SELECT distinct codigoDepto FROM 817_organigrama o WHERE o.codigoUnidad LIKE '".$codigoUnidad."%' AND o.status=1";
		$listCCT=$con->obtenerListaValores($consulta,"'");
		if($listCCT=="")
			$listCCT="-1";
		$consulta="SELECT cct_sede FROM inscritosxsede WHERE cct_sede IN (".$listCCT.") and curso in (".$listCursos.")";
	
		$listCCTInscritos=$conGalileo->obtenerListaValores($consulta,"'");
		
		if($listCCTInscritos=="")
			$listCCTInscritos=-1;
		$consulta="SELECT distinct codigoUnidad,o.unidad FROM 817_organigrama o WHERE codigoDepto in (".$listCCTInscritos.")  order by o.unidad";

		$arr=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arr;
		
	}
	
	function obtenerSesionesSubSistemaGlobal()
	{
		global $con;
		global $conGalileo;
		$codigoUnidad=$_POST["codigoUnidad"];
		$idCurso=$_POST["idCurso"];
		$nSesion=12;
		
		$consulta="SELECT cveCurso FROM _246_tablaDinamica WHERE id__246_tablaDinamica=".$idCurso;
		$listCursos=$con->obtenerListaValores($consulta);
		if($listCursos=="")
			$listCursos=-1;
		
		$consulta="select distinct codigoDepto from 817_organigrama where status=1 and codigoUnidad like '".$codigoUnidad."%'";
		$listCct=$con->obtenerListaValores($consulta,"'");
		if($listCct=="")
			$listCct=-1;
		
		$consulta="SELECT DISTINCT idgrupo FROM inscritosxsede WHERE cct_sede IN(".$listCct.") and curso in (".$listCursos.")";	

		$listGrupos=$conGalileo->obtenerListaValores($consulta);
		/*$consulta="SELECT id__336_tablaDinamica,txtMateria FROM _336_tablaDinamica";
		$resCursos=$con->obtenerFilas($consulta);*/
		
		if($listGrupos=="")
			$listGrupos=-1;
		$consulta="SELECT id,name FROM mdl_groups WHERE id IN (".$listGrupos.")";

		$resGpo=$conGalileo->obtenerFilas($consulta);
		$arrGrupos=array();
		while($fGpo=mysql_fetch_row($resGpo))
		{
			$datosGrupo=explode("_",$fGpo[1]);
			if(!isset($arrGrupos[$datosGrupo[1]]))
				$arrGrupos[$datosGrupo[1]]=$fGpo[0];
			else
				$arrGrupos[$datosGrupo[1]].=",".$fGpo[0];
			
		}
		
		
		$arrCursos="";
		$cadHorario="";
		$cadGrupos="";
		$ultimaOpcion="";
		foreach($arrGrupos as $horario=>$idGrupo)
		{
			$nombreGrupo="";
			if($horario!=0)
			{
				$nombreGrupo='Horario: '.substr($horario,0,2).":00 - ".substr($horario,2,2).":00 hrs.";
			}
			else
				$nombreGrupo="Grupo único";
				
			$obj="['".$horario."_".$idGrupo."','".$nombreGrupo."']";
			if($arrCursos=="")
				$arrCursos=$obj;
			else
				$arrCursos.=",".$obj;
			
			if($cadHorario=="")
			{
				$cadHorario=$horario;
				$cadGrupos=$idGrupo;
			}
			else
			{
				$cadHorario.=",".$horario;
				$cadGrupos.=",".$idGrupo;
			}
			
		}
		if($arrCursos!="")
		{
			$obj="['".$cadHorario."_".$cadGrupos."','Todos los horarios']";
			$arrCursos.=",".$obj;
		}
		
		$consulta="select codCentroCosto from 817_organigrama where codigoDepto in (".$listCct.")";	
		$lisCentrosCosto=$con->obtenerListaValores($consulta,"'");			
		if($lisCentrosCosto=="")
			$lisCentrosCosto="-1";
		
		
			
		//$consulta="SELECT idReferencia FROM _337_subsistemas WHERE subsistema='".$codigoUnidad."'";	
		$consulta="SELECT id__337_tablaDinamica  FROM _337_tablaDinamica t,_337_subsistemas s WHERE s.idReferencia=t.id__337_tablaDinamica AND s.subsistema='".$codigoUnidad."' AND t.cursos=".$idCurso;
		$idReferencia=$con->obtenerValor($consulta);
		if($idReferencia=="")
			$idReferencia=-1;

		$consulta='SELECT fechaSesion,concat("Sesión: ",noSesion," - ",DATE_FORMAT(fechaSesion,"%d/%m/%Y")) FROM _337_gridFechas WHERE idReferencia='.$idReferencia.' ORDER BY fechaSesion';

		$arrFechas=$con->obtenerFilasArreglo($consulta);
		$nSesion=$con->filasAfectadas;
		$consulta="SELECT codigo,tituloCentroC FROM 506_centrosCosto WHERE codigo IN(".$lisCentrosCosto.") order by tituloCentroC";
		$arrEstados=$con->obtenerFilasArreglo($consulta);
		echo "1|".$nSesion."|[".$arrCursos."]|".$arrEstados."|".$arrFechas;
			
	}
	
	function registrarAsistencia3()
	{
		global $con;
		global $conGalileo;
		$noSesion=$_POST["noSesion"];
		$plantel=$_POST["plantel"];
		$idGrupo=$_POST["idGrupo"];
		$idCurso=$_POST["idCurso"];
		$horaRegistro=date("H:i");
		$arrAsistentes=array();
		$nombreUsuario=$_POST["nombreUsuario"];
		
		$noAsistentes=sizeof($arrAsistentes);
		$x=0;
		$fechaSesion=date("Y-m-d");
		if(isset($_POST["fechaSesion"]))
			$fechaSesion=$_POST["fechaSesion"];
		$query[$x]="begin";
		$x++;
		$query[$x]="delete from 0_AsistenciaGalileo where fechaSesion='".$fechaSesion."' and noSesion=".$noSesion." and idGrupo='".$idGrupo."' and idCurso=".$idCurso." and plantel='".$plantel."'";
		$x++;
		$query[$x]="INSERT INTO 0_AsistenciaGalileo(fechaSesion,noSesion,idGrupo,plantel,horaRegistro,idCurso) 
					VALUES('".$fechaSesion."',".$noSesion.",'".$idGrupo."','".$plantel."','".$horaRegistro."',".$idCurso.")";
		$x++;
		
		$query[$x]="INSERT INTO 0_paseListaAsistenciaAlumnoNoEncontrado(fechaAsistencia,noSesion,alumno,idGrupo,plantel,idCurso) 
							VALUES('".$fechaSesion."',".$noSesion.",'".cv($nombreUsuario)."','".$idGrupo."','".$plantel."',".$idCurso.")";
		$x++;
			
		$query[$x]="commit";
		$x++;
		eB($query);

	}
	
	function obtenerEvaluacionAudiencia()
	{
		global $con;
		
		
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		$sort=$_POST["sort"];
		$dir=$_POST["dir"];
		$formularioEvaluacion=$_POST["formularioEvaluacion"];
		$fechaFin=$_POST["fechaFin"];
		$fechaInicio=$_POST["fechaInicio"];
		$unidadGestion=$_POST["unidadGestion"];
		
		$consulta="SELECT nombreCorto,orden FROM _000_catalogoSeccionesCuestionariosEvaluacion 
			WHERE idCuestionario=".$formularioEvaluacion." ORDER BY orden";
		$res=$con->obtenerFilas($consulta);
		
		$arrCampos="";
		
		while($fila=mysql_fetch_row($res))
		{
			$token=',(
					 SELECT AVG(seccion'.($fila[1]-1).'P) FROM _'.$formularioEvaluacion.'_tablaDinamica fE,7001_eventoAudienciaJuez eJ,7000_eventosAudiencia e
					 WHERE e.fechaEvento>=\''.$fechaInicio.'\' AND e.fechaEvento<=\''.$fechaFin.'\' AND ej.idRegistroEvento=e.idRegistroEvento
					 AND ej.idJuez=j.usuarioJuez AND fE.idEvento=e.idRegistroEvento AND fE.idEstado=2
					 ) AS seccion_'.($fila[1]-1);
			
		
			$arrCampos.=$token;
		}
		
		$consulta="select * from (SELECT (SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=j.idReferencia) AS unidadGestion,
				clave as noJuez,
				usuarioJuez as idJuez,CONCAT('[',clave,'] ',(SELECT nombre FROM 800_usuarios u WHERE u.idUsuario=usuarioJuez)) AS nombreJuez,
				(
					 SELECT count(*) FROM _".$formularioEvaluacion."_tablaDinamica fE,7001_eventoAudienciaJuez eJ,7000_eventosAudiencia e
					 WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' AND ej.idRegistroEvento=e.idRegistroEvento
					 AND ej.idJuez=j.usuarioJuez AND fE.idEvento=e.idRegistroEvento AND fE.idEstado=2
					 ) AS totalEvaluaciones,
				(
					 SELECT avg(total) FROM _".$formularioEvaluacion."_tablaDinamica fE,7001_eventoAudienciaJuez eJ,7000_eventosAudiencia e
					 WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' AND ej.idRegistroEvento=e.idRegistroEvento
					 AND ej.idJuez=j.usuarioJuez AND fE.idEvento=e.idRegistroEvento AND fE.idEstado=2
					 ) AS total
				".$arrCampos."
				FROM _26_tablaDinamica j,_26_tipoJuez tj WHERE tj.idPadre=j.id__26_tablaDinamica and tj.idOpcion=1 and idReferencia
				IN(".$unidadGestion.") AND usuarioJuez<>-1 AND usuarioJuez IS NOT NULL) as tmp where 1=1 and ".$cadCondWhere." ORDER BY unidadGestion, ".$sort." ".$dir;
		
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'",registros:'.$arrRegistros.'}';
	}
?>