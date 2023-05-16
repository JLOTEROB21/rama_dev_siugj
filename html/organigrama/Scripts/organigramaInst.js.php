<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php"); 
	$consulta="select idPais,upper(nombre) from 238_paises order by nombre";
	$arrPaises=uEJ($con->obtenerFilasArreglo($consulta));
	//$consulta="select codigoUnidad,tituloCentroC from 506_centrosCosto order by codigoCompleto,tituloCentroC";
	$arrCentroC="[]";//uEJ($con->obtenerFilasArreglo($consulta));
	//$consulta="select id_650_zonas,NombreZona from 650_zonas order by NombreZona";
	$arrZonas="[]";//uEJ($con->obtenerFilasArreglo($consulta));
	//$consulta="select idEstado,upper(estado) from  654_estadoTabulacion order by estado";
	$arrStatus="[]";//uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="SELECT cveEstado,upper(estado) FROM  820_estados ORDER BY estado";
	$arrEstados=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT idTipoPuesto,nombreTipoPuesto FROM 664_tiposPuesto   order by nombreTipoPuesto";
	$arrTipoPuesto=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT idCategoriaUnidadOrganigrama,nombreCategoria,objConfiguracion FROM 817_categoriasUnidades ORDER BY nombreCategoria";
	$arrCategorias=$con->obtenerFilasArreglo($consulta);
	
	//$consulta="SELECT idRiesgo,descripcion FROM 684_riesgoPuestoSAT ORDER BY descripcion";
	$arrRiesgo="[]";//$con->obtenerFilasArreglo($consulta);
	
	$administradorGlobal=false;
	if(existeRol("'-3001_0'"))
		$administradorGlobal=true;
	
	$consulta="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE institucion=16 ORDER BY unidad";
	$arrJurisdiccion=$con->obtenerFilasArreglo($consulta);

	$arrEspecialidad="";
	
	$consulta="SELECT id__637_tablaDinamica,nombreEspecialidadDespacho FROM _637_tablaDinamica WHERE idEstado=2 ORDER BY nombreEspecialidadDespacho";
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		$consulta="SELECT id__637_gridDetallesAdicionales,detalleAdicional FROM _637_gridDetallesAdicionales WHERE idReferencia=".$fila["id__637_tablaDinamica"]." ORDER BY detalleAdicional";
		$arrDetalleEspecialidad=$con->obtenerFilasArreglo($consulta);
		
		$o="['".$fila["id__637_tablaDinamica"]."','".cv($fila["nombreEspecialidadDespacho"])."',".$arrDetalleEspecialidad."]";
		if($arrEspecialidad=="")
			$arrEspecialidad=$o;
		else
			$arrEspecialidad.=",".$o;
	}
	
	$arrEspecialidad="[".$arrEspecialidad."]";
	
	$consulta="SELECT DISTINCT claveDepartamental,unidad FROM 817_organigrama WHERE institucion=17 ORDER BY unidad";
	$arrCategoriasAGrupadoras=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT DISTINCT claveDepartamental,unidad FROM 817_organigrama WHERE institucion=10 ORDER BY unidad";
	$arrDistritosJudiciales=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT DISTINCT claveDepartamental,unidad FROM 817_organigrama WHERE institucion=12 ORDER BY unidad";
	$arrCiurcuitosJudiciales=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__636_tablaDinamica,nombreAtributo FROM _636_tablaDinamica ORDER BY nombreAtributo";
	$arrAtributosDespacho=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__625_tablaDinamica,nombreTipoProceso FROM _625_tablaDinamica WHERE esTipoProceso=1 ORDER BY nombreTipoProceso";
	$arrTiposProcesosCompete=$con->obtenerFilasArreglo($consulta);
