<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT id__1_tablaDinamica,nombreInmueble FROM _1_tablaDinamica WHERE idEstado=2 ORDER BY nombreInmueble";
	$arrEdificios=$con->obtenerFilasArreglo($consulta);
		
	$consulta="SELECT id__17_tablaDinamica,nombreUnidad,claveUnidad FROM _17_tablaDinamica WHERE cmbCategoria=3 ORDER BY prioridad";
	$arrTribunales=$con->obtenerFilasArreglo($consulta);
		
	$consulta="SELECT id__4_tablaDinamica,tipoAudiencia,promedioDuracion FROM _4_tablaDinamica a,_4_tiposUGJ u 
				WHERE u.idPadre=a.id__4_tablaDinamica AND u.idOpcion='TA'";
	
	$arrTipoAudiencia=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT nombreElemento,nombreElemento FROM 1018_catalogoVarios WHERE  tipoElemento=28";
	$arrParticipantes=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT u.idUsuario,u.Nombre FROM 800_usuarios u,807_usuariosVSRoles r WHERE r.idUsuario=u.idUsuario
				AND r.idRol=153 ORDER BY u.Nombre";
	$arrJueces=$con->obtenerFilasArreglo($consulta);
?>
var arrJueces=<?php echo $arrJueces?>;
var idMagistrado=-1;
var lblDuracionAudiencia=60;
var arrTipoTribunal=[['1','Unitario'],['2','Colegiado']];
var arrEdificios=<?php echo $arrEdificios?>;
var arrTribunales=<?php echo $arrTribunales ?>;
var arrTipoAudiencia=<?php echo $arrTipoAudiencia?>;
var arrParticipantes=<?php echo $arrParticipantes?>;
var carpetaAdministrativa='';

Ext.onReady(inicializar);

