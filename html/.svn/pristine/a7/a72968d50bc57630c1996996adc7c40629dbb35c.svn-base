<?php session_start();
	include("conexionBD.php"); 
	;
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			obtenerProfesoresPlantel();
		break;
		case 2:
			obtenerPeriodosGruposPlantel();
		break;
		case 3:
			cambiarEstadoLiberacionContrato();
		break;
		case 4:
			obtenerProfesoresPlantelContratos();
		break;
		case 5:
			obtenerProfesoresPlantelContratosHistorial();
		break;
		case 6:
			obtenerMateriasRevalidacionSolicitud();
		break;
		case 7:
			guardarEvaluacionRevalidacion();
		break;
		case 8:
			buscarAlumnosPlantel();
		break;
		case 9:
			buscarAdeudosAlumnoCaja();
		break;
		case 10:
			obtenerDocumentosInscripcion();
		break;
		case 11:
			obtenerMateriasInstanciaPlanEquivalencia();
		break;
		case 12:
			obtenerMateriasRevalidacionFinalSolicitud();
		break;
		case 13:
			guardarEvaluacionFinalRevalidacion();
		break;
		case 14:
			obtenerEvaluacionGrupoAlumno();
		break;
		case 15:
			guardarRespuestaEvaluacionAlumnoGrupo();
		break;
		case 16:
			finalizarRegistroEvaluacion();
		break;
		case 17:
			guardarRespuestasEvaluacion();
		break;
		
	}
	
	function obtenerProfesoresPlantel()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		
		$cadCondWhere=" 1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		
		
		
		$consulta="SELECT a.idUsuario FROM 4520_grupos g,4519_asignacionProfesorGrupo a WHERE g.idCiclo=".$idCiclo." AND g.idPeriodo=".$idPeriodo." AND a.idGrupo=g.idGrupos";
		$listUsuarios=$con->obtenerListaValores($consulta);
		if($listUsuarios=="")
			$listUsuarios=-1;
		
		
		$consulta="SELECT idUsuario FROM 807_usuariosVSRoles WHERE idRol=5 and idUsuario in (".$listUsuarios.")";
		$listUsuarios=$con->obtenerListaValores($consulta);
		if($listUsuarios=="")
			$listUsuarios=-1;
		
		$consulta="SELECT idUsuario as idProfesor,Paterno,Materno,Nom,(SELECT count(*) FROM 3010_contratosLiberados WHERE idUsuario=i.idUsuario AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." and liberado=1) as liberarContrato 
					FROM 802_identifica i WHERE idUsuario IN(".$listUsuarios.") and ".$cadCondWhere;
		$consulta.=" ORDER BY Paterno,Materno,Nombre";
		
		$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$registros.'}';
	}
	
	function obtenerPeriodosGruposPlantel()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		
		$consulta="SELECT DISTINCT idPeriodo FROM 4520_grupos WHERE idCiclo=".$idCiclo;
		$lisPeriodos=$con->obtenerListaValores($consulta);
		if($lisPeriodos=="")
			$lisPeriodos=-1;
		
		$consulta="SELECT id__464_gridPeriodos,CONCAT(txtDescripcion,': ',nombrePeriodo) FROM _464_gridPeriodos g,_464_tablaDinamica t WHERE 
				g.idReferencia=t.id__464_tablaDinamica and  id__464_gridPeriodos in(".$lisPeriodos.") ORDER BY txtDescripcion,nombrePeriodo	";
				
		$arrPeriodos=$con->obtenerFilasArreglo($consulta);
		
		echo "1|".$arrPeriodos;
		
	}
	
	function cambiarEstadoLiberacionContrato()
	{
		global $con;
		$estado=$_POST["s"];
		$idProfesor=$_POST["iP"];
		$idCiclo=$_POST["c"];
		$idPeriodo=$_POST["p"];
		
		
		$consulta="SELECT idRegistro FROM 3010_contratosLiberados WHERE idUsuario=".$idProfesor." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
			$consulta="insert into 3010_contratosLiberados(idUsuario,idCiclo,idPeriodo,liberado) values(".$idProfesor.",".$idCiclo.",".$idPeriodo.",".$estado.")";
		else
			$consulta="update 3010_contratosLiberados set liberado=".$estado." where idRegistro=".$idRegistro;
			
		eC($consulta);
		
		
	}
	
	function obtenerProfesoresPlantelContratos()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		
		$cadCondWhere=" 1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		
		
//		$consulta="SELECT a.idUsuario FROM 
//					4520_grupos g,4519_asignacionProfesorGrupo a,4615_gradosSolicitudAutorizacionEstructura gA,4546_estructuraPeriodo eP 
//					WHERE a.idGrupo=g.idGrupos AND g.idCiclo=".$idCiclo." AND g.idPeriodo=".$idPeriodo." 
//					AND a.esperaContrato=1 AND a.fechaAsignacion<=a.fechaBaja
//					and g.idGradoCiclo=eP.idEstructuraPeriodo and gA.idGradoEstructura=eP.idEstructuraPeriodo and gA.dictamen=1";
					
		$consulta="SELECT a.idUsuario FROM 4520_grupos g,4519_asignacionProfesorGrupo a WHERE a.idGrupo=g.idGrupos AND g.idCiclo='".$idCiclo."' 
				AND g.idPeriodo='".$idPeriodo."' AND a.esperaContrato=1 AND a.fechaAsignacion<=a.fechaBaja";
		$listUsuarios=$con->obtenerListaValores($consulta);
		if($listUsuarios=="")
			$listUsuarios=-1;
		
		
		$consulta="SELECT  idUsuario FROM 3010_contratosLiberados where idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." AND liberado=1 and
					idUsuario in(".$listUsuarios.")";
					
		$listUsuarios=$con->obtenerListaValores($consulta);
		if($listUsuarios=="")
			$listUsuarios=-1;
		
		$consulta="SELECT idUsuario as idProfesor,Paterno,Materno,Nom
					FROM 802_identifica i WHERE idUsuario IN(".$listUsuarios.") and ".$cadCondWhere;

		$consulta.=" ORDER BY Paterno,Materno,Nombre";
		$registros="";
		$numReg=0;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$tblMaterias="<table><tr><td width='600'><b>Grupos involucrados</b></td></tr>";
			
			
