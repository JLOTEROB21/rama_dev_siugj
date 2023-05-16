<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica WHERE cmbCategoria=1 ORDER BY prioridad";
	$arrUnidadesGestion=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT DISTINCT anio,anio FROM 7004_seriesUnidadesGestion ORDER BY anio";
	$arrCiclo=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT Institucion FROM 801_adscripcion WHERE idUsuario=".$_SESSION["idUsr"];
	$adscripcion=$con->obtenerValor($consulta);
	
	$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$adscripcion."'";
	$adscripcion=$con->obtenerValor($consulta);
	
	$arrRoles["'1_0'"]=1;
	$arrRoles["'112_0'"]=1;
	$arrRoles["'90_0'"]=1;
	
	$existePermisoTotal=false;
	foreach($arrRoles as $r=>$resto)
	{
		if(existeRol($r))
		{
			$existePermisoTotal=true;
			break;
		}
	}
	
	
?>
var arrCiclo=<?php echo $arrCiclo?>;   
var arrUnidadesGestion=<?php echo $arrUnidadesGestion?>;   
var adscripcion='<?php echo $adscripcion?>';
Ext.onReady(inicializar);

function inicializar()
{
	var cmbUnidadGestion=crearComboExt('cmbUnidadGestion',arrUnidadesGestion,0,0,450);
    
    <?php if(!$existePermisoTotal)
		{
	?>
    		cmbUnidadGestion.setValue(adscripcion)
    		cmbUnidadGestion.disable();
    <?php
		}
	?>
    
    
    
    var cmbCiclo=crearComboExt('cmbCiclo',arrCiclo,0,0,120);
    cmbCiclo.setValue('<?php echo date("Y")?>');
	var pivotGrid=crearGridAsignacion();	
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Asignaci&oacute;n de audiencias juez</b></span>',                                               
                                                tbar:	[
                                                			{
                                                            	xtype:'label',
                                                                html:'<b>Unidad de Gesti&oacute;n:</b>&nbsp;&nbsp;'
                                                            },
                                                            cmbUnidadGestion,'-',
                                                            {
                                                            	xtype:'label',
                                                                html:'<b>Ciclo:</b>&nbsp;&nbsp;'
                                                            },
                                                            cmbCiclo,'-',
                                                            {
                                                              icon:'../images/right1.png',
                                                              cls:'x-btn-text-icon',
                                                              text:'Consultar',
                                                              handler:function()
                                                                      {
                                                                      		if(gEx('cmbUnidadGestion').getValue()=='')
                                                                            {
                                                                            	function resp()
                                                                                {
                                                                                	gEx('cmbUnidadGestion').focus();
                                                                                }
                                                                                msgBox('Debe indicar la unidad de gesti&oacute;n cuyas asignaciones desea consultar',resp);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(gEx('cmbCiclo').getValue()=='')
                                                                            {
                                                                            	function resp2()
                                                                                {
                                                                                	gEx('cmbCiclo').focus();
                                                                                }
                                                                                msgBox('Debe indicar el ciclo cuyas asignaciones desea consultar',resp2);
                                                                                return;
                                                                            }
                                                                      
                                                                          gEx('gConsulta').getStore().load	(
                                                                          										{
                                                                                                                	url:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                                                                                    params: {
                                                                                                                    			funcion:206,
                                                                                                                                uG:gEx('cmbUnidadGestion').getValue(),
                                                                                                                                ciclo:gEx('cmbCiclo').getValue()
                                                                                                                                
                                                                                                                    		}
                                                                                                                }
                                                                          									)
                                                                      }
                                                              
                                                          }
                                                		],
                                                
                                                items:	[
                                                            pivotGrid
                                                        ]
                                            }
                                         ]
                            }
                        ) 
	                   
}

