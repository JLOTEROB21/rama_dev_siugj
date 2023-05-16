<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT id__1_tablaDinamica,nombreInmueble FROM _1_tablaDinamica WHERE idEstado=2 ORDER BY nombreInmueble";
	$arrEdificios=$con->obtenerFilasArreglo($consulta);
		
	$consulta="SELECT id__17_tablaDinamica,nombreUnidad,claveUnidad FROM _17_tablaDinamica WHERE cmbCategoria=3 ORDER BY prioridad";
	$arrTribunales=$con->obtenerFilasArreglo($consulta);
		
	
	
	$consulta="SELECT nombreElemento,nombreElemento FROM 1018_catalogoVarios WHERE  tipoElemento=28";
	$arrParticipantes=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT u.idUsuario,u.Nombre FROM 800_usuarios u,807_usuariosVSRoles r WHERE r.idUsuario=u.idUsuario
				AND r.idRol=153 ORDER BY u.Nombre";
	$arrJueces=$con->obtenerFilasArreglo($consulta);
	
	$secretariaDefault='';
	$responsableAgenda="false";
	if(existeRol("'69_0'")||existeRol("'56_0'"))
	{
		$responsableAgenda="true";
		
	}
	else
	{
		$consulta="SELECT claveOPC FROM _17_tablaDinamica WHERE claveUnidad='".$_SESSION["codigoInstitucion"]."'";
		$claveOPC=$con->obtenerValor($consulta);
		
		$secretaria="";
		if(existeRol("'153_0'"))
		{
			$secretaria="A";
		}
		else
		{
			if(existeRol("'155_0'"))
			{
				$secretaria="B";
			}
			else
			{
				if(existeRol("'156_0'"))
				{
					$secretaria="C";
				}
				else
				{
					if(existeRol("'159_0'"))
					{
						$secretaria="CO";
					}
				}
			}
		}
		
		$claveOPC.="_".$secretaria;
		
		$consulta="SELECT id__15_tablaDinamica FROM _15_tablaDinamica WHERE claveSala='".$claveOPC."'";
		$secretariaDefault=$con->obtenerValor($consulta);
	}
	
	
?>
var secretariaDefault='<?php echo $secretariaDefault?>';
var arrJueces=<?php echo $arrJueces?>;
var idMagistrado=-1;
var lblDuracionAudiencia=60;
var arrTipoTribunal=[['1','Unitario'],['2','Colegiado']];
var arrEdificios=<?php echo $arrEdificios?>;
var arrTribunales=<?php echo $arrTribunales ?>;
var arrTipoAudiencia=[];
var arrParticipantes=<?php echo $arrParticipantes?>;
var carpetaAdministrativa='';
var responsableAgenda=<?php echo $responsableAgenda?>;

Ext.onReady(inicializar);

