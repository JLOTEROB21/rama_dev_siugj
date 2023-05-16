Ext.onReady(inicializar);

function inicializar()
{
	new Ext.Button (
                                {
                                    cls:'btnSIUGJ',
                                    text:'Guardar',
                                    width:110,
                                    height:30,
                                    id:'btnGuardarForm',
                                    renderTo:'contenedor1',
                                    handler:function()
                                            {
                                                validarFrm('frmEnvio')
                                            }
                                    
                                }
                            )
	
}


function validarFrm()
{
	gE('frmEnvio').submit();
}
