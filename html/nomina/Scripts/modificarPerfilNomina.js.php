<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idPerfil=$_GET["iPerfil"];
	$consulta="select ciclo,ciclo from 550_cicloFiscal where status=1 order by ciclo";
	$arrCiclos=uEJ($con->obtenerFilasArreglo($consulta));	
	$consulta="SELECT id__642_tablaDinamica,nombrePeriodicidad FROM _642_tablaDinamica  WHERE situacion=1 ORDER BY nombrePeriodicidad";
	$arrPeriodicidad=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT idTipoPercepcion,CONCAT('[',clave,'] ',descripcion) FROM 681_tiposPercepcionSAT ORDER BY clave";
	$arrTipoPercepcion=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT idTipoDeduccion,CONCAT('[',clave,'] ',descripcion) FROM 682_tiposDeduccionSAT ORDER BY clave";
	$arrTipoDeduccion=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT idTipoCalculo,tipoCalculoAuxiliar FROM 716_tiposCalculosAuxiliares";
	$arrTipoAuxiliar=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT idConsulta,nombreConsulta FROM 991_consultasSql WHERE idTipoConcepto=3 ORDER BY nombreConsulta";
	$arrFuncionesGravamen=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idRegistro,nombreClasificador FROM 667_clasificadoresNomina WHERE idPerfil=".$idPerfil." ORDER BY nombreClasificador";
	$arrClasificadores=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	
	$idFormularioCatPuestos=obtenerIDFormularioCategoria("CP");
	$idFormularioCatTiposContratacion=obtenerIDFormularioCategoria("TC");
	$idFormularioCatClasificacionPuestos=obtenerIDFormularioCategoria("CLP");
	
	$consulta="SELECT id__".$idFormularioCatPuestos."_tablaDinamica,nombrePuesto FROM _".$idFormularioCatPuestos."_tablaDinamica order by nombrePuesto";
	$arrCatalogoPuestos=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__".$idFormularioCatTiposContratacion."_tablaDinamica,tipoContratacion FROM _".$idFormularioCatTiposContratacion."_tablaDinamica order by tipoContratacion";
	$arrCatalogoTiposContratacion=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__".$idFormularioCatClasificacionPuestos."_tablaDinamica,nomPuesto FROM _".$idFormularioCatClasificacionPuestos."_tablaDinamica order by nomPuesto";
	$arrCatalogoClasificacionPuestos=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idPeriodicidad FROM 662_perfilesNomina WHERE idPerfilesNomina=".$idPerfil;
	$idPeriodicidad=$con->obtenerValor($consulta);
	
	$consulta="SELECT noOrdinal,nombreElemento FROM _642_gElementosPeriodicidad WHERE idReferencia=".$idPeriodicidad." ORDER BY noOrdinal";
	$arrQuincenasAplicacion=$con->obtenerFilasArreglo($consulta);
	
	
?>

var arrCatalogoPuestos=<?php echo $arrCatalogoPuestos?>;
var arrCatalogoTiposContratacion=<?php echo $arrCatalogoTiposContratacion?>;
var arrCatalogoClasificacionPuestos=<?php echo $arrCatalogoClasificacionPuestos?>;
var arrSiNo=<?php echo $arrSiNo?>;
var arrClasificadoresCalculo=<?php echo $arrClasificadores?>;
var arrTipoAuxiliar=<?php echo $arrTipoAuxiliar?>;
var arrFuncionesGravamen=<?php echo $arrFuncionesGravamen?>;
var arrTipoPercepcion=<?php echo $arrTipoPercepcion?>;
var arrTipoDeduccion=<?php echo $arrTipoDeduccion?>;
var arrPeriodicidad=<?php echo $arrPeriodicidad?>;
var arrTipoAfectacion=[['1','Debe'],['2','Haber']];
var arrTipoCalculos=[['0','C\xE1lculo auxiliar','666'],['1','Deducci\xF3n','900'],['2','Percepci\xF3n','030']]
var arrEtiquetasAgr=[];
var arrAmbitoEtiqueta=[['1','Versi\xF3n impresa  de CFDI'],['2','XML de CFDI'],['3','XML y Versi\xF3n impresa de CFDI']];
Ext.onReady(inicializar);
	
function inicializar()
{
	arrEtiquetasAgrP=eval(bD(gE('arrEtiquetasAgrP').value));  
    arrEtiquetasAgrP.splice(0,0,['0','Ninguna']) ;
    arrEtiquetasAgrD=eval(bD(gE('arrEtiquetasAgrD').value));  
    arrEtiquetasAgrD.splice(0,0,['0','Ninguna']) ;
	var gridNomina=crearGridNomina();
	
}

function crearGridNomina()
{
	
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                           crearGridCalculos() 
                                        ]
                            }
                        )      
        
        
        
                                               	           
        
                                                       
	                                               
                                                        
		
}