?>
var arrTiposProcesosCompete=<?php echo $arrTiposProcesosCompete?>;
var arrAtributosDespacho=<?php echo $arrAtributosDespacho?>;
var primeraCarga='1';
var arrDistritosJudiciales=<?php echo $arrDistritosJudiciales?>;
var arrCiurcuitosJudiciales=<?php echo $arrCiurcuitosJudiciales?>;
var arrCategoriasAGrupadoras=<?php echo $arrCategoriasAGrupadoras?>;
var arrEspecialidades=<?php echo $arrEspecialidad?>;
var arrJurisdiccion=<?php echo $arrJurisdiccion?>;
var arrPaises=<?php echo $arrPaises?>;
var estadoSel=null;
var  municipioSel=null;
var idNodoSeleccionado=-1;
var soloAdmonUnidades=true;
var puedeModificarUnidadRaiz=false;
var cveMunicipio='';
var idCodRaiz;
Ext.onReady(inicializar)
var nuevoReg=false;
var arrTipoPuesto=<?php echo $arrTipoPuesto?>;
var arrZonas=<?php echo $arrZonas?>;
var arrCategorias=<?php echo $arrCategorias?>;
var arrRiesgo=<?php echo $arrRiesgo?>;
var idUsuario=-1;
function inicializar()
{
	idCodRaiz=gE('idCodRaiz').value;
	
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                cls:'panelSiugjWrap',
                                                border:false,
                                                title: 'Organigrama',
                                                
                                                items:	[
                                                			{
                                                            	xtype:'panel',
                                                                region:'north',
                                                                height:240,
                                                      			border:false,
                                                                cls:'panelSiugj',
                                                                collapsible:true,
                                                                layout:'absolute',
                                                                items:	[
                                                                			{
                                                                                xtype:'label',
                                                                                x:10,
                                                                                y:20,
                                                                                html:'<div class="letraNombreTableroNegro">Jurisdicci&oacute;n:</div>'
                                                                            },
                                                                            
                                                                            {
                                                                                xtype:'label',
                                                                                x:130,
                                                                                y:15,
                                                                                html:'<div id="divJurisdiccion"></div>'
                                                                            },
                                                                            
                                                                            {
                                                                                xtype:'label',
                                                                                x:500,
                                                                                y:20,
                                                                                html:'<div class="letraNombreTableroNegro">Especialidad:</div>'
                                                                            },
                                                                            
                                                                            {
                                                                                xtype:'label',
                                                                                x:630,
                                                                                y:15,
                                                                                html:'<div id="divEspecialidad"></div>'
                                                                            },
                                                                            
                                                                            {
                                                                                xtype:'label',
                                                                                x:980,
                                                                                y:15,
                                                                                html:'<div id="divDetalleEspecialidad"></div>'
                                                                            },
                                                                            
                                                                            {
                                                                            	xtype:'label',
                                                                                x:10,
                                                                                y:70,
                                                                                html:'<div class="letraNombreTableroNegro">Categor&iacute;a:</div>'
                                                                            },
                                                                            
                                                                            {
                                                                                xtype:'label',
                                                                                x:130,
                                                                                y:65,
                                                                                html:'<div id="divCategorias"></div>'
                                                                            },
                                                                            
                                                                            {
                                                                            	xtype:'label',
                                                                                x:430,
                                                                                y:70,
                                                                                html:'<div class="letraNombreTableroNegro">Distrito judicial:</div>'
                                                                            },
                                                                            
                                                                            {
                                                                                xtype:'label',
                                                                                x:580,
                                                                                y:65,

                                                                                html:'<div id="divDistrito"></div>'
                                                                            },
                                                                            
                                                                            {
                                                                            	xtype:'label',
                                                                                 x:880,
                                                                                y:70,
                                                                                html:'<div class="letraNombreTableroNegro">Circuito judicial:</div>'
                                                                            },
                                                                            
                                                                            {
                                                                                xtype:'label',
                                                                                 x:1040,
                                                                                y:65,
                                                                                html:'<div id="divCircuito"></div>'
                                                                            },
                                                                            
                                                                            {
                                                                                xtype:'label',
                                                                                x:10,
                                                                                y:120,
                                                                                html:'<div class="letraNombreTableroNegro">Municipio:</div>'
                                                                            },
                                                                            
                                                                            {
                                                                                xtype:'label',
                                                                                x:130,
                                                                                y:120,
                                                                                html:'<div id="divMunicipios" style="width:280px"></div>'
                                                                            },
                                                                            
                                                                            {
                                                                                xtype:'label',
                                                                                x:430,
                                                                                y:120,
                                                                                html:'<div class="letraNombreTableroNegro">Nombre del despacho:</div>'
                                                                            },
                                                                            
                                                                            {
                                                                                xtype:'textfield',
                                                                                x:630,
                                                                                y:120,
                                                                                width:280,
                                                                                id:'txtNombreDespacho',
                                                                                cls:'controlSIUGJ'
                                                                            },
                                                                            
                                                                            {
                                                                                xtype:'label',
                                                                                x:965,
                                                                                y:120,
                                                                                html:'<div class="letraNombreTableroNegro">Clave:</div>'
                                                                            },
                                                                           
                                                                            {
                                                                                xtype:'textfield',
                                                                                width:280,
                                                                                x:1040,
                                                                                y:120,
                                                                                id:'txtClave',
                                                                                cls:'controlSIUGJ'
                                                                            },
                                                                            {
                                                                                xtype:'label',
                                                                                x:10,
                                                                                y:170,
                                                                                html:'<div class="letraNombreTableroNegro">Atributos del despacho:</div>'
                                                                            },
                                                                            {
                                                                                xtype:'label',
                                                                                x:240,
                                                                                y:165,
                                                                                html:'<div id="divAtributosDespacho"></div>'
                                                                            },
                                                                            {
                                                                                xtype:'label',
                                                                                x:630,
                                                                                y:170,
                                                                                html:'<div class="letraNombreTableroNegro">Tipos de procesos de su competencia:</div>'
                                                                            },
                                                                            {
                                                                                xtype:'label',
                                                                                x:980,
                                                                                y:165,
                                                                                html:'<div id="divProcesosCompete"></div>'
                                                                            }
                                                                            
                                                                            
                                                                		]
                                                            },
                                                			{
                                                             	xtype:'panel',
                                                                region:'center',
                                                                layout:'border',
                                                                border:false,
                                                                
                                                                items:	[
                                                                			{
                                                                                xtype:'panel',
                                                                                region:'center',
                                                                                layout:'border',
                                                                                border:false,
                                                                                
                                                                                items:	[
                                                                                            {
                                                                                                xtype:'panel',
                                                                                                region:'center',
                                                                                                layout:'border',
                                                                                                border:false,
                                                                                                tbar:	[
                                                                                                            {
                                                                                                                icon:'../images/chart_organisation.png',
                                                                                                                cls:'x-btn-text-icon',
                                                                                                                text:'Administraci&oacute;n de Unidades',
                                                                                                                menu:	[
                                                                                                                            <?php
                                                                                                                            if($administradorGlobal)
                                                                                                                            {
                                                                                                                            ?>
                                                                                                                            {
                                                                                                                                text:'Agregar Unidad',
                                                                                                                                icon:'../images/add.png',
                                                                                                                                cls:'x-btn-text-icon',
                                                                                                                                handler:function()
                                                                                                                                        {
                                                                                                                                            agregarUnidad('',1);
                                                                                                                                        }
                                                                                                                            },'-',
                                                                                                                            <?php
                                                                                                                            }
                                                                                                                            ?>
                                                                                                                            {
                                                                                                                                text:'Agregar Unidad Hija',
                                                                                                                                icon:'../images/add.png',
                                                                                                                                cls:'x-btn-text-icon',
                                                                                                                                handler:function()
                                                                                                                                        {
                                                                                                                                            if(nodoSel==null)
                                                                                                                                            {
                                                                                                                                                msgBox('Debe seleccionar la unidad al cual desea agregar una unidad hija');
                                                                                                                                                return;
                                                                                                                                            }
                                                                                                                                            
                                                                                                                                            
                                                                                                                                            mostrarVentanaAgregarUnidad(nodoSel.attributes.codigoU,1);
                                                                                                                                            
                                                                                                                                            
                                                                                                                                        }
                                                                                                                            },
                                                                                                                            '-',
                                                                                                                            {
                                                                                                                                id:'btnActivar',
                                                                                                                                text:'Activar/desactivar unidad',
                                                                                                                                icon:'../images/pencil.png',
                                                                                                                                cls:'x-btn-text-icon',
                                                                                                                                disabled:true,
                                                                                                                                handler:function()
                                                                                                                                        {
                                                                                                                                            function resp(btn)
                                                                                                                                            {
                                                                                                                                                if(btn=='yes')
                                                                                                                                                {
                                                                                                                                                    var activo='1';
                                                                                                                                                    if(nodoSel.attributes.status=='1')
                                                                                                                                                        activo='0';
                                                                                                                                                    function funcAjax()
                                                                                                                                                    {
                                                                                                                                                        var resp=peticion_http.responseText;
                                                                                                                                                        arrResp=resp.split('|');
                                                                                                                                                        if((arrResp[0]=='1')||(arrResp[0]==1))
                                                                                                                                                        {
                                                                                                                                                            gEx('tOrganigrama').getRootNode().reload();
                                                                                                                                                            //gEx('tOrganigrama').expandAll();
                                                                                                                                                            nodoSel=null;
                                                                                                                                                            
                                                                                                                                                            Ext.getCmp('btnPuesto').disable();
                                                                                                                                                            Ext.getCmp('btnAsignarPuesto').disable();
                                                                                                                                                            gEx('btnActivar').disable();
                                                                                                                                                        }
                                                                                                                                                        else
                                                                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                                                    }
                                                                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=61&activo='+activo+'&codUnidad='+nodoSel.attributes.codigoU,true);
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                            msgConfirm('&iquest;Est&aacute; seguro de querer activar/desactivar la unidad seleccionada?',resp)
                                                                                                                                        }
                                                                                                                            },
                                                                                                                            
                                                                                                                            '-',
                                                                                                                            {
                                                                                                                                id:'btnModificar',
                                                                                                                                text:'Modificar Unidad',
                                                                                                                                icon:'../images/notes_edit.png',
                                                                                                                                cls:'x-btn-text-icon',
                                                                                                                                disabled:true,
                                                                                                                                handler:function()
                                                                                                                                        {
                                                                                                                                            if(nodoSel==null)
                                                                                                                                            {
                                                                                                                                                msgBox('Primero debe seleccionar la unidad que desea modificar');
                                                                                                                                                return;
                                                                                                                                            }
                                                                                                                                            
                                                                                                                                            var pos=existeValorMatriz(arrCategorias,nodoSel.attributes.idTipoUnidad);
                                                                                                                                            var fTipo=arrCategorias[pos];
                                                                                                                                            if(fTipo[2]!='')
                                                                                                                                            {
                                                                                                                                                var objConf=eval('['+fTipo[2]+']')[0];
                                                                                                                                                
                                                                                                                                                
                                                                                                                                                function funcAjax()
                                                                                                                                                {
                                                                                                                                                    var resp=peticion_http.responseText;
                                                                                                                                                    arrResp=resp.split('|');
                                                                                                                                                    if(arrResp[0]=='1')
                                                                                                                                                    {
                                                                                                                                                        var obj={};    
                                                                                                                                                        obj.ancho='100%';
                                                                                                                                                        obj.alto='100%';
                                                                                                                                                        obj.modal=true;
                                                                                                                                                        obj.url='../modeloPerfiles/vistaDTDv3.php';
                                                                                                                                                        obj.params=[['idFormulario',arrResp[4]],['idRegistro',arrResp[1]],['idReferencia',-1],['dComp',arrResp[2]],['actor',arrResp[3]]];
                                                                                                                                                        window.parent.abrirVentanaFancy(obj);
                                                                                                                                                        ventanaAM.close();
                                                                                                                                                    }
                                                                                                                                                    else
                                                                                                                                                    {
                                                                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                                                    }
                                                                                                                                                }
                                                                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=71&p='+objConf.idProceso+
                                                                                                                                                                '&r='+objConf.rolIngreso+'&u='+nodoSel.attributes.codigoU,true);
                                                                                                                                                
                                                                                                                                                
                                                                                                                                                
                                                                                                                                            }
                                                                                                                                            else
                                                                                                                                                agregarUnidad(parseInt(nodoSel.attributes.institucion),0);
                                                                                                                                        }
                                                                                                                            
                                                                                                                            },'-',
                                                                                                                            {
                                                                                                                                id:'btnEliminar',
                                                                                                                                text:'Eliminar Unidad',
                                                                                                                                icon:'../images/cancel_round.png',
                                                                                                                                cls:'x-btn-text-icon',	
                                                                                                                                disabled:true,
                                                                                                                                handler:function()
                                                                                                                                        {
                                                                                                                                            if(nodoSel==null)
                                                                                                                                            {
                                                                                                                                                msgBox('Primero debe seleccionar la unidad a eliminar');
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
                                                                                                                                                        if((arrResp[0]=='1')||(arrResp[0]==1))
                                                                                                                                                        {
                                                                                                                                                            nodoSel.remove();
                                                                                                                                                            nodoSel=null;
                                                                                                                                                           
                                                                                                                                                            Ext.getCmp('btnPuesto').disable();
                                                                                                                                                            Ext.getCmp('btnAsignarPuesto').disable();
                                                                                                                                                            gEx('btnEliminar').disable();
                                                                                                                                                            gEx('btnActivar').disable();
                                                                                                                                                            gEx('btnModificar').disable();
                                                                                                                                                            gEx('btnResponsable').disable();
                                                                                                                                                        }
                                                                                                                                                        else
                                                                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                                                    }
                                                                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=23&tipoOrg=2&codUnidad='+nodoSel.attributes.codigoU,true);
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                            msgConfirm('&iquest;Est&aacute; seguro de querer eliminar esta Unidad?',resp)
                                                                                                                                            
                                                                                                                                        }
                                                                                                                            },'-',
                                                                                                                            {
                                                                                                                                id:'btnResponsable',
                                                                                                                                hidden:soloAdmonUnidades,
                                                                                                                                text:'Administraci&oacute;n de responsables de unidad',
                                                                                                                                icon:'../images/users.png',
                                                                                                                                cls:'x-btn-text-icon',
                                                                                                                                disabled:true,
                                                                                                                                handler:function()
                                                                                                                                        {
                                                                                                                                            if(nodoSel==null)
                                                                                                                                            {
                                                                                                                                                msgBox('Debe seleccionar la unidad cuyos responsables desea asignar');
                                                                                                                                                return;
                                                                                                                                            }
                                                                                                                                            mostrarVentanaResponsablesUnidad();
                                                                                                                                        }
                                                                                                                            }
                                                                                                                        ]
                                                                                                             },
                                                                                                        
                                                                                                            {
                                                                                                                xtype:'tbspacer',
                                                                                                                width:15
                                                                                                            },
                                                                                                           {
                                                                                                              text:'Listado de puestos',
                                                                                                              id:'btnPuesto',
                                                                                                              icon:'../images/vcard.png',
                                                                                                              cls:'x-btn-text-icon',
                                                                                                              disabled:true,
                                                                                                              //hidden:soloAdmonUnidades,
                                                                                                              handler:function()
                                                                                                              {
                                                                                                                    if(nodoSel==null)
                                                                                                                    {
                                                                                                                        msgBox('Primero debe seleccionar la unidad cuyo listado de puestos desea ver');
                                                                                                                        return;
                                                                                                                    }
                                                                                                                    mostrarListadoPuestos();
                                                                                                              }
                                                                                                           },{
                                                                                                                xtype:'tbspacer',
                                                                                                                width:15
                                                                                                            },
                                                                                                           {
                                                                                                              text:'Puestos asignados',
                                                                                                              id:'btnAsignarPuesto',
                                                                                                              icon:'../images/vcard.png',
                                                                                                              cls:'x-btn-text-icon',
                                                                                                              disabled:true,
                                                                                                              hidden:soloAdmonUnidades,
                                                                                                              handler:function()
                                                                                                              {
                                                                                                                    mostrarAsignacionPuestos();
                                                                                                              }
                                                                                                           },{
                                                                                                                xtype:'tbspacer',
                                                                                                                width:15
                                                                                                            },
                                                                                                           {
                                                                                                              text:'Expandir Todo',
                                                                                                              id:'btnExpand',
                                                                                                              icon:'../images/add.png',
                                                                                                              cls:'x-btn-text-icon',
                                                                                                              handler:function()
                                                                                                              {
                                                                                                                    gEx('tOrganigrama').expandAll( );
                                                                                                              }
                                                                                                           },{
                                                                                                                xtype:'tbspacer',
                                                                                                                width:15
                                                                                                            },
                                                                                                           {
                                                                                                              text:'Colapsar Todo',
                                                                                                              id:'btnCollapse',
                                                                                                              icon:'../images/close.png',
                                                                                                              cls:'x-btn-text-icon',
                                                                                                              handler:function()
                                                                                                              {
                                                                                                                   gEx('tOrganigrama').collapseAll( );
                                                                                                              }
                                                                                                           },
                                                                                                           {
                                                                                                                xtype:'tbspacer',
                                                                                                                width:65
                                                                                                            },
                                                                                                           
                                                                                                           
                                                                                                           {

                                                                                                                text:'Buscar',
                                                                                                                icon:'../images/magnifier.png',
                                                                                                                cls:'btnSIUGJCancel',
                                                                                                                width:140,
                                                                                                                handler:function()
                                                                                                                        {
                                                                                                                            mostrarMensajeProcesando();
                                                                                                                            primeraCarga='0';
                                                                                                                            gEx('tOrganigrama').getRootNode().reload();
                                                                                                                            
                                                                                                                        }
                                                                                                                
                                                                                                            },
                                                                                                            {
                                                                                                                xtype:'tbspacer',
                                                                                                                width:5
                                                                                                            },
                                                                                                            {
                
                                                                                                                cls:'btnSIUGJCancel',
                                                                                                                width:140,
                                                                                                                text:'Limpiar filtros',
                                                                                                                icon:'../images/find_remove.png',
                                                                                                                handler:function()
                                                                                                                        {
                                                                                                                            primeraCarga='1';
                                                                                                                            
                                                                                                                            gEx('cmbJurisdiccion').setValue('');
                                                                                                                            gEx('cmbEspecialidad').setValue('');
                                                                                                                            gEx('cmbCategorias').setValue('');
                                                                                                                            gEx('cmbDistritos').setValue('');
                                                                                                                            gEx('cmbCircuitos').setValue('');
                                                                                                                            gEx('cmbDetalleEspecialidad').setValue('');
                                                                                                                            cveMunicipio='';
                                                                                                                            gEx('cmbMunicipios').setRawValue('');
                                                                                                                            gEx('txtNombreDespacho').setValue('');
                                                                                                                            gEx('txtClave').setValue('');
                                                                                                                            gEx('cmbAtributosDespacho').setValue('');
                                                                                                                            gEx('cmbProcesosCompete').setValue('');
                                                                                                                            gEx('tOrganigrama').getRootNode().reload();
                                                                                                                        }
                                                                                                                
                                                                                                            }
                                                                                                           
                                                                                                        ],
                                                                                                items:	[
                                                                                                            crearOrganigrama()
                                                                                                        ]
                                                                                             }
                                                                                        ]
                                                                             }
                                                                
                                                                			
                                                                		]
                                                             }
                                                            
                                                        ]
                                            }
                                         ]
                            }
                        )   
    
    

	var cmbJurisdiccion=crearComboExt('cmbJurisdiccion',arrJurisdiccion,0,0,340,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divJurisdiccion'});                        
	var cmbEspecialidad=crearComboExt('cmbEspecialidad',arrEspecialidades,0,0,340,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divEspecialidad'});                        	
	cmbEspecialidad.on('select',function(cmb,registro)
    							{
                                
                                	gEx('cmbDetalleEspecialidad').setValue('');
                                    gEx('cmbDetalleEspecialidad').getStore().removeAll();
                                    if(registro.data.valorComp.length>0)
                                    {
                                		gEx('cmbDetalleEspecialidad').getStore().loadData(registro.data.valorComp);
                                        gEx('cmbDetalleEspecialidad').enable();
                                    }
                                    else
                                    {
                                    	gEx('cmbDetalleEspecialidad').disable();
                                    }
                                }
    				)
    
    var cmbDetalleEspecialidad=crearComboExt('cmbDetalleEspecialidad',[],0,0,340,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divDetalleEspecialidad'});                        	
	
    var cmbCategorias=crearComboExt('cmbCategorias',arrCategoriasAGrupadoras,0,0,280,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCategorias'});                        	    
	var cmbDistritos=crearComboExt('cmbDistritos',arrDistritosJudiciales,0,0,280,{multiSelect:true,ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divDistrito'});                        	    
    var cmbCircuitos=crearComboExt('cmbCircuitos',arrCiurcuitosJudiciales,0,0,280,{multiSelect:true,ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCircuito'});                        	        


	var cmbAtributosDespacho=crearComboExt('cmbAtributosDespacho',arrAtributosDespacho,0,0,350,{multiSelect:true,ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divAtributosDespacho'});                        	    
    var cmbProcesosCompete=crearComboExt('cmbProcesosCompete',arrTiposProcesosCompete,0,0,340,{multiSelect:true,ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divProcesosCompete'});                        	        



	var oConf=	{
    					idCombo:'cmbMunicipios',
                        anchoCombo:270,
                        renderTo:'divMunicipios',
                        raiz:'registros',
                        campoDesplegar:'nombreMunicipio',
                        campoID:'codigoMunicipio',
                        funcionBusqueda:72,
                        ctCls:'campoComboWrapSIUGJAutocompletar',
                        listClass:'listComboSIUGJ',
                        paginaProcesamiento:'../paginasFunciones/funcionesOrganigrama.php',
                        confVista:'<tpl for="."><div class="search-item">{nombreMunicipio}<br></div></tpl>',
                        campos:	[
                                   	{name:'codigoMunicipio'},
                                    {name:'nombreMunicipio'}

                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	cveMunicipio='';
                                    	var aValor=combo.getRawValue();
										dSet.baseParams.criterio=aValor;
                                        
                                                                              
                                        
                                    },
                      	funcElementoSel:function(combo,registro)
                        				{
                                        	cveMunicipio=registro.data.codigoMunicipio;
                                            
                                        }
    				};

	var cmbMunicipios=crearComboExtAutocompletar(oConf);
    
    
    

}

var nodoSel=null;
var nodoResponsable=null;

function crearOrganigrama()
{
		var raiz=new  Ext.tree.AsyncTreeNode	(
                                                      {
                                                          id:'-1',
                                                          text:'Raiz',
                                                          draggable:false,
                                                          expanded :true
                                                      }
                                              	)
                                        
		var cargadorArbol=new Ext.tree.TreeLoader(
                                                        {
                                                            baseParams:{
                                                                            funcion:'35',
                                                                            organigramaInst:'1'
                                                                        },
                                                            dataUrl:'../paginasFunciones/funcionesOrganigrama.php',
                                                            uiProviders:	{
                                                                            	'col': Ext.ux.tree.ColumnNodeUI
                                                                        	}
                                                        }	


		                                         )		                                        
		
       	
        cargadorArbol.on('load',function( tree, node, response )
        						{
                                	ocultarMensajeProcesando();
                                	if(idNodoSeleccionado!=-1)
                                    {
                                    
                                    	setTimeout(function()
                                        			{
                                                    	nodoSel=gEx('tOrganigrama').buscarNodo(gEx('tOrganigrama').getRootNode(),idNodoSeleccionado);//buscarNodoID(gEx('tOrganigrama').getRootNode(),idNodoSeleccionado);
                                                        gEx('tOrganigrama'). selectPath(nodoSel.getPath());
                                                        nodoClick(nodoSel);
                                                       
                                                    },500);
                                        
                                	}
                                }
        				)
        
		cargadorArbol.on('beforeload',function(tree)
        								{
                                        	tree.baseParams.primeraCarga=primeraCarga;
                                            if(primeraCarga=='0')
                                            {
                                                tree.baseParams.jurisdiccion=gEx('cmbJurisdiccion').getValue();
                                                tree.baseParams.especialidad=gEx('cmbEspecialidad').getValue();
                                                tree.baseParams.detalleEspecialidad=gEx('cmbDetalleEspecialidad').getValue();
                                                tree.baseParams.categoria=gEx('cmbCategorias').getValue();
                                                tree.baseParams.distritoJudicial=gEx('cmbDistritos').getValue();
                                                tree.baseParams.circuitoJudicial=gEx('cmbCircuitos').getValue();;
                                                tree.baseParams.municipio=cveMunicipio;
                                                tree.baseParams.nombreDespacho=gEx('txtNombreDespacho').getValue();
                                                tree.baseParams.cveDespacho=gEx('txtClave').getValue();
                                                tree.baseParams.atributosDespacho=gEx('cmbAtributosDespacho').getValue();
                                                tree.baseParams.procesosCompete=gEx('cmbProcesosCompete').getValue();
                                                
                                                
                                                
											}                                            
                                        }
        				)                                         
		var organigrama = new Ext.ux.tree.TreeGrid	(
                                                            {
                                                                id:'tOrganigrama',
                                                                useArrows:true,
                                                                autoScroll:false,
                                                                animate:true,
                                                                enableDD:false,
                                                                border:false,
                                                                frame:false,
                                                                containerScroll: true,
                                                                root:raiz,
                                                                cls:'gridSiugjSeccion',
                                                                enableSort:false,
                                                                loader: cargadorArbol,
                                                                rootVisible:false,
                                                                region:'center',
                                                                draggable:false,
                                                                columns:[
                                                                			{
                                                                                header:'<span class="letraOrganigramaColumna">C&oacute;digo funcional</span>',
                                                                                width:300,
                                                                                dataIndex:'codigoU'
                                                                            },
                                                                            {
                                                                                header:'<span class="letraOrganigramaColumna">Unidades Organigrama</span>',
                                                                                width:800,
                                                                                dataIndex:'text'
                                                                            },
                                                                            
                                                                            {
                                                                                header:'<span class="letraOrganigramaColumna">Clave</span>',
                                                                                width:200,
                                                                                dataIndex:'codDepto'
                                                                            },
                                                                            {
                                                                                header:'<span class="letraOrganigramaColumna">Tipo de Unidad</span>',
                                                                                width:180,
                                                                                dataIndex:'tipoUnidad'
                                                                            },
                                                                            {
                                                                                header:'<span class="letraOrganigramaColumna">Situaci&oacute;n</span>',
                                                                                width:100,
                                                                                dataIndex:'activo'
                                                                            }
                                                                            
                                                                         ],
                                                                listeners: 	{
                                                                                    'render': 	function(tp)
                                                                                    			{
                                                                                        			
                                                                                                 }
                                                                                    }

                                                               
                                                            }
                                                    );
		
        
       

        
        
        organigrama.on('click',nodoClick);
        //organigrama.expandAll(); 
        return organigrama;      
}

function nodoClick(nodo)
{
	nodoSel=nodo;
    
    
	if((nodoSel.attributes.institucion=='1')||(nodoSel.attributes.institucion=='11'))
    {
    	Ext.getCmp('btnPuesto').enable();
        Ext.getCmp('btnAsignarPuesto').disable();
       
    }
    else
    {
    	Ext.getCmp('btnPuesto').disable();
        Ext.getCmp('btnAsignarPuesto').enable();
    }
	gEx('btnResponsable').enable();
    
    if((nodoSel.parentNode.id!='-1')||(puedeModificarUnidadRaiz))
    {
        gEx('btnActivar').enable();
        Ext.getCmp('btnModificar').enable();
         gEx('btnEliminar').enable();
    }
}


function mostrarListadoPuestos()
{
	var cUnidad=nodoSel.attributes.codigoU;
    
	var gridPuestos=crearGridPuestos();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														gridPuestos
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Listado de puestos de la instituci&oacute;n: '+nodoSel.text,
										width: 900,
										height:560,
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
															id:'btnAceptar',
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

var registroSimple=Ext.data.Record.create	(
                                                [
                                                    {name: 'idPuesto'},
                                                    {name: 'puesto'},
                                                    {name: 'numPuestos'},
                                                    {name: 'cvePuesto'},
                                                    {name: 'puestosAsignados'},
                                                    {name: 'puestosOcupados'},
                                                    {name: 'puestosVacantes'},
                                                     {name: 'institucion'}
                                                ]
                                            )

function crearGridPuestos()
{
	var tamPagina =	20;     
    
    var cUnidad=nodoSel.attributes.codigoU;
                                            
	var dsTablaRegistros = new Ext.data.JsonStore	(
                                                        {
                                                            root: 'registros',
                                                            totalProperty: 'numReg',
                                                            idProperty: 'idProceso',
                                                            fields: [
                                                                        {name: 'idPuesto'},
                                                                        {name: 'puesto'},
                                                                        {name: 'numPuestos'},
                                                                        {name: 'cvePuesto'},
                                                                        {name: 'puestosAsignados'},
                                                                        {name: 'puestosOcupados'},
                                                                        {name: 'institucion'},
                                                                        {name: 'zona'},
                                                                        {name: 'tipoPuesto'},
                                                                        {name: 'horasPuesto'},
                                                                        {name: 'sueldoMinimo'},
                                                                        {name: 'sueldoMaximo'},
                                                                        {name: 'nivelRiesgo'}
                                                                    ],
                                                            remoteSort:true,
                                                            proxy: new Ext.data.HttpProxy	(
                                                                                                {
                                                                                                    url: '../paginasFunciones/funcionesOrganigrama.php'
                                                                                                }
                                                                                            )
                                                       }
                                                    );
	function cargarDatos(proxy,parametros)
	{
		proxy.baseParams.funcion=28;
        proxy.baseParams.codigoU=cUnidad;
	}   
    
    var paginador=	new Ext.PagingToolbar	(
						                        {
						                              pageSize: tamPagina,
						                              store: dsTablaRegistros,
						                              displayInfo: true,
						                              disabled:false
                                                  }
					                       ) 
                                       
	dsTablaRegistros.on('beforeload',cargarDatos);   

    var filters = new Ext.ux.grid.GridFilters	(
                                                      {
                                                        	filters:[ {type: 'string', dataIndex: 'puesto'},{type: 'string', dataIndex: 'cvePuesto'}]
                                                      }
            
	                                            );                                             

   
	chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:30}),
														chkRow,
                                                        {
															header:'C&oacute;digo de puesto',
															width:100,
															sortable:true,
															dataIndex:'cvePuesto'
														},
														{
															header:'Puesto',
															width:330,
															sortable:true,
															dataIndex:'puesto'
														},
                                                        {
															header:'Zona',
															width:80,
															sortable:true,
															dataIndex:'zona',
                                                            renderer:function(val)
                                                            		{
                                                                    	var pos=existeValorMatriz(arrZonas,val,0);
                                                                        if(pos==-1)
                                                                        	return '';
                                                                        return arrZonas[pos][1];
                                                                    }
														},
                                                        {
															header:'Categor&iacute;a de puesto',
															width:150,
															sortable:true,
															dataIndex:'tipoPuesto',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrTipoPuesto,val)
                                                                    }
														},
                                                        {
															header:'Nivel de riesgo',
															width:110,
															sortable:true,
															dataIndex:'nivelRiesgo',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrRiesgo,val)
                                                                    }
														},
                                                        {
															header:'Horas puesto',
															width:100,
															sortable:true,
															dataIndex:'horasPuesto'
														},
                                                        {
															header:'Sueldo m&iacute;nimo',
															width:100,
															sortable:true,
															dataIndex:'sueldoMinimo',
                                                            renderer:'usMoney'
														}
                                                        ,
                                                        {
															header:'Sueldo m&aacute;ximo',
															width:100,
															sortable:true,
															dataIndex:'sueldoMaximo',
                                                            renderer:'usMoney'
														},
                                                        {
															header:'Puestos asignados a deptos/&aacute;reas',
															width:180,
															sortable:true,
															dataIndex:'puestosAsignados'
														}
                                                        ,
                                                        {
															header:'Puestos ocupados',
															width:100,
															sortable:true,
															dataIndex:'puestosOcupados'
														},
                                                        {
															header:'Puestos vacantes',
															width:100,
															sortable:true,
                                                            renderer:function(val,datos,reg)
                                                            {
                                                            	return parseInt(reg.get('numPuestos'))-parseInt(reg.get('puestosOcupados'));
                                                            }
														}
                                                        
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridPuesto',
                                                            store:dsTablaRegistros,
                                                            frame:true,
                                                            y:0,
                                                            cm: cModelo,
                                                            height:480,
                                                            width:870,
                                                            sm:chkRow,
                                                            plugins:[filters],
                                                            bbar:paginador,
                                                            tbar:	[
                                                            			{
                                                                        	text:'Agregar puesto',
                                                                            icon:'../images/add.png',
						                                                    cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarPuesto();
                                                                                    }
                                                                        },
                                                                        
                                                                        {
                                                                        	text:'Modificar puesto',
                                                                            icon:'../images/update_nw.gif',
						                                                    cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filaSel=tblGrid.getSelectionModel().getSelected();
                                                                                        if(filaSel==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el puesto a modificar');
                                                                                            return;
                                                                                        }
                                                                                    	mostrarVentanaAgregarPuesto(filaSel);
                                                                                    }
                                                                        },
                                                                        
                                                                        {
                                                                        	text:'Remover puesto',
                                                                            icon:'../images/delete.png',
						                                                    cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filaSel=tblGrid.getSelectionModel().getSelected();
                                                                                        if(filaSel==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el puesto a remover');
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
                                                                                                    	tblGrid.getStore().remove(filaSel);
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=30&idPuesto='+filaSel.get('idPuesto'),true);
                                                                                             }
                                                                                    	}
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el puesto seleccionado?',resp);   
                                                                                        
                                                                                        
                                                                                    }
                                                                        }/*,'-',
                                                                        {
                                                                        	text:'Tabulaci&oacute;n de puestos',
                                                                            icon:'../images/coins_add.png',
						                                                    cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filaSel=tblGrid.getSelectionModel().getSelected();
                                                                                        if(filaSel==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el puesto al cual desea agregar la tabulaci&oacute;n');
                                                                                            return;
                                                                                        }
                                                                                    	mostrarVentanaTabulacion(filaSel);
                                                                                    
                                                                                    }
                                                                        }*/
                                                            		]
                                                        }
                                                    );
	dsTablaRegistros.load({params:{start:0, limit:tamPagina,funcion:28,codigoU:cUnidad}});                                                    
	return 	tblGrid;		
}

