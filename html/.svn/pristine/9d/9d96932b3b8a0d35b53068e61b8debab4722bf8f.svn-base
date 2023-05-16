<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	$consulta="SELECT * FROM _550_tablaDinamica WHERE id__550_tablaDinamica=".$idReferencia;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$frecuenciaMedicion=$fRegistro["frecuenciaMedicion"];
	
	$arrLeyendas[1]="Mes";
	$arrLeyendas[2]="Bimestre";
	$arrLeyendas[3]="Trimestre";
	$arrLeyendas[4]="Cuatrimestre";
	$arrLeyendas[6]="Semestre";
	$arrLeyendas[12]="Anual";
	
	
	$arrPosicionOrd[1]="Primer";
	$arrPosicionOrd[2]="Segundo";
	$arrPosicionOrd[3]="Tercer";
	$arrPosicionOrd[4]="Cuarto";
	$arrPosicionOrd[5]="Quinto";
	$arrPosicionOrd[6]="Sexto";
	$arrPosicionOrd[7]="Séptimo";
	$arrPosicionOrd[8]="Octavo";
	$arrPosicionOrd[9]="Noveno";
	$arrPosicionOrd[10]="Décimo";
	$arrPosicionOrd[11]="Décimo primer";
	$arrPosicionOrd[12]="Décimo segundo";
	
	
	$cadCampos="{name: 'anio'},{name: 'calculado'},{name: 'absolutoAnual'},{name: 'porcentajeAnual'}";
	$cadColumnas="
				
				{
					  header:'A&ntilde;o',
					  width:80,
					  summaryRenderer:function()
					  				{
										return 'Promedio:';
									},
					  sortable:true,
					  dataIndex:'anio'
				  },
				  {
					  header:'Absoluto',
					  width:80,
					  summaryType:'average',
					  sortable:true,
					  editor:{xtype:'numberfield',allowDecimals:true,allowNegative:'false'},
					  dataIndex:'absolutoAnual'
				  },
				  {
					  header:'Porcentaje',
					  width:80,
					  summaryType:'average',
					  sortable:true,
					  editor:{xtype:'numberfield',allowDecimals:true,allowNegative:'false'},
					  dataIndex:'porcentajeAnual'
				  }
				  ";
	
	$cadCamposMetas="{name: 'absolutoAnual'},{name: 'porcentajeAnual'}";
	$cadColumnasMetas="
						  {
							  header:'Absoluto',
							  width:80,
							  sortable:true,
							  editor:{xtype:'numberfield',allowDecimals:true,allowNegative:'false'},
							  dataIndex:'absolutoAnual'
						  },
						  {
							  header:'Porcentaje',
							  width:80,
							  sortable:true,
							  editor:{xtype:'numberfield',allowDecimals:true,allowNegative:'false'},
							  dataIndex:'porcentajeAnual'
						  }
						  ";
	$arrCabecera="
						{},
						{header: 'Anual', colspan: 2, align: 'center'}
					";
					
	$arrCabeceraMetas=	"
						{header: 'Anual', colspan: 2, align: 'center'}
						";				
	$totalPeridos=12/$frecuenciaMedicion;
	
	
	for($x=1;$x<=$totalPeridos;$x++)
	{
		
		$cadCampos.=",{name:'absoluto_".$x."'},{name:'porcentaje_".$x."'}";
		$cadColumnas.=",
						  {
							  header:'Absoluto',
							  width:80,
							  summaryType:'average',
							  sortable:true,
							  editor:{xtype:'numberfield',allowDecimals:true,allowNegative:'false'},
							  dataIndex:'absoluto_".$x."'
						  },
						  {
							  header:'Porcentaje',
							  width:80,
							  summaryType:'average',
							  sortable:true,
							  editor:{xtype:'numberfield',allowDecimals:true,allowNegative:'false'},
							  dataIndex:'porcentaje_".$x."'
						  }";
		$arrCabecera.=",{header: '".$arrPosicionOrd[$x]." ".$arrLeyendas[$frecuenciaMedicion]."', colspan: 2, align: 'center'}";
		
		$cadCamposMetas.=",{name:'absoluto_".$x."'},{name:'porcentaje_".$x."'}";
		$cadColumnasMetas.=",
						  {
							  header:'Absoluto',
							  width:80,
							  sortable:true,
							  editor:{xtype:'numberfield',allowDecimals:true,allowNegative:'false'},
							  dataIndex:'absoluto_".$x."'
						  },
						  {
							  header:'Porcentaje',
							  width:80,
							  sortable:true,
							  editor:{xtype:'numberfield',allowDecimals:true,allowNegative:'false'},
							  dataIndex:'porcentaje_".$x."'
						  }";
		$arrCabeceraMetas.=",{header: '".$arrPosicionOrd[$x]." ".$arrLeyendas[$frecuenciaMedicion]."', colspan: 2, align: 'center'}";
		
	}
	
	$arrCabecera="[".$arrCabecera."]";
	$arrCabeceraMetas="[".$arrCabeceraMetas."]";
	
	$arrDatos="";
	$anioActual=date("Y");
	
	$consulta="SELECT COUNT(*) FROM _571_lineaBaseRegistro WHERE idReferencia=".$idRegistro." and anio<>0";
	$nLineas=$con->obtenerValor($consulta);
	
	if($nLineas==0)
	{
		$query=array();
		$queryCt=0;
		$query[$queryCt]="begin";
		$queryCt++;
		$anioInicio=$anioActual-3;
		$absolutoAnual=0;
		$porcentajeAnual=0;
		for($anio=$anioInicio;$anio<$anioActual;$anio++)
		{
			$oDato="['".$anio."','0','".$absolutoAnual."','".$porcentajeAnual."'";
			
			if($idRegistro!=-1)
			{
				$query[$queryCt]="INSERT INTO _571_lineaBaseRegistro(idReferencia,anio,mesValor,tipoValor,valor,calculado)
							VALUES(".$idRegistro.",".$anio.",0,0,".$absolutoAnual.",0)";
				$queryCt++;			
				$query[$queryCt]="INSERT INTO _571_lineaBaseRegistro(idReferencia,anio,mesValor,tipoValor,valor,calculado)
							VALUES(".$idRegistro.",".$anio.",0,1,".$porcentajeAnual.",0)";
				$queryCt++;		
			}
			
			for($x=1;$x<=$totalPeridos;$x++)
			{
				$absoluto=0;
				$porcentaje=0;
				
				$consulta="SELECT r.valor FROM _572_tablaDinamica fB,_572_registroCumplimientoIndicadores r,
							539_calendarioReportesIndicadores cR,_539_tablaDinamica mT 
							WHERE r.mesValor=".$x." AND  r.idReferencia=fB.id__572_tablaDinamica AND 
							r.idIndicador in(".$idRegistro.",".($fRegistro["idIndicadorBase"]==""?-1:$fRegistro["idIndicadorBase"]).
							") AND cR.idRegistro=fB.idRegistroCalendario AND 
							mT.id__539_tablaDinamica=cR.idReferencia AND r.tipoValor=0 and mT.ejercicioFiscal=".$anio;
				
				$absoluto=$con->obtenerValor($consulta);
				if($absoluto=="")
					$absoluto=0;
				
				$consulta="SELECT r.valor FROM _572_tablaDinamica fB,_572_registroCumplimientoIndicadores r,
							539_calendarioReportesIndicadores cR,_539_tablaDinamica mT 
							WHERE r.mesValor=".$x." AND  r.idReferencia=fB.id__572_tablaDinamica AND 
							r.idIndicador in(".$idRegistro.",".($fRegistro["idIndicadorBase"]==""?-1:$fRegistro["idIndicadorBase"]).
							") AND cR.idRegistro=fB.idRegistroCalendario AND 
							mT.id__539_tablaDinamica=cR.idReferencia AND r.tipoValor=1 and mT.ejercicioFiscal=".$anio;
				
				$porcentaje=$con->obtenerValor($consulta);
				
				if($porcentaje=="")
					$porcentaje=0;
				
				if($idRegistro!=-1)
				{
					$query[$queryCt]="INSERT INTO _571_lineaBaseRegistro(idReferencia,anio,mesValor,tipoValor,valor,calculado)
								VALUES(".$idRegistro.",".$anio.",".$x.",0,".$absoluto.",0)";
					$queryCt++;			
					$query[$queryCt]="INSERT INTO _571_lineaBaseRegistro(idReferencia,anio,mesValor,tipoValor,valor,calculado)
								VALUES(".$idRegistro.",".$anio.",".$x.",1,".$porcentaje.",0)";
					$queryCt++;	
				}
				$oDato.=",'".$absoluto."','".$porcentaje."'";
			}
			$oDato.="]";
			
			if($arrDatos=="")
				$arrDatos=$oDato;
			else
				$arrDatos.=",".$oDato;
		}
		
		$query[$queryCt]="begin";
		$queryCt++;
		$con->ejecutarBloque($query);
		
	}
	else
	{
		$consulta="SELECT DISTINCT anio FROM _571_lineaBaseRegistro WHERE idReferencia=".$idRegistro." and anio<>0 order by anio";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT DISTINCT calculado FROM _571_lineaBaseRegistro WHERE idReferencia=".$idRegistro." and anio<>0 order by anio";
			$calculado=$con->obtenerValor($consulta);
			$oDato="['".$fila[0]."',".$calculado;
			for($x=0;$x<=$totalPeridos;$x++)
			{
				$consulta="SELECT valor FROM _571_lineaBaseRegistro WHERE idReferencia=".$idRegistro.
						" AND anio=".$fila[0]." AND mesValor=".$x." AND tipoValor=0";
				$valorAbsoluto=$con->obtenerValor($consulta);
				$consulta="SELECT valor FROM _571_lineaBaseRegistro WHERE idReferencia=".$idRegistro.
						" AND anio=".$fila[0]." AND mesValor=".$x." AND tipoValor=1";
				$valorPorcentaje=$con->obtenerValor($consulta);
				
				$oDato.=",'".$valorAbsoluto."','".$valorPorcentaje."'";
			}
			$oDato.="]";
			
			if($arrDatos=="")
				$arrDatos=$oDato;
			else
				$arrDatos.=",".$oDato;
		}
	}
	
	
	
	$arrDatos="[".$arrDatos."]";
	
	$arrDatosMetas="";
	
	$consulta="SELECT COUNT(*) FROM _571_lineaBaseRegistro WHERE idReferencia=".$idRegistro." and anio=0";
	$nLineas=$con->obtenerValor($consulta);
	
	if($nLineas==0)
	{
		
		
			$oDato="['0','0'";
			for($x=1;$x<=$totalPeridos;$x++)
			{
				$oDato.=",'0','0'";
			}
			$oDato.="]";
			
			$arrDatosMetas=$oDato;
		
	}
	else
	{
		
		
		$oDato="";
		for($x=0;$x<=$totalPeridos;$x++)
		{
			$consulta="SELECT valor FROM _571_lineaBaseRegistro WHERE idReferencia=".$idRegistro.
					" AND anio=0 AND mesValor=".$x." AND tipoValor=0";
			$valorAbsoluto=$con->obtenerValor($consulta);
			$consulta="SELECT valor FROM _571_lineaBaseRegistro WHERE idReferencia=".$idRegistro.
					" AND anio=0 AND mesValor=".$x." AND tipoValor=1";
			$valorPorcentaje=$con->obtenerValor($consulta);
			
			if($oDato=="")
				$oDato="'".$valorAbsoluto."','".$valorPorcentaje."'";
			else
				$oDato.=",'".$valorAbsoluto."','".$valorPorcentaje."'";
		}
		$oDato="[".$oDato."]";
		
		$arrDatosMetas=$oDato;
		
	}
	
	$arrDatosMetas="[".$arrDatosMetas."]";
	$consulta="SELECT COUNT(*) FROM _571_gridSemaforizacion WHERE idReferencia=".$idRegistro;
	$nSemaforizacion=$con->obtenerValor($consulta);
	$addSemaforizacion="false";
	if($nSemaforizacion==0)
	{
		$addSemaforizacion="true";
	}

?>	
var addSemaforizacion=<?php echo $addSemaforizacion?>;
var totalPeriodos=<?php echo $totalPeridos ?>;
var cadenaFuncionValidacion='prepararGuardado';

var arrDatosLineaBase=<?php echo $arrDatos?>;
var arrDatosMetas=<?php echo $arrDatosMetas?>;
function inyeccionCodigo()
{
	     
	loadCSS('../Scripts/ux/groupHeader/ColumnHeaderGroup.css',function()
                                                              {
                                                              }
			) 
            
	loadCSS('../Scripts/ux/grid/GridSummary.css',function()
                                                              {
                                                              }
			)                                                                                                    
   
   loadScript('../Scripts/ux/groupHeader/ColumnHeaderGroup.js', function()
                                                                {
                                                                	loadScript('../Scripts/ux/grid/GridSummary.js', function()
                                                              		{
                                                                        crearGridLineaBase();
                                                                        crearGridMetas();
                                                                    }
                                                                    )
                                                                }
				)
    if(addSemaforizacion)
    {
    	setTimeout(	function()
        				{
                        	var registro=crearRegistro	(
                            								[
                                                            	{name: 'idRegistro'},
                                                                {name: 'idReferencia'},
                                                                {name:'vAbsoluto'},
                                                                {name:'vPorcentaje'},
                                                                {name:'aAbsoluto'},
                                                                {name:'aPorcentaje'},
                                                                {name:'rAbsoluto'},
                                                                {name:'rPorcentaje'}
                                                              ]
                            							)	
                        
                        	var r=new registro	(
                            						{
                                                    	idRegistro:-1,
                                                        idReferencia:-1,
                                                        vAbsoluto:0,
                                                        vPorcentaje:0,
                                                        aAbsoluto:0,
                                                        aPorcentaje:0,
                                                        rAbsoluto:0,
                                                        rPorcentaje:0
                                                    }
                            					)
                                                
							gEx('grid_9295').getStore().add(r);                                                
                        },
                        200
        			)
    }

	
    insertCss('.x-grid3-hd-inner {  font-family: Ubuntu, sans-serif;   height: auto !important; text-align:center; min-height:21px;   font-size: 12px;}');
	insertCss('.x-grid3-cell-inner {  text-align: center;}');

}	

function crearGridLineaBase()
{
	var summary = new Ext.ux.grid.GridSummary();
	var cabecera=	new Ext.ux.grid.ColumnHeaderGroup	(
                                                        	{
                                                            	rows: 	[<?php echo $arrCabecera?>]
                                                        	}
                                                        )

	var arrColumnas=[<?php echo $cadColumnas?>];
	
    
    var dsDatos=arrDatosLineaBase;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[<?php echo $cadCampos?>]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
                                                                                      
	      
	var cModelo= new Ext.grid.ColumnModel   	(
												 	arrColumnas
												);
	gE('sp_9291').innerHTML='';
    var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                     	{
                                                        	store:alDatos,
                                                            false:true,
                                                            cm: cModelo,
                                                            id:'gridLineaBase',
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            renderTo:'sp_9291',
                                                            columnLines : true,
                                                            height:190,
                                                            width:980,
                                                            plugins:[cabecera,summary]
                                                       }  
                                                    );                                                    
	
    
    tblGrid.on('beforeEdit',function(e)
    						{
                            
                            
                            	if((e.record.data.calculado=='1')||(!esRegistroFormulario()))
                                	e.cancel=true;
                                
                                if(e.field.indexOf('porcentaje')!=-1)
                                {
                                	
                                }
                            }
    			)

	tblGrid.on('afterEdit',function(e)
    						{
                            	
                                if(e.field.indexOf('porcentaje')!=-1)
                                {
                                	if(parseFloat(e.value)>100)
                                    {
                                    	function respAux()
                                        {
                                        	e.record.set(e.field,e.originalValue);
                                            e.grid.startEditing(e.row,e.column);
                                        }
                                    	msgBox('El porcentaje no puede ser mayor a 100%',respAux);
                                    	return;
                                    }
                                }
                            }
    			)                
                                                                                                                                                                      
}

