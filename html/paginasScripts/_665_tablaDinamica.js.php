<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idProceso=bD($_GET["iPP"]);
	$idReferencia=$_GET["iRef"];
	
	$fechaActual=date("Y-m-d");
	
	$horaActual=date("H:i");
	
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos order by nombreCategoria";
	$arrCategorias=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT claveElemento,nombreElemento FROM 1018_catalogoVarios WHERE tipoElemento=37 ORDER BY nombreElemento";
	$arrTiposPersonas=$con->obtenerFilasArreglo($consulta);
	
	$carpetaAdministrativa='';
	$arrDocumentos='';
	$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas c,_665_tablaDinamica s
			WHERE c.carpetaAdministrativa=s.carpetaAdministrativa AND s.id__665_tablaDinamica=".$idRegistro;
	$idActividad=$con->obtenerValor($consulta);

	$consulta="SELECT id__5_tablaDinamica FROM _5_tablaDinamica";
	$listPartes=$con->obtenerListaValores($consulta);
	$arrTiposNotificacion="[]";
	$existeProcesoPadre=false;
	$idTipoDocumentoPrincipal=-1;
	$esSolicitudEmbargo=0;	
	$arrDestinatarios="[]";	
	if(($idProceso!=-1)&&($idProceso!=""))
	{

		$idFormularioBase=obtenerFormularioBase($idProceso);
		$nombreTabla=obtenerNombreTabla($idFormularioBase);
		$consulta="SELECT carpetaAministrativaOrdenNotificacion,tipoNotificacionOrdenNotificacion,idTipoDocumentoPrincipal FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idReferencia;
		$fNotificacionBase=$con->obtenerPrimeraFilaAsoc($consulta);
		$carpetaAdministrativa=$fNotificacionBase["carpetaAministrativaOrdenNotificacion"];
		$tipoNotificacion=$fNotificacionBase["tipoNotificacionOrdenNotificacion"];
		$idTipoDocumentoPrincipal=$fNotificacionBase["idTipoDocumentoPrincipal"];
		$existeProcesoPadre=true;
	
		$consulta="SELECT id__666_tablaDinamica,tipoNotificacion FROM _666_tablaDinamica WHERE id__666_tablaDinamica=".$tipoNotificacion;
		$arrTiposNotificacion=$con->obtenerFilasArreglo($consulta);
		
		$x=0;

		$consulta="SELECT idDocumento FROM 9074_documentosRegistrosProceso WHERE idFormulario=".$idFormularioBase." AND idRegistro=".$idReferencia;
		$rDocumentos=$con->obtenerFilas($consulta);
		while($fDocumento=mysql_fetch_assoc($rDocumentos))
		{
			
			$consulta="SELECT nomArchivoOriginal,tamano,categoriaDocumentos FROM 908_archivos WHERE idArchivo=".$fDocumento["idDocumento"];
			$fDatosDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
			$oDocumento='{"idRegistro":"'.$x.'","idReferencia":"-1","idDocumento":"'.$fDocumento["idDocumento"].'","nombreDocumento":"'.
					cv($fDatosDocumento["nomArchivoOriginal"]).'","tamanoDoc":"'.$fDatosDocumento["tamano"].'","categoriaDocumento":"'.$fDatosDocumento["categoriaDocumentos"].'"}';
				
			
			if($arrDocumentos=="")
				$arrDocumentos=$oDocumento;
			else
				$arrDocumentos.=",".$oDocumento;
			
			$x++;
		}
		
		if($idFormularioBase=="708")
		{
			$consulta="SELECT idProcesoPadre,idReferencia FROM _708_tablaDinamica WHERE id__708_tablaDinamica=".$idReferencia;
			$fRegistroSolicitudNotificacion=$con->obtenerPrimeraFilaAsoc($consulta);
			if($fRegistroSolicitudNotificacion["idProcesoPadre"]==373)
			{
				$consulta="SELECT bienEmbargado FROM _1140_tablaDinamica WHERE id__1140_tablaDinamica=".$fRegistroSolicitudNotificacion["idReferencia"];
				$bienEmbargado=$con->obtenerValor($consulta);
				
				$esSolicitudEmbargo=1;
				switch($bienEmbargado)
				{
					case 1:
						$consulta="SELECT (e.idUsuario*-1) as idUsuario,e.nombreOficinaEntidades,(SELECT Mail FROM 805_mails WHERE idUsuario=e.idUsuario) AS email  
									FROM _1141_tablaDinamica tb,_1141_notificacionInmueble n,_1138_tablaDinamica e WHERE
									e.id__1138_tablaDinamica=n.nombreOficinaInmueble AND n.idReferencia=tb.id__1141_tablaDinamica and tb.idReferencia=".
									$fRegistroSolicitudNotificacion["idReferencia"].
									" ORDER BY e.nombreOficinaEntidades";
					break;
					case 2:
						$consulta="SELECT (e.idUsuario*-1) as idUsuario,e.nombreOficinaEntidades,(SELECT Mail FROM 805_mails WHERE idUsuario=e.idUsuario) AS email 
									 FROM _1142_tablaDinamica tb,_1142_notificacionAutomotor n,_1138_tablaDinamica e WHERE
									e.id__1138_tablaDinamica=n.nombreOficinaAutomotor AND n.idReferencia=tb.id__1142_tablaDinamica and tb.idReferencia=".
									$fRegistroSolicitudNotificacion["idReferencia"].
									" ORDER BY e.nombreOficinaEntidades";
					break;
					case 3:
						$consulta="SELECT id__1145_tablaDinamica,razonSocialSalarioHonorarios,correoElectronicoSalarioHonorarios FROM _1145_tablaDinamica 
									WHERE idReferencia=".$fRegistroSolicitudNotificacion["idReferencia"];
					break;
					case 4:
						$consulta="SELECT (e.idUsuario*-1) as idUsuario,e.nombreOficinaEntidades, (SELECT Mail FROM 805_mails WHERE idUsuario=e.idUsuario) AS email 
									 FROM _1143_tablaDinamica tb,_1143_notificacionCuentaBancaria n,
									_1138_tablaDinamica e WHERE
									e.id__1138_tablaDinamica=n.nombreOficinaCuentaBancaria AND n.idReferencia=tb.id__1143_tablaDinamica and 
									tb.idReferencia=".$fRegistroSolicitudNotificacion["idReferencia"].
									" ORDER BY e.nombreOficinaEntidades";
					break;
					case 5:
						$consulta="SELECT (e.idUsuario*-1) as idUsuario,e.nombreOficinaEntidades, (SELECT Mail FROM 805_mails WHERE idUsuario=e.idUsuario) AS email 
									 FROM _1144_tablaDinamica tb,_1144_notificacionEstablecimiento n,
									_1138_tablaDinamica e WHERE
									e.id__1138_tablaDinamica=n.nombreOficinaEstablecimiento AND n.idReferencia=tb.id__1144_tablaDinamica and 
									tb.idReferencia=".$fRegistroSolicitudNotificacion["idReferencia"].
									" ORDER BY e.nombreOficinaEntidades";
					break;
				}
				$arrDestinatarios=$con->obtenerFilasArreglo($consulta);

				
			}
			
			
		}
	}
	
	
	$consulta="SELECT id__998_tablaDinamica,nombreInstitucionEmpresa,email FROM _998_tablaDinamica ORDER BY nombreInstitucionEmpresa";
	$arrInstituciones=$con->obtenerFilasArreglo($consulta);

	if($idRegistro!=-1)
	{
		$consulta="SELECT carpetaAdministrativa,expedienteDespacho FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$fRegistroBase=$con->obtenerPrimeraFila($consulta);
		$carpetaAdministrativa=$fRegistroBase[0];
		$expedienteDespacho=$fRegistroBase[1];
		if($expedienteDespacho=="")
		{
			$consulta="update _665_tablaDinamica set expedienteDespacho=carpetaAdministrativa WHERE id__665_tablaDinamica=".$idRegistro;
			$con->ejecutarConsulta($consulta);
		}
	}
	
	$consulta="SELECT id__1138_tablaDinamica,nombreOficinaEntidades,(SELECT Mail FROM 805_mails WHERE idUsuario=t.idUsuario) AS email 
				FROM _1138_tablaDinamica t ORDER BY nombreOficinaEntidades";
	$arrEntidadesEmbargo=$con->obtenerFilasArreglo($consulta);


