<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


Ext.onReady(inicializar);

function inicializar()
{
	new Ext.Button (
                                {
                                    cls:'btnSIUGJ',
                                    text:'Guardar',
                                    width:150,
                                    height:50,
                                    id:'btnGuardarForm',
                                    renderTo:'contenedor1',
                                    handler:function()
                                            {
                                                validarFrm('frmEnvio')
                                            }
                                    
                                }
                            )
	
    
    new Ext.Button (
                                {
                                    cls:'btnSIUGJCancel',
                                    text:'Cancelar',
                                    width:150,
                                    height:50,
                                    id:'btnCancelarForm',
                                    renderTo:'contenedor2',
                                    handler:function()
                                            {
                                            	function  resp(btn)
                                                {
                                                	if(btn=='yes')
                                                    {
                                                    	regresarPagina();
                                                    }
                                                }
                                                msgConfirm('Est&aacute; seguro de querer cancelar la operaci&oacute;n?',resp)
                                                
                                            }
                                    
                                }
                            )

	if(gE('id').value!='-1')
    {
    	lanzarEvento(gE('_tipoContabilizacionint'),'change');
    }
}


function validarFrm()
{
	if(validarFormularios('frmEnvio'))
    {
    	gE('frmEnvio').submit();
    }
}


function tipoContabilizadorChange(combo)
{
	var valor=combo.options[combo.selectedIndex].value;
    
    if(valor=='1')
    {
    	mE('ctrlConstante');
        oE('ctrlFuncion');
        gE('txtValorContabilizacion').setAttribute('val','obl');
        gE('txtValorContabilizacion').setAttribute('name','_valorContabilizacionvch');
     	gE('hFuncionValorContabilizacion').value='';
        gE('hFuncionValorContabilizacion').setAttribute('name','');
        gE('hFuncionValorContabilizacion').setAttribute('val','');
        
    }
    else
    {
    	oE('ctrlConstante');
        mE('ctrlFuncion');
        gE('txtValorContabilizacion').setAttribute('val','');
        gE('txtValorContabilizacion').setAttribute('name','');
        gE('txtValorContabilizacion').value='';
        gE('hFuncionValorContabilizacion').setAttribute('val','obl');
        gE('hFuncionValorContabilizacion').setAttribute('name','_valorContabilizacionvch');
    }
    
    
}



function abrirVentanaFuncion(tipo)
{
	mostrarVentanaExpresion(	function(fila,ventana)
    							{
                                	gE('funcionValorContabilizacion').value=fila.get('nombreConsulta');
                                    gE('hFuncionValorContabilizacion').value=fila.get('idConsulta');
                                    ventana.close();
                            	}
    							,true
                          );
}

function removerFuncion(tipo)
{
	gE('hFuncionValorContabilizacion').value='';
    gE('funcionValorContabilizacion').value='';
}