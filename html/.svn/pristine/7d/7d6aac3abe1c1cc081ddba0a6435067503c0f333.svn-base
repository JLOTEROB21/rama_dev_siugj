<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT valor,texto FROM 1004_siNo ORDER BY valor DESC";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	
	
	
	
	$arrLeyendas="[['Cita Programada','#00A156'],['Cita A Programar','#900']]";
?>
var arrLeyendas=[<?php echo $arrLeyendas?>];
var arrSiNo=<?php echo $arrSiNo?>;
var idPrograma=-1;
var regPrograma=null;
var calendario;
var horaInicial;
var minutosDesplazamiento=0;
Ext.onReady(inicializar);

function inicializar()
{
	minutosDesplazamiento=parseInt(gE('minutosDezplazamiento').value);
	calendario=$('#calendar').fullCalendar(
                                            {
                                                defaultView:'agendaDay',
                                                allDaySlot:false,
                                               	height: 350,
                                                scrollTime:window.parent.gEx('cmbHoraInicio').getValue()+':00',
                                                slotDuration: '00:'+gE('minutosDivision').value+':00',
                                                minTime:'00:00:00',
                                                maxTime:'24:00:00',                                        
                                                header: {
                                                            left: 'prev,next today',
                                                            right: 'agendaWeek,agendaDay'
                                                            
                                                        },
                                                
                                                defaultDate: gE('fechaInicio').value,
                                                businessHours: false, // display business hours
                                                weekday: 'long' ,
                                                editable: false,
                                                selectable: true,
                                                loading:function(isLoading,view)
                                                        {
                                                        	
                                                            if(!isLoading)
                                                            {
                                                            	if(view.name=='agendaDay')	
                                                                {
	                                                                window.parent.gEx('fechaInicio').setValue(view.intervalStart.format('YYYY-MM-DD'));
                                                                }
                                                                
                                                                var eventos=$('#calendar').fullCalendar( 'clientEvents' ,'e_'+gE('idRegistroIgnorar').value );
                                                                if(eventos.length==0)
                                                                {
                                                                    var dteFecha=window.parent.gEx('fechaInicio');
                                                                    var tmeHoraInicio=window.parent.gEx('cmbHoraInicio');
                                                                    var tmeHoraFin=window.parent.gEx('cmbHoraFin');
                                                                    
                                                                    var evento=	{};
                                                                    evento.id='e_'+gE('idRegistroIgnorar').value;
                                                                    evento.title=bD(gE('lblNombrePrograma').value);
                                                                    evento.allDay=false;
                                                                    evento.start=moment(dteFecha.getValue().format('Y-m-d')+' '+tmeHoraInicio.getValue()).add(parseInt(gE('minutosDezplazamiento').value)*-1, 'minutes');
                                                                    evento.end=moment(dteFecha.getValue().format('Y-m-d')+' '+tmeHoraFin.getValue()).add(parseInt(gE('minutosDezplazamiento').value)*-1, 'minutes');
                                                                    evento.editable=true;
                                                                    evento.eliminable=false;
                                                                    evento.color='#900';
                                                                    
                                                                    $('#calendar').fullCalendar('renderEvent', evento);
                                                                }
                                                                else
                                                                {
                                                                    var fechaInicio=Date.parseDate(window.parent.gEx('fechaInicio').getValue().format('Y-m-d')+' '+window.parent.gEx('cmbHoraInicio').getValue()+":00",'Y-m-d H:i:s');
                                                                
                                                                    var fIni=Date.parseDate(window.parent.gEx('fechaInicio').getValue().format('Y-m-d')+' '+window.parent.gEx('cmbHoraInicio').getValue()+":00",'Y-m-d H:i:s');
                                                                    var fFIn=Date.parseDate(window.parent.gEx('fechaInicio').getValue().format('Y-m-d')+' '+window.parent.gEx('cmbHoraFin').getValue()+":00",'Y-m-d H:i:s');
                                                                    var diferencia=(fFIn-fIni)/1000/60;
                                                                    var fechaFin=fechaInicio.add(Date.MINUTE,diferencia);
                                                                    
                                                                    evento=	eventos[0];
                                                            
                                                                    evento.start=moment(fechaInicio.format('Y-m-d H:i:s'));
                                                                    evento.end=moment(fechaFin.format('Y-m-d H:i:s'));
                                                                    $('#calendar').fullCalendar('updateEvent', evento);
                                                                }
                                                                
                                                                
                                                                
                                                                 
                                                            }
                                                        },
                                                select:	function(startDate, endDate)
                                                        {
                                                        	
                                                           
                                                            
        
        
                                                        },
                                                eventAfterAllRender:function()
                                                					{
                                                                    	
                                                                    	 	
                                                                         
    
                                                                    },        
                                                eventRender: function(event, element) 
                                                			{
																
                                                              	element.bind('dblclick', function(e) 
                                                              							{
                                                                                        	var arrID=event.id.split('_');
                                                                                            abrirRegistroSolicitud(bE(event.iFormulario),bE(event.iRegistro));
                                                                                            
							                                                              }
                                                                           );        
                                                            },
                                                        
                                                eventClick: function(event, jsEvent, view) 
                                                            {
                                                              	  
                                                               
                                                               
                                                            },
        
                                                eventDrop: function(event, delta, revertFunc) 
                                                            {
                                                            	var traslape=existeTraslape(event);
                                                                if(traslape)
                                                                {
                                                                    function resp()
                                                                    {
                                                                        
                                                                        revertFunc();
                                                                    }
                                                                    msgBox('Ya existe un evento asignado en el horario que pretende programar',resp);
                                                                    return;
                                                                }
                                                                window.parent.ajustarFechaEvento(event.start.clone().add(parseInt(gE('minutosDezplazamiento').value), 'minutes'),event.end.clone().add(parseInt(gE('minutosDezplazamiento').value), 'minutes'));
                                                        
                                                            },
                                                eventResize: function(event, delta, revertFunc) 
                                                            {
                                                            	var traslape=existeTraslape(event);
                                                                if(traslape)
                                                                {
                                                                    function resp()
                                                                    {
                                                                        
                                                                        revertFunc();
                                                                    }
                                                                    msgBox('Ya existe un evento asignado en el horario que pretende programar',resp);
                                                                    return;
                                                                }
                                                                window.parent.ajustarFechaEvento(event.start.clone().add(parseInt(gE('minutosDezplazamiento').value), 'minutes'),event.end.clone().add(parseInt(gE('minutosDezplazamiento').value), 'minutes'));
                                                        
                                                                
                                                                 
                                                            
                                                            },
                                                            
                                                dayClick: function(date, jsEvent, view) 
                                                            {
                                                            	var evento;
                                                                var fecha=Date.parseDate(date.format('YYYY-MM-DD HH:mm:ss'),'Y-m-d H:i:s');
                                                               
                                                                var eventos=$('#calendar').fullCalendar( 'clientEvents' ,'e_'+gE('idRegistroIgnorar').value );
                                                                if(eventos.length==0)
                                                                {
                                                                    evento=	{};
                                                                    evento.id='';
                                                                    evento.title='';
                                                                    evento.allDay=false;
                                                                    evento.start=fecha;
                                                                    evento.end=fecha;
                                                                    evento.editable=true;
                                                                    evento.color='#900';
                                                                    $('#calendar').fullCalendar('renderEvent', evento);
                                                                    window.parent.ajustarFechaEvento(fecha.add(parseInt(gE('minutosDezplazamiento').value), 'minutes'),event.end.clone().add(parseInt(gE('minutosDezplazamiento').value), 'minutes'));
                                                        
                                                                }
                                                                else
                                                                {
                                                                    var fechaInicio=Date.parseDate(date.format('YYYY-MM-DD HH:mm:ss'),'Y-m-d H:i:s');
                                                                    
                                                                    var fIni=Date.parseDate(window.parent.gEx('fechaInicio').getValue().format('Y-m-d')+' '+window.parent.gEx('cmbHoraInicio').getValue()+":00",'Y-m-d H:i:s');
                                                                    var fFIn=Date.parseDate(window.parent.gEx('fechaInicio').getValue().format('Y-m-d')+' '+window.parent.gEx('cmbHoraFin').getValue()+":00",'Y-m-d H:i:s');
                                                                    var diferencia=(fFIn-fIni)/1000/60;
                                                                   	var fechaFin=fechaInicio.add(Date.MINUTE,diferencia);
                                                                    
                                                                    evento=	eventos[0];
                                                            
                                                                    evento.start=moment(fechaInicio.format('Y-m-d H:i:s'));
                                                                    evento.end=moment(fechaFin.format('Y-m-d H:i:s'));
                                                                    
                                                                    
                                                       
                                                                    
                                                                    
                                                                    
                                                                }
                                                                
                                                                var traslape=existeTraslape(evento);
                                                                if(traslape)
                                                                {
                                                                    function resp()
                                                                    {
                                                                        
                                                                        revertFunc();
                                                                    }
                                                                    msgBox('Ya existe un evento asignado en el horario que pretende programar',resp);
                                                                    return;
                                                                }
                                                                $('#calendar').fullCalendar(eventos.length==0?'renderEvent':'updateEvent', evento);
                                                                
                                                                window.parent.gEx('fechaInicio').setValue(evento.start.format('YYYY-MM-DD'));
                                                                window.parent.gEx('cmbHoraInicio').setValue(evento.start.format('HH:mm'));
                                                                window.parent.gEx('cmbHoraFin').setValue(evento.end.format('HH:mm'));
                                                                
                                                                
                                                            },
                                                eventSources: 	[
                                                                    {
                                                                        url:'../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',
                                                                        type:'POST',
                                                                        data:	{
                                                                                    minDesplazamiento:minutosDesplazamiento,
                                                                                    tipoRecurso:gE('tipoRecurso').value,
                                                                                    idRecurso:gE('idRecurso').value,
                                                                                    idRegistroIgnorar:gE('idRegistroIgnorar').value,
                                                                                    funcion:12
                                                                                }
                                                                    }
                                                                ]
                                                        
                                             }
                                       );
                                       
	calendario= $('#calendar').fullCalendar('getCalendar');   
    
   
    

  	
    
}




