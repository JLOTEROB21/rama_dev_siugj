<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT id__1_tablaDinamica,CONCAT('[',cveInmueble,'] ',nombreInmueble) FROM _1_tablaDinamica ORDER BY cveInmueble,nombreInmueble";
	$arrEdificios=$con->obtenerFilasArreglo($consulta);
	
?>

var arrEdificios=<?php echo $arrEdificios?>;
Ext.onReady(inicializar);

function inicializar()
{
	var cmbEdificios=crearComboExt('cmbEdificios',arrEdificios,0,0,300);
    cmbEdificios.on('select',function(cmb,registro)
    						{
                            	function funcAjax()
                                {
                                    var resp=peticion_http.responseText;
                                    arrResp=resp.split('|');
                                    if(arrResp[0]=='1')
                                    {
                                        var arrDatos=eval(arrResp[1]);
                                        gEx('cmbUnidadGestion').setValue('');
                                        gEx('cmbSala').setValue('');
                                        gEx('cmbUnidadGestion').getStore().loadData(arrDatos);
                                        recargarAgenda();
                                    }
                                    else
                                    {
                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                    }
                                }
                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=4&idEdificio='+registro.data.id,true);
                                
                            }
    				)
    var cmbUnidadGestion=crearComboExt('cmbUnidadGestion',[],0,0,300);
    cmbUnidadGestion.on('select',function(cmb,registro)
    						{
                            	function funcAjax()
                                {
                                    var resp=peticion_http.responseText;
                                    arrResp=resp.split('|');
                                    if(arrResp[0]=='1')
                                    {
                                        var arrDatos=eval(arrResp[1]);
                                        gEx('cmbSala').setValue('');
                                        gEx('cmbSala').getStore().loadData(arrDatos);
                                        recargarAgenda();
                                    }
                                    else
                                    {
                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                    }
                                }
                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=5&idUnidadGestion='+registro.data.id,true);
                                
                            }
    				)
    
    
    
    
    var cmbSala=crearComboExt('cmbSala',[],0,0,300);
    
    
    cmbSala.on('select',function(cmb,registro)
    						{
                            	recargarAgenda();
                            }
                        )
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                
                                                items:	[
                                                			{
                                                            	xtype:'panel',
                                                                region:'center',
                                                                tbar:	[	
                                                                			{
                                                                            	xtype:'label',
                                                                                html:'Edificio:&nbsp;&nbsp;'
                                                                            },
                                                                            cmbEdificios,'-',
                                                                            {
                                                                            	xtype:'label',
                                                                                html:'Unidad de Gesti&oacute;n:&nbsp;&nbsp;'
                                                                            },
                                                                            cmbUnidadGestion,'-',
                                                                            {
                                                                            	xtype:'label',
                                                                                html:'Sala:&nbsp;&nbsp;'
                                                                            },
                                                                            cmbSala
                                                                		],
                                                                items:	[
                                                                			 new Ext.ux.IFrameComponent({ 
                  
                                                                                                              id: 'frameContenido', 
                                                                                                              anchor:'100% 100%',
                                                                                                              region:'center',
  
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
}



function recargarAgenda()
{
	var cmbEdificios=gEx('cmbEdificios');
    var cmbUnidadGestion=gEx('cmbUnidadGestion');
    var cmbSala=gEx('cmbSala');
    
    if((cmbEdificios.getValue()=='')||(cmbUnidadGestion.getValue()=='')||(cmbSala.getValue()==''))
    {
    	gEx('frameContenido').load({url:'../paginasFunciones/white.php'})
    }
    else
    {
    	gEx('frameContenido').load(
        							{
                                    	url:'../modulosEspeciales_SGJP/tblCalendarioSala.php',
                                        params:	{
                                        			idSala:cmbSala.getValue(),
                                                    cPagina:'sFrm=true'
                                        		}
                                    }
                                  )
    }
    
    
}
