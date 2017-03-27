<?php include ("admin/lib/conn.php");?>

<?php
/*$sql_restaurant=mysql_query("SELECT DISTINCT(restaurant_address),restaurant_city,restaurant_state  FROM restaurant_basic_info where status=1");
$sep="";
$add="";
while($array_restaurant=mysql_fetch_array($sql_restaurant))
{	 
	$add.=$sep.'"'.strtolower($array_restaurant['restaurant_address']).",".strtolower($array_restaurant['restaurant_city']).",".strtolower($array_restaurant['restaurant_state']).'"';
	$sep=",";
}*/


/*$sql_user_address = mysql_query("SELECT DISTINCT(address),city,state,zip FROM restaurant_customer WHERE address!=''");
$sep="";
$add="";
while($array_user_address=mysql_fetch_array($sql_user_address))
{	 
	$add.=$sep.'"'.strtolower($array_user_address['address']).",".strtolower($array_user_address['city']).",".strtolower($array_user_address['state']).",".strtolower($array_user_address['zip']).'"';
	$sep=",";
}*/


/*$sql_basic_info_state=mysql_query("SELECT DISTINCT(restaurant_state) FROM restaurant_basic_info where status=1");
$all_state="";
while($res_basc_info_state=mysql_fetch_array($sql_basic_info_state))
{
	$all_state.=$sep.'"'.strtolower($res_basc_info_state['restaurant_state']).'"';
	$sep=",";
}*/


/*$sql_basic_info_zipcode=mysql_query("SELECT DISTINCT(restaurant_zipcode) FROM restaurant_basic_info where status=1");
$all_zipcode="";
while($res_basc_info_zipcode=mysql_fetch_array($sql_basic_info_zipcode))
{
	$all_zipcode.=$sep.'"'.strtolower($res_basc_info_zipcode['restaurant_zipcode']).'"';
	$sep=",";
}*/

$sep="";
$sql_basic_info_city=mysql_query("SELECT DISTINCT(restaurant_city), restaurant_state FROM restaurant_basic_info where status=1");
while($res_basc_info_city=mysql_fetch_array($sql_basic_info_city))
{
	//$all_city.=$sep.'"'.strtolower($res_basc_info_city['restaurant_city']).'"/"'.strtolower($res_basc_info_city['restaurant_state']).'"';
	$all_city.=$sep.'"'.strtolower($res_basc_info_city['restaurant_city']).",".strtolower($res_basc_info_city['restaurant_state']).'"';
	$sep=",";
}

$sql_basic_info_zipcode=mysql_query("SELECT DISTINCT(restaurant_zipcode) FROM restaurant_basic_info where status=1");
$all_zipcode="";
while($res_basc_info_zipcode=mysql_fetch_array($sql_basic_info_zipcode))
{
	$all_zipcode.=$sep.'"'.strtolower($res_basc_info_zipcode['restaurant_zipcode']).'"';
	$sep=",";
}

$full_address = $all_city.$all_zipcode;
?>