function existeTraslape(evento)
{
	var arrEventos=$('#calendar').fullCalendar( 'clientEvents');
    
    var ev;
    var x;
    for(x=0;x<arrEventos.length;x++)
    {
    	ev=arrEventos[x];
        if((ev.id!=evento.id)&&(ev.rendering!='background'))
        {
        	
            if(colisionaTiempo(evento.start.format('YYYY-MM-DD HH:mm:ss'),evento.end.format('YYYY-MM-DD HH:mm:ss'),
    	         ev.start.format('YYYY-MM-DD HH:mm:ss'),ev.end.format('YYYY-MM-DD HH:mm:ss'),false,'Y-m-d H:i:s'))
	        {
               		
                return true;
            }
		}        
        
    }
    return false;
}


function existeTraslapeCambioHorario(evento)
{
	
	evento.start.add(parseInt(gE('minutosDezplazamiento').value)*-1, 'minutes');
    evento.end.add(parseInt(gE('minutosDezplazamiento').value)*-1, 'minutes');
                                                                
	return existeTraslape(evento);
}

function cambiarHorarioEvento(evento)
{
	var event=$('#calendar').fullCalendar('clientEvents',evento.id)[0];
    event.start=evento.start;
    event.end=evento.end;
    $('#calendar').fullCalendar('updateEvent', event); 
}


