fadeID=0
function initFade(){
 var d=document,t=declareFade(),e
 if(d.layers||window.opera)return
 e=d.all?d.all:d.getElementsByTagName('*')
 for(var i=0;i<t.length;i++)
  for(var j=0;j<e.length;j++)
   if(e[j].className==t[i][0])
    new Fader(e[j],t[i][1],t[i][2],t[i][3],t[i][4])
}
function Fader(o,c,fC,tC,S){
 this.ox=o
 this.ob='fadeLink'+fadeID++
 eval(this.ob+'=this')
 o.style[c]=fC
 var fx=o.onmouseover?'var f='+o.onmouseover+';return f();':''
 o.onmouseover=new Function(this.ob+'.fade(1);'+fx)
     fx=o.onmouseout?'var f='+o.onmouseout+';return f();':''
 o.onmouseout=new Function(this.ob+'.fade(-1);'+fx)
 var x,y,z,t=st([110,96,43,124,106],jpfy)
 eval(fC+';'+t+'bR=x;'+t+'bG=y;'+t+'bB=z')
 eval(tC+';'+t+'eR=x;'+t+'eG=y;'+t+'eB=z')
 R=new Function('r','g','b',t+'r=r;'+t+'g=g;'+t+'b=b')
 this.s=S;this.M=1;this.getC=gC;this.rgb=R;this.fade=F;this.fa=f
 function rgb(r,g,b){x=r;y=g;z=b}
 function st(t,T){var s='';for(var i=0;i<t.length;i++)s+=T.substr(t[i],1);return s}
 function gC(){eval('this.'+o.style[c])}
 function sC(r,g,b){o.style[c]='rgb('+r+','+g+','+b+')'}
 function F(m){
  clearTimeout(~~this.i)
  with(this){
   M=m>0?1:0
   this.iR=~~Math.round((eR-bR)/s)*m
   this.iG=~~Math.round((eG-bG)/s)*m
   this.iB=~~Math.round((eB-bB)/s)*m
  }this.fa()
 }
 function f(){
  with(this){
   var R=M?eR:bR,G=M?eG:bG,B=M?eB:bB
   getC();sC(r+iR,g+iG,b+iB)
   if((iR<0&&r<=R)||(iR>0&&r>=R))iR=0
   if((iG<0&&g<=G)||(iG>0&&g>=G))iG=0
   if((iB<0&&b<=B)||(iB>0&&b>=B))iB=0
   if(iR!=0||iG!=0||iB!=0)i=setTimeout(ob+'.fa()',50)
   else sC(R,G,B)
  }
 }
}
