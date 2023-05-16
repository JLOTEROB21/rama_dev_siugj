<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$fechaActual=date("Y-m-d");
	
	$consulta="SELECT idSituacion,descripcionSituacion FROM 7011_situacionEventosAudiencia";
	$arrSituacionAudiencia=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT claveElemento,nombreElemento FROM 1018_catalogoVarios WHERE tipoElemento=37 ORDER BY nombreElemento";
	$arrTiposPersonas=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT id__5_tablaDinamica FROM _5_tablaDinamica";
	$listPartes=$con->obtenerListaValores($consulta);
	
	$consulta="SELECT id__998_tablaDinamica,nombreInstitucionEmpresa,email FROM _998_tablaDinamica ORDER BY nombreInstitucionEmpresa";
	$arrInstituciones=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__1138_tablaDinamica,nombreOficinaEntidades,(SELECT Mail FROM 805_mails WHERE idUsuario=t.idUsuario) AS email 
				FROM _1138_tablaDinamica t ORDER BY nombreOficinaEntidades";
	$arrEntidadesEmbargo=$con->obtenerFilasArreglo($consulta);

?>
var arrEntidadesEmbargo=<?php echo $arrEntidadesEmbargo?>;
var fechaActual='<?php echo $fechaActual?>';
var arrInstituciones=<?php echo $arrInstituciones?>;
var idActividad=-1;
var listPartes='<?php echo $listPartes?>';
var arrTiposPersonas=<?php echo $arrTiposPersonas?>;

var lblDuracionAudiencia=60;
var arrEdificios=[];
var carpetaAdministrativa='';
var arrSituacionAudiencia=<?php echo $arrSituacionAudiencia?>;
Ext.onReady(inicializar);

