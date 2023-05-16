<?php session_start();
	include("conexionBD.php"); 
	$abreviatura=$_POST["_abreviaturavch"];
	$descripcionvch=$_POST["_descripcionvch"];
	$nombreComitevch=$_POST["_nombreComitevch"];
	$tipoEvaluacion=$_POST["cmbTipoEvaluación"];
	$idComite=$_POST["idComite"];
	$etiqueta=$_POST["_etiquetavch"];
	$pagRedireccion=$_POST["pagRedireccion"];
	$query="begin";
	$x=0;
	if($con->ejecutarConsulta($query))
	{
		if($idComite=="-1")
		{
			$query="insert into 4084_unidadesRoles(unidadRol,fechaCreacion,responsable,idCategoria) values('".cv($nombreComitevch)."','".date('Y-m-d')."',".$_SESSION["idUsr"].",2)";
			if(!$con->ejecutarConsulta($query))
				return;
			$idUnidadRol=$con->obtenerUltimoID();
			
			$consulta[$x]="insert into 2006_comites(nombreComite,abreviatura,descripcion,tipoEvaluacion,idUnidadRol,etiqueta) values('".cv($nombreComitevch)."','".cv($abreviatura)."','".cv($descripcionvch)."',".$tipoEvaluacion.",".$idUnidadRol.",'".$etiqueta."')";		
			$x++;
			
			
		}
		else
		{
			$query="select idUnidadRol from 2006_comites where idComite=".$idComite;
			$idUnidadRol=$con->obtenerValor($query);
			$consulta[$x]="update 4084_unidadesRoles set unidadRol='".cv($nombreComitevch)."' where idUnidadesRoles=".$idUnidadRol;		
			$x++;	
			$consulta[$x]="update 2006_comites set nombreComite='".cv($nombreComitevch)."',abreviatura='".cv($abreviatura)."',descripcion='".cv($descripcionvch)."',tipoEvaluacion='".$tipoEvaluacion."', etiqueta='".$etiqueta."' where idComite=".$idComite;		
			$x++;	
				
		}
	}
	else
		return;
		
	
	$consulta[$x]="commit";
	$x++;
	
	if($con->ejecutarBloque($consulta))
	{
		
		if($idComite!="-1")
			header("location:".$pagRedireccion);		
		else
		{
			$idComiteN=$con->obtenerUltimoID();
?>
			<body>
			<form action="comites.php" id="frmEnvio" method="post">
            	<input type="hidden" name="idComite" value="<?php echo $idComiteN ?>" />
            </form>
            
            <script>
				document.getElementById('frmEnvio').submit();
			</script>
            </body>
<?php			
		}
	}
?>