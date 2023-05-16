<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT concat('\"',claveUnidad,'\"') as claveUnidad,nombreUnidad FROM _17_tablaDinamica WHERE esDespacho=1  ORDER BY categoriaDespacho,nombreUnidad";
	$arrDespachos=$con->obtenerFilasArreglo($consulta);
	
?>
var arrDespachos=<?php echo $arrDespachos?>;
Ext.onReady(inicializar);

function inicializar()
{

    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                cls:'panelSiugj',
                                                border:false,
                                                layout:'border',
                                                tbar:	[
                                                			{
                                                            	xtype:'label',
                                                            	html:'<span class="SIUGJ_Etiqueta"><b>Despacho:</b></span>&nbsp;&nbsp;&nbsp;'
                                                                
                                                            },
                                                             {
                                                            	xtype:'label',
                                                            	html:'<div id="divDespacho">'
                                                                
                                                            },
                                                            {
                                                            	xtype:'tbspacer',
                                                                width:10
                                                            },
                                                            
                                                            {
                                                            	xtype:'label',
                                                            	html:'<span class="SIUGJ_Etiqueta"><b>Mes:</b></span>&nbsp;&nbsp;&nbsp;'
                                                                
                                                            },
                                                            {
                                                            	xtype:'label',
                                                            	html:'<div id="divMes">'
                                                                
                                                            },
                                                             {
                                                            	xtype:'tbspacer',
                                                                width:10
                                                            },
                                                            {
                                                                x:10,
                                                                y:10,
                                                                html:'<span class="SIUGJ_Etiqueta"><b>Periodo del:</b></span>&nbsp;&nbsp;'
                                                            },
                                                            {
                                                            	xtype:'label',
                                                            	html:'<div id="divFechaInicio" style="width:150px">'
                                                                
                                                            },
                                                            
                                                            {
                                                                x:10,
                                                                y:10,
                                                                html:'<span class="SIUGJ_Etiqueta">&nbsp;&nbsp;<b>al:</b>&nbsp;&nbsp;</span>'
                                                            },
                                                            {
                                                            	xtype:'label',
                                                            	html:'<div id="divFechaFin" style="width:150px">'
                                                                
                                                            },'-',
                                                            {
                                                                icon:'../images/Reinscribir.png',
                                                                cls:'x-btn-text-icon',
                                                                text:'Consultar',
                                                                handler:function()
                                                                        {
                                                                            
                                                                            gerenerarReporte()
                                                                        }
                                                                
                                                            }
                                                            
                                                            
                                                		],
                                                items:	[
                                                
                                                			{
                                                            	xtype:'panel',
                                                                region:'center',
                                                				layout:'border',
                                                                
                                                                items:	[
                                                
                                                                            new Ext.ux.IFrameComponent({ 
                            
                                                                                                                        id: 'frameContenidoReporte', 
                                                                                                                        anchor:'100% 100%',
                                                                                                                        region:'center',
                                                                                                                        loadFuncion:function(iFrame)
                                                                                                                                    {
                                                                                                                                       /* autofitIframe(iFrame,
                                                                                                                                        function()
                                                                                                                                        {
                                                                                                                                            
                                                                                                                                         });*/
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


	var cmbDespacho=crearComboExt('cmbDespacho',arrDespachos,0,0,400,{class:'SIUGJ_ControlEtiqueta',multiSelect:true,autoCreate:{tag: "input", type: "text", style:"height:30px !important", autocomplete: "off"},ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divDespacho'});

    
    var cmbMes=crearComboExt('cmbMes',arrMeses,0,0,180,{autoCreate:{class:'SIUGJ_ControlEtiqueta',tag: "input", type: "text", style:"height:30px !important", autocomplete: "off"},ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divMes'});
    cmbMes.on('select',function(cmb,registro)
    					{
                        	var mes=registro.data.id;
                            if(parseInt(mes)<10)
                            {
                            	mes='0'+mes;
                            }
                            gEx('dteFechaInicio').setValue(gEx('dteFechaInicio').getValue().format('Y')+'-'+mes+'-01');
							var fechaFinal=gEx('dteFechaInicio').getValue();
                            fechaFinal=fechaFinal.add(Date.MONTH,1);
                        	fechaFinal=Date.parseDate(fechaFinal.format('Y')+'-'+fechaFinal.format('m')+'-01','Y-m-d');
                            fechaFinal=fechaFinal.add(Date.DAY,-1);
                            gEx('dteFechaFin').setValue(fechaFinal);
                        }
    			)

	new Ext.form.DateField(		{
                                    xtype:'datefield',
                                    id:'dteFechaInicio',
                                    ctCls:'campoFechaSIUGJ',
                                    renderTo:'divFechaInicio',
                                    autoCreate: {tag: "input", type: "text", size: "10", autocomplete: "off", style:"height:30px !important"},
                                    value:'<?php echo date("Y-m-d") ?>'
                                }
                            )

	new Ext.form.DateField(		{
                                     xtype:'datefield',
                                    id:'dteFechaFin',
                                    ctCls:'campoFechaSIUGJ',
                                    renderTo:'divFechaFin',
                                    autoCreate: {tag: "input", type: "text", size: "10", autocomplete: "off", style:"height:30px !important"},
                                    value:'<?php echo date("Y-m-d") ?>',
                                }
                            )
	
}


function gerenerarReporte()
{
	if(gEx('cmbDespacho').getValue()=='')
    {
    	function resp()
        {
        	gEx('cmbDespacho').focus();
        }
        msgBox('Debe selecionar almenos un despacho para consultar');
        return;
    }


	gEx('frameContenidoReporte').load	(
    										{
                                            	url:'../modulosEspeciales_SIUGJ/tblLibroConcilliacion.php',
                                                params: {
                                                			
                                                            
                                                            despacho: gEx('cmbDespacho').getValue(),
                                                            fechaInicio:gEx('dteFechaInicio').getValue().format('Y-m-d'),
                                                            fechaFin:gEx('dteFechaFin').getValue().format('Y-m-d')
                                                		}
                                            }
    									)
}