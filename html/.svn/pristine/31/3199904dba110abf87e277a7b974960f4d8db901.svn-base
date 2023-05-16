<?php session_start();
	include("configurarIdiomaJS.php");
	$idFormulario=$_GET["idFormulario"];
	$idReferencia=$_GET["idReferencia"];
	$idEstado=$_GET["idEstado"];
	$consulta="select idEtapa,idProceso from 900_formularios where idFormulario=".$idFormulario;
	$filaResp=$con->obtenerPrimeraFila($consulta);
	$idProceso=$filaResp[1];
	$idEtapa=$filaResp[0];
	$ocultarVerF="true";
	$ocultarNuevo="true";
	$ocultarModificar="true";
	$ocultarEliminar="true";
	$ocultarAdminUnidades="true";
	
	$consulta="select tipoFormulario,mostrarTableroControl,formularioBase from 900_formularios where idFormulario=".$idFormulario;
	$filaForm=$con->obtenerPrimeraFila($consulta);
	$tipoFormulario=$filaForm[0];
	$mostrarTC=$filaForm[1];
	$formularioBase=$filaForm[2];
	
	if($mostrarTC=="1")
		$mostrarTableroControl="false";
	if($tipoFormulario=="1")
		$ocultarAdminUnidades="false";
	$consulta="select tp.ignoraPermisos from 4001_procesos p,921_tiposProceso tp where tp.idTipoProceso=p.idTipoProceso and p.idProceso=".$idProceso;
	$ignoraPermisos=$con->obtenerValor($consulta);
	
	if($ignoraPermisos=="0")
	{
		$consulta="select permisos from 4002_rolesVSEtapas where etapa=".$idEtapa." and  proceso=".$idProceso." and idRol in(".$_SESSION["idRol"].")";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$permisos=$fila[0];
			if(!(strpos($permisos,"C")===false))
				$ocultarVerF="false";
			if(!(strpos($permisos,"A")===false))
				$ocultarNuevo="false";
			if(!(strpos($permisos,"M")===false))
				$ocultarModificar="false";
			if(!(strpos($permisos,"E")===false))
				$ocultarEliminar="false";
		}
	}
	else
	{
		$ocultarVerF="false";
		$ocultarNuevo="false";
		$ocultarModificar="false";
		$ocultarEliminar="false";
	}
	$ocultarTableroControl="true";
	
	$consulta="select f.idConfGrid,campoAgrupacion,btnAgregarLabel,btnModificarLabel,btnEliminarLabel,btnVerLabel,botonesOcultar from 909_configuracionTablaFormularios f where f.idFormulario=".$idFormulario;

	$filaConfFrm=$con->obtenerPrimeraFila($consulta);
	$idConfiguracion=$filaConfFrm[0];
	$campoAgrupacion=$filaConfFrm[1];
	
	
	if(strpos($filaConfFrm[6],"C")!==false)
	{
		$ocultarVerF=true;	
	}
	
	if(strpos($filaConfFrm[6],"A")!==false)
	{
		$ocultarNuevo=true;	
	}
	if(strpos($filaConfFrm[6],"M")!==false)
	{
		$ocultarModificar=true;	
	}
	if(strpos($filaConfFrm[6],"E")!==false)
	{
		$ocultarEliminar=true;	
	}
	
	$btnAgregarLabel="Agregar registro";
	if($filaConfFrm[2]!="")
		$btnAgregarLabel=$filaConfFrm[2];
	$btnModificarLabel="Modificar registro";

	if($filaConfFrm[3]!="")
		$btnModificarLabel=$filaConfFrm[3];
	$btnEliminarLabel="Eliminar registro";
	if($filaConfFrm[4]!="")
		$btnEliminarLabel=$filaConfFrm[4];
	$btnVerLabel="Ver ficha";
	if($filaConfFrm[5]!="")
		$btnVerLabel=$filaConfFrm[5];
	
	if($idConfiguracion=="")
		$idConfiguracion="-1";
	$queryTabla="select nombreTabla from 900_formularios where idFormulario=".$idFormulario;
	$nomTabla=$con->obtenerValor($queryTabla);
	$filtroCampos="";
	$consulta="	select cg.titulo,tamanoColumna as 'tamColumna',case cg.alineacionValores when 1 then 'left' when 2 then 'right' when 3 then 'center' 
				when 4 then 'justify' end as alineacion,cg.idElementoFormulario,
				if((select distinct(tipoElemento) from 901_elementosFormulario where 
				idGrupoElemento=cg.idElementoFormulario) is null,cg.idElementoFormulario,(select distinct(tipoElemento) 
				from 901_elementosFormulario where idGrupoElemento=cg.idElementoFormulario)) as tipoElemento,

				if((select distinct(nombreCampo) from 901_elementosFormulario where 
				idGrupoElemento=cg.idElementoFormulario) is null,
				 case cg.idElementoFormulario
					 when '-10' then 'fechaCreacion'
					 when '-11' then 'responsableCreacion'
					 when '-12' then 'fechaModificacion'
					 when '-13' then 'responsableModificacion'
					 when '-14' then 'unidadUsuarioRegistro'
					 when '-15' then 'institucionUsuarioRegistro'
					 when '-16' then 'dtefechaSolicitud'
					 when '-17' then 'tmeHoraInicio'
					 when '-18' then 'tmeHoraFin'
					 when '-19' then 'dteFechaAsignada'
					 when '-20' then 'tmeHoraInicialAsignada'
					 when '-21' then 'tmeHoraFinalAsignada'
					 when '-22' then 'unidadReservada'
					 when '-23' then 'tmeHoraSalida'
					 when '-24' then 'idEstado'
   				     when '-25' then 'codigoRegistro'
					 end
				   ,(select distinct(nombreCampo) 
				from 901_elementosFormulario where idGrupoElemento=cg.idElementoFormulario)) as nombreCampo

				from 907_camposGrid cg where 
				cg.idIdioma=".$_SESSION["leng"]." and cg.idConfGrid=".$idConfiguracion." order by cg.idGrupoCampo";
	$res=$con->obtenerFilas($consulta);
	
	$campos="{name: 'idRegistro' }";
	$columnModel='new  Ext.grid.RowNumberer()';
	$ct=1;
	while($filas=mysql_fetch_row($res))
	{
		$conf="";	
		if(($filas[4]==8)||($filas[4]==-10)||($filas[4]==-12)||($filas[4]==-16)||($filas[4]==-19))
			$conf=",renderer: formatearFecha";
		if($filas[4]==12)
			$conf=",renderer: formatearArchivo";
		if(($filas[4]==-17)||($filas[4]==-18)||($filas[4]==-20)||($filas[4]==-21)||($filas[4]==-23))
			$conf=",renderer: formatearTiempo";
		if($filas[4]==24)
			$conf=",css:'text-align:right !important;',renderer: 'usMoney'";
		$campos.=",{name: '".$filas[5]."' }";
		$tipoFiltro='string';
		switch($filas[4])
		{
			
			case 3:
			case 6:
			case 7:
			case 24:
			case 15:
				$tipoFiltro='numeric';
				if($filtroCampos=="")
					$filtroCampos="{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."'}";
				else
					$filtroCampos.=",{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."'}";
			break;
			case 8:			
			case -10:
			case -12:
			case -16:
			case -19:
				$tipoFiltro='date';
				if($filtroCampos=="")
					$filtroCampos="{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."'}";
				else
					$filtroCampos.=",{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."'}";
			break;
			case 2:
			case 4:
			case 14:
			case 16:
				$tipoFiltro='list';
				
				if(($filas[4]==2)||($filas[4]==14))
				{
					$queryOpt="select valor as id,contenido as text from 902_opcionesFormulario where idIdioma=".$_SESSION["leng"]." and idGrupoElemento=".$filas[3];
					$arrOpt=$con->obtenerFilasJSON($queryOpt);
				}
				else
				{
					$queryConfOpt="select * from 904_configuracionElemFormulario where idElemFormulario=".$filas[3];
					$fConf=$con->obtenerPrimeraFila($queryConfOpt);
					$condWhere="";
					if($fConf[12]=="1")
					{
						$condWhere=" where";
						$queryConfOpt="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$filas[3];
						$resFilasConf=$con->obtenerFilas($queryConfOpt);
						while($filasConf=mysql_fetch_row($resFilasConf))
						{
							$condWhere.=" ".$filasConf[0];
						}
						
					}
					if(strpos($fConf[2],"[")===false)
					{
						$queryOpt="select ".$fConf[4]." as id,".$fConf[3]." as text from ".$fConf[2].$condWhere;					
						
						$arrOpt=$con->obtenerFilasJSON($queryOpt);
					}
					else
						$arrOpt="[]";
				}
				if($filtroCampos=="")
					$filtroCampos="{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',options:".$arrOpt.",phpMode:true}";
				else
					$filtroCampos.=",{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',options:".$arrOpt.",phpMode:true}";
				
			break;
			case -13:
			case -11:
			case -25:
			case 5:
			case 9:
			case 10:
			case 11:
			case 15:
			
				if($filtroCampos=="")
					$filtroCampos="{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."'}";
				else
					$filtroCampos.=",{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."'}";
			break;
			case -14:
				$tipoFiltro='list';
				$queryOpt="select distinct(o.codigoUnidad),o.unidad from 817_organigrama o,".$nomTabla." t  where o.codigoUnidad=t.codigoUnidad";					
				$arrOpt=$con->obtenerFilasArreglo($queryOpt);
				if($filtroCampos=="")
					$filtroCampos="{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',options:".utf8_decode($arrOpt).",phpMode:true}";
				else
					$filtroCampos.=",{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',options:".utf8_decode($arrOpt).",phpMode:true}";
			break;
			case -15:
			case -22:
				$tipoFiltro='list';
				$queryOpt="select distinct(o.codigoUnidad),o.unidad from 817_organigrama o,".$nomTabla." t  where o.codigoUnidad=t.codigoInstitucion";					
				$arrOpt=$con->obtenerFilasArreglo($queryOpt);
				if($filtroCampos=="")
					$filtroCampos="{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',options:".utf8_decode($arrOpt).",phpMode:true}";
				else
					$filtroCampos.=",{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',options:".utf8_decode($arrOpt).",phpMode:true}";
			break;
			case -24:
				$tipoFiltro='list';
				$queryOpt="select numEtapa,nombreEtapa from 4037_etapas  where idProceso=".$idProceso;					
				$arrOpt=$con->obtenerFilasArreglo($queryOpt);
				if($filtroCampos=="")
					$filtroCampos="{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',options:".utf8_decode($arrOpt).",phpMode:true}";
				else
					$filtroCampos.=",{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',options:".utf8_decode($arrOpt).",phpMode:true}";
			break;
		}
		
		if($campoAgrupacion==$filas[5])
		{
			$columnModel.="	,{
							header:'".uEJ($filas[0])."',
							width:".$filas[1].",
							sortable:true,
							hidden:true,
							align:'".$filas[2]."',
							dataIndex:'".$filas[5]."'".$conf."
						}";
		
		}
		else
		{
			$columnModel.="	,{
							header:'".uEJ($filas[0])."',
							width:".$filas[1].",
							sortable:true,
							align:'".$filas[2]."',
							dataIndex:'".$filas[5]."'".$conf."
							
						}";
		
		}
		
		$ct++;
	}
	
	$consulta="select campoOrden,direccionOrden,numRegPag from 909_configuracionTablaFormularios where idFormulario=".$idFormulario;
	$fila=$con->obtenerPrimeraFila($consulta);
	$consulta="select * from 910_graficasGantt where idFormulario=".$idFormulario;
	$filaGrafica=$con->obtenerPrimeraFila($consulta);
	if($filaGrafica)
	{
		$btnGantt=",{
					  text:'<img src=\"../images/gantt.png\" height=\"16\" width=\"16\" >&nbsp;".$etj["lblGantt"]."',
					  handler:function()
							  {
								  enviarGantt();
							  }
				  }";
	}
	else
	{
		$btnGantt="";
	}
	
	$query="select idTipoProceso from 4001_procesos where idProceso=".$idProceso;
	$tipoProceso=$con->obtenerValor($query);
	$pagNuevo="../modeloPerfiles/registroFormularioV2.php";
	$pagModificar="../modeloPerfiles/registroFormularioV2.php";
	$pagVer="../modeloPerfiles/verFichaFormularioV2.php";
	
	if($formularioBase=="1")
	{
		$query="select pagVista,accion from 936_vistasProcesos where tipoProceso=".$tipoProceso;
		$resPagAccion=$con->obtenerFilas($query);
		while($filaAccion=mysql_fetch_row($resPagAccion))
		{
			switch($filaAccion[1])
			{
				case "0"://Nuevo
					$pagNuevo=$filaAccion[0];
				break;
				case "1"://Modificar
					$pagModificar=$filaAccion[0];
				break;
				case "2"://Consultar/Ver
					$pagVer=$filaAccion[0];
				break;
			}
		}
	}
	
		
	
