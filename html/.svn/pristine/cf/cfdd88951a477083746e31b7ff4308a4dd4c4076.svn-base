<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$consulta="SELECT * FROM 903_variablesSistema WHERE idVariable=1";
	$objConfiguracion=$con->obtenerFilasJSON($consulta);	
	
	$consulta="SELECT CONCAT(idRol,'_',extensionRol) AS idRol,nombreGrupo FROM 8001_roles ORDER by nombreGrupo";
	$arrRoles=$con->obtenerFilasArreglo($consulta);	
?>

var arrRoles=<?php echo $arrRoles?>;
var arrMinusculas='abcdefghijklmnñopqrstuvwxyz';
var arrMayusculas='ABCDEFGHIJKLMNÑOPQRSTUVWXYZ';
var arrNumeros='0123456789';
var arrEspeciales='!"#$%&()=¿?[]\'+-*/_;@.,;';

var objConfiguracion=eval(<?php echo $objConfiguracion?>)[0];

Ext.onReady(Inicializar);

function Inicializar()
{
	generaLogin();
    new Ext.Button (
                            {
                                cls:'btnSIUGJ',
                                text:'Guardar',
                                width:110,
                                height:40,
                                renderTo:'contenedor1',
                                handler:function()
                                        {
                                        	var pwd1=gE('Contrasena');
                                            if(pwd1.value=='')
                                            {
                                            	msgBox('Debe ingresar la contrase&ntilde;a a asignar');
                                            	return;
                                            }
                                            
                                        	function funcAjax()
                                            {
                                                var resp=peticion_http.responseText;
                                                arrResp=resp.split('|');
                                                if(arrResp[0]=='1')
                                                {
                                                	if(arrResp[1]=='1')
                                                    {
                                                    	msgBox('La contrase&ntilde;a es insegura<br />(Diccionario de contrase&ntilde;as restringidas)');

                                                    }
                                                    else
                                                    	guardarUsuario('nUsuario');
                                                }
                                                else
                                                {
                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                }
                                            }
                                            obtenerDatosWeb('../paginasFunciones/funciones.php',funcAjax, 'POST','funcion=14&pwd='+pwd1.value,true);
                                            
                                        
                                        
                                           
                                        }
                                
                            }
                        )
	if(gE('vCU').value=='0')
    {
    	crearGridRoles();
		crearOrganigrama();
	}
    
    var lblStatus='';
    
    switch(gE('cuentaActiva').value)
    {
    	case '0':
        	lblStatus='Cuenta Inactiva';
        break;
        case '1':
        	lblStatus='Cuenta Activa';
        break;
        case '100':
        	lblStatus='Cuenta Bloqueda';
        break;
    }
    
    
    
    
    window.parent.gE('lblStatusCuenta').innerHTML='-- '+lblStatus+' --';
    
    
}


function refrescarOrganigrama()
{
	gEx('tOrganigrama').getRootNode().reload();
}

var keyMap = new Ext.KeyMap(document, 
									{
										key: 13, 
										fn: funValidar,
										scope: this
									}
							);

function funValidar()
{
	var btnGuardar=gE('btnGuardar');
	btnGuardar.click();
	
}

