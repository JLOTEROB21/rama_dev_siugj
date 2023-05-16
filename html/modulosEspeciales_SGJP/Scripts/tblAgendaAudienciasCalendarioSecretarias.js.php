<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
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
                                                title:'<span style="color:#900; font-size:12px"><b>Agenda de Audiencias (Vista Calendario)</b></span>',
                                                tbar:	[
                                                			{
                                                            	xtype:'label',
                                                            	html:'<b>Secretar&iacute;a:&nbsp;&nbsp;&nbsp;</b>'
                                                            },
                                                            cmbSecretarias,
                                                            {
                                                            	xtype:'label',
                                                            	html:'&nbsp;&nbsp;&nbsp;</b>'
                                                            }
                                                            <?php
															$nReg=1;
                                                            foreach($arrEtSecretarias as $color=>$leyenda)
                                                            {
																if($nReg==1)
																{
																	$nReg++;
																	continue;
																}
                                                                
                                                            ?>
                                                            ,{
                                                                xtype:'label',
                                                                html:'<table><tr><td><div style="width:15px; height:15px; background-color:#<?php echo $color?>; border-style:solid; border-width:1px; border-color:#000"></div></td><td> <span style="color:#<?php echo $color?>"><?php echo utf8_encode($leyenda)?></span></td></tr></table>'
                                                            },'-'
                                                            <?php
                                                            
                                                                $nReg++;
                                                            }
                                                            ?>
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
                                    	url:'../modulosEspeciales_SGJP/calendarioAudienciasJuzgadoSecretarias.php',
                                        params:	{
                                        			tipoVista:gEx('cmbSecretarias').getValue(),
                                                    idJuzgado:idJuzgadoParametro,
                                                    vVacaciones:0,
                                                    vIncidencias:0,
                                                    vGuardias:0,
                                                    vTramite:0,
                                                    cPagina:'sFrm=true'
                                                    
                                        		}
                                    }
    							)
}
