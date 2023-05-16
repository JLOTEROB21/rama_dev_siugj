<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT claveElemento,nombreElemento FROM 1018_catalogoVarios WHERE tipoElemento=1 ORDER BY claveElemento";
	$arrSituacion=$con->obtenerFilasArreglo($consulta);
	
	$arrProcesos="";
	
	
	
	$consulta="SELECT idProceso,CONCAT('[',cveProceso,'] ',nombre) as nombreProceso FROM 4001_procesos WHERE idTipoProceso=3 and situacion=1 ORDER BY cveProceso,nombre";
	$resProcesos=$con->obtenerFilas($consulta);
	while($fProceso=mysql_fetch_assoc($resProcesos))
	{
	
	
		$consulta="select numEtapa,nombreEtapa from 4037_etapas where idProceso=".$fProceso["idProceso"]." order by numEtapa";
		$resEtapas=$con->obtenerFilas($consulta);
		$arrEtapasNumero="";
		while($fEtapas=mysql_fetch_row($resEtapas))
		{
			$o="['".$fEtapas[0]."','".removerCerosDerecha($fEtapas[0]).".- ".cv($fEtapas[1])."']";
			if($arrEtapasNumero=="")
				$arrEtapasNumero=$o;
			else
				$arrEtapasNumero.=",".$o;
		}
		
		$arrEtapasNumero="[".$arrEtapasNumero."]";
		
		$oProceso="['".$fProceso["idProceso"]."','".cv($fProceso["nombreProceso"])."',".$arrEtapasNumero."]";
		if($arrProcesos=="")
			$arrProcesos=$oProceso;
		else
			$arrProcesos.=",".$oProceso;
	}
	$arrProcesos="[".$arrProcesos."]";
	$consulta="select idValorSesion,descripcionValor,valorReemplazo from 8003_valoresSesion where tipo=1 order by descripcionValor ";
	$arrValorSesion=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select idValorSesion,descripcionValor,valorReemplazo from 8003_valoresSesion where tipo=2 order by descripcionValor ";
	$arrValorSistema=uEJ($con->obtenerFilasArreglo($consulta));
	
	$consulta="select valor,texto from 1004_siNo where idIdioma=".$_SESSION["leng"];
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	$consulta="select concat(idRol,'_',extensionRol),nombreGrupo from 8001_roles where idIdioma=".$_SESSION["leng"]." and situacion=1 order by nombreGrupo";
	$arrRolesSistema=uEJ($con->obtenerFilasArreglo($consulta));
?>
var arrUsuarioMarcaAtendida=[['1','Usuario que ocasion\xF3 cambio de etapa'],['2','Todos los usuarios notificados']];
var arrRolesSistema=<?php echo $arrRolesSistema?>;
var arrSiNo=<?php echo $arrSiNo?>;
var arrCamposFormularioBaseOrigen=[];
var arrValorSesionGlobal=<?php echo $arrValorSesion?>;
var arrValorSistemaGlobal=<?php echo $arrValorSistema?>;
var tiposLlenado=[['0','Ninguno'],['7','Funci\xF3n de sistema'],['6','Valor de formulario base'],['1','Valor de sesi\xF3n'],['8','Valor manual'],['2','Valor de sistema']];							

var filtroUsuario=new Array();
var filtroMysql=new Array();
var filtroTipoValor=new Array();
    
var arrProcesos=<?php echo $arrProcesos?>;
var arrSituacion=<?php echo $arrSituacion?>;
Ext.onReady(inicializar);

function inicializar()
{
	
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                defaultType: 'label',
                                                cls:'panelSiugjWrap',
                                                title: 'Macro Proceso',
                                                items:	[
                                                
                                                			{
                                                            	xtype:'tabpanel',
                                                                activeTab:0, 
                                                                 
                                                                cls:'tabPanelSIUGJ',                                                              
                                                                region:'center',
                                                                items:	[
                                                                			{
                                                                                xtype:'panel',
                                                                                layout:'absolute',
                                                                                defaultType: 'label',
                                                                                height:210,
                                                                                cls:'panelSiugjWrap',
                                                                                title:'Datos Generales',
                                                                                border:false,
                                                                                region:'north',
                                                                                tbar:	[
                                                                                            {
                                                                                                icon:'../images/guardar.PNG',
                                                                                                cls:'x-btn-text-icon',
                                                                                                text:'Guardar',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            var txtNombreMarco=gEx('txtNombreMarco');
                                                                                                            var txtDescripcion=gEx('txtDescripcion');
                                                                                                            var txtClave=gEx('txtClave');
                                                                                                            if(txtNombreMarco.getValue()=='')
                                                                                                            {
                                                                                                                function resp()
                                                                                                                {
                                                                                                                    txtNombreMarco.focus();
                                                                                                                }
                                                                                                                msgBox('Debe ingersar el nombre del Macro Proceso',resp);
                                                                                                                return;
                                                                                                            }
                                                                                                            
                                                                                                            var cadObj='{"idRegistro":"'+gE('idRegistro').value+'","nombreMacroProceso":"'+cv(txtNombreMarco.getValue())+
                                                                                                                        '","descripcion":"'+cv(gEx('txtDescripcion').getValue())+'","situacion":"'+
                                                                                                                        cmbSituacion.getValue()+'","cveMacroProceso":"'+cv(txtClave.getValue())+'","funcionAplicacion":"'+
                                                                                                                        (gEx('txtFuncionAplicacionMacropoceso').idConsulta?gEx('txtFuncionAplicacionMacropoceso').idConsulta:-1)+'"}';
                                                                                                            
                                                                                                            
                                                                                                            function funcAjax()
                                                                                                            {
                                                                                                                var resp=peticion_http.responseText;
                                                                                                                arrResp=resp.split('|');
                                                                                                                if(arrResp[0]=='1')
                                                                                                                {
                                                                                                                    gE('idRegistro').value=arrResp[0];
                                                                                                                }
                                                                                                                else
                                                                                                                {
                                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                }
                                                                                                            }
                                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=1&cadObj='+cadObj,true);
                                                                                                            
                                                                                                            
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                            {
                                                                                            	xtype:'tbspacer',
                                                                                                width:10
                                                                                            },
                                                                                            {
                                                                                                icon:'../images/salir.gif',
                                                                                                cls:'x-btn-text-icon',
                                                                                                text:'Salir',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            regresarPagina();
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                        ],
                                                                                items:	[
                                                                                            {
                                                                                                x:10,
                                                                                                y:20,
                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                html:'Cve. Macro Proceso'
                                                                                            }, 
                                                                                            {
                                                                                                x:10,
                                                                                                y:50,
                                                                                                xtype:'textfield',
                                                                                                width:200,
                                                                                                cls:'controlSIUGJ',
                                                                                                id:'txtClave'
                                                                                            },
                                                                                            {
                                                                                                x:500,
                                                                                                y:20,
                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                html:'Nombre del Macro Proceso <span style="color:#F00">*</span>'
                                                                                            }, 
                                                                                            {
                                                                                                x:500,
                                                                                                y:50,
                                                                                                xtype:'textfield',
                                                                                                width:300,
                                                                                                cls:'controlSIUGJ',
                                                                                                id:'txtNombreMarco'
                                                                                            },
                                                                                            {
                                                                                                x:10,
                                                                                                y:120,
                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                html:'Descripci&oacute;n'
                                                                                            }, 
                                                                                            {
                                                                                                x:10,
                                                                                                y:150,
                                                                                                xtype:'textarea',
                                                                                                width:450,
                                                                                                height:60,
                                                                                                cls:'controlSIUGJ',
                                                                                                id:'txtDescripcion'
                                                                                            },
                                                                                            {
                                                                                                x:500,
                                                                                                y:120,
                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                html:'Funci&oacute;n de Aplicaci&oacute;n'
                                                                                            } ,
                                                                                            {
                                                                                                xtype:'label',
                                                                                                x:700,
                                                                                                y:120,
                                                                                                html:'<a href="javascript:agregarFuncionControl(4)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionControl(4)"><img src="../images/cross.png"></a>'
                                                                                            },
                                                                                            {
                                                                                                xtype:'textfield',
                                                                                                width:300,
                                                                                                x:500,
                                                                                                y:150,
                                                                                                cls:'controlSIUGJ',
                                                                                                id:'txtFuncionAplicacionMacropoceso',
                                                                                                readOnly:true
                                                                                            },
                                                                                            
                                                                                            {
                                                                                                x:10,
                                                                                                y:220,
                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                html:'Situaci&oacute;n Actual'
                                                                                            },
                                                                                            {
                                                                                                xtype:'label',
                                                                                                x:10,
                                                                                                y:250,
                                                                                                html:'<div id="divComboSituacion"></div>'
                                                                                            }
                                                                                        ]
                                                                            } ,
                                                                            crearArbolMacroProceso()
                                                                            
                                                                		]
                                                            },
                                                            {
                                                            	xtype:'panel',
                                                                region:'east',
                                                                width:450,
                                                                border:false,
                                                                cls:'panelSiugjWrap',
                                                                layout:'accordion',
                                                                items:	[
                                                                			crearGridProcesosAsociados(),
                                                                            crearGridEtapasProcesal(),
                                                                            crearGridActuacionesAsociadas(),
                                                                            crearGridNotificacionesAsociadas(),
                                                                            crearGridTerminoProcesal(),
                                                                            crearGridTemporizador()
                                                                            
                                                                         ]
                                                                
                                                            }
                                                            
                                                
                                                         	
                                                        ]
                                            }
                                           
                                         ]
                            }
                        )   

	var cmbSituacion=crearComboExt('cmbSituacion',arrSituacion,0,0,250,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboSituacion'});
    cmbSituacion.setValue('1');

	var datosBase=eval(bD(gE('datosBase').value));
    if(datosBase.length>0)
    {	
    	var oDatos=datosBase[0];
        gEx('txtClave').setValue(oDatos.cveMacroProceso);
        gEx('txtNombreMarco').setValue(oDatos.nombreMacroProceso);
        gEx('txtDescripcion').setValue(escaparBR(oDatos.descripcion,true));
        gEx('cmbSituacion').setValue(oDatos.situacionActual);
        gEx('txtFuncionAplicacionMacropoceso').setValue(oDatos.lblFuncionAplicacion);
        gEx('txtFuncionAplicacionMacropoceso').idConsulta=oDatos.idFuncionAplicacion;
        
    }
    
//	inicializarZonasDragDrop();
}


function crearGridProcesosAsociados()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idProceso'},
		                                                {name: 'cveProceso'},
		                                                {name:'nombreProceso'},
                                                        {name: 'campoProcesoJudicial'},
                                                        {name: 'funcionProcesoJudicial'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'cveProceso', direction: 'ASC'},
                                                            groupField: 'cveProceso',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='2';
                                        proxy.baseParams.iM=gE('idRegistro').value;
                                    }
                        )   
       
   var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            
                                                            {
                                                                header:'Cve Proceso',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'cveProceso',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Nombre del Proceso',
                                                                width:320,
                                                                sortable:true,
                                                                dataIndex:'nombreProceso',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Campo de Proceso Judicial',
                                                                width:240,
                                                                sortable:true,
                                                                dataIndex:'campoProcesoJudicial',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Función Determinadora de Proceso Judicial',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'funcionProcesoJudicial',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gProcesos',
                                                                store:alDatos,
                                                                region:'east',
                                                                width:350,
                                                                frame:false,
                                                                cm: cModelo,
                                                                enableDragDrop:true,
                                                                ddGroup:'gridProcesos',
                                                                cls:'gridSiugjPrincipal',
                                                                title:'Procesos Asociados',
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : false,
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar Proceso',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaProcesos();
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                            	width:10
                                                                            },
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover Proceso',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=  gEx('gProcesos').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el Proceso que desea remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            
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
                                                                                                            gEx('gProcesos').getStore().reload();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=15&iM='+gE('idRegistro').value+'&iP='+fila.data.idProceso,true);

                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover el Proceso <b>'+fila.data.nombreProceso+'</b>?',resp)
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

function crearGridActuacionesAsociadas()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'cveEtiquetaActuacion'},
		                                                {name:'etiquetaActuacion'},
                                                        {name:'descripcion'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'cveEtiquetaActuacion', direction: 'ASC'},
                                                            groupField: 'cveEtiquetaActuacion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='3';
                                        proxy.baseParams.iM=gE('idRegistro').value;
                                    }
                        )   
   
   
   
   
   var expander = new Ext.ux.grid.RowExpander({
                                                    column:1,
                                                    width:40,
                                                    tpl : new Ext.Template(
                                                        '<table width="100%" >'+
                                                        '<tr>'+
                                                        	'<td  style="padding:10px">'+
                                                            '{descripcion}'+
                                                            '</td>'+
                                                        '</tr>'+
                                                        '</table>'
                                                    )
                                                }); 	    
   var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                        	expander,
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            
                                                            {
                                                                header:'Clave',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'cveEtiquetaActuacion',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'T&iacute;tulo Actuaci&oacute;n',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'etiquetaActuacion',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gActuaciones',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                title:'Actuaciones (Cat&aacute;logo)',
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                plugins:[expander],
                                                                loadMask:true,
                                                                cls:'gridSiugjPrincipal',
                                                                enableDragDrop:true,
                                                                ddGroup:'grupoDrop',
                                                                columnLines : false,
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar',
                                                                                handler:function()
                                                                                        {
                                                                                         	mostrarVentanaActuacion();   
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                            	width:10
                                                                            },
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Modificar',
                                                                                handler:function()
                                                                                        {
                                                                                         	var fila=  gEx('gActuaciones').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la actuaci&oacute;n que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            mostrarVentanaActuacion(fila);
                                                                                             
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                            	width:10
                                                                            },
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=  gEx('gActuaciones').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la actuaci&oacute;n que desea remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            
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
                                                                                                            gEx('gActuaciones').getStore().reload();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=5&iM='+gE('idRegistro').value+'&iA='+fila.data.idRegistro,true);

                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover la actuaci&oacute;n <b>'+fila.data.etiquetaActuacion+'</b>?',resp)
                                                                                            
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


function mostrarVentanaActuacion(filaActuacion)
{
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
                                                            html:'Cve. Actuaci&oacute;n:'
                                                        },
                                                        {
                                                        	x:220,
                                                            y:15,
                                                            xtype:'textfield',
                                                            width:200,
                                                            cls:'controlSIUGJ',
                                                            value:filaActuacion?filaActuacion.data.cveEtiquetaActuacion:'',
                                                            id:'txtCveActuacion'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'T&iacute;tulo de la Actuaci&oacute;n:'
                                                        },
                                                        {
                                                        	x:220,
                                                            y:65,
                                                            xtype:'textfield',
                                                            width:400,
                                                            cls:'controlSIUGJ',
                                                            value:filaActuacion?filaActuacion.data.etiquetaActuacion:'',
                                                            id:'txtTituloActuacion'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:120,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:150,
                                                            width:620,
                                                            cls:'controlSIUGJ',
                                                            height:60,
                                                            xtype:'textarea',
                                                            value:filaActuacion?escaparBR(filaActuacion.data.descripcion,true):'',
                                                            id:'txtDescripcion'
                                                        }		
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: filaActuacion?'Modificar Actuaci&oacute;n':'Registrar Actuaci&oacute;n',
										width: 670,
										height:350,
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
                                                                	gEx('txtCveActuacion').focus(false,500);
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
																		var txtCveActuacion=gEx('txtCveActuacion');
                                                                        
                                                                        if(txtCveActuacion.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtCveActuacion.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la clave de la actuaci&oacute;n',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        var txtTituloActuacion=gEx('txtTituloActuacion');
                                                                        
                                                                        
                                                                        if(txtTituloActuacion.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	txtTituloActuacion.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el t&iacute;titulo de la actuaci&oacute;n',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        var txtDescripcion=gEx('txtDescripcion');
																	
                                                                    	var cadObj='{"idRegistro":"'+(filaActuacion?filaActuacion.data.idRegistro:-1)+'","cveActuacion":"'+cv(txtCveActuacion.getValue())+
                                                                        			'","tituloActuacion":"'+cv(txtTituloActuacion.getValue())+'","descripcion":"'+cv(txtDescripcion.getValue())+
                                                                                    '","idMacroProceso":"'+gE('idRegistro').value+'"}';
                                                                    
                                                                    
                                                                    
                                                                    	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gActuaciones').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=4&cadObj='+cadObj,true);
                                                                        
                                                                    
                                                                    
                                                                    }
														}
													]
									}
								);
	ventanaAM.show();
}

function crearGridNotificacionesAsociadas()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'cveNotificacion'},
		                                                {name:'tituloNotificacion'},
                                                        {name:'descripcion'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'cveNotificacion', direction: 'ASC'},
                                                            groupField: 'cveNotificacion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='6';
                                        proxy.baseParams.iM=gE('idRegistro').value;
                                    }
                        )   
   
   
   
   
   var expander = new Ext.ux.grid.RowExpander({
                                                    column:1,
                                                    width:40,
                                                    tpl : new Ext.Template(
                                                        '<table width="100%" >'+
                                                        '<tr>'+
                                                        	'<td  style="padding:10px">'+
                                                            '{descripcion}'+
                                                            '</td>'+
                                                        '</tr>'+
                                                        '</table>'
                                                    )
                                                }); 	    
   var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                        	expander,
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            
                                                            {
                                                                header:'Clave',
                                                                width:120,
                                                                sortable:true,
                                                                dataIndex:'cveNotificacion',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'T&iacute;tulo de Notificaci&oacute;n',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'tituloNotificacion',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gNotificaciones',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                title:'Notificaciones (Cat&aacute;logo)',
                                                                cm: cModelo,
                                                                enableDragDrop:true,
                                                                ddGroup:'grupoDrop',
                                                                stripeRows :false,
                                                                plugins:[expander],
                                                                loadMask:true,
                                                                cls:'gridSiugjPrincipal',
                                                                columnLines : false,
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Crear',
                                                                                handler:function()
                                                                                        {
                                                                                         	
                                                                                            var obj={};
                                                                                            obj.ancho='100%';
                                                                                            obj.alto='100%';
                                                                                            obj.modal=true;
                                                                                            obj.url='../modeloPerfiles/notificacionProceso.php';
                                                                                            obj.params=[['idNotificacion','-1'],['idMacroProceso',gE('idRegistro').value]];
                                                                                            
                                                                                            abrirVentanaFancy(obj);
                                                                                        }
                                                                                
                                                                            },
                                                                            
                                                                            {
                                                                            	width:10,
                                                                                xtype:'tbspacer'
                                                                            },
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Modificar',
                                                                                handler:function()
                                                                                        {
                                                                                         	var fila=  gEx('gNotificaciones').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la notificaci&oacute;n que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                           	var obj={};
                                                                                            obj.ancho='100%';
                                                                                            obj.alto='100%';
                                                                                            obj.modal=true;
                                                                                            obj.url='../modeloPerfiles/notificacionProceso.php';
                                                                                            obj.params=[['idNotificacion',fila.data.idRegistro]];
                                                                                            
                                                                                            abrirVentanaFancy(obj);
                                                                                             
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	width:10,
                                                                                xtype:'tbspacer'
                                                                            },
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=  gEx('gNotificaciones').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la notificaci&oacute;n que desea remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            
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
                                                                                                            gEx('gNotificaciones').getStore().reload();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=10&iN='+fila.data.idRegistro,true);

                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover la notificaci&oacute;n <b>'+fila.data.tituloNotificacion+'</b>?',resp)
                                                                                            
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

function crearGridTerminoProcesal()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'cveTermino'},
		                                                {name:'tituloTermino'},
                                                        {name:'descripcion'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'cveTermino', direction: 'ASC'},
                                                            groupField: 'cveTermino',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='7';
                                        proxy.baseParams.iM=gE('idRegistro').value;
                                    }
                        )   
   
   
   
   
   var expander = new Ext.ux.grid.RowExpander({
                                                    column:1,
                                                    width:40,
                                                    tpl : new Ext.Template(
                                                        '<table width="100%" >'+
                                                        '<tr>'+
                                                        	'<td  style="padding:10px">'+
                                                            '{descripcion}'+
                                                            '</td>'+
                                                        '</tr>'+
                                                        '</table>'
                                                    )
                                                }); 	    
   var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                        	expander,
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            
                                                            {
                                                                header:'Clave',
                                                                width:120,
                                                                sortable:true,
                                                                dataIndex:'cveTermino',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Nombre del T&eacute;rmino',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'tituloTermino',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gTerminos',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                title:'T&eacute;rminos Procesales (Cat&aacute;logo',
                                                                cm: cModelo,
                                                                cls:'gridSiugjPrincipal',
                                                                stripeRows :false,
                                                                plugins:[expander],
                                                                loadMask:true,
                                                                enableDragDrop:true,
                                                                ddGroup:'grupoDrop',
                                                                columnLines : false,
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Registrar',
                                                                                handler:function()
                                                                                        {
                                                                                         	mostrarVentanaTermino();   
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	width:10,
                                                                                xtype:'tbspacer'
                                                                            },
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Modificar',
                                                                                handler:function()
                                                                                        {
                                                                                         	var fila=  gEx('gTerminos').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el t&eacute;rmino procesal que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            mostrarVentanaTermino(fila);
                                                                                             
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	width:10,
                                                                                xtype:'tbspacer'
                                                                            },
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=  gEx('gTerminos').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el t&eacute;rmino procesal que desea remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            
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
                                                                                                            gEx('gTerminos').getStore().reload();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=8&iM='+gE('idRegistro').value+'&iT='+fila.data.idRegistro,true);

                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover el t&eacute;rmino procesal <b>'+fila.data.tituloTermino+'</b>?',resp)
                                                                                            
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

function mostrarVentanaTermino(filaTermino)
{
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
                                                            html:'Cve. T&eacute;rmino:'
                                                        },
                                                        {
                                                        	x:220,
                                                            y:15,
                                                            xtype:'textfield',
                                                            width:200,
                                                            cls:'controlSIUGJ',
                                                            value:filaTermino?filaTermino.data.cveTermino:'',
                                                            id:'txtCveTermino'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Nombre del T&eacute;rmino:'
                                                        },
                                                        {
                                                        	x:220,
                                                            y:65,
                                                            xtype:'textfield',
                                                            width:400,
                                                            cls:'controlSIUGJ',
                                                            value:filaTermino?filaTermino.data.tituloTermino:'',
                                                            id:'tituloTermino'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:120,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:150,
                                                            width:620,
                                                            height:60,
                                                            xtype:'textarea',
                                                            cls:'controlSIUGJ',
                                                            value:filaTermino?escaparBR(filaTermino.data.descripcion,true):'',
                                                            id:'txtDescripcion'
                                                        }		
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: filaTermino?'Modificar T&eacute;rmino':'Registrar T&eacute;rmino',
										width: 670,
										height:350,
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
                                                                	gEx('txtCveTermino').focus(false,500);
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
																		var txtCveTermino=gEx('txtCveTermino');
                                                                        
                                                                        if(txtCveTermino.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtCveTermino.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la clave de t&eacute;rmino',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        var tituloTermino=gEx('tituloTermino');
                                                                        
                                                                        
                                                                        if(tituloTermino.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	tituloTermino.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el t&iacute;titulo del t&eacute;rmino',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        var txtDescripcion=gEx('txtDescripcion');
																	
                                                                    	var cadObj='{"idRegistro":"'+(filaTermino?filaTermino.data.idRegistro:-1)+'","cveTermino":"'+cv(txtCveTermino.getValue())+
                                                                        			'","tituloTermino":"'+cv(tituloTermino.getValue())+'","descripcion":"'+cv(txtDescripcion.getValue())+
                                                                                    '","idMacroProceso":"'+gE('idRegistro').value+'"}';
                                                                    
                                                                    
                                                                    
                                                                    	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gTerminos').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=9&cadObj='+cadObj,true);
                                                                        
                                                                    
                                                                    
                                                                    }
														}
														
													]
									}
								);
	ventanaAM.show();
}


