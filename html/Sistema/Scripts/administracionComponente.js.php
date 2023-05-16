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
                                                    	location.href='../gestorDocumental/tblTiposDocumentos.php';
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





function abrirVentanaFuncion(tipo)
{
	mostrarVentanaExpresion(	function(fila,ventana)
    							{
                                	gE('funcionVerificacionDisponibilidad').value=fila.get('nombreConsulta');
                                    gE('hFuncionVerificacionDisponibilidad').value=fila.get('idConsulta');
                                    ventana.close();
                            	}
    							,true
                          );
}

function removerFuncion(tipo)
{
	gE('funcionVerificacionDisponibilidad').value='';
    gE('hFuncionVerificacionDisponibilidad').value='';
}