function crearGridCalculos()
{
	var cmbTipoCalculo=crearComboExt('cmbTipoCalculo',arrTipoCalculos);
	var cmbCategoria=crearComboExt('cmbCategoria',[]);
	var tamPagina=1000;
	var cmbFuncionesGravamen=crearComboExt('cmbFuncionesGravamen',arrFuncionesGravamen);
	var cmbEtiquetaAgrupadora=crearComboExt('cmbEtiquetaAgrupadora',arrEtiquetasAgr);    
    var cmbAmbitoEtiqueta=crearComboExt('cmbAmbitoEtiqueta',arrAmbitoEtiqueta);                                                                                      
	
	var lblPerfil=gE('lblPerfil').value;  
    
	var alDatos=new Ext.data.JsonStore(		{
    											root:'registros',
                                                totalProperty:'numReg',
                                                autoLoad:false,
                                                proxy : new Ext.data.HttpProxy	(

                                                                                    {

                                                                                        url: '../paginasFunciones/funcionesEspecialesNomina.php'

                                                                                    }

                                                                                ),
                                                fields: [
                                                            {name:'orden', type:'int'},
                                                            {name:'tipoCalculo'},
                                                            {name:'codigo'},
                                                            {name:'cveCalculo'},
                                                            {name:'nombreConsulta'},
                                                            {name:'parametros'},
                                                            {name:'acumulador'},
                                                            {name:'aplicacionCalculo'},
                                                            {name:'afectacion'},
                                                            {name:'quincenaAplicacion'},
                                                            {name:'afectacionContable'},
                                                            {name:'idCalculo'},
                                                            {name:'categoriaCalculo'},
                                                            {name:'idFuncionGravamen'},
                                                            {name:'idEtiquetaAgrupadora'},
                                                            {name:'ambitoEtiqueta'},
                                                            {name: 'etiquetaConcepto'},
                                                            {name: 'idCalculoAsociado'},
                                                            {name: 'clasificacionCalculo'},
                                                            {name: 'mostrarSiValorCero'},
                                                            {name: 'incluirEnCache'},
                                                            {name: 'calcularSiCalculoAsociadoIgualCero'},
                                                            
                                                            
                                                        ]
                                                                
                                            }
                                      ) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='11';
                                        proxy.baseParams.idPerfil=gE('idPerfil').value;
                                    }
                        )   
	var filters = new Ext.ux.grid.GridFilters	(

    												{

                                                    	filters:	[ 	
                                                        				{type: 'string', dataIndex: 'codigo'},
                                                                        {type: 'string', dataIndex: 'nombreConsulta'},
                                                                        {type: 'list', dataIndex: 'tipoCalculo', phpMode:true, options: arrTipoCalculos}
                                                                    ]

                                                    }

                                                );                         
	var paginador=	new Ext.PagingToolbar	(
                                                {
                                                      pageSize: tamPagina,
                                                      store: alDatos,
                                                      displayInfo: true,
                                                      disabled:false
                                                  }
                                               )  	         
	                                                   
    var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true,checkOnly:true});
    var cmbCalculosRegistrados=crearComboExt('cmbCalculosRegistrados',[]);
    var cmbMostrarSiCero=crearComboExt('cmbMostrarSiCero',arrSiNo);
    var cmbMostrarSiCache=crearComboExt('cmbMostrarSiCache',arrSiNo);
    var cmbMostrarSiAsociadoCero=crearComboExt('cmbMostrarSiAsociadoCero',arrSiNo);
    var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:30}),
                                                            chkRow,
                                                            {
                                                                header:'&Oacute;rden de <br>ejecuci&oacute;n',
                                                                width:80,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'orden'
                                                            },
                                                            {
                                                                header:'Tipo  de c&aacute;lculo',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'tipoCalculo',
                                                                editor:cmbTipoCalculo,
                                                                renderer:function (val)
                                                                		{
                                                                        	var pos=existeValorMatriz(arrTipoCalculos,val);
                                                                            if(pos==-1)
                                                                                return '';
                                                                            else
                                                                                return '<b><span style="color:#'+arrTipoCalculos[pos][2]+'">'+arrTipoCalculos[pos][1]+'</span></b>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Clasificaci&oacute;n Cat&aacute;logo SAT',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'categoriaCalculo',
                                                                renderer:function (val,meta,registro)
                                                                		{
																			if(registro.data.tipoCalculo=='1')
                                                                            	return formatearValorRenderer(arrTipoDeduccion,val);	
                                                                            if(registro.data.tipoCalculo=='2')
                                                                            	return formatearValorRenderer(arrTipoPercepcion,val);
                                                                             	
                                                                            if(registro.data.tipoCalculo=='0')
                                                                            {
                                                                            	if(val=='')
                                                                                	val='1';
                                                                            	return formatearValorRenderer(arrTipoAuxiliar,val);    
                                                                             }   
                                                                                

                                                                        },
                                                            	editor:cmbCategoria
                                                            },
                                                            {
                                                                header:'Cve. C&aacute;lculo',
                                                                width:110,
                                                                
                                                                sortable:true,
                                                                dataIndex:'cveCalculo',
                                                                editor:{
                                                                			xtype:'textfield'
                                                               			} 
                                                            },
                                                            {
                                                                header:'ID Concepto',
                                                                width:110,
                                                                sortable:true,
                                                                dataIndex:'codigo'
                                                            },
                                                            
                                                            {
                                                                header:'Descripci&oacute;n del c&aacute;lculo',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'etiquetaConcepto',
                                                                editor:	{xtype:'textfield'},
                                                                renderer:rendererDescripcionCalculo
                                                            },
                                                            
                                                            {
                                                            	header:'Par&aacute;metros',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'parametros'
                                                            }
                                                            ,
                                                            {
                                                                header:'Afectar acumulador',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'acumulador'
                                                            },
                                                            {
                                                            	header:'Aplicar a',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'aplicacionCalculo'
                                                            },
                                                             
                                                            {
                                                            	header:'Afectaci&oacute;n sobre n&oacute;mina',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'afectacion'
                                                            },
                                                            {
                                                            	header:'Quincena de aplicaci&oacute;n',
                                                                width:380,
                                                                sortable:true,
                                                                dataIndex:'quincenaAplicacion'
                                                            },

                                                            {
                                                            	header:'Afectaci&oacute;n contable',
                                                                width:1000,
                                                                sortable:true,
                                                                hidden:true,
                                                                dataIndex:'afectacionContable'
                                                            },
                                                            {
                                                                header:'Definir gravamen mediante funci&oacute;n',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'idFuncionGravamen',
                                                                renderer:function (val,meta,registro)
                                                                		{
																			return formatearValorRenderer(arrFuncionesGravamen,val);
                                                                        },
                                                            	editor:cmbFuncionesGravamen
                                                            },
                                                            {
                                                                header:'Etiqueta agrupadora',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'idEtiquetaAgrupadora',
                                                                renderer:function (val,meta,registro)
                                                                		{
                                                                        
                                                                        	if(registro.data.tipoCalculo=='1')
                                                                            	return formatearValorRenderer(arrEtiquetasAgrD,val);	
                                                                            if(registro.data.tipoCalculo=='2')
                                                                            	return formatearValorRenderer(arrEtiquetasAgrP,val);
                                                                        
																			
                                                                        },
                                                            	editor:cmbEtiquetaAgrupadora
                                                            },
                                                            {
                                                                header:'&Aacute;mbito etiqueta',
                                                                width:200,
                                                                sortable:true,
                                                                hidden:true,
                                                                dataIndex:'ambitoEtiqueta',
                                                                renderer:function (val,meta,registro)
                                                                		{
                                                                        	if(registro.data.idEtiquetaAgrupadora=='0')
                                                                            	return 'N/A';
                                                                            if(val=='')
                                                                            	val='3';
																			return formatearValorRenderer(arrAmbitoEtiqueta,val);
                                                                        },
                                                            	editor:cmbAmbitoEtiqueta
                                                            },
                                                            {
                                                                header:'C&aacute;lculo Asociado',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'idCalculoAsociado',
                                                                renderer:function (val,meta,registro)
                                                                		{
                                                                        	if((val!='')&&(val!='0'))
                                                                            {
                                                                            	var gridCalculos=gEx('gridCalculos');
                                                                            	var filaAsociada;
                                                                                var x;
                                                                                for(x=0;x<gridCalculos.getStore().getCount();x++)
                                                                                {
                                                                                	filaAsociada=gridCalculos.getStore().getAt(x);
                                                                                    if(filaAsociada.data.idCalculo==val)
                                                                                    {
                                                                                    	return '['+filaAsociada.data.codigo+'] '+rendererDescripcionCalculo(filaAsociada.data.etiquetaConcepto,meta,filaAsociada);
                                                                                    }
                                                                                }
                                                                            
																				
                                                                            }
                                                                        },
                                                            	editor:cmbCalculosRegistrados
                                                            },
                                                            {
                                                                header:'Clasificaci&oacute;n Calculo',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'clasificacionCalculo',
                                                                renderer:function (val,meta,registro)
                                                                		{
																			return val

                                                                        }
                                                            },
                                                            {
                                                                header:'Mostrar Si Valor Cero',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'mostrarSiValorCero',
                                                                editor:cmbMostrarSiCero,
                                                                renderer:function (val,meta,registro)
                                                                		{
																			return formatearValorRenderer(arrSiNo,val);

                                                                        }
                                                            },
                                                            {
                                                                header:'Incluir en Cach&eacute;',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'incluirEnCache',
                                                                editor:cmbMostrarSiCache,
                                                                renderer:function (val,meta,registro)
                                                                		{
																			return formatearValorRenderer(arrSiNo,val);

                                                                        }
                                                            },
                                                            {
                                                                header:'Calcular Si importe<br>asociado igual a 0',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'calcularSiCalculoAsociadoIgualCero',
                                                                editor:cmbMostrarSiAsociadoCero,
                                                                renderer:function (val,meta,registro)
                                                                		{
                                                                        	if(registro.data.idCalculoAsociado=='')
                                                                            	return 'N/A';
																			return formatearValorRenderer(arrSiNo,val);

                                                                        }
                                                            }
                                                            
                                                        ]
                                                    );

	var tblGrid=	new Ext.grid.EditorGridPanel(
    												 {
                                                          id:'gridCalculos',
                                                          store:alDatos,
                                                          region:'center',
                                                          frame:false,
                                                          border:false,
                                                          cm: cModelo,
                                                          stripeRows :true,
                                                          loadMask:true,
                                                          sm:chkRow,
                                                          columnLines : true,
                                                          bbar:[paginador],
                                                          plugins:[filters],
                                                          clicksToEdit:1,
                                                          tbar:	[
                                                                      {
                                                                          icon:'../images/salir.gif',
                                                                          cls:'x-btn-text-icon',
                                                                          text:'Salir',
                                                                          handler:function()
                                                                                  {
                                                                                      regresarPagina();
                                                                                  }
                                                                          
                                                                      },'-',
                                                                      {
                                                                            cls:'x-btn-text-icon',

                                                                            icon:'../images/cog.png',
                                                                            text:'Configuraci&oacute;nes...',
                                                                            menu:	[
                                                                                      {
                                                                                          icon:'../images/page_process.png',
                                                                                          cls:'x-btn-text-icon',
                                                                                          text:'Configuraciones de perfil de n&oacute;mina',
                                                                                          handler:function()
                                                                                                  {
                                                                                                      mostrarVentanaConfiguraciones();
                                                                                                  }
                                                                                          
                                                                                      },
                                                                                      {
                                                                                          icon:'../images/page_process.png',
                                                                                          cls:'x-btn-text-icon',
                                                                                          text:'Administraci&oacute;n de perfiles de importaci&oacute;n',
                                                                                          handler:function()
                                                                                                  {
                                                                                                      mostrarVentanaAdmonPerfilesImportacion();
                                                                                                  }
                                                                                          
                                                                                      },
                                                                                      {
                                                                                          icon:'../images/page_process.png',
                                                                                          cls:'x-btn-text-icon',
                                                                                          text:'Escenario n&oacute;mina',
                                                                                          handler:function()
                                                                                                  {
                                                                                                      modificarEscenario();
                                                                                                  }
                                                                                          
                                                                                      },
                                                                                      {
                                                                                          icon:'../images/page_process.png',
                                                                                          cls:'x-btn-text-icon',
                                                                                          text:'Asignaci&oacute;n de Instituciones / Centro de Trabajo',
                                                                                          handler:function()
                                                                                                  {
                                                                                                      mostrarVentanaAsignacionInstitucion();
                                                                                                  }
                                                                                          
                                                                                      }
                                                                                  ]
                                                                       },'-',
                                                                      {
                                                                            cls:'x-btn-text-icon',
                                                                            icon:'../images/sum.png',
                                                                            text:'Calculos...',
                                                                            menu:	[
                                                                                      {
                                                                                          icon:'../images/add.png',
                                                                                          cls:'x-btn-text-icon',
                                                                                          text:'Agregar nuevo c&aacute;lculo',
                                                                                          handler:function()
                                                                                                  {
                                                                                                      agregarConcepto();
                                                                                                  }
                                                                                          
                                                                                      },'-',
                                                                                      {
                                                                                          icon:'../images/arrow_switch.png',
                                                                                          cls:'x-btn-text-icon',
                                                                                          text:'Modificar &oacute;rden del c&aacute;lculo',
                                                                                          handler:function()
                                                                                                  {
                                                                                                      var fila=tblGrid.getSelectionModel().getSelected();
                                                                                                      if(fila==null)
                                                                                                      {
                                                                                                          msgBox('Debe seleccionar el c&aacute;lculo cuyo &oacute;rden desea modificar');
                                                                                                          return;
                                                                                                      }
                                                                                                      modificarOrdenCalculo(parseInt(fila.get('orden')),fila.get('idCalculo'));   
                                                                                                  }
                                                                                          
                                                                                      },'-',
                                                                                      {
                                                                                          icon:'../images/cancel_round.png',
                                                                                          cls:'x-btn-text-icon',
                                                                                          text:'Remover c&aacute;lculo',
                                                                                          handler:function()
                                                                                                  {
                                                                                                     var fila=tblGrid.getSelectionModel().getSelected();
                                                                                                     if(fila==null)
                                                                                                     {
                                                                                                          msgBox('Debe seleccionar el c&aacute;lculo que desea remover');
                                                                                                          return;
                                                                                                     }
                                                                                                     
                                                                                                     removerConcepto(fila.get('idCalculo'))
                                                                                                  }
                                                                                          
                                                                                      }
                                                                                  ]
                                                                          }                 
                                                                     ,'-',
                                                                      
                                                                      
                                                                      {
                                                                          icon:'../images/calculator.png',
                                                                          cls:'x-btn-text-icon',
                                                                          text:'Administrar acumuladores',
                                                                          handler:function()
                                                                                  {
                                                                                      agregarAcumulador();
                                                                                  }
                                                                          
                                                                      },
                                                                      '-',
                                                                      {
                                                                          icon:'../images/formularios/calculator_add.png',
                                                                          cls:'x-btn-text-icon',
                                                                          text:'Asignar acumuladores',
                                                                          handler:function()
                                                                                  {
                                                                                      var fila=tblGrid.getSelectionModel().getSelected();
                                                                                      if(fila==null)
                                                                                      {
                                                                                          msgBox('Debe seleccionar el c&aacute;lculo que desea remover');
                                                                                          return;
                                                                                      }
                                                                                      asignarAcumulador(fila.get('idCalculo'));
                                                                                  }
                                                                          
                                                                      },
                                                                      '-',
                                                                      {
                                                                          icon:'../images/tickets.png',
                                                                          cls:'x-btn-text-icon',
                                                                          text:'Administrar etiqueta agrupadora',
                                                                          handler:function()
                                                                                  {
                                                                                      
                                                                                      mostrarVentanaEtiquetaAgrupadora()
                                                                                  }
                                                                          
                                                                      },
                                                                      '-',
                                                                      {
                                                                          icon:'../images/report_add.png',
                                                                          cls:'x-btn-text-icon',
                                                                          hidden:true,
                                                                          text:'Agregar afectaci&oacute;n contable',
                                                                          handler:function()
                                                                                  {
                                                                                      var fila=tblGrid.getSelectionModel().getSelected();
                                                                                      if(fila==null)
                                                                                      {
                                                                                          msgBox('Debe seleccionar el c&aacute;lculo a la cual desea agregar una afectaci&oacute;n contable');
                                                                                          return;
                                                                                      }
                                                                                      mostrarVentanaCuenta(bE(fila.get('idCalculo')));
                                                                                  }
                                                                          
                                                                      },'-',
                                                                      {
                                                                          icon:'../images/database_table.png',
                                                                          cls:'x-btn-text-icon',
                                                                          text:'Administrar Clasificadores C&aacute;lculos',
                                                                          handler:function()
                                                                                  {
                                                                                      
                                                                                      agregarClasificadorCalculo()
                                                                                  }
                                                                          
                                                                      },'-',
                                                                      {
                                                                          icon:'../images/page_edit2.png',
                                                                          cls:'x-btn-text-icon',
                                                                          text:'Asignar Clasificador de C&aacute;lculo',
                                                                          handler:function()
                                                                                  {
                                                                                      var fila=gEx('gridCalculos').getSelectionModel().getSelected();
                                                                                      if(!fila)
                                                                                      {
                                                                                      	msgBox('Debe seleccionar el concepto al cual desea asociar el clasificador');
                                                                                      	return;
                                                                                      }
                                                                                      agregarClasificadorCalculoNomina(fila.data.idCalculo)
                                                                                  }
                                                                          
                                                                      }
                                                                      
                                                                      
                                                                      
                                                                      
                                                                  ]
                                                      }

													
                                                   );

	tblGrid.on('beforeedit',function(e)
    						{
                            
                            	if(e.field=='idCalculoAsociado')
                                {	
                                	var arrConceptosAlineados=[['','Ninguno']];
                                	var fila;
                                	var x;
                                    for(x=0;x<e.row;x++)
                                    {
                                    	fila=e.grid.getStore().getAt(x);
                                        arrConceptosAlineados.push([fila.data.idCalculo,'['+fila.data.codigo+'] '+Ext.util.Format.stripTags(rendererDescripcionCalculo(fila.data.etiquetaConcepto,{},fila))]);
                                    }
                                    gEx('cmbCalculosRegistrados').getStore().loadData(arrConceptosAlineados);
                                }
                            
                            	if((e.field=='calcularSiCalculoAsociadoIgualCero')&&(e.record.data.idCalculoAsociado==''))
                                {
                                	e.cancel=true;
                                    return;
                                }
                            
                            	if((e.field=='ambitoEtiqueta')&&(e.record.data.idEtiquetaAgrupadora=='0'))
                                {
                                	e.cancel=true;
                                    return;
                                }
                            	
                                if(e.record.data.tipoCalculo=='1')
                                {
                                	gEx('cmbEtiquetaAgrupadora').getStore().loadData(arrEtiquetasAgrD);
                                	gEx('cmbCategoria').getStore().loadData(arrTipoDeduccion);
                                }
                                if(e.record.data.tipoCalculo=='2')
                                {
                                	gEx('cmbEtiquetaAgrupadora').getStore().loadData(arrEtiquetasAgrP);
                                	gEx('cmbCategoria').getStore().loadData(arrTipoPercepcion);
                                }
                                if(e.record.data.tipoCalculo=='0')
                                {
                                	gEx('cmbCategoria').getStore().loadData(arrTipoAuxiliar);
                                    if(e.field=='idEtiquetaAgrupadora')
                                    {
                                    	e.cancel=true;
                                    }
                                }
                                
                                
                                
                            }
    			)      
	tblGrid.on('afteredit',function(e)
    						{
                            	var tipoCampo='';
                            	switch(e.field)
                                {
                                	case 'categoriaCalculo':
                                    	tipoCampo=1;
                                    break;
                                    case 'idFuncionGravamen':
                                    	tipoCampo=2;
                                    break;
                                    case 'idEtiquetaAgrupadora':
                                    	tipoCampo=3;
                                    break;
                                    case 'ambitoEtiqueta':
                                    	tipoCampo=4;
                                    break;
                                    case 'tipoCalculo':
                                    	tipoCampo=5;
                                    break;
                                    case 'etiquetaConcepto':
                                    	tipoCampo=6;
                                    break;
                                     case 'cveCalculo':
                                    	tipoCampo=7;
                                    break;
                                    case 'idCalculoAsociado':
                                    
                                    	tipoCampo=8;
                                    break;
                                    case 'mostrarSiValorCero':
                                    
                                    	tipoCampo=9;
                                    break;
                                    case 'incluirEnCache':
                                    
                                    	tipoCampo=10;
                                    break;
                                    case 'calcularSiCalculoAsociadoIgualCero':
                                    
                                    	tipoCampo=11;
                                    break;
                                }
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
                                obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=33&tipoCampo='+tipoCampo+'&valor='+e.value+'&idCalculo='+e.record.data.idCalculo,true);
                            }
    			)                                                                        
		alDatos.load({url: '../paginasFunciones/funcionesEspecialesNomina.php',params:{funcion:11,limit:tamPagina,start:0}})                                                        
        return 	tblGrid;
}

