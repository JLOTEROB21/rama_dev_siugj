<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$fechaActual=date("Y-m-d");
	$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$_SESSION["codigoInstitucion"]."'";
	$idReferencia=$con->obtenerValor($consulta);
	
	$consulta="SELECT id__15_tablaDinamica,nombreSala FROM _55_tablaDinamica se,_15_tablaDinamica s WHERE se.idReferencia=".$idReferencia." 
			AND salasVinculadas=s.id__15_tablaDinamica order by nombreSala";
	$arrSalas=$con->obtenerFilasArreglo($consulta);
	
	$secretariaDefault='';
	$responsableAgenda="false";
	if(existeRol("'69_0'")||existeRol("'56_0'"))
	{
		$responsableAgenda="true";
		$secretariaDefault='0';
		
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

var idJuzgadoParametro=<?php echo $idReferencia?>;
var responsableAgenda=<?php echo $responsableAgenda?>;
var secretariaDefault='<?php echo $secretariaDefault?>';
var arrSalas=<?php echo $arrSalas?>;

Ext.onReady(inicializar);

function inicializar()
{

	if(responsableAgenda)
    {
    	arrSalas.splice(0,0,['0','Todas']);
    }
	var cmbSecretarias=crearComboExt('cmbSecretarias',arrSalas,0,0,220);
    cmbSecretarias.setValue(secretariaDefault);
    cmbSecretarias.on('select',function(cmb,registro)
    					{
    						recargarGridEventos();                    
                        }
    			)	 
	
	if(!responsableAgenda)
    {
    	cmbSecretarias.disable();
    }      
    
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title:'<span style="color:#900; font-size:12px"><b>Agenda de Audiencias (Vista Listado)</b></span>',
                                                tbar:	[
                                                			{
                                                            	xtype:'label',
                                                                html:'&nbsp;&nbsp;&nbsp;<b>Juzgado:</b>&nbsp;<span style="color: #900"><b>'+gE('nombreUnidad').value+'</b></span>&nbsp;&nbsp;'
                                                            },'-',
                                                			{
                                                            	xtype:'label',
                                                            	html:'<b>Secretar&iacute;a:&nbsp;&nbsp;&nbsp;</b>'
                                                            },
                                                            cmbSecretarias,
                                                            {
                                                            	xtype:'label',
                                                            	html:'&nbsp;&nbsp;&nbsp;</b>'
                                                            },'-',
                                                            {
                                                            	xtype:'label',
                                                                html:'<b>Periodo del:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dtePeriodoInicial',
                                                                value:'<?php echo $fechaActual?>',
                                                                listeners:	{
                                                                				select:function()
                                                                                		{
                                                                                        	recargarGridEventos();
                                                                                        }
                                                                                        
                                                                			}
                                                            },'-',
                                                            {
                                                            	xtype:'label',
                                                                html:'&nbsp;&nbsp;&nbsp;<b>Periodo al:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dtePeriodoFinal',
                                                                value:'<?php echo $fechaActual?>',
                                                                listeners:	{
                                                                				select:function()
                                                                                		{
                                                                                        	recargarGridEventos();
                                                                                        }
                                                                                        
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
	
    dispararEventoSelectCombo('cmbSecretarias');                         
    
}


function recargarGridEventos()
{
	gEx('frameContenidoCalendario').load	(
    								{
                                    	url:'../modulosEspeciales_SGJP/tblTableroAudienciasJuzgadoSecretarias.php',
                                        params:	{
                                        			tipoVista:gEx('cmbSecretarias').getValue(),
                                                    idJuzgado:idJuzgadoParametro,
                                                   	periodoInicio: gEx('dtePeriodoInicial').getValue().format('Y-m-d'),
                                                    periodoFin:gEx('dtePeriodoFinal').getValue().format('Y-m-d'),
                                                    cPagina:'sFrm=true'
                                                    
                                        		}
                                    }
    							)
}
