<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT claveUnidad,CONCAT('[',claveFolioCarpetas,'] ',nombreUnidad) AS nombreUnidad FROM _17_tablaDinamica";
	$arrUnidadGestion=$con->obtenerFilasArreglo($consulta);
	
	$arrEtapas="";
	$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=89 ORDER BY numEtapa";
	$rEtapas=$con->obtenerFilas($consulta);
	
	while($fEtapas=mysql_fetch_row($rEtapas))
	{
		$o="['".$fEtapas[0]."','".removerCerosDerecha($fEtapas[0]).". ".cv($fEtapas[1])."']";
		if($arrEtapas=="")
			$arrEtapas=$o;
		else
			$arrEtapas.=",".$o;
	}	
	
	$arrEtapas="[".$arrEtapas."]";
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
?>
var arrTipoCumplimiento=[['1','Inmediato'],['2','Diferido']];
var arrSituacion=<?php echo $arrEtapas?>;
var arrUnidadGestion=<?php echo $arrUnidadGestion?>;
var arrSiNo=<?php echo $arrSiNo?>;
Ext.onReady(inicializar);

function inicializar()
{
	
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                border:false,
                                               
                                                items:	[
                                                         	crearGridResultadoBusqueda()   
                                                        ]
                                            }
                                         ]
                            }
                        )
                        
	gEx('txtCriterio').focus(false,500);  
    
    if(gE('autoload').value =='1')
    {
    	gEx('txtCriterio').setValue(gE('name').value);
        realizarBusqueda();
        gEx('txtCriterio').setReadOnly(true);
        
    }
                           
}

function crearGridResultadoBusqueda()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idAcuerdo'},
                                                        {name: 'unidadGestion'},
		                                                {name: 'tipoCumplimiento'},
		                                                {name: 'resumenAcuerdo'},
		                                                {name: 'fechaExtinsion', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'acuerdoAprobado'},
                                                        {name: 'carpetaAdministrativa'},
                                                        {name: 'documentos'},
                                                        {name: 'comentariosAdicionales'},
                                                        {name: 'delito'},
                                                        {name: 'imputado'},
                                                        {name: 'victimas'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                              reader: lector,
                                              proxy : new Ext.data.HttpProxy	(

                                                                                {

                                                                                    url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                                                    timeout:300000

                                                                                }

                                                                            ),
                                              sortInfo: {field: 'carpetaAdministrativa', direction: 'ASC'},
                                              groupField: 'unidadGestion',
                                              remoteGroup:false,
                                              remoteSort: false,
                                              autoLoad:true
                                              
                                          }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='104';
                                        
                                    }
                        )   
       
       
    var chkRow=new Ext.grid.CheckboxSelectionModel();
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                    	chkRow,
                                                        new  Ext.grid.RowNumberer({width:30}),
                                                        {
                                                            header:'Unidad de Gesti&oacute;n Judicial',
                                                            width:160,
                                                            sortable:true,
                                                            dataIndex:'unidadGestion',
                                                            renderer:function(val,meta,registro)
                                                            			{
                                                                        	return val;
                                                                        }
                                                        },
                                                        {
                                                            header:'Carpeta judicial',
                                                            width:160,
                                                            sortable:true,
                                                            dataIndex:'carpetaAdministrativa',
                                                            renderer:function(val,meta,registro)
                                                            			{
                                                                        	return val;
                                                                        }
                                                        },
                                                      {
                                                          header:'Imputados',
                                                          width:300,
                                                          sortable:true,
                                                          dataIndex:'imputado',
                                                          renderer:function(val)
                                                                  {
                                                                      return val;
                                                                  }
                                                      },
                                                      {
                                                          header:'V&iacute;ctimas',
                                                          width:300,
                                                          sortable:true,
                                                          dataIndex:'victimas',
                                                          renderer:function(val)
                                                                  {
                                                                      return val;
                                                                  }
                                                      },
                                                        
                                                         {
                                                          header:'Hecho delictivo',
                                                          width:300,
                                                          hidden:true,
                                                          sortable:true,
                                                          dataIndex:'delito',
                                                          renderer:function(val)
                                                                  {
                                                                      return val;
                                                                  }
                                                      },
                                                        {
                                                            header:'Tipo de cumplimiento',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'tipoCumplimiento',
                                                            renderer:function(val)
                                                            			{
                                                                        	return formatearValorRenderer(arrTipoCumplimiento,val);
                                                                        }
                                                        },
                                                       	{
                                                          header:'Acuerdo aprobado',
                                                          width:150,
                                                          sortable:true,
                                                          dataIndex:'acuerdoAprobado',
                                                          renderer:function(val)
                                                                  {
                                                                      return formatearValorRenderer(arrSiNo,val);
                                                                  }
                                                      	},
                                                      	{
                                                          header:'Fecha de extinci&oacute;n de<br>la acci&oacute;n penal',
                                                          width:300,
                                                          sortable:true,
                                                          dataIndex:'fechaExtinsion',
                                                          renderer:function(val)
                                                                  {
                                                                  	if(val)
                                                                      	return val.format('d/m/Y');
                                                                  }
                                                      },
                                                      {
                                                          header:'Resumen del acuerdo',
                                                          width:400,
                                                          sortable:true,
                                                          dataIndex:'resumenAcuerdo',
                                                          renderer:function(val)
                                                                  {
                                                                      return mostrarValorDescripcion(val.replace(/<br \/>/gi,'').trim()==''?'(Sin resumen)':val);
                                                                  }
                                                      	},
                                                      {
                                                          header:'Comentarios adicionales',
                                                          width:400,
                                                          sortable:true,
                                                          dataIndex:'comentariosAdicionales',
                                                          renderer:function(val)
                                                                  {
                                                                      return mostrarValorDescripcion(val.replace(/<br \/>/gi,'').trim()==''?'(Sin comentarios)':val);
                                                                  }
                                                      	}
                                                      
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridResultadoBusqueda',
                                                            store:alDatos,
                                                            region:'center',
                                                            border:false,
                                                            frame:false,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,  
                                                            sm:chkRow,                                                          
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :true,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: false,
                                                                                                startCollapsed:false,
                                                                                                groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Acuerdos" : "Acuerdo"]})'
                                                                                            })
                                                        }
                                                    );
    return 	tblGrid;	
}


