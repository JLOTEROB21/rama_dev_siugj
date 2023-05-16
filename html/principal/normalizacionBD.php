<?php include("conexionBD.php");

$x=0;
$query[$x]="begin";
$x++;
$consulta="SELECT * FROM 4001_procesos";
$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_assoc($res))
{
	$consulta="SELECT * FROM 900_formularios WHERE idProceso=".$fila["idProceso"]." AND tipoFormulario IN(0,14)";
	$rFormulario=$con->obtenerFilas($consulta);
	while($fFormulario=mysql_fetch_assoc($rFormulario))
	{
		$nTabla=obtenerNombreTabla($fFormulario["idFormulario"]);
		$query[$x]="INSERT INTO 20800_relacionLlavesForaneas(tablaBase,campoBase,tablaRefiere,campoRefiere) VALUES('".$nTabla."','responsable','800_usuarios','idUsuario')";
		$x++;
		$query[$x]="INSERT INTO 20800_relacionLlavesForaneas(tablaBase,campoBase,tablaRefiere,campoRefiere) VALUES('".$nTabla."','respModif','800_usuarios','idUsuario')";
		$x++;
		$query[$x]="INSERT INTO 20800_relacionLlavesForaneas(tablaBase,campoBase,tablaRefiere,campoRefiere) VALUES('".$nTabla."','codigoUnidad','817_organigrama','codigoUnidad')";
		$x++;
		$query[$x]="INSERT INTO 20800_relacionLlavesForaneas(tablaBase,campoBase,tablaRefiere,campoRefiere) VALUES('".$nTabla."','codigoInstitucion','817_organigrama','codigoUnidad')";
		$x++;
	}

}

$consulta="SELECT * FROM 4001_procesos where idTipoProceso=3";
$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_assoc($res))
{
	$consulta="SELECT * FROM 900_formularios WHERE idProceso=".$fila["idProceso"]." and formularioBase=1";
	$rFormulario=$con->obtenerFilas($consulta);
	while($fFormulario=mysql_fetch_assoc($rFormulario))
	{
		$nTabla=obtenerNombreTabla($fFormulario["idFormulario"]);
		$consulta="SELECT * FROM 900_formularios WHERE idProceso=".$fila["idProceso"]." and formularioBase<>1";
		$rFormularioDerivado=$con->obtenerFilas($consulta);
		while($fFormularioDerivado=mysql_fetch_assoc($rFormularioDerivado))
		{
			$nTablaDerivada=obtenerNombreTabla($fFormularioDerivado["idFormulario"]);
			$query[$x]="INSERT INTO 20800_relacionLlavesForaneas(tablaBase,campoBase,tablaRefiere,campoRefiere) VALUES('".$nTablaDerivada."','idReferencia','".$nTabla."','id_".$nTabla."')";
			$x++;
		}
	}

}


$consulta="SELECT * FROM 900_formularios WHERE tipoFormulario IN(0,14)";
$rFormulario=$con->obtenerFilas($consulta);
while($fFormulario=mysql_fetch_assoc($rFormulario))
{
  $nTabla=obtenerNombreTabla($fFormulario["idFormulario"]);
  $consulta="SELECT * FROM 901_elementosFormulario WHERE idFormulario=".$fFormulario["idFormulario"]." AND tipoElemento IN(17,18,19,29)";
  $rElemento=$con->obtenerFilas($consulta);
  while($fElemento=mysql_fetch_assoc($rElemento))
  {
	  $nTablaBase="_".$fElemento["idFormulario"]."_".$fElemento["nombreCampo"];
	  if($con->existeTabla($nTablaBase))
	  {
		  if($con->existeCampo("idPadre",$nTablaBase))
		  {
			  $query[$x]="INSERT INTO 20800_relacionLlavesForaneas(idElementoFormulario,tablaBase,campoBase,tablaRefiere,campoRefiere) VALUES(".$fElemento["idGrupoElemento"].",'".$nTablaBase."','idPadre','".$nTabla."','id_".$nTabla."')";
			  $x++;
		  }
		  else
		  {
			  if($con->existeCampo("idReferencia",$nTablaBase))
			  {
				  $query[$x]="INSERT INTO 20800_relacionLlavesForaneas(idElementoFormulario,tablaBase,campoBase,tablaRefiere,campoRefiere) VALUES(".$fElemento["idGrupoElemento"].",'".$nTablaBase."','idReferencia','".$nTabla."','id_".$nTabla."')";
				  $x++;
			  }
		  }
	  }
	  
	  
	  
	  
  }
  
  $consulta="SELECT * FROM 901_elementosFormulario WHERE idFormulario=".$fFormulario["idFormulario"]." AND tipoElemento IN(12)";
  $rElemento=$con->obtenerFilas($consulta);
  while($fElemento=mysql_fetch_assoc($rElemento))
  {
	  	$query[$x]="INSERT INTO 20800_relacionLlavesForaneas(idElementoFormulario,tablaBase,campoBase,tablaRefiere,campoRefiere) VALUES(".$fElemento["idGrupoElemento"].",'".$nTabla."','".$fElemento["nombreCampo"]."','908_archivos','idArchivo')";
	  	$x++;
  }
  
  $consulta="SELECT * FROM 901_elementosFormulario WHERE idFormulario=".$fFormulario["idFormulario"]." AND tipoElemento IN(19,16,4)";
  $rElemento=$con->obtenerFilas($consulta);
  while($fElemento=mysql_fetch_assoc($rElemento))
  {
	  	$informacion=obtenerInformacionDataSetControlFormulario($fElemento["idGrupoElemento"]);
	  
	  	$nTablaBase=$informacion["tablaCampoID"];
		$nCampoBase=$informacion["campoID"];
	  	$query[$x]="INSERT INTO 20800_relacionLlavesForaneas(idElementoFormulario,tablaBase,campoBase,tablaRefiere,campoRefiere,esCampoLlaveBase) VALUES(".
				$fElemento["idGrupoElemento"].",'".$nTabla."','".$fElemento["nombreCampo"]."','".$nTablaBase."','".$nCampoBase."',".$informacion["campoID_EsLlaveTabla"].")";
		$x++;	  
  }
}




$query[$x]="commit";
$x++;

eB($query);
?>