?>
var esSolicitudEmbargo=<?php echo $esSolicitudEmbargo?>;
var arrDestinatarios=<?php echo $arrDestinatarios?>;
var arrEntidadesEmbargo=<?php echo $arrEntidadesEmbargo?>;
var idTipoDocumentoPrincipal=<?php echo $idTipoDocumentoPrincipal?>;
var arrInstituciones=<?php echo $arrInstituciones?>;
var arrTiposNotificacion=<?php echo $arrTiposNotificacion?>;
var arrDocumentos=[<?php echo $arrDocumentos?>];
var existeProcesoPadre=<?php echo $existeProcesoPadre?"true":"false"?>;
var carpetaAdministrativaRef='<?php echo $carpetaAdministrativa?>';
var idActividad='<?php echo $idActividad?>';
var listPartes='<?php echo $listPartes?>';
var arrTiposPersonas=<?php echo $arrTiposPersonas?>;
var idCarpeta=-1;
var carpetaAdministrativa='';
var arrCategorias=<?php echo $arrCategorias?>;
var arrEtapasProcesales=[];

var regDestinatario=crearRegistro	(
                                          [
                                              {name: 'idRegistro'},
                                              {name: 'idReferencia'},
                                              {name:'tipoPersona'},
                                              {name:'nombrePersona'},
                                              {name:'email'},
                                              {name:'idPersona'}
                                           ]
              
                                      );

