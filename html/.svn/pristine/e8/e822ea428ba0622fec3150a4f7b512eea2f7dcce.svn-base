<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
?>
Ext.onReady(inicializar);
function inicializar()
{
	var mVentana=gE('mostrarVentanaActor');
    if(mVentana!=null)
    {
    	switch(mVentana.value)
        {
        	case '1':
            	mostrarVentanaSelActor();
            break;
            case '2':
            	mostrarVentanaSelEtapa();
            break;
        }
    }
}

function mostrarVentanaSelActor()
{
	var gridAsigDisponibles=crearGridAsignacionesDisp();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'<span class="letraRojaSubrayada8">Se ha detectado que usted cuenta con privilegios para registrar detecci&oacute;n de necesidades de m&aacute;s de un departamento / programa, seleccione aquel bajo el cual desee entrar el proceso</span>'
                                                        },
														gridAsigDisponibles

													]
										}
									);
	
        var ventanaAM = new Ext.Window(
                                        {
                                            title: lblAplicacion,
                                            width: 680,
                                            height:450,
                                            layout: 'fit',
                                            plain:true,
                                            modal:true,
                                            bodyStyle:'padding:5px;',
                                            buttonAlign:'center',
                                            items: form,
                                            listeners : {
                                                        show : {
                                                                    buffer : 10,
                                                                    fn : function() 
                                                                    {
                                                                    }
                                                                }
                                                    },
                                            buttons:	[
                                                            {
                                                                
                                                                text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                                
                                                                handler: function()
                                                                        {
                                                                            var fila=gridAsigDisponibles.getSelectionModel().getSelected();
                                                                            if(fila==null)
                                                                            {
                                                                            	msgBox('Debe seleccionar el departamento/programa bajo el cual desea entrar al proceso');
                                                                            	return;
                                                                            }
                                                                            
                                                                            var paramJS=eval(gE('paramJS').value);
                                                                            var arrPrograma=fila.get('programa').split('.');
                                                                            var obj=new Array();
                                                                            obj[0]='idPrograma';
                                                                            obj[1]=arrPrograma[1];
                                                                            paramJS.push(obj);
                                                                            obj=new Array();
                                                                            obj[0]='codigoUnidad';
                                                                            obj[1]=fila.get('codigoDepto');
                                                                            paramJS.push(obj);
                                                                            obj=new Array();
                                                                            obj[0]='ruta';
                                                                            obj[1]=arrPrograma[0];
                                                                            paramJS.push(obj);
                                                                            enviarFormularioDatos(gE('paginaRedireccion').value,paramJS);
                                                                        }
                                                            },
                                                            {
                                                                text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                                handler:function()
                                                                        {
                                                                            ventanaAM.close();
                                                                        }
                                                            }
                                                        ]
                                        }
                                    );
        ventanaAM.show();	
}

function crearGridAsignacionesDisp()
{
	var dsDatos=eval(bD(gE('asignaDisponibles').value));
    
    
    
    var lector= new Ext.data.ArrayReader({
                                            
                                            fields: [
                                               			{name: 'codigoDepto'},
                                                        {name: 'programa'},
                                                        {name:'tituloDepto'},
                                                        {name:'tituloPrograma'}
                                            ]
                                           
                                        }
                                      );
                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            data:dsDatos,
                                                            sortInfo: {field: 'tituloPrograma', direction: 'ASC'},
                                                            groupField: 'tituloDepto'
                                                            
                                                        }) 
    
    
   // alDatos.loadData(dsDatos);
    
    
    
    
    
    
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Departamento',
															width:250,
															sortable:true,
															dataIndex:'tituloDepto'
														},
														{
															header:'Programa',
															width:300,
															sortable:true,
															dataIndex:'tituloPrograma'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            y:50,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:650,
                                                            sm:chkRow,
                                                            view: new Ext.grid.GroupingView(	{
                                                                                                    forceFit:true,
                                                                                                    showGroupName: false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:true,
                                                                                                    hideGroupedColumn: true
                                                                                            	}   
                                                                                            ) 
                                                        }
                                                    );
	return 	tblGrid;		
}


function mostrarVentanaSelEtapa()
{
	var arrDatos=eval(gE('arrEtapas').value);
    if(arrDatos.length==1)
    {
    	var paramJS=eval(gE('paramJS').value);
        var obj=new Array();
        obj[0]='numEtapa';
        obj[1]=bE(arrDatos[0][0]);
        paramJS.push(obj);
        enviarFormularioDatos(gE('paginaRedireccion').value,paramJS);
    	return;
    }
	var gridAsigDisponibles=crearGridSelEtapa(arrDatos);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'<span class="letraRojaSubrayada8">Se ha detectado que usted cuenta con privilegios para ingresar al proceso en más de un tiempo(etapa), por favor seleccione la etapa bajo la cual quiere ingresar al proceso: </span>'
                                                        },
														gridAsigDisponibles

													]
										}
									);
	
        var ventanaAM = new Ext.Window(
                                        {
                                            title: lblAplicacion,
                                            width: 560,
                                            height:450,
                                            layout: 'fit',
                                            plain:true,
                                            modal:true,
                                            bodyStyle:'padding:5px;',
                                            buttonAlign:'center',
                                            items: form,
                                            listeners : {
                                                        show : {
                                                                    buffer : 10,
                                                                    fn : function() 
                                                                    {
                                                                    }
                                                                }
                                                    },
                                            buttons:	[
                                                            {
                                                                
                                                                text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                                
                                                                handler: function()
                                                                        {
                                                                            var fila=gridAsigDisponibles.getSelectionModel().getSelected();
                                                                            if(fila==null)
                                                                            {
                                                                            	msgBox('Debe seleccionar la etapa bajo la cual desea entrar al proceso');
                                                                            	return;
                                                                            }
                                                                            
                                                                            var paramJS=eval(gE('paramJS').value);
                                                                            var obj=new Array();
                                                                            obj[0]='numEtapa';
                                                                            obj[1]=bE(fila.get('nEtapa'));
                                                                            paramJS.push(obj);
                                                                            enviarFormularioDatos(gE('paginaRedireccion').value,paramJS);
                                                                        }
                                                            },
                                                            {
                                                                text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                                handler:function()
                                                                        {
                                                                            ventanaAM.close();
                                                                        }
                                                            }
                                                        ]
                                        }
                                    );
        ventanaAM.show();	
}

function crearGridSelEtapa(arrDatos)
{
	
	var dsDatos=arrDatos;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'nEtapa'},
                                                                    {name: 'nombreEtapa'}
                                                                    
                                                                ],
                                                        sortInfo: 	{
                                                                        field: 'nEtapa',
                                                                        direction: 'ASC' 
                                                                    }
                                                                   
                                                	}
                                                
                                            );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
														chkRow,
														{
															header:'# etapa',
															width:100,
															sortable:true,
															dataIndex:'nEtapa'
														},
														{
															header:'Nombre de la etapa',
															width:350,
															sortable:true,
															dataIndex:'nombreEtapa'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            y:70,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:520,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;		
}