<?php
session_start();
include("configurarIdiomaJS.php");
include("conexionBD.php");


$consulta="select idParametros,parametro  from 2005_parametrosMensajes where tipoParametro=3 and idIdioma=".$_SESSION["leng"]." order by parametro";
$arrTiposDest=$con->obtenerFilasArreglo($consulta);
$consulta="SELECT idConsulta,nombreConsulta FROM 991_consultasSql WHERE idTipoConcepto=14 ORDER BY nombreConsulta";
$arrRenderer=$con->obtenerFilasArreglo($consulta);
?>
var arrValoresCuerpo=[];
var arrRenderer=<?php echo $arrRenderer?>;
var arrParametros=[];

var arrParametrosObjeto=[];
var regParametro=crearRegistro([{'name':'nParametro'},{'name':'orden'}]);
var arrTiposVariableEditor=[['4','Almac\xE9n de datos'],['3','Consulta auxiliar'],['5','Valor de par\xE1metro'],['1','Valor de sesi\xF3n'],['2','Valor de sistema']];
var arrDestinatario=[['4','Almac\xE9n de datos'],['3','Consulta auxiliar'],['5','Valor de par\xE1metro'],['6','Valor ingresado manualmente']];

var regDestinatario=crearRegistro([
                                    {name: 'idDestinatario'},
                                    {name: 'destinatario'},
                                    {name: 'tipoDestinatario'}
                                ])
var regDocumentos=crearRegistro	(
									[
                                    	{name: 'idDocumento'},
                                        {name: 'documento'},
                                        {name: 'tamano'}
                                    ]
								)
Ext.onReady(inicializar);

var altura;



