<?php	session_start(); 
	include("conexionBD.php"); $idEU= $_GET["idEtapasVsUsuarios"];
	$idp= $_GET["idProceso"];
	$idEtapa= $_GET["idEtapa"];
		
		$eliminar="delete from 4038_etapasVsUsuarios where idEtapasVsUsuarios='$idEU'";
		$resultado=$con->ejecutarConsulta($eliminar);
?>
<title>
 </title>
 <body>
 <form method="post" action="procesos.php" id="frmEnvio">
            <input type="hidden" name="idEtapasVsUsuarios" value="<?php echo $idEU ?>"/>
            <input type="hidden" name="idProceso" value="<?php echo $idp?>"/>
  
						<input type="hidden" name="pagRedireccion" value="../programaAcademico/procesos.php"/>           
        </form>
        <script language="javascript">
            document.getElementById('frmEnvio').submit();
        </script>


 </body>