?>


var ocultarNuevo;
var ocultarModificar;
var ocultarEliminar;
var ocultarTableroC;
var ocultarVerF;
var ocultarAdminUnidades;
var idConfig=<?php echo $idConfiguracion;?>

var camposJava=new Array( <?php echo $campos; ?>);
var columnasJava=new Array(<?php echo $columnModel; ?>);

Ext.onReady(inicializar);

function enviarGantt()
{
	var formulario=	gE('frmEnvio');
    formulario.action='../graficos/gantt.php';
    formulario.submit();
}

function formatearTiempo(val)
{
	if(val!="")
    {
		var arrValor=val.split(':');
    	return arrValor[0]+':'+arrValor[1];
    }
    return '';
}

function formatearFecha(val)
{

	if(val!='')
	{
    	var fecha=Date.parseDate(val,'Y-m-d H:i:s');
    	if(fecha)
        	return fecha.format('d/m/Y H:i:s');
        else
        {
        	fecha=Date.parseDate(val,'Y-m-d');
            if(fecha)
        		return fecha.format('d/m/Y');
        }
    }
	
}

function formatearArchivo(val)
{

	var descArch='N/E';
    if(val!='')
	    descArch='<a href="../paginasFunciones/obtenerArchivos.php?id='+bE(val)+'"><img src="../images/download.png" alt="<?php echo $etj["lblDescargar"]?>" title="<?php echo $etj["lblDescargar"]?>" />&nbsp;&nbsp;<?php echo $etj["lblDescargar"]?></a>';
	
	return descArch;
}

