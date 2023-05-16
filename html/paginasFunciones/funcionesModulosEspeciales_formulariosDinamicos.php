<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	include_once("sgjp/libreriaFunciones.php");

	
	;
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			obtenerUnidadAtencionViolenciaGenero();
		break;
		case 2:
			obtenerInmueblesTipoCarpeta();
		break;
		case 3:
			obtenerUGASInmueblesTipoCarpeta();
		break;
		case 4:
			obtenerJuecesAsignacionGuardia();
		break;
		case 5:
			obtenerJuecesGuardiaAsignados();
		break;
		
		
	}
	
	function obtenerUnidadAtencionViolenciaGenero()
	{
		global $con;
		$carpetaAdministrativa=$_POST["cA"];
		
		$consulta="SELECT u.id__17_tablaDinamica FROM 7006_carpetasAdministrativas c,_17_tablaDinamica u WHERE 
					c.carpetaAdministrativa='".$carpetaAdministrativa."' AND u.claveUnidad=c.unidadGestion";
		$idUGAOrigen=$con->obtenerValor($consulta);
		
		$consulta="SELECT jU.idReferencia FROM 7007_contenidosCarpetaAdministrativa con,7000_eventosAudiencia e,
				7001_eventoAudienciaJuez eJ,_26_tablaDinamica jU 
				WHERE con.carpetaAdministrativa='".$carpetaAdministrativa."' AND con.tipoContenido=3 AND 
				e.idRegistroEvento=con.idRegistroContenidoReferencia AND eJ.idRegistroEvento=e.idRegistroEvento
				AND jU.usuarioJuez=eJ.idJuez AND jU.idReferencia<>".$idUGAOrigen;
		$idUnidad=$con->obtenerValor($consulta);
		
		
		if($idUnidad=="")
			$idUnidad=-1;
		echo "1|".$idUnidad;
		
	}
	
	
	function obtenerInmueblesTipoCarpeta()
	{
		global $con;
		$tipoUnidad=$_POST["tipoUnidad"];
		$iUA=$_POST["iUO"];
		
		$consulta="SELECT u.idReferencia FROM _17_tablaDinamica u WHERE u.claveUnidad='".$iUA."'";
		$idInmuebleOrigen=$con->obtenerValor($consulta);
		if($idInmuebleOrigen=="")
			$idInmuebleOrigen=-1;
		$consulta="SELECT DISTINCT i.valor,i.contenido FROM _17_tablaDinamica u,
					_17_tiposCarpetasAdministra tC,902_opcionesFormulario i WHERE 
					tC.idPadre=u.id__17_tablaDinamica AND tC.idOpcion=".$tipoUnidad." AND 
					i.valor=u.idReferencia and idGrupoElemento=9622 and id__17_tablaDinamica 
					not in(49,50,52) and i.valor<>".$idInmuebleOrigen." ORDER BY contenido";
		$arrInmuebles=$con->obtenerFilasArreglo($consulta);					
		echo "1|".$arrInmuebles;
		
	}
	
	
	function obtenerUGASInmueblesTipoCarpeta()
	{
		global $con;
		$tipoUnidad=$_POST["tipoUnidad"];
		$inmueble=$_POST["inmueble"];
		
		$consulta="SELECT u.id__17_tablaDinamica FROM _17_tablaDinamica u,
					_17_tiposCarpetasAdministra tC WHERE 
					tC.idPadre=u.id__17_tablaDinamica AND tC.idOpcion=".$tipoUnidad.
					" and u.idReferencia=".$inmueble." and id__17_tablaDinamica not in(49,50,52)";
		$idUGAS=$con->obtenerListaValores($consulta);	
		if($idUGAS=="")
			$idUGAS="-1";
		
		$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica IN(".$idUGAS.
					") and id__17_tablaDinamica not in(49,50,52) order by prioridad";
		$nombreUgas=$con->obtenerListaValores($consulta);
						
		echo "1|".$nombreUgas."|".$idUGAS;
		
	}
	
	function obtenerJuecesAsignacionGuardia()
	{
		global $con;
		$criterio=$_POST["criterio"];
		
		
		 
		$consulta="SELECT  * FROM(SELECT j.clave AS noJuez,uG.nombreUnidad AS nombreUnidadGestion,j.usuarioJuez AS idJuez,
					(SELECT Nombre FROM 800_usuarios WHERE idUsuario=j.usuarioJuez) AS nombreJuez,
					CONCAT('[',j.clave,'] ',(SELECT Nombre FROM 800_usuarios WHERE idUsuario=j.usuarioJuez),' (',uG.nombreUnidad,')') AS lblEtiqueta,
					uG.id__17_tablaDinamica as idUnidadGestion					
					FROM _26_tablaDinamica j,_17_tablaDinamica uG,_26_tipoJuez tJ WHERE j.idReferencia=uG.id__17_tablaDinamica
					AND tJ.idPadre=j.id__26_tablaDinamica AND tJ.idOpcion=1 AND j.usuarioJuez <>-1 AND j.usuarioJuez IS NOT NULL
					AND uG.tipoMateria=1 ) AS tmp WHERE lblEtiqueta LIKE '%".$criterio."%'  ORDER BY noJuez";
	
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function obtenerJuecesGuardiaAsignados()
	{
		global $con;

		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
	
		$consulta="SELECT idJuez,noJuez,idUnidadGestion as nombreUnidadGestion,(SELECT Nombre FROM  800_usuarios WHERE idUsuario=idJuez) AS nombreJuez 
				FROM _624_juecesGuardia WHERE idReferencia=".$idRegistro." ORDER BY noJuez";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
?>