function recargarGridNotificaciones()
{
	gEx('gNotificaciones').getStore().reload();
}


function crearGridEtapasProcesal()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'cveEtiquetaEtapa'},
		                                                {name:'etiquetaEtapa'},
                                                        {name:'descripcion'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'cveEtapaProcesal', direction: 'ASC'},
                                                            groupField: 'cveEtapaProcesal',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='11';
                                        proxy.baseParams.iM=gE('idRegistro').value;
                                    }
                        )   
   
   
   
   
   var expander = new Ext.ux.grid.RowExpander({
                                                    column:1,
                                                    width:40,
                                                    tpl : new Ext.Template(
                                                        '<table width="100%" >'+
                                                        '<tr>'+
                                                        	'<td  style="padding:10px">'+
                                                            '{descripcion}'+
                                                            '</td>'+
                                                        '</tr>'+
                                                        '</table>'
                                                    )
                                                }); 	    
   var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                        	expander,
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            
                                                            {
                                                                header:'Clave',
                                                                width:145,
                                                                sortable:true,
                                                                dataIndex:'cveEtiquetaEtapa',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Etapa Procesal',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'etiquetaEtapa',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gEtapas',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cls:'gridSiugjPrincipal',
                                                                title:'Etapas Procesales (Cat&aacute;logo)',
                                                                cm: cModelo,
                                                                enableDragDrop:true,
                                                                ddGroup:'grupoDrop',
                                                                stripeRows :false,
                                                                plugins:[expander],
                                                                loadMask:true,
                                                                columnLines : false,
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Registrar',
                                                                                handler:function()
                                                                                        {
                                                                                         	mostrarVentanaEtapaProcesal();   
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	width:10,
                                                                                xtype:'tbspacer'
                                                                            },
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Modificar',
                                                                                handler:function()
                                                                                        {
                                                                                         	var fila=  gEx('gEtapas').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la Etapa Procesal que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            mostrarVentanaEtapaProcesal(fila);
                                                                                             
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	width:10,
                                                                                xtype:'tbspacer'
                                                                            },
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=  gEx('gEtapas').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la Etapa Procesal que desea remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            
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
                                                                                                            gEx('gEtapas').getStore().reload();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=12&iM='+gE('idRegistro').value+'&iE='+fila.data.idRegistro,true);

                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover la Etapa Procesal <b>'+fila.data.etiquetaEtapa+'</b>?',resp)
                                                                                            
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

function mostrarVentanaEtapaProcesal(filaEtapa)
{
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
                                                            html:'Cve. Etapa Procesal:'
                                                        },
                                                        {
                                                        	x:200,
                                                            y:15,
                                                            cls:'controlSIUGJ',
                                                            xtype:'textfield',
                                                            width:200,
                                                            value:filaEtapa?filaEtapa.data.cveEtiquetaEtapa:'',
                                                            id:'txtCveEtapa'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'T&iacute;tulo de la Etapa:'
                                                        },
                                                        {
                                                        	x:200,
                                                            y:65,
                                                            cls:'controlSIUGJ',
                                                            xtype:'textfield',
                                                            width:400,
                                                            value:filaEtapa?filaEtapa.data.etiquetaEtapa:'',
                                                            id:'tituloEtapa'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:120,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:150,
                                                            width:600,
                                                            height:60,
                                                            cls:'controlSIUGJ',
                                                            xtype:'textarea',
                                                            value:filaEtapa?escaparBR(filaEtapa.data.descripcion,true):'',
                                                            id:'txtDescripcion'
                                                        }		
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: filaEtapa?'Modificar Etapa Procesal':'Registrar Etapa Procesal',
										width: 650,
										height:350,
										layout: 'fit',
										plain:true,
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
                                                                	gEx('txtCveEtapa').focus(false,500);
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
																		var txtCveEtapa=gEx('txtCveEtapa');
                                                                        
                                                                        if(txtCveEtapa.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtCveEtapa.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la clave de Etapa Procesal',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        var tituloEtapa=gEx('tituloEtapa');
                                                                        
                                                                        
                                                                        if(tituloEtapa.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	tituloEtapa.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el t&iacute;titulo de la Etapa Procesal',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        var txtDescripcion=gEx('txtDescripcion');
																	
                                                                    	var cadObj='{"idRegistro":"'+(filaEtapa?filaEtapa.data.idRegistro:-1)+'","cveEtapa":"'+cv(txtCveEtapa.getValue())+
                                                                        			'","etiquetaEtapa":"'+cv(tituloEtapa.getValue())+'","descripcion":"'+cv(txtDescripcion.getValue())+
                                                                                    '","idMacroProceso":"'+gE('idRegistro').value+'"}';
                                                                    
                                                                    
                                                                    
                                                                    	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gEtapas').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=13&cadObj='+cadObj,true);
                                                                        
                                                                    
                                                                    
                                                                    }
														}
														
													]
									}
								);
	ventanaAM.show();
}