function inyeccionCodigo()
{

    if(esRegistroFormulario())
    {
      	var x;
      	if((gE('idRegistroG').value=='-1')&&(existeProcesoPadre))
        {
        	 var reg=crearRegistro	(
                                        [
                                            {name: 'idRegistro'},
                                            {name: 'idReferencia'},
                                            {name:'idDocumento'},
                                            {name:'nombreDocumento'},
                                            {name:'tamanoDoc'},
                                            {name:'categoriaDocumento'}
                                        ]
                                    );
            
            for(x=0;x<arrDocumentos.length;x++)
            {
            	
               var r=new reg	(
                                        {
                                            idRegistro:'-1',
                                            idReferencia:-1,
                                            idDocumento:arrDocumentos[x].idDocumento,
                                            nombreDocumento:arrDocumentos[x].nombreDocumento,
                                            tamanoDoc:arrDocumentos[x].tamanoDoc,
                                            categoriaDocumento:arrDocumentos[x].categoriaDocumento
                                        }
                                    )

                gEx('grid_10680').getStore().add(r);
                
                
            }
            
            
            for(x=0;x<arrDestinatarios.length;x++)
            {
                r=new regDestinatario	(
                                          {
                                              idRegistro:-1,
                                              idReferencia:-1,
                                              tipoPersona:'4',
                                              nombrePersona:arrDestinatarios[x][1],
                                              email:arrDestinatarios[x][2],
                                              idPersona:arrDestinatarios[x][0]
                                          }
                                      );
      		
            	 gEx('grid_10687').getStore().add(r);
            }
  
         
            
            gEN('_idTipoDocumentoPrincipalvch')[0].value=idTipoDocumentoPrincipal;
            
			
            if(carpetaAdministrativaRef!='')
        	{

            	gEx('ext__expedienteDespachovch').setRawValue(carpetaAdministrativaRef);
                gE('_expedienteDespachovch').value=carpetaAdministrativaRef;
                gEx('ext__expedienteDespachovch').disable();
                funcionEventoCambio(gEx('ext__expedienteDespachovch'),true);
            }
            
            
            
        }
        
        
        gEx('ext__expedienteDespachovch').on('select',function(cmb,registro)
        											{

                                                    	carpetaAdministrativa=registro.data.id;
                                                    	gEN('_carpetaAdministrativavch')[0].value=registro.data.id;
                                                    }
        									)
        
        
        if(carpetaAdministrativaRef!='')
        {
          	
          	carpetaAdministrativa=carpetaAdministrativaRef;
          	gEN('_carpetaAdministrativavch')[0].value=carpetaAdministrativaRef;
        }
      
        gEx('btnAdd_grid_10680').setHandler(function()
                                              {
                                                  mostrarVentanaDocumentos();
                                              }
                                          )
        gEx('btnAdd_grid_10687').setHandler(function()
                                              {
                                                  mostrarVentanaAgregarPersonaNotificar();
                                              }
                                          )
      
      
       	asignarEvento(gE('_tipoNotificacionvch'),'change',function(combo)
                                                                        {
                                                                           
                                                                            var opcionSel=combo.options[combo.selectedIndex].value;
                                                                            function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                	CKEDITOR.instances.txt_cuerpoNotificacionvch.setData(bD(arrResp[1]));
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax, 'POST','funcion=2&cA='+carpetaAdministrativa+'&tN='+opcionSel,true);

                                                                        }
                                                        ); 
      
        
	
    	if(existeProcesoPadre)
        {
        	llenarCombo(gE('_tipoNotificacionvch'),arrTiposNotificacion,false);
            gE('_tipoNotificacionvch').options[0]=null;
            lanzarEvento(gE('_tipoNotificacionvch'),'change');
            
            asignarEvento(gE('opt_medioNotificacionvch_1'),'click',function(combo)
            													{
                                                                	lanzarEvento(gE('_tipoNotificacionvch'),'change');
                                                                }
                         )
            
        	 asignarEvento(gE('opt_medioNotificacionvch_3'),'click',function(combo)
            													{
                                                                	lanzarEvento(gE('_tipoNotificacionvch'),'change');
                                                                }
                         )
                                                          
        }
        
        if((gE('idRegistroG').value=='-1')&&(esSolicitudEmbargo=='1'))
        {
        	setTimeout(function()
            			{
                            gE('_tipoNotificacionvch').options[0]=null;
                            selElemCombo(gE('_tipoNotificacionvch'),'14');
                            lanzarEvento(gE('_tipoNotificacionvch'),'change');
						}
                      , 2000);            
        }
        
         	
    }
    else
    {
    	
     	
        
        if(gE('sp_10672').innerHTML=='Física')
        {
        	oE('div_10683');
            oE('div_10688');
            oE('div_10689');
        	oE('div_10684');
        }
        
        
        if(gE('sp_10684').innerHTML!='Programada')
        {
        	oE('div_10685');
            oE('div_10686');
        }
       
    }
    	
    
  	
	
	gEx('grid_10680').getColumnModel().setRenderer( 1, function(val,meta,registro,rowIndex)
    													{
                                                        	return '<a href="javascript:mostrarDocumentoAdjunto(\''+bE(rowIndex)+'\')">'+val+'</a>';
                                                        }
    											 )
	gEx('grid_10680').getColumnModel().setRenderer( 2, function(val)
    													{
                                                        	return bytesToSize(parseInt(val),0);
                                                        }
    											 )
}


