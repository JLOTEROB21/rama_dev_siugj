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
                                                    	location.href='../Sistema/tblTiposRegistrosBitacoraAuditoria.php';
                                                    }
                                                }
                                                msgConfirm('Est&aacute; seguro de querer cancelar la operaci&oacute;n?',resp)
                                                
                                            }
                                    
                                }
                            )
}


function validarFrm()
{
	if(validarFormularios('frmEnvio'))
    {
    	gE('frmEnvio').submit();
    }
}
