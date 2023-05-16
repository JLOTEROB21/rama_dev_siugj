function validarFrm()
{
	if(validarFormularios('frmEnvio'))
    {
    	gE('frmEnvio').submit();
    }
}

function tipoIndicadorChange(cmb)
{
	var valor=cmb.options[cmb.selectedIndex].value;
    
    if(valor=='2')
    {
    	mE('filaValMinimo');
        gE('_valorMinimoflo').setAttribute('val','obl');
        mE('filaMeta');
        gE('_metaflo').setAttribute('val','obl');
        mE('filaAlerta');
        gE('_alertaflo').setAttribute('val','obl');
    }
    else
    {
    	oE('filaValMinimo');
        gE('_valorMinimoflo').removeAttribute('val');
        oE('filaMeta');
        gE('_metaflo').removeAttribute('val');
        oE('filaAlerta');
        gE('_alertaflo').removeAttribute('val');
    }
}

function unidadTiempoChange(ctrl)
{
	gE('lblPeriodo').innerHTML=ctrl.options[ctrl.selectedIndex].text;
}