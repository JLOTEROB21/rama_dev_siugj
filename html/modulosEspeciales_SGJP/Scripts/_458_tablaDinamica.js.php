<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	$consulta="SELECT carpetaApelacion FROM _451_tablaDinamica WHERE id__451_tablaDinamica=".$idReferencia;
	$cApelacion=$con->obtenerValor($consulta);
	
	$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cApelacion."'";
	$idActividad=$con->obtenerValor($consulta);
	
	if($idActividad=="")
		$idActividad=-1;
	
?>
var idActividad='<?php echo $idActividad?>';
var cApelacion='<?php echo $cApelacion?>';


var cadenaFuncionValidacion='funcionValidarGuardado';

function inyeccionCodigo()
{
	
	if(!esRegistroFormulario())
    {
    	
    }
    else
    {
    	if(cApelacion!='')
        {
           gEx('ext__carpetaAdministrativavch').setValue(cApelacion);
           gEx('ext__carpetaAdministrativavch').disable();
           gE('_carpetaAdministrativavch').value=cApelacion;
        }
        
        
        
	}
    
    
   
}  



function agregarParticipante()
{

	var iFiguraJuridica=gE('_figuraJuridicavch').options[gE('_figuraJuridicavch').selectedIndex].value;
    var cAdministrativa=gE('_carpetaAdministrativavch').value;
    var iActividad=-1;
    
    if((gE('idRegistroG').value=='-1')&&(idActividad!='-1'))
    {
    	iActividad=idActividad;
    }
    else
    {
    	iActividad=gE('sp_7325').value;
    }
    
    
    if(iFiguraJuridica=='-1')
    {
    	msgBox('Debe indicar el tipo de figura jur&iacute;dica a agregar');
    	return;
    }
    
    if(cAdministrativa=='-1')
    {
    	msgBox('Debe indicar la carpeta judicial al cual pertenece el apelante a agregar');
    	return;
    }
    
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.modal=true;
    obj.url='../modeloPerfiles/registroFormularioV2.php';
    
    obj.params=[
    				['accionCancelar','window.parent.accionCancelada()'],
                    ['cPagina','sFrm=true'],
                    ['pM','1'],
                    ['pE','1'],
                    ['actor','MTAx'],
                    ['idFormulario','47'],
                    ['idReferencia','-1'],
                    ['idRegistro','-1'],
                    ['figuraJuridica',iFiguraJuridica],
                    ['idActividad',idActividad],
                    ['funcPHPEjecutarNuevo',bE('participanteAgregado(idRegPadre)')]
               ];
    abrirVentanaFancy(obj);
}


function participanteAgregado(iParticipante,nombre)
{
	
	var opt=cE('option');
    opt.value=iParticipante;
    opt.text=nombre;
	gE('_nombrePromoventevch').options[gE('_nombrePromoventevch').options.length]=opt;
    gE('_nombrePromoventevch').selectedIndex=gE('_nombrePromoventevch').options.length-1;
    
}              
              
function funcionValidarGuardado()
{
	
    return true;
}      

function accionCancelada()
{
	
    cerrarVentanaFancy();
}        