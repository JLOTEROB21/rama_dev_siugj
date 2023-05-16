<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT id__2_tablaDinamica,nombre FROM _2_tablaDinamica  ORDER BY nombre";
	$arrReclusorios=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__35_denominacionDelito,denominacionDelito FROM _35_denominacionDelito";
	$arrDelitos=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__380_tablaDinamica,descripcion FROM _380_tablaDinamica";
	$arrBeneficios=$con->obtenerFilasArreglo($consulta);
?>
var arrBeneficios=<?php echo $arrBeneficios?>;
var diasMes=30;
var capturado=false;
var arrReclusorios=<?php echo $arrReclusorios?>;
var arrDelitos=<?php echo $arrDelitos?>;
var arrAniosComputo=[];
var arrMesesComputo=[];
var arrDiasComputo=[];

Ext.onReady(inicializar);

function inicializar()
{
	arrReclusorios.splice(0,0,['0','Prisi\xF3n domiciliaria']);
    var x;
    for(x=0;x<=100;x++)
    {
    	arrAniosComputo.push([x,x]);
    }
	var cmbAnios=crearComboExt('cmbAnios',arrAniosComputo,10,20,110);
    cmbAnios.setValue(0);
    
    for(x=0;x<=11;x++)
    {
    	arrMesesComputo.push([x,x]);
    }
    
    var cmbMeses=crearComboExt('cmbMeses',arrMesesComputo,130,20,110);
    cmbMeses.setValue(0);
    for(x=0;x<=364;x++)
    {
    	arrDiasComputo.push([x,x]);
    }
    
    var cmbDias=crearComboExt('cmbDias',arrDiasComputo,250,20,80);
    cmbDias.setValue(0);
    
    var arrMesesRevision=[];
    for(x=0;x<=11;x++)
    {
    	arrMesesRevision.push([x,x]);
    }
    
    var cmbCentroReclusion=crearComboExt('cmbCentroReclusion',arrReclusorios,190,55,350);
    var cmbPeriodoRevision=crearComboExt('cmbPeriodoRevision',arrMesesRevision,190,85,80);
    cmbPeriodoRevision.setValue('1');
    
	new Ext.Panel	(
    					{
                        	width:960,
                            height:1400,
                            layout:'absolute',
                            renderTo:'tblPanel',
                            border:false,
                            items:	[
                            			{
                                        	x:10,
                                            y:30,
                                            xtype:'label',
                                            html:'<b>Imputado:</b>'
                                        },
                                        {
                                        	x:100,
                                            y:30,
                                            xtype:'label',
                                            html:'<span id="lblImputado">'+bD(gE('nImputado').value)+'</span>'
                                        },
                                        {
                                        	xtype:'fieldset',
                                            title:'C&oacute;mputo de prisi&oacute;n preventiva',
                                            x:10,
                                            y:60,
                                            layout:'absolute',
                                            width:850,
                                            height:290,
                                            items:	[
                                            			
                                            			crearGridComputoPrisionPreventiva(),
                                                        {
                                                        	x:10,
                                                            y:230,
                                                            xtype:'label',
                                                            html:'<b>Total c&oacute;mputo de prisi&oacute;n preventiva:</b>'
                                                        },
                                                         {
                                                        	x:290,
                                                            y:230,
                                                            xtype:'label',
                                                            html:'<span id="lblTotalComputo"></span>'
                                                        }
                                            			
                                            		]
                                        },                                        
                                        {
                                        	xtype:'fieldset',
                                            title:'Sentencia',
                                            x:10,
                                            y:350,
                                            layout:'absolute',
                                            width:850,
                                            height:320,
                                            items:	[
                                            			
                                            			crearGridComputoSentencia(),
                                                        {
                                                        	x:10,
                                                            y:230,
                                                            xtype:'label',
                                                            html:'<b>Total c&oacute;mputo de sentencia:</b>'
                                                        },
                                                         {
                                                        	x:230,
                                                            y:230,
                                                            xtype:'label',
                                                            html:'<span id="lblTotalComputoSentencia"></span>'
                                                        },
                                                        {
                                                        	x:430,
                                                            y:230,
                                                            xtype:'label',
                                                            html:'<b>Fecha de ejecutoria:</b>'
                                                        },
                                                        {
                                                        	x:590,
                                                            y:225,
                                                            disabled:(gE('sL').value=='1'),
                                                            id:'dteFechaEjecutoria',
                                                        	xtype:'datefield',
                                                            value:'<?php echo date("Y-m-d")?>',
                                                            listeners:	{
                                                            				select:function()
                                                                            		{
                                                                                    	gE('lblFechaEjecutoria').innerHTML=convertirLeyendaFecha(gEx('dteFechaEjecutoria').getValue().format('Y-m-d'));
                                                                                        
                                                                                    }
                                                            			}
                                                        },
                                                        {
                                                        	x:590,
                                                            y:255,
                                                            xtype:'label',
                                                            html:'(<span id="lblFechaEjecutoria"></span>)'
                                                        }
                                            			
                                            		]
                                        },
                                        {
                                        	xtype:'fieldset',
                                            title:'Pena a compurgar',
                                            x:10,
                                            y:670,
                                            layout:'absolute',
                                            width:850,
                                            height:180,
                                            items:	[
                                            			{
                                                        	x:10,
                                                            y:0,
                                                            xtype: 'label',
                                                            html:'A&ntilde;os'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:20,
                                                            id:'txtAnios',
                                                            width:110,
                                                            readOnly:true,
                                                            xtype:'textfield'
                                                        },
                                                        
                                                        {
                                                        	x:130,
                                                            y:0,
                                                            xtype: 'label',
                                                            html:'Meses'
                                                        },
                                                        {
                                                        	x:130,
                                                            y:20,
                                                            width:110,
                                                            id:'txtMeses',
                                                            readOnly:true,
                                                            xtype:'textfield'
                                                        },
                                                        {
                                                        	x:250,
                                                            y:0,
                                                            xtype: 'label',
                                                            html:'D&iacute;as'
                                                        },
                                                        {
                                                        	x:250,
                                                            y:20,
                                                            width:110,
                                                            id:'txtDias',
                                                            readOnly:true,
                                                            xtype:'textfield'
                                                        },
                                                        {
                                                        	x:380,
                                                            y:25,
                                                            xtype:'label',
                                                            html:'<b>Fecha de compurgaci&oacute;n:</b>'
                                                        },
                                                        {
                                                        	x:570,
                                                            y:25,
                                                            xtype:'label',
                                                            html:'<span id="dteFechaTermino"></span>'
                                                        },
                                                        {
                                                        	x:570,
                                                            y:55,
                                                            xtype:'label',
                                                            html:'<span id="lblFechaTermino"></span>'
                                                        },
                                                        {
                                                        
                                                        	x:680,
                                                            y:18,
                                                            icon:'../images/calculator.png',
                                                            width:100,
                                                            height:25,
                                                            xtype:'button',
                                                            //hidden:(gE('sL').value=='1'),
                                                            cls:'x-btn-text-icon',
                                                            text:'Calcular',
                                                            handler:function()
                                                                    {
                                                                        calcularFechaTerminoPena();
                                                                        
                                                                    }
                                                            
                                                        },
                                                        {
                                                        	x:10,
                                                            y:60,
                                                            xtype: 'label',
                                                            html:'<b>Centro de reclusi&oacute;n:</b>'
                                                        },
                                                        cmbCentroReclusion,
                                                         {
                                                        	x:10,
                                                            y:90,
                                                            xtype: 'label',
                                                            html:'<b>Periodos de revisi&oacute;n:</b>'
                                                        },
                                                        cmbPeriodoRevision,
                                                        {
                                                        	x:300,
                                                            y:90,
                                                            xtype: 'label',
                                                            html:'<b>Meses</b>'
                                                        },
                                                        {
                                                        
                                                        	x:10,
                                                            y:117,
                                                            id:'btnSave',
                                                            icon:'../images/guardar.PNG',
                                                            width:100,
                                                            height:25,
                                                            //hidden:(gE('sL').value=='1'),
                                                            xtype:'button',
                                                            cls:'x-btn-text-icon',
                                                            //disabled:true,
                                                            text:'Guardar sentencia',
                                                            handler:function()
                                                                    {
                                                                        guardarSentenciaPrision();
                                                                    }
                                                            
                                                        }
                                            		]
                                        },
                                        {
                                        	x:10,
                                            y:860,
                                            width:850,
                                            height:300,
                                            activeTab:0,
                                            xtype:'tabpanel',
                                            items:[crearGridBeneficiosPenitenciarios()]
                                        }
                            		]
                        }
    				)

	
    
    if(gE('objRegistro').value!='')
    {
    	var obj=eval('['+bD(gE('objRegistro').value)+']')[0];

        gEx('gridComputo').getStore().loadData(obj.arrComputoPrision);
        gEx('dteFechaEjecutoria').setValue(obj.fechaEjecutoria);
        gEx('txtAnios').setValue(obj.aniosCompurga);
        gEx('txtMeses').setValue(obj.mesesCompurga);
        gEx('txtDias').setValue(obj.diasCompurga);
        gE('dteFechaTermino').innerHTML=Date.parseDate(obj.fechaCompurga,'Y-m-d').format('d/m/Y');
        gE('lblFechaTermino').innerHTML='('+convertirLeyendaFecha(obj.fechaCompurga)+')';
    }
    calcularTotalComputoPrisionPreventiva();
    gE('lblFechaEjecutoria').innerHTML=convertirLeyendaFecha(gEx('dteFechaEjecutoria').getValue().format('Y-m-d'));
}

