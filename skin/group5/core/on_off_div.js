var prox;
var proy;
var proxc;
var proyc;
function show(id){/*--打开--*/
	var netcon = document.getElementById("netcon")
	if(netcon){
		clearInterval(prox);
		clearInterval(proy);
		clearInterval(proxc);
		clearInterval(proyc);
		var li = netcon.getElementsByTagName("a");
		for(var i=0; i<li.length*3-2; i++){
			if(id == "fd"+i){
				for(j=0; j<li.length*3-2; j++){
					if(j==i){
						var o = document.getElementById("fd"+j);
						o.style.display = "block";
						o.style.width = "1px";
						o.style.height = "1px";
						prox = setInterval(function(){openx(o,274)},1);
					}else{
						var n = document.getElementById("fd"+j);
						if(n && n.style.display == "block"){
						n.style.display ="none";
						}
					}
				}
			}
			
		}
	}else{
		clearInterval(prox);
		clearInterval(proy);
		clearInterval(proxc);
		clearInterval(proyc);
		var o = document.getElementById(id);
		o.style.display = "block";
		o.style.width = "1px";
		o.style.height = "1px"; 
		prox = setInterval(function(){openx(o,274)},1);
	}
}
function openx(o,x){/*--打开x--*/
var cx = parseInt(o.style.width);
if(cx < x)
{
o.style.width = (cx + Math.ceil((x-cx)/2)) +"px";
}
else
{
clearInterval(prox);
proy = setInterval(function(){openy(o,200)},1);
}
}
function openy(o,y){/*--打开y--*/
var cy = parseInt(o.style.height);
if(cy < y)
{
o.style.height = (cy + Math.ceil((y-cy)/2)) +"px";
}
else
{
clearInterval(proy);
}
}
function closeed(id){/*--关闭--*/
clearInterval(prox);
clearInterval(proy);
clearInterval(proxc);
clearInterval(proyc);
var o = document.getElementById(id);
if(o.style.display == "block")
{
proyc = setInterval(function(){closey(o)},1);
}
}
function closey(o){/*--打开y--*/
var cy = parseInt(o.style.height);
if(cy > 0)
{
o.style.height = (cy - Math.ceil(cy/2)) +"px";
}
else
{
clearInterval(proyc);
proxc = setInterval(function(){closex(o)},1);
}
}
function closex(o){/*--打开x--*/
var cx = parseInt(o.style.width);
if(cx > 0)
{
o.style.width = (cx - Math.ceil(cx/2)) +"px";
}
else
{
clearInterval(proxc);
o.style.display = "none";
}
}



