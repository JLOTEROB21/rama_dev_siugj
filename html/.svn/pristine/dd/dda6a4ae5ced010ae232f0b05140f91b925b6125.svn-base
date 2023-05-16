<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$fechaActual=date("Y-m-d");
	$diaActual=date("N",strtotime($fechaActual));
	$fechaFinal=7-$diaActual;
	
	$fechaFinal=date("Y-m-d",strtotime("+".$fechaFinal." days",strtotime($fechaActual)));
	
	$consulta="SELECT  id__4_tablaDinamica,tipoAudiencia FROM _4_tablaDinamica";
	$arrAudiencias=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__15_tablaDinamica,nombreSala FROM _15_tablaDinamica";
	$arrSalas=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica";
	$arrUnidades=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idSituacion,descripcionSituacion FROM 7011_situacionEventosAudiencia";
	$arrSituacionEvento=$con->obtenerFilasArreglo($consulta);
?>

var arrSituacionEvento=<?php echo $arrSituacionEvento?>;
var arrSalas=<?php echo $arrSalas?>;
var arrAudiencias=<?php echo $arrAudiencias?>;
var arrUnidades=<?php echo $arrUnidades?>;

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
                                                tbar:	[	
                                                			{
                                                            	xtype:'label',
                                                                html:'&nbsp;&nbsp;&nbsp;<b><?php echo existeRol("'96_0'")?"Magistrado":"Juez"?>:</b>&nbsp;<span style="color: #900"><b>'+gE('nombreUsuario').value+'</b></span>&nbsp;&nbsp;'
                                                            },'-',
                                                			{
                                                            	xtype:'checkbox',
                                                                id:'chkPeriodoV',
                                                                boxLabel:'Mostrar periodo vacacional',
                                                                listeners:	{
                                                                                check:recargarGridEventos
                                                                            }
                                                                
                                                            },'-',
                                                			{
                                                            	xtype:'checkbox',
                                                                id:'chkIncidencias',
                                                                boxLabel:'Mostrar incidencias/permisos',
                                                                listeners:	{
                                                                                check:recargarGridEventos
                                                                            }
                                                                
                                                            },'-',
                                                			{
                                                            	xtype:'checkbox',
                                                                id:'chkGuardias',
                                                                hidden:<?php echo (existeRol("'96_0'")||($tipoMateria!='P'))?"true":"false"?>,
                                                                boxLabel:'Mostrar periodos de guardia',
                                                                listeners:	{
                                                                                check:recargarGridEventos
                                                                            }
                                                                
                                                            },'-',
                                                			{
                                                            	xtype:'checkbox',
                                                                id:'chkTramite',
                                                                hidden:<?php echo(existeRol("'96_0'")||($tipoMateria!='P'))?"true":"false"?>,
                                                                boxLabel:'Mostrar periodos de juez de tr&aacute;mite',
                                                                listeners:	{
                                                                                check:recargarGridEventos
                                                                            }
                                                                
                                                            }
                                                		],
                                                items:	[
                                                            new Ext.ux.IFrameComponent({ 
                
                                                                                              id: 'frameContenidoCalendario', 
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


	recargarGridEventos();
}


function recargarGridEventos()
{
	gEx('frameContenidoCalendario').load	(
    								{
                                    	url:'../modulosEspeciales_SGJP/calendarioAudienciasJuez.php',
                                        params:	{
                                        			idUsr:gE('idUsuario').value,
                                                    vVacaciones:gEx('chkPeriodoV').getValue()?'1':0,
                                                    vIncidencias:gEx('chkIncidencias').getValue()?'1':0,
                                                    vGuardias:gEx('chkGuardias').getValue()?'1':0,
                                                    vTramite:gEx('chkTramite').getValue()?'1':0,
                                                    cPagina:'sFrm=true'
                                                    
                                        		}
                                    }
    							)
}