<script type="text/javascript">
var suggestions = new Array(<?php echo $full_address;?>);
<!-- Declare the array and store the values according to ur usage -->
// var suggestions = new Array("bank", "back", "peter","hindu","huge", "test","bums","cat","kind","fight","argue","append","run","sad","silk","light","little","rate","orange","office","lucky","cable","monitor","narration","early","pick","put","hungry","gain","gift","java","junction","vegtable","fan","north","needle","winter","nation","carry","dance","danger","iteration","facile","yahoo","quick","quee","arrangement","vechicle","urban","xerox","zeebra","xML");
var outp;
var oldins;
var posi = -1;
var words = new Array();
var input;
var key;
function setVisible(visi)
{
  var x = document.getElementById("shadow");
  var t = document.getElementsByName("full_address")[0];
  x.style.position = 'absolute';
  x.style.top = (findPosY(t)+3)+"px";
  x.style.left = (findPosX(t)+2)+"px";
  x.style.visibility = visi;
}
function init()
{
  outp = document.getElementById("output");
  window.setInterval("lookAt()", 100);
  setVisible("hidden");
  document.onkeydown = keygetter; //needed for Opera...
  document.onkeyup = keyHandler;
}
function findPosX(obj)
{
  var curleft = 0;
  if (obj.offsetParent)
  {
    while (obj.offsetParent)
    {
      curleft += obj.offsetLeft;
      obj = obj.offsetParent;
    }
   }
  else if (obj.x)
    curleft += obj.x;
        return curleft;
}
function findPosY(obj)
{
  var curtop = 0;
  if (obj.offsetParent)
  {
    curtop += obj.offsetHeight;
    while (obj.offsetParent)
    {
      curtop += obj.offsetTop;
      obj = obj.offsetParent;
     }
   }
   else if (obj.y)
   {
     curtop += obj.y;
     curtop += obj.height;
   }
   return curtop;
}
function lookAt()
{
   var ins = document.getElementsByName("full_address")[0].value;
   if (oldins == ins)
      return;
   else if (posi > -1);
   else if (ins.length > 0)
   {
     words = getWord(ins);
     if (words.length > 0)
     {
        clearOutput();
        for (var i=0;i < words.length; ++i)
             addWord (words[i]);
        setVisible("visible");
        input = document.getElementsByName("full_address")[0].value;
     }
     else
     {
        setVisible("hidden");
        posi = -1;
     }
   }
   else
   {
    setVisible("hidden");
    posi = -1;
   }
   oldins = ins;
}
function addWord(word)
{
  var sp = document.createElement("div");
  sp.appendChild(document.createTextNode(word));
  sp.onmouseover = mouseHandler;
  sp.onmouseout = mouseHandlerOut;
  sp.onclick = mouseClick;
  outp.appendChild(sp);
}
function clearOutput()
{
  while (outp.hasChildNodes())
  {
    noten=outp.firstChild;
    outp.removeChild(noten);
  }
   posi = -1;
}
function getWord(beginning)
{
  var words = new Array();
  for (var i=0;i < suggestions.length; ++i)
   {
    var j = -1;
    var correct = 1;
    while (correct == 1 && ++j < beginning.length)
    {
		var charExists = (suggestions[i].indexOf(beginning) >= 0) ? true : false;
     //if (suggestions[i].charAt(1) != beginning.charAt(j))
         correct = 0;
    }
    if (charExists == true)
       words[words.length] = suggestions[i];
  }
    return words;
  
}       
function setColor (_posi, _color, _forg)
{
   outp.childNodes[_posi].style.background = _color;
   outp.childNodes[_posi].style.color = _forg;
}
function keygetter(event)
{
  if (!event && window.event) 
      event = window.event;
  if (event)
      key = event.keyCode;
  else
      key = event.which;
}
function keyHandler(event)
{
  if (document.getElementById("shadow").style.visibility == "visible")
  {
     var textfield = document.getElementsByName("full_address")[0];
     if (key == 40)//key down
     { 
        if (words.length > 0 && posi <= words.length-1)
        {
          if (posi >=0)
            setColor(posi, "#fff", "black");
          else 
             input = textfield.value;
             setColor(++posi, "blue", "white");
             textfield.value = outp.childNodes[posi].firstChild.nodeValue;
        }
      }
      else if (key == 38)
      { //Key up
        if (words.length > 0 && posi >= 0)
         {
           if (posi >=1)
           {
              setColor(posi, "#fff", "black");
              setColor(--posi, "blue", "white");
              textfield.value = outp.childNodes[posi].firstChild.nodeValue;
           }
           else
           {
              setColor(posi, "#fff", "black");
              textfield.value = input;
              textfield.focus();
              posi--;
           }
         }
        }
         else if (key == 27)
         { // Esc
            textfield.value = input;
            setVisible("hidden");
            posi = -1;
            oldins = input;
          }
          else if (key == 8) 
          { // Backspace
            posi = -1;
            oldins=-1;
          } 
              }
   }
    var mouseHandler=function()
    {
      for (var i=0; i < words.length; ++i)
        setColor (i, "white", "black");
      this.style.background = "blue";
      this.style.color= "white";
     }
     var mouseHandlerOut=function()
     {
       this.style.background = "white";
       this.style.color= "black";
     }
     var mouseClick=function()
     {
        document.getElementsByName("full_address")[0].value = this.firstChild.nodeValue;
        setVisible("hidden");
        posi = -1;
        oldins = this.firstChild.nodeValue;
     }
</script>
<style type="text/css">

.output
{
        font-family:Arial;
        font-size: 10pt;
        color:black;
        padding-left: 3px;
        padding-top: 3px;
        /*border: 1px solid #c9c9c9;*/
        width: 226px;
        background: #fff;
}
.shadow
{
        width:102px;
        position:relative;
        top: 2px;
        left: 2px;
       /* background: #555;*/
}
.shadow div
{
        position:relative;
        top: -2px;
        left: -2px;
		/*z-index: 2147483647;*/
		z-index: 214;
}
.output div
{
		padding:3px 0 !important;
}
#output
{
		max-height:141px !important;
		overflow:auto;
}
</style>