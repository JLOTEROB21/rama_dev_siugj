<?php
	session_start();
	include("configurarIdiomaJS.php");
	$idFormulario=$_GET["idFormulario"];
	$idRegistro=$_GET["idRegistro"];
	$consulta="select idProceso from 900_formularios where idFormulario=".$idFormulario;
	$idProceso=$con->obtenerValor($consulta);
	$consulta="select f.idFormulario from 203_elementosDTD e,900_formularios f where f.idFormulario=e.idFormulario and f.tipoFormulario=10 and f.titulo=2 and  e.idProceso=".$idProceso;
	$idFrmLineaInv=$con->obtenerValor($consulta);
	$consulta="select id_244_lineasAccion,txtLineaAccion from 244_lineasAccion where id_244_lineasAccion not in 
					(select idLineaAccion from 241_proyectosVSLineasAccion la where la.idFormulario=".$idFormulario." and la.idReferencia=".$idRegistro.")";
	if($idFrmLineaInv=="")
	{
		$consulta="select id_244_lineasAccion,txtLineaAccion from 244_lineasAccion where id_244_lineasAccion not in 
					(select idLineaAccion from 241_proyectosVSLineasAccion la where la.idFormulario=".$idFormulario." and la.idReferencia=".$idRegistro.")";
		$vincularLineasInv=false;
	}
	else
	{
		$consulta="select id_244_lineasAccion,txtLineaAccion from 244_lineasAccion";
		$vincularLineasInv=true;
	}

	$arrLineas=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select id_243_lineasInvestigacion,txtLineaInv from 240_proyectosVSLineasInvestigacion pl,243_lineasInvestigacion where id_243_lineasInvestigacion=pl.idLineaInvestigacion and pl.idFormulario=".$idFormulario." and pl.idReferencia=".$idRegistro;
	$arrLineasInv=uEJ($con->obtenerFilasArreglo($consulta));
	
?>

function agregarLinea()
{
	
    var cmbLineasInvestigacion=crearComboExt('cmbLineasInvestigacion',<?php echo $arrLineasInv?>,260,330);
    cmbLineasInvestigacion.setWidth(300);
    var alLineas=		new Ext.data.SimpleStore(
                                                    {
                                                        fields:	[
                                                                 	{name:'idLinea'},
                                                                    {name:'lineaAccion'}
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
                                                            header:'L&iacute;nea de acci&oacute;n',
                                                            width:465,
                                                            dataIndex:'lineaAccion'
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
                                                            width:560,
                                                            sm:chkRow,
                                                            title:'Elija las l&iacute;neas de acci&oacute;n que desea agregar:'
                                                            
                                                        }
                                                    );
    
    <?php
		if($vincularLineasInv)
		{
			$ocultarLineaAccion='false';
			echo "cmbLineasInvestigacion.show();";
		}
		else
		{
			$ocultarLineaAccion='true';
			echo "cmbLineasInvestigacion.hide();";
		}
	?>
    
    
    
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:5,
                                    x:5,
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
                                            			{
                                                        	xtype:'label',
                                                            x:10,
                                                            y:330,
                                                            hidden:<?php echo $ocultarLineaAccion?>,
                                                            html:'Vincular las l&iacute;neas de acci&oacute;n seleccionadas <br />con la siguiente l&iacute;nea de investigaci&oacute;n:'
                                                        },
                                                        cmbLineasInvestigacion,
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
                                                                        	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','Debe seleccionar al menos una l&iacute;nea de acci&oacute;n');
                                                                        	return;
                                                                        }
                                                                        var idLineaInv=cmbLineasInvestigacion.getValue();
                                                                        
                                                                        
                                                                        if(cmbLineasInvestigacion.isVisible()&&(idLineaInv==''))
                                                                        {
                                                                        	msgBox('Debe seleccionar la l&iacute;nea de investigaci&oacute;n con la cual se vincular&aacute;n las l&iacute;neas de acci&oacute;n seleccionadas');
	                                                                        return;
                                                                        }
                                                                        if(idLineaInv=='')
                                                                        	idLineaInv='-1';
                                                                            
                                                                        var x;
                                                                        var arrLineas='';
                                                                        var fLinea;
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
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcResp, 'POST','funcion=3&idFormulario='+idFormulario+'&idRegistro='+idRegistro+'&lineas='+arrLineas+'&idLineaInv='+idLineaInv,true);
                                                                        
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

function removerLinea(idLinea,idInv)
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
                    if(idInv==undefined)    
	                   	var fila=gE('fila_'+idLinea);
                   	else
                    	var fila=gE('fila_'+idLinea+'_'+idInv);
                   	fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcResp, 'POST','funcion=4&idLinea='+idLinea,true);
        }
    }
    msgConfirmWin('Est&aacute; seguro de querer remover esta l&iacute;nea de acci&oacute;n?',resp,360,140);
}