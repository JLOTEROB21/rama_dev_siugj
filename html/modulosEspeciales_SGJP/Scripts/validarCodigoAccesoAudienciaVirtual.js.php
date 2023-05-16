<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


Ext.onReady(inicializar);

function inicializar()
{
	var arrExtensiones=bD(gE('nombreIidentificacion').value);
    arrExtensiones=arrExtensiones.split('.');

	oVisor=new Ext.ux.IFrameComponent({ 
        
                                                id: 'hSpVisor', 
                                                width:'100%',
                                                height:350,
                                                hidden:false,
                                                renderTo:'spVisor',
                                                url: '../paginasFunciones/white.php',
                                                style: 'width:100%;height:100%' 
                                        });
                                        
		gEx('hSpVisor').load	(
                                    {
                                        url:'../visoresGaleriaDocumentos/visorDocumentosGeneral.php',
                                        params:	{
                                                    iD:bE('iD_'+gE('idIdentificacion').value),
                                                    cPagina:'sFrm=true',
                                                    extension:arrExtensiones[arrExtensiones.length-1]
                                                }
                                    }
                                );        
}