function inicializar()
{
	ocultarVerF=<?php echo $ocultarVerF ?>;
	ocultarNuevo=<?php echo $ocultarNuevo ?>;
	ocultarModificar=<?php echo $ocultarModificar?>;
	ocultarEliminar=<?php echo $ocultarEliminar ?>;
    ocultarAdminUnidades=<?php echo $ocultarAdminUnidades?>;
	ocultarTableroC=<?php echo $ocultarTableroControl ?>;
	var regresarTablero=gE('regresarTablero').value;
    
    var accion=gE('accion').value;
    
    if(accion=='<?php echo base64_encode('ver')?>')
    {
    	ocultarNuevo=true;
        ocultarModificar=true;
        ocultarEliminar=true;
        ocultarAdminUnidades=true;
        ocultarTableroC=true;
    }
    
    if(regresarTablero!='-1')
    	ocultarTableroC=true;
    
	if(gE('tdTblRegistro')!=null)
		crearTablaRegistros();
}

function nuevo()
{	
	gE('frmEnvio').action='<?php echo $pagNuevo?>';
	gE('frmEnvio').submit();
}

function nuevoRegistro()
{
	var idReferencia=gE('idReferencia');
    
    
    if(idReferencia==null)
		var arrDatos=[['idRegistro','-1'],['idFormulario',gE('idFormulario').value],['dComp','<?php echo base64_encode("agregar")?>'],['formularioNormal','1']];
    else
    	var arrDatos=[['idRegistro','-1'],['idFormulario',gE('idFormulario').value],['idReferencia',idReferencia.value],['dComp','<?php echo base64_encode("agregar")?>'],['formularioNormal','1']];
    
    var eJs=gE('eJs');
    if(eJs!=null)
    {
    	var arr=['eJs',eJs.value];
        arrDatos.push(arr);
    }
        
	var soloContenido=gE('soloContenido').value;        
    if(soloContenido=='1')
    {
    	var arreglo=new Array();
        arreglo[0]='cPagina';
        arreglo[1]='sFrm=true';
        arrDatos.push(arreglo);
    }
	enviarFormularioDatos('<?php echo $pagNuevo?>',arrDatos);
} 

