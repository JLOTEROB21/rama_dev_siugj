<?php session_start();
	include("conexionBD.php");
	include_once("SIUGJ/libreriaFuncionesIntegraciones.php");
	
	aperturarSesionUsuario(2);
					
	$fechaBase=date("Y-m-d");
	if(isset($_GET["fechaBase"]))
		$fechaBase=$_GET["fechaBase"];
	
	//$fechaReferencia=date("Y-m-d",strtotime("-1 days",strtotime($fechaBase)));
	$fechaReferencia=date("Y-m-d",strtotime($fechaBase));
	if(isset($_GET["fechaReferencia"]))
		$fechaReferencia=$_GET["fechaReferencia"];
	$consulta="SELECT COUNT(*) FROM _1283_tablaDinamica WHERE fechaAplicacion='".$fechaBase."' AND cmbMoneda=2";
	$numReg=$con->obtenerValor($consulta);
	if($numReg==0)
	{

		$precioDivisa=buscarPrecioDolar($fechaReferencia);
		if($precioDivisa)
		{
			$arrDocumentos=array();
			$arrValores=array();
			$arrValores["cmbMoneda"]=2;
			$arrValores["tipoCambio"]=$precioDivisa;
			$arrValores["fechaAplicacion"]=$fechaBase;

			


			$idRegistroInstancia=crearInstanciaRegistroFormulario(1283,-1,2,$arrValores,$arrDocumentos,-1,0);
		}
	}
	session_destroy();
	
?>
