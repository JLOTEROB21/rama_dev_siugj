<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var tipoPaticipante;

function inyeccionCodigo()
{
	if(!esRegistroFormulario())
    {
    	
    	switch(gE('sp_6882').innerHTML)
        {
        	case 'Ministerio público':
            	oE('div_6884');
                mE('div_6888');
                oE('div_7020');
                oE('div_7022');
                oE('div_7021');
                oE('div_7023');
                oE('div_7024');
                
                oE('div_6885');
                oE('div_6886');
            break;
            case 'Oficina de PGJ':
            	oE('div_6888');
                oE('div_7020');
                oE('div_7022');
                oE('div_7021');
                oE('div_7023');
                oE('div_7024');
                oE('div_6884');
                oE('div_6885');
                oE('div_6886');
            break;
            case 'Otro':
            	oE('div_6888');
                mE('div_7020');
                mE('div_7022');
                mE('div_7021');
                mE('div_7023');
                mE('div_7024');
                mE('div_6885');
                mE('div_6886');
            break;
        }
    }
    else
    {
		if(gE('idRegistroG').value=='-1')
        {
            gEx('f_sp_fechaOrdendte').setValue('<?php echo date("Y-m-d")?>');
            gEx('f_sp_fechaOrdendte').fireEvent('change', gEx('f_sp_fechaOrdendte'), gEx('f_sp_fechaOrdendte').getValue());
        }
        
        asignarEvento(gE('opt_chkSinFechaAudienciaarr_1'),'click',function(chk)
                                                                    {
                                                                        if(chk.checked)
                                                                        {
                                                                        	mE('div_7394');
                                                                            mE('div_7395');
                                                                            gE('_motvoNOAudienicavch').setAttribute('val','obl');
                                                                            gE('_eventoAudienciavch').setAttribute('val','');
                                                                            
                                                                        }
                                                                        else
                                                                        {
                                                                        	oE('div_7394');
                                                                            oE('div_7395');
                                                                            gE('_motvoNOAudienicavch').setAttribute('val','');
                                                                            gE('_eventoAudienciavch').setAttribute('val','obl');
                                                                            
                                                                        }
                                                                    }
                    )
                    
                    
                    
		lanzarEvento(gE('opt_chkSinFechaAudienciaarr_1'),'click');  
        
        
        <?php  
		if(existeRol("'147_0'"))
		{
		?>
        	gE('_fechaEntregaOrdendte').setAttribute('val','');
            gE('oficio').setAttribute('val','');
            gE('resolucion').setAttribute('val','');
            gE('actaMinima').setAttribute('val','');
            gE('_fechaPrescripciondte').setAttribute('val','');
            gE('_ordenEntregadoAvch').setAttribute('val','');
            gE('_nombrevch').setAttribute('val','');
            gE('_apPaternovch').setAttribute('val','');
            
            gE('_ministerioPublicovch').setAttribute('val','');
            gE('_ministerioPublicovch').setAttribute('valaux','');
        <?php
		}
		?>                     
    }
}

function agregarImputado()
{
	var idActividad=gE('sp_7396').innerHTML;
    if((idActividad=='')||(idActividad=='-1'))
    {
    	msgBox('Primero debe seleccionar la carpeta administrativa al cual desea registar el imputado/sentenciado');
    	return;
    }
	tipoPaticipante=4;
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.modal=true;
    obj.url='../modeloPerfiles/registroFormularioV2.php';
    obj.funcionCerrar=function()
    				{
                    	
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
                    ['figuraJuridica','4'],
                    ['idActividad',idActividad],
                    ['funcPHPEjecutarNuevo',bE('participanteAgregado(idRegPadre)')]
               ];
    abrirVentanaFancy(obj);
}

function agregarMP()
{
	var idActividad=gE('sp_7396').innerHTML;
    
    if((idActividad=='')||(idActividad=='-1'))
    {
    	msgBox('Primero debe seleccionar la carpeta administrativa al cual desea registar el miniterio p&uacute;blico');
    	return;
    }
	tipoPaticipante=10;
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.modal=true;
    obj.url='../modeloPerfiles/registroFormularioV2.php';
    obj.funcionCerrar=function()
    				{
                    	
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
    if(tipoPaticipante==4)
    {
        gE('_imputadovch').options[gE('_imputadovch').options.length]=opt;
        gE('_imputadovch').selectedIndex=gE('_imputadovch').options.length-1;
	}
    else
    {
    	gE('_ministerioPublicovch').options[gE('_ministerioPublicovch').options.length]=opt;
        gE('_ministerioPublicovch').selectedIndex=gE('_ministerioPublicovch').options.length-1;
    }    

}              
              
  

function accionCancelada()
{
	
    cerrarVentanaFancy();
}        