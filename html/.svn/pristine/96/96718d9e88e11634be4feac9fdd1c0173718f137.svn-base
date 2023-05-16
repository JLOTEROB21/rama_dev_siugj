Ext.onReady(function(){})//Este evento se dispara cuando la pagina se carga
	   
		

function mostrarVentana()
{
	win = new Ext.Window({
	
			layout      : 'fit',
			width       : 600,
			height      : 300,
			closeAction :'hide',
			plain       : true,
			items 		: [new Ext.TabPanel({
			
							items: [new Ext.Panel ({
								title		: 'Datos Generales',
								border		: false,
								layout		: 'absolute',
								region		:'center',		
								//baseCls: 'x-plain',
								defaultType :'textfield',
								items: [
												{
													
													x:10,
													y:10,
													text:'Login',
													xtype:'label'
													
												},
												
												{
													x:30,
													y:30,
													hideLabel : true, 
													xtype:'textfield',
													id:'log'
												},
												
												{
													x:50,
													y:50,
													text:'Password',
													xtype:'label'
													
												},
												
												{
													x:30,
													y:30,
													hideLabel : true, 
													fieldLabel:'Etiqueta',
													xtype:'textfield',
													id:'passw'
												},
												
												{
													fieldLabel: 'Tipo de Usuario',
													boxLabel: 'Publico',
													name: 'publico',
													xtype:'checkbox'
												},
												
												{
													labelSeparator: '',
													boxLabel: 'Privado',
													name: 'privado',
													xtype:'checkbox'
												}
										]
						})]
			
			})],
			
			
				buttons: [{
					text     : 'Submit',
					//disabled : true,
					id: 'mb8',
					handler: function (){
					Ext.MessageBox.alert('Status', 'Changes saved successfully.');
					}
				},
			
				{
					text     : 'Close',
					handler  : function(){
					win.hide();
				}
			}]			
		});
	
	win.show();
	
	//;
}
