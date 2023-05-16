<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>	

function mostrarVentanaAyuda()
{
	var img=h.gE('imgAyuda_'+h.idControlSel);
    cargarDatos=false;
    if(img!=null)
    	cargarDatos=true;

    function obtenerIdiomas()
    {
        var resp=eval(peticion_http.responseText);
        var tblAyuda=crearGridAyuda(resp);
        var form = new Ext.form.FormPanel(	
                                                {
                                                    baseCls: 'x-plain',
                                                    layout:'absolute',
                                                    defaultType: 'textfield',
                                                    items: 	[
                                                                tblAyuda	
                                                            ]
                                                }
                                            );
        
            ventanaAyuda = new Ext.Window(
                                            {
                                                title: 'Mensaje de ayuda',
                                                width: 630,
                                                height:250,
                                                minWidth: 300,
                                                minHeight: 100,
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
                                                                            pIdioma=obtenerPosFila(alNameDTD,'idIdioma',gE('hLeng').value);
                                                                            if(pIdioma!=-1)
                                                                            {
                                                                                tblFrmDTD.startEditing(pIdioma,1);
                                                                            }
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                               
                                                                {
                                                                    text: 'Aceptar',
                                                                    id:'btnFinalizarAyuda',
                                                                    listeners:
                                                                                {
                                                                                    click:	{
                                                                                                fn:function()
                                                                                                    {
                                                                                                    	tblAyuda.stopEditing(false);
                                                                                                        if(validarDatosGridAyuda(tblAyuda.getStore(),'msgAyuda',gE('hLeng').value))
                                                                                                        {
                                                                                                        	
                                                                                                            var cuerpo='';
                                                                                                            var ct=tblAyuda.getStore().getCount();
                                                                                                            var reg;
                                                                                                            var cadTemp='';
                                                                                                            for(x=0;x<ct;x++)
                                                                                                            {
                                                                                                                reg=tblAyuda.getStore().getAt(x);
                                                                                                                cadTemp='{"idIdioma":"'+cv(reg.get('idIdioma'))+'","msgAyuda":"'+cv(reg.get('msgAyuda'))+'"}';
                                                                                                                if(cuerpo=='')
                                                                                                                    cuerpo=cadTemp;
                                                                                                                else
                                                                                                                    cuerpo+=','+cadTemp;
                                                                                                            }
                                                                                                            
                                                                                                           	
                                                                                                            obj='{"idGrupoElemento":"'+cv(h.idControlSel)+'","arrMsg":['+cuerpo+']}';
                                                                                                            function funcAjax()
                                                                                                            {
                                                                                                                var resp=peticion_http.responseText;
                                                                                                                arrResp=resp.split('|');
                                                                                                                if(arrResp[0]=='1')
                                                                                                                {
                                                                                                                	var idIdioma=h.gE('hIdidioma').value;
                                                                                                                	var objJson=eval('['+obj+']')[0];
                                                                                                                    var arrMsg=objJson.arrMsg;
                                                                                                                    var z;
                                                                                                                    msgAyuda='';
                                                                                                                    for(z=0;z<arrMsg.length;z++)
                                                                                                                    {
                                                                                                                    	if(arrMsg[z].idIdioma==idIdioma)
                                                                                                                        {
                                                                                                                        	msgAyuda=dv(arrMsg[z].msgAyuda);
                                                                                                                            break;
                                                                                                                        }
                                                                                                                    }
                                                                                                                    var spAyuda=h.gE('spAyuda_'+h.idControlSel);
                                                                                                                    var padreSp=spAyuda.parentNode;
                                                                                                                    padreSp.removeChild(spAyuda);
                                                                                                                    var spAyuda=document.createElement('span');
                                                                                                                    spAyuda.id='spAyuda_'+h.idControlSel;
                                                                                                                    var imagen=document.createElement('img');
                                                                                                                    if(Ext.isIE)
                                                                                                                    {
                                                                                                                        imagen.style.height=16;
                                                                                                                        imagen.style.width=16;
                                                                                                                    }
                                                                                                                    else
                                                                                                                    {
                                                                                                                        imagen.setAttribute('width',16);
                                                                                                                        imagen.setAttribute('height',16);
                                                                                                                    }
                                                                                                                    imagen.src='../images/formularios/sInterrogacion.jpg';
                                                                                                                    imagen.title=msgAyuda;
                                                                                                                    imagen.alt=msgAyuda;
                                                                                                                    imagen.id='imgAyuda_'+h.idControlSel;
                                                                                                                    spAyuda.appendChild(imagen);
                                                                                                                    padreSp.appendChild(spAyuda);
                                                                                                                    //mE('btnDelAyuda');
                                                                                                                 	ventanaAyuda.close();  
                                                                                                                }
                                                                                                                else
                                                                                                                {
                                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                }
                                                                                                            }
                                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=28&param='+obj,true);
                                                                                                        }
                                                                                                    }
                                                                                            }
                                                                                }
                                                                },
                                                                {
                                                                    text: '<?php echo $etj["lblBtnCancelar"] ?>',
                                                                    handler:function()
                                                                    {
                                                                        ventanaAyuda.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
        if(cargarDatos==true)                              
			llenarDatosAyuda(ventanaAyuda);                                        
        else
        	ventanaAyuda.show();
        

    }
    obtenerDatosWeb('../paginasFunciones/funciones.php',obtenerIdiomas, 'POST','funcion=4',true);
	
}

function llenarDatosAyuda(ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrMsg=eval(arrResp[1]);
            var x;
            var idIdioma;
            var msg;
            var gridAyuda=Ext.getCmp('gridAyuda');
            var almacen=gridAyuda.getStore();
            for(x=0;x<arrMsg.length;x++)
            {
            	idIdioma=arrMsg[x][0];
                msg=arrMsg[x][1];
                
                asignarMensajeAyuda(idIdioma,msg,almacen);
                ventana.show();
                
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=30&idGrupoElemento='+h.idControlSel,true);
}

function asignarMensajeAyuda(idIdioma,msg,almacen)
{
	var x;
    var nFilas=almacen.getCount();
    var fila;
    for(x=0;x<nFilas;x++)
    {
    	fila=almacen.getAt(x);
        if(fila.get('idIdioma')==idIdioma)
        {
        	fila.set('msgAyuda',msg);
            break;
        }
    }
}

function crearGridAyuda(datos)
{
	var dsNameDTD= 	[];					
    alNameDTD=		new Ext.data.SimpleStore(
    											{
    												fields:	[
    															{name: 'idioma'},
																{name: 'idIdioma'},
																{name: 'msgAyuda'},
    														]
    											}
    										);
    alNameDTD.loadData(dsNameDTD);
	llenarDatosGridAyuda(datos);
	
	var cmFrmDTD= new Ext.grid.ColumnModel   	(
												 	[
													 	{
															header:'Lenguaje',
															width:80,
															dataIndex:'idioma',
															renderer: cambiarColor
														},
														{
															header:'Mensaje de ayuda',
															width:500,
															dataIndex:'msgAyuda',
															editor: new Ext.form.TextField   (
																									{
																									   
																									   style: 'text-align:left'
																									}
																								)
														}
													]
												);
											
	tblFrmDTD=	new Ext.grid.EditorGridPanel	(
                                                    {
                                                    	id:'gridAyuda',
                                                        store:alNameDTD,
                                                        frame:true,
                                                        clicksToEdit: 1,
                                                        cm: cmFrmDTD,
                                                        height:150,
                                                        width:600
                                                    }
							                    );
	
	return tblFrmDTD;	
}	

function llenarDatosGridAyuda(datos)
{
	for (x=0;x<datos.length;x++)
	{
		
		var FilaRegistro = new rgIdiomas(
                                            {
                                                    idioma:datos[x].imagen,
                                                    idIdioma: datos[x].idIdioma,
                                                    msgAyuda: datos[x].msgAyuda

                                               }
                                          );
                                                  
        alNameDTD.add(FilaRegistro); 
	}
}

function validarGAyuda(dSet,columna,idIdioma)
{
	var fila;
	var nomDefault=false;
	var ct=0;
	for(x=0;x<dSet.getCount();x++)
	{
		fila=dSet.getAt(x);
		if(trim(fila.get(columna))!='')
		{
			if(fila.get('idIdioma')==idIdioma)
				nomDefault=true;
			ct++;
		}
	}
	if(dSet.getCount()==ct)
		return 0; //Sin problemas
	
	if(!nomDefault)
		return 1; //El nombre en idioma original no fue especificado
	
	return 2;
}

function validarDatosGridAyuda(dSet,columna,idIdioma)
{
	var res=validarGAyuda(dSet,columna,idIdioma);
	switch(res)
	{
		case 0: //Sin problemas
			return true;	
		break;
		case 1: //El nombre en idioma original no fue especificado
		
			function funcAceptar()
			{
				pIdioma=obtenerPosFila(dSet,'idIdioma',gE('hLeng').value);
				if(pIdioma!=-1)
				{
					tblFrmDTD.startEditing(pIdioma,1);
				}
				return false;
			}
			msgBox('El mensaje de ayuda escrito en su idioma es obligatorio',funcAceptar);
			
		break;
		case 2:
			function funcConfirmacion(btn)
			{
				if(btn=='yes')
				{
					var fIdioma=obtenerFilaIdioma(dSet,gE('hLeng').value);
					rellenarValoresVacios(dSet,'msgAyuda','['+fIdioma.get('msgAyuda')+']');
					Ext.getCmp('btnFinalizarAyuda').fireEvent('click');
				}
				else
					return false;
			}
			msgConfirm( 'El mensaje de ayuda no ha sido especificado en todos lo idiomas, desea continuar?', funcConfirmacion);
		break;
	}
}

function eliminarAyuda()
{
	function resp(btn)
    {
    	if(btn=='yes')
        {
        	function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
    				var spAyuda=h.gE('spAyuda_'+h.idControlSel);
                    var padreSp=spAyuda.parentNode;
                    padreSp.removeChild(spAyuda);
                    var spAyuda=document.createElement('span');
                    spAyuda.id='spAyuda_'+h.idControlSel;
                    padreSp.appendChild(spAyuda);
   					//oE('btnDelAyuda');
	            }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=29&idGrupoElemento='+h.idControlSel,true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer eliminar la ayuda asociada a este control?',resp);
}