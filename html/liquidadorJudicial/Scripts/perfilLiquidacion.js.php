<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	$consulta="select idValorSesion,descripcionValor,valorReemplazo from 8003_valoresSesion where tipo=1 order by descripcionValor ";
	$arrValorSesion=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select idValorSesion,descripcionValor,valorReemplazo from 8003_valoresSesion where tipo=2 order by descripcionValor ";
	$arrValorSistema=uEJ($con->obtenerFilasArreglo($consulta));
	
	
	$consultas="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE institucion=10 AND codigoUnidad LIKE '10000003%' ORDER BY unidad";
	$arrDistritos=$con->obtenerFilasArreglo($consultas);
	
	$consultas="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE institucion=12 AND codigoUnidad LIKE '10000003%' ORDER BY unidad";
	$arrCircuitos=$con->obtenerFilasArreglo($consultas);
	
	$consultas="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE institucion=13 AND codigoUnidad LIKE '10000003%' ORDER BY unidad";
	$arrMunicipios=$con->obtenerFilasArreglo($consultas);
	
	$consultas="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica ORDER BY nombreUnidad";
	$arrDespachos=$con->obtenerFilasArreglo($consultas);
	
?>

var arrDistritos=<?php echo $arrDistritos?>;
var arrCircuitos=<?php echo $arrCircuitos?>;
var arrMunicipios=<?php echo $arrMunicipios?>;
var arrDespachos=<?php echo $arrDespachos?>;


var arrValorSesion=<?php echo $arrValorSesion ?>;
var arrValorSistema=<?php echo $arrValorSistema ?>;    

var arrParametrosDefault=[['idFormulario','idFormulario'],['idRegistro','idRegistro']]
var arrVariables=[];
var arrParametrosPerfil=arrParametrosDefault;
var idAlineacionCalculo=-1;
var arrTiposEntrada=[['1','Valor Entero'],['2','Valor Decimal'],['3','Moneda'],['4','Fecha'],['5','Opciones Cerradas (Combo)'],['6','Opci\xF3n M\xFAltiple (Combo)']];
var arrFuenteDatos=[['1','Funci\xF3n de Sistema'],['2','Opciones Manuales']];
var arrTipoValor=[['1','Variables Globales/Acumulares'],['2','Valor de Sesi\xF3n'],['3','Valor de Par\xE1metro de Sistema'],['4','Valor de Par\xE1metro de Perfil']];
var arrTiposFormatoSalida=[['1','Entero'],['2','Decimal'],['3','Moneda'],['4','Fecha'],['5','Texto']];
    
var arrSiNo=<?php echo $arrSiNo ?>;
Ext.onReady(inicializar);

