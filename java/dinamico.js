
// función para desplegar el submenú
var uno;
if (document.all){uno = 1;}else{ uno = 0;};
var ns6= document.getElementById && !uno;

var head="display:''"
var folder=''
function expandit(curobj)
{
	var stattus;
 folder= ns6? curobj.nextSibling.nextSibling.style:document.all[curobj.sourceIndex+2].style;
 if (folder.display=="none"){
	  folder.display='';
	  stattus=1;
  }else{
  	folder.display='none';
  	stattus=0;
  };
  return stattus
}

function expandit2(curobj,sino)
{
 folder=ns6?document.getElementById(curobj).style:document.all[curobj].style
 if(sino==1)
 {
  folder.display='';
  folder.visibility='visible';
 }
 else
 {
  folder.display='none';
  folder.visibility='hidden';
 };
};

function op_act(opname,fcolor,fw){
	document.getElementById(opname).style.color=fcolor;
	document.getElementById(opname).style.color=fcolor;
	document.getElementById(opname).style.fontWeight=fw;
};


			