function crearGridComputoPrisionPreventiva()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idComputo'},
                                                                    {name: 'anos'},
                                                                    {name: 'meses'},
                                                                    {name: 'dias'},
                                                                    {name: 'reclusorio'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
    var cmbAniosGrid=crearComboExt('cmbAniosGrid',arrAniosComputo,0,0);
    var cmbMesesGrid=crearComboExt('cmbMesesGrid',arrMesesComputo,0,0);
    var cmbDiasGrid=crearComboExt('cmbDiasGrid',arrDiasComputo,0,0);
    var cmbReclusorios=crearComboExt('cmbReclusorios',arrReclusorios,0,0);
    
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'A&ntilde;os',
															width:100,
															sortable:true,
                                                            editor:cmbAniosGrid,
															dataIndex:'anos'
														},
														{
															header:'Meses',
															width:100,
															sortable:true,
                                                            editor:cmbMesesGrid,
															dataIndex:'meses'
														},
                                                        {
															header:'D&iacute;as',
															width:100,
															sortable:true,
                                                            editor:cmbDiasGrid,
															dataIndex:'dias'
														},
                                                        {
															header:'Centro de detenci&oacute;n',
															width:400,
															sortable:true,
                                                            editor:cmbReclusorios,
															dataIndex:'reclusorio',
                                                            renderer:function(val)
                                                            			{
                                                                        	return formatearValorRenderer(arrReclusorios,val);
                                                                        }
														}
													]
												);
    
     var editorFila=new Ext.ux.grid.RowEditor	(
                                                        {
                                                            id:'editorFila',
                                                            saveText: 'Guardar',
                                                            cancelText:'Cancelar',
                                                            clicksToEdit:2
                                                        }
                                                    );
    
    
    editorFila.on('beforeedit',funcEditorFilaBeforeEdicion)
    editorFila.on('validateedit',funcEditorValidaEdicion);
    editorFila.on('canceledit',funcEditorCancelEdicion);
	editorFila.on('afteredit',calcularTotalComputoPrisionPreventiva) ;                                               
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridComputo',
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            y:10,
                                                            x:10,
                                                            plugins:[editorFila],
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,
                                                            height:190,
                                                            width:800,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	id:'btnAgregar',
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:(gE('sL').value=='1'),
                                                                            text:'Agregar c&oacute;mputo',
                                                                            handler:function()
                                                                            		{
                                                                                       	var tblGrid=gEx('gridComputo');
                                                                                        var editorFila=gEx('editorFila');
                                                                                        var registroGrid=crearRegistro(	[
                                                                                        									{name: 'idComputo'},
                                                                                                                            {name: 'anos'},
                                                                                                                            {name: 'meses'},
                                                                                                                            {name: 'dias'},
                                                                                                                            {name: 'reclusorio'}
                                                                                        								]);
                                                                                        
                                                      
                                                                                        
                                                                                        var nReg=new registroGrid	(
                                                                                                                        {
                                                                                                                        	idComputo:0,
                                                                                                                            anos:0,
                                                                                                                            meses:0,
                                                                                                                            dias:0,
                                                                                                                            reclusorio:''
                                                                                                                        }
                                                                                                                    )
                                                                                        
                                                                                        editorFila.stopEditing();
                                                                                        tblGrid.getStore().add(nReg);
                                                                                        tblGrid.nuevoRegistro=true;
                                                                                        editorFila.startEditing(tblGrid.getStore().getCount()-1);	
                                                                                        Ext.getCmp('btnAgregar').disable();
                                                                                        Ext.getCmp('btnRemover').disable();	
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	id:'btnRemover',
                                                                            hidden:(gE('sL').value=='1'),
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover c&oacute;mputo',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el c&oacute;mputo de prisi&oacute;n preventiva que desea remover');
                                                                                            return;
                                                                                            
                                                                                        }
                                                                                    	function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	tblGrid.getStore().remove(fila)
                                                                                                calcularTotalComputoPrisionPreventiva();
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el c&oacute;mputo de prisi&oacute;n preventiva seleccionado?',resp);
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );

	
	 tblGrid.on('beforeedit',function(e)
    						{
                            	e.cancel=(gE('sL').value=='1');
                            }
    			);
	return tblGrid;

}

