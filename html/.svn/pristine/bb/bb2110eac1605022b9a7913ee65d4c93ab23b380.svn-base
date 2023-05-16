<?php
session_start();
include("configurarIdiomaJS.php");
include("conexionBD.php");

$consulta="SELECT idConsulta,nombreConsulta FROM 991_consultasSql ORDER BY nombreConsulta";
$arrRenderer=$con->obtenerFilasArreglo($consulta);

$idNotificacion=bD($_GET["iN"]);
$idProceso=bD($_GET["iP"]);


$idFormularioBase=obtenerFormularioBase($idProceso);
if($idFormularioBase=="")
	$idFormularioBase=-1;
	
$consulta="select * from(SELECT idGrupoElemento as idGrupoElemento,nombreCampo FROM 901_elementosFormulario WHERE idFormulario=".$idFormularioBase." AND tipoElemento IN(2,3,4,5,6,7,8,9,10,11,12,14,15,16,21,22,24,25,31)
			union
			SELECT tipoElemento as idGrupoElemento,campoUsr as nombreCampo FROM 9017_camposControlFormulario) as tmp order by nombreCampo 
		";
$arrCamposFormularioBase=$con->obtenerFilasArreglo($consulta);
	

?>


var idNotificacion=<?php echo $idNotificacion?>;
var idProceso=<?php echo $idProceso?>;
var arrCamposFormularioBase=<?php echo $arrCamposFormularioBase?>;
var arrParametrosGenerales=[];
var arrValoresCuerpo=[];
var arrRenderer=<?php echo $arrRenderer?>;
var arrParametros=[];
var arrParametrosCalculo=[];

var arrParametrosObjeto=[];
var regParametro=crearRegistro([{'name':'nParametro'},{'name':'orden'}]);
var arrTiposVariableEditor=[['4','Almac\xE9n de datos'],['3','Consulta auxiliar'],['5','Valor de par\xE1metro'],['1','Valor de sesi\xF3n'],['2','Valor de sistema']];
var tiposLlenado=[['4','Almac\xE9n de datos'],['3','Consulta auxiliar'],['7','Funci\xF3n de sistema'],['6','Valor de formulario base'],['5','Valor de par\xE1metro'],['1','Valor de sesi\xF3n'],['8','Valor manual'],['2','Valor de sistema']];							
var tiposLlenadoMacroProceso=[['4','Almac\xE9n de datos'],['3','Consulta auxiliar'],['7','Funci\xF3n de sistema'],['5','Valor de par\xE1metro'],['1','Valor de sesi\xF3n'],['8','Valor manual'],['2','Valor de sistema']];							

Ext.onReady(inicializar);

