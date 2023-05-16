<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT id__1_tablaDinamica,nombreInmueble FROM _1_tablaDinamica WHERE idEstado=2 ORDER BY nombreInmueble";
	$arrEdificios=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idSituacion,descripcionSituacion FROM 7011_situacionEventosAudiencia";
	$arrSituacionAudiencia=$con->obtenerFilasArreglo($consulta);
	
	$arrTiposRecurso="[]";
	$consulta="SELECT idFormulario FROM 900_formularios WHERE categoriaFormulario=10";
	$idFormularioAux=$con->obtenerValor($consulta);
	if($idFormularioAux!="")
	{
		$consulta="SELECT id__".$idFormularioAux."_tablaDinamica,tipoRecurso FROM _".$idFormularioAux."_tablaDinamica";
		$arrTiposRecurso=$con->obtenerFilasArreglo($consulta);
	}
	
	$arrRecursos="[]";
	$consulta="SELECT idFormulario FROM 900_formularios WHERE categoriaFormulario=11";
	$idFormularioAux=$con->obtenerValor($consulta);
	if($idFormularioAux!="")
	{
		$consulta="SELECT id__".$idFormularioAux."_tablaDinamica,nombreRecurso FROM _".$idFormularioAux."_tablaDinamica";
		$arrRecursos=$con->obtenerFilasArreglo($consulta);
	}
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
?>
var primeraCargaFrame=true;
var esAudienciaLatisMeting=false;

var idUsuarioAuxiliarSalas=-1;
var arrPerfilParticipacion=[['1','Normal'],['2','Protegido']];
var arrSiNo=<?php echo $arrSiNo?>;
var fechaInicioAudienciaAux;
var fechaFinAudienciaAux;
var idRegistroRecursoIng=-1;
var arrRecursosRemovidos=[];
var regRecursosAdiconales;
var arrHoras;
var arrRecursos=<?php echo $arrRecursos?>;
var arrTiposRecurso=<?php echo $arrTiposRecurso?>;
var lblDuracionAudiencia=60;
var lblDuracionRecursoAudiencia=60;
var arrEdificios=<?php echo $arrEdificios?>;
var carpetaAdministrativa='';
var arrSituacionAudiencia=<?php echo $arrSituacionAudiencia?>;
Ext.onReady(inicializar);

