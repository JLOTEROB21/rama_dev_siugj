<?php session_start();
	;
	include("funcionesFormularios.php"); 
	include("configurarIdioma.php");
	include("funcionesClonacionReportesThot.php");
	include_once("diccionarioTerminos.php");
	if(isset($_SESSION["leng"]))
	{
		if(isset($_POST["parametros"]))
			$parametros=$_POST["parametros"];
		if(isset($_POST["funcion"]))
			$funcion=$_POST["funcion"];
		$lenguaje=$_SESSION["leng"];
		
		switch($funcion)
		{
			case 1:
				obtenerProgramasAcademicos();
			break;
			case 2:
				removerProgramaAcademico();
			break;
			case 3:
				obtenerSedesPrograma();
			break;
			case 4:
				obtenerUsuariosResponsablesSede();
			break;
			case 5:
				buscarEmpleado();
			break;
			case 6:
				guardarResponsablePrograma();
			break;
			case 7:
				eliminarResponsablePrograma();
			break;
			case 8:
				eliminarGrado();
			break;
			case 9:
				obtenerPlantelesPlanEstudio();
			break;
			case 10:
				agregarPlanEstudiosPlanteles();
			break;
			case 11:
				removerPlanEstudiosPlanteles();
			break;
			case 12:
				guardarTemaMateria();
			break;
			case 13:
				obtenerTemarioMateria();
			break;
			case 14:
				removerTema();
			break;
			case 15:
				obtenerMateriasParaRequisitoMateria();
			break;
			case 16:
				guardarRequisitosMateria();
			break;
			case 17:
				obtenerPlanEstudioPredecesor();
			break;
			case 18:
				guardarPlanesEstudioPredecesores();
			break;
			case 19:
				obtenerEstructuraCurricular();
			break;
			case 20:
				obtenerGradosDisponiblesEstructuraCurricular();
			break;
			case 21:
				agregarElementoEstructuraCurricular();
			break;
			case 22:
				modificarUnidadEstructuraCurricular();
			break;
			case 23:
				eliminarUnidadEstructuraCurricular();
			break;
			case 24:
				obtenerMateriasDisponiblesEstructuraCurricular();
			break;
			case 25:
				obtenerProgramasPlantel();
			break;
			case 26:
				eliminarMateria();
			break;
			case 27:
				obtenerFechasCiclo();
			break;
			case 28:
				guardarFechaNoHabil();
			break;
			case 29:
				removerFecha();
			break;
			case 30:
				obtenerMateriasProfesor();
			break;
			case 31:
				obtenerTemarioMateriaProfesor();
			break;
			case 32:
				obtenerSesionesGrupo();
			break;
			case 33:
				registrarAsistencia();
			break;
			case 34:
				obtenerTemarioMateriaPlaneacion();
			break;
			case 35:
				obtenerSesionesAlumno();
			break;
			case 36:
				obtenerEspecilidadArea();
			break;
			case 37:
				guardarEspecialidadMateria();
			break;
			case 38:
				obtenerIdRegistroConfiguracion();
			break;
			case 39:
				obtenerProgramasSede();
			break;
			case 40:
				obtenerMateriasPlanesEstudio();
			break;
			case 41:
				guardarGrupoCompartido();
			break;
			case 42:
				removerGrupoCompartido();
			break;
			case 43:
				obtenerPlanesMateriaComparteGrupo();
			break;
			case 44:
				obtenerHistorialAlumno();
			break;
			case 45:
				obtenerPlanEstudioPlantel();
			break;
			case 46:
				inscribirAlumnoGradoManual();
			break;
			case 47:
				removerAlumnoCiclo();
			break;
			case 48:
				verificarEscala();
			break;
			case 49:
				eliminarEscala();
			break;
			case 50:
				obtenerFechasPeriodo();
			break;
			case 51:
				guardarFechaPeriodo();
			break;
			case 52:
				obtenerMateriasModificacionHoras();
			break;
			
			case 53:
				clonarPlanEstudios();
			break;
			case 54:
				ajustarFechasTerminoGrupos();
			break;
			case 55:
				obtenerProgramasEducativosNivel();
			break;
			case 56:
				finalizarRegistroAsistencia();
			break;
			case 57:
				obtenerProgramasEducativosCiclo();
			break;
			case 58:
				obtenerPlanEstudiosProgramasEducativosCiclo();
			break;
			case 59:
				obtenerPeriodosInstanciaPlanEstudio();
			break;
			case 60:
				obtenerMateriasCicloPeriodoInstancia();
			break;
			case 61:
				obtenerGruposMateriasCicloPeriodoInstancia();
			break;
			case 62:
				obtenerAsistenciaAlumnoPeriodo();
			break;
			case 63:
				registrarSesionesModificacionAsistencia();
			break;
			case 64:
				obtenerAsistenciaAlumnoPeriodoVista();
			break;
			case 65:
				registrarSesionesModificacionAsistenciaResponsable();
			break;
			case 66:
				obtenerPlanEstudiosProgramasEducativos();
			break;
			case 67:
				obtenerProfesoresGrupo();
			break;
			case 68:
				obtenerAsignacionesProfesorGrupo();
			break;
			case 69:
				obtenerCalificacionesAlumno();
			break;
			case 70:
				obtenerDiaHabilProximo();
			break;
			case 71:
				obtenerProgramasEducativosPlantel();
			break;
			case 72;
				obtenerInstanciasPlanEstudioPlantelProgramaEducativo();
			break;
			case 73:
				obtenerInstanciasPlanEstudioPlantelProgramaEducativoArreglo();
			break;
			case 74:
				obtenerMateriasInstanciaPlan();
			break;
			case 75:
				obtenerConfiguracionEvaluacionMateria();
			break;
			case 76:
				registrarConfiguracionEvaluacionInstanciaPlan();
			break;
			case 77:
				obtenerSituacionMateriasReinscripcion();
			break;
			case 78:
				registrarOfertaCargaAcademica();
			break;
			case 79:
				obtenerMateriasDisponiblesInscripcion();
			break;
			case 80:
				obtenerGruposDisponiblesInscripcion();
			break;
			case 81:
				marcarCargaSeleccionada();
			break;
			case 82:
				publicarOfertasCargaAcademica();
			break;
			case 83:
				obtenerCalendariosTipoPerfil();
			break;
			case 84:
				obtenerEventosCalendarioTipoPerfil();
			break;
			case 85:
				obtenerConfiguracionHorarioInstanciaPlan();
			break;
			case 86:
				registrarConfiguracionInstanciaPlan();
			break;
			case 87:
				obtenerEstructuraCurricularPredecesor();
			break;
			case 88:
				asignarMateriaPredecesora();
			break;
			
		}
	}
	
	function obtenerProgramasAcademicos()
	{
		global $con;
		$comp="";
		if(isset($_POST["nivelAcademico"]))
		{
			$nivelAcademico=$_POST["nivelAcademico"];
			if($nivelAcademico!=0)
				$comp=" and nivelPlanEstudio=".$nivelAcademico;
		}
		/*$orden=$_POST["sort"];
		$dir=$_POST["dir"];*/
		$mostrarInactivos=false;
		if((isset($_POST["chkInactivos"]))&&($_POST["chkInactivos"]==1))
			$mostrarInactivos=true;
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		
		$filtroActivos=" and p.situacion=1";
		if($mostrarInactivos)
			$filtroActivos="";
			
		$listaPlanes="-1";	
		
		if(existeRol("'-4001_0'"))
		{
			$consulta="SELECT idPlanEstudio FROM 4500_planEstudio";
			$listaPlanes=$con->obtenerListaValores($consulta);
			if($listaPlanes=="")
			{
				$listaPlanes=-1;
			}
		}
		else
		{
			$consulta="(SELECT idPlanEstudio FROM 4500_planEstudio WHERE responsableCreacion=".$_SESSION["idUsr"].")";
						
			if($con->existeTabla("4500_accesoUsuarioPlanes"))			
			{
				$consulta.=	"union (SELECT idPlanEstudio FROM 4500_accesoUsuarioPlanes WHERE idUsuario=".$_SESSION["idUsr"].")";
			}
			
			$listaPlanes=$con->obtenerListaValores($consulta);
			if($listaPlanes=="")
			{
				$listaPlanes=-1;
			}
		}
		$consulta="SELECT idPlanEstudio,nombre,descripcion,cveRvoe,cvePlanEstudio,s.nombreStatus,fechaRvoe,p.idProgramaEducativo,AreaEspecialidad,nivelPlanEstudio FROM 4500_planEstudio p,4005_status s 
				WHERE s.idStatus=p.situacion and idPlanEstudio in(".$listaPlanes.") and ".$cadCondWhere." ".$comp." ".$filtroActivos." ORDER BY  idProgramaEducativo,nombre";
		
		

		
		$arrProgramas=$con->obtenerFilasJson($consulta);
		$nFilas=$con->filasAfectadas;
		echo '{"nuReg":"'.$nFilas.'","registros":'.utf8_encode($arrProgramas).'}';
	}
	
	function removerProgramaAcademico()
	{
		global $con;
		$idPlanEstudio=$_POST["idPrograma"];
		$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idPlanEstudio=".$idPlanEstudio;
		$res=$con->obtenerValor($consulta);
		if($res!="")
		{
			echo $dic["planEstudio"]["s"]["el"]." ".strtolower($dic["planEstudio"]["s"]["et"])."  est&aacute; siendo referenciado por otros registros, se recomienda marcarlo como inactivo";
			return;
		}
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="delete from 4500_planEstudio where idPlanEstudio=".$idPlanEstudio;
		$x++;
		$query[$x]="delete from 4500_usuariosResponsablesPlanEstudio where idPlanEstudio=".$idPlanEstudio;
		$x++;
		$query[$x]="delete from 4501_Grado where idPlanEstudio=".$idPlanEstudio;
		$x++;
		$query[$x]="delete from 4502_temarioMateria where idMateria in (select idMateria from 4502_Materias where idPlanEstudio=".$idPlanEstudio.")";
		$x++;
		$query[$x]="delete from 4502_Materias where idPlanEstudio=".$idPlanEstudio;
		$x++;
		$query[$x]="delete from 4503_secuenciaPlanEstudio where idPlanEstudio=".$idPlanEstudio;
		$x++;
		$query[$x]="delete from 4504_sedesPermitidas where idPlanEstudio=".$idPlanEstudio;
		$x++;
		$query[$x]="delete from 4505_estructuraCurricular where idPlanEstudio=".$idPlanEstudio;
		$x++;											 
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function obtenerSedesPrograma()
	{
		global $con;
		$idPrograma=$_POST["idPrograma"];
		$consulta="select o.codigoUnidad,o.unidad from 817_organigrama o,4504_sedesPermitidas p where o.codigoUnidad=p.sede and p.idPlanEstudio=".$idPrograma;
		$arrSedes=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrSedes).'}';
	}
	
	function obtenerUsuariosResponsablesSede()
	{
		global $con;
		$codigoInstitucion=$_POST["codigoInstitucion"];
		$consulta="SELECT p.idPlanEstudio,nombre,descripcion,cvePlanEstudio,cveRvoe FROM 4504_sedesPermitidas s,4500_planEstudio p WHERE p.idPlanEstudio=s.idPlanEstudio AND sede ='".$_SESSION["codigoInstitucion"]."' order by nombre";
		$res=$con->obtenerFilas($consulta);
		$arrNodos="";
		while($fila=mysql_fetch_row($res))
		{
			$objHijo='{icon:"../images/s.gif","descripcion":"'.cv($fila[2]).'","rvoe":"'.$fila[4].'","clave":"'.$fila[3].'",id:"p'.$fila[0].'",text:"'.cvJs($fila[1]).'",idInterno:"'.$fila[0].'",tipoNodo:"1",listeners:{ click:funcClikArbol},draggable:false,editable:true,checked:false';
			$hijos=obtenerResponsablesPlanesEstudio($fila[0],$_SESSION["codigoInstitucion"]);
			if($hijos=='[]')
				$objHijo.=',leaf:true}';
			else
				$objHijo.=',children:'.$hijos.'}';
			if($arrNodos=="")
				$arrNodos=$objHijo;
			else
				$arrNodos.=",".$objHijo;
		}
		echo "[".$arrNodos."]";
	}
	
	function obtenerResponsablesPlanesEstudio($idPlan,$sede)
	{
		global $con;
		$consulta="SELECT idResponsablePlanEstudio,u.Nombre,u.idUsuario FROM 4500_usuariosResponsablesPlanEstudio p,800_usuarios u WHERE  u.idUsuario=p.idUsuario AND p.idPlanEstudio=".$idPlan." AND p.plantel='".$sede."' order by Nombre";
		$res=$con->obtenerFilas($consulta);
		$arrNodos="";
		while($fila=mysql_fetch_row($res))
		{
			
			$consulta="select unidad from 817_organigrama o,801_adscripcion a WHERE o.codigoUnidad=a.codigoUnidad and a.idUsuario=".$fila[2];
			$plantel=$con->obtenerValor($consulta);
			if($plantel=="")
				$plantel="Sin adscripción";
			$objHijo='{id:"r'.$fila[0].'",text:"'.cvJs($fila[1]).' (<span style=\'color:#000033\'>'.cv($plantel).'</span>)",idInterno:"'.$fila[0].'",tipoNodo:"2",listeners:{ click:funcClikArbol},draggable:false,editable:true,checked:false';
			$objHijo.=',leaf:true,icon:"../images/user_gray.png"}';
			
			if($arrNodos=="")
				$arrNodos=$objHijo;
			else
				$arrNodos.=",".$objHijo;
		}
		return "[".$arrNodos."]";
		
	}
	
	function buscarEmpleado()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$campoB=$_POST["campoBusqueda"];
		$comp="";
		$plantel="";
		if(isset($_POST["plantel"]))
			$plantel=$_POST["plantel"];
		if($plantel!="")
				$comp=" and (a.codigoUnidad like '".$plantel."%' or a.codigoUnidad='".$plantel."' or a.Institucion='".$plantel."')";

		
		switch($campoB)
		{
			case "1": //Paterno
				$consulta="(select i.idUsuario,concat('[',i.idUsuario,'] <b>',Paterno,'</b>') as Paterno,Materno,Nom,Nombre,'' as Status,a.Institucion 
				from 802_identifica i,801_adscripcion a 
				where a.idUsuario=i.idUsuario ".$comp."  and  Paterno like '".$criterio."%'   order by Paterno,Materno,Nom asc)";
			break;
			case "2": //Materno
				$consulta=" (select i.idUsuario,concat('[',i.idUsuario,'] ',Paterno) as Paterno,concat('<b>',Materno,'</b>') as Materno,Nom,Nombre,'' as Status,a.Institucion
				from 802_identifica i,801_adscripcion a
				where a.idUsuario=i.idUsuario ".$comp." and  Materno like '".$criterio."%' order by Materno,Paterno,Nom asc)";
			break;
			case "3": //Nombre
				$consulta=" (select i.idUsuario,concat('[',i.idUsuario,'] ',Paterno) as Paterno, Materno,concat('<b>',Nom,'</b>') as Nom,Nombre,'' as Status,a.Institucion 
				from 802_identifica i,801_adscripcion a
				where a.idUsuario=i.idUsuario ".$comp." and Nom like '".$criterio."%' order by Nom,Paterno,Materno asc)";
			break;
		}
		$res=$con->obtenerFilas($consulta);
		$nUsuarios=$con->filasAfectadas;
		$arrDatos="";
		while($fila=mysql_fetch_row($res))
		{
			$situaciones="";
			$departamento="";
			$codigoDepto="";
			$consulta="select unidad from 817_organigrama o WHERE o.codigoUnidad='".$fila[6]."'";
			$plantel=$con->obtenerValor($consulta);
			if($plantel=="")
				$plantel="Sin adscripción";
			$obj='{"plantel":"'.$plantel.'","idUsuario":"'.$fila[0].'","Paterno":"'.$fila[1].'","Materno":"'.$fila[2].'","Nom":"'.$fila[3].'","Nombre":"'.$fila[4].'",
			"Status":"'.$situaciones.'","departamento":"'.$departamento.'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$obj='{"num":"'.$nUsuarios.'","personas":['.uDJ($arrDatos).']}';
		echo $obj;
	}
	
	function guardarResponsablePrograma()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$arrPlanes=explode(",",$obj->arrPlanes);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrPlanes as $plan)
		{
			$query="select idPlanEstudio from 4500_usuariosResponsablesPlanEstudio where idPlanEstudio=".$plan." and plantel='".$obj->plantel."' and idUsuario=".$obj->idUsuario;
			$fila=$con->obtenerPrimeraFila($query);
			if(!$fila)
			{
				$consulta[$x]="insert INTO 4500_usuariosResponsablesPlanEstudio(idPlanEstudio,plantel,idUsuario,creaInstancias) VALUES(".$plan.",'".$obj->plantel."',".$obj->idUsuario.",".$obj->creaInstancia.")";
				$x++;

			}
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function eliminarResponsablePrograma()
	{
		global $con;
		$idResponsable=$_POST["idResponsable"];

		$consulta="delete from 4500_usuariosResponsablesPlanEstudio where idResponsablePlanEstudio in (".$idResponsable.")";
		eC($consulta);
	}
	
	function eliminarGrado()
	{
		global $con;
		global $dic;
		$idGrado=$_POST["idGrado"];
		$leyendaError="";
		$consulta="SELECT leyendaGrado FROM 4501_Grado WHERE idGradoAnterior=".$idGrado;
		$leyenda=$con->obtenerValor($consulta);
		if($leyenda!="")
			$leyendaError.= $dic["grado"]["s"]["el"].' '.$dic["grado"]["s"]["et"].": <b>".$leyenda."</b> está haciendo referencia  a este registro como '".$dic["grado"]["s"]["et"]." anterior'<br>";
		$consulta="SELECT leyendaGrado FROM 4501_Grado WHERE idGradoSiguiente=".$idGrado;
		$leyenda=$con->obtenerValor($consulta);
		if($leyenda!="")
			$leyendaError.= $dic["grado"]["s"]["el"].' '.$dic["grado"]["s"]["et"].": <b>".$leyenda."</b> está haciendo referencia  a este registro como '".$dic["grado"]["s"]["et"]." siguiente'<br>";
		$consulta="SELECT idEstructuraCurricular FROM 4505_estructuraCurricular WHERE idUnidad=".$idGrado." AND tipoUnidad=3";
		$idEstructura=$con->obtenerValor($consulta);
		if($idEstructura!="")
			$leyendaError.= $dic["grado"]["s"]["el"].' '.$dic["grado"]["s"]["et"]." está alineado en ". $dic["estructuraCurricular"]["s"]["el"].' '.$dic["estructuraCurricular"]["s"]["et"]." de ".$dic["planEstudio"]["s"]["este"].' '.$dic["planEstudio"]["s"]["et"]."<br>";
		if($leyendaError=="")
		{
			$consulta="delete from 4501_Grado where idGrado=".$idGrado;
			eC($consulta);
		}
		else
			echo "<br>".$leyendaError;

	}
	
	function obtenerPlantelesPlanEstudio()
	{
		global $con;
		$idPlanEstudio=$_POST["idPlanEstudio"];
		$consulta="select o.codigoUnidad,o.unidad,p.idSedesPermitida from 817_organigrama o,4504_sedesPermitidas p where o.codigoUnidad=p.sede and p.idPlanEstudio=".$idPlanEstudio;
		$res=$con->obtenerFilas($consulta);
		$arrSedes="";
		while($fila=mysql_fetch_row($res))
		{
			$tblPersonas="<br><br><table><tr height='21'><td align='left' width='25'></td><td align='center' width='300'><span class='corpo8_bold'>Persona responsable</span></td><td align='center' width='300'><span class='corpo8_bold'>Adscripción</span></td><td align='center' width='270'><span class='corpo8_bold'>Puede Crear/Remover Instancias</span></td></tr><tr height='1'><td colspan='4' style='background-color:#900'></td></tr>";
			$consulta="SELECT idResponsablePlanEstudio,r.idUsuario,u.Nombre,r.creaInstancias FROM 4500_usuariosResponsablesPlanEstudio r,800_usuarios u WHERE u.idUsuario=r.idUsuario AND idPlanEstudio=".$idPlanEstudio." AND plantel='".$fila[0]."'";
			$resUsuario=$con->obtenerFilas($consulta);
			while($filaUsr=mysql_fetch_row($resUsuario))
			{
				$crearInstancias='Sí';
				if($filaUsr[3]==0)
					$crearInstancias="No";
				$consulta="select unidad from 817_organigrama o, 801_adscripcion a WHERE o.codigoUnidad=a.Institucion and idUsuario=".$filaUsr[1];
				$adscripcion=$con->obtenerValor($consulta);
				if($adscripcion=="")
					$adscripcion="Sin adscripción";
				$tblPersonas.="<tr height='21'><td align='left' ><a href='javascript:removerResponsable(&quot;".bE($filaUsr[0])."&quot;)'><img src='../images/delete.png' title='Remover responsable' alt='Remover responsable'></a></td><td align='left'><span class='letraExt'>".$filaUsr[2]."</span></td><td align='left'><span class='letraExt'>".$adscripcion."</span></td><td align='left'><span class='letraExt'>".$crearInstancias."</span></td></tr>";	
			}
			$tblPersonas.="</table>";
			$obj='{"idSedesPermitida":"'.$fila[2].'","codigoUnidad":"'.$fila[0].'","plantel":"'.$fila[1].'","personasPermitidas":"'.$tblPersonas.'"}';
			if($arrSedes=="")
				$arrSedes=$obj;
			else
				$arrSedes.=",".$obj;
		}
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$arrSedes.']}';
		
	}
	
	function agregarPlanEstudiosPlanteles()
	{
		global $con;
		$idPlanEstudio=$_POST["idPlanEstudio"];
		$cadPlanteles=$_POST["cadPlanteles"];
		$arrPlanteles=explode(",",$cadPlanteles);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrPlanteles as $plantel)
		{
			$consulta[$x]="INSERT INTO 4504_sedesPermitidas(idPlanEstudio,sede,fechaCreacion,responsableCreacion) VALUES(".$idPlanEstudio.",'".$plantel."','".date("Y-m-d")."',".$_SESSION["idUsr"].")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function removerPlanEstudiosPlanteles()
	{
		global $con;
		$idSedesPermitida=$_POST["idSedesPermitida"];
		$consulta="delete from 4504_sedesPermitidas where idSedesPermitida=".$idSedesPermitida;
		eC($consulta);
		
	}
	
	function guardarTemaMateria()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$codigoUnidad="";
		$orden="";
		$plantel="";
		if(isset($obj->plantel))
			$plantel=$obj->plantel;
		if($obj->idTema==-1)
		{
			$query="select max(codigoUnidad) from 4502_temarioMateria where idMateria=".$obj->idMateria." and codigoUnidadPadre='".$obj->codigoPadre."'";
			$maxCodigo=$con->obtenerValor($query);
			if($maxCodigo=="")
			{
				$codigoUnidad=$obj->codigoPadre."001";
				$orden=1;
			}
			else
			{
				$tamCodigo=strlen($maxCodigo)/3;
				$codigoUnidad=str_pad(($maxCodigo+1),(3*$tamCodigo),"0",STR_PAD_LEFT);
				$query="select max(orden) from 4502_temarioMateria where idMateria=".$obj->idMateria." and codigoUnidadPadre='".$obj->codigoPadre."'";
				$orden=$con->obtenerValor($query);
				$orden++;
			}
			$nivel=strlen($codigoUnidad)/3;	
			$consulta="insert into 4502_temarioMateria(idMateria,noTema,tema,descripcion,plantel,codigoUnidad,codigoUnidadPadre,situacion,nivel,orden) 
						VALUES(".$obj->idMateria.",'".cv($obj->noTema)."','".cv($obj->titulo)."','".cv($obj->descripcion)."','".$plantel."','".$codigoUnidad."','".$obj->codigoPadre."',".$obj->situacion.",".$nivel.",".$orden.")";
			
				
		}
		else
		{
			$consulta="update 4502_temarioMateria set noTema='".cv($obj->noTema)."',tema='".cv($obj->titulo)."',descripcion='".cv($obj->descripcion)."',situacion=".$obj->situacion." where idTemario=".$obj->idTema;
		}
		eC($consulta);
	}
	
	function obtenerTemarioMateria()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$arrTemas="";
		$plantel="";
		if(isset($_POST["plantel"]))
			$plantel=$_POST["plantel"];
		$comp=" and idStatus=1 and (plantel='' or plantel is null or plantel='".$plantel."')";
		$consulta="select idTemario,noTema,tema,descripcion,codigoUnidad,orden,s.nombreStatus,s.idStatus,plantel from 4502_temarioMateria t,4005_status s where  s.idStatus=t.situacion and idMateria=".$idMateria." and nivel=1 ".$comp." order by orden";
		$resMateria=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resMateria))
		{
			$plantel=$fila[8];
			$color="black";
			if($plantel!="")
			{
				$color="#900";
			}
			$obj='{id:"'.$fila[0].'",text:"<font color=\''.$color.'\'>'.cv($fila[1]).'.- '.cv($fila[2]).'</font>",plantel:"'.$plantel.'",noTema:"'.cv($fila[1]).'",tema:"'.cv($fila[2]).'",qtip :"'.cv($fila[3]).'",descripcion:"'.cv($fila[3]).'",codigoUnidad:"'.cv($fila[4]).'",idSituacion:"'.$fila[7].'",situacion:"'.$fila[6].'",orden:"'.cv($fila[5]).'",uiProvider:"col"';
			$hijos=obtenerTemasHijos($idMateria,$fila[4],$comp);																								  
			if($hijos=='')
				$obj.=',leaf:true,icon:"../images/bullet_green.png"}';
			else
				$obj.=',children:['.$hijos.'],icon:"../images/bullet_green.png"}';
			if($arrTemas=="")
				$arrTemas=$obj;
			else
				$arrTemas.=",".$obj;
		}
		echo "[".$arrTemas."]";
	}
	
	function obtenerTemasHijos($idMateria,$codPadre,$comp)
	{
		global $con;
		$arrTemas="";
		$consulta="select idTemario,noTema,tema,descripcion,codigoUnidad,orden,s.nombreStatus,s.idStatus,plantel  from 4502_temarioMateria t,4005_status s where  s.idStatus=t.situacion and idMateria=".$idMateria." and codigoUnidadPadre='".$codPadre."' ".$comp." order by orden";
		$resMateria=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resMateria))
		{
			$plantel=$fila[8];
			$color="black";
			if($plantel!="")
			{
				$color="#900";
			}
			$obj='{id:"'.$fila[0].'",text:"<font color=\''.$color.'\'>'.$fila[1].'.- '.cv($fila[2]).'</font>",plantel:"'.$plantel.'",noTema:"'.cv($fila[1]).'",tema:"'.cv($fila[2]).'",qtip :"'.cv($fila[3]).'",descripcion:"'.cv($fila[3]).'",codigoUnidad:"'.cv($fila[4]).'",idSituacion:"'.$fila[7].'",situacion:"'.$fila[6].'",orden:"'.cv($fila[5]).'",uiProvider:"col"';
			$hijos=obtenerTemasHijos($idMateria,$fila[4],$comp);																								  
			if($hijos=='')
				$obj.=',leaf:true,icon:"../images/bullet_green.png"}';
			else
				$obj.=',children:['.$hijos.'],icon:"../images/bullet_green.png"}';
			if($arrTemas=="")
				$arrTemas=$obj;
			else
				$arrTemas.=",".$obj;
		}
		return $arrTemas;
	}
	
	function removerTema()
	{
		global $con;
		$idTema=$_POST["idTema"];
		$query="select codigoUnidad,idMateria,orden,codigoUnidadPadre from 4502_temarioMateria where idTemario=".$idTema;
		$fila=$con->obtenerPrimeraFila($query);
		$codigoUnidad=$fila[0];
		$idMateria=$fila[1];
		$eliminable=true;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($eliminable)
		{
			$consulta[$x]="delete from 4502_temarioMateria where idMateria=".$idMateria." and (codigoUnidad='".$codigoUnidad."' or codigoUnidadPadre like '".$codigoUnidad."%')";
			$x++;
			$consulta[$x]="update 4502_temarioMateria set orden=orden-1 where idMateria=".$idMateria." and codigoUnidadPadre ='".$fila[3]."' and orden>".$fila[2];
		}
		else
			$consulta[$x]="update 4502_temarioMateria set situacion=0 where idMateria=".$idMateria." and (codigoUnidad='".$codigoUnidad."' or codigoUnidadPadre like '".$codigoUnidad."%')";
		$x++;
		$consulta[$x]="begin";
		$x++;
		eB($consulta);
	}
	
	function obtenerMateriasParaRequisitoMateria()
	{
		global $con;
		$condWhere=" 1=1 "; 
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$idMateria=$_POST["idMateria"];
		$consulta="select idMateriaRequisito from 4511_seriacionMateria where idMateria=".$idMateria;
		$listMateria=$con->obtenerListaValores($consulta);
		if($listMateria=="")
			$listMateria="-1";
		$consulta="select idPlanEstudio from 4502_Materias where idMateria=".$idMateria;
		$idPlanEstudio=$con->obtenerValor($consulta);
		$consulta="select idMateria,cveMateria,nombreMateria,descripcion from 4502_Materias where idPlanEstudio=".$idPlanEstudio." 
					and idMateria not in (".$listMateria.") and idMateria<>".$idMateria." and ".$condWhere;
		$arrMateria=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrMateria).'}';
	}
		
	function guardarRequisitosMateria()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$materias=$_POST["materias"];
		$tipoRequisito=$_POST["tipoRequisito"];
		$arrMaterias=explode(",",$materias);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrMaterias as $materia)
		{
			$consulta[$x]="INSERT INTO 4511_seriacionMateria(idMateria,idMateriaRequisito,tipoRequisito) VALUES(".$idMateria.",".$materia.",".$tipoRequisito.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
			
	}
	
	function obtenerPlanEstudioPredecesor()
	{
		global $con;
		$condWhere=" 1=1 "; 
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$idPlanEstudio=$_POST["idPlanEstudio"];
		$consulta="select idPlanEstudioAntecede from 4503_secuenciaPlanEstudio where idPlanEstudio=".$idPlanEstudio;
		$list=$con->obtenerListaValores($consulta);
		if($list=="")
			$list="-1";
		$consulta="select codigoInstitucion from 4500_planEstudio where idPlanEstudio=".$idPlanEstudio;
		$codigoInstitucion=$con->obtenerValor($consulta);
		$idPlanEstudio=$con->obtenerValor($consulta);
		$consulta="select idPlanEstudio,cvePlanEstudio,cveRvoe,nombre from 4500_planEstudio where 
					idPlanEstudio not in (".$list.") and codigoInstitucion='".$codigoInstitucion."' and ".$condWhere. " order by nombre";
		$arrMateria=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrMateria).'}';
	}
	
	function guardarPlanesEstudioPredecesores()
	{
		global $con;
		$idPlanEstudio=$_POST["idPlanEstudio"];
		$planesEstudio=$_POST["planesEstudio"];
		$arrPlanes=explode(",",$planesEstudio);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrPlanes as $plan)
		{
			$consulta[$x]="INSERT INTO 4503_secuenciaPlanEstudio(idPlanEstudio,idPlanEstudioAntecede) VALUES(".$idPlanEstudio.",".$plan.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerEstructuraCurricular()
	{
		global $con;
		global $dic;
		$arrTemas="";
		$idPlanEstudio=$_POST["idPlanEstudio"];
		$tUnidad=$dic["grado"]["s"]["et"];
		$consulta="SELECT idEstructuraCurricular,g.leyendaGrado,descripcion,codigoUnidad,maxOPC,minOPC FROM 4505_estructuraCurricular e, 4501_Grado g WHERE g.idGrado=e.idUnidad AND e.idPlanEstudio=".$idPlanEstudio." and nivel=1 AND tipoUnidad=3 ORDER BY  ordenGrado";
		$resMateria=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resMateria))
		{
			$obj='{expanded:true,clave:"",codigoUnidad:"'.$fila[3].'",id:"'.$fila[0].'",descripcion:"",nUnidad:"'.cv($fila[1]).
				'",text:"<span style=\'color:#030\'><b>'.cv($fila[1]).'</b></span>",tipoUnidad:"'.$tUnidad.'",tUnidad:"3",naturaleza:"",idNaturaleza:"",noCreditos:"N/A",totalHoras:"",horasTSemana:"",horasPSemana:"",horasISemana:"",maxOPC:"'.$fila[4].'",minOPC:"'.$fila[5].'"';
			$hijos=obtenerMateriasHijos($idPlanEstudio,$fila[3]);				

			if($hijos=='[]')
				$obj.=',leaf:true,icon:"../images/table_row_insert.png"}';
			else
				$obj.=',children:'.$hijos.',icon:"../images/table_row_insert.png"}';
			if($arrTemas=="")
				$arrTemas=$obj;
			else
				$arrTemas.=",".$obj;
		}
		echo "[".$arrTemas."]";
	}
	
	function obtenerMateriasHijos($idPlanEstudio,$codigoPadre)
	{
		global $con;
		global $dic;
		$tUnidad="";
		$arrTemas="";
		$consulta="select * from (
				SELECT idEstructuraCurricular,tipoUnidad,n.abreviatura,e.naturalezaMateria,codigoUnidad,
				(if(tipoUnidad=1,(select nombreMateria FROM 4502_Materias WHERE idMateria=e.idUnidad),
				(select nombreUnidad from 4508_unidadesContenedora where idUnidadContenedora=e.idUnidad))) as nombreUnidad,
				maxOPC,minOPC ,e.idUnidad,
				if(tipoUnidad=1,(select cveMateria FROM 4502_Materias WHERE idMateria=e.idUnidad),'') as clave,
				if(tipoUnidad=1,
					(select idCategoriaMateria FROM 4502_Materias WHERE idMateria=e.idUnidad),
					(select idCategoria FROM 4508_unidadesContenedora WHERE idUnidadContenedora=e.idUnidad)
				) as idCategoria 
				FROM 4505_estructuraCurricular e,4507_naturalezaMateria n 
				WHERE n.idNaturalezaMateria=e.naturalezaMateria and e.idPlanEstudio=".$idPlanEstudio." and codigoPadre='".$codigoPadre."') as tmp   order by idCategoria,clave";
		$resMateria=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resMateria))
		{
			$noCreditos="";
			$totalHoras="";
			$horasTSemana="";
			$horasPSemana="";
			$horasISemana="";
			$horasSemanales="";
			$icono="s.gif";
			$descripcion="";
			$color="";
			$tipoUnidadC="";
			$comp="";
			if($fila[1]==1)
			{
				$tUnidad=$dic["materia"]["s"]["et"];
				$consulta="SELECT numeroCredito,horaMateriaTotal,horasTeoricasSemanal,horasPracticasSemanal,horasIndependientes,horasSemana,idCategoriaMateria FROM 4502_Materias WHERE idMateria=".$fila[8];
				$filaMat=$con->obtenerPrimeraFila($consulta);
				$noCreditos=$filaMat[0];
				$totalHoras=$filaMat[1];
				$horasTSemana=$filaMat[2];
				$horasPSemana=$filaMat[3];
				$horasISemana=$filaMat[4];
				$horasSemanales=$filaMat[5];
				$icono="text_lowercase.png";
				$color="003";
				$idCategoria=$filaMat[6];
				$consulta="SELECT color FROM 4502_categoriaMaterias WHERE idCategoria=".$idCategoria;
				$colorFondo=$con->obtenerValor($consulta);
				$comp="<span style='width:30px;height:14px;background-color:#".$colorFondo."'>&nbsp;&nbsp;&nbsp;</span>";
			}
			else
			{
				
				$tUnidad="Unidad contenedora";
				$consulta="select descripcion,tipoUnidad,idCategoria from 4508_unidadesContenedora where idUnidadContenedora=".$fila[8];
				$fUnidad=$con->obtenerPrimeraFila($consulta);
				$descripcion=$fUnidad[0];
				$tipoUnidadC=$fUnidad[1];
				if($tipoUnidadC==1)
					$tUnidad="Unidad Agrupadora";
				$color="000";
				$icono="Icono_3d.gif";
				$idCategoria=$fUnidad[2];
				$consulta="SELECT color FROM 4502_categoriaMaterias WHERE idCategoria=".$idCategoria;
				$colorFondo=$con->obtenerValor($consulta);
				$comp="<span style='width:30px;height:14px;background-color:#".$colorFondo."'>&nbsp;&nbsp;&nbsp;</span>";
			}
			$obj='{"idCategoria":"'.$idCategoria.'",tipoUnidadC:"'.$tipoUnidadC.'",clave:"'.cv($fila[9]).'",codigoUnidad:"'.$fila[4].'",id:"'.$fila[0].'",nUnidad:"'.cv($fila[5]).'",descripcion:"'.cv($descripcion).
					'",text:"'.$comp.' <span style=\'color:#'.$color.'\'><b>'.cv($fila[5]).'</b></span>",tipoUnidad:"'.$tUnidad.'",tUnidad:"'.$fila[1].'",naturaleza:"'.$fila[2].'",idNaturaleza:"'.$fila[3].'",noCreditos:"'.$noCreditos.
					'",totalHoras:"'.$totalHoras.'",horasTSemana:"'.$horasTSemana.'",horasPSemana:"'.$horasPSemana.'",horasISemana:"'.$horasISemana.'",horasSemanales:"'.$horasSemanales.'",maxOPC:"'.$fila[6].'",minOPC:"'.$fila[7].'"';
			$hijos=obtenerMateriasHijos($idPlanEstudio,$fila[4]);																								  
			if($hijos=='[]')
				$obj.=',leaf:true,icon:"../images/'.$icono.'"}';
			else
				$obj.=',children:'.$hijos.',icon:"../images/'.$icono.'"}';
			if($arrTemas=="")
				$arrTemas=$obj;
			else
				$arrTemas.=",".$obj;
		}
		return "[".$arrTemas."]";
	}
	
	function obtenerGradosDisponiblesEstructuraCurricular()
	{
		global $con;
		$idPlanEstudio=$_POST["idPlanEstudio"];
		$consulta="SELECT idUnidad FROM 4505_estructuraCurricular WHERE idPlanEstudio=".$idPlanEstudio." AND tipoUnidad=3";
		$listUnidad=$con->obtenerListaValores($consulta);
		if($listUnidad=="")
			$listUnidad="-1";
		$consulta="select idGrado,leyendaGrado,descripcion,ordenGrado from 4501_Grado where idPlanEstudio=".$idPlanEstudio." and idGrado not in (".$listUnidad.")";
		$arrGrados=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrGrados).'}';
		
	}
	
	function agregarElementoEstructuraCurricular()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$tamCodigo="";
		$codigoPadre=$obj->codigoPadre;
		$comp="";
		if($codigoPadre=="")
			$comp=" or codigoPadre is null";
		$query="select max(codigoUnidad) from 4505_estructuraCurricular where idPlanEstudio=".$obj->idPlanEstudio." and (codigoPadre='".$codigoPadre."' ".$comp.")";
		
		$maxValor=$con->obtenerValor($query);
		if($maxValor=="")
		{
			$codigoIndividual=$codigoPadre."001";
			$tamCodigo=strlen($codigoIndividual)/3;
		}
		else
		{
			
			$tamCodigo=strlen($maxValor)/3;
			$arrTam=explode(".",$tamCodigo);
			$tamCodigo=$arrTam[0];
			if(sizeof($arrTam)>1)
			{
				if($arrTam[1]>0)
					$tamCodigo++;
			}
			$codigoIndividual=str_pad(($maxValor*1)+1,(3*$tamCodigo),"0",STR_PAD_LEFT);
		}
		
		$x=0;
		
		$consulta[$x]="begin";
		$x++;
		if($obj->tipoUnidad!=2)
		{
			$lista=explode(",",$obj->lista);
			foreach($lista as $elemento)
			{
				
				$codigoUnidad=str_pad($codigoIndividual,(3*$tamCodigo),"0",STR_PAD_LEFT);
				$nivel=strlen($codigoUnidad)/3;
				$consulta[$x]="INSERT INTO 4505_estructuraCurricular(idPlanEstudio,idUnidad,tipoUnidad,codigoPadre,codigoUnidad,naturalezaMateria,nivel,fechaCreacion,responsableCreacion,minOPC,maxOPC) 
								VALUES(".$obj->idPlanEstudio.",".$elemento.",".$obj->tipoUnidad.",'".$codigoPadre."','".$codigoUnidad."',".$obj->naturaleza.",".$nivel.",'".date("Y-m-d").
								"',".$_SESSION["idUsr"].",".$obj->minimoOpC.",".$obj->maximoOpC.")";
				
				$x++;
				
				$query="SELECT idInstanciaPlanEstudio,sede FROM 4513_instanciaPlanEstudio WHERE idPlanEstudio=".$obj->idPlanEstudio;
				$res=$con->obtenerFilas($query);
				while($fila=mysql_fetch_row($res))
				{
					$query="SELECT cveMateria,horasSemana FROM 4502_Materias WHERE idMateria=".$elemento;
					$fMateria=$con->obtenerPrimeraFila($query);
					if($fMateria[1]=="")
						$fMateria[1]=0;
					$query="INSERT INTO 4512_aliasClavesMateria(idInstanciaPlanEstudio,idMateria,sede,cveMateria,noHorasSemana) 
								VALUES(".$fila[0].",".$elemento.",'".$fila[1]."','".$fMateria[0]."',".$fMateria[1].")";
					if($con->ejecutarConsulta($query))
					{
						$query="SELECT idGrupoPadre,idCiclo,idPeriodo FROM 4540_gruposMaestros WHERE idInstanciaPlanEstudio=".$fila[0]." AND codigoGrado='".substr($codigoPadre,0,3)."'";
						
						$resGruposPadre=$con->obtenerFilas($query);
						while($filaGrupo=mysql_fetch_row($resGruposPadre))
						{

							$idMateriaAgrupadora=obtenerIdElementoEstructuraUnidadAgrupadora($obj->idPlanEstudio,$codigoUnidad);

							$idGrupoAgrupadora=0;
							if($idMateriaAgrupadora!=-1)
							{
								$query="SELECT idGrupos FROM 4520_grupos WHERE idMateria=-".$idMateriaAgrupadora." AND 
											idInstanciaPlanEstudio=".$fila[0]." AND idCiclo=".$filaGrupo[1]." AND idPeriodo=".$filaGrupo[2];
								$idGrupoAgrupadora=$con->obtenerValor($query);
								if($idGrupoAgrupadora=="")
									$idGrupoAgrupadora=0;
							}
							crearGrupoMateriaUnica($fila[0],$elemento,$filaGrupo[0],"NULL","NULL",$idGrupoAgrupadora);
						}
					}
					else
					{
						$query="rollback";
						return $con->ejecutarConsulta($query);
					}
				}
				$codigoIndividual=($codigoIndividual*1)+1;
			}
			$query="SELECT idInstanciaPlanEstudio,sede FROM 4513_instanciaPlanEstudio WHERE idPlanEstudio=".$obj->idPlanEstudio;
			$res=$con->obtenerFilas($query);
			while($fila=mysql_fetch_row($res))
			{
				$query="SELECT cveMateria,horasSemana FROM 4502_Materias WHERE idMateria=".$elemento;
				$fMateria=$con->obtenerPrimeraFila($query);
				if($fMateria[1]=="")
						$fMateria[1]=0;
				$query="INSERT INTO 4512_aliasClavesMateria(idInstanciaPlanEstudio,idMateria,sede,cveMateria,noHorasSemana) 
							VALUES(".$fila[0].",".$elemento.",'".$fila[1]."','".$fMateria[0]."',".$fMateria[1].")";
				if($con->ejecutarConsulta($query))
				{
					$query="SELECT idGrupoPadre FROM 4540_gruposMaestros WHERE idInstanciaPlanEstudio=".$fila[0]." AND codigoGrado='".substr($codigoPadre,0,3)."'";
					$resGruposPadre=$con->obtenerFilas($query);
					while($filaGrupo=mysql_fetch_row($resGruposPadre))
					{
						crearGrupoMateriaUnica($fila[0],$elemento,$filaGrupo[0]);
					}
				}
				else
				{
					$query="rollback";
					return $con->ejecutarConsulta($query);
				}
			}
			
		}
		else
		{
			$consulta[$x]="insert into 4508_unidadesContenedora(nombreUnidad,descripcion,idPlanEstudio,tipoUnidad,idCategoria) 
							VALUES('".cv($obj->nombreUnidad)."','".cv($obj->descripcion)."',".$obj->idPlanEstudio.",".$obj->tipoUnidadCont.",".$obj->idCategoria.")";
			$x++;
			$consulta[$x]="set @idUnidadContenedora:=(select last_insert_id())";
			$x++;
			$codigoUnidad=$codigoIndividual;
			$nivel=strlen($codigoUnidad)/3;
			$consulta[$x]="INSERT INTO 4505_estructuraCurricular(idPlanEstudio,idUnidad,tipoUnidad,codigoPadre,codigoUnidad,naturalezaMateria,nivel,fechaCreacion,responsableCreacion,minOPC,maxOPC) 
							VALUES(".$obj->idPlanEstudio.",(select last_insert_id()),".$obj->tipoUnidad.",'".$codigoPadre."','".$codigoUnidad."',".$obj->naturaleza.",".$nivel.",'".date("Y-m-d")."',".$_SESSION["idUsr"].",".$obj->minimoOpC.",".$obj->maximoOpC.")";
			$x++;
			
			if($obj->tipoUnidadCont==1)
			{
				$query="SELECT idInstanciaPlanEstudio,sede FROM 4513_instanciaPlanEstudio WHERE idPlanEstudio=".$obj->idPlanEstudio;
				$res=$con->obtenerFilas($query);
				while($fila=mysql_fetch_row($res))
				{
					$query="SELECT idGrupoPadre,idCiclo,idPeriodo FROM 4540_gruposMaestros WHERE idInstanciaPlanEstudio=".$fila[0]." AND codigoGrado='".substr($codigoPadre,0,3)."'";
					$resGruposPadre=$con->obtenerFilas($query);
					while($filaGrupo=mysql_fetch_row($resGruposPadre))
					{
						$query="select * from 4540_gruposMaestros where idGrupoPadre=".$filaGrupo[0];
						$filaGpo=$con->obtenerPrimeraFila($query);
						
						$fechaInicio="NULL";
						$fechaFin="NULL";
						$query="SELECT fechaInicial,fechaFinal FROM 4544_fechasPeriodo WHERE idCiclo=".$filaGrupo[1]." and idPeriodo=".$filaGrupo[2]." and idInstanciaPlanEstudio='".$fila[0]."'";
						$fFechas=$con->obtenerPrimeraFila($query);
						if(($fFechas)&&($fFechas[0]!=""))
						{
							$fechaInicio="'".$fFechas[0]."'";
						}
						
						
						if($fFechas[1]!="")	
							$fechaFin="'".$fFechas[1]."'";
						else
							$fechaFin="NULL";
						$nGrupo=$obj->nombreUnidad."-1 [".$filaGpo[1]."]";
						
						$queryGpoMaestro="SELECT idGradoCiclo FROM 4540_gruposMaestros WHERE idGrupoPadre=".$filaGpo[0];
						$idGradoCiclo=$con->obtenerValor($queryGpoMaestro);	
						
						$consulta[$x]="insert into 4520_grupos(idPlanEstudio,Plantel,idMateria,nombreGrupo,cupoMinimo,cupoMaximo,situacion,idCiclo,idInstanciaPlanEstudio,idGrupoPadre,fechaInicio,fechaFin,idPeriodo,idGrupoAgrupador,idGradoCiclo)
								VALUES(".$fila[0].",'".$fila[1]."',(@idUnidadContenedora*-1),'".cv($nGrupo)."',".$filaGpo[4].",".$filaGpo[5].",".$filaGpo[2].",".$filaGpo[6].
								",".$filaGpo[3].",".$filaGpo[0].",".$fechaInicio.",".$fechaFin.",".$filaGpo[7].",0,".$idGradoCiclo.")";
						
						$x++;
					}
				}
			}
		}
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
	}
	
	function modificarUnidadEstructuraCurricular()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		switch($obj->tipoUnidad)
		{
			case 1:
				$consulta[$x]="update 4505_estructuraCurricular set naturalezaMateria=".$obj->naturaleza.",minOPC=".$obj->minimoOpC.",maxOPC=".$obj->maximoOpC." where idEstructuraCurricular=".$obj->idEstructuraCurricular;
				$x++;
			break;
			case 2:
				$consulta[$x]="update 4505_estructuraCurricular set naturalezaMateria=".$obj->naturaleza.",minOPC=".$obj->minimoOpC.",maxOPC=".$obj->maximoOpC." where idEstructuraCurricular=".$obj->idEstructuraCurricular;
				$x++;
				$query="select idUnidad from 4505_estructuraCurricular where idEstructuraCurricular=".$obj->idEstructuraCurricular;
				$idUnidad=$con->obtenerValor($query);
				$consulta[$x]="update 4508_unidadesContenedora set nombreUnidad='".cv($obj->nombreUnidad)."',descripcion='".cv($obj->descripcion)."',tipoUnidad=".$obj->tipoUnidadCont.",idCategoria=".$obj->idCategoria.
							" where idUnidadContenedora=".$idUnidad;
				$x++;
			break;
			case 3:
				$consulta[$x]="update 4505_estructuraCurricular set minOPC=".$obj->minimoOpC.",maxOPC=".$obj->maximoOpC." where idEstructuraCurricular=".$obj->idEstructuraCurricular;
				$x++;
			break;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function eliminarUnidadEstructuraCurricular()
	{
		global $con;
		global $dic;
		$idUnidadEstructura=$_POST["idUnidadEstructura"];
		$x=0;

		$consulta[$x]="begin";
		$x++;
		$query="select codigoUnidad,idPlanEstudio,tipoUnidad,idUnidad from 4505_estructuraCurricular where idEstructuraCurricular=".$idUnidadEstructura;
		$filaUnidad=$con->obtenerPrimeraFila($query);
		$query="select idGrupos from 4520_grupos WHERE idMateria=".$filaUnidad[3];
		
		$listGrupos=$con->obtenerListaValores($query);
		if($listGrupos!="")
		{
			$query="SELECT COUNT(*) FROM 4522_horarioGrupo WHERE idGrupo IN (".$listGrupos.")";
			$nHorarios=$con->obtenerValor($query);
			if($nHorarios>0)
			{
				echo "<br>Ya existen ".strtolower($dic["grupo"]["p"]["et"])." asociados a ".strtolower($dic["materia"]["s"]["el"]." ".$dic["materia"]["s"]["et"])." con horario asignado";
				return;
			}
			
		}
		$consulta[$x]="delete from 4505_estructuraCurricular where idEstructuraCurricular=".$idUnidadEstructura;
		$x++;
		$consulta[$x]="delete from 4505_estructuraCurricular where codigoUnidad like '".$filaUnidad[0]."%' and idPlanEstudio=".$filaUnidad[1];
		$x++;
		if($filaUnidad[2]==1)
		{
			$consulta[$x]="delete from 4520_grupos WHERE idMateria=".$filaUnidad[3];
			$x++;
			$consulta[$x]="delete from 4512_aliasClavesMateria WHERE idMateria=".$filaUnidad[3];
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerMateriasDisponiblesEstructuraCurricular()
	{
		global $con;
		
		$todasMaterias=$_POST["todasMaterias"];
		
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		$idPlanEstudio=$_POST["idPlanEstudio"];
		$consulta="SELECT idUnidad FROM 4505_estructuraCurricular WHERE  idPlanEstudio=".$idPlanEstudio." AND tipoUnidad=1";
		$listMat=$con->obtenerListaValores($consulta);
		if($listMat=="")
			$listMat="-1";
		$consulta="SELECT idMateria,nombreMateria,descripcion,cveMateria FROM 4502_Materias WHERE idPlanEstudio=".$idPlanEstudio." AND situacion=1 and ".$cadCondWhere;
		if($todasMaterias==0)
		{
			$consulta.=" AND idMateria NOT IN (".$listMat.")";
		}
		$arrObj=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrObj).'}';
	}
	
	function obtenerProgramasPlantel()
	{
		global $con;
		$mostrarInactivos=false;
		if((isset($_POST["chkInactivos"]))&&($_POST["chkInactivos"]==1))
			$mostrarInactivos=true;
		$comp="";
		$sede=$_POST["s"];
		if(isset($_POST["nivelAcademico"]))
		{
			$nivelAcademico=$_POST["nivelAcademico"];
			if($nivelAcademico!=0)
				$comp=" and nivelPlanEstudio=".$nivelAcademico;
		}
		$idUsuario=bD($_POST["iU"]);
		$condicion="";
		if($idUsuario!=0)
		{
				$condicion="and i.idPlanEstudio in (SELECT idPlanEstudio  FROM 4500_usuariosResponsablesPlanEstudio WHERE idUsuario=".$idUsuario." 
								 AND plantel='".$sede."' )";
		}
		
		$filtroActivos=" and i.situacion=1";
		if($mostrarInactivos)
			$filtroActivos="";
		
		$orden=$_POST["sort"];
		$dir=$_POST["dir"];
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		$consulta="select distinct * from (SELECT i.idInstanciaPlanEstudio,i.nombrePlanEstudios as nombre,i.cveRvoe,i.fechaRvoe,p.descripcion,s.nombreStatus,
				i.cvePlanEstudio,p.nombre as planEstudiosBase,t.turno,m.nombre as modalidad,per.txtDescripcion,(SELECT COUNT(*) FROM 4512_aliasClavesMateria WHERE idInstanciaPlanEstudio=i.idInstanciaPlanEstudio AND cambioNoHoras<>0)as comp,
				p.idProgramaEducativo,p.AreaEspecialidad,p.nivelPlanEstudio,pr.nombreProgramaEducativo as nombreProgramaEducativo,p.idPlanEstudio
		FROM 4500_planEstudio p,4005_status s,4513_instanciaPlanEstudio i,4516_turnos t,4514_tipoModalidad m,_464_tablaDinamica per,4500_programasEducativos pr
		 WHERE t.idTurno=i.idTurno and m.idModalidad=i.idModalidad and i.idPlanEstudio=p.idPlanEstudio and i.sede='".$sede."' and pr.idProgramaEducativo=p.idProgramaEducativo and 
		 s.idStatus=i.situacion  and  per.id__464_tablaDinamica=i.idPeriodicidad ".$condicion." ".$filtroActivos."
		 ) as tmp where ".$cadCondWhere." ".$comp." ORDER BY  ".$orden." ".$dir;

		$arrProgramas=$con->obtenerFilasJson($consulta);
		$nFilas=$con->filasAfectadas;
		echo '{"nuReg":"'.$nFilas.'","registros":'.utf8_encode($arrProgramas).'}';
	}
	
	function eliminarMateria()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$leyendaError="";
		if($leyendaError=="")
		{
			$consulta="delete from 4502_Materias where idMateria=".$idMateria;
			eC($consulta);
		}
		else
			echo "<br>".$leyendaError;
	}
	
	function obtenerFechasCiclo()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$plantel="";
		if(isset($_POST["plantel"]))
			$plantel=$_POST["plantel"];
		$consulta="SELECT idFechaCalendario as idFecha,descripcion AS leyenda,fechaInicio,fechaFin as fechaTermino,(select unidad from 817_organigrama where codigoUnidad=f.plantel) as plantel,
					afectaClases,afectaPago FROM  4525_fechaCalendarioDiaHabil f WHERE idCiclo=".$idCiclo;
		if($plantel!="")
			$consulta.=" and (plantel='".$plantel."' or plantel='')";		
		$arrObj="";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$o='{"tipo":"1","idFecha":'.$fila[0].',"leyenda":"'.cv($fila[1]).'","fechaInicio":"'.$fila[2].'","fechaTermino":"'.$fila[3].'","plantel":"'.$fila[4].'","afectaClases":"","afectaPago":"","pagadoProfesor":"","_parent":null,"_is_leaf":false}';
			$consulta="SELECT codigoUnidad,unidad FROM 817_organigrama o,4525_plantelesDiasFestivos p WHERE o.codigoUnidad=p.plantel ORDER BY unidad";
			$resPlantel=$con->obtenerFilas($consulta);
			while($fPlantel=mysql_fetch_row($resPlantel))
			{
				$o.=',{"tipo":"2","idFecha":"'.$fPlantel[0].'","leyenda":"'.cv($fPlantel[1]).'","fechaInicio":"'.$fila[2].'","fechaTermino":"'.$fila[3].'","plantel":"'.$fila[4].'","afectaClases":"","afectaPago":"","pagadoProfesor":"","_parent":'.$fila[0].
						',"_is_leaf":true}';
			}
			if($arrObj=="")
				$arrObj=$o;
			else
				$arrObj.=",".$o;
		}
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.($arrObj).']}';
		
	}
	
	function guardarFechaNoHabil()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$plantel="";
		if(isset($obj->plantel))
			$plantel=$obj->plantel;
		if($obj->idFecha==-1)
			$consulta="INSERT INTO 4525_fechaCalendarioDiaHabil(idCiclo,fechaInicio,fechaFin,plantel,descripcion,afectaClases,afectaPago) 
						VALUES(".$obj->idCiclo.",'".$obj->fechaInicio."','".$obj->fechaTermino."','".$plantel."','".cv($obj->leyenda)."',".$obj->afectaClases.",".$obj->afectaPago.")";
		else
			$consulta="update 4525_fechaCalendarioDiaHabil set afectaClases=".$obj->afectaClases.",afectaPago=".$obj->afectaPago.", fechaInicio='".$obj->fechaInicio."',
					fechaFin='".$obj->fechaTermino."',descripcion='".cv($obj->leyenda)."' where idFechaCalendario=".$obj->idFecha;
			
		if($con->ejecutarConsulta($consulta))
		{
			
			if($obj->recalcularFechas==0)
			{
				echo "1|";
				return;
			}
			if($plantel!="")
			{
				if(!recalcularFechasPlantel($plantel,$obj->fechaInicio,$obj->fechaTermino))
					return;
			}
			else
			{
				$consulta="SELECT codigoUnidad FROM 817_organigrama WHERE institucion=1 AND codigoUnidad <>'0001' AND instColaboradora=0";
				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					$plantel=$fila[0];
					if(!recalcularFechasPlantel($plantel,$obj->fechaInicio,$obj->fechaTermino))
						return;
				}
			}
			echo "1|";
		}
	}
	
	function removerFecha()
	{
		global $con;
		$idFecha=$_POST["idFecha"];
		$consulta="SELECT plantel,fechaInicio,fechaFin FROM 4525_fechaCalendarioDiaHabil WHERE idFechaCalendario=".$idFecha;
		$fDatos=$con->obtenerPrimeraFila($consulta);
		$plantel=$fDatos[0];
		
		$consulta="delete from 4525_fechaCalendarioDiaHabil where idFechaCalendario=".$idFecha;
		if($con->ejecutarConsulta($consulta))
		{
			if($plantel!="")
			{
				if(!recalcularFechasPlantel($plantel,$fDatos[1],$fDatos[2]))
					return;
			}
			else
			{
				$consulta="SELECT codigoUnidad FROM 817_organigrama WHERE institucion=1 AND codigoUnidad <>'0001' AND instColaboradora=0";
				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					$plantel=$fila[0];
					if(!recalcularFechasPlantel($plantel,$fDatos[1],$fDatos[2]))
						return;
				}
			}
			echo "1|";
		}
		
	}
	
	function obtenerMateriasProfesor()
	{
		global $con;
		global $mostrarEnVistaMateriasTipoCriterioEval;
		global $urlSitio;
		
		$llaveSitio=generarLlaveSitio();
		
		$existeFuncionSitio=function_exists("gruposVisiblesProfesor_".$llaveSitio);
		
		$ignorarSituacion=false;
		$idUsuario=$_POST["idUsuario"];
		$ciclo=$_POST["idCiclo"];
		$vista=$_POST["vista"];
		$idPeriodo=$_POST["idPeriodo"];
		if(!isset($_POST["vAlumno"]))
		{
			
			$consulta="SELECT DISTINCT g.idInstanciaPlanEstudio,Plantel,o.unidad,i.nombrePlanEstudios FROM 4520_grupos g,4519_asignacionProfesorGrupo a,817_organigrama o,4513_instanciaPlanEstudio i 
						WHERE idCiclo=".$ciclo." and g.idPeriodo=".$idPeriodo." AND a.idGrupo=g.idGrupos AND a.idUsuario=".$idUsuario."  AND  o.codigoUnidad=g.Plantel AND i.idInstanciaPlanEstudio=g.idInstanciaPlanEstudio
						and a.fechaAsignacion<=a.fechaBaja";

			$resProg=$con->obtenerFilas($consulta);
			$arrNodos="";
			

			while($filasProg=mysql_fetch_row($resProg))
			{
				$queryComp="";
				
				if(!$existeFuncionSitio)
				{
					$situacionPlan=obtenerSituacionPlanPeriodo($filasProg[0],$ciclo,$idPeriodo);

					$listGrados=-1;
					if($situacionPlan==3)
					{
						$consulta="SELECT idEstructuraPeriodo FROM 4546_estructuraPeriodo WHERE idInstanciaPlanEstudio=".$filasProg[0]." AND idCiclo=".$ciclo." AND idPeriodo=".$idPeriodo;
						$listGrados=$con->obtenerListaValores($consulta);
					}
					else
					{
						if($situacionPlan==0)
						{
							$consulta="SELECT idEstructuraPeriodo FROM 4546_estructuraPeriodo e,4615_gradosSolicitudAutorizacionEstructura g 
										WHERE e.idInstanciaPlanEstudio=".$filasProg[0]." AND e.idCiclo=".$ciclo." AND e.idPeriodo=".$idPeriodo." and g.idGradoEstructura=e.idEstructuraPeriodo
										and g.dictamen=1";
							$listGrados=$con->obtenerListaValores($consulta);
						}
					}
					
					
					if($listGrados=="")
						$listGrados=-1;
					
					
					if(!$ignorarSituacion)
					{
						$queryComp=" and g.idGradoCiclo in (".$listGrados.")";
					}
				}
				else
				{
					eval('$queryComp=gruposVisiblesProfesor_'.$llaveSitio.'($idUsuario,$ciclo,$idPeriodo);');
					
				}
				
				
				
				
				
				$consulta="SELECT g.idMateria,g.idGrupos,nombreGrupo,m.nombreMateria,a.fechaAsignacion,a.fechaBaja FROM 4520_grupos g,4519_asignacionProfesorGrupo a, 4502_Materias m
						WHERE idCiclo=".$ciclo." and idPeriodo=".$idPeriodo." AND idInstanciaPlanEstudio=".$filasProg[0]." AND  a.idGrupo=g.idGrupos AND a.idUsuario=".$idUsuario." AND 
							 m.idMateria=g.idMateria and  a.fechaAsignacion<=a.fechaBaja ".$queryComp." 
						";

				

				$resMaterias=$con->obtenerFilas($consulta);
				$arrMaterias="";
				while($fila=mysql_fetch_row($resMaterias))
				{
					
					$consulta="SELECT idAliasClaveMateria FROM 4512_aliasClavesMateria WHERE idMateria=".$fila[0]." AND idInstanciaPlanEstudio=".$filasProg[0];
					$idAliasClaveMateria=$con->obtenerValor($consulta);
					$nodoM='	{
									"text":"('.cv($fila[2]).') '.cv($fila[3]).'",
									"id":"'.$fila[1]."_".$fila[0].'",
									"idMateria":"'.$fila[0].'",
									"idAliasClaveMateria":"'.$idAliasClaveMateria.'",
									"idInstanciaPlan":"'.$filasProg[0].'",
									"allowDrop":false,
									"idGrupo":"'.$fila[1].'",
									"icon":"../images/users.png",
									"tipo":"1",
									"fechaInicio":"'.$fila[4].'",
									"fechaTermino":"'.$fila[5].'",
									leaf:true
								}
							';	
					if($arrMaterias=="")
						$arrMaterias=$nodoM;
					else
						$arrMaterias.=",".$nodoM;
				}
				
					
				if($arrMaterias!="")
				{
					$nodoProg='	{
									"text":"'.cv($filasProg[3]).' ('.cv($filasProg[2]).')",
									"id":"p_'.$filasProg[0].'",
									"allowDrop":false,
									"icon":"../images/book_open.png",
									"tipo":"0",
									"idGrupo":"-1",
									"children":	['.$arrMaterias.']
								}
										';		
					if($arrNodos=="")
						$arrNodos=$nodoProg;
					else
						$arrNodos.=",".$nodoProg;
				}
				
			}
		}
		else
		{
			$ignorarSituacion=true;
			/*$consulta="SELECT DISTINCT g.idInstanciaPlanEstudio,Plantel,o.unidad,i.nombrePlanEstudios FROM 4520_grupos g,4517_alumnosVsMateriaGrupo a,817_organigrama o,4513_instanciaPlanEstudio i 
						WHERE g.idCiclo=".$ciclo." and g.idPeriodo=".$idPeriodo." AND a.idGrupo=g.idGrupos AND a.idUsuario=".$idUsuario."  AND 
						a.situacion=1 AND o.codigoUnidad=g.Plantel AND i.idInstanciaPlanEstudio=g.idInstanciaPlanEstudio";*/
			
			$consulta="SELECT idInstanciaPlanEstudio FROM 4529_alumnos a WHERE idUsuario=".$idUsuario." AND idCiclo=".$ciclo." AND idPeriodo=".$idPeriodo;
			
			
			
			$resProg=$con->obtenerFilas($consulta);
			$arrNodos="";
			
			while($filasProg=mysql_fetch_row($resProg))
			{
				
				$consulta="select unidad from 817_organigrama o,4513_instanciaPlanEstudio i where i.idInstanciaPlanEstudio=".$filasProg[0]." and o.codigoUnidad=i.sede";
				$plantel=$con->obtenerValor($consulta);
				
				$situacionPlan=obtenerSituacionPlanPeriodo($filasProg[0],$ciclo,$idPeriodo);
				if(($situacionPlan==3)||($ignorarSituacion))
				{
					$consulta="(SELECT g.idGrupos FROM 4520_grupos g,4517_alumnosVsMateriaGrupo a
								WHERE  g.idInstanciaPlanEstudio=".$filasProg[0]." and g.idCiclo=".$ciclo." and g.idPeriodo=".$idPeriodo." AND  a.idGrupo=g.idGrupos AND a.idUsuario=".$idUsuario." AND 
								a.situacion=1)
								union
								(
									SELECT a.idGrupo FROM 4520_grupos g,4517_alumnosVsMateriaGrupo a
											WHERE  g.idInstanciaPlanEstudio=".$filasProg[0]." and g.idCiclo=".$ciclo." and g.idPeriodo=".$idPeriodo." AND  a.idGrupoOrigen=g.idGrupos AND a.idUsuario=".$idUsuario." AND 
											a.situacion=1
								)
								";
					
					$listGrupos=$con->obtenerListaValores($consulta);
					if($listGrupos=="")
						$listGrupos=-1;
					
					$consulta="SELECT g.idMateria,g.idGrupos,nombreGrupo,m.nombreMateria FROM 4520_grupos g, 4502_Materias m
							WHERE g.idGrupos IN (".$listGrupos.") AND g.idMateria=m.idMateria ORDER BY m.nombreMateria,nombreGrupo";		
					$resMaterias=$con->obtenerFilas($consulta);
					$arrMaterias="";
					while($fila=mysql_fetch_row($resMaterias))
					{
						
						$consulta="SELECT idAliasClaveMateria FROM 4512_aliasClavesMateria WHERE idMateria=".$fila[0]." AND idInstanciaPlanEstudio=".$filasProg[0];
						$idAliasClaveMateria=$con->obtenerValor($consulta);
						$nodoM='	{
										"text":"('.cv($fila[2]).') '.cv($fila[3]).'",
										"id":"'.$fila[1]."_".$fila[0].'",
										"idMateria":"'.$fila[0].'",
										"idAliasClaveMateria":"'.$idAliasClaveMateria.'",
										"idInstanciaPlan":"'.$filasProg[0].'",
										"allowDrop":false,
										"idGrupo":"'.$fila[1].'",
										"icon":"../images/users.png",
										"tipo":"1",
										leaf:true
									}
								';	
						if($arrMaterias=="")
							$arrMaterias=$nodoM;
						else
							$arrMaterias.=",".$nodoM;
					}
				
					
					if($arrMaterias!="")
					{
						$nodoProg='	{
										"text":"'.cv(obtenerNombreInstanciaPlan($filasProg[0])).' ('.cv($plantel).')",
										"id":"p_'.$filasProg[0].'",
										"allowDrop":false,
										"icon":"../images/book_open.png",
										"tipo":"0",
										"idGrupo":"-1",
										"children":	['.$arrMaterias.']
									}
											';		
						if($arrNodos=="")
							$arrNodos=$nodoProg;
						else
							$arrNodos.=",".$nodoProg;
					}
				}
			}
		}
		echo "[".uEJ($arrNodos)."]";
	
	}
	
	function obtenerTemarioMateriaProfesor()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$consulta="SELECT idMateria,Plantel FROM 4520_grupos WHERE idGrupos=".$idGrupo;
		$fGrupo=$con->obtenerPrimeraFila($consulta);
		if(!$fGrupo)
		{
			echo "[]";
			return;
		}
		$idMateria=$fGrupo[0];
		$plantel=$fGrupo[1];
		$noSesion=$_POST["noSesion"];
		$arrTemas="";
		$comp=" and idStatus=1 and (plantel='' or plantel is null or plantel='".$plantel."')";
		if($noSesion==-1)
		{
			
			$consulta="select idTemario,noTema,tema,descripcion,codigoUnidad,orden,s.nombreStatus,s.idStatus,plantel from 4502_temarioMateria t,4005_status s where  s.idStatus=t.situacion and idMateria=".$idMateria." and nivel=1 ".$comp." order by orden";
		}
		else
			$consulta="select idTemario,noTema,tema,descripcion,codigoUnidad,orden,s.nombreStatus,s.idStatus,plantel from 4502_temarioMateria t,4005_status s where  
					s.idStatus=t.situacion and idMateria=".$idMateria." and idTemario in (SELECT idTema FROM 4536_temasVSSesion WHERE idGrupo=".$idGrupo." AND noSesion=".$noSesion.") ".$comp." order by orden";
		$resMateria=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resMateria))
		{
			$plantel=$fila[8];
			$color="black";
			
			$obj='{id:"'.$fila[0].'",text:"<font color=\''.$color.'\'>'.$fila[1].'.- '.$fila[2].'</font>",plantel:"'.$plantel.'",noTema:"'.cv($fila[1]).'",tema:"'.cv($fila[2]).'",qtip :"'.cv($fila[3]).'",descripcion:"'.cv($fila[3]).'",codigoUnidad:"'.cv($fila[4]).'",idSituacion:"'.$fila[7].'",situacion:"'.$fila[6].'",orden:"'.cv($fila[5]).'"';
			$hijos="";
			if($noSesion==-1)
				$hijos=obtenerTemasHijosProfesor($idMateria,$fila[4],$comp);																								  
			if($hijos=='')
				$obj.=',leaf:true,icon:"../images/bullet_green.png"}';
			else
				$obj.=',children:['.$hijos.'],icon:"../images/bullet_green.png"}';
			if($arrTemas=="")
				$arrTemas=$obj;
			else
				$arrTemas.=",".$obj;
		}
		echo "[".$arrTemas."]";
	}
	
	function obtenerTemasHijosProfesor($idMateria,$codPadre,$comp)
	{
		global $con;
		$arrTemas="";
		$consulta="select idTemario,noTema,tema,descripcion,codigoUnidad,orden,s.nombreStatus,s.idStatus,plantel  from 4502_temarioMateria t,4005_status s where  s.idStatus=t.situacion and idMateria=".$idMateria." and codigoUnidadPadre='".$codPadre."' ".$comp." order by orden";
		$resMateria=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resMateria))
		{
			$plantel=$fila[8];
			$color="black";
			$obj='{id:"'.$fila[0].'",text:"<font color=\''.$color.'\'>'.$fila[1].'.- '.$fila[2].'</font>",plantel:"'.$plantel.'",noTema:"'.cv($fila[1]).'",tema:"'.cv($fila[2]).'",qtip :"'.cv($fila[3]).'",descripcion:"'.cv($fila[3]).'",codigoUnidad:"'.cv($fila[4]).'",idSituacion:"'.$fila[7].'",situacion:"'.$fila[6].'",orden:"'.cv($fila[5]).'"';
			$hijos=obtenerTemasHijos($idMateria,$fila[4],$comp);																								  
			if($hijos=='')
				$obj.=',leaf:true,icon:"../images/bullet_green.png"}';
			else
				$obj.=',children:['.$hijos.'],icon:"../images/bullet_green.png"}';
			if($arrTemas=="")
				$arrTemas=$obj;
			else
				$arrTemas.=",".$obj;
		}
		return $arrTemas;
	}
	
	function obtenerSesionesGrupo()
	{
		global $con;
		global $arrDiasSemana;
		$idGrupo=$_POST["idGrupo"];
		$consulta="SELECT COUNT(*) FROM 4530_sesiones WHERE idGrupo=".$idGrupo;
		$nSesiones=$con->obtenerValor($consulta);
		if($nSesiones==0)
		{
			$consulta="SELECT fechaInicio,fechaFin,situacion,Plantel FROM 4520_grupos WHERE idGrupos=".$idGrupo;
			$fila=$con->obtenerPrimeraFila($consulta);
			$consulta=array();
			$x=0;
			ajustarSesiones($idGrupo,strtotime($fila[0]),NULL,$consulta,$x,true);
			
		}
		
		$consulta="SELECT idSesion,noSesion,fechaSesion,horario,tipoSesion,situacionAsistencia,comentarios,tipoExamen,noExamen FROM 4530_sesiones WHERE idGrupo=".$idGrupo." ORDER BY fechaSesion";
		$arrSesiones=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrSesiones).'}';
		
	}
	
	function registrarAsistencia()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$noSesion=$_POST["noSesion"];
		$fecha=$_POST["fecha"];
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$query[$x]="begin";
		$x++;
		foreach($obj->arrRegistros as $o)
		{
			if($o->idAsistencia==-1)
			{
				$query[$x]="INSERT INTO 4531_listaAsistencia(idGrupo,noSesion,fechaSesion,idAlumno,tipo) VALUES(".$idGrupo.",".$noSesion.",'".$fecha."',".$o->idUsuario.",".$o->asistencia.")";
				$x++;
			}
			else
			{
				$query[$x]="update 4531_listaAsistencia set tipo=".$o->asistencia." where idAsistencia=".$o->idAsistencia;
				$x++;
			}
		}
		$query[$x]="UPDATE 4530_sesiones SET situacionAsistencia=1 WHERE idGrupo=".$idGrupo." AND noSesion=".$noSesion;
		$x++;
		$query[$x]="commit";
		$x++;
		eB($query);
		
	}
	
	function obtenerTemarioMateriaPlaneacion()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$consulta="SELECT idMateria,Plantel FROM 4520_grupos WHERE idGrupos=".$idGrupo;
		$fGrupo=$con->obtenerPrimeraFila($consulta);
		$idMateria=$fGrupo[0];
		$plantel=$fGrupo[1];
		$noSesion=$_POST["noSesion"];
		$consulta="SELECT idTema FROM 4536_temasVSSesion WHERE idGrupo=".$idGrupo." AND noSesion=".$noSesion;
		$arrTemasSesion=$con->obtenerFilasArreglo1D($consulta);
		$arrTemas="";
		$comp=" and idStatus=1 and (plantel='' or plantel is null or plantel='".$plantel."')";
		$consulta="select idTemario,noTema,tema,descripcion,codigoUnidad,orden,s.nombreStatus,s.idStatus,plantel from 4502_temarioMateria t,4005_status s where  s.idStatus=t.situacion and idMateria=".$idMateria." and nivel=1 ".$comp." order by orden";
		$resMateria=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resMateria))
		{
			$plantel=$fila[8];
			$color="black";
			$temaCheck='false';
			if(existeValor($arrTemasSesion,$fila[0]))
				$temaCheck='true';
			$obj='{checked:'.$temaCheck.',id:"'.$fila[0].'",text:"<font color=\''.$color.'\'>'.$fila[1].'.- '.cv($fila[2]).'</font>",plantel:"'.$plantel.'",noTema:"'.cv($fila[1]).'",tema:"'.cv($fila[2]).'",qtip :"'.cv($fila[3]).'",descripcion:"'.cv($fila[3]).'",codigoUnidad:"'.cv($fila[4]).'",idSituacion:"'.$fila[7].'",situacion:"'.$fila[6].'",orden:"'.cv($fila[5]).'"';
			$hijos=obtenerTemasHijosPlaneacion($idMateria,$fila[4],$comp,$arrTemasSesion);																								  
			if($hijos=='')
				$obj.=',leaf:true,icon:"../images/bullet_green.png"}';
			else
				$obj.=',children:['.$hijos.'],icon:"../images/bullet_green.png"}';
			if($arrTemas=="")
				$arrTemas=$obj;
			else
				$arrTemas.=",".$obj;
		}
		echo "[".$arrTemas."]";
	}
	
	function obtenerTemasHijosPlaneacion($idMateria,$codPadre,$comp,$arrTemasSesion)
	{
		global $con;
		$arrTemas="";
		$consulta="select idTemario,noTema,tema,descripcion,codigoUnidad,orden,s.nombreStatus,s.idStatus,plantel  from 4502_temarioMateria t,4005_status s where  s.idStatus=t.situacion and idMateria=".$idMateria." and codigoUnidadPadre='".$codPadre."' ".$comp." order by orden";
		$resMateria=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resMateria))
		{
			$plantel=$fila[8];
			$color="black";
			$temaCheck='false';
			if(existeValor($arrTemasSesion,$fila[0]))
				$temaCheck='true';
			$obj='{checked:'.$temaCheck.',id:"'.$fila[0].'",text:"<font color=\''.$color.'\'>'.$fila[1].'.- '.cv($fila[2]).'</font>",plantel:"'.$plantel.'",noTema:"'.cv($fila[1]).'",tema:"'.cv($fila[2]).'",qtip :"'.cv($fila[3]).'",descripcion:"'.cv($fila[3]).'",codigoUnidad:"'.cv($fila[4]).'",idSituacion:"'.$fila[7].'",situacion:"'.$fila[6].'",orden:"'.cv($fila[5]).'"';
			$hijos=obtenerTemasHijos($idMateria,$fila[4],$comp);																								  
			if($hijos=='')
				$obj.=',leaf:true,icon:"../images/bullet_green.png"}';
			else
				$obj.=',children:['.$hijos.'],icon:"../images/bullet_green.png"}';
			if($arrTemas=="")
				$arrTemas=$obj;
			else
				$arrTemas.=",".$obj;
		}
		return $arrTemas;
	}
		
	function obtenerSesionesAlumno()
	{
		global $con;
		global $arrDiasSemana;
		$idGrupo=$_POST["idGrupo"];
		$idUsuario=$_POST["idUsuario"];
		
		$consulta="SELECT idSesion,noSesion,fechaSesion,horario,tipoSesion,(SELECT tipo FROM 4531_listaAsistencia  WHERE idGrupo=".$idGrupo." AND noSesion=s.noSesion AND idAlumno=".$idUsuario.")as registroAsistencia,comentarios 
						FROM 4530_sesiones s WHERE idGrupo=".$idGrupo." ORDER BY fechaSesion";
		$arrSesiones=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrSesiones).'}';
		
	}
	
	function obtenerEspecilidadArea()
	{
		global $con;
		$idArea=$_POST["idArea"];
		$consulta="SELECT id__369_dtgEspecialidad,especialidad FROM _369_dtgEspecialidad WHERE idReferencia=".$idArea;
		echo "1|".$con->obtenerFilasArreglo($consulta);
	}
	
	function guardarEspecialidadMateria()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$cadEspecialidad=$_POST["cadEspecialidad"];
		$arrEspecialidades=explode(",",$cadEspecialidad);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrEspecialidades as $e)
		{
			$consulta[$x]="insert into 4502_perfilMateria(idMateria,idEspecialidad) values(".$idMateria.",".$e.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerIdRegistroConfiguracion()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idPlanEstudio=$_POST["idPlanEstudio"];
		$idInstancia=$_POST["idInstancia"];
		$consulta="select id__".$idFormulario."_tablaDinamica from _".$idFormulario."_tablaDinamica where idPlanEstudio=".$idPlanEstudio." and idInstanciaPlanEstudio=".$idInstancia;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
			$idRegistro=-1;
			echo "1|".$idRegistro;
			
	}
	
	function obtenerProgramasSede()
	{
		global $con;
		$sede=$_POST["s"];
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		$consulta="select * from (SELECT i.idInstanciaPlanEstudio,i.nombrePlanEstudios as nombre,i.cveRvoe,t.turno,m.nombre as modalidad,p.descripcion 
		FROM 4500_planEstudio p,4005_status s,4513_instanciaPlanEstudio i,4516_turnos t,4514_tipoModalidad m
		 WHERE t.idTurno=i.idTurno and m.idModalidad=i.idModalidad and i.idPlanEstudio=p.idPlanEstudio and i.sede='".$sede."' and 
		 s.idStatus=i.situacion) as tmp where ".$cadCondWhere." ORDER BY  nombre";
		$arrProgramas=$con->obtenerFilasJson($consulta);
		$nFilas=$con->filasAfectadas;
		echo '{"nuReg":"'.$nFilas.'","registros":'.utf8_encode($arrProgramas).'}';
	}
	
	function obtenerMateriasPlanesEstudio()
	{
		global $con;
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		$idInstancia=$_POST["idInstanciaPlanEstudio"];
		$idGrupo=$_POST["idGrupo"];
		
		$consulta="SELECT idAliasClaveMateria,a.idMateria,a.cveMateria,nombreMateria FROM 4512_aliasClavesMateria a,4502_Materias m 
					WHERE m.idMateria=a.idMateria AND a.idInstanciaPlanEstudio=".$idInstancia." and ".$cadCondWhere."
					and idAliasClaveMateria not in (SELECT idAliasClaveMateria FROM 4512_aliasClavesMateria a,4520_grupos g 
					WHERE a.idInstanciaPlanEstudio=g.idInstanciaPlanEstudio AND a.idMateria=g.idMateria AND g.idGrupos=".$idGrupo.")
					and a.idMateria not in (SELECT idMateriaEquivalente FROM 4539_gruposCompartidos WHERE idGrupo=".$idGrupo." AND idInstanciaComparte=".$idInstancia.")
					 ORDER BY nombreMateria";
		$arrMaterias=$con->obtenerFilasJson($consulta);
		$nFilas=$con->filasAfectadas;
		echo '{"nuReg":"'.$nFilas.'","registros":'.utf8_encode($arrMaterias).'}';					
	}
	
	function guardarGrupoCompartido()
	{
		global $con;
		global $arrDiasSemana;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$idGrupoOrigen=$obj->idGrupoOrigen;
		$idGrupoDestino=$obj->idGrupoDestino;
		$idPlanEstudioResp=$obj->idPlanEstudioResp;
		$consulta="SELECT * FROM 4520_grupos WHERE idGrupos=".$idGrupoOrigen;
		$fGrupoOrigen=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT * FROM 4520_grupos WHERE idGrupos=".$idGrupoDestino;
		$fGrupoDestino=$con->obtenerPrimeraFila($consulta);
		$idInstancia2=$idPlanEstudioResp;
		if($fGrupoOrigen[11]!=$fGrupoDestino[11])
		{
			if($fGrupoDestino[11]!=$idPlanEstudioResp)
			{
				$idInstancia2=$fGrupoDestino[11];
				$idGrupoOrigen=$obj->idGrupoDestino;
				$fAux=$fGrupoOrigen;
				$fGrupoOrigen=$fGrupoDestino;
				$idGrupoDestino=$obj->idGrupoOrigen;
				$fGrupoDestino=$fAux;
			}
			else
				$idInstancia2=$fGrupoOrigen[11];
		}
		
		if($fGrupoOrigen[12]!="")
		{
			$consulta="SELECT dia,horaInicio,horaFin,idGrupo,fechaInicio,fechaFin FROM 4522_horarioGrupo WHERE idGrupo=".$idGrupoDestino." ORDER BY dia,horaInicio";
			$resHorario=$con->obtenerFilas($consulta);
			$arrHorario=array();
			while($fHorario=mysql_fetch_row($resHorario))
			{
				if(!isset($arrHorario[$fHorario[0]]))
					$arrHorario[$fHorario[0]]=array();
				$objHorario[0]=$fHorario[1];
				$objHorario[1]=$fHorario[2];
				$objHorario[2]=$fHorario[3];
				$objHorario[3]=($fHorario[4]);//Fecha Inicio
				$objHorario[4]=($fHorario[5]);//Fecha Fin
				array_push($arrHorario[$fHorario[0]],$objHorario);
			}
			
			$consulta="SELECT idGrupos FROM 4520_grupos WHERE idGrupoPadre=".$fGrupoOrigen[12]." and idGrupos<>".$idGrupoOrigen." and ((fechaInicio>='".$fGrupoDestino[7]."' and fechaInicio<='".$fGrupoDestino[8]."')or
						(fechaFin>='".$fGrupoDestino[7]."' and fechaFin<='".$fGrupoDestino[8]."')or(fechaInicio<='".$fGrupoDestino[7]."' and fechaFin>='".$fGrupoDestino[8]."'))";
			
			$listGrupos=$con->obtenerListaValores($consulta);
			if($listGrupos=="")
				$listGrupos=-1;
			$consulta="SELECT dia,horaInicio,horaFin,idGrupo,fechaInicio,fechaFin FROM 4522_horarioGrupo WHERE idGrupo in (".$listGrupos.") ORDER BY dia,horaInicio";

			$resHorariosGrupo=$con->obtenerFilas($consulta);
			$arrHorarioGpo=array();
			while($fHorario=mysql_fetch_row($resHorariosGrupo))
			{
				if(!isset($arrHorarioGpo[$fHorario[0]]))
					$arrHorarioGpo[$fHorario[0]]=array();
				$objHorario[0]=$fHorario[1];
				$objHorario[1]=$fHorario[2];
				$objHorario[2]=$fHorario[3];
				$objHorario[3]=($fHorario[4]);//Fecha Inicio
				$objHorario[4]=($fHorario[5]);//Fecha Fin
				array_push($arrHorarioGpo[$fHorario[0]],$objHorario);
			}
			$arrGrupos=array();
			$consulta="SELECT idGrupos,nombreGrupo,m.nombreMateria,
					(select concat(i.nombrePlanEstudios,' (Turno: ',t.turno,', Modalidad: ',m.nombre,', Plantel: ',o.unidad,')') as nombrePlanEstudios from 
					4513_instanciaPlanEstudio i,4516_turnos t,4514_tipoModalidad m,817_organigrama o WHERE t.idTurno=i.idTurno and m.idModalidad=i.idModalidad 
					and o.codigoUnidad=i.sede and i.idInstanciaPlanEstudio=g.idInstanciaPlanEstudio) as planEstudio 
					FROM 4520_grupos g,4502_Materias m WHERE m.idMateria=g.idMateria and idGrupos IN (".$listGrupos.")";
			$resGrupos=$con->obtenerFilas($consulta);
			while($fGrupos=mysql_fetch_row($resGrupos))
			{
				$arrGrupos[$fGrupos[0]]["nombreGrupo"]=$fGrupos[1];
				$arrGrupos[$fGrupos[0]]["nombreMateria"]=$fGrupos[2];
				$arrGrupos[$fGrupos[0]]["planEstudio"]=$fGrupos[3];
				
			}
			$cadCasos="";
			$arrCasos="";
		
			if((sizeof($arrHorario)>0)&&(sizeof($arrHorarioGpo)>0))
			{
				foreach($arrHorario as $dia=>$arrHorarios)
				{
					if(isset($arrHorarioGpo[$dia]))
					{
						foreach($arrHorarios as $h)
						{
							foreach($arrHorarioGpo[$dia] as $resto)
							{
								if(colisionaTiempo($h[0],$h[1],$resto[0],$resto[1],false))
								{
									if(colisionaTiempo($h[3],$h[4],$resto[3],$resto[4],true))
									{
										$planEstudios=$arrGrupos[$resto[2]]["planEstudio"];
										$obj='{"noError":"13","permiteContinuar":"0","msgError":"El grupo presenta problemas de horario con el grupo <b>'.$arrGrupos[$resto[2]]["nombreGrupo"].'</b> de la materia <b>'.$arrGrupos[$resto[2]]["nombreMateria"].
											'</b> el d&iacute;a <b>'.utf8_encode($arrDiasSemana[$dia]).'</b> de '.date("H:i",strtotime($resto[0])).' a '.date("H:i",strtotime($resto[1])).' del plan de estudios <b>'.$planEstudios.'</b>","compl":""}';
										if($arrCasos=="")
											$arrCasos=$obj;
										else				
											$arrCasos.=",".$obj;
									}
								}
							}
							
						}
					}
				}
				if($arrCasos!="")
					$cadCasos='{"permiteContinuar":"0","arrCasos":['.$arrCasos.']}';	
			}
		}
		if($cadCasos!="")
		{
			echo "2|".$cadCasos;
			return;
		}
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$ejecutarTransaccion=false;
		$consulta="SELECT idUsuario FROM 4500_usuariosResponsablesPlanEstudio WHERE plantel='".$fGrupoOrigen[2]."' AND idPlanEstudio=".$fGrupoOrigen[1]." and idUsuario=".$_SESSION["idUsr"];
		$fRespO=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT idUsuario FROM 4500_usuariosResponsablesPlanEstudio WHERE plantel='".$fGrupoDestino[2]."' AND idPlanEstudio=".$fGrupoDestino[1]." and idUsuario=".$_SESSION["idUsr"];
		$fRespD=$con->obtenerPrimeraFila($consulta);
		//if($fRespO&&$fRespD)
			$ejecutarTransaccion=true;
		
		if($ejecutarTransaccion)
		{
			$query[$x]="update 4517_alumnosVsMateriaGrupo SET idGrupo=".$idGrupoDestino.",idGrupoOrigen=".$idGrupoOrigen." WHERE idGrupo=".$idGrupoOrigen;
			$x++;
			$query[$x]="update 4520_grupos SET situacion=2 where idGrupos=".$idGrupoOrigen;
			$x++;
			$query[$x]="insert into 4539_gruposCompartidos(idGrupo,idInstanciaComparte,idMateriaEquivalente,idGrupoReemplaza) 
						VALUES(".$idGrupoDestino.",".$fGrupoOrigen[11].",".$fGrupoOrigen[3].",".$idGrupoOrigen.")";
			$x++;
		}
		else
		{
			$query[$x]="INSERT INTO 4545_transaccionesPlanesEstudio(tipoTransaccion,idInstanciaPlan,idInstanciaPlan2,complementario1,complementario2,situacion,fechaTransaccion,respRegTransaccion)
					values(1,".$idPlanEstudioResp.",".$idInstancia2.",'".$idGrupoOrigen."','".$idGrupoDestino."',1,'".date("Y-m-d H:i")."',".$_SESSION["idUsr"].")";
			$x++;
					
		}
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	
	
	
	function removerGrupoCompartido()
	{
		global $con;
		$idGrupoCompartido=$_POST["idGrupoCompartido"];
		$consulta="SELECT * FROM 4539_gruposCompartidos WHERE idGrupoCompartido=".$idGrupoCompartido;
		$fGrupo=$con->obtenerPrimeraFila($consulta);
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="delete from 4539_gruposCompartidos where idGrupoCompartido=".$idGrupoCompartido;

		$x++;
		$query[$x]="update 4520_grupos SET situacion=1 where idGrupos=".$fGrupo[4];

		$x++;
		
		$query[$x]="update 4517_alumnosVsMateriaGrupo SET idGrupo=".$fGrupo[4].",idGrupoOrigen=NULL WHERE idGrupoOrigen=".$fGrupo[4];
		$x++;
		
		
		$query[$x]="commit";
		$x++;
		eB($query);
		
	}
	
	function obtenerPlanesMateriaComparteGrupo()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$consulta="SELECT g.idGrupoCompartido,i.nombrePlanEstudios as nombre,i.cveRvoe,t.turno,m.nombre as modalidad,o.unidad as  plantel,nombreMateria as materiaEquivale,p.descripcion 
		FROM 4500_planEstudio p,4005_status s,4513_instanciaPlanEstudio i,4516_turnos t,4514_tipoModalidad m,4539_gruposCompartidos g,817_organigrama o,4502_Materias mat
		WHERE o.codigoUnidad=i.sede and mat.idMateria=g.idMateriaEquivalente and i.idInstanciaPlanEstudio=g.idInstanciaComparte and t.idTurno=i.idTurno and m.idModalidad=i.idModalidad and i.idPlanEstudio=p.idPlanEstudio and
		s.idStatus=i.situacion and g.idGrupo=".$idGrupo." ORDER BY  nombre";
		$arrMaterias=$con->obtenerFilasJson($consulta);
		$nFilas=$con->filasAfectadas;
		echo '{"nuReg":"'.$nFilas.'","registros":'.utf8_encode($arrMaterias).'}';					
	}
	
	function obtenerHistorialAlumno()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$consulta="SELECT a.idAlumnoTabla,c.nombreCiclo,concat(i.nombrePlanEstudios,' (Turno: ',t.turno,', Modalidad: ',m.nombre,')') as nombrePlanEstudios,g.leyendaGrado,
					(if((select gr.nombreGrupo from 4540_gruposMaestros gr where gr.idGrupoPadre=a.idGrupo) is null,'N/A',(select gr.nombreGrupo from 4540_gruposMaestros gr where gr.idGrupoPadre=a.idGrupo))) as nombreGrupo,s.nombreStatus FROM 
					4529_alumnos a,4526_ciclosEscolares c,4501_Grado g, 
					4513_instanciaPlanEstudio i,4527_status s,4516_turnos t,4514_tipoModalidad m
					WHERE t.idTurno=i.idTurno and m.idModalidad=i.idModalidad and s.idStatus=a.estado AND i.idInstanciaPlanEstudio=a.idInstanciaPlanEstudio AND c.idCiclo=a.ciclo AND 
					g.idGrado=a.idGrado AND  a.idUsuario=".$idUsuario;
				
		$arr=$con->obtenerFilasJson($consulta);					
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arr).'}';
	}
	
	function obtenerPlanEstudioPlantel()
	{
		global $con;
		$plantel=$_POST["plantel"];
		$consulta="SELECT idInstanciaPlanEstudio,CONCAT(nombrePlanEstudios,' <br>(<span class=\"letraRojaSubrayada8\">Turno:</span> <span class=\"letraExt\"><b>',t.turno,'</b>,</span> <span class=\"letraRojaSubrayada8\">Modalidad:</span> <span class=\"letraExt\"><b>',m.nombre,'</b></span>)') AS nombrePlanEstudios,
					CONCAT(nombrePlanEstudios,' (Turno: ',t.turno,', Modalidad: ',m.nombre,')') AS nombrePlanEstudios2
					FROM 4513_instanciaPlanEstudio i,4514_tipoModalidad m,4516_turnos t WHERE i.idTurno=t.idTurno AND 
					i.idModalidad=m.idModalidad and sede='".$plantel."'";
		
		$arr=$con->obtenerFilasArreglo($consulta);					
		echo "1|".$arr;
		
	}
	
	function inscribirAlumnoGradoManual()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$query="SELECT sede,idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$obj->idInstanciaPlanEstudio;
		$filaPlan=$con->obtenerPrimeraFila($query);
		$idPlanEstudio=$filaPlan[1];
		$Plantel=$filaPlan[0];
		$Ciclo=$obj->idCiclo;
		$idUsuario=$obj->idAlumno;
		$idInstanciaPlan=$obj->idInstanciaPlanEstudio;
		$idGrado=$obj->idGrado;
		

		if($obj->idEsquemaGrupo==1)
		{
			
			$x=0;
			$consulta[$x]="begin";
			$x++;
			$consulta[$x]="INSERT INTO 4529_alumnos(ciclo,idInstanciaPlanEstudio,idGrado,idGrupo,idUsuario,estado) VALUES(".$Ciclo.",".$idInstanciaPlan.",".$idGrado.",NULL,".$idUsuario.",1)";
			$x++;
			$query="SELECT codigoUnidad FROM 4505_estructuraCurricular WHERE idUnidad=".$idGrado." AND idPlanEstudio=".$idPlanEstudio." 
				AND tipoUnidad=3";
			$codigoUnidad=$con->obtenerValor($query);
			inscribirAlumnoMateriaObligatoria($codigoUnidad,$idPlanEstudio,$idUsuario,$consulta,$x,$Ciclo,$Plantel,$idInstanciaPlan,$idGrado);

			$consulta[$x]="commit";
			$x++;
			$res=$con->ejecutarBloque($consulta);
		}
		else
		{
			$res=inscribirAlumnoGradoGrupo($obj->idAlumno,$obj->idGrado,$obj->idCiclo,$obj->idGrupo);
			
		}
		if($res)
			echo "1|";			
	}
	
	function removerAlumnoCiclo()
	{
		global $con;
		$idAlumnoTabla=$_POST["idAlumnoTabla"];
		$consulta="SELECT * FROM 4529_alumnos WHERE idAlumnoTabla=".$idAlumnoTabla;
		$fila=$con->obtenerPrimeraFila($consulta);
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="delete from 4529_alumnos WHERE idAlumnoTabla=".$idAlumnoTabla;
		$x++;
		$query[$x]="DELETE FROM 4517_alumnosVsMateriaGrupo WHERE idUsuario=".$fila[7]." AND  idGrupo IN (
						SELECT idGrupos FROM 4520_grupos WHERE idInstanciaPlanEstudio=".$fila[2]." AND idCiclo=".$fila[1].")";	
		$x++;									
		$query[$x]="commit";
		$x++;
		eB($query);
		
	}
	
	function verificarEscala()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		if($obj->idElemento!=-1)
		{
			$consulta="select idEscalaCalificacion from 4033_elementosEscala where idElementoEscala=".$obj->idElemento;
			$idEscala=$con->obtenerValor($consulta);
			$consulta="select idEscalaCalificacion from 4033_elementosEscala where ((valorMinimo>=".$obj->minimo." and valorMaximo<=".$obj->minimo.") 
						or (valorMinimo>=".$obj->maximo." and valorMaximo<=".$obj->maximo.") or (".$obj->minimo.">=valorMinimo and ".$obj->maximo."<=valorMaximo)) 
						and idEscalaCalificacion=".$idEscala." and idElementoEscala<>".$obj->idElemento;

		}
		else
		{
			$idEscala=$obj->idEscala;
			$consulta="select idEscalaCalificacion from 4033_elementosEscala where ((valorMinimo>=".$obj->minimo." and valorMaximo<=".$obj->minimo.") 
						or (valorMinimo>=".$obj->maximo." and valorMaximo<=".$obj->maximo.") or (".$obj->minimo.">=valorMinimo and ".$obj->maximo."<=valorMaximo)) 
						and idEscalaCalificacion=".$idEscala;
			
		}

		$con->obtenerFilas($consulta);
		
		echo "1|".$con->filasAfectadas;
		
	}
	
	function eliminarEscala()
	{
		global $con;
		$idEscala=$_POST["idEscala"];
		$consulta="delete from 4033_elementosEscala where idElementoEscala=".$idEscala;
		eC($consulta);
	}
	function obtenerFechasPeriodo()
	{
		global $con;
		return;
		$idCiclo=$_POST["idCiclo"];
		$idPeriodicidad=$_POST["idPeriodicidad"];
		$plantel=$_POST["plantel"];
		$consulta="SELECT id__464_gridPeriodos,nombrePeriodo FROM _464_gridPeriodos WHERE idReferencia=".$idPeriodicidad;
		$res=$con->obtenerFilas($consulta);
		$arrFechas="";
		$nReg=$con->filasAfectadas;
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT fechaInicial,fechaFinal FROM 4544_fechasPeriodo WHERE idPeriodo=".$fila[0]." AND idCiclo=".$idCiclo." and Plantel='".$plantel."'";
			$fFechas=$con->obtenerPrimeraFila($consulta);
			
			$obj='{
						"idPeriodo":"'.$fila[0].'",
						"nombrePeriodo":"'.$fila[1].'",
						"fechaInicial":"'.$fFechas[0].'",
						"fechaFinal":"'.$fFechas[1].'"
					}';
			if($arrFechas=="")
				$arrFechas=$obj;
			else
				$arrFechas.=",".$obj;
		}
		echo '{"numReg":"'.$nReg.'",registros:['.$arrFechas.']}';
			
	}
	
	function guardarFechaPeriodo()
	{
		global $con;
		
		
		$fechaActual=date("Y-m-d");
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		

		foreach($obj->listInstancias as $objInstancia)
		{
			if($objInstancia->tipo==3)
			{
			
				$query="SELECT idPeriodoFecha,fechaInicial FROM 4544_fechasPeriodo WHERE idCiclo=".$obj->idCiclo." AND idPeriodo=".$objInstancia->idPeriodo." AND idInstanciaPlanEstudio=".$objInstancia->idInstancia;
				$fPeriodo=$con->obtenerPrimeraFila($query);
				if(!$fPeriodo)
				{
					$consulta[$x]="INSERT INTO 4544_fechasPeriodo(idPeriodo,fechaInicial,fechaFinal,idCiclo,Plantel,idInstanciaPlanEstudio) VALUES(".$objInstancia->idPeriodo.",'".$obj->fechaInicial.
								"','".$obj->fechaFinal."',".$obj->idCiclo.",'".$obj->plantel."',".$objInstancia->idInstancia.")";
					$x++;
				}
				else
				{
					$consulta[$x]="update 4520_grupos set fechaInicio='".$obj->fechaInicial."' where idInstanciaPlanEstudio='".$objInstancia->idInstancia."' and 
								(fechaInicio='".$fPeriodo[1]."' or fechaInicio<'".$obj->fechaInicial."' or fechaInicio is null) and idCiclo=".$obj->idCiclo." AND idPeriodo=".$objInstancia->idPeriodo;
					$x++;
					$consulta[$x]="UPDATE 4544_fechasPeriodo SET fechaInicial='".$obj->fechaInicial."',fechaFinal='".$obj->fechaFinal."' WHERE idPeriodoFecha=".$fPeriodo[0];
					$x++;
					
				}
			}
			else
			{
				if($objInstancia->tipo==5)
				{
					$consulta[$x]="DELETE FROM 4571_fechasBloquePeriodo WHERE idInstancia=".$objInstancia->idInstancia." AND idCiclo=".$obj->idCiclo.
								"  AND idPeriodo=".$objInstancia->idPeriodo." AND noBloque=".$objInstancia->noBloque;
					$x++;
					
					$query="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$objInstancia->idInstancia;
					$idPlanEstudio=$con->obtenerValor($query);
					
					
					
					$query="SELECT idUnidad FROM 4505_estructuraCurricular WHERE idPlanEstudio=".$idPlanEstudio." AND tipoUnidad=3";
					$resGrados=$con->obtenerFilas($query);	
					while($fGrados=mysql_fetch_row($resGrados))
					{
						$query="SELECT idEstructuraPeriodo FROM 4546_estructuraPeriodo WHERE idCiclo=".$obj->idCiclo." 
								AND idPeriodo=".$objInstancia->idPeriodo." AND idInstanciaPlanEstudio=".$objInstancia->idInstancia.
								" AND idGrado=".$fGrados[0];
						

						$iGdo=$con->obtenerValor($query);
						if($iGdo=="")
							$iGdo="-".$fGrados[0];
							
						$consulta[$x]="INSERT INTO 4571_fechasBloquePeriodo(noBloque,idGrado,idPeriodo,idCiclo,fechaInicio,idInstancia,fechaFin,idGradoPlan) 
										VALUES(".$objInstancia->noBloque.",".$iGdo.",".$objInstancia->idPeriodo.",".$obj->idCiclo.",'".$obj->fechaInicial.
										"',".$objInstancia->idInstancia.",'".$obj->fechaFinal."',".$fGrados[0].")";
						$x++;
					}
				}
				else
				{
					$query="SELECT idFechasExamen FROM 4580_fechasExamenes WHERE idCiclo=".$obj->idCiclo." AND idPeriodo=".$objInstancia->idPeriodo." AND idInstancia=".$objInstancia->idInstancia.
							" and  idExamen=".$objInstancia->tipoExamen." AND complementario=".$objInstancia->noExamen." AND numBloque=".$objInstancia->noBloque;
					$fFechas=$con->obtenerPrimeraFila($query);	
					if(!$fFechas)
					{
						$consulta[$x]="INSERT INTO 4580_fechasExamenes(idExamen,complementario,idInstancia,idCiclo,idPeriodo,fechaInicio,fechaFin,numBloque)
										VALUES(".$objInstancia->tipoExamen.",'".$objInstancia->noExamen."',".$objInstancia->idInstancia.",".$obj->idCiclo.",".$objInstancia->idPeriodo.",'".$obj->fechaInicial."','".$obj->fechaFinal."',".$objInstancia->noBloque.")";
						$x++;
					}
					else
					{
						$consulta[$x]="update 4580_fechasExamenes set fechaInicio='".$obj->fechaInicial."',fechaFin='".$obj->fechaFinal."' WHERE idFechasExamen=".$fFechas[0];
	
						$x++;
					}
				}
			}
		}
		
		
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			
			if($obj->ajustarGrupos==1)
			{
			
				foreach($obj->listInstancias as $objInstancia)
				{
					if($objInstancia->tipo==3)
					{
						$query="SELECT idGrupos,idMateria,idInstanciaPlanEstudio FROM 4520_grupos WHERE idInstanciaPlanEstudio='".$objInstancia->idInstancia.
								"' and idCiclo=".$obj->idCiclo." AND idPeriodo=".$objInstancia->idPeriodo." and fechaFin>=fechaInicio AND fechaInicio>'".$fechaActual."'";
						$res=$con->obtenerFilas($query);
						while($fila=mysql_fetch_row($res))
						{
							if(!ajustarFechaFinalCurso($fila[0]))
								return "";
						}
					}
				}
			}
			
		}
		
		
		echo "1|";
		
	}
	
	function obtenerMateriasModificacionHoras()
	{
		global $con;
		$idInstancia=$_POST["idInstancia"];
		$query="SELECT m.nombreMateria,a.noHorasSemana AS horasActual,(a.noHorasSemana+a.cambioNoHoras) AS horasAnterior FROM 4512_aliasClavesMateria a,4502_Materias m 
				WHERE a.idInstanciaPlanEstudio=".$idInstancia." AND a.cambioNoHoras<>0 AND m.idMateria=a.idMateria";
		$arrObj=$con->obtenerFilasJson($query);
		$obj='{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrObj).'}';
		$consulta="update 4512_aliasClavesMateria set cambioNoHoras=0 where cambioNoHoras<>0 and idInstanciaPlanEstudio=".$idInstancia;
		if($con->ejecutarConsulta($consulta))
			echo $obj;
	}
	
	function clonarPlanEstudios()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$marcaClonacion=date("YmdHis");
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT  INTO 4500_planEstudio(nombre,descripcion,cvePlanEstudio,cveRvoe,fechaRvoe,codigoInstitucion,situacion,fechaCreacion,
						responsableCreacion,nivelPlanEstudio,Modalidad,Turno,AreaEspecialidad,horasSemanaMateriasInd)
						SELECT '".cv($obj->nombrePlan)."' as nombre,'".cv($obj->descripcion)."' as descripcion,'".cv($obj->clavePlan)."' as cvePlanEstudio,cveRvoe,fechaRvoe,codigoInstitucion,situacion,'".date("Y-m-d")."' as fechaCreacion,
						'".$_SESSION["idUsr"]."' as responsableCreacion,nivelPlanEstudio,Modalidad,Turno,AreaEspecialidad,horasSemanaMateriasInd FROM 
						4500_planEstudio WHERE idPlanEstudio=".$obj->idPlanEstudio;
		$x++;						
		$consulta[$x]="set @idPlanEstudio:=(select last_insert_id())";
		$x++;
		$consulta[$x]="INSERT INTO 4503_secuenciaPlanEstudio(idPlanEstudio,idPlanEstudioAntecede)
						SELECT @idPlanEstudio,idPlanEstudioAntecede FROM 4503_secuenciaPlanEstudio WHERE idPlanEstudio=".$obj->idPlanEstudio;
		$x++;
		$consulta[$x]="INSERT INTO 4504_sedesPermitidas (idPlanEstudio,sede,fechaCreacion,responsableCreacion)
					SELECT @idPlanEstudio,sede,'".date("Y-m-d")."','".$_SESSION["idUsr"]."' FROM 4504_sedesPermitidas WHERE idPlanEstudio=".$obj->idPlanEstudio;
		$x++;
		$consulta[$x]="INSERT INTO 4500_usuariosResponsablesPlanEstudio(idPlanEstudio,plantel,idUsuario)
						SELECT @idPlanEstudio,plantel,idUsuario FROM 4500_usuariosResponsablesPlanEstudio WHERE idPlanEstudio=".$obj->idPlanEstudio;
		$x++;
		
		$query="SELECT fechaCreacion,responsable,idEstado,codigoUnidad,codigoInstitucion,codigo,id__392_tablaDinamica FROM _392_tablaDinamica WHERE idReferencia=".$obj->idPlanEstudio;
		$res=$con->obtenerFilas($query);
		while($fila=mysql_fetch_row($res))
		{
			$consulta[$x]="INSERT INTO _392_tablaDinamica (idReferencia,fechaCreacion,responsable,idEstado,codigoUnidad,codigoInstitucion,codigo) values
							(@idPlanEstudio,'".date("Y-m-d")."',".$_SESSION["idUsr"].",'".$fila[2]."','".$fila[3]."','".$fila[4]."','".$fila[5]."')";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
			$consulta[$x]="INSERT INTO _392_docVSplanesEstudio(idReferencia,documentos) 
							SELECT @idRegistro,documentos FROM _392_docVSplanesEstudio WHERE idReferencia=".$fila[6];
			$x++;
		}
		
		$query="SELECT fechaCreacion,responsable,idEstado,codigoUnidad,codigoInstitucion,codigo,id__398_tablaDinamica FROM _398_tablaDinamica WHERE idReferencia=".$obj->idPlanEstudio;
		$res=$con->obtenerFilas($query);
		while($fila=mysql_fetch_row($res))
		{
			$consulta[$x]="INSERT INTO _398_tablaDinamica (idReferencia,fechaCreacion,responsable,idEstado,codigoUnidad,codigoInstitucion,codigo) values
							(@idPlanEstudio,'".date("Y-m-d")."',".$_SESSION["idUsr"].",'".$fila[2]."','".$fila[3]."','".$fila[4]."','".$fila[5]."')";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
			$consulta[$x]="INSERT INTO _398_examenesPlanes(idReferencia,examen,limitado,noMaxExamenes,noMaxExamRepetido) 
							SELECT @idRegistro,examen,limitado,noMaxExamenes,noMaxExamRepetido FROM _398_examenesPlanes WHERE idReferencia=".$fila[6];
			$x++;
		}
		$consulta[$x]="insert into _393_tablaDinamica(idReferencia,fechaCreacion,responsable,idEstado,codigoUnidad,codigoInstitucion,codigo,txtPorcentajeMin,cmbVeces,cmbRedondear)
						SELECT @idPlanEstudio,'".date("Y-m-d")."',".$_SESSION["idUsr"].",1,codigoUnidad,codigoInstitucion,codigo,txtPorcentajeMin,cmbVeces,cmbRedondear FROM _393_tablaDinamica WHERE idReferencia=".$obj->idPlanEstudio;
		$x++;
		$consulta[$x]="INSERT INTO 4521_configuracionGrupo(plantel,idPlanEstudio,prefijo,tipoSufijo,valorInicial,incremento,cupoMinimo,cupoMaximo)
						SELECT plantel,@idPlanEstudio,prefijo,tipoSufijo,valorInicial,incremento,cupoMinimo,cupoMaximo FROM 4521_configuracionGrupo
						WHERE idPlanEstudio=".$obj->idPlanEstudio;
		$x++;
		$query="SELECT idGrado,leyendaGrado,ordenGrado,situacion,descripcion,idGradoAnterior,idGradoSiguiente from 4501_Grado WHERE idPlanEstudio=".$obj->idPlanEstudio;
		$res=$con->obtenerFilas($query);
		while($fila=mysql_fetch_row($res))
		{
			$consulta[$x]="INSERT INTO 4501_Grado(idPlanEstudio,leyendaGrado,ordenGrado,situacion,descripcion,fechaCreacion,responsableCreacion,idGradoAnterior,idGradoSiguiente)
							VALUES(@idPlanEstudio,'".$fila[1]."',".$fila[2].",1,'".$fila[3]."','".date("Y-m-d")."',".$_SESSION["idUsr"].",-1,-1)";
			$x++;
			$consulta[$x]="set @idGrado:=(select last_insert_id())";
			$x++;
			$consulta[$x]="INSERT INTO 4554_elementosClonacion(idElementoOrigen,idElementoClon,tipoElemento,idPlanOrigen,idPlanDestino,marcaClonacion)
							VALUES(".$fila[0].",@idGrado,3,".$obj->idPlanEstudio.",@idPlanEstudio,'".$marcaClonacion."')";
			$x++;
		}
		
		if(mysql_num_rows($res)>0)
		{
			mysql_data_seek($res,0);
		}
		while($fila=mysql_fetch_row($res))
		{
			$idGradoAnterior=-1;
			if(($fila[5]!=-1)&&($fila[5]!=""))
			{
				$idGradoAnterior="if((select idElementoClon from 4554_elementosClonacion 
									where idElementoOrigen=".$fila[5]." and tipoElemento=3 and marcaClonacion='".$marcaClonacion."') is null,-1,(select idElementoClon from 4554_elementosClonacion 
									where idElementoOrigen=".$fila[5]." and tipoElemento=3 and marcaClonacion='".$marcaClonacion."'))";
			}
			$idGradoSiguiente=-1;
			if(($fila[6]!=-1)&&($fila[6]!=""))
			{
				
				$idGradoSiguiente="if((select idElementoClon from 4554_elementosClonacion 
								where idElementoOrigen=".$fila[6]." and tipoElemento=3 and marcaClonacion='".$marcaClonacion."') is null,-1,(select idElementoClon from 4554_elementosClonacion 
								where idElementoOrigen=".$fila[6]." and tipoElemento=3 and marcaClonacion='".$marcaClonacion."'))";
			}
			$consulta[$x]="update 4501_Grado set idGradoSiguiente=(".$idGradoSiguiente."),idGradoAnterior=(".$idGradoAnterior.")
								where idGrado=(select idElementoClon from 4554_elementosClonacion 
								where idElementoOrigen=".$fila[0]." and tipoElemento=3 and marcaClonacion='".$marcaClonacion."')";
			$x++;
		}
		$query="SELECT idUnidadContenedora,nombreUnidad,descripcion,tipoUnidad FROM 4508_unidadesContenedora WHERE idPlanEstudio=".$obj->idPlanEstudio;
		$res=$con->obtenerFilas($query);
		while($fila=mysql_fetch_row($res))
		{
			$consulta[$x]="INSERT INTO 4508_unidadesContenedora(nombreUnidad,descripcion,idPlanEstudio,tipoUnidad) VALUES('".$fila[1]."','".$fila[2]."',@idPlanEstudio,".$fila[3].")";
			$x++;
			$consulta[$x]="set @idContenedor:=(select last_insert_id())";
			$x++;
			$consulta[$x]="INSERT INTO 4554_elementosClonacion(idElementoOrigen,idElementoClon,tipoElemento,idPlanOrigen,idPlanDestino,marcaClonacion)
							VALUES(".$fila[0].",@idContenedor,2,".$obj->idPlanEstudio.",@idPlanEstudio,'".$marcaClonacion."')";
			$x++;
		}
		
		
		$query="SELECT * FROM 4502_Materias WHERE idPlanEstudio=".$obj->idPlanEstudio;
		$res=$con->obtenerFilas($query);
		while($fila=mysql_fetch_row($res))
		{
			if($fila[9]=="")
				$fila[9]="NULL";
			if($fila[10]=="")
				$fila[10]="NULL";
			if($fila[16]=="")
				$fila[16]="NULL";
			if($fila[18]=="")
				$fila[18]=0;
			$consulta[$x]="INSERT INTO 4502_Materias(idPlanEstudio,nombreMateria,descripcion,cveMateria,objGenerales,objEspecificos,horaMateriaTotal,
							horasTeoricasSemanal,horasPracticasSemanal,horasIndependientes,proposito,numeroCredito,situacion,fechaCreacion,responsableCreacion,
							noAplicaHorasMateria,horasSemana,noParciales) VALUES(@idPlanEstudio,'".$fila[2]."','".$fila[3]."','".$fila[4]."','".$fila[5]."','".$fila[6]."',".$fila[7].",
							".$fila[8].",".$fila[9].",".$fila[10].",'".$fila[11]."',".$fila[12].",1,'".date("Y-m-d")."',".$_SESSION["idUsr"].",".$fila[16].",".$fila[17].",".$fila[18].")";
									
			$x++;
			$consulta[$x]="set @idMateria:=(select last_insert_id())";
			$x++;
			$consulta[$x]="INSERT INTO 4554_elementosClonacion(idElementoOrigen,idElementoClon,tipoElemento,idPlanOrigen,idPlanDestino,marcaClonacion)
							VALUES(".$fila[0].",@idMateria,1,".$obj->idPlanEstudio.",@idPlanEstudio,'".$marcaClonacion."')";
			$x++;
			$consulta[$x]="INSERT INTO 4502_perfilMateria(idMateria,idEspecialidad)
						SELECT @idMateria,idEspecialidad FROM 4502_perfilMateria WHERE idMateria=".$fila[0];
			$x++;
			$consulta[$x]="INSERT INTO 4502_temarioMateria(idMateria,noTema,tema,descripcion,plantel,codigoUnidad,codigoUnidadPadre,situacion,nivel,orden)
						SELECT @idMateria,noTema,tema,descripcion,plantel,codigoUnidad,codigoUnidadPadre,situacion,nivel,orden FROM 4502_temarioMateria 
						WHERE idMateria=".$fila[0];
			$x++;
			
			
		}
		
		
		if(mysql_num_rows($res)>0)
			mysql_data_seek($res,0);
		while($fila=mysql_fetch_row($res))
		{
			$query="SELECT idMateriaRequisito,tipoRequisito FROM 4511_seriacionMateria WHERE idMateria=".$fila[0]." AND sede IS NULL";
			$resReq=$con->obtenerFilas($query);
			while($fReq=mysql_fetch_row($resReq))
			{
				$consulta[$x]="set @idMateriaAux:=(select idElementoClon from 4554_elementosClonacion where idElementoOrigen=".$fila[0]." and tipoElemento=1 and marcaClonacion='".$marcaClonacion."')";
				$x++;
				$consulta[$x]="set @idMateriaReq:=(select idElementoClon from 4554_elementosClonacion where idElementoOrigen=".$fReq[0]." and tipoElemento=1 and marcaClonacion='".$marcaClonacion."')";
				$x++;
				$consulta[$x]="insert into 4511_seriacionMateria(idMateria,idMateriaRequisito,tipoRequisito) values
								(@idMateriaAux,@idMateriaReq,".$fReq[1].")";
				$x++;
			}
		}
		
		$query="SELECT idUnidad,tipoUnidad,codigoPadre,codigoUnidad,naturalezaMateria,nivel,minOPC,maxOPC
				FROM 4505_estructuraCurricular WHERE idPlanEstudio=".$obj->idPlanEstudio;
		$res=$con->obtenerFilas($query);
		while($fila=mysql_fetch_row($res))
		{
			if($fila[2]=="")
				$fila[2]="NULL";
			else
				$fila[2]="'".$fila[2]."'";
			if($fila[4]=="")
				$fila[4]="NULL";
			if($fila[6]=="")
				$fila[6]="NULL";
			if($fila[7]=="")
				$fila[7]="NULL";
				
			$consulta[$x]="set @idUnidad:=(select idElementoClon from 4554_elementosClonacion where idElementoOrigen=".$fila[0]." and tipoElemento=".$fila[1]." and marcaClonacion='".$marcaClonacion."')";
			$x++;
			$consulta[$x]="INSERT INTO 4505_estructuraCurricular(idPlanEstudio,idUnidad,tipoUnidad,codigoPadre,codigoUnidad,naturalezaMateria,nivel,
							fechaCreacion,responsableCreacion,minOPC,maxOPC) VALUES(@idPlanEstudio,@idUnidad,".$fila[1].",".$fila[2].",'".$fila[3]."',".$fila[4].",
							".$fila[5].",'".date("Y-m-d")."',".$_SESSION["idUsr"].",".$fila[6].",".$fila[7].")";
			$x++;
		}
		$consulta[$x]="delete from 4554_elementosClonacion where idPlanDestino=@idPlanEstudio and marcaClonacion='".$marcaClonacion."'";
		$x++;
		$consulta[$x]="commit";
		$x++;

		if($con->ejecutarBloque($consulta))
		{
			$query="select @idPlanEstudio";
			$idPlanEstudio=$con->obtenerValor($query);
			echo "1|".$idPlanEstudio;
		}
		
	}
	
	function ajustarFechasTerminoGrupos()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		$idMateria=$_POST["idMateria"];
		$idInstancia=$_POST["idInstancia"];
		$consulta="select idGrupos,fechaInicio from 4520_grupos where idMateria=".$idMateria." and idInstanciaPlanEstudio=".$idInstancia." and idCiclo=".$idCiclo." and idPeriodo=".$idPeriodo;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			ajustarFechaFinalCurso($fila[0]);
		}
		echo "1|";
	}
	
	function obtenerProgramasEducativosNivel()
	{
		global $con;
		$nivelAcademico=$_POST["nivelAcademico"];
		$consulta="SELECT idProgramaEducativo,nombreProgramaEducativo FROM 4500_programasEducativos WHERE nivelProgramaEducativo=".$nivelAcademico." AND situacion=1";
		$arrProgramas=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrProgramas;
	}
	
	function finalizarRegistroAsistencia()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$noSesion=$_POST["noSesion"];
		$fecha=$_POST["fecha"];
		$query="UPDATE 4530_sesiones SET situacionAsistencia=2 WHERE idGrupo=".$idGrupo." AND noSesion=".$noSesion;
		eC($query);

	}
	
	function obtenerProgramasEducativosCiclo()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$plantel=$_POST["plantel"];
		$consulta="SELECT  DISTINCT p.idProgramaEducativo,p.nombreProgramaEducativo FROM 4546_estructuraPeriodo e,4513_instanciaPlanEstudio i,4500_programasEducativos p,4500_planEstudio pl WHERE idCiclo= ".$idCiclo."
			AND i.idInstanciaPlanEstudio=e.idInstanciaPlanEstudio AND pl.idPlanEstudio=i.idPlanEstudio AND p.idProgramaEducativo=pl.idProgramaEducativo and i.sede='".$plantel."'
			ORDER BY nombreProgramaEducativo";
		echo "1|".$con->obtenerFilasArreglo($consulta);
	}
	
	function obtenerPlanEstudiosProgramasEducativosCiclo()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$idPrograma=$_POST["idProgramaEducativo"];
		$plantel=$_POST["plantel"];
		$arrPlanEstudio="[]";
		$arrAux=array();
		if(($idPrograma!=-1)&&($idPrograma!=""))
		{
			$consulta="SELECT  DISTINCT i.idInstanciaPlanEstudio FROM 4546_estructuraPeriodo e,4513_instanciaPlanEstudio i,4500_planEstudio pl WHERE idCiclo=".$idCiclo."
						AND i.idInstanciaPlanEstudio=e.idInstanciaPlanEstudio AND pl.idPlanEstudio=i.idPlanEstudio AND pl.idProgramaEducativo=".$idPrograma." and i.sede='".$plantel."'";
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$nInstancia=obtenerNombreInstanciaPlan($fila[0]);
				$arrAux[$nInstancia."_".$fila[0]][0]=$fila[0];
				$arrAux[$nInstancia."_".$fila[0]][1]="[".$fila[0]."] ".cv($nInstancia);
			}
			ksort($arrAux);
			foreach($arrAux as $o)
			{
				$oA="['".$o[0]."','".$o[1]."']";
				if($arrPlanEstudio=="[]")
					$arrPlanEstudio=$oA;
				else
					$arrPlanEstudio.=",".$oA;
			}
			$arrPlanEstudio="[".$arrPlanEstudio."]";
		}
		echo "1|".$arrPlanEstudio;
	}
	
	function obtenerPeriodosInstanciaPlanEstudio()
	{
		global $con;
		$arrRegistros="[]";
		$idInstancia=$_POST["idInstancia"];
		if(($idInstancia!=-1)&&($idInstancia!=""))
		{
			$consulta="SELECT idPeriodicidad FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstancia;
			$idPeriodo=$con->obtenerValor($consulta);
			$consulta="SELECT id__464_gridPeriodos,nombrePeriodo,periodoDefaultActivo FROM _464_gridPeriodos WHERE idReferencia=".$idPeriodo;
			$arrRegistros=$con->obtenerFilasArreglo($consulta);
		}
		echo "1|".$arrRegistros;
	}
	
	function obtenerMateriasCicloPeriodoInstancia()
	{
		global $con;
		$idInstancia=$_POST["idInstancia"];
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		$registros="[]";
		
		if($idInstancia=="")
			$idInstancia=-1;
			
		if($idCiclo=="")
			$idCiclo=-1;
			
		if($idPeriodo=="")	
			$idPeriodo=-1;	
			
		$consulta="SELECT sede FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstancia;
		$plantel=$con->obtenerValor($consulta);
		
		if($plantel=="")
			$plantel=-1;
		
		
		$consulta="SELECT situacion FROM 4547_situacionInstanciaPlan WHERE idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." AND plantel='".$plantel."'  
					ORDER BY idSituacionPlanEstudio DESC";			
		
		$situacionPlanEstudio=$con->obtenerValor($consulta);
		
		
		if($situacionPlanEstudio=="")
			$situacionPlanEstudio=0;
		
		
		if(($idInstancia!=-1)&&($idInstancia!="")&&($idCiclo!=-1)&&($idCiclo!="")&&($idPeriodo!=-1)&&($idPeriodo!=""))
		{
			$consulta="SELECT DISTINCT m.idMateria,CONCAT('[',a.cveMateria,'] ',m.nombreMateria) FROM 4502_Materias m,4512_aliasClavesMateria a,4520_grupos g 
						WHERE m.idMateria=a.idMateria AND a.idMateria=g.idMateria AND a.idInstanciaPlanEstudio=g.idInstanciaPlanEstudio AND g.idInstanciaPlanEstudio=".$idInstancia."
						AND g.idCiclo=".$idCiclo." AND g.idPeriodo=".$idPeriodo;
						
			/*if($situacionPlanEstudio==0)			
			{
				$consultaTmp="SELECT idGradoEstructura FROM 4615_gradosSolicitudAutorizacionEstructura g,4614_cabeceraSolicitudAutorizacionEstructura s,4546_estructuraPeriodo e
							 WHERE s.idRegistro=g.idSolicitud AND s.situacion=2 AND g.dictamen=1 AND e.idEstructuraPeriodo=g.idGradoEstructura 
							 AND e.idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." AND idInstanciaPlanEstudio=".$idInstancia;
				$listaGrados=$con->obtenerListaValores($consultaTmp);
				if($listaGrados=="")
					$listaGrados=-1;
					
				$consulta.=" and idGradoCiclo in (".$listaGrados.")";	
					
			}*/
	
						
			$consulta.=" ORDER BY m.nombreMateria";
						
			$registros=$con->obtenerFilasArreglo($consulta);						
		}
		echo "1|".$registros;
		
	}
	
	function obtenerGruposMateriasCicloPeriodoInstancia()
	{
		global $con;
		$idInstancia=$_POST["idInstancia"];
		$idCiclo=$_POST["idCiclo"];
		$idMateria=$_POST["idMateria"];
		$idPeriodo=$_POST["idPeriodo"];
		$registros="[]";
		if(($idInstancia!=-1)&&($idInstancia!="")&&($idCiclo!=-1)&&($idCiclo!="")&&($idPeriodo!=-1)&&($idPeriodo!="")&&($idMateria!=-1)&&($idMateria!=""))
		{
			$consulta="SELECT DISTINCT g.idGrupos,nombreGrupo,idGradoCiclo,situacion FROM 4520_grupos g 
						WHERE g.idInstanciaPlanEstudio=".$idInstancia."
						AND g.idCiclo=".$idCiclo." AND g.idPeriodo=".$idPeriodo." and g.idMateria=".$idMateria." ORDER BY nombreGrupo";
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$instanciaComparte="";
				$materiaComparte="";
				$grupoComparte="";
				if($fila[3]==2)
				{
					$consulta="SELECT idGrupo FROM 4539_gruposCompartidos WHERE  idGrupoReemplaza=".$fila[0];
					$idGrupoReemplaza=$con->obtenerValor($consulta);
					$consulta="SELECT idInstanciaPlanEstudio,nombreGrupo,m.nombreMateria FROM 4520_grupos g,4502_Materias m WHERE g.idGrupos=".$idGrupoReemplaza." AND  g.idMateria=m.idMateria";
					$fGrupoReemplaza=$con->obtenerPrimeraFila($consulta);
					$instanciaComparte=obtenerNombreInstanciaPlan($fGrupoReemplaza[0]);
					$materiaComparte=$fGrupoReemplaza[2];
					$grupoComparte=$fGrupoReemplaza[1];
				}
				
				$oA="['".$fila[0]."','".cv($fila[1])."','".$fila[2]."','".$fila[3]."','".cv($instanciaComparte)."','".cv($materiaComparte)."','".cv($grupoComparte)."']";
				if($registros=="[]")
					$registros=$oA;
				else
					$registros.=",".$oA;
			}
			$registros="[".$registros."]";
		}
		echo "1|".$registros;
		
	}
	
	function obtenerAsistenciaAlumnoPeriodo()
	{
		global $con;
		global $arrDiasSemana;
		
		$idUsuario=-1;
		$fInicio="";
		$fFin="";
		$plantel="";
		$tMovimiento="";
		$idProfesor="-1";
		$idFormulario=-1;
		$idRegistro=-1;
		$compl="";
		$listGrupos="-1";
		$arrAsignaciones=array();
		if(!isset($_POST["idFormulario"]))
		{
			$idUsuario=$_POST["iU"];
			$fInicio=$_POST["fInicio"];
			$fFin=$_POST["fFin"];
			$plantel=$_POST["plantel"];
			$tMovimiento=$_POST["tMovimiento"];
		}
		else
		{
			$idFormulario=$_POST["idFormulario"];
			$idRegistro=$_POST["idRegistro"];
			
			$consulta="SELECT dteFechaInicial,dteFechaFinal,tipoRegistro,cmbPlanEstudio,cmbTipoMovimientos,codigoInstitucion,cmdAlumno,responsable FROM _744_tablaDinamica WHERE id__744_tablaDinamica=".$idRegistro;
			$fRegistro=$con->obtenerPrimeraFila($consulta);

			$idUsuario=$fRegistro[6];
			$fInicio=$fRegistro[0];
			$fFin=$fRegistro[1];
			$plantel=$fRegistro[5];
			$tMovimiento=$fRegistro[4];
			$idInstancia=$fRegistro[3];
			$idProfesor=$fRegistro[7];
			if($tMovimiento==1)
				$tMovimiento=0;
			else
				$tMovimiento=1;
			if($fRegistro[2]=="")
			{
				
				$consulta="SELECT a.idGrupo,a.fechaAsignacion,a.fechaBaja FROM 4520_grupos g,4519_asignacionProfesorGrupo a
							WHERE g.idInstanciaPlanEstudio=".$idInstancia." and a.idUsuario=".$idProfesor." AND a.idGrupo=g.idGrupos AND a.fechaAsignacion<=a.fechaBaja
							and ".generarConsultaIntervalos($fInicio,$fFin,"a.fechaAsignacion","a.fechaBaja");

				$resAsig=$con->obtenerFilas($consulta);
				while($fAsig=mysql_fetch_row($resAsig))
				{
					$arrAsignaciones[$fAsig[0]][0]=strtotime($fAsig[1]);
					$arrAsignaciones[$fAsig[0]][1]=strtotime($fAsig[2]);
					if($listGrupos=="-1")
						$listGrupos=$fAsig[0];
					else
						$listGrupos.=",".$fAsig[0];
				}
				$compl=" and idGrupos in (".$listGrupos.")";
			}
			
			
		}
		$arrAsistencia="";
		$arrAux=array();
		$arrInstancias=array();
		$lblAsistencia="";
		if($tMovimiento==0)
			$lblAsistencia="Falta en";
		else
			$lblAsistencia="Asistencia en";
		
		
		if(($idUsuario!=-1)&&($fInicio!="")&&($fFin!="")&&($tMovimiento!==""))
		{
			
			$consulta="SELECT l.idAsistencia,l.idGrupo,l.noSesion,l.fechaSesion,g.idInstanciaPlanEstudio,concat('[',g.nombreGrupo,'] ',m.nombreMateria) as nomGrupo FROM 4531_listaAsistencia l,4520_grupos g,4502_Materias m,4530_sesiones s WHERE 
						l.idAlumno=".$idUsuario." AND tipo=".$tMovimiento." and l.fechaSesion>='".$fInicio."' and l.fechaSesion<='".$fFin."'
						AND g.idGrupos=l.idGrupo and m.idMateria=g.idMateria  AND Plantel='".$plantel."' and l.idAlumno=".$idUsuario." and s.noSesion=l.noSesion and s.idGrupo=l.idGrupo and s.situacionAsistencia=2".$compl."
						order by l.fechaSesion";
			
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$considerar=true;
				if(sizeof($arrAsignaciones)>0)
				{
					$fSesion=strtotime($fila[3]);
					if(!(($fSesion>=$arrAsignaciones[$fila[1]][0])&&($fSesion<=$arrAsignaciones[$fila[1]][1])))
					{
						$considerar=false;
					}
					
				}
				if($considerar)
				{
					$nomInstancia="";
					if(!isset($arrInstancias[$fila[4]]))
					{
						$arrInstancias[$fila[4]]=obtenerNombreInstanciaPlan($fila[4]);
					}
					$nomInstancia=$arrInstancias[$fila[4]];
					if(!isset($arrAux[$nomInstancia]))
					{
						$arrAux[$nomInstancia]=array();
					}
					if(!isset($arrAux[$nomInstancia][$fila[5]]))
						$arrAux[$nomInstancia][$fila[5]]=array();
					$objSesion[0]=$fila[0];
					$objSesion[1]=$fila[2];
					$objSesion[2]=$fila[3];
					$objSesion[3]=$fila[1];
	
					array_push($arrAux[$nomInstancia][$fila[5]],$objSesion);
				}
			}
			
			if(sizeof($arrAux)>0)
			{
				foreach($arrAux as $nIntancia=>$resto)
				{
					ksort($arrAux[$nIntancia]);
				}
				ksort($arrAux);
				$nInstancia=0;
				foreach($arrAux as $nombreInstancia=>$resto)
				{
					$listGrupos="";
					$nGrupo=0;
					foreach($resto as $grupo=>$arrSesiones)
					{
						$listSesion="";
						foreach($arrSesiones as $sesion)
						{
							$chkRegistro='false';
							if(($idFormulario!=-1)&&($idRegistro!=-1))
							{
								$consulta="SELECT COUNT(*) FROM 4590_registroMovAsistencia WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND idAsistencia=".$sesion[0] ;
								$nReg=$con->obtenerValor($consulta);
								if($nReg>0)
									$chkRegistro='true';
							}
							$fSesion=strtotime($sesion[2]);
							$lblHorario="";
							$consulta="SELECT GROUP_CONCAT(horario) FROM 4530_sesiones WHERE idGrupo=".$sesion[3]." AND noSesion=".$sesion[1];
							$lblHorario=$con->obtenerValor($consulta);
							$oSesion='{"icon":"../images/s.gif","id":"'.$sesion[0].'","text":"<b>'.$lblAsistencia.' Sesión: '.$sesion[1].'</b> ('.utf8_encode($arrDiasSemana[date("w",$fSesion)])." ".date("d/m/Y",$fSesion).', Horario: '.$lblHorario.')","leaf":true,"checked":'.$chkRegistro.'}';
							if($listSesion=="")
								$listSesion=$oSesion;
							else
								$listSesion.=",".$oSesion;
						}
						$oGrupos='{"icon":"../images/s.gif","id":"g_'.$nGrupo.'","text":"<b>Grupo:</b> '.cv($grupo).'","leaf":false,"expanded":true,"children":['.$listSesion.']}';
						if($listGrupos=="")
							$listGrupos=$oGrupos;
						else
							$listGrupos.=",".$oGrupos;
						$nGrupo++;
					}
					$oAsistencia='{"icon":"../images/s.gif","id":"i_'.$nInstancia.'","text":"<b>Plan de estudios:</b> '.cv($nombreInstancia).'","leaf":false,"expanded":true,"children":['.$listGrupos.']}';
					if($arrAsistencia=="")
						$arrAsistencia=$oAsistencia;
					else
						$arrAsistencia.=",".$oAsistencia;
					$nInstancia++;
					
				}
			}			
		}		
		echo "[".$arrAsistencia."]";
	}
	
	function registrarSesionesModificacionAsistencia()
	{
		global $con;
		$valor=0;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$query="SELECT dteFechaInicial,dteFechaFinal,tipoRegistro,cmbPlanEstudio,cmbTipoMovimientos,codigoInstitucion,cmdAlumno,responsable FROM _744_tablaDinamica WHERE id__744_tablaDinamica=".$obj->idRegistro;
		$fRegistro=$con->obtenerPrimeraFila($query);
		if($fRegistro[4]==1)
			$valor=2;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 4590_registroMovAsistencia WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idRegistro;
		$x++;
		$arrSesiones=explode(",",$obj->arrAsistencia);
		foreach($arrSesiones as $s)
		{
			$consulta[$x]="INSERT INTO 4590_registroMovAsistencia(idFormulario,idReferencia,idAsistencia,valorAsignar) VALUES(".$obj->idFormulario.",".$obj->idRegistro.",".$s.",".$valor.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
			
	}
	
	function obtenerAsistenciaAlumnoPeriodoVista()
	{
		global $con;
		global $arrDiasSemana;
		
		
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$query="SELECT dteFechaInicial,dteFechaFinal,tipoRegistro,cmbPlanEstudio,cmbTipoMovimientos,codigoInstitucion,cmdAlumno,responsable FROM _744_tablaDinamica WHERE id__744_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFila($query);
		$tMovimiento=$fRegistro[4];
		$compl="";
		$listGrupos="-1";
		$arrAsignaciones=array();
		
		$arrAsistencia="";
		$arrAux=array();
		$arrInstancias=array();
		$lblAsistencia="";
		if($tMovimiento==0)
			$lblAsistencia="Falta en";
		else
			$lblAsistencia="Asistencia en";
		$consulta="SELECT idAsistencia FROM 4590_registroMovAsistencia WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$listaAsistencia=$con->obtenerListaValores($consulta);
		if($listaAsistencia=="")
			$listaAsistencia=-1;
		$consulta="SELECT l.idAsistencia,l.idGrupo,l.noSesion,l.fechaSesion,g.idInstanciaPlanEstudio,concat('[',g.nombreGrupo,'] ',m.nombreMateria) as nomGrupo FROM 4531_listaAsistencia l,4520_grupos g,4502_Materias m,4530_sesiones s WHERE 
					g.idGrupos=l.idGrupo and m.idMateria=g.idMateria  and s.noSesion=l.noSesion and s.idGrupo=l.idGrupo and l.idAsistencia in (".$listaAsistencia.") order by l.fechaSesion";
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$nomInstancia="";
			if(!isset($arrInstancias[$fila[4]]))
			{
				$arrInstancias[$fila[4]]=obtenerNombreInstanciaPlan($fila[4]);
			}
			$nomInstancia=$arrInstancias[$fila[4]];
			if(!isset($arrAux[$nomInstancia]))
			{
				$arrAux[$nomInstancia]=array();
			}
			if(!isset($arrAux[$nomInstancia][$fila[5]]))
				$arrAux[$nomInstancia][$fila[5]]=array();
			$objSesion[0]=$fila[0];
			$objSesion[1]=$fila[2];
			$objSesion[2]=$fila[3];
			$objSesion[3]=$fila[1];

			array_push($arrAux[$nomInstancia][$fila[5]],$objSesion);
			
		
		}
		if(sizeof($arrAux)>0)
		{
			foreach($arrAux as $nIntancia=>$resto)
			{
				ksort($arrAux[$nIntancia]);
			}
			ksort($arrAux);
			$nInstancia=0;
			foreach($arrAux as $nombreInstancia=>$resto)
			{
				$listGrupos="";
				$nGrupo=0;
				foreach($resto as $grupo=>$arrSesiones)
				{
					$listSesion="";
					foreach($arrSesiones as $sesion)
					{
						
						$fSesion=strtotime($sesion[2]);
						$lblHorario="";
						$consulta="SELECT GROUP_CONCAT(horario) FROM 4530_sesiones WHERE idGrupo=".$sesion[3]." AND noSesion=".$sesion[1];
						$lblHorario=$con->obtenerValor($consulta);
						$oSesion='{"icon":"../images/s.gif","id":"'.$sesion[0].'","text":"<b>'.$lblAsistencia.' Sesión: '.$sesion[1].'</b> ('.utf8_encode($arrDiasSemana[date("w",$fSesion)])." ".date("d/m/Y",$fSesion).', Horario: '.$lblHorario.')","leaf":true}';
						if($listSesion=="")
							$listSesion=$oSesion;
						else
							$listSesion.=",".$oSesion;
					}
					$oGrupos='{"icon":"../images/s.gif","id":"g_'.$nGrupo.'","text":"<b>Grupo:</b> '.cv($grupo).'","leaf":false,"expanded":true,"children":['.$listSesion.']}';
					if($listGrupos=="")
						$listGrupos=$oGrupos;
					else
						$listGrupos.=",".$oGrupos;
					$nGrupo++;
				}
				$oAsistencia='{"icon":"../images/s.gif","id":"i_'.$nInstancia.'","text":"<b>Plan de estudios:</b> '.cv($nombreInstancia).'","leaf":false,"expanded":true,"children":['.$listGrupos.']}';
				if($arrAsistencia=="")
					$arrAsistencia=$oAsistencia;
				else
					$arrAsistencia.=",".$oAsistencia;
				$nInstancia++;
				
			}
		}
			
		
		
		echo "[".$arrAsistencia."]";
	}
	
	
	function registrarSesionesModificacionAsistenciaResponsable()
	{
		global $con;
		$valor=0;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$instanciaPlan=0;
		$arrSesiones=explode(",",$obj->arrAsistencia);
		foreach($arrSesiones as $s)
		{
			$query="SELECT idInstanciaPlanEstudio FROM 4531_listaAsistencia l,4520_grupos g WHERE idAsistencia=".$s." AND g.idGrupos=l.idGrupo";
			$instanciaPlan=$con->obtenerValor($query);
			break;
		}
		
		
		if($obj->tipoMovimiento==1)
			$valor=2;
		$idDocumento="NULL";
		if(($obj->idDocumento!="")&&($obj->idDocumento!="-1"))
			$idDocumento=registrarDocumentoServidor($obj->idDocumento,$obj->nombreDocumento);	
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO _744_tablaDinamica(fechaCreacion,responsable,idEstado,codigoInstitucion,dteFechaInicial,dteFechaFinal,txtDescripcion,datDocumento,cmdAlumno,cmbTipoMovimientos,tipoRegistro,cmbPlanEstudio,cmbTipoJustificacion)
						VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",1,'".$obj->plantel."','".$obj->fechaInicio."','".$obj->fechaFin."','".cv($obj->descripcion)."',".$idDocumento.",".$obj->idAlumno.",".
						$obj->tipoMovimiento.",1,".$instanciaPlan.",".$obj->idMotivoJustificacion.")";
		$x++;
		$consulta[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		
		
		foreach($arrSesiones as $s)
		{
			$consulta[$x]="INSERT INTO 4590_registroMovAsistencia(idFormulario,idReferencia,idAsistencia,valorAsignar) VALUES(".$obj->idFormulario.",@idRegistro,".$s.",".$valor.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$query="select @idRegistro";	
			$idRegistro=$con->obtenerValor($query);
			cambiarEtapaFormulario($obj->idFormulario,$idRegistro,3);
			echo "1|";
		}
			
	}
	
	
	function obtenerPlanEstudiosProgramasEducativos()
	{
		global $con;
		$idPrograma=$_POST["idPrograma"];
		$plantel=$_POST["plantel"];
		$arrPlanEstudio="[]";
		$arrAux=array();
		if(($idPrograma!=-1)&&($idPrograma!=""))
		{
			$consulta="SELECT  DISTINCT i.idInstanciaPlanEstudio,i.idPeriodicidad FROM 4513_instanciaPlanEstudio i,4500_planEstudio pl WHERE 
						pl.idPlanEstudio=i.idPlanEstudio AND pl.idProgramaEducativo=".$idPrograma." and i.sede='".$plantel."'";
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$nInstancia=obtenerNombreInstanciaPlan($fila[0]);
				$arrAux[$nInstancia][0]=$fila[0];
				$arrAux[$nInstancia][1]=cv($nInstancia);
				$consulta="SELECT id__464_gridPeriodos,nombrePeriodo,periodoDefaultActivo FROM _464_gridPeriodos WHERE idReferencia=".$fila[1];
				$arrPeriodos=$con->obtenerFilasArreglo($consulta);
				$arrAux[$nInstancia][2]=$arrPeriodos;
			}
			ksort($arrAux);
			foreach($arrAux as $o)
			{
				$oA="['".$o[0]."','".$o[1]."',".$o[2]."]";
				if($arrPlanEstudio=="[]")
					$arrPlanEstudio=$oA;
				else
					$arrPlanEstudio.=",".$oA;
			}
			$arrPlanEstudio="[".$arrPlanEstudio."]";
		}
		echo "1|".$arrPlanEstudio;
	}
	
	function obtenerProfesoresGrupo()
	{
		global $con;
		$idGrupo=$_POST["idGrupo"];
		$idSolicitud=$_POST["idSolicitud"];
		$arrRegistros="";
		$arrAsignaciones=obtenerFechasAsignacionGrupoV2($idGrupo,$idSolicitud,true,true,"","",0);
		$arrAsignaciones=normalizarFechasAsignacionProfesores($arrAsignaciones,$idGrupo,$idSolicitud);
		if(sizeof($arrAsignaciones)>0)
		{
			foreach($arrAsignaciones as $a)
			{
				$consulta="SELECT descParticipacion FROM 953_elementosPerfilesParticipacionAutor WHERE idElementoPerfilAutor=".$a[8];
				$tipoAsignacion=$con->obtenerValor($consulta);
				$o='{"idAsignacion":"'.$a[0].'","idUsuario":"'.$a[5].'","nombreProfesor":"'.obtenerNombreUsuario($a[5]).'","periodoInicio":"'.$a[6].'","periodoFin":"'.$a[7].'","tipoAsignacion":"'.$tipoAsignacion.'","cveAsignacion":"'.$a[8].'"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
					
			}
		}
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerAsignacionesProfesorGrupo()
	{
		global $con;
		$idAsignacion=$_POST["idAsignacion"];
		$idProfesor=$_POST["idProfesor"];
		$idSolicitud=$_POST["idSolicitud"];
		$fechaInicio=date("Y-m-d");
		$fechaFin=strtotime("+2 years",strtotime(date("Y-m-d")));
		$arrAsignaciones=obtenerAsignacionesProfesor($idProfesor,$idSolicitud,$fechaInicio,date("Y-m-d",$fechaFin));
		
		
		$cadRegistros="";
		if(sizeof($arrAsignaciones)>0)
		{
			$numReg=0;
			foreach($arrAsignaciones as $a)
			{
				
				$consulta="SELECT Plantel FROM 4520_grupos WHERE idGrupos=".$a[1];
				$plantel=$con->obtenerValor($consulta);
				if(($a[0]==$idAsignacion)||($plantel!=$_SESSION["codigoInstitucion"]))
				{
					continue;
				}
				
				
				
				$comentarioBaja="";
				$consulta="SELECT idInstanciaPlanEstudio FROM 4520_grupos WHERE idGrupos=".$a[1];
				$idInstanciaPlan=$con->obtenerValor($consulta);
				$consulta="SELECT descParticipacion FROM 953_elementosPerfilesParticipacionAutor WHERE idElementoPerfilAutor=".$a[8];
				$tipoAsignacion=$con->obtenerValor($consulta);
				$permiteBaja="";
				if($a[8]!=37)
					$permiteBaja=1;
				else
				{
					$arrAsignaciones=obtenerFechasAsignacionGrupoV2($a[1],$idSolicitud,true,true,$fechaInicio,date("Y-m-d",$fechaFin),1);
					
					if(sizeof($arrAsignaciones)>0)
					{
						$oUltimo=$arrAsignaciones[sizeof($arrAsignaciones)-1];
						
						if($oUltimo[0]==$a[0])
						{
							$permiteBaja=1;
						}
						else
						{
							$permiteBaja=0;
							$comentarioBaja="No es la última asignación vigente del grupo";
						}
					}
				}
				$o='{"idGrupo":"'.$a[1].'","cveAsignacion":"'.$a[8].'","idAsignacion":"'.$a[0].'","grupo":"'.obtenerNombreGrupoMateria($a[1]).'","planEstudios":"'.obtenerNombreInstanciaPlan($idInstanciaPlan).'","tipoAsignacion":"'.$tipoAsignacion
					.'","periodoInicio":"'.$a[6].'","periodoFin":"'.$a[7].'","permiteBaja":"'.$permiteBaja.'","comentarioBaja":"'.cv($comentarioBaja).'","noParticipa":false,"ultimoDiaLabores":""}';
				$numReg++;
				if($cadRegistros=="")
					$cadRegistros=$o;
				else
					$cadRegistros.=",".$o;
			}
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$cadRegistros.']}';
	}
	
	function obtenerCalificacionesAlumno()
	{
		global $con;
		$arrCalificaciones="";
		$idUsuario=$_POST["idUsuario"];
		$idGrupo=$_POST["idGrupo"];
		$consulta="SELECT idInstanciaPlanEstudio,idPlanEstudio,idMateria FROM 4520_grupos where idGrupos=".$idGrupo;
		$fGrupos=$con->obtenerPrimeraFila($consulta);
		$idInstancia=$fGrupos[0];
		$idPlanEstudio=$fGrupos[1];
		$idMateria=$fGrupos[2];
		
		
		
		$consulta="SELECT idPerfilEvaluacion FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$fGrupos[0]; 	
		$idReferenciaExamenes=$con->obtenerValor($consulta);
		$consulta="SELECT e.idTipoExamen,tipoExamen FROM 4622_catalogoTipoExamen e,4625_tiposExamenPerfilEvaluacion t WHERE t.idPerfil=".$idReferenciaExamenes.
				" AND  t.idTipoExamen=e.idTipoExamen ORDER BY t.prioridad";
		$res=$con->obtenerFilas($consulta);
		$nReg=0;
		while($fila=mysql_fetch_row($res))
		{
			
			$consulta="SELECT idPerfil,calificacionMinimaAprobatoria,idPerfilEvaluacionMateria FROM 4592_configuracionPerfilEvaluacion WHERE 
					idInstanciaPlanEstudio in(".$idInstancia.",-1) AND idMateria in(".$idMateria.",-1) and idGrupo in (".$idGrupo.",-1) AND tipoExamen=".$fila[0]." AND noExamen=1".
					" order by idPlanEstudio desc ,idInstanciaPlanEstudio desc,idMateria desc,idGrupo desc";
			
			
			
			$fPerfil=$con->obtenerPrimeraFila($consulta);
			
			if(!$fPerfil)			
			{
				$fPerfil[0]=obtenerValorConfiguracionEvaluacion($idReferenciaExamenes,$fila[0],12);//Perfil de evaluacion
				$fPerfil[1]=obtenerValorConfiguracionEvaluacion($idReferenciaExamenes,$fila[0],13);//Calificacionminima aprobatoria
				$fPerfil[2]="-1";
				
			}
			
			$comp="";
			$mostrarSolicitud=true;
			
			$referencia="";
					
		
			$formaAplicacion=obtenerValorConfiguracionEvaluacion($idReferenciaExamenes,$fila[0],1);//Forma de aplicacion
			
			if($formaAplicacion==2)
			{
		
				$idConcepto=obtenerValorConfiguracionEvaluacion($idReferenciaExamenes,$fila[0],3);//Concepto asociado
				if(($idConcepto=="")||($idConcepto==0))
				{
					$idConcepto=-1;	
				}
				$arrFunciones="";
				$cache=NULL;
				$consulta="SELECT idFuncion FROM 4606_funcionesConfiguracionPerfilEvaluacion WHERE tipoFuncion=2 AND idPerfilEvaluacionMateria=".$fPerfil[2];
			
				$resFunc=$con->obtenerFilas($consulta);
				while($fFuncion=mysql_fetch_row($resFunc))
				{
					$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$fFuncion[0];
					$nombreFuncion=$con->obtenerValor($consulta);
					
					
					$cTmp='{"idUsuario":"'.$idUsuario.'","idInstanciaPlanEstudio":"'.$idInstancia.'","idMateria":"'.$idMateria.'","idGrupo":"'.$idGrupo.'","tipoEvaluacion":"'.$fila[0].'","noEvaluacion":"1"}';
					$objTmp=json_decode($cTmp);
					$objTmp->objUsr=json_decode($obj);
					$oResp=removerComillasLimite(resolverExpresionCalculoPHP($fFuncion[0],$objTmp,$cache));
  
					if($oResp=='0')
					{
						$mostrarSolicitud=false;	
					}
					$o="['".cv($nombreFuncion)."','".$oResp."']";
					if($arrFunciones=="")
						$arrFunciones=$o;
					else		
						$arrFunciones.=",".$o;
						
				}
				
				
				
				if($mostrarSolicitud)
				{
					$consulta="SELECT id__736_tablaDinamica FROM _736_tablaDinamica WHERE idUsuarioRegistro=".$idUsuario." AND idGrupo=".$idGrupo." AND idTipoExamen=".$fila[0];
					$idRegistro=$con->obtenerValor($consulta);
					if($idRegistro=="")
					{
						$comp="&nbsp;&nbsp;<a href='javascript:abrirSolicitudExamen(\\\"".bE(736)."\\\",\\\"".bE(-1)."\\\",\\\"".bE(193)."\\\",\\\"".bE("[['idUsuarioRegistro',".$idUsuario."],['idGrupo',".$idGrupo."],['idTipoExamen',".$fila[0]."],['noEvaluacion',1],['cPagina','sFrm=true']]")."\\\")'><img width=13 height=13 src='../images/pencil.png'> Solicitar exámen</a>";
					}
					else
					{
						$referencia=obtenerReferenciaPagoFormulario(736,$idRegistro,$idConcepto,$idUsuario);
						$comp="&nbsp;&nbsp;<a href='javascript:abrirSolicitudExamen(\\\"".bE(736)."\\\",\\\"".bE($idRegistro)."\\\",\\\"".bE(785)."\\\",\\\"".bE("[['idUsuarioRegistro',".$idUsuario."],['idGrupo',".$idGrupo."],['idTipoExamen',".$fila[0]."],['noEvaluacion',1],['cPagina','sFrm=true']]")."\\\")'><img width=13 height=13 src='../images/magnifier.png'> Ver solicitud de exámen</a>";
					}
				}
				else
				{
					$comp="&nbsp;&nbsp;<img src='../images/cross.png' width=13 height=13>&nbsp;Sin derecho a solicitar, <a href='javascript:verDetallesSinDerecho(\\\"".bE($fila[0])."\\\",\\\"".bE("[".$arrFunciones."]")."\\\")'>ver detalles...</a>";
				}
			}
				
		
			$consulta="SELECT valor FROM 4569_calificacionesEvaluacionAlumnoPerfilMateria WHERE idAlumno=".$idUsuario." AND idGrupo=".$idGrupo." AND tipoEvaluacion=".$fila[0];
			$valor=$con->obtenerValor($consulta);
			if($valor=="")
				$valor="N/E";
				
				
			
			$calificacionMinima=$fPerfil[1];
			
			
			$compTotal='';
			$funcionRenderer="";
			$rendererCalificacion=obtenerValorConfiguracionEvaluacion($idReferenciaExamenes,$fila[0],8);//Función renderer
			
			if($rendererCalificacion!="0")
			{
				$consulta="SELECT nombreFuncionJS FROM 9033_funcionesScriptsSistema WHERE idFuncion=".$rendererCalificacion;
				$funcionRenderer=$con->obtenerValor($consulta);
				
			}
			else
			{
				$funcionRenderer="formateoEstandar";
			}	
				
			
			
			
			$obj='{"referencia":"'.$referencia.'","idTipoExamen":"'.$fila[0].'","nombreExamen":"'.$fila[1].'","calificacion":"'.$valor.'","comp":"'.($comp).'","noExamen":"1","funcionRenderer":"'.$funcionRenderer.'","calificacionMinima":"'.$calificacionMinima.'"}';
			if($arrCalificaciones=="")
				$arrCalificaciones=$obj;
			else
				$arrCalificaciones.=",".$obj;
				$nReg++;
			
		}
		echo '{"numReg":"'.$nReg.'","registros":['.$arrCalificaciones.']}';
		
	}
	
	function obtenerDiaHabilProximo()
	{
		$fecha=$_POST["fecha"];
		$plantel=$_POST["plantel"];
		$tOperacion=$_POST["tOperacion"];
		$fecha=obtenerFechaMinimaOperacionAMES($fecha,$tOperacion,$plantel);
		echo "1|".$fecha;
	}
	
	function obtenerProgramasEducativosPlantel()
	{
		global $con;	
		$plantel=$_POST["plantel"];
		$consulta="SELECT idProgramaEducativo,nombreProgramaEducativo FROM 4500_programasEducativos where idProgramaEducativo 
				in (SELECT DISTINCT p.idProgramaEducativo FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE p.idPlanEstudio=i.idPlanEstudio AND i.sede='".$plantel."') order by nombreProgramaEducativo";
		$arrRegistros=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrRegistros."";
	}
	
	function obtenerInstanciasPlanEstudioPlantelProgramaEducativo()
	{
		global $con;
		
		$arrPrograma=array();
		$plantel=$_POST["plantel"];
		$idProgramaEducativo=$_POST["idProgramaEducativo"];
		
		$consulta="SELECT idInstanciaPlanEstudio FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE i.idPlanEstudio=p.idPlanEstudio AND i.sede='".$plantel."' AND p.idProgramaEducativo=".$idProgramaEducativo;
		$res=$con->obtenerFilas($consulta);	
		while($fila=mysql_fetch_row($res))
		{
			$nomInstancia=obtenerNombreInstanciaPlan($fila[0]);
			$arrPrograma[$nomInstancia."_".$fila[0]]["nombre"]=$nomInstancia;
			$arrPrograma[$nomInstancia."_".$fila[0]]["idInstancia"]=$fila[0];
		}
		ksort($arrPrograma);
		
		$cadRegistros="";
		$numReg=0;
		foreach($arrPrograma as $registro)
		{
			$o='{"idInstanciaPlan":"'.$registro["idInstancia"].'","nombreInstanciaPlan":"'.cv($registro["nombre"]).'"}';
			if($cadRegistros=="")
				$cadRegistros=$o;
			else
				$cadRegistros.=",".$o;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$cadRegistros.']}';
	}


	function obtenerInstanciasPlanEstudioPlantelProgramaEducativoArreglo()
	{
		global $con;
		
		$arrPrograma=array();
		$plantel=$_POST["plantel"];
		$idProgramaEducativo=$_POST["idProgramaEducativo"];
		
		$consulta="SELECT idInstanciaPlanEstudio FROM 4513_instanciaPlanEstudio i,4500_planEstudio p WHERE i.idPlanEstudio=p.idPlanEstudio AND i.sede='".$plantel."' AND p.idProgramaEducativo=".$idProgramaEducativo;
		$res=$con->obtenerFilas($consulta);	
		while($fila=mysql_fetch_row($res))
		{
			$nomInstancia=obtenerNombreInstanciaPlan($fila[0]);
			$arrPrograma[$nomInstancia."_".$fila[0]]["nombre"]=$nomInstancia;
			$arrPrograma[$nomInstancia."_".$fila[0]]["idInstancia"]=$fila[0];
		}
		ksort($arrPrograma);
		
		$cadRegistros="";
		$numReg=0;
		foreach($arrPrograma as $registro)
		{
			$o="['".$registro["idInstancia"]."','".cv($registro["nombre"])."']";
			if($cadRegistros=="")
				$cadRegistros=$o;
			else
				$cadRegistros.=",".$o;
			$numReg++;
		}
		echo '1|['.$cadRegistros.']';
	}
	
	function obtenerMateriasInstanciaPlan()
	{
		global $con;
		$idInstanciaPlan=$_POST["idInstanciaPlan"];	
		$consulta="SELECT a.idMateria,CONCAT('[',a.cveMateria,'] ',m.nombreMateria) FROM 4512_aliasClavesMateria a,4502_Materias m WHERE idInstanciaPlanEstudio=".$idInstanciaPlan."
					AND m.idMateria=a.idMateria ORDER BY m.nombreMateria";
		$registros=$con->obtenerFilasArreglo($consulta);	
		echo "1|".$registros;					
	}
	
	function obtenerConfiguracionEvaluacionMateria()
	{
		global $con;
		$idInstanciaPlan=$_POST["idInstanciaPlan"];
		$idMateria=$_POST["idMateria"];
		$idReferenciaExamenes=obtenerPerfilExamenesAplica("",$idInstanciaPlan);
		$consulta="SELECT id__721_tablaDinamica,e.examen,g.noExamen,g.etiquetaExamen,asentarMateriaRevalidacion,g.asistencia,g.fechaAsignacion
				FROM _398_gridTiposExamen g,_721_tablaDinamica t,_720_tablaDinamica e WHERE g.idReferencia=".$idReferenciaExamenes." 
				AND t.id__721_tablaDinamica=g.tipoExamen AND e.id__720_tablaDinamica=t.examen   ORDER BY t.prioridadAplicaExamen";
		$arrReg="";
		$resExamenes=$con->obtenerFilas($consulta);	
		while($fExamen=mysql_fetch_row($resExamenes))
		{
			
			$consulta="SELECT idPerfil,calificacionMinimaAprobatoria,idPerfilEvaluacionMateria FROM 4592_configuracionPerfilEvaluacion  WHERE idInstanciaPlanEstudio=".$idInstanciaPlan." 
						AND idMateria=".$idMateria." AND tipoExamen=".$fExamen[0]." AND noExamen=".$fExamen[2];
			$fCal=$con->obtenerPrimeraFila($consulta);
			if(!$fCal)
			{
				$fCal[0]="";
				$fCal[1]="";
				$fCal[2]="-1";
			}
			
			$consulta="SELECT idFuncion ,c.nombreConsulta FROM 4606_funcionesConfiguracionPerfilEvaluacion f,991_consultasSql c WHERE c.idConsulta=f.idFuncion AND idPerfilEvaluacionMateria=".$fCal[2]." 
					AND tipoFuncion=1 ORDER BY idFuncionPerfilConfiguracion";
			$funcionesDisparadoras=$con->obtenerFilasArreglo($consulta);
			$consulta="SELECT idFuncion ,c.nombreConsulta FROM 4606_funcionesConfiguracionPerfilEvaluacion f,991_consultasSql c WHERE c.idConsulta=f.idFuncion AND idPerfilEvaluacionMateria=".$fCal[2]." 
						AND tipoFuncion=2 ORDER BY idFuncionPerfilConfiguracion";
			$funcionesSolicitud=$con->obtenerFilasArreglo($consulta);
			
			$o="['".$fExamen[0]."','".$fExamen[2]."','".cv($fExamen[3])."','".$fExamen[4]."','".$fCal[0]."','".$fCal[1]."','".$fExamen[5]."','".$fExamen[6]."',".$funcionesDisparadoras.",".$funcionesSolicitud."]";
			if($arrReg=="")
				$arrReg=$o;
			else
				$arrReg.=",".$o;
		}
		echo "1|[".$arrReg."]";
	}
	
	function registrarConfiguracionEvaluacionInstanciaPlan()
	{
		global $con;	
		
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$cadObj=$_POST["cObj"];
		$obj=json_decode($cadObj);
		$arrInstancias=explode(",",$obj->instanciaPlanEstudio);
		foreach($arrInstancias as $i)
		{
			$consulta="SELECT sede,idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$i;
			$fInstancia=$con->obtenerPrimeraFila($consulta);
			
			$consulta="SELECT id__398_tablaDinamica FROM _398_tablaDinamica WHERE  idInstanciaPlanEstudio=".$i;
			
			$idReferenciaExamenes=$con->obtenerValor($consulta);
			if($idReferenciaExamenes=="")
			{
				$query[$x]="INSERT INTO _398_tablaDinamica(idReferencia,fechaCreacion,responsable,idEstado,codigoUnidad,codigoInstitucion,idPlanEstudio,idInstanciaPlanEstudio)
							VALUES(".$i.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",0,'".$fInstancia[0]."','".$fInstancia[0]."',".$fInstancia[1].",".$i.")";
				$x++;	
				
				$query[$x]="set @idConfiguracion:=(select last_insert_id())";
				$x++;
				$query[$x]="UPDATE _398_tablaDinamica SET codigo=id__398_tablaDinamica WHERE id__398_tablaDinamica=@idConfiguracion";
				$x++;
			}
			else
			{
				$query[$x]="set @idConfiguracion:=".$idReferenciaExamenes;
				$x++;
				$query[$x]="UPDATE _398_tablaDinamica SET fechaModif='".date("Y-m-d H:i:s")."',respModif=".$_SESSION["idUsr"]." WHERE id__398_tablaDinamica=@idConfiguracion";
				$x++;
				$query[$x]="DELETE FROM _398_gridTiposExamen WHERE idReferencia=".$idReferenciaExamenes;
				$x++;
			}
			
			
			
			
			foreach($obj->arrExamenes as $o)
			{
				$query[$x]="INSERT INTO _398_gridTiposExamen(idReferencia,tipoExamen,noExamen,etiquetaExamen,asentarMateriaRevalidacion,asistencia,fechaAsignacion)
							VALUES(@idConfiguracion,".$o->idTipoExamen.",".$o->noExamen.",'".cv($o->etiquetaExamen)."',".$o->asientaCalificacion.",".$o->porcentajeAsistencia.",".$o->validacionAsignacionFechas.")";
				$x++;
				
				$consulta="SELECT idMateria FROM 4512_aliasClavesMateria WHERE idInstanciaPlanEstudio=".$i;
				$resMateria=$con->obtenerFilas($consulta);
				while($fMateria=mysql_fetch_row($resMateria))
				{
					$consulta="SELECT idPerfilEvaluacionMateria FROM 4592_configuracionPerfilEvaluacion where  idInstanciaPlanEstudio=".$i." and idMateria=".$fMateria[0]." and idGrupo=-1 and tipoExamen=".$o->idTipoExamen." and noExamen=".$o->noExamen;
					$listPerfilesEval=$con->obtenerListaValores($consulta);
					if($listPerfilesEval=="")
						$listPerfilesEval=-1;
					
					$query[$x]="delete from  4592_configuracionPerfilEvaluacion where  idInstanciaPlanEstudio=".$i." and idMateria=".$fMateria[0]." and idGrupo=-1 and tipoExamen=".$o->idTipoExamen." and noExamen=".$o->noExamen;
					$x++;
					
					$query[$x]="DELETE FROM 4606_funcionesConfiguracionPerfilEvaluacion WHERE idPerfilEvaluacionMateria IN(".$listPerfilesEval.")";
					$x++;
			
					$query[$x]="INSERT INTO 4592_configuracionPerfilEvaluacion(idPlanEstudio,idInstanciaPlanEstudio,idMateria,idGrupo,tipoExamen,noExamen,idPerfil,calificacionMinimaAprobatoria) 
								VALUES(".$fInstancia[1].",".$i.",".$fMateria[0].",-1,".$o->idTipoExamen.",".$o->noExamen.",".$o->perfilEvaluacion.",".$o->calificacionAprobatoria.")";
					$x++;
					
					$query[$x]="set @idRegistro:=(select last_insert_id())";
					$x++;
		
					if(sizeof($o->funcionesDisparadoras)>0)
					{
						foreach($o->funcionesDisparadoras as $f)
						{
							$query[$x]="INSERT INTO 4606_funcionesConfiguracionPerfilEvaluacion(idFuncion,tipoFuncion,idPerfilEvaluacionMateria) VALUES(".$f->idFuncion.",1,@idRegistro)";
							$x++;
						}
						foreach($o->funcionesSolicitud as $f)
						{
							$query[$x]="INSERT INTO 4606_funcionesConfiguracionPerfilEvaluacion(idFuncion,tipoFuncion,idPerfilEvaluacionMateria) VALUES(".$f->idFuncion.",2,@idRegistro)";
							$x++;
						}
					}
					
				}
			}
		}
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	
	function obtenerSituacionMateriasReinscripcion()
	{
		global $con;
		global $arrDiasSemana;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$idUsuario=$_POST["idUsuario"];
		$idGrado=$_POST["idGrado"];
		$idPeriodo=$_POST["idPeriodo"];
		$idCiclo=$_POST["idCiclo"];
		$idInstanciaPlan=$_POST["idInstanciaPlan"];
		
		$idOferta=$_POST["idOferta"];
		
		$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstanciaPlan;
		$idPlanEstudio=$con->obtenerValor($consulta);
		$arrRegistros="";
		$numReg=0;
		if($idOferta==-1)
		{
			$listMateriaIgn="";
			
			$consulta="SELECT id__721_tablaDinamica FROM _721_tablaDinamica WHERE cmbCalificacionfinal=1";
			$listEvaluacionesFinales=$con->obtenerListaValores($consulta);
			if($listEvaluacionesFinales=="")
				$listEvaluacionesFinales=-1;
			$consulta="SELECT codigoUnidad FROM 4505_estructuraCurricular WHERE idUnidad=".$idGrado." AND tipoUnidad=3";
			$codigoPadre=$con->obtenerValor($consulta);
			$consulta="SELECT * FROM 4505_estructuraCurricular WHERE codigoPadre='".$codigoPadre."' AND idPlanEstudio=".$idPlanEstudio;			
			$res=$con->obtenerFilas($consulta);
			while($fReg=mysql_fetch_row($res))
			{
				if($fReg[3]=="1")
				{
					if($listMateriaIgn=="")
						$listMateriaIgn=$fReg[2];
					else
						$listMateriaIgn.=",".$fReg[2];
						
						
						
					$consulta="SELECT m.nombreMateria,a.noHorasSemana,numeroCredito,a.idMateria FROM  4502_Materias m,4512_aliasClavesMateria a WHERE a.idMateria=".$fReg[2]." AND a.idMateria=m.idMateria AND a.idInstanciaPlanEstudio=".$idInstanciaPlan;
					$fMateria=$con->obtenerPrimeraFila($consulta);
					$situacion=0;
					$inscribe=0;
					$arrCadMateriasIncumplidas="";				
					$consulta="SELECT count(*) FROM 4569_calificacionesEvaluacionAlumnoPerfilMateria WHERE idAlumno=".$idUsuario." AND tipoEvaluacion IN(".$listEvaluacionesFinales.") AND idMateria=".$fReg[2]." and aprobado=1";
					$nReg=$con->obtenerValor($consulta);
					if($nReg==0)
					{
						$arrMateriasIncumple=obtenerMateriasIncumplePrerrequisitos($idUsuario,$fReg[2]);
						if(sizeof($arrMateriasIncumple)>0)
						{
							$situacion=1;
							foreach($arrMateriasIncumple as $iMateria)	
							{
								$consulta="SELECT nombreMateria FROM 4502_Materias WHERE idMateria=".$iMateria;
								$nMateria=cv($con->obtenerValor($consulta));	
								if($arrCadMateriasIncumplidas=="")
									$arrCadMateriasIncumplidas=$nMateria;
								else
									$arrCadMateriasIncumplidas.=", ".$nMateria;
							}
						}
						
						
					}
					else
						$situacion=2;
					switch($situacion)
					{
						
						case 1:
							$inscribe=0;
							$arrCadMateriasIncumplidas="No se han acreditado las siguientes materias prerequisito: ".$arrCadMateriasIncumplidas;
						break;	
						case 2:
							$inscribe=2;
							$arrCadMateriasIncumplidas="La materia ya ha sido acreditada";
						break;	
						default:
							$inscribe=1;
							$arrCadMateriasIncumplidas="";
						break;
					}
					// 
					$idGrupoMateria=-1;
					$ultimoGrupo=-1;
					if(($situacion!=1)&&($situacion!=2))
					{
						$consulta="SELECT idGrupos,situacion FROM 4520_grupos WHERE idInstanciaPlanEstudio=".$idInstanciaPlan." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." AND idMateria=".$fReg[2]." ORDER BY idGrupos";
						
						$rGrupo=$con->obtenerFilas($consulta);
						while($fGrupo=mysql_fetch_row($rGrupo))
						{
							$idGrupo=$fGrupo[0];
							if($fGrupo[1]==2)
							{
								$consulta="SELECT idGrupo FROM 4539_gruposCompartidos WHERE idGrupoReemplaza=".$idGrupo;
								$idGrupo=$con->obtenerValor($consulta);	
								
							}
							
							$consulta="select cupoMaximo from 4520_grupos where idGrupos=".$idGrupo;
							$cupoMaximo=$con->obtenerValor($consulta);
							$consulta="SELECT COUNT(*) FROM 4517_alumnosVsMateriaGrupo WHERE idUsuario=".$idUsuario." AND idGrupo=".$idGrupo;
							$nMaximo=$con->obtenerValor($consulta);
							if($nMaximo<$cupoMaximo)
							{
								
								$idGrupoMateria=$idGrupo;	
							}
							$ultimoGrupo=$idGrupo;
							
						}
						if($idGrupoMateria==-1)
							$idGrupoMateria=$ultimoGrupo;
					}
					$nombreGrupo="Sin grupo asignado";
					$nombreInstanciaGrupo="";
					$horarioReg="";
					$lblHorario="<table><tr><td class='corpo8_bold' align='center' width='100'><b>D&iacute;a</b></td><td class='corpo8_bold' align='center' width='100'>".
								"<b>Hora</b></td><td class='corpo8_bold' align='center' width='250'><b>Aula</b></td></tr>".
								"<tr height='1'><td colspan='3' style='background-color:#900'></td></tr>";
					if($idGrupoMateria!="-1")
					{
						$consulta="SELECT nombreGrupo,idInstanciaPlanEstudio FROM 4520_grupos WHERE idGrupos=".$idGrupoMateria;
						$fGpo=$con->obtenerPrimeraFila($consulta);
						$nombreGrupo=$fGpo[0];
						$nombreInstanciaGrupo=obtenerNombreInstanciaPlan($fGpo[1]);
						$consulta="SELECT MIN(fechaInicio) FROM 4522_horarioGrupo WHERE idGrupo=".$idGrupoMateria." AND fechaInicio<fechaFin";
						$fechaInicio=$con->obtenerValor($consulta);
						if($fechaInicio!="")
						{
							$consulta="SELECT dia,horaInicio,horaFin,(SELECT nombreArea FROM 9309_ubicacionesFisicas WHERE idAreaFisica=h.idAula) as aula FROM 4522_horarioGrupo h 
										WHERE idGrupo=".$idGrupoMateria." AND fechaInicio='".$fechaInicio."' and fechaInicio<fechaFin order by dia";
							$rHorario=$con->obtenerFilas($consulta);
							while($fHorario=mysql_fetch_row($rHorario))
							{
								$o="['".$fHorario[0]."','".$fHorario[1]."','".$fHorario[2]."','".$fHorario[3]."']";	
								if($horarioReg=="")
									$horarioReg=$o;
								else
									$horarioReg.=",".$o;
								$lblHorario.="<tr height='18'><td align='left'><b>".cv(utf8_encode($arrDiasSemana[$fHorario[0]]))."</b></td><td align='right'> ".date("H:i",strtotime($fHorario[1]))." - ".date("H:i",strtotime($fHorario[2]))."</td><td align='right'>".$fHorario[3]."</td></tr>";
							}
						}
					}
					$lblHorario.="</table>";
					$o='{"horarioReg":['.$horarioReg.'],"instanciaPlan":"'.cv($nombreInstanciaGrupo).'","inscribe":"'.$inscribe.'","idMateria":"'.$fReg[2].'","idGrupo":"'.$idGrupoMateria.'","nombreMateria":"'.cv($fMateria[0]).
						'","creditos":"'.$fMateria[2].'","horasSemana":"'.$fMateria[1].'","grupo":"'.cv($nombreGrupo).'","idCategoria":"1","horario":"'.$lblHorario.'","comentarios":"'.$arrCadMateriasIncumplidas.'","situacion":"'.$situacion.'"}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else	
						$arrRegistros.=",".$o;
					$numReg++;
				}
				
			}
			
			$consulta="SELECT m.idMateria,m.nombreMateria,a.noHorasSemana,m.numeroCredito FROM 4607_materiasAdeudoAlumno mA,4502_Materias m,4512_aliasClavesMateria a  WHERE mA.idAlumno=".$idUsuario." AND mA.idInstanciaPlan=".$idInstanciaPlan." 
						AND mA.situacion=1 AND m.idMateria=mA.idMateria and a.idMateria=m.idMateria AND a.idInstanciaPlanEstudio=mA.idInstanciaPlan ORDER BY m.nombreMateria";
			$res=$con->obtenerFilas($consulta);
			while($fMateria=mysql_fetch_row($res))
			{
				if($listMateriaIgn=="")
					$listMateriaIgn=$fMateria[0];
				else
					$listMateriaIgn.=",".$fMateria[0];
				$o='{"horarioReg":[],"instanciaPlan":"","inscribe":"1","idMateria":"'.$fMateria[0].'","idGrupo":"-1","nombreMateria":"'.cv($fMateria[1]).
						'","creditos":"'.$fMateria[3].'","horasSemana":"'.$fMateria[2].'","grupo":"Sin grupo asignado","idCategoria":"2","horario":"","comentarios":"","situacion":"0"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else	
					$arrRegistros.=",".$o;
				$numReg++;
			}
			
			$consulta="SELECT idCiclo,idPeriodo FROM 4529_alumnos WHERE idUsuario=".$idUsuario." AND idInstanciaPlanEstudio=".$idInstanciaPlan." ORDER BY idAlumnoTabla desc";
			$fCiclo=$con->obtenerPrimeraFila($consulta);
			if($fCiclo)
			{
				$consulta="SELECT id__721_tablaDinamica FROM _721_tablaDinamica WHERE cmbCalificacionfinal=1";
				$listEvaluacionesFinales=$con->obtenerListaValores($consulta);
				$consulta="SELECT a.idMateria  FROM 4517_alumnosVsMateriaGrupo a,4520_grupos g WHERE idUsuario=".$idUsuario." AND a.idMateria NOT IN (".$listMateriaIgn.") 
						AND g.idGrupos=a.idGrupo AND g.idCiclo=".$fCiclo[0]." AND g.idPeriodo=".$fCiclo[1]." AND g.idInstanciaPlanEstudio=".$idInstanciaPlan;
				$resMatCiclo=$con->obtenerFilas($consulta);	
				while($fMatCiclo=mysql_fetch_row($resMatCiclo))
				{
					$consulta="SELECT COUNT(*) FROM 4569_calificacionesEvaluacionAlumnoPerfilMateria c WHERE idAlumno=".$idUsuario." AND idMateria=".$fMatCiclo[0]." AND aprobado=1 AND tipoEvaluacion IN (".$listEvaluacionesFinales.")";
					$nReg=$con->obtenerValor($consulta);
					if($nReg==0)
					{
						$consulta="SELECT m.nombreMateria,a.noHorasSemana,numeroCredito,a.idMateria FROM  4502_Materias m,4512_aliasClavesMateria a WHERE a.idMateria=".$fMatCiclo[0]." 
									AND a.idMateria=m.idMateria AND a.idInstanciaPlanEstudio=".$idInstanciaPlan;
						$fMateria=$con->obtenerPrimeraFila($consulta);
						$o='{"horarioReg":[],"instanciaPlan":"","inscribe":"0","idMateria":"'.$fMateria[3].'","idGrupo":"-1","nombreMateria":"'.cv($fMateria[0]).
							'","creditos":"'.$fMateria[2].'","horasSemana":"'.$fMateria[1].'","grupo":"Sin grupo asignado","idCategoria":"2","horario":"","comentarios":"","situacion":"0"}';
						if($arrRegistros=="")
							$arrRegistros=$o;
						else	
							$arrRegistros.=",".$o;
						$numReg++;
					}
				}
			}
		}
		else
		{
			$consulta="SELECT m.idMateria,idGrupo,idCategoria,m.nombreMateria,a.noHorasSemana,numeroCredito,a.idMateria,e.situacion,e.comentarios FROM 4609_elementosOfertaAcademica e,4502_Materias m,4512_aliasClavesMateria a WHERE idOfertaAcademica=".$idOferta." 
					and m.idMateria=e.idMateria and a.idMateria=e.idMateria and a.idInstanciaPlanEstudio=".$idInstanciaPlan;
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$inscribe=0;
				if($fila[1]!=-1)
					$inscribe=1;
					
				$nombreGrupo="Sin grupo asignado";
				$nombreInstanciaGrupo="";
				$horarioReg="";
				$lblHorario="<table><tr><td class='corpo8_bold' align='center' width='100'><b>D&iacute;a</b></td><td class='corpo8_bold' align='center' width='100'>".
							"<b>Hora</b></td><td class='corpo8_bold' align='center' width='250'><b>Aula</b></td></tr>".
							"<tr height='1'><td colspan='3' style='background-color:#900'></td></tr>";
				if($fila[1]!="-1")
				{
					$consulta="SELECT nombreGrupo,idInstanciaPlanEstudio FROM 4520_grupos WHERE idGrupos=".$fila[1];
					$fGpo=$con->obtenerPrimeraFila($consulta);
					$nombreGrupo=$fGpo[0];
					$nombreInstanciaGrupo=obtenerNombreInstanciaPlan($fGpo[1]);
					$consulta="SELECT MIN(fechaInicio) FROM 4522_horarioGrupo WHERE idGrupo=".$fila[1]." AND fechaInicio<fechaFin";
					$fechaInicio=$con->obtenerValor($consulta);
					if($fechaInicio!="")
					{
						$consulta="SELECT dia,horaInicio,horaFin,(SELECT nombreArea FROM 9309_ubicacionesFisicas WHERE idAreaFisica=h.idAula) as aula FROM 4522_horarioGrupo h 
									WHERE idGrupo=".$fila[1]." AND fechaInicio='".$fechaInicio."' and fechaInicio<fechaFin order by dia";
						$rHorario=$con->obtenerFilas($consulta);
						while($fHorario=mysql_fetch_row($rHorario))
						{
							$o="['".$fHorario[0]."','".$fHorario[1]."','".$fHorario[2]."','".$fHorario[3]."']";	
							if($horarioReg=="")
								$horarioReg=$o;
							else
								$horarioReg.=",".$o;
							$lblHorario.="<tr height='18'><td align='left'><b>".cv(utf8_encode($arrDiasSemana[$fHorario[0]]))."</b></td><td align='right'> ".date("H:i",strtotime($fHorario[1]))." - ".date("H:i",strtotime($fHorario[2]))."</td><td align='right'>".$fHorario[3]."</td></tr>";
						}
					}
				}
				$lblHorario.="</table>";	
					
				$o='{"horarioReg":['.$horarioReg.'],"instanciaPlan":"'.cv($nombreInstanciaGrupo).'","inscribe":"'.$inscribe.'","idMateria":"'.$fila[0].'","idGrupo":"'.$fila[1].'","nombreMateria":"'.cv($fila[3]).
					'","creditos":"'.$fila[5].'","horasSemana":"'.$fila[4].'","grupo":"'.cv($nombreGrupo).'","idCategoria":"'.$fila[2].'","horario":"'.$lblHorario.'","comentarios":"'.cv($fila[8]).'","situacion":"'.$fila[7].'"}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else	
					$arrRegistros.=",".$o;
				$numReg++;
			}
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function registrarOfertaCargaAcademica()
	{
		global $con;	
		
		$cadObj=$_POST["cadObj"];	
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$obj=json_decode($cadObj);
		$idOferta=$obj->idOferta;
		if($idOferta==-1)
		{
			
			$consulta[$x]="INSERT INTO 4608_ofertaCargasAcademicas(descripcion,idFormulario,idReferencia,cargaSeleccionada,idAlumno,idIstanciaPlan,costoCarga)
						VALUES('".cv($obj->comentarios)."',".$obj->idFormulario.",".$obj->idReferencia.",0,".$obj->idAlumno.",".$obj->idIstanciaPlan.",".$obj->costoCarga.")";
			$x++;
			$consulta[$x]="set @idOferta:=(select last_insert_id())";
			$x++;
			
		}
		else
		{
			$consulta[$x]="set @idOferta:=".$idOferta;
			$x++;
			$consulta[$x]="update 4608_ofertaCargasAcademicas set descripcion='".cv($obj->comentarios)."',costoCarga=".$obj->costoCarga." where idOfertaAcademica=@idOferta";
			$x++;
			$consulta[$x]="delete from 4609_elementosOfertaAcademica where idOfertaAcademica=@idOferta";
			$x++;
		}
		
		if(sizeof($obj->arrMaterias)>0)
		{
			foreach($obj->arrMaterias as $m)	
			{
				$consulta[$x]="INSERT INTO 4609_elementosOfertaAcademica(idMateria,idGrupo,idCategoria,idOfertaAcademica,situacion,comentarios)
							VALUES(".$m->idMateria.",".$m->idGrupo.",".$m->idCategoria.",@idOferta,".$m->situacion.",'".cv($m->comentarios)."')";
				$x++;
			}
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$query="select @idOferta";
			
			$idOferta=$con->obtenerValor($query);
			$query="select idOfertaAcademica,descripcion,costoCarga from 4608_ofertaCargasAcademicas where idFormulario=".$obj->idFormulario." and idReferencia=".$obj->idReferencia."  order by idOfertaAcademica";
			$res=$con->obtenerFilas($query);
			$arrOferta="";
			$nReg=1;
			while($fOferta=mysql_fetch_row($res))
			{
				$o="['".$fOferta[0]."','Opción ".$nReg."','".cv($fOferta[1])."','".$fOferta[2]."']";
				if($arrOferta=="")
					$arrOferta=$o;
				else
					$arrOferta.=",".$o;
				$nReg++;
			}
			echo "1|".$idOferta."|[".$arrOferta."]";	
		}
	}
	
	function obtenerMateriasDisponiblesInscripcion()
	{
		global $con;
		$idAlumno=$_POST["idAlumno"];
		$idInstancia=$_POST["idInstancia"];
		$idPeriodo=$_POST["idPeriodo"];
		$idCiclo=$_POST["idCiclo"];
		
		$formato=1;
		if(isset($_POST["formato"]))
			$formato=2;
		$numReg=0;
		$arrRegistros="";
		$o="";
		$consulta="SELECT distinct m.idMateria,m.nombreMateria,numeroCredito FROM 4520_grupos g,4502_Materias m WHERE g.situacion=1 AND 
					idInstanciaPlanEstudio=".$idInstancia." AND m.idMateria=g.idMateria and idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." 
					ORDER BY m.nombreMateria";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			if(!esMateriaAcreditada($idAlumno,$fila[0]))
			{
				$arrMateriasIncumple=obtenerMateriasIncumplePrerrequisitos($idAlumno,$fila[0]);
				if(sizeof($arrMateriasIncumple)==0)
				{
					$consulta="SELECT noHorasSemana FROM 4512_aliasClavesMateria WHERE idInstanciaPlanEstudio=".$idInstancia." AND idMateria=".$fila[0];
					$noHoras=$con->obtenerValor($consulta);
					
					if($formato==1)
						$o="['".$fila[0]."','".cv($fila[1])."','".$fila[2]."','".$noHoras."']";
					else
						$o='{"idMateria":"'.$fila[0].'","nombreMateria":"'.cv($fila[1]).'","noCreditos":"'.$fila[2].'","horasSemana":"'.$noHoras.'"}';
					
					
					
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
					$numReg++;
				}
			}
		}
		if($formato==1)
			echo "1|[".$arrRegistros."]";
		else
			echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerGruposDisponiblesInscripcion()
	{
		global $con;
		global $arrDiasSemana;
		$idInstancia=$_POST["idInstancia"];
		$idPeriodo=$_POST["idPeriodo"];
		$idCiclo=$_POST["idCiclo"];
		$idMateria=$_POST["idMateria"];
		
		
		$consulta="SELECT sede,idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idInstancia;
		$fInstancia=$con->obtenerPrimeraFila($consulta);
		$plantel=$fInstancia[0];
		$idPlanEstudio=$fInstancia[1];
		
		$consulta="SELECT idGrupos,nombreGrupo,idMateria FROM 4520_grupos WHERE idInstanciaPlanEstudio=".$idInstancia." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." AND idMateria=".$idMateria." and situacion=1 ORDER BY nombreGrupo";
		$arrRegistros="";
		$res=$con->obtenerFilas($consulta);
		$numReg=0;
		while($fila=mysql_fetch_row($res))
		{
			$horarioReg="";
			$lblHorario="<table><tr><td class='corpo8_bold' align='center' width='100'><b>D&iacute;a</b></td><td class='corpo8_bold' align='center' width='100'>".
						"<b>Hora</b></td><td class='corpo8_bold' align='center' width='250'><b>Aula</b></td></tr>".
						"<tr height='1'><td colspan='3' style='background-color:#900'></td></tr>";
			$consulta="SELECT MIN(fechaInicio) FROM 4522_horarioGrupo WHERE idGrupo=".$fila[0]." AND fechaInicio<fechaFin";
			$fechaInicio=$con->obtenerValor($consulta);
			if($fechaInicio!="")
			{
				$consulta="SELECT dia,horaInicio,horaFin,(SELECT nombreArea FROM 9309_ubicacionesFisicas WHERE idAreaFisica=h.idAula) as aula FROM 4522_horarioGrupo h 
							WHERE idGrupo=".$fila[0]." AND fechaInicio='".$fechaInicio."' and fechaInicio<fechaFin order by dia";
				$rHorario=$con->obtenerFilas($consulta);
				while($fHorario=mysql_fetch_row($rHorario))
				{
					$o="['".$fHorario[0]."','".$fHorario[1]."','".$fHorario[2]."','".$fHorario[3]."']";	
					if($horarioReg=="")
						$horarioReg=$o;
					else
						$horarioReg.=",".$o;
					$lblHorario.="<tr height='18'><td align='left'><b>".cv(utf8_encode($arrDiasSemana[$fHorario[0]]))."</b></td><td align='right'> ".date("H:i",strtotime($fHorario[1]))." - ".date("H:i",strtotime($fHorario[2]))."</td><td align='right'>".$fHorario[3]."</td></tr>";
				}
			}
			
			$lblHorario.="</table>";	
				
			$o='{"horarioReg":['.$horarioReg.'],"idGrupos":"'.$fila[0].'","nombreGrupo":"'.cv($fila[1]).'","horario":"'.$lblHorario.'","idMateria":"'.$fila[2].'","idPlanEstudio":"'.$idPlanEstudio.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else	
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function marcarCargaSeleccionada()
	{
		global $con;
		$idCarga=$_POST["idCarga"];	
		$idFormulario=$_POST["idFormulario"];	
		$idRegistro=$_POST["idRegistro"];	
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="UPDATE 4608_ofertaCargasAcademicas SET cargaSeleccionada=0 WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$x++;
		$query[$x]="UPDATE 4608_ofertaCargasAcademicas SET cargaSeleccionada=1 WHERE idOfertaAcademica= ".$idCarga;
		$x++;
		$query[$x]="insert into  4610_cargaAcademicaSeleccionada (idFormulario,idReferencia,idCargaSeleccionada) values(".$idFormulario.",".$idRegistro.",".$idCarga.")";
		$x++;
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
		{
			//cambiarEtapaFormulario($idFormulario,$idRegistro,"2");
			echo "1|";	
		}
	}
	
	function publicarOfertasCargaAcademica()
	{
		global $con;
		
		$idFormulario=$_POST["idFormulario"];	
		$idRegistro=$_POST["idRegistro"];	
		cambiarEtapaFormulario($idFormulario,$idRegistro,"1.6");
		echo "1|";	
		
	}
	
	function obtenerCalendariosTipoPerfil()
	{
		global $con;
		$arrCalendarios="";
		$consulta="SELECT idCategoria,nombreCategoria,color FROM 4502_categoriaMaterias";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$obj='	{
						"id":"'.$fila[0].'",
						"title":"'.cv($fila[1]).'"
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
	
	function obtenerEventosCalendarioTipoPerfil()
	{
		global $con;
		$idPerfil=$_POST["idPerfil"];
		
		
		$arrFechas[0]="2011-06-05";
		$arrFechas[1]="2011-06-06";		
		$arrFechas[2]="2011-06-07";
		$arrFechas[3]="2011-06-08";
		$arrFechas[4]="2011-06-09";
		$arrFechas[5]="2011-06-10";
		$arrFechas[6]="2011-06-11";
		
		$arrCategorias[0]="Sin categoría";
		$consulta="SELECT idCategoria,nombreCategoria FROM 4502_categoriaMaterias ORDER BY idCategoria";
		$rCategoria=$con->obtenerFilas($consulta);
		while($fCategoria=mysql_fetch_row($rCategoria))
		{
			$arrCategorias[$fCategoria[0]]=$fCategoria[1];
		}
		
		$arrRegistros="";
		
		$consulta="SELECT horaInicial,horaFinal,idCategoriaMateria,idRegistro,dia FROM 4627_horariosPerfilMateria WHERE idPerfil=".$idPerfil;
		$res=$con->ObtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$titulo='Bloque materias tipo: '.cv($arrCategorias[$fila[2]]).' <a href="javascript:removerBloque(\''.bE($fila[3]).'\')"><img src="../images/delete.png" title="Remover bloque" alt="Remover bloque"/></a>';
			$o='	{	
						"id": "'.$fila[3].'",
						"cid": "'.$fila[2].'",
						"title": "'.cv($titulo).'",
						"start": "'.$arrFechas[$fila[4]].' '.$fila[0].'",
						"end": "'.$arrFechas[$fila[4]].' '.$fila[1].'",
						"ad": 0,
						"notes": "",
						"loc":"",
						"url":"",
						"rem":"",
						"rO":0,
						"tipoEvento":"0"
					}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		
		echo '{"evts":['.$arrRegistros.']}';
	}
	
	function obtenerConfiguracionHorarioInstanciaPlan()
	{
		global $con;
		$idIntanciaPlan=$_POST["idIntanciaPlan"];
		
		$numReg=0;
		$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$idIntanciaPlan;
		$idPlanEstudio=$con->obtenerValor($consulta);
		$arrRegistros="";
		$consulta="SELECT g.idGrado,g.leyendaGrado FROM 4505_estructuraCurricular e,4501_Grado g WHERE e.idPlanEstudio=".$idPlanEstudio." AND tipoUnidad=3 AND g.idGrado=e.idUnidad ORDER  BY g.ordenGrado";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$consulta="SELECT idPerfil FROM 4628_perfilHorarioGrado WHERE idInstanciaPlan=".$idIntanciaPlan." AND idGrado=".$fila[0];
			$idPerfil=$con->obtenerValor($consulta);
			
			$o='{"idGrado":"'.$fila[0].'","lblGrado":"'.cv($fila[1]).'","idPerfil":"'.$idPerfil.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
				
			$numReg++;
			
		}
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
		
	}
	
	function registrarConfiguracionInstanciaPlan()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="DELETE FROM 4628_perfilHorarioGrado WHERE idInstanciaPlan=".$obj->idInstancia;
		$x++;
		
		foreach($obj->arrRegistros as $r)
		{
			$query[$x]="INSERT INTO 4628_perfilHorarioGrado(idInstanciaPlan,idGrado,idPerfil) VALUES(".$obj->idInstancia.",".$r->idGrado.",".$r->idPerfil.")";
			$x++;
		}
		
		$query[$x]="commit";
		$x++;
		
		eB($query);
		
		
		
	}
	
	
	function obtenerEstructuraCurricularPredecesor()
	{
		global $con;
		global $dic;
		$arrTemas="";
		$idPlanEstudio=$_POST["idPlanEstudio"];
		$tUnidad=$dic["grado"]["s"]["et"];
		$idEstructura=$_POST["idEstructura"];
		
		
		$consulta="SELECT idUnidadPredecesora,codigoUnidad FROM 4505_estructuraCurricular WHERE idEstructuraCurricular=".$idEstructura;
		$fEstructura=$con->obtenerPrimeraFila($consulta);
		
		$idElementoPredecesor=$fEstructura[0];
		$grado=substr($fEstructura[1],0,3);
		
		
		$consulta="SELECT idUnidad FROM 4505_estructuraCurricular WHERE tipoUnidad=3 AND codigoUnidad='".$grado."' AND idPlanEstudio=".$idPlanEstudio;
		
		$idGrado=$con->obtenerValor($consulta);
		
		
		$consulta="select ordenGrado from 4501_Grado where idGrado=".$idGrado;
		$ordenGrado=$con->obtenerValor($consulta);
		
		$consulta="SELECT idGrado FROM 4501_Grado WHERE idPlanEstudio=".$idPlanEstudio." AND ordenGrado<".$ordenGrado." ORDER BY ordenGrado";
		$idGrados=$con->obtenerListaValores($consulta);
		if($idGrados=="")
			$idGrados=-1;
		
		
		$consulta="SELECT idEstructuraCurricular,g.leyendaGrado,descripcion,codigoUnidad,maxOPC,minOPC FROM 4505_estructuraCurricular e, 4501_Grado g 
					WHERE g.idGrado=e.idUnidad AND e.idPlanEstudio=".$idPlanEstudio." and nivel=1 AND tipoUnidad=3 AND e.idUnidad IN(".$idGrados.") 
					ORDER BY  ordenGrado";
		$resMateria=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resMateria))
		{
			$obj='{clave:"",codigoUnidad:"'.$fila[3].'",id:"'.$fila[0].'",descripcion:"",nUnidad:"'.cv($fila[1]).
				'",text:"<span style=\'color:#030\'><b>'.cv($fila[1]).'</b></span>",tipoUnidad:"'.$tUnidad.'",tUnidad:"3",naturaleza:"",idNaturaleza:"",noCreditos:"N/A",totalHoras:"",horasTSemana:"",horasPSemana:"",horasISemana:"",maxOPC:"'.$fila[4].'",minOPC:"'.$fila[5].'"';
			$hijos=obtenerMateriasHijosPredecesor($idPlanEstudio,$fila[3],$idEstructura,$idElementoPredecesor);				

			if($hijos=='[]')
				$obj.=',leaf:true,icon:"../images/table_row_insert.png"}';
			else
				$obj.=',children:'.$hijos.',icon:"../images/table_row_insert.png"}';
			if($arrTemas=="")
				$arrTemas=$obj;
			else
				$arrTemas.=",".$obj;
		}
		echo "[".$arrTemas."]";
	}
	
	function obtenerMateriasHijosPredecesor($idPlanEstudio,$codigoPadre,$idEstructura,$idElementoPredecesor)
	{
		global $con;
		global $dic;
		$tUnidad="";
		$arrTemas="";
		$consulta="select * from (
				SELECT idEstructuraCurricular,tipoUnidad,n.abreviatura,e.naturalezaMateria,codigoUnidad,
				(if(tipoUnidad=1,(select nombreMateria FROM 4502_Materias WHERE idMateria=e.idUnidad),
				(select nombreUnidad from 4508_unidadesContenedora where idUnidadContenedora=e.idUnidad))) as nombreUnidad,
				maxOPC,minOPC ,e.idUnidad,
				if(tipoUnidad=1,(select cveMateria FROM 4502_Materias WHERE idMateria=e.idUnidad),'') as clave,
				if(tipoUnidad=1,
					(select idCategoriaMateria FROM 4502_Materias WHERE idMateria=e.idUnidad),
					(select idCategoria FROM 4508_unidadesContenedora WHERE idUnidadContenedora=e.idUnidad)
				) as idCategoria 
				FROM 4505_estructuraCurricular e,4507_naturalezaMateria n 
				WHERE n.idNaturalezaMateria=e.naturalezaMateria and e.idPlanEstudio=".$idPlanEstudio." and codigoPadre='".$codigoPadre."') as tmp   order by idCategoria,clave";
		$resMateria=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resMateria))
		{
			$noCreditos="";
			$totalHoras="";
			$horasTSemana="";
			$horasPSemana="";
			$horasISemana="";
			$horasSemanales="";
			$icono="s.gif";
			$descripcion="";
			$color="";
			$tipoUnidadC="";
			$comp="";
			if($fila[1]==1)
			{
				$tUnidad=$dic["materia"]["s"]["et"];
				$consulta="SELECT numeroCredito,horaMateriaTotal,horasTeoricasSemanal,horasPracticasSemanal,horasIndependientes,horasSemana,idCategoriaMateria FROM 4502_Materias WHERE idMateria=".$fila[8];
				$filaMat=$con->obtenerPrimeraFila($consulta);
				$noCreditos=$filaMat[0];
				$totalHoras=$filaMat[1];
				$horasTSemana=$filaMat[2];
				$horasPSemana=$filaMat[3];
				$horasISemana=$filaMat[4];
				$horasSemanales=$filaMat[5];
				$icono="text_lowercase.png";
				$color="003";
				$idCategoria=$filaMat[6];
				$consulta="SELECT color FROM 4502_categoriaMaterias WHERE idCategoria=".$idCategoria;
				$colorFondo=$con->obtenerValor($consulta);
				$comp="<span style='width:30px;height:14px;background-color:#".$colorFondo."'>&nbsp;&nbsp;&nbsp;</span>";
			}
			else
			{
				
				$tUnidad="Unidad contenedora";
				$consulta="select descripcion,tipoUnidad,idCategoria from 4508_unidadesContenedora where idUnidadContenedora=".$fila[8];
				$fUnidad=$con->obtenerPrimeraFila($consulta);
				$descripcion=$fUnidad[0];
				$tipoUnidadC=$fUnidad[1];
				if($tipoUnidadC==1)
					$tUnidad="Unidad Agrupadora";
				$color="000";
				$icono="Icono_3d.gif";
				$idCategoria=$fUnidad[2];
				$consulta="SELECT color FROM 4502_categoriaMaterias WHERE idCategoria=".$idCategoria;
				$colorFondo=$con->obtenerValor($consulta);
				$comp="<span style='width:30px;height:14px;background-color:#".$colorFondo."'>&nbsp;&nbsp;&nbsp;</span>";
			}
			
			if($idElementoPredecesor==$fila[0])
				$color="F00";
			
			$obj='{"idCategoria":"'.$idCategoria.'",tipoUnidadC:"'.$tipoUnidadC.'",clave:"'.cv($fila[9]).'",codigoUnidad:"'.$fila[4].'",id:"'.$fila[0].'",nUnidad:"'.cv($fila[5]).'",descripcion:"'.cv($descripcion).
					'",text:"<input type=\'checkbox\' '.(($idElementoPredecesor==$fila[0])?"checked=checked":"").'  name=\'chkSel\' id=\'chk_'.$fila[0].'\' onclick=\'rdoNodoSel(this,event)\'> '.$comp.
					' <span style=\'color:#'.$color.'\'><b>'.cv($fila[5]).'</b></span>",tipoUnidad:"'.$tUnidad.'",tUnidad:"'.$fila[1].'",naturaleza:"'.$fila[2].'",idNaturaleza:"'.$fila[3].'",noCreditos:"'.$noCreditos.
					'",totalHoras:"'.$totalHoras.'",horasTSemana:"'.$horasTSemana.'",horasPSemana:"'.$horasPSemana.'",horasISemana:"'.$horasISemana.'",horasSemanales:"'.$horasSemanales.'",maxOPC:"'.$fila[6].'",minOPC:"'.$fila[7].'"';
			$hijos=obtenerMateriasHijosPredecesor($idPlanEstudio,$fila[4],$idEstructura,$idElementoPredecesor);																								  
			if($hijos=='[]')
				$obj.=',leaf:true,icon:"../images/'.$icono.'"}';
			else
				$obj.=',children:'.$hijos.',icon:"../images/'.$icono.'"}';
			if($arrTemas=="")
				$arrTemas=$obj;
			else
				$arrTemas.=",".$obj;
		}
		return "[".$arrTemas."]";
	}
	
	function asignarMateriaPredecesora()
	{
		global $con;
		$elementoBase=$_POST["elementoBase"];
		$elementoPredecesor=$_POST["elementoPredecesor"];
		
		$consulta="UPDATE 4505_estructuraCurricular SET idUnidadPredecesora=".$elementoPredecesor." WHERE idEstructuraCurricular=".$elementoBase;
		eC($consulta);
		
	}
	
?>