function inicializar()
{
	var registroBase=eval(bD(gE('registroBase').value));
    var objBase=null;
    if(registroBase.length>0)
    {
    	objBase=registroBase[0];
    }
    

    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                items:	[
                                                            {
                                                            	xtype:'panel',
                                                                layout:'border',
                                                                region:'center',
                                                                border:false,
                                                                cls:'panelSiugj',
                                                                title:'Concepto de Liquidaci&oacute;n',
                                                                items:	[
                                                                			{
                                                                            	xtype:'tabpanel',
                                                                                border:false,
                                                                                id:'tabPanelGeneral',
                                                                                cls:'tabPanelSIUGJ',
                                                                                region:'center',
                                                                                
                                                                                activeTab:0,
                                                                                tbar:	[
                                                                                			{
                                                                                                icon:'../images/guardar.PNG',
                                                                                                cls:'x-btn-text-icon',
                                                                                                height:30,
                                                                                                width:140,
                                                                                                id:'btnGuardar',
                                                                                                text:'Guardar',
                                                                                                handler:function()
                                                                                                        {
                                                                                                        	var cmbAmbitoGeneral=gEx('cmbAmbitoGeneral');
                                                                                                            
                                                                                                            var txtCvePerfil=gEx('txtCvePerfil');
                                                                                                            
                                                                                                            if(txtCvePerfil.getValue()=='')
                                                                                                            {
                                                                                                            	function resp()
                                                                                                                {
                                                                                                                	txtCvePerfil.focus();
                                                                                                                }
                                                                                                                msgBox('Debe ingresar la clave del concepto de liquidaci&oacute;n',resp);
                                                                                                                return;
                                                                                                            }
                                                                                                            
                                                                                                            var txtNombrePerfil=gEx('txtNombrePerfil');
                                                                                                            
                                                                                                            
                                                                                                            if(txtNombrePerfil.getValue()=='')
                                                                                                            {
                                                                                                            	function resp2()
                                                                                                                {
                                                                                                                	txtNombrePerfil.focus();
                                                                                                                }
                                                                                                                msgBox('Debe ingresar el nombre del concepto de liquidaci&oacute;n',resp2);
                                                                                                                return;
                                                                                                            }
                                                                                                            
                                                                                                            var txtDescripcion=gEx('txtDescripcionPerfil');
                                                                                                            
                                                                                                            var cmbSituacionActual=gEx('cmbSituacionActual');
                                                                                                            if(cmbSituacionActual.getValue()=='')
                                                                                                            {
                                                                                                            	function resp3()
                                                                                                                {
                                                                                                                	cmbSituacionActual.focus();
                                                                                                                }
                                                                                                                msgBox('Debe indicar la situaci&oacute;n del concepto de liquidaci&oacute;n',resp3);
                                                                                                                return;
                                                                                                            }
                                                                                                            
                                                                                                            var arrParametros='';
                                                                                                            var x;
                                                                                                            var fila;
                                                                                                            for(x=0;x<gEx('gParametros').getStore().getCount();x++)
                                                                                                            {
                                                                                                            	fila=gEx('gParametros').getStore().getAt(x);
                                                                                                                if(arrParametros=='')
                                                                                                                	arrParametros=fila.data.detallesParametro;
                                                                                                                else
                                                                                                                	arrParametros+=','+fila.data.detallesParametro;
                                                                                                            }
                                                                                                            
                                                                                                            var o='';
                                                                                                            var arrVariables='';
                                                                                                            var gridVariables=gEx('gridVariables');
                                                                                                            for(x=0;x<gEx('gridVariables').getStore().getCount();x++)
                                                                                                            {
                                                                                                            	fila=gEx('gridVariables').getStore().getAt(x);
                                                                                                                
                                                                                                                if(fila.data.nombreVariable=='')
                                                                                                                {
                                                                                                                	function respAux()
                                                                                                                    {
                                                                                                                    	gEx('tabPanelGeneral').setActiveTab(2);
                                                                                                                    	gEx('gridVariables').startEditing(x,2);
                                                                                                                    }
                                                                                                                    msgBox('Debe ingresar el nombre de la variable',respAux);
                                                                                                                    return;
                                                                                                                }
                                                                                                                
                                                                                                                o='{"nombreVariable":"'+fila.data.nombreVariable+'"}';
                                                                                                                if(arrVariables=='')
                                                                                                                	arrVariables=o;
                                                                                                                else
                                                                                                                	arrVariables+=','+o;
                                                                                                            }
                                                                                                            
                                                                                                            
                                                                                                           
                                                                                                            var arrDistritos='';
                                                                        
                                                                                                            var o='';
                                                                                                            var fila;
                                                                                                            var gridCatalogo=gEx('gridCatalogo_1');
                                                                                                            var x;
                                                                                                            
                                                                                                            for(x=0;x<gridCatalogo.getStore().getCount();x++)
                                                                                                            {
                                                                                                                fila=gridCatalogo.getStore().getAt(x);
                                                                                                                o='{"cveElemento":"'+fila.data.cveElemento+'"}';
                                                                                                                if(arrDistritos=='')
                                                                                                                    arrDistritos=o;
                                                                                                                else
                                                                                                                    arrDistritos+=','+o;
                                                                                                            }
                                                                                                            
                                                                                                            
                                                                                                            var arrCircuitos='';
                                                                                                            
                                                                                                            o='';
                                                                                                            
                                                                                                            gridCatalogo=gEx('gridCatalogo_2');
                                                                                                            for(x=0;x<gridCatalogo.getStore().getCount();x++)
                                                                                                            {
                                                                                                                fila=gridCatalogo.getStore().getAt(x);
                                                                                                                o='{"cveElemento":"'+fila.data.cveElemento+'"}';
                                                                                                                if(arrCircuitos=='')
                                                                                                                    arrCircuitos=o;
                                                                                                                else
                                                                                                                    arrCircuitos+=','+o;
                                                                                                            }
                                                                                                            
                                                                                                            
                                                                                                            var arrMunicipios='';
                                                                                                            
                                                                                                             o='';
                                                                                                            
                                                                                                            gridCatalogo=gEx('gridCatalogo_3');
                                                                                                            for(x=0;x<gridCatalogo.getStore().getCount();x++)
                                                                                                            {
                                                                                                                fila=gridCatalogo.getStore().getAt(x);
                                                                                                                o='{"cveElemento":"'+fila.data.cveElemento+'"}';
                                                                                                                if(arrMunicipios=='')
                                                                                                                    arrMunicipios=o;
                                                                                                                else
                                                                                                                    arrMunicipios+=','+o;
                                                                                                            }
                                                                                                            
                                                                                                            var arrDespachos='';
                                                                                                            
                                                                                                            
                                                                                                            gridCatalogo=gEx('gridCatalogo_4');
                                                                                                            for(x=0;x<gridCatalogo.getStore().getCount();x++)
                                                                                                            {
                                                                                                                fila=gridCatalogo.getStore().getAt(x);
                                                                                                                o='{"cveElemento":"'+fila.data.cveElemento+'"}';
                                                                                                                if(arrDespachos=='')
                                                                                                                    arrDespachos=o;
                                                                                                                else
                                                                                                                    arrDespachos+=','+o;
                                                                                                            }
                                                                                                            
                                                                                                            
                                                                                                            var cadObj='{"idRegistro":"'+gE('idPerfil').value+'","cvePerfil":"'+cv(txtCvePerfil.getValue())+'","nombrePerfil":"'+
                                                                                                            			cv(txtNombrePerfil.getValue())+'","descripcion":"'+cv(txtDescripcion.getValue())+
                                                                                                                        '","situacionActual":"'+cmbSituacionActual.getValue()+'","arrParametros":['+arrParametros+
                                                                                                                        '],"arrVariables":['+arrVariables+'],"ambitoGlobal":"'+gEx('cmbAmbitoAplicacion').getValue()+
                                                                                                                        '","arrDistritos":['+arrDistritos+'],"arrCircuitos":['+arrCircuitos+'],"arrMunicipios":['+arrMunicipios+
                                                                                                                        '],"arrDespachos":['+arrDespachos+']}';
                                                                                                        
                                                                                                        	
                                                                                                            
                                                                                                            var oConf={};
                                                                                                            oConf.tabla='20010_perfilesLiquidacion';
                                                                                                            oConf.campoBusqueda='cvePerfil';
                                                                                                            oConf.valor=txtCvePerfil.getValue();
                                                                                                            oConf.campoIRegistro='idRegistro';
                                                                                                            oConf.iRegistroIgnorar=gE('idPerfil').value;
                                                                                                            oConf.functionExisteRegistro=function()
                                                                                                            							{
                                                                                                                                        	function respAux()
                                                                                                                                            {
                                                                                                                                            	txtCvePerfil.focus();
                                                                                                                                            }
                                                                                                                                        	msgBox('La clave del concepto ingresada ya ha sido registrada anteriormente',respAux);
                                                                                                                                        
                                                                                                                                        }

                                                                                                             oConf.functionNoExisteRegistro=function()
                                                                                                            							{
                                                                                                                                        	function funcAjax()
                                                                                                                                            {
                                                                                                                                                var resp=peticion_http.responseText;
                                                                                                                                                arrResp=resp.split('|');
                                                                                                                                                if(arrResp[0]=='1')
                                                                                                                                                {
                                                                                                                                                    gE('idPerfil').value=arrResp[1];
                                                                                                                                                    gEx('tabCalculos').enable();
                                                                                                                                                    gEx('btnEjecutar').show();
                                                                                                                                                    gEx('btnEjecutar').enable();
                                                                                                                                                }
                                                                                                                                                else
                                                                                                                                                {
                                                                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesLiquidador.php',funcAjax, 'POST','funcion=1&cadObj='+cadObj,true);
                                                                                                                                        }
                                                                                                            
                                                                                                            validarNoExistenciaRegistro(oConf)
                                                                                                        
                                                                                                        	
                                                                                                        
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                            {
                                                                                                xtype:'tbspacer',
                                                                                                width:10
                                                                                            },
                                                                                            {
                                                                                                icon:'../images/icon_big_tick.gif',
                                                                                                cls:'x-btn-text-icon',
                                                                                                height:30,
                                                                                                width:140,
                                                                                                hidden:gE('idPerfil').value=='-1',
                                                                                                id:'btnEjecutar',
                                                                                                text:'Ejecutar Concepto de Liquidaci&oacute;n',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            var obj={};
                                                                                                            obj.ancho='100%';
                                                                                                            obj.alto='100%';
                                                                                                            obj.params=[['idPerfil',gE('idPerfil').value]],
                                                                                                            obj.url='../liquidadorJudicial/tblPerfilLiquidacionEjecucion.php';
                                                                                                        	abrirVentanaFancySuperior(obj);
                                                                                                        
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                            {
                                                                                                xtype:'tbspacer',
                                                                                                width:10
                                                                                            },
                                                                                            {
                                                                                                icon:'../images/salir.gif',
                                                                                                cls:'x-btn-text-icon',
                                                                                                height:30,
                                                                                                width:140,
                                                                                                text:'Salir',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            regresarPagina();
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                            {
                                                                                                icon:'../images/add.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                id:'btnAddVariable',
                                                                            					hidden:true,
                                                                                                text:'Agregar Variable',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            var reg=crearRegistro([{name: 'nombreVariable'}]);
                                                                                                            var r=new reg({"nombreVariable":""})
                                                                                                            gEx('gridVariables').getStore().add(r);
                                                                                                            gEx('gridVariables').startEditing(gEx('gridVariables').getStore().getCount()-1,2);
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                            
                                                                                            {
                                                                                                xtype:'tbspacer',
                                                                                                width:10
                                                                                            },
                                                                                            {
                                                                                                icon:'../images/add.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                height:30,
                                                                                                width:140,
                                                                                                hidden:true,
                                                                                                id:'btnAgregarParametro',
                                                                                                text:'Agregar Par&aacute;metro',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            mostrarVentanaParametros()
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                            {
                                                                                                icon:'../images/delete.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                id:'btnDelVariable',
                                                                            					hidden:true,
                                                                                                text:'Remover Variable',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            var fila=gEx('gridVariables').getSelectionModel().getSelected();
                                                                                                            if(!fila)
                                                                                                            {	
                                                                                                                msgBox('Debe seleccionar la variable que desea remover');
                                                                                                                return;
                                                                                                            }
                                                                                                            
                                                                                                            function respAuxVariable(btn)
                                                                                                            {

                                                                                                                if(btn=='yes')
                                                                                                                {
                                                                                                                	gEx('gridVariables').getStore().remove(fila);
                                                                                                                    arrParametrosPerfil=[];
                                                                                                                    for(x=0;x<arrParametrosDefault.length;x++)
                                                                                                                    {
                                                                                                                    	arrParametrosPerfil.push(arrParametrosDefault[x]);
                                                                                                                    }
                                                                                                                    

                                                                                                                    var x;

                                                                                                                    for(x=0;x<gEx('gParametros').getStore().getCount();x++)
                                                                                                                    {
                                                                                                                        fila=gEx('gParametros').getStore().getAt(x);
                                                                                                                        arrParametrosPerfil.push([fila.data.nombreParametro,fila.data.etiqueta]);
                                                                                                                        
                                                                                                                    }
                                                                                                                }
                                                                                                            }
                                                                                                            msgConfirm('Est&aacute; seguro de querer remover la variable seleccionada',respAuxVariable);
                                                                                                            
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                            {
                                                                                                xtype:'tbspacer',
                                                                                                width:10
                                                                                            },
                                                                                            {
                                                                                                icon:'../images/pencil.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                height:30,
                                                                                                width:140,
                                                                                                 hidden:true,
                                                                                                id:'btnModificarParametro',
                                                                                                text:'Modificar Par&aacute;metro',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            var fila=gEx('gParametros').getSelectionModel().getSelected();
                                                                                                            if(!fila)
                                                                                                            {	
                                                                                                                msgBox('Debe seleccionar el par&aacute;metro que desea modificar');
                                                                                                                return;
                                                                                                            }
                                                                                                           
                                                                                                            mostrarVentanaParametros(fila);
                                                                                                            
                                                                                                            
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                            
                                                                                            {
                                                                                                xtype:'tbspacer',
                                                                                                width:10
                                                                                            },
                                                                                            {
                                                                                                icon:'../images/delete.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                height:30,
                                                                                                width:140,
                                                                                                 hidden:true,
                                                                                                id:'btnRemoverParametro',
                                                                                                text:'Remover Par&aacute;metro',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            var fila=gEx('gParametros').getSelectionModel().getSelected();
                                                                                                            if(!fila)
                                                                                                            {	
                                                                                                                msgBox('Debe seleccionar el par&aacute;metro que desea remover');
                                                                                                                return;
                                                                                                            }
                                                                                                            
                                                                                                            function resp(btn)
                                                                                                            {
                                                                                                                if(btn=='yes')
                                                                                                                {
                                                                                                                    gEx('gParametros').getStore().remove(fila);
                                                                                                                }
                                                                                                            }
                                                                                                            msgConfirm('Est&aacute; seguro de querer remover el par&aacute;metro seleccionado',resp);
                                                                                                            
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                            
                                                                                            
                                                                                		],
                                                                                items:	[
                                                                                			{
                                                                                            	xtype:'panel',
                                                                                                title:'Generales',
                                                                                                border:false,
                                                                                                layout:'absolute',
                                                                                                defaultType: 'label',
                                                                                                listeners: 	{
                                                                                                                activate:function(p)
                                                                                                                        {
                                                                                                                        	gEx('btnGuardar').show();
                                                                                                                            gEx('btnAgregarParametro').hide();
                                                                                                                            gEx('btnModificarParametro').hide();
                                                                                                                            gEx('btnRemoverParametro').hide();
                                                                                                                            gEx('btnAddVariable').hide();
                                                                                                                            gEx('btnDelVariable').hide();
                                                                                                                        }
                                                                                                            },
                                                                                                items:	[
                                                                                                			{
                                                                                                            	x:10,
                                                                                                                y:10,
                                                                                                                html:'<span class="SIUGJ_Etiqueta">Cve. concepto: <span style="color:#F00">*</span></span>'
                                                                                                            },
                                                                                                            {
                                                                                                            	xtype:'textfield',
                                                                                                                x:230,
                                                                                                                y:5,
                                                                                                                cls:'controlSIUGJ',
                                                                                                                width:150,
                                                                                                                value:objBase?objBase.cvePerfil:'',
                                                                                                                id:'txtCvePerfil'
                                                                                                            },
                                                                                                            {
                                                                                                            	x:10,
                                                                                                                y:50,
                                                                                                                html:'<span class="SIUGJ_Etiqueta">Nombre del Concepto: <span style="color:#F00">*</span></span>'
                                                                                                            },
                                                                                                            {
                                                                                                            	xtype:'textfield',
                                                                                                                x:230,
                                                                                                                y:45,
                                                                                                                cls:'controlSIUGJ',
                                                                                                                width:350,
                                                                                                                value:objBase?objBase.nombrePerfil:'',
                                                                                                                id:'txtNombrePerfil'
                                                                                                            },
                                                                                                            {
                                                                                                            	x:10,
                                                                                                                y:90,
                                                                                                                html:'<span class="SIUGJ_Etiqueta">Descripci&oacute;n:</span>'
                                                                                                            },
                                                                                                            {
                                                                                                            	xtype:'textarea',
                                                                                                                x:230,
                                                                                                                y:85,
                                                                                                                cls:'controlSIUGJ',
                                                                                                                width:450,
                                                                                                                height:60,
                                                                                                                value:objBase?escaparBR(objBase.descripcion):'',
                                                                                                                id:'txtDescripcionPerfil'
                                                                                                            },
                                                                                                            {
                                                                                                            	x:10,
                                                                                                                y:160,
                                                                                                                html:'<span class="SIUGJ_Etiqueta">&Aacute;mbito Global: <span style="color:#F00">*</span></span>'
                                                                                                            },
                                                                                                            {
                                                                                                            	x:230,
                                                                                                                y:155,
                                                                                                                html:'<div id="divComboAmbito"></div>'
                                                                                                            },
                                                                                                            {
                                                                                                            	x:10,
                                                                                                                y:210,
                                                                                                                html:'<span class="SIUGJ_Etiqueta">Situaci&oacute;n Actual: <span style="color:#F00">*</span></span>'
                                                                                                            },
                                                                                                            {
                                                                                                            	x:230,
                                                                                                                y:205,
                                                                                                                html:'<div id="divComboSituacionActual"></div>'
                                                                                                            }
                                                                                                		]
                                                                                            },
                                                                                            {
                                                                                            	xtype:'panel',
                                                                                                border:false,
                                                                                                defaultType: 'label',
                                                                                                layout:'border',
                                                                                                listeners: 	{
                                                                                                                activate:function(p)
                                                                                                                        {
                                                                                                                        	gEx('btnAgregarParametro').show();
                                                                                                                            gEx('btnModificarParametro').show();
                                                                                                                            gEx('btnRemoverParametro').show();
                                                                                                                            gEx('btnAddVariable').hide();
                                                                                                                            gEx('btnDelVariable').hide();
                                                                                                                        }
                                                                                                            },
                                                                                                title:'Par&aacute;metros de arranque',
                                                                                                items:	[
                                                                                                			crearGridParametrosArranque()
                                                                                                		]
                                                                                            },
                                                                                            {
                                                                                            	xtype:'panel',
                                                                                                border:false,
                                                                                                defaultType: 'label',
                                                                                                layout:'border',
                                                                                                listeners: 	{
                                                                                                                activate:function(p)
                                                                                                                        {
                                                                                                                        	gEx('btnAgregarParametro').hide();
                                                                                                                            gEx('btnModificarParametro').hide();
                                                                                                                            gEx('btnRemoverParametro').hide();
                                                                                                                            gEx('btnAddVariable').show();
                                                                                                                            gEx('btnDelVariable').show();
                                                                                                                        }
                                                                                                            },
                                                                                                title:'Variables Globales/Acumuladoras',
                                                                                                items:	[
                                                                                                			crearGridVariables()
                                                                                                		]
                                                                                            },
                                                                                            
                                                                                            {
                                                                                                xtype:'tabpanel',
                                                                                                listeners: 	{
                                                                                                                activate:function(p)
                                                                                                                        {
                                                                                                                        	gEx('btnAddVariable').hide();
                                                                                                                            gEx('btnDelVariable').hide();
                                                                                                                        }
                                                                                                            },
                                                                                                id:'tpanelAmbito',
                                                                                                title:'&Aacute;mbito de Aplicaci&oacute;n',
                                                                                                activeTab:0,
                                                                                                items:	[
                                                                                                            {
                                                                                                                xtype:'panel',
                                                                                                                title:'Distritos',
                                                                                                                items:	[
                                                                                                                            crearGridCatalogos(1)
                                                                                                                        ]
                                                                                                            },
                                                                                                            {
                                                                                                                xtype:'panel',
                                                                                                                title:'Circuitos',
                                                                                                                items:	[
                                                                                                                            crearGridCatalogos(2)
                                                                                                                        ]
                                                                                                            },
                                                                                                            {
                                                                                                                xtype:'panel',
                                                                                                                title:'Municipios',
                                                                                                                items:	[
                                                                                                                            crearGridCatalogos(3)
                                                                                                                        ]
                                                                                                            },
                                                                                                            {
                                                                                                                xtype:'panel',
                                                                                                                title:'Despachos',
                                                                                                                items:	[
                                                                                                                            crearGridCatalogos(4)
                                                                                                                        ]
                                                                                                            }
                                                                                                        ]
                                                                                            },
                                                                                            {
                                                                                            	xtype:'panel',
                                                                                                id:'tabCalculos',
                                                                                                disabled:gE('idPerfil').value=='-1',
                                                                                                layout:'border',
                                                                                                listeners: 	{
                                                                                                                activate:function(p)
                                                                                                                        {
                                                                                                                        	gEx('btnAgregarParametro').hide();
                                                                                                                            gEx('btnModificarParametro').hide();
                                                                                                                            gEx('btnRemoverParametro').hide();
                                                                                                                            gEx('btnAddVariable').hide();
                                                                                                                            gEx('btnDelVariable').hide();
                                                                                                                        }
                                                                                                            },
                                                                                                title:'C&aacute;lculos',
                                                                                                items:	[
                                                                                                			crearGridCalculos()
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
                        
	var cmbSituacionActual=crearComboExt('cmbSituacionActual',[['1','Activo'],['0','Inactivo']],0,0,180,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboSituacionActual'});                        
	var cmbAmbitoAplicacion=crearComboExt('cmbAmbitoAplicacion',arrSiNo,0,0,180,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboAmbito'});                        

	cmbAmbitoAplicacion.on('select',function(cmb,registro)
    					{
                        	if(registro.data.id=='1')
                            {
                            	gEx('tpanelAmbito').disable();
                                var x;
                                for(x=1;x<=4;x++)
                                {
                                	gEx('gridCatalogo_'+x).getStore().removeAll();
                                }
                            }
                            else
                            {
                            	gEx('tpanelAmbito').enable();
                            }
                        }
    			)

    if(objBase)
    {
    	cmbAmbitoAplicacion.setValue(objBase.ambitoGlobal);
        dispararEventoSelectCombo('cmbAmbitoAplicacion');
		cmbSituacionActual.setValue(objBase.situacionActual);
	}
    
    
    arrParametrosPerfil=arrParametrosDefault;
    var x;
    var fila;
    for(x=0;x<gEx('gParametros').getStore().getCount();x++)
    {
        fila=gEx('gParametros').getStore().getAt(x);
        arrParametrosPerfil.push([fila.data.nombreParametro,fila.data.etiqueta]);
        
    }
}

function crearGridParametrosArranque()
{
	
	 
	var arrParametros=bD(gE('arrParametros').value);
	var dsDatos=eval(arrParametros);
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'nombreParametro'},
                                                                    {name: 'etiqueta'},
                                                                    {name:'detallesParametro'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);

                                                                                      
	
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            
                                                            {
                                                                header:'Etiqueta',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'etiqueta'
                                                            },
                                                            {
                                                                header:'Nombre del Par&aacute;metro',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'nombreParametro'
                                                            },
                                                            {
                                                                header:'Detalles',
                                                                width:650,
                                                                sortable:true,
                                                                dataIndex:'detallesParametro',
                                                                renderer:function(val)
                                                                		{
                                                                        	var obj=eval('['+val+']')[0];
                                                                        	var lblElemento='<b>Tipo de Entrada:</b> '+formatearValorRenderer(arrTiposEntrada,obj.tipoEntrada);
                                                                        	switch(obj.tipoEntrada)
                                                                            {
                                                                            	case '5':
                                                                                case '6':
                                                                                	lblElemento+='(<b>Fuente de Datos:</b> '+formatearValorRenderer(arrFuenteDatos,obj.fuenteDatos)+')';
                                                                                break;
                                                                            }
                                                                            
                                                                            
                                                                            return lblElemento;
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gParametros',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                cls:'gridSiugj',
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true
                                                            }
                                                        );
        return 	tblGrid;
}

function mostrarVentanaParametros(filaValor)
{
	var objParam=null;
    
    if(filaValor)
    {
    	objParam=eval('['+filaValor.data.detallesParametro+']')[0];

    }
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            region:'center',
                                                            id:'tabPanelParametro',
                                                            cls:'tabPanelSIUGJ',
                                                            activeTab:0,
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            id:'tab1Panel',
                                                                            defaultType: 'label',
                                                                            title:'Configuraci&oacute;n del Par&aacute;metro',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Etiqueta del Par&aacute;metro:'
                                                                                        },
                                                                                        {
                                                                                        	x:250,
                                                                                            y:5,
                                                                                            xtype:'textfield',
                                                                                            width:300,
                                                                                            id:'txtEtiqueta',
                                                                                            value:objParam?objParam.etiquetaParametro:'',
                                                                                            cls:'controlSIUGJ'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:50,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Nombre del Par&aacute;metro:'
                                                                                        },
                                                                                        {
                                                                                        	x:250,
                                                                                            y:45,
                                                                                            xtype:'textfield',
                                                                                            width:250,
                                                                                            value:objParam?objParam.nombreParametro:'',
                                                                                            enableKeyEvents :true,
                                                                                            maskRe:/^[_a-zA-Z0-9]$/,
                                                                                            
                                                                                            id:'txtNombreParametro',
                                                                                            cls:'controlSIUGJ'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:90,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Descripci&oacute;n del par&aacute;metro:'
                                                                                        },
                                                                                        {
                                                                                        	x:250,
                                                                                            y:85,
                                                                                            width:400,
                                                                                            height:60,
                                                                                            cls:'controlSIUGJ',
                                                                                            value:objParam?escaparBR(objParam.descripcion):'',
                                                                                            xtype:'textarea',
                                                                                            id:'txtDescripcion'
                                                                                            
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:160,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Tipo de Dato de Entrada:'
                                                                                        },
                                                                                        {
                                                                                            x:250,
                                                                                            y:155,                                                                                            
                                                                                            html:'<div id="dComboTipoEntrada"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:200,
                                                                                            id:'lblFuenteDatos1',
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            hidden:true,
                                                                                            html:'Fuente de Datos:'
                                                                                        },
                                                                                        {
                                                                                            x:250,
                                                                                            y:195,
                                                                                            hidden:true,
                                                                                            id:'cmbFuenteDatos1',                                                                                            
                                                                                            html:'<div id="dComboFuenteDatos"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:240,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            id:'lblFuncionSistema',
                                                                                            hidden:true,
                                                                                            html:'Funci&oacute;n de Sistema:'
                                                                                        },
                                                                                        {
                                                                                            xtype:'textfield',
                                                                                            id:'txtFuncionSistema',
                                                                                            x:250,
                                                                                            hidden:true,
                                                                                            y:235,
                                                                                            cls:'controlSIUGJ',
                                                                                            readOnly:true,
                                                                                            width:350
                                                                                        },
                                                                                        {
                                                                                            x:610,
                                                                                            y:243,
                                                                                            hidden:true,
                                                                                            id:'btnFuncionSistema',
                                                                                            html:'<a href="javascript:abrirVentanaFuncion(1)"><img src="../images/pencil.png" /></a>&nbsp;&nbsp;&nbsp;<a href="javascript:removerFuncion(1)"><img src="../images/cross.png" /></a>'
                                                                                        }
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'border',
                                                                            id:'tab2Panel',
                                                                            defaultType: 'label',
                                                                            title:'Opciones de Combo',
                                                                            items:	[
                                                                            			crearGridOpciones()
                                                                                     ]
                                                                        }
                                                            		]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Par&aacute;metro',
										width: 700,
                                        cls:'msgHistorialSIUGJ',
										height:465,
										layout: 'fit',
										plain:true,
										modal:true,
                                        closable:false,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	gEx('txtEtiqueta').focus(false,500);
                                                                	gEx('tabPanelParametro').hideTabStripItem(1);
                                                                	cmbTipoEntrada=crearComboExt('cmbTipoEntrada',arrTiposEntrada,0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'dComboTipoEntrada'});
                                                                    cmbTipoEntrada.on('select',function(cmb,registro)
                                                                    							{
                                                                                                	
                                                                                                    switch(registro.data.id)
                                                                                                    {
                                                                                                    	case '5':
                                                                                                        case '6':
                                                                                                        	
                                                                                                        	gEx('lblFuenteDatos1').show();
                                                                                                            gEx('cmbFuenteDatos1').show();
                                                                                                        break;
                                                                                                    	case '1':
                                                                                                        case '2':
                                                                                                        case '3':
                                                                                                        case '4':

                                                                                                        	gEx('lblFuenteDatos1').hide();
                                                                                                            gEx('cmbFuenteDatos1').hide();
                                                                                                            
                                                                                                            gEx('cmbFuenteDatos').setValue('');
                                                                                                            gEx('lblFuncionSistema').hide();
                                                                                                            gEx('txtFuncionSistema').hide();
                                                                                                            gEx('btnFuncionSistema').hide();
                                                                                                            gEx('gOpciones').getStore().removeAll();
                                                                                                            gEx('tabPanelParametro').hideTabStripItem(1);
                                                                                                        break;
                                                                                                    }
                                                                                                    
                                                                                                }
                                                                    				)
                                                                                    
                                                                    cmbFuenteDatos=crearComboExt('cmbFuenteDatos',arrFuenteDatos,0,0,200,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'dComboFuenteDatos'});
																	cmbFuenteDatos.on('select',function(cmb,registro)
                                                                    							{
                                                                                                	switch(registro.data.id)
                                                                                                    {
                                                                                                    	case '1':
                                                                                                        	gEx('lblFuncionSistema').show();
                                                                                                            gEx('txtFuncionSistema').show();
                                                                                                            gEx('btnFuncionSistema').show();
                                                                                                            gEx('gOpciones').getStore().removeAll();
                                                                                                            gEx('tabPanelParametro').hideTabStripItem(1);
                                                                                                        break;
                                                                                                        case '2':
                                                                                                        	gEx('lblFuncionSistema').hide();
                                                                                                            gEx('txtFuncionSistema').hide();
                                                                                                            gEx('btnFuncionSistema').hide();
                                                                                                            gEx('tabPanelParametro').unhideTabStripItem(1);
                                                                                                        break;
                                                                                                    }
                                                                                                }
                                                                    				)                
                                                                    gE('cmbFuenteDatos').parentNode.style="width:200px";                
                                                                    if(objParam)
                                                                    {
	                                                                    cmbTipoEntrada.setValue(objParam.tipoEntrada);
                                                                        dispararEventoSelectCombo('cmbTipoEntrada');
                                                                        gEx('cmbFuenteDatos').setValue(objParam.fuenteDatos);
                                                                        dispararEventoSelectCombo('cmbFuenteDatos');
                                                                        gEx('txtFuncionSistema').idFuncion=objParam.funcionSistema;
                                                                        gEx('txtFuncionSistema').setValue(objParam.lblFuncionSistema);
                                                                        var arrDatos=[];
                                                                        var x;
                                                                        var o;
                                                                        for(x=0;x<objParam.opcionesFuncion.length;x++)
                                                                        {
                                                                        	o=objParam.opcionesFuncion[x];
                                                                            arrDatos.push([(o.valorOpcion?o.valorOpcion:o[0]),(o.etiqueta?o.etiqueta:o[1])]);
                                                                        }
                                                                        gEx('gOpciones').getStore().loadData(arrDatos);
                                                                        
                                                                    }
                                                                    
                                                                }
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            width:140,
                                                            cls:'btnSIUGJCancel',
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
																		var txtEtiqueta=gEx('txtEtiqueta');
                                                                        
                                                                        if(txtEtiqueta.getValue()=='')
                                                                        {
                                                                            function resp1()
                                                                            {
                                                                            	gEx('tabpanel').setActiveTab(0);
                                                                                txtEtiqueta.focus();
                                                                            }
                                                                            msgBox('Debe indicar la etiqueta del par&aacute;metro',resp1);
                                                                            return;
																		}                                                                        
                                                                        var txtNombreParametro=gEx('txtNombreParametro');
                                                                        if(txtNombreParametro.getValue()=='')
                                                                        {
                                                                            function resp2()
                                                                            {
                                                                            	gEx('tabpanel').setActiveTab(0);
                                                                                txtNombreParametro.focus();
                                                                            }
                                                                            msgBox('Debe indicar el nombre del par&aacute;metro',resp2);
                                                                            return;
                                                                       	} 
                                                                        
                                                                        var cmbTipoEntrada=gEx('cmbTipoEntrada');
                                                                        if(cmbTipoEntrada.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	gEx('tabpanel').setActiveTab(0);
                                                                                cmbTipoEntrada.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de entrada del par&aacute;metro',resp3);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        var cmbFuenteDatos=gEx('cmbFuenteDatos');
                                                                        var txtFuncionSistema=gEx('txtFuncionSistema');
                                                                        var txtDescripcion=gEx('txtDescripcion');
                                                                        
                                                                        if((cmbTipoEntrada.getValue()=='5')||(cmbTipoEntrada.getValue()=='6'))
                                                                        {
                                                                        	if(cmbFuenteDatos.getValue()=='')
                                                                            {
                                                                            	function resp5()
                                                                                {
                                                                                    gEx('tabpanel').setActiveTab(0);
                                                                                    cmbFuenteDatos.focus();
                                                                                }
                                                                                msgBox('Debe indicar la fuente de datos de la entrada del par&aacute;metro',resp5);
                                                                                return;
                                                                            }
                                                                            else
                                                                            {
                                                                            	if(cmbFuenteDatos.getValue()=='1')
                                                                            	{
                                                                                	if((!txtFuncionSistema.idFuncion)||(txtFuncionSistema.idFuncion==-1))	
                                                                                	{
                                                                                    	function resp6()
                                                                                        {
                                                                                            gEx('tabpanel').setActiveTab(0);
                                                                                            
                                                                                        }
                                                                                        msgBox('Debe indicar la funci&oacute;n a ocupar como fuente de datos',resp6);
                                                                                        return;
                                                                                    }
                                                                                }
                                                                                
                                                                                
                                                                            }
                                                                        }
                                                                        
                                                                        
                                                                        var objArr='';
        																
                                                                        
                                                                        var x=0;
                                                                        var gOpciones=gEx('gOpciones');
                                                                        var fila;
                                                                        var o;
                                                                        for(x=0;x<gOpciones.getStore().getCount();x++)
                                                                        {
                                                                            fila=gOpciones.getStore().getAt(x);
                                                                            o='{"valorOpcion":"'+fila.data.valorOpcion+'","etiqueta":"'+fila.data.etiqueta+'"}';
                                                                            
                                                                            
                                                                            if(fila.data.valorOpcion=='')
                                                                            {
                                                                                function resp1()
                                                                                {
                                                                                	gEx('tabpanel').setActiveTab(1);
                                                                                    gOpciones.startEditing(x,2);
                                                                                }
                                                                                msgBox('Debe ingresar la clave de la opci&oacute;n',resp1);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(fila.data.etiqueta=='')
                                                                            {
                                                                                function resp2()
                                                                                {
                                                                                	gEx('tabpanel').setActiveTab(1);
                                                                                    gOpciones.startEditing(x,3);
                                                                                }
                                                                                msgBox('Debe ingresar la etiqueta de la opci&oacute;n',resp2);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(objArr=='')
                                                                                objArr=o;
                                                                            else
                                                                                objArr+=','+o;
                                                                            
                                                                            
                                                                        }
                                                                        
                                                                        if((cmbFuenteDatos.getValue()=='2')&&(objArr==''))
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	gEx('tabpanel').setActiveTab(1);

                                                                            }
                                                                            msgBox('Debe indicar las opciones a desplegar en el combo',resp4);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        var cadObj='{"etiquetaParametro":"'+cv(txtEtiqueta.getValue(),false,true)+'","nombreParametro":"'+cv(txtNombreParametro.getValue(),false,true)+
                                                                        			'","tipoEntrada":"'+cmbTipoEntrada.getValue()+'","fuenteDatos":"'+cmbFuenteDatos.getValue()+
                                                                                    '","funcionSistema":"'+(txtFuncionSistema.idFuncion?txtFuncionSistema.idFuncion:-1)+
                                                                                    '","lblFuncionSistema":"'+cv(gEx('txtFuncionSistema').getValue(),false,true)+
                                                                                    '","opcionesFuncion":['+objArr+'],"descripcion":"'+cv(txtDescripcion.getValue(),false,true)+'"}';
                                                                        
                                                                        
                                                                        if(!filaValor)
                                                                        {
                                                                            var reg=crearRegistro	(
                                                                                                        [
                                                                                                            {name: 'nombreParametro'},
                                                                                                            {name: 'etiqueta'},
                                                                                                            {name:'detallesParametro'}	
                                                                                                        ]
                                                                                                    )
                                                                            var r=new reg	(
                                                                                                {
                                                                                                    nombreParametro:txtNombreParametro.getValue(),
                                                                                                    etiqueta:txtEtiqueta.getValue(),
                                                                                                    detallesParametro:cadObj
                                                                                                }
                                                                                            )
                                                                        
                                                                            gEx('gParametros').getStore().add(r);
                                                                        }
                                                                        else
                                                                        {
                                                                        	filaValor.set('nombreParametro',txtNombreParametro.getValue());
                                                                            filaValor.set('etiqueta',txtEtiqueta.getValue());
                                                                            filaValor.set('detallesParametro',cadObj);
                                                                        }
                                                                        
                                                                        arrParametrosPerfil=arrParametrosDefault;
                                                                        var x;
                                                                        var fila;
                                                                        for(x=0;x<gEx('gParametros').getStore().getCount();x++)
                                                                        {
                                                                        	fila=gEx('gParametros').getStore().getAt(x);
                                                                            arrParametrosPerfil.push([fila.data.nombreParametro,fila.data.etiqueta]);
                                                                            
                                                                        }
                                                                        
                                                                        
                                                                        ventanaAM.close();
                                                                    }
														}
														
													]
									}
								);
	ventanaAM.show();	
}

function crearGridOpciones()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'valorOpcion'},
                                                                    {name: 'etiqueta'}
                                                                ]
                                                    }
                                                );


	var arrOpciones=[];//eval(bD(gE('arrOpciones').value));

    alDatos.loadData(arrOpciones);
	var chkRow=new Ext.grid.CheckboxSelectionModel({checkOnly:true,width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:40}),
														chkRow,
														{
															header:'Valor Opci&oacute;n',
															width:150,
															sortable:true,
                                                            editor:	{xtype:'textfield',cls:'controlSIUGJ'},
															dataIndex:'valorOpcion'
														},
														{
															header:'Etiqueta',
															width:300,
															sortable:true,
                                                            editor:	{xtype:'textfield',cls:'controlSIUGJ'},
															dataIndex:'etiqueta'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gOpciones',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                           	cm: cModelo,
                                                            clicksToEdit:1,
                                                            stripeRows :true,
                                                            cls:'gridSiugj',
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            height:210,
                                                            width:650,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar Opci&oacute;n',
                                                                            handler:function()
                                                                                    {
                                                                                        var gOpciones=gEx('gOpciones');
                                                                                        
                                                                                        var reg=crearRegistro	(
                                                                                                                    [
                                                                                                                        {name: 'valorOpcion'},
                                                                                                                        {name: 'etiqueta'}
                                                                                                                    ]
                                                                                                                )
                                                                                        
                                                                                        var r=new  reg	(
                                                                                                            {
                                                                                                                valorOpcion:'',
                                                                                                                etiqueta:''
                                                                                                            }
                                                                                                        )  	
                                                                                    
                                                                                    
                                                                                        var gOpciones=gEx('gOpciones');
                                                                                        gOpciones.getStore().add(r);
                                                                                        gOpciones.startEditing(gOpciones.getStore().getCount()-1,2);
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                            icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover Opcion',
                                                                            handler:function()
                                                                                    {
                                                                                        var fila=gEx('gOpciones').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                            msgBox('Debe seleccinar la opci&oacute;n que desea remover');
                                                                                            return;
                                                                                        }
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                            gEx('gOpciones').getStore().remove(fila);
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover la opci&oacute;n seleccionada?',resp);
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}


function abrirVentanaFuncion(tipo)
{
	mostrarVentanaExpresion(	function(fila,ventana)
    							{
                                	if(tipo==1)
                                    {
                                        gEx('txtFuncionSistema').setValue(fila.get('nombreConsulta'));
                                        gEx('txtFuncionSistema').idFuncion=fila.get('idConsulta');
                                    }
                                    else
                                    {
                                        
                                    }
                                    ventana.close();
                            	}
    							,true
                          );
}

function removerFuncion(tipo)
{
	if(tipo==1)
    {
        gEx('txtFuncionSistema').setValue('');
        gEx('txtFuncionSistema').idFuncion=-1;
    }
    else
    {
       
    }
}

function crearGridVariables()
{	
	var dsDatos=eval(bD(gE('arrVariables').value));
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'nombreVariable'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:40}),
														chkRow,
														{
															header:'Nombre Variable',
															width:400,
															sortable:true,
                                                            editor:	{
                                                            			enableKeyEvents :true,
                                                                        cls:'controlSIUGJ',
                                                                        maskRe:/^[_a-zA-Z0-9]$/
                                                            		},
															dataIndex:'nombreVariable'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridVariables',
                                                            store:alDatos,
                                                            frame:true,
                                                            cm: cModelo,
                                                            cls:'gridSiugj',
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            region:'center',
                                                            columnLines : true,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
}


function crearGridCalculos()
{
	var arrTipoPrecision=[['1','Redondear'],['2','Truncar']];
	var cmbTipoPrecisionResultado=crearComboExt('cmbTipoPrecisionResultado',arrTipoPrecision,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
	var cmbTipoPrecisionResultadoPresentacion=crearComboExt('cmbTipoPrecisionResultadoPresentacion',arrTipoPrecision,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
	
    var cmbEditorSiNo=crearComboExt('cmbEditorSiNo',arrSiNo,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
    var cmbEditorOrden=crearComboExt('cmbEditorOrden',[],0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
    var cmbFormatoResultado=crearComboExt('cmbFormatoResultado',arrTiposFormatoSalida,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistroCalculo'},
		                                                {name: 'idCalculo'},
		                                                {name:'nombreCalculo'},
		                                                {name: 'orden'},
                                                        {name: 'parametrosEntrada'},
                                                        {name: 'variablesAfecta'},
                                                        {name: 'funcionAplicacion'},
                                                        {name: 'lblFuncionAplicacion'},
                                                        {name: 'mostrarResultado'},
                                                        {name: 'etiquetaResultado'},
                                                        {name: 'formatoResultado'},
                                                        {name: 'precisionResultado'},
                                                        {name: 'tipoPrecision'},
                                                        {name: 'precisionFormatoResultado'},
                                                        {name: 'tipoPrecisionResultado'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesLiquidador.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'orden', direction: 'ASC'},
                                                            groupField: 'orden',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='3';
                                        proxy.baseParams.idPerfil=gE('idPerfil').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            {
                                                                header:'Orden',
                                                                width:120,
                                                                sortable:true,
                                                                editor:cmbEditorOrden,
                                                                dataIndex:'orden'
                                                            },
                                                            {
                                                                header:'C&aacute;lculo',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'nombreCalculo'
                                                            },
                                                            {
                                                                header:'Funci&oacute;n de aplicaci&oacute;n',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'lblFuncionAplicacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var comp='';
                                                                            
                                                                            if(val!='')
                                                                            {
                                                                            	comp='<a href="javascript:removerFuncionAplicacion(\''+bE(registro.data.idRegistroCalculo)+'\')"><img width="14" height="14" title="Remover funci&oacute;n de aplicaci&oacute;n" alt="Remover funci&oacute;n de aplicaci&oacute;n"  src="../images/cross.png"></a> ';
                                                                            }
                                                                            
                                                                            
                                                                        	return '<a href="javascript:agregarFuncionAplicacion(\''+bE(registro.data.idRegistroCalculo)+
                                                                            		'\')"><img title="Asignar funci&oacute;n de aplicaci&oacute;n" alt="Asignar funci&oacute;n de aplicaci&oacute;n" width="14" height="14" src="../images/pencil.png"></a> '+comp+val;
                                                                        }
                                                            },
                                                            {
                                                                header:'Par&aacute;metros de Entrada',
                                                                width:700,
                                                                sortable:true,
                                                                dataIndex:'parametrosEntrada',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var tipoValorParametro;
                                                                            var tablaRenderer='<table>';
                                                                        	var x;
                                                                            var xAux;
                                                                            for(x=0;x<val.length;x++)
                                                                            {
                                                                            	tipoValorParametro='';
                                                                                if(val[x][2]!='')
                                                                                {
                                                                                    tipoValorParametro='<b>'+formatearValorRenderer(arrTipoValor,val[x][2])+':</b> ';
                                                                                    switch(val[x][2])
                                                                                    {
                                                                                        case '1':
                                                                                            var arrVariables=[];
    
    
                                                                                            for(xAux=0;xAux<gEx('gridVariables').getStore().getCount();xAux++)
                                                                                            {
                                                                                                fila=gEx('gridVariables').getStore().getAt(xAux);
                                                                                                arrVariables.push([fila.data.nombreVariable,fila.data.nombreVariable]);    	    
                                                                                            }            	
                                                                                            tipoValorParametro+=formatearValorRenderer(arrVariables,val[x][1]);
                                                                                        break;
                                                                                        case '2':
                                                                                             tipoValorParametro+=formatearValorRenderer(arrValorSesion,val[x][1]);
                                                                                        
                                                                                        break;
                                                                                        case '3':
                                                                                            tipoValorParametro+=formatearValorRenderer(arrValorSistema,val[x][1]);
                                                                                        
                                                                                        break;
                                                                                        case '4':
                                                                                            tipoValorParametro+=formatearValorRenderer(arrParametrosPerfil,val[x][1]);
                                                                                            
                                                                                        break;
                                                                                    }
                                                                                }
                                                                            	tablaRenderer+='<tr id="fila_'+bE(val[x][0])+'"><td width="120"><span class="lblSIUGJ">'+val[x][0]+'</span></td><td><span class="lblSIUGJ">'+tipoValorParametro+'</span></td><td><a href="javascript:mostrarVentanaParametroEntrada(\''+bE(registro.data.idRegistroCalculo)+'\',\''+bE(val[x][0])+'\')"><img src="../images/pencil.png" width="14" height="14"></a></td></tr>'
                                                                            }
                                                                            tablaRenderer+='</table>';
                                                                            return tablaRenderer;
                                                                        }
                                                            },
                                                            {
                                                                header:'Precisi&oacute;n del resultado',
                                                                width:240,
                                                                sortable:true,
                                                                editor:{xtype:'numberfield',allowDecimals:false,allowNegative:false,cls:'SIUGJ_Etiqueta'},
                                                                dataIndex:'precisionResultado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val+ 'decimales';
                                                                        }
                                                            },
                                                            {
                                                                header:'Tipo de precisi&oacute;n',
                                                                width:220,
                                                                sortable:true,
                                                                editor:cmbTipoPrecisionResultado,
                                                                dataIndex:'tipoPrecision',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoPrecision,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Variables que afecta',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'variablesAfecta',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var tablaRenderer='<table>';
                                                                        	var comp='<a href="javascript:mostrarVentanaVariable(\''+bE(registro.data.idRegistroCalculo)+'\')"><img width="14" height="14" title="Agregar Variable" alt="Agregar Variable" src="../images/pencil.png"></a><br>';
                                                                        	var x;
                                                                            for(x=0;x<val.length;x++)
                                                                            {
                                                                            	tablaRenderer+='<tr id="fila_'+bE(val[x][0])+'"><td><a href="javascript:removerVariable(\''+bE(registro.data.idRegistroCalculo)+'\',\''+bE(val[x][0])+'\')"><img src="../images/delete.png" width="14" height="14"></a></td><td><span class="lblSIUGJ">'+val[x][0]+' (Afectaci&oacute;n: '+val[x][1]+')</span></td></tr>'
                                                                            }
                                                                            tablaRenderer+='</table>';
                                                                            return comp+tablaRenderer;
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Mostrar resultado en resumen',
                                                                width:280,
                                                                sortable:true,
                                                                editor:cmbEditorSiNo,
                                                                dataIndex:'mostrarResultado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSiNo,val);
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Etiqueta del resultado',
                                                                width:250,
                                                                sortable:true,
                                                                editor:{xtype:'textfield', 'cls':'SIUGJ_Etiqueta'},
                                                                dataIndex:'etiquetaResultado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Formato del resultado',
                                                                width:250,
                                                                sortable:true,
                                                                editor:cmbFormatoResultado,
                                                                dataIndex:'formatoResultado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTiposFormatoSalida,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Precisi&oacute;n',
                                                                width:140,
                                                                sortable:true,
                                                                editor:{xtype:'numberfield',allowDecimals:false,allowNegative:false,cls:'SIUGJ_Etiqueta'},
                                                                dataIndex:'precisionFormatoResultado',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        
                                                                        	if((registro.data.formatoResultado=='4')||(registro.data.formatoResultado=='5'))
                                                                            	return 'N/A';
                                                                        	return val+' decimales';
                                                                        }
                                                            },
                                                            {
                                                                header:'Tipo de precisi&oacute;n',
                                                                width:220,
                                                                sortable:true,
                                                                editor:cmbTipoPrecisionResultadoPresentacion,
                                                                dataIndex:'tipoPrecisionResultado',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if((registro.data.formatoResultado=='4')||(registro.data.formatoResultado=='5'))
                                                                            	return 'N/A';
                                                                        	return formatearValorRenderer(arrTipoPrecision,val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gCalculos',
                                                                cls:'gridSiugj',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                clicksToEdit:1,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true, 
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                height:30,
                                                                                text:'Agregar C&aacute;lculo',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaExpresion(	function(fila,ventana)
                                                                                                                        {
                                                                                                                            var cadObj='{"idPerfil":"'+gE('idPerfil').value+'","idCalculo":"'+fila.data.idConsulta+'"}';
                                                                                                                            function funcAjax()
                                                                                                                            {
                                                                                                                                var resp=peticion_http.responseText;
                                                                                                                                arrResp=resp.split('|');
                                                                                                                                if(arrResp[0]=='1')
                                                                                                                                {
                                                                                                                                    gEx('gCalculos').getStore().reload();
                                                                                                                                    ventana.close();
                                                                                                                                }
                                                                                                                                else
                                                                                                                                {
                                                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                                }
                                                                                                                            }
                                                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesLiquidador.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true);

                                                                                                                            
                                                                                                                            
                                                                                                                        }
                                                                                                                        ,true,
                                                                                                                        {
                                                                                                                        	idCategoriaDefault:107,
                                                                                                                            funcionAgregarCalculo:'agregarCalculoPerfil'
                                                                                                                        }
                                                                                                                  );
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                                xtype:'tbspacer',
                                                                                width:10
                                                                            },
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                height:30,
                                                                                text:'Remover C&aacute;lculo',
                                                                                handler:function()
                                                                                        {
                                                                                            
                                                                                        }
                                                                                
                                                                            }
                                                                		],                                                               
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
                                	if(e.field=='orden')
                                    {	
                                    	var arrElementos=[];
                                    	var total=e.grid.getStore().getCount();
                                        var x;
                                        for(x=1;x<=e.grid.getStore().getCount();x++)
                                        {
                                        	arrElementos.push([x,x]);
                                        }
                                        gEx('cmbEditorOrden').getStore().loadData(arrElementos);
                                    }
                                    if((e.field=='precisionFormatoResultado')||(e.field=='tipoPrecisionResultado'))
                                    {
                                    	if((e.record.data.formatoResultado=='4')||(e.record.data.formatoResultado=='5'))
                                        {
                                        	e.cancel=true;
                                        }
                                    }
                                }
    			)

	tblGrid.on('afteredit',function(e)
    							{
                                	var cadObj='{"idRegistro":"'+e.record.data.idRegistroCalculo+'","campo":"'+e.field+'","valor":"'+e.value+'"}';
                                	function funcAjax()
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                        	if(e.field=='orden')
	                                            gEx('gCalculos').getStore().reload();
                                        }
                                        else
                                        {
                                        	function respErr()
                                            {
                                            	e.record.set(e.field,e.originalValue);
                                            }
                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0],respErr);
                                        }
                                    }
                                    obtenerDatosWeb('../paginasFunciones/funcionesLiquidador.php',funcAjax, 'POST','funcion=4&cadObj='+cadObj,true);

                                }
    			)

	return 	tblGrid;
}