function inicializar()
{

	lblDuracionAudiencia=parseInt(gE('duracionAudiencia').value);
	Ext.QuickTips.init();
	if(window.parent)
		window.parent.autoScroll=150;
	
                        
	var cmbSalas=crearComboExt('cmbSalas',eval(bD(gE('arrSalas').value)),130,85,220);
    cmbSalas.on('select',function(cmb,registro)
    					{
                        	if(registro.data.valorComp=='4')
                            {
                            	esAudienciaLatisMeting=true;
                            	gEx('tPanelAudiencia').unhideTabStripItem(2);
                            }
                            else
                            {
                            	esAudienciaLatisMeting=false;
                            	gEx('tPanelAudiencia').hideTabStripItem(2);
                            }
    						cargarDatosAgenda();                    
                        }
    			)
    
    
    var cmbEdificio=crearComboExt('cmbEdificio',arrEdificios,130,55,220);
    

   
    cmbEdificio.on('select',function(){buscarSalasDisponibles();cargarDatosAgenda();}	);
                
                
                
	var cmbTipoAudiencia=  crearComboExt('cmbTipoAudiencia',eval(bD(gE('arrTipoAudiencia').value)),0,65,350);    
    cmbTipoAudiencia.on('select',function(cmb,registro)
    					{
    						lblDuracionAudiencia=parseInt(registro.data.valorComp);                    
                        }
    			)
    
     cmbTipoAudiencia.setDisabled(true);         
   
    var horaInicial=new Date(2010,5,10,7,0);
	var horaFinal=new Date(2010,5,10,23,59);
    
	arrHoras=generarIntervaloHoras(horaInicial,horaFinal,1,'H:i','H:i');
    
	var cmbHoraInicio=crearComboExt('tmeHoraInicio',arrHoras,130,115,90);
    cmbHoraInicio.on('select',function(cmb,registro)
    						{

                            	ajustarRecursosAdicionalesAudiencia(fechaInicioAudienciaAux,fechaFinAudienciaAux);
                            	calcularHoraFinal(registro.data.id);
                            }
    		
            		)
   
   	cmbHoraInicio.on('beforeselect',function(cmb,registro)
    						{
                            	
                            	fechaInicioAudienciaAux=Date.parseDate(gEx('dteFecha').getValue().format('Y-m-d')+' '+cmb.getValue(),'Y-m-d H:i');
								fechaFinAudienciaAux=Date.parseDate(gEx('dteFecha').getValue().format('Y-m-d')+' '+gEx('tmeHoraFin').getValue(),'Y-m-d H:i');
                                
    
                            }
    		
            		)
   
   	var cmbHoraFin=crearComboExt('tmeHoraFin',arrHoras,245,115,90);
    cmbHoraFin.on('select',function()
    						{
                            	ajustarRecursosAdicionalesAudiencia(fechaInicioAudienciaAux,fechaFinAudienciaAux);
                            	calcularTiempoEstimado()
                            }
    		
            		)
   
   
   cmbHoraFin.on('beforeselect',function(cmb,registro)
    						{
                            	
                            	fechaInicioAudienciaAux=Date.parseDate(gEx('dteFecha').getValue().format('Y-m-d')+' '+gEx('tmeHoraInicio').getValue(),'Y-m-d H:i');
								fechaFinAudienciaAux=Date.parseDate(gEx('dteFecha').getValue().format('Y-m-d')+' '+cmb.getValue(),'Y-m-d H:i');
                                
    
                            }
    		
            		)
   
	var oConf=	{
    					idCombo:'cmbAuxiliarSala',
                        posX:10,
                        posY:70,
                        anchoCombo:350,
                        raiz:'registros',
                        campoDesplegar:'nombreUsuario',
                        campoID:'nombreUsuario',
                        funcionBusqueda:9,
                        paginaProcesamiento:'../paginasFunciones/funciones.php',
                        confVista:'<tpl for="."><div class="search-item">{nombreUsuario}<br></div></tpl>',
                        campos:	[
                        			{name:'idUsuario'},
                                    {name:'nombreUsuario'}

                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	idUsuarioAuxiliarSalas=-1;
                                    	var aValor=combo.getRawValue();
										dSet.baseParams.criterio=aValor;
                                        dSet.baseParams.roles="'16_0'";
                                        
                                        
                                    },
                      	funcElementoSel:function(combo,registro)
                    				{
                                    	idUsuarioAuxiliarSalas=registro.data.idUsuario;
                                        
                                        
                                    }  
    				};

	var cmbAuxiliarSala=crearComboExtAutocompletar(oConf)
    
   
    
	var cmbMesaEvidencias=crearComboExt('cmbMesaEvidencias',arrSiNo,250,15,110);                                                                                            
    cmbMesaEvidencias.setValue(gE('requiereMesaEvidencia').value);
    
    
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                bbar:	[
                                                            {
                                                                xtype:'label',
                                                                html:'<table><tr><td><div style="width:15px; height:15px; background-color:#900; border-style:solid; border-width:1px; border-color:#000"></div></td><td> Evento a modificar</td></tr></table>'
                                                            },'-',
                                                            {
                                                                xtype:'label',
                                                                html:'<table><tr><td><div style="width:15px; height:15px; background-color:#030; border-style:solid; border-width:1px; border-color:#000"></div></td><td> Eventos de la sala</td></tr></table>'
                                                            },'-',
                                                            {
                                                                xtype:'label',
                                                                html:'<table><tr><td><div style="width:15px; height:15px; background-color:#E56A4B; border-style:solid; border-width:1px; border-color:#000"></div></td><td> Eventos de juez</td></tr></table>'
                                                            },'-',
                                                            {
                                                                xtype:'label',
                                                                html:'<table><tr><td><div style="width:15px; height:15px; background-color:#3D00CA; border-style:solid; border-width:1px; border-color:#000"></div></td><td> No disponibilidad de juez</td></tr></table>'
                                                            },'-',
                                                            {
                                                                xtype:'label',
                                                                html:'<table><tr><td><div style="width:15px; height:15px; background-color:#B55381; border-style:solid; border-width:1px; border-color:#000"></div></td><td> No disponibilidad de sala</td></tr></table>'
                                                            },
                                                            '-',
                                                            {
                                                                xtype:'label',
                                                                html:'<table><tr><td><div style="width:15px; height:15px; background-color:#000; border-style:solid; border-width:1px; border-color:#000"></div></td><td> Fuera del l&iacute;mite m&aacute;ximo de atenci&oacute;n</td></tr></table>'
                                                            }
                                                            
                                                        ],
                                                items:	[
                                                			
                                                            {
                                                            	width:400,
                                                                baseCls: 'x-plain',
                                                            	xtype:'tabpanel',
                                                                id:'tPanelAudiencia',
                                                                hidden:gE('sL').value=='1',
                                                                region:'east',                                                                
                                                                bbar:	new Ext.Toolbar	(
                                                                								{
                                                                                                	buttonAlign:'center',
                                                                                                	items: [
                                                                                                                {
                                                                                                                    
                                                                                                                    width:100,
                                                                                                                    hidden:true,                                                                                                                    
                                                                                                                    id:'btnModificar',
                                                                                                                    xtype:'button',
                                                                                                                    icon:'../images/pencil.png',
                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                    text:'Modificar audiencia',
                                                                                                                    handler:function()
                                                                                                                            {
                                                                                                                                function resp(btn)
                                                                                                                                {
                                                                                                                                    if(btn=='yes')
                                                                                                                                    
                                                                                                                                        guardarEvento();   
                                                                                                                                }
                                                                                                                                msgConfirm('Est&aacute; seguro de querer modificar la informaci&oacute;n del evento',resp);
                                                                                                                                return;
                                                                                                                            }
                                                                                                                    
                                                                                                                },
                                                                                                                {
                                                                                                                    
                                                                                                                    width:100,
                                                                                                                    border:true,
                                                                                                                    id:'btnConfirmar',
                                                                                                                    xtype:'button',
                                                                                                                    icon:'../images/icon_big_tick.gif',
                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                    text:'Confirmar audiencia',
                                                                                                                    handler:function()
                                                                                                                            {
                                                                                                                                function resp(btn)
                                                                                                                                {
                                                                                                                                    if(btn=='yes')
                                                                                                                                    
                                                                                                                                        guardarEvento();   
                                    
                                                                                                                                }
                                                                                                                                msgConfirm('Est&aacute; seguro de querer guardar la informaci&oacute;n del evento',resp);
                                                                                                                                return;
                                                                                                                            }
                                                                                                                    
                                                                                                                }
                                                                                                            ]
                                                                                                }
                                                                							),
                                                                
                                                               
                                                                activeTab:0,
                                                                items:	[
                                                                			{
                                                                            	xtype:'panel',
                                                                                title:'Datos Generales',
                                                                                layout:'absolute',
                                                                                items:	[
                                                                                			{
                                                                                                x:20,
                                                                                                y:20,
                                                                                                xtype:'label',
                                                                                                html:'<span style="font-size:11px"><b>ID Audiencia:</b></span>'
                                                                                            },
                                                                                            {
                                                                                                x:170,
                                                                                                y:20,
                                                                                                xtype:'label',
                                                                                                html:'<span style="font-size:11px; color:#900; font-weight:bold" id="idAudiencia">NO Asignado</span>'
                                                                                            },
                                                                                            {
                                                                                                x:20,
                                                                                                y:40,
                                                                                                xtype:'label',
                                                                                                html:'<span style="font-size:11px"><b>Situaci&oacute;n audiencia:</b></span>'
                                                                                            },
                                                                                            {
                                                                                                x:170,
                                                                                                y:40,
                                                                                                xtype:'label',
                                                                                                html:'<span style="font-size:11px; color:#900; font-weight:bold" id="lblStatusAudiencia">'+formatearValorRenderer(arrSituacionAudiencia,gE('situacionAudiencia').value)+'</span>'
                                                                                            },
                                                                                            {
                                                                                                xtype:'fieldset',
                                                                                                x:10,
                                                                                                y:65,
                                                                                                disabled:gE('sL').value=='1',
                                                                                                title:'Datos de la audiencia',
                                                                                                layout:'absolute',
                                                                                                width:385,
                                                                                                height:390,
                                                                                                items:	[	
                                                                                
                                                                                                           
                                                                                                            {
                                                                                                                x:0,
                
                                                                                                                y:10,
                                                                                                                xtype:'label',
                                                                                                                html:'<span style="font-size:11px">Carpeta Judicial:</span>'
                                                                                                            },                                                                                            
                                                                                                            {
                                                                                                                x:125,
                                                                                                                y:10,
                                                                                                                xtype:'label',
                                                                                                                html:'<span style="font-size:11px; color:#900; font-weight:bold">'+gE('carpetaAdministrativa').value+'</span>'
                                                                                                            },
                                                                                                            {
                                                                                                                x:0,
                                                                                                                y:40,
                                                                                                                xtype:'label',
                                                                                                                html:'<span style="font-size:11px">Tipo de audiencia:</span>'
                                                                                                            },
                                                                                                            cmbTipoAudiencia,
                                                                                                            {
                                                                                                                x:0,
                                                                                                                y:100,
                                                                                                                xtype:'label',
                                                                                                                html:'<span style="font-size:11px">Fecha de la audiencia:</span>'
                                                                                                            },
                                                                                                            {
                                                                                                                x:155,
                                                                                                                y:95,
                                                                                                                xtype:'datefield',
                                                                                                                id:'dteFecha',
                                                                                                                value:'<?php echo date('Y-m-d')?>',
                                                                                                                listeners:	{
                                                                                                                				change:function(ctrl,nValor,vValor)
                                                                                                                                		{
                                                                                                                                        	fechaInicioAudienciaAux=Date.parseDate(vValor.format('Y-m-d')+' '+gEx('tmeHoraInicio').getValue(),'Y-m-d H:i');
																																			fechaFinAudienciaAux=Date.parseDate(vValor.format('Y-m-d')+' '+gEx('tmeHoraFin').getValue(),'Y-m-d H:i');
                                                                                                                                            ajustarRecursosAdicionalesAudiencia(fechaInicioAudienciaAux,fechaFinAudienciaAux);
    
                                                                                                                                        },
                                                                                                                                select: function()
                                                                                                                                        {
                                                                                                                                        
                                                                                                                                        	
    
                                                                                                                                        
                                                                                                                                            if((gE('tipoCarpetaAdministrativa').value=='6')&&(gE('idJuez').value!='-1')&&(gE('idJuezResponsableCarpeta').value!='-1'))
                                                                                                                                            {
                                                                                                                                                
                                                                                                                                                asignarJuez();
                                                                                                                                            }
                                                                                                                                            else
                                                                                                                                            {
	                                                                                                                                            buscarSalasDisponibles();
                                                                                                                                                cargarDatosAgenda();
                                                                                                                                            }
                                                                                                                                                
                                                                                                                                            
                                                                                                                                        }
                                                                                                                                
                                                                                                                                
                                                                                                                            }
                                                                                                                
                                                                                                            },
                                                                                                            {
                                                                                                                x:200-(gE('tipoCarpetaAdministrativa').value=='6'?190:0),
                                                                                                                y:120,
                                                                                                                id:'btnAsignarJuez',
                                                                                                                width:40,
                                                                                                                xtype:'button',
                                                                                                                icon:'../images/user_go.png',
                                                                                                                cls:'x-btn-text-icon',
                                                                                                                tooltip:'Asignar Juez',
                                                                                                                handler:function()
                                                                                                                        {
                                                                                                                            
                                                                                                                            if(gEx('dteFecha').getValue()=='')
                                                                                                                            {
                                                                                                                                function respDte()
                                                                                                                                {
                                                                                                                                    gEx('dteFecha').focus();
                                                                                                                                }
                                                                                                                                msgBox('Debe indicar la fecha en que se llevar&aacute; a cabo la audiencia',respDte);
                                                                                                                                return;
                                                                                                                            }
                                                                                                                            gEx('chkJuezTramite').setValue(false);
                                                                                                                            asignarJuez();
                                                                                                                        }
                                                                                                            },
                                                                                                            {
                                                                                                                x:200-(gE('tipoCarpetaAdministrativa').value=='6'?190:0),
                                                                                                                y:120,
                                                                                                                id:'btnMdificarJuez',
                                                                                                                width:40,
                                                                                                                xtype:'button',
                                                                                                                hidden:true,
                                                                                                                icon:'../images/user_edit.png',
                                                                                                                cls:'x-btn-text-icon',
                                                                                                                tooltip:'Modificar Juez',
                                                                                                                handler:function()
                                                                                                                        {
                                                                                                                            gEx('chkJuezTramite').setValue(false);
                                                                                                                            mostrarModificacionJuez();
                                                                                                                        }
                                                                                                            },
                                                                                                            {
                                                                                                                x:250-(gE('tipoCarpetaAdministrativa').value=='6'?190:0),
                                                                                                                y:120,
                                                                                                                id:'btnAsignarJuezExcusa',
                                                                                                                width:40,
                                                                                                                hidden:true,
                                                                                                                xtype:'button',
                                                                                                                icon:'../images/users.png',
                                                                                                                cls:'x-btn-text-icon',
                                                                                                                tooltip:'Asignar Nuevo Juez por Excusa',
                                                                                                                handler:function()
                                                                                                                        {
                                                                                                                            
                                                                                                                            if(gEx('dteFecha').getValue()=='')
                                                                                                                            {
                                                                                                                                function respDte()
                                                                                                                                {
                                                                                                                                    gEx('dteFecha').focus();
                                                                                                                                }
                                                                                                                                msgBox('Debe indicar la fecha en que se llevar&aacute; a cabo la audiencia',respDte);
                                                                                                                                return;
                                                                                                                            }
                                                                                                                            gEx('chkJuezTramite').setValue(false);
                                                                                                                            mostrarVentanaMotivoExcusa();
                                                                                                                        }
                                                                                                            },
                                                                                                           
                                                                                                            {
                                                                                                                x:300,
                                                                                                                y:120,
                                                                                                                id:'btnInicializar',
                                                                                                                width:40,
                                                                                                                xtype:'button',
                                                                                                                hidden:true,
                                                                                                                icon:'../images/arrow_refresh.PNG',
                                                                                                                cls:'x-btn-text-icon',
                                                                                                                tooltip:'Reiniciar asignaci&oacute;n',
                                                                                                                handler:function()
                                                                                                                        {
                                                                                                                            gE('arrJuezOriginal').value='';
                                                                                                                            gE('arrJuecesBloquear').value='';
                                                                                                                            gE('arrJuecesExcusa').value='';
                                                                                                                            gEx('chkJuezTramite').show();
                                                                                                                            gEx('chkJuezTramite').setValue(false);
                                                                                                                            gEx('btnAsignarJuez').show();
                                                                                                                           
                                                                                                                            gEx('btnInicializar').hide();
                                                                                                                            asignarJuez();
                                                                                                                            
                                                                                                                        }
                                                                                                            },
                                                                                                             {
                                                                                                                x:0,
                                                                                                                y:120,
                                                                                                                xtype:'checkbox',
                                                                                                                hidden:gE('tipoCarpetaAdministrativa').value=='6',
                                                                                                                id:'chkJuezTramite',
                                                                                                                boxLabel:'Asignar Juez de Tr&aacute;mite',
                                                                                                                listeners:	{
                                                                                                                                check:function(chk,valor)
                                                                                                                                        {
                                                                                                                                            if(valor)
                                                                                                                                            {
                                                                                                                                                gE('arrJuezOriginal').value='';
                                                                                                                                                obtenerJuezTramite();
                                                                                                                                                
                                                                                                                                            }
                                                                                                                                            else
                                                                                                                                            {
                                                                                                                                                gEx('btnAsignarJuez').show();
                                                                                                                                                gEx('fsJuez').hide();
                                                                                                                                                gEx('btnMdificarJuez').hide();
                                                                                                                                                gEx('btnAsignarJuezExcusa').hide();
                                                                                                                                                
                                                                                                                                            }
                                                                                                                                        }
                                                                                                                            }
                                                                                                             },
                                                                                                            {
                                                                                                                xtype:'fieldset',
                                                                                                                x:-10,
                                                                                                                y:140,
                                                                                                                id:'fsJuez',
                                                                                                                hidden:true,
                                                                                                                border:false,
                                                                                                                layout:'absolute',
                                                                                                                width:380,
                                                                                                                height:230,
                                                                                                                items:	[
                                                                                                                            {
                                                                                                                                x:0,
                                                                                                                                y:10,
                                                                                                                                xtype:'label',
                                                                                                                                html:'<span style="font-size:11px">Juez asignado:</span>'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:125,
                                                                                                                                y:10,
                                                                                                                                xtype:'label',
                                                                                                                                html:'<span style="font-size:11px; color:#900" id="lblJuez">'+bD(gE('nombreJuez').value)+'</span>'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:0,
                                                                                                                                y:60,
                                                                                                                                xtype:'label',
                                                                                                                                html:'<span style="font-size:11px">Edificio:</span>'
                                                                                                                            },
                                                                                                                            cmbEdificio,
                                                                                                                            {
                                                                                                                                x:0,
                                                                                                                                y:90,
                                                                                                                                xtype:'label',
                                                                                                                                html:'<span style="font-size:11px">Sala:</span>'
                                                                                                                            },
                                                                                                                            
                                                                                                                            cmbSalas,
                                                                                                                            
                                                                                                                            {
                                                                                                                                x:0,
                                                                                                                                y:120,
                                                                                                                                xtype:'label',
                                                                                                                                html:'<span style="font-size:11px">Hora:</span>'
                                                                                                                            },
                                                                                                                            cmbHoraInicio,
                                                                                                                            {
                                                                                                                                x:230,
                                                                                                                                y:120,
                                                                                                                                xtype:'label',
                                                                                                                                html:'<span style="font-size:11px">-</span>'
                                                                                                                            },
                                                                                                                            cmbHoraFin,
                                                                                                                            {
                                                                                                                                x:0,
                                                                                                                                y:150,
                                                                                                                                xtype:'checkbox',
                                                                                                                                id:'chkVisualizarAgendaRecursos',
                                                                                                                                checked:true,
                                                                                                                                boxLabel:'Visualizar agenda de recursos adicionales',
                                                                                                                                listeners:	{
                                                                                                                                                check:function(chk,valor)
                                                                                                                                                        {
                                                                                                                                                         	cargarDatosAgenda();   
                                                                                                                                                        }
                                                                                                                                            }
                                                                                                                             }
                                                                                                                            	
                                                                                                                        ]
                                                                                                                
                                                                                                            }
                                                                                                            
                                                                                                                
                                                                                                            
                                                                                                            
                                                                                                       ]
                                                                                            }     
                                                                                		]
                                                                                
                                                                            },
                                                                            {
                                                                            	xtype:'panel',
                                                                                title:'Recursos Adicionales',
                                                                                layout:'border',
                                                                                listeners:	{
                                                                                				activate:function()
                                                                                                		{
                                                                                                        	
                                                                                                            gEx('gRecursosAdicionales').getView().refresh();
                                                                                                        }
                                                                                			},
                                                                                items:	[
                                                                                
                                                                                			crearGridRecursosAdicionales()
                                                                                		]
                                                                            },
                                                                            {
                                                                            	xtype:'panel',
                                                                                id:'panelConfVirtual',
                                                                                title:'Conf. Audiencia Virtual',
                                                                                layout:'absolute',
                                                                                listeners:	{
                                                                                				activate:function()
                                                                                                		{
                                                                                                        	
                                                                                                            //gEx('gRecursosAdicionales').getView().refresh();
                                                                                                        }
                                                                                			},
                                                                                items:	[
                                                                                
                                                                                			{
                                                                                            	x:10,
                                                                                                y:20,
                                                                                                xtype:'label',
                                                                                                html:'Requiere Mesa de Evidencias:'
                                                                                            },
                                                                                            cmbMesaEvidencias,
                                                                                            {
                                                                                            	x:10,
                                                                                                y:50,
                                                                                                xtype:'label',
                                                                                                html:'Auxiliar de Sala:'
                                                                                            },
                                                                                            cmbAuxiliarSala,
                                                                                            {
                                                                                            	x:10,
                                                                                                y:100,
                                                                                                xtype:'fieldset',
                                                                                                title:'Participantes',
                                                                                                width:380,
                                                                                                height:360,
                                                                                                layout:'absolute',
                                                                                                items:	[
                                                                                                			crearGridParticipantesLatisMeeting()
                                                                                                		]
                                                                                            }
                                                                                		]
                                                                            }
                                                                			
                                                                			     
                                                                		]
                                                            },
                                                            {
                                                            	xtype:'panel',
                                                                layout:'border',
                                                                region:'center',
                                                                
                                                                items:	[
                                                                			new Ext.ux.IFrameComponent({ 
                
                                                                                                          id: 'frameContenidoAgenda', 
                                                                                                          anchor:'100% 100%',
                                                                                                          region:'center',
                                                                                                          border:true,
                                                                                                          loadFuncion:function(iFrame)
                                                                                                                      {
                                                                                                                          
                                                                                                                      },
            
                                                                                                          url: '../paginasFunciones/white.php',
                                                                                                          style: 'width:100%;height:100%' 
                                                                                                  })
                                                                		]
                                                            }
                                                            
                                                        ]
                                            }
                                         ]
                            }
                        )  
    
    
    <?php
	
	if($tipoMateria!="P")
	{
?>
		gEx('tPanelAudiencia').hideTabStripItem(1);
<?php
	}
	?>
                        
	gEx('tPanelAudiencia').setActiveTab(1);  
    gEx('tPanelAudiencia').setActiveTab(2);
    gEx('tPanelAudiencia').setActiveTab(0);                      
	gEx('tPanelAudiencia').hideTabStripItem(2);
                        
                        
	 if((gE('idAuxiliarSala').value!='')&&(gE('idAuxiliarSala').value!='-1'))
    {
    	idUsuarioAuxiliarSalas=gE('idAuxiliarSala').value;
	    cmbAuxiliarSala.setRawValue(gE('nombreAuxiliarSala').value);
    }
                            
	var cmbTipoAudiencia=gEx('cmbTipoAudiencia');
    cmbTipoAudiencia.setValue(gE('tipoAudiencia').value);
    var cmbEdificio=gEx('cmbEdificio');
    cmbEdificio.setValue(gE('idEdificio').value);
    var dteFecha=gEx('dteFecha');
    
    if(gE('fechaAudiencia').value!='')
    	dteFecha.setValue(gE('fechaAudiencia').value);
    if(gE('horaInicio').value!='')
    {
    	
        gEx('btnModificar').show();
        gEx('btnConfirmar').hide();
        gE('idAudiencia').innerHTML=gE('idRegistroEvento').value;
        
        var cmbSalas=gEx('cmbSalas');
        cmbSalas.setValue(gE('idSala').value);
        
       
        
        var cmbHoraInicio=gEx('tmeHoraInicio');
        cmbHoraInicio.setValue(gE('horaInicio').value);
        var cmbHoraFin=gEx('tmeHoraFin');
        cmbHoraFin.setValue(gE('horaFin').value);
        dispararEventoSelectCombo('cmbSalas');
        gEx('btnAsignarJuez').hide();
        gEx('btnMdificarJuez').show();
        //gEx('btnAsignarJuezExcusa').show();
        gEx('chkJuezTramite').hide();
        
    }
    
    if(gE('idJuez').value!='-1')
    {
    	
    	gEx('chkJuezTramite').hide();
        gEx('btnAsignarJuez').hide();
        gEx('btnMdificarJuez').show();
        //gEx('btnAsignarJuezExcusa').show();
        
    	gEx('fsJuez').show();
    }
    
    if(gE('sL').value=='1')
    {
        gEx('chkJuezTramite').hide();
        gEx('btnAsignarJuez').hide();
        gEx('btnMdificarJuez').hide();
        gEx('btnAsignarJuezExcusa').hide();
        gEx('btnModificar').hide();
        gEx('btnConfirmar').hide();
    }
                         
}


