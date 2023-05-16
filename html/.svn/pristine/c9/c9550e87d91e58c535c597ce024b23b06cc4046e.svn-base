<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idTipoTelefono,tipoTelefono FROM 1006_tipoTelefono";
	$arrTelefonos=$con->obtenerFilasArreglo($consulta);
	
?>

var eventoClone=false;
var arrTelefonos=<?php echo $arrTelefonos?>;
var primeraCargaFrame=true;

var arrTipoParticipante=[['1','Usuario de Sistema'],['2','Usuario Externo al Sistema'],['3','Usuario Gen\xE9rico']];
var arrRolesReunion=[['1','Moderador'],['2','Invitado']];
var arrSiNo=<?php echo $arrSiNo?>;
var arrSituacionConferencia=[['0','En Espera de Confirmaci&oacute;n','../images/bullet-grey.png'],['1','En Espera de Inicio','../images/bullet-green.png'],['2','En Desarrollo','../images/control_play_blue.png'],['3','Conclu&iacute;da','../images/bullet-blue.png'],['4','Cancelada','../images/bullet-black.png']];
    
var arregloValores=[];

Ext.onReady(inicializar);

function inicializar()
{
	var horaInicial=new Date(2010,5,10,0,0);
	var horaFinal=new Date(2010,5,10,23,59);
	arregloValores=generarIntervaloHoras(horaInicial,horaFinal,1,'H:i','H:i');
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Reuniones Virtuales Programadas</b></span>',
                                                items:	[
                                                			crearArbolContactos(),
                                                            crearGridAudienciasProgramadas()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}


function crearGridAudienciasProgramadas()
{

	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name:'fechaRegistro', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                                {name: 'idResponsableRegistro'},
                                                        {name: 'situacionActual'},
                                                        {name: 'nombreReunion'},
		                                                {name:'fechaProgramada', type:'date', dateFormat:'Y-m-d H:i:s'},
	                                                    {name:'duracion'},
                                                        {name: 'meetingID'},
                                                        {name: 'maxParticipantes'},
                                                        {name: 'permiteGrabacion'},
                                                        {name: 'grabarAlIniciar'},
                                                        {name: 'permiteDetenerIniciarGrabacion'},
                                                        {name: 'webCamSoloModerador'},
                                                        {name: 'silencioAlIniciar'},
                                                        {name: 'permitirDesSileciarParticipantes'},
                                                        {name: 'deshabilitarCamaraParticipantes'},
                                                        {name: 'deshabilitarMicrofonoParticipantes'},
                                                        {name: 'deshabilitarChatPrivado'},
                                                        {name: 'deshabilitarChatPublico'},
                                                        {name: 'deshabilitarNotas'},
                                                        {name: 'iniciarAlIngresarModerador'},
                                                        {name: 'participantesConsiderados'},
                                                        {name: 'comentariosCancelacion'}
                                                        
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_VideoConferencias.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaInicial', direction: 'ASC'},
                                                            groupField: 'fechaInicial',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	var btnEditMeeting=gEx('btnEditMeeting');
                                        btnEditMeeting.disable();
                                        var btnConfMeeting=gEx('btnConfMeeting');
                                        btnConfMeeting.disable();
                                        var btnCancelMeeting=gEx('btnCancelMeeting');
                                        btnCancelMeeting.disable();
                                    	proxy.baseParams.funcion='1';
                                    }
                        )   



                                                        
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'situacionActual',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var pos=existeValorMatriz(arrSituacionConferencia,val);
                                                                           
                                                                            return '<img src="'+arrSituacionConferencia[pos][2]+'" title="'+arrSituacionConferencia[pos][1]+'" alt="'+arrSituacionConferencia[pos][1]+'" width="16" height="16"/>';
                                                                        }
                                                            },
                                                             
                                                            {
                                                                header:'Situaci&oacute;n actual',
                                                                width:220,
                                                                
                                                                sortable:true,
                                                                dataIndex:'situacionActual',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var comp='';
                                                                            if(registro.data.comentariosCancelacion!='')
                                                                            {
                                                                            	comp='<img src="../images/icon_comment.gif" title="'+escaparBR(registro.data.comentariosCancelacion,true)+'" alt="'+escaparBR(registro.data.comentariosCancelacion,true)+'" />&nbsp;&nbsp;';
                                                                            }
                                                                        	return comp+formatearValorRenderer(arrSituacionConferencia,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'T&iacute;tulo',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'nombreReunion',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Fecha de Reuni&oacute;n',
                                                                width:120,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'fechaProgramada',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            {
                                                                header:'Duraci&oacute;n Estimada<br />(minutos)',
                                                                width:120,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'duracion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val;
                                                                        }
                                                            }
                                                            ,
                                                            {
                                                                header:'ID de Reuni&oacute;n',
                                                                width:180,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'meetingID',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Participantes',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'participantesConsiderados',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Esperar a Moderador<br>Para Iniciar Reuni&oacute;n',
                                                                width:140,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'iniciarAlIngresarModerador',
                                                                renderer:rendererSiNo
                                                            },
                                                            {
                                                                header:'Permitir Grabar<br>la Reuni&oacute;n',
                                                                width:110,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'permiteGrabacion',
                                                                renderer:rendererSiNo
                                                            },
                                                            {
                                                                header:'Grabar Reuni&oacute;n<br>al Iniciar',
                                                                width:110,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'grabarAlIniciar',
                                                                renderer:rendererSiNo
                                                            },
                                                            
                                                            {
                                                                header:'Permitir Detener/Iniciar<br>la Reuni&oacute;n',
                                                                width:140,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'permiteDetenerIniciarGrabacion',
                                                                renderer:rendererSiNo
                                                            },
                                                            {
                                                                header:'Mostrar C&aacute;maras<br>s&oacute;lo al Moderador',
                                                                width:160,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'webCamSoloModerador',
                                                                renderer:rendererSiNo
                                                            },
                                                            {
                                                                header:'Silenciar Participantes<br>al Iniciar la Reuni&oacute;n',
                                                                width:150,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'silencioAlIniciar',
                                                                renderer:rendererSiNo
                                                            },
                                                            {
                                                                header:'Permitir Control de<br>Microfonos al Moderador',
                                                                width:150,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'permitirDesSileciarParticipantes',
                                                                renderer:rendererSiNo
                                                            }
                                                            ,
                                                            {
                                                                header:'Deshabilitar C&aacute;mara<br>a Participantes',
                                                                width:140,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'deshabilitarCamaraParticipantes',
                                                                renderer:rendererSiNo
                                                            }
                                                            ,{
                                                                header:'Deshabilitar Micr&oacute;fono<br>a Participantes',
                                                                width:140,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'deshabilitarMicrofonoParticipantes',
                                                                renderer:rendererSiNo
                                                            }
                                                            ,{
                                                                header:'Deshabilitar Chat<br>Privado',
                                                                width:110,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'deshabilitarChatPrivado',
                                                                renderer:rendererSiNo
                                                            }
                                                            ,{
                                                                header:'Deshabilitar Chat<br>P&uacute;blico',
                                                                width:110,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'deshabilitarChatPublico',
                                                                renderer:rendererSiNo
                                                            }
                                                            ,{
                                                                header:'Deshabilitar Notas',
                                                                width:120,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'deshabilitarNotas',
                                                                renderer:rendererSiNo
                                                            }
                                                           ,
                                                            {
                                                                header:'Fecha de Registro',
                                                                width:120,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            {
                                                                header:'Registrado por',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'idResponsableRegistro',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );


                                                    
    var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gReunionesProgramadas',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                id:'btnAddMeeting',
                                                                                text:'Programar Nueva Reuni&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                        	eventoClone=false;
	                                                                                    	mostrarVentanaConfReunion(); 
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                id:'btnEditMeeting',
                                                                                disabled:true,
                                                                                text:'Modificar Reuni&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                        	eventoClone=false;
                                                                                        	var fila=gEx('gReunionesProgramadas').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la reuni&oacute;n que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            mostrarVentanaConfReunion(fila);
                                                                                        }
                                                                                
                                                                            }
                                                                            ,'-',
                                                                            {
                                                                                icon:'../images/icon_big_tick.gif',
                                                                                cls:'x-btn-text-icon',
                                                                                id:'btnConfMeeting',
                                                                                disabled:true,
                                                                                text:'Confirmar Reuni&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=gEx('gReunionesProgramadas').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la reuni&oacute;n que desea confirmar');
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
                                                                                                            gEx('gReunionesProgramadas').getStore().reload();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_VideoConferencias.php',funcAjax, 'POST','funcion=6&idReunion='+fila.data.idRegistro,true);

                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer confirmar la reuni&oacute;n?',resp);
                                                                                            
                                                                                        }
                                                                                
                                                                            }
                                                                            ,'-',
                                                                            {
                                                                                icon:'../images/cross.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                id:'btnCancelMeeting',
                                                                                text:'Cancelar Reuni&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=gEx('gReunionesProgramadas').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la reuni&oacute;n que desea cancelar');
                                                                                            	return;
                                                                                            }
                                                                                            mostrarVentanaCancelacion(fila);
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/page_white_stack.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                id:'btnCloneMeeting',
                                                                                text:'Clonar Reuni&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                        	eventoClone=true;
                                                                                            var fila=gEx('gReunionesProgramadas').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la reuni&oacute;n que desea c');
                                                                                            	return;
                                                                                            }
                                                                                            mostrarVentanaConfReunion(fila);
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
	tblGrid.getSelectionModel().on('rowselect',function(sm,numFila,registro)
    											{
                                                	
													gEx('btnCloneMeeting').enable();
                                                    var btnEditMeeting=gEx('btnEditMeeting');
                                                    btnEditMeeting.disable();
                                                    var btnConfMeeting=gEx('btnConfMeeting');
                                                    btnConfMeeting.disable();
                                                    var btnCancelMeeting=gEx('btnCancelMeeting');
                                                    btnCancelMeeting.disable();
                                                	switch(registro.data.situacionActual)
                                                    {
                                                    	case '0':
                                                        	btnEditMeeting.enable();
                                                            btnConfMeeting.enable();
                                                            btnCancelMeeting.enable();
                                                        break;
                                                        case '1':
                                                        	btnCancelMeeting.enable();
                                                        break;
                                                        case '2':
                                                        break;
                                                        case '3':
                                                        break;
                                                        case '4':
                                                        break;
                                                    }
                                                }
    							)

	tblGrid.getSelectionModel().on('rowdeselect',function(sm,numFila,registro)
    											{
                                                	
													gEx('btnCloneMeeting').disable();
                                                    var btnEditMeeting=gEx('btnEditMeeting');
                                                    btnEditMeeting.disable();
                                                    var btnConfMeeting=gEx('btnConfMeeting');
                                                    btnConfMeeting.disable();
                                                    var btnCancelMeeting=gEx('btnCancelMeeting');
                                                    btnCancelMeeting.disable();
                                                	
                                                }
    							)
                                
    return 	tblGrid;	
}


