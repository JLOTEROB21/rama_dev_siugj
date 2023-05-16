CKEDITOR.editorConfig = function( config ) 
{
	config.allowedContent=true;
	config.extraPlugins= 'pSaveFirmaElectronica,pSavePDF,cwjdsjcsconfineselection';
	config.readOnly = true;

	config.toolbarGroups = [
							
							{ name: 'others', groups: [ 'others' ] },
							{ name: 'plugins', groups: ['pSaveFirmaElectronica,pSavePDF']} 
						];

	config.removeButtons = 'Save,NewPage,Preview,Print,Templates,Replace,Find,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Link,Unlink,Anchor,Image,Flash,HorizontalRule,Smiley,PageBreak,Iframe,Maximize,ShowBlocks,About,SelectAll';
};