function guardarUsuario(form)
{
	var pwd1=gE('Contrasena');
	var pwd2=gE('Contrasena2');
	if(pwd1.value!=pwd2.value)
	{
		keyMap.disable();
		function ponerFoco()
		{
			pwd1.focus();
			keyMap.enable();
		}
		msgBox('Las contrase&ntilde;as introducidas son diferentes',ponerFoco);
		return;
	}
    
    if(gE('vCU').value=='1')
    {
    	
        if(pwd1.value.length<parseInt(objConfiguracion.logitudMinimaContrasena))
        {
            function respAux3()
            {
                pwd1.focus();
            }
            msgBox('La longitud de la contrase&ntilde;a debe ser de almenos '+(parseInt(objConfiguracion.logitudMinimaContrasena)==1?'1 caracter':(objConfiguracion.logitudMinimaContrasena+' caracteres')),respAux3);
            return;
        }
        
        if(pwd1.value.length>parseInt(objConfiguracion.logitudMaximaContrasena))
        {
            function respAux4()
            {
                pwd1.focus();
            }
            msgBox('La longitud de la contrase&ntilde;a excede el m&aacute;ximo permitido ('+(parseInt(objConfiguracion.logitudMaximaContrasena)==1?'1 caracter':(objConfiguracion.logitudMaximaContrasena+' caracteres')+')'),respAux4);
            return;
        }
        
       
        
        if(parseInt(objConfiguracion.minLetrasMinusculas)>0)
        {
            var totaLetras=contarOcurrenciasCaraceteresCadena(arrMinusculas,pwd1.value);
            if(totaLetras<parseInt(objConfiguracion.minLetrasMinusculas))
            {
                function respAux5()
                {
                    pwd1.focus();
                }
                msgBox('La contrase&ntilde;a debe contener almenos '+(parseInt(objConfiguracion.minLetrasMinusculas)==1?'1 letra min&uacute;scula':(objConfiguracion.minLetrasMinusculas+' letras min&uacute;sculas')),respAux5);
                return;
            }
        }
        
        
        
        if(parseInt(objConfiguracion.minLetrasMayusculas)>0)
        {
            var totaLetras=contarOcurrenciasCaraceteresCadena(arrMayusculas,pwd1.value);
            if(totaLetras<parseInt(objConfiguracion.minLetrasMayusculas))
            {
                function respAux50()
                {
                    pwd1.focus();
                }
                msgBox('La contrase&ntilde;a debe contener almenos '+(parseInt(objConfiguracion.minLetrasMayusculas)==1?'1 letra may&uacute;scula':(objConfiguracion.minLetrasMayusculas+' letras may&uacute;sculas')),respAux50);
                return;
            }
        }
         
        
        if(parseInt(objConfiguracion.minCaracteresNumericos)>0)
        {
            var totaLetras=contarOcurrenciasCaraceteresCadena(arrNumeros,pwd1.value);
            if(totaLetras<parseInt(objConfiguracion.minCaracteresNumericos))
            {
                function respAux7()
                {
                    pwd1.focus();
                }
                msgBox('La contrase&ntilde;a debe contener almenos '+(parseInt(objConfiguracion.minCaracteresNumericos)==1?'1 caracter num&eacute;rico':(objConfiguracion.minCaracteresNumericos+' caracteres num&eacute;ricos')),respAux7);
                return;
            }
        }
        
        if(parseInt(objConfiguracion.minCaracteresEspeciales)>0)
        {
            var totaLetras=contarOcurrenciasCaraceteresCadena(arrEspeciales,pwd1.value);
            if(totaLetras<parseInt(objConfiguracion.minCaracteresEspeciales))
            {
                function respAux8()
                {
                    pwd1.focus();
                }
                msgBox('La contrase&ntilde;a debe contener almenos '+(parseInt(objConfiguracion.minCaracteresEspeciales)==1?'1 caracter especial':(objConfiguracion.minCaracteresEspeciales+' caracteres especiales')),respAux8);
                return;
            }
        }
        
    }
    
	if(gE('vCU').value=='0')
    {
        if (!validaRoles())
        {
            keyMap.disable();
            function resp()
            {
                keyMap.enable();
            }
            Ext.MessageBox.alert(lblAplicacion,'Por lo menos debe seleccionar un rol para el Usuario',resp);
            return;
        }
	}
    	
	if (!validarFormularios(form))
	{
		return;
	}
	else
	{
		var formulario=gE(form);
        if(gE('vCU').value=='0')
	        prepararComboRoles();
		formulario.submit();
	}
}


function prepararComboRoles()
{
	var gridRoles=gEx('gRoles');
    var hRoles=gE('listadoRoles');
    var x;
    var roles='';
    var fila;
    for(x=0;x<gridRoles.getStore().getCount();x++)
    {
    	fila=gridRoles.getStore().getAt(x);
        
        if(fila.data.idRol!='')
        {
        
        
            if(roles=='')
                roles=fila.data.idRol;
            else
                roles+=','+fila.data.idRol;
		}
    }
    hRoles.value=roles;
    
}

function validaRoles()
{

    if(gEx('gRoles').getStore().getCount()==0)
    	return false;
    else
    	return true;
}

function generaLogin()
{
	var cmbLogin=gE('cmbLogin');
    if(cmbLogin)
    {
        var idUsr=gE('idUsuario');
        limpiarCombo(cmbLogin);
        function funcTratarRespuesta()
        {
            var resp=peticion_http.responseText;
            var arrOpc=resp.split('|');
            var x;
            var opcion;
            for(x=0;x<arrOpc.length-1;x++)
            {
                opcion=document.createElement('option');
                opcion.value=arrOpc[x];
                opcion.text=arrOpc[x];
                cmbLogin.options[cmbLogin.length]=opcion;
            }
            selElemCombo(cmbLogin,gE('lblLogin').value);
        }
        obtenerDatosWeb('intermediaProcesar.php',funcTratarRespuesta, 'POST','banderaGuardar=generaLogin&idUsuario='+idUsr.value);		
	}
}

function regresar(usr)
{
	var arrParam=[['idUsuario',usr]];
	enviarFormularioDatos('intermediaMostrar.php',arrParam);	
}

function removerRol()
{
	var cmbRoles=gE('listRoles');
	var rol=cmbRoles.selectedIndex;
	if(rol==-1)
	{
		Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','Debe elegir el rol a remover');
        return;
	}
    
    function resp(btn)
    {
    	if(btn=='yes')
        	cmbRoles[cmbRoles.selectedIndex]=null;
    }
    Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>','Est&aacute; seguro de querer remover este rol',resp);
    
    
}