function modificar(tblGrid)
{
	var selModel=tblGrid.getSelectionModel();
    var filaSel=selModel.getSelected();
    var idReferencia=gE('idReferencia');
    var idRef='-1';
    if(idReferencia!=null)
    	idRef=gE('idReferencia').value;
    if(filaSel!=null)
    {
    	var arrDatos=[['idReferencia',idRef],['idRegistro',filaSel.get('idRegistro')],['idFormulario',gE('idFormulario').value],['dComp','<?php echo base64_encode("modificar")?>'],['formularioNormal','1']];
        var soloContenido=gE('soloContenido').value;        
        if(soloContenido=='1')
        {
            var arreglo=new Array();
            arreglo[0]='cPagina';
            arreglo[1]='sFrm=true';
            arrDatos.push(arreglo);
        }
		enviarFormularioDatos('<?php echo $pagModificar?>',arrDatos);
    }
    else
    {
        Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["msgDebeSelElem"]?>')
    }
}

function verFicha(tblGrid)
{
	var selModel=tblGrid.getSelectionModel();
    var filaSel=selModel.getSelected();
    if(filaSel!=null)
    {
		var idRef='-1';
        idRef=gE('idReferencia').value;
		var arrDatos=[['idReferencia',idRef],['idRegistro',filaSel.get('idRegistro')],['idFormulario',gE('idFormulario').value],['dComp','<?php echo base64_encode("ver")?>'],['formularioNormal','1']];
        var soloContenido=gE('soloContenido').value;        
        if(soloContenido=='1')
        {
            var arreglo=new Array();
            arreglo[0]='cPagina';
            arreglo[1]='sFrm=true';
            arrDatos.push(arreglo);
        }
        enviarFormularioDatos('<?php echo $pagVer?>',arrDatos);

    }
    else
    {
        Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["msgDebeSelElem"]?>')
    }
}