function crearGridMetas()
{
	var cabecera=	new Ext.ux.grid.ColumnHeaderGroup	(
                                                        	{
                                                            	rows: 	[<?php echo $arrCabeceraMetas?>]
                                                        	}
                                                        )

	var arrColumnas=[<?php echo $cadColumnasMetas?>];
	
    
    var dsDatos=arrDatosMetas;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[<?php echo $cadCamposMetas?>]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
                                                                                      
	      
	var cModelo= new Ext.grid.ColumnModel   	(
												 	arrColumnas
												);
	gE('sp_9297').innerHTML='';
    var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                     	{
                                                        	store:alDatos,
                                                            false:true,
                                                            cm: cModelo,
                                                            id:'gridMetas',
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            renderTo:'sp_9297',
                                                            columnLines : true,
                                                            height:150,
                                                            width:980,
                                                            plugins:[cabecera]
                                                       }  
                                                    );                                                    
	
    
    tblGrid.on('beforeEdit',function(e)
    						{
                            	if(!esRegistroFormulario())
                                	e.cancel=true;
                                
                            }
    			)

	tblGrid.on('afterEdit',function(e)
    						{
                            	
                                if(e.field.indexOf('porcentaje')!=-1)
                                {
                                	if(parseFloat(e.value)>100)
                                    {
                                    	function respAux()
                                        {
                                        	e.record.set(e.field,e.originalValue);
                                            e.grid.startEditing(e.row,e.column);
                                        }
                                    	msgBox('El porcentaje no puede ser mayor a 100%',respAux);
                                    	return;
                                    }
                                }
                            }
    			)                
                                                                                                                                                                      
}

