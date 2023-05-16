<?php session_start();
	include("conexionBD.php");
	
	$funcion="-1";
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	
	switch($funcion)
	{
		case "1":
			eliminarCategoria();
		break;
		case "2":
			eliminarUnidadApartado();
		break;
		case 3:
			obtenerUnidadApartado();
		break;
		case 4:
			obtenerHorasInicialesFinales();
		break;
		case 5:
			obtenerSolicitudes();
		break;
		case 6:
			asignarHorario();
		break;
		case 7:
			marcarReasignacion();
		break;
		
	}
	
	function eliminarCategoria()
	{
		global $con;
		$idCategoria=$_POST["idCategoria"];
		$consulta="delete from 920_categoriasUnidadesApartado  where idCategoria=".$idCategoria;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
		
	}
	
	function eliminarUnidadApartado()
	{
		global $con;		
		$idUnidadApartado=$_POST["idUnidad"];
		$consulta="delete from 919_unidadesApartado  where idUnidadApartado=".$idUnidadApartado;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
		
	}
	
	function obtenerUnidadApartado()
	{
		global $con;
		$idCategoria=$_POST["idCategoria"];
		$idProceso=$_POST["idProceso"];
		$consulta="	select idUnidadApartado,unidad from 919_unidadesApartado where idCategoria=".$idCategoria." and idUnidadApartado 
					not in(select idUnidadApartado from 923_UnidadesApartadoVSProcesos where idProceso=".$idProceso.")";
		$arrUnidades=$con->obtenerFilasArreglo($consulta);
		
		echo "1|".uEJ($arrUnidades);
		
	}
	
	function obtenerHorasInicialesFinales()
	{
		global $con;
		$dia=$_POST["dia"];
		$idProceso=$_POST["idProceso"];
		$consulta="select hInicial,hFinal from 927_horariosConfiguracionCita where tipo=0 and idProceso=".$idProceso." and dia=".$dia;
		$filaResp=$con->obtenerPrimeraFila($consulta);
		if(!$filaResp)
		{
			echo "1|2";
		}
		else
		{
			echo "1|1|".date('H:i',strtotime($filaResp[0]))."|".date('H:i',strtotime($filaResp[1]));
		}
	}
	
	function obtenerSolicitudes()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idUnidad=$_POST["idUnidad"];
		$condicion=$_POST["condicion"];
		$consulta="select idProceso,nombreTabla from 900_formularios where idFormulario=".$idFormulario;
		$filaResp=$con->obtenerPrimeraFila($consulta);
		$nombreTabla=$filaResp[1];
		
		$consulta="select id_".$nombreTabla.",fechaCreacion,(select concat(Prefijo,' ',Nom,' ',Paterno,' ',Materno) from 802_identifica where idUsuario=t.responsable),dtefechaSolicitud,tmeHoraInicio,tmeHoraFin  from ".$nombreTabla." t where idEstado in(1,6) and ".$condicion."  order by dtefechaSolicitud,tmeHoraInicio";
		$arrSolicitudes=$con->obtenerFilasArreglo($consulta);		
		echo "1|".uEJ($arrSolicitudes);
	}
	
	function asignarHorario()
	{
		global $con;
		$idReg=$_POST["idRegistro"];
		$fechaAsig=$_POST["fecha"];
		$idUnidad=$_POST["idUnidad"];
		$idFormulario=$_POST["idFormulario"];
		$hInicio=$_POST["hInicio"];
		$hFin=$_POST["hFin"];
		$estado=2;
		
		
		
		$query="select idProceso,nombreTabla from 900_formularios where idFormulario=".$idFormulario;
		$filaResp=$con->obtenerPrimeraFila($query);
		$idProceso=$filaResp[0];
		$nombreTabla=$filaResp[1];
		$x=0;
		$query="select idEstado from ".$nombreTabla." where id_".$nombreTabla."=".$idReg;
		$edo=$con->obtenerValor($query);
		if($edo==6)
			$estado=7;
		$consulta[$x]="begin";
		$x++;
		
		
		$consulta[$x]="update ".$nombreTabla." set idEstado=".$estado.",dteFechaAsignada='".cambiaraFechaMysql($fechaAsig)."',tmeHoraInicialAsignada='".$hInicio."',
					tmeHoraFinalAsignada='".$hFin."' where id_".$nombreTabla."=".$idReg;
		$x++;
		$consulta[$x]="insert into 925_horarioUnidadesApartado(idUnidadApartado,horaInicio,horaFin,fecha,proceso,idRegistro,nombreTabla,estado) 
						values(".$idUnidad.",'".$hInicio."','".$hFin."','".cambiaraFechaMysql($fechaAsig)."',".$idProceso.",".$idReg.",'".$nombreTabla."',2)";
		
		$x++;
		
		$consulta[$x]="commit";
		if($con->ejecutarBloque($consulta))
		{
			echo "1|";
		}
		else
			echo "|";
	}
	
	function marcarReasignacion()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$idAsignacion=$_POST["idAsignacion"];
		$query="select nombreTabla from 900_formularios where idFormulario=".$idFormulario;
		$nomTabla=$con->obtenerValor($query);
		$consulta[0]="begin";
		$consulta[1]="update ".$nomTabla." set idEstado=6 where id_".$nomTabla."=".$idRegistro;
		$consulta[2]="update 925_horarioUnidadesApartado set estado=6 where idHApartado=".$idAsignacion;
		$consulta[3]="commit";
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
		
		
		
		
	}
?>