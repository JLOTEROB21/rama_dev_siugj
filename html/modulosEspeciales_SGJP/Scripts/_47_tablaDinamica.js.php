<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	$esRegistroAdolescentes=esRegistroAdolescentes($idFormulario,$idRegistro);
?>

var esRegistroAdolescentes=<?php echo $esRegistroAdolescentes?>;
var cadenaFuncionValidacion='prepararFormulario';

function inyeccionCodigo()
{
	var figuraJuridica=gEN('_figuraJuridicavch')[0].value;
	if(esRegistroFormulario())
    {

        asignarEvento('opt_tipoPersonavch_1','click',function()
                                                        {
                                                            gE('sp_992').innerHTML='Nombre';
                                                            gE('_nombrevch').setAttribute('size',40);
                                                            gE('_nombrevch').focus();
                                                        }
                    );
        asignarEvento('opt_tipoPersonavch_2','click',function()
                                                        {
                                                            gE('sp_992').innerHTML='Raz&oacute;n social';
                                                            gE('_nombrevch').setAttribute('size',90);
                                                            gE('_nombrevch').focus();
                                                        }
         
                       );
                       
        var fechaNacimiento=gEx('f_sp_fechaNacimientodte');
        if(fechaNacimiento)
        {
            fechaNacimiento.on('change',function()
                                        {
                                            calcularEdad()
                                        }
                              )
        }    
        
        
        if(gE('idRegistroG').value=='-1')
        {
        	gE('opt_esMexicanovch_1').checked=true;
            
            lanzarEvento(gE('opt_esMexicanovch_1'),'click',gE('opt_esMexicanovch_1'));
        	
            gE('opt_esMexicanovch_1').checked=false;
        	
        }
        
        if(figuraJuridica=='13')
        {
        	mE('div_6721');
            mE('div_6723');
            mE('div_6722');
            mE('div_6725');
            mE('div_6724');
            if(gEx('grid_6726'))
	            gEx('grid_6726').show();
            
            //gE('_relacionMenorvch').setAttribute('val','obl');
        }
        else
        {
        	oE('div_6721');
            oE('div_6723');
            oE('div_6722');
            oE('div_6725');
            oE('div_6724');
            if(gEx('grid_6726'))
            {
                oE('div_6726');
                gEx('grid_6726').hide();
            }
            //gE('_relacionMenorvch').setAttribute('val','');
        }
        
        
	} 
    else
    {
    	if(gE('sp_1016'))
        {
            if((gE('sp_1016').innerHTML=='No especificada')||(gE('sp_1016').innerHTML=='Sí'))
            {
                oE('div_827');
                
            }
        }
        
        if(gE('sp_822'))
        {
            if((gE('sp_822').innerHTML=='INDETERMINADO')||(gE('sp_822').innerHTML=='SIN IDENTIFICACION')||(gE('sp_822').innerHTML=='NO QUISO CONTESTAR'))
            {
                oE('div_823');
                
            }
         }   
        
        if(figuraJuridica=='13')
        {
        	mE('div_6721');
            mE('div_6723');
            mE('div_6722');
            mE('div_6725');
            mE('div_6724');
            if(gEx('grid_6726'))
           	 	gEx('grid_6726').show();
            
            //gE('_relacionMenorvch').setAttribute('val','obl');
        }
        else
        {
        	oE('div_6721');
            oE('div_6723');
            oE('div_6722');
            oE('div_6725');
            oE('div_6724');
            oE('div_6726');
            if(gEx('grid_6726'))
	            gEx('grid_6726').hide();
            //gE('_relacionMenorvch').setAttribute('val','');
        }
        
    } 
    
    if((esRegistroAdolescentes==1)&&(figuraJuridica=='4'))
	    gE('sp_1880').innerHTML='Menor';
        
    
    if(gE('_personasAsociaarr')||gE('span_[personasAsocia]arr'))
    {
    	oE('div_7571');
        oE('div_7573');
    	gE('sp_7570').innerHTML='Esta persona se relaciona como '+gE('sp_1880').innerHTML.toLowerCase()+' de:'
    	var mostrarPersonasAsocia=false;
    	var listaTipoAsociacion=gE('sp_7571').innerHTML;

    	if(listaTipoAsociacion!='')
        {
        	mE('div_7570');
            mE('div_7572');
            mE('tbl_personasAsociaarr');
            if(gE('sp_7573').innerHTML=='0')
            	gE('_personasAsociaarr').setAttribute('val','');
        }
        else
        {
        	oE('div_7570');
            oE('div_7572');
            oE('tbl_personasAsociaarr');
            gE('_personasAsociaarr').setAttribute('val','');
        }
    }
        
        
}



function calcularEdad()
{
	var fechaNacimiento=gEx('f_sp_fechaNacimientodte');
    
    
    var edad=0;
    
    var fechaActual=Date.parseDate('<?php echo date("Y-m-d")?>','Y-m-d');
    
    fechaNacimiento=fechaNacimiento.getValue();
    
    fechaCumpleados=Date.parseDate(fechaActual.format("Y")+'-'+fechaNacimiento.format('m-d'),'Y-m-d');
    
    edad=parseInt(fechaActual.format('Y'))-parseInt(fechaNacimiento.format('Y'));
    if(fechaCumpleados>fechaActual)
    {
    	edad--;
    }
    
    
    
    gE('_edadint').value=edad;
}


function prepararFormulario()
{
	gE('_edadint').disabled=false;
    return true;
}