function mostrarVentanaAgregarPuesto(filaSel)
{
	var cmbZona=crearComboExt('cmbZona',arrZonas,115,80);
 	cmbZona.setValue('4')  ;
    var cmbTipoPuesto=crearComboExt('cmbTipoPuesto',arrTipoPuesto,115,105);
    cmbTipoPuesto.setValue('4');
    var cmbRiesgo=crearComboExt('cmbRiesgo',arrRiesgo,115,130,200);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
                                            			{
                                                        	html:'Clave puesto: <font color="red">*</font>',
                                                            x:10,
                                                            y:10,
                                                            xtype:'label'
                                                            
                                                        },
                                                        {
                                                        	x:115,
                                                            y:5,
                                                            id:'txtCvePuesto',
                                                            width:150
                                                        },
														{
                                                        	html:'Puesto: <font color="red">*</font>',
                                                            x:10,
                                                            y:35,
                                                            xtype:'label'
                                                        },
                                                        {
                                                        	x:115,
                                                            y:30,
                                                            id:'txtPuesto',
                                                            width:350
                                                        },
                                                        {
                                                        	x:10,
                                                            y:60,
                                                            xtype:'label',
                                                            html:'No. plazas: <font color="red">*</font>'
                                                        },
                                                        {
                                                        	x:115,
                                                            id:'numPuestos',
                                                            y:55,
                                                            width:'30',
                                                            xtype:'numberfield',
                                                            allowDecimals:false,
                                                            allowNegative:false
                                                        },
                                                        {
                                                        	x:160,
                                                            y:60,
                                                            xtype:'label',
                                                            html:'(0 Si no aplica)'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:85,
                                                            xtype:'label',
                                                            html:'Zona: <font color="red">*</font>'
                                                        },
                                                        cmbZona,
                                                        {
                                                        	x:10,
                                                            y:110,
                                                            xtype:'label',
                                                            html:'Cat. de puesto: <font color="red">*</font>'
                                                        },
                                                        cmbTipoPuesto,
                                                        {
                                                        	x:10,
                                                            y:135,
                                                            xtype:'label',
                                                            html:'Riesgo puesto: <font color="red">*</font>'
                                                        },
                                                        cmbRiesgo,
                                                        {
                                                        	x:10,
                                                            y:165,
                                                            xtype:'label',
                                                            html:'Horas puesto: <font color="red">*</font>'
                                                        },
                                                        {
                                                        	x:160,
                                                            y:165,
                                                            xtype:'label',
                                                            html:'(0 Si no aplica)'
                                                        },
                                                         {
                                                        	x:115,
                                                            y:160,
                                                            width:'30',
                                                            xtype:'numberfield',
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            id:'txtHorasPuesto'
                                                        }
                                                        ,
                                                        
                                                        
                                                        {
                                                        	x:10,
                                                            y:195,
                                                            xtype:'label',
                                                            html:'Sueldo m&iacute;nimo: <font color="red">*</font>'
                                                        },
                                                        {
                                                        	x:115,
                                                            y:190,
                                                            xtype:'numberfield',
                                                            allowNegative:false,
                                                            width:85,
                                                            id:'txtSueldoMinimo'
                                                        },
                                                        {
                                                        	x:230,
                                                            y:195,
                                                            xtype:'label',
                                                            html:'Sueldo m&aacute;ximo: <font color="red">*</font>'
                                                        },
                                                        {
                                                        	x:330,
                                                            y:190,
                                                            xtype:'numberfield',
                                                            allowNegative:false,
                                                            width:85,
                                                            id:'txtSueldoMaximo'
                                                        },
                                                        {
                                                        	x:425,
                                                            y:195,
                                                            xtype:'label',
                                                            html:'(0 Si no aplica)'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar puesto',
										width: 550,
										height:305,
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
                                                                	Ext.getCmp('txtCvePuesto').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															id:'btnAceptar',
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtPuesto=Ext.getCmp('txtPuesto');
                                                                        var txtNumPuestos=Ext.getCmp('numPuestos');
                                                                        var txtCvePuesto=Ext.getCmp('txtCvePuesto');
                                                                       	
                                                                        var txtZona=cmbZona;
                                                                        var txtHorasPuesto=Ext.getCmp('txtHorasPuesto');
                                                                        var txtSueldoMin=Ext.getCmp('txtSueldoMinimo');
                                                                        var txtSueldoMax=Ext.getCmp('txtSueldoMaximo');
                                                                        var tipoPuesto=cmbTipoPuesto;
                                                                        
                                                                        if(txtCvePuesto.getValue()=='')
                                                                        {
                                                                        	function respCPuesto()
                                                                            {
                                                                            	txtCvePuesto.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar la clave del puesto a agregar',respCPuesto);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbRiesgo.getValue()=='')
                                                                        {
                                                                        	function respCRiesgo()
                                                                            {
                                                                            	cmbRiesgo.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el nivel de riesgo del puesto',respCRiesgo);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(txtPuesto.getValue()=='')
                                                                        {
                                                                        	function respNPuesto()
                                                                            {
                                                                            	txtPuesto.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el nombre del puesto a agregar',respNPuesto);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(txtNumPuestos.getRawValue()=='')
                                                                        {
                                                                        	function respNumPuesto()
                                                                            {
                                                                            	txtNumPuestos.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el n&uacute;mero de plazas a agregar',respNumPuesto);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(txtZona.getValue()=='')
                                                                        {
                                                                        	function respZona()
                                                                            {
                                                                            	txtZona.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la zona a la cual pertenece el puesto',respZona);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(tipoPuesto.getValue()=='')
                                                                        {
                                                                        	function respTipoPuesto()
                                                                            {
                                                                            	tipoPuesto.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el tipo de puesto',respTipoPuesto);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(txtHorasPuesto.getRawValue()=='')
                                                                        {
                                                                        	function respHorasPuesto()
                                                                            {
                                                                            	txtHorasPuesto.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el tipo de puesto',respHorasPuesto);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(txtSueldoMin.getRawValue()=='')
                                                                        {
                                                                        	function respSueldoMin()
                                                                            {
                                                                            	txtSueldoMin.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el sueldo m&iacute;nimo asignado al puesto',respSueldoMin);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(txtSueldoMax.getRawValue()=='')
                                                                        {
                                                                        	function respSueldoMax()
                                                                            {
                                                                            	txtSueldoMax.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el sueldo m&aacute;ximo asignado al puesto',respSueldoMax);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(txtSueldoMin.getValue()>txtSueldoMax.getValue())
                                                                        {
                                                                        
                                                                        	function respSueldoMin2()
                                                                            {
                                                                            	txtSueldoMin.focus();
                                                                            }
                                                                        	msgBox('El sueldo m&iacute;nimo no puede ser mayor que el sueldo m&aacute;ximo',respSueldoMin2);
                                                                        	return;
                                                                        }
                                                                        var idPuesto="-1";
                                                                        if(filaSel!=undefined)
                                                                        	idPuesto=filaSel.get('idPuesto');
                                                                        var cadObj='{"riesgo":"'+cmbRiesgo.getValue()+'","idPuesto":"'+idPuesto+'","cvePuesto":"'+cv(txtCvePuesto.getValue())+'","puesto":"'+cv(txtPuesto.getValue())+'","codigoU":"'+nodoSel.attributes.codigoU+
                                                                        	'","numPlazas":"'+txtNumPuestos.getValue()+'","zona":"'+txtZona.getValue()+'","tipoPuesto":"'+tipoPuesto.getValue()+'","horasPuesto":"'+txtHorasPuesto.getValue()+
                                                                            '","sueldoMinimo":"'+txtSueldoMin.getValue()+'","sueldoMaximo":"'+txtSueldoMax.getValue()+'"}';
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                               gEx('gridPuesto').getStore().reload();
                                                                               ventanaAM.close();
                                                                                 
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=29&cadObj='+cadObj,true);
                                                                   		
                                                                       
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
    if(filaSel!=undefined)
    {
    	var txtPuesto=Ext.getCmp('txtPuesto');
        txtPuesto.setValue(filaSel.get('puesto'));
		var txtNumPuestos=Ext.getCmp('txtNumPuestos');
        var txtCvePuesto=Ext.getCmp('txtCvePuesto');
        txtCvePuesto.setValue(filaSel.get('cvePuesto'));
        gEx('numPuestos').setValue(filaSel.get('numPuestos'));
        gEx('cmbZona').setValue(filaSel.get('zona'));
        gEx('cmbTipoPuesto').setValue(filaSel.get('tipoPuesto'));
        gEx('txtHorasPuesto').setValue(filaSel.get('horasPuesto'));
        gEx('txtSueldoMinimo').setValue(filaSel.get('sueldoMinimo'));
        gEx('txtSueldoMaximo').setValue(filaSel.get('sueldoMaximo'));
        gEx('cmbRiesgo').setValue(filaSel.data.nivelRiesgo);
        
    }
	ventanaAM.show();	
}

function agregarInstitucion(tipoUnidad,accion)
{
	estadoSel=null;
    municipioSel=null;
	var idOrganigrama="-1";
	var arrCentrosC=<?php echo $arrCentroC?>;
	var arrPaises=<?php echo $arrPaises?>;
    var arrUnidades=[['1','Departamento'],['2','Instituci\u00F3n']];
	var cmbPais=crearComboExt('cmbPais',arrPaises,110,175);
    cmbPais.setWidth(220);
    cmbPais.minListWidth=220;
    cmbPais.setValue('146');
    
	var cmbCentroCosto=crearComboExt('cmbCentroCosto',arrCentrosC,150,315,260);
    var cmbCentroCosto2=crearComboExt('cmbCentroCosto2',arrCentrosC,110,470,260);
    var controlTelefono='<table  border="0" cellspacing="1" cellpadding="1">'+
                        '<tr><td  >&nbsp;<select name="cmbTelefonoInst" id="cmbTelefonoInst" size="5" style="width:240px"></select><input type="hidden" name="telefonos" id="telefonos" value="" />'+
                        '</td><td width="5"  align="left">&nbsp;</td><td width="19"><table><tr><td>'+
                        '<a href="javaScript:solicitarTel(\'cmbTelefonoInst\')"><img src="../images/icon_big_tick.gif" alt="Agregar" height="15" title="Agregar Tel�fono" border="0"/></a>'+
                        '</td></tr><tr><td>'+
                        '<a href="javaScript:eliminarTelefono(\'cmbTelefonoInst\')"><img src="../images/cancel_round.png" alt="Eliminar" title="Eliminar Tel�fono" border="0"/></a>'+
                        '</td></tr></table><br /></td></tr></table>';
                        
	var controlTelefonoD='<table  border="0" cellspacing="1" cellpadding="1">'+
                        '<tr><td  >&nbsp;<select name="cmbTelefonoDepto" id="cmbTelefonoDepto" size="5" style="width:240px"></select><input type="hidden" name="telefonos" id="telefonos" value="" />'+
                        '</td><td width="5"  align="left">&nbsp;</td><td width="19"><table><tr><td>'+
                        '<a href="javaScript:solicitarTel(\'cmbTelefonoDepto\')"><img src="../images/icon_big_tick.gif" alt="Agregar" height="15" title="Agregar Tel�fono" border="0"/></a>'+
                        '</td></tr><tr><td>'+
                        '<a href="javaScript:eliminarTelefono(\'cmbTelefonoDepto\')"><img src="../images/cancel_round.png" alt="Eliminar" title="Eliminar Tel�fono" border="0"/></a>'+
                        '</td></tr></table><br /></td></tr></table>';                        
    
    var panelDir=	{
    					id:'panelDir1',
                        layout:'absolute',
                        xtype:'panel',
                        baseCls: 'x-plain',
                        x:0,
                        y:200,
                        width:450,
                        height:400,
                        hidden:true,
                        items:	[
                                    {
                                        x:10,
                                        y:10,
                                        baseCls: 'x-plain',
                                        html:'Estado:'
                                    },
                                    {
                                        x:110,
                                        y:5,
                                        id:'txtEstado1',
                                        xtype:'textfield',
                                        width:200
                                    },
                                    {
                                        x:10,
                                        y:35,
                                        baseCls: 'x-plain',
                                        html:'Ciudad:'
                                    },
                                    {
                                        x:110,
                                        y:30,
                                        id:'txtCiudad1',
                                        xtype:'textfield',
                                        width:200
                                    },
                                    {
                                        x:10,
                                        y:60,
                                        html:'CP.:',
                                        baseCls: 'x-plain'
                                    },						
                                    {
                                        x:110,
                                        y:55,
                                        id:'txtCp1',
                                        xtype:'numberfield',
                                        width:80,
                                        allowDecimals:false,
                                        allowNegative:false
                                    },
                                    {
                                        x:10,
                                        y:85,
                                        html:'Calle:',
                                        baseCls: 'x-plain'
                                    },
                                    {
                                        x:110,
                                        y:80,
                                        id:'txtCalle1',
                                        xtype:'textfield',
                                        width:220
                                    },
                                    {
                                        x:10,
                                        y:110,
                                        html:'N&uacute;mero:',
                                        baseCls: 'x-plain'
                                    },						
                                    {
                                        x:110,
                                        y:105,
                                        id:'txtNumero1',
                                        xtype:'textfield',
                                        width:80
                                        
                                    }
                                    
                                ]
                    }
	
    
    var cmbEstado=crearComboExt('cmbEstado',<?php echo $arrEstados?>,110,5); 
    var cmbMunicipio=crearComboExt('cmbMunicipio',[],110,30,320);
    var cmbLocalidad=crearComboExt('cmbLocalidad',[],110,55,320);   
    var cmbColonia=crearComboExt('cmbColonia',[],110,80,320);  
    cmbPais.on('select',function (combo,registro)
    					{
                        	cmbEstado.setValue('');
                        	cmbMunicipio.setValue('');
							cmbLocalidad.setValue('');
	                        cmbColonia.setValue('');
                        	
                            gEx('cmbEstado').getStore().removeAll();
                            gEx('cmbMunicipio').getStore().removeAll();
                            gEx('cmbLocalidad').reset();
                            gEx('cmbColonia').reset;
                            gEx('txtCp').setValue('');
                            gEx('txtCalle').setValue('');
                            gEx('txtNumero').setValue();
                            
                            
                            function funcAjax()
                            {
                                var resp=peticion_http.responseText;
                                arrResp=resp.split('|');
                                if(arrResp[0]=='1')
                                {
                                
                                    gEx('cmbEstado').getStore().loadData(eval(arrResp[1]));
                                    gEx('cmbEstado').setValue('');
                                    if(estadoSel)
                                    {
                                        gEx('cmbEstado').setValue(estadoSel);
                                        dispararEventoSelectCombo('cmbEstado');
                                        estadoSel=null;
                                        
                                    }
                                    
                                }
                                else
                                {
                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                }
                            }
                            obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=60&accion=4&codigo='+registro.get('id'),true);
                            
                            	
                            
                        }
    
    	)
    cmbEstado.on('select',	function(combo,registro,indice,obj)
    							{
                                    function funcAjax()
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                        
                                        	cmbMunicipio.getStore().loadData(eval(arrResp[1]));
                                            cmbMunicipio.setValue('');
                                            if(municipioSel)
                                            {
                                            	cmbMunicipio.setValue(municipioSel);
                                                dispararEventoSelectCombo('cmbMunicipio');
                                                municipioSel=null;
                                                
                                            }
                                            cmbLocalidad.setValue('');
                                            cmbColonia.setValue('');
                                        }
                                        else
                                        {
                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                        }
                                    }
                                    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=60&accion=1&codigo='+registro.get('id'),true);
                                }
    				)
	cmbMunicipio.on('select',	function(combo,registro,indice,obj)
    							{
                                    function funcAjax()
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                        	cmbLocalidad.getStore().loadData(eval(arrResp[1]));
                                            cmbLocalidad.setValue('');

                                            if(obj!=undefined)
                                            {
                                            	
                                            	gEx('cmbLocalidad').setValue(obj.ciudad);
                                                pos=obtenerPosFila(gEx('cmbLocalidad').getStore(),'id',obj.ciudad);
                                                if(pos!='-1')
                                                {
                                                    var registro=gEx('cmbLocalidad').getStore().getAt(pos);
                                                    gEx('cmbLocalidad').fireEvent('select',gEx('cmbLocalidad'),registro,pos,obj);
                                                }
                                                
                                            }
                                            
                                        }
                                        else
                                        {
                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                        }
                                    }
                                    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=60&accion=2&codigo='+registro.get('id'),true);
                                }
    				)  
	cmbLocalidad.on('select',	function(combo,registro,indice,obj)
    							{
                                    function funcAjax()
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                        	cmbColonia.getStore().loadData(eval(arrResp[1]));
                                            cmbColonia.setValue('');
                                            if(obj!=undefined)
                                            {
                                            	gEx('cmbColonia').setValue(obj.colonia);
                                            }
                                            
                                        }
                                        else
                                        {
                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                        }
                                    }
                                    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=60&accion=3&codigo='+registro.get('id'),true);
                                }
    				)                                        
	var panelDir2=	{
    					id:'panelDir2',
                        layout:'absolute',
                        xtype:'panel',
                        baseCls: 'x-plain',
                        x:0,
                        y:200,
                        width:450,
                        height:400,
                        items:[
                                    {
                                        x:10,
                                        y:10,
                                        baseCls: 'x-plain',
                                        html:'Estado:'
                                    },
                                    cmbEstado,
                                    {
                                        x:10,
                                        y:35,
                                        baseCls: 'x-plain',
                                        html:'Municipio:'
                                    },
                                    cmbMunicipio,
                                     {
                                        x:10,
                                        y:60,
                                        baseCls: 'x-plain',
                                        html:'Localidad:'
                                    },
                                    cmbLocalidad,
                                    {
                                        x:10,
                                        y:85,
                                        baseCls: 'x-plain',
                                        html:'Colonia:'
                                    },
                                    cmbColonia,
                                    {
                                        x:10,
                                        y:110,
                                        html:'CP.:',
                                        baseCls: 'x-plain'
                                    },						
                                    {
                                        x:110,
                                        y:105,
                                        id:'txtCp',
                                        xtype:'numberfield',
                                        width:80,
                                        allowDecimals:false,
                                        allowNegative:false
                                    },
                                    {
                                        x:10,
                                        y:135,
                                        html:'Calle:',
                                        baseCls: 'x-plain'
                                    },						
                                    {
                                        x:110,
                                        y:130,
                                        id:'txtCalle',
                                        xtype:'textfield',
                                        width:320
                                    },
                                    {
                                        x:10,
                                        y:160,
                                        html:'N&uacute;mero:',
                                        baseCls: 'x-plain'
                                    },						
                                    {
                                        x:110,
                                        y:155,
                                        id:'txtNumero',
                                        xtype:'textfield',
                                        width:80
                                        
                                    }
                                    
                                ]
                    }                    
        
    var txtCod;
    var codigoPadre='';
    var longCod=4;
    var ancho=80;
    var lblVentana;
    if(tipoUnidad==0)
    {
    	if(accion==undefined)
	    	lblVentana='Agregar &Aacute;rea/Departamento';
        else
        	lblVentana='Modificar &Aacute;rea/Departamento';
    	txtCod='txtCodigoDepto';
        if(accion==undefined)
	        codigoPadre=nodoSel.attributes.codigoU;
        else
        	codigoPadre=nodoSel.attributes.unidadPadre;
        if((nodoSel.attributes.institucion=='1')||((accion!=undefined)&&(nodoSel.parentNode.attributes.institucion=='1')))
        {
        	longCod=2;
            ancho=30;
        }
    }
    else
    {
    	if(accion==undefined)
	    	lblVentana='Agregar Instituci&oacute;n'
        else
        	lblVentana='Modificar Instituci&oacute;n'
       	if(tipoUnidad=='3')
	        codigoPadre=nodoSel.attributes.codigoU;
    	txtCod='txtCodigoInst';
    }
    
    var panelUnidad=new Ext.Panel(
    								{
                                    	id:'panelUnidad',
                                    	x:10,
                                        y:10,
                                        
										layout:'absolute',
                                        width:415,
                                        height:390,
                                        hidden:true,
                                        baseCls: 'x-plain',
                                    	items:[
                                        		
                                        		{
                                                      x:10,
                                                      y:10,
                                                      baseCls: 'x-plain',
                                                      html:'C&oacute;digo depto/&Aacute;rea:'
                                                  },
                                                  {
                                                  	  id:'txtCodigoDepto',
                                                      x:150,
                                                      xtype:'textfield',
                                                      width:100,
                                                      y:5
                                                  },
                                                  {
                                                	x:10,
                                                    y:40,
                                                    html:'Clave departamental/&Aacute;rea:',
                                                    baseCls: 'x-plain'
                                                },
                                                {
                                                	  id:'txtClaveDep',
                                                      x:150,
                                                      xtype:'textfield',
                                                      width:100,
                                                      y:35
                                                  },
                                                  {
                                                      x:10,
                                                      y:70,
                                                      baseCls: 'x-plain',
                                                      html:'&Aacute;rea/Depto:<font color="red">*</font>'
                                                  },
                                                  {
                                                      x:150,
                                                      y:65,
                                                      id:'txtDeptoNuevo',
                                                      xtype:'textfield',
                                                      width:230
                                                  },
                                                  {
	                                               	  x:10,
                                                      y:100,
                                                      baseCls: 'x-plain',
                                                      html:'Descripci&oacute;n:'
                                                  },
                                                  {
                                                  	x:150,
                                                    y:95,
                                                    xtype:'textarea',
                                                    id:'txtDescripcionDepto',
                                                    width:240,
                                                    height:100
                                                  },
                                                  {
                                                  	x:10,
                                                    y:210,
                                                    baseCls: 'x-plain',
                                                    html:'Tel&eacute;fono:'
                                                  },
                                                  {
                                                  	x:150,
                                                    y:200,
                                                    baseCls: 'x-plain',
                                                    html:controlTelefonoD
                                                  },
                                                  {
                                                  	x:10,
                                                    y:320,
                                                    baseCls: 'x-plain',
                                                    html:'Cento de costo:'
                                                  },
                                                  cmbCentroCosto
                                               ]
                                      }
                                   )
    
    var panelInst=new Ext.Panel(
    								{
                                    	id:'panelInst',
                                    	x:10,
                                        y:10,
                                        baseCls: 'x-plain',
										layout:'absolute',
                                        width:590,
                                        height:500,
                                        hidden:true,
                                    	items:[
                                        		{
                                                      x:10,
                                                      y:10,
                                                      baseCls: 'x-plain',
                                                      html:'C&oacute;digo:'
                                                  },
                                                  {
                                                      x:110,
                                                      id:'txtCodigoInst',
                                                      xtype:'textfield',
                                                      maxLength:4,
                                                      width:80,
                                                      y:5
                                                  },
                                                  {
                                                      x:10,
                                                      y:40,
                                                      baseCls: 'x-plain',
                                                      html:'Instituci&oacute;n:<font color="red">*</font>'
                                                  },
                                                  {
                                                      x:110,
                                                      y:35,
                                                      id:'txtInstitucionNueva',
                                                      xtype:'textfield',
                                                      width:230
                                                  },
                                                  {
	                                               	  x:10,
                                                      y:70,
                                                      baseCls: 'x-plain',
                                                      html:'Descripci&oacute;n:'
                                                  },
                                                  {
                                                  	x:110,
                                                    y:65,
                                                    xtype:'textarea',
                                                    width:240,
                                                    height:100,
                                                    id:'txtDescripcion'
                                                  },
                                                  {
                                                      x:10,
                                                      y:180,
                                                      baseCls: 'x-plain',
                                                      html:'Pa&iacute;s:<font color="red">*</font>'
                                                  }
                                                  ,
                                                  cmbPais,
                                                  
                                                  panelDir2,
                                                  {
                                                  	x:10,
                                                    y:385,
                                                    baseCls: 'x-plain',
                                                    html:'Tel&eacute;fono:'
                                                  },
                                                  {
                                                  	x:110,
                                                    y:390,
                                                    baseCls: 'x-plain',
                                                    html:controlTelefono
                                                  },
                                                  {
                                                  	x:10,
                                                    y:475,
                                                    baseCls: 'x-plain',
                                                    html:'Centro de costo:'
                                                  },
                                                  cmbCentroCosto2
                                              ]
                                    }
                                )
    
    
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											disabled:false,
                                            defaultType:'label',
											items:	[
                                            			
                                            			panelInst,
                                                        panelUnidad
                                                   ]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:lblVentana,
										width:600,
										height:580,
										layout:'fit',
										buttonAlign:'center',
										items:[form],
										modal:true,
										plain:true,
										listeners:
											{
												show:
												{
													buffer:10,
                                                    fn:function()
														{
																Ext.getCmp(txtCod).focus(false,500);
														}
												}
											},
										buttons:
												[
												 	{
														text:'Aceptar',
														handler:function ()
															{
                                                            	if(accion!=undefined)
                                                                {
                                                                	idOrganigrama=nodoSel.id;
                                                                }
                                                                var centroCosto;
                                                            	if((tipoUnidad==1)||(tipoUnidad=='3'))
                                                                {
                                                                	var codUnidad=Ext.getCmp(txtCod).getValue();
	                                                           		var telefonos=recoletarValoresCombo('cmbTelefonoInst');
                                                                    var txtInstitucion=Ext.getCmp('txtInstitucionNueva');
                                                                    var objIns='';
                                                                    if(cmbPais.getValue()=='146')
                                                                    {
                                                                    	var estado=gEx('cmbEstado').getValue();
                                                                        var municipio=gEx('cmbMunicipio').getValue();
                                                                        var localidad=gEx('cmbLocalidad').getValue();
                                                                        var colonia=gEx('cmbColonia').getValue();
                                                                        var cp=gEx('txtCp').getValue();
                                                                        var calle=gEx('txtCalle').getValue();
                                                                        var numero=gEx('txtNumero').getValue();
                                                                    	objIns='{"idPais":"'+cmbPais.getValue()+'","estado":"'+estado+'","municipio":"'+municipio+'","localidad":"'+localidad+'","colonia":"'+colonia+'","cp":"'+cp+'","calle":"'+calle+'","numero":"'+numero+'"}';
                                                                    }
                                                                    else
                                                                    {
                                                                    	var estado=gEx('txtEstado1').getValue();
                                                                        var municipio='';
                                                                        var localidad=gEx('txtCiudad1').getValue();
                                                                        var colonia='';
                                                                        var cp=gEx('txtCp1').getValue();
                                                                        var calle=gEx('txtCalle1').getValue();
                                                                        var numero=gEx('txtNumero1').getValue();
                                                                    	objIns='{"idPais":"'+cmbPais.getValue()+'","estado":"'+estado+'","municipio":"'+municipio+'","localidad":"'+localidad+'","colonia":"'+colonia+'","cp":"'+cp+'","calle":"'+calle+'","numero":"'+numero+'"}';
                                                                    }
                                                                    var txtCp=Ext.getCmp('txtCp');
                                                                    var txtCiudad=Ext.getCmp('txtCiudad');
                                                                    var txtEstado=Ext.getCmp('txtEstado');
                                                                    if(txtInstitucion.getValue()=='')
                                                                    {
                                                                        function resp()
                                                                        {
                                                                            txtInstitucion.focus();
                                                                        }
                                                                        msgBox("El campo de instituci&oacute;n es obligatorio",resp);
                                                                        return;
                                                                    }
                                                                    var descripcion=cv(Ext.getCmp('txtDescripcion').getValue());
                                                                    var objParam='{"CC":"'+cmbCentroCosto2.getValue()+'","idOrganigrama":"'+idOrganigrama+'","codUnidad":"'+codUnidad+'","codigoUPadre":"'+codigoPadre+'","nombre":"'+cv(txtInstitucion.getValue())+'","descripcion":"'+descripcion+'","institucion":"1","objInst":'+objIns+',"telefonos":"'+telefonos+'"}';
                                                                    guardarInstitucion(objParam,ventana);    
                                                            	}  
                                                                else
                                                                {
                                                                	var txtClaveDep=gEx('txtClaveDep').getValue();
                                                                	var codUnidad=Ext.getCmp(txtCod).getValue();
                                                                	var telefonos=recoletarValoresCombo('cmbTelefonoDepto');
                                                                	var depto=Ext.getCmp('txtDeptoNuevo').getValue();
                                                                    var descripcion=Ext.getCmp('txtDescripcionDepto').getValue();
                                                                    var objParam='{"txtClaveDep":"'+txtClaveDep+'","longCod":"'+longCod+'","idOrganigrama":"'+idOrganigrama+'","codUnidad":"'+codUnidad+'","codigoUPadre":"'+codigoPadre+'","nombre":"'+cv(depto)+'","descripcion":"'+cv(descripcion)+'","institucion":"0"'+',"telefonos":"'+telefonos+'","CC":"'+cmbCentroCosto.getValue()+'"}';
                                                                    guardarDepartamento(objParam,ventana);
                                                                }
                                                                                                                          
															}
													},
													{
														text:'Cancelar',
														handler:function ()
															{
																ventana.close();
																
															}
													}
												 ]
									}
							   )
	if(tipoUnidad==0)
    {
        Ext.getCmp('panelUnidad').show();
        Ext.getCmp('panelInst').hide();
        ventana.setSize(480,440);
    }
    else
    {
        Ext.getCmp('panelInst').show();    
        Ext.getCmp('panelUnidad').hide();
        ventana.setSize(550,585);
	}                               
                               
	if(accion!=undefined)
    	llenarDatosUnidad(ventana,nodoSel);
    else
    {                               
		ventana.show();   
                 
    }
}

function agregarUnidad(unidaPadre,accion,tipoUnidad)
{
	var idOrganigrama="-1";
	var arrPaises=<?php echo $arrPaises?>;
    var arrUnidades=[['1','Departamento'],['2','Instituci\u00F3n']];
	var cmbPais=null;
    
    var cmbEstado=crearComboExt('cmbEstado',[],120,5);
    
    
    
    var controlTelefono='<table  border="0" cellspacing="1" cellpadding="1">'+
                        '<tr><td width="19"><table><tr><td>'+
                        '<a href="javaScript:solicitarTel(\'cmbTelefonoInst\')"><img src="../images/icon_big_tick.gif" alt="Agregar" height="15" title="Agregar Tel�fono" border="0"/></a>'+
                        '</td></tr><tr><td>'+
                        '<a href="javaScript:eliminarTelefono(\'cmbTelefonoInst\')"><img src="../images/cancel_round.png" alt="Eliminar" title="Eliminar Tel�fono" border="0"/></a>'+
                        '</td></tr></table><br /></td><td width="5"  align="left">&nbsp;</td><td  >&nbsp;<select class="SIUGJ_Control" name="cmbTelefonoInst" id="cmbTelefonoInst" size="5" style="width:270px; height:80px !important;"></select><input type="hidden" name="telefonos" id="telefonos" value="" />'+
                        '</td></tr></table>';

	var controlMail='<table  border="0" cellspacing="1" cellpadding="1">'+
                        '<tr><td width="19"><table><tr><td>'+
                        '<a href="javaScript:solicitarEMail()"><img src="../images/icon_big_tick.gif" alt="Agregar Correo electr&oacute;nico" height="15" title="Agregar Correo electr&oacute;nico" border="0"/></a>'+
                        '</td></tr><tr><td>'+
                        '<a href="javascript:eliminarEmail()"><img src="../images/cancel_round.png" alt="Eliminar Correo electr&oacute;nico" title="Eliminar Correo electr&oacute;nico" border="0"/></a>'+
                        '</td></tr></table><br /></td><td width="5"  align="left">&nbsp;</td><td  >&nbsp;<select class="SIUGJ_Control" name="cmbMail" id="cmbMail" size="5" style="width:270px; height:80px !important;"></select><input type="hidden" name="mailes" id="mailes" value="" />'+
                        '</td></tr></table>';                        
	
    
	
    
    var cmbEstado=null; 
    var cmbMunicipio=null;
    
   
	var panelDir2=	{
    					id:'panelDir2',
                        layout:'absolute',
                        xtype:'panel',
                        baseCls: 'x-plain',
                        defaultType: 'label',
                        x:0,
                        y:60,
                        width:720,
                        height:400,
                        items:[
                                    {
                                        x:10,
                                        y:10,
                                        cls:'SIUGJ_Etiqueta',
                                        html:'Departamento:'
                                    },
                                    {
                                        x:180,
                                        y:5,
                                        html:'<div id="divComboDepartamento" style="width:310px"></div>'
                                    },
                                    {
                                        x:10,
                                        y:60,
                                        cls:'SIUGJ_Etiqueta',
                                        html:'Municipio:'
                                    },
                                    {
                                        x:180,
                                        y:55,
                                        html:'<div id="divComboMunicipio" style="width:310px"></div>'
                                    },
                                    {
                                        x:10,
                                        y:110,
                                        html:'Domicilio:',
                                        cls:'SIUGJ_Etiqueta',
                                    },		
                                    				
                                    {
                                        x:180,
                                        y:105,
                                        cls:'controlSIUGJ',
                                        id:'txtCalle',
                                        xtype:'textarea',
                                        width:500,
                                        height:60
                                    },
                                    {
                                        x:380,
                                        y:70,
                                        hidden:true,
                                        html:'N&uacute;mero:',
                                        baseCls: 'x-plain'
                                    },						
                                    {
                                        x:440,
                                        y:65,
                                        hidden:true,
                                        id:'txtNumero',
                                        xtype:'textfield',
                                        width:80
                                        
                                    }
                                    ,						
                                    {
                                        x:120,
                                        y:125,
                                        id:'txtCp',
                                        hidden:true,
                                        xtype:'textfield',
                                        width:80,
                                        allowDecimals:false,
                                        allowNegative:false
                                    },
                                    {
                                        x:10,
                                        y:100,
                                        hidden:true,
                                        baseCls: 'x-plain',
                                        html:'Colonia:'
                                    },
                                    {
                                    	x:120,
                                        y:95,
                                        hidden:true,
                                        id:'cmbColonia',
                                        xtype:'textfield',
                                        width:220
                                    },
                                    {
                                        x:10,
                                        y:130,
                                        html:'CP.:',
                                        hidden:true,
                                        baseCls: 'x-plain'
                                    }
                                    
                                    
                                    
                                ]
                    }                    
        
    var txtCod;
    var codigoPadre='';
    var longCod=4;
    var ancho=80;
    var lblVentana;
    
    if(accion==1)
        lblVentana='Agregar Unidad ('+formatearValorRenderer(arrCategorias,tipoUnidad)+')';
    else
        lblVentana='Modificar Unidad ('+formatearValorRenderer(arrCategorias,nodoSel.attributes.idTipoUnidad)+')';    
    
    codigoPadre=unidaPadre;
    txtCod='txtCodigoInst';

	var cmbTipoUnidad=null;
	
    var panelInst=new Ext.Panel(
    								{
                                    	id:'panelInst',
                                    	x:10,
                                        y:10,
                                        baseCls: 'x-plain',
										layout:'absolute',
                                        width:680,
                                        height:500,
                                        defaultType: 'label',
                                    	items:[
                                        		{
                                                      
                                                      x:10,
                                                      y:20,
                                                      cls:'SIUGJ_Etiqueta',
                                                      html:'Cve. Unidad:'
                                                  },
                                                  {
                                                      x:230,
                                                      cls:'',
                                                      id:'txtCodigoInst',
                                                      cls:'controlSIUGJ',
                                                      xtype:'textfield',
                                                      width:200,
                                                      y:15
                                                  },
                                                  {
                                                      x:10,
                                                      y:60,
                                                      cls:'SIUGJ_Etiqueta',
                                                      html:'Nombre de la Unidad: <font color="red">*</font>'
                                                  },
                                                  {
                                                      x:230,
                                                      y:55,
                                                      cls:'controlSIUGJ',
                                                      id:'txtInstitucionNueva',
                                                      xtype:'textfield',
                                                      width:430
                                                  },
                                                  {
	                                               	  x:10,
                                                      y:100,
                                                      cls:'SIUGJ_Etiqueta',
                                                      html:'Descripci&oacute;n:'
                                                  },
                                                  {
                                                  	x:230,
                                                    y:95,
                                                    cls:'controlSIUGJ',
                                                    xtype:'textarea',
                                                    width:430,
                                                    height:80,
                                                    id:'txtDescripcion'
                                                  },
                                                  {
                                                  	x:10,
                                                    y:200,
                                                    cls:'SIUGJ_Etiqueta',
                                                    html:'Tipo de Unidad: <font color="red">*</font>'
                                                  },
                                                  {
                                                      x:230,
                                                      y:195,
                                                      html:'<div id="divComboTipoUnidad"></div>'
                                                  }
                                              ]
                                    }
                                )
    
    
     
    
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											disabled:false,
                                            defaultType:'label',
											items:	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            id:'tabGral',
                                                            activeTab:2,
                                                            height:500,
                                                            width:700,
                                                            cls:'tabPanelSIUGJ',
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            baseCls: 'x-plain',
                                                                            title:'Datos generales',
                                                                            layout:'absolute',
                                                                            items:[panelInst]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            baseCls: 'x-plain',
                                                                            defaultType: 'label',
                                                                            title:'Datos de ubicaci&oacute;n',
                                                                            layout:'absolute',
                                                                            items:	[
                                                                                        {
                                                                                              x:10,
                                                                                              y:20,
                                                                                              cls:'SIUGJ_Etiqueta',  
                                                                                              defaultType: 'label',                                                                                            
                                                                                              html:'Pa&iacute;s:<font color="red">*</font>'
                                                                                          }
                                                                                          ,
                                                                                          	{
                                                                                            	x:180,
                                                                                           	 	y:15,
                                                                                            	html:'<div id="divComboPais" style="width:310px"></div>'
                                                                                        	},
                                                                                          panelDir2,
                                                                                    ]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            baseCls: 'x-plain',
                                                                            title:'Datos de contacto',
                                                                            defaultType: 'label',
                                                                            layout:'absolute',
                                                                            items:	[
                                                                                        {
                                                                                          x:10,
                                                                                          y:20,
                                                                                          cls:'SIUGJ_Etiqueta',
                                                                                          html:'Tel&eacute;fono de contacto:'
                                                                                        },
                                                                                        {
                                                                                          x:210,
                                                                                          y:15,
                                                                                          baseCls: 'x-plain',
                                                                                          html:controlTelefono
                                                                                        },
                                                                                        {
                                                                                          x:10,
                                                                                          y:120,
                                                                                          cls:'SIUGJ_Etiqueta',
                                                                                          html:'Correo electr&oacute;nico:'
                                                                                        },
                                                                                        {
                                                                                          x:210,
                                                                                          y:115,
                                                                                          baseCls: 'x-plain',
                                                                                          html:controlMail
                                                                                        }
                                                                                    ]
                                                                        }
                                                            		]
                                                                    
                                                        }
                                                        

                                                   ]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:lblVentana,
										width:750,
										height:400,
										layout:'fit',
                                        closable:false,
                                        cls:'msgHistorialSIUGJ',
										buttonAlign:'center',
										items:[form],
										modal:true,
										plain:true,
										listeners:
											{
												show:
												{
													buffer:10,
                                                    fn:function()
														{
                                                        		var x=2;
                                                                for(x=1;x>=0;x--)
                                                                    gEx('tabGral').setActiveTab(x);
                                                                         
																Ext.getCmp(txtCod).focus(false,500);
                                                                cmbTipoUnidad=crearComboExt('cmbTipoUnidad',arrCategorias,0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboTipoUnidad'});
																cmbTipoUnidad.setValue(tipoUnidad);
    															cmbTipoUnidad.disable();
                                                                
                                                                
                                                                var cmbEstado="";
                                                                var cmbPais=crearComboExt('cmbPais',arrPaises,0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboPais'});
                                                                cmbPais.setValue('52');
                                                                var cmbEstado=crearComboExt('cmbEstado',<?php echo $arrEstados?>,0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboDepartamento'}); 
                                                                var cmbMunicipio=crearComboExt('cmbMunicipio',[],0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboMunicipio'});
                                                                
                                                                cmbPais.on('select',function (combo,registro)
                                                                                    {
                                                                                        cmbEstado.setValue('');
                                                                                        cmbMunicipio.setValue('');
                                                                                        cmbMunicipio.getStore().removeAll();
                                                                                        var cmbColonia=gEx('cmbColonia');
                                                                                        cmbColonia.setValue('');
                                                                                        
                                                                                       
                                                                                        
                                                                                        function funcAjax()
                                                                                        {
                                                                                            var resp=peticion_http.responseText;
                                                                                            arrResp=resp.split('|');
                                                                                            if(arrResp[0]=='1')
                                                                                            {
                                                                                            
                                                                                                gEx('cmbEstado').getStore().loadData(eval(arrResp[1]));
                                                                                                gEx('cmbEstado').setValue('');
                                                                                                if(estadoSel)
                                                                                                {
                                                                                                    gEx('cmbEstado').setValue(estadoSel);
                                                                                                    dispararEventoSelectCombo('cmbEstado');
                                                                                                    estadoSel=null;
                                                                                                    
                                                                                                }
                                                                                                
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                            }
                                                                                        }
                                                                                        obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=60&accion=4&codigo='+registro.get('id'),true);
                                                                                        
                                                                                            
                                                                                        
                                                                                        
                                                                                        
                                                                                        
                                                                                        
                                                                                    }
                                                                
                                                                    )
                                                                cmbEstado.on('select',	function(combo,registro,indice,obj)
                                                                                            {
                                                                                                function funcAjax()
                                                                                                {
                                                                                                    var resp=peticion_http.responseText;
                                                                                                    arrResp=resp.split('|');
                                                                                                    if(arrResp[0]=='1')
                                                                                                    {
                                                                                                        cmbMunicipio.getStore().loadData(eval(arrResp[1]));
                                                                                                        cmbMunicipio.setValue('');
                                                                                                        if(municipioSel)
                                                                                                        {
                                                                                                            cmbMunicipio.setValue(municipioSel);
                                                                                                            dispararEventoSelectCombo('cmbMunicipio');
                                                                                                            municipioSel=null;
                                                                                                            
                                                                                                        }
                                                                                                        
                                                                                                        
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=60&accion=1&codigo='+registro.get('id'),true);
                                                                                            }
                                                                                )
                                                           		
                                                                if(accion=='0')
                                                                    llenarDatosUnidad(ventana,nodoSel);
                                                                else
                                                                {                               
                                                                    
                                                                    var x=2;
                                                                    for(x=1;x>=0;x--)
                                                                        gEx('tabGral').setActiveTab(x);
                                                                             
                                                                }     
                                                                
                                                        }
												}
											},
										buttons:
												[
												 	{
														text:'Cancelar',
                                                        cls:'btnSIUGJCancel',
                                                        width:140,
														handler:function ()
															{
																ventana.close();
																
															}
													},
                                                    {
														text:'Aceptar',
                                                        cls:'btnSIUGJ',
                                                        width:140,
														handler:function ()
															{
                                                            	if(accion=='0')
                                                                	idOrganigrama=nodoSel.id;
                                                            	
                                                                var codUnidad=Ext.getCmp('txtCodigoInst').getValue();
                                                                var telefonos=recoletarValoresCombo('cmbTelefonoInst');
                                                                var txtInstitucion=Ext.getCmp('txtInstitucionNueva');
                                                                var objIns='';
                                                                var estado=gEx('cmbEstado').getValue();
                                                                var municipio=gEx('cmbMunicipio').getValue();
                                                                var localidad='';
                                                                var colonia=gEx('cmbColonia').getValue();
                                                                var cp=gEx('txtCp').getValue();
                                                                var calle=gEx('txtCalle').getValue();
                                                                var numero=gEx('txtNumero').getValue();
                                                                objIns='{"idPais":"'+gEx('cmbPais').getValue()+'","estado":"'+estado+'","municipio":"'+municipio+'","localidad":"'+localidad+'","colonia":"'+cv(colonia)+'","cp":"'+cp+'","calle":"'+cv(calle)+'","numero":"'+numero+'"}';
                                                                
                                                                var txtCp=Ext.getCmp('txtCp');
                                                                var txtCiudad=Ext.getCmp('txtCiudad');
                                                                var txtEstado=Ext.getCmp('txtEstado');
                                                                if(txtInstitucion.getValue()=='')
                                                                {
                                                                    function resp()
                                                                    {
                                                                    	gEx('tabGral').setActiveTab(0);
                                                                        txtInstitucion.focus();
                                                                    }
                                                                    msgBox("Debe ingresar el nombre de la unidad",resp);
                                                                    return;
                                                                }
                                                                var tUnidad=cmbTipoUnidad.getValue();
                                                                if(gEx('cmbTipoUnidad').getValue()=='')
                                                                {
                                                                	function resp2()
                                                                    {
                                                                    	gEx('tabGral').setActiveTab(0);
                                                                    	gEx('cmbTipoUnidad').focus();
                                                                    }
                                                                    msgBox('Debe indicar el tipo de unidad a agregar',resp2);
                                                                    return;
                                                                }
                                                                
                                                                if(gEx('cmbPais').getValue()=='')
                                                                {
                                                                	function resp3()
                                                                    {
                                                                    	gEx('tabGral').setActiveTab(1);
                                                                    	gEx('cmbPais').focus();
                                                                    }
                                                                    msgBox('Debe indicar el pa&iacute;s al cual pertenece la unidad a agregar',resp3);
                                                                    return;
                                                                }
                                                                
                                                                var cmbMail=gE('cmbMail');
                                                                var email='';
                                                                var x;
                                                                for(x=0;x<cmbMail.options.length;x++)
                                                                {
                                                                	if(email=='')
                                                                    	email=cmbMail.options[x].value;
                                                                    else
                                                                    	email+=','+cmbMail.options[x].value;
                                                                    
                                                                }
                                                                
                                                                var descripcion=cv(Ext.getCmp('txtDescripcion').getValue());
                                                                var objParam='{"idOrganigrama":"'+idOrganigrama+'","codUnidad":"'+codUnidad+'","codigoUPadre":"'+codigoPadre+'","nombre":"'+cv(txtInstitucion.getValue())+
                                                                			'","descripcion":"'+descripcion+'","institucion":"'+tUnidad+'","objInst":'+objIns+',"telefonos":"'+telefonos+'","email":"'+email+'"}';
                                                                
                                                                guardarInstitucion(objParam,ventana);    
                                                            	
                                                                                                                          
															}
													}
												 ]
									}
							   )
	ventana.show();  
	
}

function solicitarEMail()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Correo electr&oacute;nico:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            width:300,
                                                            x:200,
                                                            y:15,
                                                            cls:'controlSIUGJ',
                                                            id:'txtMail'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Correo electr&oacute;nico',
										width: 600,
										height:200,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
                                        closable:false,
                                        cls:'msgHistorialSIUGJ',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	gEx('txtMail').focus(false,500);
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
																		var txtMail=gEx('txtMail');
                                                                        if(!validarCorreo(txtMail.getValue().trim()))
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtMail.focus();
                                                                            }
                                                                            msgBox('La direcci&oacute;n de correo electr&oacute;nico no es v&aacute;lida',resp);
                                                                            return;
                                                                        }
                                                                        var cmbMail=gE('cmbMail');
                                                                        if(existeValor(cmbMail,txtMail.getValue().trim())!=-1)
                                                                        {
                                                                        	msgBox('La direcci&oacute;n de correo electr&oacute;nico ingresada ya ha sido registrada previamente');
                                                                        	return;
                                                                        }
                                                                        var opcion;
                                                                		opcion=cE('option');
                                                                        opcion.text=txtMail.getValue().trim();
                                                                        opcion.value=txtMail.getValue().trim();
                                                                        cmbMail.options[cmbMail.options.length]=opcion;
                                                                        ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}

function eliminarEmail()
{
	var cmbMail;
	cmbMail=gE('cmbMail');
	if(cmbMail.selectedIndex==-1)
	{
		msgBox('Debe seleccionar la direcci&oacute;n E-mail que desea remover');
		return;
	}
	function resp(btn)
	{
		if(btn=='yes')
		{
			cmbMail.options[cmbMail.selectedIndex]=null;
		}
	}
	msgConfirm('�Est&aacute; seguro de querer remover la direcci&oacute;n de E-mail seleccionada?',resp);
	
}

function guardarInstitucion(objInst,ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var tOrganigrama=Ext.getCmp('tOrganigrama');
            tOrganigrama.getRootNode().reload();
            tOrganigrama.expandAll();
            ventana.close();
            if(nodoSel)
	            idNodoSeleccionado=nodoSel.id;
            else
            	idNodoSeleccionado=arrResp[1];
           	nodoSel=null;

            Ext.getCmp('btnPuesto').disable();
            Ext.getCmp('btnAsignarPuesto').disable();
            gEx('btnEliminar').disable();
            gEx('btnActivar').disable();
            gEx('btnModificar').disable();
            gEx('btnResponsable').disable();
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=33&param='+objInst,true);
}

function guardarDepartamento(obj,ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var tOrganigrama=Ext.getCmp('tOrganigrama');
            tOrganigrama.getRootNode().reload();
            //tOrganigrama.expandAll();
        	ventana.close();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=34&param='+obj,true);
}

function llenarDatosUnidad(ventana,nodoSel)
{
    var alto;
    var telefonos=nodoSel.attributes.telefonos;
   	var descTel=nodoSel.attributes.descTel;
    gEx('cmbTipoUnidad').setValue(nodoSel.attributes.institucion);
    var arrTelefonos=new Array();
    if(telefonos!='')
    {
        var arrTel=telefonos.split(',');
        var arrDescTel=descTel.split('<br>');
        var arr;
        var x;
        for(x=0;x<arrTel.length;x++)
        {
            arr=new Array();
            arr[0]=arrTel[x];
            arr[1]=arrDescTel[x];
            arrTelefonos[x]=arr;
        }
	}    
    
    
    var mails=nodoSel.attributes.mails;
    var arrMail=new Array();
    var aMail=new Array();
    if(mails!='')
    {
        var arrMail=mails.split(',');
        var arr;
        var x;
        for(x=0;x<arrMail.length;x++)
        {
            arr=new Array();
            arr[0]=arrMail[x];
            arr[1]=arrMail[x];
            aMail[x]=arr;
        }
	}    
    var c
    
    var combo;
    var txtCodigo;
	
    txtCodigo=Ext.getCmp('txtCodigoInst');
    txtCodigo.setValue(nodoSel.attributes.codDepto);
    combo=gE('cmbTelefonoInst');
    rellenarCombo(combo,arrTelefonos)
    combo=gE('cmbMail');
    rellenarCombo(combo,aMail)
    var codigoU=nodoSel.attributes.codigoU;
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var datosIns=eval(arrResp[1])[0];
            var txtInstitucion=Ext.getCmp('txtInstitucionNueva');
            txtInstitucion.setValue(datosIns.institucion);
            var txtCp=Ext.getCmp('txtCp');
            txtCp.setValue(datosIns.cp);
            var cmbPais=Ext.getCmp('cmbPais');
            cmbPais.setValue(datosIns.idPais);
            var pos=obtenerPosFila(cmbPais.getStore(),'id',datosIns.idPais);
            if(pos!='-1')
            {
                var registro=cmbPais.getStore().getAt(pos);
                cmbPais.fireEvent('select',cmbPais,registro);
            }
           
            
            estadoSel=datosIns.estado;
            municipioSel=datosIns.municipio;
            
            
            
            gEx('txtCp').setValue(datosIns.cp);
            gEx('txtCalle').setValue(datosIns.calle);
            gEx('txtNumero').setValue(datosIns.numero);
           
            gEx('cmbColonia').setValue(datosIns.colonia);
                
            
            
            var descripcion=Ext.getCmp('txtDescripcion');
            descripcion.setValue(dv(nodoSel.attributes.descripcion));
            ventana.show();   
            gEx('tabGral').setActiveTab(0);
            txtInstitucion.focus(false,1000);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=27&codU='+codigoU,true);
    
}

var tipoTel;

function solicitarTel(idCombo)
{
	tipoTel='0';
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											disabled:false,
											items:
													[
                                                    
                                                    	new Ext.form.Label(
																		   		{
																					x:5,
																					y:20,
                                                                                    cls:'SIUGJ_Etiqueta',
																					text: 'Tipo:'
																				}
																		   ),
														new Ext.form.Radio
														(
															{
                                                                x:140,
                                                                y:15,
                                                                checked:true,
                                                                boxLabel:'Tel&eacute;fono',
                                                                ctCls:'SIUGJ_Etiqueta',
                                                                allowBlank :true,
                                                                value:'0',
                                                                id:'Tel'
															}
														),
														
														new Ext.form.Radio
														(
															{
                                                                x:270,
                                                                y:15,
                                                                checked:false,
                                                                boxLabel:'Fax',
                                                                ctCls:'SIUGJ_Etiqueta',
                                                                allowBlank :true,
                                                                value:'2',
                                                                id:'Fax'
															}
														),
                                                    
                                                    	new Ext.form.Label(
																		   		{
																					x:5,
																					y:70,
                                                                                    cls:'SIUGJ_Etiqueta',
																					html: 'Pa&iacute;s:'
																				}
																		   ),
                                                       	{
                                                            x:140,
                                                            y:65,
                                                            xtype:'label',
                                                            html: '<div id="divComboPaisTelefono"></div>'
                                                        }, 
                                                    
													 	new Ext.form.Label(
																		   		{
																					x:5,
																					y:120,
                                                                                    cls:'SIUGJ_Etiqueta',
																					html: 'No. Tel&eacute;fono:'
																				}
																		   ),
                                                        
                                                        new Ext.form.NumberField
														(
															{
                                                                x:120,
                                                                y:115,
                                                                cls:'controlSIUGJ',
                                                                width:40,
                                                                height:20,
                                                                hidden:true,
                                                                id:'txtLada',
                                                                maxLengthText:'La lada debe contener solo 3 n&uacute;meros',
                                                                maxLength:3,
                                                                allowDecimals:false,
                                                                allowNegative:false
															}
														),     
                                                        
                                                        new Ext.form.NumberField
														(
															{
																x:140,
                                                                y:115,
                                                                cls:'controlSIUGJ',
                                                                width:140,
                                                                maxLength :10,
                                                                id:'txtTelefono',
                                                                allowDecimals:false,
                                                                allowNegative:false
															}
														),                   
                                                                           
                                                                      
                                                                           
														new Ext.form.Label(
																		   		{
																					x:330,
																					y:120,
                                                                                    cls:'SIUGJ_Etiqueta',
																					html: 'Extensi&oacute;n:'
																				}
																		   ),
                                                      	new Ext.form.NumberField
														(
															{
                                                                x:430,
                                                                y:115,
                                                                cls:'controlSIUGJ',
                                                                width:100,
                                                                id:'txtExtensiones',
                                                                allowDecimals:false,
                                                                allowNegative:false
															}
														)
														
														
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar N&uacute;mero Telef&oacute;nico',
										width:580,
										height:270,
                                        cls:'msgHistorialSIUGJ',
										layout:'fit',
										buttonAlign:'center',
										items:[form],
										modal:true,
										plain:true,
										listeners:
											{
												show:
												{
													buffer:10,fn:function()
															{
																Ext.getCmp('txtLada').focus(false,1000);
                                                                var comboPaisTelefono=crearComboExt('comboPaisTelefono',arrPaises,0,0,250,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboPaisTelefono'});                        
																comboPaisTelefono.setValue('52');
															}
												}
											},
										buttons:
												[
                                                	{
														text:'Cancelar',
                                                        cls:'btnSIUGJCancel',
                                                        width:140,
														handler:function ()
															{
																ventana.close();
																
															}
													},
												 	{
														text:'Aceptar',
                                                        cls:'btnSIUGJ',
                                                        width:140,
														handler:function ()
															{
                                                            	var codArea=Ext.getCmp('comboPaisTelefono').getValue();
																var tel=Ext.getCmp('txtTelefono').getValue()+'';
																var exten=Ext.getCmp('txtExtensiones').getValue()+'';
																var lada=Ext.getCmp('txtLada').getValue();
                                                                if(codArea.length==00)
                                                                {
                                                                	function enfocarCodArea()
                                                                    {
                                                                    	gEx('comboPaisTelefono').focus();
                                                                    }
                                                                	msgBox('Debe seleccionar el pa&iacute;s al cual pertenece el n&uacute;mero telef&oacute;nico',enfocarCodArea);
                                                                    return;
                                                                }
                                                                
                                                                if(tel.length==0)
                                                                {
                                                                	function enfocarTelefono()
                                                                    {
                                                                    	Ext.getCmp('txtTelefono').focus();
                                                                    }
                                                                	msgBox('El n&uacute;mero de tel&eacute;fono ingresado no es v&aacute;lido',enfocarTelefono);
                                                                    return;
                                                                }
                                                                
                                                                
                                                                if(tel.length!=10)
                                                                {
                                                                	function enfocarTelefono2()
                                                                    {
                                                                    	Ext.getCmp('txtTelefono').focus();
                                                                    }
                                                                	msgBox('El n&uacute;mero de tel&eacute;fono debe ser de 10 d&iacute;gitos',enfocarTelefono2);
                                                                    return;
                                                                }
                                                                
                                                                /*if(lada.length==0)
                                                                {
                                                                	function enfocarLada()
                                                                    {
                                                                    	Ext.getCmp('txtLada').focus();
                                                                    }
                                                                	msgBox('El n&uacute;mero Lada ingresado no es v&aacute;lido',enfocarLada);
                                                                    return;
                                                                }*/
                                                                
                                                                var opcion;
                                                                
                                                                opcion=cE('option');
                                                                opcion.value=tipoTel+'_'+codArea+'_'+lada+'_'+tel+'_'+exten;
                                                                var extens='Ext.: '+exten;
                                                                
                                                                switch(tipoTel)
                                                                {
                                                                    case "0":
                                                                        tipoTel='Tel\u00E9fono';
                                                                    break;
                                                                    /*case "1":
                                                                        tipoTel='Celular';
                                                                    break;*/
                                                                    case "2":
                                                                        tipoTel='Fax';
                                                                    break;
                                                                }
                                                                
                                                                if (exten!="")
                                                                    opcion.text='['+tipoTel+'] ('+codArea+') '+lada+"-"+tel + " ("+extens+")";
                                                                else
                                                                    opcion.text='['+tipoTel+'] ('+codArea+') '+lada+"-"+tel+" ()";

                                                               var cmbTelefono=gE(idCombo);
                                                               var resp=existeValor(cmbTelefono,opcion.value);
                                                               if(resp==-1)
                                                               {
                                                               		cmbTelefono.options[cmbTelefono.options.length]=opcion;
                                                               }
                                                               ventana.close();
	
															}
													}
													
												 ]
									}
							   )
	
	var tel=Ext.getCmp('Tel');
	var fax=Ext.getCmp('Fax');
	//var movil=Ext.getCmp('Movil');
	tel.on('check',radioCheck);
	fax.on('check',radioCheck);
	//movil.on('check',radioCheck);
	ventana.show();
	
}

function radioCheck(chk,valor)
{
	if(valor==true)
	{
		var tel=Ext.getCmp('Tel');
		var fax=Ext.getCmp('Fax');
		//var movil=Ext.getCmp('Movil');
		tipoTel=chk.value;
		if(tel.id!=chk.id)
			tel.setValue(false);
		if(fax.id!=chk.id)
			fax.setValue(false);
		/*if(movil.id!=chk.id)
			movil.setValue(false);*/
	}
	
}

function eliminarTelefono(idCombo)
{
	var cmbTelefono;
	cmbTelefono=gE(idCombo);
	if(cmbTelefono.selectedIndex==-1)
	{
		msgBox('Debe seleccionar el n&uacute;mero telef&oacute;nico a eliminar');
		return;
	}
	function resp(btn)
	{
		if(btn=='yes')
		{
			cmbTelefono.options[cmbTelefono.selectedIndex]=null;
		}
	}
	Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>','Est&aacute; seguro de querer eliminar el n&uacute;mero telef&oacute;nico seleccionado?',resp);
	
}

var filaPuesto=null;

function mostrarVentanaTabulacion(filaSel)
{
	filaPuesto=filaSel;
	var gridTabulaciones=crearGridTabulacion();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'<b>C&oacute;d. puesto:</b>'
                                                        },
                                                        {
                                                        	x:100,
                                                            y:10,
                                                            html:filaSel.get('cvePuesto')
                                                        },
                                                        {
                                                        	x:300,
                                                            y:10,
                                                            html:'<b>Puesto:</b>'
                                                        },
                                                        {
                                                        	x:370,
                                                            y:10,
                                                            html:filaSel.get('puesto')
                                                        },
                                                        
                                                        gridTabulaciones

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Tabulaci&oacute;n de puestos',
										width: 900,
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
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
                                
	llenarDatosTabulacion(ventanaAM,filaSel);                                

}

function llenarDatosTabulacion(ventana,filaSel)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
        	Ext.getCmp('gridTab').getStore().loadData(arrDatos);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=37&idPuesto='+filaSel.get('idPuesto'),true);

}

var regTabulacion=crearRegistro(	[
                                        {name: 'idTabulacion'},
                                        {name: 'codTabulacion'},
                                        {name: 'idZona'},
                                        {name: 'salarioMin'},
                                        {name: 'salarioMax'},
                                        {name: 'status'},
                                        {name: 'ocupado'},
                                        {name: 'tipoPuesto'}
                                    ]
								)

function crearGridTabulacion()
{
	var arrZonas=<?php echo $arrZonas?>;
    var arrStatus=<?php echo $arrStatus?>;
	var cmbZonas=crearComboExt('cmbZonas',arrZonas);
    var cmbSituacion=crearComboExt('cmbSituacion',arrStatus);
    var cmbTipoPuesto=crearComboExt('cmbTipoPuesto',arrTipoPuesto);
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idTabulacion'},
                                                                    {name: 'codTabulacion'},
                                                                    {name: 'idZona'},
                                                                    {name: 'salarioMin'},
                                                                    {name: 'salarioMax'},
                                                                    {name: 'status'},
                                                                    {name: 'ocupado'},
                                                                    {name: 'tipoPuesto'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
    var editorFila=new Ext.ux.grid.RowEditor	(
    												{
                                                        saveText: 'Guardar',
                                                        cancelText:'Cancelar',
                                                        clicksToEdit:2
                                                    }
                                                );

	editorFila.on('beforeedit',funcEditorFilaBeforeEdit)
    editorFila.on('validateedit',funcEditorValida);
    editorFila.on('canceledit',funcEditorCancelEdit);                                                
    
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'C&oacute;digo tabulaci&oacute;n',
															width:125,
															sortable:true,
															dataIndex:'codTabulacion',
                                                            editor:new Ext.form.TextField({id:'txtCodTab'})
														},
                                                        {
															header:'Tipo puesto',
															width:120,
															sortable:true,
															dataIndex:'tipoPuesto',
                                                            editor:cmbTipoPuesto,
                                                            renderer:function(val)
                                                            		{
                                                                    	var pos=existeValorMatriz(arrTipoPuesto,val,0);
                                                                        if(pos==-1)
                                                                        	return '';
                                                                        return arrTipoPuesto[pos][1];
                                                                    }
														}
                                                        ,
														{
															header:'Zona',
															width:150,
															sortable:true,
															dataIndex:'idZona',
                                                            editor:cmbZonas,
                                                            renderer:function(val)
                                                            		{
                                                                    	var pos=existeValorMatriz(arrZonas,val,0);
                                                                        if(pos==-1)
                                                                        	return '';
                                                                        return arrZonas[pos][1];
                                                                    }
														},
                                                        
                                                        {
															header:'Salario m&iacute;nimo',
															width:100,
															sortable:true,
															dataIndex:'salarioMin',
                                                            renderer:'usMoney',
                                                            editor:new Ext.form.NumberField	(
                                                            									{
                                                                                                	id:'txtSalMinimo',
                                                                                                    allowDecimals:true,
                                                                                                    allowNegative:false
                                                                                                }
                                                            								)
														},
                                                        {
															header:'Salario m&aacute;ximo',
															width:100,
															sortable:true,
															dataIndex:'salarioMax',
                                                            renderer:'usMoney',
                                                            editor:new Ext.form.NumberField	(
                                                            									{
                                                                                                	id:'txtSalMaximo',
                                                                                                    allowDecimals:true,
                                                                                                    allowNegative:false
                                                                                                }
                                                            								)
														},
                                                        {
															header:'Situaci&oacute;n',
															width:90,
															sortable:true,
															dataIndex:'status',
                                                            editor:cmbSituacion,
                                                             renderer:function(val)
                                                            		{
                                                                    	var pos=existeValorMatriz(arrStatus,val,0);
                                                                        if(pos==-1)
                                                                        	return '';
                                                                        return arrStatus[pos][1];
                                                                    }
														},
                                                        {
															header:'Vacante?',
															width:80,
															sortable:true,
															dataIndex:'ocupado'
														}
                                                        
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridTab',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            x:5,
                                                            cm: cModelo,
                                                            height:310,
                                                            width:860,
                                                            sm:chkRow,
                                                            plugins:[editorFila],
                                                            tbar:	[
                                                            			{
                                                                        	id:'btnAgregarTab',
                                                                            text:'Agregar tabulaci&oacute;n',
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                                    {
                                                                                       var r=new regTabulacion	(
                                                                                       								{
                                                                                                                        idTabulacion:'-1',
                                                                                                                        codTabulacion:'',
                                                                                                                        idZona:'',
                                                                                                                        salarioMin:0,
                                                                                                                        salarioMax:0,
                                                                                                                        status:'1',
                                                                                                                        ocupado:'Si',
                                                                                                                        tipoPuesto:'1'
                                                                                                                	}
                                                                                                            	);
                                                                                        editorFila.stopEditing();
                                                                                    	tblGrid.getStore().add(r);
                                                                                        nuevoReg=true;
                                                                                        editorFila.startEditing(tblGrid.getStore().getCount()-1);
                                                                                    }
                                                                        },
                                                                        
                                                                        {
                                                                            id:'btnEliminarTab',
                                                                            text:'Remover tabulaci&oacute;n',
                                                                            icon:'../images/cancel_round.png',
                                                                            cls:'x-btn-text-icon',	
                                                                            handler:function()
                                                                                    {
                                                                                    	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                            Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','Primero debe seleccionar los elementos a remover');
                                                                                            return;
                                                                                        }
                                                                                        
                                                                                        var listado=obtenerListadoArregloFilas(filas,'idTabulacion');
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                            if(btn=='yes')
                                                                                            {
                                                                                                function funcAjax()
                                                                                                {
                                                                                                    var resp=peticion_http.responseText;
                                                                                                    arrResp=resp.split('|');
                                                                                                    if((arrResp[0]=='1')||(arrResp[0]==1))
                                                                                                    {
                                                                                                    	filaPuesto.set('numPuestos',parseInt(filaPuesto.get('numPuestos'))-filas.length);
                                                                                                        tblGrid.getStore().remove(filas);
                                                                                                    }
                                                                                                    else
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=38&listado='+listado,true);
                                                                                            }
                                                                                        }
                                                                                        Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>','&iquest;Est&aacute; seguro de querer remover los elementos seleccionados?',resp)
                                                                                        
                                                                                    }
                                                                        }
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}

function funcGridBeforeEdit(e)
{
	/*if((!pEdicion)||(e.record.get('situacion')!=etapaActual))
		e.cancel=true;*/
}

function funcEditorValida(rowEditor,obj,registro,nFila)
{	
	if(obj.codTabulacion=='')
    {
    	function resp()
        {
        	Ext.getCmp('txtCodTab').focus();
        }
    	msgBox('Debe ingresar el c&oacute;digo de la tabulaci&oacute;n',resp);
        return false;
    }
    
    if(obj.idZona=='')
    {
    	function respP()
        {
        	Ext.getCmp('cmbZonas').focus();
        }
    	msgBox('Debe ingresar la zona del puesto',respP);
        return false;
    }
	
    if(obj.salarioMin=='')
    {
    	function respOG()
        {
        	Ext.getCmp('txtSalMinimo').focus(true);
        }
    	msgBox('Debe ingresar el salario m&iacute;nimo del puesto',respOG);
        return false;
    }
    
    if(obj.salarioMax=='')
    {
    	function respPeriodo()
        {
        	Ext.getCmp('txtSalMaximo').focus(true);
        }
    	msgBox('Debe ingresar el salario m&aacute;ximo del puesto',respPeriodo);
        return false;
    }
    
    if(parseFloat(obj.salarioMin)>parseFloat(obj.salarioMax))
    {
    	function respSal()
        {
        	Ext.getCmp('txtSalMinimo').focus(true);
        }
    	msgBox('El salario m&iacute;nimo no puede ser mayor que el salario m&aacute;ximo',respSal);
        return false;
    }
   
   	function funcAjax1()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var cadObj='{"tipoPuesto":"'+obj.tipoPuesto+'","idPuesto":"'+filaPuesto.get('idPuesto')+'","idTabulacion":"'+registro.get('idTabulacion')+'","codTabulacion":"'+cv(obj.codTabulacion)+'","idZona":"'+obj.idZona+'","salarioMin":"'+obj.salarioMin+'","salarioMax":"'+obj.salarioMax+'","situacion":"'+obj.status+'"}';
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                	var arrPuestos=eval(arrResp[3]);
                    Ext.getCmp('gridPuesto').getStore('').loadData(arrPuestos);
                    filaPuesto.set('numPuestos',parseInt(arrResp[2]));
                    registro.set('idTabulacion',arrResp[1]);
                    Ext.getCmp('btnAgregarTab').enable();
                    Ext.getCmp('btnEliminarTab').enable();
                    nuevoReg=false;
                    Ext.getCmp('gridTab').getStore().save();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                    Ext.getCmp('btnAgregarTab').enable();
                    Ext.getCmp('btnEliminarTab').enable();
                    if(registro.get('idTabulacion')=='-1')
                        Ext.getCmp('gridTab').getStore().removeAt(Ext.getCmp('gridTab').getStore().getCount()-1);
                    else
                        Ext.getCmp('gridTab').getStore().rejectChanges();
                    nuevoReg=false;
                    return false;
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=36&obj='+cadObj,true);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax1, 'POST','funcion=39&idTabulacion='+registro.get('idTabulacion')+'&codTabulacion='+cv(obj.codTabulacion),true);

   
   
        
}

function funcEditorFilaBeforeEdit(ctrl,fila)
{
	var tblGrid=Ext.getCmp('gridTab');
    var registro=tblGrid.getStore().getAt(fila);
	/*if((!pEdicion)||(registro.get('situacion')!=etapaActual))
    {
        return false;
    }*/
	Ext.getCmp('btnAgregarTab').disable();
    Ext.getCmp('btnEliminarTab').disable();

}

function funcEditorCancelEdit(rowEdit,obj,registro,nFila)
{
	if(nuevoReg)
    {
    	var gridPOA=Ext.getCmp('gridTab');
        gridPOA.getStore().removeAt(gridPOA.getStore().getCount()-1);
    }
   	Ext.getCmp('btnAgregarTab').enable();
    Ext.getCmp('btnEliminarTab').enable();

    nuevoReg=false;
}


function mostrarAsignacionPuestos()
{
	var gridPuestosDepto=crearGridPuestoDepto();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridPuestosDepto

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Puestos asignados al &aacute;rea/departamento: '+nodoSel.text,
										width: 900,
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
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	llenarPuestosAsigUnidad(ventanaAM,gridPuestosDepto);
}

var arrEdoPuesto=[['0','Vacante'],['1','Ocupado']];

function crearGridPuestoDepto()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idUnidadVSPuesto'},
                                                                    {name: 'idTabulacion'},
                                                                    {name: 'codTabulacion'},
                                                                    {name: 'nomPuesto'},
                                                                    {name: 'zona'},
                                                                    {name: 'status'},
                                                                    {name: 'usuarioOcupa'},
                                                                    {name: 'tipoPuesto'}
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
                                                        	header:'Clave puesto',
															width:120,
															sortable:true,
															dataIndex:'codTabulacion'
                                                        },
														{
															header:'Puesto',
															width:300,
															sortable:true,
															dataIndex:'nomPuesto'
														},
                                                        {
                                                        	header:'Tipo puesto',
															width:110,
															sortable:true,
															dataIndex:'tipoPuesto',
                                                            renderer:function(val)
                                                            		{
                                                                    	var pos=existeValorMatriz(arrTipoPuesto,val,0);
                                                                        if(pos==-1)
                                                                        	return '';
                                                                        return arrTipoPuesto[pos][1];
                                                                    }
                                                        },
                                                        {
                                                        	header:'Zona',
															width:110,
															sortable:true,
															dataIndex:'zona'
                                                        },
                                                        
														{
															header:'Situaci&oacute;n',
															width:90,
															sortable:true,
															dataIndex:'status',
                                                            renderer:function(val)
                                                            		{
                                                                    	var pos=existeValorMatriz(arrEdoPuesto,val,0);
                                                                        if(pos==-1)
                                                                        	return '';
                                                                        return arrEdoPuesto[pos][1];
                                                                    }
														},
                                                        {
															header:'Puesto ocupado por:',
															width:220,
															sortable:true,
															dataIndex:'usuarioOcupa',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val=='')
                                                                        	return 'Vacante'
                                                                        return val;
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridTabPuestoDepto',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:10,
                                                            x:1,
                                                            cm: cModelo,
                                                            height:350,
                                                            width:870,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	id:'btnAgregarTabDepto',
                                                                            text:'Asignar puesto',
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                                    {
                                                                                       mostrarVentanaPuestos();
                                                                                    }
                                                                        },
                                                                        
                                                                        {
                                                                            id:'btnEliminarTabDepto',
                                                                            text:'Remover asignaci&oacute;n de puesto',
                                                                            icon:'../images/cancel_round.png',
                                                                            cls:'x-btn-text-icon',	
                                                                            handler:function()
                                                                                    {
                                                                                    	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar los puestos a remover');
                                                                                        	return;
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                            if(btn=='yes')
                                                                                            {
                                                                                                var listado=obtenerListadoArregloFilas(filas,'idUnidadVSPuesto');
                                                                                                
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
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=44&listado='+listado,true);

                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover los puestos seleccionados?',resp)
                                                                                    }
                                                                        }
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}

function mostrarVentanaPuestos()
{
	var arrPuestos=[];
	var cmbPuestos=crearComboExt('cmbPuestos',arrPuestos,80,5,480);
    var gridPuestoDisp=crearGridPuestoDisp();
    cmbPuestos.on('select',funcPuestoChange);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Puesto:'
                                                        },
                                                        cmbPuestos,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'N&uacute;m. total de plazas:',
                                                            xtype:'label'
                                                        },
                                                        {
                                                        	x:150,
                                                            y:40,
                                                            html:'',
                                                            xtype:'label',
                                                            id:'lblNumPlazas'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'N&uacute;m. plazas disponibles:',
                                                            xtype:'label'
                                                        },
                                                        {
                                                        	x:150,
                                                            y:70,
                                                            html:'',
                                                            xtype:'label',
                                                            id:'lblNumPlazasDisp'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'N&uacute;m. plazas a asignar:',
                                                            xtype:'label'
                                                        },
                                                        {
                                                        	x:150,
                                                            y:100,
                                                            hidden:true,
                                                            html:'<span  style="color:#F00">No existen plazas disponibles para asignar</span>',
                                                            xtype:'label',
                                                            id:'lblNoPlazas'
                                                        },
                                                        {
                                                        	x:150,
                                                            y:95,
                                                            xtype:'numberfield',
                                                            allowNegative:false,
                                                            allowDecimals:false,
                                                            id:'txtNumPlazas',
                                                            width:60,
                                                            value:0
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vAsignaPuesto',
										title: 'Asignar puesto',
										width: 600,
										height:110,
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

                                                                        if(cmbPuestos.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbPuestos.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el puesto a asignar',resp);
                                                                            return;
                                                                        }
                                                                        var numPuesto=gEx('txtNumPlazas').getValue();
                                                                        if(numPuesto=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	gEx('txtNumPlazas').focus();
                                                                            }
                                                                            msgBox('Debe indicar el n&uacute;mero de plazas a asignar',resp);
                                                                            return;
                                                                        }
                                                                        var numPlazasDisp=parseInt(ventanaAM.plazasDisp);
                                                                        
                                                                        
                                                                        if(numPuesto>numPlazasDisp)
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	gEx('txtNumPlazas').focus();
                                                                            }
                                                                            msgBox('El n&uacute;mero de plazas a asignar no puede ser mayor que el n&uacute;mero de plazas disponibles',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                Ext.getCmp('gridTabPuestoDepto').getStore().loadData(eval(arrResp[1]));
                                                                                ventanaAM.close();
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=42&numPuesto='+numPuesto+'&idPuesto='+cmbPuestos.getValue()+'&unidad='+nodoSel.attributes.codigoU,true);

                                                                        
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
	llenarPuestosDisp(ventanaAM,cmbPuestos);
}

function llenarPuestosDisp(ventanaAM,cmbPuestos)
{
	var codigoUnidad=nodoSel.attributes.codigoInstitucion;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	cmbPuestos.getStore().loadData(eval(arrResp[1]));
            ventanaAM.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=40&codigoUnidad='+codigoUnidad,true);
}

function funcPuestoChange(combo,registro)
{
	var codigoUnidad=nodoSel.attributes.codigoF;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	gEx('lblNumPlazas').setText(arrResp[1]);
            var plazasDisp=parseInt(arrResp[1])-parseInt(arrResp[2]);
            gEx('vAsignaPuesto').plazasDisp=plazasDisp;
            gEx('lblNumPlazasDisp').setText(plazasDisp);
            if(plazasDisp==0)
            {
            	gEx('lblNoPlazas').show();
                gEx('txtNumPlazas').hide();
                
            }
            else
            {
            	gEx('lblNoPlazas').hide();
                gEx('txtNumPlazas').show();
            }
            gEx('vAsignaPuesto').setHeight(220);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=41&idPuesto='+registro.get('id'),true);
}

function crearGridPuestoDisp()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                    			{name:'idTabulacion'},
                                                                {name: 'codTab'},
                                                                {name: 'zona'},
                                                                {name: 'tipoPuesto'}
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
															header:'C&oacute;digo tabulaci&oacute;n',
															width:190,
															sortable:true,
															dataIndex:'codTab'
														},
                                                        {
															header:'Tipo puesto',
															width:120,
															sortable:true,
															dataIndex:'tipoPuesto',
                                                            renderer:function(val)
                                                            		{
                                                                    	var pos=existeValorMatriz(arrTipoPuesto,val,0);
                                                                        if(pos==-1)
                                                                        	return '';
                                                                        return arrTipoPuesto[pos][1];
                                                                    }
														}
                                                        ,
														{
															header:'Zona',
															width:170,
															sortable:true,
															dataIndex:'zona'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridPuestosDisp',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:570,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;
}

function llenarPuestosAsigUnidad(ventanaAM,grid)
{
	var codigoUnidad=nodoSel.attributes.codigoU;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	grid.getStore().loadData(eval(arrResp[1]));
            ventanaAM.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=43&unidad='+codigoUnidad,true);
}

function mostrarVentanaResponsablesUnidad()
{

	var raiz=new  Ext.tree.AsyncTreeNode	(
                                                      {
                                                          id:'-1',
                                                          text:'Raiz',
                                                          draggable:false,
                                                          expanded :true
                                                      }
                                              	)
                                        
    var cargadorArbol=new Ext.tree.TreeLoader(
                                                    {
                                                        baseParams:{
                                                                        funcion:'66',
                                                                        codigoUnidad:nodoSel.attributes.codigoInstitucion
                                                                    },
                                                        dataUrl:'../paginasFunciones/funcionesOrganigrama.php'
                                                        
                                                    }	


                                             )
	var arbolResponsable = new Ext.ux.tree.TreeGrid	(
                                                            {
                                                                id:'tResponsable',
                                                                height:335,
                                                                width:570,
                                                                useArrows:true,
                                                                autoScroll:true,
                                                                animate:true,
                                                                enableDD:true,
                                                                root:raiz,
                                                                loader: cargadorArbol,
                                                                rootVisible:false,
                                                                draggable:false,
                                                                tbar:	[
                                                                			{
                                                                            	id:'btnAddResp',
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar Responsable',
                                                                                disabled:true,
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaAgregarResponsable();
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                            	id:'btnDelResp',
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                text:'Remover Responsable',
                                                                                handler:function()
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
                                                                                                            nodoResponsable.remove();
                                                                                                            nodoResponsable=null;
                                                                                                            gEx('btnAddResp').disable();
																										    gEx('btnDelResp').disable();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=67&idResponsable='+nodoResponsable.id,true);

                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover al responsable seleccionado?',resp);
                                                                                            return;
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                		],
                                                                columns:[
                                                                			
                                                                            {
                                                                                header:'Rol/Responsable',
                                                                                width:500,
                                                                                dataIndex:'text'
                                                                            }
                                                                         ]

                                                               
                                                            }
                                                    );
		
        
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														arbolResponsable
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Administraci&oacute;n de responsables de unidad',
										width: 595,
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
    arbolResponsable.on('click',nodoRespClick);
    arbolResponsable.expandAll();
}

function nodoRespClick(nodo)
{
	
	nodoResponsable=nodo;
    gEx('btnAddResp').disable();
    gEx('btnDelResp').disable();
    switch(nodo.attributes.tipoNodo)
    {
    	case '0':
        	gEx('btnAddResp').enable();
        break;
        case '1':
        	gEx('btnDelResp').enable();
        break;
    }
}

function mostrarVentanaAgregarResponsable()
{
	idUsuario=-1;
	var oConf=	{
    					idCombo:'cmbCliente',
                        anchoCombo:380,
                        posX:130,
                        posY:5,
                        campoDesplegar:'Nombre',
                        campoID:'idUsuario',
                        funcionBusqueda:6,
                        raiz:'personas',
                        nRegistros:'num',
                        paginaProcesamiento:'../Usuarios/procesarbUsuario.php',
                        confVista:	'<tpl for="."><div class="search-item"><table><tr><td width="380">{Paterno}&nbsp;{Materno}&nbsp;{Nom}&nbsp;<br>{Status}<br>---<br></td><td width="50"><img height="40" width="33" src="../Usuarios/verFoto.php?Id={idUsuario}"/></td></tr></table></div></tpl>',
                        campos:	[
                                    {name:'idUsuario'},
                                    {name:'Paterno'},
                                    {name:'Materno'},
                                    {name:'Nombre'},
                                    {name:'Nom'},
                                    {name: 'Status'}
                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	dSet.baseParams.criterio=combo.getRawValue();
                                        dSet.baseParams.campoBusqueda=5;
                                        dSet.baseParams.listRoles="'-1000_0'";
                                        <?php
                                        if(existeRol("'-3000_0'"))
										{
	                                        echo "dSet.baseParams.adscripcion='".$_SESSION["codigoInstitucion"]."';";
											echo "dSet.baseParams.oDepto='1';";
											echo "dSet.baseParams.oInstitucion='1';";
										}
										?>
                                    	idUsuario=-1;
                                        
                                        
                                    },
                      	funcElementoSel:function(combo,registro)
                    				{
                                    	idUsuario=registro.get('idUsuario')
                                        
                                    	
                                    }  
    				};

    
	var cmbPersonal=crearComboExtAutocompletar(oConf);

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Usuario a asignar:'
                                                        },
                                                        cmbPersonal,
                                                        {
                                                        	xtype:'label',
                                                            x:185,
                                                            y:40,
                                                            html:'Si no encuentra al usuario que desea asignar como responsable, reg&iacute;strelo <a href="javascript:registrarUsuario()"><span class="letraRoja">AQU&Iacute;</span></a>'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignar responsable',
										width: 620,
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
                                                                	gEx('cmbCliente').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	if(idUsuario==-1)
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	gEx('cmbCliente').focus();
                                                                            }
                                                                            msgBox('Debe selecceionar el usuarios que desea asignar como responsable',resp);
                                                                            return;
                                                                        }
                                                                        var cadObj='{"idUsuario":"'+idUsuario+'","rol":"'+nodoResponsable.id+'","codigoUnidad":"'+nodoSel.attributes.codigoInstitucion+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('tResponsable').getRootNode().reload();
                                                                                gEx('tResponsable').expandAll();
                                                                               	ventanaAM.close(); 
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=68&cadObj='+cadObj,true);
                                                                        
																		
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

function registrarUsuario()
{
	var objConf={};
    objConf.url='../Usuarios/altaUsuario.php';
    objConf.titulo='Alta de Usuario';
    objConf.ancho=960;
    objConf.alto=380;   
    var codigoInstitucion;
    var codigoUnidad;
    if(nodoSel.attributes.adscribeInstitucion=='1')
    {
    	codigoInstitucion=nodoSel.attributes.codigoInstitucion;
        codigoUnidad=nodoSel.attributes.codigoInstitucion;
    }
    else
    {
    	codigoUnidad=nodoSel.attributes.codigoInstitucion;
        var nodoInst=buscarAdscripcionInstitucion(nodoSel.parentNode);
        codigoInstitucion=nodoInst.attributes.codigoInstitucion;
        
    }
    
    
    objConf.params=[['cPagina','sFrm=true'],['idUsuario','-1'],['titulo','Alta de Usuario'],['ocultarDomicilio','1'],['ocultarLugarNacimiento','1'],
    				['ocultarFechaNacimiento','1'],['ocultarPrefijo','1'],['ocultarCurp','1'],['ocultarIssste','1'],['ocultarRFC','1'],['generarPassword','1'],
                    ['codigoInstitucion',codigoInstitucion],['codigoUnidad',codigoUnidad],['funcionScript',bE('window.parent.asignarUsuario(@idUsuario,"@nomUsuario");')]];
    window.parent.abrirVentanaFancy(objConf);	
}

function buscarAdscripcionInstitucion(nodo)
{
	if(nodo.attributes.adscribeInstitucion=='1')
    	return nodo;
    return buscarAdscripcionInstitucion(nodo.parentNode);
}

function asignarUsuario(iU,nom)
{
	var cmbCliente=gEx('cmbCliente');
    cmbCliente.setRawValue(nom);	
    idUsuario=iU;
    cerrarVentanaFancy();
    
}

function recargarContenedorCentral()
{

}

function recargarOrganigrama(codigoUnidad,idOrganigrama)
{
	gEx('tOrganigrama').getRootNode().reload();
    gEx('tOrganigrama').expandAll(); 
	idNodoSeleccionado=idOrganigrama;

}


function mostrarVentanaAgregarUnidad(unidadPadre,accion)
{
	
    var cmbTipoUnidadAgrega=null;
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Seleccione el tipo de unidad que desea agregar:'
                                                        },
                                                        {
                                                            x:425,
                                                            y:15,
                                                            html:'<div id="divTipoUnidad"></div>'
                                                        }
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de Tipo de Unidad',
										width: 780,
										height:190,
                                        cls:'msgHistorialSIUGJ',
                                        id:'vAgregarUnidadHija',
										layout: 'fit',
                                        closable:false,
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
                                                                	cmbTipoUnidadAgrega=crearComboExt('cmbTipoUnidadAgrega',arrCategorias,0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divTipoUnidad'});
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
                                                                    
                                                                    	if(cmbTipoUnidadAgrega.getValue()=='')
                                                                        {
                                                                        	function respAux()
                                                                            {
                                                                            	cmbTipoUnidadAgrega.focus();
                                                                            	
                                                                            }
                                                                            msgBox('Seleccione el tipo de unidad que desea agregar',respAux);
                                                                            return;
                                                                        }
                                                                    	
                                                                        var pos=existeValorMatriz(arrCategorias,cmbTipoUnidadAgrega.getValue());
                                                                        var cadObjConf=arrCategorias[pos][2];
                                                                        if(cadObjConf!='')
                                                                        {
                                                                        	var objConf=eval('['+cadObjConf+']')[0];
                                                                            
                                                                            function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                    var obj={};    
                                                                                    obj.ancho='100%';
                                                                                    obj.alto='100%';
                                                                                    obj.url='../modeloPerfiles/vistaDTDv3.php';
                                                                                    obj.modal=true;
                                                                                    obj.params=[['tipoUnidad',cmbTipoUnidadAgrega.getValue()],['unidadPadre',unidadPadre],['idFormulario',arrResp[4]],['idRegistro',arrResp[1]],['idReferencia',-1],['dComp',arrResp[2]],['actor',arrResp[3]]];
                                                                                    window.parent.abrirVentanaFancy(obj);
                                                                                    ventanaAM.close();
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=352&rol='+objConf.rolIngreso+'&idProceso='+objConf.idProceso+
                                                                            			'&idRegistro=-1',true);
                                                                            
                                                                            
                                                                            
                                                                            
                                                                        }
                                                                        else
                                                                        {
																			agregarUnidad(nodoSel.attributes.codigoU,1,cmbTipoUnidadAgrega.getValue());
                                                                            ventanaAM.close();
																		}
                                                                    }
														}
													]
									}
								);
	ventanaAM.show();	
    
    
}