function rendererSiNo(val)
{
	var color='900';
    
    if(val=='1')
    	color='003C08';
    
	return '<span style="color:#'+color+'"><b>'+formatearValorRenderer(arrSiNo,val)+'</b></span>';
}


function mostrarVentanaConfReunion(filaReunion,arrContactos)
{
    var cmbHoraInicial=crearComboExt('cmbHoraInicial',arregloValores,260,45,80);
	cmbHoraInicial.setValue('<?php echo date("H:i")?>');
    
    var cmbGrabarReunion=crearComboExt('cmbGrabarReunion',arrSiNo,230,5,80);
    cmbGrabarReunion.setValue('1');
    
    var cmbGrabarReunionAlIniciar=crearComboExt('cmbGrabarReunionAlIniciar',arrSiNo,620,5,80);
    cmbGrabarReunionAlIniciar.setValue('0');
    
    var cmbPermitirDetenerIniciar=crearComboExt('cmbPermitirDetenerIniciar',arrSiNo,230,35,80);
    cmbPermitirDetenerIniciar.setValue('1');
    
    var cmbMostrarCamarasModerador=crearComboExt('cmbMostrarCamarasModerador',arrSiNo,620,35,80);
    cmbMostrarCamarasModerador.setValue('0');
    
    
    var cmbIniciarSilencio=crearComboExt('cmbIniciarSilencio',arrSiNo,230,65,80);
    cmbIniciarSilencio.setValue('1');
    
    var cmbPermiteControlMicrofono=crearComboExt('cmbPermiteControlMicrofono',arrSiNo,620,65,80);
    cmbPermiteControlMicrofono.setValue('1');
    
    var cmbDeshabilitarCamara=crearComboExt('cmbDeshabilitarCamara',arrSiNo,230,95,80);
    cmbDeshabilitarCamara.setValue('0');
    
    var cmbDeshabilitarMicrofono=crearComboExt('cmbDeshabilitarMicrofono',arrSiNo,620,95,80);
    cmbDeshabilitarMicrofono.setValue('0');
    
    var cmbDeshabilitarChatPrivado=crearComboExt('cmbDeshabilitarChatPrivado',arrSiNo,230,125,80);
    cmbDeshabilitarChatPrivado.setValue('0');
    
    var cmbDeshabilitarChatPublico=crearComboExt('cmbDeshabilitarChatPublico',arrSiNo,620,125,80);
    cmbDeshabilitarChatPublico.setValue('0');
    
    var cmbDeshabilitarNotas=crearComboExt('cmbDeshabilitarNotas',arrSiNo,230,155,80);
    cmbDeshabilitarNotas.setValue('0');
    
    var cmbEsperarModerador=crearComboExt('cmbEsperarModerador',arrSiNo,620,155,80);
    cmbEsperarModerador.setValue('0');
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            id:'panelReunion',
                                                            activeTab:0,
                                                            region:'center',
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            title:'Datos Generales',
                                                                            items:	[
                                                                            			{
                                                                                        	x:10,
                                                                                            y:10,
                                                                                            xtype:'label',
                                                                                            html:'<b>T&iacute;tulo de la Reuni&oacute;n:</b>'
                                                                                        },
                                                                                        {
                                                                                        	x:150,
                                                                                            y:5,
                                                                                            xtype:'textarea',
                                                                                            width:550,
                                                                                            height:35,
                                                                                            id:'txtTitulo'
                                                                                        },
                                                                                        {
                                                                                        	x:10,
                                                                                            y:50,
                                                                                            xtype:'label',
                                                                                            html:'<b>Fecha de la Reuni&oacute;n:</b>'
                                                                                        },
                                                                                        {
                                                                                        	x:150,
                                                                                            y:45,
                                                                                        	xtype:'datefield',
                                                                                            id:'dteFechaReunion',
                                                                                            value:'<?php echo date("Y-m-d")?>'
                                                                                        },
                                                                                        cmbHoraInicial,
                                                                                        {
                                                                                        	x:400,
                                                                                            y:50,
                                                                                            xtype:'label',
                                                                                            html:'<b>Duraci&oacute;n Estimada (min.):</b>'
                                                                                        },
                                                                                        {
                                                                                        	x:570,
                                                                                            y:45,
                                                                                            xtype:'numberfield',
                                                                                            allowDecimals:false,
                                                                                            allowNegative:false,
                                                                                            width:60,
                                                                                            value:60,
                                                                                            id:'txtDuracion'
                                                                                        },
                                                                                        crearGridParticipantes(filaReunion?filaReunion.data.idRegistro:'-1',arrContactos)
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            title:'Configuraciones Especiales',
                                                                            items:	[
                                                                            			{
                                                                                        	x:10,
                                                                                            y:10,
                                                                                            xtype:'label',
                                                                                            html:'<b>Permitir Grabar la Reuni&oacute;n:</b>'
                                                                                        },
                                                                                        cmbGrabarReunion,
                                                                                        {
                                                                                        	x:340,
                                                                                            y:10,
                                                                                            xtype:'label',
                                                                                            html:'<b>Grabar la Reuni&oacute;n Automaticamente al Iniciar:</b>'
                                                                                        },
                                                                                        cmbGrabarReunionAlIniciar,
                                                                                        {
                                                                                        	x:10,
                                                                                            y:40,
                                                                                            xtype:'label',
                                                                                            html:'<b>Permitir Detener/Iniciar Grabaci&oacute;n:</b>'
                                                                                        },
                                                                                        cmbPermitirDetenerIniciar,
                                                                                        {
                                                                                        	x:340,
                                                                                            y:40,
                                                                                            xtype:'label',
                                                                                            html:'<b>Mostrar C&aacute;maras S&oacute;lo al Moderador:</b>'
                                                                                        },
                                                                                        cmbMostrarCamarasModerador,
                                                                                        {
                                                                                        	x:10,
                                                                                            y:70,
                                                                                            xtype:'label',
                                                                                            html:'<b>Iniciar Todos en Silencio (Mute):</b>'
                                                                                        },
                                                                                        cmbIniciarSilencio,
                                                                                        {
                                                                                        	x:340,
                                                                                            y:70,
                                                                                            xtype:'label',
                                                                                            html:'<b>Pemitir el Control de Microfonos al Moderador:</b>'
                                                                                        },
                                                                                        cmbPermiteControlMicrofono,
                                                                                         {
                                                                                        	x:10,
                                                                                            y:100,
                                                                                            xtype:'label',
                                                                                            html:'<b>Deshabilitar C&aacute;mara a Participantes:</b>'
                                                                                        },
                                                                                        cmbDeshabilitarCamara,
                                                                                        {
                                                                                        	x:340,
                                                                                            y:100,
                                                                                            xtype:'label',
                                                                                            html:'<b>Deshabilitar Microfono a Participantes:</b>'
                                                                                        },
                                                                                        cmbDeshabilitarMicrofono,
                                                                                        {
                                                                                        	x:10,
                                                                                            y:130,
                                                                                            xtype:'label',
                                                                                            html:'<b>Deshabilitar Chat Privado:</b>'
                                                                                        },
                                                                                        cmbDeshabilitarChatPrivado,
                                                                                        {
                                                                                        	x:340,
                                                                                            y:130,
                                                                                            xtype:'label',
                                                                                            html:'<b>Deshabilitar Chat P&uacute;blico:</b>'
                                                                                        },
                                                                                        cmbDeshabilitarChatPublico,
                                                                                         {
                                                                                        	x:10,
                                                                                            y:160,
                                                                                            xtype:'label',
                                                                                            html:'<b>Deshabilitar Notas:</b>'
                                                                                        },
                                                                                        cmbDeshabilitarNotas,
                                                                                        {
                                                                                        	x:340,
                                                                                            y:160,
                                                                                            xtype:'label',
                                                                                            html:'<b>Esperar al Moderador para Iniciar Reuni&oacute;n:</b>'
                                                                                        },
                                                                                        cmbEsperarModerador
                                                                               
                                                                            		]
                                                                        }
                                                            		]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: filaReunion?'Modificar Reuni&oacute;n':'Programar Nueva Reuni&oacute;n',
										width: 770,
										height:380,
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
                                                                	gEx('txtTitulo').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
                                                                    	var txtTitulo=gEx('txtTitulo');
                                                                        if(txtTitulo.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	gEx('panelReunion').setActiveTab(0);
                                                                            	txtTitulo.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el t&iacute;tulo de la reuni&oacute;n',resp1)
                                                                            return;
                                                                        }
                                                                        var dteFechaReunion=gEx('dteFechaReunion');
                                                                        
                                                                        if(dteFechaReunion.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	gEx('panelReunion').setActiveTab(0);
                                                                            	dteFechaReunion.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la fecha de la reuni&oacute;n',resp2)
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbHoraInicial.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	gEx('panelReunion').setActiveTab(0);
                                                                            	cmbHoraInicial.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la hora de la reuni&oacute;n',resp3)
                                                                            return;
                                                                        }
                                                                        
                                                                        var txtDuracion=gEx('txtDuracion');
                                                                        
                                                                        if(txtDuracion.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	gEx('panelReunion').setActiveTab(0);
                                                                            	txtDuracion.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la duraci&oacute;n de la reuni&oacute;n',resp4)
                                                                            return;
                                                                        }
                                                                        
                                                                        var arrParticipantes='';
                                                                        var x;
                                                                        var fila;
                                                                        var gParticipantes=gEx('gParticipantes');
                                                                        var o;
                                                                        var totalParticipantes=0;
                                                                        var existeModerador=0;
                                                                        for(x=0;x<gParticipantes.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gParticipantes.getStore().getAt(x);
                                                                            o='{"idParticipante":"'+fila.data.idParticipante+'","nombreParticipante":"'+cv(fila.data.nombreParticipante)+
                                                                            '","tipoParticipacion":"'+fila.data.tipoParticipacion+'","email":"'+fila.data.email+'","noParticipantes":"'+
                                                                            fila.data.noParticipantes+'","tipoParticipante":"'+fila.data.tipoParticipante+'","telefono":"'+
                                                                            fila.data.telefono+'"}';
                                                                            totalParticipantes+=parseInt(fila.data.noParticipantes);
                                                                            
                                                                            if(arrParticipantes=='')
                                                                            {
                                                                            	arrParticipantes=o;
                                                                            }
                                                                            else
                                                                            {
	                                                                            arrParticipantes+=','+o;
                                                                            }
                                                                            
                                                                            if(fila.data.tipoParticipacion=='1')
                                                                            {
                                                                            	existeModerador=true;
                                                                            }
                                                                        }
                                                                        
                                                                        if(!existeModerador)
                                                                        {
                                                                        	gEx('panelReunion').setActiveTab(0);
                                                                        	msgBox('Debe registrar almenos un participante que funja como <b>Moderador</b>');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var idReunion=-1;
                                                                        if((filaReunion)&&(!eventoClone))
                                                                        {
                                                                        	idReunion=filaReunion.data.idRegistro;
                                                                        }
                                                                        
                                                                       var confSesion='{"permiteGrabacion":"'+cmbGrabarReunion.getValue()+'","grabarAlIniciar":"'+cmbGrabarReunionAlIniciar.getValue()+
                                                                        				'","permiteDetenerIniciarGrabacion":"'+cmbPermitirDetenerIniciar.getValue()+'","webCamSoloModerador":"'+cmbMostrarCamarasModerador.getValue()+
                                                                                        '","silencioAlIniciar":"'+cmbIniciarSilencio.getValue()+'","permitirDesSileciarParticipantes":"'+cmbPermiteControlMicrofono.getValue()+
                                                                                        '","deshabilitarCamaraParticipantes":"'+cmbDeshabilitarCamara.getValue()+'","deshabilitarMicrofonoParticipantes":"'+cmbDeshabilitarMicrofono.getValue()+
                                                                                        '","deshabilitarChatPrivado":"'+cmbDeshabilitarChatPrivado.getValue()+'","deshabilitarChatPublico":"'+cmbDeshabilitarChatPublico.getValue()+
                                                                                        '","deshabilitarNotas":"'+cmbDeshabilitarNotas.getValue()+'","iniciarAlIngresarModerador":"'+cmbEsperarModerador.getValue()+'"}';


																		var cadObj='{"tituloReunion":"'+cv(txtTitulo.getValue())+'","fechaReunion":"'+(dteFechaReunion.getValue().format('Y-m-d')+' '+cmbHoraInicial.getValue())+
                                                                        			'","duracionEstimada":"'+txtDuracion.getValue()+'","participantes":['+arrParticipantes+
                                                                                    '],"totalParticipantes":"'+totalParticipantes+'","idReunion":"'+idReunion+'","confSesion":'+confSesion+'}';
																	
                                                                    	
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gReunionesProgramadas').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_VideoConferencias.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                        
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
    if(filaReunion)
    {

        gEx('txtTitulo').setValue(escaparBR(filaReunion.data.nombreReunion,true));
        if(!eventoClone)
        {
            gEx('dteFechaReunion').setValue(filaReunion.data.fechaProgramada.format('Y-m-d'));
            cmbHoraInicial.setValue(filaReunion.data.fechaProgramada.format('H:i'));
		}
        gEx('txtDuracion').setValue(filaReunion.data.duracion);
        
        cmbGrabarReunion.setValue(filaReunion.data.permiteGrabacion),
        cmbGrabarReunionAlIniciar.setValue(filaReunion.data.grabarAlIniciar),
        cmbPermitirDetenerIniciar.setValue(filaReunion.data.permiteDetenerIniciarGrabacion),
        cmbMostrarCamarasModerador.setValue(filaReunion.data.webCamSoloModerador),
        cmbIniciarSilencio.setValue(filaReunion.data.silencioAlIniciar),
        cmbPermiteControlMicrofono.setValue(filaReunion.data.permitirDesSileciarParticipantes),
        cmbDeshabilitarCamara.setValue(filaReunion.data.deshabilitarCamaraParticipantes),
        cmbDeshabilitarMicrofono.setValue(filaReunion.data.deshabilitarMicrofonoParticipantes),
        cmbDeshabilitarChatPrivado.setValue(filaReunion.data.deshabilitarChatPrivado),
        cmbDeshabilitarChatPublico.setValue(filaReunion.data.deshabilitarChatPublico),
        cmbDeshabilitarNotas.setValue(filaReunion.data.deshabilitarNotas),
        cmbEsperarModerador.setValue(filaReunion.data.iniciarAlIngresarModerador)
        
        
    }
}