function inicializar()
{
	var arrJueces=bD(gE('nombreJuez').value);
    arrJueces=arrJueces.split('<br>');
	var tituloJueces='';
	var lblJueces='';
	if(arrJueces.length>3)
    {
    	var x;
        for(x=0;x<3;x++)
        {
        	if(lblJueces=='')
            	lblJueces=arrJueces[x];
            else
            	lblJueces+='<br>'+arrJueces[x];
        }
        
        lblJueces+='...';
        tituloJueces=bD(gE('nombreJuez').value);
        tituloJueces=tituloJueces.replace(/<br>/gi,'\r');

        
    }	
    else
    {
    	lblJueces=bD(gE('nombreJuez').value);
		tituloJueces=lblJueces;
	}
	idActividad=gE('idActividad').value;
	arrEdificios=eval(bD(gE('arrEdificios').value));
	var arrSalas=eval(bD(gE('arrSalas').value));
	lblDuracionAudiencia=parseInt(gE('duracionAudiencia').value);
	Ext.QuickTips.init();
	if(window.parent)
		window.parent.autoScroll=150;
	
                        
	
    
    
          
   
    var horaInicial=new Date(2010,5,10,7,0);
	var horaFinal=new Date(2010,5,10,23,59);
    
	var arrHoras=generarIntervaloHoras(horaInicial,horaFinal,1,'H:i','H:i');
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                cls:'panelSiugj',
                                                layout:'border',
                                                bbar:	[
                                                            {
                                                                xtype:'label',
                                                                html:'<table><tr><td><div style="width:10px; height:10px; border-radius:10px; background-color:#900; border-style:solid; border-width:1px; border-color:#900"></div></td><td> <div class="SIUGJ_Etiqueta12_Gris">Evento a modificar</div></td></tr></table>'
                                                            },
                                                            {
                                                            	xtype:'tbspacer',
                                                                width:5
                                                            }
                                                            ,
                                                            {
                                                                xtype:'label',
                                                                html:'<table><tr><td><div style="width:10px; height:10px; border-radius:10px; background-color:#030; border-style:solid; border-width:1px; border-color:#030"></div></td><td> <div class="SIUGJ_Etiqueta12_Gris">Eventos de la sala</div></td></tr></table>'
                                                            },
                                                            {
                                                            	xtype:'tbspacer',
                                                                width:5
                                                            },
                                                            {
                                                                xtype:'label',
                                                                html:'<table><tr><td><div style="width:10px; height:10px; border-radius:10px; background-color:#E56A4B; border-style:solid; border-width:1px; border-color:#E56A4B"></div></td><td> <div class="SIUGJ_Etiqueta12_Gris">Eventos de juez</div></td></tr></table>'
                                                            },
                                                            {
                                                            	xtype:'tbspacer',
                                                                width:5
                                                            },
                                                            {
                                                                xtype:'label',
                                                                html:'<table><tr><td><div style="width:10px; height:10px; border-radius:10px; background-color:#3D00CA; border-style:solid; border-width:1px; border-color:#3D00CA"></div></td><td> <div class="SIUGJ_Etiqueta12_Gris">No disponibilidad de juez</div></td></tr></table>'
                                                            },
                                                            {
                                                            	xtype:'tbspacer',
                                                                width:5
                                                            },
                                                            {
                                                                xtype:'label',
                                                                html:'<table><tr><td><div style="width:10px; height:10px; border-radius:10px; background-color:#B55381; border-style:solid; border-width:1px; border-color:#B55381"></div></td><td> <div class="SIUGJ_Etiqueta12_Gris">No disponibilidad de sala</div></td></tr></table>'
                                                            },
                                                            {
                                                            	xtype:'tbspacer',
                                                                width:5
							    },
								<?php
									if($considerarDisponibilidadSujetosProcesajes)
									{
								?>
                                                            {
                                                                xtype:'label',
                                                                html:'<table><tr><td><div style="width:10px; height:10px; border-radius:10px; background-color:#A89D07; border-style:solid; border-width:1px; border-color:#A89D07"></div></td><td> <div class="SIUGJ_Etiqueta12_Gris">Eventos de Participante</div></td></tr></table>'
							    },
								<?php
									}			
								?>
                                                            {
                                                            	xtype:'tbspacer',
                                                                width:70
                                                            },
                                                            
                                                            {
                                                               
                                                                width:140,
                                                                id:'btnConfirmar',
                                                                xtype:'button',
                                                                icon:'../images/icon_big_tick.gif',
                                                                cls:'btnSIUGJ',
                                                                text:'Confirmar audiencia',
                                                                handler:function()
                                                                        {
                                                                            function resp(btn)
                                                                            {
                                                                                if(btn=='yes')
                                                                                
                                                                                    guardarEvento();   
                                                                            }
                                                                            msgConfirm('Est&aacute; seguro de querer guardar la informaci&oacute;n de la audiencia',resp);
                                                                            return;
                                                                        }
                                                                
                                                            }	,
                                                            {
                                                                width:140,
                                                                hidden:true,
                                                                id:'btnModificar',
                                                                xtype:'button',
                                                                icon:'../images/pencil.png',
                                                                cls:'btnSIUGJ',
                                                                text:'Modificar audiencia',
                                                                handler:function()
                                                                        {
                                                                            function resp(btn)
                                                                            {
                                                                                if(btn=='yes')
                                                                                
                                                                                    guardarEvento();   
                                                                            }
                                                                            msgConfirm('Est&aacute; seguro de querer modificar la informaci&oacute;n de la audiencia',resp);
                                                                            return;
                                                                        }
                                                                
                                                            }
                                                            
                                                        ],
                                                items:	[
                                                			
                                                            {
                                                            	width:530,
                                                                xtype:'panel',
                                                                cls:'panelSiugj',
                                                                hidden:gE('sL').value=='1',
                                                                layout:'absolute',
                                                                region:'east',
                                                                items:	[
                                                                			{
                                                                                x:20,
                                                                                y:10,
                                                                                xtype:'label',
                                                                                cls:'SIUGJ_Etiqueta14_Gris',
                                                                                html:'ID Audiencia:'
                                                                            },
                                                                            {
                                                                                x:180,
                                                                                y:10,
                                                                                xtype:'label',
                                                                                cls:'SIUGJ_ControlEtiqueta14_Gris',
                                                                                html:'<span id="idAudiencia">NO Asignado</span>'
                                                                            },
                                                                			{
                                                                                x:20,
                                                                                y:30,
                                                                                xtype:'label',
                                                                                cls:'SIUGJ_Etiqueta14_Gris',
                                                                                html:'Situaci&oacute;n audiencia:'
                                                                            },
                                                                            {
                                                                                x:180,
                                                                                y:30,
                                                                                xtype:'label',
                                                                                cls:'SIUGJ_Etiqueta14_Gris',
                                                                                html:'<span id="lblStatusAudiencia">'+formatearValorRenderer(arrSituacionAudiencia,gE('situacionAudiencia').value)+'</span>'
                                                                            },
                                                                			{
                                                                            	xtype:'tabpanel',
                                                                                activeTab:0,
                                                                                id:'tabPanelAudiencia',
                                                                                x:10,
                                                                                y:55,
                                                                                cls:'tabPanelSIUGJ',
                                                                                
                                                                                width:510,
                                                                                height:500,//(obtenerDimensionesNavegador()[0]-65),
                                                                                items:	[	
                                                                							{
                                                                                            	xtype:'panel',
                                                                                                region:'center',
                                                                                                layout:'absolute',
                                                                                                baseCls: 'x-plain',
                                                                                                title:'Generales de audiencia',
                                                                                				items:	[
                                                                                                			 {
                                                                                                                x:10,
                                                                                                                y:5,
                                                                                                                xtype:'label',
                                                                                                                cls:'SIUGJ_Etiqueta14_Gris',
                                                                                                                html:'Proceso Judicial:'
                                                                                                            },                                                                                            
                                                                                                            {
                                                                                                                x:280,
                                                                                                                y:5,
                                                                                                                xtype:'label',
                                                                                                                cls:'SIUGJ_ControlEtiqueta14_Gris',
                                                                                                                html:gE('carpetaAdministrativa').value
                                                                                                            },
                                                                                                            {
                                                                                                                x:10,
                                                                                                                y:30,
                                                                                                                xtype:'label',
                                                                                                                cls:'SIUGJ_Etiqueta14_Azul',
                                                                                                                html:'Tipo de audiencia:'
                                                                                                            },
                                                                                                            {
                                                                                                                x:10,
                                                                                                                y:55,
                                                                                                                xtype:'label',
                                                                                                                html:'<div id="spTipoAudiencia"></div>'
                                                                                                            }
                                                                                                            ,
                                                                                                            {
                                                                                                                x:10,
                                                                                                                y:105,
                                                                                                                xtype:'label',
                                                                                                                cls:'SIUGJ_Etiqueta14_Azul',
                                                                                                                html:'Fecha de la audiencia:'
                                                                                                            },
                                                                                                            {
                                                                                                                x:10,
                                                                                                                y:130,
                                                                                                                xtype:'label',
                                                                                                                html:'<div id="spFechaAudiencia" style="width:480px"></div>'
                                                                                                            },
                                                                                                            {
                                                                                                                x:10,
                                                                                                                y:180,
                                                                                                                xtype:'label',
                                                                                                                cls:'SIUGJ_Etiqueta14_Azul',
                                                                                                                html:'Juez/Magistrado asignado:'
                                                                                                            },
                                                                                                            {
                                                                                                                x:10,
                                                                                                                y:205,
                                                                                                                xtype:'label',
                                                                                                                cls:'SIUGJ_ControlEtiqueta14_Gris',
                                                                                                                html:lblJueces
                                                                                                            }, 
                                                                                                            {
                                                                                                                x:10,
                                                                                                                y:255,
                                                                                                                xtype:'label',
                                                                                                                cls:'SIUGJ_Etiqueta14_Azul',
                                                                                                                html:'Sede:'
                                                                                                            },
                                                                                                            {
                                                                                                                x:80,
                                                                                                                y:250,
                                                                                                                xtype:'label',
                                                                                                                html:'<div id="spSede"></div>'
                                                                                                            },
                                                                                                            {
                                                                                                                x:10,
                                                                                                                y:305,
                                                                                                                xtype:'label',
                                                                                                                cls:'SIUGJ_Etiqueta14_Azul',
                                                                                                                html:'Sala:'
                                                                                                            },
                                                                                                            
                                                                                                            {
                                                                                                                x:80,
                                                                                                                y:300,
                                                                                                                xtype:'label',
                                                                                                                html:'<div id="spSala"></div>'
                                                                                                            } ,
                                                                                                            {
                                                                                                                x:10,
                                                                                                                y:355,
                                                                                                                xtype:'label',
                                                                                                                cls:'SIUGJ_Etiqueta14_Azul',
                                                                                                                html:'Hora:'
                                                                                                            },
                                                                                                            {
                                                                                                                x:80,
                                                                                                                y:350,
                                                                                                                xtype:'label',
                                                                                                                html:'<div id="spHoraInicio"></div>'
                                                                                                            } ,
                                                                                                            
                                                                                                            
                                                                                                            {
                                                                                                                x:270,
                                                                                                                y:350,
                                                                                                                xtype:'label',
                                                                                                                html:'<div id="spHoraFin"></div>'
                                                                                                            }
                                                                                                            
                                                                                                            
                                                                                                		]
                                                                                            },
                                                                                            {
                                                                                            	xtype:'panel',
                                                                                                region:'center',
                                                                                                layout:'absolute',
                                                                                                baseCls: 'x-plain',
                                                                                                title:'Complementarios',
                                                                                				items:	[
                                                                                                			{
                                                                                                            	x:10,
                                                                                                                y:10,
                                                                                                                cls:'SIUGJ_Etiqueta14_Gris',
                                                                                                                xtype:'label',
                                                                                                                html:'Nombre del Evento:'
                                                                                                            },
                                                                                                            {
                                                                                                            	x:10,
                                                                                                                y:30,
                                                                                                                xtype:'textfield',
                                                                                                                width:490,
                                                                                                                cls:'SIUGJ_Control',
                                                                                                                id:'txtNombreEvento'
                                                                                                                
                                                                                                            },
                                                                                                            {
                                                                                                            	x:10,
                                                                                                                y:80,
                                                                                                                xtype:'label',
                                                                                                                cls:'SIUGJ_Etiqueta14_Gris',
                                                                                                                html:'Descripci&oacute;n del Evento:'
                                                                                                            },
                                                                                                            {
                                                                                                            	x:10,
                                                                                                                y:100,
                                                                                                                xtype:'textarea',
                                                                                                                width:480,
                                                                                                                height:45,
                                                                                                                cls:'controlSIUGJ',
                                                                                                                id:'txtDescripcion'
                                                                                                                
                                                                                                            },
                                                                                                            crearGridParticipantesEvento()
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

	gEx('tabPanelAudiencia').setActiveTab(1);
  	gEx('tabPanelAudiencia').setActiveTab(0);

	var cmbTipoAudiencia=  crearComboExt('cmbTipoAudiencia',eval(bD(gE('arrTipoAudiencia').value)),0,0,480,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'spTipoAudiencia'});    
    cmbTipoAudiencia.on('select',function(cmb,registro)
    					{
    						lblDuracionAudiencia=parseInt(registro.data.valorComp);                    
                        }
    			)
	new Ext.form.DateField (
                                {
                                    xtype:'datefield',
                                    id:'dteFecha',
                                    ctCls:'campoFechaSIUGJ',
                                    width:470,
                                    renderTo:'spFechaAudiencia',
                                    minValue:'<?php echo $fechaActual?>',
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
                                    
                                }
                              )
                        

    cmbTipoAudiencia.setValue(gE('tipoAudiencia').value);
    
    
    var cmbEdificio=crearComboExt('cmbEdificio',arrEdificios,0,0,410,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'spSede'});
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
                                obtenerDatosWebV2('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',respAux22, 'POST','funcion=17&idUnidadGestion='+
                                                    gE('idUnidadGestion').value+'&idEdificio='+registro.data.id,false);                  
                        }
    			)
    
    
    
    cmbEdificio.setValue(gE('idEdificio').value);
    
    
    var cmbSalas=crearComboExt('cmbSalas',arrSalas,0,0,410,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'spSala'});
    cmbSalas.on('select',function(cmb,registro)
    					{
    						cargarDatosAgenda();                    
                        }
    			)
    

	var cmbHoraInicio=crearComboExt('tmeHoraInicio',arrHoras,0,0,170,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'spHoraInicio'});
    cmbHoraInicio.on('select',function(cmb,registro)
    						{
                            	calcularHoraFinal(registro.data.id);
                                ajustarEvento();
                            }
    		
            		)
   
   	var cmbHoraFin=crearComboExt('tmeHoraFin',arrHoras,0,0,170,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'spHoraFin'});
    cmbHoraFin.on('select',function()
    						{
                            	calcularTiempoEstimado()
                                ajustarEvento();
                            }
    		
            		)


    gEx('tabPanelAudiencia').setActiveTab(0);
    
    
    
    
    
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
        
        
    }
    
    
    if(gE('idJuez').value!='-1')
    {
    	
    	
    	
    }
    
    
    if(gE('sL').value=='1')
    {
        
        gEx('btnModificar').hide();
        gEx('btnConfirmar').hide();
    }
    
    
    if(arrSalas.length==1)
    {
		cmbSalas.setValue(arrSalas[0][0]);
        dispararEventoSelectCombo('cmbSalas');
    }
    
    
                   
}

