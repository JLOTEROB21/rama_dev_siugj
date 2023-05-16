var myMenu;
Ext.onReady(inicializar);


function inicializar()
{
	
	 myMenu= new MenuMatic({ orientation:'vertical',hideDelay:300 });			
    

	new Ext.Panel	(
    				
                            {	
                            	idPanel:'panelCentral',
                                width:'100%',
                                border:false,
                                renderTo:'tblContenido',
                                items:	[
                                         	new Ext.ux.IFrameComponent({ 
                                        									loadFuncion:autofitIframe,
                                                                            id: 'frameContenido', 
                                                                            anchor:'100% 100%',
                                                                            url: '../paginasFunciones/white.php',
                                                                            style: 'width:100%;height:100%' 
                                                                    })   
                                        ]
                            }
                         )
	mostrarPaginaInicio();                         
	
    
}

function mostrarPaginaInicio()
{
	var arrParam=[];
    var idRegistro=gE('idRegistro').value;
    if(idRegistro=='')
    	idRegistro=-1;
    arrParam.push(['t',bE('_694_tablaDinamica')]);
    arrParam.push(['iR',bE(idRegistro)]);
   	arrParam.push(['cc',bE('paginaPrincipal')]);
   	arrParam.push(['cI',bE('id__694_tablaDinamica')]);
    cargarContenido('../principal/visorContenio.php',arrParam);
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

function cargarDatosPrograma(obj,iP)
{
	myMenu.hideAllSubMenusNow();
	var arrParam=[];
	arrParam.push(['idProgramaEducativo',bD(iP)]);
	arrParam.push(['plantel',gE('plantel').value]);    
    cargarContenido('../planteles/planesEstudioPlantel.php',arrParam);
}


function cargarSeccion(iS)
{
	var arrParam=[];
	var idRegistro=bD(iS);
    if(idRegistro=='')
    	idRegistro=-1;
    arrParam.push(['t',bE('_695_tablaDinamica')]);
    arrParam.push(['iR',bE(idRegistro)]);
   	arrParam.push(['cc',bE('contenido')]);
   	arrParam.push(['cI',bE('id__695_tablaDinamica')]);
    cargarContenido('../principal/visorContenio.php',arrParam);
}

function ingresarInscripcion(objParam)
{
	var obj={};
    obj.url='../planesEstudios/inscripcion.php';
    obj.ancho=840;
    obj.alto=490;
    obj.scrolling='no';
    obj.params=[['idCiclo',objParam.idCiclo],['idPeriodo',objParam.idPeriodo],['idInstancia',objParam.idInstancia]];
    abrirVentanaFancy(obj);
}


function ingresarSistema()
{
	var obj={};
    obj.url='../principal/login.php';
    obj.ancho=840;
    obj.alto=420;
    abrirVentanaFancy(obj);
}