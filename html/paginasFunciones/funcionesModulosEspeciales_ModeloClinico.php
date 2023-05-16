<?php session_start();
	;
	include("funcionesFormularios.php"); 
	include("configurarIdioma.php");
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
				registrarHorarioEspecialidad();
			break;
			case 2:
				obtenerHorariosEspecialidad();
			break;
			case 3:
				actualizarDuracionCita();
			break;
			case 4:
				removerHorarioCita();
			break;
			case 5:
				obtenerAreasFisicas();
			break;
			case 6:
				removerAreaFisica();
			break;
			case 7:
				agregarAreaFisica();
			break;
			case 8:
				obtenerCitas();
			break;
			case 9:
				guardarCita();
			break;
			
		}
	}
	
	
	function registrarHorarioEspecialidad()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idRegistro==-1)
		{
			$consulta="INSERT INTO 1201_horariosEspecialidad(institucion,especialidad,dia,horaInicio,horaFin)
					VALUES('".$_SESSION["codigoInstitucion"]."',".$obj->especialidad.",".date("w",strtotime($obj->fechaInicio)).",'".date("H:i:s",strtotime($obj->fechaInicio)).
					"','".date("H:i:s",strtotime($obj->fechaFin))."')";
		}
		else
		{
			$consulta="UPDATE 1201_horariosEspecialidad SET horaInicio='".date("H:i:s",strtotime($obj->fechaInicio))."',horaFin='".date("H:i:s",strtotime($obj->fechaFin))."' WHERE idHorario=".$obj->idRegistro;
		}
		if($con->ejecutarConsulta($consulta))
		{
			if($obj->idRegistro==-1)	
			{
				$obj->idRegistro=$con->obtenerUltimoID();	
			}
			echo "1|".$obj->idRegistro;	
		}
		
	}
	
	function obtenerHorariosEspecialidad()
	{
		global $con;
		global $arrFechasHorario;
		$idEspecialidad=$_POST["idEspecialidad"];	
		
		$consulta="SELECT especialidad FROM _1005_tablaDinamica WHERE id__1005_tablaDinamica=".$idEspecialidad;
		$especialidad=$con->obtenerValor($consulta);
		$arrRegistros="";
		
		
		$consulta="SELECT idHorario,horaInicio,horaFin,dia FROM 1201_horariosEspecialidad WHERE institucion='".$_SESSION["codigoInstitucion"]."' AND especialidad=".$idEspecialidad;
		$res=$con->obtenerFilas($consulta);
		
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT COUNT(*) FROM 1203_areasFisicasEspecialidad WHERE idBloque=".$fila[0];
			$totalAreas=$con->obtenerValor($consulta);
			$fechaBase=$arrFechasHorario[$fila[3]];
			$obj='	{
						  "id": "'.$fila[0].'",
						  "cid": "1",
						  "title": "<a href=\'javascript:removerBloque(\\"'.bE($fila[0]).'\\")\'><img src=\'../images/delete.png\' title=\'Remover Bloque de cita\' alt=\'Remover Bloque de cita\'></a> <a href=\'javascript:agregarAreaFisica(\\"'.bE($fila[0]).'\\")\'><img src=\'../images/chart_organisation.png\' title=\'Agregar área física\' alt=\'Agregar área física\'></a>Especialidad:'.cv($especialidad).
						  '<br><br>Áreas asignadas: '.$totalAreas.'",
						  "start": "'.$fechaBase.' '.$fila[1].'",
						  "end": "'.$fechaBase.' '.$fila[2].'",
						  "ad": 0,
						  "notes": "",
						  "loc":"",
						  "url":"",
						  "rem":"",
						  "rO":0,
						  "tipoEvento":"0"
					  }';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
		}
		
		echo  	'{
                    "evts": ['.$arrRegistros.']
                }';
		
	}
	
	
	function actualizarDuracionCita()
	{
		global $con;
		$idEspecialidad=$_POST["idEspecialidad"];	
		$duracionCita=$_POST["duracionCita"];
		$consulta="SELECT idConfiguracion FROM 1202_configuracionCitaEspecialidad WHERE institucion='".$_SESSION["codigoInstitucion"]."' AND idEspecialidad=".$idEspecialidad;
		$idConfiguracion=$con->obtenerValor($consulta);
		if($idConfiguracion=="")
			$consulta="INSERT INTO 1202_configuracionCitaEspecialidad(institucion,idEspecialidad,duracionCita) VALUES('".$_SESSION["codigoInstitucion"]."',".$idEspecialidad.",".$duracionCita.")";
		else
			$consulta="update 1202_configuracionCitaEspecialidad set duracionCita=".$duracionCita." where idConfiguracion=".$idConfiguracion;
		eC($consulta);;
			
	}
	
	function removerHorarioCita()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 1201_horariosEspecialidad WHERE idHorario=".$idRegistro;
		$x++;
		$consulta[$x]="DELETE FROM 1203_areasFisicasEspecialidad WHERE idBloque=".$idRegistro;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);	
	}
	
	function obtenerAreasFisicas()
	{
		global $con;
		$idBloque=$_POST["idBloque"];
		$consulta="SELECT t.idAreaFisica as idArea,u.nombreArea as descripcion,horarioInicial,horarioFinal FROM 1203_areasFisicasEspecialidad t,9309_ubicacionesFisicas u 
				WHERE idBloque=".$idBloque." AND u.idAreaFisica=t.idAreaFisica";
		
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));	
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
			
	}
	
	function removerAreaFisica()
	{
		global $con;
		$idBloque=$_POST["idBloque"];
		$idArea=$_POST["idArea"];
		$consulta="DELETE FROM 1203_areasFisicasEspecialidad WHERE idAreaFisica=".$idArea." AND idBloque=".$idBloque;
		eC($consulta);
	}
	
	function agregarAreaFisica()
	{
		global $con;
		$idBloque=$_POST["idBloque"];
		$idArea=$_POST["idArea"];
		$hInicial=$_POST["hInicial"];
		$hFinal=$_POST["hFinal"];
		$consulta="INSERT INTO 1203_areasFisicasEspecialidad(idAreaFisica,idBloque,horarioInicial,horarioFinal)
					VALUES(".$idArea.",".$idBloque.",'".$hInicial."','".$hFinal."')";
		eC($consulta);
	}
	
	
	function obtenerCitas()
	{
		global $con;
		
		$idEspecialidad=$_POST["idEspecialidad"];
		$idMedico=$_POST["idMedico"];
		if($idMedico=="")
			$idMedico=0;
		$fechaInicio=$_POST["start"];
		$fechaFin=$_POST["end"];
		
		$arrBase=explode("-",$fechaInicio);
		$fechaStrBase=$arrBase[2]."-".$arrBase[0]."-".$arrBase[1];

		$fBase=date("Y-m-d",strtotime($fechaStrBase));
		
		$arrEvento="";
		$consulta="SELECT duracionCita FROM 1202_configuracionCitaEspecialidad WHERE institucion='".$_SESSION["codigoInstitucion"]."' AND idEspecialidad=".$idEspecialidad;
		$duracionCita=$con->obtenerValor($consulta);
		if($duracionCita=="")
			$duracionCita=60;
		
		$nRegistro=1;
		$consulta="SELECT a.* FROM 1201_horariosEspecialidad h,1203_areasFisicasEspecialidad a WHERE h.institucion='".$_SESSION["codigoInstitucion"]."' AND h.especialidad=".$idEspecialidad."
					AND a.idBloque=h.idHorario AND h.dia=".date("w",strtotime($fechaInicio));
		

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{

			$hInicio=strtotime($fila[3]);
			$hFin=strtotime($fila[4]);
			while($hInicio<$hFin)
			{
				$consulta="SELECT nombreArea FROM 9309_ubicacionesFisicas WHERE idAreaFisica=".$fila[1];
				$unidad=$con->obtenerValor($consulta);
				$consulta="SELECT COUNT(*) FROM 1200_citasMedicas WHERE idEspecialidad=".$idEspecialidad." AND idAreaFisica=".$fila[1]." AND fecha='".$fBase."' AND hora='".date("H:i:s",$hInicio)."'";
				
				$cid=1;
				$titulo="Disponible (".$unidad.")";
				$nReg=$con->obtenerValor($consulta);
				if($nReg>0)
				{
					$cid=2;
					$titulo="NO Disponible (".$unidad.")";
				}
				$obj='	{
						  "id": "'.$nRegistro.'_'.$fila[1].'",
						  "cid": "'.$cid.'",
						  "title": "'.$titulo.'",
						  "start": "'.$fBase.' '.date("H:i:s",$hInicio).'",
						  "end": "'.$fBase.' '.date("H:i:s",strtotime("+".$duracionCita." minutes",$hInicio)).'",
						  "ad": 0,
						  "notes": "",
						  "loc":"",
						  "url":"",
						  "rem":"",
						  "rO":0,
						  "tipoEvento":"1"
					  }';
				if($arrEvento=="")
					$arrEvento=$obj;
				else
					$arrEvento.=",".$obj;
					
				$hInicio=strtotime("+".$duracionCita." minutes",$hInicio);
				$nRegistro++;
			}
			
			
			
				
		}
		
	
		echo  	'{
					  "evts": ['.$arrEvento.']
				  }';
	}
	
	function guardarCita()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);	
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="INSERT INTO 1200_citasMedicas(fecha,hora,idEspecialidad,idMedico,idUsuario,idAreaFisica,idReferencia) 
					VALUES('".$obj->fecha."','".$obj->hora."',".$obj->idEspecialidad.",".$obj->idMedico.",".$obj->idPaciente.",".$obj->idAreaFisica.",".$obj->idReferencia.")";
		$x++;
		$consulta[$x]="UPDATE _1023_tablaDinamica SET fechaCita='".$obj->fecha." ".$obj->hora."' WHERE id__1023_tablaDinamica=".$obj->idReferencia;
		$x++;
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
?>