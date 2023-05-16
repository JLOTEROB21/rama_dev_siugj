<?php
	session_start();
	include("conexionBD.php");
	
	$arrSedes="";
	$consulta="SELECT id__1_tablaDinamica,nombreInmueble FROM _1_tablaDinamica";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		$consulta="SELECT id__15_tablaDinamica,nombreSala FROM _15_tablaDinamica WHERE idReferencia=".$fila["id__1_tablaDinamica"]." ORDER BY nombreSala";
		$arrSalas=$con->obtenerFilasArreglo($consulta);
		$o="['".$fila["id__1_tablaDinamica"]."','".cv($fila["nombreInmueble"])."',".$arrSalas."]";
		if($arrSedes=="")
			$arrSedes=$o;
		else
			$arrSedes.=",".$o;
	}
	$arrSedes="[".$arrSedes."]";
	
?>

var arrSedes=<?php echo $arrSedes?>;

Ext.onReady(inicializar);

function inicializar()
{
	setTimeout( function()
    			{
                    var cmbSede=crearComboExt('cmbSede',arrSedes,0,0,420,{renderTo:'spSede',ctCls:'comboWrapSIUGJAzul',listClass :'listComboSIUGJAzul'});
                    cmbSede.on('select',function(cmb,registro)
                                        {
                                            gEx('cmbSala').setValue('');
                                            gEx('cmbSala').getStore().loadData(registro.data.valorComp);
                                            recargarReporte();
                                        }
                            );
                    var cmbSala=crearComboExt('cmbSala',[],0,0,420,{renderTo:'spSala',ctCls:'comboWrapSIUGJAzul',listClass :'listComboSIUGJAzul'});
                    cmbSala.on('select',recargarReporte);   
                
                    new Ext.form.DateField	(
                                                    {
                                                        xtype:'datefield',
                                                        id:'dteFechaCalendario',
                                                        width:270,
                                                        value:'<?php echo date("Y-m-d")?>',
                                                        ctCls:'campoFechaSIUGJAzul',
                                                        renderTo:'spFechaExpedicion',
                                                        listeners:	{
                                                                        select:recargarReporte
                                                                    }
                                                    }
                                                )  
                    $('#calendar').fullCalendar(
                                                    {
                                                        defaultView:'agendaDay',
                                                        height:obtenerDimensionesNavegador()[0]-230,
                                                        header: 
                                                                {
                                                                    left: '',
                                                                    center: '',
                                                                    right:''
                                                                    
                                                                },
                                                        
                                                        defaultDate: '<?php echo date("Y-m-d")?>',
                                                        businessHours: true, // display business hours
                                                        editable: true,
                                                        scrollTime:'08:00:00',
                                                        loading:function(isLoading,view)
                                                                {
                                                                    if(!isLoading)
                                                                    {
                                                                        
                                                                        
                                                                        
                                                                    }
                                                                },
                                                        dayClick: function(date, jsEvent, view) 
                                                                    {
                                                                        
                                                                        
                                                                        
                                                                    },
                
                                                        eventDrop: function(event, delta, revertFunc) 
                                                                    {
                                                                        
                                                                        
                                                                
                                                                
                                                                    },
                                                        eventResize: function(event, delta, revertFunc) 
                                                                    {
                                                                        
                                                                        
                                                                        
                                                                        
                                                                         
                                                                    
                                                                    },
                                                        eventSources: 	[
                                                                            {
                                                                                id:'defaultEventSource',
                                                                                url:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJSinSession.php',
                                                                                type:'POST',
                                                                                data:	function()
                                                                                        {
                                                                                            return {
                                                                                                        idSala:gEx('cmbSala').getValue()==''?-1:gEx('cmbSala').getValue(),
                                                                                                        asignacionJuez:-1,
                                                                                                        funcion:1
                                                                                                    }
                                                                                        }
                                                                            }
                                                                        ]
                                                                
                                                     }
                                               );
                               
				},500);
    
    
                               
}


function recargarReporte()
{
	$('#calendar').fullCalendar('gotoDate',gEx('dteFechaCalendario').getValue().format('Y-m-d')) ;
}


function functionAfterPrevDate()
{
	var fechaActual=$('#calendar').fullCalendar('getDate');
	gEx('dteFechaCalendario').setValue(fechaActual.format('YYYY-MM-DD'));
}

function functionNextPrevDate()
{
	var fechaActual=$('#calendar').fullCalendar('getDate');
	gEx('dteFechaCalendario').setValue(fechaActual.format('YYYY-MM-DD'));
}