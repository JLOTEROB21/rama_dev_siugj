function enviarProceso(cmb)
{
	var idProceso=cmb.options[cmb.selectedIndex].value;
    var hProceso=gE('hIdProceso');
    hProceso.value=idProceso;
    gE('frmEnvio').submit();
}