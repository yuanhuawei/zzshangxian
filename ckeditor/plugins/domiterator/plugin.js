﻿CKEDITOR.plugins.add('domiterator');(function(){function a(g){var h=this;if(arguments.length<1)return;h.range=g;h.forceBrBreak=0;h.enlargeBr=1;h.enforceRealBlocks=0;h._||(h._={});};var b=/^[\r\n\t ]+$/,c=CKEDITOR.dom.walker.bookmark(false,true),d=CKEDITOR.dom.walker.whitespaces(true),e=function(g){return c(g)&&d(g);};function f(g,h,i){var j=g.getNextSourceNode(h,null,i);while(!c(j))j=j.getNextSourceNode(h,null,i);return j;};a.prototype={getNextParagraph:function(g){var G=this;var h,i,j,k,l,m;if(!G._.lastNode){i=G.range.clone();i.shrink(CKEDITOR.NODE_ELEMENT,true);k=i.endContainer.hasAscendant('pre',true)||i.startContainer.hasAscendant('pre',true);i.enlarge(G.forceBrBreak&&!k||!G.enlargeBr?CKEDITOR.ENLARGE_LIST_ITEM_CONTENTS:CKEDITOR.ENLARGE_BLOCK_CONTENTS);var n=new CKEDITOR.dom.walker(i),o=CKEDITOR.dom.walker.bookmark(true,true);n.evaluator=o;G._.nextNode=n.next();n=new CKEDITOR.dom.walker(i);n.evaluator=o;var p=n.previous();G._.lastNode=p.getNextSourceNode(true);if(G._.lastNode&&G._.lastNode.type==CKEDITOR.NODE_TEXT&&!CKEDITOR.tools.trim(G._.lastNode.getText())&&G._.lastNode.getParent().isBlockBoundary()){var q=new CKEDITOR.dom.range(i.document);q.moveToPosition(G._.lastNode,CKEDITOR.POSITION_AFTER_END);if(q.checkEndOfBlock()){var r=new CKEDITOR.dom.elementPath(q.endContainer),s=r.block||r.blockLimit;G._.lastNode=s.getNextSourceNode(true);}}if(!G._.lastNode){G._.lastNode=G._.docEndMarker=i.document.createText('');G._.lastNode.insertAfter(p);}i=null;}var t=G._.nextNode;p=G._.lastNode;G._.nextNode=null;while(t){var u=0,v=t.hasAscendant('pre'),w=t.type!=CKEDITOR.NODE_ELEMENT,x=0;if(!w){var y=t.getName();if(t.isBlockBoundary(G.forceBrBreak&&!v&&{br:1})){if(y=='br')w=1;else if(!i&&!t.getChildCount()&&y!='hr'){h=t;j=t.equals(p);break;}if(i){i.setEndAt(t,CKEDITOR.POSITION_BEFORE_START);if(y!='br')G._.nextNode=t;}u=1;}else{if(t.getFirst()){if(!i){i=new CKEDITOR.dom.range(G.range.document);i.setStartAt(t,CKEDITOR.POSITION_BEFORE_START);}t=t.getFirst();continue;}w=1;}}else if(t.type==CKEDITOR.NODE_TEXT)if(b.test(t.getText()))w=0;if(w&&!i){i=new CKEDITOR.dom.range(G.range.document);i.setStartAt(t,CKEDITOR.POSITION_BEFORE_START);}j=(!u||w)&&t.equals(p);if(i&&!u)while(!t.getNext(e)&&!j){var z=t.getParent();if(z.isBlockBoundary(G.forceBrBreak&&!v&&{br:1})){u=1;w=0;j=j||z.equals(p);i.setEndAt(z,CKEDITOR.POSITION_BEFORE_END);break;}t=z;w=1;j=t.equals(p);x=1;}if(w)i.setEndAt(t,CKEDITOR.POSITION_AFTER_END);t=f(t,x,p);j=!t;if(j||u&&i)break;}if(!h){if(!i){G._.docEndMarker&&G._.docEndMarker.remove();
G._.nextNode=null;return null;}var A=new CKEDITOR.dom.elementPath(i.startContainer),B=A.blockLimit,C={div:1,th:1,td:1};h=A.block;if(!h&&!G.enforceRealBlocks&&C[B.getName()]&&i.checkStartOfBlock()&&i.checkEndOfBlock())h=B;else if(!h||G.enforceRealBlocks&&h.getName()=='li'){h=G.range.document.createElement(g||'p');i.extractContents().appendTo(h);h.trim();i.insertNode(h);l=m=true;}else if(h.getName()!='li'){if(!i.checkStartOfBlock()||!i.checkEndOfBlock()){h=h.clone(false);i.extractContents().appendTo(h);h.trim();var D=i.splitBlock();l=!D.wasStartOfBlock;m=!D.wasEndOfBlock;i.insertNode(h);}}else if(!j)G._.nextNode=h.equals(p)?null:f(i.getBoundaryNodes().endNode,1,p);}if(l){var E=h.getPrevious();if(E&&E.type==CKEDITOR.NODE_ELEMENT)if(E.getName()=='br')E.remove();else if(E.getLast()&&E.getLast().$.nodeName.toLowerCase()=='br')E.getLast().remove();}if(m){var F=h.getLast();if(F&&F.type==CKEDITOR.NODE_ELEMENT&&F.getName()=='br')if(CKEDITOR.env.ie||F.getPrevious(c)||F.getNext(c))F.remove();}if(!G._.nextNode)G._.nextNode=j||h.equals(p)?null:f(h,1,p);return h;}};CKEDITOR.dom.range.prototype.createIterator=function(){return new a(this);};})();
