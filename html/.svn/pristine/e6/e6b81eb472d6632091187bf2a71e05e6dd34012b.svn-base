<?php session_start();
	;
	include("funcionesFormularios.php"); 
	include("configurarIdioma.php");

	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			obtenerNombreEscuela();
		break;
		case 2:
			obtenerCP();
		break;
		case 3:
			buscarAlumno();
		break;

	}
		
		
	
	
	
	function obtenerNombreEscuela()
	{
		global $con;
		$iE=$_POST["iE"];
		$consulta="SELECT CONCAT('Clave: ',claveEscuela,', ',nombreEscuela) FROM _1051_tablaDinamica WHERE id__1051_tablaDinamica=".$iE;
		$nombreEscuela=$con->obtenerValor($consulta);
		echo "1|".$nombreEscuela;
	}
	
	function obtenerCP()
	{
		global $con;
		$iC=$_POST["iC"];
		$consulta="SELECT CONCAT('C.P. ',cp,', ',nombreColonia) FROM _1050_tablaDinamica WHERE id__1050_tablaDinamica=".$iC;
		$nombreColonia=$con->obtenerValor($consulta);
		echo "1|".$nombreColonia;
	}
	
	
	function buscarAlumno()
	{
		global $con;
		$valorBusqueda=$_POST["valorBusqueda"];
		$consulta="SELECT * FROM (SELECT idUsuario AS idAlumno,ApPat AS apPaterno,ApMat AS apMaterno,Nombre AS nombre,
					(SELECT CONCAT(gr.ordenGrado,g.nombreGrupo) FROM 4529_alumnos a,4540_gruposMaestros g,4501_Grado gr 
					WHERE g.idGrupoPadre=a.idGrupo AND a.idUsuario=t.idUsuario AND gr.idGrado=a.idGrado
					) AS grupo,CONCAT(ApPat,' ',ApMat,' ',Nombre) AS nombreAlumno FROM _1047_tablaDinamica t) AS tmp 
					WHERE  nombreAlumno LIKE '%".cv($valorBusqueda)."%' ORDER BY apPaterno,apMaterno,nombre";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
?>