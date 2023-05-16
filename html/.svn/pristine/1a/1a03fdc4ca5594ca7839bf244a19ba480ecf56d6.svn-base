<?php session_start();
	include("conexionBD.php"); 
	
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
		case 1: //Autentificar Usuario
			verificarValor();
		break;
		case 2:
			obtenerRevisoresProyectos();
		break;
		case 3:	
			enviarMailUsuario();
		break;
		case 4:
			asignarDictamenProyecto();
		break;
		case 5:
			obtenerComitesDisponibles();
		break;
		case 6:
			asignarComiteCategoria();
		break;
		case 7:
			removerComiteCategoria();
		break;
		case 8:
			guardarComentariosEval();
		break;
		case 9:
			guadarEvalRequisitos();
		break;
		case 10:
			guardarEvalCat7();
		break;
		case 11:
			marcarProyectosComoEnEsperaCambios();
		break;
		case 12:
			marcarProyectoVoBo();
		break;
		case 13:
			guardarReporteCambiosProyectos();
		break;
		case 14:
			obtenerMateriasProfesor();
		break;
		case 15:
			obtenerAlumnosXSede();
		break;
		case 16:
			obtenerPlanesEstuadiosAperturar();
		break;
		case 17:
			obtenerEstadosDisponibles();
		break;
		case 18:
			obtenerMunicipiosDisponibles();
		break;
		case 19:
			recuperarDatosAccesoOSC();
		break;
		case 20:
			obtenerRevisoresProyectos2012();
		break;
		
		case 21:
			obtenerEstadosDisponiblesV2();
		break;
		case 22:
			obtenerMunicipiosDisponiblesV2();
		break;
		case 23:
			obtenerLocalidadesDisponiblesV2();
		break;
		case 24:
			obtenerCentroCostoEmpresa();
		break;
		case 25:
			obtenerEmpleadosCentroCosto();
		break;
		case 26:
			registrarDiasTrabajadosEmpleadoCC();
		break;
		
	}
	
	function verificarValor()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$valor=bD($_POST["valor"]);
		$campo=bD($_POST["campo"]);
		
		$inserta=$_POST["inserta"];
		$nTabla=obtenerNombreTabla($idFormulario);
		$consulta="select id_".$nTabla." from ".$nTabla." where ".$campo."='".$valor."'";
		
		$idReg=$con->obtenerValor($consulta);
		if($idReg=="")
		{
			if($inserta=="1")
			{
				$consulta="insert into ".$nTabla."(".$campo.") values(".$valor.")";
				if($con->ejecutarConsulta($consulta))
				{
					$idReg=$con->obtenerUltimoID();
					echo "1|".$idReg;
				}
				else
					echo "|";
			}
			else
				$idReg="-1";	
		}
		else
			echo "1|".$idReg;
	}
	
	function obtenerRevisoresProyectos()
	{
		global $con;
		$lP=$_POST["lP"];
		$proyectos=bD($lP);
		$consulta="SELECT distinct idUsuarioRevisor,u.Nombre FROM 955_revisoresProceso r, 800_usuarios u WHERE r.estado in (1,2) and u.idUsuario=r.idUsuarioRevisor and idFormDictamen=-1 AND idReferencia IN (".$proyectos.") order by trim(u.Nombre)";	
		$resRevisores=$con->obtenerFilas($consulta);
		$arrRevisores="";
		while($fila=mysql_fetch_row($resRevisores))
		{
			$nUsuario=$fila[1];
			$consulta="select count(idUsuarioRevisor) FROM 955_revisoresProceso WHERE  estado in (1,2) and idUsuarioRevisor=".$fila[0]." and idReferencia IN (".$proyectos.")";
			$nAsignaciones=$con->obtenerValor($consulta);
			$consulta="select count(idUsuarioRevisor) FROM 955_revisoresProceso WHERE  idUsuarioRevisor=".$fila[0]." and idFormDictamen<>-1 and idReferencia IN (".$proyectos.")";
			$nAsignacionesRealizadas=$con->obtenerValor($consulta);
			$consulta="select Mail from 805_mails where idUsuario=".$fila[0]." limit 0,1";
			$mail=$con->obtenerValor($consulta);
			$obj="['".$fila[0]."','".$nUsuario."','".$nAsignaciones."','".$nAsignacionesRealizadas."','".($nAsignaciones-$nAsignacionesRealizadas)."','".$mail."']";
			if($arrRevisores=="")
				$arrRevisores=$obj;
			else
				$arrRevisores.=",".$obj;
		}
		echo "1|[".$arrRevisores."]";
	}
	
	function enviarMailUsuario()
	{
		global $con;
		$cadObj=$_POST["obj"];	
		$obj=json_decode($cadObj);
		$asunto=$obj->asunto;
		$cuerpo=$obj->cuerpo;
		$listaUsr=$obj->listaUsr;
		$arrResultados="";
		if($listaUsr!="")
		{
			$arrUsuario=explode(",",$listaUsr);
			
			foreach($arrUsuario as $usuario)
			{
				$consulta="select Nombre,(SELECT Mail FROM 805_mails WHERE idUsuario=".$usuario." LIMIT 0,1) as mail from 800_usuarios u where u.idUsuario=".$usuario;	
				$fila=$con->obtenerPrimeraFila($consulta);
				$resultado=0;
				
				if(enviarMail($fila[1],$asunto,$cuerpo))
					$resultado=1;

				$obj="['".$fila[0]."','".$resultado."']";
				if($arrResultados=="")
					$arrResultados=$obj;
				else
					$arrResultados.=",".$obj;
			}
		}
		$arrResultados="[".$arrResultados."]";
		echo "1|".$arrResultados;
	}
	
	function asignarDictamenProyecto()
	{
		global $con;
		$dictamen=$_POST["dictamen"];
		$comentario=$_POST["comentario"];
		$idRegistro=$_POST["idRegistro"];
		$idFormulario=$_POST["idFormulario"];
		$consulta="select * from 1012_dictamenesProyectos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$fila=$con->obtenerPrimeraFila($consulta);
		if($fila)
		{
			$consulta="update 1012_dictamenesProyectos set  dictamen=".$dictamen.",comentarios='".cv($comentario)."',fechaDictamen='".date("Y-m-d")."',idResponsable=".$_SESSION["idUsr"]." where idFormulario=".$idFormulario." and idReferencia=".$idRegistro;	
		}
		else
		{
			$consulta="insert into 1012_dictamenesProyectos(idFormulario,idReferencia,dictamen,comentarios,fechaDictamen,idResponsable) values(".$idFormulario.",".$idRegistro.",".$dictamen.",'".cv($comentario)."','".date("Y-m-d")."',".$_SESSION["idUsr"].")";
		}
		
		eC($consulta);	
	} 
	
	function obtenerComitesDisponibles()
	{
		global $con;
		$idCategoria=$_POST["iC"];
		$consulta="SELECT idComite FROM 1013_comitesCategorias WHERE idCategoria=".$idCategoria;
		$lista=$con->obtenerListaValores($consulta);
		if($lista=="")
			$lista="-1";
		$consulta="SELECT idComite,nombreComite FROM 2006_comites WHERE idComite NOT IN (".$lista.") order by nombreComite";
		$arrComites=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrComites;
		
	}
	
	function asignarComiteCategoria()
	{
		global $con;
		$idComite=$_POST["idComite"];
		$idCategoria=$_POST["idCategoria"];
		$consulta="insert into 1013_comitesCategorias(idComite,idCategoria) values(".$idComite.",".$idCategoria.")";
		eC($consulta);
	}
	
	function removerComiteCategoria()
	{
		global $con;
		$iA=$_POST["iA"];
		
		$consulta="delete from 1013_comitesCategorias where idComitesCategorias=".$iA;
		eC($consulta);
	}
	
	function guardarComentariosEval()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$idProyecto=$obj->idProyecto;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($obj->arrComentarios as $comentario)
		{
			switch($comentario->tipoComentario)
			{
				case 0:
					$consulta[$x]="UPDATE _318_tablaDinamica SET observaciones='".cv($comentario->comentario)."' WHERE id__318_tablaDinamica=".$comentario->idDictamen;
				break;
				case 1:
					$consulta[$x]="UPDATE 1014_comentariosPresupuesto SET comentario='".cv($comentario->comentario)."' WHERE idProyecto=".$idProyecto;
				break;
				case 2:
					$consulta[$x]="UPDATE 1012_dictamenesProyectos SET comentarios='".cv($comentario->comentario)."' WHERE idReferencia=".$idProyecto." and tipoDictamen=0";
				break;
			}
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function guadarEvalRequisitos()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$valor=$_POST["valor"];
		$comentario=$_POST["comentario"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 1015_validacionesRequisitos WHERE codigoInstitucion='".$idProyecto."'";
		$x++;
		$consulta[$x]="insert into 1015_validacionesRequisitos(codigoInstitucion,situacion,comentario) values('".$idProyecto."',".$valor.",'".cv($comentario)."')";
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$consulta="SELECT idUsuario FROM 801_adscripcion WHERE Institucion='".$idProyecto."'";
			$listUsr=$con->obtenerListaValores($consulta);
			if($listUsr=="")
				$listUsr="-1";
			$consulta="SELECT distinct u.idUsuario,u.Login,u.Nombre,u.Password FROM  800_usuarios u WHERE  u.idUsuario in (".$listUsr.")";
			$res=$con->obtenerFilas($consulta);	
			while($fila=mysql_fetch_row($res))
			{
				$cuerpoMail="Estimado _nombreRevisor: <br><br>Como resultado de la validación de documentos de su OSC. se le notifica ue han sido marcados como: \"_dictamen\".<br>Siento acompañado además de los siguientes comentarios:<br><br>\"_comentarios\"<br><br>
							<br>
							<br>
							Sin más por el momento le envio un cordial saludo y le deseo un buen día.<br><br>
							
							<b>Atentamente</b><br>
							Dr. Carlos García de León Moreno<br>
							Director de Prevención y Participación Social<br>
							CENSIDA";
							
				$idUsuario=$fila[0];
				$nombre=$fila[2];
				$login=$fila[1];
				$password=$fila[3];
				$consulta="SELECT distinct Mail FROM 805_mails WHERE idUsuario=".$fila[0];	
				$mail=$con->obtenerValor($consulta);
				//$mail="novant1730@hotmail.com";
				$dictamen="";
				switch($valor)
				{
					case "1":	
						$dictamen='Validado';
					break;
				   
					case "2":
						$dictamen='En espera de cambios';
					break;
					
				}
				if($comentario=="")
					$comentario="Sin comentarios";
					
				$nCuerpo=str_replace("_nombreRevisor",$nombre,$cuerpoMail);
				$nCuerpo=str_replace("_dictamen",$dictamen,$nCuerpo);
				$nCuerpo=str_replace("_comentarios",$comentario,$nCuerpo);
				$obj=array();
				$obj[0]=$idUsuario;
				$obj[1]=$nombre;
				$obj[2]=$mail;
				
				enviarMail($mail,"Convocatoria CENSIDA 2011, Validación de documentos OSC",$nCuerpo,"proyectos@grupolatis.net","Dr. Carlos García de León",NULL);
				
			}
			echo "1|";
		}
		
	}
	
	function guardarEvalCat7()
	{
		global $con;
		$obj=$_POST["cadObj"];
		$cadObj=json_decode($obj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 1012_dictamenesProyectos where tipoDictamen=0 and idReferencia=".$cadObj->idProyecto;
		$x++;
		$consulta[$x]="INSERT INTO 1012_dictamenesProyectos(idFormulario,idReferencia,dictamen,comentarios,fechaDictamen,idResponsable,tipoDictamen)
					VALUES(293,".$cadObj->idProyecto.",".$cadObj->dictamen.",'".cv($cadObj->comentarios)."','".date('Y-m-d')."',".$_SESSION["idUsr"].",0)";
		$x++;
		$consulta[$x]="delete from 100_calculosGrid where idFormulario=293 and idReferencia=".$cadObj->idProyecto;
		$x++;
		if($cadObj->dictamen==1)
		{
			$consulta[$x]="INSERT INTO 100_calculosGrid(montoAutorizado,idFormulario,idReferencia)  VALUES(".$cadObj->montoAutorizado.",293,".$cadObj->idProyecto.")";

		}
		
		//$consulta[$x]="delete from 100_calculosGrid where idFormulario=293 and idReferencia=".$cadObj->idProyecto;
		$x++;
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function marcarProyectosComoEnEsperaCambios()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$motivo=$_POST["motivo"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 100_reporteCambios WHERE idProyecto=".$idProyecto;
		$x++;
		$consulta[$x]="insert into 1016_comentariosProyectos(idProyecto,motivo,fechaComentario,responsable) VALUES(".$idProyecto.",'".cv($motivo)."','".date('Y-m-d')."',".$_SESSION["idUsr"].")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		$query="select codigo,codigoInstitucion from _293_tablaDinamica where id__293_tablaDinamica=".$idProyecto;
		$filaProy=$con->obtenerPrimeraFila($query);
		$query="SELECT idUsuario FROM 801_adscripcion WHERE Institucion='".$filaProy[1]."'";
		$listUsr=$con->obtenerListaValores($query);
		if($listUsr=="")
			$listUsr="-1";
		$query="SELECT distinct u.idUsuario,u.Login,u.Nombre,u.Password FROM  800_usuarios u WHERE  u.idUsuario in (".$listUsr.")";
		$res=$con->obtenerFilas($query);	
		while($fila=mysql_fetch_row($res))
		{
			$cuerpoMail="Estimado _nombreRevisor: <br><br>Como resultado de la validación de su proyecto con folio _nFolio, éste ha sido marcado como 'En Espera de Cambios' presentando los siguientes comentarios:<br><br>\"_comentarios\"<br><br>
						<br>
						<br>
						Esperando pueda llevar a cabo los cambios solicitados en la brevedad posible, le envio un cordial saludo y le deseo un buen día.<br><br>
						
						<b>Atentamente</b><br>
						Dr. Carlos García de León Moreno<br>
						Director de Prevención y Participación Social<br>
						CENSIDA";
						
			$idUsuario=$fila[0];
			$nombre=$fila[2];
			$login=$fila[1];
			$password=$fila[3];
			$folio=$filaProy[0];
			$query="SELECT distinct Mail FROM 805_mails WHERE idUsuario=".$fila[0];	
			$mail=$con->obtenerValor($query);
			//$mail="novant1730@hotmail.com";
			$nCuerpo=str_replace("_nombreRevisor",$nombre,$cuerpoMail);
			$nCuerpo=str_replace("_nFolio",$folio,$nCuerpo);
			$nCuerpo=str_replace("_comentarios",$motivo,$nCuerpo);
			$obj=array();
			$obj[0]=$idUsuario;
			$obj[1]=$nombre;
			$obj[2]=$mail;
			
			enviarMail($mail,"Convocatoria CENSIDA 2011, Validación de proyectos",$nCuerpo,"proyectos@grupolatis.net","Dr. Carlos García de León",NULL);
			
		}
		//echo "1|";
		eB($consulta);
	}
	
	function marcarProyectoVoBo()
	{
		$idProyecto=$_POST["idProyecto"];
		$tipo=$_POST["tipo"];
		$consulta="insert into 1017_voBoProyectos(idProyecto,tipoVoBo,fechaVoBo,responsable) VALUES(".$idProyecto.",".$tipo.",'".date('Y-m-d')."',".$_SESSION["idUsr"].")";	
		eC($consulta);
	}
	
	function guardarReporteCambiosProyectos()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$consulta="INSERT INTO 100_reporteCambios(idProyecto,fechaConfirmacion) VALUES(".$idProyecto.",'".date("Y-m-d")."')";
		eC($consulta);
	}
	
	function obtenerMateriasProfesor()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$idProfesor=$_POST["idProfesor"];
		$consul="SELECT a.idGrupo,g.nombreGrupo AS grupo,a.idMateria,g.fechaInicio,g.fechaFin AS fechaTermino,o.unidad AS sede,m.titulo AS materia,p.nombrePrograma AS programa
				FROM 4049_materiaVSProfesorVSGrupo a,4048_grupos g,817_organigrama o,4013_materia m,4004_programa p
				WHERE a.idMateria=m.idMateria and o.codigoUnidad=g.sede AND g.idGrupo=a.idGrupo AND g.ciclo=".$ciclo." AND idUsuario=".$idProfesor." AND a.estado=1 AND p.idPrograma=g.idPrograma
				UNION
				SELECT a.idGrupo,g.nombreGrupo AS grupo,a.idMateria,g.fechaInicio,g.fechaFin AS fechaTermino,o.unidad AS sede,m.titulo AS materia,p.nombrePrograma AS programa 
				FROM 4047_participacionesMateria a,4048_grupos g,817_organigrama o,4013_materia m,4004_programa p 
				WHERE a.idMateria=m.idMateria and o.codigoUnidad=g.sede AND g.idGrupo=a.idGrupo AND g.ciclo=".$ciclo." AND idUsuario=".$idProfesor." AND a.estado=1 AND p.idPrograma=g.idPrograma AND a.participacionP=1 ";
		$res1=$con->obtenerFilasJSON($consul);
		echo '{"numReg":"'.($con->filasAfectadas).'","registros":'.utf8_encode($res1).'}';
						 
		
	}
	
	function obtenerAlumnosXSede()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$sede=$_POST["sede"];
		$consulta="	SELECT idMapaCurricular,p.nombrePrograma,m.nombre,p.idPrograma FROM 4241_nuevosMapas n,4004_programa p,4153_modalidadPrograma m WHERE 
					m.idModalidad=n.idModalidadCurso AND p.idPrograma=n.idPrograma AND n.ciclo=".$ciclo." AND sede='".$sede."' order by nombrePrograma";
		$res=$con->obtenerFilas($consulta);		
		$ct=0;		
		$arrAlumnos="";	
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT idGrado,leyenda FROM 4014_grados WHERE idPrograma=".$fila[3]." ORDER BY grado";
			$resFila=$con->obtenerFilas($consulta);
			while($filaGrado=mysql_fetch_row($resFila))
			{
				$consulta="select count(*) from 4118_alumnos WHERE ciclo=".$ciclo." AND idPrograma=".$fila[3]." AND idGrado=".$filaGrado[0]." AND estado=1";
				$nAlumnos=$con->obtenerValor($consulta);
				$obj='{"programa":"'.$fila[1].' ('.$fila[2].')","grado":"'.$filaGrado[1].'","alumnosInscritos":"'.$nAlumnos.'"}';
				if($arrAlumnos=="")
					$arrAlumnos=$obj;
				else
					$arrAlumnos.=",".$obj;
				$ct++;
			}
		}
		echo '{"numReg":"'.($ct).'","registros":['.$arrAlumnos.']}';
	}
	
	function obtenerPlanesEstuadiosAperturar()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$sede=$_POST["sede"];
		$consulta="	SELECT idMapaCurricular,p.nombrePrograma,m.nombre,p.idPrograma FROM 4241_nuevosMapas n,4004_programa p,4153_modalidadPrograma m WHERE 
					m.idModalidad=n.idModalidadCurso AND p.idPrograma=n.idPrograma AND n.ciclo=".$ciclo." AND sede='".$sede."' order by nombrePrograma";
		$res=$con->obtenerFilas($consulta);		
		$ct=0;		
		$arrAlumnos="";	
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT idGrado,leyenda FROM 4014_grados WHERE idPrograma=".$fila[3]." and idGradoAnt=-1 ORDER BY grado limit 0,1";
			$resFila=$con->obtenerFilas($consulta);
			while($filaGrado=mysql_fetch_row($resFila))
			{
				$consulta="select count(*) from 4118_alumnos WHERE ciclo=".$ciclo." AND idPrograma=".$fila[3]." AND idGrado=".$filaGrado[0]." AND estado=1";
				$nAlumnos=$con->obtenerValor($consulta);
				$consulta="select situacion from 4241_aperturaGrados where idNuevoMapa=".$fila[0]." and idGrado=".$filaGrado[0];
				$decision=$con->obtenerValor($consulta);
				if($decision=="")
					$decision=-1;
				$obj='{"idGrado":"'.$filaGrado[0].'","idMapa":"'.$fila[0].'","programa":"'.$fila[1].' ('.$fila[2].')","alumnosInscritos":"'.$nAlumnos.'","decision":"'.$decision.'"}';
				if($arrAlumnos=="")
					$arrAlumnos=$obj;
				else
					$arrAlumnos.=",".$obj;
				$ct++;
			}
		}
		echo '{"numReg":"'.($ct).'","registros":['.$arrAlumnos.']}';

	}
	
	function obtenerEstadosDisponibles()
	{
		global $con;
		$comp="";
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="select distinct estado FROM 0_vistaCiudadesAplicacion WHERE idSubcategoria=".$obj->idSubcategoria." AND idTema=".$obj->idTema;

		$listEstados=$con->obtenerListaValores($consulta,"'");
		if($listEstados!="")
		{
			$comp=" where cveEstado in (".$listEstados.")";
		}
		
		$consulta="SELECT cveEstado,upper(estado) FROM 820_estados ".$comp." ORDER BY estado";
		$arrEstados=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrEstados;
	}
	
	function obtenerMunicipiosDisponibles()
	{
		global $con;

		$comp="";
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$cveEstado=$_POST["estado"];
		$consulta="select distinct municipio FROM 0_vistaCiudadesAplicacion WHERE idSubcategoria=".$obj->idSubcategoria." AND idTema=".$obj->idTema." and estado='".$cveEstado."'";
		$listMunicipios=$con->obtenerListaValores($consulta,"'");
		if($listMunicipios!="")
		{
			$comp=" and cveMunicipio in (".$listMunicipios.")";
		}
		
		
		$consulta="SELECT cveMunicipio,municipio FROM 821_municipios where cveEstado='".$cveEstado."' ".$comp." order by municipio";
		$arrEstados=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrEstados;
	}
	
	function recuperarDatosAccesoOSC()
	{
		global $con;
		$codigoUnidad=$_POST["idInstitucion"];
		$consulta="select idOrganigrama,unidad from 817_organigrama where codigoUnidad='".$codigoUnidad."'";
		$fUnidad=$con->obtenerPrimeraFila($consulta);
		$idInstitucion=$fUnidad[0];
		$nUnidad=$fUnidad[1];
		
		$consulta="SELECT email FROM 247_instituciones WHERE idOrganigrama=".$idInstitucion;
		$mail=$con->obtenerValor($consulta);
		$consulta="SELECT Login,PASSWORD,Nombre FROM 800_usuarios u,801_adscripcion a WHERE a.idUsuario=u.idUsuario AND a.Institucion='".$codigoUnidad."' and a.idUsuario<>1";
		$fDatos=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT asunto,cuerpo FROM 2004_mensajesAcciones WHERE idAccionEnvio=5";
		$fDatosEnvio=$con->obtenerPrimeraFila($consulta);
		$cuerpo=$fDatosEnvio[1];
		$cuerpo=str_replace("@nombre",$fDatos[2],$cuerpo);
		$cuerpo=str_replace("@login",$fDatos[0],$cuerpo);
		$cuerpo=str_replace("@passwd",$fDatos[1],$cuerpo);
		$cuerpo=str_replace("@nOSC",$nUnidad,$cuerpo);
		enviarMail($mail,$fDatosEnvio[0],$cuerpo,"proyectos@grupolatis.net","Censida");
		echo "1|";
	}
	
	function obtenerRevisoresProyectos2012()
	{
		global $con;
		$lP=$_POST["lP"];
		$proyectos=bD($lP);
		$consulta="SELECT distinct r.idUsuario,u.Nombre FROM 1011_asignacionRevisoresProyectos r, 800_usuarios u WHERE r.situacion=1 and u.idUsuario=r.idUsuario 
						and r.idProyecto IN (".$proyectos.") and idFormulario=410 order by trim(u.Nombre)";	
		$resRevisores=$con->obtenerFilas($consulta);
		$arrRevisores="";
		while($fila=mysql_fetch_row($resRevisores))
		{
			$nUsuario=$fila[1];
			$consulta="select count(idUsuario) FROM 1011_asignacionRevisoresProyectos r WHERE  idUsuario=".$fila[0]." and r.idProyecto IN (".$proyectos.") and idFormulario=410";
			$nAsignaciones=$con->obtenerValor($consulta);
			$consulta="select count(idUsuario) FROM 1011_asignacionRevisoresProyectos r WHERE  idUsuario=".$fila[0]." and situacion=2 and r.idProyecto IN (".$proyectos.") and idFormulario=410";
			$nAsignacionesRealizadas=$con->obtenerValor($consulta);
			$consulta="select Mail from 805_mails where idUsuario=".$fila[0]." limit 0,1";
			$mail=$con->obtenerValor($consulta);
			$obj="['".$fila[0]."','".$nUsuario."','".$nAsignaciones."','".$nAsignacionesRealizadas."','".($nAsignaciones-$nAsignacionesRealizadas)."','".$mail."']";
			if($arrRevisores=="")
				$arrRevisores=$obj;
			else
				$arrRevisores.=",".$obj;
		}
		echo "1|[".$arrRevisores."]";
	}
	
	function obtenerEstadosDisponiblesV2()
	{
		global $con;
		$consulta="SELECT cveEstado,upper(estado) FROM 820_estadosV2 ORDER BY estado";
		$arrEstados=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrEstados;
	}
	
	function obtenerMunicipiosDisponiblesV2()
	{
		global $con;
		$cveEstado=$_POST["estado"];
		$consulta="SELECT cveMunicipio,upper(municipio) FROM 821_municipiosV2 where cveEstado='".$cveEstado."' order by municipio";
		$arrEstados=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrEstados;
	}
	
	function obtenerLocalidadesDisponiblesV2()
	{
		global $con;
		$municipio=$_POST["municipio"];
		$consulta="SELECT cveLocalidad,upper(localidad) FROM 822_localidadesV2 WHERE cveMunicipio='".$municipio."' ORDER BY localidad";
		$arrEstados=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrEstados;
	}
	
	function obtenerCentroCostoEmpresa()
	{
		global $con;
		$idEmpresa=$_POST["idEmpresa"];
		
		
		$consulta="SELECT distinct centroCosto FROM _1011_tablaDinamica WHERE id__1011_tablaDinamica IN (SELECT idReferencia FROM _1011_gridUsuarios WHERE usuario=".$_SESSION["idUsr"].")";
		$listCC=$con->obtenerListaValores($consulta);
		if($listCC=="")
			$listCC=-1;
		$consulta="SELECT idCentroCosto,centroCosto FROM 722_centrosCostos WHERE idEmpresa=".$idEmpresa." AND situacion=1 and idCentroCosto in (".$listCC.")ORDER BY centroCosto";
		$arrCC=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrCC;
			
	}
	
	
	function obtenerEmpleadosCentroCosto()
	{
		global $con;
		$idCentroCosto=$_POST["idCentroCosto"];
		$idPeriodo=$_POST["idQuincena"];
		
		
		
		$consulta="SELECT DISTINCT idEmpleado FROM 3011_valoresConceptosEmpleado WHERE idCentroCosto=".$idCentroCosto." AND idPeriodo=".$idPeriodo;
		$listaEmpleados=$con->obtenerListaValores($consulta);
		if($listaEmpleados=="")
			$listaEmpleados=-1;
		$consulta="SELECT idEmpleado,CONCAT(IF(rfc1 IS NULL,'',rfc1),'-',IF(rfc2 IS NULL,'',rfc2),'-',IF(rfc3 IS NULL,'',rfc3)) AS rfc,CONCAT(IF(apPaterno IS NULL,'',apPaterno),' ',
					IF(apMaterno IS NULL,'',apMaterno),' ',IF(nombre IS NULL,'',nombre)) AS nombreEmpleado,numEmpleado,
					(select diasTrabajados from 3010_diasTrabajadosEmpleados WHERE idEmpleado=e.idEmpleado AND idCentroCosto=".$idCentroCosto." AND idPeriodo=".$idPeriodo.") as diasTrabajados FROM 693_empleadosNominaV2 e 
					WHERE idCentroCosto=".$idCentroCosto." and (situacion=1 or idEmpleado in (".$listaEmpleados."))";

		$numReg=0;
		$arrRegistros="";//utf8_encode($con->obtenerFilasJSON($consulta));			
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$comp="";
			$consulta="SELECT conceptoBase,c.nombreConcepto FROM _1012_tablaDinamica t,713_conceptosBaseNomina c WHERE t.situacion=1 AND c.idConcepto=t.conceptoBase ORDER BY nombreConcepto";
			$rConceptos=$con->obtenerFilas($consulta);
			while($fConcepto=mysql_fetch_row($rConceptos))
			{
				
				$consulta="SELECT valor FROM 3011_valoresConceptosEmpleado WHERE idEmpleado=".$fila[0]." AND idCentroCosto=".$idCentroCosto." AND idPeriodo=".$idPeriodo." and  idConcepto=".$fConcepto[0];			
				$valor=$con->obtenerValor($consulta);
				$oComp='"concepto_'.$fConcepto[0].'":"'.$valor.'"';
				$comp.=",".$oComp;
			}
			$o='{"idEmpleado":"'.$fila[0].'","numEmpleado":"'.$fila[3].'","nombreEmpleado":"'.cv($fila[2]).'","rfc":"'.$fila[1].'","diasTrabajados":"'.$fila[4].'"'.$comp.'}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
					
					
	}
	
	function registrarDiasTrabajadosEmpleadoCC()
	{
		global $con;
		$idCentroCosto=$_POST["idCC"];
		$idEmpleado=$_POST["idEmpleado"];
		$idPeriodo=$_POST["idPeriodo"];
		$dias=$_POST["dias"];
		$campo=$_POST["campo"];
		
		
		if($campo=="diasTrabajados")
		{
			$consulta="SELECT idEmpleadoDiasTrabajados FROM 3010_diasTrabajadosEmpleados WHERE idEmpleado=".$idEmpleado." AND idCentroCosto=".$idCentroCosto." AND idPeriodo=".$idPeriodo;			
			$idEmpleadoDiasTrabajados=$con->obtenerValor($consulta);
			if($idEmpleadoDiasTrabajados=="")
			{
				$consulta="INSERT INTO 3010_diasTrabajadosEmpleados(idEmpleado,idCentroCosto,idPeriodo,diasTrabajados) VALUES(".$idEmpleado.",".$idCentroCosto.",".$idPeriodo.",".$dias.")";	
			}
			else
				$consulta="update 3010_diasTrabajadosEmpleados set diasTrabajados=".$dias." where idEmpleadoDiasTrabajados=".$idEmpleadoDiasTrabajados;	
		
		}
		else
		{
			$arrConcepto=explode("_",$campo);
			$idConcepto=$arrConcepto[1];
			$consulta="SELECT idValorConcepto FROM 3011_valoresConceptosEmpleado WHERE idEmpleado=".$idEmpleado." AND idCentroCosto=".$idCentroCosto." AND idPeriodo=".$idPeriodo." and  idConcepto=".$idConcepto;			
			$idValorConcepto=$con->obtenerValor($consulta);
			if($idValorConcepto=="")
			{
				$consulta="INSERT INTO 3011_valoresConceptosEmpleado(idEmpleado,idCentroCosto,idPeriodo,idConcepto,valor) VALUES(".$idEmpleado.",".$idCentroCosto.",".$idPeriodo.",".$idConcepto.",".$dias.")";	
			}
			else
				$consulta="update 3011_valoresConceptosEmpleado set valor=".$dias." where idValorConcepto=".$idValorConcepto;
		}
		eC($consulta);
					
	}
?>