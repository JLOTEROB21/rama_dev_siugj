<?php 
	include_once("conexionBD.php");

	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	
	switch($funcion)
	{
		
		case 1:
			obtenerEventosFechaSala();
		break;
	}


	
	function obtenerEventosFechaSala()
	{
		global $con;
		global $tipoMateria;
		$idSala=$_POST["idSala"];
		$asignacionJuez=$_POST["asignacionJuez"];
		
		$arrEventos="";
		
		
		$start=$_POST["start"];
		$end=$_POST["end"];
		
		$consulta="SELECT if(horaInicioReal is null,horaInicioEvento,horaInicioReal),if(horaTerminoReal is null,horaFinEvento,horaTerminoReal),
					(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=a.tipoAudiencia) as tipoAudiencia,idRegistroEvento FROM 7000_eventosAudiencia a
					WHERE idSala=".$idSala." AND fechaEvento>='".$start."' AND fechaEvento<='".$end."' and 
					a.situacion=1";
	
	
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			
			
			$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$fila[3];
			$cAdministrativa=$con->obtenerValor($consulta);
			
			
			$e='{"id":"e_'.$fila[3].'","editable":false,"title":"('.$fila[3].') '.cv($fila[2]).' ['.$cAdministrativa.']","start":"'.date("Y-m-d\TH:i:s",strtotime($fila[0])).'","end":"'.date("Y-m-d\TH:i:s",strtotime($fila[1])).'","color":"#030"}';	
			if($arrEventos=="")
				$arrEventos=$e;
			else
				$arrEventos.=",".$e;
		}
		
		
		echo '['.$arrEventos.']';
		
	}
?>