function mostrarVentanaProcesos()
{
	
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
                                                            html:'Proceso a Agregar:'
                                                        },
                                                        {
                                                            x:260,
                                                            y:15,
                                                            html:'<div id="divComboProcesoAgregar"></div>'
                                                        }
                                                        ,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Campo de Proceso Judicial:'
                                                        },
                                                        {
                                                            x:260,
                                                            y:65,
                                                            html:'<div id="divComboCampoProcesoJudicial"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:120,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Funci&oacute;n Determinadora Proceso Judicial:'
                                                        },
                                                         {
                                                          xtype:'textfield',
                                                          width:290,
                                                          x:380,
                                                          y:115,
                                                          value:'',
                                                          cls:'controlSIUGJ',
                                                          id:'txtFuncionDeterminadoraProceso',
                                                          readOnly:true
                                                      },
                                                      {
                                                          xtype:'label',
                                                          x:680,
                                                          y:117,
                                                          id:'lblBtnFunciones',
                                                          html:'<a href="javascript:agregarFuncionAplicacion(6)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(6)"><img src="../images/cross.png"></a>'
                                                      }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Proceso',
										width: 800,
										height:280,
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
                                                                	var cmbProcesos=crearComboExt('cmbProcesos',arrProcesos,0,0,400,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboProcesoAgregar'});
    
                                                                    cmbProcesos.on('select',function(cmb,registro)
                                                                                            {
                                                                                                function funcAjax()
                                                                                                {
                                                                                                    var resp=peticion_http.responseText;
                                                                                                    arrResp=resp.split('|');
                                                                                                    if(arrResp[0]=='1')
                                                                                                    {
                                                                                                        var arrResp=eval(arrResp[1]);   
                                                                                                        gEx('cmbCampoProcesoJudicial').setValue('');
                                                                                                        gEx('cmbCampoProcesoJudicial').getStore().loadData(arrResp);
                                                                                                        
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=18&iP='+registro.data.id,true);
                                                                                                
                                                                                            }
                                                                                    )
                                                                    var cmbCampoProcesoJudicial=crearComboExt('cmbCampoProcesoJudicial',arrProcesos,0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboCampoProcesoJudicial'});
                                                                	gEx('cmbProcesos').focus(false,500);
                                                                    
                                                                    
                                                                    
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
                                                            width:140,
                                                            cls:'btnSIUGJ',
															handler: function()
																	{
                                                                    	var cmbProcesos=gEx('cmbProcesos');
																		if(cmbProcesos.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbProcesos.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el proceso que desea agregar',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cmbCampoProcesoJudicial=gEx('cmbCampoProcesoJudicial');
                                                                        if(cmbCampoProcesoJudicial.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbCampoProcesoJudicial.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el campo con el cual se asocia el proceso judicial',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cadObj='{"iM":"'+gE('idRegistro').value+'","iP":"'+cmbProcesos.getValue()+'","cExpediente":"'+cmbCampoProcesoJudicial.getValue()+
                                                                        			'","iFExpediente":"'+((gEx('txtFuncionDeterminadoraProceso').idConsulta && gEx('txtFuncionDeterminadoraProceso').idConsulta!='')?gEx('txtFuncionDeterminadoraProceso').idConsulta:'-1')+'"}';
                                                                    	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gProcesos').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=14&cadObj='+cadObj,true);
                                                                        
                                                                    
                                                                    
                                                                    }
														}
													]
									}
								);
	ventanaAM.show();
}


function crearArbolMacroProceso()
{

	var raiz=new  Ext.tree.AsyncTreeNode	(
                                                      {
                                                          id:'-1',
                                                          text:'Raiz',
                                                          draggable:false,
                                                          expanded :true
                                                      }
                                              	)
                                        
	var cargadorArbol=new Ext.tree.TreeLoader(
                                                        {
                                                            baseParams:{
                                                                            funcion:'16',
                                                                            iM:gE('idRegistro').value
                                                                        },
                                                            dataUrl:'../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',
                                                            uiProviders:	{
                                                                            	'col': Ext.ux.tree.ColumnNodeUI
                                                                        	}
                                                        }	


		                                         )		                                        
		
       	
        cargadorArbol.on('load',function( tree, node, response )
        						{
                                	/*if(idNodoSeleccionado!=-1)
                                    {
                                    
                                    	setTimeout(function()
                                        			{
                                                    	nodoSel=gEx('tOrganigrama').buscarNodo(gEx('tOrganigrama').getRootNode(),idNodoSeleccionado);//buscarNodoID(gEx('tOrganigrama').getRootNode(),idNodoSeleccionado);
                                                        gEx('tOrganigrama'). selectPath(nodoSel.getPath());
                                                        nodoClick(nodoSel);
                                                       
                                                    },500);
                                        
                                	}*/
                                }
        				)

	var aMacroProceso = new Ext.ux.tree.TreeGrid	(
                                                            {
                                                                id:'tMacroProceso',
                                                                title:'Escenario',
                                                                useArrows:true,
                                                                region:'center',
                                                                autoScroll:true,
                                                                animate:true,
                                                                enableDrop :true,
                                                                ddGroup:'grupoDrop',
                                                                containerScroll: true,
                                                                root:raiz,
                                                                cls:'gridSiugjPrincipal',
                                                                enableSort:false,
                                                                loader: cargadorArbol,
                                                                rootVisible:false,
                                                                region:'center',
                                                                dropConfig:	{
                                                                				appendOnly:true,
                                                                                ddGroup:'grupoDrop',
                                                                                allowContainerDrop:true,
                                                                                 
                                                                                onContainerOver:function( source, e, data )
                                                                                				{
                                                                                                	return this.dropNotAllowed;
                                                                                                },
                                                                                onNodeOver:function( nodeData,source, e, data )
                                                                                				{
                                                                                                
                                                                                                	return this.dropAllowed;
                                                                                                },
                                                                                                
                                                                                onNodeDrop:function( nodeData,source, e, data )
                                                                                				{
                                                                                                	
                                                                                                    switch(data.grid.id)
                                                                                                    {
                                                                                                    	case 'gActuaciones':
                                                                                                       		mostrarVentanaAgregarActuacionProceso(nodeData.node,data.selections[0]);
                                                                                                        break;
                                                                                                        case 'gEtapas':
                                                                                                       		mostrarVentanaAgregarEtapaProceso(nodeData.node,data.selections[0]);
                                                                                                        break;
                                                                                                        case 'gTerminos':
                                                                                                       		mostrarVentanaAgregarTerminoProceso(nodeData.node,data.selections[0]);
                                                                                                        break;
                                                                                                        case 'gTemporizadores':
                                                                                                        	mostrarVentanaAgregarTemporizadorProceso(nodeData.node,data.selections[0]);
                                                                                                        break;
                                                                                                        case 'gNotificaciones':
                                                                                                        	mostrarVentanaNotificacionesProceso(nodeData.node,data.selections[0]);
                                                                                                        break;
                                                                                                       
                                                                                                    }
                                                                                                    
                                                                                                }                
                                                                			},
                                                                columns:[
                                                                			{
                                                                                header:'',
                                                                                width:50,
                                                                                align:'center',
                                                                                dataIndex:'espacio'
                                                                            },
                                                                			{
                                                                                header:'',
                                                                                width:40,
                                                                                align:'center',
                                                                                dataIndex:'btnEditar'
                                                                            },
                                                                             {
                                                                                header:'',
                                                                                width:40,
                                                                                align:'center',
                                                                                dataIndex:'btnRemover'
                                                                            },
                                                                            {
                                                                                header:'Tipo Elemento',
                                                                                width:180,
                                                                                dataIndex:'tipoElemento'
                                                                            },
                                                                			{
                                                                                header:'Descripci&oacute;n',
                                                                                width:450,
                                                                                dataIndex:'text'
                                                                            },                                                                            
                                                                            
                                                                            {
                                                                                header:'Etapa',
                                                                                width:250,
                                                                                dataIndex:'etapa'
                                                                            }
                                                                            ,
                                                                             {
                                                                                header:'Funci&oacute;n Renderer',
                                                                                width:350,
                                                                                dataIndex:'lblFuncionRenderer'
                                                                            }
                                                                            ,
                                                                             {
                                                                                header:'Condici&oacute;n de Aplicaci&oacute;n',
                                                                                width:500,
                                                                                dataIndex:'lblMetodoAplicacion'
                                                                            }
                                                                         ],
                                                                listeners: 		{
                                                                                    'render': 	function(tp)
                                                                                    			{
                                                                                                	if(!tp.inicializado)
                                                                                        			{
                                                                                                    	tp.inicializado=true;
                                                                                                    	inicializarZonasDragDrop();
                                                                                                 	}
                                                                                                 }    
                                                                                            
                                                                                    }

                                                               
                                                            }
                                                    );
		
        
       

	return aMacroProceso;        
}


function inicializarZonasDragDrop()
{
	var tMacroProceso=gEx('tMacroProceso');
	var firstGridDropTargetEl =  gEx('tMacroProceso').el.dom;
   
    var firstGridDropTarget = new Ext.dd.DropTarget(firstGridDropTargetEl, {
                ddGroup    : 'gridProcesos',
                notifyDrop : function(ddSource, e, data)
                            {
                            	var fila=gEx('gProcesos').getStore().getAt(data.rowIndex);
                            	
                                mostrarVentanaAgregarProcesoEscenario(fila);
                            	return true
                            }
        });
        
	       

}


var arrVarchar=[['<>','Distinto a'],['=','Igual a'],['in','Est\xE9 en'],['not in','No est\xE9 en'],['like \'valor%\'','Inicie con'],['like \'%valor\' ','Termine con'],['like \'%valor%\'','Contenga']];
var arrInt=[['>','Mayor que'],['>=','Mayor o igual que'],['<','Menor a'],['<=','Menor o igual que'],['<>','Distinto a'],['=','Igual a'],['in','Est\xE9 en'],['not in','No est\xE9 en']];
var arrCombo=[['<>','Distinto a'],['=','Igual a'],['in','Est\xE9 en'],['not in','No est\xE9 en']];


function mostrarVentanaAgregarProcesoEscenario(fila)
{
	
   
    var valorTxt=new Ext.form.TextField	(
    										{
                                            	id:'txtValor',
                                                width:130,
                                                x:545,
                                                y:45,
                                                cls:'controlSIUGJ',
                                                hidden:true
                                                
                                            }	
    									)
    
    var valorDte=new Ext.form.DateField	(
    										{
                                            	id:'dteValor',
                                                width:100,
                                                x:545,
                                                y:45,
                                                hidden:true
                                            }
    									)
                                        
    var valorInt= new Ext.form.NumberField	(
                                                {
                                                    id:'intValor',
                                                    width:100,
                                                    x:545,
	                                                y:45,
                                                    hidden:true,
                                                    cls:'controlSIUGJ',
                                                    allowDecimals:false
                                                    
                                                }	
                                            )
                                            
	var valorDec= new Ext.form.TextField	(
                                                {
                                                    id:'decValor',
                                                    width:100,
                                                    x:545,
	                                                y:45,
                                                    cls:'controlSIUGJ',
                                                    hidden:true,
                                                    allowDecimals:true
                                                    
                                                }	
	                                           )  
    
    var tipoCampoF;
    filtroUsuario=new Array();
    filtroMysql=new Array();
    filtroTipoValor=new Array();
   
    
    var objConfCombo={};
    objConfCombo.arrCampos=	[
                                {name: 'nCamposO'},
                                {name: 'nombreCampo'},
                                {name: 'tipoDato'},
                                {name: 'tipoCtrl'},
                                {name: 'campoLlave'},
                                {name: 'tablaO'},
                                {name: 'tipoTabla'}
                            ];
                            
	objConfCombo.campoEtiqueta='nombreCampo';
    objConfCombo.campoValor=  'nCamposO'; 
    objConfCombo.confVista='<tpl for="."><div class="search-item">{nombreCampo}</div></tpl>';                         
    objConfCombo.renderTo='divComboFiltro';  
    objConfCombo.ctCls='comboWrapSIUGJControl';
    objConfCombo.cls='comboSIUGJControl';
    objConfCombo.listClass='listComboSIUGJControl';      
    
    
            
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
                                                            html:'Proceso a Agregar:'
                                                        },
                                                        {
                                                        	x:230,
                                                            y:15,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            html:(fila.data?fila.data.nombreProceso:fila.attributes.lblTipoProceso)
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Etapa:'
                                                        },
                                                        {
                                                          x:230,
                                                          y:65,
                                                          html:'<div id="divComboEtapa"></div>'
                                                      },
                                                        {
                                                        	x:10,
                                                            y:120,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Metodo de Aplicaci&oacute;n:'
                                                        },
                                                        {
                                                          x:230,
                                                          y:115,
                                                          html:'<div id="divComboMetodoAplicacion"></div>'
                                                      },
                                                        {
                                                        	x:10,
                                                            y:170,
                                                            cls:'SIUGJ_Etiqueta',
                                                            id:'lblFuncionAplicacion',
                                                            html:'Funci&oacute;n de Aplicaci&oacute;n:'
                                                        },	
                                                        {
                                                          xtype:'textfield',
                                                          width:350,
                                                          x:230,
                                                          y:165,
                                                          value:'',
                                                          cls:'controlSIUGJ',
                                                          id:'txtFuncionAplicacion',
                                                          readOnly:true
                                                      },
                                                      {
                                                          xtype:'label',
                                                          x:600,
                                                          y:167,
                                                          id:'lblBtnFunciones',
                                                          html:'<a href="javascript:agregarFuncionAplicacion(1)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(1)"><img src="../images/cross.png"></a>'
                                                      },
                                                      {
                                                      	 x:0,
                                                         y:220,
                                                         height:250,
                                                         xtype:'panel',
                                                         baseCls: 'x-plain',
                                                         id:'pConsulta',
                                                         defaultType: 'label',
                                                         layout:'absolute',
                                                         items:	[
                                                         			{
                                                                        x:10,
                                                                        y:15,
                                                                        xtype:'label',
                                                                        cls:'SIUGJ_Etiqueta',
                                                                        html:'Campo filtro:'
                                                                    },
                                                                    {
                                                                        x:10,
                                                                        y:45,
                                                                        html:'<div id="divComboFiltro"></div>'
                                                                    },
        
                                                                    {
                                                                        x:390,
                                                                        y:15,
                                                                        cls:'SIUGJ_Etiqueta',
                                                                        xtype:'label',
                                                                        html:'Condici&oacute;n:'
                                                                    },
                                                                    {
                                                                        x:390,
                                                                        y:45,
                                                                        html:'<div id="divComboCondicion"></div>'
                                                                    },
                                                                    {
                                                                        x:540,
                                                                        y:45,
                                                                        html:'<div id="divComboValor"></div>'
                                                                    },

                                                                    valorTxt,
                                                                    valorDte,
                                                                    valorInt,
                                                                    valorDec,
                                                                    {
                                                                        xtype:'button',
                                                                        text:'Agregar',
                                                                        x:10,
                                                                        y:90,
                                                                        width:100,
                                                                        icon:'../images/mas.gif',
                                                                        cls:'btnSIUGJCancel',
                                                                        handler:function()
                                                                                {
                                                                                	var cmbCampo=gEx('cmbCampo');
                                                                                    var condicion=gEx('cmbCondicion');
                                                                                    var valor=gEx('cmbValor');
                                                                                    if(cmbCampo.getValue()=='')
                                                                                    {
                                                                                        function resp()
                                                                                        {
                                                                                            cmbCampo.focus(false,10);
                                                                                        }
                                                                                        msgBox('Debe seleccionar el campo bajo el cual se filtrar&aacute;a la informaci&oacute;n',resp);
                                                                                        return;
                                                                                    }
                                                                                    var campoMysql=cmbCampo.getValue();
                                                                                    var campoUsr=cmbCampo.getRawValue();
                                                                                    var condicionU;
                                                                                    var condicionM;
                                                                                    if(condicion.getValue()=='')
                                                                                    {
                                                                                        function resp()
                                                                                        {
                                                                                            condicion.focus(false,10);
                                                                                        }
                                                                                        msgBox('Debe seleccionar la condici&oacute;n de comparaci&oacute;n',resp);
                                                                                        return;
                                                                                    }
                                                                                    condicionU=condicion.getRawValue();
                                                                                    condicionM=condicion.getValue();
                                                                                    var valorU='';
                                                                                    var valorM='';
                                                                                    switch(tipoCampoF)
                                                                                    {
                                                                                        case 'optM':
                                                                                       // case 'optT':
                                                                                        
                                                                                        	if(valor.isVisible())
                                                                                            {
                                                                                                if(valor.getValue()=='')
                                                                                                {
                                                                                                    function resp()
                                                                                                    {
                                                                                                        valor.focus(false,10);
                                                                                                    }
                                                                                                    msgBox('Debe ingresar el valor bajo el cual de filtrar&aacute; la informaci&oacute;n',resp);
                                                                                                    return;
                                                                                                }
                                                                                                valorM=valor.getValue();
                                                                                                valorU=valor.getRawValue();
                                                                                             }
                                                                                             if(valorTxt.isVisible())
                                                                                             {
                                                                                             	
                                                                                                valorU="'"+valorTxt.getValue()+"'";
	                                                                                            valorM="'"+valorTxt.getValue()+"'";
                                                                                             }
                                                                                        break;
											case 'optT':
											case 'varchar':
                                                                                        case 'text':
                                                                                            valorU="'"+valorTxt.getValue()+"'";
                                                                                            valorM="'"+valorTxt.getValue()+"'";
                                                                                        break;
                                                                                        case 'smallint':
                                                                                        case 'year':
                                                                                        case 'bigint':
                                                                                        case 'tinyint':
                                                                                        case 'int':
                                                                                        case 'varbinary':
                                                                                            if(valorInt.getRawValue()=='')
                                                                                            {
                                                                                                function resp()
                                                                                                {
                                                                                                    valorInt.focus(false,10);
                                                                                                }
                                                                                                msgBox('Debe ingresar el valor bajo el cual de filtrar&aacute; la informaci&oacute;n',resp);
                                                                                                return;
                                                                                            }
                                                                                            valorU=valorInt.getValue();
                                                                                            valorM=valorInt.getValue();
                                                                                            
                                                                                        break;
                                                                                        case 'numeric':
                                                                                        case 'real':
                                                                                        case 'double':
                                                                                        case 'float':
                                                                                        case 'decimal':
                                                                                            if(valorDec.getRawValue()=='')
                                                                                            {
                                                                                                function resp()
                                                                                                {
                                                                                                    valorDec.focus(false,10);
                                                                                                }
                                                                                                msgBox('Debe ingresar el valor bajo el cual de filtrar&aacute; la informaci&oacute;n',resp);
                                                                                                return;
                                                                                            }
                                                                                            valorU=valorDec.getValue();
                                                                                            valorM=valorDec.getValue();
                                                                                        break;
                                                                                        case 'date':
                                                                                        case 'datetime':
                                                                                            if(valorDte.getValue()=='')
                                                                                            {
                                                                                                function resp()
                                                                                                {
                                                                                                    valorDte.focus(false,10);
                                                                                                }
                                                                                                msgBox('Debe ingresar el valor bajo el cual de filtrar&aacute; la informaci&oacute;n',resp);
                                                                                                return;
                                                                                            }
                                                                                            valorU=valorDte.getValue().format('d/m/Y');
                                                                                            valorM="'"+valorDte.getValue().format('Y-m-d')+"'";
                                                                                            
                                                                                        break;
                                                                                        
                                                                                    }
                                                                                    var compA='';
                                                                                    var compC='';
                                                                                    if((condicionM=='in')||(condicionM=='not in'))
                                                                                    {
                                                                                        compA='(';
                                                                                        compC=')';
                                                                                    }
                                                                                    var cadM='';
                                                                                    var cadU='';
                                                                                    if((condicionM.indexOf('like')!=-1))
                                                                                    {
                                                                                        cadM=campoMysql+' '+condicionM.replace('valor',valorM.replace(/\'/gi,''));
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        cadM=campoMysql+' '+condicionM+' '+compA+valorM+compC;
                                                                                        
                                                                                    }
                                                                                    cadU=campoUsr+' '+condicionU+' '+compA+valorU+compC;
                                                                                    filtroUsuario[filtroUsuario.length]=cadU;
                                                                                    filtroMysql[filtroMysql.length]=cadM;
                                                                                    filtroTipoValor[filtroTipoValor.length]='1|0';
                                                                                    generarSentencia();
                                                                                }
                                                                    }
                                                                    
                                                                    ,
                                                                    {
                                                                       xtype:'button',
                                                                       text:'Remover',
                                                                       x:120,
                                                                       y:90,
                                                                       width:100,
                                                                       icon:'../images/menos.gif',
                                                                       cls:'btnSIUGJCancel',
                                                                       handler:function()
                                                                              {
                                                                                  if(filtroUsuario.length>0)
                                                                                  {
                                                                                      filtroUsuario.splice(filtroUsuario.length-1,1);
                                                                                      filtroMysql.splice(filtroMysql.length-1,1);
                                                                                      filtroTipoValor.splice(filtroTipoValor.length-1,1);
                                                                                      generarSentencia();
                                                                                  }
                                                                              }
                                                                   }
                                                                    ,
                                                                    {
                                                                         width:60,
                                                                         xtype:'button',
                                                                         text:'(',
                                                                         x:230,
                                                                         y:90,
                                                                         cls:'btnSIUGJCancel',
                                                                         handler:function()
                                                                                {
                                                                                    filtroUsuario[filtroUsuario.length]='(';
                                                                                    filtroMysql[filtroMysql.length]='(';
                                                                                    filtroTipoValor[filtroTipoValor.length]='0|0';
                                                                                    generarSentencia();
                                                                                }
                                                                     }
                                                                    ,
                                                                    {
                                                                          width:60,
                                                                          xtype:'button',
                                                                          text:')',
                                                                          x:300,
                                                                          y:90,
                                                                          cls:'btnSIUGJCancel',
                                                                          handler:function()
                                                                                  {
                                                                                      filtroUsuario[filtroUsuario.length]=')';
                                                                                      filtroMysql[filtroMysql.length]=')';
                                                                                      filtroTipoValor[filtroTipoValor.length]='0|0';
                                                                                      generarSentencia();
                                                                                  }
                                                                   	}
                                                                    ,
                                                                    {
                                                                        width:60,
                                                                        xtype:'button',
                                                                        text:'Y',
                                                                        x:370,
                                                                        y:90,
                                                                        cls:'btnSIUGJCancel',
                                                                        handler:function()
                                                                                {
                                                                                    filtroUsuario[filtroUsuario.length]='Y';
                                                                                    filtroMysql[filtroMysql.length]='AND';
                                                                                    filtroTipoValor[filtroTipoValor.length]='0|0';
                                                                                    generarSentencia();
                                                                                }
                                                                     }
                                                                    ,
                                                                    {
                                                                       width:60,
                                                                       xtype:'button',
                                                                       text:'O',
                                                                       x:440,
                                                                       y:90,
                                                                       cls:'btnSIUGJCancel',
                                                                       handler:function()
                                                                              {
                                                                                  filtroUsuario[filtroUsuario.length]='O';
                                                                                  filtroMysql[filtroMysql.length]='OR';
                                                                                  filtroTipoValor[filtroTipoValor.length]='0|0';
                                                                                  generarSentencia();
                                                                              }
                                                                   }
                                                                    ,
                                                                    {
                                                                        id:'txtConsulta',
                                                                        xtype:'textarea',
                                                                        x:10,
                                                                        y:145,
                                                                        width:760,
                                                                        height:90,
                                                                        cls:'controlSIUGJ',
                                                                        readOnly:true
                                                                    }
                                                                        
                                                                                    
                                                         		]
                                                      }	
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Proceso a Escenario',
										width: 820,
										height:575,
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
                                                                
                                                                	var cmbEtapaProceso=crearComboExt('cmbEtapaProceso',[],0,0,450,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboEtapa'});
    
                                                                    
                                                                    
                                                                    
                                                                    
                                                                    var cmbMetodoAplicacion=crearComboExt('cmbMetodoAplicacion',[['0','Ninguno'],['1','Mediante Funci\xF3n de Sistema'],['2','Mediante Regla de Comparaci\xF3n']],0,0,350,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboMetodoAplicacion'});
                                                                    cmbMetodoAplicacion.setValue(fila.data?'0':fila.attributes.metodoAplicacion);
                                                                    
                                                                    cmbMetodoAplicacion.on('select',function(cmb,registro)
                                                                                                    {
                                                                                                        gEx('txtFuncionAplicacion').setValue('');
                                                                                                        gEx('txtConsulta').setValue('');
                                                                                                        filtroUsuario=[];
                                                                                                        filtroMysql=[];
                                                                                                        filtroTipoValor=[];
                                                                                                        switch(registro.data.id)
                                                                                                        {
                                                                                                            case '0':
                                                                                                                gEx('lblBtnFunciones').hide();
                                                                                                                gEx('pConsulta').disable();
                                                                                                                gEx('lblFuncionAplicacion').hide();
                                                                                                                gEx('txtFuncionAplicacion').hide();
                                                                                                            break;
                                                                                                            case '1':
                                                                                                                gEx('lblBtnFunciones').show();
                                                                                                                gEx('pConsulta').disable();
                                                                                                                gEx('lblFuncionAplicacion').show();
                                                                                                                gEx('txtFuncionAplicacion').show();
                                                                                                         
                                                                                                            break;
                                                                                                            case '2':
                                                                                                                gEx('lblBtnFunciones').hide();
                                                                                                                gEx('pConsulta').enable();
                                                                                                                gEx('lblFuncionAplicacion').hide();
                                                                                                                gEx('txtFuncionAplicacion').hide();
                                                                                                                
                                                                                                            break;
                                                                                                        }
                                                                                                    }
                                                                                            )
                                                                
                                                                
                                                                	var cmbCampo=crearComboExt('cmbCampo',[],0,0,350,objConfCombo);
                                                                    cmbCampo.on('select',function(cmb,registro)
                                                                                            {
                                                                                                var cmbCondicion=Ext.getCmp('cmbCondicion');
                                                                                                var arr;
                                                                                                cmbCondicion.reset();
                                                                                                tipoCampoF=registro.get('tipoDato');
                                                                                                switch(tipoCampoF)
                                                                                                {
                                                                                                    case 'optM':
												    case 'optT':
                                                                                                        arr=arrCombo;
                                                                                                        mostrarCampoF('cmbValor');
                                                                                                        Ext.getCmp('cmbValor').reset();
                                                                                                        llenarOpciones(registro);
                                                                                                    break;
                                                                                                    case 'varchar':
                                                                                                    case 'text':
                                                                                                        arr=arrVarchar;
                                                                                                        Ext.getCmp('txtValor').setValue('');
                                                                                                        mostrarCampoF('txtValor');
                                                                                                    break;
                                                                                                    case 'smallint':
                                                                                                    case 'year':
                                                                                                    case 'bigint':
                                                                                                    case 'tinyint':
                                                                                                    case 'int':
                                                                                                    case 'varbinary':
                                                                                                        arr=arrInt;
                                                                                                        Ext.getCmp('intValor').setValue('0');
                                                                                                        mostrarCampoF('intValor');
                                                                                                    break;
                                                                                                    case 'numeric':
                                                                                                    case 'real':
                                                                                                    case 'double':
                                                                                                    case 'float':
                                                                                                    case 'decimal':
                                                                                                        arr=arrInt;
                                                                                                        Ext.getCmp('decValor').setValue('0.0');
                                                                                                        mostrarCampoF('decValor');
                                                                                                    break;
                                                                                                    case 'datetime':
                                                                                                    case 'date':
                                                                                                        arr=arrInt;
                                                                                                        mostrarCampoF('dteValor');
                                                                                                    break;
                                                                                                }
                                                                                                cmbCondicion.getStore().loadData(arr);
                                                                                                cmbCondicion.focus(false,10);
                                                                                            }
                                                                                )
                                                                                
                                                                                
                                                                    var condicion= crearComboExt('cmbCondicion',[],0,0,125,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboCondicion'});  
                                                                    condicion.on('select',function(cmb,registro)
                                                                                            {
                                                                                                switch(tipoCampoF)
                                                                                                {
                                                                                                    case'optM':
                                                                                                    case 'optT':
                                                                                                        Ext.getCmp('cmbValor').focus(false,10);
                                                                                                    break;
                                                                                                    case 'varchar':
                                                                                                    case 'text':
                                                                                                        Ext.getCmp('txtValor').focus(false,10);
                                                                                                    break;
                                                                                                    case 'smallint':
                                                                                                    case 'year':
                                                                                                    case 'bigint':
                                                                                                    case 'tinyint':
                                                                                                    case 'int':
                                                                                                    case 'varbinary':
                                                                                                        Ext.getCmp('intValor').focus(false,10);
                                                                                                    break;
                                                                                                    case 'numeric':
                                                                                                    case 'real':
                                                                                                    case 'double':
                                                                                                    case 'float':
                                                                                                    case 'decimal':
                                                                                                        Ext.getCmp('decValor').focus(false,10);
                                                                                                    break;
                                                                                                    case 'datetime':
                                                                                                    case 'date':
                                                                                                        Ext.getCmp('dteValor').focus(false,10);
                                                                                                    break;
                                                                                                }
                                                                                                
                                                                                            }
                                                                                )
                                                                
                                                                
                                                                	var valor= crearComboExt('cmbValor',[],0,0,240,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboValor'});   
                                                                
                                                                	 dispararEventoSelectCombo('cmbMetodoAplicacion');
                                                                     
                                                                     
                                                                    filtroUsuario=new Array();
                                                                    filtroMysql=new Array();
                                                                   	filtroTipoValor=new Array();
                                                                    
                                                                     
                                                                     gEx('txtFuncionAplicacion').idConsulta=fila.data?'-1':fila.attributes.iFuncionAplicacion;
                                                                     gEx('txtFuncionAplicacion').setValue(fila.data?'':fila.attributes.lblFuncionAplicacion);
                                                                     var condiciones=eval(fila.data?'[]':bD(fila.attributes.condiciones));
                                                                     var x;
                                                                     for(x=0;x<condiciones.length;x++)
                                                                     {
                                                                     	filtroUsuario.push(condiciones[x].tokenUsuario);
                                                                        filtroTipoValor.push(condiciones[x].tipoValor);
                                                                        filtroMysql.push(condiciones[x].tokenMysql);
                                                                     }
                                                                     
                                                                     generarSentencia();
																
                                                                	function funcAjax()
                                                                    {
                                                                        var resp=peticion_http.responseText;
                                                                        arrResp=resp.split('|');
                                                                        if(arrResp[0]=='1')
                                                                        {
                                                                            var arDatos=eval(arrResp[1]);
                                                                            
                                                                            var arrDatos2=eval(arrResp[2]);
                                                                            
                                                                            cmbEtapaProceso.getStore().loadData(arDatos);
                                                                            cmbCampo.getStore().loadData(arrDatos2);
                                                                            if(!fila.data)
                                                                            {
                                                                                cmbEtapaProceso.setValue(removerCerosDerecha(fila.attributes.numEtapa));
                                                                            }
                                                                            	
                                                                        }
                                                                        else
                                                                        {
                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                        }
                                                                    }
                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=17&iP='+(fila.data?fila.data.idProceso:fila.attributes.iProceso),true);
                                                                          
                                                                
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
                                                                    	var cmbEtapaProceso=gEx('cmbEtapaProceso');
                                                                        var cmbMetodoAplicacion=gEx('cmbMetodoAplicacion');
																		if(cmbEtapaProceso.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbEtapaProceso.focus();
                                                                            }
                                                                            msgBox('Debe indicar la etapa del proceso a agregar',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        if(cmbMetodoAplicacion.getValue()=='1')
                                                                        {
                                                                        	var txtFuncionAplicacion=gEx('txtFuncionAplicacion');
                                                                        	if((!txtFuncionAplicacion.idConsulta)||(txtFuncionAplicacion.idConsulta==''))
                                                                            {
                                                                            	function resp2()
                                                                                {
                                                                                    txtFuncionAplicacion.focus();
                                                                                }
                                                                                msgBox('Debe indicar la funci&oacute;n de aplicaci&oacute;n del proceso',resp2);
                                                                                return;
                                                                            }
                                                                        
                                                                        }
                                                                        
                                                                        if(cmbMetodoAplicacion.getValue()=='2')
                                                                        {
                                                                        	if(filtroMysql.length==0)
                                                                            {
                                                                            	function resp3()
                                                                                {
                                                                                   
                                                                                }
                                                                                msgBox('Debe indicar las condiciones de aplicaci&oacute;n del proceso',resp3);
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        var arrConsultaAplicacion='';
                                                                        
                                                                       
                                                                        
                                                                        var arrConsultaAplicacion='';
                                                                        var idFuncionAplicacion=((!gEx('txtFuncionAplicacion').idConsulta) || (gEx('txtFuncionAplicacion').idConsulta=='-1'))?'-1': gEx('txtFuncionAplicacion').idConsulta;
                                                                        var x;
                                                                        var o;
                                                                        
                                                                        
                                                                        for(x=0;x<filtroUsuario.length;x++)
                                                                        {
																			o='{"tokenUsuario":"'+cv(filtroUsuario[x])+'","tipoValor":"'+cv(filtroTipoValor[x])+'","tokenMysql":"'+cv(filtroMysql[x])+'"}';
                                                                            if(arrConsultaAplicacion=='')
                                                                            	arrConsultaAplicacion=o;
                                                                            else
                                                                            	arrConsultaAplicacion+=','+o;
                                                                        }
                                                                        var cadObj='{"idProceso":"'+(fila.data?fila.data.idProceso:fila.attributes.iProceso)+'","etapaProceso":"'+cmbEtapaProceso.getValue()+'","metodoAplicacion":"'+cmbMetodoAplicacion.getValue()+
                                                                        			'","funcionAplicacion":"'+idFuncionAplicacion+'","consultaAplicacion":"'+bE(arrConsultaAplicacion)+
                                                                                    '","idRegistroProceso":"'+(fila.data?-1:fila.attributes.idRegistroProceso)+
                                                                                    '","idMacroProceso":"'+gE('idRegistro').value+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('tMacroProceso').getRootNode().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=19&cadObj='+cadObj,true);
                                                                        
																	}
														}
														
													]
									}
								);
                                
	ventanaAM.show();                      
	
}

function agregarFuncionAplicacion(tipo)
{

	var control='';
	switch(tipo)
    {
    	case 1:
	    	control=gEx('txtFuncionAplicacion');
    	break;
        case 2:
	    	control=gEx('txtFuncionEjecucionCumplimientoTermino');
    	break;
        case 3:
	    	control=gEx('txtFuncionEjecucionVencimientoTermino');
    	break;
        case 4:
	    	control=gEx('txtFuncionAplicacion2');
    	break;
        case 5:
	    	control=gEx('txtFuncionPeriodoTermino');
    	break;
        case 6:
	    	control=gEx('txtFuncionDeterminadoraProceso');
    	break;
        case 7:	
        	control=gEx('txtFuncionAplicacion7');
        	
        break;
        case 8:	
        	control=gEx('txtFuncionAplicacion8');
        	
        break;
        
         case 100:	
        	control=gEx('txtFuncionCondicionalEjecucionArranqueTermino');
        	
        break;
        case 101:	
        	control=gEx('txtFuncionCondicionalEjecucionCumplimientoTermino');
        	
        break;
        case 102:	
        	control=gEx('txtFuncionCondicionalEjecucionVencimientoTermino');
        	
        break;
        case 110:
        	control=gEx('txtFuncionEjecucionArranqueTermino');
        
        break;
        
        
        
       
    }
    
    
    
    asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre,ventana)
                                            {
                                             	control.idConsulta=idConsulta;
                                                control.setValue(nombre);
                                                
                                                if(gEx('vAgregarExp'))
	                                                gEx('vAgregarExp').close();
                                            }

	if(window.parent.mostrarVentanaExpresion)
    {
        window.parent.mostrarVentanaExpresion(function(filaSelec,ventana)
                                {
                                    control.idConsulta=filaSelec.data.idConsulta;
                                    control.setValue(filaSelec.data.nombreConsulta);
                                    
                                    
                                    ventana.close();
                                }
                                ,true);
	}
    else
    {
    	mostrarVentanaExpresion(function(filaSelec,ventana)
                                {
                                    control.idConsulta=filaSelec.data.idConsulta;
                                    control.setValue(filaSelec.data.nombreConsulta);
                                    
                                    
                                    ventana.close();
                                }
                                ,true);
    }    
}


function removerFuncionAplicacion(tipo)
{
	var control='';
    switch(tipo)
    {
    	case 1:
	    	control=gEx('txtFuncionAplicacion');
    	break;
        case 2:
	    	control=gEx('txtFuncionEjecucionCumplimientoTermino');
    	break;
        case 3:
	    	control=gEx('txtFuncionEjecucionVencimientoTermino');
    	break;
        case 4:
	    	control=gEx('txtFuncionAplicacion2');
    	break;
        case 5:
	    	control=gEx('txtFuncionPeriodoTermino');
    	break;
        case 6:
	    	control=gEx('txtFuncionDeterminadoraProceso');
    	break;
        case 7:	
        	control=gEx('txtFuncionAplicacion7');
        	
        break;
        case 8:	
        	control=gEx('txtFuncionAplicacion8');
        	
        break;
        case 100:	
        	control=gEx('txtFuncionCondicionalEjecucionArranqueTermino');
        	
        break;
        case 101:	
        	control=gEx('txtFuncionCondicionalEjecucionCumplimientoTermino');
        	
        break;
        case 102:	
        	control=gEx('txtFuncionCondicionalEjecucionVencimientoTermino');
        	
        break;
       
    }
    control.idConsulta='';
    control.setValue('');
}

function generarSentencia()
{
	var x;
    var txtConsulta='';
    sentenciaMysql='';
	for(x=0;x<filtroUsuario.length;x++)
    {
    	txtConsulta+=' '+filtroUsuario[x];
        sentenciaMysql+=' '+filtroMysql[x];
    }
    Ext.getCmp('txtConsulta').setValue(txtConsulta);
}

function mostrarCampoF(idCampo)
{
    oE('divComboValor');
    Ext.getCmp('txtValor').hide();
    Ext.getCmp('dteValor').hide();
    Ext.getCmp('intValor').hide();
    Ext.getCmp('decValor').hide();
    
    if(idCampo=='cmbValor')
	{
		mE('divComboValor');
	}
    else
	{	
	    Ext.getCmp(idCampo).show();
	}
}

function llenarOpciones(registro)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var datos=eval(arrResp[1]);
            if(datos.length==0)
            {
            	oE('divComboValor')
            	gEx('txtValor').show();
            }
            else
            {
            	gEx('cmbValor').getStore().loadData(datos);
            	mE('divComboValor')
            	gEx('txtValor').hide();
            }
	     				   	  
    
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=26&tb='+registro.get('tablaO')+'&tipoTabla='+registro.get('tipoTabla')+'&campo='+registro.get('nCamposO'),true);
}


function removerProcesoEscenario(p)
{
	var nodo=buscarNodoID(gEx('tMacroProceso').getRootNode(),'p_'+bD(p))
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
                    gEx('tMacroProceso').getRootNode().reload();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=20&iP='+p,true);
            
        }
    }
    msgConfirm('Est&aacute; seguro de querer remover el proceso "'+nodo.attributes.lblTipoProceso+'.- '+nodo.attributes.etapa+'" del escenario?',resp);
    
}

function modificarProcesoEscenario(p)
{
	var nodo=buscarNodoID(gEx('tMacroProceso').getRootNode(),'p_'+bD(p))
    
    mostrarVentanaAgregarProcesoEscenario(nodo);
}

