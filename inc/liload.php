<script language=Javascript>
function Inint_AJAX() {
try { return new ActiveXObject("Msxml2.XMLHTTP");  } catch(e) {} //IE
try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
try { return new XMLHttpRequest();          } catch(e) {} //Native Javascript
alert("XMLHttpRequest not supported");
return null;
};

// type: 1-Scheme; 
// src: UL name to view; 
// val: List value; 
// vall: view ALL or optiona data; 
// prog: program or optional data;

function dochange(type, src, val, vall, prog) { 
var req = Inint_AJAX();
req.onreadystatechange = function () {
 if (req.readyState==4) {
      if (req.status==200) {
           document.getElementById(src).innerHTML=req.responseText; //return value
      }
 }
};

req.open("GET", "<?php echo $url_main;?>inc/liview.php?type="+type+"&val="+val+"&vall="+vall+"&prog="+prog); //make connection
req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=iso-8859-1"); // set Header
req.send(null); //send value
}

</script>