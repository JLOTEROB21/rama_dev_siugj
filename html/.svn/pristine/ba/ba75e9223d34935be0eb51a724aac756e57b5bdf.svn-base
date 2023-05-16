<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos ORDER BY nombreCategoria";
	$arrCategorias=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT valor,texto FROM 1004_siNo ORDER BY valor DESC";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	
?>
var arrSiNo=<?php echo $arrSiNo?>;
var arrCategorias=<?php echo $arrCategorias?>;
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
                                                cls:'panelSiugj',
                                                title: 'Configuraci&oacute;n de m&oacute;dulo de registro de documentos',
                                                items:	[
                                                         	crearGridRegistroDocumentos()   
                                                        ]
                                            }
                                         ]
                            }
                        )   
}


function crearGridRegistroDocumentos()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'tipoDocumento'},
		                                                {name: 'obligatorio'},
		                                                {name: 'funcionAplicacion'},
                                                        {name: 'nombreFuncion'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloRegistroDocumentos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'tipoDocumento', direction: 'ASC'},
                                                            groupField: 'tipoDocumento',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='4';
                                        proxy.baseParams.idFormularioProceso=gE('idFormularioProceso').value;
                                        proxy.baseParams.idProceso=gE('idProceso').value;
                                    }
                        )   


	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40,checkOnly:true});
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            chkRow,
                                                            
                                                            {
                                                                header:'Documento',
                                                                width:550,
                                                                sortable:true,
                                                                dataIndex:'tipoDocumento',
                                                                editor:crearComboExt('editor_idDocumento',arrCategorias,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'}),
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrCategorias,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Obligatorio',
                                                                width:230,
                                                                sortable:true,
                                                                dataIndex:'obligatorio',
                                                                editor:crearComboExt('editor_obligatorio',arrSiNo,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'}),
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSiNo,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Funci&oacute;n de aplicaci&oacute;n',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'funcionAplicacion',
                                                                renderer:function(val,meta,registro,numFila)
                                                                		{
                                                                        	var comp='<a href="javascript:agregarFuncionAsignacion(\''+bE(numFila)+'\')"><img src="../images/pencil.png" title="Funci&oacute;n de aplicaci&oacute;n" alt="Funci&oacute;n de aplicaci&oacute;n"></a> ';
                                                                        	if(registro.data.nombreFuncion!='')
                                                                            	comp+='<a href="javascript:removerFuncionAsignacion(\''+bE(numFila)+'\')"><img src="../images/cross.png" title="Remover funci&oacute;n de aplicaci&oacute;n" alt="Remover funci&oacute;n de aplicaci&oacute;n"></a> ';
                                                                            
                                                                            return comp+registro.data.nombreFuncion
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gridDocumentos',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                clicksToEdit:1,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                sm:chkRow,
                                                                columnLines : true,
                                                                tbar:	[
                                                                            {
                                                                                icon:'../principalPortal/imagesSIUGJ/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar tipo de documento',
                                                                                handler:function()
                                                                                        {
                                                                                            var reg=crearRegistro	(
                                                                                            							[
                                                                                                                        	{name:'idRegistro'},
                                                                                                                            {name: 'tipoDocumento'},
                                                                                                                            {name: 'obligatorio'},
                                                                                                                            {name: 'funcionAplicacion'},
                                                                                                                            {name: 'nombreFuncion'}
                                                                                                                        ]
                                                                                            						)
                                                                                        
                                                                                        	var r=new reg	(
                                                                                            					{
                                                                                                                	idRegistro:-1,
                                                                                                                    tipoDocumento:'',
                                                                                                                    obligatorio:'0',
                                                                                                                    funcionAplicacion:'',
                                                                                                                    nombreFuncion:''
                                                                                                                }
                                                                                            				)
                                                                                        
                                                                                        	gEx('gridDocumentos').getStore().add(r);
                                                                                            gEx('gridDocumentos').startEditing(gEx('gridDocumentos').getStore().getCount()-1,1);
                                                                                            
                                                                                            
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                            	width:30
                                                                            },
                                                                            {
                                                                                icon:'../principalPortal/imagesSIUGJ/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover tipo de documento',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=gEx('gridDocumentos').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el tipo de documento a remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	gEx('gridDocumentos').getStore().remove(fila);
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('¿Est&aacute; seguro de querer remover el tipo de documento seleccionado?',resp);
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                            	width:30
                                                                            },
                                                                            {
                                                                                icon:'../images/guardar.JPG',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Guardar',
                                                                                handler:function()
                                                                                        {
                                                                                            var arrFilas='';
                                                                                            var o='';
                                                                                            var x;
                                                                                            var fila;
                                                                                            for(x=0;x<gEx('gridDocumentos').getStore().getCount();x++)
                                                                                            {
                                                                                            	fila=gEx('gridDocumentos').getStore().getAt(x);
                                                                                            	o='{"tipoDocumento":"'+fila.data.tipoDocumento+'","obligatorio":"'+fila.data.obligatorio+
                                                                                                	'","funcionAplicacion":"'+fila.data.funcionAplicacion+'"}';
                                                                                                    
                                                                                                if(fila.data.tipoDocumento=='')
                                                                                                {    
                                                                                                    function resp()
                                                                                                    {
                                                                                                    	gEx('gridDocumentos').startEditing(x,1);
                                                                                                    }
                                                                                                    msgBox('Debe indicar el tipo de documento a agregar',resp);
                                                                                                    return;
																								}      
                                                                                                
                                                                                                
                                                                                                if(fila.data.obligatorio=='')
                                                                                                {    
                                                                                                    function resp2()
                                                                                                    {
                                                                                                    	gEx('gridDocumentos').startEditing(x,2);
                                                                                                    }
                                                                                                    msgBox('Debe indicar la obligatoriedad del tipo de documento',resp2);
                                                                                                    return;
																								}                                                                                                  
                                                                                                    	
                                                                                                if(arrFilas=='')
                                                                                                	arrFilas=o;
                                                                                                else
                                                                                                	arrFilas+=','+o;
                                                                                            }
                                                                                            
                                                                                            
                                                                                            var cadObj='{"idFormularioProceso":"'+gE('idFormularioProceso').value+'","idProceso":"'+gE('idProceso').value+'","arrFilas":['+arrFilas+']}';
                                                                                            function funcAjax()
                                                                                            {
                                                                                                var resp=peticion_http.responseText;
                                                                                                arrResp=resp.split('|');
                                                                                                if(arrResp[0]=='1')
                                                                                                {
                                                                                                    gEx('gridDocumentos').getStore().reload();
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloRegistroDocumentos.php',funcAjax, 'POST','funcion=5&cadObj='+cadObj,true);

                                                                                            
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                        ],
                                                                cls:'gridSiugjPrincipal',
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


function agregarFuncionAsignacion(numFila)
{

	var filaRegistro=gEx('gridDocumentos').getStore().getAt(parseInt(bD(numFila)));
	
    
    
    asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre,ventana)
                                            {
                                             	filaRegistro.set('funcionAplicacion',idConsulta);
                                                filaRegistro.set('nombreFuncion',nombre)
                                                if(gEx('vAgregarExp'))
	                                                gEx('vAgregarExp').close();
                                            }
    mostrarVentanaExpresion(function(filaSelec,ventana)
    						{
                                filaRegistro.set('funcionAplicacion',filaSelec.data.idConsulta);
                                filaRegistro.set('nombreFuncion',filaSelec.data.nombreConsulta)
                                
                                ventana.close();
                            }
    						,true);
    
}


function removerFuncionAsignacion(numFila)
{
	var filaRegistro=gEx('gridDocumentos').getStore().getAt(parseInt(bD(numFila)));
	filaRegistro.set('funcionAplicacion','');
    filaRegistro.set('nombreFuncion','')
}