function eliminar(tblGrid)
{
	var selModel=tblGrid.getSelectionModel();
    var filaSel=selModel.getSelected();
    
    if(filaSel!=null)
    {
		var nombreTabla=gE('nombreTabla').value;
        var nombreCampoId='id_'+nombreTabla;
        
        var obj='{"tabla":"'+nombreTabla+'","nombreCampoId":"'+nombreCampoId+'","idRegistro":"'+filaSel.get('idRegistro')+'"}';
        
        function respPregunta(btn)
        {
            if(btn=='yes')
            {
                function funcResp()
                {
                    var arrResp=peticion_http.responseText.split('|');
                    if(arrResp[0]=='1')
                    {
                       tblGrid.getStore().remove(filaSel);
						if(window.parent.mostrarMenuDTD)	
                        		window.parent.mostrarMenuDTD();
                      /* if(typeof(funcAgregar)!='undefined')
							funcAgregar();    */ 
                        
                    }
                    else
                    {
                         msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);				
                    }
                }
                obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=10&param='+obj,true);
            }
        }
        Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["msgConfirmDel"] ?>',respPregunta);
        
    }
    else
    {
        Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["msgDebeSelElem"]?>')
    }
	
}



function crearTablaRegistros()
{
<?php
	if($campoAgrupacion=="0")
	{
?>
        var dsTablaRegistros = new Ext.data.JsonStore	(
                                                            {
                                                                root: 'registros',
                                                                totalProperty: 'numReg',
                                                                idProperty: 'idRegistro',
                                                                fields: camposJava,
                                                                remoteSort:true,
                                                                proxy: new Ext.data.HttpProxy	(
                                                                                                    {
                                                                                                        url: '../paginasFunciones/funcionesTblFormularios.php'
                                                                                                    }
                                                                                                )
                                                            }
                                                        );
<?php                                                    
	}
    else
    {                                                    	
?>	         
		var lector= new Ext.data.JsonReader	(
        										{
                                                    idProperty: 'idRegistro',
                                                    root: 'registros',
                                                    totalProperty: 'numReg',
                                                    fields: camposJava
                                                }
                                             );
       	var dsTablaRegistros= new Ext.data.GroupingStore(
                                                          {
                                                              reader: lector,
                                                              remoteSort:true,
                                                              groupField:'<?php echo $campoAgrupacion?>',
                                                              proxy: new Ext.data.HttpProxy	(
                                                                                                  {
                                                                                                      url: '../paginasFunciones/funcionesTblFormularios.php'
                                                                                                  }
                                                                                              )
                                                              }
                                                     ) 
<?php
	}
?>                                                        
	var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[ <?php echo $filtroCampos?> ]
                                                    }
                                                );                                                    
                                                    
	dsTablaRegistros.setDefaultSort('<?php echo $fila[0]?>', '<?php echo $fila[1]?>');
                                                    
                                                
                                                   
                                                
                                                
	function cargarDatos(proxy,parametros)
    {
    	proxy.baseParams.idFormulario=<?php echo $idFormulario?>;
        proxy.baseParams.funcion=1;
        proxy.baseParams.idReferencia=<?php echo $idReferencia?>;
        proxy.baseParams.idEstado=<?php echo $idEstado?>;
        proxy.baseParams.idConfiguracion=idConfig;
        
    }                                      
                                                    
	dsTablaRegistros.on('beforeload',cargarDatos);  
                                              
    var modelColumn= new Ext.grid.ColumnModel   	(
												 		columnasJava
													);
	
	var tamPagina =
	<?php 	
		if($fila[2]=='')	
		  echo "1";
	  else
		  echo $fila[2]
	?>