function inicializar()
{
	Ext.QuickTips.init();
	if(window.parent)
		window.parent.autoScroll=150;
	var cmbTribunalAlzada=crearComboExt('cmbTribunalAlzada',arrTribunales,130,5,220);
    cmbTribunalAlzada.on('select',function(cmb,registro)
                                {
                                    dispararEventoSelectCombo('cmbEdificio');   
                                    if(gE('idEvento').value=='-1')
	                                    gEx('gMagistrados').getStore().reload(); 
                                    if(!gEx('cmbNoToca').disabled) 
                                    { 
	                                    gEx('cmbNoToca').setValue(''); 
                                    	carpetaAdministrativa=-1;                    
                                    }
                                }
                        )
                        
	var cmbSalas=crearComboExt('cmbSalas',[],130,355,220);
    cmbSalas.on('select',function(cmb,registro)
    					{
    						cargarDatosAgenda();                    
                        }
    			)
    
    
    var cmbEdificio=crearComboExt('cmbEdificio',arrEdificios,130,295,220);
    

   
     cmbEdificio.on('select',function(){buscarSalasDisponibles();cargarDatosAgenda();}	);
                
                
                
	var cmbTipoAudiencia=  crearComboExt('cmbTipoAudiencia',arrTipoAudiencia,130,265,220);    
    cmbTipoAudiencia.on('select',function(cmb,registro)
    					{
    						lblDuracionAudiencia=parseInt(registro.data.valorComp);                    
                        }
    			)
    
              
    var cmbTipoTribunal=    crearComboExt('cmbTipoTribunal',arrTipoTribunal,130,65,170);  
    cmbTipoTribunal.setValue('1');
    cmbTipoTribunal.on('select',function(cmb,registro)
    					{
    						var fila;
                            var gMagistrados=gEx('gMagistrados');            
                            var x;
                            
                            for(x=0;x<gMagistrados.getStore().getCount();x++)
                            {
                                fila=gMagistrados.getStore().getAt(x);
                        		fila.set('participante',false);
                            }
                        }
    			)
    
    var oConf=	{
    					idCombo:'cmbNoToca',
                        anchoCombo:220,
                        raiz:'registros',
                        posX:130,
                        posY:35,
                        
                        campoDesplegar:'carpetaAdministrativa',
                        campoID:'carpetaAdministrativa',
                        funcionBusqueda:47,
                        paginaProcesamiento:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                        confVista:'<tpl for="."><div class="search-item">{carpetaAdministrativa}<br></div></tpl>',
                        campos:	[
                                    {name:'carpetaAdministrativa'}

                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	carpetaAdministrativa=-1;
                                    	var aValor=combo.getRawValue();
										dSet.baseParams.criterio=aValor;
                                        dSet.baseParams.tC=8;
                                        var pos=existeValorMatriz(arrTribunales,gEx('cmbTribunalAlzada').getValue());
                                        dSet.baseParams.uG=arrTribunales[pos][2];
                                        
                                        
                                    },
                      	funcElementoSel:function(combo,registro)
                    				{
                                    	carpetaAdministrativa=registro.data.carpetaAdministrativa;
                                        
                                    }  
    				};

	var cmbNoToca=crearComboExtAutocompletar(oConf)
    
    
    
	var horaInicial=new Date(2010,5,10,9,0);
	var horaFinal=new Date(2010,5,10,22,0);
    
	var arrHoras=generarIntervaloHoras(horaInicial,horaFinal,1,'H:i','H:i');
    
	var cmbHoraInicio=crearComboExt('tmeHoraInicio',arrHoras,130,385,90);
    cmbHoraInicio.on('select',function(cmb,registro)
    						{
                            	calcularHoraFinal(registro.data.id);
                            }
    		
            		)
   
   	var cmbHoraFin=crearComboExt('tmeHoraFin',arrHoras,245,385,90);
    cmbHoraFin.on('select',function()
    						{
                            	calcularTiempoEstimado()
                            }
    		
            		)
    
    var gridMagistrados=crearGridMagistrados();           
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                items:	[
                                                			
                                                            {
                                                            	width:400,
                                                                baseCls: 'x-plain',
                                                            	xtype:'panel',
                                                                layout:'absolute',
                                                                region:'east',
                                                                items:	[
                                                                			{
                                                                            	xtype:'fieldset',
                                                                                x:10,
                                                                                y:0,
                                                                                title:'Datos de la audiencia',
                                                                                layout:'absolute',
                                                                                width:385,
                                                                                height:475,
                                                                                items:	[	
                                                                
                                                                                            {
                                                                                                x:0,
                                                                                                y:10,
                                                                                                xtype:'label',
                                                                                                html:'<span style="font-size:11px">Tribunal de Alzada:</span>'
                                                                                            },
                                                                                            cmbTribunalAlzada,
                                                                                            {
                                                                                                x:0,
                                                                                                y:40,
                                                                                                xtype:'label',
                                                                                                html:'<span style="font-size:11px">Carpeta Judicial:</span>'
                                                                                            },
                                                                                            cmbNoToca,
                                                                                            {
                                                                                                x:0,
                                                                                                y:70,
                                                                                                xtype:'label',
                                                                                                html:'<span style="font-size:11px">Tipo de tribunal:</span>'
                                                                                            },
                                                                                            cmbTipoTribunal,
                                                                                            {
                                                                                            	x:315,
                                                                                                y:63,
                                                                                                width:40,
                                                                                                xtype:'button',
                                                                                                icon:'../images/user_add.png',
                                                                            					cls:'x-btn-text-icon',
                                                                                                tooltip:'Agregar juez por ministerio de ley',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            mostrarVentanaAgregarMagistrado();
                                                                                                        }
                                                                                            },
                                                                                            
                                                                                            gridMagistrados,
                                                                                            {
                                                                                                x:0,
                                                                                                y:300,
                                                                                                xtype:'label',
                                                                                                html:'<span style="font-size:11px">Edificio:</span>'
                                                                                            },
                                                                                            cmbEdificio,
                                                                                            {
                                                                                                x:0,
                                                                                                y:360,
                                                                                                xtype:'label',
                                                                                                html:'<span style="font-size:11px">Sala:</span>'
                                                                                            },
                                                                                            {
                                                                                                x:0,
                                                                                                y:270,
                                                                                                xtype:'label',
                                                                                                html:'<span style="font-size:11px">Tipo de audiencia:</span>'
                                                                                            },
                                                                                            cmbTipoAudiencia,
                                                                                            cmbSalas,
                                                                                            {
                                                                                                x:0,
                                                                                                y:330,
                                                                                                xtype:'label',
                                                                                                html:'<span style="font-size:11px">Fecha:</span>'
                                                                                            },
                                                                                            {
                                                                                            	x:130,
                                                                                                y:325,
                                                                                                xtype:'datefield',
                                                                                                id:'dteFecha',
                                                                                                value:'<?php echo date('Y-m-d')?>',
                                                                                                listeners:	{
                                                                                                				select:function()
                                                                                                                		{	
                                                                                                                        	buscarSalasDisponibles();
                                                                                                                              cargarDatosAgenda();
                                                                                                                            
                                                                                                                        }
                                                                                                			}
                                                                                                
                                                                                            },
                                                                                            {
                                                                                                x:0,
                                                                                                y:390,
                                                                                                xtype:'label',
                                                                                                html:'<span style="font-size:11px">Hora:</span>'
                                                                                            },
                                                                                            cmbHoraInicio,
                                                                                            {
                                                                                                x:230,
                                                                                                y:390,
                                                                                                xtype:'label',
                                                                                                html:'<span style="font-size:11px">-</span>'
                                                                                            },
                                                                                            cmbHoraFin,
                                                                                            {
                                                                                            	x:245,
                                                                                                y:410,
                                                                                                width:100,
                                                                                                xtype:'button',
                                                                                                icon:'../images/guardar.PNG',
                                                                                                cls:'x-btn-text-icon',
                                                                                                text:'Guardar',
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
    
           
    if(gE('idCarpeta').value!='-1')                        
    {
        
        carpetaAdministrativa=gE('cAdministrativa').value;
        gEx('cmbNoToca').setRawValue(carpetaAdministrativa);
        gEx('cmbNoToca').disable();
        
        
        gEx('cmbTribunalAlzada').setValue(gE('uGestion').value);
        gEx('cmbTribunalAlzada').disable();
        dispararEventoSelectCombo('cmbTribunalAlzada');
        
    }
    var cmbTipoTribunal=gEx('cmbTipoTribunal');
    var cmbEdificio=gEx('cmbEdificio');
    if(gE('idEvento').value!='-1')
    {
        var oEventoAudiencia=eval('['+bD(gE('oEventoAudiencia').value)+']')[0];
        
        carpetaAdministrativa=oEventoAudiencia.carpetaAdministrativa;
        
        gEx('cmbNoToca').setRawValue(carpetaAdministrativa);
        gEx('cmbNoToca').disable();
        gEx('cmbTribunalAlzada').setValue(oEventoAudiencia.idCentroGestion);
        gEx('cmbTribunalAlzada').disable();
        
        
        
        
        cmbTipoTribunal.setValue(oEventoAudiencia.tipoTribunal);
       
       var reg=crearRegistro(		[
                                        {name:'idUsuario'},
                                        {name: 'magistrado'},
                                        {name:'participacion'},
                                        {name: 'ministerioLey'},
                                        {name: 'idMagistradoOriginal'},
                                        {name: 'participante'}
                                    ]);
        var x;
        for(x=0;x<oEventoAudiencia.arrJuez.length;x++)
        {
            gEx('gMagistrados').getStore().add(new reg(oEventoAudiencia.arrJuez[x]))
        }
        
            
        
        
        cmbEdificio.setValue(oEventoAudiencia.idEdificio);
        var cmbTipoAudiencia=gEx('cmbTipoAudiencia');
        cmbTipoAudiencia.setValue(oEventoAudiencia.tipoAudiencia);
        
        var dteFecha=gEx('dteFecha');
        dteFecha.setValue(oEventoAudiencia.fechaEvento);
        var cmbHoraInicio=gEx('tmeHoraInicio');
        cmbHoraInicio.setValue(oEventoAudiencia.horaInicioEvento);
        var cmbHoraFin=gEx('tmeHoraFin');
        cmbHoraFin.setValue(oEventoAudiencia.horaFinEvento);
        
      	
        
    }
    else
    	cmbEdificio.setValue(gE('idEdificio').value);
    buscarSalasDisponibles(function(arrSalas)
    						{
                            	if(gE('idSala').value!='-1')
								{                                
                                    if(existeValorMatriz(arrSalas,gE('idSala').value)!=-1)
                                    {
                                        gEx('cmbSalas').setValue(gE('idSala').value);
                                    }
                            	}
                            }
    						); 
    			                   
}

function cargarDatosAgenda()
{
	if((gEx('cmbSalas').getValue()=='')||(gEx('dteFecha').getValue()==''))
    {
    	return;
    }
	var fila;
    var gMagistrados=gEx('gMagistrados');            
    var x;
    var listaJueces='';
   
    for(x=0;x<gMagistrados.getStore().getCount();x++)
    {
    	fila=gMagistrados.getStore().getAt(x);
        
        if(fila.data.participante===true)
        {
        	
        	if(listaJueces=='')
            	listaJueces=fila.data.idUsuario;
            else
            	listaJueces+=','+fila.data.idUsuario;
            	
        }
    }
    
    if(listaJueces=='')
    	listaJueces=-1;
    
    var oParams={
                    idSala:gEx('cmbSalas').getValue(),
                    cPagina:'sFrm=true',
                    idJueces:listaJueces ,
                    idUnidadGestion:gEx('cmbTribunalAlzada').getValue(),
                    iEvento:gE('idEvento').value,
                    fechaBase: gEx('dteFecha').getValue().format('Y-m-d')
                    
                }
    
    
	gEx('frameContenidoAgenda').load	(
    								{
                                    	url:'../modulosEspeciales_SGJP/calendarioEventosAlzada.php',
                                        params:	oParams
                                    }
    							)
}

function crearGridMagistrados()
{

	var cmbParticipacion=crearComboExt('cmbParticipacion',arrParticipantes);       
       var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idUsuario'},
		                                                {name: 'magistrado'},
		                                                {name:'participacion'},
                                                        {name: 'ministerioLey'},
                                                        {name: 'idMagistradoOriginal'},
                                                        {name: 'participante'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_Alzada.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'magistrado', direction: 'ASC'},
                                                            groupField: 'magistrado',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='6';
                                        proxy.baseParams.iU=gEx('cmbTribunalAlzada').getValue();
                                    }
                        )   

	var checkColumn = new Ext.grid.CheckColumn	(
	 												{
													   header: '',
													   dataIndex: 'participante',
													   width: 30
													}
												);

       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            {
                                                                header:'Magistrado',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'magistrado',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var leyenda=mostrarValorDescripcion(val);
                                                                            if(registro.data.ministerioLey=='1')	
                                                                            	leyenda='<img src="../images/user_gray.png" width="14" height="14" title="Por Ministerio de Ley" alt="Por Ministerio de Ley"> '+leyenda;
                                                                       		return leyenda;
                                                                        }
                                                            },
                                                            checkColumn,
                                                            {
                                                                header:'Participaci&oacute;n',
                                                                width:100,
                                                                sortable:true,
                                                                editor:cmbParticipacion,
                                                                dataIndex:'participacion'
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gMagistrados',
                                                                store:alDatos,
                                                                frame:false,
                                                                width:360,
                                                                height:165,
                                                                cm: cModelo,
                                                                x:0,
                                                                y:90,
                                                                clicksToEdit:1,
                                                                plugins:[checkColumn],
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
    
    
    tblGrid.on('beforeedit',function(e)
    						{
                            	if(e.field=='participante')
                                {
                                	if(gEx('cmbTipoTribunal').getValue()=='1')	
                                    {
                                    	var x;
                                        for(x=0;x<e.grid.getStore().getCount();x++)
                                        {
                                        	e.grid.getStore().getAt(x).set('participante',false);
                                        }
                                    }
                                    
                                    e.record.set('participante',true);
                                    
                                    
                                    
                                }
                            }
    			)
    
    
    tblGrid.on('afteredit',function(e)
    						{
                            	if(e.field=='participante')
                                {
                                    cargarDatosAgenda();
                                    
                                }
                            }
    			)
    return 	tblGrid;	
	

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
	var cmbTribunalAlzada=gEx('cmbTribunalAlzada');
    var cmbTipoTribunal=gEx('cmbTipoTribunal');
    var cmbSalas=gEx('cmbSalas');
    var cmbEdificio=gEx('cmbEdificio');
    var cmbTipoAudiencia=gEx('cmbTipoAudiencia');
    var dteFecha=gEx('dteFecha');
    var cmbHoraInicio=gEx('tmeHoraInicio');
    var cmbHoraFin=gEx('tmeHoraFin');
    
    if(cmbTribunalAlzada.getValue()=='')
    {
    	function resp()
        {
        	cmbTribunalAlzada.focus();
        }
        msgBox('Debe seleccionar el tribunal de alzada al cual pertenece la audiencia',resp);
    	return;
    }
    
    if(carpetaAdministrativa=='')
    {
    	function resp5()
        {
        	gEx('cmbNoToca').focus();
        }
        msgBox('Debe seleccionar la Carpeta Judicial de Alzada a la cual pertenece la audiencia',resp5);
    	return;
    }
    
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
    var arrJueces='';
    var fila;
    var gMagistrados=gEx('gMagistrados');            
    var x;
    var nJueces=0;
    for(x=0;x<gMagistrados.getStore().getCount();x++)
    {
    	fila=gMagistrados.getStore().getAt(x);

        if(fila.data.participante)
        {
        	if(fila.data.participacion=='')
            {
            	function resp100()
                {
                	gMagistrados.startEditing(x,2);
                }
            	msgBox('Debe indicar la participaci&oacute;n del magistrado seleccionado',resp100);
            	return;
            }
        	oJuez='{"idUsuario":"'+fila.data.idUsuario+'","participacion":"'+cv(fila.data.participacion)+'","ministerioLey":"'+fila.data.ministerioLey+'"}';
            if(arrJueces=='')
            	arrJueces=oJuez;
            else
            	arrJueces+=','+oJuez;
                
            nJueces++;
        }
    }
    
    if((nJueces==0)&&(cmbTipoTribunal.getValue()=='1'))
    {
    	msgBox('Debe indicar almenos un magistrado que presidir&aacute; la audiencia ');
    	return;
    }
    else
    {
    	if(cmbTipoTribunal.getValue()=='2')
        {
        	if(nJueces<2)
            {
            	msgBox('Debe indicar almenos dos magistrados para tribunal colegiado');
    			return;
            }
        }
    }
    
    

    var cadObj='{"idEvento":"'+gE('idEvento').value+'","tribunal":"'+cmbTribunalAlzada.getValue()+'","toca":"'+carpetaAdministrativa+
    			'","tipoTribunal":"'+cmbTipoTribunal.getValue()+
    			'","edificio":"'+cmbEdificio.getValue()+'","sala":"'+cmbSalas.getValue()+'","tipoAudiencia":"'+cmbTipoAudiencia.getValue()+
                '","fecha":"'+dteFecha.getValue().format('Y-m-d')+'","horaInicio":"'+cmbHoraInicio.getValue()+'","horaFin":"'+
                cmbHoraFin.getValue()+'","jueces":['+arrJueces+']}';
                
	
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	function resp()
            {
                limpiarDatosEvento();
                if(window.parent.accionRegistroAudiencia)
                    window.parent.accionRegistroAudiencia();
            }
            msgBox('La audiencia ha sido agendada con &eacute;xito',resp);
            return;
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Alzada.php',funcAjax, 'POST','funcion=7&cadObj='+cadObj,true);
    
    
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

function mostrarVentanaAgregarMagistrado()
{
	var cmbTribunalAlzada=gEx('cmbTribunalAlzada');
    if(cmbTribunalAlzada.getValue()=='')
    {
    	function respAux()
        {
        	cmbTribunalAlzada.focus();
        }
        msgBox('Debe seleccionar el tribunal de alzada a la cual pertenece la audiencia a programar',respAux);
    	return;
    }

	var cmbJuez=crearComboExt('cmbJuez',arrJueces,80,5,350);
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10, 
                                                            y:10,
                                                            html:'Juez:'
                                                        },
                                                        cmbJuez,
                                                        {
                                                        	x:440,
                                                            y:8,
                                                            html:'<a href="javascript:registrarJuez()"><img src="../images/add.png" title="Registrar juez por ministerio de ley" alt="Registrar juez por ministerio de ley" /></a>'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar juez por ministerio de ley',
										width: 550,
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
                                                                	gEx('cmbJuez').focus(500,false);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		if(cmbJuez.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar el juez por ministerio de ley que desea agregar');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var reg=crearRegistro(		[
                                                                                                        {name:'idUsuario'},
                                                                                                        {name: 'magistrado'},
                                                                                                        {name:'participacion'},
                                                                                                        {name: 'ministerioLey'},
                                                                                                        {name: 'idMagistradoOriginal'},
                                                                                                        {name: 'participante'}
                                                                                                    ]);
                                                                       	var oMagistrado=	{
                                                                        						idUsuario:cmbJuez.getValue(),
                                                                                                magistrado:gEx('cmbJuez').getRawValue(),
                                                                                                participacion:'',
                                                                                                ministerioLey:'1',
                                                                                                idMagistradoOriginal:'',
                                                                                                participante:true
                                                                                                
                                                                        					}
                                                                        gEx('gMagistrados').getStore().add(new reg(oMagistrado));
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


function registrarJuez()
{
	
    
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			
                                                        {
                                                        	xtype:'textfield',
                                                            width:150,
                                                            x:10,
                                                            y:10,
                                                            id:'txtNombre'
                                                        },
                                                        
                                                        
                                                        {
                                                        	x:65,
                                                            y:35,
                                                            id:'lblNombre',
                                                            html:'<span >Nombre</span>'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            width:120,
                                                            x:170,
                                                            y:10,
                                                            id:'txtApPaterno'
                                                        },
                                                        {
                                                        	x:205,
                                                            y:35,
                                                            id:'lblApPaterno',
                                                            html:'<span >Ap. Paterno</span>'
                                                        }
                                                        ,
                                                        {
                                                        	xtype:'textfield',
                                                            width:120,
                                                            x:300,
                                                            y:10,
                                                            id:'txtApMaterno'
                                                        },
                                                         {
                                                        	x:335,
                                                            y:35,
                                                            id:'lblApMaterno',
                                                            html:'<span >Ap. Materno</span>'
                                                        }
                                                        
                                                        
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Registrar juez por ministerio de ley',
										width: 470,
										height:140,
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
                                                                	gEx('txtNombre').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
                                                                    	var txtApPaterno=gEx('txtApPaterno');
                                                                        var txtApMaterno=gEx('txtApMaterno');
                                                                        var txtNombre=gEx('txtNombre');
                                                                        var nombreAgregar='';
                                                                        
                                                                        var cadObj='';
                                                                        
                                                                        nombreAgregar=txtNombre.getValue()+' '+txtApPaterno.getValue()+' '+txtApMaterno.getValue();
                                                                        cadObj='{"tribunalAlzada":"'+gEx('cmbTribunalAlzada').getValue()+'","nombre":"'+cv(txtNombre.getValue())+
                                                                                '","apPaterno":"'+cv(txtApPaterno.getValue())+'","apMaterno":"'+cv(txtApMaterno.getValue())+'"}';
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                var reg=crearRegistro	(
                                                                                							[
                                                                                                                  {name:'id'},
                                                                                                                  {name:'nombre'},
                                                                                                                  {name:'valorComp'},
                                                                                                                  {name:'valorComp2'},
                                                                                                                  {name:'valorComp3'},
                                                                                                                  {name:'valorComp4'}
                                                                                                                  
                                                                                                              ]
                                                                                						)
                                                                            
                                                                            	var r=new reg (
                                                                                					{
                                                                                                    	id:arrResp[1],
                                                                                                        nombre:nombreAgregar
                                                                                                    }
                                                                                				)
                                                                            	gEx('cmbJuez').getStore().add(r);
                                                                                gEx('cmbJuez').setValue(arrResp[1]);
                                                                                arrJueces.push([arrResp[1],nombreAgregar]);
                                                                            	ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Alzada.php',funcAjax, 'POST','funcion=10&cadObj='+cadObj,true);
                                                                        
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
    dispararEventoSelectCombo('cmbTipoPersona');
    
}


function buscarSalasDisponibles(afterLoad)
{
	
    function respAux22(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrDatos=eval(arrResp[1]);
           
           	var arrSalasDisponibles=[];
            var x;
            for(x=0;x<arrDatos.length;x++)
            {
            	if((arrDatos[x][0]!='152')&&(arrDatos[x][0]!='154')&&(arrDatos[x][0]!='75'))
                {
                	arrSalasDisponibles.push(arrDatos[x]);
                }
           	}
            gEx('cmbSalas').setValue('');
            gEx('cmbSalas').getStore().loadData(arrSalasDisponibles);
           
            if(afterLoad)
            {
            	afterLoad(arrSalasDisponibles);
            }
            
           
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