function inicializar()
{
	arrRenderer.splice(0,1,['0','Ninguno']);
	arrValoresCuerpo=eval(bD(gE('arrValoresCuerpo').value));
	arrParametros=eval(bD(gE('arrParam').value));
    var x;
    for(x=0;x<arrParametros.length;x++)
    {
    	arrParametrosObjeto.push([arrParametros[x][0],arrParametros[x][0]]);
    }
    arrParametrosCalculo=arrParametrosObjeto;
	obj={};
    obj.permitirRegistroParametro=false;
    altura=obtenerDimensionesNavegador()[1];
    obj.alto=altura;
    obj.idReferencia=gE('idMensajeEnvio').value;
    obj.tDataSet=10;
    obj.tituloConcepto='el mensaje de env&iacute;o';
	var arbol=crearArbolAlmacen(obj);
    var gDestinatario=crearGridDestinatarioMensaje('gridDestinatario','gDestinatario');
    var gCC=crearGridDestinatarioMensaje('gridCC','gCC');
    var gCCO=crearGridDestinatarioMensaje('gridCCO','gCCO');
    var gRemitente=crearGridDestinatarioMensaje('gridRemitente','gRemitente');
	//crearGridDocumentosAdjuntos();
	crearGridParametros();
    var tabCabecera= new Ext.TabPanel	(	{
    											id:'tPanelCabecera',
    						
                                                renderTo:'tabCabecera',
                                                width:800,
                                                height:300,
                                                cls:'tabPanelSIUGJ',
                                                activeTab: 0,
                                                items:	[	
                                                			{
                                                                xtype:'panel',
                                                                border:false,
                                                                frame:false,
                                                                items:[]
                                                            },
                                                            {
                                                                xtype:'panel',
                                                                border:false,
                                                                frame:false,
                                                                title:'Destinatarios',
                                                                items:[gDestinatario]
                                                            },
                                                            {
                                                                xtype:'panel',
                                                                border:false,
                                                                frame:false,
                                                                title:'Remitentes',
                                                                items:[gRemitente]
                                                            },
                                                            {
                                                                xtype:'panel',
                                                                border:false,
                                                                frame:false,
                                                                title:'Con Copia (CC)',
                                                                items:[gCC]
                                                            },
                                                            {
                                                                xtype:'panel',
                                                                border:false,
                                                                frame:false,
                                                                title:'Con Copia Oculta (CCO)',
                                                                items:[gCCO]
                                                            }
                                                        ]
                                                
                                            }
                                        );
	
    
    new Ext.Viewport(	{
                            layout: 'border',
                            items: [
                            			{
                                        	xtype:'panel',
                                            region:'center',
                                            layout:'border',
                                            cls:'panelSiugjWrap',
                                            title:'Mensaje de env&iacute;o',
                                            tbar:[
                                            		{
                                                    	xtype:'label',
                                                    	html:'&nbsp;&nbsp;&nbsp;'
                                                     },
                                            		{
                                                        icon:'../images/salir.gif',
                                                        cls:'x-btn-text-icon',
                                                        text:'Regresar',
                                                        handler:function()
                                                                {
                                                                    regresarPagina();
                                                                }
                                                        
                                                    },
                                            		'-',
                                                    {
                                                        icon:'../images/guardar.PNG',
                                                        cls:'x-btn-text-icon',
                                                        text:'Guardar mensaje de env&iacute;o',
                                                        handler:function()
                                                                {
                                                                    var panelPrincipal=gEx('panelPrincipal');
                                                                    var cadObj='';
                                                                    var txtTitulo=gE('txtTitulo');
                                                                    
                                                                    if(txtTitulo.value.trim()=='')
                                                                    {
                                                                        function resp()
                                                                        {
                                                                            panelPrincipal.setActiveTab(0);
                                                                            txtTitulo.focus();
                                                                        }
                                                                        msgBox('Debe ingresar el t&iacute;tulo del mensaje',resp);
                                                                        return;
                                                                    }
                                                                    
                                                                    var txtDescripcion=gE('txtDescripcion');
                                                                    var cmbCategoria=gE('cmbCategoria');
                                                                    
                                                                    if(cmbCategoria.selectedIndex==0)
                                                                    {
                                                                        function resp2()
                                                                        {
                                                                            panelPrincipal.setActiveTab(0);
                                                                            cmbCategoria.focus();
                                                                        }
                                                                        msgBox('Debe indicar la categor&iacute;a a la cual pertenece el mensaje',resp2);
                                                                        return;
                                                                    }
                                                                    var idCategoria=cmbCategoria.options[cmbCategoria.selectedIndex].value;
                                                                    
                                                                    
                                                                    var txtAsunto=gE('txtAsunto');
                                                                    if(txtAsunto.value.trim()=='')
                                                                    {
                                                                        function resp3()
                                                                        {
                                                                            panelPrincipal.setActiveTab(1);
                                                                            txtAsunto.focus();
                                                                        }
                                                                        msgBox('Debe ingresar el asunto del mensaje',resp3);
                                                                        return;
                                                                    }
                                                                    var cuerpo=gEx('txtContenido').getValue();
                                                                    var x;
                                                                    var fila;
                                                                    var o;
                                                                    var arrDestinatario='';
                                                                    var gDestinatario=gEx('gDestinatario');
                                                                    for(x=0;x<gDestinatario.getStore().getCount();x++)
                                                                    {
                                                                        fila=gDestinatario.getStore().getAt(x);
                                                                        o='{"idDestinatario":"'+fila.get('idDestinatario')+'","destinatario":"'+fila.get('destinatario')+'","tipoDestinatario":"'+fila.get('tipoDestinatario')+'"}';
                                                                        if(arrDestinatario=='')
                                                                            arrDestinatario=o;
                                                                        else
                                                                            arrDestinatario+=','+o;
                                                                    }
                                                                    if(arrDestinatario=='')
                                                                    {
                                                                        function resp13()
                                                                        {
                                                                            panelPrincipal.setActiveTab(1);
                                                                            
                                                                        }
                                                                        msgBox('Al menos debe ingresar un destinatario para el mensaje',resp13);
                                                                        return;
                                                                    }
                                                                    var arrCC='';
                                                                    
                                                                    var gCC=gEx('gCC');
                                                                    for(x=0;x<gCC.getStore().getCount();x++)
                                                                    {
                                                                        fila=gCC.getStore().getAt(x);
                                                                        o='{"idDestinatario":"'+fila.get('idDestinatario')+'","destinatario":"'+fila.get('destinatario')+'","tipoDestinatario":"'+fila.get('tipoDestinatario')+'"}';
                                                                        if(arrCC=='')
                                                                            arrCC=o;
                                                                        else
                                                                            arrCC+=','+o;
                                                                    }
                                                                    var arrCCO='';
                                                                    var gCCO=gEx('gCCO');
                                                                    for(x=0;x<gCCO.getStore().getCount();x++)
                                                                    {
                                                                        fila=gCCO.getStore().getAt(x);
                                                                        o='{"idDestinatario":"'+fila.get('idDestinatario')+'","destinatario":"'+fila.get('destinatario')+'","tipoDestinatario":"'+fila.get('tipoDestinatario')+'"}';
                                                                        if(arrCCO=='')
                                                                            arrCCO=o;
                                                                        else
                                                                            arrCCO+=','+o;
                                                                    }
                                                                    
                                                                    var arrRemitente='';
                                                                    var gRemitente=gEx('gRemitente');
                                                                    for(x=0;x<gRemitente.getStore().getCount();x++)
                                                                    {
                                                                        fila=gRemitente.getStore().getAt(x);
                                                                        o='{"idDestinatario":"'+fila.get('idDestinatario')+'","destinatario":"'+fila.get('destinatario')+'","tipoDestinatario":"'+fila.get('tipoDestinatario')+'"}';
                                                                        if(arrRemitente=='')
                                                                            arrRemitente=o;
                                                                        else
                                                                            arrRemitente+=','+o;
                                                                    }
                                                                    
                                                                    var arrParametros='';
                                                                    var gParametro=gEx('gParametro');
                                                                    
                                                                   
                                                                    for(x=0;x<gParametro.getStore().getCount();x++)
                                                                    {
                                                                        
                                                                        fila=gParametro.getStore().getAt(x);
                                                                        o='{"nParametro":"'+cv(fila.get('nParametro'))+'","orden":"'+fila.get('orden')+'"}';
                                                                        if(arrParametros=='')
                                                                            arrParametros=o;
                                                                        else
                                                                            arrParametros+=','+o;
                                                                        
                                                                    }
                                                                    
                                                                    
                                                                    //var gAdjuntos=gEx('gAdjuntos');
                                                                    var arrDocumentosAdj='';
                                                                    /*for(x=0;x<gAdjuntos.getStore().getCount();x++)
                                                                    {
                                                                        fila=gAdjuntos.getStore().getAt(x);
                                                                        o='{"idDocumento":"'+fila.get('idDocumento')+'","tDocumento":"'+fila.get('tipoDocumento')+'","nombreDocumento":"'+fila.get('documento')+'"}';
                                                                        if(arrDocumentosAdj=='')
                                                                            arrDocumentosAdj=o;
                                                                        else
                                                                            arrDocumentosAdj+=','+o;
                                                                    }*/
                                                                    
                                                                    var cAux;
                                                                    var aValoresCuerpo='';
                                                                    
                                                                    for(x=0;x<arrValoresCuerpo.length;x++)
                                                                    {
                                                                        o=arrValoresCuerpo[x];
                                                                        if(cuerpo.indexOf(codificarVariable(o.lblVariable))!=-1)
                                                                        {
                                                                            cAux='{"lblVariable":"'+o.lblVariable+'","renderer":"'+o.renderer+'","tVariable":"'+o.tVariable+'","valor1":"'+o.valor1+'","valor2":"'+o.valor2+'"}';
                                                                            if(aValoresCuerpo=='')
                                                                                aValoresCuerpo=cAux;
                                                                            else
                                                                                aValoresCuerpo+=','+cAux;
                                                                        }
                                                                    }

                                                                    cadObj='{"arrRemitente":"'+bE('['+arrRemitente+']')+'","arrDocumentosAdj":"'+bE('['+arrDocumentosAdj+']')+'","arrDestinatario":"'+
                                                                            bE('['+arrDestinatario+']')+'","arrCC":"'+bE('['+arrCC+']')+'","arrCCO":"'+bE('['+arrCCO+']')+'","arrValoresCuerpo":"'+bE('['+aValoresCuerpo+']')+
                                                                            '","arrParametros":['+arrParametros+'],"idMensaje":"'+gE('idMensajeEnvio').value+
                                                                            '","titulo":"'+cv(txtTitulo.value.trim())+
                                                                            '","descripcion":"'+cv(txtDescripcion.value.trim())+'","categoria":"'+idCategoria+'","asunto":"'+
                                                                            cv(txtAsunto.value.trim())+'","cuerpo":"'+bE(cv(cuerpo.trim()))+'"}';
                                                                    
                                                                    function funcAjax()
                                                                    {
                                                                        var resp=peticion_http.responseText;
                                                                        arrResp=resp.split('|');
                                                                        if(arrResp[0]=='1')
                                                                        {
                                                                            idReferencia=arrResp[1];
                                                                            gE('idMensajeEnvio').value=idReferencia;
                                                                            msgBox('El mensaje ha sido guardado correctamente');
                                                                        }
                                                                        else
                                                                        {
                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                        }
                                                                    }
                                                                    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=203&cadObj='+cadObj,true);
                                                                    
                                                                    
                                                                    
                                                                }
                                                    }
                                                  ],
                                            items:	[
                                           				 {
                                                         	xtype:'panel',
                                                            collapsible:true,
                                                            region: 'east',
                                                            width:255,
                                                            split:true,
                                                            layout:'anchor',
                                                            items:[arbol]
                                                         },
                                                         {
                                                         	xtype:'panel',
                                                            region: 'center',
                                                            split:true,
                                                            layout:'absolute',
                                                            
                                                            items:	[
                                                            			
                                                                      	{
                                                                              id:'panelPrincipal',
                                                                              activeTab: 2,
                                                                              cls:'tabPanelSIUGJ',
                                                                              xtype:'tabpanel',
                                                                              listeners:{
                                                                              				tabchange:function(t,p)
                                                                                            		{
                                                                                                    	if(p.id=='tCabecera')
                                                                                                        {
                                                                                                        	gEx('tPanelCabecera').setActiveTab(1);
                                                                                                            gEx('tPanelCabecera').hideTabStripItem(0);
                                                                                                        }
                                                                                                    }
                                                                              			},	
                                                                              items:	[
                                                                              				{
                                                                                                xtype:'panel',
                                                                                                border:false,
                                                                                                frame:false,
                                                                                                height:altura,
                                                                                                title:'1.- Configuraci&oacute;n del mensaje',
                                                                                                contentEl:'tblConfGeneral'
                                                                                            },
                                                                              				{
                                                                                                xtype:'panel',
                                                                                                border:false,
                                                                                                frame:false,
                                                                                                height:altura,
                                                                                                id:'tCabecera',
                                                                                                title:'2.- Cabecera del mensaje',
                                                                                                contentEl:'tblCabecera'
                                                                                            },
                                                                                            {
                                                                                                
                                                                                                xtype:'panel',
                                                                                                height:altura,
                                                                                                title:'3.- Cuerpo del mensaje',
                                                                                                items:	[
                                                                                                            crearMCE('txtContenido')
                                                                                                        ]
                                                                                            }
                                                                                         ]
                                                                        }
                                                            		]
                                                         }
                                                         
	                                           		]
                                        }
                                     ]
						}
                    ) 
	                 
     
      
    
	gEx('gDestinatario').getStore().loadData(eval(bD(gE('arrDestinatarios').value)));
    gEx('gCC').getStore().loadData(eval(bD(gE('arrCC').value)));
    gEx('gCCO').getStore().loadData(eval(bD(gE('arrCCO').value)));
    gEx('gRemitente').getStore().loadData(eval(bD(gE('arrRemitente').value)));
    
    
    

    //gEx('gAdjuntos').getStore().loadData(eval(bD(gE('arrDocumentosAdj').value)));
                                    

}

