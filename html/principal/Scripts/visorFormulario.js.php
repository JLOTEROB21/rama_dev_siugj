Ext.onReady(inicializar);

function inicializar()
{
	var mostrarCerrar=gE('mostrarCerrar').value;
    var objConf={
                    xtype:'panel',
                    region:'center',
                    layout:'border',
                    border:false,
                    frame:false,
                    items:	[
                                {
                                    region:'center',
                                    id:'frameContenido',
                                    autoScroll: true,
                                    xtype:'iframepanel',
                                    border:false,
                                    frame:false,
                                    deferredRender: false,
                                   loadMask:	{
                                                    msg:'Cargando'
                                                }
                                }
                                  
                            ]
                }
	if(mostrarCerrar=='1')             
        objConf.bbar=	[
                                {
                                    icon:'../images/add.png',
                                    cls:'x-btn-text-icon',
                                    text:'Cerrar Ventana',
                                    handler:function()
                                            {
                                            	function resp(btn)
                                                {
                                                
                                                	window.close();
                                                }
                                                msgConfirm('Est&aacute; seguro de querer cerrar la ventana?',resp);
                                            }
                                    
                                }
                            ]
	new Ext.Viewport(	{
                            layout: 'border',
                            items: [
                            			objConf
                                    ]
						}
                      )                                    
	var confPagina='mR1=false';
	var urlCarga='';
    var idRegistro=gE('idRegistro').value;
    var idFormulario=gE('idFormulario').value;
    var idReferencia=gE('idReferencia').value;
    var soloFrm=gE('soloFormulario').value;
    if(soloFrm=='1')
    	confPagina='sFrm=true';
    var eJ=gE('eJ').value;
    if(idRegistro=='-1')
    	urlCarga='../modeloPerfiles/registroFormulario.php';
    else
    	urlCarga='../modeloPerfiles/verFichaFormulario.php';
    
    var arrParam=[['pagRedireccion','../modeloPerfiles/verFichaFormulario.php'],['idFormulario',idFormulario],['idRegistro',idRegistro],['idReferencia',idReferencia],['accionCancelar','window.close();'],['eJs',eJ],['ignoraPermisos','1'],['cPagina',confPagina]];    
    cargarContenido(urlCarga,arrParam);                                
}

function cargarRegistro(idFormulario,idRegistro)
{
	var confPagina='mR1=false';
	var soloFrm=gE('soloFormulario').value;
    if(soloFrm=='1')
    	confPagina='sFrm=true';
	var arrParam=[['idFormulario',idFormulario],['idRegistro',idRegistro],['cPagina',confPagina],['ignoraPermisos','1']];
	cargarContenido('../modeloPerfiles/verFichaFormulario.php',arrParam);
}

function cargarContenido(urlCarga,arrParam)
{

	var objParams={};
    var x;
    for(x=0;x<arrParam.length;x++)
    {
    	eval('objParams.'+arrParam[x][0]+'=arrParam[x][1];');
    }

	gEx('frameContenido').load	(
    								{
    								 	url:urlCarga,
                                     	scripts:true,
                                     	params:objParams
                                    }
    							)
}