function cargarDatosAgenda()
{

	

	if(gE('sL').value=='1')
    {	
    	var oParams=	{
                    
                    		iEvento:gE('idRegistroEvento').value,
                            carpetaAdministrativa:gE('carpetaAdministrativa').value
                    
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
                    carpetaAdministrativa:gE('carpetaAdministrativa').value,
                    fechaBase: gEx('dteFecha').getValue().format('Y-m-d')
                    
                }
    
    
	gEx('frameContenidoAgenda').load	(
    								{
                                    	url:'../modulosEspeciales_SGJ/calendarioEventos.php',
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
           
            
            
            if(calendario.existeTraslape(evento))
            {
                
                function resp22()
                {
                	
                    evento.start=Date.parseDate(moment(horaInicioAnterior).format("YYYY-MM-DD HH:mm:ss"),'Y-m-d H:i:s');
                    evento.end=Date.parseDate(moment(horaFinAnterior).format("YYYY-MM-DD HH:mm:ss"),'Y-m-d H:i:s');
                    evento.start=horaInicioAnterior;
                    evento.end=horaFinAnterior;
                    evento._start=horaInicioAnterior;
                    evento.end=horaFinAnterior;
                    var fechaEvento=evento.start.format('Y-m-d');
                    
                    gEx('dteFecha').setValue(fechaEvento);
                    gEx('tmeHoraInicio').setValue(evento.start.format('H:i'));
                    gEx('tmeHoraFin').setValue(evento.end.format('H:i'));
                    var registro=calendario.$('#calendar').fullCalendar('updateEvent', evento);
                   
                    
                       
                }
                msgBox('Ya existe un evento asignado en el horario que pretende programar',resp22);
                return;
            }
            evento.start=moment(horaInicio.format('Y-m-d H:i:s'));
            evento.end=moment(horaFin.format('Y-m-d H:i:s'));
            
            
                    
            
            calendario.$('#calendar').fullCalendar('updateEvent', evento);
       }
       else
       {

       		var evento=	{};
            evento.id='e_'+calendario.gE('idEvento').value;
            evento.title='';
            evento.allDay=false;
            evento.start=moment(horaInicio.format('Y-m-d H:i:s'));
            evento.end=moment(horaFin.format('Y-m-d H:i:s'));
            evento.editable=true;
            evento.color='#900';
            console.log(evento);
            
            var traslape=calendario.existeTraslape(evento);
            if(traslape)
            {
                function resp()
                {
                    
                    gEx('tmeHoraInicio').setValue('');
                    gEx('tmeHoraFin').setValue('');
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
    var arrParticipantes='';
    var x;
    var o;
    var fila;
    for(x=0;x<gEx('gridPersonas').getStore().getCount();x++)
    {
    	fila=gEx('gridPersonas').getStore().getAt(x);
        o='{"tipoPersona":"'+fila.data.tipoPersona+'","nombre":"'+cv(fila.data.nombre)+'","mail":"'+fila.data.mail+'","idPersona":"'+fila.data.idPersona+'"}';
    	if(arrParticipantes=='')
        	arrParticipantes=o;
        else
        	arrParticipantes+=','+o;
    }
    

    var cadObj='{"idEvento":"'+gE('idRegistroEvento').value+'","unidadGestion":"'+gE('idUnidadGestion').value+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+
    			'","edificio":"'+cmbEdificio.getValue()+'","sala":"'+cmbSalas.getValue()+'","tipoAudiencia":"'+cmbTipoAudiencia.getValue()+
                '","fecha":"'+dteFecha.getValue().format('Y-m-d')+'","horaInicio":"'+cmbHoraInicio.getValue()+'","horaFin":"'+
                cmbHoraFin.getValue()+'","jueces":['+arrJueces+'],"idFormulario":"'+gE('idFormulario').value+
                '","idRegistroSolicitud":"'+gE('idRegistro').value+'","arrJuezOriginal":"'+(gE('arrJuezOriginal').value)+
                '","nombreEvento":"'+cv(gEx('txtNombreEvento').getValue())+'","descripcionEvento":"'+cv(gEx('txtDescripcion').getValue())+
                '","participantes":['+arrParticipantes+']}';
                
	
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	gE('lblStatusAudiencia').innerHTML=formatearValorRenderer(arrSituacionAudiencia,'1');
            gEx('btnModificar').show();
            gEx('btnConfirmar').hide();
	        gE('idRegistroEvento').value=arrResp.length>2?arrResp[2]:arrResp[1];
            gE('idAudiencia').innerHTML=gE('idRegistroEvento').value;
        	function resp()
            {
                if(window.parent.recargarContenedorCentral)
                	window.parent.recargarContenedorCentral();
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
    obtenerDatosWeb('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax, 'POST','funcion=16&cadObj='+cadObj,true);
    
    
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



function crearGridParticipantesEvento()
{

	var dsDatos=eval(bD(gE('arrParticipantes').value));
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'tipoPersona'},
                                                                    {name: 'nombre'},
                                                                    {name: 'mail'},
                                                                    {name: 'idPersona'}
                                                                ]
                                                    }
                                                );
                                                
                                                

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	chkRow,
														{
															header:'Tipo de Persona',
															width:150,
															sortable:true,
															dataIndex:'tipoPersona',
                                                            renderer:function(val)
                                                            		{

                                                                    	return formatearValorRenderer(arrTiposPersonas,val);
                                                                    }
														},
														{
															header:'Nombre',
															width:230,
															sortable:true,
															dataIndex:'nombre'
														},
														{
															header:'E-Mail',
															width:300,
															sortable:true,
															dataIndex:'mail'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            x:10,
                                                            y:155,
                                                            id:'gridPersonas',
                                                            cls:'gridSiugjPrincipal',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            height:240,
                                                            width:490,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            width:150,
                                                                            text:'Agregar Participante',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarPersonaNotificar();
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            width:150,
                                                                            text:'Remover Participante',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila;
                                                                                        fila=gEx('gridPersonas').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la persona que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        gEx('gridPersonas').getStore().remove(fila);
                                                                                        
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}





function mostrarVentanaAgregarPersonaNotificar()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											
											items: 	[
                                            			{
                                                        	region:'center',
                                                            width:500,
                                                        	xtype:'panel',
                                                            defaultType: 'label',
                                                            layout:'absolute',
                                                            border:false,
                                                            items:	[
                                                            			{
                                                                            x:10,
                                                                            y:20,
                                                                            cls:'letraNotificaciones',
                                                                            html:'Tipo de Persona Jur&iacute;dica:'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:50,
                                                                            html:'<div id="spTipoPersona"></div>'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:110,
                                                                            cls:'letraNotificaciones',
                                                                            id:'lblNombre',
                                                                            html:'Nombre:'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:140,
                                                                            id:'lblSpIntituciones',
                                                                            html:'<div id="spInstituciones"></div>'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:140,
                                                                            id:'lblSpEmbargo',
                                                                            html:'<div id="spEmbargo"></div>'
                                                                        },
                                                                        
                                                                        {
                                                                            x:10,
                                                                            y:140,
                                                                            cls:'controlSIUGJ',
                                                                            xtype:'textfield',
                                                                            width:364,                                                            
                                                                            disabled:true,
                                                                            id:'txtNombre'
                                                                            
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:190,
                                                                            cls:'letraNotificaciones',
                                                                            id:'lblMail',
                                                                            html:'E-mail:'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:220,
                
                                                                            cls:'controlSIUGJ',
                                                                            disabled:true,
                                                                            xtype:'textfield',
                                                                            width:364,
                                                                            id:'txtMail'
                                                                            
                                                                        }
                                                            		]
                                                        },
                                                        {
                                                        	xtype:'panel',
                                                            region:'east',
                                                            width:450,
                                                            border:false,
                                                            cls:'gridPanelSIUGJCabecera',
                                                            title:'Participantes',
                                                            layout:'border',
                                                            items:	[
                                                            			crearArbolSujetosProcesalesRelacion(listPartes,idActividad,-1)
                                                                    ]
                                                        }
                                            			
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Destinatario',
										width: 950,
										height:450,
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
                                                                	var cmbTipoPersonaJuridica=crearComboExt('cmbTipoPersonaJuridica',arrTiposPersonas,0,0,364,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'spTipoPersona'});
    
																    cmbTipoPersonaJuridica.on('select',function(cmb,registro)
                                                                                                {
                                                                                                    gEx('lblNombre').hide();
                                                                                                    gEx('txtNombre').hide();
                                                                                                    gEx('lblMail').hide();
                                                                                                    gEx('txtMail').hide();
                                                                                                    gEx('lblSpIntituciones').hide();
                                                                                                    gEx('cmbInstituciones').setValue('');
                                                                                                    gEx('cmbEntidadesEmbargo').setValue('');
                                                                                                    gEx('lblSpEmbargo').hide('');
                                                                                                    switch(registro.data.id)
                                                                                                    {
                                                                                                        case '1':
                                                                                                            gEx('txtNombre').setValue('');
                                                                                                            gEx('txtMail').setValue('');
                                                                                                            gEx('arbolSujetosRelacion').enable();
                                                                                                            gEx('txtNombre').disable();
                                                                                                            gEx('txtMail').disable();
                                                                                                            
                                                                                                        break;
                                                                                                        case '2':
                                                                                                            
                                                                                                            gEx('lblNombre').show();
                                                                                                            gEx('txtNombre').show();
                                                                                                            gEx('lblMail').show();
                                                                                                            gEx('txtMail').show();
                                                                                                            gEx('lblNombre').setText('Nombre:');
                                                                                                            gEx('arbolSujetosRelacion').disable();
                                                                                                            gEx('txtNombre').enable();
                                                                                                            gEx('txtMail').enable();
                                                                                                            gEx('txtNombre').focus();
                                                                                                            
                                                                                                        break;
                                                                                                        case '3':
                                                                                                            gEx('arbolSujetosRelacion').disable();
                                                                                                            gEx('lblNombre').show();
                                                                                                            gEx('lblNombre').setText('Instituci\xF3n:',false);
                                                                                                            gEx('lblSpIntituciones').show();
                                                                                                        break;
                                                                                                        case '4':
                                                                                                            gEx('arbolSujetosRelacion').disable();
                                                                                                            gEx('lblNombre').show();
                                                                                                            gEx('lblNombre').setText('Entidad Embargo:',false);
                                                                                                            gEx('lblSpEmbargo').show();
                                                                                                        break;
                                                                                                    }
                                                                                                    
                                                                                                }
                                                                            )
                            
                            
                            										var cmbInstituciones=crearComboExt('cmbInstituciones',arrInstituciones,0,0,364,{multiSelect:true,ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'spInstituciones'});
                                                                    gEx('lblSpIntituciones').hide();
                                                                    var cmbEntidadesEmbargo=crearComboExt('cmbEntidadesEmbargo',arrEntidadesEmbargo,0,0,365,{multiSelect:true,ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'spEmbargo'});
                                                                    gEx('lblSpEmbargo').hide();
                            
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
                                                                    	var txtNombre=gEx('txtNombre');
                                                                        var txtMail=gEx('txtMail');
                                                                        
                                                                        var reg=crearRegistro	(
                                                                        							[
                                                                                                    	
                                                                                                        {name: 'tipoPersona'},
                                                                                                        {name: 'nombre'},
                                                                                                        {name: 'mail'},
                                                                                                        {name: 'idPersona'}
                                                                                                     ]
                                                                        
                                                                        						);
                                                                        
                                                                        
                                                                        
                                                                         
                                                                        
                                                                        switch(parseInt(gEx('cmbTipoPersonaJuridica').getValue()))
                                                                        {
                                                                        	case 1:
                                                                            	var nodos=gEx('arbolSujetosRelacion').getChecked();
                                                                                var x;
                                                                                var r
                                                                                var pos;
                                                                                for(x=0;x<nodos.length;x++)
                                                                                {
                                                                                    pos=obtenerPosFila(gEx('gridPersonas').getStore(),'idPersona',nodos[x].attributes.idPersona);
                                                                                    if(pos==-1)
                                                                                    {
                                                                                        r=new reg	(
                                                                                                        {
                                                                                                            
                                                                                                            tipoPersona:gEx('cmbTipoPersonaJuridica').getValue(),
                                                                                                            nombre:nodos[x].attributes.nombre,
                                                                                                            mail:nodos[x].attributes.mail,
                                                                                                            idPersona:nodos[x].attributes.idPersona
                                                                                                        }
                                                                                                    );
                                                                                    
                                                                                		
                                                                                        gEx('gridPersonas').getStore().add(r);
                                                                                    }
                                                                                }
                                                                            break;
                                                                            case 2:
                                                                            	if(txtNombre.getValue()=='')
                                                                                {
                                                                                    function resp1()
                                                                                    {
                                                                                        txtNombre.focus();
                                                                                    }
                                                                                    msgBox('Debe ingresar el nombre del destinatario',resp1);
                                                                                    return;
                                                                                }
                                                                                
                                                                                if(txtMail.getValue()=='')
                                                                                {
                                                                                    function resp2()
                                                                                    {
                                                                                        txtMail.focus();
                                                                                    }
                                                                                    msgBox('Debe ingresar la direcci&oacute;n de correo electr&oacute;nico a notificar',resp2);
                                                                                    return;
                                                                                }
                                                                                
                                                                                if(!validarCorreo(txtMail.getValue()))
                                                                                {
                                                                                    function resp3()
                                                                                    {
                                                                                        txtMail.focus();
                                                                                    }
                                                                                    msgBox('La direcci&oacute;n de correo electr&oacute;nico ingresada NO es v&aacute;lida',resp3);
                                                                                    return;
                                                                                }
                                                                                
                                                                                var r=new reg	(
                                                                                                    {
                                                                                                        
                                                                                                        tipoPersona:gEx('cmbTipoPersonaJuridica').getValue(),
                                                                                                        nombre:txtNombre.getValue(),
                                                                                                        mail:txtMail.getValue(),
                                                                                                        idPersona:-1
                                                                                                    }
                                                                                                );
                                                                                
                                                                            
                                                                                gEx('gridPersonas').getStore().add(r);
                                                                            break;
                                                                            case 3:
                                                                            	var arrInstitucionesSel=gEx('cmbInstituciones').getValue();

                                                                                if(arrInstitucionesSel=='')
                                                                                {
                                                                                	msgBox('Debe seleccionar almenos una instituci&oacute;n a notificar');
                                                                                	return;
                                                                                }
                                                                                
                                                                                
                                                                                var aInstituciones=arrInstitucionesSel.split(",");
                                                                                var x;
                                                                                var r
                                                                                var pos;

                                                                                for(x=0;x<aInstituciones.length;x++)
                                                                                {
                                                                                    pos=existeValorMatriz(arrInstituciones,aInstituciones[x]);
                                                                                    if(pos!=-1)
                                                                                    {
                                                                                        r=new reg	(
                                                                                                        {
                                                                                                            
                                                                                                            tipoPersona:gEx('cmbTipoPersonaJuridica').getValue(),
                                                                                                            nombre:arrInstituciones[pos][1],
                                                                                                            mail:arrInstituciones[pos][2],
                                                                                                            idPersona:-1
                                                                                                        }
                                                                                                    );
                                                                                    
                                                                                
                                                                                        gEx('gridPersonas').getStore().add(r);
                                                                                        
                                                                                       
                                                                                        
                                                                                    }
                                                                                }
                                                                            break;
                                                                            case 4:
                                                                            	var arrInstitucionesSel=gEx('cmbEntidadesEmbargo').getValue();

                                                                                if(arrInstitucionesSel=='')
                                                                                {
                                                                                	msgBox('Debe seleccionar almenos una instituci&oacute;n a notificar');
                                                                                	return;
                                                                                }
                                                                                
                                                                                
                                                                                var aInstituciones=arrInstitucionesSel.split(",");
                                                                                var x;
                                                                                var r
                                                                                var pos;

                                                                                for(x=0;x<aInstituciones.length;x++)
                                                                                {
                                                                                    pos=existeValorMatriz(arrEntidadesEmbargo,aInstituciones[x]);
                                                                                    if(pos!=-1)
                                                                                    {
                                                                                        r=new reg	(
                                                                                                        {
                                                                                                            
                                                                                                            tipoPersona:gEx('cmbTipoPersonaJuridica').getValue(),
                                                                                                            nombre:arrEntidadesEmbargo[pos][1],
                                                                                                            mail:arrEntidadesEmbargo[pos][2],
                                                                                                            idPersona:-1
                                                                                                        }
                                                                                                    );
                                                                                    
                                                                                
                                                                                        gEx('gridPersonas').getStore().add(r);
                                                                                    }
                                                                                }
                                                                            break;
                                                                        }
                                                                        
																		
                                                                        
                                                                        
                                                                        ventanaAM.close();
																	}
														}
														
													]
									}
								);
	ventanaAM.show();
}