function inicializar()
{
	arrTipoAudiencia=eval(bD(gE('arrTipoAudiencia').value));
	Ext.QuickTips.init();
	if(window.parent)
		window.parent.autoScroll=150;

	var cmbSecretarias=crearComboExt('cmbSecretarias',eval(bD(gE('arrSalas').value)),130,185,220);
    cmbSecretarias.setValue(secretariaDefault);
    cmbSecretarias.on('select',function(cmb,registro)
    					{
    						cargarDatosAgenda();                    
                        }
    			)	 
	
	if(!responsableAgenda)
    {
    	cmbSecretarias.disable();
    }      
    
    if(gE('idEvento').value!='-1')                     
    {
    	cmbSecretarias.setValue(gE('idSala').value);
    }
                
	var cmbTipoAudiencia=  crearComboExt('cmbTipoAudiencia',arrTipoAudiencia,0,70,350);    
    cmbTipoAudiencia.on('select',function(cmb,registro)
    					{
    						lblDuracionAudiencia=parseInt(registro.data.valorComp);  
                            
                            
                            if(registro.data.id=='2008')
                            {
                            	gEx('lblEspecifique').show();
                            	gEx('txtEspecifique').show();
                                gEx('txtEspecifique').focus(false,100);
                                
                            }
                            else
                            {
                            	gEx('lblEspecifique').hide();
                            	gEx('txtEspecifique').hide();
                                gEx('txtEspecifique').setValue('');
                            }
                                              
                        }
    			)
    
              
    
    
    
	var horaInicial=new Date(2010,5,10,9,0);
	var horaFinal=new Date(2010,5,10,22,0);
    
	var arrHoras=generarIntervaloHoras(horaInicial,horaFinal,1,'H:i','H:i');
    
	var cmbHoraInicio=crearComboExt('tmeHoraInicio',arrHoras,130,155,90);
    cmbHoraInicio.on('select',function(cmb,registro)
    						{
                            	calcularHoraFinal(registro.data.id);
                            }
    		
            		)
   
   	var cmbHoraFin=crearComboExt('tmeHoraFin',arrHoras,245,155,90);
    cmbHoraFin.hide();
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
															<?php 
                                                            $nReg=1;
                                                            foreach($arrEtSecretarias as $color=>$leyenda)
                                                            {
                                                                if($nReg>1)
                                                                    echo ",";
                                                            ?>
                                                            {
                                                                xtype:'label',
                                                                html:'<table><tr><td><div style="width:15px; height:15px; background-color:#<?php echo $color?>; border-style:solid; border-width:1px; border-color:#000"></div></td><td> <?php echo utf8_encode($leyenda)?></td></tr></table>'
                                                            },'-'
                                                            <?php
                                                            
                                                                $nReg++;
                                                            }
                                                            ?>
                                                        ],
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
                                                                                                html:'<span style="font-size:11px">Expediente:</span>'
                                                                                            },
                                                                                            {
                                                                                                x:130,
                                                                                                y:10,
                                                                                                xtype:'label',
                                                                                                html:'<span style="font-size:11px; color:#900; font-weight:bold">'+gE('cAdministrativa').value+'</span>'
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
                                                                                                id:'lblEspecifique',
                                                                                                hidden:true,
                                                                                                xtype:'label',
                                                                                                html:'<span style="font-size:11px">Especifique:</span>'
                                                                                            },
                                                                                            {
                                                                                            	x:130,
                                                                                                y:95,
                                                                                                id:'txtEspecifique',
                                                                                                hidden:true,
                                                                                                xtype:'textfield',
                                                                                                width:220
                                                                                                
                                                                                            },
                                                                                            {
                                                                                                x:0,
                                                                                                y:130,
                                                                                                xtype:'label',
                                                                                                html:'<span style="font-size:11px">Fecha:</span>'
                                                                                            },
                                                                                            {
                                                                                            	x:130,
                                                                                                y:125,
                                                                                                xtype:'datefield',
                                                                                                id:'dteFecha',
                                                                                                value:'<?php echo date('Y-m-d')?>',
                                                                                                listeners:	{
                                                                                                				select:cargarDatosAgenda
                                                                                                			}
                                                                                                
                                                                                            },
                                                                                            {
                                                                                                x:0,
                                                                                                y:160,
                                                                                                xtype:'label',
                                                                                                html:'<span style="font-size:11px">Hora:</span>'
                                                                                            },
                                                                                            cmbHoraInicio,
                                                                                            {
                                                                                                x:230,
                                                                                                y:160,
                                                                                                hidden:true,
                                                                                                xtype:'label',
                                                                                                html:'<span style="font-size:11px">-</span>'
                                                                                            },
                                                                                            cmbHoraFin,
                                                                                            {
                                                                                                x:0,
                                                                                                y:190,
                                                                                                xtype:'label',
                                                                                                html:'<span style="font-size:11px">Secretar&iacute;a:</span>'
                                                                                            },
                                                                                            
                                                                                            cmbSecretarias,
                                                                                            {
                                                                                            	xtype:'checkbox',
                                                                                                x:0,
                                                                                                y:250,
                                                                                                listeners:	{
                                                                                                				check:cargarDatosAgenda
                                                                                                			},
                                                                                                id:'chkMostrarAgendaJuzgado',
                                                                                                boxLabel:'Mostrar agenda global del Juzgado'
                                                                                            },
                                                                                            {
                                                                                            	x:245,
                                                                                                y:210,
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
        
        
    }

    if(gE('idEvento').value!='-1')
    {

        var oEventoAudiencia=eval('['+bD(gE('oEventoAudiencia').value)+']')[0];
        carpetaAdministrativa=oEventoAudiencia.carpetaAdministrativa;
        
       
        var cmbTipoAudiencia=gEx('cmbTipoAudiencia');
        cmbTipoAudiencia.setValue(oEventoAudiencia.tipoAudiencia);
        
        var dteFecha=gEx('dteFecha');
        dteFecha.setValue(oEventoAudiencia.fechaEvento);
        var cmbHoraInicio=gEx('tmeHoraInicio');
        cmbHoraInicio.setValue(oEventoAudiencia.horaInicioEvento);
        var cmbHoraFin=gEx('tmeHoraFin');
        cmbHoraFin.setValue(oEventoAudiencia.horaFinEvento);
        
      
        
    }
    
	cargarDatosAgenda();	                   
}

