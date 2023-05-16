<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php"); 
	
	$idProceso=base64_decode($_GET["proc"]);
	$consulta="select numEtapa,nombreEtapa from 4037_etapas where idProceso=".$idProceso;

	$arrEtapas=uEJ($con->obtenerFilasArreglo($consulta));
	
	$res5=$con->obtenerFilas("select idIdioma,idioma,imagen from 8002_idiomas");
	$columnas="";
	$ancho=470;
	while($fila5=mysql_fetch_row($res5))
	{
		if($columnas=="")
			$columnas= "{header:'<center><img src=\"../images/banderas/".$fila5[2]."\" title=\"".$fila5[1]."\" /></center>',width:210,dataIndex:'idioma_".$fila5[0]."',editor: new Ext.form.TextField ({  style: 'text-align:left'})}";
		else
			$columnas.=","."{header:'<center><img src=\"../images/banderas/".$fila5[2]."\" title=\"".$fila5[1]."\" /></center>',width:210,dataIndex:'idioma_".$fila5[0]."',editor: new Ext.form.TextField ({  style: 'text-align:left'})}";
	$ancho+=210;	
	}	
	if($ancho==255)
		$ancho+=210;
	$columnasDP=$columnas;
	$columnasDR=uEJ($columnas);
	$columnas.=",{header:'Pasa a etapa:',width:330,dataIndex:'numEtapa',renderer:formatearEtapa}";	
	$columnasDP.=",{header:'Acci&oacute;n autor:',width:200,dataIndex:'accion',renderer:formatearAccion}";	
	$columnas=uEJ($columnas);
	$columnasDP=uEJ($columnasDP);
	
	$campos="{name:'valorOpt'}";
	$camposOpciones="valorOpt:''";
	$filaDefault="''";
	if(mysql_data_seek($res5,0))
	{
		while($fila5=mysql_fetch_row($res5))
		{
			$campos.=",{name:'idioma_".$fila5[0]."'}";
			$camposOpciones.=",idioma_".$fila5[0].":''";
			$filaDefault.=",''";
		}	
	}
	$filaDefaultDR=$filaDefault;
	$filaDefaultDP=$filaDefault.=",'1'";
	$filaDefault.=",'0'";
	$camposDR=uEJ($campos);
	$camposDP=uEJ($campos.",{name:'accion'}");
	$campos.=",{name:'numEtapa'}";
	$campos=uEJ($campos);
	$camposOpcionesDP=uEJ($camposOpciones.",accion:'1'");
	$camposOpciones.=",numEtapa:'0'";
	$camposOpciones=uEJ($camposOpciones);

	$consulta="select valorOpcion,opcion from 951_catalogoOpcionesVarios where tipoOpcion=1 and idIdioma=".$_SESSION["leng"];
	$arrOpciones=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select valorOpcion,opcion from 951_catalogoOpcionesVarios where tipoOpcion=2 and idIdioma=".$_SESSION["leng"];
	$arrAcciones=uEJ($con->obtenerFilasArreglo($consulta));
?>

var arrEtapas=<?php echo $arrEtapas?>;
var arrAcciones=<?php echo $arrAcciones?>;
var arrNinguna=['0','Ninguna'];
arrEtapas.push(arrNinguna);

function formatearAccion(val)
{
	var pos=existeValorMatriz(arrAcciones,val);
    if(pos>-1)
		return arrAcciones[pos][1];
    else
    	return val;
}
function agregarFormulario(p,et,pc)
{
	var arrParam=[['idProceso',p],['idFormulario','-1'],['numEtapa',et],['idProyComite',pc]];
    enviarFormularioDatos('../modeloPerfiles/formulariosComite.php',arrParam);
}

function modificarFormulario(idFrm)
{
	var arrParam=[['idFormulario',idFrm]];
    enviarFormularioDatos('../modeloPerfiles/formulariosComite.php',arrParam);
}

function verFormulario(idFrm)
{
	var arrParam=[['idFormulario',idFrm]];
    enviarFormularioDatos('../modeloPerfiles/configurarVistaFormulario.php',arrParam);
}

