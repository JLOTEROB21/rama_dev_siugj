<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica WHERE cmbCategoria=1 ORDER BY prioridad";
	$res=$con->obtenerFilas($consulta);
	$arrUnidadesGestion="";
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT tC.idTipoCarpeta,tC.nombreTipoCarpeta FROM _17_tiposCarpetasAdministra cA,7020_tipoCarpetaAdministrativa tC
					WHERE tC.idTipoCarpeta=cA.idOpcion AND cA.idPadre=".$fila[0]." AND tC.idTipoCarpeta IN(1,5,6) ORDER BY tc.idTipoCarpeta";
		$arrCarpetas=$con->obtenerFilasArreglo($consulta);			
		$o="['".$fila[0]."','".cv($fila[1])."',".$arrCarpetas."]";
		if($arrUnidadesGestion=="")
			$arrUnidadesGestion=$o;
		else
			$arrUnidadesGestion.=",".$o;
	}
	
?>

var arrUnidadesGestion=[<?php echo $arrUnidadesGestion?>];

Ext.onReady(inicializar);

function inicializar()
{
	var cmbUnidadGestion=crearComboExt('cmbUnidadGestion',arrUnidadesGestion,10,40,420);
    cmbUnidadGestion.on('select',function(cmb,registro)
    							{
                                	gEx('cmbTipoCarpeta').setValue('');
                                	gEx('cmbTipoCarpeta').getStore().loadData(registro.data.valorComp);
                                    if(registro.data.valorComp.length==1)
                                    {
	                                	gEx('cmbTipoCarpeta').setValue(registro.data.valorComp[0][0]);
                                        dispararEventoSelectCombo('cmbTipoCarpeta');
                                    }
                                }
    					)
    var horaInicial=new Date(2010,5,10,0,1);
	var horaFinal=new Date(2010,5,10,23,59);
	
    var cmbTipoCarpeta=crearComboExt('cmbTipoCarpeta',[],150,75,280);
    cmbTipoCarpeta.on('select',function(cmb,registro)
    							{
                                	function funcAjax()
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                        	cmbTipoAudiencia.setValue('');
                                            var arDatos=eval(arrResp[1]);
                                            cmbTipoAudiencia.getStore().loadData(arDatos);
                                        }
                                        else
                                        {
                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                        }
                                    }
                                    obtenerDatosWeb('../../paginasFunciones/funcionesAuxiliares.php',funcAjax, 'POST','funcion=33&tC='+registro.data.id+'&tU='+cmbUnidadGestion.getValue(),true);
                                }
    					)
    
    var cmbTipoAudiencia=crearComboExt('cmbTipoAudiencia',[],10,105,420);
	var arrHoras=generarIntervaloHoras(horaInicial,horaFinal,20);
    var cmbHoraRecepcion=crearComboExt('cmbHoraRecepcion',arrHoras,300,135,110);
    cmbHoraRecepcion.setValue('<?php echo date("H:00")?>');
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                 
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Debug Agenda Audiencias</b></span>',
                                                items:	[
                                                            {
                                                            	xtype:'panel',
                                                                width:450,
                                                                region:'west',
	                                                            layout:'absolute',
                                                                title:'Par&aacute;metro de configuraci&oacute;n',
                                                                items:	
                                                                        [
                                                                        	{
                                                                            	x:10,
                                                                                y:20,
                                                                                xtype:'label',
                                                                                html:'Unidad de Gestión Judicial:'
                                                                            },
                                                                            cmbUnidadGestion,
                                                                            {
                                                                            	x:10,
                                                                                y:80,
                                                                                xtype:'label',
                                                                                html:'Tipo de Carpeta:'
                                                                            },
                                                                            cmbTipoCarpeta,
                                                                            {
                                                                            	x:10,
                                                                                y:110,
                                                                                xtype:'label',
                                                                                html:'Tipo de audiencia:'
                                                                            },
																			cmbTipoAudiencia,
                                                                            {
                                                                            	x:10,
                                                                                y:140,
                                                                                xtype:'label',
                                                                                html:'Fecha/Hora recepci&oacute;n:'
                                                                            },
                                                                            {
                                                                            	x:180,
                                                                                y:135,
                                                                                xtype:'datefield',
                                                                                id:'dteFechaRecepcion',
                                                                                value:'<?php echo date("Y-m-d")?>'
                                                                            },
                                                                            cmbHoraRecepcion
                                                                        ]
                                                            },
                                                            {
                                                            	xtype:'panel',
                                                                width:300,
                                                                region:'center',
                                                                layout:'absolute',
                                                                tile:'',
                                                                ietms:	[]
                                                            }
                                                        ]
                                            }
                                         ]
                            }
                        )   
}