function mostrarVentanaDocumentos()
{
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
                                            cls:'panelSiugj',
                                            tbar:	[
                                                        {
                                                            xtype:'label',
                                                           	cls:'letraNombreTablero',
                                                            html:'Origen de los documentos:&nbsp;&nbsp;'
                                                        },
                                                        {
                                                        	html:'<div id="divComboOrigen"></div>'
                                                        },
                                                        {
                                                        	xtype:'tbspacer',
                                                            width:10
                                                        }
                                                        ,
                                                        {
                                                            icon:'../images/add.png',
                                                            cls:'x-btn-text-icon',
                                                            height:35,
                                                            text:'Adjuntar documento',
                                                            handler:function()
                                                                    {
                                                                        mostrarVentanaAdjuntarDocumento()
                                                                    }
                                                            
                                                        }
                                                    ],
											items: 	[
                                            			crearGridDocumentos()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar documentos',
										width: 950,
										height:450,
										layout: 'fit',
										plain:true,
                                        cls:'msgHistorialSIUGJ',
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	var cmbOridenDocumentos=crearComboExt('cmbOridenDocumentos',[['1','Proceso Judicial']],0,0,250,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboOrigen'});
                                                                    cmbOridenDocumentos.setValue('1');
                                                                    cmbOridenDocumentos.on('select',function(cmb,registro)
                                                                                                    {
                                                                                                        switch(parseInt(registro.data.id))
                                                                                                        {
                                                                                                            case 1:
                                                                                                                gEx('gridDocumentos').getStore().load	(
                                                                                                                                                            {
                                                                                                                                                                url:'funcionesModulosEspeciales_SGP',
                                                                                                                                                                parms:	{
                                                                                                                                                                            funcion:19,
                                                                                                                                                                            cA:bE(carpetaAdministrativa),
                                                                                                                                                                            idCarpetaAdministrativa:idCarpeta
                                                                                                                                                                        }
                                                                                                                                                            }
                                                                                                                                                        )
                                                                                                                
                                                                                                            break;
                                                                                                        }
                                                                                                    }
                                                                                        )
                                                                                        
                                                                                        
                                                                	dispararEventoSelectCombo('cmbOridenDocumentos');                        
																}
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
                                                                    	var f;
                                                                    	var listaDocumentos='';
																		var filas=gEx('gridDocumentos').getSelectionModel().getSelections();
                                                                        var x;
                                                                        var f;
                                                                        var pos;
                                                                        var reg=crearRegistro	(
                                                                        							[
                                                                                                    	{name: 'idRegistro'},
                                                                                                        {name: 'idReferencia'},
                                                                                                        {name:'idDocumento'},
                                                                                                        {name:'nombreDocumento'},
                                                                                                        {name:'tamanoDoc'},
                                                                                                        {name:'categoriaDocumento'}
                                                                                                    ]
                                                                        						);
                                                                        
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	f=filas[x];
                                                                        	pos=obtenerPosFila(gEx('grid_10680').getStore(),'idDocumento',f.data.idDocumento)
                                                                        	if(pos==-1)
                                                                            {
                                                                            	
                                                                            	var r=new reg	(
                                                                                					{
                                                                                                    	idRegistro:-1,
                                                                                                        idReferencia:-1,
                                                                                                        idDocumento:f.data.idDocumento,
                                                                                                        nombreDocumento:f.data.nomArchivoOriginal,
                                                                                                        tamanoDoc:f.data.tamano,
                                                                                                        categoriaDocumento:f.data.categoriaDocumentos
                                                                                                    }
                                                                                				)
                                                                            
                                                                            	gEx('grid_10680').getStore().add(r);
                                                                            }
                                                                        	
                                                                        }
                                                                        
                                                                        ventanaAM.close();
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
    
}