function buscarSalasDisponibles()
{
	
    function respAux22(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrDatos=eval(arrResp[1]);
            gEx('cmbSalas').setValue('');
            gEx('cmbSalas').getStore().loadData(arrDatos);
            
           /* var pos=obtenerPosFila(gEx('cmbSalas').getStore(),'id',objDatosAudiencia.idSala);
            if(pos!=-1)
                cmbSalas.setValue(objDatosAudiencia.idSala);
            else
                cmbSalas.setValue(arrDatos[0][0]);
            cargarDatosAgenda();*/
            
            
           
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',respAux22, 'POST','funcion=5&idUnidadGestion='+
                        gE('idUnidadGestion').value+'&tipoAudiencia='+gEx('cmbTipoAudiencia').getValue()+
                        '&carpetaAdministrativa='+gE('carpetaAdministrativa').value+'&idEdificio='+gEx('cmbEdificio').getValue()+
                        '&fechaAudiencia='+gEx('dteFecha').getValue().format('Y-m-d'),false);                  
                        
}

function crearGridParticipantesLatisMeeting()
{
	var cmbPerfilParticipacion=crearComboExt('cmbPerfilParticipacion',arrPerfilParticipacion,0,0);
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idParticipante'},
		                                                {name: 'perfilParticipante'},
		                                                {name: 'nombreParticipante'},
                                                        {name: 'idParticipanteReunion'},
                                                        {name: 'tieneMail'}
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
                                                            sortInfo: {field: 'nombreParticipante', direction: 'ASC'},
                                                            groupField: 'nombreParticipante',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='321';
                                        proxy.baseParams.carpetaAdministrativa=gE('carpetaAdministrativa').value;
                                        proxy.baseParams.idEvento=gE('idRegistroEvento').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                        	{
                                                                header:'',
                                                                width:50,
                                                                sortable:true,
                                                                dataIndex:'idParticipanteReunion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var lblAcciones='';
                                                                        	if(val!='-1')
                                                                            {
                                                                            	if(registro.data.tieneMail=='1')
                                                                            		lblAcciones='<a style="cursor:pointer" onclick="reenviarInvitacion(\''+bE(val)+'\')"><img src="../images/email_go.png" width="14" height="14" title="Reenviar Invitaci&oacute;n" alt="Reenviar Invitaci&oacute;n"></a>&nbsp;';
                                                                            	lblAcciones +='<a style="cursor:pointer" onclick="imprimirInvitacion(\''+bE(val)+'\')"><img src="../images/vcard.png" width="14" height="14" title="Imprimir Invitaci&oacute;n" alt="Imprimir Invitaci&oacute;n"></a>';
                                                                            }
                                                                            
                                                                            return lblAcciones;
                                                                        }
                                                            },
                                                            {
                                                                header:'Participante',
                                                                width:185,
                                                                sortable:true,
                                                                dataIndex:'nombreParticipante',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Perfil de<br />participaci&oacute;n',
                                                                width:80,
                                                                align:'center',
                                                                sortable:true,
                                                                editor:cmbPerfilParticipacion,
                                                                dataIndex:'perfilParticipante',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrPerfilParticipacion,val);
                                                                            }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gPerfilParticipacion',
                                                                store:alDatos,
                                                                x:0,
                                                                y:0,
                                                                clicksToEdit:1,
                                                                region:'center',
                                                                width:355,
                                                                height:330,
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
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