function rendererDescripcionCalculo(val,meta,registro)
{	
    if(val==registro.data.nombreConsulta)
        return '<span style="color:#006"><b>'+mostrarValorDescripcion(val)+'</b></span>';
    else
    {
        return '<span title="'+val+' [C&aacute;lculo: '+registro.data.nombreConsulta+']" alt="'+val+' [C&aacute;lculo: '+registro.data.nombreConsulta+']"><span style="color:#006"><b>'+val+'</b></span><br><span style="color:#777"> [<b>C&aacute;lculo:</b> '+registro.data.nombreConsulta+']</span></span>';
    }
}


function mostrarVentanaAdmonPerfilesImportacion()
{
	var idPerfil=gE('idPerfil').value;
	var obj={};
    obj.titulo='Perfiles de importaci&oacute;n';
    obj.ancho='90%';
    obj.alto='90%';
    obj.url='../nomina/perfilesImportacion.php';
    obj.params=[['idPerfil',idPerfil],['cPagina','sFrm=true']];
	window.parent.abrirVentanaFancy(obj);
}


function agregarConcepto()
{
	var idUsuario=-1;
	asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre)
                                            {
                                            	gEx('gExpresiones').getStore().reload();
                                                
                                            }
	mostrarVentanaExpresion(function(fila,ventana)
    						{
                            	function funcAjax()
                                {
                                    var resp=peticion_http.responseText;
                                    arrResp=resp.split('|');
                                    if(arrResp[0]=='1')
                                    {
                                        gEx('gridCalculos').getStore().reload();
                                        ventana.close();
                                    }
                                    else
                                    {
                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                    }
                                }
                                obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=49&listConceptos='+fila.data.idConsulta+'&tipo=-1&idUsuario='+idUsuario+'&idPerfil='+gE('idPerfil').value,true);
    
    
                            }
    						,
    						true,{idCategoriaDefault:106});



	                               
    
}

function funcTipoCalculoSelect(combo,registro)
{
	var idUsuario=-1;
    var tC=registro.get('id');
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            var gridConcepto=gEx('gridDeduccionPercepcion');
            gridConcepto.getStore().loadData(arrDatos);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=53&tipo='+tC+'&idUsuario='+idUsuario+'&idPerfil='+gE('idPerfil').value,true);
}