function funcEditorFilaBeforeEdicion(rowEdit,fila)
{
	if(gE('sL').value=='1')
    	return false;
	var idGrid='gridComputo';
	var grid=Ext.getCmp(idGrid);
    grid.copiaRegistro=grid.getStore().getAt(fila).copy();
    grid.registroEdit=grid.getStore().getAt(fila);
	if((grid.soloLectura)&&(!grid.nuevoRegistro))
		return false;
}

function funcEditorValidaEdicion(rowEdit,obj,registro,nFila)
{
	var idGrid='gridComputo';
	var grid=Ext.getCmp(idGrid);
	var cm=grid.getColumnModel();
	var nColumnas=cm.getColumnCount(false);
    if(capturado)
    {
    	return false;
    }
    capturado=true;
	var x;
	var total=parseInt(obj.anos)+parseInt(obj.meses)+parseInt(obj.dias);
    if(total==0)
    {
    	 msgBox('Debe indicar el tiempo que el imputado cumpli&oacute; prisi&oacute;n preventiva');
         capturado=false;
         return false;
    }
    else
	{
        if(obj.reclusorio=='')
        {
            msgBox('Debe indicar el reclusorio en el cual el imputado cumpli&oacute; la prisi&oacute;n preventiva');
            capturado=false;
            return false;
        }
   	}
    Ext.getCmp('btnRemover').enable();
	Ext.getCmp('btnAgregar').enable();
    grid.nuevoRegistro=false;
    capturado=false;
    calcularTotalComputoPrisionPreventiva();
    return true;
}

