Ext.onReady(inicializar);

function inicializar()
{
	gE('_nombreGrupovch').focus();
}


function validarEnvio()
{
	if(validarFormularios('frmEnvio'))
    {
    	gE('frmEnvio').submit();
    }
}