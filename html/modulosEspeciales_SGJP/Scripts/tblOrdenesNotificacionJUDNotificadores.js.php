<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$consulta="SELECT idEtapaProcesal,descripcionEtapa,orden FROM 7009_etapasProcesales ORDER BY orden";
	$arrEtapasProcesales=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos";
	$arrCategorias=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos order by nombreCategoria";
	$arrTipoDocumento=$con->obtenerFilasArreglo($consulta);
?>
var uploadControl;
var arrTipoDocumento=<?php echo $arrTipoDocumento?>;
var registroDocumentoSel=null;
var arrEtapasProcesales=<?php echo $arrEtapasProcesales?>;
var arrCategorias=<?php echo $arrCategorias?>;
var arrAudiencias=[];
var carpetaAdministrativa=-1;
var idCarpeta=-1;
var idOrden=-1;
 
var arrSituacionOrden=[['2,3,4','Cualquiera'],['2','En espera de atenci\xF3n (JUD de Notificadores)'],['3','En espera de atenci\xF3n (Notificador)'],['4','Atendida']]; 
var arrTipoSolicitud=[['1','Derivada de Determinaci\xF3n'],['2','Derivada de audiencia']];
  
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
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>&Oacute;rdenes de notificaci&oacute;n</b></span>',
                                               	tbar:	[
                                                            {
                                                                icon:'../images/add.png',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnCrear',
                                                                hidden:true,
                                                                text:'Crear orden de notificaci&oacute;n',
                                                                handler:function()
                                                                        {
                                                                          	mostrarVentanaOrdenNotificacion();  
                                                                        }
                                                                
                                                            },'-',
                                                            {
                                                            	id:'btnModificar',
                                                                icon:'../images/pencil.png',
                                                                cls:'x-btn-text-icon',
                                                                hidden:true,
                                                                text:'Modificar orden de notificaci&oacute;n',
                                                                handler:function()
                                                                        {
                                                                            var fila=gEx('gOrdenesNotificacion').getSelectionModel().getSelected();
                                                                            if(!fila)
                                                                            {
                                                                            	msgBox('Debe seleccionar la orden de notificaci&oacute;n que desea remover');
                                                                            	return;
                                                                            }
                                                                            mostrarVentanaOrdenNotificacion(fila);
                                                                        }
                                                                
                                                            }
                                                            ,'-',
                                                            {
                                                            	id:'btnRemover',
                                                                icon:'../images/delete.png',
                                                                cls:'x-btn-text-icon',
                                                                hidden:true,
                                                                text:'Remover orden de notificaci&oacute;n',
                                                                handler:function()
                                                                        {
                                                                            var fila=gEx('gOrdenesNotificacion').getSelectionModel().getSelected();
                                                                            if(!fila)
                                                                            {
                                                                            	msgBox('Debe seleccionar la orden de notificaci&oacute;n que desea remover');
                                                                            	return;
                                                                            }
                                                                            
                                                                            function respConf(btn)
                                                                            {
                                                                            	if(btn=='yes')
                                                                                {
                                                                                    function funcAjax()
                                                                                    {
                                                                                        var resp=peticion_http.responseText;
                                                                                        arrResp=resp.split('|');
                                                                                        if(arrResp[0]=='1')
                                                                                        {
                                                                                            gEx('btnRemover').disable();
                                                                                            gEx('btnModificar').disable();
                                                                                            gEx('gOrdenesNotificacion').getStore().remove(fila);
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                        }
                                                                                    }
                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=5&iO='+fila.data.idOrden,true);
                                                                           		}
                                                                            }
                                                                            msgConfirm('Est&aacute; seguro de querer remover la orden de notificaci&oacute;n seleccionada?',respConf);
                                                                            
                                                                        }
                                                                
                                                            }
                                                            
                                                        ] ,
                                                items:	[
                                                            crearGridOrdenesNotificacion()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}