function mostrarVentanaAgregarActuacionProceso(nodoDestino,fila,nodoEdita)
{
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
                                                            html:'Proceso:'
                                                        },
                                                        {
                                                        	x:170,
                                                            y:20,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            html:nodoDestino.attributes.lblTipoProceso
                                                        },
                                                        {
                                                        	x:10,
                                                            y:55,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Etapa:'
                                                        },
                                                        {
                                                        	x:170,
                                                            y:55,
                                                            cls:'SIUGJ_ControlEtiqueta',                                                            
                                                            html:nodoDestino.attributes.etapa
                                                        },
                                                        {
                                                        	x:10,
                                                            y:90,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Actuaci&oacute;n:'
                                                        },
                                                        {
                                                        	x:170,
                                                            y:90,
                                                            cls:'SIUGJ_ControlEtiqueta',    
                                                            html:'['+fila.data.cveEtiquetaActuacion+'] '+fila.data.etiquetaActuacion
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:125,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Funci&oacute;n renderer:'
                                                        },
                                                        {
                                                          xtype:'textfield',
                                                          width:350,
                                                          x:220,
                                                          y:120,
                                                          value:'',
                                                          cls:'controlSIUGJ',
                                                          id:'txtFuncionAplicacion',
                                                          readOnly:true
                                                      },
                                                      {
                                                          xtype:'label',
                                                          x:590,
                                                          y:122,
                                                          id:'lblBtnFunciones',
                                                          html:'<a href="javascript:agregarFuncionAplicacion(1)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(1)"><img src="../images/cross.png"></a>'
                                                      },
                                                      {
                                                        	x:10,
                                                            y:160,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Funci&oacute;n de aplicaci&oacute;n:'
                                                        },
                                                        {
                                                          xtype:'textfield',
                                                          width:350,
                                                          x:220,
                                                          y:155,
                                                          value:'',
                                                          cls:'controlSIUGJ',
                                                          id:'txtFuncionAplicacion2',
                                                          readOnly:true
                                                      },
                                                      {
                                                          xtype:'label',
                                                          x:590,
                                                          y:157,
                                                          id:'lblBtnFunciones2',
                                                          html:'<a href="javascript:agregarFuncionAplicacion(4)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(4)"><img src="../images/cross.png"></a>'
                                                      },
                                                      {
                                                        	x:10,
                                                            y:195,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Funci&oacute;n de detalle:'
                                                        },
                                                        {
                                                          xtype:'textfield',
                                                          width:350,
                                                          x:220,
                                                          y:190,
                                                          value:'',
                                                          cls:'controlSIUGJ',
                                                          id:'txtFuncionAplicacion7',
                                                          readOnly:true
                                                      },
                                                      {
                                                          xtype:'label',
                                                          x:590,
                                                          y:192,
                                                          id:'lblBtnFunciones7',
                                                          html:'<a href="javascript:agregarFuncionAplicacion(7)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(7)"><img src="../images/cross.png"></a>'
                                                      }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Actuaci&oacute;n',
										width: 720,
										height:370,
                                        cls:'msgHistorialSIUGJ',
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
                                                                	if(nodoEdita)
                                                                    {
                                                                    	gEx('txtFuncionAplicacion').setValue(nodoEdita.attributes.lblFuncionRenderer);
                                                                        gEx('txtFuncionAplicacion').idConsulta=nodoEdita.attributes.funcionRenderer;
                                                                        gEx('txtFuncionAplicacion2').setValue(nodoEdita.attributes.lblMetodoAplicacion);
                                                                        gEx('txtFuncionAplicacion2').idConsulta=nodoEdita.attributes.idFuncionAplicacion;
                                                                        gEx('txtFuncionAplicacion7').setValue(nodoEdita.attributes.lblMetodoDetalle);
                                                                        gEx('txtFuncionAplicacion7').idConsulta=nodoEdita.attributes.idFuncionDetalle;
                                                                        
                                                                    }
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
                                                                    	var txtFuncionAplicacion=gEx('txtFuncionAplicacion');
                                                                    	if(!txtFuncionAplicacion.idConsulta || txtFuncionAplicacion.idConsulta=='')
                                                                        	txtFuncionAplicacion.idConsulta='-1';
                                                                        var txtFuncionAplicacion2=gEx('txtFuncionAplicacion2');
                                                                    	if(!txtFuncionAplicacion2.idConsulta || txtFuncionAplicacion2.idConsulta=='')
                                                                        	txtFuncionAplicacion2.idConsulta='-1';
                                                                        
                                                                        
                                                                        var txtFuncionAplicacion7=gEx('txtFuncionAplicacion7');
                                                                    	if(!txtFuncionAplicacion7.idConsulta || txtFuncionAplicacion7.idConsulta=='')
                                                                        	txtFuncionAplicacion7.idConsulta='-1';
                                                                        
																		var cadObj='{"idNodoProceso":"'+nodoDestino.id.replace('p_','')+'","idActuacion":"'+fila.data.idRegistro+
                                                                        		'","funcionRenderer":"'+txtFuncionAplicacion.idConsulta+'","funcionAplicacion":"'+txtFuncionAplicacion2.idConsulta+
                                                                                '","idRegistro":"'+(nodoEdita?nodoEdita.id.replace('e_',''):-1)+'","funcionDetalle":"'+txtFuncionAplicacion7.idConsulta+'"}';
																		
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('tMacroProceso').getRootNode().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=21&cadObj='+cadObj,true);

                                                                        
                                                                    }
														}
													]
									}
								);
	ventanaAM.show();	
}

function removerElementoProcesoEscenario(p)
{
	var nodo=buscarNodoID(gEx('tMacroProceso').getRootNode(),'e_'+bD(p))
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
                    gEx('tMacroProceso').getRootNode().reload();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=22&iE='+p,true);
            
        }
    }
    msgConfirm('Est&aacute; seguro de querer remover el elemento "'+nodo.text+'" del escenario?',resp);
    
}

function mostrarVentanaAgregarEtapaProceso(nodoDestino,fila,nodoEdita)
{
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
                                                            html:'Proceso:'
                                                        },
                                                        {
                                                        	x:200,
                                                            y:15,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            html:nodoDestino.attributes.lblTipoProceso
                                                        },
                                                        {
                                                        	x:10,
                                                            y:55,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Etapa:'
                                                        },
                                                        {
                                                        	x:200,
                                                            y:50,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            html:nodoDestino.attributes.etapa
                                                        },
                                                        {
                                                        	x:10,
                                                            y:90,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Etapa Procesal:'
                                                        },
                                                        {
                                                        	x:200,
                                                            y:85,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            html:'['+fila.data.cveEtiquetaEtapa+'] '+fila.data.etiquetaEtapa
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:125,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Funci&oacute;n renderer:'
                                                        },
                                                        {
                                                          xtype:'textfield',
                                                          width:350,
                                                          x:230,
                                                          y:120,
                                                          value:'',
                                                          cls:'controlSIUGJ',
                                                          id:'txtFuncionAplicacion',
                                                          readOnly:true
                                                      },
                                                      {
                                                          xtype:'label',
                                                          x:600,
                                                          y:122,
                                                          id:'lblBtnFunciones',
                                                          html:'<a href="javascript:agregarFuncionAplicacion(1)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(1)"><img src="../images/cross.png"></a>'
                                                      },
                                                      {
                                                        	x:10,
                                                            y:160,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Funci&oacute;n de aplicaci&oacute;n:'
                                                        },
                                                        {
                                                          xtype:'textfield',
                                                          width:350,
                                                          x:230,
                                                          y:155,
                                                          value:'',
                                                          cls:'controlSIUGJ',
                                                          id:'txtFuncionAplicacion2',
                                                          readOnly:true
                                                      },
                                                      {
                                                          xtype:'label',
                                                          x:600,
                                                          y:157,
                                                          id:'lblBtnFunciones2',
                                                          html:'<a href="javascript:agregarFuncionAplicacion(4)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(4)"><img src="../images/cross.png"></a>'
                                                      }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Cambiar Etapa Procesal',
										width: 720,
										height:310,
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
                                                                	if(nodoEdita)
                                                                    {
                                                                    	gEx('txtFuncionAplicacion').setValue(nodoEdita.attributes.lblFuncionRenderer);
                                                                        gEx('txtFuncionAplicacion').idConsulta=nodoEdita.attributes.funcionRenderer;
                                                                        gEx('txtFuncionAplicacion2').setValue(nodoEdita.attributes.lblMetodoAplicacion);
                                                                        gEx('txtFuncionAplicacion2').idConsulta=nodoEdita.attributes.idFuncionAplicacion;
                                                                        
                                                                    }
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
                                                                    	var txtFuncionAplicacion=gEx('txtFuncionAplicacion');
                                                                    	if(!txtFuncionAplicacion.idConsulta || txtFuncionAplicacion.idConsulta=='')
                                                                        	txtFuncionAplicacion.idConsulta='-1';
                                                                            
                                                                        var txtFuncionAplicacion2=gEx('txtFuncionAplicacion2');
                                                                    	if(!txtFuncionAplicacion2.idConsulta || txtFuncionAplicacion2.idConsulta=='')
                                                                        	txtFuncionAplicacion2.idConsulta='-1';    
                                                                            
																		var cadObj='{"idNodoProceso":"'+nodoDestino.id.replace('p_','')+'","idEtapaProcesal":"'+fila.data.idRegistro+
                                                                        			'","funcionRenderer":"'+txtFuncionAplicacion.idConsulta+'","functionAplicacion":"'+txtFuncionAplicacion2.idConsulta+
                                                                                    '","idRegistro":"'+(nodoEdita?nodoEdita.id.replace('e_',''):-1)+'"}';
																		
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('tMacroProceso').getRootNode().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=23&cadObj='+cadObj,true);

                                                                        
                                                                    }
														}
													]
									}
								);
	ventanaAM.show();	
}