function eliminarFormulario(idFrm)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcResp()
			{
				var arrResp=peticion_http.responseText.split('|');
				if(arrResp[0]=='1')
				{
                	var filaDel=gE('fila_'+idFrm);
                    filaDel.parentNode.removeChild(filaDel);
                    
				}
				else
				{
					 msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=44&idFormulario='+idFrm,true);
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este formulario?',respPregunta);
}

function verFormulario(idFormulario)
{
	var arrParam=[['idFormulario',idFormulario]];
    enviarFormularioDatos('../modeloPerfiles/formularios.php',arrParam);

}

function configurarDictamenRevisor(idAccion,et,idGrupoElemento)
{
	
    var grupoElemento=null;
    if(idGrupoElemento!=undefined)
    	grupoElemento=idGrupoElemento;
	
    var dsOpciones= [<?php echo "[".$filaDefaultDR."]" ?>];
    alOpciones=		new Ext.data.SimpleStore(
                                                {
                                                    fields:	[
                                                                <?php 
                                                                    echo $camposDR;
                                                                ?>
                                                            ]
                                                }
                                            );
    
    alOpciones.loadData(dsOpciones);
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'Clave',
                                                            width:100,
                                                            dataIndex:'valorOpt',
                                                            editor: new Ext.form.TextField   (
                                                                                                    {
                                                                                                      
                                                                                                       style: 'text-align:left'
                                                                                                    }
                                                                                                )
                                                        }
                                                        ,
                                                        <?php 
                                                            echo $columnasDR;
                                                        ?>
                                                    ]
                                                );
    
    
    
    tblOpciones=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridOpcionesManualesDR',
                                                            store:alOpciones,
                                                            frame:true,
                                                            clicksToEdit: 1,
                                                            cm: cmFrmDTD,
                                                            height:270,
                                                            columnLines:true,
                                                            width:<?php echo $ancho+35-350 ?>,
                                                            title:'Ingrese los posibles valores de dict&aacute;men:',
                                                            tbar: [
                                                                    {
                                                                        text: 'Agregar opci&oacute;n',
                                                                        icon:'../images/add.png',
                                                                        handler : function()
                                                                                  {
                                                                                        var r=new RegistroOpciones	(
                                                                                                                        {
                                                                                                                            <?php echo $camposOpcionesDP?>
                                                                                                                        }
                                                                                                                    ) 	
                                                                                        alOpciones.add(r);	
                                                                                        tblOpciones.startEditing(alOpciones.getCount()-1,1);
                                                                                  }
                                                                    }
                                                                    ,
                                                                    {
                                                                        text:'Eliminar Opci&oacute;n',
                                                                        icon:'../images/cancel_round.png',
                                                                        handler:function()
                                                                                {
                                                                                    var fila=tblOpciones.getSelectionModel().getSelectedCell();
                                                                                    if(fila!=null)
                                                                                    {
                                                                                        var posFila=alOpciones.getAt(fila[0]);
                                                                                        function funcConfirmDel(btn)
                                                                                        {
                                                                                            if(btn=="yes")
                                                                                            {
                                                                                                alOpciones.remove(posFila);
                                                                                            }
                                                                                        }
                                                                                        Ext.Msg.confirm('<?php echo $etj["lblAplicacion"] ?>','Est&aacute; seguro de querer eliminar esta opci&oacute;n?',funcConfirmDel);
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('Debe seleccionar la opci&oacute;n a remover');
                                                                                    }
                                                                                    
                                                                                }  
                                                                    }
                                                                    
                                                                  ]
                                                        }
                                                    );
    
    function funcEdicion(e)
    {
        if(e.field=='valorOpt')
        {
            var res=obtenerPosFila(e.grid.getStore(),'valorOpt',e.value);
            if((res!='-1')&&(e.row!=res))
            {
                function funcOK()
                {
                    e.record.set('valorOpt',e.originalValue);
                    e.grid.getView().refresh();
                    e.grid.startEditing(e.row,e.column);

                }
                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','La opci&oacute;n ingresada ya se encuentra registrada',funcOK);
            }
        }
    }
    tblOpciones.on('afteredit',funcEdicion);
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:10,
                                    items:	[
                                                tblOpciones
                                            ]
                                }
                            );
                            
   
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                                        panelGrid
                                                        
                                                    ]
                                        }
                                    );
    
    

    
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: 'Aceptar',
                                        minWidth:80,
                                        id:'btnAceptar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                        var resul=validarOpciones(tblOpciones.getStore(),tblOpciones);
                                                                            
                                                                        if(resul)
                                                                        {
                                                                            var opciones=obtenerValoresOpcionesManualesDR();
                                                                            
                                                                            function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                	ventanaPregCerradas.close();
                                                                                    recargarPagina();
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=70&objOpciones={"opciones":'+opciones+'}&idAccion='+idAccion,true);
                                                                            
                                                                            
                                                                            
                                                                        }
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    var ventanaPregCerradas = new Ext.Window(
                                            {
                                                title: 'Opciones de dictamen',
                                                width: <?php echo ($ancho+65-350) ?> ,
                                                height:400,
                                                minWidth: 300,
                                                minHeight: 100,
                                                layout: 'fit',
                                                plain:true,
                                                modal:true,
                                                bodyStyle:'padding:5px;',
                                                buttonAlign:'center',
                                                items: 	[
                                                            form
                                                        ],
                                                listeners : {
                                                            show : {
                                                                        buffer : 10,
                                                                        fn : function() 
                                                                        {
                                                                           
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                                btnSiguiente,
                                                                {
                                                                    text: 'Cancelar',
                                                                    handler:function()
                                                                    {
                                                                    	
                                                                        ventanaPregCerradas.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
	
    llenarOpcionesDictamenRevisores(ventanaPregCerradas,idGrupoElemento);

}

function llenarOpcionesDictamenRevisores(ventana,idGrupoElemento)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            Ext.getCmp('gridOpcionesManualesDR').getStore().loadData(arrDatos);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=72&idGrupoElemento='+idGrupoElemento,true);
}

function validarOpciones(dSet,tblEditor)
{
	var res=validarCampoNoVacio(tblOpciones.getStore(),'valorOpt');
	if(res!='-1')
	{
		function funcClickOk()
		{
			tblOpciones.startEditing(res-1,1);
			return false
		}
		Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','El contenido de esta celda no puede estar vac&iacute;a',funcClickOk);
	}
	else
	{
		var cm=tblEditor.getColumnModel();
		var idIdioma=gE('hLeng').value;
		var nomColumn='idioma_'+idIdioma;
		var posCol=cm.findColumnIndex(nomColumn);
		var x;
		var res=validarCampoNoVacio(dSet,nomColumn);
		if(res!='-1')
		{
			function funcClickOk()
			{
				tblEditor.startEditing(res-1,posCol);
				return false;
			}
			Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','El texto a mostrar como opci&oacute;n debe ser ingresado, al menos en su idioma',funcClickOk);	
			
		}
		else
		{
			var colName='';
            var numColums=cm.getColumnCount()-1;
           
            for(x=2;x<numColums;x++)
            {
                colName=cm.getDataIndex(x);
                if(colName!=nomColumn)
                {
                    res=validarCampoNoVacio(dSet,colName);
                    if(res!='-1')
                    {
                        function funcConfirmacion(btn)
                        {
                            if(btn=='yes')
                            {
                                for(x=2;x<cm.getColumnCount();x++)
                                {
                                    colName=cm.getDataIndex(x);
                                    if(colName!=nomColumn)
                                        rellenarValoresVaciosColumna(dSet,colName,nomColumn);
                                }
                                //Ext.getCmp('btnFinalizarPCerradas').fireEvent('click');
                            }
                            return false;
                        }
                        Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"] ?>', 'El texto a mostrar como opci&oacute;n no ha sido especificado en todos lo idiomas, desea continuar', funcConfirmacion);
                    }
                    else
                        return true;
                }
            }
            return true;
        	
		}
	}
    
    
}

function obtenerValoresOpcionesManuales()
{
	var opciones='';
    var cadTemp='';
    
    var tblOpciones=Ext.getCmp('gridOpcionesManuales');
    var cm=tblOpciones.getColumnModel();
    var ct=tblOpciones.getStore().getCount();
    var reg;
    var x;
    
    for(x=0;x<ct;x++)
    {
        reg=tblOpciones.getStore().getAt(x);
        var valColumnas=obtenerValoresColumnasRegistro(cm,reg);
        cadTemp='{"vOpcion":"'+cv(reg.get('valorOpt'))+'",'+
                '"columnas":['+valColumnas+'],'+
                '"etapa":"'+reg.get('numEtapa')+'"}';
        if(opciones=='')
            opciones=cadTemp;
        else
            opciones+=','+cadTemp;
    }
    return '['+opciones+']';
}

function obtenerValoresOpcionesManualesDR()
{
	var opciones='';
    var cadTemp='';
    
    var tblOpciones=Ext.getCmp('gridOpcionesManualesDR');
    var cm=tblOpciones.getColumnModel();
    var ct=tblOpciones.getStore().getCount();
    var reg;
    var x;
    
    for(x=0;x<ct;x++)
    {
        reg=tblOpciones.getStore().getAt(x);
        var valColumnas=obtenerValoresColumnasRegistroGR(cm,reg);
        cadTemp='{"vOpcion":"'+cv(reg.get('valorOpt'))+'",'+
                '"columnas":['+valColumnas+']}';
        if(opciones=='')
            opciones=cadTemp;
        else
            opciones+=','+cadTemp;
    }
    return '['+opciones+']';
}

function obtenerValoresOpcionesManualesDP()
{
	var opciones='';
    var cadTemp='';
    
    var tblOpciones=Ext.getCmp('gridOpcionesManuales');
    var cm=tblOpciones.getColumnModel();
    var ct=tblOpciones.getStore().getCount();
    var reg;
    var x;
    
    for(x=0;x<ct;x++)
    {
        reg=tblOpciones.getStore().getAt(x);
        var valColumnas=obtenerValoresColumnasRegistro(cm,reg);
        cadTemp='{"vOpcion":"'+cv(reg.get('valorOpt'))+'",'+
                '"columnas":['+valColumnas+'],'+
                '"accion":"'+reg.get('accion')+'"}';
        if(opciones=='')
            opciones=cadTemp;
        else
            opciones+=','+cadTemp;
    }
    return '['+opciones+']';
}

function obtenerValoresColumnasRegistro(cm,reg)
{
	var columnas='';
	var idLeng='';
	var tColum='';
	var x;
	for(x=2;x<cm.getColumnCount()-1;x++)
	{
		tColumn=cm.getDataIndex(x);
		idLeng=cm.getDataIndex(x).split('_')[1];
		if(columnas=='')
			columnas='{"idLeng":"'+idLeng+'","texto":"'+cv(reg.get(tColumn))+'"}';
		else
			columnas+=',{"idLeng":"'+idLeng+'","texto":"'+cv(reg.get(tColumn))+'"}';
	}
	return columnas;
}

function obtenerValoresColumnasRegistroGR(cm,reg)
{
	var columnas='';
	var idLeng='';
	var tColum='';
	var x;
    
	for(x=2;x<cm.getColumnCount();x++)
	{
		tColumn=cm.getDataIndex(x);
		idLeng=cm.getDataIndex(x).split('_')[1];
		if(columnas=='')
			columnas='{"idLeng":"'+idLeng+'","texto":"'+cv(reg.get(tColumn))+'"}';
		else
			columnas+=',{"idLeng":"'+idLeng+'","texto":"'+cv(reg.get(tColumn))+'"}';
	}
	return columnas;
}

function configurarDictamenParcial(idAccion,et,idGrupoElemento)
{
	
    var grupoElemento=null;
    if(idGrupoElemento!=undefined)
    	grupoElemento=idGrupoElemento;
    var dsOpciones= [<?php echo "[".$filaDefaultDP."]" ?>];
    alOpciones=		new Ext.data.SimpleStore(
                                                {
                                                    fields:	[
                                                                <?php 
                                                                    echo $camposDP;
                                                                ?>
                                                            ]
                                                }
                                            );
    
    alOpciones.loadData(dsOpciones);
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'Clave',
                                                            width:100,
                                                            dataIndex:'valorOpt',
                                                            editor: new Ext.form.TextField   (
                                                                                                    {
                                                                                                      
                                                                                                       style: 'text-align:left'
                                                                                                    }
                                                                                                )
                                                        }
                                                        ,
                                                        <?php 
                                                            echo $columnasDP;
                                                        ?>
                                                    ]
                                                );
    
    
    
    tblOpciones=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridOpcionesManuales',
                                                            store:alOpciones,
                                                            frame:true,
                                                            clicksToEdit: 1,
                                                            cm: cmFrmDTD,
                                                            height:300,
                                                            columnLines:true,
                                                            width:<?php echo $ancho+35 ?>,
                                                            title:'Ingrese los posibles valores de dict&aacute;men:'
                                                        }
                                                    );
    
    function funcEdicion(e)
    {
        if(e.field=='valorOpt')
        {
            var res=obtenerPosFila(e.grid.getStore(),'valorOpt',e.value);
            if((res!='-1')&&(e.row!=res))
            {
                function funcOK()
                {
                    e.record.set('valorOpt',e.originalValue);
                    e.grid.getView().refresh();
                    e.grid.startEditing(e.row,e.column);
                }
                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','La opci&oacute;n ingresada ya se encuentra registrada',funcOK);
            }
        }
    }
    tblOpciones.on('afteredit',funcEdicion);
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:10,
                                    items:	[
                                                tblOpciones
                                            ]
                                }
                            );
                            
   
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                                        panelGrid
                                                        
                                                    ]
                                        }
                                    );
    
    

    
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: 'Aceptar',
                                        minWidth:80,
                                        id:'btnAceptar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                        var resul=validarOpciones(tblOpciones.getStore(),tblOpciones);
                                                                            
                                                                        if(resul)
                                                                        {
                                                                            var opciones=obtenerValoresOpcionesManualesDP();
                                                                            
                                                                            function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                	ventanaPregCerradas.close();
                                                                                    recargarPagina();
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=69&objOpciones={"opciones":'+opciones+'}&idAccion='+idAccion,true);
                                                                            
                                                                            
                                                                            
                                                                        }
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    var ventanaPregCerradas = new Ext.Window(
                                            {
                                                title: 'Opciones de dictamen',
                                                width: <?php echo ($ancho+65) ?> ,
                                                height:470,
                                                minWidth: 300,
                                                minHeight: 100,
                                                layout: 'fit',
                                                plain:true,
                                                modal:true,
                                                bodyStyle:'padding:5px;',
                                                buttonAlign:'center',
                                                items: 	[
                                                            form
                                                        ],
                                                listeners : {
                                                            show : {
                                                                        buffer : 10,
                                                                        fn : function() 
                                                                        {
                                                                           
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                                btnSiguiente,
                                                                {
                                                                    text: 'Cancelar',
                                                                    handler:function()
                                                                    {
                                                                    	
                                                                        ventanaPregCerradas.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
	llenarOpcionesDictamenParcial(ventanaPregCerradas,idGrupoElemento);

}

function llenarOpcionesDictamenParcial(ventana,idGrupoElemento)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            Ext.getCmp('gridOpcionesManuales').getStore().loadData(arrDatos);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=71&idGrupoElemento='+idGrupoElemento,true);
}

function configurarDictamenFinal(idAccion,et,idGrupoElemento,idProceso)
{
	var arrEtapas=[];
    var grupoElemento=null;
    if(idGrupoElemento!=undefined)
    	grupoElemento=idGrupoElemento;
	var cmbPasaEtapa=crearComboExt('cmbPasaEtapa',arrEtapas);
    var dsOpciones= [<?php echo "[".$filaDefault."]" ?>];
    alOpciones=		new Ext.data.SimpleStore(
                                                {
                                                    fields:	[
                                                                <?php 
                                                                    echo $campos;
                                                                ?>
                                                            ]
                                                }
                                            );
    
    alOpciones.loadData(dsOpciones);
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'Clave',
                                                            width:100,
                                                            dataIndex:'valorOpt',
                                                            editor: new Ext.form.TextField   (
                                                                                                    {
                                                                                                      
                                                                                                       style: 'text-align:left'
                                                                                                    }
                                                                                                )
                                                        }
                                                        ,
                                                        <?php 
                                                            echo $columnas;
                                                        ?>
                                                    ]
                                                );
    
    
    
    tblOpciones=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridOpcionesManuales',
                                                            store:alOpciones,
                                                            frame:true,
                                                            clicksToEdit: 1,
                                                            cm: cmFrmDTD,
                                                            height:300,
                                                            columnLines:true,
                                                            width:<?php echo $ancho+35 ?>,
                                                            title:'Ingrese los posibles valores de dict&aacute;men:',
                                                            
                                                        }
                                                    );
    
    function funcEdicion(e)
    {
        if(e.field=='valorOpt')
        {
            var res=obtenerPosFila(e.grid.getStore(),'valorOpt',e.value);
            if((res!='-1')&&(e.row!=res))
            {
                function funcOK()
                {
                    e.record.set('valorOpt',e.originalValue);
                    e.grid.getView().refresh();

                    e.grid.startEditing(e.row,e.column);
                }
                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','La opci&oacute;n ingresada ya se encuentra registrada',funcOK);
            }
        }
    }
    tblOpciones.on('afteredit',funcEdicion);
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:10,
                                    items:	[
                                                tblOpciones
                                            ]
                                }
                            );
                            
   
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                                        panelGrid
                                                        
                                                    ]
                                        }
                                    );
    
    

    
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: 'Aceptar',
                                        minWidth:80,
                                        id:'btnAceptar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                        var resul=validarOpciones(tblOpciones.getStore(),tblOpciones);
                                                                            
                                                                        if(resul)
                                                                        {
                                                                            var opciones=obtenerValoresOpcionesManuales();
                                                                            function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                	ventanaPregCerradas.close();
                                                                                    recargarPagina();
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=53&objOpciones={"opciones":'+opciones+'}&idAccion='+idAccion,true);
                                                                            
                                                                            
                                                                            
                                                                        }
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    var ventanaPregCerradas = new Ext.Window(
                                            {
                                                title: 'Opciones de dictamen',
                                                width: <?php echo ($ancho+65) ?> ,
                                                height:470,
                                                minWidth: 300,
                                                minHeight: 100,
                                                layout: 'fit',
                                                plain:true,
                                                modal:true,
                                                bodyStyle:'padding:5px;',
                                                buttonAlign:'center',
                                                items: 	[
                                                            form
                                                        ],
                                                listeners : {
                                                            show : {
                                                                        buffer : 10,
                                                                        fn : function() 
                                                                        {
                                                                           
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                                btnSiguiente,
                                                                {
                                                                    text: 'Cancelar',
                                                                    handler:function()
                                                                    {
                                                                    	
                                                                        ventanaPregCerradas.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
	
	
	obtenerEtapasDisponibles(et,ventanaPregCerradas,cmbPasaEtapa.getStore(),true,grupoElemento,idProceso);
    
}

function formatearEtapa(val)
{
	var pos=existeValorMatriz(arrEtapas,val);
    if(pos>-1)
		return arrEtapas[pos][1];
    else
    	return val;
}

function obtenerEtapasDisponibles(et,ventana,almacen,ninguna,grupoElemento,idProceso)
{
	
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrEt=eval(arrResp[1]);
            if(ninguna!=undefined)
            	arrEt.push(['0','Ninguna']);
            almacen.loadData(arrEt);
            if(grupoElemento==null)
	            ventana.show();
            else
            	llenarOpcionesDictamen(grupoElemento,ventana);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=51&idProceso='+idProceso+'&numEtapa='+et,true);
}

function llenarOpcionesDictamen(idGrupoElemento,ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrParam=eval(arrResp[1]);
            Ext.getCmp('gridOpcionesManuales').getStore().loadData(arrParam);
        	ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=54&idElemento='+idGrupoElemento,true);


}