function agregarCalculoPerfil(a,v,c)
{
	var cadObj='{"idPerfil":"'+gE('idPerfil').value+'","idCalculo":"'+v+'"}';
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('gCalculos').getStore().reload();
            gEx('vAgregarExp').close();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesLiquidador.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true);



    	
}

function agregarFuncionAplicacion(iR)
{
	idAlineacionCalculo=bD(iR);
	 mostrarVentanaExpresion(	function(fila,ventana)
                                {
                                    var cadObj='{"idAlineacionCalculo":"'+idAlineacionCalculo+'","idCalculo":"'+fila.data.idConsulta+'"}';
                                    function funcAjax()
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                            gEx('gCalculos').getStore().reload();
                                            ventana.close();
                                        }
                                        else
                                        {
                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                        }
                                    }
                                    obtenerDatosWeb('../paginasFunciones/funcionesLiquidador.php',funcAjax, 'POST','funcion=5&cadObj='+cadObj,true);

                                    
                                    
                                }
                                ,true,
                                {
                                    funcionAgregarCalculo:'agregarCalculoPerfil'
                                }
                          );	
}

function agregarCalculoFuncionAplicacion(a,v,c)
{
	var cadObj='{"idAlineacionCalculo":"'+idAlineacionCalculo+'","idCalculo":"'+v+'"}';
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('gCalculos').getStore().reload();
            gEx('vAgregarExp').close();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesLiquidador.php',funcAjax, 'POST','funcion=5&cadObj='+cadObj,true);



    	
} 

