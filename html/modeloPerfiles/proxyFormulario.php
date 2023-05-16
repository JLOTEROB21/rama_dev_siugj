<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");

$cPagina="";
if(isset($_POST["cPagina"]))
	$cPagina=$_POST["cPagina"];
$confReferencia="";
if(isset($_POST["confReferencia"]))
	$confReferencia=$_POST["confReferencia"];
$eJs="";
if(isset($_POST["eJs"]))
	$eJs=$_POST["eJs"];

$idFormulario="-1";
if(isset($_POST["idFormulario"]))
	$idFormulario=$_POST["idFormulario"];
$idRegistro="-1";
if(isset($_POST["idRegistro"]))
	$idRegistro=$_POST["idRegistro"];
$idReferencia="-1";
if(isset($_POST["idReferencia"]))
	$idReferencia=$_POST["idReferencia"];

$iFrame="";
if(isset($_POST["iFrame"]))
	$iFrame=$_POST["iFrame"];

$paginaRedireccion="";
if(isset($_POST["paginaRedireccion"]))
	$paginaRedireccion=$_POST["paginaRedireccion"];
	
$accion="";
if(isset($_POST["accion"]))
	$accion=base64_decode($_POST["accion"]);

$funcEjecutarNuevo="";
if(isset($_POST["funcEjecutarNuevo"]))
	$funcEjecutarNuevo=base64_decode($_POST["funcEjecutarNuevo"]);

$funcEjecutarModif="";
if(isset($_POST["funcEjecutarModif"]))
	$funcEjecutarModif=base64_decode($_POST["funcEjecutarModif"]);

$funcPHPEjecutarNuevo="";
if(isset($_POST["funcPHPEjecutarNuevo"]))
	$funcPHPEjecutarNuevo=base64_decode($_POST["funcPHPEjecutarNuevo"]);

$funcPHPEjecutarModif="";
if(isset($_POST["funcPHPEjecutarModif"]))
	$funcPHPEjecutarModif=base64_decode($_POST["funcPHPEjecutarModif"]);


$pagEnvio="";

$enviarFormulario=true;
if(isset($_POST["noEnvioFrm"]))
	$enviarFormulario=false;

$accionCancelar="";
if(isset($_POST["accionCancelar"]))
	$accionCancelar=bD($_POST["accionCancelar"]);
