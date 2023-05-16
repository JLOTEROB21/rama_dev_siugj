<?php
	session_start();
	include("configurarIdiomaJS.php");
	$idFormulario=$_GET["idFormulario"];
	$idRegistro=$_GET["idRegistro"];
	$consulta="select idProceso from 900_formularios where idFormulario=".$idFormulario;
	$idProceso=$con->obtenerValor($consulta);
	$consulta="select centroCosto from 986_vinculacionCC cc where cc.idFormulario=".$idFormulario." and cc.idReferencia=".$idRegistro;
	$codigosCC=$con->obtenerListaValores($consulta,"'");
	if($codigosCC=='')
		$codigosCC="-1";
	$consulta="select codigoCompleto,codigo,tituloCentroC from 506_centrosCosto where codigoCompleto not in 
					(".$codigosCC.")";
	//echo $consulta;
	$arrCC=uEJ($con->obtenerFilasArreglo($consulta));
	
	
?>

function agregarCC()
{
	
    
    var alDatos=		new Ext.data.SimpleStore(
                                                    {
                                                        fields:	[
                                                                 	{name:'codigoCompleto'},
                                                                    {name: 'codigo'},
                                                                    {name:'tituloCentroC'}
                                                                ]
                                                    }
                                                );
    
    
    var dsDatos= <?php echo $arrCC?>;
    
    alDatos.loadData(dsDatos);
    var chkRow=new Ext.grid.CheckboxSelectionModel();
    var cmLinea= new Ext.grid.ColumnModel   	(
                                                    [
                                                    	chkRow,
                                                        {
                                                            header:'C&oacute;digo',
                                                            width:165,
                                                            dataIndex:'codigo'
                                                        },
                                                        {
                                                            header:'Centro de costo',
                                                            width:300,
                                                            dataIndex:'tituloCentroC'
                                                        }
                                                    ]
                                                );
    
    
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridCentro',
                                                            store:alDatos,
                                                            frame:true,
                                                            cm: cmLinea,
                                                            height:300,
                                                            width:560,
                                                            sm:chkRow,
                                                            title:'Elija el centro de costo que desea agregar:'
                                                            
                                                        }
                                                    );
    
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:5,
                                    x:5,
                                    items:	[
                                    			
                                                tblGrid
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
                                                                        var filas= tblGrid.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','Debe seleccionar al menos un centro de costo');
                                                                        	return;
                                                                        }
                                                                       
                                                                        var x;
                                                                        var arrCC='';
                                                                        var fLinea;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	if(arrCC=='')
                                                                            	arrCC=filas[x].get('codigoCompleto');
                                                                            else
                                                                            	arrCC+=','+filas[x].get('codigoCompleto');
                                                                        }
                                                                        
                                                                        var idRegistro=gE('idRegistro').value;
                                                                        var idFormulario=gE('idFormulario').value;
                                                                        function funcResp()
                                                                        {
                                                                            var arrResp=peticion_http.responseText.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	if(typeof(funcAgregar)!='undefined')
                                                                                	funcAgregar();
                                                                               recargarPagina();
                                                                                ventanaSelForm.close();  
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcResp, 'POST','funcion=213&idFormulario='+idFormulario+'&idRegistro='+idRegistro+'&centros='+arrCC,true);
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaSelForm = new Ext.Window(
                                            {
                                                title: 'Selecci&oacute;n de l&iacute;neas de acci&oacute;n',
                                                width: 600 ,
                                                height:460,
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
                                                                    text: '<?php echo $etj["lblBtnCancelar"] ?>',
                                                                    handler:function()
                                                                    {
                                                                    	
                                                                        ventanaSelForm.close();
                                                                        
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
	ventanaSelForm.show();
	
}

function removerCC(idCentro)
{
	function resp(btn)
    {
    	if(btn=='yes')
        {
        	function funcResp()
            {
                var arrResp=peticion_http.responseText.split('|');
                if(arrResp[0]=='1')
                {
                	if(typeof(funcAgregar)!='undefined')
	                   	funcAgregar();
                    var fila=gE('fila_'+idCentro);
                   	
                   	fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcResp, 'POST','funcion=214&idCentro='+idCentro,true);
        }
    }
    msgConfirmWin('Est&aacute; seguro de querer remover el centro de costo seleccionado?',resp,360,140);
}