function removerFuncionAplicacion(iR)
{

	function resp(btn)
    {
    	if(btn=='yes')
        {
            var cadObj='{"idAlineacionCalculo":"'+bD(iR)+'","idCalculo":"-1"}';
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    gEx('gCalculos').getStore().reload();
                    ventana.close();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesLiquidador.php',funcAjax, 'POST','funcion=5&cadObj='+cadObj,true);
		}
    }
    msgConfirm('Est&aacute; seguro de querer remover la funci&oacute;n de aplicaci&oacute;n?',resp);
}

function mostrarVentanaVariable(iR)
{
	var cmbVariables;
    var cmbAfectacion;
	var gridVariables=gEx('gridVariables');
	var fila;
    var x;
    var arrVariables=[];
    var arrAfectacion=[['+','+'],['-','-']];
    
    for(x=0;x<gridVariables.getStore().getCount();x++)
    {
    	fila=gridVariables.getStore().getAt(x);
		arrVariables.push([fila.data.nombreVariable,fila.data.nombreVariable]);    	    
    }
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Variable:'
                                                        },
                                                        {
                                                            x:180,
                                                            y:5,                                                                                            
                                                            html:'<div id="dComboVariable"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:50,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Afectaci&oacute;n:'
                                                        },
                                                        {
                                                            x:180,
                                                            y:45,                                                                                            
                                                            html:'<div id="dComboAfectacion"></div>'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Variable',
										width: 500,
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
                                                                        cmbVariables=crearComboExt('cmbVariables',arrVariables,0,0,200,{ctCls:'comboSIUGJ',listClass:'listComboSIUG',renderTo:'dComboVariable'});
                                                                        cmbAfectacion=crearComboExt('cmbAfectacion',arrAfectacion,0,0,130,{ctCls:'comboSIUGJ',listClass:'listComboSIUG',renderTo:'dComboAfectacion'});
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
                                                                    	if(cmbVariables.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbVariables.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar la variable a afectar',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbAfectacion.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbAfectacion.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el tipo de afectaci&oacute;n',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        var cadObj='{"variable":"'+cmbVariables.getValue()+'","afectacion":"'+cv(cmbAfectacion.getValue())+'","idRegistro":"'+bD(iR)+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gCalculos').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesLiquidador.php',funcAjax, 'POST','funcion=6&cadObj='+cadObj,true);
                                                                        

																	}
														}
													]
									}
								);
	ventanaAM.show();
}

