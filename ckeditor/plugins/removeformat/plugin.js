﻿CKEDITOR.plugins.add('removeformat',{requires:['selection'],init:function(a){a.addCommand('removeFormat',CKEDITOR.plugins.removeformat.commands.removeformat);a.ui.addButton('RemoveFormat',{label:a.lang.removeFormat,command:'removeFormat'});a._.removeFormat={filters:[]};}});CKEDITOR.plugins.removeformat={commands:{removeformat:{exec:function(a){var b=a._.removeFormatRegex||(a._.removeFormatRegex=new RegExp('^(?:'+a.config.removeFormatTags.replace(/,/g,'|')+')$','i')),c=a._.removeAttributes||(a._.removeAttributes=a.config.removeFormatAttributes.split(',')),d=CKEDITOR.plugins.removeformat.filter,e=a.getSelection().getRanges(1),f=e.createIterator(),g;while(g=f.getNextRange()){if(!g.collapsed)g.enlarge(CKEDITOR.ENLARGE_ELEMENT);var h=g.createBookmark(),i=h.startNode,j=h.endNode,k,l=function(n){var o=new CKEDITOR.dom.elementPath(n),p=o.elements;for(var q=1,r;r=p[q];q++){if(r.equals(o.block)||r.equals(o.blockLimit))break;if(b.test(r.getName())&&d(a,r))n.breakParent(r);}};l(i);if(j){l(j);k=i.getNextSourceNode(true,CKEDITOR.NODE_ELEMENT);while(k){if(k.equals(j))break;var m=k.getNextSourceNode(false,CKEDITOR.NODE_ELEMENT);if(!(k.getName()=='img'&&k.data('cke-realelement'))&&d(a,k))if(b.test(k.getName()))k.remove(1);else{k.removeAttributes(c);a.fire('removeFormatCleanup',k);}k=m;}}g.moveToBookmark(h);}a.getSelection().selectRanges(e);}}},filter:function(a,b){var c=a._.removeFormat.filters;for(var d=0;d<c.length;d++){if(c[d](b)===false)return false;}return true;}};CKEDITOR.editor.prototype.addRemoveFormatFilter=function(a){this._.removeFormat.filters.push(a);};CKEDITOR.config.removeFormatTags='b,big,code,del,dfn,em,font,i,ins,kbd,q,samp,small,span,strike,strong,sub,sup,tt,u,var';CKEDITOR.config.removeFormatAttributes='class,style,lang,width,height,align,hspace,valign';
