<?php	session_start();
include("conexionBD.php");


$nombreFuncion=$_POST["_nombreFuncionvch"];
$descripcion=$_POST["_descripcionvch"];
$cadParametros=$_POST["cadParametros"];
$idFuncion=$_POST["idFuncion"];
$idCategoria=$_POST["_idCategoriaint"];
$archivoInclude=$_POST["_archivoIncludevch"];
$nombreFuncionPHP=$_POST["_nombreFuncionPHPvch"];

$conf=$_POST["conf"];
$x=0;
$consulta[$x]="begin";
$x++;
$reenviar=false;
if($idFuncion==-1)
{
	$consulta[$x]="INSERT INTO 9033_funcionesSistema(nombreFuncion,tipoFuncion,descripcion,fechaCreacion,responsableCreacion,nombreFuncionPHP,archivoInclude,idCategoria)
					VALUES('".cv($nombreFuncion)."',0,'".cv($descripcion)."','".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",'".cv($nombreFuncionPHP)."','".cv($archivoInclude)."',".$idCategoria.")";
	$x++;
	$consulta[$x]="set @idRegistro:=(select last_insert_id())";
	$x++;
	$arrParam=explode(",",$cadParametros);
	if(sizeof($arrParam)>0)
	{
		foreach($arrParam as $p)
		{
			$consulta[$x]="INSERT INTO 9034_parametrosFuncionesSistema(parametro,idFuncion) VALUES('".$p."',@idRegistro)";
			$x++;
		}
	}
}
else
{
	$consulta[$x]="update 9033_funcionesSistema set nombreFuncion='".cv($nombreFuncion)."',descripcion='".cv($descripcion)."',nombreFuncionPHP='".cv($nombreFuncionPHP)."',archivoInclude='".cv($archivoInclude)."',idCategoria=".$idCategoria." where idFuncion=".$idFuncion;
	$x++;
	$consulta[$x]="delete from  9034_parametrosFuncionesSistema where idFuncion=".$idFuncion;
	$x++;
	if($cadParametros!="")
	{
		$arrParam=explode(",",$cadParametros);
		if(sizeof($arrParam)>0)
		{
			foreach($arrParam as $p)
			{
				$consulta[$x]="INSERT INTO 9034_parametrosFuncionesSistema(parametro,idFuncion) VALUES('".$p."',".$idFuncion.")";
				$x++;
			}
		}
	}
}

$consulta[$x]="commit";
$x++;

if($con->ejecutarBloque($consulta))
	$reenviar=true;
?>


<html>
	<body>
    	<form method="post" action="../Sistema/tblFuncionesSistema.php" id="frmEnvio">
        	<input type="hidden" name="configuracion" value="<?php echo $conf?>">
        </form>
        <script>
			<?php
				if($reenviar)
				{
			?>
			document.getElementById('frmEnvio').submit();
			<?php
				}
			?>
		</script>
    </body>
</html>