function removerVariable(iR,p)
{
	var cadObj='{"idRegistro":"'+bD(iR)+'","parametro":"'+bD(p)+'"}';
	function resp(btn)
    {
    	if(btn=='yes')
        {
        	function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
					var nodo=gE('fila_'+p);
                    nodo.parentNode.remove(nodo);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesLiquidador.php',funcAjax, 'POST','funcion=7&cadObj='+cadObj,true);
            
        }
    }
    msgConfirm('Est&aacute; seguro de querer remover la afectaci&oacute;n de la variable',resp);
}

function mostrarVentanaParametroEntrada(iR,nParam)
{
	var cmbVariables;
    var cmbAfectacion;
	var gridVariables=gEx('gridVariables');
	var fila;
    var x;
	arrVariables=[];
    
    
    for(x=0;x<gridVariables.getStore().getCount();x++)
    {
    	fila=gridVariables.getStore().getAt(x);
		arrVariables.push([fila.data.nombreVariable,fila.data.nombreVariable]);    	    
    }
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Par&aacute;metro:'
                                                        },
                                                        {
                                                            x:180,
                                                            y:15, 
                                                            cls:'SIUGJ_ControlEtiqueta',                                                                                           
                                                            html:bD(nParam)
                                                        },
                                            			{
                                                        	x:10,
                                                            y:70,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Tipo de Valor:'
                                                        },
                                                        {
                                                            x:180,
                                                            y:65,                                                                                            
                                                            html:'<div id="dComboTipoValor"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:120,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Valor:'
                                                        },
                                                        {
                                                            x:180,
                                                            y:115,                                                                                            
                                                            html:'<div id="dComboValor"></div>'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Par&aacute;metro',
										width: 650,
										height:300,
										layout: 'fit',
										plain:true,
										modal:true,
                                        closable:false,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
                                                        show : {
                                                                    buffer : 10,
                                                                    fn : function() 
                                                                    {
                                                                        cmbTipoValor=crearComboExt('cmbTipoValor',arrTipoValor,0,0,400,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'dComboTipoValor'});
                                                                        cmbTipoValor.on('select',function(cmb,registro)
                                                                        						{
                                                                                                	gEx('cmbValor').setValue('');
                                                                                                	switch(registro.data.id)
                                                                                                    {
                                                                                                    	case '1':
                                                                                                        	
                                                                                                            gEx('cmbValor').getStore().loadData(arrVariables);
                                                                                                        break;
                                                                                                        case '2':
                                                                                                        	 gEx('cmbValor').getStore().loadData(arrValorSesion);
                                                                                                        
                                                                                                        break;
                                                                                                        case '3':
                                                                                                        	gEx('cmbValor').getStore().loadData(arrValorSistema);
                                                                                                        
                                                                                                        break;
                                                                                                        case '4':
                                                                                                        	
                                                                                                            gEx('cmbValor').getStore().loadData(arrParametrosPerfil);
                                                                                                        break;
                                                                                                    }
                                                                                                }
                                                                        				)
                                                                        
                                                                        cmbValor=crearComboExt('cmbValor',[],0,0,400,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'dComboValor'});
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
                                                                    	if(cmbTipoValor.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbTipoValor.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el tipo de valor a asignar al par&aacute;metro',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbValor.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbValor.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el valor a asignar al par&aacute;metro',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        var cadObj='{"parametro":"'+bD(nParam)+'","tipoValor":"'+cmbTipoValor.getValue()+'","valor":"'+cv(cmbValor.getValue())+'","idRegistro":"'+bD(iR)+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gCalculos').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesLiquidador.php',funcAjax, 'POST','funcion=8&cadObj='+cadObj,true);
                                                                        

																	}
														}
													]
									}
								);
	ventanaAM.show();
}

