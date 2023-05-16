<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	
	include_once("funcionesActores.php");
	
	
	


	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];


	switch($funcion)
	{
		case 1:
				obtenerDepartamento();
		break;
		case 2:
				obtenerMunicipio();
		break;
		case 3:
				obtenerInfoConsulta();
		break;
		case 4:
				obtenerInfoConsultaFiltro();
		break;
		case 5:
			registrarPostulacionBien();
		break;
		case 6:
			rendererBienRemate();
		break;
	}
	
	function obtenerDepartamento()
	{
		global $con;
		$arrRegistros="";
		$numReg=0;
		
		$valorBusqueda=$_POST["valorBusqueda"];
		
		
		$consulta="SELECT cveEstado,estado FROM 820_estados WHERE estado LIKE '%".$valorBusqueda."%' order by estado";
		$res=$con->obtenerFilas($consulta);
		
		while($fila=mysql_fetch_row($res))
		{
			$cveEstado=$fila[0];
			$estado=$fila[1];
			
			$o='{"cveEstado":"'.$cveEstado.'","estado":"'.$estado.'"}';
			
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';			
	}
	
	function obtenerMunicipio()
	{
		global $con;
		global $con;
		$arrRegistros="";
		$numReg=0;
		$cveEstado=$_POST["cveEstado"];
		$valorBusqueda=$_POST["valorBusqueda"];
		
		
		$consulta="SELECT cveMunicipio,municipio FROM 821_municipios WHERE cveEstado='".$cveEstado."' and  municipio LIKE '%".$valorBusqueda."%' ORDER BY municipio";
		$res=$con->obtenerFilas($consulta);
		
		while($fila=mysql_fetch_row($res))
		{
			$cveMunicipio=$fila[0];
			$municipio=$fila[1];
			
			$o='{"cveMunicipio":"'.$cveMunicipio.'","municipio":"'.$municipio.'"}';
			
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';			
	}
	
	function obtenerInfoConsulta()
	{
		global $con;
		$arrRegistros="";
		$numReg=0;
		$cveDepartamento="";
		$cveMunicipio="";
		$precioBase=0;
		$fechaRemate="";
		
		$consulta="SELECT id__1140_tablaDinamica,t.fechaCreacion,t.idEstado,t.codigo,carpetaAdministrativa,bienEmbargado,d.departamento,
				d.municipio,d.descripcion,d.precioBase,d.fechaRemate,d.descripcion FROM _1140_tablaDinamica t,_1205_tablaDinamica d 
				WHERE t.id__1140_tablaDinamica=d.idReferencia";
		$res=$con->obtenerFilas($consulta);
		
		while($fila=mysql_fetch_row($res))
		{
			$idRegistro=$fila[0];
			$fechaCreacion=$fila[1];
			$situacion=$fila[2];
			$folio=$fila[3];
			$carpeta=$fila[4];
			$bienEmbargado=$fila[5];
			$cveDepartamento=$fila[6];
			$cveMunicipio=$fila[7];
			$descripcion=$fila[8];
			$evaluo=$fila[9];
			$fechaRemate=formatearFecha($fila[10]);
			
			$o='{"idRegistro":"'.$idRegistro.'","numCaso":"'.$folio.'","codigoUnico":"'.$carpeta.'","bienSolicitado":"'.$bienEmbargado.'","situacion":"'.$situacion.'","cveDepartamento":"'.$cveDepartamento.'","cveMunicipio":"'.$cveMunicipio.'","evaluo":"'.$evaluo.'","fechaRemate":"'.$fechaRemate.'","descripcion":"'.$descripcion.'"}';
			
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
			
		}
		echo '{"numReg":'.$numReg.',"registros":['.$arrRegistros.']}';		
	}
	
	function obtenerInfoConsultaFiltro()
	{
		global $con;
		$arrRegistros="";
		
		$bienEmbargado=$_POST["bienSolicitado"];
		$cveDepartamento=$_POST["cveDepartamento"];
		$cveMunicipio=$_POST["cveMunicipio"];
		$situacion=$_POST["situacion"];
		$fechaRemate=$_POST["fechaRemate"];
		
		$importeInicial=$_POST["importeInicial"];
		$importeFinal=$_POST["importeFinal"];
		
		
		$sql=" 1=1";
		
		$sql.=" and  bienEmbargado in(".$bienEmbargado.")";
		
		if($cveDepartamento!="")
		{
			$sql.=" AND departamento='".$cveDepartamento."'";
		}
		
		if($cveMunicipio!="")
		{
			$sql.=" AND municipio='".$cveMunicipio."'";
		}
		
		
		$sql.=" AND t.idEstado in(".$situacion.")";
		
		
		if($fechaRemate!="")
		{
			$sql.=" AND fechaRemate='".$fechaRemate."'";
		}
		
		if($importeInicial!="")
		{
			
			$sql.=" AND d.precioBase >='".$importeInicial."'";
			
		}
		
		if($importeFinal!="")
		{
			
			$sql.=" AND d.precioBase <= '".$importeFinal."'";
			
		}
		
		$numReg=0;
		$cveDepartamento="";
		$cveMunicipio="";
		$precioBase=0;
		$fechaRemate="";
		
		$consulta="SELECT id__1140_tablaDinamica,t.fechaCreacion,t.idEstado,t.codigo,carpetaAdministrativa,bienEmbargado,d.departamento,
				d.municipio,d.descripcion,d.precioBase,d.fechaRemate,d.id__1205_tablaDinamica as idRegistroInfo FROM _1140_tablaDinamica t,_1205_tablaDinamica d 
				WHERE t.id__1140_tablaDinamica=d.idReferencia AND".$sql."";
		$res=$con->obtenerFilas($consulta);
		
		while($fila=mysql_fetch_row($res))
		{
			$idRegistro=$fila[0];
			$fechaCreacion=$fila[1];
			$situacion=$fila[2];
			$folio=$fila[3];
			$carpeta=$fila[4];
			$bienEmbargado=$fila[5];
			$cveDepartamento=$fila[6];
			$cveMunicipio=$fila[7];
			$descripcion=$fila[8];
			$evaluo=$fila[9];
			$fechaRemate=formatearFecha($fila[10]);
			
			$idUsuario=-1;
			if(isset($_SESSION["idUsr"]) &&($_SESSION["idUsr"]!="")&&($_SESSION["idUsr"]!=-1))
			{
				$idUsuario=$_SESSION["idUsr"];
			}

			
			
			$consulta="SELECT COUNT(*) FROM _1225_tablaDinamica WHERE idReferencia=".$idRegistro." AND postulanteRemateJudicial=".$idUsuario." AND idEstado=2";
			$postulado=$con->obtenerValor($consulta);
			$postulado=$postulado>0?1:0;
			
			$consulta="SELECT idArchivoImagen FROM 9058_imagenesControlGaleria WHERE idElementoFormulario=15575 AND idRegistro=".$fila[11];
			$idArchivoImagen=$con->obtenerValor($consulta);
			$o='{"idRegistro":"'.$idRegistro.'","idArchivoImagen":"'.$idArchivoImagen.'","numCaso":"'.$folio.'","codigoUnico":"'.$carpeta.'","bienSolicitado":"'.
				$bienEmbargado.'","situacion":"'.$situacion.'","cveDepartamento":"'.$cveDepartamento.'","cveMunicipio":"'.$cveMunicipio.'","evaluo":"'.$evaluo.
				'","fechaRemate":"'.$fechaRemate.'","descripcion":"'.$descripcion.'","postulado":"'.$postulado.'"}';
			
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
			
		}
		echo '{"numReg":'.$numReg.',"registros":['.$arrRegistros.']}';		
	}
	
	function formatearFecha($fecha)
	{
		return date("d/m/Y",strtotime($fecha))	;
	}
	
	function formatearMoneda($monto)
	{
		return '$ '.number_format($monto,2);
	}	
	
	function registrarPostulacionBien()
	{
		global $con;
		$idBien=$_POST["idBien"];
		$idUsuario=-1;
		if(isset($_SESSION["idUsr"]) &&($_SESSION["idUsr"]!="")&&($_SESSION["idUsr"]!=-1))
		{
			$idUsuario=$_SESSION["idUsr"];
		}
		
		$consulta="SELECT id__1225_tablaDinamica as idRegistro,idEstado FROM _1225_tablaDinamica WHERE postulanteRemateJudicial=".$idUsuario." AND idReferencia=".$idBien;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		if(!$fRegistro)
		{
			$arrDocumentos=array();
			$arrValores=array();
			$arrValores["postulanteRemateJudicial"]=$idUsuario;
			$idRegistroInstancia=crearInstanciaRegistroFormulario(1225,$idBien,1.5,$arrValores,$arrDocumentos,-1,0);
			$consulta="SELECT id__1225_tablaDinamica as idRegistro,idEstado FROM _1225_tablaDinamica WHERE postulanteRemateJudicial=".$idUsuario." AND idReferencia=".$idBien;
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			
		}
		
		$iR=$fRegistro["idRegistro"];
		$a=bE("auto");
		$idProceso=obtenerIdProcesoFormulario(1225);
		$rol="23_0";
		$actor=obtenerActorProcesoIdRol($idProceso,$rol,$fRegistro["idEstado"]);
		$act=bE($actor);
		
		echo "1|".$iR."|".$a."|".$act;
	}
	
	function rendererBienRemate()
	{
		global $con;	
		$idBien=$_POST["idBien"];
		
		$consulta="SELECT id__1140_tablaDinamica,t.fechaCreacion,t.idEstado,t.codigo,carpetaAdministrativa,bienEmbargado,d.departamento,
				d.municipio,d.descripcion,d.precioBase,d.fechaRemate,d.id__1205_tablaDinamica as idRegistroInfo FROM _1140_tablaDinamica t,_1205_tablaDinamica d 
				WHERE t.id__1140_tablaDinamica=d.idReferencia AND id__1140_tablaDinamica=".$idBien;
		
		$fBien=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		$arrCategoria[1]="Inmueble";
		$arrCategoria[2]="Automotor";
		$arrCategoria[5]="Establecimiento de comercio";
		
		
		$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fBien["departamento"]."'";
		$departamento=$con->obtenerValor($consulta);
		
		$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$fBien["municipio"]."'";
		$municipio=$con->obtenerValor($consulta);
		
		$consulta="SELECT idArchivoImagen FROM 9058_imagenesControlGaleria WHERE idElementoFormulario=15575 AND idRegistro=".$fBien["idRegistroInfo"];
		$idArchivoImagen=$con->obtenerValor($consulta);
		
		$arrCamposProyecta["Clave"]=$fBien["codigo"];
		$arrCamposProyecta["Foto"]=$idArchivoImagen!=""?"<img src='../paginasFunciones/obtenerArchivos.php?id=".bE($idArchivoImagen)."' style='width: 100px; height: 100px;'>":"<img src='../images/imgNoDisponible.jpg' style='width: 100px; height: 100px;'>";
		
		$arrCamposProyecta["Categor&iacute;a"]=$arrCategoria[$fBien["bienEmbargado"]];
		$arrCamposProyecta["Departamento"]=$departamento;
		$arrCamposProyecta["Municipio"]=$municipio;
		$arrCamposProyecta["Aval&uacute;o"]="$ ".number_format($fBien["precioBase"],2);
		$arrCamposProyecta["Fecha de remate"]=date("d/m/Y",strtotime($fBien["fechaRemate"]));
		$arrCamposProyecta["Descripci&oacute;n del bien"]=$fBien["descripcion"];
		
		
		$leyenda=generarTablaRemateJudicial($arrCamposProyecta);
		
		$obj='{"leyenda":"'.$leyenda.'"}';
	
		echo "1|".$obj;
		
	}
	
	
	function generarTablaRemateJudicial($arrCamposProyecta)
	{
		$fila1="";
		$fila2="";
		$numItem=0;

		
		$leyenda="<table width='890' id='principal'>";
			
		
		foreach($arrCamposProyecta as $etiqueta=>$valor)
		{
			
			
			if($numItem==0)
			{
				$fila1="<tr height='35'><td width='400' align='left' valign='top'><span class='SIUGJ_Etiqueta'>".$etiqueta."</span></td><td width='90'></td>";
				$fila2="<tr height='45'><td  align='left' valign='top'><span class='SIUGJ_ControlEtiqueta'>".cv($valor)."</span></td><td  valign='top'></td>";
			}
			else
			{
				$fila1.="<td width='400' align='left' valign='top'><span class='SIUGJ_Etiqueta'>".$etiqueta."</span></td></tr>";
				$fila2.="<td valign='top'><span class='SIUGJ_ControlEtiqueta'>".cv($valor)."</span></td></tr>";
			}
			
			$numItem++;
			if($numItem==2)
			{
				$leyenda.=$fila1.$fila2;
				$numItem=0;
				$fila1="";
				$fila2="";
			}
		}
		if($numItem==1)
		{
			$fila1.="<td width='400' align='left' valign='top'></td></tr>";
			$fila2.="<td valign='top'><span class='SIUGJ_ControlEtiqueta'></span></td></tr>";
			$leyenda.=$fila1.$fila2;
		}
		

		
		
		
		$leyenda.="</table>";
		return $leyenda;
	}
?>