function crearArbolSujetosProcesalesRelacion(listPartes,iA,iP)
{
	var iActividad=iA?iA:-1;
    var idPersona=iP?iP:-1;
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
                                                                    funcion:'19',
                                                                    iC:-1,
                                                                    cA:carpetaAdministrativa,
                                                                    iA:iActividad,
                                                                    check:1,
                                                                    iP:idPersona,
                                                                    moduloNotificaciones:1,
                                                                    sujetosProcesales:listPartes
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'
                                                }
                                            )		
										
	cargadorArbol.on('beforeload',function(c)
    						{
                            }
    				)	
    										
	cargadorArbol.on('load',function(c,nodoCarga)
    						{
                            	
                            }
    				)										
	var arbolSujetosJuridicos=new Ext.tree.TreePanel	(
                                                            {
                                                                id:'arbolSujetosRelacion',
                                                                useArrows:true,
                                                                animate:true,
                                                                enableDD:false,
                                                                ddScroll:true,
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                border:true,
                                                                disabled:true,
                                                                cls:'arbolNotificacion',
                                                                root:raiz,
                                                                region:'center',
                                                                loader: cargadorArbol,
                                                                rootVisible:false
                                                            }
                                                        )
         
         
                                                    
	return  arbolSujetosJuridicos;
}

