Ext.onReady(inicializar);

function inicializar()
{
	Ext.QuickTips.init();
    var x;
    for(x=0;x<toolP.length;x++)
    {
    	
    	 new Ext.ToolTip	(
         						{        
                                    title: 'Actividades',
                                    id: 'tool_'+toolP[x],
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
}

function verInfoactividad(iA,idTool)
{
	var idTool=Ext.getCmp('tool_'+bD(idTool));
    idTool.hide();
	var arrDatos=[['idActividad',iA],['cPagina','mR1=false']];
    window.open('',"vDatosAct", "toolbar=no,directories=no,menubar=no,status=no,scrollbars=yes,fullscreen=yes");
    enviarFormularioDatos('../modeloProyectos/fichaActividadProceso.php',arrDatos,'POST','vDatosAct');

}