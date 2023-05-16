<?php session_start();
	;
	include("funcionesFormularios.php"); 
	include("configurarIdioma.php");
	include_once("cfdi/funcionesNominaGeneral.php");
	include_once("cfdi/cFDIFinkok.php");
	
	if(isset($_SESSION["leng"]))
	{
		$z=0;
		$consultaS;
		if(isset($_POST["parametros"]))
			$parametros=$_POST["parametros"];
		if(isset($_POST["funcion"]))
			$funcion=$_POST["funcion"];
		$lenguaje=$_SESSION["leng"];
		
		switch($funcion)
		{
			case 1:
				obtenerCriteriosPuesto();
			break;
			case 2:
				guardarCalculoPerfil();
			break;
			case 3:
				borrarCalculosPerfil();
			break;
			case 4:
				modificarValoresCalculo();
			break;
			case 5:
				modificarPuntos();
			break;
			case 6:
				obtenerCriteriosPerfilPuesto();
			break;
			case 7:
				obtenerParametrosCalculo();
			break;
			case 8:
				obtenerPerfilPuesto();
			break;
			case 9:
				borrarPerfilPuesto();
			break;
			case 10:
				marcarCandidatos();
			break;
			case 11:
				obtenerRolesEnfermeriaPeriodo();
			break;
			case 12:
				registroRolEnfermeria();
			break;
			case 13:
				obtenerDatosEmpleado();
			break;
			case 14:
				obtenerResultadosEvaluaciones();//grid de Alma
			break;
			case 15:
				crearRolEnfermeria();
			break;
			case 16:
				agregarEmpleadoRol();
			break;
			case 17:
				removerEmpleadoRol();
			break;
			case 18:
				obtenerDocentesEsperaContrato();
			break;
			case 19:
				crearContratoDocente();
			break;
			case 20:
				obtenerContratos();
			break;
			case 50:
				registrarPerfilMateria();
			break;
			case 51:
				guardarPerfilNomina();
			break;
			case 52:
				guardarAsignacionRol();
			break;
			case 53:
				removerIncidencia();
			break;
			case 54:
				validarAsistenciaProfesor();
			break;
			case 55:
				obtenerDatosEmpleadoSDI();
			break;
			case 56:
				reconstruirNuevaVersionContrato();
			break;
			case 57:
				obtenerVersionesContrato();
			break;
			case 58:
				obtenerPuestosDepartamentosEmpresa();
			break;
			
			
			case 59:
				generarNominaEmpresaV2();
			break;
			case 60:
				obteneDatosNominaEmpleadoV2();
			break;
			case 61:
				modificarNominaEmpleadoV2();
			break;
			case 62:
				obtenerCertificadosSeriesEmpresa();
			break;
			case 63:
				timbrarComprobantesNomina();
			break;
			case 64:
				timbrarComprobantes();
			break;
			case 65:
				obtenerHuellasUsuario();
			break;
			case 66:
				obtenerRecibosNominaUsuario();
			break;
			case 67:
				bloquearDesbloquearDatosUsuarioNomina();
			break;
			
			
			
		}
	}
		function obtenerCriteriosPuesto()
		{
			global $con;
			
			if(isset($_POST["idPuesto"]))
				$idPuesto=$_POST["idPuesto"];
			else
				$idPuesto=2;
			$consulta="SELECT idPerfilVSPuesto,idCriterio,nombreConsulta,valor FROM 9312_perfilPuesto p, 991_consultasSql c  WHERE idPuesto=".$idPuesto." AND idConsulta=idCriterio AND idTipoConcepto>2";
			$res=$con->obtenerFilas($consulta);
			$numReg=$con->filasAfectadas;
		
			$arrCriterios="";
			
			while($fila=mysql_fetch_row($res))
			{
				
				$banderaParam=0;
				$arregloParam="";
				$conParam="SELECT parametro FROM 993_parametrosConsulta WHERE idConsulta=".$fila[1];
				$resPar=$con->obtenerFilas($conParam);
				$nParam=$con->filasAfectadas;
				if($nParam>0)
					$banderaParam=1;
				$arregloParam=$con->obtenerFilasArreglo($consulta);
				
				
				$obj='{"idPerfilVSPuesto":"'.$fila[0].'","idCriterio":"'.$fila[1].'","nombreConsulta":"'.$fila[2].'","tieneParam":"'.$banderaParam.'","arregloParam":"'.$arregloParam.'","valor":"'.$fila[3].'"}';	
				if($arrCriterios=="")
					$arrCriterios=$obj;
				else
					$arrCriterios.=",".$obj;
				
			}
			$obj='{"numReg":"'.$numReg.'","registros":['.$arrCriterios.']}';
			
			echo $obj;		
		}
		
		function guardarCalculoPerfil()
		{
			global $con;
			
			$idPuesto=base64_decode($_POST["idPuesto"]);
			$idCriterio=base64_decode($_POST["idCalculo"]);
			$cadena=$_POST["cadena"];
			$valor=$_POST["valor"];
			
			if($cadena=="")
			{
				$existe="SELECT idPerfilVSPuesto FROM 9312_perfilPuesto WHERE idPuesto=".$idPuesto;
				$id=$con->obtenerValor($existe);
				if($id=="")
				{
					$query="INSERT INTO 9312_perfilPuesto (idPuesto,idCriterio,valor) VALUES(".$idPuesto.",".$idCriterio.",".$valor.")";
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
			else
			{
				$existe="SELECT idPerfilVSPuesto FROM 9312_perfilPuesto WHERE idPuesto=".$idPuesto;
				$id=$con->obtenerValor($existe);
				if($id=="")
				{
					$consulta="begin";
					if($con->ejecutarConsulta($consulta))
					{
						$ct=0;
						$insertar="INSERT INTO 9312_perfilPuesto (idPuesto,idCriterio,valor) VALUES(".$idPuesto.",".$idCriterio.",".$valor.")";
						if($con->ejecutarConsulta($insertar))
						{
							$idTabla=$con->obtenerUltimoID();
							$arreglo=explode(",",$cadena);
							$tamano=sizeof($arreglo);
							
							for($x=0;$x<$tamano;$x++)
							{
								$elemento=explode("_",$arreglo[$x]);
								$parametro=$elemento[0];
								$valor=$elemento[1];
								
								$query[$ct]="INSERT INTO 9313_perfilVSParametros (idPerfilVSPuesto,parametro,valor) VALUES(".$idTabla.",'".$parametro."','".$valor."')";
								$ct++;
							}
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
					echo "1|";
				}
			}
		}
		
		function borrarCalculosPerfil()
		{
			global $con;
			
			$cadena=$_POST["cadena"];
			$arreglo=explode(",",$cadena);
			$tamano=sizeof($arreglo);
			
			$consulta="begin";
			if($con->ejecutarConsulta($consulta))
			{
				$ct=0;
				for($x=0;$x<$tamano;$x++)	
				{
					$query[$ct]="DELETE FROM 9312_perfilPuesto WHERE idPerfilVSPuesto=".$arreglo[$x];
					$ct++;
					$query[$ct]="DELETE FROM 9313_perfilVSParametros WHERE idPerfilVSPuesto=".$arreglo[$x];
					$ct++;
				}
				
			    $query[$ct]="commit";
				if($con->ejecutarBloque($query))
					echo "1|";
				else
					echo "|";
			}
		}
		
		function modificarValoresCalculo()
		{
			global $con;
			
			$cadena=$_POST["cadena"];
			$idTabla=base64_decode($_POST["idTabla"]);
			$arreglo=explode(",",$cadena);
			$tamano=sizeof($arreglo);
			
			$consulta="begin";
			if($con->ejecutarconsulta($consulta))
			{
				$ct=0;
				
				for($x=0;$x<$tamano;$x++)
				{
					$elemento=explode("_",$arreglo[$x]);
					$parametro=$elemento[0];
					$valor=$elemento[1];
					
					$query[$ct]="UPDATE 9313_perfilVSParametros SET valor='".$valor."' WHERE idPerfilVSPuesto=".$idTabla." AND parametro='".$parametro."'";
					$ct++;
				}
			}
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
		
		function modificarPuntos()
		{
			global $con;
			
			$puntos=$_POST["puntos"];
			$idTabla=$_POST["idTabla"];
			
			$query="UPDATE 9312_perfilPuesto SET valor=".$puntos." WHERE idPerfilVSPuesto=".$idTabla;
			if($con->ejecutarConsulta($query))
				echo "1|";
			else
				echo "|";
		}
		
		function obtenerCriteriosPerfilPuesto()
		{
			global $con;
			echo "1|2";
			return;
			$idSolicitud=$_POST["idSolicitud"];
			$idFormulario=$_POST["idFormulario"];
			$consulta="SELECT idUnidadOrgVSPuesto FROM 667_puestosVacantes WHERE idFormularioPerfil=".$idFormulario." AND idRegistroPerfil=".$idSolicitud." AND STATUS=1";
			$idTabla=$con->obtenerValor($consulta);
			if($idTabla=="")
			{
				echo "1|2";
			}
			else
			{
				$consulta="SELECT idPuesto FROM 653_unidadesOrgVSPuestos WHERE idUnidadVSPuesto=".$idTabla;
				$idPuesto=$con->obtenerValor($consulta);
				if($idPuesto=="")
				{
					echo "1|2";
				}
				else
				{
					$conCriterios="SELECT idPerfilVSPuesto,idCriterio,valor FROM 9312_perfilPuesto WHERE idPuesto=".$idPuesto;
					$res=$con->obtenerFilas($conCriterios);
					$nFilas=$con->filasAfectadas;
					if($nFilas>0)
					{
						$objParam="";
						while($fila=mysql_fetch_row($res))
						{
							$conNombreC="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$fila[1];
							$nombreC=$con->obtenerValor($conNombreC);
							
							$cadenaParam="";
							$tieneParametros=0;
							$conParametros="SELECT parametro,valor FROM 9313_perfilVSParametros WHERE idPerfilVSPuesto=".$fila[0];
							$resP=$con->obtenerFilas($conParametros);
							$nParam=$con->filasAfectadas;
							if($nParam>0)
							{
								$tieneParametros=1;
							}
							while($filaP=mysql_fetch_row($resP))
							{
								 $pareja='[\''.$filaP[0].'\','.$fila[1].']';
								 if($cadenaParam=='')
									$cadenaParam=$pareja;
								 else
									$cadenaParam.=','.$pareja;
							
							}
							
							$cadenaParam='['.$cadenaParam.']';
							
							$obj='['.$fila[1].',\''.$nombreC.'\','.$fila[2].','.$tieneParametros.','.$cadenaParam.']';
							
							if($objParam=="")
								$objParam=$obj;
							else
								$objParam.=",".$obj;
						}
						
						echo "1|1|[".$objParam."]";	
					}
					else
					{
						echo "1|2";
					}
				}
			}
		}
		
		function obtenerParametrosCalculo()
		{
			global $con;
			
			$idCalculo=$_POST["idCalculo"];
			$consulta="SELECT parametro FROM 993_parametrosConsulta WHERE idConsulta=".$idCalculo;
			$nParametros=$con->obtenerFilasArreglo($consulta);
			echo "1|".$nParametros;
		}
		
		function obtenerPerfilPuesto()
		{
			global $con;
			
			$condWhere="";
			if(isset($_POST["filter"]))
			{
				$arrFiltro=$_POST["filter"];
				$ct=sizeof($arrFiltro);
				for($x=0;$x<$ct;$x++)
				{
					switch($arrFiltro[$x]["data"]["type"])
					{
						case 'string':
							$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
						break;
					}
				}
			}
			
			$consulta="SELECT p.idPuesto,puesto FROM 9312_perfilPuesto p, 819_puestosOrganigrama pu WHERE p.idPuesto=pu.idPuesto ".$condWhere." ORDER BY puesto";
			$res=$con->obtenerFilas($consulta);
			$nfilas=$con->filasAfectadas;
			
			$arrPerfiles="";
			
			while($fila=mysql_fetch_row($res))
			{
				
				$banderaParam=0;
				$arregloParam="";
				$conParam="SELECT parametro FROM 993_parametrosConsulta WHERE idConsulta=".$fila[0];
				$resPar=$con->obtenerFilas($conParam);
				$nParam=$con->filasAfectadas;
				if($nParam>0)
					$banderaParam=1;
				$arregloParam=$con->obtenerFilasArreglo($consulta);
				
				
				$obj='{"idPuesto":"'.$fila[0].'","puesto":"'.$fila[1].'"}';	
				if($arrPerfiles=="")
					$arrPerfiles=$obj;
				else
					$arrPerfiles.=",".$obj;
				
			}
			$obj='{"numReg":"'.$nfilas.'","registros":['.$arrPerfiles.']}';
			
			echo $obj;		
		}
		
		function borrarPerfilPuesto()
		{
			global $con;
			
			$idPuesto=$_POST["idPuesto"];
			
			$consulta="begin";
			if($con->ejecutarConsulta($consulta))
			{
				$ct=0;
				
				$conDatos="SELECT idPerfilVSPuesto FROM 9312_perfilPuesto WHERE idPuesto=".$idPuesto;
				$idTabla=$con->obtenerValor($conDatos);
				if($idTabla=="")
				{
				    $idTabla="-1";
				}
				
				$query[$ct]="DELETE FROM 9313_perfilVSParametros WHERE idPerfilVSPuesto=".$idTabla;
				$ct++;
				$query[$ct]="DELETE FROM 9312_perfilPuesto WHERE idPuesto=".$idPuesto;
				$ct++;
				$query[$ct]="commit";
				if($con->ejecutarBloque($query))
				   echo "1|";
				else
					echo "1|";
			}
		}
		
		function marcarCandidatos()
		{
			global $con;
			
			$solicitud=$_POST["idSolicitud"];
			$cadena=$_POST["cadena"];
			$idFormulario=$_POST["idFormulario"];
			$arreglo=explode(",",$cadena);
			$tamano=sizeof($arreglo);
			
			$consulta="begin";
			if($con->ejecutarconsulta($consulta))
			{
				$ct=0;
				
				for($x=0;$x<$tamano;$x++)
				{
					$conExiste="SELECT idUsuario FROM 4231_candidatosSolicitud WHERE idSolicitud=".$solicitud." AND idUsuario=".$arreglo[$x]." AND estado=1";
					$existe=$con->obtenerValor($conExiste);
					if($existe=="")
					{
						$query[$ct]="INSERT INTO 4231_candidatosSolicitud (idSolicitud,idUsuario,estado,idFormulario) VALUES(".$solicitud.",".$arreglo[$x].",1,".$idFormulario.")";
						$ct++;
					}
				}
				
				$query[$ct]="commit";
				if($con->ejecutarBloque($query))
					echo "1|";
				else
					echo "|";
			}
		}
		
		function obtenerRolesEnfermeriaPeriodo()
		{
			global $con;
			global $arrMesLetra;
			$ciclo=$_POST["idCiclo"];
			$idServicio=$_POST["idServicio"];
			
			$numFilas=0;
			$mes;
			$arrRolesE="";
			$consulta="SELECT id__865_tablaDinamica,txtCategoria FROM _865_tablaDinamica WHERE id__865_tablaDinamica in (SELECT c.idCategoria FROM _465_tablaDinamica t,_465_gridServicioCategoria c WHERE c.idReferencia=t.id__465_tablaDinamica
						AND t.id__465_tablaDinamica=".$idServicio.") order by txtCategoria";
			
			$arrCategorias=$con->obtenerFilasArregloAsocPHP($consulta);			
			$consulta="SELECT * FROM 9315_periodosRoles ORDER BY noPeriodo";
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$objRaiz='{"idRolE":"'.$fila[3].'","periodo":"'.$fila[1].'"';
				foreach($arrCategorias as $idCategoria=>$categoria)
				{
					$resto=',"idCategoria":"'.$idCategoria.'","categoria":"'.$categoria.'"';
					
					//9315
					$consulta="SELECT idConfiguracion FROM 9315_configuracionRolEnfermeria WHERE ciclo=".$ciclo." AND idServicio=".$idServicio." AND idPeriodo=".$fila[3];
					$filaConf=$con->obtenerPrimeraFila($consulta);
					if($filaConf)
					{
						if($arrRolesE=="")
							$arrRolesE=$objRaiz.$resto."}";
						else
							$arrRolesE.=",".$objRaiz.$resto."}";
						$numFilas++;
					}
					
				}
			}
			$arrRolesE=$arrRolesE;
			$obj='{"numReg":"'.$numFilas.'","registros":['.$arrRolesE.']}';
			echo $obj;	
			
				
		}
		
		function registroRolEnfermeria()
		{
			global $con;
			
			//$tipoA=$_POST["tipoA"];
			//$idRolConf=$_POST["idRolConf"];
			//$fecha=$_POST["fecha"];
			//$noSemana=$_POST["noSemana"];
			
			//if(isset($_POST["tipoRegistro"]))
//				$tipoRegistro=$_POST["tipoRegistro"];
//			else
//				$tipoRegistro=1;
			
			$idUsuario=$_POST["idUsuario"];
			$cadena=$_POST["cadena"];
			$arreglo=explode(",",$cadena);
			$tamano=sizeof($arreglo);
			$fechaIni=$_POST["fechaIni"];
			$fechaFin=$_POST["fechaFin"];
			
			$consulta="begin";
			if($con->ejecutarConsulta($consulta))
			{
				$borrar="DELETE FROM 9315_registroRolEnfermeria WHERE idUsuario=".$idUsuario." AND fecha>='".$fechaIni."' AND fecha<='".$fechaFin."'";
				if($con->ejecutarconsulta($borrar))
				{
					$ct=0;
					for($x=0;$x<$tamano;$x++)
					{
						$elemneto=explode("_",$arreglo[$x]);
						$query[$ct]="INSERT INTO 9315_registroRolEnfermeria (idUsuario,idRolVSConfigSemana,fecha,noSemana) VALUES(".$idUsuario.",".$elemneto[0].",'".$elemneto[1]."',".$elemneto[2].")";
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
		
		function obtenerDatosEmpleado()
		{
			global $con;
			
			$idUsuario=$_POST["idUsuario"];
			$consulta="SELECT numDia,horaInicio,horaFin,horasLaborales,minutosLaborales FROM 979_horariosLaborUsuario WHERE idUsuario=".$idUsuario." ortder by dia";
			$res=$con->obtenerFilas($consulta);
			$filas=$con->filaAfectadas;
			
			$cabecera="<table>";
			$titulos="";
			$cuerpo="";
			$pie="</table>";
			if($filas>0)
			{
				
                $titulos="<tr>
                	<td>Dia</td>
                    <td>Hora de Inicio</td>
                    <td>Hora de Fin </td>
                    <td>Horas Diarias</td>
				</tr>";
            }
			
			while($fila=mysql_fetch_row($res))
			{
				$obj=
				$cuerpo.="<tr>
							<td>".$obtenerNombreDia($fila[0])."</td>
							<td>".date('H:i',$fila[1])."</td>
							<td>".date('H:i',$fila[2])."</td>
							<td>".date('H:i',$fila[3])."</td>
						</tr>";
						
			}
			
			$final=$cabecera.$titulos.$cuerpo.$pie;
			echo "1|".$final;
		}
		
		function obtenerNombreDia($num)
		{
			switch($num)
				{
					case 1:
						$letra="Lunes";
					break;
					case 2:
						$letra="Martes";
					break;
					case 3:
						$letra="Miercoles";
					break;
					case 4:
						$letra="Jueves";
					break;
					case 5:
						$letra="Viernes";
					break;
					case 6:
						$letra="Sabado";
					break;
					case 7:
						$letra="Domingo";
					break;
				}
				return $letra;
		}

		function obtenerResultadosEvaluaciones()
		{
			global $con;
			
			$consulta="SELECT idNombreAspirante,idCalPsicometrico,idExamenconoc,idComentario FROM _692_GrdResultadoexamen";
			$res=$con->obtenerFilas($consulta);
			$nreg=$con->filasAfectadas;
		
			$arrResultados="";
			while($fila=mysql_fetch_row($res))
			{
				$nombre=obtenerNombreUsuario($fila[0]);
				
				$obj='{"idUsuario":"'.$fila[0].'","nombre":"'.$nombre.'","resPsicometrico":"'.$fila[1].'","resConocimientos":"'.$fila[2].'","comentarios":"'.$fila[3].'"}';	
				if($arrResultados=="")
					$arrResultados=$obj;
				else
					$arrResultados.=",".$obj;
			}
			$obj='{"numReg":"'.$nreg.'","registros":['.$arrResultados.']}';
			echo $obj;
			
		}
		
		function crearRolEnfermeria()
		{
			global $con;
			$cadObj=$_POST["obj"];
			$obj=json_decode($cadObj);
			$consulta="INSERT INTO 9314_instanciasRolEnfermeria(ciclo,fechaInicio,fechaFin,idServicio,cvePuesto,idTurno)
					VALUES(".$obj->ciclo.",'".$obj->fechaInicio."','".$obj->fechaFin."',".$obj->idServicio.",'".$obj->cvePuesto."',".$obj->idTurno.")";
					
			if($con->ejecutarConsulta($consulta))
			{
				$idRol=$con->obtenerUltimoID();
				echo "1|".$idRol;
			}
		}
		
		function agregarEmpleadoRol()
		{
			global $con;
			$cadObj=$_POST["obj"];
			$obj=json_decode($cadObj);	
			$x=0;
			$consulta[$x]="begin";
			$x++;
			$arrEmpleados=explode(",",$obj->listaUsr);
			foreach($arrEmpleados as $empleado)
			{
				$consulta[$x]="INSERT INTO 9315_registroRolEnfermeria(idUsuario,idRol,fechaInicio,fechaFin,idTurno,idServicio)
							 VALUES(".$empleado.",".$obj->idRol.",'".$obj->fechaInicio."','".$obj->fechaFin."',".$obj->idTurno.",".$obj->idServicio.")";
				$x++;
			}
			
			$consulta[$x]="commit";
			$x++;
			eB($consulta);
		}
		
		function removerEmpleadoRol()
		{
			global $con;
			$idEmpleado=$_POST["idEmpleado"];
			$consulta="delete from 9315_registroRolEnfermeria where idUsuarioVSRolE=".$idEmpleado;
			eC($consulta);
		}
		
		function registrarPerfilMateria()
		{
			global $con;
			$iS=$_POST["iS"];
			$consulta="select * from 4233_solicitudConvMateria WHERE idSolicitudConvMat=".$iS;

			$fila=$con->obtenerPrimeraFila($consulta);	
			$consulta="select idPrograma from 4013_materia where idMateria=".$fila[1];
			$idPrograma=$con->obtenerValor($consulta);
			$consulta="INSERT INTO _290_tablaDinamica (fechaCreacion,responsable,idEstado,codigoUnidad,codigoInstitucion,cmbCiclo,cmbMateria,cmbPrograma,cmbGrupo)
					VALUES('".date('Y-m-d')."',".$_SESSION["idUsr"].",2,'".$fila[2]."','".$fila[2]."',".$fila[5].",".$fila[1].",".$idPrograma.",".$fila[3].")";

			if($con->ejecutarConsulta($consulta))
			{
				$idReferencia=$con->obtenerUltimoID();
				$consulta="update 4233_solicitudConvMateria set idFormulario=290 , idRegistro=".$idReferencia." WHERE idSolicitudConvMat=".$iS;	
				if($con->ejecutarConsulta($consulta))
				{
					echo "1|".$idReferencia;
				}
				else
					echo "|";
			}
			else
				echo "|";
		}
		
		function obtenerDocentesEsperaContrato()
		{
			global $con;
			$idCiclo=$_POST["idCiclo"];
			$idPeriodo=$_POST["idPeriodo"];
			$arrFiltro=array();
			if(isset($_POST["filter"]))
			{
				$arrFiltro=$_POST["filter"];
			}
			$condicionWhere=" 1=1 ";
			if(sizeof($arrFiltro)>0)
				$condicionWhere=generarCadenaConsultasFiltro($arrFiltro);
			$consulta="SELECT idInstanciaPlanEstudio FROM 4513_instanciaPlanEstudio WHERE sede='".$_SESSION["codigoInstitucion"]."' 
						AND idModalidad IN (4,7)";
			$listPlanesAbiertos=$con->obtenerListaValores($consulta);
			if($listPlanesAbiertos=="")
				$listPlanesAbiertos=-1;
				
				
			/*$listaInstanciasAutorizadas=-1;	
			
			
			$consulta="SELECT situacion FROM 4547_situacionInstanciaPlan WHERE plantel='".$_SESSION["codigoInstitucion"]."' 
						AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." ORDER BY idSituacionPlanEstudio DESC";
			$situacionPlantel=$con->obtenerValor($consulta);			
			if($situacionPlantel==3)
			{
				$consulta="SELECT idInstanciaPlanEstudio FROM 4513_instanciaPlanEstudio WHERE sede='".$_SESSION["codigoInstitucion"]."'";
				$listaInstanciasAutorizadas=$con->obtenerListaValores($consulta);			
				if($listaInstanciasAutorizadas=="")
					$listaInstanciasAutorizadas=-1;
			}*/
			
			
				
			$nreg=0;
			$consulta="SELECT * FROM (SELECT DISTINCT u.idUsuario,concat(u.Paterno,' ',u.Materno,' ',u.Nom) as Nombre 
					FROM 4519_asignacionProfesorGrupo m,802_identifica u,4520_grupos g WHERE g.idGrupos=m.idGrupo 
					AND g.Plantel='".$_SESSION["codigoInstitucion"]."' AND u.idUsuario=m.idUsuario AND m.esperaContrato=1 
					AND g.idCiclo=".$idCiclo." AND g.idPeriodo=".$idPeriodo." AND m.fechaAsignacion<=m.fechaBaja) AS tmp 
					WHERE  1=1 and ".$condicionWhere." ORDER BY Nombre";
			$res=$con->obtenerFilas($consulta);
			$arrDocentes="";
			while($filaMat=mysql_fetch_row($res))
			{	
				$consulta="SELECT g.idGrupos,g.idMateria,g.nombreGrupo,g.idInstanciaPlanEstudio,g.idGradoCiclo FROM 4519_asignacionProfesorGrupo m,
							4520_grupos g WHERE  g.idGrupos=m.idGrupo AND g.Plantel='".$_SESSION["codigoInstitucion"]."' AND  m.fechaAsignacion<=m.fechaBaja
							and  m.esperaContrato=1 AND m.idUsuario=".$filaMat[0]." and g.idInstanciaPlanEstudio in (".$listPlanesAbiertos.") 
							AND g.idCiclo='".$idCiclo."' AND g.idPeriodo='".$idPeriodo."'";
				
				$resMaterias=$con->obtenerFilas($consulta);
				$nMateriasAbiertas=0;
				
				$datos="<table><tr height='21'><td align='center' width='400'><span class='corpo8_bold'>Materia</span></td><td align='center' width='150'><span class='corpo8_bold'>Grupo</span></td></tr><tr height='1'><td style='background-color:#900' colspan='2'></td></tr>";
				while($filaGpo=mysql_fetch_row($resMaterias))
				{
					$situacion=obtenerSituacionPlanPeriodo($filaGpo[3],$idCiclo,$idPeriodo,$filaGpo[4]);
					if(($situacion==3)||($situacion==1))
					{
						$nMateriasAbiertas++;
						$nombrePlanEstudio=obtenerNombreInstanciaPlan($filaGpo[3]);
						$consulta="SELECT CONCAT('[',ma.cveMateria,']',ma.nombreMateria) AS mat from 4502_Materias ma WHERE ma.idMateria=".$filaGpo[1];
						$fila=$con->obtenerPrimeraFila($consulta);	
						$datos.="<tr height='21'><td align='left'><span class='letraAzulSubrayada7' >".$fila[0]."</span><br><span class='copyrigthSinPadding'>(".$nombrePlanEstudio.")</span><td align='left'><span class='letraAzulSubrayada7'>".$filaGpo[2]."</span></td></tr>";
					}
				}
				
				$consulta="SELECT g.idGrupos,g.idMateria,g.nombreGrupo,g.idInstanciaPlanEstudio,g.idGradoCiclo FROM 4519_asignacionProfesorGrupo m,4520_grupos g
                    		WHERE g.idGrupos=m.idGrupo AND g.Plantel='".$_SESSION["codigoInstitucion"]."' AND  m.fechaAsignacion<=m.fechaBaja and  
							m.esperaContrato=1 AND m.idUsuario=".$filaMat[0]." and g.idInstanciaPlanEstudio not in (".$listPlanesAbiertos.") AND 
							g.idCiclo='".$idCiclo."' AND g.idPeriodo='".$idPeriodo."'";
				$resMaterias=$con->obtenerFilas($consulta);
				$nMateriasCerradas=0;
				while($filaGpo=mysql_fetch_row($resMaterias))
				{
					$situacion=obtenerSituacionPlanPeriodo($filaGpo[3],$idCiclo,$idPeriodo,$filaGpo[4]);
					if(($situacion==3)||($situacion==1))
					{
						$nMateriasCerradas++;
						$nombrePlanEstudio=obtenerNombreInstanciaPlan($filaGpo[3]);
						$consulta="SELECT CONCAT('[',ma.cveMateria,']',ma.nombreMateria) AS mat from 4502_Materias ma WHERE ma.idMateria=".$filaGpo[1];
						$fila=$con->obtenerPrimeraFila($consulta);	
						$datos.="<tr height='21'><td align='left'><span class='letraAzulSubrayada7' >".$fila[0]."</span><br><span class='copyrigthSinPadding'>(".$nombrePlanEstudio.")</span></td><td align='left'><span class='letraAzulSubrayada7'>".$filaGpo[2]."</span></td></tr>";
					}
				}
				$datos.="</table>";
				
				
				if(($nMateriasAbiertas==0)&&($nMateriasCerradas==0))
					continue;
				$obj='{"idUsuario":"'.$filaMat[0].'","Nombre":"'.$filaMat[1].'","noMateriasEscolarizado":"'.$nMateriasCerradas.'","noMateriasAbierto":"'.$nMateriasAbiertas.'","datosMateria":"'.$datos.'"}';
				if($arrDocentes=="")
					$arrDocentes=$obj;
				else
					$arrDocentes.=",".$obj;
				$nreg++;
			}
			$obj='{"numReg":"'.$nreg.'","registros":['.$arrDocentes.']}';
			echo $obj;	
		}
		
		function crearContratoDocente()
		{
			global $con;
			$listado=$_POST["listado"];	
			$arrListado=explode(",",$listado);
			$consulta="SELECT idCiclo FROM 4526_ciclosEscolares WHERE situacion=1";
			$cicloActivo=$con->obtenerValor($consulta);
			$consulta="select id__269_tablaDinamica from _269_tablaDinamica where cmbCicloEscolar=".$cicloActivo;
			$idReferencia=$con->obtenerValor($consulta);
			$listContratos="";
			$listaActualiza="";
			$consulta="begin";
			if($con->ejecutarConsulta($consulta))
			{
					
				foreach($arrListado as $idUsuario)
				{
					
					$consulta="SELECT g.idGrupos,ma.idMateria,ma.horaMateriaTotal,m.idAsignacionProfesorGrupo FROM 4519_asignacionProfesorGrupo m,800_usuarios w ,4520_grupos g,4502_Materias ma
							WHERE ma.idMateria=g.idMateria AND g.idGrupos=m.idGrupo AND g.Plantel='".$_SESSION["codigoInstitucion"]."' AND w.idUsuario=m.idUsuario AND m.esperaContrato=1 AND w.idUsuario=".$idUsuario;
					$res=$con->obtenerFilas($consulta);
					$x=0;
					
				
					$fechaMin="NULL";
					$fechaMax="NUlL";
					$consulta="INSERT INTO _273_tablaDinamica(fechaCreacion,responsable,idEstado,codigoUnidad,codigoInstitucion,txtContrato,cmbCatedratico,txtContratoDel,txtContratoAl)
								VALUES('".date('Y-m-d')."',".$_SESSION["idUsr"].",2,'".$_SESSION["codigoUnidad"]."','".$_SESSION["codigoInstitucion"]."','',".$idUsuario.",".$fechaMin.",".$fechaMax.")";
					
					if($con->ejecutarConsulta($consulta))
					{
						$idRegistro=$con->obtenerUltimoID();
						if($listContratos=="")
							$listContratos=$idRegistro;
						else
							$listContratos.=",".$idRegistro;
						while($fila=mysql_fetch_row($res))
						{
							if($listaActualiza=="")
								$listaActualiza=$fila[3];
							else
								$listaActualiza.=",".$fila[3];
							$consulta="SELECT fechaInicio,fechaFin FROM 4520_grupos WHERE idGrupos=".$fila[0];
							$filaFechas=$con->obtenerPrimeraFila($consulta);
							if($filaFechas[0]!="")
							{
								if($fechaMin=="NULL")
									$fechaMin=$filaFechas[0];	
								else
								{
									if(strtotime($fechaMin)>strtotime($filaFechas[0]))	
										$fechaMin=$filaFechas[0];
								}
							}
							
							if($filaFechas[1]!="")
							{
								if($fechaMax=="NULL")
									$fechaMax=$filaFechas[1];
								else
								{
									if(strtotime($fechaMax)<strtotime($filaFechas[1]))	
										$fechaMax=$filaFechas[1];
								}
							}
							$costoHora=0;
							$consulta="SELECT cmbNivelEstudio,txtnivel,nE.intPrioridad FROM _262_tablaDinamica t,_246_tablaDinamica nE
										WHERE t.responsable=".$idUsuario." AND nE.id__246_tablaDinamica=t.cmbNivelEstudio 
										ORDER BY nE.intPrioridad DESC";
							$fNivel=$con->obtenerPrimeraFila($consulta);
							if($fNivel)
							{
								$nivelCurso=$fNivel[1];
								$consulta="SELECT idHrCatedra FROM _269_Tabuladorsueldos WHERE idNivelAcademico=".$fNivel[0]." AND idReferencia=".$idReferencia;
								$costoHora=$con->obtenerValor($consulta);
								if($costoHora=="")
									$costoHora=0;
							}
							else
							{
								$costoHora=0;
							}
							$costo=$fila[2]*$costoHora;
							
							
							
							$query[$x]="INSERT INTO _274_gridAsignaturas(idReferencia,asignatura,noHoras,costoCurso)
										VALUES(".$idRegistro.",'".$fila[1]."_".$fila[0]."',".$fila[2].",".$costo.")";
							$x++;
						}
						$query[$x]="update _273_tablaDinamica set codigo=id__273_tablaDinamica,txtContrato=lpad(id__273_tablaDinamica,6,'0'),txtContratoDel=".$fechaMin.",txtContratoAl=".$fechaMax." where id__273_tablaDinamica=".$idRegistro;

						$x++;
						
						
					}
					else
					{
						echo "|";
						return;
					}
				
				}
				if($listaActualiza=="")
					$listaActualiza="-1";
						
				$query[$x]="update 4519_asignacionProfesorGrupo set esperaContrato=0 where idAsignacionProfesorGrupo in(".$listaActualiza.")";
				$x++;
				$query[$x]="commit";
				$x++;
				if($con->ejecutarBloque($query))
				{
					echo "1|".$listContratos;
				}
				
			}
			else
				echo "|";
			
		}
		
		function guardarPerfilNomina()
		{
			global $con;	
			$cadObj=$_POST["obj"];
			$obj=json_decode($cadObj);
			if($obj->idEtapa==-1)
				$consulta="insert into 662_etapasNomina(nombreEtapa,noEtapa,idPerfil) values ('".$obj->tituloEtapa."',".$obj->noEtapa.",".$obj->idPerfil.")";
			else
				$consulta="update 662_etapasNomina set nombreEtapa='".$obj->tituloEtapa."',noEtapa=".$obj->noEtapa.",idPerfil=".$obj->idPerfil." where idEtapa=".$obj->idEtapa;
			eC($consulta);
		}
		
		function guardarAsignacionRol()
		{
			global $con;
			$cadObj=$_POST["obj"];
			$obj=json_decode($cadObj);
			$x=0;
			$consulta[$x]="begin";
			$x++;
			
			if(sizeof($obj->arrObj)>0)
			{
				foreach($obj->arrObj as $objUsr)
				{
					if($objUsr->accion==1)
					{
						$query="select idUsuario from 9315_asignacionesFechas where idRol=".$obj->idRol." and idTurno=".$objUsr->idTurno." and idServicio=".$obj->idServicio." and fechaAsignacion='".$objUsr->fecha."' and idUsuario=".$objUsr->idUsuario;
						$fila=$con->ObtenerPrimeraFila($query);
						if(!$fila)
						{
							$consulta[$x]="insert into 9315_asignacionesFechas(idUsuario,idRol,fechaAsignacion,idTurno,idServicio) values(".$objUsr->idUsuario.",".$obj->idRol.",'".$objUsr->fecha."',".$objUsr->idTurno.",".$obj->idServicio.")" ;
//							echo $consulta[$x]."<br>";
							$x++;
						}
					}
					else
					{
						$consulta[$x]="delete from 9315_asignacionesFechas where idRol=".$obj->idRol." and idTurno=".$objUsr->idTurno." and idServicio=".$obj->idServicio." and fechaAsignacion='".$objUsr->fecha."' and idUsuario=".$objUsr->idUsuario;
						//echo $consulta[$x]."<br>";
						$x++;
					}
				}
			}
			$consulta[$x]="commit";
			$x++;
			eB($consulta);
			
		}
		
		function obtenerContratos()
		{
			global $con;
			$cadena="";
			$idCiclo=$_POST["idCiclo"];
			$idPeriodo=$_POST["idPeriodo"];
			$plantel=$_POST["plantel"];
			$idUsuario=$_POST["idUsuario"];
			
			$consulta="SELECT idContratoProfesor,folioContrato,fechaInicioContrato,fechaFinContrato,datosContrato FROM 4553_contratosProfesores 
						WHERE idProfesor=".$idUsuario." AND plantel='".$plantel."' AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;
			

			$res=$con->obtenerFilas($consulta);	
			$arrObj="";
			$nReg=0;
			$fechaActual=strtotime(date("Y-m-d"));
			while($fila=mysql_fetch_row($res))
			{
				$objContrato=$fila[4];
				$obj=unserialize($objContrato);
				
				$objNuevo=reconstruirContrato($fila[0]);
				
				$objNuevo=normalizarDiferenciaContratos($obj,$objNuevo);
				$cambiaContrato=0;
				$tblDatosComp="";
				$cambiosDetectados="";
				$numMateriasDiferente=false;
				if(sizeof($objNuevo->arrMaterias)!=sizeof($obj->arrMaterias))
					$numMateriasDiferente=true;
				if(($obj->costoHora!=$objNuevo->costoHora)||($obj->fInicioC!=$objNuevo->fInicioC)||($obj->fFinC!=$objNuevo->fFinC)||$numMateriasDiferente)
				{
					$cambiaContrato=1;
					$tblDatosComp="<br><br><b>Se han detectado los siguientes cambios en el contrato actual:</b><br><br>";
					if($objNuevo->costoHora=="")
						$objNuevo->costoHora=0;
					if($obj->costoHora!=$objNuevo->costoHora)
					{
						
						$tblDatosComp.="<table><tr><td><img src='../images/bullet_green.png'></td><td> El costo por hora es diferente: <b>Costo original:</b> $ ".number_format($obj->costoHora,2).", <b>Costo actual:</b> $ ".number_format($objNuevo->costoHora,2)."</td></tr></table><br>";
						$cambiosDetectados.="El costo por hora es diferente: Costo original: $ ".number_format($obj->costoHora,2).", Costo actual: $ ".number_format($objNuevo->costoHora,2)."<br>";
						
					}

					if($obj->fInicioC!=$objNuevo->fInicioC)
					{
						$tblDatosComp.="<table><tr><td><img src='../images/bullet_green.png'></td><td> La fecha de inicio del contrato es diferente: <b>Fecha original:</b> ".date("d/m/Y",strtotime($obj->fInicioC)).", <b>Fecha actual:</b> ".date("d/m/Y",strtotime($objNuevo->fInicioC))."</td></tr></table><br>";
						$cambiosDetectados.="La fecha de inicio del contrato es diferente: Fecha original: ".date("d/m/Y",strtotime($obj->fInicioC)).", Fecha actual: ".date("d/m/Y",strtotime($objNuevo->fInicioC))."<br>";
					}
					
					if($obj->fFinC!=$objNuevo->fFinC)
					{
						$tblDatosComp.="<table><tr><td><img src='../images/bullet_green.png'></td><td> La fecha de t&eacute;rmino del contrato es  diferente: <b>Fecha original:</b> ".date("d/m/Y",strtotime($obj->fFinC)).", <b>Fecha actual:</b> ".date("d/m/Y",strtotime($objNuevo->fFinC))."</td></tr></table><br>";
						$cambiosDetectados.="La fecha de término del contrato es  diferente: Fecha original: ".date("d/m/Y",strtotime($obj->fFinC)).", Fecha actual: ".date("d/m/Y",strtotime($objNuevo->fFinC))."<br>";
					}
					if($numMateriasDiferente)
					{
						$tblDatosComp.="";
						$cambiosDetectados.="El número de materias involucradas en el contrato ha cambiado (Total materias original: ".sizeof($obj->arrMaterias).
								", Total materias actual: ".sizeof($objNuevo->arrMaterias).")<br>";
						$tblDatosComp.=$cambiosDetectados;
					}
					
				}

				$dMateria="<br><table><tr><td width='400' align='center'><span class='corpo8_bold'>Materia / asignatura</span></td><td width='120' align='center'><span class='corpo8_bold'>Grupo</span></td>".
							"<td width='70' align='center'><span class='corpo8_bold'>Horas</span></td><td width='120' align='center'><span class='corpo8_bold'>Costo por hora</span></td><td width='120' align='center'><span class='corpo8_bold'>Fecha de inicio</span></td>".
							"<td width='120' align='center'><span class='corpo8_bold'>Fecha de t&eacute;rmino</span></td></tr>".
							"<tr height='1'><td style='background-color:#900' colspan='6'></td></tr>";
				$noMaterias=0;

				foreach($objNuevo->arrMaterias as $objMat)
				{
					$materia=$objMat->nombreMateria;
					$consulta="select nombreGrupo,idInstanciaPlanEstudio from 4520_grupos where idGrupos=".$objMat->idGrupo;
					$fGrupos=$con->obtenerPrimeraFila($consulta);
					$grupo=$fGrupos[0];

					$nombrePlanEstudio=obtenerNombreInstanciaPlan($fGrupos[1]);
					$dMateria.="<tr height='21'><td align='left'><span class='letraExt'  style='font-size: 11px !important'><b>".$materia."</b></span><br><span class='copyrigthSinPadding'>(".$nombrePlanEstudio.
							")</span><td align='center'><span class='letraExt' style='font-size: 11px !important'>".$grupo."</span></td><td align='center'><span class='letraExt' style='font-size: 11px !important'>".
							number_format($objMat->horasMateria)."</span></td><td align='right'><span class='letraExt' style='font-size: 11px !important'>$ ".number_format($objMat->costoHora,2).
							"</span></td><td align='right'><span class='letraExt' style='font-size: 11px !important'>".date("d/m/Y",strtotime($objMat->fechaInicio))."</span></td>".
							"<td align='right'><span class='letraExt' style='font-size: 11px !important'>".date("d/m/Y",strtotime($objMat->fechaFin))."</span></td></tr>";
					$noMaterias++;
				}
				
				$dMateria.="</table>".$tblDatosComp;
				$consulta="SELECT COUNT(*) FROM 4553_versionesContrato WHERE idContrato=".$fila[0];
				
				$nVersiones=$con->obtenerValor($consulta);
				$nVersiones++;
				$obj='{"cambiosDetectados":"'.$cambiosDetectados.'","cambiaContrato":"'.$cambiaContrato.'","idContratoProfesor":"'.$fila[0].'","folio":"'.$fila[1].'","fInicio":"'.$fila[2].'","fTermino":"'.$fila[3].'","versiones":"'.$nVersiones.'","documento":"'.$obj->nombreArchivo.'","datosMateria":"'.$dMateria.'"}';
				if($arrObj=="")
					$arrObj=$obj;
				else
					$arrObj.=",".$obj;
				$nReg++;
				
			}
			echo '{"registros":['.$arrObj.'],"numReg":"'.$nReg.'"}';
			
		}
		
		function removerIncidencia()
		{
			global $con;
			$id=bD($_POST["id"]);
			$arrID=explode("_",$id);
			$consulta="DELETE FROM 9106_Justificaciones where idUsuario=".$arrID[0]." and fecha_Inicial='".$arrID[1]."' and fecha_Final='".$arrID[1]."'";
			eC($consulta);
			
		}
		
		function validarAsistenciaProfesor()
		{
			global $con;
			$hora=$_POST["hora"];
			$codigo=$_POST["codigo"];
			$consulta="SELECT idUsuario FROM 801_adscripcion WHERE codigoRegAsistencia='".$codigo."'";
			$idUsuario=$con->obtenerValor($consulta);
			echo validarHorarioAsistenciaProfesor($hora,$idUsuario,date("Y-m-d"),$_SESSION["codigoInstitucion"]);
			
		}
		
		function obtenerDatosEmpleadoSDI()
		{
			global $con;
			$cadObj=$_POST["cadObj"];
			$obj=json_decode($cadObj);
			$consulta="SELECT cuenta FROM 823_cuentasUsuario WHERE idUsuario=".$obj->idUsuario;
			$nCuenta=$con->obtenerValor($consulta);
			$anio=2012;
			//$sdi=calcularSDIBimestre($obj->idUsuario,$obj->plantel);
			$consulDatos="SELECT txtSDI FROM _497_tablaDinamica WHERE cmbDocente='".$obj->idUsuario."' AND cmbTipohonorario='1' AND cmbCiclo='".$anio."' 
							AND cmbBimestre2='3' AND codigoInstitucion='".$obj->plantel."'";
			$sdi=$con->obtenerValor($consulDatos);
			if($sdi=="")
				$sdi=0;
			echo "1|".$sdi."|".$nCuenta;
		}
		
		function reconstruirNuevaVersionContrato()
		{
			global $con;
			$datosContratoAnt="";
			$idContrato=$_POST["idContrato"];
			$cadObj=$_POST["cadObj"];
			$obj=json_decode($cadObj);
			
			$motivo="Cambios detectados: ".str_replace("#R<br />","<br>",$obj->cambiosDetectados);
			$motivo.="<br>Comentario adicionales:".str_replace("#R<br />","<br>",$obj->txtComentarios);
			$nuevoContrato=reconstruirContrato($idContrato);
			
			$consulta="SELECT datosContrato FROM 4553_contratosProfesores WHERE idContratoProfesor=".$idContrato;
			$fOriginal=$con->obtenerPrimeraFila($consulta);
			$objContratoOriginal=$fOriginal[0];
			$objOriginal=unserialize($objContratoOriginal);

			$nuevoContrato=normalizarDiferenciaContratos($objOriginal,$nuevoContrato);
			
			$txtContrato=crearContrato($nuevoContrato,false);
			
			$consulta="SELECT COUNT(*) FROM 4553_versionesContrato WHERE idContrato=".$idContrato;
			$nVersion=$con->obtenerValor($consulta);
			$nVersion+=2;
			$consulta="SELECT  datosContrato,version FROM 4553_contratosProfesores WHERE idContratoProfesor=".$idContrato;
			$fContrato=$con->obtenerPrimeraFila($consulta);
			$datosContratoAnt=$fContrato[0];
			$versionActual=$fContrato[1];
			if($versionActual=="")
				$versionActual=1;
			$x=0;
			$query[$x]="begin";
			$x++;
			$query[$x]="INSERT INTO 4553_versionesContrato(noVersion,fechaCreacion,motivoReemplazo,datosContrato,idContrato,responsableReemplazo) 
						VALUES(".$versionActual.",'".date("Y-m-d H:i:s")."','".cv($motivo)."','".cv($datosContratoAnt)."',".$idContrato.",".$_SESSION["idUsr"].")";
			$x++;
			$query[$x]="UPDATE 4553_contratosProfesores SET VERSION=".$nVersion.",datosContrato='".serialize($nuevoContrato)."' WHERE idContratoProfesor=".$idContrato;
			$x++;
			$query[$x]="commit";
			$x++;
			if($con->ejecutarBloque($query))
			{
				$nombreArchivo=$nuevoContrato->numeroContrato."_V".$nVersion.".doc";
				$f=fopen("../modulosEspeciales_UGM/respaldoContratos/".$nombreArchivo,"w");
				fwrite($f,$txtContrato);
				fclose($f);
				echo "1|".$nVersion;
			}
		}
		
		function obtenerVersionesContrato()
		{
			global $con;
			$idContrato=$_POST["idContrato"];
			$consulta="SELECT idVersionContrato AS idRegistro,noVersion,fechaCreacion AS fechaReemplazo,motivoReemplazo AS motivo,u.Nombre AS  responsable
						FROM 4553_versionesContrato v,800_usuarios u WHERE idContrato=".$idContrato." AND  u.idUsuario=v.responsableReemplazo ORDER BY noVersion desc";
			$arrReg=$con->obtenerFilasJSON($consulta);
			echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
						
		}
		
		function obtenerPuestosDepartamentosEmpresa()
		{
			global $con;
			$idEmpresa=$_POST["idEmpresa"];
			$consulta="SELECT idDepartamento,CONCAT('[',cveDepartamento,'] ',nombreDepartamento) FROM 691_departamentosNominaV2 WHERE idEmpresa=".$idEmpresa." ORDER BY nombreDepartamento";
			$arrDeptos=$con->obtenerFilasArreglo($consulta);
			$consulta="SELECT idPuesto,CONCAT('[',cvePuesto,'] ',puesto) FROM 692_puestosNominaV2 WHERE idEmpresa=".$idEmpresa." ORDER BY puesto";
			$arrPuestos=$con->obtenerFilasArreglo($consulta);
			$consulta="SELECT idRegistro,registroPatronal FROM 6927_empresaRegistroPatronal WHERE idEmpresa=".$idEmpresa." ORDER BY registroPatronal";
			$arrRegPatronal=$con->obtenerFilasArreglo($consulta);
			$consulta="SELECT idCentroCosto,centroCosto FROM 722_centrosCostos WHERE idEmpresa=".$idEmpresa." ORDER BY centroCosto";
			$arrCentroCosto=$con->obtenerFilasArreglo($consulta);
			echo "1|".$arrPuestos."|".$arrDeptos."|".$arrRegPatronal."|".$arrCentroCosto;
			
		}
		
		function generarNominaEmpresaV2()
		{
			global $con;
			$cadObj=$_POST["cadObj"];
			$obj=json_decode($cadObj);
			
			$x=0;
			$consulta[$x]="begin";
			$x++;
			
			$generarXMLNOmina=false;
			
			if(!isset($obj->idNomina))
			{
				$consulta[$x]="	INSERT INTO 698_nominasV2(fechaInicio,fechaFin,fechaPago,numDiasPagados,idEmpresa,idResponsable,fechaCreacion,situacion,descripcionNomina,idCertificado,idSerie)
								VALUES('".$obj->fechaInicio."','".$obj->fechaFin."','".$obj->fechaPago."','".$obj->diasPagados."','".$obj->idEmpresa."','".$_SESSION["idUsr"]."','".date("Y-m-d H:i:s")."',1,'".cv($obj->descripcion)."',".$obj->idCertificado.",".$obj->idSerie.")";
				$x++;
				$consulta[$x]="set @idNomina:=(select last_insert_id())";
				$x++;
				
				$query="SELECT idEmpleado,sdi FROM 693_empleadosNominaV2 WHERE idEmpresa=".$obj->idEmpresa." and situacion=1";
				$res=$con->obtenerFilas($query);
				while($fila=mysql_fetch_row($res))
				{
					$sdi=0;
					if($fila[1]!=0)
						$sdi=$fila[1];
					$consulta[$x]="INSERT INTO 699_empleadosEjecucionNominaV2(idNomina,idEmpleado,situacion,montoIncapacidad,montoHorasExtra,sdi) VALUES(@idNomina,".$fila[0].",1,0,0,".$sdi.")";
					$x++;
					$consulta[$x]="set @idEmpleadoNomina:=(select last_insert_id())";
					$x++;
					$consulta[$x]="INSERT INTO 700_percepcionesDeduccionesV2(idEmpleadoNomina,tipoConcepto,categoriaConcepto,clave,descripcion,importeGravado,importeExento)
									SELECT @idEmpleadoNomina AS idEmpleadoNomina,'2' AS idEmpleado,tipoPercepcion,clave,descripcion,importeGravado,importeExento FROM 696_percepcionesEmpleadoV2 WHERE idEmpleado=".$fila[0];
					$x++;
					$consulta[$x]="INSERT INTO 700_percepcionesDeduccionesV2(idEmpleadoNomina,tipoConcepto,categoriaConcepto,clave,descripcion,importeGravado,importeExento)
									SELECT @idEmpleadoNomina AS idEmpleadoNomina,'1' AS idEmpleado,tipoDeduccion,clave,descripcion,importeGravado,importeExento FROM 697_deduccionesEmpleadoV2 WHERE idEmpleado=".$fila[0];
					$x++;
					
					
					$consulta[$x]="update 699_empleadosEjecucionNominaV2 set totalPercepciones=(select sum(importeGravado+importeExento) from 700_percepcionesDeduccionesV2 where idEmpleadoNomina=@idEmpleadoNomina and tipoConcepto=2),
								totalDeducciones=(select sum(importeGravado+importeExento) from 700_percepcionesDeduccionesV2 where idEmpleadoNomina=@idEmpleadoNomina and tipoConcepto=1) where idEmpleadoNomina=@idEmpleadoNomina";
					$x++;
					$consulta[$x]="update 699_empleadosEjecucionNominaV2 set sueldoNeto=totalPercepciones-totalDeducciones where idEmpleadoNomina=@idEmpleadoNomina";
					$x++;
				}
				
				$generarXMLNomina=true;
			}
			else
			{
				$consulta[$x]="UPDATE 698_nominasV2 SET idCertificado=".$obj->idCertificado.",idSerie=".$obj->idSerie.",fechaInicio='".$obj->fechaInicio."',fechaFin='".$obj->fechaFin."',fechaPago='".$obj->fechaPago."',numDiasPagados='".$obj->diasPagados."',descripcionNomina='".cv($obj->descripcion)."' WHERE idNomina=".$obj->idNomina;
				$x++;	
			}
			$consulta[$x]="commit";
			$x++;
			
			if($con->ejecutarBloque($consulta))
			{
				$query="select @idNomina";
				$idNomina=$con->obtenerValor($query);	
				
				if($generarXMLNomina)
				{
					generarListadoXMLNominaGeneral($idNomina);	
				}
				
				echo "1|".$idNomina;
			}
			
				
		}
		
		function obteneDatosNominaEmpleadoV2()
		{
			global $con;
			$idEmpleadoNomina=$_POST["idEmpleadoNomina"];
			$consulta="SELECT categoriaConcepto,clave,descripcion,importeGravado,importeExento FROM 700_percepcionesDeduccionesV2 WHERE idEmpleadoNomina=".$idEmpleadoNomina." AND tipoConcepto=2 and categoriaConcepto<>16";
			$arrPercepciones=$con->obtenerFilasArreglo($consulta);
			$consulta="SELECT categoriaConcepto,clave,descripcion,importeGravado,importeExento FROM 700_percepcionesDeduccionesV2 WHERE idEmpleadoNomina=".$idEmpleadoNomina." AND tipoConcepto=1 and categoriaConcepto<>6";
			$arrDeducciones=$con->obtenerFilasArreglo($consulta);
			$consulta="SELECT diasIncapacidad,tipoIncapacidad,descuentoIncapacidad,importeGravado,importeExento FROM 701_incapacidadesNominaV2 WHERE idEmpleadoNomina=".$idEmpleadoNomina;
			$arrIncapacidades=$con->obtenerFilasArreglo($consulta);
			$consulta="SELECT diasHorasExtra,tipoPagoHoras,totalHorasExtra,importePagado,importeGravado,importeExento FROM 702_horasExtraNominaV2 WHERE idEmpleadoNomina=".$idEmpleadoNomina;
			$arrHorasExtra=$con->obtenerFilasArreglo($consulta);
			echo "1|".$arrPercepciones."|".$arrDeducciones."|".$arrIncapacidades."|".$arrHorasExtra;
			
			
			
		}
		
		function modificarNominaEmpleadoV2()
		{
			global $con;
			$cadObj=$_POST["cadObj"];
			$obj=json_decode($cadObj);
			
			$query="SELECT idComprobante FROM 699_empleadosEjecucionNominaV2 WHERE idEmpleadoNomina=".$obj->idEmpleadoNomina;
			$idComprobante=$con->obtenerValor($query);
			
			
			$query="SELECT folio FROM 703_relacionFoliosCFDI WHERE idFolio=".$idComprobante;
			$folio=$con->obtenerValor($query);
			
			
			$x=0;
			$consulta[$x]="begin";
			$x++;
			
			$consulta[$x]="delete from 700_percepcionesDeduccionesV2 where idEmpleadoNomina=".$obj->idEmpleadoNomina;
			$x++;
			
			$consulta[$x]="delete from 701_incapacidadesNominaV2 where idEmpleadoNomina=".$obj->idEmpleadoNomina;
			$x++;
			
			$consulta[$x]="delete from 702_horasExtraNominaV2 where idEmpleadoNomina=".$obj->idEmpleadoNomina;
			$x++;
			
			$totalIncapacidades=0;
			
			$tIncapacidadGravado=0;
			$tIncapacidadExento=0;
			foreach($obj->arrIncapacidades as $p)
			{
				if($p->descuentoIncapacidad=="")
					$p->descuentoIncapacidad=0;
					
				$totalIncapacidades+=$p->descuentoIncapacidad;
				$tIncapacidadGravado+=$p->importeGravado;
				$tIncapacidadExento+=$p->importeExento;
				$consulta[$x]="INSERT INTO 701_incapacidadesNominaV2(diasIncapacidad,tipoIncapacidad,descuentoIncapacidad,idEmpleadoNomina,importeGravado,importeExento)
								values(".$p->diasIncapacidad.",'".$p->tipoIncapacidad."',".cv($p->descuentoIncapacidad).",".$obj->idEmpleadoNomina.",".$p->importeGravado.",".$p->importeExento.")";		
				$x++;
			}
			
			if(sizeof($obj->arrIncapacidades)>0)
			{
				$objPercepcion='{"tipoDeduccion":"6","clave":"d06","descripcion":"Descuento por incapacidad","importeGravado":"'.$tIncapacidadGravado.'","importeExento":"'.$tIncapacidadExento.'"}';	
				$oPercepcion=json_decode($objPercepcion);
				array_push($obj->arrDeducciones,$oPercepcion);
			}
			
			$totalHorasExtra=0;
			$tHoraExtraGravado=0;
			$tHoraExtraExento=0;
			foreach($obj->arrHorasExtra as $p)
			{
				
				if($p->importePagado=="")
					$p->importePagado=0;
				$totalHorasExtra+=$p->importePagado;
				$tHoraExtraGravado+=$p->importeGravado;
				$tHoraExtraExento+=$p->importeExento;
				$consulta[$x]="INSERT INTO 702_horasExtraNominaV2(diasHorasExtra,tipoPagoHoras,totalHorasExtra,importePagado,idEmpleadoNomina,importeGravado,importeExento)
								values(".$p->diasHorasExtra.",'".$p->tipoPagoHoras."','".cv($p->totalHorasExtra)."',".$p->importePagado.",".$obj->idEmpleadoNomina.",".$p->importeGravado.",".$p->importeExento.")";		
				$x++;
			}
			
			if(sizeof($obj->arrHorasExtra)>0)
			{
				$objPercepcion='{"tipoPercepcion":"16","clave":"p16","descripcion":"Horas extra","importeGravado":"'.$tHoraExtraGravado.'","importeExento":"'.$tHoraExtraExento.'"}';	
				$oPercepcion=json_decode($objPercepcion);
				array_push($obj->arrPercepciones,$oPercepcion);
			}
			
			$totalPercepciones=0;
			
			foreach($obj->arrPercepciones as $p)
			{
				if($p->importeGravado=="")
					$p->importeGravado=0;
				if($p->importeExento=="")
					$p->importeExento=0;
				$totalPercepciones+=$p->importeGravado+$p->importeExento;
				$consulta[$x]="INSERT INTO 700_percepcionesDeduccionesV2(idEmpleadoNomina,tipoConcepto,categoriaConcepto,clave,descripcion,importeGravado,importeExento)
								values(".$obj->idEmpleadoNomina.",2,".$p->tipoPercepcion.",'".$p->clave."','".cv($p->descripcion)."',".$p->importeGravado.",".$p->importeExento.")";		
				$x++;
			}
			
			$totalDeducciones=0;
			foreach($obj->arrDeducciones as $p)
			{
				if($p->importeGravado=="")
					$p->importeGravado=0;
				if($p->importeExento=="")
					$p->importeExento=0;
				$totalDeducciones+=$p->importeGravado+$p->importeExento;
				$consulta[$x]="INSERT INTO 700_percepcionesDeduccionesV2(idEmpleadoNomina,tipoConcepto,categoriaConcepto,clave,descripcion,importeGravado,importeExento)
								values(".$obj->idEmpleadoNomina.",1,".$p->tipoDeduccion.",'".$p->clave."','".cv($p->descripcion)."',".$p->importeGravado.",".$p->importeExento.")";		
				$x++;
			}
			
			$consulta[$x]="UPDATE 699_empleadosEjecucionNominaV2 SET totalPercepciones=".$totalPercepciones.",totalDeducciones=".$totalDeducciones.",sueldoNeto=".($totalPercepciones-$totalDeducciones).",montoIncapacidad=".$totalIncapacidades.",montoHorasExtra=".$totalHorasExtra.",sdi=".$obj->sdi." WHERE idEmpleadoNomina=".$obj->idEmpleadoNomina;		
			$x++;
			
			$consulta[$x]="commit";
			$x++;
			
			if($con->ejecutarBloque($consulta))
			{
				$c=new cNominaCFDI();
				$idRegistro=$obj->idEmpleadoNomina;
				
				
				
				$oNomina=generarXMLNominaGeneral($idRegistro,$folio);
				$c->setObjNomina($oNomina);
				$XML=$c->generarXML();
				$c->actualizarXMLComprobante($idComprobante);
				$c->generarSelloDigital($idComprobante);
				
				echo "1|";
			}
		}
		
		function obtenerCertificadosSeriesEmpresa()
		{
			global $con;
			$arrCertificados="";
			$idEmpresa=$_POST["idEmpresa"];
			$consulta="SELECT idCertificado,noCertificado FROM 687_certificadosSelloDigital WHERE idReferencia=".$idEmpresa." AND fechaFinVigencia>='".date("Y-m-d")."'  ORDER BY noCertificado";	

			$resCertificados=$con->obtenerFilas($consulta);
			while($fCertificado=mysql_fetch_row($resCertificados))
			{
				$consulta="SELECT idSerieCertificado,serie FROM 688_seriesCertificados WHERE idCertificado=".$fCertificado[0];
				$arrSeries=$con->obtenerFilasArreglo($consulta);
				$o="['".$fCertificado[0]."','".$fCertificado[1]."',".$arrSeries."]";
				if($arrCertificados=="")
					$arrCertificados=$o;
				else
					$arrCertificados.=",".$o;
			}
			
			
			$consulta="SELECT idRegistro,registroPatronal FROM 6927_empresaRegistroPatronal WHERE idEmpresa=".$idEmpresa." ORDER BY registroPatronal";
			$arrRegistroP=$con->obtenerFilasArreglo($consulta);
			echo "1|[".$arrCertificados."]|".$arrRegistroP;
		}
		
		function timbrarComprobantesNomina()
		{
			global $con;
			
			$listaEmpleados=$_POST["listaEmpleados"];
			$consulta="select idComprobante from 699_empleadosEjecucionNominaV2 where idEmpleadoNomina in(".$listaEmpleados.")"	;
			$res=$con->obtenerFilas($consulta);
			$c=new cFDIFinkok();		
			while($fila=mysql_fetch_row($res))
			{
				$c->timbrarComprobante($fila[0]);
			}
			echo "1|";
		}
		
		function timbrarComprobantes()
		{
			global $con;
			$listaEmpleados=$_POST["listaEmpleados"];
			if($listaEmpleados!="")
			{
				$arrComprobante=explode(",",$listaEmpleados);
	
				$c=new cFDIFinkok();		
				foreach($arrComprobante as $f)
				{
					$c->timbrarComprobante($f);
				}
			}
			echo "1|";
		}
		
		function obtenerHuellasUsuario()
		{
			global $con;
			$idUsuario=$_POST["idUsuario"];
			$tipoUsuario=$_POST["tipoUsuario"];
			$consulta="SELECT idTipoHuella,(SELECT COUNT(*) FROM 908_catalogoHuellas WHERE idUsuario=".$idUsuario." AND tipoUsuario=".$tipoUsuario." and noHuella=t.idTipoHuella) AS registrado FROM 826_tiposHuellasUsuario t ORDER BY idTipoHuella";
			$arrRegistos=utf8_encode($con->obtenerFilasJSON($consulta));
			echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistos.'}';
		}
		
		function obtenerRecibosNominaUsuario()
		{
			global $con;
			$ciclo=$_POST["ciclo"];
			if($ciclo=="")
				$ciclo=-1;
			$numReg=0;
			$arrComprobantes="";
			$consulta="select idAsientoNomina,a.idNomina,a.totalPercepciones,a.totalDeducciones,a.sueldoNeto,a.idComprobante,n.descripcion,n.folioNomina,n.institucion,n.quincenaAplicacion,n.idPerfil 
						FROM 672_nominasEjecutadas n,671_asientosCalculosNomina a,703_relacionFoliosCFDI r WHERE  a.idUsuario=".$_SESSION["idUsr"]." and n.ciclo=".$ciclo." and n.idNomina=a.idNomina  AND idComprobante IS NOT NULL
						and r.idFolio=a.idComprobante and r.situacion=2 order by quincenaAplicacion";											
			$res=$con->obtenerFilas($consulta);											
			while($fila=mysql_fetch_row($res))
			{
				
				$consulta="SELECT nombreElemento,noOrdinal FROM 678_elementosTipoPagoNomina e,662_perfilesNomina p WHERE idTipoPago=p.idPeriodicidad and idPerfilesNomina=".$fila[10]." and noOrdinal=".$fila[9]." ORDER BY noOrdinal";
				$fPeriodo=$con->obtenerPrimeraFila($consulta);
				$periodo=$fPeriodo[1];
				$lblQuincena=$fPeriodo[0];
				$consulta="select unidad from 817_organigrama where codigoUnidad='".$fila[8]."'";
				$institucion=$con->obtenerValor($consulta);
				
				$o='{"ordinal":"'.$periodo.'","idAsiento":"'.$fila[0].'","idNomina":"'.$fila[1].'","totalPercepciones":"'.$fila[2].'","totalDeducciones":"'.$fila[3].'","sueldoNeto":"'.$fila[4].'","idComprobante":"'.$fila[5].'","descripcion":"'.cv($fila[6]).'",
					"folioNomina":"'.$fila[7].'","plantel":"'.cv($institucion).'","periodo":"'.$lblQuincena.'"}';														
				if($arrComprobantes=="")
					$arrComprobantes=$o;
				else
					$arrComprobantes.=",".$o;
		
				$numReg++;	
				
			}
			echo '{"numReg":"'.$numReg.'","registros":['.$arrComprobantes.']}';
		}
		
		function bloquearDesbloquearDatosUsuarioNomina()
		{
			global $con;
			$idUsuario=bD($_POST["u"]);
			$situacion=bD($_POST["s"]);
			$consulta="UPDATE 802_identifica SET bloqueadoNomina=".$situacion." WHERE idUsuario=".$idUsuario;
			eC($consulta);
			
				
		}
?>