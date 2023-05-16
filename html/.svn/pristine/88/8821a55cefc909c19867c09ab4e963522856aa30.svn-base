<?php session_start();
	include("conexionBD.php");
	$parametros="";
	$x=0;
	$consulta;
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
		case "1":
			eliminarProceso();
		break;
		case "2":
			eliminarNivel();
		break;
		case "3":
			eliminarPrograma();
		break;
		case "4":
			eliminarHabilidad();
		break;
		case "5":
			eliminarCompetencia();
		break;
		case "6":
			eliminarActitud();
		break;
		case "7":
			eliminarRecurso();
		break;
		case "8":
			eliminarEvaluacion();
		break;
		case "9":
			eliminarTecnicaColaborativa();
		break;
		case "10":
			eliminarProducto();
		break;
		case "11":
			eliminarMateria();
		break;
		case "12":
			eliminarGrado();
		break;
		case "13":
			eliminarCiclo();
		break;
		case "14":
			eliminarDocumento();
		break;
		case "15":
			eliminarUnidadMedida();
		break;
		case "16":
			eliminarPeriodo();
		break;
		case "17":
			eliminarAreaConcentracion();
		break;
		case "18":
			eliminarIdiomaMateria();
		break;
		case "19":
			eliminarEscalaCalificacion();
		break;
		case "20":
			eliminarEtapa();
		break;
		case "21":
			eliminarActitudMateria();
		break;
		case "22":
			eliminarCompetenciaMateria();
		break;
		case "23":
			eliminarEvaluacionMateria();
		break;
		case "24":
			eliminarHabilidadMateria();
		break;
		case "25":
			eliminarRecursoMateria();
		break;
		case "26":
			eliminarTecnicaMateria();
		break;
		case "27":
			eliminarTema();
		break;
		case "28":
			obtenerElementosMateria();
		break;
		case "29":
			obtenerElementosMateria2();
		break;
		case "30":
			cargarCombo();
		break;
		case "31":
			eliminarInmueble();
		break;
		case "32":
			obtenerParametrosAutomaticos();
		break;
		case "33":
			obtenerRecursos();
		break;
		case 34:
			obtenerRecursosSolEvento();
		break;
		case 35:
			validarRecursos();
		break;
		case 36:
			generarArbolTemas3();
		break;
		case 100:
			elementosCompartida();
		break;
		case 101:
			eliminarInformacionCompartida();
		break;
		case 102:
			obtenerDisciplinasCampo();
		break;
		case 103:
			obtenerSubDisciplinas();
		break;
		case 200:
			eliminarTiempoP();
		break;
	}


function eliminarProceso()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4001_procesos where idProceso=".$id;
	$re1=$con->ejecutarConsulta($consulta);
	
	
	if(($re1))
			echo "1";
		else
			echo "-1";

}


function eliminarNivel()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4003_nivel where idNivel=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}

function eliminarPrograma()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4004_programa where idPrograma=".$id;
	$consulta2="delete from 4020_programaVsDocumento where idPrograma=".$id;
	$re1=$con->ejecutarConsulta($consulta);
	$re2=$con->ejecutarConsulta($consulta2);
		
	if(($re1)and($re2))
			echo "1";
		else
			echo "-1";

}

function eliminarHabilidad()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4006_habilidades where idHabilidad=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}


function eliminarCompetencia()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4007_competencias where idCompetencia=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}

function eliminarActitud()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4008_actitudes where idActitud=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}

function eliminarRecurso()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from  4009_recursos where idRecurso=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}

function eliminarEvaluacion()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4010_evaluaciones where idEvaluacion=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}

function eliminarTecnicaColaborativa()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4011_tecnicasColaborativas where idTecnicaC=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}

function eliminarProducto()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4012_productos where idProducto=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}

function eliminarMateria()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4013_materia where idMateria=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}

function eliminarGrado()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4014_grados where idGrado=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}

function eliminarCiclo()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4015_ciclos where idCiclo=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}

function eliminarDocumento()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4016_documentos where idDocumento=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}

function eliminarUnidadMedida()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from  4018_UnidadesDeMedida where idUnidadMedida=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}

