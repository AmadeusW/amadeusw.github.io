<!--
//written by Janusz "Vax" Radkiewicz
//modified by Bogdan Blaszczak
//if you want to use it, do not remove these lines

var t=new Array();
for(var i=1;i<13;i++) t[i]=new Image();
for(var i=1;i<13;i++) t[i].src="grafika/thumbs/"+i+".jpg";

function W(id,s){
var d=document;
d=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
if(!document.layers&&s)d=d.style;
return d
}
function Pisz(dzie,co){
if(document.layers)with(W(dzie).document){write(co);close()}
else W(dzie).innerHTML=co
}
function NSres(f){
if(f==true){document.dW=innerWidth;document.dH=innerHeight;onresize=NSres}
else if(innerWidth!=document.dW||innerHeight!=document.dH)location.reload()
}if(document.layers)NSres(true);
var celX=cienX=oBx=250,celY=cienY=oBy=-100,Ani=0;

function Hop(left,top){
 celX=left;
 celY=top;
 if(!Ani)RuchOb();
}

function RuchOb(){ 
 with(W('obiekt',1)){top=oBy;left=oBx}
 with(W('cien',1)){top=cienY+20;left=cienX+20}
 oBx=(12*oBx+celX)/13;
 oBy=(9*oBy+celY)/10;
 cienX=(20*cienX+celX)/21;
 cienY=(15*cienY+celY)/16;

if(Math.round(cienX)!=celX||Math.round(cienY)!=celY)
 Ani=setTimeout("RuchOb()",20);
else Ani=0
}
function Mout(){status=''}

function WstawT(numer,tekst,Ptekst){
var w=document.layers?W('obiekt'):window;
w.document.images.thumb1.src=t[numer].src;
var tekst1="<span class='napis1'>"+tekst+"</span>";
tekst="<span class='napis'>"+tekst+"</span>";
Pisz('napis',tekst);
Pisz('napis1',tekst1);
window.status=Ptekst
}
function Inf(){alert('Teraz nastapi³by skok do strony na której jest umieszczone du¿e zdjêcie.')}
//-->