function crearGridConceptos()
{
	var dsDatos=[];
    
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idConsulta'},
                                                                {name: 'codigo'},
                                                                {name: 'nomConcepto'},
                                                                {name: 'descripcion'}
                                                                
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
															header:'C&oacute;digo',
															width:100,
															sortable:true,
															dataIndex:'codigo'
														},
														{
															header:'C&aacute;lculo',
															width:250,
															sortable:true,
															dataIndex:'nomConcepto'
														},
														{
															header:'Descripci&oacute;n',
															width:300,
															sortable:true,
															dataIndex:'descripcion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                        	id:'gridDeduccionPercepcion',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:70,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:650,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;		
}

function removerConcepto(iC)
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
                	gEx('gridCalculos').getStore().reload();
                    
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=155&idConcepto='+bE(iC)+'&tipo=1',true);

        }
    }
    msgConfirm('Est&aacute; seguro de querer remover el c&aacute;lculo seleccionado',resp);
}

function modificarOrdenCalculo(o,iC)
{
	var x;
    var arrParam=new Array();
    var obj;
    var grid=gEx('gridCalculos');
    for(x=1;x<=grid.getStore().getCount();x++)
    {
    	if(x!=o)
        {
            obj=new Array();
            obj.push(x);
            obj.push(x);
            arrParam.push(obj);
        }
    }
    var cmbOrden=crearComboExt('cmbOrden',arrParam,130,5,130);
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Orden de c&aacute;lculo:'
                                                        },
                                                        cmbOrden

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Seleccione el orden en que se ejecutar&aacute; el c&aacute;lculo',
										width: 350,
										height:120,
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
																		
                                                                        if(cmbOrden.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar el orden en el cual se llevar&aacute; a cabo el c&aacute;lculo');
                                                                            return;
                                                                        }
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                           		gEx('gridCalculos').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=59&idUsuario=-1&idCalculo='+bE(iC)+'&orden='+cmbOrden.getValue(),true);
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

function modificarEscenario()
{
	var idPerfil=gE('idPerfil').value;
	var obj={};
    obj.titulo='Escenario de nómina';
    obj.ancho='100%';
    obj.alto='90%';
    obj.url='../nomina/escenarioNomina.php';
    obj.params=[['idPerfil',idPerfil],['cPagina','sFrm=true']];
	window.parent.abrirVentanaFancy(obj);
}

function agregarAcumulador()
{
	
	var gridAcumuladores=crearGridAcumuladores();
    gridAcumuladores.getStore().loadData(eval(gE('arrAcumuladores').value));
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridAcumuladores

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Administraci&oacute;n de acumuladores',
										width: 400,
										height:360,
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

function crearGridAcumuladores()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                        			{name: 'idAcumulador'},
                                                                    {name: 'nomAcumulador'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Acumulador',
															width:250,
															sortable:true,
															dataIndex:'nomAcumulador'
														}													
                                                   ]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'tblGridAcumulador',
                                                            store:alDatos,
                                                            frame:false,
                                                            x:10,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:360,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	id:'btnAddAcumulador',
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar acumulador',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarAcumulor('-1');
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	id:'btnDelAcumulador',
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover acumulador',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el acumulador a remover');
                                                                                            return;
                                                                                        }
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
                                                                                                     	tblGrid.getStore().remove(fila);
                                                                                                        recargarPagina();	   
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=69&idAcumulador='+fila.get('idAcumulador'),true);
                                                                                                    
                                                                                            
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el acumulador seleccionado?',resp)
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;		
}

function mostrarVentanaAgregarAcumulor(idAcumulador)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                        	xtype:'label',
                                                            html:'Nombre de acumulador:'
                                                            
                                                        },
                                                        {
                                                        	x:150,
                                                            y:5,
                                                        	xtype:'textfield',
                                                            id:'txtNomAcumulador',
                                                            width:240
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Acumuladores',
										width: 450,
										height:130,
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
                                                                	gEx('txtNomAcumulador').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var nAcumulador=gEx('txtNomAcumulador');
                                                                        var nivelAcumulador=0;
                                                                        
                                                                        if(nAcumulador.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	nAcumulador.focus();
                                                                            }
                                                                            msgBox('Debe indicar el nombre del acumulador',resp);
                                                                            return;
                                                                        }
                                                                        
																		function funcAjax()
                                                                        {
                                                                        	
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                             	gEx('tblGridAcumulador').getStore().loadData(eval(arrResp[1]));
                                                                                gE('arrAcumuladores').value=arrResp[1];
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=68&idPerfil='+gE('idPerfil').value+'&idUsuario=NULL&nAcumulador='+cv(nAcumulador.getValue())+'&idAcumulador='+idAcumulador+'&nivelAcumulador='+nivelAcumulador,true);
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

function modificarValorParametro(iC,iP,o)
{
	
	var arrTiposValor;

    arrTiposValor=[['21','Acumulador'],['1','Constante'],['2','Resultado deducci\xF3n'],['3','Resultado percepci\xF3n']];
	var cmbTipoValor=crearComboExt('cmbTipoValor',arrTiposValor,100,5,310);
    cmbTipoValor.setValue('1');
    function cmbTipoValorChange(combo,registro)
    {
    	switch(registro.get('id'))
        {
        	case '1':
            	gEx('txtValor').show();
                gEx('txtValor').focus();
                gEx('cmbValor').hide()
            break;
            case '21':
            	gEx('txtValor').setValue('');
                gEx('txtValor').hide();
                gEx('cmbValor').show()
            	var cmbValor=gEx('cmbValor');
                cmbValor.getStore().loadData(eval(gE('arrAcumuladores').value));
            break;
            default:
            	gEx('txtValor').setValue('');
                gEx('txtValor').hide();
                gEx('cmbValor').show()
                function funcAjax()
                {
                    var resp=peticion_http.responseText;
                    arrResp=resp.split('|');
                    if(arrResp[0]=='1')
                    {
                        var cmbValor=gEx('cmbValor');
                        var arrDatos=eval(arrResp[1]);
                        cmbValor.getStore().loadData(arrDatos);
                    }
                    else
                    {
                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                    }
                }
                obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=57&idUsuario='+iU+'&orden='+o+'&tipo='+registro.get('id'),true);
            break;
        
        }
        
    }
    cmbTipoValor.on('select',cmbTipoValorChange);
    var cmbValor=crearComboExt('cmbValor',[],100,35,310);
    cmbValor.hide();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de valor:'
                                                        },
                                                        cmbTipoValor,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Valor:'
                                                        },
                                                        cmbValor,
                                                        {
                                                        	id:'txtValor',
                                                            x:100,
                                                            y:35,
                                                            width:80,
                                                            xtype:'textfield',
                                                            hidden:false
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar par&aacute;metro',
										width: 480,
										height:150,
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
                                                                	gEx('txtValor').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var tipo=cmbTipoValor.getValue();
                                                                        var txtValor=gEx('txtValor');
                                                                        var valor;
                                                                        var tipoParametro=1;
                                                                        var valorMostrar='';
                                                                        if(tipo=='1')
                                                                        {
                                                                        	if(txtValor.getValue()=='')
                                                                            {
                                                                            	function resp()
                                                                                {
                                                                                	txtValor.focos();
                                                                                }
                                                                            	msgBox('El valor ingresado no es v&aacute;lido',resp);
                                                                            	return;
                                                                            }
                                                                            valor=txtValor.getValue();
                                                                            valorMostrar=valor;
                                                                        }
                                                                        else
                                                                        {
                                                                        	if(tipo=='21')
                                                                            {
                                                                            	if(cmbValor.getValue()=='')
                                                                                {
                                                                                    msgBox('Debe seleccionar el acumulador que funcionar&aacute; como par&aacute;metro');
                                                                                    return;
                                                                                }
                                                                                valor=cmbValor.getValue();
                                                                                valorMostrar=cmbValor.getRawValue();
                                                                                tipoParametro=21;
                                                                            }
                                                                            else
                                                                            {
                                                                                tipoParametro=2;
                                                                                if(cmbValor.getValue()=='')
                                                                                {
                                                                                    msgBox('Debe seleccionar la opci&oacute;n que funcionar&aacute; como par&aacute;metro');
                                                                                    return;
                                                                                }
                                                                                valor=cmbValor.getValue();
                                                                                valorMostrar=cmbValor.getRawValue();
                                                                            }
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gE('lblValor_'+bD(iC)+'_'+bD(iP)).innerHTML=valorMostrar;
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=58&tipoParam='+tipoParametro+'&valor='+valor+'&idConsulta='+iC+'&idParam='+iP,true);
                                                                        
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


function asignarAcumulador(iC)
{
	var arrOperaciones=[['=','='],['+','+'],['-','-'],['*','x'],['/','/']];
	var cmbOperacion=crearComboExt('cmbOperacion',arrOperaciones,110,5,115);
	var gridAcumuladores=crearGridAcumuladores();
    gridAcumuladores.setPosition(10,40);
    gridAcumuladores.getStore().loadData(eval(gE('arrAcumuladores').value));
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                        	xtype:'label',
                                                            html:'Operaci&oacute;n:'
                                                        },
                                                        cmbOperacion,
														gridAcumuladores

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Adminitraci&oacute;n de acumuladores',
										width: 400,
										height:360,
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
															handler:function()
																	{
                                                                    	if(cmbOperacion.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbOperacion.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar la operaci&oacute;n a realizar sobre el acumulador',resp);
                                                                            return;
                                                                            
                                                                        }
																		var fila=gridAcumuladores.getSelectionModel().getSelected();
                                                                        if(fila==null)
                                                                        {
                                                                        	msgBox('Debe seleccionar el acumulador a utilizar');
                                                                            return;
                                                                        
                                                                        }
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gridCalculos').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=70&idCalculo='+(iC)+'&idAcumulador='+fila.get('idAcumulador')+'&operacion='+cv(cmbOperacion.getValue()),true);
                                                                        
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
    gEx('btnAddAcumulador').hide();
    gEx('btnDelAcumulador').hide();
}

function removerAsignacionAcum(iA)
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
                    var fila=gE('fila_'+bD(iA));
                    fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=71&idAcumulador='+bD(iA),true);
                    }
    }
    msgConfirm('Est&aacute; seguro de querer remover la asignaci&oacute;n del acumulador',resp)
}

