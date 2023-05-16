<?php session_start();
include("conexionBD.php"); 
include("configurarIdiomaJS.php");

?>
Ext.onReady(function(){})//Este evento se dispara cuando la pagina se carga
	   
		

function mostrarPermisos(idCheck,permisos)
{
	win = new Ext.Window({
	
			layout      : 'fit',
			width       : 330,
			height      : 150,
			closeAction :'hide',
			plain       : true,
			items 		: [new Ext.Panel ({
								title		: 'Permisos',
								border		: false,
								layout		: 'absolute',
								region		:'center',		
								//baseCls: 'x-plain',
								defaultType :'textfield',
								items: [						
												{
													x:30,
													y:20,
													fieldLabel: '',
													boxLabel: 'Agregar',
													name: 'publico',
													xtype:'checkbox',
													id:'chkAgregar'
												},
												{
													x:120,
													y:20,
													fieldLabel: '',
													boxLabel: 'Modificar',
													name: 'publico',
													xtype:'checkbox',
													id:'chkModificar'
												},
												
												{
													x:210,
													y:20,
													labelSeparator: '',
													boxLabel: 'Eliminar',
													name: 'privado',
													xtype:'checkbox',
													id:'chkElminar'
												}
										]
						})],
			
			
			
				buttons: [{
					text     : 'Aceptar',
					
					id: 'mb8',
					handler: 
						function ()
                        {
                            var result='C';
                            var agreg=Ext.getCmp ('chkAgregar');
                            var modif=Ext.getCmp ('chkModificar');
                            var elim=Ext.getCmp ('chkElminar');
                            if(agreg.getValue()==true)
                            {
                                result=result+'A';
                            }
                            if(modif.getValue()==true)
                            {
                                result=result+'M';
                            }
                            if(elim.getValue()==true)
                            {
                                result=result+'E';
                            }
                            if(result=='')
                            {
                            	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["lblDebeSelUnPermiso"]?>');
                            	return;
                            }
                            var idCh='h'+idCheck;
                            var idlb='l'+idCheck; 	
                            gE(idCh).value=result;
                            gE(idlb).innerHTML='<br><a href="javascript: mostrarPermisos(\''+idCheck+'\',\''+result+'\')">Permisos: '+result+' </a>';				
                            win.hide();
					
						}
				},
			
				{
					text     : 'Close',
					handler  : function()
                    {
						win.hide();
					}
			}]			
		});
		win.show();
		if (permisos!=null)
		{
				
				if(permisos.indexOf('A')!=-1)
				{
					Ext.getCmp('chkAgregar').setValue(true);
				}  
				if(permisos.indexOf('M')!=-1)
				{
					Ext.getCmp('chkModificar').setValue(true);
				}  
				if(permisos.indexOf('E')!=-1)
				{
					Ext.getCmp('chkElminar').setValue(true);
				}  
		
		}
		
		
	
	
}

function checkClick(obj)
{
		if(obj.checked==true)
        	mostrarPermisos(obj.id);
		else 
        {
            var idCh='h'+obj.id;
            var idlb='l'+obj.id; 	
            gE(idCh).value='';
            gE(idlb).innerHTML='';	
		}
}