function crearGridCatalogos(tA)
{

	var lblEtiqueta='';
    switch(tA)
    {
    	case 1:
        	lblEtiqueta='Distrito';
        break;
        case 2:
        	lblEtiqueta='Circuito';
        break;
        case 3:
        	lblEtiqueta='Municipio';
        break;
        case 4:
        	lblEtiqueta='Despacho';
        break;
    }



	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'cveElemento'},
		                                                {name: 'nombreElemento'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesLiquidador.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreElemento', direction: 'ASC'},
                                                            groupField: 'nombreElemento',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='9';
                                        proxy.baseParams.iR=gE('idPerfil').value;
                                        proxy.baseParams.tA=tA;
                                    }
                        )   
       
       
       
       var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
                                                            {
                                                                header:lblEtiqueta,
                                                                width:800,
                                                                sortable:true,
                                                                dataIndex:'nombreElemento',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridCatalogo_'+tA,
                                                                store:alDatos,
                                                                region:'center',
                                                                cls:'gridSiugj',
                                                                frame:false,
                                                                cm: cModelo,
                                                                sm:chkRow,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                height:350,
                                                                tbar:	[
                                                                            {
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar '+lblEtiqueta,
                                                                                handler:function()
                                                                                        {
                                                                                            switch(tA)
                                                                                            {
                                                                                                case 1:
                                                                                                    mostrarVentanaAgregarDistrito(gE('idPerfil').value)
                                                                                                break;
                                                                                                case 2:
                                                                                                	mostrarVentanaAgregarCircuito(gE('idPerfil').value)
                                                                                                   
                                                                                                break;
                                                                                                case 3:
                                                                                                    mostrarVentanaAgregarMunicipio(gE('idPerfil').value)
                                                                                                break;
                                                                                                case 4:
                                                                                                   mostrarVentanaAgregarDespacho(gE('idPerfil').value);
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover '+lblEtiqueta,
                                                                                handler:function()
                                                                                        {
                                                                                        	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                            
                                                                                            if(filas.length==0)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar almenos un elemento a remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	tblGrid.getStore().remove(filas);
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover los elementos seleccionados?',resp);
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                        ],
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
        return 	tblGrid;
}

function mostrarVentanaAgregarDistrito(idFecha)
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
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Seleccione los distritos que desea agregar al &aacute;mbito de aplicaci&oacute;n:'
                                                        },
                                                        crearGridDistritosAdd(idFecha)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Distrito',
										width: 650,
										height:450,
										closable:false,
                                        layout: 'fit',
										plain:true,
                                        
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
                                        cls:'msgHistorialSIUGJ',
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
                                                                    	var pos;
                                                                        var r;
                                                                        var registro=crearRegistro	(		
                                                                                                        [
                                                                                                            {name:'cveElemento'},
                                                                                                            {name: 'nombreElemento'}
                                                                                                        ]
                                                                                                    );
																		var filas=gEx('gridCatalogoAddDistrito').getSelectionModel().getSelections();
                                                                        var x;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	pos=obtenerPosFila(gEx('gridCatalogo_1').getStore(),'cveElemento',filas[x].data.cveDistrito);
                                                                            if(pos==-1)
                                                                            {
                                                                            	r=new registro	(
                                                                                					{
                                                                                                    	cveElemento:filas[x].data.cveDistrito,
                                                                                                        nombreElemento:filas[x].data.nombreDistrito
                                                                                                    }
                                                                                				)
                                                                            
                                                                            	gEx('gridCatalogo_1').getStore().add(r);	
                                                                            }
                                                                            
                                                                        }
                                                                        
                                                                        ventanaAM.close();
                                                                        	
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}


function crearGridDistritosAdd(idFecha)
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'cveDistrito'},
		                                                {name: 'nombreDistrito'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreDistrito', direction: 'ASC'},
                                                            groupField: 'nombreDistrito',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='27';
                                        proxy.baseParams.iR=idFecha;
                                        
                                    }
                        )   
       var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
                                                            {
                                                                header:'Distrito',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'nombreDistrito',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridCatalogoAddDistrito',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                height:300,
                                                                sm:chkRow,
                                                                width:625,
                                                                y:50,
                                                                cls:'gridSiugj',
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
        return 	tblGrid;	
}

