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
	
	$consulta="SELECT idTipoCarpeta,nombreTipoCarpeta FROM 7020_tipoCarpetaAdministrativa";
	$arrTipoCarpeta=$con->obtenerFilasArreglo($consulta);	
	
	$consulta="SELECT id__625_tablaDinamica,nombreTipoProceso FROM _625_tablaDinamica  ORDER BY nombreTipoProceso";
	$arrTiposProcesoGlobal=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
	$arrEstados=$con->obtenerFilasArreglo($consulta);	
	
	
	$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica order by nombreTipo";
	$arrTipoFigura=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT id__32_tablaDinamica,UPPER(tipoIdentificacion) FROM _32_tablaDinamica WHERE id__32_tablaDinamica NOT IN(19,9999,13,17) ORDER BY tipoIdentificacion";
	$arrTipoIdentificacion=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__626_tablaDinamica,nombreClaseProceso FROM _626_tablaDinamica  ORDER BY nombreClaseProceso";
	$arrClaseProceso=$con->obtenerFilasArreglo($consulta);

?>

var arrClaseProceso=<?php echo $arrClaseProceso?>;
var arrTipoIdentificacion=<?php echo $arrTipoIdentificacion?>;
var arrTiposProcesoGlobal=<?php echo $arrTiposProcesoGlobal?>;
var arrTipoCarpeta=<?php echo $arrTipoCarpeta?>;
var arrEstadoProceso=[['1','Abierto'],['3','Cerrado']];
var arrEspecialidades=[<?php echo $arrEspecialidades?>];
var arrDespachos=<?php echo $arrDespachos?>;
var arrEstadoProcesoGlobal=[['0','No Iniciado'],['1','Abierto'],['3','Cerrado']];
var arrEstados=<?php echo $arrEstados?>;
var arrTipoFigura=<?php echo $arrTipoFigura?>;

Ext.onReady(inicializar);