function mostrarVentanaAgregarTerminoProceso(nodoDestino,filaOrigen,nodoEdita)
{
	var arrOpcionesApartir=[['1','Mismo d\xEDa'],['2','D\xEDa Siguiente']];	
	var arrProcesoArranque=[['0','Ninguno']];
    var x;
    for(x=0;x<arrProcesos.length;x++)
    {
    	arrProcesoArranque.push([arrProcesos[x][0],arrProcesos[x][1],arrProcesos[x][2]]);
    }
	var arrPeriodoTermino=[['2','D\xEDas Habiles'],['3','D\xEDas Naturales'],['4','Meses']];//['1','Horas']
	
    
    
    
    
   
    
    
    
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            id:'tabTermino',
                                                            region:'center',
                                                            cls:'tabPanelSIUGJ',
                                                            activeTab:0,
                                                            items:	[
                                                            			{	
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Datos Generales',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Proceso:'
                                                                                        },
                                                                                        {
                                                                                            x:150,
                                                                                            y:10,
                                                                                            cls:'SIUGJ_ControlEtiqueta',
                                                                                            html:nodoDestino.attributes.lblTipoProceso
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:45,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Etapa:'
                                                                                        },
                                                                                        {
                                                                                            x:150,
                                                                                            y:45,
                                                                                            cls:'SIUGJ_ControlEtiqueta',
                                                                                            html:nodoDestino.attributes.etapa
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:80,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'T&eacute;rmino procesal:'
                                                                                        },
                                                                                        {
                                                                                            x:220,
                                                                                            y:80,
                                                                                            cls:'SIUGJ_ControlEtiqueta',
                                                                                            html:'['+filaOrigen.data.cveTermino+'] '+filaOrigen.data.tituloTermino
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:115,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Funci&oacute;n renderer:'
                                                                                        },
                                                                                        {
                                                                                          xtype:'textfield',
                                                                                          width:500,
                                                                                          x:220,
                                                                                          y:110,
                                                                                          value:'',
                                                                                          cls:'controlSIUGJ',
                                                                                          id:'txtFuncionAplicacion',
                                                                                          readOnly:true
                                                                                      },
                                                                                      {
                                                                                          xtype:'label',
                                                                                          x:740,
                                                                                          y:112,
                                                                                          id:'lblBtnFunciones',
                                                                                          html:'<a href="javascript:agregarFuncionAplicacion(1)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(1)"><img src="../images/cross.png"></a>'
                                                                                      },
                                                                                      
                                                                                      {
                                                                                            x:10,
                                                                                            y:150,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Funci&oacute;n de aplicaci&oacute;n:'
                                                                                        },
                                                                                        {
                                                                                          xtype:'textfield',
                                                                                          width:500,
                                                                                          x:220,
                                                                                          y:145,
                                                                                          value:'',
                                                                                          cls:'controlSIUGJ',
                                                                                          id:'txtFuncionAplicacion2',
                                                                                          readOnly:true
                                                                                      },
                                                                                      {
                                                                                          xtype:'label',
                                                                                          x:740,
                                                                                          y:145,
                                                                                          id:'lblBtnFunciones2',
                                                                                          html:'<a href="javascript:agregarFuncionAplicacion(4)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(4)"><img src="../images/cross.png"></a>'
                                                                                      },
                                                                                      
                                                                                      {
                                                                                            x:10,
                                                                                            y:185,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Funci&oacute;n de detalle:'
                                                                                        },
                                                                                        {
                                                                                          xtype:'textfield',
                                                                                          width:500,
                                                                                          x:220,
                                                                                          y:180,
                                                                                          value:'',
                                                                                          cls:'controlSIUGJ',
                                                                                          id:'txtFuncionAplicacion7',
                                                                                          readOnly:true
                                                                                      },
                                                                                      {
                                                                                          xtype:'label',
                                                                                          x:740,
                                                                                          y:182,
                                                                                          id:'lblBtnFunciones7',
                                                                                          html:'<a href="javascript:agregarFuncionAplicacion(7)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(7)"><img src="../images/cross.png"></a>'
                                                                                      },
                                                                                      
                                                                                      
                                                                                       {
                                                                                            x:10,
                                                                                            y:220,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Tipo de intervalo de tiempo:'
                                                                                        },
                                                                                      	{
                                                                                            x:280,
                                                                                            y:215,
                                                                                            html:'<div id="divComboIntervaloTiempo"></div>'
                                                                                        },
                                                                                      
                                                                                        {
                                                                                            x:10,
                                                                                            y:270,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Periodo del t&eacute;rmino:'
                                                                                        },
                                                                                        {
                                                                                            x:220,
                                                                                            y:265,
                                                                                            cls:'controlSIUGJ',
                                                                                            xtype:'numberfield',
                                                                                            allowDecimals:false,
                                                                                            allowNegative:false,
                                                                                            width:80,
                                                                                            id:'txtPeriodoTermino'
                                                                                        },
                                                                                        {
                                                                                          xtype:'textfield',
                                                                                          width:350,
                                                                                          x:220,
                                                                                          y:265,
                                                                                          value:'',
                                                                                          hidden:true,
                                                                                          cls:'controlSIUGJ',
                                                                                          id:'txtFuncionPeriodoTermino',
                                                                                          readOnly:true
                                                                                      },
                                                                                      {
                                                                                          xtype:'label',
                                                                                          x:590,
                                                                                          y:267,
                                                                                          hidden:true,
                                                                                          id:'lblBtnFunciones3',
                                                                                          html:'<a href="javascript:agregarFuncionAplicacion(5)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(5)"><img src="../images/cross.png"></a>'
                                                                                      },
                                                                                        {
                                                                                            x:310,
                                                                                            y:265,
                                                                                            html:'<div id="divComboPeriodoTermino"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:590,
                                                                                            y:270,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            id:'lblAPartir',
                                                                                            html:'A partir de:'
                                                                                        },
                                                                                        {
                                                                                            x:710,
                                                                                            y:265,
                                                                                            html:'<div id="divComboApartir"></div>'
                                                                                        },
                                                                                        
                                                                                      {
                                                                                            x:10,
                                                                                            y:320,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            id:'lblHoraLimiteTermino',
                                                                                            html:'Hora l&iacute;mite del t&eacute;rmino:'
                                                                                       },
                                                                                       {
                                                                                            x:250,
                                                                                            y:315,
                                                                                            html:'<div id="divComboHoraLimite"></div>'
                                                                                        },
                                                                                       
                                                                                      {
                                                                                            x:10,
                                                                                            y:370,
																							cls:'SIUGJ_Etiqueta',
                                                                                            html:'Usuario asignado a t&eacute;rmino:'
                                                                                       },
                                                                                       {
                                                                                          xtype:'textfield',
                                                                                          width:300,
                                                                                          x:310,
                                                                                          y:365,
                                                                                          value:'',
                                                                                          id:'txtFuncionAplicacion8',
                                                                                          cls:'controlSIUGJ',
                                                                                          readOnly:true
                                                                                      },
                                                                                      {
                                                                                          xtype:'label',
                                                                                          x:630,
                                                                                          y:367,
                                                                                          id:'lblBtnFunciones8',
                                                                                          html:'<a href="javascript:agregarFuncionAplicacion(8)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(8)"><img src="../images/cross.png"></a>'
                                                                                      }
                                                                            		]
                                                                        },
                                                                        
                                                                        {	
                                                                            xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Arranque T&eacute;rmino',
                                                                            items:	[
                                                                            			{
                                                                                        	x:10,
                                                                                            y:20,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                        	html:'Funci\xF3n a ejecutar:',
                                                                                            
                                                                                        },
                                                                                        {
                                                                                              xtype:'textfield',
                                                                                              width:350,
                                                                                              x:220,
                                                                                              y:15,
                                                                                              value:'',
                                                                                              cls:'controlSIUGJ',
                                                                                              id:'txtFuncionEjecucionArranqueTermino',
                                                                                              readOnly:true
                                                                                          },
                                                                                          {
                                                                                              xtype:'label',
                                                                                              x:590,
                                                                                              y:17,
                                                                                              id:'lblBtnFunciones110',
                                                                                              html:'<a href="javascript:agregarFuncionAplicacion(110)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(110)"><img src="../images/cross.png"></a>'
                                                                                          },
                                                                                          
                                                                                          {
                                                                                        	x:10,
                                                                                            y:55,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                        	html:'Funci\xF3n a condicional de arranque:',
                                                                                            
                                                                                        },
                                                                                        {
                                                                                              xtype:'textfield',
                                                                                              width:350,
                                                                                              x:320,
                                                                                              y:50,
                                                                                              value:'',
                                                                                              cls:'controlSIUGJ',
                                                                                              id:'txtFuncionCondicionalEjecucionArranqueTermino',
                                                                                              readOnly:true
                                                                                          },
                                                                                          {
                                                                                              xtype:'label',
                                                                                              x:690,
                                                                                              y:52,
                                                                                              id:'lblBtnFunciones1100',
                                                                                              html:'<a href="javascript:agregarFuncionAplicacion(100)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(100)"><img src="../images/cross.png"></a>'
                                                                                          },
                                                                                          
                                                                                          
                                                                                     	 {
                                                                                        	x:10,
                                                                                            y:90,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                        	html:'Proceso a Arrancar:',
                                                                                            
                                                                                        },
                                                                                        {
                                                                                            x:220,
                                                                                            y:85,
                                                                                            html:'<div id="divComboProcesoArranque3" style="width:510px"></div>'
                                                                                        },
											    
                                                                                        {
                                                                                        	x:10,
                                                                                            y:140,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                        	html:'Etapa de Arraque:',
                                                                                            
                                                                                        },
                                                                                        {
                                                                                            x:220,
                                                                                            y:135,
                                                                                            html:'<div id="divComboEtapaArranque3" style="width:510px"></div>'
                                                                                        },
                                                                                        crearGridCamposProcesoArranque('3',nodoDestino,(nodoEdita?nodoEdita.id.replace('e_',''):'-1'))
                                                                            		]
                                                                        },
                                                                        {	
                                                                            xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Cumplimiento T&eacute;rmino',
                                                                            items:	[
                                                                            			{
                                                                                        	x:10,
                                                                                            y:20,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                        	html:'Funci\xF3n a Ejecutar:',
                                                                                            
                                                                                        },
                                                                                        {
                                                                                          xtype:'textfield',
                                                                                          width:350,
                                                                                          x:220,
                                                                                          y:15,
                                                                                          value:'',
                                                                                          cls:'controlSIUGJ',
                                                                                          id:'txtFuncionEjecucionCumplimientoTermino',
                                                                                          readOnly:true
                                                                                      },
                                                                                      {
                                                                                          xtype:'label',
                                                                                          x:590,
                                                                                          y:17,
                                                                                          id:'lblBtnFunciones10',
                                                                                          html:'<a href="javascript:agregarFuncionAplicacion(2)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(2)"><img src="../images/cross.png"></a>'
                                                                                      },
                                                                                      {
                                                                                        x:10,
                                                                                        y:55,
                                                                                        cls:'SIUGJ_Etiqueta',
                                                                                        html:'Funci\xF3n a Condicional de Arranque:',
                                                                                        
                                                                                    },
                                                                                    {
                                                                                          xtype:'textfield',
                                                                                          width:350,
                                                                                          x:320,
                                                                                          y:50,
                                                                                          value:'',
                                                                                          cls:'controlSIUGJ',
                                                                                          id:'txtFuncionCondicionalEjecucionCumplimientoTermino',
                                                                                          readOnly:true
                                                                                      },
                                                                                      {
                                                                                          xtype:'label',
                                                                                          x:690,
                                                                                          y:52,
                                                                                          id:'lblBtnFunciones1101',
                                                                                          html:'<a href="javascript:agregarFuncionAplicacion(101)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(101)"><img src="../images/cross.png"></a>'
                                                                                      },
                                                                                      {
                                                                                        	x:10,
                                                                                            y:90,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                        	html:'Proceso a Arrancar:',
                                                                                            
                                                                                        },
                                                                                        {
                                                                                            x:220,
                                                                                            y:85,
                                                                                            html:'<div id="divComboProcesoArranque1" style="width:510px"></div>'
                                                                                        },
                                                                                        {
                                                                                        	x:10,
                                                                                            y:140,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                        	html:'Etapa de Arraque:',
                                                                                            
                                                                                        },
                                                                                        {
                                                                                            x:220,
                                                                                            y:135,
                                                                                            html:'<div id="divComboEtapaArranque1" style="width:510px"></div>'
                                                                                        },
                                                                                        crearGridCamposProcesoArranque('1',nodoDestino,(nodoEdita?nodoEdita.id.replace('e_',''):'-1'))
                                                                            		]
                                                                        },
                                                                        {	
                                                                            xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Vencimiento T&eacute;rmino',
                                                                            items:	[
                                                                            			{
                                                                                        	x:10,
                                                                                            y:20,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                        	html:'Funci\xF3n a Ejecutar:',
                                                                                            
                                                                                        },
                                                                                        
                                                                                        {
                                                                                              xtype:'textfield',
                                                                                              width:350,
                                                                                              x:220,
                                                                                              y:15,
                                                                                              value:'',
                                                                                               cls:'controlSIUGJ',
                                                                                              id:'txtFuncionEjecucionVencimientoTermino',
                                                                                              readOnly:true
                                                                                          },
                                                                                          {
                                                                                              xtype:'label',
                                                                                              x:590,
                                                                                              y:17,
                                                                                              id:'lblBtnFunciones11',
                                                                                              html:'<a href="javascript:agregarFuncionAplicacion(3)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(3)"><img src="../images/cross.png"></a>'
                                                                                          },
                                                                                          {
                                                                                        	x:10,
                                                                                            y:55,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                        	html:'Funci\xF3n a Condicional de Arranque:',
                                                                                            
                                                                                        },
                                                                                        {
                                                                                              xtype:'textfield',
                                                                                              width:350,
                                                                                              x:320,
                                                                                              y:50,
                                                                                              value:'',
                                                                                               cls:'controlSIUGJ',
                                                                                              id:'txtFuncionCondicionalEjecucionVencimientoTermino',
                                                                                              readOnly:true
                                                                                          },
                                                                                          {
                                                                                              xtype:'label',
                                                                                              x:690,
                                                                                              y:52,
                                                                                              id:'lblBtnFunciones1102',
                                                                                              html:'<a href="javascript:agregarFuncionAplicacion(102)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(102)"><img src="../images/cross.png"></a>'
                                                                                          },
                                                                                     	 {
                                                                                        	x:10,
                                                                                            y:90,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                        	html:'Proceso a Arrancar:',
                                                                                            
                                                                                        },
                                                                                         {
                                                                                            x:220,
                                                                                            y:85,
                                                                                            html:'<div id="divComboProcesoArranque2" style="width:510px"></div>'
                                                                                        },
                                                                                        {
                                                                                        	x:10,
                                                                                            y:140,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                        	html:'Etapa de Arraque:',
                                                                                            
                                                                                        },
                                                                                        {
                                                                                            x:220,
                                                                                            y:135,
                                                                                            html:'<div id="divComboEtapaArranque2" style="width:510px"></div>'
                                                                                        },
                                                                                        crearGridCamposProcesoArranque('2',nodoDestino,(nodoEdita?nodoEdita.id.replace('e_',''):'-1'))
                                                                            		]
                                                                        }
                                                            		]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar T&eacute;rmino Procesal',
										width: 990,
										height:580,
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
                                                                	gEx('tabTermino').setActiveTab(1);
                                                                    gEx('tabTermino').setActiveTab(2);
                                                                    gEx('tabTermino').setActiveTab(3);
                                                                    gEx('tabTermino').setActiveTab(0);    
                                                                	var cmbTipoIntervaloTiempo=crearComboExt('cmbTipoIntervaloTiempo',[['1','Valor Manual'],['2','Mediante Funci\xF3n de Sistema']],0,0,350,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboIntervaloTiempo'}); 
                                                                    cmbTipoIntervaloTiempo.setValue('1');                           
                                                                    cmbTipoIntervaloTiempo.on('select',function(cmb,registro)
                                                                                                        {
                                                                                                            switch(registro.data.id)
                                                                                                            {
                                                                                                                case '1':
                                                                                                                    gEx('txtPeriodoTermino').show();

                                                                                                                    gEx('lblAPartir').show();

                                                                                                                    gEx('txtFuncionPeriodoTermino').hide();
                                                                                                                    gEx('lblBtnFunciones3').hide();
                                                                                                                    gEx('txtFuncionPeriodoTermino').setValue('');
                                                                                                                    gEx('txtFuncionPeriodoTermino').idConsulta='-1';
                                                                                                                    gEx('lblHoraLimiteTermino').show();
                                                                                                                    
                                                                                                                    
                                                                                                                    
                                                                                                                    mE('divComboApartir');
                                                                                                                    mE('divComboPeriodoTermino');
                                                                                                                    mE('divComboHoraLimite');
                                                                                                                    
                                                                                                                break;
                                                                                                                case '2':
                                                                                                                    gEx('txtPeriodoTermino').setValue('');
                                                                                                                    
                                                                                                                    gEx('cmbAPartir').setValue('');
                                                                                                                    gEx('txtFuncionPeriodoTermino').show();
                                                                                                                    gEx('lblBtnFunciones3').show();
                                                                                                                    gEx('lblHoraLimiteTermino').hide();
                                                                                                                    gEx('cmbHoraLimite').setValue('');
                                                                                                                    gEx('txtPeriodoTermino').hide();
                                                                                                                    gEx('lblAPartir').hide();
                                                                                                                    
                                                                                                                    oE('divComboApartir');
                                                                                                                    oE('divComboPeriodoTermino');
                                                                                                                    oE('divComboHoraLimite');
                                                                                                                    
                                                                                                                
                                                                                                                break;
                                                                                                            }
                                                                                                        }
                                                                                            )
																	
                                                                    var cmbPeriodoTermino=crearComboExt('cmbPeriodoTermino',arrPeriodoTermino,0,0,220 ,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboPeriodoTermino'});
    																
                                                                    var cmbAPartir=crearComboExt('cmbAPartir',arrOpcionesApartir,0,0,180,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboApartir'});
                                                                	var cmbHoraLimite=crearCampoHoraExt('cmbHoraLimite','07:00','20:00',15,false,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboHoraLimite'});
                                                                    cmbHoraLimite.setWidth(180);  
                                                                    
                                                                    var cmbProcesoArranque3=crearComboExt('cmbProcesoArranque_3',arrProcesoArranque,0,0,500,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboProcesoArranque3'});
                                                                    cmbProcesoArranque3.setValue('0');
                                                                    cmbProcesoArranque3.on('select',function(cmb,registro)
                                                                                                    {
                                                                                                        if(registro.data.id=='0')
                                                                                                        {
                                                                                                            gEx('cmbEtapaArranque3').setValue('');
                                                                                                            gEx('cmbEtapaArranque3').disable();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            gEx('cmbEtapaArranque3').setValue('');
                                                                                                            gEx('cmbEtapaArranque3').getStore().loadData(registro.data.valorComp);
                                                                                                            gEx('cmbEtapaArranque3').enable();
                                                                                                        }
                                                                                                        gEx('gCamposTablero_3').getStore().reload();
                                                                                                    }
                                                                                            )    
                                                                                            
                                                                    var cmbEtapaArranque3=   crearComboExt('cmbEtapaArranque3',[],0,0,500,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboEtapaArranque3'}); 
                                                                    cmbEtapaArranque3.disable();  
                                                                    
                                                                    var cmbProcesoArranque1=crearComboExt('cmbProcesoArranque_1',arrProcesoArranque,0,0,500,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboProcesoArranque1'});
                                                                    cmbProcesoArranque1.setValue('0');
                                                                    cmbProcesoArranque1.on('select',function(cmb,registro)
                                                                                                    {
                                                                                                        if(registro.data.id=='0')
                                                                                                        {
                                                                                                            gEx('cmbEtapaArranque1').setValue('');
                                                                                                            gEx('cmbEtapaArranque1').disable();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            gEx('cmbEtapaArranque1').setValue('');
                                                                                                            gEx('cmbEtapaArranque1').getStore().loadData(registro.data.valorComp);
                                                                                                            gEx('cmbEtapaArranque1').enable();
                                                                                                        }
                                                                                                        gEx('gCamposTablero_1').getStore().reload();
                                                                                                    }
                                                                                            )
                                                                    
                                                                    
                                                                    var cmbEtapaArranque1=   crearComboExt('cmbEtapaArranque1',[],0,0,500,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboEtapaArranque1'}); 
																	cmbEtapaArranque1.disable();
                                                                    
                                                                    
                                                                    var cmbProcesoArranque2=crearComboExt('cmbProcesoArranque_2',arrProcesoArranque,0,0,500,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboProcesoArranque2'});
                                                                    cmbProcesoArranque2.setValue('0');
                                                                    cmbProcesoArranque2.on('select',function(cmb,registro)
                                                                                                    {
                                                                                                        if(registro.data.id=='0')
                                                                                                        {
                                                                                                            gEx('cmbEtapaArranque2').setValue('');
                                                                                                            gEx('cmbEtapaArranque2').disable();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            gEx('cmbEtapaArranque2').setValue('');
                                                                                                            gEx('cmbEtapaArranque2').getStore().loadData(registro.data.valorComp);
                                                                                                            gEx('cmbEtapaArranque2').enable();
                                                                                                        }
                                                                                                        gEx('gCamposTablero_2').getStore().reload();
                                                                                                    }
                                                                                            )
                                                                    
                                                                                     
                                                                                            
                                                                                                                         
                                                                                            
                                                                                              
                                                                
                                                                
                                                                    
                                                                    var cmbEtapaArranque2=   crearComboExt('cmbEtapaArranque2',[],0,0,500,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboEtapaArranque2'}); 
                                                                    cmbEtapaArranque2.disable();      
                                                                    
                                                                    if(nodoEdita)
                                                                    {
                                                                        gEx('txtFuncionAplicacion').idConsulta=nodoEdita.attributes.funcionRenderer;
                                                                        gEx('txtFuncionAplicacion2').idConsulta=nodoEdita.attributes.idFuncionAplicacion;
                                                                        gEx('txtFuncionAplicacion').setValue(nodoEdita.attributes.lblFuncionRenderer);
                                                                        gEx('txtFuncionAplicacion2').setValue(nodoEdita.attributes.lblMetodoAplicacion);
                                                                        
                                                                        gEx('txtFuncionAplicacion7').setValue(nodoEdita.attributes.lblMetodoDetalle);
                                                                        gEx('txtFuncionAplicacion7').idConsulta=nodoEdita.attributes.idFuncionDetalle;
                                                                        gEx('txtFuncionAplicacion8').idConsulta=nodoEdita.attributes.idFuncionUsuarioAsignado;
                                                                        gEx('txtFuncionAplicacion8').setValue(nodoEdita.attributes.lblMetodoUsuarioAsignado);
                                                                        
                                                                        var objConfiguracion=eval('['+bD(nodoEdita.attributes.objConfiguracion)+']')[0];
                                                                        cmbTipoIntervaloTiempo.setValue(objConfiguracion.datosGenerales.tipoIntervaloTiempo);
                                                                        dispararEventoSelectCombo('cmbTipoIntervaloTiempo');
                                                                        gEx('txtPeriodoTermino').setValue(objConfiguracion.datosGenerales.cvePeriodoTiempo);
                                                                        gEx('cmbPeriodoTermino').setValue(objConfiguracion.datosGenerales.periodoTiempo);
                                                                        gEx('txtFuncionPeriodoTermino').idConsulta=objConfiguracion.datosGenerales.txtFuncionPeriodoTermino;
                                                                        var objConfiguracionComplementaria=eval('['+bD(nodoEdita.attributes.objConfiguracionComplementaria)+']')[0];
                                                                        gEx('txtFuncionPeriodoTermino').setValue(objConfiguracionComplementaria.lblFuncionPeriodoTermino);
                                                                       
                                                                        gEx('txtFuncionEjecucionCumplimientoTermino').idConsulta=objConfiguracion.cumplimientoTermino.funcionEjecucion;
                                                                        gEx('txtFuncionEjecucionCumplimientoTermino').setValue(objConfiguracionComplementaria.lblFuncionCumplimiento);
                                                                        
                                                                        gEx('txtFuncionEjecucionVencimientoTermino').idConsulta=objConfiguracion.vencimientoTermino.funcionEjecucion;
                                                                        gEx('txtFuncionEjecucionVencimientoTermino').setValue(objConfiguracionComplementaria.lblFuncionVencimiento);
                                                                        
                                                                        gEx('txtFuncionEjecucionArranqueTermino').idConsulta=objConfiguracion.arranqueTermino.funcionEjecucion;
                                                                        gEx('txtFuncionEjecucionArranqueTermino').setValue(objConfiguracionComplementaria.lblFuncionArranque);
                                                                        
                                                                        
                                                                        
                                                                        var txtFuncionCondicionalEjecucionArranqueTermino=gEx('txtFuncionCondicionalEjecucionArranqueTermino');
                                                                        var txtFuncionCondicionalEjecucionCumplimientoTermino=gEx('txtFuncionCondicionalEjecucionCumplimientoTermino');
                                                                        var txtFuncionCondicionalEjecucionVencimientoTermino=gEx('txtFuncionCondicionalEjecucionVencimientoTermino');
                                                                        
                                                                        if(objConfiguracion.arranqueTermino.funcionCondicionalArranque)
                                                                        {
                                                                            txtFuncionCondicionalEjecucionArranqueTermino.idConsulta=objConfiguracion.arranqueTermino.funcionCondicionalArranque;
                                                                            txtFuncionCondicionalEjecucionArranqueTermino.setValue(objConfiguracionComplementaria.lblFuncionCondicionalArranqueTermino);
                                                                        }
                                                                        
                                                                        if(objConfiguracion.cumplimientoTermino.funcionCondicionalArranque)
                                                                        {        
                                                                            txtFuncionCondicionalEjecucionCumplimientoTermino.idConsulta=objConfiguracion.cumplimientoTermino.funcionCondicionalArranque;
                                                                            txtFuncionCondicionalEjecucionCumplimientoTermino.setValue(objConfiguracionComplementaria.lblFuncionCondicionalCumplimientoTermino);
                                                                        } 
                                                                        
                                                                        if(objConfiguracion.vencimientoTermino.funcionCondicionalArranque)
                                                                        {           
                                                                            txtFuncionCondicionalEjecucionVencimientoTermino.idConsulta=objConfiguracion.vencimientoTermino.funcionCondicionalArranque;
                                                                            txtFuncionCondicionalEjecucionVencimientoTermino.setValue(objConfiguracionComplementaria.lblFuncionCondicionalVencimientoTermino);
                                                                        }
                                                                                                                                        
                                                                        if(objConfiguracion.cumplimientoTermino.procesoArranque!='-1')
                                                                        {
                                                                            cmbProcesoArranque1.setValue(objConfiguracion.cumplimientoTermino.procesoArranque);
                                                                            dispararEventoSelectCombo('cmbProcesoArranque_1');
                                                                        }
                                                                        
                                                                         if(objConfiguracion.vencimientoTermino.procesoArranque!='-1')
                                                                        {
                                                                            cmbProcesoArranque2.setValue(objConfiguracion.vencimientoTermino.procesoArranque);
                                                                            dispararEventoSelectCombo('cmbProcesoArranque_2');
                                                                        }
                                                                        
                                                                        
                                                                         if(objConfiguracion.arranqueTermino.procesoArranque!='-1')
                                                                        {
                                                                            cmbProcesoArranque3.setValue(objConfiguracion.arranqueTermino.procesoArranque);
                                                                            dispararEventoSelectCombo('cmbProcesoArranque_3');
                                                                        }
                                                                
                                                                        cmbEtapaArranque1.setValue(objConfiguracion.cumplimientoTermino.etapaArranque);
                                                                        cmbEtapaArranque2.setValue(objConfiguracion.vencimientoTermino.etapaArranque);
                                                                        cmbEtapaArranque3.setValue(objConfiguracion.arranqueTermino.etapaArranque);
                                                                        cmbAPartir.setValue(objConfiguracion.datosGenerales.aPartirDe?objConfiguracion.datosGenerales.aPartirDe:'');
                                                                        cmbHoraLimite.setValue(objConfiguracion.datosGenerales.horaLimite?objConfiguracion.datosGenerales.horaLimite:'');
                                                                    }
                                                                      
                                                                
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
                                                                    	
                                                                        var txtPeriodoTermino=gEx('txtPeriodoTermino');
                                                                        var txtFuncionPeriodoTermino=gEx('txtFuncionPeriodoTermino');
                                                                        var cmbTipoIntervaloTiempo=gEx('cmbTipoIntervaloTiempo');
                                                                        var cmbPeriodoTermino=gEx('cmbPeriodoTermino');
                                                                        var cmbAPartir=gEx('cmbAPartir');
                                                                        var cmbHoraLimite=gEx('cmbHoraLimite');
                                                                        if(cmbTipoIntervaloTiempo.getValue()=='1')
                                                                        {
                                                                        	if((txtPeriodoTermino.getValue()=='')&&(txtPeriodoTermino.getValue()!='0'))
                                                                            {
                                                                            	function respAux2()
                                                                                {
                                                                                	gEx('tabTermino').setActiveTab(0);
                                                                                	txtPeriodoTermino.focus();
                                                                                }
                                                                               	msgBox('Debe indicar el periodo que tendr&aacute; el t&eacute;rmino a agregar',respAux2);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(cmbPeriodoTermino.getValue()=='')
                                                                            {
                                                                            	function respAux3()
                                                                                {
                                                                                	gEx('tabTermino').setActiveTab(0);
                                                                                	cmbPeriodoTermino.focus();
                                                                                }
                                                                               	msgBox('Debe indicar el periodo de tiempo que tendr&aacute; el t&eacute;rmino a agregar',respAux3);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(cmbAPartir.getValue()=='')
                                                                            {
                                                                            	function respAux2()
                                                                                {
                                                                                	gEx('tabTermino').setActiveTab(0);
                                                                                	cmbAPartir.focus();
                                                                                }
                                                                               	msgBox('Debe indicar a partir de cuando, se calculara el periodo del t&eacute;rmino a agregar',respAux2);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(cmbHoraLimite.getValue()=='')
                                                                            {
                                                                            	function respAux2()
                                                                                {
                                                                                	gEx('tabTermino').setActiveTab(0);
                                                                                	cmbHoraLimite.focus();
                                                                                }
                                                                               	msgBox('Debe indicar el horario a partir del cual ser&aacute; considerad&aacute; al t&eacute;rmino como vencido',respAux2);
                                                                                return;
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                        	if(!txtFuncionPeriodoTermino.idConsulta || txtFuncionPeriodoTermino.idConsulta=='-1')
                                                                            {
                                                                            	function respAux()
                                                                                {
                                                                                	gEx('tabTermino').setActiveTab(0);
                                                                                }
                                                                               	msgBox('Debe indicar la funci&oacute;n que define el periodo de t&eacute;rmino',respAux);
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        
                                                                        var gCamposTablero=gEx('gCamposTablero_1');
                                                                        var x;
																		var fila;
                                                                        var aRegistros='';
                                                                        for(x=0;x<gCamposTablero.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gCamposTablero.getStore().getAt(x);
                                                                            
                                                                            if(fila.data.tipoLlenado=='')
                                                                            {
                                                                            	function resp()
                                                                                {
                                                                                	gEx('tabTermino').setActiveTab(1);
                                                                                	gCamposTablero.startEditing(x,3);
                                                                                }
                                                                                msgBox('Debe indicar el tipo de llenado del campo',resp)
                                                                            	return;
                                                                            }
                                                                            
                                                                            if((fila.data.tipoLlenado!='0')&&(fila.data.valor==''))
                                                                            {
                                                                            	function resp2()
                                                                                {
                                                                                	if(fila.data.tipoLlenado!='7')
                                                                                    {
                                                                                    	gEx('tabTermino').setActiveTab(1);
	                                                                                	gCamposTablero.startEditing(x,3);
                                                                                	}
                                                                                }
                                                                                msgBox('Debe indicar el valor a asignar al campo destino',resp2)
                                                                            	return;
                                                                            }
                                                                            
                                                                            obj='{"campoDestino":"'+fila.data.nombreCampo+'","tipoLlenado":"'+fila.data.tipoLlenado+'","valor":"'+cv(fila.data.valor,false,true)+'"}';
                                                                            
                                                                            if(aRegistros=='')
                                                                            {
                                                                            	aRegistros=obj;
                                                                            }
                                                                            else
                                                                            {
                                                                            	aRegistros+=','+obj;
                                                                            }
                                                                        }
                                                                        
                                                                        var arrRegistrosCumplimientoTermino='['+aRegistros+']';
                                                                        aRegistros='';
                                                                        var gCamposTablero=gEx('gCamposTablero_2');
                                                                        for(x=0;x<gCamposTablero.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gCamposTablero.getStore().getAt(x);
                                                                            
                                                                            if(fila.data.tipoLlenado=='')
                                                                            {
                                                                            	function resp()
                                                                                {
                                                                                	gEx('tabTermino').setActiveTab(2);
                                                                                	gCamposTablero.startEditing(x,3);
                                                                                }
                                                                                msgBox('Debe indicar el tipo de llenado del campo',resp)
                                                                            	return;
                                                                            }
                                                                            
                                                                            if((fila.data.tipoLlenado!='0')&&(fila.data.valor==''))
                                                                            {
                                                                            	function resp2()
                                                                                {
                                                                                	if(fila.data.tipoLlenado!='7')
                                                                                    {
                                                                                    	gEx('tabTermino').setActiveTab(2);
	                                                                                	gCamposTablero.startEditing(x,3);
                                                                                	}
                                                                                }
                                                                                msgBox('Debe indicar el valor a asignar al campo destino',resp2)
                                                                            	return;
                                                                            }
                                                                            
                                                                            obj='{"campoDestino":"'+fila.data.nombreCampo+'","tipoLlenado":"'+fila.data.tipoLlenado+'","valor":"'+cv(fila.data.valor,false,true)+'"}';
                                                                            
                                                                            if(aRegistros=='')
                                                                            {
                                                                            	aRegistros=obj;
                                                                            }
                                                                            else
                                                                            {
                                                                            	aRegistros+=','+obj;
                                                                            }
                                                                        }
                                                                        
                                                                        var arrRegistrosVencimientoTermino='['+aRegistros+']';
                                                                        aRegistros='';
                                                                        
                                                                        var gCamposTablero=gEx('gCamposTablero_3');
                                                                        for(x=0;x<gCamposTablero.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gCamposTablero.getStore().getAt(x);
                                                                            
                                                                            if(fila.data.tipoLlenado=='')
                                                                            {
                                                                            	function resp()
                                                                                {
                                                                                	gEx('tabTermino').setActiveTab(2);
                                                                                	gCamposTablero.startEditing(x,3);
                                                                                }
                                                                                msgBox('Debe indicar el tipo de llenado del campo',resp)
                                                                            	return;
                                                                            }
                                                                            
                                                                            if((fila.data.tipoLlenado!='0')&&(fila.data.valor==''))
                                                                            {
                                                                            	function resp2()
                                                                                {
                                                                                	if(fila.data.tipoLlenado!='7')
                                                                                    {
                                                                                    	gEx('tabTermino').setActiveTab(2);
	                                                                                	gCamposTablero.startEditing(x,3);
                                                                                	}
                                                                                }
                                                                                msgBox('Debe indicar el valor a asignar al campo destino',resp2)
                                                                            	return;
                                                                            }
                                                                            
                                                                            obj='{"campoDestino":"'+fila.data.nombreCampo+'","tipoLlenado":"'+fila.data.tipoLlenado+'","valor":"'+cv(fila.data.valor,false,true)+'"}';
                                                                            
                                                                            if(aRegistros=='')
                                                                            {
                                                                            	aRegistros=obj;
                                                                            }
                                                                            else
                                                                            {
                                                                            	aRegistros+=','+obj;
                                                                            }
                                                                        }
                                                                        
                                                                        var arrRegistrosArranqueTermino='['+aRegistros+']';
                                                                        
                                                                        
                                                                        var txtFuncionEjecucionCumplimientoTermino=gEx('txtFuncionEjecucionCumplimientoTermino');
                                                                        var txtFuncionEjecucionVencimientoTermino=gEx('txtFuncionEjecucionVencimientoTermino');
                                                                        var txtFuncionEjecucionArranqueTermino=gEx('txtFuncionEjecucionArranqueTermino');
                                                                        
                                                                        
                                                                        var cmbProcesoArranque1=gEx('cmbProcesoArranque_1');
                                                                        var cmbProcesoArranque2=gEx('cmbProcesoArranque_2');
                                                                        var cmbProcesoArranque3=gEx('cmbProcesoArranque_3');
                                                                        var cmbEtapaArranque1=gEx('cmbEtapaArranque1');
                                                                        var cmbEtapaArranque2=gEx('cmbEtapaArranque2');
                                                                        var cmbEtapaArranque3=gEx('cmbEtapaArranque3');

                                                                        if(cmbProcesoArranque1.getValue()=='')
                                                                        	cmbProcesoArranque1.setValue('0');
                                                                        
                                                                        if(cmbProcesoArranque2.getValue()=='')
                                                                        	cmbProcesoArranque2.setValue('0');
                                                                        
                                                                        
                                                                        if(cmbProcesoArranque3.getValue()=='')
                                                                        	cmbProcesoArranque3.setValue('0');
                                                                        
                                                                        var txtFuncionAplicacion7=gEx('txtFuncionAplicacion7');
                                                                    	if(!txtFuncionAplicacion7.idConsulta || txtFuncionAplicacion7.idConsulta=='')
                                                                        	txtFuncionAplicacion7.idConsulta='-1';
                                                                        
                                                                        
                                                                        var txtFuncionAplicacion=gEx('txtFuncionAplicacion');
                                                                        var txtFuncionAplicacion2=gEx('txtFuncionAplicacion2');
                                                                        var txtPeriodoTermino=gEx('txtPeriodoTermino');
                                                                        var txtFuncionPeriodoTermino=gEx('txtFuncionPeriodoTermino');
                                                                        var txtFuncionAplicacion8=gEx('txtFuncionAplicacion8');
                                                                        
                                                                        
                                                                        var txtFuncionCondicionalEjecucionArranqueTermino=gEx('txtFuncionCondicionalEjecucionArranqueTermino');
                                                                        var txtFuncionCondicionalEjecucionCumplimientoTermino=gEx('txtFuncionCondicionalEjecucionCumplimientoTermino');
                                                                        var txtFuncionCondicionalEjecucionVencimientoTermino=gEx('txtFuncionCondicionalEjecucionVencimientoTermino');
                                                                        
                                                                        
                                                                        var objAccion='{"datosGenerales":{"tipoIntervaloTiempo":"'+cmbTipoIntervaloTiempo.getValue()+'","cvePeriodoTiempo":"'+txtPeriodoTermino.getValue()+'","periodoTiempo":"'+cmbPeriodoTermino.getValue()+
																						'","txtFuncionPeriodoTermino":"'+(txtFuncionPeriodoTermino.idConsulta?txtFuncionPeriodoTermino.idConsulta:-1)+'","aPartirDe":"'+gEx('cmbAPartir').getValue()+
                                                                                        '","horaLimite":"'+cmbHoraLimite.getValue()+'"},'+
                                                                        			'"cumplimientoTermino":{"funcionEjecucion":"'+(txtFuncionEjecucionCumplimientoTermino.idConsulta?txtFuncionEjecucionCumplimientoTermino.idConsulta:-1)+
                                                                        			'","funcionCondicionalArranque":"'+(txtFuncionCondicionalEjecucionCumplimientoTermino.idConsulta?txtFuncionCondicionalEjecucionCumplimientoTermino.idConsulta:-1)+
                                                                                    '","procesoArranque":"'+cmbProcesoArranque1.getValue()+'","etapaArranque":"'+cmbEtapaArranque1.getValue()+'","valoresArranque":'+arrRegistrosCumplimientoTermino+
                                                                        			'},"vencimientoTermino":{"funcionEjecucion":"'+(txtFuncionEjecucionVencimientoTermino.idConsulta?txtFuncionEjecucionVencimientoTermino.idConsulta:-1)+
                                                                                    '","funcionCondicionalArranque":"'+(txtFuncionCondicionalEjecucionVencimientoTermino.idConsulta?txtFuncionCondicionalEjecucionVencimientoTermino.idConsulta:-1)+
                                                                                    '","procesoArranque":"'+cmbProcesoArranque2.getValue()+'","etapaArranque":"'+cmbEtapaArranque2.getValue()+'","valoresArranque":'+arrRegistrosVencimientoTermino+
                                                                                    '},"arranqueTermino":{"funcionEjecucion":"'+(txtFuncionEjecucionArranqueTermino.idConsulta?txtFuncionEjecucionArranqueTermino.idConsulta:-1)+
                                                                                    '","funcionCondicionalArranque":"'+(txtFuncionCondicionalEjecucionArranqueTermino.idConsulta?txtFuncionCondicionalEjecucionArranqueTermino.idConsulta:-1)+
                                                                                    '","procesoArranque":"'+cmbProcesoArranque3.getValue()+'","etapaArranque":"'+cmbEtapaArranque3.getValue()+'","valoresArranque":'+arrRegistrosArranqueTermino+
                                                                                    '}}';
                                                                        
                                                                        var cadObj='{"idTerminoProcesal":"'+filaOrigen.data.idRegistro+'","idPadre":"'+nodoDestino.id.replace('p_','')+
                                                                        		'","idRegistro":"'+(nodoEdita?nodoEdita.id.replace('e_',''):'-1')+'","funcionRenderer":"'+(txtFuncionAplicacion.idConsulta?txtFuncionAplicacion.idConsulta:-1)+
                                                                                '","functionAplicacion":"'+(txtFuncionAplicacion2.idConsulta?txtFuncionAplicacion2.idConsulta:-1)+
                                                                                '","objConfiguracionAccion":"'+bE(objAccion)+'","tipoElemento":"4","funcionDetalle":"'+txtFuncionAplicacion7.idConsulta+
                                                                                '","funcionAsignacionUsuario":"'+(txtFuncionAplicacion8.idConsulta?txtFuncionAplicacion8.idConsulta:-1)+'" }';
                                                                        
                                                                        
                                                                       
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('tMacroProceso').getRootNode().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=25&cadObj='+cadObj,true);

                                                                        
                                                                    }
														}
														
													]
									}
								);
	ventanaAM.show();	
	
    
    
    
}

function crearGridCamposProcesoArranque(iGrid,nodoDestino,idRegistroDestino)
{
	
	var cmbLlenado=crearComboExt('cmbLlenado_'+iGrid,tiposLlenado,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
  
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'nombreCampo'},
                                                        {name:'tipoDato'},
		                                                {name: 'tipoLlenado'},
                                                        {name: 'etiquetaValor'},
		                                                {name:'valor'},
                                                        {name: 'esCampoDefault'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php'

                                                                                              }

                                                                                          ),
                                                            
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion=24;
                                        proxy.baseParams.idProcesoDestino=bE(gEx('cmbProcesoArranque_'+iGrid).getValue());
                                        proxy.baseParams.idEtapaProcesoMacropoceso=bE(nodoDestino.id.replace('p_',''));
                                        proxy.baseParams.idProcesoOrigen=bE(nodoDestino.attributes.iProceso);
                                        proxy.baseParams.tipoGrid=bE(iGrid);
                                        proxy.baseParams.idRegistro=bE(idRegistroDestino);
                                        
                                    }
                        )   

	alDatos.on('load',function(proxy)
    								{
                                    	
                                    	arrCamposFormularioBaseOrigen=proxy.reader.jsonData.camposFormularioBase;
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer({width:40}),
                                                        
                                                        {
                                                            header:'Campo de Formulario',
                                                            width:210,
                                                            sortable:true,
                                                            dataIndex:'nombreCampo',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	var color='000';
                                                                        if(registro.data.esCampoDefault=='1')
                                                                        {
                                                                        	color='900';
                                                                        }
                                                                    	return '<span style="color:#'+color+'">'+val+'</span>';
                                                                    }
                                                        },
                                                        {
                                                            header:'Tipo de dato',
                                                            width:170,
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
                                                            width:350,
                                                            sortable:true,
                                                            editor:{xtype:'textfield',id:'campoTexto_'+iGrid},
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
                                                                            	comp='<a href=\'javascript:mostrarVentanaFuncionSistemaTableroControl("'+bE(registro.data.nombreCampo)+'","'+bE(iGrid)+'")\'><img src="../images/pencil.png" width="14" height="14" title="Modificar" alt="Modificar"></a> ';
                                                                            break;
                                                                        }
                                                                    	return comp+mostrarValorDescripcion(registro.data.etiquetaValor);
                                                                    }
                                                        }
                                                    ]
                                                );
                                                    
    var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gCamposTablero_'+iGrid,
                                                            store:alDatos,
                                                            x:10,
                                                            y:185,
                                                            frame:false,
                                                            height:235,
                                                           	border:true,
                                                            cm: cModelo,
                                                            clicksToEdit:1,
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            columnLines : false,
                                                            cls:'gridSiugjPrincipal', 
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
                                    if((e.record.data.tipoLlenado=='0')||(e.record.data.tipoLlenado=='7'))
                                        e.cancel=true;
                                    else
                                    {
                                        
                                    }
                                }
                                
                                   
                                
                            }
    			)
                
                
	tblGrid.on('afteredit',function(e)
    						{
                            	if(e.field=='tipoLlenado')
                                {
                                	e.record.set('valor','');
                                    e.record.set('etiquetaValor','');
                                    
                                    var control=null;
                                    
                                    switch(e.value)
                                    {
                                        case '1': //Valor de sesión
                                            control=crearComboExt('ctrlValor_'+iGrid,arrValorSesionGlobal,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
                                        break;
                                        case '2': //Valor de sistema
                                            control=crearComboExt('ctrlValor_'+iGrid,arrValorSistemaGlobal,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
                                        break;
                                        
                                        case '6':  //Valor de formulario base
                                            control=crearComboExt('ctrlValor_'+iGrid,arrCamposFormularioBaseOrigen,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
                                        break;
                                        case '7':  //Función de sistema
                                            
                                        break;
                                        case '8':  //Valor manual
                                            control=new Ext.form.TextField({cls:'controlSIUGJ',id:'ctrlValor_'+iGrid});
                                        break;
                                        
                                    }
                                    
                                    e.grid.getColumnModel().setEditor(4,control); 
                                    
                                    
                                }
                                
                                
                                if(e.field=='valor')
                                {
                                
                                	var control=gEx('ctrlValor_'+iGrid);
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

function recargarGridCamposArrancaProceso()
{

	gEx('gCamposTablero').getStore().load	(
    											{
                                                	url:'../paginasFunciones/funcionesProyectos.php',
                                                    params:	{
                                                    			idProcesoDestino:bE(gEx('cmbProcesos').getValue())
                                        
                                                    		}
                                                                                                    
												}
    										);
}


function mostrarVentanaFuncionSistemaTableroControl(iCampo,iGrid)
{
	
    asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre,ventana)
                                            {
                                             	var pos=obtenerPosFila(gEx('gCamposTablero_'+bD(iGrid)).getStore(),'nombreCampo',bD(iCampo));
                                                var fila=gEx('gCamposTablero_'+bD(iGrid)).getStore().getAt(pos);
                                                fila.set('valor',idConsulta);
                                                fila.set('etiquetaValor',nombre);
                                                if(gEx('vAgregarExp'))
	                                                gEx('vAgregarExp').close();
                                            }
    mostrarVentanaExpresion(function(filaSelec,ventana)
    						{
                            	var pos=obtenerPosFila(gEx('gCamposTablero_'+bD(iGrid)).getStore(),'nombreCampo',bD(iCampo));
                                var fila=gEx('gCamposTablero_'+bD(iGrid)).getStore().getAt(pos);
                                fila.set('valor',filaSelec.data.idConsulta);
                                fila.set('etiquetaValor',filaSelec.data.nombreConsulta);
                                
                                ventana.close();
                            }
    						,true);
    
}


function pausecomp(millis)
{
    var date = new Date();
    var curDate = null;
    do { curDate = new Date(); }
    while(curDate-date < millis);
}

function modificarElementoProcesoEscenario(iR)
{
	var nodo=buscarNodoID(gEx('tMacroProceso').getRootNode(),'e_'+bD(iR));
	var filaData={};
    filaData.data={};
    
    switch(nodo.attributes.idTipoElemento)
    {
    	case '2':
        	filaData.data.cveEtiquetaActuacion=nodo.attributes.cveElemento;
		    filaData.data.etiquetaActuacion=nodo.attributes.lblElemento.split('] ')[1];
    		filaData.data.idRegistro=nodo.attributes.idElemento;
        	mostrarVentanaAgregarActuacionProceso(nodo.parentNode,filaData,nodo);
        break;
        case '3':
        	filaData.data.cveEtiquetaEtapa=nodo.attributes.cveElemento;
		    filaData.data.etiquetaEtapa=nodo.attributes.lblElemento.split('] ')[1];
    		filaData.data.idRegistro=nodo.attributes.idElemento;
        	mostrarVentanaAgregarEtapaProceso(nodo.parentNode,filaData,nodo);
        break;
        case '4':
        	filaData.data.cveTermino=nodo.attributes.cveElemento;
		    filaData.data.tituloTermino=nodo.attributes.lblElemento.split('] ')[1];
    		filaData.data.idRegistro=nodo.attributes.idElemento;
            
        
        	mostrarVentanaAgregarTerminoProceso(nodo.parentNode,filaData,nodo);
        break;
        case '5':
        	filaData.data.cveTemporizador=nodo.attributes.cveElemento;
		    filaData.data.tituloTemporizador=nodo.attributes.lblElemento.split('] ')[1];
    		filaData.data.idRegistro=nodo.attributes.idElemento;
            mostrarVentanaAgregarTemporizadorProceso(nodo.parentNode,filaData,nodo);
        break;
        case '6':
        	filaData.data.cveTemporizador=nodo.attributes.cveElemento;
		    filaData.data.tituloTemporizador=nodo.attributes.lblElemento.split('] ')[1];
    		filaData.data.idRegistro=nodo.attributes.idElemento;
            mostrarVentanaNotificacionesProceso(nodo.parentNode,filaData,nodo);
        break;
    }
}


function crearGridTemporizador()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'cveTemporizador'},
		                                                {name:'tituloTemporizador'},
                                                        {name:'descripcion'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'cveTemporizador', direction: 'ASC'},
                                                            groupField: 'cveTemporizador',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='26';
                                        proxy.baseParams.iM=gE('idRegistro').value;
                                    }
                        )   
   
   
   
   
   var expander = new Ext.ux.grid.RowExpander({
                                                    column:1,
                                                    width:40,
                                                    tpl : new Ext.Template(
                                                        '<table width="100%" >'+
                                                        '<tr>'+
                                                        	'<td  style="padding:10px">'+
                                                            '{descripcion}'+
                                                            '</td>'+
                                                        '</tr>'+
                                                        '</table>'
                                                    )
                                                }); 	    
   var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                        	expander,
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            
                                                            {
                                                                header:'Clave',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'cveTemporizador',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Nombre del Temporizador',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'tituloTemporizador',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gTemporizadores',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                title:'Temporizadores (Cat&aacute;logo)',
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                plugins:[expander],
                                                                loadMask:true,
                                                                cls:'gridSiugjPrincipal',
                                                                enableDragDrop:true,
                                                                ddGroup:'grupoDrop',
                                                                columnLines : false,
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Registrar',
                                                                                handler:function()
                                                                                        {
                                                                                         	mostrarVentanaTemporizador();   
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	width:10,
                                                                                xtype:'tbspacer'
                                                                            },
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Modificar',
                                                                                handler:function()
                                                                                        {
                                                                                         	var fila=  gEx('gTemporizadores').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el temporizador que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            mostrarVentanaTemporizador(fila);
                                                                                             
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	width:10,
                                                                                xtype:'tbspacer'
                                                                            },
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=  gEx('gTemporizadores').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el temporizador que desea remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            
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
                                                                                                            gEx('gTemporizadores').getStore().reload();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=28&iM='+gE('idRegistro').value+'&iT='+fila.data.idRegistro,true);

                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover el temporizador <b>'+fila.data.tituloTemporizador+'</b>?',resp)
                                                                                            
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

function mostrarVentanaTemporizador(filaTemporizador)
{
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
                                                            html:'Cve. del  Temporizador:'
                                                        },
                                                        {
                                                        	x:250,
                                                            y:15,
                                                            xtype:'textfield',
                                                            width:200,
                                                            cls:'controlSIUGJ',
                                                            value:filaTemporizador?filaTemporizador.data.cveTemporizador:'',
                                                            id:'txtCveTemporizador'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Nombre del Temporizador:'
                                                        },
                                                        {
                                                        	x:250,
                                                            y:65,
                                                            xtype:'textfield',
                                                            width:380,
                                                            cls:'controlSIUGJ',
                                                            value:filaTemporizador?filaTemporizador.data.tituloTemporizador:'',
                                                            id:'tituloTemporizador'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:120,
                                                            cls:'SIUGJ_Etiqueta',                                                            
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:150,
                                                            width:620,
                                                            height:60,
                                                            xtype:'textarea',
                                                            cls:'controlSIUGJ',
                                                            value:filaTemporizador?escaparBR(filaTemporizador.data.descripcion,true):'',
                                                            id:'txtDescripcion'
                                                        }		
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: filaTemporizador?'Modificar Temporizador':'Registrar Temporizador',
										width: 670,
										height:350,
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
                                                                	gEx('txtCveTemporizador').focus(false,500);
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
																		var txtCveTemporizador=gEx('txtCveTemporizador');
                                                                        
                                                                        if(txtCveTemporizador.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtCveTemporizador.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la clave del temporizador',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        var tituloTemporizador=gEx('tituloTemporizador');
                                                                        
                                                                        
                                                                        if(tituloTemporizador.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	tituloTemporizador.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el t&iacute;titulo del temporizador',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        var txtDescripcion=gEx('txtDescripcion');
																	
                                                                    	var cadObj='{"idRegistro":"'+(filaTemporizador?filaTemporizador.data.idRegistro:-1)+'","cveTemporizador":"'+cv(txtCveTemporizador.getValue())+
                                                                        			'","tituloTemporizador":"'+cv(tituloTemporizador.getValue())+'","descripcion":"'+cv(txtDescripcion.getValue())+
                                                                                    '","idMacroProceso":"'+gE('idRegistro').value+'"}';
                                                                    
                                                                    
                                                                    
                                                                    	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gTemporizadores').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=27&cadObj='+cadObj,true);
                                                                        
                                                                    
                                                                    
                                                                    }
														}
														
													]
									}
								);
	ventanaAM.show();
}