function existeRol(idCombo,valor)
{
	var combo=gE(idCombo);
    var x;
    for(x=0;x<combo.options.length;x++)
    {
    	if(combo.options[x].value==valor)
        	return true;
    }
    return false;

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
                                                                            funcion:'70',
                                                                            organigramaInst:'1',
                                                                            idUsuario:gE('idUsuario').value
                                                                            
                                                                        },
                                                            dataUrl:'../paginasFunciones/funcionesOrganigrama.php',
                                                            uiProviders:	{
                                                                            	'col': Ext.ux.tree.ColumnNodeUI
                                                                        	}
                                                        }	


		                                         )		                                        
		
                                        
		var organigrama = new Ext.ux.tree.TreeGrid	(
                                                            {
                                                                id:'tOrganigrama',
                                                                height:550,
                                                                width:840,
                                                                cls:'gridSiugjSeccion',
                                                                useArrows:true,
                                                                autoScroll:false,
                                                                animate:true,
                                                                enableDD:true,
                                                                containerScroll: false,
                                                                root:raiz,
                                                                enableSort:false,
                                                                loader: cargadorArbol,
                                                                rootVisible:false,                                                                
                                                                draggable:false,
                                                                columns:[
                                                                			
                                                                            {
                                                                                header:'Unidades Organigrama',
                                                                                width:800,
                                                                                sortable:false,
                                                                                menuDisabled:true,
                                                                                dataIndex:'text'
                                                                            }/*,
                                                                            
                                                                            {
                                                                                header:'Cve. Departamental',
                                                                                width:180,
                                                                                menuDisabled:true,
                                                                                sortable:false,
                                                                                dataIndex:'cveDeptal'
                                                                            }*/
                                                                         ],
                                                                 listeners: 	{
                                                                                    'render': 	function(tp)
                                                                                    			{
                                                                                        			
                                                                                                 }
                                                                                    }

                                                               
                                                            }
                                                    );
		
        
       

        
        var panel=new Ext.Panel	(
        							{
                                    	id:'divPanel',
                                        border:false,
                                        renderTo:'tblOrganigrama',
                                        items:	[
                                                    organigrama
                                        		]
                                        
                                    }
        						)
        organigrama.on('checkchange',nodoClick);
        organigrama.expandAll();       
}

function nodoClick(nodo,status)
{
	if((status)&&(nodoSel!=nodo))
    {
    	
		nodoSel=nodo;
        gE('adscripcion').value=nodoSel.attributes.codigoU;

        checarNodosHijos(gEx('tOrganigrama').getRootNode(),false);
        nodoSel.getUI().toggleCheck(true);
        nodoSel=null;
        
	}
    
    
	
}

function radioCambioPassChecked(rdo)
{
	var arrRadio=rdo.id.split('_');
    gE('cambiarDatosUsr').value=arrRadio[1];
}

function radioCuentaActivaChecked(rdo)
{
	var arrRadio=rdo.id.split('_');
    gE('cuentaActiva').value=arrRadio[1];
}

function contarOcurrenciasCaraceteresCadena(arrBase,frase)
{
	var contar=0;
	for (var i = 0; i < arrBase.length; i++) 
    {
     	for (var x = 0; x < frase.length; x++) 
        {

     		if(arrBase[i]==frase[x])
            {
    			contar++;
         	}
    	}
 	}
    
    return contar;
 }
 
function crearGridRoles()
{
	var cmbRoles=crearComboExt('cmbRoles',arrRoles,0,0,null,{ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
 	var dsDatos=eval(bD(gE('arrRoles').value));
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idRol'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	chkRow,
														{
															header:'Rol',
															width:400,
															sortable:true,
															dataIndex:'idRol',
                                                            editor:cmbRoles,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrRoles,val);
                                                                    }
                                                                    
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            id:'gRoles',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            hideHeaders:true,
                                                            stripeRows :false,
                                                            renderTo:'gridRoles',
                                                            cls:'gridSiugjFormularios',
                                                            columnLines : false,
                                                            height:260,
                                                            width:650,
                                                            clicksToEdit:1,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../principalPortal/imagesSIUGJ/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar rol',
                                                                            width:325,
                                                                            handler:function()
                                                                            		{
                                                                                    	var reg=crearRegistro([{name: 'idRol'}]);
                                                                                        gEx('gRoles').getStore().add(new reg({idRol:''}));
                                                                                        gEx('gRoles').startEditing(gEx('gRoles').getStore().getCount()-1,1);
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../principalPortal/imagesSIUGJ/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover rol',
                                                                            width:315,
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gRoles').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el rol que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        function resp()
                                                                                        {
                                                                                        	gEx('gRoles').getStore().remove(fila);
                                                                                        }
                                                                                        msgConfirm('¿Est&aacute; seguro de querer removerl el rol seleccionado?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );

	
	return 	tblGrid;	
}
