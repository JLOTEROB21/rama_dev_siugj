<?php
	session_start();
	include("conexionBD.php");

	$arrSedes="";
	$consulta="SELECT id__1_tablaDinamica,nombreInmueble FROM _1_tablaDinamica";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
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
                    var cmbSede=crearComboExt('cmbSede',arrSedes,0,0,350);
                    cmbSede.on('select',function(cmb,registro)
                                        {
                                            gEx('cmbSala').setValue('');
                                            gEx('cmbSala').getStore().loadData(registro.data.valorComp);
                                            gEx('frameContenidoReporte').load	(
                                                                                    {	
                                                                                        url:'../paginasFunciones/white.php',
                                                                                        
                                                                                    }
                                                                                )
                                        }
                            );
                    var cmbSala=crearComboExt('cmbSala',[],0,0,350);
                    cmbSala.on('select',recargarReporte);
                    
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
                                                                                layout:'border',
                                                                                cls:'panelSiugj',
                                                                                title:'<span style="font-size:30px">Calendario de Audiencias</span>',
                                                                                tbar:	[
                                                                                            
                                                                                            {
                                                                                                xtype:'label',
                                                                                                html:'<span class="SIUGJ_Etiqueta">Sede:</span>&nbsp;&nbsp;'
                                                                                            },
                                                                                            cmbSede,
                                                                                            {
                                                                                                xtype:'label',
                                                                                                html:'&nbsp;&nbsp;&nbsp;&nbsp;<span class="SIUGJ_Etiqueta">Sala:</span>&nbsp;&nbsp;'
                                                                                            },
                                                                                            cmbSala,
                                                                                            {
                                                                                                xtype:'label',
                                                                                                html:'&nbsp;&nbsp;&nbsp;&nbsp;<span class="SIUGJ_Etiqueta">Fecha:</span>&nbsp;&nbsp;'
                                                                                            },
                                                                                            {
                                                                                                icon:'../images/left1.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                width:30,
                                                                                                handler:function()
                                                                                                        {
                                                                                                            gEx('fechaBase').setValue(gEx('fechaBase').getValue().add(Date.DAY, -1));
                                                                                                            recargarReporte()
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                            {
                                                                                                xtype:'datefield',
                                                                                                id:'fechaBase',
                                                                                                value:'<?php echo date("Y-m-d") ?>',
                                                                                                listeners:	{
                                                                                                                'select':function()
                                                                                                                        {
                                                                                                                            recargarReporte()
                                                                                                                        },
                                                                                                                'change':function()
                                                                                                                        {
                                                                                                                            recargarReporte()
                                                                                                                        }
                                                                                                            }
                                                                                            },
                                                                                            {
                                                                                                icon:'../images/right1.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                width:30,
                                                                                                handler:function()
                                                                                                        {
                                                                                                             gEx('fechaBase').setValue(gEx('fechaBase').getValue().add(Date.DAY, 1));
                                                                                                             recargarReporte()
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                            
                                                                                        ],
                                                                                items:	[
                                                                                             new Ext.ux.IFrameComponent({ 
                                
                                                                                                                        id: 'frameContenidoReporte', 
                                                                                                                        anchor:'100% 100%',
                                                                                                                        border:false,
                                                                                                                        region:'center',
                                                                                                                        loadFuncion:function(iFrame)
                                                                                                                                    {
                                                                                                                                        
                                                                                                                                        
                                                                                                                                       
                                                                                                                                        
                                                                                                                                    },
                                
                                                                                                                        url: '../paginasFunciones/white.php',
                                                                                                                        style: 'width:100%;height:700px' 
                                                                                                                })
                                                                                        ]
                                                                            }
                                                                        ]
                                                            }
                                                            
                                                         ]
                                            }
                                        )   
					},5000                                        
			)
	
}


function recargarReporte()
{
	gEx('frameContenidoReporte').load	(
    										{	
                                            	url:'../reportes/frmReporteSalaCalendario.php',
                                                params:	{
                                                			idSala:gEx('cmbSala').getValue(),
                                                            fechaBase:gEx('fechaBase').getValue().format('Y-m-d'),
                                                            cPagina: 'sFrm=true'
                                                		}
                                            }
    									)
}