function crearMCE(idMce)
{
	var posicion=0;
	FCKeditor.BasePath = '../Scripts/fckeditor/' ;
    var mce= new Ext.ux.FCKeditor	(
    									{
                                        
                                        	y:0,
                                        	Name : idMce,
                                            Height:(altura-posicion),
                                            ToolbarSet : 'Default',
                                            config:'../fckconfig4.js'

                                        }
    								)
    
     mce.on('editorRender',function(textEditor)
     						{
                            	textEditor.setValue(bD(gE('cuerpo').value));
                                setTimeout('cambiarTab()',1000);
                                
                                
                            }
     		)                               
    return mce;
}

function enfocarCuerpo()
{
	var oEditor=Ext.ux.FCKeditorMgr.get('txtContenido');
    
//    oEditor.Focus();
}

function cambiarTab()
{
	gEx('panelPrincipal').setActiveTab(0);
    gEx('gParametro').getView().refresh();
    
}

function insertarParametro_click()
{
	
	var cmbTipoVariable=crearComboExt('cmbTipoVariable',arrTiposVariableEditor,130,5,280);
    
    cmbTipoVariable.on('select',function(cmb,registro)
    							{
                                	switch(registro.get('id'))
                                    {
                                    	case '1':
                                        	gEx('vInsertarVariable').setHeight(190);
                                            gE('lblValor1').innerHTML='Valor de sesi&oacute;n:';
                                            gE('lblValor2').innerHTML='';
                                            gEx('cmbValor2').hide();
                                            gEx('cmbValor1').show();
                                            gEx('cmbValor1').reset();
                                            gEx('cmbValor2').reset();
                                            gEx('cmbValor1').getStore().loadData(arrValorSesion);
                                            
                                        break;
                                        case '2':
                                        	gEx('vInsertarVariable').setHeight(190);
                                            gE('lblValor1').innerHTML='Valor de sistema:';
                                            gE('lblValor2').innerHTML='';
                                            gEx('cmbValor2').hide();
                                            gEx('cmbValor1').show();
                                            gEx('cmbValor1').reset();
                                            gEx('cmbValor2').reset();
                                            gEx('cmbValor1').getStore().loadData(arrValorSistema);
                                        break;
                                        case '3':
                                        	gEx('vInsertarVariable').setHeight(190);
                                            gE('lblValor1').innerHTML='Consulta auxiliar:';
                                            gE('lblValor2').innerHTML='';
                                            gEx('cmbValor2').hide();
                                            gEx('cmbValor1').show();
                                            gEx('cmbValor1').reset();
                                            gEx('cmbValor2').reset();
                                            var arrAlmacenDatos=obtenerAlmacenesDatosDisponibles(2);
                                           
                                            cmbValor1.getStore().loadData(arrAlmacenDatos);
                                        break;
                                        case '4':
                                        	gEx('vInsertarVariable').setHeight(220);
                                            gE('lblValor1').innerHTML='Almac&eacute;n de datos:';
                                            gE('lblValor2').innerHTML='Campo a proyectar:';
                                            gEx('cmbValor2').show();
                                            gEx('cmbValor1').show();
                                            gEx('cmbValor1').reset();
                                            gEx('cmbValor2').reset();
                                            var arrAlmacenDatos=obtenerAlmacenesDatosDisponibles(1);
                                            cmbValor1.getStore().loadData(arrAlmacenDatos);
                                        break;
                                        case '5':
                                        	gEx('vInsertarVariable').setHeight(190);
                                            gE('lblValor1').innerHTML='Valor de par&aacute;metro:';
                                            gE('lblValor2').innerHTML='';
                                            gEx('cmbValor2').hide();
                                            gEx('cmbValor1').show();
                                            gEx('cmbValor1').reset();
                                            gEx('cmbValor2').reset();
                                            gEx('cmbValor1').getStore().loadData(arrParametrosCalculo);
                                        break;
                                    }
                                }
    					)
    var cmbFuncionRenderer=crearComboExt('cmbFuncionRenderer',arrRenderer,130,35,280);
    cmbFuncionRenderer.setValue('0');
    var cmbValor1=crearComboExt('cmbValor1',[],130,65,280);
    cmbValor1.hide();
    var cmbValor2=crearComboExt('cmbValor2',[],130,95,280);
    cmbValor2.hide();
    cmbValor1.on('select',function(cmb,registro)
    						{
                            	switch(gEx('cmbTipoVariable').getValue())
                                {
	                                case '4':
                                    	var arrCampos=obtenerCamposDisponibles(registro.get('id'));
                                        cmbValor2.reset();
                                        cmbValor2.getStore().loadData(arrCampos);
                                    break;
                                }
                            }
    			)
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de variable:'
                                                        },
                                                        cmbTipoVariable,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            
                                                            html:'<span id="lblValor">Funci&oacute;n renderer</span>:'
                                                        }
														,
                                                        cmbFuncionRenderer,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'<span id="lblValor1"></span>'
                                                        }
														,
                                                        cmbValor1,
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'<span id="lblValor2"></span>'
                                                        }
														,
                                                        cmbValor2
                                                        

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vInsertarVariable',
										title: 'Insertar variable de dato',
										width: 500,
										height:160,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var tipoVariable=cmbTipoVariable.getValue();
                                                                        var etVariable;
                                                                        
                                                                        if(tipoVariable=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbTipoVariable.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de variable a insertar',resp);
                                                                            return;
                                                                        }
                                                                        var valor2Reg=cmbValor2.getValue();
                                                                        switch(tipoVariable)
                                                                        {
                                                                        	case '1':
                                                                            	if(cmbValor1.getValue()=='')
                                                                                {
                                                                                	function resp2()
                                                                                    {
                                                                                        cmbValor1.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el valor de sesi&oacute;n a insertar',resp2);
                                                                                    return;
                                                                                }
                                                                                etVariable='V. Sesion: '+cmbValor1.getRawValue();
                                                                            break;
                                                                            case '2':
                                                                            	if(cmbValor1.getValue()=='')
                                                                                {
                                                                                	function resp3()
                                                                                    {
                                                                                        cmbValor1.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el valor de sistema a insertar',resp3);
                                                                                    return;
                                                                                }
                                                                                 etVariable='V. Sistema: '+cmbValor1.getRawValue();
                                                                            break;
                                                                            case '3':
                                                                            	if(cmbValor1.getValue()=='')
                                                                                {
                                                                                	function resp4()
                                                                                    {
                                                                                        cmbValor1.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar la consulta auxiliar de la cual se obtendr&aacute; el valor a insertar',resp4);
                                                                                    return;
                                                                                }
                                                                                 etVariable='C. Aux.: '+cmbValor1.getRawValue();
                                                                            break;
                                                                            case '4':
                                                                            	if(cmbValor1.getValue()=='')
                                                                                {
                                                                                	function resp5()
                                                                                    {
                                                                                        cmbValor1.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el almac&eacute;n de datos del cual se obtendr&aacute; el valor a insertar',resp5);
                                                                                    return;
                                                                                }
                                                                                if(cmbValor2.getValue()=='')
                                                                                {
                                                                                	function resp7()
                                                                                    {
                                                                                        cmbValor2.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el campo del cual se obtendr&aacute; el valor a insertar',resp7);
                                                                                    return;
                                                                                }
                                                                                etVariable='Almacen: '+cmbValor1.getRawValue()+'.'+cmbValor2.getRawValue();
                                                                                var nodo=buscarNodoID(gEx('arbolDataSet').getRootNode(),cmbValor2.getValue());
                                                                                if(nodo.nCampo!=undefined)
	                                                                                valor2Reg=nodo.nCampo;
                                                                                else
                                                                                	valor2Reg=nodo.attributes.nCampo;
                                                                            break;
                                                                            case '5':
                                                                            	if(cmbValor1.getValue()=='')
                                                                                {
                                                                                	function resp6()
                                                                                    {
                                                                                        cmbValor1.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el par&aacute;metro a insertar',resp6);
                                                                                    return;
                                                                                }
                                                                                 etVariable='Parametro: '+cmbValor1.getRawValue();
                                                                            break;
                                                                        }
                                                                        
                                                                        
                                                                        var lblTipoVariable='';
                                                                        
                                                                        var oEditor=Ext.ux.FCKeditorMgr.get('txtContenido');
                                                                        lblTipoVariable='[@'+etVariable+']';//'<span style="color:#900">[@'+etVariable+']</span>';
                                                                       	if ( oEditor.EditMode == FCK_EDITMODE_WYSIWYG )
                                                                        {
                                                                            oEditor.InsertHtml(lblTipoVariable);
                                                                        }
                                                                        
                                                                        

                                                                        
                                                                        if(obtenerPosObjeto(arrValoresCuerpo,'lblVariable','[@'+codificarVariable(etVariable)+']')==-1)
	                                                                        arrValoresCuerpo.push({lblVariable:'[@'+codificarVariable(etVariable)+']',tVariable:tipoVariable,valor1:cmbValor1.getValue(),valor2:valor2Reg,renderer:cmbFuncionRenderer.getValue()});
                                                                       	
                                                                        ventanaAM.close();
                                                                        
                                                                       
                                                                       	                                                                        
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}

function mostrarVentanaParametro()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                        	xtype:'label',
                                                            html:'Par&aacute;metro:'
                                                        },
                                                        {
                                                        	x:110,
                                                            y:5,
                                                            xtype:'textfield',
                                                            width:220,
                                                            id:'txtParametro'
                                                        }
														

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar par&aacute;metro',
										width: 380,
										height:130,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	gEx('txtParametro').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtParametro=gEx('txtParametro');
                                                                        if(txtParametro.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtParametro.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el nombre del par&aacute;metro');
                                                                            return;
                                                                        }
                                                                        var gParametro=gEx('gParametro');
                                                                        if(obtenerPosFila(gParametro.getStore(),'nParametro',txtParametro.getValue())==-1)
                                                                        {
                                                                        	var r=new regParametro({nParametro:txtParametro.getValue().trim(),orden:gParametro.getStore().getCount()+1});
                                                                            gParametro.getStore().add(r);
                                                                        }
                                                                        ventanaAM.close();
                                                                        
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();
}

function crearGridParametros()
{
	var dsDatos=arrParametros;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'nParametro'},
                                                                    {name: 'orden'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
	
    
    chkRow.on('rowselect',function(sm,idx,registro)
    						{
                            	if(sm.getSelections().length==1)
                                {
                                	gEx('btnDown').enable();
                                    gEx('btnUp').enable();
                                }
                                else
                                {
                                	gEx('btnDown').disable();
                                    gEx('btnUp').disable();
                                }
                            }
    		)

	chkRow.on('rowdeselect',function(sm,idx,registro)
    						{
                            	if(sm.getSelections().length==1)
                                {
                                	gEx('btnDown').enable();
                                    gEx('btnUp').enable();
                                }
                                else
                                {
                                	gEx('btnDown').disable();
                                    gEx('btnUp').disable();
                                }
                            }
    		)            
    
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:40}),
														chkRow,
														{
															header:'Par&aacute;metro',
															width:270,
															sortable:true,
															dataIndex:'nParametro'
														},
                                                        {
															header:'Orden',
															width:80,
															sortable:true,
															dataIndex:'orden'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gParametro',
                                                            renderTo:'tblParametros',
                                                            store:alDatos,
                                                            frame:false,
                                                            cm: cModelo,
                                                            loadMask:true,
                                                            stripeRows :false,
                                                            columnLines : false,
                                                            cls:'gridSiugjPrincipal',
                                                            height:210,
                                                            width:650,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar par&aacute;metro',
                                                                            handler:function()

                                                                            		{
                                                                                    	mostrarVentanaParametro();	
                                                                                    }
                                                                            
                                                                        },{
                                                                        	xtype:'tbspacer',
                                                                            width:10
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover par&aacute;metro',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar los par&aacute;metros que desea remover');
                                                                                            return;
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                            if(btn=='yes')
                                                                                            {
                                                                                                tblGrid.getStore().remove(filas);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover los par&aacute;metros seleccionados?',resp);
                                                                                        return;
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	xtype:'tbspacer',
                                                                            width:10
                                                                        },
                                                                        {
                                                                        	id:'btnDown',
                                                                        	icon:'../images/SignDown.gif',
                                                                            cls:'x-btn-icon',
                                                                            disabled:true,
                                                                            handler:function()
                                                                            		{
                                                                                    	var fAux;
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        var orden=parseInt(fila.get('orden'))-1;
                                                                                        if(orden<tblGrid.getStore().getCount()-1)
                                                                                        {
                                                                                        	fAux=tblGrid.getStore().getAt(orden+1);
                                                                                            fAux.set('orden',orden+1);
                                                                                            fila.set('orden',orden+2);
                                                                                            
                                                                                        }
                                                                                        tblGrid.getStore().sort([{field:'orden', direction:'ASC'}]);
                                                                                        
                                                                                    }
                                                                        },
                                                                        {
                                                                        	xtype:'tbspacer',
                                                                            width:10
                                                                        },
                                                                        {
                                                                        	id:'btnUp',
                                                                        	icon:'../images/SignUp.gif',
                                                                            cls:'x-btn-icon',
                                                                            disabled:true,
                                                                            handler:function()
                                                                            		{
                                                                                    	
                                                                                        var fAux;
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        var orden=parseInt(fila.get('orden'))-1;
                                                                                        if(orden>0)
                                                                                        {
                                                                                        	fAux=tblGrid.getStore().getAt(orden-1);
                                                                                            fAux.set('orden',orden+1);
                                                                                            fila.set('orden',orden);
                                                                                            
                                                                                        }
                                                                                        tblGrid.getStore().sort([{field:'orden', direction:'ASC'}]);
                                                                                    }
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;		
} 

function crearGridDestinatarioMensaje(divDestino,idGrid)
{
	
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idDestinatario'},
                                                                    {name: 'destinatario'},
                                                                    {name: 'tipoDestinatario'}
                                                                ]
                                                    }
                                                );

	var lAgregar='Agregar destinatario';
    var lRemover='Remover destinatario';
	if(idGrid=='gRemitente')
    {
    	lAgregar='Agregar remitente';
        lRemover='Remover remitente';
    }
    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:40}),
														{
															header:'Destinatario',
															width:300,
															sortable:true,
															dataIndex:'destinatario'
														},
														{
															header:'Tipo destinatario',
															width:250,
															sortable:true,
															dataIndex:'tipoDestinatario',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrDestinatario,val);
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            border:false,
                                                            cm: cModelo,
                                                            height:300,
                                                            loadMask:true,
                                                            stripeRows :false,
                                                            columnLines : false,
                                                            cls:'gridSiugjPrincipal',
                                                            id:idGrid,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:lAgregar,
                                                                            id:'a_'+idGrid,
                                                                            handler:function()
                                                                            		{
                                                                                    	if(idGrid=='gRemitente')
                                                                                        {
                                                                                        	if(tblGrid.getStore().getCount()>0)
                                                                                            {
                                                                                            	msgBox('S&oacute;lo puede indicar un remitente del mensaje');
                                                                                            	return;
                                                                                            }
                                                                                        }
                                                                                    	insertarDestinatario(tblGrid);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:lRemover,
                                                                            id:'d_'+idGrid,
                                                                            handler:function()
                                                                            		{
                                                                                    	
                                                                                    	var filas=tblGrid.getSelectionModel().getSelected();
                                                                                        if(filas==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar al menos un elemento a remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                    	function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
	                                                                                        	tblGrid.getStore().remove(filas);
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el elemento seleccionado?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function insertarDestinatario(grid)
{
	var lAgregar='';
    var lOrigen='Origen destinatario:';
    switch(grid.id)
    {
    	case 'gDestinatario':
        	lAgregar=' destinatario';
        break;
        case 'gCC':
        	lAgregar=' destinatario [CC]';
        break;
        case 'gCCO':
        	lAgregar=' destinatario [CCO]';
        break;
        case 'gRemitente':
        	lOrigen='Remitente :';
        	lAgregar=' remitente del mensaje';
        break;
        
    }
	arrRenderer.splice(0,1,['0','Ninguno']);
	var cmbTipoVariable=crearComboExt('cmbTipoVariable',arrDestinatario,130,5,280);
    
    cmbTipoVariable.on('select',function(cmb,registro)
    							{
                               		gEx('cmbValor1').show();
                                    gEx('txtEmailManual').hide();
                                	switch(registro.get('id'))
                                    {
                                    	case '1':
                                        	gEx('vInsertarVariable').setHeight(160);
                                            gE('lblValor1').innerHTML='Valor de sesi&oacute;n:';
                                            gE('lblValor2').innerHTML='';
                                            gEx('cmbValor2').hide();
                                            gEx('cmbValor1').show();
                                            gEx('cmbValor1').reset();
                                            gEx('cmbValor2').reset();
                                            gEx('cmbValor1').getStore().loadData(arrValorSesion);
                                            
                                        break;
                                        case '2':
                                        	gEx('vInsertarVariable').setHeight(160);
                                            gE('lblValor1').innerHTML='Valor de sistema:';
                                            gE('lblValor2').innerHTML='';
                                            gEx('cmbValor2').hide();
                                            gEx('cmbValor1').show();
                                            gEx('cmbValor1').reset();
                                            gEx('cmbValor2').reset();
                                            gEx('cmbValor1').getStore().loadData(arrValorSistema);
                                        break;
                                        case '3':
                                        	gEx('vInsertarVariable').setHeight(160);
                                            gE('lblValor1').innerHTML='Consulta auxiliar:';
                                            gE('lblValor2').innerHTML='';
                                            gEx('cmbValor2').hide();
                                            gEx('cmbValor1').show();
                                            gEx('cmbValor1').reset();
                                            gEx('cmbValor2').reset();
                                            var arrAlmacenDatos=obtenerAlmacenesDatosDisponibles(2);
                                           
                                            cmbValor1.getStore().loadData(arrAlmacenDatos);
                                        break;
                                        case '4':
                                        	gEx('vInsertarVariable').setHeight(190);
                                            gE('lblValor1').innerHTML='Almac&eacute;n de datos:';
                                            gE('lblValor2').innerHTML='Campo a proyectar:';
                                            gEx('cmbValor2').show();
                                            gEx('cmbValor1').show();
                                            gEx('cmbValor1').reset();
                                            gEx('cmbValor2').reset();
                                            var arrAlmacenDatos=obtenerAlmacenesDatosDisponibles(1);
                                            cmbValor1.getStore().loadData(arrAlmacenDatos);
                                        break;
                                        case '5':
                                        	gEx('vInsertarVariable').setHeight(160);
                                            gE('lblValor1').innerHTML='Valor de par&aacute;metro:';
                                            gE('lblValor2').innerHTML='';
                                            gEx('cmbValor2').hide();
                                            gEx('cmbValor1').show();
                                            gEx('cmbValor1').reset();
                                            gEx('cmbValor2').reset();
                                            gEx('cmbValor1').getStore().loadData(arrParametrosCalculo);
                                        break;
                                        case '6':
                                        	gEx('vInsertarVariable').setHeight(160);
                                            gE('lblValor1').innerHTML='Valor manual:';
                                            gE('lblValor2').innerHTML='';
                                            gEx('cmbValor2').hide();
                                            gEx('cmbValor1').show();
                                            gEx('cmbValor1').reset();
                                            gEx('cmbValor2').reset();
                                            gEx('cmbValor1').hide();
                                            gEx('txtEmailManual').show();
                                        break;
                                    }
                                }
    					)
    var cmbFuncionRenderer=crearComboExt('cmbFuncionRenderer',arrRenderer,130,35,280);
    cmbFuncionRenderer.setValue('0');
    var cmbValor1=crearComboExt('cmbValor1',[],130,35,280);
    cmbValor1.hide();
    var cmbValor2=crearComboExt('cmbValor2',[],130,65,280);
    cmbValor2.hide();
    cmbValor1.on('select',function(cmb,registro)
    						{
                            	switch(gEx('cmbTipoVariable').getValue())
                                {
	                                case '4':
                                    	var arrCampos=obtenerCamposDisponibles(registro.get('id'),true);
                                        cmbValor2.reset();
                                        cmbValor2.getStore().loadData(arrCampos);
                                    break;
                                }
                            }
    			)
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:lOrigen
                                                        },
                                                        cmbTipoVariable,
                                                        
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'<span id="lblValor1"></span>'
                                                        }
														,
                                                        {
                                                        	x:130,
                                                            y:35,
                                                            hidden:true,
                                                            id:'txtEmailManual',
                                                            xtype:'textfield',
                                                            width:280
                                                        },
                                                        cmbValor1,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'<span id="lblValor2"></span>'
                                                        }
														,
                                                        cmbValor2
                                                        

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vInsertarVariable',
										title: 'Agregar '+lAgregar,
										width: 500,
										height:130,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var tipoVariable=cmbTipoVariable.getValue();
                                                                        var etVariable;
                                                                        var lblTipoVariable='';
                                                                        if(tipoVariable=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbTipoVariable.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de variable a insertar',resp);
                                                                            return;
                                                                        }
                                                                        switch(tipoVariable)
                                                                        {
                                                                        	case '1':
                                                                            	if(cmbValor1.getValue()=='')
                                                                                {
                                                                                	function resp2()
                                                                                    {
                                                                                        cmbValor1.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el valor de sesi&oacute;n a insertar',resp2);
                                                                                    return;
                                                                                }
                                                                                etVariable='V. Sesion: '+cmbValor1.getRawValue();
                                                                            break;
                                                                            case '2':
                                                                            	if(cmbValor1.getValue()=='')
                                                                                {
                                                                                	function resp3()
                                                                                    {
                                                                                        cmbValor1.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el valor de sistema a insertar',resp3);
                                                                                    return;
                                                                                }
                                                                                 etVariable='V. Sistema: '+cmbValor1.getRawValue();
                                                                            break;
                                                                            case '3':
                                                                            	if(cmbValor1.getValue()=='')
                                                                                {
                                                                                	function resp4()
                                                                                    {
                                                                                        cmbValor1.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar la consulta auxiliar de la cual se obtendr&aacute; el valor a insertar',resp4);
                                                                                    return;
                                                                                }
                                                                                 etVariable='C. Aux.: '+cmbValor1.getRawValue();
                                                                            break;
                                                                            case '4':
                                                                            	if(cmbValor1.getValue()=='')
                                                                                {
                                                                                	function resp5()
                                                                                    {
                                                                                        cmbValor1.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el almac&eacute;n de datos del cual se obtendr&aacute; el valor a insertar',resp5);
                                                                                    return;
                                                                                }
                                                                                if(cmbValor2.getValue()=='')
                                                                                {
                                                                                	function resp7()
                                                                                    {
                                                                                        cmbValor2.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el campo del cual se obtendr&aacute; el valor a insertar',resp7);
                                                                                    return;
                                                                                }
                                                                                etVariable='Almacen: '+cmbValor2.getRawValue();
                                                                            break;
                                                                            case '5':
                                                                            	if(cmbValor1.getValue()=='')
                                                                                {
                                                                                	function resp6()
                                                                                    {
                                                                                        cmbValor1.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el par&aacute;metro a insertar',resp6);
                                                                                    return;
                                                                                }
                                                                                 etVariable='Parametro: '+cmbValor1.getRawValue();
                                                                            break;
                                                                            case '6':
                                                                            	var txtEmailManual=gEx('txtEmailManual');
                                                                            	if(txtEmailManual.getValue().trim()=='')
                                                                                {
                                                                                	function resp10()
                                                                                    {
                                                                                    	txtEmailManual.focus();
                                                                                    }
                                                                                    msgBox('Debe ingresar el '+lAgregar,resp10);
                                                                                    return;
                                                                                }
                                                                                var arrEmail=txtEmailManual.getValue().split(';');
                                                                                var tmp;
                                                                                var mail;
                                                                                var cadMailError='';
                                                                                for(tmp=0;tmp<arrEmail.length;tmp++)
                                                                                {
                                                                                	mail=arrEmail[tmp].trim();
                                                                                    
                                                                                    
                                                                                    if(validarCorreo(mail))
                                                                                    {
                                                                                    	etVariable='E-mail: '+mail;
                                                                                        lblTipoVariable=etVariable;
                                                                                        var claveDestinatario=lblTipoVariable+'||'+tipoVariable+'||'+mail+'||'+cmbValor2.getValue();
                                                                                        if(obtenerPosFila(grid.getStore(),'idDestinatario',claveDestinatario)==-1)
                                                                                        {
                                                                                            var r= new regDestinatario	(
                                                                                                                            {	
                                                                                                                                idDestinatario:claveDestinatario,
                                                                                                                                destinatario:lblTipoVariable,
                                                                                                                                tipoDestinatario:tipoVariable
                                                                                                                            }
                                                                                                                        )
                                                                                            grid.getStore().add(r);
                                                                                        }
                                                                                        if(grid.id=='gRemitente')
                                                                                        {
                                                                                        	break;
                                                                                        }
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                    	if(cadMailError=='')
                                                                                        	cadMailError=mail;
                                                                                        else
                                                                                        	cadMailError+='; '+mail;
                                                                                    }
                                                                                    
                                                                                }
                                                                                if(cadMailError!='')
                                                                                {
                                                                                	msgBox('Las siguientes direcciones electr&oacute;nicos no son v&aacute;lidas:<br><br>'+cadMailError.replace(/;/gi,'<br>'));
                                                                                    txtEmailManual.setValue(cadMailError);
                                                                                    return;
                                                                                }
                                                                                
                                                                            break;
                                                                        }
                                                                        if(tipoVariable!=6)
                                                                        {
                                                                       
                                                                            
                                                                            lblTipoVariable=etVariable;
                                                                            var claveDestinatario=lblTipoVariable+'||'+tipoVariable+'||'+cmbValor1.getValue()+'||'+cmbValor2.getValue();
                                                                            if(obtenerPosFila(grid.getStore(),'idDestinatario',claveDestinatario)==-1)
                                                                            {
                                                                                var r= new regDestinatario	(
                                                                                                                {	
                                                                                                                    idDestinatario:claveDestinatario,
                                                                                                                    destinatario:lblTipoVariable,
                                                                                                                    tipoDestinatario:tipoVariable
                                                                                                                }
                                                                                                            )
                                                                                grid.getStore().add(r);
                                                                            }
                                                                        }
                                                                        ventanaAM.close();
                                                                        
                                                                       
                                                                       	                                                                        
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}

function crearGridDocumentosAdjuntos()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idDocumento'},
                                                                {name: 'documento'},
                                                                {name: 'tamano'},
                                                                {name: 'tipoDocumento'}

                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														
														{
															header:'Documento',
															width:220,
															sortable:true,
															dataIndex:'documento',
                                                            renderer:function(val)	
                                                            		{
                                                                    	return mostrarValorDescripcion(val);
                                                                    }
														},
                                                        {
															header:'Tipo',
															width:160,
															sortable:true,
															dataIndex:'tipoDocumento',
                                                            renderer:function(val)
                                                            		{
                                                                    	switch(val)
                                                                        {
                                                                        	case '1':
                                                                            	return 'Documento de Galer&iacute;a';
                                                                            break;
                                                                            case '3':
                                                                            	return 'Consulta auxiliar';
                                                                            break;
                                                                            case '4':
                                                                            	return 'Almac\xE9n de datos';
                                                                            break;
                                                                        }
                                                                    }
														},
                                                        {
															header:'Tama&ntilde;o',
															width:150,
															sortable:true,
                                                            css:'text-align:right !important;',
															dataIndex:'tamano'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gAdjuntos',
                                                            store:alDatos,
                                                            frame:true,
                                                           	renderTo:'gridAdjuntos',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            height:160,
                                                            width:650,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar documento de Galer&iacute;a',
                                                                            handler:function()
                                                                            		{
                                                                                    	agregarDocumento();
                                                                                    }
                                                                            
                                                                        },
                                                                        '-',
                                                                        {
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar documento de Origen de Datos',
                                                                            handler:function()
                                                                            		{
                                                                                    	insertarDocumentoOrigenDatos()
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover documento',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getSelectionModel().getSelected();
                                                                                        if(filas==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el documento que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                    	function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
	                                                                                        	tblGrid.getStore().remove(filas);
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el documento seleccionado?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}


function agregarDocumento()
{
	var conf={};
    conf.url='../galeriaDocumentos/admonDocumentos.php';
    conf.titulo='Galer&iacute;a de documentos';
    conf.ancho='90%';
    conf.alto='95%';
    conf.params=[['soloDescarga',1],['cPagina','sFrm=true'],['fSel','window.parent.documentoSeleccionado']];
    abrirVentanaFancy(conf);
}

function documentoSeleccionado(idDocumento,url,objDoc)
{
	var almacen=gEx('gAdjuntos').getStore();

    if(obtenerPosFila(almacen,'idDocumento',objDoc.idDocumento)==-1)
    {
    	var r=new regDocumentos({idDocumento:objDoc.idDocumento,documento:objDoc.nombreArchivo,tamano:objDoc.tamano,tipoDocumento:1});
    	almacen.add(r);
   	}
}

function codificarVariable(cadena)
{

    cadena=cadena.replace(/á/gi,'&aacute;');
    cadena=cadena.replace(/é/gi,'&eacute;');
    cadena=cadena.replace(/í/gi,'&iacute;');
    cadena=cadena.replace(/ó/gi,'&oacute;');
    cadena=cadena.replace(/ú/gi,'&uacute;');
    cadena=cadena.replace(/Á/gi,'&Aacute;');
    cadena=cadena.replace(/É/gi,'&Eacute;');
    cadena=cadena.replace(/Í/gi,'&Iacute;');
    cadena=cadena.replace(/Ó/gi,'&Oacute;');
    cadena=cadena.replace(/Ú/gi,'&Uacute;');
    
    return cadena;
}


function insertarDocumentoOrigenDatos()
{
	var lAgregar='';
    var arrOrigenDatos=[['4','Almac\xE9n de datos'],['3','Consulta auxiliar']];
	arrRenderer.splice(0,1,['0','Ninguno']);
	var cmbTipoVariable=crearComboExt('cmbTipoVariable',arrOrigenDatos,130,5,280);
    
    cmbTipoVariable.on('select',function(cmb,registro)
    							{
                               		gEx('cmbValor1').show();
                                    gEx('txtEmailManual').hide();
                                	switch(registro.get('id'))
                                    {
                                    	case '1':
                                        	gEx('vInsertarVariable').setHeight(160);
                                            gE('lblValor1').innerHTML='Valor de sesi&oacute;n:';
                                            gE('lblValor2').innerHTML='';
                                            gEx('cmbValor2').hide();
                                            gEx('cmbValor1').show();
                                            gEx('cmbValor1').reset();
                                            gEx('cmbValor2').reset();
                                            gEx('cmbValor1').getStore().loadData(arrValorSesion);
                                            
                                        break;
                                        case '2':
                                        	gEx('vInsertarVariable').setHeight(160);
                                            gE('lblValor1').innerHTML='Valor de sistema:';
                                            gE('lblValor2').innerHTML='';
                                            gEx('cmbValor2').hide();
                                            gEx('cmbValor1').show();
                                            gEx('cmbValor1').reset();
                                            gEx('cmbValor2').reset();
                                            gEx('cmbValor1').getStore().loadData(arrValorSistema);
                                        break;
                                        case '3':
                                        	gEx('vInsertarVariable').setHeight(160);
                                            gE('lblValor1').innerHTML='Consulta auxiliar:';
                                            gE('lblValor2').innerHTML='';
                                            gEx('cmbValor2').hide();
                                            gEx('cmbValor1').show();
                                            gEx('cmbValor1').reset();
                                            gEx('cmbValor2').reset();
                                            var arrAlmacenDatos=obtenerAlmacenesDatosDisponibles(2);
                                           
                                            cmbValor1.getStore().loadData(arrAlmacenDatos);
                                        break;
                                        case '4':
                                        	gEx('vInsertarVariable').setHeight(190);
                                            gE('lblValor1').innerHTML='Almac&eacute;n de datos:';
                                            gE('lblValor2').innerHTML='Campo a proyectar:';
                                            gEx('cmbValor2').show();
                                            gEx('cmbValor1').show();
                                            gEx('cmbValor1').reset();
                                            gEx('cmbValor2').reset();
                                            var arrAlmacenDatos=obtenerAlmacenesDatosDisponibles(1);
                                            cmbValor1.getStore().loadData(arrAlmacenDatos);
                                        break;
                                        case '5':
                                        	gEx('vInsertarVariable').setHeight(160);
                                            gE('lblValor1').innerHTML='Valor de par&aacute;metro:';
                                            gE('lblValor2').innerHTML='';
                                            gEx('cmbValor2').hide();
                                            gEx('cmbValor1').show();
                                            gEx('cmbValor1').reset();
                                            gEx('cmbValor2').reset();
                                            gEx('cmbValor1').getStore().loadData(arrParametrosCalculo);
                                        break;
                                        case '6':
                                        	gEx('vInsertarVariable').setHeight(160);
                                            gE('lblValor1').innerHTML='Valor manual:';
                                            gE('lblValor2').innerHTML='';
                                            gEx('cmbValor2').hide();
                                            gEx('cmbValor1').show();
                                            gEx('cmbValor1').reset();
                                            gEx('cmbValor2').reset();
                                            gEx('cmbValor1').hide();
                                            gEx('txtEmailManual').show();
                                        break;
                                    }
                                }
    					)
    var cmbFuncionRenderer=crearComboExt('cmbFuncionRenderer',arrRenderer,130,35,280);
    cmbFuncionRenderer.setValue('0');
    var cmbValor1=crearComboExt('cmbValor1',[],130,35,280);
    cmbValor1.hide();
    var cmbValor2=crearComboExt('cmbValor2',[],130,65,280);
    cmbValor2.hide();
    cmbValor1.on('select',function(cmb,registro)
    						{
                            	switch(gEx('cmbTipoVariable').getValue())
                                {
	                                case '4':
                                    	var arrCampos=obtenerCamposDisponibles(registro.get('id'),true);
                                        cmbValor2.reset();
                                        cmbValor2.getStore().loadData(arrCampos);
                                    break;
                                }
                            }
    			)
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Origen de datos:'
                                                        },
                                                        cmbTipoVariable,
                                                        
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'<span id="lblValor1"></span>'
                                                        }
														,
                                                        {
                                                        	x:130,
                                                            y:35,
                                                            hidden:true,
                                                            id:'txtEmailManual',
                                                            xtype:'textfield',
                                                            width:280
                                                        },
                                                        cmbValor1,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'<span id="lblValor2"></span>'
                                                        }
														,
                                                        cmbValor2
                                                        

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vInsertarVariable',
										title: 'Agregar archivo adjunto',
										width: 500,
										height:130,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var tipoVariable=cmbTipoVariable.getValue();
                                                                        var etVariable;
                                                                        var lblTipoVariable='';
                                                                        if(tipoVariable=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbTipoVariable.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de variable a insertar',resp);
                                                                            return;
                                                                        }
                                                                        switch(tipoVariable)
                                                                        {
                                                                        	case '1':
                                                                            	if(cmbValor1.getValue()=='')
                                                                                {
                                                                                	function resp2()
                                                                                    {
                                                                                        cmbValor1.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el valor de sesi&oacute;n a insertar',resp2);
                                                                                    return;
                                                                                }
                                                                                etVariable='V. Sesion: '+cmbValor1.getRawValue();
                                                                            break;
                                                                            case '2':
                                                                            	if(cmbValor1.getValue()=='')
                                                                                {
                                                                                	function resp3()
                                                                                    {
                                                                                        cmbValor1.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el valor de sistema a insertar',resp3);
                                                                                    return;
                                                                                }
                                                                                 etVariable='V. Sistema: '+cmbValor1.getRawValue();
                                                                            break;
                                                                            case '3':
                                                                            	if(cmbValor1.getValue()=='')
                                                                                {
                                                                                	function resp4()
                                                                                    {
                                                                                        cmbValor1.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar la consulta auxiliar de la cual se obtendr&aacute; el valor a insertar',resp4);
                                                                                    return;
                                                                                }
                                                                                 etVariable='C. Aux.: '+cmbValor1.getRawValue();
                                                                            break;
                                                                            case '4':
                                                                            	if(cmbValor1.getValue()=='')
                                                                                {
                                                                                	function resp5()
                                                                                    {
                                                                                        cmbValor1.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el almac&eacute;n de datos del cual se obtendr&aacute; el valor a insertar',resp5);
                                                                                    return;
                                                                                }
                                                                                if(cmbValor2.getValue()=='')
                                                                                {
                                                                                	function resp7()
                                                                                    {
                                                                                        cmbValor2.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el campo del cual se obtendr&aacute; el valor a insertar',resp7);
                                                                                    return;
                                                                                }
                                                                                etVariable='Almacen: '+cmbValor2.getRawValue();
                                                                            break;
                                                                            case '5':
                                                                            	if(cmbValor1.getValue()=='')
                                                                                {
                                                                                	function resp6()
                                                                                    {
                                                                                        cmbValor1.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el par&aacute;metro a insertar',resp6);
                                                                                    return;
                                                                                }
                                                                                 etVariable='Parametro: '+cmbValor1.getRawValue();
                                                                            break;
                                                                            case '6':
                                                                            	var txtEmailManual=gEx('txtEmailManual');
                                                                            	if(txtEmailManual.getValue().trim()=='')
                                                                                {
                                                                                	function resp10()
                                                                                    {
                                                                                    	txtEmailManual.focus();
                                                                                    }
                                                                                    msgBox('Debe ingresar el '+lAgregar,resp10);
                                                                                    return;
                                                                                }
                                                                                var arrEmail=txtEmailManual.getValue().split(';');
                                                                                var tmp;
                                                                                var mail;
                                                                                var cadMailError='';
                                                                                for(tmp=0;tmp<arrEmail.length;tmp++)
                                                                                {
                                                                                	mail=arrEmail[tmp].trim();
                                                                                    
                                                                                    
                                                                                    if(validarCorreo(mail))
                                                                                    {
                                                                                    	etVariable='E-mail: '+mail;
                                                                                        lblTipoVariable=etVariable;
                                                                                        var claveDestinatario=lblTipoVariable+'||'+tipoVariable+'||'+mail+'||'+cmbValor2.getValue();
                                                                                        if(obtenerPosFila(grid.getStore(),'idDestinatario',claveDestinatario)==-1)
                                                                                        {
                                                                                            var r= new regDestinatario	(
                                                                                                                            {	
                                                                                                                                idDestinatario:claveDestinatario,
                                                                                                                                destinatario:lblTipoVariable,
                                                                                                                                tipoDestinatario:tipoVariable
                                                                                                                            }
                                                                                                                        )
                                                                                            grid.getStore().add(r);
                                                                                        }
                                                                                        if(grid.id=='gRemitente')
                                                                                        {
                                                                                        	break;
                                                                                        }
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                    	if(cadMailError=='')
                                                                                        	cadMailError=mail;
                                                                                        else
                                                                                        	cadMailError+='; '+mail;
                                                                                    }
                                                                                    
                                                                                }
                                                                                if(cadMailError!='')
                                                                                {
                                                                                	msgBox('Las siguientes direcciones electr&oacute;nicos no son v&aacute;lidas:<br><br>'+cadMailError.replace(/;/gi,'<br>'));
                                                                                    txtEmailManual.setValue(cadMailError);
                                                                                    return;
                                                                                }
                                                                                
                                                                            break;
                                                                        }
                                                                        var almacen=gEx('gAdjuntos').getStore();
																		var claveDestinatario=cmbValor1.getValue()+'||'+cmbValor2.getValue();
                                                                        if(obtenerPosFila(almacen,'idDocumento',claveDestinatario)==-1)
                                                                        {
                                                                            var r=new regDocumentos({idDocumento:claveDestinatario,documento:etVariable,tamano:'N/D',tipoDocumento:tipoVariable});
                                                                            almacen.add(r);
                                                                        }
                                                                        
                                                                        ventanaAM.close();
                                                                        
                                                                       
                                                                       	                                                                        
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}