function crearGridOrdenesNotificacion()
{
	var cmbSituacionOrdenes=crearComboExt('cmbSituacionOrdenes',arrSituacionOrden,0,0,300);
    cmbSituacionOrdenes.setValue('2,3,4');
    cmbSituacionOrdenes.on('select',function(cmb,registro)
    								{
                                    	gEx('gOrdenesNotificacion').getStore().reload();
                                    }
    						)
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idOrden'},
		                                                {name: 'folioOrden'},
		                                                {name: 'carpetaJudicial'},
		                                                {name:'idCarpeta'},
                                                        {name: 'fechaEnvioJUDRegistro',  type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'fechaDeterminacion', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'tipoNotificacion'},
                                                        {name: 'descripcionNotificacion'},
                                                        {name: 'solicitadoPor'},
                                                        {name: 'situacion'},
                                                        {name: 'notificadorAsignado'},
                                                        {name: 'comentariosAdicionales'},
                                                        {name: 'nombreDeterminacion'},
                                                        {name: 'idEventoDeriva'},
                                                        {name: 'actasFirmadas'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
    
    var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[ 
                                                        				{type: 'string', dataIndex: 'folioOrden'},
                                                                        {type: 'string', dataIndex: 'carpetaJudicial'},
                                                                        {type: 'date', dataIndex: 'fechaEnvioJUDRegistro'},
                                                                        {type: 'list', dataIndex: 'tipoNotificacion', options :arrTipoSolicitud, phpMode:true},
                                                                    ]
                                                    }
                                                ); 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'folioOrden', direction: 'ASC'},
                                                            groupField: 'folioOrden',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	gEx('btnRemover').disable();
                                        gEx('btnModificar').disable();
                                    	proxy.baseParams.funcion='17';
                                        proxy.baseParams.iU='<?php echo $_SESSION["codigoInstitucion"]?>';
                                        proxy.baseParams.situacion=cmbSituacionOrdenes.getValue();
                                        
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'',
                                                                width:40,
                                                                sortable:true,
                                                                dataIndex:'idOrden',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(parseInt(registro.data.situacion)>1)
                                                                            {
                                                                            	return '<a href="javascript:mostrarVentanaAperturaNotificacionJUD(\''+bE('{"idOrden":"'+val+'"}')+'\')"><img src="../images/magnifier.png" width="14" height="14" title="Ver orden de notificaci&oacute;n" alt="Ver orden de notificaci&oacute;n"></a>';
                                                                            }
                                                                        }
                                                            },
                                                            {
                                                                header:'',
                                                                width:90,
                                                                sortable:true,
                                                                dataIndex:'idOrden',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                        	if(registro.data.actasFirmadas!='')
                                                                            {
                                                                            	var arrOrdenes=registro.data.actasFirmadas.split(',');
                                                                                var comp='';
                                                                                var o='';
                                                                                var x;
                                                                                var noActa=1;
                                                                                for(x=0;x<arrOrdenes.length;x++)
                                                                                {
                                                                                	o='<a href="javascript:mostrarActaCircunstanciada(\''+bE(arrOrdenes[x])+'\')"><img src="../imagenesDocumentos/16/file_extension_pdf.png" title="Acta circunstaciada '+noActa+'" alt="Acta circunstaciada '+noActa+'"></a>';
                                                                                    if(comp=='')
                                                                                    	comp=o;
                                                                                    else
                                                                                    	comp+=' '+o;
                                                                                    noActa++;
                                                                                }
                                                                                
                                                                                return comp;

                                                                            }
                                                                        }
                                                            },
                                                            {
                                                                header:'Folio',
                                                                width:110,
                                                                sortable:true,
                                                                dataIndex:'folioOrden'
                                                            },
                                                            {
                                                                header:'Carpeta Judicial',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'carpetaJudicial'
                                                            },
                                                            {
                                                                header:'Fecha de asignaci&oacute;n',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'fechaEnvioJUDRegistro',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            {
                                                                header:'Tipo notificaci&oacute;n',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'tipoNotificacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoSolicitud,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Nombre determinaci&oacute;n/audiencia',
                                                                width:520,
                                                                sortable:true,
                                                                dataIndex:'descripcionNotificacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	meta.attr='style="height:auto !important;white-space: normal;line-height: 14px;"';
                                                                        	return mostrarValorDescripcion(val);
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:'Solicitado por',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'solicitadoPor',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return mostrarValorDescripcion(val);
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:'Comentarios adicionales',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'comentariosAdicionales',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return mostrarValorDescripcion(val);
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:'Notificador asignado',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'notificadorAsignado',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return mostrarValorDescripcion(val);
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n',
                                                                width:320,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return formatearValorRenderer(arrSituacionOrden,val);
                                                                        	
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gOrdenesNotificacion',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                border:true,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                plugins:[filters],
                                                                columnLines : true,   
                                                                tbar:	[
                                                                            {
                                                                            	xtype:'label',
                                                                                html:'&nbsp;&nbsp;<b>Mostrar &oacute;rdenes en situaci&oacute;n:</b>&nbsp;&nbsp;&nbsp;'
                                                                            },
                                                                            cmbSituacionOrdenes
                                                                            
                                                                        ] ,                                                            
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
                                                        
		tblGrid.getSelectionModel().on	('rowselect',function(sm,nFila,registro)
                                        {
                                        	gEx('btnRemover').disable();
                                            gEx('btnModificar').disable();
                                            
                                            if(parseInt(registro.data.situacion)==1)
                                            {
                                            	gEx('btnRemover').enable();
                                                gEx('btnModificar').enable();
                                            }
                                        }
        			)                                                        
        
        
                                                        
        return 	tblGrid;	
}

function mostrarVentanaOrdenNotificacion(fila)
{
	if(fila)
    	idOrden=fila.data.idOrden;
    else
        idOrden=-1;
	
	var oConf=	{
    					idCombo:'cmbCarpetaJudicial',
                        anchoCombo:200,
                        posX:180,
                        posY:5,
                        raiz:'registros',
                        campoDesplegar:'carpetaAdministrativa',
                        campoID:'carpetaAdministrativa',
                        funcionBusqueda:47,
                        paginaProcesamiento:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                        confVista:'<tpl for="."><div class="search-item">{carpetaAdministrativa}<br></div></tpl>',
                        campos:	[
                                    {name:'carpetaAdministrativa'},
                                    {name:'idCarpeta'}

                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	carpetaAdministrativa=-1;
                                        idCarpeta=-1;
                                    	var aValor=combo.getRawValue();
										dSet.baseParams.criterio=aValor;
                                        dSet.baseParams.uG='<?php echo $_SESSION["codigoInstitucion"]?>';
                                        
                                        
                                        
                                    },
                      	funcElementoSel:function(combo,registro)
                    				{
                                    	carpetaAdministrativa=registro.data.carpetaAdministrativa;
                                        idCarpeta=registro.data.idCarpeta;
                                        function funcAjax()
                                        {
                                            var resp=peticion_http.responseText;
                                            arrResp=resp.split('|');
                                            if(arrResp[0]=='1')
                                            {
                                                arrAudiencias=eval(arrResp[1]);
                                                gEx('cmbAudienciaDeriva').getStore().loadData(arrAudiencias);
                                            }
                                            else
                                            {
                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                            }
                                        }
                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=2&iC='+idCarpeta+'&cA='+carpetaAdministrativa,true);
                                        
                                    }  
    				};

	var carpetaJudicial=crearComboExtAutocompletar(oConf);
	var cmbTipoNotificacion=crearComboExt('cmbTipoNotificacion',arrTipoSolicitud,180,35,200);
    
    var cmbAudienciaDeriva=crearComboExt('cmbAudienciaDeriva',[],180,65,480);
    cmbAudienciaDeriva.on('select',function(cmb,registro)
   									{
   										gEx('dteFechaDterminacion').setValue(registro.data.valorComp);
   									}
    					)
    cmbAudienciaDeriva.hide();
    
    cmbTipoNotificacion.on('select',function(cmb,registro)
    								{
                                    	
                                    	switch(registro.data.id)
                                        {
                                            case '1':
                                                gEx('lblNombreDeterminacion').show();
                                                gEx('txtNombreDeterminacion').show();
                                                gEx('lblFechaDeterminacion').setText('Fecha de la determinaci&oacute;n:',false);
                                                gEx('lblFechaDeterminacion').show();
                                                gEx('dteFechaDterminacion').show();
                                                gEx('dteFechaDterminacion').setValue('<?php echo date("Y-m-d")?>');
                                                gEx('dteFechaDterminacion').enable();
                                                gEx('lblAudienciaDeriva').hide();
                                                gEx('cmbAudienciaDeriva').setValue('');
                                                gEx('cmbAudienciaDeriva').hide();
                                                gEx('txtNombreDeterminacion').focus(false,500);
                                                
                                            break;
                                            case '2':

                                                gEx('lblNombreDeterminacion').hide();
                                                gEx('txtNombreDeterminacion').hide();
                                                gEx('txtNombreDeterminacion').setValue('');
                                                gEx('lblFechaDeterminacion').show();
                                                gEx('dteFechaDterminacion').setValue('');
                                                gEx('dteFechaDterminacion').disable();
                                                gEx('lblFechaDeterminacion').setText('Fecha del auto:');
                                                gEx('dteFechaDterminacion').show();                                        
                                                gEx('lblAudienciaDeriva').show();
                                                gEx('cmbAudienciaDeriva').show();
                                                gEx('cmbAudienciaDeriva').focus(false,500);
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
                                                            html:'Carpeta Judicial:'
                                                        },
                                                        carpetaJudicial,
                                                        {
                                                        	x:455,
                                                            y:5,
                                                            width:100,
                                                            hight:35,
                                                            xtype:'button',
                                                            icon:'../images/guardar.JPG',
                                                            cls:'x-btn-text-icon',
                                                            text:'Guardar orden',
                                                            handler:function()
                                                                    {
                                                                        if(carpetaAdministrativa==-1)
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	gEx('cmbCarpetaJudicial').focus();
                                                                            }
                                                                        	msgBox('Debe indicar la carpeta judicial a la cual pertenece la orden de notificaci&oacute;n',resp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(gEx('cmbTipoNotificacion').getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	gEx('cmbTipoNotificacion').focus();
                                                                            }
                                                                        	msgBox('Debe indicar el tipo de notificaci&oacute;n de la cual deriva la orden de notificaci&oacute;n',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        switch(gEx('cmbTipoNotificacion').getValue())
                                                                        {
                                                                        	case '1':
                                                                            	if(gEx('txtNombreDeterminacion').getValue()=='')
                                                                                {
                                                                                	function resp3()
                                                                                    {
                                                                                        gEx('txtNombreDeterminacion').focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el nombre de la determinaci&oacute;n de la cual deriva la orden de notificaci&oacute;n',resp3);
                                                                                    return;
                                                                                }
                                                                                
                                                                                if(gEx('dteFechaDterminacion').getValue()=='')
                                                                                {
                                                                                	function resp4()
                                                                                    {
                                                                                        gEx('dteFechaDterminacion').focus();
                                                                                    }
                                                                                    msgBox('Debe indicar la fecha de la determinaci&oacute;n de la cual deriva la orden de notificaci&oacute;n',resp4);
                                                                                    return;
                                                                                }
                                                                            break;
                                                                            case '2':
                                                                            	if(gEx('cmbAudienciaDeriva').getValue()=='')
                                                                                {
                                                                                	function resp5()
                                                                                    {
                                                                                        gEx('cmbAudienciaDeriva').focus();
                                                                                    }
                                                                                    msgBox('Debe indicar la audiencia de la cual deriva la orden de notificaci&oacute;n',resp5);
                                                                                    return;
                                                                                }
                                                                                
                                                                                if(gEx('dteFechaDterminacion').getValue()=='')
                                                                                {
                                                                                	function resp6()
                                                                                    {
                                                                                        gEx('dteFechaDterminacion').focus();
                                                                                    }
                                                                                    msgBox('Debe indicar la fecha del auto de la cual deriva la orden de notificaci&oacute;n',resp6);
                                                                                    return;
                                                                                }
                                                                            break;
                                                                        }
                                                                        
                                                                        var cadObj='{"idOrden":"'+idOrden+'","carpetaJudicial":"'+carpetaAdministrativa+'","idCarpeta":"'+idCarpeta+'","tipoNotificacion":"'+
                                                                        			gEx('cmbTipoNotificacion').getValue()+'","nombreDeterminacion":"'+cv(gEx('txtNombreDeterminacion').getValue())+
                                                                                    '","fechaDeterminacion":"'+gEx('dteFechaDterminacion').getValue().format('Y-m-d')+'","idEventoAudiencia":"'+
                                                                                    gEx('cmbAudienciaDeriva').getValue()+'","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+'"}';
                                                                    
                                                                    	
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	if(idOrden==-1)
                                                                                {
                                                                                	gEx('vOrden').setTitle('Modificar orden de notificaci&oacute;n: , Folio: <b><span style="color:#900">'+arrResp[2]+'</span></b>');
                                                                                }
                                                                                idOrden=parseInt(arrResp[0]);
                                                                                gEx('gOrdenesNotificacion').getStore().reload();
                                                                                gEx('fArchivos').enable();
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[1]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=4&cadObj='+cadObj,true);
                                                                        
                                                                    }
                                                            
                                                        },
                                                        {
                                                        	x:560,
                                                            y:5,
                                                            id:'btnEnviarJUD',
                                                            width:100,
                                                            hight:35,
                                                            hidden:fila?false:true,
                                                            xtype:'button',
                                                            icon:'../images/user_go.png',
                                                            cls:'x-btn-text-icon',
                                                            text:'Enviar a JUD de Notificadores',
                                                            handler:function()
                                                                    {
                                                                       
                                                                        var cadObj='{"idOrden":"'+idOrden+'"}';                                                                    
                                                                    	
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	
                                                                                gEx('gOrdenesNotificacion').getStore().reload();
                                                                                gEx('vOrden').close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=9&cadObj='+cadObj,true);
                                                                        
                                                                    }
                                                            
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Tipo notificaci&oacute;n:'
                                                        },
                                                        cmbTipoNotificacion,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            hidden:true,
                                                            id:'lblNombreDeterminacion',
                                                            html:'Nombre de la determinaci&oacute;n:'
                                                        },
                                                        {
                                                            id:'txtNombreDeterminacion',
                                                            xtype:'textfield',
                                                            width:480,
                                                            hidden:true,
                                                            x:180,
                                                            y:65
                                                        },
                                                        {
                                                            x:10,
                                                            y:100,
                                                            id:'lblFechaDeterminacion',
                                                            hidden:true,
                                                            xtype:'label',
                                                            html:'Fecha de la determinaci&oacute;n:'
                                                        },
                                                        {
                                                            x:10,
                                                            y:70,
                                                            hidden:true,
                                                            xtype:'label',
                                                            id:'lblAudienciaDeriva',
                                                            html:'Audiencia de la cual deriva:'
                                                        },
                                                        cmbAudienciaDeriva,
                                                        {
                                                            xtype:'datefield',
                                                            x:180,
                                                            y:95,
                                                            id:'dteFechaDterminacion',
                                                            hidden:true,
                                                            value:'<?php echo date("Y-m-d")?>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:150,
                                                            xtype:'textarea',
                                                            id:'txtComentariosAdicionales',
                                                           	width:820,
                                                            hight:25
                                                        },
                                                        {
                                                        	xtype:'fieldset',
                                                            id:'fArchivos',
                                                            x:10,
                                                            y:225,
                                                            width:820,
                                                            height:165,
                                                            layout:'border',
                                                            disabled:true,
                                                            title:'Documentos a notificar',
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            layout:'border',
                                                                            
                                                                            region:'center',
                                                                            tbar:	[
                                                                                        {
                                                                                            icon:'../images/add.png',
                                                                                            cls:'x-btn-text-icon',
                                                                                            text:'Agregar documento',
                                                                                            handler:function()
                                                                                                    {
                                                                                                     	mostrarVentanaDocumentos();   
                                                                                                    }
                                                                                            
                                                                                        },'-',
                                                                                        {
                                                                                            icon:'../images/delete.png',
                                                                                            cls:'x-btn-text-icon',
                                                                                            text:'Remover documento',
                                                                                            handler:function()
                                                                                                    {
                                                                                                        if(!registroDocumentoSel)
                                                                                                        {
                                                                                                        	msgBox('Debe seleccionar el documento que desea remover');
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
                                                                                                                        gEx('vistaDocuentosAdjuntos').getStore().reload();
                                                                                                                    }
                                                                                                                    else
                                                                                                                    {
                                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                    }
                                                                                                                }
                                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=7&iO='+idOrden+'&iD='+registroDocumentoSel.data.idDocumento,true);
                                                                                                            }
                                                                                                        }
                                                                                                        msgConfirm('Est&aacute; seguro de querer remover el documento seleccionado?',resp);
                                                                                                        
                                                                                                    }
                                                                                            
                                                                                        }
                                                                                        
                                                                                    ],
                                                                            items:	[
                                                                            
                                                                            			crearVistaDocumentosAdjuntos()
                                                                            		]
                                                                        }
                                                                        
                                                                        
                                                            		]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: (fila?'Modificar orden de notificaci&oacute;n':'Nueva orden de notificaci&oacute;n')+', Folio: <b><span style="color:#900">'+(fila?fila.data.folioOrden:'Por asignar')+'</span></b>' ,
										width: 880,
										height:470,
										layout: 'fit',
										plain:true,
										modal:true,
                                        id:'vOrden',
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
                                                            hidden:true,
															handler: function()
																	{
																		
																	}
														},
														{
															text: 'Cerrar',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();
    
    if(fila)
    {
    	carpetaAdministrativa=fila.data.carpetaJudicial;
		idCarpeta=fila.data.idCarpeta;
        
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            	
                arrAudiencias=eval(arrResp[1]);
                gEx('cmbAudienciaDeriva').getStore().loadData(arrAudiencias);
                gEx('cmbCarpetaJudicial').setRawValue(carpetaAdministrativa);
                gEx('cmbTipoNotificacion').setValue(fila.data.tipoNotificacion);
                dispararEventoSelectCombo('cmbTipoNotificacion');
                gEx('dteFechaDterminacion').setValue(fila.data.fechaDeterminacion);
                gEx('txtNombreDeterminacion').setValue(fila.data.nombreDeterminacion);
                gEx('cmbAudienciaDeriva').setValue(fila.data.idEventoDeriva);
                gEx('txtComentariosAdicionales').setValue(escaparBR(fila.data.comentariosAdicionales));
                gEx('fArchivos').enable();
                
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=2&iC='+idCarpeta+'&cA='+carpetaAdministrativa,true);
        
    	
        
    }
    	
}



