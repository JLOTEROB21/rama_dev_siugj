<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica WHERE esDespacho=1 ORDER BY nombreUnidad";
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
	
?>

var arrClaseProceso=<?php echo $arrClaseProceso?>;
var arrEspecialidades=[<?php echo $arrEspecialidades?>];
var arrDespachos=<?php echo $arrDespachos?>;

var arrSiNo=<?php echo $arrSiNo?>;
var arrSalasBusqueda=<?php echo $arrSalasBusqueda?>;
var arrSituacionEvento=<?php echo $arrSituacionEvento?>;
var arrEdificios=<?php echo $arrEdificios?>;
var arrSalas=<?php echo $arrSalas?>;
var arrAudiencias=<?php echo $arrAudiencias?>;
var arrUnidades=<?php echo $arrUnidades?>;
var arrTipoAudiencia=<?php echo $arrTipoAudiencia?>;
var arrSemaforo=<?php echo $arrSituaciones?>;


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
                                                                x:510,
                                                                y:110,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Sala:'
                                                            },
                                                            {
                                                            	x:670,
                                                                y:105,
                                                                xtype:'label',
                                                                html:'<div id="divComboSala"></div>'
                                                            },
                                                             {
                                                                x:10,
                                                                y:160,
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Tipo de audiencia:'
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
                                                                html:'Situaci&oacute;n de la audiencia:'
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
                                                                html:'Fecha de audiencia:'
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
                                             crearGridEventos()
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
    
    var cmbSala=crearComboExt('cmbSala',arrSalas,0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboSala'});
    
    var cmbTipoAudiencia=crearComboExt('cmbTipoAudiencia',arrTipoAudiencia,0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboTipoAudiencia'});
    
    var cmbSituacionAudiencia=crearComboExt('cmbSituacionAudiencia',arrSituacionEvento,0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboSituacionAudiencia'});
    
    
    
    
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
                  '","claseProceso":"'+cv(gEx('cmbClaseProceso').getValue())+'","sala":"'+gEx('cmbSala').getValue()+'","situacionAudiencia":"'+
                  gEx('cmbSituacionAudiencia').getValue()+'","tipoAudiencia":"'+gEx('cmbTipoAudiencia').getValue()+'"}';
              

	gEx('dEventos').getStore().load	(
    									{
                                        	url:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',
                                            params:	{
                                            			funcion:'37',
                                                        cadObj:cadObjAux
                                            		}
                                        }
    								)
}

function crearGridEventos()
{

	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idEvento'},
                                                        {name: 'carpetaAdministrativa'},
		                                                {name: 'fechaEvento', type:'date', dateFormat:'Y-m-d'},
		                                                {name: 'horaInicial', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                               	{name: 'horaFinal', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'tipoAudiencia'},
                                                        {name: 'sala'},
                                                        {name: 'unidadGestion'},
                                                        {name: 'situacion'},
                                                        {name: 'juez'}  ,
                                                        {name: 'horaInicialReal', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                               	{name: 'horaFinalReal', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'urlMultimedia'},
                                                        {name: 'iFormulario' }, 
                                                        {name: 'iRegistro' },
                                                        {name: 'iFormularioSituacion'},                                                     
                                                        {name: 'iRegistroSituacion'} ,
                                                        {name: 'edificio'}
                                                                                                    
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
                                                            sortInfo: {field: 'fechaEvento', direction: 'ASC'},
                                                            groupField: 'fechaEvento',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='37';
                                        
                                    }
                        )   
       
       
       var filters = new Ext.ux.grid.GridFilters	(
                                                        {
                                                            filters:	[
                                                            				{
                                                                            	type:'string',
                                                                                dataIndex:'carpetaAdministrativa'
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'situacion',
                                                                                options:arrSituacionEvento,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'date',
                                                                                dataIndex:'fechaEvento'
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'tipoAudiencia',
                                                                                options:arrAudiencias,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'sala',
                                                                                options:arrSalasBusqueda,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'edificio',
                                                                                options:arrEdificios,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'string',
                                                                                dataIndex:'juez'
                                                                            }
                                                                            
                                                            			]
                                                        }
                                                    );  
       
        var chkRow=new Ext.grid.CheckboxSelectionModel({checkOnly :false,width:40});
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
                                                             
                                                            {
                                                                header:'ID Evento',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'idEvento'
                                                                
                                                            },
                                                            
                                                            
                                                           
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                css:'text-align:center;vertical-align:middle !important;',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var icono='';
                                                                            meta.attr='style="padding: 0px !important;"';
                                                                        	icono=formatearValorRenderer(arrSemaforo,val);    
                                                                            var tamano=formatearValorRenderer(arrSemaforo,val,2);                                                                            
                                                                            return '<img src="'+icono+'" width="'+tamano+'" height="'+tamano+'" title="'+formatearValorRenderer(arrSituacionEvento,val)+'" alt="'+formatearValorRenderer(arrSituacionEvento,val)+'">';
                                                                        	
                                                                        }
                                                            },
                                                             {
                                                                header:'Situaci&oacute;n audiencia',
                                                                width:230,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrSituacionEvento,val));
                                                                        }
                                                            },
                                                            {
                                                                header:'',
                                                                width:60,
                                                                sortable:true,
                                                                hidden:true,
                                                                dataIndex:'situacion',
                                                                css:'text-align:left;vertical-align:middle !important;',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                            var comp2='';
                                                                            
                                                                            
                                                                           	switch(val)
                                                                            {
	                                                                            case '1':
    	                                                                        case '4':
                                                                            	case '5':
                                                                                	if(registro.data.urlCanal!='')
                                                                                		comp2='<a href="javascript:abrirVentanaSala(\''+bE(registro.data.sala)+'\',\''+bE(registro.data.idEvento)+'\')"><img src="../images/film_go.png" title="Visualizar audiencia" alt="Visualizar audiencia" /></a>'
                                                                                break;
                                                                                case '2':
                                                                                	if(registro.data.urlMultimedia!='')
                                                                                		comp2='<a href="javascript:abrirVideoGrabacion(\''+bE(registro.data.idEvento)+'\')"><img src="../images/control_play_blue.png" title="Visualizar grabaci&oacute;n" alt="Visualizar grabaci&oacute;n" /></a>'
                                                                              	break;
                                                                            }
                                                                            
                                                                            var comp='';
                                                                            if(registro.data.iRegistroSituacion!='-1')
                                                                            {
                                                                            	comp='<a href="javascript:abrirFormatoRegistro(\''+bE(registro.data.iFormularioSituacion)+'\',\''+
                                                                                		bE(registro.data.iRegistroSituacion)+'\')"><img src="../images/magnifier.png" title="Ver detalles..."'+
                                                                                        ' alt="Ver detalles..."></a> ';
                                                                            	if(comp2!='')
                                                                                	comp='&nbsp;&nbsp;'+comp;
                                                                            }
                                                                            
                                                                        	return comp2+comp;
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:'C&oacute;digo &Uacute;nico de Proceso',
                                                                width:210,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                            },
                                                            {
                                                                header:'Fecha de<br />la audiencia',
                                                                width:130,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'fechaEvento',
                                                                renderer:function(val)
                                                                	{
                                                                    	return val.format('d/m/Y');
                                                                    }
                                                            },
                                                            {
                                                                header:'Hora programada de audiencia',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'horaInicial',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	var comp='';
                                                                        if(val.format('d')!=registro.data.horaFinal.format('d'))
                                                                        {
                                                                        	comp=' del '+registro.data.horaFinal.format('d/m/Y');
                                                                        }

                                                                    	return 'De las '+val.format('H:i')+' hrs. a las '+registro.data.horaFinal.format('H:i')+' hrs.'+comp
                                                                    }
                                                            },

                                                            
                                                            {
                                                                header:'Hora de realizaci&oacute;n de audiencia',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'horaInicialReal',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if(!val)
                                                                        {
                                                                        	return '(Datos no disponibles)';
                                                                        }
                                                                    	var comp='';
                                                                        if(val.format('d')!=registro.data.horaFinalReal.format('d'))
                                                                        {
                                                                        	comp=' del '+registro.data.horaFinalReal.format('d/m/Y');
                                                                        }

                                                                    	return 'De las '+val.format('H:i')+' hrs. a las '+registro.data.horaFinalReal.format('H:i')+' hrs.'+comp
                                                                    }
                                                            },
                                                            {
                                                                header:'Tipo de audiencia',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'tipoAudiencia',
                                                                renderer:function(val)
                                                                		{
                                                                        
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrAudiencias,val));
                                                                        }
                                                            },
                                                            {
                                                                header:'Sede',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'edificio',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var lblSala=mostrarValorDescripcion(formatearValorRenderer(arrEdificios,val));
                                                                            
                                                                            
                                                                            
                                                                        	return lblSala;
                                                                        }
                                                            },
                                                            {
                                                                header:'Sala',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'sala',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var lblSala=mostrarValorDescripcion(formatearValorRenderer(arrSalas,val));
                                                                            
                                                                            
                                                                            
                                                                        	return lblSala;
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Juez',
                                                                width:320,
                                                                sortable:true,
                                                                dataIndex:'juez'
                                                            },
                                                            {
                                                                header:'Despacho',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'unidadGestion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrUnidades,val));
                                                                        }
                                                            }
                                                           
                                                           
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'dEventos',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                sm:chkRow,
                                                                cls:'gridSiugjPrincipal',
                                                                columnLines : false,      
                                                                plugins:	[filters],
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
                                                                                            
                                                                                            var cmbSala=gEx('cmbSala');
                                                                                            cmbSala.setValue('');
                                                                                            
                                                                                            var cmbTipoAudiencia=gEx('cmbTipoAudiencia');
                                                                                            cmbTipoAudiencia.setValue('');
                                                                                            
                                                                                            var cmbSituacionAudiencia=gEx('cmbSituacionAudiencia');
                                                                                            cmbSituacionAudiencia.setValue('');
   
                                                                                            
                                                                                            gEx('dEventos').getStore().removeAll();
                                                                                        
                                                                                            
                                                                                        }
                                                                                
                                                                            } 
                                                                		],
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;

}