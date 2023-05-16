<?php
	include("conexionBD.php"); 
	
	$descripcion=$_POST["_descripcionvch"];
	$nombreP=$_POST["_nombrePerfilvch"];
	$elementos=$_POST["hElementos"];
	$idPerfil=$_POST["idPerfil"];
	
	$x=0;
	$query="begin";
	$reenviar=false;
	if($con->ejecutarConsulta($query))
	{
		if($idPerfil=="-1")
		{
			$query="insert into 952_perfilesParticipacionAutores(nombrePerfil,descripcion) value('".cv($nombreP)."','".cv($descripcion)."')";
			if(!$con->ejecutarConsulta($query))
				return;
			
			$idPerfil=$con->obtenerUltimoID();
		}
		else
		{
			$consulta[$x]="update 952_perfilesParticipacionAutores set nombrePerfil='".cv($nombreP)."' , descripcion='".cv($descripcion)."' where idPerfilParticipacionAutor=".$idPerfil;
			$x++;
		}
		
		
		$consulta[$x]="delete from 953_elementosPerfilesParticipacionAutor where idPerfilAutor=".$idPerfil;
		$x++;
		
		$arrElementos=explode("@!",$elementos);
		$nElementos=sizeof($arrElementos);
		for($ct=0;$ct<$nElementos;$ct++)
		{
			$arrValorElemento=explode("|",$arrElementos[$ct]);
			$consulta[$x]="insert into 953_elementosPerfilesParticipacionAutor(idPerfilAutor,clave,descParticipacion) values(".$idPerfil.",'".cv($arrValorElemento[0])."','".cv($arrValorElemento[1])."')";
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			$reenviar=true;
		
		
		
	}
	
	
?>

<body>
	<form action="../modeloProyectos/tblConfiguracionesModuloAutores.php" method="post" id='frmEnvio' >
    </form>
    <script>
		<?php
			if($reenviar)
				echo "document.getElementById('frmEnvio').submit();";
		?>
		
	</script>
    
</body>