function mostrarVentanaAgregarCircuito(idFecha)
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
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Seleccione los circuitos que desea agregar al &aacute;mbito de aplicaci&oacute;n:'
                                                        },
                                                        crearGridCircuitosAdd(idFecha)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Circuito',
										width: 650,
										height:450,
										layout: 'fit',
										plain:true,
										modal:true,
                                        closable:true,
                                        cls:'msgHistorialSIUGJ',
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
                                                                    	var pos;
                                                                        var r;
                                                                        var registro=crearRegistro	(		
                                                                                                        [
                                                                                                            {name:'cveElemento'},
                                                                                                            {name: 'nombreElemento'}
                                                                                                        ]
                                                                                                    );
																		var filas=gEx('gridCatalogoAddCircuito').getSelectionModel().getSelections();
                                                                        var x;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	pos=obtenerPosFila(gEx('gridCatalogo_2').getStore(),'cveElemento',filas[x].data.cveCircuito);
                                                                            if(pos==-1)
                                                                            {
                                                                            	r=new registro	(
                                                                                					{
                                                                                                    	cveElemento:filas[x].data.cveCircuito,
                                                                                                        nombreElemento:filas[x].data.nombreCircuito
                                                                                                    }
                                                                                				)
                                                                            
                                                                            	gEx('gridCatalogo_2').getStore().add(r);	
                                                                            }
                                                                            
                                                                        }
                                                                        
                                                                        ventanaAM.close();
                                                                        	
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}