function seleccionarTodos(iC)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrChk=gEN('chk_'+bD(iC));
            var x;
            for(x=0;x<arrChk.length;x++)
            {
                arrChk[x].checked=true;
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=65&iC='+bD(iC),true);
}

function agregarPuestoCalculo(iC,c)
{ 
	var gridPuestosCalculo=crearGridPuestosCalculo(iC);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Puestos a considerar para aplicar el calculo: "'+bD(c)+'"'
                                                        },
                                                        gridPuestosCalculo

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Puestos asociados al c&aacute;lculo',
										width: 480,
										height:380,
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
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	llenarPuestosAsociadosCalculo(gridPuestosCalculo.getStore(),ventanaAM,iC);                                

}

function llenarPuestosAsociadosCalculo(almacen,ventana,iC)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            almacen.loadData(eval(arrResp[1]));
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=62&idCalculo='+bD(iC),true);
    

}

function crearGridPuestosCalculo(iC)
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idPuestoVSCalculo'},
                                                                    {name: 'cvePuesto'},
                                                                    {name: 'puesto'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:30}),
														chkRow,
														{
															header:'Clave Puesto',
															width:100,
															sortable:true,
															dataIndex:'cvePuesto'
														},
														{
															header:'Puesto',
															width:250,
															sortable:true,
															dataIndex:'puesto'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                         	id:'gridPuestoAsoc',   
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:450,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar puesto',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaPuestosDisponibles(iC);
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover puesto',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el puesto que desea remover para la aplicaci&oacute;n del c&aacute;lculo');
                                                                                            return;
                                                                                        }
                                                                                        var listDel=obtenerListadoArregloFilas(filas,'idPuestoVSCalculo');
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
                                                                                                     	tblGrid.getStore().remove(filas);   
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=74&listPuesto='+listDel,true);
                                                                                                

                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover los puestos seleccionados?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;		
}

function mostrarVentanaPuestosDisponibles(iC)
{ 
	var gridPuestosCalculoDisponibles=crearGridPuestosCalculosDisponibles();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														
                                                        gridPuestosCalculoDisponibles

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Puestos asociados al c&aacute;lculo',
										width: 480,
										height:380,
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
																		var filas=gridPuestosCalculoDisponibles.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar al menos un puesto para aplicar el c&aacute;lculo');
                                                                            return;
                                                                        }
                                                                        
                                                                        var listaPuestos=obtenerListadoArregloFilas(filas,'idPuesto');
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gridPuestoAsoc').getStore().loadData(eval(arrResp[1]));
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=73&listaPuestos='+listaPuestos+'&idCalculo='+bD(iC),true);
                                                                        
                                                                        
                                                                        
                                                                        
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
	llenarPuestosDisponiblesAsociadosCalculo(gridPuestosCalculoDisponibles.getStore(),ventanaAM,iC);                                

}

function crearGridPuestosCalculosDisponibles()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idPuesto'},
                                                                    {name: 'cvePuesto'},
                                                                    {name: 'puesto'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:30}),
														chkRow,
														{
															header:'Clave Puesto',
															width:100,
															sortable:true,
															dataIndex:'cvePuesto'
														},
														{
															header:'Puesto',
															width:250,
															sortable:true,
															dataIndex:'puesto'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridPuestosDisponibles',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:450,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;		
}

function llenarPuestosDisponiblesAsociadosCalculo(almacen,ventana,iC)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            almacen.loadData(eval(arrResp[1]));
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=63&idCalculo='+bD(iC),true);
    

}

function actualizarAfectacionNomina(radio)
{
	var arrAfectacion=radio.id.split('_');
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	gEx('gridCalculos').getStore().reload();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=51&tipoConcepto=1&afectacion='+arrAfectacion[1]+'&idConcepto='+arrAfectacion[2],true);  
}

function configurarQuincenasAplicacion(idConcepto)
{
	var arrCiclos=<?php echo $arrCiclos?>;
    var arrQuincenasAplicacion=<?php echo $arrQuincenasAplicacion?>;
	var cmbCiclos=crearComboExt('cmbCiclos',arrCiclos,100,5,160);

    var cmbQuincena=crearComboExt('cmbQuincena',arrQuincenasAplicacion,100,35,250,{multiSelect:true});
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                        	html:'Ciclo:'
                                                        },
                                                        cmbCiclos	,
                                                        {
                                                        	xtype:'checkbox',
                                                            x:270,
                                                            y:5,
                                                            id:'chkCualquierCiclo',
                                                            boxLabel:'Cualquier ciclo',
                                                            listeners:	{
                                                            				check:function(chk,checado)
                                                                            		{
                                                                                    	if(checado)
                                                                                        {
                                                                                        	gEx('cmbCiclos').setValue('');
                                                                                        	gEx('cmbCiclos').disable()
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                        	gEx('cmbCiclos').enable()
                                                                                        }
                                                                                    }
                                                            			}
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Quincena:'
                                                        },											
                                                        cmbQuincena
                                                        

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Quincenas de afectaci&oacute;n',
										width: 500,
										height:160,
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
                                                                    	if(!gEx('chkCualquierCiclo').getValue())
                                                                        {
                                                                            if(cmbCiclos.getValue()=='')
                                                                            {
                                                                                function respC()
                                                                                {
                                                                                    cmbCiclos.focus();
                                                                                }
                                                                                
                                                                                msgBox('Debe seleccionar el ciclo al cual pertenece las quincenas en que el c&aacute;lculo ser&aacute; aplicado',respC);
                                                                                return;
                                                                                
                                                                            }
																		}
                                                                        if(cmbQuincena.getValue()=='')
                                                                        {
                                                                        	function respQ()
                                                                            {
                                                                            	cmbQuincena.focus();
                                                                            }
                                                                            
                                                                        	msgBox('Debe seleccionar la primera quincena de afectaci&oacute;',respQ);
                                                                        	return;
                                                                            
                                                                        }
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var posFila=obtenerPosFila(gEx('gridCalculos').getStore(),'idCalculo',idConcepto);
                                                                                var fila=gEx('gridCalculos').getStore().getAt(posFila);
                                                                                fila.set('quincenaAplicacion',arrResp[1]);
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=52&idConcepto='+
                                                                        				idConcepto+'&cualquierCiclo='+(gEx('chkCualquierCiclo').getValue()?1:0)+'&ciclo='+cmbCiclos.getValue()+
                                                                                        '&quincena='+cmbQuincena.getValue(),true);

                                                                        
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

function funcCicloSelect(combo,registro)
{
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
			Ext.getCmp('cmbQuincena').getStore().loadData(eval(arrResp[1]));
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=46&ciclo='+registro.get('id'),true);
    
}

function modificarTipoAfectacion(id)
{
	var idControl='';
	
    idControl='afectacionTipoCta_'+bD(id);
    
	var valor=gE(idControl).innerHTML;
    var tAfectacion='2';
    if(valor=='Debe')
    	tAfectacion='1';
    var cmbTipoAfectacion=crearComboExt('cmbTipoAfectacion',arrTipoAfectacion,130,5,130);
    cmbTipoAfectacion.setValue(tAfectacion);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de afectaci&oacute;n:'
                                                        },
                                                       cmbTipoAfectacion
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	
										title: 'Tipo de afectaci&oacute;n',
										width: 330,
										height:140,
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
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gE(idControl).innerHTML=cmbTipoAfectacion.getRawValue();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=154&id='+id+'&valor='+cmbTipoAfectacion.getValue()+'&tipo=1',true);
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

function eliminarCuenta(id,iC)
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
                	
                	var fila=gE('fila_'+bD(iC)+'_'+bD(id));
                    fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=153&id='+id,true);

        }
    }
    msgConfirm('Est&aacute; seguro de querer remover la cuenta seleccionada y su configuraci&oacute;n',resp)
}

