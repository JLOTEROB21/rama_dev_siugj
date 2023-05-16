<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT id__1_tablaDinamica,nombreInmueble FROM _1_tablaDinamica WHERE idEstado=2 ORDER BY nombreInmueble";
	$arrEdificios=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idSituacion,descripcionSituacion FROM 7011_situacionEventosAudiencia";
	$arrSituacionAudiencia=$con->obtenerFilasArreglo($consulta);
	
?>
var lblDuracionAudiencia=60;
var arrEdificios=<?php echo $arrEdificios?>;
var carpetaAdministrativa='';
var arrSituacionAudiencia=<?php echo $arrSituacionAudiencia?>;
Ext.onReady(inicializar);

function inicializar()
{
	var arrSalas=eval(bD(gE('arrSalas').value));
	lblDuracionAudiencia=parseInt(gE('duracionAudiencia').value);
	Ext.QuickTips.init();
	if(window.parent)
		window.parent.autoScroll=150;
	
                        
	var cmbSalas=crearComboExt('cmbSalas',arrSalas,130,85,220);
    cmbSalas.on('select',function(cmb,registro)
    					{
    						cargarDatosAgenda();                    
                        }
    			)
    
    
    var cmbEdificio=crearComboExt('cmbEdificio',arrEdificios,130,55,220);
    cmbEdificio.disable();

   
    cmbEdificio.on('select',function(cmb,registro)
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
                                        if(arrDatos.length==1)
                                        {
                                        	gEx('cmbSalas').setValue(arrDatos[0][0]);
                                            dispararEventoSelectCombo('cmbSalas');
                                        }
                                      	
                                        
                                        
                                       
                                    }
                                    else
                                    {
                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[1]);
                                    }
                                }
                                obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',respAux22, 'POST','funcion=5&idUnidadGestion='+
                                                    gE('idUnidadGestion').value+'&idEdificio='+registro.data.id,false);                  
                        }
    			)
                
                
                
	var cmbTipoAudiencia=  crearComboExt('cmbTipoAudiencia',eval(bD(gE('arrTipoAudiencia').value)),0,65,350);    
    cmbTipoAudiencia.on('select',function(cmb,registro)
    					{
    						lblDuracionAudiencia=parseInt(registro.data.valorComp);                    
                        }
    			)
    
     cmbTipoAudiencia.setDisabled(true);         
   
    var horaInicial=new Date(2010,5,10,7,0);
	var horaFinal=new Date(2010,5,10,23,59);
    
	var arrHoras=generarIntervaloHoras(horaInicial,horaFinal,1,'H:i','H:i');
    
	var cmbHoraInicio=crearComboExt('tmeHoraInicio',arrHoras,130,115,90);
    cmbHoraInicio.on('select',function(cmb,registro)
    						{
                            	calcularHoraFinal(registro.data.id);
                            }
    		
            		)
   
   	var cmbHoraFin=crearComboExt('tmeHoraFin',arrHoras,245,115,90);
    cmbHoraFin.on('select',function()
    						{
                            	calcularTiempoEstimado()
                            }
    		
            		)
   
   
                                                                                        
   
    
    
    
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
                                                            	xtype:'panel',
                                                                hidden:gE('sL').value=='1',
                                                                layout:'absolute',
                                                                region:'east',
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
                                                                                height:410,
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
                                                                                                				select: function()
                                                                                                                		{
                                                                                                                        	if((gE('tipoCarpetaAdministrativa').value=='6')&&(gE('idJuez').value!='-1')&&(gE('idJuezResponsableCarpeta').value!='-1'))
                                                                                                                            {
                                                                                                                            	
                                                                                                                                asignarJuez();
                                                                                                                            }
                                                                                                                            else
                                                                                                                            {
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
                                                                                                                x:230,
                                                                                                                y:143,
                                                                                                                width:100,
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
                                                                                                                
                                                                                                            }	,
                                                                                                            {
                                                                                                                x:230,
                                                                                                                y:143,
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
                                                                                                                
                                                                                                            }	
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
                        
	var cmbTipoAudiencia=gEx('cmbTipoAudiencia');
    cmbTipoAudiencia.setValue(gE('tipoAudiencia').value);
    var cmbEdificio=gEx('cmbEdificio');
    cmbEdificio.setValue(gE('idEdificio').value);
    var cmbSalas=gEx('cmbSalas');

    
    if(arrSalas.length==1)
    {
		cmbSalas.setValue(arrSalas[0][0]);
        dispararEventoSelectCombo('cmbSalas');
    }
    
    
    
    
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
        gEx('chkJuezTramite').hide();
        
    }
    
    
    if(gE('idJuez').value!='-1')
    {
    	
    	gEx('chkJuezTramite').hide();
        gEx('btnAsignarJuez').hide();
        //gEx('btnMdificarJuez').show();
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
    	return;
    }
	var fila;
    var x;
    var listaJueces=gE('idJuez').value;
   
    
    
    if(listaJueces=='')
    	listaJueces=-1;
    
    var oParams={
                    idSala:gEx('cmbSalas').getValue(),
                    cPagina:'sFrm=true',
                    idJueces:listaJueces ,
                    idUnidadGestion:gE('idUnidadGestion').value,
                    iEvento:gE('idRegistroEvento').value,
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
	
	var duracionOriginal=parseInt(lblDuracionAudiencia);
    
	var fechaInicio=gEx('dteFecha').getValue().format('Y-m-d');
    fechaInicio+=' '+horaInicial;
    
    var dteFechaInicio=Date.parseDate(fechaInicio,'Y-m-d H:i');
   
    var dteFechaFin=dteFechaInicio.add(Date.MINUTE,duracionOriginal);
    
    
	gEx('tmeHoraFin').setValue(dteFechaFin.format('H:i')); 
    
    gEx('tmeHoraInicio').setValue(dteFechaInicio.format('H:i')); 
   
    calcularTiempoEstimado();   
   
    
       
}