function crearGridParticipantes(idReunion,arrContactos)
{
	var cmbTipoParticipacion=crearComboExt('cmbTipoParticipacion',arrRolesReunion);
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idParticipante'},
		                                                {name: 'nombreParticipante'},
		                                                {name:'tipoParticipacion'},
		                                                {name:'email'},
                                                        {name:'telefono'},
                                                        {name: 'tipoParticipante'},
                                                        {name:'noParticipantes'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_VideoConferencias.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreParticipante', direction: 'ASC'},
                                                            groupField: 'tipoParticipacion',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='4';
                                        proxy.baseParams.idReunion=idReunion;
                                    }
                        )   
                        
	alDatos.on('load',function(proxy)
    								{
                                    	if(arrContactos)
                                        	cargarContactos(arrContactos);
                                    }
                        )                           
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            
                                                            {
                                                                header:'Nombre del Participante',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'nombreParticipante',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Rol del Participante',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'tipoParticipacion',
                                                                editor:cmbTipoParticipacion,
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var comp='';
                                                                            if(registro.data.noParticipantes!='1')
                                                                            {
                                                                            	comp=' <span title="('+registro.data.noParticipantes+') participantes" alt="('+registro.data.noParticipantes+') participantes">('+registro.data.noParticipantes+')</span>';
                                                                            }
                                                                        	return formatearValorRenderer(arrRolesReunion,val)+comp;
                                                                        }
                                                                        
                                                            },
                                                            
                                                            {
                                                                header:'Correo Electr&oacute;nico',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'email',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
                                                                        
                                                            },
                                                            {
                                                                header:'Tel&eacute;fono',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'telefono',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
                                                                        
                                                            }
                                                        ]
                                                    );
                                                    
    var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gParticipantes',
                                                                store:alDatos,
                                                                x:10,
                                                                y:80,
                                                                height:180,
                                                                width:710,
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
                                                                                text:'Agregar Participante',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaAgregarParticipante();
                                                                                        }
                                                                                
                                                                            },
                                                                            '-',
                                                                            {
                                                                                icon:'../images/area.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar Grupo',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaAgregarGrupoReunion();
                                                                                        }
                                                                                
                                                                            },
                                                                            '-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover Participante',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=gEx('gParticipantes').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el participante que desea remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	gEx('gParticipantes').getStore().remove(fila);
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover al participante seleccionado?',resp);
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