function modficarPorcentaje(id)
{
	var idControl='';
	
    idControl='afectacionCta_'+bD(id);
    
	var valor=gE(idControl).innerHTML;
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Porcentaje:'
                                                        },
                                                        {
                                                        	x:100,
                                                            y:5,
                                                            width:100,
                                                        	xtype:'numberfield',
                                                            allowDecimals:true,
                                                            id:'txtPorcentaje',
                                                            value:valor
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	
										title: 'Porcentaje de afectaci&oacute;n',
										width: 250,
										height:140,
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
                                                                	Ext.getCmp('txtPorcentaje').focus(true,1000);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var porcentaje=Ext.getCmp('txtPorcentaje').getValue();
                                                                        if(porcentaje=='')
                                                                        {
                                                                        	function respP()
                                                                            {
                                                                            	Ext.getCmp('txtPorcentaje').focus();
                                                                                return;
                                                                            }
                                                                            msgBox('El valor ingresado no es v&aacute;lido',respP);
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gE(idControl).innerHTML=porcentaje;
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=154&id='+id+'&valor='+porcentaje+'&tipo=2',true);
                                                                        
                                                                        
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

function modificarTipoRecurso(combo)
{
	var idCombo=combo.id;
    datosCombo=idCombo.split("_");
    iC=datosCombo[1];
    tR=obtenerValorSelect(combo);
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
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=158&idCuenta='+iC+'&tipoPresupuesto='+tR,true);
}

function mostrarVentanaCuenta(iC)
{
	var gridCuenta=generarGridCuenta();
    var cmbTipoAfectacion=crearComboExt('cmbTipoAfectacion',arrTipoAfectacion,115,355);
    cmbTipoAfectacion.setValue('1');
    function aceptarClick()
    {
    	var filaTDoc=gridCuenta.getSelectionModel().getSelections();
        if(filaTDoc.length==0)
        {
            msgBox('Primero debe seleccionar una cuenta');
            return;
        }
        var x;
        var cadCuentas='';
        for(x=0;x<filaTDoc.length;x++)
        {
        	if(cadCuentas=='')
		      	cadCuentas=filaTDoc[x].get('idCuenta')+'|'+filaTDoc[x].get('cuenta');
            else
	        	cadCuentas+=','+filaTDoc[x].get('idCuenta')+'|'+filaTDoc[x].get('cuenta');
        }
        	
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            	gEx('gridCalculos').getStore().reload();
                Ext.getCmp('ventanaCta').close();
                
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=152&idConcepto='+iC+'&tipo=1&cadCuentas='+cadCuentas+'&tAfectacion='+cmbTipoAfectacion.getValue(),true);
        
        
            

    }
    gridCuenta.on('rowdblclick',function()
    									{
                                        	aceptarClick();
                                        }
    						)
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														
                                                        {
                                                        	html:'Seleccione la cuenta a afectar:',
                                                            x:10,
                                                            y:10
                                                        },
                                                        gridCuenta,
                                                        {
                                                        	html:'Tipo afectaci&oacute;n:',
                                                            x:10,
                                                            y:360
                                                        },
                                                        cmbTipoAfectacion
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	
                                        id:'ventanaCta',
										title: 'Cuentas',
										width: 635,
										height:470,
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
															id:'btnTPAceptar',
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		aceptarClick();
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
	
    gridCuenta.getStore().load({params:{funcion:48,idConsulta:iC,accion:1}});                             
	ventanaAM.show();	
}

function generarGridCuenta()
{
    var alDatos = new Ext.data.JsonStore	(
                                                        {
                                                            root: 'registros',
                                                            totalProperty: 'numReg',
                                                            idProperty: 'codigo',
                                                            fields:	[
                                                            			{name: 'idCuenta'},
                                                                        {name: 'cuenta'},
		                                                                {name: 'estructura'}
                                                                    ],
                                                            remoteSort:false,
                                                            proxy: new Ext.data.HttpProxy	(
                                                                                                {
                                                                                                    url: '../paginasFunciones/funcionesContabilidad.php'
                                                                                                }
                                                                                            )
                                                        }
                                                    );                                            

    
    var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[
                                                        				{
                                                                            type:'string',
                                                                           	dataIndex:'cuenta' 
																		},
                                                                        {
                                                                            type:'string',
                                                                           	dataIndex:'estructura' 
																		}
                                                        			]
                                                    }
                                                ); 
    var chkRow=new Ext.grid.CheckboxSelectionModel();
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
                                                        chkRow,
														{
															header:'Cuenta',
															width:180,
															sortable:true,
															dataIndex:'cuenta'
														},
                                                        {
															header:'Estructura',
															width:320,
															sortable:true,
															dataIndex:'estructura'
														}
														
													]
												);
                                                
	var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridCuentas',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:300,
                                                            width:580,
                                                            sm:chkRow,
                                                            loadMask:true,
                                                            plugins: filters
                                                            
                                                        }
                                                    );
	return 	tblGrid;
}

function actualizaAfectacion(check)
{
	var accion='-1';
	if(check.checked)
    	accion="1";
    var arrAfectacion=check.id.split('_');
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
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=50&accion='+accion+'&tipoConcepto=1&afectacion='+arrAfectacion[1]+'&idConcepto='+arrAfectacion[2],true);  
}

function mostrarVentanaConfiguraciones()
{
	var arrSiNo=[['0','No'],['1','S\xED']];
	var cmbPeriodicidad=crearComboExt('cmbPeriodicidad',arrPeriodicidad,145,105,250);
	var arrAccionesDecimales=[['1','Truncar'],['2','Redondear']];
    var cmbAcciones=crearComboExt('cmbAcciones',arrAccionesDecimales,410,195,140);
    var cmbAsistencia=crearComboExt('cmbAsistencia',arrSiNo,230,225,120);
	var cmbLimitarFechas=crearComboExt('cmbLimitarFechas',arrSiNo,180,135,120);
    cmbLimitarFechas.setValue('1');
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Nombre del perfil:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            x:145,
                                                            y:5,
                                                            id:'txtNombrePerfil',
                                                            width:400
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	xtype:'textarea',
                                                            x:145,
                                                            y:35,
                                                            width:500,
                                                            height:60,
                                                            
                                                            id:'txtDescripcion'
                                                        },
                                                         {
                                                        	x:10,
                                                            y:110,
                                                            html:'Periodicidad de pago:<span class="letraRoja">*</span>'
                                                        },
                                                        cmbPeriodicidad,
                                                        {
                                                        	x:10,
                                                            y:140,
                                                            html:'Limitar fechas de periodo?:<span class="letraRoja">*</span>'
                                                        },
                                                        cmbLimitarFechas,
                                                        
                                                        {
                                                        	x:10,
                                                            y:170,
                                                            html:'No. de decimales a utlizar en los resultados de calculos (Presici&oacute;n):'
                                                        },
                                                        {
                                                        	xtype:'numberfield',
                                                            width:80,
                                                            id:'noDecimales',
                                                            allowDecimal:false,
                                                            allowNegative:false,
                                                            x:410,
                                                            y:165
                                                            
                                                        },
                                                        {
                                                        	x:10,
                                                            y:200,
                                                            html:'Acci&oacute;n a realizar al sobrepasar el n&uacute;mero de decimales permitidos:'
                                                        },
                                                        cmbAcciones,
                                                        {
                                                        	x:10,
                                                            y:230,
                                                            html:'¿Considerar periodo de inasistencias?:'
                                                        },
                                                        cmbAsistencia,
                                                        {
                                                        	x:10,
                                                            y:260,
                                                            html:'Para configurar las acciones que se realizar&aacute;n al recalcular una n&oacute;mina de click <a href="javascript:accionesReprocesamiento()"><span style="color:#F00 "><b>AQU&Iacute;</b></span></span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:290,
                                                            html:'Para configurar las acciones que se realizar&aacute;n al eliminar una n&oacute;mina de click <a href="javascript:accionesEliminacion()"><span style="color:#F00 "><b>AQU&Iacute;</b></span></span>'
                                                        }
														

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar perfil de n&oacute;mina',
										width: 750,
										height:400,
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
                                                                	gEx('txtNombrePerfil').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		if(gEx('txtNombrePerfil').getValue()=='')
                                                                        {
                                                                        	msgBox('Debe ingresar el nombre del perfil a crear');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var noDecimales=gEx('noDecimales');
                                                                        if(noDecimales.getValue()=='')
                                                                        {
                                                                        	
                                                                        	msgBox('Debe ingresar la precision a utilizar en los valores generados por los c&aacute;lculos pertenecientes a este perfil');
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbAcciones.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe indicar la acci&oacute;n a realizar al sobrepasar el n&uacute;mero de decimales permitidos');
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbPeriodicidad.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbPeriodicidad.focus();
                                                                            }
                                                                            msgBox('Debe indicar la periodicidad de pago',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=13&limitarFechasPeriodo='+cmbLimitarFechas.getValue()+'&considerarAsistencia='+cmbAsistencia.getValue()+'&idPeriodicidad='+cmbPeriodicidad.getValue()+'&idPefil='+gE('idPerfil').value+'&accion='+cmbAcciones.getValue()+'&precision='+noDecimales.getValue()+'&nombrePerfil='+cv(gEx('txtNombrePerfil').getValue())+'&descripcion='+cv(gEx('txtDescripcion').getValue()),true);

                                                                        
                                                                        
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
	
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var obj=eval('['+arrResp[1]+']')[0];
            gEx('txtNombrePerfil').setValue(obj.nombrePerfil);
            gEx('txtDescripcion').setValue(obj.descripcion);
            gEx('noDecimales').setValue(obj.precisionDecimales);
            cmbAcciones.setValue(obj.criterioPrecision);
            cmbPeriodicidad.setValue(obj.idPeriodicidad);
            cmbAsistencia.setValue(obj.considerarAsistencia);
            cmbLimitarFechas.setValue(obj.limitarFechasPeriodo);
            ventanaAM.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=14&idPefil='+gE('idPerfil').value,true);
}

function accionesReprocesamiento()
{
	var objConf={};
    objConf.titulo="Funci&oacute;n de reprocesamiento";
    objConf.ancho="100%";
    objConf.alto="90%";
    objConf.url='../nomina/conceptosNomina.php';
    
    
    
	var idFuncionRecalculo=gE('idFuncionRecalculo').value;
	if((idFuncionRecalculo==-1)||(idFuncionRecalculo==''))
    {
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                gE('idFuncionRecalculo').value=arrResp[1];
                objConf.params=[['idConsulta',arrResp[1]],['mCerrar','1'],['ocultarAdmonParam','1']];
                abrirVentanaFancy(objConf);
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=30&accion=1&idPerfil='+gE('idPerfil').value,true);
	}
    else
    {
    	objConf.params=[['idConsulta', gE('idFuncionRecalculo').value],['mCerrar','1'],['ocultarAdmonParam','1']];
        abrirVentanaFancy(objConf);
    }
}

function accionesEliminacion()
{
	var objConf={};
    objConf.titulo="Funci&oacute;n de eliminaci&oacute;n";
    objConf.ancho="100%";
    objConf.alto="90%";
    objConf.url='../nomina/conceptosNomina.php';
    
    
    
	var idFuncionEliminacion=gE('idFuncionEliminacion').value;
	if((idFuncionEliminacion==-1)||(idFuncionEliminacion==''))
    {
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                gE('idFuncionEliminacion').value=arrResp[1];
                objConf.params=[['idConsulta',arrResp[1]],['mCerrar','1'],['ocultarAdmonParam','1']];
                abrirVentanaFancy(objConf);
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=30&accion=-1&idPerfil='+gE('idPerfil').value,true);
	}
    else
    {
    	objConf.params=[['idConsulta', gE('idFuncionEliminacion').value],['mCerrar','1'],['ocultarAdmonParam','1']];
        abrirVentanaFancy(objConf);
    }
}

function mostrarVentanaEtiquetaAgrupadora()
{
	var gEtiquetas=crearGridEtiquetaAgrupadora();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gEtiquetas

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Etiquetas agrupadoras',
										width: 500,
										height:350,
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
																		ventanaAM.close();
																	}
															}
													]
									}
								);
	ventanaAM.show();	



}