function eliminarPeriodo()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4019_periodos where idPeriodo=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}

function eliminarAreaConcentracion()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4021_areasConcentracion where idAreaConcentracion=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}

function eliminarIdiomaMateria()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4024_idiomasMateria where idIdiomaMateria=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}

function eliminarEscalaCalificacion()
{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4032_escalasCalificacion where idEscalaCalificacion=".$id;
	$consulta2="delete from 4033_elementosEscala where idEscalaCalificacion=".$id;
	$re1=$con->ejecutarConsulta($consulta);
	$re2=$con->ejecutarConsulta($consulta2);
	if(($re1)and($re2))
			echo "1";
		else
			echo "-1";
}

function eliminarEtapa()
{
	global $con;
	$id=bD($_POST["idEtapa"]);
	$query="select * from 4037_etapas where idEtapa=".$id;
	$filaEt=$con->obtenerPrimeraFila($query);
	$idProceso=$filaEt[1];
	$aEtapa=$filaEt[2];	
	$x=0;
	$consulta[$x]="begin";
	$x++;
	$consulta[$x]="delete from 4037_etapas where idEtapa=".$id;
	$x++;
	$consulta[$x]="delete from  4002_rolesVSEtapas where idEtapa=".$id;
	$x++;
	$consulta[$x]="delete from  234_proyectosVSComitesVSEtapas where idProyecto=".$idProceso." and numEtapa=".$aEtapa;
	$x++;
	$consulta[$x]="delete from  4002_rolesVSEtapas where etapa=".$aEtapa." and proceso=".$idProceso;
	$x++;
	$consulta[$x]="delete from  4038_etapasVSUsuarios where idEtapa=".$aEtapa." and idProceso=".$idProceso;
	$x++;
	$consulta[$x]="delete from  518_camposEtapa where numEtapa=".$aEtapa." and idProceso=".$idProceso;
	$x++;
	$consulta[$x]="delete from  521_bitacoraEtapasPOA where etapaActual=".$aEtapa." and idProceso=".$idProceso;
	$x++;
	$consulta[$x]="delete from  521_bitacoraEtapasPOA  where etapaAnterior=".$aEtapa." and idProceso=".$idProceso;
	$x++;
	$consulta[$x]="delete from  521_modificacionesRegistrosPOA where situacion=".$aEtapa." and idProceso=".$idProceso;
	$x++;
	$consulta[$x]="delete from  521_registrosPOA  where situacion=".$aEtapa." and idProceso=".$idProceso;
	$x++;
	$consulta[$x]="delete from  522_afectacionCuentasPOA  where numEtapa=".$aEtapa." and idProceso=".$idProceso;
	$x++;				
	$consulta[$x]="update 900_formularios set idEtapa=-1 where idEtapa=".$aEtapa." and idProceso=".$idProceso;
	$x++;		
	$consulta[$x]="delete from 911_disparadores  where idEtapa=".$aEtapa." and idFormulario in (select idFormulario from 900_formularios
					where idProceso=".$idProceso.")";
	$x++;	
	$consulta[$x]="delete from  912_reportes where idEtapa=".$aEtapa." and idProceso=".$idProceso;
	$x++;	
	$consulta[$x]="delete from  941_bitacoraEtapasFormularios where etapaActual=".$aEtapa." and idFormulario in (select idFormulario from 900_formularios
					where idProceso=".$idProceso.")";
	$x++;	
	$consulta[$x]="delete from  941_bitacoraEtapasFormularios where etapaAnterior=".$aEtapa." and idFormulario in (select idFormulario from 900_formularios
					where idProceso=".$idProceso.")";
	$x++;	
	$consulta[$x]="delete from  944_actoresProcesoEtapa where numEtapa=".$aEtapa." and idProceso=".$idProceso;
	$x++;		
	$consulta[$x]="delete from  995_proyectosVSParticipantesVSEtapas where numEtapa=".$aEtapa." and idProyecto=".$idProceso;
	$x++;		
	$consulta[$x]="delete from 947_actoresProcesosEtapasVSAcciones WHERE 
					idGrupoAccion=1 AND CAST(complementario AS DECIMAL(10,2))=".$aEtapa." AND idActorProcesoEtapa IN
					(SELECT idActorProcesoEtapa FROM 944_actoresProcesoEtapa WHERE idProceso=".$idProceso.")";
	$x++;
	$consulta[$x]="commit";
	$x++;
	eB($consulta);
}


