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
	
	
	
	
	$consulta="SELECT id__626_tablaDinamica,nombreClaseProceso FROM _626_tablaDinamica  ORDER BY nombreClaseProceso";
	$arrClaseProceso=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT  id__4_tablaDinamica,tipoAudiencia FROM _4_tablaDinamica";
	$arrAudiencias=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__15_tablaDinamica, concat(nombreSala, ' [',e.nombreInmueble,']') FROM _15_tablaDinamica s,_1_tablaDinamica e 
			where e.id__1_tablaDinamica=s.idReferencia and id__15_tablaDinamica in(SELECT DISTINCT idSala FROM 7000_eventosAudiencia) 
			order by nombreSala,nombreInmueble";
	$arrSalasBusqueda=$con->obtenerFilasArreglo($consulta);
	$arrSalas=$arrSalasBusqueda;
	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica";
	$arrUnidades=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idSituacion,descripcionSituacion FROM 7011_situacionEventosAudiencia where descripcionSituacion<>''";
	$arrSituacionEvento=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idSituacion,icono,tamano FROM 7011_situacionEventosAudiencia";
	$arrSituaciones=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__1_tablaDinamica,nombreInmueble FROM _1_tablaDinamica";
	$arrEdificios=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	
	
	$consulta="SELECT id__4_tablaDinamica,tipoAudiencia FROM _4_tablaDinamica ORDER BY tipoAudiencia";
	$arrTipoAudiencia=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idSituacion,descripcionSituacion FROM 7011_situacionEventosAudiencia ORDER BY descripcionSituacion";
	$arrSituacionAudiencia=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__700_tablaDinamica,nombreActuacion FROM _700_tablaDinamica ORDER BY nombreActuacion";
	$arrActuaciones=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__625_tablaDinamica,nombreTipoProceso FROM _625_tablaDinamica ORDER BY nombreTipoProceso";
	$arrTipoProcesos=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__626_tablaDinamica,nombreClaseProceso FROM _626_tablaDinamica ORDER BY nombreClaseProceso";
	$arrClaseProcesos=$con->obtenerFilasArreglo($consulta);
