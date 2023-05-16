<?php session_start();
	$mostrarXML=true;
	include("conexionBD.php"); 
	include("configurarIdioma.php");
	if($incluirCabeceraISO)
		header('Content-Type: text/html; charset=iso-8859-1');
		
	if(isset($_POST["funcion"]))
			$funcion=$_POST["funcion"];	
		
	if(isset($_SESSION["leng"]))
	{
		if(isset($_POST["parametros"]))
			$parametros=$_POST["parametros"];
		
		$lenguaje=$_SESSION["leng"];
		
		switch($funcion)
		{
			case 0:
				echo "1|";
				return;
			break;
			case 1:
				guardarMensajesAlerta();
			break;
			case 2:
				obtenerMensajesAlerta();
			break;
			case 3:
				eliminarMensajeAlerta();
			break;
			case 4:
				eliminarRol();
			break;
			case 5:
				guardarMensajesProceso();
			break;
			case 38:
				obtenerNumElementosMenu();
			break;
			case 39:
				guardarContenidos();
			break;
			case 40:
				obtenerContenidos();
			break;
			case 41:
				guardarFuncionesSistema();
			break;
			case 42:
				eliminarOpcionSistema();
			break;
			case 43:
				obtenerOpciones();
			break;
			case 44:
				modificarFuncionesSistema();
			break;
			case 45:
				guardarMenuSistema();
			break;
			case 46:
				eliminarMenuSistema();
			break;
			case 47;
				obtenerMenuSistema();
			break;
			case 48:
				modificarMenuSistema();
			break;
			case 49:
				obtenerSoloMenus();
			break;
			case 50:
				obtenerOpcionesDisponibles();
			break;
			case 51:
				agregarOpciones();
			break;
			case 52:
				eliminarOpcionMenu();
			break;
			case 53:
				obtenerOpcionesPagina();
			break;
			case 54:
				obtenerOpcionesPaginaDisponible();
			break;
			case 55:
				asociarOpcinesPaginas();
			break;
			case 56:
				quitarAsociacionPagina();
			break;
			case 70:
				obtenerPaginasOpciones();
			break;
			case 71:
				asignarMenuPagina();
			break;
			case 72:
				cambiarIdioma();
			break;
			case 73:
				obtenerProcesos();
			break;
			case 74:
				obtenerCategoriasDocumentos();
			break;
			case 75:
				modificarCategoriaDocumento();
			break;
			case 76:
				removerCategoriaDocumento();
			break;
			case 77:
				obtenerDocumentosCategoria();
			break;
			case 78:
				guardarDocumentoCategoria();
			break;
			case 79:
				removerDocumentosGaleria();
			break;
			case 80:
				obtenerComentariosDudas();
			break;
			case 81:
				removerComentario();
			break;
			case 82:
				guardarRespuestaComentario();
			break;
			case 83:
				generarTableroControl();
			break;
			case 84:
				enviarContacto();
			break;
			case 85:
				registrarBitacoraNotificaciones();
			break;
			case 86:
				cambiarAdscripcionUsuario();
			break;
			case 87:
				cambiarIdentidadUsuario();
			break;
			case 88:
				restaurarIdentidadUsuario();
			break;
			case 89:
				obtenerLiberiasFuncionesExternas();
			break;
			
		}
	}
	else
	{
		if($funcion==0)
		{
			echo "1|";
			return;
		}
	}
	
	
	function guardarMensajesAlerta()
	{
		global $con;
		$parametro=str_replace('\\\\','\\',$_POST["param"]);
		$objJson=json_decode($parametro);
		$idCircular=$objJson->idCircular;
		$circulares=$objJson->circulares;
		//$permisos=$objJson->permisos;
		//$arrPermisos=explode(",",$permisos);
		
		$ct=sizeof($circulares);
		$obj;
		$consultaIdPlantilla="select idMensajeSiguiente from 2000_variablesSistema";
		$idPlantilla=$con->obtenerValor($consultaIdPlantilla);
		$p=0;
		$consulta[$p]="begin";
		$p++;
		if($idCircular!="")
		{
			$consulta[$p]="delete from 2004_mensajesAcciones where idPlantillaG=".$idCircular;
			$p++;
		}
		for($x=0;$x<$ct;$x++)
		{
			$obj=$circulares[$x];
			$consulta[$p]="insert into 2004_mensajesAcciones(asunto,cuerpo,idIdioma,idPlantillaG,descripcion,idUsuario,idAccionEnvio) values('".cv($obj->asunto)."','".cv($obj->cuerpo)."',".cv($obj->idIdioma).",".$idPlantilla.",'".cv($obj->desc)."',".$_SESSION["idUsr"].",".$obj->accionE.")";
			$p++;

		}
		/*$ct=sizeof($arrPermisos);
		for($x=0;$x<$ct;$x++)
		{
			$consulta[$p]="insert into 229_circularesVSRoles(idCircular,idRol) values(".$idPlantilla.",".$arrPermisos[$x].")";
			$p++;
		}*/
		$consulta[$p]="update 2000_variablesSistema set idMensajeSiguiente=idMensajeSiguiente+1";
		$p++;
		$consulta[$p]="commit";
		if($con->ejecutarBloque($consulta))
			echo "1|".$idPlantilla;
		else
			echo "-1|";		
	}
	
	function obtenerMensajesAlerta()
	{
		global $con;
		global $SO;
		$idCircular=$_POST["idCircular"];
		if(!isset($_POST["idProceso"]))
			$plantillas=$con->obtenerFilasJson("select asunto,cuerpo,idIdioma,descripcion from 2004_mensajesAcciones where idPlantillaG=".$idCircular);
		else
			$plantillas=$con->obtenerFilasJson("select asunto,cuerpo,idIdioma,descripcion,remitente from 9020_mensajesAccionProceso where idGrupoMensaje=".$idCircular);
		$permisos="[]";
		if($SO==1)
			$obj='[{"permisos":"'.$permisos.'",plantillas:'.utf8_encode($plantillas).'}]';
		else
			$obj='[{"permisos":"'.$permisos.'",plantillas:'.utf8_encode($plantillas).'}]';
		echo $obj;
	}	
		
	function eliminarMensajeAlerta()
	{
		global $mostrarXML;
		global $con;
		$mostrarXML=false;
		$idCircular=$_POST["idCircular"];
		$consulta="delete from 2004_mensajesAcciones where idPlantillaG=".$idCircular;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "-1|";
	}	
		
	function guardarFuncionesSistema()
	{
		global $mostrarXML;
		global $baseDir;
		$mostrarXML=false;
		global $con;
		$parametro=$_POST["param"];
		
		$parametro=str_replace("\\","",$parametro);
		$objJson=json_decode($parametro);
		
		$arrObj=$objJson->arreglo;
		
		$padreMenu=false;
		if(strpos($objJson->idPadre,"m_")!==false)
		{
			$padreMenu=true;
		}
		
		$idPadre=str_replace("m_","",$objJson->idPadre);
		
		$posicion=$objJson->posicion;
		$bullet="'NULL'";
		$nombreBullet="'NULL'";
		$tamano="NULL";
		$archivo="";
		if((isset($objJson->archivo))&&($objJson->archivo!=""))
		{
			$binario_contenido='';
			$nombreBullet=$objJson->archivo;
			$archivo=$baseDir."/archivosTemporales/".$nombreBullet;
			$bullet = "'".addslashes(fread(fopen($archivo, "rb"), filesize($archivo)))."'";
			$tamano=filesize($archivo);
			$nombreBullet="'".$nombreBullet."'";

		}
		
		$x=0;
		$query[$x]="begin";
		$x++;		
		
		$consulta="select idOpcionPlantillaSig,idGrupoContenidoSig from 4127_variablesSistema for update";
		$filaP=$con->obtenerPrimeraFila($consulta);
		$idOpcion=$filaP[0];
		$idContenido=$filaP[1];
		if($arrObj[0]->tipoOpcion=="1")
		{
			$pDestino=$arrObj[0]->pEnlace."?id=".$idContenido;
			$consulta="select idIdioma from 8002_idiomas";
			$resI=$con->obtenerFilas($consulta);
			while($filasI=mysql_fetch_row($resI))
			{
				$query[$x]="insert into 816_contenidos(idIdioma,idGrupoContenido) values(".$filasI[0].",".$idContenido.")";
				$x++;
				
			}
		}
		else
			$idContenido="-1";
		
		foreach($arrObj as $fila)
		{
			switch($fila->tipoOpcion)
			{
				case "0":
				case "2":
				case "3":
				case "4":
				case "5":
				case "9":
				case "10":
				case "11":
					$pDestino=$fila->pEnlace;
				break;
				
			}
			$idFuncionVisualiza="-1";
			if(isset($objJson->idFuncionVisualiza))
				$idFuncionVisualiza=$objJson->idFuncionVisualiza;
				
			$idFuncionRenderer="-1";
			if(isset($objJson->idFuncionRenderer))
				$idFuncionRenderer=$objJson->idFuncionRenderer;
			
			$clase="";
			if(isset($objJson->estilo))
				$clase=$objJson->estilo;
				
			$idDocumento="-1";	
			if(isset($objJson->idDocumento))
				$idDocumento=$objJson->idDocumento;	
			
			$idPadreMenu="NULL";
			if(!$padreMenu)
				$idPadreMenu=$idPadre;
				
			$query[$x]= "insert into 809_opciones(textoOpcion,paginaUrlDestino,descripcion,idIdioma,idOpcion,tipoEnlace,idContenido,bullet,nombreBullet,tamano,idDocumento,idFuncionVisualizacion,idFuncionRenderer,clase,idPadre,orden) values
						('".($fila->etiqueta)."','".cv($pDestino)."','".($fila->descripcion)."',".$fila->idIdioma.",".$idOpcion.",".$fila->tipoOpcion.",".$idContenido.",".$bullet.",".$nombreBullet.",".$tamano.",".$idDocumento.",".
						$idFuncionVisualiza.",".$idFuncionRenderer.",'".$clase."',".$idPadreMenu.",".((!$padreMenu)?$posicion:"NULL").")";
			$x++;
			
		}
		
		if($padreMenu)
		{
			$query[$x]="update 811_menusVSOpciones set orden=orden+1 where idMenu=".$idPadre." and orden>=".$posicion;
			$x++;
			
			$query[$x]="insert into 811_menusVSOpciones(idMenu,idOpcion,orden) values(".$idPadre.",".$idOpcion.",".$posicion.")";
			$x++;
			
			
			
		}
		if($fila->tipoOpcion=="0")
			$query[$x]="update 4127_variablesSistema set idOpcionPlantillaSig=idOpcionPlantillaSig+1";
		else
			$query[$x]="update 4127_variablesSistema set idOpcionPlantillaSig=idOpcionPlantillaSig+1,idGrupoContenidoSig=idGrupoContenidoSig+1";
		$x++;
		$query[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($query))
		{
			if($archivo!="")
				unlink($archivo);
			echo "1|".$idOpcion;
		}
	}	
		
	function obtenerOpciones()
	{
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		$idOpcion=$_POST["id"];
		$consulta="select textoOpcion,paginaUrlDestino,descripcion,idIdioma,idFuncionVisualizacion,idFuncionRenderer,clase 
					from 809_opciones where idOpcion=".$idOpcion;
		$res=$con->obtenerFilas($consulta);
		$obj="";
		$arrObj="";
		
		$idFuncionVisualiza="-1";
		$idFuncionRenderer=-1;
		$prioridad=1;
		$clase="";
		
		while($fila=mysql_fetch_row($res))
		{
			$idFuncionVisualiza=$fila[4];
			if($idFuncionVisualiza=="")
				$idFuncionVisualiza=-1;
			$idFuncionRenderer=$fila[5];
			if($idFuncionRenderer=="")
				$idFuncionRenderer=-1;
			
			$clase=$fila[6];
			
			$obj='{"idIdioma":"'.$fila[3].'","etiqueta":"'.cvJs($fila[0]).'","pEnlace":"'.$fila[1].'","descripcion":"'.cvJs($fila[2]).'"}';
			if($arrObj=='')
				$arrObj=$obj;
			else
				$arrObj.=','.$obj;
		}
		
		$consulta="select idRol from 812_permisosOpcionesMenus where tipo=0 and idOpcion=".$idOpcion;
		$res=$con->obtenerFilas($consulta);
		$permisos="";
		while($fila=mysql_fetch_row($res))
		{
			if($permisos=="")
				$permisos=$fila[0];
			else
				$permisos.="|".$fila[0];
		}
		$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$idFuncionVisualiza;
		$nFuncionVisualiza=$con->obtenerValor($consulta);
		$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$idFuncionRenderer;
		$nFuncionRenderer=$con->obtenerValor($consulta);
		$consulta="select idMenu,orden from 811_menusVSOpciones where idOpcion=".$idOpcion;
		$fila=$con->obtenerPrimeraFila($consulta);
		$numOpcion=0;
		if($fila)
		{
			$consulta="select count(idMenu) from 811_menusVSOpciones where idMenu=".$fila[0];
			$numOpcion=$con->obtenerValor($consulta);
		}
		echo '[{"permisos":"'.$permisos.'","opciones":['.uEJ($arrObj).'],"numOpciones":"'.$numOpcion.'","numOpcion":"'.$fila[1].'","idFuncionVisualizacion":"'.$idFuncionVisualiza.'","idFuncionRenderer":"'.$idFuncionRenderer.
				'","nFuncionVisualizacion":"'.$nFuncionVisualiza.'","nFuncionRenderer":"'.$nFuncionRenderer.'","clase":"'.$clase.'"}]';
	}
	
	function obtenerSoloMenus()
	{
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		$idOpcion=str_replace("m_","",$_POST["id"]);
		$consulta="select textoMenu,descripcion,idIdioma,colorFondo,idProceso,idFuncionVisualiza,idFuncionRenderer,prioridad,clase from 808_titulosMenu where idMenu=".$idOpcion;
		$res=$con->obtenerFilas($consulta);
		$obj="";
		$arrObj="";
		$colorFondo="";
		$idProceso=-1;
		$idFuncionVisualiza="-1";
		$idFuncionRenderer=-1;
		$prioridad=1;
		$clase="";
		while($fila=mysql_fetch_row($res))
		{
			$idProceso=$fila[4];
			$idFuncionVisualiza=$fila[5];
			if($idFuncionVisualiza=="")
				$idFuncionVisualiza=-1;
			$idFuncionRenderer=$fila[6];
			if($idFuncionRenderer=="")
				$idFuncionRenderer=-1;
			$prioridad=$fila[7];
			if($prioridad=="")
				$prioridad=1;
			$clase=$fila[8];
			$colorFondo=$fila[3];
			$obj='{"idIdioma":"'.$fila[2].'","etiqueta":"'.cvJs($fila[0]).'","descripcion":"'.cvJs($fila[1]).'"}';
			if($arrObj=='')
				$arrObj=$obj;
			else
				$arrObj.=','.$obj;
		}

		$consulta="select idRol from 812_permisosOpcionesMenus where idOpcion=".$idOpcion;
		$res=$con->obtenerFilas($consulta);
		$permisos="";
		while($fila=mysql_fetch_row($res))
		{
			$cadObj="";
			if($idProceso==-1)
			{
				$arrRoles=explode('_',$fila[0]);
				
				$consulta=" select concat((select nombreGrupo from 8001_roles where idIdioma=".$_SESSION["leng"]." and idRol=".$arrRoles[0]." ),
																		(if( ".$arrRoles[1]."=0,'',concat(' (',
																		(select unidadRol from 4084_unidadesRoles where idUnidadesRoles=".$arrRoles[1]."),')')))) as rol"; 
				
				$descRol=$con->obtenerValor($consulta);														
				$cadObj="['".$fila[0]."','".$descRol."']";
			}
			else
			{
				$arrRoles=explode('|',$fila[0]);

				$actor=$arrRoles[0];
				switch($arrRoles[1])
				{
					case "1":
						$arrRol=explode("_",$actor);
						$consulta="select nombreGrupo from 8001_roles where idRol=".$arrRol[0];
						$rol1=$con->obtenerValor($consulta);
						if($rol1!="")
						{
							$rol2="";
							if($arrRol[1]!="0")
							{
								$consulta="select unidadRol from 4084_unidadesRoles where idUnidadesRoles=".$arrRol[1];
								$rol2=" (".$con->obtenerValor($consulta).")";
							}
							
							$actor=$rol1.$rol2;
						}
						else
							continue;
						
						
					break;
					case "2":
						$consulta="SELECT c.nombreComite as nombre FROM 2006_comites c WHERE c.idComite=".$actor;	
						$actor=$con->obtenerValor($consulta);
					
					break;
				}
				$cadObj="['".$fila[0]."','".$actor."','".$arrRoles[1]."']";
			}
			if($permisos=='')
				$permisos=$cadObj;
			else
				$permisos.=",".$cadObj;
		}
		
		$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$idFuncionVisualiza;
		$nFuncionVisualiza=$con->obtenerValor($consulta);
		$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$idFuncionRenderer;
		$nFuncionRenderer=$con->obtenerValor($consulta);
		echo '[{"permisos":['.uEJ($permisos).'],"opciones":['.uEJ($arrObj).'],"colorFondo":"'.$colorFondo.'","idFuncionVisualizacion":"'.$idFuncionVisualiza.'","idFuncionRenderer":"'.$idFuncionRenderer.
				'","nFuncionVisualizacion":"'.$nFuncionVisualiza.'","nFuncionRenderer":"'.$nFuncionRenderer.'","prioridad":"'.$prioridad.'","clase":"'.$clase.'"}]';
	}
	
	function modificarFuncionesSistema()
	{
		
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		global $baseDir;
		$parametro=$_POST["param"];
		$parametro=str_replace("\\","",$parametro);
		$objJson=json_decode($parametro);
		$bullet="'NULL'";
		$nombreBullet="'NULL'";
		$tamano="NULL";
		$archivo="";
		if($objJson->archivo!="")
		{
			$binario_contenido='';
			$nombreBullet=$objJson->archivo;
			$archivo=$baseDir."/archivosTemporales/".$nombreBullet;
			$bullet = "'".addslashes(fread(fopen($archivo, "rb"), filesize($archivo)))."'";
			$tamano=filesize($archivo);
			$nombreBullet="'".$nombreBullet."'";

		}
		
		$arrObj=$objJson->arreglo;
		$posicion=$objJson->posicion;
		$idOpcion=$objJson->idOpcion;
		
		
		$esOpcionNormal=true;
		$query="SELECT idPadre,orden FROM 809_opciones WHERE idOpcion=".$idOpcion;
		$fDatosOpcion=$con->obtenerPrimeraFila($query);
		$ordenOriginal="";
		$idMenu="";
		if($fDatosOpcion[0]!="")
		{
			$ordenOriginal=$fDatosOpcion[1];
			$idMenu=$fDatosOpcion[0];
			$esOpcionNormal=false;
		}
		else
		{
			$query="select orden,idMenu from 811_menusVSOpciones where idOpcion=".$idOpcion;
			$fResp=$con->obtenerPrimeraFila($query);
			$ordenOriginal=$fResp[0];
			$idMenu=$fResp[1];
		}
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$idFuncionVisualizacion=-1;
		if(isset($objJson->idFuncionVisualizacion))	
			$idFuncionVisualizacion=$objJson->idFuncionVisualizacion;
		if(isset($objJson->idFuncionVisualiza))	
			$idFuncionVisualizacion=$objJson->idFuncionVisualiza;
		$idFuncionRenderer="-1";
			if(isset($objJson->idFuncionRenderer))
				$idFuncionRenderer=$objJson->idFuncionRenderer;
			
		$clase="";
		if(isset($objJson->estilo))
			$clase=$objJson->estilo;	
				
		foreach($arrObj as $fila  )
		{
			if($objJson->archivo!="")
			{
				$consulta[$x]= "update 809_opciones set textoOpcion='".cv($fila->etiqueta)."',paginaUrlDestino='".cv($fila->pEnlace)."',descripcion='".cv($fila->descripcion)."',
							bullet=".$bullet.",nombreBullet=".$nombreBullet.",tamano=".$tamano.",idFuncionVisualizacion=".$idFuncionVisualizacion.",idFuncionRenderer=".$idFuncionRenderer.",clase='".$clase."' where idIdioma=".$fila->idIdioma." and idOpcion=".$idOpcion;
			}
			else
			{
				$consulta[$x]= "update 809_opciones set textoOpcion='".cv($fila->etiqueta)."',paginaUrlDestino='".cv($fila->pEnlace)."',descripcion='".cv($fila->descripcion)."',idFuncionVisualizacion=".$idFuncionVisualizacion.",
							idFuncionRenderer=".$idFuncionRenderer.",clase='".$clase."' where idIdioma=".$fila->idIdioma." and idOpcion=".$idOpcion;
			}
			
			$x++;
			
			
			if($posicion!=$ordenOriginal)
			{
				if($esOpcionNormal)
				{
					if($ordenOriginal>$posicion)
						$consulta[$x]="update 811_menusVSOpciones set orden=orden+1 where orden>=".$posicion." and idMenu=".$idMenu;
					else
						$consulta[$x]="update 811_menusVSOpciones set orden=orden-1 where orden<=".$posicion." and idMenu=".$idMenu;
					
					$x++;
						
					$consulta[$x]="update 811_menusVSOpciones set orden=".$posicion." where idOpcion=".$idOpcion;
					$x++;
					
				}
				else
				{
					if($ordenOriginal>$posicion)
						$consulta[$x]="update 809_opciones set orden=orden+1 where orden>=".$posicion." and idPadre=".$idMenu;
					else
						$consulta[$x]="update 809_opciones set orden=orden-1 where orden<=".$posicion." and idPadre=".$idMenu;
						
					$x++;
					
					$consulta[$x]="update 809_opciones set orden=".$posicion." where idOpcion=".$idOpcion;
					$x++;
					
				}
				
			}
		}
			
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			echo "1|".$idOpcion;
		}
	}	
	
	function guardarMenuSistema()
	{
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		$parametro=$_POST["param"];
		$parametro=str_replace("\\","",$parametro);
		$objJson=json_decode($parametro);
		$arrObj=$objJson->arreglo;
		$permisosGrupo=$objJson->permisosGrupos;
		$consulta="begin";
		$idProceso=-1;
		if(isset($objJson->idProceso))
			$idProceso=$objJson->idProceso;
			
		$idFuncionVisualiza=-1;
		if(isset($objJson->idFuncionVisualiza))
			$idFuncionVisualiza=$objJson->idFuncionVisualiza;
		$idFuncionRenderer=-1;
		if(isset($objJson->idFuncionRenderer))
			$idFuncionRenderer=$objJson->idFuncionRenderer;
			
		$prioridad=1;
		if(isset($objJson->prioridad))
			$prioridad=$objJson->prioridad;
			
		$clase="";	
		if(isset($objJson->estilo))
			$clase=$objJson->estilo;
			
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="select idOpcionMenuSig from 4127_variablesSistema for update";
			$idOpcion=$con->obtenerValor($consulta);
			foreach($arrObj as $fila  )
			{
				$consulta= "insert into 808_titulosMenu(textoMenu,descripcion,idIdioma,idMenu,colorFondo,idProceso,idFuncionVisualiza,idFuncionRenderer,prioridad,clase) values
							('".cv($fila->etiqueta)."','".cv($fila->descripcion)."',".$fila->idIdioma.",".$idOpcion.",'".$objJson->colorFondo."',".$idProceso.",".$idFuncionVisualiza.",".$idFuncionRenderer.
							",".$prioridad.",'".$clase."')";
				if(!$con->ejecutarConsulta($consulta))
				{
					echo "|";
					return;
				}
			}
			$consulta="update 4127_variablesSistema set idOpcionMenuSig=idOpcionMenuSig+1";
			if($con->ejecutarConsulta($consulta))
			{
				if($permisosGrupo!="")
				{
					$arrPGrupos=explode(",",$permisosGrupo);
					$nGrupos=sizeof($arrPGrupos);
					for($z=0;$z<$nGrupos;$z++)
					{
						$consulta="insert into 812_permisosOpcionesMenus(idOpcion,idRol,tipo) values(".$idOpcion.",'".$arrPGrupos[$z]."',1)";
						if(!$con->ejecutarConsulta($consulta))
						{
							echo "|";
							return;
						}
					}
				}
				$consulta="commit";
				if(!$con->ejecutarConsulta($consulta))
					echo "|";
				else
					echo "1|".$idOpcion;
			}
			else
				echo "|";
		}
		else
			echo "|";
	}
		
	function eliminarMenuSistema()
	{
		global $con;
		$idOpcion=$_POST["param"];
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="delete from 808_titulosMenu where idMenu=".$idOpcion;
			if($con->ejecutarConsulta($consulta))
			{
				$consulta="delete from 813_paginasVSOpciones where tipo=1 and idOpcion=".$idOpcion;
				if($con->ejecutarConsulta($consulta))
				{
					$consulta="delete from 811_menusVSOpciones where idMenu=".$idOpcion;
					if($con->ejecutarConsulta($consulta))
					{
						$consulta="commit";
						if($con->ejecutarConsulta($consulta))
							echo "1";
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
			echo "|";
		
	}
	
	function obtenerMenuSistema()
	{
		global $con;
		$idMenu=$_POST["id"];
		$objJson='';
		$consulta="select textoMenu,descripcion from 808_titulosMenu where idMenu=".$idMenu." and idIdioma=".$_SESSION["leng"];
		$resMenu=$con->obtenerFilas($consulta);
		$raiz='';
		if($filaMenu=mysql_fetch_row($resMenu))
		{
			$raiz='<b><font color=blue>'.$filaMenu[0].'</font></b>';
			if($filaMenu[1]!="")
				$raiz.=" ('".$filaMenu[1]."')";
			$raiz.=" Permisos:[".obtenerPermisosOpcionMenu($idMenu,"1")."]";
		}
		$consulta="select pO.idOpcion,pO.textoOpcion from 811_menusVSOpciones mO,809_opciones pO where pO.idOpcion=mO.idOpcion and pO.idIdioma=".$_SESSION["leng"]." and mO.idMenu=".$idMenu;
		$resOpcion=$con->obtenerFilas($consulta);
		$objMenu='';
		$arrObjMenu='';
		$idMenuVsOpcion='';
		$textoMenuVsOpcion='';
		while($filaOpcion=mysql_fetch_row($resOpcion))
		{
			$idMenuVsOpcion=$filaOpcion[0];
			$textoMenuVsOpcion='<b>'.$filaOpcion[1].'</b>';
			$textoMenuVsOpcion.=" [".obtenerPermisosOpcionMenu($filaOpcion[0],"0")."]";
			
			$objMenu='{"idOpcion":"'.$idMenuVsOpcion.'","texto":"'.$textoMenuVsOpcion.'"}';
			if($arrObjMenu=='')
				$arrObjMenu=$objMenu;
			else
				$arrObjMenu.=",".$objMenu;
		
		}
		echo '[{"raiz":"'.$raiz.'","opciones":['.$arrObjMenu.']}]';
	}
	
	function modificarMenuSistema()
	{
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		$parametro=$_POST["param"];
		$parametro=str_replace("\\","",$parametro);
		$objJson=json_decode($parametro);
		$arrObj=$objJson->arreglo;
		$permisosGrupo=$objJson->permisosGrupos;
		$consulta="begin";
		
		$idFuncionVisualiza=-1;
		if(isset($objJson->idFuncionVisualiza))
			$idFuncionVisualiza=$objJson->idFuncionVisualiza;
		$idFuncionRenderer=-1;
		if(isset($objJson->idFuncionRenderer))
			$idFuncionRenderer=$objJson->idFuncionRenderer;
			
		$prioridad=1;
		if(isset($objJson->prioridad))
			$prioridad=$objJson->prioridad;
			
		$clase="";	
		if(isset($objJson->estilo))
			$clase=$objJson->estilo;	
			
		if($con->ejecutarConsulta($consulta))
		{
			$idOpcion=str_replace("m_","",$objJson->idOpcion);
			foreach($arrObj as $fila  )
			{
				$consulta= "update 808_titulosMenu set textoMenu='".$fila->etiqueta."',descripcion='".$fila->descripcion."',colorFondo='".$objJson->colorFondo."',idFuncionVisualiza=".$idFuncionVisualiza.",
							idFuncionRenderer=".$idFuncionRenderer.",prioridad=".$prioridad.",clase='".$clase."' where idIdioma=".$fila->idIdioma." and idMenu=".$idOpcion;
				if(!$con->ejecutarConsulta($consulta))
				{
					echo "|";
					return;
				}
			}
			
			$consulta="delete from 812_permisosOpcionesMenus where  idOpcion=".$idOpcion;
			if($con->ejecutarConsulta($consulta))
			{
				if($permisosGrupo!="")
				{
					$arrPGrupos=explode(",",$permisosGrupo);
					$nGrupos=sizeof($arrPGrupos);
					for($z=0;$z<$nGrupos;$z++)
					{
						$consulta="insert into 812_permisosOpcionesMenus(idOpcion,idRol,tipo) values(".$idOpcion.",'".$arrPGrupos[$z]."',1)";
						if(!$con->ejecutarConsulta($consulta))
						{
							echo "|";
							return;
						}
					}
				}
				
				$consulta="commit";
				if(!$con->ejecutarConsulta($consulta))
				{
					echo "|";
					return;
				}
				else
					echo "1|".$idOpcion;
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
	
	function obtenerPermisosOpcionMenu($idOpcion,$tipo)
	{
		global $con;
		//$consulta="select g.NombreGrupo from 812_permisosOpcionesMenus pM,8001_roles g where g.idRol=pM.idRol and pM.idOpcion=".$idOpcion." and pM.tipo=".$tipo." and g.idIdioma=".$_SESSION["leng"];
		
		$consulta="SELECT idProceso FROM 808_titulosMenu WHERE idMenu=".$idOpcion;
		$idProceso=$con->obtenerValor($consulta);
		$consulta="select idRol from 812_permisosOpcionesMenus where idOpcion=".$idOpcion;
		$resPermisos=$con->obtenerFilas($consulta);
		$permisos='';
		$descRol="";
		while($filaPermisos=mysql_fetch_row($resPermisos))
		{
			if($idProceso==-1)
			{
				$arrRoles=explode('_',$filaPermisos[0]);
				$consulta=" select concat((select nombreGrupo from 8001_roles where idIdioma=".$_SESSION["leng"]." and idRol=".$arrRoles[0]." ),
																		(if( ".$arrRoles[1]."=0,'',concat(' (',
																		(select unidadRol from 4084_unidadesRoles where idUnidadesRoles=".$arrRoles[1]."),')')))) as rol"; 
				$descRol=$con->obtenerValor($consulta);					
			}
			else
			{
				$arrRoles=explode('|',$filaPermisos[0]);
				$actor=$arrRoles[0];
				switch($arrRoles[1])
				{
					case "1":
						$arrRol=explode("_",$actor);
						$consulta="select nombreGrupo from 8001_roles where idRol=".$arrRol[0];
						$rol1=$con->obtenerValor($consulta);
						if($rol1!="")
						{
							$rol2="";
							if($arrRol[1]!="0")
							{
								$consulta="select unidadRol from 4084_unidadesRoles where idUnidadesRoles=".$arrRol[1];
								$rol2=" (".$con->obtenerValor($consulta).")";
							}
							
							$descRol=$rol1.$rol2;
						}
						else
							continue;
						
						
					break;
					case "2":
						$consulta="SELECT c.nombreComite as nombre FROM 2006_comites c WHERE c.idComite=".$actor;	
						$descRol=$con->obtenerValor($consulta);
					
					break;
				}
			}
			if($permisos=='')
				$permisos=$descRol;
			else
				$permisos.=", ".$descRol;
			
		}
		return $permisos;
	}
	
	function agregarOpciones()
	{
		global $con;
		$idOpciones=$_POST["idOpciones"];
		$idMenu=$_POST["idMenu"];
		$opciones=explode(',',$idOpciones);
		$ct=sizeof($opciones);
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			for($x=0;$x<$ct;$x++)
			{
				$consulta="insert into 811_menusVSOpciones (idMenu,idOpcion) values(".$idMenu.",".$opciones[$x].")";
				if(!$con->ejecutarConsulta($consulta))
				{
					echo "|";
					return;
				}
			}
			$consulta="commit";
			if($con->ejecutarConsulta($consulta))
			{
				echo "1|";
			}
			else
				echo "|";
		}
		else
			echo "|";
	}
	
	function eliminarOpcionMenu()
	{
		global $con;
		$idMenu=$_POST["idMenu"] ;
		$idOpcion=$_POST["idOpcion"];
		$consulta="delete from 811_menusVSOpciones where idMenu=".$idMenu." and idOpcion=".$idOpcion;
		if($con->ejecutarConsulta($consulta))
		{
			echo "1";
		}
		else
			echo "|";
		
	}
	
	function obtenerOpcionesPagina()
	{
		global $mostrarXML;
		$mostrarXML=false;
		global $con;
		$idProceso="-1";
		if(isset($_POST["idProceso"]))
			$idProceso=$_POST["idProceso"];
		$consulta="select tm.idMenu,tm.textoMenu,tm.descripcion from 808_titulosMenu tm where  tm.idIdioma=".$_SESSION["leng"]." and idProceso=".$idProceso." and situacion=1 order by textoMenu";
		$resOpciones=$con->obtenerFilas($consulta);
		$objOpcion='';
		$arrOpcion='';
		$etiqueta='';
		$arrOpcionesMenu="";
		$opcionesMenu="";
		$permisos="";
		while($filaOpciones=mysql_fetch_row($resOpciones))
		{
			$etiqueta=$filaOpciones[1];			
			
			$procesoMenu="";
			$paginaMenu="";
			$macroMenu="";
			$consulta="SELECT idPagina,posicion FROM 813_paginasVSOpciones WHERE idOpcion=".$filaOpciones[0];
			$resVinculaciones=$con->obtenerFilas($consulta);
			while($filaVinculaciones=mysql_fetch_row($resVinculaciones))
			{
				switch($filaVinculaciones[1])
				{
					case 1:
					case 2:
					case 3:
						$consulta="SELECT pagina FROM 810_paginas WHERE idPagina=".$filaVinculaciones[0];
						if($paginaMenu=="")
							$paginaMenu=$con->obtenerValor($consulta);
						else
							$paginaMenu.=",".$con->obtenerValor($consulta);
					break;
					case 4:
						$consulta="SELECT macroProceso FROM 810_macroProcesos WHERE idMacroProceso=".($filaVinculaciones[0]*-1);
						if($macroMenu=="")
							$macroMenu=$con->obtenerValor($consulta);
						else
							$macroMenu.=",".$con->obtenerValor($consulta);
					break;
				}
			}
			
			
			$permisos=" [Roles: <i>".obtenerPermisosOpcionMenu($filaOpciones[0],"1")."</i>]";
			
			$consulta="select pO.idOpcion,pO.textoOpcion,pO.descripcion,pO.paginaUrlDestino,pO.tipoEnlace,if(pO.idContenido is null,'-1',pO.idContenido) as idCont  from 811_menusVSOpciones mO, 
						809_opciones pO where pO.idOpcion=mO.idOpcion and
						 pO.idIdioma=".$_SESSION["leng"]." and mO.idMenu=".$filaOpciones[0]." order by mO.orden";
			$resOpcMenu=$con->obtenerFilas($consulta);
			$arrOpcionesMenu="null";
			$opcionesMenu="";
			
			while($filaOpcMenu=mysql_fetch_row($resOpcMenu))
			{
				$proceso="";
				switch($filaOpcMenu[4])
				{
					case 2:
						$arrDatos=explode("idFormulario=",$filaOpcMenu[3]);
						$consulta="SELECT nombreFormulario,p.nombre FROM 900_formularios f,4001_procesos p WHERE idFormulario=".$arrDatos[1]." AND p.idProceso=f.idProceso";
						$fFormulario=$con->obtenerPrimeraFila($consulta);
						$proceso=$fFormulario[1]." <br>(Formulario: ".$fFormulario[0].")";
					break;
					case 10:
						$arrDatos=explode("('",$filaOpcMenu[3]);
						
						$arrDatos=explode("')",$arrDatos[1]);
						
						$consulta="SELECT nombreFormulario,p.nombre FROM 900_formularios f,4001_procesos p WHERE p.idProceso=".bD($arrDatos[0])." and f.formularioBase=1 AND p.idProceso=f.idProceso";
						$fFormulario=$con->obtenerPrimeraFila($consulta);
						$proceso=$fFormulario[1]." <br>(Formulario: ".$fFormulario[0].")";
					break;
				}
				$pagina=$paginaMenu;
				$macro=$macroMenu;
				$etiquetaOpt=$filaOpcMenu[1];
				$permisosOpt="";
				$textoOpcion=cvJs($etiquetaOpt);
				
				$arrOpcionesHijas=obtenerOpcionesMenuHijas($filaOpcMenu[0]);
				
				$compNodo='"leaf":true';
				if($arrOpcionesHijas!="[]")
				{
					$compNodo='"leaf":false,"children":'.$arrOpcionesHijas;
				}
				
				$opcionesMenu='{"cls":"cssNodoArbolNivel2","id":"'.$filaOpcMenu[0].'","text":"'.$textoOpcion.'","descripcion":"'.cvJs($filaOpcMenu[2]).
							'","URL":"'.$filaOpcMenu[3].'","tipoEnlace":"'.$filaOpcMenu[4].'","idContenido":"'.$filaOpcMenu[5].'",'.$compNodo.',"tipoOpcion":"1","icon":"../images/s.gif","procesoPertenece":"'.$proceso.'","paginasVinculadas":"'.$pagina.'","macroprocesosVinculados":"'.$macro.'"}';
				if($arrOpcionesMenu=="null")
					$arrOpcionesMenu=$opcionesMenu;
				else
					$arrOpcionesMenu.=",".$opcionesMenu;
			}					
			if(	$arrOpcionesMenu!="null")				
			{
				$arrOpcionesMenu="[".$arrOpcionesMenu."]";
				$hoja="";
			}
			else
			{
				$hoja=',"leaf":true';
			}
			$objOpcion='{"cls":"cssNodoArbolNivel1","id":"m_'.$filaOpciones[0].'","text":"'.cvJs($etiqueta).''.$permisos.'","descripcion":"'.
						cvJs($filaOpciones[2]).'","children":'.$arrOpcionesMenu.', "tipoOpcion":"3","icon":"../images/s.gif"'.$hoja.',"procesoPertenece":"'.$procesoMenu.'","paginasVinculadas":"'.$paginaMenu.'","macroprocesosVinculados":"'.$macroMenu.'"}';
			if($arrOpcion=="")
			{
				$arrOpcion=$objOpcion;
			}
			else
				$arrOpcion.=",".$objOpcion;
		}
		echo "[".uEJ($arrOpcion)."]";
			
	}
	
	function obtenerOpcionesMenuHijas($idPadre)
	{
		global $con;
		$consulta="select pO.idOpcion,pO.textoOpcion,pO.descripcion,pO.paginaUrlDestino,pO.tipoEnlace,if(pO.idContenido is null,'-1',pO.idContenido) 
					as idCont  from 809_opciones pO where pO.idPadre=".$idPadre." and pO.idIdioma=".$_SESSION["leng"]."  order by pO.orden";
		$resOpcMenu=$con->obtenerFilas($consulta);
		$arrOpcionesMenu="";
		$opcionesMenu="";
		$paginaMenu="";
		$procesoMenu="";
		$macroMenu="";
		while($filaOpcMenu=mysql_fetch_row($resOpcMenu))
		{
			$proceso="";
			switch($filaOpcMenu[4])
			{
				case 2:
					$arrDatos=explode("idFormulario=",$filaOpcMenu[3]);
					$consulta="SELECT nombreFormulario,p.nombre FROM 900_formularios f,4001_procesos p WHERE idFormulario=".$arrDatos[1]." AND p.idProceso=f.idProceso";
					$fFormulario=$con->obtenerPrimeraFila($consulta);
					$proceso=$fFormulario[1]." <br>(Formulario: ".$fFormulario[0].")";
				break;
				case 10:
					$arrDatos=explode("('",$filaOpcMenu[3]);
					
					$arrDatos=explode("')",$arrDatos[1]);
					
					$consulta="SELECT nombreFormulario,p.nombre FROM 900_formularios f,4001_procesos p WHERE p.idProceso=".bD($arrDatos[0])." and f.formularioBase=1 AND p.idProceso=f.idProceso";
					$fFormulario=$con->obtenerPrimeraFila($consulta);
					$proceso=$fFormulario[1]." <br>(Formulario: ".$fFormulario[0].")";
				break;
			}
			$pagina=$paginaMenu;
			$macro=$macroMenu;
			$etiquetaOpt=$filaOpcMenu[1];
			$permisosOpt="";
			$textoOpcion=cvJs($etiquetaOpt);
			
			$arrOpcionesHijas=obtenerOpcionesMenuHijas($filaOpcMenu[0]);
				
			$compNodo='"leaf":true';
			if($arrOpcionesHijas!="[]")
			{
				$compNodo='"leaf":false,"children":'.$arrOpcionesHijas;
			}
			
			$opcionesMenu='{"cls":"cssNodoArbolNivel2","id":"'.$filaOpcMenu[0].'","text":"'.$textoOpcion.'","descripcion":"'.cvJs($filaOpcMenu[2]).
						'","URL":"'.$filaOpcMenu[3].'","tipoEnlace":"'.$filaOpcMenu[4].'","idContenido":"'.$filaOpcMenu[5].'",'.$compNodo.',"tipoOpcion":"1","icon":"../images/s.gif","procesoPertenece":"'.$proceso.'","paginasVinculadas":"'.$pagina.'","macroprocesosVinculados":"'.$macro.'"}';
			if($arrOpcionesMenu=="")
				$arrOpcionesMenu=$opcionesMenu;
			else
				$arrOpcionesMenu.=",".$opcionesMenu;
		}	
		
		return "[".$arrOpcionesMenu."]";
	}
	
	function obtenerOpcionesPaginaDisponible()
	{
		global $con;
		$id=$_POST["id"];
		$nivel=$_POST["nivel"];
		$grupo=$_POST["grupo"];
		
		switch($nivel)
		{
			case "1":
			case "2":
				$consulta="select op.idOpcion
						from 813_paginasVSOpciones pO, 809_opciones op,812_permisosOpcionesMenus oM,810_paginas pa
						where oM.idOpcion=pO.idOpcion
						and pO.idPagina=pa.idPagina
						and op.idOpcion=pO.idOpcion
						and op.idIdioma=".$_SESSION["leng"]." 
						and oM.tipo=0 and oM.idRol=".$grupo."
						and pa.idPagina='".$id."'
						order by idPaginasVSOpciones";
				
				$resOpcAsig=$con->obtenerFilas($consulta);
				$opcAsig="0";
				while($fileOptAsig=mysql_fetch_row($resOpcAsig))
				{
					if($opcAsig=="0")
						$opcAsig=$fileOptAsig[0];
					else
						$opcAsig.=",".$fileOptAsig[0];
				}
						
				$consulta="select op.idOpcion,op.textoOpcion,op.descripcion	from 809_opciones op,812_permisosOpcionesMenus oM 	where oM.idOpcion=op.idOpcion and op.idIdioma=".$_SESSION["leng"]." and oM.tipo=0 and oM.idRol=".$grupo." and op.idOpcion not in(".$opcAsig.") order by op.textoOpcion";		
				
				$resOpciones=$con->obtenerFilas($consulta);
				
				$objOpcion='';
				$arrOpcion='';
				$etiqueta='';
				while($filaOpciones=mysql_fetch_row($resOpciones))
				{
					$etiqueta="<b>".$filaOpciones[1]."</b>";
					if($filaOpciones[2]!="")
						$etiqueta.=" ( ".$filaOpciones[2]." )";
					$etiqueta.=" [".obtenerPermisosOpcionMenu($filaOpciones[0],"0")."]";
					$objOpcion='{"idOpcion":"'.$filaOpciones[0].'","etiqueta":"'.$etiqueta.'","opciones":null}';
					if($arrOpcion=="")
					{
						$arrOpcion=$objOpcion;
					}
					else
						$arrOpcion.=",".$objOpcion;
				}
				echo "[".$arrOpcion."]";
				
			break;
			case "3":
				$consulta="select tm.idMenu from 813_paginasVSOpciones pO, 808_titulosMenu
						 tm,812_permisosOpcionesMenus oM,810_paginas pa where oM.idOpcion=pO.idOpcion
						 and pO.idPagina=pa.idPagina and tm.idMenu=pO.idOpcion and tm.idIdioma=".$_SESSION["leng"]." and
						 oM.tipo=1 and oM.idRol=".$grupo." and pa.idPagina='".$id."' order by 
						 idPaginasVSOpciones";
						 
				$resOpcAsig=$con->obtenerFilas($consulta);
				$opcAsig="0";
				while($fileOptAsig=mysql_fetch_row($resOpcAsig))
				{
					if($opcAsig=="0")
						$opcAsig=$fileOptAsig[0];
					else
						$opcAsig=",".$fileOptAsig[0];
				}		 
						 
					
				$consulta="select tm.idMenu,tm.textoMenu,tm.descripcion from 808_titulosMenu
						 tm,813_paginasVSOpciones oM where oM.idOpcion=tm.idMenu
						 and  tm.idIdioma=".$_SESSION["leng"]." and tm.idMenu not in(".$opcAsig.") 
						 and oM.tipo=1 and oM.idRol=".$grupo." order by 
						 tm.textoMenu"; 
				$resOpciones=$con->obtenerFilas($consulta);
				$objOpcion='';
				$arrOpcion='';
				$etiqueta='';
				$arrOpcionesMenu="";
				$opcionesMenu="";
				while($filaOpciones=mysql_fetch_row($resOpciones))
				{
					$etiqueta="<font color=blue><b>".$filaOpciones[1]."</b></font>";
					if($filaOpciones[2]!="")
						$etiqueta.=" ( ".$filaOpciones[2]." )";
					$etiqueta.=" [".obtenerPermisosOpcionMenu($filaOpciones[0],"1")."]";
					
					$consulta="select pO.idOpcion,pO.textoOpcion,pO.descripcion  from 811_menusVSOpciones mO, 
								809_opciones pO,813_paginasVSOpciones pOM where pOM.idOpcion=pO.idOpcion and
								pOM.tipo=0 and pOM.idRol=".$grupo." and	pO.idOpcion=mO.idOpcion and
								 pO.idIdioma=".$_SESSION["leng"]." and mO.idMenu=".$filaOpciones[0];
					$resOpcMenu=$con->obtenerFilas($consulta);
					$arrOpcionesMenu="null";
					$opcionesMenu="";
					while($filaOpcMenu=mysql_fetch_row($resOpcMenu))
					{
						$etiquetaOpt="<b>".$filaOpcMenu[1]."</b>";
						if($filaOpcMenu[2]!="")
							$etiqueta.=" ( ".$filaOpcMenu[2]." )";
						$etiquetaOpt.=" [".obtenerPermisosOpcionMenu($filaOpcMenu[0],"0")."]";
						$opcionesMenu='{"idOpcion":"'.$filaOpcMenu[0].'","etiqueta":"'.$etiquetaOpt.'"}';
						if($arrOpcionesMenu=="null")
							$arrOpcionesMenu=$opcionesMenu;
						else
							$arrOpcionesMenu.=",".$opcionesMenu;
					}					
					if(	$arrOpcionesMenu!="null")				
						$arrOpcionesMenu="[".$arrOpcionesMenu."]";
					$objOpcion='{"idOpcion":"'.$filaOpciones[0].'","etiqueta":"'.$etiqueta.'","opciones":'.$arrOpcionesMenu.'}';
					if($arrOpcion=="")
					{
						$arrOpcion=$objOpcion;
					}
					else
						$arrOpcion.=",".$objOpcion;
				}
				echo "[".$arrOpcion."]";
			break;
			
		}
	}
	
	function quitarAsociacionPagina()
	{
		global $mostrarXML;
		global $con;
		$mostrarXML=false;
		
		$idOpcion=str_replace("m_","",$_POST["idOpcion"]);
		$tipoAsociacion=$_POST["tAsociacion"];
		$idContenido=$_POST["idContenido"];
		$x=0;
		$consulta[$x]="begin";
		$x++;	
		
		
		if($tipoAsociacion==0)//Menu
		{
			$consulta[$x]="delete from 808_titulosMenu where idMenu=".$idOpcion;
			$x++;
			
			$query="select mo.idOpcion from 811_menusVSOpciones mo where mo.idMenu=".$idOpcion;
			$res=$con->obtenerFilas($query);
			while($fConsulta=mysql_fetch_row($res))
			{
				eliminarOpcionesHijas($fConsulta[0],$consulta,$x);
				$consulta[$x]="DELETE FROM 809_opciones WHERE idOpcion=".$fConsulta[0];
				$x++;
				$consulta[$x]="delete from 811_menusVSOpciones where idOpcion=".$fConsulta[0];
				$x++;
				
			}
		}
		else
		{
			$esOpcionNormal=true;
			$query="SELECT idPadre,orden FROM 809_opciones WHERE idOpcion=".$idOpcion;
			$fDatosOpcion=$con->obtenerPrimeraFila($query);
			$orden="";
			$idMenu="";
			if($fDatosOpcion[0]!="")
			{
				$orden=$fDatosOpcion[1];
				$idMenu=$fDatosOpcion[0];
				$esOpcionNormal=false;
			}
			else
			{
				$query="select orden,idMenu from 811_menusVSOpciones where idOpcion=".$idOpcion;
				$fila=$con->obtenerPrimeraFila($query);
				$orden=$fila[0];
				$idMenu=$fila[1];
			}
			
			eliminarOpcionesHijas($idOpcion,$consulta,$x);
			$consulta[$x]="delete from 809_opciones where idOpcion=".$idOpcion;
			$x++;
			$consulta[$x]="delete from 816_contenidos where idGrupoContenido=".$idContenido;
			$x++;
			if($esOpcionNormal)
			{
				$consulta[$x]="delete from 811_menusVSOpciones where idOpcion=".$idOpcion;
				$x++;
				$consulta[$x]="update 811_menusVSOpciones set orden=orden-1 where idMenu=".$idMenu." and orden>=".$orden;
				$x++;
			}
			else
			{
				$consulta[$x]="update 809_opciones set orden=orden-1 where idPadre=".$idMenu." and orden>=".$orden;
				$x++;
			}
			
			
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	
	function eliminarOpcionesHijas($idOpcionPadre,&$consulta,&$x)
	{
		global $con;
		$query="SELECT idOpcion FROM 809_opciones WHERE idPadre=".$idOpcionPadre;
		$res=$con->obtenerFilas($query);
		while($fConsulta=mysql_fetch_row($res))
		{
			eliminarOpcionesHijas($fConsulta[0],$consulta,$x);
			$consulta[$x]="DELETE FROM 809_opciones WHERE idOpcion=".$fConsulta[0];
			$x++;
			
		}
		
		
		
	}
	
	function obtenerPaginasOpciones()
	{
		global $mostrarXML;
		global $con;
		$mostrarXML=false;
		$idOpcion=$_POST["idOpcion"];
		$idOpcion=str_replace("m_","",$idOpcion);
		$posicion=$_POST["pos"];
		if($posicion!=4)
		{
			$consulta="(select p.idPagina,p.pagina,p.descripcion,'true' as asociacion from 810_paginas p
						where p.idPagina in(select idPagina from 813_paginasVSOpciones where idOpcion=".$idOpcion." and posicion=".$posicion."))
						union
						(select p.idPagina,p.pagina,p.descripcion,'false' as asociacion from 810_paginas p
						where p.idPagina not in(select idPagina from 813_paginasVSOpciones where idOpcion=".$idOpcion." and posicion=".$posicion.")) order by pagina";
			
		}
		else
			$consulta="(SELECT (idMacroProceso*-1) as idPagina,macroProceso as pagina,descripcion, 'true' as asociacion from 810_macroProcesos where idMacroProceso in 
						(select (idPagina*-1) as idPagina from 813_paginasVSOpciones where idOpcion=".$idOpcion." and posicion=".$posicion."))
						union
						(SELECT (idMacroProceso*-1) as idPagina,macroProceso as pagina,descripcion, 'false' as asociacion from 810_macroProcesos where idMacroProceso not in  
						(select (idPagina*-1) as idPagina from 813_paginasVSOpciones where idOpcion=".$idOpcion." and posicion=".$posicion."))
						";
		$cuerpo=utf8_encode($con->obtenerFilasJson($consulta));						
						
		echo $cuerpo;
	}	
	
	function asignarMenuPagina()
	{
		global $mostrarXML;
		global $con;
		$mostrarXML=false;
		$obj=dvJs($_POST["obj"]);
		$objJson=json_decode($obj);
		$idMenu=str_replace("m_","",$objJson->idMenu);
		$posicion=$objJson->pos;
		$arrPaginas=$objJson->arrObj;
		$consulta[0]="begin";
		$consulta[1]="delete from 813_paginasVSOpciones where idOpcion=".$idMenu." and posicion=".$posicion;
		$ct=2;
		foreach($arrPaginas as $fila)
		{
			$consulta[$ct]="insert into 813_paginasVSOpciones(idPagina,idOpcion,posicion) values(".$fila->idPagina.",".$idMenu.",".$posicion.")";
			$ct++;
		}
		$consulta[$ct]="commit";
		if($con->ejecutarBloque($consulta))
			echo "1";
	}
	
	function cambiarIdioma()
	{
			$idIdioma=$_POST["idIdioma"];
			$_SESSION["leng"]=$idIdioma;
			echo "1";
	}
		
	function obtenerContenidos()
	{
		global $mostrarXML;
		global $con;
		$mostrarXML=false;
		$idContenido=$_POST["idContenido"];
		$contenidos=$con->obtenerFilasJson("select contenido,idIdioma from 816_contenidos where idGrupoContenido=".$idContenido);
		$contenidos=str_replace("\\\\\\","\\",utf8_encode($contenidos));
		$obj='[{"arrContenidos":'.$contenidos.'}]';
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
	
	function obtenerNumElementosMenu()
	{
		global $con;
		$idMenu=str_replace("m_","",$_POST["idMenu"]);
		

		
		$consulta="select count(idMenu) from 811_menusVSOpciones where idMenu= ".$idMenu;
		$valor=$con->obtenerValor($consulta);
		echo "1|".$valor;
		
	}
	
	function eliminarRol()
	{
		global $con;
		$idRol=$_POST["idRol"];
		$consulta="delete from 8001_roles where idRol=".$idRol;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerProcesos()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$consulta="select idProceso,nombre,descripcion from 4001_procesos where idTipoProceso=".$idProceso;
		$arrDatos=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrDatos);
	}

	function guardarMensajesProceso()
	{
		global $con;
		$parametro=str_replace('\\\\','\\',$_POST["param"]);
		$objJson=json_decode($parametro);
		$idCircular=$objJson->idCircular;
		$idProceso=$objJson->idProceso;
		$numEtapa=$objJson->numEtapa;
		$circulares=$objJson->circulares;
		//$permisos=$objJson->permisos;
		//$arrPermisos=explode(",",$permisos);
		
		$ct=sizeof($circulares);
		$obj;
		$consultaIdPlantilla="select idMensajeSiguiente from 2000_variablesSistema";
		$idPlantilla=$con->obtenerValor($consultaIdPlantilla);
		$p=0;
		$consulta[$p]="begin";
		$p++;
		if($idCircular!="")
		{
			$consulta[$p]="delete from 9020_mensajesAccionProceso where idGrupoMensaje=".$idCircular;
			$p++;
		}
		for($x=0;$x<$ct;$x++)
		{
			$obj=$circulares[$x];
			$consulta[$p]="insert into 9020_mensajesAccionProceso(asunto,cuerpo,idIdioma,idGrupoMensaje,descripcion,idUsuario,idProceso,numEtapa,remitente) 
							values('".cv($obj->asunto)."','".cv($obj->cuerpo)."',".cv($obj->idIdioma).",".$idPlantilla.",'".cv($obj->desc)."',
							".$_SESSION["idUsr"].",".$idProceso.",".$numEtapa.",'".cv($obj->remitente)."')";
			$p++;

		}
		
		$consulta[$p]="update 2000_variablesSistema set idMensajeSiguiente=idMensajeSiguiente+1";
		$p++;
		$consulta[$p]="commit";
		if($con->ejecutarBloque($consulta))
			echo "1|".$idPlantilla;
		else
			echo "-1|";		
	}
	
	function obtenerCategoriasDocumentos()
	{
		global $con;
		$idUsuario=$_SESSION["idUsr"];
		$consulta="SELECT idCategoriaDocumento FROM 9047_categoriasDocumento WHERE idUsuario=".$idUsuario." ORDER BY nombreCategoria";
		$listCategorias=$con->obtenerListaValores($consulta);
		$arrCategorias=explode(",",$listCategorias);
		$consulta="SELECT idCategoria FROM 9047_usuariosCategoriasComparte WHERE (tipoUsuario=0 AND idUsuario=".$idUsuario.") OR (tipoUsuario=1 AND idUsuario IN(".$_SESSION["idRol"]."))";
		$listCategorias=$con->obtenerListaValores($consulta);
		if($listCategorias!="")
		{
			$arrCategoriasAux=explode(",",$listCategorias);
			foreach($arrCategoriasAux as $idCategoria)
			{
				if(!existeValor($arrCategorias,$idCategoria))
					array_push($arrCategorias,$idCategoria);
			}
		}

		$listCategorias="";
		if(sizeof($arrCategorias)>0)
		{
			foreach($arrCategorias as $idCategoria)
			{
				if($listCategorias=="")
					$listCategorias=$idCategoria;
				else
					$listCategorias.=",".$idCategoria;
			}
		}
		
		if($listCategorias=="")
			$listCategorias=-1;
		
		$consulta="SELECT g.idCategoria FROM 9048_usuariosDocumentoComparte d,9048_galeriaDocumentos g WHERE 
					g.idGaleriaDocumentos=d.idDocumento and 
					(
						(d.tipoUsuario=0 AND d.idUsuario=".$_SESSION["idUsr"].") OR (d.tipoUsuario=1 AND d.idUsuario IN(".$_SESSION["idRol"].")) or (g.idUsuario=".$idUsuario.")
					)	and g.idCategoria not in (".$listCategorias.")";

		$resCategoria=$con->obtenerFilas($consulta);
		while($filaCat=mysql_fetch_row($resCategoria))
		{
			if(!existeValor($arrCategorias,$filaCat[0]))
			{
				if($listCategorias==-1)
					$listCategorias=$filaCat[0];
				else
					$listCategorias.=",".$filaCat[0];
			}
		}
		
		$consulta="SELECT distinct g.idGaleriaDocumentos FROM 9048_galeriaDocumentos g WHERE g.idCategoria=0 and g.idUsuario=".$idUsuario;
					
		$con->obtenerFilas($consulta);
		$noDocumentos=$con->filasAfectadas;
		
		$consulta="SELECT distinct g.idGaleriaDocumentos FROM 9048_usuariosDocumentoComparte d,9048_galeriaDocumentos g WHERE g.idCategoria=0 and
					g.idGaleriaDocumentos=d.idDocumento and 
					(
						(d.tipoUsuario=0 AND d.idUsuario=".$idUsuario.") OR (d.tipoUsuario=1 AND d.idUsuario IN(".$idUsuario."))
					)";
					
		$con->obtenerFilas($consulta);
		$noDocumentos+=$con->filasAfectadas;
		$cadNodos='{icon:"../images/user_gray.png",id:"0",text:"Sin categoría ('.$noDocumentos.')",leaf:true,noDocumentos:"'.$noDocumentos.'","nombre":"Sin categoría","permisosCategoria":"CA","permisos":"A","arrPermisosDefault":[]}';
		$consulta="SELECT * FROM 9047_categoriasDocumento WHERE idCategoriaDocumento in (".$listCategorias.")";
		$res=$con->obtenerFilas($consulta);
		$permisos="";
		$permisosCategoria="";
		$arrPermisosDefault="";
		while($fila=mysql_fetch_row($res))
		{
			$permisos="";
			$permisosCategoria="";
			$arrPermisosDefault="";
			$consulta="SELECT idUsuario,tipoUsuario,permisos from 9047_usuariosCategoriasComparte WHERE idCategoria=".$fila[0];
			$resPermisos=$con->obtenerFilas($consulta);
			$usuariosComparte="";
			$icono="../images/user_gray.png";
			while($filaUsr=mysql_fetch_row($resPermisos))
			{
				$nomUsuario="";
				if($filaUsr[1]==1)
					$nomUsuario=obtenerTituloRol($filaUsr[0]);
				else
					$nomUsuario=obtenerNombreUsuario($filaUsr[0]);
				$obj="['".$filaUsr[0]."','".trim($nomUsuario)."','".$filaUsr[1]."','".$filaUsr[2]."']";
				if($usuariosComparte=="")
					$usuariosComparte=$obj;
				else
					$usuariosComparte.=",".$obj;
					
				if($fila[3]!=$idUsuario)
				{
					
					if($filaUsr[1]==0)
					{
						if($filaUsr[0]==$idUsuario)
						{
							
							for($x=0;$x<strlen($filaUsr[2]);$x++)
							{
								
								$permiso=$filaUsr[2][$x];
								
								if(strpos($permisos,$permiso)===false)
									$permisos.=$permiso;
							}
						}
					}
					else
					{
						if(existeRol("'".$filaUsr[0]."'"))
						{
							for($x=0;$x<sizeof($filaUsr[2]);$x++)
							{
								$permiso=$filaUsr[2][$x];
								
								if(strpos($permisos,$permiso)===false)
									$permisos.=$permiso;
							}
						}
					}
				}
					
			}
			$texto=$fila[1];
			$texto2="";
			$noDocumentos=0;
			if($fila[3]!=$idUsuario)
			{
				$texto2=" [<b>Compartida por</b> ".obtenerNombreUsuario($fila[3])."]";
				$consulta="SELECT distinct g.idGaleriaDocumentos FROM 9048_galeriaDocumentos g WHERE g.idCategoria=".$fila[0]." and g.idUsuario=".$idUsuario;
				$con->obtenerFilas($consulta);
				$noDocumentos=$con->filasAfectadas;	
				$consulta="SELECT distinct g.idGaleriaDocumentos FROM 9048_usuariosDocumentoComparte d,9048_galeriaDocumentos g WHERE g.idCategoria=".$fila[0]." and
					g.idGaleriaDocumentos=d.idDocumento and 
					(
						(d.tipoUsuario=0 AND d.idUsuario=".$idUsuario.") OR (d.tipoUsuario=1 AND d.idUsuario IN(".$idUsuario."))
					)";

				$permisosCategoria="C";
				$arrPermisosDefault="";
				$icono="../images/user_go.png";
			}
			else
			{
				
				$arrPermisosDefault=$usuariosComparte;
				$permisosCategoria="CAME";
				$permisos="CAME";
				$consulta="SELECT distinct g.idGaleriaDocumentos FROM 9048_galeriaDocumentos g WHERE g.idCategoria=".$fila[0];	
			}
			$con->obtenerFilas($consulta);
			$noDocumentos+=$con->filasAfectadas;
			$texto=$fila[1]." (".$noDocumentos.")".$texto2;
			
			$obj='{"icon":"'.$icono.'","permisosCategoria":"'.$permisosCategoria.'","permisos":"'.$permisos.'","arrPermisosDefault":['.$arrPermisosDefault.'],id:"'.$fila[0].'",text:"'.$texto.'",leaf:true,noDocumentos:"'.$noDocumentos.'","qtip":"'.$fila[2].'","nombre":"'.$fila[1].'","descripcion":"'.$fila[2].'"}';
			$cadNodos.=",".$obj;
		}
		
		echo "[".$cadNodos."]";
		
	}
	
	function modificarCategoriaDocumento()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->idCategoria==-1)
		{
			$consulta[$x]="INSERT INTO 9047_categoriasDocumento(nombreCategoria,descripcion,idUsuario) VALUES('".cv($obj->nombreCategoria)."','".cv($obj->descripcion)."',".$_SESSION["idUsr"].")";
			$x++;
			$consulta[$x]="set @idCategoria:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$consulta[$x]="update 9047_categoriasDocumento set nombreCategoria='".cv($obj->nombreCategoria)."',descripcion='".cv($obj->descripcion)."' where idCategoriaDocumento=".$obj->idCategoria;
			$x++;
			$consulta[$x]="set @idCategoria:=".$obj->idCategoria;
			$x++;
		}
		
		$consulta[$x]="delete from  9047_usuariosCategoriasComparte where idCategoria=@idCategoria";
		$x++;
		if(sizeof($obj->arrComparte)>0)
		{
			foreach($obj->arrComparte as $d)
			{
				$consulta[$x]="INSERT INTO 9047_usuariosCategoriasComparte(idUsuario,tipoUsuario,permisos,idCategoria) VALUES('".$d->idUnidad."',".$d->tipoUnidad.",'".$d->permisos."',@idCategoria)";
				$x++;
			}
		}	
		$consulta[$x]="commit";
		$x++;	
			
		if($con->ejecutarBloque($consulta))
		{
			if($obj->idCategoria==-1)
			{
				$consulta="select @idCategoria";
				$obj->idCategoria=$con->obtenerValor($consulta);
			}

			echo "1|".$obj->idCategoria;
		}
	}
	
	function removerCategoriaDocumento()
	{
		global $con;
		$idCategoria=$_POST["idCategoria"];
		$consulta="delete from 9047_categoriasDocumento where idCategoriaDocumento=".$idCategoria;
		eC($consulta);
	}
	
	function obtenerDocumentosCategoria()
	{
		global $con;
		global $baseDir;
		
		$idCategoria=$_POST["idCategoria"];
		
		
		$consulta="SELECT idUsuario FROM 9047_categoriasDocumento WHERE idCategoriaDocumento=".$idCategoria;
		$idUsuario=$con->obtenerValor($consulta);
		if($idUsuario==$_SESSION["idUsr"])
		{
			$consulta="SELECT * FROM 9048_galeriaDocumentos WHERE idCategoria=".$idCategoria;
		}
		else
		{
			$consulta="SELECT idDocumento FROM 9048_usuariosDocumentoComparte WHERE (tipoUsuario=0 AND idUsuario=".$_SESSION["idUsr"].") OR (tipoUsuario=1 AND idUsuario IN(".$_SESSION["idRol"]."))";
			$listDocumentos=$con->obtenerListaValores($consulta);
			if($listDocumentos=="")
				$listDocumentos=-1;
			$consulta="SELECT * FROM 9048_galeriaDocumentos WHERE idCategoria=".$idCategoria." and (idUsuario=".$_SESSION["idUsr"]." or idGaleriaDocumentos in (".$listDocumentos."))";
		}
		$res=$con->obtenerFilas($consulta);
		$cadObj="";
		while($fila=mysql_fetch_row($res))
		{
			$url="";
			$lblComplementario="";
			$datosArchivos=explode(".",$fila[1]);
			$extension=strtolower($datosArchivos[sizeof($datosArchivos)-1]);
			$tamano=$fila[3];
			if($tamano<1024)
			{
				$tamano=number_format($tamano,0)." bytes";
			}
			else
			{
				$tamano=$fila[3]/1024;
				$dTamano=explode(".",$tamano);
				$tamano=$dTamano[0];
				if(isset($dTamano[1]))
				{
					$tamano++;
				}
				$tamano=number_format($tamano,0);
				$tamano.=" KB";
			}
			$ancho="32";
			$alto="32";
			$maxAlto="64";
			$maxAncho="200";
			if(($extension=="png")||($extension=="jpg")||($extension=="jpeg")||($extension=="gif"))
			{
				
				$url="../repositorioDocumentos/documento_".$fila[0];
				$tamanoImg=getimagesize($url);
				$ancho=$tamanoImg[0];
				$alto=$tamanoImg[1];
				
				if(($alto>$maxAlto)||($ancho>$maxAncho))
				{
					if($alto>$ancho)
					{
						
						$escala=$maxAlto/$alto;
						$alto=$maxAlto;
						$ancho*=$escala;
					}
					else
					{
						$escala=$maxAncho/$ancho;
						$ancho=$maxAncho;
						$alto*=$escala;
					}
				}
				$url.="?noCache=0";
				
			}
			else
			{
				if(file_exists($baseDir."/imagenesDocumentos/32/file_extension_".strtolower($extension).".png"))
				{
					$url="../imagenesDocumentos/32/file_extension_".strtolower($extension).".png";
				}
				else
				{
					$url="../imagenesDocumentos/32/document_empty.png";
				}
			}
			$permisos="";
			if($fila[4]==$_SESSION["idUsr"])
			{
				$permisos="CME";
			}
			else
			{
				$permisos="C";
				$lblComplementario="<img src='../images/user_go.png' width='12' height='12' alt='Documento compartido' title='Documento compartido'>&nbsp;";
			}
			$consulta="SELECT idUsuario,tipoUsuario,permisos from 9048_usuariosDocumentoComparte WHERE idDocumento=".$fila[0];
			$resUsr=$con->obtenerFilas($consulta);
			$usuariosComparte="";
			while($filaUsr=mysql_fetch_row($resUsr))
			{
				$nomUsuario="";
				if($filaUsr[1]==1)
					$nomUsuario=obtenerTituloRol($filaUsr[0]);
				else
					$nomUsuario=obtenerNombreUsuario($filaUsr[0]);
				$obj="['".$filaUsr[0]."','".trim($nomUsuario)."','".$filaUsr[1]."','".$filaUsr[2]."']";
				if($usuariosComparte=="")
					$usuariosComparte=$obj;
				else
					$usuariosComparte.=",".$obj;
					
				if($fila[4]!=$_SESSION["idUsr"])
				{
					
					if($filaUsr[1]==0)
					{
						if($filaUsr[0]==$_SESSION["idUsr"])
						{
							
							for($x=0;$x<strlen($filaUsr[2]);$x++)
							{
								
								$permiso=$filaUsr[2][$x];
								
								if(strpos($permisos,$permiso)===false)
									$permisos.=$permiso;
							}
						}
					}
					else
					{
						if(existeRol("'".$filaUsr[0]."'"))
						{
							for($x=0;$x<sizeof($filaUsr[2]);$x++)
							{
								$permiso=$filaUsr[2][$x];
								
								if(strpos($permisos,$permiso)===false)
									$permisos.=$permiso;
							}
						}
					}
				}
					
			}
			
			
			$obj='{"lblComplementario":"'.$lblComplementario.'","autor":"'.trim(obtenerNombreUsuario($fila[4])).'","permisos":"'.$permisos.'","usuariosComparte":['.$usuariosComparte.'],"alto":"'.$alto.'","ancho":"'.$ancho.'","extension":"'.$extension.'","idCategoria":"'.$fila[5].'","idDocumento":"'.$fila[0].'","url":"'.$url.'","nombreArchivo":"'.cv($fila[1]).'","tituloDocumento":"'.cv($fila[7]).'","descripcion":"'.cv($fila[2]).'","tamano":"'.$tamano.'","fechaUltimoCambio":"'.date("d/m/Y H:i",strtotime($fila[6])).'"}';
			if($cadObj=="")
				$cadObj=$obj;
			else
				$cadObj.=",".$obj;
		}
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$cadObj.']}';

	}
	
	function guardarDocumentoCategoria()
	{
		global $con;
		global $baseDir;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$tamano=0;
		$dirTemporal=$baseDir."/archivosTemporales";
		$dirDestino=$baseDir."/repositorioDocumentos";
		if($obj->archivoId!="")
		{
			$tamano=filesize($dirTemporal."/".$obj->archivoId);
		}
		if($obj->idDocumento==-1)
		{
			$consulta[$x]="INSERT INTO 9048_galeriaDocumentos(nombreDocumento,descripcion,tamano,idUsuario,idCategoria,fechaUltimoCambio,tituloDocumento)
						VALUES('".cv($obj->nombreArchivo)."','".cv($obj->descripcion)."',".$tamano.",".$_SESSION["idUsr"].",".$obj->categoria.",'".date("Y-m-d H:i:s")."','".cv($obj->titulo)."')";
			$x++;
			$consulta[$x]="set @idDocumento:=(select last_insert_id())";
			$x++;
			
		}
		else
		{
			if($obj->archivoId=="")
			{
				$consulta[$x]="update 9048_galeriaDocumentos set tituloDocumento='".cv($obj->titulo)."',fechaUltimoCambio='".date("Y-m-d H:i:s")."',idCategoria=".$obj->categoria.",descripcion='".cv($obj->descripcion).
							"' where idGaleriaDocumentos=".$obj->idDocumento;
				$x++;
			}
			else
			{
				$consulta[$x]="update 9048_galeriaDocumentos set nombreDocumento='".cv($obj->nombreArchivo)."',tamano=".$tamano.",tituloDocumento='".cv($obj->titulo)."',fechaUltimoCambio='".date("Y-m-d H:i:s").
							"',idCategoria=".$obj->categoria.",descripcion='".cv($obj->descripcion)."' where idGaleriaDocumentos=".$obj->idDocumento;
				$x++;
			}
			$consulta[$x]="set @idDocumento:=".$obj->idDocumento;
			$x++;
		}
		$consulta[$x]="delete from  9048_usuariosDocumentoComparte where idDocumento=@idDocumento";
		$x++;
		if(sizeof($obj->arrComparte)>0)
		{
			foreach($obj->arrComparte as $d)
			{
				$consulta[$x]="INSERT INTO 9048_usuariosDocumentoComparte(idUsuario,tipoUsuario,permisos,idDocumento) VALUES('".$d->idUnidad."',".$d->tipoUnidad.",'".$d->permisos."',@idDocumento)";
				$x++;
			}
		}
		
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			if($obj->idDocumento==-1)
			{
				$consulta="select @idDocumento";
				$obj->idDocumento=$con->obtenerValor($consulta);
			}
			if($obj->archivoId!="")
			{
				copy($dirTemporal."/".$obj->archivoId,$dirDestino."/documento_".$obj->idDocumento);
				unlink($dirTemporal."/".$obj->archivoId);
			}
			echo "1|";
		}
	}
	
	function removerDocumentosGaleria()
	{
		global $con;
		global $baseDir;
		$idDocumento=$_POST["idDocumento"];
		$consulta="delete  from 9048_galeriaDocumentos where  idGaleriaDocumentos=".$idDocumento;
		$dirDestino=$baseDir."/repositorioDocumentos";
		if($con->ejecutarConsulta($consulta))
		{
			unlink($dirDestino."/documento_".$idDocumento);
			echo "1|";
		}
	}
	
	function obtenerComentariosDudas()
	{
		global $con;
		$situacion=$_POST["situacion"];
		$ciclo=$_POST["ciclo"];
		$consulta="SELECT idComentarioUsuario AS idComentario,fechaComentario,nombreUsuario AS responsableComentario,email AS emailResponsable,comentario,activo AS situacion,fechaRespuesta AS fechaAtencion,
				(SELECT nombre FROM 800_usuarios WHERE idUsuario=c.idResponsableRespuesta)responsableAtencion,respuesta AS respuestaAtencion FROM 001_comentariosUsuariosSistema c 
				WHERE fechaComentario>='".$ciclo."-01-01' and fechaComentario<='".$ciclo."-12-31' and activo in (".$situacion.") ORDER BY fechaComentario";
		$arrReg=$con->obtenerFilasJSON($consulta);
		
		$arrReg=str_replace("#R","",$arrReg);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
		
	}
	
	function guardarRespuestaComentario()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="UPDATE 001_comentariosUsuariosSistema SET activo=0,fechaRespuesta='".date("Y-m-d H:i:s")."',respuesta='".cv($obj->respuesta)."',idResponsableRespuesta=".$_SESSION["idUsr"].",comentariosAdicionales='".cv($obj->adicional)."' WHERE idComentarioUsuario=".$obj->idComentario;

		if($con->ejecutarConsulta($consulta))
		{
			$asunto="Soporte a Dudas/Comentarios";
			$cuerpo=cv($obj->respuesta);
			$consulta="SELECT comentario,emailRemitente FROM 001_comentariosUsuariosSistema WHERE idComentarioUsuario=".$obj->idComentario;
			$fDuda=$con->obtenerPrimeraFila($consulta);
			$comentario=$fDuda[0];
			$cuerpo.="<br><br><br>Este mensaje responde al comentario:<br><br><br>".cv($comentario);
			$remitente="soporteSMAP@grupolatis.net";
			if($fDuda[1]!="")
			{
				$remitente=$fDuda[1];	
			}
			$destinatario=$obj->email;

			if($obj->enviarRespuesta==1)
			{
				if(enviarMail($destinatario,$asunto,$cuerpo,$remitente))
				{
					enviarMail("smap2014censida@gmail.com","Respuesta a destinatario: ".$destinatario,$cuerpo,$remitente);
					
					
					echo "1|";
				}
			}
			else
			{
				echo "1|";
			}
		}
	}
	
	function removerComentario()
	{
		global $con;
		$idComentario=$_POST["idComentario"];
		$consulta="delete from 001_comentariosUsuariosSistema where idComentarioUsuario=".$idComentario;
		eC($consulta);
	}
	
	function generarTableroControl()
	{
		global $con;
		$objRef=NULL;
		$arrMenu="";
		$totalReg=0;
		$consulta="SELECT t.idMenu,textoMenu,colorFondo,idFuncionVisualiza,idFuncionRenderer,clase FROM 813_paginasVSOpciones p,808_titulosMenu t WHERE posicion=5 AND t.idMenu=p.idOpcion ORDER BY prioridad,textoMenu";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$tblMenu="";
			
			$mostrarMenu=true;
			
			$consulta="SELECT COUNT(idOpcion) FROM 812_permisosOpcionesMenus WHERE idOpcion=".$fila[0]." AND  idRol IN(".$_SESSION["idRol"].")";
			
			$nReg=$con->obtenerValor($consulta);
			if($nReg==0)
				$mostrarMenu=true;
			
			if((!$mostrarMenu)&&($fila[3]!="")&&($fila[3]!="-1"))
			{
				$cadObj='{"idMenu":"'.$fila[0].'"}';
				$obj=json_decode($cadObj);
				$resultado=removerComillasLimite(resolverExpresionCalculoPHP($fila[3],$obj,$objRef));

				if($resultado==0)
					$mostrarMenu=false;
				else
					$mostrarMenu=true;
			}
			
			if(!$mostrarMenu)
				continue;
			if(($fila[4]=="")||($fila[4]=="-1"))
			{
				$linkEnlace="";
				$opciones="";
				$consulta="SELECT o.* FROM 811_menusVSOpciones m,809_opciones o WHERE idMenu=".$fila[0]." AND o.idOpcion=m.idOpcion ORDER BY orden";
				$resOpt=$con->obtenerFilas($consulta);
				while($filaOpt=mysql_fetch_row($resOpt))
				{
					$o="";
					$mostrarOpcion=true;
					if(($filaOpt[12]!="")&&($filaOpt[12]!="-1"))
					{
						$cadObj='{"idOpcion":"'.$filaOpt[0].'"}';
				
						$obj=json_decode($cadObj);
						
						$resultado=removerComillasLimite(resolverExpresionCalculoPHP($filaOpt[12],$obj,$objRef));
						if($resultado==0)
							$mostrarOpcion=false;
					}
					if(!$mostrarOpcion)
						continue;
					if(($filaOpt[13]=="")||($filaOpt[13]=="-1"))
					{
						if(strpos($filaOpt[2],"?idFormulario"))
						{
							
							$arrOpciones=explode('=',$filaOpt[2]);
							$idFormulario=$arrOpciones[1];
							if(strpos($filaOpt[2],"administrarHorarioUnidadApartado.php"))
								$linkEnlace='window.parent.enviarFormularioAdmon('.$idFormulario.')';
							else
								$linkEnlace.='window.parent.enviarFormulario('.$idFormulario.')';
						}
						else
						{
							if(strpos($filaOpt[2],"?idTipoProyecto"))
							{
								$arrOpciones=explode('=',$filaOpt[2]);
								$idTipoProyecto=$arrOpciones[1];
								
							}
							else
							{
								if(strpos($filaOpt[2],"javascript")===false)
									$linkEnlace='window.parent.abrirUrl(\\"'.$filaOpt[2].'\\")';
								else
								{
									
									$linkEnlace=str_replace("javascript:","javascript:window.parent.",$filaOpt[2]);
									
								}
							}
						}
						$claseOpcion="bg_list_un";
						if($filaOpt[14]!="")
							$claseOpcion=$filaOpt[14];
						$imgBullet="";
						if($filaOpt[9]!="")
							$imgBullet="<img src='../media/verBullet.php?id=".$filaOpt[0]."' width='16' height='16'> ";
						$o=	'<li >'.
								'<table><tr height=\'21\'><td width=\'20\'>'.$imgBullet.'</td><td><a onclick='.$linkEnlace.' style=\'cursor:pointer; cursor: hand;\'><span class=\''.$claseOpcion.'\'>'.$filaOpt[1].'</span></a></td></tr></table>'.
							'</li>';
					}
					else
					{
						$cadObj='{"idOpcion":"'.$filaOpt[0].'"}';
				
						$obj=json_decode($cadObj);
						
						$tblOpcion=removerComillasLimite(resolverExpresionCalculoPHP($filaOpt[13],$obj,$objRef));
						$o='<li>'.$tblOpcion.'</li>';
					}
					$opciones.=$o;
				}	
				$claseMenu="current";
				if($fila[5]!="")
					$claseMenu=$fila[5];
				$tblMenu='<table>'.
							'<tr>'.
								'<td >'.
									'<ul id=\'menu_'.$nReg.'\'>'.
										'<li  >'.
											'<a href=\'#\'><span class=\''.$claseMenu.'\' style=\'display:inline-block; \'>'.$fila[1].'</span></a>'.
											'<ul>'.
												$opciones.
											'</ul>'.
										'</li>'.
									'</ul>'.
								'</td>'.
							'</tr>'.
						'</table>';
			}
			else
			{
				$cadObj='{"idMenu":"'.$fila[0].'"}';
				$obj=json_decode($cadObj);
				$tblMenu=removerComillasLimite(resolverExpresionCalculoPHP($fila[4],$obj,$objRef));
			}
			$obj='{"orden":"'.$totalReg.'","menu":"'.$tblMenu.'"}';
			if($arrMenu=="")
				$arrMenu=$obj;
			else
				$arrMenu.=",".$obj;
			$totalReg++;
		}
		echo '{"numReg":"'.$totalReg.'","registros":['.$arrMenu.']}';
	}
		
	function enviarContacto()
	{
		global $con;
		global $urlSitio;
		
		$conAux=generarInstanciaConector(5);
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);	
		$consulta="INSERT INTO _1019_tablaDinamica(fechaCreacion,responsable,idEstado,sitio,zona,nombre,email,telefono,comentarios,empresa)
				VALUES('".date("Y-m-d H:i:s")."',1,1,'".$urlSitio."',".$obj->idZona.",'".cv($obj->nombre)."','".cv($obj->email)."','".cv($obj->telefono)."','".cv($obj->comentarios)."','".cv($obj->empresa)."')";
		if($conAux->ejecutarConsulta($consulta))
		{
			echo "1|";	
		}
	}
	
	function registrarBitacoraNotificaciones()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$referencia1="";
		if(isset($_POST["referencia1"]))
			$referencia1=$_POST["referencia1"];
		$referencia2="";
		if(isset($_POST["referencia2"]))
			$referencia2=$_POST["referencia2"];
		$referencia3="";
		if(isset($_POST["referencia3"]))
			$referencia3=$_POST["referencia3"];
		$obj=json_decode($cadObj);
		
	
		$idResponsable=1;
		if(isset($_SESSION["idUsr"]))
			$idResponsable=$_SESSION["idUsr"];
			
			
		$x=0;	
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO 8000_logNotificaciones(tipoNotificacion,respuesta,accionEvento,fechaEvento,observaciones,comentarios,idResponsable,referencia1,referencia2,referencia3,verificarAutorizacion,idUsuarioAutorizacion)
					VALUES(".$obj->tipoNotificacion.",".$obj->respuesta.",".$obj->accionEvento.",'".date("Y-m-d H:i:s")."','".cv(bD($obj->observaciones))."','".cv($obj->comentarios)."',".$idResponsable.
					",'".cv($referencia1)."','".cv($referencia2)."','".cv($referencia3)."',".$obj->verificarAutorizacion.",".$obj->idUsuarioAutorizacion.")";
		$x++;
		$consulta[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		
		
		$reflectionClase = new ReflectionObject($obj->datosEvento);
		
		foreach ($reflectionClase->getProperties() as $property => $value) 
		{
			$nombre=$value->getName();
			
			$valor=$value->getValue($obj->datosEvento);
				
			$consulta[$x]="INSERT INTO 8000_datosEventoLogNotificaciones(idNotificacion,datosEvento,valor)
						VALUES(@idRegistro,'".$nombre."','".cv($valor)."')";
			$x++;
			
  
		}
		
		
		$cadTemp='{"arrComentarios":'.bD($obj->observaciones).'}';

		$oTemp=json_decode($cadTemp);
		
		
		$arrEntidadesInvolucradas=array();
		foreach($oTemp->arrComentarios as $c)
		{
			$arrEntidadesInvolucradas[$c->entidadValidacion."_".$c->idEntidadValidacion]["tipoEntidad"]=$c->entidadValidacion;
			$arrEntidadesInvolucradas[$c->entidadValidacion."_".$c->idEntidadValidacion]["idEntidadValidacion"]=$c->idEntidadValidacion;
		}
		foreach($arrEntidadesInvolucradas as $id=>$resto)
		{
			$consulta[$x]="INSERT INTO 8000_entidadesEventoLogNotificacion(idNotificacion,tipoEntidad,idEntidad)
						VALUES(@idRegistro,".$resto["tipoEntidad"].",".$resto["idEntidadValidacion"].")";
			$x++;
			
		}
		
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
	}
	
	function cambiarAdscripcionUsuario()
	{
		$adscripcion=$_POST["adscripcion"];
		$_SESSION["codigoInstitucion"]=$adscripcion;
		echo "1|";
	}
	
	function cambiarIdentidadUsuario()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		
		
		$consulta="Select u.idUsuario,u.login,u.Nombre,a.Institucion,a.codigoUnidad,u.status,u.cambiarDatosUsr from 800_usuarios u,
					801_adscripcion a where a.idUsuario=u.idUsuario and u.idUsuario=".$idUsuario; //and Status=1
		
		
		$fila=$con->obtenerPrimeraFila($consulta);
		
		if($fila)
		{
			$conAdscripcion="SELECT codigoUnidad FROM 801_adscripcion WHERE idUsuario=".$fila[0];
			$adscripcion=$con->obtenerValor($conAdscripcion);
			$conRol="SELECT idRol FROM 807_usuariosVSRoles WHERE idUsuario=".$fila[0]." AND idRol=1";
			$idRol=$con->obtenerValor($conRol);

			$_SESSION["idUsrAnterior"]=$_SESSION["idUsr"];
			$_SESSION["suplantado"]=1;
			$_SESSION["idUsr"]=$fila[0];
			$_SESSION["login"]=$fila[1];
			$_SESSION["nombreUsr"]=$fila[2];
			$_SESSION["statusCuenta"]=$fila[6];
			$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$fila[0];
			$resRoles=$con->obtenerFilas($consulta);
			$listaGrupo="";
			while($fRoles=mysql_fetch_row($resRoles))
			{
				$arrRol=explode("_",$fRoles[0]);
				$rol="'".$fRoles[0]."'";
				if($arrRol[1]!="0")
					$rol.=",'".$arrRol[0]."_-1'";
				
				if($listaGrupo=="")
					$listaGrupo=$rol;
				else
					$listaGrupo.=",".$rol;
			}
			if($listaGrupo=="")
				$listaGrupo='-1';
			$_SESSION["idRol"]=$listaGrupo.",'-100_0','1_0'";
			$_SESSION["codigoUnidad"]=$fila[4];
			$_SESSION["codigoInstitucion"]=$fila[3];
			
		}
		
		echo "1|";
	}
	
	
	function restaurarIdentidadUsuario()
	{
		global $con;
	
		if(!isset($_SESSION["idUsrAnterior"])||($_SESSION["idUsrAnterior"]==-1))
		{
			echo "1|";
			return;
		}
		
		$consulta="Select u.idUsuario,u.login,u.Nombre,a.Institucion,a.codigoUnidad,u.status,u.cambiarDatosUsr from 800_usuarios u,
					801_adscripcion a where a.idUsuario=u.idUsuario and u.idUsuario=".$_SESSION["idUsrAnterior"]; //and Status=1
		
		
		$fila=$con->obtenerPrimeraFila($consulta);
		
		if($fila)
		{
			$conAdscripcion="SELECT codigoUnidad FROM 801_adscripcion WHERE idUsuario=".$fila[0];
			$adscripcion=$con->obtenerValor($conAdscripcion);
			$conRol="SELECT idRol FROM 807_usuariosVSRoles WHERE idUsuario=".$fila[0]." AND idRol=1";
			$idRol=$con->obtenerValor($conRol);

			$_SESSION["idUsrAnterior"]=-1;
			$_SESSION["suplantado"]=-1;
			$_SESSION["idUsr"]=$fila[0];
			$_SESSION["login"]=$fila[1];
			$_SESSION["nombreUsr"]=$fila[2];
			$_SESSION["statusCuenta"]=$fila[6];
			$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$fila[0];
			$resRoles=$con->obtenerFilas($consulta);
			$listaGrupo="";
			while($fRoles=mysql_fetch_row($resRoles))
			{
				$arrRol=explode("_",$fRoles[0]);
				$rol="'".$fRoles[0]."'";
				if($arrRol[1]!="0")
					$rol.=",'".$arrRol[0]."_-1'";
				
				if($listaGrupo=="")
					$listaGrupo=$rol;
				else
					$listaGrupo.=",".$rol;
			}
			if($listaGrupo=="")
				$listaGrupo='-1';
			$_SESSION["idRol"]=$listaGrupo.",'-100_0'";
			$_SESSION["codigoUnidad"]=$fila[4];
			$_SESSION["codigoInstitucion"]=$fila[3];
			
		}
		
		echo "1|";
	}
	
	function obtenerLiberiasFuncionesExternas()
	{
		global $con;
		global $baseDir;
		$dir = opendir($baseDir."/include/funcionesExternas");
    	$arrRegistros="";
		$numReg=0;
		while ($elemento = readdir($dir))
		{
        	if( $elemento != "." && $elemento != "..")
			{
            	if( !is_dir($dir."/".$elemento) )
				{
					$tiempo=fileatime($baseDir."/include/funcionesExternas/".$elemento);
                	$o='{"nombreArchivo":"'.cv($elemento).'","fechaSubida":"'.date("Y-m-d H:i:s",$tiempo).'","tamano":"'.filesize($baseDir."/include/funcionesExternas/".$elemento).'"}';
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
					$numReg++;
    	        } 
				
        	}
    	}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
?>