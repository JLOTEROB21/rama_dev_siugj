<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idEdificio=-1;
	$idUnidadGestion=-1;
	
	$consulta="SELECT id__15_tablaDinamica,nombreSala FROM _15_tablaDinamica WHERE idReferencia=5 and id__15_tablaDinamica not in(75,152) ORDER BY nombreSala";
	$arrSalas=$con->obtenerFilasArreglo($consulta);
	
	if(!existeRol("'1_0'") && !existeRol("'112_0'"))
	{
		$consulta="SELECT id__17_tablaDinamica,idReferencia FROM _17_tablaDinamica WHERE claveUnidad='".$_SESSION["codigoInstitucion"]."'";
		$fDatosUnidad=$con->obtenerPrimeraFila($consulta);
		$idUnidadGestion=$fDatosUnidad[0];
		$idEdificio=$fDatosUnidad[1];
		
		
		$consulta="SELECT u.idUsuario, CONCAT('[',clave,'] ',u.nombre) FROM _26_tablaDinamica j,800_usuarios u WHERE idReferencia=".$idUnidadGestion." AND usuarioJuez IS NOT NULL AND usuarioJuez<>-1
					AND u.idUsuario=j.usuarioJuez ORDER BY u.nombre";
	}
	else
	{
		$idEdificio=5;
		$consulta="SELECT u.idUsuario, CONCAT('[',clave,'] ',u.nombre) FROM _26_tablaDinamica j,800_usuarios u WHERE  usuarioJuez IS NOT NULL AND usuarioJuez<>-1
					AND u.idUsuario=j.usuarioJuez and u.idUsuario <>3122 ORDER BY u.nombre";
	}
	
	$arrJueces=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__1_tablaDinamica,nombreInmueble FROM _1_tablaDinamica WHERE idEstado=2 ORDER BY nombreInmueble";
	$arrEdificios=$con->obtenerFilasArreglo($consulta);
	
?>

var idEdificio='<?php echo $idEdificio ?>';
var arrEdificios=<?php echo $arrEdificios?>;
var arrJueces=<?php echo $arrJueces?>;
var arrSalas=<?php echo $arrSalas?>;  

Ext.onReady(inicializar);

function inicializar()
{
	var cmbEdificio=crearComboExt('cmbEdificio',arrEdificios,0,0,300);
	arrJueces.splice(0,0,['0','Ninguno']);
    cmbEdificio.setValue(idEdificio);
    
    cmbEdificio.on('select',function(cmb,registro)
    					{
    						    function respAux22()
                                {
                                    var resp=peticion_http.responseText;
                                    arrResp=resp.split('|');
                                    if(arrResp[0]=='1')
                                    {
                                        var arrDatos=eval(arrResp[1]);
                                        
                                        gEx('cmbSalas').getStore().loadData(arrDatos);
                                        gEx('cmbSalas').setValue(arrDatos[0][0]);
                                        
                                        
                                       
                                        cargarEventosSalas();
                                        
                                        
                                       
                                    }
                                    else
                                    {
                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                    }
                                }
                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',respAux22, 'POST','funcion=5&idUnidadGestion=-1'+
                                                    '&fechaAudiencia='+gEx('dteFecha').getValue().format('Y-m-d')+'&idEdificio='+registro.data.id,false);                  
                        }
    			)
    
    
	var cmbJuez=crearComboExt('cmbJuez',arrJueces,0,0,250);
    cmbJuez.setValue('0');
    cmbJuez.on('select',cargarEventosSalas);    
	var cmbSalas=crearComboExt('cmbSalas',[],0,0,200);
    
    cmbSalas.on('select',cargarEventosSalas);
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Agenda de Salas</b></span>',
                                               	tbar: 	[
                                                			{
                                                            	xtype:'label',
                                                                html:'<b>Fecha:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dteFecha',
                                                                listeners:	{
                                                                				'select':cargarEventosSalas
                                                                			},
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            '-',
                                                            {
                                                            	xtype:'label',
                                                                html:'<b>Sede:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            cmbEdificio,'-',
                                                			{
                                                            	xtype:'label',
                                                                html:'<b>Sala:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            cmbSalas,'-',
                                                            {
                                                            	xtype:'label',
                                                                html:'<b>Mostrar eventos del Juez:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            cmbJuez
                                                		],
                                                        
                                                bbar:	[
                                                            
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
                                                            }
                                                            
                                                        ],        
                                                items:	[
                                                            new Ext.ux.IFrameComponent({ 

                                                                                            id: 'frameContenidoAgenda', 
                                                                                            anchor:'100% 100%',
                                                                                            region:'center',
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
                        )   


	dispararEventoSelectCombo('cmbEdificio');
}

function cargarEventosSalas()
{
	gEx('frameContenidoAgenda').load	(
    								{
                                    	url:'../modulosEspeciales_SGJP/calendarioEventosSala.php',
                                        params:	{
                                        			idSala:gEx('cmbSalas').getValue(),
                                                    cPagina:'sFrm=true',
                                                    asignacionJuez:gEx('cmbJuez').getValue(),
                                                    fechaBase: gEx('dteFecha').getValue().format('Y-m-d')
                                        		}
                                    }
    							)
}