function mostrarVentanaAgregarTemporizadorProceso(nodoDestino,filaOrigen,nodoEdita)
{
	
	var arrProcesoArranque=[['0','Ninguno']];
    var x;
    for(x=0;x<arrProcesos.length;x++)
    {
    	arrProcesoArranque.push([arrProcesos[x][0],arrProcesos[x][1],arrProcesos[x][2]]);
    }
	var arrPeriodoTermino=[['1','Horas'],['2','D\xEDas Habiles'],['3','D\xEDas Naturales'],['4','Meses']];

    var arrOpcionesApartir=[['1','Mismo d\xEDa'],['2','D\xEDa Siguiente']];	
                                
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            id:'tabTermino',
                                                            region:'center',
                                                            activeTab:0,
                                                            cls:'tabPanelSIUGJ',
                                                            items:	[
                                                            			{	
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Datos Generales',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Proceso:'
                                                                                        },
                                                                                        {
                                                                                            x:150,
                                                                                            y:10,
                                                                                            cls:'SIUGJ_ControlEtiqueta',
                                                                                            html:nodoDestino.attributes.lblTipoProceso
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:45,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Etapa:'
                                                                                        },
                                                                                        {
                                                                                            x:150,
                                                                                            y:45,
                                                                                            cls:'SIUGJ_ControlEtiqueta',
                                                                                            html:nodoDestino.attributes.etapa
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:80,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Nombre del temporizador:'
                                                                                        },
                                                                                        {
                                                                                            x:240,
                                                                                            y:80,
                                                                                            cls:'SIUGJ_ControlEtiqueta',
                                                                                            html:'['+filaOrigen.data.cveTemporizador+'] '+filaOrigen.data.tituloTemporizador
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:115,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Funci&oacute;n renderer:'
                                                                                        },
                                                                                        {
                                                                                          xtype:'textfield',
                                                                                          width:500,
                                                                                          x:220,
                                                                                          y:110,
                                                                                          value:'',
                                                                                          cls:'controlSIUGJ',
                                                                                          id:'txtFuncionAplicacion',
                                                                                          readOnly:true
                                                                                      },
                                                                                      {
                                                                                          xtype:'label',
                                                                                          x:740,
                                                                                          y:112,
                                                                                          id:'lblBtnFunciones',
                                                                                          html:'<a href="javascript:agregarFuncionAplicacion(1)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(1)"><img src="../images/cross.png"></a>'
                                                                                      },
                                                                                      
                                                                                      {
                                                                                            x:10,
                                                                                            y:150,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Funci&oacute;n de aplicaci&oacute;n:'
                                                                                        },
                                                                                        {
                                                                                          xtype:'textfield',
                                                                                          width:500,
                                                                                          x:220,
                                                                                          y:145,
                                                                                          value:'',
                                                                                          cls:'controlSIUGJ',
                                                                                          id:'txtFuncionAplicacion2',
                                                                                          readOnly:true
                                                                                      },
                                                                                      {
                                                                                          xtype:'label',
                                                                                          x:740,
                                                                                          y:145,
                                                                                          id:'lblBtnFunciones2',
                                                                                          html:'<a href="javascript:agregarFuncionAplicacion(4)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(4)"><img src="../images/cross.png"></a>'
                                                                                      },
                                                                                      
                                                                                      {
                                                                                            x:10,
                                                                                            y:185,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Funci&oacute;n de detalle:'
                                                                                        },
                                                                                        {
                                                                                          xtype:'textfield',
                                                                                          width:500,
                                                                                          x:220,
                                                                                          y:180,
                                                                                          value:'',
                                                                                          cls:'controlSIUGJ',
                                                                                          id:'txtFuncionAplicacion7',
                                                                                          readOnly:true
                                                                                      },
                                                                                      {
                                                                                          xtype:'label',
                                                                                          x:740,
                                                                                          y:182,
                                                                                          id:'lblBtnFunciones7',
                                                                                          html:'<a href="javascript:agregarFuncionAplicacion(7)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(7)"><img src="../images/cross.png"></a>'
                                                                                      },
                                                                                      
                                                                                      
                                                                                       {
                                                                                            x:10,
                                                                                            y:220,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Tipo de intervalo de tiempo:'
                                                                                        },
                                                                                      	{
                                                                                            x:280,
                                                                                            y:215,
                                                                                            html:'<div id="divComboIntervaloTiempo"></div>'
                                                                                        },
                                                                                      
                                                                                        {
                                                                                            x:10,
                                                                                            y:270,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Periodo del temporizador:'
                                                                                        },
                                                                                        {
                                                                                            x:280,
                                                                                            y:265,
                                                                                            cls:'controlSIUGJ',
                                                                                            xtype:'numberfield',
                                                                                            allowDecimals:false,
                                                                                            allowNegative:false,
                                                                                            width:80,
                                                                                            id:'txtPeriodoTermino'
                                                                                        },
                                                                                        {
                                                                                          xtype:'textfield',
                                                                                          width:350,
                                                                                          x:280,
                                                                                          y:265,
                                                                                          value:'',
                                                                                          hidden:true,
                                                                                          cls:'controlSIUGJ',
                                                                                          id:'txtFuncionPeriodoTermino',
                                                                                          readOnly:true
                                                                                      },
                                                                                      {
                                                                                          xtype:'label',
                                                                                          x:650,
                                                                                          y:267,
                                                                                          hidden:true,
                                                                                          id:'lblBtnFunciones3',
                                                                                          html:'<a href="javascript:agregarFuncionAplicacion(5)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(5)"><img src="../images/cross.png"></a>'
                                                                                      },
                                                                                        {
                                                                                            x:370,
                                                                                            y:265,
                                                                                            html:'<div id="divComboPeriodoTermino"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:650,
                                                                                            y:270,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            id:'lblAPartir',
                                                                                            html:'A partir de:'
                                                                                        },
                                                                                        {
                                                                                            x:770,
                                                                                            y:265,
                                                                                            html:'<div id="divComboApartir"></div>'
                                                                                        },
                                                                                        
                                                                                      {
                                                                                            x:10,
                                                                                            y:320,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            id:'lblHoraLimiteTermino',
                                                                                            html:'Hora l&iacute;mite del temporizador:'
                                                                                       },
                                                                                       {
                                                                                            x:280,
                                                                                            y:315,
                                                                                            html:'<div id="divComboHoraLimite"></div>'
                                                                                        },
                                                                                       
                                                                                      {
                                                                                            x:10,
                                                                                            y:370,
																							cls:'SIUGJ_Etiqueta',
                                                                                            html:'Usuario asignado:'
                                                                                       },
                                                                                       {
                                                                                          xtype:'textfield',
                                                                                          width:300,
                                                                                          x:280,
                                                                                          y:365,
                                                                                          value:'',
                                                                                          id:'txtFuncionAplicacion8',
                                                                                          cls:'controlSIUGJ',
                                                                                          readOnly:true
                                                                                      },
                                                                                      {
                                                                                          xtype:'label',
                                                                                          x:600,
                                                                                          y:367,
                                                                                          id:'lblBtnFunciones8',
                                                                                          html:'<a href="javascript:agregarFuncionAplicacion(8)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(8)"><img src="../images/cross.png"></a>'
                                                                                      }
                                                                                        
                                                                            		]
                                                                        },
                                                                        {	
                                                                            xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Arranque temporizador',
                                                                            items:	[
                                                                            			{
                                                                                        	x:10,
                                                                                            y:20,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                        	html:'Funci\xF3n a Ejecutar:',
                                                                                            
                                                                                        },
                                                                                        {
                                                                                          xtype:'textfield',
                                                                                          width:350,
                                                                                          x:220,
                                                                                          y:15,
                                                                                          value:'',
                                                                                          cls:'controlSIUGJ',
                                                                                          id:'txtFuncionEjecucionCumplimientoTermino',
                                                                                          readOnly:true
                                                                                      },
                                                                                      {
                                                                                          xtype:'label',
                                                                                          x:590,
                                                                                          y:17,
                                                                                          id:'lblBtnFunciones10',
                                                                                          html:'<a href="javascript:agregarFuncionAplicacion(2)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(2)"><img src="../images/cross.png"></a>'
                                                                                      },
                                                                                      {
                                                                                        x:10,
                                                                                        y:55,
                                                                                        cls:'SIUGJ_Etiqueta',
                                                                                        html:'Funci\xF3n a Condicional de Arranque:',
                                                                                        
                                                                                    },
                                                                                    {
                                                                                          xtype:'textfield',
                                                                                          width:350,
                                                                                          x:320,
                                                                                          y:50,
                                                                                          value:'',
                                                                                          cls:'controlSIUGJ',
                                                                                          id:'txtFuncionCondicionalEjecucionCumplimientoTermino',
                                                                                          readOnly:true
                                                                                      },
                                                                                      {
                                                                                          xtype:'label',
                                                                                          x:690,
                                                                                          y:52,
                                                                                          id:'lblBtnFunciones1101',
                                                                                          html:'<a href="javascript:agregarFuncionAplicacion(101)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(101)"><img src="../images/cross.png"></a>'
                                                                                      },
                                                                                      {
                                                                                        	x:10,
                                                                                            y:90,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                        	html:'Proceso a Arrancar:',
                                                                                            
                                                                                        },
                                                                                        {
                                                                                            x:220,
                                                                                            y:85,
                                                                                            html:'<div id="divComboProcesoArranque1" style="width:510px"></div>'
                                                                                        },
                                                                                        {
                                                                                        	x:10,
                                                                                            y:140,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                        	html:'Etapa de Arraque:',
                                                                                            
                                                                                        },
                                                                                        {
                                                                                            x:220,
                                                                                            y:135,
                                                                                            html:'<div id="divComboEtapaArranque1" style="width:510px"></div>'
                                                                                        },
                                                                                        crearGridCamposProcesoArranque('1',nodoDestino,(nodoEdita?nodoEdita.id.replace('e_',''):'-1'))
                                                                            		]
                                                                        },
                                                                        {	
                                                                            xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Vencimiento temporizador',
                                                                            items:	[
                                                                            			{
                                                                                        	x:10,
                                                                                            y:20,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                        	html:'Funci\xF3n a Ejecutar:',
                                                                                            
                                                                                        },
                                                                                        
                                                                                        {
                                                                                              xtype:'textfield',
                                                                                              width:350,
                                                                                              x:220,
                                                                                              y:15,
                                                                                              value:'',
                                                                                               cls:'controlSIUGJ',
                                                                                              id:'txtFuncionEjecucionVencimientoTermino',
                                                                                              readOnly:true
                                                                                          },
                                                                                          {
                                                                                              xtype:'label',
                                                                                              x:590,
                                                                                              y:17,
                                                                                              id:'lblBtnFunciones11',
                                                                                              html:'<a href="javascript:agregarFuncionAplicacion(3)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(3)"><img src="../images/cross.png"></a>'
                                                                                          },
                                                                                          {
                                                                                        	x:10,
                                                                                            y:55,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                        	html:'Funci\xF3n a Condicional de Arranque:',
                                                                                            
                                                                                        },
                                                                                        {
                                                                                              xtype:'textfield',
                                                                                              width:350,
                                                                                              x:320,
                                                                                              y:50,
                                                                                              value:'',
                                                                                               cls:'controlSIUGJ',
                                                                                              id:'txtFuncionCondicionalEjecucionVencimientoTermino',
                                                                                              readOnly:true
                                                                                          },
                                                                                          {
                                                                                              xtype:'label',
                                                                                              x:690,
                                                                                              y:52,
                                                                                              id:'lblBtnFunciones1102',
                                                                                              html:'<a href="javascript:agregarFuncionAplicacion(102)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionAplicacion(102)"><img src="../images/cross.png"></a>'
                                                                                          },
                                                                                     	 {
                                                                                        	x:10,
                                                                                            y:90,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                        	html:'Proceso a Arrancar:',
                                                                                            
                                                                                        },
                                                                                         {
                                                                                            x:220,
                                                                                            y:85,
                                                                                            html:'<div id="divComboProcesoArranque2" style="width:510px"></div>'
                                                                                        },
                                                                                        {
                                                                                        	x:10,
                                                                                            y:140,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                        	html:'Etapa de Arraque:',
                                                                                            
                                                                                        },
                                                                                        {
                                                                                            x:220,
                                                                                            y:135,
                                                                                            html:'<div id="divComboEtapaArranque2" style="width:510px"></div>'
                                                                                        },
                                                                                        crearGridCamposProcesoArranque('2',nodoDestino,(nodoEdita?nodoEdita.id.replace('e_',''):'-1'))
                                                                            		]
                                                                        }
                                                            		]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Temporizador',
										width: 990,
										height:580,
                                        cls:'msgHistorialSIUGJ',
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
                                                                	
                                                                    gEx('tabTermino').setActiveTab(1);
                                                                    gEx('tabTermino').setActiveTab(2);
                                                                    gEx('tabTermino').setActiveTab(0);    
                                                                	var cmbTipoIntervaloTiempo=crearComboExt('cmbTipoIntervaloTiempo',[['1','Valor Manual'],['2','Mediante Funci\xF3n de Sistema']],0,0,350,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboIntervaloTiempo'}); 
                                                                    cmbTipoIntervaloTiempo.setValue('1');                           
                                                                    cmbTipoIntervaloTiempo.on('select',function(cmb,registro)
                                                                                                        {
                                                                                                            switch(registro.data.id)
                                                                                                            {
                                                                                                                case '1':
                                                                                                                    gEx('txtPeriodoTermino').show();

                                                                                                                    gEx('lblAPartir').show();

                                                                                                                    gEx('txtFuncionPeriodoTermino').hide();
                                                                                                                    gEx('lblBtnFunciones3').hide();
                                                                                                                    gEx('txtFuncionPeriodoTermino').setValue('');
                                                                                                                    gEx('txtFuncionPeriodoTermino').idConsulta='-1';
                                                                                                                    gEx('lblHoraLimiteTermino').show();
                                                                                                                    
                                                                                                                    
                                                                                                                    
                                                                                                                    mE('divComboApartir');
                                                                                                                    mE('divComboPeriodoTermino');
                                                                                                                    mE('divComboHoraLimite');
                                                                                                                    
                                                                                                                break;
                                                                                                                case '2':
                                                                                                                    gEx('txtPeriodoTermino').setValue('');
                                                                                                                    
                                                                                                                    gEx('cmbAPartir').setValue('');
                                                                                                                    gEx('txtFuncionPeriodoTermino').show();
                                                                                                                    gEx('lblBtnFunciones3').show();
                                                                                                                    gEx('lblHoraLimiteTermino').hide();
                                                                                                                    gEx('cmbHoraLimite').setValue('');
                                                                                                                    gEx('txtPeriodoTermino').hide();
                                                                                                                    gEx('lblAPartir').hide();
                                                                                                                    
                                                                                                                    oE('divComboApartir');
                                                                                                                    oE('divComboPeriodoTermino');
                                                                                                                    oE('divComboHoraLimite');
                                                                                                                    
                                                                                                                
                                                                                                                break;
                                                                                                            }
                                                                                                        }
                                                                                            )
																	
                                                                    var cmbPeriodoTermino=crearComboExt('cmbPeriodoTermino',arrPeriodoTermino,0,0,220 ,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboPeriodoTermino'});
    																
                                                                    var cmbAPartir=crearComboExt('cmbAPartir',arrOpcionesApartir,0,0,180,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboApartir'});
                                                                	var cmbHoraLimite=crearCampoHoraExt('cmbHoraLimite','07:00','20:00',15,false,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboHoraLimite'});
                                                                    cmbHoraLimite.setWidth(180);  
                                                                    
                                                                     var cmbProcesoArranque1=crearComboExt('cmbProcesoArranque_1',arrProcesoArranque,0,0,500,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboProcesoArranque1'});
                                                                    cmbProcesoArranque1.setValue('0');
                                                                    cmbProcesoArranque1.on('select',function(cmb,registro)
                                                                                                    {
                                                                                                        if(registro.data.id=='0')
                                                                                                        {
                                                                                                            gEx('cmbEtapaArranque1').setValue('');
                                                                                                            gEx('cmbEtapaArranque1').disable();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            gEx('cmbEtapaArranque1').setValue('');
                                                                                                            gEx('cmbEtapaArranque1').getStore().loadData(registro.data.valorComp);
                                                                                                            gEx('cmbEtapaArranque1').enable();
                                                                                                        }
                                                                                                        gEx('gCamposTablero_1').getStore().reload();
                                                                                                    }
                                                                                            )
                                                                    
                                                                    
                                                                    var cmbEtapaArranque1=   crearComboExt('cmbEtapaArranque1',[],0,0,500,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboEtapaArranque1'}); 
																	cmbEtapaArranque1.disable();
                                                                    
                                                                    
                                                                    var cmbProcesoArranque2=crearComboExt('cmbProcesoArranque_2',arrProcesoArranque,0,0,500,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboProcesoArranque2'});
                                                                    cmbProcesoArranque2.setValue('0');
                                                                    cmbProcesoArranque2.on('select',function(cmb,registro)
                                                                                                    {
                                                                                                        if(registro.data.id=='0')
                                                                                                        {
                                                                                                            gEx('cmbEtapaArranque2').setValue('');
                                                                                                            gEx('cmbEtapaArranque2').disable();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            gEx('cmbEtapaArranque2').setValue('');
                                                                                                            gEx('cmbEtapaArranque2').getStore().loadData(registro.data.valorComp);
                                                                                                            gEx('cmbEtapaArranque2').enable();
                                                                                                        }
                                                                                                        gEx('gCamposTablero_2').getStore().reload();
                                                                                                    }
                                                                                            )
                                                                    
                                                                                     
                                                                                            
                                                                                                                         
                                                                                            
                                                                                              
                                                                
                                                                
                                                                    
                                                                    var cmbEtapaArranque2=   crearComboExt('cmbEtapaArranque2',[],0,0,500,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboEtapaArranque2'}); 
                                                                    cmbEtapaArranque2.disable();      
                                                                    
                                                                    if(nodoEdita)
                                                                    {
                                                                        gEx('txtFuncionAplicacion').idConsulta=nodoEdita.attributes.funcionRenderer;
                                                                        gEx('txtFuncionAplicacion2').idConsulta=nodoEdita.attributes.idFuncionAplicacion;
                                                                        gEx('txtFuncionAplicacion').setValue(nodoEdita.attributes.lblFuncionRenderer);
                                                                        gEx('txtFuncionAplicacion2').setValue(nodoEdita.attributes.lblMetodoAplicacion);
                                                                        
                                                                        gEx('txtFuncionAplicacion7').setValue(nodoEdita.attributes.lblMetodoDetalle);
                                                                        gEx('txtFuncionAplicacion7').idConsulta=nodoEdita.attributes.idFuncionDetalle;
                                                                        
                                                                        var objConfiguracion=eval('['+bD(nodoEdita.attributes.objConfiguracion)+']')[0];
                                                                        
                                                                        cmbTipoIntervaloTiempo.setValue(objConfiguracion.datosGenerales.tipoIntervaloTiempo);
                                                                        dispararEventoSelectCombo('cmbTipoIntervaloTiempo');
                                                                        gEx('txtPeriodoTermino').setValue(objConfiguracion.datosGenerales.cvePeriodoTiempo);
                                                                        gEx('cmbPeriodoTermino').setValue(objConfiguracion.datosGenerales.periodoTiempo);
                                                                        gEx('txtFuncionPeriodoTermino').idConsulta=objConfiguracion.datosGenerales.txtFuncionPeriodoTermino;
                                                                        var objConfiguracionComplementaria=eval('['+bD(nodoEdita.attributes.objConfiguracionComplementaria)+']')[0];
                                                                        gEx('txtFuncionPeriodoTermino').setValue(objConfiguracionComplementaria.lblFuncionPeriodoTermino);
                                                                        gEx('txtFuncionEjecucionCumplimientoTermino').idConsulta=objConfiguracion.cumplimientoTermino.funcionEjecucion;
                                                                        gEx('txtFuncionEjecucionCumplimientoTermino').setValue(objConfiguracionComplementaria.lblFuncionCumplimiento);
                                                                        
                                                                        gEx('txtFuncionEjecucionVencimientoTermino').idConsulta=objConfiguracion.vencimientoTermino.funcionEjecucion;
                                                                        gEx('txtFuncionEjecucionVencimientoTermino').setValue(objConfiguracionComplementaria.lblFuncionVencimiento);
                                                                        
                                                                        
                                                                        if(objConfiguracion.cumplimientoTermino.procesoArranque!='-1')
                                                                        {
                                                                            cmbProcesoArranque1.setValue(objConfiguracion.cumplimientoTermino.procesoArranque);
                                                                            dispararEventoSelectCombo('cmbProcesoArranque_1');
                                                                        }
                                                                        
                                                                         if(objConfiguracion.vencimientoTermino.procesoArranque!='-1')
                                                                        {
                                                                            cmbProcesoArranque2.setValue(objConfiguracion.vencimientoTermino.procesoArranque);
                                                                            dispararEventoSelectCombo('cmbProcesoArranque_2');
                                                                        }
                                                                        
                                                                        cmbEtapaArranque1.setValue(objConfiguracion.cumplimientoTermino.etapaArranque);
                                                                        cmbEtapaArranque2.setValue(objConfiguracion.vencimientoTermino.etapaArranque);
                                                                
                                                                        gEx('txtFuncionAplicacion8').idConsulta=nodoEdita.attributes.idFuncionUsuarioAsignado;
                                                                        gEx('txtFuncionAplicacion8').setValue(nodoEdita.attributes.lblMetodoUsuarioAsignado);
                                                                        cmbAPartir.setValue(objConfiguracion.datosGenerales.aPartirDe?objConfiguracion.datosGenerales.aPartirDe:'');
                                                                        cmbHoraLimite.setValue(objConfiguracion.datosGenerales.horaLimite?objConfiguracion.datosGenerales.horaLimite:'');
                                                                    }
                                                                    
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
                                                                    	
                                                                        var txtPeriodoTermino=gEx('txtPeriodoTermino');
                                                                        var txtFuncionPeriodoTermino=gEx('txtFuncionPeriodoTermino');
                                                                        var cmbTipoIntervaloTiempo=gEx('cmbTipoIntervaloTiempo');
                                                                        var cmbPeriodoTermino=gEx('cmbPeriodoTermino');
                                                                        var cmbAPartir=gEx('cmbAPartir');
                                                                        var cmbHoraLimite=gEx('cmbHoraLimite');
                                                                        
                                                                       
                                                                        
                                                                        if(cmbTipoIntervaloTiempo.getValue()=='1')
                                                                        {
                                                                        	if((txtPeriodoTermino.getValue()=='')&&(txtPeriodoTermino.getValue()!='0'))
                                                                            {
                                                                            	function respAux2()
                                                                                {
                                                                                	gEx('tabTermino').setActiveTab(0);
                                                                                	txtPeriodoTermino.focus();
                                                                                }
                                                                               	msgBox('Debe indicar el periodo que tendr&aacute; el temporizador a agregar',respAux2);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(cmbPeriodoTermino.getValue()=='')
                                                                            {
                                                                            	function respAux3()
                                                                                {
                                                                                	gEx('tabTermino').setActiveTab(0);
                                                                                	cmbPeriodoTermino.focus();
                                                                                }
                                                                               	msgBox('Debe indicar el periodo de tiempo que tendr&aacute; el temporizador a agregar',respAux3);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(cmbAPartir.getValue()=='')
                                                                            {
                                                                            	function respAux2()
                                                                                {
                                                                                	gEx('tabTermino').setActiveTab(0);
                                                                                	cmbAPartir.focus();
                                                                                }
                                                                               	msgBox('Debe indicar a partir de cuando, se calcular&aacute; el periodo del temporizador a agregar',respAux2);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(cmbHoraLimite.getValue()=='')
                                                                            {
                                                                            	function respAux2()
                                                                                {
                                                                                	gEx('tabTermino').setActiveTab(0);
                                                                                	cmbHoraLimite.focus();
                                                                                }
                                                                               	msgBox('Debe indicar el horario a partir del cual ser&aacute; considerado al temporizador como vencido',respAux2);
                                                                                return;
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                        	if(!txtFuncionPeriodoTermino.idConsulta || txtFuncionPeriodoTermino.idConsulta=='-1')
                                                                            {
                                                                            	function respAux()
                                                                                {
                                                                                	gEx('tabTermino').setActiveTab(0);
                                                                                }
                                                                               	msgBox('Debe indicar la funci&oacute;n que define el periodo del temporizador',respAux);
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        
                                                                        var gCamposTablero=gEx('gCamposTablero_1');
                                                                        var x;
																		var fila;
                                                                        var aRegistros='';
                                                                        for(x=0;x<gCamposTablero.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gCamposTablero.getStore().getAt(x);
                                                                            
                                                                            if(fila.data.tipoLlenado=='')
                                                                            {
                                                                            	function resp()
                                                                                {
                                                                                	gEx('tabTermino').setActiveTab(1);
                                                                                	gCamposTablero.startEditing(x,3);
                                                                                }
                                                                                msgBox('Debe indicar el tipo de llenado del campo',resp)
                                                                            	return;
                                                                            }
                                                                            
                                                                            if((fila.data.tipoLlenado!='0')&&(fila.data.valor==''))
                                                                            {
                                                                            	function resp2()
                                                                                {
                                                                                	if(fila.data.tipoLlenado!='7')
                                                                                    {
                                                                                    	gEx('tabTermino').setActiveTab(1);
	                                                                                	gCamposTablero.startEditing(x,3);
                                                                                	}
                                                                                }
                                                                                msgBox('Debe indicar el valor a asignar al campo destino',resp2)
                                                                            	return;
                                                                            }
                                                                            
                                                                            obj='{"campoDestino":"'+fila.data.nombreCampo+'","tipoLlenado":"'+fila.data.tipoLlenado+'","valor":"'+cv(fila.data.valor,false,true)+'"}';
                                                                            
                                                                            if(aRegistros=='')
                                                                            {
                                                                            	aRegistros=obj;
                                                                            }
                                                                            else
                                                                            {
                                                                            	aRegistros+=','+obj;
                                                                            }
                                                                        }
                                                                        
                                                                        var arrRegistrosCumplimientoTermino='['+aRegistros+']';
                                                                        aRegistros='';
                                                                        var gCamposTablero=gEx('gCamposTablero_2');
                                                                        for(x=0;x<gCamposTablero.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gCamposTablero.getStore().getAt(x);
                                                                            
                                                                            if(fila.data.tipoLlenado=='')
                                                                            {
                                                                            	function resp()
                                                                                {
                                                                                	gEx('tabTermino').setActiveTab(2);
                                                                                	gCamposTablero.startEditing(x,3);
                                                                                }
                                                                                msgBox('Debe indicar el tipo de llenado del campo',resp)
                                                                            	return;
                                                                            }
                                                                            
                                                                            if((fila.data.tipoLlenado!='0')&&(fila.data.valor==''))
                                                                            {
                                                                            	function resp2()
                                                                                {
                                                                                	if(fila.data.tipoLlenado!='7')
                                                                                    {
                                                                                    	gEx('tabTermino').setActiveTab(2);
	                                                                                	gCamposTablero.startEditing(x,3);
                                                                                	}
                                                                                }
                                                                                msgBox('Debe indicar el valor a asignar al campo destino',resp2)
                                                                            	return;
                                                                            }
                                                                            
                                                                            obj='{"campoDestino":"'+fila.data.nombreCampo+'","tipoLlenado":"'+fila.data.tipoLlenado+'","valor":"'+cv(fila.data.valor,false,true)+'"}';
                                                                            
                                                                            if(aRegistros=='')
                                                                            {
                                                                            	aRegistros=obj;
                                                                            }
                                                                            else
                                                                            {
                                                                            	aRegistros+=','+obj;
                                                                            }
                                                                        }
                                                                        
                                                                        var arrRegistrosVencimientoTermino='['+aRegistros+']';
                                                                        
                                                                        var txtFuncionEjecucionCumplimientoTermino=gEx('txtFuncionEjecucionCumplimientoTermino');
                                                                        var txtFuncionEjecucionVencimientoTermino=gEx('txtFuncionEjecucionVencimientoTermino');
                                                                        
                                                                        var cmbProcesoArranque1=gEx('cmbProcesoArranque_1');
                                                                        var cmbProcesoArranque2=gEx('cmbProcesoArranque_2');

                                                                        var cmbEtapaArranque1=gEx('cmbEtapaArranque1');
                                                                        var cmbEtapaArranque2=gEx('cmbEtapaArranque2');
                                                                        
                                                                        
                                                                        if(cmbProcesoArranque1.getValue()=='')
                                                                        	cmbProcesoArranque1.setValue('0');
                                                                        
                                                                        if(cmbProcesoArranque2.getValue()=='')
                                                                        	cmbProcesoArranque2.setValue('0');
                                                                        
                                                                        
                                                                        var txtFuncionAplicacion=gEx('txtFuncionAplicacion');
                                                                        var txtFuncionAplicacion2=gEx('txtFuncionAplicacion2');
                                                                        var txtPeriodoTermino=gEx('txtPeriodoTermino');
                                                                        var txtFuncionPeriodoTermino=gEx('txtFuncionPeriodoTermino');
                                                                        var txtFuncionAplicacion8=gEx('txtFuncionAplicacion8');
                                                                        
                                                                        var txtFuncionAplicacion7=gEx('txtFuncionAplicacion7');
                                                                    	if(!txtFuncionAplicacion7.idConsulta || txtFuncionAplicacion7.idConsulta=='')
                                                                        	txtFuncionAplicacion7.idConsulta='-1';
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        var objAccion='{"datosGenerales":{"tipoIntervaloTiempo":"'+cmbTipoIntervaloTiempo.getValue()+'","cvePeriodoTiempo":"'+txtPeriodoTermino.getValue()+'","periodoTiempo":"'+cmbPeriodoTermino.getValue()+
																						'","txtFuncionPeriodoTermino":"'+(txtFuncionPeriodoTermino.idConsulta?txtFuncionPeriodoTermino.idConsulta:-1)+'","aPartirDe":"'+gEx('cmbAPartir').getValue()+
                                                                                        '","horaLimite":"'+cmbHoraLimite.getValue()+'"},'+
                                                                        			'"cumplimientoTermino":{"funcionEjecucion":"'+(txtFuncionEjecucionCumplimientoTermino.idConsulta?txtFuncionEjecucionCumplimientoTermino.idConsulta:-1)+
                                                                        			'","procesoArranque":"'+cmbProcesoArranque1.getValue()+'","etapaArranque":"'+cmbEtapaArranque1.getValue()+'","valoresArranque":'+arrRegistrosCumplimientoTermino+
                                                                        			'},"vencimientoTermino":{"funcionEjecucion":"'+(txtFuncionEjecucionVencimientoTermino.idConsulta?txtFuncionEjecucionVencimientoTermino.idConsulta:-1)+
                                                                                    '","procesoArranque":"'+cmbProcesoArranque2.getValue()+'","etapaArranque":"'+cmbEtapaArranque2.getValue()+'","valoresArranque":'+arrRegistrosVencimientoTermino+'}}';
                                                                        
                                                                        var cadObj='{"idTerminoProcesal":"'+filaOrigen.data.idRegistro+'","idPadre":"'+nodoDestino.id.replace('p_','')+
                                                                        		'","idRegistro":"'+(nodoEdita?nodoEdita.id.replace('e_',''):'-1')+'","funcionRenderer":"'+(txtFuncionAplicacion.idConsulta?txtFuncionAplicacion.idConsulta:-1)+
                                                                                '","functionAplicacion":"'+(txtFuncionAplicacion2.idConsulta?txtFuncionAplicacion2.idConsulta:-1)+
                                                                                '","objConfiguracionAccion":"'+bE(objAccion)+'","tipoElemento":"5","funcionDetalle":"'+txtFuncionAplicacion7.idConsulta+
                                                                                '","funcionAsignacionUsuario":"'+(txtFuncionAplicacion8.idConsulta?txtFuncionAplicacion8.idConsulta:-1)+'"}';
                                                                        
                                                                        
                                                                       
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('tMacroProceso').getRootNode().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=25&cadObj='+cadObj,true);

                                                                        
                                                                    }
														}
													]
									}
								);
	ventanaAM.show();	
	
    
}



function mostrarVentanaNotificacionesProceso(nodoDestino,filaOrigen,nodoEdita)
{
	
	var gNotificaciones=gEx('gNotificaciones');
	var arrTipoNotificaciones=[];
    var x;
    var fila;
    for(x=0;x<gNotificaciones.getStore().getCount();x++)
    {
    	fila=gNotificaciones.getStore().getAt(x);
        
    	arrTipoNotificaciones.push([fila.data.idRegistro,'['+fila.data.cveNotificacion+'] '+fila.data.tituloNotificacion]);
    }
	var cmbTipoNotificacion=crearComboExt('cmbTipoNotificacion',arrTipoNotificaciones,180,5,300);
    var cmbAccesoProceso=crearComboExt('cmbAccesoProceso',arrSiNo,180,125,120);
    
   
    
    cmbAccesoProceso.setValue('0');
    
    cmbAccesoProceso.on('select',function(cmb,registro)
    							{
                                	if(registro.data.id=='1')
                                    	gEx('cmbRolesParticipantesProcesos').enable();
                                    else
                                    	gEx('cmbRolesParticipantesProcesos').disable();
                                }
    					)
    
    var cmbNotificacionActiva=crearComboExt('cmbNotificacionActiva',arrSiNo,180,185,120);
    cmbNotificacionActiva.setValue('1');
    
    var cmbExtensiones=crearComboExt('cmbExtensiones',[],440,65,220);
	cmbExtensiones.disable();
	var cmbRolesNotificacion=crearComboExt('cmbRolesNotificacion',arrRolesSistema,180,65,250);
    
    cmbRolesNotificacion.on('select',function(cmb,registro)	
    								{
                                    	cmbExtensiones.setValue('');
                                        var idRegistro=registro.get('id');
                                        var arrId=idRegistro.split('_');
                                        if(arrId[1]!=0)
                                        {
                                            function funcAjax()
                                            {
                                                var resp=peticion_http.responseText;
                                                arrResp=resp.split('|');
                                                if(arrResp[0]=='1')
                                                {
                                                    var arrExtensiones=eval(arrResp[1]);
                                                    cmbExtensiones.getStore().loadData(arrExtensiones);                
                                                    cmbExtensiones.enable();
                                                    
                                                }
                                                else
                                                {
                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                }
                                            }
                                            obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=20&extension='+arrId[1],true);
                                        }
                                        else
                                        {
                                            cmbExtensiones.disable();
                                           
                                        }
                                    }
    						);

	var cmbRolesParticipantesProcesos=  crearComboExt('cmbRolesParticipantesProcesos',arrRolesSistema,180,155,250);                          
    //cmbRolesParticipantesProcesos.setValue('0');     
    
    var cmbAtendidaCambioEtapa=crearComboExt('cmbAtendidaCambioEtapa',arrSiNo,255,215	,140);  
    cmbAtendidaCambioEtapa.setValue('0');
    cmbAtendidaCambioEtapa.disable();
    cmbAtendidaCambioEtapa.on('select',function(cmb,registro)
    									{
                                        	if(registro.data.id=='1')
                                            {
                                            	gEx('idPanelConf').unhideTabStripItem(1 );
                                            }
                                            else
                                            {
                                            	gEx('idPanelConf').hideTabStripItem(1 );
                                            }
                                        }
    							)
    
    var cmbUsuarioMarcaAtendida=   crearComboExt('cmbUsuarioMarcaAtendida',arrUsuarioMarcaAtendida,275,35,250);  
    cmbUsuarioMarcaAtendida.setValue('2');  
    
    var cmbMarcarNotificacionesDelegadas=  crearComboExt('cmbMarcarNotificacionesDelegadas',arrSiNo,330,65,140);
    cmbMarcarNotificacionesDelegadas.setValue('1');
    var cmbMarcarNotificacionesOrigen=  crearComboExt('cmbMarcarNotificacionesOrigen',arrSiNo,390,95,140); 
    cmbMarcarNotificacionesOrigen.setValue('1');    
    var cmbProcesoArranque1=crearComboExt('cmbProcesoArranque_1',arrProcesos,150,10,500);
 
    cmbProcesoArranque1.on('select',function(cmb,registro)
    								{
                                    	gEx('cmbEtapaArranque').getStore().loadData(registro.data.valorComp);
                                    	gEx('gCamposTablero_1').getStore().reload();
                                    }
    						)     
                            
	var cmbEtapaArranque=   crearComboExt('cmbEtapaArranque',[],150,40,300);                         
                            
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            activeTab:1,
                                                            id:'idPanelConf',
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            height: 330,
                                                                            defaultType: 'label',
                                                                            title:'Configuraci&oacute;n Inicial',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            html:'Tipo de notificaci&oacute;n: <span style="color:#F00">*</span>'
                                                                                        },
                                                                                        cmbTipoNotificacion,
                                                                                        {
                                                                                            x:10,
                                                                                            y:40,
                                                                                            html:'Funci&oacute;n de aplicaci&oacute;n:'
                                                                                        },
                                                                                        {
                                                                                            xtype:'textfield',
                                                                                            width:350,
                                                                                            x:180,
                                                                                            y:35,
                                                                                            id:'txtFuncionAplicacion',
                                                                                            readOnly:true
                                                                                        },
                                                                                        {
                                                                                            xtype:'label',
                                                                                            x:550,
                                                                                            y:37,
                                                                                            html:'<a href="javascript:agregarFuncionControl(1)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionControl(1)"><img src="../images/cross.png"></a>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:70,
                                                                                            html:'Actor destinatario:'
                                                                                        },
                                                                                        cmbRolesNotificacion,
                                                                                        cmbExtensiones,
                                                                                        {
                                                                                            x:10,
                                                                                            y:100,
                                                                                            html:'Funci&oacute;n de asignaci&oacute;n de destinatario:'
                                                                                        },
                                                                                        {
                                                                                            xtype:'textfield',
                                                                                            width:350,
                                                                                            x:240,
                                                                                            y:95,
                                                                                            id:'txtFuncionAsignacionDestinatario',
                                                                                            readOnly:true
                                                                                        },
                                                                                        {
                                                                                            xtype:'label',
                                                                                            x:610,
                                                                                            y:97,
                                                                                            html:'<a href="javascript:agregarFuncionControl(2)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionControl(2)"><img src="../images/cross.png"></a>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:130,
                                
                                                                                            html:'Permitir acceso al proceso: <span style="color:#F00">*</span>'
                                                                                        },
                                                                                        cmbAccesoProceso,
                                                                                        {
                                                                                            x:10,
                                                                                            y:160,
                                                                                            html:'Actor de acceso al proceso:'
                                                                                        },
                                                                                        cmbRolesParticipantesProcesos,
                                                                                        {
                                                                                            x:10,
                                                                                            y:190,
                                                                                            html:'Notificaci&oacute;n activa: <span style="color:#F00">*</span>'
                                                                                        },
                                                                                        cmbNotificacionActiva,
                                                                                        {
                                                                                            x:10,
                                                                                            y:220,
                                                                                            html:'¿Marcar como atendia al cambiar de etapa?: <span style="color:#F00">*</span>'
                                                                                        },
                                                                                        cmbAtendidaCambioEtapa
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            height: 330,
                                                                            defaultType: 'label',
                                                                            title:'Configuraci&oacute;n cambio etapa',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            html:'Funci&oacute;n de aplicaci&oacute;n:'
                                                                                        },
                                                                                        {
                                                                                            xtype:'textfield',
                                                                                            width:350,
                                                                                            x:180,
                                                                                            y:5,
                                                                                            id:'txtFuncionAplicacionCambioEtapa',
                                                                                            readOnly:true
                                                                                        },
                                                                                        {
                                                                                            xtype:'label',
                                                                                            x:550,
                                                                                            y:7,
                                                                                            html:'<a href="javascript:agregarFuncionControl(3)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionControl(3)"><img src="../images/cross.png"></a>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:40,
                                                                                            html:'Marcar como atendida notificaciones del usuario:'
                                                                                        },
                                                                                        cmbUsuarioMarcaAtendida,
                                                                                        {
                                                                                            x:10,
                                                                                            y:70,
                                                                                            html:'Marcar como atendida tambi&eacute;n a notificaciones delegadas:'
                                                                                        },
                                                                                        cmbMarcarNotificacionesDelegadas,
                                                                                        {
                                                                                            x:10,
                                                                                            y:100,
                                                                                            html:'Si es notificaci&oacute;n delegada, marcar como atendida a la notificaci&oacute;n origen:'
                                                                                        },
                                                                                        cmbMarcarNotificacionesOrigen
                                                                                        
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            height: 330,
                                                                            defaultType: 'label',
                                                                            title:'Arranque de Proceso',
                                                                            items:	[
                                                                            			
                                                                                      {
                                                                                        	x:10,
                                                                                            y:15,
                                                                                        	html:'Proceso a Arrancar:',
                                                                                            
                                                                                        },
                                                                                        cmbProcesoArranque1,
                                                                                        {
                                                                                        	x:10,
                                                                                            y:45,
                                                                                        	html:'Etapa de Arraque:',
                                                                                            
                                                                                        },
                                                                                        cmbEtapaArranque,
                                                                                        crearGridCamposProcesoArranque('4',nodoDestino,(nodoEdita?nodoEdita.id.replace('e_',''):'-1'))
                                                                            
                                                                            		]
                                                                        }
                                                            		]
                                                            
                                                        }
														

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configurar notificaci&oacute;n',
										width: 900,
										height:440,
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
                                                                	gEx('gCamposTablero_1').setPosition(10,75);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var txtFuncionAplicacionCambioEtapa=gEx('txtFuncionAplicacionCambioEtapa');
                                                                    	var txtFuncionAplicacion=gEx('txtFuncionAplicacion');
                                                                    	var txtFuncionAsignacionDestinatario=gEx('txtFuncionAsignacionDestinatario');
																		if(cmbTipoNotificacion.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	gEx('idPanelConf').setActiveTab(0);
                                                                            	cmbTipoNotificacion.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de notificaci&oacute;n a ejecutar',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        actorDestinatario='';
                                                                        if(cmbRolesNotificacion.getValue()!='')
                                                                        {
                                                                        	actorDestinatario=cmbRolesNotificacion.getValue();
                                                                            
                                                                            var arrRol=actorDestinatario.split('_');
                                                                            var extension='0';
                                                                            if(arrRol[1]!='0')
                                                                            {
                                                                            	if(cmbExtensiones.getValue()!='')
                                                                                {
                                                                                	extension=cmbExtensiones.getValue();	
                                                                                }
                                                                            }
                                                                            
                                                                            actorDestinatario=arrRol[0]+'_'+extension;
                                                                            
                                                                            
                                                                            	
                                                                        }
                                                                        
                                                                        var actorAccesoProceso='';
                                                                        
                                                                        if(cmbAccesoProceso.getValue()=='1')
                                                                        {
                                                                        	actorAccesoProceso=cmbRolesParticipantesProcesos.getValue();
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        var confComplementaria='';
                                                                        if(cmbAtendidaCambioEtapa.getValue()=='1')
                                                                        {
                                                                        	confComplementaria='{"funcionAplicacion":"'+((txtFuncionAplicacionCambioEtapa.getValue()=='')?'-1':txtFuncionAplicacionCambioEtapa.idConsulta)+
                                                                            					'","afectarNotificionUsuario":"'+cmbUsuarioMarcaAtendida.getValue()+
                                                                                                '","afectarNotificacionesDelegadas":"'+cmbMarcarNotificacionesDelegadas.getValue()+
                                                                                                '","afectarNotificacionesPadre":"'+cmbMarcarNotificacionesOrigen.getValue()+'"}';
                                                                        }
                                                                        
                                                                        
                                                                         var objConfiguracionAccion='{"actorDestinatario":"'+actorDestinatario+'","funcionAsignacionDestinatario":"'+((txtFuncionAsignacionDestinatario.getValue()=='')?'-1':
                                                                        							txtFuncionAsignacionDestinatario.idConsulta)+
                                                                                                    '","permiteAccesoProceso":"'+cmbAccesoProceso.getValue()+'","actorAccesoProceso":"'+actorAccesoProceso+'","notificacionActiva":"'+
                                                                                                    cmbNotificacionActiva.getValue()+'","etapa":"0","idPerfil":"-1","confComplementaria":"'+
                                                                                                    (confComplementaria)+'","marcarAtendidaCambioEtapa":"'+cmbAtendidaCambioEtapa.getValue()+'"';
                                                                        
                                                                        
                                                                        var aRegistros='';
                                                                        
                                                                        if(cmbAccesoProceso.getValue()=='1')
                                                                        {
                                                                        	var gCamposTablero=gEx('gCamposTablero_4');
                                                                            var x;
                                                                            var fila;
                                                                            var aRegistros='';
                                                                            for(x=0;x<gCamposTablero.getStore().getCount();x++)
                                                                            {
                                                                                fila=gCamposTablero.getStore().getAt(x);
                                                                                
                                                                                if(fila.data.tipoLlenado=='')
                                                                                {
                                                                                    function resp()
                                                                                    {
                                                                                        gEx('tabTermino').setActiveTab(1);
                                                                                        gCamposTablero.startEditing(x,3);
                                                                                    }
                                                                                    msgBox('Debe indicar el tipo de llenado del campo',resp)
                                                                                    return;
                                                                                }
                                                                                
                                                                                if((fila.data.tipoLlenado!='0')&&(fila.data.valor==''))
                                                                                {
                                                                                    function resp2()
                                                                                    {
                                                                                        if(fila.data.tipoLlenado!='7')
                                                                                        {
                                                                                            gEx('tabTermino').setActiveTab(1);
                                                                                            gCamposTablero.startEditing(x,3);
                                                                                        }
                                                                                    }
                                                                                    msgBox('Debe indicar el valor a asignar al campo destino',resp2)
                                                                                    return;
                                                                                }
                                                                                
                                                                                obj='{"campoDestino":"'+fila.data.nombreCampo+'","tipoLlenado":"'+fila.data.tipoLlenado+'","valor":"'+cv(fila.data.valor,false,true)+'"}';
                                                                                
                                                                                if(aRegistros=='')
                                                                                {
                                                                                    aRegistros=obj;
                                                                                }
                                                                                else
                                                                                {
                                                                                    aRegistros+=','+obj;
                                                                                }
                                                                            }
                                                                            if(cmbProcesoArranque1.getValue()=='')
                                                                            {
                                                                                function resp1()
                                                                                {
                                                                                    gEx('idPanelConf').setActiveTab(2);
                                                                                    cmbProcesoArranque1.focus();
                                                                                }
                                                                                msgBox('Debe indicar el proceso que arrancar&aacute; al ingresar a la tarea',resp1);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(cmbEtapaArranque.getValue()=='')
                                                                            {
                                                                                function resp2()
                                                                                {
                                                                                    gEx('idPanelConf').setActiveTab(2);
                                                                                    cmbEtapaArranque.focus();
                                                                                }
                                                                                msgBox('Debe indicar la etapa en la cual arrancar&aacute; el proceso al ingresar a la tarea',resp2);
                                                                                return;
                                                                            }
                                                                            
                                                                            objConfiguracionAccion+=',"procesoArranque":"'+cmbProcesoArranque1.getValue()+'","etapaArranque":"'+cmbEtapaArranque.getValue()+'","valoresArranque":['+aRegistros+']';
                                                                        }
                                                                        
                                                                        objConfiguracionAccion+='}';
                                                                        
                                                                       
                                                                        
                                                                        
                                                                        var cadObj='{"idNotificacion":"'+cmbTipoNotificacion.getValue()+'","idPadre":"'+nodoDestino.id.replace('p_','')+
                                                                        		'","idRegistro":"'+(nodoEdita?nodoEdita.id.replace('e_',''):'-1')+'","funcionRenderer":"-1","funcionAplicacion":"'+((txtFuncionAplicacion.getValue()=='')?'':txtFuncionAplicacion.idConsulta)+
                                                                                '","objConfiguracionAccion":"'+bE(objConfiguracionAccion)+'","tipoElemento":"6","idMacroProceso":"'+gE('idRegistro').value+'"}';
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('tMacroProceso').getRootNode().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=29&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        
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
    gEx('idPanelConf').setActiveTab(0);
    dispararEventoSelectCombo('cmbAccesoProceso');
    dispararEventoSelectCombo('cmbAtendidaCambioEtapa');
    if(nodoEdita)
    {
    	var objConfiguracionComplementaria=eval('['+bD(nodoEdita.attributes.objConfiguracionComplementaria)+']')[0];
        var objConfiguracion=eval('['+bD(nodoEdita.attributes.objConfiguracion)+']')[0];
        
    	cmbTipoNotificacion.setValue(nodoEdita.attributes.idElemento);
        var txtFuncionAplicacion=gEx('txtFuncionAplicacion');
        txtFuncionAplicacion.setValue(nodoEdita.attributes.lblMetodoAplicacion);
        txtFuncionAplicacion.idConsulta=nodoEdita.attributes.idFuncionAplicacion;
        
        
        if(objConfiguracion.actorDestinatario!='')
        {
        
	       	var idRegistro=objConfiguracion.actorDestinatario;
            var arrId=idRegistro.split('_');
        	var rolSelecionado='';
        	var pos;
            var x;
            for(x=0;x<arrRolesSistema.length;x++)
            {
            	var aAux=arrRolesSistema[x][0].split('_');
                
                if(aAux[0]==arrId[0])
                {
                	rolSelecionado=arrRolesSistema[x][0];
                	break;
                }
                
            }
            
        
        	cmbRolesNotificacion.setValue(rolSelecionado);
            cmbExtensiones.setValue('');
            var arrIdRolSelecionado=rolSelecionado.split('_');
            if(arrIdRolSelecionado[1]!=0)
            {
                function funcAjax()
                {
                    var resp=peticion_http.responseText;
                    arrResp=resp.split('|');
                    if(arrResp[0]=='1')
                    {
                        var arrExtensiones=eval(arrResp[1]);
                        cmbExtensiones.getStore().loadData(arrExtensiones);                
                        cmbExtensiones.enable();
                        if(arrId[1]!='0')
	                        cmbExtensiones.setValue(arrId[1]);
                        
                    }
                    else
                    {
                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                    }
                }
                obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=20&extension='+arrIdRolSelecionado[1],true);
            }
            else
            {
                cmbExtensiones.disable();
            }
        }
        
        var txtFuncionAsignacionDestinatario=gEx('txtFuncionAsignacionDestinatario');
        txtFuncionAsignacionDestinatario.setValue(objConfiguracionComplementaria.lblFuncionAsignacionDestinatario);
        txtFuncionAsignacionDestinatario.idConsulta=objConfiguracion.funcionAsignacionDestinatario;
        
        cmbAccesoProceso.setValue(objConfiguracion.permiteAccesoProceso);
        dispararEventoSelectCombo('cmbAccesoProceso');
        cmbRolesParticipantesProcesos.setValue(objConfiguracion.actorAccesoProceso);
        
        cmbNotificacionActiva.setValue(objConfiguracion.notificacionActiva);
        cmbAtendidaCambioEtapa.setValue(objConfiguracion.marcarAtendidaCambioEtapa);
        dispararEventoSelectCombo('cmbAtendidaCambioEtapa');
        if(objConfiguracion.confComplementaria!='')
        {
        	var objComp=eval('['+objConfiguracion.confComplementaria+']')[0];
            var txtFuncionAplicacionCambioEtapa=gEx('txtFuncionAplicacionCambioEtapa');
            txtFuncionAplicacionCambioEtapa.setValue(objConfiguracionComplementaria.lblFuncionAplicacionMarcaAsignacion);
        	txtFuncionAplicacionCambioEtapa.idConsulta=objComp.funcionAplicacion==''?-1:objComp.funcionAplicacion;
            cmbUsuarioMarcaAtendida.setValue(objComp.afectarNotificionUsuario);
            cmbMarcarNotificacionesDelegadas.setValue(objComp.afectarNotificacionesDelegadas);
            cmbMarcarNotificacionesOrigen.setValue(objComp.afectarNotificacionesPadre);
            
            
        }
        
        cmbProcesoArranque1.setValue(objConfiguracion.procesoArranque);
        dispararEventoSelectCombo('cmbProcesoArranque_1');
        cmbEtapaArranque.setValue(objConfiguracion.etapaArranque);
    }	
    
    
   
    
}

function agregarFuncionControl(tipo)
{

	var control='';
	switch(tipo)
    {
    	case 1:
	    	control=gEx('txtFuncionAplicacion');
    	break;
        case 2:
	    	control=gEx('txtFuncionAsignacionDestinatario');
    	break;
        case 3:
	    	control=gEx('txtFuncionAplicacionCambioEtapa');
    	break;
        case 4:
        	control=gEx('txtFuncionAplicacionMacropoceso');
        	
        break;
    }
    
    
    
    asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre,ventana)
                                            {
                                             	control.idConsulta=idConsulta;
                                                control.setValue(nombre);
                                                
                                                if(gEx('vAgregarExp'))
	                                                gEx('vAgregarExp').close();
                                            }
    mostrarVentanaExpresion(function(filaSelec,ventana)
    						{
                            	control.idConsulta=filaSelec.data.idConsulta;
                                control.setValue(filaSelec.data.nombreConsulta);
                                
                                
                                ventana.close();
                            }
    						,true);
    
}

function removerFuncionControl(tipo)
{
	var control='';
    switch(tipo)
    {
    	case 1:
	    	control=gEx('txtFuncionAplicacion');
    	break;
        case 2:
	    	control=gEx('txtFuncionAsignacionDestinatario');
    	break;
        case 3:
	    	control=gEx('txtFuncionAplicacionCambioEtapa');
    	break;
        case 4:
        	control=gEx('txtFuncionAplicacionMacropoceso');
        	
        break;
    }
    
    
    
    
    control.idConsulta='-1';
    control.setValue('');
}
