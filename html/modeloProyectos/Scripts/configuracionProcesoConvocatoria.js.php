<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$idFormulario=bD($_GET["idFormulario"]);
	$idReferencia=bD($_GET["idReferencia"]);
	$consulta="select idProcesoVinculado,p.idTipoProceso,p.idProceso,p.nombre from 9043_procesosVinculadosConvocatoria c,4001_procesos p where p.idProceso=c.idProceso and idFormulario=".$idFormulario." and idReferencia=".$idReferencia;
	$arrProcesos=$con->obtenerFilasArreglo($consulta);
	
	$idProceso=obtenerIdProcesoFormulario($idFormulario);
	
	$consulta="SELECT configuracion FROM 203_configuracionModuloDTD WHERE idModulo=12 AND idProceso=".$idProceso;
	$cadConf=$con->obtenerValor($consulta);
	$listTiposPermitidos="";
	if($cadConf=="")
	{
		$consulta="select idTipoProceso FROM 921_tiposProceso WHERE idTipoProceso  not in (1,15)";

		$listTiposPermitidos=$con->obtenerListaValores($consulta);
	}
	else
	{
		$objConf=json_decode($cadConf);
		$listTiposPermitidos=$objConf->listTiposProceso;
	}
	
	
	$consulta="SELECT idTipoProceso,tipoProceso FROM 921_tiposProceso WHERE idTipoProceso IN (".$listTiposPermitidos.") order by tipoProceso";
	$arrTipoProceso=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT idProceso,nombre FROM 4001_procesos WHERE idTipoProceso=15";
	$arrProcesosRegistro=$con->obtenerFilasArreglo($consulta);
	
	
?>

var arrTipoProceso=<?php echo $arrTipoProceso?>;
var arrProcesosRegistro=<?php echo $arrProcesosRegistro?>;

Ext.onReady(inicializar);

function inicializar()
{
	var gridProcesos=crearGridProcesos();
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
    cmbTipoProceso.on('select',funcComboTipoPrcesoChange);
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
        var editorFila=new Ext.ux.grid.RowEditor	(
                                                        {
                                                            id:'editor_GridProcesos',
                                                            saveText: 'Guardar',
                                                            cancelText:'Cancelar',
                                                            clicksToEdit:2
                                                        }
                                                    );
    	editorFila.on('beforeedit',funcEditorFilaBeforeEditGridProcesos)
    	editorFila.on('validateedit',funcEditorValidaCampoGridProcesos);
    	editorFila.on('canceledit',funcEditorCancelEditCampoGridProcesos);  
        
        
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            chkRow,
                                                            {
                                                                header:'Tipo de proceso',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'tipoProceso',
                                                                editor:cmbTipoProceso,
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
                                                                editor:cmbProcesos,
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
                                                                width:800,
                                                                sm:chkRow,
                                                                plugins:[editorFila],
                                                                tbar:	[
                                                                			{
                                                                            	id:'btnAddEditorGridProcesos',
                                                                            	icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar proceso',
                                                                                handler:function()
                                                                                		{
                                                                                        	var r=new regProcesoRegistro({idRegProceso:'-1',tipoProceso:'',proceso:'',nProceso:''});
                                                                                            editorFila.stopEditing();
                                                                                            tblGrid.getStore().add(r);
                                                                                            tblGrid.nuevoRegistro=true;
                                                                                            editorFila.startEditing(tblGrid.getStore().getCount()-1);	
                                                                                        }
                                                                               
                                                                                        
                                                                            },
                                                                            {
                                                                            	id:'btnDelEditorGridProcesos',
                                                                            	icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover proceso',
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
                                                                                                	var idRegProceso=obtenerListadoArregloFilas(fila,'idRegProceso');
                                                                                                	function funcAjax()
                                                                                                    {
                                                                                                        var resp=peticion_http.responseText;
                                                                                                        arrResp=resp.split('|');
                                                                                                        if(arrResp[0]=='1')
                                                                                                        {
                                                                                                        	tblGrid.getStore().remove(fila);
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=221&idRegProceso='+idRegProceso,true);

	
                                                                                                	
                                                                                                }
                                                                                               
                                                                                            }
                                                                                             msgConfirm('Est&aacute; seguro de querer remover los procesos seleccionados?',resp);
                                                                                            
                                                                                        }
                                                                               
                                                                                        
                                                                            }
                                                                		]
                                                            }
                                                        );
	    tblGrid.nuevoRegistro=false;   
        tblGrid.on('beforeedit',funcTipoProcesoSelect);                                       
        return 	tblGrid;
}

function funcEditorFilaBeforeEditGridProcesos()
{

}

function funcEditorValidaCampoGridProcesos(rowEditor,obj,registro)
{
	var cmbTipoProceso=gEx('cmbTipoProceso');
    var cmbProceso=gEx('cmbProcesos');
    var idFormulario=gE('idFormulario').value;
    var idReferencia=gE('idRegistro').value;
    if(cmbTipoProceso.getValue()=='')
    {
    	function funcRespTipo()
        {
        	cmbTipoProceso.focus();
        }
    	msgBox('Debe indicar el tipo de proceso con el cual se vincular&aacute; la convocatoria',funcRespTipo);
        return false;
    }
    
    if(cmbProceso.getValue()=='')
    {
    	function funcRespProc()
        {
        	cmbProceso.focus();
        }
    	msgBox('Debe indicar el proceso con el cual se vincular&aacute; la convocatoria',funcRespProc);
        return false;
    }
    
    var cadObj='{"idRegProceso":"'+registro.get('idRegProceso')+'","idFormulario":"'+idFormulario+'","idReferencia":"'+idReferencia+'","idProceso":"'+cmbProceso.getValue()+'"}';
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            gEx('editorGridProcesos').getStore().loadData(arrDatos);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            Ext.getCmp('btnAddEditorGridProcesos').enable();
            Ext.getCmp('btnDelEditorGridProcesos').enable();
            var grid=gEx('editorGridProcesos').getStore().rejectChanges();
            grid.nuevoRegistro=false;
            return false;
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=220&cadObj='+cadObj,true);
    return true;
    
    
}

function funcEditorCancelEditCampoGridProcesos()
{
	var grid=Ext.getCmp('editorGridProcesos');
	if(grid.nuevoRegistro)
		grid.getStore().removeAt(grid.getStore().getCount()-1);
	
	Ext.getCmp('btnAddEditorGridProcesos').enable();
    Ext.getCmp('btnDelEditorGridProcesos').enable();
	grid.nuevoRegistro=false;
}

function funcTipoProcesoSelect(e)
{
	if(e.record.get('tipoProceso')=='')
    {
    	e.cancel=true;
        return;
    }
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            var cmbProcesos=gEx('cmbProcesos');
            cmbProcesos.reset();
            cmbProcesos.getStore().loadData(arrDatos);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=219&idTipoProceso='+e.record.get('tipoProceso'),true);	

}

function funcComboTipoPrcesoChange(combo,registro)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            var cmbProcesos=gEx('cmbProcesos');
            cmbProcesos.reset();
            cmbProcesos.getStore().loadData(arrDatos);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=219&idTipoProceso='+registro.get('id'),true);	
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

function registroEnLinea(combo)
{
	var idFormulario=gE('idFormulario').value;
    var idReferencia=gE('idRegistro').value;
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
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=222&idFormulario='+idFormulario+'&idReferencia='+idReferencia+'&valor='+combo.options[combo.selectedIndex].value,true);
}