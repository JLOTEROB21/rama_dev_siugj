<?php
include_once("conexionBD.php");


$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica where codigo is null";
$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_assoc($res))
{
	$folio=generarFolioProcesos(17,$fila["id__17_tablaDinamica"]);
	$consulta="UPDATE _17_tablaDinamica SET codigo='".$folio."' WHERE id__17_tablaDinamica=".$fila["id__17_tablaDinamica"];
	$con->ejecutarConsulta($consulta);
}

return;

$arrEstructura=array();
$nodo["codigoUnidad"]="100000040001000500010001";
agregarNodoDespachoEstructuraOrganizacional($arrEstructura,$nodo);
$nodo["codigoUnidad"]="100000040001001100010001";
agregarNodoDespachoEstructuraOrganizacional($arrEstructura,$nodo);

varDUmp($arrEstructura);


function agregarNodoDespachoEstructuraOrganizacional(&$arrEstructura,$nodo)
{
	global $con;
	$arrDescomponerNodo=$nodo["codigoUnidad"];
	$arrRuta=array();
	
	$totalNiveles=strlen($nodo["codigoUnidad"])/4;
	
	
	for($x=0;$x<$totalNiveles;$x++)
	{
		$arrRuta[$x]=substr($nodo["codigoUnidad"],0,(4*($x+1)));
	}
	

	
	for($x=0;$x<$totalNiveles;$x++)
	{
		$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,codigoDepto,status,
							(case status when '1'  then 'Activo' when '0' then 'Inactivo' when '2' then 'Concentrador' end) as activo,
							(SELECT nombreCategoria FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as tipoUnidad,
							
							(SELECT objConfiguracion FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as objConfiguracion,
							o.institucion as idTipoUnidad
							from 817_organigrama o where codigoUnidad='".$arrRuta[$x]."'";
		$filaNodo=$con->obtenerPrimeraFilaAsoc($consulta);
				
		if($x==0)
		{
			if(!isset($arrEstructura[$arrRuta[$x]]))
			{
				$arrEstructura[$arrRuta[$x]]=array();
				
				
				
				$arrEstructura[$arrRuta[$x]]["info"]=$filaNodo;
				$arrEstructura[$arrRuta[$x]]["hijos"]=array();	
			}
			
		}
		else
		{
			$cadena="";
			$pos=0;
			for($pos=0;$pos<$x;$pos++)
			{
				if($cadena=="")
					$cadena='$arrEstructura["'.$arrRuta[$pos].'"]';
				else
					$cadena.='["hijos"]["'.$arrRuta[$pos].'"]';
				
				eval('if(!isset('.$cadena.'))
						{
							$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion,codCentroCosto,
										unidadPadre,codigoIndividual,codigoDepto,status,
							(case status when \'1\'  then \'Activo\' when \'0\' then \'Inactivo\' when \'2\' then \'Concentrador\' end) as activo,
							(SELECT nombreCategoria FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as tipoUnidad,
							(SELECT objConfiguracion FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as objConfiguracion,
							o.institucion as idTipoUnidad
							from 817_organigrama o where codigoUnidad=\''.$arrRuta[$pos].'\'";
							$filaNodoInfo=$con->obtenerPrimeraFilaAsoc($consulta);
							'.$cadena.'["info"]=$filaNodoInfo;
							'.$cadena.'["hijos"]=array();
						}
					');
				
				
			}
			
			
			//echo ($cadena.'["hijos"]["'.$arrRuta[$pos].'"]=array();'.$cadena.'["hijos"]["'.$arrRuta[$pos].'"]["info"]=$filaNodo;'.$cadena.'["hijos"]["'.$arrRuta[$pos].'"]["hijos"]=array()');
			
		}
		
		if($x==$totalNiveles-1)
		{
			eval($cadena.'["hijos"]["'.$arrRuta[$x].'"]=array();'.$cadena.'["hijos"]["'.$arrRuta[$x].'"]["info"]=$filaNodo;'.$cadena.'["hijos"]["'.$arrRuta[$x].'"]["hijos"]=array();');
		}
		
	}
	
}
?>