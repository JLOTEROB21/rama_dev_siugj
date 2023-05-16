<?php session_start();
	include("conexionBD.php"); 
	include_once("transportes/funcionesTransportes.php"); 
	ini_set("memory_limit","128M");
	
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
			guardarReferenciaPunto();
		break;
		case 2: 
			guardarHorarioRutas();
		break;
		case 3: 
			obtenerRutasSemana();
		break;
		case 4:
			obtenerHorariosRuta();
		break;
		case 5:
			obtenerRolArranqueSemana();
		break;
		case 6:
			obtenerRolArranqueSemana();
		break;
		case 7:
			generarRolArranqueSemana();
		break;
		case 8:
			obtenerUnidadesDisponiblesFecha();
		break;
		case 9:
			obtenerInventarioExistenciaTarjetas();
		break;
		case 10:
			obtenerComprasTarjetas();
		break;
		case 11:
			obtenerAutobusesRolDia();
		break;
		case 12:
			buscarTarjetaFolio();
		break;
		case 13:
			buscarTalonFolio();
		break;
		case 14:
			guardarDatosTarjeta();
		break;
		case 15:
			obtenerDatosTarjeta();
		break;
		case 16:
			buscarTalonesActivos();
		break;
		case 17:
			obtenerRolDia();
		break;
		case 18:
			obtenerRolGuardiaDia();
		break;
		case 19:
			registrarAsistenciaUnidad();
		break;
		case 20:
			buscarDatosUnidad();
		break;
		case 21:
			buscarChofer();
		break;
		case 22:
			buscarDatosChofer();
		break;
		case 23:
			evaluarComentariosUnidadChofer();
		break;
		case 24:
			buscarDatosAsignacion();
		break;
		case 25:
			registrarSalidaUnidad();
		break;
		case 26:
			verificarFoliosBajaIntervalo();
		break;
		case 27:
			registrarIngresoPuntoControl();
		break;
		case 28:
			buscarDatosTarjeta();
		break;
		case 29:
			registrarLiquidacionTarjeta();
		break;	
		case 30:
			verificarPermisosAutorizacionUsuario();
		break;
		case 31:
			obtenerAbonosChofer();
		break;
		case 32:
			obtenerAdeudosChofer();
		break;
		case 33:
			registrarAbonosChofer();
		break;
		case 34:
			obtenerPermisosAccionesOperativas();
		break;
		case 35:
			obtenerPuntosControlDisponibles();
		break;
		case 36:
			registrarPuntosControlDisponibles();
		break;
		case 37:
			obtenerPuntosControlAsignados();
		break;
		case 38:
			registrarUsuarioPuntosControl();
		break;
		case 39:
			removerUsuarioPuntosControl();
		break;
		case 40:
			obtenerRolDiaControlTrafico();
		break;
		case 41:
			registrarAsignacionUnidad();
		break;
		case 42:
			obtenerDatosAsignacion();
		break;
		case 43:
			obtenerUnidadesReemplazantes();
		break;
		case 44:
			obtenerDatosUnidadReemplaza();
		break;
		case 45:
			registrarSolicitudReemplazoUnidad();
		break;
		case 46:
			verificarRequerimientoVerificacioBiometrico();
		break;
		case 47:
			obtenerSolicitudesCambioUnidad();
		break;
		case 48:
			registrarAutorizacionSolicitudReemplazoUnidad();
		break;
		case 49:
			obtenerAsignacionTalonesChofer();
		break;
		case 50:
			buscarDatosTalonBoletos();
		break;
		case 51:
			registrarAsignacionTalon();
		break;
		case 52:
			desasignarTalon();
		break;
		case 53:
			buscarDatosTalonBoletosFolio();
		break;
		case 54:
			buscarRelacionTalonesChofer();
		break;
		case 55:
			obtenerBajasBoletosTalon();
		break;
		case 56:
			registrarBajasBoletosTalon();
		break;
		case 57:
			obtenerCambiosCostoBoleto();
		break;
		case 58:
			registrarCambiosCostoBoleto();
		break;
		case 59:
			obtenerAsignacionTarjetasChofer();
		break;
		case 60:
			obtenerTarjetaDisponibleAsignacion();
		break;
		case 61:
			registrarAsignacionTarjetaChofer();
		break;
		case 62:
			registrarDesasignacionTarjetaChofer();
		break;
		case 63:
			obtenerTalonesDiponiblesTarjeta();
		break;
		case 64:
			obtenerTalonesTarjetaActual();
		break;
		case 65:
			buscarDatosRegistroIngresoPuntoControl();
		break;
		case 66:
			obtenerVentaBoletosActualTarjeta();
		break;
		case 67;
			buscarDatosChoferCambio();
		break;
		case 68:
			registrarCambioChofer();
		break;
		case 69:
			obtenerSolicitudesCambioChofer();
		break;
		case 70:
			registrarAjustesLiquidacionTarjeta();
		break;
			
		
	}
	
	function guardarReferenciaPunto()
	{
		global $con;
		
		$latitud=$_POST["latitud"];
		$longitud=$_POST["longitud"];
		$idPunto=$_POST["idPunto"];
		$consulta="UPDATE _1010_tablaDinamica SET latitud='".$latitud."',longitud='".$longitud."' WHERE id__1010_tablaDinamica=".$idPunto;
		eC($consulta);
		
	}
	
	function guardarHorarioRutas()
	{
		global $con;
		$fechaActual=date("Y-m-d");
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$fInicioOriginal=NULL;
		if($obj->idHorario==-1)
		{
			$consulta[$x]="update 3102_perfilHorarioRuta set fechaFin='".date("Y-m-d",strtotime("-1 days",strtotime($obj->fechaAplicacion)))."' where idRuta=".$obj->idRuta." and fechaFin is null";
			$x++;
						
			$consulta[$x]="INSERT INTO 3102_perfilHorarioRuta(fechaInicio,fechaFin,idRuta,descripcion)
							VALUES('".$obj->fechaAplicacion."',NULL,".$obj->idRuta.",'".cv($obj->descripcion)."')";	
			$x++;
			$consulta[$x]="set @idHorario:=(select last_insert_id())";
			$x++;
		}
		else
		{
			
			$query="select fechaInicio from 3102_perfilHorarioRuta where idPerfilHorario=".$obj->idHorario;
			$fInicioOriginal=$con->obtenerValor($query);
			if($fInicioOriginal!=$obj->fechaAplicacion)
			{
				if(strtotime($fInicioOriginal)<strtotime($obj->fechaAplicacion))
				{
					$fAnterior=date("Y-m-d",strtotime("-1 days",strtotime($fInicioOriginal)));
					$query="SELECT idPerfilHorario FROM 3102_perfilHorarioRuta WHERE fechaInicio<='".$fAnterior."' and fechaFin>='".$fAnterior."' and fechaInicio<=fechaFin"	;
					
				}
				else
				{
					$query="SELECT idPerfilHorario FROM 3102_perfilHorarioRuta WHERE fechaInicio<='".$obj->fechaAplicacion."' and fechaFin>='".$obj->fechaAplicacion."' and fechaInicio<=fechaFin"	;
					
				}
				$idPerfilHorario=$con->obtenerValor($query);
				if($idPerfilHorario!="")
				{
					$fechaFin=date("Y-m-d",strtotime("-1 days",strtotime($obj->fechaAplicacion)));
					$consulta[$x]="update 3102_perfilHorarioRuta set fechaFin='".$fechaFin."' where idPerfilHorario=".$idPerfilHorario;	
					$x++;
				}
			}
			
			$consulta[$x]="update 3102_perfilHorarioRuta set fechaInicio='".$obj->fechaAplicacion."' where idPerfilHorario=".$obj->idHorario;	
			$x++;
			$consulta[$x]="set @idHorario:=".$obj->idHorario;
			$x++;
			$consulta[$x]="DELETE FROM 3104_marcadoresHorarioPerfilRuta WHERE idHorario IN (SELECT idHorarioPerfil FROM 3103_horariosPerfilRuta WHERE idPerfilHorarioRuta=@idHorario)";
			$x++;
			$consulta[$x]="delete FROM 3103_horariosPerfilRuta WHERE idPerfilHorarioRuta=@idHorario";
			$x++;
		}
		
		
		foreach($obj->arrHorarios as $h)
		{
			foreach($h->arrAtributos as $a)
			{
				if($a->idPuntoPaseLista=="")
					$a->idPuntoPaseLista="NULL";
				if($a->toleranciaPase=="")
					$a->toleranciaPase="NULL";
				$consulta[$x]="INSERT INTO 3103_horariosPerfilRuta(horario,dia,idPerfilHorarioRuta,idFilaHorario,idPuntoPaseLista,toleranciaPaseLista) VALUES('".
								$h->horario."',".$a->dia.",@idHorario,".$a->numFila.",".$a->idPuntoPaseLista.",".$a->toleranciaPase.")";
				$x++;
				$consulta[$x]="set @idHorarioAtributo:=(select last_insert_id())";
				$x++;
				foreach($a->atributos as $atr)
				{
					$consulta[$x]="INSERT INTO 3104_marcadoresHorarioPerfilRuta(idHorario,idMarcador) VALUES(@idHorarioAtributo,".$atr->atributo.")";
					$x++;
				}
				
				
				
			}
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			if($obj->idHorario==-1)
			{
				$query="select @idHorario";
				$obj->idHorario=$con->obtenerValor($query);	
			}
			
			
			$fechaReferencia=$obj->fechaAplicacion;
			if($fInicioOriginal!=NULL)
			{
				if(strtotime($fechaReferencia)>strtotime($fInicioOriginal))
					$fechaReferencia=$fInicioOriginal;
			}
			
			
			if(strtotime($fechaReferencia)<strtotime($fechaActual))
				$fechaReferencia=$fechaActual;
			
			$consulta="SELECT MAX(fecha) FROM 3105_horarioEjecucionRuta WHERE idRuta=".$obj->idRuta." and fecha>='".$fechaReferencia."'";
			$fechaMax=$con->obtenerValor($consulta);
			if($fechaMax!="")
			{
				$consulta="SELECT fechaFin FROM 1050_semanasAnio WHERE fechaInicio<='".$fechaMax."' AND fechaFin>='".$fechaMax."'";
				$fechaFin=$con->obtenerValor($consulta);	
				$fInicio=strtotime($fechaReferencia);
				while($fInicio<=strtotime($fechaFin))
				{
					generarRolHorarioRutaDia($obj->idRuta,date("Y-m-d",$fInicio),true);
					$fInicio=strtotime("+1 days",$fInicio);

				}
			}
			
			
			
			
			echo "1|".$obj->idHorario;	
		}
	
	}
	
	function obtenerRutasSemana()
	{
		global $con;
		$idSemana=$_POST["idSemana"];
		$idRuta=$_POST["idRuta"];
		
		$tipoHorarios=$_POST["tipoHorarios"];
		$consulta="SELECT fechaInicio,fechaFin FROM 1050_semanasAnio WHERE idSemanaAnio=".$idSemana;
		$fSemanas=$con->obtenerPrimeraFila($consulta);
		$fechaInicio=strtotime($fSemanas[0]);
		$fechaFin=strtotime($fSemanas[1]);
		
		$fechaInicioAux=$fechaInicio;
		
		$arrFechaConsiderar=array();
		for($x=1;$x<=7;$x++)
		{
			$dia=$x;
			if($dia==7)
				$dia=0;
				
			$arrFechaConsiderar[$dia]=date("Y-m-d",$fechaInicioAux);
			$fechaInicioAux=strtotime("+1 days",$fechaInicioAux);
				
		}
		
		$numReg=0;
		$arrRegistros="";
		
		$consulta="SELECT idRuta,nombreRuta FROM 3100_rutasTransportes";
		
		if($idRuta!=0)
			$consulta.=" where idRuta=".$idRuta;
		
		$consulta.=" ORDER BY nombreRuta";
		$res=$con->obtenerFilas($consulta);
		
		
		$arrRutas=array();
		$arrCacheHorarios=array();
		
		
		$arrHorariosAux=array();
		
		while($fila=mysql_fetch_row($res))
		{
			$arrRutas[$fila[1]."_".$fila[0]]=array();
			foreach($arrFechaConsiderar as $dia=>$f)
			{
				generarRolHorarioRutaDia($fila[0],$f);
			}
			
			$consulta="SELECT DISTINCT p.horario FROM 3105_horarioEjecucionRuta h,3103_horariosPerfilRuta p WHERE 
						idRuta=".$fila[0]." AND fecha>='".date("Y-m-d",$fechaInicio).
						"' AND fecha<='".date("Y-m-d",$fechaFin)."' and p.idHorarioPerfil=h.idHorario";
			$resHorario=$con->obtenerFilas($consulta);
			while($fHorario=mysql_fetch_row($resHorario))		
			{
				$horario=array();	
				for($x=1;$x<=7;$x++)
				{
					$dia=$x;
					if($dia==7)
						$dia=0;
					
					
					$comp="";
					switch($tipoHorarios)
					{
						case 1:	
							$comp=" and idPuntoPaseLista is not null";
						break;
						case 2:	
							$comp=" and idPuntoPaseLista is  null";
						break;
					}
					
					$consulta="SELECT p.idHorarioPerfil,idFilaHorario,p.idPuntoPaseLista FROM 3105_horarioEjecucionRuta h,3103_horariosPerfilRuta p WHERE p.idHorarioPerfil=h.idHorario and
								 idRuta=".$fila[0]." AND fecha='".$arrFechaConsiderar[$dia]."' and p.horario='".$fHorario[0]."'   ".$comp;	
					

					$rHorario=$con->obtenerFilas($consulta);
					while($fHorarioAux=mysql_fetch_row($rHorario))
					{
						
						if(!isset($horario[$fHorarioAux[1]]))
						{
							$horario[$fHorarioAux[1]]=array();	
							for($nAux=0;$nAux<7;$nAux++)
							{
								$horario[$fHorarioAux[1]][$nAux]["horario"]="";
								$horario[$fHorarioAux[1]][$nAux]["complementario"]="";
								
							}
						}
						$nReg=$fHorarioAux[0];
						$consulta="SELECT idMarcador FROM 3104_marcadoresHorarioPerfilRuta WHERE idHorario=".$nReg;
						$marcadores=$con->obtenerFilasArreglo($consulta);
						$comp=$nReg."_".$marcadores;
						$horario[$fHorarioAux[1]][$dia]["horario"]=$fHorario[0];
						if(!isset($horario[$fHorarioAux[1]]["puntoPaseLista"])||($horario[$fHorarioAux[1]]["puntoPaseLista"]==""))
							$horario[$fHorarioAux[1]]["puntoPaseLista"]=$fHorarioAux[2];
						$horario[$fHorarioAux[1]][$dia]["complementario"]=$comp;
						
					}
					
				}
				
				$arrHorario=$horario;
				
				foreach($arrHorario as $nFila=>$horario)
				{
					$puntoPaseLista="";
					if($horario["puntoPaseLista"]=="")
						$puntoPaseLista="2) Horario abierto";
					else
					{
						$consulta="SELECT nombreTerminal FROM _1010_tablaDinamica WHERE id__1010_tablaDinamica=".$horario["puntoPaseLista"];
						$nPaseLista=$con->obtenerValor($consulta);
						$puntoPaseLista="1) Horarios de arranque, pase de lista en: ".$nPaseLista;	
					}
					
					$o='{@reemplazar,"paseLista":"'.$puntoPaseLista.'","ruta":"'.$fila[1].'","lunes":"'.$horario[1]["horario"].'","martes":"'.$horario[2]["horario"].'","miercoles":"'.$horario[3]["horario"].
						'","jueves":"'.$horario[4]["horario"].'","viernes":"'.$horario[5]["horario"].'","sabado":"'.$horario[6]["horario"].
						'","domingo":"'.$horario[0]["horario"].'","lunesComp":"'.$horario[1]["complementario"].'","martesComp":"'.$horario[2]["complementario"].
						'","miercolesComp":"'.$horario[3]["complementario"].'","juevesComp":"'.$horario[4]["complementario"].'","viernesComp":"'.$horario[5]["complementario"].
						'","sabadoComp":"'.$horario[6]["complementario"].'","domingoComp":"'.$horario[0]["complementario"].'"
						}';
					
					
					if(!isset($arrHorariosAux[$puntoPaseLista]))
						$arrHorariosAux[$puntoPaseLista]=array();
					
					array_push($arrHorariosAux[$puntoPaseLista],$o);
					
					
					
					
					
				}
			}
			
		}
		
		ksort($arrHorariosAux);
		
		$basePrioridad=1000;
		foreach($arrHorariosAux as $tipoHorario =>$arrElemento)
		{
			$aTipoHorario=split(") ",$tipoHorario);
			
			$tipoHorario=$aTipoHorario[1];
			$o='{"prioridad":"'.$basePrioridad.'","paseLista":"0","ruta":"'.$tipoHorario.'","lunes":"00:00:00","martes":"00:00:00","miercoles":"00:00:00","jueves":"00:00:00","viernes":"00:00:00","sabado":"00:00:00","domingo":"00:00:00","lunesComp":"","martesComp":"","miercolesComp":"","juevesComp":"","viernesComp":"","sabadoComp":"","domingoComp":""						}';
			
			if($arrRegistros=='')
				$arrRegistros=$o;
			else	
				$arrRegistros.=",".$o;
			$numReg++;
			
			foreach($arrElemento as $o)
			{
				$o=str_replace("@reemplazar",'"prioridad":"'.($basePrioridad+1).'"',$o);
				if($arrRegistros=='')
					$arrRegistros=$o;
				else	
					$arrRegistros.=",".$o;
				$numReg++;	
			}
			$basePrioridad+=1000;
		}
		
		/*
					
					
					
					*/
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerHorariosRuta()
	{
		global $con;
		$idRuta=$_POST["idRuta"];
		$consulta="SELECT  idPerfilHorario AS   idHorario, descripcion,fechaInicio,fechaFin FROM 3102_perfilHorarioRuta WHERE 
					idRuta=".$idRuta." and (fechaInicio<=fechaFin or fechaFin is null) ORDER BY  fechaInicio DESC";
		
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));	
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function obtenerRolArranqueSemana()
	{
		global $con;
		$idSemana=$_POST["idSemana"];
		$idRuta=$_POST["idRuta"];
		$arrUnidades=array();
		$consulta="SELECT id__1012_tablaDinamica,numEconomico FROM _1012_tablaDinamica  ORDER BY id__1012_tablaDinamica";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$arrUnidades[$fila[0]]=$fila[1];
		}
		
		$consulta="SELECT fechaInicio,fechaFin FROM 1050_semanasAnio WHERE idSemanaAnio=".$idSemana;
		$fSemanas=$con->obtenerPrimeraFila($consulta);
		$fechaInicio=strtotime($fSemanas[0]);
		$fechaFin=strtotime($fSemanas[1]);
		
		$fechaInicioAux=$fechaInicio;
		
		$arrFechaConsiderar=array();
		$arrFechas="";
		for($x=1;$x<=7;$x++)
		{
			$dia=$x;
			if($dia==7)
			{
				$dia=0;
				$arrFechas="'".date("d/m/Y",$fechaInicioAux)."'".$arrFechas;
			}
			else
				$arrFechas.=",'".date("d/m/Y",$fechaInicioAux)."'";
				
			$arrFechaConsiderar[$dia]=date("Y-m-d",$fechaInicioAux);
			$fechaInicioAux=strtotime("+1 days",$fechaInicioAux);
		}
		$numReg=0;
		$arrRegistros="";
		$comp="";
		$consulta="SELECT idRuta,nombreRuta FROM 3100_rutasTransportes";
		if($idRuta!=0)
		{
			$consulta.=" where idRuta=".$idRuta;
			$comp=" and r.idRuta=".$idRuta;
		}
		$consulta.=" ORDER BY nombreRuta";
		$res=$con->obtenerFilas($consulta);
		$arrRutas=array();
		$arrCacheHorarios=array();
		$matrizHorario=array();
		$matrizHorarioRol=array();
		while($fila=mysql_fetch_row($res))
		{
			foreach($arrFechaConsiderar as $dia=>$f)
			{
				generarRolHorarioRutaDia($fila[0],$f);
			}
		}
			
		$arrRutasHorarios=array();
		foreach($arrFechaConsiderar as $dia=>$f)
		{	
			$consulta="SELECT r.nombreRuta,p.horario,p.idPerfilHorarioRuta,p.idFilaHorario,r.idRuta FROM 3105_horarioEjecucionRuta h,3103_horariosPerfilRuta p,3100_rutasTransportes r 
						WHERE  h.fecha='".$f."' and p.idHorarioPerfil=h.idHorario ".$comp." AND  r.idRuta=h.idRuta ORDER BY horario,nombreRuta";	
			$res=$con->obtenerFilas($consulta);
			while($fRuta=mysql_fetch_row($res))		
			{
				$llave=$fRuta[1]."_".$fRuta[0]."_".$fRuta[2]."_".$fRuta[3]."_".$fRuta[4];

				if(!isset($arrRutasHorarios[$llave]))
				{
					$arrRutasHorarios[$llave]=array();
					$arrRutasHorarios[$llave]["idRuta"]=$fRuta[4];
					$arrRutasHorarios[$llave]["ruta"]=$fRuta[0];
					$arrRutasHorarios[$llave]["horario"]=$fRuta[1];
					$arrRutasHorarios[$llave]["idPerfil"]=$fRuta[2];
					$arrRutasHorarios[$llave]["idFila"]=$fRuta[3];
					$arrRutasHorarios[$llave]["numDias"]=0;
					$arrRutasHorarios[$llave]["0"]="";
					$arrRutasHorarios[$llave]["1"]="";
					$arrRutasHorarios[$llave]["2"]="";
					$arrRutasHorarios[$llave]["3"]="";
					$arrRutasHorarios[$llave]["4"]="";
					$arrRutasHorarios[$llave]["5"]="";
					$arrRutasHorarios[$llave]["6"]="";
				}
			}
		}
		ksort($arrRutasHorarios);
		foreach($arrRutasHorarios as $llave=>$aRuta)
		{
			foreach($arrFechaConsiderar as $dia=>$f)
			{
				$consulta="SELECT idHorarioEjecucion,(SELECT idUnidadAsignada FROM 3106_asignacionHorarioRuta WHERE idHorarioAsignacion=e.idHorarioEjecucion) as idUnidadAsignada FROM 3105_horarioEjecucionRuta e,
							3103_horariosPerfilRuta h,3104_marcadoresHorarioPerfilRuta m WHERE fecha='".$f."' AND h.idHorarioPerfil=e.idHorario
							AND h.idPerfilHorarioRuta=".$aRuta["idPerfil"]." AND h.idFilaHorario=".$aRuta["idFila"]." and m.idHorario=e.idHorario and m.idMarcador in (2,4)";	
							
				$fAsignacion=$con->obtenerprimeraFila($consulta);			
				if($fAsignacion)
				{
					$numEconomico="";
					if(isset($arrUnidades[$fAsignacion[1]]))
						$numEconomico=$arrUnidades[$fAsignacion[1]];
					$arrRutasHorarios[$llave][$dia]=$numEconomico."|".$fAsignacion[1]."|".$fAsignacion[0];
					$arrRutasHorarios[$llave]["numDias"]++;
				}
							
							
			}
		}		
			
		

			
		foreach($arrRutasHorarios as $llave=>$aRuta)
		{
			if($aRuta["numDias"]>0)
			{
				$o='{"idRuta":"'.$aRuta["idRuta"].'","ruta":"'.$aRuta["ruta"].'","horario":"'.$aRuta["horario"].'","lunes":"'.$aRuta[1].'","martes":"'.$aRuta[2].'","miercoles":"'.$aRuta[3].'","jueves":"'.$aRuta[4].
					'","viernes":"'.$aRuta[5].'","sabado":"'.$aRuta[6].'","domingo":"'.$aRuta[0].'"}';	
				if($arrRegistros=='')
					$arrRegistros=$o;
				else	
					$arrRegistros.=",".$o;
				$numReg++;
			}
		}
		
		
		
		echo '{"arrFechas":['.$arrFechas.'],"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function generarRolArranqueSemana()
	{
		global $con;

		$consulta="SELECT funcionRolArranque FROM _1033_tablaDinamica";
		$idFuncionArranque=$con->obtenerValor($consulta);
		if($idFuncionArranque=="")
		{
			echo "1|";
			return;
		}
		$idSemana=$_POST["idSemana"];
		$fechaInicio=$_POST["fechaInicio"];
		$unidadInicial=$_POST["unidadInicial"];
		$consulta="SELECT fechaInicio,fechaFin FROM 1050_semanasAnio WHERE idSemanaAnio=".$idSemana;
		$fSemanas=$con->obtenerPrimeraFila($consulta);	
		$fSemanas[0]=$fechaInicio;
		
		$fInicioAux=strtotime($fSemanas[0]);
		$fFin=strtotime($fSemanas[1]);
		$calcularUnidadInicio=false;
		while($fInicioAux<=$fFin)
		{
			if($calcularUnidadInicio)
			{
				$fechaAnt=date("Y-m-d",strtotime("-1 days",$fInicioAux));
				$consulta="SELECT idUnidadAsignada FROM 3106_asignacionHorarioRuta WHERE fecha='".$fechaAnt."' ORDER BY orden desc";

				$ultimaUnidad=$con->obtenerValor($consulta);
				$arrUnidades=obtenerUnidadesAsignablesTransporte(date("Y-m-d",$fInicioAux));
				foreach($arrUnidades as $u)
				{
					if($u["idUnidad"]>$ultimaUnidad)	
					{

						$unidadInicial=$u["idUnidad"];
						break;
					}
				}
			}
			else
				$calcularUnidadInicio=true;
				
			$arrRutas=generarRolArranqueDia(date("Y-m-d",$fInicioAux));
			if(sizeof($arrRutas)>0)
			{
				$cTmp='{"arrRutas":"","fecha":"","ultimaUnidad":""}';
				$objTmp=json_decode($cTmp);
				$objTmp->arrRutas=$arrRutas;
				$objTmp->fecha=date("Y-m-d",$fInicioAux);
				$objTmp->ultimaUnidad=$unidadInicial;
				$cache=NULL;

				$oResp=removerComillasLimite(resolverExpresionCalculoPHP($idFuncionArranque,$objTmp,$cache));	
			}
			
			$fInicioAux=strtotime("+1 days",$fInicioAux);
			
		}
		echo "1|";
		
	}
	
	function obtenerUnidadesDisponiblesFecha()
	{
		global $con;	
		$fecha=$_POST["fecha"];
		$arrUnidades=obtenerUnidadesAsignablesTransporte($fecha);
		$fechaAnt=date("Y-m-d",strtotime("-1 days",strtotime($fecha)));
		$consulta="SELECT idUnidadAsignada FROM 3106_asignacionHorarioRuta WHERE fecha='".$fechaAnt."' ORDER BY orden desc";
		$ultimaUnidad=$con->obtenerValor($consulta);
		$unidadArranque="";
		$aUnidades="";
		$pos=0;
		foreach($arrUnidades as $u)
		{
			$oU="['".$u["idUnidad"]."','".$u["numEconomico"]."']";	
			
			if($pos>0)
			{
				if(($ultimaUnidad!="")&&($arrUnidades[$pos-1]["idUnidad"]==$ultimaUnidad))	
					$unidadArranque=$u["idUnidad"];
			}
			if($aUnidades=="")
				$aUnidades=$oU;
			else
				$aUnidades.=",".$oU;
			$pos++;
		}
		
		if((sizeof($arrUnidades)>0)&&($ultimaUnidad!=""))
		{
			foreach($arrUnidades as $u)
			{
				if($u["idUnidad"]>$ultimaUnidad)
				{
					$unidadArranque=$u["idUnidad"];
					break;
				}
			}
			
		}
		
		if($unidadArranque=="")
			$unidadArranque=$arrUnidades[0]["idUnidad"];
		echo "1|[".$aUnidades."]|".$unidadArranque;
	}
	
	function obtenerInventarioExistenciaTarjetas()
	{
		global $con;
		$arrRegistros="";
		$numReg=0;
		$consulta="SELECT DISTINCT colorTarjeta FROM _1039_gridDetalleCompra";
		$res=$con->obtenerFilas($consulta);		
		while($fila=mysql_fetch_row($res))
		{
			$consulta='select count(*) from 1101_tarjetasInventario where situacion=0 and color='.$fila[0];
			$nReg=$con->obtenerValor($consulta);	
			$o='{"color":"'.$fila[0].'","existencia":"'.$nReg.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg=0;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerComprasTarjetas()
	{
		global $con;	
		$arrRegistros="";
		$nReg=0;
		$consulta="SELECT idCompra,fechaCompra,serie,folio,
					(select IF(tipoEmpresa=1,CONCAT(apPaterno,' ',apMaterno,' ',razonSocial),razonSocial) AS razonSocial from 6927_empresas where idEmpresa=c.idProveedor) as proveedor
					FROM 1102_comprasTarjeta c";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$descripcion='<table><tr><td width="120" align="center"><span class="letraAzulSimple">Color</span></td><td width="100" align="center"><span class="letraAzulSimple">Folio inicial</span>'.
						'</td><td width="100" align="center"><span class="letraAzulSimple">Folio final</span></td><td width="10" align="center"><span class="letraAzulSimple">Total</span></td></tr>';
			$consulta="SELECT color,folioInicial,folioFinal FROM _1031_tablaDinamica t,1103_detalleCompra d WHERE t.id__1031_tablaDinamica=d.idColor AND d.idCompra=".$fila[0];
			$rDetalle=$con->obtenerFilas($consulta);
			while($fDetalle=mysql_fetch_row($rDetalle))
			{
				$descripcion.='<tr><td width="120" align="center"><span class="letraAzulSimple" style="color:#000">'.$fDetalle[0].'</span></td>'.
								'<td width="120" align="center"><span class="letraAzulSimple" style="color:#000">'.$fDetalle[1].'</span></td>'.
								'<td width="120" align="center"><span class="letraAzulSimple" style="color:#000">'.$fDetalle[2].'</span></td>'.
								'<td width="120" align="center"><span class="letraAzulSimple" style="color:#000">'.(1+$fDetalle[2]-$fDetalle[1]).'</span></td>'.
								'</tr>';	
			}
			$descripcion.="</table>";
			$o='{"idCompra":"'.$fila[0].'","fechaCompra":"'.$fila[1].'","serie":"'.$fila[2].'","folio":"'.$fila[3].'","proveedor":"'.cv($fila[4]).'","descripcion":"'.$descripcion.'"}';	
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$nReg++;
		}
		echo '{"numReg":"'.$nReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	function obtenerAutobusesRolDia()
	{
		global $con;
		$fechaActual=date("Y-m-d");
		$fecha=$_POST['fecha'];
		$numReg=0;
		$arrRegistros="";
		$consulta="SELECT idUnidadAsignada AS idUnidad,f.numEconomico,f.numPlacas
					FROM 3106_asignacionHorarioRuta a,_1012_tablaDinamica f WHERE fecha='".$fecha."' AND f.id__1012_tablaDinamica=a.idUnidadAsignada ORDER BY horario";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$consulta="SELECT idTarjeta,situacion,idAsignacion FROM 1103_asignacionTarjetaFecha a WHERE a.fecha='".$fecha."' AND a.idUnidad=".$fila[0]." and a.situacion not in (0)";
			$fAsignacion=$con->obtenerPrimeraFila($consulta);		
			$idTarjeta=$fAsignacion[0];
			$situacion=$fAsignacion[1];
			$folio="";
			$idAsignacion=$fAsignacion[2];
			if(!$fAsignacion)
			{
				$consulta="SELECT idAsignacion,idTarjeta,situacion FROM 1103_asignacionTarjetaFecha WHERE idUnidad=".$fila[0]." AND fecha<'".$fechaActual."' AND situacion=1";	
				$fTarjeta=$con->obtenerPrimeraFila($consulta);
				if($fTarjeta)
				{
					$idTarjeta=$fTarjeta[1];
					$consulta="update 1103_asignacionTarjetaFecha set fecha='".$fecha."' where idAsignacion=".$fTarjeta[0];
					$con->ejecutarConsulta($consulta);
					$situacion=$fTarjeta[2];
					$idAsignacion=$fTarjeta[0];
				}
			}
			
			if($idTarjeta!="")
			{
				$consulta="select folio FROM 1101_tarjetasInventario t where t.idTarjetaInventario=".$idTarjeta;
				$folio=$con->obtenerValor($consulta);
			}
			
			
			$o='{"idAsignacion":"'.$idAsignacion.'","idUnidad":"'.$fila[0].'","numEconomico":"'.$fila[1].'","numPlacas":"'.$fila[2].'","idTarjeta":"'.$idTarjeta.'","noTarjeta":"'.$folio.'","situacion":"'.$situacion.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
			
	}
	
	function buscarTarjetaFolio()
	{
		global $con;
		$folio=$_POST["folio"];
		$color=$_POST["color"]	;
		
		$consulta="SELECT idTarjetaInventario FROM 1101_tarjetasInventario WHERE folio=".$folio." AND color=".$color." AND situacion=0";
		$idTarjeta=$con->obtenerValor($consulta);
		echo "1|".$idTarjeta;
		
	}
	
	function buscarTalonFolio()
	{
		global $con;
		$folio=$_POST["folioTalon"];
		$consulta="SELECT * FROM 1102_talonesBoletos WHERE idTalon=".$folio;
		$fBoleto=$con->obtenerPrimeraFila($consulta);
		$objResp='';
		if(!$fBoleto)
		{
			$objResp='{"resultado":"0"}';
		}
		else
		{
			if($fBoleto[7]==4)
			{
				$objResp='{"resultado":"1"}';
			}
			else
			{
				if(!(($fBoleto[7]==1)||($fBoleto[7]==3)))
				{
					$objResp='{"resultado":"2"}';
				}
				else
				{
					  $foliosBaja=$foliosBaja=obtenerTotalFoliosBaja($fBoleto[0]);;
					  
					  $total=$fBoleto[11]-$fBoleto[5]+1-$foliosBaja;
					  $montoTalon=$total*$fBoleto[4];
					  $consulta="SELECT clave,c.color FROM _1030_tablaDinamica t,_1031_tablaDinamica c WHERE id__1030_tablaDinamica=".$fBoleto[1]." AND c.id__1031_tablaDinamica=t.color";
					  $fDatosBoleto=$con->obtenerPrimeraFila($consulta);
					  $descripcion='['.$fDatosBoleto[0].'] Color: '.$fDatosBoleto[1];
					  $objResp='{"resultado":"4","descripcion":"'.$descripcion.'","costoUnitario":"'.$fBoleto[4].'","folioInicial":"'.$fBoleto[5].'","folioFinal":"'.$fBoleto[11].'","foliosBaja":"'.$foliosBaja.'","montoTalon":"'.$montoTalon.'","total":"'.$total.'"}';	
					
				}
			}
		}
		echo "1|".$objResp;
		
	}
	
	function guardarDatosTarjeta()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$query[$x]="begin";
		$x++;
		
		
		
		$query[$x]="UPDATE 1101_tarjetasInventario SET situacion=1 WHERE idTarjetaInventario=".$obj->idTarjeta;
		$x++;
		
		$consulta="SELECT COUNT(*) FROM 1103_asignacionTarjetaFecha WHERE idTarjeta=".$obj->idTarjeta." AND situacion<>0 AND idUnidad<>".$obj->idUnidad;
		$nReg=$con->obtenerValor($consulta);
		if($nReg>0)
		{
			echo "|La tarjeta ya ha sido asignada a otra unidad";
			return;	
		}
		$consulta="SELECT idAsignacion FROM 1103_asignacionTarjetaFecha WHERE fecha='".$obj->fecha."' AND idUnidad=".$obj->idUnidad." AND idTarjeta=".$obj->idTarjeta;
		$idAsignacion=$con->obtenerValor($consulta);
		if($idAsignacion=="")
		{
			$query[$x]	="insert into 1103_asignacionTarjetaFecha(fecha,idUnidad,idTarjeta,situacion) values('".$obj->fecha."',".$obj->idUnidad.",".$obj->idTarjeta.",1)";
			$x++;
			$query[$x]="set @idAsignacion:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$query[$x]	="update 1103_asignacionTarjetaFecha set situacion=1 where idAsignacion=".$idAsignacion;
			$x++;	
			$query[$x]="set @idAsignacion:=".$idAsignacion;
			$x++;
		}
		
			
		$listaTalones="";
		$query[$x]="delete from  1102_detalleTarjetaAsignada where idAsignacion=@idAsignacion";
		$x++;
		
		foreach($obj->detalleTarjeta as $d)
		{
			$query[$x]="INSERT INTO 1102_detalleTarjetaAsignada(idTalon,costoUnitario,folioInicial,folioFinal,foliosBaja,total,montoTotal,idAsignacion)
						VALUES(".$d->folioTalon.",".$d->costoUnitario.",".$d->folioInicial.",".$d->folioFinal.",".$d->foliosBaja.",".$d->total.",".$d->montoTalon.",@idAsignacion)";
			$x++;
			if($listaTalones=="")
				$listaTalones=$d->folioTalon;
			else
				$listaTalones.=",".$d->folioTalon;
		}
		
		$query[$x]	="UPDATE 1102_talonesBoletos SET situacion=2 WHERE idTalon IN (".$listaTalones.")";
		$x++;
		
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
		{
			$consulta="select @idAsignacion";
			$idAsignacion=$con->obtenerValor($consulta);
			echo "1|".$idAsignacion;
		}
			
	}
	
	function obtenerDatosTarjeta()
	{
		global $con;
		$idAsignacion=$_POST["idAsignacion"];
		$consulta="SELECT idTarjeta FROM 1103_asignacionTarjetaFecha WHERE idAsignacion=".$idAsignacion;
		
		$idTarjeta=$con->obtenerValor($consulta);
		$consulta="SELECT folio,color,situacion FROM 1101_tarjetasInventario WHERE idTarjetaInventario=".$idTarjeta;
		$fDatosTarjeta=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT d.idTalon,(SELECT concat('[',clave,'] Color: ',c.color) FROM _1030_tablaDinamica t,_1031_tablaDinamica c WHERE id__1030_tablaDinamica=t.tipoBoleto AND c.id__1031_tablaDinamica=t.color) AS descripcion,
					d.costoUnitario,d.folioInicial,d.folioFinal,d.foliosBaja,d.total,d.montoTotal FROM 1102_detalleTarjetaAsignada d,1102_talonesBoletos t WHERE idAsignacion=".$idAsignacion." and t.idTalon=d.idTalon";

		$arrRegistros=$con->obtenerFilasArreglo($consulta);
		
		echo '1|{"folio":"'.$fDatosTarjeta[0].'","color":"'.$fDatosTarjeta[1].'","registros":'.$arrRegistros.'}';
			
	}
	
	function buscarTalonesActivos()
	{
		global $con;
		$idUnidad=$_POST["idUnidad"];
		$consulta="SELECT DISTINCT d.idTalon FROM 1103_asignacionTarjetaFecha a,1102_detalleTarjetaAsignada d, 1102_talonesBoletos t
					WHERE idUnidad=".$idUnidad." AND a.situacion<>0 AND d.idAsignacion=a.idAsignacion AND t.idTalon=d.idTalon AND t.situacion IN (1,3)";

		$idTalones=	$con->obtenerListaValores($consulta);		
		if($idTalones=="")
		{
			$idTalones=-1;
		}
		
		$arrReg="";
		$consulta="SELECT * FROM 1102_talonesBoletos WHERE idTalon IN (".$idTalones.")";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT clave,c.color FROM _1030_tablaDinamica t,_1031_tablaDinamica c WHERE id__1030_tablaDinamica=".$fila[1]." AND c.id__1031_tablaDinamica=t.color";
			$fDatosBoleto=$con->obtenerPrimeraFila($consulta);
			$descripcion='['.$fDatosBoleto[0].'] Color: '.$fDatosBoleto[1];
			
			
			$foliosBaja=obtenerTotalFoliosBaja($fila[0]);
					  
			$total=$fila[11]-$fila[5]+1-$foliosBaja;
			$montoTalon=$total*$fila[4];
			$o="['".$fila[0]."','".$descripcion."','".$fila[4]."','".$fila[5]."','".$fila[11]."','".$foliosBaja."','".$total."','".$montoTalon."']";
			if($arrReg=="")
				$arrReg=$o;
			else
				$arrReg.=",".$o;
			
		}

		echo "1|[".$arrReg."]";
		
	
		
			
	}
	
	function obtenerRolDia()
	{
		global $con;
		$fecha=$_POST["fecha"];
		
		$idPuntoPaseLista=-1;
		$comp="";
		$arrPuntosPermitidos=array();
		if(isset($_POST["idPuntoPaseLista"])&&($_POST["idPuntoPaseLista"]!=""))
		{
			$comp=" and p.idPuntoPaseLista in(".$_POST["idPuntoPaseLista"].")";
			$idPuntoPaseLista=$_POST["idPuntoPaseLista"];
			$arrPuntosPermitidos=explode(",",$idPuntoPaseLista);
		}
	
		$consulta="SELECT DISTINCT idHorarioEjecucion FROM 3105_horarioEjecucionRuta h,3103_horariosPerfilRuta p,3100_rutasTransportes r,3102_perfilHorarioRuta ph,3104_marcadoresHorarioPerfilRuta
					m WHERE h.fecha='".$fecha."' AND p.idHorarioPerfil=h.idHorario AND ph.idPerfilHorario=p.idPerfilHorarioRuta AND  
					r.idRuta=ph.idRuta AND m.idHorario=h.idHorario AND m.idMarcador =4 ".$comp."
					ORDER BY horario,nombreRuta";
		$listaGuardias=$con->obtenerListaValores($consulta);
		if($listaGuardias=="")
			$listaGuardias=-1;
		
		
		
		$consulta="SELECT DISTINCT idHorarioEjecucion,p.horario,r.nombreRuta,r.idRuta,p.idPuntoPaseLista,p.idHorarioPerfil 
					FROM 3105_horarioEjecucionRuta h,3103_horariosPerfilRuta p,3100_rutasTransportes r,3102_perfilHorarioRuta ph,3104_marcadoresHorarioPerfilRuta
					m WHERE h.fecha='".$fecha."' AND p.idHorarioPerfil=h.idHorario AND ph.idPerfilHorario=p.idPerfilHorarioRuta AND  
					r.idRuta=ph.idRuta AND m.idHorario=h.idHorario AND m.idMarcador NOT IN(4) and h.idHorarioEjecucion not in (".$listaGuardias.")
					ORDER BY horario,nombreRuta";

		$res=$con->obtenerFilas($consulta);
		$numReg=0;
		$aRegistros="";
		while($fila=mysql_fetch_row($res))
		{
			if((!existeValor($arrPuntosPermitidos,$fila[4]))&&($fila[4]!=""))
					continue;
			$consulta="SELECT a.idUnidadAsignada,(select numEconomico from _1012_tablaDinamica  where id__1012_tablaDinamica=a.idUnidadAsignada),
						idChoferAsignado,a.situacion,a.idAsignacion FROM 3106_asignacionHorarioRuta a WHERE idHorarioAsignacion=".$fila[0]."";
			$fAsignacion=$con->obtenerPrimeraFila($consulta);
			
			switch($fAsignacion[3])
			{
				case "":
					$fAsignacion[0]="";
					$fAsignacion[1]="";
					$fAsignacion[2]="";
					$fAsignacion[3]=5;
					$fAsignacion[4]=-1;
				break;	
				
			}
			
			$puntoPaseLista="";
			if($fila[4]=="")
			{
				$consulta="SELECT COUNT(*) FROM 3104_marcadoresHorarioPerfilRuta WHERE idHorario=".$fila[5]." AND idMarcador=3";
				$nReg=$con->obtenerValor($consulta);
				if($nReg==0)
				{
					$puntoPaseLista="2) Horarios Abiertos";
					
				}
				else
				{
					$puntoPaseLista="3) Horarios Velada";
					
				}
			}
			else
			{
				
				$consulta="SELECT COUNT(*) FROM 3104_marcadoresHorarioPerfilRuta WHERE idHorario=".$fila[5]." AND idMarcador=4";
				$nReg=$con->obtenerValor($consulta);
				
				$consulta="SELECT nombreTerminal FROM _1010_tablaDinamica WHERE id__1010_tablaDinamica=".$fila[4];
				$nPaseLista=$con->obtenerValor($consulta);
				if($nReg==0)
				{
					$puntoPaseLista="1) Horarios de Arranque, pase de lista en: ".$nPaseLista;	
					
				}
				else
				{
					$puntoPaseLista="0) Horarios de Guardia, pase de lista en: ".$nPaseLista;	
					
				}
			}
			
			
			$datosCambioUnidad="";
			
			$motivoCambio="";
			$consulta="SELECT * FROM 1104_solicitudCambioUnidad WHERE idAsignacionCambio=".$fAsignacion[4]." and situacion=0";
			$fSolicitud=$con->obtenerPrimeraFila($consulta);
			if(!$fSolicitud)
			{
				
				$consulta="SELECT * FROM 1104_solicitudCambioUnidad WHERE idRutaReemplazo=".$fAsignacion[4]." and situacion=0";
				$fSolicitud=$con->obtenerPrimeraFila($consulta);
				if($fSolicitud)
				{
					$motivoCambio=$fSolicitud[5];
					if($fSolicitud[3]==0)
					{
						$ruta=obtenerNombreRutaAsignacion($fSolicitud[1]);
						$ruta=$ruta["nombreRuta"];
						$chofer1=obtenerNombreChofer($fSolicitud[14]);
						if($chofer1!="")
							$chofer1=" (Chofer asignado: ".cv($chofer1).")";
						$datosCambioUnidad="Esta unidad presenta una solicitud de cambio de unidad, reemplaza a la unidad: ".
						obtenerNumEconomicoIdUnidad($fSolicitud[12]).$chofer1." en la ruta: ".$ruta.". <br>Motivo: ".cv($motivoCambio);
					}
					else
					{
						$chofer1=obtenerNombreChofer($fSolicitud[14]);
						if($chofer1!="")
							$chofer1=" (Chofer asignado: ".cv($chofer1).")";
						$ruta=obtenerNombreRutaAsignacion($fSolicitud[1]);
						$ruta=$ruta["nombreRuta"];
						$datosCambioUnidad="Esta unidad presenta una solicitud de intercambio de unidad, intercambia horario con la unidad: ".
						obtenerNumEconomicoIdUnidad($fSolicitud[12]).$chofer1." en la ruta: ".$ruta.". <br>Motivo: ".cv($motivoCambio);
					}
				}
				
			}
			else
			{
				
				
				$motivoCambio=$fSolicitud[5];
				
				if($fSolicitud[3]==0)
				{
					$chofer1=obtenerNombreChofer($fSolicitud[13]);
					if($chofer1!="")
						$chofer1=" (Chofer asignado: ".cv($chofer1).")";
					$datosCambioUnidad="Esta unidad presenta una solicitud de cambio de unidad, será reemplazado por la unidad: ".
					obtenerNumEconomicoIdUnidad($fSolicitud[2]).$chofer1.". <br>Motivo: ".cv($motivoCambio);
				}
				else
				{
					$chofer1=obtenerNombreChofer($fSolicitud[13]);
					if($chofer1!="")
						$chofer1=" (Chofer asignado: ".cv($chofer1).")";
					$ruta=obtenerNombreRutaAsignacion($fSolicitud[3]);
					$ruta=$ruta["nombreRuta"];
					$datosCambioUnidad="Esta unidad presenta una solicitud de intercambio de unidad, intercambia horario con la unidad: ".
					obtenerNumEconomicoIdUnidad($fSolicitud[2]).$chofer1." en la ruta: ".$ruta.". <br>Motivo: ".cv($motivoCambio);
				}
			}
			
			$o='{"datosCambioUnidad":"'.cv($datosCambioUnidad).'","puntoPaseLista":"'.$puntoPaseLista.'","idUnidadAsignada":"'.$fAsignacion[0].'","idHorarioEjecucion":"'.$fila[0].'","ruta":"'.cv($fila[2]).'","idRuta":"'.$fila[3].'","unidad":"'.$fAsignacion[1].'","horario":"'.$fila[1].'","situacion":"'.$fAsignacion[3].'","idAsignacion":"'.$fAsignacion[4].'"}';	
			if($aRegistros=="")	
				$aRegistros=$o;
			else
				$aRegistros.=",".$o;
			$numReg++;
		}
		
		
		$consulta="SELECT p.idAccionOperativa FROM 3117_puntosControlAccionOperativa p,3118_usuariosPuntoControlAccionOperativa u WHERE 
				u.idAccionPuntoControl=p.idAccionPuntoControl AND u.idUsuario=".$_SESSION["idUsr"]." AND p.idPuntoControl in (".$idPuntoPaseLista.")";
				
		
		$permisos=$con->obtenerFilasArreglo($consulta);
		echo '{"permisos":"'.$permisos.'","numReg":"'.$numReg.'","registros":['.$aRegistros.']}';
	}
	
	function obtenerRolGuardiaDia()
	{
		global $con;
		$fecha=$_POST["fecha"];
		
		$idPuntoPaseLista=-1;
		
		$comp="";
		if(isset($_POST["idPuntoPaseLista"])&&($_POST["idPuntoPaseLista"]!=""))
		{
			$comp=" and p.idPuntoPaseLista in (".$_POST["idPuntoPaseLista"].")";
			$idPuntoPaseLista=$_POST["idPuntoPaseLista"];
		}
		
		$consulta="SELECT DISTINCT idHorarioEjecucion,p.horario,r.nombreRuta,r.idRuta 
					FROM 3105_horarioEjecucionRuta h,3103_horariosPerfilRuta p,3100_rutasTransportes r,3102_perfilHorarioRuta ph,3104_marcadoresHorarioPerfilRuta
					m WHERE h.fecha='".$fecha."' AND p.idHorarioPerfil=h.idHorario AND ph.idPerfilHorario=p.idPerfilHorarioRuta AND  
					r.idRuta=ph.idRuta AND m.idHorario=h.idHorario AND m.idMarcador =4 ".$comp."
					ORDER BY horario,nombreRuta";

		$res=$con->obtenerFilas($consulta);
		$numReg=0;
		$aRegistros="";
		while($fila=mysql_fetch_row($res))
		{
			$datosCambioUnidad="";
			
						
			$consulta="SELECT a.idUnidadAsignada,(select numEconomico from _1012_tablaDinamica  where id__1012_tablaDinamica=a.idUnidadAsignada),
						idChoferAsignado,a.situacion,a.idAsignacion,idUnidadAsignada FROM 3106_asignacionHorarioRuta a WHERE idHorarioAsignacion=".$fila[0]."";
			$fAsignacion=$con->obtenerPrimeraFila($consulta);
			$idUnidadReemplazante=-1;
			if(isset($fAsignacion[5])&&($fAsignacion[5]!=""))
				$idUnidadReemplazante=$fAsignacion[5];
			$consulta="SELECT * FROM 1104_solicitudCambioUnidad WHERE idUnidadReemplazante=".$idUnidadReemplazante." and situacion=0";
			$fSolicitud=$con->obtenerPrimeraFila($consulta);
			if($fSolicitud)
			{
				
				$motivoCambio=$fSolicitud[5];
				if($fSolicitud[3]==0)
				{
					$ruta=obtenerNombreRutaAsignacion($fSolicitud[1]);
					$ruta=$ruta["nombreRuta"];
					$chofer1=obtenerNombreChofer($fSolicitud[14]);
					if($chofer1!="")
						$chofer1=" (Chofer asignado: ".cv($chofer1).")";
					$datosCambioUnidad="Esta unidad presenta una solicitud de cambio de unidad, reemplaza a la unidad: ".
					obtenerNumEconomicoIdUnidad($fSolicitud[12]).$chofer1.". en la ruta: ".$ruta." <br>Motivo: ".cv($motivoCambio);
				}
				else
				{
					$chofer1=obtenerNombreChofer($fSolicitud[14]);
					if($chofer1!="")
						$chofer1=" (Chofer asignado: ".cv($chofer1).")";
					$ruta=obtenerNombreRutaAsignacion($fSolicitud[1]);
					$ruta=$ruta["nombreRuta"];
					$datosCambioUnidad="Esta unidad presenta una solicitud de intercambio de unidad, intercambia horario con la unidad: ".
					obtenerNumEconomicoIdUnidad($fSolicitud[12]).$chofer1." en la ruta: ".$ruta.". <br>Motivo: ".cv($motivoCambio);
				}
				
				
			}
			
			
			
			$o='{"datosCambioUnidad":"'.cv($datosCambioUnidad).'","idUnidadAsignada":"'.$fAsignacion[0].'","idHorarioEjecucion":"'.$fila[0].'","ruta":"'.cv($fila[2]).'","idRuta":"'.$fila[3].'","unidad":"'.$fAsignacion[1].'","horario":"'.$fila[1].'","situacion":"'.$fAsignacion[3].'","idAsignacion":"'.$fAsignacion[4].'"}';	
			if($aRegistros=="")	
				$aRegistros=$o;
			else
				$aRegistros.=",".$o;
			$numReg++;
		}
		
		
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$aRegistros.']}';
	}
		
	function registrarAsistenciaUnidad()
	{
		global $con;
		$idUnidad=$_POST["idUnidad"];
		$idChofer=$_POST["idChofer"];
		$idAsignacion=$_POST["idAsignacion"];
		
		$objTarjeta=$_POST["objTarjeta"];
		$fecha=date("Y-m-d");
		$asignoRuta=0;
		$lblRutaAsignada="";
		if($idAsignacion=="")
		{
			$resultado=asignarSiguienteRutaDisponible($fecha,$idUnidad,$idChofer);
			$idAsignacion=$resultado["idAsignacion"];	
			$asignoRuta=1;		
			$lblRutaAsignada=$resultado["rutaAsignada"];
		}
			
		$comentarios=$_POST["comentarios"];
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="INSERT INTO 3109_datosPaseLista(idUnidad,idChofer,fechaLista,horaRegistro,idResponsable,datosComplementarios,idAsignacion)
					VALUES(".$idUnidad.",".$idChofer.",'".date("Y-m-d")."','".date("H:i:s")."',".$_SESSION["idUsr"].",'{\"comentarios\":\"".cv($comentarios)."\"}',".
					$idAsignacion.")";
		$x++;
		
		$query[$x]="UPDATE 3106_asignacionHorarioRuta SET idChoferAsignado=".$idChofer." WHERE idAsignacion=".$idAsignacion;
		$x++;
		if($objTarjeta!="")
		{
			$oTarjeta=json_decode($objTarjeta);
			registrarArmadoTarjeta($query,$x,$oTarjeta,$idAsignacion);
			
		}
		
		
		$query[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($query))
		{
			cambiarSituacionAsignacionRuta($idAsignacion,2);
			echo "1|".$asignoRuta."|".$lblRutaAsignada;
		}
		
	}
	
	function buscarDatosUnidad()
	{
		global $con;
		$unidad=$_POST["unidad"];
		$fechaActual=$_POST["fecha"];
		$consulta="SELECT * FROM _1012_tablaDinamica WHERE idEstado=2 AND numEconomico=".$unidad;
		$fUnidad=$con->obtenerPrimeraFila($consulta);
		if(!$fUnidad)
			echo "1|-1";
		else
		{
			$consulta="SELECT nombreMarca FROM _1011_tablaDinamica WHERE id__1011_tablaDinamica=".$fUnidad[15];
			$marca=$con->obtenerValor($consulta);
			
			if($fUnidad[12]=="")
				$fUnidad[12]=-1;
			$nombre=obtenerNombreUsuario($fUnidad[12]);
			
			
			
			$consulta="SELECT idHorarioAsignacion,idAsignacion FROM 3106_asignacionHorarioRuta a WHERE fecha='".$fechaActual."' AND idUnidadAsignada=".$fUnidad[0]." AND a.situacion=1";
			$fAsig=$con->obtenerPrimeraFila($consulta);
			
			$idHorarioAsignacion=$fAsig[0];
			$idAsignacion=$fAsig[1];
			if($idHorarioAsignacion=="")
				$idHorarioAsignacion=-1;
			$consulta="SELECT p.horario,r.nombreRuta  FROM 3105_horarioEjecucionRuta h,3103_horariosPerfilRuta p,3100_rutasTransportes r WHERE h.idHorarioEjecucion=".$idHorarioAsignacion." AND  p.idHorarioPerfil=h.idHorario
					AND r.idRuta=h.idRuta";
			$fRuta=$con->obtenerPrimeraFila($consulta);
			
			echo '1|{"marca":"'.cv($marca).'","modelo":"'.$fUnidad[14].'","noPlacas":"'.$fUnidad[16].'","noMotor":"'.$fUnidad[13].'","propietario":"'.cv($nombre).'","ruta":"['.$fRuta[0].'] '.cv($fRuta[1]).'","idAsignacion":"'.$idAsignacion.'","idUnidad":"'.$fUnidad[0].'"}';	
		}
		
	}
	
	function buscarChofer()
	{
		global $con;
		
		$considerarActivos=1;
		$valorBusqueda=$_POST["valorBusqueda"];
		if(isset($_POST["considerarActivos"]))
			$considerarActivos=$_POST["considerarActivos"];
			
		$consulta="SELECT * FROM (SELECT id__1013_tablaDinamica as idChofer,CONCAT(aPaterno,' ',aMaterno,' ',nombre) AS nombre,idEstado FROM _1013_tablaDinamica ORDER BY aPaterno,aMaterno,nombre) AS tmp WHERE nombre LIKE '%".$valorBusqueda."%'";	
		if($considerarActivos==1)
			$consulta.=" and idEstado=2 order by nombre";
		else
			$consulta.=" and idEstado in (2,3,4) order by nombre";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function buscarDatosChofer()
	{
		
		global $con;
		$idChofer=$_POST["idChofer"];	
		$consulta="SELECT * FROM _1013_tablaDinamica WHERE id__1013_tablaDinamica=".$idChofer;
		$fChofer=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT idArchivoImagen FROM 9058_imagenesControlGaleria where idElementoFormulario=8650 AND idRegistro=".$fChofer[0];
		$idArchivo=$con->obtenerValor($consulta);
		$imagen="";
		if($idArchivo=="")
			$imagen="../images/imgNoDisponible.jpg";
		else
			$imagen="../paginasFunciones/obtenerArchivos.php?id=".bE($idArchivo);
		
		$edad="";
		$consulta="SELECT l.numeroLicencia,l.fechaVigencia,t.tipoLicencia FROM _1018_tablaDinamica l,_1009_tablaDinamica t WHERE l.idReferencia=".$fChofer[0]." and '".date("Y-m-d")."'<=fechaVigencia and t.id__1009_tablaDinamica=l.cmbTipoLicencia ORDER BY fechaEmision DESC";
		$fLicencia=$con->obtenerPrimeraFila($consulta);
		$fNacimiento="";
		if($fChofer[21]!="")
		{
			$fNacimiento=date("d/m/Y",strtotime($fChofer[21]));
			$edad=obtenerEdad($fChofer[21]);
		}
		
		$vencimientoLicencia="";
		if($fLicencia[1]!="")
			$vencimientoLicencia=date("d/m/Y",strtotime($fLicencia[1]));
		$nombre=$fChofer[11]." ".$fChofer[12]." ".$fChofer[10];
		
		
		$tarjetas="";
		$consulta="SELECT colorTarjeta,folioTarjeta,situacion,idRegistro FROM 1108_asignacionTarjetaChofer WHERE idChofer=".$idChofer." AND situacion IN (1,2)";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$situacion="";
			if($fila[2]==2)
				$situacion=" - Asignada actualmente";
				
			$consulta="select color FROM _1031_tablaDinamica where id__1031_tablaDinamica=".$fila[0];
			$color=$con->obtenerValor($consulta);	
			$etiqueta=$fila[1]." (".$color.")".$situacion;
			
			$o="['".$fila[3]."','".$etiqueta."']";
			if($tarjetas=="")
				$tarjetas=$o;
			else
				$tarjetas.=",".$o;
		}
		$totalTarjeta=0;
		$consulta="SELECT idRegistro FROM 1108_asignacionTarjetaChofer WHERE idChofer=".$idChofer." AND situacion IN (2)";
		$tarjetaActiva=$con->obtenerValor($consulta);
		
		echo '1|{"tarjetaActiva":"'.$tarjetaActiva.'","tarjetas":['.$tarjetas.'],"totalTarjeta":"'.$totalTarjeta.'","nombre":"'.cv($nombre).'","fechaNacimiento":"'.$fNacimiento.'","edad":"'.$edad.'","tipoLicencia":"'.$fLicencia[2].'","vencimientoLicencia":"'.$vencimientoLicencia.'","numLicencia":"'.$fLicencia[0].'","imagen":"'.$imagen.'"}';
	}
	
	function evaluarComentariosUnidadChofer()
	{
		global $con;
		$tipoEvaluacion=$_POST["tipoEvaluacion"];//1Pase lista 2 Salida a ruta
		$fecha=$_POST["fecha"];
		$idUnidad=$_POST["idUnidad"];
		$idChofer=$_POST["idChofer"];
		
		
		$arrComentarios=array();
		
		//Unidad
		
		$cTmp='{"fecha":"","idPuntoControl":"","idUnidad":"'.$idUnidad.'","idChofer":"'.$idChofer.'"}';
		$objTmp=json_decode($cTmp);
		$objTmp->idUnidad=$idUnidad;
		$objTmp->fecha=$fecha;
		$cache=NULL;
		
		switch($tipoEvaluacion)
		{
			case 1:
			
				if($idUnidad!=-1)
				{
					$consulta="SELECT tipoValidacion,funcionValidacion,accion FROM _1033_gridFuncionesValidacionSalidaChofer where tipoValidacion=2";
					$res=$con->obtenerFilas($consulta);
					while($fila=mysql_fetch_row($res))
					{
						$oResp=resolverExpresionCalculoPHP($fila[1],$objTmp,$cache);	
						
						if($oResp["resultado"]==1)
						{
							$resp=array();	
							$resp["mensaje"]=$oResp["mensaje"];
							$resp["accion"]=$fila[2];
							$resp["tipoValidacion"]="Validación de unidad";
							$resp["icono"]="";
							if(isset($oResp["icono"]))
								$resp["icono"]=$oResp["icono"];
							array_push($arrComentarios,$resp);
						}
						
					}
				}
				//Chofer
				if($idChofer!=-1)
				{
					$consulta="SELECT tipoValidacion,funcionValidacion,accion FROM _1033_gridFuncionesValidacionSalidaChofer where tipoValidacion=1";
					$res=$con->obtenerFilas($consulta);
					while($fila=mysql_fetch_row($res))
					{
						$oResp=resolverExpresionCalculoPHP($fila[1],$objTmp,$cache);	
						
						if($oResp["resultado"]==1)
						{
							$resp=array();	
							$resp["mensaje"]=$oResp["mensaje"];
							$resp["accion"]=$fila[2];
							$resp["tipoValidacion"]="Validación de chofer";
							$resp["icono"]="";
							if(isset($oResp["icono"]))
								$resp["icono"]=$oResp["icono"];
							array_push($arrComentarios,$resp);
						}
						
					}
				}
			break;
			case 2:
				if($idUnidad!=-1)
				{
					$consulta="SELECT tipoEvaluacion,funcionValidacion,accion FROM _1033_gridEvaluacionSalida where tipoEvaluacion=2";
					$res=$con->obtenerFilas($consulta);
					while($fila=mysql_fetch_row($res))
					{
						$oResp=resolverExpresionCalculoPHP($fila[1],$objTmp,$cache);	
						
						if($oResp["resultado"]==1)
						{
							$resp=array();	
							$resp["mensaje"]=$oResp["mensaje"];
							$resp["accion"]=$fila[2];
							$resp["tipoValidacion"]="Validación de unidad";
							$resp["icono"]="";
							if(isset($oResp["icono"]))
								$resp["icono"]=$oResp["icono"];
							array_push($arrComentarios,$resp);
						}
						
					}
				}
				//Chofer
				if($idChofer!=-1)
				{
					
					$consulta="SELECT tipoEvaluacion,funcionValidacion,accion FROM _1033_gridEvaluacionSalida where tipoEvaluacion=1";
					$res=$con->obtenerFilas($consulta);
					while($fila=mysql_fetch_row($res))
					{
						$oResp=resolverExpresionCalculoPHP($fila[1],$objTmp,$cache);	
						
						if($oResp["resultado"]==1)
						{
							$resp=array();	
							$resp["mensaje"]=$oResp["mensaje"];
							$resp["accion"]=$fila[2];
							$resp["tipoValidacion"]="Validación de chofer";
							$resp["icono"]="";
							if(isset($oResp["icono"]))
								$resp["icono"]=$oResp["icono"];
							array_push($arrComentarios,$resp);
						}
						
					}
				}
			break;
			case 3:
				$idPuntoControl=$_POST["idPuntoControl"];
				
				$objTmp->idPuntoControl=$idPuntoControl;
				if($idUnidad!=-1)
				{
					$consulta="SELECT tipoEvaluacion,funcionEvaluacion,accion FROM _1033_gridEvaluacionesPuntoControl where tipoEvaluacion=2";
					$res=$con->obtenerFilas($consulta);
					while($fila=mysql_fetch_row($res))
					{
						$oResp=resolverExpresionCalculoPHP($fila[1],$objTmp,$cache);	
						
						if($oResp["resultado"]==1)
						{
							$resp=array();	
							$resp["mensaje"]=$oResp["mensaje"];
							$resp["accion"]=$fila[2];
							$resp["tipoValidacion"]="Validación de unidad";
							$resp["icono"]="";
							if(isset($oResp["icono"]))
								$resp["icono"]=$oResp["icono"];
							array_push($arrComentarios,$resp);
						}
						
					}
				}
				
				//Chofer
				if($idChofer!=-1)
				{
					$consulta="SELECT tipoEvaluacion,funcionEvaluacion,accion FROM _1033_gridEvaluacionesPuntoControl where tipoEvaluacion=1";
					$res=$con->obtenerFilas($consulta);
					while($fila=mysql_fetch_row($res))
					{
						$oResp=resolverExpresionCalculoPHP($fila[1],$objTmp,$cache);	
						
						if($oResp["resultado"]==1)
						{
							$resp=array();	
							$resp["mensaje"]=$oResp["mensaje"];
							$resp["accion"]=$fila[2];
							$resp["tipoValidacion"]="Validación de chofer";
							$resp["icono"]="";
							if(isset($oResp["icono"]))
								$resp["icono"]=$oResp["icono"];
							array_push($arrComentarios,$resp);
						}
						
					}
				}
			break;
		}
		
		
		$arrReg="";
		$numReg=0;
		if(sizeof($arrComentarios)>0)
		{
			foreach($arrComentarios as $c)	
			{
				$o='{"comentario":"'.cv($c["mensaje"]).'","tipoComentario":"'.$c["tipoValidacion"].'","icono":"'.$c["icono"].'","accion":"'.$c["accion"].'"}';	
				if($arrReg=="")
					$arrReg=$o;
				else
					$arrReg.=",".$o;
				$numReg++;
			}
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrReg.']}';
			
	}
		
	function buscarDatosAsignacion()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$unidad=-1;
		if(isset($_POST["unidad"]))
			$unidad=$_POST["unidad"];
		
		$idChofer=-1;
		if(isset($_POST["idChofer"]))
			$idChofer=$_POST["idChofer"];
		$fechaActual=$_POST["fecha"];
		$consulta="";
		$situacionesAdiciones="";
		if(isset($_POST["situacionesAdiciones"]))
			$situacionesAdiciones=",".$_POST["situacionesAdiciones"];
		
		
		$idPuntoControl=0;
		if(isset($_POST["puntoControl"]))
			$idPuntoControl=$_POST["puntoControl"];
		
		switch($criterio)
		{
			case "1":
				$consulta="SELECT id__1012_tablaDinamica FROM _1012_tablaDinamica WHERE numEconomico=".$unidad." AND idEstado=2";
				$idUnidad=$con->obtenerValor($consulta);
				if($idUnidad!="")
					$consulta="SELECT idAsignacion,idHorarioAsignacion,idUnidadAsignada,if(idChoferAsignado is null,-1,idChoferAsignado),idTarjeta FROM 3106_asignacionHorarioRuta 
					WHERE fecha='".$fechaActual."' AND idUnidadAsignada= ".$idUnidad." order by idAsignacion desc";
				else
				{
					echo "1|-1";	
					return;	
				}
					
			break;
			case "2":
				$consulta="SELECT idAsignacion,idHorarioAsignacion,idUnidadAsignada,if(idChoferAsignado is null,-1,idChoferAsignado),idTarjeta FROM 3106_asignacionHorarioRuta 
				WHERE fecha='".$fechaActual."' AND idChoferAsignado= ".$idChofer."  order by idAsignacion desc";
			break;
		}
		
		$fConsulta=$con->obtenerPrimeraFila($consulta);
		if($fConsulta)
		{
			$fPuntoControl=NULL;	
			if($idPuntoControl!=0)
			{
				
				$consulta="SELECT * FROM 3109_puntosControlRutaEjecucion WHERE idAsignacion=".$fConsulta[0]." AND idPuntoControl=".$idPuntoControl;	
				$fPuntoControl=$con->obtenerPrimeraFila($consulta);
				if(!$fPuntoControl)
				{
					echo '1|-3';
					return;	
				}
				
			}
			
			$idChofer=$fConsulta[3];
			$idUnidad=$fConsulta[2];
			$consulta="SELECT * FROM _1012_tablaDinamica WHERE idEstado=2 AND id__1012_tablaDinamica=".$fConsulta[2];
			$fUnidad=$con->obtenerPrimeraFila($consulta);

			$consulta="SELECT nombreMarca FROM _1011_tablaDinamica WHERE id__1011_tablaDinamica=".$fUnidad[15];
			$marca=$con->obtenerValor($consulta);
			
			if($fUnidad[12]=="")
				$fUnidad[12]=-1;
			$nombre=obtenerNombreUsuario($fUnidad[12]);
			
			$consulta="SELECT idHorarioAsignacion,idAsignacion,situacion FROM 3106_asignacionHorarioRuta a WHERE fecha='".$fechaActual."' AND idUnidadAsignada=".$fUnidad[0]." AND a.situacion in (1,2,7,11".$situacionesAdiciones.") order by idAsignacion asc";
			$fAsig=$con->obtenerPrimeraFila($consulta);
			
			$idHorarioAsignacion=$fAsig[0];
			$idAsignacion=$fAsig[1];
			if($idHorarioAsignacion=="")
				$idHorarioAsignacion=-1;
			$consulta="SELECT p.horario,r.nombreRuta  FROM 3105_horarioEjecucionRuta h,3103_horariosPerfilRuta p,3100_rutasTransportes r WHERE h.idHorarioEjecucion=".$idHorarioAsignacion." AND  p.idHorarioPerfil=h.idHorario
					AND r.idRuta=h.idRuta";
			$fRuta=$con->obtenerPrimeraFila($consulta);

			$datosUnidad='{"noEconomico":"'.$fUnidad[10].'","marca":"'.cv($marca).'","modelo":"'.$fUnidad[14].'","noPlacas":"'.$fUnidad[16].'","noMotor":"'.$fUnidad[13].
						'","propietario":"'.cv($nombre).'","ruta":"['.$fRuta[0].'] '.cv($fRuta[1]).'","idAsignacion":"'.$idAsignacion.'","idUnidad":"'.$fUnidad[0].'","situacionRuta":"'.$fAsig[2].'"}';	
			
			$consulta="SELECT * FROM _1013_tablaDinamica WHERE id__1013_tablaDinamica=".$fConsulta[3];
			$fChofer=$con->obtenerPrimeraFila($consulta);
			if($fChofer)
			{
				
			
				$consulta="SELECT idArchivoImagen FROM 9058_imagenesControlGaleria where idElementoFormulario=8650 AND idRegistro=".$fChofer[0];
				$idArchivo=$con->obtenerValor($consulta);
				$imagen="";
				if($idArchivo=="")
					$imagen="../images/imgNoDisponible.jpg";
				else
					$imagen="../paginasFunciones/obtenerArchivos.php?id=".bE($idArchivo);
				
				$edad="";
				$consulta="SELECT l.numeroLicencia,l.fechaVigencia,t.tipoLicencia FROM _1018_tablaDinamica l,_1009_tablaDinamica t WHERE l.idReferencia=".$fChofer[0]." and '".date("Y-m-d")."'<=fechaVigencia and t.id__1009_tablaDinamica=l.cmbTipoLicencia ORDER BY fechaEmision DESC";
	
				$fLicencia=$con->obtenerPrimeraFila($consulta);
				$fNacimiento="";
				if($fChofer[21]!="")
				{
					$fNacimiento=date("d/m/Y",strtotime($fChofer[21]));
					$edad=obtenerEdad($fChofer[21]);
				}
				
				$vencimientoLicencia="";
				if($fLicencia[1]!="")
					$vencimientoLicencia=date("d/m/Y",strtotime($fLicencia[1]));
					
				$datosChofer='{"nombreChofer":"'.cv($fChofer[11]).' '.cv($fChofer[12]).' '.cv($fChofer[10]).'","fechaNacimiento":"'.$fNacimiento.'","edad":"'.$edad.'","tipoLicencia":"'.$fLicencia[2].'","vencimientoLicencia":"'.$vencimientoLicencia.'","numLicencia":"'.$fLicencia[0].'","imagen":"'.$imagen.'"}';
			}
			else
			{
				$datosChofer='{"nombreChofer":"","fechaNacimiento":"","edad":"","tipoLicencia":"","vencimientoLicencia":"","numLicencia":"","imagen":"../images/imgNoDisponible.jpg"}';
			}
			$idAsignacionTarjeta=$fConsulta[4];
			
			
			$folioTA="";
			$colorTA="";
			$tarjetas="";
			$consulta="SELECT colorTarjeta,folioTarjeta,situacion,idRegistro FROM 1108_asignacionTarjetaChofer WHERE idChofer=".$idChofer." AND situacion IN (1,2)";
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$situacion="";
				if($fila[2]==2)
				{
					if($idAsignacionTarjeta=="")
						$idAsignacionTarjeta=$fila[3];
					$situacion=" - Asignada actualmente";
				}
				$consulta="select color FROM _1031_tablaDinamica where id__1031_tablaDinamica=".$fila[0];
				$color=$con->obtenerValor($consulta);	
				$etiqueta=$fila[1]." (".$color.")".$situacion;
				
				$o="['".$fila[3]."','".$etiqueta."']";
				if($tarjetas=="")
					$tarjetas=$o;
				else
					$tarjetas.=",".$o;
				
				if($fila[2]==2)
				{
					$folioTA=$fila[1];
					$colorTA=$color;	
				}
					
			}
			
			$consulta="SELECT idRegistro FROM 1108_asignacionTarjetaChofer WHERE idChofer=".$idChofer." AND situacion IN (2)";
			
			$tarjetaActiva=$con->obtenerValor($consulta);
			
			$idTarjeta=-1;
			$datosTarjeta= '{"tarjetaActiva":"'.$idAsignacionTarjeta.'","registros":['.$tarjetas.'],"folio":"'.$folioTA.'","color":"'.$colorTA.'"}';
			
			
			$cadObj='{"idUnidad":"'.$idUnidad.'","idChofer":"'.$idChofer.'","idTarjeta":"'.$idTarjeta.'","idAsignacionTarjeta":"'.$idAsignacionTarjeta.'","idAsignacion":"'.$fConsulta[0].
						'","datosUnidad":'.$datosUnidad.',"datosChofer":'.$datosChofer.',"datosTarjeta":'.$datosTarjeta.'}';
			echo '1|'.$cadObj;	
		}
		else
		{
			echo "1|-2";	
		}
		
	}
	
	function registrarSalidaUnidad()
	{
		global $con;
		$idAsignacionTarjeta=$_POST["idAsignacionTarjeta"];
		$idUnidad=$_POST["idUnidad"];
		$idChofer=$_POST["idChofer"];
		$idAsignacion=$_POST["idAsignacion"];
		$comentarios=$_POST["comentarios"];
		$objTarjeta=$_POST["objTarjeta"];
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="UPDATE 3106_asignacionHorarioRuta SET situacion=11,horaSalida='".date("Y-m-d H:i:s")."',responsableAutorizacionSalida=".$_SESSION["idUsr"]." WHERE idAsignacion=".$idAsignacion;
		$x++;
		
		if($objTarjeta!="")
		{
			$oTarjeta=json_decode($objTarjeta);
			registrarArmadoTarjeta($consulta,$x,$oTarjeta,$idAsignacion);
			
		}
		
		
		$consulta[$x]="commit";
		$x++;
		
		
		if($con->ejecutarBloque($consulta))
		{
			cambiarSituacionAsignacionRuta($idAsignacion,11,$comentarios,0);
			cambiarSituacionAsignacionRuta($idAsignacion,3,$comentarios,0);
			
/*			$consulta="update 1103_asignacionTarjetaFecha set situacion=2 where idAsignacion=".$idAsignacionTarjeta;
			$con->ejecutarConsulta($consulta);
*/			
			
			registrarPuntosControlRuta($idAsignacion);
			$query="SELECT funcionAccion FROM _1033_gridFuncionesAccion WHERE accion=4";
			$res=$con->obtenerFilas($query);
			$cTmp='{"idAsignacion":""}';
			$objTmp=json_decode($cTmp);
			$objTmp->idAsignacion=$idAsignacion;
			$cache=NULL;
			while($fila=mysql_fetch_row($res))
			{
				$oResp=resolverExpresionCalculoPHP($fila[0],$objTmp,$cache);			
			}
			echo "1|";
		}
	}
		
	function verificarFoliosBajaIntervalo()
	{
		global $con;
		$folioInicial=$_POST["folioInicial"];
		$folioFinal=$_POST["folioFinal"];
		$idTalon=$_POST["idTalon"];
		
		$foliosBaja=obtenerTotalFoliosBaja($idTalon,$folioInicial,$folioFinal);
		echo "1|".$foliosBaja;
		
		
	}
		
	function registrarIngresoPuntoControl()
	{
		global $con;

		$registroAjuste=0;
		if(isset($_POST["registroAjuste"]))
			$registroAjuste=$_POST["registroAjuste"];
		
		$oSigRuta=1;
		if(isset($_POST["oSigRuta"]))
			$oSigRuta=$_POST["oSigRuta"];
		
		$query="SELECT metodoRegistroBoletoPuntoControl FROM _1033_tablaDinamica";
		$metodoRegistroBoletoPuntoControl=$con->obtenerValor($query);
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$horaRegistro=date("H:i:s");
		$query="SELECT idChofer FROM 1108_asignacionTarjetaChofer WHERE idRegistro=".$obj->idAsignacionTarjeta;//--
		$idChofer=$con->obtenerValor($query);

		$idPuntoControlEjecucion=$obj->idPuntoControlEjecucion;
		
		$query="SELECT idPuntoRecorrido FROM 3109_puntosControlRutaEjecucion WHERE idPuntoControlEjecucion=".$idPuntoControlEjecucion;
		$idPuntoRecorrido=$con->obtenerValor($query);
		$tipoPunto="";
		if($idPuntoRecorrido!="")
		{
			$query="SELECT tipoPunto  FROM 3101_puntosRecorridoRuta WHERE idPuntoRecorrido=".$idPuntoRecorrido;
			$tipoPunto=$con->obtenerValor($query);
		}
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="UPDATE 3109_puntosControlRutaEjecucion SET horaLlegadaRegistrada='".$horaRegistro."',horaSalidaPunto='".$horaRegistro."', responsableRegistro=".$_SESSION["idUsr"].", situacion=2,comentarios='".cv($obj->comentarios)."' 
					WHERE idPuntoControlEjecucion=".$idPuntoControlEjecucion;
		$x++;
		$consulta[$x]="DELETE FROM 3110_tarjetaRegistroPuntoControl WHERE idPuntoControlRuta=".$idPuntoControlEjecucion;
		$x++;
		
		foreach($obj->tarjeta as $r)
		{
			if($r->total=="")
				$r->total=0;
			
			$consulta[$x]="INSERT INTO 3110_tarjetaRegistroPuntoControl(folioTalon,folioInicial,folioFinal,folioActual,folioBaja,total,montoTotal,idPuntoControlRuta,costoUnitario,tipoFolio,registroAjuste,ultimoFolioVendido)
						VALUES(".$r->folioTalon.",".$r->folioInicial.",".$r->folioFinal.",".$r->folioActual.",".$r->folioBaja.",".$r->total.",".$r->montoTotal.",".$idPuntoControlEjecucion.",".$r->costoUnitario.
						",".$metodoRegistroBoletoPuntoControl.",".$registroAjuste.",".$r->ultimoFolioVendido.")";
			$x++;
			
			$boletosExistencia=0;
			$totalFoliosBajas=0;
			$boletosExistencia=0;
			
			if($r->folioActual!=0)
			{
				$totalFoliosBajas=obtenerTotalFoliosBaja($r->folioTalon,($r->folioActual+$metodoRegistroBoletoPuntoControl),$r->folioFinal);	
				$boletosExistencia=1+($r->folioFinal-($r->folioActual+$metodoRegistroBoletoPuntoControl))-$totalFoliosBajas;
			}
			else
			{
				$fActual=$r->folioActual;
				if($metodoRegistroBoletoPuntoControl==0)//folio actual
				{
					$boletosExistencia=0;
				}
				else
				{  //Ultimo boleto vendido
					
					$fActual=$r->folioInicial;
					if($r->ultimoFolioVendido!=-1)
					{
						$fActual=$r->ultimoFolioVendido+1;
					}
					//$query="SELECT folioActual FROM 1102_talonesBoletos WHERE idTalon=".$r->folioTalon;
					//$fActual=$con->obtenerValor($query);
					
					$totalFoliosBajas=obtenerTotalFoliosBaja($r->folioTalon,($fActual),$r->folioFinal);	
					$boletosExistencia=1+($r->folioFinal-$fActual)-$totalFoliosBajas;
					$r->folioActual=$fActual-1;
				}
			}
			
			$situacionBoleto=2;
			$situacionAsignacion=1;
			if($boletosExistencia==0)
			{
				$situacionBoleto=4;
				$r->folioActual=-1;
				$situacionAsignacion=4;
			}
			else
				$r->folioActual+=$metodoRegistroBoletoPuntoControl;
			
			$actualizarFolioActual=true;
			if($r->total!=0)
			{
				$query="select folioActual from 1102_talonesBoletos where idTalon=".$r->folioTalon;
				$folioActualBD=$con->obtenerValor($query);
				if(($r->folioActual<$folioActualBD)&&($r->folioActual!=-1))
					$actualizarFolioActual=false;
					
					
				$query="SELECT idDetalle FROM 1102_detalleTarjetaAsignada WHERE idAsignacion=".$obj->idAsignacionTarjeta." AND idTalon=".$r->folioTalon." ORDER BY idDetalle DESC";	
				$idDetalle=$con->obtenerValor($query);
				
				
				if($boletosExistencia==0)	
				{
					
					$query="SELECT DISTINCT idAsignacion FROM 1102_detalleTarjetaAsignada WHERE idTalon=".$r->folioTalon." AND idDetalle>".$idDetalle." order by idDetalle asc";
					$rAsignacion=$con->obtenerFilas($query);
					while($fAsignacion=mysql_fetch_row($rAsignacion))
					{
						$query="SELECT idAsignacion FROM 3106_asignacionHorarioRuta WHERE idTarjeta=".$fAsignacion[0]." ORDER BY idAsignacion ASC";
						$rAsignacionesRuta=$con->obtenerFilas($query);
						while($fAsignacionRuta=mysql_fetch_row($rAsignacionesRuta))
						{
						
							$query="SELECT idPuntoControlEjecucion FROM 3109_puntosControlRutaEjecucion WHERE idAsignacion=".$fAsignacionRuta[0] ;
							$lPuntosControl=$con->obtenerListaValores($query);
							if($lPuntosControl=="")
								$lPuntosControl=-1;
							
						
							$consulta[$x]="delete from 3110_tarjetaRegistroPuntoControl where folioTalon=".$r->folioTalon." and idPuntoControlRuta in(".$lPuntosControl.")";
							$x++;	
									
						}
						
						
						$consulta[$x]="delete from 1102_detalleTarjetaAsignada where idTalon=".$r->folioTalon." and idAsignacion=".$fAsignacion[0];
						$x++;
						
						
					}
					
					
					
					
					
				}
				else
				{
					
					$query="SELECT DISTINCT idAsignacion FROM 1102_detalleTarjetaAsignada WHERE idTalon=".$r->folioTalon." AND idDetalle>".$idDetalle." and folioInicial<=".$r->folioActual." order by idDetalle asc";
					
					
					$rAsignacion=$con->obtenerFilas($query);
					while($fAsignacion=mysql_fetch_row($rAsignacion))
					{
						
						$query="select * from 1102_detalleTarjetaAsignada WHERE idTalon=".$r->folioTalon." and idAsignacion=".$fAsignacion[0];
						
						$fRegistroAsignacion=$con->obtenerPrimeraFila($query);	
						
						$foliosBaja=obtenerTotalFoliosBaja($r->folioTalon,$r->folioActual,$fRegistroAsignacion[4]);
						
						$total=($fRegistroAsignacion[4]-$r->folioActual-$foliosBaja)+1;
						if($total<0)	
							$total=0;
						
						$montoTotal=$total*$fRegistroAsignacion[2];
						$consulta[$x]="UPDATE 1102_detalleTarjetaAsignada SET folioInicial=".$r->folioActual.",foliosBaja=".$foliosBaja.",total=".$total.",montoTotal=".$montoTotal." WHERE idDetalle=".$fRegistroAsignacion[0];
						$x++;
						
						
						$query="SELECT idAsignacion FROM 3106_asignacionHorarioRuta WHERE idTarjeta=".$fAsignacion[0]." ORDER BY idAsignacion ASC";

						$rAsignacionesRuta=$con->obtenerFilas($query);
						while($fAsignacionRuta=mysql_fetch_row($rAsignacionesRuta))
						{
						
							$query="SELECT idPuntoControlEjecucion FROM 3109_puntosControlRutaEjecucion WHERE idAsignacion=".$fAsignacionRuta[0] ;
							$lPuntosControl=$con->obtenerListaValores($query);
							if($lPuntosControl=="")
								$lPuntosControl=-1;
							
							$query="SELECT * FROM 3110_tarjetaRegistroPuntoControl where folioTalon=".$r->folioTalon." and idPuntoControlRuta in(".$lPuntosControl.") and folioInicial<=".$r->folioActual;
							$registroTPC=$con->obtenerFilas($query);
							while($fTPC=mysql_fetch_row($registroTPC))
							{
								$uBoletoVendido=$fTPC[4];
								if($uBoletoVendido==0)
								{
									if($fTPC[10]==0)
										$uBoletoVendido=$fTPC[3];	
									else
									{
										$uBoletoVendido=$fTPC[12];
										if($uBoletoVendido==-1)
											$uBoletoVendido=$ultimoBoletoVendidoActualTalon;
									}
								}
								else
									if($fTPC[10]==0)
										$uBoletoVendido--;	
								
								
								$foliosBaja=obtenerTotalFoliosBaja($r->folioTalon,$r->folioActual,$uBoletoVendido);
								$total=($uBoletoVendido-$r->folioActual-$foliosBaja)+1;
								if($total<0)	
									$total=0;
								
								$montoTotal=$total*$fTPC[9];
								$compDetalle="";
								if(($fTPC[2]==$fTPC[4])||($fTPC[4]<$r->folioActual))
									$compDetalle=",folioActual=".$r->folioActual;
								$consulta[$x]="UPDATE 3110_tarjetaRegistroPuntoControl SET folioInicial=".$r->folioActual.",folioBaja=".$foliosBaja.",total=".$total.",montoTotal=".$montoTotal.$compDetalle." WHERE idRegistro=".$fTPC[0];
								$x++;
							}
						}
												
					}
					
				}
					
			}	
				
			if($actualizarFolioActual)	
			{
				$consulta[$x]="UPDATE 1102_talonesBoletos SET folioActual=".($r->folioActual).",boletosExistencia=".$boletosExistencia.",situacion=".$situacionBoleto." WHERE idTalon=".$r->folioTalon;
				$x++;
				
				$query="SELECT idAsignacion FROM 1105_asignacionBoletosChofer WHERE folioTalon=".$r->folioTalon." AND idChofer=".$idChofer." ORDER BY idAsignacion DESC";
				$idAsignacionBoleto=$con->obtenerValor($query);
				$consulta[$x]="UPDATE 1105_asignacionBoletosChofer SET folioActual=".($r->folioActual).", situacion=".$situacionAsignacion." WHERE idAsignacion=".$idAsignacionBoleto;
				$x++;
			}
			
			
		}
		
		if($tipoPunto==2)
		{
			$consulta[$x]="UPDATE 3106_asignacionHorarioRuta SET horaLlegada='".date("Y-m-d H:i:s")."' WHERE idAsignacion=".$obj->idAsignacion;
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			$lblRutaAsignada="";
			switch($tipoPunto)
			{
				case 2://Terminal
					$query="SELECT funcionAccion FROM _1033_gridFuncionesAccion WHERE accion=1";
					cambiarSituacionAsignacionRuta($obj->idAsignacion,4,$obj->comentarios,0);
					$queryAux="SELECT idUnidadAsignada,idChoferAsignado FROM 3106_asignacionHorarioRuta WHERE idAsignacion=".$obj->idAsignacion;
					$fAux=$con->obtenerPrimeraFila($queryAux);
					/*if($oSigRuta==1)
					{
						$resultado=asignarSiguienteRutaDisponible(date("Y-m-d"),$fAux[0],$fAux[1]);
						$lblRutaAsignada=$resultado["rutaAsignada"];
					}*/
					
				break;	
				case 6://Punto de control
					$query="SELECT funcionAccion FROM _1033_gridFuncionesAccion WHERE accion=3";
				break;	
			}
			$res=$con->obtenerFilas($query);
			
			
			$cTmp='{"idPuntoControl":"","idAsignacion":"","idPuntoControlEjecucion":""}';
			$objTmp=json_decode($cTmp);
			$objTmp->idPuntoControl=$obj->idPuntoControl;
			$objTmp->idPuntoControlEjecucion=$idPuntoControlEjecucion;
			$objTmp->idAsignacion=$obj->idAsignacion;
			$cache=NULL;
			
			while($fila=mysql_fetch_row($res))
			{
				$oResp=resolverExpresionCalculoPHP($fila[0],$objTmp,$cache);			
			}
			
			echo "1|".$lblRutaAsignada;
		}			
	}
		
	function buscarDatosTarjeta()
	{
		global $con;
		$pComision=15;
		$idTarjeta=$_POST["idTarjeta"];
		$color=$_POST["color"];
		$oURutaActiva=false;
		if(isset($_POST["oURutaActiva"]))
			$oURutaActiva=($_POST["oURutaActiva"]==1)?true:false;
		
		
		$arrResumenBoletos=array();
		
		$consulta="SELECT idTarjetaInventario FROM 1101_tarjetasInventario WHERE folio='".$idTarjeta."' AND color=".$color." and situacion in(1)";
		$idTarjetaInventario=$con->obtenerValor($consulta);
		if($idTarjetaInventario=="")
			$idTarjetaInventario=-2;
		$consulta="SELECT idRegistro FROM 1108_asignacionTarjetaChofer WHERE idTarjeta=".$idTarjetaInventario." and situacion in (2,5)";
		$idAsignacionTarjeta=$con->obtenerValor($consulta);
		if($idAsignacionTarjeta=="")
			$idAsignacionTarjeta=-2;
		$consulta="SELECT * FROM 3106_asignacionHorarioRuta WHERE idTarjeta=".$idAsignacionTarjeta."  ORDER BY idAsignacion DESC LIMIT 0,1";
		$fConsulta=$con->obtenerPrimeraFila($consulta);
		
		if($fConsulta)
		{
			
			$idChofer=$fConsulta[3];
			$idUnidad=$fConsulta[2];
			$consulta="SELECT * FROM _1012_tablaDinamica WHERE idEstado=2 AND id__1012_tablaDinamica=".$fConsulta[2];
			$fUnidad=$con->obtenerPrimeraFila($consulta);
			$socio=$fUnidad[12];
			
			
			$consulta="SELECT nombreMarca FROM _1011_tablaDinamica WHERE id__1011_tablaDinamica=".$fUnidad[15];
			$marca=$con->obtenerValor($consulta);
			
			if($fUnidad[12]=="")
				$fUnidad[12]=-1;
			$nombre=obtenerNombreUsuario($fUnidad[12]);
			
			
			$arrFoliosTarjeta=array();	
			$consulta="SELECT idTalon FROM 1102_detalleTarjetaAsignada WHERE idAsignacion=".$idAsignacionTarjeta;
			$rFolios=$con->obtenerFilas($consulta);
			while($fFolios=mysql_fetch_row($rFolios))
			{
				$arrFoliosTarjeta[$fFolios[0]]	=1;
			}
			
			$arrFolioTalon=array();
			
			$arrRutas="";
			/*$consulta="SELECT * FROM 3106_asignacionHorarioRuta WHERE idTarjeta=".$idAsignacionTarjeta."  ORDER BY idAsignacion";
			$resAsignacion=$con->obtenerFilas($consulta);*/
			$consulta="select distinct * from ((SELECT idAsignacion FROM 3106_asignacionHorarioRuta WHERE idTarjeta=".$idAsignacionTarjeta.") 
						union 
						(SELECT idAsignacionRuta FROM 3122_tarjetasAsignadasRecorridosInconclusos WHERE idAsignacionTarjeta=".$idAsignacionTarjeta.")) as tmp  ORDER BY idAsignacion";
			$resAsignacion=$con->obtenerFilas($consulta);
			while($fAsignacion=mysql_fetch_row($resAsignacion))
			{
				$consulta="SELECT idHorarioAsignacion,idAsignacion FROM 3106_asignacionHorarioRuta a WHERE idAsignacion=".$fAsignacion[0];
				$fAsig=$con->obtenerPrimeraFila($consulta);
				
				$idHorarioAsignacion=$fAsig[0];
				$idAsignacion=$fAsig[1];
				if($idHorarioAsignacion=="")
					$idHorarioAsignacion=-1;
				$consulta="SELECT p.horario,r.nombreRuta,fecha  FROM 3105_horarioEjecucionRuta h,3103_horariosPerfilRuta p,3100_rutasTransportes r WHERE h.idHorarioEjecucion=".$idHorarioAsignacion." AND  p.idHorarioPerfil=h.idHorario
						AND r.idRuta=h.idRuta";
				$fRuta=$con->obtenerPrimeraFila($consulta);

				$nomRuta='['.date("d/m/Y",strtotime($fRuta[2]))." - ".$fRuta[0].'] '.$fRuta[1];
				
				$consulta="SELECT distinct idPuntoControlEjecucion,idPuntoControl,nombreTerminal,horaLlegadaRegistrada FROM 3109_puntosControlRutaEjecucion p,_1010_tablaDinamica t,3110_tarjetaRegistroPuntoControl r WHERE 
							idAsignacion=".$fAsignacion[0]." AND p.situacion=2 and r.idPuntoControlRuta=p.idPuntoControlEjecucion
							AND t.id__1010_tablaDinamica=p.idPuntoControl order by r.idRegistro";

				$resPuntoControl=$con->obtenerFilas($consulta);
				while($fPuntoControl=mysql_fetch_row($resPuntoControl))
				{

					$consulta="SELECT * FROM 3110_tarjetaRegistroPuntoControl WHERE idPuntoControlRuta=".$fPuntoControl[0]." and ignorarRegistro=0 ORDER BY idRegistro";
					$resTarjetaPunto=$con->obtenerFilas($consulta);
					while($fTarjetaPunto=mysql_fetch_row($resTarjetaPunto))
					{
						if(isset($arrFoliosTarjeta[$fTarjetaPunto[1]]))
						{
							if(!isset($arrFolioTalon[$fTarjetaPunto[1]]))
							{
								$arrFolioTalon[$fTarjetaPunto[1]]["folioInicial"]=$fTarjetaPunto[2];	
							}
							$arrFolioTalon[$fTarjetaPunto[1]]["folioFinal"]=$fTarjetaPunto[3];	
							
							if($arrFolioTalon[$fTarjetaPunto[1]]["folioInicial"]==-1)
							{
								$consultaUpdate="update 3110_tarjetaRegistroPuntoControl set ignorarRegistro=1 where idRegistro=".$fTarjetaPunto[0];
								$con->ejecutarConsulta($consultaUpdate);
								continue;
							}
							
							$folioInicial=$arrFolioTalon[$fTarjetaPunto[1]]["folioInicial"];
							
							
							
							$folioFinal=$arrFolioTalon[$fTarjetaPunto[1]]["folioFinal"];
							
							
							if($fTarjetaPunto[10]==1)
							{
								if($fTarjetaPunto[4]!=0)
									$arrFolioTalon[$fTarjetaPunto[1]]["folioInicial"]=$fTarjetaPunto[4]+1;
	
							}
							else
							{
								if($fTarjetaPunto[4]!=0)
									$arrFolioTalon[$fTarjetaPunto[1]]["folioInicial"]=$fTarjetaPunto[4];
								else
									$arrFolioTalon[$fTarjetaPunto[1]]["folioInicial"]=-1;	
							}
							
							$consulta="SELECT tipoBoleto,monto,color FROM 1102_talonesBoletos WHERE idTalon=".$fTarjetaPunto[1];
							$fDatosTipoBoleto=$con->obtenerPrimeraFila($consulta);

							$consulta="SELECT tipoBoleto FROM _1040_gridDetalleCompra WHERE id__1040_gridDetalleCompra=".$fDatosTipoBoleto[0];
							$tBoleto=$con->obtenerValor($consulta);
							
							$consulta="SELECT clave FROM _1030_tablaDinamica WHERE id__1030_tablaDinamica=".$tBoleto;
							$cveBoleto=$con->obtenerValor($consulta);
							
						/*	$consulta="SELECT clave,c.color FROM _1030_tablaDinamica t,_1031_tablaDinamica c WHERE id__1030_tablaDinamica=".$tBoleto." AND c.id__1031_tablaDinamica=t.color";
							$fDatosBoleto=$con->obtenerPrimeraFila($consulta);*/
							
							$consulta="SELECT color FROM _1031_tablaDinamica WHERE id__1031_tablaDinamica=".$fDatosTipoBoleto[2];
							$color=$con->obtenerValor($consulta);
							

							
							$descripcion='['.$cveBoleto.'] Boleto: '.$color." $".number_format($fDatosTipoBoleto[1],2);
							
							$ultimoFolio=-1;
							$foliosBaja=0;
							$total=0;
							$montoTotal=0;
							
							if($fTarjetaPunto[10]==1)
							{
								if($fTarjetaPunto[4]!=0)
								{
									$ultimoFolio=$fTarjetaPunto[4];
									$foliosBaja=obtenerTotalFoliosBaja($fTarjetaPunto[1],$folioInicial,$ultimoFolio);
									
									$total=(($ultimoFolio-$folioInicial)+1)-$foliosBaja;
									$montoTotal=$total*$fTarjetaPunto[9];	
								}
								else
								{
									$ultimoFolio=-1;
									$foliosBaja=0;
									$total=0;
									$montoTotal=0;	
								}
							}
							else
							{
								if($fTarjetaPunto[4]!=0)
								{
									$ultimoFolio=$fTarjetaPunto[4]-1;
									$foliosBaja=obtenerTotalFoliosBaja($fTarjetaPunto[1],$folioInicial,$ultimoFolio);
									$total=(($ultimoFolio-$folioInicial)+1)-$foliosBaja;
									$montoTotal=$total*$fTarjetaPunto[9];	
								}
								else
								{
									$ultimoFolio=$fTarjetaPunto[3];
									$foliosBaja=obtenerTotalFoliosBaja($fTarjetaPunto[1],$folioInicial,$ultimoFolio);
									$total=(($ultimoFolio-$folioInicial)+1)-$foliosBaja;
									$montoTotal=$total*$fTarjetaPunto[9];	
								}
							}
							
							
							$o="['".$fTarjetaPunto[1]."','".$descripcion."','".$fTarjetaPunto[9]."','".$folioInicial."','".$folioFinal."','".$foliosBaja."','0','0','".
								$fTarjetaPunto[4]."','".$total."','".$montoTotal."','".$fAsignacion[0]."','".cv($nomRuta)."','".cv($fPuntoControl[2])."','".$fPuntoControl[2]."']";
								
							if($arrRutas=="")
								$arrRutas=$o;
							else	
								$arrRutas.=",".$o;
								
								
							if(!isset($arrResumenBoletos[$fTarjetaPunto[1]]))	
							{
								$arrResumenBoletos[$fTarjetaPunto[1]]["descripcion"]=$descripcion;
								$arrResumenBoletos[$fTarjetaPunto[1]]["costoUnitario"]=$fTarjetaPunto[9];
								$arrResumenBoletos[$fTarjetaPunto[1]]["folioInicial"]=$folioInicial;
								$arrResumenBoletos[$fTarjetaPunto[1]]["folioFinal"]=$folioFinal;
								$arrResumenBoletos[$fTarjetaPunto[1]]["folioCorte"]=$fTarjetaPunto[4];
								$arrResumenBoletos[$fTarjetaPunto[1]]["foliosBaja"]=$foliosBaja;
								$arrResumenBoletos[$fTarjetaPunto[1]]["total"]=$total;
								$arrResumenBoletos[$fTarjetaPunto[1]]["montoTotal"]=$montoTotal;
								
							}
							else
							{
								$arrResumenBoletos[$fTarjetaPunto[1]]["folioCorte"]=$fTarjetaPunto[4];
								$arrResumenBoletos[$fTarjetaPunto[1]]["foliosBaja"]+=$foliosBaja;
								$arrResumenBoletos[$fTarjetaPunto[1]]["total"]+=$total;
								$arrResumenBoletos[$fTarjetaPunto[1]]["montoTotal"]+=$montoTotal;
							}
								
						}
					}
				}
				
				
			}
			
			
			$cadArrResumenBoletos="";
			

			foreach($arrResumenBoletos as $fTalon=>$r)
			{
				$o='{"folioTalon":"'.$fTalon.'","descripcion":"'.cv($r["descripcion"]).'","costoUnitario":"'.$r["costoUnitario"].'","folioInicial":"'.$r["folioInicial"].'","folioFinal":"'.$r["folioFinal"].
						'","foliosBaja":"'.$r["foliosBaja"].'","total":"'.$r["total"].'","montoTotal":"'.$r["montoTotal"].'","folioActual":"'.$r["folioCorte"].'","folioActualOriginal":"'.$r["folioCorte"].'"}';
				if($cadArrResumenBoletos=="")
					$cadArrResumenBoletos=$o;
				else
					$cadArrResumenBoletos.=",".$o;
					

					
			}
		
		
			$datosUnidad='{"noEconomico":"'.$fUnidad[10].'","marca":"'.cv($marca).'","modelo":"'.$fUnidad[14].'","noPlacas":"'.$fUnidad[16].'","noMotor":"'.$fUnidad[13].'","propietario":"'.cv($nombre).'","idUnidad":"'.$fUnidad[0].'"}';	
			
			
			$consulta="SELECT id__1044_tablaDinamica FROM _1044_tablaDinamica WHERE cmbSocio=".$socio;
			$idRegSocio=$con->obtenerValor($consulta);
			if($idRegSocio!="")
			{
				$consulta="SELECT porcentaje FROM _1046_tablaDinamica WHERE cmbOperador=".$idChofer." AND idReferencia=".$idRegSocio;
				$porcentajeComision=$con->obtenerValor($consulta);	
				if($porcentajeComision=="")
				{
					$consulta="SELECT p.porcentaje FROM _1045_tablaDinamica t,_1045_porcentajeUnidades p WHERE t.idReferencia=".$idRegSocio." AND 
								p.idReferencia=t.id__1045_tablaDinamica AND p.unidad=".$fUnidad[10];
					$porcentajeComision=$con->obtenerValor($consulta);	
					if($porcentajeComision=="")
						$porcentajeComision=$pComision;
				}
			}
			else
				$porcentajeComision=$pComision;
			
			
			$consulta="SELECT * FROM _1013_tablaDinamica WHERE id__1013_tablaDinamica=".$fConsulta[3];
			$fChofer=$con->obtenerPrimeraFila($consulta);
			if($fChofer)
			{
				
			
				$consulta="SELECT idArchivoImagen FROM 9058_imagenesControlGaleria where idElementoFormulario=8650 AND idRegistro=".$fChofer[0];
				$idArchivo=$con->obtenerValor($consulta);
				$imagen="";
				if($idArchivo=="")
					$imagen="../images/imgNoDisponible.jpg";
				else
					$imagen="../paginasFunciones/obtenerArchivos.php?id=".bE($idArchivo);
				
				$edad="";
				$consulta="SELECT l.numeroLicencia,l.fechaVigencia,t.tipoLicencia FROM _1018_tablaDinamica l,_1009_tablaDinamica t WHERE l.idReferencia=".$fChofer[0]." and '".date("Y-m-d")."'<=fechaVigencia and t.id__1009_tablaDinamica=l.cmbTipoLicencia ORDER BY fechaEmision DESC";
	
				$fLicencia=$con->obtenerPrimeraFila($consulta);
				$fNacimiento="";
				if($fChofer[21]!="")
				{
					$fNacimiento=date("d/m/Y",strtotime($fChofer[21]));
					$edad=obtenerEdad($fChofer[21]);
				}
				
				$vencimientoLicencia="";
				if($fLicencia[1]!="")
					$vencimientoLicencia=date("d/m/Y",strtotime($fLicencia[1]));
					
				$datosChofer='{"nombreChofer":"'.cv($fChofer[11]).' '.cv($fChofer[12]).' '.cv($fChofer[10]).'","fechaNacimiento":"'.$fNacimiento.'","edad":"'.$edad.'","tipoLicencia":"'.$fLicencia[2].'","vencimientoLicencia":"'.$vencimientoLicencia.'","numLicencia":"'.$fLicencia[0].'","imagen":"'.$imagen.'"}';
			}
			else
			{
				$datosChofer='{"nombreChofer":"","fechaNacimiento":"","edad":"","tipoLicencia":"","vencimientoLicencia":"","numLicencia":"","imagen":"../images/imgNoDisponible.jpg"}';
			}
			
			
			$datosTarjeta="[]";
			
			$consulta="SELECT * FROM 3106_asignacionHorarioRuta WHERE idTarjeta=".$idAsignacionTarjeta." and situacion=3  ORDER BY idAsignacion DESC LIMIT 0,1";
			$fConsulta=$con->obtenerPrimeraFila($consulta);
			$datosComp="";
			if($fConsulta)
			{
				$dRuta=obtenerNombreRutaAsignacion($fConsulta[0]);

				$datosComp=',"idRutaActiva":"'.$fConsulta[0].'","nombreRutaActiva":"'.cv($dRuta["nombreRuta"]).'"';
			}
			
			$cadObj='{"porcentajeComision":"'.$porcentajeComision.'","resumenBoletos":['.$cadArrResumenBoletos.'],"registrosRuta":['.$arrRutas.'],"idUnidad":"'.$idUnidad.'","idChofer":"'.$idChofer.
					'","idTarjeta":"'.$idTarjeta.'","idAsignacionTarjeta":"'.$idAsignacionTarjeta.'","idAsignacion":"'.$fConsulta[0].'","datosUnidad":'.
					$datosUnidad.',"datosChofer":'.$datosChofer.',"datosTarjeta":'.$datosTarjeta.$datosComp.'}';
			echo '1|'.$cadObj;	
		}
		else
		{
			echo "1|-1";	
		}
		
	}
	
	function registrarLiquidacionTarjeta()
	{
		global $con;
		$cadObj=$_POST["cadObj"];	
		$obj=json_decode($cadObj);
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="INSERT INTO 3111_registroLiquidacionTarjeta(fechaRegistro,responsableRegistro,idAsignacionTarjeta,montoTarjeta,montoRecibido,diferencia,comentariosAdicionales,gastos)
					VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$obj->idAsignacionTarjeta.",".$obj->montoAcumulado.",".$obj->montoRecibido.",".$obj->diferencia.",'".cv($obj->comentariosAdicionales).
					"',".$obj->totalGastos.")";
		$x++;
		
		$query[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		$consulta="SELECT folioTarjeta,(SELECT color FROM _1031_tablaDinamica WHERE id__1031_tablaDinamica=colorTarjeta) AS color,idChofer,idTarjeta FROM 1108_asignacionTarjetaChofer WHERE idRegistro=".$obj->idAsignacionTarjeta;
		$fTarjeta=$con->obtenerPrimeraFila($consulta);
		
		if($obj->diferencia>0)
		{
			registrarAdeudoChofer($fTarjeta[2],$obj->diferencia,1,"Diferencia en en liquidación de tarjeta: ".$fTarjeta[0]." (".$fTarjeta[1].")" ,$obj->idAsignacionTarjeta);
		}
		
		foreach($obj->arrGastos as $g)
		{
			if($g->fechaGasto!="")
				$g->fechaGasto="'".$g->fechaGasto."'";
			else

				$g->fechaGasto="NULL";
			$query[$x]="INSERT INTO 3116_gastosLiquidacionTarjeta(tipoGasto,fechaGasto,montoGasto,idLiquidacion)
					VALUES(".$g->tipoGasto.",".$g->fechaGasto.",".$g->montoGasto.",@idRegistro)";
			$x++;
		}
		
		$query[$x]="UPDATE 1101_tarjetasInventario SET situacion=2 WHERE idTarjetaInventario=".$fTarjeta[3];
		$x++;
		
		$query[$x]="UPDATE 1108_asignacionTarjetaChofer SET situacion=4 WHERE idRegistro=".$obj->idAsignacionTarjeta;
		$x++;
		
		
		$arrTalonesTarjeta=array();
		$consulta="SELECT idTalon FROM 1102_detalleTarjetaAsignada WHERE idAsignacion=".$obj->idAsignacionTarjeta;
		$rDetalle=$con->obtenerFilas($consulta);
		while($fDetalle=mysql_fetch_row($rDetalle))
		{
			$arrTalonesTarjeta[$fDetalle[0]]=array();
			$arrTalonesTarjeta[$fDetalle[0]]["montoVenta"]=0;
			$arrTalonesTarjeta[$fDetalle[0]]["ultimoFolio"]=0;
			$arrTalonesTarjeta[$fDetalle[0]]["folioInicial"]=0;
			$arrTalonesTarjeta[$fDetalle[0]]["folioFinal"]=-1;
			$arrTalonesTarjeta[$fDetalle[0]]["costoBoleto"]=0;
			$arrTalonesTarjeta[$fDetalle[0]]["boletosVendidos"]=0;
			$arrTalonesTarjeta[$fDetalle[0]]["boletosBaja"]=0;
			
			
		}
		
		$consulta="SELECT idAsignacion FROM 3106_asignacionHorarioRuta WHERE idTarjeta=".$obj->idAsignacionTarjeta." ORDER BY idAsignacion";
		$lAsignaciones=$con->obtenerListaValores($consulta);
		if($lAsignaciones=="")
			$lAsignaciones=-1;
			
		$consulta="SELECT idPuntoControlEjecucion FROM 3109_puntosControlRutaEjecucion WHERE idAsignacion in(".$lAsignaciones.") ORDER BY idPuntoControlEjecucion";
		$lPuntosControl=$con->obtenerListaValores($consulta);
		if($lPuntosControl=="")
			$lPuntosControl=-1;
		
		
		$consulta="SELECT DISTINCT folioTalon FROM 3110_tarjetaRegistroPuntoControl WHERE idPuntoControlRuta IN (".$lAsignaciones.")";
		$rTalon=$con->obtenerFilas($consulta);
		while($fTalon=mysql_fetch_row($rTalon))
		{
			if(!isset($arrTalonesTarjeta[$fTalon[0]]))	
			{
				$arrTalonesTarjeta[$fTalon[0]]=array();
				$arrTalonesTarjeta[$fTalon[0]]["montoVenta"]=0;
				$arrTalonesTarjeta[$fTalon[0]]["ultimoFolio"]=0;	
				$arrTalonesTarjeta[$fTalon[0]]["folioInicial"]=0;
				$arrTalonesTarjeta[$fTalon[0]]["folioFinal"]=-1;
				$arrTalonesTarjeta[$fTalon[0]]["costoBoleto"]=0;
				$arrTalonesTarjeta[$fTalon[0]]["boletosVendidos"]=0;
				$arrTalonesTarjeta[$fTalon[0]]["boletosBaja"]=0;
			}
		}

		
		foreach($arrTalonesTarjeta as $folioTalon=>$resto)
		{
			$ultimoBoletoVendido=-1;
			$consulta="SELECT * FROM 3110_tarjetaRegistroPuntoControl WHERE idPuntoControlRuta IN (".$lPuntosControl.") AND folioTalon=".$folioTalon." ORDER BY idRegistro";
			$rPuntoC=$con->obtenerFilas($consulta);	
			while($fPuntoC=mysql_fetch_row($rPuntoC))
			{
				if($arrTalonesTarjeta[$folioTalon]["folioInicial"]==0)
				{
					$arrTalonesTarjeta[$folioTalon]["folioInicial"]=$fPuntoC[2];
					$arrTalonesTarjeta[$folioTalon]["costoBoleto"]=$fPuntoC[9];
					$arrTalonesTarjeta[$folioTalon]["folioFinal"]=$ultimoBoletoVendido;
				}
				
				if($fPuntoC[10]==1)
				{
					if($fPuntoC[4]==0)
						$arrTalonesTarjeta[$folioTalon]["folioFinal"]=$ultimoBoletoVendido;
					else
						$arrTalonesTarjeta[$folioTalon]["folioFinal"]=$fPuntoC[4];
					
				}
				else
				{
					if($fPuntoC[4]==0)
						$arrTalonesTarjeta[$folioTalon]["folioFinal"]=$fPuntoC[3];
					else
						$arrTalonesTarjeta[$folioTalon]["folioFinal"]=$fPuntoC[4]-1;
				}
				
				$ultimoBoletoVendido=$arrTalonesTarjeta[$folioTalon]["folioFinal"];
				
			}
			
			if($arrTalonesTarjeta[$folioTalon]["folioFinal"]!=-1)
			{
				$arrTalonesTarjeta[$folioTalon]["boletosBaja"]=obtenerTotalFoliosBaja($folioTalon,$arrTalonesTarjeta[$folioTalon]["folioInicial"],$arrTalonesTarjeta[$folioTalon]["folioFinal"]);
				$arrTalonesTarjeta[$folioTalon]["boletosVendidos"]=($arrTalonesTarjeta[$folioTalon]["folioFinal"]-$arrTalonesTarjeta[$folioTalon]["folioInicial"]+1)-$arrTalonesTarjeta[$folioTalon]["boletosBaja"];
				$arrTalonesTarjeta[$folioTalon]["montoVenta"]=$arrTalonesTarjeta[$folioTalon]["boletosVendidos"]*$arrTalonesTarjeta[$folioTalon]["costoBoleto"];
			}
			else
			{
				$arrTalonesTarjeta[$folioTalon]["boletosBaja"]=0;
				$arrTalonesTarjeta[$folioTalon]["boletosVendidos"]=0;
				$arrTalonesTarjeta[$folioTalon]["montoVenta"]=0;
			}
			
		}
		
		
		
		foreach($arrTalonesTarjeta as $idFolio=>$resto)
		{
			
			$consulta="SELECT idDetalle FROM 1102_detalleTarjetaAsignada WHERE idAsignacion=".$obj->idAsignacionTarjeta." AND idTalon=".$idFolio;
			$idDetalle=$con->obtenerValor($consulta);
			
			if($idDetalle!="")
			{
				$query[$x]="UPDATE 1102_detalleTarjetaAsignada SET foliosBaja=".$resto["boletosBaja"].", total=".$resto["boletosVendidos"].", montoTotal=".$resto["montoVenta"].",ultimoFolioVendido=".$resto["folioFinal"]." 
							WHERE idDetalle=".$idDetalle;
				$x++;
			}
			else
			{
				$query[$x]="INSERT INTO 1102_detalleTarjetaAsignada(idTalon,costoUnitario,folioInicial,folioFinal,foliosBaja,total,montoTotal,idAsignacion,ultimoFolioVendido)
						VALUES(".$idFolio.",".$resto["costoBoleto"].",".$resto["folioInicial"].",".$resto["folioFinal"].",".$resto["boletosBaja"].",".$resto["boletosVendidos"].",".$resto["montoVenta"].",-1,".$resto["folioFinal"].")";
				$x++;
				
			}
			
			$consulta="SELECT idAsignacion FROM 1105_asignacionBoletosChofer a,3113_adeudosChofer s WHERE a.idChofer=".$fTarjeta[2]." 
						AND folioTalon=".$idFolio." AND s.idChofer=a.idChofer AND s.tipoConceptoAdeudo=2 AND s.referencia1=a.idAsignacion AND s.situacion=1";
			$idAdeudo=$con->obtenerValor($consulta);
			if($idAdeudo!="")
				registrarAbonoAdeudo($idAdeudo,$resto["montoVenta"],2,"Liquidación de tarjeta: ".$fTarjeta[0]." (".$fTarjeta[1]."), Folios: ".$resto["folioInicial"]." - ".$resto["folioFinal"]);	
			
		}
		
	
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query));
		{
			$consulta="SELECT idAsignacion FROM 3106_asignacionHorarioRuta WHERE idTarjeta=".$obj->idAsignacionTarjeta;
			$resAsignacion=$con->obtenerFilas($consulta);
			while($fAsignacion=mysql_fetch_row($resAsignacion))
			{
				cambiarSituacionAsignacionRuta($fAsignacion[0],12,$obj->comentariosAdicionales);	
			}	
			echo "1|";
		}
	}
	
	function verificarPermisosAutorizacionUsuario()
	{
		global $con;
		$idUsuario=$_POST["iU"];
		$accion=$_POST["a"];
		
		$consulta="SELECT COUNT(*) FROM _1042_chkAccionesUsuarioAutorizacion c,_1042_tablaDinamica t WHERE c.idPadre=t.id__1042_tablaDinamica AND t.idUsuario=".$idUsuario." AND c.idOpcion=".$accion;
		$nReg=$con->obtenerValor($consulta);
		echo "1|".$nReg;
		
		
	}
	
	function obtenerAbonosChofer()
	{
		global $con;
		$idAdeudo=$_POST["idAdeudo"];	
		
		
		$consulta="SELECT fechaAbono,montoAbono,comentariosAdicionales as comentarios,tipoAbono,descripcion FROM 3114_abonosChofer d WHERE d.idAdeudoChofer=".$idAdeudo;
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function obtenerAdeudosChofer()
	{
		global $con;
		$idChofer=$_POST["idChofer"];	
		$situacion=$_POST["situacion"];

		
		$consulta="SELECT sum(saldoActual) FROM 3113_adeudosChofer WHERE idChofer=".$idChofer." and situacion=1";
		$saldoAdeudo=$con->obtenerValor($consulta);
		if($saldoAdeudo=="")
			$saldoAdeudo=0;
		$consulta="SELECT idAdeudo,fechaAdeudo,montoAdeudo,(SELECT SUM(montoAbono) FROM 3114_abonosChofer WHERE idAdeudoChofer=d.idAdeudo) as montoAbonado,saldoActual,tipoConceptoAdeudo AS conceptoAdeudo,descripcion,situacion 
				FROM 3113_adeudosChofer d WHERE d.idChofer=".$idChofer;
				
		if($situacion!=0)		
			$consulta.=" and situacion=".$situacion;
			
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"montoAdeudo":"'.$saldoAdeudo.'","numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function registrarAbonosChofer()
	{
		global $con;	
		$idAdeudo=$_POST["idAdeudo"];
		$montoAbono=$_POST["montoAbono"];
		$comentarios=$_POST["comentarios"];
		
		if(registrarAbonoAdeudo($idAdeudo,$montoAbono,1,"Abono en ventanilla",$comentarios))
		{
			echo "1|";	
		}
		
	}
	
	function obtenerPermisosAccionesOperativas()
	{
		global $con;
		$arrRegistros="";
		$consulta="SELECT id__1050_tablaDinamica,accionOperativa FROM _1050_tablaDinamica ORDER BY accionOperativa";
		$res=$con->obtenerFilas($consulta);	
		while($fila=mysql_fetch_row($res))
		{
			$comp=",leaf:true";
			$arrHijos=obtenerPuntosControlAccionOperativa($fila[0]);
			
			if($arrHijos!="[]")
				$comp=",leaf:false,children:".$arrHijos;
			
			$o='{"icon":"../images/cog.png","id":"a_'.$fila[0].'","text":"'.cv($fila[1]).'","tipo":"1"'.$comp.'}';
			if($arrRegistros=="")	
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		echo '['.$arrRegistros.']';
	}
	
	function obtenerPuntosControlAccionOperativa($idAccionOperativa)
	{
		global $con;
		$arrRegistros="";
		$consulta="SELECT idAccionPuntoControl,nombreTerminal FROM 3117_puntosControlAccionOperativa p, _1010_tablaDinamica t WHERE p.idAccionOperativa=".$idAccionOperativa." AND  t.id__1010_tablaDinamica=p.idPuntoControl ORDER BY nombreTerminal";
		$res=$con->obtenerFilas($consulta);	
		while($fila=mysql_fetch_row($res))
		{
			$comp=",leaf:true";
			$arrHijos=obtenerUsuariosPuntosControlAccionOperativa($fila[0]);
			
			if($arrHijos!="[]")
				$comp=",leaf:false,children:".$arrHijos;
			
			$o='{"icon":"../images/lorry_flatbed.png","id":"p_'.$fila[0].'","text":"'.cv($fila[1]).'","tipo":"2"'.$comp.'}';
			if($arrRegistros=="")	
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		return "[".$arrRegistros."]";	
	}
	
	function obtenerUsuariosPuntosControlAccionOperativa($idAccionPuntoControl)
	{
		global $con;
		$arrRegistros="";
		$consulta="SELECT idUsuarioPuntoControlAccionOperativa,u.Nombre FROM 3118_usuariosPuntoControlAccionOperativa p, 800_usuarios u WHERE p.idAccionPuntoControl=".$idAccionPuntoControl." AND  u.idUsuario=p.idUsuario ORDER BY Nombre";
		$res=$con->obtenerFilas($consulta);	
		while($fila=mysql_fetch_row($res))
		{
			$o='{"icon":"../images/user_gray.png","id":"u_'.$fila[0].'","text":"'.cv($fila[1]).'","tipo":"3","leaf":true}';
			if($arrRegistros=="")	
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		return "[".$arrRegistros."]";	
	}	
	
	function obtenerPuntosControlDisponibles()
	{
		global $con;
		$idAccionOperativa=$_POST["idAccionOperativa"];	
		$consulta="SELECT idPuntoControl FROM 3117_puntosControlAccionOperativa WHERE idAccionOperativa=".$idAccionOperativa;
		
		$lPuntosControl=$con->obtenerListaValores($consulta);
		if($lPuntosControl=="")
			$lPuntosControl=-1;
		
		switch($idAccionOperativa)
		{
			case "1":
			case "2":
			case "4":
			case "6":
			case "7":
				$consulta="SELECT id__1010_tablaDinamica as idPuntoControl,nombreTerminal as puntoControl FROM _1010_tablaDinamica WHERE registraAsistencia=1 ";
			break;
			case "5":
			case "3":
			
				$consulta="SELECT id__1010_tablaDinamica as idPuntoControl,nombreTerminal as puntoControl FROM _1010_tablaDinamica WHERE id__1010_tablaDinamica IN
						(SELECT DISTINCT puntoDestino FROM 3101_puntosRecorridoRuta WHERE tipoPunto IN (2,6)) ";
			break;
		}
		
		
		$consulta.=" and id__1010_tablaDinamica not in (".$lPuntosControl.") ORDER BY nombreTerminal"; 

		$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$registros.'}';
		
		
	}
	
	function registrarPuntosControlDisponibles()
	{
		global $con;
		$cadObj=$_POST["cadObj"];	
		$obj=json_decode($cadObj);
		$x=0;
		$query[$x]="begin";
		$x++;
		foreach($obj->arrRegistros as $r)
		{
			$query[$x]=" INSERT INTO 3117_puntosControlAccionOperativa(idAccionOperativa,idPuntoControl) VALUES(".$obj->idAccion.",".$r->idPuntoControl.")";
			$x++;	
		}
		$query[$x]="commit";
		$x++;
		eB($query);
		
		
	}
	
	function obtenerPuntosControlAsignados()
	{
		global $con;
		$idAccionOperativa=$_POST["idAccionOperativa"];	
		$consulta="SELECT idPuntoControl FROM 3117_puntosControlAccionOperativa WHERE idAccionOperativa=".$idAccionOperativa;
		
		$lPuntosControl=$con->obtenerListaValores($consulta);
		if($lPuntosControl=="")
			$lPuntosControl=-1;
			
		$consulta="SELECT u.idUsuario,u.Nombre FROM _1050_gridRoles g,807_usuariosVSRoles ur,800_usuarios u WHERE idReferencia=".$idAccionOperativa." and ur.idRol=g.rol and u.idUsuario=ur.idUsuario order by u.Nombre";
		$arrUsuarios=$con->obtenerFilasArreglo($consulta);
			
		$consulta="SELECT id__1010_tablaDinamica as idPuntoControl,nombreTerminal as puntoControl FROM _1010_tablaDinamica WHERE id__1010_tablaDinamica IN (".$lPuntosControl.") ORDER BY nombreTerminal";
		$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"arrUsuarios":'.$arrUsuarios.',"numReg":"'.$con->filasAfectadas.'","registros":'.$registros.'}';
		
		
	}
	
	function registrarUsuarioPuntosControl()
	{
		global $con;
		$cadObj=$_POST["cadObj"];	
		$obj=json_decode($cadObj);
		$x=0;
		$query[$x]="begin";
		$x++;
		foreach($obj->arrRegistros as $r)
		{
			$consulta="SELECT idAccionPuntoControl FROM 3117_puntosControlAccionOperativa WHERE idAccionOperativa=".$obj->idAccion." AND idPuntoControl=".$r->idPuntoControl;
			$idAccionPuntoControl=$con->obtenerValor($consulta);
			$consulta="SELECT count(*) FROM 3118_usuariosPuntoControlAccionOperativa WHERE idAccionPuntoControl=".$idAccionPuntoControl." AND idUsuario=".$obj->idUsuario;
			$nReg=$con->obtenerValor($consulta);
			if($nReg==0)
			{
				$query[$x]=" INSERT INTO 3118_usuariosPuntoControlAccionOperativa(idAccionPuntoControl,idUsuario) VALUES(".$idAccionPuntoControl.",".$obj->idUsuario.")";
				$x++;	
			}
		}
		$query[$x]="commit";
		$x++;
		eB($query);
		
		
	}
	
	function removerUsuarioPuntosControl()
	{
		global $con;
		$id=$_POST["id"];	
		$arrDatos=explode("_",$id);
		
		$x=0;
		$query[$x]="begin";
		$x++;
		switch($arrDatos[0])
		{
			case "u":
				$query[$x]="delete from 3118_usuariosPuntoControlAccionOperativa where idUsuarioPuntoControlAccionOperativa=".$arrDatos[1];
				$x++;
			break;
			case "p":
				$query[$x]="delete from 3118_usuariosPuntoControlAccionOperativa where idAccionPuntoControl =".$arrDatos[1];
				$x++;
				$query[$x]="delete from 3117_puntosControlAccionOperativa where idAccionPuntoControl=".$arrDatos[1];
				$x++;
			break;
				
		}
		$query[$x]="commit";
		$x++;
		eB($query);
		
	}
	
	function obtenerRolDiaControlTrafico()
	{
		global $con;
		$fecha=$_POST["fecha"];
		
		$mHG=$_POST["mHG"];
		$mHR=$_POST["mHR"];
		$mHA=$_POST["mHA"];
		$mHV=$_POST["mHV"];
		
		/*$consulta="SELECT DISTINCT idHorarioEjecucion FROM 3105_horarioEjecucionRuta h,3103_horariosPerfilRuta p,3100_rutasTransportes r,3102_perfilHorarioRuta ph,3104_marcadoresHorarioPerfilRuta
					m WHERE h.fecha='".$fecha."' AND p.idHorarioPerfil=h.idHorario AND ph.idPerfilHorario=p.idPerfilHorarioRuta AND  
					r.idRuta=ph.idRuta AND m.idHorario=h.idHorario AND m.idMarcador =4 ".$comp."
					ORDER BY horario,nombreRuta";
		$listaGuardias=$con->obtenerListaValores($consulta);
		if($listaGuardias=="")*/
			$listaGuardias=-1;
		$consulta="SELECT DISTINCT idHorarioEjecucion,p.horario,r.nombreRuta,r.idRuta,p.idPuntoPaseLista,p.idHorarioPerfil 
					FROM 3105_horarioEjecucionRuta h,3103_horariosPerfilRuta p,3100_rutasTransportes r,3102_perfilHorarioRuta ph,3104_marcadoresHorarioPerfilRuta
					m WHERE h.fecha='".$fecha."' AND p.idHorarioPerfil=h.idHorario AND ph.idPerfilHorario=p.idPerfilHorarioRuta AND  
					r.idRuta=ph.idRuta AND m.idHorario=h.idHorario AND m.idMarcador NOT IN(4) and h.idHorarioEjecucion not in (".$listaGuardias.") 
					ORDER BY horario,nombreRuta";

		$res=$con->obtenerFilas($consulta);
		$numReg=0;
		$aRegistros="";
		while($fila=mysql_fetch_row($res))
		{
			
			$consulta="SELECT a.idUnidadAsignada,t.numEconomico,idChoferAsignado,a.situacion,a.idAsignacion FROM 3106_asignacionHorarioRuta a,_1012_tablaDinamica t WHERE idHorarioAsignacion=".$fila[0]."
						AND t.id__1012_tablaDinamica=a.idUnidadAsignada";
			$fAsignacion=$con->obtenerPrimeraFila($consulta);
			
			switch($fAsignacion[3])
			{
				case "":
					$fAsignacion[0]="";
					$fAsignacion[1]="";
					$fAsignacion[2]="";
					$fAsignacion[3]=5;
					$fAsignacion[4]="";
				break;	
				
			}
			
			$puntoPaseLista="";
			if($fila[4]=="")
			{
				$consulta="SELECT COUNT(*) FROM 3104_marcadoresHorarioPerfilRuta WHERE idHorario=".$fila[5]." AND idMarcador=3";
				$nReg=$con->obtenerValor($consulta);
				if($nReg==0)
				{
					$puntoPaseLista="2) Horarios Abiertos";
					if($mHA==0)
						continue;
				}
				else
				{
					$puntoPaseLista="3) Horarios Velada";
					if($mHV==0)
						continue;
				}
			}
			else
			{
				
				$consulta="SELECT COUNT(*) FROM 3104_marcadoresHorarioPerfilRuta WHERE idHorario=".$fila[5]." AND idMarcador=4";
				$nReg=$con->obtenerValor($consulta);
				
				$consulta="SELECT nombreTerminal FROM _1010_tablaDinamica WHERE id__1010_tablaDinamica=".$fila[4];
				$nPaseLista=$con->obtenerValor($consulta);
				if($nReg==0)
				{
					$puntoPaseLista="1) Horarios de Arranque, pase de lista en: ".$nPaseLista;	
					if($mHR==0)
						continue;
				}
				else
				{
					$puntoPaseLista="0) Horarios de Guardia, pase de lista en: ".$nPaseLista;	
					if($mHG==0)
						continue;
				}
			}
			
			
			$o='{"puntoPaseLista":"'.$puntoPaseLista.'","idUnidadAsignada":"'.$fAsignacion[0].'","idHorarioEjecucion":"'.$fila[0].'","ruta":"'.cv($fila[2]).'","idRuta":"'.$fila[3].'","unidad":"'.$fAsignacion[1].'","horario":"'.$fila[1].'","situacion":"'.$fAsignacion[3].'","idAsignacion":"'.$fAsignacion[4].'"}';	
			if($aRegistros=="")	
				$aRegistros=$o;
			else
				$aRegistros.=",".$o;
			$numReg++;
		}
		
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$aRegistros.']}';
	}
	
	function registrarAsignacionUnidad()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$arrComentarios=array();
		$idAccionOperacion=6;
		$arrReg="[]";
		
		if($obj->validar=="1")
		{
			$arrReg=obtenerComentariosAccionOperacion($idAccionOperacion,$obj->unidad,$obj->fecha,$obj->idHorarioEjecucion,$obj->idPuntoControl);
			$resp=1;
			if($arrReg!="")
			{
				$resp="[".$arrReg."]";
				echo "1|".$resp;	
				return;
			}
		}
		
		$idUnidad=obtenerIdUnidadNumEconomico($obj->unidad);

		$consulta="SELECT horario,idPuntoPaseLista FROM 3105_horarioEjecucionRuta h,3103_horariosPerfilRuta p WHERE 
					idHorarioEjecucion=".$obj->idHorarioEjecucion." AND p.idHorarioPerfil=h.idHorario";
		$fHorarioEjecucion=$con->obtenerPrimeraFila($consulta);
		$horario=$fHorarioEjecucion[0];
		
		$idChoferAsignado=obtenerIdChofer($idUnidad,$obj->fecha,$horario);
		if($idChoferAsignado==-1)
		{
			$consulta="select idChoferAsignado from 3106_asignacionHorarioRuta where idUnidadAsignada=".$idUnidad." and 
						fecha='".$obj->fecha."' and horario<='".$horario."' order by idAsignacion desc";
			$idChoferAsignado=$con->obtenerValor($consulta);		
			if(($idChoferAsignado==-1)||($idChoferAsignado==""))
				$idChoferAsignado="NULL";
		}
		$consulta="INSERT INTO 3106_asignacionHorarioRuta(idHorarioAsignacion,idUnidadAsignada,idChoferAsignado,fecha,horario,orden,situacion)
					VALUES(".$obj->idHorarioEjecucion.",".$idUnidad.",".$idChoferAsignado.",'".$obj->fecha."','".$horario."',".$obj->idHorarioEjecucion.",1)";
		if($con->ejecutarConsulta($consulta))
		{
			$idAsignacion=$con->obtenerUltimoID();
			
			echo '1||{"idAsignacion":"'.$idAsignacion.'","idUnidadAsignada":"'.$idUnidad.'"}';		
		}
		
	}
	
	function obtenerDatosAsignacion()
	{
		global $con;
		$idAsignacion=$_POST["idAsignacion"];	
		
		
		
		$consulta="SELECT * FROM 3106_asignacionHorarioRuta WHERE idAsignacion=".$idAsignacion;
		$fConsulta=$con->obtenerPrimeraFila($consulta);
			
		$idChofer=$fConsulta[3];
		if($idChofer=="")
			$idChofer=-1;
		$idUnidad=$fConsulta[2];
		$consulta="SELECT * FROM _1012_tablaDinamica WHERE idEstado=2 AND id__1012_tablaDinamica=".$idUnidad;
		$fUnidad=$con->obtenerPrimeraFila($consulta);
		$socio=$fUnidad[12];
		
		
		$consulta="SELECT nombreMarca FROM _1011_tablaDinamica WHERE id__1011_tablaDinamica=".$fUnidad[15];
		$marca=$con->obtenerValor($consulta);
		
		if($fUnidad[12]=="")
			$fUnidad[12]=-1;
		$nombre=obtenerNombreUsuario($fUnidad[12]);
		
		$dRuta='['.date("d/m/Y H:i",strtotime($fConsulta[7]." ".$fConsulta[8])).']';
		
		$ruta=$dRuta;
		$consulta="SELECT r.nombreRuta FROM 3105_horarioEjecucionRuta h,3100_rutasTransportes r WHERE idHorarioEjecucion=".$fConsulta[1]." AND r.idRuta=h.idRuta";
		$nomRuta=$con->obtenerValor($consulta);
		$ruta.=" ".$nomRuta;
		
		$datosUnidad='{"ruta":"'.$ruta.'","noEconomico":"'.$fUnidad[10].'","marca":"'.cv($marca).'","modelo":"'.$fUnidad[14].'","noPlacas":"'.$fUnidad[16].'","noMotor":"'.$fUnidad[13].'","propietario":"'.cv($nombre).'","idUnidad":"'.$fUnidad[0].'"}';	
		
		
		
		
		
		$consulta="SELECT * FROM _1013_tablaDinamica WHERE id__1013_tablaDinamica=".$idChofer;
		$fChofer=$con->obtenerPrimeraFila($consulta);
		if($fChofer)
		{
			
		
			$consulta="SELECT idArchivoImagen FROM 9058_imagenesControlGaleria where idElementoFormulario=8650 AND idRegistro=".$fChofer[0];
			$idArchivo=$con->obtenerValor($consulta);
			$imagen="";
			if($idArchivo=="")
				$imagen="../images/imgNoDisponible.jpg";
			else
				$imagen="../paginasFunciones/obtenerArchivos.php?id=".bE($idArchivo);
			
			$edad="";
			$consulta="SELECT l.numeroLicencia,l.fechaVigencia,t.tipoLicencia FROM _1018_tablaDinamica l,_1009_tablaDinamica t WHERE l.idReferencia=".$fChofer[0]." and '".date("Y-m-d")."'<=fechaVigencia and t.id__1009_tablaDinamica=l.cmbTipoLicencia ORDER BY fechaEmision DESC";
  
			$fLicencia=$con->obtenerPrimeraFila($consulta);
			$fNacimiento="";
			if($fChofer[21]!="")
			{
				$fNacimiento=date("d/m/Y",strtotime($fChofer[21]));
				$edad=obtenerEdad($fChofer[21]);
			}
			
			$vencimientoLicencia="";
			if($fLicencia[1]!="")
				$vencimientoLicencia=date("d/m/Y",strtotime($fLicencia[1]));
				
			$datosChofer='{"nombreChofer":"'.cv($fChofer[11]).' '.cv($fChofer[12]).' '.cv($fChofer[10]).'","fechaNacimiento":"'.$fNacimiento.'","edad":"'.$edad.'","tipoLicencia":"'.$fLicencia[2].'","vencimientoLicencia":"'.$vencimientoLicencia.'","numLicencia":"'.$fLicencia[0].'","imagen":"'.$imagen.'"}';
		}
		else
		{
			$datosChofer='{"nombreChofer":"No asignado","fechaNacimiento":"","edad":"","tipoLicencia":"","vencimientoLicencia":"","numLicencia":"","imagen":"../images/imgNoDisponible.jpg"}';
		}
		
		
		
		
		
		$cadObj='{"idUnidad":"'.$idUnidad.'","idChofer":"'.$idChofer.'","datosUnidad":'.$datosUnidad.',"datosChofer":'.$datosChofer.'}';
		echo '1|'.$cadObj;	
	}
	
	function obtenerUnidadesReemplazantes()
	{
		global $con;
		$idAsignacion=$_POST["idAsignacion"];
		$consulta="SELECT fecha,horario,idUnidadAsignada FROM 3106_asignacionHorarioRuta WHERE idAsignacion=".$idAsignacion;
		$fAsignacion=$con->obtenerPrimeraFila($consulta);
		
		$arrUnidadesIng=array();
		$arrUnidadesIng[$fAsignacion[2]]=1;
		
		$consulta="SELECT idUnidadReemplazante,idUnidadReemplazar FROM 1104_solicitudCambioUnidad s, 3106_asignacionHorarioRuta a
					WHERE a.idAsignacion=s.idAsignacionCambio AND a.fecha='".$fAsignacion[0]."' AND s.situacion=0";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$arrUnidadesIng[$fila[0]]=1;
			if($fila[1]!=-1)
				$arrUnidadesIng[$fila[1]]=1;
		}
		
		$consulta="SELECT id__1012_tablaDinamica,numEconomico FROM _1012_tablaDinamica WHERE idEstado=2 ORDER BY numEconomico";
		$res=$con->obtenerFilas($consulta);
		$arrRegistros="";
		$numReg=0;
		while($fila=mysql_fetch_row($res))
		{
			
			if(isset($arrUnidadesIng[$fila[0]]))
				continue;
			
			$idChofer=obtenerIdChofer($fila[0],$fAsignacion[0],$fAsignacion[1]);
			
			$nChofer="";
			if($idChofer==-1)
				$nChofer="(No asignado)";
			else
			{
				$consulta="SELECT CONCAT(aPaterno,' ',aMaterno,' ',nombre) AS nombre FROM _1013_tablaDinamica WHERE id__1013_tablaDinamica=".$idChofer;
				$nChofer=$con->obtenerValor($consulta);	
			}
			
			$esGuardia=0;
			$arrRutas="['0','No intercambiar']";
			$consulta="SELECT idHorarioAsignacion,idAsignacion,horario,situacion FROM 3106_asignacionHorarioRuta WHERE  fecha='".$fAsignacion[0]."'   AND idUnidadAsignada=".$fila[0]." and situacion in (1,2,6,7,8,13)";
			
			$resHorario=$con->obtenerFilas($consulta);
			while($fHorario=mysql_fetch_row($resHorario))
			{
				if(asignacionPresentaMarca($fHorario[1],4))
				{
					$esGuardia=$fHorario[1];

					if($fHorario[3]=="13")
					{
						$esGuardia=0;	
					}
					continue;
				}
				else
				{
					if(strtotime($fAsignacion[1])>strtotime($fHorario[2]))	
					{
						continue;	
					}
				}
				$dRuta=obtenerNombreRutaAsignacion($fHorario[1]);
				$arrRutas.=",['".$fHorario[1]."','".cv($dRuta["nombreRuta"])."']";
			}
			
			
			$agrupacion="2.- Unidades Disponibles";
			if($esGuardia!=0)
			{
				
				$agrupacion="1.- Unidades de Guardia Disponibles";
			}
			$o='{"idUnidad":"'.$fila[0].'","noEconomico":"'.$fila[1].'","idChofer":"'.$idChofer.'","choferAsignado":"'.cv($nChofer).'","agrupacion":"'.$agrupacion.'","arrRutas":['.$arrRutas.']}';
			if($arrRegistros=="")	
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
			
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
			
	}
		
	function obtenerDatosUnidadReemplaza()
	{
		global $con;
		$idAsignacion=$_POST["idAsignacion"];	
		$idUnidad=$_POST["idUnidad"];
		
		
		$consulta="SELECT * FROM _1012_tablaDinamica WHERE idEstado=2 AND id__1012_tablaDinamica=".$idUnidad;
		$fUnidad=$con->obtenerPrimeraFila($consulta);
		$socio=$fUnidad[12];
		
		
		$consulta="SELECT nombreMarca FROM _1011_tablaDinamica WHERE id__1011_tablaDinamica=".$fUnidad[15];
		$marca=$con->obtenerValor($consulta);
		
		if($fUnidad[12]=="")
			$fUnidad[12]=-1;
		$nombre=obtenerNombreUsuario($fUnidad[12]);
		
		$consulta="SELECT  fecha,horario FROM 3106_asignacionHorarioRuta WHERE idAsignacion=".$idAsignacion;
		$fAsignacion=$con->obtenerPrimeraFila($consulta);
		
		
		$idChofer=obtenerIdChofer($idUnidad,$fAsignacion[0],$fAsignacion[1]);
		
		$datosUnidad='{"ruta":"","noEconomico":"'.$fUnidad[10].'","marca":"'.cv($marca).'","modelo":"'.$fUnidad[14].'","noPlacas":"'.$fUnidad[16].'","noMotor":"'.$fUnidad[13].'","propietario":"'.cv($nombre).'","idUnidad":"'.$fUnidad[0].'"}';	
		$consulta="SELECT * FROM _1013_tablaDinamica WHERE id__1013_tablaDinamica=".$idChofer;
		$fChofer=$con->obtenerPrimeraFila($consulta);
		if($fChofer)
		{
			
		
			$consulta="SELECT idArchivoImagen FROM 9058_imagenesControlGaleria where idElementoFormulario=8650 AND idRegistro=".$fChofer[0];
			$idArchivo=$con->obtenerValor($consulta);
			$imagen="";
			if($idArchivo=="")
				$imagen="../images/imgNoDisponible.jpg";
			else
				$imagen="../paginasFunciones/obtenerArchivos.php?id=".bE($idArchivo);
			
			$edad="";
			$consulta="SELECT l.numeroLicencia,l.fechaVigencia,t.tipoLicencia FROM _1018_tablaDinamica l,_1009_tablaDinamica t WHERE l.idReferencia=".$fChofer[0]." and '".date("Y-m-d")."'<=fechaVigencia and t.id__1009_tablaDinamica=l.cmbTipoLicencia ORDER BY fechaEmision DESC";
  
			$fLicencia=$con->obtenerPrimeraFila($consulta);
			$fNacimiento="";
			if($fChofer[21]!="")
			{
				$fNacimiento=date("d/m/Y",strtotime($fChofer[21]));
				$edad=obtenerEdad($fChofer[21]);
			}
			
			$vencimientoLicencia="";
			if($fLicencia[1]!="")
				$vencimientoLicencia=date("d/m/Y",strtotime($fLicencia[1]));
				
			$datosChofer='{"nombreChofer":"'.cv($fChofer[11]).' '.cv($fChofer[12]).' '.cv($fChofer[10]).'","fechaNacimiento":"'.$fNacimiento.'","edad":"'.$edad.'","tipoLicencia":"'.$fLicencia[2].'","vencimientoLicencia":"'.$vencimientoLicencia.'","numLicencia":"'.$fLicencia[0].'","imagen":"'.$imagen.'"}';
		}
		else
		{
			$datosChofer='{"nombreChofer":"No asignado","fechaNacimiento":"","edad":"","tipoLicencia":"","vencimientoLicencia":"","numLicencia":"","imagen":"../images/imgNoDisponible.jpg"}';
		}
		
		
		
		
		
		$cadObj='{"idUnidad":"'.$idUnidad.'","idChofer":"'.$idChofer.'","datosUnidad":'.$datosUnidad.',"datosChofer":'.$datosChofer.'}';
		echo '1|'.$cadObj;	
	}
	
	function registrarSolicitudReemplazoUnidad()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$arrComentarios=array();
		$idAccionOperacion=7;
		$arrReg="";
		if($obj->validar=="1")
		{
			
			$consulta="SELECT idUnidadAsignada,idChoferAsignado,fecha,idHorarioAsignacion FROM 3106_asignacionHorarioRuta WHERE idAsignacion=".$obj->idAsignacionCambio;
			$fAsignacion=$con->obtenerPrimeraFila($consulta);
			$idChofer=$fAsignacion[1];
			if($idChofer=="")
				$idChofer=-1;
			$arrReg=obtenerComentariosAccionOperacion($idAccionOperacion,$obj->idUnidadReemplazante,$fAsignacion[2],$fAsignacion[3],$obj->idPuntoControl,$idChofer);
			if($obj->idRutaReemplazo!=0)
			{
				$consulta="SELECT idUnidadAsignada,idChoferAsignado,fecha,idHorarioAsignacion FROM 3106_asignacionHorarioRuta WHERE idAsignacion=".$obj->idRutaReemplazo;
				$fAsignacion2=$con->obtenerPrimeraFila($consulta);
				$idChofer2=$fAsignacion2[1];
				if($idChofer2=="")
					$idChofer2=-1;
				$arrReg2=obtenerComentariosAccionOperacion($idAccionOperacion,$fAsignacion[0],$fAsignacion2[2],$fAsignacion2[3],$obj->idPuntoControl,$idChofer2);
				if($arrReg!="")
				{
					$arrReg.=",".$arrReg2;
					
				}
				else
					$arrReg=$arrReg2;
			}
		}

		if($arrReg=="")
		{
			$consulta="SELECT idUnidadAsignada,idChoferAsignado FROM 3106_asignacionHorarioRuta WHERE idAsignacion=".$obj->idAsignacionCambio;
			$fDatosReemplazar=$con->obtenerPrimeraFila($consulta);
			if($fDatosReemplazar[1]=="")
				$fDatosReemplazar[1]=-1;
				
			$idUnidadReemplazar=$fDatosReemplazar[0];
			$idChoferReemplazar=$fDatosReemplazar[1];
			$idChoferReemplazante=-1;
			if($obj->idRutaReemplazo!="0")
			{
				$consulta="SELECT idUnidadAsignada,idChoferAsignado FROM 3106_asignacionHorarioRuta WHERE idAsignacion=".$obj->idRutaReemplazo;
				$fDatosReemplazar=$con->obtenerPrimeraFila($consulta);
				if($fDatosReemplazar[1]=="")
					$fDatosReemplazar[1]=-1;
					
				$idChoferReemplazante=$fDatosReemplazar[1];
			}
			$consulta="INSERT INTO 1104_solicitudCambioUnidad(idAsignacionCambio,idUnidadReemplazante,idRutaReemplazo,
						idMotivoReemplazo,comentarios,situacion,fechaRegistroSolicitud,idResponsableSolicitud,idUnidadReemplazar,idChoferReemplazante,idChoferReemplazar)
						VALUES(".$obj->idAsignacionCambio.",".$obj->idUnidadReemplazante.",".$obj->idRutaReemplazo.",".$obj->idMotivoReemplazo.",'".
						cv($obj->comentarios)."',0,'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$idUnidadReemplazar.",".$idChoferReemplazante.",".$idChoferReemplazar.")";
		
			if($con->ejecutarConsulta($consulta))
				echo "1|1";
		}
		else
			echo "1|0|[".$arrReg."]";
		
		
	}
	
	function verificarRequerimientoVerificacioBiometrico()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$consulta="select count(*) from _1043_chkAccionesOperativas WHERE idOpcion=".$idAccion;
		$nReg=$con->obtenerValor($consulta);
		$verificarAutorizacion="0";
		if($nReg>0)
			$verificarAutorizacion="1";	
		echo "1|".$verificarAutorizacion;
	}
		
	function obtenerSolicitudesCambioUnidad()
	{
		global $con;
		$situcion=$_POST["situacion"];
		$arrRegistros="";
		$nReg=0;
		$consulta="SELECT * FROM 1104_solicitudCambioUnidad where situacion=".$situcion;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))		
		{
			$consulta="SELECT motivoCambio FROM _1049_tablaDinamica WHERE id__1049_tablaDinamica=".$fila[4];
			$motivoCambio=$con->obtenerValor($consulta);
			if($fila[3]==0)
			{
				$ruta=obtenerNombreRutaAsignacion($fila[1]);
				$ruta=$ruta["nombreRuta"];// 
				
				$chofer1=obtenerNombreChofer($fila[14]);
				if($chofer1=="")
					$chofer1="(Sin chofer asignado)";
				
				$comentariosSolicitud="<span style='color:#900'><b>Reemplazo</b></span><br>".
										"<b>Unidad a reemplazar:</b> ".obtenerNumEconomicoIdUnidad($fila[12])."<br>
										<b>Chofer asignado:</b> ".cv($chofer1)."<br>
										<b>Ruta:</b> ".cv($ruta)."<br><br>
										<b>Unidad reemplazante:</b> ".obtenerNumEconomicoIdUnidad($fila[2])."<br>
										<b>Motivo del reemplazo:</b> ".cv($motivoCambio)."<br><br>
										<b>Comentarios adicionales:</b> ".cv($fila[5]);
										
			}
			else
			{
				$chofer1=obtenerNombreChofer($fila[14]);
				if($chofer1=="")
					$chofer1="(Sin chofer asignado)";
				
				$chofer2=obtenerNombreChofer($fila[13]);
				if($chofer2=="")
					$chofer2="(Sin chofer asignado)";
				
				$ruta=obtenerNombreRutaAsignacion($fila[1]);
				$ruta=$ruta["nombreRuta"];
				$ruta2=obtenerNombreRutaAsignacion($fila[3]);
				$ruta2=$ruta2["nombreRuta"];
				$comentariosSolicitud="<span style='color:#900'><b>Intercambio</b></span><br>".
										"<b>Unidad a reemplazar:</b> ".obtenerNumEconomicoIdUnidad($fila[12])."<br>
										<b>Ruta:</b> ".cv($ruta)."<br>
										<b>Chofer asignado:</b> ".cv($chofer1)."<br><br>
										<b>Unidad reemplazante:</b> ".obtenerNumEconomicoIdUnidad($fila[2])."<br>
										<b>Ruta:</b> ".cv($ruta2)."<br>
										<b>Chofer asignado:</b> ".cv($chofer2)."<br><br>
										<b>Motivo del reemplazo:</b> ".cv($motivoCambio)."<br><br>
										<b>Comentarios adicionales:</b> ".cv($fila[5]);
										
			}
			$obj='{"idSolicitud":"'.$fila[0].'","fechaSolicitud":"'.$fila[7].'","solicitadoPor":"'.obtenerNombreUsuarioPaterno($fila[8]).
				'","solicitud":"'.cv($comentariosSolicitud).'","situacion":"'.$fila[6].'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$nReg++;
		}
		echo '{"numReg":"'.$nReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	function registrarAutorizacionSolicitudReemplazoUnidad()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$arrComentarios=array();
		$idAccionOperacion=7;
		$arrReg="";
		$consulta="SELECT idAsignacionCambio,idRutaReemplazo,idUnidadReemplazante,idUnidadReemplazar,idMotivoReemplazo,idChoferReemplazante,idChoferReemplazar FROM 1104_solicitudCambioUnidad WHERE idSolicitud=".$obj->idSolicitud;
		$fSolicitud=$con->obtenerPrimeraFila($consulta);
			
		if($obj->validar=="1")
		{
			
			$consulta="SELECT idUnidadAsignada,idChoferAsignado,fecha,idHorarioAsignacion FROM 3106_asignacionHorarioRuta WHERE idAsignacion=".$fSolicitud[0];
			$fAsignacion=$con->obtenerPrimeraFila($consulta);
			$idChofer=$fAsignacion[1];
			if($idChofer=="")
				$idChofer=-1;
			$arrReg=obtenerComentariosAccionOperacion($idAccionOperacion,$fSolicitud[2],$fAsignacion[2],$fAsignacion[3],0,$idChofer);
			if($fSolicitud[1]!=0)
			{
				$consulta="SELECT idUnidadAsignada,idChoferAsignado,fecha,idHorarioAsignacion FROM 3106_asignacionHorarioRuta WHERE idAsignacion=".$fSolicitud[1];
				$fAsignacion2=$con->obtenerPrimeraFila($consulta);
				$idChofer2=$fAsignacion2[1];
				if($idChofer2=="")
					$idChofer2=-1;
				$arrReg2=obtenerComentariosAccionOperacion($idAccionOperacion,$fAsignacion[0],$fAsignacion2[2],$fAsignacion2[3],0,$idChofer2);
				if($arrReg!="")
				{
					$arrReg.=",".$arrReg2;
					
				}
				else
					$arrReg=$arrReg2;
			}
		}

		if($arrReg=="")
		{
			$x=0;
			$query[$x]="begin";
			$x++;
			
			if($fSolicitud[5]=="")
				$fSolicitud[5]="NULL";
			
			
			$query[$x]="UPDATE 1104_solicitudCambioUnidad SET situacion=".$obj->dictamen.",fechaAutorizacion='".date("Y-m-d H:i:s")."',idResponsableAutorizacion=".$_SESSION["idUsr"].",comentariosFinales='".cv($obj->comentarios)."' WHERE idSolicitud=".$obj->idSolicitud;
			$x++;
			if($obj->dictamen==1)
			{
			
				$query[$x]="UPDATE 3106_asignacionHorarioRuta SET idUnidadAsignada=".$fSolicitud[2].",idChoferAsignado=".$fSolicitud[5]." WHERE idAsignacion=".$fSolicitud[0];
				$x++;
				
				if(($fSolicitud[1]!="-1")&&($fSolicitud[1]!="0"))
				{
					if($fSolicitud[6]=="")
						$fSolicitud[6]="NULL";
					$query[$x]="UPDATE 3106_asignacionHorarioRuta SET idUnidadAsignada=".$fSolicitud[3].",idChoferAsignado=".$fSolicitud[6]." WHERE idAsignacion=".$fSolicitud[1];
					$x++;
				}
				
				$cache=NULL;
				$cTmp='{"tipoElemento":"","idElemento":"","idMotivoCambio":"","idRegistro":""}';
				$objTmp=json_decode($cTmp);
				$objTmp->idMotivoCambio=$fSolicitud[4];
				$objTmp->idRegistro=$obj->idSolicitud;				
				$consulta="SELECT sancionAplica from _1049_gridSanciones WHERE idReferencia=".$fSolicitud[4];

				$resSanciones=$con->obtenerFilas($consulta);
				while($fSancion=mysql_fetch_row($resSanciones))
				{
					
					$consulta="SELECT funcionAccion,aplicableA FROM _1025_tablaDinamica WHERE id__1025_tablaDinamica=".$fSancion[0];
					$fAux=$con->obtenerPrimeraFila($consulta);
					$objTmp->tipoElemento=$fAux[1];
					
					switch($objTmp->tipoElemento)
					{
						case 1: //CHofer
							$objTmp->idElemento=$fSolicitud[6];
						break;
						case 2: //Unidad
							$objTmp->idElemento=$fSolicitud[3];
						break;	
					}
					if(($objTmp->idElemento!="")&&($objTmp->idElemento!="-1"))
						$oResp=resolverExpresionCalculoPHP($fila[0],$objTmp,$cache);			
				}
			}
			$query[$x]="commit";
			$x++;
			if($con->ejecutarBloque($query))
				echo "1|1";
		}
		else
			echo "1|0|[".$arrReg."]";
		
		
	}
		
	function obtenerAsignacionTalonesChofer()
	{
		global $con;
		$idChofer=$_POST["idChofer"];
		$situacion=$_POST["situacion"];
		
		$comp="";
		switch($situacion)
		{
			case 0:
				
			break;
			case 1:
				$comp=" and a.situacion=1";
			break;
			case 2:
				$comp=" and a.situacion=0";
			break;
			case 4:
				$comp=" and a.situacion=2";
			break;
				
		}
		
		$registros="";
		$consulta="	SELECT idAsignacion,a.folioTalon,a.folioInicial,a.folioFinal,t.folioActual,fechaAsignacion,fechaBaja,a.situacion,v.boleto as descripcion,a.motivoBaja,
					a.montoBoleto,t.boletosExistencia FROM 1105_asignacionBoletosChofer a,1102_talonesBoletos t,_1040_gridDetalleCompra g,1000_vistaTiposBoletos v WHERE idChofer=".$idChofer.$comp."
					AND g.id__1040_gridDetalleCompra=t.tipoBoleto AND v.idTipoBoleto=g.tipoBoleto and t.idTalon=a.folioTalon ORDER BY idAsignacion";
		//$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$totalFoliosBaja=obtenerTotalFoliosBaja($fila[1],$fila[2],$fila[3]);
			$total=(($fila[3]-$fila[2])+1)-$totalFoliosBaja;
			$uBoletoVendido=obtenerUltimoBoletoVendido($fila[1],$idChofer);
			$o='{"totalFoliosBaja":"'.$totalFoliosBaja.'","costoBoleto":"'.$fila[10].'","motivoBaja":"'.cv($fila[9]).'","idAsignacion":"'.$fila[0].'","folioTalon":"'.
				$fila[1].'","folioInicial":"'.$fila[2].'","folioFinal":"'.$fila[3].'","folioActual":"'.$uBoletoVendido.
				'","fechaAsignacion":"'.$fila[5].'","fechaBaja":"'.$fila[6].'","situacion":"'.$fila[7].'","descripcion":"'.cv($fila[8]).'","total":"'.$fila[11].'"}'	;
			if($registros=="")	
				$registros=$o;
			else
				$registros.=",".$o;
		}
		
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$registros.']}';
			
	}
	
	function buscarDatosTalonBoletos()
	{
		global $con;
		$folio=$_POST["folio"];
		$aRegistros="";
		$consulta="SELECT idTalon,v.boleto,t.folioInicial,t.folioFinalActual as folioFinal,t.folioActual,boletosExistencia as total,t.situacion,
					(SELECT CONCAT(IF(c.aPaterno IS NULL,'',c.aPaterno),' ',IF(c.aMaterno IS NULL,'',c.aMaterno),' ',IF(c.nombre IS NULL,'',c.nombre))  FROM 1105_asignacionBoletosChofer a,
					_1013_tablaDinamica c WHERE folioTalon=t.idTalon AND situacion=1 AND c.id__1013_tablaDinamica=a.idChofer) as choferAsignado 
					FROM 1102_talonesBoletos t,_1040_gridDetalleCompra g,1000_vistaTiposBoletos v WHERE idTalon=".$folio."
					AND g.id__1040_gridDetalleCompra=t.tipoBoleto AND v.idTipoBoleto=g.tipoBoleto and t.situacion not in (4,2)";
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$total=(($fila[3]-$fila[2])+1)-obtenerTotalFoliosBaja($fila[0],$fila[2],$fila[3]);
			
			$o='{"idTalon":"'.$fila[0].'","boleto":"'.$fila[1].'","folioInicial":"'.$fila[2].'","folioFinal":"'.$fila[3].'","folioActual":"'.$fila[4].
				'","total":"'.$fila[5].'","situacion":"'.$fila[6].'","choferAsignado":"'.$fila[7].'"}'	;
			if($aRegistros=="")	
				$aRegistros=$o;
			else
				$aRegistros.=",".$o;
		}
		
		
		echo "1|[".$aRegistros."]";
		
		
	}
	
	function registrarAsignacionTalon()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);	
		
		
		
		
		$query="SELECT monto,boletosExistencia FROM 1102_talonesBoletos WHERE  idTalon=".$obj->folioTalon;
		$fila=$con->obtenerPrimeraFila($query);
		$montoBoleto=$fila[0];
		$boletosExistencia=$fila[1];
		$fechaAsignacion=date("Y-m-d H:i:s");
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="INSERT INTO 1105_asignacionBoletosChofer(folioTalon,folioInicial,folioFinal,folioActual,fechaAsignacion,situacion,idChofer,montoBoleto)
						VALUES('".cv($obj->folioTalon)."','".cv($obj->folioInicial)."','".cv($obj->folioFinal)."','".cv($obj->folioActual)."','".$fechaAsignacion."',1,".cv($obj->idChofer).",".$montoBoleto.")";
		$x++;	
		$consulta[$x]="set @idAsignacion=(select last_insert_id())";
		$x++;
		$consulta[$x]="UPDATE 1102_talonesBoletos SET situacion=2 WHERE idTalon=".$obj->folioTalon;
		$x++;
		
		$descripcion="Consignación del talón: ".$obj->folioTalon." (Folios: ".$obj->folioInicial." - ".$obj->folioFinal."), Precio unitario: $ ".number_format($montoBoleto,2);
		$montoAdeudo=$boletosExistencia*$montoBoleto;
		$consulta[$x]="INSERT INTO 3113_adeudosChofer(idChofer,fechaAdeudo,montoAdeudo,tipoConceptoAdeudo,referencia1,descripcion,situacion,saldoActual)
					VALUES(".$obj->idChofer.",'".$fechaAsignacion."',".$montoAdeudo.",2,@idAsignacion,'".cv($descripcion)."',1,".$montoAdeudo.")";
		$x++;
		
		
		$query="SELECT idRegistro FROM 1108_asignacionTarjetaChofer WHERE idChofer=".$obj->idChofer." AND situacion=2";
		$idTarjeta=$con->obtenerValor($query);
		
		if($idTarjeta!="")
		{
			$totalFoliosBaja=obtenerTotalFoliosBaja($obj->folioTalon,$obj->folioInicial,$obj->folioFinal); 
			$total=(($obj->folioFinal-$obj->folioInicial)+1)-$totalFoliosBaja;
			$montoTotal=$total*$montoBoleto;
			$consulta[$x]="INSERT INTO 1102_detalleTarjetaAsignada(idTalon,costoUnitario,folioInicial,folioFinal,foliosBaja,total,montoTotal,idAsignacion,ultimoFolioVendido)
							VALUES(".$obj->folioTalon.",".$montoBoleto.",".$obj->folioInicial.",".$obj->folioFinal.",".$totalFoliosBaja.",".$total.",".$montoBoleto.",".$idTarjeta.",-1)";
		
			$x++;	
		}
		
		$consulta[$x]="commit";
		$x++;	
				
		if($con->ejecutarBloque($consulta))
		{
			echo "1|".$con->obtenerUltimoID();	
		}
	}
	
	function desasignarTalon()
	{
		global $con;	
		$idAsignacion=$_POST["idAsignacion"];
		$motivo=$_POST["motivo"];
		
		$consulta="SELECT folioTalon,montoBoleto,idChofer FROM 1105_asignacionBoletosChofer WHERE idAsignacion=".$idAsignacion;
		$fTalon=$con->obtenerPrimeraFila($consulta);
		
		$idTalon=$fTalon[0];
		$montoBoleto=$fTalon[1];
		$idChofer=$fTalon[2];
		
		
		$abortarOperacion=false;
		
		$tabla="<table>";
		$consulta=" SELECT idRegistro FROM 1108_asignacionTarjetaChofer WHERE idChofer=".$idChofer." AND situacion IN (2,5)";
		$rAsignacion=$con->obtenerFilas($consulta);
		while($fAsignacion=mysql_fetch_row($rAsignacion))
		{
			$consulta="SELECT * FROM 1102_detalleTarjetaAsignada WHERE idAsignacion=".$fAsignacion[0]." AND idTalon=".$idTalon;
			$fTalonAsignacion=$con->obtenerPrimeraFila($consulta);	
			
			$consulta="SELECT COUNT(*) FROM 3110_tarjetaRegistroPuntoControl WHERE idPuntoControlRuta IN (
						SELECT idPuntoControlEjecucion FROM 3106_asignacionHorarioRuta a,3109_puntosControlRutaEjecucion p WHERE idTarjeta=".$fAsignacion[0]." AND p.idAsignacion=a.idAsignacion)
						AND folioTalon=".$idTalon." AND total>0";
			$nReg=$con->obtenerValor($consulta);
			if($nReg>0)
			{
				$consulta="SELECT folioTarjeta,situacion,colorTarjeta FROM 1108_asignacionTarjetaChofer WHERE idRegistro=".$fAsignacion[0];
				$fDatosTarjeta=$con->obtenerPrimeraFila($consulta);
				$consulta="select color FROM _1031_tablaDinamica where id__1031_tablaDinamica=".$fDatosTarjeta[2];
				$color=$con->obtenerValor($consulta);	
				$situacion="";
				switch($fDatosTarjeta[1])
				{
					case 2:
						$situacion="En uso/Recorrido";
					break;
					case 5:
						$situacion="En espera de liquidaci&oacute;n";
					break;	
				}
				$tabla.="<tr><td><br><br>El tal&oacute;n ingresado se encuentra registrado en la tarjeta <b>".$fDatosTarjeta[0]." (".$color.")</b> el cual se encuentra en estado: <b>".$situacion."</b></td></tr>";
				
				$abortarOperacion=true;
		
			}
			
		}
		$tabla.="<tr><td><br><br>Primero debe liquidar las tarjetas indicadas anteriormente, y posteriormente remover el tal&oacute;n </td></tr>";
		$tabla.="</table>";
		
		if($abortarOperacion)
		{
			echo $tabla;
			return;	
		}
		
		
		$consulta="select boletosExistencia from 1102_talonesBoletos where idTalon=".$idTalon;
		$boletosExistencia=$con->obtenerValor($consulta);
		
		$montoDescuento=$boletosExistencia*$montoBoleto;
		
		$x=0;
		
		
		
		$query[$x]="begin";
		$x++;
		$query[$x]="UPDATE 1105_asignacionBoletosChofer SET situacion=0,fechaBaja='".date("Y-m-d H:i:s")."',motivoBaja='".cv($motivo)."',idResponsableBaja=".$_SESSION["idUsr"]." WHERE idAsignacion=".$idAsignacion;
		$x++;
		
		$query[$x]="UPDATE 1102_talonesBoletos SET situacion=3 WHERE idTalon=".$idTalon;
		$x++;
		$query[$x]="DELETE FROM 1102_detalleTarjetaAsignada WHERE idAsignacion IN 
				(SELECT idRegistro FROM 1108_asignacionTarjetaChofer WHERE idChofer=".$idChofer." AND situacion IN (2,5)) and idTalon=".$idTalon;
		$x++;
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
		{
			$consulta="SELECT idAdeudo FROM 3113_adeudosChofer WHERE tipoConceptoAdeudo=2 and referencia1=".$idAsignacion;
			$idAdeudo=$con->obtenerValor($consulta);
			
			
			if(registrarAbonoAdeudo($idAdeudo,$montoDescuento,2,"Desasignación del talon ".$idTalon.", Total folios: ".$boletosExistencia,""))
				echo "1|";		
		}
	}
	
	function buscarDatosTalonBoletosFolio()
	{
		global $con;
		$folio=$_POST["folio"];
		$aRegistros="";
		$consulta="SELECT idTalon,v.boleto,t.folioInicial,t.folioFinalActual,t.folioActual,boletosExistencia as total,t.situacion,
					(SELECT CONCAT(IF(c.aPaterno IS NULL,'',c.aPaterno),' ',IF(c.aMaterno IS NULL,'',c.aMaterno),' ',IF(c.nombre IS NULL,'',c.nombre))  FROM 1105_asignacionBoletosChofer a,
					_1013_tablaDinamica c WHERE folioTalon=t.idTalon AND situacion=1 AND c.id__1013_tablaDinamica=a.idChofer) as choferAsignado,t.monto,t.folioFinal 
					FROM 1102_talonesBoletos t,_1040_gridDetalleCompra g,1000_vistaTiposBoletos v WHERE idTalon=".$folio."
					AND g.id__1040_gridDetalleCompra=t.tipoBoleto AND v.idTipoBoleto=g.tipoBoleto";
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$total=(($fila[3]-$fila[2])+1)-obtenerTotalFoliosBaja($fila[0],$fila[2],$fila[3]);
			$montoBoleto=$fila[8];
			if($fila[5]==0)
			{
				$fila[4]=-1;
				$fila[3]=-1;
					
			}
			
			
			$o='{"idTalon":"'.$fila[0].'","boleto":"'.$fila[1].'","folioInicial":"'.$fila[2].'","folioFinal":"'.$fila[9].'","folioActual":"'.$fila[4].
				'","total":"'.$fila[5].'","situacion":"'.$fila[6].'","choferAsignado":"'.$fila[7].'","montoBoleto":"'.$montoBoleto.'","ultimoActual":"'.$fila[3].'"}'	;
			if($aRegistros=="")	
				$aRegistros=$o;
			else
				$aRegistros.=",".$o;
		}
		
		
		echo "1|[".$aRegistros."]";
		
		
	}
	
	function buscarRelacionTalonesChofer()
	{
		global $con;
		$folio=$_POST["folio"];
		$consulta="SELECT idAsignacion,(SELECT CONCAT(IF(c.aPaterno IS NULL,'',c.aPaterno),' ',IF(c.aMaterno IS NULL,'',c.aMaterno),' ',IF(c.nombre IS NULL,'',c.nombre))  
				FROM _1013_tablaDinamica c WHERE c.id__1013_tablaDinamica=a.idChofer) AS choferAsignado,
				fechaBaja,motivoBaja,montoBoleto,a.situacion,a.fechaAsignacion,a.folioInicial,a.folioFinal,a.idChofer FROM 1105_asignacionBoletosChofer a WHERE folioTalon=".$folio." ORDER BY folioTalon DESC";
		$numReg=0;
		$registros="";
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$ultimoBoleto=obtenerUltimoBoletoVendido($folio,$fila[9]);
			$total=($ultimoBoleto-$fila[7]+1)-obtenerTotalFoliosBaja($folio,$fila[7],$ultimoBoleto);
			if($total<0)
				$total=0;
			
			
			$o='{"idAsignacion":"'.$fila[0].'","choferAsignado":"'.$fila[1].'","fechaBaja":"'.$fila[2].'","motivoBaja":"'.$fila[3].
				'","montoBoleto":"'.$fila[4].'","situacion":"'.$fila[5].'","fechaAsignacion":"'.$fila[6].'","folioInicial":"'.$fila[7].'","folioFinal":"'.$ultimoBoleto.'","total":"'.$total.'"}';
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';
			
	}
	
	function obtenerBajasBoletosTalon()
	{
		global $con;
		$folio=$_POST["folio"];
		$consulta="SELECT folioInicial,folioFinal,fechaBaja,(select Nombre from 800_usuarios where idUsuario=b.responsableBaja)as responsableBaja,idMotivoBaja,comentariosBaja,idChoferAsignado,(folioFinal-folioInicial+1) AS totalBaja 
					FROM 1106_bajasBoletosTalon b WHERE idTalon=".$folio." ORDER BY folioInicial"	;
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function registrarBajasBoletosTalon()
	{
		global $con;
		
		$cadObj=$_POST["cadObj"];	
		$obj=json_decode($cadObj);

		$query="SELECT idChofer,idAsignacion,montoBoleto FROM 1105_asignacionBoletosChofer WHERE folioTalon=".$obj->idTalon." AND situacion=1";
		$fAsignacion=$con->obtenerPrimeraFila($query);
		$idChofer=$fAsignacion[0];
		$idAsignacion=$fAsignacion[1];
		$montoBoleto=$fAsignacion[2];
		if($idChofer=="")
			$idChofer=-1;

		$comp=generarConsultaIntervalos($obj->folioInicial,$obj->folioFinal,"folioInicial","folioFinal",true);
		
		$arrIntervalos=array();
		$query="SELECT folioInicial,folioFinal FROM 1106_bajasBoletosTalon WHERE idTalon=".$obj->idTalon." and ".$comp." order by folioInicial";
		
		$rRegistros=$con->obtenerFilas($query);
		while($fRegistro=mysql_fetch_row($rRegistros))
		{
			array_push($arrIntervalos,$fRegistro);
		}
		
		$arrFoliosCandidatos=array();
		
		for($pos=$obj->folioInicial;$pos<=$obj->folioFinal;$pos++)
		{
			$arrFoliosCandidatos[$pos]=0;
		}
		
		$arrIntervalosBaja=array();
		foreach($arrIntervalos as $i)
		{
			for($pos=$i[0];$pos<=$i[1];$pos++)
			{
				if(isset($arrFoliosCandidatos[$pos]))
					$arrFoliosCandidatos[$pos]=1;
			}	
		}
		
		$fInicial=NULL;
		$fFinal=NULL;
		$arrIntervalosBaja=array();
		foreach($arrFoliosCandidatos as $folio=>$valor)
		{
			if($valor==0)	
			{
				if($fInicial==NULL)	
					$fInicial=$folio;
				else
				{
					$fFinal=$folio;
				}
			}
			else
			{
				if($fInicial!=NULL)	
				{
					if($fFinal==NULL)	
						$fFinal=$fInicial;
					$i=array();
					$i[0]=$fInicial;
					$i[1]=$fFinal;
					array_push($arrIntervalosBaja,$i);
					$fInicial=NULL;
					$fFinal=NULL;
					
				
				}
			}
		}
		
		if($fInicial!=NULL)	
		{
			if($fFinal==NULL)	
				$fFinal=$fInicial;
			$i=array();
			$i[0]=$fInicial;
			$i[1]=$fFinal;
			array_push($arrIntervalosBaja,$i);
			$fInicial=NULL;
			$fFinal=NULL;
			
		
		}
		
		
		$query="SELECT folioActual,folioFinalActual FROM 1102_talonesBoletos WHERE idTalon=".$obj->idTalon;
		$fTalon=$con->obtenerPrimeraFila($query);
		
		$listaFolio="";
		if(sizeof($arrIntervalosBaja)>0)
		{
			$totalBoletosBaja=0;
			$x=0;
			$consulta[$x]="begin";
			$x++;		
			foreach($arrIntervalosBaja as $i)	
			{
				$totalBoletosBaja+=($i[1]-$i[0]+1);
				$consulta[$x]="INSERT INTO 1106_bajasBoletosTalon(idTalon,folioInicial,folioFinal,fechaBaja,responsableBaja,idMotivoBaja,comentariosBaja,idChoferAsignado)
						VALUES(".$obj->idTalon.",".$i[0].",".$i[1].",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$obj->idMotivoBaja.",'".cv($obj->comentariosAdicionales)."',".$idChofer.")";
				$x++;
				
				if($listaFolio=="")
					$listaFolio=$i[0]." - ".$i[1];
				else
					$listaFolio.=", ".$i[0]." - ".$i[1];
				
			}
			
			
			
			$consulta[$x]="commit";
			$x++;
			
			if($con->ejecutarBloque($consulta))
			{
				$folioActualTalon=obtenerProximoFolioActual($obj->idTalon,$fTalon[0]);	
				$ultimoFolioActual=obtenerProximoFolioTerminoActual($obj->idTalon);
				$existencia=0;
				if($folioActualTalon==-1)
					$existencia=0;
				else
				{
					$existencia=($ultimoFolioActual-$folioActualTalon+1)-obtenerTotalFoliosBaja($obj->idTalon,$folioActualTalon,$ultimoFolioActual);
					if($existencia<0)
						$existencia=0;
				}
			
			
			
				$consulta=array();
				$x=0;
				$consulta[$x]="begin";
				$x++;		
				$consulta[$x]="UPDATE 1102_talonesBoletos SET folioActual=".$folioActualTalon.",folioFinalActual=".$ultimoFolioActual.",boletosExistencia=".$existencia." WHERE idTalon=".$obj->idTalon;
				$x++;
				$consulta[$x]="UPDATE 1105_asignacionBoletosChofer SET folioActual=".$folioActualTalon." WHERE folioTalon=".$obj->idTalon." AND situacion=1";
				$x++;
				if($existencia==0)
				{
					$consulta[$x]="UPDATE 1102_talonesBoletos SET situacion=4 WHERE idTalon=".$obj->idTalon;
					$x++;
					$consulta[$x]="UPDATE 1105_asignacionBoletosChofer SET situacion=2,fechaBaja='".date("Y-m-d H:i:s")."',idResponsableBaja=".$_SESSION["idUsr"]." WHERE folioTalon=".$obj->idTalon." AND situacion=1";
					$x++;
					
					$abortarOperacion=false;
					$query=" SELECT idRegistro FROM 1108_asignacionTarjetaChofer WHERE idChofer=".$idChofer." AND situacion IN (2,5)";
					
					$rAsignacion=$con->obtenerFilas($query);
					while($fAsignacion=mysql_fetch_row($rAsignacion))
					{
						$query="SELECT * FROM 1102_detalleTarjetaAsignada WHERE idAsignacion=".$fAsignacion[0]." AND idTalon=".$obj->idTalon;
						
						$fTalonAsignacion=$con->obtenerPrimeraFila($query);	
						
						$query="SELECT COUNT(*) FROM 3110_tarjetaRegistroPuntoControl WHERE idPuntoControlRuta IN (
									SELECT idPuntoControlEjecucion FROM 3106_asignacionHorarioRuta a,3109_puntosControlRutaEjecucion p WHERE idTarjeta=".$fAsignacion[0]." AND p.idAsignacion=a.idAsignacion)
									AND folioTalon=".$obj->idTalon." AND total>0";
						$nReg=$con->obtenerValor($query);
						if($nReg==0)
						{
							$consulta[$x]="DELETE FROM 1102_detalleTarjetaAsignada WHERE idDetalle=".$fTalonAsignacion[0];
							$x++;
					
						}
						
					}
					
					
					
				}
				
				$consulta[$x]="commit";
				$x++;					
				
				
				
								
				if($con->ejecutarBloque($consulta))
				{
					$query="SELECT cmbCargarMontoBaja,motivoBaja FROM _1054_tablaDinamica WHERE id__1054_tablaDinamica=".$obj->idMotivoBaja;
					$fMotivoBaja=$con->obtenerPrimeraFila($query);
					
					$cargaMontoBaja=$fMotivoBaja[0];
					$motivoBaja=$fMotivoBaja[1];
					if($idChofer!=-1)
					{
						$query="SELECT idAdeudo FROM 3113_adeudosChofer WHERE tipoConceptoAdeudo=2 AND referencia1=".$idAsignacion;
						$idAdeudo=$con->obtenerValor($query);	
						$montoAbono=$totalBoletosBaja*$montoBoleto;		
						$descripcion="Baja de boletos, Talon: ".$obj->idTalon.", Motivo: ".$motivoBaja.", Folios: ".$listaFolio;			
						registrarAbonoAdeudo($idAdeudo,$montoAbono,2,$descripcion);
						if($cargaMontoBaja==1)
						{
							if(registrarAdeudoChofer($idChofer,$montoAbono,5,$descripcion,$idAsignacion))
							{
								echo "1|";	
							}
							
						}
						else
							echo "1|";
					}
					else
						echo "1|";
				}
			}
		}
		else
		{
			echo "El intervalo de folios que desea registrar como baja ya han sido dados de baja previamente";
		}
		
		
	}
	
	function obtenerCambiosCostoBoleto()
	{
		global $con;
		$folio=$_POST["folio"];
		$consulta="SELECT idRegistro,costoBoleto,folioInicial,folioFinal,fechaCambio,(SELECT Nombre FROM 800_usuarios WHERE idUsuario=c.idResponsableCambio) AS responsableCambio,comentariosCambio FROM 1107_cambiosCostoTalon c WHERE idTalon=".$folio." order by idRegistro desc";	
		$numReg=0;
		$registros="";
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{

			$total=($fila[3]-$fila[2]+1)-obtenerTotalFoliosBaja($folio,$fila[2],$fila[3]);
			
			
			$o='{"idRegistro":"'.$fila[0].'","costoBoleto":"'.$fila[1].'","folioInicial":"'.$fila[2].'","folioFinal":"'.$fila[3].
				'","fechaCambio":"'.$fila[4].'","responsableCambio":"'.$fila[5].'","comentariosCambio":"'.$fila[6].'","totalBoletos":"'.$total.'"}';
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';
	}
	
	function registrarCambiosCostoBoleto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];	
		$obj=json_decode($cadObj);
		
		$query="SELECT folioActual,folioFinal FROM 1102_talonesBoletos WHERE idTalon=".$obj->idTalon;
		$fRegistro=$con->obtenerprimeraFila($query);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="INSERT INTO 1107_cambiosCostoTalon(fechaCambio,folioInicial,folioFinal,costoBoleto,idResponsableCambio,comentariosCambio,idTalon)
					VALUES('".date("Y-m-d H:i:s")."',".$fRegistro[0].",".$fRegistro[1].",".$obj->costoBoleto.",".$_SESSION["idUsr"].",'".cv($obj->motivoCambio)."',".$obj->idTalon.")";
		$x++;
		$consulta[$x]="UPDATE 1102_talonesBoletos SET monto=".$obj->costoBoleto." WHERE idTalon=".$obj->idTalon;
		$x++;
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function obtenerAsignacionTarjetasChofer()
	{
		global $con;
		$idChofer=$_POST["idChofer"];
		$situacion=$_POST["situacion"];
		
		$comp="";
		switch($situacion)
		{
			case 0:
				
			break;
			case 1:
				$comp=" and a.situacion=1";
			break;
			case 2:
				$comp=" and a.situacion=2";
			break;
			case 3:
				$comp=" and a.situacion=3";
			break;
			case 4:
				$comp=" and a.situacion=4";
			break;
			case 5:
				$comp=" and a.situacion=5";
			break;
				
		}
		
		$registros="";
		$consulta="	SELECT idRegistro,idTarjeta,a.colorTarjeta,a.folioTarjeta,a.situacion,fechaAsignacion,fechaUltimaOperacion,
					comentariosAdicionales FROM 1108_asignacionTarjetaChofer a WHERE idChofer=".$idChofer.$comp;
		//$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$o='{"idAsignacion":"'.$fila[0].'","idTarjeta":"'.$fila[1].'","colorTarjeta":"'.$fila[2].'","folioTarjeta":"'.
				$fila[3].'","situacion":"'.$fila[4].'","fechaAsignacion":"'.$fila[5].'","fechaUltimaOperacion":"'.$fila[6].'","comentariosAdicionales":"'.$fila[7].'"}'	;
			if($registros=="")	
				$registros=$o;
			else
				$registros.=",".$o;
		}
		
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$registros.']}';
			
	}
	
	function obtenerTarjetaDisponibleAsignacion()
	{
		global $con;
		$color=$_POST["color"];
		$folio=$_POST["folio"];
		$consulta="SELECT idTarjetaInventario FROM 1101_tarjetasInventario WHERE folio=".$folio." AND color=".$color." and situacion in (0)";	
		$idTarjeta=$con->obtenerValor($consulta);
		if($idTarjeta=="")
			$idTarjeta=0;
		echo "1|".$idTarjeta;
		
	}
	
	function registrarAsignacionTarjetaChofer()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="INSERT INTO 1108_asignacionTarjetaChofer(idTarjeta,colorTarjeta,folioTarjeta,situacion,fechaAsignacion,responsableAsignacion,idChofer)
						VALUES(".$obj->idTarjeta.",".$obj->color.",".$obj->folioTarjeta.",1,'".date("Y-m-d H.i:s")."',".$_SESSION["idUsr"].",".$obj->idChofer.")";
		$x++;
		$consulta[$x]="UPDATE 1101_tarjetasInventario SET situacion=1 WHERE idTarjetaInventario=".$obj->idTarjeta;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			echo "1|".$con->obtenerUltimoID();
		}
	}
	
	function registrarDesasignacionTarjetaChofer()
	{
		global $con;	
		$idAsignacion=$_POST["idAsignacion"];
		$motivo=$_POST["motivo"];
		
		$query="SELECT idTarjeta FROM 1108_asignacionTarjetaChofer WHERE idRegistro=".$idAsignacion;
		$idTarjeta=$con->obtenerValor($query);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="UPDATE 1101_tarjetasInventario SET situacion=0 WHERE idTarjetaInventario=".$idTarjeta;
		$x++;
		$consulta[$x]="UPDATE 1108_asignacionTarjetaChofer SET situacion=3,fechaUltimaOperacion='".date("Y-m-d H:i:s")."',comentariosAdicionales='".cv($motivo)."',idResponsableUltimaOperacion=".$_SESSION["idUsr"]." WHERE idRegistro=".$idAsignacion;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerTalonesDiponiblesTarjeta()
	{
		global $con;
		$idChofer=$_POST["idChofer"];
		$idTarjeta=$_POST["idTarjeta"];
		$consulta="SELECT idTarjeta,colorTarjeta,situacion FROM 1108_asignacionTarjetaChofer WHERE idRegistro=".$idTarjeta;
		$fFila=$con->obtenerPrimeraFila($consulta);
		

		$talones="";
		$totalTarjeta=0;
		
		switch($fFila[2])
		{
			case 1:
				$consulta="	SELECT idAsignacion,a.folioTalon,a.folioActual,t.folioFinal,v.boleto as descripcion,
							a.montoBoleto,a.folioInicial FROM 1105_asignacionBoletosChofer a,1102_talonesBoletos t,_1040_gridDetalleCompra g,1000_vistaTiposBoletos v WHERE idChofer=".$idChofer."
							AND g.id__1040_gridDetalleCompra=t.tipoBoleto AND v.idTipoBoleto=g.tipoBoleto and t.idTalon=a.folioTalon and a.situacion=1 ORDER BY idAsignacion";
				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					$totalFoliosBaja=obtenerTotalFoliosBaja($fila[1],$fila[2],$fila[3]); 
					$total=(($fila[3]-$fila[2])+1)-$totalFoliosBaja;
					
					$montoTotal=$total*$fila[5];
					
					
					$totalTarjeta+=$montoTotal;
					
					$o="['".$fila[1]."','".$fila[4]."','".$fila[5]."','".$fila[2]."','".$fila[2]."','".cv($fila[3])."','".$totalFoliosBaja."','".$total."','".$montoTotal."','','','-1']";
					if($talones=="")	
						$talones=$o;
					else
						$talones.=",".$o;
				}
			
			break;
			case 2:
				$consulta="	SELECT a.idTalon,a.costoUnitario,a.folioInicial,a.folioFinal,v.boleto FROM 1102_detalleTarjetaAsignada a,1102_talonesBoletos t,_1040_gridDetalleCompra g,1000_vistaTiposBoletos v, 1105_asignacionBoletosChofer asg WHERE 
							g.id__1040_gridDetalleCompra=t.tipoBoleto AND v.idTipoBoleto=g.tipoBoleto AND t.idTalon=a.idTalon AND a.idAsignacion=".$idTarjeta." and t.idTalon=asg.folioTalon and asg.idChofer=".$idChofer." and asg.situacion=1";
			
				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					$totalFoliosBaja=obtenerTotalFoliosBaja($fila[0],$fila[2],$fila[3]); 
					$total=(($fila[3]-$fila[2])+1)-$totalFoliosBaja;
					$montoTotal=$total*$fila[1];
					
					
					$totalTarjeta+=$montoTotal;
					
					$consulta="SELECT folioActual FROM 1102_talonesBoletos WHERE idTalon=".$fila[0];
					$fActual=$con->obtenerValor($consulta);
					$uBoletoVendido=obtenerUltimoBoletoVendido($fila[0],$idChofer);
					
					if($uBoletoVendido<$fila[2])
						$uBoletoVendido=-1;
					
					$o="['".$fila[0]."','".$fila[4]."','".$fila[1]."','".$fila[2]."','".$fActual."','".$fila[3]."','".$totalFoliosBaja."','".$total."','".$montoTotal."','','','".$uBoletoVendido."']";
					if($talones=="")	
						$talones=$o;
					else
						$talones.=",".$o;
				}
			
			
			break;
		}
		
		echo "1|[".$talones."]|".$totalTarjeta;	
	}
	
	function obtenerTalonesTarjetaActual()
	{
		global $con;
		$sActivo=0;
		if(isset($_POST["sActivo"]))
			$sActivo=$_POST["sActivo"];
			
		$vCierreRuta=0;
		if(isset($_POST["vCierreRuta"]))	
			$vCierreRuta=$_POST["vCierreRuta"];
			
		$idTarjeta=$_POST["idTarjeta"];
		$consulta="SELECT idTarjeta,colorTarjeta,situacion,idChofer FROM 1108_asignacionTarjetaChofer WHERE idRegistro=".$idTarjeta;
		$fFila=$con->obtenerPrimeraFila($consulta);
		$idChofer=$fFila[3];
		$talones="";
		$totalTarjeta=0;
		
		$consulta="SELECT metodoRegistroBoletoPuntoControl FROM _1033_tablaDinamica";
		$metodoRegistroBoletoPuntoControl=$con->obtenerValor($consulta);	
		
		$consulta="	SELECT distinct a.idTalon,a.costoUnitario,a.folioInicial,a.folioFinal,v.boleto FROM 1102_detalleTarjetaAsignada a,1102_talonesBoletos t,_1040_gridDetalleCompra g,1000_vistaTiposBoletos v,1105_asignacionBoletosChofer asg WHERE 
							g.id__1040_gridDetalleCompra=t.tipoBoleto AND v.idTipoBoleto=g.tipoBoleto AND t.idTalon=a.idTalon AND asg.folioTalon=t.idTalon 
							and  a.idAsignacion=".$idTarjeta;
		
		if($sActivo==1)
		{
			$consulta.=" and asg.situacion=1";
		}
		
		$consulta.=" order by a.idTalon";
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$total=0;
			$montoTotal=0;
			$uBoletoVendido=obtenerUltimoBoletoVendido($fila[0],$idChofer);
			if($uBoletoVendido<$fila[2])
				$uBoletoVendido=-1;
			
			
			if($vCierreRuta==1)
			{
				$consulta="SELECT idAsignacion FROM 3106_asignacionHorarioRuta WHERE idTarjeta=".$idTarjeta."  LIMIT 0,1";
				$idAsignacion=$con->obtenerValor($consulta);
				$consulta="SELECT * FROM 3110_tarjetaRegistroPuntoControl WHERE idPuntoControlRuta IN (
							SELECT idPuntoControlEjecucion FROM 3109_puntosControlRutaEjecucion WHERE idAsignacion IN (".$idAsignacion.")) AND folioTalon=".$fila[0]." ORDER BY idRegistro DESC LIMIT 0,1";
				
				$fFolio=$con->obtenerPrimeraFila($consulta);

				$uBoletoVendido=$fFolio[4];
				
				if($fFolio[10]==0)
					$uBoletoVendido--;
					
				if($uBoletoVendido=="")
					$uBoletoVendido=-1;
					
				if($uBoletoVendido<$fila[2])
					$uBoletoVendido=-1;	
					
			}
			

			$totalFoliosBaja=0; 
			$folioActual=$uBoletoVendido+1;
			if($metodoRegistroBoletoPuntoControl==0)
			{
				
				if($uBoletoVendido==-1)
				{
					$folioActual=$fila[2];
					$totalFoliosBaja=0;
					$total=0;
					$montoTotal=0;
				}
				else
				{
					$folioActual=$uBoletoVendido+1;
					$totalFoliosBaja=0;
					$total=0;
					$montoTotal=0;	
				}
				
			}
			else
			{
				$folioActual=0;
				$totalFoliosBaja=0;
				$total=0;
				$montoTotal=0;	
			}
			
			$totalTarjeta+=$montoTotal;
			$o="['".$fila[0]."','".$fila[4]."','".$fila[1]."','".$fila[2]."','".$folioActual."','".$fila[3]."','".$totalFoliosBaja.
				"','".$total."','".$montoTotal."','','','".$uBoletoVendido."']";
			if($talones=="")	
				$talones=$o;
			else
				$talones.=",".$o;
		}
	
		
		
		
		echo "1|[".$talones."]|".$totalTarjeta;	
		
		
	}
	
	function buscarDatosRegistroIngresoPuntoControl()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$unidad=-1;
		if(isset($_POST["unidad"]))
			$unidad=$_POST["unidad"];
		
		$idChofer=-1;
		if(isset($_POST["idChofer"]))
			$idChofer=$_POST["idChofer"];
		$fechaActual=$_POST["fecha"];
		$consulta="";
		
		$idPuntoControlEjecucion=-1;
		$origen="";
		
		
		$idPuntoControl=0;
		if(isset($_POST["puntoControl"]))
			$idPuntoControl=$_POST["puntoControl"];
		
		switch($criterio)
		{
			case "1":
				$consulta="SELECT id__1012_tablaDinamica FROM _1012_tablaDinamica WHERE numEconomico=".$unidad." AND idEstado=2";
				$idUnidad=$con->obtenerValor($consulta);
				if($idUnidad!="")
					$consulta="SELECT a.idAsignacion,a.idHorarioAsignacion,a.idUnidadAsignada,if(idChoferAsignado is null,-1,idChoferAsignado),a.idTarjeta FROM 3106_asignacionHorarioRuta a, 1108_asignacionTarjetaChofer t
					WHERE a.fecha='".$fechaActual."' AND a.idUnidadAsignada= ".$idUnidad." and t.idRegistro=a.idTarjeta and t.situacion in (1,2) order by idAsignacion desc";
				else
				{
					echo "1|-1";	
					return;	
				}
					
			break;
			case "2":
				$consulta="SELECT a.idAsignacion,a.idHorarioAsignacion,a.idUnidadAsignada,if(idChoferAsignado is null,-1,idChoferAsignado),a.idTarjeta FROM 3106_asignacionHorarioRuta a,, 1108_asignacionTarjetaChofer t
				WHERE a.fecha='".$fechaActual."' AND a.idChoferAsignado= ".$idChofer."  and t.idRegistro=a.idTarjeta and t.situacion in (1,2) order by idAsignacion desc";
			break;
		}
		
		$fConsulta=$con->obtenerPrimeraFila($consulta);
		if($fConsulta)
		{
			$fPuntoControl=NULL;	
			if($idPuntoControl!=0)
			{
				
				$consulta="SELECT * FROM 3109_puntosControlRutaEjecucion WHERE idAsignacion=".$fConsulta[0]." AND idPuntoControl=".$idPuntoControl." and situacion=1";	
				$fPuntoControl=$con->obtenerPrimeraFila($consulta);
				if(!$fPuntoControl)
				{
					
					$consulta="SELECT * FROM 3109_puntosControlRutaEjecucion WHERE idAsignacion=".$fConsulta[0]." AND idPuntoControl=".$idPuntoControl;	
					$fPuntoControl=$con->obtenerPrimeraFila($consulta);
					if(!$fPuntoControl)
					{
						echo '1|-3';
						return;	
					}
					else
					{
						echo '1|-4';
						return;	
					}
				}
				
				$idPuntoControlEjecucion=$fPuntoControl[0];
				$consulta="SELECT nombreTerminal FROM _1010_tablaDinamica WHERE id__1010_tablaDinamica=".$fPuntoControl[9];
				$origen=$con->obtenerValor($consulta);
				
				
			}
			
			$idChofer=$fConsulta[3];
			$idUnidad=$fConsulta[2];
			$consulta="SELECT * FROM _1012_tablaDinamica WHERE  id__1012_tablaDinamica=".$fConsulta[2];
			$fUnidad=$con->obtenerPrimeraFila($consulta);

			$consulta="SELECT nombreMarca FROM _1011_tablaDinamica WHERE id__1011_tablaDinamica=".$fUnidad[15];
			$marca=$con->obtenerValor($consulta);
			
			if($fUnidad[12]=="")
				$fUnidad[12]=-1;
			$nombre=obtenerNombreUsuario($fUnidad[12]);
			

			$fAsig[0]=$fConsulta[1];
			$fAsig[1]=$fConsulta[0];
			$idHorarioAsignacion=$fAsig[0];
			$idAsignacion=$fAsig[1];
			if($idHorarioAsignacion=="")
				$idHorarioAsignacion=-1;
			$consulta="SELECT p.horario,r.nombreRuta  FROM 3105_horarioEjecucionRuta h,3103_horariosPerfilRuta p,3100_rutasTransportes r WHERE h.idHorarioEjecucion=".$idHorarioAsignacion." AND  p.idHorarioPerfil=h.idHorario
					AND r.idRuta=h.idRuta";
			$fRuta=$con->obtenerPrimeraFila($consulta);

			$datosUnidad='{"noEconomico":"'.$fUnidad[10].'","marca":"'.cv($marca).'","modelo":"'.$fUnidad[14].'","noPlacas":"'.$fUnidad[16].'","noMotor":"'.$fUnidad[13].'","propietario":"'.cv($nombre).'","ruta":"['.$fRuta[0].'] '.cv($fRuta[1]).'","idAsignacion":"'.$idAsignacion.'","idUnidad":"'.$fUnidad[0].'"}';	
			
			$consulta="SELECT * FROM _1013_tablaDinamica WHERE id__1013_tablaDinamica=".$fConsulta[3];
			$fChofer=$con->obtenerPrimeraFila($consulta);
			if($fChofer)
			{
				
			
				$consulta="SELECT idArchivoImagen FROM 9058_imagenesControlGaleria where idElementoFormulario=8650 AND idRegistro=".$fChofer[0];
				$idArchivo=$con->obtenerValor($consulta);
				$imagen="";
				if($idArchivo=="")
					$imagen="../images/imgNoDisponible.jpg";
				else
					$imagen="../paginasFunciones/obtenerArchivos.php?id=".bE($idArchivo);
				
				$edad="";
				$consulta="SELECT l.numeroLicencia,l.fechaVigencia,t.tipoLicencia FROM _1018_tablaDinamica l,_1009_tablaDinamica t WHERE l.idReferencia=".$fChofer[0]." and '".date("Y-m-d")."'<=fechaVigencia and t.id__1009_tablaDinamica=l.cmbTipoLicencia ORDER BY fechaEmision DESC";
	
				$fLicencia=$con->obtenerPrimeraFila($consulta);
				$fNacimiento="";
				if($fChofer[21]!="")
				{
					$fNacimiento=date("d/m/Y",strtotime($fChofer[21]));
					$edad=obtenerEdad($fChofer[21]);
				}
				
				$vencimientoLicencia="";
				if($fLicencia[1]!="")
					$vencimientoLicencia=date("d/m/Y",strtotime($fLicencia[1]));
					
				$datosChofer='{"nombreChofer":"'.cv($fChofer[11]).' '.cv($fChofer[12]).' '.cv($fChofer[10]).'","fechaNacimiento":"'.$fNacimiento.'","edad":"'.$edad.'","tipoLicencia":"'.$fLicencia[2].'","vencimientoLicencia":"'.$vencimientoLicencia.'","numLicencia":"'.$fLicencia[0].'","imagen":"'.$imagen.'"}';
			}
			else
			{
				$datosChofer='{"nombreChofer":"","fechaNacimiento":"","edad":"","tipoLicencia":"","vencimientoLicencia":"","numLicencia":"","imagen":"../images/imgNoDisponible.jpg"}';
			}
			$idAsignacionTarjeta=$fConsulta[4];
			
			$folioTA="";
			$colorTA="";
			$tarjetas="";
			$consulta="SELECT colorTarjeta,folioTarjeta,situacion,idRegistro FROM 1108_asignacionTarjetaChofer WHERE idChofer=".$idChofer." AND situacion IN (1,2)";
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				
				$consulta="select color FROM _1031_tablaDinamica where id__1031_tablaDinamica=".$fila[0];
				$color=$con->obtenerValor($consulta);	
				$etiqueta=$fila[1]." (".$color.")";
				
				$o="['".$fila[3]."','".$etiqueta."']";
				if($tarjetas=="")
					$tarjetas=$o;
				else
					$tarjetas.=",".$o;
				
				if($fila[2]==2)
				{
					$folioTA=$fila[1];
					$colorTA=$color;	
				}
					
			}
			
			$consulta="SELECT idRegistro FROM 1108_asignacionTarjetaChofer WHERE idChofer=".$idChofer." AND situacion IN (2)";
			$tarjetaActiva=$con->obtenerValor($consulta);
			$datosTarjeta= '{"tarjetaActiva":"'.$idAsignacionTarjeta.'","registros":['.$tarjetas.'],"folio":"'.$folioTA.'","color":"'.$colorTA.'"}';
			
			
			$cadObj='{"origen":"'.cv($origen).'","idPuntoControlEjecucion":"'.$idPuntoControlEjecucion.'","idUnidad":"'.$idUnidad.'","idChofer":"'.$idChofer.'","idTarjeta":"-1","idAsignacionTarjeta":"'.$idAsignacionTarjeta.'","idAsignacion":"'.$fConsulta[0].
						'","datosUnidad":'.$datosUnidad.',"datosChofer":'.$datosChofer.',"datosTarjeta":'.$datosTarjeta.'}';
			echo '1|'.$cadObj;	
		}
		else
		{
			echo "1|-2";	
		}
		
	}
	
	function obtenerVentaBoletosActualTarjeta()
	{
		global $con	;
		$idAsignacionTarjeta=$_POST["idAsignacionTarjeta"];
			
		$arrFoliosTarjeta=array();	
		$consulta="SELECT idTalon FROM 1102_detalleTarjetaAsignada WHERE idAsignacion=".$idAsignacionTarjeta;
		$rFolios=$con->obtenerFilas($consulta);
		while($fFolios=mysql_fetch_row($rFolios))
		{
			$arrFoliosTarjeta[$fFolios[0]]	=1;
		}
			
		$arrFolioTalon=array();
		
		$arrRutas="";
		$consulta="select distinct * from ((SELECT idAsignacion FROM 3106_asignacionHorarioRuta WHERE idTarjeta=".$idAsignacionTarjeta.") 
				union 
				(SELECT idAsignacionRuta FROM 3122_tarjetasAsignadasRecorridosInconclusos WHERE idAsignacionTarjeta=".$idAsignacionTarjeta.")) as tmp  ORDER BY idAsignacion";
		$resAsignacion=$con->obtenerFilas($consulta);
		while($fAsignacion=mysql_fetch_row($resAsignacion))
		{
			$consulta="SELECT idHorarioAsignacion,idAsignacion FROM 3106_asignacionHorarioRuta a WHERE idAsignacion=".$fAsignacion[0];
			$fAsig=$con->obtenerPrimeraFila($consulta);
			
			$idHorarioAsignacion=$fAsig[0];
			$idAsignacion=$fAsig[1];
			if($idHorarioAsignacion=="")
				$idHorarioAsignacion=-1;
			$consulta="SELECT p.horario,r.nombreRuta,fecha  FROM 3105_horarioEjecucionRuta h,3103_horariosPerfilRuta p,3100_rutasTransportes r WHERE h.idHorarioEjecucion=".$idHorarioAsignacion." AND  p.idHorarioPerfil=h.idHorario
					AND r.idRuta=h.idRuta";
			$fRuta=$con->obtenerPrimeraFila($consulta);
		
			$nomRuta='['.date("d/m/Y",strtotime($fRuta[2]))." - ".$fRuta[0].'] '.$fRuta[1];
			
			$consulta="SELECT idPuntoControlEjecucion,idPuntoControl,nombreTerminal,horaLlegadaRegistrada FROM 3109_puntosControlRutaEjecucion p,_1010_tablaDinamica t WHERE idAsignacion=".$fAsignacion[0]." AND p.situacion=2
						AND t.id__1010_tablaDinamica=p.idPuntoControl order by idPuntoControlEjecucion";
		
			$resPuntoControl=$con->obtenerFilas($consulta);
			while($fPuntoControl=mysql_fetch_row($resPuntoControl))
			{
				
				$consulta="SELECT * FROM 3110_tarjetaRegistroPuntoControl WHERE idPuntoControlRuta=".$fPuntoControl[0]." ORDER BY idRegistro";
				$resTarjetaPunto=$con->obtenerFilas($consulta);
				while($fTarjetaPunto=mysql_fetch_row($resTarjetaPunto))
				{
					
					if(isset($arrFoliosTarjeta[$fTarjetaPunto[1]]))
					{
						if(!isset($arrFolioTalon[$fTarjetaPunto[1]]))
						{
							$arrFolioTalon[$fTarjetaPunto[1]]["folioInicial"]=$fTarjetaPunto[2];	
						}
						$arrFolioTalon[$fTarjetaPunto[1]]["folioFinal"]=$fTarjetaPunto[3];	
						
						
						$folioInicial=$arrFolioTalon[$fTarjetaPunto[1]]["folioInicial"];
						$folioFinal=$arrFolioTalon[$fTarjetaPunto[1]]["folioFinal"];
						
						
						if($fTarjetaPunto[10]==1)
						{
							if($fTarjetaPunto[4]!=0)
								$arrFolioTalon[$fTarjetaPunto[1]]["folioInicial"]=$fTarjetaPunto[4]+1;
			
						}
						else
						{
							if($fTarjetaPunto[4]!=0)
								$arrFolioTalon[$fTarjetaPunto[1]]["folioInicial"]=$fTarjetaPunto[4];
							else
								$arrFolioTalon[$fTarjetaPunto[1]]["folioInicial"]=-1;	
						}
						
						$consulta="SELECT tipoBoleto FROM 1102_talonesBoletos WHERE idTalon=".$fTarjetaPunto[1];
						$tBoleto=$con->obtenerValor($consulta);
						$consulta="SELECT clave,c.color FROM _1030_tablaDinamica t,_1031_tablaDinamica c WHERE id__1030_tablaDinamica=".$tBoleto." AND c.id__1031_tablaDinamica=t.color";
						$fDatosBoleto=$con->obtenerPrimeraFila($consulta);
						$descripcion='['.$fDatosBoleto[0].'] Color: '.$fDatosBoleto[1];
						
						$ultimoFolio=-1;
						$foliosBaja=0;
						$total=0;
						$montoTotal=0;
						
						if($fTarjetaPunto[10]==1)
						{
							if($fTarjetaPunto[4]!=0)
							{
								$ultimoFolio=$fTarjetaPunto[4];
								$foliosBaja=obtenerTotalFoliosBaja($fTarjetaPunto[1],$folioInicial,$ultimoFolio);
								
								$total=(($ultimoFolio-$folioInicial)+1)-$foliosBaja;
								$montoTotal=$total*$fTarjetaPunto[9];	
							}
							else
							{
								$ultimoFolio=-1;
								$foliosBaja=0;
								$total=0;
								$montoTotal=0;	
							}
						}
						else
						{
							if($fTarjetaPunto[4]!=0)
							{
								$ultimoFolio=$fTarjetaPunto[4]-1;
								$foliosBaja=obtenerTotalFoliosBaja($fTarjetaPunto[1],$folioInicial,$ultimoFolio);
								$total=(($ultimoFolio-$folioInicial)+1)-$foliosBaja;
								$montoTotal=$total*$fTarjetaPunto[9];	
							}
							else
							{
								$ultimoFolio=$fTarjetaPunto[3];
								$foliosBaja=obtenerTotalFoliosBaja($fTarjetaPunto[1],$folioInicial,$ultimoFolio);
								$total=(($ultimoFolio-$folioInicial)+1)-$foliosBaja;
								$montoTotal=$total*$fTarjetaPunto[9];	
							}
						}
						
						
						$o="['".$fTarjetaPunto[1]."','".$descripcion."','".$fTarjetaPunto[9]."','".$folioInicial."','".$folioFinal."','".$foliosBaja."','0','0','".
							$fTarjetaPunto[4]."','".$total."','".$montoTotal."','".$fAsignacion[0]."','".cv($nomRuta)."','".cv($fPuntoControl[2])."','".$fPuntoControl[2]."']";
							
						if($arrRutas=="")
							$arrRutas=$o;
						else	
							$arrRutas.=",".$o;
					}
				}
			}
			
		}
		echo "1|[".$arrRutas."]";
		
	}
	
	function buscarDatosChoferCambio()
	{
		global $con;
		$fechaActual=date("Y-m-d");
		$idChofer=-1;
		if(isset($_POST["idChofer"]))
			$idChofer=$_POST["idChofer"];
		
		$consulta="SELECT * FROM _1013_tablaDinamica WHERE id__1013_tablaDinamica=".$idChofer;
		$fChofer=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT idArchivoImagen FROM 9058_imagenesControlGaleria where idElementoFormulario=8650 AND idRegistro=".$fChofer[0];
		$idArchivo=$con->obtenerValor($consulta);
		$imagen="";
		if($idArchivo=="")
			$imagen="../images/imgNoDisponible.jpg";
		else
			$imagen="../paginasFunciones/obtenerArchivos.php?id=".bE($idArchivo);
		
		$edad="";
		$consulta="SELECT l.numeroLicencia,l.fechaVigencia,t.tipoLicencia FROM _1018_tablaDinamica l,_1009_tablaDinamica t WHERE l.idReferencia=".$fChofer[0]." and '".$fechaActual.
				"'<=fechaVigencia and t.id__1009_tablaDinamica=l.cmbTipoLicencia ORDER BY fechaEmision DESC";

		$fLicencia=$con->obtenerPrimeraFila($consulta);
		$fNacimiento="";
		if($fChofer[21]!="")
		{
			$fNacimiento=date("d/m/Y",strtotime($fChofer[21]));
			$edad=obtenerEdad($fChofer[21]);
		}
		
		$vencimientoLicencia="";
		if($fLicencia[1]!="")
			$vencimientoLicencia=date("d/m/Y",strtotime($fLicencia[1]));
		
		$idAsignacionTarjeta="";
		$folioTA="";
		$colorTA="";
		$tarjetas="";
		$consulta="SELECT colorTarjeta,folioTarjeta,situacion,idRegistro FROM 1108_asignacionTarjetaChofer WHERE idChofer=".$idChofer." AND situacion IN (1,2)";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$situacion="";
			if($fila[2]==2)
			{
				if($idAsignacionTarjeta=="")
					$idAsignacionTarjeta=$fila[3];
				$situacion=" - Asignada actualmente";
			}
			$consulta="select color FROM _1031_tablaDinamica where id__1031_tablaDinamica=".$fila[0];
			$color=$con->obtenerValor($consulta);	
			$etiqueta=$fila[1]." (".$color.")".$situacion;
			
			$o="['".$fila[3]."','".$etiqueta."']";
			if($tarjetas=="")
				$tarjetas=$o;
			else
				$tarjetas.=",".$o;
			
			if($fila[2]==2)
			{
				$folioTA=$fila[1];
				$colorTA=$color;	
			}
				
		}
		
		$ruta="";
		$situacion=0;
		if($idAsignacionTarjeta!="")
		{
			$consulta="SELECT idHorarioAsignacion,fecha,horario,situacion FROM 3106_asignacionHorarioRuta WHERE idTarjeta=".$idAsignacionTarjeta." AND situacion NOT IN (4,12,14) ORDER BY idAsignacion DESC";
			$fRuta=$con->obtenerPrimeraFila($consulta);
			if($fRuta)	
			{
				$dRuta='['.date("d/m/Y H:i",strtotime($fRuta[1]." ".$fRuta[2])).']';	
				$ruta=$dRuta;
				$consulta="SELECT r.nombreRuta FROM 3105_horarioEjecucionRuta h,3100_rutasTransportes r WHERE idHorarioEjecucion=".$fRuta[0]." AND r.idRuta=h.idRuta";
				$nomRuta=$con->obtenerValor($consulta);
				$ruta.=" ".$nomRuta;	
				$situacion=$fRuta[3];
			}
		}
		$datosChofer='{"nombreChofer":"'.cv($fChofer[11]).' '.cv($fChofer[12]).' '.cv($fChofer[10]).'","fechaNacimiento":"'.$fNacimiento.'","edad":"'.$edad.'","tipoLicencia":"'.$fLicencia[2].
					'","vencimientoLicencia":"'.$vencimientoLicencia.'","numLicencia":"'.$fLicencia[0].'","imagen":"'.$imagen.'","arrTarjetas":['.$tarjetas.
					'],"tarjetaActiva":"'.$idAsignacionTarjeta.'","rutaActual":"'.cv($ruta).'","situacionRuta":"'.$situacion.'"}';
					
					
					
					
		echo "1|".$datosChofer;
	}
	
	function registrarCambioChofer()
	{
		global $con;
		$cadObj=$_POST["cadObj"];	
		$obj=json_decode($cadObj);
		
		$consulta="SELECT idUnidadAsignada,idChoferAsignado,idTarjeta FROM 3106_asignacionHorarioRuta WHERE idAsignacion=".$obj->idAsignacionBase;
		$fRuta=$con->obtenerPrimeraFila($consulta);
		
		$consulta="INSERT INTO 3121_solicitudesCambioChofer(idUnidad,idChoferOriginal,idAsignacion,idChoferCambio,idMotivoCambio,idTarjetaCambio,
					comentariosAdicionales,fechaSolicitud,idResponsable,situacion,idTarjetaOriginal) VALUES
					(".$fRuta[0].",".$fRuta[1].",".$obj->idAsignacionBase.",".$obj->idChoferCambio.",".$obj->idMotivo.",".$obj->idTarjetaUtilizar.",'".cv($obj->comentarios)."',
					'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",1,".$fRuta[2].")";
		
		if($con->ejecutarConsulta($consulta))
		{
			$idSolicitud=$con->obtenerUltimoID();
			registrarAutorizacionSolicitudCambio($idSolicitud);	
			echo "1|";
		}
	}
	
	function obtenerSolicitudesCambioChofer()
	{
		global $con;
		
		
		$numReg=0;
		$arrRegistros="";
		$consulta="SELECT * FROM 3121_solicitudesCambioChofer ORDER BY idRegistro desc";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT folioTarjeta,colorTarjeta FROM 1108_asignacionTarjetaChofer WHERE idRegistro=".$fila[6];
			$fTarjeta=$con->obtenerPrimeraFila($consulta);
			
			
			$consulta="SELECT color FROM _1031_tablaDinamica WHERE id__1031_tablaDinamica=".$fTarjeta[1];
			$color=$con->obtenerValor($consulta);
			$tarjetaChofer=$fTarjeta[1]." (Color: ".cv($color).")";
			$ruta=obtenerNombreRutaAsignacion($fila[4]);
			$o='{"idSolicitud":"'.$fila[0].'","unidad":"'.obtenerNumEconomicoIdUnidad($fila[1]).'","choferOriginal":"'.cv(obtenerNombreChofer($fila[2])).
				'","fechaSolicitud":"'.$fila[9].'","choferReemplazante":"'.cv(obtenerNombreChofer($fila[3])).'","motivoReemplazo":"'.$fila[5].'","rutaReemplazo":"'.cv($ruta["nombreRuta"]).
				'","idTarjetaChofer":"'.$tarjetaChofer.'","comentariosAdicionales":"'.cv($fila[8]).'","situacion":"'.$fila[11].'","fechaAutorizacion":"'.$fila[12].'","autorizadoPor":"'.obtenerNombreUsuario($fila[13]).'"}';
			if($arrRegistros=="")		
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
			
	}
	
	function registrarAjustesLiquidacionTarjeta()
	{
		global $con;	
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$query="SELECT metodoRegistroBoletoPuntoControl FROM _1033_tablaDinamica";
		$metodoRegistroBoletoPuntoControl=$con->obtenerValor($query);
		$idAsignacionTarjeta=$obj->idAsignacionTarjeta;
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		foreach($obj->arrCambios as $r)
		{
			$boletosExistencia=0;
			
			$folioActualTalon=$r->folioActual+$metodoRegistroBoletoPuntoControl;
			$ultimoBoletoVendidoActualTalon=$r->folioActual;
			if($metodoRegistroBoletoPuntoControl==0)
				$ultimoBoletoVendidoActualTalon--;
			
			
			if($r->folioActual!=0)
			{
				$totalFoliosBajas=obtenerTotalFoliosBaja($r->idTalon,$folioActualTalon,$r->folioFinal);	
				$boletosExistencia=1+($r->folioFinal-$folioActualTalon)-$totalFoliosBajas;
			}
			else
			{
				$fActual="";
				if($metodoRegistroBoletoPuntoControl==0)//folio actual
				{
					$boletosExistencia=0;
				}
				else
				{  //Ultimo boleto vendido
					$fActual=$r->folioInicial;
					$totalFoliosBajas=obtenerTotalFoliosBaja($r->idTalon,($fActual),$r->folioFinal);	
					$boletosExistencia=1+($r->folioFinal-$fActual)-$totalFoliosBajas;
					//$r->folioActual=$fActual-1;
				}
			}
			
			$situacionBoleto=2;
			$situacionAsignacion=1;
			$actualizarFolioActual=true;
				
			$arrRegistroBoletos=obtenerRegistrosBoletoPuntosControlTarjeta($r->idTalon,$idAsignacionTarjeta);
			$ultimoRegistro=$arrRegistroBoletos[sizeof($arrRegistroBoletos)-1];
			$actualizarUltimoRegistro=false;
			
			
			$query="select folioActual from 1102_talonesBoletos where idTalon=".$r->idTalon;
			$folioActualBD=$con->obtenerValor($query);
			if(($folioActualTalon<$folioActualBD)&&($boletosExistencia!=0))
				$actualizarFolioActual=false;
			
			$query="SELECT idDetalle FROM 1102_detalleTarjetaAsignada WHERE idAsignacion=".$idAsignacionTarjeta." AND idTalon=".$r->idTalon." ORDER BY idDetalle DESC";	
			$idDetalle=$con->obtenerValor($query);
			
			if($boletosExistencia==0)	
			{
				$situacionBoleto=4;
				$situacionAsignacion=4;
				$actualizarUltimoRegistro=true;
				$query="SELECT DISTINCT idAsignacion FROM 1102_detalleTarjetaAsignada WHERE idTalon=".$r->idTalon." AND idDetalle>".$idDetalle." order by idDetalle asc";

				$rAsignacion=$con->obtenerFilas($query);
				while($fAsignacion=mysql_fetch_row($rAsignacion))
				{
					$query="SELECT idAsignacion FROM 3106_asignacionHorarioRuta WHERE idTarjeta=".$fAsignacion[0]." ORDER BY idAsignacion ASC";
					$rAsignacionesRuta=$con->obtenerFilas($query);
					while($fAsignacionRuta=mysql_fetch_row($rAsignacionesRuta))
					{
					
						$query="SELECT idPuntoControlEjecucion FROM 3109_puntosControlRutaEjecucion WHERE idAsignacion=".$fAsignacionRuta[0] ;
						$lPuntosControl=$con->obtenerListaValores($query);
						if($lPuntosControl=="")
							$lPuntosControl=-1;
						
						$consulta[$x]="delete from 3110_tarjetaRegistroPuntoControl where folioTalon=".$r->idTalon." and idPuntoControlRuta in(".$lPuntosControl.")";
						$x++;	
					}
					
					$consulta[$x]="delete from 1102_detalleTarjetaAsignada where idTalon=".$r->idTalon." and idAsignacion=".$fAsignacion[0];
					$x++;
				}
			}
			else
			{
				if(($r->folioActual>$r->folioOriginal))
				{
					$actualizarUltimoRegistro=true;
					
					$query="SELECT DISTINCT idAsignacion FROM 1102_detalleTarjetaAsignada WHERE idTalon=".$r->idTalon." AND idDetalle>".$idDetalle." and folioInicial<=".$folioActualTalon." order by idDetalle asc";
					$rAsignacion=$con->obtenerFilas($query);
					while($fAsignacion=mysql_fetch_row($rAsignacion))
					{
						
						$query="select * from 1102_detalleTarjetaAsignada WHERE idTalon=".$r->idTalon." and idAsignacion=".$fAsignacion[0];
						$fRegistroAsignacion=$con->obtenerPrimeraFila($query);	
						
						$foliosBaja=obtenerTotalFoliosBaja($r->idTalon,$folioActualTalon,$fRegistroAsignacion[4]);
						
						$total=($fRegistroAsignacion[4]-$folioActualTalon-$foliosBaja)+1;
						if($total<0)	
							$total=0;
						
						$montoTotal=$total*$fRegistroAsignacion[2];
						$consulta[$x]="UPDATE 1102_detalleTarjetaAsignada SET folioInicial=".$folioActualTalon.",foliosBaja=".$foliosBaja.",total=".$total.",montoTotal=".$montoTotal." WHERE idDetalle=".$fRegistroAsignacion[0];
						$x++;
						
						$query="SELECT idAsignacion FROM 3106_asignacionHorarioRuta WHERE idTarjeta=".$fAsignacion[0]." ORDER BY idAsignacion ASC";
						$rAsignacionesRuta=$con->obtenerFilas($query);
						while($fAsignacionRuta=mysql_fetch_row($rAsignacionesRuta))
						{
						
							$query="SELECT idPuntoControlEjecucion FROM 3109_puntosControlRutaEjecucion WHERE idAsignacion=".$fAsignacionRuta[0] ;
							$lPuntosControl=$con->obtenerListaValores($query);
							if($lPuntosControl=="")
								$lPuntosControl=-1;
							
							$query="SELECT * FROM 3110_tarjetaRegistroPuntoControl where folioTalon=".$r->idTalon." and idPuntoControlRuta in(".$lPuntosControl.") and folioInicial<=".$folioActualTalon;
							$registroTPC=$con->obtenerFilas($query);
							while($fTPC=mysql_fetch_row($registroTPC))
							{
								$uBoletoVendido=$fTPC[4];
								if($uBoletoVendido==0)
								{
									if($fTPC[10]==0)
										$uBoletoVendido=$fTPC[3];	
									else
									{
										$uBoletoVendido=$fTPC[12];
										if($uBoletoVendido==-1)
											$uBoletoVendido=$ultimoBoletoVendidoActualTalon;
									}
								}
								else
									if($fTPC[10]==0)
										$uBoletoVendido--;	
								
								
								$foliosBaja=obtenerTotalFoliosBaja($r->idTalon,$folioActualTalon,$uBoletoVendido);
								$total=($uBoletoVendido-$folioActualTalon-$foliosBaja)+1;
								if($total<0)	
									$total=0;
								
								$montoTotal=$total*$fTPC[9];
								$compDetalle="";
								if(($fTPC[2]==$fTPC[4])||($fTPC[4]<$folioActualTalon))
									$compDetalle=",folioActual=".$folioActualTalon;
								$consulta[$x]="UPDATE 3110_tarjetaRegistroPuntoControl SET folioInicial=".$folioActualTalon.",folioBaja=".$foliosBaja.",total=".$total.",montoTotal=".$montoTotal.$compDetalle." WHERE idRegistro=".$fTPC[0];
								$x++;
							}
						}
					}
				}
				else
				{
					$actualizarUltimoRegistro=false;
					//actualizar ventas boleto
					$uBoletoVendidoActualizacion=-1;
					$arrRegistrosPuntoControl=obtenerRegistrosBoletoPuntosControlTarjeta($r->idTalon,$idAsignacionTarjeta);
					foreach($arrRegistrosPuntoControl as $rPC)
					{
						if($rPC[4]>=$folioActualTalon)
						{
							if($uBoletoVendidoActualizacion!=-1)
								$uBoletoVendido=$uBoletoVendidoActualizacion;
							else
							{
								$uBoletoVendido=$rPC[12]+1;
							}
							if($uBoletoVendido==0)
								$uBoletoVendido=$rPC[2];
								
								
							$foliosBaja=obtenerTotalFoliosBaja($r->idTalon,$uBoletoVendido,$ultimoBoletoVendidoActualTalon);
							
							
							$total=($ultimoBoletoVendidoActualTalon-$uBoletoVendido-$foliosBaja)+1;
							if($total<0)	
								$total=0;
							
							$montoTotal=$total*$rPC[9];
							$consulta[$x]="UPDATE 3110_tarjetaRegistroPuntoControl SET folioActual=".$folioActualTalon.",folioBaja=".$foliosBaja.",total=".$total.
											",montoTotal=".$montoTotal.",ultimoFolioVendido=".$uBoletoVendidoActualizacion.",tipoFolio=".$metodoRegistroBoletoPuntoControl." WHERE idRegistro=".$rPC[0];
							$x++;							
							if($total!=0)
							{
								$uBoletoVendidoActualizacion=$ultimoBoletoVendidoActualTalon;
							}
							
							
						}
						else
						{
							$uBoletoVendidoActualizacion=$rPC[4];
							if($rPC[10]!=0)
								$uBoletoVendidoActualizacion++;
							
						}
					}
					
					//actualizar asignaciones posteriores
					$query="SELECT DISTINCT idAsignacion FROM 1102_detalleTarjetaAsignada WHERE idTalon=".$r->idTalon." AND idDetalle>".$idDetalle." and folioInicial<=".($r->folioOriginal+$metodoRegistroBoletoPuntoControl)." order by idDetalle asc";
					$rAsignacion=$con->obtenerFilas($query);
					while($fAsignacion=mysql_fetch_row($rAsignacion))
					{
						$query="select * from 1102_detalleTarjetaAsignada WHERE idTalon=".$r->idTalon." and idAsignacion=".$fAsignacion[0];
						$fRegistroAsignacion=$con->obtenerPrimeraFila($query);	
						$foliosBaja=obtenerTotalFoliosBaja($r->idTalon,$folioActualTalon,$fRegistroAsignacion[4]);
						$total=($fRegistroAsignacion[4]-$folioActualTalon-$foliosBaja)+1;
						if($total<0)	
							$total=0;
						
						$montoTotal=$total*$fRegistroAsignacion[2];
						$consulta[$x]="UPDATE 1102_detalleTarjetaAsignada SET folioInicial=".$folioActualTalon.",foliosBaja=".$foliosBaja.",total=".$total.",montoTotal=".$montoTotal." WHERE idDetalle=".$fRegistroAsignacion[0];
						$x++;
						
						$query="SELECT idAsignacion FROM 3106_asignacionHorarioRuta WHERE idTarjeta=".$fAsignacion[0]." ORDER BY idAsignacion ASC";
						$rAsignacionesRuta=$con->obtenerFilas($query);
						while($fAsignacionRuta=mysql_fetch_row($rAsignacionesRuta))
						{
						
							$query="SELECT idPuntoControlEjecucion FROM 3109_puntosControlRutaEjecucion WHERE idAsignacion=".$fAsignacionRuta[0] ;
							$lPuntosControl=$con->obtenerListaValores($query);
							if($lPuntosControl=="")
								$lPuntosControl=-1;
							
							$query="SELECT * FROM 3110_tarjetaRegistroPuntoControl where folioTalon=".$r->idTalon." and idPuntoControlRuta in(".$lPuntosControl.") and folioInicial<=".($r->folioOriginal+$metodoRegistroBoletoPuntoControl);
							$registroTPC=$con->obtenerFilas($query);
							while($fTPC=mysql_fetch_row($registroTPC))
							{
								
								$uBoletoVendido=$fTPC[4];
								
								if($uBoletoVendido==0)
								{
									if($fTPC[10]==0)
										$uBoletoVendido=$fTPC[3];	
									else
									{
										$uBoletoVendido=$fTPC[12];
										if($uBoletoVendido==-1)
											$uBoletoVendido=$folioActualTalon-1;
									}
								}
								else
									if($fTPC[10]==0)
										$uBoletoVendido--;	
								
								
								$foliosBaja=obtenerTotalFoliosBaja($r->idTalon,$folioActualTalon,$uBoletoVendido);
								$total=($uBoletoVendido-$folioActualTalon-$foliosBaja)+1;
								if($total<0)	
									$total=0;
								
								$montoTotal=$total*$fTPC[9];
								$compDetalle="";
								if($fTPC[2]==$fTPC[4])
									$compDetalle=",folioActual=".$folioActualTalon;
								$consulta[$x]="UPDATE 3110_tarjetaRegistroPuntoControl SET folioInicial=".$folioActualTalon.",folioBaja=".$foliosBaja.",total=".$total.",montoTotal=".$montoTotal.$compDetalle." WHERE idRegistro=".$fTPC[0];
								$x++;
							}
						}
					}
				}
			}
			
			if($actualizarUltimoRegistro)
			{
				$folioInicial=$ultimoRegistro[12]+1;
				if($folioInicial==0)
					$folioInicial=$ultimoRegistro[2];

				$uBoletoVendido=$folioActualTalon;
				if($r->folioActual!=0)
				{
					if($metodoRegistroBoletoPuntoControl==0)
						$uBoletoVendido--;
				}
				else
					$uBoletoVendido=$ultimoRegistro[3];
				
				
				
				
				$foliosBaja=obtenerTotalFoliosBaja($r->idTalon,$folioInicial,$uBoletoVendido);
				$total=($uBoletoVendido-$folioInicial-$foliosBaja)+1;
				if($total<0)	
					$total=0;
				
				$montoTotal=$total*$ultimoRegistro[9];	
				$consulta[$x]="UPDATE 3110_tarjetaRegistroPuntoControl SET folioActual=".$folioActualTalon.",folioBaja=".$foliosBaja.",total=".$total.",montoTotal=".$montoTotal.",tipoFolio=".
								$metodoRegistroBoletoPuntoControl." WHERE idRegistro=".$ultimoRegistro[0];
				$x++;	
				if($boletosExistencia==0)
					$folioActualTalon=-1;
				
			}
			
			if($actualizarFolioActual)	
			{
				$consulta[$x]="UPDATE 1102_talonesBoletos SET folioActual=".($folioActualTalon).",boletosExistencia=".$boletosExistencia.",situacion=".$situacionBoleto." WHERE idTalon=".$r->idTalon;
				$x++;
				$consulta[$x]="UPDATE 1105_asignacionBoletosChofer SET folioActual=".($folioActualTalon).", situacion=".$situacionAsignacion." WHERE folioTalon=".$r->idTalon." AND idChofer=".$obj->idChofer." AND situacion=1";
				$x++;
			}
			
		}
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);


	}
?>