function eliminarActitudMateria()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4043_materiaVsActitudes where idMateriaVsActitud=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}


function eliminarCompetenciaMateria()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4041_materiaVsCompetencias where idMateriaVsCompetencias=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}

function eliminarEvaluacionMateria()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4185_materiaVSProducto where idMateriaVSProducto=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}



function eliminarHabilidadMateria()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4042_materiaVsHabilidades where idMateriaVsHabilidad=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}

function eliminarRecursoMateria()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4045_materiaVsRecursos where idMateriaVsRecurso=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}

function eliminarTecnicaMateria()
	{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from 4046_materiaVsTecnicas where idMateriaVsTecnica=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";

}

function eliminarTema()
{
	global $con;
	$idTemaA=$_POST["idTema"];
	$arreglo=explode(',',$idTemaA);
	$tamano=sizeof($arreglo);
	global $x;
	$x=0;
	global $consulta;
	for($y=0;$y<$tamano;$y++)
	{
		$idTema=$arreglo[$y];
	$consulta[$x]="begin";
	$x++;
	tema($idTema);
	borrar($idTema);
	$consulta[$x]="commit";
	
	}
	
	if ($con->ejecutarBloque($consulta))
		echo "1|";
	else
		echo "|";
}

function borrar($id)
{	
	global $con;
	global $x;
	global $consulta;
	$consulta[$x]="delete from 4039_temas where idTema=".$id;
	$x++;

}

