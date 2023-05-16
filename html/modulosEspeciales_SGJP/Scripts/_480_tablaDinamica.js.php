<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	
	$fechaActual=date("Y-m-d");
	$horaActual=date("H:i");
	$bloqueado=1;
	if(existeRol("'1_0'"))
	{
		$bloqueado=0;
	}
	$codigoInstitucion=$_SESSION["codigoInstitucion"];
	
	
	
	
	
?>

var bloqueado='<?php echo $bloqueado?>';

var codigoInstitucion='<?php echo $codigoInstitucion?>';

var cadenaFuncionValidacion='prepararEnvio';

function inyeccionCodigo()
{
	if(esRegistroFormulario())
    {
    	
        if(gE('idRegistroG').value=='-1')
        {
            
            if(bloqueado=='1')
			{
				selElemCombo(gE('_juzgadovch'),""+codigoInstitucion);
				gE('_juzgadovch').disabled=true;
			}
            
            
        }
        
         
         
         
	}
    

}  

function prepararEnvio()
{
	gE('_juzgadovch').disabled=false;
	return true;
}


function verInformacionProceso()
{
	var idFormulario=gE('_procesoAsociadovch').options[gE('_procesoAsociadovch').selectedIndex].value;
    var idRegistro=-1;
    var control;
    switch(parseInt(idFormulario))
    {
    	case -1:
        	msgBox('Debe seleccionar el proceso con el cual se asocia la resoluci&oacute;n/acuerdo');
        	return;
        break;
    	case 96:
        	control='_registroPromocionesvch';
        break;
        case 501:
        	control='_registrosAmparovch';
        break;
        case 497:
        	control='_registrosApelacionesvch';
        break;
        case 509:
        	control='_registroValoresvch';
        break;
    }
    
    var combo=gE(control);
    
    if(combo.selectedIndex<0)
    {
    	msgBox('Debe seleccionar el registro del proceso con el cual se asocia la resoluci&oacute;n/acuerdo');
       	return;
    }
    
    idRegistro=combo.options[combo.selectedIndex].value;
    
    if(idRegistro=='-1')
    {
    	msgBox('Debe seleccionar el registro del proceso con el cual se asocia la resoluci&oacute;n/acuerdo');
       	return;
    }
    
    
    var obj={};
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.ancho='100%';
    obj.alto='100%';
    obj.params=	[['idFormulario',idFormulario],['idRegistro',idRegistro],['dComp','YXV0bw=='],['cPagina','sFrm=true'],['actor',bE(0)]];
    
    abrirVentanaFancy(obj);
    
    
}