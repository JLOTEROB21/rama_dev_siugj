<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$idCiclo=bD($_GET["iC"]);
	$consulta="select idFechaNomina,noQuincena,fechaPago,fechaLimiteOperacion,fechaLimiteAprobacion,fechaInicioIncidencia,fechaFinIncidencia,situacion,mes 
				from 656_calendarioNomina cn  where  cn.ciclo=".$idCiclo;
	$arrFechas=uEJ($con->obtenerFilasArreglo($consulta));	
	$consulta="select idEstado,estado from 657_estadosNomina order by estado";
	$arrEstados=uEJ($con->obtenerFilasArreglo($consulta));			
?>
var arrEstados=<?php echo $arrEstados?>;

Ext.onReady(inicializar);

function inicializar()
{
	var dsDatos=<?php echo $arrFechas?>;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                        			{name: 'idFechaNomina'},
                                                                    {name: 'noQuincena'},
                                                                    {name: 'fechaPago'},
                                                                    {name: 'fechaLimiteOperacion'},
                                                                    {name: 'fechaLimiteAprobacion'},
                                                                    {name: 'fechaInicioIncidencia'},
                                                                    {name: 'fechaFinIncidencia'},
                                                                    {name: 'situacion'},
                                                                    {name: 'mes'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
														{
															header:'No. Quincena',
															width:80,
															sortable:true,
															dataIndex:'noQuincena'
														},
                                                        {
															header:'Mes',
															width:90,
															sortable:true,
															dataIndex:'mes',
                                                            renderer:function(val)
                                                            {
                                                            	switch(parseInt(val))
                                                                {
                                                                	case 1:
                                                                    	return 'Enero';
                                                                    break;
                                                                    case 2:	
                                                                    	return 'Febrero';
                                                                    break;
                                                                    case 3:
                                                                    	return 'Marzo';
                                                                    break;
                                                                    case 4:
                                                                    	return 'Abril';
                                                                    break;
                                                                    case 5:
                                                                    	return 'Mayo';
                                                                    break;
                                                                    case 6:
                                                                    	return 'Junio';
                                                                    break;
                                                                    case 7:
                                                                    	return 'Julio';
                                                                    break;
                                                                    case 8:
                                                                    	return 'Agosto';
                                                                    break;
                                                                    case 9:
                                                                    	return 'Septiembre';
                                                                    break;
                                                                    case 10:
                                                                    	return 'Octubre';
                                                                    break;
                                                                    case 11:
                                                                    	return 'Noviembre';
                                                                    break;
                                                                    case 12:
                                                                    	return 'Diciembre';
                                                                    break;
                                                                }
                                                            }
                                                            
														},
														
														{
															header:'Fecha l&iacute;mite operaci&oacute;n',
															width:125,
															sortable:true,
															dataIndex:'fechaLimiteOperacion',
                                                            editor:new Ext.form.DateField({format:'d/m/Y',value:'01/01/<?php echo $idCiclo?>'}),
                                                            renderer: function(val)
                                                            			{
                                                                        	if(val!='')
	                                                                        	return cambiaraFormatoMysqlToEstandar(val);
                                                                            else
                                                                            	return val;
                                                                        }
														},
                                                        {
															header:'Fecha l&iacute;mite aprobaci&oacute;n',
															width:125,
															sortable:true,
															dataIndex:'fechaLimiteAprobacion',
                                                            editor:new Ext.form.DateField({format:'d/m/Y',value:'01/01/<?php echo $idCiclo?>'}),
                                                            renderer: function(val)
                                                            			{
                                                                        	if(val!='')
	                                                                        	return cambiaraFormatoMysqlToEstandar(val);
                                                                            else
                                                                            	return val;
                                                                        }
														},
                                                        {
															header:'Considerar incidencias del',
															width:140,
															sortable:true,
															dataIndex:'fechaInicioIncidencia',
                                                            editor:new Ext.form.DateField({format:'d/m/Y',value:'01/01/<?php echo $idCiclo?>'}),
                                                            renderer: function(val)
                                                            			{
                                                                        	if(val!='')
	                                                                        	return cambiaraFormatoMysqlToEstandar(val);
                                                                            else
                                                                            	return val;
                                                                        }
														},
                                                         {
															header:'Al',
															width:100,
															sortable:true,
															dataIndex:'fechaFinIncidencia',
                                                            editor:new Ext.form.DateField({format:'d/m/Y',value:'01/01/<?php echo $idCiclo?>'}),
                                                            renderer: function(val)
                                                            			{
                                                                        	if(val!='')
	                                                                        	return cambiaraFormatoMysqlToEstandar(val);
                                                                            else
                                                                            	return val;
                                                                        }
														},
                                                        {
															header:'Fecha pago',
															width:80,
															sortable:true,
															dataIndex:'fechaPago',
                                                            editor:new Ext.form.DateField({format:'d/m/Y',value:'01/01/<?php echo $idCiclo?>'}),
                                                            renderer: function(val)
                                                            			{
                                                                        	
                                                                        	if(val!='')
	                                                                        	return cambiaraFormatoMysqlToEstandar(val);
                                                                            else
                                                                            	return val;
                                                                        }
														},
                                                         {
															header:'Situaci&oacute;n',
															width:100,
															sortable:true,
															dataIndex:'situacion',
                                                            renderer:function(val)
                                                            		{
                                                                    	var pos=existeValorMatriz(arrEstados,val,0);
                                                                        return arrEstados[pos][1];
                                                                    }
														}
                                                        
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            cm: cModelo,
                                                            height:600,
                                                            width:900,
                                                            renderTo:'gridFechas',
                                                            tbar:	[
                                                            			{
                                                                        	id:'btnGenerarNomina',
                                                                        	icon:'../images/page_white_edit.png',
                                                                        	text:'Generar n&oacute;mina',
                                                                            cls:'x-btn-text-icon',
                                                                            disabled:true,
                                                                            handler:function()
                                                                                    {
                                                                                    	var celdaSel=tblGrid.getSelectionModel().getSelectedCell();
                                                                                        var fila=tblGrid.getStore().getAt(celdaSel[0]);
                                                                                    	var arrParam=[['quincena',fila.get('noQuincena')],['ciclo',<?php echo $idCiclo?>],['codUnidad','0001']];
                                                                                        enviarFormularioDatos('../nomina/generarNomina.php',arrParam);
                                                                                    }	
                                                                        },
                                                                        {
                                                                        	id:'btnVerNomina',
                                                                        	icon:'../images/magnifier.png',
                                                                        	text:'Ver n&oacute;mina',
                                                                            cls:'x-btn-text-icon',
                                                                            disabled:true,
                                                                            handler:function()
                                                                                    {
                                                                                    	var celdaSel=tblGrid.getSelectionModel().getSelectedCell();
                                                                                        var fila=tblGrid.getStore().getAt(celdaSel[0]);
                                                                                    	var arrParam=[['quincena',fila.get('noQuincena')],['ciclo',<?php echo $idCiclo?>],['codUnidad','0001']];
                                                                                        enviarFormularioDatos('../nomina/generarNomina.php',arrParam);
                                                                                    }	
                                                                        }
                                                            		]
                                                        }
                                                    );
	tblGrid.on('afteredit',funcGridFechasChange); 
    tblGrid.on('beforeedit',funcGridFechasChangeBefore);        
    tblGrid.on('rowclick',function(grid,fila,o)		
    											{
                                                	var registro=grid.getStore().getAt(fila);
                                                   	var pGeneracion=false;
                                                    if((registro.get('situacion')=='1')&&(registro.get('fechaLimiteOperacion')!='')&&(registro.get('fechaLimiteAprobacion')!='')&&(registro.get('fechaPago')!='')&&(registro.get('fechaInicioIncidencia')!='')&&(registro.get('fechaFinIncidencia')!=''))
                                                    	pGeneracion=true;
                                                   
                                                	if(pGeneracion)
                                                    {
	                                                	gEx('btnGenerarNomina').enable();
                                                    }
                                                    else
                                                    {
                                                    	gEx('btnGenerarNomina').disable();
                                                    }
                                                    if(registro.get('situacion')=='2')
                                                    	gEx('btnVerNomina').enable();
                                                    else
                                                    	gEx('btnVerNomina').disable();
                                                }	
    							);
}

function funcGridFechasChange(o)
{
	var valor;
    if((o.column>=2)&&(o.column<=6))
    	valor=o.value.format('Y-m-d');
    else
    	valor=o.value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=151&valor='+valor+'&columna='+o.column+'&idFechaNom='+o.record.get('idFechaNomina') ,true);

} 

function funcGridFechasChangeBefore(o)
{
	if(o.record.get('situacion')!='1')
    	o.cancel=true;
        
	/*switch(o.column)
    {
    	case '2':
        
        break;
        case '3':
        
        break;
        case '4':
        
        break;
        case '5':
        
        break;
        case '6':
        
        break;
    }*/
}