function funcEditorCancelEdicion(rowEdit,cancelado)
{

	var idGrid='gridComputo';
	var grid=Ext.getCmp(idGrid);
	if(grid.nuevoRegistro)
    {
		grid.getStore().removeAt(grid.getStore().getCount()-1);
        grid.nuevoRegistro=false;
        Ext.getCmp('btnRemover').enable();
	    Ext.getCmp('btnAgregar').enable();
        return;
    }
	Ext.getCmp('btnRemover').enable();
    Ext.getCmp('btnAgregar').enable();
    var copiaRegistro=grid.copiaRegistro;
    
    var x=0;
    var arrCampos=grid.getStore().fields;
    var filaDestino=grid.registroEdit;

    for(x=0;x<arrCampos.items.length;x++)
    {
    	filaDestino.set(arrCampos.items[x].name,copiaRegistro.get(arrCampos.items[x].name));

    }
	
    
	grid.nuevoRegistro=false;
	
}

function convertirLeyendaComputo(arrValores)
{
	var leyenda='';
    arrValores=normalizarValoresComputo(arrValores);
    
    if((arrValores[0]==0)&&(arrValores[1]==0)&&(arrValores[2]==0))
    {
    	return '0 a&ntilde;os, 0 meses, 0 dias';
    }
    
    
    if(arrValores[0]>0)
    {
    	leyenda+=arrValores[0]+(arrValores[0]==1?' a&ntilde;o':' a&ntilde;os');
    }
    
    if(arrValores[1]>0)
    {
    	if(leyenda=='')
    		leyenda+=arrValores[1]+(arrValores[1]==1?' mes':' meses');
        else
        	leyenda+=', '+arrValores[1]+(arrValores[1]==1?' mes':' meses');
    }
    
    if(arrValores[2]>0)
    {
    	if(leyenda=='')
    		leyenda+=arrValores[2]+(arrValores[2]==1?' dia':' dias');
        else
        	leyenda+=', '+arrValores[2]+(arrValores[2]==1?' dia':' dias');
    }
    
    return leyenda;
    
}

