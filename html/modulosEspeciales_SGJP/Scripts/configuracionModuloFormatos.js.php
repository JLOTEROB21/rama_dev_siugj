<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


function cancelarOperacion()
{
	function resp(btn)
    {
    	if(btn=='yes')
        {
        	window.parent.cerrarVentanaFancy();
        }
    }
    msgConfirm('Est&aacute; seguro de querer salir de la configuraci&oacute;n del m&oacute;dulo?',resp);
}


function mostrarVentanaFuncionSistema()
{
	
    asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre,ventana)
                                            {
                                             	gE('lblFuncionAsignadora').innerHTML=nombre;
                                                gE('_funcionDefinicionFormatoint').value=idConsulta;
                                                
                                                if(gEx('vAgregarExp'))
	                                                gEx('vAgregarExp').close();
                                            }
    mostrarVentanaExpresion(function(filaSelec,ventana)
    						{
                            	gE('lblFuncionAsignadora').innerHTML=filaSelec.data.nombreConsulta;
                                gE('_funcionDefinicionFormatoint').value=filaSelec.data.idConsulta;
                                ventana.close();
                            }
    						,true);
    
}


function removerFuncion()
{
	gE('lblFuncionAsignadora').innerHTML='(No asignado)';
    gE('_funcionDefinicionFormatoint').value=''
}

function funcionFormatoChange(cmb)
{
	var valor=cmb.options[cmb.selectedIndex].value;
    if(valor=='1')
    {
    	mE('filaFormatoProceso');
        gE('_idFormatoint').setAttribute('val','obl');
        gE('_funcionDefinicionFormatoint').setAttribute('val','');
        oE('filaFuncionAsignadora');
        gE('lblFuncionAsignadora').innerHTML='(No asignado)';
        gE('_funcionDefinicionFormatoint').value='';
        
    }
    else
    {
    	mE('filaFuncionAsignadora');
        oE('filaFormatoProceso');
        gE('_idFormatoint').setAttribute('val','');
        gE('_funcionDefinicionFormatoint').setAttribute('val','obl');
        var _idFormatoint=gE('_idFormatoint');
        _idFormatoint.selectedIndex=0;
        
    }	
    
}


function prepararAntesGuardar()
{
	if(validarFormularios('frmEnvio'))
    {
    	gE('frmEnvio').submit();
    }
}