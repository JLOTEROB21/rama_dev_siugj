CKEDITOR.editorConfig = function( config ) 
{
	config.extraPlugins= 'pMarcador,pPrintDocument,cwjdsjcsconfineselection';
	config.allowedContent=true;
	config.removePlugins = 'menubutton,contextmenu,pSaveFirmaElectronica';
	config.toolbarGroups = [
							{ name: 'document', groups: ['pMarcador', 'Source','mode', 'document', 'doctools' ] },
							{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
							{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
							{ name: 'forms', groups: [ 'forms' ] },
							{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
							{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
							{ name: 'links', groups: [ 'links' ] },
							{ name: 'insert', groups: [ 'insert' ] },
							{ name: 'styles', groups: [ 'styles' ] },
							{ name: 'colors', groups: [ 'colors' ] },
							{ name: 'tools', groups: [ 'tools' ] },
							{ name: 'others', groups: [ 'others' ] },
							{ name: 'about', groups: [ 'about' ] },
							{ name: 'plugins', groups: ['pPrintDocument']} 
						];

	config.removeButtons = 'pSaveFirmaElectronica,Save,NewPage,Preview,Templates,Replace,Find,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Link,Unlink,Anchor,Image,Flash,HorizontalRule,Smiley,PageBreak,Iframe,Maximize,ShowBlocks,About,SelectAll';
};