function abrirRegistroSolicitud(iF,iR)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=	[
                    ['idRegistro',bD(iR)],
                    ['idFormulario',bD(iF)],
                    ['dComp',bE('auto')],
                    ['acto',bE('0')]
                ]
                
    if(window.parent)             
        window.parent.abrirVentanaFancy(obj);
    else
        window.parent.abrirVentanaFancy(obj);
}

function formatearFila(record, rowIndex, p, ds) 
{
	var lblDocumentosAcuerdo='<br />(Sin documentos asociados)';
    var o;
   if(record.data.documentos.length>0)
   {
   		lblDocumentosAcuerdo='';
   		for(x=0;x<record.data.documentos.length;x++)
        {
        	var arExtension=record.data.documentos[x][1].split('.');
        	o='<a href="javascript:mostrarVisorDocumentoProceso(\''+arExtension[arExtension.length-1]+'\','+record.data.documentos[x][0]+')">'+record.data.documentos[x][1]+' ('+bytesToSize(parseInt(record.data.documentos[x][2]),0)+')</a>';
            if(lblDocumentosAcuerdo=='')
            	lblDocumentosAcuerdo=o;
            else
            	lblDocumentosAcuerdo+='<br>'+o;
        }
   }
    
	var xf = Ext.util.Format;
    p.body = '<br><br><table width="100%">'+(record.data.delito!=''?'<tr><td width="30"></td><td><b>Delito</b><br><br />'+record.data.delito+'<br><br /></td></tr>':'')+'<tr><td width="30"></td><td><b>V&iacute;ctimas</b><br><br />'+record.data.victimas+'<br><br /></td></tr>'+
    		'<tr><td width="30"></td><td><b>Resumen del acuerdo</b><br><br>'+(record.data.resumenAcuerdo.trim()==''?'(Sin resumen)':record.data.resumenAcuerdo)+
    		'</td></tr><tr><td width="30"></td><td><br><b>Comentarios adicionales</b><br><br>'+(record.data.comentariosAdicionales.trim()==''?'(Sin comentarios)':record.data.comentariosAdicionales)+
            '</td></tr><tr><td width="30"></td><td><br><b>Documentos del acuerdo</b><br>'+lblDocumentosAcuerdo+'<br></td></tr></table><br><br>';
    return 'x-grid3-row-expanded';
}

function mostrarVisorDocumentoProceso(extension,idDocumento,registro)
{
	var obj={};
    obj.url='../visoresGaleriaDocumentos/visorDocumentosGeneral.php';
    obj.ancho='100%';
    obj.alto='100%';
    obj.params=	[['iD',bE('iD_'+idDocumento)],['cPagina','sFrm=true']];
    abrirVentanaFancy(obj);
	
}


function realizarBusqueda()
{
	gEx('gridResultadoBusqueda').getStore().removeAll();    
    
    if(gEx('txtCriterio').getValue()!='')
    {
        gEx('gridResultadoBusqueda').getStore().load	(
                                                            	{
                                                                	url:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                                    params:	{
                                                                                funcion:104
                                                                            }
                                                            	}
  	                                                      )
	}                                                          
}

var primeraCargaFrame=true;
function frameLoad(iFrame)
{
    if(!primeraCargaFrame)
    {
        setTimeout(
                        function()
                        {
                            iFrame.contentWindow.print()
                        }, 10
                   );
        
        
    }
    else
        primeraCargaFrame=false;
    
}

function imprimirDocumento(tipoAdocumento)
{
	var listaAcuerdos=-1;      
    var gridResultadoBusqueda=gEx('gridResultadoBusqueda');
    var x;
    var fila;
    var filas=gridResultadoBusqueda.getSelectionModel().getSelections();
    for(x=0;x<filas.length;x++)
    {
    	fila=filas[x];
        if(listaAcuerdos==-1)
        	listaAcuerdos=fila.data.idAcuerdo;
        else
        	listaAcuerdos+=','+fila.data.idAcuerdo;
    }
    
    if((tipoAdocumento==2)&&(listaAcuerdos==-1))
    {
    	msgBox('Debe seleccionar almenos un acuerdo en el cual participa el imputado en cuesti&oacute;n');
    	return;
    }
    
    var iFrame=document.getElementById('frameEnvio');
    if(iFrame)
    {
        iFrame.parentNode.removeChild(iFrame);
    }
    
    primeraCargaFrame=false;
    iFrame=document.createElement('iFrame');
    iFrame.name='frameEnvio';
    iFrame.id='frameEnvio';
    //iFrame.style='display:none';
    iFrame.style='width:1px; height:1px;';
    document.body.appendChild(iFrame);
    asignarEvento(iFrame,'load',frameLoad);

    iFrame.src='../modulosEspeciales_SGJP/generarInformeAcuerdoReparatorio.php?tipoInfome='+tipoAdocumento+'&nombre='+gEx('txtCriterio').getValue()+'&listaAcuerdos='+listaAcuerdos;
}