function convertirLeyendaFecha(fecha)
{
	var fecha=Date.parseDate(fecha,'Y-m-d');
    var leyenda=arrDias[parseInt(fecha.format('w'))]+' '+fecha.format('d')+' de '+arrMeses[parseInt(fecha.format('m'))-1][1]+' de '+fecha.format('Y');
    return leyenda;
}

function sumarComputo(arrValores1,arrValores2)
{
	arrValores1=normalizarValoresComputo(arrValores1);
    arrValores2=normalizarValoresComputo(arrValores2);
    
	var arrValoresResultado=[];
    arrValoresResultado[0]=0;
    arrValoresResultado[1]=0;
    arrValoresResultado[2]=0;
    
    arrValoresResultado[2]=arrValores1[2]+arrValores2[2];
    if(arrValoresResultado[2]>diasMes)
    {
    	var meses=parseInt(arrValoresResultado[2]/diasMes);
        arrValoresResultado[2]-=(meses*diasMes);
        arrValoresResultado[1]=meses;
    }
    
    arrValoresResultado[1]+=arrValores1[1]+arrValores2[1];
    if(arrValoresResultado[1]>12)
    {
    	var anios=parseInt(arrValoresResultado[1]/12);
        arrValoresResultado[1]-=(anios*12);
        arrValoresResultado[0]=anios;
    }
    
    arrValoresResultado[0]+=arrValores1[0]+arrValores2[0];
    
    return arrValoresResultado;
}