function mostrarVentanaDocumentos()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridDocumentos()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar documentos',
										width: 950,
										height:450,
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
                                                                    	var listaDocumentos='';
																		var filas=gEx('gridDocumentos').getSelectionModel().getSelections();
                                                                        var x;
                                                                        var f;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	f=filas[x];
                                                                            if(listaDocumentos=='')
                                                                            	listaDocumentos=f.data.idDocumento;
                                                                            else
                                                                            	listaDocumentos+=','+f.data.idDocumento;
                                                                        }
                                                                        
                                                                        if(listaDocumentos=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar almenos un documento a adjuntar a la orden de notificaci&oacute;n');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var cadObj='{"idOrden":"'+idOrden+'","listaDocumentos":"'+listaDocumentos+'"}';
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('vistaDocuentosAdjuntos').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=6&cadObj='+cadObj,true);
                                                                        
                                                                        
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
    dispararEventoSelectCombo('cmbOridenDocumentos');
}

function crearGridDocumentos()
{
	var cmbOridenDocumentos=crearComboExt('cmbOridenDocumentos',[['1','Carpeta Judicial']],0,0,250);
    cmbOridenDocumentos.setValue('1');
    cmbOridenDocumentos.on('select',function(cmb,registro)
    								{
                                    	switch(parseInt(registro.data.id))
                                        {
                                        	case 1:
                                            	gEx('gridDocumentos').getStore().load	(
                                                                                            {
                                                                                                url:'funcionesModulosEspeciales_SGP',
                                                                                                parms:	{
                                                                                                            funcion:19,
                                                                                                            cA:bE(carpetaAdministrativa),
                                                                                                            idCarpetaAdministrativa:idCarpeta
                                                                                                        }
                                                                                            }
                                                                                        )
                                            	
                                            break;
                                        }
                                    }
    					)
    
    
	var cmbTipoDocumento=crearComboExt('cmbTipoDocumento',arrCategorias);
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDocumento'},
		                                                {name: 'etapaProcesal'},
		                                                {name:'nomArchivoOriginal'},
		                                                {name: 'tamano'},
                                                        {name: 'fechaRegistro', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'descripcion'},
                                                        {name:'idFormulario'},
                                                        {name:'idRegistro'},
                                                        {name:'idDocumento'},
                                                        {name: 'categoriaDocumentos'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                reader: lector,
                                                proxy : new Ext.data.HttpProxy	(

                                                                                  {

                                                                                      url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                  }

                                                                              ),
                                                sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                groupField: 'fechaRegistro',
                                                remoteGroup:false,
                                                remoteSort: false,
                                                autoLoad:false
                                                
                                            }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='19';
                                        proxy.baseParams.cA=bE(carpetaAdministrativa);
                                        proxy.baseParams.idCarpetaAdministrativa=idCarpeta;
                                    }
                        )   
       
    
    
    var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[ 
                                                        				{type: 'date', dataIndex: 'fechaCreacion'},
                                                                        {type: 'string', dataIndex: 'nomArchivoOriginal'},
                                                                        {type: 'list', dataIndex: 'categoriaDocumentos', phpMode:true, options:arrCategorias}
                                                                    ]
                                                    }
                                                );    
       
	/*var expander = new Ext.ux.grid.RowExpander({
                                                column:1,
                                                expandOnDblClick:false,
                                                tpl : new Ext.Template(
                                                    '<table >'+
                                                    '<tr><td ><span class="TSJDF_Control">{descripcion}</span><br /><br /></td></tr>'+
                                                    '</table>'
                                                )
                                            });    */    

	var chkRow=new Ext.grid.CheckboxSelectionModel();
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                    	new  Ext.grid.RowNumberer({width:30}),
                                                        chkRow,
                                                        {
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'idDocumento',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                                                        return '<img src="../imagenesDocumentos/16/file_extension_'+arrNombre[1].toLowerCase()+'.png" />'
                                                                    }
                                                        },
                                                        {
                                                            header:'Fecha de registro',
                                                            width:120,
                                                            sortable:true,
                                                            dataIndex:'fechaRegistro',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
                                                                    		return val.format('d/m/Y');
                                                                    }
                                                        },
                                                        {
                                                            header:'Tipo documento',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'categoriaDocumentos',
                                                            editor:cmbTipoDocumento,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrCategorias,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Etapa procesal',
                                                            width:250,
                                                            hidden:true,
                                                            sortable:true,
                                                            dataIndex:'etapaProcesal',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrEtapasProcesales,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Documento',
                                                            width:420,
                                                            sortable:true,
                                                            dataIndex:'nomArchivoOriginal',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        
                                                        {
                                                            header:'Tama&ntilde;o',
                                                            width:100,
                                                            sortable:true,
                                                            dataIndex:'tamano',
                                                            renderer:function(val)
                                                            		{
                                                                    	return bytesToSize(parseInt(val),0);
                                                                    }
                                                        }
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridDocumentos',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            sm:chkRow,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            tbar:	[
                                                            			{
                                                                        	xtype:'label',
                                                                            html:'<b>Origen de los documentos:&nbsp;&nbsp;</b>'
                                                                        },
                                                                        cmbOridenDocumentos,'-',
                                                                        {
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Adjuntar documento',
                                                                            handler:function()
                                                                                    {
                                                                                        mostrarVentanaAdjuntarDocumento()
                                                                                    }
                                                                            
                                                                        }
                                                            		],
                                                            columnLines : true,  
                                                            plugins:[filters],   
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :false,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: false,
                                                                                                startCollapsed:false,
                                                                                                groupTextTpl:'<span style="color:#900"><b>{text}</b> ({[values.rs.length]} {[values.rs.length > 1 ? "Documentos" : "Documento"]})</span>'
                                                                                            })
                                                        }
                                                    );
                                                    
	
    
    
    tblGrid.on('rowdblclick',function(grid,rowIndex)
                              {
                              		var registro=grid.getStore().getAt(rowIndex);
                                    var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                  	mostrarVisorDocumentoProceso(arrNombre[1].toLowerCase(),registro.data.idDocumento,registro);
                                  
                              }
                  )                                                    
                                                    
    return 	tblGrid;	
}