?>
var arrTipoProcesos=<?php echo $arrTipoProcesos?>;
var arrClaseProcesos=<?php echo $arrClaseProcesos?>;
var arrSituacionActuacion=[['1','En registro'],['2','Enviado a despacho']];
var arrActuaciones=<?php echo $arrActuaciones?>;
var arrClaseProceso=<?php echo $arrClaseProceso?>;
var arrEspecialidades=[<?php echo $arrEspecialidades?>];
var arrDespachos=<?php echo $arrDespachos?>;



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
                                                height:270,
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
                                                                x:10,
                                                                y:160,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Tipo de actuaci&oacute;n:'
                                                            },
                                                            {
                                                            	x:180,
                                                                y:160,
                                                                xtype:'label',
                                                                html:'<div id="divComboTipoAudiencia"></div>'
                                                            },
                                                            {
                                                                x:510,
                                                                y:160,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Situaci&oacute;n de la actuaci&oacute;n:'
                                                            },
                                                            {
                                                            	x:750,
                                                                y:155,
                                                                xtype:'label',
                                                                html:'<div id="divComboSituacionAudiencia"></div>'
                                                            },
                                                           {
                                                                x:10,
                                                                y:210,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Fecha de registro:'
                                                            },
                                                            {
                                                            	x:180,
                                                                y:205,
                                                                xtype:'label',
                                                                html:'<div id="divComboInicioRegistro"></div>'
                                                            },
                                                            {
                                                            	x:290,
                                                                y:205,
                                                                xtype:'label',
                                                                html:'<div id="divDteFechaInicio" style="width:150px"></div>'
                                                            },
                                                            
                                                            {
                                                                x:470,
                                                                y:210,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Y'
                                                            },
                                                            {
                                                            	x:510,
                                                                y:205,
                                                                xtype:'label',
                                                                html:'<div id="divComboFinRegistro"></div>'
                                                            },
                                                            {
                                                            	x:620,
                                                                y:205,
                                                                xtype:'label',
                                                                html:'<div id="divDteFechaFin" style="width:150px"></div>'
                                                            }
                                                                                                                                                                                                                                                                                           
                                                            
                                                           
                                                        ]
                                            },
                                            crearGridActuaciones()  
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
    
    
    var cmbTipoActuacion=crearComboExt('cmbTipoActuacion',arrActuaciones,0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboTipoAudiencia'});
    
    var cmbSituacionActuacion=crearComboExt('cmbSituacionActuacion',arrSituacionActuacion,0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboSituacionAudiencia'});
    
    
    
    
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





function recargarGridEventos()
{
	 var cadObjAux='{"depacho":"'+gEx('cmbDespachos').getValue()+'","especialidad":"'+gEx('cmbEspecialidad').getValue()+
                  '","tipoProceso":"'+gEx('cmbTipoProceso').getValue()+'","fechaInicioRegistro":"'+(gEx('fInicioFiltro').getValue()?gEx('fInicioFiltro').getValue().format('Y-m-d'):'')+
                  '","fechaFinRegistro":"'+(gEx('fFinFiltro').getValue()?gEx('fFinFiltro').getValue().format('Y-m-d'):'')+
                  '","condFInicioFiltro":"'+gEx('cmbInicioFiltro').getValue()+'","condFFinFiltro":"'+gEx('cmbFinFiltro').getValue()+
                  '","procesoJudicial":"'+cv(gEx('txtProcesoJudicial').getValue())+
                  '","claseProceso":"'+cv(gEx('cmbClaseProceso').getValue())+'","situacionActuacion":"'+
                  gEx('cmbSituacionActuacion').getValue()+'","tipoActuacion":"'+gEx('cmbTipoActuacion').getValue()+'"}';
              

	gEx('dActuaciones').getStore().load	(
    									{
                                        	url:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',
                                            params:	{
                                            			funcion:'38',
                                                        cadObj:cadObjAux
                                            		}
                                        }
    								)
}

function crearGridActuaciones()
{

	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idRegistro'},
                                                        {name: 'carpetaAdministrativa'},
                                                        {name: 'folioRegistro'},
		                                                {name: 'fechaRegistro', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                                {name: 'iFormulario' }, 
                                                        {name: 'iRegistro' },
                                                        {name: 'tipoActuacion'},                                                     
                                                        {name: 'despacho'} ,
                                                        {name: 'promovente'} ,
                                                        {name: 'tipoProceso'},
                                                        {name: 'situacionActual'},                                                                                                    
                                                        {name: 'claseProceso'}
                                                                                                    
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
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	
       
       
       
        var chkRow=new Ext.grid.CheckboxSelectionModel({checkOnly :false,width:40});
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
                                                             
                                                            {
                                                                header:'Folio de registro',
                                                                width:190,
                                                                sortable:true,
                                                                dataIndex:'folioRegistro'
                                                                
                                                            },
                                                            {
                                                                header:'Fecha de registro',
                                                                width:190,
                                                                sortable:true,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y h:i');
                                                                        }
                                                                
                                                            },
                                                            
                                                            {
                                                                header:'Tipo de actuaci&oacute;n',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'tipoActuacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrActuaciones,val));
                                                                        }
                                                                
                                                            },
                                                            {
                                                                header:'Registrado por',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'promovente'
                                                                
                                                            },
                                                            {
                                                                header:'C&oacute;digo &uacute;nico de proceso',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val;
                                                                        }
                                                                
                                                            },
                                                            {
                                                                header:'Tipo de proceso',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'tipoProceso',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrTipoProcesos,val));
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
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrClaseProcesos,val));
                                                                        }
                                                                
                                                            },
                                                            
                                                            {
                                                                header:'Despacho',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'despacho',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrDespachos,val));
                                                                        }
                                                            },
                                                             {
                                                                header:'Situaci&oacute;n actual',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'situacionActual',
                                                                renderer:function(val)
                                                                		{
                                                                        	console.log(val);
                                                                        	return (parseFloat(val)==1?'En registro':'Enviado a despacho');
                                                                        }
                                                                
                                                            }
                                                           
                                                           
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'dActuaciones',
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
                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                                                            recargarGridEventos();
                                                                                        
                                                                                           
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
                                                                                            
                                                                                            
                                                                                            var cmbTipoActuacion=gEx('cmbTipoActuacion');
                                                                                            cmbTipoActuacion.setValue('');
                                                                                            
                                                                                            var cmbSituacionActuacion=gEx('cmbSituacionActuacion');
                                                                                            cmbSituacionActuacion.setValue('');
   
                                                                                            
                                                                                            gEx('dActuaciones').getStore().removeAll();
                                                                                        
                                                                                            
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