<?php 
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT id__352_tablaDinamica,curso,o.unidad,costoTotal,clicloant,d1.idEstado FROM _352_tablaDinamica d1, _674_tablaDinamica d2,817_organigrama o
			   WHERE d2.idReferencia=id__352_tablaDinamica AND o.codigoUnidad=d1.codigoUnidad AND d1.idEstado IN (7,8,9)";
	$arreglo=$con->obtenerFilasArreglo($consulta);
?>	

Ext.onReady(inicializar);

function inicializar()
{
    crearGridCursos();
}

function crearGridCursos()
{
    var arrDatos=<?php echo $arreglo?>;
    
    var dSetReg= new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    
                                                                    {name:'idCurso'},
                                                                    {name:'curso'},
                                                                    {name:'unidad'},
                                                                    {name:'costoTotal'},
                                                                    {name:'ciclo'},
                                                                    {name:'tipo'}
                                                                ]
                                                    }
                                                 )
    
	dSetReg.loadData(arrDatos);
    var summary =  new Ext.ux.grid.GridSummary();
	var cmP= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'Curso',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'curso'
                                                            },
                                                            {
                                                                header:'Departamento',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'unidad'
                                                            },
                                                            {
                                                                header:'ciclo',
                                                                width:90,
                                                                sortable:true,
                                                                dataIndex:'ciclo'
                                                            },
                                                            {
                                                                header:'Tipo de impartici&oacute;n',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'tipo',
                                                                renderer:function(val,meta,registro)
                                                                				{
                                                                                    switch(val)
                                                                                    {
                                                                                        case '7.00':
                                                                                        return' Finaciamiento interno ';
                                                                                        break;
                                                                                        case '8.00':
                                                                                        return' Instituci&oacute; beneficiaria';
                                                                                        break;
                                                                                        case '9.00':
                                                                                        return' Licitaci&oacute;';
                                                                                        break;
                                                                                    }
                                                                                },
                                                                summaryRenderer:function()
                                                                          {
                                                                              return "<b>Costo total:</b>";
                                                                          }                	
                                                            },
                                                            {
                                                                header:'costo',
                                                                width:90,
                                                                sortable:true,
                                                                editor:{xtype:'numberfield'},
                                                                dataIndex:'costoTotal',
                                                                summaryType:'sum',
                                                                renderer:'usMoney'
                                                            }   
                                                        ]
                                                    );
											
	var gridCur=	new Ext.grid.EditorGridPanel	(
                                                    {
                                                    	x:10,
                                                        y:10,
                                                        title:'Cursos autorizados',
														id:'gridCursos',
                                                        store:dSetReg,
                                                        frame:true,
                                                        renderTo:'gCursos',
                                                        cm: cmP,
                                                        height:345,
                                                        width:800,
                                                        plugins: [summary]
													}
    											);
    gridCur.on()                                            
}