function inicializar()
{
	arrTipoFigura.splice(0,0,['-10','Auxiliar de justicia']);
	var arrFiltroFecha=[['>=','>='],['>','>'],['=','='],['<','<'],['<=','<=']];
    
	new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'north',
                                                height:320,
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
                                                                html:'Estado del proceso:'
                                                            },
                                                             {
                                                            	x:180,
                                                                y:105,
                                                                xtype:'label',
                                                                html:'<div id="divComboEstadoProceso"></div>'
                                                            },
                                                            {
                                                                x:510,
                                                                y:110,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Proceso Judicial:'
                                                            },
                                                            {
                                                            	xtype:'textfield',
                                                                width:150,
                                                                x:670,
                                                                cls:'SIUGJ_Control',
                                                                y:105,
                                                                id:'txtProcesoJudicial'
                                                            },
                                                            {
                                                                x:860,
                                                                y:110,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Folio de Radicaci&oacute;n:'
                                                            },
                                                            {
                                                            	xtype:'textfield',
                                                                width:150,
                                                                x:1050,
                                                                y:105,
                                                                cls:'SIUGJ_Control',
                                                                id:'txtFolioRadicacion'
                                                            },
                                                           {
                                                                x:10,
                                                                y:160,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Fecha de Registro:'
                                                            },
                                                            {
                                                            	x:180,
                                                                y:155,
                                                                xtype:'label',
                                                                html:'<div id="divComboInicioRegistro"></div>'
                                                            },
                                                            {
                                                            	x:290,
                                                                y:155,
                                                                xtype:'label',
                                                                html:'<div id="divDteFechaInicio" style="width:150px"></div>'
                                                            },
                                                            
                                                            {
                                                                x:470,
                                                                y:160,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Y'
                                                            },
                                                            {
                                                            	x:510,
                                                                y:155,
                                                                xtype:'label',
                                                                html:'<div id="divComboFinRegistro"></div>'
                                                            },
                                                            
                                                             
                                                            {
                                                            	x:620,
                                                                y:155,
                                                                xtype:'label',
                                                                html:'<div id="divDteFechaFin" style="width:150px"></div>'
                                                            },
                                                            {
                                                            	x:10,
                                                                y:210,
                                                            	xtype:'label',
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Persona que desea buscar:'
                                                            },
                                                            {
                                                            	x:290,
                                                                y:205,
                                                            	xtype:'textfield',
                                                                width:300,
                                                                cls:'SIUGJ_Control',
                                                                enableKeyEvents:true,
                                                                id:'txtCriterio',
                                                                listeners:	{
                                                                				specialkey:function(field, e)
                                                                                			{
                                                                                            	 if ((e.getKey() == e.ENTER)||(e.getKey() == e.TAB))
                                                                                                 {
                                                                                                 	realizarBusqueda();
                                                                                                 }
                                                                                            }
                                                                				
                                                                			}
                                                            },
                                                            {
                                                            	xtype:'label',
                                                                x:620,
                                                                y:210,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Tipo de Participaci&oacute;n:'
                                                            },
                                                            {
                                                            	x:860,
                                                                y:205,
                                                                xtype:'label',
                                                                html:'<div id="divComboTipoParticipacion" ></div>'
                                                            },
                                                            
                                                             {
                                                            	xtype:'label',
                                                                x:10,
                                                                y:260,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'No. de Documento:'
                                                            },
                                                            {
                                                            	x:180,
                                                                y:255,
                                                            	xtype:'textfield',
                                                                width:150,
                                                                cls:'SIUGJ_Control',
                                                                allowDecimals:true,
                                                                allowNegative:false,
                                                                id:'noDocumento'
                                                            },
                                                             {
                                                            	xtype:'label',
                                                                x:510,
                                                                y:260,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Tipo de Documento:'
                                                            },
                                                            {
                                                            	x:700,
                                                                y:255,
                                                                xtype:'label',
                                                                html:'<div id="divComboTipoDocumento" ></div>'
                                                            }
                                                            
                                                           
                                                        ]
                                            },
                                             crearGridResultadoProcesos()
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
    
    
    
    
    var cmbEstadoProceso=crearComboExt('cmbEstadoProceso',arrEstadoProceso,0,0,250,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboEstadoProceso'});
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
	var cmbTipoFigura=crearComboExt('cmbTipoFigura',arrTipoFigura,0,0,250,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboTipoParticipacion'});  	
	var cmbTipoDocumento=crearComboExt('cmbTipoDocumento',arrTipoIdentificacion,0,0,280,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboTipoDocumento'});  
}


function crearGridResultadoProcesos()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name:'idFormulario'},
                                                        {name:'idCarpeta'},
		                                                {name: 'folioRegistro'},
                                                        {name: 'tipoCarpeta'},
		                                                {name:'fechaRegistro', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'codigoUnicoProceso'},
                                                        {name: 'tituloProceso'},
                                                        {name: 'tipoProceso'},
                                                        {name: 'claseProceso'},
                                                        {name: 'especialidad'},
                                                        {name:'departamento'},
                                                        {name:'despacho'},
                                                        {name: 'estadoProceso'},
                                                        {name: 'actor'},
                                                        {name: 'demandado'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                            groupField: 'fechaRegistro',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='7';
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            {
                                                                header:'Folio de Registro',
                                                                width:160,
                                                                sortable:true,
                                                                dataIndex:'folioRegistro',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:abrirProcesoBusqueda(\''+bE(registro.data.idFormulario)+'\',\''+bE(registro.data.idRegistro)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de Registro',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val)
                                                                			{
                                                                            	return val.format('d/m/Y H:i')+' hrs.';
                                                                            }
                                                            },
                                                            {
                                                                header:'C&oacute;digo &Uacute;nico de Proceso',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'codigoUnicoProceso',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return val;
                                                                        	return '<a href="javascript:setBusquedaCodigo(\''+bE(val)+'\',\''+bE(registro.data.idCarpeta)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Tipo de Expediente',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'tipoCarpeta',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoCarpeta,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'T&iacute;tulo del Proceso',
                                                                width:400,
                                                                sortable:true,
                                                                hidden:true,
                                                                dataIndex:'tituloProceso'
                                                            },
                                                            
                                                            {
                                                                header:'Tipo de Proceso',
                                                                width:160,
                                                                sortable:true,
                                                                dataIndex:'tipoProceso',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrTiposProcesoGlobal,val);
                                                                            }
                                                            },
                                                            {
                                                                header:'Clase de Proceso',
                                                                width:160,
                                                                sortable:true,
                                                                dataIndex:'claseProceso',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrClaseProceso,val);
                                                                            }
                                                            },
                                                            {
                                                                header:'Especialidad',
                                                                width:160,
                                                                sortable:true,
                                                                dataIndex:'especialidad',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrEspecialidades,val);
                                                                            }
                                                            },
                                                            {
                                                                header:'Departamento',
                                                                width:160,
                                                                sortable:true,
                                                                dataIndex:'departamento',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrEstados,val);
                                                                            }
                                                            },
                                                            
                                                            {
                                                                header:'Despacho',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'despacho',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrDespachos,val);
                                                                            }
                                                            },
                                                            {
                                                                header:'Actor/Accionante',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'actor',
                                                                renderer:function(val)
                                                                			{
                                                                            	return val;
                                                                            }
                                                            },
                                                            {
                                                                header:'Demandado/Accionado',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'demandado',
                                                                renderer:function(val)
                                                                			{
                                                                            	return val;
                                                                            }
                                                            },
                                                            {
                                                                header:'Estado del Proceso',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'estadoProceso',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrEstadoProcesoGlobal,val);
                                                                            }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gResultadoBusqueda',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cls:'gridSiugjPrincipal',
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
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
                                                                                            var cmbEstadoProceso=gEx('cmbEstadoProceso');
                                                                                            var cmbDespachos=gEx('cmbDespachos');
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
                                                                                            
                                                                                            if((gEx('txtCriterio').getValue()!='')&&(+gEx('cmbTipoFigura').getValue()==''))
                                                                                            {
                                                                                            	
                                                                                            	function resp4()
                                                                                                {
                                                                                                    gEx('txtCriterio').focus();
                                                                                                }
                                                                                                msgBox('Debe seleccionar el tipo de participaci&oacute;n de la persona que desea buscar',resp4);
                                                                                                return;
                                                                                            }
                                                                                            
                                                                                            if((gEx('noDocumento').getValue()!='')&&(+gEx('cmbTipoDocumento').getValue()==''))
                                                                                            {
                                                                                            	
                                                                                            	function resp3()
                                                                                                {
                                                                                                    gEx('cmbTipoDocumento').focus();
                                                                                                }
                                                                                                msgBox('Debe seleccionar el Tipo de Documento que desea buscar',resp3);
                                                                                                return;
                                                                                            }
                                                                                            
                                                                                        
                                                                                            var cadObj='{"depacho":"'+cmbDespachos.getValue()+'","especialidad":"'+cmbEspecialidad.getValue()+
                                                                                            '","tipoProceso":"'+cmbTipoProceso.getValue()+'","estadoProceso":"'+cmbEstadoProceso.getValue()+
                                                                                            '","fechaInicioRegistro":"'+(gEx('fInicioFiltro').getValue()?gEx('fInicioFiltro').getValue().format('Y-m-d'):'')+
                                                                                            '","fechaFinRegistro":"'+(gEx('fFinFiltro').getValue()?gEx('fFinFiltro').getValue().format('Y-m-d'):'')+
                                                                                            '","condFInicioFiltro":"'+cmbInicioFiltro.getValue()+'","condFFinFiltro":"'+cmbFinFiltro.getValue()+
                                                                                            '","folioRadiacion":"'+cv(gEx('txtFolioRadicacion').getValue())+
                                                                                            '","procesoJudicial":"'+cv(gEx('txtProcesoJudicial').getValue())+
                                                                                            '","nombreParticipante":"'+cv(gEx('txtCriterio').getValue())+'","tipoFigura":"'+gEx('cmbTipoFigura').getValue()+
                                                                                            '","noDocumento":"'+cv(gEx('noDocumento').getValue())+'","tipoDocumento":"'+gEx('cmbTipoDocumento').getValue()+
                                                                                            '","claseProceso":"'+cv(gEx('cmbClaseProceso').getValue())+'"}';
                                                                                        
                                                                                        
                                                                                            gEx('gResultadoBusqueda').getStore().load	(
                                                                                                                                            {
                                                                                                                                                url:'../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',
                                                                                                                                                params:	{
                                                                                                                                                            criterioBusqueda:cadObj
                                                                                                                                                        }
                                                                                                                                             }
                    
                                                                                                                                        )
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
                                                                                            var cmbEstadoProceso=gEx('cmbEstadoProceso');
                                                                                            var cmbDespachos=gEx('cmbDespachos');
                                                                                            var cmbInicioFiltro=gEx('cmbInicioFiltro');
                                                                                            var cmbFinFiltro=gEx('cmbFinFiltro');
                                                                                            var cmbClaseProceso=gEx('cmbClaseProceso');
                                                                                            cmbDespachos.setValue('');
                                                                                            cmbEspecialidad.setValue('');
                                                                                            cmbTipoProceso.setValue('');
                                                                                            cmbEstadoProceso.setValue('');
                                                                                            cmbInicioFiltro.setValue('');
                                                                                            gEx('fInicioFiltro').setValue('');
                                                                                            cmbFinFiltro.setValue('');
                                                                                            cmbClaseProceso.setValue('');
                                                                                            gEx('fFinFiltro').setValue('');
                                                                                            
                                                                                            gEx('txtFolioRadicacion').setValue('');
                                                                                            gEx('txtProcesoJudicial').setValue('');
                                                                                            gEx('txtCriterio').setValue('');
                                                                                            gEx('cmbTipoFigura').setValue('');
                                                                                            gEx('noDocumento').setValue('');
                                                                                            gEx('cmbTipoDocumento').setValue('');
                                                                                            
                                                                                            
                                                                                            gEx('gResultadoBusqueda').getStore().removeAll();
                                                                                        
                                                                                            
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


function abrirProcesoBusqueda(iF,iR)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['idFormulario',bD(iF)],['idRegistro',bD(iR)],['actor',bE(0)],['dComp',bE('auto')]];
    
    abrirVentanaFancySuperior(obj);
    
    
}