function crearGridDocumentos()
{
	
    
    
	var cmbTipoDocumento=crearComboExt('cmbTipoDocumento',arrCategorias);
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDocumento'},
		                                                {name: 'etapaProcesal'},
		                                                {name:'nomArchivoOriginal'},
		                                                {name: 'tamano'},
                                                        {name: 'fechaRegistro', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'descripcion'},
                                                        {name:'idFormulario'},
                                                        {name:'idRegistro'},
                                                        {name:'idDocumento'},
                                                        {name: 'categoriaDocumentos'}
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
                                                sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                groupField: 'fechaRegistro',
                                                remoteGroup:false,
                                                remoteSort: false,
                                                autoLoad:false
                                                
                                            }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='19';
                                        proxy.baseParams.cA=bE(carpetaAdministrativa);
                                        proxy.baseParams.idCarpetaAdministrativa=idCarpeta;
                                    }
                        )   
       
    
    
    var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[ 
                                                        				{type: 'date', dataIndex: 'fechaCreacion'},
                                                                        {type: 'string', dataIndex: 'nomArchivoOriginal'},
                                                                        {type: 'list', dataIndex: 'categoriaDocumentos', phpMode:true, options:arrCategorias}
                                                                    ]
                                                    }
                                                );    
       
	

	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                    	new  Ext.grid.RowNumberer({width:40}),
                                                        chkRow,
                                                        {
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'idDocumento',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                                                        return '<img src="../imagenesDocumentos/16/file_extension_'+arrNombre[1].toLowerCase()+'.png" />'
                                                                    }
                                                        },
                                                        {
                                                            header:'Fecha de registro',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'fechaRegistro',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
                                                                    		return val.format('d/m/Y');
                                                                    }
                                                        },
                                                        {
                                                            header:'Tipo documento',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'categoriaDocumentos',
                                                            editor:cmbTipoDocumento,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrCategorias,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Etapa procesal',
                                                            width:280,
                                                            hidden:true,
                                                            sortable:true,
                                                            dataIndex:'etapaProcesal',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrEtapasProcesales,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Documento',
                                                            width:450,
                                                            sortable:true,
                                                            dataIndex:'nomArchivoOriginal',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        
                                                        {
                                                            header:'Tama&ntilde;o',
                                                            width:100,
                                                            sortable:true,
                                                            dataIndex:'tamano',
                                                            renderer:function(val)
                                                            		{
                                                                    	return bytesToSize(parseInt(val),0);
                                                                    }
                                                        }
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridDocumentos',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            sm:chkRow,
                                                            cls:'gridSiugjPrincipal',
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            
                                                            columnLines : false,  
                                                            plugins:[filters],   
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :false,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: false,
                                                                                                startCollapsed:false,
                                                                                                groupTextTpl:'<span style="color:#900"><b>{text}</b> ({[values.rs.length]} {[values.rs.length > 1 ? "Documentos" : "Documento"]})</span>'
                                                                                            })
                                                        }
                                                    );
                                                    
	
    
    
    tblGrid.on('rowdblclick',function(grid,rowIndex)
                              {
                              		var registro=grid.getStore().getAt(rowIndex);
                                    var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                  	window.parent.mostrarVisorDocumentoProceso(arrNombre[1].toLowerCase(),registro.data.idDocumento,registro);
                                  
                              }
                  )                                                    
                                                    
    return 	tblGrid;	
}

function mostrarDocumentoAdjunto(rowIndex)
{
	var registro=gEx('grid_10680').getStore().getAt(bD(rowIndex));
   	var arrNombre=registro.data.nombreDocumento.split('.');
   	window.parent.mostrarVisorDocumentoProceso(arrNombre[1].toLowerCase(),registro.data.idDocumento,registro);
}

function mostrarVentanaAdjuntarDocumento()
{

	

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	xtype:'label',
                                                            x:10,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Tipo de documento a adjuntar:'
                                                        },
                                                        {
                                                            x:280,
                                                            y:15,                                                                                            
                                                            html:'<div id="dComboTipoDocumental"></div>'
                                                        },
                                                        
                                                      
                                                          {
                                                              xtype:'label',
                                                              x:10,
                                                              y:70,
                                                              cls:'SIUGJ_Etiqueta',
                                                              html:'Documento a adjuntar:'
                                                          },
                                                          {
                                                            x:280,
                                                            y:65,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right"><span style="font-size:11px" class="SIUGJ_Etiqueta">Porcentaje de avance:</span> <span style="font-size:11px" id="porcentajeAvance" class="SIUGJ_Etiqueta"> 0%</span></td></tr></table>'
                                                        },
                                                       
                                                        {
                                                            x:590,
                                                            y:63,
                                                            id:'btnUploadFile',
                                                            width:120,
                                                            icon:'../images/add.png',
                                                            
                                                            xtype:'button',
                                                            cls:'btnSIUGJCancel',
                                                            text:'Seleccionar',
                                                            handler:function()
                                                                    {
                                                                        $('#containerUploader').click();
                                                                    }
                                                        },
							 							{
                                                            x:185,
                                                            y:10,
                                                            hidden:true,
                                                            html:	'<div id="containerUploader"></div>'
                                                        },
                                                        
                                                        {
                                                            x:290,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'idArchivo'

                                                        },
                                                        {
                                                            x:290,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'nombreArchivo'
                                                        } ,
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:70,
                                                            hidden:true,
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	xtype:'textarea',
                                                            x:10,
                                                            y:100,
                                                            hidden:true,
                                                            width:600+ventanaAdjuntaDocumento,
                                                            height:60,
                                                            id:'txtDescripcion'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Adjuntar documento',
										width: 750,
                                        cls:'msgHistorialSIUGJ',
                                        id:'vDocumento',
										height:250,
										layout: 'fit',
										plain:true,
										modal:false,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	
                                                                	var cObj={
                                                                    // Backend settings
                                                                                            upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                                                                                            file_post_name: "archivoEnvio",
                                                                             
                                                                                            // Flash file settings
                                                                                            file_size_limit : "1000 MB",
                                                                                            file_types : "*.pdf;*.jpg;*.jpeg;*.gif;*.png",			// or you could use something like: "*.doc;*.wpd;*.pdf",
                                                                                            file_types_description : "Todos los archivos",
                                                                                            file_upload_limit : 0,
                                                                                            file_queue_limit : 1,
                                                                             
                                                                                            
                                                                                            upload_success_handler : subidaCorrecta,
                                                                                            
                                                                                        };
                                                                
																	 var cmbTipoDocumento=crearComboExt('cmbTipoDocumento',arrCategorias,0,0,400,{renderTo:'dComboTipoDocumental',ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl'});

                                                                      
                                                                        

                                                                		crearControlUploadHTML5(cObj);
                                                                }
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
                                                                    	var cmbTipoDocumento=gEx('cmbTipoDocumento');
                                                                    	if(cmbTipoDocumento.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	cmbTipoDocumento.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de documento adjuntar');
                                                                            return;
                                                                        }
                                                                    	
																		
                                                                        if(uploadControl.files.length==0)
                                                                        {
                                                                            msgBox('Debe ingresar el documento que desea adjuntar');
                                                                            return;
                                                                        }
                                                                        uploadControl.start();
																	}
														}
														
													]
									}
								);
	ventanaAM.show();
}

