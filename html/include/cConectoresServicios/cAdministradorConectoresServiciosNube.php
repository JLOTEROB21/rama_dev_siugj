<?php  
ini_set("memory_limit","3000M");
set_time_limit(999000);
error_reporting(E_ALL);


const AGENDA_CALENDARIO=1;

include("conexionBD.php");
$consulta="SELECT * FROM 20000_conectoresServiciosNube";
$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_assoc($res))
{
	if(file_exists($baseDir."/include/".$fila["archivoInclude"]))
		include_once($fila["archivoInclude"]);
}

class cAdministradorConectoresServiciosNube
{

	function cAdministradorConectoresServiciosNube()
	{

	}
	
	
	function obtenerEventosCalendariosUsuario($idUsuario,$fechaInicio,$fechaFin,$proteccionUsuario=true,$tituloEventoProtegido="")
	{
		global $con;
		$arrRegistroEventos=array();
		$arrEventosGlobal=array();
		$consulta="SELECT idConexion,tipoConector FROM 20001_conexionesServiciosNube cN,20001_serviciosConexionNube sN WHERE cN.idUsuario=".$idUsuario.
				" and sN.idConexionServicioNube=cN.idConexion and sN.tipoServicio=".AGENDA_CALENDARIO;

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$c=$this->crearConectorServicio($fila["tipoConector"],$fila["idConexion"]);
			$arrEventos=$c->obtenerEventosRango($fechaInicio,$fechaFin);
			
			if(($proteccionUsuario)&&($idUsuario!=$_SESSION["idUsr"]))
			{
				$arrEventosAux=array();
				foreach($arrEventos as $e)
				{
					
					$e["actividad"]=$tituloEventoProtegido==""?"Actividad de Usuario (".obtenerNombreUsuario($idUsuario).")":$tituloEventoProtegido;
				
					array_push($arrEventosAux,$e);
				}
				
				$arrEventos=$arrEventosAux;
			}
			foreach($arrEventos as $e)
			{
				if(!isset($arrRegistroEventos[$e["id"]]))
					array_push($arrEventosGlobal,$e);
			}
		}
		
		return $arrEventosGlobal;
		
		
	}
	
	function crearConectorServicio($tipoConector,$idConexion)
	{
		global $con;
		$consulta="SELECT nombreClase FROM 20000_conectoresServiciosNube WHERE idTipoConector=".$tipoConector;
		$nombreClase=$con->obtenerValor($consulta);
		
		$cConector=null;
		eval('$cConector=new '.$nombreClase.'('.$idConexion.');');
		return $cConector;
	}
}


?>