<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT idCelda,celda FROM 1019_catalogoCeldasExcel ORDER BY idCelda";
	$arrCeldas=$con->obtenerFilasArreglo($consulta);
	
?>


var regColumna=null;
var arrCeldas=<?php echo $arrCeldas?>;
Ext.onReady(inicializar);

function inicializar()
{
	regColumna=crearRegistro	(
    								[
                                    	 {name: 'idColumna'},
                                         {name: 'tamano'}
                                    ]
    							)
	crearGridDefinionTamano();
    gE('_nombrePerfilvch').focus();
}


function crearGridDefinionTamano()
{
	
	var dsDatos=eval(bD(gE('arrEstructura').value));
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idColumna'},
                                                                    {name: 'tamano'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
														{
															header:'Columna',
															width:100,
															sortable:true,
															dataIndex:'idColumna',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrCeldas,val);
                                                                    }
														},
														{
															header:'Longitud',
															width:120,
															sortable:true,
                                                            css:'text-align:right !important;',
															dataIndex:'tamano',
                                                            editor:	{
                                                            			xtype:'numberfield',
                                                                        allowDecimals:false,
                                                                        allowNegative:false
                                                            		}
                                                            
                                                            
                                                            
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            renderTo:'tblDefincionEstructura',
                                                            store:alDatos,
                                                            id:'gridEstructura',
                                                            frame:false,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            clicksToEdit:1,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            height:220,
                                                            width:300,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar columna',
                                                                            handler:function()
                                                                            		{
                                                                                    	var r=new regColumna	(
                                                                                        							{
                                                                                                                    	idColumna:tblGrid.getStore().getCount()+1,
																				                                        tamano:''
                                                                                                                    }
                                                                                        						)
                                                                                                                
                                                                                                                
                                                                                    	tblGrid.getStore().add(r); 
                                                                                        tblGrid.startEditing(tblGrid.getStore().getCount()-1,2);                           
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover columna',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar almenos una columna a remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	tblGrid.getStore().remove(filas);
                                                                                                var x;
                                                                                                for(x=0;x<tblGrid.getStore().getCount();x++)
                                                                                                {
                                                                                                	tblGrid.getStore().getAt(x).set('idColumna',(x+1));
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover las columnas seleccionadas?',resp);
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function formatoImportacionSel(cmb)
{
	oE('fila_1');
    oE('fila_2');
    oE('fila_3');
    
	var valor=cmb.options[cmb.selectedIndex].value;
    switch(valor)
    {
    	case '1':
			mE('fila_3');        	
        break;
        case '2':
        	mE('fila_2');
        break;
    	case '3':
        case '4':
        	mE('fila_1');
        break;
    }
    
}

function radioDelimitadorClick(ctrl)
{
	if(ctrl.id=='chkD_6')
    {
    	hE('otro_D3');
        
    }
    else
    {
    	dE('otro_D3');
        gE('otro_D3').value='';
    }
}


function radioSeparadorClick(ctrl)
{
	if(ctrl.id=='chkS_6')
    {
    	hE('otro_S3');
    }
    else
    {
    	dE('otro_S3');
        gE('otro_S3').value='';
    }
}



function checkDelimitadorClick(ctrl)
{
	if(ctrl.id=='chkD_6')
    {
    	if(ctrl.checked)
        {
    		hE('otro_D2');
        }
        else
        {    
            dE('otro_D2');
            gE('otro_D2').value='';
		}        
    }
}


function checkSeparadorClick(ctrl)
{
	if(ctrl.id=='chkS_6')
    {
    	if(ctrl.checked)
        {
    		hE('otro_S2');
        }
        else
        {    
            dE('otro_S2');
            gE('otro_S2').value='';
		}        
    }
}


function tipoSeparacionSel(cmb)
{
	var valor=cmb.options[cmb.selectedIndex].value;
    switch(valor)
    {
    	case '1':
			mE('filaSeparadorValores');   
            oE('filaDefinicionEstructura');     	
        break;
        case '2':
        	oE('filaSeparadorValores');
            mE('filaDefinicionEstructura');
            gEx('gridEstructura').getView().refresh();
        break;
    }
}



function validarConfiguracion()
{
	if(validarFormularios('frmEnvio'))
    {
    	var formatoImportacion=gE('_formatoImportacionvch');
        var separadorLinea='';
        var separadorValores='';
        var iFormato=formatoImportacion.options[formatoImportacion.selectedIndex].value;
     	var objConfiguracion='';
        switch(iFormato)
        {
        	case '1':
            	var arrCtrl=gEN('chkD_3');
                var x;
                for(x=0;x<arrCtrl.length;x++)
                {
                	
                	if(arrCtrl[x].checked)
                    {
                    	if(arrCtrl[x].id=='chkD_6')
                        {
                        	separadorLinea='[@]'+gE('otro_D3').value;
                            if(gE('otro_D3').value=='')
                            {
                            	function resp1()
                                {
                                	gE('otro_D3').focus();
                                }
                                msgBox('Debe indicar el caracter que fungir&aacute; como separador de l&iacute;nea',resp1);
                                return;
                            }
                        }
                        else
                        {
                        	separadorLinea=arrCtrl[x].value;
                        }
                    }
                }
                
                
            	if(separadorLinea=='')
                {
                	msgBox('Debe indicar el caracter que fungir&aacute; como separador de l&iacute;nea');
                    return;
                }
            
            	arrCtrl=gEN('chkS_3');
                
                for(x=0;x<arrCtrl.length;x++)
                {
                	
                	if(arrCtrl[x].checked)
                    {
                    	if(arrCtrl[x].id=='chkS_6')
                        {
                        	separadorValores='[@]'+gE('otro_S3').value;
                            if(gE('otro_S3').value=='')
                            {
                            	function resp2()
                                {
                                	gE('otro_S3').focus();
                                }
                                msgBox('Debe indicar el caracter que fungir&aacute; como separador de valores',resp2);
                                return;
                            }
                        }
                        else
                        {
                        	separadorValores=arrCtrl[x].value;
                        }
                    }
                }
                
                
            	if(separadorValores=='')
                {
                	msgBox('Debe indicar el caracter que fungir&aacute; como separador de valores');
                    return;
                }
            
            
            
            	objConfiguracion='{"separadorLinea":"'+separadorLinea+'","separadorValores":"'+separadorValores+'","caracterEncierro":"'+cv(gE('cvsCaracterEncerrado').value,false,true)+'"}';
            break;
            case '2':
            	var arrLongitudes='';
            	var arrCtrl=gEN('chkD_2');
                var x;
                for(x=0;x<arrCtrl.length;x++)
                {
                	
                	if(arrCtrl[x].checked)
                    {
                    	if(arrCtrl[x].id=='chkD_6')
                        {
                        	
                            if(gE('otro_D2').value=='')
                            {
                            	function resp3()
                                {
                                	gE('otro_D2').focus();
                                }
                                msgBox('Debe indicar el caracter que fungir&aacute; como separador de l&iacute;nea',resp3);
                                return;
                            }
                            else
                            {
                            	if(separadorLinea=='')
                                    separadorLinea='[@]'+gE('otro_D2').value.replace(/,/gi,'@,@');
                                else
                                    separadorLinea+='[@]@,@'+gE('otro_D2').value.replace(/,/gi,'@,@');
                            }
                        }
                        else
                        {
                        	if(separadorLinea=='')
                            	separadorLinea=arrCtrl[x].value;
                            else
                            	separadorLinea+='@,@'+arrCtrl[x].value;

                        }
                    }
                }
                
                
            	if(separadorLinea=='')
                {
                	msgBox('Debe indicar almenos un caracter que fungir&aacute; como separador de l&iacute;nea');
                    return;
                }
            
            	var _separacionValoresvch=gE('_separacionValoresvch');
                
                var tipoSeparacionValores=_separacionValoresvch.options[_separacionValoresvch.selectedIndex].value;
                if(tipoSeparacionValores=='1')
                {
                    arrCtrl=gEN('chkS_2');
                    
                    
                    for(x=0;x<arrCtrl.length;x++)
                    {
                        
                        if(arrCtrl[x].checked)
                        {
                            if(arrCtrl[x].id=='chkS_6')
                            {
                            
                            	 if(gE('otro_S2').value=='')
                                {
                                    function resp4()
                                    {
                                        gE('otro_S2').focus();
                                    }
                                    msgBox('Debe indicar el caracter que fungir&aacute; como separador de l&iacute;nea',resp4);
                                    return;
                                }
                                else
                                {
                                    if(separadorValores=='')
                                        separadorValores='[@]'+gE('otro_S2').value.replace(/,/gi,'@,@');
                                    else
                                        separadorValores+='[@]@,@'+gE('otro_S2').value.replace(/,/gi,'@,@');
                                }
                                
                            }
                            else
                            {
                            	if(separadorValores=='')
                                    separadorValores=arrCtrl[x].value;
                                else
                                    separadorValores+='@,@'+arrCtrl[x].value;
                                
                            }
                        }
                    }
                    
                    
                    if(separadorValores=='')
                    {
                        msgBox('Debe indicar almenos un caracter que fungir&aacute; como separador de valores');
                        return;
                    }
            
            	}
                else
                {
                	var gridEstructura=gEx('gridEstructura');
                    var f;
                    var oT='';
                    for(x=0;x<gridEstructura.getStore().getCount();x++)
                    {
                    	f=gridEstructura.getStore().getAt(x);
                    	if((f.data.tamano=='')||(f.data.tamano=='0'))
                        {
                        	function resp6()
                            {
                            	gridEstructura.startEditing(x,2);
                            }
                            msgBox('El valor de logintud ingresado no es v&aacute;lido',resp6)
                            return;
                        
                        }
                        
                        oT='{"idColumna":"'+f.data.idColumna+'","longitud":"'+f.data.tamano+'"}';
                        if(arrLongitudes=='')
                        	arrLongitudes=oT;
                        else
                        	arrLongitudes+=','+oT;
                        
                        
                        
                    }
                    
                    if(arrLongitudes=='')
                    {
                    	msgBox('Debe definir la estructura de los registros a importar');
                    	return;
                    }
                    
                    
                }
            
            	objConfiguracion='{"caracterEncierro":"'+gE('cvsCaracterEncerrado3').value+'","arrLongitudes":['+arrLongitudes+'],"separadorLinea":"'+separadorLinea+'","separadorValores":"'+separadorValores+'","tipoSeparacionValores":"'+tipoSeparacionValores+'"}';
            
            break;
            case '3':
            case '4':
            
            	var _columnaInicialvch=gE('_columnaInicialvch');
                
                var columnaInicial=_columnaInicialvch.options[_columnaInicialvch.selectedIndex].value;
                if(columnaInicial=='-1')
                {
                	function resp10()
                    {
                    	_columnaInicialvch.focus();
                    }
                    
                	msgBox('Debe indicar la columna inicial en la cual comenzar&aacute; la lectura de registros',resp10);
                	return;
                }
                var filaInicial;
                var _filaInicialint=gE('_filaInicialint');
                filaInicial=_filaInicialint.value;
                if((filaInicial=='')||(parseFloat(filaInicial)==0))
                {
                	function resp11()
                    {
                    	_filaInicialint.focus();
                    }
                    
                	msgBox('Debe indicar la fila inicial en la cual comenzar&aacute; la lectura de registros',resp11);
                	return;
                }
                
                
                var _columnaFinalvch=gE('_columnaFinalvch');
                var columnaFinal=_columnaFinalvch.options[_columnaFinalvch.selectedIndex].value;
                if(columnaFinal!='0')
                {
                	if(parseFloat(columnaFinal)<parseFloat(columnaInicial))
                    {
                        function resp12()
                        {
                            _columnaFinalvch.focus();
                        }
                        
                        msgBox('La columna final de lectura de registros NO puede ser menor que la columna inicial',resp12);
                        return;
                    }
                }
                
                var _filaFinalint=gE('_filaFinalint');
            	var filaFinal=_filaFinalint.value;
                
                if(filaFinal=='')
                {
                	function resp13()
                    {
                    	_filaFinalint.focus();
                    }
                    
                	msgBox('Debe indicar la fila final en la cual terminar&aacute; la lectura de registros',resp13);
                	return;
                }
                
            	objConfiguracion='{"columnaInicial":"'+columnaInicial+'","filaInicial":"'+filaInicial+'","columnaFinal":"'+columnaFinal+'","filaFinal":"'+filaFinal+'"}';
            
            
            break;
        }
        
        gE('_objConfiguracionvch').value=bE(objConfiguracion);
		gE('frmEnvio').submit();        

        
    }
}