function imprimir()
{
	document.body.style.overflow='visible';
	html2canvas(document.body,{windowHeight:'1000px',backgroundColor: 'pink' }).then(canvas => {
    document.body.appendChild(canvas)
	});
	
}


function mostrarVentanaAgregarPrograma(fechaInicio,fechaFin)
{
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            activeTab:0,
                                                            baseCls: 'x-plain',
                                                            region:'center',
                                                            width:750,
                                                            height:440,
                                                            items:	[
                                                            			
                                                                        {
                                                                        	title:'Datos del programa',
                                                                            baseCls: 'x-plain',
                                                                            layout:'absolute',
                                                                        	xtype:'panel',
                                                                            items:	[
                                                                                        {
                                                                                            xtype:'label',
                                                                                            x:10,
                                                                                            y:10,
                                                                                            html:'<b>Cve. de Transmisi&oacute;n:</b>'
                                                                                        },
                                                                                        {
                                                                                            xtype:'label',
                                                                                            x:150,
                                                                                            y:10,
                                                                                            id:'lblCveTransmision',
                                                                                            html:''
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            xtype:'label',
                                                                                            x:10,
                                                                                            y:40,
                                                                                            html:'<b>Hora de inicio:</b>'
                                                                                        },
                                                                                        {
                                                                                            xtype:'label',
                                                                                            x:150,
                                                                                            y:40,
                                                                                            id:'lblFechaInicio',
                                                                                            html:''
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            xtype:'label',
                                                                                            x:370,
                                                                                            y:40,
                                                                                            html:'<b>Hora de t&eacute;rmino:</b>'
                                                                                        },
                                                                                        {
                                                                                            xtype:'label',
                                                                                            x:500,
                                                                                            y:40,
                                                                                            id:'lblFechaFin',
                                                                                            html:''
                                                                                        },
                                                                                        {
                                                                                            xtype:'label',
                                                                                            x:10,
                                                                                            y:70,
                                                                                            html:'<b>Programa:</b>'
                                                                                        },
                                                                                        {
                                                                                            xtype:'label',
                                                                                            x:150,
                                                                                            y:70,
                                                                                            id:'lblPrograma',
                                                                                            html:''
                                                                                        },
                                                                                        {
                                                                                            xtype:'label',
                                                                                            x:10,
                                                                                            y:100,
                                                                                            html:'<b>Tipo de emisi&oacute;n:</b>'
                                                                                        },
                                                                                        {
                                                                                            xtype:'label',
                                                                                            x:150,
                                                                                            y:100,
                                                                                            id:'lblTipoEmision',
                                                                                            html:''
                                                                                        },
                                                                                        {
                                                                                            xtype:'label',
                                                                                            x:300,
                                                                                            y:100,
                                                                                            id:'lblEventoConfirmar',
                                                                                            html:'Evento por confirmar'
                                                                                        }
                                                                                        ,
                                                                                        
                                                                                        {
                                                                                            xtype:'fieldset',
                                                                                            title:'Detalles del evento',
                                                                                            x:0,
                                                                                            y:130,
                                                                                            id:'fsDetalleEvento',
                                                                                            hidden:true,
                                                                                            layout:'absolute',
                                                                                            width:720,
                                                                                            height:100,
                                                                                            items:	[
                                                                                                        {
                                                                                                            xtype:'textarea',
                                                                                                            width:690,
                                                                                                            height:60,
                                                                                                            readOnly:true,
                                                                                                            x:0,
                                                                                                            y:0,
                                                                                                            id:'txtDetalle'
                                                                                                        }
                                                                                                    ]
                                                                                        },
                                                                                        {
                                                                                            xtype:'fieldset',
                                                                                            id:'fsComentariosAdicionales',
                                                                                            title:'Comentarios adicionales',
                                                                                            x:0,
                                                                                            layout:'absolute',
                                                                                            y:130,
                                                                                            width:720,
                                                                                            height:100,
                                                                                            items:	[
                                                                                                        {
                                                                                                            xtype:'textarea',
                                                                                                            width:690,
                                                                                                            height:60,
                                                                                                            x:0,
                                                                                                            y:0,
                                                                                                            readOnly:true,
                                                                                                            id:'txtComentarios'
                                                                                                        }
                                                                                                    ]
                                                                                        }
                                                                                    ]
                                                                       	},
                                                                        {
                                                                        	title:'Recursos para producci&oacute;n',
                                                                            baseCls: 'x-plain',
                                                                            layout:'absolute',
                                                                        	xtype:'panel',
                                                                            items:	[
                                                                                        crearArbolRecursos(fechaInicio.idOrdenServicio)
                                                                                    ]
                                                                       	}
                                                                    ]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Datos del programa',
										width: 750,
										height:460,
                                        id:'vPrograma',
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
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();
    ventanaAM.setHeight(320);
    
    if(!fechaFin)	
    {
    	var oEvento=fechaInicio;
        regPrograma={};
        regPrograma.data={};
        var fechaInicialEvento=oEvento.start.clone().add(minutosDesplazamiento,'minutes');
        var fechaFinalEvento=oEvento.end.clone().add(minutosDesplazamiento,'minutes');
        
    	gEx('lblCveTransmision').setText(oEvento.cveTransmision==''?'(Sin asignar)':oEvento.cveTransmision);
       
        gEx('lblFechaInicio').setText(fechaInicialEvento.format('DD/MM/YYYY HH:mm'));
        gEx('lblFechaFin').setText(fechaFinalEvento.format('DD/MM/YYYY HH:mm'));
        gEx('lblPrograma').setText(oEvento.lblPrograma+' ('+formatearValorRenderer(arrTipoTransmision,oEvento.tipoTransmision)+')');
         
        gEx('lblTipoEmision').setText(formatearValorRenderer(arrTipoEmision,oEvento.tipoEmision));
        
            
		prepararPanel(oEvento.tipoTransmision);//
        if(oEvento.porConfirmar=='1')
        	 gEx('lblEventoConfirmar').show();
        gEx('txtDetalle').setValue(escaparBR(oEvento.detalleEvento,true));
        gEx('txtComentarios').setValue(escaparBR(oEvento.comentariosAdicionales,true));
    }
}