function prepararGuardado()
{
	var id=gE('idRegistroG').value;
    
    var arrLineaBase='';

	var x;
    var fila;
    var lBase='';
    var gridLineaBase=gEx('gridLineaBase');
    var periodo=1;
    for(x=0;x<gridLineaBase.getStore().getCount();x++)
    {
    	fila=gridLineaBase.getStore().getAt(x);
        lBase='{"anio":"'+fila.data.anio+'","absoluto_0":"'+fila.data.absolutoAnual+'","porcentaje_0":"'+fila.data.porcentajeAnual+'","calculado":"'+fila.data.calculado+'"';
     	
		for(periodo=1;periodo<=totalPeriodos;periodo++)           
        {
        	lBase+=',"absoluto_'+periodo+'":"'+fila.get('absoluto_'+periodo)+'","porcentaje_'+periodo+'":"'+fila.get('porcentaje_'+periodo)+'"';
        }
        lBase+='}';
     	if(arrLineaBase=='')   
        	arrLineaBase=lBase;
        else
        	arrLineaBase+=','+lBase;
    }

    
    
    var arrMetas='';
    
    var gridMetas=gEx('gridMetas');
    var periodo=1;
    for(x=0;x<gridMetas.getStore().getCount();x++)
    {
    	fila=gridMetas.getStore().getAt(x);
        lBase='{"anio":"0","absoluto_0":"'+fila.data.absolutoAnual+'","porcentaje_0":"'+fila.data.porcentajeAnual+'","calculado":"0"';
     	
		for(periodo=1;periodo<=totalPeriodos;periodo++)           
        {
        	lBase+=',"absoluto_'+periodo+'":"'+fila.get('absoluto_'+periodo)+'","porcentaje_'+periodo+'":"'+fila.get('porcentaje_'+periodo)+'"';
        }
        lBase+='}';
     	if(arrLineaBase=='')   
        	arrLineaBase=lBase;
        else
        	arrLineaBase+=','+lBase;
    }
    
    
	var objRegistro ='{"arrLineaBase":['+arrLineaBase+'],"totalPeridos":"'+totalPeriodos+'"}';                      
	if(id=='-1')
    {
        gE('funcPHPEjecutarNuevo').value=bE('guardarDatosIndicador(@idRegPadre,\''+bE(objRegistro)+'\')');
    }
    else
    {
        gE('funcPHPEjecutarModif').value=bE('guardarDatosIndicador('+id+',\''+bE(objRegistro)+'\')');
    }
    
    if(gE('_nombreResponsablevch').value=='-1')
    {
    	function respAux2()
        {
			gEx('ext__nombreResponsablevch').focus();        	
        }
        msgBox('Debe ingresar el nombre de la persona responsable de indicador',respAux2);
        return false;
    }
    
    
    return true;
}
