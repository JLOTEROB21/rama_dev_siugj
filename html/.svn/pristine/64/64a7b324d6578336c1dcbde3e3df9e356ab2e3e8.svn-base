<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
?>

Ext.onReady(inicializar);

function inicializar()
{
	
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                			{
                                            	xtype:'panel',
                                                region:'center',
                                                border:false,
                                                layout:'border',
                                                items:	[
                                                			{
                                                            	xtype:'panel',
                                                                region:'north',
                                                                height:70,
                                                                border:false,
                                                                layout:'absolute',
                                                                items:	[
                                                                			{
                                                                                x:40,
                                                                                y:15,
                                                                                xtype:'label',
                                                                                html:'<div id="divComboProcesos">'
                                                                            },
                                                                            {
                                                                            	xtype:'button',
                                                                                icon:'../principalPortal/imagesSIUGJ/addCore.png',
                                                                                text:'Registrar',
                                                                                width:165,
                                                                                height:40,
                                                                                x:445,
                                                                                y:15,
                                                                                id:'btnAddRecordProceso',
                                                                                cls:'btnSIUGJCore',
                                                                                handler:function()
                                                                                        {
                                                                                        	if(gEx('frameRegistroProcesos').getFrameWindow &&(gEx('frameRegistroProcesos').getFrameWindow().agregarNuevoRegistro))
	                                                                                            gEx('frameRegistroProcesos').getFrameWindow().agregarNuevoRegistro();
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	xtype:'button',
                                                                                icon:'../principalPortal/imagesSIUGJ/openCore.png',
                                                                                width:220,
                                                                                height:44,
                                                                                x:625,
                                                                                y:15,
                                                                                id:'btnWatchRecordProceso',
                                                                                cls:'btnSIUGJCancelCore',
                                                                                text:'Ver Informacion',
                                                                                handler:function()
                                                                                        {
                                                                                            if(gEx('frameRegistroProcesos').getFrameWindow &&(gEx('frameRegistroProcesos').getFrameWindow().verInformacion))
	                                                                                            gEx('frameRegistroProcesos').getFrameWindow().verInformacion();
                                                                                            else
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el elemento cuya informaci&oacute;n desea observar');
                                                                                            }
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	xtype:'button',
                                                                                icon:'../principalPortal/imagesSIUGJ/deleteCore.png',
                                                                                text:'Remover',
                                                                                width:165,
                                                                                height:40,
                                                                                x:860,
                                                                                y:15,
                                                                                disabled:true,
                                                                                id:'btnDeleteRecordProceso',
                                                                                cls:'btnSIUGJCore',
                                                                                handler:function()
                                                                                        {
                                                                                            if(gEx('frameRegistroProcesos').getFrameWindow &&(gEx('frameRegistroProcesos').getFrameWindow().removerRegistro))
	                                                                                            gEx('frameRegistroProcesos').getFrameWindow().removerRegistro();
                                                                                        }
                                                                                
                                                                            }
                                                                		]
                                                            },
                                                             new Ext.ux.IFrameComponent({ 
                                                    
                                                                                            id: 'frameRegistroProcesos', 
                                                                                            anchor:'100% 100%',
                                                                                            region:'center',
                                                                                            loadFuncion:function(iFrame)
                                                                                                        {
                                                                                                            
                                                                                                            var body=gEx('frameRegistroProcesos').getFrameDocument().getElementsByTagName('body');                                                                                                                                                                            
                                                                                                                                                                            
                                                                                                             body[0].onclick=function()
                                                                                                             				{
                                                                                                                            	gEx('cmbComboProcesos').collapse( );
                                                                                                                            }
                                                                                                           
                                                                                                            
                                                                                                        },
    
                                                                                            url: '../paginasFunciones/white.php',
                                                                                            style: 'width:100%;height:100%' 
                                                                                    })
                                                		]
                                            }
                                			/*
                                                        ]
                                            }*/
                                
                                
                                           
                                         ]
                            }
                        )   


	
    var arrProcesos=[
    					['1','Procesos judiciales','/modulosEspeciales_SIUGJ/tblProcesosJudiciales.php','-1'],
                        ['2','Demandas ordinarias','../modeloProyectos/visorRegistrosProcesosV2.php','284'],
                        ['3','Tutelas','../modeloProyectos/visorRegistrosProcesosV2.php','296'],
                        ['4','Acci\xF3n p\xFAblica de inconstitucionalidad','../modeloProyectos/visorRegistrosProcesosV2.php','344'],
                        ['5','Exequ\xE1tur','../modeloProyectos/visorRegistrosProcesosV2.php','346'],
                        ['6','Medio de control de nulidad','../modeloProyectos/visorRegistrosProcesosV2.php','347'],
                        ['7','Suspensi\xF3n / Cese de trabajo','../modeloProyectos/visorRegistrosProcesosV2.php','348'],
                        ['8','Casaci\xF3n','../modeloProyectos/visorRegistrosProcesosV2.php','277'],
                        ['9','Recurso de revisi\xF3n','../modeloProyectos/visorRegistrosProcesosV2.php','362'],
                        ['10','Pagos por consignaci\xF3n','../modeloProyectos/visorRegistrosProcesosV2.php','385'],
                        ['11','Dep\xF3sitos judiciales','../modeloProyectos/visorRegistrosProcesosV2.php','384'],
                        ['12','Solicitud de traspaso de deposito judicial','../modeloProyectos/visorRegistrosProcesosV2.php','393']
    				];
    var cmbComboProcesos=crearComboExt('cmbComboProcesos',arrProcesos,0,0,370,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboProcesos'});                        
	cmbComboProcesos.on('select',function(cmb,registro)
    							{
                                	gEx('btnDeleteRecordProceso').disable();
									if(registro.data.id=='1')
                                    {
                                    	gEx('btnAddRecordProceso').disable();
                                        gEx('btnWatchRecordProceso').disable();
                                        
                                    }
                                    else
                                    {
                                    	gEx('btnAddRecordProceso').enable();
                                        gEx('btnWatchRecordProceso').enable();
                                    }
                                	gEx('frameRegistroProcesos').load	(
                                                                    {
                                                                        scripts:true,
                                                                        url:registro.data.valorComp,
                                                                        params:	{
                                                                                    cPagina: 'sFrm=true',
                                                                                    idProceso: registro.data.valorComp2,
                                                                                    pantallaCompleta:'1',
                                                                                    idFormulario: -1,
                                                                                    ocultarBarraBotones:1,
                                                                                    contentIframe:1
                                                                                }
                                                                   }
                                                                )
                                }
    					)
	cmbComboProcesos.setValue('1');
	dispararEventoSelectCombo('cmbComboProcesos');                        
    
}





function recargarContenedorCentral()
{

	if((gE('iframe-frameRegistroProcesos'))&&(gEx('frameRegistroProcesos').getFrameWindow) &&(gEx('frameRegistroProcesos').getFrameWindow().recargarContenedorCentral))
		gEx('frameRegistroProcesos').getFrameWindow().recargarContenedorCentral();
    
}