function subidaCorrecta(file, serverData) 
{


    file.id = "singlefile";	// This makes it so FileProgress only makes a single UI element, instead of one for each file
    var arrDatos=serverData.split('|');

    if ( arrDatos[0]!='1') 
    {
    	
        
    } 
    else 
    {
        
        gEx("idArchivo").setValue(arrDatos[1]);
        gEx("nombreArchivo").setValue(arrDatos[2]);
        if(gE('txtFileName'))
	        gE('txtFileName').value=arrDatos[2];
        
        
        
        var cadObj='{"carpetaAdministrativa":"'+carpetaAdministrativa+'","idFormulario":"665","idRegistro":"'+gE('idRegistroG').value+
        			'","idArchivo":"'+arrDatos[1]+'","nombreArchivo":"'+arrDatos[2]+'","tipoDocumento":"'+gEx('cmbTipoDocumento').getValue()+
                    '","descripcion":"'+cv(gEx('txtDescripcion').getValue())+'"}';
    
        function funcAjax2(peticion_http)
        {
            var resp=peticion_http.responseText;
            
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
               	gEx('gridDocumentos').getStore().reload();
                gEx('vDocumento').close();                
            }
            else
            {
                
                msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+arrResp[0]);
            }
        }
        obtenerDatosWebV2('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax2, 'POST','funcion=13&cadObj='+cadObj,false);
        
        
        
    }
		
	
}