function restarComputo(arrValores1,arrValores2)
{
	arrValores1=normalizarValoresComputo(arrValores1);
    arrValores2=normalizarValoresComputo(arrValores2);
    
	var arrValoresResultado=[];
    arrValoresResultado[0]=0;
    arrValoresResultado[1]=0;
    arrValoresResultado[2]=0;
    
    var arrValoresAux1=[];
    arrValoresAux1[0]=(arrValores1[0]*12)+arrValores1[1];
    arrValoresAux1[1]=arrValores1[2];
    
    var arrValoresAux2=[];
    arrValoresAux2[0]=(arrValores2[0]*12)+arrValores2[1];
    arrValoresAux2[1]=arrValores2[2];
    
    var arrValoresResultadoAux=[];
    arrValoresResultadoAux[0]=0;
    arrValoresResultadoAux[1]=0;
    if(arrValoresAux1[1]<arrValoresAux2[1])
    {
    	var diferencia=arrValoresAux2[1]-arrValoresAux1[1];
      	var nMeses=parseInt(diferencia/diasMes);
        if((diferencia%diasMes)>0)
        	nMeses++;
        
        if(arrValoresAux1[0]>nMeses)
        {
        	arrValoresAux1[0]-=nMeses;
            arrValoresAux1[1]+=(nMeses*diasMes);
        }
        
        else
        {
        	arrValoresResultado[0]=0;
            arrValoresResultado[1]=0;
            arrValoresResultado[2]=0;            
        	return arrValoresResultado;
        }
    }
    
    arrValoresResultadoAux[1]=arrValoresAux1[1]-arrValoresAux2[1];
    arrValoresResultadoAux[0]=arrValoresAux1[0]-arrValoresAux2[0];
    if(arrValoresResultadoAux[0]<0)
    {
    	arrValoresResultado[0]=0;
        arrValoresResultado[1]=0;
        arrValoresResultado[2]=0; 
    }
    else
    {
    	arrValoresResultado[0]=parseInt(arrValoresResultadoAux[0]/12);
        arrValoresResultado[1]=arrValoresResultadoAux[0]-(arrValoresResultado[0]*12);
        arrValoresResultado[2]=arrValoresResultadoAux[1];
    }
    return arrValoresResultado;
}

function normalizarValoresComputo(arrValores)
{
	arrValores[0]=parseInt(arrValores[0]);
    arrValores[1]=parseInt(arrValores[1]);
    arrValores[2]=parseInt(arrValores[2]);
    return arrValores;
}

function calcularTotalComputoPrisionPreventiva()
{
	var gridComputo=gEx('gridComputo');
    var x;
    var fila;
    var arrComputo=[];
    
    arrComputo[0]=0;
    arrComputo[1]=0;
    arrComputo[2]=0;
    
    var arrValor2=[];

    arrValor2[0]=0;
    arrValor2[1]=0;
    arrValor2[2]=0;
    
    for(x=0;x<gridComputo.getStore().getCount();x++)
    {
    	fila=gridComputo.getStore().getAt(x);
        
        arrValor2[0]=fila.data.anos;
        arrValor2[1]=fila.data.meses;
        arrValor2[2]=fila.data.dias;
        arrComputo=sumarComputo(arrComputo,arrValor2);
        
    }
    var arrResultado=[];
    arrResultado[0]=arrComputo;
    arrResultado[1]=convertirLeyendaComputo(arrComputo);
    gE('lblTotalComputo').innerHTML= arrResultado[1];  
    return arrResultado;
}

function calcularTotalComputoSentencia()
{
	var gridComputo=gEx('gridComputoSentencia');
    var x;
    var fila;
    var arrComputo=[];
    
    arrComputo[0]=0;
    arrComputo[1]=0;
    arrComputo[2]=0;
    
    var arrValor2=[];

    arrValor2[0]=0;
    arrValor2[1]=0;
    arrValor2[2]=0;
    
    for(x=0;x<gridComputo.getStore().getCount();x++)
    {
    	fila=gridComputo.getStore().getAt(x);
        
        arrValor2[0]=fila.data.anos;
        arrValor2[1]=fila.data.meses;
        arrValor2[2]=fila.data.dias;
        arrComputo=sumarComputo(arrComputo,arrValor2);
        
    }
    var arrResultado=[];
    arrResultado[0]=arrComputo;
    arrResultado[1]=convertirLeyendaComputo(arrComputo);
    gE('lblTotalComputoSentencia').innerHTML= arrResultado[1];  
    return arrResultado;
}

