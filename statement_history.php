<?php
session_start();
include ("admin/lib/conn.php");

$year = $_REQUEST['year'];
$statement = $_REQUEST['statement'];

function date_before_prev($date)
{
	//$date_new = date('Y-d-m', strtotime($date));
		
	$date_bef = date ('Y-m-d', strtotime ( '-7 day' . $date ) );
	
	return $date_bef;
}	

$html.='<table><tr><td>
  Statements Details &amp; History : 
 </td>
 <td>';

$html.='
<select name="statement" id="statement">
		  <option value="">---SELECT---</option>';
			if($year == date('Y'))
			{
				$prev_date = date('Y-m-d');
			}
			else
			{
				$prev_date = date($year.'-12-31');
			}
			
			
			for($i = 1;$i<=52;$i++){
				if($i==1)
				{
					$date = $prev_date;
				}
				else
				{
					$date = date('Y-m-d' ,strtotime("-1 day" .$prev_date)) ;
				}
				
				$prev_date = date_before_prev($date);
				
				$sql_statement_date = mysql_num_rows(mysql_query("SELECT order_id FROM restaurant_menu_order WHERE order_date >= '".$prev_date."' AND order_date <= '".$date."' AND restaurant_id = '".$_SESSION['restaurant']."'"));
				
				if($sql_statement_date > 1)
				{
					$order = "Orders";
				}
				else
				{
					$order = "Order";
				}
			  if($_REQUEST['statement'] == $date."^".$prev_date) {
				  $select = 'selected';
			  }else{
				  $select = '';
			  }
			  $html.='<option value="'.$date."^".$prev_date.'" '.$select.'  >'.date('m/d/Y', strtotime($prev_date))." - ".date('m/d/Y', strtotime($date))." : ".$sql_statement_date." ".$order.'</option>';
			}
		$html.='</select></td><td>';
		
		$html.='<input type="submit" name="submit" value="Search" class="button4" style="margin:0px;">
        <input type="hidden" name="hid_year" id="hid_year" value="'.$_REQUEST['year'].'" />
        <input type="hidden" name="hid_limit" id="hid_limit" value="10" />
        <input type="hidden" name="hid_num_rows" id="hid_num_rows" value="'.$sql_num_rows.'" />
        <input type="hidden" name="hid_search_date" id="hid_search_date" value="'.$_REQUEST['statement'].'" />
		</td></tr></table>';

echo $html;

?>