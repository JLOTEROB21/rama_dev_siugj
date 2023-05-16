<?php
	session_start();
	;
	$mostrarXML=true;
	include("conexionBD.php");
	include("configurarIdioma.php");
	//include("XML.php");
	if(isset($_SESSION["leng"]))
	{
		if(isset($_POST["parametros"]))
			$parametros=$_POST["parametros"];
		if(isset($_POST["funcion"]))
			$funcion=$_POST["funcion"];
		$lenguaje=$_SESSION["leng"];
		$docXML="<?xml version=\"1.0\"?><docXML>";
		switch($funcion)
		{
			case 1: //Nuevo DTD
				crearDTD($parametros);
			break;
			case 2: //Buscar elementos disponibles para nodo
				$idPadre=$_POST["idPadre"];
				obtenerElementosHijosJSON($idPadre,$parametros);
			break;
			case 3: //Obtiene nodos hijos
				crearCuerpoXML("",$parametros,"-2","");				
			break;
			case 4: //Buscar DTD existentes
				obtenerDTDs();
			break;
			case 5: //Arma DTD para modificacin
				generarDTD();
				//obtenerElementosArticulo();
			break;
			case 6: //Elimina DTD
				eliminarDTD($parametros);
			break;
			case 7: //Obtener preguntas cuestionario
				obtenerPreguntasDTD($parametros);
			break;
			case 8: //Eliminar pregunta
				eliminarPregunta($parametros);
			break;
			case 9: //Obtener Respuesta
				obtenerRespuestas($parametros);
			break;
			case 10: //Eliminar pregunta
				eliminarRespuesta($parametros);
			break;
			case 11: //Obtener idiomas del sistema
				obtenerIdiomas();
			break;
			case 12: //Obtener paginas del sistema
				obtenerPaginas();
			break;
			case 13: //Actualizar etiquetas
				actualizarEtiqueta(); 
			break;
			case 14: //Obtener etiquetas
				obtenerEtiquetas();
			break;
			case 15:
				actualizarElemento();
			break;
			case 16:
				eliminarElemento();
			break;
			case 17:
				agregarElemento();
			break;	
			case 18:
				actualizarAtributo();
			break;
			case 19:
				eliminarAtributo();
			break;
			case 20:
				agregarAtributo();
			break;	
			case 21:
				obtenerAtributosDisponibles();
			break;
			case 22:
				asignarAtributosElemento();
			break;
			case 23:
				obtenerAtributosSeparados();
			break;
			case 24:
				quitarAtributosElemento();
			break;
			case 25:
				guardarInfoComplElemento();
			break;
			case 26:
				obtenerInfoCompElemento();
			break;
			case 27:
				guardarInfoComplAtributo();
			break;
			case 28:
				obtenerInfoCompAtributo();
			break;
			case 29:
				obtenerDatosAutores();
			break;
			case 30:
				obtenerTiposDocumentos();
			break;
			case 31:
				obtenerOrganizaciones();
			break;
			case 32:
				guardarDatosAutorArticulo();
			break;
			case 33:
				guardarDatosAutor();
			break;
			case 34:
				obtenerDatosOrganizacion();
			break;
			case 35:
				obtenerDatosDiv();
			break;
			case 36:
				guardarCuerpo();
			break;
			case 37:
				quitarFiliacion();
			break;
			case 38:
				guardarResumen();
			break;
			case 39:
				obtenerDatosResumen();
			break;
			case 40:
				guardarPalabraClave();
			break;
			case 57:
				someterDocSumision();
			break;
			case 58:
				cambiarDatosSesion();
			break;
			case 59:
				cambiarDatosSesion();
			break;
			case 60:
				cambiarAutorCorrespondencia();
			break;
			case 61:
				obtenerUsuarios();
			break;
			case 62;
				eliminarComite();
			break;
			case 63:
				miembroComite();
			break;
			case 64:
				guardarCirculares();
			break;
			case 65:
				obtenerCirculares();
			break;
			case 66:
				eliminarCircular();
			break;
			case 67:
				enviarCircular();
			break;
			case 68:
				obtenerListadoCirculares();
			break;
			case 69:
				obtenerPlantillaFormateada();
			break;
			case 70:
				obtenerAutoresSeccion();
			break;
			case 71:
				obtenerRevisores();
			break;
			case 72:
				asignarRevisor();
			break;
			case 73:
				removerRevisor();
			break;
			case 74:
				registrarRevisor();
			break;
			case 75:
				cambiarSeccion();
			break;
			case 76:
				obtenerContenidos();
			break;
			case 77:
				guardarContenidos();
			break;
			case 78:
				rechazarDocumento();
			break;
			case 79:
				enviarEditorSec();
			break;
			case 80:
				obtenerRevisoresEditorSeccion();
			break;
			case 81:
				asignarRevisorEditorSeccion();
			break;
			case 82:
				removerAsignacion();
			break;
			case 83:
				enviarRevisores();
			break;
			case 84:
				validarEnvioRevisor();
			break;
			case 85:
				aprobarPorEditor();
			break;
			case 86:
				validarMail();
			break;
			case 87:
				guardarNuevoUsuario();
			break;
			case 88:
				obtenerSeccionesDoc();
			break;
			case 89:
				cancelarDocumento();
			break;
			case 90:
				ponderarSeccion();
			break;
			case 91:
				guardarPregunta();
			break;
			case 92:
				eliminarElementoCuestionario();
			break;
			case 93:
				obtenerElementosArticuloElectronico();
			break;
			case 94:
				obtenerElementosArticulo();
			break;
			case 95:
				eliminarTipoArticulo();
			break;
			case 96:
				guardarTipoArticulo();
			break;
			case 97:
				obtenerDatosTipoArticulo();
			break;
			case 98:
				crearNuevoDocumento();
			break;
			case 99:
				eliminarArchivoAutor();
			break;
		
		}
		$docXML.="</docXML>";	
		if($mostrarXML)
		{
			header("Content-type: text/xml");
			echo utf8_decode($docXML);
		}
	}
	
	function quitarFiliacion()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$idAfiliacion=$_POST["id"];
		$consulta="delete from 209_afiliacionesArticulos where idDocumento=".$_SESSION["idDoc"]." and idAfiliacion=".$idAfiliacion;
		if($con->ejecutarConsulta($consulta))
			echo "1";
		else
			echo "-1";
	}
	
	function generarDTD()
	{	
		global $mostrarXML;
		$mostrarXML=false;
		$idPadre=$_POST["idArticulo"];
		$nodos=crearCuerpoJsonConsulta($idPadre*-1);
		echo $nodos;
	}
	
	function crearCuerpoJsonConsulta($padre)
	{
		global $con;
		$consulta="select eDTD.idElementoDTD,revE.tag,eDTD.idElementoPadre,revE.id_atributos,revE.id_elemento from 203_elementosDTD eDTD,200_elementosRevista revE where revE.id_Elemento=eDTD.idElementoRevista and eDTD.idElementoPadre=".$padre." order by eDTD.idElementoDTD";
		$res=$con->obtenerFilas($consulta);
		$arrElementos="";
		$elemento="";
		$hidden='hidden:true,';
		while($fila=mysql_fetch_row($res))
		{
			$attr="";
			if($fila[3]!=NULL)
				$attr=obtenerAttributos($fila[3]);
			$hijos=	crearCuerpoJsonConsulta($fila[0]);
			$hoja="";
			if($hijos=="")
				$hoja='"leaf":"true"';
			else
				$hoja='"children":'.$hijos;
			
			$elemento='	{
							"draggable":"movible",
							"allowDrop":false,
							"id":"'.$fila[4].'",'.$hidden.'
							"text":"'.uEJ($fila[1]).' '.uEJ($attr).'",'.$hoja.'
						}
				';	
			if($arrElementos=="")
				$arrElementos=$elemento;
			else
				$arrElementos.=",".$elemento;
		}
		
		if($arrElementos!="")
			$arrElementos="[".$arrElementos."]";
		return $arrElementos;
		
	}


	
	function crearDTD($padreID)
	{	
		global $lenguaje;
		global $docXML;
		global $con;
		$res=$con->obtenerFilas("select nombre from 202_descripcionDTD where iddtd=".$padreID." and idIdioma=".$_SESSION["leng"]);
		
		if($fila=mysql_fetch_row($res))
		{
			crearCuerpoXML(utf8_decode($fila[0]),$padreID*-1,"-2","");				
		}
		
	}
	
	function crearCuerpoXML($etiqueta,$padre,$clavePadre,$atributos)
	{
		global $docXML;
		global $con;
		if($etiqueta!="")
			$docXML.="<el vReal=\"".$etiqueta."\" idElemento=\"".$padre."\" clavePadre=\"".$clavePadre."\" atributos=\"".$atributos."\" >";
		$res=$con->obtenerFilas("select * from 200_elementosRevista where id_padre=".$padre);
		while($fila=mysql_fetch_row($res))
		{
			$attr="";
			if($fila[3]!=NULL)
				$attr=obtenerAttributos($fila[3]);
			crearCuerpoXML($fila[1],$fila[0],$padre,$attr);
	
		}
		if($etiqueta!="")
			$docXML.="</el>";
	}
	
	
	
	function obtenerElementosHijosJSON($idPadre,$parametros)
	{
	
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$docJSON='{"modulos":[';
		$cuerpoJSON="";
		$elementoJSON="";
		$res=$con->obtenerFilas("select * from 200_elementosProyectos where tipoProceso=3 and idElemento not in(".$parametros.") order by idElemento");
		while($fila=mysql_fetch_row($res))
		{
			$hijos=crearCuerpoJSON($fila[0]);
			$elementoJSON='{"id":"'.$fila[0].'","elem":"'.($fila[1]).'","tipo":"0","hijos":'.$hijos.'}';
			if($cuerpoJSON=="")
				$cuerpoJSON=$elementoJSON;
			else
				$cuerpoJSON.=",".$elementoJSON;
			
		}
		
		$docJSON.=$cuerpoJSON.']}';
		echo uEJ($docJSON);
	}
		
	function crearCuerpoJSON($idPadre)
	{
		global $con;
		$res=$con->obtenerFilas("select * from 200_elementosRevista where id_padre=".$idPadre);
		$docJSON="[";
		$cuerpoJSON="";
		$elementoJSON="";
		$count=0;
		while($fila=mysql_fetch_row($res))
		{
			$attr="";
			if($fila[3]!=NULL)
				$attr=obtenerAttributos($fila[3]);
			$hijos=crearCuerpoJSON($fila[0]);
			$elementoJSON='{"id":"'.$fila[0].'","clv":"'.$idPadre.'","att":"'.$attr.'","elem":"'.utf8_encode($fila[1]).'","hijos":'.$hijos.'}';
			$count++;	
			if($cuerpoJSON=="")
				$cuerpoJSON=$elementoJSON;
			else
				$cuerpoJSON.=",".$elementoJSON;
			
		}
		$docJSON.=$cuerpoJSON."]";
		if($count==0)
			return "null";
		else
			return $docJSON;
	}
	
	function obtenerAttributos($Elemento)
	{
		$atributo="";
		global $con;
		
		if($Elemento!=NULL)			
		{
			$consulta=$con->obtenerFilas("select * from 214_atributos where id_atributo in (".$Elemento.")");
			$atributo=" (";
			while($filaAtt=mysql_fetch_row($consulta))
			{
				$atributo.=$filaAtt[1]."= ,";
			}
			$atributo=substr($atributo,0,strlen($atributo)-1);
			$atributo.=")";
		}
		return $atributo;
	}
	
	function obtenerDTDs()
	{
		global $lenguaje;
		global $docXML;
		global $con;
		$res=$con->obtenerFilas("select idTipoDocComun,TipoDocumento from 224_tipoDocumentos where idIdioma=".$lenguaje);
		while($fila=mysql_fetch_row($res))
		{
			$docXML.="<fila>";
			
			$docXML.="<id>".$fila[0]."</id><nombre>".ereg_replace("_"," ",utf8_encode($fila[1]))."</nombre>";
			
			$docXML.="</fila>";
		}
	}
	
	function eliminarDTD($idDTD)
	{
		global $con;
		try
		{	
			$con->ejecutarConsulta("begin;");
			$con->ejecutarConsulta("delete from 201_DTDs where idDTD=".$idDTD);
			eliminarRegistros($idDTD);
			$con->ejecutarConsulta("commit;");
			echo "OK";
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			$con->ejecutarConsulta("rollback;");
		}
	}
	
	function obtenerPreguntasDTD($idElemento)
	{
		global $docXML;
		global $con;
		$res=$con->obtenerFilas("Select * from tbl_preguntas where idElementoDTD=".$idElemento);
		while($fila=mysql_fetch_row($res))
		{
			$docXML.="<fila>";
			$docXML.="<id>".$fila[0]."</id><pregunta>".utf8_encode($fila[2])."</pregunta><valorPregunta>".$fila[3]."</valorPregunta>";
			$docXML.="</fila>";
		}
	}
	
	function obtenerRespuestas($idPregunta)
	{
		global $docXML;
		global $con;
		$res=$con->obtenerFilas("Select * from tbl_respuestas where idPregunta=".$idPregunta);
		while($fila=mysql_fetch_row($res))
		{
			$docXML.="<infoRespuesta>";
			$docXML.="<idRespuesta>";
			$docXML.=$fila[0];
			$docXML.="</idRespuesta>";			
			$docXML.="<respuesta>";
			$docXML.=utf8_encode($fila[2]);
			$docXML.="</respuesta>";			
			$docXML.="<valor>";
			$docXML.=$fila[3];			
			$docXML.="</valor>";			
			$docXML.="</infoRespuesta>";
		}
	}
	
	function eliminarPregunta($idPregunta)
	{
		global $con;
		global $docXML;
		try
		{
			$res=$con->ejecutarConsulta("delete from tbl_preguntas where idPregunta=".$idPregunta); 
			$docXML.="<Resultado>OK</Resultado>" ;
		}
		catch(Exception $e)
		{
			$docXML.="<Resultado>".$e->getMessage()."</Resultado>" ;
		}	
	}

	function eliminarRespuesta($idPregunta)
	{
		global $con;
		global $docXML;
		try
		{
			$res=$con->ejecutarConsulta("delete from tbl_respuestas where idRespuesta=".$idPregunta) ; 
			$docXML.="<Resultado>OK</Resultado>" ;
		}
		catch(Exception $e)
		{
			$docXML.="<Resultado>".$e->getMessage()."</Resultado>" ;
		}	
	}
	
	function obtenerIdiomas()
	{
		global $mostrarXML;
		$mostrarXML=false;
		
		global $con;
		$res=$con->obtenerFilas("select idIdioma,idioma from 8002_idiomas order by idioma ");
		$docJSON="[";
		$cuerpoJSON="";
		$elementoJSON="";
		$count=0;
		while($fila=mysql_fetch_row($res))
		{
			$elementoJSON='{"id":"'.$fila[0].'","idioma":"'.utf8_decode($fila[1]).'"}';
			$count++;	
			if($cuerpoJSON=="")
				$cuerpoJSON=$elementoJSON;
			else
				$cuerpoJSON.=",".$elementoJSON;
			
		}
		$docJSON.=$cuerpoJSON."]";
		if($count==0)
			echo "null";
		else
			echo $docJSON;
	}
	
	function obtenerPaginas()
	{
		global $mostrarXML;
		global $con;
		$mostrarXML=false;
		$res=$con->obtenerFilas("select distinct(pagina)  from 814_etiquetasIdiomaPaginas where pagina not like '%|%' order by pagina ");
		$docJSON="[";
		$cuerpoJSON="";
		$elementoJSON="";
		$count=0;
		while($fila=mysql_fetch_row($res))
		{
			$elementoJSON=$fila[0];
			$count++;	
			if($cuerpoJSON=="")
				$cuerpoJSON="'".$elementoJSON."'";
			else
				$cuerpoJSON.=","."'".$elementoJSON."'";
			
		}
		$docJSON.=$cuerpoJSON."]";
		if($count==0)
			echo "null";
		else
			echo $docJSON;
	}
	
	function actualizarEtiqueta()
	{
		$id=$_POST["id"];
		$tabla=$_POST["tabla"];
		$contenido=$_POST["contenido"];
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		try
		{
			//echo 'update 814_etiquetasIdiomaPaginas set texto="'.$contenido.'" where idEtiqueta= '.$id;
			if($tabla=="0")
				$con->ejecutarConsulta('update 814_etiquetasIdiomaPaginas set texto="'.utf8_decode($contenido).'" where idEtiqueta= '.$id);
			else
				$con->ejecutarConsulta('update 815_etiquetasIdiomaScripts set texto="'.utf8_decode($contenido).'" where idEtiqueta= '.$id);
			echo "1";
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}		
		
	}
	
	function obtenerEtiquetas()
	{
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		$condPagina="";
		$pagina=$_POST["pagina"];
		$idioma=$_POST["idioma"];
		
		if($pagina!="-1")
			$condPagina=" and pagina like '%".$pagina."%'";
		$consulta= 'Select idEtiqueta,"0" as tabla,texto,pagina from 814_etiquetasIdiomaPaginas where idIdioma='.$idioma.$condPagina.' union Select idEtiqueta,"1" as tabla,texto,pagina from 815_etiquetasIdiomaScripts where idIdioma='.$idioma.$condPagina.'   order by texto';
		$res=$con->obtenerFilas($consulta);
		$registros="";
		
		while($fila=mysql_fetch_row($res))
		{
			if($registros=="")
				$registros= '{"id":"'.$fila[0].'","tbl":"'.$fila[1].'","txt":"'.utf8_encode($fila[2]).'","pg":"'.$fila[3].'"}';
			else
				$registros.=','.'{"id":"'.$fila[0].'","tbl":"'.$fila[1].'","txt":"'.utf8_encode($fila[2]).'","pg":"'.$fila[3].'"}';
		}
		echo "[".$registros."]";
	}
	
	function actualizarElemento()
	{
		global $et;
		$id=$_POST["id"];
		$valor=$_POST["valor"];
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		try
		{
			$consulta="Select id_elemento from 200_elementosRevista  where tag='".utf8_decode($valor)."' and id_elemento<>".$id;
			if(!$con->existeRegistro($consulta))
			{
				$consulta= 'update 200_elementosRevista set tag="'.utf8_decode($valor).'" where id_elemento= '.$id;
				$con->ejecutarConsulta($consulta);
				echo "1";
			}
			else
			{
				echo $et["errElementoExiste"];
			}
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}

	function eliminarElemento()
	{
		$id=$_POST["id"];
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		try
		{
			$res=$con->ejecutarConsulta("delete from 200_elementosRevista where id_elemento=".$id) ;
			echo "1" ;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}	
	}
	
	function agregarElemento()
	{
		global $et;
		$valor=$_POST["valor"];
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		try
		{
			$consulta="Select id_elemento from 200_elementosRevista  where tag='".utf8_decode($valor)."'";
			if(!$con->existeRegistro($consulta))
			{
				$consulta= "insert into 200_elementosRevista(tag,id_padre) values('".utf8_decode($valor)."',-1000)";
				$con->ejecutarConsulta($consulta);
				$idReg=$con->obtenerUltimoID();
				echo "1|".$idReg;
			}
			else
			{
				echo "-1|".$et["errElementoExiste"];
			}
		}
		catch(Exception $e)
		{
			echo "-1|".$e->getMessage();
		}
		
	}
	
	function actualizarAtributo()
	{
		global $et;
		$id=$_POST["id"];
		$valor=$_POST["valor"];
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		try
		{
			$consulta="Select id_atributo from 214_atributos  where desc_atributo='".utf8_decode($valor)."' and id_atributo<>".$id;
			if(!$con->existeRegistro($consulta))
			{
				$consulta= 'update 214_atributos set desc_atributo="'.utf8_decode($valor).'" where id_atributo= '.$id;
				$con->ejecutarConsulta($consulta);
				echo "1";
			}
			else
			{
				echo $et["errElementoExiste"];
			}
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}

	function eliminarAtributo()
	{
		$id=$_POST["id"];
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		try
		{
			$res=$con->ejecutarConsulta("delete from 214_atributos where id_atributo=".$id) ;
			echo "1" ;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}	
	}
	
	function agregarAtributo()
	{
		global $et;
		$valor=$_POST["valor"];
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		try
		{
			$consulta="Select id_atributo from 214_atributos  where desc_atributo='".utf8_decode($valor)."'";
			if(!$con->existeRegistro($consulta))
			{
				$consulta= "insert into 214_atributos(desc_atributo,datos_comp) values('".utf8_decode($valor)."',-1000)";
				$con->ejecutarConsulta($consulta);
				$idReg=$con->obtenerUltimoID();
				echo "1|".$idReg;
			}
			else
			{
				echo "-1|".$et["errElementoExiste"];
			}
		}
		catch(Exception $e)
		{
			echo "-1|".$e->getMessage();
		}
		
	}
	
	function obtenerAtributosDisponibles()
	{
		global $et;
		$condWhere="";
		$idElemento=$_POST["idElemento"];
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		$cuerpo="";
		$objAtributo="";
		try
		{
			$consulta="Select if (ISNULL(id_atributos),'',id_atributos) as id_atributos from 200_elementosRevista  where id_elemento=".$idElemento;
			$res=$con->obtenerFilas($consulta);
			if($fila=mysql_fetch_row($res))
			{
				if($fila["0"]!="")
				{
					$condWhere="where id_atributo not in (".$fila[0].")";
				}
				$consulta="select * from 214_atributos ".$condWhere." order by datos_comp desc,desc_atributo";
				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					$objAtributo	='{"id":"'.$fila[0].'","desc":"'.utf8_encode($fila[1]).'","tipo":"'.$fila[2].'"}';
					if($cuerpo=="")
						$cuerpo=$objAtributo;
					else
						$cuerpo.=",".$objAtributo;
					
				}
				if($cuerpo=="")
					echo "null";
				else 
					echo "[".$cuerpo."]";
			}
		}
		catch(Exception $e)
		{
			echo "-1|".$e->getMessage();
		}
		
	}
	
	function asignarAtributosElemento()
	{
		global $et;
		$id=$_POST["idElemento"];
		$atributos=$_POST["idAtributos"];
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		try
		{
			$consulta='Select isnull(id_atributos),id_atributos from 200_elementosRevista where id_elemento='.$id;
			$res=$con->obtenerFilas($consulta);
			$fila=mysql_fetch_row($res);
			if(($fila[0]=='0')&&($fila[1]!=""))
			{
				$atributos=",".$atributos;
				$consulta= 'update 200_elementosRevista set id_atributos=concat(id_atributos,"'.utf8_decode($atributos).'") where id_Elemento='.$id;
			}
			else
				$consulta= 'update 200_elementosRevista set id_atributos="'.utf8_decode($atributos).'" where id_Elemento='.$id;
			$con->ejecutarConsulta($consulta);
			$consulta='Select id_atributos,tag from 200_elementosRevista where id_elemento='.$id;
			$res=$con->obtenerFilas($consulta);
			$fila=mysql_fetch_row($res);
			$att=obtenerAttributos($fila[0]);
			echo "1|".$fila[1]." ".$att; 		
		}
		catch(Exception $e)
		{
		
			echo "-1|".$e->getMessage();
		}
	}
	
	function obtenerAtributosSeparados()
	{
		$atributo="";
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$id=$_POST["idElemento"];
		$cuerpo="";
		$obj="";
		$consulta='select if (isnull(id_atributos),"",id_atributos) as id_atributos from 200_elementosRevista where id_elemento='.$id;
		$res=$con->obtenerFilas($consulta);
		$fila=mysql_fetch_row($res);
		if($fila[0]!="")
		{
			$consulta="select id_atributo, desc_atributo from 214_atributos where id_atributo in (".$fila[0].")";
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{	
				$obj='{"id":"'.$fila[0].'","atributo":"'.$fila[1].'"}';
				if($cuerpo=="")
					$cuerpo=$obj;
				else
					$cuerpo.=",".$obj;
			}
			
			echo "[".$cuerpo."]";
		}
		else
			echo "[]";
	}
	
	function quitarAtributosElemento()
	{
		global $et;
		$id=$_POST["idElemento"];
		$atributos=$_POST["idAtributos"];
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		try
		{
			$consulta= 'update 200_elementosRevista set id_atributos="'.utf8_decode($atributos).'" where id_Elemento='.$id;
			$con->ejecutarConsulta($consulta);
			$consulta='Select id_atributos,tag from 200_elementosRevista where id_elemento='.$id;
			$res=$con->obtenerFilas($consulta);
			$fila=mysql_fetch_row($res);
			$att=obtenerAttributos($fila[0]);
			echo "1|".$fila[1]." ".$att; 		
		}
		catch(Exception $e)
		{
		
			echo "-1|".$e->getMessage();
		}
	}
	
	function guardarInfoComplElemento()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$cadObjJson=$_POST["objJson"];
		$idElemento=$_POST["idElemento"];
		$objJson=json_decode($cadObjJson);
		$tElemento=$objJson->idTipoElem;
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="call 200_limpiarAtributosElemento(".$idElemento.",0)";
			if($con->ejecutarConsulta($consulta))
			{
				switch($tElemento)
				{
					case 1://Marcacion
						$consulta="update 200_elementosRevista set tipo_elemento=".$tElemento.",tipo_entrada=0,ayuda=2 where id_elemento=".$idElemento;	
						if($con->ejecutarConsulta($consulta))
						{
							$consulta="commit";
							if($con->ejecutarConsulta($consulta))
								echo "1";						
						}
						
						break;
					case 2://Entrada
						$tEntrada=$objJson->idTipoEnt;
						$ayuda=$objJson->ayuda;
						$consulta="update 200_elementosRevista set tipo_elemento=".$tElemento.",tipo_entrada=".$tEntrada.",ayuda=".$ayuda." where id_elemento=".$idElemento;	
						if($con->ejecutarConsulta($consulta))
						{
							$tEtiquetas=$objJson->etiquetas;
							for($x=0;$x<count($tEtiquetas);$x++)
							{
								$consulta="insert into 220_etiquetasCampos(textoEtiqueta,idElemento,idIdioma,tipoElemento) values('".$tEtiquetas[$x]->texto."',".$idElemento.",".$tEtiquetas[$x]->idIdioma.",0)";
								if(!$con->ejecutarConsulta($consulta))
									return ;
							}
							
							switch($tEntrada)
							{
								case 1: //Entrada abierta
									$idTipoEntrada=$objJson->tipoCampEnt;
									$longitud=$objJson->longitud;
									$obligatorio=$objJson->obligatorio;
									$ayuda=$objJson->ayuda;
								
									$consulta="insert into 213_atributosElementoEntrada(idElemento,idTipoEntrada,longitud,obligatorio,tipoElemento) values(".$idElemento.",".$idTipoEntrada.",".$longitud.",".$obligatorio.",0)";
									if($con->ejecutarConsulta($consulta))
									{
			
										if($ayuda=="1")
										{
											$msgAyuda=$objJson->msgAyuda;
											for($x=0;$x<count($msgAyuda);$x++)
											{
												$idioma=$msgAyuda[$x]->idIdioma;
												$msg=$msgAyuda[$x]->msgAyuda;
												$consulta="insert into 221_mensajesAyudaCampos(idIdioma,idElemento,mensajeAyuda,tipoElemento) values(".$idioma.",".$idElemento.",'".$msg."',0)";						
												if(!$con->ejecutarConsulta($consulta))
													return ;
											}
										}
										
										$consulta="commit";
										if($con->ejecutarConsulta($consulta))
											echo "1";
										
									}
									
								break;
								case 2://Entrada cerrada
									$opciones=$objJson->opciones;
									$ayuda=$objJson->ayuda;
									for($x=0;$x<count($opciones);$x++)
									{
										$vOpcion=$opciones[$x]->vOpcion;
										$columnas=$opciones[$x]->columnas;
										for($y=0;$y<count($columnas);$y++)
										{
											$idLeng=$columnas[$y]->idLeng;
											$texto=$columnas[$y]->texto;
											$consulta="insert into 222_opcionesElementosCampos(idElemento,valor,idIdioma,contenido,tipoElemento) values(".$idElemento.",'".$vOpcion."',".$idLeng.",'".$texto."',0)";
											if(!$con->ejecutarConsulta($consulta))
												return ;
											
										}
									}
									if($ayuda=="1")
									{
										$msgAyuda=$objJson->msgAyuda;
										for($x=0;$x<count($msgAyuda);$x++)
										{
											$idioma=$msgAyuda[$x]->idIdioma;
											$msg=$msgAyuda[$x]->msgAyuda;
											$consulta="insert into 221_mensajesAyudaCampos(idIdioma,idElemento,mensajeAyuda,tipoElemento) values(".$idioma.",".$idElemento.",'".$msg."',0)";						
											if(!$con->ejecutarConsulta($consulta))
												return ;
										}
									}
									$consulta="commit";
									if($con->ejecutarConsulta($consulta))
										echo "1";	
								break;
							}	
						}	
					break;
					case 3: //Funcion
						$tEntrada=$objJson->idTipoEnt;
						$consulta="update 200_elementosRevista set tipo_elemento=".$tElemento.",tipo_entrada=".$tEntrada.",ayuda=2 where id_elemento=".$idElemento;
						if($con->ejecutarConsulta($consulta))
						{	
							$consulta="commit;";
							if($con->ejecutarConsulta($consulta))
								echo "1";	
						}
					break;	
				}
			}
		}
	}
	
	function guardarInfoComplAtributo()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$cadObjJson=$_POST["objJson"];
		$idAtributo=$_POST["idAtributo"];
		$objJson=json_decode($cadObjJson);
		$tAtributo=$objJson->idTipoElem;
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="call 200_limpiarAtributosElemento(".$idAtributo.",1)";
			if($con->ejecutarConsulta($consulta))
			{
				switch($tAtributo)
				{
					case 1://Marcacion
						$consulta="update 214_atributos set tipo_atributo=".$tAtributo.",tipo_entrada=0,ayuda=2 where id_Atributo=".$idAtributo;	
						if($con->ejecutarConsulta($consulta))
						{
							$consulta="commit";
							if($con->ejecutarConsulta($consulta))
								echo "1";						
						}
						
						break;
					case 2://Entrada
						$tEntrada=$objJson->idTipoEnt;
						$ayuda=$objJson->ayuda;
						$consulta="update 214_atributos set tipo_atributo=".$tAtributo.",tipo_entrada=".$tEntrada.",ayuda=".$ayuda." where id_Atributo=".$idAtributo;	
						if($con->ejecutarConsulta($consulta))
						{
							$tEtiquetas=$objJson->etiquetas;
							for($x=0;$x<count($tEtiquetas);$x++)
							{
								$consulta="insert into 220_etiquetasCampos(textoEtiqueta,idElemento,idIdioma,tipoElemento) values('".$tEtiquetas[$x]->texto."',".$idAtributo.",".$tEtiquetas[$x]->idIdioma.",1)";
								if(!$con->ejecutarConsulta($consulta))
									return ;
							}
							switch($tEntrada)
							{
								case 1: //Entrada abierta
									$idTipoEntrada=$objJson->tipoCampEnt;
									$longitud=$objJson->longitud;
									$obligatorio=$objJson->obligatorio;
									$ayuda=$objJson->ayuda;
								
									$consulta="insert into 213_atributosElementoEntrada(idElemento,idTipoEntrada,longitud,obligatorio,tipoElemento) values(".$idAtributo.",".$idTipoEntrada.",".$longitud.",".$obligatorio.",1)";
									if($con->ejecutarConsulta($consulta))
									{
										if($ayuda=="1")
										{
											$msgAyuda=$objJson->msgAyuda;
											for($x=0;$x<count($msgAyuda);$x++)
											{
												$idioma=$msgAyuda[$x]->idIdioma;
												$msg=$msgAyuda[$x]->msgAyuda;
												$consulta="insert into 221_mensajesAyudaCampos(idIdioma,idElemento,mensajeAyuda,tipoElemento) values(".$idioma.",".$idAtributo.",'".utf8_decode($msg)."',1)";						
												if(!$con->ejecutarConsulta($consulta))
													return ;
											}
										}
										
										$consulta="commit";
										if($con->ejecutarConsulta($consulta))
											echo "1";
										
									}
									
								break;
								case 2://Entrada cerrada
									$opciones=$objJson->opciones;
									$ayuda=$objJson->ayuda;
									for($x=0;$x<count($opciones);$x++)
									{
										$vOpcion=$opciones[$x]->vOpcion;
										$columnas=$opciones[$x]->columnas;
										for($y=0;$y<count($columnas);$y++)
										{
											$idLeng=$columnas[$y]->idLeng;
											$texto=$columnas[$y]->texto;
											$consulta="insert into 222_opcionesElementosCampos(idElemento,valor,idIdioma,contenido,tipoElemento) values(".$idAtributo.",'".utf8_decode($vOpcion)."',".$idLeng.",'".utf8_decode($texto)."',1)";
											if(!$con->ejecutarConsulta($consulta))
												return ;
											
										}
									}
									if($ayuda=="1")
									{
										$msgAyuda=$objJson->msgAyuda;
										for($x=0;$x<count($msgAyuda);$x++)
										{
											$idioma=$msgAyuda[$x]->idIdioma;
											$msg=$msgAyuda[$x]->msgAyuda;
											$consulta="insert into 221_mensajesAyudaCampos(idIdioma,idElemento,mensajeAyuda,tipoElemento) values(".$idioma.",".$idAtributo.",'".utf8_decode($msg)."',1)";						
											if(!$con->ejecutarConsulta($consulta))
												return ;
										}
									}
									$consulta="commit";
									if($con->ejecutarConsulta($consulta))
										echo "1";	
								break;
							}	
						}	
					break;
					case 3: //Funcion
						$tEntrada=$objJSon->tipoE;
						$consulta="update tblAtrbutos set tipo_atributo=".$tAtributo.",tipo_entrada=".$tEntrada.",ayuda=2 where id_atributo=".$idAtributo;
						if($con->ejecutarConsulta($consulta))
						{	
							$consulta="commit;";
							if($con->ejecutarConsulta($consulta))
								echo "1";	
						}
					break;	
				}
			}
		}
	}
	
	function obtenerInfoCompElemento()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$idElemento=$_POST["idElemento"];
		$objJson="{";
		$consulta="select tipo_elemento,tipo_entrada,ayuda from 200_elementosRevista where id_elemento=".$idElemento;
		$res=$con->obtenerFilas($consulta);
		
		if($fila=mysql_fetch_row($res))
		{
			$objJson.='"idTipoElem":"'.$fila[0].'"';
			$objJson.=',"idTipoEnt":"'.$fila[1].'"';
			$ayuda=$fila[2];
			switch($fila[0])
			{
				case 1://Marcacion
				break;
				case 2: //Entrada
					$consulta="select textoEtiqueta,idIdioma from 220_etiquetasCampos where tipoElemento=0 and idElemento=".$idElemento;
					$res2=$con->obtenerFilas($consulta);
					$obj="";
					$arrObj="";
					while($fila2=mysql_fetch_row($res2))
					{
						$obj='{"idIdioma":"'.$fila2[1].'","msgAyuda":"'.$fila2[0].'"}';
						if($arrObj=="")
							$arrObj=$obj;
						else
							$arrObj.=",".$obj;
					}
					$objJson.=',"etiquetas":['.$arrObj.']';
					switch($fila[1])
					{
						case 1://Entrada abierta
							$consulta="select concat(idTipoEntrada,'_',(select distinct(complementario) from 223_tiposCamposEntrada where grupo=1 and idTipoComun=idTipoEntrada)) as idTipoEntrada,longitud,obligatorio from 213_atributosElementoEntrada where tipoElemento=0 and idElemento=".$idElemento;
							$res=$con->obtenerFilas($consulta);
							$fila=mysql_fetch_row($res);
							$objJson.=',"tipoCampEnt":"'.$fila[0].'"';
							$objJson.=',"longitud":"'.$fila[1].'"';
							$objJson.=',"obligatorio":"'.$fila[2].'"';
							$objJson.=',"ayuda":"'.$ayuda.'"';
							if($ayuda=="1")
							{
								$consulta="Select idIdioma,mensajeAyuda from 221_mensajesAyudaCampos where tipoElemento=0 and idElemento=".$idElemento;
								$res=$con->obtenerFilas($consulta);
								$obj="";
								$arrObj="";
								while($fila=mysql_fetch_row($res))
								{
										$obj='{"idIdioma":"'.$fila[0].'","msgAyuda":"'.$fila[1].'"}';	
										if($arrObj=="")
											$arrObj=$obj;
										else
											$arrObj.=",".$obj;
								}
								$objJson.=',"msgAyuda":['.$arrObj.']';
							}
						break;
						case 2:	//Entrada cerrada
						
							$objJson.=',"opciones":[';
							$consulta="select valor,idIdioma,contenido from 222_opcionesElementosCampos where tipoElemento=0 and idElemento=".$idElemento." order by idOpcion";
							$res=$con->obtenerFilas($consulta);
							$obj="";
							$objOpciones="";
							$arrObj="";
							$ct=0;
							$arrColumnas="";
							while($fila=mysql_fetch_row($res))
							{
								$ct++;
								$arrOpciones="";
								$vOpcion=$fila[0];
								$obj='{"vOpcion":"'.$vOpcion.'"';
								mysql_data_seek($res,$ct-1);
								$ct--;
								while(($fila=mysql_fetch_row($res))&&($vOpcion==$fila[0]))
								{
									$objOpciones='{"idLeng":"'.$fila[1].'","texto":"'.$fila[2].'"}';
									if($arrOpciones=="")
										$arrOpciones=$objOpciones;
									else
										$arrOpciones.=",".$objOpciones;
									$ct++;
								}
								$obj.=',"columnas":['.$arrOpciones.']';
								$obj.='}';
								if($arrColumnas=="")
									$arrColumnas=$obj;
								else
									$arrColumnas.=",".$obj;
							}	
							$objJson.=$arrColumnas.']';
							$objJson.=',"ayuda":"'.$ayuda.'"';
							if($ayuda=="1")
							{
								$consulta="Select idIdioma,mensajeAyuda from 221_mensajesAyudaCampos where tipoElemento=0 and idElemento=".$idElemento;
								$res=$con->obtenerFilas($consulta);
								$obj="";
								$arrObj="";
								while($fila=mysql_fetch_row($res))
								{
										$obj='{"idIdioma":"'.$fila[0].'","msgAyuda":"'.$fila[1].'"}';	
										if($arrObj=="")
											$arrObj=$obj;
										else
											$arrObj.=",".$obj;
								}
								$objJson.=',"msgAyuda":['.$arrObj.']';
							}
							
						
						break;
					}
					
				break;
				case 3://funcion
				break;
				
			}
			$objJson.='}';
			echo $objJson;
		}
	}
		
	function obtenerInfoCompAtributo()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$idAtributo=$_POST["idAtributo"];
		$objJson="{";
		$consulta="select tipo_atributo,tipo_entrada,ayuda from 214_atributos where id_atributo=".$idAtributo;
		$res=$con->obtenerFilas($consulta);
		if($fila=mysql_fetch_row($res))
		{
			$objJson.='"idTipoElem":"'.$fila[0].'"';
			$objJson.=',"idTipoEnt":"'.$fila[1].'"';
			$ayuda=$fila[2];
			switch($fila[0])
			{
				case 1://Marcacion
				break;
				case 2: //Entrada
					$consulta="select textoEtiqueta,idIdioma from 220_etiquetasCampos where tipoElemento=1 and idElemento=".$idAtributo;
					$res2=$con->obtenerFilas($consulta);
					$obj="";
					$arrObj="";
					while($fila2=mysql_fetch_row($res2))
					{
						$obj='{"idIdioma":"'.$fila2[1].'","msgAyuda":"'.$fila2[0].'"}';
						if($arrObj=="")
							$arrObj=$obj;
						else
							$arrObj.=",".$obj;
					}
					$objJson.=',"etiquetas":['.$arrObj.']';
					switch($fila[1])
					{
						case 1://Entrada abierta
							$consulta="select concat(idTipoEntrada,'_',(select distinct(complementario) from 223_tiposCamposEntrada where grupo=1 and idTipoComun=idTipoEntrada)) as idTipoEntrada,longitud,obligatorio from 213_atributosElementoEntrada where tipoElemento=1 and idElemento=".$idAtributo;
							$res=$con->obtenerFilas($consulta);
							$fila=mysql_fetch_row($res);
							$objJson.=',"tipoCampEnt":"'.$fila[0].'"';
							$objJson.=',"longitud":"'.$fila[1].'"';
							$objJson.=',"obligatorio":"'.$fila[2].'"';
							$objJson.=',"ayuda":"'.$ayuda.'"';
							if($ayuda=="1")
							{
								$consulta="Select idIdioma,mensajeAyuda from 221_mensajesAyudaCampos where tipoElemento=1 and idElemento=".$idAtributo;
								$res=$con->obtenerFilas($consulta);
								$obj="";
								$arrObj="";
								while($fila=mysql_fetch_row($res))
								{
										$obj='{"idIdioma":"'.$fila[0].'","msgAyuda":"'.$fila[1].'"}';	
										if($arrObj=="")
											$arrObj=$obj;
										else
											$arrObj.=",".$obj;
								}
								$objJson.=',"msgAyuda":['.$arrObj.']';
							}
						break;
						case 2:	//Entrada cerrada
						
							$objJson.=',"opciones":[';
							$consulta="select valor,idIdioma,contenido from 222_opcionesElementosCampos where tipoElemento=1 and idElemento=".$idAtributo." order by idOpcion";
							$res=$con->obtenerFilas($consulta);
							$obj="";
							$objOpciones="";
							$arrObj="";
							$ct=0;
							$arrColumnas="";
							while($fila=mysql_fetch_row($res))
							{
								$ct++;
								$arrOpciones="";
								$vOpcion=$fila[0];
								$obj='{"vOpcion":"'.$vOpcion.'"';
								mysql_data_seek($res,$ct-1);
								$ct--;
								while(($fila=mysql_fetch_row($res))&&($vOpcion==$fila[0]))
								{
									$objOpciones='{"idLeng":"'.$fila[1].'","texto":"'.$fila[2].'"}';
									if($arrOpciones=="")
										$arrOpciones=$objOpciones;
									else
										$arrOpciones.=",".$objOpciones;
									$ct++;
								}
								$obj.=',"columnas":['.$arrOpciones.']';
								$obj.='}';
								if($arrColumnas=="")
									$arrColumnas=$obj;
								else
									$arrColumnas.=",".$obj;
							}	
							$objJson.=$arrColumnas.']';
							$objJson.=',"ayuda":"'.$ayuda.'"';
							if($ayuda=="1")
							{
								$consulta="Select idIdioma,mensajeAyuda from 221_mensajesAyudaCampos where tipoElemento=1 and idElemento=".$idAtributo;
								$res=$con->obtenerFilas($consulta);
								$obj="";
								$arrObj="";
								while($fila=mysql_fetch_row($res))
								{
										$obj='{"idIdioma":"'.$fila[0].'","msgAyuda":"'.$fila[1].'"}';	
										if($arrObj=="")
											$arrObj=$obj;
										else
											$arrObj.=",".$obj;
								}
								$objJson.=',"msgAyuda":['.$arrObj.']';
							}
						break;
					}
				break;
				case 3://funcion
				break;
			}
			$objJson.='}';
			echo $objJson;
		}
		
	}
	
	function obtenerDatosAutores()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$cadObjJson=$_POST["datosAutor"];
		$objJson=json_decode($cadObjJson);
		$condWhere="";
		if($objJson->apPaterno!="")
		{
			$condWhere=" apPaterno like '".uEJ($objJson->apPaterno)."%'";
		}
		if($objJson->apMaterno!="")
		{
			if($condWhere!="")
				$condWhere.=" and ";	
			$condWhere.=" apMaterno like '".uEJ($objJson->apMaterno)."%'";
		}
		if($objJson->nombres!="")
		{
			if($condWhere!="")
				$condWhere.=" and ";	
			$condWhere.=" nombres like '".uEJ($objJson->nombres)."%'";
		}
		if($condWhere!="")
		{
			$consulta="select * from 205_autores where ".$condWhere;
			$res=$con->obtenerFilas($consulta);
			$arrAutores="";
			$numA=0;
			while($fila=mysql_fetch_row($res))
			{
				$consultaAfi="select  vO.idAfiliacion,vO.nomOrganizacion,vO.Div1,vO.Div2,vO.Div3,vO.ciudad,vO.estado,vO.pais,vO.cp,vO.email from 200_vOrganizaciones vO where vO.idAutor=".$fila[0]." and vO.idAfiliacion not in(select idAfiliacion from 209_afiliacionesArticulos where idDocumento=".$_SESSION["idDoc"].")";
				//echo $consultaAfi;
				$resAfi=$con->obtenerFilas($consultaAfi);
				$fichaOrg="";
				$ficha="";
				$datosComp="";
				if($fila[4]!="")
					$datosComp="Tel.: (".$fila[4].") ".$fila[5];
				if($fila[6]!="")
					if($datosComp=="")
						$datosComp="Fax: (".$fila[6].") ".$fila[7];
					else
						$datosComp.=", Fax: (".$fila[6].") ".$fila[7];
				if($fila[8]!="")
					if($datosComp=="")
						$datosComp="E-mail: ".$fila[8];
					else
						$datosComp.=", E-mail: ".$fila[8];
				if($filaAfi=mysql_fetch_row($resAfi))
				{
					do
					{
						$fichaOrg="";
						if($filaAfi[1]!="")
							$fichaOrg=$filaAfi[1];
						if($filaAfi[2]!="")
							if($fichaOrg=="")
								$fichaOrg=$filaAfi[2];
							else
								$fichaOrg.=", ".$filaAfi[2];
						if($filaAfi[3]!="")
							if($fichaOrg=="")
								$fichaOrg=$filaAfi[3];
							else
								$fichaOrg.=", ".$filaAfi[3];
						if($filaAfi[4]!="")
							if($fichaOrg=="")
								$fichaOrg=$filaAfi[4];
							else
								$fichaOrg.=", ".$filaAfi[4];
						if($filaAfi[8]!="")
							if($fichaOrg=="")
								$fichaOrg="C.P. ".$filaAfi[8];
							else
								$fichaOrg.=". C.P. ".$filaAfi[8];
						if($filaAfi[5]!="")
							if($fichaOrg=="")
								$fichaOrg=$filaAfi[5];
							else
								$fichaOrg.=", ".$filaAfi[5];
						if($filaAfi[6]!="")
							if($fichaOrg=="")
								$fichaOrg=$filaAfi[6];
							else
								$fichaOrg.=", ".$filaAfi[6];
						if($filaAfi[7]!="")
							if($fichaOrg=="")
								$fichaOrg=$filaAfi[7];
							else
								$fichaOrg.=", ".$filaAfi[7];
						
						$fichaOrg.=".";
						$objAutor='{"idAutor":"'.$fila[0].'","apPat":"'.$fila[1].'","apMat":"'.$fila[2].'","telefono":"'."(".$fila[4].")".$fila[5].'","fax":"'."(".$fila[6].") ".$fila[7].'","mail":"'.$fila[8].'","nomb":"'.$fila[3].'","datosC":"'.$datosComp.'","fichaOrg":"'.$fichaOrg.'","idAfiliacion":"'.$filaAfi[0].'"}';		
						if($arrAutores=="")
							$arrAutores=$objAutor;
						else
							$arrAutores.=','.$objAutor;	
						$numA++;
					}
					while($filaAfi=mysql_fetch_row($resAfi));
				}
				
				
			}
			echo uEJ('{"numAutores":"'.$numA.'","autores":['.$arrAutores.']}');
		}
	}
	
	function obtenerTiposDocumentos()
	{
		global $lenguaje;
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$arrObj="";
		$obj="";
		$res=$con->obtenerFilas("select idDTD,nombre,descripcion from 202_descripcionDTD where idDTD<>1 and idIdioma=".$lenguaje." order by nombre");
		while($fila=mysql_fetch_row($res))
		{
			$obj='{"idDTD":"'.$fila[0].'","nombre":"'.uEJ($fila[1]).'","desc":"'.uEJ($fila[2]).'"}';
			if($arrObj=="")
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
		}
		echo "[".$arrObj."]";
	}
	
	function obtenerOrganizaciones()
	{

		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$nomOrg=$_POST["nomOrg"];
		$condWhere=" nomOrganizacion like '%".utf8_decode($nomOrg)."%'";
		$consulta="select * from 206_organizaciones where ".$condWhere;
		$res=$con->obtenerFilas($consulta);
		$arrOrg="";
		$numA=mysql_num_rows($res);
		while($fila=mysql_fetch_row($res))
		{
			$cp=$fila[5];
			$ciudad=$fila[2];
			$estado=$fila[3];
			$pais=$fila[4];
			$mail=$fila[6];
			$desc="";
			
			if($cp!="")
				$desc="C.P. ".$cp;
			if($ciudad!="")
				if($desc!="")
					$desc.=", ".$ciudad;
				else
					$desc=$ciudad;
			if($estado!="")
				if($desc!="")
					$desc.=", ".$estado;
				else
					$desc=$estado;
			if($pais!="")
				if($desc!="")
					$desc.=", ".$pais."";
				else
					$desc=$pais;
				
			
			$objOrg='{"idOrg":"'.$fila[0].'","nomOrg":"'.$fila[1].'","ciudad":"'.$ciudad.'","estado":"'.$estado.'","pais":"'.$pais.'","cp":"'.$cp.'","email":"'.$mail.'","desc":"'.$desc.'"}';
			
			if($arrOrg=="")
				$arrOrg=$objOrg;
			else
				$arrOrg.=','.$objOrg;	
		}
		echo '{"numOrg":"'.$numA.'","org":['.uEJ($arrOrg).']}';
	}
	
	function guardarDatosAutorArticulo($objParam=null)
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		if($objParam==null)
			$param=json_decode($_POST["param"]);
		else
			$param=json_decode($objParam);
		$idAfil=$param->idAfiliacion;
		$idDoc=$param->idDoc;
		$participacion=$param->idParticipacion;
		$participacionC=$param->partC;
		$cveParticipacion=$param->cvePartC;
		$autorC=$param->autorC;
		$consulta="select estado,idTipoArticulo from 204_proyectos where idArticulo=".$idDoc;
		$filaArt=$con->obtenerPrimeraFila($consulta);
		$edoDoc=$filaArt[0];
		$tipoArt=$filaArt[1];
		if($edoDoc!="0")
		{
			guardarVersionDocumento($idDoc);
		}
		$consulta="select distinct(a.apPaterno),a.apMaterno,a.nombres,org.nomOrganizacion,
					(select nomDivision from 208_divisionesOrg where idDivisionesOrg=af.idSubdivision1) as div1,
					(select nomDivision from 208_divisionesOrg where idDivisionesOrg=af.idSubdivision2) as div2,
					(select nomDivision from 208_divisionesOrg where idDivisionesOrg=af.idSubdivision3) as div3,
					org.ciudad,org.estado,org.pais,org.cp,org.email
					from  207_afiliaciones af,205_autores a,206_organizaciones org  where org.idOrganizacion=af.idOrganizacion and
					 a.idAutor=af.idAutor and af.idAfiliacion=".$idAfil;
		$idAutorAgregado="-1";

		$consulta="insert into 209_afiliacionesArticulos (idDocumento,idAfiliacion,participacion,cveParticipacion,idRaizDTD) values(".$idDoc.",".$idAfil.",'".$participacionC."','".$cveParticipacion."',".$idAutorAgregado.")";
		if(!$con->ejecutarConsulta($consulta))
			echo "";
		else
			echo "1";
		return;
		/*$res=$con->obtenerFilas($consulta);
		if($fila=mysql_fetch_row($res))
		{
			$consulta="begin";
			if($con->ejecutarConsulta($consulta))
			{
				$consulta2="select idElementoDTD,idElementoRevista from 203_elementosDTD where idElementoPadre=".$param->idAgrupacion;
				$res2=$con->obtenerFilas($consulta2);
				if(mysql_num_rows($res2)>0)
				{
					$consulta="insert into 212_valoresElementoDTD (idElementoDTD,idDocumento,valComp) values(".$param->idAgrupacion.",".$idDoc.",'".$idAfil."')";
					if($con->ejecutarConsulta($consulta))
					{
						
						$idAutorAgregado=$con->obtenerUltimoID();//Id al que se van a gregar los valor del atributo
						while($fila2=mysql_fetch_row($res2))
						{
							$valor="";
							switch($fila2[1])
							{
								case '8': //Constate del DTD
									$valor=$fila[0];
								break;
								case '9': //Constante del DTD
									$valor=$fila[2];
								break;
							}
							$consulta="insert into 212_valoresElementoDTD(idElementoDTD,idDocumento,valor,idPadre) values(".$fila2[0].",".$idDoc.",'".$valor."',".$idAutorAgregado.")";
							if(!$con->ejecutarConsulta($consulta))
							{
								return;
							}
						}
						
						$consultaA="select distinct(vO.nomOrganizacion),vO.Div1,vO.Div2,vO.Div3 from 209_afiliacionesArticulos ad,200_vOrganizaciones vO where vO.idAfiliacion=ad.idAfiliacion and ad.idDocumento=".$idDoc." order by ad.idAfiliacionesDoc";
						$resA=$con->obtenerFilas($consultaA);
						$numAf=1;
						$enc=false;
						while(($filaA=mysql_fetch_row($resA))&&(!$enc))
						{
							$nomOrg=$fila[3];
							$div1=$fila[4];
							$div2=$fila[5];
							$div3=$fila[6];
							if(($filaA[0]==$nomOrg) &&($filaA[1]==$div1)&&($filaA[2]==$div2)&&($filaA[3]==$div3))
								$enc=true;
							else
								$numAf++;
						}
						
						$afId="a".str_pad($numAf, 2, "0", STR_PAD_LEFT);
						if(!$enc)
						{	
							$resAux=obtenerIdElementoDeTipoArticulo("-".$tipoArt,13);
							
							if($resAux!="-1")
							{
								$idIff=$resAux;
								$nomOrg=$fila[3];
								$div1=$fila[4];
								$div2=$fila[5];
								$div3=$fila[6];
								$ciudad=$fila[7];
								$estado=$fila[8];
								$pais=$fila[9];
								$cp=$fila[10];
								$mail=$fila[11];
								$valorAf="";
								if($div3!="")
								{
									$valorAf=$div3;
								}
								if($div2!="")
								{
									if($valorAf=="")
										$valorAf=$div2;
									else
										$valorAf.=". ".$div2;
								}
								if($div1!="")
								{
									if($valorAf=="")
										$valorAf=$div1;
									else
										$valorAf.=". ".$div1;
								}
								
								if($valorAf=="")
									$valorAf=$nomOrg;
								else
									$valorAf.=". ".$nomOrg;
								
								$consulta="insert into 212_valoresElementoDTD(idElementoDTD,idDocumento,valor,valComp) values(".$idIff.",".$idDoc.",'".$valorAf."','1|".$idAfil."')";
								if($con->ejecutarConsulta($consulta))
								{
									$idAfiliacion=$con->obtenerUltimoID();
									$consulta="insert into 215_valoresAtributos(valor,idElemento,idAtributo) values('".$afId."',".$idAfiliacion.",6)";
									if($con->ejecutarConsulta($consulta))
									{
										$consulta="insert into 215_valoresAtributos(valor,idElemento,idAtributo) values('".$nomOrg."',".$idAfiliacion.",13)";
										if($con->ejecutarConsulta($consulta))
										{
											if($div1!="")
											{
												$consulta="insert into 215_valoresAtributos(valor,idElemento,idAtributo) values('".$div1."',".$idAfiliacion.",14)";
												if($con->ejecutarConsulta($consulta))
												{
												
													if($div2!="")
													{
														$consulta="insert into 215_valoresAtributos(valor,idElemento,idAtributo) values('".$div2."',".$idAfiliacion.",15)";
														if($con->ejecutarConsulta($consulta))
														{
															if($div3!="")
															{
																$consulta="insert into 215_valoresAtributos(valor,idElemento,idAtributo) values('".$div3."',".$idAfiliacion.",16)";
																if(!$con->ejecutarConsulta($consulta))
																{
																	return;	
																}
															}
														}
													}
														
												}
											}
										}	
									}
										
								}
								else
									return;
								
								$consulta="insert into 209_afiliacionesArticulos (idDocumento,idAfiliacion,participacion,cveParticipacion,idRaizDTD) values(".$idDoc.",".$idAfil.",'".$participacionC."','".$cveParticipacion."',".$idAutorAgregado.")";
								if(!$con->ejecutarConsulta($consulta))
									return;
								$idAfiliacion=$idAfil;	
								$consultaAux="select idElementoDTD,idElementoRevista from 203_elementosDTD where idElementoPadre=".$idIff;
								$resAux=$con->obtenerFilas($consultaAux);
								while($filaAux=mysql_fetch_row($resAux))
								{
									
									$ejecutar=false;
									switch($filaAux[1])
									{
										case 411:
											if($ciudad!="")
											{
												$valor=$ciudad;
												$ejecutar=true;
											}
										break;
										case 412:
											if($estado!="")
											{
												$valor=$estado;
												$ejecutar=true;
											}
										break;
										case 413:
											if($pais!="")
											{
												$valor=$pais;
												$ejecutar=true;
											}
										break;
										case 414:
											if($cp!="")
											{
												$valor=$cp;
												$ejecutar=true;
											}
										break;
										case 415:
											if($mail!="")
											{
												$valor=$mail;
												$ejecutar=true;
											}
										break;
									}
					
									if($ejecutar)
									{
										$consulta="insert into 212_valoresElementoDTD(idElementoDTD,idDocumento,valor,idPadre) values(".$filaAux[0].",".$idDoc.",'".$valor."',".$idAfiliacion.")";
										if(!$con->ejecutarConsulta($consulta))
										{
											return;
										}
									}
								}
							}		
						}
						else
						{
							$consulta="insert into 209_afiliacionesArticulos (idDocumento,idAfiliacion,participacion,cveParticipacion,idRaizDTD) values(".$idDoc.",".$idAfil.",'".$participacionC."','".$cveParticipacion."',".$idAutorAgregado.")";
							if(!$con->ejecutarConsulta($consulta))
								return;
						}	
							
						$consultaAux="insert into 215_valoresAtributos(valor,idElemento,idAtributo) values('".$participacion."',".$idAutorAgregado.",1)";
						if($con->ejecutarConsulta($consultaAux))
						{
							$consultaAux="insert into 215_valoresAtributos(valor,idElemento,idAtributo) values('".$afId."',".$idAutorAgregado.",2)";
							if(!$con->ejecutarConsulta($consultaAux))
								return;
							
						}
						else
							return;
						
						if($autorC=="true")
								{
									$consulta="update 204_proyectos set idAutorCorres=".$idAfil." where idArticulo=".$idDoc;
									if(!$con->ejecutarConsulta($consulta))
										return;
								
								}
						
						$consulta="commit";
						if($con->ejecutarConsulta($consulta))
						{
							echo "1";
						}
					}
				}
			}
		}*/
	}
	
	function guardarNuevoUsuario($objParam=null)
	{
		global $con;
		global $mostrarXML;
		global $urlSitio;
		$mostrarXML=false;
		if($objParam!=null)
			$cadObjJson=$objParam;
		else
			$cadObjJson=$_POST["param"];

		$objJson=json_decode($cadObjJson);
		$apPaterno=$objJson->apPaterno;
		$apMaterno=$objJson->apMaterno;
		$nombre=$objJson->nombres;
		$nombreC=trim($nombre).' '.trim($apPaterno).' '.trim($apMaterno);
		if(isset($objJson->prefijo))
			$prefijo=$objJson->prefijo;
		else
			$prefijo="";
		
		if(isset($objJson->fechaNac))
			$fechaNac="'".cambiaraFechaMysql($objJson->fechaNac)."'";
		else
			$fechaNac="NULL";
		
		
		$mail=$objJson->email;
		$idOrg=$objJson->afiliacion->idOrg;
		$query="select nomOrganizacion from 206_organizaciones where idOrganizacion=".$idOrg;
		$institucion=$con->obtenerValor($query);
		$nacionalidad="";
		$idDoc=$objJson->idDoc;
		if($idDoc=="-1")
		{
			$idIdioma=$objJson->idIdioma;
			$password=$objJson->passwd;
		}
		else
		{
			$password=generaPassword();
			$idIdioma="1";
		}
		$mailUsr=$mail;
		
		$query="insert into 800_usuarios(Login,Status,FechaCambio,Password,Nombre,idIdioma) values('".cv(trim($mail))."',0,'".date('Y-m-d')."','".cv($password)."','".cv($nombreC)."',".$idIdioma.")";
		if(!$con->ejecutarConsulta($query))
		{
			echo "|";
			return ;
		}
			
		$idUsuario=$con->obtenerUltimoID();
		$consulta[0]="begin";
		$consulta[1]="insert into 805_mails(Mail,Tipo,Notificacion,idUsuario) values('".cv(trim($mail))."',0,1,".$idUsuario.")";
		$consulta[2]="insert into 807_usuariosVSRoles(idUsuario,idRol) values(".$idUsuario.",-1)";
		$consulta[3]="insert into 807_usuariosVSRoles(idUsuario,idRol) values(".$idUsuario.",9)";
		$consulta[4]="insert into 802_identifica(Nom,Paterno,Materno,Nombre,Prefijo,fechaNacimiento,Nacionalidad,Status,idUsuario) 
					  values('".cv($nombre)."','".cv($apPaterno)."','".cv($apMaterno)."','".cv($nombreC).
					  "','".cv($prefijo)."',".$fechaNac.",'".cv($nacionalidad)."',0,".$idUsuario.")";
		$consulta[5]="insert into 801_adscripcion(Institucion,Status,idUsuario) values('".cv($institucion)."',0,".$idUsuario.")";
		$consulta[6]="insert into 803_direcciones(idUsuario,Tipo) values(".$idUsuario.",0)";
		$consulta[7]="insert into 803_direcciones(idUsuario,Tipo) values(".$idUsuario.",1)";
		$consulta[8]="insert into 806_fotos(idUsuario) values(".$idUsuario.")";
		$consulta[9]="commit";
		
		if($con->ejecutarBloque($consulta))		
			echo "1|";
		else
			echo "|";
		$link=$urlSitio."/principal/activaCuenta.php?cta=".base64_encode("cuenta:".$idUsuario);
		$arrParametros='[
						 	["$user","'.$mailUsr.'"],["$passwd","'.$password.'"],["$actLink","'.$link.'"],
							["$instituto","'.$institucion.'"],["$apPaterno","'.$apPaterno.'"],["$apMaterno","'.$apMaterno.'"],
							["$nombre","'.$nombre.'"],["$prefijo","'.$prefijo.'"],["$nacionalidad","'.$nacionalidad.'"]
						]';
		$objEnvio='{"destinatarios":"'.$mailUsr.'","arrParametros":'.$arrParametros.',"idAccion":"13"}';
		if(enviarCircular($objEnvio))
			return $idUsuario;
		else
			return "-1";
	}
	
	function guardarDatosAutor()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$cadObjJson=$_POST["param"];
		$objJson=json_decode($cadObjJson);
		$idAgrupacion=$objJson->idAgrupacion;
		$idElemR=$objJson->idElemR;
		$idDoc=$objJson->idDoc;
		$idUsuario=	guardarNuevoUsuario($cadObjJson);
		if($idUsuario=="-1")
		{
			echo "|";
			return;
		}
		$consulta="begin";
		$idUsr="-1";
		if(isset($_SESSION["idUsr"]))		
			$idUsr=$_SESSION["idUsr"];
		
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="insert into 205_autores(apPaterno,apMaterno,Nombres,codAreaTel,telefono,codAreaFax,fax,Email,idUsuario,idUsuarioRegistro) values('".cv($objJson->apPaterno)."','".cv($objJson->apMaterno)."','".cv($objJson->nombres)."','".cv($objJson->codArea)."','".cv($objJson->tel)."','".cv($objJson->codAreaFax)."','".cv($objJson->fax)."','".cv($objJson->email)."',".$idUsuario.",".$idUsr.")";
			if($con->ejecutarConsulta($consulta))
			{
				$idAutor=$con->obtenerUltimoID();
				$infoAfiliacion=$objJson->afiliacion;
				if($infoAfiliacion->idOrg=="-1")
				{
					$consulta='insert into 206_organizaciones(nomOrganizacion,ciudad,estado,pais,email,cp,idUsr) values("'.cv($infoAfiliacion->nomOrg).'","'.cv($infoAfiliacion->ciudad).'","'.cv($infoAfiliacion->estado).'","'.cv($infoAfiliacion->pais).'","'.cv($infoAfiliacion->email).'",'.$infoAfiliacion->cp.','.$idUsr.')';
					if($con->ejecutarConsulta($consulta))
						$idOrg=$con->obtenerUltimoID();
					else
						return;
				}
				else
					$idOrg=$infoAfiliacion->idOrg;

				$idDiv1=$infoAfiliacion->idDiv1;
				if(($idDiv1=="-1")&&(trim($infoAfiliacion->nomDiv1)!=""))
				{
					$consulta='insert into 208_divisionesOrg(idPadre,nomDivision,idUsr) values(-'.$idOrg.',"'.cv($infoAfiliacion->nomDiv1).'",'.$idUsr.')';
					if($con->ejecutarConsulta($consulta))
						$idDiv1=$con->obtenerUltimoID();
					else
						return;
				}
				$idDiv2=$infoAfiliacion->idDiv2;
				if(($idDiv2=="-1")&&(trim($infoAfiliacion->nomDiv2)!=""))
				{
					$consulta='insert into 208_divisionesOrg(idPadre,nomDivision,idUsr) values('.$idDiv1.',"'.cv($infoAfiliacion->nomDiv2).'",'.$idUsr.')';
					if($con->ejecutarConsulta($consulta))
						$idDiv2=$con->obtenerUltimoID();
					else
						return;
				}
				
				$idDiv3=$infoAfiliacion->idDiv3;
				if(($idDiv3=="-1")&&(trim($infoAfiliacion->nomDiv3)!=""))
				{
					$consulta='insert into 208_divisionesOrg(idPadre,nomDivision,idUsr) values('.$idDiv2.',"'.cv($infoAfiliacion->nomDiv3).'",'.$idUsr.')';
					if($con->ejecutarConsulta($consulta))
						$idDiv3=$con->obtenerUltimoID();
					else
						return;
				}
				if($idDiv1=="-1")
					$idDiv1="NULL";
				if($idDiv2=="-1")
					$idDiv2="NULL";
				if($idDiv3=="-1")
					$idDiv3="NULL";
				$consulta="insert into 207_afiliaciones(idAutor,idOrganizacion,idSubdivision1,idSubdivision2,idSubdivision3) values(".$idAutor.",".$idOrg.",".$idDiv1.",".$idDiv2.",".$idDiv3.")";
				if($con->ejecutarConsulta($consulta))
				{
					$idAfiliacion=$con->obtenerUltimoID();
					if($con->ejecutarConsulta("commit"))
					{
						if($idDoc!="-1")
						{
							$objGuardar='{
											"idParticipacion":"co",
											"idAfiliacion":"'.$idAfiliacion.'",
											"idAgrupacion":"'.$idAgrupacion.'",
											"idElemR":"'.$idElemR.'",
											"partC":"Coautor",
											"cvePartC":"co",
											"autorC":"false",
											"idDoc":'.$idDoc.'
										}';
							guardarDatosAutorArticulo($objGuardar);
						}
						else
							echo "1";
					}
				}
			}
		}
	}
	
	function obtenerDatosDiv()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$nomDiv=$_POST["nomDiv"];
		$idPadre=$_POST["idPadre"];
		$consulta="select idDivisionesOrg,nomDivision from 208_divisionesOrg where idPadre=".$idPadre." and nomDivision like '%".utf8_decode($nomDiv)."%'";
		$res=$con->obtenerFilas($consulta);
		$arrDiv="";
		$numA=mysql_num_rows($res);
		while($fila=mysql_fetch_row($res))
		{
			$objDiv='{"idDiv":'.$fila[0].',"nomDiv":"'.$fila[1].'"}';
			if($arrDiv=="")
				$arrDiv=$objDiv;
			else
				$arrDiv.=",".$objDiv;
		}
		echo '{"numDiv":"'.$numA.'","div":['.$arrDiv.']}';
	}
	
	function guardarCuerpo()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$valor=cv(utf8_decode($_POST["param"]));
		$idElementoDTD=$_POST["idElemento"];
		$idAccion=$_POST["accion"];
		$idDoc=$_POST["idDoc"];
		$consulta="select estado from 204_proyectos where idArticulo=".$idDoc;
		$edoDoc=$con->obtenerValor($consulta);
		if($edoDoc!="0")
			guardarVersionDocumento($idDoc);
		if($idAccion=='0')//agregar
			$consulta="insert into 212_valoresElementoDTD (idElementoDTD,idDocumento,valor) values(".$idElementoDTD.",".$idDoc.",'".$valor."')";
		else
			$consulta="update 212_valoresElementoDTD set valor='".cv($valor)."' where idValorElemento=".$idAccion;
		if($con->ejecutarConsulta($consulta))
		{
			if($idAccion==0)
				$idBody=$con->obtenerUltimoID();
			else
				$idBody=$idAccion;
			echo "1|".$idBody;
		}
		else
			echo "|";
		
	}
	
	function guardarResumen()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$cadObjJson=$_POST["param"];
		$objJson=json_decode($cadObjJson);
		$idDoc=$objJson->idDoc;
		$consulta="select estado,idTipoArticulo from 204_proyectos where idArticulo=".$idDoc;
		$filaArt=$con->obtenerPrimeraFila($consulta);
		$edoDoc=$filaArt[0];
		if($edoDoc!="0")
			guardarVersionDocumento($idDoc);
		$resumen=utf8_decode($_POST["resumen"]);
		$idElementoDTD=$objJson->idElemDTD;
		$idValorDTD=$objJson->idValorDTD;
		$valorLeng=$objJson->valorLeng;
		$tipoArt="-".$filaArt[1];
		if($idValorDTD=="0")
		{
			$idValorDTD=obtenerIdElementoDeTipoArticulo($tipoArt,$idElementoDTD);
			$consulta="Begin";
			$res=$con->ejecutarConsulta($consulta);
			if($res)
			{
				$consulta="insert into 212_valoresElementoDTD(idElementoDTD,idDocumento,valor) values (".$idValorDTD.",".$idDoc.",'".cv($resumen)."')";
				$res=$con->ejecutarConsulta($consulta);
				if($res)
				{
					$idValor=$con->obtenerUltimoID();
					$consulta="insert into 215_valoresAtributos(valor,idElemento,idAtributo) values('".$valorLeng."',".$idValor.",3)";
					$res=$con->ejecutarConsulta($consulta);
					if($res)
					{
						if($con->ejecutarConsulta("commit"))
							echo "1|".$idValor;
						else
							echo "|";
					}
					else
						echo "|";
				}
				else
					echo "|";
			}
			else
				echo "|";
		}
		else
		{
			$consulta="Begin";
			$res=$con->ejecutarConsulta($consulta);
			if($res)
			{
				$consulta="update 212_valoresElementoDTD set valor='".cv($resumen)."' where idValorElemento=".$idValorDTD;
				$res=$con->ejecutarConsulta($consulta);
				if($res)
				{
					$consulta="update 215_valoresAtributos set valor='".$valorLeng."' where idElemento=".$idValorDTD." and idAtributo=3";
					$res=$con->ejecutarConsulta($consulta);
					if($res)
					{
						if($con->ejecutarConsulta("commit"))
							echo "1|".$idValorDTD;
						else
							echo "|";
					}
					else
						echo "|";
				}
				else
					echo "|";
			}
			else
				echo "|";
		}
	}
	
	function obtenerIdElementoDeTipoArticulo($idPadre,$idElementoRevista)
	{
		global $con;
		$consulta="select idElementoDTD,idElementoRevista from 203_elementosDTD where idElementoPadre=".$idPadre;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			if($fila[1]==$idElementoRevista)
				return $fila[0];
			else
			{
				$id=obtenerIdElementoDeTipoArticulo($fila[0],$idElementoRevista);
				if($id!="-1")
					return $id;
			}
		}
		return "-1";
	}
	
	function obtenerDatosResumen()
	{
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		$idValorElemento=$_POST["param"];
		$consulta="select eDTD.idElementoDTD,convert(eDTD.valor using utf8),convert(a.valor using utf8),eDTD.idValorElemento from 200_vValorElementoDTDVsElementoDTD eDTD,215_valoresAtributos a  where a.idElemento=eDTD.idValorElemento and  eDTD.idValorElemento=".$idValorElemento." and eDTD.idDocumento=".$_SESSION["idDoc"];
		$res=$con->obtenerFilas($consulta);
		$datosResumen='';
		if($fila=mysql_fetch_row($res))
		{
			$valor=str_replace('\n','',$fila[1]);
			
			$datosResumen=$valor;
		}
		echo $datosResumen;
		
	}
	
	function guardarPalabraClave()
	{
		global $con;
		//idElementoR
		$idKGrp="15";
		$idKWord="16";
		$idSKey="17";
		//idValoresTag
		$idTagKeyGrp=obtenerIdElementoDeTipoArticulo("-".$_SESSION["tipoArt"],$idKGrp);
		$idTagKeyWord=obtenerIdElementoDeTipoArticulo("-".$_SESSION["tipoArt"],$idKWord);
		$idTagSubKey=obtenerIdElementoDeTipoArticulo("-".$_SESSION["tipoArt"],$idSKey);
		
		
		//Atributos
		$idTipo="5";
		$idLenguaje="3";
		$idRid="2";
		$idID="6";
	
		global $conexion;
		global $mostrarXML;
		$mostrarXML=false;
		$cadObjJson=$_POST["param"];
		$objJson=json_decode($cadObjJson);
		$pClave=$objJson->pClave; 	//
		$tDesc=$objJson->tDesc; 	//
		$leng=$objJson->leng;		//
		$cal=$objJson->cal;
		$idValorElem=$objJson->idValorElem;
		$idDoc=$_SESSION["idDoc"];
		$consulta="select estado from 204_proyectos where idArticulo=".$idDoc;
		$edoDoc=$con->obtenerValor($consulta);
		if($edoDoc!="0")
		{
			$idDoc=$_SESSION["idDoc"];
			guardarVersionDocumento($idDoc);
		}
		$consulta="begin";
		$resC=$con->ejecutarConsulta($consulta);
		if($resC)
		{
			$consulta="select idValorElemento from 200_vValorElementoDTDVsElementoDTD where  idElementoRevista=".$idKGrp." and valComp='".$idValorElem."'";
			$res=$con->obtenerValor($consulta);
			if($res=="")
			{
				$consulta="insert into 212_valoresElementoDTD(idElementoDTD,idDocumento,valComp) values(".$idTagKeyGrp.",".$_SESSION["idDoc"].",".$idValorElem.")";
				$resC=$con->ejecutarConsulta($consulta);
				if($resC)
				{
					$idValorEGrp=$con->obtenerUltimoID();
					//Poner Atributos KeyGrp
				}
				else
				{
					echo "|";
					return;
				}
			}
			else
				$idValorEGrp=$res;
			$consulta="insert into 212_valoresElementoDTD(idElementoDTD,idDocumento,valor,idPadre) values(".$idTagKeyWord.",".$_SESSION["idDoc"].",'".$pClave."',".$idValorEGrp.") ";
			$resC=$con->ejecutarConsulta($consulta);
			if($resC)
			{
				$idKeyWord=$con->obtenerUltimoID();
				$consulta="insert into 215_valoresAtributos(valor,idElemento,idAtributo) values('".utf8_decode($tDesc)."',".$idKeyWord.",".$idTipo.")";
				$resC=$con->ejecutarConsulta($consulta);
				if($resC)
				{
					$consulta="insert into 215_valoresAtributos(valor,idElemento,idAtributo) values('".utf8_decode($leng)."',".$idKeyWord.",".$idLenguaje.")";
					$resC=$con->ejecutarConsulta($consulta);
					if($resC)
					{
						if($cal!="")
						{
							$consulta="select count(idValorElemento) from 200_vValorElementoDTDVsElementoDTD where idElementoRevista=".$idSKey." and idPadre=".$idValorEGrp;
							$resC=$con->obtenerValor($consulta);
							$resC++;
							$idLlave="k".str_pad($resC, 2, "0", STR_PAD_LEFT);
							$consulta="insert into 215_valoresAtributos(valor,idElemento,idAtributo) values('".utf8_decode($idLlave)."',".$idKeyWord.",".$idRid.")";
							$resC=$con->ejecutarConsulta($consulta);
							if($resC)
							{
								$consulta="insert into 212_valoresElementoDTD(idElementoDTD,idDocumento,valor,idPadre,valComp) values(".$idTagSubKey.",".$_SESSION["idDoc"].",'".$cal."',".$idValorEGrp.",".$idKeyWord.") ";
								$resC=$con->ejecutarConsulta($consulta);
								if($resC)
								{
									$idSubKey=$con->obtenerUltimoID();
									$consulta="insert into 215_valoresAtributos(valor,idElemento,idAtributo) values('".utf8_decode($idLlave)."',".$idSubKey.",".$idID.")";
									$resC=$con->ejecutarConsulta($consulta);
									if($resC)
									{
										if($con->ejecutarConsulta("commit"))
										{
											echo "1|".$idKeyWord;
											return;
										}
										else
										{
											echo "|";
											return;
										}
										
									}
									else
									{
										echo "|";
										return;
									}
								}
								else
								{
									echo "|";
									return;
								}
							}
							else
							{
								echo "|";
								return;
							}
						}
						else
						{
							if($con->ejecutarConsulta("commit"))
							{
								echo "1|".$idKeyWord;
								return;
							}
							else
							{
								echo "|";
								return;
							}
						}
					}
					else
					{
						echo "|";
						return;
					}
				}
				else
				{
					echo "|";
					return;
				}
			}
			else
			{
				echo "|";
				return;
			}
		}
		else
			echo "|";
	}
	
	function cambiarEstadoDocumento($estado,$documento,$idAccion,$comentario)
	{
		global $con;
		$conValor="select estado from 204_proyectos where idArticulo=".$documento;
		$idEstadoA=$con->obtenerValor($conValor);
		$consulta[0]="begin";
		$consulta[1]= "insert into 230_accionesDocumentos(accion,idDoc,idUsuarioC,fechaAccion,comentarios,idEdoAnterior,idEdoActual)
						values(".$idAccion.",".$documento.",".$_SESSION["idUsr"].",'".date('Y-m-d')."','".cv($comentario)."',".$idEstadoA.",
						".$estado.")";
		$consulta[2]="update 204_proyectos set estado=".$estado." where idArticulo=".$documento;
		$consulta[3]="commit";
		return $con->ejecutarBloque($consulta);
	}
	
	function someterDocSumision()
	{
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		$idDoc=$_POST["idDoc"];
		$edoSumision="9";
		if(cambiarEstadoDocumento($edoSumision,$idDoc,"3",""))
		{
			$consulta="select descripcion from 2000_estadosPublicacion where cveEstado=".$edoSumision;
			$estadoS=$con->obtenerValor($consulta);
			echo "1|".$estadoS;
		}
		else
			echo "|";
	}
	
	function cambiarDatosSesion()
	{
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		$valores=$_POST["param"];
		$arrVal=explode('|',$valores);
		$ct=sizeof($arrVal);
		for($x=0;$x<$ct;$x+=2)
		{
			$_SESSION[$arrVal[$x]]=$arrVal[$x+1];
		}
		echo "1";
	}
	
	function cambiarAutorCorrespondencia()
	{
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		$id=$_POST["id"];
		if($id=="-1")
			$id="null";
		$consulta="update 204_proyectos set idAutorCorres=".$id." where idArticulo=".$_SESSION["idDoc"];
		if($con->ejecutarConsulta($consulta))
			echo "1";
	}
	
	function obtenerUsuarios()
	{
		global $filasAfectadas;
		global $mostrarXML;
		global $con;
		$mostrarXML=false;
		$usuario=$_POST["datosUsuario"];	
		$consulta="select i.idUsuario,concat(i.prefijo,' ',i.Nombre) as usuario from 802_identifica i where Nombre like '%".$usuario."%'";
		$usuarios='"usuarios":'.$con->obtenerFilasJson($consulta);
		$numUsuarios='"numUsuarios":"'.$filasAfectadas.'"';
		echo '{'.$numUsuarios.','.$usuarios.'}';
		
	}
	
	function eliminarComite()
	{
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		$idSeccion=$_POST["idSeccion"];
		$query="select idUnidadRol from 2006_comites where idComite=".$idSeccion;
		$idUnidad=$con->obtenerValor($query);
		$consulta[0]="begin";
		$consulta[1]="delete from 2006_comites where idComite=".$idSeccion;
		$consulta[2]="delete from 4084_unidadesRoles where idUnidadesRoles=".$idUnidad;
		$consulta[3]="commit";
		if($con->ejecutarBloque($consulta))
			echo "1";
		else
			echo "-1";
	}
	
	function miembroComite()
	{
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		$idMiembro=$_POST["idMiembro"];
		$accion=$_POST["accion"];
		switch($accion)
		{
			case "-1":
				$consulta="update 802_identifica set miembroComite=0 where idUsuario=".$idMiembro;
			break;
			case "1":
				$consulta="update 802_identifica set miembroComite=1 where idUsuario=".$idMiembro;
			break;
		}
		
		if($con->ejecutarConsulta($consulta))
			echo "1";
		else
			echo "-1";
	}
	
	function guardarCirculares()
	{
		global $mostrarXML;
		global $con;
		$mostrarXML=false;
		$parametro=str_replace('\\\\','\\',$_POST["param"]);
		$objJson=json_decode($parametro);
		$idCircular=$objJson->idCircular;
		$circulares=$objJson->circulares;
		//$permisos=$objJson->permisos;
		//$arrPermisos=explode(",",$permisos);
		
		$ct=sizeof($circulares);
		$obj;
		$consultaIdPlantilla="select idPlantillaSig from tbl_variablesSistema";
		$idPlantilla=$con->obtenerValor($consultaIdPlantilla);
		$p=0;
		$consulta[$p]="begin";
		$p++;
		if($idCircular!="")
		{
			//$consulta[$p]="delete from 229_circularesVSRoles where idCircular=".$idCircular;
			//$p++;
			$consulta[$p]="delete from 2004_platillasCirculares where idPlantillaG=".$idCircular;
			$p++;
		}
		for($x=0;$x<$ct;$x++)
		{
			$obj=$circulares[$x];
			$consulta[$p]="insert into 2004_platillasCirculares(asunto,cuerpo,idIdioma,idPlantillaG,descripcion,idUsuario,idAccionEnvio) values('".cv($obj->asunto)."','".cv($obj->cuerpo)."',".cv($obj->idIdioma).",".$idPlantilla.",'".cv($obj->desc)."',".$_SESSION["idUsr"].",".$obj->accionE.")";
			$p++;

		}
		/*$ct=sizeof($arrPermisos);
		for($x=0;$x<$ct;$x++)
		{
			$consulta[$p]="insert into 229_circularesVSRoles(idCircular,idRol) values(".$idPlantilla.",".$arrPermisos[$x].")";
			$p++;
		}*/
		$consulta[$p]="update tbl_variablesSistema set idPlantillaSig=idPlantillaSig+1";
		$p++;
		$consulta[$p]="commit";
		if($con->ejecutarBloque($consulta))
			echo "1|".$idPlantilla;
		else
			echo "-1|";		
	}
	
	function obtenerCirculares()
	{
		global $mostrarXML;
		global $con;
		$mostrarXML=false;
		$idCircular=$_POST["idCircular"];
		$plantillas=$con->obtenerFilasJson("select asunto,cuerpo,idIdioma,descripcion from 2004_platillasCirculares where idPlantillaG=".$idCircular);
		$consulta="select idGrupo from 229_circularesVSRoles where idCircular=".$_POST["idCircular"];
		$permisos=$con->obtenerListaValores($consulta);
		$obj='[{"permisos":"'.$permisos.'",plantillas:'.utf8_encode($plantillas).'}]';
		echo $obj;
	}
	
	function eliminarCircular()
	{
		global $mostrarXML;
		global $con;
		$mostrarXML=false;
		$idCircular=$_POST["idCircular"];
		$consulta="delete from 2004_platillasCirculares where idPlantillaG=".$idCircular;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "-1|";
	}
	
	
	
	/*function enviarCircular()
	{
		global $mostrarXML;
		global $con;
		$mostrarXML=false;
		$parametro=$_POST["param"];
		$objJson=json_decode($parametro);
		$dest=$objJson->dest;
		$asunto=$objJson->asunto;
		$cuerpo=$objJson->cuerpo;
		if(substr_count($cuerpo,"\$tCuenta")>0)
		{
			$arrMail=explode(',',$des);
			$ctMail=sizeof($arrMail);
			for($x=0;$x<$ctMail;$x++)
			{
				$correo=trim($arrMail[$x]);
				$consulta="select idUsuario from 805_mails where Mail='".$correo."'";
				$idUsuario=$con->obtenerValor($consulta);
				$consulta="select concat(Prefijo,' ',Nombre) from 802_identifica where idUsuario=".$idUsuario;
				$titular=$con->obtenerValor($consulta);
				$cuerpoFinal=str_replace('\$tCuenta',$titular);
				if(!enviarMail($correo,$asunto,$cuerpoFinal))
				{
					echo "-1|Ha ocurrido un problema y no se ha podido enviar los correos, por favor inténtelo más tardes";
					return;
				}
				
			}	
			$consulta="insert into 228_circularesEnviadas(destinatario,asunto,cuerpo,fechaEnvio,idUsuario) 
							values('".cv($dest)."','".cv($asunto)."','".cv($cuerpo)."','".date('Y-m-d')."',".$_SESSION["idUsr"].")";
			if($con->ejecutarConsulta($consulta))
				echo "1|";
			else
				echo "-1|Ha ocurrido un problema en la BD y no se ha podido guaradr el registro de envio";

		}
		else
		{
			/*if(enviarMail($dest,$asunto,$cuerpo))
			{
				
				$consulta="insert into 228_circularesEnviadas(destinatario,asunto,cuerpo,fechaEnvio,idUsuario) 
							values('".cv($dest)."','".cv($asunto)."','".cv($cuerpo)."','".date('Y-m-d')."',".$_SESSION["idUsr"].")";
				if($con->ejecutarConsulta($consulta))
					echo "1|";
				else
					echo "-1|Ha ocurrido un problmea en la BD y no se ha podido guaradr el registro de envio";
			}
			else
				echo "-1|Ha ocurrido un problema y no se ha podido enviar los correos, por favor inténtelo más tardes";	
		}
							
	}*/
	
	function obtenerListadoCirculares()
	{
		global $mostrarXML;
		global $con;
		$mostrarXML=false;
		
		$consulta="select distinct(idCircular) from 229_circularesVSRoles where idRol in (".$_SESSION["idRol"].")";
		$listadoPlantillas=$con->obtenerListaValores($consulta);
		if($listadoPlantillas=="")
			$listadoPlantillas="-1";
		$consulta="(select asunto,descripcion,idPlantillaG as idPlantilla from 2004_platillasCirculares where idIdioma=".$_POST["idIdioma"]." and idUsuario=".$_SESSION["idUsr"].") union " ;
		$consulta.="(select asunto,descripcion,idPlantillaG as idPlantilla from 2004_platillasCirculares where idIdioma=".$_POST["idIdioma"]." and idPlantillaG in(".$listadoPlantillas."))";		
		$obj=$con->obtenerFilasJson($consulta);
		echo '{"plantillas":'.$obj.'}';
	}
	
	function obtenerPlantillaFormateada()
	{
		global $mostrarXML;
		global $con;
		$mostrarXML=false;
		$idPlantilla=$_POST["idPlantilla"];
		$cuerpo=$con->obtenerValor("select cuerpo from 2004_platillasCirculares where idIdioma=".$_POST["idIdioma"]." and idPlantillaG=".$idPlantilla);
		$cuerpoTmp=str_replace("\$fEnvio",date('d/m/Y'),$cuerpo);
		$cuerpo=str_replace("\$tRemitente",$_SESSION["nombreUsr"],$cuerpoTmp);
		echo dv($cuerpo);
	}
	
	function obtenerAutoresSeccion()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$parametro=$_POST["datosAutor"];
		$objJson=json_decode($parametro);
		$consulta="select idUsuario as idAutor, concat(Prefijo,' ',Nombre) as nombreC from 802_identifica where Nombre like '%".cv($objJson->autor)."%'";
		$res=$con->obtenerFilasJson($consulta);
		$obj='{"numAutores":"'.$con->filasAfectadas.'","autores":'.$res.'}';
		echo $obj;
	}
	
	function obtenerRevisores()
	{
		global $con;
		global $mostrarXML;
		global $et;
		$mostrarXML=false;
		$parametro=$_POST["datosRevisor"];
		$objJson=json_decode($parametro);
		$consulta="select i.idUsuario as idRevisor, concat(Prefijo,' ',Nombre) as nombres,dependencia as datosC, if(i.Status=100,'".$et["lblNUS"]."','".$et["lblUS"]."') as estado from 802_identifica i,801_adscripcion a where a.idUsuario=i.idUsuario and Nombre like '%".cv($objJson->revisor)."%' and (i.idUsuario in (select idUsuario from 807_usuariosVSRoles where codigoRol='10_0') and i.idUsuario not in (select idRevisor from 227_articulosVSRevisores where idArticulo=".$_SESSION["idDoc"]."))";
		$res=$con->obtenerFilasJson($consulta);
		$obj='{"numRevisores":"'.$con->filasAfectadas.'","revisores":'.utf8_encode($res).'}';
		echo $obj;
	}
	
	function asignarRevisor()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$idRevisor=$_POST["idRevisor"];
		$consulta="insert into 227_articulosVSRevisores(idArticulo,idRevisor,estado) values(".$_SESSION["idDoc"].",".$idRevisor.",1)";
		if($con->ejecutarConsulta($consulta))
			echo "1";
		else
			echo "|";
	}
	
	function removerRevisor()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$idRevisor=$_POST["idAsignacion"];
		$idDoc=$_POST["idDoc"];
		$query="select Status from 800_usuarios where idUsuario=".$idRevisor;
		$status=$con->obtenerValor($query);
		$query="select count(idRevisor) from 227_articulosVSRevisores where idRevisor=".$idRevisor;
		$numArtAsig=$con->obtenerValor($query);
		$x=0;
		
		$consulta[$x]="begin";
		$x++;	
		if(($status=="100")&&($numArtAsig=="1"))
		{
			$consulta[$x]="delete from 800_usuarios where idUsuario=".$idRevisor;
			$x++;			
			$consulta[$x]="delete from 801_adscripcion where idUsuario=".$idRevisor;
			$x++;			
			$consulta[$x]="delete from 802_identifica where idUsuario=".$idRevisor;
			$x++;		
			$consulta[$x]="delete from 804_telefonos where idUsuario=".$idRevisor;
			$x++;		
			$consulta[$x]="delete from 805_mails where idUsuario=".$idRevisor;
			$x++;		
			$consulta[$x]="delete from 807_usuariosVSRoles where idUsuario=".$idRevisor;
			$x++;		
			
		}
		$consulta[$x]="delete from 227_articulosVSRevisores where idRevisor=".$idRevisor." and idArticulo=".$idDoc;
		$x++;
		$consulta[$x]="commit";
		if($con->ejecutarBloque($consulta))
			echo "1";
		else
			echo "|";
	}
	
	function registrarRevisor()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$parametro=$_POST["param"];
		$objJson=json_decode($parametro);
		$aPaterno=$objJson->aPaterno;
		$aMaterno=$objJson->aMaterno;
		$nombre=$objJson->nombre;
		$prefijo=$objJson->prefijo;
		$institucion=$objJson->institucion;
		$mail=$objJson->mail;
		$codArea=$objJson->codArea;
		$lada=$objJson->lada;
		$ext=$objJson->ext;
		$tel=$objJson->tel;
		$nombreC=trim($nombre.' '.$aPaterno.' '.$aMaterno);
		$query="begin";
		if($con->ejecutarConsulta($query))
		{
			$query="insert into 800_usuarios(Nombre,Status) values('".cv($nombreC)."',100)";
			if($con->ejecutarConsulta($query))
			{
				$idUsuario=$con->obtenerUltimoID();
				$consulta[0]="insert into 801_adscripcion(Institucion,Status,idUsuario)values('".cv($institucion)."',100,".$idUsuario.")";
				$consulta[1]="insert into 802_identifica(Nom,Paterno,Materno,Nombre,Prefijo,Status,idUsuario) 
							  values('".cv($nombre)."','".cv($aPaterno)."','".cv($aMaterno)."','".cv($nombreC)."','".
							  cv($prefijo)."',100,".$idUsuario.")";
				$consulta[2]="insert into 804_telefonos(codArea,Lada,Extension,Numero,Tipo,Tipo2,idUsuario) 
							  values('".cv($codArea)."','".cv($lada)."','".cv($ext)."','".cv($tel)."',0,0,".$idUsuario.")";
				$consulta[3]="insert into 805_mails(Mail,Tipo,Notificacion,idUsuario) values('".cv($mail)."',0,1,".$idUsuario.")";
				$consulta[4]="insert into 227_articulosVSRevisores(idArticulo,idRevisor,estado) values(".$_SESSION["idDoc"].",".$idUsuario.",0)";
				$consulta[5]="insert into 807_usuariosVSRoles(idUsuario,idRol) values(".$idUsuario.",5)";
				$consulta[6]="commit";
				if($con->ejecutarBloque($consulta))
					echo "1|";
				else
					echo "|";
				
			}
			else
				echo "|";
		}
		else
			echo "|";
	}
	
	function cambiarSeccion()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$parametro=$_POST["param"];
		$objJson=json_decode($parametro);
		$idSeccion=$objJson->idSeccion;
		$motivo=$objJson->motivo;
		$idDoc=$objJson->idDoc;
		$csr=$objJson->csr;
		$accionC=$objJson->accionC;
		$conValor="select estado from 204_proyectos where idArticulo=".$idDoc;
		$idEstadoA=$con->obtenerValor($conValor);
		$consulta[0]="begin";
		$accionCambio;
		if($accionC==0)
		{
			if($csr==0)
			{
				$consulta[1]="update 204_proyectos set idSeccion=".$idSeccion." where idArticulo=".$idDoc;
				$accionCambio="4";
			}
			else
			{
				$consulta[1]="update 204_proyectos set idSeccion=".$idSeccion.",idSeccionRevisora=".$idSeccion." where idArticulo=".$idDoc;
				$accionCambio="6";
			}
		}
		else
		{
			$consulta[1]="update 204_proyectos set idSeccionRevisora=".$idSeccion." where idArticulo=".$idDoc;
			$accionCambio="5";
		}
			
		$consulta[2]="	insert into 230_accionesDocumentos(accion,idDoc,idUsuarioC,fechaAccion,comentarios,idEdoAnterior,idEdoActual) values
						(".$accionCambio.",".$idDoc.",".$_SESSION["idUsr"].",'".date('Y-m-d')."','".cv($motivo)."',".$idEstadoA.",".$idEstadoA.")";
		$consulta[3]="commit";
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
		
		
	}
	
	
	function obtenerContenidos()
	{
		global $mostrarXML;
		global $con;
		$mostrarXML=false;
		$idContenido=$_POST["idContenido"];
		$contenidos=$con->obtenerFilasJson("select contenido,idIdioma from 816_contenidos where idGrupoContenido=".$idContenido);
		$contenidos=str_replace("\\\\\\","\\",$contenidos);
		$obj='[{"arrContenidos":'.utf8_encode($contenidos).'}]';
		echo $obj;
	}
	
	function guardarContenidos()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$cadObjJson=$_POST["param"];
		$objJson=json_decode($cadObjJson);
		$idContenido=$objJson->idContenido;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$arrContenidos=$objJson->contenidos;
		$nContenido=sizeof($arrContenidos);
		for($ct=0;$ct<$nContenido;$ct++)
		{
			$consulta[$x]="update 816_contenidos set contenido='".cv($arrContenidos[$ct]->cuerpo)."' where idGrupoContenido=".$idContenido." and idIdioma=".$arrContenidos[$ct]->idIdioma;
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function rechazarDocumento()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$cadObjJson=$_POST["param"];
		$objJson=json_decode($cadObjJson);
		
		$conValor="select estado from 204_proyectos where idArticulo=".$objJson->idDoc;
		$idEstadoA=$con->obtenerValor($conValor);
		$consulta[0]="begin";
						
		$consulta[1]=	"insert into 230_accionesDocumentos(accion,idDoc,idUsuarioC,fechaAccion,comentarios,idEdoAnterior,idEdoActual)
						values(7,".$objJson->idDoc.",".$_SESSION["idUsr"].",'".date('Y-m-d')."','".cv($objJson->motivo)."',".$idEstadoA.",'7')";				
		$consulta[2]="update 204_proyectos set estado=7 where idArticulo=".$objJson->idDoc;
		$consulta[3]="commit";
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
		
	}
	
	function enviarEditorSec()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$cadObjJson=$_POST["param"];
		$objJson=json_decode($cadObjJson);
		$conValor="select estado from 204_proyectos where idArticulo=".$objJson->idDoc;
		$idEstadoA=$con->obtenerValor($conValor);
		$consulta[0]="begin";
		$consulta[1]=	"insert into 230_accionesDocumentos(accion,idDoc,idUsuarioC,fechaAccion,comentarios,idEdoAnterior,idEdoActual)
						values(8,".$objJson->idDoc.",".$_SESSION["idUsr"].",'".date('Y-m-d')."','".cv($objJson->motivo)."',".$idEstadoA.",10)";
		$consulta[2]="update 204_proyectos set estado=10 where idArticulo=".$objJson->idDoc;
		$consulta[3]="commit";
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
		
	}
	
	function obtenerRevisoresEditorSeccion()
	{
		global $con;
		global $mostrarXML;
		global $et;
		$mostrarXML=false;
		$parametro=$_POST["datosRevisor"];
		$objJson=json_decode($parametro);
		$idDoc=$objJson->idDoc;
		$consulta="select i.idUsuario as idRevisor, concat(Prefijo,' ',Nombre) as nombres,dependencia as datosC, if(i.Status=100,'".$et["lblNUS"]."','".$et["lblUS"]."') as estado from 802_identifica i,801_adscripcion a where a.idUsuario=i.idUsuario and Nombre like '%".cv($objJson->revisor)."%' and (i.idUsuario in (select idUsuario from 807_usuariosVSRoles where codigoRol='10_0') and i.idUsuario not in (select idRevisor from 227_articulosVSRevisores where idArticulo=".$idDoc."))";
		$res=$con->obtenerFilasJson($consulta);
		$obj='{"numRevisores":"'.$con->filasAfectadas.'","revisores":'.$res.'}';
		echo $obj;
	}
	
	function asignarRevisorEditorSeccion()
	{
		global $con;
		global $mostrarXML;
		global $et;
		$mostrarXML=false;
		$idDoc=$_POST["idDoc"];
		$idRevisor=$_POST["idRevisor"];
		$fechaAct=date('y-m-d');
		if(!isset($_POST["actualizar"]))
			$consulta="insert into 227_articulosVSRevisores(idArticulo,idRevisor,estado,aprobado,fechaAprobado) values(".$idDoc.",".$idRevisor.",2,1,'".$fechaAct."')";
		else
			$consulta="update 227_articulosVSRevisores set aprobado=1,fechaAprobado='".$fechaAct."' where idRevisor=".$_POST["idRevisor"]." and idArticulo=".$idDoc;
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|";
		}
		else
			echo "|";
	}
	
	function removerAsignacion()
	{
		global $con;
		global $mostrarXML;
		global $et;
		$mostrarXML=false;
		$idDoc=$_POST["idDoc"];
		$idRevisor=$_POST["idRevisor"];
		$consulta="select estado from 227_articulosVSRevisores where idRevisor=".$_POST["idRevisor"]." and idArticulo=".$idDoc;
		$estado=$con->obtenerValor($consulta);
		if($estado<>"2")
			$consulta="update 227_articulosVSRevisores set aprobado=0 where idRevisor=".$_POST["idRevisor"]." and idArticulo=".$idDoc;
		else
			$consulta="delete from 227_articulosVSRevisores where idRevisor=".$_POST["idRevisor"]." and idArticulo=".$idDoc;
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|";
		}
		else
			echo "|";
	}
	
	function enviarRevisores()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$cadObjJson=$_POST["param"];
		$objJson=json_decode($cadObjJson);
		$conValor="select estado from 204_proyectos where idArticulo=".$objJson->idDoc;
		$idEstadoA=$con->obtenerValor($conValor);
		$conValor="select estado,numRevision+1 as numRevision from 204_proyectos where idArticulo=".$objJson->idDoc;
		$fila=$con->obtenerPrimeraFila($conValor);
		$x=0;
		$idEstadoA=$fila[0];
		$numRevision=$fila[1];
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]=	"insert into 230_accionesDocumentos(accion,idDoc,idUsuarioC,fechaAccion,comentarios,idEdoAnterior,idEdoActual)
						values(9,".$objJson->idDoc.",".$_SESSION["idUsr"].",'".date('Y-m-d')."','".cv($objJson->motivo)."',".$idEstadoA.",'11')";
		$x++;
		$consulta[$x]="update 204_proyectos set estado=11,numRevision=".$numRevision." where idArticulo=".$objJson->idDoc;
		$x++;
		
		$consultaNR="select idRevisor from 227_articulosVSRevisores where idArticulo=".$objJson->idDoc." and aprobado=1";
		$res=$con->obtenerFilas($consultaNR);
		while($filasRev=mysql_fetch_row($res))
		{
			$consulta[$x]="insert into 216_dictamenes(noRevision,idRevisor,idDocumento) values(".$numRevision.",".$filasRev[0].",".$objJson->idDoc.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function validarEnvioRevisor()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$idDoc=$_POST["idDoc"];
		$consulta="select count(idArticulo) from 227_articulosVSRevisores where idArticulo=".$idDoc." and aprobado=1";
		$nAsignados=$con->obtenerValor($consulta);
		if($nAsignados=="0")
			echo "-1";
		else
			echo "1";
		
	}
	
	function aprobarPorEditor()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$cadObjJson=$_POST["param"];
		$objJson=json_decode($cadObjJson);
		$conValor="select estado from 204_proyectos where idArticulo=".$objJson->idDoc;
		$idEstadoA=$con->obtenerValor($conValor);
		$consulta[0]="begin";
		$consulta[1]=	"insert into 216_cambiosEdoArticulos(idDocumento,estadoAnterior,estadoActual,fechaCambio,idUsuario,comentarios) 
						values(".$objJson->idDoc.",".$idEstadoA.",12,'".date('Y-m-d')."',".$_SESSION["idUsr"].",'".cv($objJson->motivo)."')";
		$consulta[2]="update 204_proyectos set estado=12 where idArticulo=".$objJson->idDoc;
		$consulta[3]="commit";
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
		
	}
	
	function validarMail()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$mail=$_POST["mail"];
		$query="select idMail from 805_mails where Mail='".cv(trim($mail))."'";
		if($con->existeRegistro($query))
			echo "-1";
		else
			echo "1";
	}
	
	/*function enviarCircular($parametros2=null)
	{
		global $mostrarXML;
		global $con;
		$mostrarXML=false;
		if($parametros2==null)
			$parametros=$_POST["parametros"];
		else
			$parametros=$parametros2;
		
		$objParametro=json_decode($parametros);
		
		$arrParametros=$objParametro->arrParametros;
		$cadDest=$objParametro->destinatarios;
		$numParam=sizeof($arrParametros);
		$idAccion=$objParametro->idAccion;
		$consulta="select asunto,cuerpo from 2004_platillasCirculares where idIdioma=".$_SESSION["leng"]." and idAccionEnvio=".$idAccion;
		$fila=$con->obtenerPrimeraFila($consulta);
		$asunto=$fila[0];
		$cuerpo=$fila[1];
		
		for($x=0;$x<$numParam;$x++)
			$cuerpo=str_replace($arrParametros[$x][0],$arrParametros[$x][1],$cuerpo);

		$arrDestinatario=explode(',',$cadDest);
		$numDest=sizeof($arrDestinatario);
		for($x=0;$x<$numDest;$x++)
		{
			if(!enviarMail($arrDestinatario[$x],$asunto,$cuerpo))
			{
				echo "-1|";
				return;
			}
		}
		$consulta="insert into 228_circularesEnviadas(destinatario,asunto,cuerpo,fechaEnvio,idUsuario) 
		values('".cv($cadDest)."','".cv($asunto)."','".cv($cuerpo)."','".date('Y-m-d')."',-1000)";	
		if($con->ejecutarConsulta($consulta))
			return true;
		else
			return false;
	}*/
	
	
	
	function obtenerSeccionesDoc()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		if($_POST["tCambio"]==0)
			$consulta="select idSeccion, tituloSeccion from 2006_secciones where idSeccion not in(select idSeccion from 204_proyectos where idArticulo=".$_POST["idDoc"].")";
		else
			$consulta="select idSeccion, tituloSeccion from 2006_secciones where idSeccion not in(select idSeccionRevisora from 204_proyectos where idArticulo=".$_POST["idDoc"].")";
		$obj=utf8_decode($con->obtenerFilasArreglo($consulta));
		echo $obj;
	}
	
	function cancelarDocumento()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$idDocumento=$_POST["idDoc"];
		$motivo=$_POST["motivo"];
		$conValor="select estado from 204_proyectos where idArticulo=".$idDocumento;
		$idEstadoA=$con->obtenerValor($conValor);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 204_proyectos set estado=2 where idArticulo=".$idDocumento;
		$x++;
		$consulta[$x]=	"insert into 230_accionesDocumentos(accion,idDoc,idUsuarioC,fechaAccion,comentarios,idEdoAnterior,idEdoActual)
						values(2,".$idDocumento.",".$_SESSION["idUsr"].",'".date('Y-m-d')."','".cv($motivo)."',".$idEstadoA.",'2')";
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function ponderarSeccion()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$idSeccion=$_POST["idGrupoSeccion"];
		$porcentaje=$_POST["porcentaje"];
		$idCuestionario=$_POST["idCuestionario"];
		$consulta[0]="begin";
		$consulta[1]="update 233_seccionesCuestionario set ponderacion=".$porcentaje." where idGrupoSeccion=".$idSeccion." and idCuestionario=".$idCuestionario;
		$consulta[2]="update 231_cuestionariosEvaluacion set porcentaje=(select sum(ponderacion) from 233_seccionesCuestionario where idIdioma=".$_SESSION["leng"]." and idCuestionario=".$idCuestionario.") where idCuestionario=".$idCuestionario;
		$consulta[3]="commit";
		
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarPregunta()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$objJson=json_decode( $_POST["datosP"]);
		$idCuestionario=$objJson->idCuestionario;
		$pregunta=$objJson->pregunta;
		if(isset($objJson->opciones))
		{
			$opciones=$objJson->opciones;
			$tipoElemento=1;
		}
		else
			$tipoElemento=2;
			
		$query="begin";
		$maxValorOpcion=0;
		if($con->ejecutarConsulta($query))
		{
			$numPreguntas=sizeof($pregunta);
			if($pregunta[0]->idElemento==-1)//agregar Pregunta
			{
				$query="select idPreguntaCuestSig from 232_variablesSistema for update";
				$idPregunta=$con->obtenerValor($query);
				
				$query="select idOpcionCuestSig from 232_variablesSistema for update";
				$idGrupoOpcion=$con->obtenerValor($query);
				$numOpcionesAgregadas=0;
				$x=0;
				
				
				if($tipoElemento==1)
				{
					$numOpciones=sizeof($opciones);
					for($ct=0;$ct<$numOpciones;$ct++)
					{
						$valorOpcion=$opciones[$ct]->vOpcion;
						if($valorOpcion>$maxValorOpcion)
							$maxValorOpcion=$valorOpcion;
						$arrOpciones=$opciones[$ct]->columnas;
						$numOpt=sizeof($arrOpciones);
						for($y=0;$y<$numOpt;$y++)
						{
							$consulta[$x]="insert into 235_opcionesCuestionario(contenido,valor,idIdioma,idGrupoElemento,idGrupoOpcion) values
											('".$arrOpciones[$y]->texto."','".$valorOpcion."',".$arrOpciones[$y]->idLeng.",".$idPregunta.",".($idGrupoOpcion+$numOpcionesAgregadas).")";
							$x++;
						}
						$numOpcionesAgregadas++;
					}
					
					
				}
				$iElemAnt=$pregunta[0]->idElemAnt;
				$idElemSig="-1";
				$idSeccion=$pregunta[0]->idSeccion;
				
				if($iElemAnt!="-1")
				{
					$query="select idElemSiguiente from 234_elementosCuestionario where idGrupoElemento=".$iElemAnt;
					$idElemSig=$con->obtenerValor($query);
				}
				else
				{
					$query="select idGrupoElemento from 234_elementosCuestionario where idElemAnterior=-1 and idSeccion=".$idSeccion;
					$idElemSig=$con->obtenerValor($query);
					if($idElemSig=="")
						$idElemSig="-1";
				}
				
				
				for($ct=0;$ct<$numPreguntas;$ct++)
				{
					$consulta[$x]="insert into 234_elementosCuestionario(contenidoElemento,idIdioma,idElemAnterior,idElemSiguiente,idCuestionario,
									tipoElemento,idSeccion,idGrupoElemento,maxValorRespuesta) values('".cv($pregunta[$ct]->etiqueta)."',".$pregunta[$ct]->idIdioma.
									",".$iElemAnt.",".$idElemSig.",".$idCuestionario.",".$tipoElemento.",".$idSeccion.
									",".$idPregunta.",".$maxValorOpcion.")";
					
					$x++;
				}
				
				if($iElemAnt!="-1")
				{
					$consulta[$x]="update 234_elementosCuestionario set idElemSiguiente=".$idPregunta." where idGrupoElemento=".$iElemAnt;
					$x++;
					if($idElemSig!="-1")
					{
						$consulta[$x]="update 234_elementosCuestionario set idElemAnterior=".$idPregunta." where idGrupoElemento=".$idElemSig;
						$x++;
					}
				}
				else
				{
					$consulta[$x]="update 234_elementosCuestionario set idElemAnterior=".$idPregunta." where idElemAnterior=-1 and idSeccion=".$idSeccion." and idGrupoElemento<>".$idPregunta;
					$x++;
					
					
				}
				
				$consulta[$x]="update 232_variablesSistema set idPreguntaCuestSig=idPreguntaCuestSig+1,idOpcionCuestSig=idOpcionCuestSig+".$numOpcionesAgregadas;
				$x++;
				
				$consulta[$x]="commit";
				$x++;
				if($con->ejecutarBloque($consulta))
				{
					echo "1|".$idPregunta;	
				}
				
			}
			else	//modificar pregunta
			{
				
			}
		}
		else
			echo "|";
	}
	
	function eliminarElementoCuestionario()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$x=0;
		$idElemento=$_POST["idGrupoElemento"];
		$consulta[$x]="begin";
		$x++;
		$query="select concat(idElemAnterior,'|',idElemSiguiente) from 234_elementosCuestionario where idGrupoElemento=".$idElemento;
		$valores=$con->obtenerValor($query);
		$arrValores=explode("|",$valores);
		if($arrValores[0]!="-1")
		{
			$consulta[$x]="update 234_elementosCuestionario set idElemSiguiente=".$arrValores[1]." where idGrupoElemento=".$arrValores[0];
			$x++;
			$consulta[$x]="update 234_elementosCuestionario set idElemAnterior=".$arrValores[0]." where idGrupoElemento=".$arrValores[1];
			$x++;
			
		}
		else
		{
			if($arrValores[1]!="-1")
			{
				$consulta[$x]="update 234_elementosCuestionario set idElemAnterior=-1 where idGrupoElemento=".$arrValores[1];
				$x++;
			}
		}
		$consulta[$x]="delete from 234_elementosCuestionario where idGrupoElemento=".$idElemento;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerElementosArticuloElectronico()
	{
		global $mostrarXML;
		$mostrarXML=false;
		$idPadre=$_POST["idArticulo"];
		$nodos=crearCuerpoArticuloJson($idPadre);
		
		echo $nodos;
		
		
	}
	
	function crearCuerpoArticuloJson($padre)
	{
		global $con;
		$res=$con->obtenerFilas("select * from 200_elementosRevista where id_padre=".$padre);
		$arrElementos="";
		$elemento="";
		while($fila=mysql_fetch_row($res))
		{
			$attr="";
			if($fila[3]!=NULL)
				$attr=obtenerAttributos($fila[3]);
				
			$hijos=	crearCuerpoArticuloJson($fila[0]);
			$hoja="";
			if($hijos=="")
				$hoja='"leaf":"true"';
			else
				$hoja='"children":'.$hijos;
			
			$elemento='	{
							"draggable":"movible",
							"id":"'.$fila[0].'",
							"text":"'.$fila[1].' '.$attr.'",'.$hoja.'
						}
				';	
			if($arrElementos=="")
				$arrElementos=$elemento;
			else
				$arrElementos.=",".$elemento;
		}
		
		if($arrElementos!="")
			$arrElementos="[".$arrElementos."]";
		return $arrElementos;
	}
	
	function obtenerElementosArticulo()
	{
		global $mostrarXML;
		$mostrarXML=false;
		$idPadre=$_POST["idArticulo"];
		$nodos=crearCuerpoArticuloJson($idPadre);
		echo $nodos;
	}
	
	function eliminarTipoArticulo()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$idTipoArt=$_POST["idTipoArt"];
		$consulta="delete from 224_tipoDocumentos where idTipoDocComun=".$idTipoArt;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
		
	}
	
	function guardarTipoArticulo()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$cadObj=$_POST["datosP"];
		$obj=json_decode($cadObj);
		$abr=$obj->abr;
		$arrTipos=$obj->arrTipos;
		$numTipos=sizeof($arrTipos);
		$idTipo=$obj->idTipo;
		$x=0;
		
		$consulta[$x]="begin";
		$x++;
		
		if($idTipo!="-1")
		{
			$consulta[$x]="delete from 224_tipoDocumentos where idTipoDocComun=".$idTipo;
			$x++;
		}
		else
		{
			$query="select idTipoDocumentoSig from tbl_variablesSistema";
			$idTipo=$con->obtenerValor($query);
			$consulta[$x]="update tbl_variablesSistema set idTipoDocumentoSig=idTipoDocumentoSig+1";
			$x++;
		}
		
		for($ct=0;$ct<$numTipos;$ct++)
		{
			$consulta[$x]="	insert into 224_tipoDocumentos(TipoDocumento,idIdioma,idTipoDocComun,abreviatura,descripcion) 
							values('".cv($arrTipos[$ct]->etiqueta)."',".cv($arrTipos[$ct]->idIdioma).",".$idTipo.",'".cv($abr)."','".cv($arrTipos[$ct]->descripcion)."')";
			$x++;
		}
		
		$consulta[$x]="commit";
		if($con->ejecutarBloque($consulta))
			echo "1|".$idTipo;
		else
			echo "|";
		
	}
	
	function obtenerDatosTipoArticulo()
	{
		global $con;
		$idTipo=$_POST["idTipo"];
		global $mostrarXML;
		$mostrarXML=false;
		$consulta="select TipoDocumento,idIdioma,abreviatura,descripcion from 224_tipoDocumentos  where idTipoDocComun=".$idTipo;
		$arrTipo=$con->obtenerFilasJson($consulta);
		echo '1|[{"arrTipos":'.$arrTipo.'}]';
	}
	
	
	function generaPassword($length=9, $strength=0) 
	{
		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength & 1) 
		{
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) 
		{
			$vowels .= "AEUY";
		}
		if ($strength & 4) 
		{
			$consonants .= '23456789';
		}
		if ($strength & 8) 
		{
			$consonants .= '@#$%';
		}
	 
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) 
		{
			if ($alt == 1) 
			{
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} 
			else 
			{
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}
	
	
	
	function crearNuevoDocumento()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$tipoArt=$obj->tipoArt;
		$nombreDoc=$obj->nombreDoc;
		$descripcion=$obj->descripcion;
		$idSeccion=$obj->idSeccion;
		$consulta="insert into 204_proyectos(idUsuario,idTipoArticulo,nombreArticulo,descripcion,fechaCreacion,estado,idSeccion,idSeccionRevisora) 
					values (".$_SESSION["idUsr"].",".$tipoArt.",'".$nombreDoc."','".$descripcion."','".date("Y-m-d")."',0,".$idSeccion.",".$idSeccion.")";

		if(mysql_query($consulta))
		{	
			$idDoc=$con->obtenerUltimoID();
			
			$consulta="insert into 230_accionesDocumentos(accion,idDoc,idUsuarioC,fechaAccion,comentarios,idEdoAnterior,idEdoActual)
					values('1',".$idDoc.",".$_SESSION["idUsr"].",'".date('Y-m-d')."','',-1,'0')";

			if($con->ejecutarConsulta($consulta))
			{
				
				$consulta="select idAfiliacion from 207_afiliaciones af,205_autores au where af.idAutor=au.idAutor and au.idUsuario=".$_SESSION["idUsr"];
				//echo $consulta;
				$idAfiliacion=$con->obtenerValor($consulta);
				$idAgrupacion=obtenerIdElementoDeTipoArticulo("-".$tipoArt,7);
				$objGuardar='{
								  "idParticipacion":"pr",
								  "idAfiliacion":"'.$idAfiliacion.'",
								  "idAgrupacion":"'.$idAgrupacion.'",
								  "idElemR":"7",
								  "partC":"Principal",
								  "cvePartC":"pr",
								  "autorC":"true",
								  "idDoc":'.$idDoc.'
							  }';
				//echo $objGuardar;			  
				guardarDatosAutorArticulo($objGuardar);
				
				
				echo "|".$idDoc;
			
			}
			else
				echo "|";
			
		}
		else
			echo "|";
	}
	
	function eliminarArchivoAutor()
	{
		global $con;
		global $mostrarXML;
		$mostrarXML=false;
		$idArchivo=base64_decode($_POST["idArchivo"]);
		$consulta="delete from 210_archivosProyectos where idDocumento=".$idArchivo;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	

?>