function mostrarVentanaAgregarParticipante()
{
	var tipoUsuarioSistema=-1;
	var idUsuario=-1;
	var oConf=	{
    					idCombo:'cmbNombreParticipante',
                        anchoCombo:300,
                        posX:180,
                        posY:35,
                        raiz:'registros',
                        campoDesplegar:'nombreUsuario',
                        campoID:'idUsuario',
                        funcionBusqueda:2,
                        paginaProcesamiento:'../paginasFunciones/funcionesModulosEspeciales_VideoConferencias.php',
                        confVista:'<tpl for="."><div class="search-item">[{idUsuario}] {nombreUsuario}<br>{institucion}<br>({eMail})</div></tpl>',
                        campos:	[
                                   	{name:'idUsuario'},
                                    {name:'nombreUsuario'},
                                    {name: 'roles'},
                                    {name: 'eMail'},
                                    {name: 'arrTelefonos'},
                                    {name: 'institucion'},
                                    {name: 'tipoUsuario'}

                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	idUsuario=-1;
                                    	var aValor=combo.getRawValue();
										dSet.baseParams.criterio=aValor;
                                        
                                        
                                    },
                      	funcElementoSel:function(combo,registro)
                    				{
                                    	var x;
                                    	var reg=crearRegistro([{name:'eMail'}]);
                                        var regTel=crearRegistro([{name:'cvePais'},{name:'lada'},{name:'numero'}]);
                                    	idUsuario=registro.data.idUsuario;
                                        tipoUsuarioSistema=registro.data.tipoUsuario;
                                        var direccionMail=registro.data.eMail;
                                        gEx('gMailInvitacion').getStore().removeAll();
                                        gEx('gTelefonos').getStore().removeAll();
                                        
                                        if(direccionMail!='Sin direcci&oacute;n de correo registrado')
                                        {
                                        	var arrMails=direccionMail.split(',');
                                            
                                            for(x=0;x<arrMails.length;x++)
                                            {
                                            	
												 var r=new reg({eMail:arrMails[x]});
                                                 gEx('gMailInvitacion').getStore().add(r);
                                            }
                                        }
                                        
                                        
                                        var fila;
                                        for(x=0;x<registro.data.arrTelefonos.length;x++)
                                        {
                                            var r=new regTel({cvePais:registro.data.arrTelefonos[x].codPais,lada:registro.data.arrTelefonos[x].lada,numero:registro.data.arrTelefonos[x].numero});
                                            gEx('gTelefonos').getStore().add(r);
                                        }
                                        
                                    }  
    				};

	var cmbNombreParticipante=crearComboExtAutocompletar(oConf);
    cmbNombreParticipante.hide();
	
	var cmbTipoParticipante=crearComboExt('cmbTipoParticipante',arrTipoParticipante,180,5,180);
    cmbTipoParticipante.setValue('2');
    
    cmbTipoParticipante.on('select',function(cmb,registro)
    								{
                                    	switch(registro.data.id)
                                        {
                                        	case '1':
                                            	gEx('cmbNombreParticipante').show();
                                                gEx('txtNombreParticipante').setValue('');
                                                gEx('txtNombreParticipante').hide();
                                                gEx('gMailInvitacion').getStore().removeAll();
                                                gEx('cmbNombreParticipante').focus();
                                                gEx('txtNombreParticipante').enable();
                                                gEx('cmbRolParticipante').enable();
                                                gEx('lblNumeroParticipantes1').hide();
                                                gEx('totalParticipantes').hide();
                                                gEx('totalParticipantes').setValue(1);
                                                gEx('lblNumeroParticipantes2').hide();
                                                
                                                
                                            break;
                                            case '2':
                                            	gEx('cmbNombreParticipante').hide();
                                                gEx('cmbNombreParticipante').setValue('');
                                                gEx('txtNombreParticipante').show();
                                                gEx('txtNombreParticipante').setValue('');
                                                gEx('gMailInvitacion').getStore().removeAll();
                                                gEx('txtNombreParticipante').focus();
                                                gEx('txtNombreParticipante').enable();
                                                gEx('cmbRolParticipante').enable();
                                                gEx('lblNumeroParticipantes1').hide();
                                                gEx('totalParticipantes').hide();
                                                gEx('totalParticipantes').setValue(1);
                                                gEx('lblNumeroParticipantes2').hide();
                                            break;
                                            case '3':
                                            	gEx('cmbNombreParticipante').hide();
                                                gEx('cmbNombreParticipante').setValue('');
                                                gEx('txtNombreParticipante').show();
                                                gEx('txtNombreParticipante').setValue('Invitado');
                                                gEx('txtNombreParticipante').disable();
                                                gEx('gMailInvitacion').getStore().removeAll();
                                                gEx('cmbRolParticipante').disable();
                                                gEx('cmbRolParticipante').setValue('2');
                                                gEx('lblNumeroParticipantes1').show();
                                                gEx('totalParticipantes').show();
                                                gEx('totalParticipantes').setValue(2);
                                                gEx('lblNumeroParticipantes2').show();
                                            break;
                                        }
                                    }
    						)
    
    var cmbRolParticipante=crearComboExt('cmbRolParticipante',arrRolesReunion,180,65,140);
    cmbRolParticipante.setValue('2');
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'<b>Tipo de Participante:</b>'
                                                        },
                                                        cmbTipoParticipante,
                                                        {
                                                        	x:375,
                                                            y:10,
                                                            hidden:true,
                                                            id:'lblNumeroParticipantes1',
                                                            html:'<b>#</b>'
                                                        },
                                                        {
                                                        	x:390,
                                                            y:5,
                                                            id:'totalParticipantes',
                                                            xtype:'numberfield',
                                                            width:40,
                                                            value:1,
                                                            hidden:true,
                                                            allowDecimals:false,
                                                            allowNegative:false
                                                        },
                                                        {
                                                        	x:440,
                                                            y:10,
                                                            hidden:true,
                                                            id:'lblNumeroParticipantes2',
                                                            html:'<b>Participantes</b>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'<b>Nombre del Participante:</b>'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:35,
                                                            width:300,
                                                            id:'txtNombreParticipante',
                                                            xtype:'textfield'
                                                        },
                                                        cmbNombreParticipante,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'<b>Rol dentro de la reuni&oacute;n:</b>'
                                                        }	,
                                                        cmbRolParticipante,
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'<b>Direcci&oacute;n de correo electr&oacute;nico al que se enviar&aacute; la invitaci&oacute;n:</b>'
                                                        },
                                                        crearGridMail()	,
                                                        crearGridTelefono()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Participante',
										width: 680,
										height:360,
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
                                                                	gEx('txtNombreParticipante').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',                                                            
															handler: function()
																	{
																		var tipoParticipante=	gEx('cmbTipoParticipante').getValue();
                                                                        var txtNombreParticipante=gEx('txtNombreParticipante');
                                                                        if(tipoParticipante=='1')
                                                                        {
                                                                        	if(idUsuario==-1)
                                                                            {
                                                                            	function respAux()
                                                                                {
                                                                                	cmbNombreParticipante.focus();
                                                                                }
                                                                                msgBox('Debe indicar el usuario que desea agregar como participante',respAux);
                                                                                return;
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                        	if(txtNombreParticipante=='')
                                                                            {
                                                                            	function respAux2()
                                                                                {
                                                                                	txtNombreParticipante.focus();
                                                                                }
                                                                                msgBox('Debe indicar el nombre de la persona que desea agregar como participante',respAux2);
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        var emailContacto='';
                                                                        var gMailInvitacion=gEx('gMailInvitacion');
                                                                        var x;
                                                                        var fila;
                                                                        for(x=0;x<gMailInvitacion.getStore().getCount();x++)
                                                                     	{
                                                                        	fila=gMailInvitacion.getStore().getAt(x);
                                                                            
                                                                            if(!validarCorreo(fila.data.eMail))
                                                                            {
                                                                            	function respAux2()
                                                                                {
                                                                            		gMailInvitacion.startEditing(x,1);
                                                                            	}
                                                                                msgBox('La direcci&oacute;n de correo ingresado no es v&aacute;lida',respAux2);
                                                                                return;
                                                                            }
                                                                            if(emailContacto=='')
                                                                            {
                                                                            	emailContacto=fila.data.eMail;
                                                                            }
                                                                            else
                                                                            {
                                                                            	emailContacto+=','+fila.data.eMail;
                                                                            }
                                                                            
                                                                        }
                                                                        
                                                                        /*if((emailContacto=='')&&(tipoParticipante!='3'))
                                                                        {
                                                                        	msgBox('Debe ingresar almenos una direcci&oacute;n de correo electr&oacute;co para recibir la invitaci&oacute;n');
                                                                        	return;
                                                                        }*/
                                                                        var arrTelefonos='';
                                                                        var gTelefonos=gEx('gTelefonos');
                                                                        var telefono='';
                                                                        for(x=0;x<gTelefonos.getStore().getCount();x++)
                                                                     	{
                                                                        	fila=gTelefonos.getStore().getAt(x);
                                                                            telefono='('+fila.data.cvePais+') '+fila.data.lada+'-'+fila.data.numero;
                                                                            if((telefono.length-fila.data.cvePais.length-3)!=11)
                                                                            {
                                                                            	function respAux2()
                                                                                {
                                                                            		gTelefonos.startEditing(x,1);
                                                                            	}
                                                                                msgBox('Debe ingresar el n&uacute;mero de tel&eacute;fono a 10 d&iacute;gitos',respAux2);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(arrTelefonos=='')
                                                                            	arrTelefonos=telefono;
                                                                            else
                                                                            	arrTelefonos+=','+telefono;
                                                                           
                                                                            
                                                                        }
                                                                        
                                                                        
                                                                        var rParticipante=crearRegistro (
                                                                        									[
                                                                                                            	{name:'idParticipante'},
                                                                                                                {name: 'nombreParticipante'},
                                                                                                                {name:'tipoParticipante'},
                                                                                                                {name:'tipoParticipacion'},
                                                                                                                {name:'email'},
                                                                                                                {name:'telefono'},
                                                                                                                {name: 'noParticipantes'}
                                                                                                            ]
                                                                        								)
                                                                        
																		var r=new rParticipante	(
                                                                        							{
                                                                                                    	idParticipante:(tipoParticipante=='1' && tipoUsuarioSistema=='1')?idUsuario:'-1',
                                                                                                        nombreParticipante:tipoParticipante=='1'?cmbNombreParticipante.getRawValue():txtNombreParticipante.getValue(),
                                                                                                        tipoParticipante:cmbTipoParticipante.getValue(),
                                                                                                        tipoParticipacion:cmbRolParticipante.getValue(),
                                                                                                        email:emailContacto,
                                                                                                        telefono:arrTelefonos,
                                                                                                        noParticipantes:gEx('totalParticipantes').getValue()==''?1:gEx('totalParticipantes').getValue()
                                                                                                        
                                                                                                    }
                                                                        						)
                                                                    
                                                                    	gEx('gParticipantes').getStore().add(r);
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

function crearGridMail()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'eMail'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
														{
															header:'Direcci&oacute;n de correo',
															width:320,
                                                            editor:{xtype:'textfield'},
															sortable:true,
															dataIndex:'eMail'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            y:130,
                                                            x:10,
                                                            id:'gMailInvitacion',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            height:140,
                                                            width:380,
                                                            clicksToEdit:1,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar direcci&oacute;n de correo',
                                                                            handler:function()
                                                                            		{
                                                                                    	var reg=crearRegistro([{name:'eMail'}]);
                                                                                        var r=new reg({eMail:''});
                                                                                        gEx('gMailInvitacion').getStore().add(r);
                                                                                        gEx('gMailInvitacion').startEditing(0,1);
                                                                                        
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover direcci&oacute;n de correo',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gMailInvitacion').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la direcci&oacute;n de correo electr&oacute;nico que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	gEx('gMailInvitacion').getStore().remove(fila);
                                                                                            }
                                                                                            
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover la direcci&oacute;n de correo electr&oacute;nico solicitada?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function crearGridTelefono()
{
	var cmbTipoTelefono=crearComboExt('cmbTipoTelefono',arrTelefonos);
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'cvePais'},
                                                                    {name: 'lada'},
                                                                    {name: 'numero'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
														{
															header:'Pa&iacute;s',
															width:45,
															sortable:true,
															dataIndex:'cvePais',
                                                            editor:	{
                                                            			xtype:'textfield'
                                                            		}
														},
														{
															header:'Lada',
															width:45,
															sortable:true,
															dataIndex:'lada',
                                                            editor:	{
                                                            			xtype:'textfield'
                                                            		}
														},
                                                        {
															header:'N&uacute;mero',
															width:100,
															sortable:true,
															dataIndex:'numero',
                                                            editor:	{
                                                            			xtype:'textfield'
                                                            		}
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gTelefonos',
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            x:400,
                                                            y:130,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:140,
                                                            width:250,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar tel&eacute;fono',
                                                                            handler:function()
                                                                            		{
                                                                                    	var reg=crearRegistro	(
                                                                                        							[
                                                                                                                    	{name: 'cvePais'},
                                                                                                                        {name: 'lada'},
                                                                                                                        {name: 'numero'}
                                                                                                                    ]
                                                                                        						)
                                                                                   		var r=new reg	(
                                                                                        					{
                                                                                                            	cvePais:'52',
                                                                                                                lada:'',
                                                                                                                numero:''
                                                                                                            }
                                                                                        				)
                                                                                   
                                                                                    	gEx('gTelefonos').getStore().add(r);
                                                                                        gEx('gTelefonos').startEditing(gEx('gTelefonos').getStore().getCount()-1,2);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover tel&eacute;fono',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gTelefonos').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el tel&eacute;fono a remover');
                                                                                        	return;
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	gEx('gTelefonos').getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el tel&eacute;fono seleccionado?',resp);
                                                                                       
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	
   
    return 	tblGrid;	
}

function reenviarInvitacion(iR)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_VideoConferencias.php',funcAjax, 'POST','funcion=5&idRegistro='+bD(iR),true);
    
}

function imprimirInvitacion(iR)
{
	
	
    var arrParametros=[['idRegistro',bD(iR)]]
    enviarFormularioDatos('../modeloConferencias/generarInvitacionLatisMeeting.php',arrParametros,'POST','frameDTD');
    primeraCargaFrame=false;
    
}

function frameLoad(iFrame)
{
	if(!primeraCargaFrame)
    {
    	setTimeout(function()
        			{
                       
                        iFrame.contentWindow.print();
                    },2000
                   );

    }
    else
    	primeraCargaFrame=false;
	
}

function mostrarVentanaCancelacion(fila)
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
                                                            html:'Ingrese el motivo de la cancelaci&oacute;n:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            xtype:'textarea',
                                                            width:550,
                                                            height:60,
                                                            id:'txtMotivoCancelacion'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Motivo de la cancelaci&oacute;n',
										width: 600,
										height:200,
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
                                                                	gEx('txtMotivoCancelacion').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtMotivoCancelacion=gEx('txtMotivoCancelacion');
                                                                        
                                                                        if(txtMotivoCancelacion.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtMotivoCancelacion.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el motivo de la cancelaci&oacute;n',resp1);
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
                                                                                    	ventanaAM.close();
                                                                                        gEx('gReunionesProgramadas').getStore().reload();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_VideoConferencias.php',funcAjax, 'POST','funcion=7&motivo='+cv(txtMotivoCancelacion.getValue())+'&idReunion='+fila.data.idRegistro,true);

                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer cancelar la reuni&oacute;n?',resp);
                                                                        
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

function crearArbolContactos()
{
	var raiz=new  Ext.tree.AsyncTreeNode(
											{
												id:'-1',
												text:'Raiz',
												draggable:false,
												expanded :false,
												cls:'-1'
											}
										)
										
	var cargadorArbol=new Ext.tree.TreeLoader(
                                                {
                                                    baseParams:{
                                                                    funcion:'12',
                                                                    
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_VideoConferencias.php'
                                                }
                                            )		
										
	cargadorArbol.on('beforeload',function(c)
    						{
                            	nodoContactosSel=null;
                               	
                            }
    				)	
    										
	cargadorArbol.on('load',function(c,nodoCarga)
    						{
                            	
                            }
    				)										
	var arbolContactos=new Ext.tree.TreePanel	(
                                                            {
                                                                id:'arbolContactos',
                                                                title:'Contactos/Grupos',
                                                                useArrows:true,
                                                                collapsible:true,
                                                                animate:true,
                                                                enableDD:false,
                                                                ddScroll:true,
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                border:false,
                                                                region:'west',
                                                                root:raiz,
                                                                width:300,
                                                                loader: cargadorArbol,
                                                                rootVisible:false,
                                                                tbar:	[
                                                                			{
                                                                            	id:'btnAddContacto',
                                                                                disabled:true,
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                tooltip:'Crear Contacto/Grupo',
                                                                                handler:function()
                                                                                        {
                                                                                            switch(nodoContactosSel.attributes.tipo)
                                                                                            {
                                                                                                case '0':
                                                                                                    mostrarVentanaAgregarContacto();
                                                                                                break;
                                                                                                case '1':
                                                                                                    mostrarVentanaAgregarGrupo();
                                                                                                break;
                                                                                        	}
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                            	id:'btnModifyContacto',
                                                                                disabled:true,
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                tooltip:'Modificar Contacto/Grupo',
                                                                                handler:function()
                                                                                        {
                                                                                         	if(nodoContactosSel==null)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el contacto/grupo que desea modificar');
                                                                                            	return;
                                                                                            }   
                                                                                            
                                                                                            switch(nodoContactosSel.attributes.tipo)
                                                                                            {
                                                                                            	case '2':
                                                                                                    mostrarVentanaAgregarContacto(nodoContactosSel.id.replace('c_',''));
                                                                                                break;
                                                                                                case '3':
                                                                                                    mostrarVentanaAgregarGrupo(nodoContactosSel.id.replace('g_',''));
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                            	id:'btnDeleteContacto',
                                                                                disabled:true,
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                tooltip:'Remover Contacto/Grupo',
                                                                                handler:function()
                                                                                        {
                                                                                            if(nodoContactosSel==null)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el contacto/grupo que desea remover');
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
                                                                                                            gEx('arbolContactos').getRootNode().reload();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspecialesCorreo.php',funcAjax, 'POST','funcion=9&c='+nodoContactosSel.id.replace('c_','').replace('g_','')+'&t='+nodoContactosSel.attributes.tipo,true);
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover el contacto/grupo seleccionado?',resp);
                                                                                            
                                                                                            
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                id:'btnAddMeetingGroup',
                                                                                text:'Programar Nueva Reuni&oacute;n',
                                                                                handler:function()
                                                                                        {
	                                                                                    	obtenerContactosGrupo(nodoContactosSel.id.replace('g_',''),function(arrContactos)
                                                                                            															{
                                                                                                                                                        	mostrarVentanaConfReunion(null,arrContactos);
                                                                                                                                                            
                                                                                                                                                        }
                                                                                            					);
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                		]
                                                            }
                                                        )
         
         
                                                    
	arbolContactos.on('click',funcSujeto);
	//arbolSujetosJuridicos.on('dblclick',funcSujetodblClick);                           
	return  arbolContactos;
}

function funcSujeto(nodo, evento)
{
	gEx('btnAddContacto').disable();
    gEx('btnModifyContacto').disable();
    gEx('btnDeleteContacto').disable();
    gEx('btnAddMeetingGroup').disable();
	nodoContactosSel=nodo;
    
	switch(nodo.attributes.tipo)
    {
    	case '0':
        	gEx('btnAddContacto').enable();
        break;
        case '1':
        	gEx('btnAddContacto').enable();
           
        break;
        case '2':
        	gEx('btnModifyContacto').enable();
    		gEx('btnDeleteContacto').enable();
        break;
        case '3':
        	gEx('btnModifyContacto').enable();
    		gEx('btnDeleteContacto').enable();
            gEx('btnAddMeetingGroup').enable();
        break;
    }
    
    
    
}


function mostrarVentanaAgregarContacto(idContacto)
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
                                                            html:'Prefijo (Lic, Ing):'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            width:100,
                                                            x:145,
                                                            y:5,
                                                            id:'txtPrefijo'
                                                            
                                                        },
                                            			{
                                                        	x:10,
                                                            y:40,
                                                            html:'Nombre del contacto:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            width:350,
                                                            x:145,
                                                            y:35,
                                                            id:'txtNombreContacto'
                                                            
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Instituci&oacute;n:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            width:450,
                                                            x:145,
                                                            y:65,
                                                            id:'txtInstitucion'
                                                            
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'Puesto:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            width:220,
                                                            x:145,
                                                            y:95,
                                                            id:'txtPuesto'
                                                            
                                                        },
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            html:'Direcci&oacute;n de correo electr&oacute;nico:'
                                                        },
                                                        crearGridEmail(),
                                                        crearGridTelefonoContacto()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: idContacto?'Modificar Contacto':'Crear Contacto',
										width: 680,
										height:400,
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
                                                                	gEx('txtPrefijo').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',                                                            
															handler: function()
																	{
																		var txtNombreContacto=gEx('txtNombreContacto').getValue();
                                                                        if(txtNombreContacto=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	gEx('txtNombreContacto').focus();
                                                                            }
                                                                            msgBox('Debe ingresar el nombre del contacto',resp1);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var arrMails='';
                                                                        var gridMail=gEx('gridMail');
                                                                        var x;
                                                                        var fila;
                                                                        for(x=0;x<gridMail.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gridMail.getStore().getAt(x);
                                                                            if(!validarCorreo(fila.data.email))
                                                                            {
                                                                            	function resp2()
                                                                                {
                                                                                    gEx('gridMail').startEditing(x,1);
                                                                                }
                                                                                msgBox('La direcci&oacute;n de correo electr&oacute;nico ingresada NO es v&aacute;lida',resp2);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(arrMails=='')
                                                                            	arrMails='{"mail":"'+fila.data.email+'"}';
                                                                            else
                                                                            	arrMails+=',{"mail":"'+fila.data.email+'"}';
                                                                        }
                                                                        
                                                                       	/*if(arrMails=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                               
                                                                            }
                                                                            msgBox('Debe ingresar almenos una direcci&oacute;n de correo electr&oacute;nico',resp3);
                                                                            return;
                                                                        } */
                                                                        
                                                                        var arrTelefonos='';
                                                                        var gTelefonos=gEx('gTelefonosContacto');
                                                                        var telefono='';
                                                                        for(x=0;x<gTelefonos.getStore().getCount();x++)
                                                                     	{
                                                                        	fila=gTelefonos.getStore().getAt(x);
                                                                            telefono='('+fila.data.cvePais+') '+fila.data.lada+'-'+fila.data.numero;
                                                                            if((telefono.length-fila.data.cvePais.length-3)!=11)
                                                                            {
                                                                            	function respAux2()
                                                                                {
                                                                            		gTelefonos.startEditing(x,1);
                                                                            	}
                                                                                msgBox('Debe ingresar el n&uacute;mero de tel&eacute;fono a 10 d&iacute;gitos',respAux2);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(arrTelefonos=='')
                                                                            	arrTelefonos=telefono;
                                                                            else
                                                                            	arrTelefonos+=','+telefono;
                                                                           
                                                                            
                                                                        }
                                                                        
                                                                        
                                                                        var cadObj='{"idContacto":"'+(idContacto?idContacto:-1)+'","nombreContacto":"'+cv(txtNombreContacto)+
                                                                        			'","emails":['+arrMails+'],"prefijo":"'+gEx('txtPrefijo').getValue()+
                                                                                    '","arrTelefonos":"'+arrTelefonos+'","institucion":"'+cv(gEx('txtInstitucion').getValue())+
                                                                                    '","puesto":"'+cv(gEx('txtPuesto').getValue())+'"}';
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('arbolContactos').getRootNode().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_VideoConferencias.php',funcAjax, 'POST','funcion=14&cadObj='+cadObj,true);
                                                                        
                                                                        
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
    if(idContacto)
    {
    	gEx('txtPrefijo').setValue(nodoContactosSel.attributes.prefijo);
        gEx('txtNombreContacto').setValue(nodoContactosSel.attributes.nombreContacto);
        gEx('gridMail').getStore().loadData(nodoContactosSel.attributes.arrMails);
        gEx('gTelefonosContacto').getStore().loadData(nodoContactosSel.attributes.arrTelefonos);
        gEx('txtPuesto').setValue(nodoContactosSel.attributes.puesto);
        gEx('txtInstitucion').setValue(nodoContactosSel.attributes.institucion);
    }
}

function crearGridEmail()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'email'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
														{
															header:'Correo Electr&oacute;nico',
															width:325,
                                                            editor: {xtype:'textfield'},
															sortable:true,
															dataIndex:'email'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            y:160,
                                                            x:10,
                                                            id:'gridMail',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            height:150,
                                                            width:380,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar Correo Electr&oacute;nico',
                                                                            handler:function()
                                                                            		{
                                                                                    	var reg=crearRegistro([{'name':'email'}]);
                                                                                        var fila=new reg(	{email:''});
                                                                                    	gEx('gridMail').getStore().add(fila);
                                                                                        gEx('gridMail').startEditing(gEx('gridMail').getStore().getCount()-1,1);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover Correo Electr&oacute;nico',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gridMail').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {	
                                                                                        	msgBox('Debe seleccionar la direcci&oacute;n de correo electr&oacute;nico que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        gEx('gridMail').getStore().remove(fila);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function crearGridTelefonoContacto()
{
	var cmbTipoTelefono=crearComboExt('cmbTipoTelefono',arrTelefonos);
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'cvePais'},
                                                                    {name: 'lada'},
                                                                    {name: 'numero'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
														{
															header:'Pa&iacute;s',
															width:45,
															sortable:true,
															dataIndex:'cvePais',
                                                            editor:	{
                                                            			xtype:'textfield'
                                                            		}
														},
														{
															header:'Lada',
															width:45,
															sortable:true,
															dataIndex:'lada',
                                                            editor:	{
                                                            			xtype:'textfield'
                                                            		}
														},
                                                        {
															header:'N&uacute;mero',
															width:100,
															sortable:true,
															dataIndex:'numero',
                                                            editor:	{
                                                            			xtype:'textfield'
                                                            		}
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gTelefonosContacto',
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            x:400,
                                                            y:160,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:140,
                                                            width:250,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar tel&eacute;fono',
                                                                            handler:function()
                                                                            		{
                                                                                    	var reg=crearRegistro	(
                                                                                        							[
                                                                                                                    	{name: 'cvePais'},
                                                                                                                        {name: 'lada'},
                                                                                                                        {name: 'numero'}
                                                                                                                    ]
                                                                                        						)
                                                                                   		var r=new reg	(
                                                                                        					{
                                                                                                            	cvePais:'52',
                                                                                                                lada:'',
                                                                                                                numero:''
                                                                                                            }
                                                                                        				)
                                                                                   
                                                                                    	gEx('gTelefonosContacto').getStore().add(r);
                                                                                        gEx('gTelefonosContacto').startEditing(gEx('gTelefonosContacto').getStore().getCount()-1,2);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover tel&eacute;fono',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gTelefonosContacto').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el tel&eacute;fono a remover');
                                                                                        	return;
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	gEx('gTelefonosContacto').getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el tel&eacute;fono seleccionado?',resp);
                                                                                       
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	
   
    return 	tblGrid;	
}


function mostrarVentanaAgregarGrupo(idGrupo)
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
                                                            html:'Nombre del Grupo:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            width:350,
                                                            x:145,
                                                            y:5,
                                                            id:'txtNombreGrupo'
                                                            
                                                        }
                                                        ,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Contactos que forman parte del grupo:'
                                                        },
                                                        crearGridContactosGrupos()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: idGrupo?'Modificar Grupo':'Crear Grupo',
										width: 630,
										height:340,
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
                                                                        gEx('txtNombreGrupo').focus(false,500);
                                                                    }
                                                                }
                                                    },
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',                                                            
															handler: function()
																	{
																		var txtNombreGrupo=gEx('txtNombreGrupo').getValue();
                                                                        if(txtNombreGrupo=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	gEx('txtNombreGrupo').focus();
                                                                            }
                                                                            msgBox('Debe ingresar el nombre del grupo',resp1);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var arrContactos='';
                                                                        var gridContactosGrupo=gEx('gridContactosGrupo');
                                                                        var x;
                                                                        var fila;
                                                                        for(x=0;x<gridContactosGrupo.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gridContactosGrupo.getStore().getAt(x);
                                                                            
                                                                            if(arrContactos=='')
                                                                            	arrContactos='{"idContacto":"'+fila.data.idContacto+'","tipoContacto":"'+fila.data.tipoContacto+'"}';
                                                                            else
                                                                            	arrContactos+=',{"idContacto":"'+fila.data.idContacto+'","tipoContacto":"'+fila.data.tipoContacto+'"}';
                                                                        }
                                                                        
                                                                       	if(arrContactos=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                               
                                                                            }
                                                                            msgBox('Debe ingresar almenos un contacto como parte del grupo',resp3);
                                                                            return;
                                                                        } 
                                                                        
                                                                        
                                                                        var cadObj='{"idGrupo":"'+(idGrupo?idGrupo:-1)+'","nombreGrupo":"'+cv(txtNombreGrupo)+
                                                                        			'","arrContactos":['+arrContactos+']}';
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('arbolContactos').getRootNode().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_VideoConferencias.php',funcAjax, 'POST','funcion=15&cadObj='+cadObj,true);
                                                                        
                                                                        
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
    if(idGrupo)
    {
    	
        gEx('txtNombreGrupo').setValue(nodoContactosSel.attributes.nombreGrupo);
        gEx('gridContactosGrupo').getStore().loadData(nodoContactosSel.attributes.arrContactoGrupos);
    }
}

function crearGridContactosGrupos()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idContacto'},
                                                                    {name: 'tipoContacto'},
                                                                    {name: 'nombreContacto'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
														{
															header:'Nombre',
															width:350,
                                                            sortable:true,
															dataIndex:'nombreContacto'
														},
                                                        {
															header:'Tipo',
															width:150,
                                                            sortable:true,
															dataIndex:'tipoContacto',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrTipoParticipante,val);
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            y:70,
                                                            x:10,
                                                            id:'gridContactosGrupo',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            height:180,
                                                            width:590,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar Contacto',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentaAgregarContacto();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover Contacto',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gridContactosGrupo').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {	
                                                                                        	msgBox('Debe seleccionar el contacto que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        gEx('gridContactosGrupo').getStore().remove(fila);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}

function mostrarVentaAgregarContacto()
{
	var filaContacto=null;
	var oConf=	{
    					idCombo:'cmbContacto',
                        anchoCombo:350,
                        posX:140,
                        posY:5,
                        raiz:'registros',
                        campoDesplegar:'nombreContacto',
                        campoID:'idContacto',
                        funcionBusqueda:13,
                        paginaProcesamiento:'../paginasFunciones/funcionesModulosEspeciales_VideoConferencias.php',
                        confVista:'<tpl for="."><div class="search-item"><b>{nombreContacto}</b> (<i>{lblTipoContacto}</i>)<br>{mails}</div></tpl>',
                        campos:	[
                                   	{name:'idContacto'},
                                    {name:'nombreContacto'},
                                    {name:'tipoContacto'},
                                    {name:'lblTipoContacto'},
                                    {name:'mails'}

                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	filaContacto=null;
                                    	var aValor=combo.getRawValue();
										dSet.baseParams.criterio=aValor;
                                        
                                        
                                    },
                      	funcElementoSel:function(combo,registro)
                    				{
                                    	filaContacto=registro;
                                        
                                    }  
    				};

	var cmbContacto=crearComboExtAutocompletar(oConf)
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Nombre del contacto:'
                                                        },
                                                        cmbContacto
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar contacto',
										width: 540,
										height:120,
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
                                                                        gEx('cmbContacto').focus(false,500);
                                                                    }
                                                                }
                                                    },
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',                                                            
															handler: function()
																	{
																		if(!filaContacto)
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	gEx('cmbContacto').focus();
                                                                            }
                                                                        	msgBox('Debe seleccionar el contacto que desea agregar',resp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var pos=obtenerPosFila(gEx('gridContactosGrupo').getStore(),'idContacto',filaContacto.data.idContacto);
                                                                        if(pos==-1)
                                                                        {
                                                                            var reg=crearRegistro(	[
                                                                                                        {name: 'idContacto'},
                                                                                                        {name: 'tipoContacto'},
                                                                                                        {name: 'nombreContacto'}
                                                                                                    ]
                                                                                                  );
                                                                        
                                                                            var r=new reg	(
                                                                                                {
                                                                                                    idContacto:filaContacto.data.idContacto,
                                                                                                    tipoContacto:filaContacto.data.tipoContacto,
                                                                                                    nombreContacto:filaContacto.data.nombreContacto
                                                                                                }
                                                                                            )
                                                                                
                                                                            gEx('gridContactosGrupo').getStore().add(r);
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

function mostrarVentanaAgregarGrupoReunion()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearArbolGruposAgregar()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Grupo',
										width: 650,
										height:400,
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
                                                                    	var listaGrupos='';
																		var arrNodosChecados=obtenerNodoChecados(gEx('arbolContactosGrupos').getRootNode());
                                                                        var x;
                                                                        for(x=0;x<arrNodosChecados.length;x++)
                                                                        {
                                                                        	if(listaGrupos=='')
                                                                            	listaGrupos=arrNodosChecados[x].id.replace('g_','');
                                                                            else
                                                                            	listaGrupos+=','+arrNodosChecados[x].id.replace('g_','');
                                                                        }
                                                                        
                                                                        if(listaGrupos=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar almenos un grupo a agregar');
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        obtenerContactosGrupo(listaGrupos,cargarContactos);
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

function cargarContactos(arrContactos)
{
	var reg=crearRegistro(	[
    
								{name:'idParticipante'},
                                {name: 'nombreParticipante'},
                                {name:'tipoParticipacion'},
                                {name:'email'},
                                {name:'telefono'},
                                {name: 'tipoParticipante'},
                                {name:'noParticipantes'}
                            ]
                         )
	var r;
	var x;
    for(x=0;x<arrContactos.length;x++)
    {
    	r=new reg(	
        			{
                    	idParticipante:arrContactos[x][4],
                        nombreParticipante:arrContactos[x][0],
                        tipoParticipacion:arrContactos[x][1],
                        email:arrContactos[x][2],
                        telefono:arrContactos[x][3],
                        tipoParticipante:arrContactos[x][5],
                    	noParticipantes:1
                    }
                  );
		gEx('gParticipantes').getStore().add(r);
    }



}


function crearArbolGruposAgregar()
{
	var raiz=new  Ext.tree.AsyncTreeNode(
											{
												id:'-1',
												text:'Raiz',
												draggable:false,
												expanded :false,
												cls:'-1'
											}
										)
										
	var cargadorArbol=new Ext.tree.TreeLoader(
                                                {
                                                    baseParams:{
                                                                    funcion:'16',
                                                                    
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_VideoConferencias.php'
                                                }
                                            )		
										
	cargadorArbol.on('beforeload',function(c)
    						{
                            	nodoContactosSel=null;
                               	
                            }
    				)	
    										
	cargadorArbol.on('load',function(c,nodoCarga)
    						{
                            	
                            }
    				)										
	var arbolContactos=new Ext.tree.TreePanel	(
                                                            {
                                                                id:'arbolContactosGrupos',
                                                                
                                                                useArrows:true,
                                                                collapsible:false,
                                                                animate:true,
                                                                enableDD:false,
                                                                ddScroll:true,
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                border:true,
                                                                region:'center',
                                                                root:raiz,
                                                               
                                                                loader: cargadorArbol,
                                                                rootVisible:false
                                                            }
                                                        )
         
         
                                                    
	                         
	return  arbolContactos;
}


function obtenerContactosGrupo(idGrupos,funcAfter)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrDatos=eval(arrResp[1]);
            if(funcAfter)
            	funcAfter(arrDatos);
            return arrDatos;
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_VideoConferencias.php',funcAjax, 'POST','funcion=17&listGrupos='+idGrupos,true);
}