function prepararPanel(tipoTransmision)
{
	switch(tipoTransmision)
    {
        case '1': //Evento
            gEx('lblEventoConfirmar').show();
            gEx('fsDetalleEvento').show();
            gEx('fsComentariosAdicionales').setPosition( 0, 240 ) ;
            gEx('vPrograma').setHeight(460);
            
        break;
        case '2': //Show
            gEx('lblEventoConfirmar').hide();
            gEx('fsDetalleEvento').hide();
            gEx('fsComentariosAdicionales').setPosition( 0, 130 ) ;
            gEx('vPrograma').setHeight(460);
        break;
    
    }
}


function crearArbolRecursos(iO)
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
                                                                        funcion:'29',
                                                                        idFormulario:602,
                                                                        idRegistro:iO,
                                                                        sL:gE('sL').value
                                                                    },
                                                        dataUrl:'../modulosEspeciales_FOX/paginasFunciones/funcionesModulosEspeciales_FOX.php'
                                                    }	


                                             )		                                        
    
     
     
    cargadorArbol.on('beforeload',function(c)
                        {
                           
                        }
                )	 
                                    
    var organigrama = new Ext.ux.tree.TreeGrid	(
                                                        {
                                                            id:'arbolRecursosContenidos',
                                                            region:'center',
                                                            useArrows:true,
                                                            autoScroll:true,
                                                            height:350,
                                                            animate:true,
                                                            enableDD:true,
                                                            containerScroll: true,
                                                            root:raiz,
                                                            enableSort:false,
                                                            loader: cargadorArbol,
                                                            rootVisible:false,                                                                
                                                            draggable:false,
                                                            columns:[
                                                                        
                                                                        {
                                                                            header:'Recurso',
                                                                            width:420,
                                                                            dataIndex:'text'
                                                                        },
                                                                        {
                                                                            header:'Asignado',
                                                                            width:280,
                                                                            dataIndex:'lblAsignacion'
                                                                        }
                                                                     ],
                                                             listeners: 	{
                                                                                'render': 	function(tp)
                                                                                            {
                                                                                                
                                                                                             }
                                                                                }

                                                           
                                                        }
                                                );
    
    
   

    
   
    organigrama.on('click',nodoClick);
    organigrama.expandAll();  
	return organigrama;             
}

function nodoClick(nodo)
{
	
	nodoSel=nodo;
    
    
    
	
}

function abrirRegistroSolicitud(iF,iR)
{
	if(window.parent.parent)
		window.parent.parent.abrirFormularioProcesoFancy(iF,iR,bE(0));
    else
    	abrirFormularioProcesoFancy(iF,iR,bE(0));
}