function crearGridAsignacion()
{



	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idJuez'},
		                                                {name: 'juez'},
                                                        {name: 'total'},
                                                        {name: 'AU_0'},
		                                                {name: 'AU_1'},
                                                        {name: 'AU_2'},
                                                        {name: 'AU_3'},
		                                                {name: 'AU_4'},
                                                        {name: 'AU_5'},
                                                        {name: 'AU_6'},
                                                        {name: 'AU_7'},
                                                        {name: 'AN_0'},
		                                                {name: 'AN_1'},
                                                        {name: 'AN_2'},
                                                        {name: 'AN_3'},
		                                                {name: 'AN_4'},
                                                        {name: 'AN_5'},
                                                        {name: 'AN_6'},
                                                        {name: 'AN_7'},
                                                        {name: 'AI_0'},
		                                                {name: 'AI_1'},
                                                        {name: 'AI_2'},
                                                        {name: 'AI_3'},
		                                                {name: 'AI_4'},
                                                        {name: 'AI_5'},
                                                        {name: 'AI_6'},
                                                        {name: 'AI_7'},
                                                        {name: 'AI_8'},
                                                        {name: 'G_0'},
		                                                {name: 'G_1'},
                                                        {name: 'G_2'},
                                                        {name: 'G_3'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore(	{
                                                reader: lector,
                                                proxy : new Ext.data.HttpProxy	(
                                                									{
	                                                                                	url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'
		                                                                            }
			                                                                     ),
                                                sortInfo: {field: 'juez', direction: 'ASC'},
                                                groupField: 'juez',
                                                remoteGroup:false,
                                                remoteSort: true,
                                                autoLoad:false
                                                
                                            }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='206';
                                        
                                    }
               )  


	var tiposAudiencia=	[
    						{header: '', colspan: 1, align: 'center'},
                            {header: '', colspan: 1, align: 'center'},
    						{header: 'Audiencias Urgentes (AU)', colspan: 8, align: 'center'},
                            {header: 'Audiencias NO urgentes (AN)', colspan: 8, align: 'center'},
                            {header: 'Audiencias Intermedias (AI)', colspan: 9, align: 'center'},
                            {header: 'Guardias (G)', colspan: 3, align: 'center'},
                            
                            

    					]
	/*var situacionAudiencia=	[
    							{header: '', colspan: 1, align: 'center'},
    							{header: 'Asignadas', colspan: 1, align: 'center'},
                                {header: 'Canceladas', colspan: 1, align: 'center'},
                                {header: 'Modificadas', colspan: 1, align: 'center'},
                                {header: 'Asignadas', colspan: 1, align: 'center'},
                                {header: 'Canceladas', colspan: 1, align: 'center'},
                                {header: 'Modificadas', colspan: 1, align: 'center'},
                                {header: 'Asignadas', colspan: 1, align: 'center'},
                                {header: 'Canceladas', colspan: 1, align: 'center'},
                                {header: 'Modificadas', colspan: 1, align: 'center'},
                                {header: 'Asignadas', colspan: 1, align: 'center'},
                                {header: 'Canceladas', colspan: 1, align: 'center'},
                                {header: 'Modificadas', colspan: 1, align: 'center'},
                                {header: 'Asignadas', colspan: 1, align: 'center'},
                                {header: 'Canceladas', colspan: 1, align: 'center'},
                                {header: 'Modificadas', colspan: 1, align: 'center'},
                                {header: 'Asignadas', colspan: 1, align: 'center'},
                                {header: 'Canceladas', colspan: 1, align: 'center'},
                                {header: 'Modificadas', colspan: 1, align: 'center'},
                                {header: 'Asignadas', colspan: 1, align: 'center'},
                                {header: 'Canceladas', colspan: 1, align: 'center'},
                                {header: 'Modificadas', colspan: 1, align: 'center'},
                                {header: 'Asignadas', colspan: 1, align: 'center'},
                                {header: 'Canceladas', colspan: 1, align: 'center'},
                                {header: 'Modificadas', colspan: 1, align: 'center'}
    						]
*/
	var group = new Ext.ux.grid.ColumnHeaderGroup	(
    													{
                                                            rows: [tiposAudiencia]
                                                        }
                                                    );

	var pivotGrid = new Ext.grid.GridPanel	(
                                                    {
                                                        id:'gConsulta',
                                                        region  : 'center',
                                                        store     : alDatos,
                                                        columnLines: true,
                                                        columns:	[
                                                        				{header: 'Jueces',  align: 'left',dataIndex:'juez', width:350,renderer:mostrarValorDescripcion},
                                                                        {header: 'Total',  align: 'center',dataIndex:'total',width:85},
                                                                        {header: 'Asignadas',  align: 'center',dataIndex:'AU_0',width:90},
                                                                        {header: 'Asignaciones<br>Directas',  align: 'center',dataIndex:'AU_1',width:90},
                                                                        {header: 'Canceladas',  align: 'center',dataIndex:'AU_2',width:90},
                                                                        {header: 'Modificadas',  align: 'center',dataIndex:'AU_3',width:90},
                                                                        {header: 'No asignadas<br>(Juez de tr&aacute;mite)',  align: 'center',dataIndex:'AU_4',width:100},
                                                                        {header: 'No asignadas<br>(Incidencia)',  align: 'center',dataIndex:'AU_5',width:90},
                                                                        {header: 'Por asignar<br>(Deuda)',  align: 'center',dataIndex:'AU_6',width:90},
                                                                        {header: 'Programadas<br>Previamente',  align: 'center',dataIndex:'AU_7',width:90},
                                                                        
                                                                        {header: 'Asignadas',  align: 'center',dataIndex:'AN_0',width:90},
                                                                        {header: 'Asignaciones<br>Directas',  align: 'center',dataIndex:'AN_1',width:90},
                                                                        {header: 'Canceladas',  align: 'center',dataIndex:'AN_2',width:90},
                                                                        {header: 'Modificadas',  align: 'center',dataIndex:'AN_3',width:90},
                                                                        {header: 'No asignadas<br>(Juez de tr&aacute;mite)',  align: 'center',dataIndex:'AN_4',width:100},
                                                                        {header: 'No asignadas<br>(Incidencia)',  align: 'center',dataIndex:'AN_5',width:90},
                                                                        {header: 'Por asignar<br>(Deuda)',  align: 'center',dataIndex:'AN_6',width:90},
                                                                        {header: 'Programadas<br>Previamente',  align: 'center',dataIndex:'AN_7',width:90},
                                                                        
                                                                        {header: 'Asignadas',  align: 'center',dataIndex:'AI_0',width:90},
                                                                        {header: 'Asignaciones<br>Directas',  align: 'center',dataIndex:'AI_1',width:90},
                                                                        {header: 'Canceladas',  align: 'center',dataIndex:'AI_2',width:90},
                                                                        {header: 'Modificadas',  align: 'center',dataIndex:'AI_3',width:90},
                                                                        {header: 'No asignadas<br>(Juez de tr&aacute;mite)',  align: 'center',dataIndex:'AI_4',width:100 },                                                                       {header: 'Por asignar<br>(Deuda)',  align: 'center',dataIndex:'AI_6',width:75},
                                                                        {header: 'No asignadas<br>(Incidencia)',  align: 'center',dataIndex:'AN_5',width:90},
                                                                        {header: 'Por asignar<br>(Deuda)',  align: 'center',dataIndex:'AN_6',width:90},
                                                                        {header: 'Programadas<br>Previamente',  align: 'center',dataIndex:'AI_7',width:90},
                                                                        {header: 'Continuaciones<br>de audiencia',  align: 'center',dataIndex:'AI_8',width:90},
                                                                        
                                                                        {header: 'Asignadas',  align: 'center',dataIndex:'G_0',width:90},
                                                                        {header: 'Asignaciones<br>Directas',  align: 'center',dataIndex:'G_1',width:90},
                                                                        {header: 'Canceladas',  align: 'center',dataIndex:'G_2',width:90},
                                                                        {header: 'Modificadas',  align: 'center',dataIndex:'G_3',width:90}
                                                                        
                                                        			],
                                                        viewConfig: {
                                                                        forceFit: false
                                                                    },
                                                        plugins: group
                                                    }
                                               )

	
	
	return pivotGrid;                                               
}