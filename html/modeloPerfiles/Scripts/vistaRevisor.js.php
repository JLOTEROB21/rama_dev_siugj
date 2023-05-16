<?php session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
?>
var ocultarBtn=false;

Ext.onReady(inicializar);

function inicializar()
{
	new Ext.Viewport(	{
                            layout: 'border',
                            items: [
                            			{
                                        	xtype:'panel',
                                            
                                            region:'west',
                                            autoScroll:true,
                                            border:true,
                                            width:250,
                                            split:true,
                                            contentEl:'tblOpciones', 
                                            collapsible:true
                                            
                                        }
                                        ,
                                        {
                                            region:'center',
                                            id:'tblCenter',
                                            autoScroll: true,
                                            xtype:'iframepanel',
                                            deferredRender: false,
                                            loadMask:	{
                                                            msg:'Cargando'
                                                        }
                                         }
                                      
                                     
                                    
                                     ]
						}
                    );  
	verDocumento();                 
}

function realizarDictamenRevisor(idFrm,idRef)
{	
	var cPagina='sFrm=true';
	var arrParam=	{
    					paginaRedireccion:'../paginasFunciones/white.php',
    					idFormulario:idFrm,
                    	idRegistro:'-1',
                        idReferencia:bD(idRef),
                    	cPagina:cPagina,
                        eJs:'<?php echo base64_encode("window.parent.regresar1Pagina(true);")?>'
                    };
     var tblCenter=Ext.getCmp('tblCenter').load	(
    												{
                                                    	url:'../modeloPerfiles/registroFormulario.php',
                                                        params:arrParam,
                                                        scripts:true
                                                    }
    											)            

}

function regresar1Pagina(cerrarVentana)
{
	var padre=window.opener.parent;
    padre.recargarContenedorCentral();
    if(cerrarVentana!=undefined)
		window.close();	
    
}

function verDocumento()
{
	gEx('tblCenter').load( {
                    url:'../reportes/exportarRegistroHTML.php',
                    scripts:true,
                    params:	{
                                idRegistro:gE('idRegistro').value,
                                idProceso:gE('idProceso').value,
                                idFormulario:gE('idFormulario').value,
                                actor:gE('actor').value,
                                idUsuario:gE('idUsuario').value,
                                cPagina:'sFrm=mR1=false'
                               
                             }
                })   	
}