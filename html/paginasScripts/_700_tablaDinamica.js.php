<?php
	session_start();

	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");

	$lblFuncionVisualizacion='';
	$idFuncionVisualizacion=-1;
	if($idRegistro!=-1)
	{
		$consulta="SELECT idFuncionVisualizacion FROM _700_tablaDinamica WHERE id__700_tablaDinamica=".$idRegistro;
		$idFuncionVisualizacion=$con->obtenerValor($consulta);
		$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$idFuncionVisualizacion;
		$lblFuncionVisualizacion=$con->obtenerValor($consulta);
	}


?>
var ctrFuncion='<a href="javascript:agregarFuncionVisualizacion()"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionVisualizacion()"><img src="../images/cross.png"></a>';
var lblFuncionVisualizacion='<?php echo cv($lblFuncionVisualizacion)?>';
var idFuncionVisualizacion=<?php echo $idFuncionVisualizacion?>;


function inyeccionCodigo()
{
	gE('sp_11583').innerHTML='<?php echo $lblFuncionVisualizacion?> '+ctrFuncion;
    if(esRegistroFormulario())
    {
    	loadScript("../Scripts/dataConceptosAPI.js.php",function(){});
        loadScript("../Scripts/ux/grid/rowExpander.js",function(){});
        if(gE('idRegistroG').value=='-1')
        {
        	gEN('_idFuncionVisualizacionvch')[0].value=  idFuncionVisualizacion;
        }
        else
        {
        }
    }
    else
    {
    }
}


function agregarFuncionVisualizacion()
{

	var control=gEN('_idFuncionVisualizacionvch')[0];
	
    
    
    asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre,ventana)
                                            {
                                             	control.value=idConsulta;
                                                gE('sp_11583').innerHTML=nombre+' '+ctrFuncion;
                                                if(gEx('vAgregarExp'))
	                                                gEx('vAgregarExp').close();
                                            }
    mostrarVentanaExpresion(function(filaSelec,ventana)
    						{
                            	control.value=filaSelec.data.idConsulta;
                                gE('sp_11583').innerHTML=filaSelec.data.nombreConsulta+' '+ctrFuncion;
                            	
                                
                                ventana.close();
                            }
    						,true);
    
}


function removerFuncionVisualizacion()
{
	gEN('_idFuncionVisualizacionvch')[0].value=-1;
    gE('sp_11583').innerHTML=ctrFuncion;
}