function mostrarVentanaAdjuntarDocumento()
{

	/*var idRegistroAux=gE('idRegistroAux').value;
    if(idRegistroAux=='-1')
    {
    	msgBox('Primero debe guardar el formato de captura');
    	return;
    }*/

	     					
					
	var cmbTipoDocumento=crearComboExt('cmbTipoDocumento',arrTipoDocumento,185,5,350);

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	xtype:'label',
                                                            x:10,
                                                            y:10,
                                                            html:'Tipo de documento a adjuntar:'
                                                        },
                                                        cmbTipoDocumento,
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:40,
                                                            html:'Ingrese el documento a adjuntar:'
                                                        },
                                                        {
                                                            x:185,
                                                            y:35,
                                                            html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                        },
                                                       
                                                        {
                                                            x:480,
                                                            y:36,
                                                            id:'btnUploadFile',
                                                            xtype:'button',
                                                            text:'Seleccionar...',
                                                            handler:function()
                                                                    {
                                                                        $('#containerUploader').click();
                                                                    }
                                                        },
							 {
                                                            x:185,
                                                            y:10,
                                                            hidden:true,
                                                            html:	'<div id="containerUploader"></div>'
                                                        },
                                                        {
                                                            x:290,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'idArchivo'

                                                        },
                                                        {
                                                            x:290,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'nombreArchivo'
                                                        } ,
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:70,
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	xtype:'textarea',
                                                            x:10,
                                                            y:100,
                                                            width:600,
                                                            height:60,
                                                            id:'txtDescripcion'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Adjuntar documento',
										width: 650,
                                        id:'vDocumento',
										height:250,
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
                                                                
                                                                	var cObj={
                                                                    // Backend settings
                                                                                            upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                                                                                            file_post_name: "archivoEnvio",
                                                                             
                                                                                            // Flash file settings
                                                                                            file_size_limit : "1000 MB",
                                                                                            file_types : "*.pdf;*.jpg;*.jpeg;*.gif;*.png",			// or you could use something like: "*.doc;*.wpd;*.pdf",
                                                                                            file_types_description : "Todos los archivos",
                                                                                            file_upload_limit : 0,
                                                                                            file_queue_limit : 1,
                                                                             
                                                                                            
                                                                                            upload_success_handler : subidaCorrecta
                                                                                        };
                                                                     crearControlUploadHTML5(cObj);
                                                                
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
                                                                    	if(cmbTipoDocumento.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	cmbTipoDocumento.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de documento adjuntar');
                                                                            return;
                                                                        }
                                                                    	
																			
                                                                        
                                                                        if(uploadControl.files.length==0)
                                                                        {
                                                                            msgBox('Debe ingresar el documento que desea adjuntar');
                                                                            return;
                                                                        }
                                                                        uploadControl.start();
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

