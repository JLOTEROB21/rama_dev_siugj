<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


var cadenaFuncionValidacion='funcionValidaAmbito';

function agregarEstadoAplicacion(boton)
{
	var arrDatos=boton.id.split('_');
    var idGrid=arrDatos[1]+'_'+arrDatos[2];
	mostrarVentanaAgregarEstado(idGrid);
}

function mostrarVentanaAgregarEstado(idGrid)
{

	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var cmbEstado=crearComboExt('cmbEstado',eval(arrResp[1]),80,5,220);
            cmbEstado.on('select',function(combo,registro)
            						{
                                    	function funcAjax()
                                        {
                                            var resp=peticion_http.responseText;
                                            arrResp=resp.split('|');
                                            if(arrResp[0]=='1')
                                            {
                                                gEx('gridMunicipioAdd').getStore().loadData(eval(arrResp[1]));
                                            }
                                            else
                                            {
                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                            }
                                        }
                                        obtenerDatosWeb('../paginasFunciones/funcionesEspeciales.php',funcAjax, 'POST','funcion=18&idCategoria='+gE('idReferencia').value+'&estado='+registro.get('id'),true);
                                    }
            			)
            
            
            var gridMunicipio=crearGridMunicipio();
            var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Estado:'
                                                        },
                                                        cmbEstado,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Municipio:'
                                                        },
                                                        gridMunicipio

													]
										}
									);
	
            var ventanaAM = new Ext.Window(
                                            {
                                                title: 'Agregar estado / municipio',
                                                width: 400,
                                                height:420,
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
                                                                                var filas=gridMunicipio.getSelectionModel().getSelections();
                                                                                if(filas.length==0)
                                                                                {
                                                                                	msgBox('Debe seleccionar el estado/municipio que desea agregar');
                                                                                	return;
                                                                                }
                                                                                
                                                                                var x;
                                                                                var reg=crearRegistro(
                                                                                					[
                                                                                                    	{name:'idRegistro'},
                                                                                                        {name:'idReferencia'},
                                                                                                        {name:'estado'},
                                                                                                        {name:'municipio'},
                                                                                                        {name:'lblMunicipio'}
                                                                                                        
                                                                                					]);
                                                                               var grid=gEx(idGrid); 
                                                                               var r;                    
                                                                                for(x=0;x<filas.length;x++)
                                                                                {
                                                                                	if(!buscarMunicipio(grid,cmbEstado.getValue(),filas[x].get('cveMunicipio')))
                                                                                    {
                                                                                    	r=new reg({idRegistro:-1,idReferencia:-1,estado:cmbEstado.getValue(),municipio:filas[x].get('cveMunicipio'),lblMunicipio:filas[x].get('municipio')});
                                                                                        grid.getStore().add(r);
                                                                                    }
                                                                                }
                                                                                ventanaAM.close();
                                                                                
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
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesEspeciales.php',funcAjax, 'POST','funcion=17&idCategoria='+gE('idReferencia').value,true);
}


function buscarMunicipio(grid,estado,municipio)
{
	var x;
    var g=grid;
    var fila;
    for(x=0;x<g.getStore().getCount();x++)
    {
    	fila=g.getStore().getAt(x);
        if((fila.get('estado')==estado)&&(fila.get('municipio')==municipio))
        {
        	return true;
        }
        
    }
    return false;
}


function crearGridMunicipio()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                  {
                                                      fields:	[
                                                                  {name: 'cveMunicipio'},
                                                                  {name: 'municipio'}
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
															header:'Municipio',
															width:260,
															sortable:true,
															dataIndex:'municipio'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridMunicipioAdd',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            height:290,
                                                            width:370,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
}



function selAmbito()
{
	var grid=gEx('grid_3525');
	var cmbAmbito=gE('_ambitoAplicacionvch');
    var valor=cmbAmbito.options[cmbAmbito.selectedIndex].value;
    switch(valor)
    {
	     case '1':
         	grid.enable();
    	 break;
         case '2':
         	grid.enable();
         break;
         case '3':
         	if(grid.getStore().getCount()>0)
            {
            	function resp(btn)
                {
                	if(btn=='yes')
                    {
                    	grid.getStore().removeAll();
                    	grid.disable();
                    }
                    else
                    {
                    	cmbAmbito.selectedIndex=0;
                    }
                }
                msgConfirm('Al marcar el proyecto como de &aacute;mbito nacional, se eliminar&aacute;n los municipios que previamente hab&iacute;a definido como &aacute;mbito de aplicaci&oacute;n del proyecto,desea continuar?',resp)
            }
            else
         		grid.disable();
         break;
         
    }

}

function inyeccionCodigo()
{
	asignarEvento('_ambitoAplicacionvch','change',selAmbito);
}


function funcionValidaAmbito()
{
	var grid=gEx('grid_3525');
    var fila;
    var arrEstados=new Array();
    var x;
    for(x=0;x<grid.getStore().getCount();x++)
    {
    	fila=grid.getStore().getAt(x);
        if(existeValorArreglo(arrEstados,fila.get('estado'))==-1)
        	arrEstados.push(fila.get('estado'))
    }
    var cmbAmbito=gE('_ambitoAplicacionvch');
    var valor=cmbAmbito.options[cmbAmbito.selectedIndex].value;
    switch(valor)
    {
	     case '1':
         	if(arrEstados.length>1)
            {
            	msgBox('El proyecto no puede ser clasificado como local debido a que involucra m&aacute;s de un estado');
            	return false;
            }
    	 break;
         case '2':
         	if(arrEstados.length==1)
            {
            	msgBox('El proyecto no puede ser clasificado como regional debido a que involucra s&oacute;lo un estado');
            	return false;
            }
         break;
	}
	return true;
}