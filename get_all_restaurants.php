<?php
session_start();
include ("admin/lib/conn.php");
include ("includes/header_profile.php");
include ("includes/functions.php");

$state = $_REQUEST['state'];
$city = $_REQUEST['city'];
$res_id = $_REQUEST['res_id'];

$get_all_res = mysql_query("SELECT * FROM restaurant_basic_info WHERE restaurant_state = '".$state."' AND restaurant_city = '".$city."' AND id != '".$res_id."' ORDER BY restaurant_name ASC");

$html = '<form name="submit_quote" id="submit_quote" action="#" method="post" class="form-horizontal">
                           <ul class="restu_list" id="all_res">';

								 $res_cnt = 1;
								 while($all_res_name = mysql_fetch_array($get_all_res))
								 {
								 $html.= '<li><span>'.$res_cnt.".".'</span><a href="javascript:void(0);" onClick="sel_res_id_func('.$all_res_name['id'].');">'.stripslashes($all_res_name['restaurant_name']).'</a></li>';
									 $res_cnt++;
								 }
							
							$html.='</ul>
							</form>';
							
echo $html;