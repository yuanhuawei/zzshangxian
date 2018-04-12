﻿(function(){var a=/^(?:td|th)$/;function b(u){var v=u.createBookmarks(),w=u.getRanges(),x=[],y={};function z(H){if(x.length>0)return;if(H.type==CKEDITOR.NODE_ELEMENT&&a.test(H.getName())&&!H.getCustomData('selected_cell')){CKEDITOR.dom.element.setMarker(y,H,'selected_cell',true);x.push(H);}};for(var A=0;A<w.length;A++){var B=w[A];if(B.collapsed){var C=B.getCommonAncestor(),D=C.getAscendant('td',true)||C.getAscendant('th',true);if(D)x.push(D);}else{var E=new CKEDITOR.dom.walker(B),F;E.guard=z;while(F=E.next()){var G=F.getParent();if(G&&a.test(G.getName())&&!G.getCustomData('selected_cell')){CKEDITOR.dom.element.setMarker(y,G,'selected_cell',true);x.push(G);}}}}CKEDITOR.dom.element.clearAllMarkers(y);u.selectBookmarks(v);return x;};function c(u){var v=0,w=u.length-1,x={},y,z,A;while(y=u[v++])CKEDITOR.dom.element.setMarker(x,y,'delete_cell',true);v=0;while(y=u[v++]){if((z=y.getPrevious())&&!z.getCustomData('delete_cell')||(z=y.getNext())&&!z.getCustomData('delete_cell')){CKEDITOR.dom.element.clearAllMarkers(x);return z;}}CKEDITOR.dom.element.clearAllMarkers(x);A=u[0].getParent();if(A=A.getPrevious())return A.getLast();A=u[w].getParent();if(A=A.getNext())return A.getChild(0);return null;};function d(u,v){var w=b(u),x=w[0],y=x.getAscendant('table'),z=x.getDocument(),A=w[0].getParent(),B=A.$.rowIndex,C=w[w.length-1],D=C.getParent().$.rowIndex+C.$.rowSpan-1,E=new CKEDITOR.dom.element(y.$.rows[D]),F=v?B:D,G=v?A:E,H=CKEDITOR.tools.buildTableMap(y),I=H[F],J=v?H[F-1]:H[F+1],K=H[0].length,L=z.createElement('tr');for(var M=0;M<K;M++){var N;if(I[M].rowSpan>1&&J&&I[M]==J[M]){N=I[M];N.rowSpan+=1;}else{N=new CKEDITOR.dom.element(I[M]).clone();N.removeAttribute('rowSpan');!CKEDITOR.env.ie&&N.appendBogus();L.append(N);N=N.$;}M+=N.colSpan-1;}v?L.insertBefore(G):L.insertAfter(G);};function e(u){if(u instanceof CKEDITOR.dom.selection){var v=b(u),w=v[0],x=w.getAscendant('table'),y=CKEDITOR.tools.buildTableMap(x),z=v[0].getParent(),A=z.$.rowIndex,B=v[v.length-1],C=B.getParent().$.rowIndex+B.$.rowSpan-1,D=[];for(var E=A;E<=C;E++){var F=y[E],G=new CKEDITOR.dom.element(x.$.rows[E]);for(var H=0;H<F.length;H++){var I=new CKEDITOR.dom.element(F[H]),J=I.getParent().$.rowIndex;if(I.$.rowSpan==1)I.remove();else{I.$.rowSpan-=1;if(J==E){var K=y[E+1];K[H-1]?I.insertAfter(new CKEDITOR.dom.element(K[H-1])):new CKEDITOR.dom.element(x.$.rows[E+1]).append(I,1);}}H+=I.$.colSpan-1;}D.push(G);}var L=x.$.rows,M=new CKEDITOR.dom.element(L[A]||L[A-1]||x.$.parentNode);for(E=D.length;E>=0;E--)e(D[E]);return M;
}else if(u instanceof CKEDITOR.dom.element){x=u.getAscendant('table');if(x.$.rows.length==1)x.remove();else u.remove();}return null;};function f(u,v){var w=u.getParent(),x=w.$.cells,y=0;for(var z=0;z<x.length;z++){var A=x[z];y+=v?1:A.colSpan;if(A==u.$)break;}return y-1;};function g(u,v){var w=v?Infinity:0;for(var x=0;x<u.length;x++){var y=f(u[x],v);if(v?y<w:y>w)w=y;}return w;};function h(u,v){var w=b(u),x=w[0],y=x.getAscendant('table'),z=g(w,1),A=g(w),B=v?z:A,C=CKEDITOR.tools.buildTableMap(y),D=[],E=[],F=C.length;for(var G=0;G<F;G++){D.push(C[G][B]);var H=v?C[G][B-1]:C[G][B+1];H&&E.push(H);}for(G=0;G<F;G++){var I;if(D[G].colSpan>1&&E.length&&E[G]==D[G]){I=D[G];I.colSpan+=1;}else{I=new CKEDITOR.dom.element(D[G]).clone();I.removeAttribute('colSpan');!CKEDITOR.env.ie&&I.appendBogus();I[v?'insertBefore':'insertAfter'].call(I,new CKEDITOR.dom.element(D[G]));I=I.$;}G+=I.rowSpan-1;}};function i(u){var v=b(u),w=v[0],x=v[v.length-1],y=w.getAscendant('table'),z=CKEDITOR.tools.buildTableMap(y),A,B,C=[];for(var D=0,E=z.length;D<E;D++)for(var F=0,G=z[D].length;F<G;F++){if(z[D][F]==w.$)A=F;if(z[D][F]==x.$)B=F;}for(D=A;D<=B;D++)for(F=0;F<z.length;F++){var H=z[F],I=new CKEDITOR.dom.element(y.$.rows[F]),J=new CKEDITOR.dom.element(H[D]);if(J.$.colSpan==1)J.remove();else J.$.colSpan-=1;F+=J.$.rowSpan-1;if(!I.$.cells.length)C.push(I);}var K=y.$.rows[0]&&y.$.rows[0].cells,L=new CKEDITOR.dom.element(K[A]||(A?K[A-1]:y.$.parentNode));if(C.length==E)y.remove();return L;};function j(u){var v=[],w=u[0]&&u[0].getAscendant('table'),x,y,z,A;for(x=0,y=u.length;x<y;x++)v.push(u[x].$.cellIndex);v.sort();for(x=1,y=v.length;x<y;x++){if(v[x]-v[x-1]>1){z=v[x-1]+1;break;}}if(!z)z=v[0]>0?v[0]-1:v[v.length-1]+1;var B=w.$.rows;for(x=0,y=B.length;x<y;x++){A=B[x].cells[z];if(A)break;}return A?new CKEDITOR.dom.element(A):w.getPrevious();};function k(u,v){var w=u.getStartElement(),x=w.getAscendant('td',1)||w.getAscendant('th',1);if(!x)return;var y=x.clone();if(!CKEDITOR.env.ie)y.appendBogus();if(v)y.insertBefore(x);else y.insertAfter(x);};function l(u){if(u instanceof CKEDITOR.dom.selection){var v=b(u),w=v[0]&&v[0].getAscendant('table'),x=c(v);for(var y=v.length-1;y>=0;y--)l(v[y]);if(x)n(x,true);else if(w)w.remove();}else if(u instanceof CKEDITOR.dom.element){var z=u.getParent();if(z.getChildCount()==1)z.remove();else u.remove();}};function m(u){var v=u.getBogus();v&&v.remove();u.trim();};function n(u,v){var w=new CKEDITOR.dom.range(u.getDocument());if(!w['moveToElementEdit'+(v?'End':'Start')](u)){w.selectNodeContents(u);
w.collapse(v?false:true);}w.select(true);};function o(u,v,w){var x=u[v];if(typeof w=='undefined')return x;for(var y=0;x&&y<x.length;y++){if(w.is&&x[y]==w.$)return y;else if(y==w)return new CKEDITOR.dom.element(x[y]);}return w.is?-1:null;};function p(u,v,w){var x=[];for(var y=0;y<u.length;y++){var z=u[y];if(typeof w=='undefined')x.push(z[v]);else if(w.is&&z[v]==w.$)return y;else if(y==w)return new CKEDITOR.dom.element(z[v]);}return typeof w=='undefined'?x:w.is?-1:null;};function q(u,v,w){var x=b(u),y;if((v?x.length!=1:x.length<2)||(y=u.getCommonAncestor())&&y.type==CKEDITOR.NODE_ELEMENT&&y.is('table'))return false;var z,A=x[0],B=A.getAscendant('table'),C=CKEDITOR.tools.buildTableMap(B),D=C.length,E=C[0].length,F=A.getParent().$.rowIndex,G=o(C,F,A);if(v){var H;try{var I=parseInt(A.getAttribute('rowspan'),10)||1,J=parseInt(A.getAttribute('colspan'),10)||1;H=C[v=='up'?F-I:v=='down'?F+I:F][v=='left'?G-J:v=='right'?G+J:G];}catch(ab){return false;}if(!H||A.$==H)return false;x[v=='up'||v=='left'?'unshift':'push'](new CKEDITOR.dom.element(H));}var K=A.getDocument(),L=F,M=0,N=0,O=!w&&new CKEDITOR.dom.documentFragment(K),P=0;for(var Q=0;Q<x.length;Q++){z=x[Q];var R=z.getParent(),S=z.getFirst(),T=z.$.colSpan,U=z.$.rowSpan,V=R.$.rowIndex,W=o(C,V,z);P+=T*U;N=Math.max(N,W-G+T);M=Math.max(M,V-F+U);if(!w){if(m(z),z.getChildren().count()){if(V!=L&&S&&!(S.isBlockBoundary&&S.isBlockBoundary({br:1}))){var X=O.getLast(CKEDITOR.dom.walker.whitespaces(true));if(X&&!(X.is&&X.is('br')))O.append('br');}z.moveChildren(O);}Q?z.remove():z.setHtml('');}L=V;}if(!w){O.moveChildren(A);if(!CKEDITOR.env.ie)A.appendBogus();if(N>=E)A.removeAttribute('rowSpan');else A.$.rowSpan=M;if(M>=D)A.removeAttribute('colSpan');else A.$.colSpan=N;var Y=new CKEDITOR.dom.nodeList(B.$.rows),Z=Y.count();for(Q=Z-1;Q>=0;Q--){var aa=Y.getItem(Q);if(!aa.$.cells.length){aa.remove();Z++;continue;}}return A;}else return M*N==P;};function r(u,v){var w=b(u);if(w.length>1)return false;else if(v)return true;var x=w[0],y=x.getParent(),z=y.getAscendant('table'),A=CKEDITOR.tools.buildTableMap(z),B=y.$.rowIndex,C=o(A,B,x),D=x.$.rowSpan,E,F,G,H;if(D>1){F=Math.ceil(D/2);G=Math.floor(D/2);H=B+F;var I=new CKEDITOR.dom.element(z.$.rows[H]),J=o(A,H),K;E=x.clone();for(var L=0;L<J.length;L++){K=J[L];if(K.parentNode==I.$&&L>C){E.insertBefore(new CKEDITOR.dom.element(K));break;}else K=null;}if(!K)I.append(E,true);}else{G=F=1;I=y.clone();I.insertAfter(y);I.append(E=x.clone());var M=o(A,B);for(var N=0;N<M.length;N++)M[N].rowSpan++;}if(!CKEDITOR.env.ie)E.appendBogus();
x.$.rowSpan=F;E.$.rowSpan=G;if(F==1)x.removeAttribute('rowSpan');if(G==1)E.removeAttribute('rowSpan');return E;};function s(u,v){var w=b(u);if(w.length>1)return false;else if(v)return true;var x=w[0],y=x.getParent(),z=y.getAscendant('table'),A=CKEDITOR.tools.buildTableMap(z),B=y.$.rowIndex,C=o(A,B,x),D=x.$.colSpan,E,F,G;if(D>1){F=Math.ceil(D/2);G=Math.floor(D/2);}else{G=F=1;var H=p(A,C);for(var I=0;I<H.length;I++)H[I].colSpan++;}E=x.clone();E.insertAfter(x);if(!CKEDITOR.env.ie)E.appendBogus();x.$.colSpan=F;E.$.colSpan=G;if(F==1)x.removeAttribute('colSpan');if(G==1)E.removeAttribute('colSpan');return E;};var t={thead:1,tbody:1,tfoot:1,td:1,tr:1,th:1};CKEDITOR.plugins.tabletools={init:function(u){var v=u.lang.table;u.addCommand('cellProperties',new CKEDITOR.dialogCommand('cellProperties'));CKEDITOR.dialog.add('cellProperties',this.path+'dialogs/tableCell.js');u.addCommand('tableDelete',{exec:function(w){var x=w.getSelection(),y=x&&x.getStartElement(),z=y&&y.getAscendant('table',1);if(!z)return;var A=z.getParent();if(A.getChildCount()==1&&!A.is('body','td','th'))z=A;var B=new CKEDITOR.dom.range(w.document);B.moveToPosition(z,CKEDITOR.POSITION_BEFORE_START);z.remove();B.select();}});u.addCommand('rowDelete',{exec:function(w){var x=w.getSelection();n(e(x));}});u.addCommand('rowInsertBefore',{exec:function(w){var x=w.getSelection();d(x,true);}});u.addCommand('rowInsertAfter',{exec:function(w){var x=w.getSelection();d(x);}});u.addCommand('columnDelete',{exec:function(w){var x=w.getSelection(),y=i(x);y&&n(y,true);}});u.addCommand('columnInsertBefore',{exec:function(w){var x=w.getSelection();h(x,true);}});u.addCommand('columnInsertAfter',{exec:function(w){var x=w.getSelection();h(x);}});u.addCommand('cellDelete',{exec:function(w){var x=w.getSelection();l(x);}});u.addCommand('cellMerge',{exec:function(w){n(q(w.getSelection()),true);}});u.addCommand('cellMergeRight',{exec:function(w){n(q(w.getSelection(),'right'),true);}});u.addCommand('cellMergeDown',{exec:function(w){n(q(w.getSelection(),'down'),true);}});u.addCommand('cellVerticalSplit',{exec:function(w){n(r(w.getSelection()));}});u.addCommand('cellHorizontalSplit',{exec:function(w){n(s(w.getSelection()));}});u.addCommand('cellInsertBefore',{exec:function(w){var x=w.getSelection();k(x,true);}});u.addCommand('cellInsertAfter',{exec:function(w){var x=w.getSelection();k(x);}});if(u.addMenuItems)u.addMenuItems({tablecell:{label:v.cell.menu,group:'tablecell',order:1,getItems:function(){var w=u.getSelection(),x=b(w);return{tablecell_insertBefore:CKEDITOR.TRISTATE_OFF,tablecell_insertAfter:CKEDITOR.TRISTATE_OFF,tablecell_delete:CKEDITOR.TRISTATE_OFF,tablecell_merge:q(w,null,true)?CKEDITOR.TRISTATE_OFF:CKEDITOR.TRISTATE_DISABLED,tablecell_merge_right:q(w,'right',true)?CKEDITOR.TRISTATE_OFF:CKEDITOR.TRISTATE_DISABLED,tablecell_merge_down:q(w,'down',true)?CKEDITOR.TRISTATE_OFF:CKEDITOR.TRISTATE_DISABLED,tablecell_split_vertical:r(w,true)?CKEDITOR.TRISTATE_OFF:CKEDITOR.TRISTATE_DISABLED,tablecell_split_horizontal:s(w,true)?CKEDITOR.TRISTATE_OFF:CKEDITOR.TRISTATE_DISABLED,tablecell_properties:x.length>0?CKEDITOR.TRISTATE_OFF:CKEDITOR.TRISTATE_DISABLED};
}},tablecell_insertBefore:{label:v.cell.insertBefore,group:'tablecell',command:'cellInsertBefore',order:5},tablecell_insertAfter:{label:v.cell.insertAfter,group:'tablecell',command:'cellInsertAfter',order:10},tablecell_delete:{label:v.cell.deleteCell,group:'tablecell',command:'cellDelete',order:15},tablecell_merge:{label:v.cell.merge,group:'tablecell',command:'cellMerge',order:16},tablecell_merge_right:{label:v.cell.mergeRight,group:'tablecell',command:'cellMergeRight',order:17},tablecell_merge_down:{label:v.cell.mergeDown,group:'tablecell',command:'cellMergeDown',order:18},tablecell_split_horizontal:{label:v.cell.splitHorizontal,group:'tablecell',command:'cellHorizontalSplit',order:19},tablecell_split_vertical:{label:v.cell.splitVertical,group:'tablecell',command:'cellVerticalSplit',order:20},tablecell_properties:{label:v.cell.title,group:'tablecellproperties',command:'cellProperties',order:21},tablerow:{label:v.row.menu,group:'tablerow',order:1,getItems:function(){return{tablerow_insertBefore:CKEDITOR.TRISTATE_OFF,tablerow_insertAfter:CKEDITOR.TRISTATE_OFF,tablerow_delete:CKEDITOR.TRISTATE_OFF};}},tablerow_insertBefore:{label:v.row.insertBefore,group:'tablerow',command:'rowInsertBefore',order:5},tablerow_insertAfter:{label:v.row.insertAfter,group:'tablerow',command:'rowInsertAfter',order:10},tablerow_delete:{label:v.row.deleteRow,group:'tablerow',command:'rowDelete',order:15},tablecolumn:{label:v.column.menu,group:'tablecolumn',order:1,getItems:function(){return{tablecolumn_insertBefore:CKEDITOR.TRISTATE_OFF,tablecolumn_insertAfter:CKEDITOR.TRISTATE_OFF,tablecolumn_delete:CKEDITOR.TRISTATE_OFF};}},tablecolumn_insertBefore:{label:v.column.insertBefore,group:'tablecolumn',command:'columnInsertBefore',order:5},tablecolumn_insertAfter:{label:v.column.insertAfter,group:'tablecolumn',command:'columnInsertAfter',order:10},tablecolumn_delete:{label:v.column.deleteColumn,group:'tablecolumn',command:'columnDelete',order:15}});if(u.contextMenu)u.contextMenu.addListener(function(w,x){if(!w||w.isReadOnly())return null;while(w){if(w.getName() in t)return{tablecell:CKEDITOR.TRISTATE_OFF,tablerow:CKEDITOR.TRISTATE_OFF,tablecolumn:CKEDITOR.TRISTATE_OFF};w=w.getParent();}return null;});},getSelectedCells:b};CKEDITOR.plugins.add('tabletools',CKEDITOR.plugins.tabletools);})();CKEDITOR.tools.buildTableMap=function(a){var b=a.$.rows,c=-1,d=[];for(var e=0;e<b.length;e++){c++;!d[c]&&(d[c]=[]);var f=-1;for(var g=0;g<b[e].cells.length;g++){var h=b[e].cells[g];f++;while(d[c][f])f++;
var i=isNaN(h.colSpan)?1:h.colSpan,j=isNaN(h.rowSpan)?1:h.rowSpan;for(var k=0;k<j;k++){if(!d[c+k])d[c+k]=[];for(var l=0;l<i;l++)d[c+k][f+l]=b[e].cells[g];}f+=i-1;}}return d;};