;                      

<?php 

	if($campoAgrupacion=="0")
	{
?>
                                                        
        var paginador=	new Ext.PagingToolbar	(
                                                    {
                                                          pageSize: tamPagina,
                                                          store: dsTablaRegistros,
                                                          displayInfo: true,
                                                          disabled:false
                                                      }
                                                   )                                                    
                                                        
        var gridRegistros=	new Ext.grid.GridPanel	(
                                                      {
                                                          store:dsTablaRegistros,
                                                          frame:false,
                                                          border:true,
                                                          cm: modelColumn,
                                                          height:500,
                                                          width:930,
                                                          renderTo:'tblRegistros',
                                                          trackMouseOver:false,
                                                          loadMask: true,
                                                          stripeRows :true,
                                                          columnLines : true,
                                                          plugins: filters,
                                                          enableColLock: false,
                                                          tbar:	[
                                                                    {
                                                                        text:'<img src="../images/page_white_magnify.png" >&nbsp;<?php echo $btnVerLabel ?>',

                                                                        handler:function()
                                                                                {
                                                                                    verFicha(gridRegistros);
                                                                                },
                                                                        hidden:ocultarVerF
                                                                        
                                                                    },'-',
                                                                    {
                                                                        text:'<img src="../images/add.png" height="16" width="16">&nbsp;<?php echo $btnAgregarLabel ?>',
                                                                        handler:function()
                                                                                {
                                                                                    nuevoRegistro();
                                                                                },
                                                                        hidden:ocultarNuevo
                                                                        
                                                                        
                                                                    },'-',
                                                                    {
                                                                        text:'<img src="../images/edit_f2.png" height="16" width="16">&nbsp;<?php echo $btnModificarLabel ?>',
                                                                        handler:function()
                                                                                {
                                                                                    modificar(gridRegistros);
                                                                                },
                                                                        hidden:ocultarModificar
                                                                    },'-',
                                                                    {
                                                                        text:'<img src="../images/cancel_round.png" >&nbsp;<?php echo $btnEliminarLabel ?>',
                                                                        handler:function()
                                                                                {
                                                                                    eliminar(gridRegistros);
                                                                                },
                                                                        hidden:ocultarEliminar
                                                                    },'-',
                                                                    
                                                                    {
                                                                        text:'<img src="../images/tablero.gif" >&nbsp;<?php echo $etj["lblVerTableroControl"] ?>',
                                                                        handler:function()
                                                                                {
                                                                                    verTableroControl(gridRegistros);
                                                                                },
                                                                        hidden:ocultarTableroC
                                                                    },'-',
                                                                    {
                                                                        text:'<img src="../images/calendar_edit.jpg" >&nbsp;<?php echo $etj["lblAdminUnidad"] ?>',
                                                                        handler:function()
                                                                                {
                                                                                    verAdmon();
                                                                                },
                                                                        hidden:ocultarAdminUnidades
                                                                        
                                                                    },'-'
                                                                    <?php
                                                                        echo $btnGantt;
                                                                    ?>
    
                                                                ],
                                                          bbar: paginador
                                                      }
                                                  );
		dsTablaRegistros.load({params:{start:0, limit:tamPagina,funcion:1,idFormulario:<?php echo $idFormulario?>,idReferencia:<?php echo $idReferencia?>,idEstado:<?php echo $idEstado ?>,idConfiguracion:idConfig}});
<?php
	}
	else
	{
?>
				                                         
                                                        
        var gridRegistros=	new Ext.grid.GridPanel	(
                                                      {
                                                          
                                                          frame:false,
                                                          border:true,
                                                          columnLines :true,
                                                          cm: modelColumn,
                                                          height:450,
                                                          width:960,
                                                          renderTo:'tblRegistros',
                                                          trackMouseOver:false,
                                                          loadMask: true,
                                                          plugins: filters,
                                                          enableColLock: false,
                                                          store:dsTablaRegistros,
                                                          view: new Ext.grid.GroupingView({
                                                                                            forceFit:false,
                                                                                            groupTextTpl: '<span class="letraFicha">{text}</span> (<font color="#000066">Total: </font> <font color="#FF0000">{values.rs.length}</font>)',
                                                                                            startCollapsed :false
                                                                                        }),
                                                          
                                                          tbar:	[
                                                                   {
                                                                        text:'<img src="../images/icon_code.gif" >&nbsp;<?php echo $btnVerLabel ?>',
                                                                        hidden:true,
                                                                        handler:function()
                                                                                {
                                                                                    verFicha(gridRegistros);
                                                                                }/*,
                                                                        hidden:ocultarVerF*/
                                                                        
                                                                    },
                                                                    {
                                                                        text:'<img src="../images/add.png" height="16" width="16">&nbsp;<?php echo $btnAgregarLabel ?>',
                                                                        handler:function()
                                                                                {
                                                                                    nuevoRegistro();
                                                                                },
                                                                        hidden:ocultarNuevo
                                                                        
                                                                        
                                                                    },'-',
                                                                    {
                                                                        text:'<img src="../images/edit_f2.png" height="16" width="16">&nbsp;<?php echo $btnModificarLabel ?>',
                                                                        handler:function()
                                                                                {
                                                                                    modificar(gridRegistros);
                                                                                },
                                                                        hidden:ocultarModificar
                                                                    },'-',
                                                                    {
                                                                        text:'<img src="../images/cancel_round.png" >&nbsp;<?php echo $btnEliminarLabel ?>',
                                                                        handler:function()
                                                                                {
                                                                                    eliminar(gridRegistros);
                                                                                },
                                                                        hidden:ocultarEliminar
                                                                    },'-',
                                                                    {
                                                                        text:'<img src="../images/tablero.gif" >&nbsp;<?php echo $etj["lblVerTableroControl"] ?>',
                                                                        handler:function()
                                                                                {
                                                                                    verTableroControl(gridRegistros);
                                                                                },
                                                                        hidden:ocultarTableroC
                                                                    },'-',
                                                                    {
                                                                        text:'<img src="../images/calendar_edit.jpg" >&nbsp;<?php echo $etj["lblAdminUnidad"] ?>',
                                                                        handler:function()
                                                                                {
                                                                                    verAdmon();
                                                                                },
                                                                        hidden:ocultarAdminUnidades
                                                                        
                                                                    },'-'
                                                                    <?php
                                                                        echo $btnGantt;
                                                                    ?>
    
                                                                ]
                                                      }
                                                  );
		dsTablaRegistros.load({params:{start:0, limit:-1,funcion:1,idFormulario:<?php echo $idFormulario?>,idReferencia:<?php echo $idReferencia?>,idEstado:<?php echo $idEstado ?>,idConfiguracion:idConfig}});
<?php		
	}
?>    
}
    
function enviarDirecto(idRegistro)
{
	var nombreTabla=gE('nombreTabla').value;
    gE('id_'+nombreTabla).value=idRegistro;
   	gE('frmEnvio').submit();
    
}

function verTableroControl()
{
    var arrDatos=[['idFormulario',gE('idFormulario').value]];
    enviarFormularioDatos('../modeloPerfiles/tblEtapasProceso.php',arrDatos);
}

function verAdmon()
{
	gE('frmEnvioSig').action='../modeloCitas/administrarHorarioUnidadApartado.php';
    var arrDatos=[['idFormulario',gE('idFormulario').value],['ro',true]];
    enviarPagina(arrDatos);
}