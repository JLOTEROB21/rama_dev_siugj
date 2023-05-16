<?php
	session_start();
	include("configurarIdiomaJS.php");
	$idFormulario=$_GET["idFormulario"];
	$idRegistro=$_GET["idRegistro"];
	$consulta="select id_243_lineasInvestigacion,txtLineaInv from 243_lineasInvestigacion where id_243_lineasInvestigacion not in 
				(select idLineaInvestigacion from 240_proyectosVSLineasInvestigacion la where la.idFormulario=".$idFormulario." and la.idReferencia=".$idRegistro.") order by txtLineaInv";
	$arrLineas=uEJ($con->obtenerFilasArreglo($consulta));
	
?>

function agregarLinea()
{
	
    var alLineas=		new Ext.data.SimpleStore(
                                                    {
                                                        fields:	[
                                                                 	{name:'idLinea'},
                                                                    {name:'lineaInv'}
                                                                ]
                                                    }
                                                );
    
    
    var dsLineas= <?php echo $arrLineas?>;
    
    alLineas.loadData(dsLineas);
    var chkRow=new Ext.grid.CheckboxSelectionModel();
    var cmLinea= new Ext.grid.ColumnModel   	(
                                                    [
                                                    	chkRow,
                                                        {
                                                            header:'L&iacute;nea de investigaci&oacute;n',
                                                            width:325,
                                                            dataIndex:'lineaInv'
                                                        }
                                                    ]
                                                );
    
    
    var tblLineas=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridLineas',
                                                            store:alLineas,
                                                            frame:true,
                                                            cm: cmLinea,
                                                            height:300,
                                                            width:390,
                                                            sm:chkRow,
                                                            title:'Elija las l&iacute;neas de investigaci&oacute;n que desea agregar:'
                                                            
                                                        }
                                                    );
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:10,
                                    items:	[
                                                tblLineas
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
                                                                    	
                                                                        var filas= tblLineas.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','Debe seleccionar al menos una l&iacute;nea de investigaci&oacute;n');
                                                                        	return;
                                                                        }
                                                                       
                                                                        var x;
                                                                        var arrLineas='';
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	if(arrLineas=='')
                                                                            	arrLineas=filas[x].get('idLinea');
                                                                            else
                                                                            	arrLineas+=','+filas[x].get('idLinea');
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
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcResp, 'POST','funcion=5&idFormulario='+idFormulario+'&idRegistro='+idRegistro+'&lineas='+arrLineas,true);
                                                                        
                                                                        
                                                                        
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
   
    
   
   	try
    {
        ventanaSelForm = new Ext.Window(
                                                {
                                                    title: 'Selecci&oacute;n de l&iacute;neas de investigaci&oacute;n',
                                                    width: 420 ,
                                                    constrain: true,
                                                    height:390,
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
    catch(ex)
    {
    	alert(ex);
    }

	
}

function removerLinea(idLinea)
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
                    
                    recargarPagina();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcResp, 'POST','funcion=6&idLinea='+idLinea,true);
        }
    }
    msgConfirmWin('Est&aacute; seguro de querer remover esta l&iacute;nea de investigaci&oacute;n?',resp);
}

function lineaPrincipalChange(cmbLinea)
{
	var idLinea=cmbLinea.options[cmbLinea.selectedIndex].value;
    var idRegistro=gE('idRegistro').value;
    var idFormulario=gE('idFormulario').value;
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
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=115&idLinea='+idLinea+'&idFormulario='+idFormulario+'&idRegistro='+idRegistro,true);
}