function mostrarVentanaAgregarPersonaNotificar()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											
											items: 	[
                                            			{
                                                        	region:'center',
                                                            width:500,
                                                        	xtype:'panel',
                                                            defaultType: 'label',
                                                            layout:'absolute',
                                                            border:false,
                                                            items:	[
                                                            			{
                                                                            x:10,
                                                                            y:20,
                                                                            cls:'letraNotificaciones',
                                                                            html:'Tipo de Persona Jur&iacute;dica:'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:50,
                                                                            html:'<div id="spTipoPersona"></div>'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:110,
                                                                            cls:'letraNotificaciones',
                                                                            id:'lblNombre',
                                                                            html:'Nombre:'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:140,
                                                                            id:'lblSpIntituciones',
                                                                            html:'<div id="spInstituciones"></div>'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:140,
                                                                            id:'lblSpEmbargo',
                                                                            html:'<div id="spEmbargo"></div>'
                                                                        },
                                                                        
                                                                        {
                                                                            x:10,
                                                                            y:140,
                                                                            cls:'controlSIUGJ',
                                                                            xtype:'textfield',
                                                                            width:364,                                                            
                                                                            disabled:true,
                                                                            id:'txtNombre'
                                                                            
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:190,
                                                                            cls:'letraNotificaciones',
                                                                            id:'lblMail',
                                                                            html:'E-mail:'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:220,
                
                                                                            cls:'controlSIUGJ',
                                                                            disabled:true,
                                                                            xtype:'textfield',
                                                                            width:364,
                                                                            id:'txtMail'
                                                                            
                                                                        }
                                                            		]
                                                        },
                                                        {
                                                        	xtype:'panel',
                                                            region:'east',
                                                            width:450,
                                                            border:false,
                                                            cls:'gridPanelSIUGJCabecera',
                                                            title:'Participantes',
                                                            layout:'border',
                                                            items:	[
                                                            			crearArbolSujetosProcesalesRelacion(listPartes,idActividad,-1)
                                                                    ]
                                                        }
                                            			
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Destinatario',
										width: 950,
										height:450,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	var cmbTipoPersonaJuridica=crearComboExt('cmbTipoPersonaJuridica',arrTiposPersonas,0,0,364,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'spTipoPersona'});
    
																    cmbTipoPersonaJuridica.on('select',function(cmb,registro)
                                                                                                {
                                                                                                    gEx('lblNombre').hide();
                                                                                                    gEx('txtNombre').hide();
                                                                                                    gEx('lblMail').hide();
                                                                                                    gEx('txtMail').hide();
                                                                                                    gEx('lblSpIntituciones').hide();
                                                                                                    gEx('cmbInstituciones').setValue('');
                                                                                                    gEx('cmbEntidadesEmbargo').setValue('');
                                                                                                    gEx('lblSpEmbargo').hide('');
                                                                                                    switch(registro.data.id)
                                                                                                    {
                                                                                                        case '1':
                                                                                                            gEx('txtNombre').setValue('');
                                                                                                            gEx('txtMail').setValue('');
                                                                                                            gEx('arbolSujetosRelacion').enable();
                                                                                                            gEx('txtNombre').disable();
                                                                                                            gEx('txtMail').disable();
                                                                                                            
                                                                                                        break;
                                                                                                        case '2':
                                                                                                            
                                                                                                            gEx('lblNombre').show();
                                                                                                            gEx('txtNombre').show();
                                                                                                            gEx('lblMail').show();
                                                                                                            gEx('txtMail').show();
                                                                                                            gEx('lblNombre').setText('Nombre:');
                                                                                                            gEx('arbolSujetosRelacion').disable();
                                                                                                            gEx('txtNombre').enable();
                                                                                                            gEx('txtMail').enable();
                                                                                                            gEx('txtNombre').focus();
                                                                                                            
                                                                                                        break;
                                                                                                        case '3':
                                                                                                            gEx('arbolSujetosRelacion').disable();
                                                                                                            gEx('lblNombre').show();
                                                                                                            gEx('lblNombre').setText('Instituci\xF3n:',false);
                                                                                                            gEx('lblSpIntituciones').show();
                                                                                                        break;
                                                                                                        case '4':
                                                                                                            gEx('arbolSujetosRelacion').disable();
                                                                                                            gEx('lblNombre').show();
                                                                                                            gEx('lblNombre').setText('Entidad Embargo:',false);
                                                                                                            gEx('lblSpEmbargo').show();
                                                                                                        break;
                                                                                                    }
                                                                                                    
                                                                                                }
                                                                            )
                            
                            
                            										var cmbInstituciones=crearComboExt('cmbInstituciones',arrInstituciones,0,0,364,{multiSelect:true,ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'spInstituciones'});
                                                                    gEx('lblSpIntituciones').hide();
                                                                    var cmbEntidadesEmbargo=crearComboExt('cmbEntidadesEmbargo',arrEntidadesEmbargo,0,0,365,{multiSelect:true,ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'spEmbargo'});
                                                                    gEx('lblSpEmbargo').hide();
                            
																}
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,                                                            
															handler: function()
																	{
                                                                    	var txtNombre=gEx('txtNombre');
                                                                        var txtMail=gEx('txtMail');
                                                                        
                                                                        var reg=crearRegistro	(
                                                                        							[
                                                                                                    	{name: 'idRegistro'},
                                                                                                        {name: 'idReferencia'},
                                                                                                        {name:'tipoPersona'},
                                                                                                        {name:'nombrePersona'},
                                                                                                        {name:'email'},
                                                                                                        {name:'idPersona'}
                                                                                                     ]
                                                                        
                                                                        						);
                                                                        
                                                                        switch(parseInt(gEx('cmbTipoPersonaJuridica').getValue()))
                                                                        {
                                                                        	case 1:
                                                                            	var nodos=gEx('arbolSujetosRelacion').getChecked();
                                                                                var x;
                                                                                var r
                                                                                var pos;
                                                                                for(x=0;x<nodos.length;x++)
                                                                                {
                                                                                    pos=obtenerPosFila(gEx('grid_10687').getStore(),'idPersona',nodos[x].attributes.idPersona);
                                                                                    if(pos==-1)
                                                                                    {
                                                                                        r=new reg	(
                                                                                                        {
                                                                                                            idRegistro:-1,
                                                                                                            idReferencia:-1,
                                                                                                            tipoPersona:gEx('cmbTipoPersonaJuridica').getValue(),
                                                                                                            nombrePersona:nodos[x].attributes.nombre,
                                                                                                            email:nodos[x].attributes.mail,
                                                                                                            idPersona:nodos[x].attributes.idPersona
                                                                                                        }
                                                                                                    );
                                                                                    
                                                                                
                                                                                        gEx('grid_10687').getStore().add(r);
                                                                                    }
                                                                                }
                                                                            break;
                                                                            case 2:
                                                                            	if(txtNombre.getValue()=='')
                                                                                {
                                                                                    function resp1()
                                                                                    {
                                                                                        txtNombre.focus();
                                                                                    }
                                                                                    msgBox('Debe ingresar el nombre del destinatario',resp1);
                                                                                    return;
                                                                                }
                                                                                
                                                                                if(txtMail.getValue()=='')
                                                                                {
                                                                                    function resp2()
                                                                                    {
                                                                                        txtMail.focus();
                                                                                    }
                                                                                    msgBox('Debe ingresar la direcci&oacute;n de correo electr&oacute;nico a notificar',resp2);
                                                                                    return;
                                                                                }
                                                                                
                                                                                if(!validarCorreo(txtMail.getValue()))
                                                                                {
                                                                                    function resp3()
                                                                                    {
                                                                                        txtMail.focus();
                                                                                    }
                                                                                    msgBox('La direcci&oacute;n de correo electr&oacute;nico ingresada NO es v&aacute;lida',resp3);
                                                                                    return;
                                                                                }
                                                                                
                                                                                var r=new reg	(
                                                                                                    {
                                                                                                        idRegistro:-1,
                                                                                                        idReferencia:-1,
                                                                                                        tipoPersona:gEx('cmbTipoPersonaJuridica').getValue(),
                                                                                                        nombrePersona:txtNombre.getValue(),
                                                                                                        email:txtMail.getValue(),
                                                                                                        idPersona:-1
                                                                                                    }
                                                                                                );
                                                                                
                                                                            
                                                                                gEx('grid_10687').getStore().add(r);
                                                                            break;
                                                                            case 3:
                                                                            	var arrInstitucionesSel=gEx('cmbInstituciones').getValue();

                                                                                if(arrInstitucionesSel=='')
                                                                                {
                                                                                	msgBox('Debe seleccionar almenos una instituci&oacute;n a notificar');
                                                                                	return;
                                                                                }
                                                                                
                                                                                
                                                                                var aInstituciones=arrInstitucionesSel.split(",");
                                                                                var x;
                                                                                var r
                                                                                var pos;

                                                                                for(x=0;x<aInstituciones.length;x++)
                                                                                {
                                                                                    pos=existeValorMatriz(arrInstituciones,aInstituciones[x]);
                                                                                    if(pos!=-1)
                                                                                    {
                                                                                        r=new reg	(
                                                                                                        {
                                                                                                            idRegistro:-1,
                                                                                                            idReferencia:-1,
                                                                                                            tipoPersona:gEx('cmbTipoPersonaJuridica').getValue(),
                                                                                                            nombrePersona:arrInstituciones[pos][1],
                                                                                                            email:arrInstituciones[pos][2],
                                                                                                            idPersona:-1
                                                                                                        }
                                                                                                    );
                                                                                    
                                                                                
                                                                                        gEx('grid_10687').getStore().add(r);
                                                                                    }
                                                                                }
                                                                            break;
                                                                            case 4:
                                                                            	var arrInstitucionesSel=gEx('cmbEntidadesEmbargo').getValue();

                                                                                if(arrInstitucionesSel=='')
                                                                                {
                                                                                	msgBox('Debe seleccionar almenos una instituci&oacute;n a notificar');
                                                                                	return;
                                                                                }
                                                                                
                                                                                
                                                                                var aInstituciones=arrInstitucionesSel.split(",");
                                                                                var x;
                                                                                var r
                                                                                var pos;

                                                                                for(x=0;x<aInstituciones.length;x++)
                                                                                {
                                                                                    pos=existeValorMatriz(arrEntidadesEmbargo,aInstituciones[x]);
                                                                                    if(pos!=-1)
                                                                                    {
                                                                                        r=new reg	(
                                                                                                        {
                                                                                                            idRegistro:-1,
                                                                                                            idReferencia:-1,
                                                                                                            tipoPersona:gEx('cmbTipoPersonaJuridica').getValue(),
                                                                                                            nombrePersona:arrEntidadesEmbargo[pos][1],
                                                                                                            email:arrEntidadesEmbargo[pos][2],
                                                                                                            idPersona:-1
                                                                                                        }
                                                                                                    );
                                                                                    
                                                                                
                                                                                        gEx('grid_10687').getStore().add(r);
                                                                                    }
                                                                                }
                                                                            break;
                                                                        }
                                                                        
																		
                                                                        
                                                                        
                                                                        ventanaAM.close();
																	}
														}
														
													]
									}
								);
	ventanaAM.show();
}