function crearGridEtiquetaAgrupadora()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			 {name: 'idEtiqueta'},
                                                         {name: 'clave'},
                                                         {name: 'etiqueta'},
                                                         {name: 'idCategoria'},
                                                         {name: 'idCategoriaSAT'}
                                                         
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesEspecialesNomina.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'idCategoria', direction: 'ASC'},
                                                            groupField: 'idCategoria',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='37';
                                        proxy.baseParams.idPerfil=gE('idPerfil').value;
                                    }
                        )   
       
    
    alDatos.on('load',function(proxy)
    								{
                                    	arrEtiquetasAgr=[['0','Ninguna']];
                                        var x;
                                        var o;
                                        for(x=0;x<proxy.data.items.length;x++)
                                        {
                                        	o=proxy.data.items[x];
                                            arrEtiquetasAgr.push([o.idEtiqueta,o.clave,o.etiqueta]);
                                        }

                                    }
                        )   
       
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'Clave',
                                                                width:110,
                                                                sortable:true,
                                                                dataIndex:'clave'
                                                            },
                                                            {
                                                                header:'Etiqueta',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'etiqueta'
                                                            },
                                                            {
                                                                header:'Categor&iacute;a',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'idCategoria',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoCalculos,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Categor&iacute;a SAT',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'idCategoriaSAT',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	switch(registro.data.idCategoria)
                                                                            {
                                                                                case '1':
                                                                                    
                                                                                    return formatearValorRenderer(arrTipoDeduccion,val);
                                                                                break;
                                                                                case '2':
                                                                                	 return formatearValorRenderer(arrTipoPercepcion,val);

                                                                                break;
                                                                            }
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gEtiquetasNomina',
                                                                store:alDatos,
                                                                y:10,
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                height:250,
                                                                tbar:	[
                                                                            {
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar etiqueta',
                                                                                handler:function()
                                                                                        {
                                                                                             mostrarVentanaAgregarEtiqueta();	
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Modificar etiqueta',
                                                                                handler:function()
                                                                                        {
                                                                                        	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                                msgBox('Debe seleccionar la etiqueta agrupadora que desea modificar');
                                                                                                return;
                                                                                            }
                                                                                             mostrarVentanaAgregarEtiqueta(fila);	
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover etiqueta',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                                msgBox('Debe seleccionar la etiqueta agrupadora que desea remover');
                                                                                                return;
                                                                                            }
                                                                                            
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
                                                                                                            gEx('gEtiquetasNomina').getStore().reload();
                                                                                                            
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=38&idEtiqueta='+fila.data.idEtiqueta,true);
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover la etiqueta agrupadora seleccionada?',resp)
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                        ],
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: true,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;
    
    
}

function mostrarVentanaAgregarEtiqueta(fila)
{
	var arrTipoConcepto2=[['1','Deducci\xF3n','900'],['2','Percepci\xF3n','030']];
    
    var cmbCategoriaEtiqueta=crearComboExt('cmbCategoriaEtiqueta',arrTipoConcepto2,110,65,250);
    cmbCategoriaEtiqueta.on('select',function(cmb,registro)
    								{
                                    	gEx('cmbCategoriaEtiquetaSAT').setValue('');
                                    	switch(registro.data.id)
                                        {
                                        	case '1':
                                            	
                                            	gEx('cmbCategoriaEtiquetaSAT').getStore().loadData(arrTipoDeduccion);
                                            break;
                                            case '2':
                                            	gEx('cmbCategoriaEtiquetaSAT').getStore().loadData(arrTipoPercepcion);
                                            break;
                                        }
                                    }
    						)
     var cmbCategoriaEtiquetaSAT=crearComboExt('cmbCategoriaEtiquetaSAT',[],110,95,350);
    
	var lblEtiqueta='Agregar etiqueta';
    if(fila)
    	lblEtiqueta='Modificar etiqueta';
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Clave:'
                                                        },
                                                        {
                                                        	id:'txtClave',
                                                        	x:110,
                                                            y:5,
                                                            width:120,
                                                            xtype:'textfield'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Etiqueta:'
                                                        },
                                                         {
                                                        	id:'txtEtiqueta',
                                                        	x:110,
                                                            y:35,
                                                            width:320,
                                                            xtype:'textfield'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Categor&iacute;a:'
                                                        },
                                                        cmbCategoriaEtiqueta,
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'Clasificaci&oacute;n SAT:'
                                                        },
                                                        cmbCategoriaEtiquetaSAT


													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: lblEtiqueta,
										width: 500,
										height:220,
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
                                                                	gEx('txtClave').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtEtiqueta=gEx('txtEtiqueta');
                                                                        var txtClave=gEx('txtClave');
                                                                        
                                                                        if(txtEtiqueta.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtEtiqueta.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el nonbre de la etiqueta agrupadora',resp1);
                                                                            return;
                                                                        }
                                                                        var idEtiqueta=-1;
                                                                        if(fila)
                                                                        	idEtiqueta=fila.data.idEtiqueta;
                                                                            
                                                                        if(cmbCategoriaEtiqueta.getValue()=='')    
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbCategoriaEtiqueta.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la categor&iacute;a de la etiqueta agrupadora',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbCategoriaEtiquetaSAT.getValue()=='')    
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	cmbCategoriaEtiquetaSAT.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la categor&iacute;a del SAT al cual desea asociar la etiqueta agrupadora',resp3);
                                                                            return;
                                                                        }
                                                                            
                                                                        var cadObj='{"idCategoria":"'+cmbCategoriaEtiqueta.getValue()+'","idCategoriaSAT":"'+cmbCategoriaEtiquetaSAT.getValue()+'","idPerfil":"'+gE('idPerfil').value+'","idEtiqueta":"'+idEtiqueta+'","clave":"'+cv(txtClave.getValue())+'","etiqueta":"'+cv(txtEtiqueta.getValue())+'"}';
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('gEtiquetasNomina').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=36&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                        
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
    if(fila)
    {
    	var txtEtiqueta=gEx('txtEtiqueta');
        txtEtiqueta.setValue(fila.data.etiqueta);
		var txtClave=gEx('txtClave');
        txtClave.setValue(fila.data.clave);
        cmbCategoriaEtiqueta.setValue(fila.data.idCategoria);
        switch(fila.data.idCategoria)
        {
            case '1':
                
                gEx('cmbCategoriaEtiquetaSAT').getStore().loadData(arrTipoDeduccion);
            break;
            case '2':
                gEx('cmbCategoriaEtiquetaSAT').getStore().loadData(arrTipoPercepcion);
            break;
        }
        cmbCategoriaEtiquetaSAT.setValue(fila.data.idCategoriaSAT);
   	}
}

function mostrarVentanaAsignacionInstitucion()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Especifique las instituciones que podr&aacute;n hacer uso de este perfil:'
                                                        },
                                                        crearGridInstitucionesPerfil()

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asginaci&oacute;n de instituci&oacute;n',
										width: 600,
										height:350,
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
																		var gridAsignacionInstitucion=gEx('gridAsignacionInstitucion');
                                                                        var x;
                                                                        var fila;
                                                                        var arrInstituciones='';
                                                                        
                                                                        for(x=0;x<gridAsignacionInstitucion.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gridAsignacionInstitucion.getStore().getAt(x);
                                                                            if(fila.data.aplica)
                                                                            {
                                                                            	if(arrInstituciones=='')
                                                                                	arrInstituciones=fila.data.codigoInstitucion;
                                                                                else
                                                                                	arrInstituciones+=','+fila.data.codigoInstitucion;
                                                                            }
                                                                        }
                                                                        
                                                                        
                                                                        var cadObj='{"idPerfil":"'+gE('idPerfil').value+'","arrInstituciones":"'+arrInstituciones+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=40&cadObj='+cadObj,true);
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

