<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
?>

var IDActividad=-1;
var cadenaFuncionValidacion='funcionPrepararGuardado';

function inyeccionCodigo()
{

	loadScript('../Scripts/funcionesAjaxV2.js', function()
                                                        {
                                                            
                                                        }
                        );

	
	if(esRegistroFormulario())
    {
    	IDActividad=gE('sp_7621').innerHTML.replace(/'/gi,'');
        
    	setTimeout	(	function()
                        {
            				asignarEvento(gE('opt_chkOtroarr_1'),'click',function(chk)
                                                                          {
                                                                              
                                                                              if(chk.checked)
                                                                              {
                                                                                  
                                                                                  oE('div_7614');
                                                                                  oE('div_7627');
                                                                                  gE('_quejosovch').setAttribute('val','');
                                                                                  
                                                                                  gE('_nombrevch').setAttribute('val','obl');
                                                                                 
                                                                                  gE('_apPaternovch').setAttribute('val','obl');
                                                                                  
                                                                                  /*gE('_figuraJuridicavch').selectedIndex=-1;
                                                                                  gE('_figuraJuridicavch').setAttribute('val','');
                                                                                  gE('_figuraJuridicavch').disabled=true;*/
                                                                                  
                                                                                  mE('div_7615');
                                                                                  mE('div_7616');
                                                                                  mE('div_7617');
                                                                                  mE('div_7618');
                                                                                  mE('div_7619');
                                                                                  mE('div_7620');
                                                                                  
                                                                              }
                                                                              else
                                                                              {	
                                                                                  
                                                                                  mE('div_7614');
                                                                                  oE('div_7627');
                                                                                  gE('_quejosovch').setAttribute('val','obl');
                                                                                  
                                                                                  gE('_nombrevch').setAttribute('val','');
                                                                                  
                                                                                  gE('_apPaternovch').setAttribute('val','');
                                                                                  
                                                                                  if(gE('idRegistroG').value=='-1')
                                                                                  {
                                                                                      gE('_nombrevch').value='';
                                                                                      gE('_apPaternovch').value='';
                                                                                      gE('_apMaternovch').value='';
																					}                                                                                  
                                                                                  oE('div_7615');
                                                                                  oE('div_7616');
                                                                                  oE('div_7617');
                                                                                  oE('div_7618');
                                                                                  oE('div_7619');
                                                                                  oE('div_7620');
                                                                                  
                                                                                  /*gE('_figuraJuridicavch').setAttribute('val','obl');
                                                                                  gE('_figuraJuridicavch').disabled=false;*/
                                                                                  
                                                                              }
                                                                           }
                                     )
                        
                        	lanzarEvento('opt_chkOtroarr_1','click',gE('opt_chkOtroarr_1')); 
                        
                        },1000
                	)
    
    
		    	
    
    	
    }
    else
    {
    	oE('div_7622');
    	if(gEN('sp_7622').length>0 && gEN('sp_7622')[0].innerHTML=='Otro')
        {
        	oE('div_7614');
        }
        else
        {
        	oE('div_7615');
            oE('div_7616');
            oE('div_7617');
            oE('div_7618');
            oE('div_7619');
            oE('div_7620');
        }
    }

    
   
}

  


function funcionPrepararGuardado()
{
	if(gEx('grid_7612').getStore().getCount()==0)
    {
        msgBox('Debe indicar almenos un acto reclamado')
        return false;
    }
    
	return true;                
    
}

function agregarParticipante()
{

	var iFiguraJuridica=gE('_figuraJuridicavch').options[gE('_figuraJuridicavch').selectedIndex].value;
    
   
    
    
    
    
    if(iFiguraJuridica=='-1')
    {
    	msgBox('Debe indicar el tipo de figura jur&iacute;dica a agregar');
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
                    ['idActividad',IDActividad],
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