function crearArbolSujetosProcesalesRelacion(listPartes,iA,iP)
{
	var iActividad=iA?iA:-1;
    var idPersona=iP?iP:-1;
	var raiz=new  Ext.tree.AsyncTreeNode(
											{
												id:'-1',
												text:'Raiz',
												draggable:false,
												expanded :false,
												cls:'-1'
											}
										)
										
	var cargadorArbol=new Ext.tree.TreeLoader(
                                                {
                                                    baseParams:{
                                                                    funcion:'19',
                                                                    iC:-1,
                                                                    cA:carpetaAdministrativa,
                                                                    iA:iActividad,
                                                                    check:1,
                                                                    iP:idPersona,
                                                                    moduloNotificaciones:1,
                                                                    sujetosProcesales:listPartes
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'
                                                }
                                            )		
										
	cargadorArbol.on('beforeload',function(c)
    						{
                            }
    				)	
    										
	cargadorArbol.on('load',function(c,nodoCarga)
    						{
                            	
                            }
    				)										
	var arbolSujetosJuridicos=new Ext.tree.TreePanel	(
                                                            {
                                                                id:'arbolSujetosRelacion',
                                                                useArrows:true,
                                                                animate:true,
                                                                enableDD:false,
                                                                ddScroll:true,
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                border:true,
                                                                disabled:true,
                                                                cls:'arbolNotificacion',
                                                                root:raiz,
                                                                region:'center',
                                                                loader: cargadorArbol,
                                                                rootVisible:false
                                                            }
                                                        )
         
         
                                                    
	return  arbolSujetosJuridicos;
}
