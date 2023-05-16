Ext.onReady(inicializar);

function inicializar()
{
	Ext.QuickTips.init();
    var spDel=gE('spDel');
    if(spDel!=null)
    {
        crearCampoFecha('spDel','fIni');
        crearCampoFecha('spAl','fFin');
	}    
    var x;
    var titulo;
    for(x=0;x<toolP.length;x++)
    {
    	var titulo=gE('hd_'+toolP[x]).value;
    	 new Ext.ToolTip	(
         						{        
                                    title: titulo,
                                    id: 'tool_1_'+x,
                                    target: 'lbl_'+toolP[x],
                                    anchor: 'left',
                                    html: null,
                                    width: 415,
                                    autoHide: false,
                                    closable: true,
                                    contentEl: toolP[x]
                                    
                                }
							);

    }
    for(x=0;x<toolS.length;x++)
    {
    	var titulo=gE('hd_'+toolS[x]).value;
    	 new Ext.ToolTip	(
         						{        
                                    title: titulo,
                                    id: 'tool_0_'+x,
                                    target: 'lbl_'+toolS[x],
                                    anchor: 'left',
                                    html: null,
                                    width: 415,
                                    autoHide: false,
                                    closable: true,
                                    contentEl: toolS[x]
                                    
                                }
							);
    }
    
}

function refresarPrograma()
{
	var fIni=convertirCadenaFecha(gE('fIni').value);
    var fFin=convertirCadenaFecha(gE('fFin').value);
    if(fIni>fFin)
    {
    	msgBox('La fecha de  inicio no puede ser mayor a la fecha final');
        return;
    }
    gE('fIni').value=fIni.format('Y-m-d');
    gE('fFin').value=fFin.format('Y-m-d');
    gE('frmReenvio').submit();

}

function mostrarDesgloceTiempo(iU,t,c)
{
	TB_show(lblAplicacion,'../Usuarios/desgloceTiempo.php?cPagina=sFrm=true&iU='+iU+'&t='+t+'&c='+c+'&TB_iframe=true&height=480&width=850',"","scrolling=yes");
}

function verDesgloceLineaInv(iL)
{
	var iU=gE('idUsuario').value;
    var fIni=gE('fIni').value;
    var fFin=gE('fFin').value;
	TB_show(lblAplicacion,'../Usuarios/desgloceLineasInv.php?cPagina=sFrm=true&iU='+iU+'&idLinea='+iL+'&fechaI='+bE(fIni)+'&fechaF='+bE(fFin)+'&TB_iframe=true&height=480&width=850',"","scrolling=yes");
}
