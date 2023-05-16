<?php
session_start();
include("configurarIdiomaJS.php");
include("conexionBD.php");
?>

Ext.onReady(inicializar);
var tabLeng;
var numIdiomasRestantes;
var editorActivo='txtCuerpo_1';
var tabActual=0;
var tab;
// Register the command.
var tab;
var msgEspere;
function inicializar()
{
	
	var panel;
	var arrPanel=new Array();
    msgEspere=Ext.MessageBox.wait('<?php echo $etj["lblEspere"]?>','<?php echo $etj["lblAplicacion"]?>');
	<?php
	$ct=0;
	echo "arrPanel[0]=new Ext.Panel	(
	 								{
										id:'p_0',
										title:'idioma'
									}
								);";
								
	$consulta="select idIdioma,idioma from 8002_idiomas order by idioma desc";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		echo "panel=crearPanel('".($ct+1)."','".uEJ($fila[1])."','".$fila[0]."');
			 arrPanel[".($ct+1)."]=panel;";
			$ct++;
		
	}
	?>
	gE('numIdiomas').value='<?php echo $ct ?>';
    numIdiomasRestantes=gE('numIdiomas').value;
	tab = new Ext.TabPanel
	 (
	 	{
			id:'panelPrincipal',
			renderTo:'divTabs',
			activeTab: 0,
			width:720,
			height:1000,
			plain:true,
			defaults:{autoScroll: true},
			items:	arrPanel,
			buttons:	[
							{
								text:'<?php echo $etj["lblBtnAceptar"]?>',
								handler:function()
										{
											if(vContenidos())
											{
												guardarDatos();
											}
										}
							}
						]
		}
	);
    tab.remove('p_0');
	
}

function inicializarContenido()
{
	var tab=Ext.getCmp('panelPrincipal');
	var idContenido=gE('idContenido').value;
	if(idContenido!='')
	{
		function funcAjax()
		{
			var objResp=eval(peticion_http.responseText);
			var arrContenidos=objResp[0].arrContenidos;
			for(x=0;x<arrContenidos.length;x++)
			{
				nPagina=buscarIdioma(arrContenidos[x].idIdioma);
				if(nPagina!='-1')
				{				
					cuerpo=Ext.getCmp('txtCuerpo_'+nPagina);
                    cuerpo.setValue(arrContenidos[x].contenido);
				}
			}
		}
		obtenerDatosWeb('../paginasFunciones/funcionesPortal.php',funcAjax, 'POST','funcion=40&idContenido='+idContenido,true);
	}
    
    
}
function crearPanel(idLenguaje,idioma,idIdioma)
{
	var accionesEnv=[]<?php //echo $arrAccionesEnv ?>;
	

	var dsParametros= new Ext.data.SimpleStore	(
													{
														fields:	[
																	{name:'id'},
																	{name:'parametro'},
																	{name:'valor'}
																]
													}
												)
												
	var dsParametrosDest= new Ext.data.SimpleStore	(
													{
														fields:	[
																	{name:'id'},
																	{name:'parametro'},
																	{name:'valor'}
																]
													}
												)


	 var mce=crearMCE('txtCuerpo_'+idLenguaje);
	 var Panel=new Ext.Panel	(
	 								{
										id:'panel_'+idLenguaje,
										title:idioma,
										defaultType:'label',
										layout: 'absolute',
										region: 'center',
										width:720,
										autoShow : true,
										collapsible :false,
										animCollapse :false,
										items:	[
													mce
													,
													{
														xtype:'hidden',
														id:'h_'+idLenguaje,
														value:idIdioma
													}
												],
                                        listeners:
                                        		{
                                                	'show':function()
                                                    {
                                                    	editorActivo='txtCuerpo_'+idLenguaje;
                                                    }
                                                }
									}
	 							)
     
	 return Panel;
}


function crearMCE(id)
{
	FCKeditor.BasePath = '../Scripts/fckeditor/' ;
    var mce= new Ext.ux.FCKeditor	(
    									{
                                        	Name : id,
                                            ToolbarSet : 'Default',
                                            Width:715,
                                            Height:600,
                                            config:'../fckconfig2.js'

                                        }
    								)
    
     mce.on('editorRender',function(textEditor)
     						{
                            	numIdiomasRestantes--;
                                if(numIdiomasRestantes==0)
                                {
                                	msgEspere.hide();
                                	tab.setActiveTab(0);
                                	inicializarContenido()
                                }
                                else
                                {
                                	tabActual++;
                                	tab.setActiveTab(tabActual);
                                }
                                
                            }
     		)                               
    return mce;
}