function ajustarFechaEvento(evento)
{
	
	gEx('dteFecha').setValue(evento.start.format('YYYY-MM-DD'));
    gEx('tmeHoraInicio').setValue(evento.start.format('HH:mm'));    
    gEx('tmeHoraFin').setValue(evento.end.format('HH:mm'));

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
    
    var oJuez='';
    var arrJueces='{"idUsuario":"'+gE('idJuez').value+'","participacion":"'+gE('participacion').value+
    			'","ministerioLey":"0","serieRonda":"'+gE('serieRonda').value+'","noRonda":"'+gE('noRonda').value+
                '","tipoJuez":"'+gE('tipoJuez').value+'","pagoAdeudo":"'+gE('pagoAdeudo').value+
                '","arrJuecesBloquear":['+(gE('arrJuecesBloquear').value!=''?bD(gE('arrJuecesBloquear').value):'')+
                ']}';
    
    
    

    var cadObj='{"idEvento":"'+gE('idRegistroEvento').value+'","unidadGestion":"'+gE('idUnidadGestion').value+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+
    			'","edificio":"'+cmbEdificio.getValue()+'","sala":"'+cmbSalas.getValue()+'","tipoAudiencia":"'+cmbTipoAudiencia.getValue()+
                '","fecha":"'+dteFecha.getValue().format('Y-m-d')+'","horaInicio":"'+cmbHoraInicio.getValue()+'","horaFin":"'+
                cmbHoraFin.getValue()+'","jueces":['+arrJueces+'],"idFormulario":"'+gE('idFormulario').value+
                '","idRegistroSolicitud":"'+gE('idRegistro').value+'","arrJuezOriginal":"'+(gE('arrJuezOriginal').value)+'"}';
                
	
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
                if(window.parent.recargarContenedorCentral)
                	window.parent.recargarContenedorCentral();

                gEx('btnInicializar').hide();
                gEx('chkJuezTramite').hide();
                gE('arrJuezOriginal').value='';
				gE('arrJuecesBloquear').value='';
                gE('arrJuecesExcusa').value='';
                
                gE('idJuezOriginal').value=gE('idJuez').value;
                    
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
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Juzgados.php',funcAjax, 'POST','funcion=10&cadObj='+cadObj,true);
    
    
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
                //gEx('btnMdificarJuez').show();
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