function cargarDatosAgenda()
{
	
    
    var oParams={
                    cPagina:'sFrm=true',
                    idUnidadGestion:gE('uGestion').value,
                    iEvento:gE('idEvento').value,
                    idSala:gEx('chkMostrarAgendaJuzgado').getValue()?-1:gEx('cmbSecretarias').getValue(),
                    validarTraslape:0,
                    colorearSecretarias:1,
                    fechaBase: gEx('dteFecha').getValue().format('Y-m-d')
                    
                }
    
    
	gEx('frameContenidoAgenda').load	(
    								{
                                    	url:'../modulosEspeciales_SGJP/calendarioEventosJuzgados.php',
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
	var cmbTipoAudiencia=gEx('cmbTipoAudiencia');
    var dteFecha=gEx('dteFecha');
    var cmbHoraInicio=gEx('tmeHoraInicio');
    var cmbHoraFin=gEx('tmeHoraFin');
    var cmbSecretarias=gEx('cmbSecretarias');
    
    if(carpetaAdministrativa=='')
    {
    	function resp5()
        {
        	gEx('cmbNoToca').focus();
        }
        msgBox('Debe seleccionar la Carpeta Judicial de Alzada a la cual pertenece la audiencia',resp5);
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
    
    
    if((cmbTipoAudiencia.getValue()=='2008')&&(gEx('txtEspecifique').getValue()==''))
    {
    	function resp30000()
        {
        	gEx('txtEspecifique').focus();
        }
        msgBox('Debe especificar el tipo de audiencia a agendar',resp30000);
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
    
    if(cmbSecretarias.getValue()=='')
    {
    	function resp32()
        {
        	cmbSecretarias.focus();
        }
        msgBox('Debe indicar la secretaria a la cual pertenece la audiencia a agendar',resp32);
    	return;
    }
    
    var cadObj='{"idEvento":"'+gE('idEvento').value+'","tribunal":"'+gE('uGestion').value+'","toca":"'+carpetaAdministrativa+
    			'","tipoTribunal":"1","edificio":"0","sala":"'+cmbSecretarias.getValue()+'","tipoAudiencia":"'+cmbTipoAudiencia.getValue()+
                '","fecha":"'+dteFecha.getValue().format('Y-m-d')+'","horaInicio":"'+cmbHoraInicio.getValue()+'","horaFin":"'+
                cmbHoraFin.getValue()+'","jueces":['+bD(gE('arrJuecesJuzgado').value)+'],"otroTipoAudiencia":"'+
                cv(gEx('txtEspecifique').getValue())+'"}';
                

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
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[1]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Alzada.php',funcAjax, 'POST','funcion=11&cadObj='+cadObj,true);
    
    
}

function limpiarDatosEvento()
{
	gEx('cmbTipoAudiencia').setValue('');
    gEx('dteFecha').setValue('<?php echo date('Y-m-d')?>');    
    gEx('tmeHoraInicio').setValue('');
    gEx('tmeHoraFin').setValue('');    
    gEx('frameContenidoAgenda').load	(
    								{
                                    	url:'../paginasFunciones/white.php'
                                    }
    							)
    
}

