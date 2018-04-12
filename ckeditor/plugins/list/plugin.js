﻿(function(){var a={ol:1,ul:1},b=/^[\n\r\t ]*$/,c=CKEDITOR.dom.walker.whitespaces(),d=CKEDITOR.dom.walker.bookmark(),e=function(s){return!(c(s)||d(s));};CKEDITOR.plugins.list={listToArray:function(s,t,u,v,w){if(!a[s.getName()])return[];if(!v)v=0;if(!u)u=[];for(var x=0,y=s.getChildCount();x<y;x++){var z=s.getChild(x);if(z.type==CKEDITOR.NODE_ELEMENT&&z.getName() in CKEDITOR.dtd.$list)CKEDITOR.plugins.list.listToArray(z,t,u,v+1);if(z.$.nodeName.toLowerCase()!='li')continue;var A={parent:s,indent:v,element:z,contents:[]};if(!w){A.grandparent=s.getParent();if(A.grandparent&&A.grandparent.$.nodeName.toLowerCase()=='li')A.grandparent=A.grandparent.getParent();}else A.grandparent=w;if(t)CKEDITOR.dom.element.setMarker(t,z,'listarray_index',u.length);u.push(A);for(var B=0,C=z.getChildCount(),D;B<C;B++){D=z.getChild(B);if(D.type==CKEDITOR.NODE_ELEMENT&&a[D.getName()])CKEDITOR.plugins.list.listToArray(D,t,u,v+1,A.grandparent);else A.contents.push(D);}}return u;},arrayToList:function(s,t,u,v,w){if(!u)u=0;if(!s||s.length<u+1)return null;var x=s[u].parent.getDocument(),y=new CKEDITOR.dom.documentFragment(x),z=null,A=u,B=Math.max(s[u].indent,0),C=null,D,E=v==CKEDITOR.ENTER_P?'p':'div';while(1){var F=s[A];if(F.indent==B){if(!z||s[A].parent.getName()!=z.getName()){z=s[A].parent.clone(false,1);w&&z.setAttribute('dir',w);y.append(z);}C=z.append(F.element.clone(0,1));for(var G=0;G<F.contents.length;G++)C.append(F.contents[G].clone(1,1));A++;}else if(F.indent==Math.max(B,0)+1){var H=F.element.getDirection(1),I=s[A-1].element.getDirection(1),J=CKEDITOR.plugins.list.arrayToList(s,null,A,v,I!=H?H:null);if(!C.getChildCount()&&CKEDITOR.env.ie&&!(x.$.documentMode>7))C.append(x.createText('\xa0'));C.append(J.listNode);A=J.nextIndex;}else if(F.indent==-1&&!u&&F.grandparent){if(a[F.grandparent.getName()]){C=F.element.clone(false,true);D=F.element.getDirection(1);F.grandparent.getDirection(1)!=D&&C.setAttribute('dir',D);}else if(w||F.element.hasAttributes()||v!=CKEDITOR.ENTER_BR){C=x.createElement(E);F.element.copyAttributes(C,{type:1,value:1});D=F.element.getDirection()||w;D&&C.setAttribute('dir',D);if(!w&&v==CKEDITOR.ENTER_BR&&!C.hasAttributes())C=new CKEDITOR.dom.documentFragment(x);}else C=new CKEDITOR.dom.documentFragment(x);for(G=0;G<F.contents.length;G++)C.append(F.contents[G].clone(1,1));if(C.type==CKEDITOR.NODE_DOCUMENT_FRAGMENT&&A!=s.length-1){var K=C.getLast();if(K&&K.type==CKEDITOR.NODE_ELEMENT&&K.getAttribute('type')=='_moz')K.remove();if(!(K=C.getLast(e)&&K.type==CKEDITOR.NODE_ELEMENT&&K.getName() in CKEDITOR.dtd.$block))C.append(x.createElement('br'));
}if(C.type==CKEDITOR.NODE_ELEMENT&&C.getName()==E&&C.$.firstChild){C.trim();var L=C.getFirst();if(L.type==CKEDITOR.NODE_ELEMENT&&L.isBlockBoundary()){var M=new CKEDITOR.dom.documentFragment(x);C.moveChildren(M);C=M;}}var N=C.$.nodeName.toLowerCase();if(!CKEDITOR.env.ie&&(N=='div'||N=='p'))C.appendBogus();y.append(C);z=null;A++;}else return null;if(s.length<=A||Math.max(s[A].indent,0)<B)break;}if(t){var O=y.getFirst();while(O){if(O.type==CKEDITOR.NODE_ELEMENT)CKEDITOR.dom.element.clearMarkers(t,O);O=O.getNextSourceNode();}}return{listNode:y,nextIndex:A};}};function f(s){if(s.editor.readOnly)return null;var t=s.data.path,u=t.blockLimit,v=t.elements,w,x;for(x=0;x<v.length&&(w=v[x])&&!w.equals(u);x++){if(a[v[x].getName()])return this.setState(this.type==v[x].getName()?CKEDITOR.TRISTATE_ON:CKEDITOR.TRISTATE_OFF);}return this.setState(CKEDITOR.TRISTATE_OFF);};function g(s,t,u,v){var w=CKEDITOR.plugins.list.listToArray(t.root,u),x=[];for(var y=0;y<t.contents.length;y++){var z=t.contents[y];z=z.getAscendant('li',true);if(!z||z.getCustomData('list_item_processed'))continue;x.push(z);CKEDITOR.dom.element.setMarker(u,z,'list_item_processed',true);}var A=t.root,B=A.getDocument().createElement(this.type);A.copyAttributes(B,{start:1,type:1});B.removeStyle('list-style-type');for(y=0;y<x.length;y++){var C=x[y].getCustomData('listarray_index');w[C].parent=B;}var D=CKEDITOR.plugins.list.arrayToList(w,u,null,s.config.enterMode),E,F=D.listNode.getChildCount();for(y=0;y<F&&(E=D.listNode.getChild(y));y++){if(E.getName()==this.type)v.push(E);}D.listNode.replace(t.root);};var h=/^h[1-6]$/;function i(s,t,u){var v=t.contents,w=t.root.getDocument(),x=[];if(v.length==1&&v[0].equals(t.root)){var y=w.createElement('div');v[0].moveChildren&&v[0].moveChildren(y);v[0].append(y);v[0]=y;}var z=t.contents[0].getParent();for(var A=0;A<v.length;A++)z=z.getCommonAncestor(v[A].getParent());var B=s.config.useComputedState,C,D;B=B===undefined||B;for(A=0;A<v.length;A++){var E=v[A],F;while(F=E.getParent()){if(F.equals(z)){x.push(E);if(!D&&E.getDirection())D=1;var G=E.getDirection(B);if(C!==null)if(C&&C!=G)C=null;else C=G;break;}E=F;}}if(x.length<1)return;var H=x[x.length-1].getNext(),I=w.createElement(this.type);u.push(I);var J,K;while(x.length){J=x.shift();K=w.createElement('li');if(J.is('pre')||h.test(J.getName()))J.appendTo(K);else{if(C&&J.getDirection()){J.removeStyle('direction');J.removeAttribute('dir');}J.copyAttributes(K);J.moveChildren(K);J.remove();}K.appendTo(I);}if(C&&D)I.setAttribute('dir',C);
if(H)I.insertBefore(H);else I.appendTo(z);};function j(s,t,u){var v=CKEDITOR.plugins.list.listToArray(t.root,u),w=[];for(var x=0;x<t.contents.length;x++){var y=t.contents[x];y=y.getAscendant('li',true);if(!y||y.getCustomData('list_item_processed'))continue;w.push(y);CKEDITOR.dom.element.setMarker(u,y,'list_item_processed',true);}var z=null;for(x=0;x<w.length;x++){var A=w[x].getCustomData('listarray_index');v[A].indent=-1;z=A;}for(x=z+1;x<v.length;x++){if(v[x].indent>v[x-1].indent+1){var B=v[x-1].indent+1-v[x].indent,C=v[x].indent;while(v[x]&&v[x].indent>=C){v[x].indent+=B;x++;}x--;}}var D=CKEDITOR.plugins.list.arrayToList(v,u,null,s.config.enterMode,t.root.getAttribute('dir')),E=D.listNode,F,G;function H(I){if((F=E[I?'getFirst':'getLast']())&&!(F.is&&F.isBlockBoundary())&&(G=t.root[I?'getPrevious':'getNext'](CKEDITOR.dom.walker.whitespaces(true)))&&!(G.is&&G.isBlockBoundary({br:1})))s.document.createElement('br')[I?'insertBefore':'insertAfter'](F);};H(true);H();E.replace(t.root);};function k(s,t){this.name=s;this.type=t;};k.prototype={exec:function(s){var t=s.document,u=s.config,v=s.getSelection(),w=v&&v.getRanges(true);if(!w||w.length<1)return;if(this.state==CKEDITOR.TRISTATE_OFF){var x=t.getBody();if(!x.getFirst(e)){u.enterMode==CKEDITOR.ENTER_BR?x.appendBogus():w[0].fixBlock(1,u.enterMode==CKEDITOR.ENTER_P?'p':'div');v.selectRanges(w);}else{var y=w.length==1&&w[0],z=y&&y.getEnclosedNode();if(z&&z.is&&this.type==z.getName())this.setState(CKEDITOR.TRISTATE_ON);}}var A=v.createBookmarks(true),B=[],C={},D=w.createIterator(),E=0;while((y=D.getNextRange())&&++E){var F=y.getBoundaryNodes(),G=F.startNode,H=F.endNode;if(G.type==CKEDITOR.NODE_ELEMENT&&G.getName()=='td')y.setStartAt(F.startNode,CKEDITOR.POSITION_AFTER_START);if(H.type==CKEDITOR.NODE_ELEMENT&&H.getName()=='td')y.setEndAt(F.endNode,CKEDITOR.POSITION_BEFORE_END);var I=y.createIterator(),J;I.forceBrBreak=this.state==CKEDITOR.TRISTATE_OFF;while(J=I.getNextParagraph()){if(J.getCustomData('list_block'))continue;else CKEDITOR.dom.element.setMarker(C,J,'list_block',1);var K=new CKEDITOR.dom.elementPath(J),L=K.elements,M=L.length,N=null,O=0,P=K.blockLimit,Q;for(var R=M-1;R>=0&&(Q=L[R]);R--){if(a[Q.getName()]&&P.contains(Q)){P.removeCustomData('list_group_object_'+E);var S=Q.getCustomData('list_group_object');if(S)S.contents.push(J);else{S={root:Q,contents:[J]};B.push(S);CKEDITOR.dom.element.setMarker(C,Q,'list_group_object',S);}O=1;break;}}if(O)continue;var T=P;if(T.getCustomData('list_group_object_'+E))T.getCustomData('list_group_object_'+E).contents.push(J);
else{S={root:T,contents:[J]};CKEDITOR.dom.element.setMarker(C,T,'list_group_object_'+E,S);B.push(S);}}}var U=[];while(B.length>0){S=B.shift();if(this.state==CKEDITOR.TRISTATE_OFF){if(a[S.root.getName()])g.call(this,s,S,C,U);else i.call(this,s,S,U);}else if(this.state==CKEDITOR.TRISTATE_ON&&a[S.root.getName()])j.call(this,s,S,C);}for(R=0;R<U.length;R++){N=U[R];var V,W=this;(V=function(X){var Y=N[X?'getPrevious':'getNext'](CKEDITOR.dom.walker.whitespaces(true));if(Y&&Y.getName&&Y.getName()==W.type){Y.remove();Y.moveChildren(N,X);}})();V(1);}CKEDITOR.dom.element.clearAllMarkers(C);v.selectBookmarks(A);s.focus();}};var l=CKEDITOR.dtd,m=/[\t\r\n ]*(?:&nbsp;|\xa0)$/;function n(s,t){var u,v=s.children,w=v.length;for(var x=0;x<w;x++){u=v[x];if(u.name&&u.name in t)return x;}return w;};function o(s){return function(t){var u=t.children,v=n(t,l.$list),w=u[v],x=w&&w.previous,y;if(x&&(x.name&&x.name=='br'||x.value&&(y=x.value.match(m)))){var z=x;if(!(y&&y.index)&&z==u[0])u[0]=s||CKEDITOR.env.ie?new CKEDITOR.htmlParser.text('\xa0'):new CKEDITOR.htmlParser.element('br',{});else if(z.name=='br')u.splice(v-1,1);else z.value=z.value.replace(m,'');}};};var p={elements:{}};for(var q in l.$listItem)p.elements[q]=o();var r={elements:{}};for(q in l.$listItem)r.elements[q]=o(true);CKEDITOR.plugins.add('list',{init:function(s){var t=s.addCommand('numberedlist',new k('numberedlist','ol')),u=s.addCommand('bulletedlist',new k('bulletedlist','ul'));s.ui.addButton('NumberedList',{label:s.lang.numberedlist,command:'numberedlist'});s.ui.addButton('BulletedList',{label:s.lang.bulletedlist,command:'bulletedlist'});s.on('selectionChange',CKEDITOR.tools.bind(f,t));s.on('selectionChange',CKEDITOR.tools.bind(f,u));},afterInit:function(s){var t=s.dataProcessor;if(t){t.dataFilter.addRules(p);t.htmlFilter.addRules(r);}},requires:['domiterator']});})();
