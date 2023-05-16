<?php session_start();

	include("conexionBD.php");
	
	$fechaInicio=$_POST["fechaInicio"];
	$fechaFin=$_POST["fechaFin"];
	$tipoEventos=$_POST["tipoEventos"];
	$pagina=$_POST["pagina"];
	$idUsuario=$_POST["idUsuario"];
	
	$condWhere="1=1 ";
	
	
	if($idUsuario!="-1")
	{
		$condWhere.=" and idUsuario=".$idUsuario;
	}
	
	if($tipoEventos!=-1)
	{
		$condWhere.=" and tipo in(".$tipoEventos.")";
	}
	
	if($pagina!="")
	{
		$condWhere.=" and pagina like '%".$pagina."%'";
	}
	
	
	
	$libro=new cExcel($baseDir."/Usuarios/plantillas/bitacoraAcceso.xlsx",true,"Excel2007");
	
	
	$libro->setValor("C3","Del ".date("d/m/Y",strtotime($fechaInicio))." al ".date("d/m/Y",strtotime($fechaFin)));
	$libro->setValor("C4",date("d/m/Y H:i:s"));
	
	$numFila=7;
	$numElemento=1;
	

			
	$consulta="SELECT idLog,fecha,(SELECT nombreTipoRegistro FROM 00019_tiposRegistroBitacora WHERE idTipoRegistro=l.tipo) as tipo,hora,pagina,parametros,dirIP,consultaSql,(select Nombre from 800_usuarios u where u.idUsuario=l.idUsuario) as nombreUsuario,idUsuario 
					FROM 8000_logSistema l WHERE ".$condWhere." and fecha>='".$fechaInicio."' AND fecha<='".$fechaFin."'   order by fechaEvento desc";
	
	
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		
		$libro->setValor("A".$numFila,$numElemento);
		$libro->setValor("B".$numFila,date("d/m/Y",strtotime($fila["fecha"])));
		$libro->setValor("C".$numFila,date("H:i:s",strtotime($fila["hora"])));
		$libro->setValor("D".$numFila,$fila["nombreUsuario"]);
		$libro->setValor("E".$numFila,$fila["tipo"]);
		
		$libro->setValor("F".$numFila,$fila["pagina"]);
		$libro->setValor("G".$numFila,$fila["parametros"]);
		$libro->setValor("H".$numFila,$fila["dirIP"]);
		
		$libro->setValor("I".$numFila,$fila["consultaSql"]);
		
		
		$libro->setBorde("A".$numFila.":I".$numFila,"DE");
		$numFila++;
		$numElemento++;
		
	}
	$directorioDestino="bitacoraAcceso_".str_replace("-","_",$fechaInicio)."_al_".str_replace("-","_",$fechaFin);
	
	$formato=$_POST["formato"]==1?"PDF":"Excel2007";
	$extension=$_POST["formato"]==1?"pdf":"xlsx";
	if($extension=="xlsx")
	{
		$directorioDestino.=".xlsx";
	}
	
	$libro->generarArchivo($formato,$directorioDestino);
	
	
	
	
?>