<?php session_start();
	
	include("conexionBD.php");
	$parametros="";
	$funcion="";
	if(isset($_POST["funcion"]))
	{
		$funcion=$_POST["funcion"];
	}	
	
	
	switch($funcion)
	{
		case 1:
			obtenerGrados();
		break;
		case 2:
			obtenerProgramas();
		break;
		case 3:
			eliminarBloque();
		break;
		case 4:
			eliminarPerfil();
		break;
		case 5:
			asignarPerfilGrupo();
		break;
		case 6:
			eliminarProgramaBloque();
		break;
		case 7:
			obtenerGradosPrograma();
		break;
		case 8:
			obtenerProgramasHorario();
		break;
		case 9:
			eliminarMateriaGrupo();
		break;
		case 10:
			tipoGruposMapa();
		break;
		case 11:
			eliminarBloqueTipo();
		break;
		case 12:
			obtenerGruposMateria();
		break;
		case 13:
			comprobarTipoMatC();
		break;
		case 14:
			comprobarAsignarBloques();
		break;
		case 15:
			comprobarTipoMateria();
		break;
		case 16:
			obtenerMapaMateriaC();
		break;
		case 17:
			guardarBloquesMateriasHorarioLibre();
		break;
		case 18:
			guardarHorarioConflictoProfesor();
		break;
		case 19:
			guardarHorarioConflictoProfesor2();
        break;
		case 20:
			obtenerMateriasGruposGrado();
		break;
		case 21:
			obtenerGruposMaterias();
		break;
		case 22:
			obtenerProgramasCiclo();
		break;
		case 23:
			guardarMatHorarioLibre();
		break;
		case 24:
			guardarMateriaCompartida();
		break;
		case 25:
			validarExisteMateriaCompartida();
		break;
		case 26:
			inscribirMateriaHorario();
		break;
		case 27:
			removerAsignacion();
		break;
	}

	function obtenerGrados()
	{
		global $con;
		
		$idPrograma=$_POST["idPrograma"];
		$idCiclo=$_POST["idCiclo"];
		
		$consulta='SELECT * from 4060_perfilHorarios where idPrograma='.$idPrograma.' and ciclo='.$idCiclo;
		$arregloPerfil=$con->obtenerFilasArreglo($consulta);
		
		$consulta='SELECT idGrado,leyenda from 4014_grados where idPrograma='.$idPrograma." and ciclo=".$idCiclo;
		$arreglo=$con->obtenerFilasArreglo($consulta);
	
		echo "1|".$arreglo."|".$arregloPerfil;
	}
	
	function obtenerProgramas()
	{
		global $con;
		$param=$_POST["param"];
		
		$obj=json_decode(dvJs($param));
		$idCiclo=$obj->idCiclo;
		
		//$consulta='SELECT p.idPrograma, nombrePrograma FROM 4004_programa p, 4029_mapaCurricular m WHERE ciclo='.$idCiclo.' AND p.idPrograma=m.idPrograma';
		
		$consulta="SELECT distinct(o.idPrograma),n.NombrePrograma FROM  4004_programa n,4029_mapaCurricular o ,4035_programaVsUsuariosPermitidos pr
					WHERE pr.idPrograma=o.idPrograma and pr.idUsuario in(".$_SESSION["idUsr"].") 
					and o.idPrograma=n.idPrograma AND o.ciclo=".$idCiclo." AND (o.estadoMapa=1 OR o.estadoMapa=2) ORDER BY n.idPrograma";
		$arreglo=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arreglo);
	}
	
	function eliminarBloque()
	{
		global $con;
		$idBloque=$_POST["id"];
		
		$consultaInicial="SELECT anterior, siguiente FROM 4062_perfilVSBloque WHERE idPerfilVSBloque=".$idBloque;
		$res=$con->obtenerFilas($consultaInicial);
		$fila=mysql_fetch_row($res);
		$anterior=$fila[0];
		$siguiente=$fila[1];
		$consul="BEGIN";
		$con->ejecutarConsulta($consul);
		if($anterior==-1 || $siguiente==-1) 
		{
			if($anterior==-1)
			{
				
				$consulta[0]="UPDATE 4062_perfilVSBloque set anterior=".$anterior." WHERE idPerfilVSBloque=".$siguiente;
				$consulta[1]="DELETE from 4062_perfilVSBloque WHERE idPerfilVSBloque=".$idBloque;
			}
			if($siguiente==-1)
			{
				$consulta[0]="UPDATE 4062_perfilVSBloque set siguiente=".$siguiente." WHERE idPerfilVSBloque=".$anterior;
				$consulta[1]="DELETE from 4062_perfilVSBloque WHERE idPerfilVSBloque=".$idBloque;
			}
		}
		else 
		{
			$consulta[0]="UPDATE 4062_perfilVSBloque set anterior=".$anterior." WHERE idPerfilVSBloque=".$siguiente;
			$consulta[1]="UPDATE 4062_perfilVSBloque set siguiente=".$siguiente." WHERE idPerfilVSBloque=".$anterior;
			$consulta[2]="DELETE from 4062_perfilVSBloque WHERE idPerfilVSBloque=".$idBloque;
			
		}
		$con->ejecutarBloque($consulta);
		$consul="COMMIT";
		if($con->ejecutarConsulta($consul))
			echo "1|";
		else
			echo "0|";
	}
	
	function eliminarPerfil()
	{
	
		global $con;
		$idPerfil=$_POST["idPerfil"];
		$consulta[0]="begin";
		$consulta[1]="delete from 4060_perfilHorarios where idPerfil=".$idPerfil;
		$consulta[2]="delete from 4062_perfilVSBloque where idPerfil=".$idPerfil;
		$consulta[3]="commit";
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "";
		
	}
	
	function asignarPerfilGrupo()
	{
		global $con;
		$param=$_POST["param"];
		$obj=json_decode($param);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 4063_PerfilHorarioVSGrados where idGrado=".$obj->idGrado." and ciclo=".$obj->idCiclo;
		$x++;
		if($obj->idPerfil!="-1")
		{
			$consulta[$x]="insert into 4063_PerfilHorarioVSGrados(idPerfil,idGrado,ciclo,idPrograma) values(".$obj->idPerfil.",".$obj->idGrado.",".$obj->idCiclo.",".$obj->idPrograma.")";
			$x++;
		
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))	
			echo "1|";
		else
			echo "|";
		
	}
	
	function eliminarProgramaBloque()
	{
		global $con;
		$id=$_POST["id"];
		$idPrograma=$_POST["idPrograma"];
		$idGrado=$_POST["idGrado"];
		$idBloque=$_POST["idBloque"];
		
		
		$consultaValidacion="select idBloque from 4064_asignacionSeccionesBloques where idPrograma=".$idPrograma." and idGrado=".$idGrado." and idBloque
							 in(select idBloque from 4065_materiaVSGrupo where idPrograma=".$idPrograma." and idBloque=".$idBloque.")" ;
		$filas=$con->obtenerFilas($consultaValidacion);
		$numero=$con->filasAfectadas;
		
		if($numero>0)
		{
			echo "2|";
		}
		else
		{
			$consulta="delete from 4064_asignacionSeccionesBloques where idBloqueSeccion=".$id;
			$re1=$con->ejecutarConsulta($consulta);
				
			if(($re1))
				echo "1|";
			else
				echo "|";
		}
	
	}
	
	function obtenerGradosPrograma()
	{
		global $con;
		$idPrograma=$_POST["idPrograma"];
		$idCiclo=$_POST["idCiclo"];
		
		$consultaPrograma="select idtipoPrograma,idProgramaVinculado from 4004_programa where idPrograma=".$idPrograma;
		$tipoPrograma=$con->obtenerPrimeraFila($consultaPrograma);
		
		if($tipoPrograma[0]==1)
		{
		
			$consulta="select idGrado, leyenda from 4014_grados where idPrograma=".$idPrograma." and ciclo=".$idCiclo." order by grado";
			$arreglo=uEJ($con->obtenerFilasArreglo($consulta));
		
			if($con->ejecutarConsulta($consulta))
			   echo "1|".$arreglo;
			else
			   echo "|";
		}
		else
		{
		
			$consulta="select idGrado, leyenda from 4014_grados where idPrograma=".$tipoPrograma[1]." and ciclo=".$idCiclo." order by grado";
			$arreglo=uEJ($con->obtenerFilasArreglo($consulta));
		
			if($con->ejecutarConsulta($consulta))
			   echo "1|".$arreglo;
			else
			   echo "|";
		
		}
	}
	
	function obtenerProgramasHorario()
	{
		global $con;
		$param=$_POST["param"];
		
		$obj=json_decode(dvJs($param));
		$idCiclo=$obj->idCiclo;
		
		//$consulta='SELECT p.idPrograma, nombrePrograma FROM 4004_programa p, 4029_mapaCurricular m WHERE ciclo='.$idCiclo.' AND p.idPrograma=m.idPrograma';
		
		$consulta="SELECT distinct(o.idPrograma),n.NombrePrograma FROM  4004_programa n,4029_mapaCurricular o ,4035_programaVsUsuariosPermitidos pr
					WHERE pr.idPrograma=o.idPrograma and pr.idUsuario in(".$_SESSION["idUsr"].") 
					and o.idPrograma=n.idPrograma AND o.ciclo=".$idCiclo." AND (o.estadoMapa=1 OR o.estadoMapa=2) ORDER BY n.idPrograma";
		$arreglo=uEJ($con->obtenerFilasArreglo($consulta));
		
		if($con->ejecutarConsulta($consulta))
			echo "1|".$arreglo;
		else
			echo "|";
	
	}
	
	
	function eliminarMateriaGrupo()
	{
		global $con;
		$id=$_POST["id"];
		
		$consultaDatos="select *from 4065_materiaVSGrupo where idMateriaVSGrupo=".$id;
		$fila=$con->obtenerPrimeraFila($consultaDatos);
		
		$consultaDia="select dia from 4062_perfilVSBloque where idPerfilVSBloque=".$fila[1];
		$dia=$con->obtenerValor($consultaDia);
		
		$consulta[0]="begin";
		
		
		$consulta[1]="delete from 4049_materiaVSProfesorVSGrupo where idMateria=".$fila[2]." and idGrupo=".$fila[3]." and horaInicio='".$fila[4]."' and horaFin='".$fila[5]."' and ciclo=".$fila[7]." and dia=".$dia ;
		
		
		$consulta[2]="delete from 4065_materiaVSGrupo where idMateriaVSGrupo=".$id;
		$consulta[3]="commit";
		$re1=$con->ejecutarBloque($consulta);
			
		if(($re1))
			echo "1|";
		else
			echo "|";
	
	
	}
	
	function tipoGruposMapa()
	{
		global $con;
		$idPrograma=$_POST["idPrograma"];
		$idCiclo=$_POST["idCiclo"];
		$idGrado=$_POST["idGrado"];
		
		$consultaTipoGrupos="select esquemaGrupos,tipoGrupos  from 4029_mapaCurricular where ciclo=".$idCiclo." and idPrograma=".$idPrograma ;
		$tipo=$con->obtenerPrimeraFila($consultaTipoGrupos);
		
		if(($tipo[0]==1) && ($tipo[1]==1))
		{
		  $consultaGrupos="select idGrupo,nombreGrupo from 4048_grupos where  idGrado=".$idGrado ;
		  $arreglo=$con->obtenerFilasArreglo($consultaGrupos);
		  echo "1|".$arreglo;
		}
		else
		{
			echo "2|";
		}
	
	}
	
	function eliminarBloqueTipo()
	{
		global $con;
		$idBloque=$_POST["idBloque"];
		$consulta="delete from 4061_tipoBloques where idBloque=".$idBloque;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
		
	}
	
	function obtenerGruposMateria()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$arreglo="";
		
		$conGrupos="SELECT idGrupo,nombreGrupo FROM 4048_grupos WHERE idMateria=".$idMateria;
		$resCon=$con->obtenerFilas($conGrupos);
		
		while($fila=mysql_fetch_row($resCon))
		{
			$cadenaHorario="";
			$conHorario="SELECT dia,horaInicio,horaFin FROM 4180_materiaCompVSGrupo WHERE idMateria=".$idMateria." AND idGrupo=".$fila[0];
			$resHorario=$con->obtenerFilas($conHorario);
			$filasHorario=$con->filasAfectadas;
			if($filasHorario==0)
			{
				$conDatosMateria="select idPrograma,ciclo from 4013_materia where idMateria=".$idMateria;
				$datosMateria=$con->obtenerPrimeraFila($conDatosMateria);
				
				$conMapaC="select idMapaCurricular from 4029_mapaCurricular where idPrograma=".$datosMateria[0]." and ciclo=".$datosMateria[1];
				$idMapaC=$con->obtenerValor($conMapaC);
				
				$conTipoHoraMat="select idTipoHorario from 4031_elementosMapa where idMateria=".$idMateria." and idMapacurricular=".$idMapaC;
				$tipoHorarioMat=$con->obtenerValor($conTipoHoraMat);
				
				if($tipoHorarioMat==1)
				{
					$cadenaHorario="<font color=\'#FF0000\'><img src=\'../images/exclamation.png\'>Sin Horario Configurado</font>";
				}
				else
				{
					$cadenaHorario="<font color=\'#FF0000\'><img src=\'../images/exclamation.png\'>Materia con horario Abierto</font>";
				}
			}
			
			while($fHorario=mysql_fetch_row($resHorario))
			{
				$nombre=dameNombreDia($fHorario[0]);
				
				$horaDia=$nombre.":&nbsp;".date('G:i',strtotime($fHorario[1]))."-".date('G:i',strtotime($fHorario[2]));
				if($cadenaHorario=="")
					$cadenaHorario=$horaDia;
				else
					$cadenaHorario.="  ,  ".$horaDia;
			}
			$obj="['".$fila[0]."','".$fila[1]."','".$cadenaHorario."']";
			
			if($arreglo=="")
				$arreglo=$obj;
			else
				$arreglo.=",".$obj;
		}
		
		//$arreglo=$con->obtenerFilasArreglo($conGrupos);
		echo "1|[".$arreglo."]";
	}
	
	function dameNombreDia($numeroDia)
	{
		 $nombreDia="";
		 switch($numeroDia)
		  {
			  case "1":
				$nombreDia="Lun";
			  break;
			  case "2":
				$nombreDia="Mar";
			  break;
			  case "3":
				$nombreDia="Mier";
			  break;
			  case "4":
				$nombreDia="Jue";
			  break;
			  case "5":
				$nombreDia="Vie";
			  break;
			  case "6":
				$nombreDia="Sab";
			  break;
			  case "0":
				$nombreDia="Dom";
			  break;
		  }
		  return $nombreDia;
	}
	
	function comprobarTipoMatC()
	{
		global $con;
		$idMapaCurricular=$_POST["idMapaCurricular"];
		$idGrado=$_POST["idGrado"];
		$idGrupo=$_POST["idGrupo"];
		
		$comMatReg="SELECT distinct(idMateria) FROM 4065_materiaVSGrupo WHERE idGrupo=".$idGrupo;
		//echo $comMatReg;
		$matReg=$con->obtenerListaValores($comMatReg);
		if($matReg=="")
		{
			$matReg="-1";
		}
		
		$consulta="SELECT e.idMateria,e.idTipoMateria,t.nombreTipoMateria FROM 4031_elementosMapa e,4026_tipoMaterias t,4013_materia m  WHERE idMapaCurricular=".$idMapaCurricular." AND e.idMateria=m.idMateria and idGrado=".$idGrado." AND (e.idTipoHorario=1000 or m.compartida=1) and e.idTipoMateria=t.idTipoMateria and e.idMateria not in (".$matReg.")";
		//echo $consulta;
		$res=$con->obtenerFilas($consulta);
		$numF=$con->filasAfectadas;
		if($numF==0) 
		{
			echo "2|";
		}
		else
		{
			$arreglo=array();
			while($fila=mysql_fetch_row($res))
			{
				$datosMat="SELECT idPrograma,ciclo FROM 4013_materia WHERE idMateria=".$fila[0]	;
				$datos=$con->obtenerPrimeraFila($datosMat);
				
				$conMapa="select idMapaCurricular from 4029_mapaCurricular WHERE idPrograma=".$datos[0]." and ciclo=".$datos[1];
				$idMapa=$con->obtenerValor($conMapa);
				
				$tipoMat="SELECT idTipoComponente,idTipoHorario FROM 4031_elementosMapa WHERE idMateria=".$fila[0]." AND idMapaCurricular=".$idMapa;
				$tipo=$con->obtenerPrimeraFila($tipoMat);
				
				$conAbrev="SELECT abreviatura,titulo,descripcion FROM 4013_materia WHERE idMateria=".$fila[0];
				$abrev=$con->obtenerPrimeraFila($conAbrev);
				
					switch($tipo[0])
					{
						case 1:
							hijosContenedor($fila[0],$arreglo,$matReg);
						break;
						case 2:
							$elemento=$fila[0]."-".$abrev[0]."-".$abrev[1]."-".$fila[1]."-".$fila[2]."-".$abrev[2];			
							array_push($arreglo,$elemento);
						break;
						case 3:
							$elemento=$fila[0]."-".$abrev[0]."-".$abrev[1]."-".$fila[1]."-".$fila[2]."-".$abrev[2];
							array_push($arreglo,$elemento);
							hijosContenedor($fila[0],$arreglo,$matReg);
						break;
					}
			}
			
			//echo var_dump($arreglo);
			$arregloMatC="";
			$tamano=sizeof($arreglo);
			for($y=0;$y<$tamano;$y++)
			{
				$arrDatosC=explode('-',$arreglo[$y]);
				$idMatC=$arrDatosC[0];
				$abrevMatC=$arrDatosC[1];
				$nombreMat=$arrDatosC[2];
				$tipoMatC=$arrDatosC[3];
				$nomTipoMatC=$arrDatosC[4];
				$descripcion=$arrDatosC[5];
				$obj="['".$idMatC."','".$abrevMatC."','".$nombreMat."','".$tipoMatC."','".$nomTipoMatC."','".$descripcion."']";
			
				if($arregloMatC=="")
					$arregloMatC=$obj;
				else
					$arregloMatC.=",".$obj;
			}
			
			if($arregloMatC=="")
			{
				echo "2|";
			}
			else
			{
				$arregloMatC="[".$arregloMatC."]";
				echo "1|".$arregloMatC; // esto se imprime dos veces
			}
			
			//for($x=0;$x < $tamano; $x++)
	//		{
	//			$arrDatos=explode('-',$arreglo[$x]);
	//			$idMat=$arrDatos[0];
	//			$conHorario="SELECT dia,horaInicio,horaFin FROM 4180_materiaCompVSGrupo WHERE idMateria=".$idMat;
	//			$horario=$con->obtenerFilas($conHorario);
	//			$filasH=$con->filasAfectadas;
	//			if($filasH>0)
	//			{
	//				//echo "1|".$arregloMatC;
	//				//return;
	//				//echo "1|".$arregloMatC; //cuando ocurre la conicion se ejecuta esto y luego el siguiente
	//			}
	//		}
			
		}
		
	}
	
	function hijosContenedor($idPadre,&$arreglo,$matReg)
	{
		global $con;
		
		
		$cohHijos="SELECT e.idTipoComponente,e.idMateria,e.idTipoMateria,t.nombreTipoMateria FROM 4031_elementosMapa e,4026_tipoMaterias t WHERE idPadre=".$idPadre." and e.idTipoMateria=t.idTipoMateria and e.idMateria not in(".$matReg.")";
		$hijos=$con->obtenerFilas($cohHijos);
		while($fHijo=mysql_fetch_row($hijos))
		{
			$conAbrev="SELECT abreviatura,titulo,descripcion FROM 4013_materia WHERE idMateria=".$fHijo[1];
			$abrev=$con->obtenerPrimeraFila($conAbrev);
			if($fHijo[0]==1)
			{
				hijosContenedor($fHijo[1],$arreglo,$matReg);
			}
			else
			{
				$elemento=$fHijo[1]."-".$abrev[0]."-".$abrev[1]."-".$fHijo[2]."-".$fHijo[3]."-".$abrev[2];
				array_push($arreglo,$elemento);
			}
		}
	}
	
	function comprobarAsignarBloques()
	{
		global $con;
		$idGrupoC=$_POST["idGrupoC"];
		$arreglo=$_POST["arreglo"];
		$idPrograma=$_POST["idPrograma"];
		$idCiclo=$_POST["idCiclo"];
		$idPerfil=$_POST["idPerfil"];
		$idTipoMateria=$_POST["idTipoMateria"];
		$idGrupo=$_POST["idGrupo"];
		$idGrado=$_POST["idGrado"];
		$idMateria=$_POST["idMateria"];
		$arrHoraDia=explode(',',$arreglo);
		$tamanoA=sizeof($arrHoraDia);
		$cadenaRespuesta="";
		$arregloRespuestas=array();
		
		$conMapa="SELECT idMapaCurricular FROM 4029_mapaCurricular WHERE idPrograma=".$idPrograma." AND ciclo=".$idCiclo;
		//echo $conMapa;
		$idMapaCurricular=$con->obtenerValor($conMapa);
		
		//$alineacionDirecta="SELECT idElementoMapa,idTipoMateria FROM 4031_elementosMapa WHERE idMateria=".$idMateria." AND idMapaCurricular=".$idMapaCurricular ;
		//$filaAlin=$con->obtenerPrimeraFila($alineacionDirecta);
		 
		//if(!$filaAlin)
		//{
			
			$idTipoMat=operacionMateria($idMateria,$idMapaCurricular,$idGrado);
			//echo $idTipoMat;
		//}
		//else
		//{
			
		//}		
		
		for($x=0; $x< $tamanoA; $x++ )
		{
			$datosA=explode('&nbsp;',$arrHoraDia[$x]);
			$diaF=trim($datosA[0]);
			$diaC=dameNumeroDia($diaF);
			$arrHoras=explode('-',$datosA[1]);
			$horaInicio=$arrHoras[0];
			$horaFin=$arrHoras[1];
			$cadenaRespuesta=esHorarioAsignable($idPerfil,$idGrupo,$diaC,$horaInicio,$horaFin,$idTipoMat,false);
			array_push($arregloRespuestas,$cadenaRespuesta);
		}
		//echo var_dump($arregloRespuestas);
		$tamanoRespuesta=sizeof($arregloRespuestas);
		$arregloDiasBloque=array();
		for($y=0;$y<$tamanoRespuesta;$y++)
		{
			if(!$arregloRespuestas[$y]->resultado)
			{
				echo "2|".$arregloRespuestas[$y]->mensajeError."|3";
				return;
			}
			else
			{
				//var_dump($arregloRespuestas[$y]);
			}
		}
		
		
		$cadenaBloqueDias="";
		for($y=0;$y<$tamanoRespuesta;$y++)
		{
			$nHorarios=sizeof($arregloRespuestas[$y]->horarioBloques);
			for($z=0;$z<$nHorarios;$z++)
			{
				$obj=$arregloRespuestas[$y]->horarioBloques[$z][0]."-".$arregloRespuestas[$y]->horarioBloques[$z][1]."-".$arregloRespuestas[$y]->horarioBloques[$z][2];
				if($cadenaBloqueDias=="")
					$cadenaBloqueDias=$obj;
				else
					$cadenaBloqueDias.=",".$obj;
			}
		}
		//echo $cadenaBloqueDias;
		
		$conTieneMaestro="SELECT idUsuario FROM 4047_participacionesMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupoC." AND participacionP=1 AND estado=1";
		$idProfesor=$con->obtenerValor($conTieneMaestro);
		if($idProfesor=="")
		{
			$puedeGuardar=1;
		}
		else
		{
			 
			$respuestaValidacion=validarHorarioProfesor($idMateria,$idGrupoC,$idProfesor,$idCiclo);
			$resFinal=explode('|',$respuestaValidacion);
			if($resFinal[0]=="1")
			{
				$puedeGuardar=1;	
			}
			else
			{
				echo "2|".$resFinal[1]."|".$cadenaBloqueDias."|".$idTipoMat ;
				return;
			}
		
		}
		if($puedeGuardar==1)
		{
			$arregloGuardar=explode(",",$cadenaBloqueDias);
			$tamanoGuardar=sizeof($arregloGuardar);
			
			$consulta="begin";
			if($con->ejecutarConsulta($consulta))
			{
				$ct=0;
				for($w=0; $w< $tamanoGuardar;$w++ )
				{
					$datosArr=explode("-",$arregloGuardar[$w]);
					$hIg=$datosArr[0];
					$hFg=$datosArr[1];
					$idBloque=$datosArr[2];
					
					$conExiste="SELECT idMateriaVSGrupo FROM 4065_materiaVSGrupo WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND idBloque=".$idBloque ;
					$existe=$con->obtenerValor($conExiste);
					if($existe=="")
					{
						$query[$ct]="INSERT INTO 4065_materiaVSGrupo (idMateria,idGrupo,horaInicio,horaFin,idPrograma,ciclo,tipoMateriaVirtual,idBloque,idGrupoCompartido)
								VALUES ('".$idMateria."','".$idGrupo."','".$hIg."','".$hFg."','".$idPrograma."','".$idCiclo."','".$idTipoMat."','".$idBloque."','".$idGrupoC."')";
						$ct++;			
					}
				}
				
				$query[$ct]="commit";
				if($con->ejecutarbloque($query))
					echo "1|";
				else
					echo "|";
			}
		}
	}
	
	
	function operacionMateria($idMateria,$idMapaCurricular,$idGrado)
	{
		global $con;
		$conPadreMapa="SELECT idPadre,idTipoMateria FROM 4031_elementosMapa WHERE idMateria=".$idMateria." and idMapaCurricular=".$idMapaCurricular." and idGrado=".$idGrado;
		$filaPadre=$con->obtenerPrimeraFila($conPadreMapa);
		if($filaPadre)
		{
			if($filaPadre[1]!=1)
				return $filaPadre[1];
			
			if($filaPadre[0]==0)
			{
				return $filaPadre[1];
			}
			else	
			{
				return operacionMateria($filaPadre[0],$idMapaCurricular,$idGrado);
			}
		}
		else
		{
			$idMapaMateria=obtenerMapaCurricularHerenciaMateria($idMateria,$idGrado);
			if($idMapaMateria=="")
			{
				$conMapaMateria="select ciclo,idPrograma from 4013_materia where idMateria=".$idMateria;
				$datosMateria=$con->obtenerPrimeraFila($conMapaMateria);
				
				$conMapa="select idMapaCurricular from 4029_mapaCurricular where idPrograma=".$datosMateria[1]." and ciclo=".$datosMateria[0];
				$idMapaMateria=$con->obtenerValor($conMapa);
			}
			$resMateriaExterna=operacionMateriaExterna($idMateria,$idMapaMateria,$idMapaCurricular,$idGrado);
			$arrRes=explode("|",$resMateriaExterna);
			//echo $arrRes[0];
			if($arrRes[1]=="")
				return $arrRes[0];
			else
				return operacionMateria($arrRes[1],$idMapaCurricular,$idGrado);
		}
	}
	
	
	function operacionMateriaExterna($idMateria,$idMapaCurricularOrigen,$idMapaCurricularActual,$idGrado)
	{
		global $con;
		$conPadreMapa="SELECT idPadre,idTipoMateria FROM 4031_elementosMapa WHERE idMateria=".$idMateria." and idMapaCurricular=".$idMapaCurricularOrigen;
		//echo $conPadreMapa;
		$filaPadre=$con->obtenerPrimeraFila($conPadreMapa);
		if($filaPadre)
		{
			if($filaPadre[1]!=1)
				return $filaPadre[1]."|";
				
			if($filaPadre[0]==0)
			{
				return $filaPadre[1]."|";
			}
			else	
			{
				$conPadreMapa="SELECT idPadre,idTipoMateria FROM 4031_elementosMapa WHERE idMateria=".$idMateria." and idMapaCurricular=".$idMapaCurricularActual;
				$filaPadre2=$con->obtenerPrimeraFila($conPadreMapa);
				if($filaPadre2)
					return "|".$filaPadre2[0];
				else
				{
					return operacionMateriaExterna($filaPadre[0],$idMapaCurricularOrigen,$idMapaCurricularActual,$idGrado);
				}
			}
		}
		else
		{
			$idMapaMateria=obtenerMapaCurricularHerenciaMateria($idMateria,$idGrado);
			return operacionMateriaExterna($idMateria,$idMapaMateria,$idMapaCurricularOrigen,$idGrado);
		}
		
	}
	
	
	function dameNumeroDia($nombreDia)
	{
		 $numeroDia="";
		 switch($nombreDia)
		  {
			  case 'Lun:':
				$numeroDia="1";
			  break;
			  case 'Mar:':
				$numeroDia="2";
			  break;
			  case 'Mier:':
				$numeroDia="3";
			  break;
			  case 'Jue:':
				$numeroDia="4";
			  break;
			  case 'Vie:':
				$numeroDia="5";
			  break;
			  case 'Sab:':
				$numeroDia="6";
			  break;
			  case 'Dom:':
				$numeroDia="0";
			  break;
		  }
		  return $numeroDia;
	}
	
	function buscarPadreEnMapa($idMateria,$idMapaCurricular)
	{
		global $con;
		
		$conPadreMapa="SELECT idPadre,idTipoMateria FROM 4031_elementosMapa WHERE idMateria=".$idMateria;
		$filaPadre=$con->obtenerPrimeraFila($conPadreMapa);
		
		$alineacionDirecta="SELECT idElementoMapa,idTipoMateria FROM 4031_elementosMapa WHERE idMateria=".$idMateria." AND idMapaCurricular=".$idMapaCurricular ;
		$filaAlin=$con->obtenerPrimeraFila($alineacionDirecta);
		
		if(!$filaAlin)
		{
			echo $respuesta=buscarPadreEnMapa($filaPadre[0],$idMapaCurricular)	;
		}
		else
		{
			return $filaAlin[1]."elemento".$filaAlin[0];
		}
		
	}
	
	function comprobarTipoMateria()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idMapaCurricular=$_POST["idMapaCurricular"];
		$idGrado=$_POST["idGrado"];
		
		$idTipoMat=operacionMateria($idMateria,$idMapaCurricular,$idGrado);
		
		echo"1|".$idTipoMat;
	}
	
	function obtenerMapaMateriaC()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idMapaCurricular=obtenerMapaMateria($idMateria);
		echo "1|".$idMapaCurricular;
	}
	
	function guardarBloquesMateriasHorarioLibre()
	{
		global $con;
		$idPrograma=$_POST["idPrograma"];
		$idCiclo=$_POST["idCiclo"];
		$idGrupo=$_POST["idGrupo"];
		$idGrupoC=$_POST["idGrupoC"];
		$idMateria=$_POST["idMateria"];
		
		$conExiste="SELECT idMateriaVSGrupo	FROM 4065_materiaVSGrupo WHERE idMateria=".$idMateria." AND idBloque=-1000 AND idGrupo=".$idGrupo." AND idPrograma=".$idPrograma." AND ciclo=".$idCiclo." AND idGrupoCompartido=".$idGrupoC;
		$existe=$con->obtenerValor($conExiste);
		
		if($existe=="")
		{
			$consulta="INSERT INTO 4065_materiaVSGrupo (idBloque,idMateria,idGrupo,horaInicio,horaFin,idPrograma,ciclo,tipoMateriaVirtual,idGrupoCompartido)
					VALUES('-1000','".$idMateria."','".$idGrupo."','00:00','00:00','".$idPrograma."','".$idCiclo."','0','".$idGrupoC."')";
					
			if($con->ejecutarConsulta($consulta))			
			{
				echo "1|";
			}
			else
			{
				echo "|";
			}
		}
		else
		{
			echo "1|";
		}
	}
	
	function validarHorarioProfesor($idMateria,$idGrupo,$idProfesor,$idCiclo)
	{
		global $con;
		
		$materiasProfesor="SELECT idMateria,idGrupo,idParticipante FROM 4047_participacionesMateria 
							WHERE idUsuario=".$idProfesor." AND participacionP=1 AND estado=1 AND idParticipante NOT IN
							(SELECT idParticipante FROM 4047_participacionesMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo.")";
		$resMateriasProf=$con->obtenerFilas($materiasProfesor);
		$numeroFilas=$con->filasAfectadas;
		
		if($numeroFilas==0)
		{
			return 1;
		}
		else
		{
			$mensajeDeColision="";
			$conHorario="SELECT dia,horaInicio,horaFin FROM 4180_materiaCompVSGrupo WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo;
			$res=$con->obtenerFilas($conHorario);
			
			while($fila=mysql_fetch_row($resMateriasProf))	
			{
				  $horaMatProf="SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
								   WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$fila[0]." AND idGrupo=".$fila[1]." and ciclo=".$idCiclo;
				  $respuesta=$con->obtenerFilas($horaMatProf);				 
				  $numFilas=$con->filasAfectadas;
				  
				  if($numFilas==0)
				  {
					  $horaMatProf="SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
							  WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$fila[0]." AND idGrupoCompartido=".$fila[1]." and ciclo=".$idCiclo;
					  $respuesta=$con->obtenerFilas($horaMatProf);		
				  }
				  
				  while($filaMatP=mysql_fetch_row($respuesta))
				  {
					  mysql_data_seek($res,0);
					  while($filaHmat=mysql_fetch_row($res))
					  {
						  if($filaMatP[0]==$filaHmat[0])
						  {
							  if(colisionaTiempo($filaMatP[1],$filaMatP[2],$filaHmat[1],$filaHmat[2]))
							  {
								  $nombreMat="SELECT titulo FROM 4013_materia WHERE idMateria=".$fila[0];
								  $nombre=$con->obtenerValor($nombreMat);
								  
								  $nombreGrupo="SELECT titulo FROM 4013_materia WHERE idMateria=".$fila[1];
								  $nGrupo=$con->obtenerValor($nombreGrupo);
								  
								  switch($filaHmat[0])
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
								  
								  $colision="Tiene asignada la materia:&nbsp;<b>".$nombre."</b>&nbsp;el dia&nbsp;<b>".$dia."</b>&nbsp;de&nbsp;<b>".$filaHmat[1]."</b>&nbsp;a&nbsp;<b>".$filaHmat[2]."</b><br/>";
								 //echo $colision;
								 //return "2|".$dia."|".$filaHmat[1]."|".$filaHmat[2]."|".$nombre;
								  if($mensajeDeColision=="")
									$mensajeDeColision=$colision;
								  else
									$mensajeDeColision.="-".$colision;
									
									
							  }
						  }
					  }
				  }
			}
			if($mensajeDeColision=="")
				return "1|";
			else
				return "2|".$mensajeDeColision;
		}
	
	}
	
	
	function obtenerMateriasGruposGrado()
	{
		global $con;	
		$idGrado=$_POST["idGrado"];
		$consulta="select idMateria,idTipoComponente from 4031_elementosMapa where idGrado=".$idGrado;
		$resMaterias=$con->obtenerFilas($consulta);
		$arrMaterias=array();
		while($filasMat=mysql_fetch_row($resMaterias))
		{
			if($filasMat[1]!="1")
				array_push($arrMaterias,$filasMat[0]);	
			obtenerMateriasHijas($filasMat[0],$arrMaterias);	
		}
		$listMaterias="";
		foreach($arrMaterias as $materia)
		{
			if($listMaterias=="")
				$listMaterias=$materia;
			else
				$listMaterias.=",".$materia;
		}
		$consulta="SELECT idMateria,titulo FROM 4013_materia WHERE idMateria IN (".$listMaterias.") order by titulo";
		$arrDatos=$con->obtenerFilasArreglo($consulta);
		$consulta="select idGrupo,nombreGrupo from 4048_grupos where idGrado=".$idGrado;
		$arrGrupos=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrDatos)."|".uEJ($arrGrupos);
	}
	
	function obtenerGruposMaterias()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		
		$consulta="SELECT compartida FROM 4013_materia WHERE idMateria=".$idMateria;
		$compartida=$con->obtenerValor($consulta);
		if($compartida==1)
			$consulta="select idGrupo,nombreGrupo from 4048_grupos where idMateria=".$idMateria;
		else
		{
			$consulta="select idGrado from 4031_elementosMapa where idMateria=".$idMateria;	
			$idGrado=$con->obtenerValor($consulta);
			if($idGrado=="")
				$idGrado="-1";
			$consulta="select idGrupo,nombreGrupo from 4048_grupos where idGrado=".$idGrado;
		}
		$arrGrupos=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrGrupos);	
	}
	
	
	
	function guardarHorarioConflictoProfesor()
	{
		global $con;
		$cadenaDias=$_POST["cadenaDias"];
		$idPrograma=$_POST["idPrograma"];
		$idCiclo=$_POST["idCiclo"];
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$idGrupoC=$_POST["idGrupoC"];
		$idTipoMat=$_POST["idTipoMateria"];
		
		$arreglo=explode(",",$cadenaDias);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0; $x< $tamano;$x++)
			{
				$datosArr=explode("-",$arreglo[$x]);
				$hIg=$datosArr[0];
				$hFg=$datosArr[1];
				$idBloque=$datosArr[2];
				
				$conExiste="SELECT idMateriaVSGrupo FROM 4065_materiaVSGrupo WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND idBloque=".$idBloque ;
				$existe=$con->obtenerValor($conExiste);
				if($existe=="")
				{
					$query[$ct]="INSERT INTO 4065_materiaVSGrupo (idMateria,idGrupo,horaInicio,horaFin,idPrograma,ciclo,tipoMateriaVirtual,idBloque,idGrupoCompartido)
							VALUES ('".$idMateria."','".$idGrupo."','".$hIg."','".$hFg."','".$idPrograma."','".$idCiclo."','".$idTipoMat."','".$idBloque."','".$idGrupoC."')";
					$ct++;			
				}
			}
			
			$query[$ct]="commit";
			if($con->ejecutarbloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function guardarHorarioConflictoProfesor2()
	{
		global $con;
		$cadenaDias=$_POST["cadenaDias"];
		$idPrograma=$_POST["idPrograma"];
		$idCiclo=$_POST["idCiclo"];
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		//$idTipoMat=$_POST["idTipoVirtual"];
		
		//$consulta=
		
		$arreglo=explode(",",$cadenaDias);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0; $x< $tamano;$x++)
			{
				$datosArr=explode("_",$arreglo[$x]);
				$hIg=$datosArr[0];
				$hFg=$datosArr[1];
				$idBloque=$datosArr[2];
				
				$conExiste="SELECT idMateriaVSGrupo FROM 4065_materiaVSGrupo WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND idBloque=".$idBloque ;
				$existe=$con->obtenerValor($conExiste);
				if($existe=="")
				{
					$query[$ct]="INSERT INTO 4065_materiaVSGrupo (idMateria,idGrupo,horaInicio,horaFin,idPrograma,ciclo,idBloque)
							VALUES ('".$idMateria."','".$idGrupo."','".$hIg."','".$hFg."','".$idPrograma."','".$idCiclo."','".$idBloque."')";
					$ct++;			
				}
			}
			
			$query[$ct]="commit";
			if($con->ejecutarbloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function obtenerProgramasCiclo()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$consulta="SELECT m.idPrograma,p.nombrePrograma FROM  4029_mapaCurricular m,4004_programa p 
						WHERE p.idPrograma=m.idPrograma AND m.ciclo=".$ciclo." ORDER BY p.nombrePrograma";	
		$arrProgramas=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrProgramas);
	}
	
	function guardarMatHorarioLibre()
	{
		global $con;
		$cadenaBloques=$_POST["cadena"];
		$cadenaMaterias=$_POST["cadenaMaterias"];
		$idGrupo=$_POST["idGrupo"];
		$idGrado=$_POST["idGrado"];
		$idMapaCurricular=$_POST["idMapaCurricular"];
		$idPrograma=$_POST["idPrograma"];
		$idCiclo=$_POST["idCiclo"];
		
		$arregloMat=explode(",",$cadenaMaterias);
		$tamanoMat=sizeof($arregloMat);
		$arregloBlo=explode(",",$cadenaBloques);
		$tamanoBlo=sizeof($arregloBlo);
		
		$consulta="begin";
		if($con->ejecutarconsulta($consulta))
		{
			$ct=0;
			for($z=0;$z<$tamanoMat;$z++)
			{
				$idMateria=$arregloMat[$z];
				for($x=0;$x<$tamanoBlo;$x++)
				{
					$datos=explode("_",$arregloBlo[$x]);
					$idBloque=$datos[0];
					$hIg=$datos[1];
					$hFg=$datos[2];
					$idTipoMat=operacionMateria($idMateria,$idMapaCurricular,$idGrado);
					$conExiste="SELECT idMateriaVSGrupo FROM 4065_materiaVSGrupo WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND idBloque=".$idBloque ;
					$existe=$con->obtenerValor($conExiste);
					if($existe=="")
					{
						$query[$ct]="INSERT INTO 4065_materiaVSGrupo (idMateria,idGrupo,horaInicio,horaFin,idPrograma,ciclo,tipoMateriaVirtual,idBloque,idGrupoCompartido)
								VALUES ('".$idMateria."','".$idGrupo."','".$hIg."','".$hFg."','".$idPrograma."','".$idCiclo."','".$idTipoMat."','".$idBloque."','0')";
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
	
	function guardarMateriaCompartida()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idPadre=$_POST["idPadre"];
		$idGrado=$_POST["idGrado"];
		$idMapaCurricular=$_POST["idMapaCurricular"];
		
		$idMapaMateria=obtenerMapaMateria($idMateria);
		
		if($idMapaMateria==$idMapaCurricular)
		{
			$consulta="SELECT *FROM 4031_elementosMapa WHERE idMateria=".$idMateria." AND idMapaCurricular=".$idMapaCurricular." AND perteneceMapa=1";
		}
		else
		{
			$consulta="SELECT *FROM 4031_elementosMapa WHERE idMateria=".$idMateria." AND idMapaCurricular=".$idMapaMateria." AND perteneceMapa=1";
		}
		
		$fila=$con->obtenerPrimeraFila($consulta);
		
		if($fila[6]=="")
			$fila[6]="NULL";
		
		if($fila[14]=="")
			$fila[14]="NULL";
		
		if($fila[15]=="")
			$fila[15]="NULL";
			
		if($fila[27]=="")
			$fila[27]="NULL";
		
		if($fila[29]=="")
			$fila[29]="NULL";
		
		
		$query="INSERT INTO 4031_elementosMapa
				(idMapaCurricular,idGrado,idPadre,idMateria,idTipoMateria,idTipoBoleta,promedia,idIdioma
				 ,idTipoComponente,idEscalaCalificacionOf,ponderacion,noSemanas,noMaterias,idTipoHorario,perteneceMapa,criterioEvaluacion,ponderaHijos
				 ,esquemaEvaluacion,materiasLibres,porcentajeLibres,materiasOptativasC,porcentajeOptativaC,sumaPorcentaje,noMateriasMax,bloques)
                  VALUES(".$idMapaCurricular.",".$idGrado.",".$idPadre.",".$idMateria.",".$fila[5].",".$fila[6].",".$fila[7].",".$fila[8]."
						 ,".$fila[9].",".$fila[10].",".$fila[13].",".$fila[14].",".$fila[15].",1000,0,".$fila[18].",".$fila[19]."
						 ,".$fila[20].",".$fila[21].",".$fila[22].",".$fila[23].",".$fila[24].",".$fila[27].",".$fila[28].",".$fila[29].")";
		
		//echo 
		if($con->ejecutarConsulta($query))
			echo "1|";
		else	
			echo "|"	  ;
	}
	
	function validarExisteMateriaCompartida()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		
		$consulta="SELECT idElementoMapa FROM 4031_elementosMapa WHERE idMateria=".$idMateria;
		$existe=$con->obtenerValor($consulta);
		if($existe=="")
			echo "1|";
		else
			echo "2|";
	}
	
	function inscribirMateriaHorario()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		$idUsuario=$_POST["idUsuario"];
		$hIni=$_POST["hIni"];
		$hFin=$_POST["hFin"];
		$dia=$_POST["dia"];
		$consulta="SELECT idPrograma,ciclo FROM 4013_materia WHERE idMateria=".$idMateria;
		$filaMat=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT idParticipacionPrincipal FROM 4029_mapaCurricular WHERE idPrograma=".$filaMat[0]." AND ciclo=".$filaMat[1];
		$idParticipacionP=$con->obtenerValor($consulta);
		if($idParticipacionP=="")
			$idParticipacionP=-1;
			
		$validarHorasMateria=validarHorasSemanaMateria($idMateria,$idGrupo,$filaMat[1],$hIni,$hFin);
		
		if(($validarHorasMateria==2) || ($validarHorasMateria==3))
		{
			
			if($validarHorasMateria==2)
			{
				echo "7|"; //problemas con las horas a la semana de la materia;
				return;
			}
			else
			{
				echo "8|"; // la materia no tiene horas semana;
				return;
			}
		}
		
		$validH=validarMaximoHorasPeriodo($idUsuario,$filaMat[1],$idMateria,$idGrupo);
		if($validH==1)
		{
			$validarHoraAlum=explode("|",validarGrupoAlumnos($idMateria,$idGrupo,$filaMat[1],$dia,$hIni,$hFin));
			if($validarHoraAlum[0]==1)
			{
				  $x=0;
				  $query[$x]="begin";
				  $x++;
				  $conTipoH="SELECT idTipoHorarioCurso FROM 4226_tipoHorarioCurso WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo;
				  $tH=$con->obtenerValor($conTipoH);
				  if($tH=="")
				  {
					  $query[$x]="INSERT INTO 4226_tipoHorarioCurso (idGrupo,idMateria,aplicacionHorario) VALUES (".$idGrupo.",".$idMateria.",2)";
					  $x++;
				  }
				  $query[$x]="INSERT INTO 4065_materiaVSGrupo(idMateria,idGrupo,horaInicio,horaFin,idPrograma,ciclo,tipoMateriaVirtual,idGrupoCompartido,dia)
							  VALUES(".$idMateria.",".$idGrupo.",'".date("H:i",strtotime($hIni))."','".date("H:i",strtotime($hFin))."',".$filaMat[0].",".$filaMat[1].",0,0,".$dia.")";
				  $x++;
				  
				  $conExiste="SELECT idParticipante FROM 4047_participacionesMateria WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND participacionP=1";
				  $existe=$con->obtenerValor($conExiste);
				  if($existe=="")
				  {
					  $query[$x]="INSERT INTO 4047_participacionesMateria(idUsuario,idMateria,idGrupo,idParticipacion,participacionP,estado,esperaContrato) 
								  VALUES(".$idUsuario.",".$idMateria.",".$idGrupo.",".$idParticipacionP.",1,1,1)";
					  $x++;
				  }
				  $query[$x]="commit";
				  $x++;
				  eB($query);
			}
			else
			{
				echo "4|".$validarHoraAlum[1];//lista de alumnos no validos
			}
		}
		else
		{
			switch($funcion)
			{
				case 2:
					echo "2|";//con lo que tiene rebasa el maximo
				break;
				case 3:
					echo "3|";//con materia rebasa el maximo
				break;
		    }
		}
	}
	
	function removerAsignacion()
	{
		global $con;
		$iA=$_POST["iA"]	;
		$consulta="delete from 4065_materiaVSGrupo where idMateriaVSGrupo=".$iA;
		eC($consulta);
	}
	
	function validarMaximoHorasPeriodo($idUsuario,$idCiclo,$idMateria,$idGrupo)
	{
		global $con;
		
		$sedeGrupo="SELECT sede FROM 4048_grupos WHERE idGrupo='".$idGrupo."'";
		$sedeG=$con->obtenerValor($sedeGrupo);
		if($sedeG=="")
			$sedeG="-1";
		
		$consulta="SELECT id__315_tablaDinamica,IntHrmin,IntHrMax,IntHrMedida FROM _315_tablaDinamica WHERE  codigoInstitucion='".$sedeG."'"; //AND cmbCiclo=".$idCiclo;
		$filaC=$con->obtenerPrimeraFila($consulta);
		if($filaC[0]=="")
		{
			return 1;
		}
		
		$noHoras=$filaC[2];
		$minutosClase=$filaC[3];
		
		$conHorasMateria="SELECT horaInicio,horaFin  FROM 4065_materiaVSGrupo WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo;
		$resHoras=$con->obtenerFilas($conHorasMateria);
		$tiemTotalM=0;
		
		while($horaMt=mysql_fetch_row($resHoras))
		{
			$tiempoMat=((strtotime('0:00:00'))+(strtotime($horaMt[1])))-(strtotime($horaMt[0]));
			$tiemTotalM+=(date('H',$tiempoMat)*60)+(date('i',$tiempoMat));
		}
		
		if($tiemTotalM!=0)
		{
			$tiempoRealMat=$tiemTotalM/$minutosClase;
		}
		else
		{
			$tiempoRealMat=0;
		}
		
		$conMateriasUsuario="SELECT p.idMateria,p.idGrupo FROM 4047_participacionesMateria p,4048_grupos g WHERE idUsuario=".$idUsuario." AND participacionP=1 AND estado=1 AND p.idGrupo=g.idGrupo AND ciclo=".$idCiclo;
		$resMaterias=$con->obtenerFilas($conMateriasUsuario);
		$noFilas=$con->filasAfectadas;
		if($noFilas==0)
		{
			if($tiempoRealMat>$noHoras)
			{
				return 3;//con la materia rebasa el maximo
			}
			else
			{
				return 1;
			}
		}
		else
		{
			$tiempoTotal=0;
			while($fila=mysql_fetch_row($resMaterias))
			{
				$conHorarioGrupo="(SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
									  WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$fila[0]." AND idGrupo=".$fila[1]." AND ciclo=".$idCiclo.")
									  UNION
									  (			  
									  SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
									  WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$fila[0]." AND idGrupoCompartido=".$fila[1]." AND ciclo=".$idCiclo.")
									  UNION
									  (SELECT dia,horaInicio,horaFin,idPrograma,'0' AS idPerfil FROM 4065_materiaVSGrupo 
									  WHERE  idMateria=".$fila[0]." AND idGrupo=".$fila[1]." AND ciclo=".$idCiclo.")";
				$res=$con->obtenerFilas($conHorarioGrupo);					  
				
				while($fHoras=mysql_fetch_row($res))
				{
					$tiempo=((strtotime('0:00:00'))+(strtotime($fHoras[2])))-(strtotime($fHoras[1]));
					$tiempoTotal+=(date('H',$tiempo)*60)+(date('i',$tiempo));
				}
			}
			
			if($tiempoTotal==0)
			{
				if($tiempoRealMat>$noHoras)
				{
					return 3;
				}
				else
				{
					return 1;
				}
			}
			else
			{
				$tiempoReal=$tiempoTotal/$minutosClase;
				if($tiempoReal>$noHoras)
				{
					return 2;//con lo que ya tiene rebasa el maximo
				}
				else
				{
					if(($tiempoRealMat+$tiempoReal)>$noHoras)
					{
						return 3;
					}
					else
					{
						return 1;
					}
				}
			}
		}
	}
	
	function validarGrupoAlumnos($idMateria,$idGrupo,$idCiclo,$dia,$hIni,$hFin)
	{
		global $con;
		
		//$conHorarioMat="SELECT dia,horaInicio,horaFin FROM 4065_materiaVSGrupo WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo;
//		$resHorMat=$con->obtenerFilas($conHorarioMat);
//		$noFilas=$con->filasAfectadas;
//		if($noFilas==0)
//		{
//			return 1;
//		}
		
		$consulta="SELECT idusuario FROM 4120_alumnosVSElementosMapa WHERE idMateria=".$idMateria." AND idGrupo=".$idMateria." AND situacion=1";
		$res=$con->obtenerFilas($consulta);
		$noFilas=$con->filasAfectadas;
		if($noFilas==0)
		{
			return "1|";
		}
		else
		{
			$mensajeColision="";
			while($fila=mysql_fetch_row($res))
			{
				$conMatAlum="SELECT a.idMateria,idGrupo FROM 4120_alumnosVSElementosMapa a,4013_materia m WHERE a.idMateria=m.idMateria AND ciclo=".$idCiclo." AND idUsuario=".$fila[0];
				$resAlum=$con->obtenerFilas($conMatAlum);
				while($filaMat=mysql_fetch_row($resAlum))
				{
					$consulta="(SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
						  WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$filaMat[0]." AND idGrupo=".$filaMat[1]." AND ciclo=".$idCiclo.")
						  UNION
						  (			  
						  SELECT p.dia,m.horaInicio,m.horaFin,m.idPrograma,p.idPerfil FROM 4062_perfilVSBloque p,4065_materiaVSGrupo m 
						  WHERE  m.idBloque=idPerfilVSBloque AND idMateria=".$filaMat[0]." AND idGrupoCompartido=".$filaMat[1]." AND ciclo=".$idCiclo.")
						  UNION
						  (SELECT dia,horaInicio,horaFin,idPrograma,'0' AS idPerfil FROM 4065_materiaVSGrupo 
						  WHERE  idMateria=".$filaMat[0]." AND idGrupo=".$filaMat[0]." AND ciclo=".$idCiclo.")";
					$resMatAlum=$con->obtenerFilas($consulta);
					while($filaAlum=mysql_fetch_row($resMatAlum))
					{
						if($dia==$filaAlum[0])
						{
							if(colisionaTiempo($filaAlum[1],$filaAlum[2],$hIni,$hFin))
							{
								$nombre=obtenerNombreUsuario($fila[0]);
								if($mensajeColision=="")
									$mensajeColision="<tr><td>".$nombre."</td></tr>";
								else
									$mensajeColision.="<tr><td>".$nombre."</td></tr>";
							}
						}
					}
				}
			}
			if($mensajeColision=="")
			{
				return "1|";
			}
			else
			{
				$cabecera="<tr><td class='letraExt' width='200'></td></tr>";
				$cadenaFinal="<table>".$cabecera.$mensajeColision."</table>";
				return "2|".$cadenaFinal;
			}
		}
	}
	
	function validarHorasSemanaMateria($idMateria,$idGrupo,$idCiclo,$horaI,$horaF)
	{
		global $con;
		
		$horaI=date("H:i",strtotime($horaI));
		$horaF=date("H:i",strtotime($horaF));
		$conHorasSemana="SELECT horasSemana FROM 4013_materia WHERE idMateria=".$idMateria;
		$noHoras=$con->obtenerValor($conHorasSemana);
		if($noHoras=="")
		{
			return 3;
		}
		
		$sedeGrupo="SELECT sede FROM 4048_grupos WHERE idGrupo='".$idGrupo."'";
		$sedeG=$con->obtenerValor($sedeGrupo);
		if($sedeG=="")
			$sedeG="-1";
			
		$conUnidadMedida="SELECT IntHrMedida FROM _315_tablaDinamica WHERE codigoInstitucion='".$sedeG."'"; //WHERE cmbCiclo=".$idCiclo;
		$unidadM=$con->obtenerValor($conUnidadMedida);
		if($unidadM=="")
			$unidadM=60;
		
		$tiempoMat=((strtotime('0:00:00'))+(strtotime($horaF)))-(strtotime($horaI));
		$nuevosMin=(date('H',$tiempoMat)*60)+(date('i',$tiempoMat));
		
		$conHorMat="SELECT dia,horaInicio,horaFin FROM 4065_materiaVSGrupo WHERE  idMateria=".$idMateria." AND idGrupo=".$idGrupo." and ciclo=".$idCiclo;
		$resHorMat=$con->obtenerFilas($conHorMat);
		$numeroFilas=$con->filasAfectadas;
		if($numeroFilas==0)			
		{
			$validar=$nuevosMin/$unidadM;
			if($validar>$noHoras)
			{
				//echo "2|";
				return 2;
			}
			else
			{
				//echo "1|";
				return 1;
			}
		}
		else
		{
			$sumatoriaMinutos=0;
			while($hMat=mysql_fetch_row($resHorMat))			
			{
				$tiempoMat=((strtotime('0:00:00'))+(strtotime($hMat[2])))-(strtotime($hMat[1]));
				$sumatoriaMinutos+=(date('H',$tiempoMat)*60)+(date('i',$tiempoMat));
				
			}
			
			$minutosReales=$sumatoriaMinutos+$nuevosMin;
			$validar=$minutosReales/$unidadM;
			if($validar>$noHoras)
			{
				//echo "2|";
				return 2;
			}
			else
			{
				//echo "1|";
				return 1;
			}
		}
	}
?>