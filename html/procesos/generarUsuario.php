<?php	session_start(); 
	include("conexionBD.php");
	$ide= $_GET["idEtapasVsUsuarios"];
	$idetapa= $_GET["idEtapa"];
	$idp= $_GET["idProceso"];
	$idu= $_GET["idUsuario"];
	try
	{
		if($ide==-1)
		{
			
			$guardar="insert into 4038_etapasVsUsuarios(idProceso,idEtapa,idUsuario)values('".$idp."','".$idetapa."','".$idu."')";
			$resultado=$con->ejecutarConsulta($guardar);
			$ielemento=$con->obtenerUltimoID();
		}
		else
		{
			$modificar="update 4038_etapasVsUsuarios set idUsuario='".$idu."' where idEtapasVsUsuarios='".$idelemento."'";
			$resultado=$con->ejecutarConsulta($modificar);
			$ielemento=$ide;
		  }
		  $res=1;
	}
	catch(Exception $e)
	{
		$res=-1;
		echo $e->getMessage();
	}
	
 ?>
 <title>
 </title>
 <body>
 	<?php
		if($res==1)
		{
	?>
        <form method="post" action="procesos.php" id="frmEnvio">
            <input type="hidden" name="idEtapasVsUsuarios" value="<?php echo $ielemento ?>"/>
            
            <input type="hidden" name="idProceso" value="<?php echo $idp?>"/>
  
						<input type="hidden" name="pagRedireccion" value="../programaAcademico/procesos.php"/>
            
        </form>
        <script language="javascript">
           document.getElementById('frmEnvio').submit();
        </script>
    <?php
		}
	?>
 </body>