function crearGridRecursosAdicionales()
{
	regRecursosAdicionales=crearRegistro	(
                                                [
                                                    {name:'idRegistro'},
                                                    {name: 'tipoRecurso'},
                                                    {name:'idRecurso'},
                                                    {name:'horaInicio', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                    {name:'horaTermino', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                    {name: 'comentariosAdicionales'},
                                                    {name: 'alertas'}
                                                ]
                                            );
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'tipoRecurso'},
		                                                {name:'idRecurso'},
		                                                {name:'horaInicio', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'horaTermino', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'comentariosAdicionales'},
                                                        {name: 'alertas'}
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
                                                            sortInfo: {field: 'idRecurso', direction: 'ASC'},
                                                            groupField: 'tipoRecurso',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='304';
                                        proxy.baseParams.idEventoAudiencia=gE('idRegistroEvento').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'alertas'
                                                            },
                                                            {
                                                                header:'Tipo de recurso',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'tipoRecurso',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTiposRecurso,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Recurso',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'idRecurso',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrRecursos,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Hora de uso',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'horaInicio',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var lblEtiqueta=val.format('H:i')+' - '+registro.data.horaTermino.format('H:i');
                                                                            if(val.format('Y-m-d')!=registro.data.horaTermino.format('Y-m-d'))
                                                                            {
                                                                            	lblEtiqueta+=' ('+registro.data.horaTermino.format('d/m/Y')+')';	
                                                                            }
                                                                            return lblEtiqueta;
                                                                        }
                                                            },
                                                            {
                                                                header:'Comentarios adicionales',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'comentariosAdicionales',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gRecursosAdicionales',
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
                                                                                text:'Agregar recurso',
                                                                                handler:function()
                                                                                        {
                                                                                        
                                                                                        	if(gEx('tmeHoraInicio').getValue()=='')
                                                                                            {
                                                                                            	function resp1()
                                                                                                {
                                                                                                	gEx('tPanelAudiencia').setActiveTab(0);
                                                                                                	gEx('tmeHoraInicio').focus();
                                                                                                }
                                                                                                msgBox('Primero debe indicar la hora en la cual iniciar&aacute; la audiencia',resp1);
                                                                                            	return;
                                                                                            }
                                                                                        
                                                                                        	if(gEx('tmeHoraFin').getValue()=='')
                                                                                            {
                                                                                            	
                                                                                            	function resp2()
                                                                                                {
                                                                                                	gEx('tPanelAudiencia').setActiveTab(0);
                                                                                                	gEx('tmeHoraFin').focus();
                                                                                                }
                                                                                                msgBox('Primero debe indicar la hora en la cual terminar&aacute; la audiencia',resp2);
                                                                                            	return;
                                                                                            }
                                                                                           	mostrarVentanaAgregarRecursoAudiencia(); 
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Modificar recurso',
                                                                                handler:function()
                                                                                        {
                                                                                        
                                                                                        	var recurso=gEx('gRecursosAdicionales').getSelectionModel().getSelected();
                                                                                            if(!recurso)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el recurso que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                           	mostrarVentanaAgregarRecursoAudiencia(recurso); 
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                            
                                                                            ,'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover recurso',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=gEx('gRecursosAdicionales').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el recurso que desea remover');
                                                                                            	return;
                                                                                            }
                                                                                            if(fila.data.idRegistro==-1)
                                                                                            {
                                                                                            	function resp(btn)
                                                                                                {
                                                                                                	if(btn=='yes')
                                                                                                    {
                                                                                                    	gEx('gRecursosAdicionales').getStore().remove(fila);
                                                                                                        if(gEx('chkVisualizarAgendaRecursos').getValue())
                                                                                                        {
                                                                                                            cargarDatosAgenda();
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                                msgConfirm('Est&aacute; seguro de querer remover el recurso seleccionado?',resp);
                                                                                            	
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                            	mostrarVentanaRemoverRecurso(fila); 
                                                                                            }
                                                                                           	
                                                                                           
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                		],
                                                                        
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: true,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;
}

function cargarDatosAgenda()
{
	if(gE('sL').value=='1')
    {	
    	var oParams=	{
                    
                    		iEvento:gE('idRegistroEvento').value
                    
               			}
    
    
		gEx('frameContenidoAgenda').load	(
    								{
                                    	url:'../modulosEspeciales_SGJP/panelAudiencia.php',
                                        params:	oParams
                                    }
    							)
    	return;
    }

	if((gEx('cmbSalas').getValue()=='')||(gEx('dteFecha').getValue()==''))
    {
    	
		gEx('frameContenidoAgenda').load	(
                                                {
                                                    url:'../paginasFunciones/white.php'
                                                }
                                            )
    	return;
    }
	var fila;
    var x;
    var listaJueces=gE('idJuez').value;
   
   	var listaRecursosConsiderar='-1';
    var gRecursosAdicionales=gEx('gRecursosAdicionales');
    
    
    for(x=0;x<gRecursosAdicionales.getStore().getCount();x++)
    {
    	fila=gRecursosAdicionales.getStore().getAt(x);

        if(fila.data.idRegistro=='-1')
        {
        	if(listaRecursosConsiderar=='-1')
            	listaRecursosConsiderar=fila.data.tipoRecurso+'_'+fila.data.idRecurso;
            else
            	listaRecursosConsiderar+=','+fila.data.tipoRecurso+'_'+fila.data.idRecurso;
        }
        
    }
    
    
    if(listaJueces=='')
    	listaJueces=-1;
    
    var oParams={
                    idSala:gEx('cmbSalas').getValue(),
                    cPagina:'sFrm=true',
                    idJueces:listaJueces ,
                    idUnidadGestion:gE('idUnidadGestion').value,
                    iEvento:gE('idRegistroEvento').value,
                    visualizarAgendaRecursos:gEx('chkVisualizarAgendaRecursos').getValue()?1:0,
                    lRecursos:listaRecursosConsiderar,
                    fechaBase: gEx('dteFecha').getValue().format('Y-m-d')
                    
                }
    
    
	gEx('frameContenidoAgenda').load	(
    								{
                                    	url:'../modulosEspeciales_SGJP/calendarioEventosAlzada.php',
                                        params:	oParams
                                    }
    							)
}

function calcularHoraFinal(horaInicial)
{
	fechaInicioAudienciaAux=Date.parseDate(gEx('dteFecha').getValue().format('Y-m-d')+' '+gEx('tmeHoraInicio').getValue(),'Y-m-d H:i');
	fechaFinAudienciaAux=Date.parseDate(gEx('dteFecha').getValue().format('Y-m-d')+' '+gEx('tmeHoraFin').getValue(),'Y-m-d H:i');
    
	var duracionOriginal=parseInt(lblDuracionAudiencia);
    
	var fechaInicio=gEx('dteFecha').getValue().format('Y-m-d');
    fechaInicio+=' '+horaInicial;
    
    var dteFechaInicio=Date.parseDate(fechaInicio,'Y-m-d H:i');
   
    var dteFechaFin=dteFechaInicio.add(Date.MINUTE,duracionOriginal);
    
    
	gEx('tmeHoraFin').setValue(dteFechaFin.format('H:i')); 
    
    gEx('tmeHoraInicio').setValue(dteFechaInicio.format('H:i')); 
   	ajustarRecursosAdicionalesAudiencia(fechaInicioAudienciaAux,fechaFinAudienciaAux);
    calcularTiempoEstimado();   
   
    
       
}

function ajustarFechaEvento(evento)
{
	fechaInicioAudienciaAux=Date.parseDate(gEx('dteFecha').getValue().format('Y-m-d')+' '+gEx('tmeHoraInicio').getValue(),'Y-m-d H:i');
	fechaFinAudienciaAux=Date.parseDate(gEx('dteFecha').getValue().format('Y-m-d')+' '+gEx('tmeHoraFin').getValue(),'Y-m-d H:i');
	gEx('dteFecha').setValue(evento.start.format('YYYY-MM-DD'));
    gEx('tmeHoraInicio').setValue(evento.start.format('HH:mm'));    
    gEx('tmeHoraFin').setValue(evento.end.format('HH:mm'));
	ajustarRecursosAdicionalesAudiencia(fechaInicioAudienciaAux,fechaFinAudienciaAux);
    calcularTiempoEstimado();
    
    

}

function calcularTiempoEstimado()
{
	var horaInicio=Date.parseDate(gEx('dteFecha').getValue().format('Y-m-d')+' '+gEx('tmeHoraInicio').getValue(),'Y-m-d H:i');
    var fechaFin=gEx('dteFecha').getValue().format('Y-m-d');
    
    
    
    var horaFin=Date.parseDate(fechaFin+' '+gEx('tmeHoraFin').getValue(),'Y-m-d H:i');
	lblDuracionAudiencia=((horaFin-horaInicio+0)/60000);
    
    ajustarEvento();
}

function ajustarEvento()
{
	var calendario=gEx('frameContenidoAgenda').getFrameWindow();	
    var horaInicio=Date.parseDate(gEx('dteFecha').getValue().format('Y-m-d')+' '+gEx('tmeHoraInicio').getValue(),'Y-m-d H:i');
    var fechaFin=gEx('dteFecha').getValue().format('Y-m-d');
    
    
    
    var horaFin=Date.parseDate(fechaFin+' '+gEx('tmeHoraFin').getValue(),'Y-m-d H:i');
    if(calendario.$)
    {
    	var evento=calendario.$('#calendar').fullCalendar( 'clientEvents' ,'e_'+calendario.gE('idEvento').value )[0];
        if(evento)
        {
            var horaInicioAnterior=evento.start;
            var horaFinAnterior=evento.end;
            
            evento.start=moment(horaInicio);
            evento.end=moment(horaFin);
            if(calendario.existeTraslape(evento))
            {
                
                function resp22()
                {
                    evento.start=Date.parseDate(moment(horaInicioAnterior).format("YYYY-MM-DD HH:mm:ss"),'Y-m-d H:i:s');
                    evento.end=Date.parseDate(moment(horaFinAnterior).format("YYYY-MM-DD HH:mm:ss"),'Y-m-d H:i:s');
                    var fechaEvento=evento.start.format('Y-m-d');
                    
                    gEx('txtFechaEvento').setValue(fechaEvento);
                    gEx('cmbHoraInicio').setValue(evento.start.format('H:i:s'));
                    gEx('cmbHoraTermino').setValue(evento.end.format('H:i:s'));
                    var registro=calendario.$('#calendar').fullCalendar('updateEvent', evento);
                    //calcularHoraFinal(evento.start.format('H:i:s'));
                    
                       
                }
                msgBox('Ya existe un evento asignado en el horario que pretende programar',resp22);
                return;
            }
            evento.start=horaInicio;
            evento.end=horaFin;
            var registro=calendario.$('#calendar').fullCalendar('updateEvent', evento);
       }
       else
       {
       		var evento=	{};
            evento.id='e_'+calendario.gE('idEvento').value;
            evento.title='';
            evento.allDay=false;
            evento.start=moment(horaInicio);
            evento.end=moment(horaFin);
            evento.editable=true;
            evento.color='#900';
            var traslape=calendario.existeTraslape(evento);
            if(traslape)
            {
                function resp()
                {
                    
                    
                }
                msgBox('Ya existe un evento asignado en el horario que pretende programar',resp);
                return;
            }
            calendario.$('#calendar').fullCalendar('renderEvent', evento);
       }
	}
   
}

function guardarEvento()
{
    var cmbSalas=gEx('cmbSalas');
    var cmbEdificio=gEx('cmbEdificio');
    var cmbTipoAudiencia=gEx('cmbTipoAudiencia');
    var dteFecha=gEx('dteFecha');
    var cmbHoraInicio=gEx('tmeHoraInicio');
    var cmbHoraFin=gEx('tmeHoraFin');
    
    
    
    if(cmbSalas.getValue()=='')
    {
    	function resp2()
        {
        	cmbSalas.focus();
        }
        msgBox('Debe seleccionar la sala en la cual se llevar&aacute; a cabo la audiencia',resp2);
    	return;
    }
    
    if(cmbTipoAudiencia.getValue()=='')
    {
    	function resp3()
        {
        	cmbTipoAudiencia.focus();
        }
        msgBox('Debe indicar el tipo de audiencia a agendar',resp3);
    	return;
    }
    
    if(dteFecha.getValue()=='')
    {
    	function resp30()
        {
        	dteFecha.focus();
        }
        msgBox('Debe indicar la fecha en la cual desea programar la audiencia a agendar',resp30);
    	return;
    }
    
    if(cmbHoraInicio.getValue()=='')
    {
    	function resp31()
        {
        	cmbHoraInicio.focus();
        }
        msgBox('Debe indicar la hora de inicio de la audiencia a agendar',resp31);
    	return;
    }
    
    if(cmbHoraFin.getValue()=='')
    {
    	function resp32()
        {
        	cmbHoraFin.focus();
        }
        msgBox('Debe indicar la hora de t&eacute;rmino de la audiencia a agendar',resp32);
    	return;
    }
    
    var hInicio=Date.parseDate(dteFecha.getValue().format('Y-m-d')+' '+cmbHoraInicio.getValue(),'Y-m-d H:i');
    var hFin=Date.parseDate(dteFecha.getValue().format('Y-m-d')+' '+cmbHoraFin.getValue(),'Y-m-d H:i');
   
    if(hInicio>hFin)
    {
    	function resp40()
        {
        	cmbHoraFin.focus();
        }
        msgBox('La hora de inicio NO puede ser mayor que la hora de t&eacute;mino',resp40);
    	return;
    }
    var oJuez='';
    var arrJueces='{"idUsuario":"'+gE('idJuez').value+'","participacion":"'+gE('participacion').value+
    			'","ministerioLey":"0","serieRonda":"'+gE('serieRonda').value+'","noRonda":"'+gE('noRonda').value+
                '","tipoJuez":"'+gE('tipoJuez').value+'","pagoAdeudo":"'+gE('pagoAdeudo').value+
                '","arrJuecesBloquear":['+(gE('arrJuecesBloquear').value!=''?bD(gE('arrJuecesBloquear').value):'')+
                ']}';
    
    var aRecursosAdicionales='';
    var aRecursosRemovidos='';
    
    var x;
    for(x=0;x<arrRecursosRemovidos.length;x++)
    {
    	if(aRecursosRemovidos=='')
        	aRecursosRemovidos=arrRecursosRemovidos[x];
        else
        	aRecursosRemovidos+=','+arrRecursosRemovidos[x];
    }
    var objRecurso='';
    var fila;
    var gRecursosAdicionales=gEx('gRecursosAdicionales');
    
    
    
    for(x=0;x<gRecursosAdicionales.getStore().getCount();x++)
    {
    	fila=gRecursosAdicionales.getStore().getAt(x);
    	objRecurso='{"idRegistroRecurso":"'+fila.data.idRegistro+'","tipoRecurso":"'+fila.data.tipoRecurso+'","idRecurso":"'+fila.data.idRecurso+
        			'","horaInicio":"'+fila.data.horaInicio.format('Y-m-d H:i:s')+'","horaTermino":"'+fila.data.horaTermino.format('Y-m-d H:i:s')+
                    '","comentariosAdicionales":"'+cv(fila.data.comentariosAdicionales)+'"}';
    	
    	if(aRecursosAdicionales=='')
        	aRecursosAdicionales=objRecurso;
        else
        	aRecursosAdicionales+=','+objRecurso;
    }
	
    var fechaBase=new Date.parseDate('2020-08-03','Y-m-d');
   	
    if(dteFecha.getValue()>=fechaBase)
    {
    	/*if(gRecursosAdicionales.getStore().getCount()>0)
        {
            function respCub()
            {
            	gEx('tPanelAudiencia').setActiveTab(1);
            }
            msgBox('Cub&iacute;culos NO disponibles',respCub);
	        return;
    	}*/
    }
	
    var arrParticipantes='';
	var audienciaVirtualLatisMeeting='{}';
    var p;
    
    var gPerfilParticipacion=gEx('gPerfilParticipacion');
    for(x=0;x<gPerfilParticipacion.getStore().getCount();x++)
    {
    	fila=gPerfilParticipacion.getStore().getAt(x);
    	p='{"idParticipante":"'+fila.data.idParticipante+'","perfilParticipante":"'+fila.data.perfilParticipante+
        	'","nombreParticipante":"'+fila.data.nombreParticipante+'"}';
    	if(arrParticipantes=='')
        	arrParticipantes=p;
        else	
        	arrParticipantes+=','+p;
    }
    
    
    if(esAudienciaLatisMeting)
    {
    	audienciaVirtualLatisMeeting='{"requiereMesaEvidencias":"'+gEx('cmbMesaEvidencias').getValue()+
        						'","auxiliarSala":"'+(idUsuarioAuxiliarSalas==''?-1:idUsuarioAuxiliarSalas)+
                                '","participantes":['+arrParticipantes+']}';
    }
    
    
    

    var cadObj='{"idEvento":"'+gE('idRegistroEvento').value+'","unidadGestion":"'+gE('idUnidadGestion').value+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+
    			'","edificio":"'+cmbEdificio.getValue()+'","sala":"'+cmbSalas.getValue()+'","tipoAudiencia":"'+cmbTipoAudiencia.getValue()+
                '","fecha":"'+dteFecha.getValue().format('Y-m-d')+'","horaInicio":"'+cmbHoraInicio.getValue()+'","horaFin":"'+
                cmbHoraFin.getValue()+'","jueces":['+arrJueces+'],"idFormulario":"'+gE('idFormulario').value+
                '","idRegistroSolicitud":"'+gE('idRegistro').value+'","arrJuezOriginal":"'+(gE('arrJuezOriginal').value)+
                '","recursosAdicionales":['+aRecursosAdicionales+'],"recursosRemovidos":['+aRecursosRemovidos+
                '],"audienciaVirtualLatisMeeting":'+audienciaVirtualLatisMeeting+',"esLatisMeeting":"'+(esAudienciaLatisMeting?1:0)+'"}';
                
	
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	gE('lblStatusAudiencia').innerHTML=formatearValorRenderer(arrSituacionAudiencia,'1');
            gEx('btnModificar').show();
            gEx('btnConfirmar').hide();
	        gE('idRegistroEvento').value=arrResp[1];
            gE('idAudiencia').innerHTML=gE('idRegistroEvento').value;
        	function resp()
            {
                
                if(window.parent.mostrarMenuDTD)
                    window.parent.mostrarMenuDTD();
                
                if((window.parent.regresar1Pagina)&&(gE('idFormulario').value=='185'))
                	window.parent.regresar1Pagina(true);
                gEx('btnMdificarJuez').show();
                gEx('btnAsignarJuezExcusa').show();
                gEx('btnInicializar').hide();
                
                gEx('chkJuezTramite').hide();
                gE('arrJuezOriginal').value='';
				gE('arrJuecesBloquear').value='';
                gE('arrJuecesExcusa').value='';
                
                gE('idJuezOriginal').value=gE('idJuez').value;
                    
                gEx('gRecursosAdicionales').getStore().reload();    
            }
            msgBox('La audiencia ha sido agendada con &eacute;xito',resp);
            return;
        }
        else
        {
        	if(arrResp[0]=='0')
            {
            	msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[1]);
            }
            else
	            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=201&cadObj='+cadObj,true);
    
    
}

function limpiarDatosEvento()
{
	gEx('cmbTribunalAlzada').setValue('');
    gEx('cmbNoToca').setValue('');
    gEx('cmbTipoTribunal').setValue('');    
    gEx('cmbEdificio').setValue('');
    gEx('cmbSalas').setValue('');
    gEx('cmbTipoAudiencia').setValue('');
    gEx('dteFecha').setValue('<?php echo date('Y-m-d')?>');    
    gEx('tmeHoraInicio').setValue('');
    gEx('tmeHoraFin').setValue('');    
    gEx('gMagistrados').getStore().removeAll();
    gEx('frameContenidoAgenda').load	(
    								{
                                    	url:'../paginasFunciones/white.php'
                                    }
    							)
    
}

function asignarJuez()
{
	var cadObj='{"tipoAudiencia":"'+gE('tipoAudiencia').value+'","idFormulario":"'+gE('idFormulario').value+'","idRegistroSolicitud":"'+
    			gE('idRegistro').value+'","idUnidadGestion":"'+gE('idUnidadGestion').value+'","fechaAudiencia":"'+
    			gEx('dteFecha').getValue().format('Y-m-d')+'","arrJuecesExcusa":"'+gE('arrJuecesExcusa').value+'"}';
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
			var obj=eval('['+arrResp[1]+']')[0];
           
            gE('tipoJuez').value=obj.tipoJuez;
            gE('participacion').value=obj.participacion;
            gE('serieRonda').value=obj.serieRonda;
            gE('noRonda').value=obj.noRonda;
            gE('pagoAdeudo').value=obj.pagoAdeudo;
            gE('idJuez').value=obj.idJuez;
            gE('nombreJuez').value=bE(obj.nombreJuez);
            gE('arrJuecesBloquear').value=obj.arrJuecesBloquear;
            if(obj.idJuez!='-1')
            {
                gEx('fsJuez').show();
                gE('lblJuez').innerHTML=obj.nombreJuez;
                gEx('btnAsignarJuez').hide();
                gEx('btnMdificarJuez').show();
                gEx('btnAsignarJuezExcusa').show();
                cargarDatosAgenda();
			}
            else
            {
            	msgBox('NO existen jueces disponibles en la fecha indicada');
            }            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=202&cadObj='+cadObj,true);
}

function obtenerJuezTramite()
{
	gEx('fsJuez').hide();
	var cadObj='{"tipoAudiencia":"'+gE('tipoAudiencia').value+'","idUnidadGestion":"'+gE('idUnidadGestion').value+'","fechaAudiencia":"'+gEx('dteFecha').getValue().format('Y-m-d')+'"}';
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
			var obj=eval('['+arrResp[1]+']')[0];
			gE('arrJuecesBloquear').value=obj.arrJuecesBloquear;
           	gE('arrJuecesExcusa').value='';
            gE('tipoJuez').value=obj.tipoJuez;
            gE('participacion').value=obj.participacion;
            if(gE('serieRonda').value.indexOf('_D')==-1)
            {
                gE('serieRonda').value=gE('serieRonda').value+'_D';
            }
            //gE('serieRonda').value=obj.serieRonda;
            gE('noRonda').value=obj.noRonda;
            gE('pagoAdeudo').value=obj.pagoAdeudo;
            gE('idJuez').value=obj.idJuez;
            gE('nombreJuez').value=bE(obj.nombreJuez);
            if(obj.idJuez!='-1')
            {
                gEx('fsJuez').show();
                gE('lblJuez').innerHTML=obj.nombreJuez;
                gEx('btnAsignarJuez').hide();
                gEx('btnMdificarJuez').hide();
                gEx('btnAsignarJuezExcusa').hide();
                gEx('btnInicializar').hide();
			}
            else
            {
            	function respAux()
                {
                	gEx('btnAsignarJuez').show();
                    gEx('fsJuez').hide();
                    gEx('btnMdificarJuez').hide();
                    gEx('btnAsignarJuezExcusa').hide();
                    gEx('chkJuezTramite').setValue(false);
                }
            	msgBox('NO existe juez de tr&aacute;mite configurado para la fecha indicada',respAux);
            }            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=203&cadObj='+cadObj,true);
}

function mostrarModificacionJuez()
{
    var cmbJueces=crearComboExt('cmbJueces',[],180,45,350);
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                            x:20,
                                                            y:20,
                                                            xtype:'label',
                                                            html:'<span style="font-size:12px;font-family: Arial;font: 10px "Segoe UI", Arial, Helvetica, sans-serif;">Juez actual asignado: <span style="color:#F00">*</span></span>'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            width:480,
                                                            readOnly:true,
                                                            x:180,
                                                            y:15,
                                                            value:bD(gE('nombreJuez').value)
                                                        },
                                                        {
                                                            x:20,
                                                            y:50,
                                                            xtype:'label',
                                                            html:'<span style="font-size:12px;font-family: Arial;font: 10px "Segoe UI", Arial, Helvetica, sans-serif;">Juez a asignar: <span style="color:#F00">*</span></span>'
                                                        },
                                                        cmbJueces,
                                                        
                                                        
                                                        
                                                        {
                                                            x:20,
                                                            y:80,
                                                            xtype:'label',
                                                            html:'<span style="font-size:12px;font-family: Arial;font: 10px "Segoe UI", Arial, Helvetica, sans-serif;">Motivo del cambio:<span style="color:#F00"></span></span>'
                                                        },
                                                        {
                                                        	x:20,
                                                            y:110,
                                                            width:660,
                                                            height:60,
                                                            xtype:'textarea',
                                                           	id:'txtComentarios'
                                                        }
                                                        

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar Juez',
										width: 720,
										height:280,
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
                                                                        gEx('txtComentarios').focus(false,500);
                                                                    }
                                                                }
                                                    },
										buttons:	[
														{
                                                            text:'Aceptar',
                                                            handler:function()
                                                                    {
                                                                        if(cmbJueces.getValue()=='')
                                                                        {
                                                                            function resp()
                                                                            {
                                                                                cmbJueces.focus();
                                                                                
                                                                            }
                                                                            msgBox('Debe indicar el juez a asignar',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(gEx('txtComentarios').getValue()=='')
                                                                        {
                                                                            function resp2()
                                                                            {
                                                                                gEx('txtComentarios')
                                                                                
                                                                            }
                                                                            msgBox('Debe indicar del motivo del cambio',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        var cadObj='';
                                                                        
                                                                        if(
                                                                        	(gE('serieRonda').value.indexOf('_D')==-1)
                                                                            ||
                                                                        	(
                                                                            	(gE('idJuezOriginal').value!='-1')&& 
                                                                                (gE('idJuezOriginal').value!=gEx('cmbJueces').getValue())
                                                                            )
                                                                        )
                                                                        {
                                                                        	cadObj='{"serieRonda":"'+gE('serieRonda').value+'","noRonda":"'+gE('noRonda').value+'","idJuez":"'+gE('idJuez').value+
                                                                        			'","comentariosAdicionales":"'+cv(gEx('txtComentarios').getValue())+'"}';
                                                                      		 gE('arrJuezOriginal').value=bE(cadObj);
                                                                        }
                                                                        
                                                                       
                                                                       	if(gE('serieRonda').value.indexOf('_D')==-1)
                                                                        {
                                                                        	gE('serieRonda').value=gE('serieRonda').value+'_D';
                                                                        }
                                                                        
                                                                        //gE('noRonda').value='0';
                                                                        gE('idJuez').value=gEx('cmbJueces').getValue();
                                                                        gE('nombreJuez').value=bE(gEx('cmbJueces').getRawValue().split(' (')[0]);
                                                                        gE('lblJuez').innerHTML=bD(gE('nombreJuez').value);
                                                                        gE('pagoAdeudo').value='0';
                                                                        gE('arrJuecesExcusa').value='';
                                                                        if(gE('idRegistroEvento').value=='-1')
                                                                        {
                                                                            //gEx('chkJuezTramite').hide();
                                                                            
                                                                            gEx('btnInicializar').show();
                                                                            //gEx('btnMdificarJuez').hide();
                                                                            gEx('btnAsignarJuezExcusa').hide();
																		}                                                                        
                                                                        cargarDatosAgenda();
                                                                        ventanaAM.close();  
                                                                        
                                                                    }
                                                            
                                                        },
                                                        {
                                                           	text:'Cancelar',
                                                            handler:function()
                                                                    {
                                                                        ventanaAM.close();  
                                                                    }
                                                            
                                                        }
													]
									}
								);
	ventanaAM.show();
    obtenerJuecesCambio()
              
         
}

function obtenerJuecesCambio()
{
	function respAux2(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrDatos=eval(arrResp[1]);
            gEx('cmbJueces').setValue('');
            gEx('cmbJueces').getStore().loadData(arrDatos);
           
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',respAux2, 'POST','funcion=204&cA='+gE('carpetaAdministrativa').value+'&mostrarTodosJueces=1&iE='+
    				bE(gE('idRegistroEvento').value)+'&fE='+bE(gEx('dteFecha').getValue().format('Y-m-d'))+'&iUG='+bE(gE('idUnidadGestion').value),true);
}

function mostrarVentanaMotivoExcusa()
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
                                            				html:'Motivo de la Excusa:'
                                            			},
                                            			{
                                            				x:10,
                                            				y:40,
                                            				xtype:'textarea',
                                            				width:550,
                                            				height:60,
                                            				id:'txtMotivoExcusa'
                                            			}
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Motivo Excusa',
										width: 600,
										height:190,
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
																	gEx('txtMotivoExcusa').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		if(gEx('txtMotivoExcusa').getValue()=='')
																		{
																			function respMotivo()
																			{
																				gEx('txtMotivoExcusa').focus();
																			}
																			msgBox('Debe indicar el motivo de la excusa',respMotivo);
																			return;
																			
																		}
																		
																		var aJueces='';
																		var arrJuecesExcusa=gE('arrJuecesExcusa').value;
																		
																		if(arrJuecesExcusa!='')
																	   	{
																	   		
																	   		arrJuecesExcusa=eval(bD(arrJuecesExcusa));
																	   		var x;
																	   		var o;
																	   		for(x=0;x<arrJuecesExcusa.length;x++)
																	   		{
																	   			o='{"idJuez":"'+arrJuecesExcusa[x].idJuez+
																	   				'","motivoExcusa":"'+cv(arrJuecesExcusa[x].motivoExcusa)+'"}';
																	   			
																	   			if(aJueces=='')
																	   				aJueces=o;
																	   			else
																	   				aJueces+=','+o;
																	   		}
																		}
																	   
																	  
																	   if(aJueces!='')
																	   		aJueces+=',{"idJuez":"'+gE('idJuez').value+'","motivoExcusa":"'+cv(gEx('txtMotivoExcusa').getValue())+'"}';
																	   else
																	   		aJueces='{"idJuez":"'+gE('idJuez').value+'","motivoExcusa":"'+cv(gEx('txtMotivoExcusa').getValue())+'"}'
																		gE('arrJuecesExcusa').value=bE('['+aJueces+']'); 
																		asignarJuez();
																		gEx('btnInicializar').show();
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