function tema($id)
{
	global $con;
	$query="select idTema,numTema,nombreTema from 4039_temas where idPadre=".$id." order by numTema";
	$resE=$con->obtenerFilas($query);
	while($fA=mysql_fetch_row($resE))
	{
  
		tema($fA[0]);
		borrar($fA[0]);

	}
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
	
function generarArbolTemas($id,$numeracion)
	{
		 global $con;
		 
		 
		 $cadena="";
		 $consulta="select idTema,numTema,nombreTema,descripcion from 4039_temas where idPadre=".$id." and idProfesor=0";
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
									text: '".$numeracion.$ct.".- ".$fila[2]."&nbsp;&nbsp;<img src=\"../images/icon_code.gif\" title=\"Descripci&oacute;n:&nbsp;".$fila[3]."\" alt=\"Descripci&oacute;n:&nbsp;".$fila[3]."\" />',
									icon:'images/s.gif',
									leaf: true,
									draggable:false
									
									
						  }
								 ";
					}
					else
					{
					$obj="{
									id:".$fila[0].",
									text: '".$numeracion.$ct.".- ".$fila[2]."&nbsp;&nbsp;<img src=\"../images/icon_code.gif\" title=\"Descripci&oacute;n:&nbsp;".$fila[3]."\" alt=\"Descripci&oacute;n:&nbsp;".$fila[3]."\" />',
									icon:'images/s.gif',
									draggable:false,
									
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
	
	function obtenerElementosMateria2()
	{
	global $con;
	global $mostrarXML;
	$mostrarXML=false;
	
	if(isset($_POST["idMateria"]))
		$idMateria="-".$_POST["idMateria"];
	
	//$banderaX=0;
//	if(isset($_POST["bandera"]))
//		$banderaX=$_POST["bandera"];
	
	//echo $bandera;
	$cadTemas=generarArbolTemas2($idMateria,"");
	echo $cadTemas;
	}
	
	function generarArbolTemas2($id,$numeracion)
	{
		
		 global $con;
		 $cadena="";
		 
		 
		// if($banderaX==0)
//		 {
		 	$consulta="select idTema,numTema,nombreTema,descripcion from 4039_temas where idPadre=".$id;
		 	$res2=$con->obtenerFilas($consulta);
		 //}
//		 else
//		 {
//			$consulta="select idTema,numTema,nombreTema from 4039_temas where idPadre=".$id." and idProfesor=".$idUsuario ;
//		 	$res2=$con->obtenerFilas($consulta);
//		 }
		 
		 $clase="filaBlanca10";
		 $ct=1;
		 while($fila=mysql_fetch_row($res2))
		 {
			
			  $hijos=generarArbolTemas2($fila[0],$numeracion.$ct.".");
			  
			  if ($hijos=="[]")
			  {
				  $obj="{
								  id:".$fila[0].",
								  text: '".$numeracion.$ct.".- ".$fila[2]."&nbsp;&nbsp;<img src=\"../images/icon_code.gif\" title=\"Descripci&oacute;n:&nbsp;".$fila[3]."\" alt=\"Descripci&oacute;n:&nbsp;".$fila[3]."\" />',
								  checked:false,
								  icon:'images/s.gif',
								  leaf: true,
								  draggable:false,
								  listeners:	{
														  
											  }
								  
						}
							   ";
			  }
			  else
			  {
				  $obj="{
								  id:".$fila[0].",
								  text: '".$numeracion.$ct.".- ".$fila[2]."&nbsp;&nbsp;<img src=\"../images/icon_code.gif\" title=\"Descripci&oacute;n:&nbsp;".$fila[3]."\" alt=\"Descripci&oacute;n:&nbsp;".$fila[3]."\" />',
								  checked:false,
								  icon:'images/s.gif',
								  draggable:false,
								  listeners:	{
														  
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

	function cargarCombo()
	{
		global $con;
		$arrObj="";
		$datos=$_POST["objDatos"];
		$sql="SELECT distinct(n.NombrePrograma),o.idPrograma FROM  4004_programa n,4029_mapaCurricular o ,4035_programaVsRol pr
				WHERE pr.idPrograma=o.idPrograma and pr.idRol in(".$_SESSION["idRol"].") and o.idPrograma=n.idPrograma AND o.ciclo=".$datos." AND (o.estadoMapa=1 OR o.estadoMapa=2)ORDER BY n.idPrograma";
		$result =$con->obtenerFilas( $sql);
		while ( $row = mysql_fetch_row ( $result ) )
		{
			$obj='{"IdPrograma":"'.$row[1].'","Programa":"'.$row[0].'"}';
			if($arrObj=="")
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
		}
		echo '1|['.$arrObj.']';
	}		   	


function eliminarInmueble()
{
	global $con;
	$id=$_POST["id"];
	$consulta="delete from  4058_inmuebles where idInmueble=".$id;
	$re1=$con->ejecutarConsulta($consulta);
		
	if(($re1))
			echo "1";
		else
			echo "-1";
}


function obtenerParametrosAutomaticos()
{
	global $con;
	$idAccion=$_POST["idAccion"];
	$consulta="select valor,parametro from 2005_parametrosMensajes where idIdioma=".$_SESSION["leng"]." and tipoParametro=2 and idGrupoAccion=".$idAccion;
	$arrParam=$con->obtenerFilasArreglo($consulta);
	echo "1|".uEJ($arrParam);
}


function obtenerRecursos()
{
	global $con;
	$idCategoria=$_POST["idCategoria"];
	$apartable=$_POST["apartable"];
	
	if($apartable==1)
		$consulta="select idRecurso,titulo from 4009_recursos where apartable=0 and idTipoRecurso=".$idCategoria." order by titulo";  	
	else
		$consulta="select idRecurso,titulo from 4009_recursos where idTipoRecurso=".$idCategoria." order by titulo";  	
	
	$arrRecursos=$con->obtenerFilasArreglo($consulta);
	echo "1|".uEJ($arrRecursos);

}

function obtenerRecursosSolEvento()
{
	global $con;
	$idCategoria=$_POST["idCategoria"];
	if(isset($_POST["fecha"]))
		$fecha=$_POST["fecha"];
	else
		$fecha=0;
	if(isset($_POST["hI"]))
		$hI=$_POST["hI"];
	else
		$hI=0;
	if(isset($_POST["hF"]))
		$hF=$_POST["hF"];
	else
		$hF=0;
	$consulta="select idRecurso,titulo from 4009_recursos where apartable=0 and idTipoRecurso=".$idCategoria." order by titulo";  	
	$resRec=$con->obtenerFilas($consulta);
	$arrRecursos="";
	while($filaRec=mysql_fetch_row($resRec))
	{
		$consulta="select a.horaInicio,a.horaFin,r.titulo from 4098_apartaRecursos a,4009_recursos r  where r.idRecurso=a.idRecursoApartado and estadoRecurso=1 and  a.idRecursoApartado=".$filaRec[0]." and a.fecha='".$fecha."'";
		$res=$con->obtenerFilas($consulta);
		$colision=false;
		while($fila=mysql_fetch_row($res))
		{
			if(colisionaTiempo($hI,$hF,$fila[0],$fila[1]))
			{
				$colision=true;
				break;
			}
		}
		if(!$colision)
		{
			$obj="['".$filaRec[0]."','".$filaRec[1]."']";
			if($arrRecursos=="")
				$arrRecursos=$obj;
			else
				$arrRecursos.=",".$obj;
		}
		
	}
	echo "1|[".uEJ($arrRecursos)."]";
}

function validarRecursos()
{
	global $con;
	$lRecursos=$_POST["lRecursos"];
	$reporteRecursos='';
	if($lRecursos!='')
	{
		  $fecha=$_POST["fecha"];
		  $hI=$_POST["hI"];
		  $hF=$_POST["hF"];
		  $arrRecursos=explode(',',$lRecursos);
		  $nRecursos=sizeof($arrRecursos);
		  $reporteRecursos="";
			  for($x=0;$x<$nRecursos;$x++)
		  {
			  $consulta="select a.horaInicio,a.horaFin,r.titulo from 4098_apartaRecursos a,4009_recursos r  where r.idRecurso=a.idRecursoApartado and  a.idRecursoApartado=".$arrRecursos[$x]." and a.fecha='".$fecha."'";
			  $res=$con->obtenerFilas($consulta);
			  while($fila=mysql_fetch_row($res))
			  {
				  if(colisionaTiempo($hI,$hF,$fila[0],$fila[1]))
				  {
					  if($reporteRecursos=='')
						  $reporteRecursos=$fila[2];
					  else
						  $reporteRecursos=','.$fila[2];
					  break;
				  }
			  }
						  
		  }
	}
	echo "1|".$reporteRecursos;
}

function generarArbolTemas3()
	{
		
		 global $con;
		 $cadena="";
		 $idUsuario=$_SESSION["idUsr"];
		 if(isset($_POST["idMateria"]))
			$idMateria="-".$_POST["idMateria"];	
		 $id=$idMateria;
		 $numeracion="";
		// if($banderaX==0)
//		 {
		 	$consulta="select idTema,numTema,nombreTema,descripcion from 4039_temas where idPadre=".$id." and idProfesor in(".$idUsuario.",0)";
			//echo $consulta;
			$res2=$con->obtenerFilas($consulta);
		 //}
//		 else
//		 {
//			$consulta="select idTema,numTema,nombreTema from 4039_temas where idPadre=".$id." and idProfesor=".$idUsuario ;
//		 	$res2=$con->obtenerFilas($consulta);
//		 }
		 
		 $clase="filaBlanca10";
		 $ct=1;
		 while($fila=mysql_fetch_row($res2))
		 {
			
			  $hijos=generarArbolTemas2($fila[0],$numeracion.$ct.".");
			  
			  if ($hijos=="[]")
			  {
				  $obj="{
								  id:".$fila[0].",
								  text: '".$numeracion.$ct.".- ".$fila[2]."&nbsp;&nbsp;<img src=\"../images/icon_code.gif\" title=\"Descripci&oacute;n:&nbsp;".$fila[3]."\" alt=\"Descripci&oacute;n:&nbsp;".$fila[3]."\" />',
								  checked:false,
								  icon:'images/s.gif',
								  leaf: true,
								  draggable:false
						}
							   ";
			  }
			  else
			  {
				  $obj="{
								  id:".$fila[0].",
								  text: '".$numeracion.$ct.".- ".$fila[2]."&nbsp;&nbsp;<img src=\"../images/icon_code.gif\" title=\"Descripci&oacute;n:&nbsp;".$fila[3]."\" alt=\"Descripci&oacute;n:&nbsp;".$fila[3]."\" />',
								  checked:false,
								  icon:'images/s.gif',
								  draggable:false,
								  listeners:	{
														  
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
		
		echo "[".$cadena."]";
		
	
	}
function elementosCompartida()
{
	global $con;
	$idMateria=$_POST["idMateria"];
	$idCiclo=$_POST["idCiclo"];
	
	$mensajeFinal="";
	$mensajeGrupos="";
	$mapasCompartidos="";
	
	
	$conMapas="SELECT idElementoMapa,idMapaCurricular FROM 4031_elementosMapa WHERE idMateria=".$idMateria." AND perteneceMapa=0" ;
	$resMapas=$con->obtenerFilas($conMapas);
	$numMapas=$con->filasAfectadas;
	while($fMapas=mysql_fetch_row($resMapas))	
	{
		$conNomMapa="SELECT nombrePrograma FROM 4004_programa p,4029_mapaCurricular m WHERE p.idPrograma=m.idPrograma AND idMapaCurricular=".$fMapas[1]." AND m.ciclo=".$idCiclo;
		$nomProg=$con->obtenerValor($conNomMapa);
		
		if($mapasCompartidos=="")
			$mapasCompartidos=$nomProg;
		else
			$mapasCompartidos.=",".$nomProg;
	}
	
	$conGrupos="SELECT nombreGrupo,idGrupo FROM 4048_grupos WHERE idMateria=".$idMateria;
	$resGrupos=$con->obtenerFilas($conGrupos);
	$numGrupos=$con->filasAfectadas;
	
	while($fGrupos=mysql_fetch_row($resGrupos))	
	{
		$conProfesores="SELECT i.idUsuario,i.Nombre,e.descParticipacion FROM 4047_participacionesMateria p ,802_identifica i,953_elementosPerfilesParticipacionAutor e 
						WHERE idMateria=".$idMateria." AND idGrupo=".$fGrupos[1]." AND i.idUsuario=p.idUsuario AND e.idElementoPerfilAutor=p.idParticipacion";
		$resProfesores=$con->obtenerfilas($conProfesores);				
		$numFilasP=$con->filasAfectadas;
		$profesoresGrupo="";
		while($fProfesor=mysql_fetch_row($resProfesores))
		{
			$participacion=$fProfesor[1]."&nbsp;&nbsp;<font color='#009933'><b>Participacion:&nbsp;</b></font>".$fProfesor[2];
			
			if($profesoresGrupo=="")
				$profesoresGrupo=$participacion;
			else	
				$profesoresGrupo.="<br/>".$participacion;
		}		
		
		
		$conHorarioGrupo="SELECT distinct(dia),m.horaInicio,m.horaFin FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
								WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$idMateria." AND idGrupoCompartido=".$fGrupos[1]." and ciclo=".$idCiclo;
		$resHc=$con->obtenerFilas($conHorarioGrupo);						
		$numFilasH=$con->filasAfectadas;
		
		if($numFilasH==0)
		{
			$conHorarioGrupo="SELECT dia,horaInicio,horaFin FROM 4180_materiaCompVSGrupo WHERE idMateria=".$idMateria." AND idGrupo=".$fGrupos[1];
			$resHc=$con->obtenerFilas($conHorarioGrupo);
		}
		
			$horarioGrupo="";
			$nomDia="-1";
			while($fhorarioA=mysql_fetch_row($resHc))
			{
				switch($fhorarioA[0])
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
		      	if($nomDia!=$fhorarioA[0])
					$diaImprime=$dia;
				else
					$diaImprime="";
				
				$horaDia=$diaImprime."&nbsp;".$fhorarioA[1]."-".$fhorarioA[2];
				
				
			  if($horarioGrupo=="")
			  	$horarioGrupo=$horaDia;
			  else	
			  	$horarioGrupo.="<br/>".$horaDia;
			
			
			$nomDia=$fhorarioA[0];
			}
		
		
		$grupoHorario="<font color='#0000CC'><b>".$fGrupos[0]."</b></font>";
		
		if($profesoresGrupo!="")
			$grupoHorario.="<br/><b>Profesores:</b><br/>".$profesoresGrupo;
		
		if($horarioGrupo!="")
			$grupoHorario.="<br/><b>Horario:</b><br/>".$horarioGrupo;
		
		if($mensajeGrupos=="")
			$mensajeGrupos=$grupoHorario;
		else
			$mensajeGrupos.="<br/>".$grupoHorario;
	}
	
	if($mapasCompartidos!="")
	{
		$mensajeFinal="Esta Materia se vincula con los siguientes programas<br/>".$mapasCompartidos;
	}
	
	if($mensajeGrupos!="")
	{
		$mensajeFinal="<br/>Esta Materia cuenta con los siguientes Grupos:<br/>".$mensajeGrupos;
	}
	
	if($mensajeFinal=="")	
		echo"1|";
	else
		echo"2|".$mensajeFinal;
}

function eliminarInformacionCompartida()
{
	global $con;
	$idMateria=$_POST["idMateria"];
	$idCiclo=$_POST["idCiclo"];
	
	$conGrupos="SELECT nombreGrupo,idGrupo FROM 4048_grupos WHERE idMateria=".$idMateria;
	$resGrupos=$con->obtenerFilas($conGrupos);
	$filasGrupo=$con->filasAfectadas;
	if($filasGrupo>0)
	{
	  $consulta="begin";
	  if($con->ejecutarConsulta($consulta)) 
	  {
		  $x=0;
		  while($fila=mysql_fetch_row($resGrupos))
		  {
			  $query[$x]="delete FROM 4180_materiaCompVSGrupo WHERE idMateria=".$idMateria." AND idGrupo=".$fila[1];
			  $x++;
			  
			  $query[$x]="delete from 4065_materiaVSGrupo WHERE idMateria=".$idMateria." AND idGrupoCompartido=".$fila[1]." and ciclo=".$idCiclo;
			  $x++;
			  
			  $query[$x]="DELETE FROM 4047_participacionesMateria WHERE idMateria=".$idMateria." AND idGrupo=".$fila[1];
			  $x++;
			  
			  $query[$x]="DELETE FROM 4048_grupos WHERE idGrupo=".$fila[1];
			  $x++;
		  }
		  
		  $query[$x]="delete FROM 4031_elementosMapa WHERE idMateria=".$idMateria." AND perteneceMapa=0";
		  $x++;
			  
		  $query[$x]="commit";
		  if($con->ejecutarBloque($query))
		  	echo"1|";
		  else
		  	echo"2|";
	  }
	}
	else
	{
		$query="delete FROM 4031_elementosMapa WHERE idMateria=".$idMateria." AND perteneceMapa=0";
		
		if($con->ejecutarConsulta($query))
			echo"1|";
		else
			echo "2|";
		
	}
}

function obtenerDisciplinasCampo()
{
	global $con;
	$codCampo=$_POST["codCampo"];
	$arreglo="";
	
	$consulta="SELECT codigoDisciplina,nombre FROM 4212_disciplinasUnesco WHERE codigoCampo=".$codCampo;
	$arreglo=$con->obtenerFilasArreglo($consulta);
	
	echo "1|".$arreglo;

}

function obtenerSubDisciplinas()
{
	global $con;
	$codDisciplina=$_POST["codDisciplina"];
	$arreglo="";
	
	$consulta="SELECT codigoSubDisciplina,nombre FROM  4213_subDisciplinasUnesco WHERE codigoDisciplina=".$codDisciplina;
	$arreglo=$con->obtenerFilasArreglo($consulta);
	
	echo "1|".$arreglo;

}

function eliminarTiempoP()
{
	global $con;
	
	$id=$_POST["id"];
	
	$consulta="DELETE FROM 524_tiemposPresupuestales WHERE idTiempoPresupuestal=".$id;
	if($con->ejecutarConsulta($consulta))
		echo "1|";
	else
		echo "|";
}
?>