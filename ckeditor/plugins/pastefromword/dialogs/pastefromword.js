﻿CKEDITOR.dialog.add('pastefromword',function(a){return{title:a.lang.pastefromword.title,minWidth:CKEDITOR.env.ie&&CKEDITOR.env.quirks?370:350,minHeight:CKEDITOR.env.ie&&CKEDITOR.env.quirks?270:260,htmlToLoad:'<!doctype html><script type="text/javascript">window.onload = function(){if ( '+CKEDITOR.env.ie+' ) '+'document.body.contentEditable = "true";'+'else '+'document.designMode = "on";'+'var iframe = new window.parent.CKEDITOR.dom.element( frameElement );'+'var dialog = iframe.getCustomData( "dialog" );'+''+'iframe.getFrameDocument().on( "keydown", function( e )\t\t\t\t\t\t{\t\t\t\t\t\t\tif ( e.data.getKeystroke() == 27 )\t\t\t\t\t\t\t\tdialog.hide();\t\t\t\t\t\t});'+'dialog.fire( "iframeAdded", { iframe : iframe } );'+'};'+'</script><style>body { margin: 3px; height: 95%; } </style><body></body>',cleanWord:function(b,c,d,e){c=c.replace(/<\!--[\s\S]*?-->/g,'');c=c.replace(/<o:p>\s*<\/o:p>/g,'');c=c.replace(/<o:p>[\s\S]*?<\/o:p>/g,'&nbsp;');c=c.replace(/\s*mso-[^:]+:[^;"]+;?/gi,'');c=c.replace(/\s*MARGIN: 0(?:cm|in) 0(?:cm|in) 0pt\s*;/gi,'');c=c.replace(/\s*MARGIN: 0(?:cm|in) 0(?:cm|in) 0pt\s*"/gi,'"');c=c.replace(/\s*TEXT-INDENT: 0cm\s*;/gi,'');c=c.replace(/\s*TEXT-INDENT: 0cm\s*"/gi,'"');c=c.replace(/\s*TEXT-ALIGN: [^\s;]+;?"/gi,'"');c=c.replace(/\s*PAGE-BREAK-BEFORE: [^\s;]+;?"/gi,'"');c=c.replace(/\s*FONT-VARIANT: [^\s;]+;?"/gi,'"');c=c.replace(/\s*tab-stops:[^;"]*;?/gi,'');c=c.replace(/\s*tab-stops:[^"]*/gi,'');if(d){c=c.replace(/\s*face="[^"]*"/gi,'');c=c.replace(/\s*face=[^ >]*/gi,'');c=c.replace(/\s*FONT-FAMILY:[^;"]*;?/gi,'');}c=c.replace(/<(\w[^>]*) class=([^ |>]*)([^>]*)/gi,'<$1$3');if(e)c=c.replace(/<(\w[^>]*) style="([^\"]*)"([^>]*)/gi,'<$1$3');c=c.replace(/<STYLE[^>]*>[\s\S]*?<\/STYLE[^>]*>/gi,'');c=c.replace(/<(?:META|LINK)[^>]*>\s*/gi,'');c=c.replace(/\s*style="\s*"/gi,'');c=c.replace(/<SPAN\s*[^>]*>\s*&nbsp;\s*<\/SPAN>/gi,'&nbsp;');c=c.replace(/<SPAN\s*[^>]*><\/SPAN>/gi,'');c=c.replace(/<(\w[^>]*) lang=([^ |>]*)([^>]*)/gi,'<$1$3');c=c.replace(/<SPAN\s*>([\s\S]*?)<\/SPAN>/gi,'$1');c=c.replace(/<FONT\s*>([\s\S]*?)<\/FONT>/gi,'$1');c=c.replace(/<\\?\?xml[^>]*>/gi,'');c=c.replace(/<w:[^>]*>[\s\S]*?<\/w:[^>]*>/gi,'');c=c.replace(/<\/?\w+:[^>]*>/gi,'');c=c.replace(/<(U|I|STRIKE)>&nbsp;<\/\1>/g,'&nbsp;');c=c.replace(/<H\d>\s*<\/H\d>/gi,'');c=c.replace(/<(\w+)[^>]*\sstyle="[^"]*DISPLAY\s?:\s?none[\s\S]*?<\/\1>/ig,'');c=c.replace(/<(\w[^>]*) language=([^ |>]*)([^>]*)/gi,'<$1$3');c=c.replace(/<(\w[^>]*) onmouseover="([^\"]*)"([^>]*)/gi,'<$1$3');c=c.replace(/<(\w[^>]*) onmouseout="([^\"]*)"([^>]*)/gi,'<$1$3');
if(b.config.pasteFromWordKeepsStructure){c=c.replace(/<H(\d)([^>]*)>/gi,'<h$1>');c=c.replace(/<(H\d)><FONT[^>]*>([\s\S]*?)<\/FONT><\/\1>/gi,'<$1>$2</$1>');c=c.replace(/<(H\d)><EM>([\s\S]*?)<\/EM><\/\1>/gi,'<$1>$2</$1>');}else{c=c.replace(/<H1([^>]*)>/gi,'<div$1><b><font size="6">');c=c.replace(/<H2([^>]*)>/gi,'<div$1><b><font size="5">');c=c.replace(/<H3([^>]*)>/gi,'<div$1><b><font size="4">');c=c.replace(/<H4([^>]*)>/gi,'<div$1><b><font size="3">');c=c.replace(/<H5([^>]*)>/gi,'<div$1><b><font size="2">');c=c.replace(/<H6([^>]*)>/gi,'<div$1><b><font size="1">');c=c.replace(/<\/H\d>/gi,'</font></b></div>');var f=new RegExp('(<P)([^>]*>[\\s\\S]*?)(</P>)','gi');c=c.replace(f,'<div$2</div>');c=c.replace(/<([^\s>]+)(\s[^>]*)?>\s*<\/\1>/g,'');c=c.replace(/<([^\s>]+)(\s[^>]*)?>\s*<\/\1>/g,'');c=c.replace(/<([^\s>]+)(\s[^>]*)?>\s*<\/\1>/g,'');}return c;},onShow:function(){var h=this;if(CKEDITOR.env.ie)h.getParentEditor().document.getBody().$.contentEditable='false';h.parts.dialog.$.offsetHeight;var b=h.getContentElement('general','editing_area').getElement(),c=CKEDITOR.dom.element.createFromHtml('<iframe src="javascript:void(0)" frameborder="0" allowtransparency="1"></iframe>'),d=h.getParentEditor().lang;c.setStyles({width:'346px',height:'152px','background-color':'white',border:'1px solid black'});c.setCustomData('dialog',h);var e=d.editorTitle.replace('%1',d.pastefromword.title);if(CKEDITOR.env.ie)b.setHtml('<legend style="position:absolute;top:-1000000px;left:-1000000px;">'+CKEDITOR.tools.htmlEncode(e)+'</legend>');else{b.setHtml('');b.setAttributes({role:'region',title:e});c.setAttributes({role:'region',title:' '});}b.append(c);if(CKEDITOR.env.ie)b.setStyle('height',c.$.offsetHeight+2+'px');var f=CKEDITOR.env.ie&&document.domain!=window.location.hostname;if(f){CKEDITOR._cke_htmlToLoad=h.definition.htmlToLoad;c.setAttribute('src','javascript:void( (function(){document.open();document.domain="'+document.domain+'";'+'document.write( window.parent.CKEDITOR._cke_htmlToLoad );'+'delete window.parent.CKEDITOR._cke_htmlToLoad;'+'document.close();'+'})() )');}else{var g=c.$.contentWindow.document;g.open();g.write(h.definition.htmlToLoad);g.close();}},onOk:function(){var b=this.getContentElement('general','editing_area').getElement(),c=b.getElementsByTag('iframe').getItem(0),d=this.getParentEditor(),e=this.definition.cleanWord(d,c.$.contentWindow.document.body.innerHTML,this.getValueOf('general','ignoreFontFace'),this.getValueOf('general','removeStyle'));setTimeout(function(){d.insertHtml(e);
},0);},onHide:function(){if(CKEDITOR.env.ie)this.getParentEditor().document.getBody().$.contentEditable='true';},onLoad:function(){if((CKEDITOR.env.ie7Compat||CKEDITOR.env.ie6Compat)&&a.lang.dir=='rtl')this.parts.contents.setStyle('overflow','hidden');},contents:[{id:'general',label:a.lang.pastefromword.title,elements:[{type:'html',style:'white-space:normal;width:346px;display:block',onShow:function(){if(CKEDITOR.env.webkit)this.getElement().getAscendant('table').setStyle('table-layout','fixed');},html:a.lang.pastefromword.advice},{type:'html',id:'editing_area',style:'width: 100%; height: 100%;',html:'<fieldset></fieldset>',focus:function(){var b=this.getElement(),c=b.getElementsByTag('iframe');if(c.count()<1)return;c=c.getItem(0);setTimeout(function(){c.$.contentWindow.focus();},500);}},{type:'vbox',padding:0,children:[{type:'checkbox',id:'ignoreFontFace',label:a.lang.pastefromword.ignoreFontFace,'default':a.config.pasteFromWordIgnoreFontFace},{type:'checkbox',id:'removeStyle',label:a.lang.pastefromword.removeStyle,'default':a.config.pasteFromWordRemoveStyle}]}]}]};});