var altura;
function inicializar()
{
	arrParametrosCalculo.push(['idUsuarioDestinatario','ID usuario destinatario']);
    arrParametrosCalculo.push(['nombreUsuarioDestinatario','Nombre usuario destinatario']);
    arrParametrosCalculo.push(['idUsuarioRemitente','ID usuario remitente']);
    arrParametrosCalculo.push(['nombreUsuarioRemitente','Nombre usuario remitente']);
    if(gE('idMacroProceso').value=='-1')
    {
        arrParametrosCalculo.push(['idFormulario','ID formulario']);
        arrParametrosCalculo.push(['idRegistro','ID registro']);
        arrParametrosCalculo.push(['idReferencia','ID registro referencia']);
        arrParametrosCalculo.push(['idProceso','ID proceso']);
	}
    else
    {
    	 arrParametrosCalculo.push(['carpetaAdministrativa','Proceso Judicial']);
    }	
    arrParametrosGenerales=arrParametrosCalculo;     
     
     
	arrRenderer.splice(0,1,['0','Ninguno']);
	arrValoresCuerpo=eval(bD(gE('arrValoresCuerpo').value));
	
	obj={};
    obj.permitirRegistroParametro=false;

    obj.region='center';
    obj.idReferencia=gE('idNotificacion').value;
    obj.tDataSet=9067;
    obj.tituloConcepto='la notificaci&oacute;n';
	var arbol=crearArbolAlmacen(obj);	
    
    new Ext.Viewport(	{
                            layout: 'border',
                            items: [
                            			{
                                        	xtype:'panel',
                                            region:'center',
                                            cls:'panelSiugjWrap',
                                            layout:'border',
                                            tbar:[
                                            		{
                                                    	xtype:'label',
                                                    	html:'&nbsp;&nbsp;&nbsp;'
                                                     },
                                            		{
                                                        icon:'../images/salir.gif',
                                                        cls:'x-btn-text-icon',
                                                        text:'Salir',
                                                        handler:function()
                                                                {
                                                                    cancelarOperacion();
                                                                }
                                                        
                                                    },
                                            		{
                                                    	xtype:'tbspacer',
                                                        width:10
                                                    }
                                                    ,
                                                    {
                                                        icon:'../images/icon_big_tick.gif',
                                                        cls:'x-btn-text-icon',
                                                        text:'Guardar notificaci&oacute;n',
                                                        handler:function()
                                                                {
                                                                    var panelPrincipal=gEx('panelPrincipal');
                                                                    var cadObj='';
                                                                    var txtTitulo=gE('_tituloNotificacionvch');
                                                                    var _cveNotificacionvch=gE('_cveNotificacionvch');
                                                                    
                                                                    
                                                                    
                                                                    if(txtTitulo.value.trim()=='')
                                                                    {
                                                                        function resp()
                                                                        {
                                                                            panelPrincipal.setActiveTab(0);
                                                                            txtTitulo.focus();
                                                                        }
                                                                        msgBox('Debe ingresar el t&iacute;tulo de la notificaci&oacute;n',resp);
                                                                        return;
                                                                    }
                                                                    
                                                                    var txtDescripcion=gE('_descripcionvch');
                                                                    var _tableroControlAsociadoint=gE('_tableroControlAsociadoint');
                                                                    
                                                                    if(_tableroControlAsociadoint.selectedIndex==0)
                                                                    {
                                                                        function resp2()
                                                                        {
                                                                            panelPrincipal.setActiveTab(0);
                                                                            _tableroControlAsociadoint.focus();
                                                                        }
                                                                        msgBox('Debe indicar el tablero de control con el cual se vinculará la notificaci&oacute;n',resp2);
                                                                        return;
                                                                    }
                                                                    var idTablero=_tableroControlAsociadoint.options[_tableroControlAsociadoint.selectedIndex].value;
                                                                    
                                                                    
                                                                    
                                                                    var cuerpo=gEx('txtContenido').getValue();
                                                                    var x;
                                                                    var fila;
                                                                    var o;
                                                                    
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
                                                                    
																	var oR;
                                                                    var arrCamposTableroControl='';
                                                                    var gCamposTablero=gEx('gCamposTablero');
                                                                    for(x=0;x<gCamposTablero.getStore().getCount();x++)
                                                                    {
                                                                    	fila= gCamposTablero.getStore().getAt(x);
                                                                        
                                                                        oR='{"nombreCampo":"'+fila.data.nombreCampo+'","tipoLlenado":"'+fila.data.tipoLlenado+'","valor":"'+cv(fila.data.valor)+'"}';
                                                                        
                                                                        if(arrCamposTableroControl=='')
                                                                        	arrCamposTableroControl=oR;
                                                                        else
                                                                        	arrCamposTableroControl+=','+oR;
                                                                        
                                                                    }
                                                                    var arrValoresReferencia='';
                                                                    var gValoresReferencia=gEx('gValoresReferencia');
                                                                    for(x=0;x<gValoresReferencia.getStore().getCount();x++)
                                                                    {
                                                                    	fila= gValoresReferencia.getStore().getAt(x);
                                                                        
                                                                        oR='{"idValor":"'+cv(fila.data.idValor)+'","descripcion":"'+cv(fila.data.descripcion)+'","valor":"'+cv(fila.data.valor)+'"}';
                                                                        
                                                                        if(arrValoresReferencia=='')
                                                                        	arrValoresReferencia=oR;
                                                                        else
                                                                        	arrValoresReferencia+=','+oR;
                                                                        
                                                                    }
                                                                    var cmbNotificacion=gE('_notificacionRepetibleint');
                                                                    var notificacionRepetible=cmbNotificacion.options[cmbNotificacion.selectedIndex].value;
                                                                    var _marcarAtendidaAbrirint=gE('_marcarAtendidaAbrirint');
                                                                    var marcarAtendidaAbrir=_marcarAtendidaAbrirint.options[_marcarAtendidaAbrirint.selectedIndex].value;
                                                                    var _enviarMailint=gE('_enviarMailint');
                                                                    var enviarMail=_enviarMailint.options[_enviarMailint.selectedIndex].value;
                                                                    
                                                                    var enviarSMS=gE('_enviarSMSint');
                                                                    enviarSMS=enviarSMS.options[enviarSMS.selectedIndex].value;
                                                                    
                                                                    var enviarWhats=gE('_enviarWhatsint');
                                                                    enviarWhats=enviarWhats.options[enviarWhats.selectedIndex].value;

                                                                    cadObj='{"arrValoresReferencia":['+arrValoresReferencia+'],"arrCamposTableroControl":['+arrCamposTableroControl+'],"arrValoresCuerpo":"'+bE('['+aValoresCuerpo+']')+'","idNotificacion":"'+gE('idNotificacion').value+
                                                                            '","titulo":"'+cv(txtTitulo.value.trim())+'","descripcion":"'+cv(txtDescripcion.value.trim())+'","idTableroControl":"'+
                                                                            idTablero+'","cuerpo":"'+bE(cv(cuerpo.trim()))+'","idProceso":"'+gE('idProceso').value+
                                                                            '","notificacionRepetible":"'+notificacionRepetible+'","marcarAtendidaAbrir":"'+
                                                                            marcarAtendidaAbrir+'","enviarMail":"'+enviarMail+'","cveNotificacion":"'+cv(_cveNotificacionvch.value)+
                                                                            '","idMacroProceso":"'+gE('idMacroProceso').value+'","funcionRendererNotificacion":"'+gE('hFuncionRenderer').value+
                                                                            '","funcionApertura":"'+cv(gE('_funcionAperturaPersonalizadavch').value)+
                                                                            '","funcionAfterVisualizacion":"'+(gE('_funcionDespuesVisualizacionvch').value)+
                                                                            '","enviarSMS":"'+enviarSMS+'","enviarWhats":"'+enviarWhats+'"}';

                                                                    function funcAjax()
                                                                    {
                                                                        var resp=peticion_http.responseText;
                                                                        arrResp=resp.split('|');
                                                                        if(arrResp[0]=='1')
                                                                        {
                                                                            idNotificacion=arrResp[1];
                                                                            gE('idNotificacion').value=idNotificacion;
                                                                            window.parent.recargarGridNotificaciones();
                                                                            msgBox('La configuraci&oacute;n de la notificaci&oacute;n ha sido guardada correctamente');
                                                                        }
                                                                        else
                                                                        {
                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                        }
                                                                    }
                                                                    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=233&cadObj='+cadObj,true);                                                           
                                                                    
                                                                    
                                                                }
                                                    }            
                                                     
                                                  ],
                                            items:	[
                                           				 {
                                                         	xtype:'panel',
                                                            collapsible:true,
                                                            region: 'east',
                                                            width:350,
                                                            layout:'border',
                                                            items:[arbol]
                                                         },
                                                         {
                                                         	xtype:'panel',
                                                            region: 'center',
                                                            split:true,
                                                            layout:'border',
                                                            
                                                            items:	[
                                                            			
                                                                      	{
                                                                              id:'panelPrincipal',
                                                                              activeTab: 2,
                                                                              region:'center',
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
                                                                                                xtype:'tabpanel',
                                                                                                border:false,
                                                                                                frame:false,
                                                                                                cls:'tabPanelSIUGJ',
                                                                                                activeTab:0,
                                                                                                title:'Datos de la notificaci&oacute;n',
                                                                                                items:	[
                                                                                                			{
                                                                                                            	xtype:'panel',
                                                                                                                autoScroll:true,
                                                                                                                title:'Generales',
                                                                                                				contentEl:'tblConfGeneral',
                                                                                                            },
                                                                                                            {
                                                                                                            	xtype:'panel',
                                                                                                                layout:'border',
                                                                                                                title:'Valores de referencia adicionales',
                                                                                                                items:	[
                                                                                                                			crearGridValoresReferencia()
                                                                                                                		]
                                                                                                            }
                                                                                                		]
                                                                                                
                                                                                            }
                                                                              				,
                                                                                            {
                                                                                                
                                                                                                xtype:'panel',
                                                                                                layout:'border',
                                                                                                title:'Configuraci&oacute;n del tablero de control',
                                                                                                listeners:	{
                                                                                                                activate:function(p)
                                                                                                                        {
                                                                                                                            
                                                                                                                            if(!p.activado)
                                                                                                                            {
                                                                                                                                p.activado=true;
                                                                                                                                gEx('gCamposTablero').getView().refresh();
                                                                                                                                
                                                                                                                            }  
                                                                                                                        }
                                                                                                            },
                                                                                                items:	[
                                                                                                            crearGridCamposTableroControl()
                                                                                                        ]
                                                                                            },
                                                                                            {
                                                                                                
                                                                                                xtype:'panel',
                                                                                                title:'Cuerpo de la notificaci&oacute;n',
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
	                       
                           
	                          
                                    

}

function crearMCE(idMce)
{
	var posicion=0;
	FCKeditor.BasePath = '../Scripts/fckeditor/' ;
    var mce= new Ext.ux.FCKeditor	(
    									{
                                        
                                        	y:0,
                                        	Name : idMce,
                                            Height:obtenerDimensionesNavegador()[0]-110,
                                            ToolbarSet : 'Default',
                                            config:'../fckconfig4.js'

                                        }
    								)
    
     mce.on('editorRender',function(textEditor)
     						{
                            	textEditor.setValue(bD(gE('cuerpo').value));
                                setTimeout('cambiarTab()',200);
                                crearGridValoresReferencia(); 
                                
                                
                                
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
    gE('_cveNotificacionvch').focus();
    
}

function insertarParametro_click()
{
	
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Tipo de variable:'
                                                        },
                                                        {
                                                        	x:210,
                                                            y:10,

                                                            html:'<div id="divTipoVariable"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:65,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'<span id="lblValor">Funci&oacute;n renderer</span>:'
                                                        }
														,
                                                        {
                                                        	x:210,
                                                            y:60,

                                                            html:'<div id="divFuncionRenderer"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:115,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'<span id="lblValor1"></span>'
                                                        }
														,
                                                        {
                                                        	x:210,
                                                            y:110,

                                                            html:'<div id="divValor1"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:165,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'<span id="lblValor2"></span>'
                                                        }
														,
                                                        {
                                                        	x:210,
                                                            y:160,
                                                            html:'<div id="divValor2"></div>'
                                                        },
                                                        

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vInsertarVariable',
										title: 'Insertar variable de dato',
										width: 600,
										height:210,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                
                                                                	var cmbTipoVariable=crearComboExt('cmbTipoVariable',arrTiposVariableEditor,0,0,280,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divTipoVariable'});
    
                                                                    cmbTipoVariable.on('select',function(cmb,registro)
                                                                                                {
                                                                                                    switch(registro.get('id'))
                                                                                                    {
                                                                                                        case '1':
                                                                                                            gEx('vInsertarVariable').setHeight(280);
                                                                                                            gE('lblValor1').innerHTML='Valor de sesi&oacute;n:';
                                                                                                            gE('lblValor2').innerHTML='';
                                                                                                            oE('divValor2');
                                                                                                            mE('divValor1');
                                                                                                            gEx('cmbValor1').reset();
                                                                                                            gEx('cmbValor2').reset();
                                                                                                            gEx('cmbValor1').getStore().loadData(arrValorSesion);
                                                                                                            
                                                                                                        break;
                                                                                                        case '2':
                                                                                                            gEx('vInsertarVariable').setHeight(280);
                                                                                                            gE('lblValor1').innerHTML='Valor de sistema:';
                                                                                                            gE('lblValor2').innerHTML='';
                                                                                                            oE('divValor2');
                                                                                                            mE('divValor1');
                                                                                                            gEx('cmbValor1').reset();
                                                                                                            gEx('cmbValor2').reset();
                                                                                                            gEx('cmbValor1').getStore().loadData(arrValorSistema);
                                                                                                        break;
                                                                                                        case '3':
                                                                                                            gEx('vInsertarVariable').setHeight(280);
                                                                                                            gE('lblValor1').innerHTML='Consulta auxiliar:';
                                                                                                            gE('lblValor2').innerHTML='';
                                                                                                            oE('divValor2');
                                                                                                            mE('divValor1');
                                                                                                            gEx('cmbValor1').reset();
                                                                                                            gEx('cmbValor2').reset();
                                                                                                            var arrAlmacenDatos=obtenerAlmacenesDatosDisponibles(2);
                                                                                                           
                                                                                                            cmbValor1.getStore().loadData(arrAlmacenDatos);
                                                                                                        break;
                                                                                                        case '4':
                                                                                                            gEx('vInsertarVariable').setHeight(350);
                                                                                                            gE('lblValor1').innerHTML='Almac&eacute;n de datos:';
                                                                                                            gE('lblValor2').innerHTML='Campo a proyectar:';
                                                                                                            mE('divValor2');
                                                                                                            mE('divValor1');
                                                                                                            gEx('cmbValor1').reset();
                                                                                                            gEx('cmbValor2').reset();
                                                                                                            var arrAlmacenDatos=obtenerAlmacenesDatosDisponibles(1);
                                                                                                            cmbValor1.getStore().loadData(arrAlmacenDatos);
                                                                                                        break;
                                                                                                        case '5':
                                                                                                            gEx('vInsertarVariable').setHeight(280);
                                                                                                            gE('lblValor1').innerHTML='Valor de par&aacute;metro:';
                                                                                                            gE('lblValor2').innerHTML='';
                                                                                                            oE('divValor2');
                                                                                                            mE('divValor1');
                                                                                                            gEx('cmbValor1').reset();
                                                                                                            gEx('cmbValor2').reset();
                                                                                                            gEx('cmbValor1').getStore().loadData(arrParametrosCalculo);
                                                                                                        break;
                                                                                                    }
                                                                                                }
                                                                                        )
                                                                    var cmbFuncionRenderer=crearComboExt('cmbFuncionRenderer',arrRenderer,0,0,280,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divFuncionRenderer'});
                                                                    cmbFuncionRenderer.setValue('0');
                                                                    var cmbValor1=crearComboExt('cmbValor1',[],0,0,280,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divValor1'});
                                                                    var cmbValor2=crearComboExt('cmbValor2',[],0,0,280,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divValor2'});
                                                                    
                                                                    oE('divValor2');
                                                                    oE('divValor1');
                                                                    
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
                                                                
																}
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
                                                                    	var cmbFuncionRenderer=gEx('cmbFuncionRenderer');
                                                                    	var cmbTipoVariable=gEx('cmbTipoVariable');
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
                                                                        
                                                                        var cmbValor1=gEx('cmbValor1');
                                                                        var cmbValor2=gEx('cmbValor2');
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
														}
														
													]
									}
								);
	ventanaAM.show();	
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

function cancelarOperacion()
{
	function resp(btn)
    {
    	window.parent.cerrarVentanaFancy();
    }
    msgConfirm('¿Est&aacute; seguro de querer salir de la definici&oacute;n de la notificaci&oacute;n?',resp);
}

function crearGridCamposTableroControl()
{
	var cmbLlenado=crearComboExt('cmbLlenado',(gE('idMacroProceso').value=='-1'?tiposLlenado:tiposLlenadoMacroProceso),0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
   
 
    
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'nombreCampo'},
                                                        {name:'tipoDato'},
		                                                {name: 'tipoLlenado'},
                                                        {name: 'etiquetaValor'},
		                                                {name:'valor'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesFormulario.php'

                                                                                              }

                                                                                          ),
                                                            
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='234';
                                        var _tableroControlAsociadoint=gE('_tableroControlAsociadoint');
                                        proxy.baseParams.idTablero=_tableroControlAsociadoint.options[_tableroControlAsociadoint.selectedIndex].value;
                                        proxy.baseParams.idNotificacion=gE('idNotificacion').value;
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer({width:45}),
                                                        
                                                        {
                                                            header:'Campo de tablero de control',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'nombreCampo'
                                                        },
                                                        {
                                                            header:'Tipo de dato',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'tipoDato'
                                                        },
                                                        {
                                                            header:'Tipo de llenado',
                                                            width:250,
                                                            sortable:true,
                                                            dataIndex:'tipoLlenado',
                                                            editor:cmbLlenado,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(tiposLlenado,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Valor',
                                                            width:300,
                                                            sortable:true,
                                                            editor:{xtype:'textfield'},
                                                            dataIndex:'valor',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	var comp='';
                                                                        switch(registro.data.tipoLlenado)
                                                                        {
                                                                        	case '4':
                                                                            	comp='<a href=\'javascript:mostrarVentanaAlmacenDatosTableroControl("'+bE(registro.data.nombreCampo)+'")\'><img src="../images/pencil.png" width="14" height="14" title="Modificar" alt="Modificar"></a> ';
                                                                            break;
                                                                            case '7':
                                                                            	comp='<a href=\'javascript:mostrarVentanaFuncionSistemaTableroControl("'+bE(registro.data.nombreCampo)+'")\'><img src="../images/pencil.png" width="14" height="14" title="Modificar" alt="Modificar"></a> ';
                                                                            break;
                                                                        }
                                                                    	return comp+registro.data.etiquetaValor;
                                                                    }
                                                        }
                                                    ]
                                                );
                                                    
    var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gCamposTablero',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            border:false,
                                                            cm: cModelo,
                                                            cls:'gridSiugjPrincipal',
                                                            clicksToEdit:1,
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            columnLines : false, 
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :false,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: false,
                                                                                                startCollapsed:false
                                                                                            })
                                                        }
                                                    );
                                                    
                                                    
    tblGrid.on('beforeedit',function(e)
    						{
                            	

                                
                                if((e.field=='valor'))
                                {
                                	var control={xtype:'textfield',cls:'controlSIUGJ'};
                                    
									switch(e.record.data.tipoLlenado)
                                    {
                                    	case '1': //Valor de sesión
                                        	control=crearComboExt('ctrlValor',arrValorSesion,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
                                        break;
                                        case '2': //Valor de sistema
                                        	control=crearComboExt('ctrlValor',arrValorSistema,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
                                        break;
                                        case '3': //Consulta auxiliar
                                        	var arrAlmacenDatos=obtenerAlmacenesDatosDisponibles(2);
                                            control=crearComboExt('ctrlValor',arrAlmacenDatos,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
                                        break;
                                        case '4': //Almacen de datos
                                        	e.cancel=true;
                                        break;
                                        case '5': //Valor de parámetro
                                        	control=crearComboExt('ctrlValor',arrParametrosGenerales,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
                                        break;
                                        case '6':  //Valor de formulario base
                                        	control=crearComboExt('ctrlValor',arrCamposFormularioBase,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
                                        break;
                                        case '7':  //Función de sistema
                                        	e.cancel=true;
                                        break;
                                        case '8':  //Valor manual
                                        	control=new Ext.form.TextField({id:'ctrlValor',cls:'controlSIUGJ'});
                                        break;
                                        
                                    }
                                    
                                    
                                    e.grid.getColumnModel().setEditor(4,control);
                                    
                                }
                                
                                
                                	
                                
                                
                            }
    			)
                
                
	tblGrid.on('afteredit',function(e)
    						{
                            	if(e.field=='tipoLlenado')
                                {
                                	e.record.set('valor','');
                                    e.record.set('etiquetaValor','');
                                }
                                
                                
                                if(e.field=='valor')
                                {
                                
                                	var control=gEx('ctrlValor');
                                	if(control)
                                    {
                                    	switch(e.record.data.tipoLlenado)
                                        {
                                            case '1': //Valor de sesión
                                               
                                            case '2': //Valor de sistema
                                               
                                            case '3': //Consulta auxiliar
                                            case '5': //Valor de parámetro    
                                            case '6':  //Valor de formulario base
                                                var etiquetaValor='';
                                                
                                                var pos=obtenerPosFila(control.getStore(),'id',e.record.data.valor);
                                                etiquetaValor=control.getStore().getAt(pos).data.nombre;
                                                e.record.set('etiquetaValor',etiquetaValor);
                                            
                                            break;
                                            case '4': //Almacen de datos
                                                
                                            break;
                                            case '7':  //Función de sistema
                                                
                                            break;
                                            case '8':  //Valor manual
                                                e.record.set('etiquetaValor',e.value);
                                            break;
                                            
                                        }
                                        
                                            
	                                	
                                    }
                                }
                                
                            }
    			)                
    
                                                    
    return 	tblGrid;	
}

function tableroChange(cmb)
{
	gEx('gCamposTablero').getStore().reload();
}

function crearGridValoresReferencia()
{
	var dsDatos=eval(bD(gE('arrValoresReferencia').value));
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idValor'},
                                                                    {name: 'descripcion'},
                                                                    {name: 'valor'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:45}),
														
														{
															header:'ID valor',
															width:150,
															sortable:true,
															dataIndex:'idValor',
                                                            editor:{xtype:'textfield',cls:'controlSIUGJ'}
														},
														{
															header:'Descripci&oacute;n valor',
															width:400,
															sortable:true,
															dataIndex:'descripcion',
                                                             editor:{xtype:'textfield',cls:'controlSIUGJ'}
														},
                                                        {
															header:'Valor',
															width:150,
															sortable:true,
															dataIndex:'valor',
                                                            editor:{xtype:'textfield',cls:'controlSIUGJ'}
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gValoresReferencia',
                                                            store:alDatos,
                                                            frame:false,
                                                            clicksToEdit:1,
                                                            region:'center',
                                                            cm: cModelo,
                                                            cls:'gridSiugjPrincipal',
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : false,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar valor de referencia',
                                                                            handler:function()
                                                                            		{
                                                                                    	var reg=crearRegistro	(
                                                                                        							[
                                                                                                                    	{name: 'idValor'},
                                                                                                                        {name: 'descripcion'},
                                                                                                                        {name: 'valor'}
                                                                                                                    ]
                                                                                        						)
                                                                                   		var r=new reg	(
                                                                                        					{
                                                                                                            	idValor:'',
                                                                                                                descripcion:'',
                                                                                                                valor:''
                                                                                                            }
                                                                                        				)
                                                                                   
                                                                                    	tblGrid.getStore().add(r);
                                                                                        tblGrid.startEditing(tblGrid.getStore().getCount()-1,1);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover valor de referencia',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelectedCell();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el valor de referencia a remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        fila=tblGrid.getStore().getAt(fila[0]);
                                                                                        
                                                                                        
                                                                                        tblGrid.getStore().remove(fila);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function mostrarVentanaAlmacenDatosTableroControl(iCampo)
{
	
    var arrAlmacenesTC=obtenerAlmacenesDatosDisponibles(1);
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Almac&eacute;n de datos:'
                                                        },
                                                        {
                                                        	x:190,
                                                            y:10,
                                                            html:'<div id="divComboAlmacenDatos"></div>'
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:65,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Campo a vincular:'
                                                        },
                                                        {
                                                        	x:190,
                                                            y:60,
                                                            html:'<div id="divComboCampoVincula"></div>'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de almac&eacute;n de datos',
										width: 650,
										height:240,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	var cmbAlmacenesDatosTC=crearComboExt('cmbAlmacenesDatosTC',arrAlmacenesTC,0,0,360,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboAlmacenDatos'});
                                                                    cmbAlmacenesDatosTC.on('select',function(cmb,registro)
                                                                                                    {
                                                                                                        var arrCampos=obtenerCamposDisponibles(registro.get('id'),true);
                                                                                                        
                                                                                                        gEx('cmbCampoAlmacenesDatosTC').reset();
                                                                                                        gEx('cmbCampoAlmacenesDatosTC').getStore().loadData(arrCampos);	
                                                                                                    }
                                                                                        )
                                                                    var cmbCampoAlmacenesDatosTC=crearComboExt('cmbCampoAlmacenesDatosTC',[],0,0,360,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboCampoVincula'});
																}
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
                                                                    	var cmbAlmacenesDatosTC=gEx('cmbAlmacenesDatosTC');
																		if(cmbAlmacenesDatosTC.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	cmbAlmacenesDatosTC.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el almac&eacute;n de datos a vincular',resp1);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        var cmbCampoAlmacenesDatosTC=gEx('cmbCampoAlmacenesDatosTC');
                                                                        if(cmbCampoAlmacenesDatosTC.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbCampoAlmacenesDatosTC.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el campo del almac&eacute;n de datos a vincular',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        var pos=obtenerPosFila(gEx('gCamposTablero').getStore(),'nombreCampo',bD(iCampo));
                                                                        var fila=gEx('gCamposTablero').getStore().getAt(pos);
                                                                        fila.set('valor','{"idAlmacen":"'+cmbAlmacenesDatosTC.getValue()+'","campo":"'+cmbCampoAlmacenesDatosTC.getValue()+'","campoUsr":"'+cmbCampoAlmacenesDatosTC.getRawValue()+'"}');
                                                                        fila.set('etiquetaValor',cmbAlmacenesDatosTC.getRawValue()+'(Campo: '+cmbCampoAlmacenesDatosTC.getRawValue()+')');
                                                                        
                                                                        ventanaAM.close();
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
}

function mostrarVentanaFuncionSistemaTableroControl(iCampo)
{
	
    asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre,ventana)
                                            {
                                             	var pos=obtenerPosFila(gEx('gCamposTablero').getStore(),'nombreCampo',bD(iCampo));
                                                var fila=gEx('gCamposTablero').getStore().getAt(pos);
                                                fila.set('valor',idConsulta);
                                                fila.set('etiquetaValor',nombre);
                                                if(gEx('vAgregarExp'))
	                                                gEx('vAgregarExp').close();
                                            }
    mostrarVentanaExpresion(function(filaSelec,ventana)
    						{
                            	var pos=obtenerPosFila(gEx('gCamposTablero').getStore(),'nombreCampo',bD(iCampo));
                                var fila=gEx('gCamposTablero').getStore().getAt(pos);
                                fila.set('valor',filaSelec.data.idConsulta);
                                fila.set('etiquetaValor',filaSelec.data.nombreConsulta);
                                
                                ventana.close();
                            }
    						,true);
    
}


function abrirVentanaFuncion(tipo)
{
	mostrarVentanaExpresion(	function(fila,ventana)
    							{
                                	gE('funcionRendererNotificacion').value=fila.get('nombreConsulta');
                                    gE('hFuncionRenderer').value=fila.get('idConsulta');
                                    ventana.close();
                            	}
    							,true
                          );
}

function removerFuncion(tipo)
{
	gE('funcionRendererNotificacion').value='';
    gE('hFuncionRenderer').value='';
}

