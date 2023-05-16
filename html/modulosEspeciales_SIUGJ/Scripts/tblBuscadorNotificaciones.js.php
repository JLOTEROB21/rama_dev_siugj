<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica WHERE esDespacho=1 ORDER BY nombreUnidad";
	$arrDespachos=$con->obtenerFilasArreglo($consulta);
	
	$arrEspecialidades="";
	$consulta="SELECT id__637_tablaDinamica,nombreEspecialidadDespacho FROM _637_tablaDinamica ORDER by nombreEspecialidadDespacho";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$arrTiposProceso="";
		$consulta="SELECT id__625_tablaDinamica,nombreTipoProceso FROM _625_tablaDinamica WHERE especialidad=".$fila[0]." and id__625_tablaDinamica in 
				(SELECT DISTINCT tipoProceso FROM 7006_carpetasAdministrativas where tipoProceso IS NOT NULL) ORDER BY nombreTipoProceso";
		$resTipo=$con->obtenerFilas($consulta);
		while($filaTipo=mysql_fetch_assoc($resTipo))
		{
			$consulta="SELECT id__626_tablaDinamica,nombreClaseProceso FROM _626_tablaDinamica WHERE 
					idReferencia=".$filaTipo["id__625_tablaDinamica"]." ORDER BY nombreClaseProceso";
			$arrClaseProceso=$con->obtenerFilasArreglo($consulta);
			$o="['".$filaTipo["id__625_tablaDinamica"]."','".cv($filaTipo["nombreTipoProceso"])."',".$arrClaseProceso."]";
			if($arrTiposProceso=="")
				$arrTiposProceso=$o;
			else
				$arrTiposProceso.=",".$o;
		}
		
		$o="['".$fila[0]."','".cv($fila[1])."',[".$arrTiposProceso."]]";
		if($arrEspecialidades=="")
			$arrEspecialidades=$o;
		else
			$arrEspecialidades.=",".$o;
	}
	
	
	
	
	
	
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica";
	$arrUnidades=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__666_tablaDinamica,tipoNotificacion FROM _666_tablaDinamica ORDER BY tipoNotificacion";
	$arrTipoNotificacion=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=274 ORDER BY numEtapa";
	$arrSituacionNotificacion=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__625_tablaDinamica,nombreTipoProceso FROM _625_tablaDinamica ORDER BY nombreTipoProceso";
	$arrTipoProcesos=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__626_tablaDinamica,nombreClaseProceso FROM _626_tablaDinamica ORDER BY nombreClaseProceso";
	$arrClaseProcesos=$con->obtenerFilasArreglo($consulta);
	
	
?>
var arrSiNo=<?php echo $arrSiNo?>;
var arrMedioNotificacion=[['1','Electr\xF3nica'],['2','F\xEDsica'],['3','Sede judicial']];
var arrClaseProcesos=<?php echo $arrClaseProcesos?>;
var arrEspecialidades=[<?php echo $arrEspecialidades?>];
var arrDespachos=<?php echo $arrDespachos?>;
var arrSituacionNotificacion=<?php echo $arrSituacionNotificacion?>;
var arrTipoNotificacion=[['1','Electr\xF3nica'],['2','F\xEDsica'],['3','Ambas']];
var arrTipoProcesos=<?php echo $arrTipoProcesos?>;
var arrEstadoAcuseRecibo=[['1','Con acuse de recibo'],['0','Sin acuse de recibo']];
Ext.onReady(inicializar);