//			$consulta="SELECT g.idGrupos,a.fechaAsignacion,a.fechaBaja FROM 4520_grupos g,4519_asignacionProfesorGrupo a,
//						4615_gradosSolicitudAutorizacionEstructura gA,4546_estructuraPeriodo eP  
//						WHERE a.idGrupo=g.idGrupos 
//						AND g.idCiclo=".$idCiclo." AND g.idPeriodo=".$idPeriodo." and a.idUsuario=".$fila[0]." 
//						AND a.esperaContrato=1 AND a.fechaAsignacion<=a.fechaBaja and g.idGradoCiclo=eP.idEstructuraPeriodo 
//						and gA.idGradoEstructura=eP.idEstructuraPeriodo and gA.dictamen=1";
			
			$consulta="SELECT g.idGrupos,a.fechaAsignacion,a.fechaBaja FROM 4520_grupos g,4519_asignacionProfesorGrupo a
						WHERE a.idGrupo=g.idGrupos AND g.idCiclo='".$idCiclo."' AND g.idPeriodo='".$idPeriodo."' AND a.idUsuario='".$fila[0]."' 
						AND a.esperaContrato=1 AND a.fechaAsignacion<=a.fechaBaja ";
			
			$resGpo=$con->obtenerFilas($consulta);
			while($fGpo=mysql_fetch_row($resGpo))
			{
				$tblMaterias.="<tr><td>-- ".cv(obtenerNombreGrupoCompleto($fGpo[0]))."<br>&nbsp;&nbsp;&nbsp;(<b>Del</b> ".date("d/m/Y",strtotime($fGpo[1]))." <b>al</b> ".date("d/m/Y",strtotime($fGpo[2])).")</td></tr>";
			}
			$tblMaterias.="</table>";
			
			
			$o='{"idProfesor":"'.$fila[0].'","Paterno":"'.cv($fila[1]).'","Materno":"'.cv($fila[2]).'","Nom":"'.cv($fila[3]).'","tblMaterias":"'.$tblMaterias.'"}';
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$numReg++;
		}
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';
	}
	
	function obtenerProfesoresPlantelContratosHistorial()
	{
		
		global $con;
		
		
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		
		$cadCondWhere=" 1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		
		$consulta="SELECT idUsuario as idProfesor,Paterno,Materno,Nom,n.txtNivelEstudio as nivel,id__273_tablaDinamica as idContrato
					FROM 802_identifica i,_273_tablaDinamica c,_401_tablaDinamica n WHERE c.cmbCatedratico=i.idUsuario and 
					c.idCiclo=".$idCiclo." and c.idPeriodo=".$idPeriodo." and  n.id__401_tablaDinamica=c.idNivel and ".
					$cadCondWhere;

		$consulta.=" ORDER BY Paterno,Materno,Nombre";
		
		
		$registros="";
		$numReg=0;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$tblMaterias="<table><tr><td width='600'><b>Grupos involucrados</b></td></tr>";
			
			
			$consulta="SELECT g.idGrupos,a.fechaAsignacion,a.fechaBaja FROM 4520_grupos g,4519_asignacionProfesorGrupo a,_273_gruposContrato gc 
						WHERE a.idGrupo=g.idGrupos and a.idAsignacionProfesorGrupo=gc.idAsignacion and gc.idContrato=".$fila[5];
			
			$resGpo=$con->obtenerFilas($consulta);
			while($fGpo=mysql_fetch_row($resGpo))
			{
				$tblMaterias.="<tr><td>-- ".cv(obtenerNombreGrupoCompleto($fGpo[0]))."<br>&nbsp;&nbsp;&nbsp;(<b>Del</b> ".date("d/m/Y",strtotime($fGpo[1]))." <b>al</b> ".date("d/m/Y",strtotime($fGpo[2])).")</td></tr>";
			}
			$tblMaterias.="</table>";
			
			
			$o='{"idProfesor":"'.$fila[0].'","Paterno":"'.cv($fila[1]).'","Materno":"'.cv($fila[2]).'","Nom":"'.cv($fila[3]).
				'","idContrato":"'.$fila[5].'","nivel":"'.$fila[4].'","tblMaterias":"'.$tblMaterias.'"}';
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$numReg++;
		}
		
		
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';
		
	}
	
	function obtenerMateriasRevalidacionSolicitud()
	{
		global $con;
		
		
		$esEvaluacionFinal=false;
		$arrMaterias="";
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="SELECT * FROM _1066_tablaDinamica WHERE id__1066_tablaDinamica=".$idRegistro;
		
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		$idEscuelaOrigen=$fRegistro[22];
		if($idEscuelaOrigen==2)//Externa
		{
			$tipoPlan=1;
			$idPlanEstudioOrigen=$fRegistro[24];
		}
		else
		{
			$tipoPlan=0;
			$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$fRegistro[28];
			$idPlanEstudioOrigen=$con->obtenerValor($consulta);
		}
	
		$consulta="SELECT id_4574_solicitudesRevalidacion FROM 4574_solicitudesRevalidacion WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$idSolicitud=$con->obtenerValor($consulta);

		$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$fRegistro[26];
		$idPlanEstudioDestino=$con->obtenerValor($consulta);
		
		$consulta="SELECT idEquivalenciaPlanEstudio FROM 4500_equivalenciasPlanEstudio WHERE  idPlanEstudioBase=".$idPlanEstudioDestino." AND 
					tipoPlanEstudioEquivalencia=".$tipoPlan." AND idPlanEstudioEquivalencia=".$idPlanEstudioOrigen;

		
		$idEquivalenciaPlanEstudio=$con->obtenerValor($consulta);
		if($idEquivalenciaPlanEstudio=="")
			$idEquivalenciaPlanEstudio=-1;


		
		

		$nRegistros=0;
		$arrMaterias="";
		$consulta="SELECT g.leyendaGrado,e.codigoUnidad,g.idGrado FROM  4505_estructuraCurricular e,4501_Grado g WHERE e.idPlanEstudio=".$idPlanEstudioDestino.
					" AND e.tipoUnidad=3 AND g.idGrado=e.idUnidad ORDER BY g.ordenGrado";
		$resGrado=$con->obtenerFilas($consulta);
		while($fGrado=mysql_fetch_row($resGrado))
		{
			$consulta="SELECT idMateria,upper(nombreMateria) FROM 4502_Materias m,4505_estructuraCurricular e WHERE e.idPlanEstudio=".$idPlanEstudioDestino." AND e.idPlanEstudio=m.idPlanEstudio AND 
						e.tipoUnidad=1 AND m.idMateria=e.idUnidad and codigoPadre LIKE '".$fGrado[1]."%'  ORDER BY nombreMateria";
			
			
			$rMaterias=$con->obtenerFilas($consulta);
			while($fMaterias=mysql_fetch_row($rMaterias))
			{
				
				$idMateriasPlanOrigen="";
				$materiasPlanOrigen="";
				$modificable=1;
				
				$arrMateriasOrigen="";				
				if($idEquivalenciaPlanEstudio==-1)
				{
					if($tipoPlan==0)
					{
						if($idPlanEstudioOrigen==$idPlanEstudioDestino)	
						{
							$idMateriasPlanOrigen=$fMaterias[0];
							$materiasPlanOrigen=$fMaterias[1];
							$modificable=0;
							$arrMateriasOrigen="['".$idMateriasPlanOrigen."','".cv($materiasPlanOrigen)."']";
						}
					}
					
				}
				else
				{
					
					
					$consulta="SELECT idMateriaEquivalente FROM 4500_relacionEquivalenciaMaterias WHERE idEquivalenciaPlanEstudio=".$idEquivalenciaPlanEstudio." AND idMateriaBase=".$fMaterias[0]." and idMateriaEquivalente is not null";

					$res=$con->obtenerFilas($consulta);
					while($fila=mysql_fetch_row($res))
					{
						if($tipoPlan==0)
						{
							$consulta="SELECT nombreMateria FROM 4502_Materias WHERE idMateria=".$fila[0];		
						}
						else
						{
							$consulta="SELECT upper(CONCAT('[',IF(cveMateria IS NULL,'',cveMateria),']',nombreMateria)) AS nombreMateria 
										FROM 6019_materiasPlanEstudioEscuelaOrigen WHERE idMateriaPlanEstudioEscuelaOrigen=".$fila[0];
						}
						
						$materiasPlanOrigen=$con->obtenerValor($consulta);	
						
						$o='{"idMateria":"'.$fila[0].'","nombreMateria":"'.cv($materiasPlanOrigen).'"}';
						if($arrMateriasOrigen=="")
							$arrMateriasOrigen=$o;
						else
							$arrMateriasOrigen.=",".$o;
							
							
						if($idMateriasPlanOrigen=="")	
							$idMateriasPlanOrigen=$fila[0];
						else
							$idMateriasPlanOrigen.=",".$fila[0];
											
					}
				}
				
				$arrMateriasOrigen='['.$arrMateriasOrigen.']';
				
				$calificacion="";
				$situacion="";
				$idRevalidacion="";
				$tipoResolucion="";				
				
				if($idMateriasPlanOrigen=="")
					$idMateriasPlanOrigen=" is null";
				else
					$idMateriasPlanOrigen=" in(".$idMateriasPlanOrigen.")";
				
				$consulta="SELECT calificacion,situacion,idRevalidacion,tipoResolucion FROM 4575_calificacionesSolicitudesRevalidacion 
								WHERE  idSolicitudRevaliacion=".$idRegistro." AND idMateriaOrigen ".$idMateriasPlanOrigen." and idMateriaDestino=".$fMaterias[0];
				
				$fCalificacion=$con->obtenerPrimeraFila($consulta);

				if($fCalificacion)
				{
					$calificacion=$fCalificacion[0];
					$situacion=$fCalificacion[1];
					$idRevalidacion=$fCalificacion[2];
					$tipoResolucion=$fCalificacion[3];
				}
				
				
				$o=	'{"tipoResolucion":"'.$tipoResolucion.'","idRevalidacion":"'.$idRevalidacion.'","situacion":"'.$situacion.'","idMateriasPlanOrigen":"'.$idMateriasPlanOrigen.
					'","materiasPlanOrigen":"'.cv($materiasPlanOrigen).'","arrMateriasOrigen":'.$arrMateriasOrigen.',"idMateriasPlanDestino":"'.$fMaterias[0].'","materiasPlanDestino":"'.
					cv($fMaterias[1]).'","calificacion":"'.cv($calificacion).'","nodoAsignado":"","modificable":"'.$modificable.'","materiaClon":"","grado":"'.cv($fGrado[0]).
					'","idGrado":"'.cv($fGrado[2]).'"}';
					
				if($arrMaterias=="")	
					$arrMaterias=$o;
				else
					$arrMaterias.=",".$o;
				
				$nRegistros++;	
					
			}
			

			
		}
		
		echo '{"numReg":"'.$nRegistros.'","registros":['.$arrMaterias.']}';
		
	}
	
	function guardarEvaluacionRevalidacion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		if($obj->gradoInscribe=="")
			$obj->gradoInscribe="NULL";
			
		$query="SELECT planEstudioDestino FROM _1066_tablaDinamica WHERE id__1066_tablaDinamica=".$obj->idRegistro;
		$idInstancia=$con->obtenerValor($query);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$query="SELECT id_4574_solicitudesRevalidacion FROM 4574_solicitudesRevalidacion WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idRegistro;
		$idSolicitud=$con->obtenerValor($query);
		if($idSolicitud=="")
		{
			$consulta[$x]="INSERT INTO 4574_solicitudesRevalidacion(idFormulario,idReferencia,gradoInscribe) VALUES(".$obj->idFormulario.",".$obj->idRegistro.",".$obj->gradoInscribe.")";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
		}
		else
		{
			$consulta[$x]="update 4574_solicitudesRevalidacion set gradoInscribe=".$obj->gradoInscribe." where  id_4574_solicitudesRevalidacion=".$idSolicitud;
			$x++;
			$consulta[$x]="set @idRegistro:=".$idSolicitud;
			$x++;
			$consulta[$x]="delete from 4575_calificacionesSolicitudesRevalidacion WHERE idSolicitudRevaliacion=@idRegistro";
		}
		$x++;
		if(sizeof($obj->materias)>0)
		{
			foreach($obj->materias as $m)
			{
				$situacion=2;
				if($m->tipoResolucion==1)
				{
					if(esCalificacionAprobatoria($m->idMateriaD,$m->calificacion,$idInstancia)==1)
						$situacion=1;
				}
				else
					$situacion=1;
					
				if($m->tipoResolucion=="")	
					$m->tipoResolucion="NULL";
					
				if($m->idMateriaO=="")	
					$m->idMateriaO="NULL";
				
				if($m->idMateriaD=="")	
					$m->idMateriaD="NULL";
				
				if($m->idMateriaO=="NULL")
				{
					$consulta[$x]="INSERT INTO 4575_calificacionesSolicitudesRevalidacion(idSolicitudRevaliacion,idMateriaOrigen,idMateriaDestino,calificacion,situacion,tipoResolucion) 
									VALUES(@idRegistro,".$m->idMateriaO.",".$m->idMateriaD.",'".$m->calificacion."',".$situacion.",".$m->tipoResolucion.")";
					$x++;
				}
				else
				{
					$arrMateriasO=explode(",",$m->idMateriaO);

					foreach($arrMateriasO as $mO)
					{
						$consulta[$x]="INSERT INTO 4575_calificacionesSolicitudesRevalidacion(idSolicitudRevaliacion,idMateriaOrigen,idMateriaDestino,calificacion,situacion,tipoResolucion) 
									VALUES(@idRegistro,".$mO.",".$m->idMateriaD.",'".$m->calificacion."',".$situacion.",".$m->tipoResolucion.")";
									
						
						$x++;
					}
				}
			}
		}
		
		
		
		$query="SELECT * FROM _1066_tablaDinamica WHERE id__1066_tablaDinamica=".$obj->idRegistro;
		$fRegistro=$con->obtenerPrimeraFila($query);
		$idEscuelaOrigen=$fRegistro[22];
		if($idEscuelaOrigen==2)//Externa
		{
			$tipoPlan=1;
			$idPlanEstudioOrigen=$fRegistro[24];
		}
		else
		{
			$tipoPlan=0;
			$query="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$fRegistro[28];
			$idPlanEstudioOrigen=$con->obtenerValor($query);
		}
		$query="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$fRegistro[26];
		$idPlanEstudioDestino=$con->obtenerValor($query);

		$query="SELECT idEquivalenciaPlanEstudio FROM 4500_equivalenciasPlanEstudio WHERE  idPlanEstudioBase=".$idPlanEstudioDestino." AND 
					tipoPlanEstudioEquivalencia=".$tipoPlan." AND idPlanEstudioEquivalencia=".$idPlanEstudioOrigen;
		$idEquivalenciaPlanEstudio=$con->obtenerValor($query);
		if($idEquivalenciaPlanEstudio=="")
		{
			
			$consulta[$x]="INSERT INTO 4500_equivalenciasPlanEstudio(idPlanEstudioBase,tipoPlanEstudioEquivalencia,idPlanEstudioEquivalencia,fechaCreacion,idResponsableCreacion)
						VALUES(".$idPlanEstudioDestino.",".$tipoPlan.",".$idPlanEstudioOrigen.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].")";
			$x++;
			$consulta[$x]="set @idEquivalencia:=(select last_insert_id())";
			$x++;
		}
		else
		{
				
			$consulta[$x]="set @idEquivalencia:=".$idEquivalenciaPlanEstudio;
			$x++;
		}
		
		$consulta[$x]="delete from 4500_relacionEquivalenciaMaterias where idEquivalenciaPlanEstudio=@idEquivalencia";
		$x++;
		
		$consulta[$x]="commit";
		$x++;
	
		if($con->ejecutarBloque($consulta))
		{
		//Revisar Marca
			$consulta=array();
			$x=0;
			$consulta[$x]="begin";
			$x++;
			if(sizeof($obj->materias)>0)
			{
				foreach($obj->materias as $m)
				{
						
					$arrMaterias=explode(",",$m->idMateriaO);
					foreach($arrMaterias as $mat)
					{
						$materiaClon=0;
						$consulta[$x]="INSERT INTO 4500_relacionEquivalenciaMaterias(idEquivalenciaPlanEstudio,idMateriaBase,idMateriaEquivalente,modificable,materiaClon) 
										VALUES (@idEquivalencia,".$m->idMateriaD.",".$mat.",1,".$materiaClon.")";
						$x++;
					}
					/*/*$query="select count(*) from 4500_relacionEquivalenciaMaterias WHERE idEquivalenciaPlanEstudio=@idEquivalencia AND idMateriaBase=".$m->idMateriaD." AND idMateriaEquivalente=".$m->idMateriaO;
					
					$nReg=$con->obtenerValor($query);
					
					if($nReg==0)
					{
						$materiaClon=0;
						
						$consulta[$x]="INSERT INTO 4500_relacionEquivalenciaMaterias(idEquivalenciaPlanEstudio,idMateriaBase,idMateriaEquivalente,modificable,materiaClon) 
									VALUES (@idEquivalencia,".$m->idMateriaD.",".$m->idMateriaO.",1,".$materiaClon.")";
						
						
						$x++;
					}*/
					
				}
			}
			$consulta[$x]="commit";
			$x++;

			if($con->ejecutarBloque($consulta))
			{
				$query="select @idRegistro";
				$idSolicitud=$con->obtenerValor($query);
				//if(evaluarMateriasSolicitudEquivalencia($idSolicitud))
				{
					echo "1|";
				}
			}
		}
		
	}
	
	function buscarAlumnosPlantel()
	{
		global $con;
		$criterio=$_POST["criterio"];
		
		$consulta="SELECT i.idUsuario,i.Paterno AS apPaterno,Materno AS apMaterno,Nom AS nombre,Nombre AS nombreCompleto 
				FROM 802_identifica i,807_usuariosVSRoles u WHERE Nombre LIKE '%".cv($criterio)."%' AND u.idUsuario=i.idUsuario AND (u.idRol=7 or u.idRol=79)";
				
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';				
	}
	
	function buscarAdeudosAlumnoCaja()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$fechaActual=date("Y-m-d");
		$nReg=0;
		$arrRegistros="";
		$consulta="SELECT idMovimiento,idReferencia AS folioReferencia,fechaGeneracionFolio AS fechaReferencia,descripcionAdeudo AS concepto 
					FROM 6011_movimientosPago WHERE pagado=0 AND situacion=1 AND idUsuario=".$idUsuario;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$consulta="SELECT idAsientosPago,monto FROM 6012_asientosPago WHERE idReferenciaMovimiento=".$fila[0]." AND pagado=1";
			$fRegReferencia=$con->obtenerPrimeraFila($consulta);
			if(!$fRegReferencia)
			{
				$consulta="SELECT idAsientosPago,monto FROM 6012_asientosPago WHERE idReferenciaMovimiento=".$fila[0]." AND fechaInicio<='".$fechaActual."' ORDER BY fechaInicio DESC"	;
				$fRegReferencia=$con->obtenerPrimeraFila($consulta);
			}
			
			
			
			
			$montoTotalPago=$fRegReferencia[1];
			
			$consulta="SELECT SUM(montoParcialidad) FROM 6012_parcialidadesPago WHERE idMovimiento=".$fila[0];
			$totalParcial=$con->obtenerValor($consulta);
			if($totalParcial=="")
				$totalParcial=0;
				
			$montoTotalPago-=$totalParcial;
			
				
			
			
			$o='{"idMovimento":"'.$fila[0].'","folioReferencia":"'.cv($fila[1]).'","fechaReferencia":"'.$fila[2].'","monto":"'.$montoTotalPago.'","concepto":"'.$fila[3].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$nReg++;
		}
		
		
		echo '{"numReg":"'.$nReg.'","registros":['.$arrRegistros.']}';				
	}
	
	function obtenerDocumentosInscripcion()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$nReg=0;
		$cadRegistros="";
		$idInstancia=-1;
		$idUsuario=-1;
		switch($idFormulario)
		{
			case 678:
				$consulta="SELECT idInstanciaPlan,idUsuario FROM _678_tablaDinamica WHERE id__678_tablaDinamica=".$idRegistro;
				$fSolicitud=$con->obtenerPrimeraFila($consulta);
				$idInstancia=$fSolicitud[0];
				
				$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstancia;
				
				$idPlanEstudio=$con->obtenerValor($consulta);
				
				$consulta="SELECT idReferencia FROM _1068_gridPlanesEstudio WHERE planEstudio=".$idPlanEstudio;
				$idPerfil=$con->obtenerValor($consulta);
				if($idPerfil=="")
					$idPerfil=-1;
				
				
				$idUsuario=$fSolicitud[1];
				
				if($idUsuario=="")
					$idUsuario=-1;
				
			break;
			
		}
		
		
		$consulta="SELECT COUNT(*) FROM 4599_dictamenEvaluacionDocumentosInscripcion WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$nRegDocumento=$con->obtenerValor($consulta);
		if($nRegDocumento==0)
		{
			$consulta="SELECT documentos,d.txtDocumento,requerido,'' as funcionAplicacion FROM _1068_documentosInscripcion t,_391_tablaDinamica d 
						WHERE t.idReferencia=".$idPerfil." AND d.id__391_tablaDinamica=t.documentos ORDER BY txtDocumento";

		}
		else
		{
			$consulta="SELECT t.idDocumento,d.txtDocumento,'1' as requerido,'' as funcionAplicacion FROM 4598_evaluacionDocumentosInscripcion t,_391_tablaDinamica d 
						WHERE t.idFormulario=".$idFormulario." AND t.idReferencia=".$idRegistro." and  d.id__391_tablaDinamica=t.idDocumento ORDER BY txtDocumento";
		}
		
	
		$res=$con->obtenerFilas($consulta);
		$numReg=0;
		while($fila=mysql_fetch_row($res))
		{
			$mostrarDocumento=false;
			$documentoRequerido=true;
			if($fila[2]==0)
			{
				$consulta="SELECT COUNT(*) FROM 825_documentosUsr WHERE idUsuario=".$idUsuario." AND idDocumento=".$fila[0];

				$nReg=$con->obtenerValor($consulta);
				if($nReg>0)
					$documentoRequerido=false;
			}
			
			if($documentoRequerido)
			{
				if($fila[3]=="")
				{
					$mostrarDocumento=true;
				}
				else
				{
					$arrParam["idFormulario"]=$idFormulario;
					$arrParam["idRegistro"]=$idRegistro;
					$arrParam["idUsuario"]=$idUsuario;
					$arrParam["idInstancia"]=$idInstancia;
					$arrParam["idDocumento"]=$fila[0];
					$cache=NULL;
					$cadObjParam='{"param1":null}';
					$objParam1=json_decode($cadObjParam);
					$objParam1->param1=$arrParam;
					$resultado=resolverExpresionCalculoPHP($fila[3],$objParam1,$cache);
					$resultado=removerComillasLimite($resultado);
					$mostrarDocumento=($resultado==1);
					
				}
			}
			
			if(($nRegDocumento>0)||($mostrarDocumento))
			{
			
				$consulta="SELECT * FROM 4598_evaluacionDocumentosInscripcion WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND idDocumento=".$fila[0];
				$fDocumento=$con->obtenerPrimeraFila($consulta);
				$documentoDigital="";
				if($fDocumento[5]!="")
				{
					$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fDocumento[5];
					$documentoDigital=$con->obtenerValor($consulta);
					$documentoDigital.="|".$fDocumento[5];
				}
				$obj='{"idDocumento":"'.$fila[0].'","documento":"'.cv($fila[1]).'","situacion":"'.$fDocumento[4].'","fechaCondicionamiento":"'.$fDocumento[6].'","observaciones":"'.cv($fDocumento[7]).'","documentoDigital":"'.$documentoDigital.'"}';
				if($cadRegistros=="")
					$cadRegistros=$obj;
				else
					$cadRegistros.=",".$obj;
				$numReg++;
			}
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$cadRegistros.']}';
	}
	
	
	function obtenerMateriasInstanciaPlanEquivalencia()
	{
		global $con;
		
		
		$iS=$_POST["iS"];
		
		$consulta="SELECT * FROM _1066_tablaDinamica WHERE id__1066_tablaDinamica=".$iS;
		$fRegistro=$con->obtenerPrimeraFila($consulta);		
		
		$iEscuelaOrigen=$fRegistro[23];
		$iPlanOrigen=$fRegistro[24];
		$nPlanEstudio="";
		if($fRegistro[22]==2)
		{
			$consulta="SELECT nombrePlanEstudios FROM 6018_planesEstudioEscuelaOrigen WHERE idPlanEstudioEscuelas=".$iEscuelaOrigen;
			$nPlanEstudio=$con->obtenerValor($consulta);
			$consulta="SELECT idMateriaPlanEstudioEscuelaOrigen,upper(CONCAT('[',IF(cveMateria IS NULL,'',cveMateria),']',nombreMateria)) AS nombreMateria FROM 6019_materiasPlanEstudioEscuelaOrigen WHERE idPlanEstudios=".$iPlanOrigen." ORDER BY nombreMateria";
		}
		
		$res=$con->obtenerFilas($consulta);
		$cadMaterias="";
		while($fMaterias=mysql_fetch_row($res))
		{
			$o='{icon:"../images/text_lowercase.png",allowDrop:false,allowDrag:true,draggable:true,clave:"",id:"'.$fMaterias[0].'",idUnidad:"'.$fMaterias[0].'",nUnidad:"'.cv($fMaterias[1]).'",text:"<span style=\'color:#030\'><b>'.cv($fMaterias[1]).'</b></span>",tUnidad:"0","leaf":true}';
			if($cadMaterias=="")
				$cadMaterias=$o;
			else
				$cadMaterias.=",".$o;
		}

		
		$obj='{icon:"../images/Icono_3d.gif",allowDrop:false,allowDrag:false,draggable:false,clave:"",id:"'.$iEscuelaOrigen.'_'.$iPlanOrigen.'",idUnidad:"0",nUnidad:"'.cv($nPlanEstudio).'",text:"<span style=\'color:#030\'><b>'.cv($nPlanEstudio).'</b></span>",tUnidad:"1","leaf":false,children:['.$cadMaterias.']}';		
		echo '[',$obj,']';								
		
	}
	
	function obtenerMateriasRevalidacionFinalSolicitud()
	{
		global $con;
		
		
		$esEvaluacionFinal=false;
		$arrMaterias="";
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="SELECT * FROM _1066_tablaDinamica WHERE id__1066_tablaDinamica=".$idRegistro;
		
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		$idEscuelaOrigen=$fRegistro[22];
		if($idEscuelaOrigen==2)//Externa
		{
			$tipoPlan=1;
			$idPlanEstudioOrigen=$fRegistro[24];
		}
		else
		{
			$tipoPlan=0;
			$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$fRegistro[28];
			$idPlanEstudioOrigen=$con->obtenerValor($consulta);
		}
	
		$consulta="SELECT id_4574_solicitudesRevalidacion FROM 4574_solicitudesRevalidacionFinal WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$idSolicitud=$con->obtenerValor($consulta);
		
		if($idSolicitud=="")
		{
			$consulta="SELECT id_4574_solicitudesRevalidacion FROM 4574_solicitudesRevalidacion WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
			$idSolicitud=$con->obtenerValor($consulta);
		}
		else
			$esEvaluacionFinal=true;

		$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$fRegistro[26];
		$idPlanEstudioDestino=$con->obtenerValor($consulta);
		
		
		if($esEvaluacionFinal)
			$consulta="SELECT idEquivalenciaPlanEstudio FROM 4500_equivalenciasPlanEstudioFinal WHERE  idPlanEstudioBase=".$idPlanEstudioDestino." AND 
						tipoPlanEstudioEquivalencia=".$tipoPlan." AND idPlanEstudioEquivalencia=".$idPlanEstudioOrigen;

		else
			$consulta="SELECT idEquivalenciaPlanEstudio FROM 4500_equivalenciasPlanEstudio WHERE  idPlanEstudioBase=".$idPlanEstudioDestino." AND 
						tipoPlanEstudioEquivalencia=".$tipoPlan." AND idPlanEstudioEquivalencia=".$idPlanEstudioOrigen;

		
		$idEquivalenciaPlanEstudio=$con->obtenerValor($consulta);
		if($idEquivalenciaPlanEstudio=="")
			$idEquivalenciaPlanEstudio=-1;


		
		

		$nRegistros=0;
		$arrMaterias="";
		$consulta="SELECT g.leyendaGrado,e.codigoUnidad,g.idGrado FROM  4505_estructuraCurricular e,4501_Grado g WHERE e.idPlanEstudio=".$idPlanEstudioDestino.
					" AND e.tipoUnidad=3 AND g.idGrado=e.idUnidad ORDER BY g.ordenGrado";
		$resGrado=$con->obtenerFilas($consulta);
		while($fGrado=mysql_fetch_row($resGrado))
		{
			$consulta="SELECT idMateria,upper(nombreMateria) FROM 4502_Materias m,4505_estructuraCurricular e WHERE e.idPlanEstudio=".$idPlanEstudioDestino." AND e.idPlanEstudio=m.idPlanEstudio AND 
						e.tipoUnidad=1 AND m.idMateria=e.idUnidad and codigoPadre LIKE '".$fGrado[1]."%'  ORDER BY nombreMateria";
			
			
			$rMaterias=$con->obtenerFilas($consulta);
			while($fMaterias=mysql_fetch_row($rMaterias))
			{
				
				$idMateriasPlanOrigen="";
				$materiasPlanOrigen="";
				$modificable=1;
				
				$arrMateriasOrigen="";				
				if($idEquivalenciaPlanEstudio==-1)
				{
					if($tipoPlan==0)
					{
						if($idPlanEstudioOrigen==$idPlanEstudioDestino)	
						{
							$idMateriasPlanOrigen=$fMaterias[0];
							$materiasPlanOrigen=$fMaterias[1];
							$modificable=0;
							$arrMateriasOrigen="['".$idMateriasPlanOrigen."','".cv($materiasPlanOrigen)."']";
						}
					}
					
				}
				else
				{
					
					if($esEvaluacionFinal)
						$consulta="SELECT idMateriaEquivalente FROM 4500_relacionEquivalenciaMateriasFinal WHERE idEquivalenciaPlanEstudio=".$idEquivalenciaPlanEstudio." AND idMateriaBase=".$fMaterias[0]." and idMateriaEquivalente is not null";
					else
						$consulta="SELECT idMateriaEquivalente FROM 4500_relacionEquivalenciaMaterias WHERE idEquivalenciaPlanEstudio=".$idEquivalenciaPlanEstudio." AND idMateriaBase=".$fMaterias[0]." and idMateriaEquivalente is not null";

					$res=$con->obtenerFilas($consulta);
					while($fila=mysql_fetch_row($res))
					{
						if($tipoPlan==0)
						{
							$consulta="SELECT nombreMateria FROM 4502_Materias WHERE idMateria=".$fila[0];		
						}
						else
						{
							$consulta="SELECT upper(CONCAT('[',IF(cveMateria IS NULL,'',cveMateria),']',nombreMateria)) AS nombreMateria 
										FROM 6019_materiasPlanEstudioEscuelaOrigen WHERE idMateriaPlanEstudioEscuelaOrigen=".$fila[0];
						}
						
						$materiasPlanOrigen=$con->obtenerValor($consulta);	
						
						$o='{"idMateria":"'.$fila[0].'","nombreMateria":"'.cv($materiasPlanOrigen).'"}';
						if($arrMateriasOrigen=="")
							$arrMateriasOrigen=$o;
						else
							$arrMateriasOrigen.=",".$o;
							
							
						if($idMateriasPlanOrigen=="")	
							$idMateriasPlanOrigen=$fila[0];
						else
							$idMateriasPlanOrigen.=",".$fila[0];
											
					}
				}
				
				$arrMateriasOrigen='['.$arrMateriasOrigen.']';
				
				$calificacion="";
				$situacion="";
				$idRevalidacion="";
				$tipoResolucion="";				
				
				if($idMateriasPlanOrigen=="")
					$idMateriasPlanOrigen=" is null";
				else
					$idMateriasPlanOrigen=" in(".$idMateriasPlanOrigen.")";
				
				if($esEvaluacionFinal)
				{
					
					$consulta="SELECT calificacion,situacion,idRevalidacion,tipoResolucion FROM 4575_calificacionesSolicitudesRevalidacionFinal 
								WHERE  idSolicitudRevaliacion=".$idRegistro." AND idMateriaOrigen ".$idMateriasPlanOrigen." and idMateriaDestino=".$fMaterias[0];
					
				}
				else
				{
					$consulta="SELECT calificacion,situacion,idRevalidacion,tipoResolucion FROM 4575_calificacionesSolicitudesRevalidacion 
								WHERE  idSolicitudRevaliacion=".$idRegistro." AND idMateriaOrigen ".$idMateriasPlanOrigen." and idMateriaDestino=".$fMaterias[0];
				}
				$fCalificacion=$con->obtenerPrimeraFila($consulta);

				if($fCalificacion)
				{
					$calificacion=$fCalificacion[0];
					$situacion=$fCalificacion[1];
					$idRevalidacion=$fCalificacion[2];
					$tipoResolucion=$fCalificacion[3];
				}
				
				
				$o=	'{"tipoResolucion":"'.$tipoResolucion.'","idRevalidacion":"'.$idRevalidacion.'","situacion":"'.$situacion.'","idMateriasPlanOrigen":"'.$idMateriasPlanOrigen.
					'","materiasPlanOrigen":"'.cv($materiasPlanOrigen).'","arrMateriasOrigen":'.$arrMateriasOrigen.',"idMateriasPlanDestino":"'.$fMaterias[0].'","materiasPlanDestino":"'.
					cv($fMaterias[1]).'","calificacion":"'.cv($calificacion).'","nodoAsignado":"","modificable":"'.$modificable.'","materiaClon":"","grado":"'.cv($fGrado[0]).
					'","idGrado":"'.cv($fGrado[2]).'"}';
					
				if($arrMaterias=="")	
					$arrMaterias=$o;
				else
					$arrMaterias.=",".$o;
				
				$nRegistros++;	
					
			}
			

			
		}
		
		echo '{"numReg":"'.$nRegistros.'","registros":['.$arrMaterias.']}';
		
	}
	
	function guardarEvaluacionFinalRevalidacion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		if($obj->gradoInscribe=="")
			$obj->gradoInscribe="NULL";
			
		$query="SELECT planEstudioDestino FROM _1066_tablaDinamica WHERE id__1066_tablaDinamica=".$obj->idRegistro;
		$idInstancia=$con->obtenerValor($query);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$query="SELECT id_4574_solicitudesRevalidacion FROM 4574_solicitudesRevalidacionFinal WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idRegistro;
		$idSolicitud=$con->obtenerValor($query);
		if($idSolicitud=="")
		{
			$consulta[$x]="INSERT INTO 4574_solicitudesRevalidacionFinal(idFormulario,idReferencia,gradoInscribe) VALUES(".$obj->idFormulario.",".$obj->idRegistro.",".$obj->gradoInscribe.")";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
		}
		else
		{
			$consulta[$x]="update 4574_solicitudesRevalidacionFinal set gradoInscribe=".$obj->gradoInscribe." where  id_4574_solicitudesRevalidacion=".$idSolicitud;
			$x++;
			$consulta[$x]="set @idRegistro:=".$idSolicitud;
			$x++;
			$consulta[$x]="delete from 4575_calificacionesSolicitudesRevalidacionFinal WHERE idSolicitudRevaliacion=@idRegistro";
		}
		$x++;
		
		if(sizeof($obj->materias)>0)
		{
			foreach($obj->materias as $m)
			{
				$situacion=2;
				if($m->tipoResolucion==1)
				{
					if(esCalificacionAprobatoria($m->idMateriaD,$m->calificacion,$idInstancia)==1)
						$situacion=1;
				}
				else
					$situacion=1;
					
				if($m->tipoResolucion=="")	
					$m->tipoResolucion="NULL";
					
				if($m->idMateriaO=="")	
					$m->idMateriaO="NULL";
				
				if($m->idMateriaD=="")	
					$m->idMateriaD="NULL";
				
				if($m->idMateriaO=="NULL")
				{
					$consulta[$x]="INSERT INTO 4575_calificacionesSolicitudesRevalidacionFinal(idSolicitudRevaliacion,idMateriaOrigen,idMateriaDestino,calificacion,situacion,tipoResolucion) 
									VALUES(@idRegistro,".$m->idMateriaO.",".$m->idMateriaD.",'".$m->calificacion."',".$situacion.",".$m->tipoResolucion.")";
					$x++;
				}
				else
				{
					$arrMateriasO=explode(",",$m->idMateriaO);

					foreach($arrMateriasO as $mO)
					{
						$consulta[$x]="INSERT INTO 4575_calificacionesSolicitudesRevalidacionFinal(idSolicitudRevaliacion,idMateriaOrigen,idMateriaDestino,calificacion,situacion,tipoResolucion) 
									VALUES(@idRegistro,".$mO.",".$m->idMateriaD.",'".$m->calificacion."',".$situacion.",".$m->tipoResolucion.")";
									
						
						$x++;
					}
				}
			}
		}
		
		
		
		$query="SELECT * FROM _1066_tablaDinamica WHERE id__1066_tablaDinamica=".$obj->idRegistro;
		$fRegistro=$con->obtenerPrimeraFila($query);
		$idEscuelaOrigen=$fRegistro[22];
		if($idEscuelaOrigen==2)//Externa
		{
			$tipoPlan=1;
			$idPlanEstudioOrigen=$fRegistro[24];
		}
		else
		{
			$tipoPlan=0;
			$query="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$fRegistro[28];
			$idPlanEstudioOrigen=$con->obtenerValor($query);
		}
		$query="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$fRegistro[26];
		$idPlanEstudioDestino=$con->obtenerValor($query);

		$query="SELECT idEquivalenciaPlanEstudio FROM 4500_equivalenciasPlanEstudioFinal WHERE  idPlanEstudioBase=".$idPlanEstudioDestino." AND 
					tipoPlanEstudioEquivalencia=".$tipoPlan." AND idPlanEstudioEquivalencia=".$idPlanEstudioOrigen;
		$idEquivalenciaPlanEstudio=$con->obtenerValor($query);
		if($idEquivalenciaPlanEstudio=="")
		{
			$consulta[$x]="INSERT INTO 4500_equivalenciasPlanEstudioFinal(idPlanEstudioBase,tipoPlanEstudioEquivalencia,idPlanEstudioEquivalencia,fechaCreacion,idResponsableCreacion)
						VALUES(".$idPlanEstudioDestino.",".$tipoPlan.",".$idPlanEstudioOrigen.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].")";
			$x++;
			$consulta[$x]="set @idEquivalencia:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$consulta[$x]="set @idEquivalencia:=".$idEquivalenciaPlanEstudio;
			$x++;
		}
		
		$consulta[$x]="delete from 4500_relacionEquivalenciaMateriasFinal where idEquivalenciaPlanEstudio=@idEquivalencia";
		$x++;
		
		$consulta[$x]="commit";
		$x++;
	
		if($con->ejecutarBloque($consulta))
		{
		//Revisar Marca
			$consulta=array();
			$x=0;
			$consulta[$x]="begin";
			$x++;
			if(sizeof($obj->materias)>0)
			{
				foreach($obj->materias as $m)
				{
					$arrMaterias=explode(",",$m->idMateriaO);
					foreach($arrMaterias as $mat)
					{
						$materiaClon=0;
						$consulta[$x]="INSERT INTO 4500_relacionEquivalenciaMateriasFinal(idEquivalenciaPlanEstudio,idMateriaBase,idMateriaEquivalente,modificable,materiaClon) 
										VALUES (@idEquivalencia,".$m->idMateriaD.",".$mat.",1,".$materiaClon.")";
						$x++;
					}
				}
			}
			$consulta[$x]="commit";
			$x++;

			if($con->ejecutarBloque($consulta))
			{
				$query="select @idRegistro";
				$idSolicitud=$con->obtenerValor($query);
				//if(evaluarMateriasSolicitudEquivalencia($idSolicitud))
				{
					echo "1|";
				}
			}
		}
		
	}
	
	function obtenerEvaluacionGrupoAlumno()
	{
		
		global $con;
		
		$idCuestionario=$_POST["idCuestionario"];
		$idUsuario=$_POST["idUsuario"];
		$idAlumno=$_POST["idAlumno"];
		$idConvocatoria=$_POST["idConvocatoria"];
		
		
		$consulta="SELECT idGrupo FROM 4529_alumnos WHERE idUsuario=".$idAlumno." ORDER BY idAlumnoTabla DESC";

		$idGrupo=$con->obtenerValor($consulta);
		
		$arrGrupos=array();
		$consulta="SELECT idGrupos,situacion FROM 4520_grupos WHERE idGrupoPadre=".$idGrupo;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			if($fila[1]==1)
				$arrGrupos[$fila[0]]=1;
			else
			{
				$consulta="SELECT idGrupo FROM 4539_gruposCompartidos WHERE idGrupoReemplaza=".$fila[0];
				$fila[0]=$con->obtenerValor($consulta);
				$arrGrupos[$fila[0]]=1;
			}
		}
		
		
		
		$arrGruposEvaluacion=array();
		
		foreach($arrGrupos as $idGrupo=>$resto)
		{
			$consulta="SELECT m.nombreMateria FROM 4502_Materias m,4520_grupos g WHERE m.idMateria=g.idMateria AND g.idGrupos=".$idGrupo;
			$nombreMateria=$con->obtenerValor($consulta);
			
			$consulta="SELECT a.idUsuario,u.Nombre FROM 4519_asignacionProfesorGrupo a,800_usuarios u 
						WHERE a.idGrupo=".$idGrupo." AND a.fechaAsignacion<=a.fechaBaja AND u.idUsuario=a.idUsuario 
						ORDER BY a.fechaBaja DESC";
			$profesor=$con->obtenerPrimeraFila($consulta);
			
			$arrGruposEvaluacion[$nombreMateria]["idGrupo"]=$idGrupo;
			$arrGruposEvaluacion[$nombreMateria]["idUsuario"]=$profesor[0];
			$arrGruposEvaluacion[$nombreMateria]["profesor"]=$profesor[1];
			
			
		}
		
		ksort($arrGruposEvaluacion);
		
		
		$numReg=0;
		$arrRegistros="";
		
		$consulta="	
					select * from(
					(SELECT idElementoCuestionario,texto,ordenElemento FROM 9052_elementosCuestionario WHERE codigoPadre LIKE '".str_pad($idCuestionario,4,"0",STR_PAD_LEFT)."%' AND 
					tipoElemento=3)
					union
					(select 0 as idElementoCuestionario,'COMENTARIOS Y SUGERENCIAS' as texto,1000 as ordenElemento) 
					) as tmp
					
					ORDER BY ordenElemento";

		$rPregunta=$con->obtenerFilas($consulta);
		while($fPregunta=mysql_fetch_row($rPregunta))
		{
			$numReg++;
			$registro='{"concepto":"'.$numReg.".- ".cv($fPregunta[1]).'","noPregunta":"'.$fPregunta[0].'"';
		
			foreach($arrGruposEvaluacion as $nombreMateria=>$datos)
			{
				$nCampo=$datos["idGrupo"].'_'.$datos["idUsuario"];
				
				$consulta="SELECT valor FROM 000_resultadosEvaluacionGrupo WHERE noPregunta=".$fPregunta[0].
						" AND idGrupo=".$datos["idGrupo"]." AND idProfesor=".$datos["idUsuario"].
						" AND idUsuario='".$idUsuario."' AND idConvocatoria=".$idConvocatoria;
						
				
				$valor=$con->obtenerValor($consulta);
				
				$registro.=',"'.$nCampo.'":"'.cv($valor).'"';
				
				
			}
			
			$registro.='}';
				
			if($arrRegistros=="")
				$arrRegistros=$registro;
			else
				$arrRegistros.=",".$registro;
		}
		
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	function guardarRespuestaEvaluacionAlumnoGrupo()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		$consulta="SELECT idRegistro FROM 000_resultadosEvaluacionGrupo WHERE 
				noPregunta=".$obj->noPregunta." AND idGrupo=".$obj->idGrupo." AND idProfesor=".$obj->idProfesor.
				" AND idAlumno=".$obj->idAlumno." AND idConvocatoria=".$obj->idConvocatoria;
		
		$idRegistro=$con->obtenerValor($consulta);
		
		if($idRegistro=="")
		{
			$consulta="INSERT INTO 000_resultadosEvaluacionGrupo(noPregunta,idGrupo,idProfesor,idUsuario,idConvocatoria,valor,idAlumno)
						VALUES(".$obj->noPregunta.",".$obj->idGrupo.",".$obj->idProfesor.",".$obj->idUsuario.",".$obj->idConvocatoria.
						",'".cv($obj->valor)."',".$obj->idAlumno.")";
		}
		else
		{
			$consulta="UPDATE 000_resultadosEvaluacionGrupo SET valor='".cv($obj->valor)."' WHERE idRegistro=".$idRegistro;
		}
		
		eC($consulta);
	}
		
		
	function finalizarRegistroEvaluacion()
	{
		global $con;
		$idAlumno=$_POST["iA"];
		$idConvocatoria=$_POST["iC"];
		$consulta="INSERT INTO 0001_situacionEvaluacionAlumno(idAlumno,idConvocatoria,situacion) VALUES(".$idAlumno.",".$idConvocatoria.",1)";
		eC($consulta);
	}
	
	function guardarRespuestasEvaluacion()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$idAlumno=$_POST["idAlumno"];
		$idConvocatoria=$_POST["iC"];
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$query[$x]="delete from 000_resultadosEvaluacionGrupo where idUsuario='".$idUsuario."' and idConvocatoria=".$idConvocatoria;
		$x++;
		
		foreach($obj->arrCuestionario as $c)
		{
			$query[$x]="INSERT INTO 000_resultadosEvaluacionGrupo(noPregunta,idGrupo,idProfesor,idAlumno,idConvocatoria,valor,idUsuario)
						VALUES(".$c->noPregunta.",".$c->idGrupo.",".$c->idProfesor.",'".$idAlumno."',".$c->idConvocatoria.
						",'".cv($c->valor)."','".$idUsuario."')";
			$x++;
		}
		
		$query[$x]="INSERT INTO 0001_situacionEvaluacionAlumno(idAlumno,idConvocatoria,situacion) VALUES('".$idUsuario."',".$idConvocatoria.",1)";
		$x++;
		$query[$x]="commit";
		$x++;
		eB($query);
		
	}
?>