function subidaCorrecta(file, serverData) 
{


    file.id = "singlefile";	// This makes it so FileProgress only makes a single UI element, instead of one for each file
    var arrDatos=serverData.split('|');

    if ( arrDatos[0]!='1') 
    {
    	
        
    } 
    else 
    {
        
        gEx("idArchivo").setValue(arrDatos[1]);
        gEx("nombreArchivo").setValue(arrDatos[2]);
        if( gE('txtFileName'))
	        gE('txtFileName').value=arrDatos[2];
        
        
        
        var cadObj='{"carpetaAdministrativa":"'+carpetaAdministrativa+'","idFormulario":"-1","idRegistro":"-1","idArchivo":"'+arrDatos[1]+'","nombreArchivo":"'+arrDatos[2]+
        '","tipoDocumento":"'+gEx('cmbTipoDocumento').getValue()+'","descripcion":"'+cv(gEx('txtDescripcion').getValue())+'","idOrden":"'+idOrden+'"}';
    
        function funcAjax2(peticion_http)
        {
            var resp=peticion_http.responseText;
            
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
               	gEx('vistaDocuentosAdjuntos').getStore().reload();
                gEx('gridDocumentos').getStore().reload();
                gEx('vDocumento').close();                
            }
            else
            {
                
                msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+arrResp[0]);
            }
        }
        obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax2, 'POST','funcion=8&cadObj='+cadObj,false);
        
        
        
    }
		
	
}