switch($accion)
{
	case "agregar":
		$consulta="select nombreTabla,frmRepetible,formularioBase from 900_formularios where idFormulario=".$idFormulario;
		$filaValor=$con->obtenerPrimeraFila($consulta);
		$nombreTabla=$filaValor[0];
		$repetible=$filaValor[1];
		$formularioBase=$filaValor[2];
		if($nombreTabla=="")
		{
			echo "El formulario seleccionado no tiene tabla asociada";
			return;
		}
		if($formularioBase=="0")
		{
			if($repetible=="1")
				$pagEnvio="../modeloPerfiles/tblFormularios.php";
			else
			{
				$consulta="select id_".$nombreTabla." from ".$nombreTabla." where idReferencia=".$idReferencia;
				
				$idRegistro=$con->obtenerValor($consulta);
				if($idRegistro=="")
				{
					$pagEnvio="../modeloPerfiles/registroFormulario.php";
					$idRegistro="-1";
				}
				else
					$pagEnvio="../modeloPerfiles/verFichaFormulario.php";
			}
		}
		else
		{
			$pagEnvio="../modeloPerfiles/verFichaFormulario.php";
		}
		
	break;
	case "modificar":
		$consulta="select nombreTabla,frmRepetible,formularioBase from 900_formularios where idFormulario=".$idFormulario;
		$filaValor=$con->obtenerPrimeraFila($consulta);
		$nombreTabla=$filaValor[0];
		$repetible=$filaValor[1];
		$formularioBase=$filaValor[2];
		if($nombreTabla=="")
		{
			echo "El formulario seleccionado no tiene tabla asociada";
			return;
		}
		if($formularioBase=="0")
		{
			if($repetible=="1")
				$pagEnvio="../modeloPerfiles/tblFormularios.php";
			else
			{
				$consulta="select id_".$nombreTabla." from ".$nombreTabla." where idReferencia=".$idReferencia;
				$idRegistro=$con->obtenerValor($consulta);
				if($idRegistro=="")
				{
					$pagEnvio="../modeloPerfiles/registroFormulario.php";
					$idRegistro="-1";
				}
				else
					$pagEnvio="../modeloPerfiles/registroFormulario.php";
			}	
		}
		else
		{
			$pagEnvio="../modeloPerfiles/registroFormulario.php";
		}
	break;
	case "ver":
	
		$consulta="select nombreTabla,frmRepetible,formularioBase from 900_formularios where idFormulario=".$idFormulario;
		$filaValor=$con->obtenerPrimeraFila($consulta);
		$nombreTabla=$filaValor[0];
		$repetible=$filaValor[1];
		$formularioBase=$filaValor[2];
		if($nombreTabla=="")
		{
			echo "El formulario seleccionado no tiene tabla asociada";
			return;
		}
		if($formularioBase=="0")
		{
			if($repetible=="1")
				$pagEnvio="../modeloPerfiles/tblFormularios.php";
			else
			{
				$consulta="select id_".$nombreTabla." from ".$nombreTabla." where idReferencia=".$idReferencia;
				$idRegistro=$con->obtenerValor($consulta);
				if($idRegistro=="")
				{
					$pagEnvio="../modeloPerfiles/sinRegistroFormulario.php";
					$idRegistro="-1";
				}
				else
					$pagEnvio="../modeloPerfiles/verFichaFormulario.php";
			}
		}
		else
		{
			$pagEnvio="../modeloPerfiles/verFichaFormulario.php";
		}
	break;
}
?>
<body>
	<form method="post" action="<?php echo $pagEnvio?>" id="frmEnvio">
    	<input type="hidden" name="confReferencia" value="<?php echo $confReferencia?>" />
        <input type="hidden" name="idFormulario" value="<?php echo $idFormulario?>" />
        <input type="hidden" name="idRegistro" value="<?php echo $idRegistro?>" />
        <input type="hidden" name="idReferencia" value="<?php echo $idReferencia?>" />
        <input type="hidden" name="accion" value="<?php echo base64_encode($accion)?>">
        <?php
		
			if($eJs!="")
			{
		?>
        		 <input type="hidden" name="eJs" value="<?php echo $eJs?>" />
        <?php
			}
		
			if($cPagina!="")
			{
		?>
        		 <input type="hidden" name="cPagina" value="<?php echo $cPagina?>" />
          
        <?php
			}
		
			if($paginaRedireccion!="")
			{
		?>
        		 <input type="hidden" name="paginaRedireccion" value="<?php echo $paginaRedireccion?>" />
        <?php
			}
		
			if($iFrame!="")
			{
		?>
        		 <input type="hidden" name="iFrame" value="<?php echo $iFrame?>" />
        <?php
			}
		
			if($funcEjecutarNuevo!="")
			{
		?>
        		 <input type="hidden" name="funcEjecutarNuevo" value="<?php echo $funcEjecutarNuevo?>" />
        <?php
			}
		
			if($funcEjecutarModif!="")
			{
		?>
        		 <input type="hidden" name="funcEjecutarModif" value="<?php echo $funcEjecutarModif?>" />
        <?php
			}
			
			if($funcPHPEjecutarNuevo!="")
			{
		?>
        		 <input type="hidden" name="funcPHPEjecutarNuevo" value="<?php echo $funcPHPEjecutarNuevo?>" />
        <?php
			}
			if($funcPHPEjecutarModif!="")
			{
		?>
        		 <input type="hidden" name="funcPHPEjecutarModif" value="<?php echo $funcPHPEjecutarModif?>" />
        <?php
			}
			
			if($accionCancelar!="")
			{
		?>
        		 <input type="hidden" name="accionCancelar" value="<?php echo $accionCancelar?>" />
        <?php
			}
		?>
    </form>
    <script>
		<?php
		if($enviarFormulario)
			echo "document.getElementById('frmEnvio').submit();";
		?>
	</script>
    
    
</body>
