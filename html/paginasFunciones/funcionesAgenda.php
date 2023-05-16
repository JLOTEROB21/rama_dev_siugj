<?php session_start();
	include("conexionBD.php"); 
	include_once("funcionesValidacionGrupos.php"); 
	
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
			guardarEvento();
		break;
		case 2:
			eliminarEvento();
		break;
		case 3:
			obtenerListadoCalendarios();
		break;
		case 4:
			obtenerListadoEventos();
		break;
		case 5:
			modificarFechaHoraEvento();
		break;
		case 6:
			obtenerParticipantesEvento();
		break;
		case 7:
			obtenerUsuariosRol();
		break;
		case 8:
			guardarComentarioEvento();
		break;
		case 9:
			obtenerTipoEventoAlmacen();
		break;
		case 10:
			obtenerEventosAlmacen();
		break;
		case 11:
			obtenerTipoEventoProveedor();
		break;
		case 12:
			obtenerEventosProveedor();
		break;
		case 13:
			obtenerCalendariosHorario();
		break;
		case 14:
			obtenerListadoHorario();
		break;
		case 15:
			guardarHorario();
		break;
		case 16:
			modificarHorario();
		break;
		
		case 17:
			eliminarHorario();
		break;
		case 18:
			obtenerHorarioMateria();
		break;
		case 19:
			guardarHorarioGrupo();
		break;
		case 20:
			modificarHorarioGrupo();
		break;
		case 21:
			eliminarHorarioGrupo();
		break;
		case 22:
			obtenerProcesos();
		break;
		case 23:
			obtenerDisponibilidadHorarioProfesor();
		break;
		case 24:
			obtenerCandidatos();
		break;
		case 25:
			inscribirProfesorCurso();
		break;
		case 26:
			removerProfesorTitular();
		break;

		case 27:
			obtenerHorarioArea();
		break;
		case 28:
			obtenerCalendariosAreaFisica();
		break;
		case 29:
			obtenerAgendaGrupo();
		break;
		case 30:
			obtenerListadoEventosReasignacion();
		break;
		case 31:
			validarHorarioAula();
		break;
		case 32:
			guardarHorarioGrupoV2();
		break;
		case 33:
			inscribirProfesorCursoV2();
		break;
		case 34:
			obtenerRecesoGrupos();
		break;
		case 35:
			obtenerHorarioAlumno();
		break;
		case 36:
			obtenerHorarioGrupos();
		break;
	}
	
	function guardarEvento()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
		
			if($obj->idEvento=="-1")
			{
				$consulta="INSERT INTO 4089_eventos(tituloEvento,idUsuario,fechaInicio,horaInicio,fechaFinal,horaFinal,todoDia,tipoEvento,notas,lugar,paginaWeb,recordar) 
							VALUES('".cv($obj->tituloEvento)."','".$_SESSION["idUsr"]."','".$obj->fechaInicio."','".$obj->horaInicio."','".$obj->fechaFinal."','".
							$obj->horaFinal."',".$obj->todoDia.",".$obj->tipoEvento.",'".cv($obj->notas)."','".cv($obj->lugar)."','".cv($obj->paginaWeb)."',".$obj->recordar.");";
			}
			else
			{
				$consulta="	update 4089_eventos set tituloEvento='".cv($obj->tituloEvento)."',fechaInicio='".$obj->fechaInicio."',horaInicio='".$obj->horaInicio."',
							fechaFinal='".$obj->fechaFinal."',horaFinal='".$obj->horaFinal."',todoDia=".$obj->todoDia.",tipoEvento=".$obj->tipoEvento.",
							notas='".cv($obj->notas)."',lugar='".cv($obj->lugar)."',paginaWeb='".cv($obj->paginaWeb)."',recordar=".$obj->recordar." where idEvento=".$obj->idEvento;
			}
			if($con->ejecutarConsulta($consulta))
			{
				if($obj->idEvento=="-1")
					$obj->idEvento=$con->obtenerUltimoID();
				$query[$x]="delete from 4089_invitadosEvento where idEvento=".$obj->idEvento;
				$x++;
				
				foreach($obj->usuariosInvitados as $objUsuario)
				{
					$query[$x]="insert into 4089_invitadosEvento(idUsuario,idEvento,tipoRelacion,confirmado)values(".$objUsuario->idUsuario.",".$obj->idEvento.",".$objUsuario->tipoRelacion.",0) ";
					$x++;
				}
				$query[$x]="commit";
				$x++;
				if($con->ejecutarBloque($query))
					echo "1|".$obj->idEvento;	
				else
					echo "|";
			}
		}
		else
			echo "|";
	}
	
	function eliminarEvento()
	{
		global $con;
		$idEvento=$_POST["idEvento"];
		$consulta="delete from 4089_eventos where idEvento=".$idEvento;
		eC($consulta);
	}
	
	function obtenerListadoCalendarios()
	{
		global $con;
		$bandera="-1";
		if(isset($_POST["bandera"]))
			$bandera=$_POST["bandera"];
		
		$consulta="select idTipoEventos,nombreTipoEvento from 4089_tiposEvento where idTipoEventos not in (".$bandera.") order by nombreTipoEvento";
		$res=$con->obtenerFilas($consulta);
		$arrCalendarios="";
		while($fila=mysql_fetch_row($res))
		{
			$obj='	{
						"id":"'.$fila[0].'",
						"title":"'.uEJ($fila[1]).'"
					}';
					
			if($arrCalendarios=="")
				$arrCalendarios=$obj;
			else
				$arrCalendarios.=",".$obj;
		}
		echo '	{
                        "calendarios":	['.$arrCalendarios.']
            	}';
	}
	
	function obtenerListadoEventos()
	{
		global $con;
		$fechaInicio=$_POST["start"];
		$fechaFin=$_POST["end"];
		
		$dFecha=explode("-",$fechaInicio);
		$fechaInicio=$dFecha[2]."-".$dFecha[0]."-".$dFecha[1];
		$dFecha=explode("-",$fechaFin);
		$fechaFin=$dFecha[2]."-".$dFecha[0]."-".$dFecha[1];
		
		$idUsuario=$_POST["idUsuario"];
		$listEventos="-1";
		$consulta="select idEvento from 4089_invitadosEvento where idUsuario=".$idUsuario;
		$listEventos=$con->obtenerListaValores($consulta);
		if($listEventos=="")
			$listEventos="-1";
		
		/*union
						(
							SELECT concat('p_',id__249_tablaDinamica) AS idEvento, (SELECT Curso FROM _246_tablaDinamica WHERE id__246_tablaDinamica=t.Curso) AS 'tituloEvento',responsable AS 'idUsuario',
							Fecha AS 'fechaInicio',horaInicio,Fecha AS 'FechaFinal',horaFinal,'0' AS 'todoDia',
							'1' AS 'tipoEvento' ,'' AS 'notas',(SELECT codigoUnidad FROM 817_organigrama WHERE idOrganigrama=t.Sede) AS lugar,'' AS 'paginaWeb','0' AS 'recordar'
							FROM _249_tablaDinamica t
						)*/			
			
		$consulta="(	select * from 4089_eventos where idUsuario=".$idUsuario." and ((fechaInicio>='".$fechaInicio."' and fechaInicio<='".$fechaFin."') or (fechaFinal>='".$fechaInicio."' and fechaFinal<='".$fechaFin."'))) union 
						(select * from 4089_eventos where idEvento in (".$listEventos.") and ((fechaInicio>='".$fechaInicio."' and fechaInicio<='".$fechaFin."') or (fechaFinal>='".$fechaInicio."' and fechaFinal<='".$fechaFin."')))
						
					";
		$res=$con->obtenerFilas($consulta);
		$arrEvento="";
		while($fila=mysql_fetch_row($res))
		{
			$todoDia='false';			
			if($fila[7]==1)
				$todoDia='true';	
				
			$rO="0";
			if(($fila[2]!=$idUsuario)||($fila[8]=='1'))
				$rO="1";	
			
			$tEvento=0;
			if(strpos($fila[0],"_")!==false)
				$tEvento=1;
			$obj='	{
						  "id": "'.$fila[0].'",
						  "cid": "'.$fila[8].'",
						  "title": "'.cv(uEJ($fila[1])).'",
						  "start": "'.$fila[3].' '.$fila[4].'",
						  "end": "'.$fila[5].' '.$fila[6].'",
						  "ad": '.$todoDia.',
						  "notes": "'.cv(uEJ($fila[9])).'",
						  "loc":"'.cv(uEJ($fila[10])).'",
						  "url":"'.cv(uEJ($fila[11])).'",
						  "rem":"'.cv(uEJ($fila[12])).'",
						  "rO":'.$rO.',
						  "tipoEvento":"'.$tEvento.'"
					  }';
			if($arrEvento=="")
				$arrEvento=$obj;
			else
				$arrEvento.=",".$obj;	
		}
		$consulta="SELECT idCiclo FROM 4526_ciclosEscolares WHERE situacion=1";
		$cicloActivo=$con->obtenerValor($consulta);
		$consulta="SELECT codigoRol FROM 807_usuariosVSRoles WHERE idUsuario=".$idUsuario;
		$listRoles=$con->obtenerListaValores($consulta);
		$arrRoles=explode(",",$listRoles);
		
		if(existeValor($arrRoles,"7_0")) //Alumno
		{
			$consulta="SELECT m.idMateria,idGrupo,m.nombreMateria FROM 4517_alumnosVsMateriaGrupo a,4502_Materias m,4520_grupos g WHERE m.idMateria=a.idMateria AND g.idGrupos=a.idGrupo and 
						idUsuario=".$idUsuario." AND g.situacion=1";	

			$resMaterias=$con->obtenerFilas($consulta);
			while($filaMat=mysql_fetch_row($resMaterias))
			{
				$idGrupo=$filaMat[1];
				if($idGrupo=="")
					$idGrupo="-10000";
				$consulta="SELECT * FROM 4530_sesiones WHERE idGrupo=".$filaMat[1]." and (fechaSesion>='".$fechaInicio."' and fechaSesion<='".$fechaFin."')";	

				$resSesiones=$con->obtenerFilas($consulta);
				while($filaS=mysql_fetch_row($resSesiones))
				{
					$todoDia="0";
					$tipoSesion="";
					
					$tipoSesion=$filaS[4];
					$horario=$filaS[3];
					$arrHorario=explode(",",$horario);
					foreach($arrHorario as $objHorario)
					{
						$h=explode(" - ",$objHorario);
						$obj='	{
								  "id": "'.$filaS[0].'",
								  "cid": "'.$tipoSesion.'",
								  "title": "Clase: '.cv(uEJ($filaMat[2])).'",
								  "start": "'.$filaS[2].' '.$h[0].'",
								  "end": "'.$filaS[2].' '.$h[1].'",
								  "ad": '.$todoDia.',
								  "notes": "",
								  "loc":"",
								  "url":"",
								  "rem":"",
								  "rO":"-1"
							  }';
						if($arrEvento=="")
							$arrEvento=$obj;
						else
							$arrEvento.=",".$obj;
					}
				}
			}
		}
		
		if(existeValor($arrRoles,"5_0")) //Profesor
		{
			
			$consulta="SELECT m.idMateria,idGrupo,m.nombreMateria FROM 4519_asignacionProfesorGrupo a,4502_Materias m,4520_grupos g 
						WHERE m.idMateria=g.idMateria AND g.idGrupos=a.idGrupo and a.idUsuario=".$idUsuario." AND a.situacion=1 and g.situacion=1";	

			$resMaterias=$con->obtenerFilas($consulta);
			while($filaMat=mysql_fetch_row($resMaterias))
			{
				$consulta="SELECT * FROM 4530_sesiones WHERE idGrupo=".$filaMat[1]." and (fechaSesion>='".$fechaInicio."' and fechaSesion<='".$fechaFin."')";	

				$resSesiones=$con->obtenerFilas($consulta);
				while($filaS=mysql_fetch_row($resSesiones))
				{
					$todoDia="0";
					$tipoSesion="";
					
					$tipoSesion=$filaS[4];
					$horario=$filaS[3];
					$arrHorario=explode(",",$horario);
					foreach($arrHorario as $objHorario)
					{
						$h=explode(" - ",$objHorario);
						$obj='	{
								  "id": "'.$filaS[0].'",
								  "cid": "'.$tipoSesion.'",
								  "title": "Clase: '.cv(uEJ($filaMat[2])).'",
								  "start": "'.$filaS[2].' '.$h[0].'",
								  "end": "'.$filaS[2].' '.$h[1].'",
								  "ad": '.$todoDia.',
								  "notes": "",
								  "loc":"",
								  "url":"",
								  "rem":"",
								  "rO":"-1"
							  }';
						if($arrEvento=="")
							$arrEvento=$obj;
						else
							$arrEvento.=",".$obj;
					}
				}
			}
			
		}
		echo  	'{
                    "evts": ['.$arrEvento.']
                }';
				
	}
	
	function modificarFechaHoraEvento()
	{
		global $con;
		$cadObj=$_POST["cadObj"];	
		$obj=json_decode($cadObj);
		$consulta="	update 4089_eventos set fechaInicio='".$obj->fechaInicio."',horaInicio='".$obj->horaInicio."',
						fechaFinal='".$obj->fechaFinal."',horaFinal='".$obj->horaFinal."' where idEvento=".$obj->idEvento;
		eC($consulta);						
	}
	
	function obtenerParticipantesEvento()
	{
		global $con;
		$idEvento=$_POST["idEvento"];
		$arrUsuarios="";
		if(strpos($idEvento,"_")===false)
		{
			$consulta="SELECT u.idUsuario,u.Nombre,e.tipoRelacion FROM 4089_invitadosEvento e,800_usuarios u WHERE u.idUsuario=e.idUsuario AND e.idEvento=".$idEvento." order by u.Nombre";
			$arrUsuarios=$con->obtenerFilasArreglo($consulta);
		}
		else
		{
			$arrEvento=explode("_",$idEvento);
			$idEvento=$arrEvento[1];
			$arrUsuarios="[]";
		}
		$consulta="SELECT COUNT(idEvento) FROM 4089_comentariosEvento WHERE idEvento='".$idEvento."'";
		$nComentarios=$con->obtenerValor($consulta);
		echo "1|".uEJ($arrUsuarios)."|".$nComentarios;
	}
	
	function obtenerUsuariosRol()
	{
		global $con;
		$rol=$_POST["rol"];
		$arrRol=explode("_",$rol);
		$consulta="SELECT u.idUsuario,u.Nombre FROM 807_usuariosVSRoles ur,800_usuarios u WHERE u.idUsuario=ur.idUsuario AND ur.idRol=".$arrRol[0];
		$arrRoles=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrRoles);
		
	}
	
	function guardarComentarioEvento()
	{
		global $con;
		$idEvento=$_POST["idEvento"];
		$comentario=$_POST["comentario"];		
		$consulta="INSERT INTO 4089_comentariosEvento(idEvento,comentario,fechaRegistro,horaRegistro,idUsuario)
					VALUES('".$idEvento."','".cv($comentario)."','".date("Y-m-d")."','".date("H:i")."',".$_SESSION["idUsr"].")";
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="select count(idEvento) from 4089_comentariosEvento where idEvento='".$idEvento."'";
			
			$nComentarios=$con->obtenerValor($consulta);
			echo "1|".$nComentarios;
		}
	}
	
	function obtenerTipoEventoAlmacen()
	{
		global $con;
		$noFun=$_POST["noFun"];
		switch($noFun)
		{
			case 1:
				$arrCalendarios='{"calendarios":[{"id":"1","title":"Pendientes"},{"id":"2","title":"Compromiso"}]}';
				echo $arrCalendarios;
			break;
			case 2:
				$arrCalendarios='{"calendarios":[{"id":"1","title":"Pendientes"},{"id":"2","title":"Compromiso"}]}';
				echo $arrCalendarios;
			break;
		}
	}
	
	function obtenerEventosAlmacen()
	{
		global $con;
		$idAlmacen=$_POST["idAlmacen"];
		$noFun=$_POST["noFun"];
		$arrEventos="";
		
		switch($noFun)
		{
			case 1:
			  $consulta="SELECT idPedido,folioPedido,fechaAgenda,horaInicio,horaFin,idProveedor_ult,txtRazonSocial2,fechaRecepcion FROM 9102_PedidoCabecera p, _405_tablaDinamica pr  WHERE id__405_tablaDinamica=idProveedor_ult AND idAlmacen=".$idAlmacen." AND status_pedido=1 and fechaAgenda is not null and fechaAgenda<>'' ORDER BY fechaAgenda ASC ";
			  $res=$con->obtenerFilas($consulta);
			  
			  while($fila=mysql_fetch_row($res))
			  {
				  if($fila[2]=="")
				  {

					  $diaCompleto=1;
					  $fecha=$fila[7];
					  $fila[3]="00:00:00";
					  $fila[4]="00:00:00";
				  }
				  else
				  {
					  $diaCompleto=0;
					  $fecha=$fila[2];
				  }
				  
				  $obj='{"id": "'.$fila[0].'","cid": "4","title": "Pendiente","start": "'.$fecha.' '.$fila[3].'","end": "'.$fecha.' '.$fila[4].'","ad": "'.$diaCompleto.'","notes": "","loc":"","url":"","rem":"","rO":"1"}';
				  
				  if($arrEventos=="")
					  $arrEventos=$obj;
				  else
					  $arrEventos.=",".$obj;
			  }
			break;
			case 2:
				$consulta="SELECT idEntrega,fecha,horaInicio,horaFin,estado FROM 9305_fechasEntregasAlmacen WHERE fecha is not null and fecha<>'' and idAlmacen=".$idAlmacen;
				$res=$con->obtenerFilas($consulta);
				
				while($fila=mysql_fetch_row($res))
				{
					if($fila[2]=="00:00:00")
					{
						continue;
						$diaCompleto=1;
						$fila[3]="00:00:00";
						$fila[4]="00:00:00";
					}
					else
					{
						$diaCompleto=0;
						$fecha=$fila[2];
					}
					
					$obj='{"id": "'.$fila[0].'","cid": "1","title": "Pendiente","start": "'.$fila[1].' '.$fila[2].'","end": "'.$fila[1].' '.$fila[3].'","ad": "'.$diaCompleto.'","notes": "","loc":"","url":"","rem":"","rO":"1"}';
					
					if($arrEventos=="")
						$arrEventos=$obj;
					else
						$arrEventos.=",".$obj;
			  }
			break;
		}
		//echo $consulta;
		echo '{"evts":['.$arrEventos.']}';
	}
	
	function obtenerTipoEventoProveedor()
	{
		global $con;
		$arrCalendarios='{"calendarios":[{"id":"1","title":"Pendientes"},{"id":"2","title":"Compromiso"}]}';
		echo $arrCalendarios;
	}
	
	function obtenerEventosProveedor()
	{
		global $con;
		
		$idProv=$_POST["idProv"];
		$arrEventos="";
		
		//$consulta="SELECT idPedido,folioPedido,fechaAgenda,horaInicio,horaFin,idProveedor_ult,txtRazonSocial2 FROM 9102_PedidoCabecera p, _405_tablaDinamica pr  WHERE id__405_tablaDinamica=idProveedor_ult AND idAlmacen=".$idAlmacen." AND status_pedido=1 AND fechaAgenda IS NOT NULL ORDER BY fechaAgenda ASC ";
//		$res=$con->obtenerFilas($consulta);
		
		$consulta="SELECT idPedido,folioPedido,fechaAgenda,horaInicio,horaFin,p.idAlmacen,nombreAlmacen,fechaRecepcion FROM 9102_PedidoCabecera p, 9030_almacenes a WHERE idProveedor_ult=".$idProv." AND p.idAlmacen=a.idAlmacen AND status_pedido=1 ORDER BY  fechaRecepcion ASC";
		//echo $consulta;
		$res=$con->obtenerFilas($consulta);	
		
		while($fila=mysql_fetch_row($res))
		{
			if($fila[2]=="")
			{
				$diaCompleto=1;
				$fecha=$fila[7];
			}
			else
			{
				$diaCompleto=0;
				$fecha=$fila[2];
			}
			
			$obj='{"id": "'.$fila[0].'","cid": "1","title": "Pendiente ","start": "'.$fecha.' '.$fila[3].'","end": "'.$fecha.' '.$fila[4].'","ad": "'.$diaCompleto.'","notes": "","loc":"","url":"","rem":"","rO":"1"}';
			
			if($arrEventos=="")
				$arrEventos=$obj;
			else
				$arrEventos.=",".$obj;
		}
		echo '{"evts":['.$arrEventos.']}';
	}
	
	function obtenerCalendariosHorario()
	{
		echo '	{
                        "calendarios":	[
											{
												"id":"1",
												"title":"Horario asignado a materia"
											},
											{
												"id":"2",
												"title":"Horario disponible del candidato"
											},
											{
												"id":"3",
												"title":"Horario NO disponible del candidato"
											},
											{
												"id":"4",
												"title":"Horario ocupado por el grupo"
											},
											{
												"id":"5",
												"title":"Horario grupo compartido"
											},
											{
												"id":"6",
												"title":"Horario grupo compartido"
											}
										]
            	}';
	}
	
	function obtenerListadoHorario()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$rO=$_POST["rO"];

		$arrFechas[0]="2011-06-05";
		$arrFechas[1]="2011-06-06";
		$arrFechas[2]="2011-06-07";
		$arrFechas[3]="2011-06-08";
		$arrFechas[4]="2011-06-09";
		$arrFechas[5]="2011-06-10";
		$arrFechas[6]="2011-06-11";
		
		$listEventos="-1";
		$consulta="SELECT idHorarioDisponible,idDiaSemana,horaInicio,horaFin from 4065_disponibilidadHorario where idFormulario=".$idFormulario." and idReferencia= ".$idReferencia;
		
		$res=$con->obtenerFilas($consulta);
		$arrEvento="";
		while($fila=mysql_fetch_row($res))
		{
			$btnEliminar="";
			if($rO=="0")
				$btnEliminar="<a href=\'javascript:removerBloque(\\\"".bE($fila[0])."\\\")\'><img src=\'../images/delete.png\' title=\'Remover bloque\' alt=\'Remover bloque\'/></a>";
			$todoDia='false';	
			$fechaIni=$arrFechas[$fila[1]];	
			$tEvento=0;
			if(strpos($fila[0],"_")!==false)
				$tEvento=1;
			$obj='	{
						  "id": "'.$fila[0].'",
						  "cid": "1",
						  "title": "Disponible '.$btnEliminar.'",
						  "start": "'.$fechaIni.' '.$fila[2].'",
						  "end": "'.$fechaIni.' '.$fila[3].'",
						  "ad": '.$todoDia.',
						  "rO":'.$rO.'
					  }';
			if($arrEvento=="")
				$arrEvento=$obj;
			else
				$arrEvento.=",".$obj;	
		}

		echo '{"evts":['.$arrEvento.']}';
	}
	
	function guardarHorario()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$idFormulario=$obj->idFormulario;
		$idReferencia=$obj->idReferencia;
		$fechaInicio=strtotime($obj->fechaInicio);
		$fechaFin=strtotime($obj->fechaFin);
		$ciclo=$obj->ciclo;
		$idPeriodo="-1";
		if(isset($obj->idPeriodo))
			$idPeriodo=$obj->idPeriodo;
		$idDiaSemana=date("N",$fechaInicio);
		if($idDiaSemana==7)
			$idDiaSemana=0;
		$consulta="select horaInicio,horaFin from 4065_disponibilidadHorario where idReferencia=".$idReferencia." and idFormulario=".$idFormulario." and idDiaSemana=".$idDiaSemana;
		$resHorario=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resHorario))
		{
			if(colisionaTiempo(date("H:i",$fechaInicio),date("H:i",$fechaFin),$fila[0],$fila[1]))
			{
				echo "<br><b>El intervalo de tiempo que desea agregar colisiona con otro intervalo de tiempo ingresado anteriormente</b>";
				return;
			}	
		}
		$idUsuario="";			
		if($con->existeTabla("_".$idFormulario."_tablaDinamica"))
		{
			$consulta="select responsable from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idReferencia;
			$idUsuario=$con->obtenerValor($consulta);
		}
		if($idUsuario=="")
			$idUsuario=$_SESSION["idUsr"];
		$consulta="insert into 4065_disponibilidadHorario(ciclo,idUsuario,idDiaSemana,horaInicio,horaFin,tipo,idFormulario,idReferencia,idPeriodo)
					VALUES(".$ciclo.",".$idUsuario.",".$idDiaSemana.",'".date("H:i",$fechaInicio)."','".date("H:i",$fechaFin)."',1,".$idFormulario.",".$idReferencia.",".$idPeriodo.")";
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|".$con->obtenerUltimoID();
		}
	}
	
	function modificarHorario()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$idFormulario=$obj->idFormulario;
		$idReferencia=$obj->idReferencia;
		$fechaInicio=strtotime($obj->fechaInicio);
		$fechaFin=strtotime($obj->fechaFin);
		
		$idDiaSemana=date("N",$fechaInicio);
		if($idDiaSemana==7)
			$idDiaSemana=0;
		$consulta="select horaInicio,horaFin from 4065_disponibilidadHorario where idReferencia=".$idReferencia." and idFormulario=".$idFormulario." and idDiaSemana=".$idDiaSemana." and idHorarioDisponible<>".$obj->idRegistro;
		$resHorario=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resHorario))
		{
			if(colisionaTiempo(date("H:i",$fechaInicio),date("H:i",$fechaFin),$fila[0],$fila[1]))
			{
				echo "<br><b>El intervalo de tiempo deseado colisiona con otro intervalo de tiempo ingresado anteriormente</b>";
				return;
			}	
		}
		$consulta="update 4065_disponibilidadHorario set idDiaSemana=".$idDiaSemana.",horaInicio='".date("H:i",$fechaInicio)."',horaFin='".date("H:i",$fechaFin)."' where idHorarioDisponible=".$obj->idRegistro;
		eC($consulta);
	}
	
	function eliminarHorario()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$consulta="delete from 4065_disponibilidadHorario where idHorarioDisponible=".$idRegistro;
		eC($consulta);
	}
	
	function obtenerHorarioMateria()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$ciclo=$_POST["ciclo"];
		$rO=$_POST["rO"];
		$fechaActual=date("Y-m-d");
		$arrFechas[0]="2011-06-05";
		$arrFechas[1]="2011-06-06";
		$arrFechas[2]="2011-06-07";
		$arrFechas[3]="2011-06-08";
		$arrFechas[4]="2011-06-09";
		$arrFechas[5]="2011-06-10";
		$arrFechas[6]="2011-06-11";
		$consulta="select g.fechaInicio,g.fechaFin,idInstanciaPlanEstudio,idGradoCiclo from 4520_grupos g where g.idGrupos=".$idGrupo;
		$filaFechas=$con->obtenerPrimeraFila($consulta);
		
		
		$consulta="SELECT idGrado FROM 4546_estructuraPeriodo WHERE idEstructuraPeriodo=".$filaFechas[3];
		
		$idGrado=$con->obtenerValor($consulta);
		
		if($idGrado=="")
			$idGrado=-1;
			
		$consulta="SELECT idPerfil FROM 4628_perfilHorarioGrado WHERE idInstanciaPlan=".$filaFechas[2]." AND idGrado=".$idGrado;
		$idPerfil=	$con->obtenerValor($consulta);
		
		if($idPerfil=="")
			$idPerfil=-1;	
		
		$consulta="SELECT MIN(fechaInicio) FROM 4522_horarioGrupo WHERE idGrupo=".$idGrupo;
		$fechaInicioH=$con->obtenerValor($consulta);
		$consulta="SELECT idHorarioGrupo,dia,horaInicio,horaFin,idAula FROM 4522_horarioGrupo WHERE idGrupo=".$idGrupo;
		if($fechaInicioH!="")
		{
			$fechaInicioH=strtotime($fechaInicioH);
			if($fechaInicioH<=strtotime(date("Y-m-d")))
			{
				$fechaInicioH=strtotime(date("Y-m-d"));
				$consulta="SELECT max(fechaFin) FROM 4522_horarioGrupo WHERE idGrupo=".$idGrupo;
				
				$fecha=$con->obtenerValor($consulta);
				$fechaH=strtotime($fecha);
				if($fechaH<strtotime(date("Y-m-d")))
					$consulta="SELECT idHorarioGrupo,dia,horaInicio,horaFin,idAula FROM 4522_horarioGrupo WHERE idGrupo=".$idGrupo." and fechaFin='".date("Y-m-d",$fechaH)."' and fechaInicio<=fechaFin";
				else
					$consulta="SELECT idHorarioGrupo,dia,horaInicio,horaFin,idAula FROM 4522_horarioGrupo WHERE idGrupo=".$idGrupo." and '".$fechaActual."'>=fechaInicio and '".$fechaActual."'<=fechaFin";
			}
			else
			{
				$consulta="SELECT idHorarioGrupo,dia,horaInicio,horaFin,idAula FROM 4522_horarioGrupo WHERE idGrupo=".$idGrupo." and fechaInicio='".date("Y-m-d",$fechaInicioH)."' and fechaInicio<=fechaFin";
			}
		}


		$listHorarioGrupo="";
		$res=$con->obtenerFilas($consulta);
		$arrEvento="";
		
		$consulta="SELECT dia,horaInicial,horaFinal,idCategoriaMateria,idRegistro FROM  4627_horariosPerfilMateria WHERE idPerfil=".$idPerfil;
		$resHorario=$con->obtenerFilas($consulta);
		while($fHorario=mysql_fetch_row($resHorario))
		{
			$consulta="SELECT nombreCategoria,colorLetra FROM 4502_categoriaMaterias WHERE idCategoria=".$fHorario[3];
			$fCategoria=$con->obtenerPrimeraFila($consulta);
			$nombreCategoria=$fCategoria[0];
			
			
			$fechaIni=$arrFechas[$fHorario[0]];	
		
			$obj='	{
						"id": "perfilHorario_'.$fHorario[4].'",
						"cid": "'.$fHorario[3].'0000",
						"title": " ",
						"start": "'.$fechaIni.' '.$fHorario[1].'",
						"end": "'.$fechaIni.' '.$fHorario[2].'",
						"ad": "0",
						"rO":"1",
						"notes":"-1"
					}';
						   
		  	if($arrEvento=="")
				$arrEvento=$obj;
		  	else
			  	$arrEvento.=",".$obj;
		
		}
		
		
		while($fila=mysql_fetch_row($res))
		{
			if($listHorarioGrupo=="")
				$listHorarioGrupo=$fila[0];
			else
				$listHorarioGrupo.=",".$fila[0];
			$btnEliminar="";
			if($rO=="0")
				$btnEliminar="<a href=\'javascript:removerBloque(\\\"".bE($fila[0])."\\\")\'><img src=\'../images/delete.png\' title=\'Remover bloque\' alt=\'Remover bloque\'/></a>";
			$todoDia='false';	
			$fechaIni=$arrFechas[$fila[1]];	
			$tEvento=0;
			if(strpos($fila[0],"_")!==false)
				$tEvento=1;
			$comp="";
			
			$consulta="SELECT nombreArea FROM 9309_ubicacionesFisicas WHERE idAreaFisica=".$fila[4];
			$nAula=$con->obtenerValor($consulta);
			if($nAula=="")
				$nAula="No especificado";
			$cadObj='{"idAula":"'.$fila[4].'","esMateriaAsignada":"1"}';
			if($fila[4]==-1)
				$comp="<img src='../images/exclamation.png' title='Esta sesi&oacute;n de clases no tiene asignada una aula' alt='Esta sesi&oacute;n de clases no tiene asignada una aula'>&nbsp;";
			$obj='	{
						  "id": "'.$fila[0].'",
						  "cid": "1",
						  "title": "Asignado '.$comp.' '.$btnEliminar.'<br>Lugar: '.$nAula.'",
						  "objComp":"'.bE($cadObj).'",
						  "start": "'.$fechaIni.' '.$fila[2].'",
						  "end": "'.$fechaIni.' '.$fila[3].'",
						  "ad": '.$todoDia.',
						  "rO":'.$rO.',
						  "notes":"'.$fila[4].'"
					  }';
			if($arrEvento=="")
				$arrEvento=$obj;
			else
				$arrEvento.=",".$obj;	
		}
		
		/*$consulta="SELECT idHorarioGrupo,dia,horaInicio,horaFin,idAula,fechaInicio,fechaFin FROM 4522_horarioGrupo WHERE idGrupo=".$idGrupo." and fechaInicio>='".date("Y-m-d",$fechaInicioH)."' and fechaInicio<fechaFin and idHorarioGrupo not in(".$listHorarioGrupo.")";

		$res=$con->obtenerFilas($consulta);

		while($fila=mysql_fetch_row($res))
		{
			$fechaIni=$arrFechas[$fila[1]];	
			$consulta="SELECT nombreArea FROM 9309_ubicacionesFisicas WHERE idAreaFisica=".$fila[4];
			$nAula=$con->obtenerValor($consulta);
			if($nAula=="")
				$nAula="No especificado";
			$obj='	{
						  "id": "'.$fila[0].'",
						  "cid": "7",
						  "title": "<br>(Del '.date("d/m/Y",strtotime($fila[5])).' al '.date("d/m/Y",strtotime($fila[6])).')<br>Lugar: '.$nAula.'",
						  "objComp":"",
						  "start": "'.$fechaIni.' '.$fila[2].'",
						  "end": "'.$fechaIni.' '.$fila[3].'",
						  "ad": false,
						  "rO":1,
						  "notes":"'.$fila[4].'"
					  }';
			if($arrEvento=="")
				$arrEvento=$obj;
			else
				$arrEvento.=",".$obj;
		}*/
		$consulta="SELECT idUsuario FROM 4517_alumnosVsMateriaGrupo WHERE idGrupo=".$idGrupo;
		$listAlumnos=$con->obtenerListaValores($consulta);
		if($listAlumnos=="")
			$listAlumnos="-1";
			
		$consulta="SELECT DISTINCT a.idGrupo,g.fechaInicio,g.fechaFin FROM 4517_alumnosVsMateriaGrupo a,4520_grupos g WHERE a.idUsuario IN (".$listAlumnos.") AND g.idGrupos=a.idGrupo and  g.idGrupos<>".$idGrupo."
					AND  ((g.fechaInicio<='".$filaFechas[0]."' AND g.fechaFin>='".$filaFechas[0]."')||(g.fechaInicio<='".$filaFechas[1]."' AND g.fechaFin>='".$filaFechas[1]."')||(g.fechaInicio>='".$filaFechas[0]."' AND g.fechaFin<='".$filaFechas[1]."'))";
		$arrHorarioGpo=array();
		$resGrupos=$con->obtenerFilas($consulta);
		while($fGpo=mysql_fetch_row($resGrupos))
		{
			$consulta="SELECT dia,horaInicio,horaFin FROM 4522_horarioGrupo WHERE idGrupo=".$fGpo[0]." and '".$fechaActual."'>=fechaInicio and '".$fechaActual."'<=fechaFin";
			$resFilas=$con->obtenerFilas($consulta);
			while($fDia=mysql_fetch_row($resFilas))
			{
				if(!isset($arrHorarioGpo[$fDia[0]]))
					$arrHorarioGpo[$fDia[0]]=array();
				$objAux[0]=$fDia[1];
				$objAux[1]=$fDia[2];
				array_push($arrHorarioGpo[$fDia[0]],$objAux);					
			}
		}
		
		$ct=0;
		foreach($arrHorarioGpo as $dia =>$h)
		{
			$horario=organizarBloquesHorario($h);
			foreach($horario as $h)
			{
				$fechaIni=$arrFechas[$dia];	
				$todoDia='false';
				$obj='	{
							  "id": "gpo_'.$ct.'",
							  "cid": "4",
							  "title": "Ocupado por el grupo",
							  "start": "'.$fechaIni.' '.$h[0].'",
							  "end": "'.$fechaIni.' '.$h[1].'",
							  "ad": '.$todoDia.',
							  "rO":"1",
							  "notes":"-1"
						  }';
				if($arrEvento=="")
					$arrEvento=$obj;
				else
					$arrEvento.=",".$obj;	
				$ct++;
			}
		}
		
		/*$consulta="SELECT idUsuario FROM 4519_asignacionProfesorGrupo WHERE idGrupo=".$idGrupo." and participacionPrincipal=1 and situacion in (1,5)";
		$idUsuario=$con->obtenerValor($consulta);                   
		if($idUsuario!="")
		{
			$arrHorarioGpo=array();
			$arrHorario=array();
			$minHoraDia=strtotime("23:59:00");
			$minHora=strtotime("23:59:00");
			$maxHoraDia=strtotime("00:00:00");
			$consulta="SELECT idDiaSemana,horaInicio,horaFin FROM 4065_disponibilidadHorario d, 4526_ciclosEscolares c 
					WHERE d.ciclo=c.idCiclo AND  tipo=1  AND idUsuario=".$idUsuario." AND 
					((c.fechaInicio<='".$filaFechas[0]."' AND c.fechaTermino>='".$filaFechas[0]."')||(c.fechaInicio<='".$filaFechas[1]."' AND c.fechaTermino>='".$filaFechas[1]."')||
					(c.fechaInicio>='".$filaFechas[0]."' AND c.fechaTermino<='".$filaFechas[1]."')) order by idDiaSemana,horaInicio";
					$resFilas=$con->obtenerFilas($consulta);
					
					$arrHorarioProf=array();
					while($fila=mysql_fetch_row($resFilas))
					{
						$obj=array();
						if(!isset($arrHorarioProf[$fila[0]]))
							$arrHorarioProf[$fila[0]]=array();
						$obj[0]=$fila[1];
						$obj[1]=$fila[2];
						array_push($arrHorarioProf[$fila[0]],$obj);
					}
					
					foreach($arrHorarioProf as $h=>$resto)
					{
						$arrHorarioProf[$h]=organizarBloquesHorario($resto);
					}
					
					$arrCtDia=array();
					foreach($arrHorarioProf as $dia=>$resto)
					{
						foreach($resto as $fHora)
						{
							$filaHora[0]=$dia;
							$filaHora[1]=$fHora[0];
							$filaHora[2]=$fHora[1];
					
							$hora[0]=$filaHora[1];
							$hora[1]=$filaHora[2];
							$hI=strtotime($hora[0]);
							$hF=strtotime($hora[1]);
							$minHora=$hI;
							if($minHoraDia>$hI)
							{
								$minHoraDia=$hI;
								
							}
							if($maxHoraDia<$hF)
								$maxHoraDia=$hF;
							
							$d=$filaHora[0];
							if($d==7)
								$d=0;
							$consulta="SELECT h.dia,h.horaInicio,h.horaFin,g.idGrupos FROM 4519_asignacionProfesorGrupo a,4520_grupos g,4522_horarioGrupo h 
									WHERE g.idGrupos=a.idGrupo AND h.idGrupo=a.idGrupo AND idUsuario=".$idUsuario." AND participacionPrincipal=1 AND a.situacion=1 AND g.idGrupos<>".$idGrupo." and
									((g.fechaInicio<='".$filaFechas[0]."' AND g.fechaFin>='".$filaFechas[0]."')||(g.fechaInicio<='".$filaFechas[1]."' AND g.fechaFin>='".$filaFechas[1]."')||(g.fechaInicio>='".$filaFechas[0]."' AND g.fechaFin<='".$filaFechas[1]."'))
									 and  h.dia=".$filaHora[0]." and horaInicio>='".$hora[0]."' and horaFin<='".$hora[1]."' order by horaInicio";
	
							$resOcupa=$con->obtenerFilas($consulta);			
							if(!isset($arrCtDia[$filaHora[0]]))
								$arrCtDia[$filaHora[0]]=0;
							$tieneClase=false;
							while($fOcupa=mysql_fetch_row($resOcupa))
							{
								$tieneClase=true;
								if($minHora==strtotime($fOcupa[1]))
								{
									$hora[0]=$fOcupa[1];
									$hora[1]=$fOcupa[2];
									$duracion=strtotime("00:00:00")+strtotime($fOcupa[2])-strtotime($fOcupa[1]);
									$hora[2]=(date("H",$duracion)*60)+date("i",$duracion);
									$hora[3]=1;
									$hora[4]=$fOcupa[3];
									$hora[5]="";
									$hora[6]="";
									if(!isset($arrHorario[$d]))
										$arrHorario[$d]=array();
									array_push($arrHorario[$d],$hora);
									$minHora=strtotime($fOcupa[2]);
				
								}
								else
								{
									if($arrCtDia[$filaHora[0]]==0)
										$hora[0]=date("H:i",$minHoraDia);
									else
										$hora[0]=date("H:i",$minHora);											
									$hora[1]=$fOcupa[1];
									$duracion=strtotime("00:00:00")+strtotime($fOcupa[1])-strtotime($hora[0]);
									$hora[2]=(date("H",$duracion)*60)+date("i",$duracion);
									$hora[3]=0;
									if(!isset($arrHorario[$d]))
										$arrHorario[$d]=array();
									array_push($arrHorario[$d],$hora);
									$hora[0]=$fOcupa[1];
									$hora[1]=$fOcupa[2];
									$duracion=strtotime("00:00:00")+strtotime($fOcupa[2])-strtotime($fOcupa[1]);
									$hora[2]=(date("H",$duracion)*60)+date("i",$duracion);
									$hora[3]=1;
									$hora[4]=$fOcupa[3];
									$hora[5]="";
									$hora[6]="";
									array_push($arrHorario[$d],$hora);
									$minHora=strtotime($fOcupa[2]);
								}
								$arrCtDia[$filaHora[0]]++;
							}
							if(!$tieneClase)
								$minHora=$hI;
							if($minHora<$hF)
							{
								$duracion=strtotime("00:00:00")+$hF-$minHora;
								$hora[0]=date("H:i",$minHora);
								$hora[1]=date("H:i",$hF);
								$hora[2]=(date("H",$duracion)*60)+date("i",$duracion);
								$hora[3]=0;
								$hora[4]="";
								$hora[5]="";
								$hora[6]="";
								if(!isset($arrHorario[$d]))
									$arrHorario[$d]=array();
								array_push($arrHorario[$d],$hora);
								$minHora=$hF;
								$arrCtDia[$filaHora[0]]++;
							
							}
						}
					}
						
						
					$ct=0;
					foreach($arrHorario as $dia =>$h)
					{
						$horario=$h;
						foreach($horario as $h)
						{
							if($h[3]==0)
							{
								$fechaIni=$arrFechas[$dia];	
								$todoDia='false';
								$obj='	{
											  "id": "disp_'.$ct.'",
											  "cid": "2",
											  "title": "Disponible candidato",
											  "start": "'.$fechaIni.' '.$h[0].'",
											  "end": "'.$fechaIni.' '.$h[1].'",
											  "ad": '.$todoDia.',
											  "rO":"3",
											  "notes":"-1"
										  }';
														  
								
							}
							else
							{
								$consulta="SELECT nombreGrupo,nombreMateria FROM 4520_grupos g,4502_Materias m WHERE m.idMateria=g.idMateria AND idGrupos=".$h[4];
								$filaM=$con->obtenerPrimeraFila($consulta);	
								$fechaIni=$arrFechas[$dia];	
								$todoDia='false';
								$obj='	{
											  "id": "clase_'.$ct.'",
											  "cid": "3",
											  "title": "Clase: '.$filaM[1].' ('.$filaM[0].')",
											  "start": "'.$fechaIni.' '.$h[0].'",
											  "end": "'.$fechaIni.' '.$h[1].'",
											  "ad": '.$todoDia.',
											  "rO":"0",
											  "notes":"-1"
										  }';
							}
							if($arrEvento=="")
								  $arrEvento=$obj;
							  else
								  $arrEvento.=",".$obj;	
							  $ct++;	
							
							
						}
					}
		
		}*/
		
		$consulta="SELECT * FROM _476_gridRecesos WHERE idReferencia IN (
					SELECT idReferencia FROM _476_gridPlanesEstudio WHERE idInstanciaPlanEstudio=".$filaFechas[2].")";
					
		$resRecesos=$con->obtenerFilas($consulta);
		while($fReceso=mysql_fetch_row($resRecesos))
		{
			foreach($arrFechas as $fechaIni)
			{
				$obj='	{
							  "id": "receso_'.$fReceso[0].'",
							  "cid": "19",
							  "title": "'.cv($fReceso[2]).'",
							  "start": "'.$fechaIni.' '.$fReceso[3].'",
							  "end": "'.$fechaIni.' '.$fReceso[4].'",
							  "ad": "0",
							  "rO":"1",
							  "notes":"-1"
						  }';
						   
				if($arrEvento=="")
					$arrEvento=$obj;
				else
					$arrEvento.=",".$obj;
			}
		}
		
		
		
		
		$comp=obtenerAgendaGrupoCompatible($idGrupo);

		if($comp!="")
		{
			if($arrEvento=="")
				$arrEvento=$comp;
			else
				$arrEvento.=",".$comp;
		}
		
		echo '{"idPerfilHorario":"'.$idPerfil.'","evts":['.$arrEvento.']}';
	}
	
	function guardarHorarioGrupo()
	{
		global $con;
		global $arrFechasHorario;
		global $arrDiasSemana;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$idMateria=$obj->idMateria;
		$idGrupo=$obj->idGrupo;
		$fechaInicio=strtotime($obj->fechaInicio);
		$fechaFin=strtotime($obj->fechaFin);
		$idDiaSemana=date("N",$fechaInicio);
		$consulta="SELECT idGrupoPadre,fechaInicio,fechaFin FROM 4520_grupos WHERE idGrupos=".$idGrupo;
		$fGrupo=$con->obtenerPrimeraFila($consulta);
		$ciclo=$obj->ciclo;
		if($idDiaSemana==7)
			$idDiaSemana=0;
		if($con->cT())
		{
			if($obj->validar==1)
			{
				$idGrupoPadre=$fGrupo[0];
				$resValidacion=funcValidarHorarioMateriaCursoExtendido(date("H:i",$fechaInicio),date("H:i",$fechaFin),$idDiaSemana,$idGrupo,$ciclo,"-1",$obj->idMateria);
				$aValidacion=explode("|",$resValidacion);
				if($obj->idAula!=-1)
				{
					
					$res=validarModificacionHorarioAulaExtendido($obj->idAula,date("H:i",$fechaInicio),date("H:i",$fechaFin),$idDiaSemana,$ciclo,$obj->idMateria,$idGrupo);
					$resAula=explode("|",$res);
					if($resAula[0]==3)
					{
						$arrCasos="['12','0','El aula asignada ya se encuentra ocupada por otras materias en el horario indicado','".$resAula[1]."']";
						if($aValidacion[1]!="")
						{
							$cadValidacion=$aValidacion[1];
							$cadValidacion=substr($cadValidacion,0,strlen($cadValidacion)-2);
							$cadValidacion.=",".$arrCasos.']}';
							$aValidacion[1]=$cadValidacion;
						}
						else
						{
							$aValidacion[0]=2;
							$aValidacion[1]='{"permiteContinuar":"0","arrCasos":['.$arrCasos.']}';
							
						}
					}
				}
				
				if($idGrupoPadre!="")
				{
					$arrCasos="";
					$consulta="SELECT idGrupos,situacion FROM 4520_grupos WHERE idGrupoPadre=".$idGrupoPadre." AND idGrupos<>".$idGrupo." 
								and ((fechaInicio<='".$fGrupo[1]."' and fechaFin>='".$fGrupo[2]."') or 
									 (fechaInicio>='".$fGrupo[1]."' and fechaInicio<='".$fGrupo[2]."') or 
									 (fechaFin>='".$fGrupo[1]."' and fechaFin<='".$fGrupo[2]."'))";

					$resGrupos=$con->obtenerFilas($consulta);
					while($fGrupoAux=mysql_fetch_row($resGrupos))
					{
						$comp="";
						$idGrupoComp=$fGrupoAux[0];
						if($fGrupoAux[1]==2)
						{
							$consulta="SELECT idGrupo FROM 4539_gruposCompartidos WHERE idGrupoReemplaza=".$idGrupoComp;

							$idGrupoComp=$con->obtenerValor($consulta);
							$comp="compartida ";
						}
						$consulta="SELECT idGrupo,horaInicio,horaFin,fechaInicio,fechaFin FROM 4522_horarioGrupo WHERE idGrupo =".$idGrupoComp." AND dia=".$idDiaSemana." for update";
						$resHoras=$con->obtenerFilas($consulta);
						while($fHorario=mysql_fetch_row($resHoras))
						{
							
							if(colisionaTiempo($obj->fechaInicio,$obj->fechaFin,$arrFechasHorario[$idDiaSemana]." ".$fHorario[1],$arrFechasHorario[$idDiaSemana]." ".$fHorario[2]))
							{
								
								$nMateria=obtenerNombreCurso($fHorario[0]);	
								if($arrCasos=="")
									$arrCasos="['13','0','El grupo presenta problemas de horario con la materia ".$comp."<b>".$nMateria."</b> el día <b>".utf8_encode($arrDiasSemana[$idDiaSemana])."</b> de ".date("H:i",strtotime($fHorario[1]))." a ".date("H:i",strtotime($fHorario[2]))."']";
								else
									$arrCasos.=",['13','0','El grupo presenta problemas de horario con la materia ".$comp."<b>".$nMateria."</b> el día <b>".utf8_encode($arrDiasSemana[$idDiaSemana])."</b> de ".date("H:i",strtotime($fHorario[1]))." a ".date("H:i",strtotime($fHorario[2]))."']";
							}
						}
					}
					if($arrCasos!="")
					{
						if($aValidacion[1]!="")
						{
							$cadValidacion=$aValidacion[1];
							$cadValidacion=substr($cadValidacion,0,strlen($cadValidacion)-2);
							$cadValidacion.=",".$arrCasos.']}';
							$aValidacion[1]=$cadValidacion;
						}
						else
						{
							$aValidacion[0]=2;
							$aValidacion[1]='{"permiteContinuar":"0","arrCasos":['.$arrCasos.']}';
							
						}
					}
					
				}
				if($aValidacion[0]!=1)
				{
					echo "2|".$aValidacion[1];
					return;
				}
				
			}
			$consulta="INSERT INTO  4522_horarioGrupo(idGrupo,dia,horaInicio,horaFin,idAula,fechaInicio,fechaFin) VALUES
					(".$idGrupo.",".$idDiaSemana.",'".date("H:i",$fechaInicio)."','".date("H:i",$fechaFin)."',".$obj->idAula.",'".$fGrupo[1]."','".$fGrupo[2]."')";
			if($con->ejecutarConsulta($consulta)&&($con->fT())&&(ajustarFechaFinalCurso($idGrupo)))
			{
				echo "1|".$con->obtenerUltimoID();
			}
		}
	}
	
	function modificarHorarioGrupo()
	{
		global $con;
		global $arrFechasHorario;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$fechaInicio=strtotime($obj->fechaInicio);
		$fechaFin=strtotime($obj->fechaFin);
		$idRegistro=$obj->idRegistro;
		$ciclo=$obj->ciclo;
		$idDiaSemana=date("N",$fechaInicio);
		if($idDiaSemana==7)
			$idDiaSemana=0;

		if($con->cT())
		{
			$consulta="select idGrupo from 4522_horarioGrupo where idHorarioGrupo=".$idRegistro;
			$filaReg=$con->obtenerPrimeraFila($consulta);
			$idGrupo=$filaReg[0];
			if($obj->validar==1)
			{
				
				$consulta="SELECT idGrupoPadre,fechaInicio,fechaFin FROM 4520_grupos WHERE idGrupos=".$idGrupo;
				$fGrupo=$con->obtenerPrimeraFila($consulta);
				$idGrupoPadre=$fGrupo[0];
				
				
				$resValidacion=funcValidarHorarioMateriaCursoExtendido(date("H:i",$fechaInicio),date("H:i",$fechaFin),$idDiaSemana,$filaReg[0],$ciclo,$idRegistro,$obj->idMateria);
				$aValidacion=explode("|",$resValidacion);
				if($obj->idAula!=-1)
				{
					
					$res=validarModificacionHorarioAulaExtendido($obj->idAula,date("H:i",$fechaInicio),date("H:i",$fechaFin),$idDiaSemana,$ciclo,$obj->idMateria,$filaReg[0],$idRegistro);
					$resAula=explode("|",$res);
					if($resAula[0]==3)
					{
						$arrCasos="['12','1','El aula asignada ya se encuentra ocupada por otras materias en el horario indicado','".$resAula[1]."']";
						if($aValidacion[1]!="")
						{
							$cadValidacion=$aValidacion[1];
							$cadValidacion=substr($cadValidacion,0,strlen($cadValidacion)-2);
							$cadValidacion.=",".$arrCasos.']}';
							$aValidacion[1]=$cadValidacion;
						}
						else
						{
							$aValidacion[0]=2;
							$aValidacion[1]='{"permiteContinuar":"0","arrCasos":['.$arrCasos.']}';
							
						}
					}
				}
				
				if($idGrupoPadre!="")
				{
					$consulta="SELECT idGrupos FROM 4520_grupos WHERE idGrupoPadre=".$idGrupoPadre." AND idGrupos<>".$idGrupo." 
								and ((fechaInicio<='".$fGrupo[1]."' and fechaFin>='".$fGrupo[2]."') or 
									 (fechaInicio>='".$fGrupo[1]."' and fechaInicio<='".$fGrupo[2]."') or 
									 (fechaFin>='".$fGrupo[1]."' and fechaFin<='".$fGrupo[2]."'))";

					$listGrupos=$con->obtenerListaValores($consulta);
					$arrCasos="";
					if($listGrupos!="")
					{
						$consulta="SELECT idGrupo,horaInicio,horaFin FROM 4522_horarioGrupo WHERE idGrupo IN (".$listGrupos.") AND dia=".$idDiaSemana." for update";
						$resHoras=$con->obtenerFilas($consulta);
						while($fHorario=mysql_fetch_row($resHoras))
						{
							
							if(colisionaTiempo($obj->fechaInicio,$obj->fechaFin,$arrFechasHorario[$idDiaSemana]." ".$fHorario[1],$arrFechasHorario[$idDiaSemana]." ".$fHorario[2]))
							{
								
								$nMateria=obtenerNombreCurso($fHorario[0],true);	
								if($arrCasos=="")
									$arrCasos="['13','0','El grupo presenta problemas de horario con la materia <b>".$nMateria."</b> de ".date("H:i",strtotime($fHorario[1]))." a ".date("H:i",strtotime($fHorario[2]))."']";
								else
									$arrCasos.=",['13','0','El grupo presenta problemas de horario con la materia <b>".$nMateria."</b> de ".date("H:i",strtotime($fHorario[1]))." a ".date("H:i",strtotime($fHorario[2]))."']";
							}
						}
						if($arrCasos!="")
						{
							if($aValidacion[1]!="")
							{
								$cadValidacion=$aValidacion[1];
								$cadValidacion=substr($cadValidacion,0,strlen($cadValidacion)-2);
								$cadValidacion.=",".$arrCasos.']}';
								$aValidacion[1]=$cadValidacion;
							}
							else
							{
								$aValidacion[0]=2;
								$aValidacion[1]='{"permiteContinuar":"0","arrCasos":['.$arrCasos.']}';
								
							}
						}
						
						
					}
				}
				
				
				if($aValidacion[0]!=1)
				{
					echo "2|".$aValidacion[1];
					return;
				}
				
			}
			
			$consulta="update 4522_horarioGrupo set horaInicio='".date("H:i",$fechaInicio)."',horaFin='".date("H:i",$fechaFin)."',dia=".$idDiaSemana.",idAula=".$obj->idAula." where idHorarioGrupo=".$idRegistro;
	
			if(($con->ejecutarConsulta($consulta))&&($con->fT())&&(ajustarFechaFinalCurso($idGrupo)))
			{
				echo "1|";
			}
		}
	}
	
	
	
	function validarHorarioMateriaGrid($idMateria,$idGrupo,$fechaInicio,$fechaFin,$idDiaSemana,$idRegistro)
	{
		global $con;
		$horaInicio=date("H:i",$fechaInicio);
		$horaFin=date("H:i",$fechaFin);
		$consulta="SELECT ciclo FROM 4048_grupos WHERE idGrupo=".$idGrupo;
		$ciclo=$con->obtenerValor($consulta);
		return funcValidarHorarioMateriaCurso($horaInicio,$horaFin,$idDiaSemana,$idMateria,$idGrupo,$ciclo,$idRegistro);
		
	}
	
	function eliminarHorarioGrupo()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$consulta="select idGrupo from 4522_horarioGrupo WHERE idHorarioGrupo=".$idRegistro;
		$idGrupo=$con->obtenerValor($consulta);
		$consulta="delete from 4522_horarioGrupo WHERE idHorarioGrupo=".$idRegistro;
		if($con->ejecutarConsulta($consulta))
		{
			if(ajustarFechaFinalCurso($idGrupo,true))
				echo "1|";
		}

		
	}
	
	function obtenerProcesos()
	{
		global $con;
		$idTipoProceso=$_POST["idTipoProceso"];
		$consulta="select idProceso,nombre FROM  4001_procesos WHERE idTipoProceso=".$idTipoProceso." order by nombre";
		$arrProcesos=$con->obtenerFilasArreglo($consulta);	
		echo "1|".$arrProcesos;
	}
	
	function obtenerDisponibilidadHorarioProfesor()
	{
		global $con;
		global $urlSitio;
		
		
		$idUsuario=$_POST["idUsuario"];
		$idGrupo=$_POST["idGrupo"];
		$idSolicitudAME=-1;
		if(isset($_POST["idSolicitud"]))
		{
			$idSolicitudAME=$_POST["idSolicitud"];
		}
		$arrFechas[0]="2011-06-05";
		$arrFechas[1]="2011-06-06";
		$arrFechas[2]="2011-06-07";
		$arrFechas[3]="2011-06-08";
		$arrFechas[4]="2011-06-09";
		$arrFechas[5]="2011-06-10";
		$arrFechas[6]="2011-06-11";
		$consulta="select g.fechaInicio,g.fechaFin,idCiclo,idPeriodo,idInstanciaPlanEstudio,g.Plantel from 4520_grupos g where g.idGrupos=".$idGrupo;
		$filaFechas=$con->obtenerPrimeraFila($consulta);
		
		$arrEvento="";
		$arrGruposActivos=array();
		$arrHorarioGpo=array();
		$arrHorario=array();
		$minHoraDia=strtotime("23:59:00");
		$minHora=strtotime("23:59:00");
		$maxHoraDia=strtotime("00:00:00");
		$fechaActual=strtotime(date("Y-m-d"));
		
		$idCiclo=$filaFechas[2];
		$idPeriodo=$filaFechas[3];
		$plantel=$filaFechas[5];
		
		
		$consulta="SELECT idDiaSemana,horaInicio,horaFin FROM 4065_disponibilidadHorario d
                    WHERE d.ciclo=".$idCiclo." AND d.idPeriodo=".$idPeriodo.
					" AND  tipo=1 AND idUsuario=".$idUsuario."  ORDER BY idDiaSemana,horaInicio";
		$resFilas=$con->obtenerFilas($consulta);
		
		//AjusteHorario
		
		if((strpos($urlSitio,"ugmex")!==false))
		{
			if($con->filasAfectadas==0)
			{
				switch($idPeriodo)
				{
					case 11:
						$consulta="SELECT id__464_gridPeriodos FROM _464_gridPeriodos WHERE idReferencia=1 AND periodoDefaultActivo=1";
	
						$idPeriodo=$con->obtenerValor($consulta);
						
					break;
				}
				$consulta="SELECT idDiaSemana,horaInicio,horaFin FROM 4065_disponibilidadHorario d
						WHERE d.ciclo=".$idCiclo." AND d.idPeriodo=".$idPeriodo.
						" AND  tipo=1 AND idUsuario=".$idUsuario."  ORDER BY idDiaSemana,horaInicio";
				$resFilas=$con->obtenerFilas($consulta);
			}
		}
		//--
		
		$arrHorarioProf=array();
		if($con->filasAfectadas!=0)
		{
			
			while($fila=mysql_fetch_row($resFilas))
			{
				if(!isset($arrHorarioProf[$fila[0]]))
					$arrHorarioProf[$fila[0]]=array();
				$obj[0]=$fila[1];
				$obj[1]=$fila[2];
				array_push($arrHorarioProf[$fila[0]],$obj);
			}
		}
		else
		{
			$consulta="SELECT id__1025_tablaDinamica FROM _1025_tablaDinamica c,_1025_periodoEscolar p WHERE p.idPadre=c.id__1025_tablaDinamica AND c.cicloEscolar=".$idCiclo." AND p.idOpcion=".$idPeriodo." and c.codigoInstitucion='".$plantel."'";
			$lConvocatorias=$con->obtenerListaValores($consulta);
			if($lConvocatorias=="")
				$lConvocatorias=-1;
				
			$consulta="SELECT id__1026_tablaDinamica FROM _1026_tablaDinamica WHERE idConvocatoria IN (".$lConvocatorias.")";
			$lConvocatorias=$con->obtenerListaValores($consulta);
			if($lConvocatorias=="")
				$lConvocatorias=-1;
					
				
				
			$consulta="SELECT idDiaSemana,horaInicio,horaFin FROM 4065_disponibilidadHorario d
                    WHERE d.idFormulario=1026 and d.idReferencia in(".$lConvocatorias.") and d.idPeriodo=".$idPeriodo.
					" AND  tipo=1 AND idUsuario=".$idUsuario."  ORDER BY idDiaSemana,horaInicio";	
			$resFilas=$con->obtenerFilas($consulta);
			if($con->filasAfectadas==0)
			{
				$consulta="SELECT idDiaSemana,horaInicio,horaFin FROM 4065_disponibilidadHorario d
                    WHERE d.idFormulario=1026 and d.idReferencia in(".$lConvocatorias.") and d.idPeriodo=0 
					AND  tipo=1 AND idUsuario=".$idUsuario."  ORDER BY idDiaSemana,horaInicio";	
				$resFilas=$con->obtenerFilas($consulta);
			}
			
			while($fila=mysql_fetch_row($resFilas))
			{
				if(!isset($arrHorarioProf[$fila[0]]))
					$arrHorarioProf[$fila[0]]=array();
				$obj[0]=$fila[1];
				$obj[1]=$fila[2];
				array_push($arrHorarioProf[$fila[0]],$obj);
			}
			
			
		}
		
		
		$periodoInicio=$filaFechas[0];
		if(isset($_POST["fechaInicio"]))
			$periodoInicio=$_POST["fechaInicio"];
		$periodoFin=$filaFechas[1];
		if(isset($_POST["fechaFin"]))
			$periodoFin=$_POST["fechaFin"];
			

		$arrAsignaciones=obtenerAsignacionesProfesor($idUsuario,$idSolicitudAME,$periodoInicio,$periodoFin);
		
		if(sizeof($arrAsignaciones)>0)
		{
			foreach($arrAsignaciones as $a)
			{
				$arrGruposActivos[$a[1]]["participacion"]=$a[8];
				$arrGruposActivos[$a[1]]["idAsignacion"]=$a[0];
			}
		}
		/*$consulta="SELECT g.idGrupos FROM 4519_asignacionProfesorGrupo a,4520_grupos g 
						WHERE g.idGrupos=a.idGrupo AND a.idUsuario=".$idUsuario." AND participacionPrincipal=1 AND a.situacion=1 AND g.idGrupos<>".$idGrupo." and
						((g.fechaInicio<='".$filaFechas[0]."' AND g.fechaFin>='".$filaFechas[0]."')||(g.fechaInicio<='".$filaFechas[1]."' AND g.fechaFin>='".$filaFechas[1]."')||(g.fechaInicio>='".$filaFechas[0]."' AND g.fechaFin<='".$filaFechas[1]."'))";
		
		$arrGruposActivos=array();
		$resGpos=$con->obtenerFilas($consulta);	
		while($fGrupos=mysql_fetch_row($resGpos))
		{
			$comp="";
			$consulta="SELECT MIN(fechaInicio) FROM 4522_horarioGrupo WHERE idGrupo=".$fGrupos[0];
			$fIni=$con->obtenerValor($consulta);
			if($fIni!="")
			{
				$fIni=strtotime($fIni);
				if($fIni>$fechaActual)
					$comp=" and fechaInicio='".date("Y-m-d",$fIni)."'";
				else
					$comp=" and '".date("Y-m-d",$fechaActual)."'>=fechaInicio and '".date("Y-m-d",$fechaActual)."'<=fechaFin";

			}
			$arrGruposActivos[$fGrupos[0]]=$comp;
		}*/
		
		foreach($arrHorarioProf as $h=>$resto)
		{
			$arrHorarioProf[$h]=organizarBloquesHorario($resto);
		}
		$arrCtDia=array();
		foreach($arrHorarioProf as $dia=>$resto)
		{

			$minHoraDia=strtotime("23:59:00");
			$minHora=strtotime("23:59:00");
			$maxHoraDia=strtotime("00:00:00");
			foreach($resto as $fHora)
			{
				$filaHora[0]=$dia;
				$filaHora[1]=$fHora[0];
				$filaHora[2]=$fHora[1];
				
			
				$hora[0]=$filaHora[1];
				$hora[1]=$filaHora[2];
				$hI=strtotime($hora[0]);
				$hF=strtotime($hora[1]);
				$minHora=$hI;
				
				if($minHoraDia>$hI)
				{
					$minHoraDia=$hI;
					
				}
				if($maxHoraDia<$hF)
					$maxHoraDia=$hF;
				
				$d=$filaHora[0];
				if($d==7)
					$d=0;
				$tieneClase=false;
				if(sizeof($arrGruposActivos)>0)
				{
					$horaBase[0]=$hora[0];
					$horaBase[1]=$hora[1];
					$arrBloque=array();
					foreach($arrGruposActivos as $iGrupo=>$comp)
					{
						$arrHorarioGpo=obtenerFechasHorarioGrupoV2($iGrupo,$idSolicitudAME,true,true,$periodoInicio,$periodoFin);
						if(sizeof($arrHorarioGpo)>0)
						{
							foreach($arrHorarioGpo as $fHoras)
							{
								if($filaHora[0]==$fHoras[2])
								{
									if((strtotime($fHoras[3])>=strtotime($horaBase[0]))&&(strtotime($fHoras[4])<=strtotime($horaBase[1])))
									{
										$obj[0]=$fHoras[2];
										$obj[1]=$fHoras[3];
										$obj[2]=$fHoras[4];
										$obj[3]=$fHoras[1];
										$obj[4]=$fHoras[6];
										$obj[5]=$fHoras[7];
										$obj[6]=$comp["participacion"];
										$obj[7]=$comp["idAsignacion"];
										$arrBloque[strtotime($fHoras[3])]=$obj;
									}
								}
							}
						}

						/*$consulta="SELECT h.dia,h.horaInicio,h.horaFin,h.idGrupo,h.fechaInicio,h.fechaFin FROM 4522_horarioGrupo h 
								WHERE h.idGrupo=".$iGrupo." and  h.dia=".$filaHora[0]." and horaInicio>='".$horaBase[0]."' and horaFin<='".$horaBase[1]."'  order by horaInicio";
						
						$resHoras=$con->obtenerFilas($consulta);
						while($fHoras=mysql_fetch_row($resHoras))
						{
							$obj[0]=$fHoras[0];
							$obj[1]=$fHoras[1];
							$obj[2]=$fHoras[2];
							$obj[3]=$fHoras[3];
							$obj[4]=$fHoras[4];
							$obj[5]=$fHoras[5];
							$arrBloque[strtotime($fHoras[1])]=$obj;
						}*/
					}

					ksort($arrBloque);
					
						
						
					if(!isset($arrCtDia[$filaHora[0]]))
						$arrCtDia[$filaHora[0]]=0;
					$tieneClase=false;
					
					foreach($arrBloque as $fOcupa)
					{
						$tieneClase=true;
						if($minHora==strtotime($fOcupa[1]))
						{
							$hora[0]=$fOcupa[1];
							$hora[1]=$fOcupa[2];
							$duracion=strtotime("00:00:00")+strtotime($fOcupa[2])-strtotime($fOcupa[1]);
							$hora[2]=(date("H",$duracion)*60)+date("i",$duracion);
							$hora[3]=1;
							$hora[4]=$fOcupa[3];
							$hora[5]="";
							$hora[6]="";
							$hora[7]=$fOcupa[4];
							$hora[8]=$fOcupa[5];
							$hora[9]=$fOcupa[6];
							$hora[10]=$fOcupa[7];
							if(!isset($arrHorario[$d]))
								$arrHorario[$d]=array();
							array_push($arrHorario[$d],$hora);
							$minHora=strtotime($fOcupa[2]);
		
						}
						else
						{
							if($arrCtDia[$filaHora[0]]==0)
								$hora[0]=date("H:i",$minHoraDia);
							else
								$hora[0]=date("H:i",$minHora);											
							$hora[1]=$fOcupa[1];
							$duracion=strtotime("00:00:00")+strtotime($fOcupa[1])-strtotime($hora[0]);
							$hora[2]=(date("H",$duracion)*60)+date("i",$duracion);
							$hora[3]=0;
							if(!isset($arrHorario[$d]))
								$arrHorario[$d]=array();
							array_push($arrHorario[$d],$hora);
							$hora[0]=$fOcupa[1];
							$hora[1]=$fOcupa[2];
							$duracion=strtotime("00:00:00")+strtotime($fOcupa[2])-strtotime($fOcupa[1]);
							$hora[2]=(date("H",$duracion)*60)+date("i",$duracion);
							$hora[3]=1;
							$hora[4]=$fOcupa[3];
							$hora[5]="";
							$hora[6]="";
							$hora[7]=$fOcupa[4];
							$hora[8]=$fOcupa[5];
							$hora[9]=$fOcupa[6];
							$hora[10]=$fOcupa[7];
							array_push($arrHorario[$d],$hora);
							$minHora=strtotime($fOcupa[2]);
						}
						$arrCtDia[$filaHora[0]]++;
					}
					
					
					
					if(!$tieneClase)
						$minHora=$hI;
					if($minHora<$hF)
					{
						$duracion=strtotime("00:00:00")+$hF-$minHora;
						$hora[0]=date("H:i",$minHora);
						$hora[1]=date("H:i",$hF);
						$hora[2]=(date("H",$duracion)*60)+date("i",$duracion);
						$hora[3]=0;
						$hora[4]="";
						$hora[5]="";
						$hora[6]="";
						if(!isset($arrHorario[$d]))
							$arrHorario[$d]=array();
						array_push($arrHorario[$d],$hora);
						$minHora=$hF;
						$arrCtDia[$filaHora[0]]++;
					
					}
				}
				else
				{
					$minHora=strtotime($fHora[0]);
					$hF=strtotime($fHora[1]);
					$duracion=($hF-$minHora)/60;
					$hora[0]=date("H:i",$minHora);
					$hora[1]=date("H:i",$hF);
					$hora[2]=$duracion;
					$hora[3]=0;
					$hora[4]="";
					$hora[5]="";
					$hora[6]="";
					if(!isset($arrHorario[$dia]))
						$arrHorario[$dia]=array();
					array_push($arrHorario[$dia],$hora);
				}
			}
		}
			
			
		$ct=0;

		foreach($arrHorario as $dia =>$h)
		{
			$horario=$h;
			foreach($horario as $h)
			{
				if($h[3]==0)
				{
					$fechaIni=$arrFechas[$dia];	
					$todoDia='false';
					$obj='	{
								  "id": "disp_'.$ct.'",
								  "cid": "2",
								  "title": "Disponible candidato",
								  "start": "'.$fechaIni.' '.date("H:i:s",strtotime($h[0])).'",
								  "end": "'.$fechaIni.' '.date("H:i:s",strtotime($h[1])).'",
								  "ad": '.$todoDia.',
								  "rO":"1",
								  "notes":"-1"
							  }';
											  
					
				}
				else
				{
					
					$tipoEvento=0;
					if($h[9]==37)
					{
						if($h[10]==0)
							$tipoEvento=19;
						else
							$tipoEvento=3;
					}
					else
					{
						if($h[10]==0)
							$tipoEvento=21;
						else
							$tipoEvento=20;
					}
					$consulta="SELECT nombreGrupo,nombreMateria,o.unidad,a.cveMateria FROM 4520_grupos g,4502_Materias m,817_organigrama o,4512_aliasClavesMateria a WHERE m.idMateria=g.idMateria AND idGrupos=".$h[4]." 
								and o.codigoUnidad=g.plantel and a.idMateria=m.idMateria and a.sede=g.plantel";
					$filaM=$con->obtenerPrimeraFila($consulta);	
					$fechaIni=$arrFechas[$dia];	
					$todoDia='false';
					$obj='	{
								  "id": "clase_'.$ct.'",
								  "cid": "'.$tipoEvento.'",
								  "title": "'.$filaM[1].' (['.$filaM[3].'] '.$filaM[0].', Plantel: '.$filaM[2].') <br>(Del '.date("d/m/Y",strtotime($h[7])).' al '.date("d/m/Y",strtotime($h[8])).')",
								  "start": "'.$fechaIni.' '.$h[0].'",
								  "end": "'.$fechaIni.' '.$h[1].'",
								  "ad": '.$todoDia.',
								  "rO":"1",
								  "notes":"-1"
							  }';
				}
				if($arrEvento=="")
					  $arrEvento=$obj;
				  else
					  $arrEvento.=",".$obj;	
				  $ct++;	
				
				
			}
		}
		echo '1|['.str_replace("\n","",str_replace("\r","",str_replace("\t","",$arrEvento))).']';
	}
	
	function obtenerCandidatos()
	{
		global $con;
		$criterioBusqueda=$_POST["criterioBusqueda"];
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		$arrPonderacion=array();
		$consulta="SELECT idCriterio,valorPonderacion FROM 4620_configuracionBusquedaProfesores";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$arrPonderacion[$fila[0]]=$fila[1];
		}
		
		$arrResultado=array();
		$pos=0;
		
		$arrCriterios=array();
		
		foreach($obj as $o)
		{

			$objParam=json_decode(bD($o->param));
			$ref=NULL;
			$arrCriterios[$pos]=$o->idCalculo;
			$arrResultado[$pos]=resolverExpresionCalculoPHP($o->idCalculo,$objParam,$ref);
			if($arrResultado[$pos]=='')
				$arrResultado[$pos]='-1';
			$pos++;
		}
		
		$condWhere="";
		$arrUsr=array();
		
		
		if($criterioBusqueda==1)
		{
			$pos=0;
			foreach($arrResultado as $nIndex=>$resultado)
			{
				$resultado=str_replace("'","",$resultado);
				if(($resultado!="")&&($resultado!="-1"))
				{
					$arrU=explode(",",$resultado);
					$arregloAux=array();
					foreach($arrU as $r)
					{
						if(!isset($arregloAux[$r]))
						{
							$arregloAux[$r]=1;
						}
					}
					if(sizeof($arregloAux)>0)
					{
						foreach($arregloAux as $r=>$ign)
						{
							if(!isset($arrUsr[$r]))
								$arrUsr[$r]=1;
							else
								$arrUsr[$r]++;
						}
					}
				}
				
				$pos++;
			}
			
			if(sizeof($arrUsr)>0)
			{
				foreach($arrUsr as $u=>$nFunciones)
				{
					if($nFunciones==sizeof($obj))
					{
						if($condWhere=='')
							$condWhere=$u;
						else
							$condWhere.=",".$u;
					}
				}
				if($condWhere!="")
					$condWhere=' where idUsuario in ('.$condWhere.')';
			}
		
		}
		else
		{
			
			foreach($arrResultado as $nIndex=>$cadUsuario)
			{
				$cadUsuario=str_replace("'","",$cadUsuario);
				if(($cadUsuario!="")&&($cadUsuario!="-1"))
				{
					$arrListaUsuarios=explode(",",$cadUsuario);

					foreach($arrListaUsuarios as $u)
					{
						if(!isset($arrUsr[$u]))
						{
							$arrUsr[$u]=array();
							$arrUsr[$u]["total"]=0;
						}
						$iCalculo=$arrCriterios[$nIndex];
						$valor=isset($arrPonderacion[$iCalculo])?$arrPonderacion[$iCalculo]:'1';
						$arrUsr[$u]["".$nIndex]=$valor;
						$arrUsr[$u]["total"]+=$valor;
						
					}
				}
			}
			
			foreach($arrUsr as $u=>$resto)
			{
				if($condWhere=='')
					$condWhere=$u;
				else
					$condWhere.=",".$u;
			}
			if($condWhere!="")
				$condWhere=' where idUsuario in ('.$condWhere.')';
			
		}
		
		
		
		
		if($condWhere=="")
			$condWhere=" where 1=2";
		$consulta="select distinct idUsuario,concat(Paterno,' ',Materno,' ',Nom) as Nombre from 802_identifica".
					$condWhere." order by Paterno,Materno,Nom";

		$res=$con->obtenerFilas($consulta);
		$arrUsuarios="";
		
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT n.txtnivel,a.txtArea,e.especialidad FROM _262_tablaDinamica f,_246_tablaDinamica n ,
						_369_tablaDinamica a,_369_dtgEspecialidad e WHERE f.responsable=".$fila[0]." AND f.idEstado=3 AND n.id__246_tablaDinamica=f.cmbNivelEstudio AND 
						a.id__369_tablaDinamica=f.cmbAreaEstudio AND e.id__369_dtgEspecialidad=f.cmbEspecialidad ORDER BY n.intPrioridad desc";
			$resNivel=$con->obtenerFilas($consulta)	;
			$cadPerfiles="<table>";
			$perfil="";
			while($fNivel=mysql_fetch_row($resNivel))	
			{
				/*if($perfil=="")
				{
					$perfil=$fNivel[0]." (".$fNivel[1].", ".$fNivel[2].")";
				}*/
				
				$cadPerfiles.="<tr><td><img src=\"../images/bullet_green.png\"> ".$fNivel[0]." (".$fNivel[1].", ".$fNivel[2].")</td></tr>";
			}
			$cadPerfiles.="</table>";
			$obj="['".$fila[0]."','".$fila[1]."','".$perfil."','".$cadPerfiles."'";
			
			if($criterioBusqueda==2)
			{
				$obj.=",'".$arrUsr[$fila[0]]["total"]."'";
				foreach($arrCriterios as $nIndex=>$resto)
				{
					$obj.=",'".(isset($arrUsr[$fila[0]][$nIndex])?$arrUsr[$fila[0]][$nIndex]:"0")."'";
				}
			}
			
			$obj.="]";
			if($arrUsuarios=="")
				$arrUsuarios=$obj;
			else
				$arrUsuarios.=",".$obj;
		}
		echo "1|[".str_replace("|","",$arrUsuarios)."]";
	}
	
	function inscribirProfesorCurso()
	{
		global $con;
		$arrResultado=array();
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$idUsuario=$obj->idUsuario;
		$idGrupo=$obj->idGrupo;
		$idParticipacion=$obj->idParticipacion;
		$resultado=1;
		
//		$fechaAplicacion=$_POST["fechaAplicacion"];
		$query="select idMateria,idCiclo,Plantel,idPeriodo,idInstanciaPlanEstudio,fechaInicio,fechaFin,idGradoCiclo from 4520_grupos where idGrupos=".$idGrupo;
		$fGrupo=$con->obtenerPrimeraFila($query);
		if($obj->validar==1)
		{
			$noCumplePerfil=true;
			$query="SELECT idEspecialidad FROM 4502_perfilMateria WHERE idMateria=".$fGrupo[0];
			$listEspecialidades=$con->obtenerListaValores($query);
			if($listEspecialidades=="")
				$noCumplePerfil=false;
			else
			{
				$query="SELECT cmbEspecialidad FROM _262_tablaDinamica WHERE responsable=".$idUsuario." AND cmbEspecialidad IN (".$listEspecialidades.")";
				
				$res=$con->obtenerFilas($query);
				if($con->filasAfectadas>0)
					$noCumplePerfil=false;
			}
			if($noCumplePerfil)
			{
				$objA[0]="11";
				$objA[1]="1";
				$objA[2]="El profesor no cumple con el perfil requerido por la materia";
				$objA[3]="";
				$pos=existeValorMatriz($arrResultado,11,0);
				if($pos==-1)
					array_push($arrResultado,$objA);
			}
			
			$query="SELECT MIN(fechaInicio) FROM 4522_horarioGrupo WHERE fechaFin>=fechaInicio and idGrupo=".$idGrupo;
			$fechaInicioH=$con->obtenerValor($query);
			$horaMatProf="SELECT dia,horaInicio,horaFin FROM 4522_horarioGrupo where fechaFin>=fechaInicio and idGrupo=".$idGrupo;
			if($fechaInicioH!="")
			{
				$fechaInicioH=strtotime($fechaInicioH);
				if($fechaInicioH<strtotime($obj->fechaReemplaza))
					$horaMatProf="SELECT dia,horaInicio,horaFin FROM 4522_horarioGrupo where idGrupo=".$idGrupo." and fechaFin>=fechaInicio and '".$obj->fechaReemplaza."'>=fechaInicio and '".$obj->fechaReemplaza."'<=fechaFin order by dia";
			}
			$resHoras=$con->obtenerFilas($horaMatProf);
			while($filaMat=mysql_fetch_row($resHoras))
			{
				$validarNuevoHorarioMat=validarModificacionHorarioProfExtendido($idUsuario,$filaMat[1],$filaMat[2],$filaMat[0],$fGrupo[1],$fGrupo[0],$idGrupo,1,$obj->fechaReemplaza);
				$dValid=explode("|",$validarNuevoHorarioMat);
				switch($dValid[0])
				{
					case 1:
						$datosVal=validarModificacionHorarioDisponibleDocenteExtendido($filaMat[0],$filaMat[1],$filaMat[2],$fGrupo[1],$idUsuario,$fGrupo[3],$fGrupo[4]);
						$arrDatosVal=explode("|",$datosVal);
						if($arrDatosVal[0]==3)
						{
							$objA[0]="7";
							$objA[1]="0";
							$objA[2]="El horario que desea asignara a la materia no concuerda con la disponibilidad de horario que el profesor estableci&oacute;n para este ciclo";
							$objA[3]=$arrDatosVal[1];
							$pos=existeValorMatriz($arrResultado,7,0);
							if($pos==-1)
								array_push($arrResultado,$objA);
							else	
								$arrResultado[$pos][3].="<br>".$arrDatosVal[1];
						}
					break;
					case 2:
						$objA[0]="9";
						$objA[1]="0";
						$objA[2]="La materia a&uacute;n no tiene configurado fechas de inicio y t&eacute;rmino";
						$objA[3]="";
						array_push($arrResultado,$objA);
					break;
					case 3:
						$objA[0]="10";
						$objA[1]="0";
						$objA[2]="El horario presenta problemas con otras materias en las cuales el profesor es titular";
						$objA[3]=$dValid[1];
						array_push($arrResultado,$objA);
					break;
					
				}
				
				
				
				
				
			}
			
			$objCasos="";
			$resultado=1;
			if(sizeof($arrResultado)>0)	
			{
				$resultado=-1;
				$permiteContinuar=1;
				$arrCasos="";
				$cCaso="";
				foreach($arrResultado as $objRes)
				{
					if($objRes[1]==0)
						$permiteContinuar=0;
					$cCaso="['".$objRes[0]."','".$objRes[1]."','".$objRes[2]."','".$objRes[3]."']";	
					if($arrCasos=="")
						$arrCasos=$cCaso;
					else
						$arrCasos.=",".$cCaso;
				}
				$arrCasos="[".$arrCasos."]";
				$objCasos='{"permiteContinuar":"'.$permiteContinuar.'","arrCasos":'.$arrCasos.'}';
			}
		}		

		if($resultado==1)
		{
			$x=0;
			$consulta[$x]="begin";
			$x++;
			$idAsignacion=-1;
			$comp="";
			$fechaAsignacion="";
			if($obj->asignaProfesorSuplente=="0")
			{

				$fechaAsignacion=$fGrupo[5];
				$situacion=1;
				$situacionPlanEstudio=obtenerSituacionPlanPeriodo($fGrupo[4],$fGrupo[1],$fGrupo[3],$fGrupo[7]);
				$asignarProfesor=true;
				if($situacionPlanEstudio==3)
				{
					$situacion=5;
					$query="SELECT * FROM 4548_solicitudesMovimientoGrupo WHERE idGrupo=".$idGrupo." AND tipoSolicitud=2 AND situacion=1";
					$fSolicitud=$con->obtenerPrimeraFila($query);
					if(!$fSolicitud)
					{
						$folio=generarFolioAME($idGrupo);
						$objDatos='{"idProfesorAsigna":"'.$idUsuario.'","fechaReemplaza":"'.$obj->fechaReemplaza.'"';
						if(isset($obj->comentarios))
							$objDatos.=',"comentarios":"'.cv($obj->comentarios).'"';
						$objDatos.="}";
						$fechaAsignacion=$obj->fechaReemplaza;
						$consulta[$x]="INSERT INTO 4548_solicitudesMovimientoGrupo(fechaSolicitud,responsableSolicitud,idInstanciaPlan,tipoSolicitud,datosSolicitud,
										situacion,idGrupo,folio) VALUES('".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",".$fGrupo[4].",1,'".cv($objDatos)."',1,".$idGrupo.",'".$folio."')";
						
						$x++;
						
					}
					else
					{
						$objDatos=$fSolicitud[5];
						$objDatos=setAtributoCadJson($objDatos,"idProfesorSuple",$idUsuario);
						$objDatos=setAtributoCadJson($objDatos,"fechaReemplaza",$obj->fechaReemplaza);
						$consulta[$x]="update 4548_solicitudesMovimientoGrupo set datosSolicitud='".cv($objDatos)."' where idSolicitudMovimiento=".$fSolicitud[0];
						$x++;
						$asignarProfesor=false;
						
						
					}
					
					
					
				}
				
				if($asignarProfesor)
				{
					$consulta[$x]="INSERT INTO 4519_asignacionProfesorGrupo(idGrupo,idUsuario,idParticipacion,esperaContrato,participacionPrincipal,situacion,fechaAsignacion,fechaBaja) 
								VALUES(".$idGrupo.",".$idUsuario.",".$idParticipacion.",1,1,".$situacion.",'".$fechaAsignacion."','".$fGrupo[6]."')";
					$x++;
				}
				if($situacion==1)
				{
					ajustarSesiones($idGrupo,strtotime($fGrupo[5]),NULL,$consulta,$x,false);
				}
				if($fGrupo[0]<0)
				{
					$query="select idGrupos,fechaInicio FROM 4520_grupos WHERE idGrupoAgrupador=".$idGrupo;
					$resGpo=$con->obtenerFilas($query);
					while($filaGpo=mysql_fetch_row($resGpo))
					{
						$consulta[$x]="INSERT INTO 4519_asignacionProfesorGrupo(idGrupo,idUsuario,idParticipacion,esperaContrato,participacionPrincipal,situacion,fechaAsignacion,fechaBaja) 
									VALUES(".$filaGpo[0].",".$idUsuario.",".$idParticipacion.",1,1,".$situacion.",'".$fechaAsignacion."','".$fGrupo[6]."')";
						$x++;
						if($situacion==1)
						{
							ajustarSesiones($idGrupo,strtotime($filaGpo[1]),NULL,$consulta,$x,false);
						}
					}
				}
				if(isset($obj->profesorNoPerfil)&&($obj->profesorNoPerfil==1))
				{
					$consulta[$x]="INSERT INTO 4541_asignacionesNoCumplePerfil(idProfesor,idGrupo,ciclo,plantel,fechaAsignacion,comentarios)
									VALUES(".$idUsuario.",".$idGrupo.",".$fGrupo[1].",'".$fGrupo[2]."','".date("Y-m-d")."','".cv($obj->comentarios)."')";
					$x++;
					
				}
				/*$consulta[$x]="INSERT INTO 4541_fumpGrupo(idGrupo,fechaMovimiento,responsable,fechaAplicacion,idUsuario,tipoMovimiento,comentarios,idReferencia)
								VALUES(".$idGrupo.",'".date("Y-m-d")."',".$_SESSION["idUsr"].",'".$fechaAplicacion."',".$idUsuario.",1,'',(select last_insert_id()))";
				$x++;*/
				$consulta[$x]="delete from 4233_solicitudConvMateria where idGrupo=".$idGrupo;
				$x++;
			}
			else
			{
				$query="SELECT idUsuario FROM 4519_asignacionProfesorGrupo WHERE idGrupo=".$idGrupo." AND situacion=60";	
				$idUsuarioBaja=$con->obtenerValor($query);
				$situacion=1;
				$tSolicitud=3;
				if($idUsuarioBaja=="")
				{
					$query="select idFormularioAccion,idRegistroAccion from 4519_asignacionProfesorGrupo WHERE idGrupo=".$idGrupo." AND idUsuario=0 AND idParticipacion=45";
					$fSuplencia=$con->obtenerPrimeraFila($query);
					$query="select idUsuario,idAsignacionProfesorGrupo from 4519_asignacionProfesorGrupo where participacionPrincipal=1 and idGrupo=".$idGrupo." and situacion=1";
					$fUsuario=$con->obtenerPrimeraFila($query);
					$idProfesorTitular=$fUsuario[0];
					$idAsignacion=$fUsuario[1];
					$consulta[$x]="UPDATE  4519_asignacionProfesorGrupo SET idUsuario=".$idUsuario." WHERE idGrupo=".$idGrupo." AND idUsuario=0 AND idParticipacion=45";
					$x++;
					if($fGrupo[0]<0)
					{
						$query="select idGrupos FROM 4520_grupos WHERE idGrupoAgrupador=".$idGrupo;
						$listGrupos=$con->obtenerListaValores($query);
						if($listGrupos!="")
						{
							$consulta[$x]="UPDATE  4519_asignacionProfesorGrupo SET idUsuario=".$idUsuario." WHERE idGrupo in (".$listGrupos.") AND idUsuario=0 AND idParticipacion=45";
							$x++;
						}
					}
					$folio=generarFolioAME($idGrupo);
				}
				else
				{
					$query="select idFormularioAccion,idRegistroAccion,idAsignacionProfesorGrupo from 4519_asignacionProfesorGrupo WHERE idGrupo=".$idGrupo." AND idUsuario=".$idUsuarioBaja." AND idParticipacion=37 and situacion=60";
					$fSuplencia=$con->obtenerPrimeraFila($query);
					$idProfesorTitular=$idUsuarioBaja;
					$idAsignacion=$fSuplencia[2];
					$comp=',"fechaReemplaza":"'.$obj->fechaReemplaza.'"';
					if(isset($obj->comentarios))
						$comp.=',"comentarios":"'.cv($obj->comentarios).'"';
					/*if($fGrupo[0]<0)
					{
						$query="select idGrupos FROM 4520_grupos WHERE idGrupoAgrupador=".$idGrupo;
						$listGrupos=$con->obtenerListaValores($query);
						if($listGrupos!="")
						{
							$consulta[$x]="UPDATE  4519_asignacionProfesorGrupo SET idUsuario=".$idUsuario." WHERE idGrupo in (".$listGrupos.") AND idUsuario=0 AND idParticipacion=45";
							$x++;
						}
					}*/
					$query="SELECT folio  FROM 4548_solicitudesMovimientoGrupo WHERE idAsignacion=".$idAsignacion." and situacion=5";
					$folio=$con->obtenerValor($query);
					if($folio=="")
						$folio=generarFolioAME($idGrupo);
					else
					{
						$consulta[$x]="delete from 4548_solicitudesMovimientoGrupo where folio='".$folio."'";
						$x++;
					}
					$situacion=5;
					$tSolicitud=2;
				}
				
				$objDatos='{"idProfesorSuplencia":"'.$idProfesorTitular.'","idFormulario":"'.$fSuplencia[0].'","idRegistro":"'.$fSuplencia[1].'","idProfesorSuple":"'.$idUsuario.'"'.$comp.'}';
				$consulta[$x]="INSERT INTO 4548_solicitudesMovimientoGrupo(fechaSolicitud,responsableSolicitud,idInstanciaPlan,tipoSolicitud,datosSolicitud,
							situacion,idGrupo,folio,idAsignacion) VALUES('".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",".$fGrupo[4].",".$tSolicitud.",'".cv($objDatos)."',".$situacion.",".$idGrupo.",'".$folio."',".$idAsignacion.")";
				
				$x++;
			}

			$consulta[$x]="commit";
			$x++;
			
			eB($consulta);
		}
		else
		{
			echo "2|".$objCasos;
		}
	}
	
	function removerProfesorTitular()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$query="select idMateria,idCiclo,Plantel,idPeriodo,idInstanciaPlanEstudio from 4520_grupos where idGrupos=".$idGrupo;
		$fGrupo=$con->obtenerPrimeraFila($query);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($fGrupo[0]<0)
		{
			$query="select idGrupos FROM 4520_grupos WHERE idGrupoAgrupador=".$idGrupo;

			$listGrupos=$con->obtenerListaValores($query);
			if($listGrupos!="")
			{
				$consulta[$x]="delete from 4519_asignacionProfesorGrupo where idGrupo in (".$listGrupos.") and participacionPrincipal=1";
				$x++;
			}
			
		}
		$consulta[$x]="delete from 4519_asignacionProfesorGrupo where idGrupo=".$idGrupo." and participacionPrincipal=1";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerCalendariosAreaFisica()
	{
		echo '	{
                        "calendarios":	[
											{
												"id":"1",
												"title":"Horario asignado a materia"
											}
										]
            	}';
	}
	
	
	function obtenerHorarioArea()
	{
		global $idGrupo;
		global $con;
		$idArea=$_POST["idArea"];
		$ciclo=$_POST["ciclo"];
		$idGrupo=$_POST["idGrupo"];
		$consulta="select g.fechaInicio,g.fechaFin from 4520_grupos g where g.idGrupos=".$idGrupo;
		$filaFechas=$con->obtenerPrimeraFila($consulta);
		$rO=$_POST["rO"];
		$arrFechas[0]="2011-06-05";
		$arrFechas[1]="2011-06-06";
		$arrFechas[2]="2011-06-07";
		$arrFechas[3]="2011-06-08";
		$arrFechas[4]="2011-06-09";
		$arrFechas[5]="2011-06-10";
		$arrFechas[6]="2011-06-11";
		$consulta="SELECT h.dia,h.horaInicio,h.horaFin,g.idGrupos FROM 4520_grupos g,4522_horarioGrupo h 
					WHERE g.idGrupos=h.idGrupo AND h.idAula=".$idArea." AND  
					((g.fechaInicio<='".$filaFechas[0]."' AND g.fechaFin>='".$filaFechas[0]."')||(g.fechaInicio<='".$filaFechas[1]."' AND g.fechaFin>='".$filaFechas[1]."')||(g.fechaInicio>='".$filaFechas[0]."' AND g.fechaFin<='".$filaFechas[1]."'))
					  order by horaInicio";
		$arrEvento="";			
		$res=$con->obtenerFilas($consulta);	
		$ct=0;	 
		while($fila= mysql_fetch_row($res))
		{
				$consulta="SELECT nombreGrupo,nombreMateria FROM 4520_grupos g,4502_Materias m WHERE m.idMateria=g.idMateria AND idGrupos=".$fila[3];
				$filaM=$con->obtenerPrimeraFila($consulta);	
				$fechaIni=$arrFechas[$fila[0]];	
				$todoDia='false';
				$obj='	{
							  "id": "'.$ct.'",
							  "cid": "1",
							  "title": "Clase: '.$filaM[1].' ('.$filaM[0].')",
							  "start": "'.$fechaIni.' '.$fila[1].'",
							  "end": "'.$fechaIni.' '.$fila[2].'",
							  "ad": '.$todoDia.',
							  "rO":"1",
							  "notes":"-1"
						  }';
				if($arrEvento=="")
					$arrEvento=$obj;
				else
					$arrEvento.=",".$obj;	
				$ct++;
		}
		echo '{"evts":['.$arrEvento.']}';
	
	}
	
	function obtenerAgendaGrupo()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$arrFechas[0]="2011-06-05";
		$arrFechas[1]="2011-06-06";
		$arrFechas[2]="2011-06-07";
		$arrFechas[3]="2011-06-08";
		$arrFechas[4]="2011-06-09";
		$arrFechas[5]="2011-06-10";
		$arrFechas[6]="2011-06-11";
		
		$ct=0;
		$todoDia=0;
		$arrEvento="";
		$arrGrupos=array();
		array_push($arrGrupos,$idGrupo);
		$consulta="SELECT idGrupoPadre,codigoPadre,e.idPlanEstudio,g.idInstanciaPlanEstudio,e.nivel FROM  4520_grupos g,4505_estructuraCurricular e WHERE e.tipoUnidad=1 AND e.idUnidad=g.idMateria AND idGrupos=".$idGrupo;
		$fGrupo=$con->obtenerPrimeraFila($consulta);
		if($fGrupo[1]!="")
		{
			$padre=$fGrupo[1];
			if($fGrupo[4]!="2")
			{
				$padre=substr($padre,0,3);
			}
			$listMaterias=obtenerMateriasObligatorias($fGrupo[2],$padre);
			$consulta="select idGrupos from 4520_grupos WHERE idMateria IN (".$listMaterias.") AND idInstanciaPlanEstudio=".$fGrupo[3]." and idGrupos<>".$idGrupo." and idGrupoPadre=".$fGrupo[0];
			$resGrupos=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($resGrupos))
			{
				array_push($arrGrupos,$fila[0]);
			}
		}
		$ctColor=9;
		foreach($arrGrupos as $grupo)
		{
			$consulta="sELECT nombreGrupo,nombreMateria,o.unidad FROM 4520_grupos g,4502_Materias m,817_organigrama o WHERE idGrupos=".$grupo." and m.idMateria=g.idGrupos and o.codigoUnidad=g.Plantel";
			$fGrupo=$con->obtenerPrimeraFila($consulta);
			$consulta="SELECT horaInicio,horaFin,dia,idAula FROM  4522_horarioGrupo WHERE idGrupo=".$grupo." ORDER BY dia";
			$lClase=cv($fGrupo[1])." (Grupo: ".($fGrupo[2])."<br>Lugar: @lugar<br>[".$fGrupo[2]."]";
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$consulta="SELECT nombreArea FROM 9309_ubicacionesFisicas WHERE idAreaFisica=".$fila[2];
				$nAula=$con->obtenerValor($consulta);
				if($nAula=="")
					$nAula="No especificado";
				$lblClase=str_replace("@lugar",$nAula,$lClase);
				$obj='	{
						  "id": "'.$ct.'",
						  "cid": "'.$ctColor.'",
						  "title": "Clase: '.$lblClase.'",
						  "start": "'.$arrFechas[$fila[2]].' '.$fila[0].'",
						  "end": "'.$arrFechas[$fila[2]].' '.$fila[1].'",
						  "ad": '.$todoDia.',
						  "rO":"1",
						  "notes":"-1"
					  }';
				if($arrEvento=="")
					$arrEvento=$obj;
				else
					$arrEvento.=",".$obj;
				$ct++;
				
				
			}
			$ctColor++;
			if($ctColor>13)
				$ctColor=9;
		}
			

		echo '{"evts":['.$arrEvento.']}';
	}
	
	
	function obtenerMateriasObligatorias($planEstudios,$codigoPadre)
	{
		global $con;
		$consulta="SELECT * FROM 4505_estructuraCurricular WHERE idPlanEstudio=".$planEstudios." AND codigoPadre='".$codigoPadre."'";
		$res=$con->obtenerFilas($consulta);
		$cadMateria="";
		while($fila=mysql_fetch_row($res))
		{
			if($fila[3]==1)
			{
				if($fila[6]==1)
				{
					if($cadMateria=="")
						$cadMateria=$fila[2];
					else
						$cadMateria.=",".$fila[2];
				}
			}
			else
			{
				if($fila[3]==2)
				{
					$consulta="select tipoUnidad FROM 4508_unidadesContenedora WHERE idUnidadContenedora=".$fila[2];
					$tUnidad=$con->obtenerValor($consulta);
					if($tUnidad==1)
					{
						if($cadMateria=="")
							$cadMateria="-".$fila[2];
						else
							$cadMateria.=",-".$fila[2];
					}
					if($fila[6]==1)
					{
						$cadAux=obtenerMateriasObligatorias($planEstudios,$fila[5]);
						if($cadAux!="")
						{
							if($cadMateria=="")
								$cadMateria=$cadAux;
							else
								$cadMateria.=",".$cadAux;
						}
					}
					
				}
			}
		}
		return $cadMateria;
	}
	
	function  obtenerListadoEventosReasignacion()
	{
		global $con;
		$fechaInicio=$_POST["start"];
		$fechaFin=$_POST["end"];
		$plantel="";
		$comp="";
		if(isset($_POST["institucion"]))
		{
			$plantel=$_POST["institucion"];
			$comp=" and g.Plantel='".$plantel."'";
		}
		
		$dFecha=explode("-",$fechaInicio);
		$fechaInicio=$dFecha[2]."-".$dFecha[0]."-".$dFecha[1];
		$dFecha=explode("-",$fechaFin);
		$fechaFin=$dFecha[2]."-".$dFecha[0]."-".$dFecha[1];
		
		$idUsuario=$_POST["idUsuario"];
		$listEventos="-1";
		$consulta="select idEvento from 4089_invitadosEvento where idUsuario=".$idUsuario;
		$listEventos=$con->obtenerListaValores($consulta);
		if($listEventos=="")
			$listEventos="-1";
		
			
			
		$consulta="(	select * from 4089_eventos where idUsuario=".$idUsuario." and ((fechaInicio>='".$fechaInicio."' and fechaInicio<='".$fechaFin."') or (fechaFinal>='".$fechaInicio."' and fechaFinal<='".$fechaFin."'))) union 
						(select * from 4089_eventos where idEvento in (".$listEventos.") and ((fechaInicio>='".$fechaInicio."' and fechaInicio<='".$fechaFin."') or (fechaFinal>='".$fechaInicio."' and fechaFinal<='".$fechaFin."')))
						
					";
		$res=$con->obtenerFilas($consulta);
		$arrEvento="";
		while($fila=mysql_fetch_row($res))
		{
			$todoDia='false';			
			if($fila[7]==1)
				$todoDia='true';	
				
			$rO="0";
			if(($fila[2]!=$idUsuario)||($fila[8]=='1'))
				$rO="1";	
			
			$tEvento=0;
			if(strpos($fila[0],"_")!==false)
				$tEvento=1;
			$obj='	{
						  "id": "'.$fila[0].'",
						  "cid": "'.$fila[8].'",
						  "title": "'.cv(uEJ($fila[1])).'",
						  "start": "'.$fila[3].' '.$fila[4].'",
						  "end": "'.$fila[5].' '.$fila[6].'",
						  "ad": '.$todoDia.',
						  "notes": "'.cv(uEJ($fila[9])).'",
						  "loc":"'.cv(uEJ($fila[10])).'",
						  "url":"'.cv(uEJ($fila[11])).'",
						  "rem":"'.cv(uEJ($fila[12])).'",
						  "rO":'.$rO.',
						  "tipoEvento":"'.$tEvento.'"
					  }';
			if($arrEvento=="")
				$arrEvento=$obj;
			else
				$arrEvento.=",".$obj;	
		}
		
		$condActivo=" and ".generarConsultaIntervalos($fechaInicio,$fechaFin,"a.fechaAsignacion","a.fechaBaja",true);
		
		
		
		$consulta="SELECT m.idMateria,idGrupo,m.nombreMateria FROM 4519_asignacionProfesorGrupo a,4502_Materias m,4520_grupos g 
					WHERE m.idMateria=g.idMateria AND g.idGrupos=a.idGrupo and a.idUsuario=".$idUsuario.$condActivo." and a.fechaBaja>=a.fechaAsignacion and g.situacion=1 ".$comp;	

		$resMaterias=$con->obtenerFilas($consulta);
		$arrGrupos=array();
		while($filaMat=mysql_fetch_row($resMaterias))
		{
			if(!isset($arrGrupos[$filaMat[1]]))
				$arrGrupos[$filaMat[1]]=0;
					
			$consulta="SELECT * FROM 4530_sesiones WHERE idGrupo=".$filaMat[1]." and (fechaSesion>='".$fechaInicio."' and fechaSesion<='".$fechaFin."')";	

			$resSesiones=$con->obtenerFilas($consulta);
			while($filaS=mysql_fetch_row($resSesiones))
			{
				$todoDia="0";
				$tipoSesion="";
				
				$tipoSesion=$filaS[4];
				$horario=$filaS[3];
				$arrHorario=explode(",",$horario);
				foreach($arrHorario as $objHorario)
				{
					$h=explode(" - ",$objHorario);
					$obj='	{
							  "id": "'.$filaS[0].'",
							  "cid": "'.$tipoSesion.'",
							  "title": "Clase: '.cv(uEJ($filaMat[2])).'",
							  "start": "'.trim($filaS[2]).' '.trim($h[0]).'",
							  "end": "'.trim($filaS[2]).' '.trim($h[1]).'",
							  "ad": '.$todoDia.',
							  "notes": "",
							  "loc":"",
							  "url":"",
							  "rem":"",
							  "rO":"-1"
						  }';
					if($arrEvento=="")
						$arrEvento=$obj;
					else
						$arrEvento.=",".$obj;
				}
			}
		}
		$ct=0;
		$arrSesionesSuplencia=obtenerSesionesSuplencia($idUsuario,$fechaInicio,$fechaFin,$plantel);
		if(sizeof($arrSesionesSuplencia)>0)
		{
			foreach($arrSesionesSuplencia as $s=>$horario)
			{
				foreach($horario as $h)
				{
					$consulta="SELECT m.nombreMateria FROM 4520_grupos g,4502_Materias m WHERE g.idGrupos=".$h[2]." AND m.idMateria=g.idMateria";
					
					$nMateria=$con->obtenerValor($consulta);
					$obj='	{
								  "id": "s_'.$ct.'",
								  "cid": "17",
								  "title": "Clase: '.$nMateria.'",
								  "start": "'.trim($s).' '.trim($h[0]).'",
								  "end": "'.trim($s).' '.trim($h[1]).'",
								  "ad": "0",
								  "notes": "",
								  "loc":"",
								  "url":"",
								  "rem":"",
								  "rO":"1"
							  }';
					if($arrEvento=="")
						$arrEvento=$obj;
					else
						$arrEvento.=",".$obj;
					$ct++;
				}
			}
		}
		
		$lGrupos="";
		if(sizeof($arrGrupos)>0)
		{
			foreach($arrGrupos as $g)
			{
				if($lGrupos=="")
					$lGrupos=$g;
				else
					$lGrupos.=",".$g;
			}
		}
		if($lGrupos=="")
			$lGrupos=-1;
		$arrE=obtenerHorarioGrupo($lGrupos,$fechaInicio,$fechaFin,$plantel);
		if($arrEvento!="")
		{
			$arrEvento.=",".$arrE;
		}
		
		echo  	'{
                    "evts": ['.$arrEvento.']
                }';
	}
	
	function obtenerHorarioGrupo($lGrupos,$fechaInicio,$fechaFin,$plantel="")
	{
		global $con;
		$comp="";
		if($plantel!="")
		{
			$comp="  and g.Plantel='".$plantel."'";
		}


		$consulta="SELECT idUsuario FROM 4517_alumnosVsMateriaGrupo WHERE idGrupo in (".$lGrupos.")";
		$listUsuarios=$con->obtenerListaValores($consulta);
		if($listUsuarios=="")
			$listUsuarios=-1;
			
		$consulta="SELECT DISTINCT idGrupo FROM 4517_alumnosVsMateriaGrupo a,4520_grupos g WHERE idUsuario IN(".$listUsuarios.")AND g.idGrupos=a.idGrupo
					AND g.situacion=1".$comp;
		$listGrupos=$con->obtenerListaValores($consulta);
		if($listGrupos=="")
			$listGrupos=-1;
		$consulta="SELECT fechaSesion,horario FROM 4530_sesiones WHERE idGrupo IN (".$listGrupos.") and fechaSesion>='".$fechaInicio."' and fechaSesion<='".$fechaFin."' ORDER BY fechaSesion,horario";
		
		$resFilas=$con->obtenerFilas($consulta);
		$arrHorarioProf=array();
		$arrHorarioProf=array();
		while($fila=mysql_fetch_row($resFilas))
		{
			$dia=$fila[0];
			$dSesion=explode(",",$fila[1]);
			foreach($dSesion as $s)
			{
				$dHorario=explode("-",trim($s));
				if(!isset($arrHorarioProf[$dia]))
					$arrHorarioProf[$dia]=array();
				$obj[0]=trim($dHorario[0]);
				$obj[1]=trim($dHorario[1]);
				array_push($arrHorarioProf[$dia],$obj);
				
			}
			
			
		}
		if(sizeof($arrHorarioProf)>0)
		{
			foreach($arrHorarioProf as $h=>$resto)
			{
				$arrHorarioProf[$h]=organizarBloquesHorario($resto);
			}
		}
		$arrEvento="";
		$ct=1;
		foreach($arrHorarioProf as $fecha=>$resto)
		{
			foreach($resto as $h)
			{
				$obj='	{
							  "id": "ocupado_'.$ct.'",
							  "cid": "16",
							  "title": "Horario ocupado por grupo",
							  "start": "'.trim($fecha).' '.trim($h[0]).'",
							  "end": "'.trim($fecha).' '.trim($h[1]).'",
							  "ad": "0",
							  "notes": "",
							  "loc":"",
							  "url":"",
							  "rem":"",
							  "rO":"1",
							  "tipoEvento":""
						  }';
				if($arrEvento=="")
					$arrEvento=$obj;
				else
					$arrEvento.=",".$obj;
				$ct++;
			}
		}
		return $arrEvento;
		
	}
	
	function validarHorarioAula()
	{
		global $con;
		echo "1|";
	}
	
	function guardarHorarioGrupoV2()
	{
		global $con;
		global $arrFechasHorario;
		global $arrDiasSemana;
		$arrIncidencias=array();
		$cadObj="";
		$idGrupo="";
		$dia="";
		if(isset($_POST["cadObj"]))
			$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);
		$idMateria=$obj->idMateria;
		$idGrupo=$obj->idGrupo;
		$fechaInicio=strtotime($obj->fechaInicio);
		$fechaFin=strtotime($obj->fechaFin);
		$dia=date("w",strtotime($obj->fechaDia));
		$idRegistroIgnorar=-1;
		if(isset($obj->idRegistro))
			$idRegistroIgnorar=$obj->idRegistro;
			
		$consulta="SELECT idGrupoPadre,fechaInicio,fechaFin,idCiclo,idPeriodo,idInstanciaPlanEstudio FROM 4520_grupos WHERE idGrupos=".$idGrupo;
		$fGrupo=$con->obtenerPrimeraFila($consulta);
		$idCiclo=$fGrupo[3];
		$idPeriodo=$fGrupo[4];
		$idInstancia=$fGrupo[5];

		if($con->cT())
		{
			if($obj->validar==1)
			{
				$idProfesor=obtenerProfesorTitular($idGrupo);
				$resultado=validarColisionHoraMismoGrupoV2($idGrupo,$dia,$obj->horaInicial,$obj->horaFinal,$obj->fechaInicio,$obj->fechaFin,$idRegistroIgnorar);

				$objResp=json_decode($resultado);
				if($objResp->noError!=0)
				{
					array_push($arrIncidencias,$objResp);
				}
				
				$resultado=validarColisionRecesoV2($idGrupo,$dia,$obj->horaInicial,$obj->horaFinal);
				$objResp=json_decode($resultado);
				if($objResp->noError!=0)
				{
					array_push($arrIncidencias,$objResp);
				}
				
				$resultado=validarDisponibilidadHorarioRecesoAlumnoV2($idGrupo,$dia,$obj->horaInicial,$obj->horaFinal);
				$objResp=json_decode($resultado);
				if($objResp->noError!=0)
				{
					array_push($arrIncidencias,$objResp);
				}
				
				
				$resultado=validarTotalHorasAsignadasGrupoV2($idGrupo,$dia,$obj->horaInicial,$obj->horaFinal,$obj->fechaInicio,$obj->fechaFin,$idRegistroIgnorar);
				$objResp=json_decode($resultado);
				if($objResp->noError!=0)
				{
					array_push($arrIncidencias,$objResp);
				}
				if($idProfesor!=-1)
				{
					$resultado=validarRegistroDisponibilidadHorarioDocenteV2($dia,$obj->horaInicial,$obj->horaFinal,$idCiclo,$idProfesor,$idPeriodo,$idInstancia);
					$objResp=json_decode($resultado);
					if($objResp->noError!=0)
					{
						array_push($arrIncidencias,$objResp);
					}
					
					$resultado=validarDisponibilidadHorarioProfesorV2($idProfesor,$obj->horaInicial,$obj->horaFinal,$dia,$obj->fechaInicio,$obj->fechaFin,$idRegistroIgnorar,$idGrupo);
					$objResp=json_decode($resultado);
					if($objResp->noError!=0)
					{
						array_push($arrIncidencias,$objResp);
					}
				}
				
				$resultado=validarDisponibilidadHorarioAlumnoV2($idGrupo,$dia,$obj->horaInicial,$obj->horaFinal,$obj->fechaInicio,$obj->fechaFin);
				$objResp=json_decode($resultado);
				if($objResp->noError!=0)
				{
					array_push($arrIncidencias,$objResp);
				}
				

				$resultado=validarHorarioAulaV2($obj->idAula,$obj->horaInicial,$obj->horaFinal,$dia,$obj->fechaInicio,$obj->fechaFin,$idRegistroIgnorar,$idGrupo);
				$objResp=json_decode($resultado);
				if($objResp->noError!=0)
				{
					array_push($arrIncidencias,$objResp);
				}
				
				$resultado=validarChoqueGruposHermanosV2($idGrupo,$dia,$obj->horaInicial,$obj->horaFinal,$obj->fechaInicio,$obj->fechaFin);
				$objResp=json_decode($resultado);
				if($objResp->noError!=0)
				{
					array_push($arrIncidencias,$objResp);
				}
			}
			
			if(sizeof($arrIncidencias)>0)
			{
				echo "1|".generarResolucionArregloErrores($arrIncidencias);
				return;
			}
			
			if($idRegistroIgnorar==-1)
			{
				$consulta="INSERT INTO  4522_horarioGrupo(idGrupo,dia,horaInicio,horaFin,idAula,fechaInicio,fechaFin) VALUES
						(".$idGrupo.",".$dia.",'".$obj->horaInicial."','".$obj->horaFinal."',".$obj->idAula.",'".$obj->fechaInicio."','".$obj->fechaFin."')";
			}
			else
			{
				$consulta="update  4522_horarioGrupo set dia=".$dia.",horaInicio='".$obj->horaInicial."',horaFin='".$obj->horaFinal."',idAula=".$obj->idAula." where idHorarioGrupo=".$idRegistroIgnorar;
			}

			if($con->ejecutarConsulta($consulta)&&($con->fT())&&(ajustarFechaFinalCurso($idGrupo)))
			{
				if($idRegistroIgnorar==-1)
					$idRegistroIgnorar=$con->obtenerUltimoID();
				
				$consulta="select fechaFin from 4520_grupos where idGrupos=".$idGrupo;
				$fechaFin=$con->obtenerValor($consulta);
				
				echo '1|{"permiteContinuar":"1","arrErrores":[],"idHorario":"'.$idRegistroIgnorar.'","fechaFinCurso":"'.$fechaFin.'"}';
			}
		}
	}
	
	function inscribirProfesorCursoV2()
	{
		global $con;
		$arrIncidencias=array();
		$arrResultado=array();
		$cadObj="";
		if(isset($_POST["cadObj"]))
			$cadObj=$_POST["cadObj"];
		else
			$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$idUsuario=$obj->idUsuario;
		$idGrupo=$obj->idGrupo;
		$idParticipacion=$obj->idParticipacion;
		$resultado=1;

		$query="select idMateria,idCiclo,Plantel,idPeriodo,idInstanciaPlanEstudio,fechaInicio,fechaFin from 4520_grupos where idGrupos=".$idGrupo;
		$fGrupo=$con->obtenerPrimeraFila($query);
		if($obj->validar==1)
		{
			$resultado=validarPerfilProfesorGrupoV2($idUsuario,$idGrupo);
			$objResp=json_decode($resultado);
			if($objResp->noError!=0)
			{
				array_push($arrIncidencias,$objResp);
			}
			$horaMatProf="SELECT dia,horaInicio,horaFin FROM 4522_horarioGrupo where fechaFin>=fechaInicio and idGrupo=".$idGrupo;
			$resHoras=$con->obtenerFilas($horaMatProf);
			while($filaMat=mysql_fetch_row($resHoras))
			{
				$dia=$filaMat[0];
				$horaInicial=$filaMat[1];
				$horaFinal=$filaMat[2];
				$resultado=validarRegistroDisponibilidadHorarioDocenteV2($dia,$horaInicial,$horaFinal,$fGrupo[1],$idUsuario,$fGrupo[3],$fGrupo[4]);
				$objResp=json_decode($resultado);
				if($objResp->noError!=0)
				{
					array_push($arrIncidencias,$objResp);
				}
				
				$resultado=validarDisponibilidadHorarioProfesorV2($idUsuario,$horaInicial,$horaFinal,$dia,$obj->fechaInicio,$obj->fechaFin);
				$objResp=json_decode($resultado);
				if($objResp->noError!=0)
				{
					array_push($arrIncidencias,$objResp);
				}
			}
			
			if(sizeof($arrIncidencias)>0)
			{
				echo "1|".generarResolucionArregloErrores($arrIncidencias);
				return;
			}
		}		

		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$idAsignacion=-1;
		$comp="";
		$consulta[$x]="INSERT INTO 4519_asignacionProfesorGrupo(idGrupo,idUsuario,idParticipacion,esperaContrato,participacionPrincipal,situacion,fechaAsignacion,fechaBaja) 
						VALUES(".$idGrupo.",".$idUsuario.",".$idParticipacion.",1,1,1,'".$obj->fechaInicio."','".$obj->fechaFin."')";
		$x++;
		
		if($fGrupo[0]<0)
		{
			$query="select idGrupos,fechaInicio FROM 4520_grupos WHERE idGrupoAgrupador=".$idGrupo;
			$resGpo=$con->obtenerFilas($query);
			while($filaGpo=mysql_fetch_row($resGpo))
			{
				$consulta[$x]="INSERT INTO 4519_asignacionProfesorGrupo(idGrupo,idUsuario,idParticipacion,esperaContrato,participacionPrincipal,situacion,fechaAsignacion,fechaBaja) 
							VALUES(".$filaGpo[0].",".$idUsuario.",".$idParticipacion.",1,1,1,'".$obj->fechaInicio."','".$obj->fechaFin."')";
				$x++;
				
			}
		}
		if(isset($obj->profesorNoPerfil)&&($obj->profesorNoPerfil==1))
		{
			$consulta[$x]="INSERT INTO 4541_asignacionesNoCumplePerfil(idProfesor,idGrupo,ciclo,plantel,fechaAsignacion,comentarios)
							VALUES(".$idUsuario.",".$idGrupo.",".$fGrupo[1].",'".$fGrupo[2]."','".date("Y-m-d")."','".cv($obj->comentarios)."')";
			$x++;
			
		}
		
		$consulta[$x]="delete from 4233_solicitudConvMateria where idGrupo=".$idGrupo;
		$x++;
		

		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			echo '1|{"permiteContinuar":"1","arrErrores":[]}';
		}
		
	}
	
	
	function obtenerRecesoGrupos()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$arrEvento="";	
		$arrFechas[0]="2011-06-05";
		$arrFechas[1]="2011-06-06";
		$arrFechas[2]="2011-06-07";
		$arrFechas[3]="2011-06-08";
		$arrFechas[4]="2011-06-09";
		$arrFechas[5]="2011-06-10";
		$arrFechas[6]="2011-06-11";
		$consulta="select g.fechaInicio,g.fechaFin,idInstanciaPlanEstudio from 4520_grupos g where g.idGrupos=".$idGrupo;
		$filaFechas=$con->obtenerPrimeraFila($consulta);
		
		
		$consulta="SELECT * FROM _476_gridRecesos WHERE idReferencia IN (
					SELECT idReferencia FROM _476_gridPlanesEstudio WHERE idInstanciaPlanEstudio=".$filaFechas[2].")";
					
		$resRecesos=$con->obtenerFilas($consulta);
		while($fReceso=mysql_fetch_row($resRecesos))
		{
			foreach($arrFechas as $fechaIni)
			{
				$obj='	{
							  "id": "receso_'.$fReceso[0].'",
							  "cid": "19",
							  "title": "'.cv($fReceso[2]).'",
							  "start": "'.$fechaIni.' '.$fReceso[3].'",
							  "end": "'.$fechaIni.' '.$fReceso[4].'",
							  "ad": "0",
							  "rO":"1",
							  "notes":"-1"
						  }';
						   
				if($arrEvento=="")
					$arrEvento=$obj;
				else
					$arrEvento.=",".$obj;
			}
		}
		
		echo '{"evts":['.$arrEvento.']}';
	}
	
	function  obtenerHorarioAlumno()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];


		$arrFechas[0]="2011-06-05";
		$arrFechas[1]="2011-06-06";
		$arrFechas[2]="2011-06-07";
		$arrFechas[3]="2011-06-08";
		$arrFechas[4]="2011-06-09";
		$arrFechas[5]="2011-06-10";
		$arrFechas[6]="2011-06-11";
		$arrEvento="";
		$consulta="SELECT cmbAlumno,instanciaPlanEstudio,materia,idCiclo,idPeriodo FROM _932_tablaDinamica WHERE id__932_tablaDinamica=".$idRegistro;
		$fSolicitud=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT fechaInicial,fechaFinal from 4544_fechasPeriodo WHERE idInstanciaPlanEstudio=".$fSolicitud[1]." AND idCiclo=".$fSolicitud[3]." AND idPeriodo=".$fSolicitud[4]	;
		$fFechas=$con->obtenerPrimeraFila($consulta);
		$comp=" and ".generarConsultaIntervalos($fFechas[0],$fFechas[1],"g.fechaInicio","g.fechaFin");
		$consulta="SELECT idGrupoInscribe FROM 4600_solicitudesInscripcionCurso WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$idGrupoIns=$con->obtenerValor($consulta);
		if($idGrupoIns=="")
			$idGrupoIns=-1;
		$consulta="SELECT idGrupo,g.idMateria FROM 4517_alumnosVsMateriaGrupo a,4520_grupos g WHERE idUsuario=".$fSolicitud[0]." AND a.situacion=1 and g.idGrupos<>".$idGrupoIns." AND g.idGrupos=a.idGrupo".$comp;

		$res=$con->obtenerFilas($consulta);
		$numReg=0;
		while($fila=mysql_fetch_row($res))
		{
			$comp=" and ".generarConsultaIntervalos($fFechas[0],$fFechas[1],"fechaInicio","fechaFin");
			$consulta="SELECT nombreMateria FROM 4502_Materias WHERE idMateria=".$fila[1];
			$materia=$con->obtenerValor($consulta);
			$consulta="SELECT dia,horaInicio,horaFin,idAula,fechaInicio,fechaFin FROM 4522_horarioGrupo h WHERE idGrupo=".$fila[0].$comp;
			$resHorario=$con->obtenerFilas($consulta);
			
			while($fHorario=mysql_fetch_row($resHorario))
			{
				$etiqueta=$materia."<br>(Del ".date("d/m/Y",strtotime($fHorario[4]))." al ".date("d/m/Y",strtotime($fHorario[5])).")";
				$fechaIni=$arrFechas[$fHorario[0]];
				$obj='	{
							  "id": "'.$numReg.'",
							  "cid": "1",
							  "title": "'.cv($etiqueta).'",
							  "start": "'.$fechaIni.' '.$fHorario[1].'",
							  "end": "'.$fechaIni.' '.$fHorario[2].'",
							  "ad": "0",
							  "rO":"1",
							  "notes":"-1"
						  }';
						   
				if($arrEvento=="")
					$arrEvento=$obj;
				else
					$arrEvento.=",".$obj;
				$numReg++;
			}
		}
		
		echo '{"evts":['.$arrEvento.']}';
	}
	
	function  obtenerHorarioGrupos()
	{
		global $con;
		
		$idGrupo=$_POST["idGrupo"];


		$arrFechas[0]="2011-06-05";
		$arrFechas[1]="2011-06-06";
		$arrFechas[2]="2011-06-07";
		$arrFechas[3]="2011-06-08";
		$arrFechas[4]="2011-06-09";
		$arrFechas[5]="2011-06-10";
		$arrFechas[6]="2011-06-11";
		$arrEvento="";
		
		$consulta="SELECT idGrupos,g.idMateria FROM 4520_grupos g WHERE idGrupos=".$idGrupo;

		$res=$con->obtenerFilas($consulta);
		$numReg=0;
		while($fila=mysql_fetch_row($res))
		{
			
			$consulta="SELECT nombreMateria FROM 4502_Materias WHERE idMateria=".$fila[1];
			$materia=$con->obtenerValor($consulta);
			$consulta="SELECT dia,horaInicio,horaFin,idAula,fechaInicio,fechaFin FROM 4522_horarioGrupo h WHERE idGrupo=".$fila[0]." and fechaInicio<fechaFin";
			$resHorario=$con->obtenerFilas($consulta);
			
			while($fHorario=mysql_fetch_row($resHorario))
			{
				$etiqueta=$materia."<br>(Del ".date("d/m/Y",strtotime($fHorario[4]))." al ".date("d/m/Y",strtotime($fHorario[5])).")";
				$fechaIni=$arrFechas[$fHorario[0]];
				$obj='	{
							  "id": "'.$numReg.'",
							  "cid": "4",
							  "title": "'.cv($etiqueta).'",
							  "start": "'.$fechaIni.' '.$fHorario[1].'",
							  "end": "'.$fechaIni.' '.$fHorario[2].'",
							  "ad": "0",
							  "rO":"1",
							  "notes":"-1"
						  }';
						   
				if($arrEvento=="")
					$arrEvento=$obj;
				else
					$arrEvento.=",".$obj;
				$numReg++;
			}
		}
		
		echo '1|['.$arrEvento.']';
	}
		
?>