function mostrarVentanaAgregarRecursoAudiencia(fRecurso)
{
	idRegistroRecursoIng=fRecurso?fRecurso.data.idRegistro:-1;
	var cmbTipoRecurso=crearComboExt('cmbTipoRecurso',arrTiposRecurso,140,5,200);
    cmbTipoRecurso.on('select',	function(cmb,registro)
    							{
                                	function funcAjax()
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                        	gEx('cmbNombreRecurso').setValue('');
                                            var arrRecursos=eval(arrResp[1]);
                                            gEx('cmbNombreRecurso').getStore().loadData(arrRecursos);
                                        }
                                        else
                                        {
                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                        }
                                    }
                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=302&tR='+registro.data.id,true);
                                    
                                    
                                }
    				)
    
    
    
    
    var cmbNombreRecurso=crearComboExt('cmbNombreRecurso',[],10,65,330);
	cmbNombreRecurso.on('select',function()
    							{
                                	cargarDatosAgendaRecursosEvento();
                                }
    					)
    
    
    
    var cmbHoraInicial=crearComboExt('cmbHoraInicial',arrHoras,245,95,95);
    cmbHoraInicial.setValue(gEx('tmeHoraInicio').getValue());
    cmbHoraInicial.on('select',function(cmb,registro)
    								{
	                                    calcularHoraFinalRecursoAudiencia(registro.data.id);
                                    }
    					)
    
    
    
    var cmbHoraFinal=crearComboExt('cmbHoraFinal',arrHoras,140,125,95);
    cmbHoraFinal.setValue(gEx('tmeHoraFin').getValue());
    cmbHoraFinal.on('select',function(cmb,registro)
    								{
	                                    calcularTiempoEstimadoAudiencia();
                                    }
    					)
    
                                                                                                                            
                                                                                                                            
    
    
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'panel',
                                                            region:'center',
                                                            items:	[
                                                            			new Ext.ux.IFrameComponent({ 
                
                                                                                                          id: 'frameContenidoAgendaRecursos', 
                                                                                                          anchor:'100% 100%',
                                                                                                          region:'center',
                                                                                                          border:true,
                                                                                                          loadFuncion:function(iFrame)
                                                                                                                      {
                                                                                                                          //autofitIframe(iFrame);
                                                                                                                      },
            
                                                                                                          url: '../paginasFunciones/white.php',
                                                                                                          style: 'width:100%;height:370px' 
                                                                                                  })
                                                            		]
                                                        },
                                                        {
                                                        	xtype:'panel',
                                                            region:'east',
                                                            width:350,
                                                            layout:'absolute',
                                                            items:	[
                                                            			{
                                                                        	x:10,
                                                                            y:10,
                                                                            xtype:'label',
                                                                            html:'<b>Tipo de recurso:</b>'
                                                                        },
                                                                        cmbTipoRecurso,
                                                                        {
                                                                        	x:10,
                                                                            y:40,
                                                                            xtype:'label',
                                                                            html:'<b>Nombre del recurso:</b>'
                                                                        },
                                                                        cmbNombreRecurso,
                                                                        {
                                                                        	x:10,
                                                                            y:100,
                                                                            xtype:'label',
                                                                            html:'<b>Horario requerido:</b>'
                                                                        },
                                                                        {
                                                                        	x:102,
                                                                            y:130,
                                                                            xtype:'label',
                                                                            html:'<b>a:</b>'
                                                                        },
                                                                        {
                                                                        	xtype:'datefield',
                                                                            x:140,
                                                                            y:95,
                                                                            disabled:true,
                                                                            width:95,
                                                                            value:gEx('dteFecha').getValue(),
                                                                            id:'dteHoraInicial'
                                                                        },
                                                                        cmbHoraInicial,
                                                                        cmbHoraFinal,
                                                                        {
                                                                        	xtype:'datefield',
                                                                            x:245,
                                                                            y:125,
                                                                            width:95,
                                                                            value:gEx('dteFecha').getValue(),
                                                                            id:'dteHoraFinal'
                                                                        },
                                                                        {
                                                                        	x:10,
                                                                            y:160,
                                                                            xtype:'label',
                                                                            html:'<b>Comentarios adicionales:</b>'
                                                                        },
                                                                        {
                                                                        	x:10,
                                                                            y:190,
                                                                            xtype:'textarea',
                                                                            width:330,
                                                                            id:'comentariosAdicionalesRecurso'
                                                                        }
                                                                        
                                                            		]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: (fRecurso?'Modificar':'Agregar')+' recurso a audiencia',
										width: 900,
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
                                                            id:'btnAceptarRecursos',
                                                            disabled:true,
															handler: function()
																	{
																		var dteHoraInicial=gEx('dteHoraInicial');
                                                                        var cmbHoraInicial=gEx('cmbHoraInicial');
                                                                        var dteHoraFinal=gEx('dteHoraFinal');
                                                                        var cmbHoraFinal=gEx('cmbHoraFinal');
                                                                        
                                                                        
                                                                        if(cmbNombreRecurso.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	cmbNombreRecurso.focus();
                                                                            }
                                                                            msgBox('Debe indicar el recurso que desea agregar',resp1)
                                                                        	return;
                                                                        }
                                                                        
                                                                        var fInicial=Date.parseDate(dteHoraInicial.getValue().format('Y-m-d')+' '+cmbHoraInicial.getValue(),'Y-m-d H:i');
                                                                        var fFinal=Date.parseDate(dteHoraFinal.getValue().format('Y-m-d')+' '+cmbHoraFinal.getValue(),'Y-m-d H:i');
                                                                        if(fInicial>fFinal)
                                                                        {
                                                                        	function respAux()
                                                                            {
                                                                            	dteHoraInicial.focus();
                                                                            }
                                                                            msgBox('La hora de inicio NO puede ser mayor que la hora de t&eacute;rmino',respAux);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        var fechaInicialAudiencia=Date.parseDate(gEx('dteFecha').getValue().format('Y-m-d')+' '+gEx('tmeHoraInicio').getValue(),'Y-m-d H:i');
    
                                                                        var fechaFinalAudiencia=Date.parseDate(gEx('dteFecha').getValue().format('Y-m-d')+' '+gEx('tmeHoraFin').getValue(),'Y-m-d H:i');
    
                                                                        
                                                                        if(fFinal>fechaFinalAudiencia)
                                                                        {
                                                                        	function respAux2()
                                                                            {
                                                                            	dteHoraInicial.focus();
                                                                            }
                                                                            msgBox('La hora de t&eacute;rmino NO puede ser mayor que la hora de t&eacute;rmino de la audiencia',respAux2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var idRegistroRecurso=idRegistroRecursoIng;
                                                                        var x;
                                                                        var gRecursosAdicionales=gEx('gRecursosAdicionales');
                                                                        
                                                                        var fila;
                                                                        var enc=false;
                                                                        for(x=0;x<gRecursosAdicionales.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gRecursosAdicionales.getStore().getAt(x);
                                                                            if((fila.data.tipoRecurso==cmbTipoRecurso.getValue())&&(fila.data.idRecurso==cmbNombreRecurso.getValue()&&(fila.data.idRegistro!=idRegistroRecurso)))
                                                                            {
                                                                            	enc=true;
                                                                                break;
                                                                            }
                                                                        }
                                                                        
                                                                        if(enc)
                                                                        {
                                                                        	msgBox('El recurso a agregar ya ha sido registrado previamente en esta audiencia');
                                                                        	return;
                                                                        }
                                                                        else
                                                                        {
                                                                        
                                                                        	if((idRegistroRecurso==-1)&&(!fRecurso))
                                                                            {
                                                                                var r=new regRecursosAdicionales	(
                                                                                                                        {
                                                                                                                            idRegistro:idRegistroRecurso,
                                                                                                                            tipoRecurso:cmbTipoRecurso.getValue(), 
                                                                                                                            idRecurso:cmbNombreRecurso.getValue(),
                                                                                                                            horaInicio:fInicial,
                                                                                                                            horaTermino:fFinal,
                                                                                                                            comentariosAdicionales:gEx('comentariosAdicionalesRecurso').getValue(),
                                                                                                                            alertas:''
                                                                                                                        }
                                                                                                                    )
																			
                                                                            	gRecursosAdicionales.getStore().add(r);
                                                                            }
                                                                            else
                                                                            {
                                                                            	fRecurso.set('tipoRecurso',cmbTipoRecurso.getValue());
                                                                                fRecurso.set('idRecurso',cmbNombreRecurso.getValue());
                                                                                fRecurso.set('horaInicio',fInicial);
                                                                                fRecurso.set('horaTermino',fFinal);
                                                                                fRecurso.set('comentariosAdicionales',gEx('comentariosAdicionalesRecurso').getValue());
                                                                                fRecurso.set('alertas','');
                                                                            }
                                                                        }
                                                                        if(gEx('chkVisualizarAgendaRecursos').getValue())
                                                                        {
                                                                        	cargarDatosAgenda();
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
    
    if(fRecurso)
    {
    	cmbTipoRecurso.setValue(fRecurso.data.tipoRecurso);
        cmbHoraInicial.setValue(fRecurso.data.horaInicio.format("H:i"));
        cmbHoraFinal.setValue(fRecurso.data.horaTermino.format("H:i"));
        gEx('dteHoraInicial').setValue(fRecurso.data.horaInicio);
        gEx('dteHoraFinal').setValue(fRecurso.data.horaTermino);
        gEx('comentariosAdicionalesRecurso').setValue(escaparBR(fRecurso.data.comentariosAdicionales,true));
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                
                var arrRecursos=eval(arrResp[1]);
                gEx('cmbNombreRecurso').getStore().loadData(arrRecursos);
                gEx('cmbNombreRecurso').setValue(fRecurso.data.idRecurso);
                dispararEventoSelectCombo('cmbNombreRecurso');
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=302&tR='+fRecurso.data.tipoRecurso,true);
    }
    
    
    var horaInicio=Date.parseDate(gEx('dteHoraInicial').getValue().format('Y-m-d')+' '+cmbHoraInicial.getValue(),'Y-m-d H:i');
    var horaFin=Date.parseDate(gEx('dteHoraFinal').getValue().format('Y-m-d')+' '+cmbHoraFinal.getValue(),'Y-m-d H:i')
    lblDuracionRecursoAudiencia=((horaFin-horaInicio+0)/60000);	
	
}

function cargarDatosAgendaRecursosEvento()
{
	if(gEx('cmbNombreRecurso').getValue()=='')
    {
    	gEx('frameContenidoAgendaRecursos').load	(
                                                        {
                                                            url:'../paginasFunciones/white.php'

                                                        }
                                                    )
    	return;
    }
   

    
    var oParams={
                    tipoRecurso:gEx('cmbTipoRecurso').getValue(),
                    cPagina:'sFrm=true',
                    idRecurso:gEx('cmbNombreRecurso').getValue() ,
                    fechaBase: gEx('dteHoraInicial').getValue().format('Y-m-d'),
                    idRegistroRecurso:idRegistroRecursoIng,
                    idEvento:gE('idRegistroEvento').value,
                    idUnidadGestion:gE('idUnidadGestion').value
                    
                }
    
    
	gEx('frameContenidoAgendaRecursos').load	(
                                                    {
                                                        url:'../modulosEspeciales_SGJP/calendarioEventosRecursosAudiencia.php',
                                                        params:	oParams
                                                    }
                                                )
}

function calcularHoraFinalRecursoAudiencia(horaInicial)
{
	
	var duracionOriginal=parseInt(lblDuracionRecursoAudiencia);
    
	var fechaInicio=gEx('dteHoraInicial').getValue().format('Y-m-d');
    fechaInicio+=' '+horaInicial;
    
    var dteFechaInicio=Date.parseDate(fechaInicio,'Y-m-d H:i');
   
    var dteFechaFin=dteFechaInicio.add(Date.MINUTE,duracionOriginal);
    
    
	gEx('cmbHoraFinal').setValue(dteFechaFin.format('H:i')); 
    
    gEx('cmbHoraInicial').setValue(dteFechaInicio.format('H:i')); 
   	gEx('dteHoraFinal').setValue(dteFechaFin.format('Y-m-d'));
    
    
    
    
    calcularTiempoEstimadoAudiencia();   
   
    
       
}

function calcularTiempoEstimadoAudiencia()
{
	var horaInicio=Date.parseDate(gEx('dteHoraInicial').getValue().format('Y-m-d')+' '+gEx('cmbHoraInicial').getValue(),'Y-m-d H:i');
    var horaFin=Date.parseDate(gEx('dteHoraFinal').getValue().format('Y-m-d')+' '+gEx('cmbHoraFinal').getValue(),'Y-m-d H:i');
	lblDuracionRecursoAudiencia=((horaFin-horaInicio+0)/60000);
    
    ajustarEventoRecursoAudiencia();
}

function ajustarEventoRecursoAudiencia()
{
	var calendario=gEx('frameContenidoAgendaRecursos').getFrameWindow();	
    var horaInicio=Date.parseDate(gEx('dteHoraInicial').getValue().format('Y-m-d')+' '+gEx('cmbHoraInicial').getValue(),'Y-m-d H:i');
   
    var horaFin=Date.parseDate(gEx('dteHoraFinal').getValue().format('Y-m-d')+' '+gEx('cmbHoraFinal').getValue(),'Y-m-d H:i');
	
    
    
    if(calendario.$)
    {
    	var evento=calendario.$('#calendar').fullCalendar( 'clientEvents' ,'e_'+calendario.gE('idRegistroRecurso').value )[0];
        if(evento)
        {
            var horaInicioAnterior=evento.start;
            var horaFinAnterior=evento.end;
            
            evento.start=moment(horaInicio);
            evento.end=moment(horaFin);
            if(calendario.existeTraslape(evento))
            {
                
                function resp22()
                {
                    evento.start=Date.parseDate(moment(horaInicioAnterior).format("YYYY-MM-DD HH:mm:ss"),'Y-m-d H:i:s');
                    evento.end=Date.parseDate(moment(horaFinAnterior).format("YYYY-MM-DD HH:mm:ss"),'Y-m-d H:i:s');
                    var fechaEvento=evento.start.format('Y-m-d');
                    
                    gEx('txtFechaEvento').setValue(fechaEvento);
                    gEx('cmbHoraInicio').setValue(evento.start.format('H:i:s'));
                    gEx('cmbHoraTermino').setValue(evento.end.format('H:i:s'));
                    var registro=calendario.$('#calendar').fullCalendar('updateEvent', evento);
                    
                       
                }
                msgBox('Ya existe un evento asignado en el horario que pretende programar',resp22);
                return;
            }
            evento.start=horaInicio;
            evento.end=horaFin;
            var registro=calendario.$('#calendar').fullCalendar('updateEvent', evento);
       }
       else
       {
       		var evento=	{};
            evento.id='e_'+calendario.gE('idRegistroRecurso').value;
            evento.title='';
            evento.allDay=false;
            evento.start=moment(horaInicio);
            evento.end=moment(horaFin);
            evento.editable=true;
            evento.color='#900';
            var traslape=calendario.existeTraslape(evento);
            if(traslape)
            {
                function resp()
                {
                    
                    
                }
                msgBox('Ya existe un evento asignado en el horario que pretende programar',resp);
                return;
            }
            calendario.$('#calendar').fullCalendar('renderEvent', evento);
       }
	}
   
}

function ajustarFechaRecursoAudiencia(evento)
{

	gEx('dteHoraInicial').setValue(evento.start.format('YYYY-MM-DD'));
    gEx('cmbHoraInicial').setValue(evento.start.format('HH:mm'));    
    gEx('cmbHoraFinal').setValue(evento.end.format('HH:mm'));
	gEx('dteHoraFinal').setValue(evento.end.format('YYYY-MM-DD'));
    calcularTiempoEstimadoAudiencia();
}

function mostrarVentanaRemoverRecurso(fila)
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
                                                            html:'Indique el motivo por el cual remueve el recurso:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            xtype:'textarea',
                                                            width:560,
                                                            height:60,
                                                            id:'motivoRemueveRecurso'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Remover recurso',
										width: 600,
										height:180,
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
                                                                	gEx('motivoRemueveRecurso').focus(false,true);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		function resp(btn)
                                                                        {
                                                                            if(btn=='yes')
                                                                            {

                                                                            	var objRev='{"idRegistro":"'+fila.data.idRegistro+'","motivo":"'+cv(gEx('motivoRemueveRecurso').getValue())+'"}';
                                                                            	arrRecursosRemovidos.push(objRev);
                                                                            	
                                                                                
                                                                                gEx('gRecursosAdicionales').getStore().remove(fila);
                                                                                
                                                                                if(gEx('chkVisualizarAgendaRecursos').getValue())
                                                                                {
                                                                                    cargarDatosAgenda();
                                                                                }
                                                                                
                                                                                ventanaAM.close();
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer remover el recurso seleccionado?',resp);
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


function ajustarRecursosAdicionalesAudiencia(fechaInicial,fechaFinal)
{
	var fInicialRecurso;
    var fFinalRecurso;
	var fInicialActual=Date.parseDate(gEx('dteFecha').getValue().format('Y-m-d')+' '+gEx('tmeHoraInicio').getValue(),'Y-m-d H:i');
    var fFinalActual=Date.parseDate(gEx('dteFecha').getValue().format('Y-m-d')+' '+gEx('tmeHoraFin').getValue(),'Y-m-d H:i');
    
    var diferenciaHInicio=((fInicialActual-fechaInicial+0)/60000);
    var diferenciaHFin=((fFinalActual-fechaFinal+0)/60000);
    var diferenciaRecurso;
    var diferenciaHoraInicialRecurso;
   
	var gRecursosAdicionales=gEx('gRecursosAdicionales');
    var x;
    var fila;
    for(x=0;x<gRecursosAdicionales.getStore().getCount();x++)
    {
    	fila=gRecursosAdicionales.getStore().getAt(x);
        diferenciaRecurso=(fila.data.horaTermino-fila.data.horaInicio+0)/60000;
    	if((fila.data.horaInicio.format('Y-m-d H:i:s')==fechaInicial.format('Y-m-d H:i:s'))&&((fila.data.horaTermino.format('Y-m-d H:i:s')==fechaFinal.format('Y-m-d H:i:s'))))
        {	
        	fila.set('horaInicio',fInicialActual);
            fila.set('horaTermino',fFinalActual);
        }
        else
        {

        	diferenciaHoraInicialRecurso=(fila.data.horaInicio-fechaInicial+0)/60000;	
            fInicialRecurso=fInicialActual.add(Date.MINUTE,diferenciaHoraInicialRecurso);
            fFinalRecurso=fInicialRecurso.add(Date.MINUTE,diferenciaRecurso);
            
            if(fFinalRecurso>fFinalActual)
            {
            	fFinalRecurso=fFinalActual;
            }
            
            fila.set('horaInicio',fInicialRecurso);
            fila.set('horaTermino',fFinalRecurso);
            
        }
    }
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