function inicializar()
{
	var arrFiltroFecha=[['>=','>='],['>','>'],['=','='],['<','<'],['<=','<=']];
    
	new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'north',
                                                height:310,
                                                layout:'absolute',
                                                defaultType: 'label',
                                                items:	[
                                                           
                                                            {
                                                                x:10,
                                                                y:10,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Despacho:'
                                                            },
                                                            {
                                                            	x:180,
                                                                y:5,
                                                                xtype:'label',
                                                                html:'<div id="divComboDespacho"></div>'
                                                            },
                                                            
                                                            {
                                                                x:510,
                                                                y:10,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Especialidad:'
                                                            },
                                                             {
                                                            	x:670,
                                                                y:5,
                                                                xtype:'label',
                                                                html:'<div id="divComboEspecialidad"></div>'
                                                            },
                                                            {
                                                                x:10,
                                                                y:60,
                                                                 cls:'SIUGJ_Etiqueta',
                                                                html:'Tipo de proceso:'
                                                            },
                                                             {
                                                            	x:180,
                                                                y:55,
                                                                xtype:'label',
                                                                html:'<div id="divComboTipoProceso"></div>'
                                                            },
                                                            {
                                                                x:510,
                                                                y:60,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Clase de proceso:'
                                                            },
                                                            {
                                                            	x:670,
                                                                y:55,
                                                                xtype:'label',
                                                                html:'<div id="divComboClaseProceso"></div>'
                                                            },
                                                            
                                                            {
                                                                x:10,
                                                                y:110,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Proceso Judicial:'
                                                            },
                                                            {
                                                            	xtype:'textfield',
                                                                width:150,
                                                                x:180,
                                                                cls:'SIUGJ_Control',
                                                                y:105,
                                                                id:'txtProcesoJudicial'
                                                            },
                                                            {
                                                                x:510,
                                                                y:110,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Folio de notificaci&oacute;n:'
                                                            },
                                                            {
                                                            	x:750,
                                                                y:105,
                                                                xtype:'textfield',
                                                                width:200,
                                                                cls:'SIUGJ_Control',
                                                                id:'txtFolioNotificacion'
                                                            },
                                                             {
                                                                x:10,
                                                                y:160,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Tipo de notificacion:'
                                                            },
                                                            {
                                                            	x:180,
                                                                y:160,
                                                                xtype:'label',
                                                                html:'<div id="divComboTipoNotificacion"></div>'
                                                            },
                                                            {
                                                                x:510,
                                                                y:160,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Estado de la notificaci&oacute;n:'
                                                            },
                                                            {
                                                            	x:750,
                                                                y:155,
                                                                xtype:'label',
                                                                html:'<div id="divComboEstaNotificacion"></div>'
                                                            },
                                                            {
                                                                x:10,
                                                                y:210,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Acuse de recibo:'
                                                            },
                                                            {
                                                            	x:180,
                                                                y:205,
                                                                xtype:'label',
                                                                html:'<div id="divComboAcuseRecibo"></div>'
                                                            },
                                                           {
                                                                x:10,
                                                                y:260,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Fecha de registro:'
                                                            },
                                                            {
                                                            	x:180,
                                                                y:255,
                                                                xtype:'label',
                                                                html:'<div id="divComboInicioRegistro"></div>'
                                                            },
                                                            {
                                                            	x:290,
                                                                y:255,
                                                                xtype:'label',
                                                                html:'<div id="divDteFechaInicio" style="width:150px"></div>'
                                                            },
                                                            
                                                            {
                                                                x:470,
                                                                y:260,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Y'
                                                            },
                                                            {
                                                            	x:510,
                                                                y:255,
                                                                xtype:'label',
                                                                html:'<div id="divComboFinRegistro"></div>'
                                                            },
                                                            {
                                                            	x:620,
                                                                y:255,
                                                                xtype:'label',
                                                                html:'<div id="divDteFechaFin" style="width:150px"></div>'
                                                            }
                                                            
                                                           
                                                        ]
                                            },
                                             crearGridNotificaciones()
                                         ]
                            }
                        ) 
                        
                        
	var cmbDespachos=crearComboExt('cmbDespachos',arrDespachos,0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboDespacho'});
    var cmbEspecialidad=crearComboExt('cmbEspecialidad',arrEspecialidades,0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboEspecialidad'});
    cmbEspecialidad.on('select',function(cmb,registro)
                                {
                                    gEx('cmbTipoProceso').setValue('');
                                    gEx('cmbTipoProceso').getStore().loadData(registro.data.valorComp);
                                }
                        )                        
    var cmbTipoProceso=crearComboExt('cmbTipoProceso',[],0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboTipoProceso'});
    cmbTipoProceso.on('select',function(cmb,registro)
    							{
                                	gEx('cmbClaseProceso').setValue('');
                                	gEx('cmbClaseProceso').getStore().loadData(registro.data.valorComp);
                                }
    				)
    
    var cmbClaseProceso=crearComboExt('cmbClaseProceso',[],0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboClaseProceso'});
    
    
    var cmbTipoNotificacion=crearComboExt('cmbTipoNotificacion',arrTipoNotificacion,0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboTipoNotificacion'});
    
    var cmbSituacionNotificacion=crearComboExt('cmbSituacionNotificacion',arrSituacionNotificacion,0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboEstaNotificacion'});
    
    
    var cmbEstadoAcuseRecibo=crearComboExt('cmbEstadoAcuseRecibo',arrEstadoAcuseRecibo,0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboAcuseRecibo'});
    
    
    
    
    var cmbInicioFiltro=crearComboExt('cmbInicioFiltro',arrFiltroFecha,0,0,90,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboInicioRegistro'});
    var cmbFinFiltro=crearComboExt('cmbFinFiltro',arrFiltroFecha,0,0,90,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboFinRegistro'});                   
	new Ext.form.DateField (
    							{
                                    x:0,
                                    y:0,
                                    renderTo:'divDteFechaInicio',
                                    xtype:'datefield',
                                    ctCls:'campoFechaSIUGJ',
                                    id:'fInicioFiltro'
                                }
    						),
	new Ext.form.DateField (
    							{
                                    x:0,
                                    y:0,
                                    ctCls:'campoFechaSIUGJ',
                                    xtype:'datefield',
                                    renderTo:'divDteFechaFin',
                                    id:'fFinFiltro'
                                }
    						)                            
	
}





function recargarGridNotificaciones()
{


	 var cadObjAux='{"depacho":"'+gEx('cmbDespachos').getValue()+'","especialidad":"'+gEx('cmbEspecialidad').getValue()+
                  '","tipoProceso":"'+gEx('cmbTipoProceso').getValue()+'","fechaInicioRegistro":"'+(gEx('fInicioFiltro').getValue()?gEx('fInicioFiltro').getValue().format('Y-m-d'):'')+
                  '","fechaFinRegistro":"'+(gEx('fFinFiltro').getValue()?gEx('fFinFiltro').getValue().format('Y-m-d'):'')+
                  '","condFInicioFiltro":"'+gEx('cmbInicioFiltro').getValue()+'","condFFinFiltro":"'+gEx('cmbFinFiltro').getValue()+
                  '","procesoJudicial":"'+cv(gEx('txtProcesoJudicial').getValue())+
                  '","claseProceso":"'+cv(gEx('cmbClaseProceso').getValue())+'","tipoNotificacion":"'+gEx('cmbTipoNotificacion').getValue()+'","situacionNotificacion":"'+
                  gEx('cmbSituacionNotificacion').getValue()+'","estadoAcuseRecibo":"'+gEx('cmbEstadoAcuseRecibo').getValue()+
                  '","folioNotificacion":"'+cv(gEx('txtFolioNotificacion').getValue())+'"}';
              

	gEx('dNotificaciones').getStore().load	(
    									{
                                        	url:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',
                                            params:	{
                                            			funcion:'39',
                                                        cadObj:cadObjAux
                                            		}
                                        }
    								)
}

function crearGridNotificaciones()
{

	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idRegistro'},
                                                        {name: 'carpetaAdministrativa'},
                                                        {name: 'claseProceso'},
                                                        {name: 'tipoProceso'},
                                                        {name: 'idEstado'},
		                                                {name: 'fechaRegistro', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'folio'},
                                                        {name: 'tipoNotificacion'},
                                                        {name: 'documentoNotificacion'},
                                                        {name: 'destinatario'},
                                                        {name: 'despacho'},
                                                        {name: 'notificado'},
                                                        {name: 'fechaNotificacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'medioNotificacion'}
		                                                
                                                                                                    
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',
                                                                                                  timeout: (1000*600)

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                            groupField: 'fechaRegistro',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	
       
       
       
       
        var chkRow=new Ext.grid.CheckboxSelectionModel({checkOnly :false,width:40});
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
                                                             
                                                            {
                                                                header:'ID Registro',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'idRegistro'
                                                                
                                                            },
                                                            {
                                                                header:'Fecha de registro',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val)		
                                                                		{
                                                                        	return val.format('d/m/Y h:i');
                                                                        }
                                                                
                                                            },
                                                            {
                                                                header:'Folio',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'folio'
                                                                
                                                            },
                                                            {
                                                                header:'Tipo de notificaci&oacute;n',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'tipoNotificacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoNotificacion,val);
                                                                        }
                                                                
                                                            },
                                                            {
                                                                header:'Documento notifica',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'documentoNotificacion',
                                                                renderer:mostrarValorDescripcion
                                                                		
                                                                
                                                            },
                                                            {
                                                                header:'Destinatario',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'destinatario',
                                                                renderer:mostrarValorDescripcion
                                                                		
                                                                
                                                            },
                                                            {
                                                                header:'Despacho',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'despacho',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrDespachos,val);
                                                                        }
                                                                		
                                                                
                                                            },
                                                            {
                                                                header:'C&oacute;digo &uacute;nico de proceso',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                                		
                                                                
                                                            },
                                                            {
                                                                header:'Tipo de proceso',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'tipoProceso',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoProcesos,val);
                                                                        }
                                                                		
                                                                
                                                            }
                                                            ,
                                                            {
                                                                header:'Clase de proceso',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'claseProceso',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrClaseProcesos,val);
                                                                        }
                                                                		
                                                                
                                                            },
                                                            {
                                                                header:'Estado de la notificación',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'idEstado',
                                                                renderer:function(val)
                                                                		{

                                                                        	return mostrarValorDescripcion(formatearValorRendererNumerico(arrSituacionNotificacion,val));
                                                                        }
                                                                		
                                                                
                                                            },
                                                            {
                                                                header:'Notificado',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'notificado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSiNo,val);
                                                                        }
                                                                		
                                                                
                                                            },
                                                            {
                                                                header:'Fecha de notificacion',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'fechaNotificacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val)
	                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                                		
                                                                
                                                            },
                                                            {
                                                                header:'Medio de notificacion',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'medioNotificacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrMedioNotificacion,val);
                                                                        }
                                                                		
                                                                
                                                            }
                                                            
                                                            
                                                           
                                                           
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'dNotificaciones',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                sm:chkRow,
                                                                cls:'gridSiugjPrincipal',
                                                                columnLines : false,     
                                                                
                                                                tbar:	[
                                                                			{
                                                                                x:610,
                                                                                y:65,
                                                                                xtype:'button',
                                                                                icon:'../images/magnifier.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Buscar',
                                                                                handler:function()
                                                                                        {
                                                                                        	var cmbDespachos=gEx('cmbDespachos');
                                                                                            var cmbEspecialidad=gEx('cmbEspecialidad');
                                                                                            var cmbTipoProceso=gEx('cmbTipoProceso');
                                                                                            
                                                                                            var cmbInicioFiltro=gEx('cmbInicioFiltro');
                                                                                            var cmbFinFiltro=gEx('cmbFinFiltro');
                                                                                            
                                                                                            if((gEx('fInicioFiltro').getValue()!='')&&(cmbInicioFiltro.getValue()==''))
                                                                                            {
                                                                                                function resp1()
                                                                                                {
                                                                                                    cmbInicioFiltro.focus();
                                                                                                }
                                                                                                msgBox('Debe seleccionar la condici&oacute;n de b&uacute;squeda por fecha',resp1);
                                                                                                return;
                                                                                            }
                                                                                            
                                                                                            if((gEx('fFinFiltro').getValue()!='')&&(cmbFinFiltro.getValue()==''))
                                                                                            {
                                                                                                function resp2()
                                                                                                {
                                                                                                    cmbFinFiltro.focus();
                                                                                                }
                                                                                                msgBox('Debe seleccionar la condici&oacute;n de b&uacute;squeda por fecha',resp2);
                                                                                                return;
                                                                                            }
                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                                                            recargarGridNotificaciones();
                                                                                        
                                                                                           
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                x:675,
                                                                                y:65,
                                                                                xtype:'button',
                                                                                icon:'../images/find_remove.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Limpiar Filtros',
                                                                                handler:function()
                                                                                        {
                                                                                        	var cmbDespachos=gEx('cmbDespachos');
                                                                                            var cmbEspecialidad=gEx('cmbEspecialidad');
                                                                                            var cmbTipoProceso=gEx('cmbTipoProceso');
                                                                                            var cmbInicioFiltro=gEx('cmbInicioFiltro');
                                                                                            var cmbFinFiltro=gEx('cmbFinFiltro');
                                                                                            var cmbClaseProceso=gEx('cmbClaseProceso');
                                                                                            cmbDespachos.setValue('');
                                                                                            cmbEspecialidad.setValue('');
                                                                                            cmbTipoProceso.setValue('');
                                                                                            cmbInicioFiltro.setValue('');
                                                                                            gEx('fInicioFiltro').setValue('');
                                                                                            cmbFinFiltro.setValue('');
                                                                                            cmbClaseProceso.setValue('');
                                                                                            gEx('fFinFiltro').setValue('');
                                                                                            
                                                                                            gEx('txtProcesoJudicial').setValue('');
                                                                                            
                                                                                            var cmbTipoNotificacion=gEx('cmbTipoNotificacion');
                                                                                            cmbTipoNotificacion.setValue('');
                                                                                            
                                                                                            var cmbSituacionNotificacion=gEx('cmbSituacionNotificacion');
                                                                                            cmbSituacionNotificacion.setValue('');
                                                                                            
                                                                                            var cmbEstadoAcuseRecibo=gEx('cmbEstadoAcuseRecibo');
                                                                                            cmbEstadoAcuseRecibo.setValue('');
                                                                                            
                                                                                            var txtFolioNotificacion=gEx('txtFolioNotificacion');
                                                                                            txtFolioNotificacion.setValue('');
   
                                                                                            
                                                                                            gEx('dNotificaciones').getStore().removeAll();
                                                                                        
                                                                                            
                                                                                        }
                                                                                
                                                                            } 
                                                                		],
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;

}