function crearGridInstitucionesPerfil()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'codigoInstitucion'},
		                                                {name: 'institucion'},
		                                                {name:'aplica'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesEspecialesNomina.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'institucion', direction: 'ASC'},
                                                            groupField: 'institucion',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='39';
                                        proxy.baseParams.idPerfil=gE('idPerfil').value;
                                    }
                        )   
   
   
   var checkColumn = new Ext.grid.CheckColumn	(
	 												{
													   header: 'Aplica',
													   dataIndex: 'aplica',
													   width: 80
													}
												);
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer({width:40}),
                                                        
                                                        {
                                                            header:'Instituci&oacute;n / Centro de Trabajo',
                                                            width:400,
                                                            sortable:true,
                                                            dataIndex:'institucion',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        checkColumn
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridAsignacionInstitucion',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            height:270,
                                                            cm: cModelo,
                                                            plugins:	[checkColumn],
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,                                                            
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



function agregarClasificadorCalculo()
{
	
	var gridClasificador=crearGridClasificadorCalculo();
    gridClasificador.getStore().loadData(arrClasificadoresCalculo);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridClasificador

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Administraci&oacute;n de Clasificadores de C&aacute;lculo',
										width: 460,
										height:360,
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

function crearGridClasificadorCalculo()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                        			{name: 'idClasificador'},
                                                                    {name: 'nombreClasificador'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
                                                        {
															header:'ID',
															width:60,
															sortable:true,
															dataIndex:'idClasificador'
														},	
														{
															header:'Nombre Clasificador',
															width:250,
															sortable:true,
															dataIndex:'nombreClasificador'
														}													
                                                   ]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'tblGridClasificador',
                                                            store:alDatos,
                                                            frame:false,
                                                            x:10,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:420,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	id:'btnAddClasificador',
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar Clasificador',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarClasificador('-1');
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	id:'btnDelClasificador',
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover Clasificador',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el clasificador a remover');
                                                                                            return;
                                                                                        }
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
                                                                                                     	tblGrid.getStore().remove(fila);
                                                                                                        
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=104&idClasificador='+fila.get('idClasificador'),true);
                                                                                                    
                                                                                            
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el clasificador seleccionado?',resp)
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;		
}

function mostrarVentanaAgregarClasificador(idClasificador)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                        	xtype:'label',
                                                            html:'Nombre del Clasificador:'
                                                            
                                                        },
                                                        {
                                                        	x:150,
                                                            y:5,
                                                        	xtype:'textfield',
                                                            id:'txtNomClasificador',
                                                            width:240
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Clasificador',
										width: 450,
										height:130,
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
                                                                	gEx('txtNomClasificador').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var nAcumulador=gEx('txtNomClasificador');
                                                                       
                                                                        
                                                                        if(nAcumulador.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	nAcumulador.focus();
                                                                            }
                                                                            msgBox('Debe indicar el nombre del txtNomClasificador',resp);
                                                                            return;
                                                                        }
                                                                        
																		function funcAjax()
                                                                        {
                                                                        	
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                             	gEx('tblGridClasificador').getStore().loadData(eval(arrResp[1]));
                                                                                arrClasificadoresCalculo=eval(arrResp[1]);
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=103&idPerfil='+gE('idPerfil').value+'&nClasificador='+cv(nAcumulador.getValue()),true);
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


function agregarClasificadorCalculoNomina(iC)
{
	var gridClasificador=crearGridClasificadorCalculoSeleccion();
    gridClasificador.getStore().loadData(arrClasificadoresCalculo);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione los clasificadores que dese agregar al c&aacute;lculo:'
                                                        },
														gridClasificador

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Clasificador a C&aacute;lculo',
										width: 460,
										height:360,
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
																		var filas=gridClasificador.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar almenos un clasificador a agregar al c&aacute;lculo');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var idClasificadores='';
                                                                        var x;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	if(idClasificadores=='')
                                                                            	idClasificadores=	filas[x].data.idClasificador;
                                                                            else
                                                                            	idClasificadores+=','+	filas[x].data.idClasificador;
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gridCalculos').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=105&iCalculo='+iC+'&idClasificadores='+idClasificadores,true);
                                                                        
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


function crearGridClasificadorCalculoSeleccion()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                        			{name: 'idClasificador'},
                                                                    {name: 'nombreClasificador'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
                                                        {
															header:'ID',
															width:60,
															sortable:true,
															dataIndex:'idClasificador'
														},	
														{
															header:'Nombre Clasificador',
															width:250,
															sortable:true,
															dataIndex:'nombreClasificador'
														}													
                                                   ]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'tblGridClasificador',
                                                            store:alDatos,
                                                            frame:false,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:220,
                                                            width:420,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;		
}

function removerClasificadorCalculo(iR)
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
                    var fila=gE('filaClasificador_'+bD(iR));
                    fila.parentNode.removeChild(fila);
                    
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=106&iRegistro='+bD(iR),true);
            
        }
    }
    msgConfirm('Est&aacute; seguro de querer remover el clasificador seleccionado?',resp);
}


function agregarFiltroAfectacionCalculo(iC)
{
	var arrTiposElementos=[['1','Tipo de Contrataci\xF3n'],['2','Clasificaci\xF3n del Puesto'],['3','Puesto']];
    var cmbTipoElemento=crearComboExt('cmbTipoElemento',arrTiposElementos,150,5,300);
    cmbTipoElemento.setValue('1');
	cmbTipoElemento.on('select',function(cmb,registro)
    							{
                                	switch(registro.data.id)
                                    {
                                    	case '1':
                                        	gEx('cmbTiposContratacion').setValue('');
                                            gEx('cmbTiposContratacion').show();
                                            gEx('cmbClasificacionPuesto').hide();
                                            gEx('cmbCatalogoPuestos').hide();
                                            gE('lblElemento').innerHTML='Tipo de Contrataci\xF3n:';
                                        break;
                                        case '2':
                                        	gEx('cmbClasificacionPuesto').setValue('');
                                            gEx('cmbTiposContratacion').hide();
                                            gEx('cmbClasificacionPuesto').show();
                                            gEx('cmbCatalogoPuestos').hide();
                                            gE('lblElemento').innerHTML='Clasificaci\xF3n del Puesto:';
                                        break;
                                        case '3':
                                        	gEx('cmbCatalogoPuestos').setValue('');
                                            gEx('cmbTiposContratacion').hide();
                                            gEx('cmbClasificacionPuesto').hide();
                                            gEx('cmbCatalogoPuestos').show();
                                            gE('lblElemento').innerHTML='Puesto:';
                                        break;
                                    }
                                }
    				)

	var cmbTiposContratacion=crearComboExt('cmbTiposContratacion',arrCatalogoTiposContratacion,150,35,400,{multiSelect:true});
    var cmbClasificacionPuesto=crearComboExt('cmbClasificacionPuesto',arrCatalogoClasificacionPuestos,150,35,400,{multiSelect:true});
    cmbClasificacionPuesto.hide();
    var cmbCatalogoPuestos=crearComboExt('cmbCatalogoPuestos',arrCatalogoPuestos,150,35,400,{multiSelect:true});
	cmbCatalogoPuestos.hide();

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de Elemento:'
                                                        },
                                                        cmbTipoElemento,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'<span id="lblElemento">Tipo de Contrataci&oacute;n:</span>'
                                                        },
                                                        cmbTiposContratacion,
                                                        cmbClasificacionPuesto,
                                                        cmbCatalogoPuestos
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Filtro de Afectaci&oacute;n',
										width: 600,
										height:150,
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
                                                                    
                                                                    	var cmbComboElemento;
                                                                        switch(gEx('cmbTipoElemento').getValue())
                                                                        {
                                                                            case '1':
                                                                                cmbComboElemento=gEx('cmbTiposContratacion');
                                                                            break;
                                                                            case '2':
                                                                                cmbComboElemento=gEx('cmbClasificacionPuesto');
                                                                            break;
                                                                            case '3':
                                                                                cmbComboElemento=gEx('cmbCatalogoPuestos');
                                                                            break;
                                                                        }
                                                                        
                                                                        if(cmbComboElemento.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar almenos un elemento como filtro del c&aacute;lculo');
                                                                        	return;
                                                                        }
                                                                    
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
                                                                                    	var posFila=obtenerPosFila(gEx('gridCalculos').getStore(),'idCalculo',bD(iC));
                                                                                        var fila=gEx('gridCalculos').getStore().getAt(posFila);
                                                                                        fila.set('aplicacionCalculo',arrResp[1]);
                                                                                        ventanaAM.close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=108&iC='+bD(iC)+'&iE='+cmbComboElemento.getValue()+'&tE='+gEx('cmbTipoElemento').getValue(),true);
                                                                                
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer agregar los elementos seleccionados como filtro del c&aacute;lculo?',resp);
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

function removerFiltro(iR)
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
                    var fila=gE('filaFiltro_'+bD(iR));
                    fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=109&iR='+bD(iR),true);
            
        }
    }
    msgConfirm('Est&aacute; seguro de querer remover el filtro seleccionado?',resp);
}


function removerQuincenaAplicacion(iR)
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
                    var fila=gE('filaQuincena_'+bD(iR));
                    fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=110&iR='+bD(iR),true);
            
        }
    }
    msgConfirm('Est&aacute; seguro de querer remover la quincena seleccionada?',resp);
}