function crearGridCircuitosAdd(idFecha)
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'cveCircuito'},
		                                                {name: 'nombreCircuito'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreCircuito', direction: 'ASC'},
                                                            groupField: 'nombreCircuito',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='28';
                                        proxy.baseParams.iR=idFecha;
                                        
                                    }
                        )   
       var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
                                                            {
                                                                header:'Circuito',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'nombreCircuito',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridCatalogoAddCircuito',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                height:300,
                                                                sm:chkRow,
                                                                width:625,
                                                                y:50,
                                                                cls:'gridSiugj',
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
        return 	tblGrid;	
}


function mostrarVentanaAgregarMunicipio(idFecha)
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
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Seleccione los municipio que desea agregar al &aacute;mbito de aplicaci&oacute;n:'
                                                        },
                                                        crearGridMunicipioAdd(idFecha)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Municipio',
										width: 650,
										height:450,
										layout: 'fit',
										plain:true,
										modal:true,
                                        closable:true,
                                        cls:'msgHistorialSIUGJ',
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
                                                                    	var pos;
                                                                        var r;
                                                                        var registro=crearRegistro	(		
                                                                                                        [
                                                                                                            {name:'cveElemento'},
                                                                                                            {name: 'nombreElemento'}
                                                                                                        ]
                                                                                                    );
																		var filas=gEx('gridCatalogoAddMunicipio').getSelectionModel().getSelections();
                                                                        var x;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	pos=obtenerPosFila(gEx('gridCatalogo_3').getStore(),'cveElemento',filas[x].data.cveMunicipio);
                                                                            if(pos==-1)
                                                                            {
                                                                            	r=new registro	(
                                                                                					{
                                                                                                    	cveElemento:filas[x].data.cveMunicipio,
                                                                                                        nombreElemento:filas[x].data.nombreMunicipio
                                                                                                    }
                                                                                				)
                                                                            
                                                                            	gEx('gridCatalogo_3').getStore().add(r);	
                                                                            }
                                                                            
                                                                        }
                                                                        
                                                                        ventanaAM.close();
                                                                        	
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
}


function crearGridMunicipioAdd(idFecha)
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'cveMunicipio'},
		                                                {name: 'nombreMunicipio'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreMunicipio', direction: 'ASC'},
                                                            groupField: 'nombreMunicipio',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='29';
                                        proxy.baseParams.iR=idFecha;
                                        
                                    }
                        )   
       var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
                                                            {
                                                                header:'Municipio',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'nombreMunicipio',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridCatalogoAddMunicipio',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                height:300,
                                                                sm:chkRow,
                                                                width:625,
                                                                y:50,
                                                                cls:'gridSiugj',
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
        return 	tblGrid;	
}

function mostrarVentanaAgregarDespacho(idFecha)
{
	var claveUnidad;
    

	
    
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
                                                            html:'Despacho que agregar:'
                                                        },
                                                        {
                                                            x:230,
                                                            y:10,
                                                            html:'<div id="divComboDespacho">'
                                                        }
                                                        
                                                        
                                                       
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Despacho',
										width: 700,
										height:150,
										layout: 'fit',
										plain:true,
                                        closable:true,
                                        cls:'msgHistorialSIUGJ',
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	var oConf=	{
                                                                                    idCombo:'cmbDespacho',
                                                                                    anchoCombo:400,
                                                                                    posX:0,
                                                                                    posY:0,
                                                                                    raiz:'registros',
                                                                                    campoDesplegar:'nombreUnidad',
                                                                                    campoID:'claveUnidad',
                                                                                    funcionBusqueda:30,
                                                                                    renderTo:'divComboDespacho',
                                                                                    ctCls:'campoComboWrapSIUGJAutocompletar',
                                                                                    listClass:'comboWrapSIUGJControlList',
                                                                                    paginaProcesamiento:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',
                                                                                    confVista:'<tpl for="."><div class="search-item">{nombreUnidad}<br></div></tpl>',
                                                                                    campos:	[
                                                                                                {name:'claveUnidad'},
                                                                                                {name:'nombreUnidad'}
                                                            
                                                                                            ],
                                                                                    funcAntesCarga:function(dSet,combo)
                                                                                                {
                                                                                                    claveUnidad='';
                                                                                                    var aValor=combo.getRawValue();
                                                                                                    dSet.baseParams.criterio=aValor;
                                                                                                    dSet.baseParams.iR=idFecha;
                                                                                                    
                                                                                                                                          
                                                                                                    
                                                                                                },
                                                                                    funcElementoSel:function(combo,registro)
                                                                                                {
                                                                                                    claveUnidad=registro.data.claveUnidad;
                                                                                                    
                                                                                                }  
                                                                                };
                                                                                
                                                                		var cmbDespacho=crearComboExtAutocompletar(oConf);                
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
                                                                    	var pos;
                                                                        var r;
                                                                        var registro=crearRegistro	(		
                                                                                                        [
                                                                                                            {name:'cveElemento'},
                                                                                                            {name: 'nombreElemento'}
                                                                                                        ]
                                                                                                    );
																		
                                                                        var x;
                                                                        pos=obtenerPosFila(gEx('gridCatalogo_4').getStore(),'cveElemento',claveUnidad);
                                                                        if(pos==-1)
                                                                        {
                                                                            r=new registro	(
                                                                                                {
                                                                                                    cveElemento:claveUnidad,
                                                                                                    nombreElemento:gEx('cmbDespacho').getRawValue()
                                                                                                }
                                                                                            )
                                                                        
                                                                            gEx('gridCatalogo_4').getStore().add(r);	
                                                                        }
                                                                        
                                                                        ventanaAM.close();
                                                                        	
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}
