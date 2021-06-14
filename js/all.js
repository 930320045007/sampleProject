
function toggleview(element1, view1) {

   element1 = document.getElementById(element1);
   view1 = document.getElementById(view1);

   if (element1.style.display == 'none' || element1.style.display == '')
   {
      element1.style.display = 'block';
	  view1.style.display = 'none';
	  
   } else {
      element1.style.display = 'none';
	  view1.style.display = 'block';
   }

   return;
}


function toggleview2(element1) {

   element1 = document.getElementById(element1);

   if (element1.style.display == 'none' || element1.style.display == '')
   {
      element1.style.display = 'block';
   } else {
      element1.style.display = 'none';
   }

   return;
}

function toggleview4(element1, param) {

   
   element1 = document.getElementById(element1);
debugger;
   if (element1.style.display == 'none' || element1.style.display == '')
   {
      element1.style.display = 'block';
   } else {
      element1.style.display = 'none';
   }

   return;
}

function togglepopup(id) {
	var e = document.getElementById(id);
	e.style.display = 'none';
}

function MM_popupMsg(msg) {
  alert(msg);
}

function MM_goToURL() 
{ //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) 
  	eval(args[i]+".location='"+args[i+1]+"'");
}

function MM_openBrWindow(theURL,winName,features) 
{ //v2.0
  window.open(theURL,winName,features);
}