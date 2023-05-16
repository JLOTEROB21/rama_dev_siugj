<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	if($tipoMateria!="P")
		return;
?>

var cadenaFuncionValidacion='funcionPrepararGuardado';

function inyeccionCodigo()
{

	loadScript('../Scripts/funcionesAjaxV2.js', function()
                                                        {
                                                            
                                                        }
                        );

	
	if(esRegistroFormulario())
    {
    
    	setTimeout	(	function()
        			{
        
                       
                                                                    
                      
					
                    	if(gE('idRegistroG').value=='-1')
                        {
                             gEx('f_sp_fechaRecepciondte').setValue('<?php echo $fechaActual?>');
                             
                             gEx('f_sp_fechaRecepciondte').fireEvent('change', gEx('f_sp_fechaRecepciondte'), gEx('f_sp_fechaRecepciondte').getValue());
                             gEx('f_sp_fechaRecepciondte').fireEvent('select', gEx('f_sp_fechaRecepciondte'));
                             
                             gEx('f_sp_horaRecepciontme').setValue('<?php echo $horaActual?>');
                             gEx('f_sp_horaRecepciontme').fireEvent('change', gEx('f_sp_horaRecepciontme'), gEx('f_sp_horaRecepciontme').getValue());
                             
                            
                        }
                        else
                        {
                        	lanzarEvento('_categoriaAmparovch','change',gE('_categoriaAmparovch'));
                           
                        }
                        
                        lanzarEvento('_categoriaAmparovch','change',gE('_categoriaAmparovch'));
        				
                    
                    },1000
                	)
    
    
    	
    
    	
    }
    else
    {
    	if(gE('sp_7586').innerHTML=='Amparo cierto')
        {
        	oE('div_7603');
        }
        else
        {
        	oE('div_7597');
            oE('div_7598');
            oE('div_7599');
            oE('div_7600');
            oE('div_7601');
        }
    }

    
   
}

  


function funcionPrepararGuardado()
{
	var _categoriaAmparovch=gE('_categoriaAmparovch');
    if(_categoriaAmparovch.options[_categoriaAmparovch.selectedIndex].value=='2')
    {
    	if(gEx('grid_7603').getStore().getCount()==0)
        {
        	msgBox('Debe indicar almenos una unidad de gesti&oacute;n referida')
            return false;
        }
    }
	return true;                
    
}

function agregarParticipante()
{

	var iFiguraJuridica=gE('_figuraJuridicavch').options[gE('_figuraJuridicavch').selectedIndex].value;
    var cAdministrativa=gE('_carpetaAdministrativavch').value;
    var iActividad=-1;
    iActividad=gE('sp_7366').innerHTML;
    if(iActividad=='')
    	iActividad=-1;
    
    
    
    
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
                    ['idActividad',iActividad],
                    ['funcPHPEjecutarNuevo',bE('participanteAgregado(idRegPadre)')]
               ];
    abrirVentanaFancy(obj);
}


function participanteAgregado(iParticipante,nombre)
{
	
	var opt=cE('option');
    opt.value=iParticipante;
    opt.text=nombre;
	gE('_quejosovch').options[gE('_quejosovch').options.length]=opt;
    gE('_quejosovch').selectedIndex=gE('_quejosovch').options.length-1;
    
}              
              
function funcionValidarGuardado()
{
	
    return true;
}      

function accionCancelada()
{
	
    cerrarVentanaFancy();
}   