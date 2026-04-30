<!--
//written by Janusz "Vax" Radkiewicz
//modified by Bogdan Blaszczak
//if you want to use it, do not remove these lines

function Start(){
wspL=wspT=10;
celX=cienX=oBx=250,celY=cienY=oBy=-100,Ani=0;
if(document.layers)
document.captureEvents(Event.MOUSEMOVE);
document.onmousemove=DocMove;
}

function DocMove(wsp){
wspL=window.opera?wsp.clientX:document.all?event.x:wsp.pageX;
wspT=window.opera?wsp.clientY:document.all?event.y:wsp.pageY;
Cel();
}

function W(id){
var d=document;
d=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
if(!document.layers)d=d.style;
return d}

function Cel(){
 celX=wspL;
 celY=wspT;
 if(!Ani)RuchOb();
}

function RuchOb(){ 
 with(W('obiekt')){top=oBy;left=oBx}
 with(W('cien')){top=cienY+20;left=cienX+20}
 oBx=(12*oBx+celX)/13;
 oBy=(9*oBy+celY)/10;
 cienX=(20*cienX+celX)/21;
 cienY=(15*cienY+celY)/16;

if(Math.round(cienX)!=celX||Math.round(cienY)!=celY)
 Ani=setTimeout("RuchOb()",20);
else Ani=0
}
//-->

