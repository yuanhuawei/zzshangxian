﻿(function(){CKEDITOR.plugins.add('div',{requires:['editingblock','domiterator','styles'],init:function(a){var b=a.lang.div;a.addCommand('creatediv',new CKEDITOR.dialogCommand('creatediv'));a.addCommand('editdiv',new CKEDITOR.dialogCommand('editdiv'));a.addCommand('removediv',{exec:function(c){var d=c.getSelection(),e=d&&d.getRanges(),f,g=d.createBookmarks(),h,i=[];function j(l){var m=new CKEDITOR.dom.elementPath(l),n=m.blockLimit,o=n.is('div')&&n;if(o&&!o.data('cke-div-added')){i.push(o);o.data('cke-div-added');}};for(var k=0;k<e.length;k++){f=e[k];if(f.collapsed)j(d.getStartElement());else{h=new CKEDITOR.dom.walker(f);h.evaluator=j;h.lastForward();}}for(k=0;k<i.length;k++)i[k].remove(true);d.selectBookmarks(g);}});a.ui.addButton('CreateDiv',{label:b.toolbar,command:'creatediv'});if(a.addMenuItems){a.addMenuItems({editdiv:{label:b.edit,command:'editdiv',group:'div',order:1},removediv:{label:b.remove,command:'removediv',group:'div',order:5}});if(a.contextMenu)a.contextMenu.addListener(function(c,d){if(!c||c.isReadOnly())return null;var e=new CKEDITOR.dom.elementPath(c),f=e.blockLimit;if(f&&f.getAscendant('div',true))return{editdiv:CKEDITOR.TRISTATE_OFF,removediv:CKEDITOR.TRISTATE_OFF};return null;});}CKEDITOR.dialog.add('creatediv',this.path+'dialogs/div.js');CKEDITOR.dialog.add('editdiv',this.path+'dialogs/div.js');}});})();