function calcularFechaTerminoPena()
{
	var arrPena=calcularTotalComputoSentencia()[0];
    
    
    var arrTotalComputoPrision=calcularTotalComputoPrisionPreventiva()[0];
    
    var diferencia=restarComputo(arrPena,arrTotalComputoPrision);
    gEx('txtAnios').setValue(diferencia[0]);
    gEx('txtMeses').setValue(diferencia[1]);
    gEx('txtDias').setValue(diferencia[2]);
    
    var fechaTermino=gEx('dteFechaEjecutoria').getValue().add(Date.YEAR,diferencia[0]);
    fechaTermino=fechaTermino.add(Date.MONTH,diferencia[1]);
    fechaTermino=fechaTermino.add(Date.DAY,diferencia[2]);
    gE('dteFechaTermino').innerHTML=fechaTermino.format('d/m/Y');
    gE('lblFechaTermino').innerHTML='('+convertirLeyendaFecha(fechaTermino.format('Y-m-d'))+')';
    gEx('btnSave').enable();
    
}

function crearGridComputoSentencia()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idComputo'},
                                                                    {name: 'anos'},
                                                                    {name: 'meses'},
                                                                    {name: 'dias'},
                                                                    {name: 'delito'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
    
    
    var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idComputo'},
                                                        {name: 'anos'},
                                                        {name: 'meses'},
                                                        {name: 'dias'},
                                                        {name: 'delito'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                              reader: lector,
                                              proxy : new Ext.data.HttpProxy	(
                                                                                    {
                                                                                        url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'
                                                                                    }
                                                                                ),
                                              sortInfo: {field: 'delito', direction: 'ASC'},
                                              groupField: 'delito',
                                              remoteGroup:false,
                                              remoteSort: false,
                                              autoLoad:true
                                              
                                          }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='105';
                                        proxy.baseParams.idImputado=gE('idImputado').value;
                                        proxy.baseParams.idActividad=gE('idActividad').value;
                                        proxy.baseParams.carpetaJudicial=gE('carpetaJudicial').value;
                                    }
                        ) 
                        
	alDatos.on('load',function(proxy)
    								{
                                    	calcularTotalComputoSentencia();
                                    }
                        )                        
                          
    
    
	//var chkRow=new Ext.grid.CheckboxSelectionModel();
	
    var cmbAniosGrid=crearComboExt('cmbAniosGridSentencia',arrAniosComputo,0,0);
    var cmbMesesGrid=crearComboExt('cmbMesesGridSentencia',arrMesesComputo,0,0);
    var cmbDiasGrid=crearComboExt('cmbDiasGridSentencia',arrDiasComputo,0,0);
   
    
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
													
														{
															header:'A&ntilde;os',
															width:100,
															sortable:true,
                                                            editor:cmbAniosGrid,
															dataIndex:'anos'
														},
														{
															header:'Meses',
															width:100,
															sortable:true,
                                                            editor:cmbMesesGrid,
															dataIndex:'meses'
														},
                                                        {
															header:'D&iacute;as',
															width:100,
															sortable:true,
                                                            editor:cmbDiasGrid,
															dataIndex:'dias'
														},
                                                        {
															header:'Delito',
															width:400,
															sortable:true,
                                                            
															dataIndex:'delito',
                                                            renderer:function(val)
                                                            			{
                                                                        	return formatearValorRenderer(arrDelitos,val);
                                                                        }
														}
													]
												);    
                                              
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridComputoSentencia',
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            y:10,
                                                            x:10,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,
                                                            height:190,
                                                            width:800,
                                                            clicksToEdit:1,
                                                            view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: true,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            
                                                        }
                                                    );

	
    tblGrid.on('afteredit',calcularTotalComputoSentencia);
    
    tblGrid.on('beforeedit',function(e)
    						{
                            	e.cancel=(gE('sL').value=='1');
                            }
    			);
    

	return tblGrid;

}

