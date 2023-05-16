<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	include_once("sgjp/libreriaFunciones.php");
	include_once("sgjp/libreriaFuncionesPGJ.php");
	include_once("sgjp/funcionesInterconexionSGJ.php");

	
	;
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			obtenerPlantillasModeloGeneracionDocumentos();
		break;
		case 2:
			registrarDocumentoPDFRespuestaOficioMedida();
		break;
	}
	
	
	function obtenerPlantillasModeloGeneracionDocumentos()
	{
		global $con;
		
		$arbolExpandido=$_POST["arbolExpandido"];
		
		$idFormulario=-1;
		
		
		if(isset($_POST["idFormulario"]))
			$idFormulario=$_POST["idFormulario"];
		
		$idPerfil=-1;
		$idProceso=-1;
		
		$tipoUnidad=-1;
		$listaDocumentos=-1;
		$versionPlantilla=5;
		
	
		$arrRegistros="";
		$consulta=" SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos where idCategoria not in(0) ORDER BY nombreCategoria";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$arrHijos="";		
		
			
			$consulta="SELECT id__10_tablaDinamica,nombreFormato,descripcion,perfilValidacion,funcionJSParametros ,libreriaFuncionJSParametros
						FROM _10_tablaDinamica f,_10_chkVersionPlantilla v,_10_formulariosVirtualesAsociados fV 
						WHERE f.categoriaDocumento=".$fila[0]." AND v.idPadre=f.id__10_tablaDinamica 
						and fV.idPadre=f.id__10_tablaDinamica and fV.idOpcion=".abs($idFormulario)."
						AND v.idOpcion=5 ORDER BY nombreFormato ";
			
			
			
	
			
			$rDocumentos=$con->obtenerFilas($consulta);
			while($fDocumentos=mysql_fetch_assoc($rDocumentos))
			{
				$oDoc='{"tipoNodo":"2","icon":"../images/s.gif","id":"'.$fDocumentos["id__10_tablaDinamica"].'","text":"'.cv($fDocumentos["nombreFormato"]).
						'","perfilValidacion":"'.($fDocumentos["perfilValidacion"]==""?-1:$fDocumentos["perfilValidacion"]).'","descripcion":"'.
						cv($fDocumentos["descripcion"]).'","leaf":true,"children":[],"funcionJSParametros":"'.$fDocumentos["funcionJSParametros"].
						'","libreriaFuncionJSParametros":"'.$fDocumentos["libreriaFuncionJSParametros"].'"}';
				if($arrHijos=="")
					$arrHijos=$oDoc;
				else
					$arrHijos.=",".$oDoc;
			}
			
			if($arrHijos=="")
				continue;
			
			$o='{expanded:'.($arbolExpandido==1?"true":"false").',"tipoNodo":"1","icon":"../images/s.gif","id":"c_'.$fila[0].'","text":"<b>'.$fila[1].'</b>","descripcion":"",leaf:'.($arrHijos==""?"true":"false").',children:['.$arrHijos.']}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		
		echo '['.$arrRegistros.']';
	}
	
	
	function registrarDocumentoPDFRespuestaOficioMedida()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="SELECT categoriaDocumento FROM _10_tablaDinamica WHERE id__10_tablaDinamica =".$obj->tipoDocumento;
		$categoriaDocumento=$con->obtenerValor($consulta);
		$idDocumento=registrarDocumentoServidorRepositorio($obj->idArchivo,$obj->nombreArchivo,$categoriaDocumento);
		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($obj->idFormulario,$obj->idRegistro);
		
		if($carpetaAdministrativa!="")
			registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$idDocumento,$obj->idFormulario,$obj->idRegistro);
		
		$consulta="SELECT carpetaAdministrativa,idRegistroFormato FROM 7047_registroDocumentosRelacion WHERE idRegistro=".$obj->idRegistro;
		$fRegistroDocumento=$con->obtenerPrimeraFila($consulta);
		
		
		$cAdministrativa=$fRegistroDocumento[0];
		$idRegistroFormato=$fRegistroDocumento[1];
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$query[$x]="INSERT INTO 7035_informacionDocumentos(fechaCreacion,idResponsableCreacion,tipoDocumento,tituloDocumento,
					modificaSituacionCarpeta,carpetaAdministrativa,idFormulario,idReferencia,situacionDocumento,perfilValidacion)
					values('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$obj->tipoDocumento.",'".$obj->nombreArchivo."',0,'".$cAdministrativa.
					"',".$obj->idFormulario.",".$obj->idRegistro.",3,5)";
		$x++;
		$query[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		
		$query[$x]="INSERT INTO 3000_formatosRegistrados(fechaRegistro,idResponsableRegistro,tipoFormato,cuerpoFormato,
					idFormulario,idRegistro,idReferencia,firmado,documentoBloqueado,
					idDocumento,situacionActual,idPerfilEvaluacion,idDocumentoAdjunto)
					values('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$obj->tipoDocumento.",'',-2,@idRegistro,@idRegistro,0,1,".$idDocumento.
					",2,5,".$idDocumento.")";
		$x++;
		
		$query[$x]="set @idRegistroFormato:=(select last_insert_id())";
		$x++;
		
		$query[$x]="INSERT INTO 3000_bitacoraFormatos(idRegistroFormato,idEstadoAnterior,fechaCambio,idEstadoActual,
					responsableCambio,rolCambio,rolActual,resultadoEvaluacion,idDestinatario)
					values(@idRegistroFormato,1,'".date("Y-m-d H:i:s")."',2,".$_SESSION["idUsr"].",'0_0','0_0',0,0)";
		$x++;
		
		$query[$x]="set @idRegistroBitacora:=(select last_insert_id())";
		$x++;
		
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
		{
			echo "1|";
			$consulta="select @idRegistroBitacora";
			$idRegistroBitacora=$con->obtenerValor($consulta);
			notificarResponsableRespuestaMedidasCautelares($idRegistroBitacora);
		}
	}
?>