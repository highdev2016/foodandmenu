<?php
ini_set('max_execution_time', 7200);
ob_start();
session_start();
if(!isset($_SESSION['admin_id'])){
	header("location:admin/login.php");
}

include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");

if(isset($_POST["upload"]))
{
	$filename=$_FILES["file"]["tmp_name"];
	$filename1 = $_FILES["file"]["name"];
	$file_type = $_FILES['file']['type'];
	$ext=substr($filename1,strrpos($filename1,"."),(strlen($filename1)-strrpos($filename1,".")));
	
	
	if($file_type == "application/vnd.ms-excel" && $ext == ".csv")
	{
		$tmpn=$filename;
		$src_subscription_form=$tmpn;
		$dest_subscription_form1="uploaded_csvfile/".$filename1;
		copy($src_subscription_form,$dest_subscription_form1);
	}
	else{
		$msg = "Invalid File:Please Upload CSV File";
	}
	
//echo $ext=substr($filename,strrpos($filename,"."),(strlen($filename)-strrpos($filename,".")));
 
function array_non_empty_items($input) {
// If it is an element, then just return it
if (!is_array($input)) {
  return $input;
}

$non_empty_items = array();

foreach ($input as $key => $value) {
  // Ignore empty cells
  if($value) {
	// Use recursion to evaluate cells
	$non_empty_items[$key] = array_non_empty_items($value);
  }
}

// Finally return the array without empty items
return $non_empty_items;
}

$row = 1;
if (($handle = fopen("uploaded_csvfile/".$filename1, "r")) !== FALSE && $ext == ".csv") {
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	  $data_value[] = $data;
	}
	$data_arr = array_shift($data_value);
$data = (array_non_empty_items(array_non_empty_items($data_value)));




foreach($data as $arr_elements)
{	
	$sql_select_category = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_category WHERE category_name = '".$arr_elements[11]."'"));
	$sql_show_order = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info ORDER BY show_order DESC LIMIT 0,1"));
	
	$address = $arr_elements[6].",".$arr_elements[7].",".$arr_elements[8].",".$arr_elements[9].",".$arr_elements[10];
	
	if($address!=''){
	$myaddress = urlencode($address);
	//here is the google api url
	$url = "http://maps.googleapis.com/maps/api/geocode/json?address=$myaddress&sensor=false";
	//get the content from the api using file_get_contents
	$getmap = file_get_contents($url); 
	//the result is in json format. To decode it use json_decode
	$googlemap = json_decode($getmap);
	//get the latitute, longitude from the json result by doing a for loop
	foreach($googlemap->results as $res){
		$address = $res->geometry;
		$latlng = $address->location;
		$formattedaddress = $res->formatted_address;
	}
		//$sql.= " ,latitude = '".$latlng->lat."' , longitude = '".$latlng->lng."'";
	}
	
	
	
	$sql_get_duplicate = mysql_num_rows(mysql_query("SELECT * FROM restaurant_basic_info WHERE restaurant_name = '".addslashes($arr_elements[5])."' AND restaurant_address = '".$arr_elements[6]."' AND restaurant_city = '".$arr_elements[7]."' AND restaurant_state = '".$arr_elements[8]."' AND restaurant_zipcode = '".$arr_elements[9]."' "));
	
	$array_duplicate = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE restaurant_name = '".addslashes($arr_elements[5])."' AND restaurant_address = '".$arr_elements[6]."' AND restaurant_city = '".$arr_elements[7]."' AND restaurant_state = '".$arr_elements[8]."' AND restaurant_zipcode = '".$arr_elements[9]."' "));
	
	if($sql_get_duplicate == 0){
		
	$sql = ("INSERT INTO  restaurant_basic_info SET  user_id = '1',name='".addslashes($arr_elements[0])."',phone='".$arr_elements[1]."',fax='".$arr_elements[2]."',email='".$arr_elements[3]."',website='".$arr_elements[4]."',restaurant_name='".addslashes($arr_elements[5])."',restaurant_address='".addslashes($arr_elements[6])."',restaurant_city='".addslashes($arr_elements[7])."',restaurant_state='".addslashes($arr_elements[8])."',restaurant_zipcode='".$arr_elements[9]."',restaurant_country='".addslashes($arr_elements[10])."',status = 1, featured_status = 1,  show_order ='".($sql_show_order['show_order']+1)."' ,latitude = '".$latlng->lat."' , longitude = '".$latlng->lng."' ");
	
	
	if(!empty($sql_select_category['id'])){
		$sql.= " , restaurant_category_name = '".$arr_elements[11]."' , restaurant_category = '".$sql_select_category['id']."' ";
	}else{
		$sql_category = mysql_query("INSERT INTO restaurant_category SET category_name = '".$arr_elements[11]."'");
		$category_id = mysql_insert_id();
		
		$sql.= " , restaurant_category_name = '".$arr_elements[11]."' , restaurant_category = '".$category_id."' ";
	}
	
	$sql_insert = mysql_query($sql);
	
	}else{
		$sql_update = "UPDATE restaurant_basic_info SET phone='".$arr_elements[1]."', fax='".$arr_elements[2]."',email='".$arr_elements[3]."',website='".$arr_elements[4]."' ";
		if(!empty($sql_select_category['id'])){
		$sql_update.= " , restaurant_category_name = '".$arr_elements[11]."' , restaurant_category = '".$sql_select_category['id']."' ";
		}else{
		$sql_category = mysql_query("INSERT INTO restaurant_category SET category_name = '".$arr_elements[11]."'");
		$category_id = mysql_insert_id();
		
		$sql_update.= " , restaurant_category_name = '".$arr_elements[11]."' , restaurant_category = '".$category_id."' ";
		}
		
		$sql_update.=" WHERE id = '".$array_duplicate['id']."'";
	
		$query_update = mysql_query($sql_update);
	}
	//echo $sql; exit;
	
	
	
	$last_id = mysql_insert_id();
	
}
fclose($handle);
//$msg1 = "Successfully uploaded CSV file";
	
header("location:import_csv_file.php?msg1=1");
}
}

?>

<body>
<?php include ("includes/menu_restaurant_admin_panel.php");?>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont">

<div class="restaurant_cont_top">
<h1>Import CSV File</h1>
</div>

<div class="restaurant_cont_field">
<?php if($msg!=''){ ?>
<p style="text-align:center; margin-top:10px;">Invalid File:Please Upload CSV File.</p>
<?php }else if($_REQUEST['msg1']==1){?>
<p style="text-align:center; margin-top:10px;">Successfully uploaded CSV file.</p>
<?php }?>

<form enctype="multipart/form-data" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:20px; min-height:260px;">
  <tr>
    <td width="47%" height="30" align="right" style="padding-right:20px;">Upload CSV File : </td>
    <td width="53%"><input type="file" name="file" id="file"></td>
  </tr>
  <tr>
    <td height="24" style="padding:0px !important;"></td>
    <td><input type="submit" name="upload" value="Upload" style="background-color:rgb(235, 111, 0); padding:8px 12px; text-align:center; color:#ffffff; font-weight:bold; cursor:pointer; border:0; outline:0;">
  </tr>
</table>
</form>

</div>
                 
<div class="restaurant_cont_field">

</div>

<div class="pagination" style="padding-top:10px; margin-top:10px; width:100%;">
<div align="center">

</div>
</div>
</div>
<div class="clear"></div>


</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>