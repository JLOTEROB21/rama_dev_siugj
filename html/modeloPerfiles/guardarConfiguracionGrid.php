<?php include("sesiones.php");
include("conexionBD.php"); 

	$idFormulario=$_POST["idFormulario"];
	$nombreConf=$_POST["nombreConf"];
	$txtDescripcion=$_POST["txtDescripcion"];
	$arrRoles=$_POST["idRol"];
	$idConfiguracion=$_POST["idConfiguracion"];
	$ct=sizeof($arrRoles);
	$consulta="begin";
	$enviar=false;
	$hConf="";
	if($con->ejecutarConsulta($consulta))
	{
		if($idConfiguracion=="-1")
		{
			$consulta="insert into 909_configuracionTablaFormularios(nombreConfiguracion,descripcion,idFormulario) values('".cv($nombreConf)."','".cv($txtDescripcion)."',".$idFormulario.")";	
			$pagRedireccion="../formularios/configuracionesGrid.php";
		}
		else
		{
			$consulta="update 909_configuracionTablaFormularios set nombreConfiguracion='".cv($nombreConf)."',descripcion='".cv($txtDescripcion)."' where idConfGrid=".$idConfiguracion;
			$pagRedireccion="../formularios/tblListadoConfiguracionesGrid.php";
		}
		
		if($con->ejecutarConsulta($consulta))
		{
			if($idConfiguracion=="-1")
			{
				$idConfiguracion=$con->obtenerUltimoID();	
				$hConf="<input type='hidden' name='idConfiguracion' value='".$idConfiguracion."'>";
			}
			
			$nCon=0;
			$query[$nCon]="delete from 915_confGridVSRol where idConfGrid=".$idConfiguracion;
			$nCon++;
			for($x=0;$x<$ct;$x++)
			{
				$query[$nCon]="insert into 915_confGridVSRol(idConfGrid,idRol) values(".$idConfiguracion.",".$arrRoles[$x].")";
				$nCon++;
			}
			
			$query[$nCon]="commit";
			$nCon++;

			if($con->ejecutarBloque($query))
			{
				$enviar=true;
			}
		}
	}
?>

<body>
	<form action="<?php echo $pagRedireccion?>" method="post" id="frmEnvio">
    	<input type="hidden" name="idFormulario" value="<?php echo $idFormulario?>" />
        <?php echo $hConf?>
    </form>
    <script>
		<?php
			if($enviar==true)
			{
				echo "document.getElementById('frmEnvio').submit()";
			}
		?>
	
	
	</script>
    
    
</body>