function mostrarOrdenNotificacion(val)
{
	var pos=obtenerPosFila(gEx('gOrdenesNotificacion').getStore(),'idOrden',bD(val));
    var fila=gEx('gOrdenesNotificacion').getStore().getAt(pos);
    mostrarVentanaOrdenNotificacionSoloLectura(fila);
}

function mostrarVentanaOrdenNotificacionSoloLectura(fila)
{
	idOrden=fila.data.idOrden;
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Carpeta Judicial:'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:10,
                                                            html:'<span style="color:#900; font-weight:bold">'+fila.data.carpetaJudicial+'</span>'
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Tipo notificaci&oacute;n:'
                                                        },
                                                         {
                                                        	x:180,
                                                            y:40,
                                                            html:'<span style="color:#900; font-weight:bold">'+formatearValorRenderer(arrTipoSolicitud,fila.data.tipoNotificacion)+'</span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            hidden:fila.data.tipoNotificacion=='2',
                                                            id:'lblNombreDeterminacion',
                                                            html:'Nombre de la determinaci&oacute;n:'
                                                        },
                                                        
                                                        {
                                                            x:10,
                                                            y:100,
                                                            id:'lblFechaDeterminacion',
                                                            xtype:'label',
                                                            html:fila.data.tipoNotificacion=='1'?'Fecha de la determinaci&oacute;n:':'Fecha del auto:'
                                                        },
                                                        {
                                                            x:10,
                                                            y:70,
                                                            hidden:fila.data.tipoNotificacion=='1',
                                                            xtype:'label',
                                                            id:'lblAudienciaDeriva',
                                                            html:'Audiencia de la cual deriva:'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:70,
                                                           
                                                            id:'lblFechaAudiencia',
                                                            html:'<span style="color:#900; font-weight:bold" title="'+fila.data.descripcionNotificacion+'" alt="'+fila.data.descripcionNotificacion+'">'+fila.data.descripcionNotificacion.substr(0,100)+(fila.data.descripcionNotificacion.length>100?'...':'')+'</span>'
                                                        },
                                                        {
                                                            xtype:'label',
                                                            x:180,
                                                            y:100,                                                           
                                                            id:'dteFechaDterminacion',
                                                            html:'<span style="color:#900; font-weight:bold">'+fila.data.fechaDeterminacion.format('d/m/Y')+'</span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:150,
                                                            xtype:'textarea',
                                                            id:'txtComentariosAdicionales',
                                                            readOnly:true,
                                                           	width:820,
                                                            hight:25,
                                                            value:escaparBR(fila.data.comentariosAdicionales)
                                                        },
                                                        {
                                                        	xtype:'fieldset',
                                                            id:'fArchivos',
                                                            x:10,
                                                            y:225,
                                                            width:820,
                                                            height:165,
                                                            layout:'border',
                                                            
                                                            title:'Documentos a notificar',
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            layout:'border',
                                                                            
                                                                            region:'center',
                                                                            
                                                                            items:	[
                                                                            
                                                                            			crearVistaDocumentosAdjuntos()
                                                                            		]
                                                                        }
                                                                        
                                                                        
                                                            		]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Orden de notificaci&oacute;n, Folio: <b><span style="color:#900">'+fila.data.folioOrden+'</span></b>',
										width: 880,
										height:470,
										layout: 'fit',
										plain:true,
										modal:true,
                                        id:'vOrden',
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
															text: 'Cerrar',
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

function mostrarActaCircunstanciada(iD)
{
	mostrarVisorDocumentoProceso('pdf',bD(iD));
}