function guardarSentenciaPrision()
{
	var gridPrision=gEx('gridComputo');
    var gridComputoSentencia=gEx('gridComputoSentencia');
    
    var fila;
    var x;
    var o='';
    var arrComputoPrision='';
    for(x=0;x<gridPrision.getStore().getCount();x++)
    {
    	fila=gridPrision.getStore().getAt(x);
        o='{"anos":"'+fila.data.anos+'","meses":"'+fila.data.meses+'","dias":"'+fila.data.dias+'","reclusorio":"'+fila.data.reclusorio+'"}';
        if(arrComputoPrision=='')
        	arrComputoPrision=o;
        else
        	arrComputoPrision+=','+o;
    }
    
    var arrComputoSentencia='';
    for(x=0;x<gridComputoSentencia.getStore().getCount();x++)
    {
    	fila=gridComputoSentencia.getStore().getAt(x);
        o='{"anos":"'+fila.data.anos+'","meses":"'+fila.data.meses+'","dias":"'+fila.data.dias+'","delito":"'+fila.data.delito+'"}';
        if(arrComputoSentencia=='')
        	arrComputoSentencia=o;
        else
        	arrComputoSentencia+=','+o;
    }
    
    
    var objSentencia='{"arrComputoPrision":['+arrComputoPrision+'],"arrComputoSentencia":['+arrComputoSentencia+
    				'],"fechaEjecutoria":"'+gEx('dteFechaEjecutoria').getValue().format('Y-m-d')+
                    '","anioSentencia":"'+gEx('txtAnios').getValue()+'","mesSentencia":"'+gEx('txtMeses').getValue()+
                    '","diaSentencia":"'+gEx('txtDias').getValue()+'","fechaCompurga":"'+
                    Date.parseDate(gE('dteFechaTermino').innerHTML,'d/m/Y').format('Y-m-d')+'","idImputado":"'+gE('idImputado').value+
                    '","idActividad":"'+gE('idActividad').value+'","carpetaJudicial":"'+gE('carpetaJudicial').value+
                    '","idEventoAudiencia":"'+gE('idEventoAudiencia').value+'"}';
                    
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            msgBox('La informaci&oacute;n ha sido guardada correctamente');
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=106&cadObj='+objSentencia,true);
                    
    
}

function crearGridBeneficiosPenitenciarios()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idBeneficio'},
                                                        {name:'tipo'},
		                                                {name: 'aplicarBeneficio'},
		                                                {name:'detalles'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'tipo', direction: 'ASC'},
                                                            groupField: 'tipo',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='107';
                                        proxy.baseParams.idImputado=gE('idImputado').value;
                                        proxy.baseParams.idActividad=gE('idActividad').value;
                                        proxy.baseParams.carpetaJudicial=gE('carpetaJudicial').value;
                                    }
                        )   
       
       
    var checkColumn = new Ext.grid.CheckColumn	(
	 												{
													   header: '',
													   dataIndex: 'aplicarBeneficio',
													   width: 30
													}
												);
                                                       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            checkColumn,
                                                            {
                                                                header:'Beneficio/Sustitutivo',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'idBeneficio',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrBeneficios,val);
                                                                            }
                                                            },
                                                            {
                                                                header:'Detalles',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'detalles',
                                                                editor:{xtype:'textarea',height:80},
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Tipo',
                                                                width:100,
                                                                sortable:true,
                                                                dataIndex:'tipo',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val=='1')
                                                                            	return 'Beneficio penitenciario';
                                                                            return 'Sustitutivo de pena';
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gridBeneficios',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                plugins:[checkColumn],
                                                                clickstoEdit:1,
                                                                title:'Beneficios penitenciarios/Sustitutivos de pena',
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: true,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        
        tblGrid.on('beforeedit',function(e)
        							{
                                    	if(gE('sL').value=='1')
                                        	e.cancel=true;
                                            
                                          
                                    }
        			)
        
        return 	tblGrid;
}
