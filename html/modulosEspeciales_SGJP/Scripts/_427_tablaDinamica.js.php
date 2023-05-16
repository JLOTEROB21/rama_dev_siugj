<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	$idParticipante=-1;
	if($idRegistro!=-1)
	{
		$consulta="SELECT ministerioPublico FROM _427_tablaDinamica WHERE id__427_tablaDinamica=".$idRegistro;	
		$idParticipante=$con->obtenerValor($consulta);
	}
	
	$consulta="SELECT  idActividad FROM _385_tablaDinamica WHERE id__385_tablaDinamica=".$idReferencia;

	$idActividadBase=$con->obtenerValor($consulta);
?>

var idActividadBase=<?php echo $idActividadBase?>;
var idParticipante=<?php echo $idParticipante?>;

var cadenaFuncionValidacion='funcionValidarGuardado';

function inyeccionCodigo()
{
	
	if(!esRegistroFormulario())
    {
    	
    }
    else
    {
       asignarEvento(gE('_ministerioPublicovch'),'change',buscarDomilicio)
	}
    
    gE('sp_6782').innerHTML='';
    loadScript('../modulosEspeciales_SGJP/Scripts/cDireccionContacto.js.php?iF=<?php echo $idFormulario?>&iR=<?php echo $idRegistro?>', function()
    																		{
                                                                            	
                                                                            	var obj={};
                                                                                obj.idParticipante=idParticipante;
                                                                                obj.renderTo='sp_6782';
                                                                                obj.permiteEditar=esRegistroFormulario();
                                                                                
                                                                                obj.beforeShowWindow=colapsarPanel;
                                                                                obj.afterCloseWindow=restaurarPanel;
                                                                                
                                                                                construirTableroDireccion(obj);
                                                                            }
				)
   
}  

function buscarDomilicio()
{
	var cmb=gE('_ministerioPublicovch');
    var obj={};
    obj.idParticipante=cmb.options[cmb.selectedIndex].value;
    obj.renderTo='sp_6782';
    obj.permiteEditar=esRegistroFormulario();
    obj.beforeShowWindow=colapsarPanel;
    obj.afterCloseWindow=restaurarPanel;
    construirTableroDireccion(obj);
    
}

function agregarParticipante()
{
	
    
    colapsarPanel();
	var obj={};
    
    obj.ancho='100%';
    obj.alto='100%';
    obj.modal=true;
    obj.url='../modeloPerfiles/registroFormularioV2.php';
    obj.funcionCerrar=function()
    				{
                    	restaurarPanel();
                    }
    obj.params=[
    				['accionCancelar','window.parent.accionCancelada()'],
                    ['cPagina','sFrm=true'],
                    ['pM','1'],
                    ['pE','1'],
                    ['actor','MTAx'],
                    ['idFormulario','47'],
                    ['idReferencia','-1'],
                    ['idRegistro','-1'],
                    ['figuraJuridica','10'],
                    ['idActividad',idActividadBase],
                    ['funcPHPEjecutarNuevo',bE('participanteAgregado(idRegPadre)')]
               ];
    abrirVentanaFancy(obj);
}

function colapsarPanel()
{
	window.parent.gEx('panelListadoRegistros').setHeight(1);
    window.parent.gEx('vContenedor').doLayout();
}

function restaurarPanel()
{
	window.parent.gEx('panelListadoRegistros').setHeight(220);
    window.parent.gEx('vContenedor').doLayout();
}

function participanteAgregado(iParticipante,nombre)
{
	restaurarPanel();
	var opt=cE('option');
    opt.value=iParticipante;
    opt.text=nombre;
	gE('_ministerioPublicovch').options[gE('_ministerioPublicovch').options.length]=opt;
    gE('_ministerioPublicovch').selectedIndex=gE('_ministerioPublicovch').options.length-1;
    buscarDomilicio();
}              
              
function funcionValidarGuardado()
{
	if(gE('lblEstado').innerHTML=='')
    {
    	msgBox('Debe ingresar la &uacute;ltima direcci&oacute;n de contacto');
    	return false;
    }
    
    return true;
}      

function accionCancelada()
{
	restaurarPanel();
    cerrarVentanaFancy();
}        