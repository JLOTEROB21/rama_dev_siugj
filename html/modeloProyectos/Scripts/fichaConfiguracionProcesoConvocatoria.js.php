<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$consulta="SELECT idTipoProceso,tipoProceso FROM 921_tiposProceso WHERE idTipoProceso NOT IN (1,15) order by tipoProceso";
	$arrTipoProceso=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT idProceso,nombre FROM 4001_procesos WHERE idTipoProceso=15";
	$arrProcesosRegistro=$con->obtenerFilasArreglo($consulta);
	$idFormulario=bD($_GET["idFormulario"]);
	$idReferencia=bD($_GET["idReferencia"]);
	$consulta="select idProcesoVinculado,p.idTipoProceso,p.idProceso,p.nombre from 9043_procesosVinculadosConvocatoria c,4001_procesos p where p.idProceso=c.idProceso and idFormulario=".$idFormulario." and idReferencia=".$idReferencia;
	$arrProcesos=$con->obtenerFilasArreglo($consulta);
?>

var arrTipoProceso=<?php echo $arrTipoProceso?>;
var arrProcesosRegistro=<?php echo $arrProcesosRegistro?>;

Ext.onReady(inicializar);

function inicializar()
{
	var gridProcesos=crearGridProcesos();
    //var gridProcesosRegistro=crearGridProcesosRegistro();
    
}


var regProcesoRegistro=crearRegistro([
										{name: 'idRegProceso'},
                                        {name: 'tipoProceso'},
                                        {name: 'proceso'},
                                        {name: 'nProceso'}
                                     ]);


function crearGridProcesos()
{
	var cmbTipoProceso=crearComboExt('cmbTipoProceso',arrTipoProceso);
    var cmbProcesos=crearComboExt('cmbProcesos',[]);
	var dsDatos=<?php echo $arrProcesos?>;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idRegProceso'},
                                                                    {name: 'tipoProceso'},
                                                                    {name: 'proceso'},
                                                                    {name: 'nProceso'}
                                                                ]
                                                    }
                                                );
    
        alDatos.loadData(dsDatos);
        var chkRow=new Ext.grid.CheckboxSelectionModel();
       
        
        
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            chkRow,
                                                            {
                                                                header:'Tipo de proceso',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'tipoProceso',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoProceso,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Proceso',
                                                                width:500,
                                                                sortable:true,
                                                                dataIndex:'proceso',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return registro.get('nProceso');
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'editorGridProcesos',
                                                                store:alDatos,
                                                                frame:true,
                                                                renderTo:'gridProcesos',
                                                                cm: cModelo,
                                                                height:260,
                                                                width:800
                                                            }
                                                        );
	    tblGrid.nuevoRegistro=false;   
        return 	tblGrid;
}



var regProcesoRegistro=crearRegistro([
										{name: 'idRegProceso'},
                                        {name: 'proceso'}
                                     ]);

function crearGridProcesosRegistro()
{
	var cmbProcesosRegistro=crearComboExt('cmbProcesosRegistro',arrProcesosRegistro);
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idRegProceso'},
                                                                    {name: 'proceso'}
                                                                ]
                                                    }
                                                );
    
        alDatos.loadData(dsDatos);
        var chkRow=new Ext.grid.CheckboxSelectionModel();
        
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            chkRow,
                                                            
                                                            {
                                                                header:'Proceso',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'proceso',
                                                                editor:cmbProcesosRegistro,
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrProcesosRegistro,val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'editorGridProcesosRegistro',
                                                                store:alDatos,
                                                                frame:true,
                                                                renderTo:'gridProcesosRegistro',
                                                                cm: cModelo,
                                                                height:260,
                                                                width:450,
                                                                sm:chkRow,
                                                                tbar:	[
                                                                			{
                                                                            	icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                handler:function()
                                                                                		{
                                                                                        	var r=new regProcesoRegistro({idRegProceso:'-1',proceso:''});
                                                                                            tblGrid.getStore().add(r);
                                                                                        },
                                                                                text:'Agregar proceso'
                                                                                        
                                                                            },
                                                                            {
                                                                            	icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                handler:function()
                                                                                		{
                                                                                        	var fila=tblGrid.getSelectionModel().getSelections();
                                                                                            if(fila.length==0)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar al menos un proceso a remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	tblGrid.getStore().remove(fila);
                                                                                                }
                                                                                                
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover los procesos seleccionados?',resp);
                                                                                            
                                                                                        },
                                                                                text:'Remover proceso'
                                                                                        
                                                                            }
                                                                		]
                                                            }
                                                        );
        return 	tblGrid;
}