function vContenidos()
{
	var res=validarContenidos();
	switch(res)
	{
		case 0:
			return true;
		break;
		case 21:
			function funcAceptar()
			{
				Ext.getCmp('panelPrincipal').activate('panel_'+tabLeng);
				Ext.getCmp('txtCuerpo_'+tabLeng).focus(10,true);
				return false;
			}
			Ext.Msg.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["msgErrorContenido"] ?>',funcAceptar);
		break;
		case 22:
			function funcConfirmacion(btn)
			{
				if(btn=='yes')
				{
					rellenarValoresContenido();
					guardarContenido();
					return true;
				}
				else
					return false;
			}
			Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"] ?>', '<?php echo $etj["msgErrorContenido2"] ?>', funcConfirmacion);
		break;
	}
}

function rellenarValoresContenido()
{
	var x;
	var cuerpoO=Ext.getCmp('txtCuerpo_1').getValue();
	var cuerpoD;
	var vCuerpo;
	for (x=2;x<=gE('numIdiomas').value;x++)
	{
		cuerpoD=Ext.getCmp('txtCuerpo_'+x);
		if(cuerpoD.getValue()=='')
		{
			vCuerpo=cuerpoO.replace(String.fromCharCode(10), "<br>");
			vCuerpo=vCuerpo.replace(String.fromCharCode(13), "<br>");
			cuerpoD.setValue(vCuerpo);
		}

	}
}

function validarContenidos()
{
	var nIdiomas=gE('numIdiomas').value;
	var x;
	var asunto;
	var cuerpo;
	var idIdioma;
	var idiomaPagina=gE('hLeng').value;
	for(x=0;x<nIdiomas;x++)
	{
		
		cuerpo=Ext.getCmp('txtCuerpo_'+(x+1)).getValue();
		idIdioma=Ext.getCmp('h_'+(x+1)).getValue();
		if(cuerpo.trim()=='')
		{
			tabLeng=x+1;
			if(idIdioma==idiomaPagina)
				return 21;
			else
				return 22;
		}
		
	}
	return 0;
}

function guardarDatos()
{
	var obj="";
	var arrObj="";
	var nIdiomas=gE('numIdiomas').value;
	var idIdioma;
	var asunto;
	var cuerpo;
	var desc;
	var idContenido=gE('idContenido').value;
	for(x=1;x<=nIdiomas;x++)
	{
		
		cuerpo=Ext.getCmp('txtCuerpo_'+x).getValue();
		idIdioma=Ext.getCmp('h_'+x).getValue();
		obj='{"idIdioma":"'+idIdioma+'","cuerpo":"'+cv(cuerpo)+'"}';
		if(arrObj=='')
			arrObj=obj;
		else
			arrObj+=","+obj;
	}
	
	
	
	var objFinal='{"idContenido":"'+idContenido+'","contenidos":['+arrObj+']}';
	function funcAjax()
	{
		var resp=peticion_http.responseText;
		var arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
			function respMsg()
			{
				//location.href='tblcirculares.php';
			}
			
			Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["lblOperacionOK"] ?>',respMsg);
		}
		else
			msgBox('<?php $etj["errOperacion"].' '?>'+peticion_http.responseText);
	}
	obtenerDatosWeb('../paginasFunciones/funcionesPortal.php',funcAjax, 'POST','funcion=39&param='+objFinal,true);
}

function buscarIdioma(idIdioma)
{
	var x;
	var h;
	for(x=1;x<=gE('numIdiomas').value;x++)
	{
		h=Ext.getCmp('h_'+x);
		if(h.getValue()==idIdioma)
			return x;
	}
	return -1;
}

function inserta(datos)
{
	var oEditor=Ext.ux.FCKeditorMgr.get(editorActivo);
	if ( oEditor.EditMode == FCK_EDITMODE_WYSIWYG )
	{
		oEditor.InsertHtml(datos);
	}
} 

function mostrarVentanaImg()
{
	var conf=  	{
                    url:'../media/get-images.php',
                    width:815,
                    height:480,
                    verTiposImg:'1',
                    guardarTipoImg:1
                }
	showVentanaImagen(conf);                
}
